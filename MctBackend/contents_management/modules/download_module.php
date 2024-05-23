<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

require "../../config.php";
include_once('../../page.class.php');

session_start();
if(empty($_SESSION['user']) || empty($_SESSION['password']) || empty($_SESSION['login_time'])){
	echo "<script language='JavaScript'>location='../../login.php'</script>";
	exit();
}

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase);

if(isset($_REQUEST['act'])!=''){
	if($_REQUEST['act']=='del'){
		$d_id01=$_REQUEST['d_id'];
		$d_type01=$_REQUEST['d_type'];
		if($d_id01!='' && $d_type01!=''){

			if($d_type01=='Drivers'){
				$str_del="delete from `sp_driver` where `ID`=".$d_id01;
			}else if($d_type01=='BIOS'){
				$str_del="delete from `sp_bios` where `ID`=".$d_id01;
			}else if($d_type01=='Firmware'){
				$str_del="delete from `sp_firmware` where `ID`=".$d_id01;
			}else if($d_type01=='Software Downloads'){
				$str_del="delete from `sp_software` where `ID`=".$d_id01;
			}
			$del_cmd=mysqli_query($link_db,$str_del);
			echo "<script>alert('Delete The Data!');self.location='download_module.php'</script>";
			exit();
		}
	}
}

if(isset($_REQUEST['kinds'])!=''){
	if($_REQUEST['kinds']=="edit_downlo"){
		$m_id01=intval($_POST['m_id']);
		$dl_type01=$_POST['dl_type'];
		$cha_vmodelM01=$_POST['cha_vmodelM'];
		$subca0101=$_POST['subca01'];
		$subca01_U01=$_POST['subca01_U'];
		$subca01_CHS01=$_POST['subca01_CHS'];
		$subca01_CHS_vender01=$_POST['subca01_CHS_vender'];

		$dl_os_str="";
		if(isset($_POST['dl_os'])!=''){
			foreach($_POST['dl_os'] as $dl_os_val)
			{
				$dl_os_str.=$dl_os_val.";";
			}
		}else{
			$dl_os_str="";
		}

		$dl_name01=trim($_POST['dl_name']);
		$dl_Date01=trim($_POST['dl_Date']);
		$dl_ver01=trim($_POST['dl_ver']);
		$dl_size01=trim($_POST['dl_size']);
		$dl_desc01=str_replace("'", "''", trim($_POST['dl_desc']));
		$dl_loc01=trim($_POST['dl_loc']);
		$relProd_val=trim($_POST['relProd_valM']);
		$dl_note01=trim($_POST['dl_note']);
		$status01=trim($_POST['status']);

		$Me_vnder01=trim($_POST['Me_vnder']);
		$Me_size01=trim($_POST['Me_size']);
		$Me_type01=trim($_POST['Me_type']);
		$Me_chip01=trim($_POST['Me_chip']);
		$Me_Vnum01=trim($_POST['Me_Vnum']);
		$Me_Pnum01=trim($_POST['Me_Pnum']);
		$Me_AMB01=trim($_POST['Me_AMB']);
		$Me_freq01=trim($_POST['Me_freq']);
		$Me_volt01=trim($_POST['Me_volt']);
		$Me_rohs01=trim($_POST['Me_rohs']);
		$Me_quaCPU01=trim($_POST['Me_quaCPU']);

		$SI_vnder01=trim($_POST['SI_vnder']);
		$SI_url01=trim($_POST['SI_url']);

		$HDD_vnder01=trim($_POST['HDD_vnderM']);
		$HDD_mname01=trim($_POST['HDD_mnameM']);
		$HDD_size01=trim($_POST['HDD_sizeM']);
		$HDD_type01=trim($_POST['HDD_typeM']);
		$HDD_capac01=trim($_POST['HDD_capacM']);
		$HDD_bus01=trim($_POST['HDD_busM']);

		putenv("TZ=Asia/Taipei");
		$now=date("Y/m/d H:i:s");

		if($dl_type01=="1"){
			$str_upd="UPDATE `sp_driver` set `VALUECATEGORY`='".$subca0101."', `FILENAME`='".$dl_name01."', `FILEDATE`='".$dl_Date01."', `DESCRIPTION`='".$dl_desc01."', `VERSION`='".$dl_ver01."', `FILESIZE`='".$dl_size01."', `PATH`='".$dl_loc01."', `OS`='".$dl_os_str."', `MODEL`='".$relProd_val."', `NOTES`='".$dl_note01."', `LANG`='en-US', `UPDATE_DATE`='".$now."', `STATUS`='".$status01."' where `ID`=".$m_id01;
		}else if($dl_type01=="2"){
			$str_upd="UPDATE `sp_bios` set `FILENAME`='".$dl_name01."', `FILEDATE`='".$dl_Date01."', `DESCRIPTION`='".$dl_desc01."', `VERSION`='".$dl_ver01."', `PATH`='".$dl_loc01."', `FILESIZE`='".$dl_size01."', `LANG`='en-US', `MODEL`='".$relProd_val."', `NOTES`='".$dl_note01."', `UPDATE_DATE`='".$now."', `STATUS`='".$status01."' where `ID`=".$m_id01;
		}else if($dl_type01=="15"){
			$str_upd="UPDATE `sp_firmware` set `FILENAME`='".$dl_name01."', `FILEDATE`='".$dl_Date01."', `DESCRIPTION`='".$dl_desc01."', `VERSION`='".$dl_ver01."', `PATH`='".$dl_loc01."', `OS`='".$dl_os_str."', `FILESIZE`='".$dl_size01."', `NOTES`='".$dl_note01."', `LANG`='en-US', `MODEL`='".$relProd_val."', `UPDATE_DATE`='".$now."', `STATUS`='".$status01."' where `ID`=".$m_id01;
		}else if($dl_type01=="19"){
			$str_upd="UPDATE `sp_software` set `FILENAME`='".$dl_name01."', `FILEDATE`='".$dl_Date01."', `DESCRIPTION`='".$dl_desc01."', `VERSION`='".$dl_ver01."', `PATH`='".$dl_loc01."' `OS`='".$dl_os_str."', `FILESIZE`='".$dl_size01."', `NOTES`='".$dl_note01."', `LANG`='en-US', `MODEL`='".$relProd_val."', `UPDATE_DATE`='".$now."', `STATUS`='".$status01."' where `ID`=".$m_id01;
		}
		$upd_cmd=mysqli_query($link_db,$str_upd);
		echo "<script>alert('Update The Data !');location.href='download_module.php'</script>";
		exit();
	}
//****************Add**************
	if($_REQUEST['kinds']=="add_downlo"){
		$dlA_type01=$_POST['dlA_type'];
		$cha_vmodel01=$_POST['cha_vmodel'];
		/*$subca01A01=$_POST['subca01A'];
		$subca01A_U01=$_POST['subca01A_U'];
		$subca01A_CHS01=$_POST['subca01A_CHS'];
		$subca01A_CHS_vender01=$_POST['subca01A_CHS_vender'];*/

		$dlA_os_str="";
		if($_POST['dlA_os']!=''){
			foreach($_POST['dlA_os'] as $dlA_os_val)
			{
				$dlA_os_str.=$dlA_os_val.";";
			}
		}else{
			$dlA_os_str="";
		}

		$dlA_name01=$_POST['dlA_name'];
		$dlA_Date01=$_POST['dlA_Date'];
		$dlA_ver01=$_POST['dlA_ver'];
		$dlA_size01=$_POST['dlA_size'];
//$dlA_desc01=$_POST['dlA_desc'];
		$dlA_desc01=str_replace("'","''",trim($_POST['dlA_desc']));
		$dlA_loc01=$_POST['dlA_loc'];
		$relProd_val=$_POST['relProd_val'];
		$dlA_note01=str_replace("'","''",trim($_POST['dlA_note']));
		$statusA01=$_POST['statusA'];

		$MeA_vnder01=$_POST['MeA_vnder'];
		$MeA_size01=$_POST['MeA_size'];
		$MeA_type01=$_POST['MeA_type'];
		$MeA_chip01=$_POST['MeA_chip'];
		$MeA_Vnum01=$_POST['MeA_Vnum'];
		$MeA_Pnum01=$_POST['MeA_Pnum'];
		$MeA_AMB01=$_POST['MeA_AMB'];
		$MeA_freq01=$_POST['MeA_freq'];
		$MeA_volt01=$_POST['MeA_volt'];
		$MeA_rohs01=$_POST['MeA_rohs'];
		$MeA_quaCPU01=$_POST['MeA_quaCPU'];

		$SIA_vnder01=$_POST['SIA_vnder'];
		$SIA_url01=$_POST['SIA_url'];

		$HDD_vnder01=$_POST['HDD_vnder'];
		$HDD_mname01=$_POST['HDD_mname'];
		$HDD_size01=$_POST['HDD_size'];
		$HDD_type01=$_POST['HDD_type'];
		$HDD_capac01=$_POST['HDD_capac'];
		$HDD_bus01=$_POST['HDD_bus'];

		putenv("TZ=Asia/Taipei");
		$now=date("Y/m/d H:i:s");

		if($dlA_type01=="1"){

			$str_Dvalues="select `ID` FROM `sp_driver` order by `ID` desc limit 1";
			$check_Dvalues=mysqli_query($link_db,$str_Dvalues);
			$Max_CValID=mysqli_fetch_row($check_Dvalues);
			$MCount=$Max_CValID[0]+1;

			if($dlA_note01!=''){
				$str_inst="INSERT INTO `sp_driver`(`ID`, `VALUECATEGORY`, `FILENAME`, `FILEDATE`, `DESCRIPTION`, `VERSION`, `FILESIZE`, `PATH`, `OS`, `MODEL`, `NOTES`, `LANG`, `STATUS`, `UPDATE_DATE`) VALUES (".$MCount.",'".$subca01A01."','".$dlA_name01."','".$dlA_Date01."','".$dlA_desc01."','".$dlA_ver01."','".$dlA_size01."','".$dlA_loc01."','".$dlA_os_str."','".$relProd_val."','".$dlA_note01."','en-US','".$statusA01."','".$now."')";
			}else{
				$str_inst="INSERT INTO `sp_driver`(`ID`, `VALUECATEGORY`, `FILENAME`, `FILEDATE`, `DESCRIPTION`, `VERSION`, `FILESIZE`, `PATH`, `OS`, `MODEL`, `LANG`, `STATUS`, `UPDATE_DATE`) VALUES (".$MCount.",'".$subca01A01."','".$dlA_name01."','".$dlA_Date01."','".$dlA_desc01."','".$dlA_ver01."','".$dlA_size01."','".$dlA_loc01."','".$dlA_os_str."','".$relProd_val."','en-US','".$statusA01."','".$now."')";
			}
		}else if($dlA_type01=="2"){

			$str_Bvalues="select `ID` FROM `sp_bios` order by `ID` desc limit 1";
			$check_Bvalues=mysqli_query($link_db,$str_Bvalues);
			$Max_CValID=mysqli_fetch_row($check_Bvalues);
			$MCount=$Max_CValID[0]+1;

			if($dlA_note01!=''){
				$str_inst="INSERT INTO `sp_bios`(`ID`, `FILENAME`, `FILEDATE`, `DESCRIPTION`, `VERSION`, `PATH`, `FILESIZE`, `LANG`, `MODEL`, `NOTES`, `STATUS`, `UPDATE_DATE`) VALUES (".$MCount.",'".$dlA_name01."','".$dlA_Date01."','".$dlA_desc01."','".$dlA_ver01."','".$dlA_loc01."','".$dlA_size01."','en-US','".$relProd_val."','".$dlA_note01."','".$statusA01."','".$now."')";
			}else{
				$str_inst="INSERT INTO `sp_bios`(`ID`, `FILENAME`, `FILEDATE`, `DESCRIPTION`, `VERSION`, `PATH`, `FILESIZE`, `LANG`, `MODEL`, `STATUS`, `UPDATE_DATE`) VALUES (".$MCount.",'".$dlA_name01."','".$dlA_Date01."','".$dlA_desc01."','".$dlA_ver01."','".$dlA_loc01."','".$dlA_size01."','en-US','".$relProd_val."','".$statusA01."','".$now."')";
			}
		}else if($dlA_type01=="15"){
			$str_Firmvalues="select `ID` FROM `sp_firmware` order by `ID` desc limit 1";
			$check_Firmvalues=mysqli_query($link_db,$str_Firmvalues);
			$Max_CValID=mysqli_fetch_row($check_Firmvalues);
			$MCount=$Max_CValID[0]+1;

			if($dlA_note01!=''){
				$str_inst="INSERT INTO `sp_firmware`(`ID`, `FILENAME`, `FILEDATE`, `DESCRIPTION`, `VERSION`, `PATH`, `OS`, `FILESIZE`, `NOTES`, `LANG`, `MODEL`, `STATUS`, `UPDATE_DATE`) VALUES (".$MCount.",'".$dlA_name01."','".$dlA_Date01."','".$dlA_desc01."','".$dlA_ver01."','".$dlA_loc01."','".$dlA_os_str."','".$dlA_size01."','".$dlA_note01."','en-US','".$relProd_val."','".$statusA01."','".$now."')";
			}else{
				$str_inst="INSERT INTO `sp_firmware`(`ID`, `FILENAME`, `FILEDATE`, `DESCRIPTION`, `VERSION`, `PATH`, `OS`, `FILESIZE`, `LANG`, `MODEL`, `STATUS`, `UPDATE_DATE`) VALUES (".$MCount.",'".$dlA_name01."','".$dlA_Date01."','".$dlA_desc01."','".$dlA_ver01."','".$dlA_loc01."','".$dlA_os_str."','".$dlA_size01."','en-US','".$relProd_val."','".$statusA01."','".$now."')";
			}	
		}else if($dlA_type01=="19"){
			$str_Firmvalues="select `ID` FROM `sp_software` order by `ID` desc limit 1";
			$check_Firmvalues=mysqli_query($link_db,$str_Firmvalues);
			$Max_CValID=mysqli_fetch_row($check_Firmvalues);
			$MCount=$Max_CValID[0]+1;

			if($dlA_note01!=''){
				$str_inst="INSERT INTO `sp_software`(`ID`, `FILENAME`, `FILEDATE`, `DESCRIPTION`, `VERSION`, `PATH`, `OS`, `FILESIZE`, `NOTES`, `LANG`, `MODEL`, `STATUS`, `UPDATE_DATE`) VALUES (".$MCount.",'".$dlA_name01."','".$dlA_Date01."','".$dlA_desc01."','".$dlA_ver01."','".$dlA_loc01."','".$dlA_os_str."','".$dlA_size01."','".$dlA_note01."','en-US','".$relProd_val."','".$statusA01."','".$now."')";
			}else{
				$str_inst="INSERT INTO `sp_software`(`ID`, `FILENAME`, `FILEDATE`, `DESCRIPTION`, `VERSION`, `PATH`, `OS`, `FILESIZE`, `LANG`, `MODEL`, `STATUS`, `UPDATE_DATE`) VALUES (".$MCount.",'".$dlA_name01."','".$dlA_Date01."','".$dlA_desc01."','".$dlA_ver01."','".$dlA_loc01."','".$dlA_os_str."','".$dlA_size01."','en-US','".$relProd_val."','".$statusA01."','".$now."')";
			}	
		}
		$inst_cmd=mysqli_query($link_db,$str_inst);
		echo "<script>alert('AddNew The Data!');location.href='download_module.php'</script>";
		exit();
	}
}

if(isset($_REQUEST['s_search'])<>''){
	$s_search=$_REQUEST['s_search'];
//$s_search=preg_replace("['\"\$ \r\n\t;<>\*%\?]", '', $_REQUEST['s_search']);
	if($_REQUEST['Sel_DType']<>''){
		$sel_dtype=$_REQUEST['Sel_DType'];	
		if($sel_dtype==1){ 
			$str1="SELECT count(a.FILENAME) FROM sp_driver a where a.FILENAME like '%".$s_search."%' or a.DESCRIPTION like '%".$s_search."%'";
		}else if($sel_dtype==2){
			$str1="SELECT count(b.FILENAME) FROM sp_bios b where b.FILENAME like '%".$s_search."%' or b.DESCRIPTION like '%".$s_search."%'";
		}else if($sel_dtype==15){
			$str1="SELECT count(b.FILENAME) FROM sp_firmware b where b.FILENAME like '%".$s_search."%' or b.DESCRIPTION like '%".$s_search."%'";
		}else if($sel_dtype==19){
			$str1="SELECT count(b.FILENAME) FROM sp_software b where b.FILENAME like '%".$s_search."%' or b.DESCRIPTION like '%".$s_search."%'";
		}else if($sel_dtype==0){
			$str1="SELECT count(a.FILENAME)+(select count(b.FILENAME) from sp_bios b where b.FILENAME like '%".$s_search."%')+(select count(m.FILENAME) from sp_firmware m where m.FILENAME like '%".$s_search."%') FROM sp_driver a where a.FILENAME like '%".$s_search."%'";
		}
	}else{
		$str1="SELECT count(a.FILENAME)+(select count(b.FILENAME) from sp_bios b)+(select count(m.FILENAME) from sp_firmware m) FROM sp_driver a";
	}
}else{

	if(isset($_REQUEST['Sel_DType'])<>''){
		$sel_dtype=intval($_REQUEST['Sel_DType']);
		if($sel_dtype==1){ 
			$str1="SELECT count(a.FILENAME) FROM sp_driver a";
		}else if($sel_dtype==2){ 
			$str1="SELECT count(b.FILENAME) FROM sp_bios b";
		}else if($sel_dtype==15){
			$str1="SELECT count(b.FILENAME) FROM sp_firmware b";
		}else if($sel_dtype==19){ 
			$str1="SELECT count(b.FILENAME) FROM sp_software b";
		}else if($sel_dtype==0){
			$str1="SELECT count(a.FILENAME)+(select count(b.FILENAME) from sp_bios b)+(select count(m.FILENAME) from sp_firmware m) FROM sp_driver a";
		}
	}else{	 
		$str1="SELECT count(a.FILENAME)+(select count(b.FILENAME) from sp_bios b)+(select count(m.FILENAME) from sp_firmware m) FROM sp_driver a";
	}

}
//echo $str1;
$list1 =mysqli_query($link_db,$str1);
list($public_count) = mysqli_fetch_row($list1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Website Contents Management - Products Management - Contents: Modules - Download management</title>
	<link rel="stylesheet" type="text/css" href="../../backend.css">
	<link rel="stylesheet" type="text/css" href="../../css.css" />
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
for(var i = 1; i < 5; i++){ //tr_len是要控制的tr个数   
	$("#tr_"+i).hide();   
}
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

$("a#dw_edit").click(function() {
	alert($(this).next('.uid').val());
});

</script>
<script language="JavaScript">
function MM_o(selObj){
	window.open(document.getElementById('doldmod_page').options[document.getElementById('doldmod_page').selectedIndex].value,"_self");
}

function search_value(){
	var slType;
//self.location = "?s_search=" + document.form3.sear_txt.value;
slType=document.getElementById('Sel_DType').value;
//self.location = slType + "&s_search=" + document.getElementById('sear_txt').value;
self.location = "?Sel_DType=" + slType + "&s_search=" + document.getElementById('sear_txt').value;
return false;
}

function doEnter(event){
	var keyCodeEntered = (event.which) ? event.which : window.event.keyCode;
	if (keyCodeEntered == 13){
//alert(keyCodeEntered);
//if(confirm('Are you sure you want to search this word?')) {
	document.location.href = "?Sel_DType=" + document.getElementById('Sel_DType').value + "&s_search=" + document.getElementById('sear_txt').value;	   
//}   
}
}

function MM_PT(selObj){

	var dl_num=document.getElementById('dlA_type').value;
	if(dl_num==1){
		$("#tr_1").show();$("#tr_1_01").hide();$("#tr_1_02").hide();$("#tr_1_03").show();$("#tr_1_04").show();$("#tr_1_05").show();$("#tr_1_06").show();$("#tr_1_07").show();$("#tr_1_08").show();$("#tr_1_09").show();
		$("#tr_2").hide();
		$("#tr_3").hide();
		$("#tr_4").hide();
		document.getElementById('download_pannel').style.display='block';
		document.getElementById('cha_vmodel').style.display='none';	  
		document.getElementById('dlA_name').style.display='block';
		document.getElementById('dlA_Date').style.display='block';
		document.getElementById('dlA_ver').style.display='block';
		document.getElementById('dlA_size').style.display='block';
		document.getElementById('dlA_desc').style.display='block';
		document.getElementById('dlA_loc').style.display='block';
		/*document.getElementById('subca01A').style.display='block';
		document.getElementById('subca01A_U').style.display='none';*/
		document.getElementById('Memory_pannel').style.display='none';
		document.getElementById('SI_pannel').style.display='none';
		document.getElementById('HDD_pannel').style.display='none';
		document.getElementById('os_area').style.display='block';
		/*document.getElementById('subca01A_CHS').style.display='none';
		document.getElementById('subca01A_CHS_vender').style.display='none';*/
	}else if(dl_num==2){
		$("#tr_1").show();$("#tr_1_01").hide();$("#tr_1_02").hide();$("#tr_1_03").show();$("#tr_1_04").show();$("#tr_1_05").show();$("#tr_1_06").show();$("#tr_1_07").show();$("#tr_1_08").show();$("#tr_1_09").show();
		$("#tr_2").hide();
		$("#tr_3").hide();
		$("#tr_4").hide();
		document.getElementById('download_pannel').style.display='block';
		document.getElementById('cha_vmodel').style.display='none';
		document.getElementById('dlA_name').style.display='block';
		document.getElementById('dlA_Date').style.display='block';
		document.getElementById('dlA_ver').style.display='block';
		document.getElementById('dlA_size').style.display='block';
		document.getElementById('dlA_desc').style.display='block';
		document.getElementById('dlA_loc').style.display='block';
		/*document.getElementById('subca01A').style.display='none';
		document.getElementById('subca01A_U').style.display='none';*/
		document.getElementById('Memory_pannel').style.display='none';
		document.getElementById('SI_pannel').style.display='none';
		document.getElementById('HDD_pannel').style.display='none';
		document.getElementById('os_area').style.display='block';
		/*document.getElementById('subca01A_CHS').style.display='none';
		document.getElementById('subca01A_CHS_vender').style.display='none';*/	  
	}else if(dl_num==15){
		$("#tr_1").show();$("#tr_1_01").hide();$("#tr_1_02").hide();$("#tr_1_03").show();$("#tr_1_04").show();$("#tr_1_05").show();$("#tr_1_06").show();$("#tr_1_07").show();$("#tr_1_08").show();$("#tr_1_09").show();
		$("#tr_2").hide();
		$("#tr_3").hide();
		$("#tr_4").hide();
		document.getElementById('download_pannel').style.display='block';
		document.getElementById('cha_vmodel').style.display='none';
		document.getElementById('dlA_name').style.display='block';
		document.getElementById('dlA_Date').style.display='block';
		document.getElementById('dlA_ver').style.display='block';
		document.getElementById('dlA_size').style.display='block';
		document.getElementById('dlA_desc').style.display='block';
		document.getElementById('dlA_loc').style.display='block';
		document.getElementById('subca01A').style.display='none';
		document.getElementById('subca01A_U').style.display='none';
		document.getElementById('Memory_pannel').style.display='none';
		document.getElementById('SI_pannel').style.display='none';
		document.getElementById('HDD_pannel').style.display='none';
		document.getElementById('os_area').style.display='block';
		document.getElementById('subca01A_CHS').style.display='none';
		document.getElementById('subca01A_CHS_vender').style.display='none';
	}else if(dl_num==19){
		$("#tr_1").show();$("#tr_1_01").hide();$("#tr_1_02").hide();$("#tr_1_03").show();$("#tr_1_04").show();$("#tr_1_05").show();$("#tr_1_06").show();$("#tr_1_07").show();$("#tr_1_08").show();$("#tr_1_09").show();
		$("#tr_2").hide();
		$("#tr_3").hide();
		$("#tr_4").hide();
		document.getElementById('download_pannel').style.display='block';
		document.getElementById('cha_vmodel').style.display='none';
		document.getElementById('dlA_name').style.display='block';
		document.getElementById('dlA_Date').style.display='block';
		document.getElementById('dlA_ver').style.display='block';
		document.getElementById('dlA_size').style.display='block';
		document.getElementById('dlA_desc').style.display='block';
		document.getElementById('dlA_loc').style.display='block';
		/*document.getElementById('subca01A').style.display='none';
		document.getElementById('subca01A_U').style.display='none';*/
		document.getElementById('Memory_pannel').style.display='none';
		document.getElementById('SI_pannel').style.display='none';
		document.getElementById('HDD_pannel').style.display='none';
		document.getElementById('os_area').style.display='block';
		/*document.getElementById('subca01A_CHS').style.display='none';
		document.getElementById('subca01A_CHS_vender').style.display='none';*/	  
	}else{
		$("#tr_1").hide();$("#tr_1_01").hide();$("#tr_1_02").hide();$("#tr_1_03").hide();$("#tr_1_04").hide();$("#tr_1_05").hide();$("#tr_1_06").hide();$("#tr_1_07").hide();$("#tr_1_08").hide();$("#tr_1_09").hide();
		$("#tr_2").hide();
		$("#tr_3").hide();
		$("#tr_4").hide();
		document.getElementById('download_pannel').style.display='none';
		document.getElementById('cha_vmodel').style.display='none';
		document.getElementById('dlA_name').style.display='none';
		document.getElementById('dlA_Date').style.display='none';
		document.getElementById('dlA_ver').style.display='none';
		document.getElementById('dlA_size').style.display='none';
		document.getElementById('dlA_desc').style.display='none';
		document.getElementById('dlA_loc').style.display='none';
		//document.getElementById('subca01A').style.display='none';
		//document.getElementById('subca01A_U').style.display='none';
		document.getElementById('Memory_pannel').style.display='none';
		document.getElementById('SI_pannel').style.display='none';
		document.getElementById('HDD_pannel').style.display='none';
		document.getElementById('os_area').style.display='none';
		//document.getElementById('subca01A_CHS').style.display='none';
		//document.getElementById('subca01A_CHS_vender').style.display='none';
	}
}

function get_types(num){	

	if(num==1){
		$("#tr_1M").show();$("#tr_1_01M").show();$("#tr_1_02M").hide();$("#tr_1_03M").show();$("#tr_1_04M").show();$("#tr_1_05M").show();$("#tr_1_06M").show();$("#tr_1_07M").show();$("#tr_1_08M").show();$("#tr_1_09M").show();
		$("#tr_2M").hide();
		$("#tr_3M").hide();
		$("#tr_4M").hide();
		document.getElementById('download_pannelM').style.display='block';
		document.getElementById('cha_vmodelM').style.display='none';	  
		document.getElementById('dl_name').style.display='block';
		document.getElementById('dl_Date').style.display='block';
		document.getElementById('dl_ver').style.display='block';
		document.getElementById('dl_size').style.display='block';
		document.getElementById('dl_desc').style.display='block';
		document.getElementById('dl_loc').style.display='block';
		document.getElementById('subca01').style.display='block';
		document.getElementById('subca01_U').style.display='none';
		document.getElementById('Memory_pannelM').style.display='none';
		document.getElementById('SI_pannel').style.display='none';
		document.getElementById('HDD_pannel').style.display='none';
		document.getElementById('os_areaM').style.display='block';
		document.getElementById('subca01_CHS').style.display='none';
		document.getElementById('subca01_CHS_vender').style.display='none';
	}

}

function MM_PTM(selObj){
	var dl_num=document.getElementById('dl_type').value;
	if(dl_num==1){
		$("#tr_1M").show();$("#tr_1_01M").hide();$("#tr_1_02M").hide();$("#tr_1_03M").show();$("#tr_1_04M").show();$("#tr_1_05M").show();$("#tr_1_06M").show();$("#tr_1_07M").show();$("#tr_1_08M").show();$("#tr_1_09M").show();
		$("#tr_2M").hide();
		$("#tr_3M").hide();
		$("#tr_4M").hide();
		document.getElementById('download_pannelM').style.display='block';
		document.getElementById('cha_vmodelM').style.display='none';	  
		document.getElementById('dl_name').style.display='block';
		document.getElementById('dl_Date').style.display='block';
		document.getElementById('dl_ver').style.display='block';
		document.getElementById('dl_size').style.display='block';
		document.getElementById('dl_desc').style.display='block';
		document.getElementById('dl_loc').style.display='block';
		document.getElementById('subca01').style.display='block';
		document.getElementById('subca01_U').style.display='none';
		document.getElementById('Memory_pannelM').style.display='none';
		document.getElementById('SI_pannel').style.display='none';
		document.getElementById('HDD_pannel').style.display='none';
		document.getElementById('os_areaM').style.display='block';
		document.getElementById('subca01_CHS').style.display='none';
		document.getElementById('subca01_CHS_vender').style.display='none';
	}else if(dl_num==2){
		$("#tr_1M").show();$("#tr_1_01M").hide();$("#tr_1_02M").hide();$("#tr_1_03M").show();$("#tr_1_04M").show();$("#tr_1_05M").show();$("#tr_1_06M").show();$("#tr_1_07M").show();$("#tr_1_08M").show();$("#tr_1_09M").show();
		$("#tr_2M").hide();
		$("#tr_3M").hide();
		$("#tr_4M").hide();
		document.getElementById('download_pannelM').style.display='block';
		document.getElementById('cha_vmodelM').style.display='none';
		document.getElementById('dl_name').style.display='block';
		document.getElementById('dl_Date').style.display='block';
		document.getElementById('dl_ver').style.display='block';
		document.getElementById('dl_size').style.display='block';
		document.getElementById('dl_desc').style.display='block';
		document.getElementById('dl_loc').style.display='block';
		document.getElementById('subca01').style.display='none';
		document.getElementById('subca01_U').style.display='none';
		document.getElementById('Memory_pannelM').style.display='none';
		document.getElementById('SI_pannel').style.display='none';
		document.getElementById('HDD_pannel').style.display='none';
		document.getElementById('os_areaM').style.display='block';
		document.getElementById('subca01_CHS').style.display='none';
		document.getElementById('subca01_CHS_vender').style.display='none';	  
	}else if(dl_num==15){
		$("#tr_1M").show();$("#tr_1_01M").hide();$("#tr_1_02M").hide();$("#tr_1_03M").show();$("#tr_1_04M").show();$("#tr_1_05M").show();$("#tr_1_06M").show();$("#tr_1_07").show();$("#tr_1_08M").show();$("#tr_1_09M").show();
		$("#tr_2M").hide();
		$("#tr_3M").hide();
		$("#tr_4M").hide();
		document.getElementById('download_pannelM').style.display='block';
		document.getElementById('cha_vmodelM').style.display='none';
		document.getElementById('dl_name').style.display='block';
		document.getElementById('dl_Date').style.display='block';
		document.getElementById('dl_ver').style.display='block';
		document.getElementById('dl_size').style.display='block';
		document.getElementById('dl_desc').style.display='block';
		document.getElementById('dl_loc').style.display='block';
		document.getElementById('subca01').style.display='none';
		document.getElementById('subca01_U').style.display='none';
		document.getElementById('Memory_pannelM').style.display='none';
		document.getElementById('SI_pannel').style.display='none';
		document.getElementById('HDD_pannel').style.display='none';
		document.getElementById('os_areaM').style.display='block';
		document.getElementById('subca01_CHS').style.display='none';
		document.getElementById('subca01_CHS_vender').style.display='none';
	}else if(dl_num==19){
		$("#tr_1M").show();$("#tr_1_01M").hide();$("#tr_1_02M").hide();$("#tr_1_03M").show();$("#tr_1_04M").show();$("#tr_1_05M").show();$("#tr_1_06M").show();$("#tr_1_07M").show();$("#tr_1_08M").show();$("#tr_1_09M").show();
		$("#tr_2M").hide();
		$("#tr_3M").hide();
		$("#tr_4M").hide();
		document.getElementById('download_pannelM').style.display='block';
		document.getElementById('cha_vmodelM').style.display='none';
		document.getElementById('dl_name').style.display='block';
		document.getElementById('dl_Date').style.display='block';
		document.getElementById('dl_ver').style.display='block';
		document.getElementById('dl_size').style.display='block';
		document.getElementById('dl_desc').style.display='block';
		document.getElementById('dl_loc').style.display='block';
		document.getElementById('subca01').style.display='none';
		document.getElementById('subca01_U').style.display='none';
		document.getElementById('Memory_pannelM').style.display='none';
		document.getElementById('SI_pannel').style.display='none';
		document.getElementById('HDD_pannel').style.display='none';
		document.getElementById('os_areaM').style.display='block';
		document.getElementById('subca01_CHS').style.display='none';
		document.getElementById('subca01_CHS_vender').style.display='none';	  
	}else{
		$("#tr_1M").hide();$("#tr_1_01M").hide();$("#tr_1_02M").hide();$("#tr_1_03M").hide();$("#tr_1_04M").hide();$("#tr_1_05M").hide();$("#tr_1_06M").hide();$("#tr_1_07M").hide();$("#tr_1_08M").hide();$("#tr_1_09M").hide();
		$("#tr_2M").hide();
		$("#tr_3M").hide();
		$("#tr_4M").hide();
		document.getElementById('download_pannelM').style.display='none';
		document.getElementById('cha_vmodelM').style.display='none';
		document.getElementById('dl_name').style.display='none';
		document.getElementById('dl_Date').style.display='none';
		document.getElementById('dl_ver').style.display='none';
		document.getElementById('dl_size').style.display='none';
		document.getElementById('dl_desc').style.display='none';
		document.getElementById('dl_loc').style.display='none';
		document.getElementById('subca01').style.display='none';
		document.getElementById('subca01_U').style.display='none';
		document.getElementById('Memory_pannelM').style.display='none';
		document.getElementById('SI_pannelM').style.display='none';
		document.getElementById('HDD_pannelM').style.display='none';
		document.getElementById('os_areaM').style.display='none';
		document.getElementById('subca01_CHS').style.display='none';
		document.getElementById('subca01_CHS_vender').style.display='none';
	}
}

function show_add(){
	$("#downlo_add").show();
	$("#downlo_edit").hide();
}
function hide_add(){
	self.location='download_module.php';
}
function show_edit(){
	$("#downlo_add").hide();
	$("#downlo_edit").show();
}
function hide_edit(){
	self.location='download_module.php';
}
</script>
</head>

<body>
	<a name="top"></a>
	<div >
		<div class="left"><h1>&nbsp;&nbsp;Website Backends - Website Contents Management - Contents: Download management</h1></div>
		<div id="logout">Hi <?=str_replace("@mic.com.tw", "", $_SESSION['user']);?> <a href="../logo.php">Log out &gt;&gt;</a></div>
	</div>

	<div class="clear"></div>
	<div id="menu">
		<ul>
			<li ><a href="../default.php">Products</a>

			</li>
			<li> <a href="../modules.php">Contents</a> 
				<ul>
					<li><a href="../modules.php">Modules</a></li>	  
				</ul>
			</li>
			<li ><a href="../newsletter.php">Newsletters</a>
				<ul><li><a href="../subscribe.php">Subscription</a></li></ul>
			</li>
		</ul>
	</div>
	<div class="clear"></div>
	<div id="Search" >
		<h2>Contents &nbsp;&gt;&nbsp;  <a href="../modules.php">Modules</a>  &nbsp;&gt;&nbsp; Download management</h2> 
	</div>
	<div id="content">
		<br />
		<h3>Download List:
		</h3>
		<div class="pagination left">
			<p>
				<form id="form3" name="form3" method="post" action="download_module.php" onsubmit="return false;">
					<select id="Sel_DType" name="Sel_DType">
<!--
<option value="download_module.php?sel_dtype=" selected>All Types</option>
<option value="download_module.php?sel_dtype=Drivers">Drivers</option>
<option value="download_module.php?sel_dtype=BIOS">BIOS</option>
<option value="download_module.php?sel_dtype=Memory">Memory</option>
<option value="download_module.php?sel_dtype=Manuals">Manuals</option>
<option value="download_module.php?sel_dtype=Datasheets">Datasheets</option>
<option value="download_module.php?sel_dtype=Video">Video Compatibility</option>
<option value="download_module.php?sel_dtype=IPMI">IPMI/iKVM firmware</option>
-->
<option value="0" selected>All Types</option>
<?php
$str_dl="SELECT `ID`, `NAME` FROM `c_sp_itemlist` where `ID` in (1,2,15,19)";
//$str_dl="SELECT `ID`, `NAME` FROM `c_sp_itemlist` where `ID` <> 10";
$dl_result=mysqli_query($link_db,$str_dl);
while($dl_data=mysqli_fetch_row($dl_result)){
	?>
	<option value="<?=$dl_data[0];?>"><?=$dl_data[1];?></option>
	<?php
}
?>
</select>&nbsp;&nbsp;&nbsp;&nbsp;<input id="sear_txt" name="sear_txt" type="text" size="30" value="" onkeydown="doEnter(event);" /> <input type="button" value="Search" onclick="search_value();" /></form>  
<span style="color:#0F0">**Key word search: FILE NAME & Products欄位 </span> 
</p>
<div class="pagination left">Total: <span class="w14bblue"><?=$public_count;?></span> records </div>
</div>

<table class="list_table">
	<tr>
		<th >*File Name</th><th  >*Download Type <a class="fancybox fancybox.iframe" href="lb_dl_type.php" /><img src="../../images/icon_edit.png" alt="Edit" /></a></th><th  >*File Date</th><th  >Products</th><th>*Status</th><th><div class="button14" style="width:50px;"><a href="#downlo_add" STYLE="text-decoration:none" onClick="show_add();">Add</a></div></th>
	</tr>
	<?php
	if(isset($_REQUEST['page'])!=""){
		$page=(int)$_REQUEST['page'];
	}else{
		$page="1";
	}

	if(empty($page))$page="1";

	$read_num="10";
	$start_num=$read_num*($page-1); 

	if(isset($_REQUEST['s_search'])<>''){
		$s_search=preg_replace("/['\"\$ \r\n\t;<>\*%\?]/", '', $_REQUEST['s_search']);

		if(isset($_REQUEST['Sel_DType'])<>''){
			$sel_dtype=trim($_REQUEST['Sel_DType']);
			if($sel_dtype==1){ 
				$str="SELECT a.ID, a.FILENAME, 'Drivers' as DL_Type, a.FILEDATE, a.MODEL, a.STATUS, a.UPDATE_DATE FROM sp_driver a where a.FILENAME like '%".$s_search."%' or a.DESCRIPTION like '%".$s_search."%' ORDER BY a.UPDATE_DATE desc limit $start_num,$read_num;";
			}else if($sel_dtype==2){
				$str="SELECT b.ID, b.FILENAME, 'BIOS' as DL_Type, b.FILEDATE, b.MODEL, b.STATUS, b.UPDATE_DATE FROM sp_bios b where b.FILENAME like '%".$s_search."%' or b.DESCRIPTION like '%".$s_search."%' ORDER BY b.UPDATE_DATE desc limit $start_num,$read_num;";
			}else if($sel_dtype==15){
				$str="select m.ID, m.FILENAME, 'Firmware' as DL_Type, m.FILEDATE, m.MODEL, m.STATUS, m.UPDATE_DATE from sp_firmware m where m.FILENAME like '%".$s_search."%' or m.DESCRIPTION like '%".$s_search."%' ORDER BY m.UPDATE_DATE desc limit $start_num,$read_num;";
			}else if($sel_dtype==19){
				$str="select m.ID, m.FILENAME, 'Software Downloads' as DL_Type, m.FILEDATE, m.MODEL, m.STATUS, m.UPDATE_DATE from sp_software m where m.FILENAME like '%".$s_search."%' or m.DESCRIPTION like '%".$s_search."%' ORDER BY m.UPDATE_DATE desc limit $start_num,$read_num;";
			}else if($sel_dtype==0){
			//$str="SELECT ID, FILENAME, 'Drivers' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_driver UNION ALL SELECT ID, FILENAME, 'BIOS' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_bios UNION ALL SELECT ID, FILENAME, 'IPMI/iKVM firmware' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_firmware where (FILENAME like '%".$s_search."%') ORDER BY ID limit $start_num,$read_num;";
				$str="SELECT * from (SELECT ID, FILENAME, 'Drivers' as DL_Type, FILEDATE, MODEL, STATUS, UPDATE_DATE FROM sp_driver UNION ALL SELECT ID, FILENAME, 'BIOS' as DL_Type, FILEDATE, MODEL, STATUS, UPDATE_DATE FROM sp_bios UNION ALL SELECT ID, FILENAME, 'Firmware' as DL_Type, FILEDATE, MODEL, STATUS, UPDATE_DATE FROM sp_firmware UNION ALL SELECT ID, FILENAME, 'Software Downloads' as DL_Type, FILEDATE, MODEL, STATUS, UPDATE_DATE FROM sp_software) a where (a.FILENAME like '%".$s_search."%') ORDER BY a.UPDATE_DATE desc limit $start_num,$read_num;";
			}
		}else{
			//$str="SELECT ID, FILENAME, 'Drivers' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_driver UNION ALL SELECT ID, FILENAME, 'BIOS' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_bios UNION ALL SELECT ID, FILENAME, 'Utilities' as DL_Type,FILEDATE, MODEL, STATUS FROM sp_utility UNION ALL SELECT ID, VENDER_NUMBER, 'Memory' as DL_Type, '' as FDATE, MODEL, STATUS FROM sp_memory UNION ALL SELECT ID, VENDERMODEL, 'Chassis' as DL_Type, '' as FDATE, MODEL, STATUS FROM sp_chassis UNION ALL SELECT ID, FILENAME, 'Manuals' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_manual UNION ALL SELECT ID, FILENAME, 'Datasheets' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_datasheet UNION ALL SELECT ID, FILENAME, 'Jumpers' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_jumper UNION ALL SELECT ID, FILENAME, 'FRU' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_fru UNION ALL SELECT ID, FILENAME, 'OptionalParts' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_optionpart UNION ALL SELECT ID, FILENAME, 'StandardParts' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_standardpart UNION ALL SELECT ID, FILENAME, 'VideoCompatibility' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_videocompatibility UNION ALL SELECT ID, FILENAME, 'IPMI/iKVM firmware' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_firmware UNION ALL SELECT ID, FILENAME, 'Quick Guide' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_qg UNION ALL SELECT ID, FILENAME, 'Press Review' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_pressreview UNION ALL SELECT ID, VENDER_NAME, 'HDD' as DL_Type, '' as FDATE, MODEL, STATUS FROM sp_hdd where (FILENAME like '%".$s_search."%') ORDER BY ID limit $start_num,$read_num;";
			$str="SELECT * from (SELECT ID, FILENAME, 'Drivers' as DL_Type, FILEDATE, MODEL, STATUS, UPDATE_DATE FROM sp_driver UNION ALL SELECT ID, FILENAME, 'BIOS' as DL_Type, FILEDATE, MODEL, STATUS, UPDATE_DATE FROM sp_bios UNION ALL SELECT ID, FILENAME, 'Firmware' as DL_Type, FILEDATE, MODEL, STATUS, UPDATE_DATE FROM sp_firmware UNION ALL SELECT ID, FILENAME, 'Software Downloads' as DL_Type, FILEDATE, MODEL, STATUS, UPDATE_DATE FROM sp_software) a where (a.FILENAME like '%".$s_search."%') ORDER BY a.UPDATE_DATE desc limit $start_num,$read_num;";
		}

	}else{

		if(isset($_REQUEST['Sel_DType'])<>''){	  
			$sel_dtype=$_REQUEST['Sel_DType'];
			if($sel_dtype==1){ 
				$str="SELECT a.ID, a.FILENAME, 'Drivers' as DL_Type, a.FILEDATE, a.MODEL, a.STATUS, a.UPDATE_DATE FROM sp_driver a ORDER BY a.UPDATE_DATE desc limit $start_num,$read_num;";
			}else if($sel_dtype==2){
				$str="SELECT b.ID, b.FILENAME, 'BIOS' as DL_Type, b.FILEDATE, b.MODEL, b.STATUS, b.UPDATE_DATE FROM sp_bios b ORDER BY b.UPDATE_DATE desc limit $start_num,$read_num;";
			}else if($sel_dtype==15){
				$str="select m.ID, m.FILENAME, 'Firmware' as DL_Type, m.FILEDATE, m.MODEL, m.STATUS, m.UPDATE_DATE from sp_firmware m ORDER BY m.UPDATE_DATE desc limit $start_num,$read_num;";
			}else if($sel_dtype==19){
				$str="select m.ID, m.FILENAME, 'Software Downloads' as DL_Type, m.FILEDATE, m.MODEL, m.STATUS, m.UPDATE_DATE from sp_software m ORDER BY m.UPDATE_DATE desc limit $start_num,$read_num;";
			}else if($sel_dtype==0){
				$str="SELECT ID, FILENAME, 'Drivers' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_driver UNION ALL SELECT ID, FILENAME, 'BIOS' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_bios UNION ALL SELECT ID, FILENAME, 'Firmware' as DL_Type, FILEDATE, MODEL, STATUS, UPDATE_DATE FROM sp_firmware UNION ALL SELECT ID, FILENAME, 'Software Downloads' as DL_Type, FILEDATE, MODEL, STATUS, UPDATE_DATE FROM sp_software ORDER BY UPDATE_DATE desc limit $start_num,$read_num;";
			}
		}else{		  
	//$str="SELECT ID, FILENAME, 'Drivers' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_driver UNION ALL SELECT ID, FILENAME, 'BIOS' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_bios UNION ALL SELECT ID, FILENAME, 'Utilities' as DL_Type,FILEDATE, MODEL, STATUS FROM sp_utility UNION ALL SELECT ID, VENDER_NUMBER, 'Memory' as DL_Type, '' as FDATE, MODEL, STATUS FROM sp_memory UNION ALL SELECT ID, VENDERMODEL, 'Chassis' as DL_Type, '' as FDATE, MODEL, STATUS FROM sp_chassis UNION ALL SELECT ID, FILENAME, 'Manuals' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_manual UNION ALL SELECT ID, FILENAME, 'Datasheets' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_datasheet UNION ALL SELECT ID, FILENAME, 'Jumpers' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_jumper UNION ALL SELECT ID, FILENAME, 'FRU' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_fru UNION ALL SELECT ID, FILENAME, 'OptionalParts' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_optionpart UNION ALL SELECT ID, FILENAME, 'StandardParts' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_standardpart UNION ALL SELECT ID, FILENAME, 'VideoCompatibility' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_videocompatibility UNION ALL SELECT ID, FILENAME, 'IPMI/iKVM firmware' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_firmware UNION ALL SELECT ID, FILENAME, 'Quick Guide' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_qg UNION ALL SELECT ID, FILENAME, 'Press Review' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_pressreview UNION ALL SELECT ID, VENDER_NAME, 'HDD' as DL_Type, '' as FDATE, MODEL, STATUS FROM sp_hdd ORDER BY `ID` limit $start_num,$read_num;";
	//$str="SELECT ID, FILENAME, 'Drivers' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_driver UNION ALL SELECT ID, FILENAME, 'BIOS' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_bios UNION ALL SELECT ID, FILENAME, 'IPMI/iKVM firmware' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_firmware UNION ALL SELECT ID, FILENAME, 'Press Review' as DL_Type, FILEDATE, MODEL, STATUS FROM sp_pressreview ORDER BY `ID` limit $start_num,$read_num;";
		$str="SELECT ID, FILENAME, 'Drivers' as DL_Type, FILEDATE, MODEL, STATUS, UPDATE_DATE FROM sp_driver UNION ALL SELECT ID, FILENAME, 'BIOS' as DL_Type, FILEDATE, MODEL, STATUS, UPDATE_DATE FROM sp_bios UNION ALL SELECT ID, FILENAME, 'Firmware' as DL_Type, FILEDATE, MODEL, STATUS, UPDATE_DATE FROM sp_firmware UNION ALL SELECT ID, FILENAME, 'Software Downloads' as DL_Type, FILEDATE, MODEL, STATUS, UPDATE_DATE FROM sp_software ORDER BY `UPDATE_DATE` desc limit $start_num,$read_num;";
		}

	}       
$result=mysqli_query($link_db,$str);
$i=0;
while(list($ID,$FILENAME,$DL_Type,$FILEDATE,$MODEL,$STATUS)=mysqli_fetch_row($result)){
	$i=$i+1;
	putenv("TZ=Asia/Taipei");
	?>
	<tr>
		<td ><?=$FILENAME;?></td><td><?=$DL_Type;?></td>
		<td>
			<?php
			if($FILEDATE!='' && $FILEDATE!='0000-00-00 00:00:00'){
				echo date("Y/m/d",strtotime($FILEDATE));
			}
			?></td><td><?=$MODEL;?></td><td><?php if($STATUS==1){ echo "Online"; }else if($STATUS==0){ echo "Offline"; } ?></td><td ><a id="dw_edit" href="?mid=<?=$ID;?>&d_type=<?=$DL_Type;?> #downlo_edit">Edit</a>&nbsp;&nbsp;<a href="?act=del&d_id=<?=$ID;?>&d_type=<?=$DL_Type;?>" onclick="return confirm('Are you sure you want to delete this item?');">Del</a></td>
		</tr> 
		<?php
	}
	?>
	<tr>
		<td colspan="6">
			<?php
			$all_page=ceil($public_count/$read_num);
			$pageSize=$page;
			$total=$all_page;
			pageft($total,$pageSize,1,0,0,15);       
			?>
		</td>
	</tr>
</table>

<div class="sabrosus"><span class="w14bblue"><?=$read_num?></span> Records Per Page &nbsp;&nbsp;| &nbsp;&nbsp;Page: &nbsp;
	<select id="doldmod_page" name="doldmod_page" onChange="MM_o(this)">
		<?php
		for($j=1;$j<=$total;$j++){
			?>
			<option value="?page=<?=$j?>&s_search=<?=$s_search?>" <?php if($page==$j){ echo "selected"; } ?>><?=$j?></option>
			<?php
		}
		?>
	</select>&nbsp;&nbsp;
	<?php echo $pagenav;?>
</div>

<p style="color:#0F0">- click "Del" 要popup a confirmation window to proceed<br />- List順序:新至舊</p>
<p >&nbsp;</p><p >&nbsp;</p>
<p class="clear">&nbsp;</p>
<!--Click Edit and add -->
<div id="downlo_add" class="subsettings" style="display:none">
	<form id="form1" name="form1" method="post" action="?kinds=add_downlo" onsubmit="return Final_Check();">							
		<h1>Add a download file</h1>
		<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hide_add()"> [close] </a></div><!--end of close-->
		<table class="addspec">
			<tr>
				<th>Download Type:  </th>
				<td>
					<select id="dlA_type" name="dlA_type" onChange="MM_PT(this)">
						<option value="" selected>--Select--</option>
						<?php
						$str_dltpA="SELECT `ID`, `NAME` FROM `c_sp_itemlist` where `ID` in (1,2,15,19)";
						$dltpA_result=mysqli_query($link_db,$str_dltpA);
						while($dltpA_data=mysqli_fetch_row($dltpA_result)){
							?>
							<option value="<?=$dltpA_data[0];?>"><?=$dltpA_data[1];?></option>
							<?php
						}
						?>
					</select>
					<p style="color:#0F0">
						- 若選擇的 download type ，在 設定時，有check Subcategory，會出現下面 Subcategory 的選單。若有 check OS ，則會出現下面的 OS list 。 
					</p>
				</td>
			</tr>
			<!--設定 Subcategory-->
			<tr id="tr_1">
				<td colspan="2">
					<div id="download_pannel" style="display:none">
						<table border="0">
							<tr id="tr_1_01">
								<th>Subcssatery</th>
								<td>

									<select id="subca01A" name="subca01A" style="display:none">
										<?php
//$str_subcaA="SELECT DISTINCT `VALUECATEGORY` FROM `sp_driver`";
										$str_subcaA="SELECT `LISTNAME` FROM `c_all_selectlist` WHERE `CATEGORY`='driver'";
										$subcaA_result=mysqli_query($link_db,$str_subcaA);
										while($subcaA_data=mysqli_fetch_row($subcaA_result)){
											?>
											<option value="<?=$subcaA_data[0]?>"><?=$subcaA_data[0]?></option>
											<?php
										}
										?>
									</select>
									<select id="subca01A_U" name="subca01A_U" style="display:none">
										<?php
										$str_subcaU="SELECT DISTINCT `VALUECATEGORY` FROM `sp_utility`";
										$subcaU_result=mysqli_query($link_db,$str_subcaU);
										while($subcaU_data=mysqli_fetch_row($subcaU_result)){
											?>
											<option value="<?=$subcaU_data[0]?>"><?=$subcaU_data[0]?></option>
											<?php
										}
										?>
									</select>
									<select id="subca01A_CHS" name="subca01A_CHS" style="display:none;">
										<?php
										$str_subcaCHS="SELECT distinct `CATEGORY` FROM `sp_chassis`";
										$subcaCHS_result=mysqli_query($link_db,$str_subcaCHS);
										while($subcaCHS_data=mysqli_fetch_row($subcaCHS_result)){
											?>
											<option value="<?=$subcaCHS_data[0];?>"><?=$subcaCHS_data[0];?></option>
											<?php
										}
										?>
									</select><div style="display:inline;"></div>
									<select id="subca01A_CHS_vender" name="subca01A_CHS_vender" style="display:none;">
										<?php
										$str_subcaCHS_Vdr="SELECT `ID`, `VENDER` FROM `c_sp_chassis_vender`";
										$subcaCHS_Vdr_result=mysqli_query($link_db,$str_subcaCHS_Vdr);
										while($subcaCHS_Vdr_data=mysqli_fetch_row($subcaCHS_Vdr_result)){
											?>
											<option value="<?=$subcaCHS_Vdr_data[0];?>"><?=$subcaCHS_Vdr_data[1];?></option>
											<?php
										}
										?>
									</select>

								</td>
							</tr>
							<tr id="tr_1_02">
								<th>Vender Model: </th>
								<td><input id="cha_vmodel" name="cha_vmodel" type="text" size="40" value="" style="display:none" /></td>
							</tr>
							<!--設定 supported OSs-->
							<tr id="tr_1_03">
								<th>OS: </th>
								<td>
									<div id="os_area" style="display:none">
										<?php
										$str_osA="SELECT `LISTVALUE`, `LISTNAME` FROM `c_all_selectlist` where `CATEGORY`='OS' and `STATUS`='1'";
										//echo $str_osA;
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
											<input type="checkbox" name="dlA_os[]" value="<?=$osA_data[0];?>"> <?=$osA_data[1];?> <?=$br01;?>
											<?php
										}
										?>
										<p style="color:#0F0">由新至舊列出所有 OS ，可多選</p>
									</div>
								</td>
							</tr>
							<!--end 設定 supported OSs -->

							<tr id="tr_1_04">
								<th>File Name:  </th>
								<td><input id="dlA_name" name="dlA_name" type="text" size="40" value="" style="display:none" /></td>
							</tr>
							<tr id="tr_1_05">
								<th>File Date:  </th>
								<td><input id="dlA_Date" name="dlA_Date" type="text" size="8" value="" onfocus="HS_setDate(this)" style="display:none" /></td>
							</tr>
							<tr id="tr_1_06">
								<th>Version:  </th>
								<td><input id="dlA_ver" name="dlA_ver" type="text" size="10" value="" style="display:none" /></td>
							</tr>
							<tr id="tr_1_07">
								<th>File size:</th>
								<td>
									<input id="dlA_size" name="dlA_size" type="text" size="10" value="" style="display:none" /></td>
								</tr>
								<tr id="tr_1_08">
									<th>File Description:</th>
									<td><textarea id="dlA_desc" name="dlA_desc" rows="4" cols="50" style="max-width: 250px; max-height: 250px;display:none;"></textarea></td>
								</tr>
								<tr id="tr_1_09">
									<th>File Location: </th>
									<td><input id="dlA_loc" name="dlA_loc" type="text" size="40" value="" style="display:none" /></td>
								</tr>
							</table>
						</div>
					</td>
				</tr>

				<!--end 設定 Subcategory -->
				<!--設定 Memory-->
				<tr id="tr_2">
					<th colspan="2">
						<div id="Memory_pannel" style="display:none">
							<table border="0">
								<tr>
									<td width="256">Module Vender:&nbsp;&nbsp;&nbsp;</td>
									<td><select id="MeA_vnder" name="MeA_vnder">
										<?php
										$str_subcaMe="SELECT distinct A.VENDER_NAME, B.MODULEVENDER FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID order by B.MODULEVENDER";
										$subcaMe_result=mysqli_query($link_db,$str_subcaMe);
										while($subcaMe_data=mysqli_fetch_row($subcaMe_result)){
											?>
											<option value="<?=$subcaMe_data[0];?>"><?=$subcaMe_data[1];?></option>
											<?php
										}
										?>
									</select><td></tr>
									<tr>
										<td width="256">Size:&nbsp;&nbsp;&nbsp;</td>
										<td><select id="MeA_size" name="MeA_size">
											<?php
											$str_me_Sze="SELECT `MEMORYSIZE`, `DESCRIPTION`, `STATUS` FROM `c_sp_memory_size`";
											$me_Sze_result=mysqli_query($link_db,$str_me_Sze);
											while($me_Sze_data=mysqli_fetch_row($me_Sze_result)){
												?>
												<option value="<?=$me_Sze_data[0];?>"><?=$me_Sze_data[1];?></option>
												<?php
											}
											?>
										</select><td></tr>
										<tr>
											<td width="256">Type:&nbsp;&nbsp;&nbsp;</td>
											<td><select id="MeA_type" name="MeA_type">
												<?php
												$str_me_typ="SELECT `ID`, `MEMORYTYPE` FROM `c_sp_memory_type`";
												$me_typ_result=mysqli_query($link_db,$str_me_typ);
												while($me_typ_data=mysqli_fetch_row($me_typ_result)){
													?>
													<option value="<?=$me_typ_data[1];?>"><?=$me_typ_data[1];?></option>
													<?php
												}
												?>
											</select><td></tr>
											<tr>
												<td width="256">Chipset Vender:&nbsp;&nbsp;&nbsp;</td>
												<td><select id="MeA_chip" name="MeA_chip">
													<?php
													$str_me_chip="SELECT `ID`, `CHIPVENDER` FROM `c_sp_memory_chipvender` order by `CHIPVENDER`";
													$me_chip_result=mysqli_query($link_db,$str_me_chip);
													while($me_chip_data=mysqli_fetch_row($me_chip_result)){
														?>
														<option value="<?=$me_chip_data[1];?>"><?=$me_chip_data[1];?></option>
														<?php
													}
													?>
												</select></td></tr>
												<tr><td width="256">Vender Number:&nbsp;&nbsp;&nbsp;</td><td><input id="MeA_Vnum" name="MeA_Vnum" type="text" size="40" value="" /></td></tr>
												<tr><td width="256">Part Number:&nbsp;&nbsp;&nbsp;</td><td><input id="MeA_Pnum" name="MeA_Pnum" type="text" size="40" value="" /></td></tr>
												<tr><td width="256">AMB:&nbsp;&nbsp;&nbsp;</td><td><input id="MeA_AMB" name="MeA_AMB" type="text" size="40" value="" /></td></tr>
												<tr>
													<td width="256">Frequence:&nbsp;&nbsp;&nbsp;</td><td><select id="MeA_freq" name="MeA_freq">
													<?php
													$str_me_freq="SELECT `ID`, `FREQUENCE`, `STATUS` FROM `c_sp_memory_frequence` order by `FREQUENCE`";
													$me_freq_result=mysqli_query($link_db,$str_me_freq);
													while($me_freq_data=mysqli_fetch_row($me_freq_result)){
														?>
														<option value="<?=$me_freq_data[1];?>"><?=$me_freq_data[1];?></option>
														<?php
													}
													?>
												</select></td></tr>
												<tr><td width="256">VOLTAGE:&nbsp;&nbsp;&nbsp;</td><td><input id="MeA_volt" name="MeA_volt" type="text" size="40" value="" /></td></tr>
												<tr>
													<td width="256">ROHS:&nbsp;&nbsp;&nbsp;</td><td><select id="MeA_rohs" name="MeA_rohs">
													<option value="1" selected>Yes</option>
													<option value="0">No</option>
												</select></td></tr>
												<tr><td width="256">Qualified CPU:&nbsp;&nbsp;&nbsp;</td><td><input id="MeA_quaCPU" name="MeA_quaCPU" type="text" size="40" value="" /></td></tr>
											</table>
										</div>
									</th>
								</tr>
								<!--end 設定 Memory -->

								<tr id="tr_3">
									<th colspan="2">
										<div id="SI_pannel" style="display:none">
											<table border="0">
												<tr>
													<td width="256">Module Vender:&nbsp;&nbsp;&nbsp;</td>
													<td><select id="SIA_vnder" name="SIA_vnder">
														<?php
														$str_subcaSI="SELECT `ID`, `VENDER`, `STATUS` FROM `c_sp_si_vender`";
														$subcaSI_result=mysqli_query($link_db,$str_subcaSI);
														while($subcaSI_data=mysqli_fetch_row($subcaSI_result)){
															?>
															<option value="<?=$subcaSI_data[0];?>"><?=$subcaSI_data[1];?></option>
															<?php
														}
														?>
													</select><td></tr>
													<tr><td width="256">URL:&nbsp;&nbsp;&nbsp;</td><td><input id="SIA_url" name="SIA_url" type="text" size="40" value="" /></td></tr>
												</table>
											</div>
										</th>
									</tr>

									<tr id="tr_4">
										<th colspan="2">
											<div id="HDD_pannel" style="display:none">
												<table border="0">
													<tr>
														<td width="256">Module Vender:&nbsp;&nbsp;&nbsp;</td>
														<td><select id="HDD_vnder" name="HDD_vnder">
															<?php
															$str_subcaHDDvd="SELECT `ID`, `MODULEVENDER`, `STATUS` FROM `c_sp_hdd_modulevender`";
															$subcaHDDvd_result=mysqli_query($link_db,$str_subcaHDDvd);
															while($subcaHDDvd_data=mysqli_fetch_row($subcaHDDvd_result)){
																?>
																<option value="<?=$subcaHDDvd_data[0];?>"><?=$subcaHDDvd_data[1];?></option>
																<?php
															}
															?>
														</select><td></tr>
														<tr><td width="256">MODEL Name:&nbsp;&nbsp;&nbsp;</td><td><input id="HDD_mname" name="HDD_mname" type="text" size="40" value="" /></td></tr>
														<tr><td width="256">HDD Size:&nbsp;&nbsp;&nbsp;</td>
															<td><select id="HDD_size" name="HDD_size">
																<?php
																$str_subcaHDDsz="SELECT `ID`, `HDDSIZE`, `STATUS` FROM `c_sp_hdd_size`";
																$subcaHDDsz_result=mysqli_query($link_db,$str_subcaHDDsz);
																while($subcaHDDsz_data=mysqli_fetch_row($subcaHDDsz_result)){
																	?>
																	<option value="<?=$subcaHDDsz_data[1];?>"><?=$subcaHDDsz_data[1];?></option>
																	<?php
																}
																?>
															</select></td></tr>
															<tr><td width="256">HDD Type:&nbsp;&nbsp;&nbsp;</td>
																<td><select id="HDD_type" name="HDD_type">
																	<?php
																	$str_subcaHDDtp="SELECT `ID`, `HDDTYPE`, `STATUS` FROM `c_sp_hdd_type`";
																	$subcaHDDtp_result=mysqli_query($link_db,$str_subcaHDDtp);
																	while($subcaHDDtp_data=mysqli_fetch_row($subcaHDDtp_result)){
																		?>
																		<option value="<?=$subcaHDDtp_data[1];?>"><?=$subcaHDDtp_data[1];?></option>
																		<?php
																	}
																	?>
																</select></td></tr>
																<tr><td width="256">HDD CAPACITY:&nbsp;&nbsp;&nbsp;</td>
																	<td><select id="HDD_capac" name="HDD_capac">
																		<?php
																		$str_subcaHDDcap="SELECT `ID`, `Capacity`, `STATUS` FROM `c_sp_hdd_capacity`";
																		$subcaHDDcap_result=mysqli_query($link_db,$str_subcaHDDcap);
																		while($subcaHDDcap_data=mysqli_fetch_row($subcaHDDcap_result)){
																			?>
																			<option value="<?=$subcaHDDcap_data[1];?>"><?=$subcaHDDcap_data[1];?></option>
																			<?php
																		}
																		?>
																	</select></td></tr>

																	<tr><td width="256">HDD BUS:&nbsp;&nbsp;&nbsp;</td>
																		<td><select id="HDD_bus" name="HDD_bus">
																			<?php
																			$str_subcaHDDbus="SELECT `ID`, `HDDBUS`, `STATUS` FROM `c_sp_hdd_bus`";
																			$subcaHDDbus_result=mysqli_query($link_db,$str_subcaHDDbus);
																			while($subcaHDDbus_data=mysqli_fetch_row($subcaHDDbus_result)){
																				?>
																				<option value="<?=$subcaHDDbus_data[1];?>"><?=$subcaHDDbus_data[1];?></option>
																				<?php
																			}
																			?>
																		</select></td></tr>

																	</table>
																</div>
															</th>
														</tr>

														<tr>
															<th>Products:</th>
															<td><div class="button14" style="width:60px;" ><a class="fancybox fancybox.iframe" href="../lb_doload_mo.php" style="color:#ffffff">Edit</a></div>
																<!--列出被勾選的Products-->
																<textarea id="relProd_val" name="relProd_val" rows="5" cols="80" style="border: none;max-width: 800px; max-height: 200px;" readonly></textarea>
																<p><span id="relProd"></span></p></td>
															</tr>
															<tr>
																<th>Notes:</th>
																<td>
																	<textarea id="dlA_note" name="dlA_note" rows="4" cols="50" style="max-width: 250px; max-height: 250px;"></textarea>
																</td>
															</tr>
															<tr>
																<th>Status:</th>
																<td><select id="statusA" name="statusA"><option value="1" selected>Online</option><option value="0">Offline</option></select>
																</td>
															</tr>
															<tr><td colspan="2">
																<input name="B2" class="button14" style="width:60px;" type="submit" value="Done" />&nbsp;&nbsp;<input name="C2" class="button14" style="width:60px;" type="button" value="Cancel" onclick="javascript:location.href='download_module.php'" /> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
															</td></tr>
														</table>
													</form>
													<script language="JavaScript">
													function Final_Check(){
														var dl_num=document.getElementById('dlA_type').value;
														if(dl_num==4 || dl_num==5 || dl_num==11 || dl_num==18){	

														}else{
															if(document.form1.dlA_type.value == ""){
																alert("Required select a Download Type！");
																document.form1.dlA_type.focus();
																return false;
															}
															if(document.form1.dlA_name.value == ""){
																alert("Required input a File Name！");
																document.form1.dlA_name.focus();
																return false;
															}
															if(document.form1.dlA_Date.value == ""){
																alert("Required input a File Date！");
																document.form1.dlA_Date.focus();
																return false;
															}
														}
														return true;
													}
													</script>
												</div>
												<p class="clear">&nbsp;</p>
											</div>
											<?php
											if(isset($_REQUEST['mid'])!='' && isset($_REQUEST['d_type'])!=''){
												$mid=$_REQUEST['mid'];
												$d_type01=$_REQUEST['d_type'];

												if(trim($d_type01)=="Drivers"){  
													$str_m="Select `ID`, `VALUECATEGORY`, `FILENAME`, `FILEDATE`, `DESCRIPTION`, `VERSION`, `FILESIZE`, `PATH`, `OS`, `MODEL`, `NOTES`, `LANG`, `STATUS` from `sp_driver` where `ID`=".$mid;
													$m_result=mysqli_query($link_db,$str_m);
													$m_data=mysqli_fetch_row($m_result);
													$id01=$m_data[0];
													$valuecategory01=$m_data[1];
													$os01=$m_data[8];
													$filename01=$m_data[2];
													$filedata01=$m_data[3];
													$version01=$m_data[5];
													$filesize01=$m_data[6];
													$description01=$m_data[4];
													$path01=$m_data[7];
													$model01=$m_data[9];
													$note01=$m_data[10];
													$lang01=$m_data[11];
													$status01=$m_data[12];
												}else if(trim($d_type01)=="BIOS"){
													$str_m="Select `ID`, `FILENAME`, `FILEDATE`, `DESCRIPTION`, `VERSION`, `PATH`, `FILESIZE`, `LANG`, `MODEL`, `NOTES`, `STATUS` from `sp_bios` where `ID`=".$mid;
													$m_result=mysqli_query($link_db,$str_m);
													$m_data=mysqli_fetch_row($m_result);
													$id01=$m_data[0];
													$filename01=$m_data[1];
													$filedata01=$m_data[2];
													$description01=$m_data[3];
													$version01=$m_data[4];
													$path01=$m_data[5];
													$filesize01=$m_data[6];
													$lang01=$m_data[7];
													$model01=$m_data[8];
													$note01=$m_data[9];
													$status01=$m_data[10];
												}else if(trim($d_type01)=="Firmware"){
													$str_m="Select `ID`, `FILENAME`, `FILEDATE`, `DESCRIPTION`, `VERSION`, `PATH`, `FILESIZE`, `NOTES`, `LANG`, `MODEL`, `STATUS`, `OS` from `sp_firmware` where `ID`=".$mid;
													$m_result=mysqli_query($link_db,$str_m);
													$m_data=mysqli_fetch_row($m_result);
													$id01=$m_data[0];
													$filename01=$m_data[1];
													$filedata01=$m_data[2];
													$description01=$m_data[3];
													$version01=$m_data[4];
													$path01=$m_data[5];
													$filesize01=$m_data[6];
													$note01=$m_data[7];
													$lang01=$m_data[8];
													$model01=$m_data[9];  
													$status01=$m_data[10];  
													$os01=$m_data[11];
												}else if(trim($d_type01)=="Software Downloads"){
													$str_m="Select `ID`, `FILENAME`, `FILEDATE`, `DESCRIPTION`, `VERSION`, `PATH`, `FILESIZE`, `NOTES`, `LANG`, `MODEL`, `STATUS`, `OS` from `sp_software` where `ID`=".$mid;
													$m_result=mysqli_query($link_db,$str_m);
													$m_data=mysqli_fetch_row($m_result);
													$id01=$m_data[0];
													$filename01=$m_data[1];
													$filedata01=$m_data[2];
													$description01=$m_data[3];
													$version01=$m_data[4];
													$path01=$m_data[5];
													$filesize01=$m_data[6];
													$note01=$m_data[7];
													$lang01=$m_data[8];
													$model01=$m_data[9];  
													$status01=$m_data[10]; 
													$os01=$m_data[11]; 
												}
												?>
												<div id="downlo_edit" class="subsettings" style="display:none">
													<form id="form2" name="form2" method="post" action="?kinds=edit_downlo" enctype="multipart/form-data" onsubmit="return Final_MCheck();">
														<input type="hidden" name="m_id" value="<?=$id01;?>">
														<h1>Edit a download file</h1>
														<div class="right"><a href="#" onclick="hide_edit()"> [close] </a></div>
														<table class="addspec">
															<tr>
																<th>Download Type:  </th>
																<td>
																	<select id="dl_type" name="dl_type" onChange="MM_PTM(this)">
																		<option value="" >--Select--</option>
																		<?php
																		$str_dltp="SELECT `ID`, `NAME` FROM `c_sp_itemlist` where `ID` in (1,2,15,19) and `NAME`='".trim($d_type01)."'";
																		$dltp_result=mysqli_query($link_db,$str_dltp);
																		$dltp_data=mysqli_fetch_row($dltp_result);
																		?>
																		<option value="<?=$dltp_data[0];?>" selected><?=$dltp_data[1];?></option>
																	</select> <a href="#downlo_edit" onclick="MM_PTM()">Show All</a>
																	<p style="color:#0F0">
																		- 若選擇的 download type ，在 設定時，有check Subcategory，會出現下面 Subcategory 的選單。若有 check OS ，則會出現下面的 OS list 。 
																	</p>
																</td>
															</tr>
															<!--設定 Subcategory-->
															<tr id="tr_1M">
																<td colspan="2">
																	<div id="download_pannelM" style="display:none">
																		<table border="0">
																			<tr id="tr_1_01M">
																				<th>Subcatery</th>
																				<td>
																					<select id="subca01" name="subca01" style="display:none">
																						<?php
																						//$str_subcaA="SELECT DISTINCT `VALUECATEGORY` FROM `sp_driver`";
																						$str_subcaA="SELECT `LISTNAME` FROM `c_all_selectlist` WHERE `CATEGORY`='driver'";
																						$subcaA_result=mysqli_query($link_db,$str_subcaA);
																						while($subcaA_data=mysqli_fetch_row($subcaA_result)){
																							?>
																							<option value="<?=$subcaA_data[0]?>" <?php if($subcaA_data[0]==$valuecategory01){ echo "selected"; } ?>><?=$subcaA_data[0]?></option>
																							<?php
																						}
																						?>
																					</select>
																					<select id="subca01_U" name="subca01_U" style="display:none">
																						<?php
																						$str_subcaU="SELECT DISTINCT `VALUECATEGORY` FROM `sp_utility`";
																						$subcaU_result=mysqli_query($link_db,$str_subcaU);
																						while($subcaU_data=mysqli_fetch_row($subcaU_result)){
																							?>
																							<option value="<?=$subcaU_data[0]?>"><?=$subcaU_data[0]?></option>
																							<?php
																						}
																						?>
																					</select>
																					<select id="subca01_CHS" name="subca01_CHS" style="display:none;">
																						<?php
																						$str_subcaCHS="SELECT distinct `CATEGORY` FROM `sp_chassis`";
																						$subcaCHS_result=mysqli_query($link_db,$str_subcaCHS);
																						while($subcaCHS_data=mysqli_fetch_row($subcaCHS_result)){
																							?>
																							<option value="<?=$subcaCHS_data[0];?>" <?php if($category01==$subcaCHS_data[0]){ echo "selected";  } ?>><?=$subcaCHS_data[0];?></option>
																							<?php
																						}
																						?>
																					</select><div style="display:inline;"></div>
																					<select id="subca01_CHS_vender" name="subca01_CHS_vender" style="display:none;">
																						<?php
																						$str_subcaCHS_Vdr="SELECT `ID`, `VENDER` FROM `c_sp_chassis_vender`";
																						$subcaCHS_Vdr_result=mysqli_query($link_db,$str_subcaCHS_Vdr);
																						while($subcaCHS_Vdr_data=mysqli_fetch_row($subcaCHS_Vdr_result)){
																							?>
																							<option value="<?=$subcaCHS_Vdr_data[0];?>" <?php if($venderid01==$subcaCHS_Vdr_data[0]){ echo "selected"; } ?>><?=$subcaCHS_Vdr_data[1];?></option>
																							<?php
																						}
																						?>
																					</select>
																				</td>
																			</tr>
																			<tr id="tr_1_02M">
																				<th>Vender Model: </th>
																				<td><input id="cha_vmodelM" name="cha_vmodelM" type="text" size="40" value="<?=$vendermodel01;?>" style="display:none" /></td>
																			</tr>
																			<!--設定 supported OSs-->
																			<tr id="tr_1_03M">
																				<th>OS: </th>
																				<td>
																					<div id="os_areaM" style="display:none">
																						<?php
																						$str_osA="SELECT `LISTVALUE`, `LISTNAME` FROM `c_all_selectlist` where `CATEGORY`='OS' and `STATUS`='1'";
																						$osA_result=mysqli_query($link_db,$str_osA);
																						while($osA_data=mysqli_fetch_row($osA_result)){
																							$o+=1;
																							if($o%5==0){
																								$br01="<br />";
																							}else{
																								$br01="";
																							}
																							?>
																							<input type="checkbox" name="dl_os[]" value="<?=$osA_data[0];?>" <?php if(strpos(";".$os01,";".$osA_data[0].";")!='' || strpos(";".$os01,";".$osA_data[0].";")===0) { echo "checked"; } ?>> <?=$osA_data[1];?> <?=$br01;?>
																							<?php
																						}
																						?>
																						<p style="color:#0F0">由新至舊列出所有 OS ，可多選</p>
																					</div>
																				</td>
																			</tr>
																			<!--end 設定 supported OSs -->

																			<tr id="tr_1_04M">
																				<th>File Name:  </th>
																				<td><input id="dl_name" name="dl_name" type="text" size="50" value="<?=$filename01;?>" style="display:none" /></td>
																			</tr>
																			<tr id="tr_1_05M">
																				<th>File Date:  </th>
																				<td><input id="dl_Date" name="dl_Date" type="text" size="8" value="<?=$filedata01;?>" onfocus="HS_setDate(this)" style="display:none" /></td>
																			</tr>
																			<tr id="tr_1_06M">
																				<th>Version:  </th>
																				<td><input id="dl_ver" name="dl_ver" type="text" size="50" value="<?=$version01;?>" style="display:none" /></td>
																			</tr>
																			<tr id="tr_1_07M">
																				<th>File size:</th>
																				<td>
																					<input id="dl_size" name="dl_size" type="text" size="30" value="<?=$filesize01;?>" style="display:none" /></td>
																				</tr>
																				<tr id="tr_1_08M">
																					<th>File Description:</th>
																					<td><textarea id="dl_desc" name="dl_desc" rows="4" cols="50" style="max-width: 250px; max-height: 250px;display:none;"><?=$description01;?></textarea></td>
																				</tr>
																				<tr id="tr_1_09M">
																					<th>File Location: </th>
																					<td><input id="dl_loc" name="dl_loc" type="text" size="50" value="<?=$path01;?>" style="display:none" /></td>
																				</tr>
																			</table>
																		</div>
																	</td>
																</tr>
																<!--end 設定 Subcategory -->
																<!--設定 Memory-->
																<tr id="tr_2M">
																	<th colspan="2">
																		<div id="Memory_pannelM" style="display:none">
																			<table border="0">
																				<tr>
																					<td width="256">Module Vender:&nbsp;&nbsp;&nbsp;</td>
																					<td><select id="Me_vnder" name="Me_vnder">
																						<?php
																						$str_subcaMe="SELECT distinct A.VENDER_NAME, B.MODULEVENDER FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID order by B.MODULEVENDER";
																						$subcaMe_result=mysqli_query($link_db,$str_subcaMe);
																						while($subcaMe_data=mysqli_fetch_row($subcaMe_result)){
																							?>
																							<option value="<?=$subcaMe_data[0];?>" <?php if($vender_name01==$subcaMe_data[0]){ echo "selected"; } ?>><?=$subcaMe_data[1];?></option>
																							<?php
																						}
																						?>
																					</select><td></tr>
																					<tr>
																						<td width="256">Size:&nbsp;&nbsp;&nbsp;</td>
																						<td><select id="Me_size" name="Me_size">
																							<?php
																							$str_me_Sze="SELECT `MEMORYSIZE`, `DESCRIPTION`, `STATUS` FROM `c_sp_memory_size`";
																							$me_Sze_result=mysqli_query($link_db,$str_me_Sze);
																							while($me_Sze_data=mysqli_fetch_row($me_Sze_result)){
																								?>
																								<option value="<?=$me_Sze_data[0];?>" <?php if($memory_size01==$me_Sze_data[0]){ echo "selected"; } ?>><?=$me_Sze_data[1];?></option>
																								<?php
																							}
																							?>
																						</select><td></tr>
																						<tr>
																							<td width="256">Type:&nbsp;&nbsp;&nbsp;</td>
																							<td><select id="Me_type" name="Me_type">
																								<?php
																								$str_me_typ="SELECT `ID`, `MEMORYTYPE` FROM `c_sp_memory_type`";
																								$me_typ_result=mysqli_query($link_db,$str_me_typ);
																								while($me_typ_data=mysqli_fetch_row($me_typ_result)){
																									?>
																									<option value="<?=$me_typ_data[1];?>" <?php if($memory_type01==$me_typ_data[1]){ echo "selected"; } ?>><?=$me_typ_data[1];?></option>
																									<?php
																								}
																								?>
																							</select><td></tr>
																							<tr>
																								<td width="256">Chipset Vender:&nbsp;&nbsp;&nbsp;</td>
																								<td><select id="Me_chip" name="Me_chip">
																									<?php
																									$str_me_chip="SELECT `ID`, `CHIPVENDER` FROM `c_sp_memory_chipvender` order by `CHIPVENDER`";
																									$me_chip_result=mysqli_query($link_db,$str_me_chip);
																									while($me_chip_data=mysqli_fetch_row($me_chip_result)){
																										?>
																										<option value="<?=$me_chip_data[1];?>" <?php if($chip01==$me_chip_data[1]){ echo "selected"; } ?>><?=$me_chip_data[1];?></option>
																										<?php
																									}
																									?>
																								</select></td></tr>
																								<tr><td width="256">Vender Number:&nbsp;&nbsp;&nbsp;</td><td><input id="Me_Vnum" name="Me_Vnum" type="text" size="40" value="<?=$vender_number01;?>" /></td></tr>
																								<tr><td width="256">Part Number:&nbsp;&nbsp;&nbsp;</td><td><input id="Me_Pnum" name="Me_Pnum" type="text" size="40" value="<?=$chip_part_number01;?>" /></td></tr>
																								<tr><td width="256">AMB:&nbsp;&nbsp;&nbsp;</td><td><input id="Me_AMB" name="Me_AMB" type="text" size="40" value="<?=$amb01;?>" /></td></tr>
																								<tr>
																									<td width="256">Frequence:&nbsp;&nbsp;&nbsp;</td><td><select id="Me_freq" name="Me_freq">
																									<?php
																									$str_me_freq="SELECT `ID`, `FREQUENCE`, `STATUS` FROM `c_sp_memory_frequence` order by `FREQUENCE`";
																									$me_freq_result=mysqli_query($link_db,$str_me_freq);
																									while($me_freq_data=mysqli_fetch_row($me_freq_result)){
																										?>
																										<option value="<?=$me_freq_data[1];?>" <?php if($memory_frequence01==$me_freq_data[1]){ echo "selected"; } ?>><?=$me_freq_data[1];?></option>
																										<?php
																									}
																									?>
																								</select></td></tr>
																								<tr><td width="256">VOLTAGE:&nbsp;&nbsp;&nbsp;</td><td><input id="Me_volt" name="Me_volt" type="text" size="40" value="<?=$vlotage01;?>" /></td></tr>
																								<tr>
																									<td width="256">ROHS:&nbsp;&nbsp;&nbsp;</td><td><select id="Me_rohs" name="Me_rohs">
																									<option value="1" <?php if($rohs01==1){ echo "selected"; } ?>>Yes</option>
																									<option value="0" <?php if($rohs01==0){ echo "selected"; } ?>>No</option>
																								</select></td></tr>
																								<tr><td width="256">Qualified CPU:&nbsp;&nbsp;&nbsp;</td><td><input id="Me_quaCPU" name="Me_quaCPU" type="text" size="40" value="<?=$qualifiedcpu01;?>" /></td></tr>
																							</table>
																						</th>
																					</tr>
																					<!--end 設定 Memory -->

																					<tr id="tr_3M">
																						<th colspan="2">
																							<div id="SI_pannelM" style="display:none">
																								<table border="0">
																									<tr>
																										<td width="256">Module Vender:&nbsp;&nbsp;&nbsp;</td>
																										<td><select id="SI_vnder" name="SI_vnder">
																											<?php
																											$str_subcaSI="SELECT `ID`, `VENDER`, `STATUS` FROM `c_sp_si_vender`";
																											$subcaSI_result=mysqli_query($link_db,$str_subcaSI);
																											while($subcaSI_data=mysqli_fetch_row($subcaSI_result)){
																												?>
																												<option value="<?=$subcaSI_data[0];?>" <?php if($subcaSI_data[0]==$venderid01){ echo "selected"; } ?>><?=$subcaSI_data[1];?></option>
																												<?php
																											}
																											?>
																										</select><td></tr>
																										<tr><td width="256">URL:&nbsp;&nbsp;&nbsp;</td><td><input id="SI_url" name="SI_url" type="text" size="60" value="<?=$link01;?>" /></td></tr>
																									</table>
																								</div>
																							</th>
																						</tr>

																						<tr id="tr_4M">
																							<th colspan="2">
																								<div id="HDD_pannelM" style="display:none">
																									<table border="0">
																										<tr>
																											<td width="256">Module Vender:&nbsp;&nbsp;&nbsp;</td>
																											<td><select id="HDD_vnderM" name="HDD_vnderM">
																												<?php
																												$str_subcaHDDvd="SELECT `ID`, `MODULEVENDER`, `STATUS` FROM `c_sp_hdd_modulevender`";
																												$subcaHDDvd_result=mysqli_query($link_db,$str_subcaHDDvd);
																												while($subcaHDDvd_data=mysqli_fetch_row($subcaHDDvd_result)){
																													?>
																													<option value="<?=$subcaHDDvd_data[0];?>"><?=$subcaHDDvd_data[1];?></option>
																													<?php
																												}
																												?>
																											</select><td></tr>
																											<tr><td width="256">MODEL Name:&nbsp;&nbsp;&nbsp;</td><td><input id="HDD_mnameM" name="HDD_mnameM" type="text" size="40" value="<?=$model_name01;?>" /></td></tr>
																											<tr><td width="256">HDD Size:&nbsp;&nbsp;&nbsp;</td>
																												<td><select id="HDD_sizeM" name="HDD_sizeM">
																													<?php
																													$str_subcaHDDsz="SELECT `ID`, `HDDSIZE`, `STATUS` FROM `c_sp_hdd_size`";
																													$subcaHDDsz_result=mysqli_query($link_db,$str_subcaHDDsz);
																													while($subcaHDDsz_data=mysqli_fetch_row($subcaHDDsz_result)){
																														?>
																														<option value="<?=$subcaHDDsz_data[1];?>" <?php if($subcaHDDsz_data[1]==$hdd_size01){ echo "selected"; } ?>><?=$subcaHDDsz_data[1];?></option>
																														<?php
																													}
																													?>
																												</select></td></tr>
																												<tr><td width="256">HDD Type:&nbsp;&nbsp;&nbsp;</td>
																													<td><select id="HDD_typeM" name="HDD_typeM">
																														<?php
																														$str_subcaHDDtp="SELECT `ID`, `HDDTYPE`, `STATUS` FROM `c_sp_hdd_type`";
																														$subcaHDDtp_result=mysqli_query($link_db,$str_subcaHDDtp);
																														while($subcaHDDtp_data=mysqli_fetch_row($subcaHDDtp_result)){
																															?>
																															<option value="<?=$subcaHDDtp_data[1];?>"><?=$subcaHDDtp_data[1];?></option>
																															<?php
																														}
																														?>
																													</select></td></tr>
																													<tr><td width="256">HDD CAPACITY:&nbsp;&nbsp;&nbsp;</td>
																														<td><select id="HDD_capacM" name="HDD_capacM">
																															<?php
																															$str_subcaHDDcap="SELECT `ID`, `Capacity`, `STATUS` FROM `c_sp_hdd_capacity`";
																															$subcaHDDcap_result=mysqli_query($link_db,$str_subcaHDDcap);
																															while($subcaHDDcap_data=mysqli_fetch_row($subcaHDDcap_result)){
																																?>
																																<option value="<?=$subcaHDDcap_data[1];?>"><?=$subcaHDDcap_data[1];?></option>
																																<?php
																															}
																															?>
																														</select></td></tr>

																														<tr><td width="256">HDD BUS:&nbsp;&nbsp;&nbsp;</td>
																															<td><select id="HDD_busM" name="HDD_busM">
																																<?php
																																$str_subcaHDDbus="SELECT `ID`, `HDDBUS`, `STATUS` FROM `c_sp_hdd_bus`";
																																$subcaHDDbus_result=mysqli_query($link_db,$str_subcaHDDbus);
																																while($subcaHDDbus_data=mysqli_fetch_row($subcaHDDbus_result)){
																																	?>
																																	<option value="<?=$subcaHDDbus_data[1];?>"><?=$subcaHDDbus_data[1];?></option>
																																	<?php
																																}
																																?>
																															</select></td></tr>

																														</table>
																													</div>
																												</th>
																											</tr>

																											<tr>
																												<th>Products:</th>
																												<td><div class="button14" style="width:60px;" ><a class="fancybox fancybox.iframe" href="../elb_doload_mo.php?cid=<?=$id01;?>&d_type=<?=$d_type01;?>" style="color:#ffffff">Edit</a></div>
																													<!--列出被勾選的Products-->
																													<textarea id="relProd_valM" name="relProd_valM" rows="5" cols="80" style="border: none;max-width: 800px; max-height: 200px;" readonly><?=$model01;?></textarea>
																													<p><span id="relProd"></span></p></td>
																												</tr>
																												<tr>
																													<th>Notes:</th>
																													<td>
																														<textarea id="dl_note" name="dl_note" rows="4" cols="50" style="max-width: 250px; max-height: 250px;"><?=$note01;?></textarea>
																													</td>
																												</tr>
																												<tr>
																													<th>Status:</th>
																													<td><select id="status" name="status"><option value="1" <?php if($status01=='1'){ echo "selected"; } ?>>Online</option><option value="0" <?php if($status01=='0'){ echo "selected"; } ?>>Offline</option></select>
																													</td>
																												</tr>
																												<tr><td colspan="2">
																													<input name="B2" class="button14" style="width:60px;" type="submit" value="Done" />&nbsp;&nbsp;<input name="C2" class="button14" style="width:60px;" type="button" value="Cancel" onclick="javascript:location.href='download_module.php'" /> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
																												</td></tr>
																											</table>
																										</form>
																										<script language="JavaScript">
																										function Final_MCheck(){
																											var dl_num=document.getElementById('dl_type').value;
																											if(dl_num==4 || dl_num==5 || dl_num==18){	

																											}else{
																												if(document.form2.dl_type.value == ""){
																													alert("Required select a Download Type！");
																													document.form2.dl_type.focus();
																													return false;
																												}
																												if(document.form2.dl_name.value == ""){
																													alert("Required input a File Name！");
																													document.form2.dl_name.focus();
																													return false;
																												}
																												if(document.form2.dl_Date.value == ""){
																													alert("Required input a File Date！");
																													document.form2.dl_Date.focus();
																													return false;
																												}
																											}
																											return true;
																										}
																										</script>
																									</div>
																									<?php
																								}
																								?>
																								<div id="footer">	Copyright &copy; 2014 Company Co. All rights reserved.
																									<div class="gotop" onClick="location='#top'">Top</div>
																								</div>
																							</body>
																							</html>
																							<?php
																							if(isset($_REQUEST['mid'])!=''){
																								echo "<script language='JavaScript'>show_edit();</script>";
																								exit();
																							}
																							?>