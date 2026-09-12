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
	exit;
}

$result = $link->query("SELECT dni, cliente, domicilio, ciudad, codpost FROM clientes WHERE codigo = '$codigoc'");
$row = $result->fetch_array(MYSQLI_BOTH);

echo "<p /><label>Cliente</label> <input type='text' readonly='readonly' value='$row[0]'> <input type='text' readonly='readonly' value='$row[1]'>";

echo " &nbsp; <label>Domicilio</label> <input type='text' readonly='readonly' value='$row[2]'>";

echo "<br /><label>Ciudad</label> <input type='text' readonly='readonly' value='$row[4]'> <input type='text' readonly='readonly' value='$row[3]'>\n";

echo "</form><p />";

$result = $link->query("SELECT pedidos.dni, pedidos.n_ped, pedidos.totpedido, pedidos.n_, invent.artic, invent.p_coste FROM pedidos LEFT JOIN factemi ON pedidos.n_ = factemi.n_ LEFT JOIN invent ON pedidos.n_ped = invent.n_ped  WHERE pedidos.client = '$codigoc' ORDER BY n_ped");

$ped = 0;

while ($row = $result->fetch_array(MYSQLI_BOTH)) :

	if ($ped == 0) {
		echo "<table class='basica 100' width='100%'><th>Art&iacute;culo</th><th>Precio</th><th>Nº Factura</th><th>Facturado</th></tr>\n";
	}

	if ($row['n_ped'] != $ped) {
		if ($ped != 0) {
		echo "<tr><td class='blanco dcha b'>TOTAL PEDIDO: </td><td class='blanco dcha b'>".number_format($tot*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td><td class='blanco' colspan='2'>&nbsp;</td></tr>\n";
		} 
		echo "<tr><td class='verde' colspan='4'>&nbsp</td></tr>\n";
		echo "<tr><td class='blanco' colspan='2'><span style='font-size:1.3em;font-weight:bold'>Pedido nº: <a href=gcpedidos.php?xx=Pedidos&n_ped=".$row['n_ped'].">".$row['n_ped']."</a></span></td>\n";

		echo "<td class='dcha'>";
			
		if ($row['n_'] != 0) {
			echo $row['n_'];
		}
		
		echo "</td>\n";

		$a = $row['n_'];
		$res = $link->query("SELECT n_ FROM factemi WHERE n_ = '$a'");
		if ($res->num_rows > 0) {
			echo "<td align='center'>SI";
		} else {
			echo "<td align='center'>NO";
		}
		echo "</td></tr>\n";

		$tot = $row['totpedido'];

	}
	echo "<tr><td>".$row['artic']."</td><td class='dcha'>".number_format($row['p_coste']*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td><td colspan=2></td>\n";


	$ped = $row['n_ped'];

endwhile;

if ($ped != 0) {
	echo "<tr><td class='blanco dcha b'>TOTAL PEDIDO: </td><td class='blanco dcha b'>".number_format($tot*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td><td  class='blanco' colspan='2'>&nbsp;</td></tr>\n";
	echo "<tr0><td class='verde' colspan='4'>&nbsp;</td></tr>\n";
	echo "<tr><td class='blanco dcha b' colspan='2'>TOTAL: ";
	$res = $link->query("SELECT SUM(totpedido) AS tot FROM pedidos WHERE client = $codigoc");
	$row = $res->fetch_array(MYSQLI_BOTH);
	echo number_format($row[0]*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td><td class='blanco' colspan='2'>&nbsp;</td></tr></table>";
} else {
	echo "<p />No hay pedidos para este Cliente";
}

