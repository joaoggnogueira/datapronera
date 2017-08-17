<?PHP
$publico = $this->session->userdata("publico");
?>
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
        margin-left: 5px;
        width: 270px;
    }
    #input-group-search .input-group-addon{
        position: absolute;
        width: 40px;
        z-index: 11;
    }
    #pac-input {
        position: absolute;
        background-color: #fff;
        font-family: Roboto;
        margin-left: 40px;
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
        z-index: 10000 !important;
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
    .dataTables_wrapper{
        max-height: calc(100vh - 250px);
        overflow-x: hidden;
        overflow-y: auto;
    }
    #map{
        height: calc(100vh - 100px);
        width: 100%;
        left: 0px;
        background-color: black;
        z-index: 9;
    }

    .BADGE{
        display: inline-block;
        min-width: 10px;
        padding: 3px 7px;
        font-size: 12px;
        font-weight: bold;
        line-height: 1;
        color: #ffffff;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        background-color: #999999;
        border-radius: 10px;
    }

    #content{
        width: 100% !important;
    }

    #middle{
        width: calc(100vw - 100px) !important;
        margin-top: 100px;
    }

    #content{
        padding: 0px !important;
    }

    .option button{
        margin-right: 5px;
    }

    .labels{
        line-height: 100px;
    }
    .panel-search .panel-heading{
        background: rgb(71,164,71);
        color: white !important;
    }
    #searchbutton{
        height: 32px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        margin-top: 10px;
    }
    table.table{
        width: 100% !important;
    }

    .modal{
        z-index: 10001;
    }

    .modal-backdrop.fade.in{
        z-index: 10000;
    }
    .desc .input-group-addon{
        border-radius: 4px !important;
        border: 1px solid rgb(204, 204, 204);
        background: white;
        padding: 0px !important;
    }
    .desc label{
        padding-bottom: 6px;
        padding-left: 12px;
        padding-right: 12px;
        padding-top: 6px;
        height: 25px;
        line-height: 25px;
    }

    #options{
        max-height: calc(100% - 100px);
        min-width: 300px;
        overflow-x: hidden;
        overflow-y: auto;
        display: none;
        margin-top: 10px;
    }

    #filters,#markersconfig{
        padding: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        margin: 10px;
        background: rgba(255,255,255,0.8);
    }
    #filters > summary, #markersconfig > summary{
        padding: 10px;
        padding-top: 0px;
        padding-bottom: 0px;
    }

    #filters summary,#markersconfig summary{
        cursor: pointer;
        -webkit-touch-callout: none; /* iOS Safari */
        -webkit-user-select: none; /* Safari */
        -khtml-user-select: none; /* Konqueror HTML */
        -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
        user-select: none; /* Non-prefixed version, currently
                              supported by Chrome and Opera */
    }

    #filters summary:hover,#markersconfig summary:hover{
        font-weight: bold;
    }

    #filters ul,#tipo_marker{
        margin-top: 10px;
        padding: 0px;
    }

    #filters label{
        line-height: 20px;
    }

    #filters li{
        padding: 10px;
        background: white;
        margin-left: 10px;
        cursor: pointer;
        margin: 10px;
        list-style: none;
    }

    #filters[open=''] > summary,#markersconfig[open=''] > summary{
        font-size: 12px;
    }

    #filters[open=''],#markersconfig[open='']{
        padding: 5px;
        padding-top: 10px;
    }

    #filters > summary,#markersconfig > summary{
        font-size: 18px;
    }

    #filters details > summary{
        font-size: 13px;
    }
    #markersconfig label{
        margin-top: 10px;
        padding-left: 10px;
    }
    #markersconfig ul{
        padding: 10px;
        padding-left: 20px;
    }
    .control-chk{
        font-size: 13px;
        padding: 5px;
    }
    
    #options > summary{
        background: rgba(255,255,255,0.5);
        font-size: 20px;
        padding: 10px;
        margin: 10px;
    }

</style>
<details id="options">
    <summary><span class="fa fa-cogs"> Opções</span></summary>
    <details id="markersconfig" style="max-width: 300px;">
        <summary>MARCADORES</summary>
        <select id="tipo_marker" class="form-control option" style="width: 250px;">
            <option value="group">Com Agrupamento</option>
            <option value="normal">Sem Agrupamento</option>
            <option value="circle">Circulo Ponderado</option>
        </select>
        <label>Observações:</label>
        <ul>
            <li><b>Com agrupamento: </b>Marcadores muito próximos serão agrupados</li>  
            <li><b>Sem agrupamento: </b>Pode levar muito tempo para processar devido a quantidade de marcadores</li>  
            <li><b>Circulo Ponderado: </b>Não possui interação, mas permite ver a concentração de caracterizações</li>  
        </ul>
    </details>
    <details id="filters">
        <summary>FILTROS</summary>
        <ul>
            <li>
                <details class='filter-option'>
                    <summary>Status do Curso</summary>
                    <hr/>
                    <span><a class="btn btn-default all control-chk">Selecionar tudo</a></span>
                    <span><a class="btn btn-default one control-chk">Selecionar um</a></span>
                    <hr/>
                    <div class="checkbox">
                        <label><input class='filter option status-filter' checked value="AN" type="checkbox"/>ANDAMENTO</label>
                    </div>
                    <div class="checkbox">
                        <label><input class='filter option status-filter' checked value="CC" type="checkbox"/>CONCLUIDO</label>
                    </div>
                    <div class="checkbox">
                        <label><input class='filter option status-filter' checked value="2P" type="checkbox"/>PNERA II</label>
                    </div>
                </details>
            </li>
            <li>
                <details class='filter-option'>
                    <summary>Modalidade</summary>
                    <hr/>
                    <span><a class="btn btn-default all control-chk">Selecionar tudo</a></span>
                    <span><a class="btn btn-default one control-chk">Selecionar um</a></span>
                    <hr/>
                    <?PHP foreach ($modalidades as $modalidade): ?>
                        <div class="checkbox">
                            <label><input class='filter option modalidade-filter' checked value="<?= $modalidade->id ?>" type="checkbox"/><?= $modalidade->nome ?></label>
                        </div>
                    <?PHP endforeach; ?>
                </details>
            </li>
        </ul>
    </details>
</details>
<div class="panel panel-default" style="margin-bottom: 0px">
    <div class="panel-heading" style="height: 50px !important;">
        <div class="col-md-7">    
            <h5><b>Relatório de Mapas</b></h5>
        </div>
        <div style="text-align: right;" class="col-md-5">
            <span id="loadingmarkers"><i class="glyphicon glyphicon-refresh"></i> Carregando ...</span>
            <a class="btn btn-success" id="search-curso" data-toggle="modal" data-target="#searchCursoModal">
                Buscar curso <i class="glyphicon glyphicon-search"></i>
            </a>
            <a class="btn btn-success" id="search-educando" data-toggle="modal" data-target="#searchEducandoModal">
                Buscar Educando <i class="glyphicon glyphicon-search"></i>
            </a>
            <a class="btn btn-primary" data-toggle="modal" data-target="#helpModal">
                Ajuda <i class="glyphicon glyphicon-question-sign"></i>
            </a>
        </div>
    </div>
    <div class="panel-body" style="padding: 0px">
        <div id="map-wrapper">
            <select style="display: none" class="form-control" onchange="updateMap()" name="mapa" id="mapa-select">
                <option selected value="educando">Educandos por município de origem</option>
                <option value="curso">Cursos por município de realização</option>
            </select>
            <div id="input-group-search" style="display: none" class="input-group">
                <span class="input-group-addon controls"><i class="glyphicon glyphicon-search"></i></span>
                <input id="pac-input" class="controls" type="text" placeholder="Pesquise o município aqui">
            </div>

            <div id="map">
                <p id="loading" style="color:white;padding-top: 90px;text-align: center">
                    <i class="glyphicon glyphicon-map-marker"></i> 
                    Carregando<br/><br/>
                    <i style="text-decoration: none;font-size: 30px">Google Maps</i><br/><br/>
                    Aguarde ...
                    <b class="problem"></b>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    var infowindow = null;
    var markerwindow = null;
    var markerCluster = null;
    var map = null;
    var hashMarkers = null;
    var lastType = "";

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
        $("#loading").remove();

        map = new google.maps.Map(document.getElementById('map'), initialpos);

        var input = document.getElementById('pac-input');
        var selectbox = document.getElementById("mapa-select");
        var inputgroup = document.getElementById("input-group-search");
        var config = document.getElementById("options");

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(selectbox);

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(inputgroup);
        map.controls[google.maps.ControlPosition.LEFT].push(config);

        $(inputgroup).fadeIn(1000);
        $(selectbox).fadeIn(1000);
        setTimeout(function () {
            $(config).slideDown(1000);
        }, 1000);

        $(config).find("#tipo_marker").change(updateTypeMarker);
        $(config).find("input[type='checkbox']").change(updateFilters);
        
        $(config).find(".control-chk.all").click(checkAll);
        $(config).find(".control-chk.one").click(checkOne);
        
        var options = {
            types: ['(cities)'],
            componentRestrictions: {country: 'br'}
        };
        var autocomplete = new google.maps.places.Autocomplete(input, options);

        autocomplete.bindTo('bounds', map);

        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                $.ajax({
                    url: "http://maps.google.com/maps/api/geocode/json?address=" + input.value + "&types=(cities)&components=country:BR",
                    type: 'POST',
                    dataType: 'json',
                    timeout: 20000,
                    success: function (data) {
                        if (data.results.length !== 0) {
                            place = data.results[0];
                            input.value = place.formatted_address;
                            map.setCenter(place.geometry.location);
                            map.setZoom(10);
                        } else {
                            window.alert("Nenhum município encontrado com" + input.value);
                        }
                    },
                    error: function (data) {
                        window.alert("Falha na busca");
                        console.log(data);
                    }
                });
                return;
            }

            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(10);
            }
        });

        $("#mapa-select").val("educando");
    }

    function init() {
        setTimeout(function () {
            updateMap();
        }, 1000);
    }
    
    function checkAll(event){
        console.log(event);
        $(event.target).parents(".filter-option").eq(0).find("input[type='checkbox']").each(function(){
            this.checked = true;
        });
        updateMap();
    }
    
    function checkOne(event){
        $(event.target).parents(".filter-option").eq(0).find("input[type='checkbox']").each(function(){
            this.checked = false;
        });
        $(event.target).parents(".filter-option").eq(0).find("input[type='checkbox']").get(0).checked = true;
        updateMap();
    }
    
    function updateTypeMarker(event) {
        switch (event.target.value) {
            case "normal":
                setTimeout(function () {
                    alert("Aguarde até que todos os marcadores sejão colocados. Isso pode levar um tempo");
                }, 1);

                break;
        }
        updateMap();
    }

    function updateFilters(event) {

        if ($(event.target).parents(".filter-option").eq(0).find(".filter:checked").length === 0) {
            event.target.checked = true;
        } else {
            updateMap();
        }

    }

    function getFilter() {

        var data = {
            "status": [],
            "modalidade": {"ids": [], "nil": false}
        };

        $("#filters").find(".status-filter:checked").each(function () {
            data.status.push(this.value);
        });
        $("#filters").find(".modalidade-filter:checked").each(function () {
            if (this.value !== "NULL") {
                data.modalidade.ids.push(this.value);
            } else {
                data.modalidade.nil = true;
            }
        });
        return data;
    }

    function updateMap() {
        if (typeof (google) !== "undefined") {
            if (map === null) {
                initMap();
            } else {
                if (markerCluster) {
                    markerCluster.clearMarkers();
                    markerCluster = null;
                    hashMarkers.length = 0;
                } else {
                    for (var key in hashMarkers) {
                        if (hashMarkers[key].setMap) {
                            hashMarkers[key].setMap(null);
                        }
                    }
                    hashMarkers.length = 0;
                }
                var searchEducandoBtn = document.getElementById('search-educando');
                searchEducandoBtn.style.display = "none";
                var searchCursoBtn = document.getElementById('search-curso');
                searchCursoBtn.style.display = "none";
                $("#options .input").attr('disabled', 'disabled');
                $("#loadingmarkers").show();
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
            var li = document.createElement("li");
            var a = document.createElement("a");
            a.style.cursor = "pointer";
            a.innerHTML = buttonspec.title;
            li.addEventListener("click", function () {
                buttonspec.action(id, li);
            });
            li.appendChild(a);

            return li;
        };

        var pai = document.createElement("div");
        pai.className = "panel-body";
        var ul = document.createElement("ul");
        var option = document.createElement("div");
        option.className = "option";
        option.appendChild(ul);
        ul.className = "nav nav-tabs";
        var buttonsr = [];

        for (var i = 0; i < buttons.length; i++) {
            buttonsr[i] = createButton(buttons[i]);
            ul.appendChild(buttonsr[i]);
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
                css("margin", "5px").
                css("right", "0px").
                addClass("panel").addClass("panel-default")
                .append(
                        $("<div/>").
                        addClass("panel-heading").css("margin-left", "auto").css("margin-right", "auto").css("width", "100%").addClass("row").
                        html("<h5 class='col-md-11' style='margin-top:0px;margin-bottom:0px'><i class='glyphicon glyphicon-map-marker'></i> " + node.municipio + "<b> (" + node.estado + ")</b></h5>\
                         <div class='col-md-1'><button class='close' aria-label='Close' onclick='closeWindow()'><span aria-hidden='true'>&times;</span></button></div>")
                        )
                .append(pai);

        closeWindow();
        marker.setIcon('<?= base_url('css/images/markerselected.png') ?>');
        div.hide();
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(div.get(0));
        markerwindow = marker;
        infowindow = div;
        map_recenter(markerwindow.getPosition(), 0, 0);
        $(buttonsr[0]).click();
        if (buttons.length === 1) {
            $(ul).remove();
        }

        div.slideDown(300);
    }

    function createMarker(node) {
        if (!typeMarkerIs("circle")) {
            var marker_data = {
                position: {lng: parseFloat(node.lng), lat: parseFloat(node.lat)},
                icon: "<?= base_url('css/images/marker.png') ?>",
                label: {
                    text: node.total,
                    title: node.municipio,
                    color: 'white',
                    fontSize: '12px',
                    x: '20',
                    y: '70'
                },
                labelClass: "labels"
            };

            if (typeMarkerIs("normal")) {
                marker_data.map = map;
            }
            return new google.maps.Marker(marker_data);
        } else {
            var circle = new google.maps.Circle({
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35,
                map: map,
                center: {lng: parseFloat(node.lng), lat: parseFloat(node.lat)},
                radius: node.total * 100 + 10000
            });
            return circle;
        }

    }

    function typeMarkerIs(type) {
        return $("#tipo_marker").val() === type;
    }

    function closeWindow() {
        if (infowindow) {
            map.controls[google.maps.ControlPosition.TOP_RIGHT].removeAt(0);
            infowindow.remove();
            infowindow = false;
            markerwindow.setIcon('<?= base_url('css/images/marker.png') ?>');
        }
    }

    //desabilitado
    function prepareMapaInstituicao() {
        $.get("<?php echo site_url('relatorio_mapas/get_municipios_instituicoes'); ?>", {filters: getFilter()}, function (instituicoes) {
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

        var get = $.get("<?php echo site_url('relatorio_mapas/get_municipios_cursos'); ?>", {filters: getFilter()}, function (cursos) {
            hashMarkers = [];
            var markers = cursos.map(function (curso) {

                if (typeof (google) !== "undefined") {
                    var marker = createMarker(curso);
                    hashMarkers[curso.id] = marker;
                    marker.addListener('click', function () {
                        var data = [
                            {title: "<i class='glyphicon glyphicon-book'></i> Listar cursos", action: getCursos}
                        ];
                        <?PHP if (!$publico): ?>
                            data.push({title: "<i class='glyphicon glyphicon-education'></i> Para estes <b>CURSOS</b> listar educandos", action: getEducandosCursos});
                        <?PHP endif; ?>
                        openWindow(data, marker, curso);

                    });
                }
                return marker;
            });
            if (typeof (google) !== "undefined" && typeMarkerIs("group")) {
                markerCluster = new MarkerClusterer(map, markers, {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
            }
            $("#loadingmarkers").hide();
            $("#options .input").removeAttr('disabled');
            var searchCursoBtn = document.getElementById('search-curso');
            searchCursoBtn.style.display = "inline-block";

        }, "json");
        console.log(get);
    }

    function prepareMapaEducando() {
        var get = $.get("<?php echo site_url('relatorio_mapas/get_municipios_educandos'); ?>", {filters: getFilter()}, function (educandos) {
            hashMarkers = [];
            var markers = educandos.map(function (educando) {

                if (typeof (google) !== "undefined") {
                    var marker = createMarker(educando);

                    hashMarkers[educando.id] = marker;
                    <?PHP if (!$publico): ?>
                    marker.addListener('click', function () {
                        
                        openWindow([
                            {title: "<i class='glyphicon glyphicon-user'></i> Listar educandos", action: getEducandos},
                            {title: "<i class='glyphicon glyphicon-book'></i> Para estes <b>EDUCANDOS</b> listar cursos oferecidos", action: getCursosEducandos}
                        ], marker, educando);
                    });
                    <?PHP endif; ?>

                }
                return marker;
            });
            if (typeof (google) !== "undefined" && typeMarkerIs("group")) {
                markerCluster = new MarkerClusterer(map, markers, {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
            }
            $("#loadingmarkers").hide();
            $("#options .input").removeAttr('disabled');
<?PHP if (!$publico): ?>
                var searchEducandoBtn = document.getElementById('search-educando');
                searchEducandoBtn.style.display = "inline-block";
<?PHP endif; ?>
        }, "json");
        console.log(get);
    }

    var tableopened = null;

    function appendTable(url, titles, btn, onselect, search) {

        var parent = $($(btn).parents(".option")[0]);
        var table = $(parent.find("table")[0]);
        $(".option li").removeClass("active");
        $(btn).addClass("active");
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
            data: {filters: getFilter()},
            url: url,
            table: table,
            controls: null
        });
        tableopened.appendEvent(onselect);
        if (search) {
            $(".dataTables_wrapper input").val(search).keyup();
        }
    }

    function getCursos(id_municipio, btn) {
        appendTable("<?= site_url("relatorio_mapas/get_cursos/") ?>/" + id_municipio, ['codigo', 'curso', 'modalidade', 'instituição', 'total educandos <span class="badge">nacional</span>'], btn,
                function (data) {
                    getEducandosCursos(id_municipio, $(".option li:nth-child(2)").get(0), data[0]);
                });
    }

    function getInstituicoes(id_municipio, btn) {
        appendTable("<?= site_url("relatorio_mapas/get_instituicoes/") ?>/" + id_municipio, ['id', 'nome', 'sigla', 'unidade', 'curso'], btn);
    }

<?PHP if (!$publico): ?>

        function getEducandos(id_municipio, btn, search) {
            appendTable("<?= site_url("relatorio_mapas/get_educandos/") ?>/" + id_municipio, ['nome', 'assentamento', 'código sipra', 'código curso'], btn, false, search);
        }

        //Lista Educandos do mapa Curso
        function getEducandosCursos(id_municipio, btn, search) {
            appendTable("<?= site_url("relatorio_mapas/get_educandos_cursos/") ?>/" + id_municipio, ["educando", "Cidade", "nome do território", "tipo do território", "código curso"], btn, false, search);
        }

        //Lista Cursos do mapa Educando
        function getCursosEducandos(id_municipio, btn) {
            appendTable("<?= site_url("relatorio_mapas/get_cursos_educandos/") ?>/" + id_municipio, ['codigo', 'curso', 'modalidade', 'total educandos <span class="badge">no município</span>'], btn,
                    function (data) {
                        getEducandos(id_municipio, $(".option li:nth-child(1)").get(0), data[0]);
                    });
        }

<?PHP endif; ?>

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
<div class="modal fade" id="helpModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content panel panel-info">
            <div class="modal-header panel-heading">
                Ajuda <i class="glyphicon glyphicon-question-sign"></i>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <ul class="nav nav-tabs" id="tabHelp">
                <li class="active"><a data-toggle="tab" href="#marcadores">Marcadores</a></li>
                <li><a data-toggle="tab" href="#agrupamentos">Agrupamentos</a></li>
                <li><a data-toggle="tab" href="#outros">Outros</a></li>
            </ul>
            <div class="tab-content">
                <div id="marcadores" class="modal-body tab-pane fade in active">
                    <label>Vamos começar com algumas informações básicas</label>
                    <hr/>
                    <div class="input-group desc">
                        <span class="input-group-addon"><img src="<?= base_url('css/images/marker.png') ?>" width="37" height="37"/></span>
                        <label>Esse marcador representa um múnicipio</label>
                    </div>
                    <hr/>
                    <div class="input-group desc">
                        <span class="input-group-addon" style='height: 37px'><img src="<?= base_url('css/images/markerexample.png') ?>" width="40" height="37"/></span>
                        <label>O número representa a quantidade caracterizações de:</label>
                        <ul>
                            <li><b>Cursos</b>, ou seja, a quantidade de cursos foram realizados no município</li>
                            <li><b>Educandos</b>, ou seja, a quantidade de educandos tem origem no município</li>
                        </ul>
                    </div>
                    <hr/>
                    <div class="alert alert-info"><i class="glyphicon glyphicon-hand-up"></i> Clique no marcador para visualizar informações sobre as caracterizações !</div>
                    <br/>
                    <?PHP if ($publico): ?>
                        <div class="alert alert-danger"><i class="fa fa-exclamation"></i> No modo de acesso público, não é possível visualizar informações educandos</div>
                    <?PHP endif; ?>
                    <hr/>
                    <div style="text-align: right">
                        <a class="btn btn-primary" onclick="$('#tabHelp > li:nth-child(2) > a').click();">Continuar <i class="glyphicon glyphicon-chevron-right"></i></a>
                    </div>
                </div>
                <div id="agrupamentos" class="modal-body tab-pane fade">
                    <label>Os seguintes símbolos representam agrupamento de marcadores e a cor indica a granularidade em relação aos demais</label>
                    <hr/>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group desc">
                                <span class="input-group-addon"><img src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m1.png" width="37" height="37"/></span>
                                <label>Baixa</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group desc">
                                <span class="input-group-addon"><img src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m2.png" width="37" height="37"/></span>
                                <label>Média</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group desc">
                                <span class="input-group-addon"><img src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m3.png"  width="37" height="37"/></span>
                                <label>Alta</label>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="input-group desc">
                        <span class="input-group-addon"><img src="<?= base_url('css/images/clusterexample.png') ?>"  width="42" height="37"/></span>
                        <label>O número no interior representa a quantidade de marcadores acumulados nele</label>
                    </div>
                    <hr/>
                    <div class="alert alert-info"><i class="glyphicon glyphicon-hand-up"></i> Clique no marcador de agrupamento para ampliar o mapa, e visualizar os marcadores agrupados !</div>
                    <div style="text-align: right">
                        <a class="btn btn-primary" onclick="$('#tabHelp > li:nth-child(3) > a').click();">Continuar <i class="glyphicon glyphicon-chevron-right"></i></a>
                    </div>
                </div>
                <div id="outros" class="modal-body tab-pane fade">
                    <label>Por fim, algumas fucionalidades que podem ajduar na visualização</label>
                    <hr/>
                    <div class="input-group desc">
                        <span class="input-group-addon"><img src="<?= base_url('css/images/mapaselectExample.png') ?>" width="150" height="37"/></span>
                        <label>Selecione o Mapa no canto superior a esquerda</label>
                    </div>
                    <hr/>
                    <div class="input-group desc">
                        <span class="input-group-addon"><a class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></a></span>
                        <label>Use este ícone para pesquisar um município </label>
                    </div>
                    <hr/>
                    <div class="input-group desc">
                        <span class="input-group-addon"><img src="<?= base_url('css/images/fullscreen.png') ?>" width="37" height="37"></span>
                        <label>Use este ícone abrir o mapa em modo tela cheia</label>
                    </div>
                    <hr/>
                    <div style="text-align: right">
                        <a class="btn btn-primary" data-dismiss="modal">Fechar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="searchCursoModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content panel panel-search">
            <div class="modal-header panel-heading">
                <i class="fa fa-bookmark"></i> Buscar Curso 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="glyphicon glyphicon-remove"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <label>Digite abaixo o nome (ou parte do nome) do curso</label>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="input-group">
                                <span style="height: 34px" class="input-group-addon glyphicon glyphicon-search"></span>
                                <input type="search" name="search" style="text-transform: uppercase;margin: 1px 0px" class="form-control"/>      
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-success">Buscar</button>
                        </div>
                    </div>
                    <br/>
                    <div class="alert alert-success">
                        A busca será realizada de acordo com os filtros escolhidos no mapa!
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    </div>
                    <div class="alert alert-success">
                        Não utilizar acentuação!
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    </div>
                </form>
                <hr/>
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th> ID_MUN </th>
                            <th> CURSO </th>
                            <th> MUNICÍPIO </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?PHP if (!$publico): ?>
    <div class="modal fade" id="searchEducandoModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content panel panel-search">
                <div class="modal-header panel-heading">
                    <i class="fa fa-graduation-cap"></i> Buscar Município de Origem do Educando 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="glyphicon glyphicon-remove"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <label>Digite abaixo o nome (ou parte do nome) do educando</label>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="input-group">
                                    <span style="height: 34px" class="input-group-addon glyphicon glyphicon-search"></span>
                                    <input type="search" name="search" style="text-transform: uppercase; margin: 1px 0px" class="form-control"/>    
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-success">Buscar</button>
                            </div>
                        </div>
                        <br/>
                        <div class="alert alert-success">
                            A busca será realizada de acordo com os filtros escolhidos no mapa!
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        </div>
                        <div class="alert alert-success">
                            Não utilizar acentuação!
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        </div>
                    </form>
                    <hr/>
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th> ID_MUN </th>
                                <th> NOME </th>
                                <th> CURSO </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?PHP endif; ?>
<script>
    $(document).ready(function () {
        var searchCursoBtn = document.getElementById('search-curso');
        var searchEducandoBtn = document.getElementById('search-educando');
        searchCursoBtn.style.display = "none";
        searchEducandoBtn.style.display = "none";
        $(document.body).append($("#helpModal"));
        setTimeout(function () {
            if ($("#loading").length !== 0) {
                $("#loading .problem").html("<br/>Esta demorando muito!");
                setTimeout(function () {
                    $("#loading .problem").html("<br/>Esta demorando muito!<br/>Verifique se está conectado com a internet!");
                }, 1000);
            }
        }, 10000);

        var tableSearchCursoModal = null;

        $('#searchCursoModal').on('shown.bs.modal', function () {
            $(this).find("input[type='search']").focus();
            if (tableSearchCursoModal === null) {
                $(this).find("table").hide();
            }
        });

        $("#searchCursoModal form").submit(function (e) {
            e.preventDefault();
        });

        $("#searchCursoModal form").submit(function (e) {
            e.preventDefault($(this).find("input[type='search']").val());
            var term = $(this).find("input[type='search']").val().toUpperCase();
            var table = $("#searchCursoModal").find("table").eq(0);

            if (tableSearchCursoModal !== null) {
                tableSearchCursoModal.destroy();
            }
            table.show();
            tableSearchCursoModal = new Table({
                data: {filters: getFilter()},
                url: "<?= site_url("relatorio_mapas/search_curso/") ?>/" + term,
                table: table,
                controls: null
            });
            tableSearchCursoModal.hideColumns([0]);
            tableSearchCursoModal.appendEvent(function (data) {
                var marker = hashMarkers[data[0]];
                map_recenter(marker.getPosition(), 0, 0);
                map.setZoom(15);
                $("#searchCursoModal").modal('hide');
            });
        });

        $('#searchEducandoModal').on('shown.bs.modal', function () {
            $(this).find("input[type='search']").focus();
            if (tableSearchEducandoModal === null) {
                $(this).find("table").hide();
            }
        });

        var tableSearchEducandoModal = null;

        $("#searchEducandoModal form").submit(function (e) {
            e.preventDefault($(this).find("input[type='search']").val());
            var term = $(this).find("input[type='search']").val().toUpperCase();
            var table = $("#searchEducandoModal").find("table").eq(0);

            if (tableSearchEducandoModal !== null) {
                tableSearchEducandoModal.destroy();
            }
            table.show();
            tableSearchEducandoModal = new Table({
                data: {filters: getFilter()},
                url: "<?= site_url("relatorio_mapas/search_educando/") ?>/" + term,
                table: table,
                controls: null
            });
            tableSearchEducandoModal.hideColumns([0]);
            tableSearchEducandoModal.appendEvent(function (data) {
                var marker = hashMarkers[data[0]];
                map_recenter(marker.getPosition(), 0, 0);
                map.setZoom(15);
                $("#searchEducandoModal").modal('hide');
            });
        });
    });
</script>