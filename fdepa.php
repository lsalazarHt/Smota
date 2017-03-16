<?php require 'template/start.php'; ?>
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
	                	<li class="active">Departamento</li>
	             	</ol>
	            </section>

				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="box">
								<div class="box-header">
			                     	<h3 class="box-title">Departamento</h3>
			                    </div><!-- /.box-header -->
			                    <div class="box-body" style="height: 425px; overflow-y: scroll;">
			                    	<table id="table" class="table table-bordered table-condensed">
				                        <thead>
				                            <tr style="background-color: #3c8dbc; color:white;">
				                             	<th class="text-center" width="100">CODIGO</th>
				                             	<th class="text-left">NOMBRE</th>
				                             	<th class="text-center" style="width:50px;">VISIBLE</th>
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
<script src="js/fdepa.js"></script>
<!--  Detectar cambios en las Formas    -->
<script src="assets/js/detectaCambiosEnFormas.js"></script>
<!--  Notifications Plugin    -->
	<script src="assets/js/bootstrap-notify.js"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
	 <script src="assets/js/demo.js"></script>