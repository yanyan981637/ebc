<?php
header("X-Frame-Options: DENY");
//header("Content-Security-Policy-Report-Only: default-src *; img-src https:; frame-src 'none'; report-uri http://www.tyan.com");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://www.tyan.com");
header('Content-Type: text/html; charset=utf-8');
header("Cache-control: private");
require "../config.php";



error_reporting(0);

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase,$link_db);

$r_pid="";$s_PID="";$m_SKUs="";$s_PMc_str="";$Chk_SKU="";$m_PType="";$Fid="";$Hid="";

function dowith_sql($str)
{
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
	$str = str_replace("or","",$str);
	$str = str_replace("=","",$str);
	return $str;
}

$PType_si="";$PMCode_si="";$PSKUs_si="";$PLang_si="";$PLang_si01="";$ProductName01="";$PType_siName01="";
$WTBName01="";$CUName01="";$OSName01="";$WTBName01_url="";$CUName01_url="";$OSName01_url="";$PRName01="";$DMName01="";$SPName01="";$DLName01="";

$PType_si=preg_replace("/['\"\~\%\$ \r\n\t;<>\?]/i", '', trim($_REQUEST['PType']));
$PMCode_si=preg_replace("/['\"\~\%\$ \r\n\t;<>\?]/i", '', trim($_REQUEST['PMCode']));
$PSKUs_si=dowith_sql($_REQUEST['PSKUs']);


if(isset($_REQUEST['PLang'])!=''){  
	$PLang_si=dowith_sql($_REQUEST['PLang']);
	$PLang_si=str_replace(".php","",$PLang_si);

	if($PLang_si=="EN"){
		$PLang_si01="EN";
		$PLang_si="en-US";
		$ProductName01="Products";
		$WTBName01="WHERE TO BUY";$WTBName01_url="/where_to_buy/asia.php";
		$CUName01="Contact Us";$CUName01_url="/contact.php";
		$OSName01="Online Service";$OSName01_url="http://12.33.221.75/helpstar/hsPages/login.aspx";
		$PRName01="Press Review";
		$DMName01="Docs";
		$SPName01="Support / AVL";
		$DLName01="Downloads";
		$PDName01="Overview";
		$SPECName01="Specifications";
	}else if($PLang_si=="JP"){
		$PLang_si01="JP";
		$PLang_si="ja-JP";
		$ProductName01="製品";
		$WTBName01="販売店情報";$WTBName01_url="/JP/where_to_buy/asia.php";
		$CUName01="お問い合わせ";$CUName01_url="/JP/contact.php";
		$OSName01="オンライン サービス";$OSName01_url="http://12.33.221.75/helpstar/hsPages/login.aspx";
		$PRName01="製品レビュー";
		$DMName01="資料";
		$SPName01="サポート";
		$DLName01="ダウンロード";
		$PDName01="概要";
		$SPECName01="仕様";
	}else if($PLang_si=="CN"){
		$PLang_si01="CN";
		$PLang_si="zh-CN";
		$ProductName01="产品";
		$WTBName01="各地经销";$WTBName01_url="/CN/where_to_buy/asia.php";
		$CUName01="联络我们";$CUName01_url="/CN/contact.php";
		$OSName01="在线服务";$OSName01_url="http://12.33.221.75/helpstar/hsPages/login.aspx";
		$PRName01="产品评测";
		$DMName01="文件";
		$SPName01="支持列表";
		$DLName01="下载";
		$PDName01="简介";
		$SPECName01="规格";
	}else if($PLang_si=="ZH"){
		$PLang_si01="ZH";
		$PLang_si="zh-TW";
		$ProductName01="產品";
		$WTBName01="各地經銷";$WTBName01_url="/ZH/where_to_buy/asia.php";
		$CUName01="聯絡我們";$CUName01_url="/ZH/contact.php";
		$OSName01="線上服務";$OSName01_url="http://12.33.221.75/helpstar/hsPages/login.aspx";
		$PRName01="產品評測";
		$DMName01="文件";
		$SPName01="支援列表";
		$DLName01="下載";
		$PDName01="簡介";
		$SPECName01="規格";
	}
}else{
	$PLang_si01="EN";
	$PLang_si="en-US";
	$ProductName01="Products";
	$WTBName01="WHERE TO BUY";$WTBName01_url="/EN/where_to_buy/usa.php";
	$CUName01="Contact Us";$CUName01_url="/EN/contact.php";
	$OSName01="Online Service";$OSName01_url="http://12.33.221.75/helpstar/hsPages/login.aspx";
	$PRName01="Press Review";
	$DMName01="Docs / FRU";
	$SPName01="Support / AVL";
	$DLName01="Downloads";
	$PDName01="Overview";
	$SPECName01="Specifications";
}

if(isset($_REQUEST['pid'])!=''){
	$r_pid=intval($_REQUEST['pid']);
}else{

	if ($PSKUs_si == "B5521F65X9-090PV6R"){
		echo "<script>self.location='/Barebones_FS65B5521_B5521F65X9-160PV6R';</script>";
	}else if ($PSKUs_si == "S7063GM3NR-2T"){
		echo "<script>self.location='/Motherboards_S7063_S7063GM3NR-2T(BTO)';</script>";
	}else if ($PSKUs_si == "S7063GM2NR-1T"){
		echo "<script>self.location='/Motherboards_S7063_S7063GM2NR-1T(BTO)';</script>";
	}else if ($PSKUs_si == "S7063WGM2NR-1T-B"){
		echo "<script>self.location='/Motherboards_S7063_S7063WGM2NR-1T-B(BTO)';</script>";
	}else if ($PSKUs_si == "S7063WGM3NR-2T"){
		echo "<script>self.location='/Motherboards_S7063_S7063WGM3NR-2T(BTO)';</script>";
	}else if ($PSKUs_si == "S7067GM3NR-2T"){
		echo "<script>self.location='/Motherboards_S7067_S7067GM3NR-2T(BTO)';</script>";
	}else if ($PSKUs_si == "S7067GM2NR-1T"){
		echo "<script>self.location='/Motherboards_S7067_S7067GM2NR-1T(BTO)';</script>";
	}else if ($PSKUs_si == "S7067WGM2NR-1T-B"){
		echo "<script>self.location='/Motherboards_S7067_S7067WGM2NR-1T-B(BTO)';</script>";
	}else if ($PSKUs_si == "S7067WGM3NR-2T"){
		echo "<script>self.location='/Motherboards_S7067_S7067WGM3NR-2T(BTO)';</script>";
	}

	if($_REQUEST['PType'] == "Motherboards"){
		$prod_imgurl="./images/systemboards/";
		$s_PID = "select SYSTEMBOARDID from p_s_main_systemboards where MODELCODE='".$PMCode_si."' and LANG='en-US'";
	}else if($_REQUEST['PType'] == "Barebones"){
		$prod_imgurl="./images/serverbarebones/";
		$s_PID = "select SERVERID from p_b_main_serverbarebones where MODELCODE='".$PMCode_si."' and LANG='en-US'";
	}else if($_REQUEST['PType'] == "HBA"){
		$s_PID = "select HBAID from p_s_main_hba where MODELCODE='".$PMCode_si."' and LANG='en-US'";
		$prod_imgurl="./images/HBA/";
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
	}else{
		echo "<script language='javascript'>self.location='/404.htm'</script>";
		exit();
	}

	$PCd_cmd=mysqli_query($link_db,$s_PID);
	$PCd_result=mysqli_fetch_row($PCd_cmd);

	if($PCd_result==true){	   
		$r_pid = $PCd_result[0];
	}  
}

if(isset($_REQUEST['SKU'])!=''){
	$m_SKUs = trim($_REQUEST['SKU']);
}else{

	$s_PMc_str = $PMCode_si;   
	$s_SKU = "select Product_SKU_Auto_ID, IS_EOL from product_skus where SKU='".$PSKUs_si."' and MODELCODE='".$s_PMc_str."'";
	$pkS_cmd=mysqli_query($link_db,$s_SKU);
	$pkS_result=mysqli_fetch_row($pkS_cmd);

	if($pkS_result==true){
		$m_SKUs=$pkS_result[0];
	}
	if($pkS_result[1]==1){
		$EOL="(EOL)";
	}

}

$str_STN01="";
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

$Chk_SKU="select Product_SKU_Auto_ID from product_skus where Web_Disable=1 and Product_SKU_Auto_ID=".$m_SKUs."";
$chS_cmd=mysqli_query($link_db,$Chk_SKU);
$chS_result=mysqli_fetch_row($chS_cmd);
//if(empty($chS_result)):
if($chS_cmd == true):

	else:
		//echo "<script>self.location='./404.htm';</script>";
	exit();
	endif;

/* if(isset($_REQUEST['ProductType'])!=''){
$m_PType = trim($_REQUEST['ProductType']);
}else{

if($PType_si == "Motherboards"){
$m_PType = "MB";
}else if($PType_si == "Barebones"){
$m_PType = "BB";
}else if($PType_si == "HBA"){
$m_PType = "HBA";
}else if($PType_si == "Chassis"){
$m_PType = "CHS";
}else if($PType_si == "JBOD"){
$m_PType = "JBOD";
}else if($PType_si == "NIC"){
$m_PType = "NIC";
}else if($PType_si == "TPM"){
$m_PType = "TPM";
}

} */

//--------------20170518 更新----------------------
if(isset($_REQUEST['ProductType'])!=''){
	$m_PType = trim($_REQUEST['ProductType']);
}else{	
	if($PType_si == "IndustrialPanelPC"){
					//$m_PType = "BB";
		if($PLang_si=="en-US"){
			$PType_siName01="Industrial Panel PC";
			$siName_url = "/products/Industrial_Panel_PC";
		}		
	}else if($PType_si == "EmbeddedSystem"){
					//$m_PType = "BB";
		if($PLang_si=="en-US"){
			$PType_siName01="Embedded System";
			$siName_url = "/products/embedded_system";
		}
	}else if($PType_si == "IndustrialMotherboard"){
					//$m_PType = "HBA";
		if($PLang_si=="en-US"){
			$PType_siName01="Industrial Motherboard";
			$siName_url = "/products/industrial_motherboard";
		}
	}else if($PType_si == "OCPserver"){
					//$m_PType = "Chassis";
		if($PLang_si=="en-US"){
			$PType_siName01="OCP Server";
			$siName_url = "/products/OCP";
		}	
	}else if($PType_si == "OCPMezz"){
					//$m_PType = "JBOD";
		if($PLang_si=="en-US"){
			$PType_siName01="OCP Mezz";
			$siName_url = "/products/OCP";
		}
	}else if($PType_si == "JBODJBOF"){
					//$m_PType = "JBOD";
		if($PLang_si=="en-US"){
			$PType_siName01="JBOD / JBOF";
			$siName_url = "/products/storage_platform";
		}
	}else if($PType_si == "OCPRack"){
					//$m_PType = "JBOD";
		if($PLang_si=="en-US"){
			$PType_siName01="OCP Rack";
			$siName_url = "/products/OCP";
		}
	}else if($PType_si == "POS"){
					//$m_PType = "JBOD";
		if($PLang_si=="en-US"){
			$PType_siName01="POS";
						//$siName_url = "/EN/TYAN_JBOD/";
		}
	}
}
//--------------20170518 更新end----------------------

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
		}else if(strtoupper($m_PType) == "CHS"){	     
			$mysql = "SELECT p_r_main_rackchassis.SERVERID,";
			$mysql = $mysql . " p_r_main_rackchassis.MODELNAME, ";
			$mysql = $mysql . " p_r_main_rackchassis.SPEC, ";
			$mysql = $mysql . " p_r_main_rackchassis.CPUSORT, ";
			$mysql = $mysql . " p_r_main_rackchassis.IMG, ";
			$mysql = $mysql . " p_r_main_rackchassis.BIGIMG, ";
			$mysql = $mysql . " p_r_main_rackchassis.UPDATE_USER, ";
			$mysql = $mysql . " p_r_main_rackchassis.UPDATE_DATE, ";
			$mysql = $mysql . " p_r_main_rackchassis.STATUS, ";
			$mysql = $mysql . " CONCAT(p_r_main_rackchassis.MODELNAME,' (',p_r_main_rackchassis.MODELCODE,')') AS MODEL, ";
			$mysql = $mysql . " CASE WHEN ISDUALCORE = 1 THEN '_DualCore' ELSE '' END AS DUALCORE,";
			$mysql = $mysql . " p_r_main_rackchassis.MODELCODE, ";
			$mysql = $mysql . " p_r_main_rackchassis.ISDUALCORE, ";
			$mysql = $mysql . " p_r_main_rackchassis.NEW_START, ";
			$mysql = $mysql . " p_r_main_rackchassis.NEW_END, ";
			$mysql = $mysql . " p_b_rackmount.RACKMOUNTNAME, ";
			$mysql = $mysql . " p_b_rackmount.RACKMOUNTNAME as myLabelTest,";
			$mysql = $mysql . " SERVERID as myid";
			$mysql = $mysql . " FROM p_r_main_rackchassis ";
			$mysql = $mysql . " INNER JOIN p_b_rackmount ON p_r_main_rackchassis.RACKMOUNTID = p_b_rackmount.RACKMOUNTID ";
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
		}

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

	$CPUSORT01=$DataList1_result[3];
	$IMG01=$DataList1_result[4];
	$FTPIMG01=$DataList1_result[5];	
}

function GetModelCode($r_pid,$ProductType,$link_db,$select){
	$totl_f="";
	switch ($ProductType){
		case "IndustrialPanelPC":
		$str_GM="select `MODELCODE` FROM `p_b_main_panelpc` where PANELPCID='".$r_pid."' ORDER BY PANELPCID";
		$totl_f="";  
		break;
		case "EmbeddedSystem":
		$str_GM="select `MODELCODE` FROM `p_b_main_embedded` where EMBEDDEDID='".$r_pid."' ORDER BY EMBEDDEDID";
		$totl_f=""; 
		break;
		case "IndustrialMotherboard":
		$str_GM="select `MODELCODE` FROM `p_b_main_industriamb` where INDUSTRIAMBID='".$r_pid."' ORDER BY `INDUSTRIAMBID`";
		$total_f="";
		break;
		case "OCPserver":
		$str_GM="select `MODELCODE` FROM `p_b_main_ocpserver` where OCPID='".$r_pid."' ORDER BY OCPID";
		$totl_f="";
		break;
		case "OCPMezz":
		$str_GM="select `MODELCODE` FROM `p_b_main_ocpmezz` where OCPMezzID='".$r_pid."' ORDER BY OCPMezzID";
		$totl_f="";
		break;
		case "JBODJBOF":
		$str_GM="select `MODELCODE` FROM `p_b_main_jbodjbof` where JBODFID='".$r_pid."' ORDER BY JBODFID";
		$totl_f="";
		break;
		case "OCPRack":
		$str_GM="select `MODELCODE` FROM `p_b_main_ocprack` where OCPRACKID='".$r_pid."' ORDER BY OCPRACKID";
		$totl_f="";
		break;
		case "POS":
		$str_GM="select `MODELCODE` FROM `p_b_main_pos` where POSID='".$r_pid."' ORDER BY POSID";
		$totl_f="";
		break;
		default: 
	}
	$GM_cmd1=mysqli_query($link_db,$str_GM);
	$GM_result1=mysqli_fetch_row($GM_cmd1);

	if($GM_result1 == true){
		$GM_Val = $totl_f.$GM_result1[0];
	}
	Return $GM_Val;
}

function GetPreviewVal($r_pid,$link_db,$select){	
	$pr_result="";
	$PType_si=preg_replace("/['\"\~\%\$ \r\n\t;<>\?]/i", '', trim($_REQUEST['PType']));
	$PSKUs_si=str_replace("['\"\$ \r\n\t;<>\*\?]", '', $_REQUEST['PSKUs']);
	$str_prchk="SELECT `MODEL` FROM `sp_pressreview` where `STATUS`='1' and (`MODEL` like '%".GetModelCode($r_pid,$PType_si,$link_db,$select)."%' or `MODEL` like '%".str_replace(".php","",$PSKUs_si)."%') order by `UPDATE_DATE` desc";
	$prchk_cmd=mysqli_query($link_db,$str_prchk);
	$prchk_data=mysqli_fetch_row($prchk_cmd);
	if($prchk_data==true){
		$pr_result=true;
	}else{
		$pr_result="";
	}

	return $pr_result;
}

function GetModelCodeByID($r_pid,$ProductType,$spItemName,$link_db,$select){

	switch ($ProductType){
		case "IndustrialPanelPC":
		$str_GM="select `MODELCODE` FROM `p_b_main_panelpc` where PANELPCID='".$r_pid."' ORDER BY PANELPCID";
		break;
		case "EmbeddedSystem":
		$str_GM="select `MODELCODE` FROM `p_b_main_embedded` where EMBEDDEDID='".$r_pid."' ORDER BY EMBEDDEDID";
		break;
		case "IndustrialMotherboard":
		$str_GM="select `MODELCODE` FROM `p_b_main_industriamb` where INDUSTRIAMBID='".$r_pid."' ORDER BY `INDUSTRIAMBID`";
		break;
		case "OCPserver":
		$str_GM="select `MODELCODE` FROM `p_b_main_ocpserver` where OCPID='".$r_pid."' ORDER BY OCPID";
		break;
		case "OCPMezz":
		$str_GM="select `MODELCODE` FROM `p_b_main_ocpmezz` where OCPMezzID='".$r_pid."' ORDER BY OCPMezzID";
		break;
		case "JBODJBOF":
		$str_GM="select `MODELCODE` FROM `p_b_main_jbodjbof` where JBODFID='".$r_pid."' ORDER BY JBODFID";
		break;
		case "OCPRack":
		$str_GM="select `MODELCODE` FROM `p_b_main_ocprack` where OCPRACKID='".$r_pid."' ORDER BY OCPRACKID";
		break;
		case "POS":
		$str_GM="select `MODELCODE` FROM `p_b_main_pos` where POSID='".$r_pid."' ORDER BY POSID";
		break;
		default:
	}
	$GM_cmd01=mysqli_query($link_db,$str_GM);
	$GM_result01=mysqli_fetch_row($GM_cmd01);

	if($GM_result01 == true){
		$GM_Val=$GM_result01[0];
	}
	
	if($spItemName=="Drivers"){

		$str_ct="SELECT Count(1) FROM sp_driver WHERE MODEL LIKE '%".$GM_Val."%'";
		$ctcmd=mysqli_query($link_db,$str_ct);
		$c_result=mysqli_fetch_row($ctcmd);	
		if($c_result==true){
			Return "Drivers";
		}

	}else if($spItemName=="Manuals"){

		$str_ct="SELECT Count(*) FROM sp_manual WHERE ((STATUS = '1') AND (MODEL LIKE '%".$GM_Val.",%'))"; 
		$ctcmd=mysqli_query($link_db,$str_ct);
		$c_result=mysqli_fetch_row($ctcmd);	
		if($c_result==true){
			Return "Manuals";
		}

	}else if($spItemName=="Datasheets"){

		$str_ct="SELECT Count(*) FROM sp_datasheet WHERE ((STATUS = '1') AND (MODEL LIKE '%".$GM_Val.",%'))"; 
		$ctcmd=mysqli_query($link_db,$str_ct);
		$c_result=mysqli_fetch_row($ctcmd);	
		if($c_result==true){
			Return "Datasheets";
		}

	}else if($spItemName=="BIOS"){

		$str_ct="SELECT Count(*) FROM sp_bios WHERE ((STATUS = '1') AND (MODEL LIKE '%".$GM_Val.",%'))"; 
		$ctcmd=mysqli_query($link_db,$str_ct);
		$c_result=mysqli_fetch_row($ctcmd);	
		if($c_result==true){
			Return "BIOS";
		}
	}
}

function GetModelName($link_db,$select){
	$PSKUs_si=dowith_sql($_REQUEST['PSKUs']);
	$PMCode_si=preg_replace("/['\"\~\%\$ \r\n\t;<>\?]/i", '', trim($_REQUEST['PMCode']));
	if(isset($_REQUEST['SKU'])!=''){
		$Gm_SKUs=trim($_REQUEST['SKU']);
	}else{
		$s_GPMc_str=trim($PMCode_si);   
		$s_GSKU="select Product_SKU_Auto_ID from product_skus where SKU='".trim($PSKUs_si)."' and MODELCODE='".$s_GPMc_str."'";
		$pkS_gcmd=mysqli_query($link_db,$s_GSKU);
		$pkS_gresult=mysqli_fetch_row($pkS_gcmd);

		if($pkS_gresult == true){
			$Gm_SKUs=$pkS_gresult[0];
		}
	}

	$GMname="SELECT Case When IS_EOL = 1 Then CONCAT(product_models.ModelName,' ',product_skus.MODELCODE,' (',product_skus.SKU ,') (EOL)') Else CONCAT(product_models.ModelName,' ',product_skus.MODELCODE,' (',product_skus.SKU,')') end MODELName FROM product_models INNER JOIN product_skus ON product_models.ModelCode = product_skus.MODELCODE where Product_SKU_Auto_ID=".$Gm_SKUs;
	$GM_cmd=mysqli_query($link_db,$GMname);
	$GM_result=mysqli_fetch_row($GM_cmd);
	if($GM_result==true){  
		$GNM_val=strtr($GM_result[0],'TYAN','');
	}
	return $GNM_val;
}

if($m_PType == "IndustrialPanelPC"){
//$Mdname="Server Barebones ".$CPUNAME01." : ".GetModelName($link_db,$select);
		$Mdname=GetModelName($link_db,$select);
		$Get_N_SKU_Type="SELECT MODELCODE FROM p_b_main_panelpc WHERE (PANELPCID = ".$r_pid.")";
		$Get_N_SKU_Type_cmd=mysqli_query($link_db,$Get_N_SKU_Type);
		$Get_N_SKU_Type_result=mysqli_fetch_row($Get_N_SKU_Type_cmd);

		$Get_N_SKU_Type_all = "SELECT product_skus.*, ".$r_pid." as pid,'IndustrialPanelPC' as ProductType, CONCAT('IndustrialPanelPC',RTRIM(product_skus.MODELCODE),'_',RTRIM(product_skus.SKU),'') as PSKULINK FROM product_skus INNER JOIN ProductTypes ON product_skus.ProductTypeID = ProductTypes.ProductTypeID INNER JOIN vw_ModelName ON product_skus.MODELCODE = vw_ModelName.ModelCode INNER JOIN p_b_main_panelpc ON product_skus.ModelCode = p_b_main_panelpc.MODELCODE"; 
		$Get_N_SKU_Type_all = $Get_N_SKU_Type_all . " Where product_skus.MODELCODE like Case When locate('-','".$Get_N_SKU_Type_result[0]."')<>0 Then CONCAT(SUBSTRING('".$Get_N_SKU_Type_result[0]."', 1, locate('-','".$Get_N_SKU_Type_result[0]."')-1) , '%') else CONCAT('".$Get_N_SKU_Type_result[0]."' , '%') End and Web_Disable=0 and LANG='en-US' order by SKU";

	}else if($m_PType == "EmbeddedSystem"){
//$Mdname="Storage Adapter ".$CPUNAME01." : ".GetModelName($link_db,$select);
		$Mdname=GetModelName($link_db,$select);
		$Get_N_SKU_Type="SELECT MODELCODE FROM p_b_main_embedded WHERE (`EMBEDDEDID` = ".$r_pid.")";
		$Get_N_SKU_Type_cmd=mysqli_query($link_db,$Get_N_SKU_Type);
		$Get_N_SKU_Type_result=mysqli_fetch_row($Get_N_SKU_Type_cmd);

		$Get_N_SKU_Type_all = "SELECT product_skus.*, ".$r_pid." as pid,'EmbeddedSystem' as ProductType, CONCAT('Motherboards_',RTRIM(product_skus.MODELCODE),'_',RTRIM(product_skus.SKU),'') as PSKULINK FROM product_skus INNER JOIN ProductTypes ON product_skus.ProductTypeID = ProductTypes.ProductTypeID INNER JOIN vw_ModelName ON product_skus.MODELCODE = vw_ModelName.ModelCode INNER JOIN p_b_main_embedded ON product_skus.ModelCode = p_b_main_embedded.MODELCODE"; 
		$Get_N_SKU_Type_all = $Get_N_SKU_Type_all . " Where product_skus.MODELCODE like Case When locate('-','".$Get_N_SKU_Type_result[0]."')<>0 Then CONCAT(SUBSTRING('".$Get_N_SKU_Type_result[0]."', 1, locate('-','".$Get_N_SKU_Type_result[0]."')-1) , '%') else CONCAT('".$Get_N_SKU_Type_result[0]."' , '%') End and Web_Disable=0 and LANG='en-US' order by SKU desc";

	}else if($m_PType == "IndustrialMotherboard"){
//$Mdname="Server Chassis ".$CPUNAME01." : ".GetModelName($link_db,$select);
		$Mdname=GetModelName($link_db,$select);
		$Get_N_SKU_Type="SELECT MODELCODE FROM `p_b_main_industriamb` WHERE (INDUSTRIAMBID = ".$r_pid.")";
		$Get_N_SKU_Type_cmd=mysqli_query($link_db,$Get_N_SKU_Type);
		$Get_N_SKU_Type_result=mysqli_fetch_row($Get_N_SKU_Type_cmd);

		$Get_N_SKU_Type_all = "SELECT product_skus.*, ".$r_pid." as pid,'IndustrialMotherboard' as ProductType, CONCAT('Chassis_',RTRIM(product_skus.MODELCODE),'_',RTRIM(product_skus.SKU),'') as PSKULINK FROM product_skus INNER JOIN producttypes ON product_skus.ProductTypeID = producttypes.ProductTypeID INNER JOIN vw_modelname ON product_skus.MODELCODE = vw_modelname.ModelCode INNER JOIN p_b_main_industriamb ON product_skus.ModelCode = p_b_main_industriamb.MODELCODE"; 
		$Get_N_SKU_Type_all = $Get_N_SKU_Type_all . " Where product_skus.MODELCODE like Case When locate('-','".$Get_N_SKU_Type_result[0]."')<>0 Then CONCAT(SUBSTRING('".$Get_N_SKU_Type_result[0]."', 1, locate('-','".$Get_N_SKU_Type_result[0]."')-1) , '%') else CONCAT('".$Get_N_SKU_Type_result[0]."' , '%') End and LANG='en-US' and product_skus.sku in (select contents_product_skus.sku from contents_product_skus where contents_product_skus.slang='EN,' and contents_product_skus.modelcode='".$Get_N_SKU_Type_result[0]."' and contents_product_skus.status=1) order by SKU desc"; //mod 20150520 

}else if($m_PType == "OCPserver"){
//$Mdname="Server JBOD ".$CPUNAME01." : ".GetModelName($link_db,$select);
	$Mdname=GetModelName($link_db,$select);
	$Get_N_SKU_Type="SELECT MODELCODE FROM `p_b_main_ocpserver` WHERE (OCPID = ".$r_pid.")";
	$Get_N_SKU_Type_cmd=mysqli_query($link_db,$Get_N_SKU_Type);
	$Get_N_SKU_Type_result=mysqli_fetch_row($Get_N_SKU_Type_cmd);

	$Get_N_SKU_Type_all = "SELECT product_skus.*, ".$r_pid." as pid,'OCPserver' as ProductType, CONCAT('JOBD_',RTRIM(product_skus.MODELCODE),'_',RTRIM(product_skus.SKU),'') as PSKULINK FROM product_skus INNER JOIN producttypes ON product_skus.ProductTypeID = producttypes.ProductTypeID INNER JOIN vw_modelname ON product_skus.MODELCODE = vw_modelname.ModelCode INNER JOIN p_b_main_ocpserver ON product_skus.ModelCode = p_b_main_ocpserver.MODELCODE"; 
	$Get_N_SKU_Type_all = $Get_N_SKU_Type_all . " Where product_skus.MODELCODE like Case When locate('-','".$Get_N_SKU_Type_result[0]."')<>0 Then CONCAT(SUBSTRING('".$Get_N_SKU_Type_result[0]."', 1, locate('-','".$Get_N_SKU_Type_result[0]."')-1) , '%') else CONCAT('".$Get_N_SKU_Type_result[0]."' , '%') End and LANG='en-US' and product_skus.sku in (select contents_product_skus.sku from contents_product_skus where contents_product_skus.slang='EN,' and contents_product_skus.modelcode='".$Get_N_SKU_Type_result[0]."' and contents_product_skus.status=1) order by SKU desc"; //mod 20150520 

}else if($m_PType == "OCPMezz"){
//$Mdname="Server TPM ".$CPUNAME01." : ".GetModelName($link_db,$select);
	$Mdname=GetModelName($link_db,$select);
	$Get_N_SKU_Type="SELECT MODELCODE FROM `p_b_main_ocpmezz` WHERE (OCPMezzID = ".$r_pid.")";
	$Get_N_SKU_Type_cmd=mysqli_query($link_db,$Get_N_SKU_Type);
	$Get_N_SKU_Type_result=mysqli_fetch_row($Get_N_SKU_Type_cmd);

	$Get_N_SKU_Type_all = "SELECT distinct product_skus.*, ".$r_pid." as pid,'OCPMezz' as ProductType, CONCAT('TPM_',RTRIM(product_skus.MODELCODE),'_',RTRIM(product_skus.SKU),'') as PSKULINK FROM product_skus INNER JOIN producttypes ON product_skus.ProductTypeID = producttypes.ProductTypeID INNER JOIN vw_modelname ON product_skus.MODELCODE = vw_modelname.ModelCode INNER JOIN p_b_main_ocpmezz ON product_skus.ModelCode = p_b_main_ocpmezz.MODELCODE"; 
	$Get_N_SKU_Type_all = $Get_N_SKU_Type_all . " Where product_skus.MODELCODE like Case When locate('-','".$Get_N_SKU_Type_result[0]."')<>0 Then CONCAT(SUBSTRING('".$Get_N_SKU_Type_result[0]."', 1, locate('-','".$Get_N_SKU_Type_result[0]."')-1) , '%') else CONCAT('".$Get_N_SKU_Type_result[0]."' , '%') End and LANG='en-US' and product_skus.sku in (select contents_product_skus.sku from contents_product_skus where contents_product_skus.slang='EN,' and contents_product_skus.modelcode='".$Get_N_SKU_Type_result[0]."' and contents_product_skus.status=1) order by SKU desc"; //mod 20150520

}else if($m_PType == "JBODJBOF"){
//$Mdname="Server NIC ".$CPUNAME01." : ".GetModelName($link_db,$select);
	$Mdname=GetModelName($link_db,$select);
	$Get_N_SKU_Type="SELECT MODELCODE FROM `p_b_main_jbodjbof` WHERE (JBODFID = ".$r_pid.")";
	$Get_N_SKU_Type_cmd=mysqli_query($link_db,$Get_N_SKU_Type);
	$Get_N_SKU_Type_result=mysqli_fetch_row($Get_N_SKU_Type_cmd);

	$Get_N_SKU_Type_all = "SELECT distinct product_skus.*, ".$r_pid." as pid,'JBODJBOF' as ProductType, CONCAT('NIC_',RTRIM(product_skus.MODELCODE),'_',RTRIM(product_skus.SKU),'') as PSKULINK FROM product_skus INNER JOIN producttypes ON product_skus.ProductTypeID = producttypes.ProductTypeID INNER JOIN vw_modelname ON product_skus.MODELCODE = vw_modelname.ModelCode INNER JOIN p_b_main_jbodjbof ON product_skus.ModelCode = p_b_main_jbodjbof.MODELCODE"; 
$Get_N_SKU_Type_all = $Get_N_SKU_Type_all . " Where product_skus.MODELCODE like Case When locate('-','".$Get_N_SKU_Type_result[0]."')<>0 Then CONCAT(SUBSTRING('".$Get_N_SKU_Type_result[0]."', 1, locate('-','".$Get_N_SKU_Type_result[0]."')-1) , '%') else CONCAT('".$Get_N_SKU_Type_result[0]."' , '%') End and LANG='en-US' and product_skus.sku in (select contents_product_skus.sku from contents_product_skus where contents_product_skus.slang='EN,' and contents_product_skus.modelcode='".$Get_N_SKU_Type_result[0]."' and contents_product_skus.status=1) order by SKU desc"; //mod 20150520

}else if($m_PType == "OCPRack"){
//$Mdname="Server Adapters (Mezzanine Cards): ".GetModelName($link_db,$select);
	$Mdname=GetModelName($link_db,$select);
	$Get_N_SKU_Type="SELECT MODELCODE FROM `p_b_main_ocprack` WHERE (OCPRACKID = ".$r_pid.")";
	$Get_N_SKU_Type_cmd=mysqli_query($link_db,$Get_N_SKU_Type);
	$Get_N_SKU_Type_result=mysqli_fetch_row($Get_N_SKU_Type_cmd);

	$Get_N_SKU_Type_all = "SELECT distinct product_skus.*, ".$r_pid." as pid,'OCPRack' as ProductType, CONCAT('GPUMezz',RTRIM(product_skus.MODELCODE),'_',RTRIM(product_skus.SKU),'') as PSKULINK FROM product_skus INNER JOIN producttypes ON product_skus.ProductTypeID = producttypes.ProductTypeID INNER JOIN vw_modelname ON product_skus.MODELCODE = vw_modelname.ModelCode INNER JOIN p_b_main_ocprack ON product_skus.ModelCode = p_b_main_ocprack.MODELCODE"; 
	$Get_N_SKU_Type_all = $Get_N_SKU_Type_all . " Where product_skus.MODELCODE like Case When locate('-','".$Get_N_SKU_Type_result[0]."')<>0 Then CONCAT(SUBSTRING('".$Get_N_SKU_Type_result[0]."', 1, locate('-','".$Get_N_SKU_Type_result[0]."')-1) , '%') else CONCAT('".$Get_N_SKU_Type_result[0]."' , '%') End and LANG='en-US' and product_skus.sku in (select contents_product_skus.sku from contents_product_skus where contents_product_skus.slang='EN,' and contents_product_skus.modelcode='".$Get_N_SKU_Type_result[0]."' and contents_product_skus.status=1) order by SKU desc"; //mod 20150520
//echo $Get_N_SKU_Type_all;exit();
}else if($m_PType == "POS"){
//$Mdname="Server Adapters (Mezzanine Cards): ".GetModelName($link_db,$select);
	$Mdname=GetModelName($link_db,$select);
	$Get_N_SKU_Type="SELECT MODELCODE FROM `p_b_main_pos` WHERE (POSID = ".$r_pid.")";
	$Get_N_SKU_Type_cmd=mysqli_query($link_db,$Get_N_SKU_Type);
	$Get_N_SKU_Type_result=mysqli_fetch_row($Get_N_SKU_Type_cmd);

	$Get_N_SKU_Type_all = "SELECT distinct product_skus.*, ".$r_pid." as pid,'POS' as ProductType, CONCAT('LANMezz',RTRIM(product_skus.MODELCODE),'_',RTRIM(product_skus.SKU),'') as PSKULINK FROM product_skus INNER JOIN producttypes ON product_skus.ProductTypeID = producttypes.ProductTypeID INNER JOIN vw_modelname ON product_skus.MODELCODE = vw_modelname.ModelCode INNER JOIN p_b_main_pos ON product_skus.ModelCode = p_b_main_pos.MODELCODE"; 
	$Get_N_SKU_Type_all = $Get_N_SKU_Type_all . " Where product_skus.MODELCODE like Case When locate('-','".$Get_N_SKU_Type_result[0]."')<>0 Then CONCAT(SUBSTRING('".$Get_N_SKU_Type_result[0]."', 1, locate('-','".$Get_N_SKU_Type_result[0]."')-1) , '%') else CONCAT('".$Get_N_SKU_Type_result[0]."' , '%') End and LANG='en-US' and product_skus.sku in (select contents_product_skus.sku from contents_product_skus where contents_product_skus.slang='EN,' and contents_product_skus.modelcode='".$Get_N_SKU_Type_result[0]."' and contents_product_skus.status=1) order by SKU desc"; //mod 20150520
}else{
//$Mdname="Server Motherboards ".$CPUNAME01." : ".GetModelName($link_db,$select);
	$Mdname=GetModelName($link_db,$select);
	$Get_N_SKU_Type="SELECT MODELCODE, CPUID FROM p_s_main_systemboards WHERE (SYSTEMBOARDID = ".$r_pid.")";
	$Get_N_SKU_Type_cmd=mysqli_query($link_db,$Get_N_SKU_Type);
	$Get_N_SKU_Type_result=mysqli_fetch_row($Get_N_SKU_Type_cmd);

	$Get_N_SKU_Type_all = "SELECT product_skus.*, ".$r_pid." as pid,'MB' as ProductType, CONCAT('Motherboards_',RTRIM(product_skus.MODELCODE),'_',RTRIM(product_skus.SKU),'') as PSKULINK FROM product_skus INNER JOIN ProductTypes ON product_skus.ProductTypeID = ProductTypes.ProductTypeID INNER JOIN vw_ModelName ON product_skus.MODELCODE = vw_ModelName.ModelCode INNER JOIN p_s_main_systemboards ON product_skus.ModelCode = p_s_main_systemboards.MODELCODE"; 
	$Get_N_SKU_Type_all = $Get_N_SKU_Type_all . " Where product_skus.MODELCODE like Case When locate('-','".$Get_N_SKU_Type_result[0]."')<>0 Then CONCAT(SUBSTRING('".$Get_N_SKU_Type_result[0]."', 1, locate('-','".$Get_N_SKU_Type_result[0]."')-1) , '%') else CONCAT('".$Get_N_SKU_Type_result[0]."' , '%') End and Web_Disable=0 and LANG='en-US' order by SKU desc";
}

$str_getPType="SELECT `CategoryModuID` FROM `contents_product_skus` where `SKU`='".$PSKUs_si."'";
$getPType_cmd=mysqli_query($link_db,$str_getPType);
$getPType_data=mysqli_fetch_row($getPType_cmd);

$str_CategName="SELECT `CategoryModuID`, `CategoryModuName` FROM `category_module_las` where `CategoryModuID`=".$getPType_data[0]." and `slang`='EN'";
$CategName_result=mysqli_query($link_db,$str_CategName);
$CategName_data=mysqli_fetch_row($CategName_result);
if($CategName_data[1]!=''){
	$Category_title=trim($CategName_data[1]).":";
}else{
	$Category_title="";
}

$str_pdesc="SELECT `ID`, `NAME`, `DESCS`, `smmarys`, `LANG`, `MODEL`, `STATUS` FROM `spdescription_list` where concat(',',`MODEL`) like '%".$PSKUs_si.",%' and `LANG`='".$PLang_si."'";
$pdesc_cmd=mysqli_query($link_db,$str_pdesc);
$pdesc_data=mysqli_fetch_row($pdesc_cmd);
$name=$pdesc_data[1];
$descs=$pdesc_data[2];
$smmarys=$pdesc_data[3];

//****************2021/05/11 add Breadcrumb BTO ********
$strBTO="";
$str_bto="SELECT `IS_BTO` FROM `product_skus` WHERE `Product_SKU_Auto_ID`='".$m_SKUs."'";
$bto_cmd=mysqli_query($link_db,$str_bto);
$bto_data=mysqli_fetch_row($bto_cmd);
if($bto_data[0]==1){
	$strBTO="&nbsp;(BTO)";
}else{
	$strBTO="";
}
//****************2021/05/11 add Breadcrumb BTO end ********
?>
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="../images/ico/favicon.ico">	
	<title><?=$prods_docu_title;?><?=$PType_si;?> <?=$PMCode_si;?> <?=$PSKUs_si;?> - Manual, Datasheet</title>
	<!-- Bootstrap -->
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">
	<link href="../css/font-awesome.css" rel="stylesheet">
	<link href="../css/fhmm.css" rel="stylesheet">
	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script type="text/javascript">
	$(function(){
		$("#MVaBtn").click(function() {
			var search_str = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
			var mail_val = $("#mail").val();
			if(search_str.test(mail_val)){
				var form = $('#form_nletter');  
				var formdata = false;
				if (window.FormData){
					formdata = new FormData(form[0]);
				}

				var params = $('#form_nletter').serialize();
				<?php if(isset($_REQUEST['FB_Cid'])!='' && isset($_REQUEST['FB_Lang'])!=''){ ?>
					var url = "subscription_done.php?FB_Cid=<?=$_REQUEST['FB_Cid'];?>&FB_Lang=<?=$_REQUEST['FB_Lang'];?>";
					<?php
				}else{
					?>
					var url = "subscription_done.php?FB_Cid=&FB_Lang=";
					<?php
				}
				?>

				$.ajax({
					type: "post",
					url: url,
					dataType: "html",
					data: formdata ? formdata : form.serialize(),  
					cache: false,
					contentType: false,
					processData: false,  

					success: function(data){
						if(data == "refresh"){	
							$("#sucss_msg").show();
							$("#err_msg").hide();
							$("#mail").val('');
						}
						else{
							$("#sucss_msg").hide();
							$("#err_msg").show();
							$("#mail").val('');	
						}
					}  
				});  
				/* End */
			}else{
				alert("mail format is incorrect!");
				$("#mail").val('');
				$("#sucss_msg").hide();
				$("#err_msg").hide();
			}

		});  
});
</script>

<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>

<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-113958064-1', 'auto');
ga('send', 'pageview');
</script>
</head>
<body> 
	<!--Header logo & global top menu-->
	<?php	
	if($PLang_si=="en-US"){
		include("../top.htm");
	}else if($PLang_si=="ja-JP"){
		include("../top_jp.htm");
	}else if($PLang_si=="zh-CN"){
		include("../top_cn.htm");
	}else if($PLang_si=="zh-TW"){
		include("../top_zh.htm");
	}
	?>
	<!--end Header logo & global top menu-->
	<!--contents-->
	<div class="content_bg">
		<div class="container content_center" >
			<div class="row content_row_center" >
				<!--Breadcrumbs-->
				<div class="row row_bs" >
					<span itemscope itemtype="https://schema.org/breadcrumb"><span itemprop="title"><?=$ProductName01;?></span> &gt; </span>
					<span itemscope itemtype="https://schema.org/breadcrumb"><a itemprop="url" href="<?=$siName_url;?>"><span itemprop="title"> <?=$PType_siName01;?> </span></a> &gt; </span>
					<span itemscope itemtype="https://schema.org/breadcrumb"><a itemprop="url" href="/<?php if(trim($PLang_si01)!="EN"){ echo $PLang_si01."_"; };?><?=$PType_si;?>_<?=$PMCode_si;?>_<?=$PSKUs_si;?>"><span itemprop="title"> <?//=$Category_title;?> <?=$PSKUs_si.$EOL.$strBTO;?></span></a> &gt; </span>
					<span itemscope itemtype="https://schema.org/breadcrumb"><a itemprop="url" href="#"><span itemprop="title"> Overview</span></a> </span>
				</div>
				<!--end Breadcrumbs-->
				<!--Product name-->
				<div class="row" >
					<h1 class="product_name"><?=$Mdname.$strBTO;?></h1>
				</div>
				<!--end Product name-->
				<?php
				/* Mod 20150520 Start */
				$str_Pimg="SELECT `ProductFile`, `ProductBFile`,`MODELDESCRIPT`, `legend_val` FROM `contents_product_skus` where `SKU`='".str_replace(".php","",$PSKUs_si)."'";
				$Pimg_cmd=mysqli_query($link_db,$str_Pimg);
				$Ping_data=mysqli_fetch_row($Pimg_cmd);
				$legend_val01=$Ping_data[3];
				/* Mod 20150520 End */
				$image_arr=explode(",",$Ping_data[0]); //多圖切割
				$arr_num=count($image_arr); 
				?>
				<div class="row">
					<div class="col-xs-6 col-md-4 text-right" style="padding:0px 0px 0px 40px">
						<!--product image+icon-->
						<div>
							<?php
							if($arr_num>1){
								echo "<div id='carousel-example-generic' class='carousel slide' data-ride='carousel' data-interval='false'>";

								echo "<div class='carousel-inner'>";
								for($i=0; $i<$arr_num; $i++) {
									if($image_arr[$i]!=""){
									?>
									<div class="item <?php if($i==0){echo "active";}?> ">
										<img src="<?=$prod_imgurl.$image_arr[$i]?>">
									</div>
									<?php
									}
								
								}
								echo "</div>";
								//echo "</div>";
								?>
								<!-- Controls -->
								<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
									<span class="glyphicon glyphicon-chevron-left" style="color:#00ffff"></span>
								</a>
								<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
									<span class="glyphicon glyphicon-chevron-right" style="color:#00ffff"></span>
								</a>
								</div>
								<br /> <br /> <span class="label label-default"><?=$legend_val01;?></span>
								<a href="<?=$Ping_data[1];?>" target="tyan" /><img src="../images/icon_zoomin.gif" title="Click to Download"  /></a>
									
							<?php
							}else{
								if($Ping_data[0]!=''){
								?>
								<a href="<?=$Ping_data[1];?>" target="tyan" /><img src="
									<?php 
									if(strpos($Ping_data[0],'~')!='' || strpos($Ping_data[0],'~')===0){
										echo str_replace('~','',$Ping_data[0]);
									}else{
										echo str_replace('.','',$prod_imgurl).$Ping_data[0];
									}
									?>" /></a><br /><br /> <span class="label label-default"><?=$legend_val01;?></span>
									<a href="<?=$Ping_data[1];?>" target="tyan" /><img src="../images/icon_zoomin.gif" title="Click to Download"  /></a><br />
									<?php
								}else{
									?>
									<a href="<?=$FTPIMG01;?>" target="tyan" /><img src="../images/icon_zoomin.gif" title="Click to Download"  /></a><br /> <span class="label label-default"><?=$legend_val01;?></span>
									<?php
								}
							}

			
								?>  
							</div> 
							<div ></div>
							<!--end product image+icon-->  
						</div>
						<div class="col-xs-12 col-md-8 col_padding20"  >  
							<!--Top icons-->
							<div style="margin-left:40px">
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
								$CPS_str="SELECT `img`,`url` FROM `c_sp_icon` where `img` IN (".$a.") ORDER BY `c_sp_icon`.`order` ASC";
								$CPS_cmd=mysqli_query($link_db,$CPS_str);
								while($CPS_result=mysqli_fetch_row($CPS_cmd)){
									if(trim($CPS_result[1])!='' && $CPS_result[1]!='http://'){
										$imgname=str_replace("./","",$CPS_result[0]);
										echo "<a href='".$CPS_result[1]."' target='icons' /><img src=".$imgname." /></a>&nbsp;";
									}else{
										$imgname=str_replace("./","",$CPS_result[0]);
										echo "<img src=".$imgname." data-toggle='tooltip' data-placement='bottom' data-html='true' title='$CPS_result[2]'>&nbsp;";
									}
								}
								?>
							</div>
							<!--Top icons end--> 
							<!--Product Summary-->
							<div style="margin-left:40px; ">
								<?=$smmarys;?>
							</div> 
							<!--end Product Summary-->
							<!--Bottom icons-->
							<div style="margin-left:40px">
								<?php
								$PIcons_split_b=explode(",",$PIcons_data[1],-1);
							//***************2018.02.12 修改icon排序***************
								$a="";
								foreach ($PIcons_split_b as $PIcons_split_all_b) {
									if($a==Null){
										$a = "'./images/logo/".$PIcons_split_all_b."'";
									}else{
										$a.= ",'./images/logo/".$PIcons_split_all_b."'";
									}
								}
								$CPS_b_str="SELECT `img`, `url`, `tooltips` FROM `c_sp_icon` where `img` IN (".$a.") ORDER BY `c_sp_icon`.`order` ASC";
								$CPS_b_cmd=mysqli_query($link_db,$CPS_b_str);
								while($CPS_b_result=mysqli_fetch_row($CPS_b_cmd)){
									if(trim($CPS_b_result[1])!='' && $CPS_b_result[1]!='http://'){
										$imgname=str_replace("./","",$CPS_b_result[0]);
										echo "<a href='".$CPS_b_result[1]."' target='icons' /><img src=".$imgname." /></a>&nbsp;";
									}else{
										$imgname=str_replace("./","",$CPS_b_result[0]);
										echo "<img src=".$imgname." data-toggle='tooltip' data-placement='bottom' data-html='true' title='$CPS_b_result[2]'>&nbsp;";
									}
								}
								?>
							</div>
							<!--Bottom icons end --> 
							<!--buttons-->	  
							<div style="margin-left:40px">
								<div class="btn-group"></div>
								<br /><br />
							</div>
							<!--end buttons-->	 
						</div>
					</div>
<!--
<div>&nbsp;</div>
<div>&nbsp;</div>-->
<div class="row col_padding20" >
	<!--product description contents-->
	<!--tabs-->
	<ul class="nav nav-tabs">
		<li class="active" ><a href="#dt1" data-toggle="tab"><?=$PDName01;?></a></li>
		<li><a href="/<?php if(trim($PLang_si01)!="EN"){ echo $PLang_si01."_"; };?><?=$PType_si;?>_<?=$PMCode_si;?>_<?=$PSKUs_si;?>"><?=$SPECName01;?></a></li>
		<?php
		$Dashe01="SELECT ID FROM `sp_datasheet` WHERE ((STATUS = 1) AND (MODEL LIKE '%".GetModelCode($r_pid,$PType_si,$link_db,$select).",%')) ORDER BY FILEDATE DESC";
		$Dashe01_cmd=mysqli_query($link_db,$Dashe01);
		$Dashe01_data=mysqli_fetch_row($Dashe01_cmd);
		if($Dashe01_data==true){
			$Dashe01_num=mysqli_num_rows($Dashe01_cmd);
		}else{
			$Dashe01_num=0;
		}
		$Manu01="SELECT ID FROM `sp_manual` WHERE ((STATUS = 1) AND (MODEL LIKE '%".GetModelCode($r_pid,$PType_si,$link_db,$select).",%')) ORDER BY FILEDATE DESC";
		$Manu01_cmd=mysqli_query($link_db,$Manu01);
		$Manu01_data=mysqli_fetch_row($Manu01_cmd);
		if($Manu01_data==true){
			$Manu01_num=mysqli_num_rows($Manu01_cmd);
		}else{
			$Manu01_num=0;
		}	 
		$Fru01="SELECT ID FROM `sp_fru` WHERE ((STATUS = 1) AND (MODEL LIKE '%".GetModelCode($r_pid,$PType_si,$link_db,$select).",%')) ORDER BY FILEDATE DESC";
		$Fru01_cmd=mysqli_query($link_db,$Fru01);
		$Fru01_data=mysqli_fetch_row($Fru01_cmd);
		if($Fru01_data==true){
			$Fru01_num=mysqli_num_rows($Fru01_cmd);
		}else{
			$Fru01_num=0;
		}	 

		if($Dashe01_num>0 || $Manu01_num>0 || $Fru01_num>0){
			?>
			<li><a href="<?=$PType_si;?>~<?=$PMCode_si;?>~<?=str_replace(".php","",$PSKUs_si);?>~documents<?php if(trim($PLang_si01)!="EN"){ echo "~".$PLang_si01; };?>"><?=$DMName01;?></a></li>
			<?php
		}
		
		$BIOS01="SELECT `ID` FROM `sp_bios` WHERE ((STATUS = 1) AND (MODEL LIKE '%".GetModelCode($r_pid,$PType_si,$link_db,$select).",%' or MODEL LIKE '%".$PSKUs_si."%'))ORDER BY FILEDATE DESC";
		$BIOS01_cmd=mysqli_query($link_db,$BIOS01);
		$BIOS01_data=mysqli_fetch_row($BIOS01_cmd);
		if($BIOS01_data==true){
			$BIOS01_num=mysqli_num_rows($BIOS01_cmd);
		}else{
			$BIOS01_num=0;
		}
		
		$DRVER01="SELECT `ID` FROM `sp_driver` WHERE ((STATUS = 1) AND (MODEL LIKE '%".GetModelCode($r_pid,$PType_si,$link_db,$select).",%' or MODEL LIKE '%".$PSKUs_si."%'))ORDER BY FILEDATE DESC";
		$DRVER01_cmd=mysqli_query($link_db,$DRVER01);
		$DRVER01_data=mysqli_fetch_row($DRVER01_cmd);
		if($DRVER01_data==true){
			$DRVER01_num=mysqli_num_rows($DRVER01_cmd);
		}else{
			$DRVER01_num=0;
		}

		if($BIOS01_num>0 || $DRVER01_num>0){
			?>
			<li><a href="<?=$PType_si;?>=<?=$PMCode_si;?>=<?=str_replace(".php","",$PSKUs_si);?>=downloads<?php if(trim($PLang_si01)!="EN"){ echo "=".$PLang_si01; };?>"><?=$DLName01;?></a></li>
			<?php
		}

		$Memry01="SELECT `ID` FROM `sp_memory` WHERE ((STATUS = 1) AND (MODEL LIKE '%".GetModelCode($r_pid,$PType_si,$link_db,$select).",%')) ORDER BY `ID` DESC";
		$Memry01_cmd=mysqli_query($link_db,$Memry01);
		$Memry01_data=mysqli_fetch_row($Memry01_cmd);
		if($Memry01_data==true){
			$Memry01_num=mysqli_num_rows($Memry01_cmd);
		}else{
			$Memry01_num=0;
		}
		$Hdd01="SELECT `ID` FROM `sp_hdd` WHERE ((STATUS = 1) AND (MODEL LIKE '%".GetModelCode($r_pid,$PType_si,$link_db,$select).",%')) ORDER BY `ID` DESC";
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
		?>
		<li ><a href="<?=$PType_si;?>@<?=$PMCode_si;?>@<?=str_replace(".php","",$PSKUs_si);?>@supports<?php if(trim($PLang_si01)!="EN"){ echo "@".$PLang_si01; };?>"><?=$SPName01;?></a></li>
		<?php
		}

		if(GetPreviewVal($r_pid,$link_db,$select)){
			?>
			<li><a href="<?=$PType_si;?>=<?=$PMCode_si;?>=<?=str_replace(".php","",$PSKUs_si);?>=preview<?php if(trim($PLang_si01)!="EN"){ echo "=".$PLang_si01; };?>"><?=$PRName01;?></a></li>
			<?php
		}
		?>	 
		<?php
		$tab_contant="";
		$str_exp="SELECT `ID`, `DESNAME`, `NAME`, `DESCS`, `RETURN_URL`, `URL` FROM `spexptabs_list` WHERE instr(`MODEL`,'".str_replace(".php","",$PSKUs_si)."')>0 and `LANG`='".$PLang_si."' and `STATUS`=1";
		$exp_cmd=mysqli_query($link_db,$str_exp);
		$i=1;
		while($exp_data=mysqli_fetch_row($exp_cmd)){
			$i+=1;
			if($exp_data[4]==0){
				echo "<li><a href='#dt".$i."' data-toggle='tab'>".$exp_data[2]."</a></li>";
				$tab_contant.="<div class=tab-pane active id=dt".$i.">".trim($exp_data[3])."</div>";
			}else if($exp_data[4]==1){
				echo "<li><a href='".$exp_data[5]."' target='_blank'>".$exp_data[2]."</a></li>";
			}		 
		}
		?>
	</ul>
	<!--end tabs-->
	<div class="tab-content">
		<div class="tab-pane active" id="dt1">
			<!--SKUs groups-->
			
			<!--end of SKUs groups-->
			<?=$descs;?>
			<br /><br />
		</div>
		<?=$tab_contant;?>
	</div>
	<!--end of product description contents-->
</div>
</div>
</div>
</div>
<!--end contents-->
<!-- FOOTER -->
<?php
if($PLang_si=="en-US"){
	include("../foot.htm");
}else if($PLang_si=="ja-JP"){
	include("../foot_jp.htm");
}else if($PLang_si=="zh-CN"){
	include("../foot_cn.htm");
}else if($PLang_si=="zh-TW"){
	include("../foot_zh.htm");
}
?>
<div id="go-top" style="display: block;"><a title="Back to Top" href="#">Go To Top</a></div>
<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/docs.min.js"></script>
	<script>
	$('#example').tooltip(options)
	</script>	
</body>
</html>