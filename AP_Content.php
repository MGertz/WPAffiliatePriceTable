<?

if( is_single() ) {

	// Database info
	global $wpdb;
	$prefix = $wpdb->prefix;

	// PostID
	$postID = get_the_ID();

	//out variablen skal være tom.
	$out = "";

	$sql = "SELECT * FROM `".$prefix."ap_tables_posts` WHERE `post_id` = '".$postID."'";
    $result = $wpdb->get_results($sql);
    
    foreach( $result as $row ) {

   		$out .= "<h3 class='AP_Header'>Pris liste</h3>";

		
		// Hent ID på tabellen
		$sql2 = "SELECT * FROM `".$prefix."ap_tables` WHERE `id` = '".$row->table_id."';";
        $result2 = $wpdb->get_results($sql2);
		foreach( $result2 as $row2 ) {
			$out .= "<table class='AP_Outer'>";
			$out .= "<thead><tr>";
			$out .= "<th>Forhandler</th>";
			$out .= "<th>Pris</th>";
			$out .= "<th colspan='2'>Forsendelse</th>";
			$out .= "</tr></thead>";

			$out .= "<tbody>";

			// Hent priser fra tabellen.
			$sql3 = "SELECT * FROM `".$prefix."ap_prices` WHERE `table_id` = '".$row2->id."' ORDER BY `price` ASC;";
            $result3 = $wpdb->get_results($sql3);
            foreach( $result3 as $row3) {

				$ProductUrl = $row3->product_url;

				$out .= "<tr>";


				$sql4 = "SELECT * FROM `".$prefix."ap_webshops` WHERE `id` = '".$row3->webshop_id."';";
                $result4 = $wpdb->get_results($sql4);
                foreach( $result4 as $row4 ) {
    
                	$price = number_format($row3->price , 2, ",", ".");


					$out .= "<td>".$row4->shop_name."</td>";
					$out .= "<td>".$price." ".$row4->currency."</td>";
					$out .= "<td>".$row4->shipping." ".$row4->currency."</td>";

					$ProgramID = $row4->program_id;
					$AffiliateID = $row4->affiliate_id;
				}

				// Generate Link

				$sql5 = "SELECT * FROM `".$prefix."ap_affiliates` WHERE `id` = '".$AffiliateID."';";
                $result5 = $wpdb->get_results($sql5);
                foreach( $result5 as $row5 ) {
					$PartnerID = $row5->partner_id;
					$Url = $row5->url;

				}

				#$ProductUrl = urlencode($ProductUrl);


				$Url = str_replace("[ProgramID]",$ProgramID,$Url);
				$Url = str_replace("[PartnerID]",$PartnerID,$Url);
				$Url = str_replace("[URL]",$ProductUrl,$Url);



				//http://clk.tradedoubler.com/click?p([ProgramID])a([PartnerID])url([URL])

				$out .= "<td class='AP_link'><a href='".$Url."' target='_blank' class='AP_button'>Køb Her »</a></td>";


				
				$out .= "</tr>";
			}

			$out .= "</tbody>";
			$out .= "</table><br>";
		}

	}

	$content = $content.$out;

}

?>