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

$sql = "SELECT DISTINCT asiento FROM apuntes WHERE ";

$ant = 0;

//*********************************

if ($apasiento1) {
	$sql = $sql."asiento >= '$apasiento1'";
	$ant = 1;
	if ($apasiento2) {
		$sql = $sql." and ";
	}
}
if ($apasiento2) {
	$sql = $sql."asiento <= '$apasiento2'";
	$ant = 1;
}

//*********************************

$a1=explode("/",$apfecha1); 
$b1="20".$a1[2]."-".$a1[1]."-".$a1[0];
$a2=explode("/",$apfecha2); 
$b2="20".$a2[2]."-".$a2[1]."-".$a2[0];

if ($apfecha1 or $apfecha2) {
	if ($ant == 1) {
		$sql = $sql." ".$orand4;
	}
}

if ($apfecha1) {
	$sql = $sql." fecha >= '$b1'";
	$ant = 1;
	if ($apfecha2) {
		$sql = $sql." and";
	}
}
if ($apfecha2) {
	$sql = $sql." fecha <= '$b2'";
	$ant = 1;
}

//*********************************

if ($apcuenta1) {
	if ($ant == 1) {
		$sql = $sql." ".$orand5;
	}
}
if ($apcuenta1) {
	$sql = $sql." cuenta = '$apcuenta1'";
	$ant = 1;
}

//*********************************

if ($apconcepto1) {
	if ($ant == 1) {
		$sql = $sql." ".$orand6;
	}
}
if ($apconcepto1) {
	$sql = $sql." concepto LIKE '%".$apconcepto1."%'";
	$ant = 1;
}

//*********************************

if ($apimporte1 or $apimporte2) {
	if ($ant == 1) {
		$sql = $sql." ".$orand7;
	}
}

if ($apimporte1) {
	$sql = $sql." (debe >= '$apimporte1' and debe > 0 or haber >= '$apimporte1' and haber > 0)";
	if ($apimporte2) {
		$sql = $sql." and";
	}
}
if ($apimporte2) {
	$sql = $sql." (debe <= '$apimporte2' and debe > 0 or haber <= '$apimporte2' and haber > 0)";
}

//*********************************

$sql = $sql." order by asiento";

echo "RESULTADO DE LA B&Uacute;SQUEDA. ASIENTOS: &nbsp; &nbsp;&nbsp;&nbsp;";

$result = $link->query($sql);

echo "| ";
$ant = 0;
while ($fila = $result->fetch_array(MYSQLI_BOTH)) :
echo "<a href='editasi2.php?asiento=".$fila[0]."'>".$fila[0]."</a> | ";
$ant = 1;
endwhile;

if ($ant == 0) {
	
	echo "<span class='b'> No se encontraron coincidencias </span>|";

}

?>