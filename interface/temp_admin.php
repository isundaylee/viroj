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
  <div id="f1title" style="<?php echo $style; ?>">&nbsp; </div>
  TID: <input type="text" name="tid" oninput="inquireTitle(this.value); " />
  <br />
  <input type="submit" value="Remove" />
</form>
</div>

<script type="text/javascript">

var xmlHttps = null; 
try {
    xmlHttps = new XMLHttpRequest(); 
} catch (e) {
    try {
	xmlHttps = new ActiveXObject("Msxml2.XMLHTTP"); 
    } catch (e) {
	try {
	    xmlHttps = new ActiveXObject("Microsoft.XMLHTTP"); 
	} catch (failed) {
	    xmlHttps = null; 
	}
    }
}

if (xmlHttps == null) alert('Error creating xmlHttps'); 

function receivedTitle()
{
    if (xmlHttps.readyState == 4)
    {
	document.getElementById('f1title').innerHTML = 'Title: ' + xmlHttps.response; 
    }
}

function inquireTitle(a)
{
    var url = "util_get_task_title.php?tid=" + a; 
    xmlHttps.open("GET", url, true); 
    xmlHttps.onreadystatechange = receivedTitle; 
    xmlHttps.send(); 
}

</script>

</div>