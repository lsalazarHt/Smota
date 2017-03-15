$(document).ready(function(){

	$('#btnConsulta').addClass('disabled');
	$('#btnGuardar').removeClass('disabled');

	/*$('.tableJs').DataTable({
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
	    "columns": [
	        { "class": "text-center cod","width":"15%"},
	        { "class": "text-left","width":"30px"}
	    ]
	});*/

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
		}else if(modal==4){
			$('#modalPqr').modal('show');
		}else if(modal==5){
			dep = $('#txtDepCod').val();
			loc = $('#txtLocCod').val();
			if( (dep!='') && (loc!='') ){
				actualizarZonas(dep,loc);
			}
		}else if(modal==6){
			dep = $('#txtDepCod').val();
			loc = $('#txtLocCod').val();
			zon = $('#txtZonCod').val();
			if( (dep!='') && (loc!='') && (zon!='') ){
				actualizarSectores(dep,loc,zon);
			}
		}
	});

	$('#txtDepCod').click(function(){
		//$('#txtDepCod').val(cod);
		modal=1;
		$('#txtDepNomb').val('');
		$('#txtLocCod').val('');
		$('#txtLocNomb').val('');
		$('#txtZonCod').val('');
		$('#txtZonNomb').val('');
		$('#txtSecCod').val('');
		$('#txtSecNomb').val('');
		//$('#txtCodOrd').val('');
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
		$('#txtLocNomb').val('');
		$('#txtZonCod').val('');
		$('#txtZonNomb').val('');
		$('#txtSecCod').val('');
		$('#txtSecNomb').val('');
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

	$("#txtTecCod").keypress(function(event){
		if(event.which == 13){
			cod = $.trim($('#txtTecCod').val());
			if(cod!=''){
				buscarTecnico(cod);
			}
		}
	});

	$("#txtPqrCod").keypress(function(event){
		if(event.which == 13){
			cod = $.trim($('#txtPqrCod').val());
			if(cod!=''){
				buscarPqr(cod);
			}
		}
	});

	$('#txtPqrCod').click(function(){
		modal=4;
		$('#txtPqrNomb').val('');
	});

	$('#txtZonCod').click(function(){
		modal=5;
		$('#txtZonNomb').val('');
		$('#txtSecCod').val('');
		$('#txtSecNomb').val('');
	});
	$("#txtZonCod").keypress(function(event){
		if(event.which == 13){
			dep = $.trim($('#txtDepCod').val());
			loc = $.trim($('#txtLocCod').val());
			cod = $.trim($('#txtZonCod').val());
			if( (dep!='') && (loc!='') && (cod!='') ){
				buscarDepartamento(dep);
				buscarLocalidad(dep,loc);
				buscarZonas(dep,loc,cod);
			}
		}
	});

	$('#txtSecCod').click(function(){
		modal=6;
		$('#txtSecNomb').val('');
	});
	$("#txtSecCod").keypress(function(event){
		if(event.which == 13){
			dep = $.trim($('#txtDepCod').val());
			loc = $.trim($('#txtLocCod').val());
			zon = $.trim($('#txtZonCod').val());
			cod = $.trim($('#txtSecCod').val());
			if( (dep!='') && (loc!='') && (zon!='') && (cod!='') ){
				buscarDepartamento(dep);
				buscarLocalidad(dep,loc);
				buscarZonas(dep,loc,zon);
				buscarSector(dep,loc,zon,cod);
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

	//Asignar Ordenes
	$('#btnGuardar').click(function(){
		//Verificar campos
		depNomb = $('#txtDepNomb').val();
		locNomb = $('#txtLocNomb').val();
		zonNomb = $('#txtZonNomb').val();
		secNomb = $('#txtSecNomb').val();
		pqrNomb = $('#txtPqrNomb').val();
		tecNomb = $('#txtTecNomb').val();
		
		dep = $('#txtDepCod').val();
		loc = $('#txtLocCod').val();
		zon = $('#txtZonCod').val();
		sec = $('#txtSecCod').val();
		cant = $('#txtCant').val();
		pqr = $('#txtPqrCod').val();
		tec = $('#txtTecCod').val();
		obs = $('#txtObservAsign').val();

		if( (dep!='') && (loc!='') &&  (zon!='') &&  (sec!='') &&  (cant!='') &&  (pqr!='') &&  (tec!='') ){
			if( (depNomb!='') && (locNomb!='') &&  (zonNomb!='') &&  (secNomb!='') &&  (pqrNomb!='') &&  (tecNomb!='') ){
				if(cant>0){
					//Asignar Bloque
					$.ajax({
				        type:'POST',
				        url:'proc/paslote_proc.php?accion=asignar_ordenes',
				        data:{dep:dep,loc:loc,zon:zon,sec:sec,cant:cant,pqr:pqr,tec:tec,obs:obs},
				        success: function(data){
				        	if(data==1){
				        		alert('El Lote se asigno correctamente')
				        		limpiar();
				        	}else{ alert(data) }
				        }
				    });
				}else{
					alert('Porfavor coloque una cantidad valida')
				}
			}else{ alert('Porfavor complete los datos') }
		}else{ alert('Porfavor complete los datos') }
	});

});

var modal = 1;
function buscarDepartamento(dep){
	$.ajax({
        type:'POST',
        url:'proc/paslote_proc.php?accion=buscar_departamento',
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
        url:'proc/paslote_proc.php?accion=actualizar_localidades',
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
        url:'proc/paslote_proc.php?accion=buscar_localidades',
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
function addTecnico(cod,nom){
	$('#txtTecCod').val(cod);
	$('#txtTecNomb').val(nom);
	$('#modalTecnicos').modal('hide');
}
function buscarTecnico(cod){
	$.ajax({
        type:'POST',
        url:'proc/paslote_proc.php?accion=buscar_tecnico',
        data:{cod:cod},
        success: function(data){
        	$('#txtTecNomb').val(data);
        }
    });
}
function addPqr(cod,nom){
	$('#txtPqrCod').val(cod);
	$('#txtPqrNomb').val(nom);
	$('#modalPqr').modal('hide');
}
function buscarPqr(cod,nom){
	$.ajax({
        type:'POST',
        url:'proc/paslote_proc.php?accion=buscar_pqr',
        data:{cod:cod},
        success: function(data){
        	$('#txtPqrNomb').val(data);
        }
    });
}
function actualizarZonas(dep,loc){
	$.ajax({
        type:'POST',
        url:'proc/paslote_proc.php?accion=actualizar_zonas',
        data:{dep:dep,loc:loc},
        success: function(data){
        	$('#divZonas').html(data);
        	$('#modalZonas').modal('show');
        }
    });
}
function addZonas(cod,nom){
	$('#txtZonCod').val(cod);
	$('#txtZonNomb').val(nom);
	$('#modalZonas').modal('hide');
}
function buscarZonas(dep,loc,cod){
	$.ajax({
        type:'POST',
        url:'proc/paslote_proc.php?accion=buscar_zonas',
        data:{dep:dep,loc:loc,cod:cod},
        success: function(data){
        	$('#txtZonNomb').val(data);
        }
    });
}
function actualizarSectores(dep,loc,zon){
	$.ajax({
        type:'POST',
        url:'proc/paslote_proc.php?accion=actualizar_sectores',
        data:{dep:dep,loc:loc,zon:zon},
        success: function(data){
        	$('#divSectores').html(data);
        	$('#modalSectores').modal('show');
        }
    });
}
function addSector(cod,nom){
	$('#txtSecCod').val(cod);
	$('#txtSecNomb').val(nom);
	$('#modalSectores').modal('hide');
}
function buscarSector(dep,loc,zon,cod){
	$.ajax({
        type:'POST',
        url:'proc/paslote_proc.php?accion=buscar_sector',
        data:{dep:dep,loc:loc,zon:zon,cod:cod},
        success: function(data){
        	$('#txtSecNomb').val(data);
        }
    });
}
function limpiar(){
	$('#txtDepCod').val('');
	$('#txtDepNomb').val('');
	$('#txtLocCod').val('');
	$('#txtLocNomb').val('');
	$('#txtZonCod').val('');
	$('#txtZonNomb').val('');
	$('#txtSecCod').val('');
	$('#txtSecNomb').val('');
	$('#txtCant').val('');
	$('#txtPqrCod').val('');
	$('#txtPqrNomb').val('');
	$('#txtTecCod').val('');
	$('#txtTecNomb').val('');
	$('#txtObservAsign').val('');
}




//
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