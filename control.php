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
	return;
}
?>

<body>

<?php
include("arriba.php");
$menu13=6;include("menusizda.php");

$boapu = $_GET['boapu'];

if ($boapu == 't') {

	$sql = "SELECT apuntes.row_id from apuntes LEFT JOIN asientos on asientos.asiento = apuntes.asiento WHERE asientos.asiento is NULL";
	$result = $link->query($sql);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$link->query("DELETE FROM apuntes WHERE row_id = '$fila[0]'");
	}

} else {

	if ($boapu) {

		$sql = "SELECT asientos.asiento, apuntes.asiento from apuntes LEFT JOIN asientos on asientos.asiento = apuntes.asiento WHERE apuntes.row_id = '$boapu'";
		$result = $link->query($sql);
		$fila = $result->fetch_array(MYSQLI_BOTH);
		if ($fila[0] != $fila[1]) {$link->query("DELETE FROM apuntes WHERE row_id = '$boapu'");}

	}

}

$sql = "SELECT apuntes.row_id from apuntes LEFT JOIN asientos on asientos.asiento = apuntes.asiento WHERE asientos.asiento is NULL";
$result = $link->query($sql);
$num = $result->num_rows;

if ($num) {
	echo "<span class='rojo b'>Hay $num Apuntes hu&eacute;rfanos. </span>[ <a href=?boapu=t onclick=\"return confirm('Confirmar borrado')\">BORRAR TODOS</a> ]<p />";
}

$sql = "SELECT asientos.asiento, apuntes.asiento, apuntes.cuenta, subcuent.cuenta, apuntes.row_id from apuntes left join subcuent ON subcuent.cuenta = apuntes.cuenta LEFT JOIN asientos on asientos.asiento = apuntes.asiento ORDER BY apuntes.asiento";
$result = $link->query($sql);

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	$mensaje = "";
	$x0 = ""; $x1 = ""; $x2 = "";

	if ($fila[0] != $fila[1]) {
		$mensaje = "<span class='rojo b'>Error</span>: Apunte hu&eacute;rfano.<br />";
		$result1 = $link->query("SELECT concepto, debe, haber FROM apuntes WHERE row_id = '$fila[4]'");
		$fila1 = $result1->fetch_array(MYSQLI_BOTH);
		$mensaje .= "<span class='peq rojo b'>$fila1[0]. ";
		if ($fila1[1] != 0) {$mensaje .= "Debe: $fila1[1]";}
		if ($fila1[2] != 0) {$mensaje .= "Haber: $fila1[2]";}
		$mensaje .= "</span> [ <a href='?boapu=$fila[4]'>BORRAR</a> ]";
	}

	if ($fila[2] == 'NULL') {$mensaje .= "<span class='rojo b'>Error</span> en Asiento ".$fila[0].", hay un apunte sin Subcuenta asociada.<br />";}
	
	if ($fila[2] != $fila[3]) {
		$mensaje .= "<span class='rojo b'>Error</span> en Asiento ".$fila[0].", no existe la Subcuenta $fila[2].<br />";
		$x1 = " Subcuenta: <span class='rojo b'>Error</span> - ";
	} else {
		$x0 = " Subcuenta: ".$fila[3]." OK - ";
	}

	$cuenta = substr($fila[3],0,3);
	$subgrupo = substr($fila[3],0,2);

	$sql1 = "SELECT cuenta FROM cuentas WHERE cuenta = '$cuenta'";
	$result1 = $link->query($sql1);
	if ($result1->num_rows == 0) {
		$mensaje .= "<span class='rojo b'>Error</span> en Asiento ".$fila[0].", no existe la Cuenta $cuenta en la tabla Cuentas.<br />";
		$x1 = " Cuenta: <span class='rojo b'>Error</span> - ";
	} else {
		$x1 = $result1->fetch_array(MYSQLI_BOTH);
		$x1 = " Cuenta: ".$x1[0]." OK - ";
	}


	$sql2 = "SELECT subgrupo FROM subgrupo WHERE subgrupo = '$subgrupo'";
	$result2 = $link->query($sql2);
	if ($result2->num_rows == 0) {
		$mensaje .= "<span class='rojo b'>Error</span> en Asiento ".$fila[0].", no existe el Subgrupo $subgrupo en la tabla Subgrupos.<br />";
		$x2 = " Subgrupo: <span class='rojo b'>Error</span>";
	} else {
		$x2 = $result2->fetch_array(MYSQLI_BOTH);
		$x2 = " Subgrupo: ".$x2[0]." OK";
	}

	if ($mensaje) {
		$error = 1;
		echo "Apunte: ".$fila[4]." [Asiento: <a href=editasi2.php?asiento=".$fila[1].">".$fila[1]."</a> Subcuenta: ".$fila[2]."]<br />Tablas: ".$x0.$x1.$x2."<br />".$mensaje."<hr>";
	}
}

if (!$error) {echo "No se han detectado errores en las tablas.";}

?>

</div>

<?php $top = 0; include("pie.php");?>

</body></html>
