<?php

#if( is_single() ) {

  // Database info
  global $wpdb;
  $prefix = $wpdb->prefix;


  // Git the [APT id] tag
  $pattern = '/\[apt\sid.+]/';
  preg_match_all($pattern,$content,$result);

  $result = $result[0];

  foreach( $result as $res ) {

    $APT_Table = $res;

    // Get the ID number
    $table_id = str_replace("[apt id=","",$APT_Table);
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

      $sql = "SELECT * FROM `".$prefix."apt_prices` WHERE `table_id` = '".$table_id."' ORDER BY `price`";
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


          $sql2 = "SELECT * FROM `".$prefix."apt_webshops` WHERE `id` = ".$row->webshop_id;
          $result2 = $wpdb->get_results($sql2);
          foreach( $result2 as $row2 ) {
            $out .= "<td>".$row2->shop_name."</td>";
            $currency = $row2->currency;
            $shipping = $row2->shipping;
            $program_id = $row2->program_id;
            $affiliate_id = $row2->affiliate_id;
            $webshop_name = $row2->shop_name;
          }

        $out .= "<td>".number_format($row->price,2,",",".")." ".$currency."</td>";
        $out .= "<td>".$shipping." ".$currency."</td>";



        $sql3 = "SELECT * FROM `".$prefix."apt_affiliates` WHERE `id` = ".$affiliate_id;
        $result3 = $wpdb->get_results($sql3);
        foreach( $result3 as $row3 ) {
          $url = $row3->url;
          $partner_id = $row3->partner_id;
        }

        if ( get_option('permalink_structure') ) {
          $sql4 = "SELECT * FROM `".$prefix."apt_tables` WHERE `id` = ".$table_id;
          $result4 = $wpdb->get_results($sql4);
          foreach( $result4 as $row4 ) {
            $table_name = $row4->name;
          }

          $url = $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["SERVER_NAME"]."/apt/".$table_name."/".$webshop_name;


        } else {
          $url = str_replace("[ProgramID]",$program_id,$url);
          $url = str_replace("[PartnerID]",$partner_id,$url);
          $url = str_replace("[URL]",$product_url,$url);
        }

        $out .= "<td class='apt_link'><a href='".$url."' class='apt_button' target='_blank'>Buy Now</a></td>";
        $out .= "</tr>";
      }


    $out .= "</tbody>";

    $out .= "</table>";







    $content = str_replace($APT_Table,$out,$content);

  }



# } // is_single() end

?>
