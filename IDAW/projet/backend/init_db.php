<?php
require_once('config.php');
$connectionString = "mysql:host=". _MYSQL_HOST;
if(defined('_MYSQL_PORT'))
$connectionString .= ";port=". _MYSQL_PORT;
$connectionString .= ";dbname=" . _MYSQL_DBNAME;
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' );
$info = new PDO("mysql:host="._MYSQL_HOST.";port=". _MYSQL_PORT.";dbname=information_schema",_MYSQL_USER,_MYSQL_PASSWORD,$options);
$drop =$info->prepare("SELECT table_name FROM tables WHERE table_schema =". _MYSQL_DBNAME);
$drop->execute();
$tables = $drop->fetchAll();
try {
$pdo = new PDO($connectionString,_MYSQL_USER,_MYSQL_PASSWORD,$options);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $erreur) {
//myLog('Erreur : '.$erreur->getMessage());
}
foreach($tables as $table){
    $delete= "DROP TABLE"." ".$table[0];
    $pdo->prepare($delete)->execute();
}
$sql = file_get_contents('sql/idaw.sql');
$pdo->exec($sql);

?>