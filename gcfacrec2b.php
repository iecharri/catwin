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

if (!$link OR !$_SESSION['empresa']) {
	return;
}

include("jdatepicker.php");

?>

<form name='form1' method='post' onsubmit="return compruebacamposgcfacrec(form1)">

<p /><br /><label>Proveedor</label> 

<?php

	echo "<input type='hidden' name='nueva' value='no'>";

	echo "<select name='codigo'>";

	$result = $link->query("SELECT codigo, proveed FROM proveed ORDER by proveed");
	while ($row = $result->fetch_array(MYSQLI_BOTH)){
	echo "<option value='".$row[0]."'>".$row[1]."\n";
	}

	echo "</select>\n";
?>

<input type='hidden' name='anadir' value='2'>
<label>Fecha</label> 
<input type='text' name='fecha' size='8' maxlength='8' class='datepicker'> 
<!-- <input type="button" name="selfecha" value="..."  onclick="displayDatePicker('fecha','','dmy');"> --> 
<label>Nº Factura</label> 
<input type='text' name='fact' size='15' maxlength='15'>

<p />

<label>Total Factura</label> 
<input type='text' name='totfac' size='9' onchange="calculagcfacrec(form1)"> &#8364; 

<label>Tipo IVA</label>  
<select name='tipoiva' onchange="calculagcfacrec(form1)" onfocus="calculagcfacrec(form1)">

<!-- <option value='1.18'>0,18
<option value='1.16'>0,16
<option value='1.08'>0,08
<option value='1.07'>0,07
<option value='1.05'>0,05
<option value='1.04'>0,04
<option value='1.02'>0,02
<option value='1'>0 -->

<?php optioniva($link);?>
</select>



<label>Base Imp.</label> <input type='text' name='baseimp' size='9'> &#8364; 

<label>Cuota IVA</label> <input type='text' name='cuotaiva' size='9' readonly>&#8364; 

<p />

<label>Art&iacute;culo</label> 
<input type='text' name='artic' size='10' maxlength='30' onfocus="calculagcfacrec(form1)"> <!-- calcula1gcfacrec -->
&nbsp; &nbsp; <label>Tipo</label> 
<?php
echo "<select name='tipo'>\n";
$result = $link->query("SELECT row_id, tipo FROM tipos ORDER by tipo");
while ($row = $result->fetch_array(MYSQLI_BOTH)){
echo "<option value='".$row[0]."'>".$row[1]."\n";
}
echo "</select>\n";
?>
&nbsp; &nbsp; <label>P. Coste</label> 
<input type = 'text' size='10' maxlength='10' name='p_coste'> &#8364; 
&nbsp; &nbsp; <label>Nuevo Tipo de Art&iacute;culo</label> 
<input type = 'text' size='15' maxlength='35' name='nuetipo'>

<p />

<input type='submit' name='boton' value="Crear Factura" onclick='return compruebafecha(form1)'>

</form>