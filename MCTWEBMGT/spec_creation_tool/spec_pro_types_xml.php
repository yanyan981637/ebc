<?php
header('Content-Type: text/html; charset=utf-8');
require ("../config.php");

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);

$str_r= "<?xml version='1.0' encoding='utf-8' ?>";
$str_r= $str_r . "<Categories_class>";
      $str="select SPECCategoryID,SPECCategoryName FROM speccategroies";
      $result=mysqli_query($link_db,$str);
      while($row=mysqli_fetch_array($result)){
$str_r= $str_r . "<SCategories_list>";
$str_r= $str_r . "<SCategories_id>{$row[SPECCategoryID]}</SCategories_id>";
$str_r= $str_r . "<SCategories_name>{$row[SPECCategoryName]}</SCategories_name>";

      $str1="select SPECTypeID,SPECCategoryID,SPECTypeName,IsShow FROM spectypes where SPECCategoryID=".$row[SPECCategoryID];
      $result1=mysqli_query($link_db,$str1);
        while($rows=mysqli_fetch_array($result1)){
$str_r= $str_r . "<STypes_list>";
$str_r= $str_r . "<STypes_id>{$rows[SPECTypeID]}</STypes_id>";
$str_r= $str_r . "<STypes_name>{$rows[SPECTypeName]}</STypes_name>";
$str_r= $str_r . "</STypes_list>";
        }
$str_r= $str_r . "</SCategories_list>";      
      }
$str_r= $str_r . "</Categories_class>";


mk_xml($str_r);

  /* 由mysqli_query產生xml檔案 */
  function mk_xml($str_r){
    $dir="./";
    $fp = fopen($dir."/spec_pro_types.xml","w");

    if(!$fp){
    mkdir($dir,0777);
    }
 
    $data=fopen($dir."/spec_pro_types.xml","w");
    fwrite($data,$str_r);
    fclose($data);
  }
?>