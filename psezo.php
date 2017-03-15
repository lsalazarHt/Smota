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
				                	<div class="col-md-12">
				                		<table id="tableDepa" class="table table-bordered table-hover table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center">CODIGO</th>
					                              	<th class="text-left">NOMBRE</th>
					                            </tr>
					                        </thead>
					                        <tbody>
					                        	<?php 
		                                            //$conn = require 'inc/clases/conexion.php';
		                                            $query ='SELECT * FROM departam WHERE DEPAVISI=1 ORDER BY DEPADESC';
		                                            $respuesta = $conn->prepare($query) or die ($sql);
		                                            if(!$respuesta->execute()) return false;
		                                            if($respuesta->rowCount()>0){
		                                                while ($row=$respuesta->fetch()){
		                                                    echo 
		                                                    	'<tr>
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
	            <div class="modal fade" id="modalLocalidades">
	             	<div class="modal-dialog">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">LOCALIDADES</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12" style="height: 400px; overflow-y: scroll;">
				                		<table id="tableLoca" class="table table-bordered table-hover table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center" width="100">CODIGO</th>
					                              	<th class="text-left">NOMBRE</th>
					                            </tr>
					                        </thead>
					                        <tbody id="divLocalidadesDepartamento">
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
				                	<div class="col-md-12" style="height: 400px; overflow-y: scroll;">
				                		<table id="tableZona" class="table table-bordered table-hover table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center" width="100">CODIGO</th>
					                              	<th class="text-left">NOMBRE</th>
					                            </tr>
					                        </thead>
					                        <tbody id="divZonasLocalidadesDepartamento">
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
				                	<div class="col-md-12" style="height: 400px; overflow-y: scroll;">
				                		<table id="tableSectores" class="table table-bordered table-hover table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center" width="100">CODIGO</th>
					                              	<th class="text-left">NOMBRE</th>
					                            </tr>
					                        </thead>
					                        <tbody id="divSectoresZonas">
					                        	<?php 
		                                            //$conn = require 'inc/clases/conexion.php';
		                                            $query ='SELECT * FROM sectores WHERE SEOPVISI=1 ORDER BY SEOPCODI DESC';
		                                            $respuesta = $conn->prepare($query) or die ($sql);
		                                            if(!$respuesta->execute()) return false;
		                                            if($respuesta->rowCount()>0){
		                                                while ($row=$respuesta->fetch()){
		                                                    echo 
		                                                    	'<tr onclick="seleccionarSector('.$row['SEOPCODI'].',\''.$row['SEOPNOMB'].'\')">
		                                                    		<td class="text-center">'.$row['SEOPCODI'].'</td>
		                                                    		<td>'.$row['SEOPNOMB'].'</td>
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
	                	<li><a href="#">Informacion Basica</a></li>
	                	<li class="active">Sectores Operativos de la Zona Operativa</li>
	             	</ol>
	            </section>

				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="box">
								<div class="box-header">
			                     	<h3 class="box-title">Zonas Operativas de Localidad</h3>
			                    </div><!-- /.box-header -->
			                    <div class="box-body">
			                    	<div id="divListaDepartamentos" class="display-none"></div>
			                    	<div class="row">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtCodDepar" class="col-sm-2 control-label text-right" style="margin-top:5px;">Departamento</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control" id="txtCodDepar" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-5">
				                        		<input type="text" class="form-control" id="txtNomDepar" placeholder="Nombre de Departamento" readonly>
				                      		</div>
				                      		<div class="col-sm-2">
				                      			<a class="btn btn-success btn btn-sm" onclick="buscarCiudadesDepartamento()" data-toggle="tooltip" data-original-title="Buscar Ciudades"><i class="fa fa-search"></i></a>
				                      		</div>
					                    </div>
				                	</div>
				                	<div id="divListaCiudades" class="display-none"></div>
				                    <br>
				                    <div class="row">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtCodLoca" class="col-sm-2 control-label text-right" style="margin-top:5px;">Ciudad</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control" id="txtCodLoca" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-5">
				                        		<input type="text" class="form-control" id="txtNomLoca" placeholder="Nombre de Ciudad" readonly>
				                      		</div>
				                      		<div class="col-sm-2">
				                      			<a class="btn btn-success btn btn-sm" onclick="buscarZonasOperativas()" data-toggle="tooltip" data-original-title="Buscar Zonas Operativas"><i class="fa fa-search"></i></a>
				                      		</div>
					                    </div>
				                	</div> 
				                	<div id="divListaZonas" class="display-none"></div>
				                    <br>
				                    <div class="row">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtCodZona" class="col-sm-2 control-label text-right" style="margin-top:5px;">Zona</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control" id="txtCodZona" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-5">
				                        		<input type="text" class="form-control" id="txtNomZona" placeholder="Nombre de Zona" readonly>
				                      		</div>
				                      		<div class="col-sm-2">
				                      			<a class="btn btn-success btn btn-sm" onclick="buscarSectoresZonasOperativas()" data-toggle="tooltip" data-original-title="Buscar Sectores Operativos"><i class="fa fa-search"></i></a>
				                      		</div>
					                    </div>
				                	</div>      
			                    </div>
							</div>

							<div class="box">
								<div class="box-header">
			                     	<h3 class="box-title">Sectores Operativos de la Zona Operativa</h3>
			                    </div><!-- /.box-header -->
			                    <div class="box-body" style="height: 210px; overflow-y: scroll;">
			                    	<table id="table" class="table table-bordered table-condensed">
				                        <thead>
				                            <tr style="background-color: #3c8dbc; color:white;">
				                             	<th class="text-center" width="100">CODIGO</th>
				                              	<th class="text-left">SECTOR</th>
				                              	<th class="text-center" width="100">VISIBLE</th>
				                            </tr>
				                        </thead>
				                        <tbody>
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
<script src="js/psezo.js"></script>