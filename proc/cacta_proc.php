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
        $query ="SELECT CONCAT(mobrottr.MOOTDEPA,'-',mobrottr.MOOTLOCA,'-',mobrottr.MOOTNUMO) AS CODIOT,
					CONCAT(manobra.MOBRCODI,'-',manobra.MOBRDESC) AS MANOBR, ot.OTUSUARIO,
					CONCAT(pqr.PQRCODI,'-',pqr.PQRDESC) AS PQRENC, mobrottr.MOOTCANT, 
					mobrottr.MOOTVAPA, mobrottr.MOOTFECH
				FROM mobrottr 
					JOIN manobra ON manobra.MOBRCODI = mobrottr.MOOTMOBR
					JOIN ot ON ot.OTNUME = mobrottr.MOOTNUMO
					JOIN pqr ON pqr.PQRCODI = ot.OTPQRENCO
				WHERE mobrottr.MOOTACTA = $act
				ORDER BY mobrottr.MOOTFECH";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
            	
                $table .= '
                		<tr>
                			<td class="text-center">'.$row['CODIOT'].'</td>
                			<td class="text-left">'.utf8_encode($row['MANOBR']).'</td>
                			<td class="text-center">'.$row['OTUSUARIO'].'</td>
                			<td class="text-left">'.utf8_encode($row['PQRENC']).'</td>
                			<td class="text-right">'.$row['MOOTCANT'].'</td>
                			<td class="text-right">$'.number_format($row['MOOTVAPA'],0,"",".").'</td>
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
                			<td class="text-left">'.$row['CLNOCODI'].'-'.utf8_encode($row['CLNODESC']).'</td>
                			<td class="text-center">'.$row['NOTAFECH'].'</td>
                			<td class="text-center">'.$row['NOTASIGN'].'</td>
                			<td class="text-right">$ '.number_format($row['NOTAVALO'],0,'.','.').'</td>
                		</tr>';
            }   
        }
        echo $table;
    }
?>