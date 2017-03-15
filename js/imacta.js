$(document).ready(function(){
	$('#btnEditor').addClass('disabled');
	$('#btnCancelar').removeClass('disabled');

	$('#btnListaValores').click(function(){
		if(modal==1){
			$('#modalActas').modal('show');
		}
	});

	$('#btnConsulta').click(function(){
		cod = $('#txtActCod').val();
		buscarActa(cod);
	});

	$('#txtActCod').click(function(){
		$('#txtTecCod').val('');
		$('#txtTecNomb').val('');
		$('#txtFecha').val('');
		$('#txtEstado').val('');
		$('#txtValBruto').val('');
		$('#txtValNeto').val('');
		$('#txtObservActa').val('');
	});

	$("#txtActCod").keypress(function(event){
		if(event.which == 13){
			cod = $.trim($('#txtActCod').val());
			buscarActa(cod);
		}
	});

	$('#btnImprimir').click(function(){
		cod = $('#txtActCod').val();
		vNe = $('#txtValNeto').val();
		if( (cod!='') && (vNe!='') ){
			imprimirActa(cod);
		}else{
			alert('Porfavor coloque un acta valido')
		}
	});

	$('#btnCancelar').click(function(){
		
		limpiar();
	});
});
var modal = 1;
//ACTAS
function buscarActa(cod){
	if(cod!=''){
		$.ajax({
	        type:'POST',
	        url:'proc/imacta_proc.php?accion=buscar_acta',
	        data:{cod:cod},
	        dataType: 'json',
	        success: function(data){
	        	$('#txtActCod').val(data[0]);
	        	$('#txtTecCod').val(data[1]);
	        	$('#txtTecNomb').val(data[2]);
	        	$('#txtFecha').val(data[3]);
	        	$('#txtEstado').val(data[4]);
	        	$('#txtValBruto').val(data[5]);
	        	$('#txtValNeto').val(data[6]);
	        	$('#txtObservActa').val(data[7]);
	        	$('#modalActas').modal('hide');

	        	if( data[6] != '' ){
	        		$('#btnImprimir').removeClass('disabled');
	        	}else{
	        		$('#btnImprimir').addClass('disabled');
	        	}
	        }
	    });
	}else{ alert('Porfavor coloque una acta valida') }
}
function imprimirActa(cod){
	var result = confirm("Esta seguro que desea imprimir el acta #"+cod);
	if(result){
		url = 'imactaprint.php?cod='+cod;
		window.open(url,'_blank');
	}
}
//OTROS
function limpiar(){
	$('#txtActCod').val('');
	$('#txtTecCod').val('');
	$('#txtTecNomb').val('');
	$('#txtFecha').val('');
	$('#txtEstado').val('');
	$('#txtValBruto').val('');
	$('#txtValNeto').val('');
	$('#txtObservActa').val('');
	$('#btnGuardar').addClass('disabled');
}
function solonumeros(){
	if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
	    event.returnValue = false;
}