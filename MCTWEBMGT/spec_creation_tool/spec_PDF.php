<?php
header('Content-Type: text/html; charset=utf-8');
if(isset($_REQUEST['sku_id'])!=''){
$skus_id=intval($_REQUEST['sku_id']);

$url="http://10.88.24.54/TYANWEBMGT/mockups/Out_PDF.php?sku_id=".$skus_id;
putenv("TZ=Asia/Taipei");

error_reporting(E_ALL);
ini_set('display_errors', '1');
//$cmd = "wkhtmltopdf $url $skus_id.pdf";
shell_exec("../../../../usr/bin/wkhtmltopdf $url $skus_id.pdf");

//$t = shell_exec($cmd);
//echo "<script>location.href='./$skus_id.pdf';</script>";
exit();
}

make_html($skus_id);
function make_html($id){

$url="http://10.88.24.54/TYANWEBMGT/mockups/Out_PDF.php?sku_id=".$id;

ob_start();#開啟伺服器暫存 
include_once $url; 
$ctx=ob_get_contents();# 得取緩存 
ob_end_clean();#清空緩存 
$fh=fopen($id.".html","w+"); 
fwrite($fh,$ctx);# 寫入html,產生html 
fclose($fh);
}
?>