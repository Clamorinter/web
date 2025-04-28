<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

$user_id = $_SESSION['user_id'];
$server_id = $_POST['server_id'];

// Удаляем запись об аренде
$stmt = $pdo->prepare("DELETE FROM server_user WHERE user_id = ? AND server_id = ?");
$stmt->execute([$user_id, $server_id]);

// Обновляем статус сервера на "Свободен"
$updateStatusStmt = $pdo->prepare("UPDATE virtual_server SET status_id = 1 WHERE id = ?");
$updateStatusStmt->execute([$server_id]);

$_SESSION['success'] = "Аренда отменена!";
header('Location: account.php');
exit;
