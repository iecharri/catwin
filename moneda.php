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

?>

<form name='moneda' method='post' class='inline' action=''>
<select name='moneda' onchange='javascript:this.form.submit()'>

<?php

$array = moneda();

foreach ($array as $elem) {
	$b = explode("|",$elem);
	if (trim($b[0])) {
		echo "<option value='$b[0]|$b[2]'";
		if ($_SESSION['moneda'] == $b[0] AND strlen($_SESSION['moneda']) == strlen($b[0]) AND $_SESSION['deci'] == $b[2]) {
			echo " selected = 'selected'";
			//$_SESSION['deci'] = $b[2];
			$_SESSION['simbolo'] = $b[3];
		}
		echo ">".$b[1]."</option>";
	}
}
unset($array);

?>

</select></form>

