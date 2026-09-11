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

<body<?php if(!$bloqueo) {echo " onload=\"foco('cuenta')\"";}?>>

<?php
include("arriba.php");
$menu12=9;include("menusizda.php");

echo "<form method='post' name='form1' onsubmit='return borrar_cuenta(form1)'>\n";
echo "<p /><span class='b'>Subgrupo / Cuenta / Subcuenta :</span> <input type='text' name='cuenta' size='8' maxlength='8'>\n";
echo "<input type='submit' value='Borrar' name='Borrar'>\n";
echo "</p>\n";
echo "</form>\n";

if (strlen($cuenta) == 2) {
	$rs = $link->query("SELECT * FROM subgrupo WHERE subgrupo = $cuenta");
	if ($rs->num_rows > 0) {
		$tempo = "SELECT * FROM cuentas WHERE cuenta LIKE '".$cuenta."%'";
		$rs = $link->query($tempo);
		if ($rs->num_rows > 0) {
			echo "<p /><br /><p />El subgrupo <span class='b'>$cuenta</span> no puede ser borrado porque existen cuentas pertenecientes a ese Subgrupo.";
		} else {
			$link->query("DELETE FROM subgrupo WHERE subgrupo = $cuenta");
			echo "<p /><br /><p />El subgrupo <span class='b'>$cuenta</span> ha sido borrado.";
		}
	} else {
		echo "<p /><br /><p />El subgrupo <span class='b'>$cuenta</span> no existe.";
	}
}

if (strlen($cuenta) == 3) {
	$rs = $link->query("SELECT * FROM cuentas WHERE cuenta = $cuenta");
	if ($rs->num_rows > 0) {
		$tempo = "SELECT * FROM subcuent WHERE cuenta LIKE '".$cuenta."%'";
		$rs = $link->query($tempo);
		if ($rs->num_rows > 0) {
			echo "<p /><br /><p />La cuenta <span class='b'>$cuenta</span> no puede ser borrada porque existen Subcuentas pertenecientes a esa Cuenta.";
		} else {
			$link->query("DELETE FROM cuentas WHERE cuenta = $cuenta");
			echo "<p /><br /><p />La cuenta <span class='b'>$cuenta</span> ha sido borrada.";
		}
	} else {
		echo "<p /><br /><p />La cuenta <span class='b'>$cuenta</span> no existe.";
	}
}

if (strlen($cuenta) == 8) {

	include ('sumsubcuent.php');

	$rs = $link->query("SELECT * FROM subcuent WHERE cuenta = $cuenta");

	if ($rs->num_rows > 0)

	{

		$fila = $rs->fetch_array(MYSQLI_BOTH);

		if ( $fila['saldod'] != 0 || $fila['saldoa'] != 0 )

		{
			echo "<p /><br /><p />La Subcuenta <span class='b'>$cuenta</span> no puede ser borrada porque su saldo es distinto de cero.";

		} else {

			$link->query("DELETE FROM subcuent WHERE cuenta = $cuenta");
			echo "<p /><br /><p />Subcuenta <span class='b'> $cuenta </span>borrada.";
		}

	} else {
	
		echo "<p /><br /><p />La Subcuenta <span class='b'>$cuenta</span> no existe.";

	}

}

?>

<?php $top = 1; include("pie.php");?></body></html>
