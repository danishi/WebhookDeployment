<?php
// webhook parameter check
$array_info = [
    'date'      => date('Y/m/d H:i:s'),
    '$_REQUEST' => $_REQUEST,
    '$_SERVER'  => $_SERVER,
];

ob_start();
var_dump($array_info);
$result = ob_get_contents();
ob_end_clean();

file_put_contents('test.log', $result);
