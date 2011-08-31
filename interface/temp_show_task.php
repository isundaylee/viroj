<?php

require_once('config.php');

$half_width = VJ_SUBFRAME_HALF_WIDTH; 
$subtitle_style = VJ_SUBTITLE_STYLE; 
$sectiontitle_style = VJ_SECTIONTITLE_STYLE; 
$style = VJ_CONTENT_STYLE; 
$width = VJ_SUBFRAME_WIDTH; 

?>

<div style="margin: auto; width: <?php echo $width; ?>; ">

<div style="margin: auto; width: <?php echo $width; ?>; ">
<div style="<?php echo $subtitle_style; ?>"><?php echo $task['title']; ?></div>
<hr />
<div style="<?php echo $style; ?>"><?php echo $task['desc']; ?></div>
</div>

&nbsp; <br /><hr />

<div style="<?php echo $sectiontitle_style; ?>; text-align: left">Input Format</div>
&nbsp; <br />
<div style="<?php echo $style; ?>"><?php echo $task['input']; ?></div>
&nbsp; 
<div style="<?php echo $sectiontitle_style; ?>; text-align: left">Output Format</div>
&nbsp; <br />
<div style="<?php echo $style; ?>"><?php echo $task['output']; ?></div>

&nbsp; <br /><hr />

<div style="float: left; width: <?php echo $width; ?>; ">
<div style="<?php echo $sectiontitle_style; ?>; text-align: left">Sample Input</div>
&nbsp; <br />
<div style="<?php echo $style; ?>"><?php echo $task['sinput']; ?></div>
</div>
<div style="float: left; width: <?php echo $width; ?>; ">
&nbsp; <br />
<div style="<?php echo $sectiontitle_style; ?>; text-align: left">Sample Output</div>
&nbsp; <br />
<div style="<?php echo $style; ?>"><?php echo $task['soutput']; ?></div>
</div>

&nbsp; <br /><hr />

<div style="float: left; width: <?php echo $width; ?>; ">
<div style="<?php echo $sectiontitle_style; ?>">Data Limit</div>
<div style="<?php echo $style; ?>"><?php echo $task['limit']; ?></div>
</div>

&nbsp; <br /><hr />

<div style="text-align: center; <?php echo $style; ?>">
<a href="submit_classic.php?tid=<?php echo $tid; ?>">
Submit
</a>
</div>

</div>