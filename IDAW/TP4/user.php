<?php
require_once('config.php');
//require_once('dbinit.php');
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

$request = $pdo->prepare("select * from users");
$request->execute();
$users = $request->fetchAll();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Table</title>
  </head>
  <body>
<table>
  <tr>
    <th>ID</th>
    <th>Nom</th>
    <th>Mail</th>
    <th>Supprimer</th>
    <th>Update</th>
  </tr>
<?php

foreach($users as $user){
    echo '<tr>';
    echo"<td> {$user['id']} </td>";
    echo"<td> {$user['name']} </td>";
    echo"<td> {$user['email']} </td>";
    echo"<td> <a href=delete.php?id={$user['id']}>Supprimer</a></td> ";
    echo"<td> <a href=user.php?id={$user['id']}>Update</a></td> ";
    echo '</tr>';
   
}
echo "</table>";

if(isset($_GET['id'])){
  $id=$_GET['id'];
  $sql="SELECT *
  FROM users
  WHERE id=$id";
  $req = $pdo->prepare($sql);
  $req->execute();
  $user=$req->fetch();
  echo " <form action='update.php?id={$user['id']}' method='post'>";
  echo " <label for='name'>NOM:</label>";
  echo " <input type='text' name='name' id='name' value=".$user['name'].">"; 
  echo "<label for='email'>Email:</label>";
  echo "<input type='text' name='email' id='email' value=".$user['email'].">";
  echo " <input type='submit' value='Update'>";
  echo "                      </form>";
}
else{
  echo " <form action='insert.php' method='post'>";
  echo " <label for='name'>NOM:</label>";
  echo " <input type='text' name='name' id='name'>";
  echo "<label for='email'>Email:</label>";
  echo "<input type='text' name='email' id='email'>";
  echo " <input type='submit' value='Creer'>";
  echo "                      </form>";

}
$pdo = null;
?>

 

</body>
</html>