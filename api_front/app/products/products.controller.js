app.controller('productsController', function($scope, $mdDialog, $mdToast, productsFactory){
    
       // Pour consulter un produit
       $scope.readProducts = function(){
    
           // Utiliser products factory
           productsFactory.readProducts().then(function successCallback(response){
               $scope.products = response.data.records;
           }, function errorCallback(response){
               $scope.showToast("Produit non trouvé!.");
           });
    
       }
        
       // Afficher la formulaire de creation de produit
       $scope.showCreateProductForm = function(event){
    
       $mdDialog.show({
           controller: DialogController,
           templateUrl: './app/products/create_product.template.html',
           parent: angular.element(document.body),
           clickOutsideToClose: true,
           scope: $scope,
           preserveScope: true,
           fullscreen: true 
       });
   }
    
   
   // Créer nouveau produit
$scope.createProduct = function(){
    
       productsFactory.createProduct($scope).then(function successCallback(response){
    
           // Informer l'utilisateur de lacreation d'un nouveau produit
           $scope.showToast(response.data.message);
    
           // Charger la liste de produits
           $scope.readProducts();
    
           // Fermer la fenetre popup
           $scope.cancel();
    
           // Vider les champs de formulaire
           $scope.clearProductForm();
    
       }, function errorCallback(response){
           $scope.showToast("Impossible de créer produit.");
       });

     
       
   }
     // Initialiser les entrées
     $scope.clearProductForm = function(){
        $scope.id = "";
        $scope.name = "";
        $scope.description = "";
        $scope.price = "";
      }, 

         // Afficher message
         $scope.showToast = function(message){
            $mdToast.show(
            $mdToast.simple()
               .textContent(message)
               .hideDelay(3000)
               .position("top right")
             );
           }   
  
$scope.readOneProduct = function(id){
    
       // Importer le produit à consulter
       productsFactory.readOneProduct(id).then(function successCallback(response){
    
           // Remplir la formulaire par les infos de produit
           $scope.id = response.data.id;
           $scope.name = response.data.name;
           $scope.description = response.data.description;
           $scope.price = response.data.price;
    
           $mdDialog.show({
               controller: DialogController,
               templateUrl: './app/products/read_one_product.template.html',
               parent: angular.element(document.body),
               clickOutsideToClose: true,
               scope: $scope,
               preserveScope: true,
               fullscreen: true
           }).then(
               function(){},
    
               // Cliquant sur bouton annuler
               function() {
                   // initialiser le contenu de popup
                   $scope.clearProductForm();
               }
           );
    
       }, function errorCallback(response){
           $scope.showToast("uups! impossible d'effectuer la tache .");
       });
    
   }
    
  
$scope.showUpdateProductForm = function(id){
    
       // Importer le produit à modifier
       productsFactory.readOneProduct(id).then(function successCallback(response){
    
           //  Remplir la formulaire par les infos de produit
           $scope.id = response.data.id;
           $scope.name = response.data.name;
           $scope.description = response.data.description;
           $scope.price = response.data.price;
    
           $mdDialog.show({
               controller: DialogController,
               templateUrl: './app/products/update_product.template.html',
               parent: angular.element(document.body),
               targetEvent: event,
               clickOutsideToClose: true,
               scope: $scope,
               preserveScope: true,
               fullscreen: true
           }).then(
               function(){},
    
              
               function() {
                   
                   $scope.clearProductForm();
               }
           );
    
       }, function errorCallback(response){
           $scope.showToast("uups! impossible d'effectuer la tache.");
       });
    
   }
    
   // Modifier produit et enregistrer modifications
$scope.updateProduct = function(){
    
       productsFactory.updateProduct($scope).then(function successCallback(response){
    
           
           $scope.showToast(response.data.message);
    
           
           $scope.readProducts();
    
         
           $scope.cancel();
    
          
           $scope.clearProductForm();
    
       },
       function errorCallback(response) {
           $scope.showToast("uups! impossible d'effectuer la tache.");
       });
    
   }
    
   // cofirmer la suppression de produit
$scope.confirmDeleteProduct = function(event, id){
    
      
       $scope.id = id;
    
       
       var confirm = $mdDialog.confirm()
           .title('Etes vous sure?')
           .textContent('Cet produit va être supprimer.')
           .targetEvent(event)
           .ok('Oui')
           .cancel('Non');
    
       // Afficher popup
       $mdDialog.show(confirm).then(
           // Bouton 'Oui'
           function() {
               // Supprimer produit
               $scope.deleteProduct();
           },
    
           // Bouton 'Non'
           function() {
               // Cacher popup
           }
       );
   }
// Supprimer produit
$scope.deleteProduct = function(){
    
       productsFactory.deleteProduct($scope.id).then(function successCallback(response){
    
         
           $scope.showToast(response.data.message);
    
        
           $scope.readProducts();
    
       }, function errorCallback(response){
           $scope.showToast("Unable to delete record.");
       });
    
   }
    
  // Chercher produit
$scope.searchProducts = function(){
    
       
       productsFactory.searchProducts($scope.product_search_keywords).then(function successCallback(response){
           $scope.products = response.data.records;
       }, function errorCallback(response){
           $scope.showToast("Unable to read record.");
       });
   }   
      
function DialogController($scope, $mdDialog) {
    $scope.cancel = function() {
        $mdDialog.cancel();
    };
}
   });