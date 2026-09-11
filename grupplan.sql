-- Copyright (C) 2000-2013  Antonio Grandío Botella http://www.antoniograndio.com
-- Copyright (C) 2000-2013  Inmaculada Echarri San Adrián inma.echarri@gmail.com

-- This file is part of Catwin.

-- CatWin is free software; you can redistribute it and/or modify
-- it under the terms of the GNU General Public License as published by
-- the Free Software Foundation; either version 2 of the License, or
-- at your option) any later version.

-- CatWin is distributed in the hope that it will be useful,
-- but WITHOUT ANY WARRANTY; without even the implied warranty of
-- MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
-- GNU General Public License for more details:
-- http://www.gnu.org/copyleft/gpl.html

-- You should have received a copy of the GNU General Public License
-- along with Catwin Net; if not, write to the Free Software
-- Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

-- 
-- Estructura de tabla para la tabla `grupplan`

CREATE TABLE `grupplan` (
  `grupo` int(2) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripgr` longtext NOT NULL
) ENGINE=MyISAM;

-- 
-- Volcar la base de datos para la tabla `grupplan`
-- 

INSERT INTO `grupplan` (`grupo`, `nombre`, `descripgr`) VALUES 
(1, 'Financiación Básica', '0'),
(2, 'Inmovilizado', '0'),
(3, 'Existencias', '0'),
(4, 'Acreedores y deudores por operaciones comerciales', '0'),
(5, 'Cuentas financieras', '0'),
(6, 'Compras y Gastos', '0'),
(7, 'Ventas e ingresos', '0'),
(8, 'Gastos imputados al patrimonio neto', '0'),
(9, 'Ingresos imputados al patrimonio neto', '0');
