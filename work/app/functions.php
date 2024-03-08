<?php 


function h($str){
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function createToken(){
  if(!isset($_SESSION['token'])){
    $_SESSION['token'] =bin2hex(random_bytes(32));
  }
}
function valideToken() {
  if(
    empty($_SESSION['token'])||
    $_SESSION['token']!== filter_input(INPUT_POST,'token')
  )
  exit('Invalid post request');
}
function getTodos($pdo) {
    $stmt = $pdo->query("SELECT * FROM todos ORDER BY id DESC");
    $todos = $stmt->fetchAll();
    return $todos;
  }

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  valideToken();
  addTodo($pdo);
  header ('Location:'.SITE_URL);
  exit;
}

$todos = getTodos($pdo);
// var_dump($todos);




function getPdoInstance() {
    
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
    exit();
  }
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