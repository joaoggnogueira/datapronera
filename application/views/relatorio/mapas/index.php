<style>
    #map{
        height: calc(100vh - 75px);
    }
</style>


<h1>Relatório de Mapas</h1>
<p>Abaixo se encontram-se os filtros que podem ser realizados no relatório geral do pronera.</p>

<div class="form-group">
    <label>Mapa</label>
    <div>
        <select class="form-control" onchange="updateMap()" name="mapa" id="mapa">
            <option selected value="educando">Cidades dos Educandos</option>
            <option value="curso">Cidades das Caracterizações de Cursos ativos</option>
            <option value="instituicao">Cidades das Caracterizações de Instituições</option>
        </select>
        <p class="text-danger select"><label for="educando_tipo_terr"></label></p>
    </div>
</div>
<div id="map"></div>


<script>
    var infowindow = null;
    var markerwindow = null;
    var markerCluster = null;
    var map = null;

    function updateMap() {
        if (map === null) {
            var initialpos = {
                zoom: 4,
                center: {lat: -14.235004, lng: -51.92527999999999}
            };
            map = new google.maps.Map(document.getElementById('map'), initialpos);
            $("#mapa").val("educando");
        } else {
            markerCluster.clearMarkers();
        }
        switch ($("#mapa").val()) {
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

    }

    function prepareMapaInstituicao() {

        $.get("<?php echo site_url('relatorio_mapas/get_municipios_instituicoes'); ?>", function (instituicoes) {

            var markers = instituicoes.map(function (instituicao) {
                var marker = new google.maps.Marker({
                    position: {lng: parseFloat(instituicao.lng), lat: parseFloat(instituicao.lat)},
                    label: instituicao.total
                });

                marker.addListener('click', function () {
                    if (infowindow) {
                        infowindow.close();
                    }
                    markerwindow = marker;

                    markerCluster = new MarkerClusterer(map, markers, {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
                    infowindow = new google.maps.InfoWindow({
                        content: "<div style='padding-left:50px;padding-right:50px'>\
                            <table style='width:100%'>\
                               <tr>\
                                   <td><h4>Município</h4></td>\
                                   <td><h4 style='text-align:right'>Total de Caracterizações</h4></td>\
                               </tr>\
                               <tr>\
                                   <td><h5>" + instituicao.municipio + "</h5></td>\
                                   <td><h5 style='text-align:right'>" + instituicao.total + "</h5></td>\
                               </tr>\
                             </table>\
                             <div class='option'>\
                                    <button type='button' onclick='getInstituicoes(" + instituicao.id + ",this)' class='btn btn-success'>Listar instituições</button>\
                                    <p></p>\
                                   <table style='width:100%;margin-top:10px' class='table table-striped table-bordered'></table>\
                             </div>\
                          </div>"
                        , maxHeight: 200});
                    infowindow.open(map, marker);
                    map_recenter(markerwindow.getPosition(), 0, -100);
                });
            
                return marker;
            });
            markerCluster = new MarkerClusterer(map, markers, {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
        }, "json");

    }

    function prepareMapaCurso() {

        $.get("<?php echo site_url('relatorio_mapas/get_municipios_cursos'); ?>", function (cursos) {

            var markers = cursos.map(function (curso) {
                var marker = new google.maps.Marker({
                    position: {lng: parseFloat(curso.lng), lat: parseFloat(curso.lat)},
                    label: curso.total
                });
                marker.addListener('click', function () {
                    if (infowindow) {
                        infowindow.close();
                    }
                    markerwindow = marker;
                    infowindow = new google.maps.InfoWindow({
                        content: "<div style='padding-left:50px;padding-right:50px'>\
                                <table style='width:100%'>\
                                   <tr>\
                                       <td><h4>Município</h4></td>\
                                       <td><h4 style='text-align:right'>Total de Educandos</h4></td>\
                                   </tr>\
                                   <tr>\
                                       <td><h5>" + curso.municipio + "</h5></td>\
                                       <td><h5 style='text-align:right'>" + curso.total + "</h5></td>\
                                   </tr>\
                                 </table>\
                                 <div class='option'>\
                                       <button type='button' onclick='getCursos(" + curso.id + ",this)' class='btn btn-success'>Listar cursos</button>\
                                       <p></p>\
                                       <table style='width:100%;margin-top:10px' class='table table-striped table-bordered'></table>\
                                 </div>\
                              </div>"
                        , maxHeight: 200});
                    infowindow.open(map, marker);
                    map_recenter(markerwindow.getPosition(), 0, -100);
                });

                return marker;
            });

            markerCluster = new MarkerClusterer(map, markers, {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
        }, "json");

    }

    function prepareMapaEducando() {

        $.get("<?php echo site_url('relatorio_mapas/get_municipios_educandos'); ?>", function (educandos) {

            var markers = educandos.map(function (educando) {

                var marker = new google.maps.Marker({
                    position: {lng: parseFloat(educando.lng), lat: parseFloat(educando.lat)},
                    label: educando.total
                });

                marker.addListener('click', function () {
                    if (infowindow) {
                        infowindow.close();
                    }
                    markerwindow = marker;
                    infowindow = new google.maps.InfoWindow({
                        content: "<div style='padding-left:50px;padding-right:50px'>\
                                <table style='width:100%'>\
                                   <tr>\
                                       <td><h4>Município</h4></td>\
                                       <td><h4 style='text-align:right'>Total de Educandos</h4></td>\
                                   </tr>\
                                   <tr>\
                                       <td><h5>" + educando.municipio + "</h5></td>\
                                       <td><h5 style='text-align:right'>" + educando.total + "</h5></td>\
                                   </tr>\
                                 </table>\
                                 <div class='option'>\
                                       <button type='button' onclick='getEducandos(" + educando.id + ",this)' class='btn btn-success'>Listar educandos</button>\
                                       <h5>Para estes <b>EDUCANDOS</b> listar ... </h5>\
                                       <button type='button' onclick='getCursosEducandos(" + educando.id + ",this)' class='btn btn-success'>Cursos presenciados</button>\
                                       <p></p>\
                                       <table style='width:100%;margin-top:10px' class='table table-striped table-bordered'></table>\
                                 </div>\
                              </div>"
                        , maxHeight: 200});
                    infowindow.open(map, marker);
                    map_recenter(markerwindow.getPosition(), 0, -100);
                });
                return marker;
            });

            markerCluster = new MarkerClusterer(map, markers, {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
        }, "json");

    }

    var tableopened = null;

    function appendTable(url, titles, btn) {
        var parent = $($(btn).parents(".option")[0]);
        var table = $(parent.find("table")[0]);
        parent.find("button").removeAttr("disabled");
        $(btn).attr("disabled", "disabled");
        var innerHTML = "<thead><tr>";

        for (var i = 0; i < titles.length; i++) {
            innerHTML += "<th> " + titles[i].toUpperCase() + " </th>";
        }

        innerHTML += "</tr></thead><tbody></tbody>";
        if (tableopened) {
            tableopened.destroy();
        }
        table.html(innerHTML);
        tableopened = new Table({
            url: url,
            table: table,
            controls: null
        });
        map_recenter(markerwindow.getPosition(), 0, -300);
    }

    function getCursos(id_municipio, btn) {
        appendTable("<?= site_url("relatorio_mapas/get_cursos/") ?>/" + id_municipio, ['codigo', 'curso', 'modalidade', "superintendência"], btn);
    }

    function getInstituicoes(id_municipio, btn) {
        appendTable("<?= site_url("relatorio_mapas/get_instituicoes/") ?>/" + id_municipio, ['id', 'nome', 'sigla', 'unidade', 'natureza'], btn);
    }

    function getEducandos(id_municipio, btn) {
        appendTable("<?= site_url("relatorio_mapas/get_educandos/") ?>/" + id_municipio, ['nome', 'assentamento', 'tipo', 'código sipra'], btn);
    }

    function getCursosEducandos(id_municipio, btn) {
        appendTable("<?= site_url("relatorio_mapas/get_cursos_educandos/") ?>/" + id_municipio, ['codigo', 'curso', 'modalidade', "superintendência"], btn);
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
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC6A2l8RrNfmBdbVI-kMjRHBoZmBa1e4IU&callback=updateMap"></script>