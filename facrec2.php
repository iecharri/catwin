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
		
		if ($fila[0] == $asiento) { $mensaje = "No ha sido dado de alta. Asiento ".$asiento." ya existe."; }

	endwhile;

/* ***************COMPROBACI&Oacute;N A&Ntilde;O ****************** */

$result = $link->query("SELECT anocont FROM empresa");
$fila = $result->fetch_array(MYSQLI_BOTH);

$b = explode("/",$fecha);

if ($fila[0] != "20".$b[2]) { $mensaje1 = "No se ha creado. El a&ntilde;o no es el del ejercicio actual (".$fila[0].")."; }

/* ***************COMPROBACI&Oacute;N EXISTEN LAS CUENTAS****** */

$mensaje = existesubcuenta($link,$proveedor1);
if (!$mensaje) {$mensaje = existesubcuenta($link,$cuengas1);}
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

$sql = "SELECT codigo, cuenta FROM proveed WHERE cuenta = '$proveedor1'";
$result = $link->query($sql);
if (!$result->num_rows) {
	$result = $link->query("SELECT descripci_ FROM subcuent WHERE cuenta = '$proveedor1'");
	$fila = $result->fetch_array(MYSQLI_BOTH);
	$link->query("INSERT INTO proveed (proveed, cuenta) VALUES ('$fila[0]', '$proveedor1')");
	$result = $link->query("SELECT codigo FROM proveed WHERE cuenta = '$proveedor1'");
	$fila = $result->fetch_array(MYSQLI_BOTH);
} else {
	$fila = $result->fetch_array(MYSQLI_BOTH);
}
$codigo = $fila[0];

if ( $totfac > 0 )

{

// SE A&Ntilde;ADE UN REGISTRO A TABLA FACTREC.
$sql = "INSERT INTO factrec (fecha, fact, codigo, totalr, tipivar1, totbruto, fich, tipofich, asiento) VALUES ('$b', '$numfac', '$codigo', '$totfac', '$tipoiva', '$baseimp', '$contenido', '$tipo1', '$asiento')";if (!$link->query($sql)) die ("No se ha podido a&ntilde;adir Factura.");

$sql = "INSERT INTO apuntes (asiento, fecha, tipo, cuenta, concepto, debe, ip) VALUES ('$asiento', '$b', 'F. Recibida', '$cuengas1', 'Fr. nº ".$numfac." de ".$proveedor1."', '".$baseimp."', '$ip')"; 
if (!$link->query($sql)) die ("No se ha podido a&ntilde;adir Apunte.");

$sql = "INSERT INTO apuntes (asiento, fecha, tipo, cuenta, concepto, debe, ip) VALUES ('$asiento', '$b', 'F. Recibida', '47200000',"." 'Fr. nº ".$numfac." de ".$proveedor1."', '".$cuotaiva."', '$ip')"; 
if (!$link->query($sql)) die ("No se ha podido a&ntilde;adir Apunte.");

$sql = "INSERT INTO apuntes (asiento, fecha, tipo, cuenta, concepto, haber, ip) VALUES ('$asiento', '$b', 'F. Recibida',  '$proveedor1', 'Fr. nº ".$numfac." Cp. ".$cuengas1."', '".$totfac."', '$ip')"; 
if (!$link->query($sql)) die ("No se ha podido a&ntilde;adir Apunte.");

} else {

$totfac = 0 - $totfac;
$baseimp = 0 - $baseimp;
$cuotaiva = 0 - $cuotaiva;

// SE A&Ntilde;ADE UN REGISTRO A TABLA FACTREC.
$sql = "INSERT INTO factrec (fecha, fact, codigo, totalr, tipivar1, totbruto, fich, tipofich, asiento) VALUES ('$b', '$numfac', '$codigo', '$totfac', '$tipoiva', '$baseimp', '$contenido', '$tipo1', '$asiento')";
if (!$link->query($sql)) die ("No se ha podido a&ntilde;adir Factura Recibida.");

$sql = "INSERT INTO apuntes (asiento, fecha, tipo, cuenta, concepto, debe, ip) VALUES ('$asiento', '$b', 'F. Recibida', '$proveedor1', 'S/ Abono nº ".$numfac."', '".$totfac."', '$ip')"; 
if (!$link->query($sql)) die ("No se ha podido a&ntilde;adir Apunte.");

$sql = "INSERT INTO apuntes (asiento, fecha, tipo, cuenta, concepto, haber, ip) VALUES ('$asiento', '$b', 'F. Recibida', '$cuengas1',"." 'Abono nº ".$numfac." de ".$proveedor1."', '".$baseimp."', '$ip')"; 
if (!$link->query($sql)) die ("No se ha podido a&ntilde;adir Apunte.");

$sql = "INSERT INTO apuntes (asiento, fecha, tipo, cuenta, concepto, haber, ip) VALUES ('$asiento', '$b', 'F. Recibida',  '47200000', 'Abono nº ".$numfac." de. ".$proveedor1."', '".$cuotaiva."', '$ip')"; 
if (!$link->query($sql)) die ("No se ha podido a&ntilde;adir Apunte.");

}

$sql = "INSERT INTO asientos (asiento, fecha, tipo, fich, tipofich, explicacion) VALUES ('$asiento', '$b', 'F. Recibida', '$contenido', '$tipo1', \"$explicacion\")"; 
if (!$link->query($sql)) die ("No se ha podido a&ntilde;adir Asiento.");

$anadido = 1;

}

