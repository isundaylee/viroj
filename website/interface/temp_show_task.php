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

<div style="float: left; width: <?php echo $width; ?>; ">
<div style="float: left; width: <?php echo $half_width; ?>; ">
<div style="<?php echo $sectiontitle_style; ?>">Input Format</div>
&nbsp; <br />
<div style="<?php echo $style; ?>"><?php echo $task['input']; ?></div>
</div>
<div style="float: left; width: <?php echo $half_width; ?>; ">
<div style="<?php echo $sectiontitle_style; ?>">Output Format</div>
&nbsp; <br />
<div style="<?php echo $style; ?>"><?php echo $task['output']; ?></div>
</div>
</div> 

&nbsp; <br /><hr />

<div style="float: left; width: <?php echo $width; ?>; ">
<div style="float: left; width: <?php echo $half_width; ?>; ">
<div style="<?php echo $sectiontitle_style; ?>">Sample Input</div>
&nbsp; <br />
<div style="<?php echo $style; ?>"><?php echo $task['sinput']; ?></div>
</div>
<div style="float: left; width: <?php echo $half_width; ?>; ">
<div style="<?php echo $sectiontitle_style; ?>">Sample Output</div>
&nbsp; <br />
<div style="<?php echo $style; ?>"><?php echo $task['soutput']; ?></div>
</div>
</div>

&nbsp; <br /><hr />

<div style="float: left; width: <?php echo $width; ?>; ">
<div style="<?php echo $sectiontitle_style; ?>">Data Limit</div>
<div style="<?php echo $style; ?>"><?php echo $task['limit']; ?></div>
</div>

&nbsp; <br />

</div>