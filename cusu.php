<?php 
	require 'template/start.php';
	if(!empty($_REQUEST["txtIdUsuarioPost"])){
		$usuarioCodigo = $_REQUEST["txtIdUsuarioPost"];
		$conn = require 'template/sql/conexion.php';
		$query ="SELECT * FROM usuarios WHERE USUCODI = ".$usuarioCodigo;
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
            	$usuarioNombre = $row['USUNOMB'];                            
            	$usuarioDireccion = $row['USUDIRE'];                            
            	$usuarioRuta = $row['USURUTA'];                            
            	$usuarioMedidor = $row['USUMEDI'];                            
            	$usuarioSector = $row['USUSEOP'];                            
            	$usuarioBarrio = $row['USUNOBA'];                            
            	$usuarioDepartamento = $row['USUDEPA'];                            
            	$usuarioLocalidad = $row['USULOCA'];                            
            }

	        //SECTOR
	        $query ="SELECT SEOPNOMB FROM sectores WHERE SEOPCODI = ".$usuarioSector;
	        $respuesta = $conn->prepare($query) or die ($sql);
	        if(!$respuesta->execute()) return false;
	        if($respuesta->rowCount()>0){
	        	while ($row=$respuesta->fetch()){
	        		$usuarioSectorNomb = $row['SEOPNOMB'];  
	        	}
	        }

	        //DEPARTAMENTO
	        $query ="SELECT DEPADESC FROM departam WHERE DEPACODI = ".$usuarioDepartamento;
	        $respuesta = $conn->prepare($query) or die ($sql);
	        if(!$respuesta->execute()) return false;
	        if($respuesta->rowCount()>0){
	        	while ($row=$respuesta->fetch()){
	        		$usuarioDepartamentoNomb = $row['DEPADESC'];  
	        	}
	        }

	        //LOCALIDAD
	        $query ="SELECT LOCANOMB FROM localidad WHERE LOCACODI = ".$usuarioLocalidad;
	        $respuesta = $conn->prepare($query) or die ($sql);
	        if(!$respuesta->execute()) return false;
	        if($respuesta->rowCount()>0){
	        	while ($row=$respuesta->fetch()){
	        		$usuarioLocalidadNomb = $row['LOCANOMB'];  
	        	}
	        }
        }

        //ORDENES DEL USUARIO
        $i = 0;
        $table = '';
		$query ="SELECT OTDEPA,OTLOCA,OTNUME,OTFEORD,OTFEAS,OTCUMP,OTESTA,OTPQRREPO,OTPQRENCO,OTTECN,OTCAAT,OTCANOA  
				 FROM ot 
				 WHERE OTUSUARIO = ".$usuarioCodigo."
				 ORDER BY OTNUME";
				$i++;                     
        $respuesta = $conn->prepare($query) or die ($sql);
        if(!$respuesta->execute()) return false;
        if($respuesta->rowCount()>0){
            while ($row=$respuesta->fetch()){
                $i++;                     
                $table.='
                        <tr id="trSelect'.$i.'" class="trDefault" onClick="trSelect(\'trSelect'.$i.'\','.$row['OTNUME'].')" ondblclick="enviarOrden('.$row['OTNUME'].','.$usuarioCodigo.',\'trSelect'.$i.'\')">
                            <td class="text-center">'.$row['OTDEPA'].' - '.$row['OTLOCA'].' - '.$row['OTNUME'].'</td>
                            <td class="text-center">'.$row['OTFEORD'].'</td>
                            <td class="text-center">'.$row['OTFEAS'].'</td>
                            <td class="text-center">'.$row['OTCUMP'].'</td>
                            <td class="text-center">'.$row['OTESTA'].'</td>
                            <td class="text-center">'.$row['OTPQRREPO'].'</td>
                            <td class="text-center">'.$row['OTPQRENCO'].'</td>
                            <td class="text-center">'.$row['OTTECN'].'</td>
                            <td class="text-center">'.$row['OTCAAT'].'</td>
                            <td class="text-center">'.$row['OTCANOA'].'</td>
                        </tr>
                        ';
            }
        }
        $table.'<input type="hidden" id="contRow" value="'.$i.'">';


        echo '<script src="tools/plugins/jQuery/jQuery-2.1.4.min.js"></script>
        	<script type="text/javascript">
				$(document).ready(function () {
					$("#btnConsulta").addClass("disabled");
					$("#btnCancelar").removeClass("disabled");

					
					
				});
			</script>';
	}else{
		$usuarioCodigo='';
		$usuarioNombre = '';                            
    	$usuarioDireccion = '';                            
    	$usuarioRuta = '';                            
    	$usuarioMedidor = '';                            
    	$usuarioSector = '';                            
    	$usuarioBarrio = '';                            
    	$usuarioDepartamento = '';                            
    	$usuarioLocalidad = '';
	    $usuarioSectorNomb = '';
	    $usuarioDepartamentoNomb = '';
	    $usuarioLocalidadNomb = '';
	    $table = '';
	}
?>
<!--  Material Dashboard CSS    -->
<link href="assets/css/material-dashboard.css" rel="stylesheet"/>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
<body class="hold-transition skin-blue layout-top-nav">
	<div class="wrapper">
		<?php require 'template/menu.php'; ?> 
		<div class="content-wrapper">
			<div class="container">
				
				<section class="content-header">
	             	<?php include 'template/sub_menu.php' ?>
	            	<ol class="breadcrumb">
	                	<li><a href="#">Informacion Basica</a></li>
	                	<li class="active">Consulta de Usuarios</li>
	             	</ol>
	            </section>

				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="box">
								<div class="box-header">
			                     	<h3 class="box-title">Datos Basicos de Usuarios</h3>
			                    </div><!-- /.box-header -->
			                    <div class="box-body">
			                    	<input type="hidden" id="swEstadoPqr" value="0" readonly>
			                   	 	<div id="divConsultarPqrUsuarios" class=" display-none"></div>
			                    	<div class="row">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtCod" class="col-sm-2 control-label text-right" style="margin-top:5px;">Codigo</label>
					                     	<div class="col-sm-2">
				                        		<input <?php echo 'value="'.$usuarioCodigo.'"'; ?> type="text" class="form-control input-sm" id="txtCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
					                    </div>
				                	</div>
				                    <div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtNom" class="col-sm-2 control-label text-right" style="margin-top:5px;">Nombre</label>
				                      		<div class="col-sm-8">
				                        		<input <?php echo 'value="'.$usuarioNombre.'"'; ?> type="text" class="form-control input-sm" id="txtNom" placeholder="Nombre del Usuario" onclick="swEditor('txtNom')" readonly>  
				                      		</div>
					                    </div>
				                	</div> 
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtDirec" class="col-sm-2 control-label text-right" style="margin-top:5px;">Direccion</label>
				                      		<div class="col-sm-8">
				                        		<input <?php echo 'value="'.$usuarioDireccion.'"'; ?> type="text" class="form-control input-sm" id="txtDirec" placeholder="Direccion del Usuario" onclick="swEditor('txtDirec')" readonly>  
				                      		</div>
					                    </div>
				                	</div> 
									<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtRuta" class="col-sm-2 control-label text-right" style="margin-top:5px;">Ruta</label>
					                     	<div class="col-sm-3">
				                        		<input <?php echo 'value="'.$usuarioRuta.'"'; ?> type="text" class="form-control input-sm" id="txtRuta" placeholder="Ruta del Usuario" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtMedidor" class="col-sm-2 control-label text-right" style="margin-top:5px;">Medidor</label>
					                     	<div class="col-sm-3">
				                        		<input <?php echo 'value="'.$usuarioMedidor.'"'; ?> type="text" class="form-control input-sm" id="txtMedidor" placeholder="Medidor del Usuario" readonly>
				                      		</div>
					                    </div>
				                	</div>
									<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtCodSec" class="col-sm-2 control-label text-right" style="margin-top:5px;">Sector</label>
					                     	<div class="col-sm-2">
				                        		<input <?php echo 'value="'.$usuarioSector.'"'; ?> type="text" class="form-control input-sm" id="txtCodSec" placeholder="Codigo" onkeypress="solonumeros()" readonly>
				                      		</div>
				                      		<div class="col-sm-6">
				                        		<input <?php echo 'value="'.$usuarioSectorNomb.'"'; ?> type="text" class="form-control input-sm" id="txtNomSec" placeholder="Nombre del Sector" readonly>
				                      		</div>
					                    </div>
				                	</div>
									<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtBarr" class="col-sm-2 control-label text-right" style="margin-top:5px;">Barrio</label>
				                      		<div class="col-sm-8">
				                        		<input <?php echo 'value="'.$usuarioBarrio.'"'; ?> type="text" class="form-control input-sm" id="txtBarr" placeholder="Barrio del Usuario" onclick="swEditor('txtBarr')" readonly>  
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtCodDep" class="col-sm-2 control-label text-right" style="margin-top:5px;">Departamento</label>
					                     	<div class="col-sm-2">
				                        		<input <?php echo 'value="'.$usuarioDepartamento.'"'; ?> type="text" class="form-control input-sm" id="txtCodDep" placeholder="Codigo" onkeypress="solonumeros()" readonly>
				                      		</div>
				                      		<div class="col-sm-6">
				                        		<input <?php echo 'value="'.$usuarioDepartamentoNomb.'"'; ?> type="text" class="form-control input-sm" id="txtNomDep" placeholder="Nombre del Departamento" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtCodLoc" class="col-sm-2 control-label text-right" style="margin-top:5px;">Localidad</label>
					                     	<div class="col-sm-2">
				                        		<input <?php echo 'value="'.$usuarioLocalidad.'"'; ?> type="text" class="form-control input-sm" id="txtCodLoc" placeholder="Codigo" onkeypress="solonumeros()" readonly>
				                      		</div>
				                      		<div class="col-sm-6">
				                        		<input <?php echo 'value="'.$usuarioLocalidadNomb.'"'; ?> type="text" class="form-control input-sm" id="txtNomLoc" placeholder="Nombre de la Localidad" readonly>
				                      		</div>
					                    </div>
				                	</div>
			                    </div>
							</div>
							<div class="box">
								<div class="box-header">
			                     	<h3 class="box-title">Historial de Ordenes del Usuario</h3>
			                   </div>
			                    <div class="box-body">
			                    	<div class="row" style="height: 350px; overflow-y: scroll;">
			                    		<div class="col-sm-12 container-table-list" id="tabla_historial_ordenes">
					                    	<table class="table table-condensed table-bordered table-striped">
						                        <thead>
						                            <tr style="background-color: #3c8dbc; color:white;">
						                             	<th class="text-center" width="130">ORDEN</th>
						                              	<th class="text-center">FECHA ORDEN</th>
						                              	<th class="text-center">FECHA ASIGNACION</th>
						                              	<th class="text-center">FECHA CUMPLIMIENTO</th>
						                              	<th class="text-center">ESTADO</th>
						                              	<th class="text-center">PQR REPORTADA</th>
						                              	<th class="text-center">PQR ENCONTRADA</th>
						                              	<th class="text-center">TECNICO</th>
						                              	<th class="text-center">CAUSA ATENCION</th>
						                              	<th class="text-center">CAUSA NO ATENCION</th>
						                            </tr>
						                        </thead>
						                        <tbody>
						                        	<?php echo $table; ?>
						                        </tbody>
						                    </table>
			                    		</div>
			                    	</div>
			                    	<hr>
			                    	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtObjAsgOrd" class="col-sm-2 control-label text-right" style="margin-top:5px;">Observacion de Asignacion</label>
				                      		<div class="col-sm-9">
				                      			<textarea class="form-control input-sm" placeholder="Observacion de Asignacion de la Orden" id="txtObjAsgOrd"  onclick="swEditor('txtObjAsgOrd')" readonly></textarea>
				                      		</div>
					                    </div>
				                	</div> 
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtObjLegOrd" class="col-sm-2 control-label text-right" style="margin-top:5px;">Observacion de Legalizacion</label>
				                      		<div class="col-sm-9">
				                      			<textarea class="form-control input-sm" placeholder="Observacion de Legalizacion de la Orden" id="txtObjLegOrd"  onclick="swEditor('txtObjLegOrd')" readonly></textarea>
				                      		</div>
					                    </div>
				                	</div> 
			                    </div>
							</div>
						</div>
					</div>
				</section>

				<form method="POST" action="cusuOrden.php" class="display-none" id="formDetalleOrdenPost">
					<input type="hidden" id="txtIdOrdenPost" name="txtIdOrdenPost">
					<input type="hidden" id="txtIdUsuarioPost" name="txtIdUsuarioPost">
					<input type="hidden" id="txtISelectPost" name="txtISelectPost">
				</form>

			</div>
		</div>
		<?php require 'template/footer.php'; ?>
	</div>
</body>
<?php require 'template/end.php'; ?>
<script src="js/cusu.js"></script>
<!--  Detectar cambios en las Formas    -->
<script src="assets/js/detectaCambiosEnFormas.js"></script>
<!--  Seleccionar nuevo Item Talas    -->
<script src="assets/js/selectedNewRow.js"></script>
<!--  Notifications Plugin    -->
<script src="assets/js/bootstrap-notify.js"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="assets/js/demo.js"></script>