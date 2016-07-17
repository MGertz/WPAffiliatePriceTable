<?php
require_once "Crawler.php";
global $wpdb;


// Hvis der bliver kaldt fra en pris listen
if( $_GET["page"] == "APT-Prices" ) {
  $id = $_GET["ID"];

  $sql = "SELECT * FROM `".$wpdb->prefix."apt_prices` WHERE `id` = '".$id."';";
  $result = $wpdb->get_results($sql);

  foreach( $result as $row ) {
    // Hent Crawler info
    $sql2 = "SELECT * FROM `".$wpdb->prefix."apt_webshops` WHERE `id` = '".$row->webshop_id."';";
    $result2 = $wpdb->get_results($sql2);
    foreach( $result2 as $row2 ) {
      $CrawlFrom1 = stripslashes($row2->crawl_from1);
      $CrawlTo1 = stripslashes($row2->crawl_to1);
      $CrawlFrom2 = stripslashes($row2->crawl_from2);
      $CrawlTo2 = stripslashes($row2->crawl_to2);

    }


    $price = AP_Crawler( $row->product_url , $CrawlFrom1  , $CrawlTo1 , $CrawlFrom2  , $CrawlTo2 );

    $table = $wpdb->prefix."apt_prices";
    $where = array( 'id' => $row->id );

    $update = array( 'price' => $price , 'last_updated' => date('Y-m-d H:i:s'));

    $wpdb->update($table,$update,$where);


  }

  header("Location: /wp-admin/admin.php?page=APT-Prices");


}

// Hvis der kaldes fra Tabel listen
if( $_GET["page"] == "APT-Tables" ) {
  $id = $_GET["ID"];

  $sql = "SELECT * FROM `".$wpdb->prefix."apt_prices` WHERE `table_id` = '".$id."';";
  $result = $wpdb->get_results($sql);

  foreach( $result as $row ) {
    // Hent Crawler info
    $sql2 = "SELECT * FROM `".$wpdb->prefix."apt_webshops` WHERE `id` = '".$row->webshop_id."';";
    $result2 = $wpdb->get_results($sql2);
    foreach( $result2 as $row2 ) {
      $CrawlFrom1 = stripslashes($row2->crawl_from1);
      $CrawlTo1 = stripslashes($row2->crawl_to1);
      $CrawlFrom2 = stripslashes($row2->crawl_from2);
      $CrawlTo2 = stripslashes($row2->crawl_to2);
    }


    $price = AP_Crawler( $row->product_url , $CrawlFrom1  , $CrawlTo1 , $CrawlFrom2  , $CrawlTo2 );

    $table = $wpdb->prefix."apt_prices";
    $where = array( 'id' => $row->id );

    $update = array( 'price' => $price , 'last_updated' => date('Y-m-d H:i:s'));

    $wpdb->update($table,$update,$where);


  }

  header("Location: /wp-admin/admin.php?page=APT-Tables&acton=Prices");



}















exit;
