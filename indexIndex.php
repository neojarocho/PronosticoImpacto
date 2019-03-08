<?php
//index.php

header('Access-Control-Allow-Origin: *'); 
header('Content-Type: text/html; charset=utf-8');

include('database_connection.php');

$country = '';

$Sql="SELECT country FROM country_state_city GROUP BY country ORDER BY country ASC";
$result=pg_query($connect, $Sql);
while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
$Paises[] = $row;
} pg_free_result($result);

# Cerrar conexion a base de datos
pg_close($connect);

$result=$Paises;

foreach($result as $row)
{
	$country .= '<option value="'.$row['country'].'">'.$row['country'].'</option>';
}


?>
<!DOCTYPE html>
<html>
	<head>
		<title>Insert Dynamic Multi Select Box Data using Jquery Ajax PHP</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="jquery.lwMultiSelect.js"></script>
		<link rel="stylesheet" href="jquery.lwMultiSelect.css" />
	</head>
	<body>
		<br /><br />
		<div class="container" style="width:600px;">
			<h2 align="center">Municipios de Impacto</h2><br /><br />
			<form method="post" id="insert_data">
				<select name="country" id="country" class="form-control action">
					<option value="">Seleción</option>
					<?php echo $country; ?>
				</select>
				<br />
				<select name="state" id="state" class="form-control action">
					<option value="">Departamento/Zona</option>
				</select>
				<br />
				<select name="city" id="city" multiple class="form-control">
				</select>
				<br />
				<input type="hidden" name="hidden_city" id="hidden_city" />
				<input type="submit" name="insert" id="action" class="btn btn-info" value="Agregar" />
			</form>
		</div>
	</body>
</html>

<script>
$(document).ready(function(){

	$('#city').lwMultiSelect();

	$('.action').change(function(){
	//	alert("Entroooo");
		if($(this).val() != '')
		{
			
			//alert($(this).attr("id"));
			//alert($(this).val());
			
			var action = $(this).attr("id");
			var query = $(this).val();
			var result = '';
			
			if(action == 'country')
			{
			
				result = 'state';
			}
			else
			{
				result = 'city';
			}
			$.ajax({
				url:'PaginaInicio.php',
				method:"POST",
				data:{action:action, query:query},
				success:function(data)


				{

					 $('#'+result).html(data);
					///////// alert(data);
					 if(result == 'city')

					 {
					 	$('#city').data('plugin_lwMultiSelect').updateList();
					 	//alert(data);

					 }
				}
			})
		}
	});

	$('#insert_data').on('submit', function(event){
		event.preventDefault();

				if($('#country').val() == '')
		{
			alert("Please Select Country");
			return false;
		}
		else if($('#state').val() == '')
		{
			alert("Please Select State");
			return false;
		}
		else if($('#city').val() == '')
		{
			alert("Please Select City");
			return false;
		}
		else
		{
			$('#hidden_city').val($('#city').val());
			$('#action').attr('disabled', 'disabled');
			var form_data = $(this).serialize();



			$.ajax({
				url:"Procesos.php",
				method:"POST",
				data:form_data,
				success:function(data)
				{
					alert(data);

					
					$('#action').attr("disabled", "disabled");
					if(data == 'done')
					{

						$('#city').html('');
						$('#city').data('plugin_lwMultiSelect').updateList();
						$('#city').data('plugin_lwMultiSelect').removeAll();
						$('#insert_data')[0].reset();
						alert('Data Inserted');
					}
				}
			});
		}
	});

});
</script>



