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

// Calcula los valores usados en los listados de p&eacute;rdidas y ganancias

$rs1 = $link->query( "SELECT SUM(sdod2c), SUM(sdoh2c) FROM subgrupo WHERE subgrupo >= 60 AND subgrupo < 70" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A   = $row[ 1 ] - $row[ 0 ];

$rs1 = $link->query( "SELECT SUM(sdod2c), SUM(sdoh2c) FROM subgrupo WHERE subgrupo >= 60 AND subgrupo <= 61" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A1  = $row[ 1 ] - $row[ 0 ];
$rs1 = $link->query( "SELECT SUM(sdod2c), SUM(sdoh2c) FROM subgrupo WHERE subgrupo >= 71 AND subgrupo < 72" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A1  += $row[ 1 ] - $row[ 0 ];

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta >= 640 AND cuenta <= 649" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A2  = $row[ 0 ] - $row[ 1 ];

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta >= 640 AND cuenta < 641" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A2a = $row[ 0 ] - $row[ 1 ];

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta >= 642 AND cuenta <= 649" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A2b = $row[ 0 ] - $row[ 1 ];

$rs1 = $link->query( "SELECT SUM(sdod2c), SUM(sdoh2c) FROM subgrupo WHERE subgrupo = 68" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A3  = $row[ 1 ] - $row[ 0 ];

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 650 OR ( cuenta >= 693 AND cuenta <= 695 ) OR ( cuenta >= 793 AND cuenta <= 795 )" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A4  = $row[ 0 ] - $row[ 1 ];

$rs1 = $link->query( "SELECT SUM(sdod2c), SUM(sdoh2c) FROM subgrupo WHERE subgrupo = 62" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A5  = $row[ 1 ] - $row[ 0 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 631 OR cuenta = 634 OR cuenta = 636 OR cuenta = 639 OR cuenta = 651 OR cuenta = 659 OR cuenta = 690" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A5  += $row[ 0 ] - $row[ 1 ];

$rs1 = $link->query( "SELECT SUM(sdod2c), SUM(sdoh2c) FROM subgrupo WHERE subgrupo = 70" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$B1a = $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdod2c), SUM(sdoh2c) FROM subgrupo WHERE subgrupo >= 73 AND subgrupo <= 75" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$B1b = $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 790" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$B1b += $row[ 0 ] - $row[ 1 ];
$B1 = $B1a + $B1b;

$AI = $B1 - $A1 - $A2 - $A3 - $A4 - $A5;

if( $AI < 0 )
   $AI = 0;

$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 66100000 AND cuenta <= 66109999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A6A = $row[ 1 ] - $row[ 0 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 66150000 AND cuenta <= 66159999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A6A += $row[ 1 ] - $row[ 0 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 66200000 AND cuenta <= 66209999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A6A += $row[ 1 ] - $row[ 0 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 66300000 AND cuenta <= 66309999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A6A += $row[ 1 ] - $row[ 0 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 66400000 AND cuenta <= 66409999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A6A += $row[ 1 ] - $row[ 0 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 66500000 AND cuenta <= 66509999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A6A += $row[ 1 ] - $row[ 0 ];

$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 66110000 AND cuenta <= 66119999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A6B = $row[ 1 ] - $row[ 0 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 66160000 AND cuenta <= 66169999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A6B += $row[ 1 ] - $row[ 0 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 66210000 AND cuenta <= 66219999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A6B += $row[ 1 ] - $row[ 0 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 66310000 AND cuenta <= 66319999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A6B += $row[ 1 ] - $row[ 0 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 66410000 AND cuenta <= 66419999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A6B += $row[ 1 ] - $row[ 0 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 66510000 AND cuenta <= 66519999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A6B += $row[ 1 ] - $row[ 0 ];

$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 66130000 AND cuenta <= 66139999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A6C = $row[ 1 ] - $row[ 0 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 66180000 AND cuenta <= 66189999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A6C += $row[ 1 ] - $row[ 0 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 66220000 AND cuenta <= 66229999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A6C += $row[ 1 ] - $row[ 0 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 66230000 AND cuenta <= 66239999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A6C += $row[ 1 ] - $row[ 0 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 66320000 AND cuenta <= 66329999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A6C += $row[ 1 ] - $row[ 0 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 66330000 AND cuenta <= 66339999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A6C += $row[ 1 ] - $row[ 0 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 66430000 AND cuenta <= 66439999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A6C += $row[ 1 ] - $row[ 0 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 66530000 AND cuenta <= 66539999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A6C += $row[ 1 ] - $row[ 0 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 669" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A6C += $row[ 0 ] - $row[ 1 ];

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 666 OR CUENTA = 667" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A6D = $row[ 0 ] - $row[ 1 ];

$A6 = $A6A + $A6B + $A6C + $A6D; 

$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 69630000 AND cuenta <= 69639999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A7 = $row[ 1 ] - $row[ 0 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 69650000 AND cuenta <= 69659999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A7 += $row[ 1 ] - $row[ 0 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 69660000 AND cuenta <= 69669999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A7 += $row[ 1 ] - $row[ 0 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 697 OR cuenta = 698 OR cuenta = 699" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A7 += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 79630000 AND cuenta <= 79639999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A7 += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 79650000 AND cuenta <= 79659999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A7 += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 79660000 AND cuenta <= 79669999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A7 += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 797 OR cuenta = 798 OR cuenta = 799" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A7 += $row[ 1 ] - $row[ 0 ];

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 668" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A8  = $row[ 0 ] - $row[ 1 ];

$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 76000000 AND cuenta <= 76009999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$B2a = $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 76100000 AND cuenta <= 76109999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$B2a += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 76200000 AND cuenta <= 76209999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$B2a += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 76300000 AND cuenta <= 76309999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$B2a += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 76500000 AND cuenta <= 76509999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$B2a += $row[ 0 ] - $row[ 1 ];

$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 76010000 AND cuenta <= 76019999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$B2b = $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 76110000 AND cuenta <= 76119999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$B2b += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 76210000 AND cuenta <= 76219999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$B2b += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 76310000 AND cuenta <= 76319999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$B2b += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 76510000 AND cuenta <= 76519999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$B2b += $row[ 0 ] - $row[ 1 ];

$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 76030000 AND cuenta <= 76039999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$B2c = $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 76130000 AND cuenta <= 76139999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$B2c += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 76230000 AND cuenta <= 76239999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$B2c += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 76330000 AND cuenta <= 76339999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$B2c += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 76530000 AND cuenta <= 76539999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$B2c += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 769" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$B2c += $row[ 0 ] - $row[ 1 ];

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 766" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$B2d = $row[ 0 ] - $row[ 1 ];

$B2 = $B2a + $B2b + $B2c + $B2d;

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 768" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$B3  = $row[ 0 ] - $row[ 1 ];

$AII = $B2 - $B3 - $A6 - $A7 - $A8; 

$BI = $A1 + $A2 + $A3 + $A4 + $A5 - $B1;

$BII = $A6 + $A7 + $A8 - $B2 - $B3;

$BIII = $BI + $BII - $AI - $AII;

$AIII = $AI + $AII - ( ( $BI > 0 ) ? $BI : 0 ) - $BII;
if( $AIII < 0 )
   $AIII = 0;

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta >= 770 AND cuenta <= 773" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$B4  = $row[ 0 ] - $row[ 1 ];

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 774" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$B5  = $row[ 0 ] - $row[ 1 ];

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 775" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$B6  = $row[ 0 ] - $row[ 1 ];

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 778" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$B7  = $row[ 0 ] - $row[ 1 ];

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 779" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$B8  = $row[ 0 ] - $row[ 1 ];

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 691 OR cuenta = 692" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A9  = $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 69600000 AND cuenta <= 69619999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A9 += $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 791 OR cuenta = 792" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A9 += $row[ 1 ] - $row[ 0 ];
$rs1 = $link->query( "SELECT SUM(saldod), SUM(saldoa) FROM subcuent WHERE cuenta >= 79600000 AND cuenta <= 79619999" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A9 += $row[ 1 ] - $row[ 0 ];

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta >= 670 OR cuenta <= 673" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A10 = $row[ 0 ] - $row[ 1 ];

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 674" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A11 = $row[ 0 ] - $row[ 1 ];

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 678" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A12 = $row[ 0 ] - $row[ 1 ];

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 679" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A13 = $row[ 0 ] - $row[ 1 ];

$AIV = $B4 + $B5 + $B6 + $B7 + $B8 - $A9 - $A10 - $A11 - $A12 - $A13;

$BIV = $A9 + $A10 + $A11 + $A12 + $A13 - $B4 - $B5 - $B6 - $B7 - $B8;

$AV = $AIII + $AIV - ( ( $BIII > 0 ) ? $BIII : 0 ) - $BIV;

$BV = $BIII + $BIV - $AIII - $AIV;

$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 630 OR cuenta = 633" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A14 = $row[ 0 ] - $row[ 1 ];
$rs1 = $link->query( "SELECT SUM(sdo3cd), SUM(sdo3ca) FROM cuentas WHERE cuenta = 638" );
$row = $rs1->fetch_array(MYSQLI_BOTH);
$A14 += $row[ 1 ] - $row[ 0 ];

$AVI = $AV - $A14 - $A15;

$BVI = $BV + $A14 + $A15;

$B = $B1 + $B2 + $B3 + $B4 + $B5 + $B6 + $B7 + $B8;

