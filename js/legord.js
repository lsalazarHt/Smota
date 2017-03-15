$(document).ready(function(){
	//btnConsulta
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
	    "autoWidth": false
	    /*"columns": [
	        { "class": "text-center cod","width":"15%"},
	        { "class": "text-left","width":"30px"}
	    ]*/
	});

	$('#btnEditor').click(function(){
		var text = $('#'+ediText).val();
		$('#txtCampEditor').val(text);
		$('#editModal').modal('show');
	});

	$("#txtNumbOrd").keypress(function(event){
		if(event.which == 13){
			dep = $.trim($('#txtDepOrd').val());
			loc = $.trim($('#txtLocaOrd').val());
			num = $.trim($('#txtNumbOrd').val());
			if( (dep!='') && (loc!='') && (num!='') ){
				buscarOrden(dep,loc,num);
			}else{ alert('Porfavor coloque un numero valido') }
		}
	});

	$('#btnCancelar').click(function(){
		limpiar();
		$('#btnGuardar').addClass('disabled');
		$('#btnCancelar').addClass('disabled');
	});

	$('#btnListaValores').click(function(){
		if(modal==1){
			$('#modalOrdenes').modal('show');
		}else if(modal==2){ //Validar pqr x tecnico
			tec = $.trim($('#txtCodTecn').val());
			if(tec!=''){
				actualizarPqr(tec);
			}else{ alert('Porfavor coloque un tecnico valido') }
		}else if(modal==5){ //Validar mano de obra x tecnico y pqr
			pqr = $.trim($('#txtPqrCodEnc').val());
			if(pqr!=''){
				actualizarManoObra(pqr);
			}else{ alert('Porfavor coloque una pqr valido') }
		}else if(modal==6){
			pqr = $.trim($('#txtPqrCodEnc').val());
			if(pqr!=''){
				actualizarMateriales(pqr);
			}else{ alert('Porfavor coloque una pqr valido') }
			$('#modalMaterial').modal('show');
		}
	});

	$('#btnGuardar').click(function(){
		dep = $('#txtDepOrd').val();
		loc = $('#txtLocaOrd').val();
		num = $('#txtNumbOrd').val();

		fCumpl = $('#txtFechaCumpl').val();
		pqrEnc = $('#txtPqrCodEnc').val();

		horIni = $('#txtHoraInicial').val();
		horFin = $('#txtHoraFinal').val();

		legali = $('#txtLegalizador').val();

		if( (dep!='') && (loc!='') && (num!='') && (fCumpl!='') && (pqrEnc!='') && (horIni!='') 
			&& (horFin!='') && (legali!='') ){
			guardarOrdenIndiv(dep,loc,num,fCumpl,pqrEnc,horIni,horFin,legali);
		}else{
			alert('Porfavor complete los datos, para poder legalizar la orden')
		}
	});

	$("#txtPqrCodEnc").keypress(function(event){
		if(event.which == 13){
			cod = $.trim($('#txtPqrCodEnc').val());
			tec = $.trim($('#txtCodTecn').val());
			if(tec!=''){
				buscarTrabajo(cod,tec);
			}else{ alert('Porfavor coloque un tecnico valido') }
		}
	});

	$('#txtPqrCodEnc').click(function(){ modal = 2; });

	$('#txtDepOrd').click(function(){ modal = 1; });
	$('#txtLocaOrd').click(function(){ modal = 1; });
	$('#txtNumbOrd').click(function(){ modal = 1; });

	$('#txtHoraInicial').focusout(function(){
		hIni = $('#txtHoraInicial').val();
		hFin = $('#txtHoraFinal').val();

		if( (hIni!='') && (hFin!='') ){
			if(hIni>=hFin){
				alert('La hora de inicio no es valida')
				$('#txtHoraInicial').val('');
			}
		}
	});

	$('#txtHoraFinal').focusout(function(){
		hIni = $('#txtHoraInicial').val();
		hFin = $('#txtHoraFinal').val();
		
		if( (hIni!='') && (hFin!='') ){
			if(hIni>=hFin){
				alert('La hora de inicio no es valida')
				$('#txtHoraInicial').val('');
			}
		}
	});

	//Btn Agregar
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
	    cell3.className = 'text-center ';
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

});
var modal = 1;
var idManGl = 0;
var idMatGl = 0;
var ediText = '';

/*
function swSalir(){
	$('#txt_sw_salir').val(1);
}
function salir_ventana(){
	var r = confirm("Esta seguro que desea salir?");
	if(r==true){
	    txt = "You pressed OK!";
	}
}*/
function buscarOrden(dep,loc,num){
	$.ajax({
        type:'POST',
        url:'proc/legord_proc.php?accion=obtener_orden',
        data:{dep:dep, loc:loc, num:num},
        dataType: "json",
        success: function(data){
			$('#modalOrdenes').modal('hide');
        	$('#txtDepOrd').val(dep);
			$('#txtLocaOrd').val(loc);
			$('#txtNumbOrd').val(num);
			//Tecnico
			$('#txtCodTecn').val(data[0]);
			$('#txtNomTecn').val(data[1]);
			//console.log(data[1])
			//Cumplida
			/*if(data[2]==3){
				$('#divEstOrd').html('<input type="checkbox" style="margin-left: 20px; margin-top:10px;" checked><label style="margin-left: 10px; color:red;">Cumplida</label>');
			}else{
				$('#divEstOrd').html('<input type="checkbox" style="margin-left: 20px; margin-top:10px;"><label style="margin-left: 10px; color:red;">Cumplida</label>');
			}*/
			//Fechas
			$('#txtFechaRecib').val(data[3]);
			$('#txtFechaOrd').val(data[4]);
			$('#txtFechaCumpl').val(data[5]);
			$('#txtFechaAsig').val(data[6]);
			$('#txtFechaLega').val(data[7]);
			//Pqr
			$('#txtPqrCodRep').val(data[8]);
			$('#txtPqrNombRep').val(data[9]);
			$('#txtPqrCodEnc').val(data[10]);
			$('#txtPqrNombEnc').val(data[11]);
			//Usuario
			$('#txtCodUser').val(data[12]);
			$('#txtNomUser').val(data[13]);
			//Estado
			$('#txtCodEst').val(data[14]);
			$('#txtNomEst').val(data[15]);
			//Hora
			$('#txtHoraInicial').val(data[16]);
			$('#txtHoraFinal').val(data[17]);
			//
			$('#txtObservacion').val(data[18]);
			
			$('#txtAsignador').val(data[19]);
			$('#txtRecibidor').val(data[20]);
			//$('#txtLegalizador').val(data[21]);

			//obtenerManoObraOrden(dep,loc,num);
			//obtenerMaterialesOrden(dep,loc,num);

			//Desbloquear 
			$('#btnGuardar').removeClass('disabled');
			$('#btnCancelar').removeClass('disabled');
        }
    });
}
function editor(idText){

	ediText = idText;
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
function descargarEditor(){
	var text = 	$('#txtCampEditor').val();
	$('#'+ediText).val(text);
	$('#editModal').modal('hide');
}
function guardarOrdenIndiv(dep,loc,num,fCumpl,pqrEnc,horIni,horFin,leg){
	
	obs = $('#txtObservacion').val();
	codTec = $('#txtCodTecn').val();
	
	$.ajax({
        type:'POST',
        url:'proc/legord_proc.php?accion=guardar_orden',
        data:{dep:dep, loc:loc, num:num, obs:obs, leg:leg, fCumpl:fCumpl, pqrEnc:pqrEnc, horIni:horIni, horFin:horFin },
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
					        url:'proc/legord_proc.php?accion=guardar_mo_ot',
					        data:{ cod:cod, dep:dep, loc:loc, num:num, can:can, val:val, codTec:codTec},
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
					        url:'proc/legord_proc.php?accion=guardar_ma_ot',
					        data:{ cod:cod, dep:dep, loc:loc, num:num, can:can, val:val, codTec:codTec, cantInv:cantInv},
					        success: function(data){
					        	console.log(data+' MA')
					        }
					    });
					}
				}
        		//Actualizar Ordenes
        		$.ajax({
			        type:'POST',
			        url:'proc/legord_proc.php?accion=actualizar_orden',
			        data:{cod:'1'},
			        success: function(data){
			        	$('#divTableOrdenes').html(data);
			        }
			    });

        		alert('La orden se guardo con Exito!')
				limpiar();
        	}else{ alert(data) }
        }
    });
}
function obtenerManoObraOrden(dep,loc,num){
	$.ajax({
        type:'POST',
        url:'proc/legord_proc.php?accion=obtener_mano_obra',
        data:{dep:dep, loc:loc, num:num},
        success: function(data){
        	$('#tableManoObra').html(data);
        }
    });
}
function obtenerMaterialesOrden(dep,loc,num){
	$.ajax({
        type:'POST',
        url:'proc/legord_proc.php?accion=obtener_materiales',
        data:{dep:dep, loc:loc, num:num},
        success: function(data){
        	$('#tableMateriales').html(data);
        }
    });
}
function limpiar(){
	$('#txtDepOrd').val('');
	$('#txtLocaOrd').val('');
	$('#txtNumbOrd').val('');
	//Tecnico
	$('#txtCodTecn').val('');
	$('#txtNomTecn').val('');
	//Cumplida
	//$('#divEstOrd').html('<input type="checkbox" style="margin-left: 20px; margin-top:10px;"><label style="margin-left: 10px; color:red;">Cumplida</label>');
	//Fechas
	$('#txtFechaRecib').val('');
	$('#txtFechaOrd').val('');
	$('#txtFechaCumpl').val('');
	$('#txtFechaAsig').val('');
	$('#txtFechaLega').val('');
	//Pqr
	$('#txtPqrCodRep').val('');
	$('#txtPqrNombRep').val('');
	$('#txtPqrCodEnc').val('');
	$('#txtPqrNombEnc').val('');
	//Usuario
	$('#txtCodUser').val('');
	$('#txtNomUser').val('');
	//Estado
	$('#txtCodEst').val('');
	$('#txtNomEst').val('');
	//Hora
	$('#txtHoraInicial').val('');
	$('#txtHoraFinal').val('');
	$('#txtObservacion').val('');
	$('#txtAsignador').val('');
	$('#txtRecibidor').val('');
	//$('#txtLegalizador').val('');

	a = '<tr style="background-color: #3c8dbc; color:white;"><td class="text-right" width="80"></td>';
	b = '<td >Mano de Obra</td><td class="text-right" width="70">Cantidad</td>';
	c = '<td class="text-right" width="100">Valor</td></tr>';
	$('#tableManoObra').html(a+b+c);
	
	a = '<tr style="background-color: #3c8dbc; color:white;"><td class="text-right" width="80"></td>';
	b = '<td >Material</td><td class="text-right" width="70">Cantidad</td>';
	c = '<td class="text-right" width="100">Valor</td></tr>';
	$('#tableMateriales').html(a+b+c);
}
//PQR X TECNICO
function actualizarPqr(cod){
	$.ajax({
        type:'POST',
        url:'proc/legord_proc.php?accion=buscar_pqrxtecnico',
        data:{cod:cod},
        success: function(data){
        	$('#tablaDivPqr').html(data);
			$('#modalPqr').modal('show');
        }
    });
}
function buscarTrabajo(cod,tec){
	$.ajax({
        type:'POST',
        url:'proc/legord_proc.php?accion=buscar_trabajo',
        data:{cod:cod,tec:tec},
        success: function(data){
        	if(data!=''){
	            $('#txtPqrCodEnc').val(cod);
	            $('#txtPqrNombEnc').val(data);
        	}else{
        		$('#txtPqrNombEnc').val('');
        		alert('Porfavor coloque un pqr valido')
        	}
        	$('#modalPqr').modal('hide');
        }
    });
}
//MANO DE OBRA X PQR
function solonumerosEnterMano(id){
	if(event.which == 13){
		colocarManoObra(id);
	}else{
	    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
	        event.returnValue = false;
	}
}
function actualizarManoObra(cod){
	$.ajax({
        type:'POST',
        url:'proc/legord_proc.php?accion=actualiza_manoObraxpqr',
        data:{cod:cod},
        success: function(data){
        	$('#tablaDivManoObra').html(data);
			$('#modalManoObra').modal('show');
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
	        url:'proc/legord_proc.php?accion=buscar_manoObra',
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
		pqr = $('#txtPqrCodEnc').val();
	    $('#modalManoObra').modal('hide');
		$.ajax({
	        type:'POST',
	        url:'proc/legord_proc.php?accion=buscar_manoObraxCant',
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
// MATERIALES X PQR
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
	        url:'proc/legord_proc.php?accion=buscar_materiales',
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
function actualizarMateriales(cod){
	tec = $('#txtCodTecn').val();
	$.ajax({
        type:'POST',
        url:'proc/legord_proc.php?accion=actualiza_materialesxpqr',
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
		tec = $('#txtCodTecn').val();
		pqr = $('#txtPqrCodEnc').val();
	    $('#modalMaterial').modal('hide');
		$.ajax({
	        type:'POST',
	        url:'proc/legord_proc.php?accion=buscar_materialesxcant',
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
