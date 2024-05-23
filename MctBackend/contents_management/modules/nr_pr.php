<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);

require "../../config.php";
include_once('../../page.class.php');
error_reporting(0);

@session_start();
if(empty($_SESSION['user']) || empty($_SESSION['password']) || empty($_SESSION['login_time'])){
echo "<script language='JavaScript'>location='../../login.php'</script>";
exit();
}

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase);

if(isset($_REQUEST['act'])!='' || isset($_REQUEST['d_id'])!=''){
  if(trim($_REQUEST['act'])=='del'){
  $d_id01=intval($_REQUEST['d_id']);
  $str_del="delete from `nr_pressroom` where `ID`=".$d_id01;
  $del_cmd=mysqli_query($link_db,$str_del);
  echo "<script>alert('Delete the Data !');self.location='nr_pr.php';</script>";
  exit();
  }
}

if(isset($_REQUEST['kinds'])!=''){
if(trim($_REQUEST['kinds'])=='add_nrpr'){

if(isset($_POST['pr1A'])!=''){
$pr1A=trim($_POST['pr1A']);
$pr1A=str_replace("'","&#39;",$pr1A);
}else{
$pr1A="";
}
if(isset($_POST['PDateA'])!=''){
$PDateA=trim($_POST['PDateA']);
}else{
$PDateA="";
}
if(isset($_POST['pr2A'])!=''){
$pr2A=trim($_POST['pr2A']);
}else{
$pr2A="";
}
if(isset($_POST['editor1'])!=''){
$editor1=trim($_POST['editor1']);
$editor1=str_replace("'","&#39;",$editor1);
}else{
$editor1="";
}
if(isset($_FILES['myFileA']['name'])!=''){
$myFileA=trim($_FILES['myFileA']['name']);
}else{
$myFileA="";
}
if(isset($_POST['pr_langA'])!=''){
$pr_langA=trim($_POST['pr_langA']);
}else{
$pr_langA="";
}
if(isset($_POST['relProd_val'])!=''){
$relProd_val=trim($_POST['relProd_val']);
}else{
$relProd_val="";
}
if(isset($_POST['check_itemST'])!=''){
$check_itemST=trim($_POST['check_itemST']);
}else{
$check_itemST="";
}
if(isset($_POST['check_itemSH'])!=''){
$check_itemSH=trim($_POST['check_itemSH']);
}else{
$check_itemSH="";
}
if(isset($_POST['a_redirect'])!=''){
	$a_redirect=trim($_POST['a_redirect']);
}else{
	$a_redirect="";
}

if($check_itemST=='1'){
    if(isset($_POST['pr_statusA'])!=''){
	$pr_statusA=$_POST['pr_statusA'];
	$sDT="0000-00-00 00:00:00";
	$eDT="0000-00-00 00:00:00";
	}
}else if($check_itemSH=='2'){
    if(isset($_POST['sDate'])!=''){
	$sDate=$_POST['sDate'];
	$sTime=$_POST['sTime'];
	$sDT = $sDate." ".$sTime;
	}
	if(isset($_POST['eDate'])!=''){
	$eDate=$_POST['eDate'];
	$eTime=$_POST['eTime'];
	$eDT = $eDate." ".$eTime;
	}
}

   if(($myFileA != "none" && $myFileA != ""))
   {
     $UploadPath = "../../../images/pressroom_pic/";
     $flag = copy($_FILES['myFileA']['tmp_name'], $UploadPath.$_FILES['myFileA']['name']);
     if($flag) echo "";
     $urlA="images/pressroom_pic/";
   }else{
     $urlA="";
   }

$str_n="SELECT `ID` from `nr_pressroom` order by `ID` desc limit 1";
$check_cmd=mysqli_query($link_db,$str_n);
$MCount_record=mysqli_fetch_row($check_cmd);
$SCount=$MCount_record[0]+1;

$str_inst="insert into `nr_pressroom` (`ID`, `TITLE`, `CONTENT`, `DETAIL`, `NEWSDATE`, `MODEL`, `LANG`, `IMG`, `STATUS`, `sDate`, `eDate`, `Redirect`) values (".$SCount.",'".$pr1A."','".$pr2A."','".$editor1."','".$PDateA."','".$relProd_val."','".$pr_langA."','$urlA$myFileA','".$pr_statusA."', '".$sDT."', '".$eDT."', '".$a_redirect."')";
$inst_cmd=mysqli_query($link_db,$str_inst);
echo "<script>alert('AddNew a Press Release Data!');window.location.href='nr_pr.php'</script>";
exit();
}

if(trim($_REQUEST['kinds'])=='edit_nrpr'){
    if(isset($_POST['prid01'])!=''){
	$prid01=intval($_POST['prid01']);
	}else{
	$prid01="";
	}
	if(isset($_POST['pr1'])!=''){
	$pr1=trim($_POST['pr1']);
	$pr1=str_replace("'","&#39;",$pr1);
	}else{
	$pr1="";
	}
	if(isset($_POST['PDate'])!=''){
	$PDate=trim($_POST['PDate']);
	}else{
	$PDate="";
	}
	if(isset($_POST['pr2'])!=''){
	$pr2=trim($_POST['pr2']);
	}else{
	$pr2="";
	}
	if(isset($_POST['editor2'])!=''){
	$editor2=trim($_POST['editor2']);
	$editor2=str_replace("'","&#39;",$editor2);
	}else{
	$editor2="";
	}
	if(isset($_FILES['myFile']['name'])!=''){
	$myFile=trim($_FILES['myFile']['name']);
	}else{
	$myFile="";
	}
	if(isset($_POST['pr_lang'])!=''){
	$pr_lang=$_POST['pr_lang'];
	}else{
	$pr_lang="";
	}
	if(isset($_POST['relProd_mval'])!=''){
	$relProd_mval=trim($_POST['relProd_mval']);
	}else{
	$relProd_mval="";
	}
	if(isset($_POST['check_itemST_M'])!=''){
	$check_itemST_M=trim($_POST['check_itemST_M']);
	}else{
	$check_itemST_M="";
	}
	if(isset($_POST['check_itemSH_M'])!=''){
	$check_itemSH_M=trim($_POST['check_itemSH_M']);
	}else{
	$check_itemSH_M="";
	}
	if(isset($_POST['e_redirect'])!=''){
		$e_redirect=trim($_POST['e_redirect']);
	}else{
		$e_redirect="";
	}

if($check_itemST_M=='1'){
    if(isset($_POST['pr_status'])!=''){
	$pr_status=$_POST['pr_status'];
	$sDTM="0000-00-00 00:00:00";
	$eDTM="0000-00-00 00:00:00";
	}
}else if($check_itemSH_M=='2'){
	if(isset($_POST['sDateM'])!=''){
	$sDateM=$_POST['sDateM'];
	$sTimeM=$_POST['sTimeM'];
	$sDTM=$sDateM." ".$sTimeM;
	}
	if(isset($_POST['eDateM'])!=''){
	$eDateM=$_POST['eDateM'];
	$eTimeM=$_POST['eTimeM'];
	$eDTM=$eDateM." ".$eTimeM;
	}
}

   if(($myFile != "none" && $myFile != ""))
   {
     $UploadPath = "../../../images/pressroom_pic/";
     $flag = copy($_FILES['myFile']['tmp_name'], $UploadPath.$_FILES['myFile']['name']);
     if($flag) echo "";
     $url="images/pressroom_pic/";
   }else{
     $url="";
   }

//putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

if($check_itemST_M=='1'){
   if($myFile!=''){
   $str_upd="UPDATE `nr_pressroom` SET `TITLE`='".$pr1."',`CONTENT`='".$pr2."',`DETAIL`='".$editor2."',`NEWSDATE`='".$PDate."',`MODEL`='".$relProd_mval."',`LANG`='".$pr_lang."',`IMG`='$url$myFile',`UPDATE_USER`='admin',`UPDATE_DATE`='".$now."',`STATUS`='".$pr_status."', `sDate`='".$sDTM."', `eDate`='".$eDTM."', `Redirect`='".$e_redirect."' where `ID`=".$prid01;
   }else{
   $str_upd="UPDATE `nr_pressroom` SET `TITLE`='".$pr1."',`CONTENT`='".$pr2."',`DETAIL`='".$editor2."',`NEWSDATE`='".$PDate."',`MODEL`='".$relProd_mval."',`LANG`='".$pr_lang."',`UPDATE_USER`='admin',`UPDATE_DATE`='".$now."',`STATUS`='".$pr_status."', `sDate`='".$sDTM."', `eDate`='".$eDTM."', `Redirect`='".$e_redirect."' where `ID`=".$prid01;
   }
}else if($check_itemSH_M=='2'){
   if($myFile!=''){
   $str_upd="UPDATE `nr_pressroom` SET `TITLE`='".$pr1."',`CONTENT`='".$pr2."',`DETAIL`='".$editor2."',`NEWSDATE`='".$PDate."',`MODEL`='".$relProd_mval."',`LANG`='".$pr_lang."',`IMG`='$url$myFile',`UPDATE_USER`='admin',`UPDATE_DATE`='".$now."', `sDate`='".$sDTM."', `eDate`='".$eDTM."', `Redirect`='".$e_redirect."' where `ID`=".$prid01;
   }else{
   $str_upd="UPDATE `nr_pressroom` SET `TITLE`='".$pr1."',`CONTENT`='".$pr2."',`DETAIL`='".$editor2."',`NEWSDATE`='".$PDate."',`MODEL`='".$relProd_mval."',`LANG`='".$pr_lang."',`UPDATE_USER`='admin',`UPDATE_DATE`='".$now."', `sDate`='".$sDTM."', `eDate`='".$eDTM."', `Redirect`='".$e_redirect."' where `ID`=".$prid01;
   }
}

$upd_cmd=mysqli_query($link_db,$str_upd);
echo "<script>alert('Update a Press Release Data!');window.location.href='nr_pr.php'</script>";
exit();
}
}
  $slang="";
  if(isset($_REQUEST['s_search'])<>''){
  $s_search=trim($_REQUEST['s_search']);
  //$s_search=preg_replace("['\"\$ \r\n\t;<>\*%\?]", '', $_REQUEST['s_search']);
    if(isset($_REQUEST['slang'])<>''){
     $slang=trim($_REQUEST['slang']);
	 $str1="select count(*) from `nr_pressroom` where (`TITLE` like '%".$s_search."%' or `CONTENT` like '%".$s_search."%' or `DETAIL` like '%".$s_search."%') and (`LANG`='".$slang."')";
    }else{
	 $str1="select count(*) from `nr_pressroom` where (`TITLE` like '%".$s_search."%' or `CONTENT` like '%".$s_search."%' or `DETAIL` like '%".$s_search."%')";
    }
  }else{

	if(isset($_REQUEST['slang'])<>''){
     $slang=trim($_REQUEST['slang']);
     $str1="SELECT count(*) from `nr_pressroom` where (`LANG`='".$slang."')";
	}else{
	 $str1="select count(*) from `nr_pressroom`";
	}

  }
  $list1=mysqli_query($link_db,$str1);
  list($public_count)=mysqli_fetch_row($list1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Website Contents Management - Products Management - Contents: Modules - (Newsroom) Press Release</title>
<link rel="stylesheet" type="text/css" href="../../backend.css">
<link rel="stylesheet" type="text/css" href="../../css/css.css" />
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
$(function() {

  $("#check_itemST").click(function() {
   if($('input[id="check_itemST"]:checked').val()=='1'){
    $('input[name="check_itemSH"][value="2"]').prop("checked",false);
    $('#pr_statusA').prop('disabled', false);
    $('#sDate').prop('disabled', true);
    $('#sTime').prop('disabled', true);
	$('#eDate').prop('disabled', true);
	$('#eTime').prop('disabled', true);
   }
  });

  $("#check_itemSH").click(function() {
   if($('input[id="check_itemSH"]:checked').val()=='2'){
    $('input[name="check_itemST"][value="1"]').prop("checked",false);
    $('#pr_statusA').prop('disabled', true);
    $('#sDate').prop('disabled', false);
    $('#sTime').prop('disabled', false);
	$('#eDate').prop('disabled', false);
	$('#eTime').prop('disabled', false);
   }
  });

  $("#check_itemST_M").click(function() {
   if($('input[id="check_itemST_M"]:checked').val()=='1'){
    $('input[name="check_itemSH_M"][value="2"]').prop("checked",false);
    $('#pr_status').prop('disabled', false);
    $('#sDateM').prop('disabled', true);
    $('#sTimeM').prop('disabled', true);
	$('#eDateM').prop('disabled', true);
	$('#sTimeM').prop('disabled', true);
   }
  });

  $("#check_itemSH_M").click(function() {
   if($('input[id="check_itemSH_M"]:checked').val()=='2'){
    $('input[name="check_itemST_M"][value="1"]').prop("checked",false);
    $('#pr_status').prop('disabled', true);
    $('#sDateM').prop('disabled', false);
    $('#sTimeM').prop('disabled', false);
	$('#eDateM').prop('disabled', false);
	$('#eTimeM').prop('disabled', false);
   }
  });

  $("#sear_txt").keypress(function (event) {
	if (event.keyCode == 13) {
	self.location.href = document.getElementById('SEL_SLang').value + "&s_search=" + document.getElementById('sear_txt').value;
	}
  });
});
</script>

    <script language="JavaScript">
    function MM_SL(selObj){
	   window.open(document.getElementById('SEL_SLang').options[document.getElementById('SEL_SLang').selectedIndex].value,"_self");
	}

	function MM_o(selObj){
       window.open(document.getElementById('PressRelease_page').options[document.getElementById('PressRelease_page').selectedIndex].value,"_self");
    }

	function search_value(){
	var slang;
    //self.location = "?s_search=" + document.form3.sear_txt.value;
	slang=document.getElementById('SEL_SLang').value;
    self.location = slang + "&s_search=" + document.getElementById('sear_txt').value;
    return false;
    }

	function doEnter(event){
    var keyCodeEntered = (event.which) ? event.which : window.event.keyCode;
     if (keyCodeEntered == 13){
       if(confirm('Are you sure you want to search this word?')) {
	   document.location.href = document.getElementById('SEL_SLang').value + "&s_search=" + document.getElementById('sear_txt').value;
	   }
     }
    }

	function show_add(){
	  $('#nrpr_add').show();
	  $('#nrpr_edit').hide();
	}

	function hiden_add(){
	  //#('#nrpr_add_').hide();
	  self.location = "nr_pr.php";
	}

	function show_edit(){
	  $('#nrpr_edit').show();
	  $('#nrpr_add').hide();
	}

	function hiden_edit(){
	  self.location = "nr_pr.php";
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
	</script>
</head>

<body>
<a name="top"></a>
<div >
<div class="left"><h1>&nbsp;&nbsp;Website Backends - Website Contents Management - Contents: (Newsroom) Press Release</h1></div>
<div id="logout">Hi <?=str_replace("@mic.com.tw", "", $_SESSION['user']);?> <a href="../logo.php">Log out &gt;&gt;</a></div>
</div>
<div class="clear"></div>
<?php
include("menus.php");
?>

<div class="clear"></div>
<div id="Search" >
<h2>Contents &nbsp;&gt;&nbsp;  <a href="../modules.php">Modules</a>  &nbsp;&gt;&nbsp; (Newsroom) Press Release</h2>
</div>

<div id="content">
<br />
<div class="right">| &nbsp;<a href="nr_events.php" />Events</a>&nbsp; | &nbsp;<a href="nr_awards.php" />Awards</a>&nbsp; | &nbsp;<a href="nr_review.php" />Press Review</a>&nbsp; | &nbsp;</div>
<br />
<h3>Press Release Lists:
</h3>
<div class="pagination left">
<p>
<form id="form3" name="form3" method="post" action="nr_pr.php" onsubmit="return false;">
<select id="SEL_SLang" name="SEL_SLang" onChange="MM_SL(this)">
<option value="nr_pr.php?slang=">All</option>
<option value="nr_pr.php?slang=en-US" <?php if($slang=='en-US'){ echo "selected";} ?>>English</option>
<option value="nr_pr.php?slang=zh-CN" <?php if($slang=='zh-CN'){ echo "selected";} ?>>簡體</option>
<option value="nr_pr.php?slang=zh-TW" <?php if($slang=='zh-TW'){ echo "selected";} ?>>繁體</option>
<option value="nr_pr.php?slang=ja-JP" <?php if($slang=='ja-JP'){ echo "selected";} ?>>日文</option>
</select> <input id="sear_txt" name="sear_txt" type="text" size="20" value="" /> <input type="button" value="Search" onclick="search_value();" />
</form>
<span style="color:#0F0">**Key word search: "PR Title" & "Related Products" & "Outline" & "Contents" 欄位 </span>
</p>

<div class="pagination left">Total: <span class="w14bblue"><?=$public_count;?></span> records </div>
</div>
<table class="list_table">
  <tr>
    <th >*PR Date</th><th  >*PR Title</th><th>Related Products</th><th  >Language</th><th  >*Status</th><th><div class="button14" style="width:50px;"><a href="#nrpr_add" STYLE="text-decoration:none" onClick="show_add();">Add</a></div></th>
  </tr>
  <?php
	  if(isset($_REQUEST['page'])!=""){
      $page=intval($_REQUEST['page']);
      }else{
      $page="1";
      }

      if(empty($page))$page="1";

      $read_num="10";
      $start_num=$read_num*($page-1);

        if(isset($_REQUEST['s_search'])!=''){
		//$s_search=preg_replace("['\"\$ \r\n\t;<>\*%\?]", '', $_REQUEST['s_search']);
          if(isset($_REQUEST['slang'])<>''){
		   $slang=trim($_REQUEST['slang']);
		   $str="SELECT `ID`, `TITLE`, `CONTENT`, `DETAIL`, `NEWSDATE`, `NOTES`, `MODEL`, `LANG`, `UPDATE_USER`, `UPDATE_DATE`, `STATUS`, `sDate`, `eDate` FROM `nr_pressroom` where (`TITLE` like '%".$s_search."%' or `CONTENT` like '%".$s_search."%' or `DETAIL` like '%".$s_search."%') and (`LANG`='".$slang."') ORDER BY `ID` DESC limit $start_num,$read_num;";
          }else{
		   $str="SELECT `ID`, `TITLE`, `CONTENT`, `DETAIL`, `NEWSDATE`, `NOTES`, `MODEL`, `LANG`, `UPDATE_USER`, `UPDATE_DATE`, `STATUS`, `sDate`, `eDate` FROM `nr_pressroom` where (`TITLE` like '%".$s_search."%' or `CONTENT` like '%".$s_search."%' or `DETAIL` like '%".$s_search."%') ORDER BY `ID` DESC limit $start_num,$read_num;";
          }
		}else{

		  if(isset($_REQUEST['slang'])<>''){
           $slang=trim($_REQUEST['slang']);
		   $str="SELECT `ID`, `TITLE`, `CONTENT`, `DETAIL`, `NEWSDATE`, `NOTES`, `MODEL`, `LANG`, `UPDATE_USER`, `UPDATE_DATE`, `STATUS`, `sDate`, `eDate` FROM `nr_pressroom` where (`LANG`='".$slang."') ORDER BY `ID` DESC limit $start_num,$read_num;";
		  }else{
		   $str="SELECT `ID`, `TITLE`, `CONTENT`, `DETAIL`, `NEWSDATE`, `NOTES`, `MODEL`, `LANG`, `UPDATE_USER`, `UPDATE_DATE`, `STATUS`, `sDate`, `eDate` FROM `nr_pressroom` ORDER BY `ID` DESC limit $start_num,$read_num;";
		  }
		}
      $result=mysqli_query($link_db,$str);
      $i=0;
	  while(list($ID, $TITLE, $CONTENT, $DETAIL, $NEWSDATE, $NOTES, $MODEL, $LANG, $UPDATE_USER, $UPDATE_DATE, $STATUS, $sDate, $eDate)=mysqli_fetch_row($result))
      {
      $i=$i+1;
      putenv("TZ=Asia/Taipei");
  ?>
  <tr>
    <td ><?=date("Y/m/d",strtotime($NEWSDATE));?></td><td><?php if(strlen($TITLE)>=40){ echo substr($TITLE,0 ,40)."----"; }else if(strlen($TITLE)<40){ echo $TITLE; }?></td>
    <td><?=$MODEL;?></td>
    <td><?=$LANG;?></td>
    <td><?php if($STATUS=='1'){ echo "Online"; }else if($STATUS=='0'){ echo "Offline"; }?></br><?php if(strtotime($sDate)>0 && $sDate!=NULL){echo "<font  style='color:#FF0000'>(".$sDate.")</font>";} ?></td>
    <td ><a href="nr_pr.php?prid=<?=$ID;?>&types=edit#nrpr_edit">Edit</a>&nbsp;&nbsp;<a href="?act=del&d_id=<?=$ID;?>" onclick="return confirm('Are you sure you want to delete this item?');">Del</a></td>
  </tr>
  <?php
      }
  ?>
  <tr>
    <td colspan="7">
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
<select id="PressRelease_page" name="PressRelease_page" onChange="MM_o(this)">
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

<p >&nbsp;</p><p >&nbsp;</p>
  <P style="color:#0F0">
  - "PR Title" 只show 前100個characters<br >
  - "Related Products" show 只要有被勾選的SKU 的 Model，重覆的 Model 只show 一筆<br >
  - "Status" 決定此則PR是否online<br >
  - click "Del" 要popup a confirmation window to proceed<br >
  - * 表可sorting<br >- List 順序：新至舊
  </p>
<p class="clear">&nbsp;</p>
<!--Click Edit and add -->
<div id="nrpr_add" class="subsettings" style="display:none">
<form id="form1" name="form1" method="post" action="?kinds=add_nrpr" enctype="multipart/form-data" onsubmit="return Final_Check();">
<h1>Add a PR:</h1>
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hiden_add()"> [close] </a></div><!--end of close-->
<table class="addspec">

<tr>
<th>PR Title:  </th>
<td><input id="pr1A" name="pr1A" type="text" size="80" value="" /></td>
</tr>
<tr>
<th>PR Date:  </th>
<td><input id="PDateA" name="PDateA" type="text" size="10" value="" onfocus="HS_setDate(this)" /></td>
</tr>
<tr>
<th>Outline: </th>
<td><input id="pr2A" name="pr2A" type="text" size="80" value="" /></td>
</tr>
<tr>
<th>Contents: </th>
<td><textarea id="editor1" name="editor1" rows="5" cols="100" style="max-width: 500px; max-height: 500px;"></textarea>
<p style="color:#0F0">** web editor : Allow HTML code</p>
</td>
</tr>
<tr>
<th>Image: </th>
<td><input type="file" name="myFileA" size="20"></td>
</tr>
<tr>
<th>Redirect:  </th>
<td><input id="a_redirect" name="a_redirect" type="text" size="50" value=""  />
<P style="color:#0F0">Please use underline _ for the space.<p>
</td>
</tr>
<tr>
<th>Language:</th>
<td>
<select id="pr_langA" name="pr_langA">
<option value="" selected>Select...</option>
<option value="en-US">English</option>
<option value="zh-CN">簡體</option>
<option value="zh-TW">繁體</option>
<option value="ja-JP">日文</option>
</select><span style="color:#0F0">*必選欄位</span>
</td>
</tr>
<tr>
<th>Related Products:</th>
<td> <div class="button14 " style="width:60px;" ><a class="fancybox fancybox.iframe" href="../lb_supported_pros.php" style="color:#ffffff">Edit</a></div>
 <!--列出被勾選的Products-->
 <textarea id="relProd_val" name="relProd_val" rows="5" cols="80" style="border: none;max-width: 800px; max-height: 200px;" readonly></textarea>
 <p><span id="relProd"></span></p><!--end of 列出被勾選的Products-->
 </td>
</tr>
<tr>
<th>Status/Schedule:</th>
<td>
<input type="radio" id="check_itemST" name="check_itemST" value="1" checked />

<select id="pr_statusA" name="pr_statusA">
<option selected value="1">Online</option>
<option value="0">Offline</option>
</select>&nbsp;&nbsp;&nbsp;&nbsp;
Schedule : <input type="radio" id="check_itemSH" name="check_itemSH" value="2" /> <input id="sDate" name="sDate" type="text" size="20" value="" onfocus="HS_setDate(this)" disabled />  <input id="sTime" name="sTime" type="text" size="8" value="00:00:00" disabled /> to <input id="eDate" name="eDate" type="text" size="20" value="" onfocus="HS_setDate(this)" disabled />  <input id="eTime" name="eTime" type="text" size="8" value="00:00:00" disabled />
<font  style="color:#FF0000"> Server分鐘需加10分鐘<font >
<P style="color:#0F0">
- 只能設定立即上線/下線 或是 上線的schedule 其中之一、選擇任何一個，另一個就失效。Default 為 online。<br>
- schedule 的設定請套 JQuery date picker<br>
<p>
</td>
</tr>
<tr><td colspan="2">
<!--<input name="c2" type="button" value="Cancel" onclick="javascript:self.location='nr_pr.php'" />&nbsp;&nbsp;<input name="b2" type="submit" value="Done" />-->
<BUTTON name="submitbutton01" id="submitbutton01" style="width:70px; margin-right:10px" type="submit" class="big_button left">Done</BUTTON><BUTTON name="submitbutton02" id="submitbutton02" style="width:86px; margin-right:10px" type="reset" class="big_button left" onclick="javascript:self.location='nr_pr.php'">Cancel</BUTTON>  <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
</td></tr>
</table>
</form>

<script language="JavaScript">
function Final_Check( ) {
if(document.form1.pr1A.value == ""){
alert("Required input a PR Title！");
document.form1.pr1A.focus();
return false;
}

if(document.form1.PDateA.value == ""){
alert("Required select a PR Date！");
document.form1.PDateA.focus();
return false;
}

if(document.form1.pr2A.value == ""){
alert("Required input a Outline！");
document.form1.pr2A.focus();
return false;
}
/*
if(document.form1.editor1.value == ""){
alert("Required input a Contents！");
document.form1.editor1.focus();
return false;
}
*/

//-------20170509 Add 判斷image是否有檔案----------
/* if(document.form1.myFileA.value == ""){
alert("Please select To upload large image！");
document.form1.myFileA.focus();
return false;
} */

if(document.form1.pr_langA.value == ""){
alert("Required select a language！");
document.form1.pr_langA.focus();
return false;
}

//2017.08.14 註解非必要欄位
/*if(document.form1.relProd_val.value == ""){
alert("Required Input a Related Products！");
document.form1.relProd_val.focus();
return false;
}*/

return true;
}
</script>
</div>
<?php
if(isset($_REQUEST['prid'])!=''){

  $prid=intval($_REQUEST['prid']);
  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
  mysqli_query($link_db, 'SET NAMES utf8');
  //$select=mysqli_select_db($dataBase);
  $str_m="SELECT `ID`, `TITLE`, `CONTENT`, `DETAIL`, `NEWSDATE`, `NOTES`, `MODEL`, `LANG`, `IMG`, `UPDATE_USER`, `UPDATE_DATE`, `STATUS`, `sDate`, `eDate`, `Redirect` FROM `nr_pressroom` where `ID`=".$prid;
  $mresult=mysqli_query($link_db,$str_m);
  $mdata=mysqli_fetch_row($mresult);

?>

<div id="nrpr_edit" class="subsettings" style="display:none">
<form id="form2" name="form2" method="post" action="?kinds=edit_nrpr" enctype="multipart/form-data" onsubmit="return EFinal_Check();">
<h1>Edit a PR:</h1>
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hiden_edit()"> [close] </a></div><!--end of close-->
<table class="addspec">

<tr>
<th>PR Title:  </th>
<td><input id="pr1" name="pr1" type="text" size="80" value="<?=$mdata[1];?>" /></td>
</tr>
<tr>
<th>PR Date:  </th>
<td><input id="PDate" name="PDate" type="text" size="10" value="<?=date("Y/m/d",strtotime($mdata[4]));?>" onfocus="HS_setDate(this)" /></td>
</tr>
<tr>
<th>Outline: </th>
<td><input id="pr2" name="pr2" type="text" size="80" value="<?=$mdata[2];?>" /></td>
</tr>
<tr>
<th>Contents: </th>
<td><textarea id="editor2" name="editor2" rows="5" cols="100" style="max-width: 500px; max-height: 500px;"><?=$mdata[3];?></textarea>
<p style="color:#0F0">** web editor : Alow HTML code</p>
</td>
</tr>
<tr>
<th>Image: </th>
<td><input type="file" name="myFile" size="20">&nbsp;<p><?=$mdata[8]?></p></td>
</tr>
<tr>
<th>Redirect:  </th>
<td><input id="e_redirect" name="e_redirect" type="text" size="50" value="<?=$mdata[14];?>"  />
<P style="color:#0F0">Please use underline _ for the space.<p>
</td>
</tr>
<tr>
<th>Language:</th>
<td>
<select id="pr_lang" name="pr_lang">
<option value="">Select...</option>
<option value="en-US" <?php if($mdata[7]=='en-US'){ echo "selected"; } ?>>English</option>
<option value="zh-CN" <?php if($mdata[7]=='zh-CN'){ echo "selected"; } ?>>簡體</option>
<option value="zh-TW" <?php if($mdata[7]=='zh-TW'){ echo "selected"; } ?>>繁體</option>
<option value="ja-JP" <?php if($mdata[7]=='ja-JP'){ echo "selected"; } ?>>日文</option>
</select><span style="color:#0F0">*必選欄位</span>
</td>
</tr>
<tr>
<th>Related Products:</th>
<td> <div class="button14 " style="width:60px;" ><a class="fancybox fancybox.iframe" href="../elb_supported_pros_PRL.php?pid=<?=$mdata[0];?>" style="color:#ffffff">Edit</a></div>
 <!--列出被勾選的Products-->
 <textarea id="relProd_mval" name="relProd_mval" rows="5" cols="80" style="border: none;max-width: 800px; max-height: 200px;" readonly><?=$mdata[6];?></textarea>
 <p><span id="relProd"></span></p><!--end of 列出被勾選的Products-->
 </td>
</tr>
<tr>
<th>Status/Schedule:</th>
<td>
<input type="radio" id="check_itemST_M" name="check_itemST_M" value="1" checked />

<select id="pr_status" name="pr_status">
<option value="1" <?php if($mdata[11]=='1'){ echo "selected"; } ?>>Online</option>
<option value="0" <?php if($mdata[11]=='0'){ echo "selected"; } ?>>Offline</option>
</select>&nbsp;&nbsp;&nbsp;&nbsp;
Schedule:<input type="radio" id="check_itemSH_M" name="check_itemSH_M" value="2" /> <input id="sDateM" name="sDateM" type="text" size="20" value="" onfocus="HS_setDate(this)" disabled />  <input id="sTimeM" name="sTimeM" type="text" size="8" value="00:00:00" disabled /> to <input id="eDateM" name="eDateM" type="text" size="20" value="" onfocus="HS_setDate(this)" disabled />  <input id="eTimeM" name="eTimeM" type="text" size="8" value="00:00:00" disabled /><font  style="color:#FF0000">(<?php echo$mdata[12]; ?>)<font > <font  style="color:#FF0000"> Server分鐘需加10分鐘<font >
<P style="color:#0F0">
- 只能設定立即上線/下線 或是 上線的schedule 其中之一、選擇任何一個，另一個就失效。Default 為 online。<br>
- schedule 的設定請套 JQuery date picker<br>
<p>
</td>
</tr>
<tr><td colspan="2">
<input type="hidden" name="prid01" value="<?=$mdata[0];?>">
<!--<input name="c2" type="button" value="Cancel" onclick="form2.reset();" />&nbsp;&nbsp;<input name="b2" type="submit" value="Done" />-->
<BUTTON name="submitbutton01" id="submitbutton01" style="width:70px; margin-right:10px" type="submit" class="big_button left">Done</BUTTON><BUTTON name="submitbutton02" id="submitbutton02" style="width:86px; margin-right:10px" type="reset" class="big_button left" onclick="form2.reset();">Cancel</BUTTON> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
</td></tr>
</table>
</form>

<script language="JavaScript">
function EFinal_Check( ) {
if(document.form2.pr1.value == ""){
alert("Required input a PR Title！");
document.form2.pr1.focus();
return false;
}

if(document.form2.PDate.value == ""){
alert("Required select a PR Date！");
document.form2.PDate.focus();
return false;
}

if(document.form2.pr2.value == ""){
alert("Required input a Outline！");
document.form2.pr2.focus();
return false;
}

//-------------Edit 判斷image是否有檔案----------
/* if(document.form2.myFile.value == ""){
alert("Please select To upload large image！");
document.form2.myFile.focus();
return false;
} */

if(document.form2.pr_lang.value == ""){
alert("Required select a language！");
document.form2.pr_lang.focus();
return false;
}

if(document.form2.relProd_val.value == ""){
alert("Required Input a Related Products！");
document.form2.relProd_val.focus();
return false;
}

return true;
}
</script>
</div>
<?php
}
?>
<p class="clear">&nbsp;</p>
</div>

<div id="footer">	Copyright &copy; 2014 Company Co. All rights reserved.
<div class="gotop" onClick="location='#top'">Top</div>
</div>
<script src="../ckeditor/ckeditor.js"></script>
<script>
  CKEDITOR.replace( 'editor2', {
    });
</script>
<script>
  CKEDITOR.replace( 'editor1', {
    });
</script>
</body>
</html>
<?php
if(isset($_REQUEST['prid'])!=''){
echo "<script>show_edit();</script>\n";
exit();
}
?>