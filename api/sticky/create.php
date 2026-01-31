<?php
require_once "../../auth.php";
require_once "../../config/db.php";

$userId = $_SESSION['user_id'] ?? null;
$content = $_POST['content'] ?? '';
$pos_x = $_POST['pos_x'] ?? 150;
$pos_y = $_POST['pos_y'] ?? 120;
$color = $_POST['color'] ?? 'yellow'; // Get color from POST or default to yellow

// Validate color (security)
$allowedColors = ['yellow', 'pink', 'blue', 'green', 'purple'];
if (!in_array($color, $allowedColors)) {
    $color = 'yellow';
}

if (!$userId) {
    echo json_encode(["success" => false]);
    exit;
}

// Allow empty content - user can fill it in later
$sql = "INSERT INTO sticky_notes (user_id, content, color, pos_x, pos_y)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$ok = $stmt->execute([$userId, $content, $color, $pos_x, $pos_y]);

echo json_encode(["success" => $ok]);