<?php

//Copyright (C) 2000-2010  Antonio Grandio Botella http://www.antoniograndio.com
//Copyright (C) 2000-2010  Inmaculada Echarri San Adrian inma.echarri@gmail.com

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

if ($_GET['emp'] == 1) {$_GET['n'] = 1;}

if ($_GET['n'] == 1) {
	$onload="onload=\"foco('asiento')\"";
	$result = $link->query("SELECT ultasi FROM empresa");
	$fila = $result->fetch_array(MYSQLI_BOTH);
	$asiento = $fila[0] + 1;
	$link->query("UPDATE empresa SET ultasi = '$asiento' WHERE 1");
	// Cojo el valor de la fecha en que se hizo el &uacute;ltimo Asiento
	$result = $link->query("SELECT date_format(ultfecha,'%d/%m/%y') AS ultfechax FROM empresa");
	$row = $result->fetch_array(MYSQLI_BOTH);
	$fecha = $row[0];
} else {
	$onload="onload=\"foco('cuenta11')\"";
	$readonly=" readonly='readonly'";
	$asiento = $_POST['asiento'];
	$fecha = $_POST['fecha'];
	$tipo =$_POST['tipo'];
}

?>

<body <?php if (!$bloqueo) {echo $onload;}?>>

<?php

include("arriba.php");
$menu11=1;include("menusizda.php");

if ($debe OR $haber) {
	include ("altaasigral2.php");
	$cuadre = totalapu($link,$asiento);
}

?>

<form enctype='multipart/form-data' name='form1' action='altaasigral.php' method='post' onsubmit="return altaasigral(form1)">

<label>Asiento</label>
<input type='text' name='asiento' value="<?php echo $asiento;?>" size='8' <?php echo $readonly;?>> 

<label>Fecha</label>
<input type='text' name='fecha' size='8' maxlength='8' class='datepicker' value="<?php echo $fecha;?>" <?php echo $readonly;?>>
<!-- <input type="button" name="selfecha" value="..."  onclick="displayDatePicker('fecha','','dmy');"> -->

<label>Tipo</label> <select name='tipo' <?php echo $readonly;?>>

<?php
$array = tipoasi();
foreach ($array as $clave=>$valor) {
	echo "<option value='$valor' ";
	if ($valor == "General") {echo " selected='selected'";}
	echo ">$valor</option>";
}
?>

</select><p /> 

<?php
if (!$_POST['asiento']) {
	$temp = "Primer Apunte:";
} else {
	$temp = "Siguiente Apunte:";
	$result = $link->query("SELECT explicacion FROM asientos WHERE asiento = '".$_POST['asiento']."'");
	$expli = $result->fetch_array(MYSQLI_BOTH);
}
?>

<fieldset><legend><?php echo $temp;?></legend>

<br /><label>Cuenta</label><br /><input type='text' name='cuenta1' size='8'"> <!-- onfocus="form1.cuenta11.focus() readonly='readonly' --> 

<select name='cuenta11' onfocus="seleccionacuenta10(form1)" onchange="seleccionacuenta1(form1)">
<option value=''>*** Introduce a la izquierda el n&uacute;mero de Cuenta o selecciona la Cuenta en este desplegable ***</option>

<?php
$result = $link->query("SELECT cuenta, descripci_ FROM subcuent ORDER by descripci_");
while ($row = $result->fetch_array(MYSQLI_BOTH)){
echo "<option value='".$row[0]."'";
if($row[0] == $_POST['cuenta1']) {echo " selected";}
echo ">".$row[1]."</option>";
}
?>

</select>

<br />

<label>Concepto</label><br />
<input type='text' name='concepto' value="<?php echo $_POST['concepto'];?>" onfocus="seleccionacuenta10(form1)" size='35'>

<br />

<label>Debe</label><br />
<input type='text' name='debe' size='11' maxlength='11' onfocus="seleccionacuenta10(form1)"> &#8364;

<br />

<label>Haber</label><br />
<input type='text' name='haber' size='11' maxlength='11' onfocus="seleccionacuenta10(form1)"> &#8364;

</fieldset><p style="clear:both"><p />

<?php

echo "<label>Justificante</label> <input type='file' name='fich' size='19' maxlength='19'>";
if ($_POST['asiento']) {echo " (Si el asiento ya tiene un justificante ser&aacute; sustitu&iacute;do)";}
echo "<br /><label>Explicaci&oacute;n</label> <textarea name='explicacion' rows='6' cols='90'>$expli[0]</textarea>";
echo "<p />";
if ($_GET['n'] == 1) {
	echo "<input type='submit' name='boton' value=\"Alta Asiento\" onclick='return compruebafechaN(form1)'>";
} else {
	echo "<input type='submit' name='boton' value=\"Alta Apunte\" onclick='return compruebafechaN(form1)'>";
	if ($debe OR $haber) {
		echo "&nbsp;&nbsp;&nbsp;<a href='altaasigral.php?n=1'";
		if ($cuadre) {echo " onclick=\"return confirm('Asiento descuadrado ¿Continuar con nuevo Asiento?')\"";}
		echo ">Alta nuevo Asiento</a>";
	}
}
?>

</form>

<?php

echo $mensaje;

if ($anadido) {

	echo "<table class='basica 100' width='100%'>";
	cabasi(2);
	asiento($link,$asiento,"1",$_SESSION['moneda'],$_SESSION['deci'],$_GET['bojust']);
	echo "</table>";

}

?>

</div>

<?php $top = 0; include("pie.php");?>

</body></html>
