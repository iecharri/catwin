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

include("config.php");

mysqli_report(MYSQLI_REPORT_OFF);

$link = @new mysqli(SERVER,USER,PASSWORD);
if ($link->connect_errno) {
    echo "<p /><br /><p /><div style='text-align:center'>En estos momentos no hay conexi&oacute;n con el servidor, int&eacute;ntalo m&aacute;s tarde.</div>";
    exit;
}

//***********************************************************

if ($_POST['crearbd']) {include ("crearemp.php");}

//***********************************************************

if (PRUEBA == 1) {
// *** SERVER_PRUEBAS
if ($_GET['emp'] == 1) {
	$_POST['usuario1'] = 'administrador';
	$_POST['empresa1'] = 'nuevocat';
	$_POST['password1'] = "admin";
}
// *** SERVER_PRUEBAS}

if ($_POST['password1'] AND ADAPTARTABLAS == 1) {
	$sel = mysqli_select_db($link,$_POST['empresa1']);
	if (!$sel) {return;}
	$link->query("set names 'utf8'");
	include("adaptarolddb.php");
}

if ($_POST['usuario1']) {
	$_POST['usuario1'] = mysqli_real_escape_string($link,$_POST['usuario1']);
	$_POST['password1'] = mysqli_real_escape_string($link,$_POST['password1']);
	mysqli_select_db($link,$_POST['empresa1']);
	if (mysqli_select_db($link,$_POST['empresa1']) AND $_POST['password1']) {
		$link->query("set names 'utf8'");
		$result = $link->query("SELECT * FROM grupplan");
		if (!$result) {include("plangralconta.php");}
		$result = $link->query("SELECT * FROM usuarios WHERE usuario = '".$_POST['usuario1']."' AND clave = '".SHA1($_POST['password1'])."'");
		$fila = $result->fetch_array(MYSQLI_BOTH);
		if (!$fila) {
			session_unset();session_destroy();mysqli_close($link);return;
		} else {
			$_SESSION['empresa']= $_POST['empresa1'];
			$_SESSION['usuario'] = $_POST['usuario1'];
			$_SESSION['auto'] = $fila['perm'];
		}
	} else {
		session_unset();session_destroy();$link->close();return;
	}
	
}

if ($_POST['accion'] == 'desc') {

	session_unset();
	$link->close();
	return;

}

if (substr(strrchr($_SERVER['SCRIPT_NAME'], "/"), 1) == "empresa.php"){
	
	session_unset();
	return;
	
}

if (!$_SESSION['empresa']) {return;}

mysqli_select_db($link,$_SESSION['empresa']);
$link->query("set names 'utf8'");
	
///////////////////////////////////////////////
$result = $link->query("SELECT * FROM empresa");
if (!$result->num_rows) {
	$link->query("INSERT INTO empresa VALUES ('', '', '', '', '', '', '','', 0, '', '".date("Y")."','1','1','1','1','1','','','','')");
	$result = $link->query("SELECT * FROM empresa");
}
///////////////////////////////////////////////

$sql = "SELECT bloq FROM empresa";
$result = $link->query($sql);
$bloq = $result->fetch_array(MYSQLI_BOTH);

if ($bloq[0] AND !$renum) {
	$bloqueo = "<p /><br /><div class='centro rojo b' />La base de datos est&aacute; bloqueada para tareas de mantenimiento. Intentarlo en unos segundos.</div>";
}

$sql = "SELECT ultasi FROM empresa";
$result = $link->query($sql);
$fila = $result->fetch_array(MYSQLI_BOTH);

if (!$fila[0]) {
	$sql = "SELECT max(asiento) FROM asientos";
	$result = $link->query($sql);
	$fila1 = $result->fetch_array(MYSQLI_BOTH);
	$link->query("UPDATE empresa SET ultasi = '$fila1[0]'");
}

?>