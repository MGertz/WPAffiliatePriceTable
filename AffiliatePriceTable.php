<?php
/*
Plugin Name: Affiliate Price Table (APT)
Plugin URI: http://Ringhus.dk/AffiliatePriceTable
Description: With this plugin, you can create pricetables on your page, that list prices from webshops, and the plugin is able to update the prices automaticly. If you disable this plugin, no data will be deleted. there was created a few tables in your database, where all content is saved.
Author: Michael Ringhus Gertz
Version: Beta
Date 24-08-2015
Author URI: mailto://michael@ringhus.dk
*/



/*
 * Tilføjer menu i admin delen
 *
 */
add_action('admin_menu',function() {
	add_menu_page(
		'Affiliate Price Table', 			//Page Title
		'APT',												//Menu Title
		'manage_options',							//Capability
		'Affiliate-Plugin',						// Menu Slug
		'',														// function
		plugin_dir_url(__FILE__)."icon16.png",	// Icon
		'50'													// Position
	);

    add_submenu_page(
		'Affiliate-Plugin',					// Parent Slug
		'Affiliate Pristabeller',			// Page Title
		'Price Tables',						// Menu Title
		'manage_options',					// Capability
		'APT-Tables',	        // MenuSlug
		'AP_Tables'
	);

	add_submenu_page(
		'Affiliate-Plugin',					// Parent Slug
		'Affiliate Forhandlere',			// Page Title
		'Webshops',							// Menu Title
		'manage_options',					// Capability
		'APT-Webshops',      	// MenuSlug
		'APT_WebShop'
	);

	add_submenu_page(
		'Affiliate-Plugin',					// Parent Slug
		'Affiliate Network',				// Page Title
		'Affiliate Network',				// Menu Title
		'manage_options',					// Capability
		'APT-Affiliate',	    // MenuSlug
		'AP_Affiliate'
	);

	add_submenu_page(
		'Affiliate-Plugin',					// Parent Slug
		'Price List',						// Page Title
		'Price List',						// Menu Title
		'manage_options',					// Capability
		'APT-Prices',	  		// MenuSlug
		'AP_Prices'
	);

	// indstillinger link
	add_submenu_page(
		'Affiliate-Plugin',					// Parent Slug
		'Styling',					// Page Title
		'Styling',					// Menu Title
		'manage_options',					// Capability
		'APT-Style',		// MenuSlug
		'APT_Styling'
	);



	remove_submenu_page('Affiliate-Plugin','Affiliate-Plugin');
});


// HER ER DE NYE HOOKS
// Denne function er kun lige til en hurtig test
function AP_Tables() {
    $action = $_GET["action"];

    if( $action == "Add" ) {
        require_once"Tables-Add.php";
        exit;
    } elseif ( $action == "Edit" ) {
        require_once"Tables-Edit.php";
        exit;
    } elseif ( $action == "Prices" ) {
        require_once"Tables-Prices.php";
        exit;
    } else {
        require_once"Tables-List.php";
        exit;
    }
}

function AP_Affiliate() {
	$action = $_GET["action"];

    if( $action == "Add" ) {
        require_once"Affiliate-Add.php";
        exit;
    } elseif ( $action == "Edit" ) {
        require_once"Affiliate-Edit.php";
        exit;
    } else {
        require_once"Affiliate-List.php";
        exit;
    }
}

function AP_Prices() {
	$action = $_GET["action"];

    require_once"Prices-List.php";
    exit;
}

function APT_Webshop() {
	$action = $_GET["action"];

    if( $action == "Add" ) {
        require_once"Webshops-Add.php";
        exit;
    } elseif ( $action == "Edit" ) {
        require_once"Webshops-Edit.php";
        exit;
    } else {
        require_once"Webshops-List.php";
        exit;
    }
}

function APT_Styling() {

	require_once"APT_Styling.php";
	exit;

}









// Denne kode kører hvergnag en side loades.
// Her i kan også indsættes header() funktionen, så man kan udføre et job, og sende retur
add_action('wp_loaded',function() {

    // Når der postet en nyt indhold eller opdateres, sendes $_POST videre til denne side
	require_once"Post-Handle.php";


	// Tjek om en delete action er igang, hvis der er, kald Delete.php filen som håndterer dette.
	if( $_GET["action"] == "Delete" ) {
		require_once"AP_Delete.php";
	}


	// Tjek om der skal hentes priser
	if( $_GET["action"] == "PriceUpdater" ) {
		require_once"PriceUpdater.php";
	}


		/*
		// JEG TROR IKKE DENNE SIDE BRUGES
	  // Tjek om der skal laves update af alle priser.
	  if( $_GET["page"] == "Affiliate-Plugin-Prices" && $_GET["action"] == "Update" ) {
	  	require_once"Prices-List-Updater.php";
	  }
		*/


});

// Denne funktion laver indholdet i en post
add_filter('the_content','AP_Content');
function AP_Content($content) {
	#require_once"AP_Content.php";
	require_once"Content.php";
	return $content;
}





// Denne function tilføjer stylesheet til websiden
function AP_Add_Style() {
	wp_enqueue_style('core',plugins_url('css/style.css',__FILE__));
}
add_action('wp_enqueue_scripts','AP_Add_Style');



// Denne function tjekker om der skal køres et cronjob.
function myinit() {
	if( isset($_GET["AffiliatePluginCron"]) AND $_GET["AffiliatePluginCron"] == "true" ) {
		echo "Der skal køres cron job";
		exit;
	}
}
add_action('init','myinit');


// Denne funktion skal gribe links
add_action("init",function() {

	// Tjek om permalink er aktiveres, hvis det er , skal denne funktion køre, eller skal den bare springes over.
	if ( get_option('permalink_structure') ) {
		global $wpdb;

		$url = trim( urldecode( $_SERVER["REQUEST_URI"] ) ,"/");

		$url = explode("/",$url);

		$linker = $url[0];

		if( $linker == "apt" ) {


			$table = $url[1];
			$shop = $url[2];

			$sql = "SELECT * FROM `".$wpdb->prefix."apt_tables` WHERE `name` = '".$table."'";
			$result = $wpdb->get_results($sql);
			foreach( $result as $row ) {
				$table_id = $row->id;
			}
			if( $table_id == "" ) {
				#header("Location: ".$_SERVER["REQUEST_SCHEME"]."://".$_SERVER["SERVER_NAME"]);
				exit();
			}

			$sql = "SELECT * FROM `".$wpdb->prefix."apt_webshops` WHERE `shop_name` = '".$shop."'";
			$result = $wpdb->get_results($sql);
			foreach( $result as $row ) {
				$affiliate_id = $row->affiliate_id;
				$program_id = $row->program_id;
				$webshop_id = $row->id;
			}
			if( $webshop_id == "" ) {
				header("Location: ".$_SERVER["REQUEST_SCHEME"]."://".$_SERVER["SERVER_NAME"]);
				exit();
			}




			$sql = "SELECT * FROM `".$wpdb->prefix."apt_prices` WHERE `webshop_id` = '".$webshop_id."' AND `table_id` = '".$table_id."'";
			$result = $wpdb->get_results($sql);
			foreach( $result as $row ) {
				$product_url = $row->product_url;
			}

			$sql = "SELECT * FROM `".$wpdb->prefix."apt_affiliates` WHERE `id` = '".$affiliate_id."'";
			$result = $wpdb->get_results($sql);
			foreach( $result as $row ) {
				$affiliate_url = $row->url;
				$partner_id = $row->partner_id;
			}


			$affiliate_url = str_replace("[PartnerID]",$partner_id,$affiliate_url);
			$affiliate_url = str_replace("[ProgramID]",$program_id,$affiliate_url);
			$affiliate_url = str_replace("[URL]",$product_url,$affiliate_url);

			header("Location: ".$affiliate_url);

			die();

		}
	}


});




// Activation hook
require_once "Activation_Hook.php";
register_activation_hook(__FILE__,'AP_Activation_Hook');
