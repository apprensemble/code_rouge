// marquette lez lille
// 10 rue jean froissart


						/*// trairement des donnees d'adresse
						$scope.adressesDonnees = function adressesDonnees (Num, TypeRue, NomRue, CodePostal, NomVille, hexacle, rivoli) {
							
							$scope.oras.Num = Num;
							$scope.oras.TypeRue = TypeRue;
							$scope.oras.NomRue = NomRue;
							$scope.oras.CodePostal = CodePostal;
							$scope.oras.NomVille = NomVille;
							
							
							if ($scope.adresseRapprochee(hexacle, rivoli) == "RAPPROCHEE") {
								$scope.oras.AdrRapp = Num+" "+TypeRue+" "+NomRue+" "+CodePostal+" "+NomVille;
								$scope.oras.AdrSNA = "N/A";
								$scope.oras.Adr42C = "N/A";
							} 
							if ($scope.adresseRapprochee(hexacle, rivoli) == "SNA") {
								$scope.oras.AdrRapp = "Adresse SNA non rapprochée";
								$scope.oras.AdrSNA = Num+" "+TypeRue+" "+NomRue+" "+CodePostal+" "+NomVille;
								$scope.oras.Adr42C = "N/A";
							}
							if ($scope.adresseRapprochee(hexacle, rivoli) == "42C") {
								$scope.oras.AdrRapp = "Adresse 42C non rapprochée";
								$scope.oras.AdrSNA = "N/A";
								$scope.oras.Adr42C = Num+" "+TypeRue+" "+NomRue+" "+CodePostal+" "+NomVille;
							}
							if ($scope.adresseRapprochee(hexacle, rivoli) == "vide") {
								
							}
							
							return NomVille;
						}
						*/


            /* Creation d'un tableau qui va contenir nos donnes */
            /*
             * Pour chaque elt du tableay on a les coordonnÃ©es gÃ©ographiques
             * une valeur ainsi que le nom de la rÃ©gion franÃ§aise
             */
            var tableau = [
                [48.58476, 7.750576, 12187, 'Alsace'],
                [44.837912, -0.579541, 60798, 'Aquitaine'],
                [45.783088, 3.082352, 9517, 'Auvergne'],
                [47.32167, 5.04139, 21219, 'Bourgogne'],
                [48.114722, -1.679444, 35008, 'Bretagne'],
                [47.9025, 1.909, 42865, 'Centre'],
                [48.9575, 4.365, 9739, 'Champagne-Ardenne'],
                [41.9266, 8.73694, 2182, 'Corse'],
                [47.24306, 6.02194, 7382, 'Franche-ComtÃ©'],
                [16, -61.73334, 1573, 'Guadeloupe'],
                [4.93461, -52.33033, 73, 'Guyane'],
                [48.856578, 2.351828, 148436, 'Ã�le-de-France'],
                [43.611944, 3.877222, 63651, 'Languedoc-Roussillon'],
                [45.85, 1.25, 7475, 'Limousin'],
                [49.1203, 6.1778, 13408, 'Lorraine'],
                [14.6, -61.08334, 948, 'Martinique'],
                [-12.77889, 45.23151, 0, 'Mayotte'],
                [43.604482, 1.443962, 56363, 'Midi-PyrÃ©nÃ©es'],
                [50.637222, 3.063333, 24487, 'Nord-Pas-de-Calais'],
                [49.183056, -0.369444, 16975, 'Basse-Normandie'],
                [49.443889, 1.103333, 20667, 'Haute-Normandie'],
                [47.21806, -1.55278, 48655, 'Pays de la Loire'],
                [49.9, 2.3, 26832, 'Picardie'],
                [46.581945, 0.336112, 31773, 'Poitou-Charentes'],
                [43.296346, 5.369889, 121459, 'Provence-Alpes-CÃ´te d\'Azur'],
                [-20.8789, 55.4481, 1736, 'La RÃ©union'],
                [45.759723, 4.842223, 89100, 'RhÃ´ne-Alpes'] 
            ];
            /* On boucle sur le tableau pour y placer les points */
            for (i = 0; i < tableau.length; i++) {
                
                var nbAnnonces = tableau[i][2];
                var couleur ="green";
                
                if (nbAnnonces > 20000) {
                    if (nbAnnonces > 50000) {
                        couleur = "red";
                    } else {
                        couleur = "orange";
                    }
                }
                /*
                 * On va crÃ©er un cercle sur la carte pour chaque point
                 */
                var circleLocation = new L.LatLng(tableau[i][0], tableau[i][1]),
                circleOptions = {
                    color: couleur,
                    fillColor: couleur,
                    fillOpacity: 0.5
                };
        
                var circle = new L.Circle(circleLocation,(7000 + (tableau[i][2]/4)), circleOptions);
                // on rajoute un popup sur le cercle
                circle.bindPopup(tableau[i][3]+ " : " + tableau[i][2]+" annonces");
                // on ajoute le cercle Ã  la carte
                map.addLayer(circle);