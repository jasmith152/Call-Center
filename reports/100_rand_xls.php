<?php
include '../dbcon/config.php';
include '../dbcon/opendb.php';
$select = "SELECT lcc_contact_contact_id as `LSIoogle ID`, `lcc_contact_date_created` as `Date Acquired`, CONCAT(lcc_contact_lname, ', ',lcc_contact_fname) as Name, `lcc_contact_gender` as Gender, `lcc_contact_payment_type` as `Financial Class`, `lcc_contact_pay_type_comments` as `Insurance Type`, `lcc_contact_city` as City, `lcc_contact_state_prov` as State FROM `lcc_contact` ORDER BY rand() LIMIT 100";
                
$export = mysql_query($select);
$fields = mysql_num_fields($export);
for ($i = 0; $i < $fields; $i++) {
    $header .= mysql_field_name($export, $i) . "\t";
}
while($row = mysql_fetch_row($export)) {
    $line = '';
    foreach($row as $value) {                                            
        if ((!isset($value)) OR ($value == "")) {
            $value = "\t";
        } else {
            $value = str_replace('"', '""', $value);
            $value = '"' . $value . '"' . "\t";
        }
        $line .= $value;
    }
    $data .= trim($line)."\n";
}
$data = str_replace("\r","",$data); 
if ($data == "") {
    $data = "\n(0) Records Found!\n";                        
} 
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=100_random_financial_ins.xls");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$data"; 
include '../dbcon/closedb.php';
?>