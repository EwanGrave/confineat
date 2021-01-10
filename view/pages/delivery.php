<?php declare(strict_types=1);
require_once "model/autoload.php";


//var_dump($data);

$p = new WebPage("Livraisons");

$p->appendContent(<<<HTML
<!--Corps principal de la page HTML-->
<main class="main">
HTML
);

$json_conv = json_encode([]);



if(count($data) != 0)
{





// Adresse du fichier
$file_path = 'view/csv/adresses_livraison.csv';

$fp = fopen($file_path, 'w');
if (count($data) > 0){
    for($i=0;$i<(count($data));$i++)
    {
        $donnees = array ($data[$i]['localisation']);
        fputcsv($fp,$donnees);
    }
}
fclose($fp);


// Ouverture du fichier
$file = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Lecture du fichier
foreach ($file as $line => $content)
{
    // var_dump(urlencode($content));

    // Récupération de l'URL au bon format
    $url_gmap    = 'https://api.opencagedata.com/geocode/v1/json?q=' . urlencode($content) . '&key=0583cc0bde4c4f758a5d65fe8760e4df';

    //var_dump($url_gmap);

    // Ouverture de l'URL au format JSON (sous forme d'un tableau de type Array)
    $json        = json_decode(file_get_contents($url_gmap), true);
    // Récupération des coordonnées dans le fichier JSON
    $coord       = $json['results'][0]['geometry'];
    // Ajout des coordonnées (lattitude et longitude) dans notre nouvelle ligne
    $file[$line] = $content . ',' . $coord['lat'] . ',' . $coord['lng'];
}

// Retour à la ligne pour chaque ligne
$file = implode("\n", $file);
// Insertion des données
file_put_contents($file_path, $file);


$file = fopen($file_path, "r");
$line = [];
while (!feof($file) ) {
    $line[] = fgetcsv($file, 1024);
}
fclose($file);
//var_dump($line);



    $donnees_map = [];
    for($i=0;$i<(count($line));$i++)
    {
        $donnees_map[$data[$i]['lastname'].' '.ucfirst($data[$i]['firstname'])] = ['lat'=>$line[$i][1],'lon'=>$line[$i][2]] ;
    }
    //var_dump($donnees_map);

    //json_decode($donnees_map);

    $json_conv = json_encode($donnees_map);

for($i=0;$i<(count($data));$i++)
{

    $idUser = $data[$i]['idUser'];
    $nom = $data[$i]['lastname'].' '.ucfirst($data[$i]['firstname']);
    $localisation = $data[$i]['localisation'];
    $idMenu = $data[$i]['idMenu'];
    $nameMenu = $data[$i]['name'].' '.ucfirst($data[$i]['firstname']);

    $p->appendContent(<<<HTML

    <div class="box12"> 
    <div>
        <p >{$nom}</p> 
        <p >{$localisation}</p>
        <p >{$nameMenu}</p>

        <input type='button' id='$idUser' value='Si livré' class='etat_livraison' onclick="setDelivered(this.id)"/>  

    </div>
    </div>

HTML
);


}                    


}

$p->appendContent(<<<HTML
<!-- </div>
  </div>  -->
    <div id="map">
	    <!-- Ici s'affichera la carte -->
    </div>


    <script type="text/javascript">
            // On initialise la latitude et la longitude de Reims (centre de la carte)
            //<?php echo json_encode($json_conv); ?>;
            var lat = 49.2577886;
            var lon =  4.031926;
            var adresses = $json_conv;
            //console.log(adresses);

            var road = [];



            var macarte = null;
            // Fonction d'initialisation de la carte
            function initMap() {
                // Créer l'objet "macarte" et l'insèrer dans l'élément HTML qui a l'ID "map"
                var macarte = L.map('map').setView([lat, lon], 13);
                // Leaflet ne récupère pas les cartes (tiles) sur un serveur par défaut. Nous devons lui préciser où nous souhaitons les récupérer. Ici, openstreetmap.fr
                L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
                    // Il est toujours bien de laisser le lien vers la source des données
                    attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
                    minZoom: 10,
                    maxZoom: 20
                }).addTo(macarte);


                //création du taleau des coordonnées
                for (adresse in adresses) {
                road.push(adresses[adresse].lat, adresses[adresse].lon);
                //console.log(adresse);
                }

                //console.log(road);

                //Nous définissons le trajet
                routingControl = L.Routing.control({
                    geocoder: L.Control.Geocoder.nominatim(),
                    waypoints: [
                    null
                    ],
                    // Nous personnalisons le tracé
                    lineOptions: {
                    styles: [{color: '#00bfff', opacity: 1, weight: 4}]
                    },
                    // Nous personnalisons la langue et le moyen de transport
                    router: new L.Routing.osrmv1({
                        language: 'fr',
                        profile: 'bike', // car, bike, foot
                    }),
                    //Nous n'affichons pas la barre de recherche au départ.
                    show : false,
                    routeWhileDragging: false,
                }).addTo(macarte);

                if (road.length == 2){
                    routingControl.setWaypoints([
                    L.latLng(49.2425706,4.0601551),
                    L.latLng(road[0], road[1]),
                    L.latLng(49.2425706,4.0601551)
                    ]);
                }else if (road.length == 4){
                    routingControl.setWaypoints([
                    L.latLng(49.2425706,4.0601551),
                    L.latLng(road[0], road[1]),
                    L.latLng(road[2], road[3]),
                    L.latLng(49.2425706,4.0601551)
                    ]);
                }else if(road.length == 6){
                    routingControl.setWaypoints([
                    L.latLng(49.2425706,4.0601551),
                    L.latLng(road[0], road[1]),
                    L.latLng(road[2], road[3]),
                    L.latLng(road[2], road[3]),
                    L.latLng(49.2425706,4.0601551)
                ]);
                }else if(road.length == 8){
                    routingControl.setWaypoints([
                    L.latLng(49.2425706,4.0601551),
                    L.latLng(road[0], road[1]),
                    L.latLng(road[2], road[3]),
                    L.latLng(road[4], road[5]),
                    L.latLng(road[6], road[7]),
                    L.latLng(49.2425706,4.0601551)
                ]);
                }else if(road.length == 10){
                    routingControl.setWaypoints([
                    L.latLng(49.2425706,4.0601551),
                    L.latLng(road[0], road[1]),
                    L.latLng(road[2], road[3]),
                    L.latLng(road[4], road[5]),
                    L.latLng(road[6], road[7]),
                    L.latLng(road[8], road[9]),
                    L.latLng(49.2425706,4.0601551)
                ]);
                }

            
                routingControl.on('routesfound', function(e) {
                var routes = e.routes;
                var summary = routes[0].summary;
                // alert distance and time in km and minutes
                //console.log('Total distance is ' + summary.totalDistance / 1000 + ' km and total time is ' + Math.round(summary.totalTime % 3600 / 60) + ' minutes');

                document.getElementsByClassName('distance')[0].innerHTML = summary.totalDistance / 1000
                document.getElementsByClassName('time')[0].innerHTML = Math.round(summary.totalTime % 3600 / 60)
                });


                // Nous parcourons la liste des adresses
                for (adresse in adresses) {
                
                    //Nous placons les marqueurs pour chaque adresse
                    var marker = L.marker([adresses[adresse].lat, adresses[adresse].lon]).addTo(macarte);                
                    // Nous ajoutons la popup. A noter que son contenu (ici la variable adresse) peut être du HTML
                    marker.bindPopup(adresse );
                    // sur le click du marker la popup s'ouvre
                    
                }


                //Ajout de l'adresse du restaurant sur la carte

                var myIcon = L.icon({
                    iconUrl: "view/img/icone/icone_restaurant.png",
                    iconSize: [40,40],
                    iconAnchor:[19,40],
                    popupAnchor: [0, -40],
                });
                var mark = L.marker([49.2425706, 4.0601551], { icon: myIcon }).addTo(macarte);
                mark.bindPopup('Confin\'eat');

            }
            window.onload = function(){
		// Fonction d'initialisation qui s'exécute lorsque le DOM est chargé
		initMap();
        
            };

        
    </script>


</main>
<h2> La distance totale est <b class='distance'>...</b> km et le temps total est estimé à <b class='time'>...</b>  minutes</h2>
HTML
);


$p->appendContent(<<<HTML

HTML
);


$p->appendContent(<<<HTML


 <!-- Fichiers Javascript -->
 <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
 <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>

HTML
);


$p->appendContent(<<<HTML
<script>

function setDelivered(idbasket) {
    
    console.log("toto1");

    if ( confirm( "Valider cette livraison ?" ) ) {
		new AjaxRequest(
		{
			url        : "index.php?action=delivered",
			method     : "post",
			handleAs   : "json",
			parameters : {
				idBasket     : idbasket
			},
			onSuccess : function(message) {
                console.log(message);
				document.location.href = "index.php?action=delivery";  
			},
			onError : function(status, message) {
                console.log("error");
				console.log(message);
			}
		});
    }

}








</script>
HTML
);


$p->appendCssUrl("view/css/accueil.css");
$p->appendCssUrl("view/css/overlay.css");
$p->appendCssUrl("view/css/overlay_img.css");
$p->appendJsUrl("view/js/overlay.js");
$p->appendJsUrl("view/js/ajaxrequest.js");

echo $p->toHTML();