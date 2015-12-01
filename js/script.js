$(document).ready(function(){
    $.noConflict();
    $("#popup").hide();
   // var mapCenter = new google.maps.LatLng(47.6145, -122.3418); //Google map Coordinates
    //var map;
    //map_initialize(); // load map
    function map_initialize(){
    //Google map option
        var googleMapOptions = 
        { 
            center: mapCenter, // map center
            zoom: 2, //zoom level, 0 = earth view to higher value
            panControl: true, //enable pan Control
            zoomControl: true, //enable zoom control
            zoomControlOptions: {
            style: google.maps.ZoomControlStyle.SMALL //zoom control size
            },
            scaleControl: true, // enable scale control
            mapTypeId: google.maps.MapTypeId.SATELLITE // google map type
        };
      map = new google.maps.Map(document.getElementById("map_canvas"), googleMapOptions); 
    
       
    }
    var latlon=[]; 
    $(".fileUpload").live("click",function(){
        var latlon=[];     
    });
    
    var isPolygon=0;
    function orderSelection(value,pos){
        latlon[pos]=value;
     }

    jQuery("#camposExcel").chosen({width: "100%",placeholder_text_multiple:"Latitud y Longitud",search_contains: true, max_selected_options: 2});
    jQuery("#camposExcel").chosen().change(function(e,params){
        var val=jQuery("#camposExcel").val();
        if(val.length==1)
            orderSelection(val[0],0); 
        else{
            orderSelection(val[1],1);
            if(latlon[0]==val[1]){
                orderSelection(val[0],1);
            }
        }
    });

    jQuery("#iconos").chosen({disable_search_threshold: 10, width:'100%'});
    $(".upload").live("click",function(){
        $("#subido").hide();
        $("#descargar").html("");

    });


    $('.isPolygon').click(function() { 
        if ($(this).is(':checked')) {
             isPolygon=1;
             $("#iconosDiv").css("display","none");
        } else {
            isPolygon=0;
            $("#iconosDiv").css("display","block");
        }
    });
    
    $("#subir").live("click", function(){
        $("#subido").css("display","block");
        $("#descargar").css("display","none");
    });
    $("#crearKML").live("click",function(){
        if($("#camposExcel option:selected").length==2){
            $("#subido").hide();
            $("#descargar").css("display","block");
            var url = "scriptsPhp/kml.php"; // El script a dónde se realizará la petición.
                $.ajax({
                    type: "POST",
                    url: url,
                    data: "nameKML="+$("#nameKML").val()+"&isPolygon="+isPolygon+"&latitud="+latlon[0]+"&longitud="+latlon[1]+"&archivo="+$("#archivo").val()+"&icono="+$("#iconos").val(), // 
                    success: function(data)
                    {  
                        $("#descargar").html(data['mensaje']);
                        /*
                       
                        var lats = [];
                        var lons = [];
                        var infos= [];
                        var bounds = new google.maps.LatLngBounds();
                        for (var prop in json.lat) {
                            lats.push(json.lat[prop]);
                        }
                        for (var prop in json.lon) {
                            lons.push(json.lon[prop]);
                        }
                       for (var prop in json.tabla) {
                            infos.push(json.tabla[prop]);
                        }
                        
                         //##### drop a new marker on right click ######
                       // google.maps.event.addListener(map, 'rightclick', function(event) {      
                       for(var i=0;i<lats.length;i++){
                            var lat=lats[i];
                            var lon=lons[i];
                            var marker = new google.maps.Marker({
                                position: new google.maps.LatLng(lat,lon), //map Coordinates where user right clicked
                                map: map,
                                draggable:true, //set marker draggable 
                                animation: google.maps.Animation.DROP, //bounce animation
                                title:"CESAVENAY",
                                icon: json.icono //custom pin icon
                            });
                            
                            //Content structure of info Window for the Markers
                           // var contentString=$('infos');
                            var contentString = $('<div class="marker-info-win" style="width:1200px">'+
                            '<div class="marker-inner-win"><span class="info-content">'+infos[i]+
                            '</span>'+
                            '<br />');
                            //<button name="remove-marker" class="remove-marker" title="Eliminar Punto">Eliminar Punto</button></div></div>
                            //Create an infoWindow
                            var infowindow = new google.maps.InfoWindow({maxWidth: 1200});
                            
                            //set the content of infoWindow
                            infowindow.setContent(contentString[0]);
                            
                            //add click listner to marker which will open infoWindow         
                            google.maps.event.addListener(marker, 'click', function() {
                                    infowindow.open(map,this); // click on marker opens info window 
                            });
                            bounds.extend(marker.position);
                            
                            //###### remove marker #########/
                            //var removeBtn   = contentString.find('button.remove-marker')[0];
                            //google.maps.event.addDomListener(removeBtn, "click", function(event) {
                            //    marker.setMap(null);
                            //});
                            
                        //});
                        }// END FOR
                        map.setZoom(15);
                        map.fitBounds(bounds);*/
                        
                    }// END SUCCESS
                }); // END AJAX
                
        }
        else{
            alert("Error!");
        }

    });
    
});
