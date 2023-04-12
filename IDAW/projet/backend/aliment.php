<?php

$request_method = $_SERVER["REQUEST_METHOD"];
switch ($request_method) {
  case 'GET':
    if (!empty($_GET["id"])) {
      $id = $_GET["id"];
      getAliment($id);
    } else {
      if (!empty($_GET["nom_alimentation"])) {
        $nom_alimentation = $_GET["nom_alimentation"];
        AddSearchedAlimentationID($nom_alimentation);
      } else {
        getAliment();
      }
    }
    break;
  case 'POST':
    addAliment();
    break;

  default:
    // Requête invalide
    header("HTTP/1.0 405 Method Not Allowed");
    break;
}

function getAliment($id = null)
{
  require_once('init_pdo.php');
  $query = "
  SELECT a.nom, t.nom AS nom_type, c1.quantité AS kcal, c2.quantité AS proteines, c3.quantité AS glucides, c4.quantité AS lipides 
  FROM aliments a 
  JOIN type t ON a.id_type = t.id 
  LEFT JOIN contient c1 ON a.id = c1.id_alim AND c1.id_nut = 136 
  LEFT JOIN contient c2 ON a.id = c2.id_alim AND c2.id_nut = 141 
  LEFT JOIN contient c3 ON a.id = c3.id_alim AND c3.id_nut = 143 
  LEFT JOIN contient c4 ON a.id = c4.id_alim AND c4.id_nut = 142";

  if ($id !== null) {
    $query .= " WHERE a.id = ?";
    $params = [$id];
  }

  $request = $pdo->prepare($query);
  $request->execute($params ?? []);
  $aliments = $request->fetchAll();

  $datas = array_map(function ($aliment) {
    return [
      'nom_alim' => $aliment['nom'],
      'nom_type' => $aliment['nom_type'],
      'kcal'     => $aliment['kcal'],
      'proteine' => $aliment['proteines'],
      'glucide'  => $aliment['glucides'],
      'lipide'  => $aliment['lipides']
    ];
  }, $aliments);

  $res = array("data" => $datas);
  header('Content-Type: application/json');
  echo json_encode($res, JSON_PRETTY_PRINT);
}
function AddSearchedAlimentationID($nom_alimentation)
{
  require_once('init_pdo.php');
  $query = "
  SELECT a.id
  FROM aliments a
  WHERE a.nom = ?";
  $params = [$nom_alimentation];

  $request = $pdo->prepare($query);
  $request->execute($params ?? []);
  $aliments = $request->fetchAll();

  $datas = array_map(function ($aliment) {
    return [
      'id' => $aliment['id'],
    ];
  }, $aliments);

  $res = array("data" => $datas);
  header('Content-Type: application/json');
  echo json_encode($res, JSON_PRETTY_PRINT);
}

function addAliment()
{
  require_once('init_pdo.php');
  $nom =  $_POST['nom'];
  $type = $_POST['type'];
  $sql = "INSERT INTO aliments(nom,id_type)  VALUES ('$nom','$type')";
  $request = $pdo->prepare($sql)->execute();
  if ($request) {
    $response = array(
      'status' => 1,
      'status_message' => 'Aliment ajoute avec succes.'
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
