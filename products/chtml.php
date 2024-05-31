<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

if(isset($_REQUEST['PType'])!=''){
$m_Ptype=trim($_REQUEST['PType']);
}
if(isset($_REQUEST['PMCode'])!=''){
$m_PMCode=trim($_REQUEST['PMCode']);
}
if(isset($_REQUEST['PSKUs'])!=''){
$m_PSKUs=trim($_REQUEST['PSKUs']);
}

$url_front="http://www.tyan.com/product_details.php";
$url=$url_front."?PType=".$m_Ptype."&PMCode=".$m_PMCode."&PSKUs=".$m_PSKUs;

function CHtml($fromUrl,$ToHtml){
 $str=@file_get_contents($fromUrl);
 $fp=@fopen($ToHtml,'w+');
 $fwp=@fwrite($fp,$str);
 @fclose($fp);
 @chmod($ToHtml,0755);
}
CHtml($url,$m_Ptype."_".$m_PMCode."_".$m_PSKUs.".html");
copy($m_Ptype."_".$m_PMCode."_".$m_PSKUs.".html","../".$m_Ptype."-".$m_PMCode."-".$m_PSKUs.".htm");
unlink($m_Ptype."_".$m_PMCode."_".$m_PSKUs.".html");

echo "<script>alert(\"Automatically Generated!\");self.location='../TyanBackend/contents_management/default.php'</script>";
exit();
?>