<?php
/**
 * LifeTrack - Tasks API
 * Handles all task operations: create, read, update, delete, toggle
 */

header('Content-Type: application/json');
require_once '../../config/db.php';

// Get action from request
$action = $_POST['action'] ?? $_GET['action'] ?? '';

// Response helper function
function sendResponse($success, $message, $data = null) {
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

// Database connection
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    sendResponse(false, "Database connection failed: " . $e->getMessage());
}

// ==================== ACTIONS ====================

switch ($action) {
    
    // ========== CREATE TASK ==========
    case 'create':
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $due_date = $_POST['due_date'] ?? null;
        $due_time = $_POST['due_time'] ?? null;
        $priority = $_POST['priority'] ?? 'medium';
        $category = $_POST['category'] ?? 'personal';
        
        if (empty($title)) {
            sendResponse(false, "Task title is required");
        }
        
        try {
            $sql = "INSERT INTO tasks (title, description, due_date, due_time, priority, category) 
                    VALUES (:title, :description, :due_date, :due_time, :priority, :category)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':title' => $title,
                ':description' => $description,
                ':due_date' => $due_date,
                ':due_time' => $due_time,
                ':priority' => $priority,
                ':category' => $category
            ]);
            
            $taskId = $pdo->lastInsertId();
            sendResponse(true, "Task created successfully", ['id' => $taskId]);
        } catch (PDOException $e) {
            sendResponse(false, "Failed to create task: " . $e->getMessage());
        }
        break;
    
    // ========== GET TASKS ==========
    case 'list':
        $filter = $_GET['filter'] ?? 'all'; // all, today, upcoming, completed
        $category = $_GET['category'] ?? null;
        
        try {
            $sql = "SELECT * FROM tasks WHERE 1=1";
            $params = [];
            
            // Filter by date
            if ($filter === 'today') {
                $sql .= " AND DATE(due_date) = CURDATE()";
            } elseif ($filter === 'upcoming') {
                $sql .= " AND due_date > CURDATE()";
            } elseif ($filter === 'overdue') {
                $sql .= " AND due_date < CURDATE() AND completed = 0";
            } elseif ($filter === 'completed') {
                $sql .= " AND completed = 1";
            }
            
            // Filter by category
            if ($category) {
                $sql .= " AND category = :category";
                $params[':category'] = $category;
            }
            
            $sql .= " ORDER BY 
                      CASE priority 
                          WHEN 'high' THEN 1 
                          WHEN 'medium' THEN 2 
                          WHEN 'low' THEN 3 
                      END,
                      due_date ASC, 
                      due_time ASC";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            sendResponse(true, "Tasks retrieved successfully", $tasks);
        } catch (PDOException $e) {
            sendResponse(false, "Failed to retrieve tasks: " . $e->getMessage());
        }
        break;
    
    // ========== UPDATE TASK ==========
    case 'update':
        $id = $_POST['id'] ?? null;
        
        if (!$id) {
            sendResponse(false, "Task ID is required");
        }
        
        try {
            // Build dynamic update query
            $updates = [];
            $params = [':id' => $id];
            
            if (isset($_POST['title'])) {
                $updates[] = "title = :title";
                $params[':title'] = trim($_POST['title']);
            }
            if (isset($_POST['description'])) {
                $updates[] = "description = :description";
                $params[':description'] = trim($_POST['description']);
            }
            if (isset($_POST['due_date'])) {
                $updates[] = "due_date = :due_date";
                $params[':due_date'] = $_POST['due_date'];
            }
            if (isset($_POST['due_time'])) {
                $updates[] = "due_time = :due_time";
                $params[':due_time'] = $_POST['due_time'];
            }
            if (isset($_POST['priority'])) {
                $updates[] = "priority = :priority";
                $params[':priority'] = $_POST['priority'];
            }
            if (isset($_POST['category'])) {
                $updates[] = "category = :category";
                $params[':category'] = $_POST['category'];
            }
            if (isset($_POST['completed'])) {
                $updates[] = "completed = :completed";
                $params[':completed'] = $_POST['completed'];
            }
            
            if (empty($updates)) {
                sendResponse(false, "No fields to update");
            }
            
            $sql = "UPDATE tasks SET " . implode(", ", $updates) . " WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            
            sendResponse(true, "Task updated successfully");
        } catch (PDOException $e) {
            sendResponse(false, "Failed to update task: " . $e->getMessage());
        }
        break;
    
    // ========== TOGGLE COMPLETE ==========
    case 'toggle':
        $id = $_POST['id'] ?? null;
        
        if (!$id) {
            sendResponse(false, "Task ID is required");
        }
        
        try {
            // Toggle completed status
            $sql = "UPDATE tasks SET completed = NOT completed WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            // Get new status
            $sql = "SELECT completed FROM tasks WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            $task = $stmt->fetch(PDO::FETCH_ASSOC);
            
            sendResponse(true, "Task status toggled", ['completed' => $task['completed']]);
        } catch (PDOException $e) {
            sendResponse(false, "Failed to toggle task: " . $e->getMessage());
        }
        break;
    
    // ========== DELETE TASK ==========
    case 'delete':
        $id = $_POST['id'] ?? $_GET['id'] ?? null;
        
        if (!$id) {
            sendResponse(false, "Task ID is required");
        }
        
        try {
            $sql = "DELETE FROM tasks WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            if ($stmt->rowCount() > 0) {
                sendResponse(true, "Task deleted successfully");
            } else {
                sendResponse(false, "Task not found");
            }
        } catch (PDOException $e) {
            sendResponse(false, "Failed to delete task: " . $e->getMessage());
        }
        break;
    
    // ========== GET SINGLE TASK ==========
    case 'get':
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            sendResponse(false, "Task ID is required");
        }
        
        try {
            $sql = "SELECT * FROM tasks WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            $task = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($task) {
                sendResponse(true, "Task retrieved successfully", $task);
            } else {
                sendResponse(false, "Task not found");
            }
        } catch (PDOException $e) {
            sendResponse(false, "Failed to retrieve task: " . $e->getMessage());
        }
        break;
    
    // ========== GET STATISTICS ==========
    case 'stats':
        try {
            $stats = [];
            
            // Total tasks
            $sql = "SELECT COUNT(*) as total FROM tasks";
            $stats['total'] = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC)['total'];
            
            // Completed tasks
            $sql = "SELECT COUNT(*) as completed FROM tasks WHERE completed = 1";
            $stats['completed'] = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC)['completed'];
            
            // Today's tasks
            $sql = "SELECT COUNT(*) as today FROM tasks WHERE DATE(due_date) = CURDATE()";
            $stats['today'] = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC)['today'];
            
            // Overdue tasks
            $sql = "SELECT COUNT(*) as overdue FROM tasks WHERE due_date < CURDATE() AND completed = 0";
            $stats['overdue'] = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC)['overdue'];
            
            // Completion rate
            $stats['completion_rate'] = $stats['total'] > 0 
                ? round(($stats['completed'] / $stats['total']) * 100, 1) 
                : 0;
            
            sendResponse(true, "Statistics retrieved successfully", $stats);
        } catch (PDOException $e) {
            sendResponse(false, "Failed to retrieve statistics: " . $e->getMessage());
        }
        break;
    
    // ========== INVALID ACTION ==========
    default:
        sendResponse(false, "Invalid action specified");
}
?>