$(document).ready(function(){
	$('#txtEnCod').focus();
	$('#btnConsulta').addClass('disabled');
	
	$('#btnListaValores').click(function(){
		if(modal==1){ $('#modalBodega').modal('show');
		}else{ obtenerMateriales(); }
	});

	$('#txtEnCod').click(function(){
		modal = 1;
		$('#txtEnNomb').val('');
		$('#txtMatCod').val('');
		$('#txtMatNomb').val('');
		$('#tableMovimientosMaterial').html('');
	});
	$("#txtEnCod").keypress(function(event){
		if(event.which == 13){
			cod = $.trim($('#txtEnCod').val());
			buscarBodegaPrincipal(cod);
		}
	});

	$('#txtMatCod').click(function(){
		modal = 2;
		$('#txtMatNomb').val('');
		$('#tableMovimientosMaterial').html('');
	});
	$("#txtMatCod").keypress(function(event){
		if(event.which == 13){
			cod = $.trim($('#txtMatCod').val());
			buscarMaterial(cod);
		}
	});

	$("#txtAnio").keypress(function(event){
		if(event.which == 13){
			$('#txtMes').focus();
		}
	});

	$("#txtMes").keypress(function(event){
		if(event.which == 13){
			$('#selcTipo').focus();
		}
	});

	$("#selcTipo").keypress(function(event){
		if(event.which == 13){
			$('#btnConsultar_kardex').focus();
		}
	});

	$('#txtAnio').click(function(){
		$('#tableMovimientosMaterial').html('');
	});
	$('#txtMes').click(function(){
		$('#tableMovimientosMaterial').html('');
	});

});
var modal = 1;
//ADD
function addBodegaOrig(cod,bod){
	$('#txtEnCod').val(cod);
	$('#txtEnNomb').val(bod);
	$('#modalBodega').modal('hide');
}
function addMaterial(cod,mat){
	$('#txtMatCod').val(cod);
	$('#txtMatNomb').val(mat);
	$('#modalMaterial').modal('hide');
}

//BUSCAR
function buscarBodegaPrincipal(bod){
	if( (bod!='') ){
		$.ajax({
	        type:'POST',
	        url:'proc/kardex_proc.php?accion=buscar_bodega_principal',
	        data:{ bod:bod },
	        success: function(data){
	        	$('#txtEnNomb').val(data);
				data != '' ? $('#txtMatCod').focus(): demo.showNotification('bottom','left', 'La bodega no existe', 4);
	        }
	    });
	}else{
		demo.showNotification('bottom','left', 'Porfavor coloque una bodega valida', 4);
		$('#txtEnNomb').val('');
	}
}
function buscarMaterial(mat){
	bod = $('#txtEnCod').val();
	if( (mat!='') && (bod!='') ){
		$.ajax({
	        type:'POST',
	        url:'proc/kardex_proc.php?accion=buscar_material',
	        data:{ mat:mat, bod:bod },
	        dataType: 'json',
	        success: function(data){
	        	$('#txtMatCod').val(mat);
	        	$('#txtMatNomb').val(data[0]);
				data != '' ? $('#txtAnio').focus(): demo.showNotification('bottom','left', 'El material no existe', 4);
	        }
	    });
	}else{
		demo.showNotification('bottom','left', 'Porfavor coloque un material valida', 4);
	}
}
//OBTENER
function obtenerMateriales(){
	bod = $.trim($('#txtEnCod').val());
	nom = $.trim($('#txtEnNomb').val());
	if( (bod!='') && (nom!='') ){
		$.ajax({
	        type:'POST',
	        url:'proc/kardex_proc.php?accion=obtener_materiales',
	        data:{ bod:bod },
	        success: function(data){
	        	$('#divModalMateriales').html(data);
	        	$('#modalMaterial').modal('show');
	        }
	    });
	}else{
		demo.showNotification('bottom','left', 'Porfavor coloque una bodega valida', 4);
	}
}

//
function limpiar(){
	$('#txtEnCod').val('');
	$('#txtEnNomb').val('');
	$('#txtMatCod').val('');
	$('#txtMatNomb').val('');
	$('#txtAnio').val('');
	$('#txtMes').val('');
	$('#tableMovimientosMaterial').html('');
}
function consultar(){
	bodCod = $.trim($('#txtEnCod').val());
	bodNom = $.trim($('#txtEnNomb').val());
	matCod = $.trim($('#txtMatCod').val());
	matNom = $.trim($('#txtMatNomb').val());
	anio   = $.trim($('#txtAnio').val());
	mes    = $.trim($('#txtMes').val());
	tipo   = $('#selcTipo').val();

	if( (bodCod!='') && (bodNom!='') && (matCod!='') && (matNom!='') && 
			(anio!='') && (mes!='') ){
		$('#tableMovimientosMaterial').html('');
		//obtener cantidad inicial
			$.ajax({
				type:'POST',
				url:'proc/kardex_proc.php?accion=obtener_cant_val_inicial',
				data:{ bodCod:bodCod, matCod:matCod, anio:anio, mes:mes, tipo:tipo  },
				dataType: 'json',
				success: function(data){
					$('#txtCantInic').val(number_format(data[0],0));
					$('#txtValoInic').val(number_format(data[1],0));
					canIni = data[0];
					valIni = data[1];

					cantFinal  = 0;
					valorFinal = 0;
					//obtener detalle
						$.ajax({
							type:'POST',
							url:'proc/kardex_proc.php?accion=obtener_movimientos_detalle',
							data:{ bodCod:bodCod, matCod:matCod, anio:anio, mes:mes, tipo:tipo  },
							dataType: 'json',
							success: function(data){
								console.log(data)
								entraCant = data[0];
								salidCant = data[1];

								entraValor = data[2];
								salidValor = data[3];

								$('#txtEntrCant').val(number_format(entraCant,0));
								$('#txtSalidCant').val(number_format(salidCant,0));
								$('#txtEntrVal').val(number_format(entraValor,0));
								$('#txtSalidVal').val(number_format(salidValor,0));

								//cantidad final calculada
									cantFinal = (parseInt(canIni) + parseInt(entraCant)) - parseInt(salidCant);
									$('#txtCantFinCalc').val(number_format(cantFinal,0));

								//valor final calculado
									valorFinal = (parseInt(valIni) + parseInt(entraValor)) - parseInt(salidValor);
									$('#txtValFinCalc').val(number_format(valorFinal,0));
							}
						});
					//

					//obtener valor del sistema
						$.ajax({
							type:'POST',
							url:'proc/kardex_proc.php?accion=obtener_valor_sistema',
							data:{ bodCod:bodCod, matCod:matCod, anio:anio, mes:mes, tipo:tipo },
							dataType: 'json',
							success: function(data){
								cantsistema = parseInt(data[0]);
								valoSistema = parseInt(data[1]);

								$('#txtCantFinSist').val(number_format(cantsistema,0));
								$('#txtValoFinSist').val(number_format(valoSistema,0));

								//calcular diferencia
								//console.log("cantidad final: "+cantFinal)
								//console.log("valor final: "+valorFinal)
								difCant = cantFinal  - cantsistema;
								difValo = valorFinal - valoSistema;
								if( (difCant!=0) || (difValo!=0) ){
									$('#txtDifCantidad').removeClass('border-green');
									$('#txtDifValor').removeClass('border-green');

									$('#txtDifCantidad').addClass('border-red');
									$('#txtDifValor').addClass('border-red');
								}else{
									$('#txtDifCantidad').removeClass('border-red');
									$('#txtDifValor').removeClass('border-red');

									$('#txtDifCantidad').addClass('border-green');
									$('#txtDifValor').addClass('border-green');
								}
								$('#txtDifCantidad').val(number_format(difCant,0));
								$('#txtDifValor').val(number_format(difValo,0));

							}
						});
					//

					//obtener movimientos
						$.ajax({
							type:'POST',
							url:'proc/kardex_proc.php?accion=obtener_movimientos',
							data:{ bodCod:bodCod, matCod:matCod, anio:anio, mes:mes, tipo:tipo, canIni:canIni, valIni:valIni  },
							success: function(data){
								$('#tableMovimientosMaterial').html(data);
							}
						});
					//
				}
			});
		//
	}else{
		demo.showNotification('bottom','left', 'Por favorcomplete los datos', 4);
	}
}
function enviarMovimiento(documento,tipo){
	if(tipo=='A'){//almacen
		$('#txtDocumentoMovimiento').val(documento);
		$('#formDetalleMovimientoPost').submit();
	}else{//legalizacion

	}
}

//OTROS
function solonumeros(){
    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
        event.returnValue = false;
}
function number_format(amount,decimals){

    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

    decimals = decimals || 0; // por si la variable no fue fue pasada

    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0) 
        return parseFloat(0).toFixed(decimals);

    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);

    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;

    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + '.' + '$2');

    return amount_parts.join('.');
}
function trSelect(trId){
	$('.trDefault').removeClass('trSelect');
	$('#'+trId).addClass('trSelect');
}