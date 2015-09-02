<?php
function my_row_actions($id=0) {

	$page = "?page=APT-Webshops";


	$out = "<div class=\"row-actions\">
	<a href=\"".$page."&action=Edit&ID=".$id."\">Edit</a> |
	<a href=\"".$page."&action=Delete&ID=".$id."\">Delete</a>
	</div>";

	return $out;
}
global $wpdb;


$sql = "SELECT * FROM `".$wpdb->prefix."apt_affiliates` ORDER BY `Name`";
$result = $wpdb->get_results($sql);
foreach( $result as $row ) {
	$affiliates[$row->id] = $row->name;
}




?>
<div class="wrap">
	<h2>Webshops <a href="?page=APT-Webshops&action=Add" class="add-new-h2">Add</a></h2>


	<p>List of all webshops</p>

	<table class="wp-list-table widefat fixed posts" cellspacing="0">
		<thead>
			<tr>
				<th>Name</th>
				<th>Affiliate Network</th>
				<th>Shipment</th>
				<th>Currency</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>Name</th>
				<th>Affiliate Network</th>
				<th>Shipment</th>
				<th>Currency</th>
			</tr>
		</tfoot>



		<tbody>

		<?php
			$sql = "SELECT * FROM `".$wpdb->prefix."apt_webshops` ORDER BY `shop_name`;";

            $result = $wpdb->get_results($sql);

			$alternate = true;

            foreach( $result as $row ) {

				if( $alternate == true ) {
					echo "<tr class='alternate'>";
					$alternate = false;
				} else {
					echo "<tr>";
					$alternate = true;
				}

				echo "<td>".$row->shop_name." (".$row->program_id.")".my_row_actions($row->id)."</td>";


				echo "<td>".$affiliates[$row->affiliate_id]."</td>";

				echo "<td>".$row->shipping."</td>";
				echo "<td>".$row->currency."</td>";
				echo "</tr>";

			}



		?>


		</tbody>
	</table>

</div>
