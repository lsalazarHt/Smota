<?php 
	session_start();
	date_default_timezone_set('America/Bogota');
	$conn = require '../template/sql/conexion.php';

	if($_REQUEST["accion"]=="buscar_acta"){
		$query ="SELECT ACTANUME, tecnico.TECNCODI, tecnico.TECNNOMB, ACTAFECH, ACTAESTA, ACTAVABR,ACTAVANE, ACTAOBSE
				 FROM acta
					INNER JOIN tecnico ON tecnico.TECNCODI = acta.ACTATECN
				 WHERE acta.ACTAESTA = 'G' AND acta.ACTANUME = ".$_REQUEST["cod"];
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
            	$dato0 = $row['ACTANUME'];
            	$dato1 = $row['TECNCODI'];
            	$dato2 = utf8_encode($row['TECNNOMB']);
            	$dato3 = $row['ACTAFECH'];
            	$dato4 = $row['ACTAESTA'];
            	$dato5 = number_format($row['ACTAVABR'],0,"",".");
            	$dato6 = number_format($row['ACTAVANE'],0,"",".");
            	$dato7 = $row['ACTAOBSE'];
            }   
        }
        

        $arr = array($dato0,$dato1,$dato2,$dato3,$dato4,$dato5,$dato6,$dato7);
	    echo json_encode($arr);
	}
	if($_REQUEST["accion"]=="actualizar_actas"){
		$table = '';
		$query ="SELECT acta.ACTANUME, tecnico.TECNNOMB, ACTAFECH, ACTAVANE
				 FROM acta
					INNER JOIN tecnico ON tecnico.TECNCODI = acta.ACTATECN
				 WHERE acta.ACTAESTA = 'G'";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $table .= 
                	'<tr onclick="buscarActa('.$row['ACTANUME'].')">
                		<td class="text-center">'.$row['ACTANUME'].'</td>
                		<td>'.utf8_encode($row['TECNNOMB']).'</td>
                		<td class="text-right">$ '.number_format($row['ACTAVANE'],0,"",".").'</td>
                		<td class="text-center">'.$row['ACTAFECH'].'</td>
                	</tr>';                                   
            }   
        }
        echo $table;
	}
	if($_REQUEST["accion"]=="reversar_acta"){
		$cod = $_REQUEST["cod"];
		$sw = false;
        $queryDelete = "DELETE FROM acta WHERE ACTANUME = $cod";
   		$respuestaDelete = $conn->prepare($queryDelete) or die ($queryDelete);
        if(!$respuestaDelete->execute()){
            echo 'Error!';
        }else{
            //echo 1;
            //MANOS DE OBRAS
                $queryDelete = "UPDATE mobrottr SET MOOTACTA = 0 WHERE MOOTACTA = $cod";
                $respuestaDelete = $conn->prepare($queryDelete) or die ($queryDelete);
                if(!$respuestaDelete->execute()){
                    //echo 'Error!';
                    $sw = false;
                }else{
                    //echo 1;
                    $sw = true;
                }
            //
            //NOTAS
                $queryDelete = "DELETE FROM nota WHERE NOTAACTA = $cod";
                $respuestaDelete = $conn->prepare($queryDelete) or die ($queryDelete);
                if(!$respuestaDelete->execute()){
                    //echo 'Error!';
                    $sw = false;
                }else{
                    //echo 1;
                    $sw = true;
                }
            //
        }
        if($sw){
            echo 1;
        }else{
            echo "Error!";
        }
	}
?>