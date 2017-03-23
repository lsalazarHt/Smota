$(document).ready(function () {
	$('#btnEditor').addClass('disabled');
	$('#btnImprimir').removeClass('disabled');

	$('#tableBodega').DataTable({
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
	    "autoWidth": false,
	    "columns": [
	        { "class": "text-center cod","width":"10%"},
	        { "class": "text-left","width":"30px"}
	    ]
	});

	$("#txtCodBodega").click(function(){

		$('#btnCancelar').click();
	});
	$("#txtCodBodega").keypress(function(event){
		if(event.which == 13){
			cod = $("#txtCodBodega").val();
			if(cod!=''){
				buscarNombreBodega(cod);
			}else{
				var msgError = 'Porfavor coloque un codigo valido';
				demo.showNotification('bottom','left', msgError, 4);
			}
		}
	});

	$('#btnListaValores').click(function(){
		if(modal==1){
			$('#modalBodega').modal('show');
		}
	});
	$('#btnConsulta').click(function(){
		$('#btnConsulta').addClass('disabled');
		$('#btnCancelar').removeClass('disabled');

		$('#btnPrimer').removeClass('disabled');
		$('#btnAnterior').removeClass('disabled');
		$('#btnSiguiente').removeClass('disabled');
		$('#btnUltimo').removeClass('disabled');

		cargarTodos();
	});
	$('#btnCancelar').click(function(){
		$('#btnConsulta').removeClass('disabled');
		$('#btnCancelar').addClass('disabled');

		$('#btnPrimer').addClass('disabled');
		$('#btnAnterior').addClass('disabled');
		$('#btnSiguiente').addClass('disabled');
		$('#btnUltimo').addClass('disabled');
		limpiar();
	});

	
	$('#btnPrimer').click(function(){
		$('#txtActual').val(1);
		cod = $('#txtCod1').val();
		buscarNombreBodega(cod);
	});
	$('#btnAnterior').click(function(){
		codId = parseInt($('#txtActual').val());
		$('#txtActual').val(codId-1);
		codId = parseInt($('#txtActual').val());

		if(codId>=1){
			cod = $('#txtCod'+codId).val();
			buscarNombreBodega(cod);
		}else{
			$('#txtActual').val(1);
		}
	});
	$('#btnSiguiente').click(function(){
		codId = parseInt($('#txtActual').val());
		$('#txtActual').val(codId+1);
		codId = parseInt($('#txtActual').val());

		codUlt = parseInt($('#txtToltal').val());
		if(codId<=codUlt){
			cod = $('#txtCod'+codId).val();
			buscarNombreBodega(cod);
		}else{
			$('#txtActual').val(codUlt);
		}
	});
	$('#btnUltimo').click(function(){
		codUlt = parseInt($('#txtToltal').val());
		$('#txtActual').val(codUlt);
		cod = $('#txtCod'+codUlt).val();
		buscarNombreBodega(cod);
	});

	$('#btnImprimir').click(function(){
		cod = $("#txtCodBodega").val();
		nomb = $("#txtNomBodega").val();
		if( (cod!='') && (nomb!='') ){
			imprimirInventarioBodega(cod);
		}else{
			var msgError = 'Porfavor coloque un codigo valido';
			demo.showNotification('bottom','left', msgError, 4);
		}
	});

});

var modal = 1;
function cargarTodos(){
	$('#divLista').html('');
	$.ajax({
        type:'POST',
        url:'proc/mcupos_proc.php?accion=cargar_todos',
        data:{codDep:'1'},
        success: function(data){
            $('#divLista').html(data);
            $('#btnPrimer').click();
        }
    });
}
function btn_buscarNombreBodega(){
	cod = $("#txtCodBodega").val();
	if(cod!=''){
		buscarNombreBodega(cod);
	}else{
		var msgError = 'Porfavor coloque un codigo valido';
		demo.showNotification('bottom','left', msgError, 4);
	}
}
function buscarNombreBodega(cod){
	$.ajax({
        type:'POST',
        url:'proc/mcupos_proc.php?accion=seleccionar_nombre',
        data:{cod:cod},
        success: function(data){
        	$('#btnCancelar').removeClass('disabled');
            $('#txtCodBodega').val(cod);
            $('#txtNomBodega').val(data);
            //$('#txtCodPqr').attr('readonly','readonly');
        }
    });
}
function imprimirInventarioBodega(cod){

	window.open('lcumaco_report.php?cod='+cod, "Imprimir Inventario Tecnico", "width=1200, height=620");
}
function colocarBodega(id,nomb){
	$('#txtCodBodega').val(id);
	$('#txtNomBodega').val(nomb);
	$('#modalBodega').modal('hide');
}
function solonumeros(){
    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
        event.returnValue = false;
}
function limpiar(){
    $('#txtCodBodega').val('');
	$('#txtTotalInvPropio').val(0);
	$('#txtTotalInvPrestado').val(0);
    $('#txtNomBodega').val('');
	$('#divLista').html('');
	$('#table_detalle_inventario').html('');
}