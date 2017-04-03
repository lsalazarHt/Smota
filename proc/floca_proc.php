<?php 
	$conn = require '../template/sql/conexion.php';

	if($_REQUEST["accion"]=="seleccionar_departamento"){
		$dato='';
		$query ='SELECT DEPACODI,DEPADESC FROM departam WHERE DEPACODI = '.$_REQUEST["cod"].' AND DEPAVISI=1';
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                	$dato = $row['DEPADESC'];                              
                }   
            }
            echo $dato;
	}
	if($_REQUEST["accion"]=="guardar_registros"){
		
        $query ="INSERT INTO localidad (LOCADEPA,LOCACODI,LOCANOMB) 
                VALUES (".$_REQUEST["codDep"].",".$_REQUEST["codLoc"].",'".$_REQUEST["nomLoc"]."')";
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
	}
    if($_REQUEST["accion"]=="editar_registros"){
        
        $query ="UPDATE localidad SET LOCANOMB='".$_REQUEST["nomLoc"]."', LOCACODI=".$_REQUEST["codLoc"].", LOCAVISI=".$_REQUEST["chekLoc"]." WHERE LOCACODI=".$_REQUEST["codOrgLoc"]." AND LOCADEPA=".$_REQUEST["codDep"];
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
    }
    if($_REQUEST["accion"]=="ocultar_registros"){
        
        $query ="UPDATE localidad SET LOCAVISI=0 WHERE LOCACODI=".$_REQUEST["codLoc"]." AND LOCADEPA=".$_REQUEST["codDep"];
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
    }
    if($_REQUEST["accion"]=="eliminar_registro"){
        
        $query ="DELETE FROM localidad WHERE LOCACODI=".$_REQUEST["codLoc"]." AND LOCADEPA=".$_REQUEST["codDep"];
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
    }
	if($_REQUEST["accion"]=="actualizar_localidad"){
		$table='<thead>
                    <tr style="background-color: #3c8dbc; color:white;">
                        <th class="text-center" style="width:50px;">CODIGO</th>
                        <th class="text-left
                        ">NOMBRE</th>
                        <th class="text-center" style="width:50px;">VISIBLE</th>
                    </tr>
                </thead><tbody>';
        $i=0;
		$query ='SELECT LOCACODI,LOCANOMB,LOCAVISI
                 FROM localidad
                 INNER JOIN departam ON departam.DEPACODI = localidad.LOCADEPA 
                 WHERE LOCADEPA='.$_REQUEST["codDep"].' AND DEPAVISI=1 ORDER BY  LOCACODI';
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                if($row['LOCAVISI']==1){$visible = 'checked="checked"'; }
                else{ $visible = '';}

                $i++;                     
                $table.='
                        <tr id="trSelect'.$i.'" class="trDefault">
                            <td style="width:50px;">
                                <input type="hidden" id="txtCodOrg'.$i.'" value="'.$row['LOCACODI'].'" readonly>
                                <input type="text" id="txtCod'.$i.'" class="form-control text-center input-sm" value="'.$row['LOCACODI'].'" onclick="swEditor(\'txtCod'.$i.'\',\'trSelect'.$i.'\')">
                                <input type="hidden" id="txtTipo'.$i.'" value="1">
                            </td>
                            <td>
                                <input type="text" id="txtNomb'.$i.'" class="form-control input-sm" value="'.$row['LOCANOMB'].'" onclick="swEditor(\'txtNomb'.$i.'\',\'trSelect'.$i.'\')">
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
    if($_REQUEST["accion"]=="cargar_departamento"){
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
?>