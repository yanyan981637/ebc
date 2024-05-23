<?php
header("X-Frame-Options: DENY");
//header("Content-Security-Policy-Report-Only: default-src *; img-src https:; frame-src 'none'; report-uri http://www.tyan.com");
header("Content-Security-Policy-Report-Only: default-src *; img-src *; frame-src *; script-src * 'unsafe-inline'; style-src * 'unsafe-inline'; report-uri https://www.mitacmct.com");
// 禁止缓存目前檔案:
header('Content-Type: text/html; charset=utf-8');
/* 避免產生回上一頁 err_cache_miss 錯誤 */
header('Cache-Control: no cache'); //no cache
session_cache_limiter('private_no_expire'); // works
/* End */
header("Cache-control: private");

error_reporting(0);

if(strpos(trim(getenv('REQUEST_URI')),'?')!='' || strpos(trim(getenv('REQUEST_URI')),'?')===0 || strpos(trim(getenv('REQUEST_URI')),"'")!='' || strpos(trim(getenv('REQUEST_URI')),"'")===0 || strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
  echo "<script language='javascript'>self.location='/404.htm'</script>";
  exit;
}

if(isset($_POST['submit'])){
header('location:search_result.php');//處理數據後，轉向到其他頁面
exit;
}

require "config.php";
$sear_txt="";
$Data_record_check="";
$PLang_si01="";
$infoval1_data_all="";$infoval2_data_all="";$infoval3_data_all="";$infoval4_data_all="";$infoval5_data_all="";$infoval6_data_all="";$infoval7_data_all="";$infoval8_data_all="";
$infoval9_data_all="";$infoval10_data_all="";$infoval11_data_all="";$infoval12_data_all="";$infoval13_data_all="";$infoval14_data_all="";

@session_start();

function dowith_sql($str){
  $str = str_replace("and","",$str);
  $str = str_replace("execute","",$str);
  $str = str_replace("update","",$str);
  $str = str_replace("count","",$str);
  $str = str_replace("chr","",$str);
  $str = str_replace("mid","",$str);
  $str = str_replace("master","",$str);
  $str = str_replace("truncate","",$str);
  $str = str_replace("char","",$str);
  $str = str_replace("declare","",$str);
  $str = str_replace("select","",$str);
  $str = str_replace("create","",$str);
  $str = str_replace("delete","",$str);
  $str = str_replace("insert","",$str);
  $str = str_replace("'","",$str);
  $str = str_replace('"',"",$str);
  $str = str_replace('{',"",$str);
  $str = str_replace('}',"",$str);
  $str = str_replace('(',"",$str);
  $str = str_replace(')',"",$str);
  $str = str_replace('<',"",$str);
  $str = str_replace('>',"",$str);
  $str = str_replace("or","",$str);
  $str = str_replace("=","",$str);
  $str = str_replace("%20","",$str);
  $str = str_replace("%","",$str);
  $str = str_replace("0x02BC","",$str);
  $str = str_replace("<script>","",$str);
  $str = str_replace("</script>","",$str);
  $str = str_replace("javascript","",$str);
  $str = str_replace("bar","",$str);
  $str = str_replace("foo","",$str);
  $str = str_replace("alert","",$str);
  $str = str_replace("%00","",$str);
  $str = str_replace("script","",$str);
  $str = str_replace("ONLOAD","",$str);
  $str = str_replace("enter","",$str);
  $str = str_replace("your","",$str);
  $str = str_replace("please","",$str);
  $str = str_replace("yyobna","",$str);
  $str = str_replace("ngjsep","",$str);
  return $str;
}
//2017/07/12新增防injecion
$url = getenv('REQUEST_URI');
$url = dowith_sql($url);
//end

$sortVl01_M="";$sortVl01_S="";$sortVl01_SCKT="";$sortVl01_SCKN="";$sortVl01_CHPS="";$sortVl01_FFAT="";$sortVl01_CPU="";$sortVl01_APPT="";
$sortVl01_RACM="";$sortVl01_SerT="";$sortVl01_AdpT="";$sortVl01_HddT="";$sortVl01_PwsP="";$sortVl01_ChasT="";$sortVl01_JbdT="";
/*if(isset($_REQUEST['sortVl'])!=''){
  if(trim($_REQUEST['sortVl'])=="M1A" || trim($_REQUEST['sortVl'])=="S1A" || trim($_REQUEST['sortVl'])=="PCS1A" || trim($_REQUEST['sortVl'])=="SCKT1A" || trim($_REQUEST['sortVl'])=="SCKN1A"){
    if(trim($_REQUEST['sortVl'])=="M1A"){
      $sortVl01="a.MODELCODE";
    }elseif(trim($_REQUEST['sortVl'])=="S1A"){
      $sortVl01="a.SKU";
    }elseif(trim($_REQUEST['sortVl'])=="PCS1A"){
      $sortVl01="a.processor_val";
    }elseif(trim($_REQUEST['sortVl'])=="SCKT1A"){
      $sortVl01="a.socket_t_val";
    }elseif(trim($_REQUEST['sortVl'])=="SCKN1A"){
      $sortVl01="a.socket_n_val";
    }
    $sortVl01_M="M1D";$sortVl01_S="S1D";
    $sortVl01_PCS="PCS1D";$sortVl01_SCKT="SCKT1D";
    $sortVl01_SCKN="SCKN1D";$sortVl01_CHPS="CHPS1D";
    $sortVl01_FFAT="FFAT1D";$sortVl01_CPU="CPU1D";
    $sortVl01_APPT="APPT1D";$sortVl01_RACM="RACM1D";
    $sortVl01_SerT="SerT1D";$sortVl01_AdpT="AdpT1D";
    $sortVl01_HddT="HddT1D";$sortVl01_PwsP="PwsP1D";
    $sortVl01_ChasT="ChasT1D";$sortVl01_JbdT="JbdT1D";
    $sortVl01_DIMM="DIMM1D";$sortVl01_LAN="LAN1D";
    $sortVl01_StorT="StorT1D";$sortVl01_StorBT="StorBT1D";
    $sortVl01_PSU="PSU1D";$sortVl01_OtheT="OtheT1D";
    $sortVl01_Type="Type1D";
  }else if(trim($_REQUEST['sortVl'])=="M1D" || trim($_REQUEST['sortVl'])=="S1D" || trim($_REQUEST['sortVl'])=="PCS1D" || trim($_REQUEST['sortVl'])=="SCKT1D" || trim($_REQUEST['sortVl'])=="SCKN1D"){
    if(trim($_REQUEST['sortVl'])=="M1D"){
      $sortVl01="a.MODELCODE Desc";
    }elseif(trim($_REQUEST['sortVl'])=="S1D"){
      $sortVl01="a.SKU Desc";
    }elseif(trim($_REQUEST['sortVl'])=="PCS1D"){
      $sortVl01="a.processor_val Desc";
    }elseif(trim($_REQUEST['sortVl'])=="SCKT1D"){
      $sortVl01="a.socket_t_val Desc";
    }elseif(trim($_REQUEST['sortVl'])=="SCKN1D"){
      $sortVl01="a.socket_n_val Desc";
    }
    $sortVl01_M="M1A";$sortVl01_S="S1A";
    $sortVl01_PCS="PCS1A";$sortVl01_SCKT="SCKT1A";
    $sortVl01_SCKN="SCKN1A";$sortVl01_CHPS="CHPS1A";
    $sortVl01_FFAT="FFAT1A";$sortVl01_CPU="CPU1A";
    $sortVl01_APPT="APPT1A";$sortVl01_RACM="RACM1A";
    $sortVl01_SerT="SerT1A";$sortVl01_AdpT="AdpT1A";
    $sortVl01_HddT="HddT1A";$sortVl01_PwsP="PwsP1A";
    $sortVl01_ChasT="ChasT1A";$sortVl01_JbdT="JbdT1A";
    $sortVl01_DIMM="DIMM1A";$sortVl01_LAN="LAN1A";
    $sortVl01_StorT="StorT1A";$sortVl01_StorBT="StorBT1A";
    $sortVl01_PSU="PSU1A";$sortVl01_OtheT="OtheT1A";
    $sortVl01_Type="Type1A";
  }

  if(trim($_REQUEST['sortVl'])=="CHPS1A" || trim($_REQUEST['sortVl'])=="FFAT1A" || trim($_REQUEST['sortVl'])=="CPU1A" || trim($_REQUEST['sortVl'])=="APPT1A" || trim($_REQUEST['sortVl'])=="RACM1A" || trim($_REQUEST['sortVl'])=="SerT1A" || trim($_REQUEST['sortVl'])=="AdpT1A"){
    if(trim($_REQUEST['sortVl'])=="CHPS1A"){
      $sortVl01="a.chipset_val";
    }elseif(trim($_REQUEST['sortVl'])=="FFAT1A"){
      $sortVl01="a.ffactor_val";
    }elseif(trim($_REQUEST['sortVl'])=="CPU1A"){
      $sortVl01="a.cpu_val";
    }elseif(trim($_REQUEST['sortVl'])=="APPT1A"){
      $sortVl01="a.applications_val";
    }elseif(trim($_REQUEST['sortVl'])=="RACM1A"){
      $sortVl01="a.rackmount_val";
    }elseif(trim($_REQUEST['sortVl'])=="SerT1A"){
      $sortVl01="a.server_t_val";
    }elseif(trim($_REQUEST['sortVl'])=="AdpT1A"){
      $sortVl01="a.adapter_t_val";
    }
    $sortVl01_M="M1D";$sortVl01_S="S1D";
    $sortVl01_PCS="PCS1D";$sortVl01_SCKT="SCKT1D";
    $sortVl01_SCKN="SCKN1D";$sortVl01_CHPS="CHPS1D";
    $sortVl01_FFAT="FFAT1D";$sortVl01_CPU="CPU1D";
    $sortVl01_APPT="APPT1D";$sortVl01_RACM="RACM1D";
    $sortVl01_SerT="SerT1D";$sortVl01_AdpT="AdpT1D";
    $sortVl01_HddT="HddT1D";$sortVl01_PwsP="PwsP1D";
    $sortVl01_ChasT="ChasT1D";$sortVl01_JbdT="JbdT1D";
    $sortVl01_DIMM="DIMM1D";$sortVl01_LAN="LAN1D";
    $sortVl01_StorT="StorT1D";$sortVl01_StorBT="StorBT1D";
    $sortVl01_PSU="PSU1D";$sortVl01_OtheT="OtheT1D";
    $sortVl01_Type="Type1D";
  }else if(trim($_REQUEST['sortVl'])=="CHPS1D" || trim($_REQUEST['sortVl'])=="FFAT1D" || trim($_REQUEST['sortVl'])=="CPU1D" || trim($_REQUEST['sortVl'])=="APPT1D" || trim($_REQUEST['sortVl'])=="RACM1D" || trim($_REQUEST['sortVl'])=="SerT1D" || trim($_REQUEST['sortVl'])=="AdpT1D"){
    if(trim($_REQUEST['sortVl'])=="CHPS1D"){
      $sortVl01="a.chipset_val Desc";
    }elseif(trim($_REQUEST['sortVl'])=="FFAT1D"){
      $sortVl01="a.ffactor_val Desc";
    }elseif(trim($_REQUEST['sortVl'])=="CPU1D"){
      $sortVl01="a.cpu_val Desc";
    }elseif(trim($_REQUEST['sortVl'])=="APPT1D"){
      $sortVl01="a.applications_val Desc";
    }elseif(trim($_REQUEST['sortVl'])=="RACM1D"){
      $sortVl01="a.rackmount_val Desc";
    }elseif(trim($_REQUEST['sortVl'])=="SerT1D"){
      $sortVl01="a.server_t_val Desc";
    }elseif(trim($_REQUEST['sortVl'])=="AdpT1D"){
      $sortVl01="a.adapter_t_val Desc";
    }
    $sortVl01_M="M1A";$sortVl01_S="S1A";
    $sortVl01_PCS="PCS1A";$sortVl01_SCKT="SCKT1A";
    $sortVl01_SCKN="SCKN1A";$sortVl01_CHPS="CHPS1A";
    $sortVl01_FFAT="FFAT1A";$sortVl01_CPU="CPU1A";
    $sortVl01_APPT="APPT1A";$sortVl01_RACM="RACM1A";
    $sortVl01_SerT="SerT1A";$sortVl01_AdpT="AdpT1A";
    $sortVl01_HddT="HddT1A";$sortVl01_PwsP="PwsP1A";
    $sortVl01_ChasT="ChasT1A";$sortVl01_JbdT="JbdT1A";
    $sortVl01_DIMM="DIMM1A";$sortVl01_LAN="LAN1A";
    $sortVl01_StorT="StorT1A";$sortVl01_StorBT="StorBT1A";
    $sortVl01_PSU="PSU1A";$sortVl01_OtheT="OtheT1A";
    $sortVl01_Type="Type1A";
  }

  if(trim($_REQUEST['sortVl'])=="HddT1A" || trim($_REQUEST['sortVl'])=="PwsP1A" || trim($_REQUEST['sortVl'])=="ChasT1A" || trim($_REQUEST['sortVl'])=="JbdT1A"){
    if(trim($_REQUEST['sortVl'])=="HddT1A"){
      $sortVl01="a.hdd_val";
    }elseif(trim($_REQUEST['sortVl'])=="PwsP1A"){
      $sortVl01="a.pwersup_val";
    }elseif(trim($_REQUEST['sortVl'])=="ChasT1A"){
      $sortVl01="a.chass_t_val";
    }elseif(trim($_REQUEST['sortVl'])=="JbdT1A"){
      $sortVl01="a.jbd_t_val";
    }
    $sortVl01_M="M1D";$sortVl01_S="S1D";
    $sortVl01_PCS="PCS1D";$sortVl01_SCKT="SCKT1D";
    $sortVl01_SCKN="SCKN1D";$sortVl01_CHPS="CHPS1D";
    $sortVl01_FFAT="FFAT1D";$sortVl01_CPU="CPU1D";
    $sortVl01_APPT="APPT1D";$sortVl01_RACM="RACM1D";
    $sortVl01_SerT="SerT1D";$sortVl01_AdpT="AdpT1D";
    $sortVl01_HddT="HddT1D";$sortVl01_PwsP="PwsP1D";
    $sortVl01_ChasT="ChasT1D";$sortVl01_JbdT="JbdT1D";
    $sortVl01_DIMM="DIMM1D";$sortVl01_LAN="LAN1D";
    $sortVl01_StorT="StorT1D";$sortVl01_StorBT="StorBT1D";
    $sortVl01_PSU="PSU1D";$sortVl01_OtheT="OtheT1D";
    $sortVl01_Type="Type1D";
  }else if(trim($_REQUEST['sortVl'])=="HddT1D" || trim($_REQUEST['sortVl'])=="PwsP1D" || trim($_REQUEST['sortVl'])=="ChasT1D" || trim($_REQUEST['sortVl'])=="JbdT1D"){
    if(trim($_REQUEST['sortVl'])=="HddT1D"){
      $sortVl01="a.hdd_val Desc";
    }elseif(trim($_REQUEST['sortVl'])=="PwsP1D"){
      $sortVl01="a.pwersup_val Desc";
    }elseif(trim($_REQUEST['sortVl'])=="ChasT1D"){
      $sortVl01="a.chass_t_val Desc";
    }elseif(trim($_REQUEST['sortVl'])=="JbdT1D"){
      $sortVl01="a.jbd_t_val Desc";
    }
    $sortVl01_M="M1A";$sortVl01_S="S1A";
    $sortVl01_PCS="PCS1A";$sortVl01_SCKT="SCKT1A";
    $sortVl01_SCKN="SCKN1A";$sortVl01_CHPS="CHPS1A";
    $sortVl01_FFAT="FFAT1A";$sortVl01_CPU="CPU1A";
    $sortVl01_APPT="APPT1A";$sortVl01_RACM="RACM1A";
    $sortVl01_SerT="SerT1A";$sortVl01_AdpT="AdpT1A";
    $sortVl01_HddT="HddT1A";$sortVl01_PwsP="PwsP1A";
    $sortVl01_ChasT="ChasT1A";$sortVl01_JbdT="JbdT1A";
    $sortVl01_DIMM="DIMM1A";$sortVl01_LAN="LAN1A";
    $sortVl01_StorT="StorT1A";$sortVl01_StorBT="StorBT1A";
    $sortVl01_PSU="PSU1A";$sortVl01_OtheT="OtheT1A";
    $sortVl01_Type="Type1A";
  }  

}else{
  $sortVl01="";
  $sortVl01_M="M1A";$sortVl01_S="S1A";
  $sortVl01_PCS="PCS1A";$sortVl01_SCKT="SCKT1A";
  $sortVl01_SCKN="SCKN1A";$sortVl01_CHPS="CHPS1A";
  $sortVl01_FFAT="FFAT1A";$sortVl01_CPU="CPU1A";
  $sortVl01_APPT="APPT1A";$sortVl01_RACM="RACM1A";
  $sortVl01_SerT="SerT1A";$sortVl01_AdpT="AdpT1A";
  $sortVl01_HddT="HddT1A";$sortVl01_PwsP="PwsP1A";
  $sortVl01_ChasT="ChasT1A";$sortVl01_JbdT="JbdT1A";
  $sortVl01_DIMM="DIMM1A";$sortVl01_LAN="LAN1A";
  $sortVl01_StorT="StorT1A";$sortVl01_StorBT="StorBT1A";
  $sortVl01_PSU="PSU1A";$sortVl01_OtheT="OtheT1A";
  $sortVl01_Type="Type1A";
}*/

if(isset($_GET['PLang'])!=''){  
  $PLang_si=dowith_sql($_GET['PLang']);
  $PLang_si=str_replace(".php","",$PLang_si);

  if($PLang_si=="en-US" || $PLang_si==""){
    $PLang_si01="EN";
    $PLang_si="en-US";
  }
}else{
  $PLang_si01="EN";
  $PLang_si="en-US";
}
if(isset($_POST['txtInput'])!=''){
  $sear_txt=dowith_sql(preg_replace("/['\"\~\%\$\r\n\t;<>\?]/i", '', trim($_POST['txtInput'])));
  $sear_txt=str_replace('-','',$sear_txt);
  $sear_txt=filter_var($sear_txt);
  if(strlen($sear_txt)<2){
    $Data_record_check="true";
  }else{
    $Data_record_check="false";
  }
}

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');


if(isset($_COOKIE['status'])){
  //$s_cookie="";
}else{
  $s_cookie=$_COOKIE['status'];
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name='author' content='MiTAC Computing Technology'>
<meta name="company" content="MiTAC Computing Technology">
<meta name="description" content="">
<meta property="og:type" content="website" />
<meta property="og:description" content="" /> 
<meta property="og:title" content="Search Results  | MiTAC Computing Technology" />
<link rel="shortcut icon" href="images/ico/favicon.ico">

<!-- Stylesheets
============================================= -->
<link rel="stylesheet" href="css1/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="css1/style.css" type="text/css" />
<link rel="stylesheet" href="css1/swiper.css" type="text/css" />
<link rel="stylesheet" href="css1/dark.css" type="text/css" />
<link rel="stylesheet" href="css1/font-icons.css" type="text/css" />
<link rel="stylesheet" href="css1/animate.css" type="text/css" />
<link rel="stylesheet" href="css1/magnific-popup.css" type="text/css" />
<link rel="stylesheet" href="css1/custom.css" type="text/css" />
<link rel="stylesheet" href="css1/home.css " type="text/css" />

<script src="js1/jquery.js"></script>
<!-- Document Title
============================================= -->
<title>Search Results  | MiTAC Computing Technology</title>

<?php 
//************google analytics ************
if($s_cookie!=2){
  include_once("analyticstracking.php");
}
?>
</head>

<body class="stretched">

<!-- Document Wrapper
  ============================================= -->
  <div id="wrapper" class="clearfix">


    <!--Header logo & global top menu-->
    <?php
    include("top1.htm");
    ?>
    <!--end Header logo & global top menu-->



    <div class="section m-0 border-0 dark" style="background:#e7f2fd; padding:30px 100px 15px 100px">
      <div class="container clearfix">
        <h2 style="color:#1b1b1b">Search Result : <span class="fw-semibold"><?=$sear_txt;?></span></h2>
      </div>
    </div>

    <div class="clear mb-6"></div>

    <div class="container"><!--container-->

      <div class="row ">
        <div class="col-6">
          <?php
          $Data_record41_exist="";
          $Data_record51_exist="";
          $Data_record61_exist="";
          $Data_record71_exist="";
          $Data_record81_exist="";
          $Data_record91_exist="";
          $Data_record101_exist="";
          $Data_record111_exist="";
          $Data_record112_exist="";
          $Data_record113_exist="";

          if($Data_record_check!="true"){
            //Embedded System
            $str41="SELECT a.ProductTypeID,a.MODELCODE,a.STATUS,a.Product_Info,a.SKU,a.Product_SContents_Auto_ID,a.ProductSFile,a.IsnewUp,b.IS_EOL,b.IS_BTO FROM contents_product_skus a inner join (SELECT Product_SKU_Auto_ID,MODELCODE,SKU,IS_EOL,IS_BTO FROM product_skus) b on a.Product_SContents_Auto_ID=b.Product_SKU_Auto_ID inner join spdescription_list c ON b.SKU=c.NAME ";
            $str41.=" WHERE (a.ProductTypeID_SKU=108) AND ((Replace(a.MODELCODE,'-','') like '%".str_replace('-','',$sear_txt)."%' ) OR Replace(a.SKU,'-','') like '%".str_replace(' ','%',$sear_txt)."%' OR (c.DESCS like '%".str_replace(' ','%',$sear_txt)."%' OR c.smmarys like '%".str_replace(' ','%',$sear_txt)."%') ) AND (a.slang='".$PLang_si01.",') AND a.STATUS='1' ";
            $str41.=" order by a.crea_d desc";

            mysqli_query($link_db, 'SET NAMES utf8');
            $cmd41=mysqli_query($link_db,$str41);
            $Data_record41_num=mysqli_num_rows($cmd41);
            if($Data_record41_num==0 || $sear_txt==""){
              $Data_record41_exist="true";
            }else{

            ?>
            <!--one product type card-->
            <div class="card mb-5">
              <div class="card-body">
                <h1 class="card-title">Embedded System</h1>
                <table class="table table-striped table-hover">
                  <tbody>
                    <?php
                    $str41_val="";$Embedded_url="";
                    while($data41=mysqli_fetch_array($cmd41, MYSQLI_NUM)){//常數狀態 MYSQLI_ASSOC, MYSQLI_NUM, and MYSQLI_BOTH
                      $MCODE41=$data41[1];
                      $SKUs41=$data41[4];
                      if(strpos($data41[6],'/NIC/')!='' || strpos($data41[6],'/NIC/')===0){
                        $IMG41=$data41[6];
                      }else{
                        $IMG41="./images/NIC/".$data41[6];
                      }
                      $IsnewUp41=$data41[7];
                      $IsEol41=$data41[8];
                      $IsBTO41=$data41[9];
                      if($PLang_si01=="EN" || $PLang_si01==""){
                        $str_pdesc="SELECT `ID`, `NAME`, `DESCS`, `LANG`, `MODEL`, `STATUS` FROM `spdescription_list` where concat(',',`MODEL`) like '%".$SKUs41.",%' and `STATUS`=1 and LANG = '$PLang_si'";//原條件是$MCODE41
                        $pdesc_cmd=mysqli_query($link_db,$str_pdesc);
                        $pdesc_data=mysqli_fetch_row($pdesc_cmd);
                        if($pdesc_data==true){
                          if($pdesc_data[2]=="" || $pdesc_data[2]=="NULL"){
                            $Embedded_url="EmbeddedSystem_".$MCODE41."_".$SKUs41;
                          }else {
                            $Embedded_url="EmbeddedSystem_".$MCODE41."_".$SKUs41;
                          }
                        }else{
                          $Embedded_url="EmbeddedSystem_".$MCODE41."_".$SKUs41; 
                        }

                      }else if($PLang_si01=="CN" || $PLang_si01=="JP" || $PLang_si01=="ZH"){
                      }
                      ?>
                      <tr onclick="javascript:self.location='./<?=rawurlencode($Embedded_url);?>'">
                        <td><a href="<?=rawurlencode($Embedded_url);?>"><?=$MCODE41;?> / <?=$SKUs41;?></a> &nbsp;
                          <?php 
                          if($IsnewUp41=='1'){
                            echo "<span class='badge bg-danger'>NEW!</span>&nbsp;";
                          }
                          if($IsEol41=='1'){
                            echo "<span class='badge bg-secondary'>EOL</span>&nbsp;";
                          }
                          if($IsBTO41=='1'){
                            if($IsEol41=='1'){
                            }else{
                              echo "<span class='badge bg-primary'>BTO</span>&nbsp;";
                            }
                            
                          }
                          ?>
                        </td>  
                      </tr>
                    <?php
                    }
                    ?> 
                  </tbody>
                </table>
              </div>
            </div>
            <!--end one product type card-->
            
            <?php
            }//end Embedded System

            //Industrial Panel PC
            $str51="SELECT a.ProductTypeID,a.MODELCODE,a.STATUS,a.Product_Info,a.SKU,a.Product_SContents_Auto_ID,a.ProductSFile,a.IsnewUp,b.IS_EOL,b.IS_EOL FROM contents_product_skus a inner join (SELECT Product_SKU_Auto_ID,MODELCODE,SKU,IS_EOL,IS_BTO FROM product_skus) b on a.Product_SContents_Auto_ID=b.Product_SKU_Auto_ID inner join spdescription_list c ON b.SKU=c.NAME ";
            $str51.=" WHERE (a.ProductTypeID_SKU=107) AND ((Replace(a.MODELCODE,'-','') like '%".str_replace('-','',$sear_txt)."%' ) OR Replace(a.SKU,'-','') like '%".str_replace(' ','%',$sear_txt)."%' OR (c.DESCS like '%".str_replace(' ','%',$sear_txt)."%' OR c.smmarys like '%".str_replace(' ','%',$sear_txt)."%') ) AND (a.slang='".$PLang_si01.",') AND a.STATUS='1' ";
            $str51.=" order by a.crea_d desc";
            mysqli_query($link_db, 'SET NAMES utf8');
            $cmd51=mysqli_query($link_db,$str51);
            $Data_record51_num=mysqli_num_rows($cmd51);
            if($Data_record51_num==0 || $sear_txt==""){
              $Data_record51_exist="true";
            }else{
            ?>
            <!--one product type card-->
            <div class="card mb-5">
              <div class="card-body">
                <h1 class="card-title">Industrial Panel PC</h1>
                <table class="table table-striped table-hover">
                  <tbody>
                    <?php
                    $str51_val="";$IPanelPC_url="";
                    while($data51=mysqli_fetch_array($cmd51, MYSQLI_NUM)){//常數狀態 MYSQLI_ASSOC, MYSQLI_NUM, and MYSQLI_BOTH
                      $MCODE51=$data51[1];
                      $SKUs51=$data51[4];
                      $IMG51=$data51[6];
                      $IsnewUp51=$data51[7];
                      $IsEol51=$data51[8];
                      $IsBTO51=$data51[9];
                      if($PLang_si01=="EN" || $PLang_si01==""){

                        $str_pdesc="SELECT `ID`, `NAME`, `DESCS`, `LANG`, `MODEL`, `STATUS` FROM `spdescription_list` where concat(',',`MODEL`) like '%".$SKUs51.",%' and `STATUS`=1 and LANG = '$PLang_si'";//原條件是$MCODE51
                        $pdesc_cmd=mysqli_query($link_db,$str_pdesc);
                        $pdesc_data=mysqli_fetch_row($pdesc_cmd);
                        if($pdesc_data==true){
                          if($pdesc_data[2]=="" || $pdesc_data[2]=="NULL"){
                            $IPanelPC_url="IndustrialPanelPC_".$MCODE51."_".$SKUs51;
                          } else {
                            $IPanelPC_url="IndustrialPanelPC_".$MCODE51."_".$SKUs51;
                          }

                        }else{
                          $IPanelPC_url="IndustrialPanelPC_".$MCODE51."_".$SKUs51;
                        }

                      }else if($PLang_si01=="CN" || $PLang_si01=="JP" || $PLang_si01=="ZH"){

                      }
                      ?>
                      <tr onclick="javascript:self.location='./<?=rawurlencode($IPanelPC_url);?>'">
                        <!--<td><img class="media-object" src="<?=str_replace('~','.',"./images/serverbarebones/".$IMG51);?>" alt="<?=$SKUs51;?>"></td>-->
                        <td><a href="<?=rawurlencode($IPanelPC_url);?>"><?=$MCODE51;?> / <?=$SKUs51;?></a> &nbsp;
                          <?php 
                          if($IsnewUp51=='1'){
                            echo "<span class='badge bg-danger'>NEW!</span>&nbsp;";
                          }
                          if($IsEol51=='1'){
                            echo "<span class='badge bg-secondary'>EOL</span>&nbsp;";
                          }
                          if($IsBTO51=='1'){
                             if($IsEol51=='1'){
                            }else{
                              echo "<span class='badge bg-primary'>BTO</span>&nbsp;";
                            }
                          }
                          ?>
                        </td>
                      </tr>
                    <?php
                    }
                    ?>            
                  </tbody>
                </table>
              </div>
            </div>


            <!--end one product type card-->
            <?php
            } //Industrial Panel PC end


            //Industrial Motherboard
            $str61="SELECT a.ProductTypeID,a.MODELCODE,a.STATUS,a.Product_Info,a.SKU,a.Product_SContents_Auto_ID,a.ProductSFile,a.IsnewUp,b.IS_EOL,b.IS_BTO FROM contents_product_skus a inner join (SELECT Product_SKU_Auto_ID,MODELCODE,SKU,IS_EOL,IS_BTO FROM product_skus) b on a.Product_SContents_Auto_ID=b.Product_SKU_Auto_ID inner join spdescription_list c ON b.SKU=c.NAME ";
            $str61.=" WHERE (a.ProductTypeID_SKU=109) AND ((Replace(a.MODELCODE,'-','') like '%".str_replace('-','',$sear_txt)."%' ) OR Replace(a.SKU,'-','') like '%".str_replace(' ','%',$sear_txt)."%' OR (c.DESCS like '%".str_replace(' ','%',$sear_txt)."%' OR c.smmarys like '%".str_replace(' ','%',$sear_txt)."%') ) AND (a.slang='".$PLang_si01.",') AND a.STATUS='1' ";
            $str61.=" order by a.crea_d desc";

            mysqli_query($link_db, 'SET NAMES utf8');
            $cmd61=mysqli_query($link_db,$str61);
            $Data_record61_num=mysqli_num_rows($cmd61);
            if($Data_record61_num==0 || $sear_txt==""){
              $Data_record61_exist="true";
            }else{
            ?>
            <!--one product type card-->
            <div class="card mb-5">
              <div class="card-body">
                <h1 class="card-title">Industrial Motherboard</h1>
                <table class="table table-striped table-hover">
                  <tbody>
                    <?php
                    $str61_val="";$IndustrialMB_url="";
                    while($data61=mysqli_fetch_array($cmd61, MYSQLI_NUM)){//常數狀態 MYSQLI_ASSOC, MYSQLI_NUM, and MYSQLI_BOTH
                      $MCODE61=$data61[1];
                      $SKUs61=$data61[4];
                      $IMG61=$data61[6];
                      $IsnewUp61=$data61[7];
                      $IsEol61=$data61[8];
                      $IsBTO61=$data61[9];
                      if($PLang_si01=="EN" || $PLang_si01==""){

                        $str_pdesc="SELECT `ID`, `NAME`, `DESCS`, `LANG`, `MODEL`, `STATUS` FROM `spdescription_list` where concat(',',`MODEL`) like '%".$SKUs61.",%' and `STATUS`=1 and LANG = '$PLang_si'";//原條件是$MCODE61
                        $pdesc_cmd=mysqli_query($link_db,$str_pdesc);
                        $pdesc_data=mysqli_fetch_row($pdesc_cmd);
                        if($pdesc_data==true){
                          if($pdesc_data[2]=="" || $pdesc_data[2]=="NULL"){
                            $IndustrialMB_url="IndustrialMotherboard_".$MCODE61."_".$SKUs61;
                          } else {
                            $IndustrialMB_url="IndustrialMotherboard_".$MCODE61."_".$SKUs61;
                          }

                        }else{
                          $IndustrialMB_url="IndustrialMotherboard_".$MCODE61."_".$SKUs61;
                        } 

                      }else if($PLang_si01=="CN" || $PLang_si01=="JP" || $PLang_si01=="ZH"){
                      }
                      ?>
                      <tr onclick="javascript:self.location='./<?=rawurlencode($IndustrialMB_url);?>'">
                        <!--<td><img class="media-object" src="<?=str_replace('~','.',"./images/jbod/".$IMG61);?>" alt="<?=$SKUs61;?>"></td>-->
                        <td><a href="<?=rawurlencode($IndustrialMB_url);?>"><?=$MCODE61;?> / <?=$SKUs61;?></a> &nbsp;
                          <?php 
                          if($IsnewUp61=='1'){
                            echo "<span class='badge bg-danger'>NEW!</span>&nbsp;";
                          }
                          if($IsEol61=='1'){
                            echo "<span class='badge bg-secondary'>EOL</span>&nbsp;";
                          }
                          if($IsBTO61=='1'){
                             if($IsEol61=='1'){
                            }else{
                              echo "<span class='badge bg-primary'>BTO</span>&nbsp;";
                            }
                          }
                          ?>
                        </td> 
                      </tr>
                    <?php
                    }
                    ?>    
                  </tbody>
                </table>
              </div>
            </div>
            <!--end one product type card-->
            <?php
            }// Industrial Motherboard end

            //OCP Server
            $str81="SELECT a.ProductTypeID,a.MODELCODE,a.STATUS,a.Product_Info,a.SKU,a.Product_SContents_Auto_ID,a.ProductSFile,a.IsnewUp,b.IS_EOL,a.ProductTypeID,b.IS_BTO ";
            $str81.=" FROM contents_product_skus a inner join (SELECT Product_SKU_Auto_ID,MODELCODE,SKU,IS_EOL,IS_BTO FROM product_skus) b on a.Product_SContents_Auto_ID=b.Product_SKU_Auto_ID inner join spdescription_list c ON b.SKU=c.NAME ";
            $str81.=" WHERE (a.ProductTypeID_SKU=110) AND ((Replace(a.MODELCODE,'-','') like '%".str_replace('-','',$sear_txt)."%' ) OR Replace(a.SKU,'-','') like '%".str_replace(' ','%',$sear_txt)."%' OR (c.DESCS like '%".str_replace(' ','%',$sear_txt)."%' OR c.smmarys like '%".str_replace(' ','%',$sear_txt)."%') ) AND (a.slang='".$PLang_si01.",') AND a.STATUS='1' ";
            $str81.=" order by a.crea_d desc";

            mysqli_query($link_db, 'SET NAMES utf8');
            $cmd81=mysqli_query($link_db,$str81);
            $Data_record81_num=mysqli_num_rows($cmd81);
            if($Data_record81_num==0 || $sear_txt==""){
              $Data_record81_exist="true";
            }else{
            ?>
            <!--one product type card-->
            <div class="card mb-5">
              <div class="card-body">
                <h1 class="card-title">OCP Server</h1>
                <table class="table table-striped table-hover">
                  <tbody>
                    <?php
                    $str81_val="";$ocpServer_url="";
                    while($data81=mysqli_fetch_array($cmd81, MYSQLI_NUM)){//常數狀態 MYSQLI_ASSOC, MYSQLI_NUM, and MYSQLI_BOTH
                      $MCODE81=$data81[1];
                      $SKUs81=$data81[4];
                      $IMG81=$data81[6];
                      $IsnewUp81=$data81[7];
                      $IsEol81=$data81[8];
                      $IsBTO81=$data81[10];
                      if($PLang_si01=="EN" || $PLang_si01==""){

                        $str_pdesc="SELECT `ID`, `NAME`, `DESCS`, `LANG`, `MODEL`, `STATUS` FROM `spdescription_list` where concat(',',`MODEL`) like '%".$SKUs81.",%' and `STATUS`=1 and LANG = '$PLang_si'";//原條件是$MCODE61
                        $pdesc_cmd=mysqli_query($link_db,$str_pdesc);
                        $pdesc_data=mysqli_fetch_row($pdesc_cmd);
                        if($pdesc_data==true){
                          if($pdesc_data[2]=="" || $pdesc_data[2]=="NULL"){
                            $ocpServer_url="OCPserver_".$MCODE81."_".$SKUs81;
                          } else {
                            $ocpServer_url="OCPserver=".$MCODE81."=".$SKUs81."=description=EN";
                          }

                        }else{
                          $ocpServer_url="OCPserver_".$MCODE81."_".$SKUs81;
                        } 

                      }else if($PLang_si01=="CN" || $PLang_si01=="JP" || $PLang_si01=="ZH"){
                      }

                    ?>
                    <tr onclick="javascript:self.location='./<?=rawurlencode($ocpServer_url);?>'">
                      <!--<td><img class="media-object" src="<?=str_replace('~','.',"./images/jbod/".$IMG81);?>" alt="<?=$SKUs81;?>"></td>-->
                      <td><a href="<?=rawurlencode($ocpServer_url);?>"><?=$MCODE81;?> / <?=$SKUs81;?></a> &nbsp;
                        <?php 
                        if($IsnewUp81=='1'){
                          echo "<span class='badge bg-danger'>NEW!</span>&nbsp;";
                        }
                        if($IsEol81=='1'){
                          echo "<span class='badge bg-secondary'>EOL</span>&nbsp;";
                        }
                        if($IsBTO81=='1'){
                          if($IsEol81=='1'){
                          }else{
                            echo "<span class='badge bg-primary'>BTO</span>&nbsp;";
                          }
                        }
                        ?>
                      </td>
                    </tr>
                    <?php
                    }
                    ?>    
                  </tbody>
                </table>
              </div>
            </div>
            <!--end one product type card-->
            <?php
            }// OCP Server end

            //OCP Mezz.
            $str91="SELECT a.ProductTypeID,a.MODELCODE,a.STATUS,a.Product_Info,a.SKU,a.Product_SContents_Auto_ID,a.ProductSFile,a.IsnewUp,b.IS_EOL,a.ProductTypeID,b.IS_BTO ";
            $str91.=" FROM contents_product_skus a inner join (SELECT Product_SKU_Auto_ID,MODELCODE,SKU,IS_EOL,IS_BTO FROM product_skus) b on a.Product_SContents_Auto_ID=b.Product_SKU_Auto_ID inner join spdescription_list c ON b.SKU=c.NAME ";
            $str91.=" WHERE (a.ProductTypeID_SKU=111) AND ((Replace(a.MODELCODE,'-','') like '%".str_replace('-','',$sear_txt)."%' ) OR Replace(a.SKU,'-','') like '%".str_replace(' ','%',$sear_txt)."%' OR (c.DESCS like '%".str_replace(' ','%',$sear_txt)."%' OR c.smmarys like '%".str_replace(' ','%',$sear_txt)."%') ) AND (a.slang='".$PLang_si01.",') AND a.STATUS='1' ";
            $str91.=" order by a.crea_d desc";

            mysqli_query($link_db, 'SET NAMES utf8');

            $cmd91=mysqli_query($link_db,$str91);
            $Data_record91_num=mysqli_num_rows($cmd91);
            if($Data_record91_num==0 || $sear_txt==""){
              $Data_record91_exist="true";
            }else{
            ?>
            <!--one product type card-->
            <div class="card mb-5">
              <div class="card-body">
                <h1 class="card-title">OCP Mezz</h1>
                <table class="table table-striped table-hover">
                  <tbody>
                    <?php
                    $str91_val="";$Jbod_url="";

                    while($data91=mysqli_fetch_array($cmd91, MYSQLI_NUM)){//常數狀態 MYSQLI_ASSOC, MYSQLI_NUM, and MYSQLI_BOTH
                      $MCODE91=$data91[1];
                      $SKUs91=$data91[4];
                      $IMG91=$data91[6];
                      $IsnewUp91=$data91[7];
                      $IsEol91=$data91[8];
                      $IsEol91=$data91[10];
                      if($PLang_si01=="EN" || $PLang_si01==""){

                        $str_pdesc="SELECT `ID`, `NAME`, `DESCS`, `LANG`, `MODEL`, `STATUS` FROM `spdescription_list` where concat(',',`MODEL`) like '%".$SKUs91.",%' and `STATUS`=1 and LANG = '$PLang_si'";//原條件是$MCODE61
                        $pdesc_cmd=mysqli_query($link_db,$str_pdesc);
                        $pdesc_data=mysqli_fetch_row($pdesc_cmd);
                        if($pdesc_data==true){
                          if($pdesc_data[2]=="" || $pdesc_data[2]=="NULL"){
                            $ocpmezz_url="OCPMezz_".$MCODE91."_".$SKUs91;
                          } else {
                            $ocpmezz_url="OCPMezz=".$MCODE91."=".$SKUs91."=description=EN";
                          }   
                        }else{
                          $ocpmezz_url="OCPMezz_".$MCODE91."_".$SKUs91;
                        } 

                      }
                      ?>
                      <tr onclick="javascript:self.location='./<?=rawurlencode($ocpmezz_url);?>'">
                        <!--<td><img class="media-object" src="<?=str_replace('~','.',"./images/jbod/".$IMG91);?>" alt="<?=$SKUs91;?>"></td>-->
                        <td><a href="<?=rawurlencode($ocpmezz_url);?>"><?=$MCODE91;?> / <?=$SKUs91;?></a> &nbsp;
                          <?php 
                          if($IsnewUp91=='1'){
                            echo "<span class='badge bg-danger'>NEW!</span>&nbsp;";
                          }
                          if($IsEol91=='1'){
                            echo "<span class='badge bg-secondary'>EOL</span>&nbsp;";
                          }
                          if($IsBTO91=='1'){
                            if($IsEol91=='1'){
                            }else{
                              echo "<span class='badge bg-primary'>BTO</span>&nbsp;";
                            }
                          }

                          ?>
                        </td>
                      </tr>
                      <?php
                      }
                      ?>    
                  </tbody>
                </table>
              </div>
            </div>
            <!--end one product type card-->
            <?php
            }// OCP Mezz. end

            //JBOD / JBOF.
            $str101="SELECT a.ProductTypeID,a.MODELCODE,a.STATUS,a.Product_Info,a.SKU,a.Product_SContents_Auto_ID,a.ProductSFile,a.IsnewUp,b.IS_EOL,a.ProductTypeID,b.IS_BTO ";
            $str101.=" FROM contents_product_skus a inner join (SELECT Product_SKU_Auto_ID,MODELCODE,SKU,IS_EOL,IS_BTO FROM product_skus) b on a.Product_SContents_Auto_ID=b.Product_SKU_Auto_ID inner join spdescription_list c ON b.SKU=c.NAME ";
            $str101.=" WHERE (a.ProductTypeID_SKU=112) AND ((Replace(a.MODELCODE,'-','') like '%".str_replace('-','',$sear_txt)."%' ) OR Replace(a.SKU,'-','') like '%".str_replace(' ','%',$sear_txt)."%' OR (c.DESCS like '%".str_replace(' ','%',$sear_txt)."%' OR c.smmarys like '%".str_replace(' ','%',$sear_txt)."%') ) AND (a.slang='".$PLang_si01.",') AND a.STATUS='1' ";
            $str101.=" order by a.crea_d desc";

            mysqli_query($link_db, 'SET NAMES utf8');

            $cmd101=mysqli_query($link_db,$str101);
            $Data_record101_num=mysqli_num_rows($cmd101);
            //mysqli_data_seek($cmd61, $Data_record61_num-1);
            if($Data_record101_num==0 || $sear_txt==""){
              $Data_record101_exist="true";
            }else{
            ?>
            <!--one product type card-->
            <div class="card mb-5">
              <div class="card-body">
                <h1 class="card-title">JBOD / JBOF</h1>
                <table class="table table-striped table-hover">
                  <tbody>
                    <?php
                    $str101_val="";$jbodjbof_url="";

                    while($data101=mysqli_fetch_array($cmd101, MYSQLI_NUM)){//常數狀態 MYSQLI_ASSOC, MYSQLI_NUM, and MYSQLI_BOTH
                      $MCODE101=$data101[1];
                      $SKUs101=$data101[4];
                      $IMG101=$data101[6];
                      $IsnewUp101=$data101[7];
                      $IsEol101=$data101[8];
                      $IsBTO101=$data101[10];
                      if($PLang_si01=="EN" || $PLang_si01==""){

                        $str_pdesc="SELECT `ID`, `NAME`, `DESCS`, `LANG`, `MODEL`, `STATUS` FROM `spdescription_list` where concat(',',`MODEL`) like '%".$SKUs101.",%' and `STATUS`=1 and LANG = '$PLang_si'";//原條件是$MCODE61
                        $pdesc_cmd=mysqli_query($link_db,$str_pdesc);
                        $pdesc_data=mysqli_fetch_row($pdesc_cmd);
                        if($pdesc_data==true){
                          if($pdesc_data[2]=="" || $pdesc_data[2]=="NULL"){
                            $jbodjbof_url="JBODJBOF_".$MCODE101."_".$SKUs101;
                          } else {
                            $jbodjbof_url="JBODJBOF=".$MCODE101."=".$SKUs101."=description=EN";
                          }   
                        }else{
                          $jbodjbof_url="JBODJBOF_".$MCODE101."_".$SKUs101;
                        } 

                      }
                    ?>
                    <tr onclick="javascript:self.location='./<?=rawurlencode($jbodjbof_url);?>'">
                      <!--<td><img class="media-object" src="<?=str_replace('~','.',"./images/jbod/".$IMG101);?>" alt="<?=$SKUs101;?>"></td>-->
                      <td><a href="<?=rawurlencode($jbodjbof_url);?>"><?=$MCODE101;?> / <?=$SKUs101;?></a> &nbsp;
                        <?php 
                        if($IsnewUp101=='1'){
                           echo "<span class='badge bg-danger'>NEW!</span>&nbsp;";
                        }
                        if($IsEol101=='1'){
                          echo "<span class='badge bg-secondary'>EOL</span>&nbsp;";
                        }
                        if($IsBTO101=='1'){
                          if($IsEol101=='1'){
                          }else{
                            echo "<span class='badge bg-primary'>BTO</span>&nbsp;";
                          }
                        }
                        ?>
                      </td>
                    </tr>
                    <?php
                    }
                    ?>    
                  </tbody>
                </table>
              </div>
            </div>
            <!--end one product type card-->
            <?php
            }// JBOD / JBOF. end

            //OCP Rack.
            $str111="SELECT a.ProductTypeID,a.MODELCODE,a.STATUS,a.Product_Info,a.SKU,a.Product_SContents_Auto_ID,a.ProductSFile,a.IsnewUp,b.IS_EOL,a.ProductTypeID ";
            $str111.=" FROM contents_product_skus a inner join (SELECT Product_SKU_Auto_ID,MODELCODE,IS_EOL FROM product_skus) b on a.Product_SContents_Auto_ID=b.Product_SKU_Auto_ID inner join spdescription_list c ON b.MODELCODE=c.NAME ";
            $str111.=" WHERE (a.ProductTypeID_SKU=113) AND ((Replace(a.MODELCODE,'-','') like '%".str_replace('-','',$sear_txt)."%' ) OR Replace(a.SKU,'-','') like '%".str_replace(' ','%',$sear_txt)."%' OR (c.DESCS like '%".str_replace(' ','%',$sear_txt)."%' OR c.smmarys like '%".str_replace(' ','%',$sear_txt)."%') ) AND (a.slang='".$PLang_si01.",') AND a.STATUS='1' ";
            $str111.=" order by a.crea_d desc";

            mysqli_query($link_db, 'SET NAMES utf8');

            $cmd111=mysqli_query($link_db,$str111);
            $Data_record111_num=mysqli_num_rows($cmd111);
            if($Data_record111_num==0 || $sear_txt==""){
              $Data_record111_exist="true";
            }else{
            ?>
            <!--one product type card-->
            <div class="card mb-5">
              <div class="card-body">
                <h1 class="card-title">OCP Rack</h1>
                <table class="table table-striped table-hover">
                  <tbody>
                    <?php
                    $str101_val="";$ocprack_url="";

                    while($data111=mysqli_fetch_array($cmd111, MYSQLI_NUM)){//常數狀態 MYSQLI_ASSOC, MYSQLI_NUM, and MYSQLI_BOTH
                      $MCODE111=$data111[1];
                      $SKUs111=$data111[4];
                      $IMG111=$data111[6];
                      $IsnewUp111=$data111[7];
                      $IsEol111=$data111[8];
                      if($PLang_si01=="EN" || $PLang_si01==""){

                        $str_pdesc="SELECT `ID`, `NAME`, `DESCS`, `LANG`, `MODEL`, `STATUS` FROM `spdescription_list` where concat(',',`MODEL`) like '%".$SKUs111.",%' and `STATUS`=1 and LANG = '$PLang_si'";//原條件是$MCODE61
                        $pdesc_cmd=mysqli_query($link_db,$str_pdesc);
                        $pdesc_data=mysqli_fetch_row($pdesc_cmd);
                        if($pdesc_data==true){
                          if($pdesc_data[2]=="" || $pdesc_data[2]=="NULL"){
                            $ocprack_url="OCPRack_".$MCODE111."_".$SKUs111;
                          } else {
                            $ocprack_url="OCPRack=".$MCODE111."=".$SKUs111."=description=EN";
                          }   
                        }else{
                          $ocprack_url="OCPRack".$MCODE111."_".$SKUs111;
                        } 

                      }
                    ?>
                    <tr onclick="javascript:self.location='./<?=rawurlencode($ocprack_url);?>'">
                      <!--<td><img class="media-object" src="<?=str_replace('~','.',"./images/jbod/".$IMG111);?>" alt="<?=$SKUs111;?>"></td>-->
                      <td><a href="<?=rawurlencode($ocprack_url);?>"><?=$MCODE111;?> / <?=$SKUs111;?></a> &nbsp;
                        <?php 
                        if($IsnewUp111=='1'){
                           echo "<span class='badge bg-danger'>NEW!</span>&nbsp;";
                        }
                        if($IsEol111=='1'){
                          echo "<span class='badge bg-secondary'>EOL</span>&nbsp;";
                        }
                        ?>
                      </td>
                    </tr>
                    <?php
                    }
                    ?>    
                  </tbody>
                </table>
              </div>
            </div>
            <!--end one product type card-->
            <?php
            }// OCP Rack. end

            //POS.
            $str112="SELECT a.ProductTypeID,a.MODELCODE,a.STATUS,a.Product_Info,a.SKU,a.Product_SContents_Auto_ID,a.ProductSFile,a.IsnewUp,b.IS_EOL,a.ProductTypeID ";
            $str112.=" FROM contents_product_skus a inner join (SELECT Product_SKU_Auto_ID,MODELCODE,IS_EOL FROM product_skus) b on a.Product_SContents_Auto_ID=b.Product_SKU_Auto_ID inner join spdescription_list c ON b.MODELCODE=c.NAME ";
            $str112.=" WHERE (a.ProductTypeID_SKU=114) AND ((Replace(a.MODELCODE,'-','') like '%".str_replace('-','',$sear_txt)."%' ) OR Replace(a.SKU,'-','') like '%".str_replace(' ','%',$sear_txt)."%' OR (c.DESCS like '%".str_replace(' ','%',$sear_txt)."%' OR c.smmarys like '%".str_replace(' ','%',$sear_txt)."%') ) AND (a.slang='".$PLang_si01.",') AND a.STATUS='1' ";
            $str112.=" order by a.crea_d desc";

            mysqli_query($link_db, 'SET NAMES utf8');

            $cmd112=mysqli_query($link_db,$str112);
            $Data_record112_num=mysqli_num_rows($cmd112);
            if($Data_record112_num==0 || $sear_txt==""){
              $Data_record112_exist="true";
            }else{
            ?>
            <!--one product type card-->
            <div class="card mb-5">
              <div class="card-body">
                <h1 class="card-title">POS</h1>
                <table class="table table-striped table-hover">
                  <tbody>
                    <?php
                    $str101_val="";$pos_url="";

                    while($data112=mysqli_fetch_array($cmd112, MYSQLI_NUM)){//常數狀態 MYSQLI_ASSOC, MYSQLI_NUM, and MYSQLI_BOTH
                      $MCODE112=$data112[1];
                      $SKUs112=$data112[4];
                      $IMG112=$data112[6];
                      $IsnewUp112=$data112[7];
                      $IsEol112=$data112[8];
                      if($PLang_si01=="EN" || $PLang_si01==""){

                        $str_pdesc="SELECT `ID`, `NAME`, `DESCS`, `LANG`, `MODEL`, `STATUS` FROM `spdescription_list` where concat(',',`MODEL`) like '%".$SKUs112.",%' and `STATUS`=1 and LANG = '$PLang_si'";//原條件是$MCODE61
                        $pdesc_cmd=mysqli_query($link_db,$str_pdesc);
                        $pdesc_data=mysqli_fetch_row($pdesc_cmd);
                        if($pdesc_data==true){
                          if($pdesc_data[2]=="" || $pdesc_data[2]=="NULL"){
                            $pos_url="POS_".$MCODE112."_".$SKUs112;
                          } else {
                            $pos_url="POS=".$MCODE112."=".$SKUs112."=description=EN";
                          }   
                        }else{
                          $pos_url="POS_".$MCODE112."_".$SKUs112;
                        } 

                      }
                    ?>
                    <tr onclick="javascript:self.location='./<?=rawurlencode($pos_url);?>'">
                      <!--<td><img class="media-object" src="<?=str_replace('~','.',"./images/jbod/".$IMG112);?>" alt="<?=$SKUs112;?>"></td>-->
                      <td><a href="<?=rawurlencode($pos_url);?>"><?=$MCODE112;?> / <?=$SKUs112;?></a> &nbsp;
                        <?php 
                        if($IsnewUp112=='1'){
                           echo "<span class='badge bg-danger'>NEW!</span>&nbsp;";
                        }
                        if($IsEol112=='1'){
                          echo "<span class='badge bg-secondary'>EOL</span>&nbsp;";
                        }
                        ?>
                      </td>
                    </tr>
                    <?php
                    }
                    ?>    
                  </tbody>
                </table>
              </div>
            </div>
            <!--end one product type card-->
            <?php
            }// POS. end

            //5G Edge Computing.
            $str113="SELECT a.ProductTypeID,a.MODELCODE,a.STATUS,a.Product_Info,a.SKU,a.Product_SContents_Auto_ID,a.ProductSFile,a.IsnewUp,b.IS_EOL,a.ProductTypeID ";
            $str113.=" FROM contents_product_skus a inner join (SELECT Product_SKU_Auto_ID,MODELCODE,IS_EOL FROM product_skus) b on a.Product_SContents_Auto_ID=b.Product_SKU_Auto_ID inner join spdescription_list c ON b.MODELCODE=c.NAME ";
            $str113.=" WHERE (a.ProductTypeID_SKU=115) AND ((Replace(a.MODELCODE,'-','') like '%".str_replace('-','',$sear_txt)."%' ) OR Replace(a.SKU,'-','') like '%".str_replace(' ','%',$sear_txt)."%' OR (c.DESCS like '%".str_replace(' ','%',$sear_txt)."%' OR c.smmarys like '%".str_replace(' ','%',$sear_txt)."%') ) AND (a.slang='".$PLang_si01.",') AND a.STATUS='1' ";
            $str113.=" order by a.crea_d desc";

            mysqli_query($link_db, 'SET NAMES utf8');

            $cmd113=mysqli_query($link_db,$str113);
            $Data_record113_num=mysqli_num_rows($cmd113);
            if($Data_record113_num==0 || $sear_txt==""){
              $Data_record113_exist="true";
            }else{
            ?>
            <!--one product type card-->
            <div class="card mb-5">
              <div class="card-body">
                <h1 class="card-title">5G Edge Computing</h1>
                <table class="table table-striped table-hover">
                  <tbody>
                    <?php
                    $str101_val="";$pos_url="";

                    while($data113=mysqli_fetch_array($cmd113, MYSQLI_NUM)){//常數狀態 MYSQLI_ASSOC, MYSQLI_NUM, and MYSQLI_BOTH
                      $MCODE113=$data113[1];
                      $SKUs113=$data113[4];
                      $IMG113=$data113[6];
                      $IsnewUp113=$data113[7];
                      $IsEol113=$data113[8];
                      if($PLang_si01=="EN" || $PLang_si01==""){

                        $str_pdesc="SELECT `ID`, `NAME`, `DESCS`, `LANG`, `MODEL`, `STATUS` FROM `spdescription_list` where concat(',',`MODEL`) like '%".$SKUs113.",%' and `STATUS`=1 and LANG = '$PLang_si'";//原條件是$MCODE61
                        $pdesc_cmd=mysqli_query($link_db,$str_pdesc);
                        $pdesc_data=mysqli_fetch_row($pdesc_cmd);
                        if($pdesc_data==true){
                          if($pdesc_data[2]=="" || $pdesc_data[2]=="NULL"){
                            $pos_url="5GEdgeComputing_".$MCODE113."_".$SKUs113;
                          } else {
                            $pos_url="5GEdgeComputing_=".$MCODE113."=".$SKUs113."=description=EN";
                          }   
                        }else{
                          $pos_url="5GEdgeComputing_".$MCODE113."_".$SKUs113;
                        } 

                      }
                    ?>
                    <tr onclick="javascript:self.location='./<?=rawurlencode($pos_url);?>'">
                      <!--<td><img class="media-object" src="<?=str_replace('~','.',"./images/jbod/".$IMG113);?>" alt="<?=$SKUs113;?>"></td>-->
                      <td><a href="<?=rawurlencode($pos_url);?>"><?=$MCODE113;?> / <?=$SKUs113;?></a> &nbsp;
                        <?php 
                        if($IsnewUp113=='1'){
                           echo "<span class='badge bg-danger'>NEW!</span>&nbsp;";
                        }
                        if($IsEol113=='1'){
                          echo "<span class='badge bg-secondary'>EOL</span>&nbsp;";
                        }
                        ?>
                      </td>
                    </tr>
                    <?php
                    }
                    ?>    
                  </tbody>
                </table>
              </div>
            </div>
            <!--end one product type card-->
            <?php
            }// 5G Edge Computing. end

          } //if else $Data_record_check end
          ?>
        </div>


        <?php
        //Press Release
        $strPR="SELECT ID, TITLE, CONTENT, NEWSDATE, STATUS, Redirect FROM nr_pressroom WHERE CONTENT like '%".$sear_txt."%' AND STATUS='1'";
        $cmdPR=mysqli_query($link_db,$strPR);
        $Data_PR_num=mysqli_num_rows($cmdPR);
        if($Data_PR_num==0 || $sear_txt==""){
          $Data_PR_exist="true";
        }else{
        ?>
        <div class="col-6">
          <!--press release  card-->
          <div class="card mb-5">
            <div class="card-body">
              <h1 class="card-title">Press Release</h1>
              <table class="table table-striped table-hover">
                <tbody>
                  <?php     
                  $cmdPR=mysqli_query($link_db,$strPR);
                  while($dataPR=mysqli_fetch_row($cmdPR)){//常數狀態 MYSQLI_ASSOC, MYSQLI_NUM, and MYSQLI_BOTH
                    $id=$dataPR[0];
                    $title=$dataPR[1];
                    $NEWSDATE=explode(" ", $dataPR[3]);
                    $Redirect=$dataPR[5];
                  ?>
                  <tr >
                    <?php
                    if($Redirect!=""){
                    ?>
                    <td><?=$NEWSDATE[0];?></td><td><a href="en-US@<?=$Redirect;?>~PRDetail" /><?=$title;?></a></td>
                    <?php
                    }else{
                    ?>
                    <td><?=$NEWSDATE[0];?></td><td><a href="en-US@<?=$id;?>~PRDetail" /><?=$title;?></a></td>
                    <?php
                    }
                    ?>
                  </tr>
                  <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <!--end press release  card-->
        </div>
        <?php
        }

        if(($Data_record41_exist=="true" && $Data_record51_exist=="true" && $Data_record61_exist=="true" && $Data_record81_exist=="true" && $Data_record91_exist=="true" && $Data_record101_exist=="true" && $Data_record111_exist=="true" && $Data_record112_exist=="true" && $Data_record113_exist=="true" && $Data_PR_exist=="true") || $Data_record_check=="true"){
        ?>
        <!--search result alert-->
        <div class="alert alert-danger">Sorry. We can't find anything for your search.</div>
        <!--end search result alert-->
        <?php
        }
        ?>

      </div>
    </div><!--end container-->

    <div class="clear mb-6"></div>





















    <!-- FOOTER -->	  
    <?php
    include("foot1.htm");
    ?>
    <!-- FOOTER end -->	  

  </div><!-- #wrapper end -->

<!-- Go To Top
  ============================================= -->
  <div id="gotoTop" class="icon-line-arrow-up"></div>

<!-- JavaScripts
  ============================================= -->

  <script src="js1/plugins.min.js"></script>

<!-- Footer Scripts
  ============================================= -->
  <script src="js1/functions.js"></script>

  <!-- ADD-ONS JS FILES -->

  <script src="js1/catalog.js"></script>
  <script src="js1/top.js"></script>


</body>
</html>