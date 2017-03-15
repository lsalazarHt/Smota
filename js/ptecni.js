$(document).ready(function () {
	$('#btnNuevo').removeClass('disabled');
	$('#btnGuardar').removeClass('disabled');
	$('#btnListaValores').addClass('disabled');
	$('#btnConsulta').removeClass('disabled');
	$('#btnEditor').addClass('disabled');
	
	$("#txtCod").keypress(function(event){
		if(event.which == 13){
			codTec = $('#txtCod').val();
			buscarTecnico(codTec);
		}
	});

	$("#btnCancelar").click(function(){

		limpiar();
		$('#btnConsulta').removeClass('disabled');
        $('#btnCancelar').addClass('disabled');
        $('#btnNuevo').removeClass('disabled');
        $('#divConsultarTecnicos').html('');

        $('#btnPrimer').addClass('disabled');
	    $('#btnAnterior').addClass('disabled');
	    $('#btnSiguiente').addClass('disabled');
	    $('#btnUltimo').addClass('disabled');
	});

	$("#btnNuevo").click(function(){

		limpiar();
		$('#btnConsulta').addClass('disabled');
        $('#btnCancelar').removeClass('disabled');

        $('#btnPrimer').addClass('disabled');
	    $('#btnAnterior').addClass('disabled');
	    $('#btnSiguiente').addClass('disabled');
	    $('#btnUltimo').addClass('disabled');
	});

	$('#btnListaValores').click(function(){
		if(modal==1){
			$('#modalClaseTecnicos').modal('show');
		}
	});

	$("#txtClaseCod").click(function(){

		$('#btnListaValores').removeClass('disabled');
	});

	$("#txtClaseCod").keypress(function(event){
		if(event.which == 13){
			cod = $('#txtClaseCod').val();
			buscarClase(cod);
		}
	});

	$('#btnGuardar').click(function(){
		tipo = $('#swEstadoTecnico').val();

		cod = $.trim($('#txtCod').val());
		nom = $.trim($('#txtNom').val());
		clas = $.trim($('#txtClaseCod').val());
		clasNomb = $.trim($('#txtClaseNomb').val());
		
		fIng = $.trim($('#txtFechaIng').val());
		fRet = $.trim($('#txtFechaRet').val());
		bod = $.trim($('#txtCodBodega').val());
		bodVdd = $.trim($('#txtCodBodegaVdd').val());
		salar = $.trim($('#txtSalario').val());
		
		//Checkbox
			if($("#ckAct").is(':checked')) { act = 'A'; }
			else{ act = 'N'; }

			//if($("#ckLmp").is(':checked')) { lMatPro = 'S'; }
			//else{ lMatPro = 'N'; }

			if($("#ckInv").is(':checked')) { devPr = 'S'; }
			else{ devPr = 'N'; bod=''; }

		//End Checkbox

		if( (cod!='') && (nom!='') && (clas!='') && (clasNomb!='') ){
			if( (clas!='') && (clasNomb=='') ){
				alert('Error! Porfavor coloque una clase valido')
				return false;
			}

			if(tipo==0){ //Nuevo
				$.ajax({
			        type:'POST',
			        url:'proc/ptecni_proc.php?accion=guardar_registros',
			        data:{cod:cod, nom:nom, clas:clas, fIng:fIng, fRet:fRet, bod:bod, salar:salar, 
			        	  act:act, devPr:devPr},
			        success: function(data){
			        	//console.log(data)
			            if(data==1){
		                    $('#btnCancelar').click();
		                    alert('El Tecnico se agrego con exito')
			            }else{ alert(data+' Agregar!') }
			        }
			    });
			}else{ //Editar
				codOrg = $.trim($('#txtCodOrg').val());
				$.ajax({
			        type:'POST',
			        url:'proc/ptecni_proc.php?accion=editar_registros',
			        data:{codOrg:codOrg,cod:cod, nom:nom, clas:clas, fIng:fIng, fRet:fRet, bod:bod, 
			        	  salar:salar,act:act, devPr:devPr},
			        success: function(data){
			            if(data==1){
		                    $('#btnCancelar').click();
		                    alert('El Tecnico se edito con exito')
			            }else{ alert(data+' Editar!') }
			        }
			    });
			}
		}else{
			alert('Error! Porfavor complete los datos')
		}
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

var modal = 1;
function buscarClase(cod){
	$.ajax({
        type:'POST',
        url:'proc/ptecni_proc.php?accion=buscar_clase',
        data:{cod:cod},
        success: function(data){
        	$('#txtClaseNomb').val(data);
        }
    });
}
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
        			$('#div_ckAct').html('<input type="checkbox" id="ckAct" checked>');
        		}else{
        			$('#div_ckAct').html('<input type="checkbox" id="ckAct">');
        		}

        		$('#txtFechaIng').val(data[5]);
        		$('#txtFechaRet').val(data[6]);
        		$('#txtCodBodega').val(data[8]);
        		
        		if(data[8]!=''){
        			$('#div_ckInv').html('<input type="checkbox" id="ckInv" checked onclick="swManejaBodega()">');
        			$('#divSwCodigoBodegaLabel').removeClass('display-none');
					$('#divSwCodigoBodegaInput').removeClass('display-none');
        		}else{
        			$('#div_ckInv').html('<input type="checkbox" id="ckInv" onclick="swManejaBodega()">');
        			$('#divSwCodigoBodegaLabel').addClass('display-none');
					$('#divSwCodigoBodegaInput').addClass('display-none');
        		}
        		$('#txtSalario').val(data[9]);

        		//devega
        		if(data[10]=='S'){
        			$('#div_ckDevProd').html('<input type="checkbox" id="ckDevProd" checked>');
        		}else{
        			$('#div_ckDevProd').html('<input type="checkbox" id="ckDevProd">');
        		}
        		$('#swEstadoTecnico').val(1);

        		$('#btnConsulta').addClass('disabled');
        		$('#btnCancelar').removeClass('disabled');
        	}else{
				limpiar();
        		alert('Error! El Tecnico no existe')
        	}
        }
    });
}
function swManejaBodega(){
	//sw = false;
	if($("#ckInv").is(':checked')) { sw = true; }
	else{ sw = false; }

	if(sw){
		$('#divSwCodigoBodegaLabel').removeClass('display-none');
		$('#divSwCodigoBodegaInput').removeClass('display-none');
	}else{
		$('#divSwCodigoBodegaLabel').addClass('display-none');
		$('#divSwCodigoBodegaInput').addClass('display-none');
	}
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
function agregarClasesTecnico(cod,nom){
	$('#txtClaseCod').val(cod);
	$('#txtClaseNomb').val(nom);
	$('#modalClaseTecnicos').modal('hide');
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