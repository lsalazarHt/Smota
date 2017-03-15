<?php
    date_default_timezone_set('America/Bogota');
	$conn = require '../template/sql/conexion.php';

	if($_REQUEST["accion"]=="actualizar_registros"){
		$table='<thead>
                    <tr style="background-color: #3c8dbc; color:white;">
                     	<th class="text-center" width="100">CODIGO</th>
                     	<th class="text-left">DESCRIPCION</th>
                     	<th class="text-center" width="245"></th>
                     	<th class="text-center" width="50"></th>
                     	<th class="text-center" width="200">TIPO MOV. SOPORTE</th>
                      	<th class="text-center" width="50"></th>
                      	<th class="text-center" width="200">CLASE DE BODEGA DESTINO</th>
                    </tr>
                </thead><tbody>';
        $i=0;
		$query ='SELECT tipomovi.*, clasbode.CLBODESC
				 FROM tipomovi
				 INNER JOIN clasbode ON clasbode.CLBOCODI = tipomovi.TIMVCLBO';
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                if($row['TIMOSAEN']=='E'){ 
                	$ent = 'checked="checked"';
                	$sal = '';
               	}else{ 
                	$ent = '';
                	$sal = 'checked="checked"';
                }

                if($row['TIMOPROP']=='S'){ $mInvPropio = 'checked="checked"'; }
                else{ $mInvPropio = '';}

                if($row['TIMOMVSO']=='0'){ $codTipSoport = ''; }
                else{ $codTipSoport = $row['TIMOMVSO'];}

                $i++;
                $table.='
                        <tr id="trSelect'.$i.'" class="trDefault">
                            <td>
                                <input type="hidden" id="txtCodOrg'.$i.'" class="form-control input-sm" value="'.$row['TIMOCODI'].'" readonly>
                                <input type="text" id="txtCod'.$i.'" class="form-control input-sm text-center" value="'.$row['TIMOCODI'].'" onkeypress="solonumeros()" onclick="swEditor(\'txtCod'.$i.'\',\'trSelect'.$i.'\')">
                                <input type="hidden" id="txtTipo'.$i.'" value="1">
                            </td>
                            <td>
                                <input type="text" id="txtNomb'.$i.'" class="form-control input-sm" value="'.$row['TIMODESC'].'" onclick="swEditor(\'txtNomb'.$i.'\',\'trSelect'.$i.'\')">
                            </td>
                            <td>
                            	<input type="radio" name="tipoMov'.$i.'" value="E" '.$ent.' onclick="swEditor(\'\',\'trSelect'.$i.'\')"> <small>Entrada</small> &nbsp;
                            	<input type="radio" name="tipoMov'.$i.'" value="S" '.$sal.' onclick="swEditor(\'\',\'trSelect'.$i.'\')"> <small>Salida</small> &nbsp;
                                <input type="checkbox" id="txtMInvPro'.$i.'" '.$mInvPropio.' onclick="swEditor(\'\',\'trSelect'.$i.'\')"> <small>Mueve Inv. Propio</small>
                            </td>
                            <td>
                                <input type="text" id="txtCodTipoSoporte'.$i.'" class="form-control input-sm text-center" value="'.$codTipSoport.'" onkeypress="solonumerosEnter('.$i.')" onclick="swEditor(\'\',\'trSelect'.$i.'\')">
                            </td>
                            <td>
                                <input type="text" id="txtNomTipoSoporte'.$i.'" class="form-control input-sm" value="" placeholder="Indefinido" onclick="swEditor(\'\',\'trSelect'.$i.'\')" readonly>
                            </td>
                            <td>
                                <input type="text" id="txtCodClaseBodega'.$i.'" class="form-control input-sm text-center" value="'.$row['TIMVCLBO'].'" onkeypress="solonumerosEnter('.$i.')" onclick="swEditorM(\'\',\'trSelect'.$i.'\',1,'.$i.')">
                            </td>
                            <td>
                                <input type="text" id="txtNomClaseBodega'.$i.'" class="form-control input-sm" value="'.$row['CLBODESC'].'" onclick="swEditor(\'\',\'trSelect'.$i.'\')" readonly>
                            </td>
                        </tr>
                        ';
            }   
        }
        echo '<input type="hidden" id="contRow" value="'.$i.'">'.$table.'</tbody>';
	}

	if($_REQUEST["accion"]=="validar_clase"){
        $sw=0;
        $query ='SELECT CLBOCODI,CLBODESC FROM clasbode WHERE CLBOCODI = '.$_REQUEST["cod"];
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $sw = 1;
                $dato = $row['CLBODESC'];                              
            }
        }else{
            $sw = 0;
            $dato = 0;
        }
        $arr = array($sw,$dato);
        echo json_encode($arr);
    }

    if($_REQUEST["accion"]=="guardar_registros"){
    	if($_REQUEST["tMovSop"]==''){ $_REQUEST["tMovSop"]=0; }
        $query ="INSERT INTO tipomovi (TIMOCODI, TIMODESC, TIMOSAEN, TIMOPROP, TIMOMVSO, TIMVCLBO) 
                VALUES (".$_REQUEST["cod"].",'".$_REQUEST["nom"]."','".$_REQUEST["e_s"]."',
                		'".$_REQUEST["chek"]."',".$_REQUEST["tMovSop"].",".$_REQUEST["clBodDes"].")";
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo $query;
        }else{
            echo 1;
        }
	}

	if($_REQUEST["accion"]=="editar_registros"){
        if($_REQUEST["tMovSop"]==''){ $_REQUEST["tMovSop"]=0; }
        $query ="UPDATE tipomovi
        		 SET TIMOCODI=".$_REQUEST["cod"].", TIMODESC='".$_REQUEST["nom"]."',
        		 	 TIMOSAEN='".$_REQUEST["e_s"]."', TIMOPROP='".$_REQUEST["chek"]."',
        		 	 TIMOMVSO=".$_REQUEST["tMovSop"].", TIMVCLBO=".$_REQUEST["clBodDes"]."
        		 WHERE TIMOCODI=".$_REQUEST["codOrg"];
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
    }

?>