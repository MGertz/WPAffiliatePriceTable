<?php
function my_row_actions($id=0) {

	$page = "?page=APT-Affiliate";


	$out = "<div class=\"row-actions\">
	<a href=\"".$page."&action=Edit&ID=".$id."\">Edit</a> |
	<a href=\"".$page."&action=Delete&ID=".$id."\">Delete</a>
	</div>";

	return $out;
}

global $wpdb;
$prefix = $wpdb->prefix;
?>
<div class="wrap">
	<h2>Affiliate Network <a href="?page=APT-Affiliate&action=Add" class="add-new-h2">Add</a></h2>

	<table class="wp-list-table widefat fixed posts" cellspacing="0">
		<thead>
			<tr>
				<th>Network Name</th>
				<th>Partner ID</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>Network Name</th>
				<th>Partner ID</th>
			</tr>
		</tfoot>


		<tbody>

		<?php
			$sql = "SELECT * FROM `".$prefix."ap_affiliates` ORDER BY `name`;";
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

				echo "<td>".$row->name."".my_row_actions($row->id)."</td>";
				echo "<td>".$row->partner_id."</td>";
				echo "</tr>";
			}
			?>
		</tbody>
	</table>

</div>
