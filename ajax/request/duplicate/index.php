<?php
include $_SERVER['DOCUMENT_ROOT'].'/functions/databases.php';
function getLccContactPhoneDupes($value)
{
  $sql="SELECT `dv_id` as `id`, `dv_fname` as `fname`, `dv_lname` as `lname` FROM lcc_contact_dupe_checks WHERE (dv_prime = '".$value."' OR dv_alt = '".$value."')";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while($r=mysql_fetch_array($result))
  {
    $call_center[] = array('id'=>$r['id'],'fname'=>ucfirst(strtolower($r['fname'])),'lname'=>ucfirst(strtolower($r['lname'])));
  }
  $sql="SELECT `web_id` as `id`, `FirstName` as `fname`, `LastName` as `lname` FROM new_leads_raw WHERE (REPLACE(primPhone,'-','') = '".$value."' OR REPLACE(altPhone,'-','') = '".$value."')";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while($r=mysql_fetch_array($result))
  {
    $pre_qual[] = array('id'=>$r['id'],'fname'=>ucfirst(strtolower($r['fname'])),'lname'=>ucfirst(strtolower($r['lname'])));
  }
  $sql="SELECT `id` as `id`, `lcc_contact_fname` as `fname`, `lcc_contact_lname` as `lname` FROM `lcc_recycle_bin_leads` WHERE (`recycle_reason` = 'Lead Deleted' OR `recycle_reason` = 'Lead Re-Deleted') AND (`lcc_contact_prim_phone` = '".$value."' OR `lcc_contact_alt_phone` = '".$value."')";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while($r=mysql_fetch_array($result))
  {
    $recycled[] = array('id'=>$r['id'],'fname'=>ucfirst(strtolower($r['fname'])),'lname'=>ucfirst(strtolower($r['lname'])));
  }
  return array_merge(array('call_center'=>$call_center),array('pre_qual'=>$pre_qual),array('recycled'=>$recycled));
}
function getLccContactEmailDupes($value)
{
  $sql="SELECT `dv_id`, dv_fname, dv_lname FROM lcc_contact_dupe_checks WHERE dv_email = '".$value."'";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  while($r=mysql_fetch_array($result))
  {
    $array[] = array('cc_id'=>$r['dv_id'],'fname'=>ucfirst(strtolower($r['dv_fname'])),'lname'=>ucfirst(strtolower($r['dv_lname'])));
  }
  return $array;
}
?>
