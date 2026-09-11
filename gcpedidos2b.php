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

<form name='form1' method='post' action='?desde=gcpedidos' onsubmit="return compruebacamposgcpedidos(form1)">

<label>Cliente</label> 

<?php

	echo "<select name='codigoc'>";

	$result = $link->query("SELECT codigo, cliente FROM clientes ORDER by cliente");
	while ($row = $result->fetch_array(MYSQLI_BOTH)){
	echo "<option value='".$row[0]."'>".$row[1]."\n";
	}

	echo "</select>\n";
?>

<input type='hidden' name='anadir' value='2'>
<label>Fecha</label>
<input type='text' name='fecha' size='8' class='datepicker' maxlength='8'> 
<!-- <input type="button" name="selfecha" value="..."  onclick="displayDatePicker('fecha','','dmy');"> -->

<label>Nº Pedido</label>
<input type='text' name='n_ped' size='15' maxlength='15'>

<p />

<label>Total Pedido</label>
<input type='text' name='totpedido' size='9'> &#8364; 

<p />

<label>Art&iacute;culo</label> 
<input type='text' name='artic' size='10' maxlength='30'>

&nbsp; &nbsp; <label>Proveedor</label> 
<?php
echo "<select name='codigo'>\n";
$result = $link->query("SELECT codigo, proveed FROM proveed ORDER by proveed");
while ($row = $result->fetch_array(MYSQLI_BOTH)){
	echo "<option value='".$row[0]."'>".$row[1]."\n";
}
echo "</select>\n";
?>

<p />

<input type='submit' name='boton' value="Crear Pedido" onclick='return compruebafecha(form1)'>

</form>