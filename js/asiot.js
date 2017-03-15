$(document).ready(function(){

	$('#btnConsulta').addClass('disabled');

	$('.tableJs').DataTable({
	    //ajax : 'assets/inc/clss/tbl/tabla-apuestas-adm-apuesta.php?camp=0',
	    "iDisplayLength": 10,
	    "lengthMenu": [
	        [10, 20, 30, -1],
	        [10, 20, 30, "Todos"] // change per page values here 
	    ],
	    initComplete: function(oSettings, json) {
	        //$('.tooltips').tooltip();
	    },
	    pageLength: 10,
	    "language": {
	        "sProcessing":     "Procesando...",
	        "sLengthMenu":     "Mostrar _MENU_ Registros",
	        "sZeroRecords":    "No se encontraron resultados",
	        "sEmptyTable":     "No hay Datos registradas en el sistema",
	        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
	        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
	        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
	        "sInfoPostFix":    "",
	        "sSearch":         "",
	        "sUrl":            "",
	        "sInfoThousands":  ",",
	        "sLoadingRecords": "Cargando Datos...",
	        "oPaginate": {
	            "sFirst":    "Primero",
	            "sLast":     "Último",
	            "sNext":     "Siguiente",
	            "sPrevious": "Anterior"
	        },
	        "oAria": {
	            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
	            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
	        }
	      },
	    "searching": true,
	    "ordering": false,
	    "info": false,
	    "autoWidth": false
	    /*"columns": [
	        { "class": "text-center cod","width":"15%"},
	        { "class": "text-left","width":"30px"}
	    ]*/
	});

	$('#btnListaValores').click(function(){
		if(modal==1){
			$('#modalDepartamentos').modal('show');
		}else if(modal==2){
			dep = $('#txtDepCod').val();
			if(dep!=''){
				actualizarLocalidad(dep);
			}
		}else if(modal==3){
			$('#modalTecnicos').modal('show');
		}
	});

	$('#txtDepCod').click(function(){
		//$('#txtDepCod').val(cod);
		modal=1;
		$('#txtDepNomb').val('');
		$('#txtLocCod').val('');
		$('#txtLocNomb').val('');
		//$('#txtCodOrd').val('');
		//Usuario
		$('#txtUsuCod').val('');
		$('#txtUsuNomb').val('');
		$('#txtUsuDirec').val('');
		//Pqr
		$('#txtPqrCod').val('');
		$('#txtPqrNomb').val('');
		//Fechas
		$('#txtFechaReci').val('');
		$('#txtFechaAsig').val('');
		$('#txtFechaCump').val('');
		//Tecnico
		$('#txtTecCod').val('');
		$('#txtTecNomb').val('');
		
		$('#txtObservAsign').val('');
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
		//$('#txtLocCod').val();
		$('#txtLocNomb').val('');
		//Usuario
		$('#txtUsuCod').val('');
		$('#txtUsuNomb').val('');
		$('#txtUsuDirec').val('');
		//Pqr
		$('#txtPqrCod').val('');
		$('#txtPqrNomb').val('');
		//Fechas
		$('#txtFechaReci').val('');
		$('#txtFechaAsig').val('');
		$('#txtFechaCump').val('');
		//Tecnico
		$('#txtTecCod').val('');
		$('#txtTecNomb').val('');
		
		$('#txtObservAsign').val('');	
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

	$("#txtCodOrd").keypress(function(event){
		if(event.which == 13){
			dep = $.trim($('#txtDepCod').val());
			loc = $.trim($('#txtLocCod').val());
			num = $.trim($('#txtCodOrd').val());
			buscarDepartamento(dep);
			buscarLocalidad(dep,loc);
			if( (dep!='') && (loc!='') && (num!='') ){
				buscarOrden(dep,loc,num);
			}
		}
	});

	$('#btnCancelar').click(function(){
		limpiar();
		$('#btnGuardar').addClass('disabled');
		$('#btnCancelar').addClass('disabled');
	});

	$('#txtTecCod').click(function(){
		modal=3;
		//$('#txtLocCod').val();
		$('#txtTecNomb').val('');
	});

	$('#btnEditor').click(function(){
		var text = $('#'+ediText).val();
		$('#txtCampEditor').val(text);
		$('#editModal').modal('show');
	});

	$('#btnGuardar').click(function(){
		dep = $.trim($('#txtDepCod').val());
		loc = $.trim($('#txtLocCod').val());
		num = $.trim($('#txtCodOrd').val());
		fAg = $.trim($('#txtFechaAsig').val());
		tec = $.trim($('#txtTecCod').val());
		obs = $.trim($('#txtObservAsign').val());

		if( (dep!='') && (loc!='') && (num!='') && (fAg!='') && (tec!='') ){
			guardarOrden(dep,loc,num,fAg,tec,obs);
		}else{
			alert('Error! Porfavor complete todos los campos')
		}
	});

	$("#txtTecCod").keypress(function(event){
		if(event.which == 13){
			cod = $.trim($('#txtTecCod').val());
			if(cod!=''){
				buscarTecnico(cod);
			}
		}
	});

});

var modal = 1;
function buscarTecnico(cod){
	$.ajax({
        type:'POST',
        url:'proc/asiot_proc.php?accion=buscar_tecnico',
        data:{cod:cod},
        success: function(data){
        	$('#txtTecNomb').val(data);
        }
    });
}
function buscarDepartamento(dep){
	$.ajax({
        type:'POST',
        url:'proc/asiot_proc.php?accion=buscar_departamento',
        data:{dep:dep},
        success: function(data){
        	$('#txtDepNomb').val(data);
        }
    });
}
function addDepartamento(cod,dep){
	$('#txtDepCod').val(cod);
	$('#txtDepNomb').val(dep);
	$('#modalDepartamentos').modal('hide');
}
function actualizarLocalidad(dep){
	$.ajax({
        type:'POST',
        url:'proc/asiot_proc.php?accion=actualizar_localidades',
        data:{dep:dep},
        success: function(data){
        	$('#divLocalidades').html(data);
        	$('#modalLocalidad').modal('show');
        }
    });
}
function buscarLocalidad(dep,loc){
	$.ajax({
        type:'POST',
        url:'proc/asiot_proc.php?accion=buscar_localidades',
        data:{dep:dep, loc:loc},
        success: function(data){
        	$('#txtLocNomb').val(data);
        }
    });
}
function addLocalidad(cod,loc){
	$('#txtLocCod').val(cod);
	$('#txtLocNomb').val(loc);
	$('#modalLocalidad').modal('hide');
}
function buscarOrden(dep,loc,num){
	$.ajax({
        type:'POST',
        url:'proc/asiot_proc.php?accion=obtener_orden',
        data:{dep:dep, loc:loc, num:num},
        dataType: "json",
        success: function(data){
        	if(data[11]==0){
        		alert('Error! Porfavor coloque un numero de orden valida para asignar')
        	}else{
	        	$('#txtDepCod').val(dep);
				$('#txtLocCod').val(loc);
				$('#txtCodOrd').val(num);
				//Usuario
				$('#txtUsuCod').val(data[0]);
				$('#txtUsuNomb').val(data[1]);
				$('#txtUsuDirec').val(data[2]);
				//Pqr
				$('#txtPqrCod').val(data[3]);
				$('#txtPqrNomb').val(data[4]);
				//Fechas
				$('#txtFechaReci').val(data[5]);
				$('#txtFechaAsig').val(data[6]);
				$('#txtFechaCump').val(data[7]);
				//Tecnico
				$('#txtTecCod').val(data[8]);
				$('#txtTecNomb').val(data[9]);
				
				$('#txtObservAsign').val(data[10]);
				
				//Desbloquear 
				$('#btnGuardar').removeClass('disabled');
				$('#btnCancelar').removeClass('disabled');
        	}
        }
    });
}
function addTecnico(cod,nom){
	$('#txtTecCod').val(cod);
	$('#txtTecNomb').val(nom);
	$('#modalTecnicos').modal('hide');
}
function limpiar(){
	$('#txtDepCod').val('');
	$('#txtDepNomb').val('');
	$('#txtLocCod').val('');
	$('#txtLocNomb').val('');
	$('#txtCodOrd').val('');
	//Usuario
	$('#txtUsuCod').val('');
	$('#txtUsuNomb').val('');
	$('#txtUsuDirec').val('');
	//Pqr
	$('#txtPqrCod').val('');
	$('#txtPqrNomb').val('');
	//Fechas
	$('#txtFechaReci').val('');
	$('#txtFechaAsig').val('');
	$('#txtFechaCump').val('');
	//Tecnico
	$('#txtTecCod').val('');
	$('#txtTecNomb').val('');
	
	$('#txtObservAsign').val('');
}
function guardarOrden(dep,loc,num,fAg,tec,obs){
	$.ajax({
        type:'POST',
        url:'proc/asiot_proc.php?accion=guardar_orden',
        data:{dep:dep, loc:loc, num:num, fAg:fAg, tec:tec, obs:obs},
        success: function(data){
        	if(data==1){
        		alert('La OT se asigno correctamente')
        		limpiar();
        	}else{ alert(data) }
        }
    });
}

var ediText = '';
function editor(idText){

	ediText = idText;
}
function descargarEditor(){
	var text = 	$('#txtCampEditor').val();
	$('#'+ediText).val(text);
	$('#editModal').modal('hide');
}
//Otros
function solonumeros(){
	if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
	    event.returnValue = false;
}