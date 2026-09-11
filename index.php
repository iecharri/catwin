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

?>

<body <?php if(!$_SESSION['empresa']) {
	echo "onload=\"foco('empresa1')\"";
	}?>>
	
<?php

include ("arriba.php");
include("menusizda.php");

if (!$_SESSION['empresa'] OR $x) {

	include ("info.php");

} else {

	echo "<p /><br />Bienvenido a catwin usuario <span class='b'>".$_SESSION['usuario']."</span>.<p />Usa el men&uacute; de la izquierda para acceder a las diferentes opciones del programa.";

	$result = $link->query("SELECT usuario, asunto, nota FROM notas WHERE fecha = '".date('Y-m-d')."' OR fecha = '00/00/00' ORDER BY fecha DESC");
	if ($result->num_rows > 0) {
		echo "<p /><span class='verde b'><a href='notas.php'>Notas</a> del d&iacute;a:</span><table class='basica wid83'><th>De</th><th>Asunto</th><th>Nota</th></tr>";
		while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
			echo "<tr><td>".$fila['usuario']."</td><td>".$fila['asunto']."</td><td>".nl2br($fila['nota'])."</td></tr>";
		}
		echo "</table>";
	}

}

?>

</div>

<?php if($_SESSION['empresa']) {include("pie.php");};?>

</body></html>
