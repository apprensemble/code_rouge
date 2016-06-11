/*
 * Déclaration de l'application app
 */
var app = angular.module("app", [
	'ngRoute',
//	'routeAppControllers',
	'ui.bootstrap',
	'btorfs.multiselect',
	'btorfs.multiselect.templates',
//	'vk.beautify'

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
		.otherwise({
            redirectTo: '/page1'
        });
    }
]);

/*
 * Définition des contrôleurs
 */
//var routeAppControllers = angular.module('routeAppControllers',	'ui.bootstrap', []);

/* Contrôleur de la page d'accueil */
//routeAppControllers.controller('page1Ctrl', ['$scope','$http',   // specifie que le controlleur utilise les modules scope et http definis dans angular
angular.module("app").controller('page1Ctrl', ['$scope','$http',  
	function($scope, $http ){   // definir scope et http ici aussi, c'est uniquement des modules angular ici
        $scope.message = "Bienvenue sur la page d'accueil";
		
			// creation d'un objet "ligne ORAS du tableau de resultats"
			$scope.oras = {}; 
			$scope.fantoir = {};
			$scope.fantoirFinVoie = {};
			$scope.bano= {};
			$scope.oras.id = "test";
			$scope.oras.CoordX = "0";
			$scope.oras.Rivoli = "";
			$scope.oras.Hexacle = "";
			$scope.bano.CoordX="";
			var riv = null;
			var dept = null;
			var cmne = null;
//			$scope.Villes = "arras";


		$scope.options = [
			"SNA",
			"42C GRBL VALENCE",
			"42C GRBL RODEZ",
			"42C GRBL GRENOBLE",
			"42C GRBL REUNION",
			"42C GRBL CARAIBE",
		];
 

	
		
			/* fonction generique de recherche de codes dans les json envoyés par oras */
			$scope.getExternalCode = function(address,externalCode) {
       			var i = 0;
				// on récupere le nombre de lignes a parser dans le json
				var len = address.street.externalCodes.length; 
				// Et on balaye
				for (; i < len; ) {
					// Si on trouve, on renvoie la valeur correspondante
					if(address.street.externalCodes[i].code == externalCode) {
                    return address.street.externalCodes[i].value;
					}
					i++;
				}
				// Sinon on retourne un null 
				return null;
			}
			
			/* fonction de recherche du plus haut score dans un retour json */
			$scope.hiScore = function(address) {
				var i = 0;
				var len = address.features.length;
				var HIscore=0.01;
				for (; i < len; ) {
					if (HIscore < address.features[i].properties.score) {
						HIscore = address.features[i].properties.score;
					}
					i++;
				}
				return HIscore;
			}
			
			/* fonction qui verifie la presence d'un numero dans la voie */
			$scope.getNumber = function(address) {
				if(typeof address.streetNumber == "undefined") {
					return null;
					} 
					else {
					return address.streetNumber.number;	
					}
			}
			
			
			/* fonction qui verifie la presence d'un label dans la voie */
			$scope.getLabel = function(address) {
				if(typeof address.properties.label == "undefined") {
					return null;
				}
				else {
					return address.properties.label;
				}
			}
			
			/* Fonction de verification de rapprochement de l'adresse fournie par ORAS */
			$scope.adresseRapprochee = function(hexacle, rivoli) {
				if ((hexacle != null) && (rivoli != null)) {
					return "RAPPROCHEE";
					} else {
						if (hexacle == null) {
							return "42C";} else {
								if (rivoli == null) {return "SNA";
								} 
							}
					
			
					 
				}	
				if ((hexacle == null) && (rivoli == null)) {
					return "vide";
					}
			alert (this);
			}	
			
				
			//}
			
			/* gestion de l'affichage de carte */
				$scope.map;
            // initialisation de la fonction initmap 
            function initmap() {
				
				// Ici on indique ou trouver l'icone qui désigne un emplacement sur la carte
				L.Icon.Default.imagePath = 'bower_components/leaflet/dist/images';
				
                // paramétrage de la carte
                $scope.map = new L.Map('map');
                // crÃ©ation des "tiles" avec open street map
                var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
                var osmAttrib='Map data de OpenStreetMap';
                var osm = new L.TileLayer(osmUrl, {minZoom: 2, maxZoom: 18, attribution: osmAttrib});           
                // on centre sur la France
                $scope.map.setView(new L.LatLng(45.7531152, 4.827906),6);
                //$scope.map.setView(new L.LatLng({{ oras.CoordX }}, {{ oras.CoordY }}),14);
				$scope.map.addLayer(osm);
							
            }

			
 			// on va procéder Ã  l'initialisation de la carte */
            initmap();
			
			//on tente d'ajouter un marker*/

			var marker = L.marker(new L.LatLng(45.7531152, 4.827906)).bindPopup("test").addTo($scope.map);
			//marker.bindPopup("Coucou Monde! Je suis un popup.").openPopup();
			//var marker = new L.marker( 1.433491 , 43.606953 ).bindPopup("test").addTo(map);
			
			//var valeur = jQuery(#basic-addon2).val();
			
			//var LaVille = jQuery(page1).value('LaVille', {});
			//$scope.LaVille = LaVille;


	
			// on fait la recherche apres clic sur le bouton search (l'appli recherches est lancée par le click dans la page 1)
				$scope.recherches = function () {
				//alert ("le bouton fonctionne");
					

//	alert ($scope.Villes);
						
						/* Cette partie concerne l'API ORAS */
//						$http.get('http://dv15twsc01.rouen.francetelecom.fr/orasweb/api/addresses?mode=geoCoordinates&geoCodeX=1.296349&geoCodeY=43.717627&addressLevel=numero').
						$http.get('http://dv15twsc01.rouen.francetelecom.fr/orasweb/rest/addresses?mode=fullText&fullText='+$scope.Voies+" "+$scope.Villes).
						success(function(data) {
						$scope.address = data;

						//$scope.oras.id = $scope.address[0].id;
						
						// récupération des données d'adresse 
						$scope.oras.Num = $scope.getNumber($scope.address.addresses[0]);
						$scope.oras.TypeRue = $scope.address.addresses[0].street.type;
						$scope.oras.NomRue = $scope.address.addresses[0].street.name;
						$scope.oras.CodePostal = $scope.address.addresses[0].postalCode;
						$scope.oras.NomVille = $scope.address.addresses[0].cityName;

						
					//	$scope.oras.Rivoli = $scope.address[0].street.externalCodes[0].value;
					//	$scope.oras.Hexavia = $scope.address[0].street.externalCodes[1].value
					//	$scope.oras.Hexacle = $scope.address[0].street.externalCodes[2].value
					
						// recherche du rivoli
						// utilise la fonction getExternalCode
						$scope.oras.Rivoli=$scope.getExternalCode($scope.address.addresses[0],"RIVOLI_FT");
						riv = $scope.oras.Rivoli;
						
						// recherche hexavia
						$scope.oras.Hexavia=$scope.getExternalCode($scope.address.addresses[0],"HEXAVIA");

						// recherche hexacle voie
						$scope.oras.Hexacle=$scope.getExternalCode($scope.address.addresses[0],"HEXACLE_VOIE");
						
						// recherches coordonnees de l'adresse
						$scope.oras.CoordX = $scope.address.addresses[0].geographicCoordinates[0].geoCodeX;
						$scope.oras.CoordY = $scope.address.addresses[0].geographicCoordinates[0].geoCodeY;
						
						$scope.oras.TypeAddress = $scope.adresseRapprochee($scope.oras.Hexacle, $scope.oras.Rivoli);

						
						
						//$scope.oras.test1 = $scope.adressesDonnees(Num, TypeRue, NomRue, CodePostal, NomVille, $scope.oras.Hexacle, $scope.oras.Rivoli);
						
						// affichage sur la carte
						var Longitude = $scope.address.addresses[0].geographicCoordinates[0].geoCodeX;
						var Latitude = $scope.address.addresses[0].geographicCoordinates[0].geoCodeY;
						var marker2 = L.marker(new L.LatLng( Latitude, Longitude)).bindPopup("ORAS").addTo($scope.map);
						$scope.map.setView(new L.LatLng( Latitude, Longitude),14);
						//var marker = L.marker(new L.LatLng( [X ,  Y ])).bindPopup("test").addTo($scope.map);
						
						
							/* Cette partie concerne le fantoir */
						
							// recuperation a partir du code rivoli
							var cityCode = $scope.address.addresses[0].cityCode;
							var res = cityCode.split(""); 
							var dept = res[0]+res[1];
							var cmne = res[2]+res[3]+res[4];
							
							$http.get('http://localhost:8001/orasihm/lireFantoir?dpt='+dept+'&cmn='+cmne+'&rivoli='+riv).
							success(function(data) {
								$scope.addressFantoir = data;
						
								$scope.fantoir.code_voie = $scope.addressFantoir[0].cod_nat_voie;
								$scope.fantoir.voie = $scope.addressFantoir[0].libelle_voie;
								$scope.fantoir.cmn = $scope.addressFantoir[0].cmn;	
									
							});
						
							// recuperation a partir de la fin du nom de voie
							var voie = $scope.Voies;
							var res2 = voie.split(" ");
							var place = (res2.length - 1);
							var dernierMot = res2[place];
							$scope.fantoir.der = dernierMot;
							var http = 'http://localhost:8001/orasihm/lireFantoirFinVoie?dpt='+dept+'&cmn='+cmne+'&FinVoie='+dernierMot;
							
							$http.get(http).success(function(data) {
								$scope.addressFantoirFinVoie = data;
					
								//$scope.fantoirFinVoie.code_voie = $scope.addressFantoirFinVoie[0].cod_nat_voie;
								//$scope.fantoirFinVoie.voie = $scope.addressFantoirFinVoie[0].libelle_voie;
								//$scope.fantoirFinVoie.cmn = $scope.addressFantoirFinVoie[0].cmn;	
								//$scope.fantoirFinVoie.rivoli = $scope.addressFantoirFinVoie[0].rivoli;
									
							});
						
						}
						);
						


						
						/* Cette partie concerne l'API BAN */
						$http.get('http://api-adresse.data.gouv.fr/search/?q='+$scope.Voies+" "+$scope.Villes).
						success(function(data) {
						$scope.addressBano = data;
						
						// recherche du plus haut score
						$scope.bano.score = $scope.hiScore($scope.addressBano);
						
						// recherche de l'adresse BAN
						$scope.bano.Rue = $scope.getLabel($scope.addressBano.features[0]);

						// recherche coordonnées adresse
						$scope.bano.CoordX = $scope.addressBano.features[0].geometry.coordinates[0];
						$scope.bano.CoordY = $scope.addressBano.features[0].geometry.coordinates[1];
						
						//alert($scope.bano.Voie);
						var LongBan = $scope.addressBano.features[0].geometry.coordinates[0];
						var LatBan = $scope.addressBano.features[0].geometry.coordinates[1];
						var marker3 = L.marker(new L.LatLng( LatBan, LongBan)).bindPopup("BAN").addTo($scope.map);
						$scope.map.setView(new L.LatLng( LatBan, LongBan),14);
						}
						);
						// PB a resoudre: effacer les anciens markers a chaque recherche (sinon c'est vite le brin)
						
					//	$http.get('http://wxs.ign.fr/yrjfjqcfob4i6beiwh7xzauu/geoportail/OpenLS/
				//  	alerte ("ici");

					
			}

			
			//map.setView([40.737, -73.923], 8);
		// alert("c'est ok");	

		//	marker.bindPopup("Exemple de texte").openPopup();	
 
		$scope.sendMail = function () {
			/**alert ("le bouton fonctionne");
			var ref = $scope.ref;
			var contenu = $scope.contenu;
			var dest = $scope.mail;
			var createur = $scope.exp;**/
			
			var url = 'http://localhost:8001/orasihm/sauverDemande?ref='+$scope.ref+'&contenu='+$scope.contenu+'&dest='+$scope.mail+'&createur='+$scope.exp+'&status=enCours';
			$http.get(url);
		}
	}
	
]);

/* Contrôleur de la page de contact */
//routeAppControllers.controller('page2Ctrl', ['$scope','$http',
angular.module("app").controller('page2Ctrl', ['$scope','$http',  
    function($scope, $http){
		
		$scope.oras = {}; 
		
		var url2 = 'http://localhost:8001/orasihm/lireDemandes2';
		$http.get(url2).success(function(data) {
		$scope.demandes = data;
		//$scope.dem.ref = $scope.demandes[0].ref;
		
					
		});
		
        $scope.oras.message = "Laissez-nous un message sur la page de contact !";
        $scope.oras.msg = "Page prévue pour gérer le suivi des demandes";
    }
]);

/* Contrôleur de la page de spare */
//routeAppControllers.controller('page3Ctrl', ['$scope',
angular.module("app").controller('page3Ctrl', ['$scope','$http',  
    function($scope){
        $scope.message = "Laissez-nous un message sur la page de spare !";
        $scope.msg = "Fonction a définir";
    }
]);


