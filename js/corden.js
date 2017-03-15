$(document).ready(function(){

	$("#txtCodNum").keypress(function(event){
		if(event.which == 13){
			dep = $("#txtCodDep").val();
			loc = $("#txtCodLoc").val();
			num = $("#txtCodNum").val();
			//if( (dep!='') && (loc!='') && (num!='') ){
				buscarNumeroOrden(dep,loc,num);
			//}else{
			//	alert('Porfavor coloque un numero de orden valido')
			//}
		}
	});

    $('#btnConsulta').click(function(){
        dep = $("#txtCodDep").val();
        loc = $("#txtCodLoc").val();
        num = $("#txtCodNum").val();
        buscarNumeroOrden(dep,loc,num);
    });

    $('#btnCancelar').removeClass('disabled');
    $('#btnCancelar').click(function(){
        $('#txtCodDep').val('');
        $('#txtCodLoc').val('');
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
    });
});

function buscarNumeroOrden(dep,loc,num){
    $.ajax({
        type:'POST',
        url:'proc/corden_proc.php?accion=buscar_orden',
        data:{ num:num },
        dataType: "json",
        success: function(data){
            $('#txtCodDep').val(data[0]);
            $('#txtCodLoc').val(data[1]);
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