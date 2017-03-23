<?php 
	date_default_timezone_set('America/Bogota');
	require 'template/start.php'; 
?>
<!--  Material Dashboard CSS    -->
<link href="assets/css/material-dashboard.css" rel="stylesheet"/>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
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
		                                                    	'<tr onclick="addDepartamento(\''.str_pad($row['DEPACODI'],2,"0", STR_PAD_LEFT).'\',\''.$row['DEPADESC'].'\')">
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
					                        <tbody id="tableTecnicos">
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
	            <div class="modal fade" id="modalPqr">
	             	<div class="modal-dialog" style="width:60%">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">PQRS</h4>
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
	            <div class="modal fade" id="modalCuadrilla">
	             	<div class="modal-dialog" style="width:60%">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">CUADRILLAS</h4>
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
		                                            $query ="SELECT * FROM cuadrilla ";
		                                            $respuesta = $conn->prepare($query) or die ($sql);
		                                            if(!$respuesta->execute()) return false;
		                                            if($respuesta->rowCount()>0){
		                                                while ($row=$respuesta->fetch()){
		                                                    echo 
		                                                    	'<tr onclick="addCuadrilla(\''.$row['CUADCODI'].'\',\''.utf8_encode($row['CUADNOMB']).'\')">
		                                                    		<td class="text-center">'.$row['CUADCODI'].'</td>
		                                                    		<td>'.utf8_encode($row['CUADNOMB']).'</td>
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
	            <div class="modal fade" id="modalEstado">
	             	<div class="modal-dialog" style="width:60%">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">ESTADOS</h4>
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
		                                            $query ="SELECT * FROM estaot";
		                                            $respuesta = $conn->prepare($query) or die ($sql);
		                                            if(!$respuesta->execute()) return false;
		                                            if($respuesta->rowCount()>0){
		                                                while ($row=$respuesta->fetch()){
		                                                    echo 
		                                                    	'<tr onclick="addEstado(\''.$row['ESOTCODI'].'\',\''.utf8_encode($row['ESOTDESC']).'\')">
		                                                    		<td class="text-center">'.$row['ESOTCODI'].'</td>
		                                                    		<td>'.utf8_encode($row['ESOTDESC']).'</td>
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
	            <div class="modal fade" id="modalUsuario">
	             	<div class="modal-dialog" style="width:60%">
	                	<div class="modal-content">
			                <div class="modal-header" style="background-color: #3c8dbc; color:white;">
			                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title">USUARIOS</h4>
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
		                                            $query ="SELECT * FROM usuarios";
		                                            $respuesta = $conn->prepare($query) or die ($sql);
		                                            if(!$respuesta->execute()) return false;
		                                            if($respuesta->rowCount()>0){
		                                                while ($row=$respuesta->fetch()){
		                                                    echo 
		                                                    	'<tr onclick="addUsuario(\''.$row['USUCODI'].'\',\''.utf8_encode($row['USUNOMB']).'\')">
		                                                    		<td class="text-center">'.$row['USUCODI'].'</td>
		                                                    		<td>'.utf8_encode($row['USUNOMB']).'</td>
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
	                	<li><a href="#">Consulta</a></li>
	                	<li class="active">Consulta Masiva de Ordenes</li>
	             	</ol>
	            </section>

				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="box">
								<div class="box-header">
			                     	<h3 class="box-title">Consulta Masiva de Ordenes </h3>
			                    </div><!-- /.box-header -->
			                    <div class="box-body">
			                    	<input type="hidden" id="swEstadoTecnico" value="0" readonly>
			                    	<div id="divConsultarTecnicos" class="display-none"></div>
			                    	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Departamento</label>
					                     	<div class="col-sm-1">
				                        		<input type="text" class="form-control input-sm e e1 key" id="txtDepCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-3">
				                        		<input type="text" class="form-control input-sm" id="txtDepNomb" placeholder="Nombre del Departamento" readonly>
				                      		</div>
					                     	<label for="txtCuaCod" class="col-sm-1 control-label" style="margin-top:5px;">Cuadrilla</label>
				                      		<div class="col-sm-1">
				                        		<input type="text" class="form-control input-sm e e2 key" id="txtCuaCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-3">
				                        		<input type="text" class="form-control input-sm" id="txtCuaNomb" placeholder="Nombre del Departamento" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Localidad</label>
					                     	<div class="col-sm-1">
				                        		<input type="text" class="form-control input-sm e e3 key" id="txtLocCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-3">
				                        		<input type="text" class="form-control input-sm" id="txtLocNomb" placeholder="Nombre de la Localidad" readonly>
				                      		</div>
					                     	<label for="txtClase" class="col-sm-1 control-label" style="margin-top:5px;">Estado</label>
					                     	<div class="col-sm-1">
				                        		<input type="text" class="form-control input-sm e e4 key" id="txtEstCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-3">
				                        		<input type="text" class="form-control input-sm" id="txtEstNomb" placeholder="Nombre del Estado" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Zona</label>
					                     	<div class="col-sm-1">
				                        		<input type="text" class="form-control input-sm e e5 key" id="txtZonaCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-3">
				                        		<input type="text" class="form-control input-sm" id="txtZonaNomb" placeholder="Nombre de la Zona" readonly>
				                      		</div>
				                      		<label for="txtClase" class="col-sm-1 control-label" style="margin-top:5px;">Fecha Inic</label>
					                     	<div class="col-sm-2">
				                        		<input type="date" class="form-control input-sm e e6" id="txtFechaInicial" placeholder="Fecha" <?php echo 'value="'.date('Y-m-d').'"'; ?>>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Sector</label>
					                     	<div class="col-sm-1">
				                        		<input type="text" class="form-control input-sm e e7 key" id="txtSectCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-3">
				                        		<input type="text" class="form-control input-sm" id="txtSectNomb" placeholder="Nombre del Sector" readonly>
				                      		</div>
				                      		<label for="txtClase" class="col-sm-1 control-label" style="margin-top:5px;">Fecha Fin</label>
					                     	<div class="col-sm-2">
				                        		<input type="date" class="form-control input-sm e e8" id="txtFechaFin" placeholder="Fecha" <?php echo 'value="'.date('Y-m-d').'"'; ?>>
				                      		</div>
				                        	<input type="hidden" id="txtFechaActual" <?php echo 'value="'.date('Y-m-d').'"'; ?>>

					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Codigo de Pqr</label>
					                     	<div class="col-sm-1">
				                        		<input type="text" class="form-control input-sm e e9 key" id="txtPqrCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-3">
				                        		<input type="text" class="form-control input-sm" id="txtPqrNomb" placeholder="Nombre del Pqr" readonly>
				                      		</div>
				                      		<label for="txtClase" class="col-sm-1 control-label" style="margin-top:5px;">Usuario</label>
					                     	<div class="col-sm-1">
				                        		<input type="text" class="form-control input-sm e e10 key" id="txtUsuCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-3">
				                        		<input type="text" class="form-control input-sm" id="txtUsuNomb" placeholder="Nombre del Usuario" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-2 control-label text-right" style="margin-top:5px;">Codigo Tecnico</label>
					                     	<div class="col-sm-1">
				                        		<input type="text" class="form-control input-sm e e11 key" id="txtTecCod" placeholder="Codigo" onkeypress="solonumeros()">
				                      		</div>
				                      		<div class="col-sm-3">
				                        		<input type="text" class="form-control input-sm" id="txtTecNomb" placeholder="Nombre de Tecnico" readonly>
				                      		</div>
					                    </div>
				                	</div>
				                	<hr>
				                	<div class="row marginTop3">
					                	<div class="form-group">
					                     	<label for="txtClase" class="col-sm-5 control-label text-center" style="margin-top:5px;">Criterio de ordenamiento de ordenes a consultar</label>
					                    </div>
				                	</div>
				                	<div class="row marginTop3">
					                	<div class="form-group">
				                      		<div class="col-sm-4 text-center" style="border: solid 1px; margin-left: 50px; background-color: #808080; color:white;">
				                      			<small style="margin-top: 8px;">
					                      			<input type="radio" name="critOrd" checked value="1"> Direccion &nbsp; 
					                      			<input type="radio" name="critOrd" value="2"> Ruta &nbsp; 
					                      			<input type="radio" name="critOrd" value="3"> Fecha &nbsp; 
					                      			<input type="radio" name="critOrd" value="4"> PQR &nbsp; 
					                      			<input type="radio" name="critOrd" value="5"> Sector &nbsp; 
					                      			<input type="radio" name="critOrd" value="6"> Usuario &nbsp; 
				                      			</small>
				                      		</div>
					                    	<div class="col-sm-4 text-center">
				                      			<a class="btn btn-sm btn-default" onclick="mostrarOrdenes()"> Mostrar ordenes segun Criterio</a>&nbsp;&nbsp;
				                      			<a class="btn btn-sm btn-default" onclick="limpiarPantalla()"> Limpiar Pantalla</a>
				                      		</div>
					                    </div>
				                	</div>
				                	<hr>
				                	<div class="row marginTop3">
				                		<div class="col-md-12">
				                			<input type="hidden" id="swCheckTodos" value="0">
				                			<div id="tableOrdenes" style="height: 460px; overflow-y: scroll;">
						                		<div id="divOrden">
							                		<table class="table table-bordered table-condensed">
							                			<thead>
								                			<tr style="background-color: #3c8dbc; color:white;">
										        				<th class="text-center" width="100">NRO DE ORDEN</th>
										        				<th class="text-center" width="70">FECHA</th>
										        				<th class="text-center" width="70">PQR</th>
										        				<th class="text-center" width="100">TECNICO</th>
										        				<th class="text-center" width="100">USUARIO</th>
										        				<th class="text-center" width="100">OBSERVACION</th>
										        				<th class="text-center" width="100">ESTADO</th>
										        				<th class="text-center" width="100">DIRECCION</th>
										        				<th class="text-center" width="100">SECTOR</th>
										        			</tr>
							                			</thead>
							                			<tbody></tbody>
							                		</table>
						                		</div>
				                			</div>
				                		</div>
				                	</div>
			                    </div>
							</div>

						</div>
					</div>
				</section>
				
				<form method="POST" action="cusuOrden.php" class="display-none" id="formDetalleOrdenPost">
					<input type="hidden" id="txtIdOrdenPost" name="txtIdOrdenPost">
					<input type="hidden" id="txtIdUsuarioPost" name="txtIdUsuarioPost">
				</form>

			</div>
		</div>
		<?php require 'template/footer.php'; ?>
	</div>
</body>
<?php require 'template/end.php'; ?>
<script src="js/comao.js"></script>
<!--  Detectar cambios en las Formas    -->
<script src="assets/js/detectaCambiosEnFormas.js"></script>
<!--  Seleccionar nuevo Item Talas    -->
<script src="assets/js/selectedNewRow.js"></script>
<!--  Notifications Plugin    -->
<script src="assets/js/bootstrap-notify.js"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="assets/js/demo.js"></script>
<!--  TAB ENTER    -->
<script src="assets/js/tabEnter.js"></script>