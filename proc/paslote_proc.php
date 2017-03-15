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
    if($_REQUEST["accion"]=="buscar_tecnico"){
        $cod = $_REQUEST["cod"];
        
        $nomb = '';
        $query ="SELECT * FROM tecnico WHERE TECNCODI = $cod AND TECNESTA='A'";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $nomb = $row['TECNNOMB'];
            }   
        }
        echo $nomb;
    }
    if($_REQUEST["accion"]=="buscar_pqr"){
        $cod = $_REQUEST["cod"];
        
        if($cod!=0){
	        $nomb = '';
	        $query ="SELECT * FROM pqr WHERE PQRCODI = $cod";
	        $respuesta = $conn->prepare($query) or die ($sql);
	        if(!$respuesta->execute()) return false;
	        if($respuesta->rowCount()>0){
	            while ($row=$respuesta->fetch()){
	                $nomb = $row['PQRDESC'];
	            }   
	        }
	        echo $nomb;
        }else{
        	echo 'Todos';
        }
    }
    if($_REQUEST["accion"]=="actualizar_zonas"){
        $dep = $_REQUEST["dep"];
        $loc = $_REQUEST["loc"];
        
        $table = '';
        $query ="SELECT * FROM zonas WHERE ZONADEPA = $dep AND ZONALOCA = $loc AND ZONAVISI = 1";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $table .= '<tr onclick="addZonas('.$row['ZONACODI'].',\''.$row['ZONANOMB'].'\')">
                				<td>'.$row['ZONACODI'].'</td>
                				<td>'.$row['ZONANOMB'].'</td>
                			</tr>';
            }   
        }
        echo $table;
    }
    if($_REQUEST["accion"]=="buscar_zonas"){
    	$dep = $_REQUEST["dep"];
        $loc = $_REQUEST["loc"];
        $cod = $_REQUEST["cod"];
        
        $nomb = '';
        $query ="SELECT * FROM zonas WHERE ZONADEPA = $dep AND ZONALOCA = $loc AND ZONACODI = $cod";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $nomb = $row['ZONANOMB'];
            }   
        }
        echo $nomb;
    }
    if($_REQUEST["accion"]=="actualizar_sectores"){
        $dep = $_REQUEST["dep"];
        $loc = $_REQUEST["loc"];
        $zon = $_REQUEST["zon"];
        
        $table = '';
        $query ="SELECT * FROM seopzoop WHERE SEZODEPA = $dep AND SEZOLOCA = $loc AND SEZOZOOP = $zon AND SEZOVISI = 1";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){

            	//Obtener nombre del sector
            		$nomb = '';
			        $querySec ="SELECT * FROM sectores WHERE SEOPCODI = ".$row['SEZOSEOP'];
			        $respuestaSec = $conn->prepare($querySec) or die ($sql);
			        if(!$respuestaSec->execute()) return false;
			        if($respuestaSec->rowCount()>0){
			            while ($rowSec=$respuestaSec->fetch()){
			                $nomb = $rowSec['SEOPNOMB'];
			            }   
			        }
			    //Fin Obtener nombre del sector

                $table .= '<tr onclick="addSector('.$row['SEZOSEOP'].',\''.$nomb.'\')">
                				<td>'.$row['SEZOSEOP'].'</td>
                				<td>'.$nomb.'</td>
                			</tr>';
            }   
        }
        echo $table;
    }
    if($_REQUEST["accion"]=="buscar_sector"){
    	$dep = $_REQUEST["dep"];
        $loc = $_REQUEST["loc"];
        $zon = $_REQUEST["zon"];
        $cod = $_REQUEST["cod"];
        
        if($cod!=0){
	        $nomb = '';
	        $query ="SELECT * FROM seopzoop WHERE SEZODEPA = $dep AND SEZOLOCA = $loc AND SEZOZOOP = $zon AND SEZOSEOP = $cod AND SEZOVISI = 1";
	        $respuesta = $conn->prepare($query) or die ($sql);
	        if(!$respuesta->execute()) return false;
	        if($respuesta->rowCount()>0){
	            while ($row=$respuesta->fetch()){

	            	//Obtener nombre del sector
				        $querySec ="SELECT * FROM sectores WHERE SEOPCODI = ".$row['SEZOSEOP'];
				        $respuestaSec = $conn->prepare($querySec) or die ($sql);
				        if(!$respuestaSec->execute()) return false;
				        if($respuestaSec->rowCount()>0){
				            while ($rowSec=$respuestaSec->fetch()){
				                $nomb = $rowSec['SEOPNOMB'];
				            }   
				        }
				    //Fin Obtener nombre del sector

	            }   
	        }
	        echo $nomb;
        }else{
	        echo 'Todos';
        }
    }
    if($_REQUEST["accion"]=="asignar_ordenes"){
    	$dep = $_REQUEST["dep"];
    	$loc = $_REQUEST["loc"];
    	$zon = $_REQUEST["zon"]; //
    	$cant = $_REQUEST["cant"];
    	$tec = $_REQUEST["tec"];
    	$obs = $_REQUEST["obs"];

    	//Sectores
    	if($_REQUEST["sec"]!=0){
    		$codSec = $_REQUEST["sec"];
    		$sec = 'AND USUSEOP = '.$_REQUEST["sec"];
    	}else{ $sec=''; }
    	//Pqr
    	if($_REQUEST["pqr"]!=0){
    		$pqr = 'AND OTPQRREPO = '.$_REQUEST["pqr"];
    	}else{ $pqr=''; }

    	//Realizamos Consulta
    	$query ="SELECT * FROM ot WHERE OTESTA = 1 AND OTDEPA = $dep AND OTLOCA = $loc $pqr LIMIT $cant";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $num = $row['OTNUME'];
                $usu = $row['OTUSUARIO'];
                //Filtrar usuario x sector
                $queryU ="SELECT * FROM usuarios WHERE USUCODI = $usu $sec";
		        $respuestaU = $conn->prepare($queryU) or die ($sql);
		        if(!$respuestaU->execute()) return false;
		        if($respuestaU->rowCount()>0){
		            while ($rowU=$respuestaU->fetch()){
				        $nomUsu = $rowU['USUNOMB'];
		                //Filtrar zona x sector
		            	$queryZ ="SELECT * FROM seopzoop WHERE SEZOSEOP = $codSec AND SEZOZOOP = $zon ";
				        $respuestaZ = $conn->prepare($queryZ) or die ($sql);
				        if(!$respuestaZ->execute()) return false;
				        if($respuestaZ->rowCount()>0){
				            while ($rowZ=$respuestaZ->fetch()){
				                //Asignamos ordenes
									$queryOr ="UPDATE ot SET OTTECN = $tec, OTOBSERVAS = '$obs' WHERE OTDEPA = $dep AND OTLOCA = $loc AND OTNUME = $num";
							        $respuestaOr = $conn->prepare($queryOr) or die ($queryOr);
							        if(!$respuestaOr->execute()){
							            echo 'Error!';
							        }else{
							            echo 1;
							        }				            		
		                		//End Asignar ordenes
				            }
				        }//End Consulta Zona x sector
		            }
		        }//End Consulta usuarios x sector
            } 
        }//End Consulta ordenes

    }
?>