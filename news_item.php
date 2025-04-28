<?php
require 'db.php';

if (!isset($_GET['id'])) {
    header('Location: news.php');
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("
    SELECT n.*, u.name, u.surname
    FROM news n
    JOIN users u ON n.author_id = u.id
    WHERE n.id = ?
");
$stmt->execute([$id]);
$news = $stmt->fetch();

if (!$news) {
    echo "Новость не найдена.";
    exit;
}


include 'header.php';
?>

<main class="container py-4">
  <h1><?= htmlspecialchars($news['title']) ?></h1>
  <p><strong>Автор:</strong> <?= htmlspecialchars($news['surname']) . ' ' . htmlspecialchars($news['name']) ?></p>
  <p><strong>Дата:</strong> <?= date('d.m.Y', strtotime($news['created_at'])) ?></p>
  
  <div class="news-content">
	  <?= $news['content'] ?>
	</div>

</main>

<?php include 'footer.php'; ?>
