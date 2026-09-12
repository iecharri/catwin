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

include("head.php");
include("jdatepicker.php");

if (!$link OR !$_SESSION['empresa']) {
	include("noempresa.php");
	exit;
}
?>

<body <?php if (!$_POST) {echo " onload=\"foco('n_')\"";} else {echo " onload=\"foco('totfac')\"";}?>>

<?php
include("arriba.php");
$menu51=8;include("menusizda.php");

extract($_GET);
extract($_POST);
if (!$_GET AND !$_POST) {$n_="";$fecha="";}

?>

<form action='?xx=<?php echo str_replace(' ','%20',$xx); ?>' method='post' name='form1' onsubmit="return gcaltafactemi(form1)">

<?php

echo " &nbsp; &nbsp;<a href='gclisfactemi.php' class='b'>Listado de Facturas Emitidas</a> &nbsp; &nbsp;";
?>

<p /><label>Nª Factura</label> <input type='text' name='n_' size='10' maxlength='10' value='<?php echo $n_;?>'> 

<label>Fecha</label> <input type='text' name='fecha' size='8' maxlength='8' class='datepicker' value = '<?php echo $fecha;?>'>
<!-- <input type="button" name="selfecha" value="..."  onclick="displayDatePicker('fecha','','dmy');"> -->

<input type='submit' value='Continuar'>

</form>
<?php

if ($n_) {
	include ("gcaltafactemi1.php");
}

?>

</div>

<?php $top = 0; include("pie.php");?>

</body></html>
