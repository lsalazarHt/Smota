<?php 
	$conn = require '../template/sql/conexion.php';

	if($_REQUEST["accion"]=="buscar_acta"){
        $act = $_REQUEST["act"];
        
        $cTec = '';
        $nTec = '';
        $query ="SELECT acta.*, tecnico.TECNNOMB
				 FROM acta
				 INNER JOIN tecnico ON tecnico.TECNCODI = acta.ACTATECN 
				 WHERE acta.ACTANUME = $act";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $cTec = $row['ACTATECN'];
                $nTec = utf8_encode($row['TECNNOMB']);
                $fech = $row['ACTAFECH'];
                $esta = $row['ACTAESTA'];
                $vBru = number_format($row['ACTAVABR'],0,'.','.');
                $vNet = number_format($row['ACTAVANE'],0,'.','.');
                $obsr = $row['ACTAOBSE'];
            }   
        }
        $arr = array($cTec,$nTec,$fech,$esta,$vBru,$vNet,$obsr);
        echo json_encode($arr);
    }

    if($_REQUEST["accion"]=="buscar_mano_obra_acta"){
        $act = $_REQUEST["act"];
        
        $table = '';
        $query ="SELECT mobrottr.MOOTDEPA, mobrottr.MOOTLOCA, mobrottr.MOOTNUMO, mobrottr.MOOTUSER, 
        			manobra.MOBRCODI, manobra.MOBRDESC, mobrottr.MOOTCANT, mobrottr.MOOTVASU,
        			mobrottr.MOOTFECH
				 FROM mobrottr 
					INNER JOIN manobra ON manobra.MOBRCODI = mobrottr.MOOTMOBR
				 WHERE mobrottr.MOOTACTA = $act";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
            	//OBTENER PQR DE LA ORDEN
            		$codPqr ="";
            		$nomPqr ="";
            		$query = 'SELECT ot.OTPQRENCO, pqr.PQRDESC
								FROM ot INNER JOIN pqr ON pqr.PQRCODI = ot.OTPQRENCO
								WHERE ot.OTDEPA = 76 AND ot.OTLOCA = 1 AND ot.OTNUME = 28122118';
			        $respuestaPqr = $conn->prepare($query) or die ($sql);
			        if(!$respuestaPqr->execute()) return false;
			        if($respuestaPqr->rowCount()>0){
			            while ($rowPqr=$respuestaPqr->fetch()){
			            	$codPqr = $rowPqr['OTPQRENCO'];
			            	$nomPqr = $rowPqr['PQRDESC'];
			            }
			        }
            	//
                $table .= '
                		<tr>
                			<td class="text-center">'.$row['MOOTDEPA'].' - '.$row['MOOTLOCA'].' - '.$row['MOOTNUMO'].'</td>
                			<td class="text-center">'.$row['MOBRCODI'].'</td>
                			<td>'.utf8_encode($row['MOBRDESC']).'</td>
                			<td class="text-center">'.$row['MOOTUSER'].'</td>
                			<td class="text-center">'.$codPqr.'</td>
                			<td>'.utf8_encode($nomPqr).'</td>
                			<td class="text-center">'.$row['MOOTCANT'].'</td>
                			<td class="text-right">$ '.number_format($row['MOOTVASU'],0,'.','.').'</td>
                			<td class="text-center">'.$row['MOOTFECH'].'</td>
                		</tr>';
            }   
        }
        echo $table;
    }

    if($_REQUEST["accion"]=="buscar_notas_acta"){
        $act = $_REQUEST["act"];
        
        $table = '';
        $query ="SELECT nota.NOTACODI, clasnota.CLNOCODI,clasnota.CLNODESC, nota.NOTAFECH, nota.NOTASIGN, nota.NOTAVALO
				 FROM nota
				 INNER JOIN clasnota ON clasnota.CLNOCODI = nota.NOTACLAS
				 WHERE nota.NOTAACTA = $act";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $table .= '
                		<tr>
                			<td class="text-center">'.$row['NOTACODI'].'</td>
                			<td class="text-center">'.$row['CLNOCODI'].'</td>
                			<td>'.utf8_encode($row['CLNODESC']).'</td>
                			<td class="text-center">'.$row['NOTAFECH'].'</td>
                			<td class="text-center">'.$row['NOTASIGN'].'</td>
                			<td class="text-right">$ '.number_format($row['NOTAVALO'],0,'.','.').'</td>
                		</tr>';
            }   
        }
        echo $table;
    }
?>