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

if ($_SESSION['auto'] < 5) {
	echo "Usuario no autorizado";
	echo "</div>";
	include("pie.php");
	echo "</body></html>";
	exit;
}

?>Regularizaci&oacute;n del IVA (en construcci&oacute;n)<p /><?php

$result = $link->query("SELECT * from subcuent WHERE cuenta = '47500000' OR cuenta = '47700000' OR cuenta = '47200000' OR cuenta = '47000000'");
$fila = $result->num_rows;
if ($fila < 4) {echo "No existe la Subcuenta 47500000, 47700000, 47200000 &oacute; 47000000</div></body></html>";exit;}

echo "<a href=regiva.php?accion=ver>Ver Asientos de Regularizaci&oacute;n del IVA</a> ";
echo "<form name=form1 method=post action=regiva.php>";
echo "Regularizaci&oacute;n ";
echo "
<select name=tipo>
<option value='1'";
if ($_POST['tipo'] == 1) {echo " selected";}
echo "
>Mensual
<option value='03'";
if ($_POST['tipo'] == 3) {$_POST['mes'] = $_POST['tipo']; echo " selected";}
echo "
>Trimestral - 03
<option value='06'";
if ($_POST['tipo'] == 6) {$_POST['mes'] = $_POST['tipo']; echo " selected";}
echo "
>Trimestral - 06
<option value='09'";
if ($_POST['tipo'] == 9) {$_POST['mes'] = $_POST['tipo']; echo " selected";}
echo "
>Trimestral	- 09
<option value='12'";
if ($_POST['tipo'] == 12) {$_POST['mes'] = $_POST['tipo']; echo " selected";}
echo "
>Trimestral	- 12
<option value='13'";
if ($_POST['tipo'] == 13) {$_POST['mes'] = 12; echo " selected";}
echo "
>Anual</option>
</select>
";
echo " a fin del mes: <input type='text' name='mes' size='2' maxlength='2' value=".$_POST['mes']."> <input type='submit' name='regiva' value=' Ver '> ";
if ($_POST['mes'] AND $_POST['regiva']) {
	echo "<input type='submit' name='regiva1' value=' Alta Asiento '>";
}
echo "</form>";

if ($_GET['accion'] == "ver") {
	$result = $link->query("SELECT asiento FROM asientos WHERE tipo = 'Reg. del IVA'");
	regiva($result,$link);
}

if ($_POST['mes'] AND ($_POST['regiva'] OR $_POST['regiva1'])) {
	$array = iva($_POST['tipo'], $_POST['mes'],$link);
}

if ($_POST['regiva1'] AND $array) {

	include ('sumsubcuent.php');
	foreach ($array as $clave=>$valor) {
		$link->query($array[$clave]) or die ("Error");
	}
	include ('sumsubcuent.php');

	echo "<div id='dialog' title='Regularizaci&oacute;n del IVA'>";
	echo "<p class='verde b'>Se ha a&ntilde;adido el Asiento<p />";
	echo "</div>";

}

function regiva($result,$link) {

if ($result->num_rows > 0) {

	echo "<table class='basica 100' width='100%'>";cabasi("");
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		asiento($link, $fila[0], "", $_SESSION['moneda'], $_SESSION['deci'],$_GET['bojust']);
	}
	$fecha = explode("-",$fila['fecha']);
	echo "</table>";

}

}

function iva($tipo, $mes, $link) {

	$ip = $_SERVER['HTTP_CLIENT_IP'];
	if (!$ip) {$ip = $_SERVER['REMOTE_ADDR'];}

	$result = $link->query("SELECT ultasi FROM empresa");
	$fila = $result->fetch_array(MYSQLI_BOTH);
	$id = $fila[0] + 1;
	$link->query("UPDATE empresa SET ultasi = '$id' WHERE 1");

	$result = $link->query("SELECT anocont FROM empresa");
	$fila = $result->fetch_array(MYSQLI_BOTH);
	$lastday = mktime(0, 0, 0, $mes+1, 0, $fila[0]);
	$fecha = strftime("%d", $lastday)."/".$mes."/".$fila[0];
	$finsert = $fila[0]."-".$mes."-".strftime("%d", $lastday);

	$mes = $b = explode("/",$fecha);
	$mes = $mes[1];
	if ($tipo == 1) {
		$fecha1 = $fila[0]."-".$mes."-01";
		$fecha2 = $fila[0]."-".$mes."-31";
	}
	if ($tipo >= 3 AND $tipo <= 12) {
		$fecha1 = $fila[0]."-".($tipo-2)."-01";
		$fecha2 = $fila[0]."-".$tipo."-31";
	}
	if ($tipo == 13) {
		$fecha1 = $fila[0]."-01-01";
		$fecha2 = $fila[0]."-12-31";
	}

	$result = $link->query("SELECT SUM(debe) AS debe, SUM(haber) AS haber FROM apuntes WHERE cuenta = '47700000' AND fecha >= '$fecha1' AND fecha < '$fecha2'");
	$tot477 = $result->fetch_array(MYSQLI_BOTH);
	$tot477 = $tot477[0]-$tot477[1];
	$result = $link->query("SELECT SUM(debe) AS debe, SUM(haber) AS haber FROM apuntes WHERE cuenta = '47200000' AND fecha >= '$fecha1' AND fecha < '$fecha2'");
	$tot472 = $result->fetch_array(MYSQLI_BOTH);
	$tot472 = $tot472[0]-$tot472[1];

	echo "<table class='basica 100' width='100%'>";cabasi("");
	
	echo "<tr><td class='blanco b' colspan='6'>Asiento: <a href='editasi2.php?asiento=$id'>$id</a> Fecha: $fecha Tipo: Reg. del IVA</td></tr>";

	$result = $link->query("SELECT descripci_ FROM subcuent WHERE cuenta = '47700000'");
	$cr = $result->fetch_array(MYSQLI_BOTH);
	echo "<tr><td><a href='extractoctas.php?cuenta=47700000'>47700000</a></td><td>$cr[0]</td><td></td>";
	echo "<td class='dcha'>";
	if ($tot477 < 0) {
		echo number_format(0-($tot477*$_SESSION['moneda']),$_SESSION['deci'],',','.');
		$totf = 0 - $tot477;
		$array[] = "INSERT INTO apuntes (asiento, fecha, tipo, cuenta, contrap, concepto, debe, ip) VALUES ('$id', '$finsert', 'Reg. del IVA', '47700000', '', '', '$totf', '$ip')";

	}
	echo "</td>";
	echo "<td class='dcha'>";
	if ($tot477 > 0) {
		echo number_format($tot477*$_SESSION['moneda'],$_SESSION['deci'],',','.');
		$totf = $tot477;
		$array[] = "INSERT INTO apuntes (asiento, fecha, tipo, cuenta, contrap, concepto, haber, ip) VALUES ('$id', '$finsert', 'Reg. del IVA', '47700000', '', '', '$tot477', '$ip')";
	}
	echo "</td><td></td>";
	echo "</tr>";

	$result = $link->query("SELECT descripci_ FROM subcuent WHERE cuenta = '47200000'");
	$cr = $result->fetch_array(MYSQLI_BOTH);
	echo "<tr><td><a href='extractoctas.php?cuenta=47200000'>47200000</a></td><td>$cr[0]</td><td></td>";
	echo "<td class='dcha'>";
	if ($tot472 < 0) {
		echo number_format(0-($tot472*$_SESSION['moneda']),$_SESSION['deci'],',','.');
		if ($totf < 0 - $tot472) {$totf = 0 - $tot472;}
		$array[] = "INSERT INTO apuntes (asiento, fecha, tipo, cuenta, contrap, concepto, debe, ip) VALUES ('$id', '$finsert', 'Reg. del IVA', '47200000', '', '', '$totf', '$ip')";
	}
	echo "</td>";
	echo "<td class='dcha'>";
	if ($tot472 > 0) {
		echo number_format($tot472*$_SESSION['moneda'],$_SESSION['deci'],',','.');
		if ($totf < $tot472) {$totf = $tot472;}
		$array[] = "INSERT INTO apuntes (asiento, fecha, tipo, cuenta, contrap, concepto, haber, ip) VALUES ('$id', '$finsert', 'Reg. del IVA', '47200000', '', '', '$tot472', '$ip')";
	}
	echo "</td><td></td>";
	echo "</tr>";

	$tot = $tot477 + $tot472;
	echo "<tr><td>";
	if ($tot > 0) {
		$result = $link->query("SELECT descripci_ FROM subcuent WHERE cuenta = '47000000'");
		$cr = $result->fetch_array(MYSQLI_BOTH);
		echo "<a href='extractoctas.php?cuenta=47000000'>47000000</a>"; $cue = "47000000";
	} else {
		$result = $link->query("SELECT descripci_ FROM subcuent WHERE cuenta = '47500000'");
		$cr = $result->fetch_array(MYSQLI_BOTH);
		echo "<a href='extractoctas.php?cuenta=47500000'>47500000</a>"; $cue = "47500000";
	}
	echo "</td><td>$cr[0]</td><td></td>";
	echo "<td class='dcha'>";
	if ($tot > 0) {
		echo number_format($tot*$_SESSION['moneda'],$_SESSION['deci'],',','.');
		$array[] = "INSERT INTO apuntes (asiento, fecha, tipo, cuenta, contrap, concepto, debe, ip) VALUES ('$id', '$finsert', 'Reg. del IVA', '$cue', '', '', '$tot', '$ip')";
	}
	echo "</td>";
	echo "<td class='dcha'>";
	if ($tot < 0) {$tot = 0-$tot;
		echo number_format($tot*$_SESSION['moneda'],$_SESSION['deci'],',','.');
		$array[] = "INSERT INTO apuntes (asiento, fecha, tipo, cuenta, contrap, concepto, haber, ip) VALUES ('$id', '$finsert', 'Reg. del IVA', '$cue', '', '', '$tot', '$ip')";
	}
	echo "</td><td></td></tr>";

	if ($totf < 0) {$totf = 0 - $totf;}
	echo "<tr class='b'><td class='blanco dcha' colspan='3'>SUMAS:</td>";
	echo "<td class='blanco dcha'>".number_format($totf*$_SESSION['moneda'],$_SESSION['deci'],',','.');
	echo "</td>";
	echo "<td class='blanco dcha'>".number_format($totf*$_SESSION['moneda'],$_SESSION['deci'],',','.');
	echo "</td><td class='blanco'></td></tr>";

	echo "</table>";

	if ($array) {
		$array[] = "INSERT INTO asientos (asiento, fecha, tipo, sumadebe, sumahaber) VALUES ('$id', '$finsert', 'Reg. del IVA', '$totf', '$totf')";
	} else {
		echo "No se a&ntilde;adir&aacute; ning&uacute;n Asiento.";
	}
	return $array;

}

?>

<?php $top = 1; include("pie.php");?></body></html>

