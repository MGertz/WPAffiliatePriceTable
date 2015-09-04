<?php
function my_row_actions($PriceID=0,$TableID=0) {

	$page = "?page=APT-Prices";


	$out  = "<div class=\"row-actions\">";
	$out .= "<a href=\"?page=APT-Tables&action=Prices&ID=".$TableID."\">Edit Table</a> | ";
	$out .= "<a href=\"".$page."&action=Delete&ID=".$PriceID."\">Delete</a> | ";
    $out .= "<a href=\"".$page."&action=PriceUpdater&ID=".$PriceID."\">Update Price</a>";
	$out .= "</div>";

	return $out;
}



global $wpdb;
$prefix = $wpdb->prefix;


$sql = "SELECT * FROM `".$prefix."apt_tables`";
$result = $wpdb->get_results($sql);
foreach( $result as $row ) {
	$tables[$row->id] = $row->name;
}

$sql = "SELECT * FROM `".$prefix."apt_webshops`";
$result = $wpdb->get_results($sql);
foreach( $result  as $row ) {
	$webshops[$row->id] = $row->shop_name;
}


$sql = "SELECT * FROM `".$prefix."apt_prices` ORDER BY `added`";
$result = $wpdb->get_results($sql);
foreach( $result as $row ) {
	$prices[$row->id] = array(
		"WebshopID" => $row->webshop_id,
		"TableID" => $row->table_id,
		"LastUpdated" => $row->last_updated,
		"Price" => $row->price
	);
}



?>
<div class="wrap">
	<h2>Price List</h2>

	<form action="?page=APT-Prices&action=Update" method="post">

				<?
				/*

		<ul class='subsubsub'>
			<li class='all'><a href='edit.php?post_type=post'>All <span class="count">(<? echo count($prices); ?>)</span></a> |</li>
		</ul>

		<div class="tablenav top">

			<div class="alignleft actions bulkactions">
				<label for='bulk-action-selector-top' class='screen-reader-text'>Select bulk action</label>
				<select name='action' id='bulk-action-selector-top'>
					<option value='' selected='selected'>Select Action</option>
					<option value='trash'>Delete</option>
					<option value='update'>Update Prices</option>
				</select>
				<input type="submit" name="" id="doaction1" class="button action" value="Apply"  />
			</div>



			<br class="clear" />
		</div>
		*/
		?>



		<table class="wp-list-table widefat fixed posts" cellspacing="0">
			<thead>
				<tr>
					<?
					/*
					<th scope="col" id="cb" class="manage-column column-cb check-column">
						<label class="screen-reader-text" for="cb-select-all-1">Select All</label>
						<input id="cb-select-all-1" type="checkbox">
					</th>
					*/
					?>
					<th>Webshop Name</th>
					<th>Table</th>
					<th>Last Updated</th>
					<th>Price</th>
				</tr>
			</thead>


			<tfoot>
				<tr>
					<?
					/*
					<th scope="col" id="cb" class="manage-column column-cb check-column">
						<label class="screen-reader-text" for="cb-select-all-2">Select All</label>
						<input id="cb-select-all-2" type="checkbox">
					</th>
					*/
					?>
					<th>Webshop Name</th>
					<th>Table</th>
					<th>Last Updated</th>
					<th>Price</th>
				</tr>
			</tfoot>
			<tbody>
				<?
					$sql = "SELECT * FROM `".$prefix."apt_prices` ORDER BY `Added`";
					$result = $wpdb->get_results($sql);
					foreach( $result as $row ) {

						if( $alternate == true ) {
							echo "<tr class='alternate'>";
							$alternate = false;
						} else {
							echo "<tr>";
							$alternate = true;
						}



						#echo "<th scope='row' class='check-column'><input type='checkbox' name='Prices[".$row->id."][Selected]' value='true'></th>";

						echo "<td>".$webshops[$row->webshop_id].my_row_actions($row->id,$row->table_id)."</td>";
						echo "<td>".$tables[$row->table_id]."</td>";
						echo "<td>".$row->last_updated."</td>";
						echo "<td>".$row->price."</td>";

						echo "</tr>";

						echo "<input type='hidden' name='Prices[".$row->id."][PriceID]' value='".$row->id."'>";
						echo "<input type='hidden' name='Prices[".$row->id."][WebshopID]' value='".$row->webshop_id."'>";
						echo "<input type='hidden' name='Prices[".$row->id."][TableID]' value='".$row->table_id."'>";


					}
				?>
			</tbody>
		</table>

	</form>

</div>
