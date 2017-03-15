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
		$('#btnGuardar').addClass('disabled');
	});

	$("#txtActCod").keypress(function(event){
		if(event.which == 13){
			cod = $.trim($('#txtActCod').val());
			buscarActa(cod);
		}
	});

	$('#btnGuardar').click(function(){
		cod = $('#txtActCod').val();
		vNe = $('#txtValNeto').val();
		if( (cod!='') && (vNe!='') ){
			reversarActa(cod);
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
	        url:'proc/racta_proc.php?accion=buscar_acta',
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
	        		$('#btnGuardar').removeClass('disabled');
	        	}else{
	        		$('#btnGuardar').addClass('disabled');
	        	}
	        }
	    });
	}else{ alert('Porfavor coloque una acta valida') }
}
function reversarActa(cod){
	var result = confirm("Esta seguro que desea reversar el acta #"+cod);
	if(result){
		$.ajax({
	        type:'POST',
	        url:'proc/racta_proc.php?accion=reversar_acta',
	        data:{cod:cod},
	        success: function(data){
	        	if(data==1){
	        		alert('El acta #'+cod+' se reverso con exito')
					limpiar();
					actualizarActas();
	        	}else{
	        		alert(data)
	        	}
	        }
	    });
	}
}
function actualizarActas(){
	$.ajax({
        type:'POST',
        url:'proc/apacta_proc.php?accion=actualizar_actas',
        data:{cod:'1'},
        success: function(data){
        	$('#tbodyActas').html(data);
        }
    });
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