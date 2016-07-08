<?php

$ID = $_GET["ID"];

global $wpdb;

$sql = "SELECT * FROM `".$wpdb->prefix."apt_webshops` WHERE `id` = '".$ID."';";
$result = $wpdb->get_results($sql);

foreach( $result as $row ) {
	$ShopName = $row->shop_name;
	$SiteUrl = $row->site_url;
	$AffiliateID = $row->affiliate_id;
	$ProgramID = $row->program_id;
	$Shipping = $row->shipping;
	$Currency = $row->currency;
	$CrawlFrom1 = $row->crawl_from1;
	$CrawlFrom1 = str_replace('"',"&quot;",$CrawlFrom1);
    $CrawlFrom1 = stripSlashes($CrawlFrom1);
	$CrawlTo1 = $row->crawl_to1;
	$CrawlTo1 = str_replace("\"","&quot;",$CrawlTo1);
    $CrawlTo1 = stripSlashes($CrawlTo1);
	$CrawlFrom2 = $row->crawl_from2;
	$CrawlFrom2 = str_replace('"',"&quot;",$CrawlFrom2);
    $CrawlFrom2 = stripSlashes($CrawlFrom2);
	$CrawlTo2 = $row->crawl_to2;
	$CrawlTo2 = str_replace("\"","&quot;",$CrawlTo2);
    $CrawlTo2 = stripSlashes($CrawlTo2);
}






?>
<div class="wrap">
	<h2>Edit Webshop</h2>

	<div class="Left">
		<form method="post">
		<input type="hidden" name="AP_Form_Post" value="FormWebshopEdit"> <? // denne variabel bruges til at tjekke at post kommer fra dette plugin ?>
		<input type="hidden" name="ID" value="<?php echo $ID; ?>">

		<table class="form-table">
			<tbody>
				<tr class="form-field form-required">
					<th scope="row">
						<label for="ShopName">Shop Name <span class="description">(required)</span></label>
					</th>
					<td>
						<input name="ShopName" type="text" id="ShopName" value="<? echo $ShopName; ?>" aria-required="true" style="width: 350px;">
					</td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row">
						<label for="SiteUrl">Site URL <span class="description">(required)</span></label>
					</th>
					<td>
						<input name="SiteUrl" type="text" id="SiteUrl" value="<? echo $SiteUrl; ?>" aria-required="true" style="width: 350px;">
					</td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row">
						<label for="AffiliateID">Affiliate <span class="description">(required)</span></label>
					</th>
					<td>
						<select name="AffiliateID" style="width: 350px;">
							<?php
								$sql = "SELECT * FROM `".$wpdb->prefix."apt_affiliates` ORDER BY `Name`";
								$result = $wpdb->get_results($sql);
								foreach( $result as $row ) {
									echo "<option value='".$row->id."'";
									if( $row->id == $AffiliateID ) {
										echo " selected";
									}

									echo ">".$row->name."</option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row">
						<label for="ProgramID">Program ID <span class="description">(required)</span></label>
					</th>
					<td>
						<input name="ProgramID" type="text" id="ProgramID" value="<? echo $ProgramID; ?>" aria-required="true" style="width: 350px;">
					</td>
				</tr>
				<tr class="form-field">
					<th scope="row">
						<label for="Shipping">Shipment</label>
					</th>
					<td>
						<input name="Shipping" type="text" id="Shipping" value="<? echo $Shipping; ?>" aria-required="true" style="width: 350px;">
					</td>
				</tr>
				<tr class="form-field">
					<th scope="row">
						<label for="Currency">Currency</label>
					</th>
					<td>
						<input name="Currency" type="text" id="Currency" value="<? echo $Currency; ?>" aria-required="true" style="width: 350px;">
					</td>
				</tr>



				<tr class="form-field form-required">
					<th scope="row">
						<label for="CrawlFrom">Crawl From Default <span class="description">(required)</span></label>
					</th>
					<td>
						<input name="CrawlFrom1" type="text" id="CrawlFrom1" value="<? echo $CrawlFrom1; ?>" aria-required="true" style="width: 350px;">
					</td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row">
						<label for="CrawlTo">Crawl To Default <span class="description">(required)</span></label>
					</th>
					<td>
						<input name="CrawlTo1" type="text" id="CrawlTo1" value="<? echo $CrawlTo1; ?>" aria-required="true" style="width: 350px;">
					</td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row">
						<label for="CrawlFrom">Crawl From Alternative<span class="description">(required)</span></label>
					</th>
					<td>
						<input name="CrawlFrom2" type="text" id="CrawlFrom2" value="<? echo $CrawlFrom2; ?>" aria-required="true" style="width: 350px;">
					</td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row">
						<label for="CrawlTo">Crawl To Alternative<span class="description">(required)</span></label>
					</th>
					<td>
						<input name="CrawlTo2" type="text" id="CrawlTo2" value="<? echo $CrawlTo2; ?>" aria-required="true" style="width: 350px;">
					</td>
				</tr>




			</tbody>
		</table>

		<p class="submit">
			<input type="submit" name="addwebshop" id="addwebshopsub" class="button button-primary" value="Save">
		</p>

		</form>




	</div>
</div>
