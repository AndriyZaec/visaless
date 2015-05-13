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
			echo "$e";
		}	
		try {
			$countries = $client->doGetCountries();
			echo("<select id='countries' name='countries[]'>");
			foreach ($countries as $country) {
				echo "<option value='$country->name'>$country->name</option>";  		#get countries list for <select>
			}
			echo("</select>");
		} catch (Exception $e) {
			echo "$e";
		}
		print('<button id="check" type="submit" name="check">OK</button><br><br>');
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
				echo('<hr>');
				echo("<p>Countries that do not require visas for citizens of $selected</p>");
				echo('<hr>');
				foreach ($countries as $country) {
					$visa_groups = $client->doGetVisaGroups($citizenship, $country->code, $citizenship);
					foreach($visa_groups as $visa_group) {
						$visa_required = $client->doGetVisaRequired($citizenship, $country->code, $citizenship, $visa_group->id, 'false');
						
						if (!$visa_required) {				#   find countries whithout visa required
 							echo $country->name .'--'. $visa_group->title .'--'. 'Visa not required' . '<br>';
						}
			  		}
			 	}
			}
		}
	?>
	</form>
</body>
</html>
