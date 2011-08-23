<?php

require_once('config.php'); 
require_once(VJ_CORE);

?>

<div style="margin: auto; width: 600px; ">
<?php
     if ($_GET['errmsg'] != '')
     {
          $style = VJ_CONTENT_STYLE; 
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
<table style="margin: auto; width: 600px; ">
  <?php
     $style = VJ_CONTENT_STYLE; 
     foreach ($tasks as $task)
     {
          echo '<tr>'; 
          echo '<td style="' . $style . ' text-align: center; width: 50px; ">'; 
          echo $task['tid']; 
          echo '</td>';
          echo '<td style="' . $style . ' text-align: center; width: 100px; ">';
          echo $task['name']; 
          echo '</td>'; 
          echo '<td style="' . $style . 'text-align: center; width: 450px; ">';
          echo '<a href="show_task.php?tid=' . $task['tid'] . '">' . $task['title'] . '</a>'; 
          echo '</td>'; 
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
