<?php
require_once "../../auth.php";
require_once "../../config/db.php";

header("Content-Type: application/json");

$userId = $_SESSION['user_id'] ?? null;
$id = $_POST['id'] ?? null;

if (!$userId || !$id) {
    echo json_encode(["success" => false, "error" => "Missing data"]);
    exit;
}

$sql = "DELETE FROM sticky_notes WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);

if ($stmt->execute([$id, $userId])) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => "Database error"]);
}