function foco(elem) {
	document.getElementById(elem).focus();
}
function borrar_cli() {
	return confirm("¿Está seguro de que quiere borrar este Cliente?")
}

function borrar_proveed() {
	return confirm("¿Está seguro de que quiere borrar este Proveedor?")
}

function borrar_art() {
	return confirm("¿Está seguro de que quiere borrar este Artículo?")
}

function borrar_art_de_ped() {
	return confirm("¿Está seguro de que quiere borrar este Artículo del Pedido?")
}

function borrar_ped() {
	return confirm("¿Está seguro de que quiere borrar este Pedido?")
}

function borrar_fact() {
	return confirm("¿Está seguro de que quiere borrar esta Factura?")
}

function borrar_asiento() {
	return confirm("¿Está seguro de que quiere borrar este Asiento?")
}

function borrar_justificante() {
	return confirm("¿Está seguro de que quiere borrar este Justificante?")
}

function borrar_apunte() {
	return confirm("¿Está seguro de que quiere borrar este Apunte?")
}

function borrar_cuenta() {
	if (form1.cuenta.value > 0)
	{
	return confirm("¿Está seguro de que quiere borrar este Subgrupo, Cuenta o Subcuenta?")
	}
	form1.cuenta.focus();
	return false
}

function oculta(div)
{
div.style.display="none";
} 
function amplred(div)
{
	if (document.getElementById(div).style.display == "none")
	{
		document.getElementById(div).style.display="";
	} else {
		document.getElementById(div).style.display="none";
	}
}

function redondea(n, deci) {
	var n1 = n * Math.pow(10, deci)
	var n2 = Math.round(n1)
	var n3 = n2 / Math.pow(10, deci)
	return decimales(n3, deci)
}

function decimales(n, deci) {
	
	var cadena = n.toString()
	var pos = cadena.indexOf(".")
	if (pos == -1) {
		decimal = 0
		cadena += deci > 0 ? "." : ""
	}
	else {
		decimal = cadena.length - pos - 1
	}
	var total = deci - decimal
	if (total > 0) {
		for (var conta = 1; conta <= total; conta++)
		cadena += "0"
	}
	return cadena
}

function compruebafecha(form1) {
	
/*	var mes31dias = /^([1-3]0|[0-2][1-9]|31|[0-9])\/(1|01|3|03|5|05|7|07|8|08|10|12)\/([0-1][0-9]|20)$/
	var mes30dias = /^([1-3]0|[0-2][1-9]|[0-9])\/(4|04|6|06|9|09|11)\/([0-1][0-9]|20)$/
	var mes28dias = /^([1-2]0|[0-2][1-8]|[0-1]9|[0-9])\/(02|2)\/(0[1-3]|0[5-7]|09|1[0-1]|1[3-5]|1[7-9])$/
	var mes29dias = /^([1-2]0|[0-2][1-9]|[0-9])\/(02|2)\/(00|04|08|12|16|20)$/

	if (!(mes31dias.test(form1.fecha.value) ||
		mes30dias.test(form1.fecha.value) ||
		mes29dias.test(form1.fecha.value) ||
		mes28dias.test(form1.fecha.value))) {
		alert("Contenido del campo FECHA no válido. Formato: dd/mm/aa")
		form1.fecha.focus()
		form1.fecha.select()
		return false
	}
	return true
	
*/
	var formato = /^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{2}$/i
	if (!(formato.test(form1.fecha.value))) {
		alert("Contenido del campo FECHA no válido. Formato: dd/mm/aa")
		form1.fecha.focus()
		form1.fecha.select()
		return false
	}

	var fecha = form1.fecha.value.split('/');
	var year = "20" + fecha[2];
	var day = fecha[0];
	var month = fecha[1];
	var date = new Date(year,month,'0');
	if(day > date.getDate()){
		alert("Contenido del campo FECHA no válido.")
		form1.fecha.focus()
		form1.fecha.select()
		return false
	}
	
   return true
       
}

function gceditcli(form1) {
	
	if (form1.cliente.value == "" || form1.domicilio.value == "" || form1.ciudad.value == "" || form1.telefono.value == "")
	{
		alert("Completar todos los campos")
		form1.cliente.focus()
		return false
	}
	return true
}

function gccli(form1) {
	
	if (form1.dni.value == "" || form1.cliente.value == "" || form1.domicilio.value == "" || form1.telefono.value == "" || form1.ciudad.value == "")
	{
		alert("Completar todos los campos")
		form1.cliente.focus()
		return false
	}
	return true
}

function gcprov(form1) {
	
	if (form1.proveed.value == "" || form1.direcci_n.value == "" || form1.tel_fono.value == "")
	{
		alert("Completar todos los campos")
		form1.proveed.focus()
		return false
	}
	return true
}

function gcaltafactemi(form1) {
	
	if (form1.n_.value == "") {
		alert("Campo Nº FACTURA obligatorio.")
		form1.n_.focus()
		return false
	}
	return compruebafecha(form1)
}

function gcaltafactemi1(form1) {

	form1.totfac.value = redondea(form1.totfac.value, 2)
	var totfacabs=form1.totfac.value
	form1.baseimp.value = totfacabs / form1.tipoiva.value
	form1.cuotaiva.value = totfacabs - form1.baseimp.value
	form1.baseimp.value = redondea(form1.baseimp.value, 2)
	form1.cuotaiva.value = redondea(form1.cuotaiva.value, 2)

}

function gcaltafactemi2(form1) {

	if (form1.totfac.value == "" || form1.baseimp.value == "" || form1.cuotaiva.value == "") {
		alert("Rellenar todos los campos.")
		return false
	}

}

function calculafacrec1(form1) {
	
	if (form1.totfac.value == 0 || isNaN(form1.totfac.value)) {
		form1.cuotaiva.value = ""
		form1.baseimp.value = ""
		alert("Total Factura no es numérico y distinto de cero.")
		form1.totfac.focus()
		form1.totfac.select()
		return false
	}
	
	form1.totfac.value = redondea(form1.totfac.value, 2)
	var totfacabs=form1.totfac.value
	
	/*if (totfacabs < 0) {
		totfacabs = 0 - totfacabs
	}*/
	form1.baseimp.value = totfacabs / form1.tipoiva.value
	form1.cuotaiva.value = totfacabs - form1.baseimp.value
	form1.baseimp.value = redondea(form1.baseimp.value, 2)
	form1.cuotaiva.value = redondea(form1.cuotaiva.value, 2)
	
}

function compruebacamposfacrec1(form1) {
	
	if (form1.asiento.value == "" || form1.fecha.value == "" || form1.proveedor1.value == "" || form1.cuengas1.value == "" || form1.numfac.value == "" || form1.totfac.value == "" || form1.baseimp.value == "" || form1.cuotaiva.value == "")
	{
		alert("Completa todos los campos")
		form1.asiento.focus()
		return false
	}
	if (form1.asiento.value > 9999999000) {
		alert("Nº Asiento ha de ser menor o igual que 9.999.999.000.")
		form1.asiento.focus()
		return false
	}
	if (isNaN(form1.totfac.value))
	{
		alert ("Total Factura ha de ser numérico")
		form1.totfac.focus()
		form1.totfac.select()
		return false
	}
	form1.totfac.value = redondea(form1.totfac.value, 2)
	/*form1.proveedor.value = form1.proveedor.substring(7,50)
	form1.cuengas.value = form1.cuengas.substring(7,50)*/
	return true
}

function calculafacemi1(form1) {
	
	if (form1.totfac.value == 0 || isNaN(form1.totfac.value)) {
		form1.cuotaiva.value = ""
		form1.baseimp.value = ""
		alert("Total Factura no es numérico y distinto de cero.")
		form1.totfac.focus()
		form1.totfac.select()
		return false
	}
	form1.totfac.value = redondea(form1.totfac.value, 2)
	var totfacabs=form1.totfac.value
	/*if (totfacabs < 0) {
		totfacabs = 0 - totfacabs
	}*/
	form1.baseimp.value = totfacabs / form1.tipoiva.value
	form1.cuotaiva.value = totfacabs - form1.baseimp.value
	
	form1.baseimp.value = redondea(form1.baseimp.value, 2)
	form1.cuotaiva.value = redondea(form1.cuotaiva.value, 2)
	
}

function compruebacamposfacemi1(form1) {
	
	if (form1.asiento.value == "" || form1.fecha.value == "" || form1.cliente1.value == "" || form1.cuening1.value == "" || form1.numfac.value == "" || form1.totfac.value == "" || form1.baseimp.value == "" || form1.cuotaiva.value == "")
	{
		alert("Completa todos los campos.")
		form1.asiento.focus()
		return false
	}
	if (form1.asiento.value > 9999999000) {
		alert("Nº Asiento ha de ser menor o igual que 9.999.999.000.")
		form1.asiento.focus()
		return false
	}
	if (isNaN(form1.totfac.value))
	{
		alert ("Total Factura ha de ser numérico.")
		form1.totfac.focus()
		form1.totfac.select()
		return false
	}

	form1.totfac.value = redondea(form1.totfac.value, 2)
	/*form1.proveedor.value = form1.proveedor.substring(7,50)
	form1.cuengas.value = form1.cuengas.substring(7,50)*/
	return true
}

function altaasi(form1) {
	
	if (form1.asiento.value == "" || form1.fecha.value == "" || form1.cuenta1.value == "" || form1.cuenta2.value == "" || form1.tipo.value == "" || form1.concepto.value == "" || form1.importe.value == "")
	{
		alert("Completa todos los campos.")
		form1.asiento.focus()
		return false
	}
	if (form1.asiento.value > 9999999000) {
		alert("Nº Asiento ha de ser menor o igual que 9.999.999.000.")
		form1.asiento.focus()
		return false
	}
	if (isNaN(form1.importe.value))
	{
		alert ("Importe ha de ser numérico.")
		form1.importe.focus()
		form1.importe.select()
		return false
	}

	form1.importe.value = redondea(form1.importe.value, 2)
	/*form1.proveedor.value = form1.proveedor.substring(7,50)
	form1.cuengas.value = form1.cuengas.substring(7,50)*/
	return true
}

function altaasigral(form1) {
	
	if (form1.asiento.value == "" || form1.fecha.value == "" || form1.cuenta1.value == "" || form1.tipo.value == "" || form1.concepto.value == "" || (form1.debe.value == "" && form1.haber.value == ""))
	{
		alert("Completa todos los campos.")
		form1.asiento.focus()
		return false
	}
	if (form1.asiento.value > 9999999000) {
		alert("Nº Asiento ha de ser menor o igual que 9.999.999.000.")
		form1.asiento.focus()
		return false
	}
	if (isNaN(form1.debe.value))
	{
		alert ("Debe ha de ser numérico.")
		form1.debe.focus()
		form1.debe.select()
		return false
	}
	if (isNaN(form1.haber.value))
	{
		alert ("Haber ha de ser numérico.")
		form1.haber.focus()
		form1.haber.select()
		return false
	}

	/*form1.importe.value = redondea(form1.importe.value, 2)*/
	form1.debe.value = redondea(form1.debe.value, 2)
	form1.haber.value = redondea(form1.haber.value, 2)
	return true
}


function seleccionacuentaeditasi2(form1) {
	form1.cuenta1.value = form1.cuenta.value
}

function seleccionacuengas(form1) {
	form1.apcuenta1.value = form1.apcuenta2.value.substring(0,8)
}

function seleccionacuengaseditcuen2(form1) {
	form1.subgrupo.value = form1.descripci1_.value.substring(0,2)
	form1.nuevosubgrupo.value = form1.subgrupo.value
	form1.nuevodescripci1_.value = form1.descripci1_.value.substring(3)
}

function seleccionacuengaseditcuen3(form1) {
	form1.cuenta.value = form1.descripci2_.value.substring(0,3)
	form1.nuevocuenta.value = form1.cuenta.value
	form1.nuevodescripci2_.value = form1.descripci2_.value.substring(4)
}

function seleccionacuengaseditcuen1(form1) {
	form1.subcuenta.value = form1.descripci3_.value.substring(0,8)
	form1.nuevosubcuenta.value = form1.subcuenta.value
	form1.nuevodescripci3_.value = form1.descripci3_.value.substring(9)
}

/********************** Alta Asiento simple y general ******************************/
function compruebafechaN(form1) {
	return compruebafecha(form1) && compruebacuenta(form1); 
}

function compruebafechaN2(form1) {
	return compruebafecha(form1) && compruebacuenta(form1) && compruebacuenta2(form1); 
}

function compruebacuenta(form1) {
	form1.cuenta11.value = form1.cuenta1.value;
	if (form1.cuenta11.value && form1.cuenta11.value == form1.cuenta1.value) {return true;}
	alert("Elige una Cuenta válida");return false;
}

function compruebacuenta2(form1) {
	form1.cuenta22.value = form1.cuenta2.value;
	if (form1.cuenta22.value && form1.cuenta22.value == form1.cuenta2.value) {return true;}
	alert("Elige una Cuenta válida");return false;
}

function seleccionacuenta10(form1)
{
	if (form1.cuenta1.value == "") {form1.cuenta1.value = form1.cuenta11.value;return true}
	form1.cuenta11.value = form1.cuenta1.value
}

function seleccionacuenta20(form1)
{
	if (form1.cuenta2.value == "") {form1.cuenta2.value = form1.cuenta22.value;return true}
	form1.cuenta22.value = form1.cuenta2.value
}

function seleccionacuenta1(form1)
{
	form1.cuenta1.value = form1.cuenta11.value
}

function seleccionacuenta2(form1) {
	form1.cuenta2.value = form1.cuenta22.value
}

/****************** Facturas recibidas *********************/
/*function seleccionaproveedorfacrec1(form1) {
	pos = form1.proveedor.value.split('*')
		if (pos[1] > 0)
		{
		form1.cuengas1.value = pos[1]
		form1.cuengas.value = pos[1]
		form1.totfac.value = pos[2]
		form1.totfac.focus()
		} else {
		form1.cuengas1.value =""
		form1.cuengas.selectedIndex = 0
		form1.totfac.value = ""
		}
	form1.proveedor1.value = pos[0]
}*/

function seleccionaproveedorfacrec0(form1) {
	if (form1.proveedor1.value == "") {form1.proveedor1.value = form1.proveedor.value;return true;}
	form1.proveedor.value = form1.proveedor1.value;
}

function seleccionacuengasfacrec0(form1) {
	if (form1.cuengas1.value == "") {form1.cuengas1.value = form1.cuengas.value;return true;}
	form1.cuengas.value = form1.cuengas1.value;
}

function seleccionaproveedorfacrec1(form1) {
	form1.proveedor1.value = form1.proveedor.value
}

function seleccionacuengasfacrec1(form1) {
	form1.cuengas1.value = form1.cuengas.value
}

function compruebafechaN4(form1) {
	return compruebafecha(form1) && compruebaprofr(form1) && compruebacugasfr(form1); 
}

function compruebaprofr(form1) {
	form1.proveedor.value = form1.proveedor1.value;
	if (form1.proveedor.value && form1.proveedor.value == form1.proveedor1.value) {return true;}
	alert("Elige una Cuenta válida");
	return false;
}

function compruebacugasfr(form1) {
	form1.cuengas.value = form1.cuengas1.value;
	if (form1.cuengas.value && form1.cuengas.value == form1.cuengas1.value) {return true;}
	alert("Elige una Cuenta válida");
	return false;
}

/******************** Facturas emitidas *************************/
function seleccionacliente0(form1) {
	if (form1.cliente1.value == "") {form1.cliente1.value = form1.cliente.value;return true;}
	form1.cliente.value = form1.cliente1.value;
}

function seleccionacliente(form1) {
	form1.cliente1.value = form1.cliente.value
}

function compruebafechaN3(form1) {
	return compruebafecha(form1) && compruebafe1(form1) && compruebafe2(form1); 
}

function compruebafe1(form1) {
	form1.cliente.value = form1.cliente1.value;
	if (form1.cliente1.value && form1.cliente1.value == form1.cliente.value) {return true;}
	alert("Elige una Cuenta válida");
	return false;
}

function compruebafe2(form1) {
	form1.cuening.value = form1.cuening1.value;
	if (form1.cuening1.value && form1.cuening1.value == form1.cuening.value) {return true;}
	alert("Elige una Cuenta válida");
	return false;
}

function seleccionacuening0(form1) {
	if (form1.cuening1.value == "") {form1.cuening1.value = form1.cuening.value;return true;}
	form1.cuening.value = form1.cuening1.value;
}

function seleccionacuening(form1) {
	form1.cuening1.value = form1.cuening.value
}
/**********************************************************************************/

function crearemp(form2){
	if (form2.empresa11.value == "" || form2.nuevaemp.value == "" || form2.anocont.value == "" || form2.usuario.value == "" || form2.clave.value == "" || form2.clave1.value == "")
	{
		alert("Completa todos los campos")
		return false
	}

	if (form2.clave.value != form2.clave1.value)
	{
		alert("No coincide clave con la confirmación de clave")
		return false
	}

	if (form2.anocont.value < 2000)
	{ 
		alert ("El año contable debe de ser mayor que 1999")
		return false 
	}
	document.getElementById('esperar').style.display = "";
	document.getElementById('confirma').style.display = "none";
	return true
}

function confirma(){
	if (form1.nuevosubcuenta.value == "" || form1.nuevodescripci3_.value == "")
	{
		alert("Nº de Subcuenta y Descripción no pueden estar vacíos")
		return false 
	}
	if (form1.nuevosubcuenta.value != form1.subcuenta.value)
	{
		return confirm("¿Está seguro de que quiere modificar la Subcuenta en fichero de Subcuentas y en los Asientos correspondientes?")
	}
	return true
}
function confirma1(){
	if (form1.nuevosubgrupo.value == "" || form1.nuevodescripci1_.value == "")
	{
		alert("Nº de Subgrupo y Descripción no pueden estar vacíos")
		return false 
	}
	
	if (form1.nuevosubgrupo.value != form1.subgrupo.value)
	{
	return confirm("¿Está seguro de que quiere modificar el Subgrupo en fichero de Subgrupos?")
	}
	return true
}
function confirma2(){
	if (form1.nuevocuenta.value == "" || form1.nuevodescripci2_.value == "")
	{
		alert("Nº de Subgrupo y Descripción no pueden estar vacíos")
		return false 
	}
	
	if (form1.nuevocuenta.value != form1.cuenta.value)
	{
		return confirm("¿Está seguro de que quiere modificar la Subcuenta en fichero de Cuentas?")
	}
	return true
}

function validar(form1){
	if (form1.cuenta1.value.length < 1)
	{
		alert ("No puedes dejar el campo CUENTA vacío.")
		form1.cuenta1.focus()
		return false 
	}
	
	if (form1.concepto.value.length < 1)
	{
		alert ("No puedes dejar el campo CONCEPTO vacío.")
		form1.concepto.focus()
		return false
	}
	
	if (form1.debe.value < 0 || form1.haber.value < 0 || (form1.debe.value != 0 && form1.haber.value != 0) || (form1.debe.value == 0 && form1.haber.value == 0) || isNaN(form1.debe.value) || isNaN(form1.debe.value)) 
	{
		alert ("Uno de los dos campos DEBE o HABER ha de tener un valor positivo, el otro ha de ser cero.")
		form1.debe.focus()
		return false 
	}

	/*form1.importe.value = redondea(form1.importe.value, 2)*/
	form1.debe.value = redondea(form1.debe.value, 2)
	form1.haber.value = redondea(form1.haber.value, 2)
	
}

function compruebacamposgcfacrec(form1) {
	
	if (form1.fact.value == "")
	{	
		alert("Campo Nº FACTURA obligatorio.")
		form1.fact.focus()
		return false
	}
	
	if (isNaN(form1.totfac.value))
	{
		alert("Campo TOTAL FACTURA ha de ser numérico.")
		form1.cuotaiva.value = ""
		form1.baseimp.value = ""
		form1.totfac.focus()
		form1.totfac.select()
		return false
	}
	
	/*if (form1.artic.value == "")
	{	
		alert("Campo ARTíCULO obligatorio.")
		form1.artic.focus()
		return false
	}*/
	
}

function calculagcfacrec(form1) {

	if (form1.totfac.value == 0 || isNaN(form1.totfac.value)) {
		form1.cuotaiva.value = ""
		form1.baseimp.value = ""
		alert("Total Factura no es numérico y distinto de cero.")
		form1.totfac.focus()
		form1.totfac.select()
		return false
	}
	
	form1.totfac.value = redondea(form1.totfac.value, 2)
	var totfacabs=form1.totfac.value
	
	/*if (totfacabs < 0) {
		totfacabs = 0 - totfacabs
	}*/
	form1.baseimp.value = totfacabs / form1.tipoiva.value
	form1.cuotaiva.value = totfacabs - form1.baseimp.value
	form1.baseimp.value = redondea(form1.baseimp.value, 2)
	form1.cuotaiva.value = redondea(form1.cuotaiva.value, 2)

}

function calcula1gcfacrec(form1) {
	
	form1.cuotaiva.value = form1.totfac.value - form1.baseimp.value
	form1.baseimp.value = redondea(form1.baseimp.value, 2)
	form1.cuotaiva.value = redondea(form1.cuotaiva.value, 2)
	form1.p_coste.value = redondea(form1.p_coste.value, 2)
	
}



function gcpedcli(form1) {
	
	if (form1.dni.value == "") {
		alert("Campo CLIENTE obligatorio.")
		form1.dni.focus()
		return false
	}
	
}

function compruebacamposgcpedidos(form1) {
	
	if (form1.n_ped.value == "")
	{
		alert("Campo Nº PEDIDO obligatorio.")
		form1.n_ped.focus()
		return false
	}
	
	if (form1.totpedido.value == "" || isNaN(form1.totpedido.value))
	{
		alert("Campo TOTAL PEDIDO obligatorio.")
		form1.totpedido.focus()
		form1.totpedido.select()
		return false
	}

	if (form1.artic.value == "")
	{
		alert("Campo ARTíCULO obligatorio.")
		form1.artic.focus()
		return false
	}

}

function busquedas(form1) {
	if (form1.tabla[0].checked && form1.asasiento1.value == "" && form1.asasiento2.value == "" && form1.astipo1.value == "" && form1.asfecha1.value == "" && form1.asfecha2.value == "" && form1.assuma1.value == "" && form1.assuma2.value == "")
	{ 
		alert("Elige alguna condición de búsqueda.")
		return false 
	}
	
	if (form1.tabla[1].checked && form1.apasiento1.value == "" && form1.apasiento2.value == "" && form1.apcuenta1.value == "" && form1.apfecha1.value == "" && form1.apfecha2.value == "" && form1.apimporte1.value == "" && form1.apimporte2.value == "" &&form1.apconcepto1.value == "")
	{ 
		alert("Elige alguna condición de búsqueda.")
		return false
	}
	
}

function cuengasbusquedas(form1) {
	pos = form1.apcuenta2.value.split('*')
	form1.apcuenta1.value = pos[0]
}

function validmoneda(anadir) {
	if (!isNaN(anadir.moneda.value) || isNaN(anadir.deci.value) || isNaN(anadir.cant.value) && (anadir.moneda.value == "" || anadir.cant.value == "" || anadir.deci.value == "" || anadir.simb.value == ""))
	{ 
		alert("Completa todos los campos. Equivalencia y Decimales han de ser variables numéricos")
		anadir.moneda.focus()
		return false 
	}
}

function hide(div)
{
document.getElementById(div).style.display = "none";
}

function show(div)
{
document.getElementById(div).style.display = "";
} 


window.onerror=myErrorHandler
function myErrorHandler() {
return true
}

function calcula(key, calcu) {

if (key == 'C'){
	calcu.valor1.value = "";
	calcu.vent.value = "";
	calcu.listado.value = calcu.listado.value + "\n";
	calcu.vent.focus();
	calcu.listado.scrollTop = 1000000;
	return true;
}

if (key == '='){
	if (calcu.vent.value == "") {return;}
	calcu.listado.value = calcu.listado.value + "\n" + calcu.vent.value + " = ";
	calcu.vent.value = eval (calcu.vent.value);
	calcu.listado.value = calcu.listado.value + calcu.vent.value;
	calcu.vent.focus();
	calcu.listado.scrollTop = 1000000
	return true;
}

calcu.vent.value = calcu.vent.value + key
calcu.vent.focus();
calcu.listado.scrollTop = 1000000
return true;


}
