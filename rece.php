<?php 
	date_default_timezone_set('America/Bogota');
	require 'template/start.php'; 
?>
<body class="hold-transition skin-blue layout-top-nav">
	<div class="wrapper">
		<?php require 'template/menu.php'; ?>
		<div class="content-wrapper">
			<div class="container">

				<section class="content-header">
	             	<?php include 'template/sub_menu.php' ?>
	            	<ol class="breadcrumb">
	                	<li><a href="#">Ordenes</a></li>
	                	<li><a href="#">Reportes</a></li>
	                	<li class="active">Listado Ordenes para Certificacion por Rango</li>
	             	</ol>
	            </section>

				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="box">
								<div class="box-header">
			                     	<h3 class="box-title">Listado de ordenes para Certificar </h3>
			                    </div><!-- /.box-header -->
			                    <div class="box-body">
			                    	<input type="hidden" id="swEstadoTecnico" value="0" readonly>
			                    	<div id="divConsultarTecnicos" class="display-none"></div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Fecha Inicial</label>
					                     	<div class="col-sm-2">
				                        		<input type="hidden" id="txtFechaOrg" value="<?php echo date('Y-m-d') ?>">
				                        		<input type="date" class="form-control input-sm" id="txtFecInicial" value="<?php echo date('Y-m-d') ?>">
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Fecha Fin</label>
					                     	<div class="col-sm-2">
				                        		<input type="date" class="form-control input-sm" id="txtFecFin" value="<?php echo date('Y-m-d') ?>">
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
<script src="js/rece.js"></script>