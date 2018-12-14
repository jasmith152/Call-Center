<?php
include 'index.php';
require_once 'Zend/Json.php';
if($_GET['check']=='lcc_contact_phone')
{
  header('Cache-Control: no-cache, must-revalidate');
  header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
  header('Content-type: application/json');
  echo Zend_Json::encode(getLccContactPhoneDupes($_GET['value']));
}
elseif($_GET['check']=='lcc_contact_email')
{
  header('Cache-Control: no-cache, must-revalidate');
  header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
  header('Content-type: application/json');
  echo Zend_Json::encode(getLccContactEmailDupes($_GET['value']));
}
?>
