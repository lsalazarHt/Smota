$(document).ready(function(){

	//$('#btnGuardar').removeClass('disabled');
	//$('#btnNuevo').removeClass('disabled');
	$('#btnConsulta').addClass('disabled');
	$('#btnCancelar').removeClass('disabled');
	$('#btnEditor').addClass('disabled');
	$('#txtTecCod').focus();

	$('#btnListaValores').click(function(){
		if(modal==1){
			$('#modalTecnicos').modal('show');
		}
	});

	$('#txtTecCod').click(function(){
		modal = 1;
		$('#txtTecNomb').val('');
		$('#btnGuardar').addClass('disabled');
		limpiarTabla();
	});
	$("#txtTecCod").keypress(function(event){
		if(event.which == 13){
			cod = $.trim($('#txtTecCod').val());
			if( cod!='' ){
				buscarTecnico(cod);
			}else{ 
				var msgError = 'Porfavor coloque un tecnico valido';
				demo.showNotification('bottom','left', msgError, 4);
			}
		}
	});

	//GENERAR ACTA
	$('#btnGuardar').click(function(){
		tec = $('#txtTecCod').val();
		tecNom = $('#txtTecNomb').val();
		if(tecNom!=''){
			//RECORRER LAS ORDENES
			allID = '';
			cont = $('#contRow').val();
			sw=false;
			for(var i=0;i<=cont;i++){
				if($("#txtCheck"+i).is(':checked')){
					sw=true;
					id = $('#idManObra'+i).val();
					allID = allID+id+',';
				}
			}
			if(sw){
				var result = confirm("Esta seguro que desea generar el acta");
				if(result){
					$.ajax({
				        type:'POST',
				        url:'proc/gama_proc.php?accion=generar_acta',
				        data:{tec:tec,allID:allID},
				        dataType: 'json',
				        success: function(data){
				        	if(data[0]==1){
				        		var msgError = 'El acta #'+data[1]+' se genero con exito';
								demo.showNotification('bottom','left', msgError, 2);
								mostrarManosdeObra();
				        	}else{
				        		alert(data)
				        	}
				        }
				    });
				}
			}else{
				var msgError = 'Porfavor elija minimo una orden';
				demo.showNotification('bottom','left', msgError, 4);
			}
			//alert('Las ordenes se desasignaron correctamente al tenico')
		}
	});

	$('#btnCancelar').click(function(){
		modal = 1;
		$('#txtTecCod').val('');
		$('#txtTecNomb').val('');
		$('#txtNoOrden').val('');
		limpiarTabla();
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
        url:'proc/gama_proc.php?accion=buscar_tecnico',
        data:{cod:cod},
        success: function(data){
        	$('#txtTecNomb').val(data);
        }
    });
}
//MANOS DE OBRA
function mostrarManosdeObra(){
	tec = $('#txtTecCod').val();
	critOrd = $('input:radio[name=critOrd]:checked').val();
	ord = $('#txtNoOrden').val();

	if( tec!='' ){
		buscarTecnico(tec);
		$.ajax({
	        type:'POST',
	        url:'proc/gama_proc.php?accion=buscar_manos_obra',
	        data:{tec:tec, critOrd:critOrd, ord:ord},
	        success: function(data){
	        	$('#tableOrdenes').html(data);

	        	if( $('#contRow').val()!=0 ){
	        		$('#btnGuardar').removeClass('disabled');
	        	}else{
	        		$('#btnGuardar').addClass('disabled');
	        	}
	        }
	    });
	}else{
		var msgError = 'Porfavor Complete los datos para realizar el ordenamiento';
		demo.showNotification('bottom','left', msgError, 4);
	}
}
//OTROS
function solonumeros(){
	if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
	    event.returnValue = false;
}
function limpiarPantalla(){

	$('#btnCancelar').click();
}
function limpiarTabla(){
	$.ajax({
        type:'POST',
        url:'proc/gama_proc.php?accion=limpiar_tabla',
        data:{ id:'1' },
        success: function(data){
        	$('#tableOrdenes').html(data);
        }
    });
}
function selectTodos(){
	cont = $('#contRow').val();
	marcado = $('#swCheckTodos').val();

	if(marcado!=1){
		$('#swCheckTodos').val(1);
		for(var i=0;i<=cont;i++){
			$("#txtCheck"+i).click();
		}
	}else{
		for(var i=0;i<=cont;i++){
			$("#txtCheck"+i).prop("checked","");
		}
		$('#swCheckTodos').val(0);
	}
	$('.trDefault').removeClass('trSelect');
}
function escogencia(sw){
	cont = $('#contRow').val();
	if(sw==1){
		//$('#swCheckTodos').val(1);
		for(var i=0;i<=cont;i++){
			$("#txtCheck"+i).click();
		}
	}else{
		for(var i=0;i<=cont;i++){
			$("#txtCheck"+i).prop("checked","");
		}
		//$('#swCheckTodos').val(0);
	}
	$('.trDefault').removeClass('trSelect');
}