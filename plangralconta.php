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

$array = array();
$array[] = "grupplan.sql";
$array[] = "subgplan.sql";
$array[] = "cuenplan.sql";
$array[] = "subcplan.sql";


for ($i=0;$i<4;$i++) {
	creartb($array[$i],$link);
}

function creartb($fich,$link) {

$f = fopen( $fich, 'r' );
$sql = "";

while (!feof($f)) {
    $buffer = fgets($f, 4096);
	$buffer = trim($buffer);
	if ( substr($buffer,0,2)=="--" OR $buffer=="" OR strpos ($buffer, "#") === 0) { 
		continue;
	}
	$sql .= $buffer;
	if (preg_match("/;$/",$buffer)) {
		$link->query($sql);
		$sql = "";
	}
}

fclose ($f);

}

$array = "";

?>