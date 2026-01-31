<?php
require_once "../../auth.php";
require_once "../../config/db.php";

$userId = $_SESSION['user_id'];

$sql = "SELECT * FROM sticky_notes WHERE user_id = ? ORDER BY id DESC";
$stmt = $conn->prepare($sql);
$stmt->execute([$userId]);

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data);