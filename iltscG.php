<?php require 'template/start.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
	<div class="wrapper">
		<?php require 'template/menu.php'; ?>
		<div class="content-wrapper">
			<div class="container">

	            <div class="modal fade" id="modalDepartamentos">
	             	<div class="modal-dialog">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">DEPARTAMENTOS</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12" style="height: 298px; overflow-y: scroll;">
				                		<table id="tableDepa" class="tableJs table table-bordered table-hover table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center" width="100">CODIGO</th>
					                              	<th class="text-left">NOMBRE</th>
					                            </tr>
					                        </thead>
					                        <tbody>
					                        	<?php 
		                                            //$conn = require 'inc/clases/conexion.php';
		                                            $query ='SELECT * FROM departam WHERE DEPAVISI = 1 ORDER BY DEPADESC';
		                                            $respuesta = $conn->prepare($query) or die ($sql);
		                                            if(!$respuesta->execute()) return false;
		                                            if($respuesta->rowCount()>0){
		                                                while ($row=$respuesta->fetch()){
		                                                    echo 
		                                                    	'<tr onclick="addDepartamento('.str_pad($row['DEPACODI'],2,"0", STR_PAD_LEFT).',\''.$row['DEPADESC'].'\')">
		                                                    		<td class="text-center">'.str_pad($row['DEPACODI'],2,"0", STR_PAD_LEFT).'</td>
		                                                    		<td>'.$row['DEPADESC'].'</td>
		                                                    	</tr>';                                   
		                                                }   
		                                            }
		                                        ?>
					                        </tbody>
					                    </table>
				                	</div>
			                	</div>
			                </div>
	                	</div><!-- /.modal-content -->
	               	</div><!-- /.modal-dialog -->
	            </div>
	            <div class="modal fade" id="modalLocalidad">
	             	<div class="modal-dialog">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">LOCALIDADES</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12" style="height: 298px; overflow-y: scroll;">
				                		<table id="tableDepa" class="tableJs table table-bordered table-hover table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center" width="100">CODIGO</th>
					                              	<th class="text-left">NOMBRE</th>
					                            </tr>
					                        </thead>
					                        <tbody id="divLocalidades">
					                        	
					                        </tbody>
					                    </table>
				                	</div>
			                	</div>
			                </div>
	                	</div><!-- /.modal-content -->
	               	</div><!-- /.modal-dialog -->
	            </div>
	            <div class="modal fade" id="modalPqr">
	             	<div class="modal-dialog" style="width:60%">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">PQR</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12" style="height: 298px; overflow-y: scroll;">
				                		<table id="tableDepa" class="tableJs table table-bordered table-hover table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center" width="100">CODIGO</th>
					                              	<th class="text-left">NOMBRE</th>
					                            </tr>
					                        </thead>
					                        <tbody>
					                        	<?php 
		                                            //$conn = require 'inc/clases/conexion.php';
		                                            $query ="SELECT * FROM pqr";
		                                            $respuesta = $conn->prepare($query) or die ($sql);
		                                            if(!$respuesta->execute()) return false;
		                                            if($respuesta->rowCount()>0){
		                                                while ($row=$respuesta->fetch()){
		                                                    echo 
		                                                    	'<tr onclick="addPqr(\''.$row['PQRCODI'].'\',\''.utf8_encode($row['PQRDESC']).'\')">
		                                                    		<td class="text-center">'.$row['PQRCODI'].'</td>
		                                                    		<td>'.utf8_encode($row['PQRDESC']).'</td>
		                                                    	</tr>';                                   
		                                                }   
		                                            }
		                                        ?>
					                        </tbody>
					                    </table>
				                	</div>
			                	</div>
			                </div>
	                	</div><!-- /.modal-content -->
	               	</div><!-- /.modal-dialog -->
	            </div>
	            <div class="modal fade" id="modalPqr2">
	             	<div class="modal-dialog" style="width:60%">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">PQR</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12" style="height: 298px; overflow-y: scroll;">
				                		<table id="tableDepa" class="tableJs table table-bordered table-hover table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center" width="100">CODIGO</th>
					                              	<th class="text-left">NOMBRE</th>
					                            </tr>
					                        </thead>
					                        <tbody>
					                        	<?php 
		                                            //$conn = require 'inc/clases/conexion.php';
		                                            $query ="SELECT * FROM pqr";
		                                            $respuesta = $conn->prepare($query) or die ($sql);
		                                            if(!$respuesta->execute()) return false;
		                                            if($respuesta->rowCount()>0){
		                                                while ($row=$respuesta->fetch()){
		                                                    echo 
		                                                    	'<tr onclick="addPqr2(\''.$row['PQRCODI'].'\',\''.utf8_encode($row['PQRDESC']).'\')">
		                                                    		<td class="text-center">'.$row['PQRCODI'].'</td>
		                                                    		<td>'.utf8_encode($row['PQRDESC']).'</td>
		                                                    	</tr>';                                   
		                                                }   
		                                            }
		                                        ?>
					                        </tbody>
					                    </table>
				                	</div>
			                	</div>
			                </div>
	                	</div><!-- /.modal-content -->
	               	</div><!-- /.modal-dialog -->
	            </div>
	            <div class="modal fade" id="modalTecnicos">
	             	<div class="modal-dialog" style="width:60%">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">TECNICOS</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12" style="height: 398px; overflow-y: scroll;">
				                		<table id="tableDepa" class="tableJs table table-bordered table-hover table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center" width="100">CODIGO</th>
					                              	<th class="text-left">NOMBRE</th>
					                            </tr>
					                        </thead>
					                        <tbody>
					                        	<?php 
		                                            //$conn = require 'inc/clases/conexion.php';
		                                            $query ="SELECT * FROM tecnico WHERE TECNESTA='A'";
		                                            $respuesta = $conn->prepare($query) or die ($sql);
		                                            if(!$respuesta->execute()) return false;
		                                            if($respuesta->rowCount()>0){
		                                                while ($row=$respuesta->fetch()){
		                                                    echo 
		                                                    	'<tr onclick="addTecnico(\''.$row['TECNCODI'].'\',\''.utf8_encode($row['TECNNOMB']).'\')">
		                                                    		<td class="text-center">'.$row['TECNCODI'].'</td>
		                                                    		<td>'.utf8_encode($row['TECNNOMB']).'</td>
		                                                    	</tr>';                                   
		                                                }   
		                                            }
		                                        ?>
					                        </tbody>
					                    </table>
				                	</div>
			                	</div>
			                </div>
	                	</div><!-- /.modal-content -->
	               	</div><!-- /.modal-dialog -->
	            </div>

				<section class="content-header">
	             	<?php include 'template/sub_menu.php' ?>
	            	<ol class="breadcrumb">
	                	<li><a href="#">Ordenes</a></li>
	                	<li><a href="#">Reportes</a></li>
	                	<li class="active">Listado Ordenes sin Cumplir por tecnico General</li>
	             	</ol>
	            </section>

				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="box">
								<div class="box-header">
			                     	<h3 class="box-title">Imprime OT Asignadas a Tecnicos </h3>
			                    </div><!-- /.box-header -->
			                    <div class="box-body">
			                    	<input type="hidden" id="swEstadoTecnico" value="0" readonly>
			                    	<div id="divConsultarTecnicos" class="display-none"></div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Departamento</label>
					                     	<div class="col-sm-1">
				                        		<input type="text" class="form-control input-sm" id="txtDepCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-4">
				                        		<input type="text" class="form-control input-sm" id="txtDepNomb" placeholder="Nombre del Departamento" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Localidad</label>
					                     	<div class="col-sm-1">
				                        		<input type="text" class="form-control input-sm" id="txtLocCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-4">
				                        		<input type="text" class="form-control input-sm" id="txtLocNomb" placeholder="Nombre del Localidad" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Prq Inicial</label>
					                     	<div class="col-sm-1">
				                        		<input type="text" class="form-control input-sm" id="txtPqrIniCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-4">
				                        		<input type="text" class="form-control input-sm" id="txtPqrIniNomb" placeholder="Nombre del Prq Inicial" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Prq Final</label>
					                     	<div class="col-sm-1">
				                        		<input type="text" class="form-control input-sm" id="txtPqrFinCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-4">
				                        		<input type="text" class="form-control input-sm" id="txtPqrFinNomb" placeholder="Nombre del Prq Final" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Tecnico</label>
					                     	<div class="col-sm-1">
				                        		<input type="text" class="form-control input-sm" id="txtTecnCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-4">
				                        		<input type="text" class="form-control input-sm" id="txtTecnNomb" placeholder="Nombre del Tecnico" readonly>
				                      		</div>
					                    </div>
				                	</div>
			                    </div>
							</div>

						</div>
					</div>
				</section>

			</div>
		</div>
		<?php require 'template/footer.php'; ?>
	</div>
</body>
<?php require 'template/end.php'; ?>
<script src="js/iltscG.js"></script>