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
	$sql = "SELECT subgrupo FROM subgrupo WHERE subgrupo = '$anadir'";
	$result = $link->query($sql);
	if ($result->num_rows) {
		$mensaje = "&nbsp;&nbsp;<span class='rojo b'>Subgrupo $anadir ya existe en $empresa</span>";
	} else {
		$sql = "SELECT subgrupo, nombresg, grupo FROM subgplan WHERE subgrupo = '$anadir'";
		$result = $link->query($sql);
		$fila = $result->fetch_array(MYSQLI_BOTH);
		$sql = "INSERT INTO subgrupo (subgrupo, descripci_,grupo) VALUES ('$fila[0]', '".str_replace("'","",$fila[1])."', '$fila[2]')";
		$link->query($sql);
		$mensaje = "&nbsp;&nbsp;<span class=verdeb>Subgrupo $anadir a&ntilde;adido con &eacute;xito.</span>";
	}
}
?>

<a href='pgc.php'>Grupos</a>&nbsp;
Subgrupos&nbsp;
<a href='pgc3.php'>Cuentas</a>&nbsp;
<a href='pgc6.php'>Subcuentas</a>
&nbsp;&nbsp;<?php echo $mensaje;?>
<p />

<?php

if ($_GET['gr']) {
	$gr = $_GET['gr'];
	$sql = "SELECT grupplan.grupo, grupplan.nombre FROM grupplan WHERE grupplan.grupo = '$gr'";
	$result = $link->query($sql);
	$fila = $result->fetch_array(MYSQLI_BOTH);
	echo "Grupo: ".$fila[0]." ".$fila[1]."<p />";
 	$condi = "WHERE subgplan.grupo='$gr'";
}

$result = $link->query("SELECT *,subgrupo.subgrupo FROM subgplan LEFT JOIN subgrupo ON subgplan.subgrupo = subgrupo.subgrupo $condi");

if ($gr) {$filtro = "gr=$gr&";}
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	echo "<a name='$fila[0]'></a><a href=pgc3.php?subgr=".$fila[0].">".$fila[0]." ".$fila[1]."</a>";
	if ($fila['descripsg']) {
		echo " [ <a href=?".$filtro."descr=".$fila[0]."#$fila[0]>Descripci&oacute;n</a> ]";
	}
	if (!$fila[4]) {
		echo "&nbsp;&nbsp;[ <a href=?".$filtro."anadir=".$fila[0]."#$fila[0]>A&ntilde;adir a $empresa</a> ]";
	}
	if ($mensaje AND $fila[0] == $anadir) {echo $mensaje;}
	if ($descr == $fila[0]) {
		echo "<p /><div class='bi'>".nl2br($fila[3])."</div>";
	}
	if (!$gr) {echo "<div style='float:right'><a href=#inicio><img src='arriba.png' /></a></div>";}
	echo "<hr>";

}

?>

<?php $top = 1; include("pie.php");?></body></html>
