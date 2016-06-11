/*Initialisation de la carte*/

var map;
            /* initialisation de la fonction initmap */
            function initmap() {
                // paramétrage de la carte
                map = new L.Map('map');
                // création des "tiles" avec open street map
                var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
                var osmAttrib='Map data de OpenStreetMap';
                var osm = new L.TileLayer(osmUrl, {minZoom: 2, maxZoom: 10, attribution: osmAttrib});           
                // on centre sur la France
                map.setView(new L.LatLng(46.85, 2.3518),6);
                map.addLayer(osm);
            }
            /* on va procéder �  l'initialisation de la carte */
            initmap();
    
            /* Creation d'un tableau qui va contenir nos donnes */
            /*
             * Pour chaque elt du tableay on a les coordonnées géographiques
             * une valeur ainsi que le nom de la région française
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
                [47.24306, 6.02194, 7382, 'Franche-Comté'],
                [16, -61.73334, 1573, 'Guadeloupe'],
                [4.93461, -52.33033, 73, 'Guyane'],
                [48.856578, 2.351828, 148436, '�?le-de-France'],
                [43.611944, 3.877222, 63651, 'Languedoc-Roussillon'],
                [45.85, 1.25, 7475, 'Limousin'],
                [49.1203, 6.1778, 13408, 'Lorraine'],
                [14.6, -61.08334, 948, 'Martinique'],
                [-12.77889, 45.23151, 0, 'Mayotte'],
                [43.604482, 1.443962, 56363, 'Midi-Pyrénées'],
                [50.637222, 3.063333, 24487, 'Nord-Pas-de-Calais'],
                [49.183056, -0.369444, 16975, 'Basse-Normandie'],
                [49.443889, 1.103333, 20667, 'Haute-Normandie'],
                [47.21806, -1.55278, 48655, 'Pays de la Loire'],
                [49.9, 2.3, 26832, 'Picardie'],
                [46.581945, 0.336112, 31773, 'Poitou-Charentes'],
                [43.296346, 5.369889, 121459, 'Provence-Alpes-Côte d\'Azur'],
                [-20.8789, 55.4481, 1736, 'La Réunion'],
                [45.759723, 4.842223, 89100, 'Rhône-Alpes'] 
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
                 * On va créer un cercle sur la carte pour chaque point
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
                // on ajoute le cercle �  la carte
                map.addLayer(circle);
            }


/*

function InitialiserCarte() {
	
	var map = L.map('map').setView([45.7531152, 4.827906], 17);

	// create the tile layer with correct attribution
	var tuileUrl = 'http://{s}.tile.osm.org/{z}/{x}/{y}.png';
	
	var attrib='Map data � <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
	
	var osm = L.TileLayer(tuileUrl, {
		minZoom: 8, 
		maxZoom: 18, 
		attribution: attrib
	});
	
	//osm.addTo(map);

}
*/
/*
$(document).ready(function(){
	InitialiserCarte();
});
*/


