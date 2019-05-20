<?php
// INIファイル読み込み
$arrayIniFile = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "../deploy.ini", true);

// secretキーのチェック
if(!isset($_SERVER['HTTP_X_HUB_SIGNATURE']) &&
   !($_SERVER['HTTP_X_HUB_SIGNATURE'] === sha1($arrayIniFile['sercret_key']))){
    file_put_contents('depoy.log', date("Y-m-d H:i:s")."\t".'secret key error', FILE_APPEND);
    die();
}

$payload = $_REQUEST['payload'];

foreach($arrayIniFile['deploy_setting'] as $repository_name => $local_repository_path){

    if($payload['repository']['name'] != $repository_name) continue;

    $command = 'cd ' . $local_repository_path;
    shell_exec($command, $output, $return_var);
    file_put_contents('depoy.log', date("Y-m-d H:i:s")."\t".$command."\t".$output, FILE_APPEND);
    if(!$return_var) continue;

    $command = 'git --git-dir=.git pull';
    file_put_contents('depoy.log', date("Y-m-d H:i:s")."\t".$command."\t".$output, FILE_APPEND);
    shell_exec($command, $output, $return_var);
}