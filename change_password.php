<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];

    // Получаем текущий пароль пользователя
    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    if (!$user) {
        $_SESSION['success'] = "Пользователь не найден.";
        header("Location: account.php");
        exit;
    }

    if ($oldPassword !== $user['password']) {
        $_SESSION['success'] = "Старый пароль введён неверно.";
        header("Location: account.php");
        exit;
    }

    // Обновляем пароль
    $updateStmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
    $updateStmt->execute([$newPassword, $user_id]);

    $_SESSION['success'] = "Пароль успешно обновлён.";
    header("Location: account.php");
    exit;
}
?>
