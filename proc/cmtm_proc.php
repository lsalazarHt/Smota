<?php 
	$conn = require '../template/sql/conexion.php';

	if($_REQUEST["accion"]=="seleccionar_tipoM"){
		$dato='';
		$query ="SELECT TIMOCODI,TIMODESC FROM tipomovi WHERE TIMOCODI = ".$_REQUEST["cod"];
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                	$dato = $row['TIMODESC'];                              
                }   
            }
            echo $dato;
	}
	if($_REQUEST["accion"]=="actualizar_registros"){
		$table='<thead>
                    <tr style="background-color: #3c8dbc; color:white;">
                        <th class="text-center" width="100">CODIGO</th>
                        <th class="text-center">NOMBRE</th>
                        <th class="text-center" width="100">VISIBLE</th>
                    </tr>
                </thead><tbody>';
        $i=0;
        
		$query ="SELECT clmatimo.* , clasmate.CLMADESC
                 FROM clmatimo
                 INNER JOIN clasmate ON clasmate.CLMACODI = clmatimo.CMTMCLMA
                 WHERE clmatimo.CMTMTIMO = ".$_REQUEST["cod"]."
                 ORDER BY clmatimo.CMTMCLMA";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                if($row['CMTMVISI']==1){ $visible = 'checked="checked"'; }
                else{ $visible = '';}

                $i++;                     
                $table.='
                        <tr id="trSelect'.$i.'" class="trDefault">
                            <td style="width:50px;">
                                <input type="hidden" id="txtCodOrg'.$i.'" value="'.$row['CMTMCLMA'].'" readonly>
                                <input type="text" id="txtCod'.$i.'" class="form-control text-center input-sm" onkeypress="solonumerosEnter('.$i.')" value="'.$row['CMTMCLMA'].'" onclick="swEditor(\'txtCod'.$i.'\',\'trSelect'.$i.'\',2,'.$i.')">
                                <input type="hidden" id="txtTipo'.$i.'" value="1">
                            </td>
                            <td>
                                <input type="text" id="txtNomb'.$i.'" class="form-control input-sm" value="'.$row['CLMADESC'].'" readonly  onclick="swEditor(\'txtNomb'.$i.'\',\'trSelect'.$i.'\',0,0)">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" id="txtCkek'.$i.'" '.$visible.' onclick="swEditor(\'\',\'trSelect'.$i.'\',0,0)">
                            </td>
                        </tr>
                        ';
            }   
        }
        echo '<input type="hidden" id="contRow" value="'.$i.'">'.$table.'</tbody>';
        //echo $query;
	}
	if($_REQUEST["accion"]=="seleccionar_clase"){
		$dato='';
		$query ="SELECT CLMACODI,CLMADESC FROM clasmate WHERE CLMACODI = ".$_REQUEST["cod"];
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                	$dato = $row['CLMADESC'];                              
                }   
            }
            echo $dato;
	}
	if($_REQUEST["accion"]=="guardar_registros"){

        $query ="INSERT INTO clmatimo (CMTMTIMO, CMTMCLMA) 
                VALUES (".$_REQUEST["codTipoM"].",".$_REQUEST["cod"].")";
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
	}
	if($_REQUEST["accion"]=="editar_registros"){

        $query ="UPDATE clmatimo SET CMTMCLMA=".$_REQUEST["cod"].", CMTMVISI=".$_REQUEST["chek"]."
		         WHERE CMTMTIMO=".$_REQUEST["codTipoM"]." AND CMTMCLMA=".$_REQUEST["codOrg"];
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
    }

    if($_REQUEST["accion"]=="cargar_tipoM"){
        $dato='';
        $i=0;
        $query ="SELECT * FROM tipomovi ORDER BY TIMOCODI";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $i++;
                $dato .='<input type="text" id="txtCodTipo'.$i.'" value="'.$row['TIMOCODI'].'"><br>';
            }   
        }
        echo $dato.'<br>
            <input type="text" id="txtActualTipo" value="1"><br>
        <input type="text" id="txtToltalTipo" value="'.$i.'">';
    }

?>