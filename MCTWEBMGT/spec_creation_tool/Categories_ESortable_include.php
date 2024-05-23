<?php
header('Content-Type: text/html; charset=utf-8');
require "../config.php";
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);

$a='"';$str="";

if($_GET['cate']!=''){

  foreach ($_GET['cate'] as $position => $item) :
  $sql[] =$item.",";
  endforeach;

  for($i=0;$i<count($sql);$i++){
  $str.=$sql[$i];  
  }
  //echo $str."<br />";  
}

  $str_u="update `product_skus` set SKU_CategorySort='".$str."' where Product_SKU_Auto_ID=".$_REQUEST['sk_id'];
  $str_cmd=mysqli_query($link_db,$str_u);
  mysqli_close($link_db);

?>