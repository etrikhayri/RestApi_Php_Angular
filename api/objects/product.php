<?php
class Product{
 
    // Definir la base de donnée et le nom de la table
    private $conn;
    private $table_name = "products";
 
    // Attributs de l'objet
    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $category_name;
    public $created;
 
    // Constrcteur avec $db comme étant base de donnée
    public function __construct($db){
        $this->conn = $db;
    }

    // Fonction read
function read(){
    
       // Requete sql
       $query = "SELECT
                   c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
               FROM
                   " . $this->table_name . " p
                   LEFT JOIN
                       categories c
                           ON p.category_id = c.id
               ORDER BY
                   p.created DESC";
    
       // preparer requete
       $stmt = $this->conn->prepare($query);
    
       // executer requete
       $stmt->execute();
    
       return $stmt;
   }

   // Fonction create
function create(){
    
       // Requete d'insertion
       $query = "INSERT INTO
                   " . $this->table_name . "
               SET
                   name=:name, price=:price, description=:description, category_id=:category_id, created=:created";
    
       // preparer requete
       $stmt = $this->conn->prepare($query);
    
       // Former les entrées
       $this->name=htmlspecialchars(strip_tags($this->name));
       $this->price=htmlspecialchars(strip_tags($this->price));
       $this->description=htmlspecialchars(strip_tags($this->description));
       $this->category_id=htmlspecialchars(strip_tags($this->category_id));
       $this->created=htmlspecialchars(strip_tags($this->created));
    
       // Lier les entrées
       $stmt->bindParam(":name", $this->name);
       $stmt->bindParam(":price", $this->price);
       $stmt->bindParam(":description", $this->description);
       $stmt->bindParam(":category_id", $this->category_id);
       $stmt->bindParam(":created", $this->created);
    
       // executer requete
       if($stmt->execute()){
           return true;
       }
    
       return false;
        
   }

   //Fonction readOne 
function readOne(){
    
       // requete sql pour selectionner un seul produit
       $query = "SELECT
                   c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
               FROM
                   " . $this->table_name . " p
                   LEFT JOIN
                       categories c
                           ON p.category_id = c.id
               WHERE
                   p.id = ?
               LIMIT
                   0,1";
    
       // preparer requete
       $stmt = $this->conn->prepare( $query );
    
       // Lier l'id de produit 
       $stmt->bindParam(1, $this->id);
    
       // executer requete
       $stmt->execute();
    
       // obtenir le resultat de requete
       $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
       // Lier les entrées
       $this->name = $row['name'];
       $this->price = $row['price'];
       $this->description = $row['description'];
       $this->category_id = $row['category_id'];
       $this->category_name = $row['category_name'];
   }

   // Fonction update
function update(){
    
       // requete update
       $query = "UPDATE
                   " . $this->table_name . "
               SET
                   name = :name,
                   price = :price,
                   description = :description,
                   category_id = :category_id
               WHERE
                   id = :id";
    
       // preparer requete
       $stmt = $this->conn->prepare($query);
    
       // Forer les entrées
       $this->name=htmlspecialchars(strip_tags($this->name));
       $this->price=htmlspecialchars(strip_tags($this->price));
       $this->description=htmlspecialchars(strip_tags($this->description));
       $this->category_id=htmlspecialchars(strip_tags($this->category_id));
       $this->id=htmlspecialchars(strip_tags($this->id));
    
       // Lier les entrées
       $stmt->bindParam(':name', $this->name);
       $stmt->bindParam(':price', $this->price);
       $stmt->bindParam(':description', $this->description);
       $stmt->bindParam(':category_id', $this->category_id);
       $stmt->bindParam(':id', $this->id);
    
       // executer requete
       if($stmt->execute()){
           return true;
       }
    
       return false;
   }

   // Fonction delete
function delete(){
    
       // requete de suppression
       $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
    
       // preparer requete
       $stmt = $this->conn->prepare($query);
    
       // former l'entré
       $this->id=htmlspecialchars(strip_tags($this->id));
    
       // lier l'id de produit à supprimer
       $stmt->bindParam(1, $this->id);
    
       // executer requete
       if($stmt->execute()){
           return true;
       }
    
       return false;
        
   }

   // Fonction search
function search($keywords){
    
       // Requete de recherche
       $query = "SELECT
                   c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
               FROM
                   " . $this->table_name . " p
                   LEFT JOIN
                       categories c
                           ON p.category_id = c.id
               WHERE
                   p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ?
               ORDER BY
                   p.created DESC";
    
       // preparer requete
       $stmt = $this->conn->prepare($query);
    
       // Forer l'entré
       $keywords=htmlspecialchars(strip_tags($keywords));
       $keywords = "%{$keywords}%";
    
       // Lier l'entré
       $stmt->bindParam(1, $keywords);
       $stmt->bindParam(2, $keywords);
       $stmt->bindParam(3, $keywords);
    
       // executer requete
       $stmt->execute();
    
       return $stmt;
   }
}