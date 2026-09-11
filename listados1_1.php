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

if (!$link OR !$_SESSION['empresa']) {
	return;
}

?>

<form name='form1' method='post'>

<?php

if (!$titulo) {$titulo = "T&iacute;tulo";}
if (!$subtit1) {$subtit1 = "Listado de recibos";}
if (!$subtit2) {$subtit2 = "Vencimiento: ";}
if (!$cab1) {$cab1 = "Emisor: ";}
if (!$cab2) {$cab2 = "";}
if (!$cab3) {$cab3 = "Oficina: ";}
if (!$cab4) {$cab4 = "Tipo: ";}

echo "<table class='entradadatos'>";
echo "<tr><td colspan='4' align='center'><input type='text' name='titulo' size='100' maxlength='100' value='$titulo'></td></tr>";
echo "<tr><td colspan='2' width='50%'><input type='text' name='subtit1' size='50' maxlength='50' value='$subtit1'></td><td colspan='2' width='50%' align='right'><input type='text' name='subtit2' size='50' maxlength='50' value='$subtit2'></td></tr>";
echo "<tr><td width='25%'><input type='text' name='cab1' size='25' maxlength='25' value='$cab1'></td><td width='25%'><input type='text' name='cab2' size='50' maxlength='50' value='$cab2'></td><td width='25%'><input type='text' name='cab3' size='25' maxlength='25' value='$cab3'></td><td width='15%'><input type='text' name='cab4' size='15' maxlength='15' value='$cab4'></td></tr>";
echo "</table>";
?>

<p>
<table class='basica'>

<tr>
<th>Cuenta</th><th>Descripci&oacute;n</th><th>Cantidad</th></tr>

<?php

$n=0;

$rs=$link->query("SELECT cuenta, descripci_, saldod, saldoa, ctacte, telefono, telefono2 FROM subcuent ORDER BY cuenta");

$suma = 0;

while($row=$rs->fetch_array(MYSQLI_BOTH)) {

	echo "<tr>";

	echo "<td class='anchomin'>";

	if ($row['saldod'] != 0 || $row['saldoa'] != 0 )
	{
		echo "<a href='extractoctas.php?cuenta=".$row['cuenta']."'>";
	}

	echo $row['cuenta'];

	if ($row['saldod'] != 0 || $row['saldoa'] != 0 )
	{
		echo "</a>";
	}
				
	echo "</td><td class='wid99'>".$row['descripci_']."</td>";

	$temp = "cant".$n;
	echo "<td align='right'><input type='text' name='cant$n' value=".$$temp."></td></tr>";

	$suma = $suma + $$temp;

	$n++;

}

echo "<tr><td colspan='2' align='right'>SUMA</td><td align='right'><input type='text' name='suma' value='$suma'></td></tr>";

?>

</table>

<table class='entradadatos'><tr><td class='b'>Pie:<br /><textarea name='pie' rows='10' cols='60'><?php echo $pie;?></textarea></td></tr>

<?php
echo "<tr><td align='center'><input type='submit' name='validar' value='VALIDAR'></td></tr></table>";
?>

</form>

<?php

if ($_POST['validar']) {

	$titulo = nl2br($titulo);
	$subtit1 = nl2br($subtit1);
	$subtit2 = nl2br($subtit2);
	$cab1 = nl2br($cab1);
	$cab2 = nl2br($cab2);
	$cab3 = nl2br($cab3);
	$cab4 = nl2br($cab4);

	$empresa = $_SESSION['empresa'];
	$dir = PATH.$empresa."/";
	if (!is_dir($dir)) {mkdir($dir);}

	$fich = "doc".date("YmdHms").".html";

	if ($_POST['validar']) {
		echo "<a href='/catwin/".$_SESSION['empresa']."/$fich' target='_blank'>VER FICHERO CREADO</a>";
	}

	$f = fopen($dir.$fich, 'w+');

	fwrite($f, "<html><head><meta http-equiv='content-type' content='text/html; charset=UTF-8' /><title></title></head><body style='font-family: Tahoma, Verdana, Arial; font-size: 14;margin-left: 1in;margin-right: 1in; margin-top: 0.00in'>");

	fwrite($f,"<center><b>".$titulo."</b></center><p>");
	fwrite($f, "<table width='100%'><tr><td width='50%'>".$subtit1."</td><td width='50%' align='right'>".$subtit2."</td></tr></table>");
	fwrite($f, "<p><table width='100%'><tr><td width='25%'>".$cab1."</td><td width='40%' align='center'>".$cab2."</td><td width='20%' align='center'>".$cab3."</td><td width='15%' align='right'>".$cab4."</td></tr></table>");

	$n=0;

	$rs=$link->query("SELECT cuenta, descripci_, saldod, saldoa, ctacte, telefono, telefono2 FROM subcuent ORDER BY cuenta");

	$suma = 0;

	fwrite($f,"<p><table align=center width=100% style='font-family: Tahoma, Verdana, Arial; font-size: 14;'><tr><th align='right'>Ref.</th><th align=left>Nombre</th><th align='left'>Cta. Corriente</th><th align='right'>Importe</th></tr>");

	while($row=$rs->fetch_array(MYSQLI_BOTH)) {

		$temp = "cant".$n;

		if ($$temp) {
			if ($color == "#FDFDE5") {$color = "#ffffff";} else {$color="#FDFDE5";}
			fwrite($f,"<tr bgcolor='$color'><td align='right'>&nbsp;".number_format($n,0,',','.')."</td><td align='left'>&nbsp;".$row['descripci_']."</td>");
			fwrite($f,"</td><td>".$row['ctacte']."</td>");
			fwrite($f,"<td align='right'>".number_format($$temp,2,',','.')." </td></tr>");
			$suma = $suma + $$temp;
		}

		$n++;

	}

	fwrite($f,"<tr><td></td><td colspan=2><B>Total Cargos</B></td><td align='right'><b>".number_format($suma,2,',','.')." </b></td></tr></table>");

	fwrite($f,"<p><center>".nl2br($pie)."</center>");

	fwrite($f, "</body></html>");

	fclose($f);

}

?>

