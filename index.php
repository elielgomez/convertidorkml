<html>
<head>
<title>Convertidor Excel->KML</title>
<link href='css/style.css' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/chosen.css" />
<script>

</script>
</head>
<body>
<div id='credito'>Eliel G.</div>
<div id="convertidor">
    <h1>Convertidor Excel (97-2003) -> KML</h1>
	    <form action="scriptsPhp/phpfile.php" method="post" enctype="multipart/form-data" accept-charset="utf-8">
        <input type="file" class="fileUpload" name="file"><br>
        <input type="submit" id="subir" class="fileUpload" value="Subir Archivo">
    </form>
    <div id="subido">
        <div class="progress">
            <div class="bar"></div >
            <div class="percent">0%</div >
        </div>
        <div id="status"></div>
        <hr>
        <div id="select">
                <p>Latitud, Longitud:</p>
        		<select multiple="" id="camposExcel"></select>
                <div id="iconosDiv">
                    <p>Icono:</p>
                    <select id="iconos"></select>
                </div>
                <p>Nombre:</p>
                <input type="text" id="nameKML" placeholder="Nombre KML" /></p>
                <input type="button" id="crearKML" value="Crear KML" />
                <p><input type="checkbox" id="isPolygon" class="isPolygon" />Pol&iacute;gono?</p>
        </div>
        <input type="hidden" name="archivo" id="archivo">
    </div>
    <div id="descargar"></div>
    <p id="area"></p>
</div>

<!--<div id="mapa">
    <div id="map_canvas"></div>
</div>-->

</body>
<script src="js/jquery.js"></script>
<script src="js/jquery-1.11.1.js"> </script>
<!--<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>-->

<script type="text/javascript" src="js/jquery.ui.map.js"></script>
<script src="js/jquery.form.js"></script>
<script src="js/script.js"></script>
<script src="chosen/chosen.jquery.js"></script>
<script type="text/javascript">
(function() {
   
var bar = $('.bar');
var percent = $('.percent');
var status = $('#status');
   
$('form').ajaxForm({
    beforeSend: function() {
        status.empty();
        var percentVal = '0%';
        bar.width(percentVal)
        percent.html(percentVal);
    },
    uploadProgress: function(event, position, total, percentComplete) {
        var percentVal = percentComplete + '%';
        bar.width(percentVal)
        percent.html(percentVal);
    },
    success: function() {
        var percentVal = '100%';
        bar.width(percentVal)
        percent.html(percentVal);
    },
    complete: function(data) {
        var out = JSON.parse(data.responseText);

        if (out['err']=='Error')
            alert();
        else{
            status.html(out['salida']);
            jQuery("#camposExcel").chosen().html(out['campos']);
            jQuery("#iconos").chosen().html(out['iconos']);
            jQuery("#camposExcel").chosen().trigger('chosen:updated');
            jQuery("#iconos").chosen().trigger('chosen:updated');
            jQuery("#archivo").val(out['archivo']);
            jQuery("#select").show();
        }
    }
}); 

})();       
</script>





</html>