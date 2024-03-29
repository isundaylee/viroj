<?php

require('../core/config.php');

function vj_accept_pending_task($ptid, $error_handler = 'vj_error')
{
     $con = vj_get_connection($error_handler); 

     $pt = vj_get_pending_task_by_ptid($ptid, $error_handler); 

     $name = $pt['name']; 
     $title = $pt['title']; 
     $exp = "INSERT INTO " . VJ_DB_PREFIX . "tasks (name, title) VALUES ('$name', '$title'); "; 

     $result = mysql_query($exp); 

     if (!$result)
     {
          call_user_func($error_handler, 'Database insertion failed. '); 
          return;
     }

     $exp = "DELETE FROM " . VJ_DB_PREFIX . "pending_tasks WHERE ptid=$ptid; "; 
     
     $result = mysql_query($exp); 

     if (!$result)
     {
          call_user_func($error_handler, 'Database deletion failed. '); 
          return; 
     }
}

function vj_decline_pending_task($ptid, $error_handler = 'vj_error')
{
     $con = vj_get_connection($error_handler); 

     $pt = vj_get_pending_task_by_ptid($ptid); 

     $cmd = "rm -rf " . VJ_TASKDIR . $pt['name']; 

     system($cmd);

     $exp = "DELETE FROM " . VJ_DB_PREFIX . "pending_tasks WHERE ptid=$ptid; "; 

     $result = mysql_query($exp); 

     if (!$result)
     {
          call_user_func($error_handler, 'Database deletion failed. '); 
          return; 
     }
}

function vj_get_pending_tasks($error_handler = 'vj_error')
{
     $con = vj_get_connection($error_handler); 

     $exp = "SELECT * FROM " . VJ_DB_PREFIX . "pending_tasks; "; 

     $result = mysql_query($exp); 

     if (!$result)
     {
          call_user_func($error_handler, 'Database opertion failed. '); 
          return; 
     }

     $tot = 0; 
     
     while($row = mysql_fetch_array($result))
     {
          ++$tot; 
          $ans[$tot] = $row; 
     }

     return $ans; 
}

function vj_get_pending_task_by_ptid($ptid, $error_handler = 'vj_error')
{
     $con = vj_get_connection($error_handler); 

     $exp = "SELECT * FROM " . VJ_DB_PREFIX . "pending_tasks WHERE ptid=" . $ptid . ";";

     $result = mysql_query($exp); 

     if (!$result)
     {
          call_user_func($error_handler, 'Database operation failed. '); 
          return; 
     }

     $row = mysql_fetch_array($result); 

     if (!$row)
     {
          call_user_func($error_handler, 'No such pending task exists. '); 
          return; 
     }

     return $row; 
}

function vj_add_pending_task($tskname, $title, $error_handler = 'vj_error')
{
     $con = vj_get_connection($error_handler); 

     $exp = "INSERT INTO " . VJ_DB_PREFIX . "pending_tasks (name, title) VALUES ('$tskname', '$title'); "; 

     if (!mysql_query($exp))
     {
          call_user_func($error_handler, 'Database operation failed. ' . mysql_error()); 
          return; 
     }
}

function vj_get_task_types()
{
     return array('acm'); 
}

function vj_write_task_conf_file($arr, $datadir, $error_handler = 'vj_error')
{
     $a = array('type', 'tlimit', 'mlimit', 'srclimit', 'inf', 'ouf', 'datanum'); 
     foreach ($a as $str) if (!isset($arr[$str]))
     {
          call_user_func($error_handler, 'Info not complete'); 
     }

     $str = ''; 

     foreach ($arr as $i => $j)
     {
          if ($i == 'tlimit') continue; 
          if ($i == 'mlimit') continue; 
          if ($i == 'srclimit') continue; 
          if ($i == 'inf') continue; 
          if ($i == 'ouf') continue; 
          if ($i == 'datanum') continue; 
          $str .= "$i=$j\n";
     }
     $str.="datanum=" . $arr['datanum'] . "\n"; 
     for ($i=1; $i<=$arr['datanum']; $i++)
     {
          $inf = str_replace("?", $i, $arr['inf']); 
          $ouf = str_replace("?", $i, $arr['ouf']); 
          $inf = $datadir . $inf; 
          $ouf = $datadir . $ouf; 
          $str .= $arr['tlimit'] . " " . $arr['mlimit'] . " " . $inf . " " . $ouf . "\n"; 
     }
    
     return $str; 
}

function vj_util_write_file($filename, $str, $error_handler = 'vj_error')
{
     $fp = fopen($filename, "w"); 

     if (!$fp)
     {
          call_user_func($error_handler, 'Could not open file for write' ); 
          return; 
     }
     
     fwrite($fp, $str); 
     fclose($fp); 
}

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

function vj_util_read_file_adapted($filename, $error_handler = 'vj_error', $extra = array())
{
     return vj_util_adapt(vj_util_read_file($filename, $error_handler), $extra); 
}

function vj_util_read_file_full_adapted($filename, $error_handler = 'vj_error', $extra = array())
{
     return vj_util_full_adapt(vj_util_read_file($filename, $error_handler), $extra); 
}

function vj_util_adapt($str, $opt = Array())
{
     $str = str_replace("&", '&amp;', $str);
     $str = str_replace("\n", '<br />', $str);

     foreach ($opt as $i => $j) $str = str_replace($i, $j, $str); 
     
     return $str; 
}

function vj_util_full_adapt($str, $opt = array())
{
     $str = str_replace('"', '&quot;', $str);
     $str = str_replace("\t", '    ', $str); 
     $str = str_replace(" ", '&nbsp;', $str); 
     $str = str_replace("<", '&lt;', $str);
     $str = str_replace(">", '&gt;', $str);
     $str = str_replace("\n", '<br />', $str);

     foreach ($opt as $i => $j) $str = str_replace($i, $j, $str); 

     return $str; 
}

function vj_login($username, $password, $error_handler = 'vj_error')
{
     if ($_COOKIE['vj_uid'] != '')
     {
          call_user_func($error_handler, 'Attempting to log in while is already in'); 
          return; 
     }

     $con = vj_get_connection(error_handler);

     $exp = "SELECT * FROM " . VJ_DB_PREFIX . "accounts " . " WHERE username = '" . $username . "' AND PASSWORD = '" . hash("md5", $password) . "';";

     $result = mysql_query($exp);

     if ($row = mysql_fetch_array($result))
     {
          setcookie('vj_username', $username); 
          setcookie('vj_uid', $row['uid']); 
          if ($row['role'] == VJ_ADMIN_ROLE_ID) setcookie('vj_admin', 1); 
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
     setcookie('vj_uid', '');
     setcookie('vj_admin', ''); 
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

     $exp = "INSERT INTO " . VJ_DB_PREFIX . 'accounts (username, password) VALUES ("' . $username . '", "' . hash("md5", $password) . '"); ';

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

function vj_get_uid()
{
     return $_COOKIE['vj_uid']; 
}

function vj_get_filtered_uid()
{
     $uid = vj_get_uid();

     if ($uid == '')
     {
          $uid = 0; 
     }

     return $uid; 
}

function vj_get_user_detail_by_uid($uid, $error_handler = 'vj_error')
{
     $con = vj_get_connection($error_handler); 

     $exp = "SELECT * FROM " . VJ_DB_PREFIX . "accounts WHERE uid = $uid";

     $result = mysql_query($exp); 

     if (!$result)
     {
          call_user_func($error_handler, 'Not valid UID. '); 
          return; 
     }

     return mysql_fetch_array($result); 
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

function vj_get_task_detail_by_tid($tid, $error_handler = 'vj_error', $ereturn = false)
{
     $con = vj_get_connection($error_handler); 

     $exp = "SELECT * FROM " . VJ_DB_PREFIX . 'tasks WHERE tid = ' . $tid . ';';

     $result = mysql_query($exp);

     $row = mysql_fetch_array($result);
     
     if (!$row)
     {
          if ($ereturn == true) return array('title' => 'NOT FOUND'); 
          call_user_func($error_handler, 'Task with requested tid could not be found. Please check it.  '); 
          return; 
     }

     $name = $row['name'];
     $task['name'] = $name; 
     $task['title'] = $row['title']; 

     $task['title'] .= ereturn . 'asdasdasd'; 

     if ($ereturn == true) return $task; 

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

     $extra = array('$TASKROOT$' => VJ_TASKDIR_HTML . $name . '/'); 

     $task['desc'] = vj_util_read_file_adapted($taskroot . 'desc.txt', 'vj_error', $extra); 
     $task['input'] = vj_util_read_file_adapted($taskroot . 'input.txt', 'vj_error', $extra); 
     $task['output'] = vj_util_read_file_adapted($taskroot . 'output.txt', 'vj_error', $extra); 
     $task['sinput'] = vj_util_read_file_adapted($taskroot . 'sinput.txt', 'vj_error', $extra); 
     $task['soutput'] = vj_util_read_file_adapted($taskroot . 'soutput.txt', 'vj_error', $extra); 
     $task['limit'] = vj_util_read_file_adapted($taskroot . 'limit.txt', 'vj_error', $extra); 

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

function vj_submit_classic($code, $tid, $uid, $ext, $error_handler = 'vj_error')
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

     $exp = "INSERT INTO " . VJ_DB_PREFIX . "submits (tid, uid, type, status) VALUES ($tid, $uid, '$ext', 0);"; 

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
          fscanf($fp, "%d%d%d%d%d", $ans['rescode'], $ans['time'], $ans['memory'], $ans['wrongid'], $ans['codelen']);
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
     case 12: return 'RUN'; 
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

function vj_has_submitted_by_tid_and_uid($tid, $uid, $error_handler = 'vj_error')
{
     $con = vj_get_connection($error_handler);

     $table = VJ_DB_PREFIX . "submits"; 
     $exp = "SELECT * FROM $table WHERE tid = $tid AND uid = $uid; "; 

     $result = mysql_query($exp); 

     if (!$result)
     {
          call_user_func($error_handler, 'Querying database failed. ');
          return; 
     }

     if (mysql_num_rows($result) > 0)
     {
          return true; 
     }
     else
     {
          return false; 
     }
}

function vj_has_aced_by_tid_and_uid($tid, $uid, $error_handler = 'vj_error')
{
     $con = vj_get_connection($error_handler);

     $tsubmits = VJ_DB_PREFIX . "submits"; 
     $tacsubmits = VJ_DB_PREFIX . "ac_submits"; 
     $exp = "SELECT $tsubmits.sid FROM $tsubmits, $tacsubmits WHERE $tacsubmits.sid = $tsubmits.sid AND $tsubmits.tid = $tid AND $tsubmits.uid = $uid; ";

     $result = mysql_query($exp); 

     if (!$result)
     {
          call_user_func($error_handler, 'Querying database failed. '); 
          return; 
     }

     if (mysql_num_rows($result) > 0)
     {
          return true; 
     }
     else
     {
          return false; 
     }
}

function vj_get_sourcecode_classic_by_sid($sid, $error_handler = 'vj_error')
{
     $submit = vj_get_submit_detail_by_sid($sid, $error_handler); 
     return vj_util_read_file_full_adapted(VJ_SOURCEDIR . $sid . '.' . $submit['type']); 
}

function vj_validate_pending_task($ptid, $error_handler = 'vj_error')
{
     $pt = vj_get_pending_task_by_ptid($ptid, $error_handler);

     $fp = fopen(VJ_TASKDIR . $pt['name'] . "/.conf", "r"); 

     if (!$fp)
     {
          call_user_func($error_handler, 'Could not open .conf file'); 
          return FALSE; 
     }

     while (!feof($fp))
     {
          $line = fgets($fp); 
          if (strpos($line, '=') == FALSE)
          {
               sscanf($line, "%s%s%s%s", $a, $b, $in, $out); 
               if (!file_exists(VJ_TASKDIR . $pt['name'] . "/" . $in) ||
                   !file_exists(VJ_TASKDIR . $pt['name'] . "/" . $out))
               {
                    return FALSE; 
               }
          }
     }

     return TRUE; 
}

function vj_remove_task_by_tid($tid, $error_handler = 'vj_error')
{
     $con = vj_get_connection($error_handler); 

     $exp = "DELETE FROM " . VJ_DB_PREFIX . "tasks WHERE tid=$tid; "; 

     $result = mysql_query($exp); 

     if (!$result)
     {
          call_user_func($error_handler, 'Could not delete from tasks table. '); 
          return; 
     }

     $exp = "DELETE FROM " . VJ_DB_PREFIX . "submits WHERE tid=$tid; "; 

     $result = mysql_query($exp); 

     if (!$result)
     {
          call_user_func($error_handler, 'Could not delete submits info. '); 
          return; 
     }
}

function vj_is_admin()
{
     return (isset($_COOKIE['vj_admin']) && ($_COOKIE['vj_admin'] == 1)); 
}

?> 