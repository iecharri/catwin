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
Los usuarios contables pueden pinchar en "NO" para generar el Asiento siempre que el Proveedor est&eacute; validado
 en Contabilidad.</div><br /><div class='rojo b'>Los Proveedores no validados en Contabilidad (que no est&aacute;n en la tabla de Subcuentas)
  se muestran en color rojo. Los usuarios Contables pueden validarlos en el men&uacute;
   <a href='gcproveedores.php'>Proveedores</a>
</div><p />

&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a class='b' href='gcfacrec.php'>A&ntilde;adir Factura</a><p />
<table class='basica 100 hover' width=100%>
<tr>
<th class='anchomin'>Validado</th><th class='dcha'>Nº Factura</th><th>Proveedor</th><th>Fecha</th><th class='dcha'>Total</th>
</tr>

<?php

if ($fil and $fil == "si") {
	$rs=$link->query("SELECT factrec.fact, factrec.codigo, factrec.fecha, factrec.totalr, proveed.proveed, asiento, row_id, proveed.cuenta FROM factrec LEFT JOIN proveed WHERE factrec.fact == $facrec AND factrec.codigo == $codigo WHERE factrec.totalr != 0 ORDER BY fact");
} else {
	$rs=$link->query("SELECT factrec.fact, proveed.codigo, proveed.proveed, factrec.fecha, factrec.totalr, asiento, row_id, proveed.cuenta FROM factrec LEFT JOIN proveed ON proveed.codigo = factrec.codigo WHERE factrec.totalr != 0 ORDER BY fact");
}

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
				echo "<div id='validar$row_id'><a href=\"javascript:valid('validarfactrec.php?row_id=$row_id', 'validar$row_id');\" style='color:red'>NO</a></div>";
			} else {
				echo "NO";
			}
		}
	}
	echo "</td>";
	
	echo "<td class='dcha'><a href='gcfacrec.php?fact=$fact&codigo=$codigo'>$fact</a></td>\n";

	echo "<td class='wid99'>";
	if (!$cuenta) {echo "<a href='gcproveedores.php?xxx=Editar&codigo=$codigo' class='rojo b'>$proveed</a>";} else {echo $proveed;}
	echo "</td>\n";

	echo "<td>";
				
	if ($fecha != "0000-00-00" and $fecha != "") {
		$a=explode("-",$fecha); 
		echo $a[2]."/".$a[1]."/".substr($a[0],2,2);
}	 else {
		echo "&nbsp;";
	}

	echo "</td>\n";

	echo "<td class='dcha'>".number_format($totalr*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td>\n";

}

echo "</tr></table>";

?>
