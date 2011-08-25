<?php

require_once('config.php'); 
require_once(VJ_CORE);

if ($_GET['tid'] == '') $tid = 1; 
else $tid = $_GET['tid']; 
$width = VJ_SUBFRAME_WIDTH; 

?>

<div style="text-align: center; margin:auto; width: <?php echo $width; ?>; ">
<form action="proc_submit_classic.php" method="post">
  <select name="codetype">
  <?php
     $list = vj_get_source_types(); 
     foreach ($list as $i => $j)
     {
          echo '<option value="' . $i . '">' . $j . '</option>'; 
     }
  ?>
  </select>
  <textarea rows="50" cols="80" name="code"></textarea>
  <br />
  <input type="submit" />
</form>
</div>