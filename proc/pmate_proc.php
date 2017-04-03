<?php 
	
	$conn = require '../template/sql/conexion.php';

	if($_REQUEST["accion"]=="actualizar_registros"){
		$table='<thead>
                    <tr style="background-color: #3c8dbc; color:white;">
                     	<th class="text-center" width="100">CODIGO</th>
                     	<th class="text-left">NOMBRE</th>
                     	<th class="text-center" width="50">CLASE</th>
                     	<th class="text-center" width="130">UND DE MEDIDA</th>
                      	<th class="text-center" width="200"></th>
                      	<th class="text-center" width="80">ESTADO</th>
                        <th class="text-right" width="100">VIDA UTIL (DIAS)</th>
                        <th class="text-right" width="100">CANT MAX DOTACIÓN</th>
                    </tr>
                </thead><tbody>';
        $i=0;
		$query ='SELECT MATECODI,MATEDESC,MATECLAS,clasmate.CLMACODI,clasmate.CLMADESC,MATEUNME,MATEESTA,MATEEXTRA,MATEVIUT,MATEMXCT
				 FROM material
				 INNER JOIN clasmate ON clasmate.CLMACODI = MATERIAL.MATECLAS';
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                if($row['MATEESTA']=='A'){ $visible = 'checked="checked"'; }
                else{ $visible = '';}
                /*if($row['MATEEXTRA']=='A'){ $manejaSerial = 'checked="checked"'; }
                else{ $manejaSerial = '';}*/
                if($row['CLMACODI']==5 || $row['CLMACODI']==6){ $readonly = ''; }
                else{ $readonly = 'readonly';}

                $i++;
                $table.='
                        <tr id="trSelect'.$i.'" class="trDefault">
                            <td>
                                <input type="hidden" id="txtCodOrg'.$i.'" class="form-control input-sm" value="'.$row['MATECODI'].'" readonly>
                                <input type="text" id="txtCod'.$i.'" class="form-control input-sm text-center" value="'.$row['MATECODI'].'" onkeypress="solonumeros()" onclick="swEditor(\'txtCod'.$i.'\',\'trSelect'.$i.'\')">
                                <input type="hidden" id="txtTipo'.$i.'" value="1">
                            </td>
                            <td>
                                <input type="text" id="txtNomb'.$i.'" class="form-control input-sm" value="'.$row['MATEDESC'].'" onclick="swEditor(\'txtNomb'.$i.'\',\'trSelect'.$i.'\')">
                            </td>
                            <td>
                                <input type="text" id="txtClase'.$i.'" class="form-control input-sm text-center" value="'.$row['MATECLAS'].'" onkeypress="solonumerosEnter('.$i.')" onclick="swEditorM(\'\',\'trSelect'.$i.'\',1,'.$i.')">
                            </td>
                            <td>
                                <input type="text" id="txtUndMed'.$i.'" class="form-control input-sm" value="'.$row['MATEUNME'].'" onclick="swEditor(\'txtUndMed'.$i.'\',\'trSelect'.$i.'\')">
                            </td>
                            <td>
                                <input type="text" id="txtClaseNomb'.$i.'" class="form-control input-sm" value="'.$row['CLMADESC'].'" onclick="swEditor(\'\',\'trSelect'.$i.'\')" readonly>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" id="txtCkek'.$i.'" '.$visible.' onclick="swEditor(\'\',\'trSelect'.$i.'\')"> Activo
                            </td>
                            <td>
                                <input type="text" id="txtVidaUtil'.$i.'" class="form-control text-right input-sm" value="'.$row['MATEVIUT'].'" onkeypress="solonumeros('.$i.')" onclick="swEditor(\'txtVidaUtil'.$i.'\',\'trSelect'.$i.'\')" '.$readonly.'>
                            </td>
                            <td>
                                <input type="text" id="txtCantMax'.$i.'" class="form-control text-right input-sm" value="'.$row['MATEMXCT'].'" onkeypress="solonumeros('.$i.')" onclick="swEditor(\'txtCantMax'.$i.'\',\'trSelect'.$i.'\')" '.$readonly.'>
                            </td>
                        </tr>
                        ';
            }   
        }
        echo '<input type="hidden" id="contRow" value="'.$i.'">'.$table.'</tbody>';
	}

	if($_REQUEST["accion"]=="validar_clase"){
        $sw=0;
        $query ='SELECT CLMACODI,CLMADESC FROM clasmate WHERE  CLMACODI = '.$_REQUEST["cod"];
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $sw = 1;
                $dato = $row['CLMADESC'];                              
            }
        }else{
            $sw = 0;
            $dato = 0;
        }
        $arr = array($sw,$dato);
        echo json_encode($arr);
    }

    if($_REQUEST["accion"]=="guardar_registros"){
        $query ="INSERT INTO material (MATECODI,MATEDESC,MATECLAS,MATEUNME,MATEESTA,MATEVIUT,MATEMXCT) 
                VALUES (".$_REQUEST["cod"].",'".$_REQUEST["nom"]."',".$_REQUEST["cls"].",'".$_REQUEST["uMed"]."','".$_REQUEST["chek"]."','".$_REQUEST["vdUtl"]."','".$_REQUEST["cnMxDt"]."')";
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
	}

	if($_REQUEST["accion"]=="editar_registros"){
        $query ="UPDATE material
        		 SET MATECODI=".$_REQUEST["cod"].", MATEDESC='".$_REQUEST["nom"]."',
        		 	 MATECLAS=".$_REQUEST["cls"].", MATEUNME='".$_REQUEST["uMed"]."',
                     MATEVIUT='".$_REQUEST["vdUtl"]."', MATEMXCT='".$_REQUEST["cnMxDt"]."'
        		 WHERE MATECODI=".$_REQUEST["codOrg"];
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
    }
?>