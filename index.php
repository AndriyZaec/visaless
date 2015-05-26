<?php
	$i=0;

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
		$client=new SoapClient('wsdl.wsdl', array('trace'=>1, 'exceptions'=>1, 'login'=>'d630596c3ed55c7af35ddd936fdee4d7','password'=>'dfbc2c7dce8217d1a75179fdab41608f'));    //try create Soap obj 
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
	
	if (isset($_POST['selected'])){
		$selected=$_POST['selected'];
		foreach ($countries as $country){
			if ($selected==$country->name){					//   get code of selected countrie
				$citizenship=$country->code;
			}
		}
		echo('<tr>');
		foreach ($countriesRand as $randCountry){
			try{
				$visa_required = $client->doGetVisaRequired($citizenship, $randCountry->code, $citizenship, 1, 'false');
			}catch(Exception $e){
				continue;
			}
			if (!$visa_required) {				//   find countries whithout visa required
				if($i<3){
					echo '<td style="background-color:yellow;"><i>'.$randCountry->name .'</i></td>';
					echo('<tr>');
					$visa_groups = $client->doGetVisaGroups($citizenship, $randCountry->code, $citizenship);
					foreach ($visa_groups as $visa_group) {
						echo('<td style="background-color:gray;">'.$visa_group->title.'</td>');
					}
					echo('</tr>');
					$i++;
				}	
				else{
					break(1);
				}
			}
		}
		echo('</tr>');
		die();
	}
	echo $twig->render('visa-free.html', array('countries' => $countries));	

	