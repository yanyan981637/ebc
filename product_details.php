<?php
header("X-Frame-Options: DENY");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self';");
header('Content-Type: text/html; charset=utf-8');
header("Cache-control: private");

// error_reporting(0);
ini_set('display_errors', 0);

//if(strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
if(strpos(trim(getenv('REQUEST_URI')),".php")!=''){
	echo "<script language='javascript'>self.location='/404.htm'</script>";
	exit;
}

require "./config.php";


$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');

function dowith_sql($str){
	//$str = str_replace("and","",$str);
	$str = str_replace("execute","",$str);
	$str = str_replace("update","",$str);
	$str = str_replace("count","",$str);
	$str = str_replace("chr","",$str);
	$str = str_replace("<script>","",$str);
	$str = str_replace("</script>","",$str);
	$str = str_replace("javascript","",$str);
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
//$str = str_replace("or","",$str); //2017.05.23 因舊資料SKU關係, 暫時註解
	$str = str_replace("=","",$str);
	return $str;
}

function SPEC_Toal($SPC01,$SPECCa01,$db_host,$db_user,$db_pwd,$dataBase){

	$link=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
	mysqli_query($link, 'SET NAMES utf8');
	mysqli_query($link, 'SET CHARACTER_SET_CLIENT=utf8');
	mysqli_query($link, 'SET CHARACTER_SET_RESULTS=utf8');
	//$select=mysqli_select_db($dataBase,$link);

	$str_STN00="SELECT a.Product_SKU_Auto_ID,b.SPECCategoryName,a.SPECTypeName,a.CParentSpec,a.CSPECValue,a.ParentSpec,b.SPECCategoryID from sp".$SPC01." a inner join speccategroies b on a.SPECCategoryID=b.SPECCategoryID";
	$STN00_cmd=mysqli_query($link,$str_STN00);

	while($STdata=mysqli_fetch_row($STN00_cmd)){
		$SPV_Toal="";
		$SPV[]="";
		$str_CSPCA="select SPECCategoryID,SPECCategoryName,count(SPECCategoryID) as SPECCategoryCount from speccategroies where SPECCategoryName='".$STdata[1]."'";
		$CSPCA_cmd=mysqli_query($link,$str_CSPCA);
		$CSadata=mysqli_fetch_row($CSPCA_cmd);

		if(empty($CSadata)):
			else:

			if(isset($SPV[$STdata[6]])!=''){
			}else{
				$SPV[$STdata[6]]=0;
			}

			$SPV[$STdata[6]]+=1;
			endif;
			if(isset($SPV[$SPECCa01])!=''){
			$SPV_Toal=$SPV[$SPECCa01];
		}

	}
	return $SPV_Toal;
	mysqli_Close($link);
}

$r_pid="";$s_PID="";$m_SKUs="";$s_PMc_str="";$Chk_SKU="";$m_PType="";$PType_si="";$PMCode_si="";$PSKUs_si="";$PLang_si="";$ProductName01="";$PType_siName01="";
$WTBName01="";$CUName01="";$OSName01="";$WTBName01_url="";$CUName01_url="";$OSName01_url="";$PRName01="";$DMName01="";$SPName01="";$DLName01="";$PDName01="";

$PType_si=preg_replace("/['\"\~\%\$ \r\n\t;<>\?]/i", '', trim($_REQUEST['PType']));
$PType_si=filter_var($PType_si);

$PMCode_si=trim($_REQUEST['PMCode']);
$PMCode_si=filter_var($PMCode_si);

$PSKUs_si=dowith_sql($_REQUEST['PSKUs']);
$PSKUs_si=filter_var($PSKUs_si);

$Search_Sku="SELECT Product_SContents_Auto_ID, SKU, Product_dsc FROM contents_product_skus WHERE `SKU`='".$PSKUs_si."' ";
$Sku_cmd=mysqli_query($link_db,$Search_Sku);
if(mysqli_num_rows($Sku_cmd) < 1){
	echo "<script language='javascript'>self.location='/404.htm'</script>";
	exit();
}
$data=mysqli_fetch_row($Sku_cmd);
$title_des=$data[2];

if(isset($_REQUEST['PLang'])!=''){
	$PLang_si=dowith_sql($_REQUEST['PLang']);
	$PLang_si=filter_var($PLang_si);
	if($PLang_si=="EN"){
		$PLang_si01="EN";
		$PLang_si="en-US";
		$ProductName01="Products";
		$WTBName01="WHERE TO BUY";$WTBName01_url="/EN/where_to_buy/usa.php";
		$CUName01="Contact Us";$CUName01_url="/EN/contact.php";
		$OSName01="Online Service";$OSName01_url="http://12.33.221.75/helpstar/hsPages/login.aspx";
		$PRName01="Press Review";
		$DMName01="Docs";
		$SPName01="Support / AVL";
		$DLName01="Downloads";
		$PDName01="Overview";
		$SPECName01="Specifications";
	}
}else{
	$PLang_si01="EN";
	$PLang_si="en-US";
	$ProductName01="Products";
	$WTBName01="WHERE TO BUY";$WTBName01_url="/EN/where_to_buy/usa.php";
	$CUName01="Contact Us";$CUName01_url="/EN/contact.php";
	$OSName01="Online Service";$OSName01_url="http://12.33.221.75/helpstar/hsPages/login.aspx";
	$PRName01="Press Review";
	$DMName01="Docs";
	$SPName01="Support / AVL";
	$DLName01="Downloads";
	$PDName01="Overview";
	$SPECName01="Specifications";
}

if(isset($_REQUEST['pid'])!=''){
	$r_pid = intval($_REQUEST['pid']);
	$r_pid=filter_var($r_pid);
}else{
	if($PType_si == "Motherboards"){
		$prod_imgurl="./images/systemboards/";
		$s_PID = "select SYSTEMBOARDID from p_s_main_systemboards where MODELCODE='".$PMCode_si."' and LANG='en-US'";
	}else if($PType_si == "Barebones"){
		$prod_imgurl="./images/serverbarebones/";
		$s_PID = "select SERVERID from p_b_main_serverbarebones where MODELCODE='".$PMCode_si."' and LANG='en-US'";
	}else if($PType_si == "HBA"){
		$s_PID = "select HBAID from p_s_main_hba where MODELCODE='".$PMCode_si."' and LANG='".$PLang_si."'";
		$prod_imgurl="./images/HBA/";
	}else if($PType_si == "Chassis"){
		$prod_imgurl="./images/serverbarebones/";
		$s_PID = "select `SERVERID` FROM `p_r_main_rackchassis` where MODELCODE='".$PMCode_si."' and LANG='en-US'";
	}else if($PType_si == "IndustrialPanelPC"){
		$prod_imgurl="./images/product/PanelPc/";
		$s_PID = "select `PANELPCID` FROM `p_b_main_panelpc` where MODELCODE='".$PMCode_si."' and LANG='en-US'";
	}else if($PType_si == "EmbeddedSystem"){
		$prod_imgurl="./images/product/Embedded/";
		$s_PID = "select `EMBEDDEDID` FROM `p_b_main_embedded` where MODELCODE='".$PMCode_si."' and LANG='en-US'";
	}else if($PType_si == "IndustrialMotherboard"){
		$prod_imgurl="./images/product/IndustriaMB/";
		$s_PID = "select `INDUSTRIAMBID` FROM `p_b_main_industriamb` where MODELCODE='".$PMCode_si."' and LANG='en-US'";
	}else if($PType_si == "OCPserver"){
		$prod_imgurl="./images/product/OCPserver/";
		$s_PID = "select `OCPID` FROM `p_b_main_ocpserver` where MODELCODE='".$PMCode_si."' and LANG='en-US'";
	}else if($PType_si == "OCPMezz"){
		$prod_imgurl="./images/product/OCPMezz/";
		$s_PID = "select `OCPMezzID` FROM `p_b_main_ocpmezz` where MODELCODE='".$PMCode_si."' and LANG='en-US'";
	}else if($PType_si == "JBODJBOF"){
		$prod_imgurl="./images/product/JBODJBOF/";
		$s_PID = "select `JBODFID` FROM `p_b_main_jbodjbof` where MODELCODE='".$PMCode_si."' and LANG='en-US'";
	}else if($PType_si == "OCPRack"){
		$prod_imgurl="./images/product/OCPrack/";
		$s_PID = "select `OCPRACKID` FROM `p_b_main_ocprack` where MODELCODE='".$PMCode_si."' and LANG='en-US'";
	}else if($PType_si == "POS"){
		$prod_imgurl="./images/product/POS/";
		$s_PID = "select `POSID` FROM `p_b_main_pos` where MODELCODE='".$PMCode_si."' and LANG='en-US'";
	}else if($PType_si == "5GEdgeComputing"){
		$prod_imgurl="./images/product/5G/";
		$s_PID = "select `5GID` FROM `p_b_main_5G` where MODELCODE='".$PMCode_si."' and LANG='en-US'";
	}else{
		echo "<script language='javascript'>self.location='/404.htm'</script>";
		exit();
	}

	$PCd_cmd=mysqli_query($link_db,$s_PID);
	$PCd_result=mysqli_fetch_row($PCd_cmd);
	if($PCd_result==true){
		$r_pid = $PCd_result[0];
	}else{
		echo "<script language='javascript'>self.location='/404.htm'</script>";
		exit();
	}
}

if(isset($_REQUEST['SKU'])!=''){
	$m_SKUs = trim(str_replace(".php","",$PSKUs_si));
	$m_SKUs=filter_var($m_SKUs);
}else{

	//$s_PMc_str = trim($PMCode_si);

	$s_SKU = "select Product_SKU_Auto_ID, IS_EOL, IS_BTO, COMPARE, REQUEST_QUOTE from product_skus where SKU='".str_replace(".php","",$PSKUs_si)."' and MODELCODE='".$PMCode_si."'";
	$pkS_cmd=mysqli_query($link_db,$s_SKU);
	$pkS_result=mysqli_fetch_row($pkS_cmd);
	if($pkS_result==true){
		$m_SKUs=$pkS_result[0];
	}
	if($pkS_result[1]==1){
		$EOLBox=$pkS_result[1];
		$EOL="(EOL)";
	}
	if($pkS_result[2]==1){
		$BTO="(BTO)";
	}
	if($pkS_result[3]==1){
		$COMPARE=$pkS_result[3];
	}if($pkS_result[4]==1){
		$REQUEST_QUOTE=$pkS_result[4];
	}
}

global $str_STN,$str_STN01;

$str_STN="SELECT specvalues.SPEC_Vaule_ID, specvalues.Product_SKU_Auto_ID, specvalues.SPECTypeID, specvalues.SPECValue, spectypes.InputTypeID,
CASE WHEN spectypes.InputTypeID =3
THEN specvalues.SPECValue
ELSE Fun_Get_SPECValue(specvalues.SPECValue)
END CSPECValue, spectypes.ParentSpec, SPECTypeName,
CASE WHEN spectypes.ParentSpec IS NULL
THEN ''
ELSE (SELECT SPECTypeName FROM `spectypes` P WHERE P.SPECTypeID = spectypes.ParentSpec)
END CParentSpec, spectypes.SPECCategoryID, spectypes.WebOrder FROM `specvalues` INNER JOIN `spectypes` ON specvalues.SPECTypeID = spectypes.SPECTypeID WHERE (specvalues.Product_SKU_Auto_ID =".$m_SKUs.") AND (specvalues.SPECValue <> '') ORDER BY spectypes.WebOrder;";
$cmd_STN=mysqli_query($link_db,$str_STN);
while($data=mysqli_fetch_row($cmd_STN)){
	if($data[7]=="Supported CPU Series" || $data[7]=="Socket Type / Q'ty"){
		$str_STN01.=$data[5].", ";
	}
}

$Chk_SKU = "select Product_SKU_Auto_ID from product_skus where Product_SKU_Auto_ID=".$m_SKUs."";
$chS_cmd=mysqli_query($link_db,$Chk_SKU);
$chS_result=mysqli_fetch_row($chS_cmd);
if(empty($chS_result)==''):
else:
	echo "<script language='javascript'>self.location='~/404.htm'</script>";
endif;

if(isset($_REQUEST['ProductType'])!=''){
	$m_PType = trim($_REQUEST['ProductType']);
}else{
	if($PType_si == "IndustrialPanelPC"){
				//$m_PType = "BB";
		if($PLang_si=="en-US"){
			$PType_siName01="Industrial Panel PC";
			$siName_url = "/EN/products/Industrial_Panel_PC/";
		}
	}else if($PType_si == "EmbeddedSystem"){
				//$m_PType = "BB";
		if($PLang_si=="en-US"){
			$PType_siName01="Embedded System";
			$siName_url = "/EN/products/embedded_system/";
		}
	}else if($PType_si == "IndustrialMotherboard"){
				//$m_PType = "HBA";
		if($PLang_si=="en-US"){
			$PType_siName01="Industrial Motherboard";
			$siName_url = "/EN/products/industrial_motherboard/";
		}
	}else if($PType_si == "OCPserver"){
				//$m_PType = "Chassis";
		if($PLang_si=="en-US"){
			$PType_siName01="OCP Server";
			$siName_url = "/EN/products/OCP/";
		}
	}else if($PType_si == "OCPMezz"){
				//$m_PType = "JBOD";
		if($PLang_si=="en-US"){
			$PType_siName01="OCP Mezz";
			$siName_url = "/EN/products/OCP/";
		}
	}else if($PType_si == "JBODJBOF"){
				//$m_PType = "JBOD";
		if($PLang_si=="en-US"){
			$PType_siName01="JBOD / JBOF";
			$siName_url = "/EN/products/storage_platform/";
		}
	}else if($PType_si == "OCPRack"){
				//$m_PType = "JBOD";
		if($PLang_si=="en-US"){
			$PType_siName01="OCP Rack";
			$siName_url = "/EN/products/OCP/";
		}
	}else if($PType_si == "POS"){
				//$m_PType = "JBOD";
		if($PLang_si=="en-US"){
			$PType_siName01="POS";
					//$siName_url = "/EN/TYAN_JBOD/";
		}
	}else if($PType_si == "5GEdgeComputing"){
				//$m_PType = "JBOD";
		if($PLang_si=="en-US"){
			$PType_siName01="5GEdgeComputing";
					//$siName_url = "/EN/TYAN_JBOD/";
		}
	}
}

if($r_pid != NULL){
	$mysql="";
	$mysql = " SELECT p_s_main_systemboards.SYSTEMBOARDID, p_s_main_systemboards.MODELNAME, ";
	$mysql = $mysql . " p_s_main_systemboards.SPEC, ";
	$mysql = $mysql . " p_s_main_systemboards.CPUSORT, ";
	$mysql = $mysql . " p_s_main_systemboards.IMG, ";
	$mysql = $mysql . " p_s_main_systemboards.BIGIMG, ";
	$mysql = $mysql . " p_s_main_systemboards.UPDATE_USER, ";
	$mysql = $mysql . " p_s_main_systemboards.UPDATE_DATE, ";
	$mysql = $mysql . " p_s_main_systemboards.STATUS, ";
	$mysql = $mysql . " CONCAT(p_s_main_systemboards.MODELNAME,' (',p_s_main_systemboards.MODELCODE,')') AS MODEL, ";
	$mysql = $mysql . " CASE WHEN ISDUALCORE = 1 THEN '_DualCore' ELSE '' END AS DUALCORE, ";
	$mysql = $mysql . " p_s_main_systemboards.MODELCODE, ";
	$mysql = $mysql . " p_s_main_systemboards.ISDUALCORE, ";
	$mysql = $mysql . " p_s_main_systemboards.NEW_START, ";
	$mysql = $mysql . " p_s_main_systemboards.NEW_END, ";
	$mysql = $mysql . " c_s_cpu.CPUNAME,";
	$mysql = $mysql . " c_s_cpu.CPUNAME as myLabelTest,";
	$mysql = $mysql . " SYSTEMBOARDID as myid";
	$mysql = $mysql . " FROM p_s_main_systemboards ";
	$mysql = $mysql . " INNER JOIN c_s_cpu ON p_s_main_systemboards.CPUID = c_s_cpu.CPUID";
	$mysql = $mysql . " WHERE p_s_main_systemboards.SYSTEMBOARDID ='" . $r_pid . "'";

	if ($m_PType != NULL){
		if(strtoupper($m_PType) == "BB"){
			$mysql = "SELECT p_b_main_serverbarebones.SERVERID,";
			$mysql = $mysql . " p_b_main_serverbarebones.MODELNAME, ";
			$mysql = $mysql . " p_b_main_serverbarebones.SPEC, ";
			$mysql = $mysql . " p_b_main_serverbarebones.CPUSORT, ";
			$mysql = $mysql . " p_b_main_serverbarebones.IMG, ";
			$mysql = $mysql . " p_b_main_serverbarebones.BIGIMG, ";
			$mysql = $mysql . " p_b_main_serverbarebones.UPDATE_USER, ";
			$mysql = $mysql . " p_b_main_serverbarebones.UPDATE_DATE, ";
			$mysql = $mysql . " p_b_main_serverbarebones.STATUS, ";
			$mysql = $mysql . " CONCAT(p_b_main_serverbarebones.MODELNAME,' (',p_b_main_serverbarebones.MODELCODE,')') AS MODEL, ";
			$mysql = $mysql . " CASE WHEN ISDUALCORE = 1 THEN '_DualCore' ELSE '' END AS DUALCORE,";
			$mysql = $mysql . " p_b_main_serverbarebones.MODELCODE, ";
			$mysql = $mysql . " p_b_main_serverbarebones.ISDUALCORE, ";
			$mysql = $mysql . " p_b_main_serverbarebones.NEW_START, ";
			$mysql = $mysql . " p_b_main_serverbarebones.NEW_END, ";
			$mysql = $mysql . " p_b_rackmount.RACKMOUNTNAME, ";
			$mysql = $mysql . " p_b_rackmount.RACKMOUNTNAME as myLabelTest,";
			$mysql = $mysql . " SERVERID as myid";
			$mysql = $mysql . " FROM p_b_main_serverbarebones ";
			$mysql = $mysql . " INNER JOIN p_b_rackmount ON p_b_main_serverbarebones.RACKMOUNTID = p_b_rackmount.RACKMOUNTID ";
			$mysql = $mysql . " WHERE p_b_main_serverbarebones.SERVERID ='" . $r_pid . "'";
		}else if(strtoupper($m_PType) == "HBA"){
			$mysql = " SELECT ";
			$mysql = $mysql . " HBAID, MODELNAME, MODELCODE, SMALLIMG, IMG, BIGIMG, ";
			$mysql = $mysql . " LAUNCH_DATE, NOTES,COMPATIBLE, LANG, ";
			$mysql = $mysql . " UPDATE_USER, UPDATE_DATE, STATUS, ReMark, WebDes, img_c_soon";
			$mysql = $mysql . " FROM  `p_s_main_hba`";
			$mysql = $mysql . " WHERE p_s_main_hba.HBAID ='" . $r_pid . "'";
		}else if(strtoupper($m_PType) == "CHASSIS"){
			$mysql = " SELECT p_r_main_rackchassis.SERVERID,";
			$mysql = $mysql . " p_r_main_rackchassis.MODELNAME, ";
			$mysql = $mysql . " p_r_main_rackchassis.MODELCODE, ";
			$mysql = $mysql . " p_r_main_rackchassis.SPEC, ";
			$mysql = $mysql . " p_r_main_rackchassis.CPUSORT, ";
			$mysql = $mysql . " p_r_main_rackchassis.IMG, ";
			$mysql = $mysql . " p_r_main_rackchassis.BIGIMG, ";
			$mysql = $mysql . " p_r_main_rackchassis.UPDATE_USER, ";
			$mysql = $mysql . " p_r_main_rackchassis.UPDATE_DATE, ";
			$mysql = $mysql . " p_r_main_rackchassis.STATUS, ";
			$mysql = $mysql . " CONCAT(p_r_main_rackchassis.MODELNAME,' (',p_r_main_rackchassis.MODELCODE,')') AS MODEL, ";
			$mysql = $mysql . " CASE WHEN ISDUALCORE = 1 THEN '_DualCore' ELSE '' END AS DUALCORE,";
			$mysql = $mysql . " p_r_rackmount.RACKMOUNTNAME, ";
			$mysql = $mysql . " p_r_rackmount.RACKMOUNTNAME as myLabelTest,";
			$mysql = $mysql . " SERVERID as myid";
			$mysql = $mysql . " FROM `p_r_main_rackchassis`";
			$mysql = $mysql . " INNER JOIN p_r_rackmount ON p_r_main_rackchassis.RACKMOUNTID = p_r_rackmount.RACKMOUNTID ";
			$mysql = $mysql . " WHERE p_r_main_rackchassis.SERVERID ='" . $r_pid . "'";
		}else if(strtoupper($m_PType) == "JBOD"){
			$mysql = " SELECT p_r_main_jbod.SERVERID,";
			$mysql = $mysql . " p_r_main_jbod.MODELNAME, ";
			$mysql = $mysql . " p_r_main_jbod.MODELCODE, ";
			$mysql = $mysql . " p_r_main_jbod.SPEC, ";
			$mysql = $mysql . " p_r_main_jbod.CPUSORT, ";
			$mysql = $mysql . " p_r_main_jbod.IMG, ";
			$mysql = $mysql . " p_r_main_jbod.BIGIMG, ";
			$mysql = $mysql . " p_r_main_jbod.UPDATE_USER, ";
			$mysql = $mysql . " p_r_main_jbod.UPDATE_DATE, ";
			$mysql = $mysql . " p_r_main_jbod.STATUS, ";
			$mysql = $mysql . " CONCAT(p_r_main_jbod.MODELNAME,' (',p_r_main_jbod.MODELCODE,')') AS MODEL, ";
			$mysql = $mysql . " CASE WHEN ISDUALCORE = 1 THEN '_DualCore' ELSE '' END AS DUALCORE,";
			$mysql = $mysql . " p_r_rackmount.RACKMOUNTNAME, ";
			$mysql = $mysql . " p_r_rackmount.RACKMOUNTNAME as myLabelTest,";
			$mysql = $mysql . " SERVERID as myid, ";
			$mysql = $mysql . " p_r_main_jbod.HDD";
			$mysql = $mysql . " FROM `p_r_main_jbod`";
			$mysql = $mysql . " INNER JOIN p_r_rackmount ON p_r_main_jbod.RACKMOUNTID = p_r_rackmount.RACKMOUNTID ";
			$mysql = $mysql . " WHERE p_r_main_jbod.SERVERID ='" . $r_pid . "'";
		}else if(strtoupper($m_PType) == "TPM"){
			$mysql = " SELECT p_s_main_tpm.TPMID,";
			$mysql = $mysql . " p_s_main_tpm.MODELNAME, ";
			$mysql = $mysql . " p_s_main_tpm.MODELCODE, ";
			$mysql = $mysql . " p_s_main_tpm.MINISPEC, ";
			$mysql = $mysql . " p_s_main_tpm.IMG, ";
			$mysql = $mysql . " p_s_main_tpm.BIGIMG, ";
			$mysql = $mysql . " p_s_main_tpm.UPDATE_USER, ";
			$mysql = $mysql . " p_s_main_tpm.UPDATE_DATE, ";
			$mysql = $mysql . " p_s_main_tpm.STATUS, ";
			$mysql = $mysql . " CONCAT(p_s_main_tpm.MODELNAME,' (',p_s_main_tpm.MODELCODE,')') AS MODEL, ";
			$mysql = $mysql . " TPMID as myid";
			$mysql = $mysql . " FROM `p_s_main_tpm`";
			$mysql = $mysql . " WHERE p_s_main_tpm.TPMID ='" . $r_pid . "'";
		}else if(strtoupper($m_PType) == "NIC"){
			$mysql = " SELECT p_s_main_nic.NICID,";
			$mysql = $mysql . " p_s_main_nic.MODELNAME, ";
			$mysql = $mysql . " p_s_main_nic.MODELCODE, ";
			$mysql = $mysql . " p_s_main_nic.MINISPEC, ";
			$mysql = $mysql . " p_s_main_nic.IMG, ";
			$mysql = $mysql . " p_s_main_nic.BIGIMG, ";
			$mysql = $mysql . " p_s_main_nic.UPDATE_USER, ";
			$mysql = $mysql . " p_s_main_nic.UPDATE_DATE, ";
			$mysql = $mysql . " p_s_main_nic.STATUS, ";
			$mysql = $mysql . " CONCAT(p_s_main_nic.MODELNAME,' (',p_s_main_nic.MODELCODE,')') AS MODEL, ";
			$mysql = $mysql . " NICID as myid";
			$mysql = $mysql . " FROM `p_s_main_nic`";
			$mysql = $mysql . " WHERE p_s_main_nic.NICID ='" . $r_pid . "'";
		}else if($m_PType == "GPUMezz"){
			$mysql = " SELECT p_s_main_gpuserver.GPUSID,";
			$mysql = $mysql . " p_s_main_gpuserver.MODELNAME, ";
			$mysql = $mysql . " p_s_main_gpuserver.MODELCODE, ";
			$mysql = $mysql . " p_s_main_gpuserver.MINISPEC, ";
			$mysql = $mysql . " p_s_main_gpuserver.IMG, ";
			$mysql = $mysql . " p_s_main_gpuserver.BIGIMG, ";
			$mysql = $mysql . " p_s_main_gpuserver.UPDATE_USER, ";
			$mysql = $mysql . " p_s_main_gpuserver.UPDATE_DATE, ";
			$mysql = $mysql . " p_s_main_gpuserver.STATUS, ";
			$mysql = $mysql . " CONCAT(p_s_main_gpuserver.MODELNAME,' (',p_s_main_gpuserver.MODELCODE,')') AS MODEL, ";
			$mysql = $mysql . " GPUSID as myid";
			$mysql = $mysql . " FROM `p_s_main_gpuserver`";
			$mysql = $mysql . " WHERE p_s_main_gpuserver.GPUSID ='" . $r_pid . "'";

		}else if($m_PType == "LANMezz"){
			$mysql = " SELECT p_s_main_ocplan.ocpID,";
			$mysql = $mysql . " p_s_main_ocplan.MODELNAME, ";
			$mysql = $mysql . " p_s_main_ocplan.MODELCODE, ";
			$mysql = $mysql . " p_s_main_ocplan.MINISPEC, ";
			$mysql = $mysql . " p_s_main_ocplan.IMG, ";
			$mysql = $mysql . " p_s_main_ocplan.BIGIMG, ";
			$mysql = $mysql . " p_s_main_ocplan.UPDATE_USER, ";
			$mysql = $mysql . " p_s_main_ocplan.UPDATE_DATE, ";
			$mysql = $mysql . " p_s_main_ocplan.STATUS, ";
			$mysql = $mysql . " CONCAT(p_s_main_ocplan.MODELNAME,' (',p_s_main_ocplan.MODELCODE,')') AS MODEL, ";
			$mysql = $mysql . " ocpID as myid";
			$mysql = $mysql . " FROM `p_s_main_ocplan`";
			$mysql = $mysql . " WHERE p_s_main_ocplan.ocpID ='" . $r_pid . "'";

		}else if($m_PType == "StorageMezz"){
			$mysql = " SELECT p_s_main_storagemezz.storagemID,";
			$mysql = $mysql . " p_s_main_storagemezz.MODELNAME, ";
			$mysql = $mysql . " p_s_main_storagemezz.MODELCODE, ";
			$mysql = $mysql . " p_s_main_storagemezz.MINISPEC, ";
			$mysql = $mysql . " p_s_main_storagemezz.IMG, ";
			$mysql = $mysql . " p_s_main_storagemezz.BIGIMG, ";
			$mysql = $mysql . " p_s_main_storagemezz.UPDATE_USER, ";
			$mysql = $mysql . " p_s_main_storagemezz.UPDATE_DATE, ";
			$mysql = $mysql . " p_s_main_storagemezz.STATUS, ";
			$mysql = $mysql . " CONCAT(p_s_main_storagemezz.MODELNAME,' (',p_s_main_storagemezz.MODELCODE,')') AS MODEL, ";
			$mysql = $mysql . " storagemID as myid";
			$mysql = $mysql . " FROM `p_s_main_storagemezz`";
			$mysql = $mysql . " WHERE p_s_main_storagemezz.storagemID ='" . $r_pid . "'";

		}else if($m_PType == "risercard"){
			$mysql = " SELECT p_s_main_risercard.risercardID,";
			$mysql = $mysql . " p_s_main_risercard.MODELNAME, ";
			$mysql = $mysql . " p_s_main_risercard.MODELCODE, ";
			$mysql = $mysql . " p_s_main_risercard.MINISPEC, ";
			$mysql = $mysql . " p_s_main_risercard.IMG, ";
			$mysql = $mysql . " p_s_main_risercard.BIGIMG, ";
			$mysql = $mysql . " p_s_main_risercard.UPDATE_USER, ";
			$mysql = $mysql . " p_s_main_risercard.UPDATE_DATE, ";
			$mysql = $mysql . " p_s_main_risercard.STATUS, ";
			$mysql = $mysql . " CONCAT(p_s_main_risercard.MODELNAME,' (',p_s_main_risercard.MODELCODE,')') AS MODEL, ";
			$mysql = $mysql . " risercardID as myid";
			$mysql = $mysql . " FROM `p_s_main_risercard`";
			$mysql = $mysql . " WHERE p_s_main_risercard.risercardID ='" . $r_pid . "'";

		}
					//echo $mysql;exit();
	}

	$DataList1_cmd=mysqli_query($link_db,$mysql);
	$DataList1_result=mysqli_fetch_row($DataList1_cmd);
	if(strtoupper($m_PType) == "MB" || strtoupper($m_PType) == "BB"){
		$CPUNAME01="[".$DataList1_result[16]."]";
		$CPUSORT01=$DataList1_result[3];
		$IMG01=$DataList1_result[4];
		$FTPIMG01=$DataList1_result[5];
	}else if(strtoupper($m_PType) == "TPM"){
		$CPUNAME01="[]";
		$CPUSORT01="";
		$IMG01=$DataList1_result[4];
		$FTPIMG01=$DataList1_result[5];
	}else if(strtoupper($m_PType) == "NIC"){
		$CPUNAME01="[]";
		$CPUSORT01="";
		$IMG01=$DataList1_result[4];
		$FTPIMG01=$DataList1_result[5];
	}else{
		$CPUNAME01="[".$DataList1_result[13]."]";
		$CPUSORT01=$DataList1_result[3];
		$IMG01=$DataList1_result[4];
		$FTPIMG01=$DataList1_result[5];
	}
}


if($PType_si == "IndustrialPanelPC"){
	$Get_N_SKU_Type="SELECT MODELCODE FROM p_b_main_panelpc WHERE (PANELPCID = ".$r_pid.")";
	$Get_N_SKU_Type_cmd=mysqli_query($link_db,$Get_N_SKU_Type);
	$Get_N_SKU_Type_result=mysqli_fetch_row($Get_N_SKU_Type_cmd);

	$Get_N_SKU_Type_all = "SELECT product_skus.*, ".$r_pid." as pid,'IndustrialPanelPC' as ProductType, CONCAT('IndustrialPanelPC',RTRIM(product_skus.MODELCODE),'_',RTRIM(product_skus.SKU),'') as PSKULINK FROM product_skus INNER JOIN ProductTypes ON product_skus.ProductTypeID = ProductTypes.ProductTypeID INNER JOIN vw_ModelName ON product_skus.MODELCODE = vw_ModelName.ModelCode INNER JOIN p_b_main_panelpc ON product_skus.ModelCode = p_b_main_panelpc.MODELCODE";
	$Get_N_SKU_Type_all = $Get_N_SKU_Type_all . " Where product_skus.MODELCODE like Case When locate('-','".$Get_N_SKU_Type_result[0]."')<>0 Then CONCAT(SUBSTRING('".$Get_N_SKU_Type_result[0]."', 1, locate('-','".$Get_N_SKU_Type_result[0]."')-1) , '%') else CONCAT('".$Get_N_SKU_Type_result[0]."' , '%') End and Web_Disable=0 and LANG='en-US' order by SKU";

	$metaType="Processor Industrial Panel PC";
	$meta="'14','18'"; //condition
	$metaOrder=",14,18,";//ORDER

}else if($PType_si == "EmbeddedSystem"){
	$Get_N_SKU_Type="SELECT MODELCODE FROM p_b_main_embedded WHERE (`EMBEDDEDID` = ".$r_pid.")";
	$Get_N_SKU_Type_cmd=mysqli_query($link_db,$Get_N_SKU_Type);
	$Get_N_SKU_Type_result=mysqli_fetch_row($Get_N_SKU_Type_cmd);

	$Get_N_SKU_Type_all = "SELECT product_skus.*, ".$r_pid." as pid,'EmbeddedSystem' as ProductType, CONCAT('Motherboards_',RTRIM(product_skus.MODELCODE),'_',RTRIM(product_skus.SKU),'') as PSKULINK FROM product_skus INNER JOIN ProductTypes ON product_skus.ProductTypeID = ProductTypes.ProductTypeID INNER JOIN vw_ModelName ON product_skus.MODELCODE = vw_ModelName.ModelCode INNER JOIN p_b_main_embedded ON product_skus.ModelCode = p_b_main_embedded.MODELCODE";
	$Get_N_SKU_Type_all = $Get_N_SKU_Type_all . " Where product_skus.MODELCODE like Case When locate('-','".$Get_N_SKU_Type_result[0]."')<>0 Then CONCAT(SUBSTRING('".$Get_N_SKU_Type_result[0]."', 1, locate('-','".$Get_N_SKU_Type_result[0]."')-1) , '%') else CONCAT('".$Get_N_SKU_Type_result[0]."' , '%') End and Web_Disable=0 and LANG='en-US' order by SKU desc";

	$metaType="Processor Embedded System";
	$meta="'17'"; //condition
	$metaOrder=",17,";//ORDER

}else if($PType_si == "IndustrialMotherboard"){
	$Get_N_SKU_Type="SELECT MODELCODE FROM `p_b_main_industriamb` WHERE (INDUSTRIAMBID = ".$r_pid.")";
	$Get_N_SKU_Type_cmd=mysqli_query($link_db,$Get_N_SKU_Type);
	$Get_N_SKU_Type_result=mysqli_fetch_row($Get_N_SKU_Type_cmd);

	$Get_N_SKU_Type_all = "SELECT product_skus.*, ".$r_pid." as pid,'IndustrialMotherboard' as ProductType, CONCAT('Chassis_',RTRIM(product_skus.MODELCODE),'_',RTRIM(product_skus.SKU),'') as PSKULINK FROM product_skus INNER JOIN producttypes ON product_skus.ProductTypeID = producttypes.ProductTypeID INNER JOIN vw_modelname ON product_skus.MODELCODE = vw_modelname.ModelCode INNER JOIN p_b_main_industriamb ON product_skus.ModelCode = p_b_main_industriamb.MODELCODE";
	$Get_N_SKU_Type_all = $Get_N_SKU_Type_all . " Where product_skus.MODELCODE like Case When locate('-','".$Get_N_SKU_Type_result[0]."')<>0 Then CONCAT(SUBSTRING('".$Get_N_SKU_Type_result[0]."', 1, locate('-','".$Get_N_SKU_Type_result[0]."')-1) , '%') else CONCAT('".$Get_N_SKU_Type_result[0]."' , '%') End and LANG='en-US' and product_skus.sku in (select contents_product_skus.sku from contents_product_skus where contents_product_skus.slang='EN,' and contents_product_skus.modelcode='".$Get_N_SKU_Type_result[0]."' and contents_product_skus.status=1) order by SKU desc"; //mod 20150520

	$metaType="Industrial Motherboard";
	$meta="'2','1'"; //condition
	$metaOrder=",2,1,";//ORDER

}else if($PType_si == "OCPserver"){
	$Get_N_SKU_Type="SELECT MODELCODE FROM `p_b_main_ocpserver` WHERE (OCPID = ".$r_pid.")";
	$Get_N_SKU_Type_cmd=mysqli_query($link_db,$Get_N_SKU_Type);
	$Get_N_SKU_Type_result=mysqli_fetch_row($Get_N_SKU_Type_cmd);

	$Get_N_SKU_Type_all = "SELECT product_skus.*, ".$r_pid." as pid,'OCPserver' as ProductType, CONCAT('JOBD_',RTRIM(product_skus.MODELCODE),'_',RTRIM(product_skus.SKU),'') as PSKULINK FROM product_skus INNER JOIN producttypes ON product_skus.ProductTypeID = producttypes.ProductTypeID INNER JOIN vw_modelname ON product_skus.MODELCODE = vw_modelname.ModelCode INNER JOIN p_b_main_ocpserver ON product_skus.ModelCode = p_b_main_ocpserver.MODELCODE";
	$Get_N_SKU_Type_all = $Get_N_SKU_Type_all . " Where product_skus.MODELCODE like Case When locate('-','".$Get_N_SKU_Type_result[0]."')<>0 Then CONCAT(SUBSTRING('".$Get_N_SKU_Type_result[0]."', 1, locate('-','".$Get_N_SKU_Type_result[0]."')-1) , '%') else CONCAT('".$Get_N_SKU_Type_result[0]."' , '%') End and LANG='en-US' and product_skus.sku in (select contents_product_skus.sku from contents_product_skus where contents_product_skus.slang='EN,' and contents_product_skus.modelcode='".$Get_N_SKU_Type_result[0]."' and contents_product_skus.status=1) order by SKU desc"; //mod 20150520


}else if($PType_si == "OCPMezz"){
	$Get_N_SKU_Type="SELECT MODELCODE FROM `p_b_main_ocpmezz` WHERE (OCPMezzID = ".$r_pid.")";
	$Get_N_SKU_Type_cmd=mysqli_query($link_db,$Get_N_SKU_Type);
	$Get_N_SKU_Type_result=mysqli_fetch_row($Get_N_SKU_Type_cmd);

	$Get_N_SKU_Type_all = "SELECT distinct product_skus.*, ".$r_pid." as pid,'OCPMezz' as ProductType, CONCAT('TPM_',RTRIM(product_skus.MODELCODE),'_',RTRIM(product_skus.SKU),'') as PSKULINK FROM product_skus INNER JOIN producttypes ON product_skus.ProductTypeID = producttypes.ProductTypeID INNER JOIN vw_modelname ON product_skus.MODELCODE = vw_modelname.ModelCode INNER JOIN p_b_main_ocpmezz ON product_skus.ModelCode = p_b_main_ocpmezz.MODELCODE";
	$Get_N_SKU_Type_all = $Get_N_SKU_Type_all . " Where product_skus.MODELCODE like Case When locate('-','".$Get_N_SKU_Type_result[0]."')<>0 Then CONCAT(SUBSTRING('".$Get_N_SKU_Type_result[0]."', 1, locate('-','".$Get_N_SKU_Type_result[0]."')-1) , '%') else CONCAT('".$Get_N_SKU_Type_result[0]."' , '%') End and LANG='en-US' and product_skus.sku in (select contents_product_skus.sku from contents_product_skus where contents_product_skus.slang='EN,' and contents_product_skus.modelcode='".$Get_N_SKU_Type_result[0]."' and contents_product_skus.status=1) order by SKU desc"; //mod 20150520

}else if($PType_si == "JBODJBOF"){
	$Get_N_SKU_Type="SELECT MODELCODE FROM `p_b_main_jbodjbof` WHERE (JBODFID = ".$r_pid.")";
	$Get_N_SKU_Type_cmd=mysqli_query($link_db,$Get_N_SKU_Type);
	$Get_N_SKU_Type_result=mysqli_fetch_row($Get_N_SKU_Type_cmd);

	$Get_N_SKU_Type_all = "SELECT distinct product_skus.*, ".$r_pid." as pid,'JBODJBOF' as ProductType, CONCAT('NIC_',RTRIM(product_skus.MODELCODE),'_',RTRIM(product_skus.SKU),'') as PSKULINK FROM product_skus INNER JOIN producttypes ON product_skus.ProductTypeID = producttypes.ProductTypeID INNER JOIN vw_modelname ON product_skus.MODELCODE = vw_modelname.ModelCode INNER JOIN p_b_main_jbodjbof ON product_skus.ModelCode = p_b_main_jbodjbof.MODELCODE";
	$Get_N_SKU_Type_all = $Get_N_SKU_Type_all . " Where product_skus.MODELCODE like Case When locate('-','".$Get_N_SKU_Type_result[0]."')<>0 Then CONCAT(SUBSTRING('".$Get_N_SKU_Type_result[0]."', 1, locate('-','".$Get_N_SKU_Type_result[0]."')-1) , '%') else CONCAT('".$Get_N_SKU_Type_result[0]."' , '%') End and LANG='en-US' and product_skus.sku in (select contents_product_skus.sku from contents_product_skus where contents_product_skus.slang='EN,' and contents_product_skus.modelcode='".$Get_N_SKU_Type_result[0]."' and contents_product_skus.status=1) order by SKU desc"; //mod 20150520

}else if($PType_si == "OCPRack"){
	$Get_N_SKU_Type="SELECT MODELCODE FROM `p_b_main_ocprack` WHERE (OCPRACKID = ".$r_pid.")";
	$Get_N_SKU_Type_cmd=mysqli_query($link_db,$Get_N_SKU_Type);
	$Get_N_SKU_Type_result=mysqli_fetch_row($Get_N_SKU_Type_cmd);

	$Get_N_SKU_Type_all = "SELECT distinct product_skus.*, ".$r_pid." as pid,'OCPRack' as ProductType, CONCAT('GPUMezz',RTRIM(product_skus.MODELCODE),'_',RTRIM(product_skus.SKU),'') as PSKULINK FROM product_skus INNER JOIN producttypes ON product_skus.ProductTypeID = producttypes.ProductTypeID INNER JOIN vw_modelname ON product_skus.MODELCODE = vw_modelname.ModelCode INNER JOIN p_b_main_ocprack ON product_skus.ModelCode = p_b_main_ocprack.MODELCODE";
	$Get_N_SKU_Type_all = $Get_N_SKU_Type_all . " Where product_skus.MODELCODE like Case When locate('-','".$Get_N_SKU_Type_result[0]."')<>0 Then CONCAT(SUBSTRING('".$Get_N_SKU_Type_result[0]."', 1, locate('-','".$Get_N_SKU_Type_result[0]."')-1) , '%') else CONCAT('".$Get_N_SKU_Type_result[0]."' , '%') End and LANG='en-US' and product_skus.sku in (select contents_product_skus.sku from contents_product_skus where contents_product_skus.slang='EN,' and contents_product_skus.modelcode='".$Get_N_SKU_Type_result[0]."' and contents_product_skus.status=1) order by SKU desc"; //mod 20150520
}else if($PType_si == "POS"){
	$Get_N_SKU_Type="SELECT MODELCODE FROM `p_b_main_pos` WHERE (POSID = ".$r_pid.")";
	$Get_N_SKU_Type_cmd=mysqli_query($link_db,$Get_N_SKU_Type);
	$Get_N_SKU_Type_result=mysqli_fetch_row($Get_N_SKU_Type_cmd);

	$Get_N_SKU_Type_all = "SELECT distinct product_skus.*, ".$r_pid." as pid,'POS' as ProductType, CONCAT('LANMezz',RTRIM(product_skus.MODELCODE),'_',RTRIM(product_skus.SKU),'') as PSKULINK FROM product_skus INNER JOIN producttypes ON product_skus.ProductTypeID = producttypes.ProductTypeID INNER JOIN vw_modelname ON product_skus.MODELCODE = vw_modelname.ModelCode INNER JOIN p_b_main_pos ON product_skus.ModelCode = p_b_main_pos.MODELCODE";
	$Get_N_SKU_Type_all = $Get_N_SKU_Type_all . " Where product_skus.MODELCODE like Case When locate('-','".$Get_N_SKU_Type_result[0]."')<>0 Then CONCAT(SUBSTRING('".$Get_N_SKU_Type_result[0]."', 1, locate('-','".$Get_N_SKU_Type_result[0]."')-1) , '%') else CONCAT('".$Get_N_SKU_Type_result[0]."' , '%') End and LANG='en-US' and product_skus.sku in (select contents_product_skus.sku from contents_product_skus where contents_product_skus.slang='EN,' and contents_product_skus.modelcode='".$Get_N_SKU_Type_result[0]."' and contents_product_skus.status=1) order by SKU desc"; //mod 20150520
}else if($PType_si == "5GEdgeComputing"){
	$Get_N_SKU_Type="SELECT MODELCODE FROM `p_b_main_5G` WHERE (5GID = ".$r_pid.")";
	$Get_N_SKU_Type_cmd=mysqli_query($link_db,$Get_N_SKU_Type);
	$Get_N_SKU_Type_result=mysqli_fetch_row($Get_N_SKU_Type_cmd);

	$Get_N_SKU_Type_all = "SELECT distinct product_skus.*, ".$r_pid." as pid,'5G' as ProductType, CONCAT('LANMezz',RTRIM(product_skus.MODELCODE),'_',RTRIM(product_skus.SKU),'') as PSKULINK FROM product_skus INNER JOIN producttypes ON product_skus.ProductTypeID = producttypes.ProductTypeID INNER JOIN vw_modelname ON product_skus.MODELCODE = vw_modelname.ModelCode INNER JOIN p_b_main_pos ON product_skus.ModelCode = p_b_main_pos.MODELCODE";
	$Get_N_SKU_Type_all = $Get_N_SKU_Type_all . " Where product_skus.MODELCODE like Case When locate('-','".$Get_N_SKU_Type_result[0]."')<>0 Then CONCAT(SUBSTRING('".$Get_N_SKU_Type_result[0]."', 1, locate('-','".$Get_N_SKU_Type_result[0]."')-1) , '%') else CONCAT('".$Get_N_SKU_Type_result[0]."' , '%') End and LANG='en-US' and product_skus.sku in (select contents_product_skus.sku from contents_product_skus where contents_product_skus.slang='EN,' and contents_product_skus.modelcode='".$Get_N_SKU_Type_result[0]."' and contents_product_skus.status=1) order by SKU desc"; //mod 20150520
}else{
	$Get_N_SKU_Type="SELECT MODELCODE, CPUID FROM p_s_main_systemboards WHERE (SYSTEMBOARDID = ".$r_pid.")";
	$Get_N_SKU_Type_cmd=mysqli_query($link_db,$Get_N_SKU_Type);
	$Get_N_SKU_Type_result=mysqli_fetch_row($Get_N_SKU_Type_cmd);

	$Get_N_SKU_Type_all = "SELECT product_skus.*, ".$r_pid." as pid,'MB' as ProductType, CONCAT('Motherboards_',RTRIM(product_skus.MODELCODE),'_',RTRIM(product_skus.SKU),'') as PSKULINK FROM product_skus INNER JOIN ProductTypes ON product_skus.ProductTypeID = ProductTypes.ProductTypeID INNER JOIN vw_ModelName ON product_skus.MODELCODE = vw_ModelName.ModelCode INNER JOIN p_s_main_systemboards ON product_skus.ModelCode = p_s_main_systemboards.MODELCODE";
	$Get_N_SKU_Type_all = $Get_N_SKU_Type_all . " Where product_skus.MODELCODE like Case When locate('-','".$Get_N_SKU_Type_result[0]."')<>0 Then CONCAT(SUBSTRING('".$Get_N_SKU_Type_result[0]."', 1, locate('-','".$Get_N_SKU_Type_result[0]."')-1) , '%') else CONCAT('".$Get_N_SKU_Type_result[0]."' , '%') End and Web_Disable=0 and LANG='en-US' order by SKU desc";
}

//echo "<br /><br /><br /><br /><br /><br />".$Get_N_SKU_Type_all;
$str_getPType="SELECT CategoryModuID, Product_Info FROM `contents_product_skus` where `SKU`='".str_replace(".php","",$PSKUs_si)."'";
$getPType_cmd=mysqli_query($link_db,$str_getPType);
$getPType_data=mysqli_fetch_row($getPType_cmd);
$PR_info=explode(",", $getPType_data[1]);

$str_CategName="SELECT `CategoryModuID`, `CategoryModuName` FROM `category_module_las` where `CategoryModuID`=".$getPType_data[0]." and `slang`='EN'";
$CategName_result=mysqli_query($link_db,$str_CategName);
$CategName_data=mysqli_fetch_row($CategName_result);
if($CategName_data[1]!=''){
	$Category_title=trim($CategName_data[1]).":";
}else{
	$Category_title="";
}

//****************2017/07/18 icon下文字敘述********
$str_pdesc="SELECT `ID`, `NAME`, `DESCS`, `smmarys`, `LANG`, `MODEL`, `STATUS` FROM `spdescription_list` where concat(',',`MODEL`) like '%".$PSKUs_si.",%' and `LANG`='".$PLang_si."' AND STATUS='1'";
$pdesc_cmd=mysqli_query($link_db,$str_pdesc);
$pdesc_data=mysqli_fetch_row($pdesc_cmd);
$name=$pdesc_data[1];
$descs=$pdesc_data[2];
$smmarys=$pdesc_data[3];

if(isset($_COOKIE['status'])){
  //$s_cookie="";
}else{
  $s_cookie=$_COOKIE['status'];
}

//****************2021/05/11 add Breadcrumb BTO ********
$strBTO="";
$compareTypeID="";
$str_bto="SELECT IS_BTO, ProductTypeID FROM product_skus WHERE Product_SKU_Auto_ID='".$m_SKUs."'";
$bto_cmd=mysqli_query($link_db,$str_bto);
$bto_data=mysqli_fetch_row($bto_cmd);
if($bto_data[0]==1){
	$strBTO="&nbsp;(BTO)";
}else{
	$strBTO="";
}
$compareTypeID=$bto_data[1];
//****************2021/05/11 add Breadcrumb BTO end ********

//***** meta name="description" ******
$strInfo="SELECT PIV_id, PI_id, PIV_Value, PIV_Sort FROM product_infovalue_las WHERE 1";
$cmdInfo=mysqli_query($link_db, $strInfo);
while ($dataInfo=mysqli_fetch_array($cmdInfo)) {
	$listInfo[$dataInfo[1]][$dataInfo[0]]=$dataInfo[2];
	$Info[$dataInfo[0]]=$dataInfo[2];
}

$meta_des="";
if($PType_si == "IndustrialPanelPC"){

	$metaType="Processor Industrial Panel PC";
	$meta="'14','18'"; //condition
	$metaOrder=",14,18,";//ORDER

}else if($PType_si == "EmbeddedSystem"){

	$metaType="Processor Embedded System";
	$meta="'17'"; //condition
	$metaOrder=",17,";//ORDER

}else if($PType_si == "IndustrialMotherboard"){

	$metaType="Industrial Motherboard";
	$meta="'2','1'"; //condition
	$metaOrder=",2,1,";//ORDER

}else if($PType_si == "OCPserver"){
	$metaType="OCP Server";
	$meta_des.=$PSKUs_si." (".$PMCode_si.") ".$metaType;
}else if($PType_si == "OCPMezz"){
	$metaType="OCP Mezz Card";
	$meta_des.=$PSKUs_si." ".$metaType;
}else if($PType_si == "JBODJBOF"){
	$metaType="JBOD / JBOF";
	$meta_des.=$PSKUs_si." (".$PMCode_si.") ".$metaType;
}else if($PType_si == "OCPRack"){
	$metaType="OCP Rack";
	$meta_des.=$PSKUs_si." ".$metaType;
}else if($PType_si == "POS"){
	$metaType="Point of Sale (POS) Tablet ";
	$meta_des.=$PSKUs_si." ".$metaType;
}else if($PType_si == "5GEdgeComputing"){
	$metaType="5G Edge Computing Server";
	$meta_des.=$PSKUs_si." (".$PMCode_si.") ".$metaType;
}

if($PType_si == "IndustrialPanelPC" || $PType_si == "EmbeddedSystem" || $PType_si == "IndustrialMotherboard"){
	$meta_des=$PSKUs_si." - ";
	$strInfoTitle="SELECT PI_id, PI_Name FROM product_info_las WHERE PI_id IN (".$meta.")";
	$strInfoTitle.=" ORDER BY INSTR('".$metaOrder."',CONCAT(',',PI_id,','))";
	$cmdInfoTitle=mysqli_query($link_db, $strInfoTitle);
	while ($dataInfoTitle=mysqli_fetch_array($cmdInfoTitle)) {

		foreach ($PR_info as $key => $value) {
			if($value!="" && $listInfo[$dataInfoTitle[0]][$value]!=""){
				$meta_des.=$listInfo[$dataInfoTitle[0]][$value]."&nbsp;";
			}
		}

	}
	$meta_des.=$metaType;
}


//***** meta name="description" end ******
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<meta name='author' content='MiTAC Digital Technology'>
	<meta name="company" content="MiTAC Digital Technology">
	<meta name="description" content="<?=$meta_des;?>">
	<meta property="og:type" content="website" />
	<meta property="og:description" content="" />
	<meta property="og:title" content="<?=$meta_des;?> | MiTAC Digital Technology" />
    <link rel="shortcut icon" href="/images/ico/favicon.ico">

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
	<link rel="stylesheet" href="css1/product.css" type="text/css" />
    <link rel="stylesheet" href="css1/stylesheet1.css" type="text/css" /> 

	<!-- Document Title
	============================================= -->
	<title><?=$meta_des;?> | MiTAC Digital Technology</title>
	<?php
	//************判斷語系載入 google analytics ************
	if($s_cookie!=2){
	  include_once("analyticstracking.php");
	}
	?>

</head>

<body class="stretched">

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">
		<?php
		if($PLang_si=="en-US"){
			include("top1.htm");
		}else if($PLang_si=="ja-JP"){
			include("top_jp.htm");
		}else if($PLang_si=="zh-CN"){
			include("top_cn.htm");
		}else if($PLang_si=="zh-TW"){
			include("top_zh.htm");
		}
		?>



		<!-- Content
		============================================= -->

		<!--breadcrumb-->

		<section id="page-title">
			<div class="container clearfix">
				<h2><?=$PSKUs_si;?> (<?=$PMCode_si;?>) <?=$BTO;?> <?=$EOL;?></h2>
				<ol class="breadcrumb">
					<li class="breadcrumb-item">Products</li>
					<li class="breadcrumb-item"><a href="<?=$siName_url;?>"><?=$PType_si?></a></li>
					<li class="breadcrumb-item active" aria-current="page"><?=$PSKUs_si;?></li>
				</ol>
			</div>

		</section>

		<!--end breadcrumb-->

		<!--images + product briefing-->
		<?php
		/* Mod 20150520 Start */
		$legend_val01="";
		//2017.08.03 新增MODELCODE條件
		$str_Pimg="SELECT `ProductFile`, `ProductBFile`,`MODELDESCRIPT`, `legend_val` FROM `contents_product_skus` where `SKU`='".str_replace(".php","",$PSKUs_si)."' and `MODELCODE`='".str_replace(".php","",$PMCode_si)."'";
		$Pimg_cmd=mysqli_query($link_db,$str_Pimg);
		$Ping_data=mysqli_fetch_row($Pimg_cmd);
		$legend_val01=$Ping_data[3];
		/* Mod 20150520 End */
		$image_arr=explode(",",$Ping_data[0]); //多圖切割
		$arr_num=count($image_arr);
		//echo $Ping_data[1];
		?>
		<div class="section bg-transparent">
			<div class="container clearfix">
				<div class="row clearfix">
					<div class="col-lg-5">
						<div class="product" style="border: none">
							<div class="product-image position-relative">
								<div class="fslider" data-arrows="false" data-pagi="false" data-speed="400" data-pause="6000" data-thumbs="true">
									<div class="flexslider">
										<div class="slider-wrap">
											<?php
											if($arr_num>1){
												for($i=0; $i<$arr_num; $i++) {
													if($image_arr[$i]!=""){
													?>
													<div class="slide" data-thumb="<?=$prod_imgurl.$image_arr[$i]?>">
														<img src="<?=$prod_imgurl.$image_arr[$i]?>" alt="<?=$PType_si;?> - <?=$PSKUs_si;?>">
													</div>
													<?php
													}
												}
											}else{
												if($Ping_data[0]!=''){
												?>
													<img src="<?php	echo $prod_imgurl.$Ping_data[0];?>" />
													<!-- <br /> <br /> <span class="label label-default"><?//=$legend_val01;?></span> -->
													<!-- <a href="<?//=$Ping_data[1];?>" target="tyan" /><img src="../images/icon_zoomin.gif" title="Click to Download"  /></a> -->
													<?php
												}else{
													?>
													<a href="<?=$FTPIMG01;?>" target="tyan" /><img src="../images/icon_zoomin.gif" title="Click to Download"  /></a><br /> <br /> <span class="label label-default"><?=$legend_val01;?></span>
													<a href="<?=$FTPIMG01;?>" target="tyan" /><img src="../images/icon_zoomin.gif" title="Click to Download"  /></a>
													<?php
												}

											}
											?>

										</div>
									</div>
								</div>
								<div class="row clearfix">
									<div class="col-lg-10">
										<!--image legend-->
										<div class="t-left" style="color:#898989; line-height: 110%; font-size: 0.9rem; padding-top: 5%;">
											<?=$legend_val01;?>
										</div>
										<!--end image legend-->
									</div>
									<div class="col-lg-2">
									<!--big photo-->
									<div class="t-left t-3rem">
										<a href="<?=$Ping_data[1];?>" title="Click to view large images" target="_blank"><i class="icon-zoom-in"></i></a>
									</div>
									<!--end big photo-->
									</div>

								</div>
							</div>
						</div>

					</div>
					<div class="col-lg-5 offset-lg-1">
						<div class="featured-item topmargin">
							<div class="item-title">
								<div class="fw-semibold 2s1"><a href="#" style="color: #aab7bd !important;"><?=$PType_si;?> </a></div>
								<h3><?=$PSKUs_si;?> (<?=$PMCode_si;?>)  <?=$BTO;?> <?=$EOL;?></h3>
							</div>
							<!--Icons Top-->
							<div class="bottommargin-sm">
								<?php
								$PIcons_str="SELECT `Product_Icons`, `Product_Icons_b` FROM `contents_product_skus` WHERE `SKU`='".str_replace(".php","",$PSKUs_si)."'";
								$PIcons_cmd=mysqli_query($link_db,$PIcons_str);
								$PIcons_data=mysqli_fetch_row($PIcons_cmd);
								$PIcons_split=explode(",",$PIcons_data[0],-1);
								//***************2018.02.12 修改icon排序***************
								$a="";
								foreach ($PIcons_split as $PIcons_split_all) {
									if($a==Null){
										$a = "'./images/logo/".$PIcons_split_all."'";
									}else{
										$a.= ",'./images/logo/".$PIcons_split_all."'";
									}
								}
								$CPS_str="SELECT `img`,`url`, `tooltips` FROM `c_sp_icon` where `img` IN (".$a.") ORDER BY `c_sp_icon`.`order` ASC";
								$CPS_cmd=mysqli_query($link_db,$CPS_str);
								while($CPS_result=mysqli_fetch_row($CPS_cmd)){
									if(trim($CPS_result[1])!='' && $CPS_result[1]!='http://'){
										$imgname=str_replace("./","",$CPS_result[0]);
										echo "<a href='".$CPS_result[1]."' target='icons' /><img src=".$imgname." data-bs-toggle='tooltip' data-bs-placement='top'></a>&nbsp;";
									}else{
										$imgname=str_replace("./","",$CPS_result[0]);
										//echo "<img src=".$imgname." data-toggle='tooltip' data-placement='bottom' data-html='true' title='$CPS_result[2]'>&nbsp;";
										echo "<img src=".$imgname." data-bs-toggle='tooltip' data-bs-placement='top' title='$CPS_result[2]'>&nbsp;";
									}
								}
								?>
							</div>
							<!--end Icons Top-->

							<div class="clear"></div>
							<!--Product Description -> Summary-->

							<div class="item-desc">
							<?=$smmarys;?>
							</div>

							<!--end Product Description -> Summary-->
							<div class="clear"></div>
							<!--Icons Bottom-->
							<div class="topmargin-sm bottommargin-sm">
								<?php
								// $PIcons_split_b=explode(",",$PIcons_data[1],-1);
								// //***************2018.02.12 修改icon排序***************
								// $a="";
								// foreach ($PIcons_split_b as $PIcons_split_all_b) {
								// 	if($a==Null){
								// 		$a = "'./images/logo/".$PIcons_split_all_b."'";
								// 	}else{
								// 		$a.= ",'./images/logo/".$PIcons_split_all_b."'";
								// 	}
								// }
								// $CPS_b_str="SELECT `img`, `url`, `tooltips` FROM `c_sp_icon` where `img` IN (".$a.") ORDER BY `c_sp_icon`.`order` ASC";
								// $CPS_b_cmd=mysqli_query($link_db,$CPS_b_str);
								// while($CPS_b_result=mysqli_fetch_row($CPS_b_cmd)){
								// 	if(trim($CPS_b_result[1])!='' && $CPS_b_result[1]!='http://'){
								// 		$imgname=str_replace("./","",$CPS_b_result[0]);
								// 		echo "<a href='".$CPS_b_result[1]."' target='icons' /><img src=".$imgname." data-bs-toggle='tooltip' data-bs-placement='top'/></a>&nbsp;";
								// 	}else{
								// 		$imgname=str_replace("./","",$CPS_b_result[0]);
								// 		//echo "<img src=".$imgname." data-toggle='tooltip' data-placement='bottom' data-html='true' title='$CPS_b_result[2]'>&nbsp;";
								// 		echo "<img src=".$imgname." data-bs-toggle='tooltip' data-bs-placement='top' title='$CPS_b_result[2]'>&nbsp;";
								// 	}
								// }
								?>
							</div>
							<!--end Icons Bottom-->
							<div class="clear"></div>
							<?php
							if($COMPARE==1){
							?>
							<div class="button button-border button-circle m-0" onclick="add_compare('<?=$PSKUs_si?>','<?=$compareTypeID?>')"><i class="icon-line-plus"></i>Compare</div>&nbsp;
							<?php
							}
							if($REQUEST_QUOTE==1 && $EOLBox!=1){
							?>
							<div class="button button-border button-circle m-0" onclick="AddRFQ('<?=$PSKUs_si?>','<?=$compareTypeID?>')"><i class="icon-line-dollar-sign"></i>Request Quote</div>
							<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--end images + product briefing-->


		<!--product tabs-->
		<div class="section bg-transparent">
			<div class="container clearfix">
				<div class="row clearfix">
					<div class="col-lg-12">

						<div class="tabs tabs-bb tabs-bordered clearfix">

							<ul class="tab-nav clearfix">
								<?php
								//------ description tab -----------
								$str_pdesc="SELECT `ID`, `NAME`, `DESCS`, `smmarys`, `LANG`, `MODEL`, `STATUS` FROM `spdescription_list` where concat(',',`MODEL`) like '%".$PSKUs_si.",%' and `STATUS`=1 and LANG='".$PLang_si."'";
								//echo $str_pdesc;
								$pdesc_cmd=mysqli_query($link_db,$str_pdesc);
								$pdesc_data=mysqli_fetch_row($pdesc_cmd);
								if($pdesc_data==true){
									if($pdesc_data[2]=="" || $pdesc_data[2]=="NULL"){

									}else{
										echo "<li><a href='#Overview'>".$PDName01."</a></li>";
									}

								}
								//------ description tab end -----------
								//----- SPEC -------
								echo "<li><a href='#SPEC'>".$SPECName01."</a></li>";
								//----- SPEC end-------

								//----- Doc -------
								$Dashe01="SELECT ID FROM `sp_datasheet` WHERE ((STATUS = 1) AND (MODEL LIKE '%".$PMCode_si.",%')) ORDER BY FILEDATE DESC";
								$Dashe01_cmd=mysqli_query($link_db,$Dashe01);
								$Dashe01_data=mysqli_fetch_row($Dashe01_cmd);
								if($Dashe01_data==true){
									$Dashe01_num=mysqli_num_rows($Dashe01_cmd);
								}else{
									$Dashe01_num=0;
								}

								$Manu01="SELECT ID FROM `sp_manual` WHERE ((STATUS = 1) AND (MODEL LIKE '%".$PMCode_si.",%')) ORDER BY FILEDATE DESC";
								$Manu01_cmd=mysqli_query($link_db,$Manu01);
								$Manu01_data=mysqli_fetch_row($Manu01_cmd);
								if($Manu01_data==true){
									$Manu01_num=mysqli_num_rows($Manu01_cmd);
								}else{
									$Manu01_num=0;
								}

								$Fru01="SELECT ID FROM `sp_fru` WHERE ((STATUS = 1) AND (MODEL LIKE '%".$PMCode_si.",%')) ORDER BY FILEDATE DESC";
								$Fru01_cmd=mysqli_query($link_db,$Fru01);
								$Fru01_data=mysqli_fetch_row($Fru01_cmd);
								if($Fru01_data==true){
									$Fru01_num=mysqli_num_rows($Fru01_cmd);
								}else{
									$Fru01_num=0;
								}

								if($Dashe01_num>0 || $Manu01_num>0 || $Fru01_num>0 ){
									$doc_display=1;
									echo "<li><a href='#Docs'>".$DMName01."</a></li>";
								}
								//----- Doc end-------

								//----- BIOS -------
								$BIOS01="SELECT `ID` FROM `sp_bios` WHERE ((STATUS = 1) AND (MODEL LIKE '%".$PMCode_si.",%' or MODEL LIKE '%".$PSKUs_si."%'))ORDER BY FILEDATE DESC";
								$BIOS01_cmd=mysqli_query($link_db,$BIOS01);
								$BIOS01_data=mysqli_fetch_row($BIOS01_cmd);
								if($BIOS01_data==true){
									$BIOS01_num=mysqli_num_rows($BIOS01_cmd);
								}else{
									$BIOS01_num=0;
								}

								$DRVER01="SELECT `ID` FROM `sp_driver` WHERE ((STATUS = 1) AND (MODEL LIKE '%".$PMCode_si.",%' or MODEL LIKE '%".$PSKUs_si."%'))ORDER BY FILEDATE DESC";
								$DRVER01_cmd=mysqli_query($link_db,$DRVER01);
								$DRVER01_data=mysqli_fetch_row($DRVER01_cmd);
								if($DRVER01_data==true){
									$DRVER01_num=mysqli_num_rows($DRVER01_cmd);
								}else{
									$DRVER01_num=0;
								}

								if($BIOS01_num>0 || $DRVER01_num>0 ){
									$BIOS_display=1;
									echo "<li><a href='#Downloads'>".$DLName01."</a></li>";
								}
								//----- BIOS end-------

								//----- Support / AVL ------
								$Memry01="SELECT `ID` FROM `sp_memory` WHERE ((STATUS = 1) AND (MODEL LIKE '%".$PMCode_si.",%')) ORDER BY `ID` DESC";
								$Memry01_cmd=mysqli_query($link_db,$Memry01);
								$Memry01_data=mysqli_fetch_row($Memry01_cmd);
								if($Memry01_data==true){
									$Memry01_num=mysqli_num_rows($Memry01_cmd);
								}else{
									$Memry01_num=0;
								}
								$Hdd01="SELECT `ID` FROM `sp_hdd` WHERE ((STATUS = 1) AND (MODEL LIKE '%".$PMCode_si.",%')) ORDER BY `ID` DESC";
								$Hdd01_cmd=mysqli_query($link_db,$Hdd01);
								$Hdd01_data=mysqli_fetch_row($Hdd01_cmd);
								if($Hdd01_data==true){
									$Hdd01_num=mysqli_num_rows($Hdd01_cmd);
								}else{
									$Hdd01_num=0;
								}
								$str_spcpulist="SELECT `ID`, `List_NAME`, `Label_NAME`, `Url`, `MODEL`, `STATUS` FROM `sp_list` where instr(`MODEL`,'".str_replace(".php","",$PSKUs_si)."')>0";
								$spcpulist_cmd=mysqli_query($link_db,$str_spcpulist);
								$spcpulist_data=mysqli_fetch_row($spcpulist_cmd);
								if($spcpulist_data==true){
									$spcpulist_num=mysqli_num_rows($spcpulist_cmd);
								}else{
									$spcpulist_num=0;
								}
								if($Memry01_num>0 || $Hdd01_num>0 || $spcpulist_num>0){
									$AVL_display=1;
									echo "<li><a href='#AVL'>".$SPName01."</a></li>";
								}
								//----- Support / AVL end------

								//----- PR ------
								$str_prchk="SELECT `MODEL` FROM `sp_pressreview` where `STATUS`='1' and (`MODEL` like '%".$PMCode_si."%' or `MODEL` like '%".str_replace(".php","",$PSKUs_si)."%') order by `UPDATE_DATE` desc";
								$prchk_cmd=mysqli_query($link_db,$str_prchk);
								$prchk_data=mysqli_fetch_row($prchk_cmd);
								if($prchk_data==true){
									$PRlist_num=mysqli_num_rows($prchk_data);
								}else{
									$PRlist_num=0;
								}
								if($PRlist_num>0 ){
									$PR_display=1;
									echo "<li><a href='#Downloads'>".$PRName01."</a></li>";
								}
								//----- PR end------

								$tab_contant="";
								//******* 2018.03.01 $PSKUs_si ADD ."," *****************
								$str_exp="SELECT `ID`, `DESNAME`, `NAME`, `DESCS`, `RETURN_URL`, `URL` FROM `spexptabs_list` WHERE instr(`MODEL`,'".str_replace(".php","",$PSKUs_si.",")."')>0 and `LANG`='".$PLang_si."' and `STATUS`=1";
								//echo $str_exp;
								$exp_cmd=mysqli_query($link_db,$str_exp);
								$i=1;
								while($exp_data=mysqli_fetch_row($exp_cmd)){
									$i+=11;
									if($exp_data[4]==0){
										$exptag=0;
										echo "<li><a href='#dt".$i."' data-toggle='tab'>".$exp_data[2]."</a></li>";
										$tab_contant.="<div class='tab-pane' id=dt".$i.">".trim($exp_data[3])."</div>";

									}else if($exp_data[4]==1){
										$exptag=1;

										echo "<li id='qq'><a href='#dt".$i."' onclick=tagblank('".$exp_data[5]."')>".$exp_data[2]."</a></li>";
										$tab_contant.="<div class='tab-pane' id=dt".$i."></div>";
									}
								}
								?>
							</ul>

							<div class="tab-container">
								<?php
								if($descs!=""){
								?>
								<!--Product Description -> Description-->
								<div class="tab-content clearfix" id="Overview">
									<div class="col-padding">
										<div style="padding:20px">
											<!--<h1><?//=$PSKUs_si?></h1><h2 style="color:#0D47A1; line-height:120%">Slim &amp; Sleek Design</h2><br />-->
											<?=$descs;?>
										</div>
									</div>

								</div>
								<!--end Product Description -> Description-->
								<?php
								}
								?>


								<!--SPEC-->
								<div class="tab-content clearfix" id="SPEC">
									<div class="col-padding">

										<!--Product Brief start -->
										<div class="table-responsive">
											<table class="group_skus table-responsive bottommargin">
												<thead >
													<tr style="border: none;">
														<th colspan="20">
															<h2><?=$PSKUs_si?> (<?=$PMCode_si?>)  <?=$BTO?> <?=$EOL?> &nbsp;
																<!--<button class="button button-border button-circle m-0"><i class="icon-line-plus"></i>Compare</button>-->
															</h2>
														</th>
													</tr>
												</thead>

												<!--Product Brief -> Brief -->
												<?php
												$str_brief="select `ID`, `brief`, `MODEL` from `spbrief_list` where instr(`MODEL`,'".str_replace(".php","",$PSKUs_si).",')>0 and `LANG`='".$PLang_si."' and `STATUS`='1'";
												$brief_cmd=mysqli_query($link_db,$str_brief);
												$brief_data=mysqli_fetch_row($brief_cmd);
												if($brief_data==true){
													echo $brief_data[1];
												}else{

												}
												?>
												<!--end Product Brief -> Brief -->
											</table>
										</div>
										<!--Product Brief start end-->

										<!--product SPEC start -->
										<div class="table-responsive">
											<table class="pro_spec table-responsive table-striped">

												<thead>
													<tr>
														<th colspan="4"><?=$PSKUs_si?> (<?=$PMCode_si?>) Specifications <?=$BTO?> <?=$EOL?></th>
													</tr>
												</thead>

												<tbody class="greybg">
													<!--product SPEC-->
													<?php
													$str_SKUs="SELECT `SKU_CategorySort` FROM `product_skus` WHERE `Product_SKU_Auto_ID`=".$m_SKUs;

													$SKUs_cmd=mysqli_query($link_db,$str_SKUs);
													$SKUs_data=mysqli_fetch_row($SKUs_cmd);

													$SKUs_data_split=explode(',',$SKUs_data[0],-1);
													$CategorySort_Vals=substr($SKUs_data[0],0,strlen($SKUs_data[0])-1);

													if($CategorySort_Vals!=''){
														$str_STN="SELECT a.Product_SKU_Auto_ID,b.SPECCategoryName,a.SPECTypeName,a.CParentSpec,a.CSPECValue,a.ParentSpec,b.SPECCategoryID, a.ParentSort, a.SPECTypeSort From sp".$m_SKUs." a inner join `speccategroies` b on a.SPECCategoryID=b.SPECCategoryID WHERE a.SPECCategoryID in (".substr($CategorySort_Vals, 0, strlen($CategorySort_Vals)).") order by FIELD(a.SPECCategoryID,".substr($CategorySort_Vals, 0, strlen($CategorySort_Vals))."),a.ParentSort, a.`SPECTypeSort`"; //mysql in 排序 也可以按照in裡面的順序作排序
													}else{
														$str_STN="SELECT a.Product_SKU_Auto_ID,b.SPECCategoryName,a.SPECTypeName,a.CParentSpec,a.CSPECValue,a.ParentSpec,b.SPECCategoryID, a.ParentSort, a.SPECTypeSort From sp".$m_SKUs." a inner join `speccategroies` b on a.SPECCategoryID=b.SPECCategoryID order by a.SPECCategoryID"; //20150310 Mod 依據排序
													}
													$cmd=mysqli_query($link_db,$str_STN);
													//**********20180308 判斷是否有ParentSort欄位*************
													if(!$cmd){
														if($CategorySort_Vals!=''){
															$str_STN="SELECT a.Product_SKU_Auto_ID,b.SPECCategoryName,a.SPECTypeName,a.CParentSpec,a.CSPECValue,a.ParentSpec,b.SPECCategoryID From sp".$m_SKUs." a inner join `speccategroies` b on a.SPECCategoryID=b.SPECCategoryID WHERE a.SPECCategoryID in (".substr($CategorySort_Vals, 0, strlen($CategorySort_Vals)).") order by FIELD(a.SPECCategoryID,".substr($CategorySort_Vals, 0, strlen($CategorySort_Vals))."),a.SPECTypeID"; //mysql in 排序 也可以按照in裡面的順序作排序
													 	}else{
															$str_STN="SELECT a.Product_SKU_Auto_ID,b.SPECCategoryName,a.SPECTypeName,a.CParentSpec,a.CSPECValue,a.ParentSpec,b.SPECCategoryID From sp".$m_SKUs." a inner join `speccategroies` b on a.SPECCategoryID=b.SPECCategoryID order by a.SPECCategoryID"; //20150310 Mod 依據排序
														}
														$cmd=mysqli_query($link_db,$str_STN);
													}
													//**********20180308 判斷是否有ParentSort欄位 end*************
													while($data=mysqli_fetch_row($cmd)){

														echo "<tr>";
														$str_SPCA="select SPECCategoryID,SPECCategoryName,count(SPECCategoryID) as SPECCategoryCount from speccategroies where SPECCategoryName='".$data[1]."'";

														$SPCA_cmd=mysqli_query($link_db,$str_SPCA);
														$cadata=mysqli_fetch_row($SPCA_cmd);

														if(empty($cadata)):

														else:

															if(isset($SPV[$data[6]])!=''):

															else:
																$SPV[$data[6]]=0;
															endif;
															$SPV[$data[6]]+=1;
															if($SPV[$data[6]]==1){
																if($data[1]!='Graphic' || $data[1]!='Input /Output'){
																	echo "<td class='dot01' rowspan=".SPEC_Toal($m_SKUs,$data[6],$db_host,$db_user,$db_pwd,$dataBase).">".$data[1]."</td>";
																}
															}
														endif;

														//*********20170914 ADD合併欄位********
														if ($data[5]!="") {
															if ($SPV[$data[5]]=="") {
															$SPV[$data[5]]=0;
															}
															$SPV[$data[5]]+=1;
															if($SPV[$data[5]]==1){
																$strtype="SELECT COUNT(a.ParentSpec) From sp".$m_SKUs." a inner join `speccategroies` b on a.SPECCategoryID=b.SPECCategoryID WHERE a.ParentSpec = '".$data[5]."' order by a.SPECCategoryID ";
																$SPCA_type=mysqli_query($link_db,$strtype);
																$typedata=mysqli_fetch_row($SPCA_type);
																echo "<td rowspan=".$typedata[0].">".$data[3]."</td>"; //Web第二層
															}else{
															}
														}else{
															echo "<td>".$data[3]."</td>";
														}

														//*********20170914 合併欄位 END********
														echo "<td>".$data[2]."</td>";
														echo "<td>".$data[4]."</td>"; // All SPEC
														echo "</tr>";
													}
													?>
													<!--end product SPEC-->
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<!--SPEC end-->

								<?php
								if($doc_display==1){
								?>
								<div class="tab-content clearfix" id="Docs">
									<div class="col-padding">
									<!--Docs contents-->
									<?php
									$Dt01="";$Ma01="";$Fu01="";
	  							$str_c_itemlist="SELECT ID, NAME, LINK, IMG FROM c_sp_itemlist where ID in (6,7,9) ORDER BY FIELD(ID,7,6,9)";
	  							$c_itemlist_cmd=mysqli_query($link_db,$str_c_itemlist);
								  $citem=0;
								  while($c_itemlist_data=mysqli_fetch_row($c_itemlist_cmd)){
								    $citem+=1;

								    if($c_itemlist_data[1]=="Manuals"){

									    $str_man="SELECT Count(*) FROM sp_manual WHERE ((STATUS = '1') AND (MODEL LIKE '%".$PMCode_si.",%'))";
									    $cmd_man=mysqli_query($link_db,$str_man);
									  	$data_man=mysqli_fetch_row($cmd_man);
									  	if($data_man[0]!=0){
									  		echo "<h3>".$c_itemlist_data[1]."</h3>";
									  		echo "<table class='table  table-hover'>";
									  		echo "<thead>
												  		<tr>
												  		<th>Date</th>
												  		<th>File Name</th>
												  		<th></th>
												  		</tr>
												  		</thead>";
												echo "<tbody>";
												$Manu_strlist="SELECT ID, FILENAME, FILEDATE, DESCRIPTION, VERSION, PATH, FILESIZE FROM sp_manual WHERE ((STATUS = 1) AND (MODEL LIKE '%".$PMCode_si.",%')) ORDER BY FILEDATE DESC";
											  $Manu_listcmd=mysqli_query($link_db,$Manu_strlist);
											  while($Manu_LData=mysqli_fetch_row($Manu_listcmd)){
											  	putenv("TZ=Asia/Taipei");
											  	echo "<tr>";
											  	echo "<td>".date("Y/m/d",strtotime($Manu_LData[2]))."</td>";
											  	echo "<td>".$Manu_LData[1]."<span style='display: none;'>(".$Manu_LData[6].")</span>";
											  	echo "<div style='color:#898989; font-style: italic; font-size: 0.8rem; display: none;'>Version: ".$Manu_LData[4]."</div>";
													echo "</td>";
													echo "<td><a href=".$Manu_LData[5]." target='blank' /><i class='i-rounded icon-file-alt2' style='background-color:#004898; font-size: 2rem;'></i></a></td>";
													echo "</tr>";
												}
												echo "</tbody>";
												echo "</table>";
												echo "<div class='line bottommargin'></div>";
											}

									  }else if($c_itemlist_data[1]=="Datasheets"){

									    $str_ds="SELECT Count(*) FROM sp_datasheet WHERE ((STATUS = '1') AND (MODEL LIKE '%".$PMCode.",%'))";
									    $cmd_ds=mysqli_query($link_db,$str_ds);
									  	$data_ds=mysqli_fetch_row($cmd_ds);
									  	if($data_ds[0]!=0){

									  	 	echo "<h3>".$c_itemlist_data[1]."</h3>";
									  		echo "<table class='table  table-hover'>";
									  		echo "<thead>
												  		<tr>
												  		<th>Date</th>
												  		<th>File Name</th>
												  		<th></th>
												  		</tr>
												  		</thead>";
												echo "<tbody>";
												$Dashe_strlist="SELECT ID, FILENAME, FILEDATE, DESCRIPTION, VERSION, PATH, FILESIZE FROM sp_datasheet WHERE ((STATUS = 1) AND (MODEL LIKE '%".$PMCode_si.",%'))ORDER BY FILEDATE DESC";
											  $Dashe_listcmd=mysqli_query($link_db,$Dashe_strlist);
											  while($Dashe_LData=mysqli_fetch_row($Dashe_listcmd)){
											  	putenv("TZ=Asia/Taipei");
											  	echo "<tr>";
											  	echo "<td>".date("Y/m/d",strtotime($Dashe_LData[2]))."</td>";
											  	echo "<td>".$Dashe_LData[1]."<span style='display: none;'>(".$Dashe_LData[6].")</span>";
											  	echo "<div style='color:#898989; font-style: italic; font-size: 0.8rem; display: none;'>Version: ".$Dashe_LData[4]."</div>";
													echo "</td>";
													echo "<td><a href=".$Dashe_LData[5]." target='blank' /><i class='i-rounded icon-file-alt2' style='background-color:#004898; font-size: 2rem;'></i></a></td>";
													echo "</tr>";
												}
												echo "</tbody>";
												echo "</table>";
												echo "<div class='line bottommargin'></div>";

									    }

									  }else if($c_itemlist_data[1]=="FRU"){

									    $str_fru="SELECT Count(*) FROM sp_fru WHERE ((STATUS = '1') AND (MODEL LIKE '%".$PMCode_si.",%'))";
									    $cmd_fru=mysqli_query($link_db,$str_fru);
									  	$data_fru=mysqli_fetch_row($cmd_fru);
									  	if($data_fru[0]!=0){
									  		echo "<h3>".$c_itemlist_data[1]."</h3>";
									  		echo "<table class='table  table-hover'>";
									  		echo "<thead>
												  		<tr>
												  		<th>Date</th>
												  		<th>File Name</th>
												  		<th></th>
												  		</tr>
												  		</thead>";
												echo "<tbody>";
												$Fru_strlist="SELECT ID, FILENAME, FILEDATE, DESCRIPTION, VERSION, PATH, FILESIZE FROM `sp_fru` WHERE ((STATUS = 1) AND (MODEL LIKE '%".$PMCode_si.",%')) ORDER BY FILEDATE DESC";
											  $Fru_listcmd=mysqli_query($link_db,$Fru_strlist);
											  while($Fru_LData=mysqli_fetch_row($Fru_listcmd)){
											  	putenv("TZ=Asia/Taipei");
											  	echo "<tr>";
											  	echo "<td>".date("Y/m/d",strtotime($Fru_LData[2]))."</td>";
											  	echo "<td>".$Fru_LData[1]."<span style='display: none;'>(".$Fru_LData[6].")</span>";
											  	echo "<div style='color:#898989; font-style: italic; font-size: 0.8rem; display: none;'>Version: ".$Fru_LData[4]."</div>";
													echo "</td>";
													echo "<td><a href=".$Fru_LData[5]." target='blank' /><i class='i-rounded icon-file-alt2' style='background-color:#004898; font-size: 2rem;'></i></a></td>";
													echo "</tr>";
												}
												echo "</tbody>";
												echo "</table>";
												echo "<div class='line bottommargin'></div>";
											}
									  }
									}
									?>
									<!--end Docs-->
									</div>
								</div>
								<?php
								}

								//--- Support ----

								if($AVL_display==1){
								?>
								<div class="tab-content clearfix" id="AVL">
									<div class="col-padding">
										<h3>Support / AVL</h3>
										<?php
										//<!--Memory AVL-->
										if($Memry01_num>0){
										?>
										<div class="toggle toggle-bg">
											<div class="toggle-header">
												<div class="toggle-icon">
													<i class="toggle-closed icon-chevron-down1"></i>
													<i class="toggle-open icon-chevron-up1"></i>
												</div>
												<div class="toggle-title">
													Memory
												</div>
											</div>
											<div class="toggle-content">
											<!--memory table-->
											<!--one Memory Frequency-->
											<?php
											$Fid="";
											$Meo_str="SELECT DISTINCT c_sp_memory_frequence.ID, c_sp_memory_frequence.FREQUENCE, c_sp_memory_frequence.Order_val FROM c_sp_memory_frequence INNER JOIN sp_memory ON c_sp_memory_frequence.FREQUENCE = sp_memory.MEMORY_FREQUENCE WHERE (c_sp_memory_frequence.STATUS = 1) AND (sp_memory.MODEL LIKE '%".$PMCode_si.",%' or sp_memory.MODEL like '%".$PSKUs_si."%') ORDER BY Order_val desc";
										  $Meo_cmd=mysqli_query($link_db,$Meo_str);
										  while($Meo_Data=mysqli_fetch_row($Meo_cmd)){
										  	$Fid=$Meo_Data[0];
										  	echo "<h4 style='background-color:#bbd9fa; padding:10px 20px'>Memory Frequency:".$Meo_Data[1]."</h4>";
												echo "<table class='table table-hover'>";
												echo "<thead>
															  <tr>
																<th>Vendor</th>
																<th>Vendor Part #</th>
																<th>Size</th>
																<th>Type</th>
																<th>Chip Part #</th>
															  </tr>
															</thead>";
												echo "<tbody>";
												$Meo_strlist="SELECT A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, CASE A.ROHS WHEN 1 THEN 'RoHS' WHEN 0 THEN '' END AS ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.DESCRIPTION AS SIZE, B.MODULEVENDER FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE WHERE (A.STATUS = 1) AND (A.MODEL LIKE '%".$PMCode_si.",%' or A.MODEL like '%".$PSKUs_si."%') AND (C.ID = ".$Fid.") ORDER BY B.MODULEVENDER";
										    $Meo_listcmd=mysqli_query($link_db,$Meo_strlist);
										  	while($Meo_LData=mysqli_fetch_row($Meo_listcmd)){
										  		echo "<tr>
																<td><a href=".$Meo_LData[14]." target='_blank'>".$Meo_LData[16]."</td>
																<td>".$Meo_LData[6]."<br/>".$Meo_LData[2]."<br/>".$Meo_LData[3]."<br></td>";
													$str_cpsize="SELECT `MEMORYSIZE`, `DESCRIPTION` FROM `c_sp_memory_size` WHERE `MEMORYSIZE`='".$Meo_LData[1]."'";
													$cspsize_cmd=mysqli_query($link_db,$str_cpsize);
													$cspsize_data=mysqli_fetch_row($cspsize_cmd);
													echo "<td>".$cspsize_data[1]."</td>";
													echo "<td>".$Meo_LData[4]."<br />".$Meo_LData[10]."<br></td>
																<td>".$Meo_LData[5]."<br />".$Meo_LData[7]."</td>
															  </tr>";
										  	}
												echo "</tbody>";
												echo "</table>";
											}
											?>

											<!--end one Memory Frequency-->
											</div>
										</div>
										<?php
										}
										//<!--Memory AVL END-->

										//<!--HDD / SSD AVL-->
										if($Hdd01_num>0){
										?>
										<div class="toggle toggle-bg">
											<div class="toggle-header">
												<div class="toggle-icon">
													<i class="toggle-closed icon-chevron-down1"></i>
													<i class="toggle-open icon-chevron-up1"></i>
												</div>
												<div class="toggle-title">
													HDD / SSD
												</div>
											</div>
											<div class="toggle-content">
												<?php
												$Hid="";
												$Hdd_str="SELECT DISTINCT c_sp_hdd_type.ID, c_sp_hdd_type.HDDTYPE FROM c_sp_hdd_type INNER JOIN sp_hdd ON c_sp_hdd_type.HDDTYPE = sp_hdd.HDD_TYPE WHERE (c_sp_hdd_type.STATUS = 1) AND (sp_hdd.MODEL LIKE '%".$PMCode_si.",%' or sp_hdd.MODEL LIKE '%".$PSKUs_si."%') AND sp_hdd.STATUS='1' ORDER BY c_sp_hdd_type.HDDTYPE, c_sp_hdd_type.ID";
												$Hdd_cmd=mysqli_query($link_db,$Hdd_str);
											  while($Hdd_Data=mysqli_fetch_row($Hdd_cmd)){
											  	//<!--one HDD SSD Type-->
											  	$Hid=$Hdd_Data[0];
												  echo "<h4 style='background-color:#bbd9fa; padding:10px 20px'>HDD / SSD Type: ".$Hdd_Data[1]."</h4>";
												  echo "<table class='table table-hover'>
																<thead>
																  <tr>
																	<th>Vendor</th>
																	<th>Model</th>
																	<th>Form Factor</th>
																	<th>Interface</th>
																	<th>Capacity</th>
																  </tr>
																</thead>
																<tbody>";
													$Hdd_strlist="SELECT A.VENDER_NAME, A.HDD_SIZE, A.NOTE, A.HDD_TYPE, A.HDD_CAPACITY, A.HDD_BUS, A.MODEL_NAME, A.MODEL, B.MODULEVENDER, D.DESCRIPTION as SIZE, C.ID FROM sp_hdd AS A INNER JOIN c_sp_hdd_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_hdd_type AS C ON A.HDD_TYPE = C.HDDTYPE INNER JOIN c_sp_hdd_size AS D ON A.HDD_SIZE = D.HDDSIZE WHERE (A.STATUS = 1) AND (A.MODEL LIKE '%".$PMCode_si.",%' or A.MODEL LIKE '%".$PSKUs_si."%') AND (C.ID = ".$Hid.") ORDER BY B.MODULEVENDER";
												  $Hdd_listcmd=mysqli_query($link_db,$Hdd_strlist);
												  while($Hdd_LData=mysqli_fetch_row($Hdd_listcmd)){
												  	echo "<tr>
																  <td>".$Hdd_LData[8]."</td>
																  <td>".$Hdd_LData[6]."</td>
																  <td>".$Hdd_LData[1]."</td>
																  <td>".$Hdd_LData[5]."</td>
																  <td>".$Hdd_LData[4]."</td>
																  </tr>";
												  }
													echo "</tbody>";
													echo "</table>";
													//<!--one HDD SSD Type end-->
											  }
												?>
												<!--end HDD SSD table-->
											</div>
										</div>
										<!--End HDD / SSD AVL-->
										<?php
										}

										if($spcpulist_num>0){
											$str_spcpulist="SELECT ID, List_NAME, Label_NAME, DESCS, Url, MODEL, STATUS FROM sp_list where instr(`MODEL`,'".str_replace(".php","",$PSKUs_si)."')>0";
											$spcpulist_cmd=mysqli_query($link_db,$str_spcpulist);
											while ($spcpulist_data=mysqli_fetch_row($spcpulist_cmd)) {
											?>
											<!--(Product) Support Lists management (General) AVL-->
											<div class="toggle toggle-bg">
												<div class="toggle-header">
													<div class="toggle-icon">
														<i class="toggle-closed icon-chevron-down1"></i>
														<i class="toggle-open icon-chevron-up1"></i>
													</div>
													<div class="toggle-title">
														<?=$spcpulist_data[1]?>
													</div>
												</div>
												<div class="toggle-content"><?=$spcpulist_data[3]?></div>
											</div>
											<!--End (Product) Support Lists management (General) AVL-->
											<?php
											}
										}
										?>
									</div>

								</div>
								<?php
								}
								//--- Support end ----

								//--- download tag ----
								if($BIOS_display==1){
								?>
								<div class="tab-content clearfix" id="Downloads">
									<div class="col-padding">
									<!--Download-->
									<?php
									$BIOS01="SELECT ID, FILENAME, FILEDATE, DESCRIPTION, VERSION, PATH, FILESIZE FROM sp_bios WHERE ((STATUS = 1) AND (MODEL LIKE '%".$PMCode_si.",%' or `MODEL` like '%".$PSKUs_si."%')) ORDER BY FILEDATE DESC";
									$BIOS01_cmd=mysqli_query($link_db,$BIOS01);
									$BIOS01_Data=mysqli_fetch_row($BIOS01_cmd);
									if($BIOS01_Data==true){
										echo "<h3>BIOS</h3>";
										echo "<table class='table  table-hover'>";
										echo "<thead>
													<tr>
													<th>Date</th>
													<th>File Name</th>
													<th></th>
													</tr>
													</thead>";
										echo "<tbody>";
										$BIOS_strlist="SELECT ID, FILENAME, FILEDATE, DESCRIPTION, VERSION, PATH, FILESIZE FROM sp_bios WHERE ((STATUS = 1) AND (MODEL like '%".$PMCode_si.",%' or MODEL LIKE '%".$PSKUs_si.",%')) ORDER BY FILEDATE DESC";
										$BIOS_listcmd=mysqli_query($link_db,$BIOS_strlist);
										while($BIOS_LData=mysqli_fetch_row($BIOS_listcmd)){
											putenv("TZ=Asia/Taipei");
											$ftp_tw = str_replace("ftp.", "ftp1.", $BIOS_LData[5]);
											echo "<tr>";
											echo "<td>".date("Y / m / d",strtotime($BIOS_LData[2]))."</td>";
											echo "<td>".$BIOS_LData[1];
											if($BIOS_LData[6]!=""){
												echo "<span>(".$BIOS_LData[6].")</span>";
											}
											if($BIOS_LData[4]!=""){
												echo "<div style='color:#898989; font-style: italic; font-size: 0.8rem;'>Version: ".$BIOS_LData[4]."</div>";
											}
											echo "<div style='font-size: 0.9rem; margin-top:10px;  font-style: italic; color:#004898'>".$BIOS_LData[3]."</div>";
											echo "</td>";
											echo "<td>";
											echo "<a href='".$BIOS_LData[5]."'/><i class='i-rounded icon-line-download' style='background-color:#004898; font-size: 2rem;'></i></a>";
											echo "</td>";
											echo "</tr>";
										}
										echo "</tbody>";
										echo "</table>";
										echo "<div class='line bottommargin'></div>";
									}

									$IPMI01="SELECT ID, FILENAME, FILEDATE, DESCRIPTION, VERSION, PATH, FILESIZE FROM `sp_firmware` WHERE ((STATUS = 1) AND (MODEL LIKE '%".$PMCode_si.",%' or `MODEL` like '%".$PSKUs_si."%'))ORDER BY FILEDATE DESC";
									$IPMI01_cmd=mysqli_query($link_db,$IPMI01);
									$IPMI01_Data=mysqli_fetch_row($IPMI01_cmd);
									if($IPMI01_Data==true){
										echo "<h3>BMC</h3>";
										echo "<table class='table  table-hover'>";
										echo "<thead>
													<tr>
													<th>Date</th>
													<th>File Name</th>
													<th></th>
													</tr>
													</thead>";
										echo "<tbody>";
										$IPMI_strlist="SELECT ID, FILENAME, FILEDATE, DESCRIPTION, VERSION, PATH, FILESIZE FROM `sp_firmware` WHERE ((STATUS = 1) AND (MODEL LIKE '%".$PMCode_si.",%' or MODEL LIKE '%".$PSKUs_si."%'))ORDER BY FILEDATE DESC";
										$IPMI_listcmd=mysqli_query($link_db,$IPMI_strlist);
										while($IPMI_LData=mysqli_fetch_row($IPMI_listcmd)){
											putenv("TZ=Asia/Taipei");
											$ftp_tw = str_replace("ftp.", "ftp1.", $IPMI_LData[5]);
											echo "<tr>";
											echo "<td>".date("Y / m / d",strtotime($IPMI_LData[2]))."</td>";
											echo "<td>".$IPMI_LData[1];
											if($IPMI_LData[6]!=""){
												echo "<span>(".$IPMI_LData[6].")</span>";
											}
											if($IPMI_LData[4]!=""){
												echo "<div style='color:#898989; font-style: italic; font-size: 0.8rem;'>Version: ".$IPMI_LData[4]."</div>";
											}
											echo "<div style='font-size: 0.9rem; margin-top:10px;  font-style: italic; color:#004898'>".$IPMI_LData[3]."</div>";
											echo "</td>";
											echo "<td>";
											echo "<a href='".$IPMI_LData[5]."'/><i class='i-rounded icon-line-download' style='background-color:#004898; font-size: 2rem;'></i></a>";
											echo "</td>";
											echo "</tr>";
										}
										echo "</tbody>";
										echo "</table>";
										echo "<div class='line bottommargin'></div>";
									}

									$valueCat01="select ID, FILENAME, FILEDATE, DESCRIPTION, VERSION, PATH, FILESIZE from `sp_driver` where (`MODEL` like '%".$PMCode_si."%' or `MODEL` like '%".$PSKUs_si."%') order by `VALUECATEGORY`";
									$valueCat01_cmd=mysqli_query($link_db,$valueCat01);
									$valueCat01_Num=mysqli_num_rows($valueCat01_cmd);
									if($valueCat01_Num>0){
										echo "<h3>Drivers</h3>";
										echo "<table class='table  table-hover'>";
										echo "<thead>
													<tr>
													<th>Date</th>
													<th>File Name</th>
													<th></th>
													</tr>
													</thead>";
										echo "<tbody>";
										$str_DriverList="select `ID`, `FILENAME`, `FILEDATE`, `DESCRIPTION`, `FILESIZE` ,`PATH`, `VERSION` from `sp_driver` where (`MODEL` like '%".$PMCode_si."%' or `MODEL` like '%".$PSKUs_si."%') order by `FILEDATE`";
										$DriverList_cmd=mysqli_query($link_db,$str_DriverList);
										while($DriverList_data=mysqli_fetch_row($DriverList_cmd)){
											putenv("TZ=Asia/Taipei");
											$ftp_tw = str_replace("ftp.", "ftp1.", $DriverList_data[5]);
											echo "<tr>";
											echo "<td>".date("Y / m / d",strtotime($DriverList_data[2]))."</td>";
											echo "<td>".$DriverList_data[1];
											if($DriverList_data[6]!=""){
												echo "<span>(".$DriverList_data[6].")</span>";
											}
											if($DriverList_data[4]!=""){
												echo "<div style='color:#898989; font-style: italic; font-size: 0.8rem;'>Version: ".$DriverList_data[4]."</div>";
											}
											echo "<div style='font-size: 0.9rem; margin-top:10px;  font-style: italic; color:#004898'>".$DriverList_data[3]."</div>";
											echo "</td>";
											echo "<td>";
											echo "<a href='".$DriverList_data[5]."'/><i class='i-rounded icon-line-download' style='background-color:#004898; font-size: 2rem;'></i></a>";
											echo "</td>";
											echo "</tr>";
										}
										echo "</tbody>";
										echo "</table>";
										echo "<div class='line bottommargin'></div>";
									}


									?>
									<!--end Download-->
									</div>
								</div>
								<?php
								}
								//--- download tag end ----
								?>

								<!--Expansion tabs contents-->
								<?php
								if($exptag==0){
									echo $tab_contant;
								}
								?>
								<!--end Expansion tabs contents-->

							</div>

						</div>

					</div>
				</div>
			</div>
		</div>


		<!--end product tabs-->


		<!-- #content end -->

		<!-- add quote sone msg Modal -->
		<div id="addqtomsg" class="modal fade compare-alert-modal" tabindex="-1" role="dialog" aria-labelledby="centerModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<div class="block mx-auto" style="background-color: #FFF; max-width: 500px;">
							<div class="feature-box fbox-center fbox-effect fbox-lg border-bottom-0 mb-0" style="padding: 40px;">
								<div class="fbox-icon">
									<i class="icon-ok i-alt"></i>
								</div>
								<div class="fbox-content">
									<h3>Success!<span class="subtitle">Your requested quote has been added to the list. Click &nbsp;&nbsp;"<img src="/images/quote-icon.gif" />"&nbsp;&nbsp; on the top-right navigation bar to continue.</span></h3>
									<img src="/images/quote-nav-bar.gif" />
								</div>
							</div>
							<div class="section center m-0" style="padding: 30px;">
								<button type="button" class="button" data-bs-dismiss="modal" aria-hidden="true">Close</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- end add quote sone msg Modal -->

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
	<script src="js1/jquery.js"></script>
	<script src="js1/plugins.min.js"></script>

	<!-- Footer Scripts
	============================================= -->
	<script src="js1/functions.js"></script>

	<!-- ADD-ONS JS FILES -->

	<script src="js1/top.js"></script>
	<script type="text/javascript">
	function tagblank(i) {
		window.open(i);
		//location.reload();
	};
	</script>

</body>
</html>
<?php
mysqli_Close($link_db);
?>