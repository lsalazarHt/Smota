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
				                	<div class="col-md-12">
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
	            <div class="modal fade" id="modalCausaNoAtencion">
	             	<div class="modal-dialog">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">CAUSA NO ATENCION</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12">
				                		<div style="height: 350px; overflow-y: scroll;">
					                		<table class="tableJs table table-bordered table-hover table-condensed">
						                        <thead>
						                            <tr style="background-color: #3c8dbc; color:white;">
						                             	<th class="text-center" width="100">CODIGO</th>
						                              	<th class="text-left">NOMBRE</th>
						                            </tr>
						                        </thead>
						                        <tbody>
						                        	<?php 
			                                            //$conn = require 'inc/clases/conexion.php';
			                                            $query ="SELECT * FROM causnoaten WHERE CANAESTA = 'A' ORDER BY CANADESC";
			                                            $respuesta = $conn->prepare($query) or die ($sql);
			                                            if(!$respuesta->execute()) return false;
			                                            if($respuesta->rowCount()>0){
			                                                while ($row=$respuesta->fetch()){
			                                                    echo 
			                                                    	'<tr onclick="addCausaNoAten('.str_pad($row['CANACODI'],2,"0", STR_PAD_LEFT).',\''.utf8_encode($row['CANADESC']).'\')">
			                                                    		<td>'.str_pad($row['CANACODI'],2,"0", STR_PAD_LEFT).'</td>
			                                                    		<td>'.utf8_encode($row['CANADESC']).'</td>
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
	                	</div><!-- /.modal-content -->
	               	</div><!-- /.modal-dialog -->
	            </div>

				<section class="content-header">
	             	<?php include 'template/sub_menu.php' ?>
	            	<ol class="breadcrumb">
	                	<li><a href="#">Ordenes</a></li>
	                	<li class="active">Incumplir una Orden</li>
	             	</ol>
	            </section>

				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="box">
								<div class="box-header">
			                     	<h3 class="box-title">Incumplir una OT</h3>
			                    </div><!-- /.box-header -->
			                    <div class="box-body">
			                    <input type="hidden" id="swEstadoTecnico" value="0" readonly>
			                    <div id="divConsultarTecnicos" class="display-none"></div>
			                    
			                    	<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Departamento</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm" id="txtDepCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-6">
				                        		<input type="text" class="form-control input-sm" id="txtDepNomb" placeholder="Nombre del Departamento" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Localidad</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm" id="txtLocCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-6">
				                        		<input type="text" class="form-control input-sm" id="txtLocNomb" placeholder="Nombre de la Localidad" readonly>
				                      		</div>
					                    </div>
				                	</div>
			                    	<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtCod" class="col-sm-2 control-label text-right" style="margin-top:5px;">Numero de OT</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm" id="txtCodOrd" placeholder="Numero de OT" onkeypress="solonumeros()">
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Codigo Pqr</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm" id="txtPqrCod" placeholder="Codigo" onkeypress="solonumeros()" readonly>
				                      		</div>
				                      		<div class="col-sm-6">
				                        		<input type="text" class="form-control input-sm" id="txtPqrNomb" placeholder="Nombre de Tipo de Trabajo" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Codigo Tecnico</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm" id="txtTecCod" placeholder="Codigo" onkeypress="solonumeros()" readonly>
				                      		</div>
				                      		<div class="col-sm-6">
				                        		<input type="text" class="form-control input-sm" id="txtTecNomb" placeholder="Nombre de Tecnico" readonly>
				                      		</div>
					                    </div>
				                	</div>
									<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtFechaIng" class="col-sm-3 control-label text-right" style="margin-top:5px;">Fecha Asignacion</label>
					                     	<div class="col-sm-2 marginTop3">
				                        		<input type="date" class="form-control input-sm" id="txtFechaAsig" placeholder="Codigo" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Causa no Atención</label>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control input-sm" id="txtCauAtenCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-6">
				                        		<input type="text" class="form-control input-sm" id="txtCauAtenNomb" placeholder="Nombre de Causa" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                		<div class="col-sm-1"></div>
					                     	<label for="txtNom" class="col-sm-2 control-label text-right" style="margin-top:5px;">Observacion</label>
				                      		<div class="col-sm-8">
				                      			<textarea id="txtObservIncump" class="form-control input-sm" placeholder="Observacion del incumplimiento" rows="4" onclick="editor('txtObservIncump')"></textarea>
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
<script src="js/icont.js"></script>