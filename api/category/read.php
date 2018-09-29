<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/category.php';
 
// Assurer la connexion avec la base
$database = new Database();
$db = $database->getConnection();
 
// instancier l'objet produit 
$category = new Category($db);
 
// Lancer requete
$stmt = $category->read();
$num = $stmt->rowCount();
 
// verifier s''il existe des enregistrements
if($num>0){
 
    // Créer des tables vides
    $categories_arr=array();
    $categories_arr["records"]=array();
 
    // récupérer le contenu de notre table
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // Ligne par ligne
        extract($row);
 
        $category_item=array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description)
        );
 
        array_push($categories_arr["records"], $category_item);
    }
 
    echo json_encode($categories_arr);
}
 
else{
    echo json_encode(
        array("message" => "aucune categorie trouvée.")
    );
}
?>