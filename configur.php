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
if ($_GET['conf'] == 'empresa' AND !$bloqueo) {echo " onload='this.document.form1.nombre.focus()'";}
?>
>
<?php

include("arriba.php");
$menu6=4;include("menusizda.php");

?>

<ol>
<li><a href='?conf=empresa'>Empresa.</a></li>
<li><a href='?conf=act'>Actualizaciones.</a></li>
</ol>

<?php

if ($_SESSION['auto'] < 5) {
	echo "<p /><span class='rojo b'>Usuario no autorizado.</span>";
	echo "</body></html>";
	return;
}

if ($_GET['conf'] == 'empresa') {empresa($link,$_POST);}
if ($_GET['conf'] == 'act') {act($link,$_POST);}

include("pie.php");?></body></html>

<?php

//*********************************

function act($link,$POST) {


if ($POST['act'] == 'on') {$x = 1;}

if ($POST['valid']) {$link->query("UPDATE empresa SET actualizaciones = '$x' WHERE 1");}

$result = $link->query("SELECT actualizaciones FROM empresa");
$fila = $result->fetch_array(MYSQLI_BOTH);
extract($fila);

echo "<div class='centro'>";

echo "<form name='form1' method='post'>";
echo "Actualizar balances autom&aacute;ticamente <input type='checkbox' name='act'";
if ($fila[0] == 1) {echo " checked = 'checked'";}
echo "> <input type='submit' name='valid' value=' >> Validar >> '></form>";

echo "</div>";

}

//*********************************

function empresa($link,$POST) {

if ($POST['nombre']) {$mensaje = editarempresa($link,$POST);}

$result = $link->query("SELECT * FROM empresa");

$fila = $result->fetch_array(MYSQLI_BOTH);

extract($fila);

echo "<div class='centro'>";

echo "<form name='form1' method='post'>";

echo "Nombre de la Empresa<br />";
echo "<input type='text' name = 'nombre' size='50' maxlength='50' value=\"$nombre\"><p />";

echo "Domicilio<br />";
echo "<input type='text' name = 'domicilio' size='30' maxlength='30' value=\"$domicilio\"><p />";

echo "Localidad<br />";
echo "<input type='text' name = 'localidad' size='20' maxlength='20' value=\"$localidad\"><p />";

echo "C&oacute;digo Postal<br />";
echo "<input type='text' name = 'cp' size='5' maxlength='5' value=\"$cp\"><p />";

echo "<input type='submit' value=' >> Validar >>'>";

echo "</form>";

echo $mensaje;

echo "</div>";

}

function editarempresa($link,$POST) {

	if (PRUEBA == 1) {
	// *** SERVER_PRUEBAS
	if ($_SESSION['empresa'] == "nuevocat") {
		return "<p /><span class='rojo b'>Opci&oacute;n no disponible en empresa Nuevocat</span>";
	}
	// *** SERVER_PRUEBAS
	}
	extract($POST);

	$sql = "UPDATE empresa SET nombre = '$nombre', domicilio = '$domicilio', localidad = '$localidad', cp = '$cp' WHERE 1";
	$link->query($sql);

}

