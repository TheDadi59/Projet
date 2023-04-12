<?php
 require_once('config.php');

 $connectionString = "mysql:host=". _MYSQL_HOST;
if(defined('_MYSQL_PORT'))
$connectionString .= ";port=". _MYSQL_PORT;
$connectionString .= ";dbname=" . _MYSQL_DBNAME;
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' );
try {
$pdo = new PDO($connectionString,_MYSQL_USER,_MYSQL_PASSWORD,$options);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $erreur) {
//myLog('Erreur : '.$erreur->getMessage());
}
 $name =  $_POST['name'];
$email = $_POST['email'];
$id = $_GET['id'];
 // Performing insert query execution
 // here our table name is college
 $sql = "UPDATE users
 SET name = '$name',
   email = '$email'
  
 WHERE id =$id";

 $pdo->prepare($sql)->execute();


  header('Location: user.php');

  exit();
?>