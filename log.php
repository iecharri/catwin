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

$remote_host = $_SERVER['REMOTE_HOST'];
if (!$remote_host) {$remote_host = $_SERVER['REMOTE_ADDR'];}
if (!$remote_host) {$remote_host = $_SERVER['HTTP_CLIENT_IP'];}
$request_method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$date = date( "d/M/Y:H:i:s"); 

$log = "$remote_host [$date] (".$_SESSION['empresa']."/".$_SESSION['usuario'].") $request_method $request_uri\n"; 

if($f = @fopen(LOG,"a")) { 
	fputs($f, $log); 
	fclose($f); 
} 

?> 

