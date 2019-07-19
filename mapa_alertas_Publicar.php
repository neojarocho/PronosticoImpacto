<?php 
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: text/html; charset=utf-8');

include('database_connection.php');

$id_unificado = $_REQUEST['id_unificado'];
$nivel = $_REQUEST['nivel'];
 
?>




<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>


<title>Publicar</title>

        <script src="js/jquery.lwMultiSelect.js"></script>
        <link rel="stylesheet" href="js/jquery.lwMultiSelect.css" />

        <script src="js/kendo.all.min.js" type="text/javascript"></script>
        <script src="js/kendo.aspnetmvc.min.js" type="text/javascript"></script>
        <script src="js/kendo.culture.es-SV.min.js" type="text/javascript"></script>

  
    </script>
   

</head>
	<body>


<div class="container-fluid">  
   
	<div class="row" style="background: #323c48; color:#ffffff;">
		<div class="col-md-12" style="text-align: center">

			PUBLICAR

		</div>
	</div>
</div>

	</body>
</html>
