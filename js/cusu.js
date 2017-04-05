$(document).ready(function () {
	
	init = $.trim($('#txtCod').val());
	if(init!=''){
		actulizarOrdenes(init);
	}

	$('#txtCod').focus();

    $('#btnListaValores').addClass('disabled');
    $('#btnEditor').addClass('disabled');

    $("#txtCod").click(function(){
        
    });

	$("#txtCod").keypress(function(event){
		if(event.which == 13){
			id = $.trim($('#txtCod').val());
			if(id!=''){
				buscarUsuario(id);
			}else{
				var msgError = 'Error! Porfavor coloque un usuario valido';
				demo.showNotification('bottom','left', msgError, 4);
			}
		}
	});

	$('#btnConsulta').click(function(){
		$('#btnCancelar').click();
		buscarTodosUsuarios();
		$("#txtISelectPost").val('');
	});

	$('#btnCancelar').click(function(){
		limpiar();
		$('#divConsultarPqrUsuarios').html('');
		$("#txtCod").val('');
		$("#txtISelectPost").val('');

		$('#btnCancelar').addClass('disabled');
		$('#btnConsulta').removeClass('disabled');

		$('#btnPrimer').addClass('disabled');
    	$('#btnAnterior').addClass('disabled');
    	$('#btnSiguiente').addClass('disabled');
    	$('#btnUltimo').addClass('disabled');
	});

	$('#btnPrimer').click(function(){

		$('#txtActualUsu').val(1);
		cod = $('#txtCodUsu1').val();
		if($('#txtToltalUsu').val()!=0 ){
			if(cod>0){
				buscarUsuario(cod);
			}else{
				$('#btnSiguiente').click();
			}
		}
	});
	$('#btnAnterior').click(function(){
		
		codId = parseInt($('#txtActualUsu').val());
		$('#txtActualUsu').val(codId-1);
		codId = parseInt($('#txtActualUsu').val());

		if(codId>=1){
			cod = $('#txtCodUsu'+codId).val();
			buscarUsuario(cod);
		}else{
			$('#txtActualUsu').val(1);
		}
	});
	$('#btnSiguiente').click(function(){

			codId = parseInt($('#txtActualUsu').val());
			$('#txtActualUsu').val(codId+1);
			codId = parseInt($('#txtActualUsu').val());

			codUlt = parseInt($('#txtToltalUsu').val());
			if(codId<=codUlt){
				cod = $('#txtCodUsu'+codId).val();
				buscarUsuario(cod);
			}else{
				$('#txtActualUsu').val(codUlt);
			}
	});
	$('#btnUltimo').click(function(){
		codUlt = parseInt($('#txtToltalUsu').val());
		$('#txtActualUsu').val(codUlt);
		cod = $('#txtCodUsu'+codUlt).val();
		buscarUsuario(cod);
	});
});

function buscarTodosUsuarios(){
	$.ajax({
        type:'POST',
        url:'proc/cusu_proc.php?accion=cargar_usuarios',
        data:{cod:'1'},
        success: function(data){
        	$('#divConsultarPqrUsuarios').html(data);

        	$('#btnPrimer').removeClass('disabled');
        	$('#btnAnterior').removeClass('disabled');
        	$('#btnSiguiente').removeClass('disabled');
        	$('#btnUltimo').removeClass('disabled');

        	$('#btnConsulta').addClass('disabled');
        	$('#btnCancelar').removeClass('disabled');

        	$('#btnPrimer').click();
        }
    });
}
function buscarUsuario(cod){
	$.ajax({
        type:'POST',
        url:'proc/cusu_proc.php?accion=obtener_usuario',
        data:{cod:cod},
        dataType: "json",
        success: function(data){
        	if(data[0]!=0){
        		$('#txtCod').val(cod);
        		$('#txtNom').val(data[1]);
        		$('#txtDirec').val(data[2]);
        		$('#txtRuta').val(data[3]);
        		$('#txtMedidor').val(data[4]);

        		$('#txtCodSec').val(data[5]);
        		$('#txtNomSec').val(data[6]);

        		$('#txtBarr').val(data[7]);

        		$('#txtCodDep').val(data[8]);
        		$('#txtNomDep').val(data[9]);

        		$('#txtCodLoc').val(data[10]);
        		$('#txtNomLoc').val(data[11]);

        		$('#btnConsulta').addClass('disabled');
        		$('#btnCancelar').removeClass('disabled');
        		actulizarOrdenes(cod);
        	}else{
				limpiar();
				var msgError = 'Error! El Usuario no existe';
				demo.showNotification('bottom','left', msgError, 4);
        	}
        }
    });
}
function solonumeros(){
    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
        event.returnValue = false;
}
function actulizarOrdenes(cod){
	$.ajax({
        type:'POST',
        url:'proc/cusu_proc.php?accion=actualizar_ordenes',
        data:{cod:cod},
        success: function(data){
        	$('#tabla_historial_ordenes').html(data);

			cod = "#"+$("#txtISelectPost").val();
			$(cod).addClass("trSelect");
        }
    });
}
function limpiar(){
	//$('#txtCod').val('');
	$('#txtNom').val('');
	$('#txtDirec').val('');
	$('#txtRuta').val('');
	$('#txtMedidor').val('');
	$('#txtCodSec').val('');
	$('#txtNomSec').val('');
	$('#txtBarr').val('');
	$('#txtCodDep').val('');
	$('#txtNomDep').val('');
	$('#txtCodLoc').val('');
	$('#txtNomLoc').val('');

	limpiarTabla();
}
function limpiarTabla(){
	a = '<table class="table table-condensed table-bordered table-striped"><thead><tr style="background-color: #3c8dbc; color:white;">';
	b = '<th class="text-center" width="130">ORDEN</th><th class="text-center">FECHA ORDEN</th>';
	c = '<th class="text-center">FECHA ASIGNACION</th><th class="text-center">FECHA CUMPLIMIENTO</th>';
	d = '<th class="text-center">ESTADO</th><th class="text-center">PQR REPORTADA</th>';
	e = '<th class="text-center">PQR ENCONTRADA</th><th class="text-center">TECNICO</th>';
	f = '<th class="text-center">CAUSA ATENCION</th><th class="text-center">CAUSA NO ATENCION</th>';
	g = '</tr></thead><tbody></tbody></table>';
	$('#tabla_historial_ordenes').html(a+b+c+d+e+f+g);

	$('#txtObjAsgOrd').val('');
    $('#txtObjLegOrd').val('');
}

function trSelect(trId,idOrden){
	$('.trDefault').removeClass('trSelect');
	$('#'+trId).addClass('trSelect');

	//Observaciones
	$.ajax({
        type:'POST',
        url:'proc/cusu_proc.php?accion=obtener_obsOrden',
        data:{idOrden:idOrden},
        dataType: "json",
        success: function(data){
    		$('#txtObjAsgOrd').val(data[0]);
    		$('#txtObjLegOrd').val(data[1]);
        }
    });
}
function enviarOrden(idOrden,usuario,select){

	$('#txtIdUsuarioPost').val(usuario);
	$('#txtIdOrdenPost').val(idOrden);
	$('#txtISelectPost').val(select);

	$('#formDetalleOrdenPost').submit();

}
