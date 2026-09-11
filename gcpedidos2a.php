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

<form name='form1' method='post' action='?xx=<?php echo $xx; ?>&desde=gcpedidos' onsubmit="return compruebacamposgcpedidos(form1)">

<input type='hidden' name='anadir' value='1'>

<?php

$result = $link->query("SELECT * FROM pedidos WHERE n_ped = '$n_ped'");
$fila = $result->fetch_array(MYSQLI_BOTH);

$a = $fila['client'];
$res = $link->query("SELECT cliente FROM clientes WHERE codigo = '$a'");
$fila1 = $res->fetch_array(MYSQLI_BOTH);

if ($result->num_rows == 0) {

	echo "<p />No se encontr&oacute; el Pedido <span class='b'>".$n_ped."</span>";
	exit;
}

$a = $fila['n_'];

$res = $link->query("SELECT n_ FROM factemi WHERE n_ = '$a'");
if ($res->num_rows != 0) {

	echo "<p />Pedido <span class='b'>".$n_ped."</span> ya facturado, nº Factura ventas: <span class='b'>".$a."</span>";
	exit;
}

echo "<label>Cliente</label> ";

echo "<input type='text' value='".$fila1['cliente']."' name='cliente' readonly='readonly'>&nbsp; \n";

echo "<input type='hidden' value='".$fila['codigo']."' name='codigo'>";

$a=explode("-",$fila["fecha"]); 

echo "<label>Fecha</label> \n";
echo "<input type='text' name='fecha' size='8' maxlength='8'  value = '".$a[2]."/".$a[1]."/".substr($a[0],2,2)."'  readonly='readonly'>&nbsp; \n";

echo "<label>Nº Pedido</label> \n";
echo "<input type='text' size='15' value =".$n_ped." name = 'n_ped' readonly='readonly'>&nbsp; \n";
echo "<p /><label>Total Pedido</label> \n";
echo "<input type='text' size='9' value ='".$fila['totpedido']."' readonly='readonly' name='totpedido'>&nbsp;&#8364;\n";

echo "<p />\n";

echo "<label>Art&iacute;culo</label> \n";
echo "<input type='text' name='artic' size='10' maxlength='30'>\n";
echo "&nbsp; &nbsp; <label>Proveedor</label> \n";

echo "<select name=codigo>\n";
$result = $link->query("SELECT codigo, proveed FROM proveed ORDER by proveed");
while ($row = $result->fetch_array(MYSQLI_BOTH)){
echo "<option value='".$row[0]."'>".$row[1]."\n";
}
echo "</select>\n";
?>

&nbsp; &nbsp; &nbsp; &nbsp;

<input type='submit' name='boton' value="A&ntilde;adir Art&iacute;culo">

</form>

<?php

// mantengo el mismo nombre de variable que en facrec para calcular el descuadre
$baseimp = $fila['totpedido'];
$desde = "gcpedidos";
include ("gcinvent1.php");

?>
