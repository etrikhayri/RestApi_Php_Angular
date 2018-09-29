<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include la base de donnée et l'objet produit
include_once '../config/database.php';
include_once '../objects/product.php';
 
// Assurer la connexion avec labase de donnée
$database = new Database();
$db = $database->getConnection();
 
// Instancier l'objet produit
$product = new Product($db);
 
// Obtenir les mots clés
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";
 
// requete de recherche
$stmt = $product->search($keywords);
$num = $stmt->rowCount();
 
// verifier sil existe des enregistrements
if($num>0){
 
    // Créer des tables vides
    $products_arr=array();
    $products_arr["records"]=array();
 
    // récupérer le contenu de notre table
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // ligne par ligne
        extract($row);
 
        $product_item=array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description),
            "price" => $price,
            "category_id" => $category_id,
            "category_name" => $category_name
        );
 
        array_push($products_arr["records"], $product_item);
    }
 
    echo json_encode($products_arr);
}
 
else{
    echo json_encode(
        array("message" => "aucun produit trouvé.")
    );
}
?>