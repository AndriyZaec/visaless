<?php
	ini_set('soap.wsdl_cache', '0');
	ini_set('soap.wsdl_cache_enabled', '0');
	try{	
		$client=new SoapClient('wsdl.wsdl', array('trace'=>1, 'exceptions'=>1, 'login'=>'d630596c3ed55c7af35ddd936fdee4d7','password'=>'dfbc2c7dce8217d1a75179fdab41608f'));    #try create Soap obj 
	}
	catch(Exception $e){
		print($e);
	}	

	try{
		$countries=$client->doGetCountries();
	}
	catch(Exception $e){
		print($e);
	}

	$countriesRand=array();
	$countriesRand=$countries;

	shuffle($countriesRand);

	$citizenship='US';

	foreach ($countriesRand as $randCountry){
			$visa_groups = $client->doGetVisaGroups($citizenship, $randCountry->code, $citizenship);
			foreach($visa_groups as $visa_group) {
				try{
					$visa_required = $client->doGetVisaRequired($citizenship, $randCountry->code, $citizenship, $visa_group->id, 'false');
				}catch(SoapFault $exception){
					print($exception);
				}
				if (!$visa_required) {				#   find countries whithout visa required
 					if (sizeof($rnd)<= 3){
 						$rnd=$country->name;
 					}
 					else{
 						echo('<p>'.$rnd.'</p>');
 					}
 					//echo '<tr><td>'.$country->name .'</td><td>'. $visa_group->title .'</td><td>'. 'Visa not required' . '</td></tr>';
				}
			}
		}
		die();
?>	 
