<?php

$request_method=$_SERVER["REQUEST_METHOD"];
switch($request_method)
{
  case 'GET':
    if(!empty($_GET["nutriment"]))
    {
      $id_aliment = $_GET["id_aliment"];
      $nutriment = $_GET["nutriment"];
      getContient($id_aliment,$nutriment);
    }else{
        $id_aliment = $_GET["id_aliment"];
        getContient($id_aliment);
    }
    break;
  case 'POST':
    addContient();
    break;

  default:
    // Requête invalide
    header("HTTP/1.0 405 Method Not Allowed");
    break;
}

function getContient($id_aliment,$nutriment = null){
  require_once('init_pdo.php');
    echo ($nutriment);
    if($nutriment == null){
        $query = $pdo->prepare("SELECT id_nut, quantité FROM contient WHERE id_alim = $id_aliment");
    }else{
        $query = $pdo->prepare("SELECT quantité 
        FROM contient 
        WHERE id_alim = $id_aliment 
          AND id_nut = (SELECT id FROM nutriments WHERE nom = '$nutriment')
        ");
    }
    $query->execute();
    $response=array();
    $response = $query->fetchAll();
    $res = array("data" => $response);
    header('Content-Type: application/json');
    echo json_encode($res, JSON_PRETTY_PRINT);
}
function addContient(){
  require_once('init_pdo.php');
    $id_aliment =  $_POST['id_aliment'];
    $id_nutriment = $_POST['id_nutriment'];
    $quantité = $_POST['quantité'];
    $sql = "INSERT INTO contient(quantité,id_nut,id_alim)  VALUES ('$quantité','$id_nutriment','$id_aliment')";
    $test=$pdo->prepare($sql)->execute();
    if ($test)
    {$response=array(
        'status' => 1,
        'status_message' =>'Aliment ajoute avec succes.'
      );}
 else
     {$response=array(
        'status' => 0,
        'status_message' =>'Erreur de la requête.'
      );
    }
     header('Content-Type: application/json');
     echo json_encode($response);
}
?>