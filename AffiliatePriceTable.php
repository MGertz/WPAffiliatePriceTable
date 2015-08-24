<?php
/*
Plugin Name: Affiliate Price Table (APT)
Plugin URI: http://Ringhus.dk/AffiliatePriceTable
Description: With this plugin, you can create pricetables on your page, that list prices from webshops, and the plugin is able to update the prices automaticly
Author: Michael Ringhus Gertz
Version: Beta
Date 24-08-2015
Author URI: mailto://michael@ringhus.dk
*/



/*
 * Tilføjer menu i admin delen
 *
 */
function AP_menu() {
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
		'AP_WebShop'
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
		'Settings',					// Page Title
		'Settings',					// Menu Title
		'manage_options',					// Capability
		'APT-Settings',		// MenuSlug
		'AP_Settings'
	);





	remove_submenu_page('Affiliate-Plugin','Affiliate-Plugin');
}
add_action('admin_menu','AP_menu');






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
function AP_Webshop() {
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











// Denne kode kører hvergnag en side loades.
// Her i kan også indsættes header() funktionen, så man kan udføre et job, og sende retur
add_action('wp_loaded','AP_wp_loaded');
function AP_wp_loaded() {

    // Når der postet en nyt indhold eller opdateres, sendes $_POST videre til denne side
	require_once"Post-Handle.php";


	// Tjek om en delete action er igang, hvis der er, kald Delete.php filen som håndterer dette.
	if( $_GET["action"] == "Delete" ) {
		require_once"AP_Delete.php";
	}


    // Tjek om der skal laves update af alle priser.
    if( $_GET["page"] == "Affiliate-Plugin-Prices" && $_GET["action"] == "Update" ) {
    	require_once"Prices-List-Updater.php";
    }




    // Denne funktioner kaldes når der skal laves price update. fra Tabel listen.
    if( $_GET["page"] == "Affiliate-Plugin-Tables"  AND $_GET["action"] == "PriceUpdate" ) {
    	require_once"AP_PriceUpdater.php";
    	header("Location: ?page=Affiliate-Plugin-Tables");
    	exit;
    }




}

// Denne funktion laver indholdet i en post
add_filter('the_content','AP_Content');
function AP_Content($content) {
	require_once"AP_Content.php";
	return $content;
}





// Denne function tilføjer stylesheet til websiden
function AP_Add_Style() {
	$theme = get_current_theme();

	wp_enqueue_style('core',plugins_url('css/style-'.$theme.'.css',__FILE__));
}
add_action('wp_enqueue_scripts','AP_Add_Style');





// Denne function tilføjer stylesheet til admin siden
function AP_Add_Style_Admin() {
	wp_enqueue_style('',plugins_url('css/style-admin.css',__FILE__));
}
add_action('admin_init','AP_Add_Style_Admin');







// Denne function tjekker om der skal køres et cronjob.
function myinit() {
	if( isset($_GET["AffiliatePluginCron"]) AND $_GET["AffiliatePluginCron"] == "true" ) {
		echo "Der skal køres cron job";
		exit;
	}
}
add_action('init','myinit');





// Include file with Meta Box for edit post
require_once"AP_Meta_Box.php";





// Activation hook
require_once "AP_Activation_Hook.php";
register_activation_hook(__FILE__,'AP_Activation_Hook');
