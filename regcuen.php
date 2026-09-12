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

include ('sumsubcuent.php');
$result = $link->query("SELECT * FROM subcuent WHERE cuenta = '12900000'");
$cr = $result->fetch_array(MYSQLI_BOTH);

if (!$cr) {
	$mensaje = "<p />No existe la Subcuenta 12900000</div></body></html>";
}
if ($cr['saldod'] OR $cr['saldor']) {
	$mensaje = "Ejercicio ya estaba regularizado.<p /><a href='regcuendes.php'>Deshacer Regularizaci&oacute;n Ejercicio</a>.</div></body></html>";
}

if ($_SESSION['auto'] < 5) {$mensaje = "Usuario no autorizado</div></body></html>";}

?>

<body <?php if (!$bloqueo AND $_SESSION['auto'] > 4 AND !$mensaje){echo "onload='document.regcuen.fecha.focus()'";}?>>

<?php
include("arriba.php");
$menu13=5;include("menusizda.php");


?>Regularizaci&oacute;n Ejercicio<p /><?php if ($mensaje) {echo $mensaje;exit;}

if ($_POST['fecha']) {

	$fecha = anocont($link,$_POST['fecha']);
	$b = $_POST['fecha'];

} else {

	$result = $link->query("SELECT ultfecha FROM empresa");
	$row = $result->fetch_array(MYSQLI_BOTH);
	$a=explode("-",$row["ultfecha"]);
	$fecha = $a[0]."-12-31";
	$b = "31/12/".substr($a[0],2,2);

}

$result = $link->query("SELECT ultasi FROM empresa");
$fila = $result->fetch_array(MYSQLI_BOTH);
$id = $fila[0] + 1;
$reg = $id + 2;
$link->query("UPDATE empresa SET ultasi = '".$reg."' WHERE 1");

echo "<form name='regcuen' method='post' style='display:inline' onsubmit='return compruebafecha(regcuen)'>";
echo "Se van a a&ntilde;adir los siguientes Asientos con fecha ";
echo "<input type='text' size='8' maxlength='8' name='fecha' value=$b> <input type='submit' name='ver' value=' Ver '>";
if ($fecha) {
	echo " <input type='submit' name='crear' value='Alta Asientos'>";
}
echo "</form><br />";

if(!$fecha) {echo "<span class='rojo b'>El a&ntilde;o no es del ejercicio actual. No se a&ntilde;adir&aacute;n Asientos</span><br />";}

echo "<table class='basica 100' width='100%'>";cabasi("");

//*************************************************

$result = $link->query("SELECT SUM(saldod-saldoa) FROM subcuent WHERE cuenta >=60000000 AND cuenta <=80000000 AND saldod-saldoa > 0");
$tot = $result->fetch_array(MYSQLI_BOTH);

$ip = $_SERVER['HTTP_CLIENT_IP'];
if (!$ip) {$ip = $_SERVER['REMOTE_ADDR'];}

if ($tot[0]) {

	$sql = "SELECT *,saldod-saldoa AS saldo FROM subcuent WHERE cuenta >=60000000 AND cuenta <=80000000 AND saldod-saldoa > 0";
	$result = $link->query($sql);

	$id = $id+1;

	echo "<tr><td class='blanco b' colspan='6'>Asiento: $id Fecha: $b Tipo: Regularizaci&oacute;n</td></tr>";

	echo "<tr><td><a href='extractoctas.php?cuenta=12900000'>12900000</a></td><td>".$cr['descripci_']."</td><td></td><td class='dcha'>".number_format($tot[0]*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td><td></td><td></td></tr>";

	$array[] = "INSERT INTO asientos (asiento, fecha, tipo, sumadebe, sumahaber) VALUES ('$id', '$fecha', 'Regularizaci&oacute;n', '$tot[0]', '$tot[0]')";
	$array[] = "INSERT INTO apuntes (asiento, fecha, tipo, cuenta, contrap, concepto, debe, ip) VALUES ('$id', '$fecha', 'Regularizaci&oacute;n', '12900000', '', '', '$tot[0]', '$ip')";

	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

		extract($fila);

		echo "<tr><td><a href='extractoctas.php?cuenta=$cuenta'>$cuenta</a></td><td>$descripci_</td><td></td><td></td><td class='dcha'>".number_format($saldo*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td><td></td></tr>";

		if ($saldo) {
			$array[] = "INSERT INTO apuntes (asiento, fecha, tipo, cuenta, contrap, concepto, haber, ip) VALUES ('$id', '$fecha', 'Regularizaci&oacute;n', '$cuenta', '', '', '$saldo', '$ip')"; 
		}

	}

	echo "<tr class='b'><td class='blanco dcha' colspan='3'>SUMAS:</td><td class='blanco dcha'>".number_format($tot[0]*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td><td class='blanco dcha'>".number_format($tot[0]*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td><td class='blanco'></td></tr>";

	echo "<tr><td class='verde' colspan='6'>&nbsp;</td></tr>";

}

//*************************************************

$result = $link->query("SELECT SUM(saldoa-saldod) FROM subcuent WHERE cuenta >=60000000 AND cuenta <=80000000 AND saldoa-saldod > 0");
$tot = $result->fetch_array(MYSQLI_BOTH);

if ($tot[0]) {

	$sql = "SELECT *,saldoa-saldod AS saldo FROM subcuent WHERE cuenta >=60000000 AND cuenta <=80000000 AND saldoa-saldod > 0";
	$result = $link->query($sql);

	$id = $id+1;

	echo "<tr><td colspan='6' class='blanco b'>Asiento: $id Fecha: $b Tipo: Regularizaci&oacute;n</td></tr>";

	$array[] = "INSERT INTO asientos (asiento, fecha, tipo, sumadebe, sumahaber) VALUES ('$id', '$fecha', 'Regularizaci&oacute;n', '$tot[0]', '$tot[0]')";

	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

		extract($fila);

		echo "<tr><td><a href='extractoctas.php?cuenta=$cuenta'>$cuenta</a></td><td>$descripci_</td><td></td><td class='dcha'>".number_format($saldo*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td><td></td><td></td></tr>";

		if ($saldo) {
			$array[] = "INSERT INTO apuntes (asiento, fecha, tipo, cuenta, contrap, concepto, debe, ip) VALUES ('$id', '$fecha', 'Regularizaci&oacute;n', '$cuenta', '', '', '$saldo', '$ip')"; 
		}

	}

	echo "<tr><td><a href='extractoctas.php?cuenta=12900000'>12900000</a></td><td>".$cr['descripci_']."</td><td></td><td></td><td class='dcha'>".number_format($tot[0]*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td><td></td></tr>";

	$array[] = "INSERT INTO apuntes (asiento, fecha, tipo, cuenta, contrap, concepto, haber, ip) VALUES ('$id', '$fecha', 'Regularizaci&oacute;n', '12900000', '', '', '$tot[0]', '$ip')"; 

	echo "<tr class='b'><td class='blanco' colspan='3' class='dcha'>SUMAS:</td><td class='blanco dcha'>".number_format($tot[0]*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td><td class='blanco dcha'>".number_format($tot[0]*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td><td class='blanco'></td></tr>";

}

//*************************************************

echo "</table>";

if (!$array) {

	echo "No se a&ntilde;adir&aacute;n Asientos.";

}

//*************************************************

if ($_POST['crear'] AND $array) {

	foreach ($array as $clave=>$valor) {
		$link->query($array[$clave]);
	}

	include ('sumsubcuent.php');

	echo "<div id='dialog' title='Regularizaci&oacute;n Ejercicio'>";
	echo "Se han a&ntilde;adido los Asientos.";
	echo "</div>";

}

?>

<?php $top = 1; include("pie.php");?></body></html>
