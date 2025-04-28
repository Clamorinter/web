<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['server_id'])) {
  $userId = $_SESSION['user_id'];
  $serverId = intval($_POST['server_id']);

  // Проверка: уже есть такой сервер в корзине?
  $checkStmt = $pdo->prepare("SELECT 1 FROM cart WHERE user_id = :user_id AND server_id = :server_id");
  $checkStmt->execute([
    'user_id' => $userId,
    'server_id' => $serverId
  ]);

  if ($checkStmt->fetch()) {
    // Уже есть — перенаправляем с уведомлением
    header("Location: cart.php?exists=1");
    exit;
  }

  // Иначе — добавляем в корзину
  $insertStmt = $pdo->prepare("INSERT INTO cart (user_id, server_id) VALUES (:user_id, :server_id)");
  $insertStmt->execute([
    'user_id' => $userId,
    'server_id' => $serverId
  ]);

  header("Location: cart.php?added=1");
  exit;
}
?>
