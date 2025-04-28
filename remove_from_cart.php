<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['server_id'])) {
  $user_id = $_SESSION['user_id'];
  $server_id = $_POST['server_id'];

  $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ? AND server_id = ?");
  $stmt->execute([$user_id, $server_id]);

  header('Location: cart.php?message=Сервер удалён из корзины');
  exit;
}

header('Location: cart.php');
