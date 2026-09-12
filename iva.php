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
if ($_GET['accion'] == "anadir") {echo " onload='this.document.anadir.iva.focus()'";}
if ($_GET['editar']) {echo " onload='this.document.editar.iva.focus()'";}
?>
>
<?php

include("arriba.php");
$menu6=5;include("menusizda.php");

if ($_SESSION['auto'] < 5) {echo "Usuario no autorizado";echo "</div></body></html>";exit;}

if ($_POST['accion']) {anadir1($link);}
if ($_POST['editar']) {editar1($link);}
if ($_GET['borrar']) {borrar1($link);}

echo "<div style='width:50%;float:left'>";
echo "<span class='verde b'>IVA 0.21 equivale a 21%</span><p />";
listaiva($link);
echo "</div>";


echo "<div style='float:left;display:inline'>";
if ($_GET['accion'] == "anadir") {anadir();}
if ($_GET['editar']) {editar($link);}
echo "</div>";

include("pie.php");?></body></html>

<?php

//************************************************

function listaiva($link) {

$result = $link->query("SELECT * FROM iva ORDER BY n");

echo "<table style='width:40%' class='basica hover'>"; echo "<tr><th><a href=?accion=anadir>A&ntilde;adir</a></th><th>IVA</th></tr>";

$permiso[5] = "Contable"; $permiso[4] = "Administrativo";

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	echo "<tr><td style='white-space:nowrap'>";
	echo "<a href=?editar=$fila[0]>Editar</a> - <a href=?borrar=$fila[0]>Borrar</a>";
	echo "</td><td>$fila[1]</td></tr>";

}

echo "</table>";

}


function anadir() {

	echo "<form name='anadir' method='post' action='iva.php'>";
	echo "<fieldset><legend>A&ntilde;adir IVA</legend><p />";
	echo "<label>IVA</label><br /><input type='text' name='iva' size='5' maxlength='5'><p />";
	echo "<input type='submit' name='accion' value='A&ntilde;adir IVA'><p />";
	echo "</fieldset>";
	echo "</form>";

}

function anadir1($link) {

	extract($_POST);
	$sql = "INSERT INTO iva (iva) VALUES ('$iva')";
	$link->query($sql);

}

function editar($link) {

	$result = $link->query("SELECT * FROM iva WHERE n = '".$_GET['editar']."'");
	$edit = $result->fetch_array(MYSQLI_BOTH);
	echo "<form name='editar' method='post' action='iva.php'>";
	echo "<fieldset><legend>Editar IVA</legend><p />";
	echo "<label>IVA</label><br /><input type='text' name='iva' size='5' maxlength='5' value='$edit[1]'><p />";
	echo "<input type='submit' name='editar' value='Modificar IVA'><input type='hidden' name='n' value='$edit[0]'><p />";
	echo "</fieldset>";
	echo "</form>";

}

function editar1($link) {
	extract($_POST);
	$sql = "UPDATE iva SET iva = '$iva' WHERE n = '$n'";
	$link->query($sql);
}

function borrar1($link) {
	$result = $link->query("SELECT * FROM iva");
	$canti = $result->num_rows;
	if ($canti < 2) {return;}
	$n = $_GET['borrar'];
	$sql = "DELETE FROM iva WHERE n='$n'";
	$link->query($sql);	
}

