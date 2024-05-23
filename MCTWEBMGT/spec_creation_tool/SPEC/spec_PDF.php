<?php
header('Content-Type: text/html; charset=utf-8');
if(isset($_REQUEST['sku_id'])!=''){
$skus_id=intval($_REQUEST['sku_id']);

//$url="http://www.google.com.tw";
$url="http://10.88.24.54/TYANWEBMGT/mockups/Out_PDF.php?sku_id=".$skus_id;
putenv("TZ=Asia/Taipei");

error_reporting(E_ALL);
ini_set('display_errors', '1');

$cmd = "wkhtmltopdf ".$url." S".$skus_id.".pdf";
//exec("/usr/bin/wkhtmltopdf $url $skus_id.pdf");
//$t = shell_exec("/usr/bin/wkhtmltopdf $url $skus_id.pdf > /home/tyanadmin/debug.log 2>&1");

//$cmd = "wkhtmltopdf --version";
//$cmd="/usr/bin/wkhtmltopdf $url output.pdf";
$t = shell_exec($cmd);
//echo $url;

echo "<script>location.href='./S$skus_id.pdf';</script>";
exit();
}

make_html($url,$skus_id);
function make_html($url,$id){
$url="http://10.88.24.54/TYANWEBMGT/mockups/Out_PDF.php?sku_id=".$id;

ob_start();#開啟伺服器暫存 
include $url; 
$ctx=@ob_get_contents();# 得取緩存 
ob_end_clean();#清空緩存 
$fh=fopen($id.".html","w+"); 
fwrite($fh,$ctx);# 寫入html,產生html 
fclose($fh);
}
?>