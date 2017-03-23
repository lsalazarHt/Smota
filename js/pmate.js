$(document).ready(function () {
	
	actualizar();
    $('#btnNuevo').removeClass('disabled');
	$('#btnGuardar').removeClass('disabled');
	$('#btnListaValores').addClass('disabled');
	$('#btnConsulta').addClass('disabled');

	//Agregar campos
	$('#btnNuevo').click(function(){

		//Agregar una nueva fila a la tabla
		var table = document.getElementById('table');
	    var rowCount = table.rows.length;
	    var row = table.insertRow(rowCount);
	    row.className = 'trDefault';
		row.id = 'trSelect'+rowCount;
	    
	    //Codigo
	    var cell1 = row.insertCell(0);
	    cell1.className = 'text-center';
	    cell1.innerHTML = '<input type="text" id="txtCod'+rowCount+'" class="form-control input-sm text-center" onkeypress="solonumeros()" onclick="swEditor(\'txtCod'+rowCount+'\',\'trSelect'+rowCount+'\')"><input type="hidden" id="txtTipo'+rowCount+'" value="0">';
	    //Valor Numerico
	    var cell2 = row.insertCell(1);
	    cell2.className = '';
	    cell2.innerHTML = '<input type="text" id="txtNomb'+rowCount+'" class="form-control input-sm" onclick="swEditor(\'txtNomb'+rowCount+'\',\'trSelect'+rowCount+'\')">';
	    //Clase
	    var cell3 = row.insertCell(2);
	    cell3.className = 'text-center';
	    cell3.innerHTML = '<input type="text" id="txtClase'+rowCount+'" class="form-control input-sm text-center" onkeypress="solonumerosEnter('+rowCount+')" onclick="swEditorM(\'\',\'trSelect'+rowCount+'\',1,'+rowCount+')">';
	    
	    //Und Medida
	    var cell4 = row.insertCell(3);
	    cell4.className = 'text-center';
	    cell4.innerHTML = '<input type="text" id="txtUndMed'+rowCount+'" class="form-control input-sm" onclick="swEditor(\'txtUndMed'+rowCount+'\',\'trSelect'+rowCount+'\')">';
	    
	    //Clase Nombre
	    var cell5 = row.insertCell(4);
	    cell5.className = 'text-center';
	    cell5.innerHTML = '<input type="text" id="txtClaseNomb'+rowCount+'" class="form-control input-sm" onclick="swEditor(\'\',\'trSelect'+rowCount+'\')" readonly>';
	    
	    //Visible
	    var cell6 = row.insertCell(5);
	    cell6.className = 'text-center ';
	    cell6.innerHTML = '<input type="checkbox" id="txtCkek'+rowCount+'" checked="checked" onclick="swEditor(\'\',\'trSelect'+rowCount+'\')" > Activo';
	    //Maneja Serial
	    var cell7 = row.insertCell(6);
	    cell7.className = 'text-center ';
	    cell7.innerHTML = '<input type="checkbox" id="txtManSerial'+rowCount+'" onclick="swEditor(\'\',\'trSelect'+rowCount+'\')" > Maneja Serial';

	    //Vida Util
	    var cell4 = row.insertCell(7);
	    cell4.className = 'text-center';
	    cell4.innerHTML = '<input type="text" id="txtVidaUtil'+rowCount+'" class="form-control input-sm" onclick="swEditor(\'txtVidaUtil'+rowCount+'\',\'trSelect'+rowCount+'\')" readonly>';
	    
	    //Cantidad Maxima de Dotacion
	    var cell4 = row.insertCell(8);
	    cell4.className = 'text-center';
	    cell4.innerHTML = '<input type="text" id="txtCantMax'+rowCount+'" class="form-control input-sm" onclick="swEditor(\'txtCantMax'+rowCount+'\',\'trSelect'+rowCount+'\')" readonly>';
	    
	    $('#contRow').val(rowCount);
	    $('#txtCod'+rowCount).focus();
	    selectedNewRow(row.id);
	});

	//Btn Guardar
	$('#btnGuardar').click(function(){
		var cont = $('#contRow').val();

		// VALIDAR SI CUMPLE CON LOS CAMPOS OBLIGATORIOS DE <VIDA UTIL>, <CANTIDAD MAXIMA DE DOTACION>
		var noCumple = 0;
		var msgError = '';
		for(var i=1;i<=cont;i++){
			var cls = $.trim($('#txtClase'+i).val());			
			var vdUtl = $.trim($('#txtVidaUtil'+i).val());
			var cnMxDt = $.trim($('#txtCantMax'+i).val());

			if( parseInt(cls)===5 || parseInt(cls)===6 ){		
				if(parseInt(vdUtl)===0 || parseInt(cnMxDt)===0){
					msgError = 'VIDA UTIL y CANTIDAD MAXIMA DE DOTACIÓN no permite valores CERO';
					noCumple = 1;
				}	
				if(vdUtl ==='' || cnMxDt===''){
					msgError = 'VIDA UTIL y CANTIDAD MAXIMA DE DOTACIÓN no permite valores NULOS';
					noCumple = 1;
				}	
					
				console.log('no cumple');
			}

		} //END FOR

		/*
		BACKGROUND-COLOR ALERTAS
			AZUL = 1
			VERDE = 2
			NARANJA = 3
			ROJO = 4
		*/
		if(noCumple===1){
			demo.showNotification('bottom','left', msgError, 4);
			// alert(msgError);				
		}else{

			for(var i=1;i<=cont;i++){
				var codOrg = $.trim($('#txtCodOrg'+i).val());
				var cod = $.trim($('#txtCod'+i).val());
				var nom = $.trim($('#txtNomb'+i).val());
				var cls = $.trim($('#txtClase'+i).val());
				var uMed = $.trim($('#txtUndMed'+i).val());
				var vdUtl = $.trim($('#txtVidaUtil'+i).val());
				var cnMxDt = $.trim($('#txtCantMax'+i).val());

				if($("#txtCkek"+i).is(':checked')) { chek = 'A'; }
				else{ chek = 'N'; }

				if($("#txtManSerial"+i).is(':checked')) { mSerial = 'A'; }
				else{ mSerial = 'N'; }

					if( $('#txtTipo'+i).val() == 1){ //Editar
						$.ajax({
					        type:'POST',
					        url:'proc/pmate_proc.php?accion=editar_registros',
					        data:{codOrg:codOrg, cod:cod, nom:nom, cls:cls, uMed:uMed, chek:chek, mSerial:mSerial, vdUtl:vdUtl, cnMxDt:cnMxDt },
					        success: function(data){
					            if(data==1){
				                    actualizar();
					            }else{ alert(data+' Editar!') }
					        }
					    });
					}else{ // Nuevo
						if( (cod!='') && (nom!='') && (cls!='') ){
							$.ajax({
						        type:'POST',
						        url:'proc/pmate_proc.php?accion=guardar_registros',
						        data:{cod:cod, nom:nom, cls:cls, uMed:uMed, chek:chek, mSerial:mSerial, vdUtl:vdUtl, cnMxDt:cnMxDt },
						        success: function(data){
						            if(data==1){
					                    actualizar();
						            }else{ alert(data+' Agregar!') }
						        }
						    });
						}
					}
			} //END FOR
		} //END IF
	});

	//Btn Lista Valores
	$('#btnListaValores').click(function(){

		$('#modalClases').modal('show');
	});

	//Btn Editor
	$('#btnEditor').click(function(){
		var dat = $('#'+varEditor).val();
		$('#txtCampEditor').val(dat);
		$('#editModal').modal('show');
	});

});

function actualizar(){
	$('#table').html('');
	$.ajax({
        type:'POST',
        url:'proc/pmate_proc.php?accion=actualizar_registros',
        data:{cod:'1'},
        success: function(data){
            $('#table').html(data);
            $('#btnListaValores').addClass('disabled');
        }
    });
}

var idGlb = 0;
function colocarClase(id,nom){
	$('#txtClase'+idGlb).val(id);
	$('#txtClaseNomb'+idGlb).val(nom);
	$('#modalClases').modal('hide');
	if(parseInt(id)===5 || parseInt(id)===6){
		$('#txtVidaUtil'+idGlb).removeAttr('readonly');
		$('#txtCantMax'+idGlb).removeAttr('readonly');
		console.log('cumple bien');
	}else{
		$('#txtVidaUtil'+idGlb).attr('readonly', true);
		$('#txtCantMax'+idGlb).attr('readonly', true);
		console.log('no cumple');
	}
}
function solonumeros(){
    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
        event.returnValue = false;
}
function solonumerosEnter(id){
	if(event.which == 13){
		validarClase(id);
	}else{
	    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
	        event.returnValue = false;
	}
}
function validarClase(id){
	$('#txtClaseNomb'+id).val('');
	cod = $('#txtClase'+id).val();
	$.ajax({
        type:'POST',
        url:'proc/pmate_proc.php?accion=validar_clase',
        data:{cod:cod},
        dataType: "json",
        success: function(data){
        	if(data[0]!=0){
        		$('#txtClaseNomb'+id).val(data[1]);
        	}else{
        		var msgError = 'Error! La Clase no es valid';
				demo.showNotification('bottom','left', msgError, 4);
        		$('#txtClase'+id).val('');
        	}
        }
    });
}

//Ver origen del editor
var varEditor = '';
function swEditor(id,trId){

	varEditor = id;
	$('.trDefault').removeClass('trSelect');
	$('#'+trId).addClass('trSelect');
}
function swEditorM(id,trId,mdSec,i){

	varEditor = id;
	$('.trDefault').removeClass('trSelect');
	$('#'+trId).addClass('trSelect');

	if(mdSec==1){
		modal = 3;
	}
	idGlb = i;

	$('#btnListaValores').removeClass('disabled');
}
function descargarEditor(){
	var dat = $('#txtCampEditor').val();
	$('#'+varEditor).val(dat);
	$('#editModal').modal('hide');
}
