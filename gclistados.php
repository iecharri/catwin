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
$menu51=9;include("menusizda.php");

?>

<div class='noimpri'>

<ol>
<li><span class='rojo b'>EN CONSTRUCCI&Oacute;N</span> <a href='?lis=fr'>Libro de Facturas Recibidas</a></li>
<li><span class='rojo b'>EN CONSTRUCCI&Oacute;N</span> <a href='?lis=fe'>Libro de Facturas Emitidas</a></li>
</ol>

<?php

if ($_GET['lis']) {

	echo "<div class='rojo b centro'><a href='javascript:print()'>IMPRIMIR</a></div>";

}

echo "</div>";

if ($_GET['lis']) {

	$result = $link->query("SELECT nombre, anocont FROM empresa");
	$row = $result->fetch_array(MYSQLI_BOTH);

	$nombre = $row[ 0 ];
	$anocont = $row[ 1 ];
	$pagina = 1;


	echo "<div id='pag' class='arial'>";
	echo $nombre;
	echo "<br />\n";
	echo "<br />\n";
	
	if ($_GET['lis'] == 'fr')   {
		echo "<p class='centro'>LIBRO DE FACTURAS RECIBIDAS ".$anocont."<p />\n";
		fr($link);
	}
	if ($_GET['lis'] == 'fe')  {
		echo "<p class='centro'>LIBRO DE FACTURAS EMITIDAS ".$anocont."<p />\n";
		fe($link);
	}
	
	echo "<p />".ifecha();

}

echo "</div>";
	
$top = 1; include("pie.php");

?>

</body></html>

<?php

function fr($link) {

	echo "<table class='listados wid99'>\n";
	echo "   <tr>\n";
	echo "      <th class='anchomin'>Nº Serie</td>\n";
	echo "      <th class='anchomin'>Tipo</td>\n";
	echo "      <th class='anchomin'>Fecha</td>\n";
	echo "      <th class='anchomin''>Factura</th>\n";
	echo "      <th>Proveedor</th>\n";
	echo "      <th class='anchomin'>Base</th>\n";
	echo "      <th class='anchomin'>Cuota</th>\n";
	echo "      <th class='anchomin'>Total</th>\n";
	echo "   </tr>\n";

	$res=$link->query("SELECT factrec.fact, proveed.codigo, proveed.proveed, DATE_FORMAT(fecha,'%d-%m-%Y') AS fechax, factrec.totalr, totbruto, totalr, row_id, tipivar1 FROM factrec LEFT JOIN proveed ON proveed.codigo = factrec.codigo WHERE factrec.totalr != 0 ORDER BY row_id");

	while($row=$res->fetch_array(MYSQLI_BOTH)) {
	
		extract($row);

		echo "<tr>";
		echo "<td class='anchomin'>$row_id</td>";
		echo "<td class='anchomin'>".($tipivar1 - 1)."</td>";
		echo "<td class='anchomin'>$fechax</td>";
		echo "<td class='anchomin'>$fact</td>";
		echo "<td class='izda'>$proveed</td>";
		$cuota = $totalr-$totbruto;
		$totbase += $totbruto;
		$totcuota += $cuota;
		$tottotal += $totalr;
		echo "<td class='anchomin'>".number_format($totbruto*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>";
		echo "<td class='anchomin'>".number_format($cuota*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>";
		echo "<td class='anchomin'>".number_format($totalr*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>";
		echo "</tr>";
		
	}
	
	echo "<tr>";
	echo "<td></td><td></td><td></td><td></td><td></td>";
	echo "<td>".number_format($totbase*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>";
	echo "<td>".number_format($totcuota*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>";
	echo "<td>".number_format($tottotal*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>";
	echo "</tr>";
	echo "</table>";

}

function fe($link) {

	echo "<table class='listados wid99' cellspacing='1'>\n";
	echo "   <tr>\n";
	echo "      <th class='anchomin'>Nº Serie</td>\n";
	echo "      <th class='anchomin'>Fecha</td>\n";
	echo "      <th>Nombre</td>\n";
	echo "      <th class='anchomin'>Base</th>\n";
	echo "      <th class='anchomin'>Cuota</th>\n";
	echo "      <th class='anchomin'>Total</th>\n";
	echo "   </tr>\n";

	$rs=$link->query("SELECT clientes.dni, clientes.cliente, DATE_FORMAT(fecha,'%d-%m-%Y') AS fechax, factemi.total, benefbrut, n_ FROM factemi LEFT JOIN clientes ON clientes.dni = factemi.dni WHERE factemi.total != 0 ORDER BY n_");

	while($row=$rs->fetch_array(MYSQLI_BOTH)) {
	
		extract($row);

		echo "<tr>";
		echo "<td class='anchomin'>$n_</td>";
		echo "<td class='anchomin'>$fechax</td>";
		echo "<td class='izda'>$cliente</td>";
		$cuota = $total-$benefbrut;
		$totbase += $benefbrut;
		$totcuota += $cuota;
		$tottotal += $total;
		echo "<td class='anchomin'>".number_format($benefbrut*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>";
		echo "<td class='anchomin'>".number_format($cuota*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>";
		echo "<td class='anchomin'>".number_format($total*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>";
		echo "</tr>";
		
	}
	
	echo "<tr>";
	echo "<td></td><td></td><td></td>";
	echo "<td>".number_format($totbase*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>";
	echo "<td>".number_format($totcuota*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>";
	echo "<td>".number_format($tottotal*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>";
	echo "</tr>";
	echo "</table>";

}

function ifecha() {

$ndia = date('N');
$nmes = date('n');

$semana['1'] = "Lunes";
$semana['2'] = "Martes";
$semana['3'] = "Mi&eacute;rcoles";
$semana['4'] = "Jueves";
$semana['5'] = "Viernes";
$semana['6'] = "S&aacute;bado";
$semana['7'] = "Domingo";

$mes[1] = "Enero";
$mes[2] = "Febrero";
$mes[3] = "Marzo";
$mes[4] = "Abril";
$mes[5] = "Mayo";
$mes[6] = "Junio";
$mes[7] = "Julio";
$mes[8] = "Agosto";
$mes[9] = "Septiembre";
$mes[10] = "Octubre";
$mes[11] = "Noviembre";
$mes[12] = "Diciembre";

return $semana[$ndia]." ".date("d")." de ".$mes[$nmes]." de ".date("Y");

}

?>

