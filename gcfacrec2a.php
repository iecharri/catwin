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

?>

<form name='form1' method='post' onsubmit="return compruebacamposgcfacrec(form1)">

<input type='hidden' name='anadir' value='1'>

<?php

$result1 = $link->query("SELECT proveed FROM proveed WHERE codigo = '$codigo'");
$fila1 = $result1->fetch_array(MYSQLI_BOTH);

if ($result->num_rows == 0) {
	echo "<p />No se encontr&oacute; la Factura <span class='b'>".$fact."</span> de <span class='b'>".$fila1['proveed']."</span>";
	exit;
}

$fila = $result->fetch_array(MYSQLI_BOTH);

if ($fila['asiento']) {echo "<p /><span class='rojo b'>¡ATENCI&Oacute;N! La Factura est&aacute; validada, est&aacute; asociada a un Asiento en Contabilidad. S&oacute;lo puede ser borrada por un usuario Contable.</span><p />";}

echo "<p /><br /><label>Proveedor</label> ";
echo "<input type='text' value='".$fila1['proveed']."' name='proveed' readonly='readonly'>&nbsp; \n";
echo "<input type='hidden' value=".$codigo." name='codigo'>";

$a=explode("-",$fila["fecha"]); 
$b=$fila['tipivar1']-1;
$tipoiva = $fila['tipivar1'];
echo "<input type = 'hidden' value='".$tipoiva."' name='tipoiva'>";
echo "<label>Fecha</label> \n";
echo "<input type='text' name='fecha' size='8' maxlength='8'  value = '".$a[2]."/".$a[1]."/".substr($a[0],2,2)."' readonly='readonly'>&nbsp; \n";
//echo  "<input type='button' name='selfecha' value='...'  onclick=\"displayDatePicker('fecha','','dmy');\"> ";
echo "<label>Nº Factura</label> \n";
echo "<input type='text' size='15' value =".$fact." name = 'fact' readonly='readonly'>&nbsp; \n";
echo "<p /><label>Total Factura</label> \n";
echo "<input type='text' size='9' value ='".$fila['totalr']."' readonly='readonly' name='totfac'>&nbsp;&#8364; \n";
echo "<label>Tipo IVA</label> \n";
echo "<input type='text' size='5' value ='".$b."' readonly='readonly' name='tipoiva1'>&nbsp; \n";
echo "<label>Base Imp.</label> \n";
echo "<input type='text' size='9' name='baseimp' value='".$fila['totbruto']."' readonly='readonly'>&nbsp;&#8364; \n";
echo "<label>Cuota IVA</label> \n";
echo "<input type='text' size='9' name='cuotaiva' value ='".($fila['totalr']-$fila['totbruto'])."' readonly='readonly'> &#8364;<p />\n";

echo "<p />\n";

echo "<label>Art&iacute;culo</label> \n";
echo "<input type='text' name='artic' size='10' maxlength='30' onfocus='calculagcfacrec(form1)'>\n"; //calcula1gcfacrec(
echo "&nbsp; &nbsp; <label>Tipo</label> \n";

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

 &nbsp; &nbsp; &nbsp; &nbsp;

<input type='submit' name='boton' value="A&ntilde;adir Art&iacute;culo">

</form>

<?php

$desde = "gcfacrec";
$baseimp = $fila['totbruto'];
include ("gcinvent1.php");

?>
