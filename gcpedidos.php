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

include("head.php");

if (!$link OR !$_SESSION['empresa']) {
	include("noempresa.php");
	exit;
}
?>

<body <?php if(!$bloqueo AND !$n_ped) {echo "onload=\"foco('codigoc')\"";}?>>

<?php
include("arriba.php");
$menu51=5;include("menusizda.php");

extract($_GET);
extract($_POST);

$result = $link->query("SELECT max(n_) FROM pedidos");

$row = $result->fetch_array(MYSQLI_BOTH);
$ID = $row[0] + 1;

echo " &nbsp; &nbsp;<a href='gclispedidos.php' class='b'>Listado Pedidos</a> &nbsp; &nbsp;";

if ($anadir and $anadir == 1) {

	// SE MARCA EL ARTIC CON EL N_PED
	$anadir = 0;
		$result1 = $link->query("SELECT row_id, artic, n_ped FROM invent WHERE artic = '$artic' AND codigo = '$codigo' AND n_ped = 0");
		if ($result1->num_rows != 0) {
			while ($fila = $result1->fetch_array(MYSQLI_BOTH)) :
				$a = $fila[0];
				break;
			endwhile;
				$link->query("UPDATE invent SET n_ped = '$n_ped' WHERE row_id = $a") or die ("El usuario $usuario no tiene permisos para modificar Inventario.");
		} else {
			echo "<span class='rojo b'> &nbsp; &nbsp;No existe ese Art&iacute;culo de ese Proveedor.</span>";
		}

}

if ($anadir and $anadir == 2) {

	$a=explode("/",$fecha); 
	$b="20".$a[2]."-".$a[1]."-".$a[0];

	$anadir = 0;

	if ($n_ped <= 0) {

		echo "Nº de Pedido ha de ser num&eacute;rico y mayor que cero.";
		exit;

	}

	$result = $link->query("SELECT * FROM pedidos WHERE n_ped = '$n_ped'");

	if ($result->num_rows == 0) {

		// SE A&Ntilde;ADE UN REGISTRO A TABLA PEDIDOS Y SE MARCA EL ARTIC CON EL N_PED
		$result1 = $link->query("SELECT row_id, artic, n_ped FROM invent WHERE artic = '$artic' AND codigo = '$codigo' AND n_ped = 0");
		if ($result1->num_rows != 0) {
			while ($fila = $result1->fetch_array(MYSQLI_BOTH)) {
				$a = $fila[0];
				break;
			}
			$link->query("UPDATE invent SET n_ped = '$n_ped' WHERE row_id = $a") or die ("El usuario $usuario no tiene permisos para modificar Inventario.");
			$sql = "INSERT INTO pedidos (fecha, totpedido, n_ped, client) VALUES ('$b', '$totpedido', '$n_ped', '$codigoc')";
			if (!$link->query($sql)) die ("El usuario $usuario no tiene permiso para a&ntilde;adir Pedidos.");
		} else {
			echo "<span class='rojo b'> &nbsp; &nbsp;No existe ese Art&iacute;culo de ese Proveedor.</span>";
		}

	} else {

	// SE HA INTENTADO CREAR UN PEDIDO QUE YA EXISTE
	$result = $link->query("SELECT proveed FROM proveed WHERE codigo = '$codigo'");
	$fila = $result->fetch_array(MYSQLI_BOTH);
	echo " &nbsp; &nbsp; &nbsp; &nbsp;<span class='rojo'>Ya existe el pedido <span class='b'>".$n_ped."</span></span>\n";

	}
}

if ($anadir == 4) {
	// SE HA PULSADO BOT&Oacute;N PARA EDITAR UN ART&Iacute;CULO
	$anadir = 0;
	include ("gceditarti1.php");

}

if ($anadir == 5) {
	// SE HA PULSADO BOT&Oacute;N PARA BORRAR UN ART&Iacute;CULO
	$anadir = 0;
	include ("gcborraart.php");

}

if ($anadir == 6) {
	// SE HA PULSADO BOT&Oacute;N PARA BORRAR UN PEDIDO
	$anadir = 0;
	include ("gcborrped.php");

}

if ($n_ped and $n_ped != '****') {
	// SE HA PULSADO BOT&Oacute;N PARA CREAR UN NUEVO PEDIDO (se va a editar un art&iacute;culo???)
	echo " &nbsp; &nbsp; &nbsp; &nbsp;<a href=?xx=$xx>Pedido Nuevo</a>\n";
	$result = $link->query("SELECT pedidos.n_, factemi.n_ FROM factemi LEFT JOIN pedidos ON factemi.n_ = pedidos.n_ WHERE pedidos.n_ped = $n_ped");
	if ($result->num_rows == 0) {
		echo " &nbsp; &nbsp &nbsp &nbsp<a href=?xx=$xx&anadir=6&n_ped=".$n_ped." onclick='return borrar_ped()'>Borrar Pedido</a>\n";
	}
	include ("gcpedidos2a.php");


} else {
	// SE ACABA DE A&Ntilde;ADIR UN ART&Iacute;CULO
	$n_ped = '';
	include ("gcpedidos2b.php");

}

if ($anadir == 3) {

	// SE VA A EDITAR UN ART&Iacute;CULO POR HABER PULSADO EL BOT&Oacute;N CORRESPONDIENTE
	include ("gceditarti.php");

}

include("pie.php");?></body></html>
