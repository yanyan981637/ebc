<?php

require_once '../PHPExcel/Classes/PHPExcel.php';
require_once '../PHPExcel/Classes/PHPExcel/IOFactory.php';

require "../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');

function dowith_sql($str)
{
  //$str = str_replace("and","",$str);
  //$str = str_replace("execute","",$str);
  //$str = str_replace("update","",$str);
  //$str = str_replace("count","",$str);
  //$str = str_replace("chr","",$str);
  //$str = str_replace("mid","",$str);
  //$str = str_replace("master","",$str);
  //$str = str_replace("truncate","",$str);
  //$str = str_replace("char","",$str);
  //$str = str_replace("declare","",$str);
  //$str = str_replace("select","",$str);
  //$str = str_replace("create","",$str);
  //$str = str_replace("delete","",$str);
  //$str = str_replace("insert","",$str);
	$str = str_replace("'","&#39",$str);
	$str = str_replace('"',"&quot;",$str);
  //$str = str_replace(".","",$str);
  //$str = str_replace("or","",$str);
	$str = str_replace("=","",$str);
  //$str = str_replace("?","",$str);
	$str = str_replace("%","",$str);
	$str = str_replace("0x02BC","",$str);
//$str = str_replace("%20","",$str);
	return $str;
}
 
/*if($_POST['date_s']!=''){
	$date_s1=dowith_sql($_POST['date_s']);
	$date_s=dowith_sql($_POST['date_s']);
	$date_s= $date_s." 00:00:00";
}else{
	$date_s1="";
	$date_s="";
} 

if($_POST['date_e']!=''){
	$date_e1=dowith_sql($_POST['date_e']);
	$date_e=dowith_sql($_POST['date_e']);
	$date_e= $date_e." 23:59:59";
}else{
	$date_e1="";
	$date_e="";
} 
if($_POST['s_reg']!=''){
	$s_reg=dowith_sql($_POST['s_reg']);
}else{
	$s_reg="";
} 
if($_POST['s_status']!=''){
	$s_status=dowith_sql($_POST['s_status']);
}else{
	$s_status="";
} 

if($_POST['des']!=''){
  $checkbox=dowith_sql($_POST['des']);
}else{
  $checkbox="";
}*/

$str="SELECT `ID`, `NAME`, `COMPANYNAME`, `EMAIL`, `PHONE`, `REGION`, `ProductType`, `Type`, `MESSAGE`, `CREATEDATE` FROM `contact_us_new`";
$str.=" WHERE 1";

$now=date("Y/m/d");
$filename=$now."-contactUS";

$objPHPExcel = new PHPExcel();
//輸出Excel檔
header('Content-Type: application/vnd.ms-excel');
//下載檔案名字跟類型
header("Content-Disposition: attachment;filename=".$filename.".xls");
//禁止緩存每次都是新下載
header('Cache-Control: max-age=0');
//建表（格式可以是2007（2010之後版本的EXCEL）、或5（支持95～2003））
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
//輸出檔案
$objPHPExcel -> setActiveSheetIndex(0);             //要使用的工作表
$Sheet = $objPHPExcel -> getActiveSheet();    //取得作用中的工作表
$Sheet -> setTitle("工作表名字");              //設定工作表名稱
$objPHPExcel -> createSheet();                      //建立工作表
//儲存格一般文字或數字欄位用setCellvalue即可
$Sheet -> setCellValue("A1","ID")
-> setCellValue("B1","NAME")
-> setCellValue("C1","COMPANYNAME")
-> setCellValue("D1","EMAIL")
-> setCellValue("E1","PHONE")
-> setCellValue("F1","REGION")
-> setCellValue("G1","Product Type")
-> setCellValue("H1","Type")
-> setCellValue("I1","MESSAGE")
-> setCellValue("J1","CREATEDATE");
$cmd=mysqli_query($link_db,$str); 
$i=2;
while ($result=mysqli_fetch_row($cmd)) {

  $tmp = str_replace("<p>","",$result[8]);
  $tmp = str_replace("&#39;","'",$tmp);
  $tmp = str_replace("&nbsp;"," ",$tmp);
  $des = str_replace("</p>","",$tmp);

  $Sheet -> setCellValue("A".$i,$result[0])
  -> setCellValue("B".$i,$result[1])
  -> setCellValue("C".$i,$result[2])
  -> setCellValue("D".$i,$result[3])
  -> setCellValue("E".$i,$result[4])
  -> setCellValue("F".$i,$result[5])
  -> setCellValue("G".$i,$result[6])
  -> setCellValue("H".$i,$result[7])
  -> setCellValue("I".$i,$des)
  -> setCellValue("J".$i,$result[9]);

  $i++;
  
}

//調整欄寬
$Sheet -> getColumnDimension('A') -> setWidth(20);
$Sheet -> getColumnDimension('B') -> setWidth(10);
$Sheet -> getColumnDimension('C') -> setWidth(10);
$Sheet -> getColumnDimension('D') -> setWidth(10);
$Sheet -> getColumnDimension('E') -> setWidth(15);
$Sheet -> getColumnDimension('F') -> setWidth(20);
$Sheet -> getColumnDimension('G') -> setWidth(20);
$Sheet -> getColumnDimension('H') -> setWidth(15);
$Sheet -> getColumnDimension('I') -> setWidth(20);
$Sheet -> getColumnDimension('J') -> setWidth(30);
$objWriter -> save('php://output');

exit;


?>