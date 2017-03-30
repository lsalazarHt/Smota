$(document).ready(function () {
	$(document).ajaxStart(function () { 
		$.blockUI({
			message: "Un momento por favor....",
			css: { 
	            border: 'none', 
	            padding: '15px', 
	            backgroundColor: '#000', 
	            '-webkit-border-radius': '10px', 
	            '-moz-border-radius': '10px', 
	            opacity: .5, 
	            color: '#fff' 
	        } })
	}).ajaxStop($.unblockUI);
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
	
    //Seleccionar departamento
	$('#tableDepa tbody').on( 'click', 'tr', function () {
        if( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }else{
            $('#tableDepa').DataTable().$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            id =  $('.selected .cod').html();
            $('#txtCodDepar').val(id);
            $('#modalDepartamentos').modal('hide');
            
            dep = $.trim($('#txtCodDepar').val());
			if(dep!=''){
				buscarNombreDepartamento(dep);
				actualizarCiudades(dep);
				swCons = false;
			}
        }
    });
    $('#txtCodDepar').click(function(){

		$('#btnListaValores').removeClass('disabled');
		$('#btnGuardar').addClass('disabled');
		$('#btnNuevo').addClass('disabled');
		limpiarTabla();
		$('#txtCodDepar').removeAttr('readonly');
		$('#txtCodLoca').removeAttr('readonly');
		$('#btnNuevoModal').removeClass('display-none');
		$('#txtNomDepar').val('');
		$('#divListaCiudades').html('');

		//Localidades
		$('#txtCodLoca').val('');
		$('#txtNomLoca').val('');
		modal = 0;
		swCons = true;

		//btn
		$('#btnPrimer').addClass('disabled');
		$('#btnAnterior').addClass('disabled');
		$('#btnSiguiente').addClass('disabled');
		$('#btnUltimo').addClass('disabled');
	});
	$("#txtCodDepar").keypress(function(event){
		if(event.which == 13){
			dep = $.trim($('#txtCodDepar').val());
			if(dep!=''){
				buscarNombreDepartamento(dep);
				actualizarCiudades(dep);
				swCons = false;
			}
		}
	});

	//Seleccionar localidades
	$('#txtCodLoca').click(function(){

		$('#btnListaValores').removeClass('disabled');
		$('#btnGuardar').addClass('disabled');
		$('#btnNuevo').addClass('disabled');
		limpiarTabla();
		$('#txtCodLoca').removeAttr('readonly');
		$('#txtCodLoca').val('');
		$('#txtNomLoca').val('');
		modal = 1;
	});
	$("#txtCodLoca").keypress(function(event){
		if(event.which == 13){
			loc = $.trim($('#txtCodLoca').val());
			dep = $.trim($('#txtCodDepar').val());
			if( (loc!='') && (dep!='') ){
				buscarNombreDepartamento(dep);
				buscarNombreLocalidades(loc);
			}else{
				var msgError = 'Porfavor complete los datos';
				demo.showNotification('bottom','left', msgError, 4);
			}
		}
	});

	//Btn Agregar
	$('#btnNuevo').click(function(){
		codDep = $.trim($('#txtCodDepar').val());
		nomDep = $.trim($('#txtNomDepar').val());

		codLoc = $.trim($('#txtCodLoca').val());
		nomLoc = $.trim($('#txtNomLoca').val());

		if( (codDep!='') && (nomDep!='') && (codLoc!='') && (nomLoc!='') ){

			//Agregar una nueva fila a la tabla
			var table = document.getElementById('table');
		    var rowCount = table.rows.length;
		    var row = table.insertRow(rowCount);
		    row.className = 'trDefault';
		    row.id = 'trSelect'+rowCount;

		    //Codigo
		    var cell1 = row.insertCell(0);
		    cell1.className = 'text-center';
		    cell1.innerHTML = '<input type="text" id="txtCod'+rowCount+'" class="form-control input-sm" onkeypress="solonumeros()" onclick="swEditor(\'txtCod'+rowCount+'\',\'trSelect'+rowCount+'\')" readonly><input type="hidden" id="txtTipo'+rowCount+'" value="0">';
		    //Nombre
		    var cell2 = row.insertCell(1);
		    cell2.className = '';
		    cell2.innerHTML = '<input type="text" id="txtNomb'+rowCount+'" class="form-control input-sm" onclick="swEditor(\'txtNomb'+rowCount+'\',\'trSelect'+rowCount+'\')">';
		    //Accion
		    var cell3 = row.insertCell(2);
		    cell3.className = 'text-center ';
		    cell3.innerHTML = '<input type="checkbox" id="txtCkek'+rowCount+'" onclick="swEditor(\'\',\'trSelect'+rowCount+'\')" checked="checked">';

		    $('#contRow').val(rowCount);
		    $('#txtCod'+rowCount).focus();
		    selectedNewRow(row.id);
		}else{
			var msgError = 'Porfavor coloque los datos valido';
			demo.showNotification('bottom','left', msgError, 4);
		}
	});
	
	//Btn Guardar
	$('#btnGuardar').click(function(){
		var cont = $('#contRow').val();
		var codDep = $('#txtCodDepar').val();
		var codLoc = $('#txtCodLoca').val();

		for(var i=1;i<=cont;i++){
			var codOrg = $.trim($('#txtCodOrg'+i).val());
			var codZon = $.trim($('#txtCod'+i).val());
			var nomZon = $.trim($('#txtNomb'+i).val());
			if($("#txtCkek"+i).is(':checked')) { chek = 1; }
			else{ chek = 0; }

			//
			if( $('#txtTipo'+i).val() == 1){ //Editar
				$.ajax({
			        type:'POST',
			        url:'proc/pzona_proc.php?accion=editar_registros',
			        data:{codOrg:codOrg, codDep:codDep, codLoc:codLoc,nomZon:nomZon, chek:chek},
			        success: function(data){
			            if(data==1){
		                    actualizar();
			            }else{ alert(data+' Editar!') }
			        }
			    });
			}else{ // Nuevo
				if( nomZon!='' ){
					$.ajax({
				        type:'POST',
				        url:'proc/pzona_proc.php?accion=guardar_registros',
				        data:{codDep:codDep, codLoc:codLoc, nomZon:nomZon},
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
	
	//Btn Consulta
	$('#btnConsulta').click(function(){
		$('#divListaDepartamentos').html('');
		$.ajax({
	        type:'POST',
	        url:'proc/pzona_proc.php?accion=cargar_departamentos',
	        data:{dep:'1'},
	        success: function(data){
	        	swCons = true;
	            $('#divListaDepartamentos').html(data);
	            
	            $('#btnCancelar').removeClass('disabled');

				$('#btnPrimer').removeClass('disabled');
				$('#btnAnterior').removeClass('disabled');
				$('#btnSiguiente').removeClass('disabled');
				$('#btnUltimo').removeClass('disabled');

				$('#btnPrimer').click();
	        }
	    });
	});

	//Btn Cancelar
	$('#btnCancelar').click(function(){
		$('#txtCodDepar').removeAttr('readonly');
		$('#divListaCiudades').html('');
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
	})

	//Btn Localidades
	$('#btnPrimer').click(function(){
		if(swCons){
			$('#txtActualDep').val(1);
			cod = $('#txtCodDep1').val();
			if($('#txtToltalDep').val()!=0 ){
				buscarNombreDepartamento(cod);
			}
		}else{
			$('#txtActualLoc').val(1);
			codLoc = $('#txtCodLoc1').val();
			if($('#txtToltalLoc').val()!=0 ){
				buscarNombreLocalidades(codLoc);
			}
		}
	});
	$('#btnAnterior').click(function(){
		if(swCons){
			codId = parseInt($('#txtActualDep').val());
			$('#txtActualDep').val(codId-1);
			codId = parseInt($('#txtActualDep').val());

			if(codId>=1){
				cod = $('#txtCodDep'+codId).val();
				buscarNombreDepartamento(cod);
			}else{
				$('#txtActualDep').val(1);
			}
		}else{
			codId = parseInt($('#txtActualLoc').val());
			$('#txtActualLoc').val(codId-1);
			codId = parseInt($('#txtActualLoc').val());

			if(codId>=1){
				codLoc = $('#txtCodLoc'+codId).val();
				buscarNombreLocalidades(codLoc);
			}else{
				$('#txtActualLoc').val(1);
			}
		}
	});
	$('#btnSiguiente').click(function(){
		if(swCons){
			codId = parseInt($('#txtActualDep').val());
			$('#txtActualDep').val(codId+1);
			codId = parseInt($('#txtActualDep').val());

			codUlt = parseInt($('#txtToltalDep').val());
			if(codId<=codUlt){
				cod = $('#txtCodDep'+codId).val();
				buscarNombreDepartamento(cod);
			}else{
				$('#txtActualDep').val(codUlt);
			}
		}else{
			codId = parseInt($('#txtActualLoc').val());
			$('#txtActualLoc').val(codId+1);
			codId = parseInt($('#txtActualLoc').val());

			codUlt = parseInt($('#txtToltalLoc').val());
			if(codId<=codUlt){
				codLoc = $('#txtCodLoc'+codId).val();
				buscarNombreLocalidades(codLoc);
			}else{
				$('#txtActualLoc').val(codUlt);
			}
		}
	});
	$('#btnUltimo').click(function(){
		if(swCons){
			codUlt = parseInt($('#txtToltalDep').val());
			$('#txtActualDep').val(codUlt);
			cod = $('#txtCodDep'+codUlt).val();
			buscarNombreDepartamento(cod);
		}else{
			codUlt = parseInt($('#txtToltalLoc').val());
			$('#txtActualLoc').val(codUlt);
			codLoc = $('#txtCodLoc'+codUlt).val();
			buscarNombreLocalidades(codLoc);
		}
	});
	$('#btnListaValores').click(function(){
		
		if(modal==0){
			$('#txtCodDepar').val('');
			$('#txtNomDepar').val('');
			$('#txtCodLoca').val('');
			$('#txtNomLoca').val('');
			$('#modalDepartamentos').modal('show');
			$('#txtCodDepar').removeAttr('readonly');
		}else{
			$('#txtCodLoca').val('');
			$('#txtNomLoca').val('');
			dep = $('#txtCodDepar').val();
			if(dep!=''){
				actModalLocalidades();
			}else{
				var msgError = 'Porfavor coloque un departamento valido';
				demo.showNotification('bottom','left', msgError, 4);
			}
		}

		//limpiarDepartamento();
		//limpiarTabla();
	});

	//Btn Editor
	$('#btnEditor').click(function(){
		var dat = $('#'+varEditor).val();
		$('#txtCampEditor').val(dat);
		$('#editModal').modal('show');
	});

});
var swCons = false;
var modal = 0;
function buscarZonasOperativas(){
	loc = $.trim($('#txtCodLoca').val());
	dep = $.trim($('#txtCodDepar').val());
	if( (loc!='') && (dep!='') ){
		buscarNombreDepartamento(dep);
		buscarNombreLocalidades(loc);
	}else{
		var msgError = 'Porfavor complete los datos';
		demo.showNotification('bottom','left', msgError, 4);
	}
}
function buscarNombreDepartamento(id){
	if(id!=0){
		buscarLocalidades(id);
	}else if(id==0){
		dep = $.trim($('#txtCodDepar').val());
		if(dep!=''){
			buscarLocalidades(dep);
		}else{
			var msgError = 'Porfavor coloque un departamento valido';
			demo.showNotification('bottom','left', msgError, 4);
		}
	}
}
function buscarCiudadesDepartamento(){
	dep = $.trim($('#txtCodDepar').val());
	if(dep!=''){
		buscarNombreDepartamento(dep);
		actualizarCiudades(dep);
		swCons = false;
	}
}
function buscarLocalidades(cod){
	$.ajax({
        type:'POST',
        url:'proc/pzona_proc.php?accion=seleccionar_departamento',
        data:{cod:cod},
        success: function(data){
            $('#txtCodDepar').val(cod);
            $('#txtNomDepar').val(data);
            $('#txtCodDepar').attr('readonly','readonly');
            //actualizarCiudades(cod);
        }
    });
}
function actualizarCiudades(dep){
	$('#divListaCiudades').html('');
	$.ajax({
        type:'POST',
        url:'proc/pzona_proc.php?accion=cargar_ciudades',
        data:{dep:dep},
        success: function(data){
            $('#divListaCiudades').html(data);
            
            $('#btnCancelar').removeClass('disabled');

			$('#btnPrimer').removeClass('disabled');
			$('#btnAnterior').removeClass('disabled');
			$('#btnSiguiente').removeClass('disabled');
			$('#btnUltimo').removeClass('disabled');

			$('#btnPrimer').click();
        }
    });
}
function colocarCiudad(loc){
	buscarNombreLocalidades(loc);
	$('#modalLocalidades').modal('hide');
}
function buscarNombreLocalidades(cod){
	var dep = $('#txtCodDepar').val();
	if(cod!=''){
		$.ajax({
	        type:'POST',
	        url:'proc/pzona_proc.php?accion=seleccionar_localidad',
	        data:{cod:cod, dep:dep},
	        success: function(data){
	        	//console.log(data)
	            $('#txtCodLoca').val(cod);
	            $('#txtNomLoca').val(data);
	            $('#txtCodLoca').attr('readonly','readonly');
	            
	            $('#btnGuardar').removeClass('disabled');
	            $('#btnNuevo').removeClass('disabled');
	            $('#btnEliminar').addClass('disabled');
	            $('#btnConsulta').addClass('disabled');
	            $('#btnCancelar').removeClass('disabled');
	            $('#btnListaValores').addClass('disabled');

	            actualizar();

	        }
	    });
	}
}
function actModalLocalidades(){
	buscarNombreDepartamento(dep);
	dep = $('#txtCodDepar').val();
	if(dep!=''){
		$('#divLocalidadesDepartamento').html('');
		$.ajax({
	        type:'POST',
	        url:'proc/pzona_proc.php?accion=act_localidades',
	        data:{dep:dep},
	        success: function(data){
	            $('#divLocalidadesDepartamento').html(data);
	            $('#modalLocalidades').modal('show');
	        }
	    });
	}else{
		var msgError = 'Porfavor coloque un departamento valido';
		demo.showNotification('bottom','left', msgError, 4);
	}
}

function actualizar(){
	$('#table').html('');
	codDep = $.trim($('#txtCodDepar').val());
	codLoc = $.trim($('#txtCodLoca').val());
	$.ajax({
        type:'POST',
        url:'proc/pzona_proc.php?accion=actualizar_zona',
        data:{codDep:codDep, codLoc:codLoc},
        success: function(data){
            $('#table').html(data);
        }
    });
}
function limpiarDepartamento(){
	$('#txtCodDepar').val('');
	$('#txtNomDepar').val('');

	$('#txtCodLoca').val('');
    $('#txtNomLoca').val('');
}
function limpiarTabla(){
	a = '<thead><tr style="background-color: #3c8dbc; color:white;">';

	b = '<th class="text-center" width="100">CODIGO</th>';
	c = '<th class="text-left">SECTOR</th>';
	d = '<th class="text-center" width="100">VISIBLE</th>';

	e = '</tr></thead><tbody></tbody>';
	$('#table').html(a+b+c+d+e);
}
function solonumeros(){
    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
        event.returnValue = false;
}

//Ver origen del editor
var varEditor = '';
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