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
	$sql = "SELECT cuenta FROM cuentas WHERE cuenta = '$anadir'";
	$result = $link->query($sql);
	if ($result->num_rows) {
		$mensaje = "&nbsp;&nbsp;<span class='rojo b'>Cuenta $anadir ya existe en $empresa</span>";
	} else {
		$sql = "SELECT subgrupo.subgrupo, cuenplan.subgrupo, cuenplan.nombre, cuenplan.cuenta FROM cuenplan LEFT JOIN subgrupo ON cuenplan.subgrupo = subgrupo.subgrupo WHERE cuenta = '$anadir'";
		$result = $link->query($sql);
		$fila = $result->fetch_array(MYSQLI_BOTH);
		if (!$fila[0]) {
			$mensaje= "<span class='rojo b'>&nbsp;&nbsp;A&ntilde;adir antes Subgrupo $fila[1] a la tabla de Subgrupos.</span>";
		} else {
			$sql = "INSERT INTO cuentas (cuenta, descripcio,subgrupo) VALUES ('$fila[3]', '".str_replace("'","",$fila[2])."', '$fila[1]')";
			$link->query($sql);
			$mensaje = "&nbsp;&nbsp;<span class=verdeb>Cuenta $anadir a&ntilde;adida con &eacute;xito.</span>";
		}
	}
}

?>


<a href='pgc.php'>Grupos</a>&nbsp;
<a href='pgc2.php'>Subgrupos</a>&nbsp;
Cuentas&nbsp;
<a href='pgc6.php'>Subcuentas</a><p />

<?php

if ($_GET['subgr']) {
	$subgr = $_GET['subgr'];
	$sql = "SELECT grupplan.grupo, grupplan.nombre, subgplan.subgrupo, subgplan.nombresg FROM subgplan LEFT JOIN grupplan ON grupplan.grupo = subgplan.grupo WHERE subgplan.subgrupo = '$subgr'";
	$result = $link->query($sql);
	$fila = $result->fetch_array(MYSQLI_BOTH);
	echo "Grupo: <a href='pgc2.php?gr=".$fila[0]."'>".$fila[0]."</a> ".$fila[1]."<br />Subgrupo: ".$fila[2]." ".$fila[3]."<p />";

	$condi = "WHERE cuenplan.subgrupo='".$_GET['subgr']."'";
}
$result = $link->query("SELECT *, cuentas.cuenta FROM cuenplan LEFT JOIN cuentas ON cuentas.cuenta = cuenplan.cuenta $condi");

if ($subgr) {$filtro = "subgr=$subgr&";}
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	echo "<a name='$fila[0]'></a><a href='pgc6.php?cue=".$fila[0]."'>".$fila[0]." ".$fila[1]."</a>";
	if ($fila['descripcu']) {
		echo " [ <a href='?".$filtro."descr=".$fila[0]."#$fila[0]'>Descripci&oacute;n</a> ]";
	}
	if (!$fila[4]) {
		echo " [ <a href='?".$filtro."anadir=".$fila[0]."#$fila[0]'>A&ntilde;adir a $empresa</a> ]";
	}
	if ($mensaje AND $fila[0] == $anadir) {echo $mensaje;}
	if ($descr == $fila[0]) {
		echo "<p /><div class='bi'>".nl2br($fila[3])."</div>";
	}
	if (!$subgr) {echo "<div style='float:right'><a href='#inicio'><img src='arriba.png' /></a></div>";}
	echo "<hr>";

}

?>

<?php $top = 1; include("pie.php");?></body></html>
