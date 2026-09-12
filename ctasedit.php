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

//**************************

if ($param == "subcuenta") {
	$result = $link->query("SELECT cuenta, descripci_, ctacte, telefono, telefono2, natura, contrapda, importomis FROM subcuent WHERE cuenta = '$cuenta'");
	$fila = $result->fetch_array(MYSQLI_BOTH);
	echo "<span class='rojo b'>Atenci&oacute;n</span>, si no existe cuenta de nivel de agregaci&oacute;n superior correspondiente al nuevo n&uacute;mero que se le asigne, se perder&aacute; la integridad referencial y los balances de nivel de cuentas superior descuadrar&aacute;n.";
	echo "<form name='form1' method='post' onsubmit='return confirma()'>\n";
	echo "<input type='hidden' name='subcuenta' value='".$fila[0]."'>\n";
	echo "<input type='hidden' name='descripci_' value='".$fila[1]."'>\n";

	echo "Nº de Subcuenta<br /><input type='text' name='nuevosubcuenta' size='8' maxlength='8' value = '".$fila[0]."'><br />\n";
	echo "Descripci&oacute;n <span class='rojo b'>(evitar usar comillas)</span><br /><input type='text' name='nuevodescripci3_' size='50' maxlength='254' value = '".$fila[1]."'><br />";
	echo "Naturaleza<br />";
	echo "<select name='natura'>";
	echo "<option value='Activo'";
	if ($fila['natura'] == "Activo") {echo "selected='selected'";}
	echo ">Activo</option>";
	echo "<option value='Pasivo'";
	if ($fila['natura'] == "Pasivo") {echo "selected='selected'";}
	echo ">Pasivo</option>";
	echo "<option value='Neto'";
	if ($fila['natura'] == "Neto") {echo "selected='selected'";}
	echo ">Neto</option>";
	echo "<option value='Gasto'";
	if ($fila['natura'] == "Gasto") {echo "selected='selected'";}
	echo ">Gasto</option>";
	echo "<option value='Ingreso'";
	if ($fila['natura'] == "Ingreso") {echo "selected='selected'";}
	echo ">Ingreso</option>";
	echo "</select>";
	echo "<br />";
	echo "Cuenta Corriente<br /><input type='text' name='ctacte' size='23' maxlegnth='23' value=".$fila['ctacte']."><br />";
	echo "Tel&eacute;fono<br /><input type='text' name='telefono' size='20' maxlegnth='20' value=".$fila['telefono']."><br />";
	echo "Tel&eacute;fono<br /><input type='text' name='telefono2' size='20' maxlegnth='20' value=".$fila['telefono2']."><br />";
	echo "Contrapartida<br />";
	echo "<input type='text' name='cuenta1' value = '".$fila['contrapda']."' readonly='readonly' size='8' onfocus=\"form1.cuenta11.focus()\">";
	echo " <select name='cuenta11' onfocus=\"seleccionacuenta1(form1)\" onchange=\"seleccionacuenta1(form1)\"><option value)''></option>";
	$result = $link->query("SELECT cuenta, descripci_ FROM subcuent ORDER BY descripci_");
	while($fila1 = $result->fetch_array(MYSQLI_BOTH)) {
		echo "<option value='".$fila1['cuenta']."'";
		if ($fila['contrapda'] == $fila1['cuenta']) {echo " selected = 'selected'";}
		$descrip = $fila1['descripci_'];
		$len = strlen($descrip);
		if ($len > 50) {$descrip = substr($descrip,1,40)."...";
			echo ">".$descrip."</option>"; 
		}
	}
	echo "</select><br />";
	echo "Importe por omisi&oacute;n<br /><input name = 'importomis' type='text' size='20' maxlength='20' value='".$fila['importomis']."'> &#8364;";

	echo "<p /><input type='submit' value='Modificar Subcuenta'></form>\n";

}

//**************************

