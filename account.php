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

// Получаем арендованные серверы с полными данными
$serversStmt = $pdo->prepare("
  SELECT vs.*, t.name AS tariff_name, t.month_price, s.CPU_count, s.RAM, s.SSD, s.bandwidth, 
         dc.name AS datacenter_name, dc.city AS datacenter_city, ss.name AS status_name,
         su.rented_at, su.expires_at
  FROM server_user su
  JOIN virtual_server vs ON su.server_id = vs.id
  JOIN tariff t ON vs.tariff_id = t.id
  JOIN specs s ON t.specs_id = s.id
  JOIN datacenter dc ON t.datacenter_id = dc.id
  JOIN server_statuses ss ON vs.status_id = ss.id
  WHERE su.user_id = ?
");
$serversStmt->execute([$user_id]);
$servers = $serversStmt->fetchAll();
?>

<?php include 'header.php'; ?>

<main class="container py-4">
  <h1>Личный кабинет</h1>
  <hr>
  <?php if (isset($_SESSION['success'])): ?>
	  <div class="alert alert-success alert-dismissible fade show" role="alert">
		<?= htmlspecialchars($_SESSION['success']) ?>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрыть"></button>
	  </div>
	  <?php unset($_SESSION['success']); ?>
	<?php endif; ?>

	<!-- Информация о пользователе -->
	<section class="mb-4">
	  <h2>Информация о пользователе</h2>
	  <p><strong>Имя:</strong> <?= htmlspecialchars($user['name']) ?></p>
	  <p><strong>Фамилия:</strong> <?= htmlspecialchars($user['surname']) ?></p>
	  <p><strong>Отчество:</strong> <?= htmlspecialchars($user['patronymic']) ?></p>
	  <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
	  <div class="d-flex gap-2">
		<form action="edit_user.php" method="GET">
		  <button type="submit" class="btn btn-primary">Редактировать данные</button>
		</form>
		<form action="logout.php" method="POST">
		  <button type="submit" class="btn btn-outline-danger">Выйти из аккаунта</button>
		</form>
	  </div>
	</section>


  <!-- Смена пароля -->
  <section class="mb-4">
    <h2>Смена пароля</h2>
    <form action="change_password.php" method="POST">
      <div class="mb-3">
        <label for="old_password" class="form-label">Старый пароль</label>
        <input type="password" class="form-control" id="old_password" name="old_password" required>
      </div>
      <div class="mb-3">
        <label for="new_password" class="form-label">Новый пароль</label>
        <input type="password" class="form-control" id="new_password" name="new_password" required>
      </div>
      <button type="submit" class="btn btn-primary">Сменить пароль</button>
    </form>
  </section>

  <!-- Арендованные серверы -->
  <section>
    <h2>Арендованные серверы</h2>
    <?php if (count($servers) > 0): ?>
      <div class="row g-4">
        <?php foreach ($servers as $server): ?>
          <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
              <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($server['name']) ?></h5>
                <p class="card-text">
                  <strong>ЦОД:</strong> <?= htmlspecialchars($server['datacenter_name']) ?> (<?= htmlspecialchars($server['datacenter_city']) ?>)<br>
                  <strong>Тариф:</strong> <?= htmlspecialchars($server['tariff_name']) ?><br>
                  <strong>CPU:</strong> <?= htmlspecialchars($server['CPU_count']) ?><br>
                  <strong>RAM:</strong> <?= htmlspecialchars($server['RAM']) ?><br>
                  <strong>SSD:</strong> <?= htmlspecialchars($server['SSD']) ?><br>
				  <strong>IP-адрес:</strong> <?= htmlspecialchars($server['ip_address']) ?><br>
                  <strong>Пропускная способность:</strong> <?= htmlspecialchars($server['bandwidth']) ?><br>
                  <strong>Статус:</strong> <?= htmlspecialchars($server['status_name']) ?><br>
                  <strong>Цена:</strong> <?= htmlspecialchars($server['month_price']) ?> ₽/мес<br>
                  <strong>Дата аренды:</strong> <?= date('d.m.Y', strtotime($server['rented_at'])) ?><br>
                  <strong>Окончание аренды:</strong> <?= date('d.m.Y', strtotime($server['expires_at'])) ?>
                </p>
                <form action="extend_rental.php" method="POST" class="d-inline">
                  <input type="hidden" name="server_id" value="<?= $server['id'] ?>">
                  <button type="submit" class="btn btn-success btn-sm">Продлить аренду</button>
                </form>
                <form action="cancel_rental.php" method="POST" class="d-inline">
                  <input type="hidden" name="server_id" value="<?= $server['id'] ?>">
                  <button type="submit" class="btn btn-danger btn-sm">Отменить аренду</button>
                </form>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p>У вас нет арендованных серверов.</p>
    <?php endif; ?>
  </section>
</main>

<?php include 'footer.php'; ?>
