<?php
session_start(); // Подключаем сессию
include 'header.php';
include 'db.php';
?>

<main class="container py-4">
  <h1 class="mb-4">Наши виртуальные серверы</h1>

  <!-- Форма фильтрации -->
  <form method="GET" class="row g-3 mb-4">
    <div class="col-md-3">
	  <label for="datacenter" class="form-label">Датацентр</label>
	  <select name="datacenter" id="datacenter" class="form-select">
		<option value="">Все</option>
		<?php
		  $dcs = $pdo->query("SELECT id, name, city FROM datacenter")->fetchAll();
		  foreach ($dcs as $dc) {
			$selected = ($_GET['datacenter'] ?? '') == $dc['id'] ? 'selected' : '';
			echo "<option value='{$dc['id']}' $selected>{$dc['name']} ({$dc['city']})</option>";
		  }
		?>
	  </select>
	</div>


    <div class="col-md-3">
      <label for="cpu" class="form-label">CPU</label>
      <select name="cpu" id="cpu" class="form-select">
        <option value="">Все</option>
        <?php
          $cpus = $pdo->query("SELECT DISTINCT CPU_count FROM specs")->fetchAll();
          foreach ($cpus as $cpu) {
            $selected = ($_GET['cpu'] ?? '') == $cpu['CPU_count'] ? 'selected' : '';
            echo "<option value='{$cpu['CPU_count']}' $selected>{$cpu['CPU_count']}</option>";
          }
        ?>
      </select>
    </div>

    <div class="col-md-3">
      <label for="ram" class="form-label">RAM</label>
      <select name="ram" id="ram" class="form-select">
        <option value="">Все</option>
        <?php
          $rams = $pdo->query("SELECT DISTINCT RAM FROM specs")->fetchAll();
          foreach ($rams as $ram) {
            $selected = ($_GET['ram'] ?? '') == $ram['RAM'] ? 'selected' : '';
            echo "<option value='{$ram['RAM']}' $selected>{$ram['RAM']}</option>";
          }
        ?>
      </select>
    </div>

    <div class="col-md-3 d-flex align-items-end">
      <button type="submit" class="btn btn-primary w-100">Фильтровать</button>
    </div>
  </form>

  <!-- Отображение продуктов -->
  <div class="row g-4">
    <?php
		$query = "
		  SELECT vs.*, t.name AS tariff_name, t.month_price, s.CPU_count, s.RAM, s.SSD, s.bandwidth
		  FROM virtual_server vs
		  JOIN tariff t ON vs.tariff_id = t.id
		  JOIN specs s ON t.specs_id = s.id
		  JOIN datacenter dc ON t.datacenter_id = dc.id
		  JOIN server_statuses ss ON vs.status_id = ss.id
		  WHERE vs.status_id = 1
		";

		$params = [];

		if (!empty($_GET['datacenter'])) {
		  $query .= " AND dc.id = :datacenter";
		  $params['datacenter'] = $_GET['datacenter'];
		}

		if (!empty($_GET['cpu'])) {
		  $query .= " AND s.CPU_count = :cpu";
		  $params['cpu'] = $_GET['cpu'];
		}

		if (!empty($_GET['ram'])) {
		  $query .= " AND s.RAM = :ram";
		  $params['ram'] = $_GET['ram'];
		}


      $stmt = $pdo->prepare($query);
      $stmt->execute($params);
      $servers = $stmt->fetchAll();

      foreach ($servers as $server) {
        echo "
        <div class='col-md-4'>
          <div class='card shadow-sm border-0 h-100'>
            <div class='card-body d-flex flex-column'>
              <h5 class='card-title'>{$server['name']}</h5>
			  <hr>
              <p class='card-text'>
                <strong>CPU:</strong> {$server['CPU_count']}<br>
                <strong>RAM:</strong> {$server['RAM']}<br>
                <strong>SSD:</strong> {$server['SSD']}<br>
                <strong>Тариф:</strong> {$server['tariff_name']}<br>
                <strong>Цена:</strong> {$server['month_price']} ₽/мес
              </p>
              <div class='mt-auto'>
                <a href='server.php?id={$server['id']}' class='btn btn-outline-primary w-100'>Подробнее</a>
              </div>
            </div>
          </div>
        </div>";
      }

      if (count($servers) === 0) {
        echo "<p>Серверов по заданным фильтрам не найдено.</p>";
      }
    ?>
  </div>
</main>

<?php include 'footer.php'; ?>
