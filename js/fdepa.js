$(document).ready(function () {
	
    $('#table').DataTable({
	    //ajax : 'assets/inc/clss/tbl/tabla-apuestas-adm-apuesta.php?camp=0',
	    "iDisplayLength": 20,
	    "lengthMenu": [
	        [20, 40, 60, -1],
	        [20, 40, 60, "Todos"] // change per page values here 
	    ],
	    initComplete: function(oSettings, json) {
	        //$('.tooltips').tooltip();
	    },
	    pageLength: 20,
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
	    "info": true,
	    "autoWidth": false,
	    "columns": [
	        { "class": "text-center","width":"10%"},
	        { "class": "text-left","width":"30px"},
	        { "class": "text-center","width":"10%", "orderable": false }
	    ]
	});
	
	$('.dataTables_filter input').attr("placeholder", "Buscar..");
	$('.dataTables_length select').attr("style", "height:32px; border-radius: 5px;");

	$('#btnNuevoModal').click(function(){
		$('#newModal').modal('show');
	});

});
function guardarDepartamento(){
	cod = $.trim($('#txtCodDepar').val());
	nom = $.trim($('#txtNomDepar').val());

	if( (cod!='') && (nom!='') ){
		$.ajax({
	        type:'POST',
	        url:'proc/fdepa_proc.php?accion=guardar_departamento',
	        data:{cod:cod,nom:nom},
	        success: function(data){
	            if(data==1){
                    actualizar();
                    limpiar();
	            }else{ alert(data) }
	        }
	    });
	}else{
		alert('Porfavor complete los datos')
	}
}
function selectDepartamento(id,nom){
	$('#txtCodDepar').val(id);
	$('#txtCodDepar').attr('readonly','readonly');
	$('#txtNomDepar').val(nom);

	$('#btnGuardar').addClass('display-none');
	$('#btnEditar').removeClass('display-none');
	$('#btnCancelar').removeClass('display-none');
}
function editarDepartamento(){
	cod = $.trim($('#txtCodDepar').val());
	nom = $.trim($('#txtNomDepar').val());

	if( (cod!='') && (nom!='') ){
		$.ajax({
	        type:'POST',
	        url:'proc/fdepa_proc.php?accion=editar_departamento',
	        data:{cod:cod,nom:nom},
	        success: function(data){
	            if(data==1){
	            	$('#btnGuardar').removeClass('display-none');
					$('#btnEditar').addClass('display-none');
					$('#btnCancelar').addClass('display-none');
                    actualizar();
                    limpiar();
	            }else{ alert(data) }
	        }
	    });
	}else{
		alert('Porfavor complete los datos')
	}
}
function eliminarDepartamento(cod){
	bootbox.confirm("Esta seguro que desea eliminar este departamento?", function(result) {
		if(result){
			$.ajax({
		        type:'POST',
		        url:'proc/fdepa_proc.php?accion=eliminar_departamento',
		        data:{cod:cod},
		        success: function(data){
		            actualizar();
		        }
		    });
		}
	});
}
function actualizar(){
	$.ajax({
        type:'POST',
        url:'proc/fdepa_proc.php?accion=actualizar_departamento',
        data:{id:'1'},
        success: function(data){
            $('#divDepartamento').html(data);
        }
    });
}
function cancelarDepartamento(){
	$('#btnGuardar').removeClass('display-none');
	$('#btnEditar').addClass('display-none');
	$('#btnCancelar').addClass('display-none');
	actualizar();
	limpiar();
}
function limpiar(){
	$('#txtCodDepar').val('');
	$('#txtNomDepar').val('');
	$('#txtCodDepar').removeAttr('readonly');
}
