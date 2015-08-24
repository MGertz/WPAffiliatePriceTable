<div class="wrap">
	<h2>Add new pricetable</h2>

	<p>Create a new table.</p>

	<div class="Left">
		<form method="post">
		<input type="hidden" name="AP_Form_Post" value="FormTablesAdd"> <? // denne variabel bruges til at tjekke at post kommer fra dette plugin ?>

		<table class="form-table">
			<tbody>
				<tr class="form-field form-required">
					<th scope="row">
						<label for="Name">Table Name <span class="description">(required)</span></label>
					</th>
					<td>
						<input name="Name" type="text" id="Name" value="" aria-required="true" style="width: 350px;">
					</td>
				</tr>
			</tbody>
		</table>

		<p class="submit">
			<span class="spinner"></span>
			<input type="submit" name="publish" id="publish" class="button button-primary button-large" value="Create">
		</p>

		</form>
	</div>
</div>
