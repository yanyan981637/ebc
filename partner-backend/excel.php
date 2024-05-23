<?php
require_once '../support_center/PHPExcel/Classes/PHPExcel.php';
require_once '../support_center/PHPExcel/Classes/PHPExcel/IOFactory.php';

require "../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');

function dowith_sql($str)
{
  /*$str = str_replace("and","",$str);
  $str = str_replace("execute","",$str);
  $str = str_replace("update","",$str);
  $str = str_replace("count","",$str);
  $str = str_replace("chr","",$str);
  $str = str_replace("mid","",$str);
  $str = str_replace("master","",$str);*/
  $str = str_replace("truncate","",$str);
  //$str = str_replace("char","",$str);
  $str = str_replace("declare","",$str);
  //$str = str_replace("select","",$str);
  //$str = str_replace("create","",$str);
  //$str = str_replace("delete","",$str);
  //$str = str_replace("insert","",$str);
	$str = str_replace("'","&#39",$str);
	$str = str_replace('"',"&quot;",$str);
  $str = str_replace(".","",$str);
  $str = str_replace("or","",$str);
	$str = str_replace("=","",$str);
  $str = str_replace("?","",$str);
	$str = str_replace("%","",$str);
	$str = str_replace("0x02BC","",$str);
  $str = str_replace("%20","",$str);
  $str = str_replace("<script>","",$str);
  $str = str_replace("</script>","",$str);
  $str = str_replace("<style>","",$str);
  $str = str_replace("</style>","",$str);
  $str = str_replace("<img>","",$str);
  $str = str_replace("</img>","",$str);
  $str = str_replace("<a>","",$str);
  $str = str_replace("</a>","",$str);
	return $str;
}
 
$now=date("Y/m/d");

if($_POST['teams']!='' && $_POST['teams']!='none'){
	$teams=dowith_sql($_POST['teams']);
  $teams=filter_var($teams);
  $sql_teams=" AND c.Team='".$teams."'";
}else{
	$teams="";
} 

if($_POST['sales']!='' && $_POST['sales']!='none'){
  $sales=dowith_sql($_POST['sales']);
  $sales=filter_var($sales);
  $sql_sales=" AND c.ID='".$sales."'";
}else{
  $sales="";
} 

if($_POST['date']!=''){
  $date=dowith_sql($_POST['date']);
  $date=filter_var($date);
}else{
  $date="";
} 

if($_POST['type']!=''){
  $type=dowith_sql($_POST['type']);
  $type=filter_var($type);
}else{
  $type="";
} 

$tmp_date=explode(" - ",$date);
$s_date=date("Y/m/d",strtotime($tmp_date[0]));
$e_date=date("Y/m/d",strtotime($tmp_date[1]));

$j=0;
$str_team="SELECT ID, Team FROM partner_teams WHERE 1";
$cmd_team=mysqli_query($link_db,$str_team);
while ($data_team=mysqli_fetch_row($cmd_team)) {
  $teamID[$j]=$data_team[0];
  $teamName[$j]=$data_team[1];
  $j++;
}

if($type<>''){
    if($type == 'Leads'){
      $file="Leads-Report-";
      $str="SELECT a.C_DATE, a.ID, b.CompanyName, b.Name, b.Email, b.CountryCode, c.NAME, a.STATUS FROM partner_leads_quote a INNER JOIN partner_user b ON a.CompanyID=b.CompanyID INNER JOIN partner_sales c ON a.SalesID=c.ID";
      $str.=" WHERE a.C_DATE BETWEEN '".$s_date."' AND '".$e_date."'".$sql_teams.$sql_sales." GROUP BY a.ID";
    }elseif($type == 'Clients'){
      $file="Clients-Report-";
      $str="SELECT b.C_DATE, b.CompanyID, b.CompanyName, b.Name, b.Email, b.CountryCode, c.NAME FROM partner_user b INNER JOIN partner_sales c ON b.ResponsibleSales=c.ID";
      $str.=" WHERE b.C_DATE BETWEEN '".$s_date."' AND '".$e_date."'".$sql_teams.$sql_sales." GROUP BY b.C_DATE";
    }elseif($type == 'Sales'){
      $file="Sales-Report-";
      $str="SELECT a.C_DATE, a.QT_ID, b.CompanyName, b.Name, b.Email, b.CountryCode, c.NAME, a.STATUS FROM partner_projects a INNER JOIN partner_user b ON a.Company=b.CompanyID INNER JOIN partner_sales c ON a.Sales=c.ID";
      $str.=" WHERE a.C_DATE BETWEEN '".$s_date."' AND '".$e_date."'".$sql_teams.$sql_sales." GROUP BY a.QT_ID";
    }
}else{
  exit();
}
if($checkbox=="1"){ // Excel.csv

 
  $filename=$sel_status."_products_list";

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
   $Sheet -> setCellValue("A1","SKU")
  -> setCellValue("B1","Model Name")
  -> setCellValue("C1","Product Type")
  -> setCellValue("D1","UPC code");

  $cmd=mysqli_query($link_db,$str); 
  $i=2;
  while ($result=mysqli_fetch_row($cmd)) {

    $Sheet -> setCellValue("A".$i,$result[0])
    -> setCellValue("B".$i,$result[1])
    -> setCellValue("C".$i,$data[1])
    -> setCellValue("D".$i,$result[3]);

    $i++;
    
  }

  //調整欄寬
  $Sheet -> getColumnDimension('A') -> setWidth(20);
  $Sheet -> getColumnDimension('B') -> setWidth(20);
  $Sheet -> getColumnDimension('C') -> setWidth(20);
  $Sheet -> getColumnDimension('D') -> setWidth(20);
  $objWriter -> save('php://output');
  exit;

}else{ // Excel.xls

  $filename=$file.$now;

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

  if($type == 'Leads'){
    $A1="Date / Time(CST)";
    $B1="Lead ID";
    $D1="Members";
    $G1="Status";
  }elseif($type == 'Clients'){
    $A1="Date / Time";
    $B1="Company ID";
    $D1="Members";
    $G1="";
  }elseif($type == 'Sales'){
    $A1="Project Date / Time";
    $B1="ID";
    $D1="Total Amount (USD)";
    $G1="Status";
  }
  $Sheet -> setCellValue("A1",$A1)
  -> setCellValue("B1",$B1)
  -> setCellValue("C1","Company")
  -> setCellValue("D1",$D1)
  -> setCellValue("E1","Responsible Sales")
  -> setCellValue("F1","Region / Country")
  -> setCellValue("G1",$G1);

  $cmd=mysqli_query($link_db,$str);
  $i=2;
  while ($result=mysqli_fetch_row($cmd)) {
    
    if($type == 'Leads'){
      $D1=$result[3]."(".$result[4].")";
      $G1=$result[7];
    }elseif($type == 'Clients'){
      $D1=$result[3]."(".$result[4].")";
      $G1="";
    }elseif($type == 'Sales'){
      $total_tmp=0;
      $strItems="SELECT ID, QT_ID, Products, Qty, UnitPrice, Description, Sort FROM partner_projects_items WHERE QT_ID='".$result[1]."' ORDER BY Sort ASC";
      $cmdItems=mysqli_query($link_db,$strItems);
      while($Items=mysqli_fetch_row($cmdItems)) {
        $total=$Items[3]*$Items[4];
        $total_tmp+=$total;
        //$total=number_format($total,2,'.',',');
      }
      $strExtra="SELECT ID, QT_ID, Item, Price, Sort FROM partner_projects_extra WHERE QT_ID='".$result[1]."' ORDER BY Sort ASC";
      $cmdExtra=mysqli_query($link_db,$strExtra);
      while($Extra=mysqli_fetch_row($cmdExtra)) {
        $total_tmp+=$Extra[3];
        //$up=number_format($Extra[3],2,'.',',');
        //$to=number_format($Extra[3],2,'.',',');
      }
      $ALL_total=$total_tmp;
      $ALL_total=number_format($ALL_total,2,'.',','); 
      $D1=$ALL_total; 
      $G1=$result[7];   
    }


    $str_type="select Regions, CountryName from partner_countrycode where CountryCode='".$result[5]."'";
    $type_result=mysqli_query($link_db,$str_type);
    $data=mysqli_fetch_row($type_result);
    $RG=$data[0]." - ".$data[1];
    $Sheet -> setCellValue("A".$i,$result[0])
    -> setCellValue("B".$i,$result[1])
    -> setCellValue("C".$i,$result[2])
    -> setCellValue("D".$i,$D1)
    -> setCellValue("E".$i,$result[6])
    -> setCellValue("F".$i,$RG)
    -> setCellValue("G".$i,$G1);

    $i++;
  }
  //調整欄寬
  $Sheet -> getColumnDimension('A') -> setWidth(20);
  $Sheet -> getColumnDimension('B') -> setWidth(20);
  $Sheet -> getColumnDimension('C') -> setWidth(20);
  $Sheet -> getColumnDimension('D') -> setWidth(20);
  $Sheet -> getColumnDimension('E') -> setWidth(20);
  $Sheet -> getColumnDimension('F') -> setWidth(20);
  $Sheet -> getColumnDimension('G') -> setWidth(20);
  $objWriter -> save('php://output');
  exit;
}


?>