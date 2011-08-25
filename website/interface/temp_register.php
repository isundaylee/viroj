<?php

require_once('config.php'); 

?>
<form style="text-align: center; margin: auto; width: <?php echo VJ_SUBFRAME_WIDTH; ?>; " action='proc_register.php' method='post'>
  <?php
     $style = VJ_CONTENT_STYLE; 
     if ($_GET['errmsg'] != '')
     {
          $code = '<div style="' . $style . 'color: red; ' . '">'; 
          $code = $code . 'Error: ' . $_GET['errmsg']; 
          $code = $code . '</div>';
          echo $code; 
     }
  ?>
  <p>Username: <input style="<?php echo $style; ?>" type="text" name="username" /></p>
  <p>Password: <input style="<?php echo $style; ?>" type="password" name="password" /> </p>
  <p><input type="submit" value="Register" /></p>
</form>