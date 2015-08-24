<?php

#header('Content-Type:text/plain');

function AP_Crawler($url=false,$CrawlFrom=false,$CrawlTo=false) {
	$out = ""; // bruges til at vise output.

	$out .= "URL: ".$url.PHP_EOL;
  
  	if( $CrawlFrom==false ) {
		return "ERROR: Missing crawl_from informations";
		exit;
	}

	if( $CrawlTo == false ) {
		return "ERROR: Missing crawl_to informations";
		exit;
	}

	if( $url == false ) {
		return "ERROR: Missing url";
		exit;
	}

	
    // Denne part henter websitet
    $ch = curl_init($url); // initialize curl with given url
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]); // set  useragent
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // write the response to a variable
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // follow redirects if any
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); // max. seconds to execute
    curl_setopt($ch, CURLOPT_FAILONERROR, 1); // stop when it encounters an error

	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);



    $html = curl_exec($ch);

    
    
    // Fjern alt fra start op og til det ønskede start grab punkt.
	$start=strpos($html,$CrawlFrom);
	$end=strlen($html);
	$html=substr($html,$start,$end);

	// Fjern alt fra grab_to punktet
	$start=0;
	$end=strpos($html,$CrawlTo);
	$html = substr($html,$start,$end);

	$out .= "Indhold mellem de ønskede punkter: ".$html.PHP_EOL;

	// Fjern alt html nu
	$html = strip_tags($html);

	$out .= "Tags fjernet: ".$html.PHP_EOL;

	// lav html space om til bindestreg
	$html = str_replace("&nbsp;","-",$html);

	// Lav mellemrum om til bindestreger
	$html = str_replace(" ","-",$html);

	// Omdag \n for nemmere at kunne splitte indtil et array
	$html = str_replace("\n", "-", $html);


	// Fjern alt på nær, tal, komma, punktum og linieskift
	$html = preg_replace("/[^0-9-,-.,\n]/", "", $html);

	$out .= "Kun tal og komma og punktum: ".$html.PHP_EOL;


	// Omdan til array, knæk ved linie skift
	$html = explode('-',$html);
    
    // Gennemløb arrayet med udtræk.
    foreach( $html as $key => $val ) {
        
        // Tjek om linien indeholder tal
        if( preg_match("/[0-9]/",$val) ) {
            $price = $val;
        }
    }

    $out .= "Pris 1: ".$price.PHP_EOL;

    // tjek om decimal deler er et punktum. hvis det er, så skal dette rettes.
    if( substr( $price , -3, 1) == "." ) {

    	// Ret punktum til en binde streg
    	$price = str_replace(".", "-", $price);
    	$out .= "Pris test: ".$price.PHP_EOL;

    	// Fjern kommaet i tusinde deleren
    	$price = str_replace( "," , "" , $price );
    	$out .= "Pris test: ".$price.PHP_EOL;

    	// ret bindestregen til komme
    	$price = str_replace("-", ",", $price);
    	$out .= "Pris test: ".$price.PHP_EOL;

    }

    // Sæt decimaler på pricen.
    $price = number_format($price,2,'.','');


    $out .= "Prisen: ".$price.PHP_EOL;


    $out .= PHP_EOL.PHP_EOL."--------------".PHP_EOL.PHP_EOL;

    // Print output
    #echo $out;
  





    // Send tallet retur
    return $price;
}

