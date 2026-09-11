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

<body
<?php
if ($_GET['accion'] == "anadir") {echo " onload='this.document.anadir.usuario.focus()'";}
if ($_GET['editar']) {echo " onload='this.document.editar.clave.focus()'";}
?>
>
<?php

include("arriba.php");
$menu6=3;include("menusizda.php");

if ($_SESSION['auto'] < 5) {echo "Usuario no autorizado";echo "</div></body></html>";exit;}

if ($_POST['accion'] AND $_POST['usuario'] AND $_POST['clave']) {anadir1($link);}
if ($_POST['editar'] AND $_POST['usuario'] AND $_POST['clave']) {editar1($link);}

echo "<div style='width:50%;float:left'>";
listausu($link);
echo "</div>";


echo "<div style='float:left;display:inline'>";
if ($_GET['accion'] == "anadir") {anadir();}
if ($_GET['editar']) {editar($link);}
echo "</div>";

include("pie.php");?></body></html>

<?php

//*****************************************************

function listausu($link) {

$result = $link->query("SELECT *, date_format(fecha, '%d/%m/%y %h:%i:%s') AS fechax FROM usuarios ORDER BY perm, usuario");

echo "<table class='basica hover'>"; echo "<th><a href=?accion=anadir>A&ntilde;adir</a></th><th>Usuario</th><th>Contrase&ntilde;a</th><th>&Uacute;ltimo acceso</th><th>Permiso</th>";

$permiso[5] = "Contable"; $permiso[4] = "Administrativo";

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	echo "<tr><td>";
	if (PRUEBA == 1) {
		// *** SERVER_PRUEBAS
		if ($fila[0] != "administrador" AND $fila[0] != "gestor") {
			echo "<a href=?editar=$fila[0]>Editar</a>";
		}
		// *** SERVER_PRUEBAS	} else {
			echo "<a href=?editar=$fila[0]>Editar</a>";
	}
	echo "</td><td>$fila[0]</td><td>**********</td><td>".$fila['fechax']."</td><td>".$permiso[$fila['perm']]."</td></tr>";

}

echo "</table>";

}


function anadir() {

	echo "<form name='anadir' method='post' action='usuarios.php'>";
	echo "<fieldset><legend>A&ntilde;adir usuario</legend><p />";
	echo "<label>Usuario</label><br /><input type='text' name='usuario' size='10' maxlength='10'><p />";
	echo "<label>Contrase&ntilde;a</label><br /><input type='text' name='clave' size='10' maxlength='10'><p />";
	echo "<label>Permisos</label><br />";
	echo "<select name='perm'><option value='4'>Administrativo<option value='5'>Contable</select><p /><br />";
	echo "<input type='submit' name='accion' value='A&ntilde;adir usuario'><p />";
	echo "</fieldset>";
	echo "</form>";

}

function anadir1($link) {

	extract($_POST);
	$sql = "INSERT INTO usuarios (usuario, clave, perm) VALUES ('$usuario', SHA1('$clave'), '$perm')";
	$link->query($sql);

}

function editar($link) {

	$result = $link->query("SELECT * FROM usuarios WHERE usuario = '".$_GET['editar']."'");
	$edit = $result->fetch_array(MYSQLI_BOTH);
	echo "<form name='editar' method='post' action='usuarios.php'>";
	echo "<fieldset><legend>Editar usuario</legend><p />";
	echo "<label>Usuario</label><br /><input type='text' name='usuario' size='10' maxlength='10' value='$edit[0]' readonly='readonly'><p />";
	echo "<label>Contrase&ntilde;a</label><br /><input type='text' name='clave' size='10' maxlength='10' value='**********'><p />";
	echo "<label>Permisos</label><br />";
	echo "<select name='perm'>";
	echo "<option value='4' "; if ($edit['perm'] == 4) {echo " selected";}
	echo ">Administrativo";
	echo "<option value='5' "; if ($edit['perm'] == 5) {echo " selected";}
	echo ">Contable";
	echo "</select><p /><br />";
	echo "<input type='submit' name='editar' value='Modificar usuario'><p />";
	echo "</fieldset>";
	echo "</form>";

}

function editar1($link) {

	$result = $link->query("SELECT perm FROM usuarios WHERE perm = 5");
	$contables = $result->num_rows;
	extract($_POST);
	if ($contables == 1 AND $perm < 5) {return;}
	$sql = "UPDATE usuarios SET perm = '$perm' WHERE usuario = '$usuario'";
	$link->query($sql);
	if ($clave != "**********") {
		$sql = "UPDATE usuarios SET clave = SHA1('$clave') WHERE usuario = '$usuario'";
		$link->query($sql);
	}

}

?>