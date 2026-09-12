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

$empresa = $_POST['nuevaemp'];

$empresa = sanear($empresa);

$mensaje = "&nbsp;";

if ($bd != '') {
	if (!mysqli_select_db($link,$bd)) {
		$mensaje = "Error: No existe la Empresa <span class='b'>$bd</span> de la que se quieren copiar tablas."; return;
	} else {
		mysqli_select_db($link,$bd);
		$sql = "SELECT * FROM usuarios WHERE usuario = '$usuariocop' AND clave = '".SHA1($passwordcop)."'";
		$result = $link->query($sql);
		$fila = $result->fetch_array(MYSQLI_BOTH);
		if (!$fila) {$mensaje = "Usuario o clave incorrecto de la Base de datos <span class='b'>$bd</span> de la que se quieren copiar tablas."; return;}
	}
}

//Comprobar si existe la BD de la Empresa a crear
if (!mysqli_select_db($link,$empresa)) {
	// Si no existe se crea
	$sql = "CREATE DATABASE $empresa DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci"; //CHARACTER SET utf8 COLLATE utf8_general_ci";
	if (!$link->query($sql)) {
		//Si no se ha podido crear
		$mensaje = "Error: Imposible crear base de datos <span class='b'>$empresa</span><p />Es posible que debas crear la base de datos manualmente en el servidor."; return;
	} else {
		//Se ha creado y sigue el php creando talbas
	}
} else {
	//Existe, ver si tiene tablas, por ejemplo tabla usuarios
	$checktable = $link->query("SHOW TABLES LIKE 'usuarios'");
	$tableexiste = $checktable->num_rows > 0;
	if ($tableexiste) {
		$mensaje = "Error: Imposible crear base de datos <span class='b'>$empresa</span>. Ya existe en el servidor."; return;
	}
}

mysqli_select_db($link,$empresa);
$link->query("set names 'utf8'");
	
# --------------------------------------------------------
#
# Estructura de tabla para tabla 'apuntes'
#

$sql = "CREATE TABLE IF NOT EXISTS apuntes (
   row_id int(11) NOT NULL auto_increment,
   fecha date,
   asiento int(11),
   cuenta int(11),
   concepto char(255),
   debe decimal(11,2),
   haber decimal(11,2),
   tipo char(20),
   uno double,
   descripci_ char(40),
   asientoord double,
   cotejo char(1),
   sisf date,
   contrap int(11),
   modificadofecha timestamp,
   modificadousuario char(15) NOT NULL,
   fechamod timestamp,
   ip varchar(15),
   PRIMARY KEY (row_id)
)";
$link->query($sql) or die ("No ha sido posible crear la tabla 'apuntes'");

# --------------------------------------------------------
#
# Estructura de tabla para tabla 'asientos'
#

$sql = "CREATE TABLE IF NOT EXISTS asientos (
   row_id int(11) NOT NULL auto_increment,
   asiento int(11) DEFAULT '0' NOT NULL,
   ctaact char(8),
   ctarec char(9),
   ctateso char(9),
   sistemhtm9 char(8),
   fecha date,
   irpf char(1),
   n_face double,
   n_facr int(11),
   nomclient char(40),
   proveedor char(13),
   tipivar1 double,
   tipo char(15),
   totale double,
   totalr1 double,
   totalr2 double,
   totalr3 double,
   tipivar2 double,
   tipiva3 double,
   totcobro double,
   totpago double,
   descg6 char(45),
   totalfrcee double,
   l_quido double,
   ossa double,
   retirpf double,
   cuotpatron double,
   exppagos char(1),
   astohecho char(1),
   tipivae double,
   n_empresa int(11),
   guardada char(1),
   empresa char(40),
   asientoord double,
   sumadebe decimal(11,2),
   sumahaber decimal(11,2),
   modificar char(1),
   descpago char(15),
   sistemd date,
   tipirpf int(11),
   basefr int(11),
   cuotafr int(11),
   basefr1 int(11),
   basefr2 int(11),
   basefr3 int(11),
   cuotafr1 int(11),
   cuotafr2 int(11),
   cuotafr3 int(11),
   totalfr int(11),
   fich longblob,
   tipofich char(255),
   explicacion longtext,
   PRIMARY KEY (row_id),
   UNIQUE KEY asiento (asiento)
)";
$link->query($sql) or die ("No ha sido posible crear la tabla 'asientos'");

# --------------------------------------------------------
#
# Estructura de tabla para tabla 'empresa'
#

$sql = "CREATE TABLE IF NOT EXISTS empresa (
   nombre char(50) NOT NULL,
   domicilio char(30) NOT NULL,
   localidad char(20) NOT NULL,
   cp int(5) unsigned DEFAULT '0' NOT NULL,
   campo1 tinyint(4) DEFAULT '0' NOT NULL,
   campo2 tinyint(4) DEFAULT '0' NOT NULL,
   ultfecha date DEFAULT '0000-00-00' NOT NULL,
   ultfact char(11) NOT NULL,
   ultasi INT( 11 ) NOT NULL,
   nomreduc char(8) NOT NULL,
   anocont int(4) NOT NULL,
   menu1 int(1) NOT NULL,
   menu2 int(1) NOT NULL,
   menu3 int(1) NOT NULL,
   menu4 int(1) NOT NULL,
   actualizaciones int(1) NOT NULL,
   bloq int(1),
   ultdebe int(1),
   ulthaber int(1),
   ultconcepto int(1)
)";
$link->query($sql) or die ("No ha sido posible crear la tabla 'empresa'");

$sql = "INSERT INTO empresa VALUES ( '$empresa11', '', '', '', '', '', '','', 0, '$basedatos', $anocont,'1','1','1','1','1','','','','')";

$link->query($sql);

# --------------------------------------------------------
#
# Estructura de tabla para tabla 'subcuent'
#

$sql = "CREATE TABLE IF NOT EXISTS subcuent (
   row_id int(11) NOT NULL auto_increment,
   cuenta int(11) NOT NULL,
   descripci_ char(255),
   natura varchar(20),
   cuenta_pla int(11),
   saldod double,
   saldoa double,
   contrapda double,
   importomis double,
   asreg int(11),
   nif char(15),
   ctacte varchar(23),
   telefono varchar(20),
   telefono2 varchar(20),
   sdebe DOUBLE NOT NULL,
   shaber DOUBLE NOT NULL,
   PRIMARY KEY (row_id),
   UNIQUE KEY cuenta (cuenta)
)";
$link->query($sql) or die ("No ha sido posible crear la tabla 'subcuent'");

# --------------------------------------------------------
#
# Estructura de tabla para tabla 'cuentas'
#

$sql = "CREATE TABLE IF NOT EXISTS cuentas (
   row_id int(11) NOT NULL auto_increment,
   cuenta int(11) NOT NULL,
   descripcio char(255),
   subgrupo int(11),
   sdo3cd double,
   sdo3ca double,
   sdebe DOUBLE NOT NULL,
   shaber DOUBLE NOT NULL,
   PRIMARY KEY (row_id),
   UNIQUE KEY cuenta (cuenta)
)";
$link->query($sql) or die ("No ha sido posible crear la tabla 'cuentas'");

# --------------------------------------------------------
#
# Estructura de tabla para la tabla `cuentas4`
#

$sql = "CREATE TABLE IF NOT EXISTS cuentas4 (
  row_id int(11) NOT NULL AUTO_INCREMENT,
  cuenta int(11) NOT NULL,
  descripcio char(255) DEFAULT NULL,
  cuenta3 int(11) DEFAULT NULL,
  sdo4d double DEFAULT NULL,
  sdo4h double DEFAULT NULL,
  sdebe double NOT NULL,
  shaber double NOT NULL,
  PRIMARY KEY (row_id),
  UNIQUE KEY cuenta (cuenta)
)";
$link->query($sql) or die ("No ha sido posible crear la tabla 'cuentas4'");

# --------------------------------------------------------
#
# Estructura de tabla para la tabla `cuentas5`
#

$sql = "CREATE TABLE IF NOT EXISTS cuentas5 (
  row_id int(11) NOT NULL AUTO_INCREMENT,
  cuenta int(11) NOT NULL,
  descripcio char(255) DEFAULT NULL,
  cuenta4 int(11) DEFAULT NULL,
  sdo5d double DEFAULT NULL,
  sdo5h double DEFAULT NULL,
  sdebe double NOT NULL,
  shaber double NOT NULL,
  PRIMARY KEY (row_id),
  UNIQUE KEY cuenta (cuenta)
)";
$link->query($sql) or die ("No ha sido posible crear la tabla 'cuentas5'");

# --------------------------------------------------------
#
# Estructura de tabla para tabla 'usuarios'
#

$sql = "CREATE TABLE IF NOT EXISTS usuarios (
   usuario char(15) NOT NULL,
   clave varchar(40) NOT NULL,
   fecha timestamp,
   perm int(1),
   menus varchar(20),
   calc LONGTEXT NOT NULL,
   PRIMARY KEY usuario (usuario)
)";
$link->query($sql) or die ("No ha sido posible crear la tabla 'usuarios'");

#
# Volcar la base de datos para la tabla 'usuarios'
#

$sql = "INSERT INTO usuarios VALUES ( '".$_POST['usuario']."', SHA1('".$_POST['clave']."'), '00000000000000', '5','11111111111111111111','')";
$link->query($sql) or die ("Error al insertar usuario en la tabla 'usuarios'");

# --------------------------------------------------------
#
# Estructura de tabla para tabla 'grupos'
#

$sql = "CREATE TABLE IF NOT EXISTS grupos (
   row_id int(11) NOT NULL auto_increment,
   grupo int(10),
   nombre char(50),
   PRIMARY KEY (row_id)
)";
$link->query($sql) or die ("No ha sido posible crear la tabla 'grupos'");


# --------------------------------------------------------
#
# Estructura de tabla para tabla 'subgrupo'
#

$sql = "CREATE TABLE IF NOT EXISTS subgrupo (
   row_id int(11) NOT NULL auto_increment,
   subgrupo int(11) NOT NULL,
   descripci_ char(255),
   grupo int(11),
   sdod2c decimal(11,2),
   sdoh2c decimal(11,2),
   sdebe DOUBLE NOT NULL,
   shaber DOUBLE NOT NULL,
   PRIMARY KEY (row_id),
   UNIQUE KEY subgrupo (subgrupo)

)";
$link->query($sql) or die ("No ha sido posible crear la tabla 'subgrupo'");


# --------------------------------------------------------
#
# Estructura de tabla para tabla 'proveed'
#

$sql = "CREATE TABLE IF NOT EXISTS proveed (
   codigo int(11) NOT NULL auto_increment,
   proveed char(40),
   direcci_n char(80),
   tel_fono char(30),
   fax char(30),
   represente char(40),
   tel_rep_ char(30),
   fax_rep_ char(30),
   cuenta int(16),
   grupo char(1),
   prove_acre char(10),
   codprov int(11),
   dtogrupo double,
   dtopp double,
   dtoportes double,
   dtovar double,
   nifprov char(15),
   prov347 int(11),
   telmov char(20),
   PRIMARY KEY (codigo)
)";
$link->query($sql) or die ("No ha sido posible crear la tabla 'proveed'");

# --------------------------------------------------------

#
# Estructura de tabla para tabla 'clientes'
#

$sql = "CREATE TABLE IF NOT EXISTS clientes (
   codigo int(11) NOT NULL auto_increment,
   dni int(11) NOT NULL,
   cliente char(50),
   domicilio char(50),
   ciudad char(20),
   codpost int(11),
   telefono char(10),
   letradni char(1),
   UNIQUE dni (dni),
   cuenta varchar(20),
   PRIMARY KEY (codigo)
)";
$link->query($sql) or die ("No ha sido posible crear la tabla 'clientes'");

# --------------------------------------------------------

#
# Estructura de tabla para tabla 'tipos'
#

$sql = "CREATE TABLE IF NOT EXISTS tipos (
   row_id int(11) NOT NULL auto_increment,
   tipo char(35),
   c_digo char(16),
   margen double,
   oferta double,
   grupo char(25),
   PRIMARY KEY (row_id)
)";
$link->query($sql) or die ("No ha sido posible crear la tabla 'tipos'");

# --------------------------------------------------------

#
# Estructura de tabla para tabla 'invent'
#

$sql = "CREATE TABLE IF NOT EXISTS invent (
   row_id int(11) NOT NULL auto_increment,
   proveed char(45),
   codigo int(11) DEFAULT '0' NOT NULL,
   artic char(30),
   situaci_n char(10),
   fechap date,
   fechar date,
   p_coste double,
   destino char(10),
   tienda char(15),
   n_ped int(11) DEFAULT '0' NOT NULL,
   color char(15),
   modd char(15),
   medida char(15),
   tipo char(30),
   facrec char(10),
   pvp double,
   observainv char(100),
   abonodev double,
   margenesp double,
   sistema char(15),
   PRIMARY KEY (row_id)
)";
$link->query($sql) or die ("No ha sido posible crear la tabla 'invent'");

# --------------------------------------------------------

#
# Estructura de tabla para tabla 'factrec'
#

$sql = "CREATE TABLE IF NOT EXISTS factrec (
   row_id int(11) NOT NULL auto_increment,
   fecha date,
   fact char(10),
   proveed char(40),
   codigo int(11) DEFAULT '0' NOT NULL,
   totalr double,
   clave double,
   traspaso char(1),
   totbruto double,
   desctofr double,
   verificada char(1),
   punteo char(1),
   tipivar1 double,
   tipivar2 double,
   tipivar3 double,
   totalr1 double,
   totalr2 double,
   totalr3 double,
   descrip char(30),
   gasto char(1),
   concepto char(30),
   sistema char(15),
   cta int(11),
   tipirpf double,
   gastod int(11),
   nomretss int(11),
   asiento int(11),
   fich longblob NOT NULL,
   tipofich varchar(255) NOT NULL,
   PRIMARY KEY (row_id)
)";

$link->query($sql) or die ("No ha sido posible crear la tabla 'factrec'");

# --------------------------------------------------------

#
# Estructura de tabla para tabla 'pedidos'
#

$sql = "CREATE TABLE IF NOT EXISTS pedidos (
   row_id int(11) DEFAULT '0' NOT NULL,
   fecha date,
   client char(80),
   direcci_n char(60),
   ciudad char(10),
   cod_postal int(8),
   tel_fono char(16),
   observacio char(100),
   n_ int(10) DEFAULT '0' NOT NULL,
   n_ped int(11),
   dni char(12),
   totpedido decimal(16,2),
   vendedor char(25),
   _dtopedf double,
   totalcal_ int(11),
   sistema char(21)
)";

$link->query($sql) or die ("No ha sido posible crear la tabla 'pedidos'");

# --------------------------------------------------------

#
# Estructura de tabla para tabla 'factemi'
#

$sql = "CREATE TABLE IF NOT EXISTS factemi (
   row_id int(11) DEFAULT '0' NOT NULL,
   fecha date,
   n_ int(10) DEFAULT '0' NOT NULL,
   total double,
   letra char(1),
   clave double,
   traspaso char(1),
   dni char(10),
   cliente char(80),
   benefbrut int(11),
   asiento int(11),
   UNIQUE n_ (n_),
   fich longblob,
   tipofich	varchar(255),
   tipivar1	double
)";

$link->query($sql) or die ("No ha sido posible crear la tabla 'factemi'");

# --------------------------------------------------------

#
# Estructura de tabla para tabla 'referers'
#
if (PRUEBA == 1) {
// *** SERVER_PRUEBAS
$sql = "CREATE TABLE IF NOT EXISTS `referers` (
   referer varchar(255) DEFAULT '' NOT NULL,
   palabras varchar(255) NOT NULL,
   fecha timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP
)";
$link->query($sql) or die ("No ha sido posible crear la tabla 'referers'");
// *** SERVER_PRUEBAS
}
# --------------------------------------------------------

#
# Estructura de tabla para tabla 'notas'
#

$sql = "CREATE TABLE IF NOT EXISTS `notas` (
  `id` int(6) NOT NULL auto_increment,
  `usuario` varchar(15) NOT NULL,
  `fecha` date NOT NULL,
  `asunto` varchar(20) NOT NULL,
  `nota` mediumtext NOT NULL,
  PRIMARY KEY  (`id`)
)";

$link->query($sql) or die ("No ha sido posible crear la tabla 'notas'");

# --------------------------------------------------------

#-- --------------------------------------------------------

#--
#-- Estructura de tabla para la tabla `iva`
#--

$sql = "CREATE TABLE IF NOT EXISTS `iva` (
  `n` int(3) NOT NULL AUTO_INCREMENT,
  `iva` decimal(5,2) NOT NULL,
  PRIMARY KEY (`n`),
  UNIQUE KEY `iva` (`iva`)
) ENGINE=InnoDB AUTO_INCREMENT=1 ;";

$link->query($sql) or die ("No ha sido posible crear la tabla 'iva'");

#--
#-- Volcado de datos para la tabla `iva`
#--

$sql = "INSERT INTO `iva` (`n`, `iva`) VALUES (1, 0.21);";

$link->query($sql) or die ("No ha sido posible insertar iva la tabla 'iva'");

# --------------------------------------------------------

if ($bd != '')

{
	
	mysqli_select_db($link,$bd);
	$link->query("set names 'utf8'");
	$desde = $link->query("SELECT cuenta, descripci_, cuenta_pla FROM subcuent"); 
	mysqli_select_db($link,$empresa);
	$link->query("set names 'utf8'");
	while ($fila = $desde->fetch_array(MYSQLI_BOTH)) :
		$sql = "INSERT INTO subcuent (cuenta, descripci_, cuenta_pla) VALUES ('$fila[0]', '$fila[1]', '$fila[2]')";
		$link->query($sql);
	endwhile;



	mysqli_select_db($link,$bd);
	$link->query("set names 'utf8'");
	$desde = $link->query("SELECT row_id, grupo, nombre FROM grupos"); 
	mysqli_select_db($link,$empresa);
	$link->query("set names 'utf8'");

	while ($fila = $desde->fetch_array(MYSQLI_BOTH)) :
		$sql = "INSERT INTO grupos (row_id, grupo, nombre) VALUES ('$fila[0]', '$fila[1]', '$fila[2]')";
		$link->query($sql);
	endwhile;



	mysqli_select_db($link,$bd);
	$link->query("set names 'utf8'");
	$desde = $link->query("SELECT row_id, subgrupo, descripci_, grupo FROM subgrupo"); 
	mysqli_select_db($link,$empresa);
	$link->query("set names 'utf8'");

	while ($fila = $desde->fetch_array(MYSQLI_BOTH)) :
		$sql = "INSERT INTO subgrupo (row_id, subgrupo, descripci_, grupo) VALUES ('$fila[0]', '$fila[1]', '$fila[2]', '$fila[3]')";
		$link->query($sql);
	endwhile;


	mysqli_select_db($link,$bd);
	$link->query("set names 'utf8'");
	$desde = $link->query("SELECT row_id, cuenta, descripcio, subgrupo FROM cuentas"); 
	mysqli_select_db($link,$empresa);
	$link->query("set names 'utf8'");

	while ($fila = $desde->fetch_array(MYSQLI_BOTH)) :
		$sql = "INSERT INTO cuentas (row_id, cuenta, descripcio, subgrupo) VALUES ('$fila[0]', '$fila[1]', '$fila[2]', '$fila[3]')";
		$link->query($sql);
	endwhile;


	mysqli_select_db($link,$bd);
	$link->query("set names 'utf8'");
	$desde = $link->query("SELECT codigo, proveed, direcci_n, tel_fono FROM proveed"); 
	mysqli_select_db($link,$empresa);
	$link->query("set names 'utf8'");
	
	while ($fila = $desde->fetch_array(MYSQLI_BOTH)) :
		$sql = "INSERT INTO proveed (codigo, proveed, direcci_n, tel_fono) VALUES ('$fila[0]', '$fila[1]', '$fila[2]', '$fila[3]')";
		$link->query($sql);
	endwhile;


	mysqli_select_db($link,$bd);
	$link->query("set names 'utf8'");
	$desde = $link->query("SELECT dni, cliente, domicilio, ciudad, codpost, telefono, letradni  FROM clientes"); 
	mysqli_select_db($link,$empresa);
	$link->query("set names 'utf8'");

	while ($fila = $desde->fetch_array(MYSQLI_BOTH)) :
		$sql = "INSERT INTO clientes (dni, cliente, domicilio, ciudad, codpost, telefono, letradni) VALUES ('$fila[0]', '$fila[1]', '$fila[2]', '$fila[3]', '$fila[4]', '$fila[5]', '$fila[6]')";
		$link->query($sql);
	endwhile;


	mysqli_select_db($link,$bd);
	$link->query("set names 'utf8'");
	$desde = $link->query("SELECT row_id, tipo, c_digo, margen, oferta, grupo FROM tipos"); 
	mysqli_select_db($link,$empresa);
	$link->query("set names 'utf8'");

	while ($fila = $desde->fetch_array(MYSQLI_BOTH)) :
		$sql = "INSERT INTO tipos (row_id, tipo, c_digo, margen, oferta, grupo) VALUES ('$fila[0]', '$fila[1]', '$fila[2]', '$fila[3]', '$fila[4]', '$fila[5]')";
		$link->query($sql);
	endwhile;

}

$mensaje = "Se ha creado la Base de Datos de Contabilidad para la empresa <span class='b'>$empresa</span>.<p />Recuerda que para trabajar con ella has de rellenar los datos de las casillas de arriba con los siguientes valores:<p />Empresa: <span class='b'>$empresa</span> &nbsp; Usuario: <span class='b'>".$_POST['usuario']."</span> &nbsp; Clave: <span class='b'>".$_POST['clave']."</span>.";

$_POST['empresa1'] = $empresa; $_POST['usuario1'] = $_POST['usuario']; $_POST['password1']= $_POST['clave'];

//********************************

function sanear($string)
{
 
    $string = trim($string);
 
    $string = str_replace(
        array('&aacute;', 'à', 'ä', 'â', 'ª', '&Aacute;', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );
 
    $string = str_replace(
        array('&eacute;', 'è', 'ë', 'ê', '&Eacute;', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );
 
    $string = str_replace(
        array('&iacute;', 'ì', 'ï', 'î', '&Iacute;', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );
 
    $string = str_replace(
        array('&oacute;', 'ò', 'ö', 'ô', '&Oacute;', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );
 
    $string = str_replace(
        array('&uacute;', 'ù', 'ü', 'û', '&Uacute;', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );
 
    $string = str_replace(
        array('&ntilde;', 'Ń', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );
 
    //Esta parte se encarga de eliminar cualquier caracter extra&ntilde;o
    $string = str_replace(
        array("\\", "¨", "&deg;", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "&iexcl;",
             "&iquest;", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "<", ";", ",", ":"),
        '',
        $string
    );
 
    $string = str_replace(
        array(" "),
        '_',
        $string
    );
 
    return $string;
}

