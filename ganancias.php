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
$pagina = 2;

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
echo "      <td class='izda'>HABER</td>\n";
echo "      <td class='anchomin b'>EJERCICIO ".$anocont."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda b'>B) INGRESOS (B.1 a B.8)</td>\n";
echo "      <td class='anchomin'>".number_format( $B*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>B.1. Ingresos de explotaci&oacute;n</td>\n";
echo "      <td class='anchomin'>".number_format( $B1*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";
echo "   <tr>\n";
echo "      <td class='izda'>.... a) Importe neto de la cifra de negocios</td>\n";
echo "      <td class='anchomin'>".number_format( $B1a*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";
echo "   <tr>\n";
echo "      <td class='izda'>.... b) Otros ingresos de explotaci&oacute;n</td>\n";
echo "      <td class='anchomin'>".number_format( $B1b*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda b'>B.I P&Eacute;RDIDAS DE EXPLOTACI&Oacute;N (A.1 + A.2 + A.3 + A.4 + A.5 - B.1)</td>\n";
echo "      <td class='anchomin'>".number_format( ( $BI >= 0 ) ? $BI : 0*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>B.2. Ingresos financieros</td>\n";
echo "      <td class='anchomin'>".number_format( $B2*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";
echo "   <tr>\n";
echo "      <td class='izda'>.... a) En empresas del grupo</td>\n";
echo "      <td class='anchomin'>".number_format( $B2a*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";
echo "   <tr>\n";
echo "      <td class='izda'>.... b) En empresas asociadas</td>\n";
echo "      <td class='anchomin'>".number_format( $B2b*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";
echo "   <tr>\n";
echo "      <td class='izda'>.... c) Otros</td>\n";
echo "      <td class='anchomin'>".number_format( $B2c*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";
echo "   <tr>\n";
echo "      <td class='izda'>.... d) Beneficios en inversiones financieras</td>\n";
echo "      <td class='anchomin'>".number_format( $B2d*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>B.3. Diferencias positivas de cambio</td>\n";
echo "      <td class='anchomin'>".number_format( $B3*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda b'>B.II RESULTADOS FINANCIEROS NEGATIVOS (A.6 + A.7 + A.8 - B.2 - B.3)</td>\n";
echo "      <td class='anchomin'>".number_format( $BII*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda b'>B.III P&Eacute;RDIDAS DE LAS ACTIVIDADES ORDINARIAS (B.I + B.II - A.I - A.II)</td>\n";
echo "      <td class='anchomin'>".number_format( ( $BIII >= 0 ) ? $BIII : 0*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>B.4. Beneficios en enajenaci&oacute;n de inmovilizado inmaterial, material y cartera de control</td>\n";
echo "      <td class='anchomin'>".number_format( $B4*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>B.5. Beneficios por operaciones con acciones y obligaciones propias</td>\n";
echo "      <td class='anchomin'>".number_format( $B5*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>B.6. Subvenciones de capital transferidas al resultado del ejercicio</td>\n";
echo "      <td class='anchomin'>".number_format( $B6*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>B.7. Ingresos extraordinarios</td>\n";
echo "      <td class='anchomin'>".number_format( $B7*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>B.8. Ingresos y beneficios de otros ejercicios</td>\n";
echo "      <td class='anchomin'>".number_format( $B8*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda b'>B.IV RESULTADOS EXTRAORDINARIOS NEGATIVOS (A.9 + A.10 + A.11 + A.12 + A.13 - B.4 - B.5 - B.6 - B.7 - B.8)</td>\n";
echo "      <td class='anchomin'>".number_format( $BIV*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda b'>B.V P&Eacute;RDIDAS ANTES DE IMPUESTOS (B.III + B.IV - A.III - A.IV)</td>\n";
echo "      <td class='anchomin'>".number_format( ( $BV > 0 ) ? $BV : 0*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda b'>B.VI RESULTADO DEL EJERCICIO (P&Eacute;RDIDAS) (B.V + A.14 + A.15)</td>\n";
echo "      <td class='anchomin'>".number_format( ( $BVI > 0 ) ? $BVI : 0*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "</table>\n";
echo "</div>"; 

