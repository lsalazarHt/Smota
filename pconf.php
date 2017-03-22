<?php require 'template/start.php'; ?>
<!--  Material Dashboard CSS    -->
<link href="assets/css/material-dashboard.css" rel="stylesheet"/>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
<body class="hold-transition skin-blue layout-top-nav">
	<div class="wrapper">
		<?php require 'template/menu.php'; ?>
		<div class="content-wrapper">
			<div class="container">

				<div class="modal fade" id="modalDatosContratista">
	             	<div class="modal-dialog">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">DATOS BASICOS CONTRATISTA</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row display-none">
				                	<div class="form-group">
				                		<div class="col-sm-1"></div>
				                     	<label for="txtCod" class="col-sm-2 control-label" style="margin-top: 5px;">CODIGO<span class="requerido">*</span></label>
			                      		<div class="col-sm-8">
			                        		<input type="text" class="form-control" id="txtCod" placeholder="Codigo del Contratista">
			                      		</div>
				                    </div>
			                	</div>
			                	<div class="row" style="margin-top: 10px;">
				                	<div class="form-group">
				                		<div class="col-sm-1"></div>
				                     	<label for="txtNombre" class="col-sm-2 control-label" style="margin-top: 5px;">NOMBRE<span class="requerido">*</span></label>
			                      		<div class="col-sm-8">
			                        		<input type="text" class="form-control" id="txtNombre" placeholder="Nombre del Contratista">
			                      		</div>
				                    </div>
			                	</div>
			                </div>
		                  	<div class="modal-footer">
		                    	<button type="button" class="btn btn-primary" onclick="guardarDatosContratista()">Guardar</button>
		                  	</div>
	                	</div><!-- /.modal-content -->
	               	</div><!-- /.modal-dialog -->
	            </div>

				<section class="content-header">
	             	<?php include 'template/sub_menu.php' ?>
					<a id="btnConfg" onclick="datosContratista()" class="btn btn-info btn-xs" data-toggle="tooltip" data-original-title="Datos del Contratista"><i class="fa fa-cogs"></i></a>
	            	<ol class="breadcrumb">
	                	<li><a href="#">Informacion Basica</a></li>
	                	<li class="active">Parametros del Sistema</li>
	             	</ol>
	            </section>

				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="box">
								<div class="box-header">
			                     	<h3 class="box-title">Parametros del Sistema</h3>
			                    </div><!-- /.box-header -->
			                    <div class="box-body" style="height: 425px; overflow-y: scroll;">
			                    	<table id="table" class="table table-bordered table-condensed">
				                        <thead>
				                            <tr style="background-color: #3c8dbc; color:white;">
				                             	<th class="text-center" width="200">CODIGO</th>
				                             	<th class="text-center" width="150">VALOR NUMERICO</th>
				                             	<th class="text-center" width="150">VALOR CARACTER</th>
				                              	<th class="text-center">OBSERVACION</th>
				                              	<th class="text-center" width="50">VISIBLE</th>
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
<script src="js/pconf.js"></script>
<!--  Detectar cambios en las Formas    -->
<script src="assets/js/detectaCambiosEnFormas.js"></script>
<!--  Seleccionar nuevo Item Talas    -->
<script src="assets/js/selectedNewRow.js"></script>
<!--  Notifications Plugin    -->
<script src="assets/js/bootstrap-notify.js"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="assets/js/demo.js"></script>