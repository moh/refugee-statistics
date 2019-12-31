<?php
function creat_element($doc, $ele_name, $attr_names, $values){
	$ele = $doc->createElement($ele_name);
	for($x=0;$x<sizeOf($attr_names);$x++){
    	$ele->setAttribute($attr_names[$x],$values[$x]);
    
    }
	return $ele;
}
?>