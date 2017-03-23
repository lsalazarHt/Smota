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
		$('#txtCauAtenCod').val('');
		$('#txtCauAtenNomb').val('');
		$('#txtObservIncump').val('');
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
		}else{

			$('#modalCausaNoAtencion').modal('show');
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

    	$('#txtCauAtenCod').val('');
    	$('#txtCauAtenNomb').val('');

    	$('#txtObservIncump').val('');
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

    	$('#txtCauAtenCod').val('');
    	$('#txtCauAtenNomb').val('');

    	$('#txtObservIncump').val('');
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

    	$('#txtCauAtenCod').val('');
    	$('#txtCauAtenNomb').val('');

    	$('#txtObservIncump').val('');
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

	$('#txtCauAtenCod').focus(function(){
		modal = 3;
    	$('#txtCauAtenNomb').val('');
	});
	// $("#txtCauAtenCod").keypress(function(event){
	// 	if(event.which == 13){
	// 		cod = $.trim($('#txtCauAtenCod').val());
	// 		if( cod!='' ){
	// 			buscarCausaNoAten(cod);
	// 		}else{ alert('Porfavor coloque una causa valida valido') }
	// 	}
	// });

	$('#btnGuardar').click(function(){
		dep = $.trim($('#txtDepCod').val());
		loc = $.trim($('#txtLocCod').val());
		ord = $.trim($('#txtCodOrd').val());
		pqr = $.trim($('#txtPqrCod').val());
		fec = $.trim($('#txtFechaAsig').val());
		cna = $.trim($('#txtCauAtenCod').val());
		obs = $.trim($('#txtObservIncump').val());

		if( (dep!='') && (loc!='') && (ord!='') && (pqr!='') && (cna!='') ){
			var result = confirm("Esta seguro que desea incumplir esta orden");
			if(result){
			    incumplirOrden(dep,loc,ord,cna,obs);
			}
		}else{ 
			var msgError = 'Porfavor complete los datos';
			demo.showNotification('bottom','left', msgError, 4);
		}
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
        url:'proc/icont_proc.php?accion=buscar_departamento',
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
        url:'proc/icont_proc.php?accion=buscar_localidades',
        data:{dep:dep, loc:loc},
        success: function(data){
        	$('#txtLocNomb').val(data);
        }
    });
}
function actualizarLocalidad(dep){
	$.ajax({
        type:'POST',
        url:'proc/icont_proc.php?accion=actualizar_localidades',
        data:{dep:dep},
        success: function(data){
        	$('#divLocalidades').html(data);
        	$('#modalLocalidad').modal('show');
        }
    });
}
//CAUSA NO ATENCION
function addCausaNoAten(cod,cau){
	$('#txtCauAtenCod').val(cod);
	$('#txtCauAtenNomb').val(cau);
	$('#modalCausaNoAtencion').modal('hide');
}
function buscarCausaNoAten(cod){
	$.ajax({
        type:'POST',
        url:'proc/icont_proc.php?accion=buscar_causaNoAtencion',
        data:{cod:cod},
        success: function(data){
        	$('#txtCauAtenNomb').val(data);
        }
    });
}
//ORDEN
function buscarOrden(dep,loc,ord){
	$.ajax({
        type:'POST',
        url:'proc/icont_proc.php?accion=buscar_orden',
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
function incumplirOrden(dep,loc,ord,cna,obs){
	$.ajax({
        type:'POST',
        url:'proc/icont_proc.php?accion=incumplir_orden',
        data:{ dep:dep,loc:loc,ord:ord,cna:cna,obs:obs },
        success: function(data){
        	if(data==1){
        		var msgError = 'La orden se incumplio con exito';
			demo.showNotification('bottom','left', msgError, 2);
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
	if(campo==='txtCodOrd'){
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
	if(campo==='txtCauAtenCod'){
		cod = $.trim($('#txtCauAtenCod').val());
		if( cod!='' ){
			buscarCausaNoAten(cod);
		}else{ 
			var msgError = 'Porfavor coloque una causa valida valido';
			demo.showNotification('bottom','left', msgError, 4);
		}
	}
}