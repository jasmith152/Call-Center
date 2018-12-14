<?php
include $_SERVER['DOCUMENT_ROOT'] . '/functions/databases.php';
//Lists all files in a directory as a link
function fileLink($dir, $linkUrl, $linkCcid)
{
  $dirPath = $dir;
  if (is_dir($dirPath))
  {
    if ($handle = opendir($dirPath))
    {
      while (false !== ($file = readdir($handle)))
      {
        if ($file != "." && $file != "..")
        {
          if (!is_dir($dirPath . "/" . $file))
          {
            $list .= '<a class="linkList" href="' . $linkUrl . $linkCcid . '/' . $file . '" target="_blank">' . $file . '</a><br />';
          }
        }
      }
      closedir($handle);
    }
  }
  return $list;
}

/**
 * Returns a hyphen if value is null;
 *
 * @param <type> $value
 * @return <type>
 */
function hyphenEmpty($value)
{
  return (!$value) ? '-' : $value;
}

//Spits out formatted 10 digit phone number
//USAGE
//prettyPhone(111.111.1111) returns (111) 111-1111
function prettyPhone($value)
{
  $value = preg_replace("/[^0-9]/", "", $value);
  if ((!$value || $value == '') && strlen($value) <> 10)
  {
    $return = "N/A";
  }
  else
  {
    $pp1rev = strrev($value);
    $pp1rev = substr($pp1rev, 0, 10);
    $pp1rev1 = substr($pp1rev, 0, 4);
    $pp1rev2 = substr($pp1rev, 4, 3);
    $pp1rev3 = substr($pp1rev, 7, 3);
    $pparray = array($pp1rev1, "-", $pp1rev2, " ", ")", $pp1rev3, "(");
    $pparray = implode($pparray);
    $return = strrev($pparray);
  }
  return $return;
}

//Drop down with value the same as name,
//USAGE
//$dropDownArray = array('Info Sheet','Mri Report','Auth Form','Other');
//<select> arrayDropDown($dropDownArray); </select>
function arrayDropDown($array)
{
  sort($array);
  foreach ($array as $a)
  {
    $options .= '<option value="' . $a . '">' . $a . '</option>';
  }
  return $options;
}

//Generates Select Options from an SQL table.

function generateCcSelectOptions($database, $table, $ignore = NULL, $selected = NULL, $selected_value = NULL)
{
  $ignored = ($ignore) ? ' WHERE name NOT IN(' . $ignore . ')' : '';
  $option = ($selected) ? '<option value="' . $selected_value . '">' . $selected . '</option>' : '';
  $options = $option;
  $sql = "SELECT * FROM `" . $table . "`" . $ignored . " ORDER BY name asc";
  $result = dbcon('mysql', 'lcc', $database, $sql);
  while ($r = mysql_fetch_array($result))
  {
    $options .= '<option value="' . $r['id'] . '" title="' . $r['description'] . '">' . $r['name'] . '</option>';
  }
  return $options;
}

//Generates a small upload form
//USAGE
//$WEBROOT comes from root helper
//$form_dir = 'ccenter/reminders/legal/wc/l1/queries/checkbox.php';
//$form_fields = array('MAX_FILE_SIZE' => '100000','ccid'=> $r['ccid'], 'id' => $r['id'], 'mode' => '1', 'type' => 'mr'); 
//form($WEBROOT,$form_dir,$r['ccid'],$form_fields,$form_array,'Category')
function uploadForm($root, $dir, $uniqueIdentifier, $fieldArray, $dropDownArray, $selectName)
{
  $form = '<form  id="upload' . $uniqueIdentifier . 'upload" enctype="multipart/form-data" action="' . $root . $dir . '" method="POST">';
  $form .= '<div style="width:100%">';
  $form .= '<select id="uploadFormDropDown' . $uniqueIdentifier . 'uploadFormDropDown" name="dropDown">';
  $form .= '<option value="">' . $selectName . '</option>';
  $form .= arrayDropDown($dropDownArray);
  $form .= '</select>&nbsp;';
  foreach ($fieldArray as $key => $value)
  {
    $form .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
  }
  $form .= '<input name="uploadForm" type="file" />&nbsp;';
  $form .= '<input type="button" onclick="if(document.getElementById(\'uploadFormDropDown' . $uniqueIdentifier . 'uploadFormDropDown\').value == \'\'){alert(\'You must select a ' . $selectName . '\');}else{document.getElementById(\'upload' . $uniqueIdentifier . 'upload\').submit();}" value="+" title="Upload File" />';
  $form .= '<div>';
  $form .= '</form>';

  return $form;
}

//count tabs
function tabCount($field, $table, $criteria)
{
  $sql = "SELECT COUNT(" . $field . ") as `tab_count` FROM " . $table . " " . $criteria;
  //echo $sql;
  $select = mysql_query($sql);
  while ($r = mysql_fetch_array($select))
  {
    $tabCount = $r['tab_count'];
  }
  return $tabCount;
}

//Get scheduled request from db1
function getScheduledConsultByWebId($web_id)
{
  $sql = "SELECT c.web_id `web_id`, DATE_FORMAT(a.`available_date`,'%m/%d/%Y') `date`, b.consult_name `center` FROM `consult_schedule` a LEFT JOIN consult_centers b ON a.`consult_center_short` = b.id JOIN consult_schedule_request c ON a.id = c.schedule_id WHERE c.web_id = " . $web_id . " LIMIT 1";
  $result = dbcon('mysql', 'db1', 'laserspine', $sql);
  while ($r = mysql_fetch_array($result))
  {
    $row = array('data' => array('web_id' => $r['web_id'], 'date' => $r['date'], 'center' => $r['center']));
  }
  return (count($row) < 1) ? array('data' => array('web_id' => '-', 'date' => 'No', 'center' => '-')) : $row;
}

//Get all call log note by cc_id
function notesByCcId($cc_id, $output)
{
  $row_count = 1;
  $return = '<div style="padding-top:20px;margin:10px;">';
  $sql = "SELECT *, DATE_FORMAT(lcc_calls_call_date,'%m/%d/%Y') calldate FROM lcc_calls WHERE lcc_calls_contact_id = " . $cc_id . " ORDER BY lcc_calls_call_id desc";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while ($r = mysql_fetch_array($result))
  {
    if ($output == 'textarea')
    {
      $return .= $r["calldate"] . " " . $r["lcc_calls_call_time"] . " [" . $r["lcc_calls_call_method"] . "] - " . $r["lcc_calls_call_user"] . "\n" . $r["lcc_calls_call_notes"] . "\n_______________________________\n\n";
    }
    else
    {
      $return .= '<font color="#0000CC">' . $r["calldate"] . "</font> <font color=\"#0080FF\">" . $r["lcc_calls_call_time"] . "</font> <font color=\"#848484\">[" . $r["lcc_calls_call_method"] . "]</font> - <font color=\"#0000CC\"><u>" . getUserFullName($r["lcc_calls_call_user"]) . "</u></font><p style=\"margin-left:10px;margin-top:5px;\">" . $r["lcc_calls_call_notes"] . "</p><center><hr style=\"width:80%\"></center>";
    }
    $row_count++;
  }
  $return .= '</div>';
  return $return;
}

//Get login fname & lname (concat)
function getUserFullName($username, $default = 'unassigned')
{
  $return = '';
  $sql = "SELECT CONCAT(`fname`,' ',`lname`) fullname FROM login WHERE username = '" . $username . "' LIMIT 1";
  $result = dbcon('mysql', 'lcc', 'login', $sql);
  while ($r = mysql_fetch_array($result))
  {
    $return .= ucwords(strtolower($r['fullname']));
  }
  $return = ($return == '') ? $default : $return;
  return $return;
}

//Get login username
function getUsernameById($user_id)
{
  if ($user_id < 1)
  {
    return false;
  }
  $sql = "SELECT username FROM login WHERE user_id = " . $user_id . " AND `password` <> '#disabled#' LIMIT 1";
  $result = dbcon('mysql', 'lcc', 'login', $sql);
  while ($r = mysql_fetch_array($result))
  {
    $return = $r['username'];
  }
  return $return;
}

function conversionType($type_id)
{
  switch ($type_id)
  {
    case 1:
      $return = "Call";
      break;
    case 2:
      $return = "Web";
      break;
    case 3:
      $return = "Seminar";
      break;
  }
  return $return;
}

function getAmkaiAccountNumber($cc_id)
{
  $return = '';
  $sql = "SELECT lcc_contact_chart_id_chart chart FROM lcc_contact_chart_id WHERE lcc_contact_chart_id_ccid = " . $cc_id . " LIMIT 1";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while ($r = mysql_fetch_array($result))
  {
    $return .= $r['chart'];
  }
  return ($return >= 1) ? $return : 'N/A';
}

function getAmkaiSurgeryDataByDateAndChart($date, $chart)
{
  $return = NULL;
  $sql = "SELECT SurgeryDate, FirstName, LastName, ApptStatus FROM lcc_amkai_sx WHERE account = " . $chart . " AND SurgeryDate = '" . $date . "' LIMIT 1";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while ($r = mysql_fetch_array($result))
  {
    $return = array('sx_date' => $r['SurgeryDate'], 'name' => $r['FirstName'], 'last_name' => $r['lastName'], 'status' => $r['ApptStatus']);
  }
  return ($return) ? $return : NULL;
}

function getConsultDataByDateAndChart($date, $chart)
{
  $return = NULL;
  $sql = "SELECT SurgeryDate, FirstName, LastName, ApptStatus FROM lcc_amkai_sx WHERE account = " . $chart . " AND SurgeryDate = '" . $date . "' LIMIT 1";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while ($r = mysql_fetch_array($result))
  {
    $return = array('sx_date' => $r['SurgeryDate'], 'name' => $r['FirstName'], 'last_name' => $r['lastName'], 'status' => $r['ApptStatus']);
  }
  return ($return) ? $return : NULL;
}

function getLatestPayClass($cc_id)
{
  $return = '';
  $sql = "SELECT lcc_npq_fin_class FROM `lcc_new_pt` WHERE lcc_npq_contact_id = " . $cc_id . " ORDER BY `lcc_npq_id` DESC LIMIT 1";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while ($r = mysql_fetch_array($result))
  {
    $return .= $r['lcc_npq_contact_id'];
  }
  return ($return >= 1) ? $return : 'N/A';
}

//Get Ankai Surgery Data
function amkaiSxDataByCcId($cc_id, $output)
{
  $row_count = 1;
  $return = '<div style="padding-top:20px;margin:10px;">';
  $sql = "SELECT *, DATE_FORMAT(SurgeryDate,'%m/%d/%Y') sxdate FROM lcc_amkai_sx WHERE ccid = " . $cc_id . " ORDER BY CaseId,SurgeryDate desc";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  if (mysql_num_rows($result) == 0)
  {
    $return .= 'No Surgery Data Available';
  }
  else
  {
    while ($r = mysql_fetch_array($result))
    {
      if ($output == 'textarea')
      {
        $return .= $r["sxdate"] . " " . $r["ApptStatus"] . " [" . $r["OpCenter"] . "] - " . $r["FinancialClass"] . "\n" . $r["InsuranceCarrier"] . "\n_______________________________\n\n";
      }
      else
      {
        $return .= '<font color="#0000CC">' . $r["sxdate"] . "</font> <font color=\"#0080FF\">" . $r["ApptStatus"] . "</font> <font color=\"#848484\">[" . $r["OpCenter"] . "]</font> - <font color=\"#0000CC\"><u>" . $r["FinancialClass"] . "</u></font> - " . $r["InsuranceCarrier"] . "<center><hr style=\"width:80%\"></center>";
      }
      $row_count++;
    }
  }
  $return .= '</div>';
  return $return;
}

//Get Single SX Status by date and ccid
function getAmkaiSurgeryStatusByDateAndCcId($date, $id)
{
  $return = NULL;
  $sql = "SELECT SurgeryDate, FirstName, LastName, ApptStatus FROM lcc_amkai_sx WHERE ccid = " . $id . " AND SurgeryDate = '" . $date . "' LIMIT 1";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while ($r = mysql_fetch_array($result))
  {
    $return = $r['ApptStatus'];
  }
  return ($return) ? $return : 'No Match';
}

//Get Single SX Status by  ccid
function getAmkaiSurgeryStatusImagesByCcId($id)
{
  $return = '';
  $sql = "SELECT COUNT(*) count, ApptStatus status FROM lcc_amkai_sx WHERE ccid = " . $id . " GROUP BY ApptStatus";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while ($r = mysql_fetch_array($result))
  {
    if ($r['count'] > 0)
    {
      if ($r['status'] == 'Pending')
      {
        $return .= '<img src="/ccenter/images/icons/fatcow/16x16/date.png" title="' . $r['count'] . ' ' . $r['status'] . '" style="cursor:help;margin-left:2px;margin-right:2px;" />';
      };
      if ($r['status'] == 'Performed')
      {
        $return .= '<img src="/ccenter/images/icons/fatcow/16x16/date_accept.png" title="' . $r['count'] . ' ' . $r['status'] . '" style="cursor:help;margin-left:2px;margin-right:2px;" />';
      };
      if ($r['status'] == 'Partially Performed/Billable')
      {
        $return .= '<img src="/ccenter/images/icons/fatcow/16x16/date_partial_accept.png" title="' . $r['count'] . ' ' . $r['status'] . '" style="cursor:help;margin-left:2px;margin-right:2px;" />';
      };
      if ($r['status'] == 'Canceled')
      {
        $return .= '<img src="/ccenter/images/icons/fatcow/16x16/date_delete.png" title="' . $r['count'] . ' ' . $r['status'] . '" style="cursor:help;margin-left:2px;margin-right:2px;" />';
      };
    }
  }
  return ($return) ? $return : '<img src="/ccenter/images/icons/fatcow/16x16/unavailable.png" title="Nothing Scheduled" style="cursor:help;margin-left:2px;margin-right:2px;" />';
}

//GUpdate Surgery Status
function updateConsultSxStatusByCcId($id, $status)
{
  $sql = "UPDATE lcc_consult SET status_id = $status WHERE contact_id = " . $id . " LIMIT 1";
  dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
}

//Get list of fields selected in SQL.
function getFieldList($result, $line_break = "<br />")
{
  $total_fields = mysql_num_fields($result);
  $current_field = 0;
  $list = '';
  while ($current_field < $total_fields)
  {
    $list .= mysql_field_name($result, $current_field) . $line_break;
    $current_field++;
  }
  return $list;
}

function buldAniInsert()
{
  $sql = "SELECT lcc_contact_contact_id contact_id, lcc_contact_prim_phone ani, lcc_contact_alt_phone anib FROM lcc_contact ORDER BY lcc_contact_contact_id LIMIT 10000";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  $count = mysql_num_rows($result);
  while ($r = mysql_fetch_array($result))
  {
    $ids[$r['contact_id']] = array('ani' => preg_replace("/[^0-9]/", "", $r['ani']), 'anib' => preg_replace("/[^0-9]/", "", $r['anib']));
  }
  $sql = "SELECT id FROM lcc_ani";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  $before_count = mysql_num_rows($result);
  $inserts = 'INSERT INTO `lcc_ani` (`contact_id`,`ani`) VALUES';
  foreach ($ids as $key => $value)
  {
    if ($value['ani'] !== null && $value['ani'] <> '')
    {
      $inserts .= "(" . $key . "," . $value['ani'] . "),";
    }
    if ($value['anib'] !== null && $value['anib'] <> '')
    {
      $inserts .= "(" . $key . "," . $value['anib'] . "),";
    }
  }
  $inserts .= 'END';
  $inserts = str_replace(",END", ";", $inserts);
  $return[] = array('Records' => $count, 'Before Insert' => $before_count);
  return $return;
}

function view_var_dump($array)
{
  echo '<pre>';
  print_r($array);
  echo '</pre>';
}

function consultSpecialistArray()
{
  $sql = "SELECT username FROM lcc_consult_specialist";
  $result = dbcon('mysql', 'lcc', 'lsi_consult_center', $sql);
  while ($r = mysql_fetch_array($result))
  {
    $array[] = $r['username'];
  }
  return $array;
}

function updateLsiCallCenterContactLccCsUser($ccid, $user)
{
  $sql = "UPDATE lcc_contact SET lcc_cs_user = '" . $user . "' WHERE lcc_contact_contact_id = " . $ccid . " LIMIT 1";
  dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  $result = getLsiCallCenterContactFullNameByCcId($ccid);
  return $result;
}

function getLsiCallCenterContactFullNameByCcId($ccid)
{
  $sql = "SELECT CONCAT(lcc_contact_fname,' ',lcc_contact_lname) name FROM lcc_contact WHERE lcc_contact_contact_id = " . $ccid . " LIMIT 1";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while ($r = mysql_fetch_array($result))
  {
    $return = $r['name'];
  }
  return $return;
}

function getLsiCallCenterContactLccCsUserByCcId($ccid)
{
  $sql = "SELECT lcc_cs_user name FROM lcc_contact WHERE lcc_contact_contact_id = " . $ccid . " LIMIT 1";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while ($r = mysql_fetch_array($result))
  {
    $return = $r['name'];
  }
  return $return;
}

function getLsiCallCenterContactLccUserByCcId($ccid)
{
  $sql = "SELECT lcc_user name FROM lcc_contact WHERE lcc_contact_contact_id = " . $ccid . " LIMIT 1";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while ($r = mysql_fetch_array($result))
  {
    $return = $r['name'];
  }
  return $return;
}

function getAmkaiInsCarrier()
{
  $options = NULL;
  $sql = "SELECT CASE WHEN carrier LIKE 'BLUE%' THEN 'BLUE CROSS' ELSE carrier END as carriers FROM carrier GROUP BY carriers";
  $result = dbcon('mysql', 'lcc', 'lsi_lists', $sql);
  while ($r = mysql_fetch_array($result))
  {
    $array[] = $r['carriers'];
  }
  sort($array);
  foreach ($array as $value)
  {
    $options .= '<option value="' . $value . '">' . $value . '</option>';
  }
  return $options;
}

function getCaseListByContactId($contact_id, $active = 1)
{
  $sql = "SELECT * FROM lcc_case WHERE contact_id = " . $contact_id . " AND active = " . $active;
  $result = dbcon('mysql', 'lcc', 'lsi_consult_center', $sql);
  while ($r = mysql_fetch_array($result))
  {
    $array[] = array(
        'id' => $r['id'],
        'contact_id' => $r['contact_id'],
        'contact_cc_id' => $r['contact_cc_id'],
        'active' => $r['active'],
        'description' => $r['description'],
        'pay_class' => $r['pay_class'],
        'insurance_carrier' => $r['insurance_carrier'],
        'triage_datetime' => $r['triage_datetime'],
        'consult_datetime' => $r['consult_datetime'],
        'surgery_datetime' => $r['surgery_datetime'],
        'created_at' => $r['created_at'],
        'updated_at' => $r['updated_at']
    );
  }
  return $array;
}

function getCaseById($id)
{
  $sql = "SELECT * FROM lcc_case WHERE id = " . $id . " LIMIT 1";
  $result = dbcon('mysql', 'lcc', 'lsi_consult_center', $sql);
  while ($r = mysql_fetch_array($result))
  {
    $array = array(
        'id' => $r['id'],
        'contact_id' => $r['contact_id'],
        'contact_cc_id' => $r['contact_cc_id'],
        'active' => $r['active'],
        'description' => $r['description'],
        'pay_class' => $r['pay_class'],
        'insurance_carrier' => $r['insurance_carrier'],
        'triage_datetime' => $r['triage_datetime'],
        'consult_datetime' => $r['consult_datetime'],
        'surgery_datetime' => $r['surgery_datetime'],
        'created_at' => $r['created_at'],
        'updated_at' => $r['updated_at']
    );
  }
  return $array;
}

function icon16($name, $title = null, $class = null, $style = 'cursor:pointer; margin-right:2px;float:right', $alt = null)
{
  return '<img class="' . $class . '" src="/ccenter/images/icons/fatcow/16x16/' . $name . '.png" title="' . $title . '" style="' . $style . '" />';
}

function icon32($name, $title = null, $class = null, $style = 'cursor:pointer; margin-right:2px;float:right', $alt = null)
{
  return '<img class="' . $class . '" src="/ccenter/images/icons/fatcow/32x32/' . $name . '.png" title="' . $title . '" style="' . $style . '" alt="' . $alt . '" />';
}

function queryFromJqSerializedPost($post, $type, $ignore_fields)
{
  $if = explode(',', $ignore_fields);
  $fields = NULL;
  $values = NULL;
  $set = 'SET ';
  if ($type == 'insert')
  {
    foreach ($post as $key => $value)
    {
      if (trim($value) !== '' && !in_array($key, $if))
      {
        $fields .= $key . ",";
        $values .= "'" . addslashes($value) . "',";
      }
    }
    $fields = substr($fields, 0, -1);
    $values = substr($values, 0, -1);
    $query_piece = "(" . $fields . ") VALUES (" . $values . ")";
  }
  elseif ($type == 'update')
  {
    foreach ($post as $key => $value)
    {
      if (trim($value) !== '' && !in_array($key, $if))
      {
        $set .= $key . " = '" . addslashes($value) . "',";
      }
    }
    $query_piece = substr($set, 0, -1);
  }
  return $query_piece;
}

function getLastLccCallCallNoteByCcId($cc_id)
{
  $sql = "SELECT CONCAT(date_format(lcc_calls_call_date,'%m/%d/%y'),' - ',`lcc_calls_call_notes`) note FROM `lcc_calls` WHERE lcc_calls_contact_id = " . $cc_id . " ORDER BY lcc_calls_call_id DESC LIMIT 1";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while ($r = mysql_fetch_array($result))
  {
    $return = $r['note'];
  }
  return $return;
}

/**
 * returns users in the sales sub groups
 *
 * @return <type>
 */
function getSalesUserArray()
{
  $return = '';
  $sql = "SELECT CONCAT(`lname`,', ',`fname`) fullname, username FROM login WHERE sub_group IN('PA-S','OC','CS') AND password != '#disabled#' ORDER BY lname";
  $result = dbcon('mysql', 'lcc', 'login', $sql);
  while ($r = mysql_fetch_array($result))
  {
    $return[] = array('value' => $r['username'], 'option' => ucwords(strtolower($r['fullname'])));
  }
  return $return;
}

function getNlrCarriers()
{
  $return = array();
  $sql = "SELECT `PrivateCompanyInsuranceType` `carrier` FROM `new_leads_raw` GROUP BY `PrivateCompanyInsuranceType` ORDER BY `PrivateCompanyInsuranceType`";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while ($r = mysql_fetch_array($result))
  {
    $return[] = $r['carrier'];
  }
  return $return;
}

function getElapsedTime($time)
{
  if ($time > time())
  {
    $time = $time - time(); // to get the time since that moment
  }
  else
  {
    $time = time() - $time; // to get the time since that moment
  }

  $tokens = array(
      31536000 => 'year',
      2592000 => 'month',
      604800 => 'week',
      86400 => 'day',
      3600 => 'hour',
      60 => 'minute',
      1 => 'second'
  );

  foreach ($tokens as $unit => $text)
  {
    if ($time < $unit)
      continue;
    $numberOfUnits = floor($time / $unit);
    return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
  }
}

/**
 *
 * @param <type> $value lcc_eval_sht_status
 * @return <type>
 */
function getEvalShtStatus($value)
{
  switch ($value)
  {
    case 0:
      return "Pending - New";
      break;
    case 1:
      return "Pending - Read (Dr.)";
      break;
    case 2:
      return "Pending - Claimed (PC)";
      break;
    case 3:
      return "Pending - Sent New Films";
      break;
    case 4:
      return "Pending - Returned to Call Center";
      break;
    case 5:
      return "Pending - Sent To Call Center";
      break;
    case 6:
      return "Completed";
      break;
    case 7:
      return "Sheet was Copied";
      break;
    case 8:
      return "Pending - Returned to Doctor";
      break;
    default:
      return "Unknown";
  }
}

function getEmrApptDeptDesc($value)
{
  switch ($value)
  {
    case 'LSI':
      return "Tampa (PM)";
      break;
    case 'LSI-OKC':
      return "Oklahoma City (OBSC)";
      break;
    case 'LSI_AZ':
      return "Scottsdale (PM)";
      break;
    case 'LSI_PHL':
      return "Philadelphia (PM)";
      break;
    case 'LSSC':
      return "Tampa (OR)";
      break;
    case 'LSSC_AZ':
      return "Scottsdale (OR)";
      break;
    case 'LSSC_PHL':
      return "Philadelphia (OR)";
      break;
    case 'MICP':
      return "Scottsdale (OBSC)";
      break;
    case 'RRIC':
      return "San Diego";
      break;
    default:
      return "NA";
  }
}

/**
 *
 * @param <timestamp> $end_ts
 * @param <timestamp> $start_ts
 */
function dateDiffUnixTime($start_ts, $end_ts, $divisor = 86400, $rounder = 0)
{
  $diff = $end_ts - $start_ts;
  return round(($diff / $divisor), $rounder);
}

/**
 *
 * @return <type>
 */
function getConsultZips()
{
  $array = array();
  $sql = "SELECT `name`,`postalcodes` FROM `lcc_operation_center` WHERE inactive = 0 AND `center_type` = 2";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while ($r = mysql_fetch_array($result, MYSQL_ASSOC))
  {
    if (strlen($r['postalcodes']) > 0)
    {
      $array[$r['name']] = explode(',', $r['postalcodes']);
    }
  }
  return $array;
}

function getAllCenterZips()
{
  $array = array();
  $sql = "SELECT `name`,`postalcodes` FROM `lcc_operation_center` WHERE inactive = 0";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while ($r = mysql_fetch_array($result, MYSQL_ASSOC))
  {
    $array[$r['name']] = explode(',', $r['postalcodes']);
  }
  return $array;
}

function validate_email($email)
{
  $pattern = "/^[-_a-z0-9\'+*$^&%=~!?{}]++(?:\.[-_a-z0-9\'+*$^&%=~!?{}]+)*+@(?:(?![-.])[-a-z0-9.]+(?<![-.])\.[a-z]{2,6}|\d{1,3}(?:\.\d{1,3}){3})(?::\d++)?$/iD";
  if (!preg_match($pattern, $email))
  {
    return false;
  }
  else
  {
    return true;
  }
}

// end function validate_email

function getPassword($length = 7)
{
  $valid = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
  $password = '';
  for ($i = 0; $i < $length; $i++)
  {
    $position = rand(0, strlen($valid) - 1);
    $password .= $valid{$position};
  }
  return($password);
}

function csvFrom2dArray($array, $header_row = true, $col_sep = ",", $row_sep = "\n", $qut = '"')
{
  //Header row.
  if ($header_row)
  {
    foreach ($array[0] as $key => $val)
    {
      //Escaping quotes.
      $key = str_replace($qut, "$qut$qut", $key);
      $output .= "$col_sep$qut$key$qut";
    }
    $output = substr($output, 1) . "\n";
  }
  //Data rows.
  foreach ($array as $key => $val)
  {
    $tmp = '';
    foreach ($val as $cell_key => $cell_val)
    {
      //Escaping quotes.
      $cell_val = str_replace($qut, "$qut$qut", $cell_val);
      $tmp .= "$col_sep$qut$cell_val$qut";
    }
    $output .= substr($tmp, 1) . $row_sep;
  }

  return $output;
}

function array2xml($array, $name = 'root', $wrapper_name = 'wrapper', $standalone = TRUE, $beginning = TRUE)
{

  global $nested;

  if ($beginning)
  {
    if ($standalone)
      header("content-type:text/xml;charset=utf-8");
    $output .= '<' . '?' . 'xml version="1.0" encoding="UTF-8"' . '?' . '>';
    $output .= '<' . $name . '>';
    $nested = 0;
  }

  // This is required because XML standards do not allow a tag to start with a number or symbol, you can change this value to whatever you like:
  $ArrayNumberPrefix = $wrapper_name . '_';

  foreach ($array as $root => $child)
  {
    if (is_array($child))
    {
      $output .= str_repeat(" ", (2 * $nested)) . '  <' . (is_string($root) ? $root : $ArrayNumberPrefix . $root) . '>';
      $nested++;
      $output .= array2xml($child, NULL, NULL, NULL, FALSE);
      $nested--;
      $output .= str_repeat(" ", (2 * $nested)) . '  </' . (is_string($root) ? $root : $ArrayNumberPrefix . $root) . '>';
    }
    else
    {
      $output .= str_repeat(" ", (2 * $nested)) . '  <' . (is_string($root) ? $root : $ArrayNumberPrefix . $root) . '><![CDATA[' . $child . ']]></' . (is_string($root) ? $root : $ArrayNumberPrefix . $root) . '>';
    }
  }

  if ($beginning)
    $output .= '</' . $name . '>';

  return $output;
}

function activeCenterShortname()
{
  $data = array();
  $sql = "SELECT `shortname` FROM `lcc_operation_center` WHERE `locked` = 0";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while ($r = mysql_fetch_array($result, MYSQLI_ASSOC))
  {
    $data[] = $r['shortname'];
  }
  return $data;
}

function activeAscConsultShortname()
{
  $data = array();
  $sql = "SELECT `shortname` FROM `lcc_operation_center` WHERE `center_type` = 1 AND inactive = 0";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while ($r = mysql_fetch_array($result, MYSQLI_ASSOC))
  {
    $data[] = $r['shortname'];
  }
  return $data;
}

function getConsultCenterNameArray()
{
  $return = array();
  $sql = "SELECT `name` `name` FROM `lcc_operation_center` WHERE inactive != 1 AND `center_type` = 2 ORDER BY `name` ASC";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while ($r = mysql_fetch_array($result))
  {
    $name = strtolower(preg_replace("/[^A-Za-z0-9]/", "", $r['name']));
    $return[$name] = $r['name'];
  }
  return $return;
}

function getUnlockedUnassignedConsultCenterIdNameArray()
{
  $return = array();
  $sql = "SELECT a.`id`,
    a.`name` `name`
    FROM `lcc_operation_center` a
    WHERE a.locked != 1
    AND `center_type` = 2
    AND (SELECT COUNT(*) FROM `login`.`login_permission` b WHERE b.`permission` = 'lp_con_cen' AND (b.value = a.id)) < 1
    ORDER BY `name` ASC";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while ($r = mysql_fetch_array($result))
  {
    $return[$r['id']] = $r['name'];
  }
  return $return;
}

function getUnlockedUnassignedAscConsultCenterIdNameArray()
{
  $return = array();
  $sql = "SELECT a.`id`,
    a.`name` `name`
    FROM `lcc_operation_center` a
    WHERE a.locked != 1
    AND `center_type` = 2
    AND (SELECT COUNT(*) FROM `login`.`login_permission` b WHERE b.`permission` = 'lp_con_cen' AND (b.value = a.id)) < 1
    ORDER BY `name` ASC";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while ($r = mysql_fetch_array($result))
  {
    $return[$r['id']] = $r['name'];
  }
  return $return;
}

function getUnlockedUnassignedCenterIdNameArray()
{
  $return = array();
  $sql = "SELECT a.`id`,
    a.`name` `name`
    FROM `lcc_operation_center` a
    WHERE a.locked != 1
    AND (SELECT COUNT(*) FROM `login`.`login_permission` b WHERE b.`permission` = 'lp_con_cen' AND (b.value = a.id)) < 1
    ORDER BY `name` ASC";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while ($r = mysql_fetch_array($result))
  {
    $return[$r['id']] = $r['name'];
  }
  return $return;
}

function getUnlockedConsultCenterIdNameArray()
{
  $return = array();
  $sql = "SELECT a.`id`,
    a.`name` `name`
    FROM `lcc_operation_center` a
    WHERE a.locked != 1
    AND `center_type` = 2
    ORDER BY `name` ASC";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while ($r = mysql_fetch_array($result))
  {
    $return[$r['id']] = $r['name'];
  }
  return $return;
}

function getOperationCenterNameById($id)
{
  $return = array();
  $sql = "SELECT `name` FROM `lcc_operation_center` WHERE `id` = " . $id;
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while ($r = mysql_fetch_array($result))
  {
    $return = $r['name'];
  }
  return $return;
}

function getOperationCenterNameByShortname($shortname)
{
  $return = array();
  $sql = "SELECT `name` FROM `lcc_operation_center` WHERE `shortname` = '" . $shortname . "'";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while ($r = mysql_fetch_array($result))
  {
    $return = $r['name'];
  }
  return $return;
}

function getOperationCenterIdByShortname($shortname)
{
  $return = array();
  $sql = "SELECT `id` FROM `lcc_operation_center` WHERE `shortname` = '" . $shortname . "'";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while ($r = mysql_fetch_array($result))
  {
    $return = $r['id'];
  }
  return $return;
}

function getOpCenterAssocByShortname($shortname)
{
  $return = array();
  $sql = "SELECT * FROM `lcc_operation_center` WHERE `shortname` = '" . $shortname . "' LIMIT 1";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while ($r = mysql_fetch_array($result))
  {
    $return[] = $r;
  }
  if (count($return[0]) > 0)
  {
    return $return[0];
  }
  return FALSE;
}

function reloadLpPermissions($login_user_id, $url)
{
  unset($_SESSION['lp_reload_permissions']);
  foreach ($_SESSION as $session => $value)
  {
    if (strstr($session, 'lp_'))
    {
      unset($_SESSION[$session]);
    }
  }
  $perm_array = array();
  $sql = "SELECT * FROM `login_permission` WHERE login_user_id = " . $login_user_id;
  $perm_result = dbcon('mysql', 'lcc', 'login', $sql);
  while ($pr = mysql_fetch_array($perm_result))
  {
    $perm_array[$pr['permission']] = $pr['value'];
  }
  foreach ($perm_array as $key => $value)
  {
    $_SESSION[$key] = $value;
  }
  return '<script type="text/javascript">window.location=\'' . $url . '\'</script>';
}

function getLpValueByLoginUserIdPerm($login_user_id, $permission)
{
  if (!$login_user_id || !$permission)
  {
    return false;
  }
  else
  {
    $sql = "SELECT `value` FROM `login_permission` WHERE `login_user_id` = " . $login_user_id . " AND `permission` = '" . $permission . "' LIMIT 1";
    $result = dbcon('mysql', 'lcc', 'login', $sql);
    while ($r = mysql_fetch_array($result))
    {
      $return = $r['value'];
    }
    return $return;
  }
}

function getLpLoginUserIdByPermValue($permission, $value)
{
  if (!$permission || !$value)
  {
    return false;
  }
  else
  {
    $sql = "SELECT `login_user_id` FROM `login_permission` WHERE `value` = '" . $value . "' AND `permission` = '" . $permission . "' LIMIT 1";
    $result = dbcon('mysql', 'lcc', 'login', $sql);
    while ($r = mysql_fetch_array($result))
    {
      $return = $r['login_user_id'];
    }
    return $return;
  }
}

function getLpLoginUserIdArrayPermValuesByPermValue($permission)
{
  $sql = "SELECT `login_user_id`,`value` FROM `login_permission` WHERE `permission` = '" . $permission . "'";
  $result = dbcon('mysql', 'lcc', 'login', $sql);
  $return = array();
  while ($r = mysql_fetch_array($result))
  {
    $return[$r['login_user_id']] = explode(',', $r['value']);
  }
  return $return;
}

function getSeminarListInfoById($seminar_id)
{
  $array = array();
  $sql = "SELECT DATE_FORMAT(`seminar_date`,'%Y-%m-%d') `date`, `host`, `building`,
        DATE_FORMAT(`seminar_date`,'%l:%i %p') `time`, `status`, `zip`, `seats_avail`
        FROM `seminars_list`
        WHERE `status` != '3' AND id = " . $seminar_id;
  if ($seminar_id > 0)
  {
    $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
    while ($r = mysql_fetch_array($result, MYSQLI_ASSOC))
    {
      $array[] = $r;
    }
  }
  return $array;
}

//Postal Code Tools
function haversineFormula($lat1, $lon1, $lat2, $lon2)
{

  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +
          cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
          cos(deg2rad($theta));

  $dist = acos($dist);
  $dist = rad2deg($dist);

  $distance = $dist * 60 * 1.1515;

  $return = round($distance, 2);
  return $return;
}

function milesBetweenPostalCodes($zip1, $zip2)
{
  $query = "select ZipCode,`Latitude` AS lat, `Longitude` AS lon from zipcode where ZipCode = '" . $zip1 . "' AND PrimaryRecord = 'P' LIMIT 1";
  $result1 = dbcon('mysql', 'lcc', 'lsi_call_center', $query);
  $latLon1 = mysql_fetch_array($result1);
  $query = "select ZipCode,`Latitude` AS lat, `Longitude` AS lon from zipcode where ZipCode = '" . $zip2 . "' AND PrimaryRecord = 'P' LIMIT 1";
  $result2 = dbcon('mysql', 'lcc', 'lsi_call_center', $query);
  $latLon2 = mysql_fetch_array($result2);
  return haversineFormula($latLon1['lat'], $latLon1['lon'], $latLon2['lat'], $latLon2['lon']);
}

function getPostalcodesByPostalcodeMilage($zip, $miles)
{
  $milesperdegree = 69.11;
  $degreesdiff = $miles / $milesperdegree;

  $query = "select `Latitude` AS lat, `Longitude` AS lon from zipcode where ZipCode = '$zip' AND PrimaryRecord = 'P'";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $query);
  $latlong = mysql_fetch_assoc($result);

  $lat1 = $latlong['lat'] - $degreesdiff;
  $lon1 = $latlong['lon'] - $degreesdiff;

  $lat2 = $latlong['lat'] + $degreesdiff;
  $lon2 = $latlong['lon'] + $degreesdiff;

  $query = "select * from zipcode where `Latitude` between '$lat1' and '$lat2' and `Longitude` between '$lon1' and '$lon2' AND PrimaryRecord = 'P'";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $query);

  $zips = array();
  while ($row = mysql_fetch_assoc($result))
  {
    $this_miles = haversineFormula($latlong['lat'], $latlong['lon'], $row['Latitude'], $row['Longitude']);
    if ($this_miles <= $miles)
    {
      $zips[$row['ZipCode']] = array('zips' => $row['ZipCode'], 'distance' => $this_miles);
    }
  }
//    echo "<pre>";
//    print_r($zips);
//    echo "</pre>";
//    exit;
  return $zips;
}

function getAge($dateOfBirth)
{
  list($Y, $m, $d) = explode("-", $dateOfBirth);
  return( date("md") < $m . $d ? date("Y") - $Y - 1 : date("Y") - $Y );
}

function getApptsOnAfterDateByCcid($cc_id, $date, $request_date, $type = '%')
{
  $data = array();
  $sql = "SELECT * FROM `zda_emr_appt_store` WHERE `status` != 'CANCELED' AND `cc_id` = $cc_id  AND `date` >= '" . $date . "' AND `type` LIKE '" . $type . "' ORDER BY `date` ASC";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  $count = mysql_num_rows($result);
  $row = NULL;
  if ($count > 0)
  {
    while ($r = mysql_fetch_array($result, MYSQLI_ASSOC))
    {
      $data[$r['emr_appt_id']] = $r;
    }
    foreach ($data as $key => $value)
    {
      if ($value['date'] == $request_date)
      {
        $row = $data[$value['emr_appt_id']];
        $match = true;
        break;
      }
    }
    if (!$row)
    {
      foreach ($data as $key => $value)
      {
        if ($value['date'] > $date)
        {
          $row = $data[$value['emr_appt_id']];
          $match = false;
          break;
        }
      }
    }
    if ($row !== NULL)
    {
      $row = array('count' => $count, 'match' => $match, 'data' => $row);
    }
    return $row;
  }
}

function echo_exit($value, $title = null)
{
  $title = ($title) ? $title . ':' : '';
  if (is_array($value))
  {
    echo $title . view_var_dump($value);
  }
  else
  {
    echo $title . $value;
  }
  exit;
}

function getNewLeadCountByLccUser($lcc_user)
{
  $array = array();
  $sql = "SELECT COUNT(*) `total` FROM lcc_contact WHERE lcc_user = '" . $lcc_user . "' AND `lcc_lead_status` = '0'";
  if (!$lcc_user)
  {
    return false;
  }
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while ($r = mysql_fetch_array($result, MYSQLI_ASSOC))
  {
    $array = $r['total'];
  }
  return $array;
}

function getMedClrInProcessCountByLccMcUser($lcc_mc_user)
{
  $array = 0;
  $sql = "SELECT COUNT(*) `total` FROM lcc_new_pt WHERE lcc_mc_user = '" . $lcc_mc_user . "' AND lcc_npq_status = 9 AND lcc_npq_edit_mode = 1";
  if (!$lcc_mc_user)
  {
    return false;
  }
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while ($r = mysql_fetch_array($result, MYSQLI_ASSOC))
  {
    $array = $r['total'];
  }
  return $array;
}

function getMedClrOnHoldCountByLccMcUser($lcc_mc_user)
{
  $array = 0;
  $sql = "SELECT COUNT(*) `total` FROM lcc_new_pt WHERE lcc_mc_user = '" . $lcc_mc_user . "' AND lcc_npq_status = 13 AND lcc_npq_edit_mode = 1";
  if (!$lcc_mc_user)
  {
    return false;
  }
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while ($r = mysql_fetch_array($result, MYSQLI_ASSOC))
  {
    $array = $r['total'];
  }
  return $array;
}

function calculateBmi($weight, $height)
{
  if ($weight > 0 && $height > 0)
  {
    return round(($weight / ($height * $height)), 2) * 703;
  }
  else
  {
    return '-';
  }
}

function formatAlpha($value, $center = false, $placeHolder = '-')
{
  if ($value == "" || !$value)
  {
    if ($center)
    {
      return '<center>' . $placeHolder . '</center>';
    }
    else
    {
      return $placeHolder;
    }
  }
  else
  {
    return $value;
  }
}

function getDateOfBirthByContactId($cc_id)
{
  $return = '';
  $return = array();
  $sql = "SELECT `lcc_contact_dob` FROM `lcc_contact` WHERE `lcc_contact_contact_id` = " . $cc_id . " LIMIT 1";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while ($r = mysql_fetch_array($result))
  {
    $return = $r['lcc_contact_dob'];
  }
  return $return;
}

function getAgeByDateOfBirth($dob)
{
  list($Y, $m, $d) = explode("-", $dob);
  return( date("md") < $m . $d ? date("Y") - $Y - 1 : date("Y") - $Y );
}

?>