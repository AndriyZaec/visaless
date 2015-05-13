<?php
echo "<meta charset='utf-8'>";
ini_set('soap.wsdl_cache', '0'); // отключаем кэширование WSDL
ini_set('soap.wsdl_cache_enabled', '0'); // отключаем кэширование WSDL
$client=new SoapClient('wsdl.wsdl', array('trace'=>1, 'exceptions'=>1, 'login'=>'d630596c3ed55c7af35ddd936fdee4d7','password'=>'dfbc2c7dce8217d1a75179fdab41608f'));

$citizenship = "UA";
$resident = "RU";
try { 
	$countries = $client->doGetCountries();
	foreach($countries as $country){
	  if($country->code == $resident){
	    $residentCountry = $country->name;
	  }
	  if($country->code == $citizenship){
	    $citizenshipCountry = $country->name;
	  }
	}
	//var_dump($residentCountry);
	$notVisaCountry = array();
	$j=0;
	foreach($countries as $key=>$country){
		//if($country->code == "IS"){break;}
		$visa_groups = $client->doGetVisaGroups($citizenship, $country->code, $citizenship);
		
		foreach($visa_groups as $visa_group) {
		      try {
				$visa_required = $client->doGetVisaRequired($citizenship, $country->code, $citizenship, $visa_group->id, 'false');
		      }catch (SoapFault $exception) { 
			  	continue;
		      }
			if($j<=4){
			  //echo $visa_group->title.'<br>';
			  //echo $country->name.'<br>';
			  $visaGroupTitle = str_replace(' ', '-', $visa_group->title);
			  $countryName = str_replace(' ', '-', $country->name);
			  $url = 'https://'.$countryName.'.visahq.'.$resident.'/requirements/'.$citizenshipCountry.'/resident-'.$residentCountry.'/#!'.$countryName.'-'.$visaGroupTitle;
			  echo '<a href="$url"><span style="color:red;">'.$url.'</span></a><br>';
			  $visaPage = file_get_contents($url);
			  preg_match("'<div class=\"visa_infoN3\">(.*?)visa_info_feestableN'si", $visaPage, $match);
			  $visaInfo = $match[0].'</div>';
			  echo substr($visaInfo,0,-40)."<br>";
			  //echo $visaInfo;
			  
			  //echo $visaPage
			  $j++;
			   break;
			}else{
			  
			}
			//array_push($notVisaCountry,$country->name);
		      }
		}
		 //break;
		if($j>4){
		  break;
		}
	}
	/*	
	srand((float) microtime() * 10000000);
	$rand_keys = array_rand($notVisaCountry, 3);
	echo $notVisaCountry[$rand_keys[0]] . "<br>";
	echo $notVisaCountry[$rand_keys[1]] . "<br>";
	echo $notVisaCountry[$rand_keys[2]] . "<br>";*/
	
}
catch (SoapFault $exception) { 
	// print_r($client->__getLastRequestHeaders());
	// print_r($client->__getLastRequest());
	// print_r($client->__getLastResponseHeaders());
	 print_r($client->__getLastResponse());
	echo $exception;     
}
?>


