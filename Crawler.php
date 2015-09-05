<?php

#header('Content-Type:text/plain');

function AP_Crawler($url=false,$CrawlFrom=false,$CrawlTo=false) {

	// Tjek om tags der fra crawles fra er sat
	if( $CrawlFrom==false ) {
		return "ERROR: Missing crawl_from informations";
		exit;
	}

	// Tjek om tags der fra crawles til er sat
	if( $CrawlTo == false ) {
		return "ERROR: Missing crawl_to informations";
		exit;
	}

	// Tjek om der er sat en url
	if( $url == false ) {
		return "ERROR: Missing url";
		exit;
	}


  // Hent den ønskede side med cURL
  $ch = curl_init($url); // initialize curl with given url
  curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]); // set  useragent
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // write the response to a variable
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // follow redirects if any
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); // max. seconds to execute
  curl_setopt($ch, CURLOPT_FAILONERROR, 1); // stop when it encounters an error

	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

	$html = curl_exec($ch);

	// Forbred crawlfrom og CrawlTo til at bruges i preg
	$CrawlFrom = preg_quote($CrawlFrom);
	$CrawlTo = preg_quote($CrawlTo);

	// Grep prisen fra outputtet
	preg_match("'".$CrawlFrom."(.*?)".$CrawlTo."'si",$html,$match);

	// Hent det første resultat ud i en variabel
	$price = $match[0];

	// Fjern alle html tags
	$price = strip_tags($price);

	// Trim sætningen så der ingen spaces er i start og slut
	$price = trim($price);


	// Fjern alt undtagen tal, komme og punktum
	$price = preg_replace("/[^0-9\.\,]+/","",$price);

	// Ret decimal tæller til bindestreg, hvis der ingen decimal splitter er, indsæt da -00
	if( substr($price,-3,1) == "," OR substr($price,-3,1) == "." ) {
		$price = substr_replace($price,"-",-3,1);
	}else {
		$price = $price."-00";
	}

	// Fjern komme og punktum, eller tusinde deler
	$price = preg_replace("/[\.\,]/","",$price);

	// ret decimal skiller til punktum hvilket er det som bruges i SQL
	$price = str_replace("-",".",$price);

  // Send tallet retur
  return $price;
}
