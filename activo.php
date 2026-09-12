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

$result = $link->query("SELECT nombre, anocont FROM empresa");
$row = $result->fetch_array(MYSQLI_BOTH);

$nombre = $row[ 0 ];
$anocont = $row[ 1 ];
$pagina = 1;

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
echo "      <td class='izda'>ACTIVO</td>\n";
echo "      <td class='anchomin b'>EJERCICIO ".$anocont."</td>\n";
echo "   </tr>\n";

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta >= 190 AND cuenta <= 196" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A   = $row[ 0 ] - $row[ 1 ];

echo "   <tr>\n";
echo "      <td class='izda b'>A) ACCIONISTAS (SOCIOS) POR DESEMBOLSOS NO EXIGIDOS</td>\n";
echo "      <td>".number_format( $A*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

$rs1 = $link->query( "SELECT SUM(sdod2c), SUM(sdoh2c) FROM subgrupo WHERE subgrupo = 20" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$BI  = $row[ 0 ] - $row[ 1 ];

$rs1 = $link->query( "SELECT SUM(sdod2c), SUM(sdoh2c) FROM subgrupo WHERE subgrupo = 21" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$BII = $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 281" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$BII += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 291" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$BII += $row[ 0 ] - $row[ 1 ];

$rs1 = $link->query( "SELECT SUM(sdod2c), SUM(sdoh2c) FROM subgrupo WHERE subgrupo = 22" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$BIII = $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdod2c), SUM(sdoh2c) FROM subgrupo WHERE subgrupo = 23" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$BIII += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 282" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$BIII += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 292" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$BIII += $row[ 0 ] - $row[ 1 ];

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta >= 240 AND cuenta <= 247" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$BIV = $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta >= 250 AND cuenta <= 254" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$BIV += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta >= 256 AND cuenta <= 258" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$BIV += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdod2c), SUM(sdoh2c) FROM subgrupo WHERE subgrupo = 26" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$BIV += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta >= 293 AND cuenta <= 298" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$BIV += $row[ 0 ] - $row[ 1 ];

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 198" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$BV  = $row[ 0 ] - $row[ 1 ];

// c&oacute;mo se calcula $BVI ???

$B = $BI + $BII + $BIII + $BIV + $BV + $BVI;

echo "   <tr>\n";
echo "      <td class='izda b'>B) INMOVILIZADO</td>\n";
echo "      <td>".number_format( $B*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>.... I. Gastos de establecimiento</td>\n";
echo "      <td>".number_format( $BI*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>.... II. Inmovilizaciones inmateriales</td>\n";
echo "      <td>".number_format( $BII*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>.... III. Inmovilizaciones materiales</td>\n";
echo "      <td>".number_format( $BIII*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>.... IV. Inmovilizaciones financieras</td>\n";
echo "      <td>".number_format( $BIV*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>.... V. Acciones propias</td>\n";
echo "      <td>".number_format( $BV*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>.... VI. Deudores por operaciones de tr&aacute;fico a largo plazo</td>\n";
echo "      <td>".number_format( $BVI*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

$rs1 = $link->query( "SELECT SUM(sdod2c), SUM(sdoh2c) FROM subgrupo WHERE subgrupo = 27" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$C   = $row[ 0 ] - $row[ 1 ];

$C   = -$C;

echo "   <tr>\n";
echo "      <td class='izda b'>C) GASTOS A DISTRIBUIR EN VARIOS EJERCICIOS</td>\n";
echo "      <td>".number_format( $C*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 558" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$DI  = $row[ 0 ] - $row[ 1 ];

$DI  = -$DI;

$rs1 = $link->query( "SELECT SUM(sdod2c), SUM(sdoh2c) FROM subgrupo WHERE subgrupo >= 30 AND subgrupo <= 36" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$DII = $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdod2c), SUM(sdoh2c) FROM subgrupo WHERE subgrupo = 39" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$DII += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 407" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$DII += $row[ 0 ] - $row[ 1 ];

$DII = -$DII;

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta >= 430 AND cuenta <= 433" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$DIII = $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta >= 435 AND cuenta <= 436" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$DIII += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta >= 551 AND cuenta <= 553" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$DIII += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdod2c), SUM(sdoh2c) FROM subgrupo WHERE subgrupo = 44" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$DIII += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 460" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$DIII += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 544" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$DIII += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta >= 470 AND cuenta <= 472" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$DIII += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 474" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$DIII += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 490" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$DIII += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 493" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$DIII += $row[ 0 ] - $row[ 1 ];

$rs1 = $link->query( "SELECT SUM(sdod2c), SUM(sdoh2c) FROM subgrupo WHERE subgrupo = 53" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$DIV = $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta >= 540 AND cuenta <= 543" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$DIV += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta >= 545 AND cuenta <= 549" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$DIV += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta >= 565 AND cuenta <= 566" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$DIV += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta >= 593 AND cuenta <= 598" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$DIV += $row[ 0 ] - $row[ 1 ];

$DIV = -$DIV;

// c&oacute;mo se calcula $DV ???

$rs1 = $link->query( "SELECT SUM(sdod2c), SUM(sdoh2c) FROM subgrupo WHERE subgrupo = 57" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$DVI = $row[ 0 ] - $row[ 1 ];

$DVI = -$DVI;

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 480" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$DVII = $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 580" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$DVII += $row[ 0 ] - $row[ 1 ];

$DVII = -$DVII;

$D = $DI + $DII + $DIII + $DIV + $DV + $DVI + $DVII;

echo "   <tr>\n";
echo "      <td class='izda b'>D) ACTIVO CIRCULANTE</td>\n";
echo "      <td>".number_format( $D*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>.... I. Accionistas por desembolsos exigidos</td>\n";
echo "      <td>".number_format( $DI*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>.... II. Existencias</td>\n";
echo "      <td>".number_format( $DII*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>.... III. Deudores</td>\n";
echo "      <td>".number_format( $DIII*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>.... IV. Inversiones financieras temporales</td>\n";
echo "      <td>".number_format( $DIV*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>.... V. Acciones propias a corto plazo</td>\n";
echo "      <td>".number_format( $DV*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>.... VI. Tesorer&iacute;a</td>\n";
echo "      <td>".number_format( $DVI*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda'>.... VII. Ajustes por periodificaci&oacute;n</td>\n";
echo "      <td>".number_format( $DVII*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "   <tr>\n";
echo "      <td class='izda b'>TOTAL GENERAL (A + B + C + D)</td>\n";
echo "      <td>".number_format( $A + $B + $C + $D*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "</table>\n";
echo "</div>";

