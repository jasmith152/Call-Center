<?php
include '../dbcon/config.php';
include '../dbcon/opendb.php';
$cc_id = "1";

$select = "SELECT lcc_contact_contact_id as CCID, lcc_contact_date_created as `Date Acquired`, lcc_contact_tier as Tier, concat(lcc_contact_lname,',',lcc_contact_fname) as Name, lcc_contact_dob as DoB, lcc_contact_city as City, lcc_contact_state_prov as State, lcc_contact_postal as Zip, lcc_contact_country as Country, lcc_contact_gender as Gender, lcc_contact_source_one as `Main Source`, lcc_contact_source_two as `Secondary Source`, lcc_contact_Source_two_other as `Other Source`, lcc_contact_payment_type as `Ins. Type`, lcc_contact_years_in_pain as `Pain Time`, lead_added_date `Date Added`, lcc_language as `Language`, lcc_contact_spoken_surgeon as `Spoke Surgeon`, lcc_contact_had_mri as `Had MRI`, lcc_contact_recommended_sx as `SX Rec.`, lcc_contact_pain_management `Alternative Medicine`, lcc_contact_film_received_received as `Films Received` from lcc_contact limit 0, 40000";
                
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
header("Content-Disposition: attachment; filename=jp-full-cc.xls");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$data"; 
include '../dbcon/closedb.php';
?>