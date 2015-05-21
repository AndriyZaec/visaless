<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
</head>
<body>
	<p>Select citizenship</p>
	<form name='select' action="" method="post">
	<?php 
		ini_set('soap.wsdl_cache', '0');
		ini_set('soap.wsdl_cache_enabled', '0');
		try{	
				$client=new SoapClient('wsdl.wsdl', array('trace'=>1, 'exceptions'=>1, 'login'=>'d630596c3ed55c7af35ddd936fdee4d7','password'=>'dfbc2c7dce8217d1a75179fdab41608f'));    #try create Soap obj 
			}
		catch(Exception $e){
			print($e);
		}	
		try {
			$countries = $client->doGetCountries();
			echo("<select id='countries' name='countries[]'>");
			foreach ($countries as $country) {
			
			echo "<option value='$country->name'>$country->name</option>";  		#get countries list for <select>
			}
			echo("</select>");
		} catch (Exception $e) {
			print($e);
		}
		print('<input id="check" type="button" name="check" value="OK"><br><br>');
		if ($_POST) {
			foreach ($_POST['countries'] as $selectedObj) {			
				$selected=$selectedObj;								#	get selected item 
			}																				
			foreach ($countries as $country) {
				if ($selected==$country->name) {					#   get code of selected countrie
					$citizenship=$country->code;
				}
				else{
					continue;
				}
				// foreach ($countries as $country) {
					$visa_groups = $client->doGetVisaGroups($citizenship, 'US', $citizenship);
					var_dump($visa_groups);

					// foreach($visa_groups as $visa_group) {
					// 	$visa_required = $client->doGetVisaRequired($citizenship, $country->code, $citizenship, $visa_group->id, 'false');
			  		// 		}
			 	}
			//}
		}
	?>
	</form>
</body>
</html>
 
