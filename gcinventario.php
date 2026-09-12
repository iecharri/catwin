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

<body>

<?php
include("arriba.php");
$menu51=3;include("menusizda.php");

if (!$xxx) {$xxx = "artic";}

switch ($xxx) {
	case "facrec":
		$sql = "SELECT clientes.cliente, invent.facrec, invent.codigo, invent.artic, invent.situaci_n, invent.fechap, invent.fechar, invent.p_coste, invent.tipo, proveed.proveed, invent.n_ped, pedidos.n_ FROM invent LEFT JOIN proveed ON invent.codigo = proveed.codigo LEFT JOIN pedidos ON invent.n_ped = pedidos.n_ped LEFT JOIN clientes ON pedidos.dni = clientes.dni ORDER BY facrec";
		break;
	case "proveed":
		$sql = "SELECT clientes.cliente, invent.facrec, invent.codigo, invent.artic, invent.situaci_n, invent.fechap, invent.fechar, invent.p_coste, invent.tipo, proveed.proveed, invent.n_ped, pedidos.n_ FROM invent LEFT JOIN proveed ON invent.codigo = proveed.codigo LEFT JOIN pedidos ON invent.n_ped = pedidos.n_ped LEFT JOIN clientes ON pedidos.dni = clientes.dni ORDER BY proveed";
		break;
	case "artic":
		$sql = "SELECT clientes.cliente, invent.facrec, invent.codigo, invent.artic, invent.situaci_n, invent.fechap, invent.fechar, invent.p_coste, invent.tipo, proveed.proveed, invent.n_ped, pedidos.n_ FROM invent LEFT JOIN proveed ON invent.codigo = proveed.codigo LEFT JOIN pedidos ON invent.n_ped = pedidos.n_ped LEFT JOIN clientes ON pedidos.dni = clientes.dni ORDER BY artic";
		break;
	case "n_":
		$sql = "SELECT clientes.cliente, invent.facrec, invent.codigo, invent.artic, invent.situaci_n, invent.fechap, invent.fechar, invent.p_coste, invent.tipo, proveed.proveed, invent.n_ped, pedidos.n_ FROM invent LEFT JOIN proveed ON invent.codigo = proveed.codigo LEFT JOIN pedidos ON invent.n_ped = pedidos.n_ped LEFT JOIN clientes ON pedidos.dni = clientes.dni ORDER BY n_";
		break;
	case "n_ped":
		$sql = "SELECT clientes.cliente, invent.facrec, invent.codigo, invent.artic, invent.situaci_n, invent.fechap, invent.fechar, invent.p_coste, invent.tipo, proveed.proveed, invent.n_ped, pedidos.n_ FROM invent LEFT JOIN proveed ON invent.codigo = proveed.codigo LEFT JOIN pedidos ON invent.n_ped = pedidos.n_ped LEFT JOIN clientes ON pedidos.dni = clientes.dni ORDER BY n_ped";
		break;
	case "cliente":
		$sql = "SELECT clientes.cliente, invent.facrec, invent.codigo, invent.artic, invent.situaci_n, invent.fechap, invent.fechar, invent.p_coste, invent.tipo, proveed.proveed, invent.n_ped, pedidos.n_ FROM invent LEFT JOIN proveed ON invent.codigo = proveed.codigo LEFT JOIN pedidos ON invent.n_ped = pedidos.n_ped LEFT JOIN clientes ON pedidos.dni = clientes.dni ORDER BY cliente";
		break;
}

$result = $link->query("SELECT codigo, proveed FROM proveed WHERE codigo = '$codigo'");
$row1=$result->fetch_array(MYSQLI_BOTH);

echo "<table class='basica 100 hover' width='100%'>\n";
echo "<tr>\n";
echo "<th><a href=?xxx=facrec>Nº Factura</a></th><th><a href=?xxx=proveed>Proveedor</a></th><th><a href=?xxx=artic>Art&iacute;culo</a></th><th>Situaci&oacute;n</th><th>F. Pedido</th><th>F. Recepci&oacute;n</th><th>Tipo</th><th class='dcha'>Coste</th><th class='dcha'><a href=?xxx=n_>Nº Factura</a></th><th class='dcha'><a href=?&xxx=n_ped>Nº Pedido</a></th><th><a href=?xxx=cliente>Cliente</a></th></tr>\n";

$rs = $link->query($sql);
if ($rs->num_rows) {

while($row=$rs->fetch_array(MYSQLI_BOTH)) {

	echo "<tr>";

	echo "<td><a href='gcfacrec.php?fact=".$row['facrec']."&codigo=".$row['codigo']."'>".$row['facrec']."</a></td>\n";

	echo "<td>".$row['proveed']."</td>\n";

	echo "<td>".$row['artic']."</td>\n";

	echo "<td>";
	
	if ($row['situaci_n'] != "") {
		echo $row['situaci_n'];
	} else {
		echo "&nbsp;";
	}
	echo "</td>\n";

	echo "<td>";
				
	if ($row["fechap"] != "0000-00-00" and $row['fechap'] != "") {
			$a=explode("-",$row["fechap"]); 
			echo $a[2]."/".$a[1]."/".substr($a[0],2,2);
	} else {
			echo "&nbsp;";
	}
				
	echo "</td>\n";
	
	echo "<td>";

	if ($row["fechar"] != "0000-00-00" and $row['fechar'] != "") {
			$a=explode("-",$row["fechar"]); 
			echo $a[2]."/".$a[1]."/".substr($a[0],2,2);
	} else {
			echo "&nbsp;";
	}
				
	echo "</td>";

	echo "<td>".$row['tipo']."</td>\n";

	echo "<td class='dcha'>".number_format($row['p_coste']*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td>\n";

	echo "<td class='dcha'>";
	
	if ($row['n_'] != 0) {
		echo $row['n_'];
	}

	echo "</td>\n";
		
	echo "<td class='dcha'";
	
	if ($row['n_ped'] == 0) {
		echo "&nbsp;";
	} else {
	echo "<a href=gcpedidos.php?n_ped=".$row['n_ped']."&anadir=0>".$row['n_ped']."</a>";
	}

	echo "</td>\n";
	
	echo "<td>";
	
	if ($row['cliente'] == "") {
		echo "&nbsp;";
	} else {
		echo $row['cliente'];
	}
	
	echo "</td>\n";

	echo "</tr>\n";

}

}

?>

</table>

<?php $top = 1; include("pie.php");?></body></html>
