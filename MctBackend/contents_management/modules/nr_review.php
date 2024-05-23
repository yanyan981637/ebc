<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

require "../../config.php";
include_once('../../page.class.php');

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

if(isset($_REQUEST['act'])!=''){
if(trim($_REQUEST['act'])=='del'){
  $d_id01=intval($_REQUEST['d_id']);
  $d_type01=$_REQUEST['d_type'];
  if($d_id01!='' && $d_type01!=''){
      
	  if($d_type01=='Press Review'){
	  $str_del="delete from `sp_pressreview` where `ID`=".$d_id01;
	  }
	  $del_cmd=mysqli_query($link_db,$str_del);
	  echo "<script>alert('Delete The Data!');self.location='nr_review.php'</script>";
	  exit();
  }
}
}

if(isset($_REQUEST['kinds'])!=''){
$dl_type01="";$dl_Date01="";$dl_media01="";$dl_name01="";$dl_summa01="";$dl_loc01="";$relProd_val="";$pa_lang01="";$status01="";$m_id01="";
$dlA_type01="";$dlA_Date01="";$dlA_media01="";$dlA_name01="";$dlA_summa01="";$dlA_loc01="";$relProd_val="";$pa_langA01="";$statusA01="";

if($_REQUEST['kinds']=="edit_pressreview"){
if(isset($_POST['m_id'])!=''){
$m_id01=intval($_POST['m_id']);
}
if(isset($_POST['dl_type'])!=''){
$dl_type01=trim($_POST['dl_type']);
}else{
$dl_type01="";
}
if(isset($_POST['dl_Date'])!=''){
$dl_Date01=trim($_POST['dl_Date']);
}else{
$dl_Date01="";
}
if(isset($_POST['dl_media'])!=''){
$dl_media01=trim($_POST['dl_media']);
}else{
$dl_media01="";
}
if(isset($_POST['dl_name'])!=''){
	$dl_name01=trim(str_replace("'","&#39;",$_POST['dl_name']));
//$dl_name01=trim($_POST['dl_name']);
}else{
$dl_name01="";
}
if(isset($_POST['dl_summa'])!=''){
	$dl_summa01=trim(str_replace("'","&#39;",$_POST['dl_summa']));
//$dl_summa01=trim($_POST['dl_summa']);
}else{
$dl_summa01="";
}
if(isset($_POST['dl_loc'])!=''){
$dl_loc01=trim($_POST['dl_loc']);
}else{
$dl_loc01="";
}
if(isset($_POST['relProd_valM'])!=''){
$relProd_val=trim($_POST['relProd_valM']);
}else{
$relProd_val="";
}
if(isset($_POST['pa_lang'])!=''){
$pa_lang01=trim($_POST['pa_lang']);
}else{
$pa_lang01="";
}
if(isset($_POST['status'])!=''){
$status01=trim($_POST['status']);
}else{
$status01="";
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");
   
   if(isset($_FILES['MyFileM']['name'])!=''){
		$MyFileM=trim($_FILES['MyFileM']['name']);
	}else{
		$MyFileM="";
	}

if($dl_type01=="17"){
	if($MyFileM!="none" && $MyFileM!=""){ 
		$UploadPath = "../../../images/pic/press_review/";
		$flag = copy($_FILES['MyFileM']['tmp_name'], $UploadPath.$_FILES['MyFileM']['name']); 
	    $str_upd="UPDATE `sp_pressreview` set `FILENAME`='".$dl_name01."', `FILEDATE`='".$dl_Date01."', `PATH`='".$dl_loc01."', `LANG`='".$pa_lang01."', `MODEL`='".$relProd_val."', `UPDATE_DATE`='".$now."', `STATUS`='".$status01."', `media`='".$dl_media01."',`summary`='".$dl_summa01."',`pr_img`='./images/pic/press_review/".$MyFileM."' where `ID`=".$m_id01;
	}else{
		$str_upd="UPDATE `sp_pressreview` set `FILENAME`='".$dl_name01."', `FILEDATE`='".$dl_Date01."', `PATH`='".$dl_loc01."', `LANG`='".$pa_lang01."', `MODEL`='".$relProd_val."', `UPDATE_DATE`='".$now."', `STATUS`='".$status01."', `media`='".$dl_media01."',`summary`='".$dl_summa01."' where `ID`=".$m_id01;
	}
}
$upd_cmd=mysqli_query($link_db,$str_upd);
echo "<script>alert('Update The Data !');location.href='nr_review.php'</script>";
exit();
}

if(trim($_REQUEST['kinds'])=="add_pressreview"){
if(isset($_POST['dlA_type'])!=''){
$dlA_type01=trim($_POST['dlA_type']);
}else{
$dlA_type01="";	
}
if(isset($_POST['dlA_Date'])!=''){
$dlA_Date01=trim($_POST['dlA_Date']);
}else{
$dlA_Date01="";
}
if(isset($_POST['dlA_media'])!=''){
$dlA_media01=trim($_POST['dlA_media']);
}else{
$dlA_media01="";
}
if(isset($_POST['dlA_name'])!=''){
	$dlA_name01=trim(str_replace("'","&#39;",$_POST['dlA_name']));
//$dlA_name01=trim($_POST['dlA_name']);

}else{
$dlA_name01="";
}

if(isset($_POST['dlA_summa'])!=''){
	$dlA_summa01=trim(str_replace("'","&#39;",$_POST['dlA_summa']));
//$dlA_summa01=trim($_POST['dlA_summa']);
}else{
$dlA_summa01="";
}
if(isset($_POST['dlA_loc'])!=''){
$dlA_loc01=trim($_POST['dlA_loc']);
}else{
$dlA_loc01="";
}
if(isset($_POST['relProd_val'])!=''){
$relProd_val=trim($_POST['relProd_val']);
}else{
$relProd_val="";
}
if(isset($_POST['pa_langA'])!=''){
$pa_langA01=trim($_POST['pa_langA']);
}else{
$pa_langA01="";
}
if(isset($_POST['statusA'])!=''){
$statusA01=trim($_POST['statusA']);
}else{
$statusA01="";
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

    $str_Pressvalues="select `ID` FROM `sp_pressreview` order by `ID` desc limit 1";
    $check_Pressvalues=mysqli_query($link_db,$str_Pressvalues);
    $Max_CValID=mysqli_fetch_row($check_Pressvalues);
    $MCount=$Max_CValID[0]+1;
	
	if(isset($_FILES['MyFile']['name'])!=''){
		$MyFile=trim($_FILES['MyFile']['name']);
	}else{
		$MyFile="";
	}
	
	$UploadPath = "../../../images/pic/press_review/";
	/*
	if(file_exists($UploadPath)) {
    @chmod($UploadPath,0755);
    echo "file is existed!";
	}
	*/
	if($MyFile!="none" && $MyFile!=""){ 
		$flag = copy($_FILES['MyFile']['tmp_name'], $UploadPath.$_FILES['MyFile']['name']);  
		$str_inst="INSERT INTO `sp_pressreview`(`ID`, `FILENAME`, `FILEDATE`, `PATH`, `LANG`, `MODEL`, `STATUS`, `media`, `summary`, `pr_img`, `UPDATE_DATE`) VALUES (".$MCount.",'".$dlA_name01."','".$dlA_Date01."','".$dlA_loc01."','$pa_langA01','".$relProd_val."','".$statusA01."','".$dlA_media01."','".$dlA_summa01."','./images/pic/press_review/".$MyFile."','".$now."')";
	}else{
		$str_inst="INSERT INTO `sp_pressreview`(`ID`, `FILENAME`, `FILEDATE`, `PATH`, `LANG`, `MODEL`, `STATUS`, `media`, `summary`, `UPDATE_DATE`) VALUES (".$MCount.",'".$dlA_name01."','".$dlA_Date01."','".$dlA_loc01."','$pa_langA01','".$relProd_val."','".$statusA01."','".$dlA_media01."','".$dlA_summa01."','".$now."')";
	}
$inst_cmd=mysqli_query($link_db,$str_inst);
echo "<script>alert('AddNew The Data!');location.href='nr_review.php'</script>";
exit();
}
}
 $slang="";
 if(isset($_REQUEST['s_search'])<>''){
  $s_search=preg_replace("/['\"\$ \r\n\t;<>\*%\?]/i", '', $_REQUEST['s_search']);
		
	if(isset($_REQUEST['slang'])!=''){
	 $slang=trim($_REQUEST['slang']);
	 if($s_search!='' && $slang!=''){
	  $str1="select count(*) from `sp_pressreview` where (FILENAME like '%".$s_search."%' or media like '%".$s_search."%' or summary like '%".$s_search."%') and (`LANG`='".$slang."')";
	 }else if($s_search!='' && $slang==''){
	  $str1="select count(*) from `sp_pressreview` where (FILENAME like '%".$s_search."%' or media like '%".$s_search."%' or summary like '%".$s_search."%')";
	 }else if($s_search=='' && $slang!=''){
	  $str1="select count(*) from `sp_pressreview` where (`LANG`='".$slang."')";	
	 }else{
	  $str1="select count(*) from `sp_pressreview`";
	 }
	}else{
	 if($s_search!=''){
	  $str1="select count(*) from `sp_pressreview` where (FILENAME like '%".$s_search."%' or media like '%".$s_search."%' or summary like '%".$s_search."%')";
	 }else{
	  $str1="select count(*) from `sp_pressreview`";
	 }
	}
	
  }else{

	if(isset($_REQUEST['slang'])!=''){
	 $slang=trim($_REQUEST['slang']);
	 if($slang!=''){
	  $str1="select count(*) from `sp_pressreview` where (`LANG`='".$slang."')";
	 }else{
	  $str1="select count(*) from `sp_pressreview`";
	 }
	}else{
	  $str1="select count(*) from `sp_pressreview`";
	}

  }
  $list1 =mysqli_query($link_db,$str1);
  list($public_count) = mysqli_fetch_row($list1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Website Contents Management - Products Management - Contents: Modules - Press Review</title>
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
	function MM_SL(selObj){
	   window.open(document.getElementById('SEL_SLang').options[document.getElementById('SEL_SLang').selectedIndex].value,"_self");
	}
	
	function MM_o(selObj){
       window.open(document.getElementById('preview_page').options[document.getElementById('preview_page').selectedIndex].value,"_self");
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
     //alert(keyCodeEntered);
       //if(confirm('Are you sure you want to search this word?')) {
	   document.location.href = document.getElementById('SEL_SLang').value + "&s_search=" + document.getElementById('sear_txt').value;	   
	   //}   
     }
    }	
	
	function show_add(){
	  $("#preivew_add").show();
	  $("#preivew_edit").hide();
	}
	function hide_add(){
	  self.location='nr_review.php';
	}
	function show_edit(){
	  $("#preivew_add").hide();
	  $("#preivew_edit").show();
	}
	function hide_edit(){
	  self.location='nr_review.php';
	}
	</script>
</head>

<body>
<a name="top"></a>
<div >
<div class="left"><h1>&nbsp;&nbsp;Website Backends - Website Contents Management - Contents: (Newsroom) Press Review</h1></div>
<div id="logout">Hi <?=str_replace("@mic.com.tw", "", $_SESSION['user']);?> <a href="../logo.php">Log out &gt;&gt;</a></div>
</div>
<div class="clear"></div>
<?php
include("menus.php");
?>
<div class="clear"></div>
<div id="Search" >
<h2>Contents &nbsp;&gt;&nbsp;  <a href="../modules.php">Modules</a>  &nbsp;&gt;&nbsp; (Newsroom) Press Review</h2> 
</div>
<div id="content">
<br />
<div class="right">| &nbsp;<a href="nr_events.php" />Events</a>&nbsp; | &nbsp;<a href="nr_awards.php" />Awards</a>&nbsp; | &nbsp;<a href="nr_pr.php" />Press Release</a>&nbsp; | &nbsp;</div>
<br />
<h3>Press Review List:
</h3>
<div class="pagination left">
<p>
<form id="form3" name="form3" method="post" action="nr_review.php" onsubmit="return false;">
<select id="SEL_SLang" name="SEL_SLang" onChange="MM_SL(this)">
<option value="?slang=">All</option>
<option value="?slang=en-US" <?php if($slang=='en-US'){ echo "selected";} ?>>English</option>
<option value="?slang=zh-CN" <?php if($slang=='zh-CN'){ echo "selected";} ?>>簡體</option>
<option value="?slang=zh-TW" <?php if($slang=='zh-TW'){ echo "selected";} ?>>繁體</option>
<option value="?slang=ja-JP" <?php if($slang=='ja-JP'){ echo "selected";} ?>>日文</option>
</select>&nbsp;&nbsp;&nbsp;&nbsp;<input id="sear_txt" name="sear_txt" type="text" size="30" value="" onkeydown="doEnter(event);" /> <input type="button" value="Search" onclick="search_value();" /></form>  
<span style="color:#0F0">**Key word search: FILE NAME & Products欄位 </span> 
</p>
<div class="pagination left">Total: <span class="w14bblue"><?=$public_count;?></span> records </div>
</div>

<table class="list_table">
  <tr>
    <th >*Review Date</th><th>Media</th><th>Title</th><th>Reviewed Products</th><th>Language</th><th>*Status</th><th><div class="button14" style="width:50px;"><a href="#preivew_add" STYLE="text-decoration:none" onClick="show_add();">Add</a></div></th>
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
      
        if(isset($_REQUEST['s_search'])!=''){
		$s_search=preg_replace("/['\"\$ \r\n\t;<>\*%\?]/i", '', trim($_REQUEST['s_search']));
        
		  if(isset($_REQUEST['slang'])!=''){
			  
		    $slang=trim($_REQUEST['slang']);
		    if($s_search!='' && $slang!=''){
			  $str="select ID, FILENAME, 'Press Review' as DL_Type, FILEDATE, LANG, MODEL, STATUS, UPDATE_DATE, media from sp_pressreview where (FILENAME like '%".$s_search."%' or media like '%".$s_search."%' or summary like '%".$s_search."%') and (`LANG`='".$slang."') ORDER BY UPDATE_DATE desc limit $start_num,$read_num;";
		    }else if($s_search!='' && $slang==''){
			  $str="select ID, FILENAME, 'Press Review' as DL_Type, FILEDATE, LANG, MODEL, STATUS, UPDATE_DATE, media from sp_pressreview where (FILENAME like '%".$s_search."%' or media like '%".$s_search."%' or summary like '%".$s_search."%') ORDER BY UPDATE_DATE desc limit $start_num,$read_num;";
			}else if($s_search=='' && $slang!=''){
			  $str="select ID, FILENAME, 'Press Review' as DL_Type, FILEDATE, LANG, MODEL, STATUS, UPDATE_DATE, media from sp_pressreview where (`LANG`='".$slang."') ORDER BY UPDATE_DATE desc limit $start_num,$read_num;";	
			}else{
			  $str="select ID, FILENAME, 'Press Review' as DL_Type, FILEDATE, LANG, MODEL, STATUS, UPDATE_DATE, media from sp_pressreview ORDER BY UPDATE_DATE desc limit $start_num,$read_num;";
			}
			
		  }else{
			if($s_search!=''){
			$str="select ID, FILENAME, 'Press Review' as DL_Type, FILEDATE, LANG, MODEL, STATUS, UPDATE_DATE, media from sp_pressreview where (FILENAME like '%".$s_search."%' or media like '%".$s_search."%' or summary like '%".$s_search."%') ORDER BY UPDATE_DATE desc limit $start_num,$read_num;";
			}else{
			$str="select ID, FILENAME, 'Press Review' as DL_Type, FILEDATE, LANG, MODEL, STATUS, UPDATE_DATE, media from sp_pressreview ORDER BY UPDATE_DATE desc limit $start_num,$read_num;";
			}
		  }
		  
		}else{
		  
		  if(isset($_REQUEST['slang'])!=''){
		  $slang=trim($_REQUEST['slang']);
		   if($slang!=''){
		   $str="select ID, FILENAME, 'Press Review' as DL_Type, FILEDATE, LANG, MODEL, STATUS, UPDATE_DATE, media from sp_pressreview where (`LANG`='".$slang."') ORDER BY UPDATE_DATE desc limit $start_num,$read_num;";
		   }else{
		   $str="select ID, FILENAME, 'Press Review' as DL_Type, FILEDATE, LANG, MODEL, STATUS, UPDATE_DATE, media from sp_pressreview ORDER BY UPDATE_DATE desc limit $start_num,$read_num;";
		   }
		  }else{
		   $str="select ID, FILENAME, 'Press Review' as DL_Type, FILEDATE, LANG, MODEL, STATUS, UPDATE_DATE, media from sp_pressreview ORDER BY UPDATE_DATE desc limit $start_num,$read_num;";
		  }
		  
		}       
      $result=mysqli_query($link_db,$str);
	  $i=0;
      while(list($ID,$FILENAME,$DL_Type,$FILEDATE,$LANG,$MODEL,$STATUS,$UPDATE_DATE,$media)=mysqli_fetch_row($result)){
      $i=$i+1;
      putenv("TZ=Asia/Taipei");
  ?>
  <tr>
    <td>
	<?php if($FILEDATE!='' && $FILEDATE!='0000-00-00 00:00:00'){ echo date("Y/m/d",strtotime($FILEDATE)); }?></td>
	<td><?=$media;?></td>
	<td><?=$FILENAME;?></td>
	<td><?=$MODEL;?></td><td><?=$LANG;?></td><td><?php if($STATUS==1){ echo "Online"; }else if($STATUS==0){ echo "Offline"; } ?></td><td ><a id="dw_edit" href="?mid=<?=$ID;?>&d_type=<?=$DL_Type;?> #preivew_edit">Edit</a>&nbsp;&nbsp;<a href="?act=del&d_id=<?=$ID;?>&d_type=<?=$DL_Type;?>" onclick="return confirm('Are you sure you want to delete this item?');">Del</a></td>
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
<select id="preview_page" name="preview_page" onChange="MM_o(this)">
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
<div id="preivew_add" class="subsettings" style="display:none">
<form id="form1" name="form1" method="post" enctype="multipart/form-data" action="?kinds=add_pressreview" onsubmit="return Final_Check();">							
<h1>Add a press review</h1>
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hide_add()"> [close] </a></div><!--end of close-->
<table class="addspec">
<tr>
<th>press review:  </th>
<td>
<select id="dlA_type" name="dlA_type">
<?php
$str_dltpA="SELECT `ID`, `NAME` FROM `c_sp_itemlist` where `ID`=17";
$dltpA_result=mysqli_query($link_db,$str_dltpA);
while($dltpA_data=mysqli_fetch_row($dltpA_result)){
?>
<option value="<?=$dltpA_data[0];?>"><?=$dltpA_data[1];?></option>
<?php
}
?>
</select>
</td>
</tr>
<tr>
<th>Review Date:  </th>
<td><input id="dlA_Date" name="dlA_Date" type="text" size="8" value="" onfocus="HS_setDate(this)" /></td>
</tr>
<tr>
<th>Media:  </th>
<td><input id="dlA_media" name="dlA_media" type="text" size="80" value="" /></td>
</tr>
<tr>
<th>Title:  </th>
<td><input id="dlA_name" name="dlA_name" type="text" size="80" value="" /></td>
</tr>
<tr>
<th>Summary: </th>
<td><input id="dlA_summa" name="dlA_summa" type="text" size="80" value=""  />
</td>
</tr>
<tr>
<th>URL: </th>
<td><input id="dlA_loc" name="dlA_loc" type="text" size="40" value="" /></td>
</tr>
<tr>
<th>Image: </th>
<td><input type="file" name="MyFile" size="20"></td>
</tr>
<tr>
<th>Review Products:</th>
<td><div class="button14" style="width:60px;" ><a class="fancybox fancybox.iframe" href="../lb_preview_mo.php" style="color:#ffffff">Edit</a></div>
 <!--列出被勾選的Products-->
 <textarea id="relProd_val" name="relProd_val" rows="5" cols="80" style="border: none;max-width: 800px; max-height: 200px;" readonly></textarea>
 <p><span id="relProd"></span></p></td>
</tr>
<tr>
<th>Language:</th>
<td>
<select id="pa_langA" name="pa_langA">
<option value="" selected>Select...</option>
<option value="en-US">English</option>
<option value="zh-CN">簡體</option>
<option value="zh-TW">繁體</option>
<option value="ja-JP">日文</option>
</select></td>
</tr>
<tr>
<th>Status:</th>
<td><select id="statusA" name="statusA"><option value="1" selected>Online</option><option value="0">Offline</option></select>
</td>
</tr>
<tr><td colspan="2">
<input name="B2" class="button14" style="width:60px;" type="submit" value="Done" />&nbsp;&nbsp;<input name="C2" class="button14" style="width:60px;" type="button" value="Cancel" onclick="javascript:location.href='nr_review.php'" /> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
</td></tr>
</table>
</form>
<script language="JavaScript">
function Final_Check(){
	var dl_num=document.getElementById('dlA_type').value;

	  if(document.form1.dlA_type.value == ""){
	  alert("Required select a Download Type！");
	  document.form1.dlA_type.focus();
	  return false;
	  }  
	  if(document.form1.dlA_media.value == ""){
	  alert("Required input a Media！");
	  document.form1.dlA_media.focus();
	  return false;
	  }
	  if(document.form1.dlA_name.value == ""){
	  alert("Required input a Title！");
	  document.form1.dlA_name.focus();
	  return false;
	  }
	  if(document.form1.dlA_Date.value == ""){
	  alert("Required input a Review Date！");
	  document.form1.dlA_Date.focus();
	  return false;
	  }

	return true;
}
</script>
</div>
<p class="clear">&nbsp;</p>
</div>
<?php
if(isset($_REQUEST['mid'])!='' && isset($_REQUEST['d_type'])!=''){
$mid=intval($_REQUEST['mid']);
$d_type01=trim($_REQUEST['d_type']);

  if(trim($d_type01)=="Press Review"){
  $str_m="SELECT `ID`, `FILENAME`, `FILEDATE`, `PATH`, `LANG`, `MODEL`, `STATUS`, `media`, `summary`, `pr_img` FROM `sp_pressreview` where `ID`=".$mid;
  $m_result=mysqli_query($link_db,$str_m);
  $m_data=mysqli_fetch_row($m_result);
  $id01=$m_data[0];
  $filename01=$m_data[1];
  $filedata01=$m_data[2];
  $path01=$m_data[3];
  $lang01=$m_data[4];
  $model01=$m_data[5];  
  $status01=$m_data[6];
  $media01=$m_data[7];
  $summary01=$m_data[8];
  }
?>
<div id="preivew_edit" class="subsettings" style="display:none">
<form id="form2" name="form2" method="post" enctype="multipart/form-data" action="?kinds=edit_pressreview" onsubmit="return Final_MCheck();">
<input type="hidden" name="m_id" value="<?=$id01;?>">
<h1>Edit a press review</h1>
<div class="right"><a href="#" onclick="hide_edit()"> [close] </a></div>
<table class="addspec">
<tr>
<th>press review:  </th>
<td>
<select id="dl_type" name="dl_type" onChange="MM_PTM(this)">
<option value="" >--Select--</option>
<?php
$str_dltp="SELECT `ID`, `NAME` FROM `c_sp_itemlist` where `ID` =17 and `NAME`='".trim($d_type01)."'";
$dltp_result=mysqli_query($link_db,$str_dltp);
$dltp_data=mysqli_fetch_row($dltp_result);
?>
<option value="<?=$dltp_data[0];?>" selected><?=$dltp_data[1];?></option>
</select>
</td>
</tr>

<tr>
<th>Review Date:  </th>
<td><input id="dl_Date" name="dl_Date" type="text" size="8" value="<?=$filedata01;?>" onfocus="HS_setDate(this)" /></td>
</tr>
<tr>
<th>Media:  </th>
<td><input id="dl_media" name="dl_media" type="text" size="80" value="<?=$media01;?>" /></td>
</tr>
<tr>
<th>Title:  </th>
<td><input id="dl_name" name="dl_name" type="text" size="80" value="<?=$filename01;?>" /></td>
</tr>
<tr>
<th>Summary: </th>
<td><input id="dl_suma" name="dl_summa" type="text" size="80" value="<?=$summary01;?>"  />
</td>
</tr>
<tr>
<th>URL: </th>
<td><input id="dl_loc" name="dl_loc" type="text" size="50" value="<?=$path01;?>" /></td>
</tr>
<tr>
<th>Image: </th>
<td><input type="file" name="MyFileM" size="20"></td>
</tr>
<tr>
<th>Review Products:</th>
<td><div class="button14" style="width:60px;" ><a class="fancybox fancybox.iframe" href="../elb_preview_mo.php?cid=<?=$id01;?>&d_type=<?=$d_type01;?>" style="color:#ffffff">Edit</a></div>
 <!--列出被勾選的Products-->
 <textarea id="relProd_valM" name="relProd_valM" rows="5" cols="80" style="border: none;max-width: 800px; max-height: 200px;" readonly><?=$model01;?></textarea>
 <p><span id="relProd"></span></p></td>
</tr>
<tr>
<th>Language:</th>
<td>
<select id="pa_lang" name="pa_lang">
<option value="" selected>Select...</option>
<option value="en-US" <?php if($lang01=="en-US"){ echo "selected"; } ?>>English</option>
<option value="zh-CN" <?php if($lang01=="zh-CN"){ echo "selected"; } ?>>簡體</option>
<option value="zh-TW" <?php if($lang01=="zh-TW"){ echo "selected"; } ?>>繁體</option>
<option value="ja-JP" <?php if($lang01=="ja-JP"){ echo "selected"; } ?>>日文</option>
</select></td>
</tr>
<tr>
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
	  if(document.form2.dl_type.value == ""){
	  alert("Required select a Download Type！");
	  document.form2.dl_type.focus();
	  return false;
	  }
	  if(document.form2.dl_media.value == ""){
	  alert("Required input a Media！");
	  document.form2.dl_media.focus();
	  return false;
	  }
	  if(document.form2.dl_name.value == ""){
	  alert("Required input a Title！");
	  document.form2.dl_name.focus();
	  return false;
	  }
	  if(document.form2.dl_Date.value == ""){
	  alert("Required input a Review Date！");
	  document.form2.dl_Date.focus();
	  return false;
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