$(document).ready(function () {
	
	$('#btnNuevo').removeClass('disabled');
	$('#btnGuardar').removeClass('disabled');
	$('#btnListaValores').addClass('disabled');
	$('#btnConsulta').addClass('disabled');
	actualizar();

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
	    cell1.innerHTML = '<input type="text" id="txtCod'+rowCount+'" class="form-control input-sm" onclick="swEditor(\'txtCod'+rowCount+'\',\'trSelect'+rowCount+'\')"><input type="hidden" id="txtTipo'+rowCount+'" value="0">';
	    //Valor Numerico
	    var cell2 = row.insertCell(1);
	    cell2.className = '';
	    cell2.innerHTML = '<input type="text" id="txtValorNum'+rowCount+'" class="form-control input-sm" onkeypress="solonumeros()" onclick="swEditor(\'txtValorNum'+rowCount+'\',\'trSelect'+rowCount+'\')">';
	    //Valor Caracter
	    var cell1 = row.insertCell(2);
	    cell1.className = 'text-center';
	    cell1.innerHTML = '<input type="text" id="txtValorCar'+rowCount+'" class="form-control input-sm" onclick="swEditor(\'txtValorCar'+rowCount+'\',\'trSelect'+rowCount+'\')">';
	    //Observacion
	    var cell2 = row.insertCell(3);
	    cell2.className = '';
	    cell2.innerHTML = '<input type="text" id="txtObserv'+rowCount+'" class="form-control input-sm" onclick="swEditor(\'txtObserv'+rowCount+'\',\'trSelect'+rowCount+'\')">';
	    //Accion
	    var cell3 = row.insertCell(4);
	    cell3.className = 'text-center ';
	    cell3.innerHTML = '<input type="checkbox" id="txtCkek'+rowCount+'" checked="checked" onclick="swEditor(\'\',\'trSelect'+rowCount+'\')" >';

	    $('#contRow').val(rowCount);
	});
	//Guardar
	$('#btnGuardar').click(function(){
		var cont = $('#contRow').val();

		for(var i=1;i<=cont;i++){
			var cod = $.trim($('#txtCod'+i).val());
			var vNum = $('#txtValorNum'+i).val();
			var vAlf = $('#txtValorCar'+i).val();
			var obs = $.trim($('#txtObserv'+i).val());
			if($("#txtCkek"+i).is(':checked')) { chek = 1; }
			else{ chek = 0; }

			if( $('#txtTipo'+i).val() == 1){ //Editar
				var codOrg = $.trim($('#txtCodOrg'+i).val());
				$.ajax({
			        type:'POST',
			        url:'proc/pconf_proc.php?accion=editar_registros',
			        data:{ codOrg:codOrg, cod:cod, vNum:vNum, vAlf:vAlf, obs:obs, chek:chek},
			        success: function(data){
			            console.log(data)
			            if(data==1){
		                    actualizar();
			            }else{ alert(data+' Editar!') }
			        }
			    });
			}else{
				if(cod!=''){
					$.ajax({
				        type:'POST',
				        url:'proc/pconf_proc.php?accion=guardar_registros',
				        data:{cod:cod, vNum:vNum, vAlf:vAlf , obs:obs},
				        success: function(data){
				            if(data==1){
			                    actualizar();
				            }else{ alert(data+' Agregar!') }
				        }
				    });
				}
			}

		}
	});
	//Editor
	$('#btnEditor').click(function(){
		var dat = $('#'+varEditor).val();
		$('#txtCampEditor').val(dat);
		$('#editModal').modal('show');
	});

	

});
function datosContratista(){
	$.ajax({
        type:'POST',
        url:'proc/pconf_proc.php?accion=buscar_contratista',
        data:{id:'1'},
        success: function(data){
        	$('#txtNombre').val(data);
			$('#modalDatosContratista').modal('show');
        }
    });
}
function guardarDatosContratista(){
	nom = $('#txtNombre').val();
	if(nom!=''){
		$.ajax({
	        type:'POST',
	        url:'proc/pconf_proc.php?accion=guardar_contratista',
	        data:{nom:nom},
	        success: function(data){
	        	if(data==1){
		        	alert('Se guardo la informacion correctamente')
					$('#modalDatosContratista').modal('hide');
	        	}else{ alert(data) }
	        }
	    });
	}else{ alert('Porfavor complete los datos') }
}
function actualizar(){
	$('#table').html('');
	$.ajax({
        type:'POST',
        url:'proc/pconf_proc.php?accion=actualizar_parametros',
        data:{codDep:'1'},
        success: function(data){
            $('#table').html(data);
        }
    });
}
function solonumeros(){
    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
        event.returnValue = false;
}

//Ver origen del editor
var varEditor = '';
function swEditor(id,trId){

	varEditor = id;
	$('.trDefault').removeClass('trSelect');
	$('#'+trId).addClass('trSelect');
}
function descargarEditor(){
	var dat = $('#txtCampEditor').val();
	$('#'+varEditor).val(dat);
	$('#editModal').modal('hide');
}
