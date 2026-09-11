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

<p />
<table class='basica 100 hover' width='100%'>
<tr>
<th class='dcha'>Nº Pedido</th><th>Cliente</th><th>Fecha</th><th class='dcha'>Total</th><th>Factura Emitida</th>
</tr>

<?php

$rs=$link->query("SELECT pedidos.n_ped, pedidos.fecha, clientes.cliente, pedidos.totpedido, factemi.n_ FROM pedidos LEFT JOIN clientes ON pedidos.client = clientes.codigo LEFT JOIN factemi ON pedidos.n_ = factemi.n_ ORDER BY n_ped");

// bucle de listado

while($row=$rs->fetch_array(MYSQLI_BOTH)) {

	echo "<tr>";

	echo "<td class='dcha'><a href='gcpedidos.php?desde=gcpedidos&n_ped=".$row['n_ped']."'>".$row['n_ped']."</a></td>\n";

	echo "<td>".$row['cliente']."</td>\n";

	echo "<td>";

	if ($row["fecha"] != "0000-00-00" and $row['fecha'] != "") {
		$a=explode("-",$row["fecha"]); 
		echo $a[2]."/".$a[1]."/".substr($a[0],2,2);
	} else {
		echo "&nbsp;";
	}

	echo "</td>\n";

	echo "<td class='dcha'>".number_format($row['totpedido']*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td>\n";

	echo "<td class='dcha'>";

	if ($row['n_'] == '') {
		echo "&nbsp;";
	} else {
		echo $row['n_'];
	}

	echo "</td></tr>\n";

}

echo "</table>";

