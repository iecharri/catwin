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

?>

<?php

include( "perygan.php" );

$result = $link->query("SELECT nombre, anocont FROM empresa");
$row = $result->fetch_array(MYSQLI_BOTH);

$nombre = $row[0];
$anocont = $row[1];
$pagina = 1;

echo "<div id='pag' class='arial'>";
echo "<table class='entradadatos wid99'>\n";
echo "   <tr>\n";
echo "      <td width='50%'>".$nombre."</td>\n";
echo "      <td width='50%' class='dcha'>P&aacute;g: ".$pagina."</td>\n";
echo "   </tr>\n";
echo "</table>\n";
echo "<br />\n";
echo "<p class='centro b'>CUENTA DE PERDIDAS Y GANANCIAS<p />\n";
echo "<br />\n";
echo "<p class='centro'>DICIEMBRE ".$anocont."<p />\n";
echo "<table class='listados wid99' cellspacing='1'>\n";
echo "   <tr>\n";
echo "      <td class='izda'>DEBE</td>\n";
echo "      <td class='anchomin b'>EJERCICIO ".$anocont."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda b'>A) GASTOS (A.1 a A.15)</td>\n";
echo "      <td>".number_format( $A*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>A.1. Consumos de explotaci&oacute;n</td>\n";
echo "      <td>".number_format( $A1*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>A.2. Gastos de personal</td>\n";
echo "      <td>".number_format( $A2*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>.... a) Sueldos, salarios y asimilados</td>\n";
echo "      <td>".number_format( $A2a*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>.... b) Cargas sociales</td>\n";
echo "      <td>".number_format( $A2b*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>A.3. Dotaciones para amortizaciones de inmovilizado</td>\n";
echo "      <td>".number_format( $A3*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>A.4. Variaci&oacute;n de las provisiones de tr&aacute;fico y p&eacute;rdidas de cr&eacute;ditos incobrables</td>\n";
echo "      <td>".number_format( $A4*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>A.5. Otros gastos de explotaci&oacute;n</td>\n";
echo "      <td>".number_format( $A5*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda b'>A.I. BENEFICIOS DE EXPLOTACION (B.1-A.1-A.2-A.3-A.4-A.5)</td>\n";
echo "      <td>".number_format( $AI*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>A.6 Gastos financieros y gastos asimilados</td>\n";
echo "      <td>".number_format( $A6*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>.... a) Por deudas con empresas del grupo</td>\n";
echo "      <td>".number_format( $A6A*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>.... b) Por deudas con empresas asociadas</td>\n";
echo "      <td>".number_format( $A6B*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>.... c) Por otras deudas</td>\n";
echo "      <td>".number_format( $A6C*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>.... d) P&eacute;rdidas de inversiones financieras</td>\n";
echo "      <td>".number_format( $A6D*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>A.7 Variaci&oacute;n de las provisiones de inversiones financieras</td>\n";
echo "      <td>".number_format( $A7*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>A.8 Diferencias negativas de cambio</td>\n";
echo "      <td>".number_format( $A8*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda b'>A.II. RESULTADOS FINANCIEROS POSITIVOS (B.2-B.3-A.6-A.7-A.8)</td>\n";
echo "      <td>".number_format( $AII*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda b'>A.III. BENEFICIOS DE LAS ACTIVIDADES ORDINARIAS (A.I+A.II-B.I-B.II)</td>\n";
echo "      <td>".number_format( $AIII*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>A.9 Variaci&oacute;n de las provisiones de inmovilizado inmaterial, material y cartera de control</td>\n";
echo "      <td>".number_format( $A9*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>A.10 P&eacute;rdidas procedentes del inmobilizado inmaterial, material y cartera de control</td>\n";
echo "      <td>".number_format( $A10*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>A.11 P&eacute;rdidas por operaciones con acciones y obligaciones propias</td>\n";
echo "      <td>".number_format( $A11*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>A.12 Gastos extraordinarios</td>\n";
echo "      <td>".number_format( $A12*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>A.13 Gastos y p&eacute;rdidas de otros ejercicios</td>\n";
echo "      <td>".number_format( $A13*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda b'>A.IV. RESULTADOS EXTRAORDINARIOS POSITIVOS (B.4+B.5+B.6+B.7+B.8-A.9-A.10-A.11-A.12-A.13)</td>\n";
echo "      <td>".number_format( $AIV*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda b'>A.V. BENEFICIOS ANTES DE IMPUESTOS (A.III+A.IV-B.III-B.IV)</td>\n";
echo "      <td>".number_format( ( $AV > 0 ) ? $AV : 0*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>A.14 Impuesto sobre sociedades</td>\n";
echo "      <td>".number_format( $A14*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

// De que cuentas se obtiene este valor ? !!!
echo "   <tr>\n";
echo "      <td class='izda'>A.15 Otros impuestos</td>\n";
echo "      <td>".number_format( $A15*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda b'>VI. RESULTADO DEL EJERCICIO (BENEFICIOS) (A.V-A.14-A.15)</td>\n";
echo "      <td>".number_format( ( $AVI > 0 ) ? $AVI : 0*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "</table>\n";
echo "</div>";

?>