<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include la base de donnée et l'objet produit
include_once '../config/database.php';
include_once '../objects/product.php';
 
// Assurer la connexion avec labase de donnée
$database = new Database();
$db = $database->getConnection();
 
// Instancier l'objet produit
$product = new Product($db);
 
// obtenir l'id de produit à modfier
$data = json_decode(file_get_contents("php://input"));
 
// lier l'id de produit à modfier
$product->id = $data->id;
 
// lier les entrées
$product->name = $data->name;
$product->price = $data->price;
$product->description = $data->description;
$product->category_id = $data->category_id;
 
// Mettre à jour le produit
if($product->update()){
    echo '{';
        echo '"message": "Produit à été mis à jour avec succées."';
    echo '}';
}
 
// En cas d'erreur
else{
    echo '{';
        echo '"message": "Impossible de mettre à jour cet produit."';
    echo '}';
}
?>