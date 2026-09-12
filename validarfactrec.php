<?php

//Copyright (C) 2000-2015  Antonio Grandio Botella http://www.antoniograndio.com//Copyright (C) 2000-2015  Inmaculada Echarri San Adrian inma.echarri@gmail.com
//This file is part of Catwin.
//CatWin is free software; you can redistribute it and/or modify//it under the terms of the GNU General Public License as published by//the Free Software Foundation; either version 2 of the License, or//(at your option) any later version.
//CatWin is distributed in the hope that it will be useful,//but WITHOUT ANY WARRANTY; without even the implied warranty of//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the//GNU General Public License for more details://http://www.gnu.org/copyleft/gpl.html
//You should have received a copy of the GNU General Public License//along with Catwin Net; if not, write to the Free Software//Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

session_start();

include("conex.php");

if ($_SESSION['auto'] < 5) {return;}

//****************

$res = $link->query("SELECT ultasi FROM empresa");
$fila = $res->fetch_array(MYSQLI_BOTH);
$asi = $fila[0] + 1;

$link->query("UPDATE empresa SET ultasi = '$asi'");
$ip = $_SERVER['HTTP_CLIENT_IP'];
if (!$ip) {$ip = $_SERVER['REMOTE_ADDR'];}

//****************

$row_id = $_GET['row_id'];
$res = $link->query("SELECT * FROM factrec WHERE row_id = '$row_id'");
$fila = $res->fetch_array(MYSQLI_BOTH);
extract($fila);

$res = $link->query("SELECT cuenta FROM proveed WHERE codigo = '$codigo'");
$proveed = $res->fetch_array(MYSQLI_BOTH);
$proveed = $proveed[0];

$asiento = $asi;

if ( $totalr > 0 )

{

$sql = "INSERT INTO apuntes (asiento, fecha, tipo, cuenta, concepto, debe, ip) VALUES ('$asiento', '$fecha', 'F. Recibida', '60000000', 'Fr. nº ".$fact." de ".$proveed."', '".$totbruto."', '$ip')"; 
if (!$link->query($sql)) die ("El usuario $usuario no tiene permiso para a&ntilde;adir Apuntes.");

$sql = "INSERT INTO apuntes (asiento, fecha, tipo, cuenta, concepto, debe, ip) VALUES ('$asiento', '$fecha', 'F. Recibida', '47200000',"." 'Fr. nº ".$fact." de ".$proveed."', '".($totalr - $totbruto)."', '$ip')"; 
if (!$link->query($sql)) die ("El usuario $usuario no tiene permiso para a&ntilde;adir Apuntes.");

$sql = "INSERT INTO apuntes (asiento, fecha, tipo, cuenta, concepto, haber, ip) VALUES ('$asiento', '$fecha', 'F. Recibida',  '$proveed', 'Fr. nº ".$fact." Cp. 60000000', '".$totalr."', '$ip')"; 
if (!$link->query($sql)) die ("El usuario $usuario no tiene permiso para a&ntilde;adir Apuntes.");

} else {

$totalr = 0 - $totalr;
$totbruto = 0 - $totbruto;
$tipivar1 = 0 - $tipivar1;

$sql = "INSERT INTO apuntes (asiento, fecha, tipo, cuenta, concepto, debe, ip) VALUES ('$asiento', '$fecha', 'F. Recibida', '$proveed', 'S/ Abono nº ".$fact."', '".$totalr."', '$ip')"; 
if (!$link->query($sql)) die ("El usuario $usuario no tiene permiso para a&ntilde;adir Apuntes.");

$sql = "INSERT INTO apuntes (asiento, fecha, tipo, cuenta, concepto, haber, ip) VALUES ('$asiento', '$fecha', 'F. Recibida', '60000000',"." 'Abono nº ".$fact." de ".$proveed."', '".$totbruto."', '$ip')"; 
if (!$link->query($sql)) die ("El usuario $usuario no tiene permiso para a&ntilde;adir Apuntes.");

$sql = "INSERT INTO apuntes (asiento, fecha, tipo, cuenta, concepto, haber, ip) VALUES ('$asiento', '$fecha', 'F. Recibida',  '47200000', 'Abono nº ".$fact." de. ".$proveed."', '".($totalr - $totbruto)."', '$ip')"; 
if (!$link->query($sql)) die ("El usuario $usuario no tiene permiso para a&ntilde;adir Apuntes.");

}

$sql = "INSERT INTO asientos (asiento, fecha, tipo, fich, tipofich) VALUES ('$asiento', '$fecha', 'F. Recibida', '$contenido', '$tipo1')"; 
if (!$link->query($sql)) die ("El usuario $usuario no tiene permiso para a&ntilde;adir Asientos.");

$link->query("UPDATE factrec SET asiento = '$asiento' WHERE row_id = '$row_id'");

echo "SI";

include("funciones.php");
totalapu($link,$asiento);

