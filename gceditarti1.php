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

$a=explode("/",$fechap); 
$b=explode("/",$fechar); 

$fechap = "20".$a[2]."-".$a[1]."-".$a[0];
$fechar = "20".$b[2]."-".$b[1]."-".$b[0];
$result = $link->query("UPDATE invent SET artic = '$artic', situaci_n = '$situaci_n',  fechap = '$fechap', fechar = '$fechar', p_coste = '$p_coste', tipo = '$tipo' WHERE row_id = '$row_id'") or die ("<p />El usuario $usuario no tiene permisos para modificar Inventario"); 

?>
