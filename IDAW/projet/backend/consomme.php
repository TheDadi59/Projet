<?php

$request_method = $_SERVER["REQUEST_METHOD"];
switch ($request_method) {
  case 'GET':
    if (!empty($_GET["id_user"])) {
      if (!empty($_GET["somme"])) {
        $id = intval($_GET["id_user"]);
        getSommeConsomme($id);
      } else {
        if(!empty($_GET["date"]))
        {
          $id = intval($_GET["id_user"]);
          $date = intval($_GET["date"]);
          getConsomme($id,$date);
        }else{
          $id = intval($_GET["id_user"]);
          getConsomme($id);
        }
      }
      
    } else {
      // Récupérer tous les produits
      getConsomme();
    }

    break;
  case 'POST':

    addConsomme();

    break;
  case 'DELETE':
    if (!empty($_GET["id"])) {
      $id = intval($_GET["id"]);
      deleteConsomme($id);
    } else {
      // Récupérer tous les produits
      deleteConsomme();
    }
    break;
  case 'PUT':
    updateConsomme();
    break;

  default:
    // Requête invalide
    header("HTTP/1.0 405 Method Not Allowed");
    break;
}

function getConsomme($id = null,$date = null)
{
  require_once('init_pdo.php');
  if ($id === null) {
    $query = $pdo->prepare("SELECT DISTINCT consomme.id_alim, aliments.nom, consomme.quantité, consomme.date_consommation 
    FROM consomme 
    JOIN aliments ON consomme.id_alim = aliments.id ");
  } else {
    $query = $pdo->prepare("SELECT DISTINCT consomme.id_alim, aliments.nom, consomme.quantité, consomme.date_consommation 
    FROM consomme 
    JOIN aliments ON consomme.id_alim = aliments.id 
    WHERE id_user = $id");
  }
  if ($date !== null) {
    $query .= "AND consomme.date_consommation BETWEEN '$date' AND NOW()";
  }

  $query->execute();
  $response = array();
  $response = $query->fetchAll();
  $res = array("data" => $response);
  header('Content-Type: application/json');
  echo json_encode($res, JSON_PRETTY_PRINT);
}
function getSommeConsomme($id){
  require_once('init_pdo.php');
  if ($id === null) {
    $query = $pdo->prepare("SELECT 
    (consomme.quantité/100)*SUM(c1.quantité) AS total_kcal, 
    (consomme.quantité/100)*SUM(c2.quantité) AS total_proteines, 
    (consomme.quantité/100)*SUM(c3.quantité) AS total_glucides, 
    (consomme.quantité/100)*SUM(c4.quantité) AS total_lipides 
    
    FROM consomme 
    JOIN aliments a ON consomme.id_alim = a.id 
    LEFT JOIN contient c1 ON a.id = c1.id_alim AND c1.id_nut = 136 
    LEFT JOIN contient c2 ON a.id = c2.id_alim AND c2.id_nut = 141 
    LEFT JOIN contient c3 ON a.id = c3.id_alim AND c3.id_nut = 143 
    LEFT JOIN contient c4 ON a.id = c4.id_alim AND c4.id_nut = 142");
  } else {
    $query = $pdo->prepare("SELECT 
    (consomme.quantité/100)*SUM(c1.quantité) AS total_kcal, 
    (consomme.quantité/100)*SUM(c2.quantité) AS total_proteines, 
    (consomme.quantité/100)*SUM(c3.quantité) AS total_glucides, 
    (consomme.quantité/100)*SUM(c4.quantité) AS total_lipides 
    
    FROM consomme 
    JOIN aliments a ON consomme.id_alim = a.id 
    LEFT JOIN contient c1 ON a.id = c1.id_alim AND c1.id_nut = 136 
    LEFT JOIN contient c2 ON a.id = c2.id_alim AND c2.id_nut = 141 
    LEFT JOIN contient c3 ON a.id = c3.id_alim AND c3.id_nut = 143 
    LEFT JOIN contient c4 ON a.id = c4.id_alim AND c4.id_nut = 142
    WHERE id_user = $id");
  }
  $query->execute();
  $response = array();
  $response = $query->fetchAll();
  $res = array("data" => $response);
  header('Content-Type: application/json');
  echo json_encode($res, JSON_PRETTY_PRINT);
}
function addConsomme()
{
  require_once('init_pdo.php');
  $id_alim = $_POST['id_alim'];
  $id_user = $_POST['id_user'];
  $quantité = $_POST['quantité'];
  $date_consommation = $_POST['date_consommation'];

  $sql = "INSERT INTO consomme(id_alim,id_user,quantité,date_consommation)  VALUES ('$id_alim','$id_user','$quantité','$date_consommation')";
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
function deleteConsomme($id = null)
{
  require_once('init_pdo.php');
  if ($id === null) {
    $sql = " TRUNCATE TABLE `consomme`";
    $query = $pdo->prepare($sql);
  } else {
    $sql = "DELETE FROM `consomme`
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

function updateConsomme()
{
  require_once('init_pdo.php');
  $json = file_get_contents('php://input');
  $put = json_decode($json, TRUE);
  $id = $put['id'];
  $quantité = $put['quantité'];
  $date_consommation = $put['date_consommation'];
  $sql = "UPDATE consomme
  SET quantité = '$quantité',
    date_consommation = '$date_consommation'
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
