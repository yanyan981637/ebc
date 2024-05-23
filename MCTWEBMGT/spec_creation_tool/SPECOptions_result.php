<?
header('Content-Type: text/html; charset=utf-8');
require "../config.php";

$OID=$_REQUEST['OID'];
echo $OID;
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);

$str_Options="select SPECOptionValue from SPECOptions where SPECTypeID=".$OID;
$Optionsresult=mysqli_query($link_db,$str_Options);
if($Optionsresult==true){  
  while(list($SPECOptionValue)=mysqli_fetch_row($Optionsresult)){
  echo "<b>".$SPECOptionValue."</b>,&nbsp;";
  }
}
mysqli_close($link_db);
?>