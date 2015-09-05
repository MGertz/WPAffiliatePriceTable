<?php

echo "Bruges filen???? JA Det er Prices-List-Updater.php";
/*

global $wpdb;

$prefix = $wpdb->prefix;

// Hent Crawler informationer for de enkelte webshops
$sql = "SELECT * FROM `".$prefix."apt_webshops`";
$result = $wpdb->get_results($sql);
foreach( $result as $row ) {
	$webshops[$row->ID] = array( 'crawl_from' => $row->crawl_from , 'crawl_to' => $row->crawl_to );
}

// TEMP CRAP!
$action = $_POST["action"];

// Tjek om der skal slettes info
if( $action == "trash") {
	echo "Trash";

}

// Tjek om der skal opdateres priser
if( $action == "update" ) {

	// include crawler script
	require_once"Crawler.php";


	// Løb alle priser igennem
	foreach( $_POST["Prices"] as $row ) {

		// Da alle linier postes, skal der tjekkes om den enkelte linie er markeret, hvis ja kør videre.
		if( $row["Selected"] == "true" ) {
			echo "Object is selected<br>";


			// Hent Produkt URL
			$sql2 = "SELECT * FROM `".$prefix."apt_prices` WHERE `id` = '".$row["price_id"]."';";
			$result2 = $wpdb->get_results($sql2);
			foreach( $result2 as $row2 ) {
				$ProductUrl = $row2->product_url;
			}

			$crawl_from = stripslashes( $webshops[ $row["webshop_id"] ]["crawl_from"] );
			$crawl_to   = stripslashes( $webshops[ $row["webshop_id"] ]["crawl_to"] );

			$price = AP_Crawler($ProductUrl,$crawl_from,$crawl_to);

			$table = $wpdb->prefix."apt_prices";
			$where = array( 'ID' => $row["price_id"] );

			$update = array( 'price' => $price , 'last_updated' => date('Y-m-d H:i:s'));

			$wpdb->update($table,$update,$where);




		}


	}

}
*/
