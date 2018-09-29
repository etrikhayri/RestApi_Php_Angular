app.factory("productsFactory", function($http){
    
       var factory = {};
    
       // Lister tout produits
       factory.readProducts = function(){
           return $http({
               method: 'GET',
               url: 'http://127.0.0.1/api/product/read.php'
           });
       };
        
       // Créer produit
factory.createProduct = function($scope){
    return $http({
        method: 'POST',
        data: {
            'name' : $scope.name,
            'description' : $scope.description,
            'price' : $scope.price,
            'category_id' : 1
        },
        url: 'http://localhost/api/product/create.php'
    });
};
 
// Consulter produit
factory.readOneProduct = function(id){
    return $http({
        method: 'GET',
        url: 'http://localhost/api/product/read_one.php?id=' + id
    });
};
 
// Modifier produit
factory.updateProduct = function($scope){
    
       return $http({
           method: 'POST',
           data: {
               'id' : $scope.id,
               'name' : $scope.name,
               'description' : $scope.description,
               'price' : $scope.price,
               'category_id' : 1
           },
           url: 'http://localhost/api/product/update.php'
       });
   };
    
  // Supprimer produit
factory.deleteProduct = function(id){
    return $http({
        method: 'POST',
        data: { 'id' : id },
        url: 'http://localhost/api/product/delete.php'
    });
};
 
// Chercher produit
factory.searchProducts = function(keywords){
    return $http({
        method: 'GET',
        url: 'http://localhost/api/product/search.php?s=' + keywords
    });
};
        
       return factory;
   });