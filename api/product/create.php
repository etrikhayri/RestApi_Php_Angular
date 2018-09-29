<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include base de donnée et l'objet
include_once '../config/database.php';
include_once '../objects/product.php';

// Assurer la connexion avec la base
$database = new Database();
$db = $database->getConnection();

//  instancier l'objet produit 
$product = new Product($db);
 
// Obtenir les données d'entré
$data = json_decode(file_get_contents("php://input"));
 
// hydrater les attributs de l'objet
$product->name = $data->name;
$product->price = $data->price;
$product->description = $data->description;
$product->category_id = $data->category_id;
$product->created = date('Y-m-d H:i:s');
 
// Créer le produit
if($product->create()){
    echo '{';
        echo '"message": "Produit crée avec succées."';
    echo '}';
}
 
// En cas d'erreur
else{
    echo '{';
        echo '"message": "Unable to create product."';
    echo '}';
}
?>