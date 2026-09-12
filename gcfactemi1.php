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

$res = $link->query("SELECT n_ped from pedidos WHERE n_ped = '$n_ped' AND client = '$codigo'");
if ($res->num_rows == 0) {
	echo "<p />No existe ese nº de Pedido para ese Cliente."; exit;
}

$res = $link->query("SELECT n_ped from pedidos WHERE n_ped = '$n_ped' AND client = '$codigo' AND n_ != 0");
if ($res->num_rows > 0) {
	echo "<p />El Pedido ya tiene asignado un nº de Factura."; exit;
}

$res = $link->query("SELECT n_ from factemi WHERE n_ = '$n_'");
if ($res->num_rows > 0) {
	echo "<p />Factura existente ya generada."; exit;
}

$res = $link->query("SELECT n_ from pedidos WHERE n_ = '$n_' AND client != '$codigo'");
if ($res->num_rows > 0) {
	echo "<p />Ese nº de Factura est&aacute; asignado a un Pedido de otro Cliente."; exit;
}

$result = $link->query("UPDATE pedidos SET n_ = '$n_' WHERE n_ped = '$n_ped'") or die ("<p />El usuario <span class='b'>$usuario</span> no tiene permiso para modificar Pedidos.");

echo "<p />Se ha asignado el nº de Factura <span class='b'>$n_</span> al Pedido <span class='b'>$n_ped</span>.";

