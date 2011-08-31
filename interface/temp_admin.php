<?php

require_once('config.php'); 
require_once(VJ_CORE); 

include('admin_validate.php');

$width = VJ_SUBFRAME_WIDTH; 
$style = VJ_CONTENT_STYLE; 
$ssstyle = VJ_SECTIONTITLE_STYLE; 

?>

<div style="margin: auto; <?php echo $style; ?>; width: <?php echo $width; ?>">

<div style="<?php echo $ssstyle; ?>; text-align: left; ">View Pending Tasks</div>

<div>
&nbsp; <br />
<a href="util_view_pending_tasks.php">Click Here</a>
</div>

&nbsp; <br />

<div style="<?php echo $ssstyle; ?>; text-align: left; ">Remove Task</div>

<div>
&nbsp; <br />
<form action="proc_util_remove_task.php" method="get">
  TID: <input type="text" name="tid" />
  <input type="submit" value="Remove" />
</form>
</div>

<?php

?>

</div>