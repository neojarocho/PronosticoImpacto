<?php

function isEmail($field) {
    $address = trim($field);
    if (ereg('^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$',$address)) {
       return true;
    }
    else {
       return false;
    }
}

function nombre_departamento($departamentoid) {
    switch ($departamentoid) {
       case '01':
          return "Ahuachapan";
	  break;
       case '02':
          return "Santa Ana";
	  break;
       case '03':
          return "Sonsonate";
	  break;
       case '04':
          return "Chalatenango";
	  break;
       case '05':
          return "La Libertad";
	  break;
       case '06':
          return "San Salvador";
	  break;
       case '07':
          return "Cuscatlan";
	  break;
       case '08':
          return "La Paz";
	  break;
       case '09':
          return "Cabanas";
	  break;
       case '10':
          return "San Vicente";
	  break;
       case '11':
          return "Usulutan";
	  break;
       case '12':
          return "San Miguel";
	  break;
       case '13':
          return "Morazan";
	  break;
       case '14':
          return "La Union";
	  break;
   }
}

function registrarvisita ( $pagina ) {
    global $REMOTE_ADDR;
    global $HTTP_USER_AGENT;
    global $HTTP_REFERER;
  if ((substr($REMOTE_ADDR,0,7)!='172.16.') and (substr($REMOTE_ADDR,0,11)!='168.243.112')) {
    $conn=pg_connect("host=172.16.0.205 dbname=webhits user=publico");
    $fecha=date("Y-m-d");
    $hora=date("h:i");
    $sql="insert into hits (ip, browser, url, fecha, hora, pagina) 
                  values ('$REMOTE_ADDR','$HTTP_USER_AGENT','$HTTP_REFERER', '$fecha', '$hora', '$pagina')";
    $sql2 = "UPDATE contadores SET contadorglobal=contadorglobal+1, contadordiario=contadordiario+1 WHERE pagina='$pagina'";
    $res=pg_exec($conn, $sql);
    $res=pg_exec($conn, $sql2);
    $sql3 = "SELECT contadorglobal, contadordiario FROM contadores WHERE pagina='$pagina'";
    $res=pg_exec($conn, $sql3);
    $data = pg_fetch_object($res, 0);
    pg_close($conn);
    return "$data->contadordiario $data->contadorglobal";
  }
}

function mensaje ( $texto, $align="center" ) {
    echo "<br><br>";
    echo "<table align=$align border=1 cellspacing=0><tr><th width=700 height=100 valign=center>$texto</th></tr>";
    echo "</table><br><br>";
}


/*
function validarpassword ( $tecnicoid, $password ) {
    $dbc = pg_connect( "host=localhost user=cpm dbname=pronosticos" );
    $dbt = pg_exec($dbc, "SELECT clave FROM tecnicos WHERE tecnicoid=$tecnicoid");
    $pwd = pg_fetch_array ($dbt, 0);
    # echo "Password del usuario: -<b>$pwd[clave]</b>-";
    pg_close($dbc);
    if (trim($pwd[clave])==$password) {
        return 1;
    }
    else {
        return 0;
    }
}
*/

function strfecha($fecha)
{
        $stry = substr($fecha,0,4);
        $valm = intval(substr($fecha,5,2));
        $strd = substr($fecha,8,2);
        $strm = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio",
                "Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        return($strd." de ".$strm[$valm-1]." de ".$stry);
}

function strfechalarga($fecha, $dias)
{
        $timevalue = strtotime($fecha)+86400*$dias;
        $fecha = strftime("%Y/%m/%d",$timevalue);
        $stry = substr($fecha,0,4);
        $valm = intval(substr($fecha,5,2));
        $strd = substr($fecha,8,2);
        $strwd = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado", "Domingo");
        $strm = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio",
                "Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $weekday = $strwd[strftime("%u",$timevalue)];

        return($weekday.", ".$strd." de ".$strm[$valm-1]." de ".$stry);
}

function strfechacorta($fecha, $dias=0)
{
        $timevalue = strtotime($fecha)+86400*$dias;
        $fecha = strftime("%Y/%m/%d",$timevalue);
        $stry = substr($fecha,0,4);
        $valm = intval(substr($fecha,5,2));
        $strd = substr($fecha,8,2);
        $strm = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio",
                "Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        return($strm[$valm-1]." ".$strd.", ".$stry);
}

function dropdown($comboname, $combosize, $querytext, $dbconnection)
{
        #
        # comboname = nombre del control que sera creado
        # combosize = tamano requerido para el control
        # querytext = sentencia SELECT que origina los datos
        #              -> la primera columna contiene el dato y la segunda el texto
        # dbconnection = cadena de conexion a la base de datos
        #

        $dbase = pg_connect( $dbconnection );
        $tabledata = pg_exec( $dbase, $querytext );
        $no_registros = pg_numrows( $tabledata );
        $resultado = "<select name='$comboname' size=$combosize>";
        for ($i = 0; $i < $no_registros; $i++)
        {
                $combodata = pg_fetch_row( $tabledata, $i);
                $resultado .= "<option value=$combodata[0]>$combodata[1]</option><br>\n";
        };
        $resultado .= "</select>";
        pg_close( $dbase );
        return ( $resultado );
}

function sendMailToList($mensaje, $subject, $okToSend=false) {
	include_once("phplibdb.inc");
	$db = new db;
	$db->connect("staff");
	if (!$okToSend) {
		# Listado de usuarios de prueba
	    $sql = "SELECT email, dominio FROM usuarios_externos WHERE iduser IN (35,36,37,39,40) ORDER BY dominio";
	} else {
		$sql = "SELECT email, dominio FROM usuarios_externos WHERE NOT email IS NULL ORDER BY dominio";
	}
	$db->exec($sql);
	$db->moveFirst();
	$dominio = "";
	$destinatarios = "";
	# echo "Número total de Destinatarios " . $db->numRows() . "<hr>";
	for ($i=0;$i<$db->numRows();$i++) {
		$data=$db->fobject();
		if ($data->dominio == $dominio) {
			# Es otra dirección del mismo dominio, agregar a la lista
			$destinatarios .= ", " . $data->email;
		} else {
			# Es un nuevo dominio, enviar el mensaje al dominio anterior e inicializar las variables
			if ($destinatarios != "") {
				# Chequea para ver que la lista no esté vacía antes de enviar un correo
				# echo "$destinatarios <hr>";
				mail($destinatarios, $subject, $mensaje, "from:Servicio Nacional de Estudios Territoriales<comunicaciones@snet.gob.sv>");
			}
			$destinatarios = $data->email;
			$dominio = $data->dominio;
		}
		# Proceso
		$db->moveNext();
	}
	# echo "$destinatarios <hr>";
	$db->close();
}


// String EnCrypt + DeCrypt function 

function convert($str,$ky=''){
	if($ky=='')return $str; 
	$ky=str_replace(chr(32),'',$ky); 
	if(strlen($ky)<8)exit('key error'); 
	$kl=strlen($ky)<32?strlen($ky):32; 
	$k=array();for($i=0;$i<$kl;$i++){ 
	$k[$i]=ord($ky{$i})&0x1F;} 
	$j=0;for($i=0;$i<strlen($str);$i++){ 
	$e=ord($str{$i}); 
	$str{$i}=$e&0xE0?chr($e^$k[$j]):chr($e); 
	$j++;$j=$j==$kl?0:$j;} 
	return $str; 
} 
/////////////////////////////////// 

// Secret key to encrypt/decrypt with 
$key='ivan.moran'; // 8-32 characters without spaces 

?>
