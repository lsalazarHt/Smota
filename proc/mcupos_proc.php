<?php 
	$conn = require '../template/sql/conexion.php';

	if($_REQUEST["accion"]=="seleccionar_nombre"){
		$dato='';
		$query ="SELECT BODECODI,BODENOMB FROM bodega WHERE BODECODI = ".$_REQUEST["cod"]." AND BODEESTA='A'";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                	$dato = $row['BODENOMB'];                              
                }   
            }
            echo utf8_encode($dato);
	}
	if($_REQUEST["accion"]=="actualizar"){
		$table='';
        $i=0;
		$query ="SELECT *
				 FROM inventario
				 WHERE INVEBODE = ".$_REQUEST["cod"]."
				 ORDER BY INVEMATE";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){

                //MATERIAL 
                $queryMate ="SELECT MATEDESC FROM material WHERE MATECODI = ".$row["INVEMATE"];
                $respuestaMate = $conn->prepare($queryMate) or die ($sql);
                if(!$respuestaMate->execute()) return false;
                if($respuestaMate->rowCount()>0){
                    while ($rowMate=$respuestaMate->fetch()){
                        $MATEDESC = $rowMate['MATEDESC'];                              
                    }   
                }

            	$i++;
                $table.='
                        <tr id="trSelect'.$i.'" class="trDefault">
                            <td style="width:50px;">
                                <input type="hidden" id="txtCodOrg'.$i.'" value="'.$row['INVEMATE'].'" readonly>
                                <input type="text" id="txtCod'.$i.'" class="form-control text-center input-sm" onkeypress="solonumerosEnter('.$i.')" value="'.$row['INVEMATE'].'" onclick="swEditor(\'txtCod'.$i.'\',\'trSelect'.$i.'\',2,'.$i.')">
                                <input type="hidden" id="txtTipo'.$i.'" value="1">
                            </td>
                            <td>
                                <input readonly type="text" id="txtNomb'.$i.'" class="form-control input-sm" value="'.$MATEDESC.'" onclick="swEditor(\'txtNomb'.$i.'\',\'trSelect'.$i.'\',0,0)">
                            </td>
                            <td>
                                <input type="text" id="txtCantInvProp'.$i.'" class="form-control text-center text-right input-sm" onkeypress="solonumeros()" value="'.$row['INVECAPRO'].'" onclick="swEditor(\'txtCantInvProp'.$i.'\',\'trSelect'.$i.'\',0,0)">
                            </td>
                            <td>
                                <input type="text" id="txtValInvPropMost'.$i.'" class="form-control text-right input-sm" onkeypress="solonumeros()" value="'.number_format($row['INVEVLRPRO'],0,'.',',').'" onclick="swEditor(\'txtValInvPropMost'.$i.'\',\'trSelect'.$i.'\',0,0)">
                                <input type="hidden" id="txtValInvProp'.$i.'" value="'.$row['INVEVLRPRO'].'" readonly>
                            </td>
                            <td>
                                <input type="text" id="txtCantInvPres'.$i.'" class="form-control text-right text-right input-sm" onkeypress="solonumeros()" value="'.$row['INVECAPRE'].'" onclick="swEditor(\'txtValrInvProp'.$i.'\',\'trSelect'.$i.'\',0,0)">
                            </td>
                            <td>
                                <input type="text" id="txtValInvPresMost'.$i.'" class="form-control text-right input-sm" onkeypress="solonumeros()" value="'.number_format($row['INVEVLRPRE'],0,'.',',').'" onclick="swEditor(\'txtValrInvPres'.$i.'\',\'trSelect'.$i.'\',0,0)">
                                <input type="hidden" id="txtValInvPres'.$i.'" value="'.$row['INVEVLRPRE'].'" readonly>
                            </td>
                            <td>
                                <input type="text" id="txtCupo'.$i.'" class="form-control text-right input-sm" onkeypress="solonumeros()" value="'.$row['INVECUPO'].'" onclick="swEditor(\'txtCupo'.$i.'\',\'trSelect'.$i.'\',0,0)">
                            </td>
                            <td>
                                <input type="text" id="txtCupoExtr'.$i.'" class="form-control text-right input-sm" onkeypress="solonumeros()" value="'.$row['INVENCUEX'].'" onclick="swEditor(\'txtCupoExtr'.$i.'\',\'trSelect'.$i.'\',0,0)">
                            </td>
                        </tr>
                        ';
            }   
        }
        echo '<input type="hidden" id="contRow" value="'.$i.'">'.$table.'</tbody>';
        //echo $query;
	}
	if($_REQUEST["accion"]=="cargar_todos"){
        $dato='';
        $i=0;
        $query ="SELECT * FROM bodega WHERE BODEESTA='A' ORDER BY BODECODI";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $i++;
                $dato .='<input type="text" id="txtCod'.$i.'" value="'.$row['BODECODI'].'"><br>';
            }   
        }
        echo $dato.'<br>
            <input type="text" id="txtActual" value="1"><br>
        <input type="text" id="txtToltal" value="'.$i.'">';
    }
    
?>