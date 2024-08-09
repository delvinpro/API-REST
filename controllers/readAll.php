<?php
header("Access-Controle-Allow-Origin: *");
header("Content-type: application/json; charset= UTF-8");
header("Access-Controle-Allow-Methods: GET");
require_once("../config/Database.php");
require_once("../modals/Etudiant.php");

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $database = new Database();
    $db = $database->getConnexion();
    
    $etudiant = new Etudiant($db);
    
    $statement = $etudiant->readAll();
    
    if($statement->rowCount() > 0){
       $data = [];
    
       $data[] = $statement->fetchall();
        
       http_response_code(200);
       echo json_encode($data);
    } else {
        echo json_encode(["message" => "Aucune donnee a renvoyer"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "la methode n'est pas autoriser"]);
}