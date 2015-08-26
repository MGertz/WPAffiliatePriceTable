<?php

/*
_________
\_____   \
   /   __/
  |   |
  |___|
  <___>

// IF THE META BOX NEEDS TO BE ENABLED LATER, THEN THE LINE BELOW NEEDS TO BE MOVED INTO AffiliatePriceTable.php file

// Include file with Meta Box for edit post
#require_once"AP_Meta_Box.php";

*/

// Sørg for at meta boksene kun loades på post edit/new siden
add_action('load-post.php','AP_Meta_Box_Setup');
add_action('load-post-new.php','AP_Meta_Box_Setup');

// functionen som kaldes for at add boksene.
function AP_Meta_Box_Setup() {
	add_action('add_meta_boxes','AP_Meta_Box_Add');

	//add_action( 'save_post', 'AP_Meta_Box_Save', 10, 2 );
	add_action( 'save_post', 'AP_Meta_Box_Save', 10, 2 );
}

// Boks setup funktionen.
function AP_Meta_Box_Add() {
	add_meta_box(
		'AP_Meta_Box',
		'Affiliate Plugin',
		'AP_Meta_Box_Content',
		'post',
		'side',
		'default'
	);
}


// Content til boksen

function AP_Meta_Box_Content($object,$box) {

	global $wpdb;
	$prefix = $wpdb->prefix;
	$postID = get_the_ID();

	$sql = "SELECT * FROM `".$prefix."ap_tables` ORDER BY `name`";
    $result = $wpdb->get_results($sql);

    foreach( $result as $row ) {

		$tables[$row->id] = $row->name;
	}



	$sql = "SELECT * FROM `".$prefix."ap_tables_posts` WHERE `post_id` = '".$postID."'";
    $result = $wpdb->get_results($sql);
    foreach( $result as $row ) {
        $table_id = $row->table_id;
    }

	// Hent info om hvilke tables der er valgt.

	echo "<ul>";
	foreach( $tables as $key => $val ) {
		echo "<li id='table-".$key."'>";
		echo "<label class='selectit'><input type='checkbox' value='".$key."' name='post_tables[]' id='in-tables-".$key."'";

		if( $table_id == $key ) {
			echo " checked='checked'";
		}

		echo ">".$val." (".$key.")</label></li>";
		echo "</li>";
	}
	echo "</ul>";

}


/*
 * Funktionen her gemmer indholdet i metaboxen fra new/edit post siden
 */
function AP_Meta_Box_Save($postid,$post) {

	global $wpdb;
	$prefix = $wpdb->prefix;
	$table = $prefix."ap_tables_posts";

	// først slet alle tables der er bundet op på denne post
    $where = array('post_id'=>$postid);
    $wpdb->delete($table,$where);



	if( isset($_POST["post_tables"]) ) {
		$post_tables = $_POST["post_tables"];


		// indsæt så de posts som der skal bruges.
		$rows = count($post_tables);

        foreach( $post_tables as $row ) {
            $insert = array(
                'post_id' => $postid,
                'table_id' => $row
            );
            $wpdb->insert($table,$insert);

        }

	}


}


?>
