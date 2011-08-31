<?php

require_once('config.php'); 
require_once(VJ_CORE);

$W1 = '100px'; 
$W2 = '100px'; 
$W3 = '100px'; 
$W4 = '400px'; 
$W5 = '150px'; 
$W6 = '150px'; 

$uid = vj_get_filtered_uid(); 

if ($uid == 0)
{
     $uid = -1; 
}

$style = VJ_CONTENT_STYLE; 

?>

<div style="margin: auto; width: <?php echo VJ_SUBFRAME_WIDTH; ?>; ">
<?php
     if ($_GET['errmsg'] != '')
     {
          echo '<div style="color: red; text-align: center; ' . $style .'">';
          echo 'Error: ' . $_GET['errmsg'] . " You're now at page 1. "; 
          echo '<hr /></div>';
     }
?>
<?php
echo '<div style="text-align: center; ' . $style . '">'; 
$code = 'Total Pages: ' . $tot_pages; 
$code = $code . '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ' . ' Current Page: ' . $page; 
$code = $code . '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ' . ' Total Tasks: ' . $num; 
echo $code; 
echo '</div>';
?>
<hr />
<table style="margin: auto; ">
  <tr>
  <th>Status</th>
    <th>TID</th>
    <th>Name</th>
    <th>Title</th>
    <th>Submits</th>
    <th>AC Submits</th>
  </tr>
  <?php
     $style = VJ_CONTENT_STYLE; 
     foreach ($tasks as $task)
     {
          echo '<tr>'; 
	  echo "<td style='$style; text-align: center; width: $W1; '>";	
      if (vj_has_submitted_by_tid_and_uid($task['tid'], $uid))
      {
           if (vj_has_aced_by_tid_and_uid($task['tid'], $uid))
           {
                echo '<div style="color: #00FF00; ">Accepted</div>'; 
           }
           else 
           {
                echo '<div style="color: red">Unaccepted</div>'; 
           }
      }
	  echo '</td>'; 
          echo "<td style='$style; text-align: center; width: $W2; '>"; 
          echo $task['tid']; 
          echo '</td>';
          echo "<td style='$style; text-align: center; width: $W3; '>";
          echo $task['name']; 
          echo '</td>'; 
          echo "<td style='$style; text-align: center; width: $W4; '>";
          echo '<a href="show_task.php?tid=' . $task['tid'] . '">' . $task['title'] . '</a>'; 
          echo '</td>'; 
          echo "<td style='$style; text-align: center; width: $W5; '>"; 
          echo vj_get_submits_num_by_tid($task['tid']);  
          echo "</td>"; 
          echo "<td style='$style; text-align: center; width: $W6; '>";
          echo vj_get_ac_submits_num_by_tid($task['tid']);;
          echo "</td>"; 
          echo '</tr>'; 
     }
  ?>
</table>
<div style="<?php echo $style; ?> text-align: center; ">
<hr />
<?php
          $before = $page - VJ_PAGES_BEFORE; 
$after = $page + VJ_PAGES_AFTER; 
if ($before < 1) $before = 1;
if ($after > $tot_pages) $after = $tot_pages; 
for ($i=$before; $i<=$after; $i++)
{
     if ($i != $before)
     {
          for ($j=1; $j<=VJ_SPACES_BETWEEN_PAGE_NUMBERS; $j++)
          {
               echo '&nbsp; '; 
          }
     }
     if ($i != $page) echo '<a href="problems.php?page=' . $i . '">'; 
     echo "$i"; 
     if ($i != $page) echo '</a>';
}
?>
</div>
</div>
