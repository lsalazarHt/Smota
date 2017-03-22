$(document).ready(function () {
	
	$('#btnNuevo').removeClass('disabled');
	$('#btnGuardar').removeClass('disabled');
	$('#btnListaValores').addClass('disabled');
	$('#btnConsulta').removeClass('disabled');
	$('#txtCod').focus();

	$('#txtCot').click(function(){
		//$('#txtCot').val('');
		$('#txtNomt').val('');
		$('#btnListaValores').removeClass('disabled');
	});
	// $("#txtCot").keypress(function(event){
	// 	if(event.which == 13){
	// 		codTec = $('#txtCot').val();
	// 		buscarTecnico(codTec);
	// 	}
	// });

	// $("#txtCod").keypress(function(event){
	// 	if(event.which == 13){
	// 		codPqr = $('#txtCod').val();
	// 		buscarPqr(codPqr);
	// 	}
	// });

	
	//Agregar campos
	$('#btnNuevo').click(function(){
		$('#txtCod').val('');
		$('#txtCodOrg').val('');
		$('#txtNom').val('');
		$('#txtDia').val('');
		$('#div_ckSac').html('<input type="checkbox" id="ckSac">');
		$('#txtPoi').val('');
		$('#txtCdc').val('');
		$('#div_ckLmp').html('<input type="checkbox" id="ckLmp">');
		$('#div_ckLpa').html('<input type="checkbox" id="ckLpa">');
		$('#div_ckAct').html('<input type="checkbox" id="ckAct">');
		$('#div_ckLem').html('<input type="checkbox" id="ckLem">');
		$('#div_ckAdd').html('<input type="checkbox" id="ckAdd">');
		$('#div_ckIup').html('<input type="checkbox" id="ckIup">');

		$('#txtCot').val('');
		$('#txtNomt').val('');

		$('#txtPri').val('');
		$('#txtVtde').val('');
		$('#txtVtfu').val('');

		$('#swEstadoPqr').val(0);
	});
	//Guardar
	$('#btnGuardar').click(function(){
		tipo = $('#swEstadoPqr').val();

		cod = $.trim($('#txtCod').val());
		nom = $.trim($('#txtNom').val());
		dia = $.trim($('#txtDia').val());
		pInsp = $.trim($('#txtPoi').val());
		cCost = $.trim($('#txtCdc').val());
		prio = $.trim($('#txtPri').val());
		vTdentro = $.trim($('#txtVtde').val());
		vTfuera = $.trim($('#txtVtfu').val());
		cTec = $('#txtCot').val();
		nTec = $.trim($('#txtNomt').val());
		
		//Checkbox
			if($("#ckSac").is(':checked')) { sCert = 'S'; }
			else{ sCert = 'N'; }

			if($("#ckLmp").is(':checked')) { lMatPro = 'S'; }
			else{ lMatPro = 'N'; }

			if($("#ckLpa").is(':checked')) { lArch = 'S'; }
			else{ lArch = 'N'; }

			if($("#ckAct").is(':checked')) { act = 'A'; }
			else{ act = 'N'; }

			if($("#ckLem").is(':checked')) { lMater = 'S'; }
			else{ lMater = 'N'; }

			if($("#ckAdd").is(':checked')) { aDesb = 'S'; }
			else{ aDesb = 'N'; }

			if($("#ckIup").is(':checked')) { iUtil = 'S'; }
			else{ iUtil = 'N'; }
		//End Checkbox

		if( (cod!='') && (nom!='') && (dia!='') && (pInsp!='') && (cCost!='') && (prio!='') && (vTdentro!='') && (vTfuera!='') ){
			if( (cTec!='') && (nTec=='') ){
				var msgError = 'Error! Porfavor coloque un tecnico valido';
				demo.showNotification('bottom','left', msgError, 4);
				return false;
			}

			if(tipo==0){ //Nuevo
				$.ajax({
			        type:'POST',
			        url:'proc/ppqr_proc.php?accion=guardar_registros',
			        data:{cod:cod, nom:nom, dia:dia, pInsp:pInsp , cCost:cCost, prio:prio,
			        	  vTdentro:vTdentro, vTfuera:vTfuera, sCert:sCert, lMatPro:lMatPro,
			        	  lArch:lArch, act:act, lMater:lMater, aDesb:aDesb, iUtil:iUtil, cTec:cTec},
			        success: function(data){
			            if(data==1){
		                    $('#btnNuevo').click();
		                    var msgError = 'El PQR se agrego con exito';
							demo.showNotification('bottom','left', msgError, 2);
			            }else{ alert(data+' Agregar!') }
			        }
			    });
			}else{ //Editar
				codOrg = $.trim($('#txtCodOrg').val());
				$.ajax({
			        type:'POST',
			        url:'proc/ppqr_proc.php?accion=editar_registros',
			        data:{codOrg:codOrg,cod:cod, nom:nom, dia:dia, pInsp:pInsp , cCost:cCost, prio:prio,
			        	  vTdentro:vTdentro, vTfuera:vTfuera, sCert:sCert, lMatPro:lMatPro,
			        	  lArch:lArch, act:act, lMater:lMater, aDesb:aDesb, iUtil:iUtil, cTec:cTec},
			        success: function(data){
			            if(data==1){
		                    $('#btnNuevo').click();
		                    var msgError = 'El PQR se edito con exito';
							demo.showNotification('bottom','left', msgError, 2);
			            }else{ alert(data+' Editar!') }
			        }
			    });
			}
		}else{
			var msgError = 'Error! Porfavor complete los datos';
			demo.showNotification('bottom','left', msgError, 4);
		}
	});

	//Btn ListaValores
	$('#btnListaValores').click(function(){

		$('#modalTecnicos').modal('show');
	});

	//Editor
	$('#btnEditor').click(function(){
		var dat = $('#'+varEditor).val();
		$('#txtCampEditor').val(dat);
		$('#editModal').modal('show');
	});

	//Btn Consulta
	$('#btnConsulta').click(function(){
		$('#btnNuevo').click();
		$('#swEstadoPqr').val(1);
		$('#divConsultarPqrs').html('');
		$.ajax({
	        type:'POST',
	        url:'proc/ppqr_proc.php?accion=consultar_prq',
	        data:{ codTec:'1'},
	        success: function(data){
            	$('#divConsultarPqrs').html(data);

            	$('#btnPrimer').click();
	        }
	    });

	    $('#btnPrimer').removeClass('disabled');
	    $('#btnAnterior').removeClass('disabled');
	    $('#btnSiguiente').removeClass('disabled');
	    $('#btnUltimo').removeClass('disabled');

	    $('#btnCancelar').removeClass('disabled');
	    $('#btnConsulta').addClass('disabled');
	});

	$('#btnPrimer').click(function(){

		$('#txtActualPqr').val(1);
		cod = $('#txtCodPqr1').val();
		if($('#txtToltalPqr').val()!=0 ){
			buscarPqr(cod);
		}
	});
	$('#btnAnterior').click(function(){
		
		codId = parseInt($('#txtActualPqr').val());
		$('#txtActualPqr').val(codId-1);
		codId = parseInt($('#txtActualPqr').val());

		if(codId>=1){
			cod = $('#txtCodPqr'+codId).val();
			buscarPqr(cod);
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
				buscarPqr(cod);
			}else{
				$('#txtActualPqr').val(codUlt);
			}
	});
	$('#btnUltimo').click(function(){
		codUlt = parseInt($('#txtToltalPqr').val());
		$('#txtActualPqr').val(codUlt);
		cod = $('#txtCodPqr'+codUlt).val();
		buscarPqr(cod);
	});

	//Btn Cancelar
	$('#btnCancelar').click(function(){
		$('#btnNuevo').click();
		$('#swEstadoPqr').val(0);
		$('#divConsultarPqrs').html('');


		$('#btnPrimer').addClass('disabled');
	    $('#btnAnterior').addClass('disabled');
	    $('#btnSiguiente').addClass('disabled');
	    $('#btnUltimo').addClass('disabled');

	    $('#btnCancelar').addClass('disabled');
	    $('#btnConsulta').removeClass('disabled');
	});

});


function agregarTecnico(id,nom){

	$('#txtCot').val(id);
	$('#txtNomt').val(nom);
	$('#modalTecnicos').modal('hide');
}
function buscarTecnico(codTec){
	if(codTec!=''){
		$.ajax({
	        type:'POST',
	        url:'proc/ppqr_proc.php?accion=buscar_tecnico',
	        data:{ codTec:codTec},
	        success: function(data){
            	$('#txtCot').val(codTec);
            	$('#txtNomt').val(data);
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
		var msgError = 'Error! Porfavor coloque un tecnico valido';
		demo.showNotification('bottom','left', msgError, 4);
		$('#txtCot').val('');
	}
}
function buscarPqr(codPqr){
	if(codPqr!=''){
		$.ajax({
	        type:'POST',
	        url:'proc/ppqr_proc.php?accion=buscar_prq',
	        data:{codPqr:codPqr},
	        dataType: "json",
	        success: function(data){
	            $('#txtCod').val(data[0]);
	            $('#txtCodOrg').val(data[0]);
				$('#txtNom').val(data[1]);
				$('#txtDia').val(data[2]);

				if(data[3]=='S'){ $('#div_ckSac').html('<input type="checkbox" id="ckSac" checked>');
				}else{ $('#div_ckSac').html('<input type="checkbox" id="ckSac">'); }

				$('#txtPoi').val(data[4]);
				$('#txtCdc').val(data[5]);

				if(data[6]=='S'){ $('#div_ckLmp').html('<input type="checkbox" id="ckLmp" checked>');
				}else{ $('#div_ckLmp').html('<input type="checkbox" id="ckLmp">'); }

				if(data[7]=='S'){ $('#div_ckLpa').html('<input type="checkbox" id="ckLpa" checked>');
				}else{ $('#div_ckLpa').html('<input type="checkbox" id="ckLpa">'); }

				if(data[8]=='A'){ $('#div_ckAct').html('<input type="checkbox" id="ckAct" checked>');
				}else{ $('#div_ckAct').html('<input type="checkbox" id="ckAct">'); }
				
				if(data[9]!=0){
					$('#txtCot').val(data[9]);
					buscarTecnico(data[9]);
				}
				
				if(data[10]=='S'){ $('#div_ckAdd').html('<input type="checkbox" id="ckAdd" checked>');
				}else{ $('#div_ckAdd').html('<input type="checkbox" id="ckAdd">'); }

				if(data[11]=='S'){ $('#div_ckIup').html('<input type="checkbox" id="ckIup" checked>');
				}else{ $('#div_ckIup').html('<input type="checkbox" id="ckIup">'); }

				//data[12]
				$('#txtPri').val(data[13]);

				if(data[14]=='S'){ $('#div_ckLem').html('<input type="checkbox" id="ckLem" checked>');
				}else{ $('#div_ckLem').html('<input type="checkbox" id="ckLem">'); }

				$('#txtVtde').val(data[15]);
				$('#txtVtfu').val(data[16]);

	            // Tipo Editar
	            $('#swEstadoPqr').val(1);

	            $('#btnCancelar').removeClass('disabled');
	        }
	    });
	}else{
		var msgError = 'Error! Porfavor coloque un PQR valido';
		demo.showNotification('bottom','left', msgError, 4);
	}
}
function solonumeros(){
    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
        event.returnValue = false;
}
//Ver origen del editor
var varEditor = '';
function swEditor(trId){

	varEditor = trId;
}
function descargarEditor(){
	var dat = $('#txtCampEditor').val();
	$('#'+varEditor).val(dat);
	$('#editModal').modal('hide');
}

function pressEnter(campo){
	if(campo==='txtCot'){
		codTec = $('#txtCot').val();
		buscarTecnico(codTec);
	}
	if(campo==='txtCod'){
		codPqr = $('#txtCod').val();
		buscarPqr(codPqr);
	}
}