<?php
function transformDate($val)
{
    $data = intval($val);
    return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data)->format('Y-m-d');
}
function admin_varify($type){
    $admin = ['super_admin','admin'];
    if (in_array($type,$admin)) {
        return true;
    }else{
        return false;
    }
}

?>