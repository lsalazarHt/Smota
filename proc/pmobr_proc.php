<?php 
	$conn = require '../template/sql/conexion.php';

	if($_REQUEST["accion"]=="actualizar_registros"){
		$table='<thead>
                    <tr style="background-color: #3c8dbc; color:white;">
                        <th class="text-center" width="100">CODIGO</th>
                        <th class="text-left">NOMBRE</th>
                        <th class="text-center" width="130">UND DE MEDIDA</th>
                        <th class="text-center" width="180"></th>
                        <th class="text-center" width="50">VISIBLE</th>
                    </tr>
                </thead><tbody>';
        $i=0;
		$query ='SELECT * FROM manobra';
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                //if($row['MOBRESPE']==1){$visibleEsp = 'checked="checked"'; }
                //else{ $visibleEsp = '';}
                if($row['MOBRNOTE']==1){$visibleNote = 'checked="checked"'; }
                else{ $visibleNote = '';}
                if($row['MOBRVISI']==1){$visible = 'checked="checked"'; }
                else{ $visible = '';}

                $i++;
                $table.='
                        <tr id="trSelect'.$i.'" class="trDefault">
                            <td>
                                <input type="hidden" id="txtCodOrg'.$i.'" class="form-control input-sm" value="'.$row['MOBRCODI'].'" readonly>
                                <input type="text" id="txtCod'.$i.'" class="form-control input-sm text-center" value="'.$row['MOBRCODI'].'" onkeypress="solonumeros()" onclick="swEditor(\'txtCod'.$i.'\',\'trSelect'.$i.'\')">
                                <input type="hidden" id="txtTipo'.$i.'" value="1">
                            </td>
                            <td>
                                <input type="text" id="txtNomb'.$i.'" class="form-control input-sm" value="'.$row['MOBRDESC'].'" onclick="swEditor(\'txtNomb'.$i.'\',\'trSelect'.$i.'\')">
                            </td>
                            <td>
                                <input type="text" id="txtUndMed'.$i.'" class="form-control input-sm" value="'.$row['MOBRUNME'].'" onclick="swEditor(\'txtUndMed'.$i.'\',\'trSelect'.$i.'\')">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" id="ckAsocTec'.$i.'" '.$visibleNote.' onclick="swEditor(\'\',\'trSelect'.$i.'\')"> No se asocia al Tecnico
                            </td>
                            <td class="text-center">
                                <input type="checkbox" id="txtCkek'.$i.'" '.$visible.' onclick="swEditor(\'\',\'trSelect'.$i.'\')"> 
                            </td>
                        </tr>
                        ';
            }   
        }
        echo '<input type="hidden" id="contRow" value="'.$i.'">'.$table.'</tbody>';
	}

	if($_REQUEST["accion"]=="guardar_registros"){
        $query ="INSERT INTO manobra (MOBRCODI,MOBRDESC,MOBRUNME,MOBRNOTE) 
                VALUES (".$_REQUEST["cod"].",'".$_REQUEST["nom"]."','".$_REQUEST["med"]."',".$_REQUEST["note"].")";
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
	}

	if($_REQUEST["accion"]=="editar_registros"){
        $query ="UPDATE manobra
        		 SET MOBRCODI=".$_REQUEST["cod"].", MOBRDESC='".$_REQUEST["nom"]."',
        		 	 MOBRUNME='".$_REQUEST["med"]."',
        		 	 MOBRNOTE=".$_REQUEST["note"].", MOBRVISI=".$_REQUEST["chek"]."
        		 WHERE MOBRCODI=".$_REQUEST["codOrg"];
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
    }
?>