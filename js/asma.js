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
				actualizarZonas(dep,loc);
			}
		}else if(modal==4){
			dep = $('#txtDepCod').val();
			loc = $('#txtLocCod').val();
			zon = $('#txtZonaCod').val();
			if(loc!=''){
				actualizarSectores(dep,loc,zon);
			}
		}else if(modal==5){
			$('#modalPqr').modal('show');
		}else{

			$('#modalTecnicos').modal('show');
		}
	});

	$('#txtDepCod').focus(function(){

		modal=1;
		$('#txtDepNomb').val('');

		$('#txtLocCod').val('');
		$('#txtLocNomb').val('');

		$('#txtZonaCod').val('');
		$('#txtZonaNomb').val('');

		$('#txtSectCod').val('');
		$('#txtSectNomb').val('');
	});
	// $("#txtDepCod").keypress(function(event){
	// 	if(event.which == 13){
	// 		dep = $.trim($('#txtDepCod').val());
	// 		if(dep!=''){
	// 			buscarDepartamento(dep);
	// 		}else{ alert('Porfavor coloque un departamento valido') }
	// 	}
	// });

	$('#txtLocCod').focus(function(){

		modal=2;
		$('#txtLocNomb').val('');

		$('#txtZonaCod').val('');
		$('#txtZonaNomb').val('');

		$('#txtSectCod').val('');
		$('#txtSectNomb').val('');
	});
	// $("#txtLocCod").keypress(function(event){
	// 	if(event.which == 13){
	// 		dep = $.trim($('#txtDepCod').val());
	// 		loc = $.trim($('#txtLocCod').val());
	// 		if( (dep!='') && (loc!='') ){
	// 			buscarDepartamento(dep);
	// 			buscarLocalidad(dep,loc);
	// 		}else{ alert('Porfavor coloque un departamento valido') }
	// 	}
	// });

	$('#txtZonaCod').focus(function(){

		modal=3;
		$('#txtZonaNomb').val('');

		$('#txtSectCod').val('');
		$('#txtSectNomb').val('');
	});
	// $("#txtZonaCod").keypress(function(event){
	// 	if(event.which == 13){
	// 		dep = $.trim($('#txtDepCod').val());
	// 		loc = $.trim($('#txtLocCod').val());
	// 		zon = $.trim($('#txtZonaCod').val());
	// 		if( (dep!='') && (loc!='') && (zon!='') ){
	// 			buscarDepartamento(dep);
	// 			buscarLocalidad(dep,loc);
	// 			buscarZona(dep,loc,zon);
	// 		}else{ alert('Porfavor coloque una localidad valido') }
	// 	}
	// });

	$('#txtSectCod').focus(function(){

		modal=4;
		$('#txtSectNomb').val('');
	});
	// $("#txtSectCod").keypress(function(event){
	// 	if(event.which == 13){
	// 		dep = $.trim($('#txtDepCod').val());
	// 		loc = $.trim($('#txtLocCod').val());
	// 		zon = $.trim($('#txtZonaCod').val());
	// 		sec = $.trim($('#txtSectCod').val());
	// 		if( (dep!='') && (loc!='') && (zon!='') && (sec!='') ){
	// 			buscarDepartamento(dep);
	// 			buscarLocalidad(dep,loc);
	// 			buscarZona(dep,loc,zon);
	// 			buscarSector(dep,loc,zon,sec);
	// 		}else{ alert('Porfavor coloque una zona valido') }
	// 	}
	// });

	$('#txtPqrCod').focus(function(){

		modal=5;
		$('#txtPqrNomb').val('');
	});
	// $("#txtPqrCod").keypress(function(event){
	// 	if(event.which == 13){
	// 		pqr = $.trim($('#txtPqrCod').val());
	// 		if( (pqr!='') ){
	// 			buscarPqr(pqr);
	// 		}else{ alert('Porfavor coloque un pqr valido') }
	// 	}
	// });

	$('#txtTecCod').focus(function(){

		modal=6;
		$('#txtTecNomb').val('');
	});
	// $("#txtTecCod").keypress(function(event){
	// 	if(event.which == 13){
	// 		cod = $.trim($('#txtTecCod').val());
	// 		if( (cod!='') ){
	// 			buscarTecnico(cod);
	// 		}else{ alert('Porfavor coloque un tecnico valido') }
	// 	}
	// });

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
					//ASIGNAR ORDEN AL TECNICO

						asignarOrden(dep,loc,ord,tec);
					//END ASIGNAR ORDEN AL TECNICO
				}
			}
			if(!sw){ 
				var msgError = 'Porfavor elija minimo una orden';
				demo.showNotification('bottom','left', msgError, 4);
			}
			var msgError = 'Las ordenes se asignaron correctamente al tenico';
			demo.showNotification('bottom','left', msgError, 2);
			mostrarOrdenes();
		}else{
			var msgError = 'Porfavor coloque un tecnico valido';
			demo.showNotification('bottom','left', msgError, 4);
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
        url:'proc/asma_proc.php?accion=buscar_departamento',
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
        url:'proc/asma_proc.php?accion=buscar_localidades',
        data:{dep:dep, loc:loc},
        success: function(data){
        	$('#txtLocNomb').val(data);
        }
    });
}
function actualizarLocalidad(dep){
	$.ajax({
        type:'POST',
        url:'proc/asma_proc.php?accion=actualizar_localidades',
        data:{dep:dep},
        success: function(data){
        	$('#divLocalidades').html(data);
        	$('#modalLocalidad').modal('show');
        }
    });
}
//ZONAS
function addZona(cod,zon){
	$('#txtZonaCod').val(cod);
	$('#txtZonaNomb').val(zon);
	$('#modalZonas').modal('hide');
}
function actualizarZonas(dep,loc){
	$.ajax({
        type:'POST',
        url:'proc/asma_proc.php?accion=actualizar_zonas',
        data:{dep:dep, loc:loc},
        success: function(data){
        	$('#divZonas').html(data);
        	$('#modalZonas').modal('show');
        }
    });
}
function buscarZona(dep,loc,zon){
	$.ajax({
        type:'POST',
        url:'proc/asma_proc.php?accion=buscar_zona',
        data:{dep:dep, loc:loc, zon:zon},
        success: function(data){
        	$('#txtZonaNomb').val(data);
        }
    });
}
//SECTORES
function addSector(cod,sec){
	$('#txtSectCod').val(cod);
	$('#txtSectNomb').val(sec);
	$('#modalSectores').modal('hide');
}
function actualizarSectores(dep,loc,zon){
	$.ajax({
        type:'POST',
        url:'proc/asma_proc.php?accion=actualizar_sectores',
        data:{dep:dep, loc:loc, zon:zon},
        success: function(data){
        	$('#divSectores').html(data);
        	$('#modalSectores').modal('show');
        }
    });
}
function buscarSector(dep,loc,zon,sec){
	if(sec!=0){
		$.ajax({
	        type:'POST',
	        url:'proc/asma_proc.php?accion=buscar_sector',
	        data:{dep:dep, loc:loc, zon:zon, sec:sec},
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
	        url:'proc/asma_proc.php?accion=buscar_pqr',
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
function buscarTecnico(tec){
	$.ajax({
        type:'POST',
        url:'proc/asma_proc.php?accion=buscar_tecnico',
        data:{tec:tec},
        success: function(data){
        	$('#txtTecNomb').val(data);
        }
    });
}
//ORDENES
function mostrarOrdenes(){
	dep = $('#txtDepCod').val();
	loc = $('#txtLocCod').val();
	zon = $('#txtZonaCod').val();
	sec = $('#txtSectCod').val();
	pqr = $('#txtPqrCod').val();
	tec = $('#txtTecCod').val();
	critOrd = $('input:radio[name=critOrd]:checked').val();

	if( (dep!='') && (loc!='') && (zon!='') && (sec!='') && (pqr!='') ){
		$.ajax({
	        type:'POST',
	        url:'proc/asma_proc.php?accion=realizar_ordenamieno',
	        data:{ dep:dep,loc:loc,zon:zon,sec:sec,pqr:pqr,tec:tec,critOrd:critOrd },
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
		var msgError = 'Porfavor Complete los datos para realizar el ordenamiento';
		demo.showNotification('bottom','left', msgError, 4);
	}
}
function asignarOrden(dep,loc,ord,tec){
	$.ajax({
        type:'POST',
        url:'proc/asma_proc.php?accion=asignar_orden',
        data:{ dep:dep,loc:loc,ord:ord,tec:tec },
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
	$('#txtZonaCod').val('');
	$('#txtZonaNomb').val('');
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
        url:'proc/asma_proc.php?accion=limpiar_tabla',
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

function pressEnter(campo){
	if(campo==='txtDepCod'){
		dep = $.trim($('#txtDepCod').val());
		if(dep!=''){
			buscarDepartamento(dep);
		}else{ 
			var msgError = 'Porfavor coloque un departamento valido';
			demo.showNotification('bottom','left', msgError, 4);
		}
	}
	if(campo==='txtLocCod'){
		dep = $.trim($('#txtDepCod').val());
		loc = $.trim($('#txtLocCod').val());
		if( (dep!='') && (loc!='') ){
			buscarDepartamento(dep);
			buscarLocalidad(dep,loc);
		}else{ 
			var msgError = 'Porfavor coloque un departamento valido';
			demo.showNotification('bottom','left', msgError, 4);
		}
	}
	if(campo==='txtZonaCod'){
		dep = $.trim($('#txtDepCod').val());
		loc = $.trim($('#txtLocCod').val());
		zon = $.trim($('#txtZonaCod').val());
		if( (dep!='') && (loc!='') && (zon!='') ){
			buscarDepartamento(dep);
			buscarLocalidad(dep,loc);
			buscarZona(dep,loc,zon);
		}else{ 
			var msgError = 'Porfavor coloque una localidad valido';
			demo.showNotification('bottom','left', msgError, 4);
		}
	}
	if(campo==='txtSectCod'){
		dep = $.trim($('#txtDepCod').val());
		loc = $.trim($('#txtLocCod').val());
		zon = $.trim($('#txtZonaCod').val());
		sec = $.trim($('#txtSectCod').val());
		if( (dep!='') && (loc!='') && (zon!='') && (sec!='') ){
			buscarDepartamento(dep);
			buscarLocalidad(dep,loc);
			buscarZona(dep,loc,zon);
			buscarSector(dep,loc,zon,sec);
		}else{ 
			var msgError = 'Porfavor coloque una zona valido';
			demo.showNotification('bottom','left', msgError, 4);
		}
	}
	if(campo==='txtPqrCod'){
		pqr = $.trim($('#txtPqrCod').val());
		if( (pqr!='') ){
			buscarPqr(pqr);
		}else{ 
			var msgError = 'Porfavor coloque un pqr valido';
			demo.showNotification('bottom','left', msgError, 4);
		}
	}
	if(campo==='txtTecCod'){
		cod = $.trim($('#txtTecCod').val());
		if( (cod!='') ){
			buscarTecnico(cod);
		}else{ 
			var msgError = 'Porfavor coloque un tecnico valido';
			demo.showNotification('bottom','left', msgError, 4);
		}
	}
}
