<?php require 'template/start.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
	<div class="wrapper">
		<?php require 'template/menu.php'; ?>
		<div class="content-wrapper">
			<div class="container">
				
				<section class="content-header">
	             	<?php include 'template/sub_menu.php' ?>
	            	<ol class="breadcrumb">
	                	<li><a href="#">Informacion Basica</a></li>
	                	<li class="active">Mano de Obra</li>
	             	</ol>
	            </section>

				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="box">
								<div class="box-header">
			                     	<h3 class="box-title">Mano de Obra</h3>
			                    </div><!-- /.box-header -->
			                    <div class="box-body" style="height: 425px; overflow-y: scroll;">
			                    	<table id="table" class="table table-bordered table-condensed">
				                        <thead>
				                            <tr style="background-color: #3c8dbc; color:white;">
				                             	<th class="text-center" width="100">CODIGO</th>
				                             	<th class="text-left">NOMBRE</th>
				                             	<th class="text-center" width="130">UND DE MEDIDA</th>
				                              	<th class="text-center" width="170"></th>
				                             	<th class="text-center" width="180"></th>
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
<script src="js/pmobr.js"></script>
<!--  Detectar cambios en las Formas    -->
<script src="assets/js/detectaCambiosEnFormas.js"></script>
<!--  Seleccionar nuevo Item Talas    -->
<script src="assets/js/selectedNewRow.js"></script>