<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include base de donnée et l'objet
include_once '../config/database.php';
include_once '../objects/product.php';
 
// Assurer la connexion avec la base
$database = new Database();
$db = $database->getConnection();
 
// Preparer l'objet produit
$product = new Product($db);
 
// Definir l'id de produit à modifier
$product->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// Importer les details de produit à modifier
$product->readOne();
 
// Créer une table avec les details de produits
$product_arr = array(
    "id" =>  $product->id,
    "name" => $product->name,
    "description" => $product->description,
    "price" => $product->price,
    "category_id" => $product->category_id,
    "category_name" => $product->category_name
 
);
 
// Transformer la table en format json
print_r(json_encode($product_arr));
?>