<?php

require_once(__DIR__ . '/../app/config.php');

createToken();

$pdo = getPdoInstance();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  validateToken();
  addTodo($pdo);

  header('Location: ' . SITE_URL);
  exit;
}

$todos = getTodos($pdo);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>My Todos</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <h1>Todos</h1>

  <form action="" method="post">
    <input type="text" name="title" placeholder="Type new todo.">
    <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
  </form>

  <ul>
    <?php foreach ($todos as $todo): ?>
    <li>
      <input type="checkbox" <?= $todo->is_done ? 'checked' : ''; ?>>
      <span class="<?= $todo->is_done ? 'done' : ''; ?>">
        <?= h($todo->title); ?>
      </span>
    </li>
    <?php endforeach; ?>
  </ul>
</body>
</html>