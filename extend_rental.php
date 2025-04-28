<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

$user_id = $_SESSION['user_id'];
$server_id = $_POST['server_id'];

// Получаем текущую дату окончания аренды
$stmt = $pdo->prepare("SELECT expires_at FROM server_user WHERE user_id = ? AND server_id = ?");
$stmt->execute([$user_id, $server_id]);
$server = $stmt->fetch();

if ($server) {
  // Продление аренды на месяц
  $newExpireDate = date('Y-m-d', strtotime($server['expires_at'] . ' +1 month'));
  $updateStmt = $pdo->prepare("UPDATE server_user SET expires_at = ? WHERE user_id = ? AND server_id = ?");
  $updateStmt->execute([$newExpireDate, $user_id, $server_id]);

  $_SESSION['success'] = "Аренда продлена на месяц!";
} else {
  $_SESSION['error'] = "Сервер не найден в вашей аренде.";
}

header('Location: account.php');
exit;
