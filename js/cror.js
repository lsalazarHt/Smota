$(document).ready(function(){

	$('#btnGuardar').removeClass('disabled');
	$('#btnNuevo').removeClass('disabled');
	$('#btnConsulta').addClass('disabled');

	$('.tableJs').DataTable({
	    //ajax : 'assets/inc/clss/tbl/tabla-apuestas-adm-apuesta.php?camp=0',
	    "iDisplayLength": 10,
	    "lengthMenu": [
	        [10, 20, 30, -1],
	        [10, 20, 30, "Todos"] // change per page values here 
	    ],
	    initComplete: function(oSettings, json) {
	        //$('.tooltips').tooltip();
	    },
	    pageLength: 10,
	    "language": {
	        "sProcessing":     "Procesando...",
	        "sLengthMenu":     "Mostrar _MENU_ Registros",
	        "sZeroRecords":    "No se encontraron resultados",
	        "sEmptyTable":     "No hay Datos registradas en el sistema",
	        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
	        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
	        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
	        "sInfoPostFix":    "",
	        "sSearch":         "",
	        "sUrl":            "",
	        "sInfoThousands":  ",",
	        "sLoadingRecords": "Cargando Datos...",
	        "oPaginate": {
	            "sFirst":    "Primero",
	            "sLast":     "Último",
	            "sNext":     "Siguiente",
	            "sPrevious": "Anterior"
	        },
	        "oAria": {
	            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
	            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
	        }
	      },
	    "searching": true,
	    "ordering": false,
	    "info": false,
	    "autoWidth": false,
	    "columns": [
	        { "class": "text-center cod","width":"10%"},
	        { "class": "text-left","width":"30px"}
	    ]
	});

	$('#addManoObra').click(function(){

		//Agregar una nueva fila a la tabla
		var table = document.getElementById('tableManoObra');
	    var rowCount = table.rows.length;
	    var row = table.insertRow(rowCount);
	    row.className = 'trDefault';
	    row.id = 'trSelect'+rowCount;

	    var cell1 = row.insertCell(0);
	    cell1.className = 'text-center';
	    cod = '<input type="text" id="txtCodMan'+rowCount+'" class="form-control input-sm text-center" onkeypress="solonumerosEnterMano('+rowCount+')" onclick="swEditor(\'txtCodMan'+rowCount+'\',\'trSelect'+rowCount+'\',5,'+rowCount+')">';
	    codH = '<input type="hidden" id="txtTipoMan'+rowCount+'" value="0">';
	    cell1.innerHTML = cod+codH;

	    var cell1 = row.insertCell(1);
	    cell1.className = 'text-center';
	    nom = '<input readonly type="text" id="txtNombMan'+rowCount+'" class="form-control input-sm" onclick="swEditor(\'txtNombMan'+rowCount+'\',\'trSelect'+rowCount+'\',5,'+rowCount+')">';
	    cell1.innerHTML = nom;
	    
	    var cell2 = row.insertCell(2);
	    cell2.className = '';
	    a = '<input id="txtCantMan'+rowCount+'" type="text" class="form-control input-sm text-right" onkeypress="solonumerosEnterCalMano('+rowCount+')" onclick="swEditor(\'txtCantMan'+rowCount+'\',\'trSelect'+rowCount+'\',5,'+rowCount+')">';
	    b = '<input id="txtCantManMAx'+rowCount+'" type="hidden" class="form-control input-sm" readonly>';
	    cell2.innerHTML = a+b;
	    
	    var cell3 = row.insertCell(3);
	    cell3.className = 'text-center';
	    a = '<input id="txtValMan'+rowCount+'" type="hidden" readonly>';
	    b = '<input id="txtValManTotal'+rowCount+'" type="text" class="form-control input-sm text-right" onkeypress="solonumeros()" onclick="swEditor(\'txtValMan'+rowCount+'\',\'trSelect'+rowCount+'\',5,'+rowCount+')" readonly>';
	    cell3.innerHTML = a+b;

	    $('#contRowMano').val(rowCount);
	});

	$('#addMateriales').click(function(){

		//Agregar una nueva fila a la tabla
		var table = document.getElementById('tableMateriales');
	    var rowCount = table.rows.length;
	    var row = table.insertRow(rowCount);
	    row.className = 'trDefaultMat';
	    row.id = 'trSelectMat'+rowCount;

	    var cell1 = row.insertCell(0);
	    cell1.className = 'text-center';
	    cod = '<input type="text" id="txtCodMat'+rowCount+'" class="form-control input-sm text-center" onkeypress="solonumerosEnterMat('+rowCount+')" onclick="swEditorMat(\'txtCodMat'+rowCount+'\',\'trSelectMat'+rowCount+'\',6,'+rowCount+')">';
	    codH = '<input type="hidden" id="txtTipoMat'+rowCount+'" value="0">';
	    cell1.innerHTML = cod+codH;

	    var cell1 = row.insertCell(1);
	    cell1.className = 'text-center';
	    nom = '<input readonly type="text" id="txtNombMat'+rowCount+'" class="form-control input-sm" onclick="swEditorMat(\'txtNombMat'+rowCount+'\',\'trSelectMat'+rowCount+'\',6,'+rowCount+')">';
	    cell1.innerHTML = nom;
	    
	    
	    var cell2 = row.insertCell(2);
	    cell2.className = '';
	    a = '<input id="txtCantMat'+rowCount+'" type="text" class="form-control input-sm text-right" onkeypress="colocarMateCant('+rowCount+')" onclick="swEditorMat(\'txtCantMat'+rowCount+'\',\'trSelectMat'+rowCount+'\',6,'+rowCount+')">';
	    b = '<input id="txtCantMatMax'+rowCount+'" type="hidden" >';
	    c = '<input id="txtCantMatFija'+rowCount+'" type="hidden" >';
	    cell2.innerHTML = a+b+c;

	    var cell3 = row.insertCell(3);
	    cell3.className = 'text-center ';
	    a = '<input id="txtValMat'+rowCount+'" type="text" class="form-control input-sm text-right" onkeypress="solonumeros()" onclick="swEditorMat(\'txtValMat'+rowCount+'\',\'trSelectMat'+rowCount+'\',6,'+rowCount+')">';
	    b = '<input id="txtValMatMax'+rowCount+'" type="hidden" >';
	    c = '<input id="txtCantMatInv'+rowCount+'" type="hidden" >';
	    cell3.innerHTML = a+b+c; 

	    $('#contRowMate').val(rowCount);
	});

	$('#btnListaValores').click(function(){
		if(modal==1){
			$('#modalCuadrillas').modal('show');
		}else if(modal==2){
			$('#modalTecnicos').modal('show');
		}else if(modal==3){
			$('#modalUsuarios').modal('show');
		}else if(modal==4){ //Validar pqr x tecnico
			tec = $.trim($('#txtCodiTecn').val());
			if(tec!=''){
				actualizarPqr(tec);
			}else{ alert('Porfavor coloque un tecnico valido') }
		}else if(modal==5){ //Validar mano de obra x tecnico y pqr
			pqr = $.trim($('#txtCodTrab').val());
			if(pqr!=''){
				actualizarManoObra(pqr);
			}else{ alert('Porfavor coloque una pqr valido') }
		}else if(modal==6){
			pqr = $.trim($('#txtCodTrab').val());
			if(pqr!=''){
				actualizarMateriales(pqr);
			}else{ alert('Porfavor coloque una pqr valido') }
			$('#modalMaterial').modal('show');
		}
	});

	$('#txtCodiTecn').click(function(){
		
		$('#txtNombTecn').val('');
		$('#txtCodTrab').val('');
		$('#txtNomTrab').val('');
	});

	$('#txtCodiUsua').click(function(){
		
		$('#txtNombUsua').val('');
	});

	$('#txtCodTrab').click(function(){
		
		$('#txtNomTrab').val('');
	});

	$('#btnEditor').click(function(){
		var text = $('#'+ediText).val();
		$('#txtCampEditor').val(text);
		$('#editModal').modal('show');
	});

	$('#btnNuevo').click(function(){
		//Orden Padre
		$('#txtDepPadre').val('');
		$('#txtLocaPadre').val('');
		$('#txtNumbPadre').val('');
		var ordTip = $('input[name="radioOrden"]:checked').val();
		if(ordTip=='p'){
			$('#selectOrdHija').click();
			$('#txtDepPadre').prop('readonly','');
			$('#txtLocaPadre').prop('readonly','');
			$('#txtNumbPadre').prop('readonly','');
		}
		$('#txtDepOrd').val('');
		$('#txtLocaOrd').val('');
		$('#txtNumbOrd').val('');
		$('#txtFechOrd').val('');
		$('#txtCodiCuad').val('');
		$('#txtNombCuad').val('');
		$('#txtCodiTecn').val('');
		$('#txtNombTecn').val('');
		$('#txtCodiUsua').val('');
		$('#txtNombUsua').val('');
		$('#divCheck').html('<input id="txtCumpOrd" type="checkbox" style="margin-top: 10px;">');
		$('#txtDireUsua').val('');
		$('#txtCodTrab').val('');
		$('#txtNomTrab').val('');
		$('#txtHoraInicio').val('');
		$('#txtHoraFinal').val('');
		$('#txtObservacion').val('');
		limpiarTablaManoObra();
		limparTablaMateriales();
	});

	$('#btnGuardar').click(function(){

		var ordTip = $('input[name="radioOrden"]:checked').val();
		var dPadre = $('#txtDepPadre').val();
		var lPadre = $('#txtLocaPadre').val();
		var nPadre = $('#txtNumbPadre').val();

		var dOrd = $('#txtDepOrd').val();
		var lOrd = $('#txtLocaOrd').val();
		var nOrd = $('#txtNumbOrd').val();
		var fecOrd = $('#txtFechOrd').val();

		var codCua = $('#txtCodiCuad').val();
		var nomCua = $('#txtNombCuad').val();

		var codTec = $('#txtCodiTecn').val();
		var nomTec = $('#txtNombTecn').val();

		var codUsu = $('#txtCodiUsua').val();
		var nomUsu = $('#txtNombUsua').val();
		
		//if($("#txtCumpOrd").is(':checked')) { estad = 3; }
		//else{ estad = 1; }
		estad = 3;
		//var dirUsu = $('#txtDireUsua').val();

		var codTra = $('#txtCodTrab').val();
		var nomTra = $('#txtNomTrab').val();

		var horIni = $('#txtHoraInicio').val();
		var horFin = $('#txtHoraFinal').val();
		var obsOrd = $('#txtObservacion').val();

		if(ordTip=='h'){
			if( (dPadre=='') || (lPadre=='') || (nPadre=='') ){
				return false;
				alert('Error! Porfavor complete los datos del la orden padre')
			}
		}

		if( (dOrd!='') && (lOrd!='') && (nOrd!='') && (fecOrd!='') && (codCua!='') && (nomCua!='') &&
			(codUsu!='') && (nomUsu!='') && (codTec!='') && (nomTec!='') &&
			(codTra!='') && (nomTra!='') && (horIni!='') && (horFin!='') ){

			//
			$.ajax({
		        type:'POST',
		        url:'proc/cror_proc.php?accion=guardar_ot',
		        data:{ordTip:ordTip, dPadre:dPadre, lPadre:lPadre, nPadre:nPadre, dOrd:dOrd,
		        	  lOrd:lOrd, nOrd:nOrd, fecOrd:fecOrd, codCua:codCua, 
		        	  codTec:codTec, codUsu:codUsu, estad:estad, codTra:codTra, horIni:horIni,
		        	  horFin:horFin, obsOrd:obsOrd},
		        success: function(data){
		        	if(data==1){
			            //Guardar Mano de Obra
						var contMan = $('#contRowMano').val();
						for(var i=1;i<=contMan;i++){
							cod = $('#txtCodMan'+i).val();
							can = $('#txtCantMan'+i).val();
							val = $('#txtValManTotal'+i).val();
							if( (cod!='') && (can!=0) && (val!=0) ){
								$.ajax({
									type:'POST',
							        url:'proc/cror_proc.php?accion=guardar_mo_ot',
							        data:{ cod:cod, dOrd:dOrd, lOrd:lOrd, nOrd:nOrd, can:can, val:val, codTec:codTec},
							        success: function(data){
							        	console.log(data+' MO')
							        }
							    });
							}
						}
			            //Guardar Materiales
			            var contMat = $('#contRowMate').val();
						for(var i=1;i<=contMat;i++){
							cod = $('#txtCodMat'+i).val();
							can = $('#txtCantMat'+i).val();
							val = $('#txtValMat'+i).val();
							cantInv = $('#txtCantMatInv'+i).val();
							if(cod!=''){
								$.ajax({
									type:'POST',
							        url:'proc/cror_proc.php?accion=guardar_ma_ot',
							        data:{ cod:cod, dOrd:dOrd, lOrd:lOrd, nOrd:nOrd, can:can, val:val, codTec:codTec, cantInv:cantInv},
							        success: function(data){
							        	console.log(data+' MA')
							        }
							    });
							}
						}
						alert('La orden se guardo con Exito!')
						$('#btnNuevo').click();
		        	}else{
		        		alert('Se presento un error al guardar la orden de trabajo')
		        	}
		        }
		    });
		}else{
			alert('Error! Porfavor complete los datos')
		}
	});

	$("#txtCodiCuad").keypress(function(event){
		if(event.which == 13){
			cod = $.trim($('#txtCodiCuad').val());
			buscarCuadrilla(cod);
		}
	})
	$("#txtCodiTecn").keypress(function(event){
		if(event.which == 13){
			cod = $.trim($('#txtCodiTecn').val());
				buscarTecnico(cod);
		}
	});
	$("#txtCodiUsua").keypress(function(event){
		if(event.which == 13){
			cod = $.trim($('#txtCodiUsua').val());
			buscarUsuario(cod);
		}
	});
	$("#txtCodTrab").keypress(function(event){
		if(event.which == 13){
			cod = $.trim($('#txtCodTrab').val());
			tec = $.trim($('#txtCodiTecn').val());
			if(tec!=''){
				buscarTrabajo(cod,tec);
			}else{ alert('Porfavor coloque un tecnico valido') }
		}
	});

	$('#txtHoraInicio').focusout(function(){
		hIni = $('#txtHoraInicio').val();
		hFin = $('#txtHoraFinal').val();

		if( (hIni!='') && (hFin!='') ){
			if(hIni>=hFin){
				alert('La hora de inicio no es valida')
				$('#txtHoraInicio').val('');
			}
		}
	});

	$('#txtHoraFinal').focusout(function(){
		hIni = $('#txtHoraInicio').val();
		hFin = $('#txtHoraFinal').val();
		
		if( (hIni!='') && (hFin!='') ){
			if(hIni>=hFin){
				alert('La hora de inicio no es valida')
				$('#txtHoraInicio').val('');
			}
		}
	});

});
var modal = 0;
var idManGl = 0;
var idMatGl = 0;
var ediText = '';
function swModal(i){

	modal = i;
}
function selectOrd(){
	var ordTip = $('input[name="radioOrden"]:checked').val();
	if(ordTip=='p'){
		$('#txtDepPadre').prop('readonly','readonly');
		$('#txtLocaPadre').prop('readonly','readonly');
		$('#txtNumbPadre').prop('readonly','readonly');
	}else{
		$('#txtDepPadre').prop('readonly','');
		$('#txtLocaPadre').prop('readonly','');
		$('#txtNumbPadre').prop('readonly','');
	}

	$('#txtDepPadre').val('');
	$('#txtLocaPadre').val('');
	$('#txtNumbPadre').val('');
}
function limpiarTablaManoObra(){
	$('#contRowMano').val('');
	a = '<tr style="background-color: #3c8dbc; color:white;">';
	b = '<td class="text-right" width="100"></td><td >Mano de Obra</td>';
	c = '<td class="text-right" width="100">Cantidad</td>';
	d = '<td class="text-right" width="200">Valor</td></tr>'
	$('#tableManoObra').html(a+b+c+d);
}
function limparTablaMateriales(){
	$('#contRowMate').val('');
	a = '<tr style="background-color: #3c8dbc; color:white;">';
	b = '<td class="text-right" width="100"></td><td >Materiales</td>';
	c = '<td class="text-right" width="100">Cantidad</td>';
	d = '<td class="text-right" width="200">Valor</td></tr>';
	$('#tableMateriales').html(a+b+c+d);
}

function solonumeros(){
    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
        event.returnValue = false;
}
function swEditor(id,trId,mod,id){

	$('.trDefault').removeClass('trSelect');
	$('#'+trId).addClass('trSelect');
	modal = mod;
	idManGl = id;
}
function swEditorMat(id,trId,mod,id){

	$('.trDefaultMat').removeClass('trSelect');
	$('#'+trId).addClass('trSelect');
	modal = mod;
	idMatGl = id;
}
function editor(idText){

	ediText = idText;
}
function descargarEditor(){
	var text = 	$('#txtCampEditor').val();
	$('#'+ediText).val(text);
	$('#editModal').modal('hide');
}

function buscarCuadrilla(cod){
	$.ajax({
        type:'POST',
        url:'proc/cror_proc.php?accion=buscar_cuadrilla',
        data:{cod:cod},
        success: function(data){
        	if(data!=''){
	            $('#txtCodiCuad').val(cod);
	            $('#txtNombCuad').val(data);
        	}else{
        		alert('Porfavor coloque una cuadrilla valida')
        	}
        	$('#modalCuadrillas').modal('hide');
        }
    });
}
function buscarTecnico(cod){
	tec = $.trim($('#txtCodTrab').val());
	$.ajax({
        type:'POST',
        url:'proc/cror_proc.php?accion=buscar_tecnico',
        data:{cod:cod,tec:tec},
        success: function(data){
        	if(data!=''){
	            $('#txtCodiTecn').val(cod);
	            $('#txtNombTecn').val(data);
        	}else{
        		alert('Porfavor coloque un tecnico valido')
        	}
        	$('#modalTecnicos').modal('hide');
        }
    });
}
function buscarUsuario(cod){
	$.ajax({
        type:'POST',
        url:'proc/cror_proc.php?accion=buscar_usuario',
        data:{cod:cod},
        success: function(data){
        	if(data!=''){
	            $('#txtCodiUsua').val(cod);
	            $('#txtNombUsua').val(data);
	            buscarDireccionUsuario(cod);
        	}else{
        		alert('Porfavor coloque un usuario valido')
        	}
        	$('#modalUsuarios').modal('hide');
        }
    });
}
function buscarDireccionUsuario(cod){
	$.ajax({
        type:'POST',
        url:'proc/cror_proc.php?accion=buscar_direc_usuario',
        data:{cod:cod},
        success: function(data){
	        $('#txtDireUsua').val(data);
        }
    });
}
function buscarTrabajo(cod,tec){
	$.ajax({
        type:'POST',
        url:'proc/cror_proc.php?accion=buscar_trabajo',
        data:{cod:cod,tec:tec},
        success: function(data){
        	if(data!=''){
	            $('#txtCodTrab').val(cod);
	            $('#txtNomTrab').val(data);
        	}else{
        		$('#txtNomTrab').val('');
        		alert('Porfavor coloque un pqr valido')
        	}
        	$('#modalPqr').modal('hide');
        }
    });
}
function buscarManoObra(cod,cant,val){
	$('#txtCodMan'+idManGl).val('');
	//Validar que no se repita
	sw = false;
	var cont = $('#contRowMano').val();
	for(var i=1;i<=cont;i++){
		var codOrg = $.trim($('#txtCodMan'+i).val());
		if(codOrg==cod){
			sw = true;
		}
	}
	if(!sw){
	    $('#modalManoObra').modal('hide');
		$.ajax({
	        type:'POST',
	        url:'proc/cror_proc.php?accion=buscar_manoObra',
	        data:{cod:cod},
	        //dataType: 'json',
	        success: function(data){
	        	//alert(data)
	        	if(data!=''){
	        		//
		            $('#txtCodMan'+idManGl).val(cod);
		            $('#txtNombMan'+idManGl).val(data);
		            if(cant!=0){
		            	$('#txtCantMan'+idManGl).val(1);
		            }else{
		            	$('#txtCantMan'+idManGl).val(0);
		            }
		            $('#txtCantManMAx'+idManGl).val(cant);
		            $('#txtValMan'+idManGl).val(val);
		            $('#txtValManTotal'+idManGl).val(val);
	        	}else{
	        		alert('Porfavor coloque una mano de obra valida')
	        	}
	        }
	    });
	}else{
		alert('Error! La mano de obra ya existe')
	}
}
function buscarMaterial(cod,cantFija,cant,invCant,invVal){
	$('#txtCodMat'+idMatGl).val('');
	//Validar que no se repita
	sw = false;
	var cont = $('#contRowMate').val();
	for(var i=1;i<=cont;i++){
		var codOrg = $.trim($('#txtCodMat'+i).val());
		if(codOrg==cod){
			sw = true;
		}
	}
	if(!sw){
	    $('#modalMaterial').modal('hide');
		$.ajax({
	        type:'POST',
	        url:'proc/cror_proc.php?accion=buscar_materiales',
	        data:{cod:cod},
	        success: function(data){
	        	if(data!=''){
	        		//
		            $('#txtCodMat'+idMatGl).val(cod);
		            $('#txtNombMat'+idMatGl).val(data);
		            $('#txtCantMat'+idMatGl).val(1);
		            $('#txtCantMatMax'+idMatGl).val(cant);
		            $('#txtCantMatFija'+idMatGl).val(cantFija);
		            $('#txtValMat'+idMatGl).val(invVal);
		            $('#txtValMatMax'+idMatGl).val(invVal);
		            $('#txtCantMatInv'+idMatGl).val(invCant);
	        	}else{
	        		alert('Porfavor coloque un material valido')
	        	}
	        }
	    });
	}else{
		alert('Error! El material ya existe')
	}
}
function solonumerosEnterMano(id){
	if(event.which == 13){
		colocarManoObra(id);
	}else{
	    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
	        event.returnValue = false;
	}
}
function solonumerosEnterCalMano(id){
	if(event.which == 13){
		colocarManoObraCal(id);
	}else{
	    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
	        event.returnValue = false;
	}
}
function colocarManoObra(id){
	cod = $('#txtCodMan'+id).val();
	if(cod!=''){
		buscarManoObraCant(cod);
	}else{
		$('#txtCodMan'+id).val('');
		$('#txtTipoMan'+id).val('');
		$('#txtNombMan'+id).val('');
		$('#txtCantMan'+id).val('');
		$('#txtCantManMAx'+id).val('');
		$('#txtValMan'+id).val('');
		$('#txtValManTotal'+id).val('');
	}
}
function buscarManoObraCant(cod){
	$('#txtCodMan'+idManGl).val('');
	//Validar que no se repita
	sw = false;
	var cont = $('#contRowMano').val();
	for(var i=1;i<=cont;i++){
		var codOrg = $.trim($('#txtCodMan'+i).val());
		if(codOrg==cod){
			sw = true;
		}
	}
	if(!sw){
		pqr = $('#txtCodTrab').val();
	    $('#modalManoObra').modal('hide');
		$.ajax({
	        type:'POST',
	        url:'proc/cror_proc.php?accion=buscar_manoObraxCant',
	        data:{pqr:pqr,cod:cod},
	        dataType: "json",
	        success: function(data){
	        	if(data[0]!=''){
	        		//
		            $('#txtCodMan'+idManGl).val(cod);
		            $('#txtNombMan'+idManGl).val(data);
		            if(data[1]!=0){
		            	$('#txtCantMan'+idManGl).val(1);
		            }else{
		            	$('#txtCantMan'+idManGl).val(0);
		            }
		            $('#txtCantManMAx'+idManGl).val(data[1]);
		            $('#txtValMan'+idManGl).val(data[2]);
		            $('#txtValManTotal'+idManGl).val(data[2]);
	        	}else{
	        		alert('Porfavor coloque una mano de obra valida')
	        	}
	        }
	    });
	}else{
		alert('Error! La mano de obra ya existe')
	}
}
function colocarManoObraCal(id){
	cant = parseInt($('#txtCantMan'+id).val());
	cantMax = parseInt($('#txtCantManMAx'+id).val());
	val = parseInt($('#txtValMan'+id).val());

	if(cant<=cantMax){
		$('#txtValManTotal'+id).val(cant*val);
	}else{
		alert('La Cantidad no es valida');
		$('#txtCantMan'+id).val(1);
		$('#txtValManTotal'+id).val(val);
	}
}
function actualizarPqr(cod){
	$.ajax({
        type:'POST',
        url:'proc/cror_proc.php?accion=buscar_pqrxtecnico',
        data:{cod:cod},
        success: function(data){
        	$('#tablaDivPqr').html(data);
			$('#modalPqr').modal('show');
        }
    });
}
function actualizarManoObra(cod){
	$.ajax({
        type:'POST',
        url:'proc/cror_proc.php?accion=actualiza_manoObraxpqr',
        data:{cod:cod},
        success: function(data){
        	$('#tablaDivManoObra').html(data);
			$('#modalManoObra').modal('show');
        }
    });
}
function actualizarMateriales(cod){
	tec = $('#txtCodiTecn').val();
	$.ajax({
        type:'POST',
        url:'proc/cror_proc.php?accion=actualiza_materialesxpqr',
        data:{cod:cod,tec:tec},
        success: function(data){
        	$('#tablaDivMateriales').html(data);
			$('#modalMaterial').modal('show');
        }
    });
}
function solonumerosEnterMat(id){
	if(event.which == 13){
		colocarMaterial(id);
	}else{
	    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
	        event.returnValue = false;
	}
}
function colocarMaterial(id){
	cod = $('#txtCodMat'+id).val();
	if(cod!=''){
		buscarMaterialxCant(cod);
	}else{
		$('#txtCodMat'+id).val('');
		$('#txtTipoMat'+id).val('');
		$('#txtNombMat'+id).val('');
		$('#txtCantMat'+id).val('');
		$('#txtCantMatMax'+id).val('');
		$('#txtCantMatFija'+id).val('');
		$('#txtValMat'+id).val('');
		$('#txtValMatMax'+id).val('');
		$('#txtCantMatInv'+id).val('');

	}
}
function buscarMaterialxCant(cod){
	$('#txtCodMat'+idMatGl).val('');
	//Validar que no se repita
	sw = false;
	var cont = $('#contRowMate').val();
	for(var i=1;i<=cont;i++){
		var codOrg = $.trim($('#txtCodMat'+i).val());
		if(codOrg==cod){
			sw = true;
		}
	}
	if(!sw){
		tec = $('#txtCodiTecn').val();
		pqr = $('#txtCodTrab').val();
	    $('#modalMaterial').modal('hide');
		$.ajax({
	        type:'POST',
	        url:'proc/cror_proc.php?accion=buscar_materialesxcant',
	        data:{cod:cod,tec:tec,pqr:pqr},
	        dataType: "json",
	        success: function(data){
	        	if(data[0]!=''){
	        		//
		            $('#txtCodMat'+idMatGl).val(cod);
		            $('#txtNombMat'+idMatGl).val(data[0]);
		            $('#txtCantMat'+idMatGl).val(1);
		            $('#txtCantMatMax'+idMatGl).val(data[1]);
		            $('#txtCantMatFija'+idMatGl).val(data[2]);
		            $('#txtValMat'+idMatGl).val(data[4]);
		            $('#txtValMatMax'+idMatGl).val(data[4]);
		            $('#txtCantMatInv'+idMatGl).val(data[3]);
	        	}else{
	        		alert('Porfavor coloque un material valido')
	        	}
	        }
	    });
	}else{
		alert('Error! El material ya existe')
	}
}
function colocarMateCant(id){
	if(event.which == 13){
		calcularMaterial(id);
	}else{
	    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
	        event.returnValue = false;
	}
}
function calcularMaterial(id){
	cant = parseInt($('#txtCantMat'+id).val());
	cantFija = parseInt($('#txtCantMatMax'+id).val());
	cantFijaVal = $('#txtCantMatFija'+id).val();
	val = parseInt($('#txtValMatMax'+id).val());
	cantInv = parseInt($('#txtCantMatInv'+id).val());

	if(cantFijaVal=='N'){
		if(cant<=cantInv){
			$('#txtValMat'+id).val(cant*val);
		}else{
			alert('La Cantidad no es valida, el inventario no es suficiente');
			$('#txtCantMat'+id).val(1);
			$('#txtValMat'+id).val(val);
		}
	}else{
		if(cantFija<=cantInv){
			$('#txtCantMat'+id).val(cantFija);
			$('#txtValMat'+id).val(cantFija*val);
		}else{
			alert('La Cantidad no es valida, el inventario no es suficiente');
			$('#txtCantMat'+id).val(cantInv);
			$('#txtValMat'+id).val(cantInv*val);
		}
	}
}
//solonumeros