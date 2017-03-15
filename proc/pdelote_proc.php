<?php 
	$conn = require '../template/sql/conexion.php';

	if($_REQUEST["accion"]=="buscar_departamento"){
        $dep = $_REQUEST["dep"];
        
        $nomb = '';
        $query ="SELECT * FROM departam WHERE DEPACODI = $dep";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $nomb = $row['DEPADESC'];
            }   
        }
        echo $nomb;
    }
    if($_REQUEST["accion"]=="buscar_localidades"){
        $dep = $_REQUEST["dep"];
        $loc = $_REQUEST["loc"];
        
        $nomb = '';
        $query ="SELECT * FROM localidad WHERE LOCADEPA = $dep AND LOCACODI = $loc";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $nomb = $row['LOCANOMB'];
            }   
        }
        echo $nomb;
    }
	if($_REQUEST["accion"]=="actualizar_localidades"){
        $dep = $_REQUEST["dep"];
        
        $table = '';
        $query ="SELECT * FROM localidad WHERE LOCADEPA = $dep";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $table .= '<tr onclick="addLocalidad('.$row['LOCACODI'].',\''.$row['LOCANOMB'].'\')">
                				<td>'.$row['LOCACODI'].'</td>
                				<td>'.$row['LOCANOMB'].'</td>
                			</tr>';
            }   
        }
        echo $table;
    }

    if($_REQUEST["accion"]=="buscar_pqr"){
        $pqr = $_REQUEST["pqr"];
        
        $nomb = '';
        $query ="SELECT * FROM pqr WHERE PQRCODI = $pqr";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $nomb = utf8_encode($row['PQRDESC']);
            }   
        }
        echo $nomb;
    }
    if($_REQUEST["accion"]=="buscar_tecnico"){
        $pqr = $_REQUEST["pqr"];
        $tec = $_REQUEST["tec"];
        
        if($pqr!=0){
        	$q_pqr = "AND PQTEPQR = $pqr";
        }else{
        	$q_pqr = "";
        }
        $nomb = '';
        $query ="SELECT * FROM pqrxtecn WHERE PQTETECN = $tec $q_pqr";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $nomb = '';
		        $queryTec ="SELECT * FROM tecnico WHERE TECNCODI = ".$tec;
		        $respuestaTec = $conn->prepare($queryTec) or die ($sql);
		        if(!$respuestaTec->execute()) return false;
		        if($respuestaTec->rowCount()>0){
		            while ($rowTec=$respuestaTec->fetch()){
		                $nomb = utf8_encode($rowTec['TECNNOMB']);
		            }   
		        }
            }   
        }
        echo $nomb;
    }
    if($_REQUEST["accion"]=="actualizar_tecnico"){
        $pqr = $_REQUEST["pqr"];
        
        $table = '';
        if($pqr!=0){
        	$q_pqr = "WHERE PQTEPQR = $pqr";
        }else{
        	$q_pqr = "";
        }
        $query ="SELECT PQTETECN FROM pqrxtecn $q_pqr GROUP BY PQTETECN";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
            	
            	$nomb = '';
		        $queryTec ="SELECT * FROM tecnico WHERE TECNCODI = ".$row['PQTETECN'];
		        $respuestaTec = $conn->prepare($queryTec) or die ($sql);
		        if(!$respuestaTec->execute()) return false;
		        if($respuestaTec->rowCount()>0){
		            while ($rowTec=$respuestaTec->fetch()){
		                $nomb = utf8_encode($rowTec['TECNNOMB']);
		            }   
		        }

                $table .= '<tr onclick="addTecnico('.$row['PQTETECN'].',\''.$nomb.'\')">
                				<td>'.$row['PQTETECN'].'</td>
                				<td>'.$nomb.'</td>
                			</tr>';
            }   
        }
        echo $table;
    }
    if($_REQUEST["accion"]=="desasignar_ordenes"){
    	$dep = $_REQUEST["dep"];
    	$loc = $_REQUEST["loc"];
    	$pqr = $_REQUEST["pqr"];
    	$tec = $_REQUEST["tec"];

    	if($pqr!=0){
    		$q_pqr = "AND OTPQRREPO = $pqr";
    	}else{
    		$q_pqr = "";
    	}

    	$query ="UPDATE ot SET OTTECN = 0, OTESTA = 0 WHERE OTDEPA=$dep AND OTLOCA=$loc AND OTTECN=$tec $q_pqr";
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
    }
?>