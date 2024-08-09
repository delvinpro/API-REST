<?php
class Etudiant
{
    private $table = "etudients";
    private $connexion = null;

    public $id;
    public $nom;
    public $prenom;
    public $age;
    public $niveau_id;
    public $niveau_nom;
    public $created_at;

    public function __construct($db) {
        if($this->connexion === null){
            $this->connexion = $db;
        }
    }

    public function readAll(){
        $sql = "SELECT e.nom, prenom, age, e.id, niveau_id, n.nom FROM $this->table e LEFT JOIN niveauX n ON niveau_id = n.id ORDER BY e.create_at DESC";
        $req = $this->connexion->query($sql);
        return $req;
    }

    public function create() {
        $sql = "INSERT INTO $this->table(nom, prenom, age, niveau_id, create_at) VALUES (:nom, :prenom, :age, :niveau_id, NOW())";

        $req = $this->connexion->prepare($sql);

        $result = $req->execute([
            ":nom" => $this->nom,
            ":prenom" => $this->prenom,
            ":age" => $this->age,
            ":niveau_id" => $this->niveau_id
        ]);

        if ($result) {
           return true;
        } else {
           return false;
        }
        
    }

    public function update(){
        $sql = "UPDATE $this->table SET nom=:nom, prenom=:prenom, age=:age, niveau_id=:niveau_id WHERE id=:id";

        $req = $this->connexion->prepare($sql);
        $result = $req->execute([
            ":nom" => $this->nom,
            ":prenom" => $this->prenom,
            ":age" => $this->age,
            ":niveau_id" => $this->niveau_id,
            ":id" => $this->id
        ]);

        if ($result) {
            return true;
         } else {
            return false;
         }
    }

    public function delete()
    {
        $sql = "DELETE FROM  $this->table WHERE id=:id";

        $req = $this->connexion->prepare($sql);

        $result = $req->execute([
            ":id" => $this->id
        ]);

        if ($result) {
           return true;
        } else {
           return false;
        }
        

    }
}