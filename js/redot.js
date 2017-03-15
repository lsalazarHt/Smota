$(document).ready(function(){
	$('#btnCancelar').removeClass('disabled');
	$('#btnConsulta').addClass('disabled');
	//$('#btnEditor').addClass('disabled');

	$('#btnEditor').click(function(){
		var dat = $('#'+varEditor).val();
		$('#txtCampEditor').val(dat);
		$('#editModal').modal('show');
	});

	$('#btnCancelar').click(function(){
		
		$('#txtDepCod').val('');
		$('#txtDepNomb').val('');
		$('#txtLocCod').val('');
		$('#txtLocNomb').val('');
		$('#txtCodOrd').val('');
		$('#txtPqrCod').val('');
		$('#txtPqrNomb').val('');
		$('#txtTecCod').val('');
		$('#txtTecNomb').val('');
		$('#txtFechaAsig').val('');
		$('#txtObserv').val('');
		$('#btnGuardar').addClass('disabled');
	});

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

	$('#txtDepCod').click(function(){

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

    	$('#txtObserv').val('');
    	$('#btnGuardar').addClass('disabled');
		$('#btnGuardar').addClass('disabled');
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
		$('#txtPqrCod').val('');
    	$('#txtPqrNomb').val('');

    	$('#txtTecCod').val('');
    	$('#txtTecNomb').val('');

    	$('#txtFechaAsig').val('');

    	$('#txtObserv').val('');
    	$('#btnGuardar').addClass('disabled');
		$('#btnGuardar').addClass('disabled');
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

	$('#txtCodOrd').click(function(){
		$('#txtPqrCod').val('');
    	$('#txtPqrNomb').val('');

    	$('#txtTecCod').val('');
    	$('#txtTecNomb').val('');

    	$('#txtFechaAsig').val('');

    	$('#txtObserv').val('');
    	$('#btnGuardar').addClass('disabled');
	});
	$("#txtCodOrd").keypress(function(event){
		if(event.which == 13){
			dep = $.trim($('#txtDepCod').val());
			loc = $.trim($('#txtLocCod').val());
			ord = $.trim($('#txtCodOrd').val());
			if( (dep!='') && (loc!='') ){
				buscarDepartamento(dep);
				buscarLocalidad(dep,loc);
				buscarOrden(dep,loc,ord);
			}else{ alert('Porfavor coloque una localidad valida valido') }
		}
	});

	$('#btnGuardar').click(function(){
		dep = $.trim($('#txtDepCod').val());
		loc = $.trim($('#txtLocCod').val());
		ord = $.trim($('#txtCodOrd').val());
		pqr = $.trim($('#txtPqrCod').val());
		fec = $.trim($('#txtFechaAsig').val());
		obs = $.trim($('#txtObservIncump').val());

		if( (dep!='') && (loc!='') && (ord!='') && (pqr!='') ){
			var result = confirm("Esta seguro que desea redimir esta orden");
			if(result){
			    redimirOrden(dep,loc,ord,obs);
			}
		}else{ alert('Porfavor complete los datos') }
	});
});
//DEPARTAMENTO
var modal = 1;
function addDepartamento(cod,dep){
	$('#txtDepCod').val(cod);
	$('#txtDepNomb').val(dep);
	$('#modalDepartamentos').modal('hide');
}
function buscarDepartamento(dep){
	$.ajax({
        type:'POST',
        url:'proc/redot_proc.php?accion=buscar_departamento',
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
        url:'proc/redot_proc.php?accion=buscar_localidades',
        data:{dep:dep, loc:loc},
        success: function(data){
        	$('#txtLocNomb').val(data);
        }
    });
}
function actualizarLocalidad(dep){
	$.ajax({
        type:'POST',
        url:'proc/redot_proc.php?accion=actualizar_localidades',
        data:{dep:dep},
        success: function(data){
        	$('#divLocalidades').html(data);
        	$('#modalLocalidad').modal('show');
        }
    });
}
//ORDEN
function buscarOrden(dep,loc,ord){
	$.ajax({
        type:'POST',
        url:'proc/redot_proc.php?accion=buscar_orden',
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
function redimirOrden(dep,loc,ord,obs){
	$.ajax({
        type:'POST',
        url:'proc/redot_proc.php?accion=redimir_orden',
        data:{ dep:dep,loc:loc,ord:ord,obs:obs },
        success: function(data){
        	if(data==1){
        		alert('La orden se redimio con exito')
        		$('#btnCancelar').click();
        	}else{
        		alert(data)
        	}
        }
    });
}
//OTROS
varEditor = '';
function solonumeros(){
	if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
	    event.returnValue = false;
}
function editor(id){

	varEditor = id;
}
function descargarEditor(){
	var dat = $('#txtCampEditor').val();
	$('#'+varEditor).val(dat);
	$('#editModal').modal('hide');
}
