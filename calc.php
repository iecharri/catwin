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

if ($_POST['guarcerr']) {
	$link->query("UPDATE usuarios SET calc = '".$_POST['listado']."' WHERE usuario = '".$_SESSION['usuario']."'");
}
$listado = $link->query("SELECT calc FROM usuarios WHERE usuario = '".$_SESSION['usuario']."'");
if ($listado) {
	$listado = $listado->fetch_array(MYSQLI_BOTH);
	$listado = $listado[0]."\n-----\n";
}

echo "<form name='calcu' method='post' style='display:inline'>";

echo "<input type='text' id = 'vent' name='vent' size='30' maxlength='30' onkeyup=\"calcula('',calcu,event)\">";

echo "<input type='hidden' name='valor1'>";
echo "<input type='hidden' name='valor2'>";
echo "<input type='hidden' name='operador'>";

echo "<br /><input type='button' value='&nbsp;C&nbsp;' class='cour' onclick=\"calcula('C',calcu,'')\"> ";
echo "<input type='button' value='&nbsp;/&nbsp;' class='cour' onclick=\"calcula('/',calcu,'')\"> ";
echo "<input type='button' value='&nbsp;*&nbsp;' class='cour' onclick=\"calcula('*',calcu,'')\"> ";
echo "<input type='button' value='&nbsp;-&nbsp;' class='cour' onclick=\"calcula('-',calcu,'')\">";

echo "<br />";
echo "<input type='button' value='&nbsp;7&nbsp;' class='cour' onclick=\"calcula('7',calcu,'')\"> ";
echo "<input type='button' value='&nbsp;8&nbsp;' class='cour' onclick=\"calcula('8',calcu,'')\"> ";
echo "<input type='button' value='&nbsp;9&nbsp;' class='cour' onclick=\"calcula('9',calcu,'')\"> ";
echo "<input type='button' value='&nbsp;+&nbsp;' class='cour' onclick=\"calcula('+',calcu,'')\">";

echo "<br />";
echo "<input type='button' value='&nbsp;4&nbsp;' class='cour' onclick=\"calcula('4',calcu,'')\"> ";
echo "<input type='button' value='&nbsp;5&nbsp;' class='cour' onclick=\"calcula('5',calcu,'')\"> ";
echo "<input type='button' value='&nbsp;6&nbsp;' class='cour' onclick=\"calcula('6',calcu,'')\"> ";
echo "<input type='button' value='&nbsp;%&nbsp;' class='cour' onclick=\"calcula('%',calcu,'')\">";

echo "<br />";
echo "<input type='button' value='&nbsp;1&nbsp;' class='cour' onclick=\"calcula('1',calcu,'')\"> ";
echo "<input type='button' value='&nbsp;2&nbsp;' class='cour' onclick=\"calcula('2',calcu,'')\"> ";
echo "<input type='button' value='&nbsp;3&nbsp;' class='cour' onclick=\"calcula('3',calcu,'')\"> ";
echo "<input type='button' value='&nbsp;=&nbsp;' class='cour' onclick=\"calcula('=',calcu,'')\">";

echo "<br />";
echo "<input type='button' value='&nbsp;0&nbsp;' class='cour' onclick=\"calcula('0',calcu,'')\"> ";
echo "<input type='button' value='&nbsp;.&nbsp;' class='cour' onclick=\"calcula('.',calcu,'')\"> ";
echo "<input type='submit' name='guarcerr' value='guardar y cerrar'>";

echo "<textarea id='listado' name='listado' rows='6' cols='30'>$listado</textarea>";

echo "<br />";

echo "</form>";

?>
