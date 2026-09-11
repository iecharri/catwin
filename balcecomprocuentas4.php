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
$menu13=1;include("menusizda.php");

if ($ejecutar AND $ejecutar="totalbalces") {
	include ('sumsubcuent.php');
}

?>
<div class='noimpri'>
[ <a href='balcecomprocuentas.php?ejecutar=totalbalces'>Actualizar Totales</a>] &nbsp; &nbsp; 
<a href='balcecompro.php'>Subcuentas</a>&nbsp; &nbsp; 
<a href='balcecomprocuentas5.php'>Cuentas5</a>&nbsp; &nbsp; 
<span class='verde b'>Cuentas4</span>&nbsp; &nbsp; 
<a href='balcecomprocuentas.php'>Cuentas</a>&nbsp; &nbsp; 
<a href='balcecomprosubgrupo.php'>Subgrupos</a>&nbsp; &nbsp; 
</div>

<?php
if ($_SESSION['empresa'] == "nuevocat") {
?>

<table class='basica 100 hover' width='100%'>
<tr>
<th class='anchomin'>Cuenta</th><th>Descripci&oacute;n</th>
<th class='dcha anchomin'>Saldo Deudor</th><th class='dcha anchomin'>Saldo Acreedor</th>
</tr>

<?php

$rs=$link->query("SELECT cuenta, descripcio, sdo4d, sdo4h FROM cuentas4 WHERE sdo4d != 0 || sdo4h != 0 ORDER BY descripcio, cuenta");

// bucle de listado

while($row=$rs->fetch_array(MYSQLI_BOTH)) {

	echo "<tr><td class='dcha'>".$row['cuenta']."</td><td>".$row['descripcio']."</td><td class='dcha'>";

	if ($row["sdo4d"] == 0){
		echo "&nbsp;";
	} else {
		echo number_format($row["sdo4d"]*$_SESSION['moneda'],$_SESSION['deci'],',','.');
	}

	echo "</td><td class='dcha'>";

	if ($row["sdo4h"] == 0){
		echo "&nbsp;";
	} else {
		echo number_format($row["sdo4h"]*$_SESSION['moneda'],$_SESSION['deci'],',','.');
	}

	echo"</td></tr>";

}

$sql="SELECT SUM(sdo4d) AS tot_saldod, SUM(sdo4h) AS tot_saldoa FROM cuentas4"; 
$result=$link->query($sql); 
$row=$result->fetch_array(MYSQLI_BOTH);

echo "<tr><td colspan='2' class='blanco dcha b'>SUMAS: </td><td class='blanco dcha b'>".number_format($row['tot_saldod']*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td><td class='blanco dcha b'>".number_format($row['tot_saldoa']*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td></tr>\n";

?>

</table>
<?php
}
?>

<?php $top = 1; include("pie.php");?></body></html>
