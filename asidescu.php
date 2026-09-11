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
include("paginar.php");

if (!$link OR !$_SESSION['empresa']) {
	include("noempresa.php");
	exit;
}
?>

<body>

<?php
include("arriba.php");
$menu11=6;include("menusizda.php");

if ($ejecutar AND $ejecutar="totalapu") {
	totalapu($link,"");
}

if ($_GET['borr'] == 1) {

	$sql = "SELECT asiento FROM asientos WHERE sumadebe != sumahaber";
	$result = $link->query($sql);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$sql1 = "DELETE FROM apuntes WHERE asiento = '$fila[0]'";
		if (!$link->query($sql1)) die ("El usuario $usuario no tiene permiso para borrar Asientos.");
		$sql1 = "DELETE FROM asientos WHERE asiento = '$fila[0]'";
		if (!$link->query($sql1)) die ("El usuario $usuario no tiene permiso para borrar Asientos.");
		$link->query("UPDATE factrec SET asiento = '' WHERE asiento = '$fila[0]'");
		$link->query("UPDATE factemi SET asiento = '' WHERE asiento = '$fila[0]'");
	}

}

$sql = "SELECT asiento, sumadebe, sumahaber FROM asientos WHERE sumadebe != sumahaber ORDER BY asientos.asiento";

$rs=$link->query($sql);

if ($rs->num_rows == 0) {echo "<p /><span class='b'>No hay asientos descuadrados desde la &uacute;ltima vez que se actualiz&oacute; totales.</span>";echo "</div></body></html>";exit;}

echo "<h3>[ <a href='?ejecutar=totalapu'>Actualizar totales</a> ]</h3>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='?borr=1' onclick=\"return confirm('Confirmar borrado')\">BORRAR ASIENTOS DESCUADRADOS</a>";
$numasi = $rs->num_rows;

$conta = $_GET['conta'];
if (!$_GET['conta']) {
	$conta = 1;
}
$rs = $link->query($sql." LIMIT ".($conta-1).", 10");

if (pagina($numasi, $conta, 10, "Asientos", $ord)) {$fin = 1;}

echo "<table class='basica 100 hover' width='100%'>";

cabasi("");

while ($fila = $rs->fetch_array(MYSQLI_BOTH)){
	asiento($link,$fila['asiento'],0,$_SESSION['moneda'],$_SESSION['deci'],$_GET['bojust']);
}

?>

</table>

<?php
pagina($numasi, $conta, 10, "Asientos", $ord);
echo "<h3>[ <a href='?ejecutar=totalapu'>Actualizar totales</a> ]</h3>";
include("pie.php");
?>

<?php $top = 0; include("pie.php");?>

</body></html>

