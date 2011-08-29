<?php

require_once('config.php'); 
require_once(VJ_CORE); 

$uid = vj_get_filtered_uid(); 
if ($uid == 0) $uid = -1; 

if ($_GET['sid'] == '') $s = 1; 
else $s = $_GET['sid']; 

$submit = vj_get_submit_detail_by_sid($s); 

if ($submit['uid'] != $uid) 
{
     vj_error('Permission denied. '); 
     return; 
}

$style=VJ_CODE_STYLE; 
$width = VJ_SUBFRAME_WIDTH; 

echo "<div style='margin: auto; width: $width; '>"; 

echo "<div style='$style'>"; 

echo vj_get_sourcecode_classic_by_sid($s); 

echo "</div>";

echo "</div>";

?>