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

<body<?php if(!$bloqueo) {echo " onload=\"foco('asiento')\"";}?>>

<?php
include("arriba.php");
$menu11=2;include("menusizda.php");

if ($importe) {
	include ("altaasi2.php");
}

$result = $link->query("SELECT ultasi FROM empresa");
$fila = $result->fetch_array(MYSQLI_BOTH);
$ID = $fila[0] + 1;
$link->query("UPDATE empresa SET ultasi = '$ID' WHERE 1");

// Cojo el valor de la fecha en que se hizo el &uacute;ltimo Asiento

$result = $link->query("SELECT date_format(ultfecha,'%d/%m/%y') AS ultfechax FROM empresa");
$row = $result->fetch_array(MYSQLI_BOTH);
$b = $row[0];

// mantener debe, haber y concepto anteriores anadidos

$result = $link->query("SELECT ultdebe, ulthaber, ultconcepto FROM empresa");
$fila = $result->fetch_array(MYSQLI_BOTH);
$ultdebe = $fila[0];
$ulthaber = $fila[1];
if ($ultdebe == 0) {$ultdebe = "";}
if ($ulthaber == 0) {$ulthaber = "";}
$ultconcepto = $fila[2];

?>

<form name='form1' enctype='multipart/form-data' method='post' onsubmit="return altaasi(form1)">

<table class='entradadatos'>
   <tr>
      <td class='dcha'>Asiento</td> 
      <td><input type='text' name='asiento' value="<?php echo $ID ?>" size='8'>&nbsp;
      <label>Fecha</label>
      &nbsp;<input type='text' name='fecha' size='8' maxlength='8' class='datepicker' value='<?php echo $b;?>'>
      &nbsp;<!-- <input type="button" name="selfecha" value="..."  onclick="displayDatePicker('fecha','','dmy');"> -->&nbsp;<label>Tipo</label>
	  &nbsp;<select name='tipo'>
      <?php
      $array = tipoasi();
      foreach( $array as $clave => $valor ) {
		echo "<option value='$valor' ";
		if( $valor == "Simple" ) 
		echo " selected";
		echo ">$valor";
      }
      ?></select> 
      </td>   
   </tr>	
   <tr>
      <td>&nbsp;</td><td>&nbsp;</td>	
   </tr>	
   <tr>
      <td class='dcha'>Cuenta al Debe</td>
      <td><input type='text' name='cuenta1' size='8' value="<?php echo $ultdebe;?>">  <!-- readonly='readonly' onfocus="form1.cuenta11.focus() -->
      <select name='cuenta11' onfocus="seleccionacuenta10(form1)" onchange="seleccionacuenta1(form1)">
		<option value=''>*** Introduce a la izquierda el n&uacute;mero de Cuenta o selecciona la Cuenta en este desplegable ***</option>
      <?php
      $result = $link->query("SELECT cuenta, descripci_ FROM subcuent ORDER by descripci_");
      while($row = $result->fetch_array(MYSQLI_BOTH))
      {
         echo "<option value='".$row[0]."'";
         if ($ultdebe == $row[0]) {echo " selected = 'selected'";}
         echo ">".$row[1];
      }
    ?></select></td>
   </tr>	
   <tr>
      <td class='dcha'>Cuenta al Haber</td>
      <td><input type='text' name='cuenta2' size='8'value="<?php echo $ulthaber;?>">  <!-- readonly='readonly' onfocus="form1.cuenta22.focus() -->
      <select name='cuenta22' onfocus="seleccionacuenta20(form1)" onchange="seleccionacuenta2(form1)">
		<option value=''>*** Introduce a la izquierda el n&uacute;mero de Cuenta o selecciona la Cuenta en este desplegable ***</option>
      <?php
      $result = $link->query("SELECT cuenta, descripci_ FROM subcuent ORDER by descripci_");
      while($row = $result->fetch_array(MYSQLI_BOTH))
      {
         echo "<option value='".$row[0]."'";
         if ($ulthaber == $row[0]) {echo " selected = 'selected'";}
         echo ">".$row[1];
      }
      ?></select></td>
   </tr>	
   <tr>
      <td>&nbsp;</td><td>&nbsp;</td>
   </tr>	
   <tr>
      <td class='dcha'>Concepto</td>   	
      <td><input type='text' name='concepto' value="<?php echo $ultconcepto;?>" size='35' onfocus="seleccionacuenta10(form1);seleccionacuenta20(form1)"></td>
   </tr>	
   <tr>
      <td class='dcha'>Importe</td>   	
      <td><input type='text' name='importe' size='11' maxlength='11' onfocus="seleccionacuenta10(form1);seleccionacuenta20(form1)"> &#8364;</td>
   </tr>	
   <tr>
      <td>&nbsp;</td><td>&nbsp;</td>	
   </tr>	
   <tr>
      <td class='dcha'>Justificante</td>   	
      <td><input type='file' name='fich' size='19' maxlength='19'></td>
   </tr>	
   <tr>
      <td class='dcha'>Explicaci&oacute;n</td>   	
      <td><textarea name='explicacion' rows='6' cols='90'></textarea></td>
   </tr>	
   <tr>
      <td>&nbsp;</td><td>&nbsp;</td>	
   </tr>	
   <tr>
      <td colspan='2'><input type='submit' name='boton' value="Alta Asiento" onclick='return compruebafechaN2(form1)'></td>
   </tr>	
</table>	

<br />

<?php

echo $mensaje;

if ($anadido) {

	echo "<table class='basica 100' width='100%'>";

	cabasi(2);
	totalapu($link,$asiento);
	asiento($link,$asiento,"1",$_SESSION['moneda'],$_SESSION['deci'],$_GET['bojust']);


	echo "</table>";

}

?>

</div>

<?php $top = 0; include("pie.php");?>

</body></html>
