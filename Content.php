<?php

if( is_single() ) {

  // Database info
  global $wpdb;
  $prefix = $wpdb->prefix;


  // Git the [APT id] tag
  $pattern = '/\[APT\sid.+]/';
  preg_match($pattern,$content,$result, PREG_OFFSET_CAPTURE);
  $APT_Table = $result[0][0];

  // Get the ID number
  $table_id = str_replace("[APT id=","",$APT_Table);
  $table_id = str_replace(']',"",$table_id);

  // used to mark every second line
  $second = "1";


  // table header
  $out  = "<table class='apt_outer'>";
  $out .= "<thead><tr class='apt_head'>";
  $out .= "<th>Webshop</th>";
  $out .= "<th>Price</th>";
  $out .= "<th>Shipping</th>";
  $out .= "<th></th>";
  $out .= "</tr></thead>";

  $out .= "<tbody>";

    $sql = "SELECT * FROM `".$prefix."ap_prices` WHERE `table_id` = '".$table_id."' ORDER BY `price`";
    $result = $wpdb->get_results($sql);

    $rows = $wpdb->num_rows;
    $line = 1;


    foreach( $result as $row ) {


      $out .= "<tr class='";

      if( $line < $rows ) {
        $out .= "apt_row";
        $line++;
      } else {
        $out .= "apt_last";
      }


      if( $second == 2 ) {
        $out .= " apt_second";
        $secound = "0";
      }
      $second++;

      $out .= "'>";

      $product_url = $row->product_url;

        $sql2 = "SELECT * FROM `".$prefix."ap_webshops` WHERE `id` = ".$row->webshop_id;
        $result2 = $wpdb->get_results($sql2);
        foreach( $result2 as $row2 ) {
          $out .= "<td>".$row2->shop_name."</td>";
          $currency = $row2->currency;
          $shipping = $row2->shipping;
          $program_id = $row2->program_id;
          $affiliate_id = $row2->affiliate_id;
        }

      $out .= "<td>".$row->price." ".$currency."</td>";
      $out .= "<td>".$shipping." ".$currency."</td>";



      $sql3 = "SELECT * FROM `".$prefix."ap_affiliates` WHERE `id` = ".$affiliate_id;
      $result3 = $wpdb->get_results($sql3);
      foreach( $result3 as $row3 ) {
        $url = $row3->url;
        $partner_id = $row3->partner_id;
      }


      $url = str_replace("[ProgramID]",$program_id,$url);
      $url = str_replace("[PartnerID]",$partner_id,$url);
      $url = str_replace("[URL]",$product_url,$url);

      $out .= "<td class='apt_link'><a href='".$url."' class='apt_button' target='_blank'>Buy Now</a></td>";
      $out .= "</tr>";
    }


  $out .= "</tbody>";

  $out .= "</table>";







  $content = str_replace($APT_Table,$out,$content);





} else {

}


?>
