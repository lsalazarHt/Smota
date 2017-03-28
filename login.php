<?php 
  session_start();
  if( isset($_SESSION['idUsuario']) ){
    header('Location: index.php');
  }
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SIGCO | Sistema de Informacion, Gestion de Contratistas</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/css/form-elements.css">
        <link rel="stylesheet" href="assets/css/style.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <!-- <link rel="shortcut icon" href="assets/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png"> -->

        <!-- background slide -->
    <!-- <link rel="shortcut icon" href="../favicon.ico">  -->
    <link rel="stylesheet" type="text/css" href="assets/css/background-slideCSS/demo.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/background-slideCSS/style1.css" />
    <script type="text/javascript" src="assets/js/background-slideJS/modernizr.custom.86080.js"></script>

    </head>

    <body>

        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                     <ul class="cb-slideshow">
                        <li><span>Image 01</span><div><h3><!-- ga·so·duc·to --></h3></div></li>
                        <li><span>Image 02</span><div><h3><!-- pla·n·ta·de·gas --></h3></div></li>
                        <li><span>Image 03</span><div><h3><!-- gas·na·tu·ral --></h3></div></li>
                        <li><span>Image 04</span><div><h3><!-- ga·so·duc·to --></h3></div></li>
                        <li><span>Image 05</span><div><h3><!-- pla·n·ta·de·gas --></h3></div></li>
                        <li><span>Image 06</span><div><h3><!-- gas·na·tu·ral --></h3></div></li>
                    </ul>
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><strong>SIGCO</strong> System Info</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-sm-offset-4 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Inicia sesion</h3>
                            		<p>Escribe tu usuario y contraseña para iniciar sesion:</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-lock"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
			                    <form role="form" action="verificar.php" method="post" class="login-form">
			                    	<div class="form-group">
			                    		<!-- <label class="sr-only" for="form-username">Username</label> -->
			                        	<input type="text" name="txtUser" placeholder="Usuario..." class="form-username form-control" id="form-username" autofocus autocomplete="off">
			                        </div>
			                        <div class="form-group">
			                        	<!-- <label class="sr-only" for="form-password">Password</label> -->
			                        	<input type="password" name="txtPss" placeholder="Contraseña..." class="form-password form-control" id="form-password">
			                        </div>
			                        <button type="submit" class="btn">Entrar!</button>
			                    </form>
		                    </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>


        <!-- Javascript -->
     <!--    <script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/scripts.js"></script>
         -->
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>