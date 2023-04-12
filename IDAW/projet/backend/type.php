<?php

$request_method=$_SERVER["REQUEST_METHOD"];
switch($request_method)
{
  case 'GET':
    if(!empty($_GET["id_aliment"]))
    {
      $id_aliment = $_GET["id_aliment"];
      getTypes($id_aliment);
    }
    break;


  default:
    // Requête invalide
    header("HTTP/1.0 405 Method Not Allowed");
    break;
}

function getTypes($id_aliment){
    require_once('dbconnect.php');
        $query = $pdo->prepare("SELECT nom 
        FROM type 
        WHERE id = (SELECT id_type FROM aliments WHERE id = '$id_aliment')
        ");
    $query->execute();
    $response=array();
    $response = $query->fetchAll();
    $res = array("data" => $response);
    header('Content-Type: application/json');
    echo json_encode($res, JSON_PRETTY_PRINT);
}

?>