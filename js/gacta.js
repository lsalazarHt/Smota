$(document).ready(function(){

	$('#btnGuardar').removeClass('disabled');
	//$('#btnNuevo').removeClass('disabled');
	$('#btnConsulta').addClass('disabled');
	$('#btnCancelar').removeClass('disabled');
	$('#btnEditor').addClass('disabled');

	$('#btnListaValores').click(function(){
		if(modal==1){
			$('#modalTecnicos').modal('show');
		}
	});

	$('#txtTecCod').click(function(){
		modal = 1;
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
		$('#txtTecCod').val('');
		$('#txtTecNomb').val('');
		$('#txtFecha').val( $('#txtFechaOrg').val() );
	});

	$('#btnGuardar').click(function(){
		
		tec = $('#txtTecCod').val();
		tno = $('#txtTecNomb').val();
		fec = $('#txtFecha').val();

		if( (tec!='') && (tno!='') && (fec!='') ){
			generarActa(tec,fec);
		}else{
			var msgError = 'Porfavor complete los datos';
			demo.showNotification('bottom','left', msgError, 4);
		}
	});
});
var modal = 1;
//TECNICO
function addTecnico(cod,nom){
	$('#txtTecCod').val(cod);
	$('#txtTecNomb').val(nom);
	$('#modalTecnicos').modal('hide');
}
function buscarTecnico(cod){
	$.ajax({
        type:'POST',
        url:'proc/gacta_proc.php?accion=buscar_tecnico',
        data:{cod:cod},
        success: function(data){
        	$('#txtTecNomb').val(data);
        }
    });
}
//ACTA
function generarActa(tec,fec){
	bootbox.confirm("Esta seguro que desea generar el acta", function(result) {
		if(result){
			$.ajax({
				type:'POST',
				url:'proc/gacta_proc.php?accion=generar_acta',
				data:{tec:tec,fec:fec},
				dataType: 'json',
				success: function(data){
					if(data[0]==1){
						var msgError = 'El acta #'+data[1]+' se genero con exito';
						demo.showNotification('bottom','left', msgError, 2);
						$('#btnCancelar').click();
					}else{
						alert(data)
					}
				}
			});
		}
	});
}
//OTROS
function solonumeros(){
	if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
	    event.returnValue = false;
}

function pressEnter(campo){
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