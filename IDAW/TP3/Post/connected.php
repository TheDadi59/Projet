<?php 
$style='style1';
if(isset($_COOKIE['style'])){
    $style=$_COOKIE['style'];
}
?>
<?php


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>CV</title>
    <?php
    echo "<link rel='stylesheet' href='{$style}.css'>"
    ?>
  </head>
<?php

// on simule une base de données
$users = array(
// login => password
'riri' => 'fifi',
'yoda' => 'maitrejedi' );
$login = "anonymous";
$errorText = "";
$successfullyLogged = false;
if(isset($_POST['login']) && isset($_POST['password'])) {
$tryLogin=$_POST['login'];
$tryPwd=$_POST['password'];
// si login existe et password correspond
if( array_key_exists($tryLogin,$users) && $users[$tryLogin]==$tryPwd ) {
$successfullyLogged = true;
$login = $tryLogin;
} else
$errorText = "Erreur de login/password";
} else
$errorText = "Merci d'utiliser le formulaire de login";
if(!$successfullyLogged) {
  
echo $errorText;
echo $_POST['login'];
echo $_POST['password'];
} else {
  session_start();
$_SESSION['login']=$_POST['login'];
$_SESSION['password']=$_POST['password'];

echo "<h1>Bienvenu ".$_SESSION['login']."</h1>";
}
?>
<a  href="login.php?status=disconnect"  class="deletebtn">Deconnection</a>




