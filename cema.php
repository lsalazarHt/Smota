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
		                                                    		<td>'.str_pad($row['DEPACODI'],2,"0", STR_PAD_LEFT).'</td>
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
	            <div class="modal fade" id="modalTecnicos">
	             	<div class="modal-dialog">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">TECNICOS</h4>
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
		                                            $query ="SELECT * FROM tecnico WHERE TECNESTA='A'";
		                                            $respuesta = $conn->prepare($query) or die ($sql);
		                                            if(!$respuesta->execute()) return false;
		                                            if($respuesta->rowCount()>0){
		                                                while ($row=$respuesta->fetch()){
		                                                    echo 
		                                                    	'<tr onclick="addTecnico(\''.$row['TECNCODI'].'\',\''.$row['TECNNOMB'].'\')">
		                                                    		<td class="text-center">'.$row['TECNCODI'].'</td>
		                                                    		<td>'.$row['TECNNOMB'].'</td>
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
		                                                    	'<tr onclick="addPqr(\''.$row['PQRCODI'].'\',\''.$row['PQRDESC'].'\')">
		                                                    		<td class="text-center">'.$row['PQRCODI'].'</td>
		                                                    		<td>'.$row['PQRDESC'].'</td>
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
	            <div class="modal fade" id="modalZonas">
	             	<div class="modal-dialog">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">ZONAS</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12" style="height: 298px; overflow-y: scroll;">
				                		<table class="tableJs table table-bordered table-hover table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center" width="100">CODIGO</th>
					                              	<th class="text-left">NOMBRE</th>
					                            </tr>
					                        </thead>
					                        <tbody id="divZonas">
					                        	
					                        </tbody>
					                    </table>
				                	</div>
			                	</div>
			                </div>
	                	</div><!-- /.modal-content -->
	               	</div><!-- /.modal-dialog -->
	            </div>
	            <div class="modal fade" id="modalSectores">
	             	<div class="modal-dialog">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">SECTORES</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12" style="height: 298px; overflow-y: scroll;">
				                		<table class="tableJs table table-bordered table-hover table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center" width="100">CODIGO</th>
					                              	<th class="text-left">NOMBRE</th>
					                            </tr>
					                        </thead>
					                        <tbody id="divSectores">
					                        	
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
	                	<li class="active">Registro masivo de certificacion</li>
	             	</ol>
	            </section>

				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="box">
								<div class="box-header">
			                     	<h3 class="box-title">Certificacion masiva de ordenes </h3>
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
					                     	<label for="txtClase" class="col-sm-2 control-label" style="margin-top:5px;">Metodo de Certificacion</label>
				                      		<div class="col-sm-3">
				                      			<input type="radio" name="metdAsign"  style="margin-top: 8px;"> Por bloque &nbsp;&nbsp;
				                      			<input type="radio" name="metdAsign"> Escogencia Multiple
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
				                        		<input type="text" class="form-control input-sm" id="txtLocNomb" placeholder="Nombre de la Localidad" readonly>
				                      		</div>
					                     	<label for="txtClase" class="col-sm-4 control-label" style="margin-top:5px;">Criterio de Ordenamiento</label>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Sector</label>
					                     	<div class="col-sm-1">
				                        		<input type="text" class="form-control input-sm" id="txtPqrCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
					                     	<label class="col-sm-1 control-label text-center" style="margin-top:5px;"><small>Cero Todos</small></label>
				                      		<div class="col-sm-3">
				                        		<input type="text" class="form-control input-sm" id="txtPqrNomb" placeholder="Nombre del Sector" readonly>
				                      		</div>
				                      		<div class="col-sm-4 text-center" style="border: solid 1px; margin-left: 50px; background-color: #808080; color:white;">
				                      			<small style="margin-top: 8px;">
					                      			<input type="radio" name="metdAsign"> Direccion &nbsp; 
					                      			<input type="radio" name="metdAsign"> Ruta &nbsp; 
					                      			<input type="radio" name="metdAsign"> Fecha &nbsp; 
					                      			<input type="radio" name="metdAsign"> PQR &nbsp; 
					                      			<input type="radio" name="metdAsign"> Sector &nbsp; 
					                      			<input type="radio" name="metdAsign"> Usuario &nbsp; 
				                      			</small>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Codigo de Pqr</label>
					                     	<div class="col-sm-1">
				                        		<input type="text" class="form-control input-sm" id="txtPqrCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
					                     	<label class="col-sm-1 control-label text-center" style="margin-top:5px;"><small>Cero Todos</small></label>
				                      		<div class="col-sm-3">
				                        		<input type="text" class="form-control input-sm" id="txtPqrNomb" placeholder="Nombre del Pqr" readonly>
				                      		</div>
				                      		<div class="col-sm-4 text-center">
				                      			<a class="btn btn-sm btn-default"> Mostrar ordenes segun Criterio</a>&nbsp;&nbsp;
				                      			<a class="btn btn-sm btn-default"> Limpiar Pantalla</a>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Codigo Tecnico</label>
					                     	<div class="col-sm-1">
				                        		<input type="text" class="form-control input-sm" id="txtTecCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-4">
				                        		<input type="text" class="form-control input-sm" id="txtTecNomb" placeholder="Nombre de Tecnico" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Usuario</label>
					                     	<div class="col-sm-1">
				                        		<input type="text" class="form-control input-sm" id="txtTecCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-4">
				                        		<input type="text" class="form-control input-sm" id="txtTecNomb" placeholder="Nombre del Usuario" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<hr>
				                	<div class="row marginTop3">
				                		<div class="col-md-12">
					                		<table id="tableMateriales" class="table table-bordered table-condensed">
					                			<tr style="background-color: #3c8dbc; color:white;">
					                				<td class="text-center" width="75">Numero de orden</td>
					                				<td class="text-center" width="70">Fecha</td>
					                				<td class="text-center" width="70">Pqr</td>
					                				<td class="text-center" width="70">Ruta</td>
					                				<td class="text-center" width="100">Usuario</td>
					                				<td class="text-center" width="100">Tecnico</td>
					                				<td class="text-center" width="200">Observacion en la Certificacion</td>
					                				<td class="text-center" width="10"><input type="checkbox"></td>
					                			</tr>
					                		</table>
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
<script src="js/paslote.js"></script>