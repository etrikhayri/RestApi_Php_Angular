<?php
class Category{
 
    // Definir la base de donnée et le nom de la table
    private $conn;
    private $table_name = "categories";
 
    // Attributs de l'objet
    public $id;
    public $name;
    public $description;
    public $created;
 
    public function __construct($db){
        $this->conn = $db;
    }
 
    
    public function readAll(){
        //selectionner tout les données
        $query = "SELECT
                    id, name, description
                FROM
                    " . $this->table_name . "
                ORDER BY
                    name";
 
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
 
        return $stmt;
    }

    // Fonction read category
public function read(){
    
       //selectionner tout les données
       $query = "SELECT
                   id, name, description
               FROM
                   " . $this->table_name . "
               ORDER BY
                   name";
    
       $stmt = $this->conn->prepare( $query );
       $stmt->execute();
    
       return $stmt;
   }
}
?>