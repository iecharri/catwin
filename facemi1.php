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
include("jdatepicker.php");

if (!$link OR !$_SESSION['empresa']) {
	include("noempresa.php");
	exit;
}
?>

<body<?php if (!$bloqueo) {echo " onload=\"foco('asiento')\"";}?>>

<?php
include("arriba.php");
$menu11=4;include("menusizda.php");

if ($totfac) {
	include ("facemi2.php");
}

$result = $link->query("SELECT ultasi, ultfact FROM empresa");
$fila = $result->fetch_array(MYSQLI_BOTH);
$ID = $fila[0] + 1;
$ultfact = $fila[1] + 1;
$link->query("UPDATE empresa SET ultasi = '$ID', ultfact = '$ultfact' WHERE 1");

// Cojo el valor de la fecha en que se hizo el &uacute;ltimo Asiento

$result = $link->query("SELECT ultfecha, ultfact FROM empresa");
$row = $result->fetch_array(MYSQLI_BOTH);
$a=explode("-",$row["ultfecha"]); 
$b = $a[2]."/".$a[1]."/".substr($a[0],2,2)

?>

<span class='verde b'>Atenci&oacute;n, para pasar abonos por devoluciones o por descuentos comerciales, basta con elegir las cuentas correspondientes y poner signo negativo en el importe.</span><p />

<form name='form1' enctype='multipart/form-data' method='post' action='facemi1.php' onsubmit="return compruebacamposfacemi1(form1)">

<table class="entradadatos">
	<tr>
		<td class='dcha'>Asiento</td> 
		<td><input type='text' name='asiento' value="<?php echo $ID ?>" size='8'> 
		<label>Fecha</label> 
		<input type='text' name='fecha' size='8' maxlength='8' class='datepicker' value="<?php echo $b; ?>"> 
		<!-- <input type="button" name="selfecha" value="..."  onclick="displayDatePicker('fecha','','dmy');"> --> 
		<label>Nº Factura</label> 
		<input type='text' name='numfac' size='15' value =
		<?php
		if ($row["ultfact"] > 0) {
			echo 1 + $row["ultfact"];
		} else {
			echo "''";
		}
		?>
		></td>
	</tr>
	<tr>
		<td>&nbsp;</td><td>&nbsp;</td>	
	</tr>	
	<tr>
		<td class='dcha'>Cliente</td> 
		<td><input type='text' name='cliente1' size='8'> <!-- readonly='readonly' onfocus="form1.cliente.focus()" -->
		<select name='cliente' onfocus="seleccionacliente0(form1)" onchange="seleccionacliente(form1)">
		<option value=''>*** Introduce a la izquierda el n&uacute;mero de Cuenta o selecciona la Cuenta en este desplegable ***</option>
		<?php
		$result = $link->query("SELECT cuenta, descripci_ FROM subcuent ORDER by descripci_");
		while ($row = $result->fetch_array(MYSQLI_BOTH)){
			echo "<option value='".$row[0]."'>".$row[1];
		}
		?>
		</select>
	</tr>
	<tr>
		<td class='dcha'>Cuenta Ingreso</td> 
		<td><input type='text' name='cuening1' size='8'>  <!-- readonly='readonly'  onfocus="form1.cuening.focus()" -->
		<select name='cuening' onfocus="seleccionacuening0(form1)" onchange="seleccionacuening(form1)">
		<option value=''>*** Introduce a la izquierda el n&uacute;mero de Cuenta o selecciona la Cuenta en este desplegable ***</option>
		<?php
		$result = $link->query("SELECT cuenta, descripci_ FROM subcuent ORDER by descripci_");
		while ($row = $result->fetch_array(MYSQLI_BOTH)){
			echo "<option value='".$row[0]."'>".$row[1];
		}
		?>
		</select>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td><td>&nbsp;</td>	
	</tr>
	<tr>
		<td class='dcha'>Total Factura</td> 
		<td><input type='text' name='totfac' size='9' onfocus="seleccionacliente0(form1);seleccionacuening0(form1)"> &#8364; 
		<label>Tipo IVA</label> 
		<select name='tipoiva' onchange="calculafacemi1(form1)" onfocus="calculafacemi1(form1)">
		<!--<option value='1.21'>0,21
		<option value='1.18'>0,18
		<option value='1.16'>0,16
		<option value='1.08'>0,08
		<option value='1.07'>0,07
		<option value='1.05'>0,05
		<option value='1.04'>0,04
		<option value='1.02'>0,02
		<option value='1'>0 -->
		<?php optioniva($link);?>
		</select>
		<label>Base Imp</label> <input type='text' name='baseimp' size='9'> &#8364; 
		<label>Cuota IVA</label> <input type='text' name='cuotaiva' size='9'> &#8364; &nbsp; &nbsp; <a href='iva.php'>Cambiar valores del desplegable Tipo IVA</a>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td><td>&nbsp;</td>	
	</tr>
	<tr>
		<td class='dcha'>Justificante</td> 
		<td><input type='file' name='fich' size='19' maxlength='19'></td>
	</tr>
	<tr>
		<td class='dcha'><label>Explicaci&oacute;n</label> </td>
		<td><textarea name='explicacion' rows='6' cols='90'></textarea></td>
	</tr>
	<tr>
		<td>&nbsp;</td><td>&nbsp;</td>	
	</tr>
	<tr>
		<td colspan='2'><input type='submit' name='boton' value="Crear Asiento de Ventas"  onclick='return compruebafechaN3(form1)'></td>
	</tr>
</table>

</form>

<?php

echo $mensaje;

if ($anadido) {

	echo "<table class='basica 100' width='100%'>";

	cabasi(2);
	totalapu($link,$asiento);
	asiento($link,$asiento,"1",$_SESSION['moneda'],$_SESSION['deci'],$_GET['bojust']);

	echo "</table>";

}

function optioniva($link) {
	$sql = "SELECT * FROM iva ORDER BY n";
	$result = $link->query($sql);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		echo "<option value='".($fila[1] + 1)."'>$fila[1]</option>";
	}	
}

?></div>

<?php $top = 0; include("pie.php");?>

</body></html>
