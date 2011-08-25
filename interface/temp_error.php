<?php

require_once('config.php'); 

$style = VJ_CONTENT_STYLE; 

?>

<div style="text-align: center; color: red; <?php echo $style; ?>"><?php echo $_GET['errmsg']; ?></div>
