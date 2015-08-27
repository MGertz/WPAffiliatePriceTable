<?php


$css = file_get_contents(plugin_dir_path( __FILE__ )."css/style.css");

?>
<div class="wrap">
  <h2>Change style of the Price table </h2>

  <form action="" method="post">
    <input type="hidden" name="AP_Form_Post" Value="APTStyling">

    <textarea style="width: 80%; height: 400px;" name="css_style"><? echo $css; ?></textarea>


    <p class="submit">
			<input type="submit" class="button button-primary" value="Save">
		</p>




</div>





















<?php
/*
denne kode burde kunne læse en css file
$css = <<<CSS
#selector { display:block; width:100px; }
#selector a { float:left; text-decoration:none }
CSS;

//
function BreakCSS($css)
{

    $results = array();

    preg_match_all('/(.+?)\s?\{\s?(.+?)\s?\}/', $css, $matches);
    foreach($matches[0] AS $i=>$original)
        foreach(explode(';', $matches[2][$i]) AS $attr)
            if (strlen(trim($attr)) > 0) // for missing semicolon on last element, which is legal
            {
                list($name, $value) = explode(':', $attr);
                $results[$matches[1][$i]][trim($name)] = trim($value);
            }
    return $results;
}
var_dump(BreakCSS($css));

*/
