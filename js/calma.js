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


    });

    

    $('#btnPrimer').click(function(){
		$('#txtActualDep').val(1);
		codDep = $('#txtCodDep1').val();
		buscarNombreDepartamento(codDep);
	});
	$('#btnAnterior').click(function(){
		codId = parseInt($('#txtActualDep').val());
		$('#txtActualDep').val(codId-1);
		codId = parseInt($('#txtActualDep').val());

		if(codId>=1){
			codDep = $('#txtCodDep'+codId).val();
			buscarNombreDepartamento(codDep);
		}else{
			$('#txtActualDep').val(1);
		}
	});
	$('#btnSiguiente').click(function(){
		codId = parseInt($('#txtActualDep').val());
		$('#txtActualDep').val(codId+1);
		codId = parseInt($('#txtActualDep').val());

		codUlt = parseInt($('#txtToltalDep').val());
		if(codId<=codUlt){
			codDep = $('#txtCodDep'+codId).val();
			buscarNombreDepartamento(codDep);
		}else{
			$('#txtActualDep').val(codUlt);
		}
	});
	$('#btnUltimo').click(function(){
		codUlt = parseInt($('#txtToltalDep').val());
		$('#txtActualDep').val(codUlt);
		codDep = $('#txtCodDep'+codUlt).val();
		buscarNombreDepartamento(codDep);
	});

});

function consultarTipoMovimiento(txtMovCod){
    $.ajax({
        type:'POST',
        url:'proc/calma_proc.php?accion=obtener_movimiento',
        data:{ txtMovCod:txtMovCod },
        dataType: 'json',
        success: function(data){
            $('#divListaDepartamentos').html(data[0]);
            $('#divListaDepartamentos').html(data[0]);
            $('#divListaDepartamentos').html(data[0]);
            $('#divListaDepartamentos').html(data[0]);
            $('#divListaDepartamentos').html(data[0]);
            $('#divListaDepartamentos').html(data[0]);
            $('#divListaDepartamentos').html(data[0]);
            $('#divListaDepartamentos').html(data[0]);
            $('#divListaDepartamentos').html(data[0]);
            $('#divListaDepartamentos').html(data[0]);
            $('#divListaDepartamentos').html(data[0]);
            $('#divListaDepartamentos').html(data[0]);
            $('#divListaDepartamentos').html(data[0]);
            $('#divListaDepartamentos').html(data[0]);
            //$('#btnPrimer').click();
        }
    });
}

function consultarTipoMovimientoAll(){

}





//Tools
modal = 1;
function swModal(mod,id){
	ident = id;
	modal = 0;
	$('#selectRow').val(id);
	/*$('#txtCod'+ident).val('');
	$('#txtNomb'+ident).val('');
	$('#txtCant'+ident).val('');
	$('#txtVal'+ident).val('');*/
}
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