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

<?php

$result = $link->query("SELECT nombre, anocont FROM empresa");
$row = $result->fetch_array(MYSQLI_BOTH);

$nombre = $row[0];
$anocont = $row[1];
$pagina = 1;

echo "<div id='pag' class='arial'>";
echo $nombre;
echo "<br />\n";
echo "<p class='centro b'>BALANCE DE SUMAS Y SALDOS<p />\n";
echo "<br />\n";
echo "<p class='centro'>DICIEMBRE ".$anocont."<p />\n";
echo "<table class='listados wid99'>\n";
echo "   <tr>\n";
echo "      <th class='anchomin'>Cuenta</td>\n";
echo "      <th class='centro'>Nombre</th>\n";
echo "      <th class='anchomin'>Sumas Debe</th>\n";
echo "      <th class='anchomin'>Sumas Haber</th>\n";
echo "      <th class='anchomin'>Saldo Deudor</th>\n";
echo "      <th class='anchomin'>Saldo Acreedor</th>\n";
echo "   </tr>\n";

$result = $link->query("SELECT cuenta, descripci_, saldod, saldoa, sdebe, shaber FROM subcuent ORDER BY cuenta");

while ($row = $result->fetch_array(MYSQLI_BOTH))
{

	extract($row);

   $dif = $sdebe - $shaber;
   if( $dif > 0 )
   {
	  $sdeudor = $dif;
	  $sacreedor = 0;
   }
   else
   {
	  $sacreedor = - $dif;
	  $sdeudor = 0;
   }   

   $totsdebe += $sdebe;
   $totshaber += $shaber;
   $totsdeudor += $sdeudor;
   $totsacreedor += $sacreedor;

   echo "   <tr>\n";
   echo "      <td>".$cuenta."</td>\n";
   echo "      <td class='izda'>".$descripci_."</td>\n";
   echo "      <td>".number_format($sdebe*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
   echo "      <td>".number_format($shaber*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
   echo "      <td>".number_format($sdeudor*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
   echo "      <td>".number_format($sacreedor*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
   echo "   </tr>\n";
}   

echo "   <tr>\n";
echo "      <td></td>\n";
echo "      <td></td>\n";
echo "      <td>".number_format($totsdebe*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "      <td>".number_format($totshaber*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "      <td>".number_format($totsdeudor*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "      <td>".number_format($totsacreedor*$_SESSION['moneda'],$_SESSION['deci'], ",", "." )."</td>\n";
echo "   </tr>\n";

echo "</table>\n";
echo "</div>";

?>