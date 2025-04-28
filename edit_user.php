<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Получаем информацию о пользователе
$userStmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$userStmt->execute([$user_id]);
$user = $userStmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $patronymic = $_POST['patronymic'];
    $email = $_POST['email'];

    // Обновляем данные пользователя в базе
    $updateStmt = $pdo->prepare("UPDATE users SET name = ?, surname = ?, patronymic = ?, email = ? WHERE id = ?");
    $updateStmt->execute([$name, $surname, $patronymic, $email, $user_id]);

    // Перенаправляем обратно с уведомлением
    $_SESSION['success'] = "Данные успешно обновлены!";
    header('Location: account.php');
    exit;
}
?>

<?php include 'header.php'; ?>

<main class="container py-4">
    <h1>Редактирование данных пользователя</h1>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['success']) ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <form action="edit_user.php" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Имя</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="surname" class="form-label">Фамилия</label>
            <input type="text" class="form-control" id="surname" name="surname" value="<?= htmlspecialchars($user['surname']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="patronymic" class="form-label">Отчество</label>
            <input type="text" class="form-control" id="patronymic" name="patronymic" value="<?= htmlspecialchars($user['patronymic']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
    </form>
</main>

<?php include 'footer.php'; ?>
