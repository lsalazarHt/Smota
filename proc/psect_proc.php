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
	if($_REQUEST["accion"]=="actualizar_sectores"){
		$table='<thead>
                    <tr style="background-color: #3c8dbc; color:white;">
                     	<th class="text-center" width="100">CODIGO</th>
                      	<th class="text-left">SECTOR</th>
                      	<th class="text-center" width="100">VISIBLE</th>
                    </tr>
                </thead><tbody>';
        $i=0;
		$query ='SELECT DISTINCT SEOPCODI,SEOPNOMB,SEOPVISI 
				 FROM sectores
				 INNER JOIN departam ON departam.DEPACODI = sectores.SEOPDEPA
				 JOIN localidad ON localidad.LOCACODI = sectores.SEOPLOCA
				 WHERE SEOPDEPA = '.$_REQUEST["codDep"].' AND SEOPLOCA = '.$_REQUEST["codLoc"].' AND DEPAVISI = 1 AND LOCAVISI = 1
				 ORDER BY  SEOPCODI';
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                if($row['SEOPVISI']==1){$visible = 'checked="checked"'; }
                else{ $visible = '';}

                $i++;                     
                $table.='
                        <tr id="trSelect'.$i.'" class="trDefault">
                            <td style="width:50px;">
                                <input type="hidden" id="txtCodOrg'.$i.'" value="'.$row['SEOPCODI'].'" readonly>
                                <input type="text" id="txtCod'.$i.'" class="form-control text-center input-sm" value="'.$row['SEOPCODI'].'" onkeypress="solonumeros()" onclick="swEditor(\'txtCod'.$i.'\',\'trSelect'.$i.'\')">
                                <input type="hidden" id="txtTipo'.$i.'" value="1">
                            </td>
                            <td>
                                <input type="text" id="txtNomb'.$i.'" class="form-control input-sm" value="'.$row['SEOPNOMB'].'" onclick="swEditor(\'txtNomb'.$i.'\',\'trSelect'.$i.'\')">
                            </td>
                            <td class="text-center " style="width:50px;">
                                <input type="checkbox" id="txtCkek'.$i.'" '.$visible.' onclick="swEditor(\'\',\'trSelect'.$i.'\')">
                            </td>
                        </tr>
                        ';
            }   
        }
        echo '<input type="hidden" id="contRow" value="'.$i.'">'.$table.'</tbody>';
	}
	if($_REQUEST["accion"]=="guardar_registros"){
		
        $query ="INSERT INTO sectores (SEOPDEPA,SEOPLOCA,SEOPCODI,SEOPNOMB) 
                VALUES (".$_REQUEST["codDep"].",".$_REQUEST["codLoc"].",".$_REQUEST["cod"].",'".$_REQUEST["nom"]."')";
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
	}
	if($_REQUEST["accion"]=="editar_registros"){
        
        $query ="UPDATE sectores SET SEOPNOMB='".$_REQUEST["nom"]."', SEOPCODI=".$_REQUEST["cod"].", SEOPVISI=".$_REQUEST["chek"]." WHERE SEOPCODI=".$_REQUEST["codOrg"];
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
    }
?>