$(document).ready(function () {
	
	$('#tablePqr').DataTable({
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

	$('#tableManoObra').DataTable({
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
		cod = $.trim($('#txtCodPqr').val());
		nom = $.trim($('#txtNomPqr').val());
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
		    //Cant
		    var cell3 = row.insertCell(2);
		    cell3.className = '';
		    cell3.innerHTML = '<input type="text" id="txtCantMax'+rowCount+'" class="form-control input-sm text-center" onclick="swEditor(\'txtCantMax'+rowCount+'\',\'trSelect'+rowCount+'\',0,0)">';
		    //valPagar
		    var cell3 = row.insertCell(3);
		    cell3.className = '';
		    cell3.innerHTML = '<input type="text" id="txtValorPag'+rowCount+'" class="form-control input-sm text-center" onclick="swEditor(\'txtValorPag'+rowCount+'\',\'trSelect'+rowCount+'\',0,0)">';
		    //valorPosterior
		    var cell3 = row.insertCell(4);
		    cell3.className = '';
		    cell3.innerHTML = '<input type="text" id="txtValorVec'+rowCount+'" class="form-control input-sm text-center" onclick="swEditor(\'txtValorVec'+rowCount+'\',\'trSelect'+rowCount+'\',0,0)">';
		    //ValorGasera
		    var cell3 = row.insertCell(5);
		    cell3.className = '';
		    cell3.innerHTML = '<input type="text" id="txtValorGas'+rowCount+'" class="form-control input-sm text-center" onclick="swEditor(\'txtValorGas'+rowCount+'\',\'trSelect'+rowCount+'\',0,0)">';
		    

		    $('#contRow').val(rowCount);
	   	 	$('#txtCod'+rowCount).focus();
	    	selectedNewRow(row.id);
			modal = 2;
			idGlob = rowCount;
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
		var codPqr = $('#txtCodPqr').val();
		for(var i=1;i<=cont;i++){
			var cod = $.trim($('#txtCod'+i).val());
			var nom = $.trim($('#txtNomb'+i).val());
			var cant = $('#txtCantMax'+i).val();
			var vPagar = $('#txtValorPag'+i).val();
			var vVenci = $('#txtValorVec'+i).val();
			var vGaser = $('#txtValorGas'+i).val();
			

			if( $('#txtTipo'+i).val() == 1){ //Editar
				var codOrg = $.trim($('#txtCodOrg'+i).val());
				$.ajax({
			        type:'POST',
			        url:'proc/pmopqr_proc.php?accion=editar_registros',
			        data:{ codOrg:codOrg, codPqr:codPqr, cod:cod, cant:cant, vPagar:vPagar, vVenci:vVenci, vGaser:vGaser},
			        success: function(data){
			            console.log(data)
			            if(data==1){
		                    actualizar();
			            }else{ alert(data+' Editar!') }
			        }
			    });
			}else{
				if( (cod!='') && (nom!='') ){
					$.ajax({
				        type:'POST',
				        url:'proc/pmopqr_proc.php?accion=guardar_registros',
				        data:{ codPqr:codPqr, cod:cod, cant:cant, vPagar:vPagar, vVenci:vVenci, vGaser:vGaser },
				        success: function(data){
							//console.log(data)
							//alert(data)
				            if(data==1){
			                    actualizar();
				            }else{ alert(data+' Agregar!') }
				        }
				    });
				}
			}

		}
	});

	$("#txtCodPqr").click(function(){
		$('#btnCancelar').click();
		$('#txtCodPqr').removeAttr('readonly');
		$('#txtNomPqr').val('');
		limpiarTabla();
		modal=1;
	});

	$("#txtCodPqr").keypress(function(event){
		if(event.which == 13){
			buscarNombrePqr();
		}
	});

	$('#btnEditor').click(function(){
		var dat = $('#'+varEditor).val();
		$('#txtCampEditor').val(dat);
		$('#editModal').modal('show');
	});

	$('#btnListaValores').click(function(){
		
		if(modal==1){
			$('#txtCodPqr').removeAttr('readonly');
			$('#modalPrq').modal('show');
			$('#txtNomPqr').val('');
			limpiarTabla();
		}else{
			$('#modalManoObra').modal('show');
		}
	});

	$('#btnConsulta').click(function(){
		$('#btnCancelar').removeClass('disabled');

		$('#btnPrimer').removeClass('disabled');
		$('#btnAnterior').removeClass('disabled');
		$('#btnSiguiente').removeClass('disabled');
		$('#btnUltimo').removeClass('disabled');

		cargarPqr();
	});

	$('#btnCancelar').click(function(){
		$('#divListaPqr').html('');
		$('#txtCodPqr').val('');
		$('#txtCodPqr').removeAttr('readonly');
		$('#txtNomPqr').val('');
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
		$('#txtActualPqr').val(1);
		cod = $('#txtCodPqr1').val();
		buscarNombrePqr_Ant_Sgt(cod);
	});
	$('#btnAnterior').click(function(){
		codId = parseInt($('#txtActualPqr').val());
		$('#txtActualPqr').val(codId-1);
		codId = parseInt($('#txtActualPqr').val());

		if(codId>=1){
			cod = $('#txtCodPqr'+codId).val();
			buscarNombrePqr_Ant_Sgt(cod);
		}else{
			$('#txtActualPqr').val(1);
		}
	});
	$('#btnSiguiente').click(function(){
		codId = parseInt($('#txtActualPqr').val());
		$('#txtActualPqr').val(codId+1);
		codId = parseInt($('#txtActualPqr').val());

		codUlt = parseInt($('#txtToltalPqr').val());
		if(codId<=codUlt){
			cod = $('#txtCodPqr'+codId).val();
			buscarNombrePqr_Ant_Sgt(cod);
		}else{
			$('#txtActualPqr').val(codUlt);
		}
	});
	$('#btnUltimo').click(function(){
		codUlt = parseInt($('#txtToltalPqr').val());
		$('#txtActualPqr').val(codUlt);
		cod = $('#txtCodPqr'+codUlt).val();
		buscarNombrePqr_Ant_Sgt(cod);
	});
});
var modal = 1;
var idGlob = 0;
function cargarPqr(){
	$('#divListaPqr').html('');
	$.ajax({
        type:'POST',
        url:'proc/pmopqr_proc.php?accion=cargar_pqrs',
        data:{codDep:'1'},
        success: function(data){
            $('#divListaPqr').html(data);
            $('#btnPrimer').click();
        }
    });
}
function colocarPqr(id,nom){
	$('#txtCodPqr').val(id);
	$('#txtNomPqr').val(nom);
	actualizar();
	$('#modalPrq').modal('hide');
}
function buscarNombrePqr(){
	cod = $.trim($('#txtCodPqr').val());
	if(cod!=''){
		$.ajax({
	        type:'POST',
	        url:'proc/pmopqr_proc.php?accion=seleccionar_pqr',
	        data:{cod:cod},
	        success: function(data){
	            $('#txtNomPqr').val(data);
	            $('#txtCodPqr').attr('readonly','readonly');
	            actualizar();
	        }
	    });
	}else{
		/*
					BACKGROUND-COLOR ALERTAS
						AZUL = 1
						VERDE = 2
						NARANJA = 3
						ROJO = 4
					*/
		var msgError = 'Error! Porfavor coloque un PQR valido';
		demo.showNotification('bottom','left', msgError, 4);
	}
}
function buscarNombrePqr_Ant_Sgt(cod){
	$.ajax({
        type:'POST',
        url:'proc/pmopqr_proc.php?accion=seleccionar_pqr',
        data:{cod:cod},
        success: function(data){
			$('#txtCodPqr').val(cod)
            $('#txtNomPqr').val(data);
            $('#txtCodPqr').attr('readonly','readonly');
            actualizar();
        }
    });
}
function colocarManoObra(cod){
	sw = false;
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
	        url:'proc/pmopqr_proc.php?accion=seleccionar_manoObra',
	        data:{cod:cod},
	        success: function(data){
				$('#txtCod'+idGlob).val(cod);
				$('#txtNomb'+idGlob).val(data);
				$('#modalManoObra').modal('hide');
	        }
	    });
	}else{
		/*
					BACKGROUND-COLOR ALERTAS
						AZUL = 1
						VERDE = 2
						NARANJA = 3
						ROJO = 4
					*/
		var msgError = 'Error! La Mano de obra ya existe';
		demo.showNotification('bottom','left', msgError, 4);
	}
}
function actualizar(){
	$('#table').html('');
	cod = $.trim($('#txtCodPqr').val());
	$.ajax({
        type:'POST',
        url:'proc/pmopqr_proc.php?accion=actualizar_registros',
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
		validarManoObra(id);
	}else{
	    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
	        event.returnValue = false;
	}
}
function validarManoObra(id){
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
	        url:'proc/pmopqr_proc.php?accion=seleccionar_manoObra',
	        data:{cod:cod},
	        success: function(data){
				$('#txtCod'+id).val(cod);
				$('#txtNomb'+idGlob).val(data);
				if(data!=''){
					$('#txtCantMax'+idGlob).focus();
				}
	        }
	    });
	}else{
		demo.showNotification('bottom','left', 'La Mano de obra ya existe', 4);
	}
}
function limpiarTabla(){
	a = '<thead><tr style="background-color: #3c8dbc; color:white;">';
	b = '<th class="text-center" width="100">CODIGO</th>';
	c = '<th class="text-center">DESCRIPCION</th>';
	d = '<th class="text-center" width="150">CANTIDAD MAXIMA A LEGALIZAR</th>';
	e = '<th class="text-center" width="130">VALOR A PAGAR</th>';
	f = '<th class="text-center" width="190">VALOR A PAGAR POSTERIOR AL VENCIMINTO</th>';
	g = '<th class="text-center" width="160">VALOR A PAGAR POR GASERA</th>';
	h = '</tr></thead><tbody></tbody>';
	$('#table').html(a+b+c+d+e+f+g+h);
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
