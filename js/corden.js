$(document).ready(function(){
    
	// $("#txtCodNum").keypress(function(event){
	// 	if(event.which == 13){
	// 		dep = $("#txtCodDep").val();
	// 		loc = $("#txtCodLoc").val();
	// 		num = $("#txtCodNum").val();
	// 		//if( (dep!='') && (loc!='') && (num!='') ){
	// 			buscarNumeroOrden(dep,loc,num);
	// 		//}else{
	// 		//	alert('Porfavor coloque un numero de orden valido')
	// 		//}
	// 	}
	// });
    $('#btnListaValores').addClass('disabled');

    $('#btnListaValores').click(function(){
        if(modal == 1){
            $("#modarOrdenes").modal('show');
        } 
    });
    
    $('#btnConsulta').click(function(){
        
        $('#btnNuevo').addClass('disabled');
		$('#btnConsulta').addClass('disabled');
		$('#btnCancelar').removeClass('disabled');
		buscarOrdenes();
        
        /*dep = $("#txtCodDep").val();
        loc = $("#txtCodLoc").val();
        num = $("#txtCodNum").val();
        buscarNumeroOrden(dep,loc,num);*/
    });

    $('#btnPrimer').click(function(){
        //actual
		$('#txtActual_consulta').val(1);
        //obtener codigo
		dep = $('#txtCod_consulta_dep1').val();
		loc = $('#txtCod_consulta_loc1').val();
		num = $('#txtCod_consulta_nun1').val();
        //verificar total
        if($('#txtToltal_consulta').val()!=0 ){
			buscarNumeroOrden(dep,loc,num);
		}
	});
	$('#btnAnterior').click(function(){
        //actual 
        codId = parseInt($('#txtActual_consulta').val());
        //sumamos 1 al actual
        $('#txtActual_consulta').val(codId-1);
        //obtenemos actual 
        codId = parseInt($('#txtActual_consulta').val());
        //obtenemos el ultimo
        codUlt = parseInt($('#txtToltal_consulta').val());
        //verificamos que no se pase del ultimo
        if(codId>=1){
            //obtenemos orden
            dep = $('#txtCod_consulta_dep'+codId).val();
            loc = $('#txtCod_consulta_loc'+codId).val();
            num = $('#txtCod_consulta_nun'+codId).val();
            buscarNumeroOrden(dep,loc,num);
        }else{
            $('#txtActual_consulta').val(1);
        }
	});
	$('#btnSiguiente').click(function(){
        //actual 
        codId = parseInt($('#txtActual_consulta').val());
        //sumamos 1 al actual
        $('#txtActual_consulta').val(codId+1);
        //obtenemos actual 
        codId = parseInt($('#txtActual_consulta').val());
        //obtenemos el ultimo
        codUlt = parseInt($('#txtToltal_consulta').val());
        //verificamos que no se pase del ultimo
        if(codId<=codUlt){
            //obtenemos orden
            dep = $('#txtCod_consulta_dep'+codId).val();
            loc = $('#txtCod_consulta_loc'+codId).val();
            num = $('#txtCod_consulta_nun'+codId).val();
            buscarNumeroOrden(dep,loc,num);
        }else{
            $('#txtToltal_consulta').val(codUlt);
        }
	});
	$('#btnUltimo').click(function(){
        //actual
        codUlt = parseInt($('#txtToltal_consulta').val());
        //actualizar actual
        $('#txtActual_consulta').val(codUlt);
        //obtener codigo
		dep = $('#txtCod_consulta_dep'+codUlt).val();
		loc = $('#txtCod_consulta_loc'+codUlt).val();
		num = $('#txtCod_consulta_nun'+codUlt).val();
		buscarNumeroOrden(dep,loc,num);
	});

    //$('#btnCancelar').removeClass('disabled');
    $('#btnCancelar').click(function(){
        $('#txtCodDep').val('');
        $('#txtCodLoc').val('');
        $('#txtCodNum').val('');
        //tecnico
        $('#txtCodTec').val('');
        $('#txtNomTec').val('');
        //fechas
        $('#txtFecRec').val('');
        $('#txtFecOrd').val('');
        $('#txtFecCum').val('');
        $('#txtFecAsi').val('');
        $('#txtFecLeg').val('');
        //pqr
        $('#txtPqrRep').val('');
        $('#txtPqrRepNom').val('');
        $('#txtPqrEnc').val('');
        $('#txtPqrEncNom').val('');
        //causa
        $('#txtCausaAten').val('');
        $('#txtCausaAtenNom').val('');
        $('#txtCausaNoAten').val('');
        $('#txtCausaNoAtenNom').val('');
        //usuario
        $('#txtUsua').val('');
        $('#txtUsuaNomb').val('');
        $('#txtUsuaDire').val('');
        $('#txtUsuMedid').val('');
        //
        $('#txtRecibi').val('');
        $('#txtMetCort').html('<input type="checkbox" style="float: left; margin-left: 10px; margin-top: 10px;">');
        $('#txtAsigna').val('');
        $('#txtLegali').val('');
        //lectura
        $('#txtLect').val('');
        $('#txtLectCausa').val('');
        $('#txtLectObsj').val('');
        //estado
        $('#txtEst').val('');
        $('#txtEstNom').val('');
        //horas
        $('#txtHoraIni').val('');
        $('#txtHoraFin').val('');
        //observaciones
        $('#txtObservOrd').val('');
        $('#txtObservAsig').val('');
        $('#txtObservLeg').val('');
        $('#txtObservCet').val('');

        $('#divManoObra').html('');
        $('#divMaterial').html('');
        
        $('#divConsultarOt').html('');

        $('#btnConsulta').removeClass('disabled');
		$('#btnCancelar').addClass('disabled');
    });
});
modal = 1;
function buscarOrdenes(){
	$('#divConsultarOt').html('');

    dep  = $('#txtCodDep').val();
    loc  = $('#txtCodLoc').val();
    num  = $('#txtCodNum').val();

    //obtener datos
    tec  = $('#txtCodTec').val();

    pqrR = $('#txtPqrRep').val();
    pqrE = $('#txtPqrEnc').val();

    usu  = $('#txtUsua').val();
    est  = $('#txtEst').val();

	$.ajax({
        type:'POST',
        url:'proc/corden_proc.php?accion=consultar_ordenes',
        data:{ dep:dep, loc:loc, num:num, tec:tec, pqrR:pqrR, pqrE:pqrE, usu:usu, est:est },
        success: function(data){
            console.log(data)
        	$('#divConsultarOt').html(data);

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

function buscarNumeroOrden(dep,loc,num){
    $.ajax({
        type:'POST',
        url:'proc/corden_proc.php?accion=buscar_orden',
        data:{ dep:dep, loc:loc, num:num },
        dataType: "json",
        success: function(data){
            $('#txtCodDep').val(data[0]);
            $('#txtCodLoc').val(data[1]);
            $('#txtCodNum').val(num);
            //tecnico
            $('#txtCodTec').val(data[2]);
            $('#txtNomTec').val(data[3]);
            //fechas
            $('#txtFecRec').val(data[4]);
            $('#txtFecOrd').val(data[5]);
            $('#txtFecCum').val(data[6]);
            $('#txtFecAsi').val(data[7]);
            $('#txtFecLeg').val(data[8]);
            //pqr
            $('#txtPqrRep').val(data[9]);
            $('#txtPqrRepNom').val(data[10]);
            $('#txtPqrEnc').val(data[11]);
            $('#txtPqrEncNom').val(data[12]);
            //causa
            $('#txtCausaAten').val(data[13]);
            $('#txtCausaAtenNom').val(data[14]);
            $('#txtCausaNoAten').val(data[15]);
            $('#txtCausaNoAtenNom').val(data[16]);
            //usuario
            $('#txtUsua').val(data[17]);
            $('#txtUsuaNomb').val(data[18]);
            $('#txtUsuaDire').val(data[19]);
            $('#txtUsuMedid').val(data[20]);
            //
            $('#txtRecibi').val(data[21]);
            if(data[22]!=0){
                $('#txtMetCort').html('<input type="checkbox" style="float: left; margin-left: 10px; margin-top: 10px;" checked>');
            }else{
                $('#txtMetCort').html('<input type="checkbox" style="float: left; margin-left: 10px; margin-top: 10px;">');
            }
            $('#txtAsigna').val(data[23]);
            $('#txtLegali').val(data[24]);
            //lectura
            $('#txtLect').val(data[25]);
            $('#txtLectCausa').val(data[26]);
            $('#txtLectObsj').val(data[27]);
            //estado
            $('#txtEst').val(data[28]);
            $('#txtEstNom').val(data[29]);
            //horas
            $('#txtHoraIni').val(data[30]);
            $('#txtHoraFin').val(data[31]);
            //observaciones
            $('#txtObservOrd').val(data[32]);
            $('#txtObservAsig').val(data[33]);
            $('#txtObservLeg').val(data[34]);
            $('#txtObservCet').val(data[35]);

            //manos de obra
            obtenerManoDeObra(num);
            obtenerMateriales(num);
        }
    });
}
function obtenerManoDeObra(num){
    $.ajax({
        type:'POST',
        url:'proc/corden_proc.php?accion=obtener_mano_obra',
        data:{ num:num },
        success: function(data){
            $('#divManoObra').html(data);
        }
    });
}
function obtenerMateriales(num){
    $.ajax({
        type:'POST',
        url:'proc/corden_proc.php?accion=obtener_materiales',
        data:{ num:num },
        success: function(data){
            $('#divMaterial').html(data);
        }
    });
}

//OTROS
function solonumeros(){
    if ( (event.keyCode < 48) || (event.keyCode > 57)  ) 
        event.returnValue = false;
}

function pressEnter(campo){
    if(campo==='txtCodNum'){
        dep = $("#txtCodDep").val();
        loc = $("#txtCodLoc").val();
        num = $("#txtCodNum").val();
        buscarNumeroOrden(dep,loc,num);
    }
}