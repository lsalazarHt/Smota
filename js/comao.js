$(document).ready(function(){
	var modal = 1;
	$('#btnCancelar').removeClass('disabled');

	$("#txtDepCod").keypress(function(event){
		if(event.which == 13){
			dep = $("#txtDepCod").val();
			buscarDepartamento(dep);
		}
	});
	$("#txtLocCod").keypress(function(event){
		if(event.which == 13){
			dep = $("#txtDepCod").val();
			loc = $("#txtLocCod").val();
			if(dep!=''){
				buscarLocalidad(dep,loc);
			}
		}
	});
	$("#txtZonaCod").keypress(function(event){
		if(event.which == 13){
			dep = $("#txtDepCod").val();
			loc = $("#txtLocCod").val();
			zon = $("#txtZonaCod").val();
			if( (dep!='') && (loc!='') ){
				buscarZona(dep,loc,zon);
			}
		}
	});
	$("#txtSectCod").keypress(function(event){
		if(event.which == 13){
			dep = $("#txtDepCod").val();
			loc = $("#txtLocCod").val();
			zon = $("#txtZonaCod").val();
			sec = $("#txtSectCod").val();
			if( (dep!='') && (loc!='') && (sec!='') ){
				buscarSector(dep,loc,zon,sec);
			}
		}
	});
	$("#txtPqrCod").keypress(function(event){
		if(event.which == 13){
			pqr = $("#txtPqrCod").val();
			buscarPqr(pqr);
		}
	});
	$("#txtTecCod").keypress(function(event){
		if(event.which == 13){
			pqr = $("#txtPqrCod").val();
			tec = $("#txtTecCod").val();
			if(pqr!=''){
				buscarTec(pqr,tec);
			}
		}
	});
	$("#txtCuaCod").keypress(function(event){
		if(event.which == 13){
			cuad = $("#txtCuaCod").val();
			buscarCuadrilla(cuad);
		}
	});
	$("#txtEstCod").keypress(function(event){
		if(event.which == 13){
			est = $("#txtEstCod").val();
			buscarEstado(est);
		}
	});
	$("#txtUsuCod").keypress(function(event){
		if(event.which == 13){
			usu = $("#txtUsuCod").val();
			buscarUsuario(usu);
		}
	});

	$('#btnListaValores').click(function(){
		if(modal==1){

        	$('#modalDepartamentos').modal('show');
		}else if(modal==2){
			dep = $.trim($('#txtDepCod').val());
			if(dep!=''){
				actualizarLocalidad(dep);
			}
		}else if(modal==3){
			dep = $.trim($('#txtDepCod').val());
			loc = $.trim($('#txtLocCod').val());
			if( (dep!='') && (loc!='') ){
				actualizarZona(dep,loc);
			}
		}else if(modal==4){
			dep = $.trim($('#txtDepCod').val());
			loc = $.trim($('#txtLocCod').val());
			zon = $.trim($('#txtZonaCod').val());
			if( (dep!='') && (loc!='') && (zon!='') ){
				actualizarSector(dep,loc,zon);
			}
		}else if(modal==5){

        	$('#modalPqr').modal('show');
		}else if(modal==6){
			pqr = $.trim($('#txtPqrCod').val());
			if(pqr!=''){
				actualizarTecnico(pqr);
			}
		}else if(modal==7){

        	$('#modalCuadrilla').modal('show');
        }else if(modal==8){

        	$('#modalEstado').modal('show');
        }else if(modal==9){

        	$('#modalUsuario').modal('show');
        }
    }); 
    $('#txtDepCod').click(function(){
    	modal = 1;
		$('#txtLocCod').val('');
		$('#txtLocNomb').val('');
    	$('#txtZonaCod').val('');
		$('#txtZonaNomb').val('');
		$('#txtSectCod').val('');
		$('#txtSectNomb').val('');
    });
    $('#txtLocCod').click(function(){
    	modal = 2;
    	$('#txtZonaCod').val('');
		$('#txtZonaNomb').val('');
		$('#txtSectCod').val('');
		$('#txtSectNomb').val('');
    });
    $('#txtZonaCod').click(function(){
    	modal = 3;
    	$('#txtSectCod').val('');
		$('#txtSectNomb').val('');
    });
    $('#txtSectCod').click(function(){
    	
    	modal = 4;
    });
    $('#txtPqrCod').click(function(){
    	modal = 5;
    	$('#txtTecCod').val('');
		$('#txtTecNomb').val('');
    });
    $('#txtTecCod').click(function(){
    	
    	modal = 6;
    });
    $('#txtCuaCod').click(function(){
    	modal = 7;
    	$("#txtCuaNomb").val('');
    });
    $('#txtEstCod').click(function(){
    	
    	modal = 8;
    });
    $('#txtUsuCod').click(function(){
    	
    	modal = 9;
    });

	$('#btnCancelar').click(function(){
        
        limpiarTodo();
    });
	$('#btnConsulta').click(function(){
		
        mostrarOrdenes();
    });
});

function buscarNumeroOrden(dep,loc,num){
    $.ajax({
        type:'POST',
        url:'proc/corden_proc.php?accion=obtener_ordenes',
        data:{ dep:dep, loc:loc, num:num },
        success: function(data){
            $('#divOrden').html(data);
        }
    });
}

//BUSCAR
function buscarDepartamento(id){
	$.ajax({
        type:'POST',
        url:'proc/comao_proc.php?accion=buscar_departamento',
        data:{ id:id },
        success: function(data){
			$('#txtDepCod').val(id);
			$('#txtDepNomb').val(data);
        }
    });
}
function buscarLocalidad(dep,loc){
	$.ajax({
        type:'POST',
        url:'proc/comao_proc.php?accion=buscar_localidad',
        data:{ dep:dep, loc:loc },
        success: function(data){
			$('#txtLocCod').val(loc);
			$('#txtLocNomb').val(data);
        }
    });
}
function buscarZona(dep,loc,zon){
	$.ajax({
        type:'POST',
        url:'proc/comao_proc.php?accion=buscar_zona',
        data:{ dep:dep, loc:loc, zon:zon },
        success: function(data){
			$('#txtZonaCod').val(zon);
			$('#txtZonaNomb').val(data);
        }
    });
}
function buscarSector(dep,loc,zon,sec){
	$.ajax({
        type:'POST',
        url:'proc/comao_proc.php?accion=buscar_sector',
        data:{ dep:dep, loc:loc, zon:zon, sec:sec },
        success: function(data){
			$('#txtSectCod').val(sec);
			$('#txtSectNomb').val(data);
        }
    });
}
function buscarPqr(id){
	$.ajax({
        type:'POST',
        url:'proc/comao_proc.php?accion=buscar_pqr',
        data:{ id:id },
        success: function(data){
			$('#txtPqrCod').val(id);
			$('#txtPqrNomb').val(data);
        }
    });
}
function buscarTec(pqr,tec){
	$.ajax({
        type:'POST',
        url:'proc/comao_proc.php?accion=buscar_tecnico',
        data:{ pqr:pqr, tec:tec },
        success: function(data){
			$('#txtTecCod').val(tec);
			$('#txtTecNomb').val(data);
        }
    });
}
function buscarCuadrilla(id){
	$.ajax({
        type:'POST',
        url:'proc/comao_proc.php?accion=buscar_cuadrilla',
        data:{ id:id },
        success: function(data){
			$('#txtCuaCod').val(id);
			$('#txtCuaNomb').val(data);
        }
    });
}
function buscarEstado(id){
	$.ajax({
        type:'POST',
        url:'proc/comao_proc.php?accion=buscar_estado',
        data:{ id:id },
        success: function(data){
			$('#txtEstCod').val(id);
			$('#txtEstNomb').val(data);
        }
    });
}
function buscarUsuario(id){
	$.ajax({
        type:'POST',
        url:'proc/comao_proc.php?accion=buscar_usuario',
        data:{ id:id },
        success: function(data){
			$('#txtUsuCod').val(id);
			$('#txtUsuNomb').val(data);
        }
    });
}
//ACTUALIZAR
function actualizarLocalidad(dep){
	$.ajax({
        type:'POST',
        url:'proc/comao_proc.php?accion=actualizar_localidades',
        data:{ dep:dep },
        success: function(data){
            $('#divLocalidades').html(data);
        	$('#modalLocalidad').modal('show');
        }
    });
}
function actualizarZona(dep,loc){
	$.ajax({
        type:'POST',
        url:'proc/comao_proc.php?accion=actualizar_zonas',
        data:{ dep:dep, loc:loc },
        success: function(data){
            $('#divZonas').html(data);
        	$('#modalZonas').modal('show');
        }
    });
}
function actualizarSector(dep,loc,zon){
	$.ajax({
        type:'POST',
        url:'proc/comao_proc.php?accion=actualizar_sectores',
        data:{ dep:dep, loc:loc, zon:zon },
        success: function(data){
            $('#divSectores').html(data);
        	$('#modalSectores').modal('show');
        }
    });
}
function actualizarTecnico(pqr){
	$.ajax({
        type:'POST',
        url:'proc/comao_proc.php?accion=actualizar_tecnico',
        data:{ pqr:pqr },
        success: function(data){
            $('#tableTecnicos').html(data);
        	$('#modalTecnicos').modal('show');
        }
    });
}

//ADD
function addDepartamento(id,nom){
	$('#txtDepCod').val(id);
	$('#txtDepNomb').val(nom);
	$('#modalDepartamentos').modal('hide');
}
function addLocalidad(id,nom){
	$('#txtLocCod').val(id);
	$('#txtLocNomb').val(nom);
	$('#modalLocalidad').modal('hide');
}
function addZona(id,nom){
	$('#txtZonaCod').val(id);
	$('#txtZonaNomb').val(nom);
	$('#modalZonas').modal('hide');
}
function addSector(id,nom){
	$('#txtSectCod').val(id);
	$('#txtSectNomb').val(nom);
	$('#modalSectores').modal('hide');
}
function addPqr(id,nom){
	$('#txtPqrCod').val(id);
	$('#txtPqrNomb').val(nom);
	$('#modalPqr').modal('hide');
}
function addTecnico(id,nom){
	$('#txtTecCod').val(id);
	$('#txtTecNomb').val(nom);
	$('#modalTecnicos').modal('hide');
}
function addCuadrilla(id,nom){
	$('#txtCuaCod').val(id);
	$('#txtCuaNomb').val(nom);
	$('#modalCuadrilla').modal('hide');
}
function addEstado(id,nom){
	$('#txtEstCod').val(id);
	$('#txtEstNomb').val(nom);
	$('#modalEstado').modal('hide');
}
function addUsuario(id,nom){
	$('#txtUsuCod').val(id);
	$('#txtUsuNomb').val(nom);
	$('#modalUsuario').modal('hide');
}
//
function mostrarOrdenes(){
	dep = $('#txtDepCod').val();
	loc = $('#txtLocCod').val();
	zon = $('#txtZonaCod').val();
	sec = $('#txtSectCod').val();
	pqr = $('#txtPqrCod').val();
	tec = $('#txtTecCod').val();
	cua = $('#txtCuaCod').val();
	est = $('#txtEstCod').val();
	fin = $('#txtFechaInicial').val();
	ffi = $('#txtFechaFin').val();
	usu = $('#txtUsuCod').val();
	critOrd = $('input:radio[name=critOrd]:checked').val();

	if( (dep!='') && (loc!='') ){
		$.ajax({
		    type:'POST',
		    url:'proc/comao_proc.php?accion=realizar_ordenamieno',
		    data:{ dep:dep, loc:loc, zon:zon, sec:sec, pqr:pqr, tec:tec, cua:cua, est:est, fin:fin, ffi:ffi, usu:usu ,critOrd:critOrd},
		    success: function(data){
		        $('#divOrden').html(data);
		    }
		});
	}else{ alert('Porfavor coloque un departamento y una localidad valida.') }
}
function swEditor(trId){

	//varEditor = id;
	$('.trDefault').removeClass('trSelect');
	$('#'+trId).addClass('trSelect');
}
function enviarOrden(idOrden,usuario){

	$('#txtIdUsuarioPost').val(usuario);
	$('#txtIdOrdenPost').val(idOrden);

	$('#formDetalleOrdenPost').submit();
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
	$('#txtCuaCod').val('');
	$('#txtCuaNomb').val('');
	$('#txtEstCod').val('');
	$('#txtEstNomb').val('');
	$('#txtFechaInicial').val('');
	$('#txtFechaFin').val('');
	$('#txtUsuCod').val('');
	$('#txtUsuNomb').val('');
	limpiarTabla();
}
function limpiarTabla(){
	act = $('#txtFechaActual').val();
	$('#txtFechaInicial').val(act);
	$('#txtFechaFin').val(act);

	a  = '<table class="table table-bordered table-condensed"><thead>';
	a += '<tr style="background-color: #3c8dbc; color:white;">';
	a += '<th class="text-center" width="100">NRO DE ORDEN</th>';
	a += '<th class="text-center" width="70">FECHA</th>';
	a += '<th class="text-center" width="70">PQR</th>';
	a += '<th class="text-center" width="100">TECNICO</th>';
	a += '<th class="text-center" width="100">USUARIO</th>';
	a += '<th class="text-center" width="100">OBSERVACION</th>';
	a += '<th class="text-center" width="100">ESTADO</th>';
	a += '<th class="text-center" width="100">DIRECCION</th>';
	a += '<th class="text-center" width="100">SECTOR</th>';
	a += '</tr></thead><tbody></tbody></table>';
	$('#divOrden').html(a);
}
function solonumeros(){
    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
        event.returnValue = false;
}