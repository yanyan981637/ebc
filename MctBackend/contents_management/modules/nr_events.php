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

if(isset($_REQUEST['act'])!='' || isset($_REQUEST['d_id'])!=''){  
  if(trim($_REQUEST['act'])=='del'){
  $d_id01=intval($_REQUEST['d_id']);
  $str_del="delete from `nr_events` where `ID`=".$d_id01;
  $del_cmd=mysqli_query($link_db,$str_del);  
  echo "<script>alert('Delete the Data !');self.location='nr_events.php'</script>";
  exit();
  }
}

if(isset($_REQUEST['kinds'])!=''){
if(trim($_REQUEST['kinds'])=='add_nrevts'){

if(isset($_POST['pe1A'])!=''){
$pe1A=trim($_POST['pe1A']);
}else{
$pe1A="";
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
if(isset($_POST['pe2A'])!=''){
$pe2A=trim($_POST['pe2A']);
}else{
$pe2A="";
}
if(isset($_POST['sDate'])!=''){
$sDate=trim($_POST['sDate']);
}else{
$sDate="";
}
if(isset($_POST['eDate'])!=''){
$eDate=trim($_POST['eDate']);
}else{
$eDate="";
}
if(isset($_POST['pe3A'])!=''){
$pe3A=trim($_POST['pe3A']);
}else{
$pe3A="";
}
if(isset($_POST['pe_langA'])!=''){
$pe_langA=trim($_POST['pe_langA']);
}else{
$pe_langA="";
}
if(isset($_POST['pe_statusA'])!=''){
$pe_statusA=trim($_POST['pe_statusA']);
}else{
$pe_statusA="";
}

   if(($myFileA != "none" && $myFileA != ""))
   {
     $UploadPath = "../../../images/events/";
     $flag = copy($_FILES['myFileA']['tmp_name'], $UploadPath.$_FILES['myFileA']['name']);
     if($flag) echo ""; 
     $urlA="/images/events/"; 
   }else{   
     $urlA=""; 
   }

$str_n="SELECT `ID` from `nr_events` order by `ID` desc limit 1";
$check_cmd=mysqli_query($link_db,$str_n);
$MCount_record=mysqli_fetch_row($check_cmd);
$SCount=$MCount_record[0]+1;

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

$str_inst="INSERT INTO `nr_events`(`ID`, `TITLE`, `CONTENT`, `WHEREIS`, `IMG`, `STARTDATE`, `ENDDATE`, `LINK`, `LANG`, `STATUS`, `MAINITEM`, `UPDATE_DATE`) VALUES (".$SCount.",'".$pe1A."','".$editor1."','".$pe2A."','$urlA$myFileA','".$sDate."','".$eDate."','".$pe3A."','".$pe_langA."','".$pe_statusA."','1', '".$now."')";
$inst_cmd=mysqli_query($link_db,$str_inst);
echo "<script>alert('AddNew a Events Data !');self.location='nr_events.php'</script>";
exit();
}

if(trim($_REQUEST['kinds'])=='edit_nrevts'){

if(isset($_POST['peid01'])!=''){
$peid01=intval($_POST['peid01']);
}else{
$peid01="";
}
if(isset($_POST['pe1'])!=''){
$pe1=trim($_POST['pe1']);
}else{
$pe1="";
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
if(isset($_POST['pe2'])!=''){
$pe2=trim($_POST['pe2']);
}else{
$pe2="";
}
if(isset($_POST['sDateM'])!=''){
$sDateM=trim($_POST['sDateM']);
}else{
$sDateM="";
}
if(isset($_POST['eDateM'])!=''){
$eDateM=trim($_POST['eDateM']);
}else{
$eDateM="";
}
if(isset($_POST['pe3'])!=''){
$pe3=trim($_POST['pe3']);
}else{
$pe3="";
}
if(isset($_POST['pe_lang'])!=''){
$pe_lang=trim($_POST['pe_lang']);
}else{
$pe_lang="";
}
if(isset($_POST['pe_status'])!=''){
$pe_status=trim($_POST['pe_status']);
}else{
$pe_status="";
}

   if(($myFile != "none" && $myFile != ""))
   {
     $UploadPath = "../../../images/events/";
     $flag = copy($_FILES['myFile']['tmp_name'], $UploadPath.$_FILES['myFile']['name']);
     if($flag) echo ""; 
     $url="/images/events/";   
   }else{   
     $url="";   
   }
putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

if($myFile != ""){
$str_upd="UPDATE `nr_events` SET `TITLE`='".$pe1."',`CONTENT`='".$editor2."',`WHEREIS`='".$pe2."',`IMG`='$url$myFile',`STARTDATE`='".$sDateM."',`ENDDATE`='".$eDateM."',`LINK`='".$pe3."',`LANG`='".$pe_lang."',`UPDATE_USER`='admin',`UPDATE_DATE`='".$now."',`STATUS`='".$pe_status."' WHERE `ID`=".$peid01;
}else{
$str_upd="UPDATE `nr_events` SET `TITLE`='".$pe1."',`CONTENT`='".$editor2."',`WHEREIS`='".$pe2."',`STARTDATE`='".$sDateM."',`ENDDATE`='".$eDateM."',`LINK`='".$pe3."',`LANG`='".$pe_lang."',`UPDATE_USER`='admin',`UPDATE_DATE`='".$now."',`STATUS`='".$pe_status."' WHERE `ID`=".$peid01;
}
$upd_cmd=mysqli_query($link_db,$str_upd);
echo "<script>alert('Update a Events Data !');self.location='nr_events.php'</script>\n";
exit();
}
}

  $slang="";
  if(isset($_REQUEST['s_search'])<>''){
  $s_search=trim($_REQUEST['s_search']);
  //$s_search=preg_replace("['\"\$ \r\n\t;<>\*%\?]", '', $_REQUEST['s_search']);
    if(isset($_REQUEST['slang'])<>''){
     $slang=trim($_REQUEST['slang']);	
     $str1="select count(*) from `nr_events` where (`TITLE` like '%".$s_search."%' or `CONTENT` like '%".$s_search."%' or `WHEREIS` like '%".$s_search."%') and (`LANG`='".$slang."')";
    }else{
	 $str1="select count(*) from `nr_events` where (`TITLE` like '%".$s_search."%' or `CONTENT` like '%".$s_search."%' or `WHEREIS` like '%".$s_search."%')";
	}
  }else{
    
	if(isset($_REQUEST['slang'])<>''){		  
     $slang=trim($_REQUEST['slang']);		  
     $str1="SELECT count(*) from `nr_events` where (`LANG`='".$slang."')";		   
	}else{	 
	 $str1="select count(*) from `nr_events`";
	}
	
  }
  $list1 =mysqli_query($link_db,$str1);
  list($public_count) = mysqli_fetch_row($list1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Website Contents Management - Products Management - Contents: Modules - (Newsroom) Events</title>
<link rel="stylesheet" type="text/css" href="../../backend.css">
<link rel="stylesheet" type="text/css" href="../../css/css.css" />
<script type="text/javascript" src="../../jquery.min.js"></script>
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
	 slang = document.getElementById('SEL_SLang').value;
     self.location = slang + "&s_search=" + document.getElementById('sear_txt').value;
     //alert(slang + "&s_search=" + document.getElementById('sear_txt').value);
	 return false;
    }
	
	function doEnter(event){
    var keyCodeEntered = (event.which) ? event.which : window.event.keyCode;
     if (keyCodeEntered == 13){	   
	   //if(confirm('Are you sure you want to search this word?')) {
	   document.location.href = document.getElementById('SEL_SLang').value + "&s_search=" + document.getElementById('sear_txt').value;	   
	   //}	   
	 //alert(keyCodeEntered);
	 return false;
     }	
    }
	
	function show_add(){
	 $('#nrevts_add').show();
	 $('#nrevts_edit').hide();
	}
	
	function hiden_add(){
	 self.location='nr_events.php';
	}
	
	function show_edit(){
	 $('#nrevts_edit').show();
	 $('#nrevts_add').hide();
	}
	
	function hiden_edit(){
	 self.location='nr_events.php';
	}
</script>

</head>

<body>
<a name="top"></a>
<div >
<div class="left"><h1>&nbsp;&nbsp;Website Backends - Website Contents Management - Contents: (Newsroom) Events</h1></div>
<div id="logout">Hi <?=str_replace("@mic.com.tw", "", $_SESSION['user']);?> <a href="../logo.php">Log out &gt;&gt;</a></div>
</div>

<div class="clear"></div>
<?php
include("menus.php");
?>
<div class="clear"></div>
<div id="Search" >
<h2>Contents &nbsp;&gt;&nbsp;  <a href="../modules.php">Modules</a>  &nbsp;&gt;&nbsp; (Newsroom) Events</h2> 
</div>
<div id="content">
<br />
<div class="right">| &nbsp;<a href="nr_pr.php" />Press Release</a>&nbsp; | &nbsp;<a href="nr_awards.php" />Awards</a>&nbsp; | &nbsp;<a href="nr_review.php" />Press Review</a>&nbsp; | &nbsp;</div>
<br />
<div id="c01" style="display:'none'"></div>
<h3>Events Lists:
</h3>
<div class="pagination left">
<p>
<form id="form3" name="form3" method="post" action="nr_events.php" onsubmit="return false;">
<select id="SEL_SLang" name="SEL_SLang" onChange="MM_SL(this)">
<option value="nr_events.php?slang=">All</option>
<option value="nr_events.php?slang=en-US" <?php if($slang=='en-US'){ echo "selected";} ?>>English</option>
<option value="nr_events.php?slang=zh-CN" <?php if($slang=='zh-CN'){ echo "selected";} ?>>簡體</option>
<option value="nr_events.php?slang=zh-TW" <?php if($slang=='zh-TW'){ echo "selected";} ?>>繁體</option>
<option value="nr_events.php?slang=ja-JP" <?php if($slang=='ja-JP'){ echo "selected";} ?>>日文</option>
</select> <input id="sear_txt" name="sear_txt" type="text" size="20" value="" onkeydown="doEnter(event);" /> <input id="btn" name="btn" type="button" value="Search" onclick="search_value();" />
</form> <span style="color:#0F0">**Key word search: "Event Title"  & "Contents"  欄位 </span> 
</p>
<div class="pagination left">Total: <span class="w14bblue"><?=$public_count;?></span> records </div>
</div>
<table class="list_table">
  <tr>
    <th >*Timeline</th><th  >Event Title</th><th>Contents</th><th>Language</th><th  >*Status</th><th><div class="button14" style="width:50px;"><a href="#nrevts_add" STYLE="text-decoration:none" onClick="show_add();">Add</a></div></th>
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
      
        if(isset($_REQUEST['s_search'])<>''){
		//$s_search=preg_replace("['\"\$ \r\n\t;<>\*%\?]", '', $_REQUEST['s_search']);
        
		  if(isset($_REQUEST['slang'])<>''){
		  $slang=trim($_REQUEST['slang']);
		  $str="SELECT `ID`, `TITLE`, `CONTENT`, `WHEREIS`, `IMG`, `STARTDATE`, `ENDDATE`, `LINK`, `LANG`, `UPDATE_USER`, `UPDATE_DATE`, `STATUS` FROM `nr_events` where (`TITLE` like '%".$s_search."%' or `CONTENT` like '%".$s_search."%' or `WHEREIS` like '%".$s_search."%') and (LANG='".$slang."') ORDER BY `ID` DESC limit $start_num,$read_num;";
		  }else{
		  $str="SELECT `ID`, `TITLE`, `CONTENT`, `WHEREIS`, `IMG`, `STARTDATE`, `ENDDATE`, `LINK`, `LANG`, `UPDATE_USER`, `UPDATE_DATE`, `STATUS` FROM `nr_events` where (`TITLE` like '%".$s_search."%' or `CONTENT` like '%".$s_search."%' or `WHEREIS` like '%".$s_search."%') ORDER BY `ID` DESC limit $start_num,$read_num;";
          }
		  
		}else{		  
		  if(isset($_REQUEST['slang'])<>''){		  
		   $slang=trim($_REQUEST['slang']);   
		   $str="SELECT `ID`, `TITLE`, `CONTENT`, `WHEREIS`, `IMG`, `STARTDATE`, `ENDDATE`, `LINK`, `LANG`, `UPDATE_USER`, `UPDATE_DATE`, `STATUS` FROM `nr_events` where (LANG='".$slang."') ORDER BY `ID` DESC limit $start_num,$read_num;";
		  }else{		  
		   $str="SELECT `ID`, `TITLE`, `CONTENT`, `WHEREIS`, `IMG`, `STARTDATE`, `ENDDATE`, `LINK`, `LANG`, `UPDATE_USER`, `UPDATE_DATE`, `STATUS` FROM `nr_events` ORDER BY `ID` DESC limit $start_num,$read_num;";
		  }
		}        

      $result=mysqli_query($link_db,$str);
	  $i=0;
      while(list($ID, $TITLE, $CONTENT, $WHEREIS, $IMG, $STARTDATE, $ENDDATE, $LINK, $LANG, $UPDATE_USER, $UPDATE_DATE, $STATUS)=mysqli_fetch_row($result))
      {
      $i=$i+1;
      putenv("TZ=Asia/Taipei");
  ?>
  <tr>
    <td ><?php echo date("Y-m-d",strtotime($STARTDATE))." - ".date("Y-m-d",strtotime($ENDDATE));?></td><td><?=$TITLE;?></td><td><?php if(strlen($CONTENT)>=40){ echo mb_substr(htmlspecialchars($CONTENT, ENT_QUOTES),0,40,'utf-8')."...."; }else if(strlen($CONTENT)<40){ echo $CONTENT; } ?></td><td><?=$LANG;?></td><td><?php if($STATUS=='1'){ echo "Online"; }else if($STATUS=='0'){ echo "Offline"; } ?></td><td ><a href="nr_events.php?peid=<?=$ID;?>&type=edit#nrevts_edit">Edit</a>&nbsp;&nbsp;<a href="nr_events.php?act=del&d_id=<?=$ID;?>" onclick="return confirm('Are you sure you want to delete this item?');">Del</a></td>
  </tr>
  <?php
	  }
  ?>
  <tr>
    <td colspan="4">
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
<select id="Events_page" name="Events_page" onChange="MM_o(this)">
<?php
for($j=1;$j<=$total;$j++){
?>
<option value="?page=<?=$j?>&s_search=<?=$s_search?>" <?php if($page==$j){ echo "selected"; } ?>><?=$j?></option>
<?php
}
?>
</select>&nbsp;&nbsp;
<?php echo $pagenav; ?>
</div>

<p >&nbsp;</p><p >&nbsp;</p>
  <P style="color:#0F0">
  - "Contents" 只show 前100個characters<br >
  - "Status" 決定此則event是否online<br >
  - click "Del" 要popup a confirmation window to proceed<br >
    - * 表可sorting<br >- List 順序：新至舊
  </p>
<p class="clear">&nbsp;</p>

<!--Click Edit and add -->							
<div id="nrevts_add" class="subsettings" style="display:none">
<form id="form1" name="form1" method="post" action="?kinds=add_nrevts" enctype="multipart/form-data" onsubmit="return Final_Check();">
<h1>Add an event:</h1>
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hiden_add();"> [close] </a></div><!--end of close-->
<table class="addspec">
<tr>
<th>Event Title:  </th>
<td><input id="pe1A" name="pe1A" type="text" size="80" value=""  /></td>
</tr>
<tr>
<th>Contents: </th>
<td><textarea id="editor1" name="editor1" rows="5" cols="100" style="max-width: 500px; max-height: 500px;"></textarea>
<p style="color:#0F0">** web editor : Alow HTML code</p>
</td>
</tr>
<tr>
<th>Image: </th>
<td><input type="file" name="myFileA" size="20"></td>
</tr>
<tr>
<th>Location:  </th>
<td><input id="pe2A" name="pe2A" type="text" size="80" value="" /></td>
</tr>
<tr>
<th>Start Date:  </th>
<td><input id="sDate" name="sDate" type="text" size="20" value="" onfocus="HS_setDate(this)" /></td>
</tr>
<tr>
<th>End Date:  </th>
<td><input id="eDate" name="eDate" type="text" size="20" value="" onfocus="HS_setDate(this)" /></td>
</tr>
<tr>
<th>URL:  </th>
<td><input id="pe3A" name="pe3A" type="text" size="80" value=""  /></td>
</tr>
<tr>
<th>Language:</th>
<td>
<select id="pe_langA" name="pe_langA">
<option value="" selected>Select...</option>
<option value="en-US">English</option>
<option value="zh-CN">簡體</option>
<option value="zh-TW">繁體</option>
<option value="ja-JP">日文</option>
</select></td>
</tr>
<tr>
<th>Status:</th>
<td>
<select id="pe_statusA" name="pe_statusA">
<option selected value="1">Online</option>
<option value="0">Offline</option>
</select>
</td>
</tr>
<tr><td colspan="2">
<input name="c2" type="button" value="Cancel" onclick="javascript:self.location='nr_events.php'" />&nbsp;&nbsp;<input name="b2" type="submit" value="Done" /> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
</td></tr>
</table>
</form>

<script language="JavaScript">
function Final_Check( ) {
if(document.form1.pe1A.value == ""){
alert("Required input a Event Title！");
document.form1.pe1A.focus();
return false;
}

if(document.form1.pe2A.value == ""){
alert("Required input a Location！");
document.form1.pe2A.focus();
return false;
}
if(document.form1.myFileA.value == ""){
alert("Please select To upload large image！");
document.form1.myFileA.focus();
return false;
}

if(document.form1.pe_langA.value == ""){
alert("Required select a language！");
document.form1.pe_langA.focus();
return false;
}

return true;
}
</script>
</div>
<?php
if(isset($_REQUEST['peid'])!=''){
  $peid=intval($_REQUEST['peid']);
  $str_m="SELECT `ID`, `TITLE`, `CONTENT`, `WHEREIS`, `IMG`, `STARTDATE`, `ENDDATE`, `LINK`, `LANG`, `UPDATE_USER`, `UPDATE_DATE`, `STATUS`, `MAINITEM` FROM `nr_events` where `ID`=".$peid;
  $mresult=mysqli_query($link_db,$str_m);
  $mdata=mysqli_fetch_row($mresult);

?>
<div id="nrevts_edit" class="subsettings" style="display:none">
<form id="form2" name="form2" method="post" action="?kinds=edit_nrevts" enctype="multipart/form-data" onsubmit="return EFinal_Check();">
<h1>Edit an event:</h1>
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hiden_edit();"> [close] </a></div><!--end of close-->
<table class="addspec">

<tr>
<th>Event Title:  </th>
<td><input id="pe1" name="pe1" type="text" size="80" value="<?=$mdata[1];?>" /></td>
</tr>
<tr>
<th>Contents: </th>
<td><textarea id="editor2" name="editor2" rows="5" cols="100" style="max-width: 500px; max-height: 500px;"><?=$mdata[2];?></textarea>
<p style="color:#0F0">** web editor : Alow HTML code</p>
</td>
</tr>
<tr>
<th>Image: </th>
<td><input type="file" name="myFile" size="20"><?=$mdata[4];?></td>
</tr>
<tr>
<th>Location:  </th>
<td><input id="pe2" name="pe2" type="text" size="80" value="<?=$mdata[3];?>"  /></td>
</tr>
<tr>
<th>Start Date:  </th>
<td><input id="sDateM" name="sDateM" type="text" size="20" value="<?=$mdata[5];?>" onfocus="HS_setDate(this)" /></td>
</tr>
<tr>
<th>End Date:  </th>
<td><input id="eDateM" name="eDateM" type="text" size="20" value="<?=$mdata[6];?>" onfocus="HS_setDate(this)" /></td>
</tr>
<tr>
<th>URL:  </th>
<td><input id="pe3" name="pe3" type="text" size="80" value="<?=$mdata[7];?>" /></td>
</tr>
<tr>
<th>Language:</th>
<td>
<select id="pe_lang" name="pe_lang">
<option value="">Select...</option>
<option value="en-US" <?php if($mdata[8]=='en-US'){ echo "selected"; } ?>>English</option>
<option value="zh-CN" <?php if($mdata[8]=='zh-CN'){ echo "selected"; } ?>>簡體</option>
<option value="zh-TW" <?php if($mdata[8]=='zh-TW'){ echo "selected"; } ?>>繁體</option>
<option value="ja-JP" <?php if($mdata[8]=='ja-JP'){ echo "selected"; } ?>>日文</option>
</select></td>
</tr>
<tr>
<th>Status:</th>
<td>
<select id="pe_status" name="pe_status">
<option value="1" <?php if($mdata[11]==1){ echo "selected"; } ?>>Online</option>
<option value="0" <?php if($mdata[11]==0){ echo "selected"; } ?>>Offline</option>
</select>
</td>
</tr>
<tr><td colspan="2">
<input type="hidden" name="peid01" value="<?=$mdata[0];?>">
<input name="c2" type="button" value="Cancel" onclick="javascript:self.location='nr_events.php'" />&nbsp;&nbsp;<input name="b2" type="submit" value="Done" /> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
</td></tr>
</table>
</form>
<script language="JavaScript">
function EFinal_Check( ) {
if(document.form2.pe1.value == ""){
alert("Required input a Event Title！");
document.form2.pe1.focus();
return false;
}

if(document.form2.pe2.value == ""){
alert("Required input a Location！");
document.form2.pe2.focus();
return false;
}
/*if(document.form2.myFile.value == ""){
alert("Please select To upload large image！");
document.form2.myFile.focus();
return false;
}*/

if(document.form2.pe_lang.value == ""){
alert("Required select a language！");
document.form2.pe_lang.focus();
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
if(isset($_REQUEST['peid'])!=''){
echo "<script>show_edit();</script>\n";
exit();
}
?>