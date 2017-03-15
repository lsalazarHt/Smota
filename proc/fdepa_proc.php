<?php 
	$conn = require '../template/sql/conexion.php';

	if($_REQUEST["accion"]=="guardar_departamento"){
		$query ="INSERT INTO departam (DEPACODI,DEPADESC) 
                VALUES (".$_REQUEST["cod"].",'".$_REQUEST["nom"]."')";
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
	}

	if($_REQUEST["accion"]=="editar_departamento"){
		$query ="UPDATE departam SET DEPADESC='".$_REQUEST["nom"]."' WHERE DEPACODI=".$_REQUEST["cod"];
        $respuesta = $conn->prepare($query) or die ($query);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
	}

	if($_REQUEST["accion"]=="eliminar_departamento"){
		$query ="DELETE FROM departam WHERE DEPACODI=".$_REQUEST["cod"];
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()){
            echo 'Error!';
        }else{
            echo 1;
        }
	}

	if($_REQUEST["accion"]=="actualizar_departamento"){
		$table='';
		$query ='SELECT DEPACODI,DEPADESC FROM departam';
            $respuesta = $conn->prepare($query) or die ($sql);
            if(!$respuesta->execute()) return false;
            if($respuesta->rowCount()>0){
                while ($row=$respuesta->fetch()){
                    $editar = '<a class="btn btn-info btn-xs" data-toggle="tooltip" data-original-title="Editar" onClick="selectDepartamento('.$row['DEPACODI'].',\''.$row['DEPADESC'].'\')"><i class="fa fa-pencil"></i></a>';
				    $eliminar = '<a class="btn btn-danger btn-xs" data-toggle="tooltip" data-original-title="Eliminar" onClick="eliminarDepartamento('.$row['DEPACODI'].')"><i class="fa fa-times"></i></a>';
	                                                    
                    $table.='
                            <tr>
                                <td class="text-center" style="width:50px;">'.$row['DEPACODI'].'</td>
                                <td>'.$row['DEPADESC'].'</td>
                                <td class="text-center" style="width:50px;">'.$editar.' '.$eliminar.'</td>
                            </tr>
                            ';                                    
                }   
            }
            echo $table;
	}
?>