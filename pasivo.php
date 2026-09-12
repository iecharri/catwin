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
echo "<p class='centro b'>BALANCE DE SITUACI&Oacute;N<p />\n";
echo "<br />\n";
echo "<p class='centro'>DICIEMBRE ".$anocont."<p />\n";
echo "<table class='listados wid99' cellspacing='1'>\n";
echo "   <tr>\n";
echo "      <td class='izda'>PASIVO</td>\n";
echo "      <td class='anchomin b'>EJERCICIO ".$anocont."</td>\n";
echo "   </tr>\n";

$rs1 = $link->query( "SELECT SUM(sdod2c), SUM(sdoh2c) FROM subgrupo WHERE subgrupo = 10" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$AI  = $row[ 0 ] - $row[ 1 ];

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 110" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$AII = $row[ 0 ] - $row[ 1 ];

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 111" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$AIII = $row[ 0 ] - $row[ 1 ];

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta >= 112 AND cuenta <= 118" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$AIV = $row[ 0 ] - $row[ 1 ];

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta >= 120 AND cuenta <= 122" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$AV  = $row[ 0 ] - $row[ 1 ];

// $rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 129" );
// Calculamos dinamicamente el valor de la cuenta 129 (ingresos menos gastos)
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta >= 700 AND cuenta <= 799" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$AVI = -( $row[ 0 ] - $row[ 1 ] );
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta >= 600 AND cuenta <= 699" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$AVI -= $row[ 0 ] - $row[ 1 ];

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 557" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$AVII = $row[ 0 ] - $row[ 1 ];

$A = $AI + $AII + $AIII + $AIV + $AV + $AVI + $AVII;

echo "   <tr>\n";
echo "      <td class='izda b'>A) FONDOS PROPIOS</td>\n";
echo "      <td>".number_format( $A*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>.... I. Capital suscrito</td>\n";
echo "      <td>".number_format( $AI*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>.... II. Prima de emisi&oacute;n</td>\n";
echo "      <td>".number_format( $AII*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>.... III. Reserva de revalorizaci&oacute;n</td>\n";
echo "      <td>".number_format( $AIII*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>.... IV. Reservas</td>\n";
echo "      <td>".number_format( $AIV*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

// C&oacute;mo calcular $AIV1 y $AIV2 ???

echo "   <tr>\n";
echo "      <td class='izda'>........ 1. Diferencias por ajuste del capital a euros</td>\n";
echo "      <td>".number_format( $AIV1*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>........ 2. Resto de reservas</td>\n";
echo "      <td>".number_format( $AIV2*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>.... V. Resultados de ejercicios anteriores</td>\n";
echo "      <td>".number_format( $AV*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>.... VI. P&eacute;rdidas y Ganancias (beneficio &oacute; p&eacute;rdida)</td>\n";
echo "      <td>".number_format( $AVI*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>.... VII. Dividendo a cuenta entregado en el ejercicio</td>\n";
echo "      <td>".number_format( $AVII*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>.... VIII. Acciones propias para reducci&oacute;n de capital</td>\n";
echo "      <td>".number_format( $AVIII*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

$rs1 = $link->query( "SELECT SUM(sdod2c), SUM(sdoh2c) FROM subgrupo WHERE subgrupo = 13" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$B   = $row[ 0 ] - $row[ 1 ];

echo "   <tr>\n";
echo "      <td class='izda b'>B) INGRESOS A DISTRIBUIR EN VARIOS EJERCICIOS</td>\n";
echo "      <td>".number_format( $B*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

$rs1 = $link->query( "SELECT SUM(sdod2c), SUM(sdoh2c) FROM subgrupo WHERE subgrupo = 14" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$C   = $row[ 0 ] - $row[ 1 ];

echo "   <tr>\n";
echo "      <td class='izda b'>C) PROVISIONES PARA RIESGOS Y GASTOS</td>\n";
echo "      <td>".number_format( $C*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

$rs1 = $link->query( "SELECT SUM(sdod2c), SUM(sdoh2c) FROM subgrupo WHERE subgrupo >= 15 AND subgrupo <= 18" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$D   = $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta >= 248 AND cuenta <= 249" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$D  += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 259" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$D  += $row[ 0 ] - $row[ 1 ];

echo "   <tr>\n";
echo "      <td class='izda b'>D) ACREEDORES A LARGO PLAZO</td>\n";
echo "      <td>".number_format( $D*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta >= 400 AND cuenta <= 403" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$E   = $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 406" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$E  += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdod2c), SUM(sdoh2c) FROM subgrupo WHERE subgrupo = 41" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$E  += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 437" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$E  += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 465" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$E  += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta >= 475 AND cuenta <= 477" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$E  += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 479" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$E  += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 485" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$E  += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 499" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$E  += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdod2c), SUM(sdoh2c) FROM subgrupo WHERE subgrupo >= 50 AND subgrupo <= 52" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$E  += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta >= 551 AND cuenta <= 553" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$E  += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta >= 555 AND cuenta <= 556" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$E  += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta >= 560 AND cuenta <= 561" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$E  += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 585" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$E  += $row[ 0 ] - $row[ 1 ];

if( $E < 0 )
   $E = -$E;

echo "   <tr>\n";
echo "      <td class='izda b'>E) ACREEDORES A CORTO PLAZO</td>\n";
echo "      <td>".number_format( $E*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda b'>F) PROVISIONES PARA RIESGOS Y GASTOS A CORTO PLAZO</td>\n";
echo "      <td>".number_format( $F*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda b'>TOTAL GENERAL (A + B + C + D + E + F)</td>\n";
echo "      <td>".number_format( $A + $B + $C + $D + $E + $F*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "</table>\n";
echo "</div>";

