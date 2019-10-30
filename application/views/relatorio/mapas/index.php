<?PHP
if ($this->session->userdata("publico")) {
    $publico = !$this->session->userdata("permissao_publica");
} else {
    $publico = false;
}
if (!isset($modalidades)) :
    ?>
    <script>
        request('<?php echo site_url('relatorio_mapas/index'); ?>', null, 'hide');
    </script>
<?PHP
    return;
endif;
?>
<link async type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/mapa.css" />
<link async type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/tagify.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>js/tagify.min.js"></script>
<div class="panel panel-default" style="margin-bottom: 0px">
    <div class="panel-heading" style="height: 50px !important;">
        <div class="col-md-7">
            <?PHP $this->load->view('relatorio/mapas/toolbar.php', array("srAtual" => $sr, "tipo_instrumentos" => $tipo_instrumentos, "modalidades" => $modalidades, "superintendencias" => $superintendencias)); ?>
        </div>
        <div style="text-align: right;" class="col-md-5">
            <span class="btn btn-primary" id="loadingmarkers">
                <div class="lds-dual-ring"></div>
            </span>
            <a class="btn btn-success" id="search-curso" data-toggle="modal" data-target="#searchCursoModal">
                Buscar curso <i class="glyphicon glyphicon-search"></i>
            </a>
            <a class="btn btn-success" id="search-educando" data-toggle="modal" data-target="#searchEducandoModal">
                Buscar Educando <i class="glyphicon glyphicon-search"></i>
            </a>
            <a class="btn btn-primary" id="helpModalBtn" data-toggle="modal" data-target="#helpModal">
                Ajuda <i class="glyphicon glyphicon-question-sign"></i>
            </a>
        </div>
    </div>
    <div class="panel-body" style="padding: 0px">
        <div id="map-wrapper">
            <div id="input-group-search" style="display: none" class="input-group">
                <span class="input-group-addon controls"><i class="glyphicon glyphicon-search"></i></span>
                <input id="pac-input" class="controls" type="text" placeholder="Pesquise o município aqui" />
            </div>

            <div id="map">
                <p id="loading" style="color:white;padding-top: 90px;text-align: center">
                    <i class="glyphicon glyphicon-map-marker"></i>
                    Carregando<br /><br />
                    <i style="text-decoration: none;font-size: 30px">Google Maps</i><br /><br />
                    <span class="lds-dual-ring"></span> Aguarde ...
                    <b class="problem"></b>
                </p>
            </div>
        </div>
    </div>
</div>

<div id="footer_relacoes">
    <h3>Relações</h3>
    <a class='relacao' href="#" id="relacao_sr_cursos_button" data-toggle="modal" data-target="#relacao_sr_cursos_modal">
        <b>Cursos e Educandos</b><br />
        Visualize as informações das Superintendências do Incra</br>
        E seus respectivos cursos
    </a>
</div>
<script>
    var infowindow = null;
    var markerwindow = null;
    var markerCluster = null;
    var bindLines = null;
    var map = null;
    var hashMarkers = null;
    var atual_request = false;
    var lastType = "";

    function enableZoomCluster() {
        setTimeout(function() {
            if (markerCluster) {
                markerCluster.zoomOnClick_ = true;
            }
        }, 50);
    }

    function disableZoomCluster() {
        if (markerCluster) {
            markerCluster.zoomOnClick_ = false;
        }
    }

    function setCity(data) {
        var idCity = data[0];
        var position = {
            lat: parseFloat(data[3]),
            lng: parseFloat(data[4])
        };
        map.setCenter(position);
        map.setZoom(10);
        var trigger = new google.maps.event.trigger(hashMarkers[idCity], 'click');
    }

    function initMap() {
        var initialpos = {
            zoom: 4,
            center: {
                lat: -13.9731974397433545,
                lng: -51.92527999999999
            },
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: true,
            zoomControl: true,
            scaleControl: true,
            fullscreenControl: false,
            rotateControl: true
        };
        $("#loading").remove();

        map = new google.maps.Map(document.getElementById('map'), initialpos);

        google.maps.event.addListener(map, 'dragstart', disableZoomCluster);
        google.maps.event.addListener(map, 'mouseup', enableZoomCluster);

        var input = document.getElementById('pac-input');
        var inputgroup = document.getElementById("input-group-search");

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(inputgroup);

        $(inputgroup).fadeIn(1000);

        var options = {
            types: ['(cities)'],
            componentRestrictions: {
                country: 'br'
            }
        };
        var autocomplete = new google.maps.places.Autocomplete(input, options);

        autocomplete.bindTo('bounds', map);

        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                $.ajax({
                    url: "http://maps.google.com/maps/api/geocode/json?address=" + input.value + "&types=(cities)&components=country:BR",
                    type: 'POST',
                    dataType: 'json',
                    timeout: 20000,
                    success: function(data) {
                        if (data.results.length !== 0) {
                            place = data.results[0];
                            input.value = place.formatted_address;
                            map.setCenter(place.geometry.location);
                            map.setZoom(10);
                        } else {
                            window.alert("Nenhum município encontrado com" + input.value);
                        }
                    },
                    error: function(data) {
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

    }

    function init() {
        var timer;

        function timer_function() {
            if (typeof MarkerClusterer !== "undefined") {
                clearInterval(timer);
                updateMap();
            } else {
                console.log("Aguardando MarkerClusterer ser Carregado");
            }
        }

        timer = setInterval(timer_function, 1000);
    }

    function updateTypeMarker() {
        if ($("#modo-visualizacao").eq(0).attr("value") == "normal") {
            var dialog = $("#confirm-normal-mode");
            dialog.modal()
                .one('click', '#confirm-normal-mode-continue', function(e) {
                    updateMap();
                    dialog.modal("hide");
                }).one("click", '#confirm-normal-mode-cancel', function(e) {
                    $("#modo-visualizacao").eq(0).trigger("revert");
                    dialog.modal("hide");
                });
            return;
        }
        updateMap();
    }

    function updateMap() {
        if (typeof(google) !== "undefined") {
            hide_shape();

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
                $(".filter-checkbox").attr("disabled", true);
                $(".select-all").attr("disabled", true);
                $("#loadingmarkers").show();
            }
            if (atual_request) {
                atual_request.abort();
                atual_request = false;
                console.log("Request aborted");
            }
            var val = $("#select-mapa").eq(0).attr("value");
            if (val === "educando") {
                $(".only-educando-filter").show();
            } else {
                $(".only-educando-filter").hide();
            }
            switch (val) {
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
    }

    /**
     * @param {type} node Dados do Município e Caracterizacao
     */
    function openWindow(buttons, marker, node) {

        show_shape(node.cod);
        var id = node.id;

        var createButton = function(buttonspec) {
            var li = document.createElement("li");
            var a = document.createElement("a");
            a.style.cursor = "pointer";
            a.innerHTML = buttonspec.title;
            li.addEventListener("click", function() {
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
        var value_title = true;

        switch ($("#select-mapa").eq(0).attr("value")) {
            case "educando":
                value_title = "Educando(s)";
                break;
            case "curso":
                value_title = "Curso(s)";
                break;
        }

        option.appendChild(document.createElement("p"));
        var table = document.createElement("table");
        table.style.width = "100%";
        table.className = "table table-striped table-bordered";
        option.appendChild(table);
        pai.appendChild(option);
        var div = $("<div/>").
        css("width", "700px").
        css("box-shadow", "2px 2px 5px rgba(0,0,0,0.3)").
        css("background", "white").
        css("position", "absolute").
        css("margin", "5px").
        css("right", "0px").
        addClass("panel").addClass("panel-default")
            .append(
                $("<div/>").addClass("panel-heading").css("margin-left", "auto").css("margin-right", "auto").css("width", "100%").addClass("row").html("<h5 class='col-md-11' style='margin-top:0px;margin-bottom:0px'><i class='glyphicon glyphicon-map-marker'></i> " + node.municipio + " (" + node.estado + ") - <b>" + node.total + " " + value_title + "</b></h5>\
                         <div class='col-md-1'><button class='close' aria-label='Close' onclick='closeWindow()'><span aria-hidden='true'>&times;</span></button></div>")
            )
            .append(pai);

        closeWindow();
        if (marker.setIcon) {
            marker.setIcon({
                url: "<?= base_url('css/images/markerselected.png') ?>",
                size: new google.maps.Size(40, 45),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(20, 43),
                labelOrigin: new google.maps.Point(24, 16)
            });
        } else {
            marker.setOptions({
                strokeColor: "#1111FF",
                fillColor: "#1111FF"
            });
        }
        div.hide();
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(div.get(0));
        markerwindow = marker;
        infowindow = div;
        map_recenter(markerwindow.getPosition(), -(($(window).width() - 100) / 4), 0);
        $(buttonsr[0]).click();
        if (buttons.length === 1) {
            $(ul).remove();
        }

        div.slideDown(300);
    }

    function createMarker(node, max) {
        if (!typeMarkerIs("circle")) {
            var icon = {
                url: "<?= base_url('css/images/marker.png') ?>",
                size: new google.maps.Size(40, 45),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(20, 43),
                labelOrigin: new google.maps.Point(24, 16)
            };
            var marker_data = {
                position: {
                    lng: parseFloat(node.lng),
                    lat: parseFloat(node.lat)
                },
                icon: icon,
                label: {
                    text: node.total,
                    title: node.municipio,
                    color: 'white',
                    fontSize: '12px',
                    x: '30',
                    y: '70'
                },
                labelClass: "labels"
            };

            if (typeMarkerIs("normal")) {
                marker_data.map = map;
            }
            return new google.maps.Marker(marker_data);
        } else {
            var total = Math.pow(node.total / max, 0.6) * max; //POW da maior contraste entre numeros pequenos, e menor entre numeros grandes
            //var total = node.total;

            switch ($("#select-mapa").eq(0).attr("value")) {
                case "educando":
                    var radius = total * 50 + 1000;
                    break;
                case "curso":
                    var radius = total * 1000 + 10000;
                    break;
            }

            var circle = new google.maps.Circle({
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35,
                label: {
                    text: node.total
                },
                map: map,
                center: {
                    lng: parseFloat(node.lng),
                    lat: parseFloat(node.lat)
                },
                radius: radius
            });

            circle.getPosition = circle.getCenter;
            return circle;
        }

    }

    function typeMarkerIs(type) {
        return $("#modo-visualizacao").eq(0).attr("value") == type;
    }

    function closeWindow() {
        if (infowindow) {
            hide_shape();
            map.controls[google.maps.ControlPosition.TOP_RIGHT].removeAt(0);
            infowindow.remove();
            infowindow = false;
            if (markerwindow.setIcon) {
                markerwindow.setIcon({
                    url: "<?= base_url('css/images/marker.png') ?>",
                    size: new google.maps.Size(40, 45),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(20, 43),
                    labelOrigin: new google.maps.Point(24, 16)
                });
            } else {
                markerwindow.setOptions({
                    strokeColor: '#FF1111',
                    fillColor: '#FF1111'
                });
            }
        }
    }

    //desabilitado
    function prepareMapaInstituicao() {
        atual_request = $.get("<?php echo site_url('relatorio_mapas/get_municipios_instituicoes'); ?>", {
            filters: getFilter()
        }, function(instituicoes) {
            atual_request = false;
            hashMarkers = [];
            var markers = instituicoes.map(function(instituicao) {
                if (typeof(google) !== "undefined") {

                    var marker = new google.maps.Marker({
                        position: {
                            lng: parseFloat(instituicao.lng),
                            lat: parseFloat(instituicao.lat)
                        },
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
                    marker.addListener('click', function() {
                        openWindow([{
                            title: "<i class='glyphicon glyphicon-education'></i> Listar instituições",
                            action: getInstituicoes
                        }], marker, instituicao);
                    });
                }
                return marker;
            });
            if (typeof(google) !== "undefined") {
                markerCluster = new MarkerClusterer(map, markers, {
                    imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
                });
            }
        }, "json");

    }

    function prepareMapaCurso() {

        atual_request = $.get("<?php echo site_url('relatorio_mapas/get_municipios_cursos'); ?>", {
            filters: getFilter()
        }, function(cursos) {
            atual_request = false;
            hashMarkers = [];
            var max = Math.max.apply(Math, cursos.map(function(o) {
                return o.total;
            }));
            var markers = cursos.map(function(curso) {
                if (typeof(google) !== "undefined") {
                    var marker = createMarker(curso, max);
                    hashMarkers[curso.id] = marker;
                    marker.addListener('click', function() {
                        var data = [{
                            title: "<i class='glyphicon glyphicon-book'></i> Listar cursos",
                            action: getCursos
                        }];
                        <?PHP if (!$publico) : ?>
                            data.push({
                                title: "<i class='glyphicon glyphicon-education'></i> Para estes <b>CURSOS</b> listar educandos",
                                action: getEducandosCursos
                            });
                        <?PHP endif; ?>
                        openWindow(data, marker, curso);
                    });
                }
                return marker;
            });
            if (typeof(google) !== "undefined" && typeMarkerIs("group")) {
                markerCluster = new MarkerClusterer(map, markers, {
                    imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
                });
            }
            $("#loadingmarkers").hide();
            $(".filter-checkbox").removeAttr("disabled");
            $(".select-all").removeAttr("disabled");
            var searchCursoBtn = document.getElementById('search-curso');
            searchCursoBtn.style.display = "inline-block";

        }, "json");
    }

    function prepareMapaEducando() {
        atual_request = $.get("<?php echo site_url('relatorio_mapas/get_municipios_educandos'); ?>", {
            filters: getFilter()
        }, function(educandos) {

            var max = Math.max.apply(Math, educandos.map(function(o) {
                return o.total;
            }));

            atual_request = false;
            hashMarkers = [];
            console.log(max);

            var markers = educandos.map(function(educando) {
                if (typeof(google) !== "undefined") {
                    var marker = createMarker(educando, max);
                    hashMarkers[educando.id] = marker;
                    <?PHP if (!$publico) : ?>
                        marker.addListener('click', function() {
                            openWindow([{
                                    title: "<i class='glyphicon glyphicon-user'></i> Listar educandos",
                                    action: getEducandos
                                },
                                {
                                    title: "<i class='glyphicon glyphicon-book'></i> Para estes <b>EDUCANDOS</b> listar cursos oferecidos",
                                    action: getCursosEducandos
                                }
                            ], marker, educando);
                        });
                    <?PHP endif; ?>
                }
                return marker;
            });
            //MarkerClusterer is not defined
            if (typeof(google) !== "undefined" && typeMarkerIs("group")) {
                if (typeof MarkerClusterer !== "undefined") {
                    markerCluster = new MarkerClusterer(map, markers, {
                        imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
                    });
                } else {
                    alert("Lentidão da rede causou erro ocorreu ao carregar a página!\nAtualize a página");
                }
            }
            $("#loadingmarkers").hide();
            $(".filter-checkbox").removeAttr("disabled");
            $(".select-all").removeAttr("disabled");
            <?PHP if (!$publico) : ?>
                var searchEducandoBtn = document.getElementById('search-educando');
                searchEducandoBtn.style.display = "inline-block";
            <?PHP endif; ?>
        }, "json");
    }

    var tableopened = null;
    var atualStateMun = false;

    function hide_shape() {
        if (map) {
            map.data.setStyle(function(feature) {
                return {
                    visible: false
                };
            });
        }
    }

    function show_shape(codmun) {
        var uf_id = ("" + codmun).substr(0, 2);
        if (uf_id != atualStateMun) {
            if (atualStateMun != false) {
                map.data.forEach(function(feature) {
                    map.data.remove(feature);
                });
            }
            atualStateMun = uf_id;
            $.getJSON('<?php echo base_url(); ?>shapes/geojs-' + uf_id + '-mun.json', function(data) {
                map.data.addGeoJson(data);
                map.data.setStyle(function(feature) {
                    var geocodigo = feature.getProperty('id');
                    return {
                        fillColor: "#0000FF",
                        strokeWeight: 1.0,
                        fillOpacity: 0.5,
                        strokeColor: "#0000FF",
                        strokeOpacity: 1,
                        visible: (codmun == geocodigo)
                    };
                });
            });
        } else {
            map.data.setStyle(function(feature) {
                var geocodigo = feature.getProperty('id');
                return {
                    fillColor: "#0000FF",
                    strokeWeight: 1.0,
                    fillOpacity: 0.3,
                    strokeColor: "#0000FF",
                    strokeOpacity: 1,
                    visible: (codmun == geocodigo)
                };
            });
        }
    }

    function appendTable(url, titles, widths, btn, onselect, search) {

        var parent = $($(btn).parents(".option")[0]);
        var table = $(parent.find("table")[0]);
        $(".option li").removeClass("active");
        $(btn).addClass("active");
        var innerHTML = "<thead><tr>";

        for (var i = 0; i < titles.length; i++) {
            innerHTML += "<th style='width:" + widths[i] + "'> " + titles[i].toUpperCase() + " </th>";
        }

        innerHTML += "</tr></thead><tbody></tbody>";
        if (tableopened !== null) {
            tableopened.destroy();
        }
        table.html(innerHTML);
        tableopened = new Table({
            data: {
                filters: getFilter()
            },
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
        appendTable("<?= site_url("relatorio_mapas/get_cursos/") ?>/" + id_municipio,
            ['codigo', 'curso', 'modalidade', 'instituição', 'total educandos <span class="badge">nacional</span>'],
            ['60px', '150px', '100px', '125px', '100px'],
            btn,
            function(data) {
                getEducandosCursos(id_municipio, $(".option li:nth-child(2)").get(0), data[0]);
            });
    }

    function getInstituicoes(id_municipio, btn) {
        appendTable("<?= site_url("relatorio_mapas/get_instituicoes/") ?>/" + id_municipio,
            ['id', 'nome', 'sigla', 'unidade', 'curso'],
            ['60px', '200px', '50px', '125px', '100px'], btn);
    }

    <?PHP if (!$publico) : ?>

        function getEducandos(id_municipio, btn, search) {
            appendTable("<?= site_url("relatorio_mapas/get_educandos/") ?>/" + id_municipio,
                ['nome', 'assentamento', 'código sipra', 'código curso'],
                ['200px', '135px', '100px', '100px'], btn, false, search);
        }

        //Lista Educandos do mapa Curso
        function getEducandosCursos(id_municipio, btn, search) {
            appendTable("<?= site_url("relatorio_mapas/get_educandos_cursos/") ?>/" + id_municipio,
                ["educando", "Cidade", "nome do território", "tipo do território", "código curso"],
                ['60px', '150px', '120px', '100px', '100px'], btn, false, search);
        }

        //Lista Cursos do mapa Educando
        function getCursosEducandos(id_municipio, btn) {
            appendTable("<?= site_url("relatorio_mapas/get_cursos_educandos/") ?>/" + id_municipio,
                ['codigo', 'curso', 'modalidade', 'vigência', 'total educandos <span class="badge">município / país</span>'],
                ['60px', '200px', '100px', '75px', '100px'],
                btn,
                function(data) {
                    getEducandos(id_municipio, $(".option li:nth-child(1)").get(0), data[0]);
                });
        }

    <?PHP endif; ?>

    function map_recenter(latlng, offsetx, offsety) {
        var scale = Math.pow(2, map.getZoom());

        var worldCoordinateCenter = map.getProjection().fromLatLngToPoint(latlng);
        var pixelOffset = new google.maps.Point((offsetx / scale) || 0, (offsety / scale) || 0);

        var worldCoordinateNewCenter = new google.maps.Point(
            worldCoordinateCenter.x - pixelOffset.x,
            worldCoordinateCenter.y + pixelOffset.y
        );

        var newCenter = map.getProjection().fromPointToLatLng(worldCoordinateNewCenter);

        map.panTo(newCenter);
    }
</script>
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC6A2l8RrNfmBdbVI-kMjRHBoZmBa1e4IU&libraries=places&callback=init"></script>
<?PHP $this->load->view('relatorio/mapas/dialogs.php', array("srAtual" => $sr, "publico" => $publico)); ?>