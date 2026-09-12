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

$result = $link->query("SELECT actualizaciones FROM empresa");
$fila = $result->fetch_array(MYSQLI_BOTH);

if (($ejecutar AND $ejecutar="totalbalces") OR $fila[0]) {
	include ('sumsubcuent.php');
}

?>

<body>

<?php
include("arriba.php");
$menu13=7;include("menusizda.php");

?>

<div class='noimpri'>
<div class='centro'><a href='listados.php?ejecutar=totalbalces'>Actualizar Totales</a></div>
<ol>
<li><a href='?lis=sumysal'>Balance de Sumas y Saldos</a></li>
<li><span class='rojo b'>EN CONSTRUCCI&Oacute;N</span> <a href='?lis=perdidas'>P&eacute;rdidas</a> y <a href='?lis=ganancias'>Ganancias</a></li>
<li><span class='rojo b'>EN CONSTRUCCI&Oacute;N</span> Balance de Situaci&oacute;n (Activo y Pasivo).</li>
<li><span class='rojo b'>EN CONSTRUCCI&Oacute;N</span> Memoria.</li>
<li><span class='rojo b'>EN CONSTRUCCI&Oacute;N</span> Balance de Situaci&oacute;n Din&aacute;mico, sin regularizaci&oacute;n (<a href='?lis=activo'>Activo</a> y <a href='?lis=pasivo'>Pasivo</a>)</li>
</ol>
<?php if ($_GET['lis']) {echo "<div class='rojo b centro'><a href='javascript:print()'>IMPRIMIR</a></div>";}?>
</div>

<?php

if ($_GET['lis'] == 'sumysal')   {include "sumysal.php";}
if ($_GET['lis'] == 'perdidas')  {include "perdidas.php";}
if ($_GET['lis'] == 'ganancias') {include "ganancias.php";}
if ($_GET['lis'] == 'activo')    {include "activo.php";}
if ($_GET['lis'] == 'pasivo')    {include "pasivo.php";}

$top = 1; include("pie.php");?></body></html>

