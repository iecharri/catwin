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

//recordar volver a poner include ('sumsubcuent.php');

$result = $link->query("SELECT asiento FROM asientos WHERE tipo = 'Cierre'");
$cr = $result->num_rows;

if (!$cr) {
	$mensaje = "Ejercicio actual no cerrado. No se puede abrir el siguiente.<p /></div></body></html>";
}

?>

<body 

<?php if (!$mensaje AND !$bloqueo) {echo " onload = 'this.document.form1.bd.focus()'";}?>

>

<?php
include("arriba.php");
$menu13=5;include("menusizda.php");

if ($_SESSION['auto'] < 5) {echo "Usuario no autorizado";echo "</div></body></html>";exit;}

?>Apertura siguiente Ejercicio<p />

Ha de estar creada la base de datos correspondiente al nuevo ejercicio con la opci&oacute;n de Crear Empresa.<br />
Se sugiere denominar los distintos ejercicios de la siguiente manera, seg&uacute;n corresponda: nuevocat2005, nuevocat2006, etc.<p />
<?php if ($mensaje) {echo $mensaje;exit;}

$result = $link->query("SELECT anocont FROM empresa");
$row = $result->fetch_array(MYSQLI_BOTH);
$fecha = ($row[0]+1)."-01-01";
$b = "01/01/".substr(($row[0]+1),2,2);

$result = $link->query("SELECT ultasi FROM empresa");
$fila = $result->fetch_array(MYSQLI_BOTH);
$id = $fila[0] + 1;
$link->query("UPDATE empresa SET ultasi = '$id' WHERE 1");

echo "Se va a a&ntilde;adir el siguiente Asiento de Apertura con fecha $b ";
echo "<form name='form1' method='post' style='display:inline'>";
echo "a la Empresa: <input type='text' name='bd' size='12' maxlength='12'";
if ($_POST['bd']) {echo " value= '".$_POST['bd']."' readonly = 'readonly'";}
echo ">";
echo " <input type='submit' name='ver' value=' Ver '>";
if (($_POST['ver'] OR $_POST['crear']) AND $_POST['bd']) {
	$reg = existebd($_POST['bd'], $link);
	if ($reg > 0){
		echo " <input type='submit' name='crear' value='Alta Asiento'>";
	} else {
		echo $reg."</div></body></html>";exit;
	}
	
}
echo "</form><br />";

if ($_POST['ver'] OR $_POST['crear']) {

	$array = ver($b, $reg, $fecha, $link);

}

if ($_POST['crear'] AND $array) {

	mysqli_select_db($link,$_POST['bd']) or die ("Error");
	$link->query("set names 'utf8'");
	foreach ($array as $clave=>$valor) {
		$link->query($array[$clave]);
	}
	mysqli_select_db($link,$_SESSION['empresa']) or die ("Error");
	$link->query("set names 'utf8'");
	echo "<div id='dialog' title='Apertura Ejercicio'>";
	echo "Se ha a&ntilde;adido el Asiento.";
	echo "</div>";

}

?>

</div>

<?php include("pie.php");?>

</body></html>

<?php

function ver($b, $reg, $fecha, $link) {

	$result = $link->query("SELECT asiento, tipo, sumadebe, sumahaber FROM asientos WHERE tipo = 'Cierre'");
	$fila = $result->fetch_array(MYSQLI_BOTH);
	$asiento = $fila[0];
	$sumadebe = $fila['sumadebe'];
	$sumahaber = $fila['sumahaber'];
	$array[] = "INSERT INTO asientos (asiento, fecha, tipo, sumadebe, sumahaber) VALUES ('$reg', '$fecha', 'Apertura', '$fila[3]', '$fila[2]')";

	echo "<table class='basica 100' width='100%'>";cabasi("");
	echo "<tr><td class='blanco b' colspan='6'>Asiento: $reg Fecha: $b Tipo: Apertura</td></tr>";

	$result = $link->query("SELECT apuntes.cuenta, debe, haber, subcuent.descripci_ FROM apuntes LEFT JOIN subcuent ON subcuent.cuenta = apuntes.cuenta WHERE asiento = '$asiento' ORDER BY haber DESC");

	$ip = $_SERVER['HTTP_CLIENT_IP'];
	if (!$ip) {$ip = $_SERVER['REMOTE_ADDR'];}

	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	 	echo "<tr><td><a href='extractoctas.php?cuenta=".$fila['cuenta']."'>".$fila['cuenta']."</a></td><td>".$fila['descripci_']."</td><td></td>";
		if ($fila['debe']) {
			echo "<td></td><td class='dcha'>".number_format($fila['debe']*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td><td></td></tr>";
			$array[] = "INSERT INTO apuntes (asiento, fecha, cuenta, debe, haber, ip) VALUES ('$reg', '$fecha', '$fila[0]', '', '$fila[1]', '$ip')";
		}
		if ($fila['haber']) {
			echo "<td class='dcha'>".number_format($fila['haber']*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td><td></td><td></td></tr>";
			$array[] = "INSERT INTO apuntes (asiento, fecha, cuenta, debe, haber, ip) VALUES ('$reg', '$fecha', '$fila[0]', '$fila[2]', '', '$ip')";
		}

	}

	echo "<tr class='b'><td class='blanco dcha' colspan='3'>SUMAS:</td><td class='blanco dcha'>".number_format($sumahaber*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td><td class='blanco dcha'>".number_format($sumadebe*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td><td class='blanco'></td></tr>";

	echo "</table>";

	return $array;

}

function existebd($empresa, $link) {
	$result = $link->query("SELECT anocont FROM empresa");
	$anoact = $result->fetch_array(MYSQLI_BOTH);
	$bd = $link->query('SHOW DATABASES');
	while ($fila = $bd->fetch_array(MYSQLI_BOTH)) {
		if ($fila[0] == $empresa) {
			mysqli_select_db($link,$empresa) or die ("Error");
			$link->query("set names 'utf8'");
			$result = $link->query("SELECT max(asiento) FROM asientos");
			$row = $result->fetch_array(MYSQLI_BOTH);
			$id = $row[0] + 1;
			$result = $link->query("SELECT asiento FROM asientos WHERE tipo='Apertura'");
			$apertura = $result->num_rows;
			$result = $link->query("SELECT anocont FROM empresa");
			$ano = $result->fetch_array(MYSQLI_BOTH);
			mysqli_select_db($link,$_SESSION['empresa']) or die ("Error");
			$link->query("set names 'utf8'");
			if ($apertura) {return "<p />Ya estaba hecho el asiento de Apertura.";}
			if (($anoact[0]+1) != $ano[0]) {return "<p />El a&ntilde;o contable de <span class='b'>$empresa ($ano[0])</span> no es el siguiente del de <span class='b'>".$_SESSION['empresa']." ($anoact[0])</span>.";}
			return $id;
		}
	}
	return "<p />No existe la Empresa <span class='b'>$empresa</span>.";
}

