<?php

#echo "Crawler.php file included<br>";

#header('Content-Type:text/plain');

function AP_Crawler($url=false,$CrawlFrom1=false,$CrawlTo1=false,$CrawlFrom2=false,$CrawlTo2=false) {

#	echo "------------------------------ CRAWLER STARTED ------------------------------\n";
#	echo "URL: ".$url."\n";

	// Tjek om tags der fra crawles fra er sat
	if( $CrawlFrom1==false ) {
		return "ERROR: Missing crawl_from informations";
		exit;
	}

	// Tjek om tags der fra crawles til er sat
	if( $CrawlTo1 == false ) {
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

#	echo "Original From: ".$CrawlFrom1." - To: ".$CrawlTo1."\n";

	// Forbred crawlfrom og CrawlTo til at bruges i preg
	$CrawlFrom1 = preg_quote($CrawlFrom1);
	$CrawlTo1 = preg_quote($CrawlTo1);

	// udkommenter ' i strengen.
	$CrawlFrom1 = str_replace("'","\'",$CrawlFrom1);
	$CrawlTo1 = str_replace("'","\'",$CrawlTo1);

#	echo "After From: ".$CrawlFrom1." - To: ".$CrawlTo1."\n";

	if( $CrawlFrom2 != false ) {
#		echo "Original From2: ".$CrawlFrom2." - To2: ".$CrawlTo2."\n";

		// Forbred crawlfrom og CrawlTo til at bruges i preg
		$CrawlFrom2 = preg_quote($CrawlFrom2);
		$CrawlTo2 = preg_quote($CrawlTo2);

		// udkommenter ' i strengen.
		$CrawlFrom2 = str_replace("'","\'",$CrawlFrom2);
		$CrawlTo2 = str_replace("'","\'",$CrawlTo2);

#		echo "After From2: ".$CrawlFrom2." - To2: ".$CrawlTo2."\n";
	}


	// Pattern der bruges når der hentes info
	$pattern = "'".$CrawlFrom1."(.*?)".$CrawlTo1."'si";

	// Grep prisen fra outputtet
	preg_match($pattern,$html,$match);

#	echo "Match: ";
#	print_r($match);
#	echo "\n";

	if( empty($match) ) {
		// Pattern der bruges når der hentes info
		$pattern = "'".$CrawlFrom2."(.*?)".$CrawlTo2."'si";

		// Grep prisen fra outputtet
		preg_match($pattern,$html,$match);

#		echo "Match2 : ";
#		print_r($match);
#		echo "\n";


	}

	// Hent det første resultat ud i en variabel
	$price = $match[0];
#	echo "Price: ".$price."\n";

	// Fjern alle html tags
	$price = strip_tags($price);
#	echo "Price tags removed: ".$price."\n";

	// Trim sætningen så der ingen spaces er i start og slut
	$price = trim($price);
#	echo "Price trim: ".$price."\n";

	// Fjern alt undtagen tal, komme og punktum
	$price = preg_replace("/[^0-9\.\,]+/","",$price);
#	echo "Price only digits: ".$price."\n";

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
#	echo "END Price: ".$price."\n";

#	echo "------------------------------ CRAWLER ENDED ------------------------------\n\n\n";

  // Send tallet retur
  return $price;
}
