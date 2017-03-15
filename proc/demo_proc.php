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
    if($_REQUEST["accion"]=="actualizar_sectores"){
    	$dep = $_REQUEST["dep"];
    	$loc = $_REQUEST["loc"];

		$table='';
        $i=0;
		$query ='SELECT DISTINCT SEOPCODI,SEOPNOMB,SEOPVISI 
				 FROM sectores
				 INNER JOIN departam ON departam.DEPACODI = sectores.SEOPDEPA
				 JOIN localidad ON localidad.LOCACODI = sectores.SEOPLOCA
				 WHERE SEOPDEPA = '.$dep.' AND SEOPLOCA = '.$loc.' AND DEPAVISI = 1 AND LOCAVISI = 1
				 	AND SEOPCODI!=-1
				 ORDER BY SEOPNOMB';
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $table .= '<tr onclick="addSector('.$row['SEOPCODI'].',\''.utf8_encode($row['SEOPNOMB']).'\')">
                				<td>'.$row['SEOPCODI'].'</td>
                				<td>'.utf8_encode($row['SEOPNOMB']).'</td>
                			</tr>';
            }   
        }
        echo $table;
	}
	if($_REQUEST["accion"]=="buscar_sector"){
    	$dep = $_REQUEST["dep"];
    	$loc = $_REQUEST["loc"];
    	$sec = $_REQUEST["sec"];

		$nomb='';
		$query ='SELECT DISTINCT SEOPCODI,SEOPNOMB,SEOPVISI 
				 FROM sectores
				 INNER JOIN departam ON departam.DEPACODI = sectores.SEOPDEPA
				 JOIN localidad ON localidad.LOCACODI = sectores.SEOPLOCA
				 WHERE SEOPDEPA = '.$dep.' AND SEOPLOCA = '.$loc.' AND DEPAVISI = 1 AND LOCAVISI = 1
				 	AND SEOPCODI = '.$sec.' AND SEOPCODI!=-1
				 ORDER BY SEOPNOMB';
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $nomb = $row['SEOPNOMB'];
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
        				<th class="text-center" width="10"><input type="checkbox"></th>
        			</tr>
        		';
        echo $table.'</table>';
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
        				<th class="text-center" width="10"><input type="checkbox" onclick="selectTodos()"></th>
        			</tr>
        		';
    	$dep = $_REQUEST["dep"];
        $loc = $_REQUEST["loc"];
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

        $where = "WHERE ot.OTDEPA = $dep AND ot.OTLOCA = $loc $wSec $wPqr AND ot.OTTECN =$tec AND ot.OTESTA=1";
        
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
    if($_REQUEST["accion"]=="desasignar_orden"){
    	$dep = $_REQUEST["dep"];
    	$loc = $_REQUEST["loc"];
    	$ord = $_REQUEST["ord"];

    	$query ="UPDATE ot SET OTTECN = 0, OTESTA = 0 WHERE OTDEPA=$dep AND OTLOCA=$loc AND OTNUME=$ord";
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
    }
?>