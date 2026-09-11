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

if ($desde == 'gcpedidos') {

	$link->query("UPDATE invent SET n_ped = 0 WHERE row_id = $row_id");
	$result = $link->query("SELECT * FROM invent WHERE n_ped = $n_ped");
	if ($result->num_rows == 0) {
		$result = $link->query("DELETE FROM pedidos WHERE n_ped = '$n_ped'") or die ("<p />El usuario $usuario no tiene permisos para borrar Pedidos");
	}

} else {

	$link->query("DELETE FROM invent WHERE row_id = $row_id") or die ("<p />El usuario $usuario no tiene permisos para borrar Art&iacute;culos");
	$result = $link->query("SELECT * FROM invent WHERE facrec = '$fact' AND codigo = '$codigo'");
	if ($result->num_rows == 0) {
		$result1 = $link->query("SELECT asiento FROM facrec WHERE facrec = '$fact' AND codigo = '$codigo'");
		$fila = $result1->fetch_array(MYSQLI_BOTH);
		if ($fila[0]) {
			return; 
		}
		$result = $link->query("DELETE FROM factrec WHERE fact = '$fact' AND codigo = '$codigo'") or die ("<p />El usuario $usuario no tiene permisos para borrar Facturas");
	}

}
?>
