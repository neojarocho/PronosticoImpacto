<?php 
session_start();
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: text/html; charset=utf-8');
include("header.php");
include("cnn.php");
?>


<!DOCTYPE html>

<html lang="en">
<head>
    
    <title>Informe Impacto</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">



<script>

$(function () {

    // $("#contenedorprincipal").load("userView.php");
    $("#contenedorprincipal").load("Usuario.php");

});

$( document ).ready(function() {
  $( "#usuario" ).focus();
});

</script>

<style>
.widget {
}
.widget p {
  display: inline-block;  line-height: 1em;
}
.fecha {
  text-align: right;
}

</style>
</head>

<body>

<div class="container-fluid">
	<img src="Imagenes/Banner.png" width="100%" class="img-responsive" id="PaginaInicio" />
</div>

<div id="contenedorprincipal">
    <div class="row">

    </div>
</div>

</body>
</html>