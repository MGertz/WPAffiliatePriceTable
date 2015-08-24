<?php
global $wpdb;
?>
<div class="wrap">
	<h2>Add Webshop</h2>

	<div class="Left">
		<form method="post">
		<input type="hidden" name="AP_Form_Post" value="FormWebshopAdd"> <? // denne variabel bruges til at tjekke at post kommer fra dette plugin ?>

		<table class="form-table">
			<tbody>
				<tr class="form-field form-required">
					<th scope="row">
						<label for="ShopName">Shop Name <span class="description">(required)</span></label>
					</th>
					<td>
						<input name="ShopName" type="text" id="ShopName" value="" aria-required="true" style="width: 350px;">
					</td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row">
						<label for="SiteUrl">Site URL <span class="description">(required)</span></label>
					</th>
					<td>
						<input name="SiteUrl" type="text" id="SiteUrl" value="" aria-required="true" style="width: 350px;">
					</td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row">
						<label for="AffiliateID">Affiliate <span class="description">(required)</span></label>
					</th>
					<td>
						<select name="AffiliateID" style="width: 350px;">
                            <option value="0" disabled selected>-- SELECT AFFILIATE NETWORK --</option>
							<?php
								$sql = "SELECT * FROM `".$wpdb->prefix."ap_affiliates` ORDER BY `Name`";
                                $result = $wpdb->get_results($sql);

                                foreach( $result as $row ) {
                                    echo "<option value='".$row->id."'>";
                                    echo $row->name;

                                    echo "</option>";
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
						<label for="CrawlFrom">Crawl From <span class="description">(required)</span></label>
					</th>
					<td>
						<input name="CrawlFrom" type="text" id="CrawlFrom" value="<? echo $CrawlFrom; ?>" aria-required="true" style="width: 350px;">
					</td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row">
						<label for="CrawlTo">Crawl To <span class="description">(required)</span></label>
					</th>
					<td>
						<input name="CrawlTo" type="text" id="CrawlTo" value="<? echo $CrawlTo; ?>" aria-required="true" style="width: 350px;">
					</td>
				</tr>
			</tbody>
		</table>

		<p class="submit">
			<input type="submit" name="addwebshop" id="addwebshopsub" class="button button-primary" value="Create">
		</p>

		</form>




	</div>
</div>
