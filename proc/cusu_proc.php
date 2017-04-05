<?php 
	$conn = require '../template/sql/conexion.php';

	if($_REQUEST["accion"]=="obtener_usuario"){
		$dato='';
		$sw=0;
		$query ="SELECT * FROM usuarios WHERE USUCODI = ".$_REQUEST["cod"];
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
        	$sw = 1;
            while ($row=$respuesta->fetch()){
            	$dato1 = $row['USUNOMB'];                            
            	$dato2 = $row['USUDIRE'];                            
            	$dato3 = $row['USURUTA'];                            
            	$dato4 = $row['USUMEDI'];                            
            	
            	$dato5 = $row['USUSEOP'];                            
            	//$dato6 = $row['USUSEOP'];                            
            	
            	$dato7 = $row['USUNOBA'];                            
            	
            	$dato8 = $row['USUDEPA'];                            
            	//$dato9 = $row['USUDEPA'];                            
            	
            	$dato10 = $row['USULOCA'];                            
            	//$dato11 = $row['USULOCA'];
            }

	        //SECTOR
	        $query ="SELECT SEOPNOMB FROM sectores WHERE SEOPCODI = ".$dato5;
	        $respuesta = $conn->prepare($query) or die ($sql);
	        if(!$respuesta->execute()) return false;
	        if($respuesta->rowCount()>0){
	        	while ($row=$respuesta->fetch()){
	        		$dato6 = $row['SEOPNOMB'];  
	        	}
	        }

	        //DEPARTAMENTO
	        $query ="SELECT DEPADESC FROM departam WHERE DEPACODI = ".$dato8;
	        $respuesta = $conn->prepare($query) or die ($sql);
	        if(!$respuesta->execute()) return false;
	        if($respuesta->rowCount()>0){
	        	while ($row=$respuesta->fetch()){
	        		$dato9 = $row['DEPADESC'];  
	        	}
	        }

	        //LOCALIDAD
	        $query ="SELECT LOCANOMB FROM localidad WHERE LOCACODI = ".$dato10;
	        $respuesta = $conn->prepare($query) or die ($sql);
	        if(!$respuesta->execute()) return false;
	        if($respuesta->rowCount()>0){
	        	while ($row=$respuesta->fetch()){
	        		$dato11 = $row['LOCANOMB'];  
	        	}
	        }
        }else{
        	$sw = 0;
            $dato1 = '';                            
        	$dato2 = '';                            
        	$dato3 = '';                            
        	$dato4 = '';                            
        	$dato5 = '';                            
        	$dato6 = '';                            
        	$dato7 = '';                            
        	$dato8 = '';                            
        	$dato9 = '';                            
        	$dato10 = '';                            
        	$dato11 = '';
        }
        
        $arr = array($sw,$dato1,$dato2,$dato3,$dato4,$dato5,$dato6,$dato7,$dato8,$dato9,$dato10,$dato11);
        echo json_encode($arr);
	}
	if($_REQUEST["accion"]=="actualizar_ordenes"){
		$table = '<table class="table table table-condensed table-bordered table-striped">
                    <thead>
                        <tr style="background-color: #3c8dbc; color:white;">
                         	<th class="text-center" width="130">ORDEN</th>
                          	<th class="text-center">FECHA ORDEN</th>
                          	<th class="text-center">FECHA ASIGNACION</th>
                          	<th class="text-center">FECHA CUMPLIMIENTO</th>
                          	<th class="text-center">ESTADO</th>
                          	<th class="text-center">PQR REPORTADA</th>
                          	<th class="text-center">PQR ENCONTRADA</th>
                          	<th class="text-center">TECNICO</th>
                          	<th class="text-center">CAUSA ATENCION</th>
                          	<th class="text-center">CAUSA NO ATENCION</th>
                        </tr>
                    </thead>
                    <tbody>';
		$i = 0;
		$query ="SELECT OTDEPA,OTLOCA,OTNUME,OTFEORD,OTFEAS,OTCUMP,OTESTA,OTPQRREPO,OTPQRENCO,OTTECN,OTCAAT,OTCANOA  
				 FROM ot 
				 WHERE OTUSUARIO = ".$_REQUEST["cod"]."
				 ORDER BY OTNUME";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){

                $i++;                     
                $table.='
                        <tr id="trSelect'.$i.'" class="trDefault" onClick="trSelect(\'trSelect'.$i.'\','.$row['OTNUME'].')" ondblclick="enviarOrden('.$row['OTNUME'].','.$_REQUEST["cod"].',\'trSelect'.$i.'\')">
                            <td class="text-center">'.$row['OTDEPA'].' - '.$row['OTLOCA'].' - '.$row['OTNUME'].'</td>
                            <td class="text-center">'.$row['OTFEORD'].'</td>
                            <td class="text-center">'.$row['OTFEAS'].'</td>
                            <td class="text-center">'.$row['OTCUMP'].'</td>
                            <td class="text-center">'.$row['OTESTA'].'</td>
                            <td class="text-center">'.$row['OTPQRREPO'].'</td>
                            <td class="text-center">'.$row['OTPQRENCO'].'</td>
                            <td class="text-center">'.$row['OTTECN'].'</td>
                            <td class="text-center">'.$row['OTCAAT'].'</td>
                            <td class="text-center">'.$row['OTCANOA'].'</td>
                        </tr>
                        ';
            }
        }
        echo '<input type="hidden" id="contRow" value="'.$i.'">'.$table.'</tbody>';
	}
	if($_REQUEST["accion"]=="obtener_obsOrden"){
		$dato='';
		$query ="SELECT OTOBSEAS,OTOBSELE FROM ot WHERE OTNUME = ".$_REQUEST["idOrden"];
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
            	$dato1 = $row['OTOBSEAS'];                            
            	$dato2 = $row['OTOBSELE'];
            }
        }
        
        $arr = array($dato1,$dato2);
        echo json_encode($arr);
	}
    if($_REQUEST["accion"]=="cargar_usuarios"){
        $dato='';
        $i=0;
        $query ='SELECT USUCODI FROM usuarios ORDER BY USUCODI';
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $i++;
                $dato .='<input type="text" id="txtCodUsu'.$i.'" value="'.$row['USUCODI'].'"> ** ';
            }   
        }
        echo $dato.'<br>
            <input type="text" id="txtActualUsu" value="1"><br>
        <input type="text" id="txtToltalUsu" value="'.$i.'">';
    }
?>