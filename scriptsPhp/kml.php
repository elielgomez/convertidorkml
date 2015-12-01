<?php
//ELIEL G.	
header('Content-Type: application/json');

include ("../scriptsPhp/reader.php");
$tituloTabla="Datos";
$logo="http://www.filetolink.com/5edf2b12c8";

//Set name if empty
$nameKML=$_POST['nameKML'];
if(empty($_POST['nameKML'])){
	if ($_POST['isPolygon']==0)
		$nameKML="pointsKML";
	else
		$nameKML="polygonKML";
}


$arrayPuntos=array();

//object Excel Reader Class
$datos = new Spreadsheet_Excel_Reader();

//Read file
$datos->read("../upload/".$_POST['archivo']);

//Description Table's title
$titulo="<table border='1' width='50' font size='6'><tr>";
for ($i=1; !empty($datos->sheets[0]['cells'][1][$i]); $i++)
	$titulo.="<td bgcolor='#FF9900'>".$datos->sheets[0]['cells'][1][$i]."</td>";
$titulo.="</tr>";

//Points
if($_POST['isPolygon']==0){
	$infowindowTitulo="<table style='border-collapse:collapse;'>";
	$kml="<?xml version=\"1.0\" encoding=\"UTF-8\"?><kml xmlns=\"http://www.opengis.net/kml/2.2\"><Document>";
	for ($j=2; !empty($datos->sheets[0]['cells'][$j][$_POST['latitud']]); $j++){
		$kml.="<Placemark><Style id=\"normalPlacemark\"><IconStyle><Icon>";
		$kml.="<href>".$_POST['icono']."</href>";
		$kml.="</Icon></IconStyle></Style>";
		$kml.="<description>
		<![CDATA[";
			//$kml.="<p><img src='".$logo."'></p>";
			$kml.="<p><strong>".utf8_decode($tituloTabla)."</strong><p>";
			$kml.=$titulo;
			$infowindow=$infowindowTitulo;

			//Table point description
			for($r=1; !empty($datos->sheets[0]['cells'][1][$r]); $r++){
				@$kml.="<td><font size='1'>".($datos->sheets[0]['cells'][$j][$r])."</font></td>";
				@$infowindow.="<td style='border:1px solid'><font size='1'>".($datos->sheets[0]['cells'][$j][$r])."</font></td>";
			}

			$kml.="</tr></table>";
			$kml.="]]>
			</description>";
			$kml.="<Point><coordinates>".$datos->sheets[0]['cells'][$j][$_POST['longitud']].",".$datos->sheets[0]['cells'][$j][$_POST['latitud']]."</coordinates></Point></Placemark>";
	}//For
}

//It's polygon
else{
	$kml="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<kml xmlns=\"http://www.opengis.net/kml/2.2\"> 
<Document>
	<Placemark>
		<name>".$nameKML."</name>
		<Style id=\"hide\">
			<LineStyle>
				<color>6414B4FF</color>
		        <width>2</width>
		    </LineStyle>
		    <PolyStyle>
		    	<color>64780000</color>
		    </PolyStyle>
		 </Style>
		 <Polygon>
			 <outerBoundaryIs>
			 	<LinearRing>
					 <coordinates>";
	//Points
	for ($j=2; !empty($datos->sheets[0]['cells'][$j][$_POST['latitud']]); $j++){
		
		$tmpLongitude=$datos->sheets[0]['cells'][$j][$_POST['longitud']];
		$tmpLatitude=$datos->sheets[0]['cells'][$j][$_POST['latitud']];
		$kml.=$tmpLongitude.",".$tmpLatitude.",0 \n";
	}

	$kml.="</coordinates>
			 	</LinearRing>
			 </outerBoundaryIs>
		 </Polygon>
	 </Placemark>";

}
//Close kml
$kml.="</Document></kml>";

//Random number to set file name
$ext=rand(1000,9999);

//Write file
$archivo = "../upload/".utf8_encode(preg_replace('/\\.[^.\\s]{3,4}$/', '', $nameKML))."-".$ext.".kml";
$fp = fopen($archivo, "a");
$write = fputs($fp, $kml);
fclose($fp);  

//Del file
unlink("../upload/".$_POST['archivo']);
$salida['mensaje']="<p id=\"descargarLink\"><a href='./upload/".preg_replace('/\\.[^.\\s]{3,4}$/', '', $nameKML)."-".$ext.".kml'>Descargar Archivo <i>'".preg_replace('/\\.[^.\\s]{3,4}$/', '', $nameKML)."-".$ext.".kml'</i></a></p>";
$salida['icono']=$_POST['icono'];

//Json return
echo json_encode($salida);

		
?>