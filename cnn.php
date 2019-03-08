<?php

// Connecting, selecting database

function my_dbconn1($db){
	// Connecting, selecting database
	$host 		= "192.168.1.182";
	$database 	= $db;
	$user 		= "imoran";
	$pass 		= "i186#34a";
	$dbconn = pg_connect("host =".$host." dbname=".$database." user=".$user."  password=".$pass) or die('Could not connect: ' . pg_last_error());
	return $dbconn;
}

function my_dbconn3($db){
	// Connecting, selecting database
	$host 		= "192.168.6.74";
	$database 	= $db;
	$user 		= "imoran";
	$pass 		= "i186#34a";
	$dbconn = pg_connect("host =".$host." dbname=".$database." user=".$user."  password=".$pass) or die('Could not connect: ' . pg_last_error());
	return $dbconn;
}

function my_dbconn2($db){
	// Connecting, selecting database
	$host 		= "192.168.2.8";
	$database 	= $db;
	$user 		= "sysop";
	$pass 		= "sysop";
	// $dbconn = mysql_connect($host.", ".$user .", ".$pass) or die(mysql_error());	
	$dbconn = mysql_connect($host, $user, $pass) or die(mysql_error());	
	mysql_select_db($db, $dbconn);
	return $dbconn;
}

function my_dbconn4($db){
	// Connecting, selecting database
	$host 		= "192.168.1.182";
	$database 	= $db;
	$user 		= "lrodriguez";
	$pass 		= "lissbeth123";
	$dbconn = pg_connect("host =".$host." dbname=".$database." user=".$user."  password=".$pass) or die('Could not connect: ' . pg_last_error());
	return $dbconn;
}
?>