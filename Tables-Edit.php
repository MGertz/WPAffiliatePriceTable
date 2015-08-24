<?php

global $wpdb;

$sql = "SELECT * FROM `".$wpdb->prefix."ap_tables` WHERE `id` = '".$_GET["ID"]."';";

$result = $wpdb->get_results($sql);

foreach( $result as $row ) {
    $Name = $row->name;
    $ID = $row->id;
}
?>
<div class="wrap">
	<h2>Price Table Edit</h2>

    <div class="Left">
		<form method="post">
		<input type="hidden" name="AP_Form_Post" value="FormTablesEdit"> <? // denne variabel bruges til at tjekke at post kommer fra dette plugin ?>
        <input type="hidden" name="ID" value="<?php echo $ID; ?>">

		<table class="form-table">
			<tbody>
				<tr class="form-field form-required">
					<th scope="row">
						<label for="Name">Shop Name <span class="description">(required)</span></label>
					</th>
					<td>
						<input name="Name" type="text" id="Name" value="<?php echo $Name; ?>" aria-required="true" style="width: 350px;">
					</td>
				</tr>
			</tbody>
		</table>

		<p class="submit">
			<span class="spinner"></span>
			<input type="submit" name="publish" id="publish" class="button button-primary button-large" value="Save">
		</p>

		</form>
	</div>
</div>
