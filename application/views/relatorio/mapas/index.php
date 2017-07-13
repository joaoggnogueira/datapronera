<style>

    .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }

    #mapa-select{
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        margin-top: 10px;
    }

    #pac-input {
        position: absolute;
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
        z-index: 10;
        text-transform: none;
    }

    #pac-input:focus {
        border-color: #4d90fe;
    }

    .pac-container {
        font-family: Roboto;
    }

    #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
    }

    #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
    }
    #target {
        width: 345px;
    }

    #map{
        height: calc(100vh - 100px);
        width: 100%;
        left: 0px;
        background-color: black;
        z-index: 9;
    }

    #content{
        width: 100% !important;
    }

    #middle{
        width: calc(100vw - 50px) !important;
        margin-top: 100px;
    }

    .option button{
        margin-right: 5px;
    }

    .labels{
        line-height: 100px;
    }

    #searchbutton{
        height: 32px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        margin-top: 10px;
    }
    table.table{
        width: 100% !important;
    }
    
</style>

<h1>Relatório de Mapas</h1>
<div id="map-wrapper">
    <select class="form-control" onchange="updateMap()" name="mapa" id="mapa-select">
        <option selected value="educando">Cidades dos Educandos</option>
        <option value="curso">Cidades das Caracterizações de Cursos ativos</option>
        <option value="instituicao">Cidades das Caracterizações de Instituições</option>
    </select>
    <button id="searchbutton" class="btn btn-primary glyphicon glyphicon-search"></button>
    <input id="pac-input" class="controls" type="text" placeholder="Pesquise a cidade aqui">
    <div id="map"></div>
</div>

<script>
    var infowindow = null;
    var markerwindow = null;
    var markerCluster = null;
    var map = null;
    var hashMarkers = null;

    function setCity(data) {
        var idCity = data[0];
        var position = {lat: parseFloat(data[3]), lng: parseFloat(data[4])};
        map.setCenter(position);
        map.setZoom(10);
        var trigger = new google.maps.event.trigger(hashMarkers[idCity], 'click');
    }

    function initMap() {
        var initialpos = {
            zoom: 4,
            center: {lat: -13.9731974397433545, lng: -51.92527999999999},
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: true,
            zoomControl: true,
            scaleControl: true,
            fullscreenControl: true
        };
        map = new google.maps.Map(document.getElementById('map'), initialpos);

        var input = document.getElementById('pac-input');
        $(input).hide();
        var searchBox = new google.maps.places.SearchBox(input);
        var selectbox = document.getElementById("mapa-select");
        var searchbutton = document.getElementById("searchbutton");

        $(searchbutton).click(function () {
            map.controls[google.maps.ControlPosition.TOP_LEFT].removeAt(1);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
            $(input).show();
            $(input).focus();
        });
        $(input).blur(function(){
            map.controls[google.maps.ControlPosition.TOP_LEFT].removeAt(1);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(searchbutton);            
        });

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(selectbox);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(searchbutton);

        //        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        map.addListener('bounds_changed', function () {
            searchBox.setBounds(map.getBounds());
        });
        var markers = [];


        searchBox.addListener('places_changed', function () {
            var places = searchBox.getPlaces();

            if (places.length === 0) {
                return;
            }

            markers.forEach(function (marker) {
                marker.setMap(null);
            });
            markers = [];

            var bounds = new google.maps.LatLngBounds();
            places.forEach(function (place) {
                if (!place.geometry) {
                    console.log("Returned place contains no geometry");
                    return;
                }
                var icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25)
                };

                markers.push(new google.maps.Marker({
                    map: map,
                    icon: icon,
                    title: place.name,
                    position: place.geometry.location
                }));

                if (place.geometry.viewport) {
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });

        $("#mapa-select").val("educando");
    }
    
    function init(){
        setTimeout(function(){
            updateMap();
        },1000);
    }
    
    function updateMap() {
        if (typeof (google) !== "undefined") {
            if (map === null) {
                initMap();
            } else {
                markerCluster.clearMarkers();

            }
        }
        switch ($("#mapa-select").val()) {
            case "educando":
                prepareMapaEducando();
                break;
            case "curso":
                prepareMapaCurso();
                break;
            case "instituicao":
                prepareMapaInstituicao();
                break;
        }
        if (infowindow) {
            infowindow.remove();
        }
    }

    function openWindow(buttons, marker, node) {

        var id = node.id;

        var createButton = function (buttonspec) {
            var button = document.createElement("button");
            button.type = "button";
            button.className = "btn btn-success";
            button.innerHTML = buttonspec.title;
            button.addEventListener("click", function () {
                buttonspec.action(id, button);
            });
            return button;
        };

        var pai = document.createElement("div");

        pai.innerHTML = "<table style='width:100%'>\
            <tr>\
                <td><h4>" + node.municipio + "<b> (" + node.estado + ")</b></h4></td>\
                <td><button class='close' aria-label='Close' onclick='closeWindow()'><span aria-hidden='true'>&times;</span></button></td>\
            </tr>\
        </table>";

        var option = document.createElement("div");
        option.className = "option";

        var buttonsr = [];

        for (var i = 0; i < buttons.length; i++) {
            buttonsr[i] = createButton(buttons[i]);
            option.appendChild(buttonsr[i]);
        }
        option.appendChild(document.createElement("p"));
        var table = document.createElement("table");
        table.style.width = "100%";
        table.className = "table table-striped table-bordered";
        option.appendChild(table);
        pai.appendChild(option);
        var div = $("<div/>").
                css("width", "600px").
                css("box-shadow", "2px 2px 5px rgba(0,0,0,0.3)").
                css("background", "white").
                css("position", "absolute").
                css("padding", "10px").
                css("margin", "5px").
                css("max-height", "calc(100% - 10px)").
                css("overflow-x", "hidden").
                css("overflow-y", "auto").
                css("right", "0px")
                .append(pai);

        closeWindow();
        marker.setIcon('<?= base_url('css/images/markerselected.png') ?>');
        div.hide();
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(div.get(0));
        markerwindow = marker;
        infowindow = div;
        map_recenter(markerwindow.getPosition(), 0, 0);
        
        if(buttons.length>=1){
            $(buttonsr[0]).click();
            if(buttons.length===1){
                $(buttonsr[0]).remove();
            }
        }
            
        div.slideDown(300);
    }

    function createMarker(node) {
        return new google.maps.Marker({
            position: {lng: parseFloat(node.lng), lat: parseFloat(node.lat)},
            icon: "<?= base_url('css/images/marker.png') ?>",
            label: {
                text: node.total,
                color: 'white',
                fontSize: '12px',
                x: '20',
                y: '70'
            },
            labelClass: "labels"
        });
    }

    function closeWindow() {
        if (infowindow) {
            map.controls[google.maps.ControlPosition.TOP_RIGHT].removeAt(0);
            infowindow.remove();
            infowindow = false;
            markerwindow.setIcon('<?= base_url('css/images/marker.png') ?>');
        }
    }

    function prepareMapaInstituicao() {
        $.get("<?php echo site_url('relatorio_mapas/get_municipios_instituicoes'); ?>", function (instituicoes) {
            hashMarkers = [];
            var markers = instituicoes.map(function (instituicao) {
                if (typeof (google) !== "undefined") {

                    var marker = new google.maps.Marker({
                        position: {lng: parseFloat(instituicao.lng), lat: parseFloat(instituicao.lat)},
                        icon: "<?= base_url('css/images/marker.png') ?>",
                        label: {
                            text: instituicao.total,
                            color: 'white',
                            fontSize: '12px',
                            x: '20',
                            y: '70'
                        }
                    });
                    hashMarkers[instituicao.id] = marker;
                    marker.addListener('click', function () {
                        openWindow([{title: "<i class='glyphicon glyphicon-education'></i> Listar instituições", action: getInstituicoes}], marker, instituicao);
                    });
                }
                return marker;
            });
            if (typeof (google) !== "undefined") {
                markerCluster = new MarkerClusterer(map, markers, {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
            }
        }, "json");

    }

    function prepareMapaCurso() {

        $.get("<?php echo site_url('relatorio_mapas/get_municipios_cursos'); ?>", function (cursos) {
            hashMarkers = [];
            var markers = cursos.map(function (curso) {

                if (typeof (google) !== "undefined") {
                    var marker = new google.maps.Marker({
                        position: {lng: parseFloat(curso.lng), lat: parseFloat(curso.lat)},
                        icon: "<?= base_url('css/images/marker.png') ?>",
                        label: {
                            text: curso.total,
                            color: 'white',
                            fontSize: '12px',
                            x: '20',
                            y: '70'
                        }
                    });
                    hashMarkers[curso.id] = marker;
                    marker.addListener('click', function () {
                        openWindow([{title: "<i class='glyphicon glyphicon-book'></i> Listar cursos", action: getCursos}], marker, curso);
                    });
                }
                return marker;
            });
            if (typeof (google) !== "undefined") {
                markerCluster = new MarkerClusterer(map, markers, {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
            }
        }, "json");

    }

    function prepareMapaEducando() {

        $.get("<?php echo site_url('relatorio_mapas/get_municipios_educandos'); ?>", function (educandos) {
            hashMarkers = [];
            var markers = educandos.map(function (educando) {

                if (typeof (google) !== "undefined") {
                    var marker = createMarker(educando);

                    hashMarkers[educando.id] = marker;
                    marker.addListener('click', function () {
                        openWindow([
                            {title: "<i class='glyphicon glyphicon-user'></i> Listar educandos", action: getEducandos},
                            {title: "<i class='glyphicon glyphicon-book'></i> Para estes <b>EDUCANDOS</b> listar cursos oferecidos", action: getCursosEducandos}
                        ], marker, educando);
                    });

                }
                return marker;
            });
            if (typeof (google) !== "undefined") {
                markerCluster = new MarkerClusterer(map, markers, {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
            }
        }, "json");

    }

    var tableopened = null;

    function appendTable(url, titles, btn, onselect) {

        var parent = $($(btn).parents(".option")[0]);
        var table = $(parent.find("table")[0]);
        parent.find("button").removeAttr("disabled");
        $(btn).attr("disabled", "disabled");
        var innerHTML = "<thead><tr>";

        for (var i = 0; i < titles.length; i++) {
            innerHTML += "<th style='width:" + ((100 / titles.length) * 400) + "px'> " + titles[i].toUpperCase() + " </th>";
        }

        innerHTML += "</tr></thead><tbody></tbody>";
        if (tableopened !== null) {
            tableopened.destroy();
        }
        table.html(innerHTML);
        tableopened = new Table({
            url: url,
            table: table,
            controls: null
        });
        tableopened.appendEvent(onselect);
    }

    function getCursos(id_municipio, btn) {
        appendTable("<?= site_url("relatorio_mapas/get_cursos/") ?>/" + id_municipio, ['codigo', 'curso', 'modalidade','instituição'], btn, 
            function(data){
                console.log(data);
            }
        );
    }

    function getInstituicoes(id_municipio, btn) {
        appendTable("<?= site_url("relatorio_mapas/get_instituicoes/") ?>/" + id_municipio, ['id', 'nome', 'sigla', 'unidade', 'curso'], btn);
    }

    function getEducandos(id_municipio, btn) {
        appendTable("<?= site_url("relatorio_mapas/get_educandos/") ?>/" + id_municipio, ['nome', 'assentamento', 'tipo', 'código sipra'], btn);
    }

    function getCursosEducandos(id_municipio, btn) {
        appendTable("<?= site_url("relatorio_mapas/get_cursos_educandos/") ?>/" + id_municipio, ['codigo', 'curso', 'modalidade'], btn);
    }

    function map_recenter(latlng, offsetx, offsety) {
        var point1 = map.getProjection().fromLatLngToPoint(
                (latlng instanceof google.maps.LatLng) ? latlng : map.getCenter()
                );
        var point2 = new google.maps.Point(
                ((typeof (offsetx) == 'number' ? offsetx : 0) / Math.pow(2, map.getZoom())) || 0,
                ((typeof (offsety) == 'number' ? offsety : 0) / Math.pow(2, map.getZoom())) || 0
                );
        map.setCenter(map.getProjection().fromPointToLatLng(new google.maps.Point(
                point1.x - point2.x,
                point1.y + point2.y
                )));
    }

</script>
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC6A2l8RrNfmBdbVI-kMjRHBoZmBa1e4IU&libraries=places&callback=init"></script>