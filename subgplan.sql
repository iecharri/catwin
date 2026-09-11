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

-- Estructura de tabla para la tabla `subgplan`

CREATE TABLE `subgplan` (
  `subgrupo` int(2) NOT NULL,
  `nombresg` varchar(255) NOT NULL,
  `grupo` int(1) NOT NULL,
  `descripsg` longtext NOT NULL
) ENGINE=MyISAM;

-- 
-- Volcar la base de datos para la tabla `subgplan`
-- 

INSERT INTO `subgplan` (`subgrupo`, `nombresg`, `grupo`, `descripsg`) VALUES 
(10, 'Capital', 1, ''),
(11, 'Reservas', 1, ''),
(12, 'Resultados pendientes de aplicación', 1, ''),
(13, 'Subvenciones, donaciones y ajustes por cambios de valor', 1, ''),
(14, ' Provisiones', 1, ''),
(15, 'Deudas a largo plazo con características especiales', 1, ''),
(16, 'Deudas a largo plazo con partes vinculadas', 1, ''),
(17, 'Deudas a largo plazo por préstamos recibidos y otros conceptos', 1, ''),
(18, 'Pasivos por fianzas y garantías a largo plazo', 1, ''),
(19, 'Situaciones transitorias de financiación', 1, ''),
(20, 'Inmovilizaciones intangibles', 2, ''),
(21, 'Inmovilizaciones materiales', 2, ''),
(22, 'Inversiones inmobiliarias', 2, ''),
(23, 'Inmovilizaciones materiales en curso', 2, ''),
(24, 'Inversiones financieras en partes vinculadas', 2, ''),
(25, 'Otras inversiones financieras a largo plazo', 2, ''),
(26, 'Fianzas y depósitos constituidos a largo plazo', 2, ''),
(28, 'Amortización acumulada del inmovilizado', 2, ''),
(29, 'Deterioro de valor de inmovilizado', 2, ''),
(30, 'Comerciales', 3, ''),
(31, 'Materias Primas', 3, ''),
(32, 'Otros aprovisionamientos', 3, ''),
(33, 'Productos en curso', 3, ''),
(34, 'Productos semiterminados', 3, ''),
(35, 'Productos terminados', 3, ''),
(36, 'Subproductos, residuos y materiales recuperados', 3, ''),
(39, 'Deterioro de valor de las existencias', 3, ''),
(40, 'Proveedores', 4, ''),
(41, 'Acreedores varios', 4, ''),
(43, 'Clientes', 4, ''),
(44, 'Deudores varios', 4, ''),
(46, 'Personal', 4, ''),
(47, 'Administraciones públicas', 4, ''),
(48, 'Ajustes por periodificación', 4, ''),
(49, 'Deterioro de valor de créditos comerciales y provisiones a corto plazo', 4, ''),
(50, 'Empréstitos, deudas con características especiales y otras emisiones análogas a corto plazo', 5, ''),
(51, 'Deudas a corto plazo con partes vinculadas', 5, ''),
(52, 'Deudas a corto plazo por préstamos recibidos y otros conceptos', 5, ''),
(53, 'Inversiones financieras a corto plazo en partes vinculadas', 5, ''),
(54, 'Otras inversiones financieras temporales', 5, ''),
(55, 'Otras cuentas no bancarias', 5, ''),
(56, 'Fianzas y depósitos recibidos y constituidos a corto plazo, y ajustes por periodificación', 5, ''),
(57, 'Tesorería', 5, ''),
(58, 'Activos no corrientes mantenidos para la venta y activos y pasivos asociados', 5, ''),
(59, 'Deterioro del valor de instrumentos financieros', 5, ''),
(60, 'Compras', 6, ''),
(61, 'Variación de existencias', 6, ''),
(62, 'Servicios Exteriores', 6, ''),
(63, 'Tributos', 6, ''),
(64, 'Gastos de personal', 6, ''),
(65, 'Otros gastos de gestión', 6, ''),
(66, 'Gastos financieros', 6, ''),
(67, 'Pérdidas procedentes de activos no corrientes y gastos excepcionales', 6, ''),
(68, 'Dotaciones para amortizaciones', 6, ''),
(69, 'Pérdidas por deterioro y otras dotaciones', 6, ''),
(70, 'Ventas de mercaderías, de producción propia, de servicios, etc.', 7, ''),
(71, 'Variacioón de existencias', 7, ''),
(73, 'Trabajos realizados para la empresa', 7, ''),
(74, 'Subvenciones, donaciones y legados', 7, ''),
(75, 'Otros ingresos de gestión', 7, ''),
(76, 'Ingresos financieros', 7, ''),
(77, 'Beneficios procedentes de activos no corrientes e ingresos excepcionales', 7, ''),
(79, 'Excesos y aplicaciones de provisiones y de pérdidas por deterioro', 7, ''),
(80, 'Gastos financieros por valoración de activos y pasivos', 8, ''),
(81, 'Gastos en operaciones de cobertura', 8, ''),
(82, 'Gastos por diferencias de conversión', 8, ''),
(83, 'Impuesto sobre beneficios', 8, ''),
(84, 'Transferencias de subvenciones, donaciones y legados', 8, ''),
(85, 'Gastos por pérdidas actuariales y ajustes en los activos por retribuciones a largo plazo de prestación definida', 8, ''),
(86, 'Gastos por activos no corrientes en venta', 8, ''),
(89, 'Deterioro de activos financieros', 8, ''),
(90, 'Beneficios en activos financieros disponibles para la venta', 9, ''),
(91, 'Ingresos en operaciones de cobertura', 9, ''),
(92, 'Ingresos por diferencias de conversión', 9, ''),
(94, 'Ingresos por subvenciones, donaciones y legados', 9, ''),
(95, 'Ingresos por ganancias actuariales y ajustes en los activos por retribuciones a largo plazo de prestación definida', 9, ''),
(96, 'Ingresos por activos no corrientes en venta', 9, ''),
(99, 'Reversión del deterioro de activos financieros', 9, '');
