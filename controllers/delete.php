<?php
header("Access-Controle-Allow-Origin: *");
header("Content-type: application/json; charset= UTF-8");
header("Access-Controle-Allow-Methods: DELETE");
require_once("../config/Database.php");
require_once("../modals/Etudiant.php");

if ($_SERVER['REQUEST_METHOD'] === "DELETE") {
    $database = new Database();
    $db = $database->getConnexion();
    
    $etudiant = new Etudiant($db);
    
    $statement = $etudiant->readAll();

    $data = json_decode(file_get_contents("php://input"));
    if(!empty($data->id)){
        $etudiant->id = $data->id;
        if($etudiant->delete()){
            http_response_code(200);
            echo json_encode(["message" => "la suppression a ete efectuer avec success"]);
        } else {
            echo json_encode(["message" => "la suppression n'a pas ete efectuer."]);
        }
    } else{
        echo json_encode(["message" => "vous devez precise l'identifient de l'etudiant a supprimer"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "la methode n'est pas autoriser"]);
}