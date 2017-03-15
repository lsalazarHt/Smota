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
    if($_REQUEST["accion"]=="buscar_causaNoAtencion"){
        $cod = $_REQUEST["cod"];
        
        $nomb = '';
        $query ="SELECT * FROM causnoaten WHERE CANAESTA = 'A' AND CANACODI = $cod";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $nomb = utf8_encode($row['CANADESC']);
            }   
        }
        echo $nomb;
    }
    if($_REQUEST["accion"]=="buscar_orden"){
        $dep = $_REQUEST["dep"];
        $loc = $_REQUEST["loc"];
        $ord = $_REQUEST["ord"];
        
        $pqr = '';
        $tec = '';
        $fec = '';
        $est = '';
        $query ="SELECT OTPQRREPO,OTTECN,OTFEAS,OTESTA FROM ot WHERE OTDEPA = $dep AND OTLOCA = $loc AND OTNUME = $ord AND OTESTA=1";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $pqr = $row['OTPQRREPO'];
                $tec = $row['OTTECN'];
                $fec = $row['OTFEAS'];
                $est = $row['OTESTA'];
            }   
        }

        //PQR
        $nombPqr = '';
        if($pqr!=''){
        	$query ="SELECT * FROM pqr WHERE PQRCODI = $pqr";
	        $respuesta = $conn->prepare($query) or die ($sql);
	        if(!$respuesta->execute()) return false;
	        if($respuesta->rowCount()>0){
	            while ($row=$respuesta->fetch()){
	                $nombPqr = utf8_encode($row['PQRDESC']);
	            }   
	        }
        }
        //TENICO
        $nombTec = '';
        if( ($tec!='') || ($tec!=0) ){
        	$query ="SELECT * FROM tecnico WHERE TECNCODI = $tec";
	        $respuesta = $conn->prepare($query) or die ($sql);
	        if(!$respuesta->execute()) return false;
	        if($respuesta->rowCount()>0){
	            while ($row=$respuesta->fetch()){
	                $nombTec = utf8_encode($row['TECNNOMB']);
	            }   
	        }
        }
        if( $tec==0 ){ $tec=''; }

        $arr = array($pqr,$nombPqr,$tec,$nombTec,$fec,$est);
        echo json_encode($arr);
    }
    if($_REQUEST["accion"]=="incumplir_orden"){
    	$dep = $_REQUEST["dep"];
    	$loc = $_REQUEST["loc"];
    	$ord = $_REQUEST["ord"];
    	$cna = $_REQUEST["cna"];
    	$obs = $_REQUEST["obs"];

    	$query ="UPDATE ot SET OTESTA = 2, OTCANOA = $cna, OTOBSERVAS= '$obs' WHERE OTDEPA=$dep AND OTLOCA=$loc AND OTNUME=$ord";
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
    }
?>