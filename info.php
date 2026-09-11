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

<div style='margin:0 3em;'>

<!--
<table class='listados'>
<tr>
<td class='rojo b'>24-05-2013</td>
<td class='izda'>Uso de <a href='http://jquery.org' target='_blank'>Jquery</a> para mejorar despliegue de calendarios y apertura de ventanas.<br />Nueva tabla de IVA para poder a&ntilde;adir/modificar valores.<br />
Uso de extensiones MYSQLI (m&aacute;s eficientes) en lugar de MYSQL. Versi&oacute;n 0.8 en <a target='_blank' href="http://sourceforge.net/projects/catwin/files/">Sourceforge</a> </td>
</tr>
<tr>
<td style='white-space:nowrap'>01-12-2012</td>
<td style='width:100%' class='izda'><span class='rojo' style='font-size:1.3em'>Utiliza el men&uacute; <span class='verde'> Otros >> Copia Seguridad </span> y baja a tu ordenador una copia de los datos de tu Empresa.</span>
</td>
</tr>
<tr>
<td>01-12-2012</td>
<td class='izda'>Actualizado script Copia Seguridad</td>
</tr>
<tr>
<td>17-03-2011</td>
<td class='izda'>Desplegable de empresas, mejora en la seguridad de contrase&ntilde;as. Nueva versi&oacute;n de Catwin en <a href="http://sourceforge.net/projects/catwin/files/" target="_blank"> http://sourceforge.net/projects/catwin/files/</a>.
 Gracias a <a href='mailto:milor@espadasinnombre.es'>Jose Antonio</a></td>
</tr>
<tr>
<td>02-01-2011</td>
<td class='izda'>Actualizados los tipos de IVA vigentes. Nueva versi&oacute;n de Catwin en <a href="http://sourceforge.net/projects/catwin/files/" target="_blank"> http://sourceforge.net/projects/catwin/files/</a></td>
</tr>
<tr>
<td>28-11-2010</td>
<td class='izda'><span class='b'>novedades v. 0.7</span>: Listados de cuentas anuales, en desarrollo, con previsualizaci&oacute;n. Calculadora.</td>
</tr>
</table><p /><br />
-->



<div style='text-align:center;font-size:.9em;line-height:1.5em'>

<a href='http://sourceforge.net/projects/catwin' target='_blank'>CatWin Net</a> es un paquete de Contabilidad On Line que se distribuye como <span class='b'>Software Libre / Open Source</span> bajo licencia <a href = 'http://www.gnu.org/copyleft/gpl.html' target='_new'>GNU</a>.<p />

<span class='rojo b'>Atenci&oacute;n</span>: Nuestro servidor, gratuito, a&uacute;n est&aacute; en fase de pruebas. Haz copia de seguridad de tus datos frecuentemente. Es tu responsabilidad.<p /> 

<div style='margin:0 3em;text-align:justify'><span class='b'>CatWin Net</span>
es la contrapartida de la aplicaci&oacute;n <a target='_blank' 
href='http://www.virtualeidos.com/humansite/Catwin.htm' class='b'>CatWin 1.7</a> que sigo desarrollando 
para Lotus Approach pero para funcionar en versi&oacute;n <span class='b'>OnLine</span> en Inter/Intranet.
Utiliza el lenguaje <span class='b'>PHP</span> en el servidor, <span class='b'>Javascript</span> en el
cliente y la base de datos <span class='b'>MySql</span>. A imagen de la versi&oacute;n de
Approach, va a tener 3 niveles de agregaci&oacute;n: el de <span class='b'>Gesti&oacute;n Comercial</span>,
el de <span class='b'>Contabilidad</span> y el de <span class='b'>Cuentas Anuales/An&aacute;lisis de la
Informaci&oacute;n Contable</span>. Lo estamos haciendo a medias <a class='b' href="mailto:inma.echarri@gmail.com" target="_blank"> Inma Echarri</a> y
<a class='b' href="http://www.antoniograndio.com" target="_blank">yo</a> y, como
puede verse, a diferencia de otros programas dise&ntilde;ados inicialmente para
Windows pero que se adaptan para usarse en modo terminal (Terminal Server
de MS Windows 2000 por ejemplo), es un proyecto que parte de cero y que
pretende trascender el concepto de aplicaci&oacute;n cerrada e independiente de
otros programas (Recursos Humanos, Contabilidad, etc) para convertirse en un
sistema de informaci&oacute;n, conocimiento y comunicaci&oacute;n global tipo <span class='b'>ERP</span>
en la empresa
virtual del futuro inmediato.<p />
La versi&oacute;n actual en <span class='b'>fase Alfa 0.8</span>, ya incluye la posibilidad de
 <span class='b'>alta</span>, <span class='b'>baja</span> y <span class='b'>modificaci&oacute;n</span> de <span class='b'>subcuentas</span> as&iacute;
 como de <span class='b'>asientos</span> y la automatizaci&oacute;n de algunos procesos
 repetitivos (<span class='b'>asientos autom&aacute;ticos de facturas recibidas - emitidas</span>,
 con sus respectivos <span class='b'>abonos</span> cuando se introducen importes negativos,
 y asientos simples). Ya funcionan tambi&eacute;n el <span class='b'>Libro Diario</span>, el <span class='b'>Mayor - Extracto
 de Cuentas</span> y los <span class='b'>Balances de Comprobaci&oacute;n</span> a <span class='b'>tres</span> <span class='b'>niveles</span>
 de agregaci&oacute;n (nivel de <span class='b'>subcuenta</span>, <span class='b'>cuenta</span> y <span class='b'>subgrupo</span>).
 Es interesante comprobar la escasa distancia existente entre asientos,
 extractos de cuenta y su modificaci&oacute;n (a un simple click unos de otros)
 gracias al hipertexto y tambi&eacute;n constatar su infinito potencial de
 ampliaci&oacute;n (v&iacute;a simples clicks) a &aacute;mbitos extracontables para abarcar
 la totalidad de la empresa y sus v&iacute;nculos con la Extranet e Internet.
 Asimismo, funciona ya la caracter&iacute;stica de multiempresa, de modo que
 cualquiera puede ya dar un empresa de alta y empezar a experimentar con
 &eacute;l. En concreto animamos a que se haga esto &uacute;ltimo y que se nos hagan
 sugerencias.</div>
 
 <p />
 Tus <a href='mailto:mail@antoniograndio.com;inma.echarri@gmail.com'>comentarios y sugerencias</a> son muy importantes para mejorar Catwin. Gracias.
 <p />

 <div>Copyright &copy; 2000 - <?php echo date("Y");?> <a href="http://www.antoniograndio.com/">Antonio Grand&iacute;o</a> &amp; 
 <a href="mailto:inma.echarri@gmail.com">Inma Echarri.</a></div>
 
 <?php

$link = @new mysqli(SERVER,USER,PASSWORD);
if ($link->connect_errno) {
    exit;
}

if (PRUEBA == 1) {
// *** SERVER_PRUEBAS
mysqli_select_db($link,"nuevocat");
$link->query("set names 'utf8'");
//if (!eregi($_SERVER['HTTP_HOST'],$_SERVER['HTTP_REFERER'])) {
if (!preg_match("/".$_SERVER['HTTP_HOST']."/", $_SERVER['HTTP_REFERER'])) {
    if ($_SERVER['HTTP_REFERER']) {
		$a = strstr($_SERVER['HTTP_REFERER'],"q=");
		$pos = strpos($a,"&");
		$a = str_replace("+", " ", substr($a, 2, ($pos-2)));
		$query = "INSER INTO referers (referer, palabras) values ('".$_SERVER['HTTP_REFERER']."', '$a')";
		mysqli_query($link,$query);
    } 
}
// *** SERVER_PRUEBAS
}

?>

</div>
