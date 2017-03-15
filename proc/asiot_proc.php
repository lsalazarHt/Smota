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
    if($_REQUEST["accion"]=="obtener_orden"){
        $dep = $_REQUEST["dep"];
        $loc = $_REQUEST["loc"];
        $num = $_REQUEST["num"];
        //
        $sw=0;
        $codTecOt = '';
        $codUser = '';
        $pqrReport = '';
        $fechAsig = '';
        $fechRecib = '';
        $fechCump = '';
        $obs = '';
        $numTecn='';
        $numPqrRepor='';
        $nomUser='';

        $query ="SELECT * FROM ot WHERE OTDEPA = $dep AND OTLOCA = $loc AND OTNUME = $num AND OTESTA = 0";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                    $sw=1;
                    $codTecOt = $row['OTTECN'];
                    $codUser = $row['OTUSUARIO'];
                    $pqrReport = $row['OTPQRREPO'];
                    $fechAsig = $row['OTFEAS'];
                    $fechRecib = $row['OTFERECI'];
                    $fechCump = $row['OTCUMP'];
                    $obs = $row['OTOBSERVAS'];
                }
            }

        $numTecn='';
        if($codTecOt!=''){
            $query ="SELECT * FROM tecnico WHERE TECNCODI = $codTecOt";
                $respuesta = $conn->prepare($query) or die ($sql);
                if(!$respuesta->execute()) return false;
                if($respuesta->rowCount()>0){
                    while ($row=$respuesta->fetch()){
                        $numTecn = utf8_encode($row['TECNNOMB']);                              
                    }   
                }
        }

        $numPqrRepor='';
        if($pqrReport!=''){
            $query ="SELECT * FROM pqr WHERE PQRCODI = $pqrReport";
                $respuesta = $conn->prepare($query) or die ($sql);
                if(!$respuesta->execute()) return false;
                if($respuesta->rowCount()>0){
                    while ($row=$respuesta->fetch()){
                        $numPqrRepor = $row['PQRDESC'];                              
                    }   
                }
        }

        $nomUser='';
        $direccionUser='';
        if($codUser!=''){
            $query ="SELECT * FROM usuarios WHERE USUCODI = $codUser";
                $respuesta = $conn->prepare($query) or die ($sql);
                if(!$respuesta->execute()) return false;
                if($respuesta->rowCount()>0){
                    while ($row=$respuesta->fetch()){
                        $nomUser = $row['USUNOMB'];                              
                        $direccionUser = $row['USUDIRE'];                              
                    }   
                }
        }
        
        $arr = array($codUser,$nomUser,$direccionUser,$pqrReport,$numPqrRepor,$fechRecib,$fechAsig,$fechCump,$codTecOt,$numTecn,$obs,$sw);
        echo json_encode($arr);
    }
    if($_REQUEST["accion"]=="guardar_orden"){
        $dep = $_REQUEST["dep"];
        $loc = $_REQUEST["loc"];
        $num = $_REQUEST["num"];
        
        $fAg = $_REQUEST["fAg"];
        $tec = $_REQUEST["tec"];
        $obs = $_REQUEST["obs"];

        $query ="UPDATE ot set OTFEAS = '$fAg', OTTECN = $tec, OTOBSERVAS = '$obs', OTESTA = 1
                    WHERE OTDEPA = $dep AND OTLOCA = $loc AND OTNUME = $num";
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
    }
    if($_REQUEST["accion"]=="buscar_tecnico"){
        $cod = $_REQUEST["cod"];
        
        $nomb = '';
        $query ="SELECT * FROM tecnico WHERE TECNCODI = $cod";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $nomb = utf8_encode($row['TECNNOMB']);
            }   
        }
        echo $nomb;
    }

?>