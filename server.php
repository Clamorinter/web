<?php
session_start();
require 'db.php';

if (!isset($_GET['id'])) {
  header('Location: products.php');
  exit;
}

$id = $_GET['id'];

$stmt = $pdo->prepare("
  SELECT vs.*, t.name AS tariff_name, t.month_price, 
         s.CPU_count, s.RAM, s.SSD, s.bandwidth, s.traffic_limit,
         dc.name AS dc_name, dc.city, dc.country
  FROM virtual_server vs
  JOIN tariff t ON vs.tariff_id = t.id
  JOIN specs s ON t.specs_id = s.id
  JOIN datacenter dc ON t.datacenter_id = dc.id
  WHERE vs.id = :id
");
$stmt->execute(['id' => $id]);
$server = $stmt->fetch();

if (!$server) {
  echo "<h1>Сервер не найден.</h1>";
  exit;
}
?>

<?php include 'header.php'; ?>

<main class="container py-5">
  <h1 class="mb-4"><?= htmlspecialchars($server['name']) ?></h1>
  <hr>
  <div class="row">
    <div class="col-md-6">
      <ul class="list-group">
        <li class="list-group-item"><strong>Тариф:</strong> <?= $server['tariff_name'] ?> — <?= $server['month_price'] ?> ₽/мес</li>
        <li class="list-group-item"><strong>CPU:</strong> <?= $server['CPU_count'] ?></li>
        <li class="list-group-item"><strong>RAM:</strong> <?= $server['RAM'] ?></li>
        <li class="list-group-item"><strong>SSD:</strong> <?= $server['SSD'] ?></li>
        <li class="list-group-item"><strong>Ширина канала:</strong> <?= $server['bandwidth'] ?></li>
        <li class="list-group-item"><strong>Лимит трафика:</strong> <?= $server['traffic_limit'] ?></li>
      </ul>
    </div>

    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Датацентр</h5>
          <p class="card-text">
            <strong><?= $server['dc_name'] ?></strong><br>
            <?= $server['city'] ?>, <?= $server['country'] ?>
          </p>
        </div>
      </div>
	  	<?php if (isset($_SESSION['user_id'])): ?>
	  <form action="add_to_cart.php" method="POST" class="mt-3">
		<input type="hidden" name="server_id" value="<?= $server['id'] ?>">
		<button type="submit" class="btn btn-success w-100">Добавить в корзину</button>
	  </form>
	<?php else: ?>
	  <button class="btn btn-outline-secondary w-100 mt-3" data-bs-toggle="modal" data-bs-target="#authModal">
		Добавить в корзину
	  </button>
	<?php endif; ?>
    </div>
	


  </div>
</main>
<!-- Модальное окно для авторизации -->
<div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow">
      <div class="modal-header">
        <h5 class="modal-title" id="authModalLabel">Требуется авторизация</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      </div>
      <div class="modal-body">
        Чтобы добавить сервер в корзину, необходимо войти в свой аккаунт.
      </div>
      <div class="modal-footer">
        <a href="login.php" class="btn btn-primary">Войти</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>



<?php include 'footer.php'; ?>
