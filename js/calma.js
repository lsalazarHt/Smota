$(document).ready(function(){
	
    $('#btnEditor').addClass('disabled'); //deshabilitar editor
    $('#btnCancelar').removeClass('disabled'); //deshabilitar editor
	
    $('#btnListaValores').click(function(){
        if(modal==1){ $('#modalBodegaOriginal').modal('show'); //bodega origen
		}else if(modal==2){ // tipo de movimiento
			tipo = $.trim($('#txtSwTipoMov').val());
			if(tipo!=''){
				actualizarTipoMovimiento(tipo);
			}else{
				demo.showNotification('bottom','left', 'Por favor seleccione un tipo de movimiento', 4);
			}
		}else if(modal==3){ $('#modalBodegaDestino').modal('show');
		}else if(modal==4){ $('#modalTipoMovimientoSop').modal('show'); }
    });

	$('#txtEnCod').click(function(){ 
		modal=1;
		$('#txtEnNomb').val('');
		limpiarTablaMateriales();
	});
	$("#txtEnCod").keypress(function(event){
		if(event.which == 13){
			cod = $.trim($('#txtEnCod').val());
			buscarBodegaPrincipal(cod);
		}
	});
	
    $('#txtTipoCod').click(function(){ 
		modal=2;
		$('#txtTipoNomb').val('');
		limpiarTablaMateriales();
		
	});
	$("#txtTipoCod").keypress(function(event){
		if(event.which == 13){
			cod = $.trim($('#txtTipoCod').val());
			tipo = $.trim($('#txtSwTipoMov').val());
			if(tipo!=''){
				buscarTipoMovimiento(cod,tipo);
			}else{
				demo.showNotification('bottom','left', 'Por favor seleccione un tipo de movimiento', 4);
			}
		}
	});
	
    $('#txtBodCod').focus(function(){ 
		modal=3;
		$('#txtBodNomb').val('');
	});
	$("#txtBodCod").keypress(function(event){
		if(event.which == 13){
			cod = $.trim($('#txtBodCod').val());
			buscarBodegaDestino(cod);
		}
	});
	
	$('#txtSopCod').focus(function(){ 
		modal=4;
		$('#txtSopNomb').val('');
	});

	$('#txtSopCod').focus(function(){ 
		modal=0;
		$('#txtSopNomb').val('');
	});
	$("#txtSopCod").keypress(function(event){
		if(event.which == 13){
			cod = $.trim($('#txtSopCod').val());
			if(cod!=''){
				buscarTipoMovimientoSop(cod);
			}else{
				demo.showNotification('bottom','left', 'Por favor seleccione un tipo de movimiento', 4);
			}
		}
	});

    $('#btnConsulta').click(function(){
        $('#btnConsulta').addClass('disabled'); //deshabilitamos el consultar
        $('#btnCancelar').removeClass('disabled'); //habilitamos el cancelar
        
        //validamos campo de consultar
        txtMovCod = $('#txtMovCod').val();
        if(txtMovCod!=''){
            consultarTipoMovimiento(txtMovCod);
        }else{
            //habilitamos botones de navegacion
            $('#btnPrimer').removeClass('disabled');
            $('#btnAnterior').removeClass('disabled');
            $('#btnSiguiente').removeClass('disabled');
            $('#btnUltimo').removeClass('disabled');
            $('#btnImprimir').removeClass('disabled');

            consultarTipoMovimientoAll();
        }
    });

	$('#btnImprimir').click(function(){
		id = $('#txtMovCod').val();
		if(id!=''){
			window.open('calma_report.php?id='+id, "Imprimir Movimiento", "width=1200, height=620");
		}else{
			demo.showNotification('bottom','left', 'Porfavor coloque un tipo de movimiento valido', 4);
		}
	});

    $('#btnCancelar').click(function(){
        $('#btnCancelar').addClass('disabled'); //deshabilitamos el cancelar
        $('#btnConsulta').removeClass('disabled'); //habilitamos el consultar

        //deshabilitamos botones de navegacion
        $('#btnPrimer').addClass('disabled');
        $('#btnAnterior').addClass('disabled');
        $('#btnSiguiente').addClass('disabled');
        $('#btnUltimo').addClass('disabled');
		$('#btnImprimir').addClass('disabled');

		limpiarCampos();
		limpiarTablaMateriales();
    });

    /*$("#txtMovCod").keypress(function(event){
		if(event.which == 13){
			txtMovCod = $.trim($('#txtMovCod').val());
			if(txtMovCod!=''){
				consultarTipoMovimiento(txtMovCod);
			}else{
				demo.showNotification('bottom','left', 'Porfavor coloque un Numero', 4);
			}
		}
	});*/

    $('#btnPrimer').click(function(){
		$('#txt_ActualMov').val(1);
		codDep = $('#txt_CodMov1').val();
		consultarTipoMovimiento(codDep);
	});
	$('#btnAnterior').click(function(){
		codId = parseInt($('#txt_ActualMov').val());
		$('#txt_ActualMov').val(codId-1);
		codId = parseInt($('#txt_ActualMov').val());

		if(codId>=1){
			codDep = $('#txt_CodMov'+codId).val();
			consultarTipoMovimiento(codDep);
		}else{
			$('#txt_ActualMov').val(1);
		}
	});
	$('#btnSiguiente').click(function(){
		codId = parseInt($('#txt_ActualMov').val());
		$('#txt_ActualMov').val(codId+1);
		codId = parseInt($('#txt_ActualMov').val());
		
		codUlt = parseInt($('#txt_ToltalMov').val());
		if(codId<=codUlt){
			codDep = $('#txt_CodMov'+codId).val();
			consultarTipoMovimiento(codDep);
		}else{
			$('#txt_ActualMov').val(codUlt);
		}
	});
	$('#btnUltimo').click(function(){
		codUlt = parseInt($('#txt_ToltalMov').val());
		$('#txt_ActualMov').val(codUlt);
		codDep = $('#txt_CodMov'+codUlt).val();
		consultarTipoMovimiento(codDep);
	});
	
});
function consultarTipoMovimiento(txtMovCod){
    $.ajax({
        type:'POST',
        url:'proc/calma_proc.php?accion=obtener_movimiento',
        data:{ txtMovCod:txtMovCod },
        dataType: 'json',
        success: function(data){
            $('#txtMovCod').val(data[0]);
            $('#txtFecha').val(data[1]);
            $('#txtTipoCod').val(data[2]);
            $('#txtTipoNomb').val(data[3]);
            $('#txtEnCod').val(data[5]);
            $('#txtEnNomb').val(data[6]);
            $('#txtValor').val(data[9]);
			$('#txtBodCod').val(data[7]);
            $('#txtBodNomb').val(data[8]);
            $('#txtSopCod').val(data[10]);
            $('#txtSopDoc').val(data[11]);
            $('#txtRegis').val(data[12]);
            $('#txtObser').val(data[13]);
			
			if(data[4]=='E'){
				$('#divTipoMov').html('<input type="radio" name="tipoMov" checked> Entrada &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tipoMov"> Salida');
			}else{
				$('#divTipoMov').html('<input type="radio" name="tipoMov"> Entrada &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tipoMov" checked> Salida');
			}
			obtenerMaterialesMovimiento(txtMovCod);
			$('#btnConsulta').addClass('disabled'); //deshabilitamos el consultar
        	$('#btnCancelar').removeClass('disabled'); //habilitamos el cancelar
			$('#btnImprimir').removeClass('disabled'); //habilitamos el imprimir
        }
    });
}
function obtenerMaterialesMovimiento(txtMovCod){
	$.ajax({
		type:'POST',
		url:'proc/calma_proc.php?accion=obtener_materiales_movimiento',
		data:{ txtMovCod:txtMovCod },
		success: function(data){
			$('#table_tbody').html(data);
		}
	});
}
function consultarTipoMovimientoAll(){
	tm = $('#txtTipoCod').val();
	sw = $('#txtSwTipoMov').val();
	en = $('#txtEnCod').val();
	de = $('#txtBodCod').val();
	sp = $('#txtSopCod').val();
	ds = $('#txtSopDoc').val();

	$.ajax({
		type:'POST',
		url:'proc/calma_proc.php?accion=cargar_movimientos',
		data:{ tm:tm, sw:sw, en:en, de:de, sp:sp, ds:ds },
		success: function(data){
			$('#div_todos_movimientos').html(data);
			$('#btnPrimer').click();
		}
	});
}
//bodega pricipal
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
function addBodegaOrig(cod,bod){
	$('#txtEnCod').val(cod);
	$('#txtEnNomb').val(bod);
	$('#modalBodegaOriginal').modal('hide');
}
//tipo de movimiento
function buscarTipoMovimiento(cod,tipo){
	if( (cod!='') ){
		$.ajax({
	        type:'POST',
	        url:'proc/ralma_proc.php?accion=buscar_tipo_movimiento',
	        data:{ cod:cod, tipo:tipo },
			dataType: 'json',
	        success: function(data){
	        	$('#txtTipoNomb').val(data[0]);
	        	actualizarBodegaDestino(cod);
	        }
	    });
	}else{
		demo.showNotification('bottom','left', 'Por favor coloque un tipo de movimiento calido', 4);
	}
}
function actualizarTipoMovimiento(tipo){
	$.ajax({
        type:'POST',
        url:'proc/ralma_proc.php?accion=actualizar_tipo_movimiento',
        data:{ tipo:tipo },
        success: function(data){
        	$('#divTipoMov').html(data);
			$('#modalTipoMovimiento').modal('show');
        }
    });	
}
function addTipoMovimiento(cod,nom){
	$('#txtTipoCod').val(cod);
	$('#txtTipoNomb').val(nom);
	$('#modalTipoMovimiento').modal('hide');
}
//bodega de modalBodegaDestino
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
function addBodegaDes(cod,nom){
	$('#txtBodCod').val(cod);
	$('#txtBodNomb').val(nom);
	$('#modalBodegaDestino').modal('hide');
}
function buscarBodegaDestino(cod){
	if( (cod!='') ){
		$.ajax({
	        type:'POST',
	        url:'proc/calma_proc.php?accion=buscar_bodega_destino',
	        data:{ cod:cod },
	        success: function(data){
	        	$('#txtBodNomb').val(data);
	        }
	    });
	}else{
		demo.showNotification('bottom','left', 'Por favor coloque una bodega valida', 4);
	}
}
//tipo movimiento soporte
function addTipoMovimientoSop(cod,nom){
	$('#txtSopCod').val(cod);
	$('#txtSopNomb').val(nom);
	$('#modalTipoMovimientoSop').modal('hide');
}
function buscarTipoMovimientoSop(cod){
	$.ajax({
		type:'POST',
		url:'proc/calma_proc.php?accion=buscar_tipo_mov_soporte',
		data:{ cod:cod },
		success: function(data){
			$('#txtSopCod').val(cod);
			$('#txtSopNomb').val(data);
		}
	});
}

//Tools
modal = 1;
function solonumeros(){
    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
        event.returnValue = false;
}
//Limpiar
function limpiarTablaMateriales(){
	a = '<table id="table_materiales" class="table table-bordered table-condensed">';
	b = '<thead><tr style="background-color: #3c8dbc; color:white;">';
	c = '<th class="text-center" width="100">MATERIAL</th>';
	d = '<th class="">DESCRIPCION DEL MATERIAL</th>';
	e = '<th class="text-center" width="100">CANTIDAD</th>';
	f = '<th class="text-right" width="170">VALOR</th></tr></thead>';
	g = '<tbody id="divMaterialInventario"></tbody></table>';
	$('#tableOrdenes').html(a+b+c+d+e+f+g);
}
function limpiarCampos(){
	$('#txtMovCod').val('');
	$('#txtFecha').val('');
	$('#txtTipoCod').val('');
	$('#txtSwTipoMov').val('');
	$('#txtTipoNomb').val('');
	$('#txtEnCod').val('');
	$('#txtEnNomb').val('');
	$('#txtValor').val('');
	$('#txtBodCod').val('');
	$('#txtBodNomb').val('');
	$('#txtSopCod').val('');
	$('#txtSopNomb').val('');
	$('#txtSopDoc').val('');
	$('#txtRegis').val('');
	$('#txtObser').val('');
	
	$('#divTipoMov').html('<input type="radio" name="tipoMov"> Entrada &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tipoMov"> Salida');
}