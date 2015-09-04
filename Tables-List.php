<?php
function my_row_actions($id=0) {

	$page = "?page=APT-Tables";


	$out = "<div class=\"row-actions\">
	<a href=\"".$page."&action=Edit&ID=".$id."\">Edit</a> |
	<a href=\"".$page."&action=Delete&ID=".$id."\">Delete</a> |
    <a href=\"".$page."&action=Prices&ID=".$id."\">Prices</a> |
    <a href=\"".$page."&action=PriceUpdater&ID=".$id."\">Update Prices</a>
	</div>";

	return $out;
}


global $wpdb;
$prefix = $wpdb->prefix;
?>
<div class="wrap">
	<h2>Price Tables <a href="?page=APT-Tables&action=Add" class="add-new-h2">Add</a></h2>

	<table class="wp-list-table widefat fixed posts" cellspacing="0">
		<thead>
			<tr>
				<th>Name</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>Name</th>
			</tr>
		</tfoot>


		<tbody>

		<?php
			$sql = "SELECT * FROM `".$prefix."apt_tables` ORDER BY `name`;";
            $result = $wpdb->get_results($sql);

            foreach( $result as $row ) {
                if( $alternate == true ) {
					echo "<tr class='alternate'>";
					$alternate = false;
				} else {
					echo "<tr>";
					$alternate = true;
				}

                echo "<td><a href='?page=APT-Tables&action=Prices&ID=".$row->id."'>".$row->name."</a>".my_row_actions($row->id)."</td>";
                echo "</tr>";
            }

			?>
		</tbody>
	</table>

</div>
