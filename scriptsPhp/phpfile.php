<?php
header('Content-Type: application/json');
header("Content-Type: text/html; charset=utf-8"); 
include ("../scriptsPhp/reader.php");
include("iconos.php");

//Object Excel Reader Class
$datos = new Spreadsheet_Excel_Reader();
$salida['archivo']=$_FILES["file"]["name"];

//No file
if (!$_FILES["file"]) {
  $salida['salida']="Error: <br>";
} else {
  $salida['salida']="<p>Nombre Archivo: <b>" . $_FILES["file"]["name"] . "</b></p>";
  $salida['salida'].="<p>Tamaño: <b>" . ($_FILES["file"]["size"] / 1024) . " kB</b></p>";
  move_uploaded_file(utf8_encode($_FILES["file"]["tmp_name"]),
  "../upload/" .$_FILES["file"]["name"]);
  $salida['salida'].="Guardado en (remoto): " . "upload/" . $_FILES["file"]["name"];
}

//Read excel file
$datos->read("../upload/".$_FILES["file"]["name"]);

//Selec options to set fields
for ($i=1; !empty($datos->sheets[0]['cells'][1][$i]); $i++){
	$sel="";
	$campo=$datos->sheets[0]['cells'][1][$i];
	@$salida['campos'].="<option value=".$i.">".utf8_encode($campo)."</option>";
}

//Icons options
$icons = $iconos;
@$salida['iconos'].="<option value=\"\" selected>Seleccionar Icono</option>";
for ($i=0; $i<count($icons); $i++)
    //$salida['iconos'].="<option data-img-src=\"".$icons[$i]."\" value=\"".$icons[$i]."\" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$icons[$i]."</option>";
    $salida['iconos'].="<option data-img-src=\"".$icons[$i]."\" value=\"".$icons[$i]."\" style=\"font-size:10px; font-family:Verdana; background-size: 20px 20px; background-repeat:no-repeat;background-image:url(".$icons[$i].");\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$icons[$i]."</option>";

//Json return
echo json_encode($salida);
?> 