<?php

//Copyright (C) 2000-2015  Antonio Grandio Botella http://www.antoniograndio.com
//Copyright (C) 2000-2015  Inmaculada Echarri inma.echarri@gmail.com

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

if ($n_ == 0) {

	echo "<p /><br /><p />El Nº de Factura tiene que ser mayor que cero.";
	exit;

}

$res = $link->query("SELECT n_ FROM factemi WHERE n_ = $n_");
if ($res->num_rows > 0) {
	echo "<p />Factura ya creada";
	exit;
}

$res = $link->query("SELECT n_ FROM pedidos WHERE n_ = $n_");
if ($res->num_rows == 0) {
	echo "<p />No ha sido asignado ese nº de Factura a ning&uacute;n Pedido.";
	exit;
}

$result = $link->query("SELECT clientes.dni, clientes.cliente, clientes.domicilio, clientes.codpost, clientes.ciudad, pedidos.dni, pedidos.totpedido, clientes.codigo FROM pedidos LEFT JOIN clientes ON pedidos.client = clientes.codigo WHERE pedidos.n_ = $n_");

$row1 = $result->fetch_array(MYSQLI_BOTH);

echo "<form name='form2' method='post' action ='??xx=Facturas%20Emitidas&facturar=si&n_=".$n_."&fecha=".$fecha."' onsubmit='return gcaltafactemi2(form2)'>"; //&tot=".$fil[0]."

echo "<p />Cliente: <input type='text' readonly='readonly' value='".$row1[0]."'> <input type='text' readonly='readonly' value='$row1[1]'>\n";

echo "<p />Domicilio: <input type='text' readonly='readonly' value='$row1[2]'>\n";

echo "<br />Ciudad: <input type='text' readonly='readonly' value='$row1[3]'> <input type='text' readonly='readonly' value='$row1[4]'>\n";

$res = $link->query("SELECT SUM(totpedido) AS sum1 FROM pedidos WHERE pedidos.n_ = '$n_'");
$sum = $res->fetch_array(MYSQLI_BOTH);

if ($facturar and $facturar='si') {
		$facturar = 'no';
		$a=explode("/",$fecha); 
		$b="20".$a[2]."-".$a[1]."-".$a[0];
		$link->query("INSERT INTO factemi (fecha, n_, total, dni, cliente, tipivar1, benefbrut) VALUES ('$b', '$n_', '$sum[0]', '$row1[0]', '$row1[7]', '".$_POST['tipoiva']."', '".$_POST['baseimp']."')") or die ("No se ha podido crear la Factura");
}

?>

<p />
<label>Total Factura</label> 
<input type='text' name='totfac' size='9' value='<?php echo $sum[0];?>'> &#8364; 

<label>Tipo IVA</label>  
<select name='tipoiva' onchange="gcaltafactemi1(form2)" onfocus="gcaltafactemi1(form2)">

<option value='1.18'
<?php if ($_POST['tipoiva'] == 1.18) {echo " selected='selected'";}?>
>0,18
<option value='1.16'
<?php if ($_POST['tipoiva'] == 1.16) {echo " selected='selected'";}?>
>0,16
<option value='1.08'
<?php if ($_POST['tipoiva'] == 1.08) {echo " selected='selected'";}?>
>0,08
<option value='1.07'
<?php if ($_POST['tipoiva'] == 1.07) {echo " selected='selected'";}?>
>0,07
<option value='1.05'
<?php if ($_POST['tipoiva'] == 1.05) {echo " selected='selected'";}?>
>0,04
<option value='1.04'
<?php if ($_POST['tipoiva'] == 1.04) {echo " selected='selected'";}?>
>0,04
<option value='1.02'
<?php if ($_POST['tipoiva'] == 1.02) {echo " selected='selected'";}?>
>0,04
<option value='1'
<?php if ($_POST['tipoiva'] == 1) {echo " selected='selected'";}?>
>0

<?php optioniva($link,$_POST['tipoiva']);?>

</select>

<label>Base Imp.</label> <input type='text' name='baseimp' size='9' value='<?php echo $_POST['baseimp'];?>'> &#8364; 

<label>Cuota IVA</label> <input type='text' name='cuotaiva' size='9' readonly='readonly' value='<?php echo$_POST['cuotaiva'];?>'>&#8364;

<input type='submit' value='FACTURAR' onclick='return gcaltafactemi2(form2)'> 

<p />

</form>

<p />

<?php

$ped = 0;

$result = $link->query("SELECT pedidos.n_ped, pedidos.n_, pedidos.totpedido, invent.artic, invent.p_coste FROM pedidos LEFT JOIN invent ON pedidos.n_ped = invent.n_ped WHERE pedidos.n_ = '$n_' ORDER BY n_ped");

while ($row = $result->fetch_array(MYSQLI_BOTH)) :

	if ($ped == 0) {

		echo "<table class='basica 100' width='100%'><th>Art&iacute;culo</th><th>Precio</th><th>Nº Factura</th><th>Facturado</th></tr>\n";
	}

	if ($row['n_ped'] != $ped) {
		if ($ped != 0) {
			echo "<tr><td class='blanco dcha b'>SUMA: </td><td class='blanco dcha b'>".number_format($tot,2,',','.')."</td><td class='blanco' colspan='2'>&nbsp;</td></tr>\n";
		} 
		echo "<tr><td class='verde' colspan='4'>&nbsp</td></tr>\n";
		echo "<tr><td class='blanco' colspan='2'><span style='font-size:1.3em;font-weight:bold'>Pedido nº: <a href='?xx=Pedidos&n_ped=".$row['n_ped']."'>".$row['n_ped']."</a></span></td>\n";

		echo "<td class='dcha'>".$row['n_']."</td>\n";

		$a = $row['n_'];
		$res = $link->query("SELECT n_ FROM factemi WHERE n_ = '$a'");
		if ($res->num_rows > 0) {
			echo "<td style='text-align:center'>SI";
		} else {
			echo "<td style='text-align:center'>NO";
		}
		echo "</td></tr>\n";

		$tot = $row['totpedido'];

	}
	echo "<tr><td>".$row['artic']."</td><td class='dcha'>".number_format($row['p_coste'],2,',','.')."</td><td>&nbsp;</td><td>&nbsp;</td>\n";

	$ped = $row['n_ped'];

endwhile;

if ($ped != 0) {
	echo "<tr><td class='blanco dcha b'>SUMA: </td><td class='dcha b'>".number_format($tot,2,',','.')."</td><td class='blanco' colspan='2'>&nbsp;</td></tr>\n";
	echo "<tr><td colspan='4' class='verde'>&nbsp</td></tr>\n";
	echo "<tr><td class='blanco dcha b' colspan='2'>TOTAL: ";

	$res = $link->query("SELECT SUM(totpedido) AS tot FROM pedidos WHERE n_ = '$n_'");
	$row=$res->fetch_array(MYSQLI_BOTH);
	echo number_format($row[0],2,',','.')."</td><td class='blanco' colspan='2'>&nbsp;</td></tr></table>";
} else {
	echo "<p />Factura no existe.";
}

function optioniva($link,$tipoiva) {
	$sql = "SELECT * FROM iva ORDER BY n";
	$result = $link->query($sql);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		echo "<option value='".($fila[1] + 1)."'";
		if ($tipoiva == ($fila[1] + 1)) {echo " selected='selected'";}
		echo ">$fila[1]</option>";
	}	
}

