$(document).ready(function () {
	//$('#btnNuevo').removeClass('disabled');
	//$('#btnGuardar').removeClass('disabled');
	$('#btnListaValores').addClass('disabled');
	$('#btnConsulta').removeClass('disabled');
	$('#btnEditor').addClass('disabled');
    $("#txtCod").focus();
	
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

				$('.liTab').removeClass('active');
				$('.tab-pane').removeClass('active');

        		buscarOrdenesSinCumplir(1);
        		buscarOrdenesCumplidasxCertificar(1);
        		buscarOrdenesCumplidasCertificada(1);
        		buscarOrdenesIncumplidas(1);
        		buscarOrdenesAnuladas(1);
        		buscarMaterialesLegalizados(1);
        		buscarManoObraLegalizadas(1);
        		buscarActa();
        		//buscarManoObraActa();
        		//buscarNotasActa();
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

			//validar
				tab = $('#txtIdSelecttecnico_tab').val();
				if(tab==1){
					$('#ot_sinCumplir').addClass('active');
					$('#ordenesSinCumplir').addClass('active');

					cod = $('#txtIdSelecttecnico').val();
					$('#'+cod).addClass('trSelect');
				}
			//

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

			//validar
				tab = $('#txtIdSelecttecnico_tab').val();
				if(tab==2){
					$('#ot_cumXcertif').addClass('active');
					$('#ordenesCumplidasXcertificar').addClass('active');

					cod = $('#txtIdSelecttecnico').val();
					$('#'+cod).addClass('trSelect');
				}
			//
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

			//validar
				tab = $('#txtIdSelecttecnico_tab').val();
				if(tab==3){
					$('#ot_cumCertifi').addClass('active');
					$('#ordenesCumplidasCertificada').addClass('active');

					cod = $('#txtIdSelecttecnico').val();
					$('#'+cod).addClass('trSelect');
				}
			//
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

			//validar
				tab = $('#txtIdSelecttecnico_tab').val();
				if(tab==4){
					$('#ot_incumplida').addClass('active');
					$('#ordenesIncumplidas').addClass('active');

					cod = $('#txtIdSelecttecnico').val();
					$('#'+cod).addClass('trSelect');
				}
			//
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

			//validar
				tab = $('#txtIdSelecttecnico_tab').val();
				if(tab==5){
					$('#ot_anuladas').addClass('active');
					$('#ordenesAnuladas').addClass('active');

					cod = $('#txtIdSelecttecnico').val();
					$('#'+cod).addClass('trSelect');
				}
			//
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

			//validar
				tab = $('#txtIdSelecttecnico_tab').val();
				if(tab==6){
					$('#ot_matLegaliz').addClass('active');
					$('#materialesLegalizados').addClass('active');

					cod = $('#txtIdSelecttecnico').val();
					$('#'+cod).addClass('trSelect');
				}
			//
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

			//validar
				tab = $('#txtIdSelecttecnico_tab').val();
				if(tab==7){
					$('#ot_manLegaliz').addClass('active');
					$('#manoDeObraLegalizada').addClass('active');

					cod = $('#txtIdSelecttecnico').val();
					$('#'+cod).addClass('trSelect');
				}
			//
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
			//validar
				tab = $('#txtIdSelecttecnico_tab').val();
				if(tab==8){
					$('#ot_acta_tec').addClass('active');
					$('#acta').addClass('active');

					cod = $('#txtIdSelecttecnico').val();
					$('#'+cod).addClass('trSelect');

					idActa = $('#txtIdOrdenPost').val();
					buscarManoObraActa(idActa);
					buscarNotasActa(idActa);
				}
			//
        }
    });
}
function buscarManoObraActa(idActa){
	$('#table_manoObraActa').html('');
	$.ajax({
        type:'POST',
        url:'proc/ptecni_proc.php?accion=consultar_mano_obra_acta',
        data:{ idActa:idActa},
        success: function(data){
        	$('#table_manoObraActa').html(data);
        }
    });
}
function buscarNotasActa(idActa){
	$('#table_notaAsociadaActa').html('');
	tec = $('#txtCod').val();
	$.ajax({
        type:'POST',
        url:'proc/ptecni_proc.php?accion=consultar_notas_acta',
        data:{ idActa:idActa, tec:tec},
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
function trSelect_acta(trId,idActa){
    $('.trDefault').removeClass('trSelect');
    $('#'+trId).addClass('trSelect');

	buscarManoObraActa(idActa);
	buscarNotasActa(idActa);
}
function trSelect_inventario(trId){
    $('.trDefault').removeClass('trSelect');
    $('#'+trId).addClass('trSelect');
}
function trSelect_notas(trId){
    $('.trDefault').removeClass('trSelect');
    $('#'+trId).addClass('trSelect');
}
function enviarOrden(idOrden,usuario,trSelect,tab){

	//acta
	if(idOrden!=usuario){
		$('#formDetalleOrdenPost').attr('action','cusuOrden.php');
	}else{
		$('#formDetalleOrdenPost').attr('action','cacta.php');
	}
	
	$('#txtIdUsuarioPost').val(usuario);
	$('#txtIdOrdenPost').val(idOrden);
	$('#txtIdSelecttecnico').val(trSelect);
	$('#txtIdSelecttecnico_tab').val(tab);
	
	tecn = $('#txtCod').val();
	$('#txtIdTecnicoPost').val(tecn);

	$('#formDetalleOrdenPost').submit();
}