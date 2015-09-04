<?php
/*
$out ="";

global $wpdb;

$ID = $_GET["ID"];

require_once"Crawler.php";

$sql = "SELECT * FROM `".$wpdb->prefix."apt_prices` WHERE `table_id` = '".$ID."';";
$result = $wpdb->get_results($sql);

foreach( $result as $row ) {


    // Hent Crawler info
    $sql2 = "SELECT * FROM `".$wpdb->prefix."apt_webshops` WHERE `id` = '".$row->webshop_id."';";
    $result2 = $wpdb->get_results($sql2);
    foreach( $result2 as $row2 ) {
        $CrawlFrom = stripslashes($row2->crawl_from);
        $CrawlTo = stripslashes($row2->crawl_to);
    }


    $price = AP_Crawler( $row->product_url , $CrawlFrom  , $CrawlTo );

    $table = $wpdb->prefix."apt_prices";
    $where = array( 'id' => $row->id );

    $update = array( 'price' => $price , 'last_updated' => date('Y-m-d H:i:s'));

    $wpdb->update($table,$update,$where);


}

header("Location: http://wordpress/wp-admin/admin.php?page=APT-Tables&acton=Prices");
exit;
*/
