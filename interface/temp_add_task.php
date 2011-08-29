<?php

require_once('config.php'); 
require_once(VJ_CORE); 

$width = VJ_SUBFRAME_WIDTH; 
$style = VJ_CONTENT_STYLE; 

echo "<div style='margin: auto; width: $width'>"; 
echo "<div style='text-align: center'>"; 

?>

<form style="<?php echo $style; ?>" action="proc_add_task.php" method="post" enctype="multipart/form-data">
Title: <input type="text" name="title" size="30" />
Code: <input type="text" name="code" />
Type: <select name="type">
<?php

     $ar = vj_get_task_types(); 

foreach ($ar as $a) echo "<option value='$a'>$a</option"; 

?>

</select>
<br />
<textarea style="resize: none; " name="desc" rows="10" cols="80">Type your description here. </textarea>
<br />
<textarea style="resize: none; " name="input" rows="10" cols="80">Type your input format  here. </textarea>
<br />
<textarea style="resize: none; " name="output" rows="10" cols="80">Type your output format here. </textarea>
<br />
<textarea style="resize: none; " name="sinput" rows="10" cols="80">Type your sample input here. </textarea>
<br />
<textarea style="resize: none; " name="soutput" rows="10" cols="80">Type your sample output here. </textarea>
<br />
<textarea style="resize: none; " name="limit" rows="10" cols="80">Type your limit of data here. </textarea>
<br />
Time Limit: <input type="text" name="tlimit" /> s
<br />
Memory Limit: <input type="text" name="mlimit" /> KB
<br />
Source Length Limit: <input type="text" name="srclimit" /> B
<br />
Input Filename (ID as '?'): <input type="text" name="inf" />
<br />
Output Filename (ID as '?'): <input type="text" name="ouf" />
<br />
Number of Tests: <input type="text" name="datanum" />
<br />
Data Archieve: <input type="file" name="file" id="file" />
<p> Compress all the ins and outs DIRECTLY in one archive file with the format of ZIP but NOT RAR. </p>
<br /> 
<input type="submit" name="submit" value="Submit" />
<br />
</form>

<?php

echo "</div>"; 
echo "</div>"; 

?>