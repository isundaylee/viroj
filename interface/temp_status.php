<?php

require_once('config.php'); 
require_once(VJ_CORE); 

function status_error_handler($msg)
{
     vj_error($msg); 
}

vj_collect_results('status_error_handler'); 

if ($_GET['page'] == '') $page = 1; 
else $page = $_GET['page']; 

$lb = ($page - 1) * VJ_STATUS_PER_PAGE + 1; 
$ub = $page * VJ_STATUS_PER_PAGE;
$width = VJ_SUBFRAME_WIDTH; 
$style = VJ_CONTENT_STYLE; 

$submits = vj_get_submits($lb, $ub, 'status_error_handler'); 
$len = $submits[0]; 

$num = vj_get_submits_num('status_error_handler');
$tot_pages = floor(($num - 1) / VJ_STATUS_PER_PAGE) + 1; 

if ($page > $tot_pages)
{
     status_error_handler('Page number out of range. '); 
}

$W1 = '50px'; 
$W2 = '250px'; 
$W3 = '250px'; 
$W4 = '70px';
$W5 = '90px'; 
$W6 = '90px'; 

?>

<div style="margin: auto; width: <?php echo $width; ?>; ">

<?php

     echo '<div style="text-align: center; ' . $style . ';">'; 
     echo 'Total Pages: ' . $tot_pages; 
echo '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Current Page: ' . $page; 
echo '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Total Submits: ' . $num; 
echo '</div>'; 

?>

<hr />

<table style="text-align: center; <?php echo $style; ?>">

<tr>
<th>SID</th>
<th>Title</th>
<th>Status</th>
<th>Case ID</th>
<th>Time</th>
<th>Memory</th>
</tr>

<?php
     for ($i=1; $i<=$len; $i++)
     {
          echo '<tr>';
          echo "<td style='width: $W1; '>";
          echo $submits[$i]; 
          echo '</td>'; 
          echo "<td style='width: $W2; '>";
          $submit = vj_get_submit_detail_by_sid($submits[$i], 'status_error_handler'); 
          $task = vj_get_task_detail_by_tid($submit['tid']); 
          echo '<a href="show_task.php?tid=' . $submit['tid'] . '">'; 
          echo $task['title']; 
          echo '</a>'; 
          echo '</td>';
          echo "<td style='width: $W3; '>";
          if (!vj_is_judged($submits[$i]))
          {
               echo '<div style="color: ' .   VJ_STATUS_COLOR_PENDING . ';">'; 
               echo 'Pending';
               echo '</div>'; 
               echo "</td><td style='width: $W4; '>&nbsp;</td><td style='width: $W5; '>&nbsp; </td><td style='width: $W6; '>&nbsp; </td>"; 
          }
          else
          {
               $report = vj_get_submit_report_by_sid($submits[$i]);
               $status = vj_get_result_description($report['rescode']); 
               $display = get_full_description($status); 
               $color = get_display_color($status); 

               if ($status == 'CE')
               {
                    $display = "<a href='show_ce_detail_classic.php?sid=$submits[$i]'>$display</a>"; 
               }

               echo '<div style="color: ' . $color . '; ">';
               echo $display; 
               echo '</div>'; 
               echo '</td>';
               echo "<td style='width: $W4; '>";
               if ($status != 'AC') echo $report['wrongid']; 
               echo '</td>'; 
               echo "<td style='width: $W5; '>"; 
               echo $report['time'] . ' MS'; 
               echo '</td>'; 
               echo "<td style='width: $W6; '>"; 
               echo $report['memory'] . ' KB'; 
               echo '</td>'; 
          }
          echo '</tr>';
     }
?>
</table>

<?php

echo '<hr />'; 

$before = $page - VJ_STATUS_PAGES_BEFORE; 
$after = $page + VJ_STATUS_PAGES_AFTER; 

if ($before < 1) $before = 1; 
if ($after > $tot_pages) $after = $tot_pages; 

echo '<div style="text-align: center; ' . $style . '">';

for ($i=$before; $i<=$after; $i++)
{
     if ($i != $page) echo '<a href="status.php?page=' . $i . '">'; 
     echo $i; 
     if ($i != $page) echo '</a>'; 
     if ($i != $after)
     {
          for ($j=1; $j<=VJ_STATUS_SPACES_BETWEEN_PAGE_NUMBERS; $j++)
          {
               echo '&nbsp; '; 
          }
     }
}

echo '</div>'; 

?>

</div>