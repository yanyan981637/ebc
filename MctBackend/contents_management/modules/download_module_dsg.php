<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

require "../../config.php";
include_once('../../page.class.php');
error_reporting(0);

session_set_cookie_params(8*60*60); 
@session_start();

if(empty($_SESSION['user']) || empty($_SESSION['password']) || empty($_SESSION['login_time'])){
echo "<script language='JavaScript'>location='../../login.php'</script>";
exit();
}

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
  //$str = str_replace("=","",$str);
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

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

$kinds=filter_var($_GET['kinds']);

if($kinds=='Del'){
	$did01=filter_var($_GET['d_id']);
  $str_del="DELETE FROM dsg_download WHERE ID=".$did01;
  $del_cmd=mysqli_query($link_db,$str_del);
  echo "<script>alert('Delete the Data!');self.location='download_module_dsg.php'</script>";
  exit();
}

if($kinds=='add_CD'){
	$add_sel=$_POST['add_sel'];
	$add_sel=filter_var($add_sel);

	$add_mm=dowith_sql($_POST['add_mm']);
	$add_mm=filter_var($add_mm);

	$add_p_code=dowith_sql($_POST['add_p_code']);
	$add_p_code=filter_var($add_p_code);

	$add_bmcID=dowith_sql($_POST['add_bmcID']);
	$add_bmcID=filter_var($add_bmcID);

	$add_model=dowith_sql($_POST['add_model']);
	$add_model=filter_var($add_model);

	$add_p_name=dowith_sql($_POST['add_p_name']);
	$add_p_name=filter_var($add_p_name);


	$add_os="";
	if(isset($_POST['add_os'])!=''){
		foreach($_POST['add_os'] as $add_os_val)
		{
			$add_os.=$add_os_val.";";
		}
	}else{
		$add_os="";
	}

	$add_f_name=dowith_sql($_POST['add_f_name']);
	$add_f_name=filter_var($add_f_name);

	$add_date=dowith_sql($_POST['add_date']);
	$add_date=filter_var($add_date);

	$add_fw_v=dowith_sql($_POST['add_fw_v']);
	$add_fw_v=filter_var($add_fw_v);

	$add_FZ=dowith_sql($_POST['add_FZ']);
	$add_FZ=filter_var($add_FZ);

	$add_FD=$_POST['add_FD'];
	$add_FD=filter_var($add_FD);

	$add_FL=dowith_sql($_POST['add_FL']);
	$add_FL=filter_var($add_FL);

	$add_note=dowith_sql($_POST['add_note']);
	$add_note=filter_var($add_note);

	$add_nic=dowith_sql($_POST['add_nic']);
	$add_nic=filter_var($add_nic);

	$add_series=dowith_sql($_POST['add_series']);
	$add_series=filter_var($add_series);

	$add_FF=dowith_sql($_POST['add_FF']);
	$add_FF=filter_var($add_FF);

	$add_capacity=dowith_sql($_POST['add_capacity']);
	$add_capacity=filter_var($add_capacity);

	$add_supID=dowith_sql($_POST['add_supID']);
	$add_supID=filter_var($add_supID);

	$add_SFUP=dowith_sql($_POST['add_SFUP']);
	$add_SFUP=filter_var($add_SFUP);

	$add_FUT=dowith_sql($_POST['add_FUT']);
	$add_FUT=filter_var($add_FUT);

	$add_MAS=dowith_sql($_POST['add_MAS']);
	$add_MAS=filter_var($add_MAS);

	$add_SST=dowith_sql($_POST['add_SST']);
	$add_SST=filter_var($add_SST);

	$add_RFU=dowith_sql($_POST['add_RFU']);
	$add_RFU=filter_var($add_RFU);

	$add_e_ids=dowith_sql($_POST['add_e_ids']);
	$add_e_ids=filter_var($add_e_ids);

	$add_EFI=dowith_sql($_POST['add_EFI']);
	$add_EFI=filter_var($add_EFI);

	$add_Linux=dowith_sql($_POST['add_Linux']);
	$add_Linux=filter_var($add_Linux);

	$add_windows=dowith_sql($_POST['add_windows']);
	$add_windows=filter_var($add_windows);

	$add_VM=dowith_sql($_POST['add_VM']);
	$add_VM=filter_var($add_VM);

	$add_Type=dowith_sql($_POST['add_Type']);
	$add_Type=filter_var($add_Type);

	$add_EULA=dowith_sql($_POST['add_EULA']);
	$add_EULA=filter_var($add_EULA);

	$relProd_val=dowith_sql($_POST['relProd_val']);
	$relProd_val=filter_var($relProd_val);

	$add_status=dowith_sql($_POST['add_status']);
	$add_status=filter_var($add_status);
	
	$add_brandtype=dowith_sql($_POST['add_brandtype']);
	$add_brandtype=filter_var($add_brandtype);

	$strID="SELECT CMPT_ID FROM dsg_download ORDER BY CMPT_ID DESC";
	$cmdID=mysqli_query($link_db,$strID);
	$number=mysqli_fetch_row($cmdID);
	if($number[0]!=0){
		$countID=$number[0]+1;
	}else{
		$countID="10000001";
	}

	$add_Release_Type=dowith_sql($_POST['add_Release_Type']);
	$add_Release_Type=filter_var($add_Release_Type);

	$insertTmp="CMPT_ID, CMPT_classification, Download_Type, mm_number, product_code, bmc_id, model, product_name, OS, File_Name, File_Date, Version, File_size, File_Description, File_Location, Notes, nic_product_code, series, form_factor, capacity, SUP_ID, SFUP, FUT, MAS, SST, RFU, etrack_ids, EFI, Linux, Windows, VMWare, EULA_modal, Models, Status, C_DATE, brand_type, Release_Type";

	$str="INSERT INTO dsg_download (".$insertTmp.") VALUES ";
	$str.="('".$countID."','".$add_sel."','".$add_Type."','".$add_mm."','".$add_p_code."','".$add_bmcID."','".$add_model."','".$add_p_name."','".$add_os."','".$add_f_name."','".$add_date."','".$add_fw_v."','".$add_FZ."','".$add_FD."','".$add_FL."','".$add_note."','".$add_nic."','".$add_series."','".$add_FF."','".$add_capacity."','".$add_supID."','".$add_SFUP."','".$add_FUT."','".$add_MAS."','".$add_SST."','".$add_RFU."','".$add_e_ids."','".$add_EFI."','".$add_Linux."','".$add_windows."','".$add_VM."','".$add_EULA."','".$relProd_val."','".$add_status."','".$now."','".$add_brandtype."','".$add_Release_Type."')";
	if(mysqli_query($link_db,$str)){
		echo "<script>alert('Add DSG Download done!');self.location='download_module_dsg.php'</script>";
	}else{
		echo "<script>alert('Add DSG Download fail!');self.location='download_module_dsg.php'</script>";
	}
	exit();
}

if($kinds=='edit_CD'){
	$edit_ID=$_POST['edit_ID'];
	$edit_ID=filter_var($edit_ID);

	$edit_sel=$_POST['edit_sel'];
	$edit_sel=filter_var($edit_sel);

	$edit_mm=dowith_sql($_POST['edit_mm']);
	$edit_mm=filter_var($edit_mm);

	$edit_p_code=dowith_sql($_POST['edit_p_code']);
	$edit_p_code=filter_var($edit_p_code);

	$edit_bmcID=dowith_sql($_POST['edit_bmcID']);
	$edit_bmcID=filter_var($edit_bmcID);

	$edit_model=dowith_sql($_POST['edit_model']);
	$edit_model=filter_var($edit_model);

	$edit_p_name=dowith_sql($_POST['edit_p_name']);
	$edit_p_name=filter_var($edit_p_name);


	$edit_os="";
	if(isset($_POST['edit_os'])!=''){
		foreach($_POST['edit_os'] as $edit_os_val)
		{
			$edit_os.=$edit_os_val.";";
		}
	}else{
		$edit_os="";
	}

	$edit_f_name=dowith_sql($_POST['edit_f_name']);
	$edit_f_name=filter_var($edit_f_name);

	$edit_date=dowith_sql($_POST['edit_date']);
	$edit_date=filter_var($edit_date);

	$edit_fw_v=dowith_sql($_POST['edit_fw_v']);
	$edit_fw_v=filter_var($edit_fw_v);

	$edit_FZ=dowith_sql($_POST['edit_FZ']);
	$edit_FZ=filter_var($edit_FZ);

	$edit_FD=str_replace("'","’",$_POST['edit_FD']);
	$edit_FD=filter_var($edit_FD);

	$edit_FL=dowith_sql($_POST['edit_FL']);
	$edit_FL=filter_var($edit_FL);

	$edit_note=dowith_sql($_POST['edit_note']);
	$edit_note=filter_var($edit_note);

	$edit_nic=dowith_sql($_POST['edit_nic']);
	$edit_nic=filter_var($edit_nic);

	$edit_series=dowith_sql($_POST['edit_series']);
	$edit_series=filter_var($edit_series);

	$edit_FF=dowith_sql($_POST['edit_FF']);
	$edit_FF=filter_var($edit_FF);

	$edit_capacity=dowith_sql($_POST['edit_capacity']);
	$edit_capacity=filter_var($edit_capacity);

	$edit_supID=dowith_sql($_POST['edit_supID']);
	$edit_supID=filter_var($edit_supID);

	$edit_SFUP=dowith_sql($_POST['edit_SFUP']);
	$edit_SFUP=filter_var($edit_SFUP);

	$edit_FUT=dowith_sql($_POST['edit_FUT']);
	$edit_FUT=filter_var($edit_FUT);

	$edit_MAS=dowith_sql($_POST['edit_MAS']);
	$edit_MAS=filter_var($edit_MAS);

	$edit_SST=dowith_sql($_POST['edit_SST']);
	$edit_SST=filter_var($edit_SST);

	$edit_RFU=dowith_sql($_POST['edit_RFU']);
	$edit_RFU=filter_var($edit_RFU);

	$edit_e_ids=dowith_sql($_POST['edit_e_ids']);
	$edit_e_ids=filter_var($edit_e_ids);

	$edit_EFI=dowith_sql($_POST['edit_EFI']);
	$edit_EFI=filter_var($edit_EFI);

	$edit_Linux=dowith_sql($_POST['edit_Linux']);
	$edit_Linux=filter_var($edit_Linux);

	$edit_windows=dowith_sql($_POST['edit_windows']);
	$edit_windows=filter_var($edit_windows);

	$edit_VM=dowith_sql($_POST['edit_VM']);
	$edit_VM=filter_var($edit_VM);

	$edit_Type=dowith_sql($_POST['edit_Type']);
	$edit_Type=filter_var($edit_Type);

	$edit_EULA=dowith_sql($_POST['edit_EULA']);
	$edit_EULA=filter_var($edit_EULA);

	$relProd_valM=dowith_sql($_POST['relProd_valM']);
	$relProd_valM=filter_var($relProd_valM);

	$edit_status=dowith_sql($_POST['edit_status']);
	$edit_status=filter_var($edit_status);

	$edit_brandtype=dowith_sql($_POST['edit_brandtype']);
	$edit_brandtype=filter_var($edit_brandtype);

	$edit_Release_Type=dowith_sql($_POST['edit_Release_Type']);
	$edit_Release_Type=filter_var($edit_Release_Type);

	$updateTmp="CMPT_classification='".$edit_sel."',Download_Type='".$edit_Type."',mm_number='".$edit_mm."',product_code='".$edit_p_code."',bmc_id='".$edit_bmcID."',product_name='".$edit_model."',product_name='".$edit_p_name."',
		OS='".$edit_os."',File_Name='".$edit_f_name."',File_Date='".$edit_date."',Version='".$edit_fw_v."',File_size='".$edit_FZ."',File_Description='".$edit_FD."',File_Location='".$edit_FL."',
		Notes='".$edit_note."',nic_product_code='".$edit_nic."',series='".$edit_series."',form_factor='".$edit_FF."',capacity='".$edit_capacity."',SUP_ID='".$edit_supID."',SFUP='".$edit_SFUP."',
		FUT='".$edit_FUT."',MAS='".$edit_MAS."',SST='".$edit_SST."',RFU='".$edit_RFU."',etrack_ids='".$edit_e_ids."',EFI='".$edit_EFI."',Linux='".$edit_Linux."',Windows='".$edit_windows."',
		VMWare='".$edit_VM."',EULA_modal='".$edit_EULA."',Models='".$relProd_valM."',Status='".$edit_status."',brand_type='".$edit_brandtype."',U_DATE='".$now."',Release_Type='".$edit_Release_Type."'";
	$str="UPDATE dsg_download SET ".$updateTmp." WHERE ID='".$edit_ID."'";
	//echo $str;exit;
	if(mysqli_query($link_db,$str)){
		echo "<script>alert('Edit DSG Download done!');self.location='download_module_dsg.php'</script>";
	}else{
		echo "<script>alert('Edit DSG Download fail!');self.location='download_module_dsg.php'</script>";
	}
	exit();
}

/*$str_CPMT_edit="SELECT ID, Name, Type FROM c_sp_cmpt WHERE 1";
$CPMT_cmd_edit=mysqli_query($link_db,$str_CPMT_edit);
while ($CPMT_data_edit=mysqli_fetch_row($CPMT_cmd_edit)) {
	$arr_CPMT[$CPMT_data_edit[0]]=$CPMT_data_edit[1];
}*/


if(isset($_GET['sel_type'])<>''){
	$sInput=dowith_sql($_GET['sInput']);
	$sInput=filter_var($sInput);

	$sel_type=filter_var($_GET['sel_type']);
	if($sel_type=="FN"){ //File Name
		$str1="SELECT count(*) FROM dsg_download WHERE File_Name='".$sInput."'";
	}else if($sel_type=="PC"){ //product_code
		$str1="SELECT count(*) FROM dsg_download WHERE product_code='".$sInput."'";
	}else if($sel_type=="Mo"){ //Model
		$str1="SELECT count(*) FROM dsg_download WHERE model='".$sInput."'";
	}else if($sel_type=="PN"){ //product_name
		$str1="SELECT count(*) FROM dsg_download WHERE product_name='".$sInput."'";
	}else if($sel_type=="SUPID"){ //SUP_ID
		$str1="SELECT count(*) FROM dsg_download WHERE SUP_ID='".$sInput."'";
	}
}else{	 
	$str1="SELECT count(*) FROM dsg_download";
}
$list1 =mysqli_query($link_db,$str1);
list($public_count) = mysqli_fetch_row($list1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Website Contents Management - Products Management - Contents: Modules - DSG Components Download</title>
<link rel=stylesheet type="text/css" href="../../backend.css">

<script type="text/javascript" src="../../lib/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="../../lib/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="../../source/jquery.fancybox.js?v=2.0.6"></script>
<link rel="stylesheet" type="text/css" href="../../source/jquery.fancybox.css?v=2.0.6" media="screen" />
<link rel="stylesheet" type="text/css" href="../../source/helpers/jquery.fancybox-buttons.css?v=1.0.2" />
<script type="text/javascript" src="../../source/helpers/jquery.fancybox-buttons.js?v=1.0.2"></script>


<script type="text/javascript">
	function HS_DateAdd(interval,number,date){
		number = parseInt(number);
		if (typeof(date)=="string"){var date = new Date(date.split("-")[0],date.split("-")[1],date.split("-")[2])}
			if (typeof(date)=="object"){var date = date}
				switch(interval){
					case "y":return new Date(date.getFullYear()+number,date.getMonth(),date.getDate()); break;
					case "m":return new Date(date.getFullYear(),date.getMonth()+number,checkDate(date.getFullYear(),date.getMonth()+number,date.getDate())); break;
					case "d":return new Date(date.getFullYear(),date.getMonth(),date.getDate()+number); break;
					case "w":return new Date(date.getFullYear(),date.getMonth(),7*number+date.getDate()); break;
				}
			}
			function checkDate(year,month,date){
				var enddate = ["31","28","31","30","31","30","31","31","30","31","30","31"];
				var returnDate = "";
				if (year%4==0){enddate[1]="29"}
					if (date>enddate[month]){returnDate = enddate[month]}else{returnDate = date}
						return returnDate;
				}
				function WeekDay(date){
					var theDate;
					if (typeof(date)=="string"){theDate = new Date(date.split("-")[0],date.split("-")[1],date.split("-")[2]);}
					if (typeof(date)=="object"){theDate = date}
						return theDate.getDay();
				}
				function HS_calender(){
					var lis = "";
					var style = "";
					style +="<style type='text/css'>";
					style +=".calender { width:170px; height:auto; font-size:12px; margin-right:14px; background:url(calenderbg.gif) no-repeat right center #fff; border:1px solid #397EAE; padding:1px}";
					style +=".calender ul {list-style-type:none; margin:0; padding:0;}";
					style +=".calender .day { background-color:#EDF5FF; height:20px;}";
					style +=".calender .day li,.calender .date li{ float:left; width:14%; height:20px; line-height:20px; text-align:center}";
					style +=".calender li a { text-decoration:none; font-family:Tahoma; font-size:11px; color:#333}";
					style +=".calender li a:hover { color:#f30; text-decoration:underline}";
					style +=".calender li a.hasArticle {font-weight:bold; color:#f60 !important}";
					style +=".lastMonthDate, .nextMonthDate {color:#bbb;font-size:11px}";
					style +=".selectThisYear a, .selectThisMonth a{text-decoration:none; margin:0 2px; color:#000; font-weight:bold}";
					style +=".calender .LastMonth, .calender .NextMonth{ text-decoration:none; color:#000; font-size:18px; font-weight:bold; line-height:16px;}";
					style +=".calender .LastMonth { float:left;}";
					style +=".calender .NextMonth { float:right;}";
					style +=".calenderBody {clear:both}";
					style +=".calenderTitle {text-align:center;height:20px; line-height:20px; clear:both}";
					style +=".today { background-color:#ffffaa;border:1px solid #f60; padding:2px}";
					style +=".today a { color:#f30; }";
					style +=".calenderBottom {clear:both; border-top:1px solid #ddd; padding: 3px 0; text-align:left}";
					style +=".calenderBottom a {text-decoration:none; margin:2px !important; font-weight:bold; color:#000}";
					style +=".calenderBottom a.closeCalender{float:right}";
					style +=".closeCalenderBox {float:right; border:1px solid #000; background:#fff; font-size:9px; width:11px; height:11px; line-height:11px; text-align:center;overflow:hidden; font-weight:normal !important}";
					style +="</style>";
					var now;
					if (typeof(arguments[0])=="string"){
						selectDate = arguments[0].split("-");
						var year = selectDate[0];
						var month = parseInt(selectDate[1])-1+"";
						var date = selectDate[2];
						now = new Date(year,month,date);
					}else if (typeof(arguments[0])=="object"){
						now = arguments[0];
					}
					var lastMonthEndDate = HS_DateAdd("d","-1",now.getFullYear()+"-"+now.getMonth()+"-01").getDate();
					var lastMonthDate = WeekDay(now.getFullYear()+"-"+now.getMonth()+"-01");
					var thisMonthLastDate = HS_DateAdd("d","-1",now.getFullYear()+"-"+(parseInt(now.getMonth())+1).toString()+"-01");
					var thisMonthEndDate = thisMonthLastDate.getDate();
					var thisMonthEndDay = thisMonthLastDate.getDay();
					var todayObj = new Date();
					today = todayObj.getFullYear()+"-"+todayObj.getMonth()+"-"+todayObj.getDate();
for (i=0; i<lastMonthDate; i++){  // Last Month's Date
	lis = "<li class='lastMonthDate'>"+lastMonthEndDate+"</li>" + lis;
lastMonthEndDate--;
}
for (i=1; i<=thisMonthEndDate; i++){ // Current Month's Date
	if(today == now.getFullYear()+"-"+now.getMonth()+"-"+i){
		var todayString = now.getFullYear()+"-"+(parseInt(now.getMonth())+1).toString()+"-"+i;
		lis += "<li><a href=javascript:void(0) class='today' onclick='_selectThisDay(this)' title='"+now.getFullYear()+"-"+(parseInt(now.getMonth())+1)+"-"+i+"'>"+i+"</a></li>";
	}else{
		lis += "<li><a href=javascript:void(0) onclick='_selectThisDay(this)' title='"+now.getFullYear()+"-"+(parseInt(now.getMonth())+1)+"-"+i+"'>"+i+"</a></li>";
	}
}
var j=1;
for (i=thisMonthEndDay; i<6; i++){  // Next Month's Date
	lis += "<li class='nextMonthDate'>"+j+"</li>";
j++;
}
lis += style;
var CalenderTitle = "<a href='javascript:void(0)' class='NextMonth' onclick=HS_calender(HS_DateAdd('m',1,'"+now.getFullYear()+"-"+now.getMonth()+"-"+now.getDate()+"'),this) title='Next Month'>»</a>";
CalenderTitle += "<a href='javascript:void(0)' class='LastMonth' onclick=HS_calender(HS_DateAdd('m',-1,'"+now.getFullYear()+"-"+now.getMonth()+"-"+now.getDate()+"'),this) title='Previous Month'>«</a>";
CalenderTitle += "<span class='selectThisYear'><a href='javascript:void(0)' onclick='CalenderselectYear(this)' title='Click here to select other year' >"+now.getFullYear()+"</a></span>年<span class='selectThisMonth'><a href='javascript:void(0)' onclick='CalenderselectMonth(this)' title='Click here to select other month'>"+(parseInt(now.getMonth())+1).toString()+"</a></span>月";
if (arguments.length>1){
	arguments[1].parentNode.parentNode.getElementsByTagName("ul")[1].innerHTML = lis;
	arguments[1].parentNode.innerHTML = CalenderTitle;
}else{
	var CalenderBox = style+"<div class='calender'><div class='calenderTitle'>"+CalenderTitle+"</div><div class='calenderBody'><ul class='day'><li>日</li><li>一</li><li>二</li><li>三</li><li>四</li><li>五</li><li>六</li></ul><ul class='date' id='thisMonthDate'>"+lis+"</ul></div><div class='calenderBottom'><a href='javascript:void(0)' class='closeCalender' onclick='closeCalender(this)'>×</a><span><span><a href=javascript:void(0) onclick='_selectThisDay(this)' title='"+todayString+"'>Today</a></span></span></div></div>";
	return CalenderBox;
}
}
function _selectThisDay(d){
	var boxObj = d.parentNode.parentNode.parentNode.parentNode.parentNode;
	boxObj.targetObj.value = d.title;
	boxObj.parentNode.removeChild(boxObj);
}
function closeCalender(d){
	var boxObj = d.parentNode.parentNode.parentNode;
	boxObj.parentNode.removeChild(boxObj);
}
function CalenderselectYear(obj){
	var opt = "";
	var thisYear = obj.innerHTML;
	for (i=1970; i<=2020; i++){
		if (i==thisYear){
			opt += "<option value="+i+" selected>"+i+"</option>";
		}else{
			opt += "<option value="+i+">"+i+"</option>";
		}
	}
	opt = "<select onblur='selectThisYear(this)' onchange='selectThisYear(this)' style='font-size:11px'>"+opt+"</select>";
	obj.parentNode.innerHTML = opt;
}
function selectThisYear(obj){
	HS_calender(obj.value+"-"+obj.parentNode.parentNode.getElementsByTagName("span")[1].getElementsByTagName("a")[0].innerHTML+"-1",obj.parentNode);
}
function CalenderselectMonth(obj){
	var opt = "";
	var thisMonth = obj.innerHTML;
	for (i=1; i<=12; i++){
		if (i==thisMonth){
			opt += "<option value="+i+" selected>"+i+"</option>";
		}else{
			opt += "<option value="+i+">"+i+"</option>";
		}
	}
	opt = "<select onblur='selectThisMonth(this)' onchange='selectThisMonth(this)' style='font-size:11px'>"+opt+"</select>";
	obj.parentNode.innerHTML = opt;
}
function selectThisMonth(obj){
	HS_calender(obj.parentNode.parentNode.getElementsByTagName("span")[0].getElementsByTagName("a")[0].innerHTML+"-"+obj.value+"-1",obj.parentNode);
}
function HS_setDate(inputObj){
	var calenderObj = document.createElement("span");
	calenderObj.innerHTML = HS_calender(new Date());
	calenderObj.style.position = "absolute";
	calenderObj.targetObj = inputObj;
	inputObj.parentNode.insertBefore(calenderObj,inputObj.nextSibling);
}
</script>
<script type="text/javascript">
$(document).ready(function() {
	/*
	 *  Simple image gallery. Uses default settings
	 */

	$('.fancybox').fancybox();

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

function search(){
	var selType=$("#selType").val();
	var Input=$("#sInput").val();
  self.location='download_module_dsg.php?sel_type='+selType+'&sInput='+Input;
}

function show_AddCMPT(){
  $("#add_com").show();
  $("#edit_com").hide();
}

function MM_o(selObj){
	window.open(document.getElementById('components_page').options[document.getElementById('components_page').selectedIndex].value,"_self");
}
</script>





</head>

<body>
<a name="top"></a>
<div >
<div class="left"><h1>&nbsp;&nbsp;MCT Website Backends - Website Contents Management - Contents: DSG Download Management</h1></div>

<div id="logout"><a href="../../login.html">Log out &gt;&gt;</a></div>
</div>

<div class="clear"></div>
<div id="menu">
<ul>
	<li ><a href="../default.html">Products</a>

	</li>
	<li> <a href="../modules.html">Contents</a> 
		<ul>
			<li><a href="../modules.html">Modules</a></li>	  
		</ul>
	</li>
	<li ><a href="../newsletter.html">Newsletters</a>
		<ul><li><a href="../subscribe.html">Subscription</a></li></ul>
	</li>
</ul>
</div>

<div class="clear"></div>

<div id="Search" >
<h2>Contents &nbsp;&gt;&nbsp;  <a href="../modules.html">Modules</a>  &nbsp;&gt;&nbsp; DSG Download management</h2> 
</div>

<div id="content">



<br />
<h3>DSG Download List: (All downloads except for models/SKUs existed in DSG products)
</h3>
<div class="pagination left">
	<p>
		<select id="selType" name="selType">
			<option value="SUPID">SUP_ID</option>
			<option value="FN">File Name</option>
			<option value="PC">product_code</option>
			<option value="Mo">Model</option>
			<option value="PN">product_name</option>
		</select>&nbsp;&nbsp;&nbsp;&nbsp;
		<input id="sInput" name="sInput" type="text" size="30" value=""  /> <input name="" type="button" value="Search" onclick="search()" /> </p>
		<?php
		$parameter="";
		if(isset($_REQUEST['page'])!=""){
			$page=(int)$_REQUEST['page'];
		}else{
			$page="1";
		}

		if(empty($page))$page="1";

		$read_num="10";
		$start_num=$read_num*($page-1); 
		
		$all_page=ceil($public_count/$read_num);
		$pageSize=$page;
		$total=$all_page;
		pageft($total,$pageSize,1,0,0,15);

		$parameter=$_SERVER['QUERY_STRING'];  
		if($parameter!=""){
			$parameter.=$parameter."&"; 
		}	
		?>
		<p>Total: <span class="w14bblue"><?=$public_count?></span> records &nbsp;&nbsp;| &nbsp;&nbsp;<input name="" type="text" size="1" value="<?=$read_num?>" /> Records Per Page &nbsp;&nbsp;| &nbsp;&nbsp;Page: &nbsp;
		<select id="components_page" name="components_page" onChange="MM_o(this)">
			<?php
			for($j=1;$j<=$total;$j++){
				?>
				<option value="?<?=$parameter?>page=<?=$j?>" <?php if($page==$j){ echo "selected"; } ?>><?=$j?></option>
				<?php
			}
			?>
		</select>
	</p>
</div>



	<table class="list_table">

		<tr>
			<th>ID</th>
			<th>File Name</th>
			<th>CMPT_classification <a class="fancybox fancybox.iframe" href="lb_dl_CMPT.php" /><img src="../../images/icon_edit.png" alt="Edit" /></a></th>
			<th>product_code</th>
			<th>Model</th>
			<th>product_name</th>
			<th>File Date</th>
			<th>SUP ID</th>
			<th>Status</th>
			<th><div class="button14" style="width:50px;" onClick="show_AddCMPT()">Add</div></th>
		</tr>
		<?php
		$list="ID, CMPT_ID, CMPT_classification, mm_number, product_code, bmc_id, model, product_name, OS, File_Name, File_Date, Version, File_size, File_Description, File_Location, Notes, nic_product_code, series, form_factor, capacity, SUP_ID, SFUP, FUT, MAS, SST, RFU, etrack_ids, EFI, Linux, Windows, VMWare, Download_Type, EULA_modal, Status, C_DATE";

		if(isset($_GET['sel_type'])<>''){
			$sInput=filter_var($_GET['sInput']);
			
			$sel_type=filter_var($_GET['sel_type']);
			if($sel_type=="FN"){ //File Name
				$strList="SELECT ".$list." FROM dsg_download WHERE File_Name='".$sInput."' ORDER BY ID DESC limit $start_num,$read_num;";
			}else if($sel_type=="PC"){ //product_code
				$strList="SELECT ".$list." FROM dsg_download WHERE product_code='".$sInput."' ORDER BY ID DESC limit $start_num,$read_num;";
			}else if($sel_type=="Mo"){ //Model
				$strList="SELECT ".$list." FROM dsg_download WHERE model='".$sInput."' ORDER BY ID DESC limit $start_num,$read_num;";
			}else if($sel_type=="PN"){ //product_name
				$strList="SELECT ".$list." FROM dsg_download WHERE product_name='".$sInput."' ORDER BY ID DESC limit $start_num,$read_num;";
			}else if($sel_type=="SUPID"){ //SUP_ID
				$strList="SELECT ".$list." FROM dsg_download WHERE SUP_ID='".$sInput."' ORDER BY ID DESC limit $start_num,$read_num;";
			}
		}else{	 
			$strList="SELECT ".$list." FROM dsg_download WHERE 1 ORDER BY ID DESC limit $start_num,$read_num;";
		}
		$cmdList=mysqli_query($link_db,$strList);
		while ($dataList=mysqli_fetch_row($cmdList)) {
			//$CMPT=$arr_CPMT[$dataList[2]];
			$CMPT=$dataList[2];
			if($dataList[33]==1){
				$statue="Online";
			}else{
				$statue="Offline";
			}
		?>
		<tr>
			<td><?=$dataList[1]?></td>
			<td><?=$dataList[9]?></td><td><?=$CMPT?></td><td><?=$dataList[4]?></td><td><?=$dataList[6]?></td><td><?=$dataList[7]?></td><td><?=$dataList[10]?></td>
			<td><?=$dataList[20]?></td>
			<td><?=$statue?></td><td ><a href="?kinds=Edit&id=<?=$dataList[0]?>">Edit</a>&nbsp;&nbsp;<a href="?kinds=Del&d_id=<?=$dataList[0]?>">Del</a></td>
		</tr> 
		<?php
		}
		?>
		
		
	</table>

	<p style="color:#0F0">- click "Del" 要popup a confirmation window to proceed<br />- List順序:新至舊</p>

	<p >&nbsp;</p><p >&nbsp;</p>




	<p class="clear">&nbsp;</p>




	<!--Click Add -->							
	<div id="add_com" name="add_com" class="subsettings" style="display:none">
		<h1>Add a file</h1>
		<!--Click close to close this subsettings div--><div class="right"><a href="download_module_dsg.php"> [close] </a></div><!--end of close-->
		<form id="form1" name="form1" method="post" action="?kinds=add_CD">
			<table class="addspec">

			<tr style="background-color:#c4e6fb">
				<th>CMPT_classification:  </th>
				<td>
					<select id="add_sel" name="add_sel">
						<option value="none">none</option>
						<?php
						$sel="SELECT ID, Name, Type FROM c_sp_cmpt WHERE Type='CMPT'";
						$cmd=mysqli_query($link_db,$sel);
						while ($data=mysqli_fetch_row($cmd)) {
							echo "<option value=".$data[1].">".$data[1]."</option>";
						}
						?>
					</select>
				</td>
			</tr>
			<tr style="background-color:#c4e6fb">
				<th>Type:  </th>
				<td>
					<select id="add_Type" name="add_Type">
						<?php
						$sel="SELECT ID, Name, Type FROM c_sp_cmpt WHERE Type='Type'";
						$cmd=mysqli_query($link_db,$sel);
						while ($data=mysqli_fetch_row($cmd)) {
							echo "<option value=".$data[0].">".$data[1]."</option>";
						}
						?>
					</select>
				</td>
			</tr>
			<tr style="background-color:#c4e6fb">
				<th>mm_number:  </th>
				<td><input id="add_mm" name="add_mm" type="text" size="40" value=""  />
				</td>
			</tr>
			<tr style="background-color:#c4e6fb">
				<th>product_code:  </th>
				<td><input id="add_p_code" name="add_p_code" type="text" size="40" value=""  />
				</td>
			</tr>
			<tr style="background-color:#c4e6fb">
				<th>bmc_id:  </th>
				<td><input id="add_bmcID" name="add_bmcID" type="text" size="40" value=""  />
				</td>
			</tr>
			<tr style="background-color:#c4e6fb">
				<th>model:  </th>
				<td><input id="add_model" name="add_model" type="text" size="40" value=""  />
				</td>
			</tr>
			<tr style="background-color:#c4e6fb">
				<th>product_name:  </th>
				<td><input id="add_p_name" name="add_p_name" type="text" size="40" value=""  />
				</td>
			</tr>
			<tr>
				<th>Notes / Page Title:</th>
				<td><input id="add_note" name="add_note" type="text" size="40" value=""  />
				</td>
			</tr>


			<!--設定 OSs-->
			<tr>
				<th>OS: </th>
				<td>
					<?php
					$str_osA="SELECT ID, Name, Type FROM c_sp_cmpt WHERE Type='OS'";
					$osA_result=mysqli_query($link_db,$str_osA);
					$o=0;
					while($osA_data=mysqli_fetch_row($osA_result)){
						$o+=1;
						if($o%5==0){
							$br01="<br />";
						}else{
							$br01="";
						}
						?>
						<input type="checkbox" name="add_os[]" value="<?=$osA_data[0];?>"> <?=$osA_data[1];?> <?=$br01;?>
						<?php
					}
					?>
					<p style="color:#0F0">可多選</p>
				</td>
			</tr>
			<!--end 設定 supported OSs -->

			<tr>
				<th>File Name:  </th>
				<td><input id="add_f_name" name="add_f_name" type="text" size="40" value=""  />
				</td>
			</tr>
			<tr>
				<th>File Date:  </th>
				<td><input id="add_date" name="add_date" type="text" size="8" value="" onfocus="HS_setDate(this)"  /></td>
			</tr>
			<tr>
				<th>Version / fw_version:  </th>
				<td><input id="add_fw_v" name="add_fw_v" type="text" size="10" value=""  />
				</td>
			</tr>
			<tr>
				<th>File size:</th>
				<td>
					<input id="add_FZ" name="add_FZ" type="text" size="10" value=""  />
				</td>
			</tr>
			<tr>
				<th>File Description:</th>
				<td>
					<textarea id="add_FD"  name="add_FD" rows="6" cols="50" style="max-width: 300px; max-height: 300px;"></textarea>
				</td>
			</tr>

			<tr>
				<th>File Location: (URL) </th>
				<td><input id="add_FL" name="add_FL" type="text" size="40" value=""  />
				</td>
			</tr>
			<tr>
				<tr style="background-color:#c4e6fb">
					<th>nic_product_code:  </th>
					<td><input id="add_nic" name="add_nic" type="text" size="40" value=""  />
					</td>
				</tr>
				<tr style="background-color:#c4e6fb">
					<th>series:  </th>
					<td><input id="add_series" name="add_series" type="text" size="40" value=""  />
					</td>
				</tr>
				<tr style="background-color:#c4e6fb">
					<th>form_factor:  </th>
					<td><input id="add_FF" name="add_FF" type="text" size="40" value=""  />
					</td>
				</tr>
				<tr style="background-color:#c4e6fb">
					<th>capacity:  </th>
					<td><input id="add_capacity" name="add_capacity" type="text" size="40" value=""  />
					</td>
				</tr>
				<tr style="background-color:#c4e6fb">
					<th>SUP_ID:  </th>
					<td><input id="add_supID" name="add_supID" type="text" size="40" value=""  />
					</td>
				</tr>
				<tr style="background-color:#c4e6fb">
					<th>SFUP:  </th>
					<td><input id="add_SFUP" name="add_SFUP" type="text" size="40" value=""  />
					</td>
				</tr>
				<tr style="background-color:#c4e6fb">
					<th>FUT:  </th>
					<td><input id="add_FUT" name="add_FUT" type="text" size="40" value=""  />
					</td>
				</tr>
				<tr style="background-color:#c4e6fb">
					<th>MAS:  </th>
					<td><input id="add_MAS" name="add_MAS" type="text" size="40" value=""  />
					</td>
				</tr>
				<tr style="background-color:#c4e6fb">
					<th>SST:  </th>
					<td><input id="add_SST" name="add_SST" type="text" size="40" value=""  />
					</td>
				</tr>
				<tr style="background-color:#c4e6fb">
					<th>RFU:  </th>
					<td><input id="add_RFU" name="add_RFU" type="text" size="40" value=""  />
					</td>
				</tr>
				<tr style="background-color:#c4e6fb">
					<th>etrack_ids:  </th>
					<td><input id="add_e_ids" name="add_e_ids" type="text" size="40" value=""  />
					</td>
				</tr>
				<tr style="background-color:#c4e6fb">
					<th>EFI:  </th>
					<td><input id="add_EFI" name="add_EFI" type="text" size="40" value=""  />
					</td>
				</tr>
				<tr style="background-color:#c4e6fb">
					<th>Linux:  </th>
					<td><input id="add_Linux" name="add_Linux" type="text" size="40" value=""  />
					</td>
				</tr>
				<tr style="background-color:#c4e6fb">
					<th>Windows:  </th>
					<td><input id="add_windows" name="add_windows" type="text" size="40" value=""  />
					</td>
				</tr>
				<tr style="background-color:#c4e6fb">
					<th>VMWare:  </th>
					<td><input id="add_VM" name="add_VM" type="text" size="40" value=""  />
					</td>
				</tr>
				<tr style="background-color:#f19ec2">
					<th>EULA modal:  </th>
					<td>
						<select id="add_EULA" name="add_EULA">
							<option value="none">none</option>
							<?php
							$strEULA="SELECT ID, Name, Content, c_date, u_date FROM eula_dsg";
							$cmdEULA=mysqli_query($link_db,$strEULA);
							while($dataEULA=mysqli_fetch_row($cmdEULA)){
								echo "<option value=".$dataEULA[0].">".$dataEULA[0]."-".$dataEULA[1]."</option>";
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
				<th>Products:</th>
				<td><div class="button14" style="width:60px;" ><a class="fancybox fancybox.iframe" href="../lb_doload_mo_dsg.php" style="color:#ffffff">Edit</a></div>
					<!--列出被勾選的Products-->
					<textarea id="relProd_val" name="relProd_val" rows="5" cols="80" style="border: none;max-width: 800px; max-height: 200px;" readonly></textarea>
					<p><span id="relProd"></span></p></td>
				</tr>

				<tr>
					<th>Status:</th>
					<td>
						<select id="add_status" name="add_status">
							<option selected value="1">Online</option>
							<option  value="0">Offline</option>
						</select>
						&nbsp;&nbsp;&nbsp;
						<select id="add_brandtype" name="add_brandtype">
							<option selected value="Intel">Intel</option>
							<option  value="MCT">MCT</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>Release_Type:</th>
						<td><input id="add_Release_Type" name="add_Release_Type" type="text" size="40" value=""  />
					</td>
				</tr>

				<tr><td colspan="2">
					<input name="" type="submit" value="Done" />&nbsp;&nbsp;<input name="" type="button" value="Cancel" /> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
				</td></tr>


			</table>
		</form>
		</div>
		<!--Click add end-->		

		<?php
		if($kinds=="Edit"){
			$EditID=filter_var($_GET['id']);

			$list="ID, CMPT_classification, mm_number, product_code, bmc_id, model, product_name, OS, File_Name, File_Date, Version, File_size, File_Description, File_Location, Notes, nic_product_code, series, form_factor, capacity, SUP_ID, SFUP, FUT, MAS, SST, RFU, etrack_ids, EFI, Linux, Windows, VMWare, Download_Type, EULA_modal, Models, Status, brand_type, C_DATE, Release_Type";
			$strEdit="SELECT ".$list." FROM dsg_download WHERE ID='".$EditID."'";
			$cmdEdit=mysqli_query($link_db,$strEdit);
			$dataEdit=mysqli_fetch_row($cmdEdit);
			$tmpOS=explode(";", $dataEdit[7]);
		?>
		<!--Click Edit-->							
		<div id="edit_com" name="edit_com" class="subsettings">
			<h1>Edit a file</h1>
			<!--Click close to close this subsettings div--><div class="right"><a href="download_module_dsg.php"> [close] </a></div><!--end of close-->
			<form id="form2" name="form2" method="post" action="?kinds=edit_CD">
				<table class="editspec">
				<input id="edit_ID" name="edit_ID" type="hidden" value="<?=$dataEdit[0]?>">
				<tr style="background-color:#c4e6fb">
					<th>CMPT_classification:  </th>
					<td>
						<select id="edit_sel" name="edit_sel">
							<option value="none">none</option>
							<?php
							$sel="SELECT ID, Name, Type FROM c_sp_cmpt WHERE Type='CMPT'";
							$cmd=mysqli_query($link_db,$sel);
							while ($data=mysqli_fetch_row($cmd)) {
								if($data[1]==$dataEdit[1]){
									$select="selected";
								}else{
									$select="";
								}
								echo "<option value=".$data[1]." ".$select.">".$data[1]."</option>";
							}
							?>
						</select>
					</td>
				</tr>
				<tr style="background-color:#c4e6fb">
						<th>Type:  </th>
						<td>
							<select id="edit_Type" name="edit_Type">
								<option value="none">none</option>
								<?php
								$sel="SELECT ID, Name, Type FROM c_sp_cmpt WHERE Type='Type'";
								$cmd=mysqli_query($link_db,$sel);
								while ($data=mysqli_fetch_row($cmd)) {
									if($dataEdit[30]==$data[0]){
										$selType="selected";
									}else{
										$selType="";
									}
									echo "<option value=".$data[0]." ".$selType.">".$data[1]."</option>";
								}
							?>
							</select>
						</td>
					</tr>
				<tr style="background-color:#c4e6fb">
					<th>mm_number:  </th>
					<td><input id="edit_mm" name="edit_mm" type="text" size="40" value="<?=$dataEdit[2]?>"  />
					</td>
				</tr>
				<tr style="background-color:#c4e6fb">
					<th>product_code:  </th>
					<td><input id="edit_p_code" name="edit_p_code" type="text" size="40" value="<?=$dataEdit[3]?>"  />
					</td>
				</tr>
				<tr style="background-color:#c4e6fb">
					<th>bmc_id:  </th>
					<td><input id="edit_bmcID" name="edit_bmcID" type="text" size="40" value="<?=$dataEdit[4]?>"  />
					</td>
				</tr>
				<tr style="background-color:#c4e6fb">
					<th>model:  </th>
					<td><input id="edit_model" name="edit_model" type="text" size="40" value="<?=$dataEdit[5]?>"  />
					</td>
				</tr>
				<tr style="background-color:#c4e6fb">
					<th>product_name:  </th>
					<td><input id="edit_p_name" name="edit_p_name" type="text" size="40" value="<?=$dataEdit[6]?>"  />
					</td>
				</tr>

				<tr>
					<th>Notes / Page Title:</th>
					<td><input id="edit_note" name="edit_note" type="text" size="40" value="<?=$dataEdit[14]?>"  />
					</td>
				</tr>

				<!--設定 OSs-->
				<tr>
					<th>OS: </th>
					<td>
						<?php
						$str_osA="SELECT ID, Name, Type FROM c_sp_cmpt WHERE Type='OS'";
						$osA_result=mysqli_query($link_db,$str_osA);
						$o=0;
						while($osA_data=mysqli_fetch_row($osA_result)){
							$o+=1;
							if($o%5==0){
								$br01="<br />";
							}else{
								$br01="";
							}

							if(in_array($osA_data[0],$tmpOS)){
							    $checked="checked";
							} else {
							    $checked="";
							}
							?>
							<input type="checkbox" name="edit_os[]" value="<?=$osA_data[0];?>" <?=$checked?> > <?=$osA_data[1];?> <?=$br01;?>
							<?php
						}
						?>
						<p style="color:#0F0">可多選</p>
					</td>
				</tr>
				<!--end 設定 supported OSs -->

				<tr>
					<th>File Name:  </th>
					<td><input id="edit_f_name" name="edit_f_name" type="text" size="40" value="<?=$dataEdit[8]?>"  />
					</td>
				</tr>
				<tr>
					<th>File Date:  </th>
					<td><input id="edit_date" name="edit_date" type="text" size="8" value="<?=$dataEdit[9]?>" onfocus="HS_setDate(this)"  /></td>
				</tr>
				<tr>
					<th>Version / fw_version:  </th>
					<td><input id="edit_fw_v" name="edit_fw_v" type="text" size="10" value="<?=$dataEdit[10]?>"  />
					</td>
				</tr>
				<tr>
					<th>File size:</th>
					<td>
						<input id="edit_FZ" name="edit_FZ" type="text" size="10" value="<?=$dataEdit[11]?>"  />
					</td>
				</tr>
				<tr>
					<th>File Description:</th>
					<td>
						<textarea id="edit_FD"  name="edit_FD" rows="6" cols="50" style="max-width: 300px; max-height: 300px;"><?=$dataEdit[12]?></textarea>
					</td>
				</tr>

				<tr>
					<th>File Location: (URL) </th>
					<td><input id="edit_FL" name="edit_FL" type="text" size="40" value="<?=$dataEdit[13]?>"  />
					</td>
				</tr>
				<tr>
					<tr style="background-color:#c4e6fb">
						<th>nic_product_code:  </th>
						<td><input id="edit_nic" name="edit_nic" type="text" size="40" value="<?=$dataEdit[15]?>"  />
						</td>
					</tr>
					<tr style="background-color:#c4e6fb">
						<th>series:  </th>
						<td><input id="edit_series" name="edit_series" type="text" size="40" value="<?=$dataEdit[16]?>"  />
						</td>
					</tr>
					<tr style="background-color:#c4e6fb">
						<th>form_factor:  </th>
						<td><input id="edit_FF" name="edit_FF" type="text" size="40" value="<?=$dataEdit[17]?>"  />
						</td>
					</tr>
					<tr style="background-color:#c4e6fb">
						<th>capacity:  </th>
						<td><input id="edit_capacity" name="edit_capacity" type="text" size="40" value="<?=$dataEdit[18]?>"  />
						</td>
					</tr>
					<tr style="background-color:#c4e6fb">
						<th>SUP_ID:  </th>
						<td><input id="edit_supID" name="edit_supID" type="text" size="40" value="<?=$dataEdit[19]?>"  />
						</td>
					</tr>
					<tr style="background-color:#c4e6fb">
						<th>SFUP:  </th>
						<td><input id="edit_SFUP" name="edit_SFUP" type="text" size="40" value="<?=$dataEdit[20]?>"  />
						</td>
					</tr>
					<tr style="background-color:#c4e6fb">
						<th>FUT:  </th>
						<td><input id="edit_FUT" name="edit_FUT" type="text" size="40" value="<?=$dataEdit[21]?>"  />
						</td>
					</tr>
					<tr style="background-color:#c4e6fb">
						<th>MAS:  </th>
						<td><input id="edit_MAS" name="edit_MAS" type="text" size="40" value="<?=$dataEdit[22]?>"  />
						</td>
					</tr>
					<tr style="background-color:#c4e6fb">
						<th>SST:  </th>
						<td><input id="edit_SST" name="edit_SST" type="text" size="40" value="<?=$dataEdit[23]?>"  />
						</td>
					</tr>
					<tr style="background-color:#c4e6fb">
						<th>RFU:  </th>
						<td><input id="edit_RFU" name="edit_RFU" type="text" size="40" value="<?=$dataEdit[24]?>"  />
						</td>
					</tr>
					<tr style="background-color:#c4e6fb">
						<th>etrack_ids:  </th>
						<td><input id="edit_e_ids" name="edit_e_ids" type="text" size="40" value="<?=$dataEdit[25]?>"  />
						</td>
					</tr>
					<tr style="background-color:#c4e6fb">
						<th>EFI:  </th>
						<td><input id="edit_EFI" name="edit_EFI" type="text" size="40" value="<?=$dataEdit[26]?>"  />
						</td>
					</tr>
					<tr style="background-color:#c4e6fb">
						<th>Linux:  </th>
						<td><input id="edit_Linux" name="edit_Linux" type="text" size="40" value="<?=$dataEdit[27]?>"  />
						</td>
					</tr>
					<tr style="background-color:#c4e6fb">
						<th>Windows:  </th>
						<td><input id="edit_windows" name="edit_windows" type="text" size="40" value="<?=$dataEdit[28]?>"  />
						</td>
					</tr>
					<tr style="background-color:#c4e6fb">
						<th>VMWare:  </th>
						<td><input id="edit_VM" name="edit_VM" type="text" size="40" value="<?=$dataEdit[29]?>"  />
						</td>
					</tr>
					<tr style="background-color:#f19ec2">
						<th>EULA modal:  </th>
						<td>
							<select id="edit_EULA" name="edit_EULA">
								<option value="none">none</option>
								<?php
								$strEULA="SELECT ID, Name, Content, c_date, u_date FROM eula_dsg";
								$cmdEULA=mysqli_query($link_db,$strEULA);
								while($dataEULA=mysqli_fetch_row($cmdEULA)){
									if($dataEdit[31]==$dataEULA[0]){
										$selEULA="selected";
									}else{
										$selEULA="";
									}
									echo "<option value=".$dataEULA[0]." ".$selEULA.">".$dataEULA[0]."-".$dataEULA[1]."</option>";
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<th>Products:</th>
						<td><div class="button14" style="width:60px;" ><a class="fancybox fancybox.iframe" href="../elb_doload_mo_dsg.php?cid=<?=$dataEdit[0]?>&d_type=download" style="color:#ffffff">Edit</a></div>
							<!--列出被勾選的Products-->
							<textarea id="relProd_valM" name="relProd_valM" rows="5" cols="80" style="border: none;max-width: 800px; max-height: 200px;" readonly><?=$dataEdit[32]?></textarea>
							<p><span id="relProd"></span></p></td>
						</tr>
						<tr>
						<th>Status:</th>
						<td>
							<select id="edit_status" name="edit_status">
								<option value="1" <?php if($dataEdit[33]=="1"){echo "selected";} ?>>Online</option>
								<option  value="0" <?php if($dataEdit[33]=="0"){echo "selected";} ?>>Offline</option>
							</select>
							&nbsp;&nbsp;&nbsp;
							<select id="edit_brandtype" name="edit_brandtype">
								<option value="Intel" <?php if($dataEdit[34]=="Intel"){echo "selected";} ?>>Intel</option>
								<option  value="MCT" <?php if($dataEdit[34]=="MCT"){echo "selected";} ?>>MCT</option>
							</select>
						</td>
					</tr>
					<tr>
						<th>Release_Type:</th>
						<td><input id="edit_Release_Type" name="edit_Release_Type" type="text" size="40" value="<?=$dataEdit[36]?>"  />
						</td>
					</tr>	

					<tr><td colspan="2">
						<input name="" type="submit" value="Done" />&nbsp;&nbsp;<input name="" type="button" value="Cancel" /> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
					</td></tr>


				</table>
			</form>
			</div>
			<!--Click Edit end-->	
		<?php
		}
		?>
			






		<p class="clear">&nbsp;</p>

	</div>


	<div id="footer">	Copyright &copy; 2014 Company Co. All rights reserved.
		<div class="gotop" onClick="location='#top'">Top</div>



	</div>

</body>
</html>
<?php
mysqli_Close($link_db);
?>