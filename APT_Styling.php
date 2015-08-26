<?php




?>
<div class="wrap">
  <h2>Change style of the Price table </h2>

  <form action="" method="post">
    <input type="hidden" name="FormName" Value="APTStyling">


  <h3>Outer</h3>



</div>






















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
