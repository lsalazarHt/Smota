$(document).ready(function () {

	$('#btnConsulta').addClass('disabled');
	$('#btnEditor').addClass('disabled');

	$('#tableCuadrill').DataTable({
	    //ajax : 'assets/inc/clss/tbl/tabla-apuestas-adm-apuesta.php?camp=0',
	    "iDisplayLength": 5,
	    "lengthMenu": [
	        [5, 7, 10, -1],
	        [5, 7, 10, "Todos"] // change per page values here 
	    ],
	    initComplete: function(oSettings, json) {
	        //$('.tooltips').tooltip();
	    },
	    pageLength: 5,
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
	    "autoWidth": false,
	    "columns": [
	        { "class": "text-center"},
	        { "class": "text-left"}
	    ]
	});

	/*$('#btnListaValores').click(function(){

		$('#modalCuadrillas').modal('show');
	});

	$("#txtCodCuad").keypress(function(event){
		if(event.which == 13){
			id = $.trim($('#txtCodCuad').val());
			if(id!=''){
				buscarCuadrilla(id);
			}else{
				alert('Error! Porfavor coloque una cuadrilla valida')
			}
		}
	});

	$("#txtCodCuad").click(function(){
		$('#txtCodCuad').val('');
		$('#txtNomCuad').val('');
	});*/

	$('#btnConfg').click(function(){
		obtenerDatos();
		$('#modalConfArchivo').modal('show');
	});

	$("#brnCargar").click(function(){
		var cod = $('#txtCodCuad').val();
		var nom = $('#txtNomCuad').val();

		if( (cod!='') && (nom!='') ){
			$('#formCargarArchivos').submit();
		}else{
			alert('Porfavor coloque una cuadrilla valida')			
		}
	});

});

function colocarCuadrilla(id,nomb){
	$('#txtCodCuad').val(id);
	$('#txtNomCuad').val(nomb);
	
	$('#modalCuadrillas').modal('hide');
}
function buscarCuadrilla(cod){
	$.ajax({
        type:'POST',
        url:'proc/peatsc_proc.php?accion=buscar',
        data:{cod:cod},
        success: function(data){
        	$('#txtNomCuad').val(data);
        }
    });
}
function obtenerDatos(){
	$.ajax({
        type:'POST',
        url:'proc/peatsc_proc.php?accion=obtener_campos',
        data:{cod:'1'},
        dataType: "json",
        success: function(data){
        	$('#txtCodDep').val(data[0]);
        	$('#txtCodLoc').val(data[1]);
        	$('#txtCodOrd').val(data[2]);
        	$('#txtFecOrd').val(data[3]);
        	$('#txtUsuario').val(data[4]);
        	$('#txtPqrReport').val(data[5]);
        	$('#txtObservacion').val(data[6]);
        }
    });
}
function guardarDatos(){
	var a = $('#txtCodDep').val();
	var b = $('#txtCodLoc').val();
	var c = $('#txtCodOrd').val();
	var d = $('#txtFecOrd').val();
	var e = $('#txtUsuario').val();
	var f = $('#txtPqrReport').val();
	var g = $('#txtObservacion').val();

	if( (a!='') && (b!='') && (c!='') && (d!='') && (e!='') && (f!='') && (g!='') ){
		$.ajax({
	        type:'POST',
	        url:'proc/peatsc_proc.php?accion=guardarCambios',
	        data:{a:a, b:b, c:c, d:d, e:e, f:f, g:g},
	        success: function(data){
	        	if(data==1){
					$('#modalConfArchivo').modal('hide');
		        	alert('Los Cambios de guardaron correctamente!')
	        	}else{
	        		alert(data)
	        	}
	        }
	    });
	}else{
		alert('Porfavor complete todos los campos')
	}
}