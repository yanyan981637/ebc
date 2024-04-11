<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
require "../config.php";
ini_set('max_execution_time', 0);
$SPECType_num="";

session_start();
if(empty($_SESSION['user']) || empty($_SESSION['password']) || empty($_SESSION['login_time'])){
  echo "<script language='JavaScript'>location='../login.php'</script>";
  exit();
}

$Save_State="";

if(isset($_REQUEST['Mart_type'])!=''){
  if(trim($_REQUEST['Mart_type'])=='Add'){

    $s1=htmlspecialchars($_REQUEST['str_val1'], ENT_QUOTES);
    $s2=trim($_REQUEST['str_val2']);
    $s3=trim($_REQUEST['str_val3']);
    $s4=trim($_REQUEST['str_val4']);
    $s6=trim($_REQUEST['str_val6']);
    $pid=intval($_REQUEST['PType_id']);
    $ccid=intval($_REQUEST['PCate_id']);

    if(strlen($s4)>1){
      $PA_1=$s4;
    }else{
      $PA_1="0".$s4;
    }

    if($s1<>""){

      $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
      mysqli_query($link_db,'SET NAMES utf8');
      mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
      mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
      //$select=mysqli_select_db($dataBase, $link_db);    

      $str_values="select MValue_id FROM `matrix_values` order by MValue_id desc limit 1";
      $check_values=mysqli_query($link_db,$str_values);
      $Max_CValID=mysqli_fetch_row($check_values);
      $MCount=$Max_CValID[0]+1;

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
      $guid = strtr($guid,'{','');
      $guid = strtr($guid,'}','');

      putenv("TZ=Asia/Taipei");
      $now=date("Y/m/d H:i:s");
      $_SESSION["SEL_PMatrix01"]=$s6;    

      $strs="insert into `matrix_values` (`MValue_id`, `MValue_Mid`, `MValue_SUBName`, `MValue_VName`, `SKUs`, `GUID`, `crea_d`, `crea_u`, `IsShow`, `Tooltips`) values ($MCount,".$s2.",'".$s3."','".$s1."','','','$now','1782','1','')";
      $cmds=mysqli_query($link_db,$strs);
      echo "<script>self.location='add_spec.php?PCate_id=".$ccid."&p_PMA=".$PA_1."&p_seVal=".$s1."&PType_id=".$pid."&get_cookies=Yes#product_matrix';</script>";
      exit();
    }else{
    }
    echo "<script>self.location='add_spec.php?PCate_id=".$ccid."&p_PMA=".$PA_1."&p_seVal=".$s1."&PType_id=".$pid."#product_matrix';</script>";
    exit();	
  }
}


if(isset($_REQUEST['methods'])!=''){
  if(trim($_REQUEST['methods'])=='insert_spec'){
    $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
    mysqli_query($link_db,'SET NAMES utf8');
    mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
    mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
    //$select=mysqli_select_db($dataBase, $link_db); 

   
    //*************2018.05.17 判斷是否重複sku ***********
    if(isset($_POST['SKU_value'])!=''){
      $SKU_value=trim($_POST['SKU_value']);
    }else{
      $SKU_value="";
    }
    $sku_str = "SELECT * FROM `product_skus` WHERE SKU='".$SKU_value."'";
    $cmdtitle=mysqli_query($link_db, $sku_str);

    //*************2018.05.17 判斷是否重複sku End ***********

    $str_sku="select Product_SKU_Auto_ID FROM product_skus order by Product_SKU_Auto_ID desc limit 1";
    $check_sku=mysqli_query($link_db,$str_sku);
    $Max_CSKUID=mysqli_fetch_row($check_sku);
    $MCount=$Max_CSKUID[0]+1;

    if(isset($_POST['PT1'])==101 || isset($_POST['PT1'])==102){ //MainBoard
      $S_Count=17;
      $PMatr_TName="product_matrix";
    }else if(isset($_POST['PT1'])==103 || isset($_POST['PT1'])==104){ //BareBone
      $S_Count=20;
      $PMatr_TName="product_matrix_b";
    }else if(isset($_POST['PT1'])==0106){
      $S_Count=16;
      $PMatr_TName="product_matrix_h";
    }
    /* 開始寫入product_matrix */
    for($S=3;$S<$S_Count;$S++){

      if(strlen($S)>1){
        $S=$S;
      }else{
        $S="0".$S; 
      }
      $str_item="SEL_PMT0".$S;
      $str_item_M="PMS_".$S;
      if(isset($_POST[$str_item])!=''){
        if(trim($_POST[$str_item])!='Add'){
          $str="'".$_POST[$str_item]."',";
        }
      }else{		    
        if(isset($_POST[$str_item_M])!=''){
          $str="'".$_POST[$str_item_M]."',";
        }else{
          $str="";
        } 
      }   
      $str_s=$str_s.$str;
    }
    $str=substr($str_s, 0, strlen($str_s)-1);
    if(isset($_POST['SEL_PMatrix'])!=''){
      $sstr=$_POST['SEL_PMatrix'].",'".$_POST['SEL_PMODEL']."','".$MCount."',".$str;
    }else{
      $sstr="0,'".$_POST['SEL_PMODEL']."','".$MCount."',".$str;
    }

    $str_m="select MatrixID FROM ".$PMatr_TName." order by MatrixID desc limit 1";
    $check_m=mysqli_query($link_db,$str_m);
    $Max_PMaxtrixID=mysqli_fetch_row($check_m);
    $MMXCount=$Max_PMaxtrixID[0]+1;

    if(isset($_POST['PT1'])!=''){
      if(intval($_POST['PT1'])==101 || intval($_POST['PT1'])==102){ 
        $sql = "INSERT INTO `product_matrix`(`MatrixID`,`SocketR_NameID`, `ModelCode`, `SKU`, `FormFactor`, `CPU_QPI`, `Chipset`, `PCIx`, `PCI`, `PCIe`, `Mem_Max`, `Mem_Type`, `IFeatures_A`, `IFeatures_G`, `IFeatures_N`, `IFeatures_R`, `Sr_Mgt`, `RHS_typ`, `UrlSite`, `IsShow`) VALUES (".$MMXCount.",$sstr,'','1')"; 
      }else if(intval($_POST['PT1'])==103 || intval($_POST['PT1'])==104){
        $sql = "INSERT INTO `product_matrix_b`(`MatrixID`,`SocketR_NameID`, `ModelCode`, `SKU`, `Dim_H`, `Dim_W`, `Dim_D`, `Power_Supply`, `CPU_Series`, `Mem_Max`, `Mem_Type`, `HDD_Max`, `HDD_Type`, `HDD_HF`, `NIC_GbE`, `NIC_10GbE`, `PCIx`, `PCI`, `PCIe`, `Sr_Mgt`, `RHS_typ`, `UrlSite`, `IsShow`) VALUES (".$MMXCount.",$sstr,'','1')";
      }else if(intval($_POST['PT1'])==0106){
        $sql = "INSERT INTO `product_matrix_h`(`MatrixID`,`SocketR_NameID`, `ModelCode`, `SKU`, `FormFactor`, `Dim_W`, `Dim_D`, `Chipset`, `Cache_Freq`, `Host_Interface`, `Int_Port`, `Ext_Port`, `SW_RAID`, `HW_RAID`, `Enhanced_RAID`, `Optional_BBU`, `RHS_typ`, `UrlSite`, `IsShow`) VALUES (".$MMXCount.",$sstr,'','1')";
      }
    }     
    $query=mysqli_query($link_db,$sql);
    /* 結束寫入product_matrix */

    if(isset($_POST['PT1'])!=''){
      $PT1=trim($_POST['PT1']);
    }else{
      $PT1="";
    }
    if(isset($_POST['SEL_PMODEL'])!=''){
      $SEL_PMODEL=trim($_POST['SEL_PMODEL']);
    }else{
      $SEL_PMODEL="";
    }
    
    if(isset($_POST['UPC_value'])!=''){
      $UPC_value=trim($_POST['UPC_value']);
    }else{
      $UPC_value="";
    }
    if(isset($_POST['SEL_PN1'])!=''){
      $SEL_PNWork=trim($_POST['SEL_PN1']);
    }else{
      $SEL_PNWork="";
    }
    if(isset($_POST['SEL_PN2'])!=''){
      $SEL_SAS=trim($_POST['SEL_PN2']);
    }else{
      $SEL_SAS="";
    }
    if(isset($_POST['SEL_PN3'])!=''){
      $SEL_FFactor=trim($_POST['SEL_PN3']);
    }else{
      $SEL_FFactor="";
    }
    if(isset($_POST['SEL_PN4'])!=''){
      $SEL_PRiser=trim($_POST['SEL_PN4']);
    }else{
      $SEL_PRiser="";
    }
    if(isset($_POST['SEL_PN5'])!=''){
      $SEL_HDD_Bay=trim($_POST['SEL_PN5']);
    }else{
      $SEL_HDD_Bay="";
    }
    if(isset($_POST['SEL_PN6'])!=''){
      $SEL_PSU=trim($_POST['SEL_PN6']);
    }else{
      $SEL_PSU="";
    }
    if(isset($_POST['SEL_PN7'])!=''){
      $SEL_Host_IF=trim($_POST['SEL_PN7']);
    }else{
      $SEL_Host_IF="";
    }
    if(isset($_POST['SEL_PN8'])!=''){
      $SEL_C_Type=trim($_POST['SEL_PN8']);
    }else{
      $SEL_C_Type="";
    }
    if(isset($_POST['SEL_PN9'])!=''){
      $SEL_C_Qty=trim($_POST['SEL_PN9']);
    }else{
      $SEL_C_Qty="";
    }
    if(isset($_POST['SEL_PN10'])!=''){
      $SEL_FAN=trim($_POST['SEL_PN10']);
    }else{
      $SEL_FAN="";
    }
    if(isset($_POST['SEL_PN11'])!=''){
      $SEL_PCIE_slot=trim($_POST['SEL_PN11']);
    }else{
      $SEL_PCIE_slot="";
    }
    if(isset($_POST['SEL_SKU_S'])!=''){
      $SEL_SKU_S=trim($_POST['SEL_SKU_S']); 
    }else{
      $SEL_SKU_S="";
    }
    if(isset($_POST['specEOL'])!=''){
      $specEOL=trim($_POST['specEOL']);
    }else{
      $specEOL="";
    }
    if(isset($_POST['SPECC_Sort_tr'])!=''){
      $SPECC_Sort_tr=trim($_POST['SPECC_Sort_tr']);
    }else{
      $SPECC_Sort_tr="";
    }
    if(isset($_POST['SPECTP_str'])!=''){
      $SPECTP_str=trim($_POST['SPECTP_str']);
    }else{
      $SPECTP_str="";
    }
    if(isset($_POST['compareBox'])!=''){
      $compareBox=trim($_POST['compareBox']);
    }else{
      $compareBox="";
    }
    if(isset($_POST['quoteBox'])!=''){
      $quoteBox=trim($_POST['quoteBox']);
    }else{
      $quoteBox="";
    }

    if($specEOL=='1'){
      $specEOL='1';
    }else{
      $specEOL='0';
    }
    if($compareBox=='1'){
      $compareBox='1';
    }else{
      $compareBox='0';
    }
    if($quoteBox=='1'){
      $quoteBox='1';
    }else{
      $quoteBox='0';
    }

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
$guid = strtr($guid,'{','');
$guid = strtr($guid,'}','');

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

$str_lang="";
if(isset($_POST['aspecLang'])!=''){
/*  foreach($_POST['aspecLang'] as $check_lang) {
    $str_lang=$str_lang.$check_lang.",";
  }*/
  $str_lang="EN,";
}else{
  $str_lang="";	
}

$note01=htmlspecialchars($_POST['note01'],  ENT_QUOTES);

//*************SERVERID******************
$str_P_mb="select `SYSTEMBOARDID` FROM `p_s_main_systemboards` order by `SYSTEMBOARDID` desc limit 1";
$check_P_mb=mysqli_query($link_db,$str_P_mb);
$Max_P_mbMaxtrixID=mysqli_fetch_row($check_P_mb);
$MBMXCount=$Max_P_mbMaxtrixID[0]+1;

$str_P_bb="select `SERVERID` FROM `p_b_main_serverbarebones` order by `SERVERID` desc limit 1";
$check_P_bb=mysqli_query($link_db,$str_P_bb);
$Max_P_bbMaxtrixID=mysqli_fetch_row($check_P_bb);
$BBMXCount=$Max_P_bbMaxtrixID[0]+1;

$str_P_panel="select `PANELPCID` FROM `p_b_main_panelpc` order by `PANELPCID` desc limit 1";
$check_P_panel=mysqli_query($link_db,$str_P_panel);
$Max_P_panelMaxtrixID=mysqli_fetch_row($check_P_panel);
$PANELMXCount=$Max_P_panelMaxtrixID[0]+1;

$str_P_embedded="select `EMBEDDEDID` FROM `p_b_main_embedded` order by `EMBEDDEDID` desc limit 1";
$check_P_embedded=mysqli_query($link_db,$str_P_embedded);
$Max_P_embeddedMaxtrixID=mysqli_fetch_row($check_P_embedded);
$EMBEDDEDMXCount=$Max_P_embeddedMaxtrixID[0]+1;

$str_P_industria="select `INDUSTRIAMBID` FROM `p_b_main_industriamb` order by `INDUSTRIAMBID` desc limit 1";
$check_P_industria=mysqli_query($link_db,$str_P_industria);
$Max_P_industriaMaxtrixID=mysqli_fetch_row($check_P_industria);
$INDUSTRIAMBMXCount=$Max_P_industriaMaxtrixID[0]+1;

$str_P_ocp="select `OCPID` FROM `p_b_main_ocpserver` order by `OCPID` desc limit 1";
$check_P_ocp=mysqli_query($link_db,$str_P_ocp);
$Max_P_ocpMaxtrixID=mysqli_fetch_row($check_P_ocp);
$ocpMXCount=$Max_P_ocpMaxtrixID[0]+1;

$str_P_OCPMezz="select `OCPMezzID` FROM `p_b_main_ocpmezz` order by `OCPMezzID` desc limit 1";
$check_P_OCPMezz=mysqli_query($link_db,$str_P_OCPMezz);
$Max_P_OCPMezzID=mysqli_fetch_row($check_P_OCPMezz);
$OCPMezzMXCount=$Max_P_OCPMezzID[0]+1;

$str_P_JBODF="select `JBODFID` FROM `p_b_main_jbodjbof` order by `JBODFID` desc limit 1";
$check_P_JBODF=mysqli_query($link_db,$str_P_JBODF);
$Max_P_JBODFID=mysqli_fetch_row($check_P_JBODF);
$JBODFMXCount=$Max_P_JBODFID[0]+1;

$str_P_OCPRACK="select `OCPRACKID` FROM `p_b_main_ocprack` order by `OCPRACKID` desc limit 1";
$check_P_OCPRACK=mysqli_query($link_db,$str_P_OCPRACK);
$Max_P_OCPRACKID=mysqli_fetch_row($check_P_OCPRACK);
$OCPRACKMXCount=$Max_P_OCPRACKID[0]+1;

$str_P_pos="select `POSID` FROM `p_b_main_pos` order by `POSID` desc limit 1";
$check_P_pos=mysqli_query($link_db,$str_P_pos);
$Max_P_posMaxtrixID=mysqli_fetch_row($check_P_pos);
$posMXCount=$Max_P_posMaxtrixID[0]+1;

$str_P_DSG="select `IntelDSGID` FROM `p_b_main_IntelDSG` order by `IntelDSGID` desc limit 1";
$check_P_DSG=mysqli_query($link_db,$str_P_DSG);
$Max_P_DSGMaxtrixID=mysqli_fetch_row($check_P_DSG);
$DSGMXCount=$Max_P_DSGMaxtrixID[0]+1;
//******************************************

$lang_all="EN";

if(isset($_POST['PT1'])!=''){
  if(intval($_POST['PT1'])==101 || intval($_POST['PT1'])==102){
    $str_skuu="INSERT INTO `product_skus`(`Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE`, `NetWorking`, `SAS`, `FormFactor`, `UPCcode`, `FAN`, `IS_EOL`, `Web_Disable`, `GUID`, `crea_d`, `crea_u`, `upd_d`, `slang`, `SKU_CategorySort`, `SKU_Type`, `MODELDESCRIPT`, `COMPARE`, `REQUEST_QUOTE`) VALUES ($MCount,$PT1,'$SKU_value','$SEL_PMODEL','$SEL_PNWork','$SEL_SAS','$SEL_FFactor','$UPC_value','',$specEOL,$SEL_SKU_S,'$guid','$now','1782','$now','$str_lang','$SPECC_Sort_tr','$SPECTP_str','$note01','$compareBox','$quoteBox')";

    foreach($_POST['aspecLang'] as $check_lang) {
      $aspecLang_check=$aspecLang_check.$check_lang.",";
    }

    $lang_all_split=explode(",",$lang_all,-1);
    for($j=0;$j<=count($lang_all_split)-1;$j++){
      if(strpos($aspecLang_check,$lang_all_split[$j].",")!='' || strpos($aspecLang_check,$lang_all_split[$j].",")===0){
        $langSTUT=1;
      }else{
        $langSTUT=0;
      }
      $str_prod_all=$str_prod_all."(".$MCount.",0,1,'".$SKU_value."','".$SEL_PMODEL."',".$SEL_SKU_S.",'".$lang_all_split[$j].",','".$now."','1782',".$PT1.",".$langSTUT.",'".$note01."'),";
    }

    $str_con_skus="INSERT INTO `contents_product_skus`(`Product_SContents_Auto_ID`, `CategoryModuID`, `ProductTypeID`, `SKU`, `MODELCODE`, `STATUS`, `slang`, `crea_d`, `crea_u`, `ProductTypeID_SKU`, `lang_status`, `MODELDESCRIPT`) VALUES ".substr($str_prod_all,0 ,strlen($str_prod_all)-1);
    
    $str_mod="SELECT `SYSTEMBOARDID` FROM `p_s_main_systemboards` WHERE `MODELCODE`='$SEL_PMODEL' order by `SYSTEMBOARDID` desc";
    $cmd_mod=mysqli_query($link_db,$str_mod);
    $num=mysqli_num_rows($cmd_mod);
    if($num==0){
      $str_prods="INSERT INTO `p_s_main_systemboards`(`SYSTEMBOARDID`, `MODELNAME`, `MODELCODE`,`LANG`,`STATUS`) value (".$MBMXCount.",'','".$SEL_PMODEL."','en-US','0')";
      $cmd_prods=mysqli_query($link_db,$str_prods);
    }
  }else if(intval($_POST['PT1'])==103){
    $str_skuu="INSERT INTO `product_skus`(`Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE`, `PCI-E_slot`, `HDD_Bay`, `PSU`, `UPCcode`, `FAN`, `IS_EOL`, `Web_Disable`, `GUID`, `crea_d`, `crea_u`, `upd_d`, `slang`, `SKU_CategorySort`, `SKU_Type`, `MODELDESCRIPT`, `COMPARE`, `REQUEST_QUOTE`) VALUES ($MCount,$PT1,'$SKU_value','$SEL_PMODEL','$SEL_PCIE_slot','$SEL_HDD_Bay','$SEL_PSU','$UPC_value','',$specEOL,$SEL_SKU_S,'$guid','$now','1782','$now','$str_lang','$SPECC_Sort_tr','$SPECTP_str','$note01','$compareBox','$quoteBox')";

    foreach($_POST['aspecLang'] as $check_lang) {
      $aspecLang_check=$aspecLang_check.$check_lang.",";
    }

    $lang_all_split=explode(",",$lang_all,-1);
    for($j=0;$j<=count($lang_all_split)-1;$j++){
      if(strpos($aspecLang_check,$lang_all_split[$j].",")!='' || strpos($aspecLang_check,$lang_all_split[$j].",")===0){
        $langSTUT=1;
      }else{
        $langSTUT=0;
      }
      $str_prod_all=$str_prod_all."(".$MCount.",0,2,'".$SKU_value."','".$SEL_PMODEL."',".$SEL_SKU_S.",'".$lang_all_split[$j].",','".$now."','1782',".$PT1.",".$langSTUT.",'".$note01."'),";
    }

    $str_con_skus="INSERT INTO `contents_product_skus`(`Product_SContents_Auto_ID`, `CategoryModuID`, `ProductTypeID`, `SKU`, `MODELCODE`, `STATUS`, `slang`, `crea_d`, `crea_u`, `ProductTypeID_SKU`, `lang_status`, `MODELDESCRIPT`) VALUES ".substr($str_prod_all,0 ,strlen($str_prod_all)-1);
    
    $str_mod="SELECT `SERVERID` FROM `p_b_main_serverbarebones` WHERE `MODELCODE`='$SEL_PMODEL' order by `SYSTEMBOARDID` desc";
    $cmd_mod=mysqli_query($link_db,$str_mod);
    $num=mysqli_num_rows($cmd_mod);
    if($num==0){
      $str_prods="INSERT INTO `p_b_main_serverbarebones`(`SERVERID`, `MODELNAME`, `MODELCODE`,`LANG`,`STATUS`) value (".$BBMXCount.",'','".$SEL_PMODEL."','en-US','0')";    
      $cmd_prods=mysqli_query($link_db,$str_prods);
    }

  }else if(intval($_POST['PT1'])==104){
    $str_skuu="INSERT INTO `product_skus`(`Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE`, `Riser`, `HDD_Bay`, `PSU`, `UPCcode`, `FAN`, `IS_EOL`, `Web_Disable`, `GUID`, `crea_d`, `crea_u`, `upd_d`, `slang`, `SKU_CategorySort`, `SKU_Type`, `MODELDESCRIPT`, `COMPARE`, `REQUEST_QUOTE`) VALUES ($MCount,$PT1,'$SKU_value','$SEL_PMODEL','$SEL_PRiser','$SEL_HDD_Bay','$SEL_PSU','$UPC_value','',$specEOL,$SEL_SKU_S,'$guid','$now','1782','$now','$str_lang','$SPECC_Sort_tr','$SPECTP_str','$note01','$compareBox','$quoteBox')";

    foreach($_POST['aspecLang'] as $check_lang) {
      $aspecLang_check=$aspecLang_check.$check_lang.",";
    }

    $lang_all_split=explode(",",$lang_all,-1);
    for($j=0;$j<=count($lang_all_split)-1;$j++){
      if(strpos($aspecLang_check,$lang_all_split[$j].",")!='' || strpos($aspecLang_check,$lang_all_split[$j].",")===0){
        $langSTUT=1;
      }else{
        $langSTUT=0;
      }
      $str_prod_all=$str_prod_all."(".$MCount.",0,2,'".$SKU_value."','".$SEL_PMODEL."',".$SEL_SKU_S.",'".$lang_all_split[$j].",','".$now."','1782',".$PT1.",".$langSTUT.",'".$note01."'),";
    }

    $str_con_skus="INSERT INTO `contents_product_skus`(`Product_SContents_Auto_ID`, `CategoryModuID`, `ProductTypeID`, `SKU`, `MODELCODE`, `STATUS`, `slang`, `crea_d`, `crea_u`, `ProductTypeID_SKU`, `lang_status`, `MODELDESCRIPT`) VALUES ".substr($str_prod_all,0 ,strlen($str_prod_all)-1);
    
    $str_mod="SELECT `SERVERID` FROM `p_b_main_serverbarebones` WHERE `MODELCODE`='$SEL_PMODEL' order by `SYSTEMBOARDID` desc";
    $cmd_mod=mysqli_query($link_db,$str_mod);
    $num=mysqli_num_rows($cmd_mod);
    if($num==0){
      $str_prods="INSERT INTO `p_b_main_serverbarebones`(`SERVERID`, `MODELNAME`, `MODELCODE`,`LANG`,`STATUS`) value (".$BBMXCount.",'','".$SEL_PMODEL."','en-US','0')";  
      $cmd_prods=mysqli_query($link_db,$str_prods);
    }

  }else if(intval($_POST['PT1'])==107){
    $str_skuu="INSERT INTO `product_skus`(`Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE`, `Host_IF`, `Conn_Type`, `Conn_Qty`, `UPCcode`, `FAN`, `IS_EOL`, `Web_Disable`, `GUID`, `crea_d`, `crea_u`, `upd_d`, `slang`, `SKU_CategorySort`, `SKU_Type`, `MODELDESCRIPT`, `COMPARE`, `REQUEST_QUOTE`) VALUES ($MCount,$PT1,'$SKU_value','$SEL_PMODEL','$SEL_Host_IF','$SEL_C_Type','$SEL_C_Qty','$UPC_value','',$specEOL,$SEL_SKU_S,'$guid','$now','1782','$now','$str_lang','$SPECC_Sort_tr','$SPECTP_str','$note01','$compareBox','$quoteBox')";
    $str_con_skus="INSERT INTO `contents_product_skus`(`Product_SContents_Auto_ID`, `CategoryModuID`, `ProductTypeID`, `SKU`, `MODELCODE`, `STATUS`, `slang`, `crea_d`, `crea_u`, `ProductTypeID_SKU`, `MODELDESCRIPT`) VALUES ($MCount,0,46,'$SKU_value','$SEL_PMODEL',$SEL_SKU_S,'$str_lang','$now','1782',$PT1,'$note01')";
    $str_mod="select `PANELPCID` FROM `p_b_main_panelpc` WHERE `MODELCODE`='$SEL_PMODEL' order by `PANELPCID` desc";
    $cmd_mod=mysqli_query($link_db,$str_mod);
    $num=mysqli_num_rows($cmd_mod);
    if($num==0){
      $str_prods="INSERT INTO `p_b_main_panelpc`(`PANELPCID`, `MODELNAME`, `MODELCODE`,`LANG`,`STATUS`) value (".$PANELMXCount.",'TYAN','".$SEL_PMODEL."','en-US','0')";
      $cmd_prods=mysqli_query($link_db,$str_prods);
    }
  }else if(intval($_POST['PT1'])==108){
    $str_skuu="INSERT INTO `product_skus`(`Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE`, `Riser`, `HDD_Bay`, `PSU`, `UPCcode`, `FAN`, `IS_EOL`, `Web_Disable`, `GUID`, `crea_d`, `crea_u`, `upd_d`, `slang`, `SKU_CategorySort`, `SKU_Type`, `MODELDESCRIPT`, `COMPARE`, `REQUEST_QUOTE`) VALUES ($MCount,$PT1,'$SKU_value','$SEL_PMODEL','$SEL_PRiser','$SEL_HDD_Bay','$SEL_PSU','$UPC_value','$SEL_FAN',$specEOL,$SEL_SKU_S,'$guid','$now','1782','$now','$str_lang','$SPECC_Sort_tr','$SPECTP_str','$note01','$compareBox','$quoteBox')";
    $str_con_skus="INSERT INTO `contents_product_skus`(`Product_SContents_Auto_ID`, `CategoryModuID`, `ProductTypeID`, `SKU`, `MODELCODE`, `STATUS`, `slang`, `crea_d`, `crea_u`, `ProductTypeID_SKU`, `MODELDESCRIPT`) VALUES ($MCount,0,47,'$SKU_value','$SEL_PMODEL',$SEL_SKU_S,'$str_lang','$now','1782',$PT1,'$note01')";
    $str_mod="select `EMBEDDEDID` FROM `p_b_main_embedded` WHERE `MODELCODE`='$SEL_PMODEL' order by `EMBEDDEDID` desc";
    $cmd_mod=mysqli_query($link_db,$str_mod);
    $num=mysqli_num_rows($cmd_mod);
    if($num==0){
      $str_prods="INSERT INTO `p_b_main_embedded`(`EMBEDDEDID`, `MODELNAME`, `MODELCODE`,`LANG`,`STATUS`) value (".$EMBEDDEDMXCount.",'CBU','".$SEL_PMODEL."','en-US','0')";
      $cmd_prods=mysqli_query($link_db,$str_prods);
    }

  }else if(intval($_POST['PT1'])==109){
    $str_skuu="INSERT INTO `product_skus`(`Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE`, `Riser`, `HDD_Bay`, `PSU`, `UPCcode`, `FAN`, `IS_EOL`, `Web_Disable`, `GUID`, `crea_d`, `crea_u`, `upd_d`, `slang`, `SKU_CategorySort`, `SKU_Type`, `MODELDESCRIPT`, `COMPARE`, `REQUEST_QUOTE`) VALUES ($MCount,$PT1,'$SKU_value','$SEL_PMODEL','$SEL_PRiser','$SEL_HDD_Bay','$SEL_PSU','$UPC_value','$SEL_FAN',$specEOL,$SEL_SKU_S,'$guid','$now','1782','$now','$str_lang','$SPECC_Sort_tr','$SPECTP_str','$note01','$compareBox','$quoteBox')";
    $str_con_skus="INSERT INTO `contents_product_skus`(`Product_SContents_Auto_ID`, `CategoryModuID`, `ProductTypeID`, `SKU`, `MODELCODE`, `STATUS`, `slang`, `crea_d`, `crea_u`, `ProductTypeID_SKU`, `MODELDESCRIPT`) VALUES ($MCount,0,48,'$SKU_value','$SEL_PMODEL',$SEL_SKU_S,'$str_lang','$now','1782',$PT1,'$note01')";
    $str_mod="select `INDUSTRIAMBID` FROM `p_b_main_industriamb` WHERE `MODELCODE`='$SEL_PMODEL' order by `INDUSTRIAMBID` desc";
    $cmd_mod=mysqli_query($link_db,$str_mod);
    $num=mysqli_num_rows($cmd_mod);
    if($num==0){
      $str_prods="INSERT INTO `p_b_main_industriamb`(`INDUSTRIAMBID`, `MODELNAME`, `MODELCODE`,`LANG`,`STATUS`) value (".$INDUSTRIAMBMXCount.",'CBU','".$SEL_PMODEL."','en-US','0')";
      $cmd_prods=mysqli_query($link_db,$str_prods);
    }
  }else if(intval($_POST['PT1'])==110){
    $str_skuu="INSERT INTO `product_skus`(`Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE`, `Host_IF`, `Conn_Type`, `Conn_Qty`, `UPCcode`, `FAN`, `IS_EOL`, `Web_Disable`, `GUID`, `crea_d`, `crea_u`, `upd_d`, `slang`, `SKU_CategorySort`, `SKU_Type`, `MODELDESCRIPT`, `COMPARE`, `REQUEST_QUOTE`) VALUES ($MCount,$PT1,'$SKU_value','$SEL_PMODEL','$SEL_Host_IF','$SEL_C_Type','$SEL_C_Qty','$UPC_value','',$specEOL,$SEL_SKU_S,'$guid','$now','1782','$now','$str_lang','$SPECC_Sort_tr','$SPECTP_str','$note01','$compareBox','$quoteBox')";
    $str_con_skus="INSERT INTO `contents_product_skus`(`Product_SContents_Auto_ID`, `CategoryModuID`, `ProductTypeID`, `SKU`, `MODELCODE`, `STATUS`, `slang`, `crea_d`, `crea_u`, `ProductTypeID_SKU`, `MODELDESCRIPT`) VALUES ($MCount,0,49,'$SKU_value','$SEL_PMODEL',$SEL_SKU_S,'$str_lang','$now','1782',$PT1,'$note01')";
    $str_mod="select `OCPID` FROM `p_b_main_ocpserver` WHERE `MODELCODE`='$SEL_PMODEL' order by `OCPID` desc";
    $cmd_mod=mysqli_query($link_db,$str_mod);
    $num=mysqli_num_rows($cmd_mod);
    if($num==0){
      $str_prods="INSERT INTO `p_b_main_ocpserver`(`OCPID`, `MODELNAME`, `MODELCODE`,`LANG`,`STATUS`) value (".$ocpMXCount.",'CBU','".$SEL_PMODEL."','en-US','0')";
      $cmd_prods=mysqli_query($link_db,$str_prods);
    }
  }else if(intval($_POST['PT1'])==111){
    $str_skuu="INSERT INTO `product_skus`(`Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE`, `Host_IF`, `Conn_Type`, `Conn_Qty`, `UPCcode`, `FAN`, `IS_EOL`, `Web_Disable`, `GUID`, `crea_d`, `crea_u`, `upd_d`, `slang`, `SKU_CategorySort`, `SKU_Type`, `MODELDESCRIPT`, `COMPARE`, `REQUEST_QUOTE`) VALUES ($MCount,$PT1,'$SKU_value','$SEL_PMODEL','$SEL_Host_IF','$SEL_C_Type','$SEL_C_Qty','$UPC_value','',$specEOL,$SEL_SKU_S,'$guid','$now','1782','$now','$str_lang','$SPECC_Sort_tr','$SPECTP_str','$note01','$compareBox','$quoteBox')";
    $str_con_skus="INSERT INTO `contents_product_skus`(`Product_SContents_Auto_ID`, `CategoryModuID`, `ProductTypeID`, `SKU`, `MODELCODE`, `STATUS`, `slang`, `crea_d`, `crea_u`, `ProductTypeID_SKU`, `MODELDESCRIPT`) VALUES ($MCount,0,50,'$SKU_value','$SEL_PMODEL',$SEL_SKU_S,'$str_lang','$now','1782',$PT1,'$note01')";
    $str_mod="select `OCPMezzID` FROM `p_b_main_ocpmezz` WHERE `MODELCODE`='$SEL_PMODEL' order by `OCPMezzID` desc";
    $cmd_mod=mysqli_query($link_db,$str_mod);
    $num=mysqli_num_rows($cmd_mod);
    if($num==0){
      $str_prods="INSERT INTO `p_b_main_ocpmezz`(`OCPMezzID`, `MODELNAME`, `MODELCODE`,`LANG`,`STATUS`) value (".$OCPMezzMXCount.",'CBU','".$SEL_PMODEL."','en-US','0')";
      $cmd_prods=mysqli_query($link_db,$str_prods);
    }
  }else if(intval($_POST['PT1'])==112){
    $str_skuu="INSERT INTO `product_skus`(`Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE`, `Host_IF`, `Conn_Type`, `Conn_Qty`, `UPCcode`, `FAN`, `IS_EOL`, `Web_Disable`, `GUID`, `crea_d`, `crea_u`, `upd_d`, `slang`, `SKU_CategorySort`, `SKU_Type`, `MODELDESCRIPT`, `COMPARE`, `REQUEST_QUOTE`) VALUES ($MCount,$PT1,'$SKU_value','$SEL_PMODEL','$SEL_Host_IF','$SEL_C_Type','$SEL_C_Qty','$UPC_value','',$specEOL,$SEL_SKU_S,'$guid','$now','1782','$now','$str_lang','$SPECC_Sort_tr','$SPECTP_str','$note01','$compareBox','$quoteBox')";
    $str_con_skus="INSERT INTO `contents_product_skus`(`Product_SContents_Auto_ID`, `CategoryModuID`, `ProductTypeID`, `SKU`, `MODELCODE`, `STATUS`, `slang`, `crea_d`, `crea_u`, `ProductTypeID_SKU`, `MODELDESCRIPT`) VALUES ($MCount,0,51,'$SKU_value','$SEL_PMODEL',$SEL_SKU_S,'$str_lang','$now','1782',$PT1,'$note01')";
    $str_mod="select `JBODFID` FROM `p_b_main_jbodjbof` WHERE `MODELCODE`='$SEL_PMODEL' order by `JBODFID` desc";
    $cmd_mod=mysqli_query($link_db,$str_mod);
    $num=mysqli_num_rows($cmd_mod);
    if($num==0){
      $str_prods="INSERT INTO `p_b_main_jbodjbof`(`JBODFID`, `MODELNAME`, `MODELCODE`,`LANG`,`STATUS`) value (".$JBODFMXCount.",'CBU','".$SEL_PMODEL."','en-US','0')";
      $cmd_prods=mysqli_query($link_db,$str_prods);
    }
  }else if(intval($_POST['PT1'])==113){
    $str_skuu="INSERT INTO `product_skus`(`Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE`, `Host_IF`, `Conn_Type`, `Conn_Qty`, `UPCcode`, `FAN`, `IS_EOL`, `Web_Disable`, `GUID`, `crea_d`, `crea_u`, `upd_d`, `slang`, `SKU_CategorySort`, `SKU_Type`, `MODELDESCRIPT`, `COMPARE`, `REQUEST_QUOTE`) VALUES ($MCount,$PT1,'$SKU_value','$SEL_PMODEL','$SEL_Host_IF','$SEL_C_Type','$SEL_C_Qty','$UPC_value','',$specEOL,$SEL_SKU_S,'$guid','$now','1782','$now','$str_lang','$SPECC_Sort_tr','$SPECTP_str','$note01','$compareBox','$quoteBox')";
    $str_con_skus="INSERT INTO `contents_product_skus`(`Product_SContents_Auto_ID`, `CategoryModuID`, `ProductTypeID`, `SKU`, `MODELCODE`, `STATUS`, `slang`, `crea_d`, `crea_u`, `ProductTypeID_SKU`, `MODELDESCRIPT`) VALUES ($MCount,0,52,'$SKU_value','$SEL_PMODEL',$SEL_SKU_S,'$str_lang','$now','1782',$PT1,'$note01')";
    $str_mod="select `OCPRACKID` FROM `p_b_main_ocprack` WHERE `MODELCODE`='$SEL_PMODEL' order by `OCPRACKID` desc";
    $cmd_mod=mysqli_query($link_db,$str_mod);
    $num=mysqli_num_rows($cmd_mod);
    if($num==0){
      $str_prods="INSERT INTO `p_b_main_ocprack`(`OCPRACKID`, `MODELNAME`, `MODELCODE`,`LANG`,`STATUS`) value (".$OCPRACKMXCount.",'CBU','".$SEL_PMODEL."','en-US','0')";
      $cmd_prods=mysqli_query($link_db,$str_prods);
    }
  }else if(intval($_POST['PT1'])==114){
    $str_skuu="INSERT INTO `product_skus`(`Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE`, `Host_IF`, `Conn_Type`, `Conn_Qty`, `UPCcode`, `FAN`, `IS_EOL`, `Web_Disable`, `GUID`, `crea_d`, `crea_u`, `upd_d`, `slang`, `SKU_CategorySort`, `SKU_Type`, `MODELDESCRIPT`, `COMPARE`, `REQUEST_QUOTE`) VALUES ($MCount,$PT1,'$SKU_value','$SEL_PMODEL','$SEL_Host_IF','$SEL_C_Type','$SEL_C_Qty','$UPC_value','',$specEOL,$SEL_SKU_S,'$guid','$now','1782','$now','$str_lang','$SPECC_Sort_tr','$SPECTP_str','$note01','$compareBox','$quoteBox')";
    $str_con_skus="INSERT INTO `contents_product_skus`(`Product_SContents_Auto_ID`, `CategoryModuID`, `ProductTypeID`, `SKU`, `MODELCODE`, `STATUS`, `slang`, `crea_d`, `crea_u`, `ProductTypeID_SKU`, `MODELDESCRIPT`) VALUES ($MCount,0,53,'$SKU_value','$SEL_PMODEL',$SEL_SKU_S,'$str_lang','$now','1782',$PT1,'$note01')";
    $str_mod="select `POSID` FROM `p_b_main_pos` WHERE `MODELCODE`='$SEL_PMODEL' order by `POSID` desc";
    $cmd_mod=mysqli_query($link_db,$str_mod);
    $num=mysqli_num_rows($cmd_mod);
    if($num==0){
      $str_prods="INSERT INTO `p_b_main_pos`(`POSID`, `MODELNAME`, `MODELCODE`,`LANG`,`STATUS`) value (".$posMXCount.",'CBU','".$SEL_PMODEL."','en-US','0')";
      $cmd_prods=mysqli_query($link_db,$str_prods);
    }
  }else if(intval($_POST['PT1'])==115){
    $str_skuu="INSERT INTO `product_skus`(`Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE`, `Host_IF`, `Conn_Type`, `Conn_Qty`, `UPCcode`, `FAN`, `IS_EOL`, `Web_Disable`, `GUID`, `crea_d`, `crea_u`, `upd_d`, `slang`, `SKU_CategorySort`, `SKU_Type`, `MODELDESCRIPT`, `COMPARE`, `REQUEST_QUOTE`) VALUES ($MCount,$PT1,'$SKU_value','$SEL_PMODEL','$SEL_Host_IF','$SEL_C_Type','$SEL_C_Qty','$UPC_value','',$specEOL,$SEL_SKU_S,'$guid','$now','1782','$now','$str_lang','$SPECC_Sort_tr','$SPECTP_str','$note01','$compareBox','$quoteBox')";
    $str_con_skus="INSERT INTO `contents_product_skus`(`Product_SContents_Auto_ID`, `CategoryModuID`, `ProductTypeID`, `SKU`, `MODELCODE`, `STATUS`, `slang`, `crea_d`, `crea_u`, `ProductTypeID_SKU`, `MODELDESCRIPT`) VALUES ($MCount,0,54,'$SKU_value','$SEL_PMODEL',$SEL_SKU_S,'$str_lang','$now','1782',$PT1,'$note01')";
    $str_mod="select `5GID` FROM `p_b_main_5G` WHERE `MODELCODE`='$SEL_PMODEL' order by `POSID` desc";
    $cmd_mod=mysqli_query($link_db,$str_mod);
    $num=mysqli_num_rows($cmd_mod);
    if($num==0){
      $str_prods="INSERT INTO `p_b_main_5G`(`5GID`, `MODELNAME`, `MODELCODE`,`LANG`,`STATUS`) value (".$posMXCount.",'CBU','".$SEL_PMODEL."','en-US','0')";
      $cmd_prods=mysqli_query($link_db,$str_prods);
    }
  }else if(intval($_POST['PT1'])==116){
    $str_skuu="INSERT INTO `product_skus`(`Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE`, `Host_IF`, `Conn_Type`, `Conn_Qty`, `UPCcode`, `FAN`, `IS_EOL`, `Web_Disable`, `GUID`, `crea_d`, `crea_u`, `upd_d`, `slang`, `SKU_CategorySort`, `SKU_Type`, `MODELDESCRIPT`, `COMPARE`, `REQUEST_QUOTE`) VALUES ($MCount,$PT1,'$SKU_value','$SEL_PMODEL','$SEL_Host_IF','$SEL_C_Type','$SEL_C_Qty','$UPC_value','',$specEOL,$SEL_SKU_S,'$guid','$now','1782','$now','$str_lang','$SPECC_Sort_tr','$SPECTP_str','$note01','$compareBox','$quoteBox')";
    $str_con_skus="INSERT INTO `contents_product_skus`(`Product_SContents_Auto_ID`, `CategoryModuID`, `ProductTypeID`, `SKU`, `MODELCODE`, `STATUS`, `slang`, `crea_d`, `crea_u`, `ProductTypeID_SKU`, `MODELDESCRIPT`) VALUES ($MCount,0,55,'$SKU_value','$SEL_PMODEL',$SEL_SKU_S,'$str_lang','$now','1782',$PT1,'$note01')";
    $str_mod="select `IntelDSGID` FROM `p_b_main_IntelDSG` WHERE `MODELCODE`='$SEL_PMODEL' order by `IntelDSGID` desc";
    $cmd_mod=mysqli_query($link_db,$str_mod);
    $num=mysqli_num_rows($cmd_mod);
    if($num==0){
      $str_prods="INSERT INTO `p_b_main_IntelDSG`(`IntelDSGID`, `MODELNAME`, `MODELCODE`,`LANG`,`STATUS`) value (".$DSGMXCount.",'CBU','".$SEL_PMODEL."','en-US','0')";
      $cmd_prods=mysqli_query($link_db,$str_prods);
    }
  }

}

$cmd_skuu=mysqli_query($link_db,$str_skuu);
$cmd_con_skus=mysqli_query($link_db,$str_con_skus);
//$cmd_prods=mysqli_query($link_db,$str_prods);
$New_MCount=$MCount;

foreach($_POST['aspectype'] as $check_type) {

  $str_check=$check_type."|";

  /* 預先寫入 SPECTypeID Start */
  $str_sp0="insert into specvalues (`Product_SKU_Auto_ID`,`SPECTypeID`,`SPECValue`,`crea_d`,`crea_u`) values ($New_MCount,$check_type,'','$now','1782');";
  $cmd_sp0=mysqli_query($link_db,$str_sp0);
  /* End */

  foreach($_POST['aspecoption'] as $check_option) {      
    if(preg_match("/".$check_option."/i",$str_check)!=''){
      $str_result = strtr($check_option,$str_check,'');
      $str_re=str_replace($check_type."|","",$str_result.",");

      $str_specvalues="select Product_SKU_Auto_ID,SPECTypeID from `specvalues` where SPECTypeID=".$check_type." and Product_SKU_Auto_ID=".$New_MCount;
      $specvalues_cmd=mysqli_query($link_db,$str_specvalues);
      $record_specvalues=mysqli_fetch_row($specvalues_cmd);
      if(empty($record_specvalues)):
        $str_sp="insert into `specvalues` (`Product_SKU_Auto_ID`,`SPECTypeID`,`SPECValue`,`crea_d`,`crea_u`) values ($New_MCount,$check_type,'$str_re','$now','1782');";
      $cmd_sp=mysqli_query($link_db,$str_sp);     
      else:        
        $str_sp1="update `specvalues` set `SPECValue`=concat(`SPECValue`,'".$str_re."') where SPECTypeID=".$check_type." and Product_SKU_Auto_ID=".$New_MCount.";";
      $cmd_sp1=mysqli_query($link_db,$str_sp1);                
      endif;		

      $str_set="update specoptions set IsShow=''";
      $cmd_set=mysqli_query($link_db,$str_set);
      $Save_State="ok";        
    }      

  }
}

/*清除所有Cookies*/
foreach($_COOKIE as $key=>$value)
{ 
  setCookie($key,"",time()-60);
}  

//***** 2022.06.08 add ******
$sel_partner="SELECT * FROM partner_model WHERE SKU='".$SKU_value."'";
$cmd_partner=mysqli_query($link_db,$sel_partner);
$data_partner=mysqli_fetch_row($cmd_partner);
if($data_partner[0]!=""){
  $str_partner_model="UPDATE partner_model SET `SKU`='".$SKU_value."',`Model`='".$SEL_PMODEL."', U_DATE='".$now."', Import_BE='1' WHERE ID='".$data_partner[0]."'";
  if(mysqli_query($link_db,$str_partner_model)){

  }else{
    echo "<script>alert('partner_model Error (edit->update');self.location='default.php';</script>";
    exit();
  }
}else{
  $str_partner_model="INSERT INTO partner_model(ProductType, SKU, Model, Import_BE, C_DATE) VALUES ('".$PT1."', '".$edit_SKU."', '".$SEL_PMODEL."', '1', '".$now."')";
  if(mysqli_query($link_db,$str_partner_model)){

  }else{
    echo "<script>alert('partner_model Error (edit->insert)');self.location='default.php';</script>";
    exit();
  }
}

//***** 2022.06.08 add end ******

echo "<script>alert('Add Spec ok!');self.location='default.php';</script>";
exit;
}
} 

if(isset($_REQUEST['kinds'])=='Categroies_set'){
  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
  mysqli_query($link_db,'SET NAMES utf8');
  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
  //$select=mysqli_select_db($dataBase, $link_db);

  $svalue=intval($_REQUEST['SPECCate_cid']);
  $sChk=trim($_REQUEST['SPECCate_Chk']);

  if($sChk=='true'){
    $sChk=1;
  }else if($sChk=='false'){
    $sChk='';
  }

  $str_c="update speccategroies set IsShow='".$sChk."' where SPECCategoryID=".$svalue;
  $Cresult=mysqli_query($link_db,$str_c);
  echo "<script>alert('Set SPECCategroies be ok !');</script>";
  mysqli_close($link_db);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
  <HEAD>
    <META http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <TITLE>SPEC Creation Tool - Add a SPEC</TITLE>
    <LINK rel="stylesheet" type="text/css" href="../backend.css">
      <script type="text/javascript" src="../lib/jquery-1.7.2.min.js"></script>
      <script type="text/javascript" src="../lib/jquery.mousewheel-3.0.6.pack.js"></script>
      <script type="text/javascript" src="../source/jquery.fancybox.js?v=2.0.6"></script>
      <LINK rel="stylesheet" type="text/css" href="../source/jquery.fancybox.css?v=2.0.6" media="screen" />
      <LINK rel="stylesheet" type="text/css" href="../source/helpers/jquery.fancybox-buttons.css?v=1.0.2" />
      <script type="text/javascript" src="../source/helpers/jquery.fancybox-buttons.js?v=1.0.2"></script>
      <script type="text/javascript" src="../lib/hide_show.js"></script>
      <script type="text/javascript" src="jquery.cookie.js"></script>

      <script type="text/javascript">
      $(function() {  
        $("#SEL_PMODEL").change(function() {
          if($(this).val()=="Add"){
            $("#model_add01").show();
          }else{
            $("#model_add01").hide();
          }
        });
        $("#SEL_PMT003").change(function() {
          if($(this).val()=="Add"){
            $("#PMT_Show03").show();
          }else{
            if($("#SEL_PMT003").find("option:selected").text()=='-- Select --'){
              document.getElementById('alink_3').innerHTML="Add";
            }else{
              document.getElementById('alink_3').innerHTML=$("#SEL_PMT003").find("option:selected").text();
            }
            $("#PMT_Show03").hide();
          }
        });

        $("#SEL_PMT004").change(function() {
          if($(this).val()=="Add"){
            $("#PMT_Show04").show();
          }else{
            if($("#SEL_PMT004").find("option:selected").text()=='-- Select --'){
              document.getElementById('alink_4').innerHTML="Add";
            }else{
              document.getElementById('alink_4').innerHTML=$("#SEL_PMT004").find("option:selected").text();
            }
            $("#PMT_Show04").hide();
          }
        });

        $("#SEL_PMT005").change(function() {
          if($(this).val()=="Add"){
            $("#PMT_Show05").show();
          }else{
            if($("#SEL_PMT005").find("option:selected").text()=='-- Select --'){
              document.getElementById('alink_5').innerHTML="Add";
            }else{
              document.getElementById('alink_5').innerHTML=$("#SEL_PMT005").find("option:selected").text();
            }
            $("#PMT_Show05").hide();
          }
        });

        $("#SEL_PMT006").change(function() {
          if($(this).val()=="Add"){
            $("#PMT_Show06").show();
          }else{
            if($("#SEL_PMT006").find("option:selected").text()=='-- Select --'){
              document.getElementById('alink_6').innerHTML="Add";
            }else{
              document.getElementById('alink_6').innerHTML=$("#SEL_PMT006").find("option:selected").text();
            }
            $("#PMT_Show06").hide();
          }
        });

        $("#SEL_PMT007").change(function() {
          if($(this).val()=="Add"){
            $("#PMT_Show07").show();
          }else{
            if($("#SEL_PMT007").find("option:selected").text()=='-- Select --'){
              document.getElementById('alink_7').innerHTML="Add";
            }else{
              document.getElementById('alink_7').innerHTML=$("#SEL_PMT007").find("option:selected").text();
            }
            $("#PMT_Show07").hide();
          }
        });

        $("#SEL_PMT008").change(function() {
          if($(this).val()=="Add"){
            $("#PMT_Show08").show();
          }else{
            if($("#SEL_PMT008").find("option:selected").text()=='-- Select --'){
              document.getElementById('alink_8').innerHTML="Add";
            }else{
              document.getElementById('alink_8').innerHTML=$("#SEL_PMT008").find("option:selected").text();
            }
            $("#PMT_Show08").hide();
          }
        });

        $("#SEL_PMT009").change(function() {
          if($(this).val()=="Add"){
            $("#PMT_Show09").show();
          }else{
            if($("#SEL_PMT009").find("option:selected").text()=='-- Select --'){
              document.getElementById('alink_9').innerHTML="Add";
            }else{
              document.getElementById('alink_9').innerHTML=$("#SEL_PMT009").find("option:selected").text();
            }
            $("#PMT_Show09").hide();
          }
        });

        $("#SEL_PMT010").change(function() {
          if($(this).val()=="Add"){
            $("#PMT_Show10").show();
          }else{
            if($("#SEL_PMT010").find("option:selected").text()=='-- Select --'){
              document.getElementById('alink_10').innerHTML="Add";
            }else{
              document.getElementById('alink_10').innerHTML=$("#SEL_PMT010").find("option:selected").text();
            }
            $("#PMT_Show10").hide();
          }
        });

        $("#SEL_PMT011").change(function() {
          if($(this).val()=="Add"){
            $("#PMT_Show11").show();
          }else{
            if($("#SEL_PMT011").find("option:selected").text()=='-- Select --'){
              document.getElementById('alink_11').innerHTML="Add";
            }else{
              document.getElementById('alink_11').innerHTML=$("#SEL_PMT011").find("option:selected").text();
            }
            $("#PMT_Show11").hide();
          }
        });

        $("#SEL_PMT012").change(function() {
          if($(this).val()=="Add"){
            $("#PMT_Show12").show();
          }else{
            if($("#SEL_PMT012").find("option:selected").text()=='-- Select --'){
              document.getElementById('alink_12').innerHTML="Add";
            }else{
              document.getElementById('alink_12').innerHTML=$("#SEL_PMT012").find("option:selected").text();
            }
            $("#PMT_Show12").hide();
          }
        });

        $("#SEL_PMT013").change(function() {
          if($(this).val()=="Add"){
            $("#PMT_Show13").show();
          }else{
            if($("#SEL_PMT013").find("option:selected").text()=='-- Select --'){
              document.getElementById('alink_13').innerHTML="Add";
            }else{
              document.getElementById('alink_13').innerHTML=$("#SEL_PMT013").find("option:selected").text();
            }
            $("#PMT_Show13").hide();
          }
        });

        $("#SEL_PMT014").change(function() {
          if($(this).val()=="Add"){
            $("#PMT_Show14").show();
          }else{
            if($("#SEL_PMT014").find("option:selected").text()=='-- Select --'){
              document.getElementById('alink_14').innerHTML="Add";
            }else{
              document.getElementById('alink_14').innerHTML=$("#SEL_PMT014").find("option:selected").text();
            }
            $("#PMT_Show14").hide();
          }
        });

        $("#SEL_PMT015").change(function() {
          if($(this).val()=="Add"){
            $("#PMT_Show15").show();
          }else{
            if($("#SEL_PMT015").find("option:selected").text()=='-- Select --'){
              document.getElementById('alink_15').innerHTML="Add";
            }else{
              document.getElementById('alink_15').innerHTML=$("#SEL_PMT015").find("option:selected").text();
            }
            $("#PMT_Show15").hide();
          }
        });

        $("#SEL_PMT016").change(function() {
          if($(this).val()=="Add"){
            $("#PMT_Show16").show();
          }else{
            if($("#SEL_PMT016").find("option:selected").text()=='-- Select --'){
              document.getElementById('alink_16').innerHTML="Add";
            }else{
              document.getElementById('alink_16').innerHTML=$("#SEL_PMT016").find("option:selected").text();
            }
            $("#PMT_Show16").hide();
          }
        });

        $("#SEL_PMT017").change(function() {
          if($(this).val()=="Add"){
            $("#PMT_Show17").show();
          }else{
            if($("#SEL_PMT017").find("option:selected").text()=='-- Select --'){
              document.getElementById('alink_17').innerHTML="Add";
            }else{
              document.getElementById('alink_17').innerHTML=$("#SEL_PMT017").find("option:selected").text();
            }
            $("#PMT_Show17").hide();
          }
        });

        $("#SEL_PMT018").change(function() {
          if($(this).val()=="Add"){
            $("#PMT_Show18").show();
          }else{
            if($("#SEL_PMT018").find("option:selected").text()=='-- Select --'){
              document.getElementById('alink_18').innerHTML="Add";
            }else{
              document.getElementById('alink_18').innerHTML=$("#SEL_PMT018").find("option:selected").text();
            }
            $("#PMT_Show18").hide();
          }
        });

        $("#SEL_PMT019").change(function() {
          if($(this).val()=="Add"){
            $("#PMT_Show19").show();
          }else{
            if($("#SEL_PMT019").find("option:selected").text()=='-- Select --'){
              document.getElementById('alink_19').innerHTML="Add";
            }else{
              document.getElementById('alink_19').innerHTML=$("#SEL_PMT019").find("option:selected").text();
            }
            $("#PMT_Show19").hide();
          }
        });


      });
</script>
<script type="text/javascript">
$(function() {
//var i;
//for(i=1;i<4;i++){

  $("#SEL_PN1").change(function() {
    if($(this).val()=="Add"){
      $("#SKUPN_add1").show();
      $("#SSMN1_1").val("");
    }else{
      $("#SKUPN_add1").hide();
    }
  });

  $("#SEL_PN2").change(function() {
    if($(this).val()=="Add"){
      $("#SKUPN_add2").show();
      $("#SSMN1_2").val("");	
    }else{
      $("#SKUPN_add2").hide();
    }
  });

  $("#SEL_PN3").change(function() {
    if($(this).val()=="Add"){
      $("#SKUPN_add3").show();
      $("#SSMN1_3").val("");
    }else{
      $("#SKUPN_add3").hide();
    }
  });

  $("#SEL_PN4").change(function() {
    if($(this).val()=="Add"){
      $("#SKUPN_add4").show();
      $("#SSMN1_4").val("");
    }else{
      $("#SKUPN_add4").hide();
    }
  });

  $("#SEL_PN5").change(function() {
    if($(this).val()=="Add"){
      $("#SKUPN_add5").show();
      $("#SSMN1_5").val("");
    }else{
      $("#SKUPN_add5").hide();
    }
  });

  $("#SEL_PN6").change(function() {
    if($(this).val()=="Add"){
      $("#SKUPN_add6").show();
      $("#SSMN1_6").val("");
    }else{
      $("#SKUPN_add6").hide();
    }
  });

  $("#SEL_PN7").change(function() {
    if($(this).val()=="Add"){
      $("#SKUPN_add7").show();
      $("#SSMN1_7").val("");
    }else{
      $("#SKUPN_add7").hide();
    }
  });

  $("#SEL_PN8").change(function() {
    if($(this).val()=="Add"){
      $("#SKUPN_add8").show();
      $("#SSMN1_8").val("");
    }else{
      $("#SKUPN_add8").hide();
    }
  });

  $("#SEL_PN9").change(function() {
    if($(this).val()=="Add"){
      $("#SKUPN_add9").show();
      $("#SSMN1_9").val("");
    }else{
      $("#SKUPN_add9").hide();
    }
  });

//}
});
</script>

<script>
$(function() {

  $("#SSMNBtn1").click(function() {
    var params = $('input').serialize();
    var url = "add_SubSKU.php";

    $.ajax({
      type: "post",
      url: url,
      dataType: "html",
      data: params,
      success: function(data){	
        if(data == "refresh_sub"){
          window.location.reload(true);
        }
        else{
          $("#SubSKUs_MGT1").html(data);
        }
      }
    });
  });  

  $("#SSMNBtn2").click(function() {
    var params = $('input').serialize();
    var url = "add_SubSKU.php";

    $.ajax({
      type: "post",
      url: url,
      dataType: "html",
      data: params,
      success: function(data){
        if(data == "refresh_sub"){
          setTimeout(function(){ window.location.reload(true); }, 2000);    
        }
        else{
          $("#SubSKUs_MGT2").html(data);
        }
      }
    });
  });

  $("#SSMNBtn3").click(function() {
    var params = $('input').serialize();
    var url = "add_SubSKU.php";

    $.ajax({
      type: "post",
      url: url,
      dataType: "html",
      data: params,
      success: function(data){
        if(data == "refresh_sub"){
          window.location.reload(true);
        }
        else{
          $("#SubSKUs_MGT3").html(data);
        }
      }
    });
  });

  $("#SSMNBtn4").click(function() {
    var params = $('input').serialize();
    var url = "add_SubSKU.php";

    $.ajax({
      type: "post",
      url: url,
      dataType: "html",
      data: params,
      success: function(data){
        if(data == "refresh_sub"){
          window.location.reload(true);
        }
        else{
          $("#SubSKUs_MGT4").html(data);
        }
      }
    });
  });

  $("#SSMNBtn5").click(function() {
    var params = $('input').serialize();
    var url = "add_SubSKU.php";

    $.ajax({
      type: "post",
      url: url,
      dataType: "html",
      data: params,
      success: function(data){
        if(data == "refresh_sub"){
          window.location.reload(true);
        }
        else{
          $("#SubSKUs_MGT5").html(data);
        }
      }
    });
  });

  $("#SSMNBtn6").click(function() {
    var params = $('input').serialize();
    var url = "add_SubSKU.php";

    $.ajax({
      type: "post",
      url: url,
      dataType: "html",
      data: params,
      success: function(data){
        if(data == "refresh_sub"){
          window.location.reload(true);
        }
        else{
          $("#SubSKUs_MGT6").html(data);
        }
      }
    });
  });

  $("#SSMNBtn7").click(function() {
    var params = $('input').serialize();
    var url = "add_SubSKU.php";

    $.ajax({
      type: "post",
      url: url,
      dataType: "html",
      data: params,
      success: function(data){
        if(data == "refresh_sub"){
          window.location.reload(true);
        }
        else{
          $("#SubSKUs_MGT7").html(data);
        }
      }
    });
  });

  $("#SSMNBtn8").click(function() {
    var params = $('input').serialize();
    var url = "add_SubSKU.php";

    $.ajax({
      type: "post",
      url: url,
      dataType: "html",
      data: params,
      success: function(data){
        if(data == "refresh_sub"){
          window.location.reload(true);
        }
        else{
          $("#SubSKUs_MGT8").html(data);
        }
      }
    });
  });

});
</script>

<script type="text/javascript">
$(function() {

  $("#MNBtn").click(function() {  
    var params = $('input').serialize();
    var url = "add_models.php";

    $.ajax({
      type: "post",
      url: url,
      dataType: "html",
      data: params,
      success: function(data){
        if(data == "refresh"){	
          window.location.reload(true);
        }
        else{
          $("#Model_MGT").html(data);
          $("#Model_error").html('');
        }
      }  
    });  
  });

});
</script>
<script type="text/javascript">
$(function() {

  $("#SKU_value").change(function() {
    var params = $('input').serialize();
    var url = "ValiSKU.php";

    $.ajax({
      type: "post",
      url: url,
      dataType: "html",
      data: params,
      success: function(msg){
        $("#divAccount").html(msg);
      }
    });
  });

});
</script>

<script type="text/javascript">
$(document).ready(function() {    

  var t=0;			
  var myVar=setInterval(function(){myTimer()},1000);
  function myTimer()
  {
    t+=1;
    document.getElementById("count_num").innerHTML=t;

    if(t>1800){
      self.location="logo.php";		
    }
  }

/*
*  Simple image gallery. Uses default settings
*/

$('.fancybox').fancybox();

/*
*  Different effects
*/

$("#Fancy_Box01").fancybox({
  'width'				: '75%',
  'height'			: '75%',
  'autoScale'			: false,
  'transitionIn'		: 'none',
  'transitionOut'		: 'none',
  'type'				: 'iframe'
});

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
<LINK rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script language="javascript">
function Add_Matrvalue(n,pid,cid){
  var num;
  var chk_n;
  var str;
  var str_mval;
  var str_sval;
  var str_uval;
  var gset_val;    
  $.cookie("SEL_PMODEL01", $("#SEL_PMODEL").find("option:selected").val(), { expires: 1 });
  $.cookie("SKU_value01", $("#SKU_value").val(), { expires: 1 });	
  $.cookie("UPC_value01", $("#UPC_value").val(), { expires: 1 });

  if($("#SEL_PN1").length>0){
    $.cookie("SEL_PN1", $("#SEL_PN1").find("option:selected").val(), { expires: 1 });
  }
  if($("#SEL_PN2").length>0){
    $.cookie("SEL_PN2", $("#SEL_PN2").find("option:selected").val(), { expires: 1 });
  }
  if($("#SEL_PN3").length>0){
    $.cookie("SEL_PN3", $("#SEL_PN3").find("option:selected").val(), { expires: 1 });
  }
  if($("#SEL_PN4").length>0){
    $.cookie("SEL_PN4", $("#SEL_PN4").find("option:selected").val(), { expires: 1 });
  }
  if($("#SEL_PN5").length>0){
    $.cookie("SEL_PN5", $("#SEL_PN5").find("option:selected").val(), { expires: 1 });
  }
  if($("#SEL_PN6").length>0){
    $.cookie("SEL_PN6", $("#SEL_PN6").find("option:selected").val(), { expires: 1 });
  }
  if($("#SEL_PN7").length>0){
    $.cookie("SEL_PN7", $("#SEL_PN7").find("option:selected").val(), { expires: 1 });
  }
  if($("#SEL_PN8").length>0){
    $.cookie("SEL_PN8", $("#SEL_PN8").find("option:selected").val(), { expires: 1 });
  }
  if($("#SEL_PN9").length>0){
    $.cookie("SEL_PN9", $("#SEL_PN9").find("option:selected").val(), { expires: 1 });
  }
  if($("#SEL_PN10").length>0){
    $.cookie("SEL_PN10", $("#SEL_PN10").find("option:selected").val(), { expires: 1 });
  }
  ns=n.toString();

  if(pid==101||pid==102){
    str_uval_total=17;
  }else if(pid==103||pid==104){
    str_uval_total=20;
  }else if(pid==0106){
    str_uval_total=16;
  }

  for(str_uval=3;str_uval<str_uval_total;str_uval++){
    if(ns==str_uval){

      str_si=str_uval.toString();
      if(str_si.length>1){
        $.cookie("c_seVal"+str_si, $("#PMS_"+str_si+"").val(), { expires: 1 });
      }else{
        chk_ss="0"+str_si;
        $.cookie("c_seVal"+chk_ss, $("#PMS_"+chk_ss+"").val(), { expires: 1 });
      }

    }else{       
      str_i=str_uval.toString();
      if(str_i.length>1){
        $.cookie("c_seVal"+str_i, $("#SEL_PMT0"+str_i+"").find("option:selected").text(), { expires: 1 });
      }else{
        chk_s="0"+str_i;
        $.cookie("c_seVal"+chk_s, $("#SEL_PMT0"+chk_s+"").find("option:selected").text(), { expires: 1 });
      }        
    }
  }

  if(ns.length>1){
    str=$("#PMS_"+ns).val();    
  }else{
    chk_n="0"+ns;
    str=$("#PMS_"+chk_n+"").val();
  }

  str_cate=$("#SEL_PMatrix").val();

  switch(n){ 
    case 3:
    if(pid==101||pid==102){
      str_mval=1;
      str_sval="";
    }else if(pid==103||pid==104){
      str_mval=9;
      str_sval="H";
    }else if(pid==0106){
      str_mval=1;
      str_sval="";
    }
    break;
    case 4:
    if(pid==101||pid==102){
      str_mval=2;
      str_sval="";
    }else if(pid==103||pid==104){
      str_mval=9;
      str_sval="W";
    }else if(pid==0106){
      str_mval=9;
      str_sval="W";
    }
    break;
    case 5:
    if(pid==101||pid==102){
      str_mval=3;
      str_sval="";
    }else if(pid==103||pid==104){
      str_mval=9;
      str_sval="D";
    }else if(pid==0106){
      str_mval=9;
      str_sval="D";
    }
    break;
    case 6:
    if(pid==101||pid==102){
      str_mval=4;
      str_sval="PCI-X";
    }else if(pid==103||pid==104){
      str_mval=10;
      str_sval="";
    }else if(pid==0106){
      str_mval=3;
      str_sval="";
    }
    break;
    case 7:
    if(pid==101||pid==102){
      str_mval=4;
      str_sval="PCI";
    }else if(pid==103||pid==104){
      str_mval=11;
      str_sval="";
    }else if(pid==0106){
      str_mval=14;
      str_sval="";
    }
    break;
    case 8:
    if(pid==101||pid==102){
      str_mval=4;
      str_sval="PCIe";
    }else if(pid==103||pid==104){
      str_mval=5;
      str_sval="Max.";
    }else if(pid==0106){
      str_mval=15;
      str_sval="";
    }
    break;
    case 9:
    if(pid==101||pid==102){
      str_mval=5;
      str_sval="Max.";
    }else if(pid==103||pid==104){
      str_mval=5;
      str_sval="Type";
    }else if(pid==0106){
      str_mval=16;
      str_sval="Int. Port";
    }
    break;
    case 10:
    if(pid==101||pid==102){
      str_mval=5;
      str_sval="Type";
    }else if(pid==103||pid==104){
      str_mval=12;
      str_sval="Max.";
    }else if(pid==0106){
      str_mval=16;
      str_sval="Ext. Port (X)";
    }
    break;
    case 11:
    if(pid==101||pid==102){
      str_mval=6;
      str_sval="Audio (A)";
    }else if(pid==103||pid==104){
      str_mval=12;
      str_sval="Type";
    }else if(pid==0106){
      str_mval=6;
      str_sval="S/W RAID (SR)";
    }
    break;
    case 12:
    if(pid==101||pid==102){
      str_mval=6;
      str_sval="Video (G)";
    }else if(pid==103||pid==104){
      str_mval=12;
      str_sval="H/F";
    }else if(pid==0106){
      str_mval=6;
      str_sval="H/W RAID (HR)";
    }
    break;
    case 13:
    if(pid==101||pid==102){
      str_mval=6;
      str_sval="LAN (N)";
    }else if(pid==103||pid==104){
      str_mval=13;
      str_sval="GbE";
    }else if(pid==0106){
      str_mval=6;
      str_sval="Enhanced RAID (E)";
    }
    break;
    case 14:
    if(pid==101||pid==102){
      str_mval=6;
      str_sval="RAID (R)";
    }else if(pid==103||pid==104){
      str_mval=13;
      str_sval="10GbE";
    }else if(pid==0106){
      str_mval=17;
      str_sval="";
    }
    break;
    case 15:
    if(pid==101||pid==102){
      str_mval=7;
      str_sval="Server Mgmt.";
    }else if(pid==103||pid==104){
      str_mval=4;
      str_sval="PCI-X";
    }else if(pid==0106){
      str_mval=8;
      str_sval="RoHS (Type)";
    }
    break;
    case 16:
    if(pid==101||pid==102){
      str_mval=8;
      str_sval="RoHS (Type)";
    }else if(pid==103||pid==104){
      str_mval=4;
      str_sval="PCI";
    }
    break;
    case 17:
    if(pid==103||pid==104){
      str_mval=4;
      str_sval="PCIe";
    }
    break;
    case 18:
    if(pid==103||pid==104){
      str_mval=7;
      str_sval="Server Mgmt.";
    }
    break;
    case 19:
    if(pid==103||pid==104){
      str_mval=8;
      str_sval="RoHS (Type)";
    }
    break;
  }

  pms_num=n-2;	
  self.location = "?Mart_type=Add&str_val1=" + str + "&str_val2=" + str_mval + "&str_val3=" + str_sval + "&str_val4=" + pms_num + "&str_val6=" + str_cate + "&PType_id=" + pid + "&PCate_id=" + cid;
//alert(str_mval+'\n'+str_sval);  
return false;
}
</script>
<script language="JavaScript">
<?php
for($P=1;$P<18;$P++){
  if(strlen($P)>1){
    $P=$P;
  }else{
    $P="0".$P;
  }
  ?>
  function show_PMA<?=$P?>(ovalue){
    var s_value='<?=$P?>';
    var len=ovalue.length
    if(len>1){
      ovalue=ovalue;
    }else{
      ovalue="0"+ovalue;
    }
    $("#PMA_ADD"+s_value).show();
    single_SW(s_value);
  }
  function Close_PMA<?=$P?>(){
    var s_value='<?=$P?>';
    $("#PMA_ADD"+s_value+"").hide();
  }
  <?php
}
?>

function single_SW(num){  
  var ck;
  for(ck=1;ck<18;ck++){    
cks=ck.toString(); //數字轉字串
if(cks.length>1){
  cks=cks;
}else{
  cks="0"+cks;
}
if(num==cks){    
}else{
  $("#PMA_ADD"+cks+"").hide();
}

}
}

function Add_Finish(){
  $("#submitbutton01").prop('disabled', true);
  $("#Previewbutton01").prop('disabled', false);
  $("#pdfbutton01").prop('disabled', false);
}
function MM_o(selObj){
  window.open(document.getElementById('SEL_PTYPE').options[document.getElementById('SEL_PTYPE').selectedIndex].value,"_self");
}

</script>

<script type="text/javascript">
function StimeOut(){
}

function Reset_AddSpec(){
  self.location='add_spec.php';
}
</script>
<script>
<!--
function check_id(speca_id,speca_name,icount)
{

  if(confirm("確定要設定 此 Category 在 " + speca_name + " SPEC 的顯示或關閉嗎？")) {
    var checkItem = document.getElementsByName("checkall");
    self.location="?kinds=Categroies_set&SPECCate_cid="+speca_id+"&SPECCate_Chk="+checkItem[icount-1].checked;
  } 
  else {
    alert("取消操作!");
  }

}
//-->
</script>
<script language="JavaScript">
function SPEC_Check( ) {

  if(document.form1.SEL_PTYPE.value == "") {
    $("#PTYPE_error").html('<span class="w12red">(Required select a product type. )</span>');
    document.form1.SEL_PTYPE.focus();
    return false;
  }

  if(document.form1.PT1.value == "") {
    alert("Required select a product type.");
    document.form1.PT1.focus();
    return false;
  }

  if(document.form1.SEL_PMODEL.value == "" || document.form1.SEL_PMODEL.value == "Add") {
    $("#Model_MGT").html('');
    $("#Model_error").html('<span class="w12red">(Required selection or create a model. )</span>');
    document.form1.SEL_PMODEL.focus();
    return false;
  }

  if(document.form1.SKU_value.value == "") {
    $("#Model_error").html('');
    $("#SKU_error").html('<span class="w12red">(Required field. )</span>');
    document.form1.SKU_value.focus();
    return false;
  }

/*if(document.form1.SEL_PMatrix.value == "") {
alert("Please select a Matrix Category.");
document.form1.SEL_PMatrix.focus();
return false;
}*/
return true;
}


function Set_Cookies_values(){
  var str_u;
  var gset_val;
  if($.cookie("SEL_PMODEL01")!=null){
    document.getElementById("SEL_PMODEL").value=$.cookie("SEL_PMODEL01");
  }

  if($.cookie("SKU_value01")!=null){
    document.getElementById("SKU_value").value=$.cookie("SKU_value01");
  }
  if($.cookie("UPC_value01")!=null){
    document.getElementById("UPC_value").value=$.cookie("UPC_value01");
  }
  if($("#SEL_PN1").length>0 && $.cookie("SEL_PN1")!=null){
    document.getElementById("SEL_PN1").value=$.cookie("SEL_PN1");
  }
  if($("#SEL_PN2").length>0 && $.cookie("SEL_PN2")!=null){
    document.getElementById("SEL_PN2").value=$.cookie("SEL_PN2");
  }
  if($("#SEL_PN3").length>0 && $.cookie("SEL_PN3")!=null){
    document.getElementById("SEL_PN3").value=$.cookie("SEL_PN3");
  }
  if($("#SEL_PN4").length>0 && $.cookie("SEL_PN4")!=null){
    document.getElementById("SEL_PN4").value=$.cookie("SEL_PN4");
  }
  if($("#SEL_PN5").length>0 && $.cookie("SEL_PN5")!=null){
    document.getElementById("SEL_PN5").value=$.cookie("SEL_PN5");
  }
  if($("#SEL_PN6").length>0 && $.cookie("SEL_PN6")!=null){
    document.getElementById("SEL_PN6").value=$.cookie("SEL_PN6");
  }
  if($("#SEL_PN7").length>0 && $.cookie("SEL_PN7")!=null){
    document.getElementById("SEL_PN7").value=$.cookie("SEL_PN7");
  }
  if($("#SEL_PN8").length>0 && $.cookie("SEL_PN8")!=null){
    document.getElementById("SEL_PN8").value=$.cookie("SEL_PN8");
  }
  if($("#SEL_PN9").length>0 && $.cookie("SEL_PN9")!=null){
    document.getElementById("SEL_PN9").value=$.cookie("SEL_PN9");
  }
  if($("#SEL_PN10").length>0 && $.cookie("SEL_PN10")!=null){
    document.getElementById("SEL_PN10").value=$.cookie("SEL_PN10");  
  }

  for(str_u=3;str_u<20;str_u++){    
    str_u1=str_u.toString();
    if(str_u1.length>1){

      var str_checked =$.cookie("c_seVal"+str_u1);

      for(i=0;i<document.getElementById('SEL_PMT0'+str_u1).length;i++)
      {
        if(document.getElementById('SEL_PMT0'+str_u1).options[i].text==str_checked)
        {
          document.getElementById('SEL_PMT0'+str_u1).selectedIndex=i;

          if(str_checked != "-- Select --"){
            document.getElementById('alink_'+str_u1).innerHTML=str_checked;
          }

        }
      }

    }else{
      ch_k="0"+str_u1;
      var str_s =$.cookie("c_seVal"+ch_k);

      for(ii=0;ii<document.getElementById('SEL_PMT0'+ch_k).length;ii++)
      {
        if(document.getElementById('SEL_PMT0'+ch_k).options[ii].text==str_s)
        {
          document.getElementById('SEL_PMT0'+ch_k).selectedIndex=ii;
          
          if(str_s != "-- Select --"){
            document.getElementById('alink_'+str_u1).innerHTML=str_s;
          }
          
        }
      }

    }    

  }

}
</script>
<!-- Cookies -->
<script>
function s_cookies(){
  var model = document.getElementById('SEL_PMODEL').value;
  var sku = document.getElementById('SKU_value').value;
  var upc = document.getElementById('UPC_value').value;
  var d = new Date();
  d.setTime(d.getTime() + (1800 * 1000)); //30分鐘
  var expires = "expires=" + d.toGMTString();
  //document.cookie = "status=1" + "; " + expires + '; domain=blog.longwin.com.tw; path=/';
  document.cookie = "cmodel="+ model + "; " + expires + ';';
  document.cookie = "csku="+ sku + "; " + expires + ';';
  document.cookie = "cupc="+ upc + "; " + expires + ';';
}
</script>
<!-- Cookies end -->
</HEAD>
<!-- 
oncontextmenu="window.event.returnValue=false" 
onkeypress="window.event.returnValue=true" 
onkeydown="window.event.returnValue=true" 
onkeyup="window.event.returnValue=false" 
ondragstart="window.event.returnValue=false" 
onselectstart="event.returnValue=false"
-->
<BODY>
  <A name="top"></A>
  <DIV >
    <DIV class="left"><H1>&nbsp;&nbsp;Website Backends - SPEC Creation Tool</H1></DIV>

    <DIV id="logout">Hi <b>
      <?php
      echo str_replace('@mic.com.tw', '', $_SESSION['user']);
      ?></b> <A href="logo.php">Log out &gt;&gt;</A> Log out seconds <span id="count_num" style="background-color: yellow;">0</span> <br /><font color="red">* Setup:1800 sec</font></DIV>
    </DIV>

    <DIV class="clear"></DIV>
    <?php
    include("./menu.php");
    ?>
    <DIV class="clear"></DIV>
    <?php
    if(isset($_REQUEST['PCate_id'])!=''){
      $PCate_id=intval($_REQUEST['PCate_id']);
    }else{
      $PCate_id="0";
    }
    ?>
    <DIV id="Search" >
      <H2><A href="default.php" >Product SPEC</A>&nbsp;&gt;&nbsp; Add a SPEC </H2> 
    </DIV>

    <DIV id="content">
      <BR />
      <H3> Basic Settings:</H3>
      <HR class="style-four" />
      <P class="clear"></P>
      <FORM id="form1" name="form1" method="post" action="?methods=insert_spec" onsubmit="return SPEC_Check();">
        <table class="addspec">
          <TR><TH>Product Type:</TH>
            <TD>
              <P>
                <SELECT id="SEL_PTYPE" name="SEL_PTYPE" onChange="MM_o(this)">
                  <OPTION value="">Select...</OPTION>
                  <?php
                  if(isset($_REQUEST['PType_id'])!=''){
                    $PType_id01=intval($_REQUEST['PType_id']);
                  }else{
                    $PType_id01="";
                  }

                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_type="select b.ProductTypeID,a.ProductCateID,a.ProductCateName from productcategories a inner join producttypes b on a.ProductCateName=b.ProductTypeName";
                  $type_result=mysqli_query($link_db,$str_type);
                  while(list($ProductTypeID,$ProductCateID,$ProductCateName)=mysqli_fetch_row($type_result))
                  {
                    ?>
                    <OPTION value="add_spec.php?PCate_id=<?=$ProductCateID?>&PType_id=<?=$ProductTypeID?>&get_cookies=Yes" <?php if($PType_id01==$ProductTypeID){ echo "selected"; }?> ><?=$ProductCateName?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT><INPUT type="hidden" id="PT1" name="PT1" value="<?=$PType_id01;?>">&nbsp;<DIV id="PTYPE_error"></DIV>
              </P>
            </TD>
          </TR>

          <TR style="background:#fcd2e4">
            <TH>Model:</TH>
            <TD>
              <div style="color:#c00; font-weight:bold">(** Be sure to add/edit after finishing "SPEC Settings".) </div>
              <SELECT id="SEL_PMODEL" name="SEL_PMODEL">
                <OPTION selected="selected" value="">Select from extisting: </OPTION>
                <?php
                if(isset($_REQUEST['PCate_id'])<>''){
                  ?>
                  <OPTION value="Add">Add New</OPTION>
                  <?php
                }

                $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                mysqli_query($link_db,'SET NAMES utf8');
                mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                //$select=mysqli_select_db($dataBase, $link_db);
                $str_model="select ModelCode from product_models where ProductCateID=".$PCate_id." order by ModelCode";
                $Model_result=mysqli_query($link_db,$str_model);
                while(list($ModelCode)=mysqli_fetch_row($Model_result)){
                  ?>
                  <OPTION value="<?=$ModelCode;?>" <?php if(isset($_COOKIE["cmodel"])==$ModelCode){ echo "selected"; } ?>><?=$ModelCode;?></OPTION>
                  <?php
                }
                mysqli_close($link_db);
                ?>
              </SELECT>&nbsp;&nbsp;&nbsp;&nbsp; <DIV id="model_add01" style="display:none">Model Name: <INPUT type="text" name="MN_01" size="20" value=""> Model Code: <INPUT type="text" name="MN_02" size="20"> <INPUT type="hidden" name="MN_03" value="<?=$PCate_id?>"><INPUT id="MNBtn" type="button" value="Done" /></DIV><DIV id="Model_MGT"></DIV><DIV id="Model_error"></DIV>
            </TD>
          </TR>  
          <TR style="background:#fcd2e4">
            <TH>SKU:</TH>
            <TD>
              <?php
              if($_COOKIE["csku"]!=""){
                $csku=$_COOKIE["csku"];
              }
              if($_COOKIE["cupc"]!=""){
                $cupc=$_COOKIE["cupc"];
              }

              ?>
              <div style="color:#c00; font-weight:bold">(** Be sure to add/edit after finishing "SPEC Settings".) </div>
              <P><INPUT id="SKU_value" name="SKU_value" type="text" size="30" value="<?=$csku?>" />&nbsp;&nbsp;<DIV id="divAccount"></DIV><DIV id="SKU_error"></DIV></P>
              <P>UPC code: <INPUT id="UPC_value" name="UPC_value" type="text" size="30" value="<?=$cupc?>" /></P>
              <input id="s_cookie" name="s_cookie" type="button" value="Save Cookie" onclick="s_cookies()">
            </TD>
          </TR>

        </TABLE>
        <P>&nbsp;</P><P>&nbsp;</P><P class="clear"></P>
        <?php
        $PType_id="";
        if(isset($_REQUEST['PType_id'])!=""){
          $PType_id=intval($_REQUEST['PType_id']);
          if($PType_id==101 || $PType_id==103){
            $type_style="";
            $type_style_buttom="sub";
            $Cvalues="QPI";
          }else if($PType_id==102 || $PType_id==104){
            $type_style="main_A";
            $type_style_buttom="sub_A";
            $Cvalues="HT";
          }else if($PType_id==0106){
            $type_style="";
            $type_style_buttom="sub";
          }
        }else{
          $PType_id="";
        }
        ?>
        <H3>SPEC Settings:</H3>
        <HR class="style-four" /> 
        <p class="clear"></P>
          <BR />
          <P class="clear"></P>
          <?php
          if($PType_id<>""){
            ?>
            <TABLE class="pro_spec_bk">
              <THEAD>
                <TR>
                  <TH style="width:180px">Categories <A href="Categories_Sortable.php?PT_id=<?=$PType_id?>" class="fancybox fancybox.iframe"> <FONT size="2">(Order)</FONT></A></TH><TH >Types / Options</TH> 
                </TR>
              </THEAD>
              <?php
              $ParentSpec_va_all_Thr="";

              $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
              mysqli_query($link_db,'SET NAMES utf8');
              mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
              mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
              //$select=mysqli_select_db($dataBase, $link_db);
              $str_type_s="select SPECCategories,SPECType,SPECType_Sub from producttypes where ProductTypeID=".$PType_id;
              $type_result_s=mysqli_query($link_db,$str_type_s);
              $data_p=mysqli_fetch_row($type_result_s);
//echo $data_p[0];
              mysqli_close($link_db);

              $data_option_s="";
              $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
              mysqli_query($link_db,'SET NAMES utf8');
              mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
              mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
              //$select=mysqli_select_db($dataBase, $link_db);
              $str_option_s="select distinct SPECTypeID from `specvalues` where SPECValue<>''";
              $option_result_s=mysqli_query($link_db,$str_option_s);
              while($data_opt=mysqli_fetch_row($option_result_s)){

                $data_option_s.=$data_opt[0].",";
              }
              mysqli_close($link_db);
              $data_option_s=strtr($data_option_s,',,',',');


              $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
              mysqli_query($link_db,'SET NAMES utf8');
              mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
              mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
              //$select=mysqli_select_db($dataBase, $link_db);

              if(isset($_COOKIE["categor_cookie".$PType_id.""])!=''){
                $str_Cate="select `SPECCategoryID`,`SPECCategoryName`,`IsShow` from speccategroies where INSTR('".$_COOKIE["categor_cookie".$PType_id.""]."',SPECCategoryID)>0 order by SPECCategorySort";
              }else{
                $str_Cate="select `SPECCategoryID`,`SPECCategoryName`,`IsShow` from speccategroies where SPECCategoryID in (".substr($data_p[0],0,strlen($data_p[0])-1).") order by FIELD(SPECCategoryID, ".substr($data_p[0],0,strlen($data_p[0])-1).")"; 
              }
//echo $str_Cate;
              $Cateresult=mysqli_query($link_db,$str_Cate);
              $ca=0;
              while($data_spec=mysqli_fetch_row($Cateresult)){
                $ca+=1;
                ?>
                <TBODY>
                  <TR>
                    <!--name="CCateg_SPECCategoryID"-->
                    <TD><!--<INPUT name="checkall" type="checkbox" value="<?=$data_spec[0];?>" <?php if($data_spec[2]=='1') echo "checked"; ?> onclick="check_id(<?=$data_spec[0];?>,'<?=$data_spec[1];?>',<?=$i;?>);" />--> <A id="Fancy_Box01" href="lb_categories.php?PType_id=<?=$PType_id;?>"><?=$data_spec[1];?></A></TD>
                    <TD><a href="lb_types.php?SPCC_ID=<?=$data_spec[0];?>&PType_id=<?=$PType_id;?>" class="fancybox fancybox.iframe">[Edit]</a> 
                      <TABLE id="OTypes_show<?=$ca;?>" class="insidetable1">
                        <?php
                        $i1=0;
                        $ParentSpec_va_all="";$SPECTypeID_va_all="";
                        if(isset($_COOKIE["type_cookie".$data_spec[0].""])!=''){	  
                          $str_GetParent="select distinct ParentSpec from spectypes where SPECCategoryID=".$data_spec[0]." and (ParentSpec IS NOT NULL) and INSTR('".$_COOKIE["type_cookie".$data_spec[0].""]."',SPECTypeID)>0";
                          $GetParentresult=mysqli_query($link_db,$str_GetParent);
                          $GetParentresultNum=mysqli_num_rows($GetParentresult);
                          while(list($ParentSpec)=mysqli_fetch_row($GetParentresult)){
                            $ParentSpec_va_all.=$ParentSpec.",";
                          }

                          if($GetParentresultNum>0){
                            $ParentSpec_va_all_Sub=$_COOKIE["type_cookie".$data_spec[0].""];
                          }

                          $str_GetSType="select SPECTypeID as SPECTypeID_va from spectypes where SPECCategoryID=".$data_spec[0]." and (ParentSpec IS NULL) and INSTR('".$_COOKIE["type_cookie".$data_spec[0].""]."',SPECTypeID)>0";
                          $GetSTyperesult=mysqli_query($link_db,$str_GetSType);
                          while(list($SPECTypeID_va)=mysqli_fetch_row($GetSTyperesult)){
                            $SPECTypeID_va_all.=$SPECTypeID_va.",";
                          }

                          $str_GetSType="select SPECTypeID as SPECTypeID_va from spectypes where SPECCategoryID=".$data_spec[0]." and (ParentSpec IS NULL) and INSTR('".$_COOKIE["type_cookie".$data_spec[0].""]."',SPECTypeID)>0";
                          $GetSTyperesult=mysqli_query($link_db,$str_GetSType);
                          while(list($SPECTypeID_va)=mysqli_fetch_row($GetSTyperesult)){
                            $SPECTypeID_va_all.=$SPECTypeID_va.",";
                          }

                          $str_Types="select * from spectypes where SPECCategoryID=".$data_spec[0]." and INSTR('".$SPECTypeID_va_all.$ParentSpec_va_all."',SPECTypeID)>0";

                        }else{
                          $str_Types="select * from spectypes where SPECCategoryID=".$data_spec[0]." and INSTR('".$data_p[1]."',SPECTypeID)>0";
                        }
                        $Typesresult=mysqli_query($link_db,$str_Types);  
                        while(list($SPECTypeID,$SPECCategoryID,$SPECTypeName,$WebOrder,$ParentSpec)=mysqli_fetch_row($Typesresult)){
                          $i1=$i1+1;
                          $SPECType_num.=$SPECTypeID.",";  
                          ?>
                          <TR>
                            <TD width="200px" >
                              <table class="insidetable1">
                                <tr><td>
                                  <?php	
                                  echo $SPECTypeName;
                                  ?>
                                </td><td>  
                                <table>
                                  <?php
                                  $SP_Pa="";
                                  $str_Types_Pa="select SPECTypeID from spectypes where SPECCategoryID=".$data_spec[0]." and (ParentSpec is NULL)";
                                  $Typesresult_Pa=mysqli_query($link_db,$str_Types_Pa);
                                  while($Typesresult_PaData=mysqli_fetch_row($Typesresult_Pa)){
                                    $SP_Pa.=$Typesresult_PaData[0].",";
                                  }

                                  if(isset($_COOKIE["type_cookie".$data_spec[0].""])!=''){
                                    $str_Types_sub="select SPECTypeID,SPECTypeName,ParentSpec from spectypes where SPECCategoryID=".$data_spec[0]." and (INSTR(',".$_COOKIE["type_cookie".$data_spec[0].""]."',SPECTypeID)>0 and INSTR(',".$SP_Pa."',ParentSpec)>0) order by SPECTypeSort";
                                  }else{
                                    $str_Types_sub="select SPECTypeID,SPECTypeName,ParentSpec from spectypes where SPECCategoryID=".$data_spec[0]." and INSTR('".$data_p[2]."',SPECTypeID)>0";
                                  }
                                  $Typesresult_sub=mysqli_query($link_db,$str_Types_sub);	
                                  while($sub_sdate=mysqli_fetch_row($Typesresult_sub)){
                                    $ParentSpec_va_all_Thr.=$sub_sdate[0].",";		
                                    if($SPECTypeID==$sub_sdate[2]){		
                                      echo "<tr><td>".$sub_sdate[1]." ".$sub_sdate[0]."</td></tr>";
                                    }else{
                                    }
                                  }	
                                  ?>
                                </table>
                              </td>
                            </tr> 
                          </table>   
                          <?php		   		   
                          $str_option_all="";
                          $strr_option_all="";
                          $strr_option="";
                          $ii1=0;
                          $options_cookie_Vals="";
                          $str_Types_sub="select SPECTypeID,SPECCategoryID,SPECTypeName from spectypes where InputTypeID<3 and SPECCategoryID=".$SPECCategoryID." and ParentSpec=".$SPECTypeID;
                          $Typesresult_sub=mysqli_query($link_db,$str_Types_sub);
                          while($Tdata=mysqli_fetch_row($Typesresult_sub)){
                           $ii1=$ii1+1;
                           if(isset($_COOKIE["type_cookie".$data_spec[0].""])!=''){
                             if(preg_match("/".$Tdata[0]."/i",$_COOKIE["type_cookie".$data_spec[0].""])!=''){
                              $str_option="<input name='aspectype[]' type='checkbox' style='display:none' value='".$Tdata[0]."' checked />";
                              $str_option=$str_option."<a href='lb_options.php?SPCT_ID=".$Tdata[0]."' title='".$Tdata[2]."' class='fancybox fancybox.iframe' onclick=show(".$i1.",'".$Tdata[0]."')>[Edit]</a>";

                              $strr_option="<div id='divObj".$i1."' display:'inline-block'>";
                              $j=0;
                              if(isset($_COOKIE["options_cookie".$Tdata[0].""])!=''){
                                $options_cookie_Vals=$_COOKIE["options_cookie".$Tdata[0].""];
                              }else{
                                $options_cookie_Vals="";
                              }
                              $str_Optionss="select SPECOptionID,SPECOptionValue from specoptions where SPECTypeID=".$Tdata[0]." and INSTR('".$options_cookie_Vals."',SPECOptionID)>0 order by SPECOptionSort";
                              $Optionsresults=mysqli_query($link_db,$str_Optionss);
                              if($Optionsresults==true){  
                                while(list($SPECOptionID,$SPECOptionValue)=mysqli_fetch_row($Optionsresults)){
                                  $j=$j+1;
                                  $strr_option.="<input name='aspecoption[]' type='checkbox' style='display:none' value='".$Tdata[0]."|".$SPECOptionID."' checked />".$SPECOptionValue.",&nbsp;";

                                  if($j%8==0){ echo "<br />"; }
                                }
                              }

                              $strr_option.=$str_option;
                              $strr_option.="</div>";
                              $str_option_all=$str_option_all.$strr_option;
                            }
                          }
                          else{
                            if(strpos($data_p[2],$Tdata[0])!='' || strpos($data_p[2],$Tdata[0])===0){            
                              
                              $str_option="<input name='aspectype[]' type='checkbox' style='display:none' value='".$Tdata[0]."' checked />";
                              $str_option=$str_option."<a href='lb_options.php?SPCT_ID=".$Tdata[0]."' title='".$Tdata[2]."' class='fancybox fancybox.iframe' onclick=show(".$i1.",'".$Tdata[0]."')>[Edit]</a>";
                              
                              $strr_option="<div id='divObj".$i1."' display:'inline-block'>";
                              $j=0;
                              
                              if(isset($_COOKIE["options_cookie".$Tdata[0].""])!=''){
                                $options_cookie_TP=$_COOKIE["options_cookie".$Tdata[0].""];
                              }else{
                                $options_cookie_TP="";
                              }

                              $str_Optionss="select SPECOptionID,SPECOptionValue from specoptions where instr('".trim($options_cookie_TP)."',SPECOptionID)>0 and SPECTypeID=".$Tdata[0];

                              $Optionsresults=mysqli_query($link_db,$str_Optionss);
                              if($Optionsresults==true){  
                                while(list($SPECOptionID,$SPECOptionValue)=mysqli_fetch_row($Optionsresults)){
                                  $j=$j+1;

                                  $strr_option.="<input name='aspecoption[]' type='checkbox' style='display:none' value='".$Tdata[0]."|".$SPECOptionID."' checked />".$SPECOptionValue.",&nbsp;";

                                  if($j%8==0){ echo "<br />"; }
                                }
                              }
                              $strr_option.=$str_option;
                              $strr_option.="</div>";              
                              $str_option_all=$str_option_all.$strr_option;  

                            }
                          }
                        }           
                        ?> 
                        <?php
                        if($i1%3==0){
                        }
                        ?>
                      </TD>
                      <TD>
                        <div class="left">
                          <?php
                          if($str_option_all==''){
                            ?>     

                            <INPUT name="aspectype[]" type="checkbox" style="display:none" value="<?=$SPECTypeID;?>" checked />

                              <?php	
                              $str_option_all_str="";
                              $str_Options_checkd="select SPECOptionID,SPECTypeID,SPECOptionValue,IsShow FROM specoptions where SPECTypeID=".$SPECTypeID." order by SPECOptionValue";
                              $Optionsresult_checkd=mysqli_query($link_db,$str_Options_checkd);
                              $Options_data=mysqli_fetch_row($Optionsresult_checkd);
                              if(empty($Options_data)):
                                echo "<A href=lb_options.php?SPCT_ID=".$SPECTypeID." class='fancybox fancybox.iframe' onclick='show(".$i1.",".$SPECTypeID.")'>[Edit]</A>&nbsp;&nbsp;";
                              else:	
                                echo "<A href=lb_options.php?SPCT_ID=".$SPECTypeID." class='fancybox fancybox.iframe' onclick='show(".$i1.",".$SPECTypeID.")'>[Edit]</A>&nbsp;&nbsp;";
                              endif;	
                              ?>

                              <?php
                            }else{
                              echo $str_option_all;
                            }
                            ?>
                          </div>      

                          <?php
                          $options_cookie_STypeID="";
                          if($strr_option_all==""){
                            if(isset($_COOKIE["options_cookie".$SPECTypeID])!=""){
                              $options_cookie_STypeID=$_COOKIE["options_cookie".$SPECTypeID];
                            }else{
                              $options_cookie_STypeID="";
                            }
                            ?>
                            <DIV id="divObj<?=$i1;?>" style="margin:0px; padding:0px" class="left">
                              <?php
                              $j=0;
                              $str_Options="select SPECOptionID,SPECOptionValue from specoptions where instr('".trim($options_cookie_STypeID)."',SPECOptionID)>0 and SPECTypeID=".$SPECTypeID;
                              $Optionsresult=mysqli_query($link_db,$str_Options);
                              if($Optionsresult==true){  
                                while(list($SPECOptionID,$SPECOptionValue)=mysqli_fetch_row($Optionsresult)){
                                  $j=$j+1;
                                  ?>
                                  <INPUT name="aspecoption[]" type="checkbox" style="display:none" value="<?=$SPECTypeID?>|<?=$SPECOptionID;?>" checked />
                                    <?=$SPECOptionValue;?>,&nbsp;
                                    <?php
                                  }
                                }
                                ?>
                              </DIV>
                              <?php
                            }
                            ?>      
                          </TD>
                          <?php
                        }
                        ?>
                      </TABLE>
                    </TD>
                  </TR>
                </TBODY>
                <?php
              }
              mysqli_close($link_db);
              ?>
            </TABLE>
            <?php
          }
          ?>
          <P>&nbsp;</P><P>&nbsp;</P><P class="clear"></P>
          <H3>Product Matrix Settings:</H3>
          SKU : <SELECT id="SEL_SKU_S" name="SEL_SKU_S">
          <OPTION value="1" selected="selected">Disabled</OPTION>
          <OPTION value="0">Enabled</OPTION>
        </select>

        <HR class="style-four" /> 
        <p class="clear"></P>
          <?php
          if($PType_id<>""){  
            ?>
            <TABLE class="addspec" style="display:none">
              <TR ><TH>Matrix Category:</TH>
                <TD><P>
                  <SELECT id="SEL_PMatrix" name="SEL_PMatrix">
                    <OPTION selected="selected" value="">Select from extisting: </OPTION>
                    <?php
                    $Mat=0;
                    $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                    mysqli_query($link_db,'SET NAMES utf8');
                    mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                    mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                    //$select=mysqli_select_db($dataBase, $link_db);
                    $str_mat="select * from product_matrix_categories where ProductTypeID=".$PType_id." order by Matrix_CategoryName";
                    $mat_result=mysqli_query($link_db,$str_mat);
                    while(list($Product_Matrix_Cid,$ProductTypeID,$Page_Status,$Matrix_CategoryName,$IsStatus,$Matrix_SKUs)=mysqli_fetch_row($mat_result))
                    {
                      $Mat=$Mat+1;
                      ?>
                      <OPTION value="<?=$Product_Matrix_Cid;?>" 
                        <?php

                        if(isset($_SESSION['SEL_PMatrix01'])<>''){

                          if($Product_Matrix_Cid==$_SESSION['SEL_PMatrix01']){ 
                            echo "selected";
                          }

                        }else{ 
                          if(isset($_REQUEST['PMatrix_id'])==$Product_Matrix_Cid) {
                            echo "selected";
                          }else{
                            if($Mat==1){ echo "selected"; }
                          }
                        }

                        ?>><?=$Matrix_CategoryName;?></OPTION>
                        <?php
                      }
                      mysqli_close($link_db);
                      ?>
                    </SELECT>
                    <?php
                    echo $SPECType_num."<br />";
                    echo $ParentSpec_va_all_Sub."<br />";
                    echo $ParentSpec_va_all_Thr."<br />";
                    ?>
                  </P>
                </TD>
              </TR>
            </TABLE>

            <TABLE id="product_matrix" style="display:none">
              <THEAD>
                <?php
                if($PType_id==101 || $PType_id==102){
                  $P_Val=15;
                  ?>
                  <TR>
                    <TH class="<?=$type_style;?>" rowspan="2">Form Factor</TH>
                    <TH class="<?=$type_style;?>" rowspan="2">CPU / <?=$Cvalues;?></TH>
                    <TH class="<?=$type_style;?>" rowspan="2">Chipset</TH>
                    <TH class="<?=$type_style;?>" colspan="3">Exp. Slots</TH>
                    <TH class="<?=$type_style;?>" colspan="2">Memory</TH>
                    <TH class="<?=$type_style;?>" colspan="4">Integrated Features</TH>
                    <TH class="<?=$type_style;?>" rowspan="2">Server Mgmt.</TH>
                    <TH class="<?=$type_style;?>" rowspan="2">RoHS (Type)</TH>
                  </TR>    
                  <TR>
                    <TH class="sub">PCI-X</TH>
                    <TH class="sub">PCI</TH>
                    <TH class="sub">PCIe</TH>
                    <TH class="sub">Max.</TH>
                    <TH class="sub">Type</TH>
                    <TH class="sub">Audio (A)</TH>
                    <TH class="sub">Video (G)</TH>
                    <TH class="sub">LAN (N)</TH>
                    <TH class="sub">RAID (R)</TH>
                  </TR>
                  <?php
                }else if($PType_id==103 || $PType_id==104){
                  $P_Val=18;
                  ?>
                  <TR>
                    <TH class="<?=$type_style;?>" colspan="3">Dim. (inch)</TH>
                    <TH class="<?=$type_style;?>" rowspan="2">Power Supply</TH>
                    <TH class="<?=$type_style;?>" rowspan="2">CPU Series</TH>
                    <TH class="<?=$type_style;?>" colspan="2">Memory</TH>
                    <TH class="<?=$type_style;?>" colspan="3">HDD</TH>
                    <TH class="<?=$type_style;?>" colspan="2">NIC</TH>
                    <TH class="<?=$type_style;?>" colspan="3">Exp. Slots</TH>
                    <TH class="<?=$type_style;?>" rowspan="2">Server Mgmt.</TH>
                    <TH class="<?=$type_style;?>" rowspan="2">FF RoHS (Type)</TH>
                  </TR>
                  <TR>
                    <TH class="<?=$type_style_buttom;?>">H</TH>
                    <TH class="<?=$type_style_buttom;?>">W</TH>
                    <TH class="<?=$type_style_buttom;?>">D</TH>
                    <TH class="<?=$type_style_buttom;?>">Max.</TH>
                    <TH class="<?=$type_style_buttom;?>">Type</TH>
                    <TH class="<?=$type_style_buttom;?>">Max.</TH>
                    <TH class="<?=$type_style_buttom;?>">Type</TH>
                    <TH class="<?=$type_style_buttom;?>">H/F</TH>
                    <TH class="<?=$type_style_buttom;?>">GbE</TH>
                    <TH class="<?=$type_style_buttom;?>">10GbE</TH>
                    <TH class="<?=$type_style_buttom;?>">PCI-X</TH>
                    <TH class="<?=$type_style_buttom;?>">PCI</TH>
                    <TH class="<?=$type_style_buttom;?>">PCIe</TH>          
                  </TR>    
                  <?php
                }else if($PType_id==0106 || $PType_id==105){
                  $P_Val=14;
                  ?>
                  <TR>
                    <TH class="<?=$type_style;?>" rowspan="2">Form Factor</TH>
                    <TH class="<?=$type_style;?>" colspan="2">Dim. (inch)</TH>
                    <TH class="<?=$type_style;?>" rowspan="2">Chipset</TH>
                    <TH class="<?=$type_style;?>" rowspan="2">Cache Freq.</TH>
                    <TH class="<?=$type_style;?>" rowspan="2">Host Interface</TH>
                    <TH class="<?=$type_style;?>" colspan="2"># of Devices</TH>
                    <TH class="<?=$type_style;?>" colspan="3">Integrated Features</TH>
                    <TH class="<?=$type_style;?>" rowspan="2">Optional BBU</TH>
                    <TH class="<?=$type_style;?>" rowspan="2">RoHS (Type)</TH>
                  </TR>
                  <TR>
                    <TH class="<?=$type_style_buttom;?>">W</TH>
                    <TH class="<?=$type_style_buttom;?>">D</TH>          
                    <TH class="<?=$type_style_buttom;?>">Int. Port</TH>
                    <TH class="<?=$type_style_buttom;?>">Ext. Port(X)</TH>
                    <TH class="<?=$type_style_buttom;?>">S/W RAID(SR)</TH>
                    <TH class="<?=$type_style_buttom;?>">H/W RAID(HR)</TH>
                    <TH class="<?=$type_style_buttom;?>">Enhanced RAID(E)</TH>
                  </TR>
                  <?php
                }else{
                  $P_Val=0;
                }
                ?>
              </THEAD>   
              <TBODY>
                <TR>
                  <?php
                  $PS="";
                  for($PI=1;$PI<$P_Val;$PI++){
                    if(strlen($PI)>1){
                      $PI=$PI;
                    }else{
                      $PI="0".$PI;
                    }
                    $PS=$PI+3;            
                    ?>
                    <TD><A id="alink_<?=$PS-1?>" href="#product_matrix" onclick="show_PMA<?=$PI?>(<?=$PI?>);">Add</A></TD>
                    <?php
                  }
                  ?>
                </TR>

              </TBODY>
            </TABLE>
            <!--Click Add or edit 內容 會出現下面-->
            <BR />
            <?php
            if($PType_id01==101 || $PType_id01==102){
              ?>
              <DIV id="PMA_ADD01" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA01()"> [close] </A></DIV><!--end of close-->
                <H4>Form Factor:</H4>
                <SELECT id="SEL_PMT003" name="SEL_PMT003">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m03="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=1 order by MValue_VName";
                  $m_result03=mysqli_query($link_db,$str_m03);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result03)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show03" style="display:none"><INPUT type="text" id="PMS_03" name="PMS_03" size="20" value=""><BR />Tooltips :<INPUT id="PMS_03U" name="PMS_03U" type="text" size="20" value="" /> <INPUT type="button" value="Add New" onclick="Add_Matrvalue(3,<?=$PType_id;?>,<?=$PCate_id;?>);" /></DIV>
              </DIV>

              <DIV id="PMA_ADD02" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA02()"> [close] </A></DIV><!--end of close-->
                <H4>CPU / <?=$Cvalues;?>:</H4>                                                                                                        
                <SELECT id="SEL_PMT004" name="SEL_PMT004">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
  //$str_m04="select distinct CPU_QPI from product_matrix order by CPU_QPI";
                  $str_m04="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=2 order by MValue_VName";
                  $m_result04=mysqli_query($link_db,$str_m04);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result04)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show04" style="display:none"><INPUT type="text" id="PMS_04" name="PMS_04" size="20" value=""><BR />Tooltips :<INPUT id="PMS_04U" name="PMS_04U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(4,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD03" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA03()"> [close] </A></DIV><!--end of close-->
                <H4>Chipset:</H4>
                <SELECT id="SEL_PMT005" name="SEL_PMT005">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m05="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=3 order by MValue_VName";
                  $m_result05=mysqli_query($link_db,$str_m05);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result05)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show05" style="display:none"><INPUT type="text" id="PMS_05" name="PMS_05" size="20" value=""><BR />Tooltips :<INPUT id="PMS_05U" name="PMS_05U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(5,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD04" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA04()"> [close] </A></DIV><!--end of close-->
                <H4>Exp. Slots -> PCIx:</H4>            
                <SELECT id="SEL_PMT006" name="SEL_PMT006">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m06="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=4 and MValue_SUBName='PCI-X' order by MValue_VName";
                  $m_result06=mysqli_query($link_db,$str_m06);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result06)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show06" style="display:none"><INPUT type="text" id="PMS_06" name="PMS_06" size="20" value=""><BR />Tooltips :<INPUT id=="PMS_06U" name="PMS_06U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(6,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD05" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA05()"> [close] </A></DIV><!--end of close-->
                <H4>Exp. Slots -> PCI:</H4> 
                <SELECT id="SEL_PMT007" name="SEL_PMT007">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m07="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=4 and MValue_SUBName='PCI' order by MValue_VName";
                  $m_result07=mysqli_query($link_db,$str_m07);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result07)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show07" style="display:none"><INPUT type="text" id="PMS_07" name="PMS_07" size="20" value=""><BR />Tooltips :<INPUT id="PMS_07U" name="PMS_07U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(7,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD06" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA06()"> [close] </A></DIV><!--end of close-->
                <H4>Exp. Slots -> PCIe:</H4> 
                <SELECT id="SEL_PMT008" name="SEL_PMT008">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m08="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=4 and MValue_SUBName='PCIe' order by MValue_VName";
                  $m_result08=mysqli_query($link_db,$str_m08);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result08)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show08" style="display:none"><INPUT type="text" id="PMS_08" name="PMS_08" size="20" value=""><BR />Tooltips :<INPUT id="PMS_08U" name="PMS_08U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(8,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD07" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA07()"> [close] </A></DIV><!--end of close-->
                <H4>Memory -> Max.:</H4> 
                <SELECT id="SEL_PMT009" name="SEL_PMT009">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
  //$str_m09="select distinct Mem_Max from product_matrix order by Mem_Max";
                  $str_m09="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=5 and MValue_SUBName='Max.' order by MValue_VName";
                  $m_result09=mysqli_query($link_db,$str_m09);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result09)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show09" style="display:none"><INPUT type="text" id="PMS_09" name="PMS_09" size="20" value=""><BR />Tooltips :<INPUT id="PMS_09U" name="PMS_09U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(9,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD08" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA08()"> [close] </A></DIV><!--end of close-->
                <H4>Memory -> Type:</H4> 
                <SELECT id="SEL_PMT010" name="SEL_PMT010">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m10="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=5 and MValue_SUBName='Type' order by MValue_VName";
                  $m_result10=mysqli_query($link_db,$str_m10);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result10)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show10" style="display:none"><INPUT type="text" id="PMS_10" name="PMS_10" size="20" value=""><BR />Tooltips :<INPUT id="PMS_10U" name="PMS_10U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(10,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD09" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA09()"> [close] </A></DIV><!--end of close-->
                <H4>Integrated Features -> Audio (A):</H4> 
                <SELECT id="SEL_PMT011" name="SEL_PMT011">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m11="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=6 and MValue_SUBName='Audio (A)' order by MValue_VName";
                  $m_result11=mysqli_query($link_db,$str_m11);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result11)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show11" style="display:none"><INPUT type="text" id="PMS_11" name="PMS_11" size="20" value=""><BR />Tooltips :<INPUT id="PMS_11U" name="PMS_11U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(11,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD10" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA10()"> [close] </A></DIV><!--end of close-->
                <H4>Integrated Features -> Video (G):</H4> 
                <SELECT id="SEL_PMT012" name="SEL_PMT012">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m12="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=6 and MValue_SUBName='Video (G)' order by MValue_VName";
                  $m_result12=mysqli_query($link_db,$str_m12);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result12)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show12" style="display:none"><INPUT type="text" id="PMS_12" name="PMS_12" size="20" value=""><BR />Tooltips :<INPUT id="PMS_12U" name="PMS_12U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(12,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD11" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA11()"> [close] </A></DIV><!--end of close-->
                <H4>Integrated Features -> LAN (N):</H4> 
                <SELECT id="SEL_PMT013" name="SEL_PMT013">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m13="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=6 and MValue_SUBName='LAN (N)' order by MValue_VName";
                  $m_result13=mysqli_query($link_db,$str_m13);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result13)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show13" style="display:none"><INPUT type="text" id="PMS_13" name="PMS_13" size="20" value=""><BR />Tooltips :<INPUT id="PMS_13U" name="PMS_13U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(13,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD12" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA12()"> [close] </A></DIV><!--end of close-->
                <H4>Integrated Features -> RAID (R):</H4> 
                <SELECT id="SEL_PMT014" name="SEL_PMT014">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m14="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=6 and MValue_SUBName='RAID (R)' order by MValue_VName";
                  $m_result14=mysqli_query($link_db,$str_m14);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result14)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show14" style="display:none"><INPUT type="text" id="PMS_14" name="PMS_14" size="20" value=""><BR />Tooltips :<INPUT id="PMS_14U" name="PMS_14U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(14,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD13" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA13()"> [close] </A></DIV><!--end of close-->
                <H4>Server Mgmt.:</H4> 
                <SELECT id="SEL_PMT015" name="SEL_PMT015">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m15="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=7 and MValue_SUBName='Server Mgmt.' order by MValue_VName";
                  $m_result15=mysqli_query($link_db,$str_m15);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result15)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show15" style="display:none"><INPUT type="text" id="PMS_15" name="PMS_15" size="20" value=""><BR />Tooltips :<INPUT id="PMS_15U" name="PMS_15U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(15,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD14" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA14()"> [close] </A></DIV><!--end of close-->
                <H4>RoHS (Type):</H4> 
                <SELECT id="SEL_PMT016" name="SEL_PMT016">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m16="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=8 and MValue_SUBName='RoHS (Type)' order by MValue_VName";
                  $m_result16=mysqli_query($link_db,$str_m16);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result16)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show16" style="display:none"><INPUT type="text" id="PMS_16" name="PMS_16" size="20" value=""><BR />Tooltips :<INPUT id="PMS_16U" name="PMS_16U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(16,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>
              <?php
            }else if($PType_id01==103 || $PType_id01==104){
              ?>
              <DIV id="PMA_ADD01" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA01()"> [close] </A></DIV><!--end of close-->
                <H4>Dim. (inch) -> H:</H4>
                <SELECT id="SEL_PMT003" name="SEL_PMT003">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m03="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=9 and MValue_SUBName='H' order by MValue_VName";
                  $m_result03=mysqli_query($link_db,$str_m03);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result03)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show03" style="display:none"><INPUT type="text" id="PMS_03" name="PMS_03" size="20" value=""><BR />Tooltips :<INPUT id="PMS_03U" name="PMS_03U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(3,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD02" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA02()"> [close] </A></DIV><!--end of close-->
                <H4>Dim. (inch) -> W:</H4>                                                                                                        
                <SELECT id="SEL_PMT004" name="SEL_PMT004">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m04="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=9 and MValue_SUBName='W' order by MValue_VName";
                  $m_result04=mysqli_query($link_db,$str_m04);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result04)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show04" style="display:none"><INPUT type="text" id="PMS_04" name="PMS_04" size="20" value=""><BR />Tooltips :<INPUT id="PMS_04U" name="PMS_04U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(4,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD03" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA03()"> [close] </A></DIV><!--end of close-->
                <H4>Dim. (inch) -> D:</H4>
                <SELECT id="SEL_PMT005" name="SEL_PMT005">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m05="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=9 and MValue_SUBName='D' order by MValue_VName";
                  $m_result05=mysqli_query($link_db,$str_m05);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result05)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show05" style="display:none"><INPUT type="text" id="PMS_05" name="PMS_05" size="20" value=""><BR />Tooltips :<INPUT id="PMS_05U" name="PMS_05U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(5,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD04" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA04()"> [close] </A></DIV><!--end of close-->
                <H4>Power Supply:</H4>            
                <SELECT id="SEL_PMT006" name="SEL_PMT006">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m06="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=10 order by MValue_VName";
                  $m_result06=mysqli_query($link_db,$str_m06);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result06)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show06" style="display:none"><INPUT type="text" id="PMS_06" name="PMS_06" size="20" value=""><BR />Tooltips :<INPUT id=="PMS_06U" name="PMS_06U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(6,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD05" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA05()"> [close] </A></DIV><!--end of close-->
                <H4>CPU Series:</H4> 
                <SELECT id="SEL_PMT007" name="SEL_PMT007">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m07="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=11 order by MValue_VName";
                  $m_result07=mysqli_query($link_db,$str_m07);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result07)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show07" style="display:none"><INPUT type="text" id="PMS_07" name="PMS_07" size="20" value=""><BR />Tooltips :<INPUT id="PMS_07U" name="PMS_07U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(7,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD06" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA06()"> [close] </A></DIV><!--end of close-->
                <H4>Memory -> Max.:</H4> 
                <SELECT id="SEL_PMT008" name="SEL_PMT008">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m08="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=5 and MValue_SUBName='Max.' order by MValue_VName";
                  $m_result08=mysqli_query($link_db,$str_m08);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result08)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show08" style="display:none"><INPUT type="text" id="PMS_08" name="PMS_08" size="20" value=""><BR />Tooltips :<INPUT id="PMS_08U" name="PMS_08U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(8,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD07" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA07()"> [close] </A></DIV><!--end of close-->
                <H4>Memory -> Type:</H4> 
                <SELECT id="SEL_PMT009" name="SEL_PMT009">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m09="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=5 and MValue_SUBName='Type' order by MValue_VName";
                  $m_result09=mysqli_query($link_db,$str_m09);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result09)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show09" style="display:none"><INPUT type="text" id="PMS_09" name="PMS_09" size="20" value=""><BR />Tooltips :<INPUT id="PMS_09U" name="PMS_09U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(9,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD08" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA08()"> [close] </A></DIV><!--end of close-->
                <H4>HDD -> Max.:</H4> 
                <SELECT id="SEL_PMT010" name="SEL_PMT010">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m10="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=12 and MValue_SUBName='Max.' order by MValue_VName";
                  $m_result10=mysqli_query($link_db,$str_m10);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result10)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show10" style="display:none"><INPUT type="text" id="PMS_10" name="PMS_10" size="20" value=""><BR />Tooltips :<INPUT id="PMS_10U" name="PMS_10U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(10,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD09" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA09()"> [close] </A></DIV><!--end of close-->
                <H4>HDD -> Type:</H4> 
                <SELECT id="SEL_PMT011" name="SEL_PMT011">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m11="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=12 and MValue_SUBName='Type' order by MValue_VName";
                  $m_result11=mysqli_query($link_db,$str_m11);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result11)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show11" style="display:none"><INPUT type="text" id="PMS_11" name="PMS_11" size="20" value=""><BR />Tooltips :<INPUT id="PMS_11U" name="PMS_11U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(11,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD10" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA10()"> [close] </A></DIV><!--end of close-->
                <H4>HDD -> H/F:</H4> 
                <SELECT id="SEL_PMT012" name="SEL_PMT012">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m12="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=12 and MValue_SUBName='H/F' order by MValue_VName";
                  $m_result12=mysqli_query($link_db,$str_m12);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result12)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show12" style="display:none"><INPUT type="text" id="PMS_12" name="PMS_12" size="20" value=""><BR />Tooltips :<INPUT id="PMS_12U" name="PMS_12U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(12,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD11" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA11()"> [close] </A></DIV><!--end of close-->
                <H4>NIC -> GbE:</H4> 
                <SELECT id="SEL_PMT013" name="SEL_PMT013">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m13="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=13 and MValue_SUBName='GbE' order by MValue_VName";
                  $m_result13=mysqli_query($link_db,$str_m13);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result13)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show13" style="display:none"><INPUT type="text" id="PMS_13" name="PMS_13" size="20" value=""><BR />Tooltips :<INPUT id="PMS_13U" name="PMS_13U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(13,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD12" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA12()"> [close] </A></DIV><!--end of close-->
                <H4>NIC -> 10GbE:</H4> 
                <SELECT id="SEL_PMT014" name="SEL_PMT014">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m14="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=13 and MValue_SUBName='10GbE' order by MValue_VName";
                  $m_result14=mysqli_query($link_db,$str_m14);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result14)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show14" style="display:none"><INPUT type="text" id="PMS_14" name="PMS_14" size="20" value=""><BR />Tooltips :<INPUT id="PMS_14U" name="PMS_14U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(14,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD13" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA13()"> [close] </A></DIV><!--end of close-->
                <H4>Exp. Slots -> PCIx:</H4> 
                <SELECT id="SEL_PMT015" name="SEL_PMT015">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m15="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=4 and MValue_SUBName='PCI-X' order by MValue_VName";
                  $m_result15=mysqli_query($link_db,$str_m15);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result15)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show15" style="display:none"><INPUT type="text" id="PMS_15" name="PMS_15" size="20" value=""><BR />Tooltips :<INPUT id="PMS_15U" name="PMS_15U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(15,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD14" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA14()"> [close] </A></DIV><!--end of close-->
                <H4>Exp. Slots -> PCI:</H4> 
                <SELECT id="SEL_PMT016" name="SEL_PMT016">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m16="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=4 and MValue_SUBName='PCI' order by MValue_VName";
                  $m_result16=mysqli_query($link_db,$str_m16);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result16)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show16" style="display:none"><INPUT type="text" id="PMS_16" name="PMS_16" size="20" value=""><BR />Tooltips :<INPUT id="PMS_16U" name="PMS_16U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(16,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD15" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA15()"> [close] </A></DIV><!--end of close-->
                <H4>Exp. Slots -> PCIe:</H4> 
                <SELECT id="SEL_PMT017" name="SEL_PMT017">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m17="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=4 and MValue_SUBName='PCIe' order by MValue_VName";
                  $m_result17=mysqli_query($link_db,$str_m17);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result17)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show17" style="display:none"><INPUT type="text" id="PMS_17" name="PMS_17" size="20" value=""><BR />Tooltips :<INPUT id="PMS_17U" name="PMS_17U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(17,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD16" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA16()"> [close] </A></DIV><!--end of close-->
                <H4>Server Mgmt.:</H4> 
                <SELECT id="SEL_PMT018" name="SEL_PMT018">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m18="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=7 and MValue_SUBName='Server Mgmt.' order by MValue_VName";
                  $m_result18=mysqli_query($link_db,$str_m18);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result18)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show18" style="display:none"><INPUT type="text" id="PMS_18" name="PMS_18" size="20" value=""><BR />Tooltips :<INPUT id="PMS_18U" name="PMS_18U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(18,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD17" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA17()"> [close] </A></DIV><!--end of close-->
                <H4>RoHS (Type):</H4> 
                <SELECT id="SEL_PMT019" name="SEL_PMT019">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m19="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=8 and MValue_SUBName='RoHS (Type)' order by MValue_VName";
                  $m_result19=mysqli_query($link_db,$str_m19);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result19)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show19" style="display:none"><INPUT type="text" id="PMS_19" name="PMS_19" size="20" value=""><BR />Tooltips :<INPUT id="PMS_19U" name="PMS_19U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(19,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>
              <?php
            }else if($PType_id01==0106 || $PType_id01==105){
              ?>
              <DIV id="PMA_ADD01" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA01()"> [close] </A></DIV><!--end of close-->
                <H4>Form Factor:</H4>
                <SELECT id="SEL_PMT003" name="SEL_PMT003">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m03="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=1 order by MValue_VName";
                  $m_result03=mysqli_query($link_db,$str_m03);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result03)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show03" style="display:none"><INPUT type="text" id="PMS_03" name="PMS_03" size="20" value=""><BR />Tooltips :<INPUT id="PMS_03U" name="PMS_03U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(3,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD02" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA02()"> [close] </A></DIV><!--end of close-->
                <H4>Dim. (inch) -> W:</H4>                                                                                                        
                <SELECT id="SEL_PMT004" name="SEL_PMT004">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m04="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=9 and MValue_SUBName='W' order by MValue_VName";
                  $m_result04=mysqli_query($link_db,$str_m04);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result04)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show04" style="display:none"><INPUT type="text" id="PMS_04" name="PMS_04" size="20" value=""><BR />Tooltips :<INPUT id="PMS_04U" name="PMS_04U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(4,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD03" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA03()"> [close] </A></DIV><!--end of close-->
                <H4>Dim. (inch) -> D:</H4>
                <SELECT id="SEL_PMT005" name="SEL_PMT005">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m05="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=9 and MValue_SUBName='D' order by MValue_VName";
                  $m_result05=mysqli_query($link_db,$str_m05);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result05)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show05" style="display:none"><INPUT type="text" id="PMS_05" name="PMS_05" size="20" value=""><BR />Tooltips :<INPUT id="PMS_05U" name="PMS_05U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(5,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD04" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA04()"> [close] </A></DIV><!--end of close-->
                <H4>Chipset:</H4>            
                <SELECT id="SEL_PMT006" name="SEL_PMT006">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m06="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=3 order by MValue_VName";
                  $m_result06=mysqli_query($link_db,$str_m06);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result06)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show06" style="display:none"><INPUT type="text" id="PMS_06" name="PMS_06" size="20" value=""><BR />Tooltips :<INPUT id=="PMS_06U" name="PMS_06U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(6,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD05" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA05()"> [close] </A></DIV><!--end of close-->
                <H4>Cache Freq.:</H4> 
                <SELECT id="SEL_PMT007" name="SEL_PMT007">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m07="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=14 order by MValue_VName";
                  $m_result07=mysqli_query($link_db,$str_m07);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result07)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show07" style="display:none"><INPUT type="text" id="PMS_07" name="PMS_07" size="20" value=""><BR />Tooltips :<INPUT id="PMS_07U" name="PMS_07U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(7,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD06" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA06()"> [close] </A></DIV><!--end of close-->
                <H4>Host Interface:</H4> 
                <SELECT id="SEL_PMT008" name="SEL_PMT008">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m08="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=15 order by MValue_VName";
                  $m_result08=mysqli_query($link_db,$str_m08);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result08)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show08" style="display:none"><INPUT type="text" id="PMS_08" name="PMS_08" size="20" value=""><BR />Tooltips :<INPUT id="PMS_08U" name="PMS_08U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(8,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD07" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA07()"> [close] </A></DIV><!--end of close-->
                <H4># of Devices -> Int. Port:</H4> 
                <SELECT id="SEL_PMT009" name="SEL_PMT009">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m09="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=16 and MValue_SUBName='Int. Port' order by MValue_VName";
                  $m_result09=mysqli_query($link_db,$str_m09);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result09)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show09" style="display:none"><INPUT type="text" id="PMS_09" name="PMS_09" size="20" value=""><BR />Tooltips :<INPUT id="PMS_09U" name="PMS_09U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(9,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD08" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA08()"> [close] </A></DIV><!--end of close-->
                <H4># of Devices -> Ext. Port (X):</H4> 
                <SELECT id="SEL_PMT010" name="SEL_PMT010">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m10="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=16 and MValue_SUBName='Ext. Port (X)' order by MValue_VName";
                  $m_result10=mysqli_query($link_db,$str_m10);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result10)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show10" style="display:none"><INPUT type="text" id="PMS_10" name="PMS_10" size="20" value=""><BR />Tooltips :<INPUT id="PMS_10U" name="PMS_10U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(10,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD09" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA09()"> [close] </A></DIV><!--end of close-->
                <H4>Integrated Features -> S/W RAID (SR):</H4> 
                <SELECT id="SEL_PMT011" name="SEL_PMT011">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m11="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=6 and MValue_SUBName='S/W RAID (SR)' order by MValue_VName";
                  $m_result11=mysqli_query($link_db,$str_m11);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result11)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show11" style="display:none"><INPUT type="text" id="PMS_11" name="PMS_11" size="20" value=""><BR />Tooltips :<INPUT id="PMS_11U" name="PMS_11U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(11,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD10" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA10()"> [close] </A></DIV><!--end of close-->
                <H4>Integrated Features -> H/W RAID (HR):</H4> 
                <SELECT id="SEL_PMT012" name="SEL_PMT012">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m12="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=6 and MValue_SUBName='H/W RAID (HR)' order by MValue_VName";
                  $m_result12=mysqli_query($link_db,$str_m12);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result12)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show12" style="display:none"><INPUT type="text" id="PMS_12" name="PMS_12" size="20" value=""><BR />Tooltips :<INPUT id="PMS_12U" name="PMS_12U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(12,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD11" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA11()"> [close] </A></DIV><!--end of close-->
                <H4>Integrated Features -> Enhanced RAID (E):</H4> 
                <SELECT id="SEL_PMT013" name="SEL_PMT013">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php 
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m13="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=6 and MValue_SUBName='Enhanced RAID (E)' order by MValue_VName";
                  $m_result13=mysqli_query($link_db,$str_m13);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result13)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show13" style="display:none"><INPUT type="text" id="PMS_13" name="PMS_13" size="20" value=""><BR />Tooltips :<INPUT id="PMS_13U" name="PMS_13U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(13,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD12" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA12()"> [close] </A></DIV><!--end of close-->
                <H4>Optional BBU:</H4> 
                <SELECT id="SEL_PMT014" name="SEL_PMT014">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m14="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=17 order by MValue_VName";
                  $m_result14=mysqli_query($link_db,$str_m14);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result14)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show14" style="display:none"><INPUT type="text" id="PMS_14" name="PMS_14" size="20" value=""><BR />Tooltips :<INPUT id="PMS_14U" name="PMS_14U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(14,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>

              <DIV id="PMA_ADD13" class="subsettings" style="display:none">
                <!--Click close to close this subsettings div--><DIV class="right"><A href="#product_matrix" onClick="Close_PMA13()"> [close] </A></DIV><!--end of close-->
                <H4>RoHS (Type):</H4> 
                <SELECT id="SEL_PMT015" name="SEL_PMT015">
                  <OPTION selected="selected" value="">-- Select --</OPTION>
                  <OPTION value="Add">Add New</OPTION>
                  <OPTION value="NO">NO</OPTION>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m15="SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=8 and MValue_SUBName='RoHS (Type)' order by MValue_VName";
                  $m_result15=mysqli_query($link_db,$str_m15);
                  while(list($MValue_id,$MValue_VName)=mysqli_fetch_row($m_result15)){
                    ?>
                    <OPTION value="<?=$MValue_id;?>"><?=$MValue_VName;?></OPTION>
                    <?php
                  }
                  mysqli_close($link_db);
                  ?>
                </SELECT> <DIV id="PMT_Show15" style="display:none"><INPUT type="text" id="PMS_15" name="PMS_15" size="20" value=""><BR />Tooltips :<INPUT id="PMS_15U" name="PMS_15U" type="text" size="20" value=""  /><INPUT type="button" value="Add New" onclick="Add_Matrvalue(15,<?=$PType_id;?>,<?=$PCate_id;?>);"></DIV>
              </DIV>
              <?php
            }
            ?>
            <?php
          }
          ?>
          <P>&nbsp;</P><P>&nbsp;</P><P class="clear"></P>
          <H3>Grouping Settings:</H3>
          <HR class="style-four" /> 
          <p class="clear"></P>
            <!--Grouping Conditions settings -->
            <div id="GC_settings">
              <TABLE class="pro_spec_bk">
                <THEAD><TR><TH colspan="2">Grouping Condition Settings:</TH></TR></THEAD>
                <?php
                if(isset($_REQUEST['PType_id'])<>''){
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_m="select SKUs_Conditions from product_skus_categories where ProductTypeID=".intval($_REQUEST['PType_id']);
                  $cmd_m=mysqli_query($link_db,$str_m);
                  $m_result=mysqli_fetch_row($cmd_m);

                  if($m_result==true){

                    $MSKUs_id = explode(",", $m_result[0],-1);
                    $MSKUs_count = count($MSKUs_id);

                    $MSKUs_sid = array_unique($MSKUs_id);

                    foreach($MSKUs_sid as $value_c){
                      ?>
                      <TBODY>
                        <TR>
                          <TH style="width:100px"> 
                            <?php
                            $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                            mysqli_query($link_db,'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_CSKUs="select SKUs_Mid,SKUs_MiName,IsShow from skus_mainsub where SKUs_Mid=".$value_c;     
                            $CSKUsresult=mysqli_query($link_db,$str_CSKUs);
                            $data_CSKUs=mysqli_fetch_row($CSKUsresult);
                            ?>
                            <INPUT style="display:none" name="" type="checkbox" value="" <?php if($data_CSKUs[2]=='1') { ECHO "checked"; } ?> />
                              <?php
                              echo $data_CSKUs[1];
                              ?>:</TH>
                              <TD>
                                <SELECT id="SEL_PN<?=$data_CSKUs[0]?>" name="SEL_PN<?=$data_CSKUs[0]?>">
                                  <OPTION selected="selected">Select...</OPTION>
                                  <?php
                                  if(isset($_REQUEST['PType_id'])!=''){
                                    ?>
                                    <OPTION value="Add">Add New</OPTION>
                                    <?php
                                  }
                                  $u=0;
                                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                                  mysqli_query($link_db,'SET NAMES utf8');
                                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                                  //$select=mysqli_select_db($dataBase, $link_db);
                                  $str_nw="select SKUs_Sid,SKUs_Mname from skus_sublist where SKUs_Mid=".$data_CSKUs[0]." and ProductTypeID=".intval($_REQUEST['PType_id'])." order by SKUs_Mname";
                                  $NW_result=mysqli_query($link_db,$str_nw);
                                  while($ndb=mysqli_fetch_array($NW_result)){
                                    $u=$u+1;
                                    ?>
                                    <OPTION value="<?=htmlspecialchars($ndb['SKUs_Mname'], ENT_QUOTES)?>"><?=htmlspecialchars_decode($ndb['SKUs_Mname'], ENT_QUOTES)?></OPTION>
                                    <?php
                                  }
                                  $data_CKstr=$data_CKstr.$data_CSKUs[0].",";
                                  ?>                        
                                </SELECT>&nbsp;&nbsp;&nbsp;&nbsp; <DIV id="SKUPN_add<?=$data_CSKUs[0]?>" style="display:none">Values: <INPUT type="text" id="SSMN1_<?=$data_CSKUs[0]?>" name="SSMN1_<?=$data_CSKUs[0]?>" size="20" value=""> <INPUT type="hidden" name="SSMN2_<?=$data_CSKUs[0]?>" value="<?=$data_CSKUs[0];?>"><INPUT type="hidden" name="SSMN3_<?=$data_CSKUs[0]?>" value="<?=intval($_REQUEST['PType_id']);?>"><INPUT type="hidden" name="SSMN4" value="<?=$data_CKstr;?>"><INPUT id="SSMNBtn<?=$data_CSKUs[0]?>" name="SSMNBtn<?=$data_CSKUs[0]?>" type="button" value="Done" /> <DIV id="SubSKUs_MGT<?=$data_CSKUs[0];?>"></DIV></DIV>
                              </TD>
                            </TR>
                          </TBODY >
                          <?php
                        }
                      }
                      mysqli_close($link_db);
                    }
                    ?>
                  </TABLE>
                </div>

                <P>&nbsp;</P><P>&nbsp;</P><P class="clear"></P>
                <H3>Status Settings:</H3>
                <HR class="style-four" />
                <P class="clear"></P>

                <P style="font-weight:bolder;display:none">Supported Language: 
                  <INPUT name="aspecLang[]" type="checkbox" value="EN" checked="checked" /> English &nbsp;&nbsp;
                  <INPUT name="aspecLang[]" type="checkbox" value="CN" checked="checked" /> 簡中 &nbsp;&nbsp;
                  <INPUT name="aspecLang[]" type="checkbox" value="ZH" checked="checked" /> 繁中 &nbsp;&nbsp;
                  <INPUT name="aspecLang[]" type="checkbox" value="JP" checked="checked" /> 日本語 &nbsp;&nbsp;
                </P>
                <P style="padding-left:145px; font-weight:bolder"><INPUT name="specEOL" type="checkbox" value="1" /> EOL</P>
                <p style="padding-left:145px; font-weight:bolder"><input name="compareBox" type="checkbox" value="1" checked /> Enable "COMPARE" button</p>
                <p style="padding-left:145px; font-weight:bolder"><input name="quoteBox" type="checkbox" value="1" checked /> Enable "REQUEST QUOTE" button</p>

                <P class="clear"></P>
                <HR class="style-four" /> 
                <P class="clear"></P>

                <H3>SKU Note:</H3>
                <HR class="style-four" />
                <P class="clear"></P>
                <P style="padding-left:10px; font-weight:bolder"><textarea cols="30" id="note01" name="note01" rows="7"></textarea></p>
                  <HR class="style-four" /> 
                  <P class="clear"></P>
                  <DIV>
                    <DIV id="savebutton"><BUTTON name="submitbutton01" id="submitbutton01" style="width:60px; margin-right:10px" type="submit" class="button14 left">Save</BUTTON></DIV>
                  </DIV>
                  <?php
                  if(isset($_COOKIE["categor_cookie".$PType_id.""])<>''){
                    $sort_v01=$_COOKIE["categor_cookie".$PType_id.""];
                  }else{
                    if(isset($data_p[0])!=''):
                      $sort_v01=$data_p[0];
                    else:
                      $sort_v01="";
                    endif;
                  }
                  ?>
                  <textarea name="SPECC_Sort_tr" rows="5" cols="80" style="border: none;max-width: 800px; max-height: 200px;display: none;" readonly><?=$sort_v01;?></textarea>
                  <textarea name="SPECTP_str" rows="5" cols="80" style="border: none;max-width: 800px; max-height: 200px;display: none;">
                    <?php
                    if($SPECType_num!='' && $ParentSpec_va_all_Thr!=''){
                      echo $SPECType_num.$ParentSpec_va_all_Thr;
                    }
                    ?></textarea>
                  </FORM>

                  <BR>
                    <P>&nbsp;</P><P>&nbsp;</P>
                    <P class="clear">&nbsp;</P>
                    <DIV id="footer">	Copyright &copy; 2012 Company Co. All rights reserved.
                      <DIV class="gotop" onClick="location='#top'">Top</DIV>
                    </DIV>

                  </BODY>
                </HTML>
                <?php
                if($Save_State=="ok"){
                  echo "<script language='Javascript'>Add_Finish();</script>\n";
                  exit();
                }
                if(isset($_REQUEST['get_cookies'])!=''){
                  if(trim($_REQUEST['get_cookies'])=="Yes"){
                    echo "<script language='Javascript'>Set_Cookies_values();</script>\n";
                    exit();
                  }
                }
                ?>