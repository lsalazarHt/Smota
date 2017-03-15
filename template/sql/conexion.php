<?php 
    include 'config.php';
    $host='localhost';
    $dbname='dbsmota';
    $user='root';
    $pw='';
    return new PDO('mysql:host='.$host.';dbname='.$dbname,$user,$pw);
?>