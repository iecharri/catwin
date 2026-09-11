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

<body <?php if (!$bloqueo  AND $xx == 'Listados1') {echo "onload='this.document.form1.titulo.focus()'";}?>>

<?php
include("arriba.php");
$menu13=3;include("menusizda.php");

if ($xx == 'Listados1') {
	include ("listados1.php");
	echo "</div>";
	$pie = 1; include("pie.php");
	echo "</body></html>";
	exit;
}

?>

<p />

<p /><a href='?xx=Listados1'>Otros Listados</a><p />Listados existentes:<br />


<?php

$empresa = $_SESSION['empresa'];
$dir = PATH.$empresa;
if (!is_dir($dir)) {mkdir($dir);}

$handle=opendir($dir."/.");

while ($file = readdir($handle))
	{
	if(strpos($file, ".html") > 0) {
		echo "<br /><a href='/catwin/".$_SESSION['empresa']."/$file' target='_blank'\">$file</a>";
	}
	}
	closedir($handle);

$pie = 1; include("pie.php");?></body></html>

