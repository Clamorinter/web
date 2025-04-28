<?php
require 'db.php';

$stmt = $pdo->query("
    SELECT n.id, n.title, n.created_at, u.name, u.surname
    FROM news n
    JOIN users u ON n.author_id = u.id
    ORDER BY n.created_at DESC
");
$newsList = $stmt->fetchAll();
include 'header.php';
?>

<main class="container py-4">
  <h1>Новости</h1>
  <div class="row g-4">
    <?php foreach ($newsList as $news): ?>
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($news['title']) ?></h5>
            <p class="card-text">
              <strong>Автор:</strong> <?= htmlspecialchars($news['surname']) . ' ' . htmlspecialchars($news['name']) ?><br>
              <strong>Дата:</strong> <?= date('d.m.Y', strtotime($news['created_at'])) ?>
            </p>
            <a href="news_item.php?id=<?= $news['id'] ?>" class="btn btn-primary">Читать полностью</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</main>

<?php include 'footer.php'; ?>
