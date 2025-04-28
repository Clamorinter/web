<?php
session_start();
require 'db.php';
include 'header.php';

// Если пользователь уже авторизован, перенаправляем его на главную страницу
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Проверка, что поля не пустые
    if (empty($email) || empty($password)) {
        $error = 'Пожалуйста, заполните все поля.';
    } else {
        // Проверка данных пользователя
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && $password === $user['password']) {
            // Если пользователь найден и пароль правильный
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: index.php"); // Перенаправление на главную страницу
            exit;
        } else {
            $error = 'Неверный email или пароль.';
        }
    }
}
?>

<main class="container py-4">
  <h1 class="mb-4">Авторизация</h1>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  
    <?php if (isset($_SESSION['success'])): ?>
	  <div class="alert alert-success alert-dismissible fade show" role="alert">
		<?= htmlspecialchars($_SESSION['success']) ?>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрыть"></button>
	  </div>
	  <?php unset($_SESSION['success']); ?>
	<?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label for="email" class="form-label">Электронная почта</label>
      <input type="email" name="email" id="email" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Пароль</label>
      <input type="password" name="password" id="password" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Войти</button>
  </form>

  <div class="mt-3">
    <p>Нет аккаунта? <a href="register.php">Зарегистрироваться</a></p>
  </div>
</main>