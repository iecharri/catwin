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

<body <?php if($xxx != "") {echo "onload=\"foco('proveed')\"";}?>>

<?php
include("arriba.php");
$menu51=1;include("menusizda.php");

$codigo = $_GET['codigo'];

if ($xxx == 'Anadir1') {
	$link->query("INSERT INTO proveed (proveed, direcci_n, tel_fono) VALUES ('$proveed', '$direcci_n', '$tel_fono')" ) or die ("<p />El usuario $usuario no tiene permisos para a&ntilde;adir Proveedores");
	$xxx="";
}

if ($xxx == 'Editar1') {
	extract($_POST);
	$num = 1;
	if ($cuenta AND $_SESSION['auto'] > 4) {
		$result = $link->query("SELECT cuenta FROM subcuent WHERE cuenta = '$cuenta'");
		$num = $result->num_rows;
	}
	
	if (!$num) {
		$link->query("UPDATE proveed SET proveed = '$proveed', direcci_n = '$direcci_n', tel_fono = '$tel_fono', cuenta = '$cuenta' WHERE codigo = '$codigo'") or die ("<p />El usuario $usuario no tiene permisos para modificar Proveedores");
		if($_SESSION['auto'] > 4) {
			$link->query("INSERT INTO subcuent (cuenta, descripci_) VALUES ('$cuenta', '$proveed')");
		} 
	} else {
		$link->query("UPDATE proveed SET proveed = '$proveed', direcci_n = '$direcci_n', tel_fono = '$tel_fono' WHERE codigo = '$codigo'") or die ("<p />El usuario $usuario no tiene permisos para modificar Proveedores"); 
		if($_SESSION['auto'] > 4) {
			echo "<div class='solocontable'>Se ha modificado el Proveedor, pero no ha sido posible asignarle el n&uacute;mero de Subcuenta</div><p />";
		}
	}		
}

if ($xxx == 'Borrar') {

	$link->query("DELETE FROM proveed WHERE codigo = $codigo") or die ("<p />El usuario $usuario no tiene permisos para borrar  Proveedores");

}

?>

<div id='div1'>

<table class='basica 100 hover' width='100%'>
<tr>
<th>Validado</th><th>Proveedor [ <a href='gcproveedores.php?xxx=Anadir'>A&ntilde;adir Proveedor</a> ]</th><th>Direcci&oacute;n</th><th>Tel&eacute;fono</th>
</tr>

<?php

$rs = $link->query("SELECT codigo, proveed, direcci_n, tel_fono, cuenta FROM proveed ORDER BY proveed");

// bucle de listado

while($row = $rs->fetch_array(MYSQLI_BOTH)) {

	echo "<tr>";
	echo "<td class='centro'>";
	if ($row['cuenta']) {echo "S&Iacute;";} else {echo "NO";}
	echo "</td>";
	echo "<td><a href='gcproveedores.php?xxx=Editar&codigo=".$row['codigo']."'>";
	echo $row['proveed']."</a>";
	echo "</td><td>".$row['direcci_n']."</td>";
	echo "</td><td>".$row['tel_fono']."</td>";
	echo "</tr>";

}

?>

</table>

</div><div id='div2'>

<?php

if ($xxx == "Anadir") {

	echo "<form action='gcproveedores.php?xxx=Anadir1' name='form1' method='post'>";
	echo "<label>Proveedor</label><br /><input type = 'text' size='40' maxlength='40' name='proveed'><br />";
	echo "<label>Direcci&oacute;n</label><br /><input type = 'text' size='40' maxlength='80' name='direcci_n'><br />";
	echo "<label>Tel&eacute;fono</label><br /><input type = 'text' size='30' maxlength='30' name='tel_fono'><p />";
	echo "<input type = 'submit' value = 'A&ntilde;adir' onclick='return gcprov(form1)'>";
	echo "</form>\n";

}

if ($xxx == "Editar") {

	$result = $link->query("SELECT * FROM proveed WHERE codigo = $codigo");

	$fila = $result->fetch_array(MYSQLI_BOTH);

	$temp = "";
	if ($fila['cuenta']) {
		if ($_SESSION['auto'] < 5) {
		$temp = " readonly='readonly'";
			echo "<span class='rojo'>¡Atenci&oacute;n! El Proveedor no puede ser borrado, ni modificada la denominaci&oacute;n, porque se encuentra validado en Contabilidad</span><p />";
		} else {
		echo "<div class='solocontable'>¡Atenci&oacute;n! El Proveedor se encuentra validado en Contabilidad como una Subcuenta, si se modifica aqu&iacute;, los cambios no quedar&aacute;n reflejados en la tabla de Subcuentas.</div>";
		}	
	}
	echo "<p /><form action='gcproveedores.php?xxx=Editar1' name='form1' method='post'>";
	echo "<input type = 'hidden' value ='".$fila[0]."' name='codigo'>";
	echo "<label>Proveedor</label><br /><input type = 'text' value ='".$fila[1]."' $temp size='40' maxlength='40' name=proveed><br />";
	echo "<label>Direcci&oacute;n</label><br /><input type = 'text' value ='".$fila[2]."' size='40' maxlength='80' name=direcci_n><br />";
	echo "<label>Tel&eacute;fono</label><br /><input type = 'text' value ='".$fila[3]."' size='30' maxlength='30' name=tel_fono><p />";
	if (!$fila['cuenta'] AND $_SESSION['auto'] > 4) {
		echo "<div class='solocontable'>Asignar Subcuenta<br /><input type='text' size='8' name='cuenta'></div><p />";
	}
	echo "<input type = 'submit' value = 'Confirmar cambios' onclick='return gcprov(form1)'></form>\n";
	if (!$temp) {
		echo "<form action='?xx=Proveedores&xxx=Borrar' name='form2' method='post'>\n";
		echo "<input type='hidden' name='codigo' value=".$codigo.">\n";
		echo "<input type='submit' value='Borrar Proveedor' onclick='return borrar_proveed()'></form>\n";
		if ($fila['cuenta']) {echo "<p /><div class='solocontable'>Si se borra el Proveedor no se borrar&aacute; su equivalente en la tabla de Subcuentas.</div>";}
	}

}

?>

</div>

<?php $top = 1; include("pie.php");?></body></html>
