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

<body<?php if (!$bloqueo) {echo " onload=\"foco('asasiento1')\"";}?>>

<?php
include("arriba.php");
$menu13=2;include("menusizda.php");

if ($vaciar == 1) {
	$asasiento1 = '';
	$asasiento2 = '';
	$astipo1 = '';
	$asfecha1 = '';
	$asfecha2 = '';
	$assuma1 = '';
	$assuma2 = '';
	$apasiento1 = '';
	$apasiento2 = '';
	$apfecha1 = '';
	$apfecha = '';
	$apcuenta1 = '';
	$apcuenta2 = '';
	$apconcepto1 = '';
	$apimporte1 = '';
	$apimporte2 = '';
	$orand1 = "and";
	$tabla = "";
	$orand1 = "and";
	$orand2 = "and";
	$orand3 = "and";
	$orand4 = "and";
	$orand5 = "and";
	$orand6 = "and";
	$orand7 = "and";
}
?>

<center>

<form name='form1' method='post' onsubmit="return busquedas(form1)">

<p />

<table class='entradadatos'>

<tr><td colspan='3'><input type='radio' name='tabla' value="asientos" <?php if ($tabla=="asientos") {echo "checked"; } ?>> <span class='b'>Asientos</span></td></tr>

<tr><td class='dcha'>Nº Asiento </td><td><input type='text' size='15' maxlength='11' name='asasiento1' value=<?php echo $asasiento1; ?>></td><td><input type='text' size='15' maxlength='11' name='asasiento2' value=<?php echo $asasiento2; ?>></td></tr>

<tr><td class='dcha'>
<select name = 'orand1'><option value='and' <?php if ($orand1=="and") { echo "selected"; } ?>> y <option value='or' <?php if ($orand1=="or") { echo "selected"; } ?>> o </select> 
Tipo </td><td><input type='text' size='15' maxlength='15' name='astipo1' value='<?php echo $astipo1; ?>'></td><td></td></tr>

<tr><td class='dcha'>
<select name = 'orand2'><option value=and <?php if ($orand2=="and") { echo "selected"; } ?>> y <option value='or' <?php if ($orand2=="or") { echo "selected"; } ?>> o </select> 
Fecha </td><td><input type='text' size='15' maxlength='8' name='asfecha1' value=<?php echo $asfecha1; ?>></td><td><input type='text' size='15' maxlength='8' name='asfecha2' value=<?php echo $asfecha2; ?>></td></tr>

<tr><td class='dcha'>
<select name = 'orand3'><option value='and' <?php if ($orand3=="and") { echo "selected"; } ?>> y <option value='or' <?php if ($orand3=="or") { echo "selected"; } ?>> o </select> 
Suma </td><td><input type='text' size='15' maxlength='11' name='assuma1' value=<?php echo $assuma1; ?>> &#8364;</td><td><input type='text' size='15' maxlength='11' name='assuma2' value=<?php echo $assuma2; ?>> &#8364</td></tr>

<tr><td colspan='3'><input type='radio' name='tabla' value="apuntes" <?php if ($tabla=="apuntes") { echo "checked"; } ?>> <span class='b'>Apuntes</span></td></tr>

<tr><td class='dcha'>Nº Asiento </td><td><input type='text' size='15' maxlength='11' name='apasiento1' value=<?php echo $apasiento1; ?>></td><td><input type='text' size='15' maxlength='11' name='apasiento2' value=<?php echo $apasiento2; ?>></td></tr>

<tr><td class='dcha'>
<select name = 'orand4'><option value=and <?php if ($orand4=="and") { echo "selected"; } ?>> y <option value=or <?php if ($orand4=="or") { echo "selected"; } ?>> o </select> 
Fecha </td><td><input type='text' size='15' maxlength='8' name='apfecha1' value=<?php echo $apfecha1; ?>></td><td><input type='text' size='15' maxlength='8' name='apfecha2' value=<?php echo $apfecha2; ?>></td></tr>

<tr><td class='dcha'>
<select name = 'orand5'><option value='and' <?php if ($orand5=="and") { echo "selected"; } ?>> y <option value=or <?php if ($orand5=="or") { echo "selected"; } ?>> o </select> 
Cuenta </td>
<td colspan='4'><input type='text' name='apcuenta1' readonly='readonly' size='8' onfocus="form1.cuengas.focus()" value=<?php echo $apcuenta1; ?>>
<select name='apcuenta2' onchange="cuengasbusquedas(form1)" onfocus="cuengasbusquedas(form1)">
<?php
$result = $link->query("SELECT cuenta, descripci_ FROM subcuent ORDER by descripci_");
while ($row = $result->fetch_array(MYSQLI_BOTH)){
echo "<option value='".$row[0]."*".$row[1]."' ";
if ($row[0] == $apcuenta1) {
	echo "selected";
}
echo ">".$row[1];
}
?>
</select></td></tr>

<tr><td class='dcha'>
<select name = 'orand6'><option value='and' <?php if ($orand6=="and") { echo "selected"; } ?>> y <option value='or' <?php if ($orand6=="or") { echo "selected"; } ?>> o </select> 
Concepto </td><td><input type='text' size='15' maxlength='15' name='apconcepto1' value='<?php echo $apconcepto1; ?>'></td><td></td></tr>

<tr><td class='dcha'>
<select name = 'orand7'><option value='and' <?php if ($orand7=="and") { echo "selected"; } ?>> e <option value='or' <?php if ($orand7=="or") { echo "selected"; } ?>> o </select> 
Importe </td><td><input type='text' size='15' maxlength='11' name='apimporte1' value=<?php echo $apimporte1; ?>> &#8364;</td><td><input type='text' size='15' maxlength='11' name='apimporte2' value=<?php echo $apimporte2; ?>> &#8364;</td></tr>

<tr><td></td><td></td><td></td></tr>

<tr><td></td><td><input type='submit' value="Buscar"></td><td>
<a href='?vaciar=1'>Vaciar campos</a>
</td></tr>

</table>

</form></center>

<?php

if (!$tabla) {
	echo "Seleccionar una tabla en la que buscar.";
	include("pie.php");
	echo "</body></html>";
	exit;
}

if ($tabla == "asientos") {

	include ("busasi.php");

}

if ($tabla == "apuntes") {

	include ("busapu.php");

}

$top = 1; include("pie.php");?></body></html>
