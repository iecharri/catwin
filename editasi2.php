<?php

//Copyright (C) 2000-2015  Antonio Grandio Botella http://www.antoniograndio.com
//Copyright (C) 2000-2015  Inmaculada Echarri San Adrian inma.echarri@gmail.com

//This file is part of Catwin.

//CatWin is free software; you can redistribute it and/or modify
//it under the terms of the GNU General Public License as published by
//the Free Software Foundation; either version 2 of the License, or
//(at your option) any later version.

//CatWin is distributed in the hope that it will be useful,
//but WITHOUT ANY WARRANTY; without even the implied warranty of
//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//GNU General Public License for more details:
//http://www.gnu.org/copyleft/gpl.html

//You should have received a copy of the GNU General Public License
//along with Catwin Net; if not, write to the Free Software
//Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

include("head.php");

if (!$link OR !$_SESSION['empresa']) {
	include("noempresa.php");
	exit;
}
?>

<body
<?php
if (!$bloqueo AND $asiento AND $accion AND ($accion == 'altaapu' OR $accion == 'editapu')) {echo " onload=\"foco('cuenta')\"";}
?>
>

<?php
include("arriba.php");
$menu11=7;include("menusizda.php");

if (!$asiento) {

	echo "<form method='post' name='form1'>\n";
	echo "Asiento: <input type='text' name='asiento'>\n";
	echo "<input type='submit' name = 'formu' value='Buscar Asiento'>\n";
	echo "</form>\n";
	echo "</div>";
	include("pie.php");
	echo "</body></html>";
	exit;

}

$nomatach = $_FILES['fich']['name'];
if ($nomatach AND $asiento) {
	$tipo1    = $_FILES["fich"]["type"];
	$archivo1 = $_FILES["fich"]["tmp_name"];
	$tamanio1 = $_FILES["fich"]["size"];
	$fp = fopen($archivo1, "rb");
    $contenido = fread($fp, $tamanio1);
    $contenido = addslashes($contenido);
    fclose($fp);
	$link->query("UPDATE asientos SET fich = '$contenido', tipofich = '$tipo1' WHERE asiento = '$asiento'");
}

if ($explicacion) {
	$link->query("UPDATE asientos SET explicacion = \"$explicacion\" WHERE asiento = '$asiento'");
}

if ($accion == "altaapu1" AND ($debe != 0 OR $haber != 0)) {
	include ("altaapu1.php");
 }

if ($accion == "editapu1" AND ($debe != 0 OR $haber != 0)) {
 	include ("editapu1.php");
}

if ($accion == "boapu") {
 	include ("borrapu1.php");
}

if ($accion == "boasi") {
 	$sql = "DELETE FROM apuntes WHERE asiento = '$asiento'";
	if (!$link->query($sql)) die ("El usuario $usuario no tiene permiso para borrar Asientos.");
	$sql = "DELETE FROM asientos WHERE asiento = '$asiento'";
	if (!$link->query($sql)) die ("El usuario $usuario no tiene permiso para borrar Asientos.");
	$link->query("UPDATE factrec SET asiento = '' WHERE asiento = '$asiento'");
	$link->query("UPDATE factemi SET asiento = '' WHERE asiento = '$asiento'");
	echo "Asiento<span class='b'> ".$asiento." </span>borrado.\n";
	echo "</div></body></html>";exit;
}

if ($asiento) {
	$result = $link->query("SELECT asiento, explicacion FROM asientos WHERE asiento = '$asiento'");
	if ($result->num_rows == 0) {
		echo "<p />Asiento <span class='b'>$asiento</span> inexistente o Apunte Hu&eacute;rfano.</div></body></html>";
		exit;
	}
	$fila = $result->fetch_array(MYSQLI_BOTH);
}

echo "<a href='editasi2.php?asiento=$asiento&accion=boasi' onclick='return borrar_asiento()'>Borrar Asiento</a>";

echo "&nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;<a href='editasi2.php?asiento=$asiento&accion=altaapu'>A&ntilde;adir Apunte</a><p />";

echo "<form enctype='multipart/form-data' name='justificante' action='editasi2.php?asiento=$asiento' method='post'>";
echo "<label>Justificante</label> <input type='file' name='fich' size='19' maxlength='19'>";
echo " (Si el asiento ya tiene un justificante ser&aacute; sustitu&iacute;do)";
echo "<br /><label>Explicaci&oacute;n</label> <textarea name='explicacion' rows='6' cols='90'>$fila[1]</textarea>";
echo " <input type='submit' name='boton' value=\" >> \">";
echo "</form>";


echo "<table class='basica 100 hover' width='100%'>";

cabasi(2);
totalapu($link,$asiento);
asiento($link,$asiento,"1",$_SESSION['moneda'],$_SESSION['deci'],$_GET['bojust']);


echo "</table><p />";

if ($accion == 'editapu') {
	include ("editapu.php");
}

if ($accion == 'altaapu') {
	include ("altaapu.php");
}

?>

</div>

<?php $top = 0; include("pie.php");?>

</body></html>
