<?php

require_once('config.php');
require_once(VJ_CORE);

$a = json_decode($_GET['arr']); 
$len = $a[0]; 

vj_collect_results();

for ($i=1; $i<=$len; $i++) {
     if (vj_is_judged($a[$i])) {
          $report = vj_get_submit_report_by_sid($a[$i]);
          $status = vj_get_result_description($report['rescode']); 
          $fullsta = get_full_description($status); 
          $color = get_display_color($status);
          
          $ans[$i][1] = "<div style='color: $color; '>$fullsta</div>"; 
          if ($status == 'CE') 
          {
               $ans[$i][1] = '<a href="show_ce_detail_classic.php?sid=' . $a[$i] . '">' . $ans[$i][1] . '</a>'; 
          }
          $ans[$i][2] = "<div>" . $report['wrongid'] . "</div>"; 
          $ans[$i][3] = "<div>" . $report['time'] . " MS</div>";
          $ans[$i][4] = "<div>" . $report['memory'] . " KB</div>"; 
          $ans[$i][5] = "<div>" . $report['codelen'] . " B</div>"; 
     } else { 
          $fullsta = "Pending"; 
          $color = VJ_STATUS_COLOR_PENDING; 
          $ans[$i][1] = "<div style='color: $color; '>$fullsta</div>"; 
          $ans[$i][2] = ''; 
          $ans[$i][3] = ''; 
          $ans[$i][4] = ''; 
          $ans[$i][5] = ''; 
     }
}

for ($i=1; $i<=$len; $i++) {
     for ($j=1; $j<=5; $j++) {
          if ($i == 1 && $j == 1) echo "," . $ans[$i][$j]; 
          else echo "," . $ans[$i][$j]; 
     }
}

?>