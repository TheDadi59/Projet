<?php

$request_method = $_SERVER["REQUEST_METHOD"];
switch ($request_method) {
  case 'GET':
    if (!empty($_GET["id"])) {
      $id = intval($_GET["id"]);
      getUsers($id);
    } else {
      // Récupérer tous les produits
      getUsers();
    }
    break;
  case 'POST':

    addUsers();

    break;
  case 'DELETE':
    if (!empty($_GET["id"])) {
      $id = intval($_GET["id"]);
      deleteUsers($id);
    } else {
      // Récupérer tous les produits
      deleteUsers();
    }
    break;
  case 'PUT':
    updateUsers();
    break;

  default:
    // Requête invalide
    header("HTTP/1.0 405 Method Not Allowed");
    break;
}

function getUsers($id = null)
{
  require_once('dbconnect.php');
  if ($id === null) {
    $query = $pdo->prepare("select * from users");
  } else {
    $query = $pdo->prepare("select * from users where id = $id");
  }
  $query->execute();
  $response = array();
  $response = $query->fetchAll();
  $res = array("data" => $response);
  header('Content-Type: application/json');
  echo json_encode($res, JSON_PRETTY_PRINT);
}
function addUsers()
{
  require_once('dbconnect.php');
  $name = $_POST['name'];
  $email = $_POST['email'];

  $sql = "INSERT INTO users(name,email)  VALUES ('$name',
         '$email')";
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
function deleteUsers($id = null)
{
  require_once('dbconnect.php');
  if ($id === null) {
    $sql = " TRUNCATE TABLE `users`";
    $query = $pdo->prepare($sql);
  } else {
    $sql = "DELETE FROM `users`
        WHERE id=$id";
    $query = $pdo->prepare($sql);
  }
  $query->execute();
  $result = $query->execute();
  $response = array();
  if ($result) {
    $response = array(
      'status' => 1,
      'status_message' => 'Utilisateur ajoute avec succes.'
    );
  } else {
    $response = array(
      'status' => 0,
      'status_message' => 'Erreur de la requête.'
    );
  }

  $response = array(
    'status' => 1,
    'status_message' => 'Utilisateur supprimmer avec succes.'
  );
  header('Content-Type: application/json');
  echo json_encode($response, JSON_PRETTY_PRINT);
}

function updateUsers()
{
  require_once('dbconnect.php');
  $json = file_get_contents('php://input');
  $put = json_decode($json, TRUE);
  $id = $put['id'];
  $name = $put['name'];
  $email = $put['email'];
  $sql = "UPDATE users
   SET name = '$name',
     email = '$email'
   WHERE id =$id";

  $test = $pdo->prepare($sql)->execute();
  if ($test) {
    $response = array(
      'status' => 1,
      'status_message' => 'Utilisateur mis à jour  avec succes.'
    );
  } else {
    $response = array(
      'status' => 0,
      'status_message' => 'erreur'
    );
  }
  header('Content-Type: application/json');
  echo json_encode($response, JSON_PRETTY_PRINT);
}

?>