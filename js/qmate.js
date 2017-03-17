$(document).ready(function () {
	
    $('#btnConsulta').addClass('disabled');
    $('#btnEditor').addClass('disabled');

    $('#btnListaValores').click(function (){

    	if(modal==1){

    		$('#modalBodega').modal('show');
    	}else{
    		
    		$('#modalMaterial').modal('show');
    	}
    });

    $('#txtBodCod').click(function(){
		$('#txtBodNomb').val('');
		$('#txtMatCod').val('');
		$('#txtMatNomb').val('');
		$('#txtCantProp').val('');
		$('#txtValProp').val('');

		$('#txtCantSum').val('');
		$('#txtValSum').val('');
    });
    $("#txtBodCod").keypress(function(event){
		if(event.which == 13){
			cod = $.trim($('#txtBodCod').val());
			buscarBodega(cod);
		}
	});

    $('#txtMatCod').click(function(){
    	modal = 2;
		$('#txtMatNomb').val('');
		$('#txtCantProp').val('');
		$('#txtValProp').val('');

		$('#txtCantSum').val('');
		$('#txtValSum').val('');
    });
    $("#txtMatCod").keypress(function(event){
		if(event.which == 13){
			bod = $.trim($('#txtBodCod').val());
			mat = $.trim($('#txtMatCod').val());
			if(bod!=''){
				buscarMaterial(mat,bod);
			}else{
				demo.showNotification('bottom','left', 'Porfavor coloque una bodega valida', 4);
			}
		}
	});

});
var modal = 1;

//ADD
function addBodega(cod,nom){
	$('#txtBodCod').val(cod);
	$('#txtBodNomb').val(nom);
	$('#modalBodega').modal('hide');
}
function addMaterial(cod,nom,cant,val,cantSum,valSum){
	$('#txtMatCod').val(cod);
	$('#txtMatNomb').val(nom);
	$('#txtCantProp').val(number_format(cant,0));
	$('#txtValProp').val(number_format(val,0));

	$('#txtCantSum').val(number_format(cantSum,0));
	$('#txtValSum').val(number_format(valSum,0));

	actualizarSeriesMateriales(cod);
	$('#modalMaterial').modal('hide');
	$('#btnConsulta').removeClass('disabled');
}

//BUSCAR
function buscarBodega(bod){
	if(bod!=''){
		$.ajax({
	        type:'POST',
	        url:'proc/qmate_proc.php?accion=buscar_bodega_principal',
	        data:{ bod:bod },
	        success: function(data){
	        	$('#txtBodNomb').val(data);
				if(data!=''){
					$('#txtMatCod').focus();
				}
	        	actualizarMateriales(bod)
	        }
	    });
	}else{
		demo.showNotification('bottom','left', 'Porfavor coloque una bodega valida', 4);
	}
}
function buscarMaterial(mat,bod){
	if(mat!=''){
		$.ajax({
	        type:'POST',
	        url:'proc/qmate_proc.php?accion=buscar_material',
	        data:{ mat:mat, bod:bod },
	        dataType: 'json',
	        success: function(data){
	        	$('#txtMatNomb').val(data[0]);
	        	$('#txtCantProp').val(number_format(data[1],0));
	        	$('#txtValProp').val(number_format(data[2],0));
	        	$('#txtCantSum').val(number_format(data[3],0));
				$('#txtValSum').val(number_format(data[4],0));
				//actualizarSeriesMateriales(mat);
	        }
	    });
	}else{
		demo.showNotification('bottom','left', 'Porfavor coloque un material valida', 4);
	}
}

//ACTUALIZAR
function actualizarSeriesMateriales(mat){
	$.ajax({
        type:'POST',
        url:'proc/qmate_proc.php?accion=obtener_series_materiales',
        data:{ mat:mat },
        success: function(data){
        	$('#divModalMateriales').html(data);
        }
    });
}
function actualizarMateriales(bod){
	$.ajax({
        type:'POST',
        url:'proc/qmate_proc.php?accion=obtener_materiales',
        data:{bod:bod},
        success: function(data){
        	$('#divModalMateriales').html(data);
        }
    });
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