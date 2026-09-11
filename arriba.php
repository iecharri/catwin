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

if ($_POST['moneda']) {
	$b = explode("|",$_POST['moneda']);
	$_SESSION['moneda'] = $b[0];
	$_SESSION['deci'] = $b[1];
}
if (!$_SESSION['moneda']) {
	$_SESSION['moneda'] = 1;
	$_SESSION['deci'] = 2;
}

include("existesubcuenta.php");
include("jdialog.php");

?>

<a name='inicio'></a>

<div id='arriba' class='transp'>

<a href='index.php' style='float:left;padding:0 3em 0 1em'><img src='gato1.png' alt='' /></a>

<div style='float:left;display:inline;padding-left:10px;padding-top:3px'>

<?php

if (!$_SESSION['empresa']) {

	echo "<form name='form0' method='post' action='index.php' class='inline'>";
	// Se muestra un desplegable con las empresas creadas
	if($_GET['v'] == 1) {
		echo "Empresa (<a href='?v=0' >Introducir</a>) <select style='width:117px;' name='empresa1' maxlength='20'>";
		if ($link) { //Comprobando la conexion con la BDD
		//subcuent
			$linktemp = @new mysqli(SERVER,USER,PASSWORD); //Conexion temporal con el servidor mysql usando los datos del config.php
			$resulttemp = $linktemp->query('SHOW DATABASES'); //Muestra las BASE DE DATOS que tiene el servidor mysql
			while ($row = $resulttemp->fetch_array(MYSQLI_BOTH)){ //Recorrerido de todas las BDD del servidor mysql
				mysqli_select_db($linktemp,$row[0]); // Selecionamos para usar la BDD actual
				$linktemp->query("set names 'utf8'");
				$subresulttemp = $linktemp->query('SHOW TABLES LIKE "subcuent"'); //Se comprueba si existe la TABLA "subcuent"
				if ($subresulttemp->fetch_array(MYSQLI_BOTH)) { //Solo es cierto si a devuelto datos, eso quiere decir que existe!
					echo "<option value='".$row[0]."'>".$row[0]."</option>"; //Creando las opciones del select
				}
			}
		}
		echo "</select> Usuario <input type='text' name='usuario1' size='15' maxlength='15' /> Clave <input type='password' name='password1' size='15' maxlength='15' /> <input type='submit' value='Conectar' />\n";

	}
	// Se muestra un textbox para escribir manualmente
	else {
		echo "Empresa (<a href='?v=1' >Seleccionar</a>) <input type='text' name='empresa1' value='' size='20' maxlength='20' /> Usuario <input type='text' name='usuario1' size='15' maxlength='15' /> Clave <input type='password' name='password1' size='15' maxlength='15' /> <input type='submit' value='Conectar' />\n";
	}
	if (PRUEBA == 1) {
	// *** SERVER_PRUEBAS	echo "<br /><span style='font-size:.8em'>Puedes <a href='empresa.php' class='b'>Crear una Empresa</a>";
	echo " o usar la de pruebas <a href='";
	if (substr(strrchr($_SERVER['SCRIPT_NAME'], "/"), 1) == "empresa.php") {echo "index.php";}
	echo "?emp=1' class='b'>Nuevocat</a>.";
	echo "</span>";
	// *** SERVER_PRUEBAS
	}	echo "</form>";

} else {

	if ($_SESSION['usuario']) {
		echo "<form name='form0' method='post' action='index.php' style='display:inline'>";
		echo "Empresa <input type='text' name='empresa1' size='20' maxlength='20' readonly='readonly' value='".$_SESSION['empresa']."' /> ";
		echo "Usuario <input type='text' name='usuario1' size='15' maxlength='15'  readonly='readonly' value='".$_SESSION['usuario']."' /> ";
		echo "<input type='submit' name='desco' value='Desconectar' /></form>";
		echo "&nbsp;&nbsp;<a href='equiv.php'>Ver en</a> ";
		include("moneda.php");
		//echo "<div class='dialog1' title='Calculadora'>";
		//include("calc.php");
		//echo "</div>";
		echo "&nbsp;<a href='javascript:void(0)' id='dialog-link' >Calculadora</a>";
		echo "<br /><span style='font-size:.8em'>(Recuerda pulsar en <span class='b'>DESCONECTAR</span> al finalizar.)</span>\n";
	}
}

?>

</div>

<div style='position:absolute;bottom:0px;right:3px;font-size:0.8em'>
<?php
echo "<a href='empresa.php'>Crear Empresa</a> | <a href='index.php?x=1'>Acerca de CatWin Net</a> | ";
echo "<a href='http://downloads.sourceforge.net/catwin/' target='_blank'>Download</a> | ";
echo date("d-m-Y H:i", time())." CatWin Net v. 0.8 | ";include("colores.php");

?>
</div>


</div>

<div id="linea"></div>

<?php

if (LOG) {
	include ("log.php");
}

?>
