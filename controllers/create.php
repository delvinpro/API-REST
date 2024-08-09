<?php
header("Access-Controle-Allow-Origin: *");
header("Content-type: application/json; charset= UTF-8");
header("Access-Controle-Allow-Methods: POST");
require_once("../config/Database.php");
require_once("../modals/Etudiant.php");

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $database = new Database();
    $db = $database->getConnexion();
    
    $etudiant = new Etudiant($db);
    
    $statement = $etudiant->readAll();

    $data = json_decode(file_get_contents("php://input"));
    if(!empty($data->nom) && !empty($data->prenom) && !empty($data->age) && !empty($data->niveau_id)){
        $etudiant->nom = htmlspecialchars($data->nom);
        $etudiant->prenom = htmlspecialchars($data->prenom);
        $etudiant->age = htmlspecialchars($data->age);
        $etudiant->niveau_id = htmlspecialchars($data->niveau_id);

        $resutal = $etudiant->create();

        if ($resutal) {
            http_response_code(201);
            echo json_encode(["message" => "etudiant ajoute avec sucess"]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "l'ajout de l'etudiant a echoue"]);
        }
        
    } else {
        echo json_encode(["message" => "les donnees ne sont pas au complet"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "la methode n'est pas autoriser"]);
}