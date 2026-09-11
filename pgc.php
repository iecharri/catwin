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

<body>

<?php

include ("arriba.php");
$menu13=4;include("menusizda.php");

?>

<span class='verdeb'>Desde esta opci&oacute;n se puede a&ntilde;adir a la empresa las cuentas del Plan General de Contabilidad.</span><p />
Grupos&nbsp;
<a href='pgc2.php'>Subgrupos</a>&nbsp;
<a href='pgc3.php'>Cuentas</a>&nbsp;
<a href='pgc6.php'>Subcuentas</a><p />

<?php

$result = $link->query("SELECT * FROM grupplan");

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	echo "<a href=pgc2.php?gr=".$fila[0].">".$fila[0]." ".$fila[1]."</a> ";
	if ($fila['descripgp']) {
		echo " [ <a href=?".$filtro."descr=".$fila[0]."#$fila[0]>Descripci&oacute;n</a> ]";
	}
	if ($descr == $fila[0]) {
		echo "<p /><div class='bi'>".nl2br($fila[2])."</div>";
	}
	echo "<hr>";

}

?>

<?php $top = 1; include("pie.php");?></body></html>
