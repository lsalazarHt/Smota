$(document).ready(function(){

	//$('#btnGuardar').removeClass('disabled');
	$('#btnConsulta').addClass('disabled');
	//$('#btnListaValores').addClass('disabled');
	$('#btnEditor').addClass('disabled');

	$('#btnListaValores').click(function(){
		if(modal==1){
			$('#modalDepartamentos').modal('show');
		}else if(modal==2){
			dep = $('#txtDepCod').val();
			if(dep!=''){
				actualizarLocalidad(dep);
			}
		}else if(modal==3){
			dep = $('#txtDepCod').val();
			loc = $('#txtLocCod').val();
			if(loc!=''){
				actualizarSectores(dep,loc);
			}
		}else if(modal==4){
			$('#modalPqr').modal('show');
		}else{
			pqr = $('#txtPqrCod').val();
			if(pqr!=''){
				actualizarTecnico(pqr);
			}else{
				alert('Porfavor coloque un pqr valido')
			}
		}
	});

	$('#txtDepCod').click(function(){

		modal=1;
		$('#txtDepNomb').val('');

		$('#txtLocCod').val('');
		$('#txtLocNomb').val('');

		$('#txtSectCod').val('');
		$('#txtSectNomb').val('');
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

		$('#txtSectCod').val('');
		$('#txtSectNomb').val('');
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

	$('#txtSectCod').click(function(){

		modal=3;
		$('#txtSectNomb').val('');
	});
	$("#txtSectCod").keypress(function(event){
		if(event.which == 13){
			dep = $.trim($('#txtDepCod').val());
			loc = $.trim($('#txtLocCod').val());
			sec = $.trim($('#txtSectCod').val());
			if( (dep!='') && (loc!='') && (sec!='') ){
				buscarDepartamento(dep);
				buscarLocalidad(dep,loc);
				buscarSector(dep,loc,sec);
			}else{ alert('Porfavor coloque una localidad valido') }
		}
	});

	$('#txtPqrCod').click(function(){
		modal=4;
		$('#txtPqrNomb').val('');
	});
	$("#txtPqrCod").keypress(function(event){
		if(event.which == 13){
			pqr = $.trim($('#txtPqrCod').val());
			if( (pqr!='') ){
				buscarPqr(pqr);
			}else{ alert('Porfavor coloque un pqr valido') }
		}
	});

	$('#txtTecCod').click(function(){

		modal=5;
		$('#txtTecNomb').val('');
	});
	$("#txtTecCod").keypress(function(event){
		if(event.which == 13){
			cod = $.trim($('#txtTecCod').val());
			pqr = $('#txtPqrCod').val();

			if( (cod!='') && (pqr!='') ){
				buscarPqr(pqr);
				buscarTecnico(pqr,cod);
			}else{ alert('Porfavor complete los datos') }
		}
	});

	//ASIGNAR ORDENES
	$('#btnGuardar').click(function(){
		tec = $('#txtTecCod').val();
		tecNom = $('#txtTecNomb').val();
		if(tecNom!=''){
			//RECORRER LAS ORDENES
			cont = $('#contRow').val();
			sw=false;
			for(var i=0;i<=cont;i++){
				if($("#txtCheck"+i).is(':checked')){
					sw=true;
					dep = $('#txtHiddenDepa'+i).val();
					loc = $('#txtHiddenLoca'+i).val();
					ord = $('#txtHiddenOrde'+i).val();
					//DEASIGNAR ORDEN AL TECNICO

						deasignarOrden(dep,loc,ord);
					//END DEASIGNAR ORDEN AL TECNICO
				}
			}
			if(!sw){ alert('Porfavor elija minimo una orden') }
			alert('Las ordenes se desasignaron correctamente al tenico')
			mostrarOrdenes();
		}
	});
});

var modal = 1;
//DEPARTAMENTO
function addDepartamento(cod,dep){
	$('#txtDepCod').val(cod);
	$('#txtDepNomb').val(dep);
	$('#modalDepartamentos').modal('hide');
}
function buscarDepartamento(dep){
	$.ajax({
        type:'POST',
        url:'proc/demo_proc.php?accion=buscar_departamento',
        data:{dep:dep},
        success: function(data){
        	$('#txtDepNomb').val(data);
        }
    });
}
//LOCALIDADES
function addLocalidad(cod,loc){
	$('#txtLocCod').val(cod);
	$('#txtLocNomb').val(loc);
	$('#modalLocalidad').modal('hide');
}
function buscarLocalidad(dep,loc){
	$.ajax({
        type:'POST',
        url:'proc/demo_proc.php?accion=buscar_localidades',
        data:{dep:dep, loc:loc},
        success: function(data){
        	$('#txtLocNomb').val(data);
        }
    });
}
function actualizarLocalidad(dep){
	$.ajax({
        type:'POST',
        url:'proc/demo_proc.php?accion=actualizar_localidades',
        data:{dep:dep},
        success: function(data){
        	$('#divLocalidades').html(data);
        	$('#modalLocalidad').modal('show');
        }
    });
}
//SECTORES
function addSector(cod,sec){
	$('#txtSectCod').val(cod);
	$('#txtSectNomb').val(sec);
	$('#modalSectores').modal('hide');
}
function actualizarSectores(dep,loc){
	$.ajax({
        type:'POST',
        url:'proc/demo_proc.php?accion=actualizar_sectores',
        data:{dep:dep, loc:loc},
        success: function(data){
        	$('#divSectores').html(data);
        	$('#modalSectores').modal('show');
        }
    });
}
function buscarSector(dep,loc,sec){
	if(sec!=0){
		$.ajax({
	        type:'POST',
	        url:'proc/demo_proc.php?accion=buscar_sector',
	        data:{dep:dep, loc:loc, sec:sec},
	        success: function(data){
	        	$('#txtSectNomb').val(data);
	        }
	    });
	}else{

	    $('#txtSectNomb').val('Todos');
	}
}
//PQR
function addPqr(cod,pqr){
	$('#txtPqrCod').val(cod);
	$('#txtPqrNomb').val(pqr);
	$('#modalPqr').modal('hide');
}
function buscarPqr(pqr){
	if(pqr!=0){
		$.ajax({
	        type:'POST',
	        url:'proc/demo_proc.php?accion=buscar_pqr',
	        data:{pqr:pqr},
	        success: function(data){
	        	$('#txtPqrNomb').val(data);
	        }
	    });
	}else{
		
		$('#txtPqrNomb').val('Todos');
	}
}
//TECNICO
function addTecnico(cod,tec){
	$('#txtTecCod').val(cod);
	$('#txtTecNomb').val(tec);
	$('#modalTecnicos').modal('hide');
}
function actualizarTecnico(pqr){
	$.ajax({
        type:'POST',
        url:'proc/demo_proc.php?accion=actualizar_tecnico',
        data:{pqr:pqr},
        success: function(data){
        	$('#divTecnicos').html(data);
        	$('#modalTecnicos').modal('show');
        }
    });
}
function buscarTecnico(pqr,tec){
	$.ajax({
        type:'POST',
        url:'proc/demo_proc.php?accion=buscar_tecnico',
        data:{tec:tec,pqr:pqr},
        success: function(data){
        	$('#txtTecNomb').val(data);
        }
    });
}
//ORDENES
function mostrarOrdenes(){
	dep = $('#txtDepCod').val();
	loc = $('#txtLocCod').val();
	sec = $('#txtSectCod').val();
	pqr = $('#txtPqrCod').val();
	tec = $('#txtTecCod').val();
	critOrd = $('input:radio[name=critOrd]:checked').val();

	if( (dep!='') && (loc!='') && (sec!='') && (pqr!='') ){
		$.ajax({
	        type:'POST',
	        url:'proc/demo_proc.php?accion=realizar_ordenamieno',
	        data:{ dep:dep,loc:loc,sec:sec,pqr:pqr,tec:tec,critOrd:critOrd },
	        success: function(data){
	        	$('#tableOrdenes').html(data);
	        	cont = $('#contRow').val();
	        	if(cont>0){
	        		$('#btnGuardar').removeClass('disabled');
	        	}else{
	        		$('#btnGuardar').addClass('disabled');
	        	}
	        }
	    });
	}else{
		alert('Porfavor Complete los datos para realizar el ordenamiento')
	}
}
function deasignarOrden(dep,loc,ord){
	$.ajax({
        type:'POST',
        url:'proc/demo_proc.php?accion=desasignar_orden',
        data:{ dep:dep,loc:loc,ord:ord },
        success: function(data){
        	console.log(data)
        }
    });
}
//OTROS
function swEditor(trId){
	$('.trDefault').removeClass('trSelect');
	$('#'+trId).addClass('trSelect');
}
function limpiarPantalla(){
	$('#txtDepCod').val('');
	$('#txtDepNomb').val('');
	$('#txtLocCod').val('');
	$('#txtLocNomb').val('');
	$('#txtSectCod').val('');
	$('#txtSectNomb').val('');
	$('#txtPqrCod').val('');
	$('#txtPqrNomb').val('');
	$('#txtTecCod').val('');
	$('#txtTecNomb').val('');
	limpiarTabla();
}
function limpiarTabla(){
	$.ajax({
        type:'POST',
        url:'proc/demo_proc.php?accion=limpiar_tabla',
        data:{ id:'1' },
        success: function(data){
        	$('#tableOrdenes').html(data);
        }
    });
}
function solonumeros(){
	if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
	    event.returnValue = false;
}
function selectTodos(){
	cont = $('#contRow').val();
	marcado = $('#swCheckTodos').val();

	if(marcado!=1){
		$('#swCheckTodos').val(1);
		for(var i=0;i<=cont;i++){
			$("#txtCheck"+i).click();
		}
	}else{
		for(var i=0;i<=cont;i++){
			$("#txtCheck"+i).prop("checked","");
		}
		$('#swCheckTodos').val(0);
	}
	$('.trDefault').removeClass('trSelect');
}
function escogencia(sw){
	cont = $('#contRow').val();
	if(sw==1){
		//$('#swCheckTodos').val(1);
		for(var i=0;i<=cont;i++){
			$("#txtCheck"+i).click();
		}
	}else{
		for(var i=0;i<=cont;i++){
			$("#txtCheck"+i).prop("checked","");
		}
		//$('#swCheckTodos').val(0);
	}
	$('.trDefault').removeClass('trSelect');
}