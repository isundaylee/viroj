<?php

require_once('config.php'); 
require_once(VJ_CORE); 

if ($_GET['sid'] == '') $sid = 1; 
else $sid = $_GET['sid']; 

$style = VJ_CONTENT_STYLE;
$width = VJ_SUBFRAME_WIDTH;

?>

<div style="margin: auto; width: <?php echo $width; ?>; ">

<div style="<?php echo $style; ?>">

<?php echo vj_get_ce_detail_classic_by_sid($sid); ?>

</div>

</div>