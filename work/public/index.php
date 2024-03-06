<?php 
define('DSN','mysql:host=db;dbname=myapp;charset=utf8mb4');
define('DB_USER','myappuser');
define('DB_PASS','myapppass');
define ('SITE_URL','https://'.$_SERVER['HTTP_HOST']);

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
}catch (PDOException $e) {
  echo "PDOException: " . $e->getMessage();
  // exit();
}

function getTodos($pdo) {
  $stmt = $pdo->query("SELECT * FROM todos ORDER BY id DESC");
  $todos = $stmt->fetchAll();
  return $todos;
}
function addTodo($pdo){
  $title  = trim(filter_input(INPUT_POST, 'title'));
  if ($title === ''){
    return ;
  }
  $stmt = $pdo ->prepare("INSERT INTO todos (title) VALUES (:title)");
  $stmt ->bindValue(':title', $title,PDO::PARAM_STR);
  $stmt ->execute();
}

function h($str){
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  addTodo($pdo);
  header ('Location:'.SITE_URL);
  exit;
}

$todos = getTodos($pdo);
// var_dump($todos);

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
    <input type="text" name='title' placeholder="Type new todo." >
  </form>

  <ul>
    <?php  foreach ($todos as  $todo):   ?>
      <li>
      <input type="checkbox" <?= $todo -> is_done ? 'checked':'' ?>>
      <span class="<?= $todo -> is_done ? 'checked':'' ?>">
        <?= h($todo->title);  ?>
      </span>
    </li>
    <?php  endforeach;   ?>
  </ul>
</body>
</html>