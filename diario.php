<?php

//Copyright (C) 2000-2015  Antonio Grandio Botella http://www.antoniograndio.com
//Copyright (C) 2000-2015  Inmaculada Echarri inma.echarri@gmail.com

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
include("paginar.php");

if (!$link OR !$_SESSION['empresa']) {
	include("noempresa.php");
	exit;
}
?>

<body>

<?php
include("arriba.php");
$menu11=5;include("menusizda.php");

if ($ejecutar AND $ejecutar="totalapu") {
	totalapu($link,"");
}

echo "<h3 class='noimpri'>[ <a href='?ejecutar=totalapu'>Actualizar totales</a> ]";

if ($ord == "pfecha") {
	echo " [<a href='?ord=&cant=$cant'>Ordenar por Nº Asiento</a> ]";
} else {
	echo " [<a href='?ord=pfecha&cant=$cant'>Ordenar por Fecha</a>]";
}

if ($cant == "t") {
	echo " [<a href='?ord=$ord'>Por p&aacute;ginas</a> ]";
} else {
	echo " [<a href='?ord=$ord&cant=t'>Todos</a>]";
}

?>

</h3><br />

<?php

$sql = "SELECT SUM(sumadebe) AS sumadebe, SUM(sumahaber) AS sumahaber FROM asientos";
$result = $link->query($sql);
$tot = $result->fetch_array(MYSQLI_BOTH);

if ($ord == "pfecha") {
	$sql = "SELECT asiento FROM asientos ORDER BY fecha, asiento";
} else {
	$sql = "SELECT asiento FROM asientos ORDER BY asiento";
}

$rs=$link->query($sql);
$numasi = $rs->num_rows;

if ($numasi == 0) {
	echo "<p />No hay Asientos.<p /></div></body></html>";exit;
}

if (!$cant) {
	$conta = $_GET['conta'];
	if (!$_GET['conta']) {
		$conta = 1;
	}
	$rs = $link->query($sql." LIMIT ".($conta-1).", 10");

	if (pagina($numasi, $conta, 10, "Asientos", $ord)) {$fin = 1;}
}

?>

<table class='basica 100 hover' width='100%'>

<?php cabasi("");

while ($fila = $rs->fetch_array(MYSQLI_BOTH)){

	asiento($link,$fila[0],"", $_SESSION['moneda'], $_SESSION['deci'],$_GET['bojust']);

}

if ($fin OR $cant == "t") {

	echo "<tr class='b'><td class='blanco dcha' colspan='3'>SUMAS: </td><td class='blanco dcha'>".number_format($tot[0]*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td><td class='blanco dcha'>".number_format($tot[1]*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td>";

	echo "<td class='blanco dcha rojo'>";
	if ($tot[0]-$tot[1] != 0) {
		echo number_format(($tot[0]-$tot[1])*$_SESSION['moneda'],$_SESSION['deci'],',','.');
	}
	echo "</td>";

	echo "</tr>";

}

?>

</table>

<?php

if (!$cant) {
	pagina($numasi, $conta, 10, "Asientos", $ord);
}

echo "<h3 class='noimpri'>[ <a href='?ejecutar=totalapu'>Actualizar totales</a> ]";

if ($ord == "pfecha") {
	echo " [<a href='?ord=&cant=$cant'>Ordenar por Nº Asiento</a> ]";
} else {
	echo " [<a href='?ord=pfecha&cant=$cant'>Ordenar por Fecha</a>]";
}

if ($cant == "t") {
	echo " [<a href='?ord=$ord'>Por p&aacute;ginas</a> ]";
} else {
	echo " [<a href='?ord=$ord&cant=t'>Todos</a>]";
}

?>

</h3>

<?php $top = 1; include("pie.php");?></body></html>
