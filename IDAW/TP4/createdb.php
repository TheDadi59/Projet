<?php
require_once('config.php');
$pdo = new PDO('mysql:host='._MYSQL_HOST, _MYSQL_USER, _MYSQL_PASSWORD);
$requete = "CREATE DATABASE IF NOT EXISTS `"._MYSQL_DBNAME."` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
$pdo->prepare($requete)->execute();

$connexion = new PDO("mysql:host="._MYSQL_HOST.";dbname="._MYSQL_DBNAME, _MYSQL_USER, _MYSQL_PASSWORD);
if($connexion){ 
    $drop =$pdo->prepare("SELECT table_name
    FROM information_schema.tables
    WHERE table_schema ="._MYSQL_DBNAME."");
    $drop->execute();

    $tables = $drop->fetchAll();
    foreach($tables as $table){
       /* $delete= "DROP TABLE".table;
        $connexion->prepare($delete)->execute();
        */
        echo $table["table_name"];
    }
    
	$requete = "CREATE TABLE IF NOT EXISTS `"._MYSQL_DBNAME."`.`users` (
				`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
				`name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
				`email` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
				) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;";
	$connexion->prepare($requete)->execute();
    $remplir="INSERT INTO users(name,email)
    VALUES('Robin','bukielskirobin@gmail.com')";
    $connexion->prepare($remplir)->execute();
}