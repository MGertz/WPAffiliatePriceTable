<div class="wrap">
	<h2>Tilføj Affiliate Netværk</h2>

	<p>Opret en ny tabel, som priserne kan bindes op på</p>

	<div class="Left">
		<form method="post">
		<input type="hidden" name="AP_Form_Post" value="FormAffiliateAdd"> <? // denne variabel bruges til at tjekke at post kommer fra dette plugin ?>

		<table class="form-table">
			<tbody>
				<tr class="form-field form-required">
					<th scope="row">
						<label for="Name">Navn <span class="description">(påkrævet)</span></label>
					</th>
					<td>
						<input name="Name" type="text" id="Name" value="" aria-required="true" style="width: 350px;">
					</td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row">
						<label for="PartnerID">PartnerID <span class="description">(påkrævet)</span></label>
					</th>
					<td>
						<input name="PartnerID" type="text" id="PartnerID" value="" aria-required="true" style="width: 350px;">
					</td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row">
						<label for="URL">Affiliate Link <span class="description">(påkrævet)</span></label>
					</th>
					<td>
						<input name="URL" type="text" id="URL" value="" aria-required="true" style="width: 350px;">
					</td>
				</tr>
			</tbody>
		</table>

		<p class="submit">
			<input type="submit" class="button button-primary" value="Tilføj ny Affiliate">
		</p>

		</form>
	</div>
</div>