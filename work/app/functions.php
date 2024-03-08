<?php

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

function getPdoInstance()
{
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

    return $pdo;
  } catch (PDOException $e) {
    echo $e->getMessage();
    exit;
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