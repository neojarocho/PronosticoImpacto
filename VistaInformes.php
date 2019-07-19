<?php 
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: text/html; charset=utf-8');

include('database_connection.php');

$id_area_Ini = $_REQUEST['id_area'];
$area_Ini = $_REQUEST['area'];
$id_fenomeno_Ini = $_REQUEST['id_fenomeno'];
$fenomeno_Ini = $_REQUEST['fenomeno'];
$id_impacto_diario = $_REQUEST['id_impacto_diario'];



?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>


<title>Vista Informes</title>


        <script src="js/jquery.lwMultiSelect.js"></script>
        <link rel="stylesheet" href="js/jquery.lwMultiSelect.css" />

        <script src="js/kendo.all.min.js" type="text/javascript"></script>
        <script src="js/kendo.aspnetmvc.min.js" type="text/javascript"></script>
        <script src="js/kendo.culture.es-SV.min.js" type="text/javascript"></script>

    <script>
  </script>



</head>
<body>


<div class="container">
  <ul class="nav nav-tabs nav-justified">
    <li class="active"><a data-toggle="tab" href="#home">24 horas</a></li>
    <li class=""><a data-toggle="tab" href="#menu1">48 horas</a></li>
	<li class=""><a data-toggle="tab" href="#menu2">72 horas</a></li>
  </ul>


<div class="tab-content">
							<div id="home" class="tab-pane fade in active">
24 horas
							 </div>

							 <div id="menu1" class="tab-pane fade">
48 horas
							 </div>

							 <div id="menu2" class="tab-pane fade">
72 horas
							 </div>
</div>



 </div>

</body>
</html>
