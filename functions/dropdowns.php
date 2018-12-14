<?php
include $_SERVER['DOCUMENT_ROOT'] . '/functions/databases.php';
function insVerNetworks($arrayOnly=NULL)
{
    if (!$arrayOnly)
    {
        $array = array(
            'Incomplete',
            'Aetna',
            'Anthem BC',
            'Beechstreet',
            'Blue Cross',
            'Cigna',
            'Coventry',
            'Federal BC',
            'First Choice',
            'First Health',
            'Great West',
            'Humana',
            'MCR',
            'Multiplan',
            'NHBC',
            'NPPN',
            'One Net',
            'Other',
            'Pacificare',
            'PHCS',
            'Shasta',
            'Tricare',
            'TRPN',
            'UHC'
        );
        sort($array);
        $return = NULL;
        foreach ($array as $a)
        {
            $return .= '<option value="' . $a . '">' . $a . '</option>';
        }
        return $return;
    }
    else
    {
        return $array;
    }
}
?>