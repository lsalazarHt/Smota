$(document).ready(function(){
	$('#btnGuardar').removeClass('disabled');
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
		}else if(modal==3){

			$('#modalPqr').modal('show');
		}else{
			pqr = $('#txtPqrCod').val();
			if(pqr!=''){
				actualizarTecnico(pqr);
			}else{
				alert('Porfavor coloque un pqr valido')
			}
		}
	});

	$('#txtDepCod').click(function(){

		modal=1;
		$('#txtDepNomb').val('');

		$('#txtLocCod').val('');
		$('#txtLocNomb').val('');

		$('#txtCodOrd').val('');
	});
	$("#txtDepCod").keypress(function(event){
		if(event.which == 13){
			dep = $.trim($('#txtDepCod').val());
			if(dep!=''){
				buscarDepartamento(dep);
			}else{ alert('Porfavor coloque un departamento valido') }
		}
	});

	$('#txtLocCod').click(function(){

		modal=2;
		$('#txtLocNomb').val('');
		$('#txtCodOrd').val('');
	});
	$("#txtLocCod").keypress(function(event){
		if(event.which == 13){
			dep = $.trim($('#txtDepCod').val());
			loc = $.trim($('#txtLocCod').val());
			if( (dep!='') && (loc!='') ){
				buscarDepartamento(dep);
				buscarLocalidad(dep,loc);
			}else{ alert('Porfavor coloque un departamento valido') }
		}
	});

	$('#txtPqrCod').click(function(){

		modal=3;
		$('#txtPqrNomb').val('');

		$('#txtTecCod').val('');
		$('#txtTecNomb').val('');
	});
	$("#txtPqrCod").keypress(function(event){
		if(event.which == 13){
			pqr = $.trim($('#txtPqrCod').val());
			if( (pqr!='') ){
				buscarPqr(pqr);
			}else{ alert('Porfavor coloque un pqr valido') }
		}
	});

	$('#txtTecCod').click(function(){

		modal=4;
		$('#txtTecNomb').val('');
	});
	$("#txtTecCod").keypress(function(event){
		if(event.which == 13){
			cod = $.trim($('#txtTecCod').val());
			pqr = $('#txtPqrCod').val();

			if( (cod!='') && (pqr!='') ){
				buscarPqr(pqr);
				buscarTecnico(pqr,cod);
			}else{ alert('Porfavor complete los datos') }
		}
	});

	$('#btnGuardar').click(function(){
		dep = $('#txtDepCod').val();
		loc = $('#txtLocCod').val();
		pqr = $('#txtPqrCod').val();
		tec = $('#txtTecCod').val();

		if( (dep!='') && (loc!='') && (pqr!='') && (tec!='') ){
			var result = confirm("Esta seguro que desea desasignar estas orden");
			if(result){
			    desasignarOrdenes(dep,loc,pqr,tec);
			}
		}else{
			alert('Porfavor complete los datos')
		}
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
        url:'proc/pdelote_proc.php?accion=buscar_departamento',
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
        url:'proc/pdelote_proc.php?accion=buscar_localidades',
        data:{dep:dep, loc:loc},
        success: function(data){
        	$('#txtLocNomb').val(data);
        }
    });
}
function actualizarLocalidad(dep){
	$.ajax({
        type:'POST',
        url:'proc/pdelote_proc.php?accion=actualizar_localidades',
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
	        url:'proc/pdelote_proc.php?accion=buscar_pqr',
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
function actualizarTecnico(pqr){
	$.ajax({
        type:'POST',
        url:'proc/pdelote_proc.php?accion=actualizar_tecnico',
        data:{pqr:pqr},
        success: function(data){
        	$('#divTecnicos').html(data);
        	$('#modalTecnicos').modal('show');
        }
    });
}
function buscarTecnico(pqr,tec){
	$.ajax({
        type:'POST',
        url:'proc/pdelote_proc.php?accion=buscar_tecnico',
        data:{tec:tec,pqr:pqr},
        success: function(data){
        	$('#txtTecNomb').val(data);
        }
    });
}
//ORDENES
function desasignarOrdenes(dep,loc,pqr,tec){
	$.ajax({
        type:'POST',
        url:'proc/pdelote_proc.php?accion=desasignar_ordenes',
        data:{ dep:dep,loc:loc,pqr:pqr,tec:tec },
        success: function(data){
        	if(data==1){
        		alert('Las ordenes se desasignaron con exito')
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
	$('#txtPqrCod').val('');
	$('#txtTecCod').val('');
	
	$('#txtDepNomb').val('');
	$('#txtLocNomb').val('');
	$('#txtPqrNomb').val('');
	$('#txtTecNomb').val('');
}