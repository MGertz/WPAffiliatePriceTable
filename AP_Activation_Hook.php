<?php


// denne funktion kaldes når dette plugin aktiveres.
function AP_Activation_Hook() {
	global $wpdb;
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	$prefix = $wpdb->prefix;

	$tablename = $prefix."ap_affiliates";
	$sql = "CREATE TABLE ".$tablename." (
		id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		name varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		partner_id int(10) UNSIGNED NOT NULL,
		url varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		PRIMARY KEY (`id`)
    ) CHARACTER SET utf8 COLLATE utf8_general_ci;";
    dbDelta($sql);

    // Opret TradeDoubler.dk
    $insert = array('name' => 'TradeDoubler.dk','partner_id'=>'0','url' => 'http://clk.tradedoubler.com/click?p([ProgramID])a([PartnerID])url([URL])');
    $wpdb->insert($tablename,$insert);

    // Opret Partner-Ads.dk
    $insert = array('name' => 'Partner-Ads.dk','partner_id'=>'0','url' => 'http://www.partner-ads.com/dk/klikbanner.php?partnerid=[PartnerID]&bannerid=[ProgramID]&htmlurl=[URL]');
    $wpdb->insert($tablename,$insert);



	$tablename = $prefix."ap_webshops";
	$sql = "CREATE TABLE ".$tablename." (
		id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		shop_name varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		site_url varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		affiliate_id int(10) UNSIGNED NOT NULL,
		program_id int(10) UNSIGNED NOT NULL,
		shipping varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		currency varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		crawl_from varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		crawl_to varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		PRIMARY KEY (`id`)
	) CHARACTER SET utf8 COLLATE utf8_general_ci;";
    dbDelta($sql);


	$tablename = $prefix."ap_prices";
	$sql = "CREATE TABLE ".$tablename." (
		id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		webshop_id int(10) UNSIGNED NOT NULL,
		table_id int(10) UNSIGNED NOT NULL,
		product_url varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		price Decimal(10.2) NOT NULL,
		show_in_table char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Y',
		auto_update_price char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Y',
		last_updated datetime NULL,
		added datetime NULL,
		PRIMARY KEY (`id`)
	) CHARACTER SET utf8 COLLATE utf8_general_ci;";
    dbDelta($sql);


	$tablename = $prefix."ap_tables";
	$sql = "CREATE TABLE ".$tablename." (
		id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		name varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		PRIMARY KEY (`id`)
	) CHARACTER SET utf8 COLLATE utf8_general_ci;";
    dbDelta($sql);


	$tablename = $prefix."ap_tables_posts";
	$sql = "CREATE TABLE ".$tablename." (
		id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		post_id int(10) UNSIGNED NOT NULL,
		table_id int(10) UNSIGNED NOT NULL,
		PRIMARY KEY (`id`)
	) CHARACTER SET utf8 COLLATE utf8_general_ci;";
    dbDelta($sql);



}
