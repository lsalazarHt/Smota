$(document).ready(function () {
	$('#btnEditor').addClass('disabled');

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
				alert('Porfavor coloque un codigo valido')
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
		$('#btnNuevo').addClass('disabled');
        $('#btnGuardar').addClass('disabled');
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

	$('#btnNuevo').click(function(){
		//Agregar una nueva fila a la tabla
		var table = document.getElementById('table_materiales');
	    var rowCount = table.rows.length;
	    var row = table.insertRow(rowCount);
	    row.className = 'trDefault';
	    row.id = 'trSelect'+rowCount;

	    //Codigo
	    var cell1 = row.insertCell(0);
	    cell1.className = 'text-center';
	    cell1.innerHTML = '<input type="text" id="txtCod'+rowCount+'" class="form-control input-sm text-center" onkeypress="solonumerosEnter()" onClick="swModal(4,'+rowCount+')"><input type="hidden" id="txtTipo'+rowCount+'" value="0">';
	    //Nombre
	    var cell2 = row.insertCell(1);
	    cell2.className = '';
	    cell2.innerHTML = '<input type="text" id="txtNomb'+rowCount+'" class="form-control input-sm" onClick="swModal(4,'+rowCount+')" readonly>';

	    var cell3 = row.insertCell(2);
	    cell3.className = '';
	    cell3.innerHTML = '<input type="text" id="txtCant'+rowCount+'" class="form-control input-sm text-center" onkeypress="solonumeros()" onClick="swModal(4,'+rowCount+')">';

	    var cell4 = row.insertCell(3);
	    cell4.className = '';
	    cell4.innerHTML = '<input type="text" id="txtVal'+rowCount+'" class="form-control input-sm text-right" onkeypress="solonumeros()" onClick="swModal(4,'+rowCount+')">';

	    $('#contRow').val(rowCount);
	});

	$('#btnGuardar').click(function(){
		

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
		alert('Porfavor coloque un codigo valido')
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
            actualizar();
            $('#btnNuevo').removeClass('disabled');
            $('#btnGuardar').removeClass('disabled');
            $('#btnConsulta').addClass('disabled');
        }
    });
}
function colocarBodega(id,nomb){
	$('#txtCodBodega').val(id);
	$('#txtNomBodega').val(nomb);
	actualizar();
	$('#modalBodega').modal('hide');
}

function actualizar(){
	cod = $("#txtCodBodega").val();
	$.ajax({
        type:'POST',
        url:'proc/mcupos_proc.php?accion=actualizar',
        data:{cod:cod},
        success: function(data){
            $('#table_detalle_inventario').html(data);

            calcularTotal();
        }
    });
}
function calcularTotal(){

	var cont = $('#contRow').val();
	var acom = 0;
	for(var i=1;i<=cont;i++){
		var cod = $.trim($('#txtValInvProp'+i).val());
		acom = parseInt(cod) + acom;
	}
	$('#txtTotalInvPropio').val( formato_numero(acom,0,'.',',') );

	var acom = 0;
	for(var i=1;i<=cont;i++){
		var cod = $.trim($('#txtValInvPres'+i).val());
		acom = parseInt(cod) + acom;
	}
	$('#txtTotalInvPrestado').val( formato_numero(acom,0,'.',',') );
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
function swEditor(id,trId,mod,i){

	varEditor = id;
	$('.trDefault').removeClass('trSelect');
	$('#'+trId).addClass('trSelect');
}
function formato_numero(numero, decimales, separador_decimal, separador_miles){

    numero=parseFloat(numero);
    if(isNaN(numero)){
        return "";
    }

    if(decimales!==undefined){
        // Redondeamos
        numero=numero.toFixed(decimales);
    }

    // Convertimos el punto en separador_decimal
    numero=numero.toString().replace(".", separador_decimal!==undefined ? separador_decimal : ",");

    if(separador_miles){
        // Añadimos los separadores de miles
        var miles=new RegExp("(-?[0-9]+)([0-9]{3})");
        while(miles.test(numero)) {
            numero=numero.replace(miles, "$1" + separador_miles + "$2");
        }
    }
    return numero;
}