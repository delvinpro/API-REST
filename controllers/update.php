<?php
header("Access-Controle-Allow-Origin: *");
header("Content-type: application/json; charset= UTF-8");
header("Access-Controle-Allow-Methods: PUT");
require_once("../config/Database.php");
require_once("../modals/Etudiant.php");

if ($_SERVER['REQUEST_METHOD'] === "PUT") {
    $database = new Database();
    $db = $database->getConnexion();
    
    $etudiant = new Etudiant($db);
    
    $statement = $etudiant->readAll();

    $data = json_decode(file_get_contents("php://input"));
    if(!empty($data->id) && !empty($data->nom) && !empty($data->prenom) && !empty($data->age) && !empty($data->niveau_id)){
        $etudiant->id = intval($data->id);
        $etudiant->nom = htmlspecialchars($data->nom);
        $etudiant->prenom = htmlspecialchars($data->prenom);
        $etudiant->age = htmlspecialchars($data->age);
        $etudiant->niveau_id = htmlspecialchars($data->niveau_id);

        $resutal = $etudiant->update();

        if ($resutal) {
            http_response_code(201);
            echo json_encode(["message" => "etudiant modiffier avec sucess"]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "la mdiffication de l'etudiant a echoue"]);
        }
        
    } else {
        echo json_encode(["message" => "les donnees ne sont pas au complet"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "la methode n'est pas autoriser"]);
}