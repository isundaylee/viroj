<?php

require_once('config.php'); 

?>

<form style="margin: auto; width: 600px; text-align: center; " action="proc_login.php" method="post">
  <?php
      $style = VJ_CONTENT_STYLE; 
      if ($_GET['errmsg'] != '')
      {
           $code = '<div style="color: red; ' . $style . '">'; 
           $code = $code . 'Error: ' . $_GET['errmsg']; 
           $code = $code . '</div>'; 
           echo $code; 
      }
  ?>
  <p>Username: <input style="<?php echo $style; ?>" type="text" name="username" /></p>
  <p>Password: <input style="<?php echo $style; ?>" type="password" name="password" /></p>
  <input type="submit" value="Login" />
</form>
