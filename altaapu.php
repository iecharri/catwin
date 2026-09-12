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

echo "<form action='editasi2.php?asiento=".$asiento."&accion=altaapu1' name='form1' onsubmit='return validar(form1)' method=post>\n";


	echo "<table class='basica'> \n"; 

	echo "<tr><th>Asiento</th><th>Tipo</th></tr>\n";

	echo "<tr><td>\n";

	echo "<input type = 'text' value ='$asiento' size='8' maxlength='8' name='asiento' readonly='readonly' onfocus='form1.fecha.focus()' tabindex='1'>";
	echo "</td><td>\n";
	$result = $link->query("SELECT *, date_format(fecha, '%d/%m/%y') AS fechax FROM asientos WHERE asiento = $asiento"); 
	$row = $result->fetch_array(MYSQLI_BOTH);
	echo "<input type = text value ='".$row['tipo']."' size=15 maxlength=15 name=tipo readonly='readonly' tabindex=2>";

	echo "</td></tr></table><p />\n";

?>

<table class='basica'>
<tr><th>Fecha</th><th>Cuenta</th><th>Concepto</th><th class='dcha'>Debe &#8364;</th><th class='dcha'>Haber &#8364</th></tr>

<tr><td>

<input type = 'text' size='8' maxlength='8' name='fecha' value=<?php echo $row['fechax'];?> readonly='readonly' tabindex='3'>

</td><td>

<input type='text' name='cuenta1' readonly='readonly' size='8' onfocus='form1.cuenta.focus()' tabindex=0>

</td><td>

<input type = 'text' value ='' size='20' maxlength='254' name='concepto' tabindex='5'>

</td><td>

<input type = 'text' value ='' size='11' maxlength='11' name='debe' tabindex='6'>

</td><td>

<input type = 'text' value ='' size='11' maxlength='11' name='haber' tabindex='7'>

</td>

</tr><tr><td>&nbsp;</td><td colspan='4'>

<select name='cuenta' onchange='seleccionacuentaeditasi2(form1)' onfocus='seleccionacuentaeditasi2(form1)' tabindex=4>

<?php

$result = $link->query("SELECT cuenta, descripci_ FROM subcuent ORDER by descripci_");
while ($row = $result->fetch_array(MYSQLI_BOTH)){
echo "<option value='".$row[0]."'>".$row[1]."\n";
}

?>

</select>

</td>

</tr>

<tr>

<td colspan='5' class='dcha'>

<input type = 'submit'name = 'formu' value = 'A&ntilde;adir' tabindex='9' onclick='return compruebafecha(form1)'>

</td>

</tr>

</table>

</form>
