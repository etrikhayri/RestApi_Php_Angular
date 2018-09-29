<?php
// Definir les  headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include la base de donnée et l'objet product
include_once '../config/database.php';
include_once '../objects/product.php';
 
// instancier la base et l'objet product
$database = new Database();
$db = $database->getConnection();
 
// initialiser l'objet
$product = new Product($db);
 
// query products
$stmt = $product->read();
$num = $stmt->rowCount();
 
// Verifier s'il existe des enregistrements 
if($num>0){
 
    // Définir des tables vides
    $products_arr=array();
    $products_arr["records"]=array();
 
    //récupérer le contenu de notre table
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extraction ligne par ligne
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