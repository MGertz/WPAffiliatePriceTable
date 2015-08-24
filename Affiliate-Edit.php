<?php

$ID = $_GET["ID"];

global $wpdb;

$sql = "SELECT * FROM `".$wpdb->prefix."ap_affiliates` WHERE `id` = '".$ID."';";
$result = $wpdb->get_results($sql);
foreach( $result as $row ) {
	$Name = $row->name;
	$URL = $row->url;
	$PartnerID = $row->partner_id;
	
}
?><div class="wrap">
	<h2>Rediger Affiliate Netværk</h2>

	<div class="Left">
		<form method="post">
		<input type="hidden" name="AP_Form_Post" value="FormAffiliateEdit"> <? // denne variabel bruges til at tjekke at post kommer fra dette plugin ?>
		<input type="hidden" name="ID" value="<?php echo $ID; ?>">

		<table class="form-table">
			<tbody>
				<tr class="form-field form-required">
					<th scope="row">
						<label for="Name">Navn <span class="description">(påkrævet)</span></label>
					</th>
					<td>
						<input name="Name" type="text" id="Name" value="<?php echo $Name; ?>" aria-required="true" style="width: 350px;">
					</td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row">
						<label for="PartnerID">PartnerID <span class="description">(påkrævet)</span></label>
					</th>
					<td>
						<input name="PartnerID" type="text" id="PartnerID" value="<?php echo $PartnerID; ?>" aria-required="true" style="width: 350px;">
					</td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row">
						<label for="URL">Affiliate Link <span class="description">(påkrævet)</span></label>
					</th>
					<td>
						<input name="URL" type="text" id="URL" value="<?php echo $URL; ?>" aria-required="true" style="width: 350px;">
					</td>
				</tr>
			</tbody>
		</table>

		<p class="submit">
			<input type="submit" class="button button-primary" value="Rediger Affiliate Netværk">
		</p>

		</form>
	</div>
</div>