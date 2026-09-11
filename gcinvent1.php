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

?>

<table class='basica 100 hover' width='100%'>
<tr><th>&nbsp;</th>
<th>Art&iacute;culo</th><th>Situaci&oacute;n</th><th>F. Pedido</th><th>F. Recepci&oacute;n</th><th>Tipo</th><th class='dcha'>Coste</th>
</tr>

<?php
if ($desde=="gcpedidos") {
	$sql = "SELECT invent.row_id, n_ped, proveed, artic, situaci_n, fechap, fechar, p_coste, tipos.tipo FROM invent LEFT JOIN tipos ON invent.tipo = tipos.row_id WHERE n_ped = '$n_ped' ORDER BY artic";
} else {
	$sql = "SELECT invent.row_id, facrec, proveed, artic, situaci_n, fechap, fechar, p_coste, tipos.tipo FROM invent LEFT JOIN tipos ON invent.tipo = tipos.row_id WHERE facrec = '$fact' and codigo = '$codigo' ORDER BY artic";
}

$rs=$link->query($sql);

// bucle de listado

while($row=$rs->fetch_array(MYSQLI_BOTH)) {

    echo "<tr>\n";

	echo "<td><a href=?xx=";
	
	echo str_replace(" ","%20",$xx);
		
	echo "&row_id=".$row['row_id']."&anadir=3&";
	
	if ($desde=="gcpedidos") {
		echo "n_ped=".$n_ped."&dni=".$dni;
	} else {
	echo "fact=".$fact."&codigo=".$codigo;
	}

	echo "&desde=".$desde.">Editar</a></td>\n";

	echo "<td>";
	if ($row['artic']=='') {
		echo "&nbsp";
	} else {
		echo $row['artic'];
	}
	echo "</td>\n";

	echo "<td>";
		if ($row['situaci_n']=='') {
		echo "&nbsp";
	} else {
		echo $row['situaci_n'];
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
				
	echo "</td>\n";

	echo "<td>".$row['tipo']."</td>\n";

	echo "<td class='dcha'>".number_format($row['p_coste']*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td></tr>\n";

}

if ($desde and $desde=="gcpedidos") {

	$sql="SELECT SUM(p_coste) AS tot FROM invent WHERE n_ped = '$n_ped'";

} else {

	$sql="SELECT SUM(p_coste) AS tot FROM invent WHERE facrec = '$fact' and codigo = '$codigo'";
}

$result=$link->query($sql); 
$row=$result->fetch_array(MYSQLI_BOTH);
$a = $row[0]-$baseimp;

echo "<tr>";

echo "<td class=blanco colspan=3>Descuadre= ".number_format($a*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td>";

echo "<td class='blanco dcha b' colspan='3'>";

echo "TOTAL: ";

echo "</td>\n";

echo "<td class='blanco dcha'>".number_format($row[0]*$_SESSION['moneda'],$_SESSION['deci'],',','.')."</td></tr></table>";

?>
