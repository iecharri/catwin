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

/* *********** COMPROBACI&Oacute;N Nº ASIENTO **************** */

$result = $link->query("SELECT asiento FROM asientos");

	while ($fila = $result->fetch_array(MYSQLI_BOTH)) :
		
		if ($fila[0] == $asiento) { $mensaje = "No se ha dado de alta. Asiento <span class='b'>$asiento</span> ya existe."; }

	endwhile;

/* ***************COMPROBACI&Oacute;N A&Ntilde;O ****************** */

$result = $link->query("SELECT anocont FROM empresa");
$fila = $result->fetch_array(MYSQLI_BOTH);

$b = explode("/",$fecha);

if ($fila[0] != "20".$b[2]) { $mensaje1 = "No se ha creado. El a&ntilde;o no es el del ejercicio actual ($fila[0])"; }

/* ***************COMPROBACI&Oacute;N EXISTEN LAS CUENTAS****** */

$mensaje = existesubcuenta($link,$cliente1);
if (!$mensaje) {$mensaje = existesubcuenta($link,$cuening1);}
$mensaje = $mensaje1.$mensaje;

/* **************************************************** */

if (trim($mensaje) == "" AND $asiento <= 9999999000) {

$a=explode("/",$fecha); 
$b="20".$a[2]."-".$a[1]."-".$a[0];
$nomatach = $_FILES['fich']['name'];
if ($nomatach) {
	$tipo1    = $_FILES["fich"]["type"];
	$archivo1 = $_FILES["fich"]["tmp_name"];
	$tamanio1 = $_FILES["fich"]["size"];
	$fp = fopen($archivo1, "rb");
    $contenido = fread($fp, $tamanio1);
    $contenido = addslashes($contenido);
    fclose($fp);
}

$ip = $_SERVER['HTTP_CLIENT_IP'];
if (!$ip) {$ip = $_SERVER['REMOTE_ADDR'];}

$sql = "SELECT codigo, cuenta FROM clientes WHERE cuenta = '$cliente1'";
$result = $link->query($sql);
if (!$result->num_rows) {
	$res = $link->query("SELECT descripci_ FROM subcuent WHERE cuenta = '$cliente1'");
	$fila = $res->fetch_array(MYSQLI_BOTH);
	$link->query("INSERT INTO clientes (cliente, cuenta) VALUES ('$fila[0]', '$cliente1')");
	$res = $link->query("SELECT codigo FROM clientes WHERE cuenta = '$cliente1'");
	$fila = $res->fetch_array(MYSQLI_BOTH);
} else {
	$fila = $result->fetch_array(MYSQLI_BOTH);
}
$codigo = $fila[0];

if ( $totfac > 0 )

{

$sql = "INSERT INTO factemi (fecha, n_, cliente, total, tipivar1, benefbrut, fich, tipofich, asiento) VALUES ('$b', '$numfac', '$codigo', '$totfac', '$tipoiva', '$baseimp', '$contenido', '$tipo1', '$asiento')";
if (!$link->query($sql)) die ("No se ha podido a&ntilde;adir Factura Emitida.");

$sql = "INSERT INTO apuntes (asiento, fecha, tipo, cuenta, concepto, debe, ip) VALUES ('$asiento', '$b', 'F. Emitida', '$cliente1', 'Venta Nº/Fr. nº ".$numfac."', ".$totfac.", '$ip')"; 
if (!$link->query($sql)) die ("No se ha podido a&ntilde;adir Apunte.");

$sql = "INSERT INTO apuntes (asiento, fecha, tipo, cuenta, concepto, haber, ip) VALUES ('$asiento', '$b', 'F. Emitida',  '$cuening1', 'Nº/Fr. nº ".$numfac." a ".$cliente1."', ".$baseimp.", '$ip')"; 
if (!$link->query($sql)) die ("No se ha podido a&ntilde;adir Apunte.");

$sql = "INSERT INTO apuntes (asiento, fecha, tipo, cuenta, concepto, haber, ip) VALUES ('$asiento', '$b', 'F. Emitida', '47700000', 'Nº/Fr. nº ".$numfac." a ".$cliente1."', ".$cuotaiva.", '$ip')"; 
if (!$link->query($sql)) die ("No se ha podido a&ntilde;adir Apunte.");

} else {

$totfac = 0 - $totfac;
$baseimp = 0 - $baseimp;
$cuotaiva = 0 - $cuotaiva;

$sql = "INSERT INTO factemi (fecha, n_, cliente, total, tipivar1, benefbrut, fich, tipofich, asiento) VALUES ('$b', '$numfac', '$codigo', '$totfac', '$tipoiva', '$baseimp', '$contenido', '$tipo1', '$asiento')";
if (!$link->query($sql)) die ("No se ha podido a&ntilde;adir Factura Emitida.");

$sql = "INSERT INTO apuntes (asiento, fecha, tipo, cuenta, concepto, debe, ip) VALUES ('$asiento', '$b', 'F. Emitida', '$cuening1', 'Nº/Abono nº ".$numfac." a ".$cliente1."', ".$baseimp.", '$ip')"; 
if (!$link->query($sql)) die ("No se ha podido a&ntilde;adir Apunte.");

$sql = "INSERT INTO apuntes (asiento, fecha, tipo, cuenta, concepto, debe, ip) VALUES ('$asiento', '$b', 'F. Emitida',  '47700000', 'Nº/Abono nº ".$numfac." a ".$cliente1."', ".$cuotaiva.", '$ip')"; 
if (!$link->query($sql)) die ("No se ha podido a&ntilde;adir Apunte.");

$sql = "INSERT INTO apuntes (asiento, fecha, tipo, cuenta, concepto, haber, ip) VALUES ('$asiento', '$b', 'F. Emitida', '$cliente1', ' venta Nº/Fr. nº ".$numfac."', ".$totfac.", '$ip')"; 
if (!$link->query($sql)) die ("No se ha podido a&ntilde;adir Apunte.");

}

$link->query("UPDATE empresa SET ultfecha = '$b', ultfact = '$numfac'"); 

$sql = "INSERT INTO asientos (asiento, fecha, tipo, fich, tipofich, explicacion) VALUES ('$asiento', '$b', 'F. Emitida', '$contenido', '$tipo1', \"$explicacion\")"; 
if (!$link->query($sql)) die ("No se ha podido a&ntilde;adir Asiento.");

$anadido = 1;

}

