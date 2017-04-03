<?php 
	session_start();
	date_default_timezone_set('America/Bogota');
	$conn = require '../template/sql/conexion.php';

	//buscar
	if($_REQUEST["accion"]=="buscar_departamento"){
        $dep = $_REQUEST["id"];
        
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
    if($_REQUEST["accion"]=="buscar_localidad"){
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
    if($_REQUEST["accion"]=="buscar_zona"){
        $dep = $_REQUEST["dep"];
        $loc = $_REQUEST["loc"];
        $zon = $_REQUEST["zon"];
        
        $nomb = '';
        $query ="SELECT * FROM zonas WHERE ZONADEPA = $dep AND ZONALOCA = $loc AND ZONACODI = $zon AND ZONAVISI = 1";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $nomb = $row['ZONANOMB'];
            }   
        }
        echo $nomb;
    }
    if($_REQUEST["accion"]=="buscar_sector"){
        $dep = $_REQUEST["dep"];
        $loc = $_REQUEST["loc"];
        $zon = $_REQUEST["zon"];
        $sec = $_REQUEST["sec"];
        
        $nomb = '';
        $query ="SELECT * FROM seopzoop WHERE SEZODEPA = $dep AND SEZOLOCA = $loc AND SEZOZOOP = $zon AND SEZOSEOP = $sec";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){

            	$sector = '';
            	$querySect = "SELECT * FROM sectores WHERE SEOPCODI = ".$row['SEZOSEOP'];
            	$respuestaSect = $conn->prepare($querySect) or die ($sql);
            	if(!$respuestaSect->execute()) return false;
		        if($respuestaSect->rowCount()>0){
		        	while ($rowSect=$respuestaSect->fetch()){
		        		$nomb = $rowSect['SEOPNOMB'];
		        	}
		        }

            }   
        }
        echo $nomb;
    }
    if($_REQUEST["accion"]=="buscar_pqr"){
        $pqr = $_REQUEST["id"];
        
        $nomb = '';
        $query ="SELECT * FROM pqr WHERE PQRCODI = $pqr";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $nomb = $row['PQRDESC'];
            }   
        }
        echo $nomb;
    }
    if($_REQUEST["accion"]=="buscar_tecnico"){
        $pqr = $_REQUEST["pqr"];
        $tec = $_REQUEST["tec"];
        
        $nomb = '';
        $query ="SELECT * FROM pqrxtecn WHERE PQTEPQR = $pqr AND PQTETECN = $tec";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){

            	$sector = '';
            	$querySect = "SELECT * FROM tecnico WHERE TECNCODI = ".$row['PQTETECN'];
            	$respuestaSect = $conn->prepare($querySect) or die ($sql);
            	if(!$respuestaSect->execute()) return false;
		        if($respuestaSect->rowCount()>0){
		        	while ($rowSect=$respuestaSect->fetch()){
		        		$nomb = utf8_encode($rowSect['TECNNOMB']);
		        	}
		        }

            }   
        }
        echo $nomb;
    }
    if($_REQUEST["accion"]=="buscar_cuadrilla"){
        $cuad = $_REQUEST["id"];
        
        $nomb = '';
        $query ="SELECT * FROM cuadrilla WHERE CUADCODI = $cuad";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $nomb = $row['CUADNOMB'];
            }   
        }
        echo $nomb;
    }
    if($_REQUEST["accion"]=="buscar_estado"){
        $est = $_REQUEST["id"];
        
        $nomb = '';
        $query ="SELECT * FROM estaot WHERE ESOTCODI = $est";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $nomb = $row['ESOTDESC'];
            }   
        }
        echo $nomb;
    }
    if($_REQUEST["accion"]=="buscar_usuario"){
        $usu = $_REQUEST["id"];
        
        $nomb = '';
        $query ="SELECT * FROM usuarios WHERE USUCODI = $usu";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $nomb = $row['USUNOMB'];
            }   
        }
        echo $nomb;
    }
    //actualizar
	if($_REQUEST["accion"]=="actualizar_localidades"){
        $dep = $_REQUEST["dep"];
        
        $table = '';
        $query ="SELECT * FROM localidad WHERE LOCADEPA = $dep";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $table .= '<tr onclick="addLocalidad('.$row['LOCACODI'].',\''.$row['LOCANOMB'].'\')">
                				<td class="text-center">'.$row['LOCACODI'].'</td>
                				<td>'.$row['LOCANOMB'].'</td>
                			</tr>';
            }   
        }
        echo $table;
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
                $table .= '<tr onclick="addZona('.$row['ZONACODI'].',\''.$row['ZONANOMB'].'\')">
                				<td class="text-center">'.$row['ZONACODI'].'</td>
                				<td>'.$row['ZONANOMB'].'</td>
                			</tr>';
            }   
        }
        echo $table;
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
            	$sector = '';
            	$querySect = "SELECT * FROM sectores WHERE SEOPCODI = ".$row['SEZOSEOP'];
            	$respuestaSect = $conn->prepare($querySect) or die ($sql);
            	if(!$respuestaSect->execute()) return false;
		        if($respuestaSect->rowCount()>0){
		        	while ($rowSect=$respuestaSect->fetch()){
		        		$sector = $rowSect['SEOPNOMB'];
		        	}
		        }
                $table .= '<tr onclick="addSector('.$row['SEZOSEOP'].',\''.$sector.'\')">
                				<td>'.$row['SEZOSEOP'].'</td>
                				<td>'.$sector.'</td>
                			</tr>';
            }   
        }
        echo $table;
    }
    if($_REQUEST["accion"]=="actualizar_tecnico"){
        $pqr = $_REQUEST["pqr"];
        
        $table = '';
        $query ="SELECT tecnico.TECNCODI, tecnico.TECNNOMB 
				 FROM pqrxtecn
				 INNER JOIN tecnico ON pqrxtecn.PQTETECN = tecnico.TECNCODI
				 WHERE pqrxtecn.PQTEPQR = $pqr AND tecnico.TECNESTA ='A' ";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $table .= '<tr onclick="addTecnico(\''.$row['TECNCODI'].'\',\''.utf8_encode($row['TECNNOMB']).'\')">
                        		<td class="text-center">'.$row['TECNCODI'].'</td>
                        		<td>'.utf8_encode($row['TECNNOMB']).'</td>
                        	</tr>';
			}   
        }
        echo $table;
    }
    //
    if($_REQUEST["accion"]=="realizar_ordenamieno"){
    	$table = '
    			<table class="table table-condensed table-bordered table-striped">
        			<tr style="background-color: #3c8dbc; color:white;">
        				<th class="text-center" width="100">NRO DE ORDEN</th>
	    				<th class="text-center" width="70">FECHA</th>
	    				<th class="text-center" width="70">PQR</th>
	    				<th class="text-center" width="100">TECNICO</th>
	    				<th class="text-left" width="100">USUARIO</th>
	    				<th class="text-left" width="100">OBSERVACION</th>
	    				<th class="text-left" width="100">ESTADO</th>
	    				<th class="text-left" width="100">DIRECCION</th>
	    				<th class="text-center" width="100">SECTOR</th>
        			</tr>
        		';
    	$dep = $_REQUEST["dep"];
        $loc = $_REQUEST["loc"];
        $zon = $_REQUEST["zon"];
        $sec = $_REQUEST["sec"];
        $pqr = $_REQUEST["pqr"];
        $tec = $_REQUEST["tec"];
        $cua = $_REQUEST["cua"];
        $est = $_REQUEST["est"];
        $fin = $_REQUEST["fin"];
        $ffi = $_REQUEST["ffi"];
        $usu = $_REQUEST["usu"];

        $critOrd = $_REQUEST["critOrd"];

        //VALIDAMOS CRITERIOS
	        $orderby = "";
	        switch ($critOrd){
	        	case 1: //DIRECCION
	        		$orderby = "ORDER BY usuarios.USUDIRE";
	        	break;
	        	case 2: //RUTA
	        		$orderby = "ORDER BY usuarios.USURUTA";
	        	break;
	        	case 3: //FECHA
	        		$orderby = "ORDER BY ot.OTFEORD";
	        	break;
	        	case 4: //PQR
	        		$orderby = "ORDER BY ot.OTPQRREPO";
	        	break;
	        	case 5: //SECTOR
	        		$orderby = "ORDER BY usuarios.USUSEOP";
	        	break;
	        	case 6: //USUARIO
	        		$orderby = "ORDER BY usuarios.USUNOMB";
	        	break;
	        }

        //CREAR WHERE
	        $wSec = "";
	        if($sec!=""){ $wSec = "AND usuarios.USUSEOP = $sec"; }
	        $wPqr = "";
	        if($pqr!=""){ $wPqr = "AND ot.OTPQRREPO = $pqr"; }
	        $wTec = "";
	        if($tec!=""){ $wTec = "AND ot.ottecn = $tec"; }
	        $wEst = "";
	        if($est!=""){ $wEst = "AND ot.OTESTA = $est"; }
	        $wUsu = "";
	        if($usu!=""){ $wUsu = "AND ot.OTUSUARIO = $usu"; }

	        $where = "WHERE ot.OTDEPA = $dep AND ot.OTLOCA = $loc $wSec $wPqr $wTec $wEst $wUsu AND (OTFEORD >= '$fin' AND OTFEORD <= '$ffi')";
	        
        $i=0;
        $query ="SELECT ot.OTDEPA,ot.OTLOCA,ot.OTNUME,ot.OTFEORD,ot.OTPQRREPO,ot.OTTECN,ot.OTUSUARIO,usuarios.USUNOMB,ot.OTOBSEAS,estaot.ESOTDESC,usuarios.USUDIRE,usuarios.USUSEOP 
				 FROM ot
				 INNER JOIN usuarios ON usuarios.USUCODI = ot.OTUSUARIO
				 INNER JOIN estaot ON estaot.ESOTCODI = ot.OTESTA
				 $where
				 $orderby";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()) {
                $table .= ' <tr id="trSelect'.$i.'" class="trDefault" onclick="swEditor(\'trSelect'.$i.'\')" ondblclick="enviarOrden('.$row['OTNUME'].','.$row["OTUSUARIO"].')">
                				<td class="text-center">
                					'.$row['OTDEPA'].'-'.$row['OTLOCA'].'-'.$row['OTNUME'].'
                					<input type="hidden" id="txtHiddenDepa'.$i.'" value="'.$row['OTDEPA'].'">
                					<input type="hidden" id="txtHiddenLoca'.$i.'" value="'.$row['OTLOCA'].'">
                					<input type="hidden" id="txtHiddenOrde'.$i.'" value="'.$row['OTNUME'].'">
                				</td>
                				<td class="text-center">'.$row['OTFEORD'].'</td>
                				<td class="text-center">'.$row['OTPQRREPO'].'</td>
                				<td class="text-center">'.$row['OTTECN'].'</td>
                				<td class="text-left">'.$row['USUNOMB'].'</td>
                				<td class="text-left">'.utf8_encode($row['OTOBSEAS']).'</td>
                				<td class="text-left">'.$row['ESOTDESC'].'</td>
                				<td class="text-left">'.$row['USUDIRE'].'</td>
                				<td class="text-center">'.$row['USUSEOP'].'</td>
                			</tr>';
            	$i++;
            }   
        }
        $table .= '</table>';
        echo $table;
    }
?>