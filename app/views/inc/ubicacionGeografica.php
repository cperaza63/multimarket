<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Ubicacion Geografica</title>
</head>
<body>
    <div class="container d-flex w-100 h-100 p-3 mx-auto flex-column justify-content-center">
    <br>
        <header class="masthead mb-auto">
            <div class="inner">
              <div class="nav nav-masthead justify-content-center">
              	<form method="POST" target="_parent" action="https://administracion.ciudadhive.com/ciudadhive_amazon/ciudadhive/verShoppingCart.php">
                    <form class="FormularioAjax" method="POST"
                    action="<?php echo APP_URL; ?>app/ajax/companyAjax.php">
                    <input type="hidden" name="modulo_company" value="actualizarUbicacion">
                    <input type="hidden" name="company_id" value="<?php echo $company_id; ?>">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <input name="txtDireccion" type="text" class="form-control" id="txtDireccion" placeholder="Direccion">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <input name="txtCiudad" type="text" class="form-control" id="txtCiudad" placeholder="Ciudad">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <input name="txtEstado" type="text" class="form-control" id="txtEstado" placeholder="Estado">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                            <input name="latitude" type="text" id="txtLat" class="form-control" 
                            placeholder="latitude" value="<?=$datos['company_latitude'];?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                            <input name="longitude" type="text" id="txtLng" class="form-control" 
                            placeholder="longitud" value="<?=$datos['company_longitude'];?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                            <input name="grabar_direccion" type="submit" class="btn btn-success form-control" 
                            value="Grabar Dirección" id="txtLng" placeholder="grabar">
                            </div>
                        </div>
                               
              </div>
            </div>
      	</header>
          <main role="main" class="inner cover">
            <div id="map_canvas" width="100%" style="height:350px">
            </div>
          </main>
    </div>
<!--    <p><span class="col-md-2">
    <input type="submit" class="brn btn-danger form-control" value="Salir" id="salir" placeholder="Salir">
    </span>
      </p>-->
      
    </form>
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
      <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAxb8yRixOynQF18jgHtmgImmQwYMEBvGo"></script> 
    <script>
        var vMarker
        var a=1;
        var map
            map = new google.maps.Map(document.getElementById('map_canvas'), {
                zoom: 11,
                center: new google.maps.LatLng(10.199915, -68.0104358),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            vMarker = new google.maps.Marker({
                position: new google.maps.LatLng(10.199915, -68.0104358),
                draggable: true
            });
            google.maps.event.addListener(vMarker, 'dragend', function (evt) {
                $("#txtLat").val(evt.latLng.lat().toFixed(6));
                $("#txtLng").val(evt.latLng.lng().toFixed(6));

                map.panTo(evt.latLng);
            });
            map.setCenter(vMarker.position);
            vMarker.setMap(map);
            
            if (a== 1){
                a=0;
                    vMarker.setPosition(new google.maps.LatLng(<?=$datos['company_latitude'];?>, <?=$datos['company_longitude'];?>));
                    map.panTo(new google.maps.LatLng(<?=$datos['company_latitude'];?>, <?=$datos['company_longitude'];?>));
                    $("#txtLat").val(<?=$datos['company_latitude'];?>);
                    $("#txtLng").val(<?=$datos['company_longitude'];?>);
                
            }

            $("#txtCiudad, #txtEstado, #txtDireccion").change(function () {
                movePin();
            });

            function movePin() {
            var geocoder = new google.maps.Geocoder();
            var textSelectM = $("#txtCiudad").text();
            var textSelectE = $("#txtEstado").val();
            var inputAddress = $("#txtDireccion").val() + ' ' + textSelectM + ' ' + textSelectE;

            alert(inputAddress);
            geocoder.geocode({
                "address": inputAddress
            }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    vMarker.setPosition(new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng()));
                    map.panTo(new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng()));
                    $("#txtLat").val(results[0].geometry.location.lat());
                    $("#txtLng").val(results[0].geometry.location.lng());
                }

            });
        }
        </script>
</body>
</html>