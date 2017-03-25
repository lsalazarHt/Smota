<?php 
  session_start();
  if( isset($_SESSION['idUsuario']) ){
    header('Location: index.php');
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIGCO | Sistema de Informacion, Gestion de Contratistas</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="tools/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="tools/plugins/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="tools/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="tools/dist/css/skins/_all-skins.min.css">

    <!-- background slide -->
    <link rel="shortcut icon" href="../favicon.ico"> 
    <link rel="stylesheet" type="text/css" href="assets/css/background-slideCSS/demo.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/background-slideCSS/style1.css" />
    <script type="text/javascript" src="assets/js/background-slideJS/modernizr.custom.86080.js"></script>

  </head>
  <body class="hold-transition login-page">
  <ul class="cb-slideshow">
            <li><span>Image 01</span><div><h3>ga·so·duc·to</h3></div></li>
            <li><span>Image 02</span><div><h3>pla·n·ta·de·gas</h3></div></li>
            <li><span>Image 03</span><div><h3>gas·na·tu·ral</h3></div></li>
            <li><span>Image 04</span><div><h3>ga·so·duc·to</h3></div></li>
            <li><span>Image 05</span><div><h3>pla·n·ta·de·gas</h3></div></li>
            <li><span>Image 06</span><div><h3>gas·na·tu·ral</h3></div></li>
        </ul>
    <div class="login-box">
      <div class="login-logo">
        <a><b>SIGCO</b></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <form action="verificar.php" method="post">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Usuario" name="txtUser" autofocus autocomplete="off">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Contraseña" name="txtPss">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-7">
            </div><!-- /.col -->
            <div class="col-xs-5">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Iniciar sesión</button>
            </div><!-- /.col -->
          </div>
        </form>

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
  </body>
<?php require 'template/end.php'; ?>
