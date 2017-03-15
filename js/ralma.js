$(document).ready(function(){
	obtenerCodMovimiento();
	actualizarTipoMovimiento('E');

	$('#btnConsulta').addClass('disabled');
	$('#btnGuardar').removeClass('disabled');
	$('#btnCancelar').removeClass('disabled');
	$('#btnNuevo').click(function(){
		$('#btnGuardar').removeClass('disabled');
		$('#btnCancelar').removeClass('disabled');

		$('#btnNuevo').addClass('disabled');
		//limpiarTablaMateriales();

		obtenerCodMovimiento();
		$('#swMov').val('N');
		$('#txtMovCod').attr('readonly','readonly');
	});

	$('#btnConsulta').click(function(){
		$('#btnGuardar').removeClass('disabled');
		$('#btnCancelar').removeClass('disabled');

		$('#btnNuevo').addClass('disabled');
		$('#btnConsulta').addClass('disabled');

		//$('#swMov').val('E');
		$('#txtMovCod').attr('readonly','readonly');
	});

	$('#btnCancelar').click(function(){
		$('#btnNuevo').removeClass('disabled');
		//$('#btnConsulta').removeClass('disabled');

		$('#btnGuardar').addClass('disabled');
		$('#btnCancelar').addClass('disabled');

		//$('#txtMovCod').removeAttr('readonly','');
		limpiarCampos();
		limpiarTablaMateriales();
	});
	
	$('#btnListaValores').click(function(){
		if(modal==1){ $('#modalBodegaOriginal').modal('show');
		}else if(modal==2){ $('#modalTipoMovimiento').modal('show');
		}else if(modal==3){ $('#modalBodegaDestino').modal('show');
		}else{ obtenerMateriales(); }
	});

	$('#txtEnCod').click(function(){ 
		modal=1;
		$('#txtEnNomb').val('');

		limpiarTablaMateriales();
	});
	
    $('#txtTipoMovCod').click(function(){ 
		modal=2;
		$('#txtTipoMovNomb').val('');
		$('#txtBodCod').val('');
		$('#txtBodNomb').val('');
		limpiarTablaMateriales();
	});
	
    $('#txtBodCod').click(function(){ 
		modal=3;
		$('#txtBodNomb').val('');
	});
	
	$("#txtEnCod").keypress(function(event){
		if(event.which == 13){
			cod = $.trim($('#txtEnCod').val());
			buscarBodegaPrincipal(cod);
		}
	});
	
    $("#txtBodCod").keypress(function(event){
		if(event.which == 13){
			cod = $.trim($('#txtBodCod').val());
			tip = $.trim($('#txtTipoMovCod').val());
			tipNom = $.trim($('#txtTipoMovNomb').val());
			if(tipNom!=''){
				buscarBodegaDestino(cod,tip);
			}else{
				alert('Porfavor coloque un tipo de movimiento valido')
			}
		}
	});
	
    $("#txtTipoMovCod").keypress(function(event){
		if(event.which == 13){
			cod = $.trim($('#txtTipoMovCod').val());
			tipo = $.trim($('#txtSWTipoMovCod').val());
			buscarTipoMovimiento(cod,tipo);
		}
	});

	$('#btnGuardar').click(function(){
		calcularMateriales()
		var swMov = $('#swMov').val();
		if(swMov=="N"){
			codMov = $('#txtMovCod').val();
			fecha  = $('#txtFecha').val();
			codEn  = $('#txtEnCod').val();
			nomEn  = $('#txtEnNomb').val();
			valor  = $('#txtValor').val();
			codTip = $('#txtTipoMovCod').val();
			nomTip = $('#txtTipoMovNomb').val();
			codBod = $('#txtBodCod').val();
			nomBod = $('#txtBodNomb').val();
			sop = $('#txtSopCod').val();
			docSop = $('#txtDocSopCod').val();
			obs = $('#txtObser').val();

			if( (codMov!='') && (fecha!='') && (codEn!='') && (nomEn!='') && (valor!='') &&  
				(codTip!='') && (nomTip!='') && (codBod!='') && (nomBod!='') ){
					$.ajax({
				        type:'POST',
				        url:'proc/ralma_proc.php?accion=guardar_movimiento_inventario',
				        data:{ codMov:codMov, fecha:fecha, codEn:codEn, nomEn:nomEn, valor:valor, codTip:codTip,
				        		nomTip:nomTip, codBod:codBod, nomBod:nomBod, sop:sop, docSop:docSop,
				        		obs:obs
				        	 },
				        success: function(data){
				        	if(data==1){
				        		guardarMaterialesMovimiento(codMov,codTip);
				        		limpiarCampos();
				        		obtenerCodMovimiento();
				        		alert('Se genero el movimiento con exito')
							}
				        }
				    });
			}else{
				alert('Porfavor complete los datos')
			}
		}
	});
});

function guardarMaterialesMovimiento(codMov,codTip){
	var cont = $('#contRow').val();
	for(var i=1;i<=cont;i++){
		var cod = $('#txtCod'+i).val();
		var nom = $.trim($('#txtCod'+i).val());
		var can = $('#txtCant'+i).val();
		var val = $('#txtVal'+i).val();
		
		if( (cod!='') && (nom!='')){
			var tipo = $('#txtSWTipoMovCod').val();
			var bodO = $('#txtEnCod').val();
			var bodD = $('#txtBodCod').val();

			//alert("Codigo Tipo Movimiento: "+codTip)
			$.ajax({
		        type:'POST',
		        url:'proc/ralma_proc.php?accion=guardar_materiales_movimiento_inventario',
		        data:{ codMov:codMov, cod:cod, can:can, val:val, tipo:tipo, bodO:bodO, bodD:bodD, codTip:codTip },
		        success: function(data){
		        	//alert(data)
		        }
		    });
		}
	}
	limpiarTablaMateriales();
}
/*
BACKGROUND-COLOR ALERTAS
	AZUL = 1
	VERDE = 2
	NARANJA = 3
	ROJO = 4
*/
var modal = 1;
function actualizarTipoMovimiento(tipo){
	$.ajax({
        type:'POST',
        url:'proc/ralma_proc.php?accion=actualizar_tipo_movimiento',
        data:{tipo:tipo},
        success: function(data){
        	$('#txtSWTipoMovCod').val(tipo);
        	$('#txtTipoMovCod').val('');
        	$('#txtTipoMovNomb').val('');
        	$('#txtBodCod').val('');
			$('#txtBodNomb').val('');
        	$('#divTipoMov').html(data);
        }
    });	
}
function nuevoMaterial(){
	//Agregar una nueva fila a la tabla
	var table = document.getElementById('table_materiales');
    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);
    row.className = 'trDefault';
    row.id = 'trSelect'+rowCount;

    //Codigo
    var cell1 = row.insertCell(0);
    cell1.className = 'text-center';
    cell1.innerHTML = '<input type="text" id="txtCod'+rowCount+'" class="form-control input-sm text-center" onkeypress="solonumerosEnter()" onClick="swModal(4,'+rowCount+')"><input type="hidden" id="txtTipo'+rowCount+'" value="0">';
    //Nombre
    var cell2 = row.insertCell(1);
    cell2.className = '';
    cell2.innerHTML = '<input type="text" id="txtNomb'+rowCount+'" class="form-control input-sm" onClick="swModal(4,'+rowCount+')" readonly>';

    var cell3 = row.insertCell(2);
    cell3.className = '';
    cell3.innerHTML = '<input type="text" id="txtCant'+rowCount+'" class="form-control input-sm text-center" onkeypress="solonumeros_calcular('+rowCount+')" onClick="swModal(4,'+rowCount+')">';

    var cell4 = row.insertCell(3);
    cell4.className = '';
    cell4.innerHTML = '<input type="text" id="txtVal'+rowCount+'" class="form-control input-sm text-right" onkeypress="solonumerosEnter()">';

    $('#contRow').val(rowCount);
}
function obtenerMateriales(){
	bod = $.trim($('#txtEnCod').val());
	nom = $.trim($('#txtEnNomb').val());
	if( (bod!='') && (nom!='') ){
		$.ajax({
	        type:'POST',
	        url:'proc/ralma_proc.php?accion=obtener_materiales',
	        data:{ bod:bod },
	        success: function(data){
	        	$('#divModalMateriales').html(data);
	        	$('#modalMaterial').modal('show');
	        }
	    });
	}else{
		alert('Porfavor coloque una bodega valida')
	}
}
function obtenerCodMovimiento(){
	$.ajax({
        type:'POST',
        url:'proc/ralma_proc.php?accion=obtener_cod_movimiento',
        data:{cod:'1'},
        success: function(data){
        	$('#txtMovCod').val(data);
        }
    });
}
function calcularMateriales(){
	var cont = $('#contRow').val();
	var sum = 0;
	for(var i=1;i<=cont;i++){
		var cod = $.trim($('#txtCod'+i).val());
		var val = $('#txtVal'+i).val();
		if(val==''){ val = 0; }
		sum = parseInt(sum) + parseInt(val);
	}
	$('#txtValor').val(number_format(sum,0));
}
function calcularMaterial(codMat,cantMat,rowCount){
	bod = $("#txtEnCod").val(); //bodega origen
	tMo = $("#txtTipoMovCod").val(); //cod tipo movimiento
	des = $('#txtBodCod').val(); //bodega destino
	$.ajax({
		type:'POST',
		url:'proc/ralma_proc.php?accion=calcular_material',
		data:{ bod:bod, codMat:codMat, cantMat:cantMat, tMo:tMo, des:des },
		dataType: 'json',
		success: function(data){
			alert(data)
			demo.showNotification('bottom','left', 'msgError', 4);

			/*if(data[0]==2){
				alert('No tiene cantidad sufuciente para realizar esta operacion')
				$('#txtCant'+rowCount).val('');
				$('#txtVal'+rowCount).val('');
			}else{
				$('#txtVal'+rowCount).val(data[1]);
			}
			calcularMateriales();*/
		}
	});
}
//BUSCAR
function buscarBodegaPrincipal(bod){
	if( (bod!='') ){
		$.ajax({
	        type:'POST',
	        url:'proc/ralma_proc.php?accion=buscar_bodega_principal',
	        data:{ bod:bod },
	        success: function(data){
	        	$('#txtEnNomb').val(data);
				$('#txtTipoMovCod').focus();
	        }
	    });
	}else{
		alert('Porfavor coloque una bodega valida')
	}
}
function buscarBodegaDestino(bod,tipo){
	if( (bod!='') ){
		$.ajax({
	        type:'POST',
	        url:'proc/ralma_proc.php?accion=buscar_bodega_destino',
	        data:{ bod:bod, tipo:tipo },
	        success: function(data){
	        	$('#txtBodNomb').val(data);
				$('#txtSopCod').focus();
	        }
	    });
	}else{
		alert('Porfavor coloque una bodega valida')
	}
}
function buscarTipoMovimiento(cod,tipo){
	if( (cod!='') ){
		$.ajax({
	        type:'POST',
	        url:'proc/ralma_proc.php?accion=buscar_tipo_movimiento',
	        data:{ cod:cod, tipo:tipo },
	        success: function(data){
	        	$('#txtTipoMovNomb').val(data);
				$('#txtBodCod').focus();
	        	actualizarBodegaDestino(cod);
	        }
	    });
	}else{
		alert('Porfavor coloque una bodega valida')
	}
}
function validarMaterial(mat,ident){
	$('#txtCod'+ident).val('');
	var cont = $('#contRow').val();
	var swMat = false;
	for(var i=1;i<=cont;i++){
		var codAct = $.trim($('#txtCod'+i).val());
		if(codAct == mat){ swMat = true; }
	}
	if(!swMat){
		buscarMaterial(mat);
	}else{ alert('El material ya existe') }
}
function buscarMaterial(mat){
	bod = $('#txtEnCod').val();
	if( (mat!='') && (bod!='') ){
		$.ajax({
	        type:'POST',
	        url:'proc/ralma_proc.php?accion=buscar_material',
	        data:{ mat:mat, bod:bod },
	        dataType: 'json',
	        success: function(data){
	        	ident = $('#selectRow').val();
	        	$('#txtCod'+ident).val(mat);
	        	$('#txtNomb'+ident).val(data[0]);
				$('#txtCant'+ident).val(0);
				$('#txtVal'+ident).val(0);
				$('#modalMaterial').modal('hide');
				//calcularMateriales();
	        }
	    });
	}else{
		alert('Porfavor coloque una bodega valida')
	}
}
//ADD
function addBodegaOrig(cod,bod){
	$('#txtEnCod').val(cod);
	$('#txtEnNomb').val(bod);
	$('#modalBodegaOriginal').modal('hide');
}
function addBodegaDesti(cod,bod){
	$('#txtBodCod').val(cod);
	$('#txtBodNomb').val(bod);
	$('#modalBodegaDestino').modal('hide');
}
function addTipoMovimiento(cod,mov){
	$('#txtTipoMovCod').val(cod);
	$('#txtTipoMovNomb').val(mov);
	$('#modalTipoMovimiento').modal('hide');
	actualizarBodegaDestino(cod);
}
function addMaterial(cod,mat,cant,val){
	validarMaterial(cod,ident);
	//$('#txtCod'+ident).val(cod);
	//$('#txtNomb'+ident).val(mat);
	//$('#txtCant'+ident).val(cant);
	//$('#txtVal'+ident).val(val);
	//$('#modalMaterial').modal('hide');
	//calcularMateriales();
}
function actualizarBodegaDestino(tipo){
	$.ajax({
        type:'POST',
        url:'proc/ralma_proc.php?accion=actualizar_bodega_destino',
        data:{ tipo:tipo },
        success: function(data){
        	$('#divBodDest').html(data);
        }
    });
}
var ident = 0;
function swModal(mod,id){
	ident = id;
	modal = 4;
	$('#selectRow').val(id);
	/*$('#txtCod'+ident).val('');
	$('#txtNomb'+ident).val('');
	$('#txtCant'+ident).val('');
	$('#txtVal'+ident).val('');*/

	calcularMateriales();
}
function solonumeros(){
    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
        event.returnValue = false;
}
function solonumerosEnter(){
	ident = $('#selectRow').val();
	mat = $('#txtCod'+ident).val();
	if(event.which == 13){
		validarMaterial(mat,ident);
	}else{
	    if( (event.keyCode < 48) || (event.keyCode > 57) )
	        event.returnValue = false;
	}
}
function solonumeros_calcular(rowCount){
	//ident = $('#selectRow').val();
	if(event.which == 13){
		codMat = $('#txtCod'+rowCount).val();
		cantMat = $('#txtCant'+rowCount).val();
		calcularMaterial(codMat,cantMat,rowCount);
	}else{
	    if( (event.keyCode < 48) || (event.keyCode > 57) )
	        event.returnValue = false;
	}
}
function number_format(amount,decimals){

    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

    decimals = decimals || 0; // por si la variable no fue fue pasada

    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0) 
        return parseFloat(0).toFixed(decimals);

    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);

    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;

    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + '.' + '$2');

    return amount_parts.join('.');
}
function limpiarTablaMateriales(){
	a = '<table id="table_materiales" class="table table-bordered table-condensed">';
	b = '<thead><tr style="background-color: #3c8dbc; color:white;">';
	c = '<th class="text-center" width="100">MATERIAL</th>';
	d = '<th class="">DESCRIPCION DEL MATERIAL</th>';
	e = '<th class="text-center" width="100">CANTIDAD</th>';
	f = '<th class="text-right" width="170">VALOR</th></tr></thead>';
	g = '<tbody id="divMaterialInventario"></tbody></table>';
	$('#tableOrdenes').html(a+b+c+d+e+f+g);

	$('#txtValor').val(0);
}
function limpiarCampos(){
	actualizarTipoMovimiento('E');
	a = '<input type="radio" name="tipoMov" onclick="actualizarTipoMovimiento(\'E\');" checked> Entrada &nbsp;&nbsp;&nbsp;&nbsp;';
	b = '<input type="radio" name="tipoMov" onclick="actualizarTipoMovimiento(\'S\');"> Salida';
	c = '<input type="hidden" id="txtSWTipoMovCod" value="E">';
	$('#divTipoMovimientoCheck').html(a+b+c);
	//$('#swMov').val('');
	//$('#txtMovCod').val('');
	$('#txtEnCod').val('');
	$('#txtEnNomb').val('');
	$('#txtValor').val(0);
	$('#txtTipoMovCod').val('');
	$('#txtTipoMovNomb').val('');
	$('#txtBodCod').val('');
	$('#txtBodNomb').val('');
	$('#txtSopCod').val('');
	$('#txtDocSopCod').val('');
	$('#txtObser').val('');
}