<?php

require_once('config.php');
require_once(VJ_CORE);

$sid = $_GET['sid']; 
$id = $_GET['id'];

vj_collect_results();

$ans[0] = $id; 

if (vj_is_judged($sid))
{
     $report = vj_get_submit_report_by_sid($sid);
     $status = vj_get_result_description($report['rescode']); 
     $fullsta = get_full_description($status); 
     $color = get_display_color($status);
     
     $ans[1] = "<div style='color: $color; '>$fullsta</div>"; 
     $ans[2] = "<div>" . $report['wrongid'] . "</div>"; 
     $ans[3] = "<div>" . $report['time'] . " MS</div>";
     $ans[4] = "<div>" . $report['memory'] . " KB</div>"; 
}
else
{ 
     $fullsta = "Pending"; 
     $color = VJ_STATUS_COLOR_PENDING; 
     $ans[1] = "<div style='color: $color; '>$fullsta</div>"; 
     $ans[2] = ''; 
     $ans[3] = ''; 
     $ans[4] = ''; 
}

echo json_encode($ans); 

?>