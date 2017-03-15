<?php
	$conn = require '../template/sql/conexion.php';

	if($_REQUEST["accion"]=="seleccionar_departamento"){
		$dato='';
		$query ='SELECT DEPACODI,DEPADESC FROM departam WHERE DEPAVISI=1 AND DEPACODI = '.$_REQUEST["cod"];
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
            	$dato = $row['DEPADESC'];                              
            }   
        }
        echo $dato;
	}
	if($_REQUEST["accion"]=="cargar_ciudades"){
        $dato='';
        $i=0;
        $query ='SELECT * 
        		 FROM localidad
        		 INNER JOIN departam ON departam.DEPACODI = localidad.LOCADEPA
        		 WHERE LOCADEPA = '.$_REQUEST["dep"].' AND DEPAVISI = 1 AND LOCAVISI = 1
        		 ORDER BY LOCANOMB';
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $i++;
                $dato .='<input type="hidden" id="txtCodLoc'.$i.'" value="'.$row['LOCACODI'].'"><br>';
            }   
        }
        echo $dato.'<br>
            <input type="hidden" id="txtActualLoc" value="1"><br>
        <input type="hidden" id="txtToltalLoc" value="'.$i.'">';
    }
	if($_REQUEST["accion"]=="cargar_departamentos"){
        $dato='';
        $i=0;
        $query ='SELECT * FROM departam WHERE DEPAVISI= 1 ORDER BY DEPADESC';
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $i++;
                $dato .='<input type="hidden" id="txtCodDep'.$i.'" value="'.$row['DEPACODI'].'"><br>';
            }   
        }
        echo $dato.'<br>
            <input type="hidden" id="txtActualDep" value="1"><br>
        <input type="hidden" id="txtToltalDep" value="'.$i.'">';
    }
	if($_REQUEST["accion"]=="seleccionar_localidad"){
		$dato='';
		$query ='SELECT LOCANOMB 
				 FROM localidad 
				 INNER JOIN departam ON departam.DEPACODI = localidad.LOCADEPA
				 WHERE LOCADEPA = '.$_REQUEST["dep"].' AND LOCACODI = '.$_REQUEST["cod"].' AND DEPAVISI = 1 AND LOCAVISI = 1';
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
            	$dato = $row['LOCANOMB'];                              
            }   
        }
        echo $dato;
	}
	if($_REQUEST["accion"]=="act_localidades"){
		$dato='';
		$query ='SELECT LOCACODI,LOCANOMB 
				 FROM localidad
				 INNER JOIN departam ON departam.DEPACODI = localidad.LOCADEPA
				 WHERE LOCADEPA = '.$_REQUEST["dep"].' AND DEPAVISI = 1 AND LOCAVISI = 1';
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
            	$dato .= '<tr onclick="colocarCiudad('.$row['LOCACODI'].')">
							<td class="text-center">'.$row['LOCACODI'].'</td>
							<td>'.$row['LOCANOMB'].'</td>
            			  </tr>';
            }   
        }
        echo $dato;
	}
    if($_REQUEST["accion"]=="act_zonas"){
        $dato='';
        $query ='SELECT distinct zonas.*  
                 FROM zonas
                 INNER JOIN departam ON departam.DEPACODI = zonas.ZONADEPA
                 JOIN localidad ON localidad.LOCACODI = zonas.ZONALOCA
                 WHERE ZONADEPA = '.$_REQUEST["dep"].' AND ZONALOCA = '.$_REQUEST["loc"].' AND DEPAVISI = 1 AND LOCAVISI = 1 AND ZONAVISI = 1
                 ORDER BY ZONACODI';
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $dato .= '<tr onclick="colocarZona('.$row['ZONACODI'].')">
                            <td class="text-center">'.$row['ZONACODI'].'</td>
                            <td>'.$row['ZONANOMB'].'</td>
                          </tr>';
            }   
        }
        echo $dato;
    }

    if($_REQUEST["accion"]=="cargar_zonas"){
        $dato='';
        $i=0;
        $query ='SELECT distinct zonas.*  
                 FROM zonas
                 INNER JOIN departam ON departam.DEPACODI = zonas.ZONADEPA
                 JOIN localidad ON localidad.LOCACODI = zonas.ZONALOCA
                 WHERE ZONADEPA = '.$_REQUEST["dep"].' AND ZONALOCA = '.$_REQUEST["loc"].' AND DEPAVISI = 1 AND LOCAVISI = 1 AND ZONAVISI = 1
                 ORDER BY ZONACODI';
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $i++;
                $dato .='<input type="hidden" id="txtCodZon'.$i.'" value="'.$row['ZONACODI'].'"><br>';
            }   
        }
        echo $dato.'<br>
            <input type="hidden" id="txtActualZon" value="1"><br>
        <input type="hidden" id="txtToltalZon" value="'.$i.'">';
    }
    if($_REQUEST["accion"]=="seleccionar_zona"){
        $dato='';
        $query ='SELECT distinct zonas.*  
                 FROM zonas
                 INNER JOIN departam ON departam.DEPACODI = zonas.ZONADEPA
                 JOIN localidad ON localidad.LOCACODI = zonas.ZONALOCA
                 WHERE ZONACODI = '.$_REQUEST["cod"].' AND ZONADEPA = '.$_REQUEST["dep"].' AND ZONALOCA = '.$_REQUEST["loc"].' AND DEPAVISI = 1 AND LOCAVISI = 1 AND ZONAVISI = 1';
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $dato = $row['ZONANOMB'];                              
            }   
        }
        echo $dato;
    }
    //
	if($_REQUEST["accion"]=="actualizar_sectores"){
		$table='<thead>
                    <tr style="background-color: #3c8dbc; color:white;">
                     	<th class="text-center" width="100">CODIGO</th>
                      	<th class="text-left">SECTOR</th>
                      	<th class="text-center" width="100">VISIBLE</th>
                    </tr>
                </thead><tbody>';
        $i=0;
		$query ='SELECT distinct seopzoop.sezodepa,seopzoop.sezoloca,seopzoop.sezozoop,seopzoop.sezoseop, seopzoop.sezovisi
                 FROM seopzoop
                 INNER JOIN departam ON departam.DEPACODI = seopzoop.sezodepa
                 JOIN localidad ON localidad.LOCACODI = seopzoop.sezoloca
				 WHERE sezodepa = '.$_REQUEST["codDep"].' AND sezoloca = '.$_REQUEST["codLoc"].' AND sezozoop = '.$_REQUEST["codZon"].' AND DEPAVISI = 1 AND LOCAVISI = 1
				 ORDER BY seopzoop.sezoseop';
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                if($row['sezovisi']==1){$visible = 'checked="checked"'; }
                else{ $visible = '';}
                $seopzoop = $row['sezoseop'];
                

                $querySect ='SELECT SEOPNOMB FROM sectores WHERE SEOPVISI = 1 AND SEOPCODI = '.$seopzoop;
                $respuestaSect = $conn->prepare($querySect) or die ($sql);
                if(!$respuestaSect->execute()) return false;
                if($respuestaSect->rowCount()>0){
                    while ($rowSect=$respuestaSect->fetch()){
                        $nombSect = $rowSect['SEOPNOMB'];
                    }
                }

                $i++;                     
                $table.='
                        <tr id="trSelect'.$i.'" class="trDefault">
                            <td style="width:50px;">
                                <input type="hidden" id="txtCodOrg'.$i.'" value="'.$row['sezoseop'].'" readonly>
                                <input type="text" id="txtCod'.$i.'" class="form-control text-center input-sm" value="'.$row['sezoseop'].'" onkeypress="solonumerosEnter('.$i.')" onclick="swEditor(\'txtCod'.$i.'\',\'trSelect'.$i.'\',1,'.$i.')">
                                <input type="hidden" id="txtTipo'.$i.'" value="1">
                            </td>
                            <td>
                                <input type="text" id="txtNomb'.$i.'" class="form-control input-sm" value="'.$nombSect.'" onclick="swEditor(\'txtNomb'.$i.'\',\'trSelect'.$i.'\',1,'.$i.')" readonly>
                            </td>
                            <td class="text-center " style="width:50px;">
                                <input type="checkbox" id="txtCkek'.$i.'" '.$visible.' onclick="swEditor(\'\',\'trSelect'.$i.'\',1,'.$i.')">
                            </td>
                        </tr>
                        ';
            }   
        }
        echo '<input type="hidden" id="contRow" value="'.$i.'">'.$table.'</tbody>';
	}
    if($_REQUEST["accion"]=="validar_sector"){
        $sw=0;
        $query ='SELECT SEOPCODI,SEOPNOMB FROM sectores WHERE SEOPVISI = 1 AND SEOPCODI = '.$_REQUEST["cod"];
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $sw = 1;
                $dato = $row['SEOPNOMB'];                              
            }
        }else{
            $sw = 0;
            $dato = 0;
        }
        $arr = array($sw,$dato);
        echo json_encode($arr);
    }

	if($_REQUEST["accion"]=="guardar_registros"){
		
        $query ="INSERT INTO seopzoop (SEZODEPA,SEZOLOCA,SEZOZOOP,SEZOSEOP) 
                VALUES (".$_REQUEST["codDep"].",".$_REQUEST["codLoc"].",".$_REQUEST["codZon"].",".$_REQUEST["cod"].")";
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 0;
        }else{
            echo 1;
        }
	}
	if($_REQUEST["accion"]=="editar_registros"){
        
        $query ="UPDATE seopzoop SET SEZOSEOP='".$_REQUEST["cod"]."', SEZOVISI=".$_REQUEST["chek"]." 
                 WHERE SEZOSEOP=".$_REQUEST["codOrg"].' AND SEZODEPA='.$_REQUEST["codDep"].' 
                 AND SEZOLOCA='.$_REQUEST["codLoc"].' AND SEZOZOOP='.$_REQUEST["codZon"];
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
    }
?>