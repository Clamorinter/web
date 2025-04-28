<?php
session_start();
require 'db.php';

// Получаем список компаний для выпадающего списка
$companiesStmt = $pdo->query("SELECT id, name FROM company");
$companies = $companiesStmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $surname = $_POST['surname'];
    $name = $_POST['name'];
    $patronymic = $_POST['patronymic'];
    $phonenumber = $_POST['phonenumber'];
    $email = $_POST['email'];
    $company_id = $_POST['company_id'];
    $password = $_POST['password'];

    // Проверка, не существует ли пользователь с таким email
    $checkStmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $checkStmt->execute([$email]);
    if ($checkStmt->rowCount() > 0) {
        $_SESSION['error'] = "Пользователь с таким email уже зарегистрирован.";
    } else {
        // Вставка нового пользователя
        $stmt = $pdo->prepare("INSERT INTO users (surname, name, patronymic, phonenumber, email, company_id, password)
                               VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$surname, $name, $patronymic, $phonenumber, $email, $company_id, $password]);
        $_SESSION['success'] = "Регистрация прошла успешно. Вы можете войти.";
        header("Location: login.php");
        exit;
    }
}
?>

<?php include 'header.php'; ?>

<main class="container py-5">
    <h1 class="mb-4">Регистрация</h1>
	
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['error']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрыть"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
	
	  <?php if (isset($_SESSION['success'])): ?>
	  <div class="alert alert-success alert-dismissible fade show" role="alert">
		<?= htmlspecialchars($_SESSION['success']) ?>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрыть"></button>
	  </div>
	  <?php unset($_SESSION['success']); ?>
	<?php endif; ?>

    <form method="POST" action="register.php">
        <div class="row g-3">
            <div class="col-md-4">
                <label for="surname" class="form-label">Фамилия</label>
                <input type="text" class="form-control" id="surname" name="surname" required>
            </div>
            <div class="col-md-4">
                <label for="name" class="form-label">Имя</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="col-md-4">
                <label for="patronymic" class="form-label">Отчество</label>
                <input type="text" class="form-control" id="patronymic" name="patronymic" required>
            </div>
        </div>

        <div class="row g-3 mt-3">
            <div class="col-md-6">
                <label for="phonenumber" class="form-label">Телефон</label>
                <input type="text" class="form-control" id="phonenumber" name="phonenumber"
				   pattern="\d{10}" maxlength="10" inputmode="numeric"
				   placeholder="Например: 9818001212" required>


            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">Электронная почта</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
        </div>

        <div class="row g-3 mt-3">
            <div class="col-md-6">
                <label for="company_id" class="form-label">Компания</label>
                <select class="form-select" id="company_id" name="company_id" required>
                    <option value="">Выберите компанию</option>
                    <?php foreach ($companies as $company): ?>
                        <option value="<?= $company['id'] ?>"><?= htmlspecialchars($company['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="password" class="form-label">Пароль</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
        </div>
    </form>
</main>

<?php include 'footer.php'; ?>
