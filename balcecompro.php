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

$result = $link->query("SELECT actualizaciones FROM empresa");
$fila = $result->fetch_array(MYSQLI_BOTH);

if (($ejecutar AND $ejecutar="totalbalces") OR $fila[0]) {
	include ('sumsubcuent.php');
}

$ord = $_GET['ord']; if (!$ord) {$ord = "cuenta";}

?>
<div class='noimpri'>
[ <a href='balcecompro.php?ejecutar=totalbalces'>Actualizar Totales</a>] &nbsp; &nbsp; 
<span class='verde b'>Subcuentas</span>&nbsp; &nbsp; 
<a href='balcecomprocuentas5.php'>Cuentas5</a>&nbsp; &nbsp; 
<a href='balcecomprocuentas4.php'>Cuentas4</a>&nbsp; &nbsp; 
<a href='balcecomprocuentas.php'>Cuentas</a>&nbsp; &nbsp; 
<a href='balcecomprosubgrupo.php'>Subgrupos</a>&nbsp; &nbsp; 
</div>

<table class='basica 100 hover' width='100%'>
<tr>
<th><a href='balcecompro.php'>Cuenta</a></th><th><a href='balcecompro.php?ord=descripci_'>Descripci&oacute;n</a></th><th class='dcha'>Saldo Deudor</th><th class='dcha'>Saldo Acreedor</th>
</tr>

<?php

$rs=$link->query("SELECT cuenta, descripci_, saldod, saldoa FROM subcuent WHERE saldoa != 0 || saldod != 0 ORDER BY $ord");

// bucle de listado

while($row=$rs->fetch_array(MYSQLI_BOTH)) {

	echo "<tr><td class='dcha'><a href='extractoctas.php?cuenta=".$row['cuenta']."'>".$row['cuenta']."</a></td><td>".$row['descripci_']."</td><td class='dcha'>";

	if ($row["saldod"] == 0){
		echo "&nbsp;";
	} else {
		echo number_format($row["saldod"]*$_SESSION['moneda'],$_SESSION['deci'],',','.');
	}

	echo "</td><td class='dcha'>";

	if ($row["saldoa"] == 0){
		echo "&nbsp;";
	} else {
		echo number_format($row["saldoa"]*$_SESSION['moneda'],$_SESSION['deci'],',','.');
	}

	echo"</td></tr>";

}

$sql="SELECT SUM(saldod) AS tot_saldod, SUM(saldoa) AS tot_saldoa FROM subcuent"; 
$result=$link->query($sql); 
$row=$result->fetch_array(MYSQLI_BOTH);

echo "<tr><td class='blanco dcha b' colspan='2'>SUMAS: </td><td class='blanco dcha b'>".number_format($row['tot_saldod']*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td><td class='blanco dcha b'>".number_format($row['tot_saldoa']*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td></tr>\n";

echo "</table>\n"; 

?>

<?php $top = 1; include("pie.php");?></body></html>
