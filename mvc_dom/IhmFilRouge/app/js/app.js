/*
 * Déclaration de l'application app
 */
var app = angular.module("app", [
	'ngRoute',
	'ui.bootstrap',
	'btorfs.multiselect',
	'btorfs.multiselect.templates',
	'720kb.background'


]);
 


/*
 * Configuration du module principal : routeApp
 */
app.config(['$routeProvider',
    function($routeProvider) { 
        
        // Système de routage
        $routeProvider

        .when('/page1', {
            templateUrl: 'partials/page1.html',
            controller: 'page1Ctrl'
        })
        .when('/page2', {
            templateUrl: 'partials/page2.html',
            controller: 'page2Ctrl'
        })
		.when('/page3', {
            templateUrl: 'partials/page3.html',
            controller: 'page3Ctrl'
        })
				.when('/page4', {
            templateUrl: 'partials/page4.html',
            controller: 'page4Ctrl'
        })
		.otherwise({
            redirectTo: '/page2'
        });
    }
])
.directive('resize', [ "$parse", function($parse) {
    return {
      link: function(scope, elm, attrs) {
        var imagePercent;
        imagePercent = $parse(attrs.imagePercent)(scope);
        elm.bind("load", function(e) {
          elm.unbind("load"); //Hack to ensure load is called only once
          var canvas, ctx, neededHeight, neededWidth;
          neededHeight = elm[0].naturalHeight * imagePercent / 100;
          neededWidth = elm[0].naturalWidth * imagePercent / 100;
          canvas = document.createElement("canvas");
          canvas.width = neededWidth;
          canvas.height = neededHeight;
          ctx = canvas.getContext("2d");
          ctx.drawImage(elm[0], 0, 0, neededWidth, neededHeight);
          elm.attr('src', canvas.toDataURL("image/jpeg"));
        });
      }
    };
  }
  ]);
  
  

  

/*
 * Définition des contrôleurs
 */


/* Contrôleur de la page d'accueil */
//routeAppControllers.controller('page1Ctrl', ['$scope','$http',   // specifie que le controlleur utilise les modules scope et http definis dans angular
angular.module("app").controller('page1Ctrl', ['$scope','$http',  
	function($scope, $http ){   // definir scope et http ici aussi, c'est uniquement des modules angular ici
        $scope.message = "Bienvenue sur la page d'accueil";
		$scope.login = {}; 
		
		var url4 = 'http://localhost:8001/ihmFilRouge/lireClients';
		$http.get(url4).success(function(data) {
		$scope.login.clients = data;


					
		});

	
	}
]);


	


/* Contrôleur de la page de contact */

angular.module("app").controller('page2Ctrl', ['$scope','$http',  
    function($scope, $http){
		
		$scope.oras = {}; 
		
		var url2 = 'http://localhost:8001/ihmFilRouge/lireProduits';
		$http.get(url2).success(function(data) {
		$scope.produits = data;
		$scope.ajouter = function (index) {
			var nb=this.nombre;
			//alert (nb);
			var prod = this.produits[index].lib_prod;
			var codeProd = this.produits[index].code_prod;
			var HT = this.produits[index].pric_HT;
			var tVA = this.produits[index].tva;
			//alert (codeProd);
			var url5 = 'http://localhost:8001/ihmFilRouge/lirePanier';
			$http.get(url5).success(function(data) {
					$scope.paniers = data;
					if ($scope.paniers != null) {
						//alert (tVA);
						var url7 = 'http://localhost:8001/ihmFilRouge/ajouterProduitAuPanier?code_client='+$scope.paniers[0].code_client+'&code_prod='+codeProd+'&qte='+nb+'&prix_HT='+HT+'&tVA='+tVA;
						//alert(url7);
						$http.get(url7);
						//il faut reajuster le prix ttc
							var ttcPanier = $scope.paniers[0].montant_total_ttc;
							//alert (ttcPanier);
							var ttcp = parseFloat(ttcPanier);
							var HTp = parseFloat(HT);
							var tVAp = parseFloat(tVA);
							var ttc2 = ttcp + (nb * (HTp + ((HTp * tVAp) / 100)));
							//alert (ttc2);
							var url11 = 'http://localhost:8001/ihmFilRouge/modifierPrixTtc?TTC='+ttc2+'&code_client=%22'+$scope.paniers[0].code_client+'%22';
							$http.get(url11);
						//il faut diminuer le stock dispo
						
						alert ("Produit ajouté au panier");
					} else {
						
					}
			})
		}
		

					
		});
		
        $scope.oras.message = "Laissez-nous un message sur la page de contact !";
        $scope.oras.msg = "Page prévue pour gérer le suivi des demandes";
    }
]);

/* Contrôleur de la page de spare */

angular.module("app").controller('page3Ctrl', ['$scope','$http', '$window',
    function($scope, $http, $window){
		
			
		
		var url3 = 'http://localhost:8001/ihmFilRouge/lireProduitsPanier';
		$http.get(url3).success(function(data) {
		$scope.produitsPanier = data;

					
		});
		
		var url6 = 'http://localhost:8001/ihmFilRouge/lirePanier';
		$http.get(url6).success(function(data) {
		$scope.paniers = data;
		});
		
		
		$scope.supprimer = function (index2) {

		
			var codeProd2 = this.produitsPanier[index2].code_prod;
			var nb=this.produitsPanier[index2].qte;
			var HT = this.produitsPanier[index2].prix_HT;
			var tVA = this.produitsPanier[index2].tva;
		
			alert (codeProd2);
			var url8 = 'http://localhost:8001/ihmFilRouge/lirePanier';
			$http.get(url8).success(function(data) {
					$scope.paniers2 = data;
					if ($scope.paniers2 != null) {
							//il faut reajuster le prix ttc
							var ttcPanier = $scope.paniers2[0].montant_total_ttc;
							//alert (ttcPanier);
							var ttcp = parseFloat(ttcPanier);
							//alert (ttcp);
							var HTp = parseFloat(HT);
							var tVAp = parseFloat(tVA);
							var ttc2 = ttcPanier - (nb * (HTp + ((HTp * tVAp) / 100)));
							alert (ttc2);
							var url11 = 'http://localhost:8001/ihmFilRouge/modifierPrixTtc?TTC='+ttc2+'&code_client=%22'+$scope.paniers2[0].code_client+'%22';
							$http.get(url11);
						var url9 = 'http://localhost:8001/ihmFilRouge/supprimerProduitAuPanier?code_client='+$scope.paniers2[0].code_client+'&code_prod='+codeProd2;
						//alert(url9);
						$http.get(url9);
						$window.location.reload();
					} 
			})
		}
		
		$scope.acheter = function () {
			$window.location = '#/page4';
		}
			
        $scope.message = "Laissez-nous un message sur la page de spare !";
        $scope.msg = "Fonction a définir";
    }
]);

angular.module("app").controller('page4Ctrl', ['$scope','$http', '$window',
    function($scope, $http, $window){
	
		var url15 = 'http://localhost:8001/ihmFilRouge/lireClients';
		$http.get(url15).success(function(data) {
		$scope.clients2 = data;

		})

			var url8 = 'http://localhost:8001/ihmFilRouge/lirePanier';
			$http.get(url8).success(function(data) {
					$scope.paniers2 = data;
					/*if ($scope.paniers2 != null) {
						
						//var url9 = 'http://localhost:8001/ihmFilRouge/supprimerProduitAuPanier?code_client='+$scope.paniers2[0].code_client+'&code_prod='+codeProd2;
						//alert(url9);
						//$http.get(url9);
						//$window.location.reload();
					} else {
						
					}*/
			})
	
		$scope.payer = function () {
			var url10 = 'http://localhost:8001/ihmFilRouge/viderPanier';
			
			alert ("Merci pour votre achat :o)");
			$http.get(url10);
			
			var url12 = 'http://localhost:8001/ihmFilRouge/modifierPrixTtc?TTC=0&code_client=%22'+$scope.paniers2[0].code_client+'%22';
			$http.get(url12);
							
			$window.location = '#/page2';
		}
	
	}
	
	
]);

var formApp = angular.module('formApp', [])

    .controller('formController', function($scope) {
  
        // we will store our form data in this object
        $scope.formData = {};
        
    });

/* Contrôleur de la page de menu */

angular.module("app").controller('MenuCtrl', ['$scope','$http','$location', '$window' , 
    function($scope, $http, $location, $window ){
		
				$scope.menu = {}; 
				$scope.location = $location; 
		

        $scope.message = "Laissez-nous un message sur la page de spare !";
        $scope.msg = "Fonction a définir";
    }
]);
