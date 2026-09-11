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

define('SERVER', 'server');
define('USER', 'user');
define('PASSWORD', 'password');
define('PRUEBA', 0);
define('LOG', "");
define('SSL', '0');
// Cuando se modifica la estructura de las tablas los cambios est&aacute;n en adaptardb.php
// y se ejecuta cuando ADAPTARTABLAS = 1
define('ADAPTARTABLAS', '0');

//Define la ruta a la orden mysqldump para poder hacer copias de seguridad
//define('MYSQLDUMP', '"c:\mysql\mysql server 5.1\bin\mysqldump.exe"');
define('MYSQLDUMP', 'mysqldump');

//Para crear listados:

//crear un alias en apache: Alias /catwin/ "/directorio/listados/catwin/"

//Y crear la variable PATH:

//define('PATH', '/directorio/listados/catwin/');

//En Windows y si no se tiene opcion de cambiar el  Alias /catwin/ descomentar la siguiente linea:

//define('PATH', 'catwin/');

// y sustituir "/catwin/" por "catwin/" en otroslistados.php y listados1_1.php

?>
