<?php

require_once(__DIR__ . '/../app/config.php');

createToken();

try {
  $pdo = new PDO(
    DSN,
    DB_USER,
    DB_PASS,
    [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
      PDO::ATTR_EMULATE_PREPARES => false,
    ]
  );
} catch (PDOException $e) {
  echo $e->getMessage();
  exit;
}

function h($str)
{
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function createToken()
{
  if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
  }
}

function validateToken()
{
  if (
    empty($_SESSION['token']) ||
    $_SESSION['token'] !== filter_input(INPUT_POST, 'token')
  ) {
    exit('Invalid post request');
  }
}

function addTodo($pdo)
{
  $title = trim(filter_input(INPUT_POST, 'title'));
  if ($title === '') {
    return;
  }

  $stmt = $pdo->prepare("INSERT INTO todos (title) VALUES (:title)");
  $stmt->bindValue('title', $title, PDO::PARAM_STR);
  $stmt->execute();
}

function getTodos($pdo)
{
  $stmt = $pdo->query("SELECT * FROM todos ORDER BY id DESC");
  $todos = $stmt->fetchAll();
  return $todos;
}

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