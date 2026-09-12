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

<body>

<?php
include("arriba.php");
$menu12=8;include("menusizda.php");

//**************************

echo "<form name='form2' method='post'>\n";

echo "Subgrupos <input type='radio' name='tabla' value='subgrupo' ";
if ($tabla == 'subgrupo' OR !$tabla) {
	$mensaje = "<span class='rojo b'>Atenci&oacute;n</span>, si existen cuentas (y sus subcuentas correspondientes) cuyo subgrupo correspond&iacute;a al que vas sustituir por uno nuevo, estas quedar&aacute;n \"hu&eacute;rfanas\" y se perder&aacute; la integridad referencial, descuadrando los balances a cierto nivel de agregaci&oacute;n.";
	echo "checked";
}
echo "> &nbsp; Cuentas <input type='radio' name='tabla' value='cuentas' ";
if ($tabla == 'cuentas') {
	$mensaje = "<span class='rojo b'>Atenci&oacute;n</span>, si no existe subgrupo de nivel de agregaci&oacute;n superior correspondiente al nuevo n&uacute;mero que se le asigne, se perder&aacute; la integridad referencial y los balances de nivel de subgrupos superior descuadrar&aacute;n. Lo mismo ocurrir&aacute; a nivel inferior si quedan subcuentas hu&eacute;rfanas sin cuentas correspondientes a este nivel.";
	echo "checked";
}
echo "> &nbsp; Subcuentas<input type='radio' name='tabla' value='subcuent' ";
if ($tabla == 'subcuent') {
	$mensaje = "<span class='rojo b'>Atenci&oacute;n</span>, si no existe cuenta de nivel de agregaci&oacute;n superior correspondiente al nuevo n&uacute;mero que se le asigne, se perder&aacute; la integridad referencial y los balances de nivel de cuentas superior descuadrar&aacute;n.";
	echo "checked";
}
echo ">\n";

echo "<p /><input type='submit' value = ' >> MODIFICAR >> '>\n";
echo "</form>\n";

echo $mensaje;

//**************************

if ($subgrupo) {


	$descripci1_ = substr($descripci1_,3);

	if ($nuevodescripci1_ != $descripci1_ AND $nuevodescripci1_) {
		$link->query("UPDATE subgrupo SET descripci_ = '$nuevodescripci1_' WHERE subgrupo = '$subgrupo'") or die ("El usuario $usuario no tiene permisos para modificar Subgrupos.");
	}

	if ($nuevosubgrupo != $subgrupo AND $nuevosubgrupo > 9) {
		$link->query("UPDATE subgrupo SET subgrupo = '$nuevosubgrupo' WHERE subgrupo = '$subgrupo'") or die ("El usuario $usuario no tiene permisos para modificar Subgrupos o Subgrupo ya existente.");
	}

	if ($nuevosubgrupo <= 9) {
		echo " El nº de Subgrupo debe de ser num&eacute;rico con 2 d&iacute;gitos. No se ha realizado el cambio.";
	}

}

//**************************

if ($cuenta) {

	$descripci2_ = substr($descripci2_,4);

	if ($nuevodescripci2_ != $descripci2_ AND $nuevodescripci2_) {
		$link->query("UPDATE cuentas SET descripcio = '$nuevodescripci2_' WHERE cuenta = '$cuenta'") or die ("El usuario $usuario no tiene permisos para modificar Cuentas.");
	}

	if ($nuevocuenta != $cuenta AND $nuevocuenta > 99) {
		$link->query("UPDATE cuentas SET cuenta = '$nuevocuenta' WHERE cuenta = '$cuenta'") or die ("El usuario $usuario no tiene permisos para modificar Cuentas o cuenta ya existente.");
	}

	if ($nuevocuenta <= 99) {
		echo " El nº de Cuenta debe de ser num&eacute;rico con 3 d&iacute;gitos. No se ha realizado el cambio.";
	}

}

//**************************
if ($_POST['subcuenta']) {

	$descripci3_ = substr($descripci3_,7);

	if ($nuevodescripci3_ != $descripci3_ AND $nuevodescripci3_) {
		$link->query("UPDATE subcuent SET descripci_ = '$nuevodescripci3_' WHERE cuenta = '$subcuenta'") or die ("El usuario $usuario no tiene permisos para modificar Subcuentas.");
	}

	if ($nuevosubcuenta != $subcuenta AND $nuevosubcuenta > 9999999) {
		$link->query("UPDATE subcuent SET cuenta = '$nuevosubcuenta' WHERE cuenta = '$subcuenta'") or die ("El usuario $usuario no tiene permisos para modificar Subcuentas o subcuenta ya existente.");
		$ip = $_SERVER['HTTP_CLIENT_IP'];
		if (!$ip) {$ip = $_SERVER['REMOTE_ADDR'];}
		$link->query("UPDATE apuntes SET cuenta = '$nuevosubcuenta', ip = '$ip' WHERE cuenta = '$subcuenta'");
	}

	if ($nuevosubcuenta <= 9999999) {

		echo " El nº de Subcuenta debe de ser num&eacute;rico con 8 d&iacute;gitos. No se ha realizado el cambio.";

	}

}

//**************************

//**************************************************************************************************

if ($tabla == 'subgrupo') {

	echo "<form name='form1' method='post' onsubmit='return confirma1()'>\n";

	echo "<br /><p />Nº de Subgrupo: <input type='text' name='subgrupo' readonly='readonly' size='2'>\n";

	echo "Descripci&oacute;n <span class='rojo b'>(evitar usar comillas)</span>: <select name='descripci1_' onchange='seleccionacuengaseditcuen2(form1)' onfocus='seleccionacuengaseditcuen2(form1)'>\n";

	$result = $link->query("SELECT subgrupo, descripci_ FROM subgrupo ORDER by descripci_");
	while ($row = $result->fetch_array(MYSQLI_BOTH)){
		echo "<option value='".trim($row[0])."*".$row[1]."'";
		if ($row[0] == $nuevosubgrupo) {echo " selected";}
		echo ">".$row[1];
	}

	echo "</select>\n";

	echo "<br /><p />\n";
	echo "<span class='b'>CAMBIAR POR</span> (uno de los dos campos debe de estar lleno, un campo vac&iacute;o significa que no cambiar&aacute;):<br />\n";

	echo "<br /><p />\n";
	
	echo "Nº de Subgrupo: <input type='text' name='nuevosubgrupo' size='2' maxlength='2'>\n";

	echo "Descripci&oacute;n: <input type='text' name='nuevodescripci1_' size='50' maxlength='50'>\n";

	echo "<p /><input type='hidden' name='tabla' value=".$tabla."><input type='submit' value='Modificar Subgrupo'></form>\n";

}

//**************************

if ($tabla == 'cuentas') {

	echo "<form name='form1' method='post' onsubmit='return confirma2()'>\n";

	echo "<br /><p />Nº de Subcuenta: <input type='text' name='cuenta' readonly='readonly' size='3'>\n";

	echo "Descripci&oacute;n: <select name='descripci2_' onchange='seleccionacuengaseditcuen3(form1)' onfocus='seleccionacuengaseditcuen3(form1)'>\n";

	$result = $link->query("SELECT cuenta, descripcio FROM cuentas ORDER by descripcio");
	while ($row = $result->fetch_array(MYSQLI_BOTH)){
		echo "<option value='".trim($row[0])." ".$row[1]."'";
		if ($row[0] == $nuevocuenta) {echo " selected";}
		echo ">".$row[1];
	}

	echo "</select>\n";

	echo "<br /><p />\n";
	echo "<span class='b'>CAMBIAR POR</span> (uno de los dos campos debe de estar lleno, un campo vac&iacute;o significa que no cambiar&aacute;):<br />\n";

	echo "<br /><p />\n";
	
	echo "Nº de Cuenta: <input type='text' name='nuevocuenta' size='3' maxlength='3'>\n";

	echo "Descripci&oacute;n: <input type='text' name='nuevodescripci2_' size='50' maxlength='50'>\n";

	echo "<p /><input type='hidden' name='tabla' value=".$tabla."><input type='submit' value='Modificar Cuenta'></form>\n";

}

//**************************

if ($tabla == 'subcuent') {

	echo "<form name='form1' method='post' onsubmit='return confirma()'>\n";

	echo "<br /><p />Nº de Subcuenta: <input type='text' name='subcuenta' readonly='readonly' size='8' value=$nuevosubcuenta>\n";

	echo "Descripci&oacute;n: <select name='descripci3_' onchange='seleccionacuengaseditcuen1(form1);'  onfocus='seleccionacuengaseditcuen1(form1)'>\n";

	$result = $link->query("SELECT cuenta, descripci_, ctacte, telefono, telefono2 FROM subcuent ORDER by descripci_");
	while ($row = $result->fetch_array(MYSQLI_BOTH)){
		echo "<option value='".$row[0]." ".$row[1]."'";
		if ($row[0] == $nuevosubcuenta) {echo " selected";}
		echo ">".$row[1];
	}

	echo "</select>\n";

	echo "<br /><p />\n";
	echo "<span class='b'>CAMBIAR POR</span> (uno de los dos campos debe de estar lleno, un campo vac&iacute;o significa que no cambiar&aacute;):<br />\n";

	echo "<br /><p />\n";
	
	echo "Nº de Subcuenta: <input type='text' name='nuevosubcuenta' size='8' maxlength='8'>\n";

	echo "Descripci&oacute;n: <input type='text' name='nuevodescripci3_' size='50' maxlength='50'>\n";

	echo "<p /><input type='hidden' name='tabla' value=".$tabla."><input type='submit' value='Modificar Subcuenta'></form>\n";

}

?>

<?php $top = 1; include("pie.php");?></body></html>
