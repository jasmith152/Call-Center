<?php
include '../dbcon/config.php';
include '../dbcon/opendb.php';
$filename="rand_100";
$select = "SELECT lcc_contact_fname as `First Name`, lcc_contact_lname as `Last Name`, lcc_contact_date_created as `Date Created`, lcc_user as Advocate, lcc_contact_web_coms as `Web Comments` FROM lcc_contact WHERE lcc_contact_web_coms = 'LSI Call Center created this contact in house' AND lcc_contact_date_created > '2007-11-31' ORDER BY RAND() LIMIT 100";
                
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
header("Content-Disposition: attachment; filename=$filename.xls");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$data"; 
include '../dbcon/closedb.php';
?>