<?php 
	session_start();
	date_default_timezone_set('America/Bogota');
	$conn = require '../template/sql/conexion.php';

	function buscarManoObra($cod){
		$conn = require '../template/sql/conexion.php';
		$nom = '';
		$query ="SELECT * FROM manobra WHERE MOBRCODI = $cod";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
            	$nom = utf8_encode($row['MOBRDESC']);                              
            }   
        }
        return $nom;
	}
	function buscarUsuario($cod){
		$conn = require '../template/sql/conexion.php';
		$nom = '';
		$query ="SELECT * FROM usuarios WHERE USUCODI = $cod";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
            	$nom = utf8_encode($row['USUNOMB']);                              
            }   
        }
        return $nom;
	}

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
	if($_REQUEST["accion"]=="buscar_orden"){
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

	if($_REQUEST["accion"]=="limpiar_tabla"){
    	$table = '
    			<table id="tableMateriales" class="table table-bordered table-condensed">
        			<tr style="background-color: #3c8dbc; color:white;">
        				<th class="text-center" width="10" style="vertical-align:middle"><input type="checkbox"></th>
        				<th class="text-center" width="120">NUMERO DE ORDEN</th>
        				<th class="text-center" width="100" style="vertical-align:middle">FECHA ORDEN</th>
        				<th class="text-center" width="100">FECHA ASIGNACION</th>
        				<th class="text-center" width="100">FECHA CUMPLIMIENTO</th>
        				<th class="text-center" width="70" style="vertical-align:middle">PQR</th>
        				<th class="text-left" style="vertical-align:middle">MANO DE OBRA</th>
        				<th class="text-left" style="vertical-align:middle">USUARIO</th>
        				<th class="text-right" width="100" style="vertical-align:middle">VALOR</th>
        			</tr>
        		</table>
        		';
        echo $table;
    }
    if($_REQUEST["accion"]=="buscar_manos_obra"){
    	$tec = $_REQUEST["tec"];
    	$cOr = $_REQUEST["critOrd"];
    	$ord = $_REQUEST["ord"];
    	$i = 0;
    	
    	//VALIDAMOS CRITERIOS
        $orderby = "";
        switch ($cOr){
        	case 1: //ORDEN
        		$orderby = "ORDER BY mobrottr.MOOTNUMO";
        	break;
        	case 2: //MANO OBRA
        		$orderby = "ORDER BY mobrottr.MOOTMOBR";
        	break;
        	case 3: //FECHA CUMPLIMIENTO
        		$orderby = "ORDER BY ot.OTCUMP";
        	break;
        	case 4: //PQR
        		$orderby = "ORDER BY ot.OTPQRREPO";
        	break;
        	case 5: //USUARIO
        		$orderby = "ORDER BY usuarios.USUNOMB";
        	break;
        }

    	$table = '
    			<table id="tableMateriales" class="table table-bordered table-condensed">
        			<tr style="background-color: #3c8dbc; color:white;">
        				<th class="text-center" width="10"  style="vertical-align:middle"><input type="checkbox" onclick="selectTodos()"></th>
        				<th class="text-center" width="120" style="vertical-align:middle">NUMERO DE ORDEN</th>
        				<th class="text-center" width="100" style="vertical-align:middle">FECHA ORDEN</th>
        				<th class="text-center" width="100" style="vertical-align:middle">FECHA ASIGNACION</th>
        				<th class="text-center" width="100" style="vertical-align:middle">FECHA CUMPLIMIENTO</th>
        				<th class="text-center" width="70"  style="vertical-align:middle">PQR</th>
        				<th class="text-left" style="vertical-align:middle">MANO DE OBRA</th>
        				<th class="text-left" style="vertical-align:middle">USUARIO</th>
        				<th class="text-right" width="100" style="vertical-align:middle">VALOR</th>
        			</tr>
        		';

       	$query = "SELECT mobrottr.ID, mobrottr.MOOTDEPA, mobrottr.MOOTLOCA, mobrottr.MOOTNUMO, OT.OTFEORD, OT.OTFEAS, OT.OTCUMP, OT.OTPQRREPO, mobrottr.MOOTMOBR, OT.OTUSUARIO, mobrottr.MOOTVAPA
				  FROM mobrottr
				  INNER JOIN OT ON OT.OTNUME = mobrottr.MOOTNUMO 
				  	JOIN usuarios ON usuarios.USUCODI = OT.OTUSUARIO
				  WHERE mobrottr.MOOTTECN = $tec AND ( MOOTACTA is NULL OR MOOTACTA = 0 )
				   $orderby";

        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
            	$mObra = buscarManoObra( $row['MOOTMOBR'] );
            	$usuar = buscarUsuario( $row['OTUSUARIO'] );
            	$table .= '
            		<tr>
        				<td class="text-center" width="10" style="vertical-align:middle">
        					<input type="hidden" id="idManObra'.$i.'" value="'.$row['ID'].'">
        					<input type="checkbox" id="txtCheck'.$i.'">
        				</td>
        				<td class="" width="120" style="vertical-align:middle">'.$row['MOOTDEPA'].'-'.$row['MOOTLOCA'].'-'.$row['MOOTNUMO'].'</td>
        				<td class="text-center" width="100" style="vertical-align:middle">'.$row['OTFEORD'].'</td>
        				<td class="text-center" width="100" style="vertical-align:middle">'.$row['OTFEAS'].'</td>
        				<td class="text-center" width="100" style="vertical-align:middle">'.$row['OTCUMP'].'</td>
        				<td class="text-center" width="70" style="vertical-align:middle">'.$row['OTPQRREPO'].'</td>
        				<td class="text-left" style="vertical-align:middle"><small>'.$mObra.'</small></td>
        				<td class="text-left" style="vertical-align:middle"><small>'.$usuar.'</small></td>
        				<td class="text-right" width="100" style="vertical-align:middle">$ '.number_format($row['MOOTVAPA'],0,"",".").'</td>
        			</tr>';
        		$i++;
            }   
        }
        echo $table.'</table><input type="hidden" id="contRow" value="'.($i).'">';
    }
    if($_REQUEST["accion"]=="generar_acta"){
		$tec = $_REQUEST["tec"];
		$fec = date('Y-m-d');
		$idMAOBTECExp = explode(',', $_REQUEST["allID"]);
		$swGen = true;


		//CONTAR MANO DE OBRA POR TECNICO SELECCIONADO
			$valMAOBTEC = 0;
			for ($i=0;$i<count($idMAOBTECExp)-1;$i++){ 
				$query ="SELECT MOOTVAPA FROM mobrottr WHERE id = ".$idMAOBTECExp[$i];
		        $respuesta = $conn->prepare($query) or die ($sql);
		        if(!$respuesta->execute()) return false;
		        if($respuesta->rowCount()>0){
		            while ($row=$respuesta->fetch()){
		            	$valMAOBTEC = $valMAOBTEC + (int)$row['MOOTVAPA'];
		            }
		        }
			}
		//

		//CREAR ACTA
			$valor = $valMAOBTEC;
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
		            for($i=0;$i<count($idMAOBTECExp)-1;$i++) { 
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
	        }
		//
        $arr = array($swGen,$ult);
	    echo json_encode($arr);
	}

?>