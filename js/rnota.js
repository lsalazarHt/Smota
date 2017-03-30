$(document).ready(function(){
	$('#btnCancelar').removeClass('disabled');
	$('#btnGuardar').removeClass('disabled');
	$('#btnConsulta').addClass('disabled');
	$('#btnEditor').addClass('disabled');

	obtenerUltimo();
	$('#btnListaValores').click(function(){
		if(modal==1){
			$('#modalClaseNota').modal('show');
		}else{
			$('#modalTecnicos').modal('show');
		}
	});

	$('#txtClasCod').focus(function(){
		modal = 1;
		$('#txtClasNomb').val('');
	});
	// $("#txtClasCod").keypress(function(event){
	// 	if(event.which == 13){
	// 		cod = $.trim($('#txtClasCod').val());
	// 		if( cod!='' ){
	// 			buscarClase(cod);
	// 		}else{ alert('Porfavor coloque una clase valida') }
	// 	}
	// });

	$('#txtTecCod').focus(function(){
		modal = 2;
		$('#txtTecNomb').val('');
	});
	// $("#txtTecCod").keypress(function(event){
	// 	if(event.which == 13){
	// 		cod = $.trim($('#txtTecCod').val());
	// 		if( cod!='' ){
	// 			buscarTecnico(cod);
	// 		}else{ alert('Porfavor coloque un tecnico valido') }
	// 	}
	// });

	$('#btnCancelar').click(function(){
		modal = 1;
		obtenerUltimo();
		$('#txtClasCod').val('');
		$('#txtClasNomb').val('');
		//$('#txFech').val('');
		$('#txFecApli').val('');
		$('#txtTecCod').val('');
		$('#txtTecNomb').val('');
		$('#txtValor').val('');
		$('#txtObserv').val('');
	});

	$('#btnGuardar').click(function(){
		cod = $('#txtNotCod').val();
		cls = $('#txtClasCod').val();
		fec = $('#txFech').val();
		tcr = $('input:radio[name=tipoRadio]:checked').val();
		fAp = $('#txFecApli').val();
		tec = $('#txtTecCod').val();
		val = $('#txtValor').val();
		obs = $('#txtObserv').val();

		if( (cod!='') && (cls!='') && (fec!='') && (tcr!='') && (fAp!='') && (tec!='') && (val!='') ){
			guardarNota(cod,cls,fec,tcr,fAp,tec,val,obs);
		}else{
			var msgError = 'Porfavor complete los datos';
			demo.showNotification('bottom','left', msgError, 4);
		}
	});

});
var modal = 1;
function obtenerUltimo(){
	$.ajax({
        type:'POST',
        url:'proc/rnota_proc.php?accion=obtener_ultimo',
        data:{dep:'1'},
        success: function(data){
        	$('#txtNotCod').val(data);
        }
    });
}
//CLASE DE NOTA
function addClase(cod,nom){
	$('#txtClasCod').val(cod);
	$('#txtClasNomb').val(nom);
	$('#modalClaseNota').modal('hide');
}
function buscarClase(cod){
	$.ajax({
        type:'POST',
        url:'proc/rnota_proc.php?accion=buscar_clase',
        data:{cod:cod},
        success: function(data){
        	$('#txtClasNomb').val(data);
        }
    });
}
//TECNICO
function addTecnico(cod,nom){
	$('#txtTecCod').val(cod);
	$('#txtTecNomb').val(nom);
	$('#modalTecnicos').modal('hide');
}
function buscarTecnico(cod){
	$.ajax({
        type:'POST',
        url:'proc/rnota_proc.php?accion=buscar_tecnico',
        data:{cod:cod},
        success: function(data){
        	$('#txtTecNomb').val(data);
        }
    });
}
//NOTA
function guardarNota(cod,cls,fech,tipo,fechApl,tec,val,obs){
	$.ajax({
        type:'POST',
        url:'proc/rnota_proc.php?accion=guardar_nota',
        data:{cod:cod,cls:cls,fech:fech,tipo:tipo,fechApl:fechApl,tec:tec,val:val,obs:obs},
        success: function(data){
        	if(data==1){
        		var msgError = 'La nota se guardo con exito';
				demo.showNotification('bottom','left', msgError, 2);
        		$('#btnCancelar').click();
        	}else{
        		alert(data)
        	}
        }
    });
}
//OTROS
function solonumeros(){
	if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
	    event.returnValue = false;
}

function pressEnter(campo){
	if(campo==='txtClasCod'){
		cod = $.trim($('#txtClasCod').val());
		if( cod!='' ){
			buscarClase(cod);
		}else{ 
			var msgError = 'Porfavor coloque una clase valida';
			demo.showNotification('bottom','left', msgError, 4);
		}
	}
	if(campo==='txtTecCod'){
		cod = $.trim($('#txtTecCod').val());
		if( cod!='' ){
			buscarTecnico(cod);
		}else{ 
			var msgError = 'Porfavor coloque un tecnico valido';
			demo.showNotification('bottom','left', msgError, 4);
		}
	}
}