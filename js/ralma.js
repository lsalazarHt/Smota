$(document).ready(function(){

	$(document).ajaxStart(function () { 
		$.blockUI({
			message: "Un momento por favor....",
			css: { 
	            border: 'none', 
	            padding: '15px', 
	            backgroundColor: '#000', 
	            '-webkit-border-radius': '10px', 
	            '-moz-border-radius': '10px', 
	            opacity: .5, 
	            color: '#fff' 
	        } })
	}).ajaxStop($.unblockUI);
	
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
		}else if(modal==4){ $('#modalDocSoporte').modal('show');
		}else if(modal==5){ $('#modalMaterial').modal('show'); }
	});

	$('#txtEnCod').focus(function(){ 
		modal=1;
		$('#txtEnNomb').val('');
		$('#txtTipoMovCod').val('');
		$('#txtTipoMovNomb').val('');
		$('#txtBodCod').val('');
		$('#txtBodNomb').val('');
		$('#txtSopCod').val('');
		$('#txtSopNomb').val('');
		$('#txtDocSopCod').val('');
		$("#txtDocSopCod").prop("readonly",false);
		limpiarTablaMateriales();
	});
	$("#txtEnCod").keypress(function(event){
		if(event.which == 13){
			cod = $.trim($('#txtEnCod').val());
			buscarBodegaPrincipal(cod);
		}
	});
	
    $('#txtTipoMovCod').focus(function(){ 
		modal=2;
		$('#txtTipoMovNomb').val('');
		$('#txtBodCod').val('');
		$('#txtBodNomb').val('');
		$('#txtSopCod').val('');
		$('#txtSopNomb').val('');
		$('#txtDocSopCod').val('');
		$("#txtDocSopCod").prop("readonly",false);
		limpiarTablaMateriales();
	});
	$("#txtTipoMovCod").keypress(function(event){
		if(event.which == 13){
			cod = $.trim($('#txtTipoMovCod').val());
			tipo = $.trim($('#txtSWTipoMovCod').val());
			buscarTipoMovimiento(cod,tipo);
		}
	});
	
    $('#txtBodCod').focus(function(){ 
		modal=3;
		$('#txtBodNomb').val('');
	});
	$("#txtBodCod").keypress(function(event){
		if(event.which == 13){
			cod = $.trim($('#txtBodCod').val());
			tip = $.trim($('#txtTipoMovCod').val());
			tipNom = $.trim($('#txtTipoMovNomb').val());
			if(tipNom!=''){
				buscarBodegaDestino(cod,tip);
			}else{
				demo.showNotification('bottom','left', 'Porfavor coloque un tipo de movimiento valido', 4);
			}
		}
	});

	$("#txtDocSopCod").keypress(function(event){
		if(event.which == 13){
			codSop = $.trim($('#txtSopCod').val());
			docSop = $.trim($('#txtDocSopCod').val());
			bodDes = $.trim($('#txtBodCod').val());
			bodNom = $.trim($('#txtBodNomb').val());
			
			if( (codSop!='0') && (docSop!='') && (bodNom!='') ){
				validarDocumentoSoporte(codSop,docSop,bodDes);
			}else{
				if(codSop=='0'){
					demo.showNotification('bottom','left', 'Este campo no es requerido', 4);
				}else{
					if(bodNom == ''){
						demo.showNotification('bottom','left', 'Por favor coloque una bodega valida', 4);
					}else{
						demo.showNotification('bottom','left', 'Por favor coloque un documento valido', 4);
						$('#txtDocSopCod').val('');
					}
				}
			}
		}
	});

	$('#btnGuardar').click(function(){
		calcularMateriales()
		var swMov = $('#swMov').val();
		if(swMov=="N"){
			codMov  = $('#txtMovCod').val();
			fecha   = $('#txtFecha').val();
			codEn   = $('#txtEnCod').val();
			nomEn   = $('#txtEnNomb').val();
			valor   = $('#txtValor').val();
			codTip  = $('#txtTipoMovCod').val();
			nomTip  = $('#txtTipoMovNomb').val();
			codBod  = $('#txtBodCod').val();
			nomBod  = $('#txtBodNomb').val();
			sop 	= $('#txtSopCod').val();
			docSop  = $('#txtDocSopCod').val();
			obs 	= $('#txtObser').val();

			if( (codMov!='') && (fecha!='') && (codEn!='') && (nomEn!='') && (valor!='') &&  
				(codTip!='') && (nomTip!='') && (codBod!='') && (nomBod!='') ){
					sw = true;
					if( (sop!=0) && (docSop=='') ){
						sw = false;
					}else{ sw = true; }

					//todo bien
					if(sw){
						if( (!validarMateriales) && (!validarMateriales_sop) ){
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
										demo.showNotification('bottom','left', 'Se genero el movimiento con exito', 2);
										window.open('calma_report.php?id='+codMov, "Imprimir Movimiento", "width=1200, height=620");
									}
								}
							});
						}else{
							demo.showNotification('bottom','left', 'Porfavor verifique los materiales', 4);
						}
					}else{
						demo.showNotification('bottom','left', 'Porfavor complete los datos', 4);
					}
			}else{
				demo.showNotification('bottom','left', 'Porfavor complete los datos', 4);
			}
		}
	});

	$('#txtDocSopCod').focus(function(){ 
		modal=4;
		cargarDocumentoSoporte();
	});

});

function guardarMaterialesMovimiento(codMov,codTip){
	var cont = $('#contRow').val();
	for(var i=1;i<=cont;i++){
		var cod = $('#txtCod'+i).val();
		var nom = $.trim($('#txtCod'+i).val());
		var can = $('#txtCant'+i).val();
		var val = $('#txtVal'+i).val();
		
		if( (cod!='') && (nom!='') && (val!=0)){
			var tipo = $('#txtSWTipoMovCod').val();
			var bodO = $('#txtEnCod').val();
			var bodD = $('#txtBodCod').val();

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
var validarMateriales = false;
var validarMateriales_sop = false;
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
			$('#txtSopCod').val('');
			$('#txtDocSopCod').val('');
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


	//validar tipo de trabajo
		sw_tipo_movi = true;
	//
	clBod = $('#req_doc_prove_gas').val();
	if((clBod==5) && (clBod==6)){ //bodega proveedor(5), bodega gas caribe(6)
		readonly = 'readonly';
	}else{
		readonly = '';
	}


    var cell4 = row.insertCell(3);
    cell4.className = '';
    cell4.innerHTML = '<input type="text" id="txtVal'+rowCount+'" class="form-control input-sm text-right"' +readonly+'>';

    $('#contRow').val(rowCount);
	$('#txtCod'+rowCount).focus();
	selectedNewRow(row.id);
	$('#selectRow').val(rowCount);
}
//actualizar modal materiales
function obtenerMateriales(){
	bod = $.trim($('#txtEnCod').val());
	nom = $.trim($('#txtEnNomb').val());
	bodD = $("#txtBodCod").val();
	if( (bod!='') && (nom!='') ){
		$.ajax({
	        type:'POST',
	        url:'proc/ralma_proc.php?accion=obtener_materiales',
	        data:{ bod:bod, bodD:bodD },
	        success: function(data){
	        	$('#divModalMateriales').html(data);
	        	//$('#modalMaterial').modal('show');
	        }
	    });
	}else{
		demo.showNotification('bottom','left', 'Porfavor coloque una bodega valida', 4);
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
		sum = parseFloat(sum) + parseFloat(val);
	}
	$('#txtValor').val(sum);
}
function calcularMaterial(codMat,cantMat,rowCount){
	//reiniciar validadores de materiales
	validarMateriales = false;
	validarMateriales_sop = false;

	bod = $("#txtEnCod").val(); //bodega origen
	tMo = $("#txtTipoMovCod").val(); //cod tipo movimiento
	des = $('#txtBodCod').val(); //bodega destino

	sop = $('#txtSopCod').val(); // soporte 
	doc = $('#txtDocSopCod').val(); //documento de soporte

	if( (sop!=0) && (doc!=0) ){ //validar que sea material de soporte
		$.ajax({
			type:'POST',
			url:'proc/ralma_proc.php?accion=calcular_material_soporte',
			data:{ sop:sop, doc:doc, codMat:codMat, cantMat:cantMat },
			dataType: 'json',
			success: function(data){
				//console.log(data)
				if(data[0]==2){ // exito
					validarMateriales_sop = false;
					$('#txtVal'+rowCount).val(data[1]);
				}else if(data[0]==1){ //cantidad de material invalida
					validarMateriales_sop = true;
					demo.showNotification('bottom','left', 'La cantidad es mayor a la ingresada en el documento de soporte', 4);
					$('#txtCant'+rowCount).val('');
					$('#txtVal'+rowCount).val('');
				}else if(data[0]==0){ //material no es valido
					validarMateriales_sop = true;
					demo.showNotification('bottom','left', 'El material no se encuentra en el documetno de soporte', 4);
					$('#txtCod'+rowCount).val('');
					$('#txtNomb'+rowCount).val('');
					$('#txtCant'+rowCount).val('');
					$('#txtVal'+rowCount).val('');
				}
				calcularMateriales();
			}
		});
	}else{ //validar material sin soporte
		$.ajax({
			type:'POST',
			url:'proc/ralma_proc.php?accion=calcular_material',
			data:{ bod:bod, codMat:codMat, cantMat:cantMat, tMo:tMo, des:des },
			dataType: 'json',
			success: function(data){
				//console.log(data)
				if(data[0]==2){
					validarMateriales = true;
					demo.showNotification('bottom','left', 'La bodega de origen no tiene cantidad sufuciente para realizar esta operacion', 4);
					//$('#txtCant'+rowCount).val(0);
					$('#txtVal'+rowCount).val(0);
				}else if(data[0]==3){
					validarMateriales = true;
					demo.showNotification('bottom','left', 'La bodega destino no tiene el cupo disponible para realizar esta operacion', 4);
					$('#txtVal'+rowCount).val(0);
				}else if(data[0]==4){
					$('#txtVal'+rowCount).val('');
					$('#txtVal'+rowCount).focus();
				}else{
					validarMateriales = false;
					$('#txtVal'+rowCount).val(data[1]);
				}
				calcularMateriales();
			}
		});
	}
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
				if(data!=''){
					$('#txtTipoMovCod').focus();
				}
	        }
	    });
	}else{
		demo.showNotification('bottom','left', 'Porfavor coloque una bodega valida', 4);
	}
}
function buscarBodegaDestino(bod,tipo){
	if( (bod!='') ){
		$.ajax({
	        type:'POST',
	        url:'proc/ralma_proc.php?accion=buscar_bodega_destino',
	        data:{ bod:bod, tipo:tipo },
	        success: function(data){
				//obtenerMateriales();
	        	$('#txtBodNomb').val(data);
				if(data!=''){
	        		sop = $('#txtSopCod').val();
					if( sop !=0 ){
						$('#txtDocSopCod').focus();
					}else{
						$('#txtObser').focus();						
					}
				}
				cargarDocumentoSoporte();
	        }
	    });
	}else{
		demo.showNotification('bottom','left', 'Porfavor coloque una bodega valida', 4);
	}
}
function buscarTipoMovimiento(cod,tipo){
	if( (cod!='') ){
		$.ajax({
	        type:'POST',
	        url:'proc/ralma_proc.php?accion=buscar_tipo_movimiento',
	        data:{ cod:cod, tipo:tipo },
			dataType: 'json',
	        success: function(data){
	        	$('#txtTipoMovNomb').val(data[0]);
	        	$('#txtSopCod').val(data[1]);
	        	$('#txtSopNomb').val(data[3]);
	        	$('#req_doc_prove_gas').val(data[2]);
				if( data[0]!='' ){
					$('#txtBodCod').focus();
					//verificar_documento_soporte(cod)
				}
				if(data[1]==0){
					$("#txtDocSopCod").prop("readonly",true);
				}else{
					$("#txtDocSopCod").prop("readonly",false);
				}
	        	actualizarBodegaDestino(cod);
	        }
	    });
	}else{
		demo.showNotification('bottom','left', 'Porfavor coloque una bodega valida', 4);
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
	}else{ 
		demo.showNotification('bottom','left', 'El material ya existe', 4);
	}
}
function buscarMaterial(mat){
	bod = $('#txtEnCod').val();
	bodD = $('#txtBodCod').val();

	sop = $('#txtSopCod').val();
	doc = $('#txtDocSopCod').val();

	if( (sop!=0) && (doc!=0) ){ //validar que sea material de soporte
		if( (mat!='') && (bod!='') && (bodD!='') ){
			$.ajax({
				type:'POST',
				url:'proc/ralma_proc.php?accion=buscar_material_soporte',
				data:{ mat:mat, doc:doc },
				dataType: 'json',
				success: function(data){
					//console.log(data)
					if(data[0]==0){
						ident = $('#selectRow').val();
						$('#txtCod'+ident).val(data[1]);
						$('#txtNomb'+ident).val(data[2]);
						$('#txtCant'+ident).val('');
						$('#txtVal'+ident).val('');
						if(data[2]!=''){
							$('#txtCant'+ident).focus();
						}
						$('#modalMaterial').modal('hide');
					}else{
						demo.showNotification('bottom','left', 'El material no se encuentra en el documeto de soporte', 4);
						$('#txtNomb'+ident).val('');
					}
				}
			});
		}else{
			demo.showNotification('bottom','left', 'Por favor coloque una bodega valida', 4);
		}
	}else{ //material sin soporte
		if( (mat!='') && (bod!='') && (bodD!='') ){
			$.ajax({
				type:'POST',
				url:'proc/ralma_proc.php?accion=buscar_material',
				data:{ mat:mat, bod:bod, bodD:bodD },
				dataType: 'json',
				success: function(data){
					//alert(data)
					ident = $('#selectRow').val();
					$('#txtCod'+ident).val(mat);
					$('#txtNomb'+ident).val(data[0]);
					$('#txtCant'+ident).val('');
					$('#txtVal'+ident).val('');
					if(data[0]!=''){
						$('#txtCant'+ident).focus();
					}
					$('#modalMaterial').modal('hide');
					//calcularMateriales();
				}
			});
		}else{
			demo.showNotification('bottom','left', 'Porfavor coloque una bodega valida', 4);
		}
	}
}
function validarDocumentoSoporte(sop,doc,bodDes){
	$.ajax({
		type:'POST',
		url:'proc/ralma_proc.php?accion=validar_documento_soporte',
		data:{ sop:sop, doc:doc, bodDes:bodDes },
		success: function(data){
			//console.log(data)
			if(data==0){
				$('#txtObser').focus();
				buscarMaterialesDocumentosSoporte();
			}else{
				demo.showNotification('bottom','left', 'Por favor coloque un documento valido para este soporte', 4);
			}
		}
	});
}
function buscarMaterialesDocumentosSoporte(){
	docSop = $('#txtDocSopCod').val();
	$.ajax({
		type:'POST',
		url:'proc/ralma_proc.php?accion=obtener_materiales_documento_soportes',
		data:{ docSop:docSop },
		success: function(data){
			$('#divModalMateriales').html(data);
		}
	});
}
function addMaterial_doc(codMat){

}
function cargarDocumentoSoporte(){
	bodDes = $('#txtBodCod').val(); 
	tipSop = $('#txtSopCod').val();

	if( (bodDes!='') && (tipSop!='') ){
		$.ajax({
	        type:'POST',
	        url:'proc/ralma_proc.php?accion=actualizar_documentos_soporte',
	        data:{ bodDes:bodDes, tipSop:tipSop },
	        success: function(data){
				$('#divModalDocSoporte').html(data);
	        }
	    });
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
function addTipoMovimiento(cod,mov,sop){
	$('#txtTipoMovCod').val(cod);
	$('#txtTipoMovNomb').val(mov);
	$('#txtSopCod').val(sop);
	$('#modalTipoMovimiento').modal('hide');
	//verificar_documento_soporte();
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
//quitar material
function deleteMaterial(){
	id = $('#contRow').val();
	$('#trSelect'+id).remove();
	$('#contRow').val(parseInt(id)-1);
}
var ident = 0;
function verificar_documento_soporte(cod){
	$.ajax({
        type:'POST',
        url:'proc/ralma_proc.php?accion=verificar_documento_soporte',
        data:{ cod:cod },
        success: function(data){
        	$('#req_doc_soport').val(data);
        }
    });
	$.ajax({
        type:'POST',
        url:'proc/ralma_proc.php?accion=verificar_tipo_movi_provve',
        data:{ cod:cod },
        success: function(data){
        	$('#req_doc_prove_gas').val(data);
        }
    });
}
function swModal(mod,id){
	ident = id;
	//validar materiales a mostrar
	sop = $('#txtSopCod').val();
	doc = $('#txtDocSopCod').val();

	if( (sop!='') && (doc!='') ){
		buscarMaterialesDocumentosSoporte();
	}else{
		obtenerMateriales();
	}
	modal = 5;
	$('.trDefault').removeClass('trSelect');
	$('#trSelect'+id).addClass('trSelect');
	//console.log(id);
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
function solonumerosEnter(){ //add material
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
	$("#txtDocSopCod").prop("readonly",false);
}
function addDocumentoSoporte(cod){
	$('#txtDocSopCod').val(cod);
	$('#modalDocSoporte').modal('hide');
}

function atajos_teclado(e){
    tecla=(document.all) ? e.keyCode : e.which; 
	if(tecla==71 && e.altKey){
		$('#btnGuardar').click();
	}else if (tecla==77 && e.altKey){ //agregar nuevo material
    	nuevoMaterial();
		modal = 5;
	}else if(tecla==78 && e.altKey){ //quitar ultimo material
		deleteMaterial();
		modal = 5;
	}
}