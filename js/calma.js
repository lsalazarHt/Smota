$(document).ready(function(){

    $('#btnEditor').addClass('disabled'); //deshabilitar editor
	
    $('#btnListaValores').click(function(){
        if(modal==1){
            $('#modalMovimientos').modal('show');
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

            consultarTipoMovimientoAll();
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

		limpiarCampos();
		limpiarTablaMateriales();
    });

    $("#txtMovCod").keypress(function(event){
		if(event.which == 13){
			txtMovCod = $.trim($('#txtMovCod').val());
			consultarTipoMovimiento(txtMovCod);
		}
	});

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
	$.ajax({
		type:'POST',
		url:'proc/calma_proc.php?accion=cargar_movimientos',
		data:{ txtMovCod:'1' },
		success: function(data){
			$('#div_todos_movimientos').html(data);
			$('#btnPrimer').click();
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
	$('#table_tbody').html('');
}
function limpiarCampos(){
	$('#txtMovCod').val('');
	$('#txtFecha').val('');
	$('#txtTipoCod').val('');
	$('#txtTipoNomb').val('');
	$('#txtEnCod').val('');
	$('#txtEnNomb').val('');
	$('#txtValor').val('');
	$('#txtBodCod').val('');
	$('#txtBodNomb').val('');
	$('#txtSopCod').val('');
	$('#txtSopDoc').val('');
	$('#txtRegis').val('');
	$('#txtObser').val('');
	
	$('#divTipoMov').html('<input type="radio" name="tipoMov"> Entrada &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tipoMov"> Salida');
}