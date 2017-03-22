$(document).ready(function(){
	$('#btnCancelar').removeClass('disabled');
	$('#btnConsulta').addClass('disabled');
	$('#btnEditor').addClass('disabled');

	$('#btnListaValores').click(function(){
		if(modal==1){
			$('#modalDepartamentos').modal('show');
		}else if(modal==2){
			dep = $('#txtDepCod').val();
			if(dep!=''){
				actualizarLocalidad(dep);
			}
		}
	});

	$('#txtDepCod').focus(function(){

		modal=1;
		$('#txtDepNomb').val('');

		$('#txtLocCod').val('');
		$('#txtLocNomb').val('');

		$('#txtCodOrd').val('');

		$('#txtPqrCod').val('');
    	$('#txtPqrNomb').val('');

    	$('#txtTecCod').val('');
    	$('#txtTecNomb').val('');

    	$('#txtFechaAsig').val('');
		$('#btnGuardar').addClass('disabled');
	});
	// $("#txtDepCod").keypress(function(event){
	// 	if(event.which == 13){
	// 		dep = $.trim($('#txtDepCod').val());
	// 		if(dep!=''){
	// 			buscarDepartamento(dep);
	// 		}else{ alert('Porfavor coloque un departamento valido') }
	// 	}
	// });

	$('#txtLocCod').focus(function(){

		modal=2;
		$('#txtLocNomb').val('');
		$('#txtCodOrd').val('');

		$('#txtPqrCod').val('');
    	$('#txtPqrNomb').val('');

    	$('#txtTecCod').val('');
    	$('#txtTecNomb').val('');

    	$('#txtFechaAsig').val('');
		$('#btnGuardar').addClass('disabled');
	});
	// $("#txtLocCod").keypress(function(event){
	// 	if(event.which == 13){
	// 		dep = $.trim($('#txtDepCod').val());
	// 		loc = $.trim($('#txtLocCod').val());
	// 		if( (dep!='') && (loc!='') ){
	// 			buscarDepartamento(dep);
	// 			buscarLocalidad(dep,loc);
	// 		}else{ alert('Porfavor coloque un departamento valido') }
	// 	}
	// });

	$('#txtCodOrd').focus(function(){
		$('#txtPqrCod').val('');
    	$('#txtPqrNomb').val('');

    	$('#txtTecCod').val('');
    	$('#txtTecNomb').val('');

    	$('#txtFechaAsig').val('');
    	$('#btnGuardar').addClass('disabled');
	});
	// $("#txtCodOrd").keypress(function(event){
	// 	if(event.which == 13){
	// 		dep = $.trim($('#txtDepCod').val());
	// 		loc = $.trim($('#txtLocCod').val());
	// 		ord = $.trim($('#txtCodOrd').val());
	// 		if( (dep!='') && (loc!='') ){
	// 			buscarDepartamento(dep);
	// 			buscarLocalidad(dep,loc);
	// 			buscarOrden(dep,loc,ord);
	// 		}else{ alert('Porfavor coloque una localidad valida valido') }
	// 	}
	// });

	$('#btnGuardar').click(function(){
		dep = $.trim($('#txtDepCod').val());
		loc = $.trim($('#txtLocCod').val());
		ord = $.trim($('#txtCodOrd').val());
		pqr = $.trim($('#txtPqrCod').val());
		tec = $.trim($('#txtTecCod').val());
		fec = $.trim($('#txtFechaAsig').val());
		if( (dep!='') && (loc!='') && (ord!='') && (pqr!='') && (tec!='') && (fec!='') ){
			var result = confirm("Esta seguro que desea desasignar esta orden");
			if(result){
			    desasignarOrden(dep,loc,ord);
			}
		}else{ 
			var msgError = 'Porfavor complete los datos';
			demo.showNotification('bottom','left', msgError, 4);
		}
	});

	$('#btnCancelar').click(function(){
		
		$('#txtDepCod').val('');
		$('#txtLocCod').val('');
		$('#txtCodOrd').val('');
		$('#txtPqrCod').val('');
		$('#txtTecCod').val('');

		$('#txtDepNomb').val('');
		$('#txtLocNomb').val('');
		$('#txtCodOrd').val('');
		$('#txtPqrNomb').val('');
		$('#txtTecNomb').val('');

		$('#txtFechaAsig').val('');
		$('#btnGuardar').addClass('disabled');
	});
});
var modal = 1;
//DEPARTAMENTO
function addDepartamento(cod,dep){
	$('#txtDepCod').val(cod);
	$('#txtDepNomb').val(dep);
	$('#modalDepartamentos').modal('hide');
}
function buscarDepartamento(dep){
	$.ajax({
        type:'POST',
        url:'proc/pdesaot_proc.php?accion=buscar_departamento',
        data:{dep:dep},
        success: function(data){
        	$('#txtDepNomb').val(data);
        }
    });
}
//LOCALIDADES
function addLocalidad(cod,loc){
	$('#txtLocCod').val(cod);
	$('#txtLocNomb').val(loc);
	$('#modalLocalidad').modal('hide');
}
function buscarLocalidad(dep,loc){
	$.ajax({
        type:'POST',
        url:'proc/pdesaot_proc.php?accion=buscar_localidades',
        data:{dep:dep, loc:loc},
        success: function(data){
        	$('#txtLocNomb').val(data);
        }
    });
}
function actualizarLocalidad(dep){
	$.ajax({
        type:'POST',
        url:'proc/pdesaot_proc.php?accion=actualizar_localidades',
        data:{dep:dep},
        success: function(data){
        	$('#divLocalidades').html(data);
        	$('#modalLocalidad').modal('show');
        }
    });
}
//PQR
function addPqr(cod,pqr){
	$('#txtPqrCod').val(cod);
	$('#txtPqrNomb').val(pqr);
	$('#modalPqr').modal('hide');
}
function buscarPqr(pqr){
	if(pqr!=0){
		$.ajax({
	        type:'POST',
	        url:'proc/pdesaot_proc.php?accion=buscar_pqr',
	        data:{pqr:pqr},
	        success: function(data){
	        	$('#txtPqrNomb').val(data);
	        }
	    });
	}else{
		
		$('#txtPqrNomb').val('Todos');
	}
}
//TECNICO
function addTecnico(cod,tec){
	$('#txtTecCod').val(cod);
	$('#txtTecNomb').val(tec);
	$('#modalTecnicos').modal('hide');
}
function buscarTecnico(tec){
	$.ajax({
        type:'POST',
        url:'proc/pdesaot_proc.php?accion=buscar_tecnico',
        data:{tec:tec},
        success: function(data){
        	$('#txtTecNomb').val(data);
        }
    });
}
//ORDEN
function buscarOrden(dep,loc,ord){
	$.ajax({
        type:'POST',
        url:'proc/pdesaot_proc.php?accion=buscar_orden',
        data:{dep:dep, loc:loc, ord:ord},
        dataType: "json",
        success: function(data){
        	$('#txtPqrCod').val(data[0]);
        	$('#txtPqrNomb').val(data[1]);

        	$('#txtTecCod').val(data[2]);
        	$('#txtTecNomb').val(data[3]);

        	$('#txtFechaAsig').val(data[4]);
        	
        	if( data[4]!='' ){
        		$('#btnGuardar').removeClass('disabled');
        		$('#btnCancelar').removeClass('disabled');
        	}else{
        		$('#btnGuardar').addClass('disabled');
        		$('#btnCancelar').addClass('disabled');
        	}
        }
    });
}
function desasignarOrden(dep,loc,ord){
	$.ajax({
        type:'POST',
        url:'proc/pdesaot_proc.php?accion=desasignar_orden',
        data:{ dep:dep,loc:loc,ord:ord },
        success: function(data){
        	if(data==1){
        		var msgError = 'La orden se desasigno con exito';
				demo.showNotification('bottom','left', msgError, 2);
        		limpiarPantalla();
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
function limpiarPantalla(){
	$('#txtDepCod').val('');
	$('#txtLocCod').val('');
	$('#txtCodOrd').val('');
	$('#txtPqrCod').val('');
	$('#txtTecCod').val('');
	$('#txtFechaAsig').val('');
	
	$('#txtDepNomb').val('');
	$('#txtLocNomb').val('');
	$('#txtPqrNomb').val('');
	$('#txtTecNomb').val('');
	$('#btnGuardar').addClass('disabled');
}

function pressEnter(campo){
	if(campo==='txtDepCod'){
		dep = $.trim($('#txtDepCod').val());
		if(dep!=''){
			buscarDepartamento(dep);
		}else{ 
			var msgError = 'Porfavor coloque un departamento valido';
			demo.showNotification('bottom','left', msgError, 4);
		}
	}
	if(campo==='txtLocCod'){
		dep = $.trim($('#txtDepCod').val());
		loc = $.trim($('#txtLocCod').val());
		if( (dep!='') && (loc!='') ){
			buscarDepartamento(dep);
			buscarLocalidad(dep,loc);
		}else{ 
			var msgError = 'Porfavor coloque un departamento valido';
			demo.showNotification('bottom','left', msgError, 4);
		}
	}
	if(campo==='txtCodOrd'){ion(event){
		dep = $.trim($('#txtDepCod').val());
		loc = $.trim($('#txtLocCod').val());
		ord = $.trim($('#txtCodOrd').val());
		if( (dep!='') && (loc!='') ){
			buscarDepartamento(dep);
			buscarLocalidad(dep,loc);
			buscarOrden(dep,loc,ord);
		}else{ 
			var msgError = 'Porfavor coloque una localidad valida valido';
			demo.showNotification('bottom','left', msgError, 4);
		}
	}
}