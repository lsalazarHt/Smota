<?php 
	$conn = require '../template/sql/conexion.php';

	if($_REQUEST["accion"]=="actualizar_parametros"){
		$table='<thead>
                    <tr style="background-color: #3c8dbc; color:white;">
                     	<th class="text-center" width="200">CODIGO</th>
                     	<th class="text-right" width="150">VALOR NUMERICO</th>
                     	<th class="text-center" width="150">VALOR CARACTER</th>
                      	<th class="text-left">OBSERVACION</th>
                      	<th class="text-center" width="50">VISIBLE</th>
                    </tr>
                </thead><tbody>';
        $i=0;
		$query ='SELECT * FROM paraconf';
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                if($row['PARAVISI']==1){$visible = 'checked="checked"'; }
                else{ $visible = '';}

                $i++;
                $table.='
                        <tr id="trSelect'.$i.'" class="trDefault">
                            <td>
                                <input type="hidden" id="txtCodOrg'.$i.'" class="form-control input-sm" value="'.$row['PARACODI'].'" readonly>
                                <input type="text" id="txtCod'.$i.'" class="form-control input-sm" value="'.$row['PARACODI'].'" onclick="swEditor(\'txtCod'.$i.'\',\'trSelect'.$i.'\')">
                                <input type="hidden" id="txtTipo'.$i.'" value="1">
                            </td>
                            <td>
                                <input type="text" id="txtValorNum'.$i.'" class="form-control text-right input-sm" value="'.$row['PARAVANU'].'" onclick="swEditor(\'txtValorNum'.$i.'\',\'trSelect'.$i.'\')">
                            </td>
                            <td>
                                <input type="text" id="txtValorCar'.$i.'" class="form-control input-sm" value="'.$row['PARAVAST'].'" onclick="swEditor(\'txtValorCar'.$i.'\',\'trSelect'.$i.'\')">
                            </td>
                            <td>
                                <input type="text" id="txtObserv'.$i.'" class="form-control input-sm" value="'.$row['PARAOBSE'].'" onclick="swEditor(\'txtObserv'.$i.'\',\'trSelect'.$i.'\')">
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
		$_REQUEST["vAlf"] = str_replace("\\","\\\\",$_REQUEST["vAlf"]);
        $query ="INSERT INTO paraconf (PARACODI,PARAVANU,PARAVAST,PARAOBSE) 
                VALUES ('".$_REQUEST["cod"]."','".$_REQUEST["vNum"]."','".$_REQUEST["vAlf"]."','".$_REQUEST["obs"]."')";
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
	}

	if($_REQUEST["accion"]=="editar_registros"){
		$_REQUEST["vAlf"] = str_replace("\\","\\\\",$_REQUEST["vAlf"]);
        $query ="UPDATE paraconf
        		 SET PARACODI='".$_REQUEST["cod"]."', PARAVANU='".$_REQUEST["vNum"]."',
        		 	 PARAVAST='".$_REQUEST["vAlf"]."', PARAOBSE='".$_REQUEST["obs"]."',
        		 	 PARAVISI=".$_REQUEST["chek"]."
        		 WHERE PARACODI='".$_REQUEST["codOrg"]."'";
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
    }

    if($_REQUEST["accion"]=="buscar_contratista"){
        $dato='';
        $query ="SELECT descripcion FROM contratista WHERE id = 1";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                    $dato = $row['descripcion'];                              
                }   
            }
            echo $dato;
    }

    if($_REQUEST["accion"]=="guardar_contratista"){
        $query ="UPDATE contratista
                 SET descripcion='".$_REQUEST["nom"]."'
                 WHERE id=1";
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
    }
?>