<?php 
	session_start();
	date_default_timezone_set('America/Bogota');
	$conn = require '../template/sql/conexion.php';

	if($_REQUEST["accion"]=="buscar_tecnico"){
		$dato='';
		$query ="SELECT * FROM tecnico WHERE TECNCODI = ".$_REQUEST["cod"];
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                	$dato = utf8_encode($row['TECNNOMB']);                              
                }   
            }
            echo $dato;
	}
	if($_REQUEST["accion"]=="generar_acta"){
		$tec = $_REQUEST["tec"];
		$fec = $_REQUEST["fec"];
		$swGen = true;
		
		//CONTAR MANO DE OBRA POR TECNICO SELECCIONADO
			$idMAOBTEC = '';
			$contMAOBTEC = 0;
			$valMAOBTEC = 0;
			$idMAOBTECExp = '';
			$query ="SELECT id, MOOTVAPA as SUM FROM mobrottr WHERE MOOTTECN = $tec AND MOOTFECH <= '$fec' AND ( MOOTACTA is NULL OR MOOTACTA = 0 ) ";
	        $respuesta = $conn->prepare($query) or die ($sql);
	        if(!$respuesta->execute()) return false;
	        if($respuesta->rowCount()>0){
	            while ($row=$respuesta->fetch()){
	            	$idMAOBTEC = $idMAOBTEC.$row['id'].',';
	            	$valMAOBTEC = $valMAOBTEC + (int)$row['SUM'];
	            }
	        }
			$contMAOBTEC = $respuesta->rowCount();
			$idMAOBTECExp = explode(',',$idMAOBTEC);
		//END CONTAR MANO DE OBRA POR TECNICO SELECCIONADO

		//CONTAR NOTAS ASIGNADAS A TECNICO SELECCIONADO
			$idNOTAS = '';
			$contNOTAS = 0;
			$valNOTAS = 0;
			$idNOTASExp = '';
			$query ="SELECT NOTACODI,NOTAVALO as SUM FROM nota WHERE NOTATECN = $tec AND  NOTAFEAP <= '$fec' AND ( NOTAACTA is NULL OR NOTAACTA = 0 ) ";
	        $respuesta = $conn->prepare($query) or die ($sql);
	        if(!$respuesta->execute()) return false;
	        if($respuesta->rowCount()>0){
	            while ($row=$respuesta->fetch()){
	            	$idNOTAS = $idNOTAS.$row['NOTACODI'].',';
	            	$valNOTAS = $valNOTAS + (int)$row['SUM'];
	            }
	        }
			$contNOTAS = $respuesta->rowCount();
			$idNOTASExp = explode(',',$idNOTAS);
		//END CONTAR NOTAS ASIGNADAS A TECNICO SELECCIONADO

		//CREAR ACTA
			$valor = $valMAOBTEC+$valNOTAS;
			$fecha = date('Y-m-d');
			$leg = $_SESSION['user'];
			$ult = 0;
			$query ="INSERT INTO acta (ACTATECN,ACTAFECH,ACTAESTA,ACTAVABR,ACTAVANE,ACTAGENERADOR,ACTACLAS,ACTAFECOR) 
                	 VALUES ($tec,'$fecha','G',$valor,$valor,'$leg','O','$fec')";
	        $respuesta = $conn->prepare($query) or die ($query);
	        if(!$respuesta->execute()){
	            echo 'Error!';
	        }else{
	            //OBTENER NUMERO DE ACTA
	            	$queryActa ="SELECT ACTANUME FROM acta ORDER BY ACTANUME DESC LIMIT 1";
		            $respuestaActa = $conn->prepare($queryActa) or die ($queryActa);
		            if(!$respuestaActa->execute()) return false;
		            if($respuestaActa->rowCount()>0){
		                while ($rowActa=$respuestaActa->fetch()){
		                	$ult = $rowActa['ACTANUME'];                              
		                }   
		            }
		        //
		        //ACTUALIZAR MANOS DE OBRAS
		            for($i=0;$i<$contMAOBTEC;$i++) { 
		            	$queryUpdate = "UPDATE mobrottr SET MOOTACTA = $ult WHERE id = ".$idMAOBTECExp[$i];
		           		$respuestaUpdate = $conn->prepare($queryUpdate) or die ($queryUpdate);
				        if(!$respuestaUpdate->execute()){
				            //echo 'Error!';
				            $swGen = false;
				        }else{
				            //echo 1;
				            $swGen = true;
				        }
		            }
		        //
		        //ACTUALIZAR NOTAS 
		            for($i=0;$i<$contNOTAS;$i++) { 
		            	$queryUpdate = "UPDATE nota SET NOTAACTA = $ult WHERE NOTACODI = ".$idNOTASExp[$i];
		           		$respuestaUpdate = $conn->prepare($queryUpdate) or die ($queryUpdate);
				        if(!$respuestaUpdate->execute()){
				            //echo 'Error!';
				            $swGen = false;
				        }else{
				            //echo 1;
				            $swGen = true;
				        }
		            }
		        //
	        }
		//END CREAR ACTA
	    $arr = array($swGen,$ult);
	    echo json_encode($arr);
       // echo $swGen;
	}


?>