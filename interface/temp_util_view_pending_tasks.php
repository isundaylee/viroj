<?php

require_once('config.php');
require_once(VJ_CORE); 

$tasks = vj_get_pending_tasks();

$width = VJ_SUBFRAME_WIDTH;
$style = VJ_CONTENT_STYLE; 

echo "<div style='$style; text-align: center; margin: auto; width: $width; '>"; 

foreach ($tasks as $i)
{
     echo "$i <br />"; 
}

echo "</div>";

?>