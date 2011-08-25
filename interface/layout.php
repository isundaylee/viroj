<?php

require_once('config.php'); 
require_once(VJ_CORE); 

$width = VJ_PAGE_WIDTH; 

?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="style/layout.css" />
    <title><?php echo 'VIROJ - ' . $TITLE . ' (' . vj_get_filtered_username() . ')'; ?></title>
  </head>
  
  <body>
    <div style="margin: auto; width: <?php echo $width; ?>; ">
    <hr />
    <div class="mtitle">Welcome to VIROJ</div>
    <div class="subtitle">An open-source Online Judge system for all OIers. </div>
    <hr />
    <?php include('navibar.php'); ?>
    <hr />
    <?php include($CONTENT); ?>
    <hr style="clear: both; "/>
    <div class="maintainer">Maintainer: Sunday & Vani</div> 
    </div>
  </body>
</html>
