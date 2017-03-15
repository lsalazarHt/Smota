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
                				<td>'.$row['ZONACODI'].'</td>
                				<td>'.$row['ZONANOMB'].'</td>
                			</tr>';
            }   
        }
        echo $table;
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
    if($_REQUEST["accion"]=="buscar_sector"){
        $dep = $_REQUEST["dep"];
        $loc = $_REQUEST["loc"];
        $zon = $_REQUEST["zon"];
        $sec = $_REQUEST["sec"];
        
        $nomb = '';
        $query ="SELECT * FROM seopzoop WHERE SEZODEPA = $dep AND SEZOLOCA = $loc AND SEZOZOOP = $zon AND SEZOVISI = 1";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
            	//OBTENER NOMBRE DEL SECTOR
	            	$querySect = "SELECT * FROM sectores WHERE SEOPCODI = ".$sec;
	            	$respuestaSect = $conn->prepare($querySect) or die ($sql);
	            	if(!$respuestaSect->execute()) return false;
			        if($respuestaSect->rowCount()>0){
			        	while ($rowSect=$respuestaSect->fetch()){
			        		$nomb = $rowSect['SEOPNOMB'];
			        	}
			        }
		        //END OTENER NOMBRE DEL SECTOR
            }   
        }
        echo $nomb;
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
        $tec = $_REQUEST["tec"];
        
        $nomb = '';
        $query ="SELECT * FROM tecnico WHERE TECNCODI = $tec";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $nomb = utf8_encode($row['TECNNOMB']);
            }   
        }
        echo $nomb;
    }
    if($_REQUEST["accion"]=="realizar_ordenamieno"){
    	$table = '
    			<table class="table table-bordered table-condensed">
        			<tr style="background-color: #3c8dbc; color:white;">
        				<th class="text-center" width="100">NUMERO DE ORDEN</th>
        				<th class="text-center" width="70">FECHA</th>
        				<th class="text-center" width="70">PQR</th>
        				<th class="text-center" width="70">RUTA</th>
        				<th class="text-center" width="100">USUARIO</th>
        				<th class="text-center" width="100">OBSERVACION</th>
        				<th class="text-center" width="100">DIRECCION</th>
        				<th class="text-center" width="100">SECTOR</th>
        				<th class="text-center" width="10"><input type="checkbox" id="txtCheckTodosP" onclick="selectTodos()"></th>
        			</tr>
        		';
    	$dep = $_REQUEST["dep"];
        $loc = $_REQUEST["loc"];
        $zon = $_REQUEST["zon"];
        $sec = $_REQUEST["sec"];
        $pqr = $_REQUEST["pqr"];
        $tec = $_REQUEST["tec"];
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
        if($sec!=0){

        	$wSec = "AND usuarios.USUSEOP = $sec";
        }
        $wPqr = "";
        if($pqr!=0){

        	$wPqr = "AND ot.OTPQRREPO = $pqr";
        }
        $where = "WHERE ot.OTDEPA = $dep AND ot.OTLOCA = $loc $wSec $wPqr AND ot.OTESTA=0";
        
        $i=0;
        $query ="SELECT ot.OTDEPA,ot.OTLOCA,ot.OTNUME,ot.OTFEORD,ot.OTPQRREPO,usuarios.USURUTA,usuarios.USUNOMB,ot.OTOBSEAS,usuarios.USUDIRE,usuarios.USUSEOP 
				 FROM ot
				 INNER JOIN usuarios ON usuarios.USUCODI = ot.OTUSUARIO
				 $where
				 $orderby";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $table .= '<tr id="trSelect'.$i.'" class="trDefault" onclick="swEditor(\'trSelect'.$i.'\')">
                				<td>
                					'.$row['OTDEPA'].'-'.$row['OTLOCA'].'-'.$row['OTNUME'].'
                					<input type="hidden" id="txtHiddenDepa'.$i.'" value="'.$row['OTDEPA'].'">
                					<input type="hidden" id="txtHiddenLoca'.$i.'" value="'.$row['OTLOCA'].'">
                					<input type="hidden" id="txtHiddenOrde'.$i.'" value="'.$row['OTNUME'].'">
                				</td>
                				<td>'.$row['OTFEORD'].'</td>
                				<td>'.$row['OTPQRREPO'].'</td>
                				<td>'.$row['USURUTA'].'</td>
                				<td>'.$row['USUNOMB'].'</td>
                				<td>'.utf8_encode($row['OTOBSEAS']).'</td>
                				<td>'.$row['USUDIRE'].'</td>
                				<td>'.$row['USUSEOP'].'</td>
                				<td class="text-center"><input type="checkbox" id="txtCheck'.$i.'"></td>
                			</tr>';
            	$i++;
            }   
        }
        echo $table.'</table><input type="hidden" id="contRow" value="'.($i-1).'">';
    }
    if($_REQUEST["accion"]=="limpiar_tabla"){
    	$table = '
    			<table class="table table-bordered table-condensed">
        			<tr style="background-color: #3c8dbc; color:white;">
        				<th class="text-center" width="100">NUMERO DE ORDEN</th>
        				<th class="text-center" width="70">FECHA</th>
        				<th class="text-center" width="70">PQR</th>
        				<th class="text-center" width="70">RUTA</th>
        				<th class="text-center" width="100">USUARIO</th>
        				<th class="text-center" width="100">OBSERVACION</th>
        				<th class="text-center" width="100">DIRECCION</th>
        				<th class="text-center" width="100">SECTOR</th>
        				<th class="text-center" width="10"><input type="checkbox" onclick="selectTodos()"></th>
        			</tr>
        		';
        echo $table.'</table>';
    }
    if($_REQUEST["accion"]=="asignar_orden"){
    	$dep = $_REQUEST["dep"];
    	$loc = $_REQUEST["loc"];
    	$ord = $_REQUEST["ord"];
    	$tec = $_REQUEST["tec"];

    	$query ="UPDATE ot SET OTTECN = $tec,OTESTA = 1 WHERE OTDEPA=$dep AND OTLOCA=$loc AND OTNUME=$ord";
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
    }
?>