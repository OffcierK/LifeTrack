<?php
require_once "../../auth.php";
require_once "../../config/db.php";

$userId = $_SESSION['user_id'];
$id = $_POST['id'] ?? null;
$content = $_POST['content'] ?? '';
$pos_x = $_POST['pos_x'] ?? null;
$pos_y = $_POST['pos_y'] ?? null;

if (!$id) {
    echo json_encode(["success" => false]);
    exit;
}

$sql = "UPDATE sticky_notes SET content = ?, pos_x = ?, pos_y = ? 
        WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);

if ($stmt->execute([$content, $pos_x, $pos_y, $id, $userId])) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false]);
}