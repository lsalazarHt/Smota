$(document).ready(function () {
	
    $('#tableDepa').DataTable({
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
	
	//Agregar nueva localidad
	$('#btnNuevo').click(function(){
		cod = $.trim($('#txtCodDepar').val());
		nom = $.trim($('#txtNomDepar').val());
		if( (cod!='') && (nom!='') ){

			//Agregar una nueva fila a la tabla
			var table = document.getElementById('tabla_localidades');
		    var rowCount = table.rows.length;
		    var row = table.insertRow(rowCount);
		    row.className = 'trDefault';
		    row.id = 'trSelect'+rowCount;

		    //Codigo
		    var cell1 = row.insertCell(0);
		    cell1.className = 'text-center';
		    cell1.innerHTML = '<input type="text" id="txtCod'+rowCount+'" class="form-control input-sm" onkeypress="solonumeros()" onclick="swEditor(\'txtCod'+rowCount+'\',\'trSelect'+rowCount+'\')"><input type="hidden" id="txtTipo'+rowCount+'" value="0">';
		    //Nombre
		    var cell2 = row.insertCell(1);
		    cell2.className = '';
		    cell2.innerHTML = '<input type="text" id="txtNomb'+rowCount+'" class="form-control input-sm" onclick="swEditor(\'txtNomb'+rowCount+'\',\'trSelect'+rowCount+'\')">';
		    //Accion
		    var cell3 = row.insertCell(2);
		    cell3.className = 'text-center ';
		    cell3.innerHTML = '<input type="checkbox" id="txtCkek'+rowCount+'" onclick="swEditor(\'\',\'trSelect'+rowCount+'\')" checked="checked">';

		    $('#contRow').val(rowCount);
		}else{
			alert('Porfavor coloque un departamento valido')
		}
	});
	//Guardar nuevas localidad
	$('#btnGuardar').click(function(){
		var cont = $('#contRow').val();
		var codDep = $('#txtCodDepar').val();

		for(var i=1;i<=cont;i++){
			var codOrgLoc = $.trim($('#txtCodOrg'+i).val());
			var codLoc = $.trim($('#txtCod'+i).val());
			var nomLoc = $.trim($('#txtNomb'+i).val());
			if($("#txtCkek"+i).is(':checked')) { chekLoc = 1; }
			else{ chekLoc = 0; }

			//
			if( $('#txtTipo'+i).val() == 1){ //Editar
				$.ajax({
			        type:'POST',
			        url:'proc/floca_proc.php?accion=editar_registros',
			        data:{codOrgLoc:codOrgLoc, codLoc:codLoc, nomLoc:nomLoc, codDep:codDep, chekLoc:chekLoc},
			        success: function(data){
			            if(data==1){
		                    actualizar();
			            }else{ alert(data+' Editar!') }
			        }
			    });
			}else{ // Nuevo
				sw = false;
				// Validar si ya existe
				for(var j=1;j<=cont;j++){
					if($('#txtTipo'+j).val() == 1){
						//Verificar si es igual
						if( ( $('#txtCod'+j).val() ) == ( $('#txtCod'+i).val() ) ){
							sw = true;	
						}
					}
					//Fin verificar
				}
				// Fin validar
				if(!sw){
					if( (codLoc!='') && (nomLoc!='') ){
						$.ajax({
					        type:'POST',
					        url:'proc/floca_proc.php?accion=guardar_registros',
					        data:{codLoc:codLoc, nomLoc:nomLoc, codDep:codDep},
					        success: function(data){
					            if(data==1){
				                    actualizar();
					            }else{ alert(data+' Agregar!') }
					        }
					    });
					}
				}else{
					alert('Error! Al Agregar '+$('#txtNomb'+i).val())
				}

			}
		}
	});
	//Cancelar fila localidad
	$('#btnEliminar').click(function(){
		var cont = $('#contRow').val();
		var codDep = $('#txtCodDepar').val();
		bootbox.confirm("Esta seguro que desea eliminar estos registros?", function(result) {
			if(result){
				for(var i=1;i<=cont;i++){
					var codLoc = $.trim($('#txtCod'+i).val());
					if($("#txtCkek"+i).is(':checked')) {
						$.ajax({
					        type:'POST',
					        url:'proc/floca_proc.php?accion=ocultar_registros',
					        data:{codLoc:codLoc, codDep:codDep},
					        success: function(data){
					            if(data==1){
				                    actualizar();
					            }else{ alert(data) }
					        }
					    });
					}
				}
			}
		});
	});

	//Input Codigo Departamento
	$('#txtCodDepar').click(function(){

		//$('#btnCancelarLocalidad').parent().parent().remove();
		$('#txtCodDepar').removeAttr('readonly');
		$('#btnNuevoModal').removeClass('display-none');
		$('#txtNomDepar').val('');
		limpiarTabla();

		$('#btnGuardar').addClass('disabled');
        $('#btnNuevo').addClass('disabled');
        $('#btnEliminar').addClass('disabled');
        $('#btnConsulta').removeClass('disabled');
        $('#btnCancelar').addClass('disabled');
        $('#btnListaValores').removeClass('disabled');
        $('#btnPrimer').addClass('disabled');
		$('#btnAnterior').addClass('disabled');
		$('#btnSiguiente').addClass('disabled');
		$('#btnUltimo').addClass('disabled');
	});

	//Seleccionar departamento
	$('#tableDepa tbody').on( 'click', 'tr', function () {
        if( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }else{
            $('#tableDepa').DataTable().$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            id =  $('.selected .cod').html();
            $('#modalDepartamentos').modal('hide');
            buscarNombreDepartamento(id);
        }
    });
	$("#txtCodDepar").keypress(function(event){
		if(event.which == 13){
			dep = $.trim($('#txtCodDepar').val());
			if(dep!=''){
				buscarNombreDepartamento(dep);
			}
		}
	});
	$('#btnCancelar').click(function(){
		$('#txtCodDepar').removeAttr('readonly');
		limpiarDepartamento();
		limpiarTabla();

		$('#btnGuardar').addClass('disabled');
        $('#btnNuevo').addClass('disabled');
        $('#btnEliminar').addClass('disabled');
        $('#btnConsulta').removeClass('disabled');
        $('#btnCancelar').addClass('disabled');
        $('#btnListaValores').removeClass('disabled');
        $('#btnPrimer').addClass('disabled');
		$('#btnAnterior').addClass('disabled');
		$('#btnSiguiente').addClass('disabled');
		$('#btnUltimo').addClass('disabled');

		swCons = false;
	})
	$('#btnConsulta').click(function(){
		$('#btnCancelar').removeClass('disabled');

		$('#btnPrimer').removeClass('disabled');
		$('#btnAnterior').removeClass('disabled');
		$('#btnSiguiente').removeClass('disabled');
		$('#btnUltimo').removeClass('disabled');

		cargarDepartamentos();
		swCons = true;
	});
	//Editor
	$('#btnEditor').click(function(){
		var dat = $('#'+varEditor).val();
		$('#txtCampEditor').val(dat);
		$('#editModal').modal('show');
	});
	$('#btnPrimer').click(function(){
		$('#txtActualDep').val(1);
		codDep = $('#txtCodDep1').val();
		buscarNombreDepartamento(codDep);
	});
	$('#btnAnterior').click(function(){
		codId = parseInt($('#txtActualDep').val());
		$('#txtActualDep').val(codId-1);
		codId = parseInt($('#txtActualDep').val());

		if(codId>=1){
			codDep = $('#txtCodDep'+codId).val();
			buscarNombreDepartamento(codDep);
		}else{
			$('#txtActualDep').val(1);
		}
	});
	$('#btnSiguiente').click(function(){
		codId = parseInt($('#txtActualDep').val());
		$('#txtActualDep').val(codId+1);
		codId = parseInt($('#txtActualDep').val());

		codUlt = parseInt($('#txtToltalDep').val());
		if(codId<=codUlt){
			codDep = $('#txtCodDep'+codId).val();
			buscarNombreDepartamento(codDep);
		}else{
			$('#txtActualDep').val(codUlt);
		}
	});
	$('#btnUltimo').click(function(){
		codUlt = parseInt($('#txtToltalDep').val());
		$('#txtActualDep').val(codUlt);
		codDep = $('#txtCodDep'+codUlt).val();
		buscarNombreDepartamento(codDep);
	});
	$('#btnListaValores').click(function(){
		$('#txtCodDepar').removeAttr('readonly');
		$('#modalDepartamentos').modal('show');
		limpiarDepartamento();
		limpiarTabla();
	});

	$('.trSelect input').focus(function(){
		alert()
	});
});
var swCons = false;
var varEditor = '';
function buscarNombreDepartamento(id){
	if(id!=0){
		buscarLocalidades(id);
	}else if(id==0){
		dep = $.trim($('#txtCodDepar').val());
		if(dep!=''){
			buscarLocalidades(dep);
		}else{
			alert('Porfavor coloque un departamento valido')
		}
	}
}
function buscarLocalidades(cod){
	$.ajax({
        type:'POST',
        url:'proc/floca_proc.php?accion=seleccionar_departamento',
        data:{cod:cod},
        success: function(data){
            $('#txtCodDepar').val(cod);
            $('#txtNomDepar').val(data);
            $('#txtCodDepar').attr('readonly','readonly');
            actualizar();

            $('#btnGuardar').removeClass('disabled');
            $('#btnNuevo').removeClass('disabled');
            $('#btnEliminar').removeClass('disabled');
            $('#btnConsulta').addClass('disabled');
            $('#btnCancelar').removeClass('disabled');
            $('#btnListaValores').addClass('disabled');
            //buscar

            if(!swCons){
	            $('#btnPrimer').addClass('disabled');
				$('#btnAnterior').addClass('disabled');
				$('#btnSiguiente').addClass('disabled');
				$('#btnUltimo').addClass('disabled');
            }
        }
    });
}
function cargarDepartamentos(){
	$('#divListaDepartamentos').html('');
	$.ajax({
        type:'POST',
        url:'proc/floca_proc.php?accion=cargar_departamento',
        data:{codDep:'1'},
        success: function(data){
            $('#divListaDepartamentos').html(data);
            $('#btnPrimer').click();
        }
    });
}
function limpiarDepartamento(){
	$('#txtCodDepar').val('');
	$('#txtNomDepar').val('');
}
function actualizar(){
	$('#tabla_localidades').html('');
	codDep = $.trim($('#txtCodDepar').val());
	$.ajax({
        type:'POST',
        url:'proc/floca_proc.php?accion=actualizar_localidad',
        data:{codDep:codDep},
        success: function(data){
            $('#tabla_localidades').html(data);
        }
    });
}
function solonumeros(){
    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
        event.returnValue = false;
}
function limpiarTabla(){
	a = '<thead><tr style="background-color: #3c8dbc; color:white;">';
	b = '<th class="text-center" style="width:50px;">CODIGO</th>';
	c = '<th class="text-center">NOMBRE</th>';
	d = '<th class="text-center" style="width:50px;">VISIBLE</th>';
	e = '</tr></thead><tbody></tbody>';
	$('#tabla_localidades').html(a+b+c+d+e);
}
//Ver origen del editor
function swEditor(id,trId){

	varEditor = id;
	$('.trDefault').removeClass('trSelect');
	$('#'+trId).addClass('trSelect');
}
function descargarEditor(){
	var dat = $('#txtCampEditor').val();
	$('#'+varEditor).val(dat);
	$('#editModal').modal('hide');
}
