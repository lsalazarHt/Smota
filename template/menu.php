<header class="main-header"> <nav class="navbar navbar-static-top">
	<div class="container">
	    <div class="navbar-header">
	      <a href="index.php" class="navbar-brand"><b>SIGCO</b></a>
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
	        <i class="fa fa-bars"></i>
	      </button>
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
	      <ul class="nav navbar-nav">
	        
	        <!-- Informacion basica -->
	        <li class="dropdown mResto">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Informacion Basica <span class="caret"></span></a>
	          <ul class="dropdown-menu" role="menu">
	            <li><a href="cusu.php"><i class="fa fa-circle"></i>Consulta de Usuarios</a></li>
	            <li><a href="fdepa.php"><i class="fa fa-circle"></i>Departamentos</a></li>
	            <li><a href="floca.php"><i class="fa fa-circle"></i>Localidades</a></li>
	            <li><a href="pmobr.php"><i class="fa fa-circle"></i>Mano de Obra</a></li>
	            <li><a href="pclnot.php"><i class="fa fa-circle"></i>Mantenimiento Clase de Notas</a></li>
	            <li><a href="cmtm.php"><i class="fa fa-circle"></i>Mantenimiento Clase Material por Tipo Movimiento</a></li>
	            <li><a href="pmate.php"><i class="fa fa-circle"></i>Mantenimiento de Materiales</a></li>
	            <li><a href="ppqr.php"><i class="fa fa-circle"></i>Mantenimiento de PQR's</a></li>
	            <li><a href="ptimo.php"><i class="fa fa-circle"></i>Mantenimiento de Tipos de Movimiento de Inventario</a></li>
	            <li><a href="pmtpqr.php"><i class="fa fa-circle"></i>Mantenimiento Materiales x PQR</a></li>
	            <li><a href="pmopqr.php"><i class="fa fa-circle"></i>Mantenimiento Mano de Obra x PRQ</a></li>
	            <li><a href="pconf.php"><i class="fa fa-circle"></i>Parametros del Sistema</a></li>
	            <li><a href="psect.php"><i class="fa fa-circle"></i>Sectores Operativos de Localidades</a></li>
	            <li><a href="psezo.php"><i class="fa fa-circle"></i>Sectores Operativos por Zonas Operativas</a></li>
	            <li><a href="pzona.php"><i class="fa fa-circle"></i>Zonas Operativas de Localidades</a></li>
	          </ul>
	        </li>
	        <!-- Cuadrillas -->
	        <li class="dropdown mResto">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cuadrillas <span class="caret"></span></a>
	          <ul class="dropdown-menu" role="menu">
	            <li><a href="ptecni.php"><i class="fa fa-circle"></i>Administración de Técnicos</a></li>
	            <li><a href="ctecni.php"><i class="fa fa-circle"></i>Información detallada de tecnicos</a></li>
	            <li><a href="mcupos.php"><i class="fa fa-circle"></i>Definición de Stocks de Técnicos</a></li>
	            <li><a href="lcumaco.php"><i class="fa fa-circle"></i>Reporte de existencia y cupos por técnicos</a></li>
	          </ul>
	        </li>
	        <!-- Ordenes -->
	        <li class="dropdown mResto">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Ordenes <span class="caret"></span></a>
	          <ul class="dropdown-menu" role="menu">
	            <li id="mActaInd"><a style="cursor:pointer;"><i class="fa fa-angle-down"></i>Actas individuales</a></li>
		            <li class="display-none liActaInd"><a href="apacta.php" style="margin-left:20px;"><i class="fa fa-circle"></i> Aprobacion de Acta</a></li>
		            <li class="display-none liActaInd"><a href="gacta.php" style="margin-left:20px;"><i class="fa fa-circle"></i> Generacion de Acta Hasta Fecha de Corte</a></li>
		            <li class="display-none liActaInd"><a href="gama.php" style="margin-left:20px;"><i class="fa fa-circle"></i> Generacion de Acta por Escogencia</a></li>
		            <li class="display-none liActaInd"><a href="imacta.php" style="margin-left:20px;"><i class="fa fa-circle"></i> Imprimir Acta</a></li>
		            <li class="display-none liActaInd"><a href="racta.php" style="margin-left:20px;"><i class="fa fa-circle"></i> Reversar Acta</a></li>
	            <li class="mResto"><a href="asiot.php"><i class="fa fa-circle"></i>Asignacion de Ordenes Individuales</a></li>
	            <li class="mResto"><a href="asma.php"><i class="fa fa-circle"></i>Asignacion Ordenes por Pantalla</a></li>
	            <li class="mResto"><a href="panuot.php"><i class="fa fa-circle"></i>Anular una Orden</a></li>
	            <li class="mResto"><a href="peatsc.php"><i class="fa fa-circle"></i>Cargar Ordenes Asignadas</a></li>
	          	<li id="mConsultas"><a style="cursor:pointer;"><i class="fa fa-angle-down"></i>Consultas</a></li>
		            <li class="display-none liConsul"><a href="cacta.php" style="margin-left:20px;"><i class="fa fa-circle"></i> Acta</a></li>
		            <li class="display-none liConsul"><a href="comao.php" style="margin-left:20px;"><i class="fa fa-circle"></i> Consulta Masiva de Ordenes</a></li>
		            <li class="display-none liConsul"><a href="cusu.php" style="margin-left:20px;"><i class="fa fa-circle"></i> Consulta General de Usuarios</a></li>
		            <li class="display-none liConsul"><a href="cnota.php" style="margin-left:20px;"><i class="fa fa-circle"></i> Notas</a></li>
		            <li class="display-none liConsul"><a href="corden.php" style="margin-left:20px;"><i class="fa fa-circle"></i> Ordenes</a></li>
	            <li class="mResto"><a href="demo.php"><i class="fa fa-circle"></i>Desasignacion de Ordenes por Pantalla</a></li>
	            <li class="mResto"><a href="pdelote.php"><i class="fa fa-circle"></i>Desasignación en bloque</a></li>
	            <li class="mResto"><a href="pdesaot.php"><i class="fa fa-circle"></i>Desasignacion individual</a></li>
	            <li class="mResto"><a href="incot.php"><i class="fa fa-circle"></i>Incumplir una orden</a></li>
	            <li class="mResto"><a href="legord.php"><i class="fa fa-circle"></i>Legalizacion individual</a></li>
	            <!-- <li class="mResto"><a href="redot.php"><i class="fa fa-circle-o"></i>Redimir orden</a></li> -->
	            <!-- <li class="mResto"><a href="cerot.php"><i class="fa fa-circle-o"></i>Registrar certificacion individual</a></li> -->
	            <li class="mResto"><a href="rnota.php"><i class="fa fa-circle"></i>Registrar notas a tecnicos</a></li>
	            <!-- <li class="mResto"><a href="cema.php"><i class="fa fa-circle-o"></i>Registro masivo de certificacion</a></li> -->
	          	<li id="mReportes"><a style="cursor:pointer;"><i class="fa fa-angle-down"></i>Reportes</a></li>
		            <li class="display-none liRepor"><a href="rece.php" style="margin-left:20px;"><i class="fa fa-circle"></i> Listado Ordenes para Certificacion por Rango</a></li>
		            <li class="display-none liRepor"><a href="iltscG.php" style="margin-left:20px;"><i class="fa fa-circle"></i> Listado Ordenes sin Cumplir por tecnico General</a></li>
	          </ul>
	        </li>
	        <!-- Almacen -->
	        <li class="dropdown mResto">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Almacen <span class="caret"></span></a>
	          <ul class="dropdown-menu" role="menu">
	            <li class="mResto"><a href="qmate.php"><i class="fa fa-circle"></i>Consulta de Materiales por Bodega</a></li>
	            <li class="mResto"><a href="calma.php"><i class="fa fa-circle"></i>Consulta de Movimiento Almacen</a></li>
	            <li class="mResto"><a href="kardex.php"><i class="fa fa-circle-o"></i>Consulta de Movimiento Item por Bodega en un Periodo</a></li>
	            <li class="mResto"><a href="ralma.php"><i class="fa fa-circle"></i>Entradas y Salidas de Almacen</a></li>
	            <li><a id="mReportAlm" style="cursor:pointer;"><i class="fa fa-circle-o"></i>Reportes de Almacen</a></li>
	            <li class="display-none liReportAlmac"><a href="limabo.php" style="margin-left:20px;"><i class="fa fa-circle-o"></i> Existencia de Materiales en Bodega</a></li>
	            <li class="display-none liReportAlmac"><a href="#" style="margin-left:20px;"><i class="fa fa-circle-o"></i> Listado Consolidado de Movimientos de Almacen**</a></li>
	            <li class="display-none liReportAlmac"><a href="#" style="margin-left:20px;"><i class="fa fa-circle-o"></i> Listado de Movimientos de Almacen**</a></li>
	          </ul>
	        </li>
	        <!-- Utilidades -->
	        <li class="dropdown mResto">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Utilidades <span class="caret"></span></a>
	          <ul class="dropdown-menu" role="menu">
	            <li><a href="#"><i class="fa fa-circle-o"></i>Acerca de..</a></li>
	            <li><a href="#"><i class="fa fa-circle-o"></i>Cambio de  Password</a></li>
	            <li><a href="#"><i class="fa fa-circle-o"></i>Esquema de Seguridad</a></li>
	          </ul>
	        </li>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	    <!-- Navbar Right Menu -->
	    <div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
			  

			  <!-- User Account Menu -->
			  <li class="dropdown user user-menu">
			    <!-- Menu Toggle Button -->
			    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
			      <!-- The user image in the navbar-->
			      <img src="tools/dist/img/user-icon-6.png" class="user-image" alt="User Image">
			      <!-- hidden-xs hides the username on small devices so only the image appears. -->
			      <span class="hidden-xs"><?php echo $_SESSION['nbUsuario']; ?></span>
			    </a>
			    <ul class="dropdown-menu">
			      <!-- The user image in the menu -->
			      <li class="user-header">
			        <img src="tools/dist/img/user-icon-6.png" class="img-circle" alt="User Image">
			        <p>
			          <?php echo $_SESSION['nbUsuario']; ?>
			        </p>
			      </li>
			      <!-- Menu Footer-->
			      <li class="user-footer">
			        <div class="pull-right">
			          <a href="logout.php" class="btn btn-default btn-flat">Cerrar Sesión</a>
			        </div>
			      </li>
			    </ul>
			  </li>
			</ul>
	    </div><!-- /.navbar-custom-menu -->
	  </div><!-- /.container-fluid -->
	</nav>
</header>