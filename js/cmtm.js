$(document).ready(function () {
	
	$('#tableTipoM').DataTable({
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
	        { "class": "text-center cod","width":"10%"},
	        { "class": "text-left","width":"30px"}
	    ]
	});
	
	$('#tableClaseMaterial').DataTable({
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
	        { "class": "text-center cod","width":"10%"},
	        { "class": "text-left","width":"30px"}
	    ]
	});

	$('#btnNuevo').click(function(){
		cod = $.trim($('#txtCodTipoM').val());
		nom = $.trim($('#txtNomTipoM').val());
		if( (cod!='') && (nom!='') ){

			//Agregar una nueva fila a la tabla
			var table = document.getElementById('table');
		    var rowCount = table.rows.length;
		    var row = table.insertRow(rowCount);
		    row.className = 'trDefault';
		    row.id = 'trSelect'+rowCount;

		    //Codigo
		    var cell1 = row.insertCell(0);
		    cell1.className = 'text-center';
		    cell1.innerHTML = '<input type="text" id="txtCod'+rowCount+'" class="form-control input-sm text-center" onkeypress="solonumerosEnter('+rowCount+')" onclick="swEditor(\'txtCod'+rowCount+'\',\'trSelect'+rowCount+'\',2,'+rowCount+')"><input type="hidden" id="txtTipo'+rowCount+'" value="0">';
		    //Nombre
		    var cell2 = row.insertCell(1);
		    cell2.className = '';
		    cell2.innerHTML = '<input readonly type="text" id="txtNomb'+rowCount+'" class="form-control input-sm" onclick="swEditor(\'txtNomb'+rowCount+'\',\'trSelect'+rowCount+'\',0,'+rowCount+')">';
		     //Accion
		    var cell3 = row.insertCell(2);
		    cell3.className = 'text-center ';
		    cell3.innerHTML = '<input type="checkbox" id="txtCkek'+rowCount+'" onclick="swEditor(\'\',\'trSelect'+rowCount+'\',0,0)" checked="checked">';

		    $('#contRow').val(rowCount);
		    $('#txtCod'+rowCount).focus();
		    selectedNewRow(row.id);

		}else{
			/*
					BACKGROUND-COLOR ALERTAS
						AZUL = 1
						VERDE = 2
						NARANJA = 3
						ROJO = 4
					*/
					var msgError = 'Porfavor coloque un PQR valido';
					demo.showNotification('bottom','left', msgError, 4);
		}
	});

	$('#btnGuardar').click(function(){
		var cont = $('#contRow').val();
		var codTipoM = $('#txtCodTipoM').val();
		for(var i=1;i<=cont;i++){
			var cod = $.trim($('#txtCod'+i).val());
			var nom = $.trim($('#txtNomb'+i).val());
			if($("#txtCkek"+i).is(':checked')) { chek = 1; }
			else{ chek = 0; }

			if( $('#txtTipo'+i).val() == 1){ //Editar
				var codOrg = $.trim($('#txtCodOrg'+i).val());
				if( (cod!='') && (nom!='') ){
					$.ajax({
				        type:'POST',
				        url:'proc/cmtm_proc.php?accion=editar_registros',
				        data:{ codOrg:codOrg, codTipoM:codTipoM, cod:cod, chek:chek},
				        success: function(data){
				            console.log(data)
				            if(data==1){
			                    actualizar();
				            }else{ alert(data+' Editar!') }
				        }
				    });
				}
			}else{
				if( (cod!='') && (nom!='') ){
					$.ajax({
				        type:'POST',
				        url:'proc/cmtm_proc.php?accion=guardar_registros',
				        data:{ codTipoM:codTipoM, cod:cod},
				        success: function(data){
				            if(data==1){
			                    actualizar();
				            }else{ alert(data+' Agregar!') }
				        }
				    });
				}
			}

		}
	});

    $('#btnListaValores').click(function(){
		
		if(modal==1){
			$('#txtCodTipoM').removeAttr('readonly');
			$('#txtNomTipoM').val('');
			$('#modalTipoMov').modal('show');
			limpiarTabla();
		}else{
			$('#modalClaseMaterial').modal('show');
		}
	});

    $("#txtCodTipoM").click(function(){
		$('#btnCancelar').click();
		$('#txtCodTipoM').removeAttr('readonly');
		$('#txtNomTipoM').val('');
		limpiarTabla();
		modal=1;
	});

	$("#txtCodTipoM").keypress(function(event){
		if(event.which == 13){
			buscarNombreTipoM();
		}
	});

	$('#btnConsulta').click(function(){
		$('#btnCancelar').removeClass('disabled');

		$('#btnPrimer').removeClass('disabled');
		$('#btnAnterior').removeClass('disabled');
		$('#btnSiguiente').removeClass('disabled');
		$('#btnUltimo').removeClass('disabled');

		cargarTipoM();
	});

	$('#btnCancelar').click(function(){
		$('#divTipoM').html('');
		$('#txtCodTipoM').val('');
		$('#txtCodTipoM').removeAttr('readonly');
		$('#txtNomTipoM').val('');
		limpiarTabla();

		$('#btnGuardar').addClass('disabled');
        $('#btnNuevo').addClass('disabled');
        $('#btnCancelar').addClass('disabled');
        $('#btnConsulta').removeClass('disabled');

        $('#btnPrimer').addClass('disabled');
        $('#btnAnterior').addClass('disabled');
        $('#btnSiguiente').addClass('disabled');
        $('#btnUltimo').addClass('disabled');

        modal = 1;
	});

	$('#btnPrimer').click(function(){
		$('#txtActualTipo').val(1);
		cod = $('#txtCodTipo1').val();
		buscarNombreTipoM_Ant_Sgt(cod);
	});
	$('#btnAnterior').click(function(){
		codId = parseInt($('#txtActualTipo').val());
		$('#txtActualTipo').val(codId-1);
		codId = parseInt($('#txtActualTipo').val());

		if(codId>=1){
			cod = $('#txtCodTipo'+codId).val();
			buscarNombreTipoM_Ant_Sgt(cod);
		}else{
			$('#txtActualTipo').val(1);
		}
	});
	$('#btnSiguiente').click(function(){
		codId = parseInt($('#txtActualTipo').val());
		$('#txtActualTipo').val(codId+1);
		codId = parseInt($('#txtActualTipo').val());

		codUlt = parseInt($('#txtToltalTipo').val());
		if(codId<=codUlt){
			cod = $('#txtCodTipo'+codId).val();
			buscarNombreTipoM_Ant_Sgt(cod);
		}else{
			$('#txtActualTipo').val(codUlt);
		}
	});
	$('#btnUltimo').click(function(){
		codUlt = parseInt($('#txtToltalTipo').val());
		$('#txtActualTipo').val(codUlt);
		cod = $('#txtCodTipo'+codUlt).val();
		buscarNombreTipoM_Ant_Sgt(cod);
	});

});
var modal = 1;
var idGlob = 0;
function cargarTipoM(){
	$('#divTipoM').html('');
	$.ajax({
        type:'POST',
        url:'proc/cmtm_proc.php?accion=cargar_tipoM',
        data:{codDep:'1'},
        success: function(data){
            $('#divTipoM').html(data);
            $('#btnPrimer').click();
        }
    });
}
function buscarNombreTipoM_Ant_Sgt(cod){
	$.ajax({
        type:'POST',
        url:'proc/cmtm_proc.php?accion=seleccionar_tipoM',
        data:{cod:cod},
        success: function(data){
			$('#txtCodTipoM').val(cod)
            $('#txtNomTipoM').val(data);
            $('#txtCodTipoM').attr('readonly','readonly');
            actualizar();
        }
    });
}
function colocarTipoM(id,nom){
	$('#txtCodTipoM').val(id);
	$('#txtNomTipoM').val(nom);
	actualizar();
	$('#modalTipoMov').modal('hide');
}
function buscarNombreTipoM(){
	cod = $.trim($('#txtCodTipoM').val());
	if(cod!=''){
		$.ajax({
	        type:'POST',
	        url:'proc/cmtm_proc.php?accion=seleccionar_tipoM',
	        data:{cod:cod},
	        success: function(data){
	            $('#txtNomTipoM').val(data);
	            $('#txtCodTipoM').attr('readonly','readonly');
	            actualizar();
	        }
	    });
	}else{
		alert('Error! Porfavor coloque un Tipo de Movimiento valido')
	}
}
function colocarClase(cod,nom){
	sw = false;
	var cont = $('#contRow').val();
	for(var i=1;i<=cont;i++){
		var codOrg = $.trim($('#txtCod'+i).val());
		if(codOrg==cod){

			sw = true;
		}
	}

	if(!sw){
		$('#txtCod'+idGlob).val(cod);
		$('#txtNomb'+idGlob).val(nom);
		$('#modalClaseMaterial').modal('hide');
	}else{
		alert('Error! La Clase ya existe')
	}
}
function actualizar(){
	$('#table').html('');
	cod = $.trim($('#txtCodTipoM').val());
	$.ajax({
        type:'POST',
        url:'proc/cmtm_proc.php?accion=actualizar_registros',
        data:{cod:cod},
        success: function(data){
            $('#table').html(data);

            $('#btnGuardar').removeClass('disabled');
            $('#btnNuevo').removeClass('disabled');
            $('#btnCancelar').removeClass('disabled');
            $('#btnConsulta').addClass('disabled');
        }
    });
}
function solonumeros(){
    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
        event.returnValue = false;
}
function solonumerosEnter(id){
	if(event.which == 13){
		validarClase(id);
	}else{
	    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
	        event.returnValue = false;
	}
}
function validarClase(id){
	sw = false;
	$('#txtNomb'+id).val('');
	cod = $('#txtCod'+id).val();
	$('#txtCod'+id).val('');
	var cont = $('#contRow').val();
	for(var i=1;i<=cont;i++){
		var codOrg = $.trim($('#txtCod'+i).val());
		if(codOrg==cod){

			sw = true;
		}
	}
	
	if(!sw){
		$.ajax({
	        type:'POST',
	        url:'proc/cmtm_proc.php?accion=seleccionar_clase',
	        data:{cod:cod},
	        success: function(data){
				$('#txtCod'+id).val(cod);
				$('#txtNomb'+idGlob).val(data);
	        }
	    });
	}else{
		alert('Error! El material ya existe')
	}
}
function limpiarTabla(){
	a = '<thead><tr style="background-color: #3c8dbc; color:white;">';
	b = '<th class="text-center" width="100">CODIGO</th>';
	c = '<th class="text-center">NOMBRE</th>';
	d = '<th class="text-center" width="100">VISIBLE</th>';
	e = '</tr></thead><tbody></tbody>';
	$('#table').html(a+b+c+d+e);
}
//Ver origen del editor
var varEditor = '';
function swEditor(id,trId,mod,i){

	varEditor = id;
	$('.trDefault').removeClass('trSelect');
	$('#'+trId).addClass('trSelect');

	if(mod==2){
		modal=2;
	}
	idGlob = i;
}
function descargarEditor(){
	var dat = $('#txtCampEditor').val();
	$('#'+varEditor).val(dat);
	$('#editModal').modal('hide');
}
