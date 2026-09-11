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

$renum = 1;
include("head.php");

if (!$link OR !$_SESSION['empresa']) {
	include("noempresa.php");
	exit;
}

?>

<body>

<?php

include("arriba.php");
$menu13=5;include("menusizda.php");
$result = $link->query("SELECT COUNT(asiento) FROM asientos");
$num = $result->fetch_array(MYSQLI_BOTH);

?>

Atenci&oacute;n, se renumerar&aacute;n los asientos del 1 al <?php echo $num[0];?>. 

<?php 
if (!$_GET['accion']) {
	echo "<form class='centro' name='temp' method='post' action = 'renumerar.php?accion=1'>";
	echo "<div id='confirma'>";
	echo "<input type='submit' value=' >> Continuar >> ' onclick=\"show('esperar');hide('confirma')\">";
	echo "</div>";
	echo "<div id='esperar' class='rojo b centro' style='display:none'>Esperar...</div>";
	echo "</form>";
}

?>

<p />

<?php

if ($_GET['accion'] == 1) {

	$sql = "UPDATE empresa SET bloq = 1 WHERE 1";
	$link->query($sql);

	$link->query("ALTER TABLE asientos ADD asiento_temp INT(11) NOT NULL AFTER asiento");
	$link->query("ALTER TABLE apuntes ADD asiento_temp INT(11) NOT NULL AFTER asiento");
	$link->query("ALTER TABLE factrec ADD asiento_temp INT(11) NOT NULL AFTER asiento");
	$link->query("ALTER TABLE factemi ADD asiento_temp INT(11) NOT NULL AFTER asiento");

	$n = 1;
	$sql = "SELECT asiento FROM asientos ORDER BY fecha ASC, asiento ASC";
	$result = $link->query($sql);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$asiviejo = $fila['asiento'];
		echo $n." ";
		$link->query("UPDATE asientos SET asiento_temp = '$n' WHERE asiento = '$asiviejo'");
		$link->query("UPDATE apuntes SET asiento_temp = '$n' WHERE asiento = '$asiviejo'");
		$link->query("UPDATE factrec SET asiento_temp = '$n' WHERE asiento = '$asiviejo'");
		$link->query("UPDATE factemi SET asiento_temp = '$n' WHERE asiento = '$asiviejo'");
		$n++;
	}

	$link->query("ALTER TABLE asientos DROP asiento") or die ("Error1"); 
	$link->query("ALTER TABLE asientos CHANGE asiento_temp asiento INT(11) NOT NULL") or die ("Error2");
	$link->query("ALTER TABLE asientos ADD UNIQUE (asiento)") or die ("Error3");

	$link->query("ALTER TABLE apuntes DROP asiento") or die ("Error4"); 
	$link->query("ALTER TABLE apuntes CHANGE asiento_temp asiento INT(11) NOT NULL") or die ("Error5");

	$link->query("ALTER TABLE factrec DROP asiento") or die ("Error6"); 
	$link->query("ALTER TABLE factrec CHANGE asiento_temp asiento INT(11) NOT NULL") or die ("Error7");

	$link->query("ALTER TABLE factemi DROP asiento") or die ("Error8"); 
	$link->query("ALTER TABLE factemi CHANGE asiento_temp asiento INT(11) NOT NULL") or die ("Error9");

	$link->query("UPDATE empresa SET ultasi = '' WHERE 1");

	$sql = "UPDATE empresa SET bloq = 0 WHERE 1";
	$link->query($sql);

}

include("pie.php");

?></body></html>

