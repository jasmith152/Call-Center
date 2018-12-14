<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/ccenter/lists/functions/index.php';
if($_GET['type']=='unassigned')
{
  echo '<div style="width:330px;margin:0 auto;white-space:normal">';
  echo '<p>Would you like to forward this patient to a Patient Specialist?</p>';
  echo '<center>';
  echo '<select id="ua_add_user" name="ua_add_user" style="margin:5px;">';
  echo '<option value="">If yes, Select a Patient Specialist</option>';
  echo getUsernameByGroup('"PA-S","OC","CS"');
  echo '</select>';
  echo '</center>';
  echo '<lable style="float:right;margin-right:50px;">Do not load Call Center.<input type="checkbox" id="ua_add_user_home" /></label>';
  echo '</div>';
}
?>
