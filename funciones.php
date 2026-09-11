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

/* *** COMPROBACION A&Ntilde;O ****************************** */

function anocont($link,$fecha) {

	$result = $link->query("SELECT anocont FROM empresa");
	$fila = $result->fetch_array(MYSQLI_BOTH);

	$b = explode("/",$fecha);

	if ($fila[0] != "20".$b[2]) {return 0;}

	return "20".$b[2]."-".$b[1]."-".$b[0];

}

/* *** CABECERA LISTADO ASIENTOS ****************************** */

function cabasi($edborr) {

echo "<tr>";

if ($edborr) {echo "<th colspan=2></th>";}

echo "<th>Cuenta</th><th>Descripci&oacute;n</th><th>Concepto</th><th>Debe</th><th>Haber</th><th>Descuadre</th></tr>";

}

/* *** LISTAR ASIENTO ****************************** */

function asiento($link,$asiento, $edborr, $por, $deci, $bojust) {

if ($bojust == $asiento) {$link->query("UPDATE asientos SET fich = '', tipofich='' WHERE asiento = '$asiento'");}

$result = $link->query("SELECT tipofich, explicacion FROM asientos WHERE asiento = $asiento");
if ($result) {$fichero = $result->fetch_array(MYSQLI_BOTH);}

$result = $link->query("SELECT asiento, tipo, fecha, sumadebe, sumahaber FROM asientos WHERE asiento = $asiento"); 

if ($result->num_rows == 0) {

	echo $mensaje."<p />Asiento <span class='b'>$asiento</span> inexistente o Apunte Hu&eacute;rfano.";
	return;

}

$cols = 6;

if ($edborr) {$cols = $cols+2;}

$asi = $result->fetch_array(MYSQLI_BOTH);
$a=explode("-",$asi["fecha"]);

echo "<tr><td class='blanco b' colspan='$cols'>Asiento: <a href='editasi2.php?asiento=$asiento'>".$asiento."</a> Fecha: ";
echo $a[2]."/".$a[1]."/".substr($a[0],2,2);
echo " Tipo: ";
echo $asi['tipo'];
if ($asi['tipo'] == "F. Recibida") {
	$result = $link->query("SELECT fact, codigo FROM factrec WHERE asiento = '$asiento'");
	$temp = $result->fetch_array(MYSQLI_BOTH);
	echo " <a href='gcfacrec.php?fact=$temp[0]&codigo=$temp[1]'>$temp[0]</a>";
}
if ($asi['tipo'] == "F. Emitida") {
	$result = $link->query("SELECT row_id FROM factemi WHERE asiento = '$asiento'");
	$temp = $result->fetch_array(MYSQLI_BOTH);
	echo " <span class='b'>$temp[0]</span>";
}
echo "</b>";
if ($fichero[0]) {echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href='imagen.php?asiento=$asiento' target='_blank'>Ver Justificante</a>&nbsp;&nbsp;&nbsp;<a href='editasi2.php?asiento=$asiento&bojust=$asiento' onclick='return borrar_justificante()'>Borrar Justificante</a>";}

if (trim($fichero[1])) {
	echo "&nbsp;&nbsp;&nbsp;<a onclick=\"amplred('div$asiento')\">Explicaci&oacute;n (ver/ocultar)</a>";
	echo "<div id='div$asiento' style='display:none'>".$fichero[1]."</div>";
}
echo "</td></tr>";

$result = $link->query("SELECT apuntes.row_id, apuntes.cuenta, concepto, debe, haber, subcuent.descripci_ FROM apuntes LEFT JOIN subcuent ON apuntes.cuenta = subcuent.cuenta WHERE asiento = '$asiento' ORDER BY debe DESC,haber DESC");

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	echo "<tr>";
	if ($edborr) {
		echo "<td><a href='editasi2.php?row_id=".$fila[0]."&asiento=$asiento&accion=editapu' target='_self'>Editar</a></td>";
		echo "<td><a href='editasi2.php?row_id=".$fila[0]."&asiento=$asiento&accion=boapu' onclick='return borrar_apunte()'>Borrar</a></td>";
	}
	echo "<td><a href=\"extractoctas.php?cuenta=".$fila["cuenta"]."&datos='no'\">".$fila["cuenta"]."</a></td>";
	echo "<td>".$fila["descripci_"]."</td>";
	echo "<td>".$fila["concepto"]."</td><td class='dcha'>"; //utf8_decode($fila["concepto"])
	
	if ($fila["debe"] == 0)
	{
		echo "&nbsp;";
	} else {
		echo number_format($fila["debe"]*$por,$deci,',','.');
	}

	echo "</td><td class='dcha'>";
	
	
	if ($fila["haber"] == 0)
	{
		echo "&nbsp;";
	} else {
		echo number_format($fila["haber"]*$por,$deci,',','.');
	}

	echo "</td><td></td></tr>";

}

echo "<tr><td class='blanco dcha b' colspan=".($cols-3).">SUMAS: </td><td class='blanco dcha b'>".number_format($asi['sumadebe']*$por,$deci,',','.')."</td><td class='blanco dcha b'>".number_format($asi['sumahaber']*$por,$deci,',','.')."</td>";
echo "<td class='blanco dcha hover'>";
if ($asi['sumadebe']-$asi['sumahaber'] != 0) {
	echo "<span class='rojo b'>".number_format(($asi['sumadebe']-$asi['sumahaber'])*$por,$deci,',','.')."</span>";
}
echo "</td>";
echo "</tr><tr><td colspan='$cols' class='verde'>&nbsp;</td></tr>";

}

/* *** ACTUALIZAR UNO O TODOS LOS ASIENTOS ****************************** */

function totalapu($link,$asiento) {

if ($asiento) {$where = "WHERE asiento = '$asiento'";}

$rs = $link->query("SELECT asiento from asientos $where");

while ($fila = $rs->fetch_array(MYSQLI_BOTH)) :

	$a = $fila[0];

	$rs1=$link->query("SELECT SUM(debe) AS tot_debe, SUM(haber) AS tot_haber FROM apuntes WHERE asiento = '$a'");
	$fila1 = $rs1->fetch_array(MYSQLI_BOTH);

	$link->query("UPDATE asientos SET sumadebe = '$fila1[0]', sumahaber = '$fila1[1]' WHERE asiento = '$a'");

endwhile;

return ($fila1[0] - $fila1[1]);

}

/* *** TIPO DE ASIENTOS ****************************** */

function tipoasi() {

	$fp = fopen("tipoasi.txt","r");
	while ($linea= fgets($fp,1024)){$array[] = $linea;}
	fclose($fp);
	return $array;

}

/* *** MONEDA ****************************** */

function moneda() {

	$fp = fopen("moneda.txt","r");
	while ($linea= fgets($fp,1024)){$array[] = $linea;}
	fclose($fp);
	return $array;

}

/* *** ACTUALIZAR UNA O TODAS LAS SUBCUENTAS ****************************** */

function totsubcuentas ($subcuenta,$link) {

	if ($subcuenta) {$where = "WHERE cuenta = '$subcuenta'";}

	$rs = $link->query("SELECT cuenta from subcuent $where");

	while ($fila = $rs->fetch_array(MYSQLI_BOTH)) :

		$rs1 = $link->query("SELECT SUM(debe) AS tot_debe, SUM(haber) AS tot_haber FROM apuntes WHERE apuntes.cuenta = ".$fila['cuenta']);
  		$sum = $rs1->fetch_array(MYSQLI_BOTH);

		$tot = $sum['tot_debe'] - $sum['tot_haber'];

		if ($tot > 0)
		{
			$result = $link->query("UPDATE subcuent SET saldod = '$tot', saldoa = 0, sdebe = '".$sum['tot_debe']."', shaber = '".$sum['tot_haber']."' WHERE cuenta =".$fila['cuenta']) or die ("El usuario $usuario no tiene permisos para hacer Balances de Comprobaci&oacute;n."); 
		} else {

			$result = $link->query("UPDATE subcuent SET saldoa = 0 - '$tot', saldod = 0, sdebe = '".$sum['tot_debe']."', shaber = '".$sum['tot_haber']."' WHERE cuenta =".$fila['cuenta']) or die ("El usuario $usuario no tiene permisos para hacer Balances de Comprobaci&oacute;n."); 

		}

	endwhile;

	if ($subcuenta) {totcuenta (substr($subcuenta,0,3));}

}

/* *** ACTUALIZAR UNA O TODAS LAS CUENTAS de CINCO digitos ****************************** */

function totcuentas5 ($link) {

	// Rellenar cuentas5 con las cuentas de subcuent, cogiendo lo 5 primeros d&iacute;gitos
	$link->query("TRUNCATE TABLE cuentas5");
	$sql = "SELECT cuenta FROM subcuent";
	$result = $link->query($sql);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$link->query("INSERT INTO cuentas5 (cuenta) VALUES ('".substr($fila[0],0,5)."')");	
	}	

	$rs = $link->query("SELECT cuenta from cuentas5");

	while ($fila = $rs->fetch_array(MYSQLI_BOTH)) :

		$rs1 = $link->query("SELECT SUM(saldod) AS tot_debe, SUM(saldoa) AS tot_haber FROM subcuent WHERE cuenta LIKE '".$fila['cuenta']."%'");
		$sum = $rs1->fetch_array(MYSQLI_BOTH);

		$tot = $sum['tot_debe'] - $sum['tot_haber'];

		if ($tot > 0)
		{
			$result = $link->query("UPDATE cuentas5 SET sdo5d = '$tot', sdo5h = 0, sdebe = '".$sum['tot_debe']."', shaber = '".$sum['tot_haber']."' WHERE cuenta =".$fila['cuenta']) or die ("El usuario $usuario no tiene permisos para hacer Balances de Comprobaci&oacute;n."); 
		} else {

			$result = $link->query("UPDATE cuentas5 SET sdo5h = 0 - '$tot', sdo5d = 0, sdebe = '".$sum['tot_debe']."', shaber = '".$sum['tot_haber']."'  WHERE cuenta =".$fila['cuenta']) or die ("El usuario $usuario no tiene permisos para hacer Balances de Comprobaci&oacute;n."); 

		}

	endwhile;

}

/* *** ACTUALIZAR UNA O TODAS LAS CUENTAS de CUATRO digitos ****************************** */

function totcuentas4 ($link) {

	// Rellenar cuentas4 con las cuentas de cuentas5, cogiendo lo 4 primeros digitos de cuentas5 y la descripcion del PGC
	$link->query("TRUNCATE TABLE cuentas4");
	$sql = "SELECT cuenta FROM cuentas5";
	$result =$link->query($sql);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$temp = substr($fila[0],0,4);
		$result1 = $link->query("SELECT nombre FROM subcplan WHERE subcuenta = '$temp'");
		$fila = $result1->fetch_array(MYSQLI_BOTH);
		$sql = "INSERT INTO cuentas4 (cuenta, descripcio) VALUES ('$temp', \"$fila[0]\")";
		$link->query($sql);	
	}	

	$rs = $link->query("SELECT cuenta from cuentas4");

	while ($fila = $rs->fetch_array(MYSQLI_BOTH)) :

		$rs1 = $link->query("SELECT SUM(sdebe) AS tot_debe, SUM(shaber) AS tot_haber FROM cuentas5 WHERE cuenta LIKE '".$fila['cuenta']."%'");
		$sum = $rs1->fetch_array(MYSQLI_BOTH);

		$tot = $sum['tot_debe'] - $sum['tot_haber'];

		if ($tot > 0)
		{
			$result = $link->query("UPDATE cuentas4 SET sdo4d = '$tot', sdo4h = 0, sdebe = '".$sum['tot_debe']."', shaber = '".$sum['tot_haber']."' WHERE cuenta =".$fila['cuenta']) or die ("El usuario $usuario no tiene permisos para hacer Balances de Comprobaci&oacute;n."); 
		} else {

			$result = $link->query("UPDATE cuentas4 SET sdo4h = 0 - '$tot', sdo4d = 0, sdebe = '".$sum['tot_debe']."', shaber = '".$sum['tot_haber']."'  WHERE cuenta =".$fila['cuenta']) or die ("El usuario $usuario no tiene permisos para hacer Balances de Comprobaci&oacute;n."); 

		}

	endwhile;

}

/* *** ACTUALIZAR UNA O TODAS LAS CUENTAS ****************************** */

function totcuentas ($cuenta,$link) {

	if ($cuenta) {$where = "WHERE cuenta = '$cuenta'";}

	$rs = $link->query("SELECT cuenta, subgrupo from cuentas $where");

	while ($fila = $rs->fetch_array(MYSQLI_BOTH)) :

		$rs1 = $link->query("SELECT SUM(saldod) AS tot_debe, SUM(saldoa) AS tot_haber FROM subcuent WHERE cuenta LIKE '".$fila['cuenta']."%'");
		$sum = $rs1->fetch_array(MYSQLI_BOTH);

		$tot = $sum['tot_debe'] - $sum['tot_haber'];

		if ($tot > 0)
		{
			$result = $link->query("UPDATE cuentas SET sdo3cd = '$tot', sdo3ca = 0, sdebe = '".$sum['tot_debe']."', shaber = '".$sum['tot_haber']."' WHERE cuenta =".$fila['cuenta']) or die ("El usuario $usuario no tiene permisos para hacer Balances de Comprobaci&oacute;n."); 
		} else {

			$result = $link->query("UPDATE cuentas SET sdo3ca = 0 - '$tot', sdo3cd = 0, sdebe = '".$sum['tot_debe']."', shaber = '".$sum['tot_haber']."'  WHERE cuenta =".$fila['cuenta']) or die ("El usuario $usuario no tiene permisos para hacer Balances de Comprobaci&oacute;n."); 

		}

	endwhile;

}

/* *** ACTUALIZAR UNO O TODOS LOS SUBGRUPOS ****************************** */

function totsubgrupos ($subgrupo,$link) {

	if ($subgrupo) {$where = "WHERE subgrupo = '$subgrupo'";}

	$rs = $link->query("SELECT subgrupo from subgrupo $where");

	while ($fila = $rs->fetch_array(MYSQLI_BOTH)) :

		$rs1 = $link->query("SELECT SUM(sdo3ca) AS tot_debe, SUM(sdo3cd) AS tot_haber FROM cuentas WHERE cuenta LIKE '".$fila['subgrupo']."%'");
	  	$sum = $rs1->fetch_array(MYSQLI_BOTH);

		$tot = $sum['tot_debe'] - $sum['tot_haber'];

		if ($tot > 0)
		{
			$result = $link->query("UPDATE subgrupo SET sdod2c = '$tot', sdoh2c = 0, sdebe = '".$sum['tot_debe']."', shaber = '".$sum['tot_haber']."' WHERE subgrupo =".$fila['subgrupo']) or die ("El usuario $usuario no tiene permisos para hacer Balances de Comprobaci&oacute;n."); 
		} else {

			$result = $link->query("UPDATE subgrupo SET sdoh2c = 0 - '$tot', sdod2c = 0, sdebe = '".$sum['tot_debe']."', shaber = '".$sum['tot_haber']."'  WHERE subgrupo =".$fila['subgrupo']) or die ("El usuario $usuario no tiene permisos para hacer Balances de Comprobaci&oacute;n."); 

		}

	endwhile;

}
