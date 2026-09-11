<?php

//Copyright (C) 2000-2015  Antonio Grandio Botella http://www.antoniograndio.com
//Copyright (C) 2000-2015  Inmaculada Echarri inma.echarri@gmail.com

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

$sql = "SELECT clientes.cliente, clientes.domicilio, clientes.ciudad, clientes.codpost, clientes.dni, pedidos.n_ped, pedidos.totpedido, factemi.n_, invent.artic, invent.p_coste FROM pedidos LEFT JOIN clientes ON pedidos.client=clientes.codigo LEFT JOIN factemi ON pedidos.n_ = factemi.n_ LEFT JOIN invent ON pedidos.n_ped = invent.n_ped  WHERE factemi.row_id = '$row_id' ORDER BY n_";
$result = $link->query($sql);

if ($result->num_rows == 0) {echo "<p /><br /><p /><br /><span class='rojo b'>No hay datos para ese n&uacute;mero de factura.</span>";return;}

$ped = 0;


while ($row = $result->fetch_array(MYSQLI_BOTH)) :

	if ($ped == 0) {

		echo "<p /><span class='b'>Factura nº: ".$row['n_']."</span>";

		echo "<form>\n";

		echo "<p /><label>Cliente</label><br /><input type='text' readonly='readonly' value='".$row['dni']."'><br /><input type='text' readonly='readonly' value='".$row['cliente']."'>\n";

		echo "<p /><label>Domicilio</label><br /><input type='text' readonly='readonly' value='".$row['domicilio']."'>\n";

		echo "<br /><label>Ciudad</label><br /><input type='text' readonly='readonly' value='".$row['codpost']."'><br /><input type='text' readonly='readonly' value='".$row['ciudad']."'>\n";

		echo "</form><p />\n";

		echo "<table class='basica' width=100%><th>Art&iacute;culo</th><th>Precio</th></tr>\n";
	}

	if ($row['n_ped'] != $ped) {
		if ($ped != 0) {
			echo "<tr><td class='blanco dcha b'>SUMA: </td><td class='blanco dcha b'>".number_format($tot*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td></tr>\n";
		} 
		echo "<tr><td class='verde' colspan='2'>&nbsp</td></tr>\n";
		echo "<tr><td class='blanco' colspan='2'><span style='font-size:1.3em;font-weight:bold'>Pedido nº: ".$row['n_ped']."</span></td></tr>\n";

		$tot = $row['totpedido'];

	}
	echo "<tr><td>".$row['artic']."</td><td class='dcha'>".number_format($row['p_coste']*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td>\n";


	$ped = $row['n_ped'];

endwhile;

echo "<tr><td class='blanco dcha b' colspan='2'>SUMA: ".number_format($tot*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td></tr>\n";
echo "<tr><td class='verde' colspan='2'>&nbsp</td></tr>\n";
echo "<tr><td class='blanco dcha b' colspan='2'>TOTAL: ";
$res = $link->query("SELECT total FROM factemi WHERE factemi.row_id = '$row_id'");
$row=$res->fetch_array(MYSQLI_BOTH);
echo number_format($row[0]*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td></tr></table>";

?>

