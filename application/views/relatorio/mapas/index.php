<style>
  /* Always set the map height explicitly to define the size of the div
   * element that contains the map. */
  #map, #map2 {
    height: 700px;
  }
</style>


<h1>Relatório de Mapas</h1>

<h3>Cidades dos Cursos Ativos</h3>
<div id="map"></div>

<h3>Cidades dos Educandos</h3>
<div id="map2"></div>
        

 <script>
   function initMap() {
     var map = new google.maps.Map(document.getElementById('map'), {
       zoom: 4,
       center: {lat: -14.235004, lng: -51.92527999999999}
     });

     var map2 = new google.maps.Map(document.getElementById('map2'), {
       zoom: 4,
       center: {lat: -14.235004, lng: -51.92527999999999}
     });


     $.get("<?php echo site_url('requisicao/get_municipios_cursos'); ?>", function(cursos) {
        var positions = [];
        for(var i=0; i<cursos.length; i++){
          positions.push({lng: parseFloat(cursos[i].lng), lat: parseFloat(cursos[i].lat)});
        }
        // Create an array of alphabetical characters used to label the markers.
         var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

         // Add some markers to the map.
         // Note: The code uses the JavaScript Array.prototype.map() method to
         // create an array of markers based on a given "locations" array.
         // The map() method here has nothing to do with the Google Maps API.
         var markers = positions.map(function(location, i) {
           return new google.maps.Marker({
             position: location,
             label: labels[i % labels.length]
           });
         });

        // Add a marker clusterer to manage the markers.
        var markerCluster = new MarkerClusterer(map, markers,{imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
     }, "json");

     $.get("<?php echo site_url('requisicao/get_municipios_educandos'); ?>", function(educandos) {
        var positions = [];
        for(var i=0; i<educandos.length; i++){
          positions.push({lng: parseFloat(educandos[i].lng), lat: parseFloat(educandos[i].lat)});
        }
        // Create an array of alphabetical characters used to label the markers.
         var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

         // Add some markers to the map.
         // Note: The code uses the JavaScript Array.prototype.map() method to
         // create an array of markers based on a given "locations" array.
         // The map() method here has nothing to do with the Google Maps API.
         var markers = positions.map(function(location, i) {
           return new google.maps.Marker({
             position: location,
             label: labels[i % labels.length]
           });
         });

        // Add a marker clusterer to manage the markers.
        var markerCluster = new MarkerClusterer(map2 , markers,{imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
     }, "json");
   }

 </script>
 <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
    </script>
 <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC6A2l8RrNfmBdbVI-kMjRHBoZmBa1e4IU&callback=initMap"></script>