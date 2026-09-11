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

?>

(En construcci&oacute;n)<p />
<a href='apertura.php'>Apertura Ejercicio</a>
<p />
<a href='regcuen.php'>Regularizaci&oacute;n Ejercicio</a> [ <a href='regcuendes.php'>Deshacer Regularizaci&oacute;n Ejercicio</a> ]
<p />
<a href='regiva.php'>Regularizaci&oacute;n del IVA</a> [ <a href='regivades.php'>Deshacer Regularizaci&oacute;n del IVA</a> ]
<p />
<a href='cierre.php'>Cierre Ejercicio</a>
<p />
<a href='renumerar.php'>Renumerar asientos</a>

</div>

<?php $top = 0; include("pie.php");?>

</body></html>

