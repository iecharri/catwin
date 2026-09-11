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

if (!$link OR !$_SESSION['empresa']) {
	include("noempresa.php");
	exit;
}
?>

<body <?php if (!$cuenta AND !$bloqueo) {echo "onload=\"foco('cuenta')\"";}?>>

<?php
include("arriba.php");
$menu12=2;include("menusizda.php");

if (!$cuenta) {

	echo "<form method='post' name='form1'>Subcuenta: <input type='text' name='cuenta' size='8' maxlength='8'> \n";
	echo "<input type='submit' value='Buscar'></form> \n";
	include("pie.php");
	echo "</div></body></html>";
	exit;

}

$datos1= 'si';
if ($datos AND $datos = 'no') {
	$datos1 = '';
}

$result = $link->query("SELECT cuenta, descripci_, ctacte, telefono, telefono2 FROM subcuent WHERE cuenta = $cuenta"); 

if ($result->num_rows == 0) {

		echo "<p /><br /><p />No existe el Nº de Subcuenta <span class='b'>$cuenta</span> en la tabla Subcuentas.";
		exit;

}

while ($fila = $result->fetch_array(MYSQLI_BOTH)) :

	if ($fila[0] = $cuenta) {
		echo "<h2>Subcuenta: ".$cuenta." ".$fila[1]."</h2>";
		echo "Cuenta Corriente: ".$fila[2]." - Tel&eacute;fono: ".$fila[3]." / $fila[4]<p />";
		break;
	}

endwhile;

$result = $link->query("SELECT * FROM apuntes WHERE cuenta = $cuenta ORDER by fecha"); 

if ($result->num_rows == 0) {

	echo "<p /><br /><p />No hay Apuntes para el Nº de Subcuenta <span class='b'>$cuenta</span>.";
	exit;

}

/* ****************** CABECERA ************************* */
	
echo "<table class='basica 100 hover' width='100%'> \n"; 
echo "<tr><th class='b'>Fecha</th><th class='b'>Asiento</th><th class='b'>Concepto</th><th class='dcha b'>Debe</th><th class='dcha b'>Haber</th></tr> \n";

/* ****************** APUNTES ************************** */

while ($fila = $result->fetch_array(MYSQLI_BOTH)) :

	$a=explode("-",$fila["fecha"]); 
	echo "<tr><td>".$a[2]."/".$a[1]."/".substr($a[0],2,2)."</td><td><a href=editasi2.php?asiento=".$fila["asiento"].">". $fila["asiento"]."</a><td class=1>".$fila["concepto"]."</td><td class='dcha'>";
	
	if ($fila["debe"] == 0)
	{
	echo "&nbsp;";
	} else {
	echo number_format($fila["debe"]*$_SESSION['moneda'],$_SESSION['deci'],',','.');
	}
	echo "</td><td class='dcha'>";
	
	if ($fila["haber"] == 0)
	{
	echo "&nbsp;";
	} else {
	echo number_format($fila["haber"]*$_SESSION['moneda'],$_SESSION['deci'],',','.');
	}

	echo "</td></tr> \n";

endwhile;

/* ****************** SUMAS Y FIN DE TABLA*************** */


$sql="SELECT SUM(debe) AS tot_debe, SUM(haber) AS tot_haber FROM apuntes WHERE cuenta=$cuenta"; 
$result=$link->query($sql); 
$row=$result->fetch_array(MYSQLI_BOTH);

echo "<tr><td colspan='3' class='blanco dcha b'>SALDO: ".number_format(($row['tot_debe']-$row['tot_haber'])*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td><td class='blanco dcha b'>".number_format($row['tot_debe']*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td><td class='blanco dcha b'>".number_format($row['tot_haber']*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td></tr>\n";

echo "</table><p /> \n"; 

$top = 1; include("pie.php");?></body></html>
