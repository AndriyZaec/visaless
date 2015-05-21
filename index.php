<?php
	try{
		require_once 'lib/Twig/Autoloader.php';
		Twig_Autoloader::register();
		$loader = new Twig_Loader_Filesystem('templates');
		$twig = new Twig_Environment($loader, array(
    		'cache'       => 'compilation_cache',
    		'auto_reload' => true
		));
	}
	catch(Exception $e){
		print($e);
	}

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

	$countriesRand=$countries;

	shuffle($countriesRand);

	$i=0;
	
	if (isset($_POST['selected'])){
		$selected=$_POST['selected'];
		foreach ($countries as $country){
			if ($selected==$country->name){					#   get code of selected countrie
				$citizenship=$country->code;
			}
		}

		foreach ($countriesRand as $randCountry){
			$visa_groups = $client->doGetVisaGroups($citizenship, $randCountry->code, $citizenship);
			foreach($visa_groups as $visa_group) {
				try{
					$visa_required = $client->doGetVisaRequired($citizenship, $randCountry->code, $citizenship, $visa_group->id, 'false');
				}catch(Exception $e){
					echo('Data not found');
				}
				if (!$visa_required) {				#   find countries whithout visa required
 					if($i<3){
 						echo '<tr><td>'.$randCountry->name .'</td><td>'. $visa_group->title .'</td><td>'. 'Visa not required' . '</td></tr>';
 						$i++;
 					}
 					else{
 						break(2);
 					}
				}
			}
		}
		die();
	}
	echo $twig->render('visa-free.html', array('countries' => $countries));
	