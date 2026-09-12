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

if ($param == "cuentas") {

	$result = $link->query("SELECT cuenta, descripcio FROM cuentas WHERE cuenta = '$cuenta'");
	$fila = $result->fetch_array(MYSQLI_BOTH);
	echo "<span class='rojo b'>Atenci&oacute;n</span>, si no existe subgrupo de nivel de agregaci&oacute;n superior correspondiente al nuevo n&uacute;mero que se le asigne, se perder&aacute; la integridad referencial y los balances de nivel de subgrupos superior descuadrar&aacute;n. Lo mismo ocurrir&aacute; a nivel inferior si quedan subcuentas hu&eacute;rfanas sin cuentas correspondientes a este nivel.";
	echo "<form name='form1' method='post' onsubmit='return confirma2()'>\n";
	echo "<input type='hidden' name='cuenta' size='3' value='".$fila[0]."'>\n";
	echo "<input type='hidden' name='descripcio' value='".$fila[1]."'>\n";

	echo "Nº de Cuenta<br /><input type='text' name='nuevocuenta' size='3' maxlength='3' value = '".$fila[0]."'><br />\n";
	echo "Descripci&oacute;n <span class='rojo b'>(evitar usar comillas)</span><br /><input type='text' name='nuevodescripci2_' size='50' maxlength='254' value = '".$fila[1]."'>\n";
	echo "<p /><input type='submit' 'value='Modificar Cuenta'></form>\n";

}

//**************************

