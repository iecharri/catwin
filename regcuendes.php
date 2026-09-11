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
include("arriba.php");
$menu13=5;include("menusizda.php");

if ($_SESSION['auto'] < 5) {echo "Usuario no autorizado";echo "</div></body></html>";exit;}

?>Deshacer Regularizaci&oacute;n Ejercicio<p /><?php

include ('sumsubcuent.php');

if ($_POST['borrar']) {

	$result = $link->query("SELECT * FROM asientos WHERE tipo = 'Regularizaci&oacute;n' ORDER BY asiento");
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$asiento = $fila['asiento'];
		$link->query("DELETE FROM apuntes WHERE asiento = '$asiento'") or die ("El usuario $usuario no tiene permisos para borrar Apuntes");
		$link->query("DELETE FROM asientos WHERE asiento = '$asiento'") or die ("El usuario $usuario no tiene permisos para borrar Asientos");
		echo "Borrado Asiento $asiento.<br />";
	}
	echo "</div></body></html>";
	include ('sumsubcuent.php');
	exit;

}

$result = $link->query("SELECT * FROM asientos WHERE tipo = 'Regularizaci&oacute;n' ORDER BY asiento");

if ($result->num_rows == 0) {
	echo "El Ejercicio no estaba regularizado.<p /><a href='regcuen.php'>Regularizaci&oacute;n Ejercicio</a>.";
	echo "</div></body></html>";exit;
}

echo "Se van a borrar los siguientes Asientos <form name=regcuen method=post style='display:inline' onsubmit=\"return confirm('Confirmar borrado')\"><input type='submit' name='borrar' value=' Borrar '><br />";

echo "<table class='basica 100' width='100%'>";

cabasi("","");

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	asiento($link, $fila['asiento'], "", $_SESSION['moneda'],$_SESSION['deci'],$_GET['bojust']);
}

echo "</table>";

?>

</div>

<?php $top = 0; include("pie.php");?>

</body></html>
