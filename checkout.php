<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

$user_id = $_SESSION['user_id'];

// Получаем все серверы в корзине пользователя
$stmt = $pdo->prepare("SELECT server_id FROM cart WHERE user_id = ?");
$stmt->execute([$user_id]);
$servers = $stmt->fetchAll(PDO::FETCH_COLUMN);

if (count($servers) > 0) {
  // Создаем заказ
  $orderStmt = $pdo->prepare("INSERT INTO orders (user_id, order_date, status) VALUES (?, NOW(), 'Аренда оформлена')");
  $orderStmt->execute([$user_id]);
  $order_id = $pdo->lastInsertId();

  // Подготовка выражений
  $itemStmt = $pdo->prepare("INSERT INTO order_items (order_id, server_id) VALUES (?, ?)");
  $updateStatusStmt = $pdo->prepare("UPDATE virtual_server SET status_id = 2 WHERE id = ?");
  $serverUserStmt = $pdo->prepare("INSERT INTO server_user (server_id, user_id, rented_at, expires_at) VALUES (?, ?, NOW(), DATE_ADD(NOW(), INTERVAL 1 MONTH))");

  foreach ($servers as $server_id) {
    // Добавляем в order_items
    $itemStmt->execute([$order_id, $server_id]);

    // Обновляем статус сервера на "Арендуется"
    $updateStatusStmt->execute([$server_id]);

    // Добавляем запись в server_user
    $serverUserStmt->execute([$server_id, $user_id]);
  }

  // Очищаем корзину
  $deleteStmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
  $deleteStmt->execute([$user_id]);

  $_SESSION['success'] = "Аренда успешно оформлена!";
} else {
  $_SESSION['error'] = "Корзина пуста.";
}

header('Location: cart.php');
exit;
?>
