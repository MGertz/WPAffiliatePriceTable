<?php

global $wpdb;
$ID = $_GET["ID"];



// Delete Affiliate

	if( $_GET["page"] == "Affiliate-Plugin-Affiliate" ) {
		
		$table = $wpdb->prefix."ap_affiliates";
		$where = array('id'=>$ID);

		$wpdb->delete($table,$where);


		// Alle webshops som hører under denne affiliate skal også slettes. og der til skal alle priser på de enkelte webshops også slettes.

		



		header("Location: ?page=Affiliate-Plugin-Affiliate");

	}

// Delete Table

	if( $_GET["page"] == "Affiliate-Plugin-Tables" ) {
		
		// Slet tabellen
	    $table = $wpdb->prefix."ap_tables";
	    $where = array('id'=>$ID);
	    $wpdb->delete($table,$where);
	    
	    // Slet alle priser som er til denne tabel
	    $table = $wpdb->prefix."ap_prices";
	    $where = array('table_id'=>$ID);
	    $wpdb->delete($table,$where);
	    
	    // Slet alle post tabel relationer
	    $table = $wpdb->prefix."ap_tables_posts";
	    $where = array('table_id'=>$ID);
	    $wpdb->delete($table,$where);

		header("Location: ?page=Affiliate-Plugin-Tables");
	}



// Delete Webshop

	if( $_GET["page"] == "Affiliate-Plugin-Webshops" ) {

		$table = $wpdb->prefix."ap_webshops";
	    $where = array('id'=>$ID);
	    $wpdb->delete($table,$where);

	    $table = $wpdb->prefix."ap_prices";
	    $where = array('webshop_id'=>$ID);
	    $wpdb->delete($table,$where);
		
		header("Location: ?page=Affiliate-Plugin-Webshops");
	}


exit();
