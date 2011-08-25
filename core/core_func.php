<?php

require('../core/config.php');

function vj_valid_tid($tid, $error_handler = 'vj_error')
{
     $con = vj_get_connection($error_handler); 

     $exp = "SELECT * FROM " . VJ_DB_PREFIX . "tasks WHERE tid = $tid; ";
     
     $result = mysql_query($exp); 

     if ($row = mysql_fetch_array($result))
     {
          return true; 
     }
     else
     {
          return false; 
     }
}

function vj_get_connection($error_handler = 'vj_error')
{
     $con = mysql_connect(VJ_DB_HOST, VJ_DB_USERNAME, VJ_DB_PASSWORD);

     if (!$con) 
     {
          call_user_func($error_handler, 'Could not connect to database. '); 
          return; 
     }

     mysql_select_db(VJ_DB_NAME, $con); 
     mysql_query("set names 'utf8'"); 

     return $con; 
}

function vj_util_navigate($dest)
{
     echo '<script type="text/javascript">';
     echo 'location.href="' . $dest . '"';
     echo '</script>'; 
}

function vj_error_navigate($dest, $errmsg)
{
     $url = $dest . '?errmsg=' . $errmsg; 
     vj_util_navigate($url); 
}

function vj_error($errmsg)
{
     vj_error_navigate('error.php', $errmsg); 
}

function vj_util_read_file($filename, $error_handler = 'vj_error')
{
      $fp = fopen($filename, 'r'); 

     if (!$fp)
     {
          call_user_func($error_handler, 'Could not open requested file. '); 
          return; 
     }

     $content = ''; 

     while (!feof($fp))
     {
          $tmp = fgets($fp); 
          $content = $content . $tmp; 
     }

     return $content; 
}

function vj_util_read_file_adapted($filename, $error_handler = 'vj_error')
{
     return vj_util_adapt(vj_util_read_file($filename, $error_handler)); 
}

function vj_util_adapt($str)
{
     $str = str_replace(" ", '&nbsp; ', $str); 
     $str = str_replace("\n", '<br />', $str);

     return $str; 
}

function vj_login($username, $password, $error_handler = 'vj_error')
{
     if ($_COOKIE['vj_username'] != '')
     {
          call_user_func($error_handler, 'Attempting to log in while is already in'); 
          return; 
     }

     $con = vj_get_connection(error_handler);

     $exp = "SELECT * FROM " . VJ_DB_PREFIX . "accounts " . " WHERE username = '" . $username . "' AND PASSWORD = '" . $password . "';";

     $result = mysql_query($exp);

     if ($row = mysql_fetch_array($result))
     {
          setcookie('vj_username', $username); 
     }
     else 
     {
          call_user_func($error_handler, 'Wrong username-password combination. '); 
          return; 
     }
}

function vj_is_logged_in()
{
     if (vj_get_username() == '')
     {
          return false; 
     }
     else 
     {
          return true; 
     }
}

function vj_logout($error_handler = 'vj_error')
{
     if (!vj_is_logged_in())
     {
          call_user_func($error_handler, 'Attemping to log out while not logged in.' );
          return; 
     }

     setcookie('vj_username', ''); 
}

function vj_register($username, $password, $error_handler = 'vj_error')
{
     $con = vj_get_connection($error_handler); 
     
     $exp = 'SELECT * FROM ' . VJ_DB_PREFIX . 'accounts WHERE username = "' . $username . '";';

     $result = mysql_query($exp); 

     if ($row = mysql_fetch_array($result))
     {
          call_user_func($error_handler, 'User with the same username exists. '); 
          return; 
     }

     $exp = "INSERT INTO " . VJ_DB_PREFIX . 'accounts (username, password) VALUES ("' . $username . '", "' . $password . '"); ';

     $result = mysql_query($exp); 

     if (!$result)
     {
          call_user_func($error_handler, 'Error inserting entry into database. '); 
          return; 
     }
}

function vj_get_username()
{
     return $_COOKIE['vj_username']; 
}

function vj_get_filtered_username()
{
     $username = vj_get_username();

     if ($username == "")
     {
          return "not logged in"; 
     }
     else 
     {
          return $username; 
     }
}

function vj_valid_letter_num_lines($str)
{
     $len = strlen($str); 
     if ($len == 0) return false; 
     for ($i=0; $i<$len; $i++)
     {
          if ('a' <= $str[$i] && $str[$i] <= 'z') continue; 
          if ('A' <= $str[$i] && $str[$i] <= 'Z') continue; 
          if ('0' <= $str[$i] && $str[$i] <= '9') continue; 
          if ($str[$i] == '_' || $str[$i] == '-') continue; 
          return false; 
     }
     return true; 
}

function vj_valid_username($username)
{
     return vj_valid_letter_num_lines($username); 
}

function vj_valid_password($password)
{
     return vj_valid_letter_num_lines($password); 
}

function vj_get_tasks_num($error_handler = 'vj_error')
{
     $con = vj_get_connection($error_handler); 

     $exp = "SELECT * FROM " . VJ_DB_PREFIX . 'tasks;'; 

     $result = mysql_num_rows(mysql_query($exp)); 
     
     return $result; 
}

function vj_get_submits_num($error_handler = 'vj_error')
{
     $con = vj_get_connection($error_handler);

     $exp = "SELECT * FROM " . VJ_DB_PREFIX . 'submits;'; 

     $result = mysql_num_rows(mysql_query($exp)); 

     return $result; 
}

function vj_get_tasks($lb, $ub, $error_handler)
{
     $con = vj_get_connection($error_handler); 
     
     $exp = "SELECT * FROM " . VJ_DB_PREFIX . 'tasks' . " ORDER BY tid ASC LIMIT " . ($lb - 1) . ', ' . ($ub - $lb + 1) . ';';  

     $result = mysql_query($exp);
     $num = 0; 

     while ($row = mysql_fetch_array($result))
     {
          ++$num; 
          $ans[$num] = $row; 
     }

     return $ans; 
}

function vj_get_task_detail_by_tid($tid, $error_handler = 'vj_error')
{
     $con = vj_get_connection($error_handler); 

     $exp = "SELECT * FROM " . VJ_DB_PREFIX . 'tasks WHERE tid = ' . $tid . ';';

     $result = mysql_query($exp);

     $row = mysql_fetch_array($result);
     
     if (!$row)
     {
          call_user_func($error_handler, 'Task with requested tid could not be found. Please check it.  '); 
          return; 
     }

     $name = $row['name'];

     $taskroot = VJ_TASKDIR . $name . '/';

     if (!file_exists($taskroot . 'desc.txt') ||
         !file_exists($taskroot . 'input.txt') ||
         !file_exists($taskroot . 'output.txt') ||
         !file_exists($taskroot . 'sinput.txt') ||
         !file_exists($taskroot . 'soutput.txt') ||
         !file_exists($taskroot . 'limit.txt'))
     {
          call_user_func($error_handler, "Task's files not complete. Please check it. "); 
          return; 
     }

     $task['title'] = $row['title']; 
     $task['desc'] = vj_util_read_file_adapted($taskroot . 'desc.txt'); 
     $task['input'] = vj_util_read_file_adapted($taskroot . 'input.txt'); 
     $task['output'] = vj_util_read_file_adapted($taskroot . 'output.txt'); 
     $task['sinput'] = vj_util_read_file_adapted($taskroot . 'sinput.txt'); 
     $task['soutput'] = vj_util_read_file_adapted($taskroot . 'soutput.txt'); 
     $task['limit'] = vj_util_read_file_adapted($taskroot . 'limit.txt'); 

     return $task;
}

function vj_valid_source_name($str)
{
     if (preg_match('/[0-9]*_/', $str, $arr) == 1)
     {
          return $arr[0]; 
     }
     else
     {
          return false; 
     }
}

function vj_submit_classic($code, $tid, $ext, $error_handler = 'vj_error')
{
     $con = vj_get_connection(error_handler); 

     $exp = "SELECT * FROM " . VJ_DB_PREFIX . "tasks WHERE tid = " . $tid . ";";
     
     $result = mysql_query($exp); 

     $row = mysql_fetch_array($result); 

     if (!$row)
     {
          call_user_func(error_handler, 'The task does not exist. '); 
          return; 
     }

     $name = $row['name'];

     $exp = "INSERT INTO " . VJ_DB_PREFIX . "submits (tid, type, status) VALUES ($tid, '$ext', 0);"; 

     $result = mysql_query($exp);

     if (!$result)
     {
          call_user_func($error_handler, 'Submission failed due to database operating issue. '); 
          return; 
     }

     $sid = mysql_insert_id();

     $filename = VJ_SOURCEDIR . $sid . '.' . $ext; 

     $fp = fopen($filename, "w");

     if (!$fp)
     {
          call_user_func($error_handler, 'Could not open source file for write. '); 
          return; 
     }

     fwrite($fp, $code); 
     fclose($fp); 
     
     vj_write_request_file($name, $sid, $ext, $error_handler); 
}

function vj_write_request_file($name, $sid, $type, $error_handler = 'vj_error')
{
     $filename = VJ_TASKDIR . $name . '/.conf'; 
     $req_name = VJ_REQUESTS_DIR . $sid . '.req'; 

     $fp = fopen($filename, "r"); 
     $freq = fopen($req_name, "w"); 

     if (!$fp)
     {
          call_user_func($error_handler, "Can't open task's config file. "); 
          return; 
     }

     if (!$freq)
     {
          call_user_func($error_handler, "Can't open request file"); 
          return; 
     }

     fprintf($freq, "source=%s\n", VJ_SOURCE_AS_JUDGER . $sid . "." . $type);
     fprintf($freq, "lang=%s\n", $type); 

     while (!feof($fp))
     {
          $line = fgets($fp); 
          if (strpos($line, "=") != false)
          {
               fwrite($freq, $line); 
          }
          else
          {
               sscanf($line, "%f%f%s%s", $tlimit, $mlimit, $infile, $oufile); 
               fprintf($freq, "%f %f %s %s\n", $tlimit, $mlimit, VJ_TASKDIR_AS_JUDGER . $name . "/" . $infile, VJ_TASKDIR_AS_JUDGER . $name . "/" . $oufile); 
          }
     }
}

function vj_get_source_types()
{
     $types['cpp'] = 'C++'; 
     $types['c'] = 'C'; 
     $types['pas'] = 'Pascal'; 

     return $types; 
}

function vj_get_submits($lb, $ub, $error_handler = 'vj_error')
{
     $con = vj_get_connection($error_handler); 

     $exp = "SELECT * FROM " . VJ_DB_PREFIX . "submits ORDER BY sid DESC LIMIT " . ($lb - 1) . ", " . ($ub - $lb + 1) . ";";

     $result = mysql_query($exp);

     if (!$result)
     {
          call_user_func($error_handler, "Can't do query. "); 
          return; 
     }

     $num = 0; 
     while ($row = mysql_fetch_array($result))
     {
          $num++;
          $ans[$num] = $row['sid']; 
     }

     $ans[0] = $num; 

     return $ans;
}

function vj_get_submit_detail_by_sid($sid, $error_handler = 'vj_error')
{
     $con = vj_get_connection($error_handler);

     $exp = "SELECT * FROM " . VJ_DB_PREFIX . "submits WHERE sid = " . $sid . ";";

     $result = mysql_query($exp); 

     if (!($row = mysql_fetch_array($result)))
     {
          call_user_func($error_handler, 'SID not valid. '); 
          return; 
     }

     return $row; 
}

function vj_is_judged($sid, $error_handler)
{
     return (file_exists(VJ_REPORTS_DIR . $sid . '.rep')); 
}

function vj_get_submit_report_by_sid($sid, $error_handler = 'vj_error')
{
     $filename = VJ_REPORTS_DIR . $sid . '.rep'; 

     $fp = fopen($filename, "r"); 

     if (!$fp)
     {
          call_user_func($error_handler, "Can't open report file. "); 
          return; 
     }

     fscanf($fp, "%s", $type); 

     $ans['type'] = $type; 

     if ($type == 'acm')
     {
          fscanf($fp, "%d%d%d%d", $ans['rescode'], $ans['time'], $ans['memory'], $ans['wrongid']);
     }

     return $ans; 
}

function vj_get_result_description($id)
{
     switch ($id)
     {
     case 0: return 'AC'; 
     case 1: return 'CE'; 
     case 2: return 'CTLE'; 
     case 5: return 'SLLE'; 
     case 6: return 'RE'; 
     case 7: return 'TLE'; 
     case 8: return 'MLE';
     case 9: return 'WA'; 
     case 10: return 'OLE'; 
     case 11: return 'PE'; 
     }
}

function vj_valid_result_name($file)
{
     if (preg_match('/^[0-9]*.res$/', $file, $arr))
     {
          return substr($arr[0], 0, -4); 
     }
     return false; 
}

function vj_collect_results($error_handler = 'vj_error')
{
     $handle = opendir(VJ_RESULTS_DIR); 

     while ($file = readdir($handle))
     {
          if ($id = vj_valid_result_name($file))
          {
               $src = VJ_RESULTS_DIR . $id . '.res'; 
               $dest = VJ_REPORTS_DIR . $id . '.rep';
               if (!copy($src, $dest))
               {
                    call_user_func($error_handler, 'Fail to collect result files completely. '); 
                    return; 
               }
               unlink($src); 
               if (file_exists(VJ_RESULTS_DIR . $id . '.cmp'))
               {
                    $src = VJ_RESULTS_DIR . $id . '.cmp'; 
                    $dest = VJ_REPORTS_DIR . $id . '.cmp'; 
                    if (!copy($src, $dest))
                    {
                         call_user_func($error_handler, 'Fail to collect result files completely. '); 
                    }
                    unlink($src); 
               }
               $report = vj_get_submit_report_by_sid($id, $error_handler); 

               if (vj_code_is_ac($report['rescode']))
               {
                    $con = vj_get_connection($error_handler); 

                    $exp = "INSERT INTO " . VJ_DB_PREFIX . "ac_submits (sid) VALUES ($id); ";

                    $result = mysql_query($exp); 

                    if (!$result)
                    {
                         call_user_func($error_handler, 'Insert failed. '); 
                         return; 
                    }
               }
          }
     }
}

function vj_get_ce_detail_classic_by_sid($sid, $error_handler = 'vj_error')
{
     $filename = VJ_REPORTS_DIR . $sid . '.cmp';

     $fp = fopen($filename, "r"); 

     if (!$fp)
     {
          call_user_func($error_handler, 'Could not open CE detail file. ');
          return; 
     }

     return vj_util_read_file_adapted($filename); 
}

function vj_get_submits_num_by_tid($tid, $error_handler = 'vj_error')
{
     $con = vj_get_connection($error_handler); 

     $exp = "SELECT * FROM " . VJ_DB_PREFIX . "submits WHERE tid = " . $tid . ";"; 

     $result = mysql_query($exp); 

     if (!$result)
     {
          call_user_func($error_handler, 'Could not query the database. '); 
          return; 
     }

     return mysql_num_rows($result); 
}

function vj_get_ac_submits_num_by_tid($tid, $error_handler = 'vj_error')
{
     $con = vj_get_connection($error_handler);
     
     $exp = "SELECT " . VJ_DB_PREFIX . "submits.sid FROM " . VJ_DB_PREFIX . "submits, " . VJ_DB_PREFIX . "ac_submits WHERE " . VJ_DB_PREFIX . "submits.sid = " . VJ_DB_PREFIX . "ac_submits.sid AND " . VJ_DB_PREFIX . "submits.tid = $tid; "; 

     $result = mysql_query($exp); 

     if (!$result)
     {
          call_user_func($error_handler, 'Query failed. '); 
          return; 
     }

     return mysql_num_rows($result); 
}

function vj_code_is_ac($code)
{
     return $code == 0; 
}

?> 