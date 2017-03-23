$(document).ready(function () {
	//$('#btnNuevo').removeClass('disabled');
	//$('#btnGuardar').removeClass('disabled');
	$('#btnListaValores').addClass('disabled');
	$('#btnConsulta').removeClass('disabled');
	$('#btnEditor').addClass('disabled');
	
	$("#txtCod").keypress(function(event){
		if(event.which == 13){
			//$('#btnConsulta').removeClass('disabled');
	        //$('#btnCancelar').addClass('disabled');
	        $('#divConsultarTecnicos').html('');

	        $('#btnPrimer').addClass('disabled');
		    $('#btnAnterior').addClass('disabled');
		    $('#btnSiguiente').addClass('disabled');
		    $('#btnUltimo').addClass('disabled');
			codTec = $('#txtCod').val();
			buscarTecnico(codTec);
		}
	});

	$("#btnCancelar").click(function(){

		limpiar();
		$('#btnConsulta').removeClass('disabled');
        $('#btnCancelar').addClass('disabled');
        $('#divConsultarTecnicos').html('');

        $('#btnPrimer').addClass('disabled');
	    $('#btnAnterior').addClass('disabled');
	    $('#btnSiguiente').addClass('disabled');
	    $('#btnUltimo').addClass('disabled');
	});


	$("#btnConsulta").click(function(){

		$('#btnNuevo').addClass('disabled');
		$('#btnConsulta').addClass('disabled');
		$('#btnCancelar').removeClass('disabled');
		buscarTecnicos();
	});

	$('#btnPrimer').click(function(){

		$('#txtActual').val(1);
		cod = $('#txtCod1').val();
		if($('#txtToltal').val()!=0 ){
			buscarTecnico(cod);
		}
	});
	$('#btnAnterior').click(function(){
		
		codId = parseInt($('#txtActual').val());
		$('#txtActual').val(codId-1);
		codId = parseInt($('#txtActual').val());

		if(codId>=1){
			cod = $('#txtCod'+codId).val();
			buscarTecnico(cod);
		}else{
			$('#txtActual').val(1);
		}
	});
	$('#btnSiguiente').click(function(){

			codId = parseInt($('#txtActual').val());
			$('#txtActual').val(codId+1);
			codId = parseInt($('#txtActual').val());

			codUlt = parseInt($('#txtToltal').val());
			if(codId<=codUlt){
				cod = $('#txtCod'+codId).val();
				buscarTecnico(cod);
			}else{
				$('#txtActual').val(codUlt);
			}
	});
	$('#btnUltimo').click(function(){
		codUlt = parseInt($('#txtToltal').val());
		$('#txtActual').val(codUlt);
		cod = $('#txtCod'+codUlt).val();
		buscarTecnico(cod);
	});
});
function buscarTecnico(cod){
	$.ajax({
        type:'POST',
        url:'proc/ptecni_proc.php?accion=obtener_usuario',
        data:{cod:cod},
        dataType: "json",
        success: function(data){
        	if(data[0]!=0){
        		$('#txtCod').val(cod);
        		$('#txtCodOrg').val(cod);
        		$('#txtNom').val(data[1]);
        		
        		$('#txtClaseCod').val(data[2]);
        		$('#txtClaseNomb').val(data[3]);
        		
        		//activo
        		if(data[4]=='A'){
        			$('#div_ckAct').html('<input type="checkbox" id="ckAct" checked> <label class="control-label">Activo</label>');
                }else{
        			$('#div_ckAct').html('<input type="checkbox" id="ckAct"> <label class="control-label">Activo</label>');
        		}

        		$('#txtFechaIng').val(data[5]);
        		$('#txtFechaRet').val(data[6]);
        		$('#txtCodBodega').val(data[8]);
        		
        		$('#txtSalario').val(data[9]);

        		$('#btnConsulta').addClass('disabled');
        		$('#btnCancelar').removeClass('disabled');

        		buscarOrdenesSinCumplir(1);
        		buscarOrdenesCumplidasxCertificar(1);
        		buscarOrdenesCumplidasCertificada(1);
        		buscarOrdenesIncumplidas(1);
        		buscarOrdenesAnuladas(1);
        		buscarMaterialesLegalizados(1);
        		buscarManoObraLegalizadas(1);
        		buscarActa();
        		buscarManoObraActa();
        		buscarNotasActa();
        		buscarInventario();
        		buscarNotas();
                buscarElementProtecPersonal();
                buscarHerramientas();
        	}else{
				limpiar();
                var msgError = 'Error! El Tecnico no existe';
                demo.showNotification('bottom','left', msgError, 4);
        	}
        }
    });
}
function buscarOrdenesSinCumplir(order){
	$('#table_ordenesSinCumplir').html('');
	cod = $('#txtCod').val();
	$.ajax({
        type:'POST',
        url:'proc/ptecni_proc.php?accion=consultar_ordenes',
        data:{ cod:cod, order:order},
        success: function(data){
        	$('#table_ordenesSinCumplir').html(data);
        }
    });
}
function buscarOrdenesCumplidasxCertificar(order){
	$('#table_ordenesCumplidasxCertificar').html('');
	cod = $('#txtCod').val();
	$.ajax({
        type:'POST',
        url:'proc/ptecni_proc.php?accion=consultar_ordenes_x_certificar',
        data:{ cod:cod, order:order},
        success: function(data){
        	$('#table_ordenesCumplidasxCertificar').html(data);
        }
    });
}
function buscarOrdenesCumplidasCertificada(order){
	$('#table_ordenesCumplidasCertificada').html('');
	cod = $('#txtCod').val();
	$.ajax({
        type:'POST',
        url:'proc/ptecni_proc.php?accion=consultar_ordenes_certificadas',
        data:{ cod:cod, order:order},
        success: function(data){
        	$('#table_ordenesCumplidasCertificada').html(data);
        }
    });
}
function buscarOrdenesIncumplidas(order){
	$('#table_ordenesIncumplidas').html('');
	cod = $('#txtCod').val();
	$.ajax({
        type:'POST',
        url:'proc/ptecni_proc.php?accion=consultar_ordenes_incumplidas',
        data:{ cod:cod, order:order},
        success: function(data){
        	$('#table_ordenesIncumplidas').html(data);
        }
    });
}
function buscarOrdenesAnuladas(order){
	$('#table_ordenesAnuladas').html('');
	cod = $('#txtCod').val();
	$.ajax({
        type:'POST',
        url:'proc/ptecni_proc.php?accion=consultar_ordenes_anuladas',
        data:{ cod:cod, order:order},
        success: function(data){
        	$('#table_ordenesAnuladas').html(data);
        }
    });
}
function buscarMaterialesLegalizados(order){
	$('#table_materialesLegalizados').html('');
	cod = $('#txtCod').val();
	$.ajax({
        type:'POST',
        url:'proc/ptecni_proc.php?accion=consultar_materiales_legalizados',
        data:{ cod:cod, order:order},
        success: function(data){
        	$('#table_materialesLegalizados').html(data);
        }
    });
}
function buscarManoObraLegalizadas(order){
	$('#table_manoDeObraLegalizada').html('');
	cod = $('#txtCod').val();
	$.ajax({
        type:'POST',
        url:'proc/ptecni_proc.php?accion=consultar_mano_obra_legalizadas',
        data:{ cod:cod, order:order},
        success: function(data){
        	$('#table_manoDeObraLegalizada').html(data);
        }
    });
}
function buscarActa(){
	$('#table_acta').html('');
	cod = $('#txtCod').val();
	$.ajax({
        type:'POST',
        url:'proc/ptecni_proc.php?accion=consultar_acta',
        data:{ cod:cod},
        success: function(data){
        	$('#table_acta').html(data);
        }
    });
}
function buscarManoObraActa(){
	$('#table_manoObraActa').html('');
	cod = $('#txtCod').val();
	$.ajax({
        type:'POST',
        url:'proc/ptecni_proc.php?accion=consultar_mano_obra_acta',
        data:{ cod:cod},
        success: function(data){
        	$('#table_manoObraActa').html(data);
        }
    });
}
function buscarNotasActa(){
	$('#table_notaAsociadaActa').html('');
	cod = $('#txtCod').val();
	$.ajax({
        type:'POST',
        url:'proc/ptecni_proc.php?accion=consultar_notas_acta',
        data:{ cod:cod},
        success: function(data){
        	$('#table_notaAsociadaActa').html(data);
        }
    });
}
function buscarInventario(){
	$('#table_inventario').html('');
	cod = $('#txtCod').val();
	$.ajax({
        type:'POST',
        url:'proc/ptecni_proc.php?accion=consultar_inventario',
        data:{ cod:cod},
        success: function(data){
        	$('#table_inventario').html(data);
        }
    });
}
function buscarNotas(){
	$('#table_notas').html('');
	cod = $('#txtCod').val();
	$.ajax({
        type:'POST',
        url:'proc/ptecni_proc.php?accion=consultar_notas',
        data:{ cod:cod},
        success: function(data){
        	$('#table_notas').html(data);
        }
    });
}
function buscarElementProtecPersonal(){
    $('#table_ordenesSinCumplir').html('');
    cod = $('#txtCod').val();
    $.ajax({
        type:'POST',
        url:'proc/ptecni_proc.php?accion=consultar_eleprop',
        data:{ cod:cod},
        success: function(data){
            $('#table_elmento_prot').html(data);
        }
    });
}
function buscarHerramientas(order){
    $('#table_ordenesSinCumplir').html('');
    cod = $('#txtCod').val();
    $.ajax({
        type:'POST',
        url:'proc/ptecni_proc.php?accion=consultar_herramientas',
        data:{ cod:cod, order:order},
        success: function(data){
            $('#table_herramientas').html(data);
        }
    });
}

function buscarTecnicos(){
	$('#divConsultarTecnicos').html('');
	$.ajax({
        type:'POST',
        url:'proc/ptecni_proc.php?accion=consultar_tenicos',
        data:{ codTec:'1'},
        success: function(data){
        	$('#divConsultarTecnicos').html(data);

        	$('#btnPrimer').click();
        }
    });

    $('#btnPrimer').removeClass('disabled');
    $('#btnAnterior').removeClass('disabled');
    $('#btnSiguiente').removeClass('disabled');
    $('#btnUltimo').removeClass('disabled');

    $('#btnCancelar').removeClass('disabled');
    $('#btnConsulta').addClass('disabled');	
}
function solonumeros(){
    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
        event.returnValue = false;
}
function limpiar(){
	$('#txtCod').val('');
	$('#txtNom').val('');
	$('#txtClaseCod').val('');
	$('#txtClaseNomb').val('');
	$('#div_ckAct').html('<input type="checkbox" id="ckAct">');
	$('#txtFechaIng').val('');
	$('#txtFechaRet').val('');
	$('#txtCodBodega').val('');
	$('#div_ckInv').html('<input type="checkbox" id="ckInv" onclick="swManejaBodega()">');
	$('#divSwCodigoBodegaLabel').addClass('display-none');
	$('#divSwCodigoBodegaInput').addClass('display-none');
	$('#txtSalario').val('');
	$('#div_ckDevProd').html('<input type="checkbox" id="ckDevProd">');
	$('#swEstadoTecnico').val(0);
}
function limpiarTablas(){

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
function enviarOrden(idOrden,usuario){

    $('#txtIdUsuarioPost').val(usuario);
    $('#txtIdOrdenPost').val(idOrden);

    $('#formDetalleOrdenPost').submit();

}