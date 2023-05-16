<?php

$request_method=$_SERVER["REQUEST_METHOD"];
switch($request_method)
{
  case 'GET':
    if(!empty($_GET["login"]))
    {
      $id = $_GET["login"];
      $mdp = $_GET["mdp"];
      verifyUser($id,$mdp);
    }else{
    }
    break;

  default:
    // Requête invalide
    header("HTTP/1.0 408 Method Not Allowed");
    break;
}

function verifyUser($login,$mdp){
    require_once('init_pdo.php');

        $query = $pdo->prepare("SELECT *
        FROM users
        WHERE login = ? ");
    
    $query->execute([$login]);
    $response = $query->fetchAll();
    $nom=$response[0]["nom"];
    $prenom=$response[0]["prenom"];
    $id=$response[0]["id_user"];
    if($response[0]["mdp"]==$mdp){
        $response = array(
            'status' => 1,
            'status_message' => "utilisateur authentifié"
          );
          session_start();
          $_SESSION['login']=$login;
        $_SESSION['password']=$mdp;
        $_SESSION['nom']=$nom;
        $_SESSION['prenom']=$prenom;
        $_SESSION['id']=$id;
    }
    else{
        $response = array(
            'status' => 0,
            'status_message' => "erreur "
          );
    }
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}