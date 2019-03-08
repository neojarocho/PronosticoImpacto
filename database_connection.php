<?php
//database_connection.php
//$connect = new PDO("mysql:host=localhost;dbname=Control", "root", "");
//$connect = pg_connect("localhost", "5432", "", "", "Control")

$connect = pg_connect("host=192.168.1.182 port=5432 dbname=PronosticoImpacto user=lrodriguez  password=lissbeth123") or die('Could not connect: ' . pg_last_error());

?>



