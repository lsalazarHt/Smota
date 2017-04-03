<?php 
	$conn = require '../template/sql/conexion.php';

	if($_REQUEST["accion"]=="seleccionar_pqr"){
		$dato='';
		$query ="SELECT PQRCODI,PQRDESC FROM pqr WHERE PQRCODI = ".$_REQUEST["cod"]." AND PQRESTA='A'";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                	$dato = $row['PQRDESC'];                              
                }   
            }
            echo $dato;
	}
	if($_REQUEST["accion"]=="actualizar_registros"){
		$table='<thead>
                    <tr style="background-color: #3c8dbc; color:white;">
                     	<th class="text-center" width="100">CODIGO</th>
                      	<th class="text-left" style="padding-left: 10px;" >DESCRIPCION</th>
                      	<th class="text-right" width="230">CANTIDAD MAXIMA A LEGALIZAR</th>
                      	<th class="text-center" width="100">VALOR FIJO</th>
                    </tr>
                </thead><tbody>';
        $i=0;
		$query ="SELECT matepqr.*, material.MATEDESC
				 FROM matepqr
				 INNER JOIN material ON material.MATECODI = matepqr.MAPQMATE
				 WHERE material.MATEESTA = 'A' AND matepqr.MAPQPQR = ".$_REQUEST["cod"]."
				 ORDER BY material.MATECODI";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                if($row['MAPQFIJO']=='S'){ $visible = 'checked="checked"'; }
                else{ $visible = '';}

                $i++;                     
                $table.='
                        <tr id="trSelect'.$i.'" class="trDefault">
                            <td style="width:50px;">
                                <input type="hidden" id="txtCodOrg'.$i.'" value="'.$row['MAPQMATE'].'" readonly>
                                <input type="text" id="txtCod'.$i.'" class="form-control text-center input-sm" onkeypress="solonumerosEnter('.$i.')" value="'.$row['MAPQMATE'].'" onclick="swEditor(\'txtCod'.$i.'\',\'trSelect'.$i.'\',2,'.$i.')">
                                <input type="hidden" id="txtTipo'.$i.'" value="1">
                            </td>
                            <td>
                                <input readonly type="text" id="txtNomb'.$i.'" class="form-control input-sm" value="'.$row['MATEDESC'].'" onclick="swEditor(\'txtNomb'.$i.'\',\'trSelect'.$i.'\',0,0)">
                            </td>
                            <td>
                                <input type="text" id="txtCantMax'.$i.'" class="form-control text-right input-sm" onkeypress="solonumeros()" value="'.$row['MAPQCANT'].'" onclick="swEditor(\'txtNomb'.$i.'\',\'trSelect'.$i.'\',0,0)">
                            </td>
                            <td class="text-center " style="width:50px;">
                                <input type="checkbox" id="txtCkek'.$i.'" '.$visible.' onclick="swEditor(\'\',\'trSelect'.$i.'\')">
                            </td>
                        </tr>
                        ';
            }   
        }
        echo '<input type="hidden" id="contRow" value="'.$i.'">'.$table.'</tbody>';
        //echo $query;
	}
	if($_REQUEST["accion"]=="seleccionar_material"){
		$dato='';
		$query ="SELECT MATECODI,MATEDESC FROM material WHERE MATECODI = ".$_REQUEST["cod"]." AND MATEESTA='A' ";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                	$dato = $row['MATEDESC'];                              
                }   
            }
            echo $dato;
	}
	if($_REQUEST["accion"]=="guardar_registros"){
		if( $_REQUEST["cant"]=='' ){ $_REQUEST["cant"]=0; }

        $query ="INSERT INTO matepqr (MAPQPQR, MAPQMATE, MAPQCANT, MAPQFIJO) 
                VALUES (".$_REQUEST["codPqr"].",".$_REQUEST["cod"].",".$_REQUEST["cant"].",'".$_REQUEST["chek"]."')";
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
	}
	if($_REQUEST["accion"]=="editar_registros"){
        if( $_REQUEST["cant"]=='' ){ $_REQUEST["cant"]=0; }
        
        $query ="UPDATE matepqr SET MAPQMATE=".$_REQUEST["cod"].", MAPQCANT=".$_REQUEST["cant"].",
		         MAPQFIJO='".$_REQUEST["chek"]."' 
		         WHERE MAPQPQR=".$_REQUEST["codPqr"]." AND MAPQMATE=".$_REQUEST["codOrg"];
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
    }
    if($_REQUEST["accion"]=="cargar_pqrs"){
        $dato='';
        $i=0;
        $query ="SELECT * FROM pqr WHERE PQRESTA='A' ORDER BY PQRCODI";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $i++;
                $dato .='<input type="text" id="txtCodPqr'.$i.'" value="'.$row['PQRCODI'].'"><br>';
            }   
        }
        echo $dato.'<br>
            <input type="text" id="txtActualPqr" value="1"><br>
        <input type="text" id="txtToltalPqr" value="'.$i.'">';
    }

?>