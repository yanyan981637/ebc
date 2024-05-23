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
  $str = str_replace("=","",$str);
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
  $str_del="DELETE FROM dsg_security_advisories WHERE ID=".$did01;
  $del_cmd=mysqli_query($link_db,$str_del);
  echo "<script>alert('Delete the Data!');self.location='DSG_Security_Advisories.php'</script>";
  exit();
}

if($kinds=='add_SA'){
	$add_title=dowith_sql($_POST['add_title']);
	$add_title=filter_var($add_title);

	$add_date=dowith_sql($_POST['add_date']);
	$add_date=filter_var($add_date);

	$add_SAID=dowith_sql($_POST['add_SAID']);
	$add_SAID=filter_var($add_SAID);

	$add_intelSA=dowith_sql($_POST['add_intelSA']);
	$add_intelSA=filter_var($add_intelSA);

	$add_des=dowith_sql($_POST['add_des']);
	$add_des=filter_var($add_des);

	$add_SAsourceID=dowith_sql($_POST['add_SAsourceID']);
	$add_SAsourceID=filter_var($add_SAsourceID);

	$add_Order=dowith_sql($_POST['add_Order']);
	$add_Order=filter_var($add_Order);

	$add_status=dowith_sql($_POST['add_status']);
	$add_status=filter_var($add_status);

	$insertTmp="Title, SA_Date, SA_ID, Intel_SA, Description, SourceID, Ord, Status, C_DATE";

	$str="INSERT INTO dsg_security_advisories (".$insertTmp.") VALUES ";
	$str.="('".$add_title."','".$add_date."','".$add_SAID."','".$add_intelSA."','".$add_des."','".$add_SAsourceID."','".$add_Order."','".$add_status."','".$now."')";
	if(mysqli_query($link_db,$str)){
		echo "<script>alert('Add Security Advisories done!');self.location='DSG_Security_Advisories.php'</script>";
	}else{
		echo "<script>alert('Add Security Advisories fail!');self.location='DSG_Security_Advisories.php'</script>";
	}
	exit();
}

if($kinds=='edit_SA'){
	$edit_ID=dowith_sql($_POST['edit_ID']);
	$edit_ID=filter_var($edit_ID);

	$edit_title=dowith_sql($_POST['edit_title']);
	$edit_title=filter_var($edit_title);

	$edit_date=dowith_sql($_POST['edit_date']);
	$edit_date=filter_var($edit_date);

	$edit_SAID=dowith_sql($_POST['edit_SAID']);
	$edit_SAID=filter_var($edit_SAID);

	$edit_intelSA=dowith_sql($_POST['edit_intelSA']);
	$edit_intelSA=filter_var($edit_intelSA);

	$edit_des=dowith_sql($_POST['edit_des']);
	$edit_des=filter_var($edit_des);

	$edit_SAsourceID=dowith_sql($_POST['edit_SAsourceID']);
	$edit_SAsourceID=filter_var($edit_SAsourceID);

	$edit_Order=dowith_sql($_POST['edit_Order']);
	$edit_Order=filter_var($edit_Order);

	$edit_status=dowith_sql($_POST['edit_status']);
	$edit_status=filter_var($edit_status);

	$updateTmp="Title='".$edit_title."', SA_Date='".$edit_date."', SA_ID='".$edit_SAID."', Intel_SA='".$edit_intelSA."', Description='".$edit_des."', SourceID='".$edit_SAsourceID."', Ord='".$edit_Order."', Status='".$edit_status."', U_DATE='".$now."'";

	$str="UPDATE dsg_security_advisories SET ".$updateTmp." WHERE ID='".$edit_ID."'";
	if(mysqli_query($link_db,$str)){
		echo "<script>alert('Edit Security Advisories done!');self.location='DSG_Security_Advisories.php'</script>";
	}else{
		echo "<script>alert('Edit Security Advisories fail!');self.location='DSG_Security_Advisories.php'</script>";
	}
	exit();

}



if(isset($_GET['sel_type'])<>''){
	$sInput=dowith_sql($_GET['sInput']);
	$sInput=filter_var($sInput);

	$sel_type=filter_var($_GET['sel_type']);
	if($sel_type=="SAID"){ 
		$str1="SELECT count(*) FROM dsg_security_advisories WHERE SA_ID='".$sInput."'";
	}else{
		$str1="SELECT count(*) FROM dsg_security_advisories";
	}
}else{	 
	$str1="SELECT count(*) FROM dsg_security_advisories";
}

$list1 =mysqli_query($link_db,$str1);
list($public_count) = mysqli_fetch_row($list1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Website Contents Management - Products Management - Contents: Modules - DSG Security Advisories </title>
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


function show_AddSA(){
  $("#ADDSA").show();
  $("#EDITSA").hide();
}

function search(){
	//var selType=$("#selType").val();
	var Input=$("#sInput").val();
  self.location='components_download.php?sel_type=SAID'+'&sInput='+Input;
}

function MM_o(selObj){
	window.open(document.getElementById('SA_page').options[document.getElementById('SA_page').selectedIndex].value,"_self");
}
</script>










</head>

<body>
<a name="top"></a>
<div >
	<div class="left"><h1>&nbsp;&nbsp;MCT Website Backends - Website Contents Management - Contents: DSG Security Advisories</h1></div>

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
	<h2>Contents &nbsp;&gt;&nbsp;  <a href="../modules.html">Modules</a>&nbsp;&gt;&nbsp;DSG Security Advisories</h2> 
</div>

<div id="content">

	<br />

	<h3>DSG Security Advisories Lists:
	</h3>


	<div class="pagination left">
		<p>
			<select>
				<option selected>SA-ID:</option>
			</select>&nbsp;&nbsp;&nbsp;&nbsp;
			<input id="sInput" name="sInput" type="text" size="30" value=""  /> 
			<input name="" type="button" value="Search" onclick="search()"  />
		</p>
		<?php
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
		?>
		<p>Total: <span class="w14bblue"><?=$public_count?></span> records &nbsp;&nbsp;| &nbsp;&nbsp;<input name="" type="text" size="1" value="<?=$read_num?>" /> Records Per Page &nbsp;&nbsp;| &nbsp;&nbsp;Page: &nbsp;
		<select id="SA_page" name="SA_page" onChange="MM_o(this)">
			<?php
			for($j=1;$j<=$total;$j++){
				?>
				<option value="?page=<?=$j?>" <?php if($page==$j){ echo "selected"; } ?>><?=$j?></option>
				<?php
			}
			?>
		</select>
		</p>
	</div>




	<table class="list_table">

		<tr>
			<th>SA-ID</th>
			<th>Date</th>
			<th>Intel-SA</th>
			<th>Update date</th>
			<th>Order#</th>
			<th>Status</th>
			<th><div class="button14" style="width:50px;" onClick="show_AddSA()">Add</div></th>
		</tr>
		<?php
		if(isset($_GET['sel_type'])<>''){
			if($sel_type=="SAID"){ 
				$str1="SELECT ID, Title, SA_Date, SA_ID, Intel_SA, Description, SourceID, Ord, Status, U_DATE FROM dsg_security_advisories WHERE SA_ID='".$sInput."' limit $start_num,$read_num;";
			}else{
				$str1="SELECT ID, Title, SA_Date, SA_ID, Intel_SA, Description, SourceID, Ord, Status, U_DATE FROM dsg_security_advisories WHERE 1 limit $start_num,$read_num;";
			}
		}else{
			$str_list="SELECT ID, Title, SA_Date, SA_ID, Intel_SA, Description, SourceID, Ord, Status, U_DATE FROM dsg_security_advisories WHERE 1 limit $start_num,$read_num;";
		}
		$cmd_list=mysqli_query($link_db,$str_list);
		while ($data_list=mysqli_fetch_row($cmd_list)) {
			$timestamp = strtotime($data_list[2]); 
			$newDate = date("M Y", $timestamp );
			$up_date=explode(" ", $data_list[9]);

			if($data_list[8]==1){
				$statue="Online";
			}else{
				$statue="Offline";
			}
		?>
		<tr>
			<td><?=$data_list[3]?></td>
			<td><?=$newDate?></td>
			<td><?=$data_list[4]?></td>
			<td><?=$up_date[0]?></td>
			<td><?=$data_list[7]?></td>
			<td><?=$statue?></td>
			<td><a href="?kinds=Edit&id=<?=$data_list[0]?>">Edit</a>&nbsp;&nbsp;<a href="?kinds=Del&d_id=<?=$data_list[0]?>">Del</a></td>
		</tr>
		<?php
		}
		?>
		 

	</table>

	<p style="color:#0F0">- click "Del" 要popup a confirmation window to proceed<br />- List順序: 新至舊</p>

	<p >&nbsp;</p><p >&nbsp;</p>



	<p class="clear">&nbsp;</p>



	<!--Click add -->							
	<div id="ADDSA" class="subsettings" style="display:none">
		<form id="form1" name="form1" method="post" action="?kinds=add_SA">
		<h1>Add a SA</h1>
		<!--Click close to close this subsettings div--><div class="right"><a href="DSG_Security_Advisories.php"> [close] </a></div><!--end of close-->
		<table class="addspec">
			<tr>
				<th>Title:  </th>
				<td><input id="add_title" name="add_title" type="text" size="40" value=""  />
				</td>
			</tr>
			<tr>
				<th>Date:</th>
				<td>
					<input id="add_date" name="add_date" type="text" size="40" value="" onfocus="HS_setDate(this)" />
				</td>
			</tr>
			<tr>
				<th>SA-ID:</th>
				<td>
					<input id="add_SAID" name="add_SAID" type="text" size="40" value=""  />
				</td>
			</tr>
			<tr>
				<th>Intel-SA:</th>
				<td>
					<input id="add_intelSA" name="add_intelSA" type="text" size="40" value=""  />
				</td>
			</tr>
			<tr>
				<th>Description:</th>
				<td>
					<textarea id="add_des" name="add_des" rows="6" cols="50" style="max-width: 500px; max-height: 300px;"></textarea>
				</td>
			</tr>
			<tr>
				<th>Source:</th>
				<td>

					<table class="list_table" style="width:1000px">
						<div id="add_SAsource" name="add_SAsource"></div>
						<a class="fancybox fancybox.iframe" href="../lb_SA_source.php" /><img src="../../images/icon_edit.png" alt="Edit" /></a>
						<br>
						<!-- <textarea id="add_SAsource" name="add_SAsource" rows="5" cols="80" style="border: none;max-width: 800px; max-height: 200px;" readonly></textarea> -->
					</table>

					<br>
					<span style="color:#0F0">可以新增多筆 Name + URL</span>
					<input id="add_SAsourceID" name="add_SAsourceID" type="hidden" value=""  />
				</td>
			</tr>

			<tr>
				<th>Order#:</th>
				<td>
					<?php
					$strID="SELECT Ord FROM dsg_security_advisories ORDER BY Ord DESC";
					$cmdID=mysqli_query($link_db,$strID);
					$number=mysqli_fetch_row($cmdID);
					if($number[0]!=0){
						$order=$number[0]+1;
					}else{
						$order="1";
					}
					?>
					<input id="add_Order" name="add_Order" type="text" size="5" value="<?=$order?>"  />
					<br>
					<span style="color:#0F0">程式自動依序帶出號碼、由1 開始、數值愈大、在前台會先排序顯示</span>
				</td>
			</tr>
			<tr>
				<th>Status:</th>
				<td>
					<select id="add_status" name="add_status">
						<option selected value="1">Online</option>
						<option  value="0">Offline</option>
					</select>
				</td>
			</tr>

			<tr><td colspan="2">
				<input name="" type="submit" value="Done" />&nbsp;&nbsp;<a href="DSG_Security_Advisories.php"><input name="" type="button" value="Cancel" /> </a>
			</td></tr>


		</table>
	</form>
	</div>
	<!--Click ADD END  -->	

	<br>

	<!--Click Edit  -->			
	<?php
	if($kinds=="Edit"){
		$EditID=filter_var($_GET['id']);

		$str_list="SELECT ID, Title, SA_Date, SA_ID, Intel_SA, Description, SourceID, Ord, Status, U_DATE FROM dsg_security_advisories WHERE ID='".$EditID."'";
		$cmd_list=mysqli_query($link_db,$str_list);
		$data_list=mysqli_fetch_row($cmd_list);

		$SAtmp="";
		$saID=explode(",", $data_list[6]);
		foreach ($saID as $key => $value) {
			if($value!=""){

				$str2="SELECT ID, Name, URL FROM dsg_sa_source WHERE ID='".$value."'";
		    $cmd2=mysqli_query($link_db, $str2);
		    $data2=mysqli_fetch_row($cmd2);
		    $SAtmp.="Name: ".$data2[1]."&nbsp;&nbsp;URL: ".$data2[2]."<br>";
			}
			
		}
		
		?>
		<div id="EDITSA" class="subsettings">
		<h1>Edit a SA</h1>
		
		<!--Click close to close this subsettings div--><div class="right"><a href="DSG_Security_Advisories.php"> [close] </a></div><!--end of close-->
		<form id="form2" name="form2" method="post" action="?kinds=edit_SA">
		<table class="eidtspec">
			<input id="edit_ID" name="edit_ID" type="hidden" size="40" value="<?=$data_list[0]?>"  />
			<tr>
				<th>Title:  </th>
				<td><input id="edit_title" name="edit_title" type="text" size="40" value="<?=$data_list[1]?>"  />
				</td>
			</tr>
			<tr>
				<th>Date:</th>
				<td>
					<input id="edit_date" name="edit_date" type="text" size="40" value="<?=$data_list[2]?>" onfocus="HS_setDate(this)" />
				</td>
			</tr>
			<tr>
				<th>SA-ID:</th>
				<td>
					<input id="edit_SAID" name="edit_SAID" type="text" size="40" value="<?=$data_list[3]?>"  />
				</td>
			</tr>
			<tr>
				<th>Intel-SA:</th>
				<td>
					<input id="edit_intelSA" name="edit_intelSA" type="text" size="40" value="<?=$data_list[4]?>"  />
				</td>
			</tr>
			<tr>
				<th>Description:</th>
				<td>
					<textarea id="edit_des" name="edit_des" rows="6" cols="50" style="max-width: 500px; max-height: 300px;"><?=$data_list[5]?></textarea>
				</td>
			</tr>
			<tr>
				<th>Source:</th>
				<td>
					<div id="edit_SAsource" name="edit_SAsource"><?=$SAtmp;?></div>
					<table class="list_table" style="width:1000px">

						<a class="fancybox fancybox.iframe" href="../elb_SA_source.php?eID=<?=$data_list[6];?>" /><img src="../../images/icon_edit.png" alt="Edit" /></a>
						<br>
						<!-- <textarea id="edit_SAsource" name="edit_SAsource" rows="5" cols="80" style="border: none;max-width: 800px; max-height: 200px;" readonly></textarea> -->
					</table>

					<br>
					<span style="color:#0F0">可以新增多筆 Name + URL</span>
					<input id="edit_SAsourceID" name="edit_SAsourceID" type="hidden" value="<?=$data_list[6]?>"  />
				</td>
			</tr>

			<tr>
				<th>Order#:</th>
				<td>
					<input id="edit_Order" name="edit_Order" type="text" size="5" value="<?=$data_list[7]?>"  />
					<br>
					<span style="color:#0F0">程式自動依序帶出號碼、由1 開始、數值愈大、在前台會先排序顯示</span>
				</td>
			</tr>
			<tr>
				<th>Status:</th>
				<td>
					<select id="edit_status" name="edit_status">
						<option selected value="1" <?php if($data_list[8]=="1"){echo "selected";} ?>>Online</option>
						<option  value="0" <?php if($data_list[8]=="0"){echo "selected";} ?>>Offline</option>
					</select>
				</td>
			</tr>

			<tr><td colspan="2">
				<input name="" type="submit" value="Done" />&nbsp;&nbsp;<a href="DSG_Security_Advisories.php"><input name="" type="button" value="Cancel" /> </a>
			</td></tr>


		</table>
		</form>

	</div>
	<?php
	}
	?>				
	
	<!--Click Edit END-->							




	<p class="clear">&nbsp;</p>

</div>


<div id="footer">	Copyright &copy; 2014 Company Co. All rights reserved.
	<div class="gotop" onClick="location='#top'">Top</div>



</div>

</body>
<script>
function show_subsourceA(){
  $("#add_sub_source").show();
  $("#edit_sub_source").hide();
}
function show_subsourceE(i,j){
  $("#add_sub_source").hide();
  $("#edit_sub_source").show();
  var id = $("#s_id_"+j).val();
  var name = $("#s_name_"+j).val();
	var url = $("#s_url_"+j).val();
	$("#e_s_id").val(id);
	$("#e_s_name").val(name);
	$("#e_s_URL").val(url);
}

function Add_subdone(){

  var a_s_name = $("#a_s_name").val();
  var a_s_URL = $("#a_s_URL").val();

  var url = "add_SA_source.php";
  $.ajax({
    type: "post",
    url: url,
    dataType: "html",
    data: {
      a_s_name:a_s_name, 
      a_s_URL:a_s_URL
    },
    success: function(message){
      if(message == "refresh"){  
        window.location.reload(true);
      }else{
        alert(message);
        var tmp = $("#surceID").val();
        if(surceID==""){
        	tmp=message+",";
        }else{
        	tmp+=message;
        }
      }
    }
  });
}

	
</script>
</html>
<?php
mysqli_Close($link_db);
?>