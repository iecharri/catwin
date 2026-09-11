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

include("config.php");

if (SSL) {
	//Comprueba si la conexions se hace por SSL si no fuera asi, redirecciona automaticamente para que lo sea!
	if ( !isset($_SERVER['HTTPS']) || strtolower($_SERVER['HTTPS']) != 'on' ) {
  	header("Location: " . "https://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]);
  	exit();
	}
}

//error_reporting(0);

session_start();

include("a_cookies.php");

extract($_GET);
extract($_POST);
extract($_SESSION);

include("conex.php");
include("funciones.php");

?>

<!-- <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-ES"> -->

<!DOCTYPE html>

<html lang="es">

<head>
<title>CatWin Net v. 0.8</title>

<meta charset="utf-8" />

<!-- <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> -->


<meta http-equiv="pragma" content="no-cache" />
<link rel="stylesheet" type="text/css" href="estilo0.css" media="screen" />
<link rel="stylesheet" type="text/css" href="estilo<?php if (!$c) {$c = 1;} echo $c;?>.css" media="screen" />
<!-- <link rel="stylesheet" type="text/css" href="DatePicker.css" media="screen" /> -->
<link rel="stylesheet" type="text/css" href="estiloimpr.css" media="print" />
<script language="Javascript" src="javascript.js" type='text/javascript'></script>
<link href="jquery/css/ui-lightness/jquery-ui-1.9.1.custom.min.css" rel="stylesheet">
<script src="jquery/js/jquery-1.8.2.min.js"></script>
<script src="jquery/js/jquery-ui-1.9.1.custom.min.js"></script>
<script language="javascript" src="jquery/js/jquery.form.js"></script> 
<!-- <script language="Javascript" src="DatePicker.js" type='text/javascript'></script> -->
<script language="Javascript" src="codigo.js" type='text/javascript'></script>
</head>