<?php 
	$conn = require '../template/sql/conexion.php';

	if($_REQUEST["accion"]=="actualizar_registros"){
		$table='<thead>
                    <tr style="background-color: #3c8dbc; color:white;">
                     	<th class="text-center" width="100">CODIGO</th>
                     	<th class="text-left">DESCRIPCION</th>
                        <th class="text-center" width="150"></th>
                     	<th class="text-center" width="100">VISIBLE</th>
                    </tr>
                </thead><tbody>';
        $i=0;
		$query ='SELECT *
				 FROM clasnota';
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                if($row['CLNOSIGN']=='D'){ 
                	$deb = 'checked="checked"';
                	$cre = '';
               	}else{ 
                	$deb = '';
                	$cre = 'checked="checked"';
                }
                if($row['CLNOVISI']==1){ $visible = 'checked="checked"'; }
                else{ $visible = '';}
                $i++;
                $table.='
                        <tr id="trSelect'.$i.'" class="trDefault">
                            <td>
                                <input type="hidden" id="txtCodOrg'.$i.'" class="form-control input-sm" value="'.$row['CLNOCODI'].'" readonly>
                                <input type="text" id="txtCod'.$i.'" class="form-control input-sm text-center" value="'.$row['CLNOCODI'].'" onkeypress="solonumeros()" onclick="swEditor(\'txtCod'.$i.'\',\'trSelect'.$i.'\')">
                                <input type="hidden" id="txtTipo'.$i.'" value="1">
                            </td>
                            <td>
                                <input type="text" id="txtNomb'.$i.'" class="form-control input-sm" value="'.$row['CLNODESC'].'" onclick="swEditor(\'txtNomb'.$i.'\',\'trSelect'.$i.'\')">
                            </td>
                            <td>
                            	<input type="radio" name="tipoPago'.$i.'" value="D" '.$deb.' onclick="swEditor(\'\',\'trSelect'.$i.'\')"> <small>DEBITO</small> &nbsp;
                            	<input type="radio" name="tipoPago'.$i.'" value="C" '.$cre.' onclick="swEditor(\'\',\'trSelect'.$i.'\')"> <small>CREDITO</small> &nbsp;
                            </td>
                            <td class="text-center">
                                <input type="checkbox" id="txtCkek'.$i.'" '.$visible.' onclick="swEditor(\'\',\'trSelect'.$i.'\',0,0)">
                            </td>
                        </tr>
                        ';
            }   
        }
        echo '<input type="hidden" id="contRow" value="'.$i.'">'.$table.'</tbody>';
	}
    if($_REQUEST["accion"]=="guardar_registros"){
        $query ="INSERT INTO clasnota (CLNOCODI, CLNODESC, CLNOSIGN) 
                VALUES (".$_REQUEST["cod"].",'".$_REQUEST["nom"]."','".$_REQUEST["d_c"]."')";
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo $query;
        }else{
            echo 1;
        }
	}
	if($_REQUEST["accion"]=="editar_registros"){
        $query ="UPDATE clasnota
        		 SET CLNOCODI=".$_REQUEST["cod"].", CLNODESC='".$_REQUEST["nom"]."',
        		 	 CLNOSIGN='".$_REQUEST["d_c"]."', CLNOVISI=".$_REQUEST["chek"]."
        		 WHERE CLNOCODI=".$_REQUEST["codOrg"];
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
    }

?>