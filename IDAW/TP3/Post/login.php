<?php 
$style='style1';
if(isset($_COOKIE['style'])){
  $style=$_COOKIE['style'];
}
if(isset($_GET['css'])){
  setcookie("style", $_GET['css']);
  $style=$_GET['css'];
}

session_start();
if (isset($_GET['status'])){
if($_GET['status']=='disconnect'){
  session_unset();
  session_destroy();
}
}
 



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
  <body>
  <form id="login_form" action="connected.php" method="post">
<table>
<tr>
<th>Login :</th>
<td><input type="text" name="login"></td>
</tr>
<tr>
<th>Mot de passe :</th>
<td><input type="password" name="password"></td>
</tr>
<tr>
<th></th>
<td><input type="submit" value="Se connecter..." /></td>
</tr>
</table>
</form>
<form id="style_form" action="login.php" method="GET">
<select name="css">
<option value="style1">style1</option>
<option value="style2">style2</option>
</select>
<input type="submit" value="Appliquer" />
</form>
  </body>
</html>

<?php 
