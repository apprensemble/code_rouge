            var map;
            /* initialisation de la fonction initmap */
            function initmap() {
                // paramÃ©trage de la carte
                map = new L.Map('map');
                // crÃ©ation des "tiles" avec open street map
                var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
                var osmAttrib='Map data de OpenStreetMap';
                var osm = new L.TileLayer(osmUrl, {minZoom: 2, maxZoom: 18, attribution: osmAttrib});           
                // on centre sur la France
                map.setView(new L.LatLng(45.7531152, 4.827906),14);
                map.addLayer(osm);
							var marker = L.marker(new L.LatLng(45.7531152, 4.827906)).bindPopup("test").addTo(map);
            }
			<!--  -->

			
 			/* on va procÃ©der Ã  l'initialisation de la carte */
            initmap();
			
			/*on tente d'ajouter un marker*/

			

		//	marker.bindPopup("Exemple de texte").openPopup();	
                        var map;
            /* initialisation de la fonction initmap */
            function initmap() {
                // paramÃ©trage de la carte
                map = new L.Map('map');
                // crÃ©ation des "tiles" avec open street map
                var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
                var osmAttrib='Map data de OpenStreetMap';
                var osm = new L.TileLayer(osmUrl, {minZoom: 2, maxZoom: 18, attribution: osmAttrib});           
                // on centre sur la France
                map.setView(new L.LatLng(45.7531152, 4.827906),14);
                map.addLayer(osm);
							var marker = L.marker(new L.LatLng(45.7531152, 4.827906)).bindPopup("test").addTo(map);
            }
			<!--  -->

			
 			/* on va procÃ©der Ã  l'initialisation de la carte */
            initmap();
			
			/*on tente d'ajouter un marker*/

			

		//	marker.bindPopup("Exemple de texte").openPopup();	
            