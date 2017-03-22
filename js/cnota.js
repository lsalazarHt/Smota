$(document).ready(function(){
	$('#btnCancelar').removeClass('disabled');
	//$('#btnGuardar').removeClass('disabled');
	$('#btnConsulta').addClass('disabled');
	$('#btnEditor').addClass('disabled');

	$('#btnListaValores').click(function(){
		if(modal==1){
			$('#modalNotas').modal('show');
		}else if(modal==2){
			$('#modalClaseNota').modal('show');
		}else{
			$('#modalTecnicos').modal('show');
		}
	});

	$('#txtClasCod').focus(function(){
		modal = 2;
		$('#txtClasNomb').val('');
	});
	// $("#txtClasCod").keypress(function(event){
	// 	if(event.which == 13){
	// 		cod = $.trim($('#txtClasCod').val());
	// 		if( cod!='' ){
	// 			buscarClase(cod);
	// 		}else{ 
	// 			var msgError = 'Porfavor coloque una clase valida';
	// 			demo.showNotification('bottom','left', msgError, 4);
	// 		}
	// 	}
	// });

	$('#txtTecCod').focus(function(){
		modal = 3;
		$('#txtTecNomb').val('');
	});
	// $("#txtTecCod").keypress(function(event){
	// 	if(event.which == 13){
	// 		cod = $.trim($('#txtTecCod').val());
	// 		if( cod!='' ){
	// 			buscarTecnico(cod);
	// 		}else{ 
	// 			var msgError = 'Porfavor coloque un tecnico valido';
	// 			demo.showNotification('bottom','left', msgError, 4);
	// 		}
	// 	}
	// });

	$('#btnCancelar').click(function(){
		modal = 1;
		$("#txtNotCod").removeAttr("readonly");
		$('#btnGuardar').addClass('disabled');
		$('#btnEliminar').addClass('disabled');
		$('#radioDebito').click();
		$('#txtNotCod').val('');
    	$('#txtClasCod').val('');
    	$('#txtClasNomb').val('');
    	$('#txFech').val('');
    	$('#txFecApli').val('');
    	$('#txtTecCod').val('');
    	$('#txtTecNomb').val('');
    	$('#txtValor').val('');
    	$('#txtObserv').val('');
	});

	$('#txtNotCod').focus(function(){
		modal = 1;
		$("#txtNotCod").removeAttr("readonly");
		$('#btnGuardar').addClass('disabled');
		$('#btnEliminar').addClase('disabled');
		$('#radioDebito').click();
    	$('#txtClasCod').val('');
    	$('#txtClasNomb').val('');
    	$('#txFech').val('');
    	$('#txFecApli').val('');
    	$('#txtTecCod').val('');
    	$('#txtTecNomb').val('');
    	$('#txtValor').val('');
    	$('#txtObserv').val('');
	});
	// $("#txtNotCod").keypress(function(event){
	// 	if(event.which == 13){
	// 		cod = $.trim($('#txtNotCod').val());
	// 		if( cod!='' ){
	// 			buscarNota(cod);
	// 		}else{ 
	// 			var msgError = 'Porfavor coloque un codigo valido';
	// 			demo.showNotification('bottom','left', msgError, 4);
	// 		}
	// 	}
	// });

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
			editarNota(cod,cls,fec,tcr,fAp,tec,val,obs);
		}else{
			var msgError = 'Porfavor complete los datos';
			demo.showNotification('bottom','left', msgError, 4);
		}
	});

	$('#btnEliminar').click(function(){
		cod = $('#txtNotCod').val();
		cls = $('#txtClasCod').val();
		fec = $('#txFech').val();
		tcr = $('input:radio[name=tipoRadio]:checked').val();
		fAp = $('#txFecApli').val();
		tec = $('#txtTecCod').val();
		val = $('#txtValor').val();
		obs = $('#txtObserv').val();

		if( (cod!='') && (cls!='') && (fec!='') && (tcr!='') && (fAp!='') && (tec!='') && (val!='') ){
			var result = confirm("Esta seguro que desea eliminar la nota #"+cod);
			if(result){
				eliminarNota(cod);
			}
		}else{
			var msgError = 'Porfavor complete los datos';
			demo.showNotification('bottom','left', msgError, 4);
		}
	});

});
var modal = 1;
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
function buscarNota(cod){
	$.ajax({
        type:'POST',
        url:'proc/cnota_proc.php?accion=buscar_nota',
        data:{cod:cod},
        dataType: "json",
        success: function(data){
        	$('#txtNotCod').val(cod);
        	$('#txtClasCod').val(data[0]);
        	$('#txtClasNomb').val(data[1]);
        	$('#txFech').val(data[2]);
        	$('#txFecApli').val(data[3]);
        	$('#txtTecCod').val(data[4]);
        	$('#txtTecNomb').val(data[5]);
        	$('#txtValor').val(data[6]);
        	$('#txtObserv').val(data[7]);
        	
        	if( data[8] == 'D' ){
        		$('#radioDebito').click();
        	}else{
        		$('#radioCredito').click();
        	}
        	if( $('#txtClasCod').val() != '' ){
        		$("#txtNotCod").attr("readonly","readonly");
        		$('#btnGuardar').removeClass('disabled');
        		$('#btnEliminar').removeClass('disabled');
        	}else{
        		$("#txtNotCod").removeAttr("readonly");
        		$('#btnGuardar').addClass('disabled');
        		$('#btnEliminar').addClass('disabled');
        	}

        	$('#modalNotas').modal('hide');
        }
    });
}
function editarNota(cod,cls,fech,tipo,fechApl,tec,val,obs){
	$.ajax({
        type:'POST',
        url:'proc/cnota_proc.php?accion=editar_nota',
        data:{cod:cod,cls:cls,fech:fech,tipo:tipo,fechApl:fechApl,tec:tec,val:val,obs:obs},
        success: function(data){
        	if(data==1){
        		var msgError = 'La nota se edito con exito';
				demo.showNotification('bottom','left', msgError, 2);
        		$('#btnCancelar').click();
        	}else{
        		alert(data)
        	}
        }
    });
}
function eliminarNota(cod){
	$.ajax({
        type:'POST',
        url:'proc/cnota_proc.php?accion=eliminar_nota',
        data:{cod:cod},
        success: function(data){
        	if(data==1){
        		var msgError = 'La nota se elimino con exito';
				demo.showNotification('bottom','left', msgError, 4);
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
	if(campo==='txtNotCod'){
		cod = $.trim($('#txtNotCod').val());
		if( cod!='' ){
			buscarNota(cod);
		}else{ 
			var msgError = 'Porfavor coloque un codigo valido';
			demo.showNotification('bottom','left', msgError, 4);
		}
	}
}