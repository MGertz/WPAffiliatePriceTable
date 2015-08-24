<div class="wrap">
	<h2>Add Affiliate Network</h2>

	<div class="Left">
		<form method="post">
		<input type="hidden" name="AP_Form_Post" value="FormAffiliateAdd"> <? // denne variabel bruges til at tjekke at post kommer fra dette plugin ?>

		<table class="form-table">
			<tbody>
				<tr class="form-field form-required">
					<th scope="row">
						<label for="Name">Navn <span class="description">(required)</span></label>
					</th>
					<td>
						<input name="Name" type="text" id="Name" value="" aria-required="true" style="width: 350px;">
					</td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row">
						<label for="PartnerID">PartnerID <span class="description">(required)</span></label>
					</th>
					<td>
						<input name="PartnerID" type="text" id="PartnerID" value="" aria-required="true" style="width: 350px;">
					</td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row">
						<label for="URL">Affiliate URL <span class="description">(required)</span></label>
					</th>
					<td>
						<input name="URL" type="text" id="URL" value="" aria-required="true" style="width: 350px;">
					</td>
				</tr>
			</tbody>
		</table>

		<p class="submit">
			<input type="submit" class="button button-primary" value="Create">
		</p>

		</form>
	</div>
</div>
