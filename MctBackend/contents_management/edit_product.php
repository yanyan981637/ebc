<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 0);

@session_start();
if(empty($_SESSION['user']) || empty($_SESSION['login_time'])){
echo "<script language='JavaScript'>location='../login.php'</script>";
exit();
}

require "../config.php";
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase);

if(isset($_REQUEST['methods'])!=''){
if(trim($_REQUEST['methods'])=='upd_pro'){

if(isset($_REQUEST['s_search'])!=''){
$spage="?s_search=".trim($_REQUEST['s_search']);
}else{
$spage="";
}
if(isset($_POST['pid01'])!=''){
$pid01=intval($_POST['pid01']);
}else{
$pid01=1;
}
if(isset($_POST['lang01'])!=''){
  $lang01=trim($_POST['lang01']);

  if($lang01=="EN," || $lang01==""){
	  $PLang_si01="EN";
	  $PLang_si="en-US";
	  $Top_Block="<?php include('../top.htm'); ?>";
	  $Foot_Block="<?php include('../foot.htm'); ?>";
	  $memo_PType="<?php include('../PT_Sorting.htm'); ?>";
  }else if($lang01=="JP,"){
	  $PLang_si01="JP";
	  $PLang_si="ja-JP";
	  $Top_Block="<?php include('../top_jp.htm'); ?>";
	  $Foot_Block="<?php include('../foot_jp.htm'); ?>";
	  $memo_PType="<?php include('../PT_Sorting_jp.htm'); ?>";
  }else if($lang01=="CN,"){
	  $PLang_si01="CN";
	  $PLang_si="zh-CN";
	  $Top_Block="<?php include('../top_cn.htm'); ?>";
	  $Foot_Block="<?php include('../foot_cn.htm'); ?>";
	  $memo_PType="<?php include('../PT_Sorting_cn.htm'); ?>";
  }else if($lang01=="ZH,"){
	  $PLang_si01="ZH";
	  $PLang_si="zh-TW";
	  $Top_Block="<?php include('../top_zh.htm'); ?>";
	  $Foot_Block="<?php include('../foot_zh.htm'); ?>";
	  $memo_PType="<?php include('../PT_Sorting_zh.htm'); ?>";
  }

}else{
$lang01="";
}
$SEL_PTYPE="";$categ_val="";
if(isset($_POST['SEL_PTYPE'])!=''){
$SEL_PTYPE=intval($_POST['SEL_PTYPE']);
}

if(isset($_POST['categ_val'])!=''){
$categ_val=trim($_POST['categ_val']);
}else{
$categ_val=0;
}
if(isset($_POST['cate_pinfo01'])!=''){
$cate_pinfo01=trim($_POST['cate_pinfo01']);
}else{
$cate_pinfo01="";
}
if(isset($_POST['SKU_value'])!=''){
$SKU_value=trim($_POST['SKU_value']);
}else{
$SKU_value="";
}
$Model_value=trim($_POST['Model_value']);
$stat01=trim($_POST['stat01']);
if($stat01==1){
$sku_stat01=0;
}else if($stat01==0){
$sku_stat01=1;
}
if(isset($_POST['new_logo'])!=''){
$new_logo01=trim($_POST['new_logo']);
}else{
$new_logo01='0';
}
if(isset($_POST['comingSoon'])!=''){
$comingSoon=trim($_POST['comingSoon']);
}else{
$comingSoon='0';
}
$iconvals=trim($_POST['iconvals']);
$iconvals_b=trim($_POST['iconvals_b']);
//$desc=trim($_POST['desc']);
$desc=str_replace("'","''",trim($_POST['desc']));
$LandTitle=str_replace("'","''",trim($_POST['LandTitle']));
$relate_enable=trim($_POST['relate_enable']);
$relProd_val=trim($_POST['relProd_val']);
$compat_enable=trim($_POST['compat_enable']);
$compacProd_val=trim($_POST['compacProd_val']);


$str_lang="";
if(isset($_POST['aproLang'])){
foreach($_POST['aproLang'] as $aproLang01){
 $str_lang=$str_lang.$aproLang01.",";
}
}else{
 $str_lang="";
}
$PINFO_list="";
if(isset($_POST['PINFO_Val'])!=''){
  foreach($_POST['PINFO_Val'] as $PINFO_Val01){
   $PINFO_list=$PINFO_list.$PINFO_Val01.",";
  }
}else{
   $PINFO_list="";
}

$PT1="";
// table : producttypes
if($SEL_PTYPE==1){
 if(strpos(",".$PINFO_list,",2,")!='' || strpos(",".$PINFO_list,",2,")===0 || strpos(",".$PINFO_list,",157,")!='' || strpos(",".$PINFO_list,",157,")===0 || strpos(",".$PINFO_list,",202,")!='' || strpos(",".$PINFO_list,",202,")===0 || strpos(",".$PINFO_list,",235,")!='' || strpos(",".$PINFO_list,",235,")===0){
 $PT1=101;
 }else if(strpos(",".$PINFO_list,",1,")!='' || strpos(",".$PINFO_list,",1,")===0 || strpos(",".$PINFO_list,",156,")!='' || strpos(",".$PINFO_list,",156,")===0 || strpos(",".$PINFO_list,",201,")!='' || strpos(",".$PINFO_list,",201,")===0 || strpos(",".$PINFO_list,",234,")!='' || strpos(",".$PINFO_list,",234,")===0){
 $PT1=102;
 }else if(strpos(",".$PINFO_list,",200,")!='' || strpos(",".$PINFO_list,",200,")===0 || strpos(",".$PINFO_list,",204,")!='' || strpos(",".$PINFO_list,",204,")===0 || strpos(",".$PINFO_list,",203,")!='' || strpos(",".$PINFO_list,",203,")===0 || strpos(",".$PINFO_list,",236,")!='' || strpos(",".$PINFO_list,",236,")===0){
 $PT1=108;
 }
}else if($SEL_PTYPE==2){
 if(strpos(",".$PINFO_list,",2,")!='' || strpos(",".$PINFO_list,",2,")===0 || strpos(",".$PINFO_list,",157,")!='' || strpos(",".$PINFO_list,",157,")===0 || strpos(",".$PINFO_list,",202,")!='' || strpos(",".$PINFO_list,",202,")===0 || strpos(",".$PINFO_list,",235,")!='' || strpos(",".$PINFO_list,",235,")===0){
 $PT1=103;
 }else if(strpos(",".$PINFO_list,",1,")!='' || strpos(",".$PINFO_list,",1,")===0 || strpos(",".$PINFO_list,",156,")!='' || strpos(",".$PINFO_list,",156,")===0 || strpos(",".$PINFO_list,",201,")!='' || strpos(",".$PINFO_list,",201,")===0 || strpos(",".$PINFO_list,",234,")!='' || strpos(",".$PINFO_list,",234,")===0){
 $PT1=104;
 }else if(strpos(",".$PINFO_list,",200,")!='' || strpos(",".$PINFO_list,",200,")===0 || strpos(",".$PINFO_list,",204,")!='' || strpos(",".$PINFO_list,",204,")===0 || strpos(",".$PINFO_list,",203,")!='' || strpos(",".$PINFO_list,",203,")===0 || strpos(",".$PINFO_list,",236,")!='' || strpos(",".$PINFO_list,",236,")===0){
 $PT1=108;
 }
}else if($SEL_PTYPE==3){
 if(strpos(",".$PINFO_list,",18,")!='' || strpos(",".$PINFO_list,",18,")===0 || strpos(",".$PINFO_list,",165,")!='' || strpos(",".$PINFO_list,",165,")===0 || strpos(",".$PINFO_list,",212,")!='' || strpos(",".$PINFO_list,",212,")===0 || strpos(",".$PINFO_list,",244,")!='' || strpos(",".$PINFO_list,",244,")===0){
 $PT1=105;
 }else if(strpos(",".$PINFO_list,",17,")!='' || strpos(",".$PINFO_list,",17,")===0 || strpos(",".$PINFO_list,",164,")!='' || strpos(",".$PINFO_list,",164,")===0 || strpos(",".$PINFO_list,",211,")!='' || strpos(",".$PINFO_list,",211,")===0 || strpos(",".$PINFO_list,",243,")!='' || strpos(",".$PINFO_list,",243,")===0){
 $PT1=0106;
 }
}else if($SEL_PTYPE==46){
 $PT1=107;
}else if($SEL_PTYPE==47){
 $PT1=108;
}else if($SEL_PTYPE==48){
 $PT1=109;
}else if($SEL_PTYPE==49){
 $PT1=110;
}else if($SEL_PTYPE==50){
 $PT1=111;
}else if($SEL_PTYPE==51){
 $PT1=112;
}else if($SEL_PTYPE==52){
 $PT1=113;
}else if($SEL_PTYPE==53){
 $PT1=114;
}else if($SEL_PTYPE==54){
 $PT1=115;
}else if($SEL_PTYPE==55){
 $PT1=116;
}

$str_type_n1="SELECT ProductTypeID, ProductTypeName FROM producttypes_las where ProductTypeID=".$SEL_PTYPE;
$type_n1_cmd=mysqli_query($link_db,$str_type_n1);
$type_n1_data=mysqli_fetch_row($type_n1_cmd);
putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

//SYSTEMBOARD
$str11="SELECT SYSTEMBOARDID,product_skus.MODELCODE as MODEL,STATUS, Remark,product_skus.SKU, Product_SKU_Auto_ID, IS_EOL FROM p_s_main_systemboards " .
       " INNER JOIN product_skus ON p_s_main_systemboards.MODELCODE = product_skus.MODELCODE" .
       " WHERE ((MODELNAME like '%".$Model_value."%'  ) OR (Replace(product_skus.MODELCODE,'-','') like '%".str_replace('-','',$Model_value)."%' ) OR product_skus.SKU like '%".str_replace(' ','%',$Model_value)."%' ) AND (LANG = 'en-US') and (product_skus.Web_Disable = 0)" .
       " ORDER BY Product_SKU_Auto_ID";
mysqli_query($link_db, 'SET NAMES utf8');
$cmd11=mysqli_query($link_db,$str11);
$Data_record11_num=mysqli_num_rows($cmd11);
if($Data_record11_num==0):
else:
$CPUSORT_CHK="MM";
endif;
//Serverbarebones
$str21="SELECT SERVERID, product_skus.MODELCODE as MODEL,STATUS,Remark,product_skus.SKU, Product_SKU_Auto_ID, IS_EOL FROM p_b_main_serverbarebones  " .
       " INNER JOIN product_skus ON p_b_main_serverbarebones.MODELCODE = product_skus.MODELCODE" .
       " WHERE ((MODELNAME like '%".$Model_value."%'  ) OR (Replace(product_skus.MODELCODE,'-','') like '%".str_replace('-','',$Model_value)."%' ) OR product_skus.SKU like '%".str_replace(' ','%',$Model_value)."%' ) AND (LANG = 'en-US') and (product_skus.Web_Disable = 0) ORDER BY 1";
mysqli_query($link_db, 'SET NAMES utf8');
$cmd21=mysqli_query($link_db,$str21);
$Data_record21_num=mysqli_num_rows($cmd21);
if($Data_record21_num==0):
else:
$CPUSORT_CHK="BB";
endif;
//Panel Pc
$str31="SELECT PANELPCID, CONCAT(MODELNAME,'(',MODELCODE,')') as MODEL,STATUS,Remark FROM p_b_main_panelpc" .
      " WHERE ((MODELNAME like '%".$Model_value."%' ) OR (MODELCODE like '%".$Model_value."%')) AND (LANG = 'en-US') ORDER BY 1";
mysqli_query($link_db, 'SET NAMES utf8');
$cmd31=mysqli_query($link_db,$str31);
$Data_record31_num=mysqli_num_rows($cmd31);
if($Data_record31_num==0):
else:
$CPUSORT_CHK="PanelPc";
endif;
//Embedded
$str41="SELECT EMBEDDEDID, CONCAT(MODELNAME,'(',MODELCODE,')') as MODEL,STATUS,Remark FROM p_b_main_embedded" .
      " WHERE ((MODELNAME like '%".$Model_value."%' ) OR (MODELCODE like '%".$Model_value."%')) AND (LANG = 'en-US') ORDER BY 1";
mysqli_query($link_db, 'SET NAMES utf8');
$cmd41=mysqli_query($link_db,$str41);
$Data_record41_num=mysqli_num_rows($cmd41);
if($Data_record41_num==0):

else:
$CPUSORT_CHK="Embedded";
endif;
//Industria MB
$str51="SELECT INDUSTRIAMBID, CONCAT(MODELNAME,'(',MODELCODE,')') as MODEL,STATUS,Remark FROM p_b_main_industriamb" .
      " WHERE ((MODELNAME like '%".$Model_value."%' ) OR (MODELCODE like '%".$Model_value."%')) AND (LANG = 'en-US') ORDER BY 1";
mysqli_query($link_db, 'SET NAMES utf8');
$cmd51=mysqli_query($link_db,$str51);
$Data_record51_num=mysqli_num_rows($cmd51);
if($Data_record51_num==0):
else:
$CPUSORT_CHK="IndustriaMB";
endif;

//OCP Server
$str61="SELECT OCPID, CONCAT(MODELNAME,'(',MODELCODE,')') as MODEL,STATUS,Remark FROM p_b_main_ocpserver" .
      " WHERE ((MODELNAME like '%".$Model_value."%' ) OR (MODELCODE like '%".$Model_value."%')) AND (LANG = 'en-US') ORDER BY 1";
mysqli_query($link_db, 'SET NAMES utf8');
$cmd61=mysqli_query($link_db,$str61);
$Data_record61_num=mysqli_num_rows($cmd61);
if($Data_record61_num==0):
else:
$CPUSORT_CHK="OCPserver";
endif;

//OCP Mezz
$str71="SELECT OCPMezzID, CONCAT(MODELNAME,'(',MODELCODE,')') as MODEL,STATUS,Remark FROM p_b_main_ocpmezz" .
      " WHERE ((MODELNAME like '%".$Model_value."%' ) OR (MODELCODE like '%".$Model_value."%')) AND (LANG = 'en-US') ORDER BY 1";
mysqli_query($link_db, 'SET NAMES utf8');
$cmd71=mysqli_query($link_db,$str71);
$Data_record71_num=mysqli_num_rows($cmd71);
if($Data_record71_num==0):
else:
$CPUSORT_CHK="OCPMezz";
endif;

//POS
$str81="SELECT POSID, CONCAT(MODELNAME,'(',MODELCODE,')') as MODEL,STATUS,Remark FROM p_b_main_pos" .
      " WHERE ((MODELNAME like '%".$Model_value."%' ) OR (MODELCODE like '%".$Model_value."%')) AND (LANG = 'en-US') ORDER BY 1";
mysqli_query($link_db, 'SET NAMES utf8');
$cmd81=mysqli_query($link_db,$str81);
$Data_record81_num=mysqli_num_rows($cmd81);
if($Data_record81_num==0):
else:
$CPUSORT_CHK="POS";
endif;

//5G
$str91="SELECT 5GID, CONCAT(MODELNAME,'(',MODELCODE,')') as MODEL,STATUS,Remark FROM p_b_main_5G" .
      " WHERE ((MODELNAME like '%".$Model_value."%' ) OR (MODELCODE like '%".$Model_value."%')) AND (LANG = 'en-US') ORDER BY 1";
mysqli_query($link_db, 'SET NAMES utf8');
$cmd91=mysqli_query($link_db,$str91);
$Data_record91_num=mysqli_num_rows($cmd91);
if($Data_record91_num==0):
else:
$CPUSORT_CHK="5GEdgeComputing";
endif;

//IntelDSG
$str101="SELECT IntelDSGID, CONCAT(MODELNAME,'(',MODELCODE,')') as MODEL,STATUS,Remark FROM p_b_main_inteldsg" .
      " WHERE ((MODELNAME like '%".$Model_value."%' ) OR (MODELCODE like '%".$Model_value."%')) AND (LANG = 'en-US') ORDER BY 1";
mysqli_query($link_db, 'SET NAMES utf8');
$cmd101=mysqli_query($link_db,$str101);
$Data_record101_num=mysqli_num_rows($cmd101);
if($Data_record101_num==0):
else:
$CPUSORT_CHK="IntelDSG";
endif;

if(isset($_FILES['ProFile']['name'])!=''){
$ProFile=trim($_FILES['ProFile']['name']);
}else{
$ProFile="";
}
if(isset($_POST['ProFile_B'])!=''){
$ProFile_B=$_POST['ProFile_B'];
}else{
$ProFile_B="";
}
if(isset($_POST['ProFile_ALLSKU'])!=''){
$ProFile_ALLSKU=$_POST['ProFile_ALLSKU'];
}else{
$ProFile_ALLSKU="";
}

if($_FILES['ProFile_S']['name']!=''){
$ProFile_S=trim($_FILES['ProFile_S']['name']);
}else{
$ProFile_S=$_POST['ProFile_S_value'];
}
if($_FILES['ProFile_com']['name']!=''){
$ProFile_com=trim($_FILES['ProFile_com']['name']);
}else{
$ProFile_com=$_POST['ProFile_C_value'];
}

//*** image no file doesn't update ****
if($ProFile_B!=''){
$bpic_val="ProductBFile='$ProFile_B',";
}else{
$bpic_val="";
}

if($ProFile!=''){
$P_File="ProductFile='$ProFile',";
}else{
$P_File="";
}

if($ProFile_S!=''){
$P_File_S="ProductSFile='".$ProFile_S."',";
}else{
$P_File_S="";
}
//*** image no file doesn't update end****

$str_pinfoVal01="";$str_pinfoVal02="";$str_pinfoVal03="";$str_pinfoVal04="";$str_pinfoVal05="";$str_pinfoVal06="";
$str_pinfoVal07="";$str_pinfoVal08="";$str_pinfoVal09="";$str_pinfoVal10="";$str_pinfoVal11="";
if(isset($_POST['FFactor_val'])!=''){

 if(trim($_POST['FFactor_val'])!=''){
 $FFactor_val=trim($_POST['FFactor_val']);

   $str_pinfoVal01="SELECT distinct a.PI_id, b.PI_Name FROM product_infovalue_las a inner join product_info_las b on a.PI_id=b.PI_id where concat(',',a.PIV_id,',') like '%,".$FFactor_val."%'";
   $pinfoVal01_cmd=mysqli_query($link_db,$str_pinfoVal01);
   $pinfoVal01_data=mysqli_fetch_row($pinfoVal01_cmd);

   if(strpos(",".$cate_pinfo01,",".$pinfoVal01_data[0].",")!='' || strpos(",".$cate_pinfo01,",".$pinfoVal01_data[0].",")===0){
     $FFactor_val_name="<th style='font-size:10px;'>".$pinfoVal01_data[1]."</th>";
   }else{
   }
 }else{
	$FFactor_val=NULL;
  $FFactor_val_name="";
 }
}else{
 $FFactor_val=NULL;
 $FFactor_val_name="";
}

if(isset($_POST['MBprocessor_val'])!=''){

 if(trim($_POST['MBprocessor_val'])!=''){
 $MBprocessor_val=trim($_POST['MBprocessor_val']);

   $str_pinfoVal02="SELECT distinct a.PI_id, b.PI_Name FROM product_infovalue_las a inner join product_info_las b on a.PI_id=b.PI_id where concat(',',a.PIV_id,',') like '%,".$MBprocessor_val."%'";
   $pinfoVal02_cmd=mysqli_query($link_db,$str_pinfoVal02);
   $pinfoVal02_data=mysqli_fetch_row($pinfoVal02_cmd);

   if(strpos(",".$cate_pinfo01,",".$pinfoVal02_data[0].",")!='' || strpos(",".$cate_pinfo01,",".$pinfoVal02_data[0].",")===0){
     $MBprocessor_name="<th style='font-size:10px;'>".$pinfoVal02_data[1]."</th>";
   }else{
   }
 }else{
	 $MBprocessor_val=NULL;
	 $MBprocessor_name="";
 }
}else{
 $MBprocessor_val=NULL;
 $MBprocessor_name="";
}

if(isset($_POST['LAN_val'])!=''){

 if(trim($_POST['LAN_val'])!=''){
 $LAN_val=trim($_POST['LAN_val']);

   $str_pinfoVal03="SELECT distinct a.PI_id, b.PI_Name FROM product_infovalue_las a inner join product_info_las b on a.PI_id=b.PI_id where concat(',',a.PIV_id,',') like '%,".$LAN_val."%'";
   $pinfoVal03_cmd=mysqli_query($link_db,$str_pinfoVal03);
   $pinfoVal03_data=mysqli_fetch_row($pinfoVal03_cmd);

   if(strpos(",".$cate_pinfo01,",".$pinfoVal03_data[0].",")!='' || strpos(",".$cate_pinfo01,",".$pinfoVal03_data[0].",")===0){
     $LAN_val_name="<th style='font-size:10px;'>".$pinfoVal03_data[1]."</th>";
   }else{
   }
 }else{
    $LAN_val=NULL;
    $LAN_val_name="";
 }
}else{
 $LAN_val=NULL;
 $LAN_val_name="";
}

if(isset($_POST['COM_val'])!=''){

 if(trim($_POST['COM_val'])!=''){
 $COM_val=trim($_POST['COM_val']);

   $str_pinfoVal04="SELECT distinct a.PI_id, b.PI_Name FROM product_infovalue_las a inner join product_info_las b on a.PI_id=b.PI_id where concat(',',a.PIV_id,',') like '%,".$COM_val."%'";
   $pinfoVal04_cmd=mysqli_query($link_db,$str_pinfoVal04);
   $pinfoVal04_data=mysqli_fetch_row($pinfoVal04_cmd);

   if(strpos(",".$cate_pinfo01,",".$pinfoVal04_data[0].",")!='' || strpos(",".$cate_pinfo01,",".$pinfoVal04_data[0].",")===0){
     $COM_val_name="<th style='font-size:10px;'>".$pinfoVal04_data[1]."</th>";
   }else{
   }
 }else{
	 $COM_val=NULL;
	 $COM_val_name="";
 }
}else{
 $COM_val=NULL;
 $COM_val_name="";
}

if(isset($_POST['USB_val'])!=''){

 if(trim($_POST['USB_val'])!=''){
  $USB_val=trim($_POST['USB_val']);
   $str_pinfoVal05="SELECT distinct a.PI_id, b.PI_Name FROM product_infovalue_las a inner join product_info_las b on a.PI_id=b.PI_id where ',".$USB_val."' like concat('%,',a.PIV_id,',%')";
   $pinfoVal05_cmd=mysqli_query($link_db,$str_pinfoVal05);
   $pinfoVal05_data=mysqli_fetch_row($pinfoVal05_cmd);

   if(strpos(",".$cate_pinfo01,",".$pinfoVal05_data[0].",")!='' || strpos(",".$cate_pinfo01,",".$pinfoVal05_data[0].",")===0){
      $USB_val_name="<th style='font-size:10px;'>".$pinfoVal05_data[1]."</th>";
   }else{
   }
 }else{
	  $USB_val=NULL;
    $USB_val_name="";
 }
}else{
 $USB_val=NULL;
 $USB_val_name="";
}

if(isset($_POST['SATA_val'])!=''){

 if(trim($_POST['SATA_val'])!=''){
 $SATA_val=trim($_POST['SATA_val']);

   $str_pinfoVal06="SELECT distinct a.PI_id, b.PI_Name FROM product_infovalue_las a inner join product_info_las b on a.PI_id=b.PI_id where ',".$SATA_val."' like concat('%,',a.PIV_id,',%')";
   $pinfoVal06_cmd=mysqli_query($link_db,$str_pinfoVal06);
   $pinfoVal06_data=mysqli_fetch_row($pinfoVal06_cmd);

   if(strpos(",".$cate_pinfo01,",".$pinfoVal06_data[0].",")!='' || strpos(",".$cate_pinfo01,",".$pinfoVal06_data[0].",")===0){
      $SATA_val_name="<th style='font-size:10px;'>".$pinfoVal06_data[1]."</th>";
   }else{
   }
 }else{
	  $SATA_val=NULL;
    $SATA_val_name="";
 }
}else{
 $SATA_val=NULL;
 $SATA_val_name="";
}

if(isset($_POST['M2Slot_val'])!=''){

 if(trim($_POST['M2Slot_val'])!=''){
 $M2Slot_val=trim($_POST['M2Slot_val']);

   $str_pinfoVal07="SELECT distinct a.PI_id, b.PI_Name FROM product_infovalue_las a inner join product_info_las b on a.PI_id=b.PI_id where ',".$M2Slot_val."' like concat('%,',a.PIV_id,',%')";
   $pinfoVal07_cmd=mysqli_query($link_db,$str_pinfoVal07);
   $pinfoVal07_data=mysqli_fetch_row($pinfoVal07_cmd);

   if(strpos(",".$cate_pinfo01,",".$pinfoVal07_data[0].",")!='' || strpos(",".$cate_pinfo01,",".$pinfoVal07_data[0].",")===0){
      $M2Slot_val_name="<th style='font-size:10px;'>".$pinfoVal07_data[1]."</th>";
   }else{
   }
 }else{
	  $M2Slot_val=NULL;
    $M2Slot_val_name="";
 }
}else{
 $M2Slot_val=NULL;
 $M2Slot_val_name="";
}

if(isset($_POST['MiniPCIe_val'])!=''){

 if(trim($_POST['MiniPCIe_val'])!=''){
 $Mini_PCIe_val=trim($_POST['MiniPCIe_val']);

   $str_pinfoVal08="SELECT distinct a.PI_id, b.PI_Name FROM product_infovalue_las a inner join product_info_las b on a.PI_id=b.PI_id where ',".$Mini_PCIe_val."' like concat('%,',a.PIV_id,',%')";
   $pinfoVal08_cmd=mysqli_query($link_db,$str_pinfoVal08);
   $pinfoVal08_data=mysqli_fetch_row($pinfoVal08_cmd);

   if(strpos(",".$cate_pinfo01,",".$pinfoVal08_data[0].",")!='' || strpos(",".$cate_pinfo01,",".$pinfoVal08_data[0].",")===0){
      $Mini_PCIe_val_name="<th style='font-size:10px;'>".$pinfoVal08_data[1]."</th>";
   }else{
   }
 }else{
	  $Mini_PCIe_val=NULL;
      $Mini_PCIe_val_name="";
 }
}else{
 $Mini_PCIe_val=NULL;
 $Mini_PCIe_val_name="";
}

if(isset($_POST['PCIeSlot_val'])!=''){

 if(trim($_POST['PCIeSlot_val'])!=''){
 $PCIeSlot_val=trim($_POST['PCIeSlot_val']);

   $str_pinfoVal09="SELECT distinct a.PI_id, b.PI_Name FROM product_infovalue_las a inner join product_info_las b on a.PI_id=b.PI_id where ',".$PCIeSlot_val."' like concat('%,',a.PIV_id,',%')";
   $pinfoVal09_cmd=mysqli_query($link_db,$str_pinfoVal09);
   $pinfoVal09_data=mysqli_fetch_row($pinfoVal09_cmd);

   if(strpos(",".$cate_pinfo01,",".$pinfoVal09_data[0].",")!='' || strpos(",".$cate_pinfo01,",".$pinfoVal09_data[0].",")===0){
      $PCIeSlot_val_name="<th style='font-size:10px;'>".$pinfoVal09_data[1]."</th>";
   }else{
   }
 }else{
	  $PCIeSlot_val=NULL;
      $PCIeSlot_val_name="";
 }
}else{
 $PCIeSlot_val=NULL;
 $PCIeSlot_val_name="";
}

if(isset($_POST['MBpower_val'])!=''){

 if(trim($_POST['MBpower_val'])!=''){
 $MBpower_val=trim($_POST['MBpower_val']);

   $str_pinfoVal10="SELECT distinct a.PI_id, b.PI_Name FROM product_infovalue_las a inner join product_info_las b on a.PI_id=b.PI_id where ',".$MBpower_val."' like concat('%,',a.PIV_id,',%')";
   $pinfoVal10_cmd=mysqli_query($link_db,$str_pinfoVal10);
   $pinfoVal10_data=mysqli_fetch_row($pinfoVal10_cmd);
   if(strpos(",".$cate_pinfo01,",".$pinfoVal10_data[0].",")!='' || strpos(",".$cate_pinfo01,",".$pinfoVal10_data[0].",")===0){
      $MBpower_val_name="<th style='font-size:10px;'>".$pinfoVal10_data[1]."</th>";
   }else{
   }
 }else{
	  $MBpower_val=NULL;
    $MBpower_val_name="";
 }
}else{
  $MBpower_val=NULL;
  $MBpower_val_name="";
}

if(isset($_POST['Fanless_val'])!=''){

 if(trim($_POST['Fanless_val'])!=''){
 $Fanless_val=trim($_POST['Fanless_val']);

   $str_pinfoVal11="SELECT distinct a.PI_id, b.PI_Name FROM product_infovalue_las a inner join product_info_las b on a.PI_id=b.PI_id where ',".$Fanless_val."' like concat('%,',a.PIV_id,',%')";
   $pinfoVal11_cmd=mysqli_query($link_db,$str_pinfoVal11);
   $pinfoVal11_data=mysqli_fetch_row($pinfoVal11_cmd);

   if(strpos(",".$cate_pinfo01,",".$pinfoVal11_data[0].",")!='' || strpos(",".$cate_pinfo01,",".$pinfoVal11_data[0].",")===0){
      $Fanless_val_name="<th style='font-size:10px;'>".$pinfoVal11_data[1]."</th>";
   }else{
   }
 }else{
	  $Fanless_val=NULL;
    $Fanless_val_name="";
 }
}else{
 $Fanless_val=NULL;
 $Fanless_val_name="";
}

if(isset($_POST['Modularized_IO_val'])!=''){

 if(trim($_POST['Modularized_IO_val'])!=''){
 $Modularized_IO_val=trim($_POST['Modularized_IO_val']);

   $str_pinfoVal12="SELECT distinct a.PI_id, b.PI_Name FROM product_infovalue_las a inner join product_info_las b on a.PI_id=b.PI_id where ',".$Modularized_IO_val."' like concat('%,',a.PIV_id,',%')";
   $pinfoVal12_cmd=mysqli_query($link_db,$str_pinfoVal12);
   $pinfoVal12_data=mysqli_fetch_row($pinfoVal12_cmd);

   if(strpos(",".$cate_pinfo01,",".$pinfoVal12_data[0].",")!='' || strpos(",".$cate_pinfo01,",".$pinfoVal12_data[0].",")===0){
      $Modularized_IO_val_name="<th style='font-size:10px;'>".$pinfoVal12_data[1]."</th>";
   }else{
   }
 }else{
	  $Modularized_IO_val=NULL;
    $Modularized_IO_val_name="";
 }
}else{
 $Modularized_IO_val=NULL;
 $Modularized_IO_val_name="";
}

if(isset($_POST['WidgetTemperature_val'])!=''){

 if(trim($_POST['WidgetTemperature_val'])!=''){
 $WidgetTemperature_val=trim($_POST['WidgetTemperature_val']);

   $str_pinfoVal13="SELECT distinct a.PI_id, b.PI_Name FROM product_infovalue_las a inner join product_info_las b on a.PI_id=b.PI_id where ',".$WidgetTemperature_val."' like concat('%,',a.PIV_id,',%')";
   $pinfoVal13_cmd=mysqli_query($link_db,$str_pinfoVal13);
   $pinfoVal13_data=mysqli_fetch_row($pinfoVal13_cmd);

   if(strpos(",".$cate_pinfo01,",".$pinfoVal13_data[0].",")!='' || strpos(",".$cate_pinfo01,",".$pinfoVal13_data[0].",")===0){
      $WidgetTemperature_val_name="<th style='font-size:10px;'>".$pinfoVal13_data[1]."</th>";
   }else{
   }
 }else{
	  $WidgetTemperature_val=NULL;
    $WidgetTemperature_val_name="";
 }
}else{
 $WidgetTemperature_val=NULL;
 $WidgetTemperature_val_name="";
}

if(isset($_POST['PanelSize_val'])!=''){

 if(trim($_POST['PanelSize_val'])!=''){
 $PanelSize_val=trim($_POST['PanelSize_val']);

   $str_pinfoVal14="SELECT distinct a.PI_id, b.PI_Name FROM product_infovalue_las a inner join product_info_las b on a.PI_id=b.PI_id where ',".$PanelSize_val."' like concat('%,',a.PIV_id,',%')";
   $pinfoVal14_cmd=mysqli_query($link_db,$str_pinfoVal14);
   $pinfoVal14_data=mysqli_fetch_row($pinfoVal14_cmd);

   if(strpos(",".$cate_pinfo01,",".$pinfoVal14_data[0].",")!='' || strpos(",".$cate_pinfo01,",".$pinfoVal14_data[0].",")===0){
      $PanelSize_val_name="<th style='font-size:10px;'>".$pinfoVal14_data[1]."</th>";
   }else{
   }
 }else{
	  $PanelSize_val=NULL;
    $PanelSize_val_name="";
 }
}else{
 $PanelSize_val=NULL;
 $PanelSize_val_name="";
}

if(isset($_POST['EmbeddedPower_val'])!=''){

 if(trim($_POST['EmbeddedPower_val'])!=''){
 $EmbeddedPower_val=trim($_POST['EmbeddedPower_val']);

   $str_pinfoVal15="SELECT distinct a.PI_id, b.PI_Name FROM product_infovalue_las a inner join product_info_las b on a.PI_id=b.PI_id where ',".$EmbeddedPower_val."' like concat('%,',a.PIV_id,',%')";
   $pinfoVal15_cmd=mysqli_query($link_db,$str_pinfoVal15);
   $pinfoVal15_data=mysqli_fetch_row($pinfoVal15_cmd);

   if(strpos(",".$cate_pinfo01,",".$pinfoVal15_data[0].",")!='' || strpos(",".$cate_pinfo01,",".$pinfoVal15_data[0].",")===0){
      $EmbeddedPower_val_name="<th style='font-size:10px;'>".$pinfoVal15_data[1]."</th>";
   }else{
   }
 }else{
	  $EmbeddedPower_val=NULL;
    $EmbeddedPower_val_name="";
 }
}else{
 $EmbeddedPower_val=NULL;
 $EmbeddedPower_val_name="";
}

if(isset($_POST['Legend1_val'])!=''){
 $Legend1_val01=trim($_POST['Legend1_val']);
}else{
 $Legend1_val01="";
}

if(isset($_POST['PanelPCPower_val'])!=''){

 if(trim($_POST['PanelPCPower_val'])!=''){
 $Panel_PC_Power_val=trim($_POST['PanelPCPower_val']);

   $str_pinfoVa116="SELECT distinct a.PI_id, b.PI_Name FROM product_infovalue_las a inner join product_info_las b on a.PI_id=b.PI_id where ',".$Panel_PC_Power_val."' like concat('%,',a.PIV_id,',%')";
   $pinfoVal16_cmd=mysqli_query($link_db,$str_pinfoVa116);
   $pinfoVal16_data=mysqli_fetch_row($pinfoVal16_cmd);

   if(strpos(",".$cate_pinfo01,",".$pinfoVal16_data[0].",")!='' || strpos(",".$cate_pinfo01,",".$pinfoVal16_data[0].",")===0){
      $Panel_PC_Power_val_name="<th style='font-size:10px;'>".$pinfoVal16_data[1]."</th>";
   }else{
   }
 }else{
    $Panel_PC_Power_val=NULL;
    $Panel_PC_Power_val_name="";
 }
}else{
 $Panel_PC_Power_val=NULL;
 $Panel_PC_Power_val_name="";
}

if(isset($_POST['EmbeddedProcessor_val'])!=''){

 if(trim($_POST['EmbeddedProcessor_val'])!=''){
 $EmbeddedProcessor_val=trim($_POST['EmbeddedProcessor_val']);

   $str_pinfoVa117="SELECT distinct a.PI_id, b.PI_Name FROM product_infovalue_las a inner join product_info_las b on a.PI_id=b.PI_id where ',".$EmbeddedProcessor_val."' like concat('%,',a.PIV_id,',%')";
   $pinfoVal17_cmd=mysqli_query($link_db,$str_pinfoVa117);
   $pinfoVal17_data=mysqli_fetch_row($pinfoVal17_cmd);

   if(strpos(",".$cate_pinfo01,",".$pinfoVal17_data[0].",")!='' || strpos(",".$cate_pinfo01,",".$pinfoVal17_data[0].",")===0){
      $EmbeddedProcessor_val_name="<th style='font-size:10px;'>".$pinfoVal17_data[1]."</th>";
   }else{
   }
 }else{
    $EmbeddedProcessor_val=NULL;
    $EmbeddedProcessor_val_name="";
 }
}else{
 $EmbeddedProcessor_val=NULL;
 $EmbeddedProcessor_val_name="";
}

if(isset($_POST['PanelPCProcessor_val'])!=''){

 if(trim($_POST['PanelPCProcessor_val'])!=''){
 $Panel_PC_Processor_val=trim($_POST['PanelPCProcessor_val']);

   $str_pinfoVa118="SELECT distinct a.PI_id, b.PI_Name FROM product_infovalue_las a inner join product_info_las b on a.PI_id=b.PI_id where ',".$Panel_PC_Processor_val."' like concat('%,',a.PIV_id,',%')";
   $pinfoVal18_cmd=mysqli_query($link_db,$str_pinfoVa118);
   $pinfoVal18_data=mysqli_fetch_row($pinfoVal18_cmd);

   if(strpos(",".$cate_pinfo01,",".$pinfoVal18_data[0].",")!='' || strpos(",".$cate_pinfo01,",".$pinfoVal18_data[0].",")===0){
      $Panel_PC_Processor_val_name="<th style='font-size:10px;'>".$pinfoVal18_data[1]."</th>";
   }else{
   }
 }else{
    $Panel_PC_Processor_val=NULL;
    $Panel_PC_Processor_val_name="";
 }
}else{
 $Panel_PC_Processor_val=NULL;
 $Panel_PC_Processor_val_name="";
}

if(isset($_POST['EmbeddedType_val'])!=''){

 if(trim($_POST['EmbeddedType_val'])!=''){
 $EmbeddedType_val=trim($_POST['EmbeddedType_val']);

   $str_pinfoVa119="SELECT distinct a.PI_id, b.PI_Name FROM product_infovalue_las a inner join product_info_las b on a.PI_id=b.PI_id where ',".$EmbeddedType_val."' like concat('%,',a.PIV_id,',%')";
   $pinfoVal19_cmd=mysqli_query($link_db,$str_pinfoVa119);
   $pinfoVal19_data=mysqli_fetch_row($pinfoVal19_cmd);

   if(strpos(",".$cate_pinfo01,",".$pinfoVal19_data[0].",")!='' || strpos(",".$cate_pinfo01,",".$pinfoVal19_data[0].",")===0){
      $EmbeddedType_val_name="<th style='font-size:10px;'>".$pinfoVal19_data[1]."</th>";
   }else{
   }
 }else{
    $EmbeddedType_val=NULL;
    $EmbeddedType_val_name="";
 }
}else{
 $EmbeddedType_val=NULL;
 $EmbeddedType_val_name="";
}

if(isset($_POST['PanelPCType_val'])!=''){

 if(trim($_POST['PanelPCType_val'])!=''){
 $PanelPCType_val=trim($_POST['PanelPCType_val']);

   $str_pinfoVa120="SELECT distinct a.PI_id, b.PI_Name FROM product_infovalue_las a inner join product_info_las b on a.PI_id=b.PI_id where ',".$PanelPCType_val."' like concat('%,',a.PIV_id,',%')";
   $pinfoVal20_cmd=mysqli_query($link_db,$str_pinfoVa120);
   $pinfoVal20_data=mysqli_fetch_row($pinfoVal20_cmd);

   if(strpos(",".$cate_pinfo01,",".$pinfoVal20_data[0].",")!='' || strpos(",".$cate_pinfo01,",".$pinfoVal20_data[0].",")===0){
      $PanelPCType_val_name="<th style='font-size:10px;'>".$pinfoVal20_data[1]."</th>";
   }else{
   }
 }else{
    $PanelPCType_val=NULL;
      $PanelPCType_val_name="";
 }
}else{
 $PanelPCType_val=NULL;
 $PanelPCType_val_name="";
}



//********* icons top ***********
  $iconvals_valALL="";
  $iconvals_split=explode(',',$iconvals,-1);
  foreach($iconvals_split as $iconvals_val){

	$str_chkico="SELECT id FROM c_sp_icon where replace(img,'./images/logo/','')='".$iconvals_val."'";
	$chkico_cmd=mysqli_query($link_db,$str_chkico);
	$chkico_data=mysqli_fetch_row($chkico_cmd);
	$iconvals_valALL.=$chkico_data[0].",";

  }
//********** icons top end *********

//********* icons bottom ***********
  $iconvals_b_valALL="";
  $iconvals_b_split=explode(',',$iconvals_b,-1);
  foreach($iconvals_b_split as $iconvals_b_val){

  $str_chkico="SELECT id FROM c_sp_icon where replace(img,'./images/logo/','')='".$iconvals_b_val."'";
  $chkico_cmd=mysqli_query($link_db,$str_chkico);
  $chkico_data=mysqli_fetch_row($chkico_cmd);
  $iconvals_b_valALL.=$chkico_data[0].",";

  }
//********** icons bottom end *********


$spic="";$opic="";$MMurl="";$BBurl="";$CHSurl="";$HBAurl="";$JBDurl="";$TPMurl="";$NICurl="";
if($CPUSORT_CHK=="MM"){
  $MMurl="~/images/systemboards/";
  if($ProFile!="none" && $ProFile!=''){
    $UploadPath = "../../images/systemboards/";
    $flag = copy($_FILES['ProFile']['tmp_name'], $UploadPath.$_FILES['ProFile']['name']);
    if($flag) echo "";
    $spic=",IMG='$MMurl$ProFile'";
  }else if($ProFile=="none" && $ProFile==''){
    $spic="";
  }
  if($ProFile_S!="none" && $ProFile_S!=''){
    $UploadPath = "../../images/systemboards/";
    $flag = copy($_FILES['ProFile_S']['tmp_name'], $UploadPath.$_FILES['ProFile_S']['name']);
    if($flag) echo "";
    $opic=",SMALLIMG='$MMurl$ProFile_S'";
  }else if($ProFile_S=="none" && $ProFile_S==''){
    $opic="";
  }

  if($ProFile_com!="none" && $ProFile_com!=''){
    $UploadPath = "../../images/systemboards/";
    $flag = copy($_FILES['ProFile_com']['tmp_name'], $UploadPath.$_FILES['ProFile_com']['name']);
  }

  $str_CPUSORTupd="update p_s_main_systemboards set CPUSORT='".$iconvals_valALL."'$spic$opic where MODELCODE='".$Model_value."'";
}else if($CPUSORT_CHK=="BB"){
  $spic='';
  $BBurl="~/images/serverbarebones/";
  if($ProFile!="none" && $ProFile!=''){
    $UploadPath = "../../images/serverbarebones/";
    $flag = copy($_FILES['ProFile']['tmp_name'], $UploadPath.$_FILES['ProFile']['name']);
    if($flag) echo "";
    $spic=",IMG='$BBurl$ProFile'";
  }else if($ProFile=="none" && $ProFile==''){
    $spic="";
  }
  $opic='';
  if($ProFile_S!="none" && $ProFile_S!=''){
    $UploadPath = "../../images/serverbarebones/";
    $flag = copy($_FILES['ProFile_S']['tmp_name'], $UploadPath.$_FILES['ProFile_S']['name']);
    if($flag) echo "";
    $opic=",SMALLIMG='$BBurl$ProFile_S'";
  }else if($ProFile_S=="none" && $ProFile_S==''){
    $opic="";
  }

  if($ProFile_com!="none" && $ProFile_com!=''){
    $UploadPath = "../../images/serverbarebones/";
    $flag = copy($_FILES['ProFile_com']['tmp_name'], $UploadPath.$_FILES['ProFile_com']['name']);
  }

  $str_CPUSORTupd="update p_b_main_serverbarebones set CPUSORT='".$iconvals_valALL."'$spic$opic where MODELCODE='".$Model_value."'";
}else if($CPUSORT_CHK=="Chassis"){
  $CHSurl="~/images/serverbarebones/";
  if($ProFile!="none" && $ProFile!=''){

    $UploadPath = "../../images/serverbarebones/";
    $flag = copy($_FILES['ProFile']['tmp_name'], $UploadPath.$_FILES['ProFile']['name']);
    if($flag) echo "";

    $spic=",IMG='$CHSurl$ProFile'";
  }else if($ProFile=="none" && $ProFile==''){
    $spic="";
  }
  if($ProFile_S!="none" && $ProFile_S!=''){

    $UploadPath = "../../images/serverbarebones/";
    $flag = copy($_FILES['ProFile_S']['tmp_name'], $UploadPath.$_FILES['ProFile_S']['name']);
    if($flag) echo "";

    $opic=",SMALLIMG='$CHSurl$ProFile_S'";
  }else if($ProFile_S=="none" && $ProFile_S==''){
    $opic="";
  }

  if($ProFile_com!="none" && $ProFile_com!=''){
    $UploadPath = "../../images/serverbarebones/";
    $flag = copy($_FILES['ProFile_com']['tmp_name'], $UploadPath.$_FILES['ProFile_com']['name']);
  }

  $str_CPUSORTupd="update p_r_main_rackchassis set CPUSORT='".$iconvals_valALL."'$spic$opic where MODELCODE='".$Model_value."'";
}else if($CPUSORT_CHK=="PanelPc"){
  $HBAurl="~/images/product/PanelPc/";
  if($ProFile!="none" && $ProFile!=''){

    $UploadPath = "../../images/product/PanelPc/";
    $flag = copy($_FILES['ProFile']['tmp_name'], $UploadPath.$_FILES['ProFile']['name']);
    if($flag) echo "";

    $spic=",IMG='$HBAurl$ProFile'";
  }else if($ProFile=="none" && $ProFile==''){
    $spic="";
  }
  if($ProFile_S!="none" && $ProFile_S!=''){

    $UploadPath = "../../images/product/PanelPc/";
    $flag = copy($_FILES['ProFile_S']['tmp_name'], $UploadPath.$_FILES['ProFile_S']['name']);
    if($flag) echo "";

    $opic=",SMALLIMG='$HBAurl$ProFile_S'";
  }else if($ProFile_S=="none" && $ProFile_S==''){
    $opic="";
  }

  if($ProFile_com!="none" && $ProFile_com!=''){
    $UploadPath = "../../images/product/PanelPc/";
    $flag = copy($_FILES['ProFile_com']['tmp_name'], $UploadPath.$_FILES['ProFile_com']['name']);
  }

  $str_CPUSORTupd="update p_b_main_panelpc set CPUSORT='".$iconvals_valALL."'$spic$opic where MODELCODE='".$Model_value."'";
}else if($CPUSORT_CHK=="Embedded"){
  $JBDurl="~/images/product/Embedded/";
  if($ProFile!="none" && $ProFile!=''){

    $UploadPath = "../../images/product/Embedded/";
    $flag = copy($_FILES['ProFile']['tmp_name'], $UploadPath.$_FILES['ProFile']['name']);
    if($flag) echo "";

    $spic=",IMG='$JBDurl$ProFile'";
  }else if($ProFile=="none" && $ProFile==''){
    $spic="";
  }
  if($ProFile_S!="none" && $ProFile_S!=''){

    $UploadPath = "../../images/product/Embedded/";
    $flag = copy($_FILES['ProFile_S']['tmp_name'], $UploadPath.$_FILES['ProFile_S']['name']);
    if($flag) echo "";

    $opic=",SMALLIMG='$JBDurl$ProFile_S'";
  }else if($ProFile_S=="none" && $ProFile_S==''){
    $opic="";
  }

  if($ProFile_com!="none" && $ProFile_com!=''){
    $UploadPath = "../../images/product/Embedded/";
    $flag = copy($_FILES['ProFile_com']['tmp_name'], $UploadPath.$_FILES['ProFile_com']['name']);
  }

  $str_CPUSORTupd="update p_b_main_embedded set CPUSORT='".$iconvals_valALL."'$spic$opic where MODELCODE='".$Model_value."'";
}else if($CPUSORT_CHK=="IndustriaMB"){
  $TPMurl="~/images/product/IndustriaMB/";
  if($ProFile!="none" && $ProFile!=''){

    $UploadPath = "../../images/product/IndustriaMB/";
    $flag = copy($_FILES['ProFile']['tmp_name'], $UploadPath.$_FILES['ProFile']['name']);
    if($flag) echo "";

    $spic=",IMG='$TPMurl$ProFile'";
  }else if($ProFile=="none" && $ProFile==''){
    $spic="";
  }
  if($ProFile_S!="none" && $ProFile_S!=''){

    $UploadPath = "../../images/product/IndustriaMB/";
    $flag = copy($_FILES['ProFile_S']['tmp_name'], $UploadPath.$_FILES['ProFile_S']['name']);
    if($flag) echo "";

    $opic=",SMALLIMG='$TPMurl$ProFile_S'";
  }else if($ProFile_S=="none" && $ProFile_S==''){
    $opic="";
  }

  if($ProFile_com!="none" && $ProFile_com!=''){
     $UploadPath = "../../images/product/IndustriaMB/";
    $flag = copy($_FILES['ProFile_com']['tmp_name'], $UploadPath.$_FILES['ProFile_com']['name']);
  }

  $str_CPUSORTupd="update p_b_main_industriamb set CPUSORT='".$iconvals_valALL."'$spic$opic where MODELCODE='".$Model_value."'";
}else if($CPUSORT_CHK=="OCPserver"){
  $JBDurl="~/images/product/OCPserver/";
  if($ProFile!="none" && $ProFile!=''){

    $UploadPath = "../../images/product/OCPserver/";
    $flag = copy($_FILES['ProFile']['tmp_name'], $UploadPath.$_FILES['ProFile']['name']);
    if($flag) echo "";

    $spic=",IMG='$JBDurl$ProFile'";
  }else if($ProFile=="none" && $ProFile==''){
    $spic="";
  }
  if($ProFile_S!="none" && $ProFile_S!=''){

    $UploadPath = "../../images/product/OCPserver/";
    $flag = copy($_FILES['ProFile_S']['tmp_name'], $UploadPath.$_FILES['ProFile_S']['name']);
    if($flag) echo "";

    $opic=",SMALLIMG='$JBDurl$ProFile_S'";
  }else if($ProFile_S=="none" && $ProFile_S==''){
    $opic="";
  }

  if($ProFile_com!="none" && $ProFile_com!=''){
    $UploadPath = "../../images/product/OCPserver/";
    $flag = copy($_FILES['ProFile_com']['tmp_name'], $UploadPath.$_FILES['ProFile_com']['name']);
  }

  $str_CPUSORTupd="update p_b_main_ocpserver set CPUSORT='".$iconvals_valALL."'$spic$opic where MODELCODE='".$Model_value."'";
}else if($CPUSORT_CHK=="OCPMezz"){
  $OcpMurl="~/images/product/OCPMezz/";
  if($ProFile!="none" && $ProFile!=''){

    $UploadPath = "../../images/product/OCPMezz/";
    $flag = copy($_FILES['ProFile']['tmp_name'], $UploadPath.$_FILES['ProFile']['name']);
    if($flag) echo "";

    $spic=",IMG='$OcpMurl$ProFile'";
  }else if($ProFile=="none" && $ProFile==''){
    $spic="";
  }
  if($ProFile_S!="none" && $ProFile_S!=''){

    $UploadPath = "../../images/product/OCPMezz/";
    $flag = copy($_FILES['ProFile_S']['tmp_name'], $UploadPath.$_FILES['ProFile_S']['name']);
    if($flag) echo "";

    $opic=",SMALLIMG='$OcpMurl$ProFile_S'";
  }else if($ProFile_S=="none" && $ProFile_S==''){
    $opic="";
  }

  if($ProFile_com!="none" && $ProFile_com!=''){
    $UploadPath = "../../images/product/OCPMezz/";
    $flag = copy($_FILES['ProFile_com']['tmp_name'], $UploadPath.$_FILES['ProFile_com']['name']);
  }

  $str_CPUSORTupd="update p_b_main_ocpmezz set CPUSORT='".$iconvals_valALL."'$spic$opic where MODELCODE='".$Model_value."'";
}else if($CPUSORT_CHK=="JBOD / JBOF"){
  $Jbodfurl="~/images/product/JBODJBOF/";
  if($ProFile!="none" && $ProFile!=''){

    $UploadPath = "../../images/product/JBODJBOF/";
    $flag = copy($_FILES['ProFile']['tmp_name'], $UploadPath.$_FILES['ProFile']['name']);
    if($flag) echo "";

    $spic=",IMG='$Jbodfurl$ProFile'";
  }else if($ProFile=="none" && $ProFile==''){
    $spic="";
  }
  if($ProFile_S!="none" && $ProFile_S!=''){

    $UploadPath = "../../images/product/JBODJBOF/";
    $flag = copy($_FILES['ProFile_S']['tmp_name'], $UploadPath.$_FILES['ProFile_S']['name']);
    if($flag) echo "";

    $opic=",SMALLIMG='$Jbodfurl$ProFile_S'";
  }else if($ProFile_S=="none" && $ProFile_S==''){
    $opic="";
  }

  if($ProFile_com!="none" && $ProFile_com!=''){
    $UploadPath = "../../images/product/JBODJBOF/";
    $flag = copy($_FILES['ProFile_com']['tmp_name'], $UploadPath.$_FILES['ProFile_com']['name']);
  }

  $str_CPUSORTupd="update p_b_main_jbodjbof set CPUSORT='".$iconvals_valALL."'$spic$opic where MODELCODE='".$Model_value."'";
}else if($CPUSORT_CHK=="OCP Rack"){
  $OCPrackurl="~/images/product/OCPrack/";
  if($ProFile!="none" && $ProFile!=''){

    $UploadPath = "../../images/product/OCPrack/";
    $flag = copy($_FILES['ProFile']['tmp_name'], $UploadPath.$_FILES['ProFile']['name']);
    if($flag) echo "";

    $spic=",IMG='$OCPrackurl$ProFile'";
  }else if($ProFile=="none" && $ProFile==''){
    $spic="";
  }
  if($ProFile_S!="none" && $ProFile_S!=''){

    $UploadPath = "../../images/product/OCPrack/";
    $flag = copy($_FILES['ProFile_S']['tmp_name'], $UploadPath.$_FILES['ProFile_S']['name']);
    if($flag) echo "";

    $opic=",SMALLIMG='$OCPrackurl$ProFile_S'";
  }else if($ProFile_S=="none" && $ProFile_S==''){
    $opic="";
  }

  if($ProFile_com!="none" && $ProFile_com!=''){
    $UploadPath = "../../images/product/OCPrack/";
    $flag = copy($_FILES['ProFile_com']['tmp_name'], $UploadPath.$_FILES['ProFile_com']['name']);
  }

  $str_CPUSORTupd="update p_b_main_ocprack set CPUSORT='".$iconvals_valALL."'$spic$opic where MODELCODE='".$Model_value."'";
}else if($CPUSORT_CHK=="POS"){
  $POSrackurl="~/images/product/POS/";
  if($ProFile!="none" && $ProFile!=''){

    $UploadPath = "../../images/product/POS/";
    $flag = copy($_FILES['ProFile']['tmp_name'], $UploadPath.$_FILES['ProFile']['name']);
    if($flag) echo "";

    $spic=",IMG='$POSrackurl$ProFile'";
  }else if($ProFile=="none" && $ProFile==''){
    $spic="";
  }
  if($ProFile_S!="none" && $ProFile_S!=''){

    $UploadPath = "../../images/product/POS/";
    $flag = copy($_FILES['ProFile_S']['tmp_name'], $UploadPath.$_FILES['ProFile_S']['name']);
    if($flag) echo "";

    $opic=",SMALLIMG='$POSrackurl$ProFile_S'";
  }else if($ProFile_S=="none" && $ProFile_S==''){
    $opic="";
  }

  if($ProFile_com!="none" && $ProFile_com!=''){
    $UploadPath = "../../images/product/POS/";
    $flag = copy($_FILES['ProFile_com']['tmp_name'], $UploadPath.$_FILES['ProFile_com']['name']);
  }

  $str_CPUSORTupd="update p_b_main_pos set CPUSORT='".$iconvals_valALL."'$spic$opic where MODELCODE='".$Model_value."'";
}else if($CPUSORT_CHK=="5GEdgeComputing"){
  $POSrackurl="~/images/product/5G/"; //5GEdgeComputing
  if($ProFile!="none" && $ProFile!=''){

    $UploadPath = "../../images/product/5G/";
    $flag = copy($_FILES['ProFile']['tmp_name'], $UploadPath.$_FILES['ProFile']['name']);
    if($flag) echo "";

    $spic=",IMG='$POSrackurl$ProFile'";
  }else if($ProFile=="none" && $ProFile==''){
    $spic="";
  }
  if($ProFile_S!="none" && $ProFile_S!=''){

    $UploadPath = "../../images/product/5G/";
    $flag = copy($_FILES['ProFile_S']['tmp_name'], $UploadPath.$_FILES['ProFile_S']['name']);
    if($flag) echo "";

    $opic=",SMALLIMG='$POSrackurl$ProFile_S'";
  }else if($ProFile_S=="none" && $ProFile_S==''){
    $opic="";
  }

  if($ProFile_com!="none" && $ProFile_com!=''){
    $UploadPath = "../../images/product/5G/";
    $flag = copy($_FILES['ProFile_com']['tmp_name'], $UploadPath.$_FILES['ProFile_com']['name']);
  }

  $str_CPUSORTupd="update p_b_main_5G set CPUSORT='".$iconvals_valALL."'$spic$opic where MODELCODE='".$Model_value."'";
}else if($CPUSORT_CHK=="IntelDSG"){
  $POSrackurl="~/images/product/IntelDSG/"; //IntelDSG
  if($ProFile!="none" && $ProFile!=''){

    $UploadPath = "../../../IntelDSG/images/product/IntelDSG/";
    $flag = copy($_FILES['ProFile']['tmp_name'], $UploadPath.$_FILES['ProFile']['name']);
    if($flag) echo "";

    $spic=",IMG='$POSrackurl$ProFile'";
  }else if($ProFile=="none" && $ProFile==''){
    $spic="";
  }
  if($ProFile_S!="none" && $ProFile_S!=''){

    $UploadPath = "../../../IntelDSG/images/product/IntelDSG/";
    $flag = copy($_FILES['ProFile_S']['tmp_name'], $UploadPath.$_FILES['ProFile_S']['name']);
    if($flag) echo "";

    $opic=",SMALLIMG='$POSrackurl$ProFile_S'";
  }else if($ProFile_S=="none" && $ProFile_S==''){
    $opic="";
  }

  if($ProFile_com!="none" && $ProFile_com!=''){
    $UploadPath = "../../../IntelDSG/images/product/IntelDSG/";
    $flag = copy($_FILES['ProFile_com']['tmp_name'], $UploadPath.$_FILES['ProFile_com']['name']);
  }

  $str_CPUSORTupd="update p_b_main_inteldsg set CPUSORT='".$iconvals_valALL."'$spic$opic where MODELCODE='".$Model_value."'";
}

$CPUSORTupd_cmd=mysqli_query($link_db,$str_CPUSORTupd);

if($ProFile!='' || $ProFile_S!=''){
  if($ProFile!='' && $ProFile_S==''){
    $str_upd="UPDATE contents_product_skus SET CategoryModuID='".$categ_val."',ProductTypeID='".$SEL_PTYPE."',SKU='".$SKU_value."',MODELCODE='".$Model_value."',STATUS='".$stat01."',slang='".$str_lang."',Product_Info='".$PINFO_list."',".$bpic_val."".$P_File."Product_dsc='".$desc."',Relate_enable=".$relate_enable.",Relate_Prod='".$relProd_val."',Compat_enable=".$compat_enable.",Compat_Prod='".$compacProd_val."',upd_d='".$now."',upd_u='1706',IsnewUp='".$new_logo01."',ProductTypeID_SKU='".$PT1."', LandingTitle='".$LandTitle."',Coming_Soon='".$comingSoon."', ".$P_File_S." ProductFileCom='".$ProFile_com."', ";
    //2017.11.09 調整長度與新增的欄位名稱
    $str_upd.="FormFactor_val='".$FFactor_val."', MBprocessor_val='".$MBprocessor_val."', LAN_val='".$LAN_val."', COM_val='".$COM_val."', USB_val='".$USB_val."', SATA_val='".$SATA_val."', M2_Slot_val='".$M2Slot_val."', Mini_PCIe_val='".$Mini_PCIe_val."', PCIeSlot_val='".$PCIeSlot_val."', MBpower_val='".$MBpower_val."', Fanless_val='".$Fanless_val."', Modularized_IO_val='".$Modularized_IO_val."', WidgetTemperature_val='".$WidgetTemperature_val."', PanelSize_val='".$PanelSize_val."', EmbeddedPower_val='".$LandTitle."', legend_val='".$Legend1_val01."', Panel_PC_Power_val='".$Panel_PC_Power_val."', EmbeddedProcessor_val='".$EmbeddedProcessor_val."', Panel_PC_Processor_val='".$Panel_PC_Processor_val."', EmbeddedType_val='".$EmbeddedType_val."', PanelPCType_val='".$PanelPCType_val."' ";
    $str_upd.="WHERE Product_SContents_Auto_ID=".$pid01." and slang='".$lang01."'";
  }else if($ProFile=='' && $ProFile_S!=''){
    $str_upd="UPDATE contents_product_skus SET CategoryModuID='".$categ_val."',ProductTypeID='".$SEL_PTYPE."',SKU='".$SKU_value."',MODELCODE='".$Model_value."',STATUS='".$stat01."',slang='".$str_lang."',Product_Info='".$PINFO_list."',".$bpic_val."".$P_File."Product_dsc='".$desc."',Relate_enable=".$relate_enable.",Relate_Prod='".$relProd_val."',Compat_enable=".$compat_enable.",Compat_Prod='".$compacProd_val."',upd_d='".$now."',upd_u='1706',IsnewUp='".$new_logo01."',ProductTypeID_SKU='".$PT1."', LandingTitle='".$LandTitle."',Coming_Soon='".$comingSoon."', ".$P_File_S." ProductFileCom='".$ProFile_com."', ";
    $str_upd.="FormFactor_val='".$FFactor_val."', MBprocessor_val='".$MBprocessor_val."', LAN_val='".$LAN_val."', COM_val='".$COM_val."', USB_val='".$USB_val."', SATA_val='".$SATA_val."', M2_Slot_val='".$M2Slot_val."', Mini_PCIe_val='".$Mini_PCIe_val."', PCIeSlot_val='".$PCIeSlot_val."', MBpower_val='".$MBpower_val."', Fanless_val='".$Fanless_val."', Modularized_IO_val='".$Modularized_IO_val."', WidgetTemperature_val='".$WidgetTemperature_val."', PanelSize_val='".$PanelSize_val."', EmbeddedPower_val='".$EmbeddedPower_val."', legend_val='".$Legend1_val01."', Panel_PC_Power_val='".$Panel_PC_Power_val."', EmbeddedProcessor_val='".$EmbeddedProcessor_val."', Panel_PC_Processor_val='".$Panel_PC_Processor_val."', EmbeddedType_val='".$EmbeddedType_val."', PanelPCType_val='".$PanelPCType_val."' ";
    $str_upd.="WHERE Product_SContents_Auto_ID=".$pid01." and slang='".$lang01."'";
  }else if($ProFile!='' && $ProFile_S!=''){
    $str_upd="UPDATE contents_product_skus SET CategoryModuID='".$categ_val."',ProductTypeID='".$SEL_PTYPE."',SKU='".$SKU_value."',MODELCODE='".$Model_value."',STATUS='".$stat01."',slang='".$str_lang."',Product_Info='".$PINFO_list."',".$bpic_val."".$P_File."Product_dsc='".$desc."',Relate_enable=".$relate_enable.",Relate_Prod='".$relProd_val."',Compat_enable=".$compat_enable.",Compat_Prod='".$compacProd_val."',upd_d='".$now."',upd_u='1706',IsnewUp='".$new_logo01."',ProductTypeID_SKU='".$PT1."', LandingTitle='".$LandTitle."',Coming_Soon='".$comingSoon."', ".$P_File_S." ProductFileCom='".$ProFile_com."', ";
    $str_upd.="FormFactor_val='".$FFactor_val."', MBprocessor_val='".$MBprocessor_val."', LAN_val='".$LAN_val."', COM_val='".$COM_val."', USB_val='".$USB_val."', SATA_val='".$SATA_val."', M2_Slot_val='".$M2Slot_val."', Mini_PCIe_val='".$Mini_PCIe_val."', PCIeSlot_val='".$PCIeSlot_val."', MBpower_val='".$MBpower_val."', Fanless_val='".$Fanless_val."', Modularized_IO_val='".$Modularized_IO_val."', WidgetTemperature_val='".$WidgetTemperature_val."', PanelSize_val='".$PanelSize_val."', EmbeddedPower_val='".$EmbeddedPower_val."', legend_val='".$Legend1_val01."', Panel_PC_Power_val='".$Panel_PC_Power_val."', EmbeddedProcessor_val='".$EmbeddedProcessor_val."', Panel_PC_Processor_val='".$Panel_PC_Processor_val."', EmbeddedType_val='".$EmbeddedType_val."', PanelPCType_val='".$PanelPCType_val."' ";
    $str_upd.="WHERE Product_SContents_Auto_ID=".$pid01." and slang='".$lang01."'";
  }
    //$str_upd="UPDATE contents_product_skus SET CategoryModuID='".$categ_val."',ProductTypeID='".$SEL_PTYPE."',SKU='".$SKU_value."',MODELCODE='".$Model_value."',STATUS='".$stat01."',slang='".$str_lang."',Product_Info='".$PINFO_list."',".$bpic_val."".$P_File."Product_dsc='".$desc."',Relate_enable=".$relate_enable.",Relate_Prod='".$relProd_val."',Compat_enable=".$compat_enable.",Compat_Prod='".$compacProd_val."',upd_d='".$now."',upd_u='1706',IsnewUp='".$new_logo01."',ProductTypeID_SKU='".$PT1."', LandingTitle='".$LandTitle."',Coming_Soon='".$comingSoon."', ".$P_File_S." ProductFileCom='".$ProFile_com."', ";
    //$str_spupd="UPDATE product_skus SET SKU='".$SKU_value."', MODELCODE='".$Model_value."', Web_Disable=".$sku_stat01.",upd_d='".$now."', upd_u='1706', slang='".$str_lang."' where Product_SKU_Auto_ID=".$pid01;
    $str_icoupd="UPDATE contents_product_skus SET Product_Icons='".$iconvals."', Product_Icons_b='".$iconvals_b."' WHERE Product_SContents_Auto_ID=".$pid01;

}else if($ProFile=='' && $ProFile_S==''){

    $str_upd="UPDATE contents_product_skus SET CategoryModuID='".$categ_val."',ProductTypeID='".$SEL_PTYPE."',SKU='".$SKU_value."',MODELCODE='".$Model_value."',STATUS='".$stat01."',slang='".$str_lang."',Product_Info='".$PINFO_list."',".$bpic_val."".$P_File."Product_dsc='".$desc."',Relate_enable=".$relate_enable.",Relate_Prod='".$relProd_val."',Compat_enable=".$compat_enable.",Compat_Prod='".$compacProd_val."',upd_d='".$now."',upd_u='1706',IsnewUp='".$new_logo01."',ProductTypeID_SKU='".$PT1."', LandingTitle='".$LandTitle."',Coming_Soon='".$comingSoon."', ".$P_File_S." ProductFileCom='".$ProFile_com."', ";
    $str_upd.="FormFactor_val='".$FFactor_val."', MBprocessor_val='".$MBprocessor_val."', LAN_val='".$LAN_val."', COM_val='".$COM_val."', USB_val='".$USB_val."', SATA_val='".$SATA_val."', M2_Slot_val='".$M2Slot_val."', Mini_PCIe_val='".$Mini_PCIe_val."', PCIeSlot_val='".$PCIeSlot_val."', MBpower_val='".$MBpower_val."', Fanless_val='".$Fanless_val."', Modularized_IO_val='".$Modularized_IO_val."', WidgetTemperature_val='".$WidgetTemperature_val."', PanelSize_val='".$PanelSize_val."', EmbeddedPower_val='".$EmbeddedPower_val."', legend_val='".$Legend1_val01."', Panel_PC_Power_val='".$Panel_PC_Power_val."', EmbeddedProcessor_val='".$EmbeddedProcessor_val."', Panel_PC_Processor_val='".$Panel_PC_Processor_val."', EmbeddedType_val='".$EmbeddedType_val."', PanelPCType_val='".$PanelPCType_val."' ";
    $str_upd.="WHERE Product_SContents_Auto_ID=".$pid01." and slang='".$lang01."'";
    $str_icoupd="UPDATE contents_product_skus SET Product_Icons='".$iconvals."', Product_Icons_b='".$iconvals_b."' WHERE Product_SContents_Auto_ID=".$pid01;
    $str_spupd="UPDATE product_skus SET SKU='".$SKU_value."', MODELCODE='".$Model_value."', Web_Disable=".$sku_stat01.",upd_d='".$now."', upd_u='1706', slang='".$str_lang."' where Product_SKU_Auto_ID=".$pid01;
}
$spupd_record=mysqli_query($link_db,$str_spupd);
$str_icoupd_record=mysqli_query($link_db,$str_icoupd);
$upd_record=mysqli_query($link_db,$str_upd) or die(mysqli_error($link_db));


/*$str_cate01="SELECT CategoryModuID, CategoryModuName, CategIntroduction, Meta_Des, Prod_Info_Sorting, Web_Disable FROM category_module_las where CategoryModuID=".$categ_val;
$cate01_cmd=mysqli_query($link_db,$str_cate01);
$cate01_data=mysqli_fetch_row($cate01_cmd);
$CA01=trim($cate01_data[1]);
$Intro=trim($cate01_data[2]);

$td01="";
if($Proc1_val01_name!=''){
	$td01.=$Proc1_val01_name;
}
if($SockT1_val01_name!=""){
	$td01.=$SockT1_val01_name;
}
if($SockN1_val01_name!=""){
	$td01.=$SockN1_val01_name;
}
if($Chip1_val01_name!=""){
	$td01.=$Chip1_val01_name;
}
if($Factor1_val01_name!=""){
	$td01.=$Factor1_val01_name;
}
if($AdapterT1_val01_name!=""){
	$td01.=$AdapterT1_val01_name;
}
if($Rackm1_val01_name!=""){
	$td01.=$Rackm1_val01_name;
}
if($Cpu1_val01_name!=""){
	$td01.=$Cpu1_val01_name;
}
if($ServT1_val01_name!=""){
	$td01.=$ServT1_val01_name;
}
if($Appl1_val01_name!=""){
	$td01.=$Appl1_val01_name;
}
if($Hdd1_val01_name!=""){
    $td01.=$Hdd1_val01_name;
}
if($PwerSp1_val01_name!=""){
    $td01.=$PwerSp1_val01_name;
}
if($ChassT1_val01_name!=""){
	$td01.=$ChassT1_val01_name;
}
if($JBDT1_val01_name!=""){
	$td01.=$JBDT1_val01_name;
}
if($AccesT1_val01_name!=""){
	$td01.=$AccesT1_val01_name;
}
if($DIMM_val01_name!=""){
  $td01.=$DIMM_val01_name;
}
if($LAN_val01_name!=""){
  $td01.=$LAN_val01_name;
}
if($Storage_val01_name!=""){
  $td01.=$Storage_val01_name;
}
if($StorageBay_val01_name!=""){
  $td01.=$StorageBay_val01_name;
}
if($PSU_val01_name!=""){
  $td01.=$PSU_val01_name;
}
if($Other_val01_name!=""){
  $td01.=$Other_val01_name;
}
if($Type_val01_name!=""){
  $td01.=$Type_val01_name;
}


$td00="<th style='font-size:10px;'>SKU</th>".$td01;

$tr01="";$proc1="";$sokt1="";$sokn1="";$chip1="";$ffat1="";$rkmn1="";$adpt1="";$acst1="";$cpus1="";$srvt1="";$appl1="";$hdd1="";$pwsp1="";$chast1="";$jbdt1="";
$url_MB="";$url_BB="";$url_NIC="";$url_BBPower8="";$url_Chassic="";$url_TPM="";
$IsEol01="";

$str_tbl1="SELECT SKU, FormFactor_val, MBprocessor_val, LAN_val, COM_val, USB_val, SATA_val, M2_Slot_val, Mini_PCIe_val, PCIeSlot_val, MBpower_val, Fanless_val, Modularized_IO_val, WidgetTemperature_val, PanelSize_val, EmbeddedPower_val, Panel_PC_Power_val, EmbeddedProcessor_val, Panel_PC_Processor_val, EmbeddedType_val, PanelPCType_val";
$str_tbl1.=" FROM contents_product_skus where CategoryModuID=".$categ_val." and slang='".$str_lang."' and STATUS='1' order by crea_d desc";
$tbl1_cmd=mysqli_query($link_db,$str_tbl1);
while($tbl1_data=mysqli_fetch_row($tbl1_cmd)){

		$str_MB="SELECT a.ProductTypeID,a.MODELCODE,a.STATUS,a.Product_Info,a.SKU,a.Product_SContents_Auto_ID,a.ProductSFile,a.IsnewUp,b.IS_EOL FROM contents_product_skus a inner join (SELECT Product_SKU_Auto_ID,IS_EOL FROM product_skus) b on a.Product_SContents_Auto_ID=b.Product_SKU_Auto_ID" .
			   " WHERE (a.ProductTypeID_SKU between 101 and 102) AND ((Replace(a.MODELCODE,'-','') like '%".str_replace('-','',$tbl1_data[0])."%' ) OR a.SKU like '%".str_replace(' ','%',$tbl1_data[0])."%') AND (a.slang='EN,') AND a.STATUS='1' " .
			   " order by a.Product_SContents_Auto_ID";
		mysqli_query($link_db, 'SET NAMES utf8');
		$MB_cmd=mysqli_query($link_db,$str_MB);
		$MB_data=mysqli_fetch_row($MB_cmd);
		$Data_MBrecord_num=mysqli_num_rows($MB_cmd);
		if(ord($MB_data[8])=='1'){
		$IsEol01="&nbsp;<span class='label label-default'>EOL</span>&nbsp;";
		}else{
		$IsEol01="";
		}
		if($MB_data[7]=='1'){
		$IsnewUp01="<span class='label label-danger'>New!</span>";
		}else{
		$IsnewUp01="";
		}
		if($Data_MBrecord_num>0){
			if($str_lang!=''){
			if($str_lang=="EN,"){
			$url_MB="<a href='/Motherboards_".$tbl1_data[12]."_".$tbl1_data[0]."'>".$tbl1_data[0].$IsEol01.$IsnewUp01."</a>";
			}else{
			$url_MB="<a href='/".str_replace(",","",$str_lang)."_Motherboards_".$tbl1_data[12]."_".$tbl1_data[0]."'>".$tbl1_data[0].$IsEol01.$IsnewUp01."</a>";
			}
			}
		}else{
			$url_MB="";
		}

		$str_BB="SELECT a.ProductTypeID,a.MODELCODE,a.STATUS,a.Product_Info,a.SKU,a.Product_SContents_Auto_ID,a.ProductSFile,a.IsnewUp,b.IS_EOL FROM contents_product_skus a inner join (SELECT Product_SKU_Auto_ID,IS_EOL FROM product_skus) b on a.Product_SContents_Auto_ID=b.Product_SKU_Auto_ID " .
			    " WHERE (a.ProductTypeID_SKU between 103 and 104) AND ((Replace(a.MODELCODE,'-','') like '%".str_replace('-','',$tbl1_data[0])."%' ) OR a.SKU ='".$tbl1_data[0]."') AND (a.slang='EN,') AND a.STATUS='1' " .
			    " order by a.Product_SContents_Auto_ID";
		mysqli_query($link_db, 'SET NAMES utf8');
		$BB_cmd=mysqli_query($link_db,$str_BB);
		$BB_data=mysqli_fetch_row($BB_cmd);
		$Data_BBrecord_num=mysqli_num_rows($BB_cmd);
		if(ord($BB_data[8])=='1'){
		$IsEol01="&nbsp;<span class='label label-default'>EOL</span>&nbsp;";
		}else{
		$IsEol01="";
		}
		if($BB_data[7]=='1'){
		$IsnewUp01="<span class='label label-danger'>New!</span>";
		}else{
		$IsnewUp01="";
		}
		if($Data_BBrecord_num>0){
			if($str_lang!=''){
			if($str_lang=="EN,"){
			$url_BB="<a href='/Barebones_".$tbl1_data[12]."_".$tbl1_data[0]."'>".$tbl1_data[0]."</a> ".$IsEol01.$IsnewUp01;
			}else{
			$url_BB="<a href='/".str_replace(",","",$str_lang)."_Barebones_".$tbl1_data[12]."_".$tbl1_data[0]."'>".$tbl1_data[0]."</a> ".$IsEol01.$IsnewUp01;
			}
			}
		}else{
			$url_BB="";
		}

		$str_NIC="SELECT a.ProductTypeID,a.MODELCODE,a.STATUS,a.Product_Info,a.SKU,a.Product_SContents_Auto_ID,a.ProductSFile,a.IsnewUp,b.IS_EOL FROM contents_product_skus a inner join (SELECT Product_SKU_Auto_ID,IS_EOL FROM product_skus) b on a.Product_SContents_Auto_ID=b.Product_SKU_Auto_ID " .
				 " WHERE (a.ProductTypeID_SKU=105) AND ((Replace(a.MODELCODE,'-','') like '%".str_replace('-','',$tbl1_data[0])."%' ) OR a.SKU like '%".str_replace(' ','%',$tbl1_data[0])."%') AND (a.slang='EN,') AND a.STATUS='1' " .
			     " order by a.Product_SContents_Auto_ID";
		mysqli_query($link_db, 'SET NAMES utf8');
		$NIC_cmd=mysqli_query($link_db,$str_NIC);
		$NIC_data=mysqli_fetch_row($NIC_cmd);
		$Data_NICrecord_num=mysqli_num_rows($NIC_cmd);
		if(ord($NIC_data[8])=='1'){
		$IsEol01="&nbsp;<span class='label label-default'>EOL</span>&nbsp;";
		}else{
		$IsEol01="";
		}
		if($NIC_data[7]=='1'){
		$IsnewUp01="<span class='label label-danger'>New!</span>";
		}else{
		$IsnewUp01="";
		}
		if($Data_NICrecord_num>0){
			if($str_lang!=''){
			if($str_lang=="EN,"){
			$url_NIC="<a href='/NIC_".$tbl1_data[12]."_".$tbl1_data[0]."'>".$tbl1_data[0]."</a> ".$IsEol01.$IsnewUp01;
			}else{
			$url_NIC="<a href='/".str_replace(",","",$str_lang)."_NIC_".$tbl1_data[12]."_".$tbl1_data[0]."'>".$tbl1_data[0]."</a> ".$IsEol01.$IsnewUp01;
			}
			}
		}else{
			$url_NIC="";
		}

		$str_HBA="SELECT a.ProductTypeID,a.MODELCODE,a.STATUS,a.Product_Info,a.SKU,a.Product_SContents_Auto_ID,a.ProductSFile,a.IsnewUp,b.IS_EOL,a.IsnewUp FROM contents_product_skus a inner join (SELECT Product_SKU_Auto_ID,IS_EOL FROM product_skus) b on a.Product_SContents_Auto_ID=b.Product_SKU_Auto_ID " .
				 " WHERE (a.ProductTypeID_SKU=106) AND ((Replace(a.MODELCODE,'-','') like '%".str_replace('-','',$tbl1_data[0])."%' ) OR a.SKU like '%".str_replace(' ','%',$tbl1_data[0])."%') AND (a.slang='EN,') AND a.STATUS='1' " .
			     " order by a.Product_SContents_Auto_ID";
		mysqli_query($link_db, 'SET NAMES utf8');
		$HBA_cmd=mysqli_query($link_db,$str_HBA);
		$HBA_data=mysqli_fetch_row($HBA_cmd);
		$Data_HBArecord_num=mysqli_num_rows($HBA_cmd);
		if(ord($HBA_data[8])=='1'){
		$IsEol01="&nbsp;<span class='label label-default'>EOL</span>&nbsp;";
		}else{
		$IsEol01="";
		}
		if($HBA_data[9]=='1'){
		$IsnewUp01="<span class='label label-danger'>New!</span>";
		}else{
		$IsnewUp01="";
		}
		if($Data_HBArecord_num>0){
			if($str_lang!=''){
			if($str_lang=="EN,"){
			$url_HBA="<a href='/HBA_".$tbl1_data[12]."_".$tbl1_data[0]."'>".$tbl1_data[0]."</a> ".$IsEol01.$IsnewUp01;
			}else{
			$url_HBA="<a href='/".str_replace(",","",$str_lang)."_HBA_".$tbl1_data[12]."_".$tbl1_data[0]."'>".$tbl1_data[0]."</a> ".$IsEol01.$IsnewUp01;
			}
			}
		}else{
			$url_HBA="";
		}

		$str_BBPower8="SELECT a.ProductTypeID,a.MODELCODE,a.STATUS,a.Product_Info,a.SKU,a.Product_SContents_Auto_ID,a.ProductSFile,a.IsnewUp,b.IS_EOL,a.IsnewUp FROM contents_product_skus a inner join (SELECT Product_SKU_Auto_ID,IS_EOL FROM product_skus) b on a.Product_SContents_Auto_ID=b.Product_SKU_Auto_ID " .
			    " WHERE (a.ProductTypeID_SKU=108) AND ((Replace(a.MODELCODE,'-','') like '%".str_replace('-','',$tbl1_data[0])."%' ) OR a.SKU like '%".str_replace(' ','%',$tbl1_data[0])."%') AND (a.slang='EN,') AND a.STATUS='1' " .
			    " order by a.Product_SContents_Auto_ID";
		mysqli_query($link_db, 'SET NAMES utf8');
		$BBPower8_cmd=mysqli_query($link_db,$str_BBPower8);
		$BBPower8_data=mysqli_fetch_row($BBPower8_cmd);
		$Data_BBPower8record_num=mysqli_num_rows($BBPower8_cmd);
		if(ord($BBPower8_data[8])=='1'){
		$IsEol01="&nbsp;<span class='label label-default'>EOL</span>&nbsp;";
		}else{
		$IsEol01="";
		}
		if($BBPower8_data[9]=='1'){
		$IsnewUp01="<span class='label label-danger'>New!</span>";
		}else{
		$IsnewUp01="";
		}
		if($Data_BBPower8record_num>0){
			if($str_lang!=''){
			if($str_lang=="EN,"){
			$url_BBPower8="<a href='/Barebones_".$tbl1_data[12]."_".$tbl1_data[0]."'>".$tbl1_data[0]."</a> ".$IsEol01.$IsnewUp01;
			}else{
			$url_BBPower8="<a href='/".str_replace(",","",$str_lang)."_Barebones_".$tbl1_data[12]."_".$tbl1_data[0]."'>".$tbl1_data[0]."</a> ".$IsEol01.$IsnewUp01;
			}
			}
		}else{
			$url_BBPower8="";
		}

		$str_JBOD="SELECT a.ProductTypeID,a.MODELCODE,a.STATUS,a.Product_Info,a.SKU,a.Product_SContents_Auto_ID,a.ProductSFile,a.IsnewUp,b.IS_EOL,a.IsnewUp FROM contents_product_skus a inner join (SELECT Product_SKU_Auto_ID,IS_EOL FROM product_skus) b on a.Product_SContents_Auto_ID=b.Product_SKU_Auto_ID " .
			    " WHERE (a.ProductTypeID_SKU=117) AND ((Replace(a.MODELCODE,'-','') like '%".str_replace('-','',$tbl1_data[0])."%' ) OR a.SKU like '%".str_replace(' ','%',$tbl1_data[0])."%') AND (a.slang='EN,') AND a.STATUS='1' " .
			    " order by a.Product_SContents_Auto_ID";
		mysqli_query($link_db, 'SET NAMES utf8');
		$JBOD_cmd=mysqli_query($link_db,$str_JBOD);
		$JBOD_data=mysqli_fetch_row($JBOD_cmd);
		$Data_JBODrecord_num=mysqli_num_rows($JBOD_cmd);
		if(ord($JBOD_data[8])=='1'){
		$IsEol01="&nbsp;<span class='label label-default'>EOL</span>&nbsp;";
		}else{
		$IsEol01="";
		}
		if($JBOD_data[9]=='1'){
		$IsnewUp01="<span class='label label-danger'>New!</span>";
		}else{
		$IsnewUp01="";
		}
		if($Data_JBODrecord_num>0){
			if($str_lang!=''){
			if($str_lang=="EN,"){
			$url_JBOD="<a href='/JBOD_".$tbl1_data[12]."_".$tbl1_data[0]."'>".$tbl1_data[0]."</a> ".$IsEol01.$IsnewUp01;
			}else{
			$url_JBOD="<a href='/".str_replace(",","",$str_lang)."_JBOD_".$tbl1_data[12]."_".$tbl1_data[0]."'>".$tbl1_data[0]."</a> ".$IsEol01.$IsnewUp01;
			}
			}
		}else{
			$url_JBOD="";
		}

		$str_Chassic="SELECT a.ProductTypeID,a.MODELCODE,a.STATUS,a.Product_Info,a.SKU,a.Product_SContents_Auto_ID,a.ProductSFile,a.IsnewUp,b.IS_EOL,a.IsnewUp FROM contents_product_skus a inner join (SELECT Product_SKU_Auto_ID,IS_EOL FROM product_skus) b on a.Product_SContents_Auto_ID=b.Product_SKU_Auto_ID " .
				" WHERE (a.ProductTypeID_SKU=107) AND ((Replace(a.MODELCODE,'-','') like '%".str_replace('-','',$tbl1_data[0])."%' ) OR a.SKU like '%".str_replace(' ','%',$tbl1_data[0])."%') AND (a.slang='EN,') AND a.STATUS='1' " .
				" order by a.Product_SContents_Auto_ID";
		mysqli_query($link_db, 'SET NAMES utf8');
		$Chassic_cmd=mysqli_query($link_db,$str_Chassic);
		$Chassic_data=mysqli_fetch_row($Chassic_cmd);
		$Data_Chassicrecord_num=mysqli_num_rows($Chassic_cmd);
		if(ord($Chassic_data[8])=='1'){
		$IsEol01="&nbsp;<span class='label label-default'>EOL</span>&nbsp;";
		}else{
		$IsEol01="";
		}
		if($Chassic_data[9]=='1'){
		$IsnewUp01="<span class='label label-danger'>New!</span>";
		}else{
		$IsnewUp01="";
		}
		if($Data_Chassicrecord_num>0){
			if($str_lang!=''){
			if($str_lang=="EN,"){
			$url_Chassic="<a href='/Chassis_".$tbl1_data[12]."_".$tbl1_data[0]."'>".$tbl1_data[0]."</a> ".$IsEol01.$IsnewUp01;
            }else{
			$url_Chassic="<a href='/".str_replace(",","",$str_lang)."_Chassis_".$tbl1_data[12]."_".$tbl1_data[0]."'>".$tbl1_data[0]."</a> ".$IsEol01.$IsnewUp01;
			}
			}
		}else{
			$url_Chassic="";
		}

		$str_TPM="SELECT a.ProductTypeID,a.MODELCODE,a.STATUS,a.Product_Info,a.SKU,a.Product_SContents_Auto_ID,a.ProductSFile,a.IsnewUp,b.IS_EOL,a.IsnewUp FROM contents_product_skus a inner join (SELECT Product_SKU_Auto_ID,IS_EOL FROM product_skus) b on a.Product_SContents_Auto_ID=b.Product_SKU_Auto_ID " .
				" WHERE (a.ProductTypeID_SKU=1109) AND ((Replace(a.MODELCODE,'-','') like '%".str_replace('-','',$tbl1_data[0])."%' ) OR a.SKU like '%".str_replace(' ','%',$tbl1_data[0])."%') AND (a.slang='EN,') AND a.STATUS='1' " .
				" order by a.Product_SContents_Auto_ID";
		mysqli_query($link_db, 'SET NAMES utf8');
		$TPM_cmd=mysqli_query($link_db,$str_TPM);
		$TPM_data=mysqli_fetch_row($TPM_cmd);
		$Data_TPMrecord_num=mysqli_num_rows($TPM_cmd);
		if(ord($TPM_data[8])=='1'){
		$IsEol01="&nbsp;<span class='label label-default'>EOL</span>&nbsp;";
		}else{
		$IsEol01="";
		}
		if($TPM_data[9]=='1'){
		$IsnewUp01="<span class='label label-danger'>New!</span>";
		}else{
		$IsnewUp01="";
		}
		if($Data_TPMrecord_num>0){
			if($str_lang!=''){
			if($str_lang=="EN,"){
			$url_TPM="<a href='/TPM_".$tbl1_data[12]."_".$tbl1_data[0]."'>".$tbl1_data[0].$IsEol01.$IsnewUp01."</a>";
			}else{
			$url_TPM="<a href='/".str_replace(",","",$str_lang)."_TPM_".$tbl1_data[12]."_".$tbl1_data[0]."'>".$tbl1_data[0].$IsEol01.$IsnewUp01."</a>";
			}
			}
		}else{
			$url_TPM="";
		}

    $str_GPU="SELECT a.ProductTypeID,a.MODELCODE,a.STATUS,a.Product_Info,a.SKU,a.Product_SContents_Auto_ID,a.ProductSFile,a.IsnewUp,b.IS_EOL,a.IsnewUp FROM contents_product_skus a inner join (SELECT Product_SKU_Auto_ID,IS_EOL FROM product_skus) b on a.Product_SContents_Auto_ID=b.Product_SKU_Auto_ID " .
        " WHERE (a.ProductTypeID_SKU=1111) AND ((Replace(a.MODELCODE,'-','') like '%".$tbl1_data[0]."%')  OR a.SKU like '%".str_replace(' ','%',$tbl1_data[0])."%') AND (a.slang='EN,') AND a.STATUS='1' " .
        " order by a.Product_SContents_Auto_ID";
    mysqli_query($link_db, 'SET NAMES utf8');
    $GPU_cmd=mysqli_query($link_db,$str_GPU);
    $GPU_data=mysqli_fetch_row($GPU_cmd);
    $Data_GPUrecord_num=mysqli_num_rows($GPU_cmd);
    if(ord($GPU_data[8])=='1'){
    $IsEol01="&nbsp;<span class='label label-default'>EOL</span>&nbsp;";
    }else{
    $IsEol01="";
    }
    if($GPU_data[9]=='1'){
    $IsnewUp01="<span class='label label-danger'>New!</span>";
    }else{
    $IsnewUp01="";
    }
    if($Data_GPUrecord_num>0){
      if($str_lang!=''){
      if($str_lang=="EN,"){
      $url_GPU="<a href='/GPULANMezz_".$tbl1_data[12]."_".$tbl1_data[0]."'>".$tbl1_data[0].$IsEol01.$IsnewUp01."</a>";
      }else{
      $url_GPU="<a href='/".str_replace(",","",$str_lang)."_GPULANMezz_".$tbl1_data[12]."_".$tbl1_data[0]."'>".$tbl1_data[0].$IsEol01.$IsnewUp01."</a>";
      }
      }
    }else{
      $url_GPU="";
    }

    $str_OCP="SELECT a.ProductTypeID,a.MODELCODE,a.STATUS,a.Product_Info,a.SKU,a.Product_SContents_Auto_ID,a.ProductSFile,a.IsnewUp,b.IS_EOL,a.IsnewUp FROM contents_product_skus a inner join (SELECT Product_SKU_Auto_ID,IS_EOL FROM product_skus) b on a.Product_SContents_Auto_ID=b.Product_SKU_Auto_ID " .
        " WHERE (a.ProductTypeID_SKU=1112) AND ((Replace(a.MODELCODE,'-','') like '%".$tbl1_data[0]."%' ) OR a.SKU like '%".str_replace(' ','%',$tbl1_data[0])."%') AND (a.slang='EN,') AND a.STATUS='1' " .
        " order by a.Product_SContents_Auto_ID";
    mysqli_query($link_db, 'SET NAMES utf8');
    $OCP_cmd=mysqli_query($link_db,$str_OCP);
    $OCP_data=mysqli_fetch_row($OCP_cmd);
    $Data_OCPrecord_num=mysqli_num_rows($OCP_cmd);
    if(ord($OCP_data[8])=='1'){
    $IsEol01="&nbsp;<span class='label label-default'>EOL</span>&nbsp;";
    }else{
    $IsEol01="";
    }
    if($OCP_data[9]=='1'){
    $IsnewUp01="<span class='label label-danger'>New!</span>";
    }else{
    $IsnewUp01="";
    }
    if($Data_OCPrecord_num>0){
      if($str_lang!=''){
        if($str_lang=="EN,"){
          $url_OCP="<a href='/OCPLANMezz_".$tbl1_data[12]."_".$tbl1_data[0]."'>".$tbl1_data[0].$IsEol01.$IsnewUp01."</a>";
        }else{
          $url_OCP="<a href='/".str_replace(",","",$str_lang)."_OCPLANMezz_".$tbl1_data[12]."_".$tbl1_data[0]."'>".$tbl1_data[0].$IsEol01.$IsnewUp01."</a>";
        }
      }
    }else{
      $url_OCP="";
    }

    $str_Storage="SELECT a.ProductTypeID,a.MODELCODE,a.STATUS,a.Product_Info,a.SKU,a.Product_SContents_Auto_ID,a.ProductSFile,a.IsnewUp,b.IS_EOL,a.IsnewUp FROM contents_product_skus a inner join (SELECT Product_SKU_Auto_ID,IS_EOL FROM product_skus) b on a.Product_SContents_Auto_ID=b.Product_SKU_Auto_ID " .
        " WHERE (a.ProductTypeID_SKU=1113) AND ((Replace(a.MODELCODE,'-','') like '%".$tbl1_data[0]."%' ) OR a.SKU like '%".str_replace(' ','%',$tbl1_data[0])."%') AND (a.slang='EN,') AND a.STATUS='1' " .
        " order by a.Product_SContents_Auto_ID";
    mysqli_query($link_db, 'SET NAMES utf8');
    $Storage_cmd=mysqli_query($link_db,$str_Storage);
    $Storage_data=mysqli_fetch_row($Storage_cmd);
    $Data_Storagerecord_num=mysqli_num_rows($Storage_cmd);
    if(ord($Storage_data[8])=='1'){
    $IsEol01="&nbsp;<span class='label label-default'>EOL</span>&nbsp;";
    }else{
    $IsEol01="";
    }
    if($Storage_data[9]=='1'){
    $IsnewUp01="<span class='label label-danger'>New!</span>";
    }else{
    $IsnewUp01="";
    }
    if($Data_Storagerecord_num>0){
      if($str_lang!=''){
      if($str_lang=="EN,"){
      $url_Storage="<a href='/StorageCards_".$tbl1_data[12]."_".$tbl1_data[0]."'>".$tbl1_data[0].$IsEol01.$IsnewUp01."</a>";
      }else{
      $url_Storage="<a href='/".str_replace(",","",$str_lang)."_StorageCards_".$tbl1_data[12]."_".$tbl1_data[0]."'>".$tbl1_data[0].$IsEol01.$IsnewUp01."</a>";
      }
      }
    }else{
      $url_Storage="";
    }

    $str_risercard="SELECT a.ProductTypeID,a.MODELCODE,a.STATUS,a.Product_Info,a.SKU,a.Product_SContents_Auto_ID,a.ProductSFile,a.IsnewUp,b.IS_EOL,a.IsnewUp FROM contents_product_skus a inner join (SELECT Product_SKU_Auto_ID,IS_EOL FROM product_skus) b on a.Product_SContents_Auto_ID=b.Product_SKU_Auto_ID " .
        " WHERE (a.ProductTypeID_SKU=1110) AND ((Replace(a.MODELCODE,'-','') like '%".$tbl1_data[0]."%' ) OR a.SKU like '%".str_replace(' ','%',$tbl1_data[0])."%') AND (a.slang='EN,') AND a.STATUS='1' " .
        " order by a.Product_SContents_Auto_ID";
    mysqli_query($link_db, 'SET NAMES utf8');

    $risercard_cmd=mysqli_query($link_db,$str_risercard);
    $risercard_data=mysqli_fetch_row($risercard_cmd);
    $Data_risercardrecord_num=mysqli_num_rows($risercard_cmd);
    if(ord($risercard_data[8])=='1'){
    $IsEol01="&nbsp;<span class='label label-default'>EOL</span>&nbsp;";
    }else{
    $IsEol01="";
    }
    if($risercard_data[9]=='1'){
    $IsnewUp01="<span class='label label-danger'>New!</span>";
    }else{
    $IsnewUp01="";
    }
    if($Data_risercardrecord_num>0){
      if($str_lang!=''){
      if($str_lang=="EN,"){
      $url_risercard="<a href='/risercard_".$tbl1_data[12]."_".$tbl1_data[0]."'>".$tbl1_data[0].$IsEol01.$IsnewUp01."</a>";
      }else{
      $url_risercard="<a href='/".str_replace(",","",$str_lang)."_risercard_".$tbl1_data[12]."_".$tbl1_data[0]."'>".$tbl1_data[0].$IsEol01.$IsnewUp01."</a>";
      }
      }
    }else{
      $url_risercard="";
    }

		if($url_MB!=''){
			$urls=$url_MB;
		}else if($url_BB!=''){
			$urls=$url_BB;
		}else if($url_NIC!=''){
			$urls=$url_NIC;
		}else if($url_HBA!=''){
			$urls=$url_HBA;
		}else if($url_BBPower8!=''){
			$urls=$url_BBPower8;
		}else if($url_JBOD!=''){
		    $urls=$url_JBOD;
		}else if($url_Chassic!=''){
			$urls=$url_Chassic;
		}else if($url_TPM!=''){
      $urls=$url_TPM;
    }else if($url_GPU!=''){
      $urls=$url_GPU;
    }else if($url_OCP!=''){
      $urls=$url_OCP;
    }else if($url_Storage!=''){
      $urls=$url_Storage;
    }else if($url_Storage!=''){
      $urls=$url_Storage;
    }else if($url_risercard!=''){
      $urls=$url_risercard;
    }

		$sku1="<td style='font-size:10px;'>".$urls."</td>";

	if($tbl1_data[1]!=''){
	  $tbl01_split=explode(',',$tbl1_data[1],-1);
	  $tbl01_count=count(explode(',',$tbl1_data[1],-1));
      foreach($tbl01_split as $tbl01_splitVal){
	    $str_infoval1="SELECT PIV_id, PIV_Value FROM product_infovalue_las where PIV_id=".intval($tbl01_splitVal);
	    $infoval1_cmd=mysqli_query($link_db,$str_infoval1);
	    $infoval1_data=mysqli_fetch_row($infoval1_cmd);
		if($tbl01_count>1){
	    $infoval1_data_all=$infoval1_data_all.$infoval1_data[1].",";
		}else{
		$infoval1_data_all=$infoval1_data[1];
		}
	  }
	  if($Proc1_val01_name!=''){
	    $proc1="<td style='font-size:10px;'>".$infoval1_data_all."</td>";
	  }else{
		$proc1="";
	  }

	}else{
	$proc1="";
	}
	if($tbl1_data[2]!=''){
	  $tbl02_split=explode(',',$tbl1_data[2],-1);
	  $tbl02_count=count(explode(',',$tbl1_data[2],-1));
      foreach($tbl02_split as $tbl02_splitVal){
	    $str_infoval2="SELECT PIV_id, PIV_Value FROM product_infovalue_las where PIV_id=".intval($tbl02_splitVal);
	    $infoval2_cmd=mysqli_query($link_db,$str_infoval2);
	    $infoval2_data=mysqli_fetch_row($infoval2_cmd);
		if($tbl02_count>1){
	    $infoval2_data_all=$infoval2_data_all.$infoval2_data[1].",";
		}else{
		$infoval2_data_all=$infoval2_data[1];
		}
	  }
	  if($SockT1_val01_name!=""){
	    $sokt1="<td style='font-size:10px;'>".$infoval2_data_all."</td>";
	  }else{
	    $sokt1="";
	  }

	}else{
	$sokt1="";
	}
	if($tbl1_data[3]!=''){
	  $tbl03_split=explode(',',$tbl1_data[3],-1);
	  $tbl03_count=count(explode(',',$tbl1_data[3],-1));
      foreach($tbl03_split as $tbl03_splitVal){
	    $str_infoval3="SELECT PIV_id, PIV_Value FROM product_infovalue_las where PIV_id=".intval($tbl03_splitVal);
	    $infoval3_cmd=mysqli_query($link_db,$str_infoval3);
	    $infoval3_data=mysqli_fetch_row($infoval3_cmd);
		if($tbl03_count>1){
	    $infoval3_data_all=$infoval3_data_all.$infoval3_data[1].",";
		}else{
		$infoval3_data_all=$infoval3_data[1];
		}
	  }
	  if($SockN1_val01_name!=""){
	    $sokn1="<td style='font-size:10px;'>".$infoval3_data_all."</td>";
	  }else{
		$sokn1="";
	  }

	}else{
	$sokn1="";
	}
	if($tbl1_data[4]!=''){
	  $tbl04_split=explode(',',$tbl1_data[4],-1);
	  $tbl04_count=count(explode(',',$tbl1_data[4],-1));
      foreach($tbl04_split as $tbl04_splitVal){
	    $str_infoval4="SELECT PIV_id, PIV_Value FROM product_infovalue_las where PIV_id=".intval($tbl04_splitVal);
	    $infoval4_cmd=mysqli_query($link_db,$str_infoval4);
	    $infoval4_data=mysqli_fetch_row($infoval4_cmd);
		if($tbl04_count>1){
	    $infoval4_data_all=$infoval4_data_all.$infoval4_data[1].",";
		}else{
		$infoval4_data_all=$infoval4_data[1];
		}
	  }
	  if($Chip1_val01_name!=""){
	    $chip1="<td style='font-size:10px;'>".$infoval4_data_all."</td>";
	  }else{
	    $chip1="";
	  }

	}else{
	$chip1="";
	}
	if($tbl1_data[5]!=''){
	  $tbl05_split=explode(',',$tbl1_data[5],-1);
	  $tbl05_count=count(explode(',',$tbl1_data[5],-1));
      foreach($tbl05_split as $tbl05_splitVal){
	    $str_infoval5="SELECT PIV_id, PIV_Value FROM product_infovalue_las where PIV_id=".intval($tbl05_splitVal);
	    $infoval5_cmd=mysqli_query($link_db,$str_infoval5);
	    $infoval5_data=mysqli_fetch_row($infoval5_cmd);
		if($tbl05_count>1){
	    $infoval5_data_all=$infoval5_data_all.$infoval5_data[1].",";
		}else{
		$infoval5_data_all=$infoval5_data[1];
		}
	  }
	  if($Factor1_val01_name!=""){
	    $ffat1="<td style='font-size:10px;'>".$infoval5_data_all."</td>";
	  }else{
	    $ffat1="";
	  }

	}else{
	$ffat1="";
	}
	if($tbl1_data[6]!=''){
	  $tbl06_split=explode(',',$tbl1_data[6],-1);
	  $tbl06_count=count(explode(',',$tbl1_data[6],-1));
      foreach($tbl06_split as $tbl06_splitVal){
	    $str_infoval6="SELECT PIV_id, PIV_Value FROM product_infovalue_las where PIV_id=".intval($tbl06_splitVal);
	    $infoval6_cmd=mysqli_query($link_db,$str_infoval6);
	    $infoval6_data=mysqli_fetch_row($infoval6_cmd);
		if($tbl06_count>1){
	    $infoval6_data_all=$infoval6_data_all.$infoval6_data[1].",";
		}else{
		$infoval6_data_all=$infoval6_data[1];
		}
	  }
	  if($Rackm1_val01_name!=""){
	    $rkmn1="<td style='font-size:10px;'>".$infoval6_data_all."</td>";
	  }else{
		$rkmn1="";
	  }

	}else{
	$rkmn1="";
	}
	$infoval7_data_all="";
	if($tbl1_data[7]!=''){
	  $tbl07_split=explode(',',$tbl1_data[7],-1);
	  $tbl07_count=count(explode(',',$tbl1_data[7],-1));
      foreach($tbl07_split as $tbl07_splitVal){
	    $str_infoval7="SELECT PIV_id, PIV_Value FROM product_infovalue_las where PIV_id=".intval($tbl07_splitVal);
	    $infoval7_cmd=mysqli_query($link_db,$str_infoval7);
	    $infoval7_data=mysqli_fetch_row($infoval7_cmd);
		if($tbl07_count>1){
	    $infoval7_data_all=$infoval7_data_all.$infoval7_data[1].",";
		}else{
		$infoval7_data_all=$infoval7_data[1];
		}
	  }

	  if($AdapterT1_val01_name!=""){
		$adpt1="<td style='font-size:10px;'>".$infoval7_data_all."</td>";
	  }else{
		$adpt1="";
	  }

	}else{
	$adpt1="";
	}
	$infoval8_data_all="";
	if($tbl1_data[8]!=''){
	  $tbl08_split=explode(',',$tbl1_data[8],-1);
	  $tbl08_count=count(explode(',',$tbl1_data[8],-1));
      foreach($tbl08_split as $tbl08_splitVal){
	    $str_infoval8="SELECT PIV_id, PIV_Value FROM product_infovalue_las where PIV_id=".intval($tbl08_splitVal);
	    $infoval8_cmd=mysqli_query($link_db,$str_infoval8);
	    $infoval8_data=mysqli_fetch_row($infoval8_cmd);
		if($tbl08_count>1){
	    $infoval8_data_all=$infoval8_data_all.$infoval8_data[1].",";
		}else{
		$infoval8_data_all=$infoval8_data[1];
		}
	  }
	  $acst1="<td style='font-size:10px;'>".$infoval8_data_all."</td>";

	}else{
	$acst1="";
	}
	$infoval9_data_all="";
	if($tbl1_data[9]!=''){
	  $tbl09_split=explode(',',$tbl1_data[9],-1);
	  $tbl09_count=count(explode(',',$tbl1_data[9],-1));
      foreach($tbl09_split as $tbl09_splitVal){
	    $str_infoval9="SELECT PIV_id, PIV_Value FROM product_infovalue_las where PIV_id=".intval($tbl09_splitVal);
	    $infoval9_cmd=mysqli_query($link_db,$str_infoval9);
	    $infoval9_data=mysqli_fetch_row($infoval9_cmd);
		if($tbl09_count>1){
	    $infoval9_data_all=$infoval9_data_all.$infoval9_data[1].",";
		}else{
		$infoval9_data_all=$infoval9_data[1];
		}
	  }
	  if($Cpu1_val01_name!=""){
		$cpus1="<td style='font-size:10px;'>".$infoval9_data_all."</td>";
	  }else{
		$cpus1="";
	  }

	}else{
	$cpus1="";
	}
	$infoval10_data_all="";
	if($tbl1_data[10]!=''){
	  $tbl10_split=explode(',',$tbl1_data[10],-1);
	  $tbl10_count=count(explode(',',$tbl1_data[10],-1));
      foreach($tbl10_split as $tbl10_splitVal){
	    $str_infoval10="SELECT PIV_id, PIV_Value FROM product_infovalue_las where PIV_id=".intval($tbl10_splitVal);
	    $infoval10_cmd=mysqli_query($link_db,$str_infoval10);
	    $infoval10_data=mysqli_fetch_row($infoval10_cmd);
		if($tbl10_count>1){
	    $infoval10_data_all=$infoval10_data_all.$infoval10_data[1].",";
		}else{
		$infoval10_data_all=$infoval10_data[1];
		}
	  }
	  if($ServT1_val01_name!=""){
		$srvt1="<td style='font-size:10px;'>".$infoval10_data_all."</td>";
	  }else{
		$srvt1="";
	  }

	}else{
	$srvt1="";
	}
	$infoval11_data_all="";
	if($tbl1_data[11]!=''){
	  $tbl11_split=explode(',',$tbl1_data[11],-1);
	  $tbl11_count=count(explode(',',$tbl1_data[11],-1));
      foreach($tbl11_split as $tbl11_splitVal){
	    $str_infoval11="SELECT PIV_id, PIV_Value FROM product_infovalue_las where PIV_id=".intval($tbl11_splitVal);
	    $infoval11_cmd=mysqli_query($link_db,$str_infoval11);
	    $infoval11_data=mysqli_fetch_row($infoval11_cmd);
		if($tbl11_count>1){
	    $infoval11_data_all=$infoval11_data_all.$infoval11_data[1].",";
		}else{
		$infoval11_data_all=$infoval11_data[1];
		}
	  }
	  if($Appl1_val01_name!=""){
		$appl1="<td style='font-size:10px;'>".$infoval11_data_all."</td>";
	  }else{
	    $appl1="";
	  }

	}else{
	$appl1="";
	}
	$infoval12_data_all="";
	if($tbl1_data[13]!=''){
	  $tbl12_split=explode(',',$tbl1_data[13],-1);
	  $tbl12_count=count(explode(',',$tbl1_data[13],-1));
      foreach($tbl12_split as $tbl12_splitVal){
	    $str_infoval12="SELECT PIV_id, PIV_Value FROM product_infovalue_las where PIV_id=".intval($tbl12_splitVal);
	    $infoval12_cmd=mysqli_query($link_db,$str_infoval12);
	    $infoval12_data=mysqli_fetch_row($infoval12_cmd);
		if($tbl12_count>1){
	    $infoval12_data_all=$infoval12_data_all.$infoval12_data[1].",";
		}else{
		$infoval12_data_all=$infoval12_data[1];
		}
	  }
	  if($Hdd1_val01_name!=""){
		$Hdd1="<td style='font-size:10px;'>".$infoval12_data_all."</td>";
	  }else{
	    $Hdd1="";
	  }

	}else{
	$Hdd1="";
	}
	$infoval13_data_all="";
	if($tbl1_data[14]!=''){
	  $tbl13_split=explode(',',$tbl1_data[14],-1);
	  $tbl13_count=count(explode(',',$tbl1_data[14],-1));
      foreach($tbl13_split as $tbl13_splitVal){
	    $str_infoval13="SELECT PIV_id, PIV_Value FROM product_infovalue_las where PIV_id=".intval($tbl13_splitVal);
	    $infoval13_cmd=mysqli_query($link_db,$str_infoval13);
	    $infoval13_data=mysqli_fetch_row($infoval13_cmd);
		if($tbl13_count>1){
	    $infoval13_data_all=$infoval13_data_all.$infoval13_data[1].",";
		}else{
		$infoval13_data_all=$infoval13_data[1];
		}
	  }
	  if($PwerSp1_val01_name!=""){
		$pwsp1="<td style='font-size:10px;'>".$infoval13_data_all."</td>";
	  }else{
	    $pwsp1="";
	  }

	}else{
	$pwsp1="";
	}
	$infoval14_data_all="";
	if($tbl1_data[15]!=''){
	  $tbl14_split=explode(',',$tbl1_data[15],-1);
	  $tbl14_count=count(explode(',',$tbl1_data[15],-1));
      foreach($tbl14_split as $tbl14_splitVal){
	    $str_infoval14="SELECT PIV_id, PIV_Value FROM product_infovalue_las where PIV_id=".intval($tbl14_splitVal);
	    $infoval14_cmd=mysqli_query($link_db,$str_infoval14);
	    $infoval14_data=mysqli_fetch_row($infoval14_cmd);
		if($tbl14_count>1){
	    $infoval14_data_all=$infoval14_data_all.$infoval14_data[1].",";
		}else{
		$infoval14_data_all=$infoval14_data[1];
		}
	  }
	  if($ChassT1_val01_name!=""){
		$chast1="<td style='font-size:10px;'>".$infoval14_data_all."</td>";
	  }else{
	    $chast1="";
	  }

	}else{
	$chast1="";
	}

	$infoval15_data_all="";
	if($tbl1_data[16]!=''){
	  $tbl15_split=explode(',',$tbl1_data[16],-1);
	  $tbl15_count=count(explode(',',$tbl1_data[16],-1));
      foreach($tbl15_split as $tbl15_splitVal){
	    $str_infoval15="SELECT PIV_id, PIV_Value FROM product_infovalue_las where PIV_id=".intval($tbl15_splitVal);
	    $infoval15_cmd=mysqli_query($link_db,$str_infoval15);
	    $infoval15_data=mysqli_fetch_row($infoval15_cmd);
		if($tbl15_count>1){
	    $infoval15_data_all=$infoval15_data_all.$infoval15_data[1].",";
		}else{
		$infoval15_data_all=$infoval15_data[1];
		}
	  }
	  //$jbdt1="<td>".$tbl1_data[15]."</td>";

	  if($JBDT1_val01_name!=""){
		$jbdt1="<td style='font-size:10px;'>".$infoval15_data_all."</td>";
	  }else{
	    $jbdt1="";
	  }

	}else{
	$jbdt1="";
	}

  $infoval16_data_all="";
  if($tbl1_data[24]!=''){
    $tbl16_split=explode(',',$tbl1_data[24],-1);
    $tbl16_count=count(explode(',',$tbl1_data[24],-1));
      foreach($tbl16_split as $tbl16_splitVal){
      $str_infoval16="SELECT PIV_id, PIV_Value FROM product_infovalue_las where PIV_id=".intval($tbl16_splitVal);
      $infoval16_cmd=mysqli_query($link_db,$str_infoval16);
      $infoval16_data=mysqli_fetch_row($infoval16_cmd);
    if($tbl16_count>1){
      $infoval16_data_all=$infoval16_data_all.$infoval16_data[1].",";
    }else{
    $infoval16_data_all=$infoval16_data[1];
    }
    }

    if($Type_val01_name!=""){
    $type1="<td style='font-size:10px;'>".$infoval16_data_all."</td>";
    }else{
      $type1="";
    }

  }else{
  $type1="";
  }

	$tr01.="<tr>".$sku1.$proc1.$sokt1.$sokn1.$chip1.$ffat1.$rkmn1.$adpt1.$acst1.$cpus1.$srvt1.$appl1.$Hdd1.$pwsp1.$chast1.$jbdt1.$type1."</tr>";

}


$Tabl='
<table class="table table-hover">
<tr>
'.$td00.'
</tr>
'.$tr01.'
</table>';


$memo='
<div class="content_bg">
<div class="container content_center" >
<div class="row content_row_center" >
<!--Breadcrumbs-->
<div class="row" style="padding:0px 50px">
TYAN > '.$type_n1_data[1].' > '.$CA01.'
<span itemscope itemtype="https://schema.org/breadcrumb"><a itemprop="url" href="#"><span itemprop="title"> </span></a></span>
<hr>
</div>
<!--end Breadcrumbs-->
<!--Product name-->
<div class="row" >
<h1 class="product_name" > '.$CA01.'  </h1>
</div>
<!--end Product name-->
<div class="row">
  <div class="col-md-3 col_padding20 rightborder" style="display:none" >
 <!--product search box-->
 <div class="jumbotron_search" >
    <div class="input-group">
	<form target="_self" id="form1" name="form1" method="post" action="/search_result.php?PLang='.$PLang_si.'" >
      <input name="sear_txt" type="text" class="form-control" value="" maxlength="26">
	  <input type="hidden" name="search_method" value="normal" />
      <span class="input-group-btn">
        <button class="btn btn-primary" type="submit">Search</button>
      </span>
	</form>
	<script language="javascript">
	function Final_Check(){
	 if(document.form1.sear_txt.value == "" || document.form1.sear_txt.value.length < 3){
	 alert("Requires input a Searched words ! \nInput data is less than 3 bit");
	 document.form1.sear_txt.focus();
	 return false;
	 }
	 return true;
	}
	</script>
    </div>
	<div class="search_note">(Enter a SKU / Model name)</div>
 </div>
 <!--end product search box-->

   <!--product filter boxes-->
   <div class="jumbotron_search" >
   <form target="_self" id="form2" name="form2" method="post" action="/sorting_result.php?PLang='.$PLang_si.'">
   <button class="btn btn-primary btn-xs" type="submit">Find Product</button>';

   $memo.=$memo_PType;
   $memo.='<input type="hidden" name="search_method" value="type" />
   <button class="btn btn-primary btn-xs" type="submit">Find Product</button>
   </form>
   </div>
   <!--end product filter boxes-->
  </div>

  <div class="col_padding20" >
    <h2>'.$CA01.' </h2>
    <!--Category Introduction show on this box. if no introduction, then hide this box-->
    <!--<div class="jumbotron jumbotron_transparent" >
      '.$Intro.'
	</div>-->
    <!--end Category Introduction-->
<div class="clearfix">&nbsp;</div>
  <div class="jumbotron jumbotron_transparent" >
  <div class="table-responsive">
  '.$Tabl.'
  </div>
  </div>
  <div class="clearfix">&nbsp;</div>
  </div>
</div>
</div>
</div>
</div>
';

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

function getGUID(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = chr(123)// "{"
            .substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12)
            .chr(125);// "}"
        return $uuid;
    }
}

$guid = getGUID();
$guid = preg_replace("/{/i", '', $guid);
$guid = preg_replace("/}/i", '', $guid);

$inst_chk="<?php if(strpos(trim(getenv('REQUEST_URI')),'?')!='' || strpos(trim(getenv('REQUEST_URI')),'?')===0 || strpos(trim(getenv('REQUEST_URI')),'script')!='' || strpos(trim(getenv('REQUEST_URI')),'.php')!='' || strpos(trim(getenv('REQUEST_URI')),'.php')===0){ header('Location: /404.htm');exit;} ?>";

$htmlcode = $inst_chk.'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<head>
<META http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="/images/ico/favicon.ico">
<title>TYAN Computer</title>
<!-- Bootstrap -->
<link rel="stylesheet" href="http://cdn.bootcss.com/twitter-bootstrap/3.3.6/css/bootstrap.min.css">
<!--<script src="http://cdn.bootcss.com/twitter-bootstrap/3.0.3/js/bootstrap.min.js" type="text/javascript"></script>-->
<link href="/css/bootstrap.css" rel="stylesheet">
<link href="/css/style.css" rel="stylesheet">
<link href="/css/font-awesome.css" rel="stylesheet">
<link href="/css/fhmm.css" rel="stylesheet">
<!--[if lt IE 9]>
<![endif]-->
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<script src="/js/gtm/modernizr.custom.63321.js"></script>
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script language="JavaScript">
  function check_result(){
  var tInput = document.form_search.txtInput.value;
    if(tInput=="" || tInput.length<3){
		alert("Requires input a Searched words ! \nInput data is less than 3 bit");
		document.form_search.txtInput.focus();
		return false;
	}
	return true;
  }
  function checkData(m,tm,pf_Val){

  var tp_id="0"+m+""+tm;
  var n=$("#PINFO_SecNum"+m).val();

  var s=0;
  for(s=0;s<document.form2.elements.length;s++){

   if((document.form2.elements[s].type == "checkbox") && (document.form2.elements[s].value==tp_id))
   {
		 var TPname="#PINFO_TPVal"+tp_id+"[]";
         var Fname = ".PINFO_Val_S"+tp_id;
         var lenA = $(Fname+":checked").length;
         if(lenA>0){
         document.form2.elements[s].checked=true;
		    if(lenA>1){
			$(Fname).prop("checked", false);
			$(TPname).prop("checked", false);
			}else{
			document.form2.elements[s].disabled=false;
			}
         }else{
         document.form2.elements[s].checked=false;
         }
   }

  }

  var checkedCount=0;
  var checkbox = document.getElementsByName("PINFO_Val"+m+"[]");

      for(var i=0;i<checkbox.length;i++){
         if(checkbox[i].checked){
         checkedCount++;
		 }

      }
       if(checkedCount>n){
           return false;
      }
  }
  function checkDataS(m,tm,tm2,pf_Val){
  var tp_id="0"+m+""+tm;
  var tp_ids="0"+m+""+tm+""+tm2;

  var n=$("#PINFO_SecNum"+m).val();
  var s=0;
  for(s=0;s<document.form2.elements.length;s++){

   //if((document.form2.elements[s].type == "checkbox") && (document.form2.elements[s].value==tp_id || document.form2.elements[s].value==tp_ids)){
   if((document.form2.elements[s].type == "checkbox") && (document.form2.elements[s].value==tp_id)){
		 var TPname="#PINFO_TPVal0"+tp_id+"[]";
         var Fname = ".PINFO_Val_S"+tp_id;//PINFO_Val_S[] Class
		 var Fname1 = ".PINFO_Val_S"+tp_ids;//PINFO_Val_S[] Class

         var lenA = $(Fname+":checked").length;
         if(lenA>0){
         document.form2.elements[s].checked=true;
		    if(lenA>1){
			$(":checkbox").each(function() {
            this.checked = false;
            });

			document.getElementById("PINFO_Val"+m+"[]").checked = false;

			//checkDataS01_click(Fname1,s);

			}else{
			document.form2.elements[s].disabled=false;
			$(Fname1).prop("checked", true);
			}
         }else{
         document.form2.elements[s].checked=false;
		 $(Fname).prop("checked", false);
		 $(Fname1).prop("checked", false);
         }
   }
  }

  var checkedCount=0;
  var checkbox = document.getElementsByName("PINFO_Val"+m+"[]");
      for(var i=0;i<checkbox.length;i++){
         if(checkbox[i].checked){
         checkedCount++;
		 }
      }
      //alert(checkedCount);
       if(checkedCount>n){
           return false;
      }
  }
  </script>
<script type="text/javascript">
function checkComments(){
if(( event.keyCode > 32 && event.keyCode < 46) || // 46=.
   ( event.keyCode > 57 && event.keyCode < 64) || // 64=@
   ( event.keyCode > 90 && event.keyCode < 97) ||
   ( event.keyCode > 123 && event.keyCode < 127)) { // 124=~,125=},126=|
     event.returnValue = false;
   }
}
</script>
</head>
<body>
'.$Top_Block.'
'.$memo.'
'.$Foot_Block.'
<div id="go-top" style="display: block;"><a title="Back to Top" href="#">Go To Top</a></div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/docs.min.js"></script>
	<script>
	$("#myTab a").click(function (e) {
	e.preventDefault()
	$(this).tab("show")
	})
	</script>
	<script>
	$(".collapse").collapse("show")
	</script>
</body>
</html>
';

$CAS01=str_replace(" ", '_', $CA01);
$CAS01=str_replace("/", '_', $CAS01);
$CAS01=str_replace("/", '_', $CAS01);
$CAS01=str_replace("(", '_', $CAS01);
$CAS01=str_replace(")", '', $CAS01);
$CAS01=str_replace("）", '', $CAS01);
$CAS01=str_replace("___", '_', $CAS01);
$CAS01=str_replace("__", '_', $CAS01);
$str_lang01=str_replace(",","",$str_lang);
if($proc1!="" || $sokt1!="" || $sokn1!="" || $chip1!="" || $ffat1!="" || $rkmn1!="" || $adpt1!="" || $acst1!="" || $cpus1!="" || $srvt1!="" || $appl1!="" || $Hdd1!="" || $pwsp1!="" || $chast1!="" || $jbdt1!="" || $type1!=""){
ob_start();
file_put_contents($str_lang01."/".$CAS01.".htm", $htmlcode);
ob_end_clean();



if($str_lang01!='EN'){
$str_lang01s=$str_lang01."/";
}else{
$str_lang01s=$str_lang01."/";
}

copy($str_lang01s.$CAS01.".htm","../../".$str_lang01s.$CAS01.".php");
unlink($str_lang01s."/".$CAS01.".htm");
}*/
echo "<script language='JavaScript'>alert('Update a Product !');self.location='default.php".$spage."'</script>";
exit();
}
}

$cid=intval($_REQUEST['cid']);
$slang=trim($_REQUEST['lang']);
$s_search=trim($_REQUEST['s_search']);

if($cid!='' && $slang!=''){
  $BigProd_url="";
  $str_prod="SELECT Product_SContents_Auto_ID, CategoryModuID, ProductTypeID, SKU, MODELCODE, STATUS, slang, Product_Info, ProductFile, ProductBFile, ProductSFile, Product_Icons, Product_dsc, Relate_enable, Relate_Prod, Compat_enable, Compat_Prod, crea_d, crea_u, upd_d, upd_u, IsnewUp, FormFactor_val, MBprocessor_val, LAN_val, COM_val, USB_val, SATA_val, M2_Slot_val, Mini_PCIe_val, PCIeSlot_val, MBpower_val, Fanless_val, Modularized_IO_val, WidgetTemperature_val, PanelSize_val, EmbeddedPower_val,legend_val, Panel_PC_Power_val, EmbeddedProcessor_val, Panel_PC_Processor_val, EmbeddedType_val, PanelPCType_val, Product_Icons_b, LandingTitle, Coming_Soon, ProductFileCom ";
  $str_prod.="FROM contents_product_skus where Product_SContents_Auto_ID=".$cid." and slang='".$slang."'";
  $prod_result=mysqli_query($link_db,$str_prod);
  $prod_data=mysqli_fetch_row($prod_result);

  $str_MBprod="SELECT BIGIMG FROM p_s_main_systemboards WHERE MODELCODE='".$prod_data[4]."' limit 1";
  mysqli_query($link_db, 'SET NAMES utf8');
  $MBprod_result=mysqli_query($link_db,$str_MBprod);
  $MBprod_data=mysqli_fetch_row($MBprod_result);
  if(empty($MBprod_data) || $MBprod_data==''):
  else:
  $BigProd_url=$MBprod_data[0];
  endif;

  $str_BBprod="SELECT BIGIMG FROM p_b_main_serverbarebones WHERE MODELCODE='".$prod_data[4]."' limit 1";
  mysqli_query($link_db, 'SET NAMES utf8');
  $BBprod_result=mysqli_query($link_db,$str_BBprod);
  $BBprod_data=mysqli_fetch_row($BBprod_result);
  if(empty($BBprod_data) || $BBprod_data==''):
  else:
  $BigProd_url=$BBprod_data[0];
  endif;

  $str_Panprod="SELECT BIGIMG FROM p_b_main_panelpc WHERE MODELCODE='".$prod_data[4]."' limit 1";
  mysqli_query($link_db, 'SET NAMES utf8');
  $Panprod_result=mysqli_query($link_db,$str_Panprod);
  $Panprod_data=mysqli_fetch_row($Panprod_result);
  if(empty($Panprod_data) || $Panprod_data==''):
  else:
  $BigProd_url=$Panprod_data[0];
  endif;

  $str_EMprod="SELECT BIGIMG FROM p_b_main_embedded WHERE MODELCODE='".$prod_data[4]."' limit 1";
  mysqli_query($link_db, 'SET NAMES utf8');
  $EMprod_result=mysqli_query($link_db,$str_EMprod);
  $EMprod_data=mysqli_fetch_row($EMprod_result);
  if(empty($EMprod_data) || $EMprod_data==''):
  else:
  $BigProd_url=$EMprod_data[0];
  endif;

  $str_INDprod="SELECT BIGIMG FROM p_b_main_industriamb WHERE MODELCODE='".$prod_data[4]."' limit 1";
  mysqli_query($link_db, 'SET NAMES utf8');
  $INDprod_result=mysqli_query($link_db,$str_INDprod);
  $INDprod_data=mysqli_fetch_row($INDprod_result);
  if(empty($INDprod_data) || $INDprod_data==''):
  else:
  $BigProd_url=$INDprod_data[0];
  endif;


}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Website Contents Management - Products Management: Products- Edit Product</title>
<link rel="stylesheet" type="text/css" href="../backend.css">

	<script type="text/javascript" src="../lib/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="../lib/jquery.mousewheel-3.0.6.pack.js"></script>
	<script type="text/javascript" src="../source/jquery.fancybox.js?v=2.0.6"></script>
	<link rel="stylesheet" type="text/css" href="../source/jquery.fancybox.css?v=2.0.6" media="screen" />
	<link rel="stylesheet" type="text/css" href="../source/helpers/jquery.fancybox-buttons.css?v=1.0.2" />
	<script type="text/javascript" src="../source/helpers/jquery.fancybox-buttons.js?v=1.0.2"></script>
    <script language='JavaScript'>
	function icon_show(form){
	form.icon_get.value = form.iconvals.value;
	show_icon();
	}
	function prod_Check(){
	  if(document.form2.SEL_PTYPE.value == "" || document.form2.SEL_PTYPE.value == "add_product.php?SType_id=") {
      $("#PTYPE_error").html('<span class="w12red">(Required select a product type. )</span>');
      document.form2.SEL_PTYPE.focus();
      return false;
      }
	  if(document.form2.SKU_value.value == ""){
	  alert("Required Input a SKU.");
	  document.form2.SKU_value.focus();
	  return false;
	  }
	  if(document.form2.Model_value.value == ""){
	  alert("Required Input a Model.");
	  document.form2.Model_value.focus();
	  return false;
	  }
	  return true;
	}

function getElementsByClassName(node,classname) {
  if (node.getElementsByClassName) { // use native implementation if available
    return node.getElementsByClassName(classname);
  } else {
    return (function getElementsByClass(searchClass,node) {
        if ( node == null )
          node = document;
        var classElements = [],
            els = node.getElementsByTagName("*"),
            elsLen = els.length,
            pattern = new RegExp("(^|\\s)"+searchClass+"(\\s|$)"), i, j;

        for (i = 0, j = 0; i < elsLen; i++) {
          if ( pattern.test(els[i].className) ) {
              classElements[j] = els[i];
              j++;
          }
        }
        return classElements;
    })(classname, node);
  }
}

    function chk_FFactor(id){
	  var e_all='';
	  var className = 'pinfoc1';
	  var elements = getElementsByClassName(document, className),
	  n = elements.length;
	  for (var i = 0; i < n; i++) {
	        var e = elements[i];
			if(e.checked == true){
			e_all=e_all+e.value+',';
			}else{
			}

	  }
	  document.form2.FFactor_val.value=e_all;
	}

	function chk_MBprocessor(id){
	  var e_all='';
	  var className = 'pinfoc2';
	  var elements = getElementsByClassName(document, className),
	  n = elements.length;
	  for (var i = 0; i < n; i++) {
	        var e = elements[i];
			if(e.checked == true){
			e_all=e_all+e.value+',';
			}else{
			}

	  }
	  document.form2.MBprocessor_val.value=e_all;
	}

	function chk_LAN(id){
	  var e_all='';
	  var className = 'pinfoc3';
	  var elements = getElementsByClassName(document, className),
	  n = elements.length;
	  for (var i = 0; i < n; i++) {
	        var e = elements[i];
			if(e.checked == true){
			e_all=e_all+e.value+',';
			}else{
			}

	  }
	  document.form2.LAN_val.value=e_all;
	}

	function chk_COM(id){
	  var e_all='';
	  var className = 'pinfoc4';
	  var elements = getElementsByClassName(document, className),
	  n = elements.length;
	  for (var i = 0; i < n; i++) {
	        var e = elements[i];
			if(e.checked == true){
			e_all=e_all+e.value+',';
			}else{
			}

	  }
	  document.form2.COM_val.value=e_all;
	}

	function chk_USB(id){
	  var e_all='';
	  var className = 'pinfoc5';
	  var elements = getElementsByClassName(document, className),
	  n = elements.length;
	  for (var i = 0; i < n; i++) {
	        var e = elements[i];
			if(e.checked == true){
			e_all=e_all+e.value+',';
			}else{
			}

	  }
	  document.form2.USB_val.value=e_all;
	}

	function chk_SATA(id){
	  var e_all='';
	  var className = 'pinfoc6';
	  var elements = getElementsByClassName(document, className),
	  n = elements.length;
	  for (var i = 0; i < n; i++) {
	        var e = elements[i];
			if(e.checked == true){
			e_all=e_all+e.value+',';
			}else{
			}

	  }
	  document.form2.SATA_val.value=e_all;
	}

	function chk_M2Slot(id){
	  var e_all='';
	  var className = 'pinfoc7';
	  var elements = getElementsByClassName(document, className),
	  n = elements.length;
	  for (var i = 0; i < n; i++) {
	        var e = elements[i];
			if(e.checked == true){
			e_all=e_all+e.value+',';
			}else{
			}

	  }
	  document.form2.M2Slot_val.value=e_all;
	}

	function chk_MiniPCIe(id){
	  var e_all='';
	  var className = 'pinfoc8';
	  var elements = getElementsByClassName(document, className),
	  n = elements.length;
	  for (var i = 0; i < n; i++) {
	        var e = elements[i];
			if(e.checked == true){
			e_all=e_all+e.value+',';
			}else{
			}

	  }
	  document.form2.MiniPCIe_val.value=e_all;
	}

	function chk_PCIeSlot(id){
	  var e_all='';
	  var className = 'pinfoc9';
	  var elements = getElementsByClassName(document, className),
	  n = elements.length;
	  for (var i = 0; i < n; i++) {
	        var e = elements[i];
			if(e.checked == true){
			e_all=e_all+e.value+',';
			}else{
			}

	  }
	  document.form2.PCIeSlot_val.value=e_all;
	}

	function chk_MBpower(id){
	  var e_all='';
	  var className = 'pinfoc10';
	  var elements = getElementsByClassName(document, className),
	  n = elements.length;
	  for (var i = 0; i < n; i++) {
	        var e = elements[i];
			if(e.checked == true){
			e_all=e_all+e.value+',';
			}else{
			}

	  }
	  document.form2.MBpower_val.value=e_all;
	}

	function chk_Fanless(id){
	  var e_all='';
	  var className = 'pinfoc11';
	  var elements = getElementsByClassName(document, className),
	  n = elements.length;
	  for (var i = 0; i < n; i++) {
	        var e = elements[i];
			if(e.checked == true){
			e_all=e_all+e.value+',';
			}else{
			}

	  }
	  document.form2.Fanless_val.value=e_all;
	}

	function chk_ModularizedIO(id){
	  var e_all='';
	  var className = 'pinfoc12';
	  var elements = getElementsByClassName(document, className),
	  n = elements.length;
	  for (var i = 0; i < n; i++) {
	        var e = elements[i];
			if(e.checked == true){
			e_all=e_all+e.value+',';
			}else{
			}

	  }
	  document.form2.ModularizedIO_val.value=e_all;
	}

	function chk_WidgetTemperature(id){
	  var e_all='';
	  var className = 'pinfoc13';
	  var elements = getElementsByClassName(document, className),
	  n = elements.length;
	  for (var i = 0; i < n; i++) {
	        var e = elements[i];
			if(e.checked == true){
			e_all=e_all+e.value+',';
			}else{
			}

	  }
	  document.form2.WidgetTemperature_val.value=e_all;
	}

	function chk_PanelSize(id){
	  var e_all='';
	  //var className = 'pinfoc'+id;
	  var className = 'pinfoc14';
	  var elements = getElementsByClassName(document, className),
	  n = elements.length;
	  for (var i = 0; i < n; i++) {
	        var e = elements[i];
			if(e.checked == true){
			e_all=e_all+e.value+',';
			}else{
			}

	  }
	  document.form2.PanelSize_val.value=e_all;
	}

	function chk_EmbeddedPower(id){
	  var e_all='';
	  //var className = 'pinfoc'+id;
	  var className = 'pinfoc15';
	  var elements = getElementsByClassName(document, className),
	  n = elements.length;
	  for (var i = 0; i < n; i++) {
	        var e = elements[i];
			if(e.checked == true){
			e_all=e_all+e.value+',';
			}else{
			}

	  }
	  document.form2.EmbeddedPower_val.value=e_all;
	}

  function chk_PanelPCPower(id){
    var e_all='';
    //var className = 'pinfoc'+id;
    var className = 'pinfoc16';
    var elements = getElementsByClassName(document, className),
    n = elements.length;
    for (var i = 0; i < n; i++) {
          var e = elements[i];
      if(e.checked == true){
      e_all=e_all+e.value+',';
      }else{
      }

    }
    document.form2.PanelPCPower_val.value=e_all;
  }

  function chk_EmbeddedProcessor(id){
    var e_all='';
    //var className = 'pinfoc'+id;
    var className = 'pinfoc17';
    var elements = getElementsByClassName(document, className),
    n = elements.length;
    for (var i = 0; i < n; i++) {
          var e = elements[i];
      if(e.checked == true){
      e_all=e_all+e.value+',';
      }else{
      }

    }
    document.form2.EmbeddedProcessor_val.value=e_all;
  }

  function chk_PanelPCProcessor(id){
    var e_all='';
    //var className = 'pinfoc'+id;
    var className = 'pinfoc18';
    var elements = getElementsByClassName(document, className),
    n = elements.length;
    for (var i = 0; i < n; i++) {
          var e = elements[i];
      if(e.checked == true){
      e_all=e_all+e.value+',';
      }else{
      }

    }
    document.form2.PanelPCProcessor_val.value=e_all;
  }

  function chk_EmbeddedType(id){
    var e_all='';
    //var className = 'pinfoc'+id;
    var className = 'pinfoc19';
    var elements = getElementsByClassName(document, className),
    n = elements.length;
    for (var i = 0; i < n; i++) {
          var e = elements[i];
      if(e.checked == true){
      e_all=e_all+e.value+',';
      }else{
      }

    }
    document.form2.EmbeddedType_val.value=e_all;
  }

  function chk_PanelPCType(id){
    var e_all='';
    //var className = 'pinfoc'+id;
    var className = 'pinfoc20';
    var elements = getElementsByClassName(document, className),
    n = elements.length;
    for (var i = 0; i < n; i++) {
          var e = elements[i];
      if(e.checked == true){
      e_all=e_all+e.value+',';
      }else{
      }

    }
    document.form2.PanelPCType_val.value=e_all;
  }

  </script>

	<script type="text/javascript">
		$(document).ready(function() {

		var cids=<?=$cid;?>,slangs="<?=$slang;?>",s_searchs="<?=$s_search;?>"

		var t=0;
		var myVar=setInterval(function(){myTimer()},1000);
		function myTimer()
		{
		t+=1;
		document.getElementById("count_num").innerHTML=t;
		if(t>1200){
		self.location="edit_product.php?cid=" + cids + "&lang=" + slangs + "&s_search=" + s_searchs;
		}
		}

			/*
			 *  Simple image gallery. Uses default settings
			 */

			$('.fancybox').fancybox({'width':800,
                         'height':700,
                         'autoSize' : false});

			/*
			 *  Different effects
			 */

			// Change title type, overlay opening speed and opacity
			$(".fancybox-effects-a").fancybox({
				helpers: {
					title : {
						type : 'outside'
					},
					overlay : {
						speedIn : 500,
						opacity : 0.95
					}
				}
			});

			// Disable opening and closing animations, change title type
			$(".fancybox-effects-b").fancybox({
				openEffect  : 'none',
				closeEffect	: 'none',

				helpers : {
					title : {
						type : 'over'
					}
				}
			});

			// Set custom style, close if clicked, change title type and overlay color
			$(".fancybox-effects-c").fancybox({
				wrapCSS    : 'fancybox-custom',
				closeClick : true,

				helpers : {
					title : {
						type : 'inside'
					},
					overlay : {
						css : {
							'background-color' : '#eee'
						}
					}
				}
			});

			// Remove padding, set opening and closing animations, close if clicked and disable overlay
			$(".fancybox-effects-d").fancybox({
				padding: 0,

				openEffect : 'elastic',
				openSpeed  : 150,

				closeEffect : 'elastic',
				closeSpeed  : 150,

				closeClick : true,

				helpers : {
					overlay : null
				}
			});

			/*
			 *  Button helper. Disable animations, hide close button, change title type and content
			 */

			$('.fancybox-buttons').fancybox({
				openEffect  : 'none',
				closeEffect : 'none',

				prevEffect : 'none',
				nextEffect : 'none',

				closeBtn  : false,

				helpers : {
					title : {
						type : 'inside'
					},
					buttons	: {}
				},

				afterLoad : function() {
					this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
				}
			});


			/*
			 *  Thumbnail helper. Disable animations, hide close button, arrows and slide to next gallery item if clicked
			 */

			$('.fancybox-thumbs').fancybox({
				prevEffect : 'none',
				nextEffect : 'none',

				closeBtn  : false,
				arrows    : false,
				nextClick : true,

				helpers : {
					thumbs : {
						width  : 50,
						height : 50
					}
				}
			});

			/*
			 *  Media helper. Group items, disable animations, hide arrows, enable media and button helpers.
			*/
			$('.fancybox-media')
				.attr('rel', 'media-gallery')
				.fancybox({
					openEffect : 'none',
					closeEffect : 'none',
					prevEffect : 'none',
					nextEffect : 'none',

					arrows : false,
					helpers : {
						media : {},
						buttons : {}
					}
				});

			/*
			 *  Open manually
			 */

			$("#fancybox-manual-a").click(function() {
				$.fancybox.open('1_b.jpg');
			});

			$("#fancybox-manual-b").click(function() {
				$.fancybox.open({
					href : 'iframe.html',
					type : 'iframe',
					padding : 5
				});
			});

			$("#fancybox-manual-c").click(function() {
				$.fancybox.open([
					{
						href : '1_b.jpg',
						title : 'My title'
					}, {
						href : '2_b.jpg',
						title : '2nd title'
					}, {
						href : '3_b.jpg'
					}
				], {
					helpers : {
						thumbs : {
							width: 75,
							height: 50
						}
					}
				});
			});


		});
	</script>
</head>

<body>
<a name="top"></a>
<div >
<div class="left"><h1>&nbsp;&nbsp;Website Backends - Website Contents Management - Products- Edit Product</h1></div>
<div id="logout">Hi <?=str_replace("@mic.com.tw", "", $_SESSION['user']);?> <a href="./logo.php">Log out &gt;&gt;</a> Refresh seconds <span id="count_num" style="background-color: yellow;">0</span> <br /><font color="red">* Setup:1200 sec</font></div>
</div>
<div class="clear"></div>
<div id="menu">
<ul>
<li ><a href="default.php">Products</a></li>
<li> <a href="modules.php">Contents</a>
      <ul>
		<li><a href="modules.php">Modules</a></li>
      </ul>
</li>
<li ><a href="newsletter.php">Newsletters</a>
<ul><li><a href="subscribe.php">Subscription</a></li></ul>
</li>
</ul>
</div>
<div class="clear"></div>
<div id="Search" >
<h2><a href="default.php" >Products</a>&nbsp;&gt;&nbsp;Edit <?=$prod_data[4];?>: <a href="#" target="spec"><?=$prod_data[3];?></a>&nbsp;&nbsp;(<?=substr($slang,0,strlen($slang)-1);?>)</h2>
</div>
<div id="content">
<form name="form2" id="form2" method="post" enctype="multipart/form-data" action="?methods=upd_pro&s_search=<?=$s_search;?>" onsubmit="return prod_Check();">
<br />
<div class="box">
<table>
<tr>
<th style="width:250px">Product Type:</th>
<td>
<select id="SEL_PTYPE" name="SEL_PTYPE">
<?php
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
//$str_type1="SELECT ProductTypeID, ProductTypeName FROM producttypes_las where ProductTypeID=".$prod_data[2]." and slang='".substr($slang,0,strlen($slang)-1)."'";
$str_type1="SELECT ProductTypeID, ProductTypeName FROM producttypes_las where ProductTypeID=".$prod_data[2]." and slang='EN'";
$type_result1=mysqli_query($link_db,$str_type1);
list($ProductTypeID,$ProductTypeName)=mysqli_fetch_row($type_result1);
?>
<option value="<?=$ProductTypeID;?>" <?php if($prod_data[2]==$ProductTypeID){ echo "selected"; }?>><?=$ProductTypeName?></option>
<?php
mysqli_close($link_db);
?>
</select>
</td>
</tr>
<tr>
<th>Category: </th>
<td>
<select id="categ_val" name="categ_val">
<option selected value="0">Select</option>
<?php
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
//$str_Categ1="SELECT CategoryModuID, CategoryModuName, ProdTypeID, Prod_Info_Sorting FROM category_module_las where ProdTypeID=".$prod_data[2]." and slang='".substr($slang,0,strlen($slang)-1)."'";
$str_Categ1="SELECT CategoryModuID, CategoryModuName, ProdTypeID, Prod_Info_Sorting FROM category_module_las where ProdTypeID=".$prod_data[2]." and slang='EN'";
$Categ_result1=mysqli_query($link_db,$str_Categ1);
while($Categ_data=mysqli_fetch_row($Categ_result1)){
	if($Categ_data[0]==$prod_data[1]){
	$Prod_Info_Sorting01=$Categ_data[3];
	}
?>
<option value="<?=$Categ_data[0]?>" <?php if($Categ_data[0]==$prod_data[1]){ echo "selected"; } ?>><?=$Categ_data[1]?></option>
<?php
}
mysqli_close($link_db);
?>
</select> <input name="cate_pinfo01" type="hidden" value="<?=$Prod_Info_Sorting01;?>">
</td>
</tr>
<tr><th>SKU: </th><td><?=$prod_data[3]?><input type="hidden" name="SKU_value" value="<?=$prod_data[3]?>"></td></tr>
<tr><th>Model: </th><td><?=$prod_data[4]?><input type="hidden" name="Model_value" value="<?=$prod_data[4]?>"></td></tr>
<tr><th>Status: </th>
<td>
<select id="stat01" name="stat01">
<option value="1" <?php if($prod_data[5]=='1'){ echo "selected"; } ?>>Online</option>
<option value="0" <?php if($prod_data[5]=='0'){ echo "selected"; } ?>>Offline</option>
</select>&nbsp;
<INPUT name="new_logo" type="checkbox" value="1" <?php if($prod_data[21]=='1'){ echo "checked"; } ?> /> New &nbsp;
<INPUT name="comingSoon" type="checkbox" value="1" <?php if($prod_data[45]=='1'){ echo "checked"; } ?> /> Coming Soon
</td>
</tr>
<tr>
<th>Languages:</th>
<td>
<?php
if(strpos($prod_data[6],'EN,')!='' || strpos($prod_data[6],'EN,')===0){
?>
<INPUT name="aproLang[]" type="checkbox" value="EN" checked <?php //if(strpos($prod_data[6],'EN,')!='' || strpos($prod_data[6],'EN,')===0){ echo "checked"; } //if(eregi("EN",$prod_data[6])!='') {echo "checked";} ?>>English &nbsp;&nbsp;
<?php
}else if(strpos($prod_data[6],'CN,')!='' || strpos($prod_data[6],'CN,')===0){
?>
<INPUT name="aproLang[]" type="checkbox" value="CN" checked <?php //if(strpos($prod_data[6],'CN,')!='' || strpos($prod_data[6],'CN,')===0){ echo "checked"; } //if(eregi("CN",$prod_data[6])!='') {echo "checked";} ?>>簡中 &nbsp;&nbsp;
<?php
}else if(strpos($prod_data[6],'ZH,')!='' || strpos($prod_data[6],'ZH,')===0){
?>
<INPUT name="aproLang[]" type="checkbox" value="ZH" checked <?php //if(strpos($prod_data[6],'ZH,')!='' || strpos($prod_data[6],'ZH,')===0){ echo "checked"; } //if(eregi("ZH",$prod_data[6])!='') {echo "checked";} ?>>繁中 &nbsp;&nbsp;
<?php
}else if(strpos($prod_data[6],'JP,')!='' || strpos($prod_data[6],'JP,')===0){
?>
<INPUT name="aproLang[]" type="checkbox" value="JP" checked <?php //if(strpos($prod_data[6],'JP,')!='' || strpos($prod_data[6],'JP,')===0){ echo "checked"; } //if(eregi("JP",$prod_data[6])!='') {echo "checked";} ?>>日本語 &nbsp;&nbsp;
<?php
}
?>
</td>
</tr>
</table>
	 <P style="color:#0F0">- Product Type 的 default 值，會以在 "module => (Product) Product Type 裏設定的 "Associated Product Type(s) in PMM system" 對應的 Product Type 為預設。<br />- Category 的 default 值， 跟據上面的 "Product Type"， 會以在 "module =>(Category page) - Product Categories" 裏設定對應的 Categories為預設。 <br />- Status 預設為offline</p>
</div>
 <p class="clear">&nbsp;</p>
<div class="box">
   <h3> Info:</h3>
   <table class="addspec" style="width:800px">
	<tbody >
	<?php
	if($prod_data[2]!=''){

	$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);

	mysqli_query($link_db, 'SET NAMES utf8');
    mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
    mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
    //$select=mysqli_select_db($dataBase, $link_db);

	$str_pinfo="SELECT PI_id, PI_Name, slang, PI_Value, PTYPE_Value, Sorts FROM product_info_las where concat(',',PTYPE_Value) like '%,".$prod_data[2].",%' and slang='".substr($slang,0,strlen($slang)-1)."'";
  $pinfo_result=mysqli_query($link_db, $str_pinfo);
    while(list($PI_id,$PI_Name,$slang,$PI_Value,$PTYPE_Value,$Sorts)=mysqli_fetch_row($pinfo_result))
    {
	?>
	<tr ><th > <?=$PI_Name;?>: <?=$PI_id;?></th>
	<td>
	  <?php
	  $str_pinfoVal="SELECT PIV_id, PI_id, PIV_Value FROM product_infovalue_las where PI_id=".$PI_id;
    $pinfoVal_result=mysqli_query($link_db,$str_pinfoVal);
	  while($pinfoVal_data=mysqli_fetch_array($pinfoVal_result)){
		  if($PI_id==1){
			 $pclass_name="pinfoc1";
			 $info_click="chk_FFactor('".$PI_id."')";
		  }else if($PI_id==2){
			 $pclass_name="pinfoc2";
			 $info_click="chk_MBprocessor('".$PI_id."')";
		  }else if($PI_id==3){
			 $pclass_name="pinfoc3";
			 $info_click="chk_LAN('".$PI_id."')";
		  }else if($PI_id==4){
			 $pclass_name="pinfoc4";
			 $info_click="chk_COM('".$PI_id."')";
		  }else if($PI_id==5){
			 $pclass_name="pinfoc5";
			 $info_click="chk_USB('".$PI_id."')";
		  }else if($PI_id==6){
			 $pclass_name="pinfoc6";
			 $info_click="chk_SATA('".$PI_id."')";
		  }else if($PI_id==7){
			 $pclass_name="pinfoc7";
			 $info_click="chk_M2Slot('".$PI_id."')";
		  }else if($PI_id==8){
			 $pclass_name="pinfoc8";
			 $info_click="chk_MiniPCIe('".$PI_id."')";
		  }else if($PI_id==9){
			 $pclass_name="pinfoc9";
			 $info_click="chk_PCIeSlot('".$PI_id."')";
		  }else if($PI_id==10){
			 $pclass_name="pinfoc10";
			 $info_click="chk_MBpower('".$PI_id."')";
		  }else if($PI_id==11){
			 $pclass_name="pinfoc11";
			 $info_click="chk_Fanless('".$PI_id."')";
      }else if($PI_id==12){
			 $pclass_name="pinfoc12";
			 $info_click="chk_ModularizedIO('".$PI_id."')";
		  }else if($PI_id==13){
			 $pclass_name="pinfoc13";
			 $info_click="chk_WidgetTemperature('".$PI_id."')";
		  }else if($PI_id==14){
			 $pclass_name="pinfoc14";
			 $info_click="chk_PanelSize('".$PI_id."')";
		  }else if($PI_id==15){
			 $pclass_name="pinfoc15";
			 $info_click="chk_EmbeddedPower('".$PI_id."')";
		  }else if($PI_id==16){
       $pclass_name="pinfoc16";
       $info_click="chk_PanelPCPower('".$PI_id."')";
      }else if($PI_id==17){
       $pclass_name="pinfoc17";
       $info_click="chk_EmbeddedProcessor('".$PI_id."')";
      }else if($PI_id==18){
       $pclass_name="pinfoc18";
       $info_click="chk_PanelPCProcessor('".$PI_id."')";
      }else if($PI_id==19){
       $pclass_name="pinfoc19";
       $info_click="chk_EmbeddedType('".$PI_id."')";
      }else if($PI_id==20){
       $pclass_name="pinfoc20";
       $info_click="chk_PanelPCType('".$PI_id."')";
      }

	  ?>
	  <input class="<?=$pclass_name;?>" type="checkbox" name="PINFO_Val[]" value="<?=$pinfoVal_data[0];?>" onclick="<?=$info_click;?>" <?php if(preg_match("/\b".$pinfoVal_data[0].",/i", $prod_data[7])){ echo "checked"; } //if(eregi($pinfoVal_data[0],$prod_data[7])!='') {echo "checked";} ?>> <?=$pinfoVal_data[2];?> &nbsp;&nbsp;&nbsp;&nbsp;
	  <?php
	  }
	  ?>
	</td>
	</tr>
	<?php
	}

	mysqli_close($link_db);
	}
	?>
	<tr>
	<td colspan="2">
	Form Factor <input type="text" name="FFactor_val" value="<?=$prod_data[22];?>" readonly />&nbsp;&nbsp;<br />
	MB Processor <input type="text" name="MBprocessor_val" value="<?=$prod_data[23];?>" readonly />&nbsp;&nbsp;<br />
	LAN <input type="text" name="LAN_val" value="<?=$prod_data[24];?>" readonly />&nbsp;&nbsp;<br />
	COM <input type="text" name="COM_val" value="<?=$prod_data[25];?>" readonly />&nbsp;&nbsp;<br />
	USB <input type="text" name="USB_val" value="<?=$prod_data[26];?>" readonly />&nbsp;&nbsp;<br />
	SATA <input type="text" name="SATA_val" value="<?=$prod_data[27];?>" readonly />&nbsp;&nbsp;<br />
	M.2 Slot <input type="text" name="M2Slot_val" value="<?=$prod_data[28];?>" readonly />&nbsp;&nbsp;<br />
	Mini PCIe <input type="text" name="MiniPCIe_val" value="<?=$prod_data[29];?>" readonly />&nbsp;&nbsp;<br />
	PCIe Slot <input type="text" name="PCIeSlot_val" value="<?=$prod_data[30];?>" readonly />&nbsp;&nbsp;<br />
	MB Power <input type="text" name="MBpower_val" value="<?=$prod_data[31];?>" readonly />&nbsp;&nbsp;<br />
	Fanless <input type="text" name="Fanless_val" value="<?=$prod_data[32];?>" readonly />&nbsp;&nbsp;<br />
	Modularized I/O <input type="text" name="ModularizedIO_val" value="<?=$prod_data[33];?>" readonly />&nbsp;&nbsp;<br />
	Widget Temperature <input type="text" name="WidgetTemperature_val" value="<?=$prod_data[34];?>" readonly />&nbsp;&nbsp;<br />
	Panel Size <input type="text" name="PanelSize_val" value="<?=$prod_data[35];?>" readonly />&nbsp;&nbsp;<br />
	Embedded Power <input type="text" name="EmbeddedPower_val" value="<?=$prod_data[36];?>" readonly />&nbsp;&nbsp;<br />
  Panel PC Power <input type="text" name="PanelPCPower_val" value="<?=$prod_data[38];?>" readonly />&nbsp;&nbsp;<br />
  Embedded Processor <input type="text" name="EmbeddedProcessor_val" value="<?=$prod_data[39];?>" readonly />&nbsp;&nbsp;<br />
  Panel PC Processor <input type="text" name="PanelPCProcessor_val" value="<?=$prod_data[40];?>" readonly />&nbsp;&nbsp;<br />
  Embedded Type <input type="text" name="EmbeddedType_val" value="<?=$prod_data[41];?>" readonly />&nbsp;&nbsp;<br />
  Panel PC Type <input type="text" name="PanelPCType_val" value="<?=$prod_data[42];?>" readonly />&nbsp;&nbsp;<br />
	</td>
	</tr>
	</tbody>
	</table>
<P style="color:#0F0">
- 這裡列出在 pro_Conditions.html 裏，該 Product Type 所設定的條件:欄位Name及其值Values。default Load 之前的設定。<br>
</p>
</div>
<!--end Info-->
<p class="clear">&nbsp;</p>

<!--上傳圖片-->
<div class=" box">
	<h3>Upload images/photos:</h3>
<table class="addspec">
<tbody >
<tr><th>Upload product image: </th><td ><input type="file" name="ProFile" size="20">&nbsp;<font color="red">* <?=$prod_data[8];?></font>&nbsp;&nbsp;<input type="checkbox" name="ProFile_ALLSKU" value="1">&nbsp;Apply for All skus</td></tr>
<tr><th>Upload Landing image: </th><td><input type="file" name="ProFile_S" size="20">&nbsp;<font color="red">* <?=$prod_data[10];?></font><input id="ProFile_S_value" name="ProFile_S_value" type="hidden" value="<?=$prod_data[10];?>"></td></tr>
<tr><th>Upload image for comparison: </th><td ><input type="file" name="ProFile_com" size="20">&nbsp;<font color="red">* <?=$prod_data[46];?></font><input id="ProFile_C_value" name="ProFile_C_value" type="hidden" value="<?=$prod_data[46];?>"></td></tr>
<tr><th>Upload Big Photo:  </th><td><input type="text" name="ProFile_B" size="60" value="<?php if($prod_data[9]!=''){ echo $prod_data[9]; }else{ echo $BigProd_url; }?>">&nbsp;</td></tr>
<tr><th>Legend:  </th><td><input type="text" name="Legend1_val" size="60" value="<?=$prod_data[37];?>">&nbsp;</td></tr>
<tr><th>Upload multi image:</th>
  <td>
    <div class="button14 left" style="width:60px;" ><a class="fancybox fancybox.iframe" href="multi_images.php?cid=<?=$prod_data[0];?>&model=<?=$prod_data[4];?>&lang=<?=$prod_data[6];?>&type=<?=$prod_data[2];?>">Select</a></div>
  </td>
</tr>
</tbody>
</table>
<P style="color:#0F0">
- 這裡會 load 相同 model 第一個 SKU 所設定的條件的值，為預設。然後可以edit。
</p>
</div>
<!--end 上傳圖片-->

<p class="clear">&nbsp;</p>
<!--icons top-->
<div class=" box">
<h3>Icons(Top):</h3>
<table class="addspec"><tbody >
<tr >
<td>
<div class="button14 left" style="width:60px;" ><a class="fancybox fancybox.iframe" href="elb_select_icons.php?cid=<?=$prod_data[0];?>&lang=<?=$prod_data[6];?>">Select</a></div>
<br /><br /><textarea id="iconvals" name="iconvals" rows="5" cols="80" style="border: none;max-width: 700px; max-height: 60px;" onClick="icon_show(this.form)" readonly><?=$prod_data[11];?></textarea>
<p class="clear">&nbsp;</p>
<!--show 出已經選的-->
<input type="hidden" name="icon_get" id="icon_get" value="" />
<div class="left" style="width:900px">
<script language='JavaScript'>
function show_icon(){
var myString = document.form2.icon_get.value;
var splits = myString.split(",");

var i;
var path="../../images/logo/";
var icon_str = "";
for(i=0;i<splits.length-1;i++){
 icon_str=icon_str + "<img src=\""+path+splits[i]+"\" alt\"\" \/>&nbsp;&nbsp;";
}
document.getElementById('icon_list').innerHTML = icon_str;
}
</script>
<div style="display:inline;" id="icon_list" class="left" style="width:100px; margin:10px 4px"></div>
</div>
<!--end-->
</td>
</tr>
</tbody>
</table>
<P style="color:#0F0">- 這裡會 load 相同 model 第一個 SKU 所設定的條件的值，為預設。然後可以edit。</p>
</div>
<!--end icons top-->
<p class="clear">&nbsp;</p>
<!--icons bottom-->
<div class=" box">
<h3>Icons(Bottom):</h3>
<table class="addspec"><tbody >
<tr >
<td>
<div class="button14 left" style="width:60px;" ><a class="fancybox fancybox.iframe" href="elb_select_icons_bottom.php?cid=<?=$prod_data[0];?>&lang=<?=$prod_data[6];?>">Select</a></div>
<br /><br /><textarea id="iconvals_b" name="iconvals_b" rows="5" cols="80" style="border: none;max-width: 700px; max-height: 60px;" readonly><?=$prod_data[43];?></textarea>
<p class="clear">&nbsp;</p>
<!--show 出已經選的-->
<input type="hidden" name="icon_get" id="icon_get" value="" />
<div class="left" style="width:900px">
</div>
<!--end-->
</td>
</tr>
</tbody>
</table>
<P style="color:#0F0">- 這裡會 load 相同 model 第一個 SKU 所設定的條件的值，為預設。然後可以edit。</p>
</div>
<!--end icons bottom-->
<p class="clear">&nbsp;</p>
<!--Landing Title-->
<div class=" box">
<h3>Landing Title:</h3>
<textarea id="LandTitle" name="LandTitle" rows="5" cols="80" style="max-width: 700px; max-height: 200px;"><?=$prod_data[44];?></textarea>
<P style="color:#0F0">
</p>
</div>
<!--end Landing Title-->
 <p class="clear">&nbsp;</p>
<!--Description-->
<div class=" box">
<h3>Title Description:</h3>
<textarea id="desc" name="desc" rows="5" cols="80" style="max-width: 700px; max-height: 200px;"><?=$prod_data[12];?></textarea>
<P style="color:#0F0">
- 這裡會 load 相同 model 第一個 SKU 所設定的條件的值，為預設。然後可以edit。<br />
- 可留白
</p>
</div>
 <!--end Description-->
 <p class="clear">&nbsp;</p>
  <!--Related  Products-->
<div class=" box">
<h3>Related  Products:   &nbsp;&nbsp; <select name="relate_enable"><option value="1" <?php if($prod_data[13]==1){ echo "selected"; } ?>>Shown</option><option value="0" <?php if($prod_data[13]==0){ echo "selected"; } ?>>Hidden</option></select></h3>
 <div class="button14" style="width:60px;" ><a class="fancybox fancybox.iframe" href="elb_supported_pros.php?cid=<?=$prod_data[0];?>&lang=<?=$prod_data[6];?>">Edit</a></div>
 <!--列出被勾選的Products-->
 <textarea id="relProd_val" name="relProd_val" rows="5" cols="80" style="border: none;max-width: 800px; max-height: 200px;" readonly><?=$prod_data[14];?></textarea>
 <p></p><!--end of 列出被勾選的Products-->
 <P style="color:#0F0">- Shown 跟 Hidden 的設定，決定這個資訊是否要show在Product SPEC 頁面上。<br>- 這裡會 load 相同 model 第一個 SKU 所設定的條件的值，為預設。然後可以edit。<br>- 預設為隱藏</p>
 </div>
   <!--end Related  Products-->
<p class="clear">&nbsp;</p>
  <!--Compatible Products-->
<div class=" box">
<h3>Compatible Products:   &nbsp;&nbsp; <select name="compat_enable"><option value="1" <?php if($prod_data[15]==1){ echo "selected"; } ?>>Shown</option><option value="0" <?php if($prod_data[15]==0){ echo "selected"; } ?>>Hidden</option></select></h3>
 <div class="button14 " style="width:60px;" ><a class="fancybox fancybox.iframe" href="elb_supported_compat_pros.php?cid=<?=$prod_data[0];?>&lang=<?=$prod_data[6];?>">Edit</a></div>
 <!--列出被勾選的Products-->
 <textarea id="compacProd_val" name="compacProd_val" rows="5" cols="80" style="border: none;max-width: 800px; max-height: 200px;" readonly><?=$prod_data[16];?></textarea>
 <p></p><!--end of 列出被勾選的Products-->
 <P style="color:#0F0">- Shown 跟 Hidden 的設定，決定這個資訊是否要show在Product SPEC 頁面上。<br>- 這裡會 load 相同 model 第一個 SKU 所設定的條件的值，為預設。然後可以edit。<br>- 預設為隱藏</p>
 </div>
   <!--end Compatible Products-->
<p class="clear">&nbsp;</p>
<div>
<input type="hidden" name="pid01" value="<?=$prod_data[0];?>"><input type="hidden" name="lang01" value="<?=$prod_data[6];?>">
<BUTTON name="submitbutton01" id="submitbutton01" style="width:76px; margin-right:10px" type="submit" class="big_button left">Done</BUTTON><BUTTON name="submitbutton02" id="submitbutton02" style="width:86px; margin-right:10px" type="reset" class="big_button left" onclick="self.location='default.php'">Cancel</BUTTON><!--form2.reset();-->
  <P style="color:#0F0">  - 完成設定，回到default.html，並將更新的這筆資料show在第一筆<br>  - Cancel 回到 前一頁  </p>
</div>
</form>
</div>
<p class="clear">&nbsp;</p>
<div id="footer">	Copyright &copy; 2013 Company Co. All rights reserved.<div class="gotop" onClick="location='#top'">Top</div></div>
</body>
</html>