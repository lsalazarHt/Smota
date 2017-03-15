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

				swCons = 0;
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
		$('#txtCodZona').removeAttr('readonly');
		$('#btnNuevoModal').removeClass('display-none');
		$('#txtNomDepar').val('');
		$('#divListaCiudades').html('');
		$('#divListaZonas').html('');

		//Localidades
		$('#txtCodLoca').val('');
		$('#txtNomLoca').val('');

		$('#txtCodZona').val('');
		$('#txtNomZona').val('');
		modal = 0;
		swCons = 1;

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
				swCons = 0;
			}
		}
	});

	//Seleccionar localidades
	$('#txtCodLoca').click(function(){
		//actualizarZonas();
		$('#divListaZonas').html('');
		$('#btnListaValores').removeClass('disabled');
		$('#btnGuardar').addClass('disabled');
		$('#btnNuevo').addClass('disabled');
		limpiarTabla();
		$('#txtCodLoca').removeAttr('readonly');
		$('#txtCodLoca').val('');
		$('#txtNomLoca').val('');
		$('#txtCodZona').removeAttr('readonly');
		$('#txtCodZona').val('');
		$('#txtNomZona').val('');
		$('#txtActualLoc').val(0);
		modal = 1;
		swCons = 0;
	});
	$("#txtCodLoca").keypress(function(event){
		if(event.which == 13){
			loc = $.trim($('#txtCodLoca').val());
			dep = $.trim($('#txtCodDepar').val());
			if( (loc!='') && (dep!='') ){
				buscarNombreDepartamento(dep);
				buscarNombreLocalidades(loc);
				actualizarZonas();
			}else{
				alert('Porfavor complete los datos')
			}
		}
	});

	//Seleccionar zona
	$('#txtCodZona').click(function(){

		$('#btnListaValores').removeClass('disabled');
		$('#btnGuardar').addClass('disabled');
		$('#btnNuevo').addClass('disabled');
		limpiarTabla();
		$('#txtCodZona').removeAttr('readonly');
		$('#txtCodZona').val('');
		$('#txtNomZona').val('');
		modal = 2;
	});
	$("#txtCodZona").keypress(function(event){
		if(event.which == 13){
			loc = $.trim($('#txtCodLoca').val());
			dep = $.trim($('#txtCodDepar').val());
			zona = $.trim($('#txtCodZona').val());
			if( (loc!='') && (dep!='') ){
				buscarNombreDepartamento(dep);
				buscarNombreLocalidades(loc);
				buscarNombreZona(zona);
			}else{
				alert('Porfavor complete los datos')
			}
		}
	});

	$('#txtCodZona').click(function(){
		//actualizarZonas();
		//$('#txtActualZon').val(0);
		swCons = 2;
		modal = 2;
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
		    cell1.innerHTML = '<input type="text" id="txtCod'+rowCount+'" class="form-control input-sm txtCodSect text-center" onkeypress="solonumerosEnter('+rowCount+')" onclick="swEditor(\'txtCod'+rowCount+'\',\'trSelect'+rowCount+'\',1,'+rowCount+')"><input type="hidden" id="txtTipo'+rowCount+'" value="0">';
		    //Nombre
		    var cell2 = row.insertCell(1);
		    cell2.className = '';
		    cell2.innerHTML = '<input type="text" id="txtNomb'+rowCount+'" class="form-control input-sm" onclick="swEditor(\'txtNomb'+rowCount+'\',\'trSelect'+rowCount+'\',1,'+rowCount+')" readonly>';
		    //Accion
		    var cell3 = row.insertCell(2);
		    cell3.className = 'text-center ';
		    cell3.innerHTML = '<input type="checkbox" id="txtCkek'+rowCount+'" onclick="swEditor(\'\',\'trSelect'+rowCount+'\',1,'+rowCount+')" checked="checked">';

		    $('#contRow').val(rowCount);
		}else{
			alert('Porfavor coloque los datos valido')
		}
	});
	
	//Btn Guardar
	$('#btnGuardar').click(function(){
		var cont = $('#contRow').val();
		var codDep = $('#txtCodDepar').val();
		var codLoc = $('#txtCodLoca').val();
		var codZon = $('#txtCodZona').val();

		for(var i=1;i<=cont;i++){
			var codOrg = $.trim($('#txtCodOrg'+i).val());
			var cod = $.trim($('#txtCod'+i).val());
			var nom = $.trim($('#txtNomb'+i).val());
			if($("#txtCkek"+i).is(':checked')) { chek = 1; }
			else{ chek = 0; }

			//
			if( $('#txtTipo'+i).val() == 1){ //Editar
				$.ajax({
			        type:'POST',
			        url:'proc/psezo_proc.php?accion=editar_registros',
			        data:{codOrg:codOrg, codDep:codDep, codLoc:codLoc,codZon:codZon, cod:cod, chek:chek},
			        success: function(data){
			            if(data==1){
		                    actualizar();
			            }else{ alert(data+' Editar!') }
			        }
			    });
			}else{ // Nuevo
				if( (cod!='') && (nom!='') ){
					$.ajax({
				        type:'POST',
				        url:'proc/psezo_proc.php?accion=guardar_registros',
				        data:{codDep:codDep, codLoc:codLoc, codZon:codZon, cod:cod},
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
	        url:'proc/psezo_proc.php?accion=cargar_departamentos',
	        data:{dep:'1'},
	        success: function(data){
	        	swCons = 1;
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
		$('#txtCodLoca').removeAttr('readonly');
		$('#txtCodZona').removeAttr('readonly');
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
		if(swCons==1){
			$('#txtActualDep').val(1);
			cod = $('#txtCodDep1').val();
			if($('#txtToltalDep').val()!=0 ){
				buscarNombreDepartamento(cod);
			}
		}else if(swCons==0){
			$('#txtActualLoc').val(1);
			codLoc = $('#txtCodLoc1').val();
			if($('#txtToltalLoc').val()!=0 ){
				buscarNombreLocalidades(codLoc);
			}
		}else{
			$('#txtActualZon').val(1);
			codZon = $('#txtCodZon1').val();
			if($('#txtToltalZon').val()!=0 ){
				buscarNombreZona(codZon);
			}
		}
	});
	$('#btnAnterior').click(function(){
		if(swCons==1){
			codId = parseInt($('#txtActualDep').val());
			$('#txtActualDep').val(codId-1);
			codId = parseInt($('#txtActualDep').val());

			if(codId>=1){
				cod = $('#txtCodDep'+codId).val();
				buscarNombreDepartamento(cod);
			}else{
				$('#txtActualDep').val(1);
			}
		}else if(swCons==0){
			codId = parseInt($('#txtActualLoc').val());
			$('#txtActualLoc').val(codId-1);
			codId = parseInt($('#txtActualLoc').val());

			if(codId>=1){
				codLoc = $('#txtCodLoc'+codId).val();
				buscarNombreLocalidades(codLoc);
			}else{
				$('#txtActualLoc').val(1);
			}
		}else{
			codId = parseInt($('#txtActualZon').val());
			$('#txtActualZon').val(codId-1);
			codId = parseInt($('#txtActualZon').val());

			if(codId>=1){
				codZon = $('#txtCodZon'+codId).val();
				buscarNombreZona(codZon);
			}else{
				$('#txtActualZon').val(1);
			}
		}
	});
	$('#btnSiguiente').click(function(){
		if(swCons==1){
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
		}else if(swCons==0){
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
		}else{
			codId = parseInt($('#txtActualZon').val());
			$('#txtActualZon').val(codId+1);
			codId = parseInt($('#txtActualZon').val());

			codUlt = parseInt($('#txtToltalZon').val());
			if(codId<=codUlt){
				codZon = $('#txtCodZon'+codId).val();
				buscarNombreZona(codZon);
			}else{
				$('#txtActualZon').val(codUlt);
			}
		}
	});
	$('#btnUltimo').click(function(){
		if(swCons==1){
			codUlt = parseInt($('#txtToltalDep').val());
			$('#txtActualDep').val(codUlt);
			cod = $('#txtCodDep'+codUlt).val();
			buscarNombreDepartamento(cod);
		}else if(swCons==0){
			codUlt = parseInt($('#txtToltalLoc').val());
			$('#txtActualLoc').val(codUlt);
			codLoc = $('#txtCodLoc'+codUlt).val();
			buscarNombreLocalidades(codLoc);
		}else{
			codUlt = parseInt($('#txtToltalZon').val());
			$('#txtActualZon').val(codUlt);
			codZon = $('#txtCodZon'+codUlt).val();
			buscarNombreZona(codZon);
		}
	});
	$('#btnListaValores').click(function(){
		
		if(modal==0){
			limpiarTabla();
			$('#txtCodDepar').val('');
			$('#txtNomDepar').val('');
			$('#txtCodLoca').val('');
			$('#txtNomLoca').val('');
			$('#txtCodZona').val('');
			$('#txtNomZona').val('');
			$('#modalDepartamentos').modal('show');
			$('#txtCodDepar').removeAttr('readonly');
		}else if(modal==1){
			limpiarTabla();
			$('#txtCodLoca').val('');
			$('#txtNomLoca').val('');
			$('#txtCodZona').val('');
			$('#txtNomZona').val('');
			dep = $('#txtCodDepar').val();
			if(dep!=''){
				actModalLocalidades();
			}else{
				alert('Porfavor coloque un departamento valido')
			}
		}else if(modal==2){
			limpiarTabla();
			$('#txtCodZona').val('');
			$('#txtNomZona').val('');
			dep = $('#txtCodDepar').val();
			loc = $('#txtCodLoca').val();
			if( (dep!='') && (loc!='') ){
				actModalZonas();
			}else{
				alert('Porfavor coloque los datos valido')
			}
		}else{
			dep = $('#txtCodDepar').val();
			loc = $('#txtCodLoca').val();
			zon = $('#txtCodZona').val();
			if( (dep!='') && (loc!='') && (zon!='') ){
				$('#modalSectores').modal('show');
			}else{
				alert('Porfavor coloque los datos valido')
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
var swCons = 0;
var modal = 0;
var idGlb = 0;
function buscarZonasOperativas(){
	loc = $.trim($('#txtCodLoca').val());
	dep = $.trim($('#txtCodDepar').val());
	if( (loc!='') && (dep!='') ){
		buscarNombreDepartamento(dep);
		buscarNombreLocalidades(loc);
		actualizarZonas();
		limpiarTabla();
	}else{
		alert('Porfavor complete los datos')
	}
}
function buscarSectoresZonasOperativas(){
	loc = $.trim($('#txtCodLoca').val());
	dep = $.trim($('#txtCodDepar').val());
	zona = $.trim($('#txtCodZona').val());
	if( (loc!='') && (dep!='') ){
		buscarNombreDepartamento(dep);
		buscarNombreLocalidades(loc);
		buscarNombreZona(zona);
	}else{
		alert('Porfavor complete los datos')
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
			alert('Porfavor coloque un departamento valido')
		}
	}
}
function buscarCiudadesDepartamento(){
	dep = $.trim($('#txtCodDepar').val());
	if(dep!=''){
		buscarNombreDepartamento(dep);
		actualizarCiudades(dep);

		limpiarTabla();
		swCons = 0;
		$('#txtCodZona').val('');
   	 	$('#txtNomZona').val('');
   	 	$('#txtCodZona').removeAttr('readonly');
	}
}
function buscarLocalidades(cod){
	$.ajax({
        type:'POST',
        url:'proc/psezo_proc.php?accion=seleccionar_departamento',
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
        url:'proc/psezo_proc.php?accion=cargar_ciudades',
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
function colocarZona(zon){
	buscarNombreZona(zon);
	$('#modalZonas').modal('hide');
}
function buscarNombreLocalidades(cod){
	var dep = $('#txtCodDepar').val();
	if(cod!=''){
		$.ajax({
	        type:'POST',
	        url:'proc/psezo_proc.php?accion=seleccionar_localidad',
	        data:{cod:cod, dep:dep},
	        success: function(data){
	        	//console.log(data)
	            $('#txtCodLoca').val(cod);
	            $('#txtNomLoca').val(data);
	            $('#txtCodLoca').attr('readonly','readonly');
	            
	            //$('#btnGuardar').removeClass('disabled');
	            //$('#btnNuevo').removeClass('disabled');
	            //$('#btnEliminar').addClass('disabled');
	            //$('#btnConsulta').addClass('disabled');
	            $('#btnCancelar').removeClass('disabled');
	            //$('#btnListaValores').addClass('disabled');

	            //actualizarZonas();
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
	        url:'proc/psezo_proc.php?accion=act_localidades',
	        data:{dep:dep},
	        success: function(data){
	            $('#divLocalidadesDepartamento').html(data);
	            $('#modalLocalidades').modal('show');
	        }
	    });
	}else{
		alert('Porfavor coloque un departamento valido')
	}
}
function actModalZonas(){
	dep = $('#txtCodDepar').val();
	loc = $('#txtCodLoca').val();
	buscarNombreDepartamento(dep);
	buscarNombreLocalidades(loc);
	if( (dep!='') && (loc!='') ){
		$('#divZonasLocalidadesDepartamento').html('');
		$.ajax({
	        type:'POST',
	        url:'proc/psezo_proc.php?accion=act_zonas',
	        data:{ dep:dep , loc:loc },
	        success: function(data){
	            $('#divZonasLocalidadesDepartamento').html(data);
	            $('#modalZonas').modal('show');
	        }
	    });
	}else{
		alert('Porfavor coloque un departamento valido')
	}
}
function buscarNombreZona(cod){
	var dep = $('#txtCodDepar').val();
	var loc = $('#txtCodLoca').val();
	if( (cod!='') && (loc!='') ){
		$.ajax({
	        type:'POST',
	        url:'proc/psezo_proc.php?accion=seleccionar_zona',
	        data:{cod:cod, dep:dep, loc:loc},
	        success: function(data){
	        	//console.log(data)
	            $('#txtCodZona').val(cod);
	            $('#txtNomZona').val(data);
	            $('#txtCodZona').attr('readonly','readonly');
	            
	            $('#btnGuardar').removeClass('disabled');
	            $('#btnNuevo').removeClass('disabled');
	            $('#btnEliminar').addClass('disabled');
	            $('#btnConsulta').addClass('disabled');
	            $('#btnCancelar').removeClass('disabled');
	            //$('#btnListaValores').addClass('disabled');
	            actualizar();

	        }
	    });
	}
}
function actualizarZonas(){
	dep = $('#txtCodDepar').val();
	loc = $('#txtCodLoca').val();
	$.ajax({
        type:'POST',
        url:'proc/psezo_proc.php?accion=cargar_zonas',
        data:{dep:dep , loc:loc },
        success: function(data){
        	swCons=2;
            $('#divListaZonas').html(data);
            
            $('#btnCancelar').removeClass('disabled');

			$('#btnPrimer').removeClass('disabled');
			$('#btnAnterior').removeClass('disabled');
			$('#btnSiguiente').removeClass('disabled');
			$('#btnUltimo').removeClass('disabled');

			$('#btnPrimer').click();
        }
    });
}
function seleccionarSector(id,nom){
	$('#modalSectores').modal('hide');
	//cont =  $('#contRow').val();

	$('#txtCod'+idGlb).val(id);
	validarCodigoSector(id,nom,idGlb);

	//$('#txtNomb'+idGlb).val(nom);
	//console.log(cont+' - '+id+' / '+nom)
}
function actualizar(){
	$('#table').html('');
	codDep = $.trim($('#txtCodDepar').val());
	codLoc = $.trim($('#txtCodLoca').val());
	codZon = $.trim($('#txtCodZona').val());
	$.ajax({
        type:'POST',
        url:'proc/psezo_proc.php?accion=actualizar_sectores',
        data:{codDep:codDep, codLoc:codLoc, codZon:codZon},
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

    $('#txtCodZona').val('');
    $('#txtNomZona').val('');
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

function solonumerosEnter(id){
	if(event.which == 13){
		validarSector(id);
	}else{
	    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
	        event.returnValue = false;
	}
}
function validarSector(id){
	$('#txtNomb'+id).val('');
	cod = $('#txtCod'+id).val();
	$.ajax({
        type:'POST',
        url:'proc/psezo_proc.php?accion=validar_sector',
        data:{cod:cod},
        dataType: "json",
        success: function(data){
        	if(data[0]!=0){
        		validarCodigoSector(cod,data[1],id);
        		//$('#txtNomb'+id).val(data[1]);
        	}else{
        		alert('Error! El sector no es valido')
        		$('#txtCod'+id).val('');
        	}
        }
    });
}
function validarCodigoSector(id,nomb,codID){
	sw = false;
	rowCount = $('#contRow').val();
	for(var i=1;i<rowCount;i++){
		codSec = $.trim($('#txtCod'+i).val());

		if( (id==codSec) && (i!=codID) ){
			sw = true;
		}
	}

	if(sw){
		alert('Error! El Sector ya existe')
		$('#txtCod'+codID).val('');
		$('#txtNomb'+codID).val('');
	}else{
		$('#txtNomb'+codID).val(nomb);
	}

}

//Ver origen del editor
var varEditor = '';
function swEditor(id,trId,mdSec,i){

	varEditor = id;
	$('.trDefault').removeClass('trSelect');
	$('#'+trId).addClass('trSelect');

	if(mdSec==1){
		modal = 3;
	}
	idGlb = i;
}
function descargarEditor(){
	var dat = $('#txtCampEditor').val();
	$('#'+varEditor).val(dat);
	$('#editModal').modal('hide');
}