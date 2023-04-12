<?php

$request_method = $_SERVER["REQUEST_METHOD"];
switch ($request_method) {
  case 'GET':
    if (!empty($_GET["login"])) {
      $login = ($_GET["login"]);
      getUsers($login);
    } else {
      // Récupérer tous les produits
      getUsers();
    }
    break;
  case 'POST':
    addUsers();

    break;
  default:
    // Requête invalide
    header("HTTP/1.0 405 Method Not Allowed");
    break;
}
function getUsers($login = null)
{
  require_once('init_pdo.php');
  if ($login === null) {
    $query = $pdo->prepare("select * from users");
    $query->execute();
  } else {
    $query = $pdo->prepare("SELECT * FROM users WHERE login = ?");
    $query->execute([$login]);
  }

  $response = array();
  $response = $query->fetchAll();
  $res = array("data" => $response);
  header('Content-Type: application/json');
  echo json_encode($res, JSON_PRETTY_PRINT);
}
function addUsers()
{
    require_once('init_pdo.php');
  $nom = $_POST['nom'];
  $prenom = $_POST['prenom'];
  $login = $_POST['login'];
  $mdp = $_POST['mdp'];
  $sexe = $_POST['sexe'];
  $niveau = $_POST['niveau'];
  $date = $_POST['date'];

  $sql = "INSERT INTO users(login,mdp,nom,prenom,sexe,niveau,dateDeNaissance)  VALUES ('$login','$mdp','$nom','$prenom','$sexe','$niveau','$date')";
  $result = $pdo->prepare($sql)->execute();
  if ($result) {
    $response = array(
      'status' => "HTTP 201",
      'status_message' => 'Utilisateur ajoute avec succes.'
    );
  } else {
    $response = array(
      'status' => 0,
      'status_message' => 'Erreur de la requête.'
    );
  }
  header('Content-Type: application/json');
  echo json_encode($response);
}