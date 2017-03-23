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
                        <th class="text-center">DESCRIPCION</th>
                        <th class="text-center" width="150">CANTIDAD MAXIMA A LEGALIZAR</th>
                        <th class="text-center" width="130">VALOR A PAGAR</th>
                        <th class="text-center" width="190">VALOR A PAGAR POSTERIOR AL VENCIMINTO</th>
                        <th class="text-center" width="160">VALOR A PAGAR POR GASERA</th>
                    </tr>
                </thead><tbody>';
        $i=0;
        
		$query ="SELECT MANOBPQR.*, manobra.MOBRDESC
                 FROM MANOBPQR manobpqr
                 INNER JOIN manobra ON manobra.MOBRCODI = MANOBPQR.MOPQMOBR
                 WHERE manobra.MOBRVISI = 1 AND MANOBPQR.MOPQPQR = ".$_REQUEST["cod"]."
                 ORDER BY manobra.MOBRCODI";
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){

                $i++;                     
                $table.='
                        <tr id="trSelect'.$i.'" class="trDefault">
                            <td style="width:50px;">
                                <input type="hidden" id="txtCodOrg'.$i.'" value="'.$row['MOPQMOBR'].'" readonly>
                                <input type="text" id="txtCod'.$i.'" class="form-control text-center input-sm" onkeypress="solonumerosEnter('.$i.')" value="'.$row['MOPQMOBR'].'" onclick="swEditor(\'txtCod'.$i.'\',\'trSelect'.$i.'\',2,'.$i.')">
                                <input type="hidden" id="txtTipo'.$i.'" value="1">
                            </td>
                            <td>
                                <input readonly type="text" id="txtNomb'.$i.'" class="form-control input-sm" value="'.$row['MOBRDESC'].'" onclick="swEditor(\'txtNomb'.$i.'\',\'trSelect'.$i.'\',0,0)">
                            </td>
                            <td>
                                <input type="text" id="txtCantMax'.$i.'" class="form-control text-center input-sm" onkeypress="solonumeros()" value="'.$row['MOPQCANT'].'" onclick="swEditor(\'txtCantMax'.$i.'\',\'trSelect'.$i.'\'0,0)">
                            </td>

                            <td>
                                <input type="text" id="txtValorPag'.$i.'" class="form-control text-center input-sm" onkeypress="solonumeros()" value="'.$row['MAPQVLOR'].'" onclick="swEditor(\'txtValorPag'.$i.'\',\'trSelect'.$i.'\'0,0)">
                            </td>
                            <td>
                                <input type="text" id="txtValorVec'.$i.'" class="form-control text-center input-sm" onkeypress="solonumeros()" value="'.$row['MAPQVLDB'].'" onclick="swEditor(\'txtValorVec'.$i.'\',\'trSelect'.$i.'\'0,0)">
                            </td>
                            <td>
                                <input type="text" id="txtValorGas'.$i.'" class="form-control text-center input-sm" onkeypress="solonumeros()" value="'.$row['MAPQVGAS'].'" onclick="swEditor(\'txtValorGas'.$i.'\',\'trSelect'.$i.'\'0,0)">
                            </td>
                            
                        </tr>
                        ';
            }   
        }
        echo '<input type="hidden" id="contRow" value="'.$i.'">'.$table.'</tbody>';
        //echo $query;
	}
	if($_REQUEST["accion"]=="seleccionar_manoObra"){
		$dato='';
		$query ="SELECT MOBRCODI,MOBRDESC FROM manobra WHERE MOBRCODI = ".$_REQUEST["cod"]." AND MOBRVISI=1 ";
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                	$dato = $row['MOBRDESC'];                              
                }   
            }
            echo $dato;
	}
	if($_REQUEST["accion"]=="guardar_registros"){
        if( $_REQUEST["cant"]=='' ){ $_REQUEST["cant"]=0; }
        if( $_REQUEST["vPagar"]=='' ){ $_REQUEST["vPagar"]=0; }
        if( $_REQUEST["vVenci"]=='' ){ $_REQUEST["vVenci"]=0; }
		if( $_REQUEST["vGaser"]=='' ){ $_REQUEST["vGaser"]=0; }

        $query ="INSERT INTO manobpqr (MOPQPQR, MOPQMOBR, MOPQCANT, MAPQVLOR, MAPQVLDB, MAPQVGAS) 
                VALUES (".$_REQUEST["codPqr"].",".$_REQUEST["cod"].",".$_REQUEST["cant"].",".$_REQUEST["vPagar"].",".$_REQUEST["vVenci"].",".$_REQUEST["vGaser"].")";
        echo $query;
        /*$respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }*/
	}
	if($_REQUEST["accion"]=="editar_registros"){
        if( $_REQUEST["cant"]=='' ){ $_REQUEST["cant"]=0; }
        if( $_REQUEST["vPagar"]=='' ){ $_REQUEST["vPagar"]=0; }
        if( $_REQUEST["vVenci"]=='' ){ $_REQUEST["vVenci"]=0; }
        if( $_REQUEST["vGaser"]=='' ){ $_REQUEST["vGaser"]=0; }

        $query ="UPDATE manobpqr SET MOPQMOBR=".$_REQUEST["cod"].", MOPQCANT=".$_REQUEST["cant"].",
		         MAPQVLOR=".$_REQUEST["vPagar"].", MAPQVLDB=".$_REQUEST["vVenci"].", MAPQVGAS=".$_REQUEST["vGaser"]."
		         WHERE MOPQPQR=".$_REQUEST["codPqr"]." AND MOPQMOBR=".$_REQUEST["codOrg"];
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