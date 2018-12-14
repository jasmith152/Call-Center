<?php
include $_SERVER['DOCUMENT_ROOT'].'/functions/databases.php';
function getZipcodesCityStateByZipcode($value)
{
  $sql="SELECT `State`, `City` FROM `zipcode` WHERE `PrimaryRecord` = 'P' AND `ZipCode` = '".$value."' LIMIT 1";
  $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
  $city_state = NULL;
  while($r=mysql_fetch_array($result))
  {
    $country = (is_numeric(trim($value)))?'USA':'CAN';
    $city_state = array('city'=>$r['City'],'state'=>$r['State'],'country'=>$country);
  }
  return $city_state;
}
?>
