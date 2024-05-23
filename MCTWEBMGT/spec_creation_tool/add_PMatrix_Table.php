<?php
header('Content-Type: text/html; charset=utf-8');
require "../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);

  $str_m="select MatrixID FROM `product_matrix` order by MatrixID desc limit 1";
  $check_m=mysqli_query($link_db,$str_m);
  $Max_PMaxtrixID=mysqli_fetch_row($check_m);
  $MCount=$Max_PMaxtrixID[0]+1;

$str=$MCount;
echo $_POST['PMS_01']."<br />";
if($_POST['SEL_PMT001']==''){
echo "Value is Empty";
}
?>