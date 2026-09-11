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

Crear Empresa
<p /><br /><p />
<table class='entradadatos'>

<form name='form2' method='post' onsubmit="return crearemp(form2);show('esperar');hide('confirma')">

<tr>
<td class='dcha'><label>Empresa </label></td>
<td><input type='text' name='empresa11' maxlength='50' size='50'></td>
</tr>

<tr>
<td class='dcha'><label>Nombre reducido </label></td>
<td><input type='text' name='nuevaemp' size='20' maxlength='20'> 20 caracteres m&aacute;ximo (letras y n&uacute;meros): este nombre es el identificador a usar</td>
</tr>

<tr>
<td class='dcha'><label>A&ntilde;o contable</label> </td>
<td><input type='text' name='anocont' size='4' maxlength='4'></td>
</tr>

<tr>
<td class='dcha'><label>Usuario</label> </td>
<td><input type='text' name='usuario' size='15' maxlength='15'> Crear un usuario con permisos de acceso a la contabilidad</td>
</tr>

<tr>
<td class='dcha'><label>Clave</label> </td>
<td><input type='password' name='clave' size='16' maxlength='16'> Crear su clave</td>
</tr>

<tr>
<td class='dcha'><label>Confirmar clave</label> </td>
<td><input type='password' name='clave1' size='16' maxlength='16'> Teclear de nuevo la clave del usuario</td>
</tr>

<tr>
<td colspan='2'><p /><br /><p /><blockquote>
Si se desea mantener los datos de las tablas "Grupos", "Subgrupos", "Cuentas", "Subcuentas", "Proveedores", "Clientes" y "Tipos" de otra base de datos creada anteriormente, rellenar aqu&iacute; los datos de la Empresa, usuario autorizado y contrase&ntilde;a de dicha Empresa:<p />

<?php
if (PRUEBA == 1) {
// *** SERVER_PRUEBAS
echo "Ejemplo: Si se desea mantener los datos de la Empresa de prueba Nuevocat, rellenar lo siguente con:<br /> <span class='b'>Empresa</span> nuevocat &nbsp; <span class='b'>usuario</span> gestor &nbsp; <span class='b'>clave</span> gestor<p />";
// *** SERVER_PRUEBAS
}
?>
<label>Empresa:</label> <input type='text' value='' name='bd' size='20' maxlength='20'> &nbsp; <label>Usuario</label>: <input type='text' name='usuariocop' size='15' maxlength='15'> &nbsp; <label>Clave</label>: <input type='password' name='passwordcop' size='16' maxlength='16'> 

</blockquote>
</td>
</tr>


<tr>
<td colspan='2' align='center'><div id='confirma'><input type='submit' name='crearbd' value="Crear base de datos"></div></td>
</tr>

</form>

</table>

<div id='esperar' style='display:none'><img src='loader.gif'> ESPERAR...</div>
