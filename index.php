<?php
    ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);

    $i=0;

    $parseArr = array ();

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
					$parseArr[$i] = $randCountry->name;
                    $visa_groups = $client->doGetVisaGroups($citizenship, $randCountry->code, $citizenship);
                    echo '<td id="country'.$i.'" style="background-color:yellow;"><i>'.$randCountry->name .'</i><td><input type="button" value="info '.$i.'" id="info'.$i.'"></td></td>'; 
					echo('<tr>');
					foreach ($visa_groups as $visa_group) {
                        $visaGroupTitle = str_replace(' ', '-', $visa_group->title);
                        $countryName = str_replace(' ', '-',$randCountry->name);
                        $url = 'https://'.$countryName.'.visahq.com/requirements/'.$selected.'/#!'.$visaGroupTitle.'';
                        echo('<td style="background-color:gray;"><a href='.$url.' target="_blank">'.$visa_group->title.'</a></td>');
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

      if(isset($_POST['destination']) and isset($_POST['citizenship'])){
         $citizensip=$_POST['citizenship'];
         $destination=$_POST['destination'];
		 foreach ($countriesRand as $country){
			if ($citizensip==$country->name){					//   get code of selected countrie
				$citizenship=$country->code;
			}
            if ($destination==$country->name){					//   get code of selected countrie
				$destination=$country->code;
			}
		 }
        $visa_groups = $client->doGetVisaGroups($citizenship, $destination, $citizenship);
          foreach ($visa_groups as $visa_group) {
            $visaGroupTitle = str_replace(' ', '-',$visa_group->title);
            $countryName = str_replace(' ', '-',$destination);
            $url = 'https://'.$countryName.'.visahq.com/requirements/'.$citizenship.'/#!'.$visaGroupTitle.'';
            $visaPage = file_get_contents($url);
            preg_match("'<div class=\"visa_infoN3\">(.*?)visa_info_feestableN'si", $visaPage, $match);
            $visaInfo = $match[0];
            echo substr($visaInfo,0,-40)."<hr>";
        }
     die();
    }

echo $twig->render('visa-free.html', array('countries' => $countries));	

	