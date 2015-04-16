<?php

$db = new PDO('mysql:dbname=sakila;host=127.0.0.1', 'root', 'password');

// User input

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = isset($_GET['per-page']) && $_GET['per-page'] <= 50 ? (int)$_GET['per-page'] : 5;

// Positioning
$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

// Query
$articles = $db->prepare("
    SELECT SQL_CALC_FOUND_ROWS film_id, title
    FROM film
    LIMIT {$start}, {$perPage}
");

$articles->execute();
$articles = $articles->fetchAll(PDO::FETCH_ASSOC);

// Pages
$total = $db->query("SELECT FOUND_ROWS() as total")->fetch()['total'];

$pages = ceil($total / $perPage);

echo $start;
echo $perPage;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <?php foreach($articles as $article): ?>
        <div class="article">
            <p><?php echo $article['film_id']; ?>: <?php echo $article['title'] ; ?></p>
        </div>
    <?php endforeach; ?>

    <div class="pagination">
        <?php for($x =1; $x <= $pages; $x++): ?>
            <a href="?page=<?php echo $x; ?>&per-page=<?php echo $perPage; ?>"<?php if($page === $x) { echo ' class="selected"'; } ?>><?php echo $x; ?></a>
        <?php endfor; ?>
    </div>
</body>
</html>