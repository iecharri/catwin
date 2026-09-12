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

include ("arriba.php");
$menu13=4;include("menusizda.php");
if ($_GET['anadir']) {
	$anadir = $_GET['anadir'];
	if (strlen($anadir) == 4) {
		$temp = $anadir."0000";
	} elseif (strlen($anadir) == 5) {
		$temp = $anadir."000";
	}
	$sql = "SELECT cuenta FROM subcuent WHERE cuenta = '$temp'";
	$result = $link->query($sql);
	if ($result->num_rows) {
		$mensaje = "&nbsp;&nbsp;<span class='rojo b'>Subcuenta $anadir ya existe en $empresa</span>";
	} else {
		$sql = "SELECT subcplan.subcuenta, subcplan.nombre, subcplan.cuenta, cuentas.cuenta FROM subcplan LEFT JOIN cuentas ON subcplan.cuenta = cuentas.cuenta WHERE subcplan.subcuenta = '$anadir'";
		$result = $link->query($sql);
		$fila = $result->fetch_array(MYSQLI_BOTH);
		if (!$fila[3]) {
			$mensaje= "&nbsp;&nbsp;<span class='rojo b'>A&ntilde;adir antes Cuenta $fila[2] a la tabla de Cuentas.</span>";
		} else {
			$sql = "INSERT INTO subcuent (cuenta, descripci_) VALUES ('$temp', '".str_replace("'","",$fila[1])."')";
			$link->query($sql);
			$mensaje = "&nbsp;&nbsp;<span class=verdeb>Subcuenta $temp a&ntilde;adida con &eacute;xito.</span>";
		}
	}
}

?>


<a href='pgc.php'>Grupos</a>&nbsp;
<a href='pgc2.php'>Subgrupos</a>&nbsp;
<a href='pgc3.php'>Cuentas</a>&nbsp;
Subcuentas</a><p />

<?php

if ($_GET['cue']) {
	$cue = $_GET['cue'];
	$sql = "SELECT grupplan.grupo, grupplan.nombre, subgplan.subgrupo, subgplan.nombresg, cuenplan.cuenta, cuenplan.nombre FROM cuenplan LEFT JOIN subgplan ON cuenplan.subgrupo = subgplan.subgrupo LEFT JOIN grupplan ON grupplan.grupo = subgplan.grupo WHERE cuenplan.cuenta = '$cue'";
	$result = $link->query($sql);
	$fila = $result->fetch_array(MYSQLI_BOTH);
	echo "Grupo: <a href=pgc2.php?gr=".$fila[0].">".$fila[0]."</a> ".$fila[1]."<br />Subgrupo: <a href=pgc3.php?subgr=".$fila[2].">".$fila[2]."</a> ".$fila[3]."<br />Cuenta: ".$fila[4]." ".$fila[5]."<p />";
	$condi = "WHERE subcplan.cuenta='$cue'";
}
$result = $link->query("SELECT subcuenta, nombre, descripsu FROM subcplan $condi");
if ($cue) {$filtro = "cue=$cue&";}
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	echo "<a name='$fila[0]'></a><span style='color:800000'>".$fila[0]." ".$fila[1]."</span>";
	if ($fila['descripsu']) {
		echo " [ <a href='?".$filtro."descr=".$fila[0]."#$fila[0]'>Descripci&oacute;n</a> ]";
	}
	$result1 = $link->query("SELECT cuenta FROM subcuent WHERE cuenta LIKE '$fila[0]%'");
	$existe = $result1->fetch_array(MYSQLI_BOTH);
	if (!$existe[0]) {
		echo " [ <a href='?".$filtro."anadir=".$fila[0]."#$fila[0]'>A&ntilde;adir a $empresa</a> ]";
	}
	if ($mensaje AND $fila[0] == $anadir) {echo $mensaje;}
	if ($descr == $fila[0]) {
		echo "<p /><div class='bi'>".nl2br($fila[2])."</div>";
	}
	if (!$cue) {echo "<div style='float:right'><a href='#inicio'><img src='arriba.png' /></a></div>";}
	echo "<hr>";

}

?>

<?php $top = 1; include("pie.php");?></body></html>
