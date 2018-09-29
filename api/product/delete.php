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
 
//obtenir l'id de produit à supprimer
$data = json_decode(file_get_contents("php://input"));
 
// lier l'id de produit à supprimer
$product->id = $data->id;
 
// Supprimer le produit
if($product->delete()){
    echo '{';
        echo '"message": "Produit à été supprimer avec succées."';
    echo '}';
}
 
// en cas d'erreur
else{
    echo '{';
        echo '"message": "Impossible de supprimer cet produit."';
    echo '}';
}
?>