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

?>

<div class='rojo b'>El campo "Validado" indica si se ha generado el Asiento correspondiente en Contabilidad.
 Los usuarios contables pueden pinchar en "NO" para generar el Asiento siempre que el Cliente est&eacute; validado
  en Contabilidad.<p />Los Clientes no validados en Contabilidad (que no est&aacute;n en la tabla de Subcuentas)
   se muestran en color rojo. Los usuarios Contables pueden validarlos en el men&uacute; <a href='gcclientes.php'>
   Clientes</a></div><p />

&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a class='b' href='gcaltafactemi.php'>A&ntilde;adir Factura</a><p />
<table class='basica 100 hover' width='100%'>
<tr>
<th class='anchomin'>Validado</th><th class='dcha'>Nº Factura</th><th>Cliente</th><th>Fecha</th><th class='dcha'>Total</th>
</tr>

<?php

$rs=$link->query("SELECT factemi.n_, factemi.dni, factemi.fecha, factemi.total, clientes.cliente, clientes.cuenta, factemi.row_id, asiento, clientes.codigo FROM factemi LEFT JOIN clientes ON factemi.cliente = clientes.codigo ORDER BY n_");

// bucle de listado

while($row=$rs->fetch_array(MYSQLI_BOTH)) {

	extract($row);
	
	echo "<tr>";

	echo "<td class='centro anchomin'>";
	if ($_SESSION['auto'] < 5) {
		if ($asiento) {
			echo "S&Iacute;";
		} else {
			echo "NO";
		}
	} else {
		if ($asiento) {
			echo "SI";
		} else {
			if ($cuenta) {
				echo "<div id='validar$n_'><a href=\"javascript:valid('validarfactemi.php?n_=$n_', 'validar$n_');\" style='color:red'>NO</a></div>";
			} else {
				echo "NO";
			}
		}
	}
	echo "</td>";

	echo "<td class='dcha'><a href='gclisfactemi.php?row_id=".$row['row_id']."'>".$row['n_']."</a></td>\n";

	echo "<td>";
	if ($cuenta) {
		echo $row['cliente'];
	} else {
		echo "<a href='gcclientes.php?accion=Editar&codigo=".$row['codigo']."' class='rojo b'>".$row['cliente']."</a>";
	}
	echo "</td>\n";

	echo "<td>";

	if ($row["fecha"] != "0000-00-00" and $row['fecha'] != "") {
		$a=explode("-",$row["fecha"]); 
		echo $a[2]."/".$a[1]."/".substr($a[0],2,2);
	} else {
		echo "&nbsp;";
	}

	echo "</td>\n";

	echo "<td class='dcha'>".number_format($row['total']*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td>\n";

}

echo "</tr></table>";
