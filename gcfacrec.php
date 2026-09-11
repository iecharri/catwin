<?php

//Copyright (C) 2000-2015  Antonio Grandio Botella http://www.antoniograndio.com
//Copyright (C) 2000-2015  Inmaculada Echarri inma.echarri@gmail.com

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

include("head.php");

if (!$link OR !$_SESSION['empresa']) {
	include("noempresa.php");
	exit;
}
?>

<body>

<?php
include("arriba.php");
$menu51=4;include("menusizda.php");

extract($_GET);
extract($_POST);

echo " &nbsp; &nbsp;<a href='gclisfacrec.php' class='b'>Listado F. Recibidas</a> &nbsp; &nbsp;\n";

if ($anadir == 6) {
	//SE HA PULSADO BOT&Oacute;N PARA BORRAR UNA FACTURA
	include ("gcborrfac.php");
}

if ($nuetipo) {
	$link->query("INSERT INTO tipos (tipo) VALUES (\"$nuetipo\")");
	$tipo = $mysqli->insert_id; 
}

if ($anadir == 1) {
	// Si campo Art&iacute;culo es vac&iacute;o, rellenar el campo artic con "No definido" y p_coste con la Base imponible
	if (!$artic) {
		$artic = "No definido"; $p_coste = $baseimp;
	}
	// SE A&Ntilde;ADE UN REGISTRO A TABLA INVENT
	$sql = "INSERT INTO invent (artic, codigo, tipo, p_coste, facrec) VALUES ('$artic', '$codigo', '$tipo', '$p_coste', '$fact')"; 
	if (!$link->query($sql)) die ("El usuario $usuario no tiene permiso para a&ntilde;adir Art&iacute;culos.");
}

if ($anadir == 2) {

	$a=explode("/",$fecha); 
	$b="20".$a[2]."-".$a[1]."-".$a[0];
	$result = $link->query("SELECT * FROM factrec WHERE fact = '$fact' AND codigo = '$codigo'");

	if ($result->num_rows == 0) {
		// Si campo Art&iacute;culo es vac&iacute;o, rellenar el campo artic con "No definido" y p_coste con la Base imponible
		if (!$artic) {
			$artic = "No definido"; $p_coste = $baseimp;
		}
		// SE A&Ntilde;ADE UN REGISTRO A TABLA INVENT Y OTRO A FACTREC AL SER FACTURA NUEVA
		$sql = "INSERT INTO factrec (fecha, fact, codigo, totalr, tipivar1, totbruto) VALUES ('$b', '$fact', '$codigo', '$totfac', '$tipoiva', '$baseimp')";
		if (!$link->query($sql)) die ("El usuario $usuario no tiene permiso para a&ntilde;adir Facturas.");
		$sql = "INSERT INTO invent (artic, codigo, tipo, p_coste, facrec) VALUES ('$artic', '$codigo', '$tipo', '$p_coste', '$fact')"; 
		if (!$link->query($sql)) die ("El usuario $usuario no tiene permiso para a&ntilde;adir Art&iacute;culos.");

	} else {

	// SE HA INTENTADO CREAR UN Nº FACTURA QUE YA EXISTE PARA UN PROVEEDOR DADO
	$result = $link->query("SELECT proveed FROM proveed WHERE codigo = '$codigo'");
	$fila = $result->fetch_array(MYSQLI_BOTH);
	echo " &nbsp; &nbsp; &nbsp; &nbsp;<span class='rojo'>Ya existe la Factura <span class='b'>".$fact."</span> de <span class='b'>".$fila['proveed']."</span></span>\n";

	}
}

if ($anadir == 4) {
	// SE HA PULSADO BOT&Oacute;N PARA EDITAR UN ART&Iacute;CULO
	include ("gceditarti1.php");
}

if ($anadir == 5) {
	// SE HA PULSADO BOT&Oacute;N PARA BORRAR UN ART&Iacute;CULO
	include ("gcborraart.php");
}

if ($fact and $fact != '****') {
	// SE HA PULSADO BOT&Oacute;N PARA CREAR UNA FACTURA NUEVA
	
	$result = $link->query("SELECT * FROM factrec WHERE fact = '$fact' and codigo = '$codigo'");
	echo " &nbsp; &nbsp; &nbsp; &nbsp;<a href=gcfacrec.php?fact=****>Factura Nueva</a>\n";
	if ($anadir != 6) {echo " &nbsp; &nbsp &nbsp &nbsp<a href=?xx=".str_replace(' ','%20',$xx)."&anadir=6&fact=".$fact."&codigo=".$codigo." onclick='return borrar_fact()'>Borrar Factura</a>\n";
	include ("gcfacrec2a.php");}
} else {
	// SE ACABA DE A&Ntilde;ADIR UN ART&Iacute;CULO ( o m&aacute;s bien es factura nueva???)
	$fact = '';
	include ("gcfacrec2b.php");
}

if ($anadir == 3) {
	// SE VA A EDITAR UN ART&Iacute;CULO POR HABER PULSADO EL BOT&Oacute;N CORRESPONDIENTE
	include ("gceditarti.php");
}

echo $mensaje;

function optioniva($link) {
	$sql = "SELECT * FROM iva ORDER BY n";
	$result = $link->query($sql);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		echo "<option value='".($fila[1] + 1)."'>$fila[1]</option>";
	}	
}

?></div>

<?php include("pie.php");?></body></html>

</body></html>
