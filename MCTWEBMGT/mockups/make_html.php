<?php
header('Content-Type: text/html; charset=utf-8');

putenv("TZ=Asia/Taipei");
$now=date("YmdHis"); 

    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    $cmd = "wkhtmltopdf http://www.tyan.com $now.pdf";
    $t = shell_exec($cmd);
    exit();

make_html();
function make_html(){
ob_start();#開啟伺服器缓存 
include_once 'product_spec_tmp.php'; 
$ctx=ob_get_contents();# 得取缓存 
ob_end_clean();#清空缓存 
$fh=fopen("tmp.html","w+"); 
fwrite($fh,$ctx);# 寫入html,生成html 
fclose($fh);
}
?>