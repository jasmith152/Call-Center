<?php
session_start();
if (isset($_SESSION['session_registered']))
{
  include $_SERVER['DOCUMENT_ROOT'] . '/modules/functions/database/index.php';
  include $_SERVER['DOCUMENT_ROOT'] . '/modules/functions/helper/index.php';
  $helper = new miscHelpers();
  $carrier = new lccPayClassCarrier(1);
  $class = new lccPayClass(1);
  $carrierToClass = array();
  
  foreach ($carrier->tableData as $v)
  {
    $carrierToClass[$v['name']] = $v['pay_class_id'];
  }
  
  $pay_class = array();
  
  foreach ($class->tableData as $v)
  {
    $pay_class[$v['id']] = $v['name'];
  }
  
  echo $pay_class[$carrierToClass[$_POST['carrier']]];
  
}
else
{
  ?>
  <script type="text/javascript">
    window.location='/'
  </script>
  <?php
}
?>
