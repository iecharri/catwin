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
$menu13=5;include("menusizda.php");

if ($_SESSION['auto'] < 5) {echo "Usuario no autorizado";echo "</div></body></html>";exit;}

include ('sumsubcuent.php');

$result = $link->query("SELECT asiento FROM asientos WHERE tipo = 'Cierre'");
$cr = $result->num_rows;

if ($cr) {
	$mensaje = "Ejercicio ya estaba cerrado.<p /></div></body></html>";
}

?>Cierre del Ejercicio<p />

<?php 
if ($mensaje) {
	echo $mensaje;
	include("pie.php");
	echo "</body></html>";
	exit;	
}

$result = $link->query("SELECT anocont FROM empresa");
$row = $result->fetch_array(MYSQLI_BOTH);
$fecha = ($row[0]+1)."-12-31";
$b = "31/12/".substr($row[0],2,2);

$result = $link->query("SELECT ultasi FROM empresa");
$fila = $result->fetch_array(MYSQLI_BOTH);
$id = $fila[0] + 1;
$link->query("UPDATE empresa SET ultasi = '$id' WHERE 1");

echo "Se va a a&ntilde;adir el siguiente Asiento con fecha $b ";
echo "<form name='regcuen' method='post' style='display:inline'>";
echo " <input type='submit' name='ver' value=' Ver '>";
if ($_POST['ver']) {
	echo " <input type='submit' name='crear' value='Alta Asiento'>";
}
echo "</form><br />";

$result = $link->query("SELECT SUM(saldod-saldoa) FROM subcuent WHERE cuenta <60000000 AND saldod-saldoa > 0");
$tot1 = $result->fetch_array(MYSQLI_BOTH);
$result = $link->query("SELECT SUM(saldod-saldoa) FROM subcuent WHERE cuenta <60000000 AND saldod-saldoa < 0");
$tot2 = $result->fetch_array(MYSQLI_BOTH);
$tot1 = $tot1[0];
$tot2 = 0 - $tot2[0];

if (!$tot1 AND !$tot2) {echo "<p />Imposible cerrar Ejercicio.<p /></div></body></html>";exit;}

$sql = "SELECT *,saldod-saldoa AS saldo FROM subcuent WHERE cuenta <60000000 AND saldod-saldoa != 0 ORDER BY saldod,saldoa DESC";
$result = $link->query($sql);

echo "<table class='basica 100' width='100%'>";cabasi("");

echo "<tr><td class='blanco b' colspan='6'>Asiento: $id Fecha: $b Tipo: Cierre</td></tr>";

$array[] = "INSERT INTO asientos (asiento, fecha, tipo, sumadebe, sumahaber) VALUES ('$id', '$fecha', 'Cierre', '$tot2', '$tot1')";

$ip = $_SERVER['HTTP_CLIENT_IP'];
if (!$ip) {$ip = $_SERVER['REMOTE_ADDR'];}

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	extract($fila);

	echo "<tr><td><a href='extractoctas.php?cuenta=$cuenta'>$cuenta</a></td><td>$descripci_</td><td></td>";

	if ($saldo > 0) {
		$array[] = "INSERT INTO apuntes (asiento, fecha, tipo, cuenta, contrap, concepto, haber, ip) VALUES ('$id', '$fecha', 'Regularizaci&oacute;n', '$cuenta', '', '', '$saldo', '$ip')"; 
		echo "<td></td><td class='dcha'>".number_format($saldo*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td><td></td></tr>";
	}
	if ($saldo < 0) {
		$saldo = 0 - $saldo;
		$array[] = "INSERT INTO apuntes (asiento, fecha, tipo, cuenta, contrap, concepto, debe, ip) VALUES ('$id', '$fecha', 'Regularizaci&oacute;n', '$cuenta', '', '', '$saldo', '$ip')"; 
		echo "<td class='dcha'>".number_format($saldo*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td><td></td><td></td></tr>";
	}
}

echo "<tr><td class='blanco dcha' colspan='3'>SUMAS:</td><td class='blanco dcha'>".number_format($tot2*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td><td class='blanco dcha'>".number_format($tot1*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td><td class='blanco'></td></tr>";

echo "</table>";

if (!$array) {

	echo "No se a&ntilde;adir&aacute;n los Asientos";

}

if ($_POST['crear'] AND $array) {

	foreach ($array as $clave=>$valor) {
		$link->query($array[$clave]);
	}

	include ('sumsubcuent.php');

	echo "<div id='dialog' title='Cierre Ejercicio'>";
	echo "Se ha a&ntilde;adido el Asiento.";
	echo "</div>";

}

?>

<?php $top = 1; include("pie.php");?></body></html>
