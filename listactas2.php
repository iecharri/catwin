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

<body <?php if (!$bloqueo AND $accion == 'editar' AND !$_POST['nuevosubgrupo']) {echo "onload=\"foco('nuevosubgrupo')\"";}?>>

<?php
include("arriba.php");
$menu12=7;include("menusizda.php");

//include ('sumsubcuent.php');
extract($_GET);

?>

<table class='basica 100 hover' width='100%'>
<tr>
<th class='anchomin'><a href='listactas2.php'>Subgrupo</a></th><th><a href='listactas2.php?x=alfa'>Descripci&oacute;n</a></th>
</tr>

<?php

if ($_POST['nuevosubgrupo']) {

	extract($_POST);

	$link->query("UPDATE subgrupo SET descripci_ = '$nuevodescripci1_' WHERE subgrupo = '$subgrupo'") or die ("El usuario $usuario no tiene permisos para modificar Subgrupos.");

	if ($nuevosubgrupo != $subgrupo AND $nuevosubgrupo > 9) {
		$link->query("UPDATE subgrupo SET subgrupo = '$nuevosubgrupo' WHERE subgrupo = '$subgrupo'") or die ("El usuario $usuario no tiene permisos para modificar Subgrupos o Subgrupo ya existente.");
	}

	if ($nuevosubgrupo <= 9) {
		echo "El nº de Subgrupo debe de ser num&eacute;rico con 2 d&iacute;gitos. No se ha realizado el cambio.";
	}
	$accion = "";
	$cuenta = "";

}

if ($x) {$orden = "descripci_";} else {$orden = "subgrupo";}
$rs=$link->query("SELECT subgrupo, descripci_, sdod2c, sdoh2c  FROM subgrupo ORDER BY $orden");

// bucle de listado

while($row=$rs->fetch_array(MYSQLI_BOTH)) {

	echo "<tr>";

	echo "<td class='dcha anchomin'>[ <a href='?accion=editar&subgrupo=".$row['subgrupo']."&x=$x'>Editar</a> ]&nbsp;&nbsp;";
	if ($row['sdod2c'] != 0 || $row['sdoh2c'] != 0 )
	{
		echo "<a href='extractoctas2.php?cuenta=".$row['subgrupo']."'>";
	}
	echo $row['subgrupo'];
	if ($row['sdod2c'] != 0 || $row['sdoh2c'] != 0 )
	{
		echo "</a>";
	}

	echo "</td><td class='wid99'>".$row['descripci_']."</td>";

	echo "</tr>";

}
?>

</table>

<?php

if ($accion=="editar" AND $subgrupo) {
	echo "<div id='dialog' title='Editar Subgrupo $subgrupo'>";
	$param = "subgrupo";
	$cuenta = $subgrupo;
	include("ctas2edit.php");
	echo "</div>";
}

?>

<?php $top = 1; include("pie.php");?></body></html>
