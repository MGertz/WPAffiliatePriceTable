<?php

if( $_SERVER["REQUEST_METHOD"] == "POST" AND isset( $_POST["AP_Form_Post"] ) ) {
	global $wpdb;
	$prefix = $wpdb->prefix;

	// denne del kaldes når der oprettes en webshop i systemet.
	if( $_POST["AP_Form_Post"] == "FormWebshopAdd" ) {
        $table = $prefix."apt_webshops";
        $insert = array(
            'shop_name' => $_POST["ShopName"],
            'site_url' => $_POST["SiteUrl"],
            'affiliate_id' => $_POST["AffiliateID"],
            'program_id' => $_POST["ProgramID"],
            'shipping' => $_POST["Shipping"],
            'currency' => $_POST["Currency"],
            'crawl_from1' => $_POST["CrawlFrom1"],
            'crawl_to1' => $_POST["CrawlTo1"],
            'crawl_from2' => $_POST["CrawlFrom2"],
            'crawl_to2' => $_POST["CrawlTo2"]
        );

        $wpdb->insert($table,$insert);

		header("Location: ?page=APT-Webshops&acton=List");
		exit();
	}


	if( $_POST["AP_Form_Post"] == "FormTablesAdd" ) {
        $table = $prefix."apt_tables";
        $insert = array('name'=>$_POST["Name"]);

        $wpdb->insert($table,$insert);


        header("Location: ?page=APT-Tables&action=Prices&ID=".$wpdb->insert_id);
		exit();
	}

   	if( $_POST["AP_Form_Post"] == "FormTablesEdit" ) {
        $table = $wpdb->prefix."apt_tables";
        $where = array( 'id' => $_POST["ID"] );

        $update = array(
            'name' => $_POST["Name"],
        );

        $wpdb->update($table,$update,$where);



		header("Location: ?page=APT-Tables&acton=List");
		exit();

	}

	if( $_POST["AP_Form_Post"] == "FormWebshopEdit") {
        $table = $wpdb->prefix."apt_webshops";
        $where = array( 'id' =>$_POST["ID"]);

        $update = array(
        	'shop_name' => $_POST["ShopName"],
    		'site_url' => $_POST["SiteUrl"],
    		'affiliate_id' => $_POST["AffiliateID"],
    		'program_id' => $_POST["ProgramID"],
    		'shipping' => $_POST["Shipping"],
    		'currency' => $_POST["Currency"],

    		'crawl_from1' => str_replace("&quot;","\"",$_POST["CrawlFrom1"]),
    		'crawl_to1' => str_replace("&quot;","\"",$_POST["CrawlTo1"]),

            'crawl_from2' => str_replace("&quot;","\"",$_POST["CrawlFrom2"]),
            'crawl_to2' => str_replace("&quot;","\"",$_POST["CrawlTo2"])
        );

        $wpdb->update($table,$update,$where);

		header("Location: ?page=APT-Webshops&acton=List");
		exit();
	}

    if( $_POST["AP_Form_Post"] == "FormTablesPrices" ) {

        echo "Form posted<br>";
        $table = $wpdb->prefix."apt_prices";

        $TableID = $_POST["ID"];

        $ShopList = $_POST["ShopList"];

        foreach( $ShopList as $row ) {

            #echo "<pre>";
			#print_r($row);
			#echo "</pre>";


            if( $row["ProductUrl"] != "" ) {

								// Check if http is added to the url.
								if( substr($row["ProductUrl"],0,4) != "http" ) {
									$row["ProductUrl"] = "http://".$row["ProductUrl"];
								}

                $sql2 = "SELECT * FROM `".$wpdb->prefix."apt_webshops` WHERE `id` = '".$row["WebshopID"]."';";
                $result2 = $wpdb->get_results($sql2);
                foreach( $result2 as $row2 ) {
                    $crawl_from1 = stripslashes($row2->crawl_from1);
                    $crawl_to1 = stripslashes($row2->crawl_to1);
                    $crawl_from2 = stripslashes($row2->crawl_from2);
                    $crawl_to2 = stripslashes($row2->crawl_to2);
                }




                require_once"Crawler.php";

                $sql = "SELECT * FROM `".$table."` WHERE `table_id` = ".$TableID." AND `webshop_id` = ".$row["WebshopID"].";";
                $result = $wpdb->get_results($sql);


                // Tjekker om linien findes.
                if( empty($result) ) {

                    // Linien findes ikke, der skal laves en insert


                    // Tjek om prisen er sat, hvis ikke hent den.
                    if( empty( $row["Price"] ) ) {
                        $price = AP_Crawler( $row["ProductUrl"] , $crawl_from1 , $crawl_to1, $crawl_from2 , $crawl_to2 );
                    } else {
                        $price = $row["Price"];
                    }

                    $insert = array(
                        'webshop_id' => $row["WebshopID"],
                        'table_id' => $TableID,
                        'product_url' => $row["ProductUrl"],
                        'price' => $price,
                        'last_updated' => date('Y-m-d H:i:s'),
                        'added' => date('Y-m-d H:i:s')
                    );

                    $wpdb->insert($table,$insert);

                    unset($insert);

                } else {

                    // linien findes, der skal laves en update

                    // Tjek om prisen er sat, hvis ikke hent den.
                    if( empty( $row["Price"] ) ) {
                        $price = AP_Crawler( $row["ProductUrl"] , $crawl_from1 , $crawl_to1, $crawl_from2 , $crawl_to2 );
                    } else {
                        $price = $row["Price"];
                    }



                    $where = array(
                        'webshop_id' => $row["WebshopID"],
                        'table_id' => $TableID
                    );


                    $update = array(
                        'product_url' => $row["ProductUrl"],
                        'price' => $price
                    );
                    $wpdb->update($table,$update,$where);
                    unset($where);
                    unset($update);

                }
            } else {

                // Sletter en webshop, da den ikke bruges.
                $where = array( 'webshop_id' => $row["WebshopID"] , 'table_id' => $TableID );
                $wpdb->delete($table,$where);


            }

        }



        header("Location: ?page=APT-Tables&acton=Prices");
    }

	if( $_POST["AP_Form_Post"] == "FormAffiliateAdd" ) {

        $table = $prefix."apt_affiliates";
        $insert = array(
            'name' => $_POST["Name"],
            'url' => $_POST["URL"],
            'partner_id' => $_POST["PartnerID"]
        );

        $wpdb->insert($table,$insert);

		header("Location: ?page=APT-Affiliate&acton=List");
		exit();

	}


	if( $_POST["AP_Form_Post"] == "FormAffiliateEdit" ) {
        $table = $wpdb->prefix."apt_affiliates";
        $where = array( 'id' => $_POST["ID"] );

        $update = array(
            'name' => $_POST["Name"],
            'url' => $_POST["URL"],
            'partner_id' => $_POST["PartnerID"]
        );

        $wpdb->update($table,$update,$where);



		header("Location: ?page=APT-Affiliate&acton=List");
		exit();

	}

	if( $_POST["AP_Form_Post"] == "APTStyling" ) {

		echo "<pre>";
		print_r($_POST);
		echo "</pre>";


		$filepath = plugin_dir_path( __FILE__ )."css/style.css";
		$content = $_POST["css_style"];

		file_put_contents($filepath,$content);

		header("Location: ?page=APT-Style");
		exit;
	}




}

?>
