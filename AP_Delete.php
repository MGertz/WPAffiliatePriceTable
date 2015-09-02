<?php

global $wpdb;
$ID = $_GET["ID"];

// Delete Affiliate

	if( $_GET["page"] == "APT-Affiliate" ) {

		$table = $wpdb->prefix."apt_affiliates";
		$where = array('id'=>$ID);

		$wpdb->delete($table,$where);


		// Alle webshops som hører under denne affiliate skal også slettes. og der til skal alle priser på de enkelte webshops også slettes.





		header("Location: ?page=APT-Affiliate");

	}

// Delete Table

	if( $_GET["page"] == "APT-Tables" ) {

		// Slet tabellen
	    $table = $wpdb->prefix."apt_tables";
	    $where = array('id'=>$ID);
	    $wpdb->delete($table,$where);

	    // Slet alle priser som er til denne tabel
	    $table = $wpdb->prefix."apt_prices";
	    $where = array('table_id'=>$ID);
	    $wpdb->delete($table,$where);

	    // Slet alle post tabel relationer
	    $table = $wpdb->prefix."apt_tables_posts";
	    $where = array('table_id'=>$ID);
	    $wpdb->delete($table,$where);

		header("Location: ?page=APT-Tables");
	}



// Delete Webshop

	if( $_GET["page"] == "APT-Webshops" ) {

		$table = $wpdb->prefix."apt_webshops";
	    $where = array('id'=>$ID);
	    $wpdb->delete($table,$where);

	    $table = $wpdb->prefix."apt_prices";
	    $where = array('webshop_id'=>$ID);
	    $wpdb->delete($table,$where);

		header("Location: ?page=APT-Webshops");
	}


exit();
