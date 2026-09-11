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

$result = $link->query("SELECT * FROM invent WHERE row_id = $row_id");

$fila = $result->fetch_array(MYSQLI_BOTH);

?>
<form name='form3' method='post'>

<input type = 'hidden' value = '<?php echo $xx; ?>' name='xx'>
<input type = 'hidden' value ='<?php echo $desde; ?>' name='desde'>
<input type = 'hidden' value ='<?php echo $fila['row_id']; ?>' name='row_id'>
<input type = 'hidden' value = '4' name = 'anadir'>
<input type = 'hidden' value = '<?php echo $fact; ?>' name = 'fact'>
<input type = 'hidden' value = '<?php echo $n_ped; ?>' name = 'n_ped'>
<input type = 'hidden' value = '<?php echo $codigo; ?>' name = 'codigo'>

<table class='basica 100' width='100%'>
<tr><th></th><th>Art&iacute;culo</th><th>Situaci&oacute;n</th><th>F. Pedido</th><th>F. Recepci&oacute;n</th><th>Coste &#8364;</th><th>Tipo</th>

</tr><tr>

<td>

<?php
echo "<a href=?xx=".str_replace(' ','%20',$xx)."&desde=$desde&row_id=$row_id&anadir=5&fact=$fact&codigo=$codigo&n_ped=$n_ped&dni=$dni";

if ($desde == "gcpedidos") {
	echo " onclick='return borrar_art_de_ped()'>Quitar</a>";
} else {
	echo " onclick='return borrar_art()'>Borrar</a>";
}
?>

</td>

<td>

<input type = 'text' value ='<?php echo $fila['artic']; ?>' size='10' maxlength='30' name='artic'>

</td><td>

<input type = 'text' value ='<?php echo $fila['situaci_n']; ?>' size='10' maxlength='10' name='situaci_n'>

</td><td>

<?php

if ($fila["fechap"] != "0000-00-00" and $fila['fechap'] != "") {
	$a=explode("-",$fila["fechap"]); 
	echo "<input type = 'text' value ='".$a[2]."/".$a[1]."/".substr($a[0],2,2)."' size='8' maxlength='8' name='fechap'>";
} else {
	echo "<input type = 'text' value = '' size='8' maxlength='8' name='fechap'>";
}
?>

</td><td>

<?php

if ($fila["fechar"] != "0000-00-00" and $fila['fechar'] != "") {
	$a=explode("-",$fila["fechar"]); 
	echo "<input type = 'text' value ='".$a[2]."/".$a[1]."/".substr($a[0],2,2)."' size='8' maxlength='8' name='fechar'>";
} else {
	echo "<input type = 'text' value = '' size='8' maxlength='8' name='fechar'>";
}

?>

</td><td>

<input type = 'text' value ='<?php echo $fila['p_coste']; ?>' size='10' maxlength='10' name='p_coste'>

</td><td>

<?php

echo "<select name='tipo'>";

$result = $link->query("SELECT row_id, tipo FROM tipos ORDER by tipo");
while ($row = $result->fetch_array(MYSQLI_BOTH)){
echo "<option value='".$row[0]."'";
if ($row[0] == $fila['tipo']) {
	echo " selected ";
}
echo ">".$row[1];
}

echo "</select>";

?>

</td></tr></table>

<p />

<input type = 'submit' value = "Confirmar cambios">

</form>