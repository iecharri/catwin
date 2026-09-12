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
$menu51=6;include("menusizda.php");

?>

<form action='?xx=<?php echo str_replace(' ','%20',$xx); ?>' method='post' name='form1' onsubmit="return gcpedcli(form1)">

<?php

$codigoc = $_POST['codigoc'];

echo "<p /><label>Cliente</label> <select name='codigoc'>";

$result = $link->query("SELECT codigo, cliente FROM clientes ORDER by cliente");
while ($row = $result->fetch_array(MYSQLI_BOTH)){
echo "<option value='".$row[0]."'";
if ($row[0] == $codigoc) {
	echo " selected";
}
echo ">".$row[1]."\n";
}

echo "</select>\n";

?>

<input type='submit' value='Pedidos'>

</form>

<?php
if ($codigoc) {
	include("gcpedcli1.php");
}

?></div>

<?php include("pie.php");?></body></html>

</body></html>
