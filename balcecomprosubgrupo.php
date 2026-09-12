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
[ <a href='balcecomprosubgrupo.php?ejecutar=totalbalces'>Actualizar Totales</a>] &nbsp; &nbsp; 
<a href='balcecompro.php'>Subcuentas</a>&nbsp; &nbsp; 
<a href='balcecomprocuentas5.php'>Cuentas5</a>&nbsp; &nbsp; 
<a href='balcecomprocuentas4.php'>Cuentas4</a>&nbsp; &nbsp; 
<a href='balcecomprocuentas.php'>Cuentas</a>&nbsp; &nbsp; 
<span class='verde b'>Subgrupos</span>&nbsp; &nbsp; 
</div>

<table class='basica 100 hover' width='100%'>
<tr>
<th>Cuenta</th><th>Descripci&oacute;n</th><th class='dcha'>Saldo Deudor</th><th class='dcha'>Saldo Acreedor</th>
</tr>

<?php

$rs=$link->query("SELECT subgrupo, descripci_, sdod2c, sdoh2c FROM subgrupo WHERE sdod2c != 0 || sdoh2c != 0 ORDER BY descripci_");

// bucle de listado

while($row=$rs->fetch_array(MYSQLI_BOTH)) {

	echo "<tr><td class='dcha'>".$row['subgrupo']."</td><td>".$row['descripci_']."</td><td class='dcha'>";

	if ($row["sdoh2c"] == 0){
		echo "&nbsp;";
	} else {
		echo number_format($row["sdoh2c"]*$_SESSION['moneda'],$_SESSION['deci'],',','.');
	}

	echo "</td><td class='dcha'>";

	if ($row["sdod2c"] == 0){
		echo "&nbsp;";
	} else {
		echo number_format($row["sdod2c"]*$_SESSION['moneda'],$_SESSION['deci'],',','.');
	}

	echo"</td></tr>";

}

$sql="SELECT SUM(sdod2c) AS tot_saldod, SUM(sdoh2c) AS tot_saldoa FROM subgrupo"; 
$result=$link->query($sql); 
$row=$result->fetch_array(MYSQLI_BOTH);

echo "<tr><td colspan='2' class='blanco dcha b'>SUMAS: </td><td class='blanco dcha b'>".number_format($row['tot_saldoa']*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</b></td><td class='blanco dcha b'>".number_format($row['tot_saldod']*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td></tr>\n";

?>

</table>

<?php $top = 1; include("pie.php");?></body></html>
