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

function solapah($menus, $num, $id) {
echo "<ul id='$id'>";
$n = 1;
foreach ($menus as $elem) {
	if ($elem) {
		if ($num == $n) {$tipo = "id='active'";} else {$tipo = '';}
		echo "<li ".$tipo.">".$elem."</li>";
	}
	$n++;
}
echo "</ul>";
}



function solapav($menus, $num, $id, $tit, $mas, $n) {

if ($mas == 1) {$m=2;$img="menos";$alt="Reducir";} else {$m=1;$img="mas";$alt="Ampliar";}

if ($mas == 1) {
	echo "<div class='redond1'>";
} else {
	echo "<div class='redond2'>";
}
echo "<b class='rtop'><b class='r1'></b><b class='r2'></b><b class='r3'></b><b class='r4'></b></b>";

echo "<div class='tit'>";
if ($_SESSION['empresa']) {
	echo "<a href='?men$n=$m' title=\"$alt\"><img src='$img.png' alt='' /> $tit</a>";
} else {
	echo $tit;
}
echo "</div>";

if ($mas == 1 AND $menus) {
	$n = 1;
	echo "<ul class='navv'>";
	foreach ($menus as $elem) {
		if ($elem) {
			if ($num == $n) {$tipo = " id='active'";} else {$tipo = '';}
			echo "<li".$tipo.">".$elem."</li>";
		}
		$n++;
	}
	echo "</ul>";
}
if ($mas == 1 AND $menus) {
	echo "<b class='rbottom'><b class='r4'></b><b class='r3'></b><b class='r2'></b><b class='r1'></b></b>";
} else {
	echo "<b class='rbottom1'><b class='r4'></b><b class='r3'></b><b class='r2'></b><b class='r1'></b></b>";
}
echo "</div>";

}

?>