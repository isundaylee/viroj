<?php

require_once('config.php');
require_once(VJ_CORE);

include('admin_validate.php'); 

$tasks = vj_get_pending_tasks();

$width = VJ_SUBFRAME_WIDTH;
$style = VJ_CONTENT_STYLE; 

echo "<div style='$style; text-align: center; margin: auto; width: $width; '>"; 

$W1 = 100; 
$W2 = 500; 
$W3 = 400; 

?>

<table>
<tr>
<th style="<?php echo $style; ?>;" width="<?php echo $W1; ?>">A</th>
<th style="<?php echo $style; ?>;" width="<?php echo $W2; ?>">B</th>
<th style="<?php echo $style; ?>;" width="<?php echo $W3; ?>">C</th>
</tr>

<?php

foreach ($tasks as $i)
{
     echo "<tr><td style='$style; text-align: center; '>"; 
     echo $i['name'];
     echo "</td><td style='$style; text-align: center; '>"; 
     echo $i['title']; 
     echo "</td><td style='$style; text-align: center; '>"; 
     if (vj_validate_pending_task($i['ptid']))
     {
          $ptid = $i['ptid']; 
          echo "<a href='proc_util_accept_pending_task.php?ptid=$ptid'>Accept</a>"; 
          echo "&nbsp; "; 
          echo "<a href='proc_util_decline_pending_task.php?ptid=$ptid'>Decline</a>"; 
     }
     else echo "Validation failed. "; 
     echo "</td></tr>"; 
}

echo "</table>"; 
echo "</div>";

?>