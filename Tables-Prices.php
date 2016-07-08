<?php
global $wpdb;


// Hent informationer om denne tabel
$sql = "SELECT * FROM `".$wpdb->prefix."apt_tables` WHERE `id` = '".$_GET["ID"]."';";
$result = $wpdb->get_results($sql);
foreach( $result as $row )  {
	$TableName = $row->name;
	$ID = $row->id;
}

// Hent alle affiliate netværk og gem dem i et array
$sql = "SELECT * FROM `".$wpdb->prefix."apt_affiliates`";
$result = $wpdb->get_results($sql);

foreach( $result as $row ) {
	$affiliates[$row->id] = $row->name;
}

?>
<div class="wrap">
	<h2>Prices for:  <? echo $TableName; ?></h2>

	<div class="Left">
		<form method="post">
			<input type="hidden" name="AP_Form_Post" value="FormTablesPrices"> <? // denne variabel bruges til at tjekke at post kommer fra dette plugin ?>
			<input type="hidden" name="ID" value="<?php echo $ID; ?>">

			<table class="wp-list-table widefat fixed posts" cellspacing="0">
				<thead>
					<tr>
						<!-- <th class="manage-column column-cb check-column"></th> -->
						<th style="width: 15%;">Webshop Name</th>
						<th style="width: 15%;">Affiliate Network</th>
						<th>Product Link</th>
						<th style="width: 90px;">Price</th>
						<th style="width: 123px;">Last Updated</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<!-- <th class="manage-column column-cb check-column"></th> -->
						<th>Webshop Name</th>
						<th>Affiliate Network</th>
						<th>Product Link</th>
						<th>Price</th>
						<th>Last Updated</th>
					</tr>
				</tfoot>



				<tbody>

					<?php
					$sql = "SELECT * FROM `".$wpdb->prefix."apt_webshops` ORDER BY `shop_name`;";
					$result = $wpdb->get_results($sql);

					$alternate = true;

					$ShopLine = 0;

					foreach( $result as $row ) {
						echo "<input type='hidden' name='ShopList[".$ShopLine."][WebshopID]' value='".$row->id."'>";

						$sql2 = "SELECT * FROM `".$wpdb->prefix."apt_prices` WHERE `webshop_id` = ".$row->id." AND `table_id` = ".$ID.""; // $ID hentes i toppen af scriptet

						$result2 = $wpdb->get_results($sql2);

						if( $wpdb->num_rows == 1 ) {
							foreach( $result2 as $row2 ) {
								$ProductUrl = $row2->product_url;
								$Price = $row2->price;
								$last_updated = $row2->last_updated;
							}
							$Active = "True";
						} else {
							$ProductUrl = "";
							$Price = "";
							$last_updated = "";
							$Active = "False";
						}




						if( $alternate == true ) {
							echo "<tr class='alternate'>";
							$alternate = false;
						} else {
							echo "<tr>";
							$alternate = true;
						}

							#echo "<td><input type='checkbox' name='ShopList[".$ShopLine."][Active]' value='true'";
							#if( $Active == "True" ) {
							#	echo " checked";
							#}
							#echo "></td>";


							echo "<td><a href='http://".$row->site_url."' target='_blank'>".$row->shop_name."</a></td>";
							echo "<td>".$affiliates[$row->affiliate_id]."</td>";
							echo "<td><input type='text' name='ShopList[".$ShopLine."][ProductUrl]' value='".$ProductUrl."' style='width: 100%;'></td>";
							echo "<td><input type='text' name='ShopList[".$ShopLine."][Price]' value='".$Price."' style='width: 100%;'></td>";
							echo "<td>".$last_updated."</td>";

						echo "</tr>";
						$ShopLine++;

						}

						?>
				</tbody>
				</table>

			<p class="submit">
				<span class="spinner"></span>
				<input type="submit" name="publish" id="publish" class="button button-primary button-large" value="Update Table">
			</p>

		</form>

		<p><b>Info:</b> To insert this table on a post, please use the following text<br>[apt id=<?php echo $_GET["ID"]; ?>]<br>
	</div>
</div>
