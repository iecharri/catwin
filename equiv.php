<?php

//Copyright (C) 2000-2015 Antonio Grandio Botella http://www.antoniograndio.com
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

<?php

$array = moneda();
$n = 0;
$fich = "";
$fp = fopen("moneda.txt","w");
foreach ($array as $elem) {
	if (trim($elem)) {
		$fich .= $elem;
	}
}
fwrite($fp,$fich);
fclose($fp);
$_POST['cant'] = str_replace(",", ".", $_POST['cant']);

if ($_POST['accion'] == "A&ntilde;adir" AND $_POST['cant'] > 0 AND $_POST['deci'] >=0) {
	$cad = $_POST['cant']."|".$_POST['moneda']."|".$_POST['deci']."|".$_POST['simb'];
	foreach ($array as $elem) {
		$valores = explode("|",$elem);
		if ($valores[0] == $_POST['cant'] AND $valores[2] == $_POST['deci']) {
			$mensajemoneda = "Ya existe la equivalencia [ ".$_POST['cant']. " / ".$_POST['deci']." ] , cambia los decimales<p />";	
		}
		if ($valores[1] == $_POST['moneda']) {
			$mensajemoneda = "Ya existe la moneda: ".$_POST['moneda']."<p />";	
		}
	}
	if (!$mensajemoneda) {
		$fp = fopen("moneda.txt","a+");
		fwrite($fp,"\r\n".$cad);
		fclose($fp);
	}
}

if ($_POST['accion'] == "Validar") {
	$cad = $_POST['cant']."|".$_POST['moneda']."|".$_POST['deci']."|".$_POST['simb']."\r\n";
	$array = moneda();
	$n = 0;
	$fich = "";
	$fp = fopen("moneda.txt","w");

	foreach ($array as $elem) {
		$valores = explode("|",$elem);
		if ($valores[1] == $_POST['moneda'] AND $n != $_POST['n']) {
			$mensajemoneda = "Ya existe la moneda: ".$_POST['moneda']."<p />";	
		}
		if ($valores[0] == $_POST['cant'] AND $valores[2] == $_POST['deci'] AND $n != $_POST['n']) {
			$mensajemoneda = "Ya existe la equivalencia [ ".$_POST['cant']. " / ".$_POST['deci']." ] , cambia los decimales<p />";	
		}
		if ($n == $_POST['n'] AND !$mensajemoneda) {
			$fich .= $cad;
		} else {
			$fich .= $elem;
		}
		$n = $n+1;
	}
	fwrite($fp,$fich);
	fclose($fp);
}

?>

<body <?php if ($_GET['accion'] == 'anadir' OR $_GET['accion'] == 'editar'){echo "onload='this.document.anadir.moneda.focus()'";}?>>

<?php
include("arriba.php");
include("menusizda.php");
echo $mensajemoneda;
?>

<div style='float:left;display:inline'><table class='basica'>
<tr><th><a href='?accion=anadir'>A&ntilde;adir</a></th><th>Moneda</th><th>Equivalencia euros</th><th>Decimales</th><th>S&iacute;mbolo</th></tr>

<?php

$array = moneda();
$n = 0;

foreach ($array as $elem) {
	$b = explode("|",$elem);
	if (trim($b[0])) {
		echo "<tr><td>";
		if (PRUEBA == 1) {
			// *** SERVER_PRUEBAS
			if ($n > 1) {echo "<a href='?accion=editar&n=$n'>Editar</a>";}
			// *** SERVER_PRUEBAS
		} else {
			echo "<a href='?accion=editar&n=$n'>Editar</a>";
		}		echo "</td><td>$b[1]</td><td>$b[0]</td><td class=1>$b[2]</td><td>$b[3]</td></tr>";
		$n = $n+1;
	}
}
$n = 0;

?>

</table></div>

<div style='float:left'>

<?php

if ($_GET['accion'] == "anadir") {

	echo "<form action='equiv.php' name='anadir' method='post' onsubmit='return validmoneda(anadir)'>";
	echo "<fieldset><legend>A&ntilde;adir</legend><p />";
	echo "<label>Moneda</label><br /><input type='text' name='moneda' size='10' maxlength='10'><p />";
	echo "<label>Equivalencia</label><br /><input type='text' name='cant' size='10' maxlength='10'><p />";
	echo "<label>Decimales</label><br /><input type='text' name='deci' size='1' maxlength='1'><p />";
	echo "<label>S&iacute;mbolo</label><br /><input type='text' name='simb' size='4' maxlength='4'><p />";
	echo "<input type='submit' name='accion' value='A&ntilde;adir'></fieldset></form>";

}

if (PRUEBA == 1) {
	// *** SERVER_PRUEBAS
	if ($_GET['accion'] == "editar" AND $_GET['n'] < 2) {return;}
	// *** SERVER_PRUEBAS
}

if ($_GET['accion'] == "editar") {
	
	$array = moneda();

	foreach ($array as $elem) {
	if ($_GET['n'] == $n) {
		$b = explode("|",$elem);
		break;
	}
	$n = $n + 1;
	}

	if ($b) {

		echo "<form action='equiv.php' name='anadir' method='post' onsubmit='return validmoneda(anadir)'>";
		echo "<fieldset><legend>Editar</legend><p />";
		echo "<label>Moneda</label><br /><input type='text' name='moneda' size='10' maxlength='10' value = \"$b[1]\"><p />";
		echo "<label>Equivalencia</label><br /><input type='text' name='cant' size='10' maxlength='10' value = \"$b[0]\"><p />";
		echo "<label>Decimales</label><br /><input type='text' name='deci' size='1' maxlength='1' value = \"$b[2]\"><p />";
		echo "<label>S&iacute;mbolo</label><br /><input type='text' name='simb' size='4' maxlength='4' value = \"$b[3]\"><p />";
		echo "<input type='hidden' name='n' value=".$_GET['n'].">";
		echo "<input type='submit' name='accion' value='Validar'></fieldset></form>";

	}

}

?>

</div>

<?php include("pie.php");?></body></html>