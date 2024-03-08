<?php 

session_start();

define('DSN', 'mysql:host=db;dbname=myapp;charset=utf8mb4');
define('DB_USER', 'myappuser');
define('DB_PASS', 'myapppass');
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);


spl_autoload_register(function ($class){
    $fileName = sprintf(__DIR__.'/%s.php',$class);
    if (file_exists($fileName)) {
        # code...
        require($fileName);
    }else{
        echo 'File not found; '.$fileName;
        exit;
    }


});
