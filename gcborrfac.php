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

if (!$link OR !$_SESSION['empresa']) {
	return;
}

$result = $link->query("SELECT asiento FROM factrec WHERE fact = '$fact' AND codigo = '$codigo'");
$fila = $result->fetch_array(MYSQLI_BOTH);

if ($fila[0] AND $_SESSION['auto'] < 5) {
	return; 
}

$link->query("DELETE FROM invent WHERE facrec = '$fact' AND codigo = '$codigo'") or die ("<p />El usuario $usuario no tiene permisos para borrar Art&iacute;culos");

$result = $link->query("DELETE FROM factrec WHERE fact = '$fact' AND codigo = '$codigo'") or die ("<p />El usuario $usuario no tiene permisos para borrar Facturas");

if ($fila[0]) {$mensaje = "<p /><span class='rojo b'>Recordar que la Factura Recibida borrada est&aacute; asociada al Asiento <a href='editasi2.php?asiento=$fila[0]'>$fila[0]</a></span><p />";}
