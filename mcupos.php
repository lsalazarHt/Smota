<?php require 'template/start.php'; ?>
<!--  Material Dashboard CSS    -->
<link href="assets/css/material-dashboard.css" rel="stylesheet"/>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
<body class="hold-transition skin-blue layout-top-nav">
	<div class="wrapper">
		<?php require 'template/menu.php'; ?>
		<div class="content-wrapper">
			<div class="container">
				
				<div class="modal fade" id="modalBodega" >
	             	<div class="modal-dialog" style="width:70%">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">BODEGAS</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12">
				                		<table id="tableBodega" class="table table-bordered table-hover table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center" width="100">CODIGO</th>
					                              	<th class="text-left">NOMBRE</th>
					                            </tr>
					                        </thead>
					                        <tbody>
					                        	<?php 
		                                            //$conn = require 'inc/clases/conexion.php';
		                                            $query ="SELECT * FROM bodega WHERE BODEESTA = 'A' ORDER BY BODECODI";
		                                            $respuesta = $conn->prepare($query) or die ($sql);
		                                            if(!$respuesta->execute()) return false;
		                                            if($respuesta->rowCount()>0){
		                                                while ($row=$respuesta->fetch()){
		                                                    echo 
		                                                    	'<tr onclick="colocarBodega('.$row['BODECODI'].',\''.utf8_encode($row['BODENOMB']).'\')">
		                                                    		<td>'.$row['BODECODI'].'</td>
		                                                    		<td>'.utf8_encode($row['BODENOMB']).'</td>
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


	            <div class="modal fade" id="modalMaterial" >
	             	<div class="modal-dialog" style="width:70%">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">MATERIALES</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12">
				                		<table id="tableMaterial" class="table table-bordered table-hover table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center" width="100">CODIGO</th>
					                              	<th class="text-left">NOMBRE</th>
					                            </tr>
					                        </thead>
					                        <tbody>
					                        	<?php 
		                                            //$conn = require 'inc/clases/conexion.php';
		                                            $query ="SELECT M.MATECODI, M.MATEDESC, C.CLMADESC 
			                                            	FROM material M JOIN clasmate C ON C.CLMACODI = M.MATECLAS 
															WHERE MATEESTA = 'A'
															ORDER BY MATEDESC";
		                                            $respuesta = $conn->prepare($query) or die ($sql);
		                                            if(!$respuesta->execute()) return false;
		                                            if($respuesta->rowCount()>0){
		                                                while ($row=$respuesta->fetch()){
		                                                    echo 
		                                                    	'<tr onclick="colocarMaterial('.$row['MATECODI'].',\''.utf8_encode($row['MATEDESC']).'\')">
		                                                    		<td>'.$row['MATECODI'].'</td>
		                                                    		<td>'.utf8_encode($row['MATEDESC']).'</td>
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

	            <!-- <div class="modal fade" id="modalMaterial">
	             	<div class="modal-dialog">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">MATERIALES</h4>
			                </div>
			                <div class="modal-body">
			                	<div class="row">
				                	<div class="col-md-12">
				                		<table id="tableDepa" class="table table-bordered table-hover table-condensed">
					                        <thead>
					                            <tr style="background-color: #3c8dbc; color:white;">
					                             	<th class="text-center" width="100">CODIGO</th>
					                              	<th class="text-left">NOMBRE</th>
					                            </tr>
					                        </thead>
					                        <tbody>
					                        	<?php 
		                                            //$conn = require 'inc/clases/conexion.php';
		             //                                $query ='SELECT M.MATECODI, M.MATEDESC, C.CLMADESC 
			            //                                 	FROM material M JOIN clasmate C ON C.CLMACODI = M.MATECLAS 
															// WHERE MATEESTA = "A"
															// ORDER BY MATEDESC';
		             //                                $respuesta = $conn->prepare($query) or die ($sql);
		             //                                if(!$respuesta->execute()) return false;
		             //                                if($respuesta->rowCount()>0){
		             //                                    while ($row=$respuesta->fetch()){
		             //                                        echo 
		             //                                        	'<tr onClick="colocarClase(\''.$row['MATECODI'].'\',\''.$row['MATECODI'].'\')">
		             //                                        		<td class="text-center">'.$row['MATECODI'].'</td>
		             //                                        		<td class="text-left">'.$row['MATEDESC'].'</td>
		             //                                        	</tr>';                                   
		             //                                    }   
		             //                                }
		                                        ?>
					                        </tbody>
					                    </table>
				                	</div>
			                	</div>
			                </div>
	                	</div>
	               	</div>
	            </div> -->
				
				<section class="content-header">
	             	<?php include 'template/sub_menu.php' ?>
	            	<ol class="breadcrumb">
	                	<li><a href="#">Cuadrillas</a></li>
	                	<li class="active">Definición de Stocks de Técnicos</li>
	             	</ol>
	            </section>

				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="box">
								<div class="box-header">
			                     	<h3 class="box-title">Bodega</h3>
			                    </div><!-- /.box-header -->
			                    <div class="box-body">
			                    	<div id="divLista" class="display-none"></div>
			                    	<div class="row">
					                	<div class="form-group">
					                		<div class="col-sm-1">
					                			<label for="txtNom" class="col-sm-2 control-label text-right" style="margin-top:5px;">Codigo</label>
					                		</div>
					                     	<div class="col-sm-2">
				                        		<input type="text" class="form-control" id="txtCodBodega" placeholder="Codigo" onkeypress="solonumeros()" onclick="swEditor(null,null,1,null)">
				                      		</div>
				                      		<div class="col-sm-7">
				                        		<input type="text" class="form-control" id="txtNomBodega" placeholder="Nombre de la Bodega" readonly>
				                      		</div>
				                      		<div class="col-sm-2">
				                      			<a class="btn btn-success btn btn-sm" onclick="btn_buscarNombreBodega()"><i class="fa fa-search"></i></a>
				                      		</div>
					                    </div>
				                	</div>
				                    <br>          
			                    </div>
							</div>
							<div class="box">
								<div class="box-header">
			                     	<h3 class="box-title">Materiales</h3>
			                   </div>
			                    <div class="box-body" style="height: 298px; overflow-y: scroll;">
			                    	<table class="table table-bordered table-condensed" id="table_materiales">
				                        <thead>
				                            <tr style="background-color: #3c8dbc; color:white;">
				                             	<th class="text-center" width="100">CODIGO</th>
				                              	<th class="text-left">NOMBRE MATERIAL</th>
				                              	<th class="text-right" width="100">CANTIDAD INV PROPIA</th>
				                              	<th class="text-right" width="170">VALOR INV PROPIO</th>
				                              	<th class="text-right" width="100">CANTIDAD INV PRESTADA</th>
				                              	<th class="text-right" width="170">VALOR INV PRESTADO</th>
				                              	<th class="text-right" width="80">CUPO</th>
				                              	<th class="text-right" width="80">CUPO EXTRA</th>
				                            </tr>
				                        </thead>
				                        <tbody id="table_detalle_inventario">
				                        	
				                        </tbody>
				                    </table>
			                    </div>
							</div>
							<div class="box">
			                    <div class="box-body">
			                    	<table class="table">
			                            <tr>
			                             	<th width="100"></th>
			                              	<th ></th>
			                              	<th width="100">TOTAL</th>
			                              	<th width="170"><input id="txtTotalInvPropio" class="form-control input-sm text-right" type="text" readonly></th>
			                              	<th width="100">TOTAL</th>
			                              	<th width="170"><input id="txtTotalInvPrestado" class="form-control input-sm text-right" type="text" readonly></th>
			                              	<th width="80"></th>
			                              	<th width="80"></th>
			                            </tr>
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
<script src="js/mcupos.js"></script>
<!--  Detectar cambios en las Formas    -->
<script src="assets/js/detectaCambiosEnFormas.js"></script>
<!--  Seleccionar nuevo Item Talas    -->
<script src="assets/js/selectedNewRow.js"></script>
<!--  Notifications Plugin    -->
<script src="assets/js/bootstrap-notify.js"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="assets/js/demo.js"></script>