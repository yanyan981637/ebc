<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
require "./config.php";

if(strpos(trim(getenv('REQUEST_URI')),'?')!='' || strpos(trim(getenv('REQUEST_URI')),'?')===0 || strpos(trim(getenv('REQUEST_URI')),"'")!='' || strpos(trim(getenv('REQUEST_URI')),"'")===0 || strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
  echo "<script language='javascript'>self.location='/404.htm'</script>";
  exit;
}

require_once 'EN/PHPExcel/Classes/PHPExcel.php';
require_once 'EN/PHPExcel/Classes/PHPExcel/IOFactory.php';

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
 

if($_POST['SKU']!=''){
	$SKU=dowith_sql($_POST['SKU']);
  $SKU = htmlspecialchars($SKU);
}else{
	$SKU="";
} 

if($_POST['TYPE']!=''){
	$TYPE=dowith_sql($_POST['TYPE']);
  $TYPE = htmlspecialchars($TYPE);
}else{
	$TYPE="";
} 

$a=explode(" ",$SKU);

/*$str_value="SELECT ID, TYPE_ID, CATE_ID, UNDER_TYPEID, VALUE FROM new_spec_value WHERE TYPE_ID='".$TYPE."' ORDER BY Sequence ASC";
$cmd_value = mysqli_query($link_db,$str_value);
while($data_value = mysqli_fetch_row($cmd_value)) {
  $arr_value[$data_value[0]]=$data_value[4];
}*/

$str_cate = "SELECT SPECCategories FROM producttypes WHERE ProductTypeID='".$TYPE."'";
$cmd_cate = mysqli_query($link_db,$str_cate);
$data_cate = mysqli_fetch_row($cmd_cate);
$cateID=explode(",", $data_cate[0]);
foreach ($cateID as $key => $value) {
  if($value!=""){
    $str_cate1 = "SELECT SPECCategoryID, SPECCategoryName FROM speccategroies WHERE SPECCategoryID='".$value."'"; //categories sort to 後台Product Types調整
    $cmd_cate1 = mysqli_query($link_db,$str_cate1);
    while ($data_cate1 = mysqli_fetch_row($cmd_cate1)) {
      $cateID1=$data_cate1[0];
      $str_UT="SELECT SPECTypeID FROM spectypes WHERE SPECCategoryID='".$cateID1."' ORDER BY SPECTypeSort ASC";
      $cmd_UT = mysqli_query($link_db,$str_UT);
      while ($data_UT = mysqli_fetch_row($cmd_UT)) {
        $str_value="SELECT SPECOptionID, SPECOptionValue FROM specoptions WHERE SPECTypeID='".$data_UT[0]."'";

        $cmd_value = mysqli_query($link_db,$str_value);
        while($data_value = mysqli_fetch_row($cmd_value)) {
          $arr_value[$data_value[0]]=$data_value[1];
        }
      }
    }
  }
}

if($checkbox=="1"){ // Excel.csv


}else{ // Excel.xls

  $filename="Mitac_products_comparison_table";

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

  $pID=array();
  $row="B";
  $sku_model="";
  //****** SKU *******
  foreach ($a as $key => $value) {
    if($value!=""){
      $str="SELECT Product_SContents_Auto_ID, ProductTypeID_SKU, SKU, MODELCODE, ProductSFile FROM `contents_product_skus` WHERE `SKU`='".$value."'";
      $cmd=mysqli_query($link_db,$str);
      $data=mysqli_fetch_row($cmd);
      $pID[]=$data[0];
      $sku_model=$data[2]."(".$data[3].")";
      $Sheet -> setCellValue("A1","")
      -> setCellValue($row."1",$sku_model);
    }
    $PID=$data[0];
    $SKU=$value;
    $row++;
  }

  
  //****** Category *******
  $i=2;
  //$str_pType = "SELECT SPECCategories FROM producttypes WHERE ProductTypeID='".$TYPE."'"; 
  $str_pType="SELECT SKU_CategorySort, SKU_Type FROM product_skus WHERE SKU='".$SKU."'"; 
  $cmd_pType = mysqli_query($link_db,$str_pType);
  $data_pType = mysqli_fetch_row($cmd_pType);
  $cateID=explode(",", $data_pType[0]);
  $pr_SPECType=$data_pType[1];
  foreach ($cateID as $key => $value) {
    if($value!=""){
      $str_cate = "SELECT SPECCategoryID, SPECCategoryName FROM speccategroies WHERE SPECCategoryID='".$value."'";
      $cmd_cate = mysqli_query($link_db,$str_cate);
      while ($data_cate = mysqli_fetch_row($cmd_cate)) {
        //$typeID=$data_cate[1];
        $cateID=$data_cate[0];
        $Sheet -> setCellValue("A".$i,$data_cate[1]);
        $Sheet->getStyle("A".$i)->applyFromArray(
          array(
           'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID, 
            'color' => array('rgb' => 'ACE8FA') 
            ) 
           ) 
          ); 
        $i++; 
        
        //****** under type *******
        $tmp_utpyeID=array();
        $str_UT="SELECT SPECTypeID, SPECCategoryID, SPECTypeName, SPECTypeSort FROM spectypes WHERE SPECCategoryID='".$cateID."' ORDER BY SPECTypeSort ASC";
        $cmd_UT = mysqli_query($link_db,$str_UT);
        while ($data_uType = mysqli_fetch_row($cmd_UT)) {
          if(preg_match("/{$data_uType[0]}/i", $pr_SPECType)) {
            $tmp_utpyeID=$data_uType[0];
            $Sheet -> setCellValue("A".$i,$data_uType[2]);

            //****** value *******
            $row_value="B";
            //foreach ($tmp_utpyeID as $key => $uTypeID) {
            foreach ($pID as $key => $value) {
              $tmp_value="";
              $str_value="SELECT SPEC_Vaule_ID, SPECValue FROM specvalues WHERE Product_SKU_Auto_ID='".$value."' AND SPECTypeID='".$tmp_utpyeID."'";
              $cmd_value = mysqli_query($link_db,$str_value);
              $data_value = mysqli_fetch_row($cmd_value);
              if($data_value[1]==""){
                $Sheet -> setCellValue($row_value.$i,"");
              }else{  
                $tmp_vID=explode(",",$data_value[1]);
                $num1=count($tmp_vID);
                foreach ($tmp_vID as $key => $value) {
                  if($value!=""){
                    if($num1==1){
                      $tmp_value.=$arr_value[$value];
                    }else{
                      $tmp_value.=$arr_value[$value];
                      $tmp_value.=" / ";
                    }
                  }                      
                }
                
              }
              $Sheet -> setCellValue($row_value.$i,$tmp_value);
              $row_value++;
            }
            $i++;
          }else{
            //echo("False");
          }
          

          
          //}
          //****** value end*******

         
        }
        //****** under type end*******

      }
      //****** Category end*******

    }
  }

  


  //調整欄寬
  $Sheet -> getColumnDimension('A') -> setWidth(35);
  $Sheet -> getColumnDimension('B') -> setWidth(50);
  $Sheet -> getColumnDimension('C') -> setWidth(50);
  $Sheet -> getColumnDimension('D') -> setWidth(50);
  $Sheet -> getColumnDimension('E') -> setWidth(50);
  $Sheet -> getColumnDimension('F') -> setWidth(50);
  $Sheet -> getColumnDimension('G') -> setWidth(50);
  $Sheet -> getColumnDimension('H') -> setWidth(50);
  $Sheet -> getColumnDimension('I') -> setWidth(50);
  $Sheet -> getColumnDimension('J') -> setWidth(50);
  $objWriter -> save('php://output');
  
  mysqli_Close($link_db);
  exit;
}


?>