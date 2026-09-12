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

if ($param == "subgrupo") {

	$result = $link->query("SELECT subgrupo, descripci_ FROM subgrupo WHERE subgrupo = '$cuenta'");
	$fila = $result->fetch_array(MYSQLI_BOTH);
	echo "<span class='rojo b'>Atenci&oacute;n</span>, si existen cuentas (y sus subcuentas correspondientes) cuyo subgrupo correspond&iacute;a al que vas sustituir por uno nuevo, estas quedar&aacute;n \"hu&eacute;rfanas\" y se perder&aacute; la integridad referencial, descuadrando los balances a cierto nivel de agregaci&oacute;n.";
	echo "<form name=form1 method=post onsubmit='return confirma1()'>\n";
	echo "<input type=hidden name=subgrupo value='".$fila[0]."'>\n";
	echo "<input type=hidden name=descripci_ value='".$fila[1]."'>\n";

	echo "Nº de Subgrupo<br /><input type='text' name='nuevosubgrupo' size='2' maxlength='2' value = '".$fila[0]."'><br />\n";
	echo "Descripci&oacute;n <span class='rojo b'>(evitar usar comillas)</span><br /><input type='text' name='nuevodescripci1_' size='50' maxlength='254' value = '".$fila[1]."'>\n";
	echo "<p /><input type='submit' 'value='Modificar Subgrupo'></form>\n";

}

//**************************

