<?php
    session_start();
    if(!isset($_SESSION['idUsuario'])){
        header('Location: login.php');
    }
    $conn = require 'sql/conexion.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIGCO | Sistema de Informacion y Gestion de Contratistas</title>
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


    <!--  Material Dashboard CSS    -->
        <link href="assets/css/material-dashboard.css" rel="stylesheet"/>
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>

    <link rel="shortcut icon" href="tools/dist/img/favicon.png" type="image/ico" />
    
    <style type="text/css">
        .container-table-list{
            overflow-x: auto;
            white-space: nowrap;
            overflow-y: auto;
        }
        .movObEntrada_border{
            border: solid 3px #40C080;
        }
        .movObEntrada_border_red{
            border: solid 3px #E00000;
        }
        .movObEntrada_border_azul{
            border: solid 3px #8080C0;
        }
        .movObEntrada_border_azulv2{
            border: solid 3px #3c8dbc;
        }
        .content-wrapper{
            background-color: #E0E0E0;
        }
        table tbody{
            cursor: pointer;
        }
		.display-none{
			display: none;
		}
        .requerido{
            color: red;
        }
        .text-center{
            text-align: center;
        }
        .text-left{
            text-align: left;
        }
        .text-right{
            text-align: right;
        }
        .selected{
            /*background-color: #C0C0C0;*/
            /*color: while;*/
        }
        .form-control:focus{
            background-color: #E0E0E0;
        }
        .trSelect{
            background-color: #A9F5BC !important;
        }
        .marginTop15{
            margin-top: 15px;
        }
        .marginTop10{
            margin-top: 10px;
        }
        .marginTop8{
            margin-top: 8px;
        }
        .marginTop5{
            margin-top: 5px;
        }
        .marginTop3{
            margin-top: 3px;
        }
        .marginTop1{
            margin-top: 1px;
        }
        .border{
            border: 1px solid;
            /*width:*/ 
        }
        .valor{
            font-weight: bold;
        }
        .input-sm{
            /*
            right: 
            padding-top: 0 !important;
            padding-bottom: 0 !important;*/
            /*color: blue;*/
        }
        .nav-tabs-custom>.nav-tabs>li.active>a{
            background-color: #3c8dbc !important;
            border-radius: 5px;
            color: white !important;
        }
        .nav-tabs-custom>.nav-tabs>li.active{
            border-top-color: transparent !important;
        }
        .border-blue{ border: solid 1px blue;  }
        .border-black{ border: solid 1px black; }
        .border-green{ border: solid 1px green; }
        .border-red{ border: solid 1px red; }
    </style>
  </head>