<?php
include 'header.php';
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

$user_id = $_SESSION['user_id'];

// Получение серверов из корзины пользователя
$stmt = $pdo->prepare("
  SELECT vs.*, t.name AS tariff_name, t.month_price, s.CPU_count, s.RAM, s.SSD, dc.name AS datacenter_name, dc.city
  FROM cart c
  JOIN virtual_server vs ON c.server_id = vs.id
  JOIN tariff t ON vs.tariff_id = t.id
  JOIN specs s ON t.specs_id = s.id
  JOIN datacenter dc ON t.datacenter_id = dc.id
  WHERE c.user_id = ?
");
$stmt->execute([$user_id]);
$cartItems = $stmt->fetchAll();
?>




<main class="container py-4">
  <h1 class="mb-4">Корзина</h1>
  
	  <?php if (isset($_SESSION['success'])): ?>
	  <div class="alert alert-success fade show notification" role="alert">
		<?= htmlspecialchars($_SESSION['success']) ?>
	  </div>
	  <?php unset($_SESSION['success']); ?>
	<?php endif; ?>

	<?php if (isset($_SESSION['error'])): ?>
	  <div class="alert alert-danger fade show notification" role="alert">
		<?= htmlspecialchars($_SESSION['error']) ?>
	  </div>
	  <?php unset($_SESSION['error']); ?>
	<?php endif; ?>

  <?php if (isset($_GET['notification'])): ?>
    <div class="alert alert-success fade show notification" role="alert">
      <?= htmlspecialchars($_GET['notification']) ?>
    </div>
  <?php endif; ?>

  <?php if (count($cartItems) > 0): ?>
    <div class="row g-4 mb-4">
      <?php foreach ($cartItems as $server): ?>
        <div class="col-md-4">
          <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($server['name']) ?></h5>
              <p class="card-text">
                <strong>ЦОД:</strong> <?= htmlspecialchars($server['datacenter_name']) ?> (<?= htmlspecialchars($server['city']) ?>)<br>
                <strong>Тариф:</strong> <?= htmlspecialchars($server['tariff_name']) ?><br>
                <strong>CPU:</strong> <?= htmlspecialchars($server['CPU_count']) ?><br>
                <strong>RAM:</strong> <?= htmlspecialchars($server['RAM']) ?><br>
                <strong>SSD:</strong> <?= htmlspecialchars($server['SSD']) ?><br>
                <strong>Цена:</strong> <?= $server['month_price'] ?> ₽/мес
              </p>
              <form action="remove_from_cart.php" method="POST" class="text-end">
                <input type="hidden" name="server_id" value="<?= $server['id'] ?>">
                <button type="submit" class="btn btn-sm btn-outline-danger">Удалить</button>
              </form>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <form action="checkout.php" method="POST" class="text-center mt-4">
      <button type="submit" class="btn btn-success btn-lg">Оформить аренду серверов</button>
    </form>
  <?php else: ?>
    <p>Ваша корзина пуста.</p>
  <?php endif; ?>
  

</main>

<script>
  setTimeout(() => {
    const notification = document.querySelector('.notification');
    if (notification) notification.remove();
  }, 5000);
</script>

