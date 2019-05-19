<?php
// INIファイル読み込み
$arrayIniFile = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "../deploy.ini", true);

// secretキーのチェック
if(!isset($_SERVER['HTTP_X_HUB_SIGNATURE'])) die();
if(!$_SERVER['HTTP_X_HUB_SIGNATURE'] === sha1($arrayIniFile['sercret_key'])) die();

foreach($arrayIniFile['deploy_setting'] as $repository_name => $local_repository_path){
    $command = 'cd ' . $local_repository_path;
    shell_exec($command, $output, $return_var);
    if(!$return_var) continue;
    
    $command = 'git --git-dir=.git pull';
    shell_exec($command, $output, $return_var);
}
