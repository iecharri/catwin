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

r_rmdir("_backups");

$fich = '_backups/'.$_SESSION['empresa'].'_'.date('Ymdhis').'.sql';	
$command = MYSQLDUMP.' --opt -u '.USER.' -p'.PASSWORD.' '.$_SESSION['empresa'].' > '.$fich;

exec($command);

echo "<a href='$fich' target='_blank'>Bajar la copia de seguridad <span class='b'>$fich</span> (<span class='rojo'>gu&aacute;rdala en tu ordenador</span>)</a>";

//**********************************

function r_rmdir($dir) { 
    if (is_dir($dir)) { 
        $objects = scandir($dir); 
        foreach ($objects as $object) { 
            if ($object != "." && $object != "..") { 
                //if (filetype($dir."/".$object) == "dir") r_rmdir($dir."/".$object); else 
                unlink($dir."/".$object); 
            } 
        }
        reset($objects); 
        //rmdir($dir); 
    }
}
?>