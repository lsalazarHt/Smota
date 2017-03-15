<?php require 'template/start.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
	<div class="wrapper">
		<?php require 'template/menu.php'; ?>
		<div class="content-wrapper">
			<div class="container">
				
				<div class="modal fade" id="newModal">
	             	<div class="modal-dialog">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">NUEVO DEPARTAMENTO</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="form-group">
				                		<div class="col-sm-1"></div>
				                     	<label for="txtCod" class="col-sm-2 control-label" style="margin-top: 5px;">CODIGO<span class="requerido">*</span></label>
			                      		<div class="col-sm-8">
			                        		<input type="text" class="form-control" id="txtCod" placeholder="Codigo del Departamento">
			                      		</div>
				                    </div>
			                	</div>
			                	<div class="row" style="margin-top: 10px;">
				                	<div class="form-group">
				                		<div class="col-sm-1"></div>
				                     	<label for="txtNombre" class="col-sm-2 control-label" style="margin-top: 5px;">NOMBRE<span class="requerido">*</span></label>
			                      		<div class="col-sm-8">
			                        		<input type="text" class="form-control" id="txtNombre" placeholder="Nombre del Departamento">
			                      		</div>
				                    </div>
			                	</div>
			                </div>
		                  	<div class="modal-footer">
		                    	<button type="button" class="btn btn-primary">Guardar</button>
		                  	</div>
	                	</div><!-- /.modal-content -->
	               	</div><!-- /.modal-dialog -->
	            </div>

	            <div class="modal fade" id="editModal">
	             	<div class="modal-dialog">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">EDITAR DEPARTAMENTO</h4>
			                </div>
			                <div class="modal-body">
				                <input type="hidden" id="txtIdE">
			                	<div class="row">
				                	<div class="form-group">
				                		<div class="col-sm-1"></div>
				                     	<label for="txtCodE" class="col-sm-2 control-label" style="margin-top: 5px;">CODIGO<span class="requerido">*</span></label>
			                      		<div class="col-sm-8">
			                        		<input type="text" class="form-control" id="txtCodE" placeholder="Codigo del Departamento">
			                      		</div>
				                    </div>
			                	</div>
			                	<div class="row" style="margin-top: 10px;">
				                	<div class="form-group">
				                		<div class="col-sm-1"></div>
				                     	<label for="txtNombreE" class="col-sm-2 control-label" style="margin-top: 5px;">NOMBRE<span class="requerido">*</span></label>
			                      		<div class="col-sm-8">
			                        		<input type="text" class="form-control" id="txtNombreE" placeholder="Nombre del Departamento">
			                      		</div>
				                    </div>
			                	</div>
			                </div>
		                  	<div class="modal-footer">
		                    	<button type="button" class="btn btn-primary">Guardar Cambios</button>
		                  	</div>
	                	</div><!-- /.modal-content -->
	               	</div><!-- /.modal-dialog -->
	            </div>
					
				<section class="content-header">
	             	<h1>&nbsp;</h1>
	            	<ol class="breadcrumb">
	                	<li><a href="#">Informacion Basica</a></li>
	                	<li class="active">Departamentos</li>
	             	</ol>
	            </section>

				<section class="content">

					<div class="row">
						<div class="col-md-12">
							<div class="box">
								<div class="box-header">
			                     	<h3 class="box-title">Departamentos</h3>
			                    </div><!-- /.box-header -->
			                    <div class="box-body">
			                    	<div class="row">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control" id="txtCodDepar" placeholder="Codigo">
				                      		</div>
				                      		<div class="col-sm-7">
				                        		<input type="text" class="form-control" id="txtNomDepar" placeholder="Nombre de Departamento">
				                      		</div>
				                      		<div class="col-sm-2">
				                      			<a class="btn btn-success" id="btnGuardar" onclick="guardarDepartamento()">Guardar</a>
				                      			<a class="btn btn-info display-none" id="btnEditar" onclick="editarDepartamento()">Editar</a>
				                      			<a class="btn btn-danger display-none" id="btnCancelar" onclick="cancelarDepartamento()">Cancelar</a>
				                      		</div>
					                    </div>
				                	</div>
				                    <br>          
			                    </div>
							</div>

							<div class="box">
								<div class="box-header">
			                     	<h3 class="box-title"></h3>
			                    </div><!-- /.box-header -->
			                    <div class="box-body">
			                    	<table id="table" class="table table-bordered table-condensed">
				                        <thead>
				                            <tr style="background-color: #3c8dbc; color:white;">
				                             	<th class="text-center">CODIGO</th>
				                              	<th class="text-left">NOMBRE</th>
				                              	<th class="text-center">ACCIONES</th>
				                            </tr>
				                        </thead>
				                        <tbody id="divDepartamento">
				                        	<?php 
	                                            //$conn = require 'inc/clases/conexion.php';
	                                            $query ='SELECT * FROM departam ORDER BY DEPADESC';
	                                            $respuesta = $conn->prepare($query) or die ($sql);
	                                            if(!$respuesta->execute()) return false;
	                                            if($respuesta->rowCount()>0){
	                                                while ($row=$respuesta->fetch()){
				                              			$editar = '<a class="btn btn-info btn-xs" data-toggle="tooltip" data-original-title="Editar" onClick="selectDepartamento('.$row['DEPACODI'].',\''.$row['DEPADESC'].'\')"><i class="fa fa-pencil"></i></a>';
				                              			$eliminar = '<a class="btn btn-danger btn-xs" data-toggle="tooltip" data-original-title="Eliminar" onClick="eliminarDepartamento('.$row['DEPACODI'].')"><i class="fa fa-times"></i></a>';
	                                                    
	                                                    echo 
	                                                    	'<tr>
	                                                    		<td>'.str_pad($row['DEPACODI'],2,"0", STR_PAD_LEFT).'</td>
	                                                    		<td>'.$row['DEPADESC'].'</td>
	                                                    		<td>'.$editar.' '.$eliminar.'</td>
	                                                    	</tr>';                                   
	                                                }   
	                                            }
	                                        ?>
				                        </tbody>
				                    </table>
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
<script src="js/fdepa.js"></script>