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

<body <?php if (!$bloqueo AND $accion == 'editar' AND !$_POST['nuevosubcuenta']) {echo "onload=\"foco('nuevosubcuenta')\"";}?>>

<?php
include("arriba.php");
$menu12=5;include("menusizda.php");

extract($_GET);

?>

<table class='basica 100 hover' width='100%'>
<tr>
<th class='anchomin'><a href='listactas.php'>Subcuenta</a></th><th><a href='?x=alfa'>Descripci&oacute;n</a></th><th>Cuenta Corriente</th><th>Tel&eacute;fono</th><th>Tel&eacute;fono</th><th title='Contrapartida' class='anchomin'>C.</th><th title='Importe por omisi&oacute;n' class='anchomin'>I.O.</th>
</tr>

<?php

if ($_POST['nuevosubcuenta']) {

	$link->query("UPDATE subcuent SET descripci_ = '$nuevodescripci3_', natura = '$natura', telefono = '$telefono', telefono2 = '$telefono2', ctacte = '$ctacte', contrapda = '$cuenta1', importomis = '$importomis' WHERE cuenta = '$subcuenta'") or die ("El usuario $usuario no tiene permisos para modificar Subcuentas.");

	if ($nuevosubcuenta != $subcuenta AND $nuevosubcuenta > 99999) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
		if (!$ip) {$ip = $_SERVER['REMOTE_ADDR'];}
		$link->query("UPDATE subcuent SET cuenta = '$nuevosubcuenta' WHERE cuenta = '$subcuenta'") or die ("El usuario $usuario no tiene permisos para modificar Subcuentas o subcuenta ya existente.");
		$link->query("UPDATE apuntes SET cuenta = '$nuevosubcuenta', ip = '$ip' WHERE cuenta = '$subcuenta'");
	}

	if ($nuevosubcuenta <= 99999) {

		echo "El nº de Subcuenta debe de ser num&eacute;rico con 6 d&iacute;gitos. No se ha realizado el cambio.";

	}
	$accion = "";
	$cuenta = "";

}

if ($x) {$orden = "descripci_";} else {$orden = "cuenta";}
$rs=$link->query("SELECT cuenta, descripci_, saldod, saldoa, ctacte, telefono, telefono2, contrapda, importomis FROM subcuent ORDER BY $orden");

// bucle de listado

while($row=$rs->fetch_array(MYSQLI_BOTH)) {

	echo "<tr>";

	echo "<td class='dcha anchomin'>[ <a href='?accion=editar&subcuenta=".$row['cuenta']."&x=$x'>Editar</a> ]&nbsp;&nbsp;";
				
	if ($row['saldod'] != 0 || $row['saldoa'] != 0 )
	{
		echo "<a href='extractoctas.php?cuenta=".$row['cuenta']."'>";
	}

	echo $row['cuenta'];

	if ($row['saldod'] != 0 || $row['saldoa'] != 0 )
	{
		echo "</a>";
	}

	echo "</td><td>".$row['descripci_']."</td>";

	echo "<td>".$row['ctacte']."</td><td>".$row['telefono']."</td><td>".$row['telefono2']."</td>";

	echo "<td>";
	if ($row['contrapda']) {
		$result = $link->query("SELECT descripci_ FROM subcuent WHERE cuenta = '".$row['contrapda']."'");
		$row1 = $result->fetch_array(MYSQLI_BOTH);
		echo "<span title='$row1[0]'>".$row['contrapda']."</span>";
	}
	echo "</td><td class='dcha'>";
	if ($row['importomis']) {echo number_format($row['importomis']*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."";}
	echo "</td>";


	echo "</tr>";

}
?>

</table>

<?php

if ($accion=="editar" AND $subcuenta) {
	echo "<div id='dialog' title='Editar subcuenta $subcuenta'>";
	$param = "subcuenta";
	$cuenta = $subcuenta;
	include("ctasedit.php");
	echo "</div>";
}

?>

<?php $top = 1; include("pie.php");?></body></html>
