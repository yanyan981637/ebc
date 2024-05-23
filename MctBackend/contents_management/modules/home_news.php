<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

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
  $str_del="delete from `nr_news` where `ID`=".$d_id01;
  $del_cmd=mysqli_query($link_db,$str_del);
  echo "<script>alert('Delete the Data !');self.location='home_news.php';</script>";
  exit();
  }
}
if(isset($_REQUEST['kinds'])!=''){
	if(trim($_REQUEST['kinds'])=='add_hmnews'){

		if(isset($_POST['nw1A'])!=''){
			$nw1A=trim($_POST['nw1A']);
			$nw1A=str_replace("'","&#39;",$nw1A);
		}else{
			$nw1A="";
		}
		if(isset($_POST['nw2A'])!=''){
			$nw2A=trim($_POST['nw2A']);
		}else{
			$nw2A="";
		}
		if(isset($_POST['nw3A'])!=''){
			$nw3A=trim($_POST['nw3A']);
		}else{
			$nw3A="";
		}
		if(isset($_POST['nw_langA'])!=''){
			$nw_langA=trim($_POST['nw_langA']);
		}else{
			$nw_langA="";
		}
		if(isset($_POST['nw_statusA'])!=''){
			$nw_statusA=trim($_POST['nw_statusA']);
		}
		if($_POST['sDate']!=''){
			$sDate=trim($_POST['sDate']);
		}else{
			$sDate="0000-00-00 00:00:00";
		}
		if($_POST['eDate']!=''){
			$eDate=trim($_POST['eDate']);
		}else{
			$eDate="0000-00-00 00:00:00";
		}

		$str_n="SELECT `ID` from `nr_news` order by `ID` desc limit 1";
		$check_cmd=mysqli_query($link_db,$str_n);
		$MCount_record=mysqli_fetch_row($check_cmd);
		$SCount=$MCount_record[0]+1;

		$str_inst="insert into `nr_news` (`ID`, `TITLE`, `LINK`, `SORT`, `LANG`, `STATUS`, `NEWS_START_DATE`, `NEWS_END_DATE`) values (".$SCount.",'".$nw1A."','".$nw2A."','".$nw3A."','".$nw_langA."','".$nw_statusA."','".$sDate."','".$eDate."')";
		//echo $str_inst;exit();
		$inst_cmd=mysqli_query($link_db,$str_inst);
		echo "<script>alert('AddNew a News Data!');window.location.href='home_news.php'</script>";
		exit();
	}

	if(trim($_REQUEST['kinds'])=='edit_hmnw'){
		if(isset($_POST['nwid01'])!=''){
			$nwid01=intval($_POST['nwid01']);
		}else{
			$nwid01="";
		}
		if(isset($_POST['nw1'])!=''){
			$nw1=trim($_POST['nw1']);
			$nw1=str_replace("'","&#39;",$nw1);
		}else{
			$nw1="";
		}
		if(isset($_POST['nw2'])!=''){
			$nw2=trim($_POST['nw2']);
		}else{
			$nw2="";
		}
		if(isset($_POST['nw3'])!=''){
			$nw3=trim($_POST['nw3']);
		}else{
			$nw3="";
		}
		if(isset($_POST['nw_lang'])!=''){
			$nw_lang=$_POST['nw_lang'];
		}else{
			$nw_lang="";
		}

		if(isset($_POST['nw_status'])!=''){
			$nw_status=$_POST['nw_status'];
		}
		if($_POST['sDateM']!=''){
			$sDateM=$_POST['sDateM'];
		}else{
			$sDateM="0000-00-00 00:00:00";
		}
		if($_POST['eDateM']!=''){
			$eDateM=$_POST['eDateM'];
		}else{
			$eDateM="0000-00-00 00:00:00";
		}

		putenv("TZ=Asia/Taipei");
		$now=date("Y/m/d H:i:s");

		$str_upd="UPDATE `nr_news` SET `TITLE`='".$nw1."',`LINK`='".$nw2."',`SORT`='".$nw3."',`LANG`='".$nw_lang."',`NEWS_START_DATE`='".$sDateM."',`NEWS_END_DATE`='".$eDateM."',`UPDATE_DATE`='".$now."',`STATUS`='".$nw_status."' where `ID`=".$nwid01; 
		$upd_cmd=mysqli_query($link_db,$str_upd);
		echo "<script>alert('Update a News Data!');window.location.href='home_news.php'</script>";
		exit();
	}
}
$slang=""; $sstatus="";$s_search="";
if($_REQUEST['s_search']<>''){
	$s_search=trim($_REQUEST['s_search']);
  //$s_search=preg_replace("['\"\$ \r\n\t;<>\*%\?]", '', $_REQUEST['s_search']);
	if($_REQUEST['slang']<>''){
		$slang=trim($_REQUEST['slang']);	
		if($_REQUEST['sstatus']<>''){
			$sstatus=$_REQUEST['sstatus'];	
			$str1="select count(*) from `nr_news` where (`TITLE` like '%".$s_search."%') and (`LANG`='".$slang."') and `STATUS` = '".$sstatus."'";
		}else{
			$str1="select count(*) from `nr_news` where (`TITLE` like '%".$s_search."%') and (`LANG`='".$slang."')";
		} 
	}else{
		$str1="select count(*) from `nr_news` where (`TITLE` like '%".$s_search."%')";
	}
}else{
	if($_REQUEST['slang']<>''){		  
		$slang=trim($_REQUEST['slang']);	
		if($_REQUEST['sstatus']<>''){
			$sstatus=$_REQUEST['sstatus'];	
			$str1="SELECT count(*) from `nr_news` where (`LANG`='".$slang."') and `STATUS` = '".$sstatus."'";
		}else{
			$str1="select count(*) from `nr_news` where (`LANG`='".$slang."')";
		}
	}else{
		if($_REQUEST['sstatus']<>''){
			$sstatus=$_REQUEST['sstatus'];	
			$str1="SELECT count(*) from `nr_news` where `STATUS` = '".$sstatus."'";
		}else{
			$str1="select count(*) from `nr_news` where `STATUS` = '1'";
		}

	}
	
}
  //echo $str1;
$list1=mysqli_query($link_db,$str1);
list($public_count)=mysqli_fetch_row($list1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Website Contents Management - Products Management - Contents: Modules - Mitac News</title>
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
	$('#eDate').prop('disabled', true);
   }
  });
  
  $("#check_itemSH").click(function() {  
   if($('input[id="check_itemSH"]:checked').val()=='2'){
    $('input[name="check_itemST"][value="1"]').prop("checked",false);
    $('#pr_statusA').prop('disabled', true);
    $('#sDate').prop('disabled', false);
	$('#eDate').prop('disabled', false);
   }
  });
  
  $("#check_itemST_M").click(function() {  
   if($('input[id="check_itemST_M"]:checked').val()=='1'){
    $('input[name="check_itemSH_M"][value="2"]').prop("checked",false);
    $('#pr_status').prop('disabled', false);
    $('#sDateM').prop('disabled', true);
	$('#eDateM').prop('disabled', true);
   }
  });
  
  $("#check_itemSH_M").click(function() {  
   if($('input[id="check_itemSH_M"]:checked').val()=='2'){
    $('input[name="check_itemST_M"][value="1"]').prop("checked",false);
    $('#pr_status').prop('disabled', true);
    $('#sDateM').prop('disabled', false);
	$('#eDateM').prop('disabled', false);
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
	
	function MM_Ss(selObj){
		var slang = document.getElementById('SEL_SLang').value;
		var sstatus = document.getElementById('SEL_status').value;
		var surl = slang+"&sstatus="+sstatus;
		//alert(surl);exit;
		window.open(surl,"_self");
	}

	function MM_o(selObj){
       window.open(document.getElementById('news_page').options[document.getElementById('news_page').selectedIndex].value,"_self");
    }
	
	function search_value(){
	var slang;
    //self.location = "?s_search=" + document.form3.sear_txt.value;
	slang=document.getElementById('SEL_SLang').value;
	var sstatus = document.getElementById('SEL_status').value;
    self.location = slang + "&sstatus=" + sstatus + "&s_search=" + document.getElementById('sear_txt').value;
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
	  $('#hmnw_add').show();
	  $('#hmnw_edit').hide();
	}

	function hiden_add(){
	  //#('#hmnw_add_').hide();
	  self.location = "home_news.php";
	}
	
	function show_edit(){
	  $('#hmnw_edit').show();
	  $('#hmnw_add').hide();
	}
	
	function hiden_edit(){
	  self.location = "home_news.php";
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
<div class="left"><h1>&nbsp;&nbsp;Website Backends - Website Contents Management - Contents: Mitac News</h1></div>
<div id="logout">Hi <?=str_replace("@mic.com.tw", "", $_SESSION['user']);?> <a href="../logo.php">Log out &gt;&gt;</a></div>
</div>
<div class="clear"></div>
<div id="menu">
<ul>
<li ><a href="../default.php">Products</a></li>
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
<h2>Contents &nbsp;&gt;&nbsp;  <a href="../modules.php">Modules</a>  &nbsp;&gt;&nbsp; Mitac News</h2> 
</div>

<div id="content">
<br />
<h3>News Lists:
</h3>
<div class="pagination left">
<p>
<form id="form3" name="form3" method="post" action="home_news.php" onsubmit="return false;">
<select id="SEL_SLang" name="SEL_SLang" onChange="MM_SL(this)">
<option value="home_news.php?slang=">All</option>
<option value="home_news.php?slang=en-US" <?php if($slang=='en-US'){ echo "selected";} ?>>English</option>
<option value="home_news.php?slang=zh-CN" <?php if($slang=='zh-CN'){ echo "selected";} ?>>簡體</option>
<option value="home_news.php?slang=zh-TW" <?php if($slang=='zh-TW'){ echo "selected";} ?>>繁體</option>
<option value="home_news.php?slang=ja-JP" <?php if($slang=='ja-JP'){ echo "selected";} ?>>日文</option>
</select>
<select id="SEL_status" name="SEL_status" onChange="MM_Ss(this)">
<option value="">All</option>
<option value="1" <?php if($sstatus=='1'){ echo "selected";} ?>>Online</option>
<option value="0" <?php if($sstatus=='0'){ echo "selected";} ?>>Offline</option>
</select>
<input id="sear_txt" name="sear_txt" type="text" size="20" value="" />
<input type="button" value="Search" onclick="search_value();" />
</form> 
</p>

<div class="pagination left">Total: <span class="w14bblue"><?=$public_count;?></span> records </div>
</div>
<table class="list_table">
  <tr>
    <th>Title</th><th>LINK</th><th>Language</th><th>Status</th><th><div class="button14" style="width:50px;"><a href="#hmnw_add" STYLE="text-decoration:none" onClick="show_add();">Add</a></div></th>
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
      
        if($_REQUEST['s_search']!=''){
		//$s_search=preg_replace("['\"\$ \r\n\t;<>\*%\?]", '', $_REQUEST['s_search']);
          $s_search = $_REQUEST['s_search'];
          if($_REQUEST['slang']<>''){ 
          	$slang=trim($_REQUEST['slang']); 
          	if($_REQUEST['sstatus']<>''){
          		$sstatus = $_REQUEST['sstatus'];
		   		$str="SELECT `ID`, `TITLE`, `LINK`, `SORT`, `LANG`, `STATUS`, `NEWS_START_DATE`, `NEWS_END_DATE`, `UPDATE_DATE` FROM `nr_news` where (`TITLE` like '%".$s_search."%') and (`LANG`='".$slang."') and `STATUS`='".$sstatus."' ORDER BY `UPDATE_DATE` limit $start_num,$read_num;";
          	}else{
          		$sstatus = $_REQUEST['sstatus'];
          		$slang=trim($_REQUEST['slang']); 
		   		$str="SELECT `ID`, `TITLE`, `LINK`, `SORT`, `LANG`, `STATUS`, `NEWS_START_DATE`, `NEWS_END_DATE`, `UPDATE_DATE` FROM `nr_news` where (`TITLE` like '%".$s_search."%') and (`LANG`='".$slang."') ORDER BY `UPDATE_DATE` limit $start_num,$read_num;";
          	}
		   
          }else{
          	if($_REQUEST['sstatus']<>''){
          		$sstatus = $_REQUEST['sstatus'];
		   		$str="SELECT `ID`, `TITLE`, `LINK`, `SORT`, `LANG`, `STATUS`, `NEWS_START_DATE`, `NEWS_END_DATE`, `UPDATE_DATE` FROM `nr_news` where (`TITLE` like '%".$s_search."%') and `STATUS`='".$sstatus."' ORDER BY `UPDATE_DATE` limit $start_num,$read_num;";
          	}else{
          		$sstatus = $_REQUEST['sstatus'];
          		$slang=trim($_REQUEST['slang']); 
		   		$str="SELECT `ID`, `TITLE`, `LINK`, `SORT`, `LANG`, `STATUS`, `NEWS_START_DATE`, `NEWS_END_DATE`, `UPDATE_DATE` FROM `nr_news` where (`TITLE` like '%".$s_search."%') ORDER BY `UPDATE_DATE` limit $start_num,$read_num;";
          	}
          }
		}else{
		  
		  if($_REQUEST['slang']<>''){
		  	$slang=trim($_REQUEST['slang']); 
          	if($_REQUEST['sstatus']<>''){
          		$sstatus = $_REQUEST['sstatus'];
		   		$str="SELECT `ID`, `TITLE`, `LINK`, `SORT`, `LANG`, `STATUS`, `NEWS_START_DATE`, `NEWS_END_DATE`, `UPDATE_DATE` FROM `nr_news` where (`LANG`='".$slang."') and `STATUS`='".$sstatus."' ORDER BY `UPDATE_DATE` limit $start_num,$read_num;";
          	}else{
          		$sstatus = $_REQUEST['sstatus'];
          		$slang=trim($_REQUEST['slang']); 
		   		$str="SELECT `ID`, `TITLE`, `LINK`, `SORT`, `LANG`, `STATUS`, `NEWS_START_DATE`, `NEWS_END_DATE`, `UPDATE_DATE` FROM `nr_news` where (`LANG`='".$slang."') ORDER BY `UPDATE_DATE` limit $start_num,$read_num;";
          	}
		   		  
		  }else{		  
			if($_REQUEST['sstatus']<>''){
          		$sstatus = $_REQUEST['sstatus'];
		   		$str="SELECT `ID`, `TITLE`, `LINK`, `SORT`, `LANG`, `STATUS`, `NEWS_START_DATE`, `NEWS_END_DATE`, `UPDATE_DATE` FROM `nr_news` where `STATUS`='".$sstatus."' ORDER BY `UPDATE_DATE` limit $start_num,$read_num;";
          	}else{
	            $str="SELECT `ID`, `TITLE`, `LINK`, `SORT`, `LANG`, `STATUS`, `NEWS_START_DATE`, `NEWS_END_DATE`, `UPDATE_DATE` FROM `nr_news` where 1 ORDER BY `UPDATE_DATE` limit $start_num,$read_num;";
          	}		  
          }

		}     
      $result=mysqli_query($link_db,$str);
      $i=0;
	  while(list($ID,$TITLE,$LINK,$SORT,$LANG,$STATUS,$NEWS_START_DATE,$NEWS_END_DATE,$UPDATE_DATE)=mysqli_fetch_row($result)){
      $i=$i+1;
      putenv("TZ=Asia/Taipei");
  ?>
  <tr>
    <td><?php if(strlen($TITLE)>=50){ echo mb_substr($TITLE,0 ,50, "utf-8")."----"; }else if(strlen($TITLE)<50){ echo $TITLE; }?></td><td><?=$LINK;?></td><td><?=$LANG;?></td><td><?php if($STATUS=='1'){ echo "Online"; }else if($STATUS=='0'){ echo "Offline"; }?></td><td ><a href="home_news.php?nwid=<?=$ID;?>&types=edit#hmnw_edit">Edit</a>&nbsp;&nbsp;<a href="?act=del&d_id=<?=$ID;?>" onclick="return confirm('Are you sure you want to delete this item?');">Del</a></td>
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
<select id="news_page" name="news_page" onChange="MM_o(this)">
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
<div id="hmnw_add" class="subsettings" style="display:none">
<form id="form1" name="form1" method="post" action="?kinds=add_hmnews" onsubmit="return Final_Check();">
<h1>Add a news:</h1>
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hiden_add()"> [close] </a></div><!--end of close-->
<table class="addspec">

<tr>
<th>Headline:  </th>
<td><input id="pr1A" name="nw1A" type="text" size="80" value="" /></td>
</tr>
<tr>
<th>Link: </th>
<td><input id="pr2A" name="nw2A" type="text" size="80" value="" /></td>
</tr>
<tr>
<th>Language:</th>
<td>
<select id="nw_langA" name="nw_langA">
<option value="" selected>Select...</option>
<option value="en-US">English</option>
<option value="zh-CN">簡體</option>
<option value="zh-TW">繁體</option>
<option value="ja-JP">日文</option>
</select><span style="color:#0F0">*必選欄位</span>
</td>
</tr>
<tr>
<th>Status/Schedule:</th>
<td>
<select id="nw_statusA" name="nw_statusA">
<option selected value="1">Online</option>
<option value="0">Offline</option>
</select>&nbsp;&nbsp;&nbsp;&nbsp;
<input id="sDate" name="sDate" type="text" size="20" value="" onfocus="HS_setDate(this)" /> to <input id="eDate" name="eDate" type="text" size="20" value="" onfocus="HS_setDate(this)" />
<P style="color:#0F0;display:none">
- 只能設定立即上線/下線 或是 上線的schedule 其中之一、選擇任何一個，另一個就失效。Default 為 online。<br>
- schedule 的設定請套 JQuery date picker<br>
<p>
</td>
</tr>
<tr><td colspan="2">
<BUTTON name="submitbutton01" id="submitbutton01" style="width:70px; margin-right:10px" type="submit" class="big_button left">Done</BUTTON><BUTTON name="submitbutton02" id="submitbutton02" style="width:86px; margin-right:10px" type="reset" class="big_button left" onclick="javascript:self.location='home_news.php'">Cancel</BUTTON>  <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
</td></tr>
</table>
</form>
<script language="JavaScript">
function Final_Check() {
if(document.form1.nw1A.value == ""){
alert("Required input a News Title！");
document.form1.nw1A.focus();
return false;
}

if(document.form1.nw2A.value == ""){
alert("Required input a LINK！");
document.form1.nw2A.focus();
return false;
}

if(document.form1.nw_langA.value == ""){
alert("Required select a language！");
document.form1.nw_langA.focus();
return false;
}

return true;
}
</script>
</div>
<?php
if(isset($_REQUEST['nwid'])!=''){
  
  $nwid=intval($_REQUEST['nwid']);
  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
  //$select=mysqli_select_db($dataBase);
  $str_m="SELECT `ID`, `TITLE`, `LINK`, `SORT`, `LANG`, `STATUS`, `NEWS_START_DATE`, `NEWS_END_DATE`, `UPDATE_DATE` FROM `nr_news` where `ID`=".$nwid;
  $mresult=mysqli_query($link_db,$str_m);
  $mdata=mysqli_fetch_row($mresult);

?>

<div id="hmnw_edit" class="subsettings" style="display:none">
<form id="form2" name="form2" method="post" action="?kinds=edit_hmnw" onsubmit="return EFinal_Check();">
<h1>Edit a News:</h1>
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hiden_edit()"> [close] </a></div><!--end of close-->
<table class="addspec">
<tr>
<th>News Title: </th>
<td><input id="nw1" name="nw1" type="text" size="80" value="<?=$mdata[1];?>" /></td>
</tr>
<tr>
<th>Link: </th>
<td><input id="nw2" name="nw2" type="text" size="80" value="<?=$mdata[2];?>" /></td>
</tr>
<tr>
<th>Language:</th>
<td>
<select id="nw_lang" name="nw_lang">
<option value="">Select...</option>
<option value="en-US" <?php if($mdata[4]=='en-US'){ echo "selected"; } ?>>English</option>
<option value="zh-CN" <?php if($mdata[4]=='zh-CN'){ echo "selected"; } ?>>簡體</option>
<option value="zh-TW" <?php if($mdata[4]=='zh-TW'){ echo "selected"; } ?>>繁體</option>
<option value="ja-JP" <?php if($mdata[4]=='ja-JP'){ echo "selected"; } ?>>日文</option>
</select><span style="color:#0F0">*必選欄位</span>
</td>
</tr>
<tr>
<th>Status/Schedule:</th>
<td>
<select id="nw_status" name="nw_status">
<option value="1" <?php if($mdata[5]=='1'){ echo "selected"; } ?>>Online</option>
<option value="0" <?php if($mdata[5]=='0'){ echo "selected"; } ?>>Offline</option>
</select>&nbsp;&nbsp;&nbsp;&nbsp;
<input id="sDateM" name="sDateM" type="text" size="20" value="<?php putenv("TZ=Asia/Taipei");echo date("Y-m-d",strtotime($mdata[6])); ?>" onfocus="HS_setDate(this)" /> to <input id="eDateM" name="eDateM" type="text" size="20" value="<?php putenv("TZ=Asia/Taipei");echo date("Y-m-d",strtotime($mdata[7])); ?>" onfocus="HS_setDate(this)" />
</td>
</tr>
<tr>
<th>Sort: </th>
<td><input id="nw3" name="nw3" type="text" size="6" value="<?=$mdata[3];?>" /></td>
</tr>
<tr><td colspan="2">
<input type="hidden" name="nwid01" value="<?=$mdata[0];?>">
<BUTTON name="submitbutton01" id="submitbutton01" style="width:70px; margin-right:10px" type="submit" class="big_button left">Done</BUTTON><BUTTON name="submitbutton02" id="submitbutton02" style="width:86px; margin-right:10px" type="reset" class="big_button left" onclick="form2.reset();">Cancel</BUTTON> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
</td></tr>
</table>
</form>
<script language="JavaScript">
function EFinal_Check( ) {
if(document.form2.nw1.value == ""){
alert("Required input a News Title！");
document.form2.nw1.focus();
return false;
}

if(document.form2.nw2.value == ""){
alert("Required input a Link！");
document.form2.nw2.focus();
return false;
}
/*
if(document.form2.nw3.value == ""){
alert("Required input a sort！");
document.form2.nw3.focus();
return false;
}
*/
if(document.form2.nw_lang.value == ""){
alert("Required select a language！");
document.form2.nw_lang.focus();
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
</body>
</html>
<?php
if(isset($_REQUEST['nwid'])!=''){
echo "<script>show_edit();</script>\n";
exit();
}
?>