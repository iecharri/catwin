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

include("head.php");include("paginar.php");

if (!$link OR !$_SESSION['empresa']) {
	include("noempresa.php");
	exit;
}

include("jdatepicker.php");

?>

<body
<?php
if ($_GET['accion'] == "anadir") {echo " onload='this.document.anadir.fecha.focus()'";}
if ($_GET['editar']) {echo " onload='this.document.editar.fecha.focus()'";}
?>
>
<?php

include("arriba.php");
$menu6=1;include("menusizda.php");

if ($_POST['accion'] AND $_POST['asunto'] AND $_POST['nota']) {$mensaje = anadir1($link);}
if ($_POST['editar'] AND $_POST['asunto'] AND $_POST['nota']) {$mensaje = editar1($link,$_POST['id']);}

echo "<div style='width:60%;float:left'>";
listanotas($link);
echo "$mensaje</div>";


echo "<div style='float:left;display:inline'>";
if ($_GET['accion'] == "anadir") {anadir();}
if ($_GET['editar']) {editar($link,$_GET['editar']);}
echo "</div>";

include("pie.php");?></body></html>

<?php

//**********************************************************

function listanotas($link) {

	$ord = $_GET['ord'];
	if (!$ord) {$ord='fecha DESC';}
	$sql = "SELECT *, date_format(fecha, '%d/%m/%y') AS fechax FROM notas";

	$conta = $_GET['conta'];
	if (!$_GET['conta']) {
		$conta = 1;
	}
	$result = $link->query("SELECT id FROM notas");
	$numnot = $result->num_rows;
	pagina($numnot, $conta, 10, "Notas", $ord);
	$result = $link->query($sql." ORDER BY $ord LIMIT ".($conta-1).", 10");

	echo "<table class='basica hover'>"; echo "<th><a href='?ord=$ord&accion=anadir'>A&ntilde;adir</a></th><th><a href='?ord=usuario'>Usuario</a></th><th><a href='?ord=fecha DESC'>Fecha</a></th><th><a href='?ord=asunto'>Asunto</a></th><th>Nota</th>";

	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

		echo "<tr><td>";
		if ($_SESSION['usuario'] == $fila['usuario']) {
			echo "<a href='?ord=$ord&editar=$fila[0]'>Editar</a>";
		}
		if ($fila['fechax'] == '00/00/00') {$fila['fechax'] = "";}
		echo "</td><td>".$fila['usuario']."</td><td>".$fila['fechax']."</td><td>".$fila['asunto']."</td><td>".nl2br($fila['nota'])."</td></tr>";

	}

	echo "</table>";

}

function anadir() {

	echo "<form name='anadir' method='post' action='notas.php'>";
	echo "<fieldset><legend>A&ntilde;adir nota</legend><p />";
	echo "<label>Fecha</label><br /><input type='text' name='fecha' size='8' maxlength='8' class='datepicker'> ";
	//echo "<input type='button' name='selfecha' value='...' onclick=\"displayDatePicker('fecha','','dmy');\"><br />";
	echo "<span class='peq'>Dejar vac&iacute;o para que la nota se muestre siempre al conectar.</span><p />";
	echo "<label>Asunto</label><br /><input type='text' name='asunto' size='20' maxlength='20'><p />";
	echo "<label>Nota</label><br />";
	echo "<textarea name='nota' rows='10' cols='40'></textarea><p />";
	echo "<input type='submit' name='accion' value='A&ntilde;adir'><p />";
	echo "</fieldset>";
	echo "</form>";

}

function anadir1($link) {

	if (PRUEBA == 1) {
	// *** SERVER_PRUEBAS
	if ($_SESSION['empresa'] == "nuevocat") {
		return "<p /><span class='rojo b'>Opci&oacute;n no disponible en empresa Nuevocat</span>";
	}
	// *** SERVER_PRUEBAS
	}
	extract($_POST);
	$fecha = '20'.substr($fecha,6,2)."/".substr($fecha,3,2)."/".substr($fecha,0,2);
	$usuario = $_SESSION['usuario'];
	$sql = "INSERT INTO notas (fecha, usuario, asunto, nota) VALUES ('$fecha', '$usuario', '$asunto', '$nota')";
	$link->query($sql);
}

function editar($link,$id) {

	$result = $link->query("SELECT usuario, date_format(fecha, '%d/%m/%y') AS fechax, asunto, nota FROM notas WHERE id = '$id'");
	$edit = $result->fetch_array(MYSQLI_BOTH);
	echo "<form name='editar' method='post' action='notas.php'>";
	echo "<input type='hidden' name='id' value='$id'>";
	echo "<fieldset><legend>Editar nota</legend><p />";
	echo "<label>Fecha</label><br /><input type='text' name='fecha' size='8' maxlength='8' value=\"".$edit['fechax']."\"> ";
	echo "<input type='button' name='selfecha' value='...' onclick=\"displayDatePicker('fecha','','dmy');\"><br />";
	echo "<span class='peq'>Dejar vac&iacute;o para que la nota se muestre siempre al conectar.</span><p />";
	echo "<label>Asunto</label><br /><input type='text' name='asunto' size='20' maxlength='20' value=\"".$edit['asunto']."\"><p />";
	echo "<label>Nota</label><br /><textarea type='text' name='nota' rows='10' cols='40' value=\"".$edit['nota']."\">".$edit['nota']."</textarea><p />";
	echo "<span class='rojo b'>BORRAR</span> <input type='checkbox' name='borrar'> ";
	echo "<input type='submit' name='editar' value='Modificar'><p />";
	echo "</fieldset>";
	echo "</form>";

}

function editar1($link,$id) {

	if (PRUEBA == 1) {
	// *** SERVER_PRUEBAS
	if ($_SESSION['empresa'] == "nuevocat") {
		return "<p /><span class='rojo b'>Opci&oacute;n no disponible en empresa Nuevocat</span>";
	}
	// *** SERVER_PRUEBAS
	}
	extract($_POST);
	if ($borrar) {
		$link->query("DELETE FROM notas WHERE id = '$id'");
		return;
	}
	$fecha = '20'.substr($fecha,6,2)."/".substr($fecha,3,2)."/".substr($fecha,0,2);
	$usuario = $_SESSION['usuario'];
	$sql = "UPDATE notas SET fecha = '$fecha', usuario = '$usuario', asunto = '$asunto', nota = '$nota' WHERE id = '$id'";
	$link->query($sql);

}