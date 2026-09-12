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

<body <?php if (!$bloqueo AND $accion == 'editar' AND !$_POST['nuevocuenta']) {echo "onload=\"foco('nuevocuenta')\"";}?>>

<?php
include("arriba.php");
$menu12=6;include("menusizda.php");

//include ('sumsubcuent.php');
extract($_GET);

?>

<table class='basica 100 hover' width='100%'>
<tr>
<th class='anchomin'><a href='listactas3.php'>Cuenta</a></th><th><a href='listactas3.php?x=alfa'>Descripci&oacute;n</a></th>
</tr>

<?php

if ($_POST['nuevocuenta']) {

	extract($_POST);

	$link->query("UPDATE cuentas SET descripcio = '$nuevodescripci2_' WHERE cuenta = '$cuenta'") or die ("El usuario $usuario no tiene permisos para modificar Cuentas.");

	if ($nuevocuenta != $cuenta AND $nuevocuenta > 99) {
		$link->query("UPDATE cuentas SET cuenta = '$nuevocuenta' WHERE cuenta = '$cuenta'") or die ("El usuario $usuario no tiene permisos para modificar Cuentas o cuenta ya existente.");
	}

	if ($nuevocuenta <= 99) {
		echo "El nº de Cuenta debe de ser num&eacute;rico con 3 d&iacute;gitos. No se ha realizado el cambio.";
	}
	$accion = "";
	$cuenta = "";

}

if ($x) {$orden = "descripcio";} else {$orden = "cuenta";}
$rs=$link->query("SELECT cuenta, descripcio, sdo3cd, sdo3ca FROM cuentas ORDER BY $orden");

// bucle de listado

while($row=$rs->fetch_array(MYSQLI_BOTH)) {

	echo "<tr>";

	echo "<td class='dcha anchomin'>[ <a href='?accion=editar&cuenta=".$row['cuenta']."&x=$x'>Editar</a> ]&nbsp;&nbsp;";

	if ($row['sdo3cd'] != 0 || $row['sdo3ca'] != 0 )
	{
		echo "<a href='extractoctas3.php?cuenta=".$row['cuenta']."'>";
	}
	echo $row['cuenta'];
	if ($row['sdo3cd'] != 0 || $row['sdo3ca'] != 0 )
	{
		echo "</a>";
	}

	echo "</td><td class='wid99'>".$row['descripcio']."</td>";

	echo "</tr>";

} 

?>

</table>

<?php

if ($accion=="editar" AND $cuenta) {
	echo "<div id='dialog' title='Editar Cuenta $cuenta'>";
	$param = "cuentas";
	$cuenta = $cuenta;
	include("ctas3edit.php");
	echo "</div>";
}

?>

<?php $top = 1; include("pie.php");?></body></html>
