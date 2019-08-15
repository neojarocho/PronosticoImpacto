<?php
include('funciones.php');
include('funcion_marketing.php');
require("../phpmailer/class.phpmailer.php");
$fecha = date("Y-m-d");


ob_start();

// Start plain Text Output
?>


----------------------------Titulo---------------------------------


<?php
// End of plain text output

// Capture text output
$txtBody = ob_get_contents();
ob_end_clean();

ob_start();
// Start of HTML output
?>
<table align="center">
	<tr>
		<td>
			<hr/>
			<br/>
			<table width="100%">
				<tr>
					<td width="45%">&nbsp;</td>
					<td width="54%" align="right"><img src="http://www.snet.gob.sv/images/MARN_logo2009.jpg"/></td>
				</tr>
			</table>
			<br/>
			<table width="100%">
				<tr>
					<td width="100%"><font size="2" face="Arial"><b>T&iacute;tulo</b></font>
					<div align="right">
						<br/><font size="2" face="Arial"><?php echo strfechalarga($fecha,0) ?></font>
						<br/>
					</div>
					<div>
						<br/><font size="2" face="Arial">Contenido</font>
						<br/>
					</div>
					</td>
				</tr>	
			</table>
			<hr/>
			<br/><font size="1" color="#808080" face="Arial">Esta información es llevada
					a usted por el Ministerio de Medio Ambiente y Recursos Naturales.</font>
			<br/>
			<br/>
			<br/><font size="2" face="Arial">Para mayor información, favor dirigirse a:</font>
			<br/>
			<br/><font size="2" face="Arial">Gerencia de Comunicaciones</font>
			<br/><font size="2" face="Arial">Ministerio de Medio Ambiente y Recursos Naturales</font>
			<br/><font size="2" face="Arial">Tel.: (503) 2132 9483 | 2132 9524 | 2132 6281  </font>
			<br/><font size="2" face="Arial">Fax: (503)  2132 9429 </font>
			<!--<br/><font size="2" face="Arial"><b>A partir del 31 de marzo: (503) 2132 9524, (503) 2132 9525</b></font>-->
			<br/><font size="2" face="Arial">comunicaciones@marn.gob.sv</font>
			<br/><font size="2" face="Arial">www.marn.gob.sv</font></table>
			<br/>
		</td>
	</tr>
</table>
<?php
// End of HTML output

// Capture HTML otuput
$htmlBody = ob_get_contents();
ob_end_clean();

if(isset($_POST['action'])&&$_POST['action']=="send") {
	$titulo = $_POST['titulo'];
	$resumen = $_POST['resumen'];
	$htmlBody = $_POST['contenidoHTML'];
	$textBody = $_POST['contenidoTexto'];
	$to = $_POST['correo_para'];
/*	
	$mail = new PHPMailer();
	$mail->Encoding="base64";
//	$mail->From = "ComunicacionesSNET@snet.gob.sv";
	$mail->From = "Comunicaciones@marn.gob.sv";
	$mail->FromName = "Comunicaciones MARN";
	$mail->AddAddress($to, "");

	$mail->IsHTML(true); // set email format to HTML

	$mail->Subject = "$titulo: $resumen";
	$mail->Body    = $htmlBody;
	$mail->AltBody = $textBody;

	if(!$mail->Send())
	{
*/

//Para pruebas

$token = "27cbc7f0-e647-429f-a531-5abb0326dcb4";
$idgrupo = "3";


//produccion
/*
$token = "817f8b19-79fb-4ab4-9d2c-67d41adc763d";
$idgrupo = "4";
*/

$textBody = "Datos de prueba en texto plano";

$envio=enviar_email("$titulo: $resumen",$htmlBody,$idgrupo,$token,$textBody);
if($envio=="1"){

?>
<html>
	<head>
		<meta http-equiv="Content-Language" content="es">
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
		<meta name="GENERATOR" content="Dev-PHP 2.2.0">
		<title>Envío de Información en General</title>
	</head>
	<body>
	<h1>El mensaje no pudo ser enviado.</h1>
	</body>
</html>
<?php
	} else {
?>
<html>
	<head>
		<meta http-equiv="Content-Language" content="es">
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
		<meta name="GENERATOR" content="Dev-PHP 2.2.0">
		<title>Envío de Información en General</title>
	</head>
	<body>
	<h1>El mensaje ha sido envíado satisfactoriamente</h1>
	</body>
</html>
<?php

		
		exit();
	}
}
header("Content-Type: text/html;charset=utf-8");
?>
<html>
	<head>
		<meta http-equiv="Content-Language" content="es">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="GENERATOR" content="Dev-PHP 2.2.0">
		<title>Env&iacute;o de Informaci&oacute;n en General</title>
		<!-- TinyMCE -->
		<script language="javascript" type="text/javascript" src="../tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
		<script language="javascript" type="text/javascript">
function textCounter(field, countfield, maxlimit) {
	if (field.value.length > maxlimit)
		field.value = field.value.substring(0, maxlimit);
	else
		countfield.value = maxlimit - field.value.length;
}
		</script>
		<script language="javascript" type="text/javascript">
	tinyMCE.init({
		mode : "exact",
		elements : "contenidoHTML",
		theme : "advanced",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,zoom,media,searchreplace,print,contextmenu,paste,directionality,fullscreen",
		theme_advanced_buttons1_add_before : "save,newdocument,separator",
		theme_advanced_buttons1_add : "fontselect,fontsizeselect",
		theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,zoom,separator,forecolor,backcolor",
		theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
		theme_advanced_buttons3_add_before : "tablecontrols,separator",
		theme_advanced_buttons3_add : "emotions,iespell,media,advhr,separator,print,separator,ltr,rtl,separator,fullscreen",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
	    plugi2n_insertdate_dateFormat : "%Y-%m-%d",
	    plugi2n_insertdate_timeFormat : "%H:%M:%S",
		paste_use_dialog : false,
		theme_advanced_resizing : true,
		theme_advanced_resize_horizontal : false,
		theme_advanced_link_targets : "_something=My somthing;_something2=My somthing2;_something3=My somthing3;",
		paste_auto_cleanup_on_paste : true,
		paste_convert_headers_to_strong : false,
		paste_strip_class_attributes : "all",
		paste_remove_spans : false,
		paste_remove_styles : false		
	});
		</script>
		<!-- /TinyMCE -->
	</head>
	<body>
	<form method="POST" action="marketing.php">
		<input type="hidden" name="action" value="send" />
			<h3>Env&iacute;o de Informaci&oacute;n de inter&eacute;s<br/>
    	para usuarios externos e internos</h3>
	<p>
		<font face="Arial" size="2">Para: </font><input type="text" name="correo_para" size="21" value="email" /></p>srt
	<table border="1" width="700" cellspacing="0" class="med">
  	<tr>
    	<td width="100%" bgcolor="#EEEEEE"><!--<font face="Arial" size="2"><img src="http://www.snet.gob.sv/images/SNETlogo.gif" alt="" />--></font></td>
  	</tr>
  	<tr>
    	<td width="100%" bgcolor="#336699">
     		<input type="text" name="titulo" id="titulo" size="67" style="background-color: #336699; color: #ffffff" value="Informe de Comunicaciones" /></td>
  	</tr>
  	<tr>
    	<td width="600" bgcolor="#EEEEEE" valign="middle">
    		<font face="Arial" size="2"><b>Cuerpo del Correo Electr&oacute;nico</b></font>
    		<textarea id="contenidoHTML" name="contenidoHTML" rows="30" cols="85" style="width: 100%"><?php echo htmlentities($htmlBody); ?></textarea>
    	</td>
  	</tr>
	</table>
  <p><input type="submit" value="Enviar" name="B1"/><input type="reset" value="Limpiar" name="B2"/></p>
	</form>
</body>
</html>
