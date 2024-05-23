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

if($_GET['kinds']=='Del'){
  $d_id=intval($_GET['d_id']);
	  $str_del="DELETE FROM article WHERE ID=".$d_id;
	  $del_cmd=mysqli_query($link_db,$str_del);
	  echo "<script>alert('Delete Article Done!');self.location='article_mgt.php'</script>";
	  exit();
}



if($_GET['kinds']=="edit_article"){

	if(isset($_POST['edit_ID'])!=""){
		$m_id01=intval($_POST['edit_ID']);
	}
	
	if(isset($_POST['edit_title'])!=""){
		$edit_title=filter_var($_POST['edit_title']);
		$edit_title = str_replace("'","&#39;",$edit_title);
		//$edit_title=str_replace("'","’",$edit_title);
	}else{
		$edit_title="";
	}
	if(isset($_POST['edit_summary'])!=""){
		$edit_summary=filter_var($_POST['edit_summary']);
		$edit_summary = str_replace("'","&#39;",$edit_summary);
		//$edit_summary=str_replace("'","’",$edit_summary);
	}else{
		$edit_summary="";
	}
	if(isset($_POST['edit_Date'])!=""){
		$edit_Date=filter_var($_POST['edit_Date']);
	}else{
		$edit_Date="";
	}
	if(isset($_POST['edit_content'])!=""){
		$edit_content=filter_var($_POST['edit_content']);
		$edit_content = str_replace("'","&#39;",$edit_content);
		//$edit_content=str_replace("'","’",$edit_content);
	}else{
		$edit_content="";
	}
	if(isset($_POST['edit_URL'])!=""){
		$edit_URL=filter_var($_POST['edit_URL']);
		$edit_URL=str_replace(" ","_",$edit_URL);
	}else{
		$edit_URL="";
	}
	if(isset($_POST['relProd_valM'])!=""){
		$edit_pr=filter_var($_POST['relProd_valM']);
	}else{
		$edit_pr="";
	}
	if(isset($_POST['edit_status'])!=''){
		$edit_status=filter_var($_POST['edit_status']);
	}else{
		$edit_status="";
	}

	putenv("TZ=Asia/Taipei");
	$now=date("Y/m/d H:i:s");

	$str_upd="UPDATE article SET Title='".$edit_title."', Summary='".$edit_summary."', Reviewed_Date='".$edit_Date."', Contents='".$edit_content."', Redirect_URL='".$edit_URL."', Products='".$edit_pr."', Status='".$edit_status."', C_DATE='".$now."' WHERE ID=".$m_id01;
	$upd_cmd=mysqli_query($link_db,$str_upd);
	echo "<script>alert('Update Article Done!');location.href='article_mgt.php'</script>";
	exit();
}


if($_GET['kinds']=="add_article"){

	if(isset($_POST['add_title'])!=""){
		$add_title=filter_var($_POST['add_title']);
		$add_title = str_replace("'","&#39;",$add_title);
		//$add_title=str_replace("'","’",$add_title);
	}else{
		$add_title="";
	}
	if(isset($_POST['add_summary'])!=""){
		$add_summary=filter_var($_POST['add_summary']);
		$add_summary = str_replace("'","&#39;",$add_summary);
		//$add_summary=str_replace("'","’",$add_summary);
	}else{
		$add_summary="";
	}
	if(isset($_POST['add_Date'])!=""){
		$add_Date=filter_var($_POST['add_Date']);
	}else{
		$add_Date="";
	}
	if(isset($_POST['add_content'])!=""){
		$add_content=filter_var($_POST['add_content']);
		$add_content = str_replace("'","&#39;",$add_content);
		//$add_content=str_replace("'","’",$add_content);
	}else{
		$add_content="";
	}
	if(isset($_POST['add_URL'])!=""){
		$add_URL=filter_var($_POST['add_URL']);
		$add_URL=str_replace(" ","_",$add_URL);
	}else{
		$add_URL="";
	}
	if(isset($_POST['relProd_val'])!=""){
		$add_pr=filter_var($_POST['relProd_val']);
	}else{
		$add_pr="";
	}
	if(isset($_POST['add_status'])!=''){
		$add_status=filter_var($_POST['add_status']);
	}else{
		$add_status="";
	}
	
	putenv("TZ=Asia/Taipei");
	$now=date("Y/m/d H:i:s");



	$str_inst="INSERT INTO article (Title, Summary, Reviewed_Date, Contents, Redirect_URL, Products, Status, C_DATE) VALUES ('".$add_title."','".$add_summary."','".$add_Date."','".$add_content."','".$add_URL."','".$add_pr."','".$add_status."','".$now."')";
	$inst_cmd=mysqli_query($link_db,$str_inst);
	echo "<script>alert('Add Article Done!');location.href='article_mgt.php'</script>";
	exit();

}

if(isset($_GET['sInput'])<>''){
	$s_search=trim($_GET['sInput']);
  //$s_search=preg_replace("['\"\$ \r\n\t;<>\*%\?]", '', $_REQUEST['s_search']);
	$str1="SELECT count(*) FROM article WHERE Title like '%".$s_search."%'";
}else{
	$str1="SELECT count(*) FROM article WHERE 1";  
}

$list1 =mysqli_query($link_db,$str1);
list($public_count) = mysqli_fetch_row($list1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Website Contents Management - Products Management - Contents: Modules - Article management </title>
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

function MM_o(selObj){
	window.open(document.getElementById('article_page').options[document.getElementById('article_page').selectedIndex].value,"_self");
}
</script>










</head>

<body>
<a name="top"></a>
<div >
	<div class="left"><h1>&nbsp;&nbsp;MCT Website Backends - MDSG Article Management</h1></div>

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
	<h2>Contents &nbsp;&gt;&nbsp;  <a href="../modules.html">Modules</a>  &nbsp;&gt;&nbsp; Article management</h2> 
</div>

<div id="content">

	<br />

	<h3>Article Lists:</h3>
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

	<div class="pagination left">
		<p><select><option selected>Title</option></select>&nbsp;&nbsp;&nbsp;&nbsp;
			<input id="sInput" name="sInput" type="text" size="30" value=""  /> 
			<input name="" type="button" value="Search"  onclick="search()" />   </p>
		<p>Total: <span class="w14bblue"><?=$public_count?></span> records &nbsp;&nbsp;| &nbsp;&nbsp;<input name="" type="text" size="1" value="10" /> Records Per Page &nbsp;&nbsp;| &nbsp;&nbsp;Page: &nbsp;
			<select id="article_page" name="article_page" onChange="MM_o(this)">
			<?php
			for($j=1;$j<=$total;$j++){
				?>
				<option value="?page=<?=$j?>" <?php if($page==$j){ echo "selected"; } ?>><?=$j?></option>
				<?php
			}
			?>
		</select></p>
	</div>




	<table class="list_table">

		<tr>
			<th>ID</th><th >Title</th><th>Reviewed Date</th><th  >Products</th><th>*Status</th><th><div class="button14" style="width:50px;" onClick="show_add();">Add</div></th>
		</tr>
		<?php
		if(isset($_GET['sInput'])<>''){
			$s_search=trim($_GET['sInput']);
			$s_search=filter_var($s_search);
			$strList="SELECT ID, Title, Summary, Reviewed_Date, Contents, Redirect_URL, Products, Status, U_DATE FROM article WHERE Title like '%".$s_search."%' ORDER BY U_DATE DESC limit $start_num,$read_num;";
		}else{
			$strList="SELECT ID, Title, Summary, Reviewed_Date, Contents, Redirect_URL, Products, Status, U_DATE FROM article WHERE 1 ORDER BY U_DATE DESC limit $start_num,$read_num;"; 
		}
		$cmdList =mysqli_query($link_db,$strList);
		while($data = mysqli_fetch_row($cmdList)){
			$date=explode(" ",$data[3]);
			if($data[7]==1){
				$status="Online";
			}else{
				$status="Offline";
			}
			echo "<tr>
						<td >".$data[0]."</td><td>".$data[1]."</td><td>".$date[0]."</td><td>".$data[6]."</td><td>".$status."</td>
						<td ><a href='?kinds=Edit&id=".$data[0]."'>Edit</a>&nbsp;&nbsp;
						<a href='?kinds=Del&d_id=".$data[0]."'>Del</a>
						</td>
						</tr>";
		}
		?>
		

	</table>

	<p style="color:#0F0">- List順序: 新至舊</p>

	<p >&nbsp;</p><p >&nbsp;</p>



	<p class="clear">&nbsp;</p>



	<!--Click Add -->							
	<div id="Article_Add" class="subsettings" style="display:none">
		<h1>Add an Article</h1>
		<!--Click close to close this subsettings div--><div class="right"><a href="article_mgt.php"> [close] </a></div><!--end of close-->
		<form id="form1" name="form1" method="post" action="?kinds=add_article">			
			<table class="addspec">


				<tr>
					<th>Title:  </th>
					<td><input id="add_title" name="add_title" type="text" size="40" value=""  />
					</td>
				</tr>
				<tr>
					<th>Summary:  </th>
					<td><input id="add_summary" name="add_summary" type="text" size="100" value=""  />
					</td>
				</tr>
				<tr>
					<th>Reviewed Date:  </th>
					<td>
						<input id="add_Date" name="add_Date" type="text" size="10" value="" onfocus="HS_setDate(this)"/>
					</td>
				</tr>
				<tr>
					<th>Contents:</th>
					<td>
						<textarea  id="add_content" name="add_content" rows="6" cols="50" style="max-width: 300px; max-height: 300px;"></textarea>
					</td>
				</tr>
				<tr>
					<th>Redirect URL:  </th>
					<td>/support/<input id="add_URL" name="add_URL" type="text" size="40" value=""  />
					</td>
				</tr>
				<tr>
					<th>Products:</th>
					<td>edit/add 只 load Intel DSG products
						<div class="button14 " style="width:60px; " ><a class="fancybox fancybox.iframe" href="../lb_doload_mo_dsg.php" style="color:#ffffff">Edit</a></div>
						<textarea id="relProd_val" name="relProd_val" rows="5" cols="80" style="border: none;max-width: 800px; max-height: 200px;" readonly></textarea>
					</td>
				</tr>
				<tr>
					<th>Status:</th>
					<td><select id="add_status" name="add_status"><option value="1" selected>Online</option><option value="0">Offline</option></select>
					</td>
				</tr>


				<tr><td colspan="2">
					<input name="" type="submit" value="Done" />&nbsp;&nbsp;<input name="" type="button" value="Cancel" /> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
				</td></tr>


			</table>
		</form>
	</div>
	<!--Click Add END -->		
	<?php
	if($_GET['kinds']=="Edit"){
		$EID=filter_var($_GET['id']);
		$strEdit="SELECT ID, Title, Summary, Reviewed_Date, Contents, Redirect_URL, Products, Status, U_DATE FROM article WHERE ID='".$EID."'";
		$cmdEdit =mysqli_query($link_db,$strEdit);
		$dataEdit = mysqli_fetch_row($cmdEdit);
	?>
	<!--Click Edit -->							
	<div id="Article_Edit" class="subsettings" style="">
		<h1>Edit an Article</h1>
		<!--Click close to close this subsettings div--><div class="right"><a href="article_mgt.php"> [close] </a></div><!--end of close-->
		<form id="form2" name="form2" method="post" action="?kinds=edit_article">			
			<table class="addspec">
				<input id="edit_ID" name="edit_ID" type="hidden" size="40" value="<?=$dataEdit[0]?>"  />
				<tr>
					<th>Title:  </th>
					<td><input id="edit_title" name="edit_title" type="text" size="40" value="<?=$dataEdit[1]?>"  />
					</td>
				</tr>
				<tr>
					<th>Summary:  </th>
					<td><input id="edit_summary" name="edit_summary" type="text" size="100" value="<?=$dataEdit[2]?>"  />
					</td>
				</tr>
				<tr>
					<th>Reviewed Date:  </th>
					<td>
						<input id="edit_Date" name="edit_Date" type="text" size="10" value="<?=$dataEdit[3]?>" onfocus="HS_setDate(this)"/>
					</td>
				</tr>
				<tr>
					<th>Contents:</th>
					<td>
						<textarea  id="edit_content" name="edit_content" rows="6" cols="50" style="max-width: 300px; max-height: 300px;"><?=$dataEdit[4]?></textarea>
					</td>
				</tr>
				<tr>
					<th>Redirect URL:  </th>
					<td>/support/<input id="edit_URL" name="edit_URL" type="text" size="40" value="<?=$dataEdit[5]?>"  />
					</td>
				</tr>
				<tr>
					<th>Products:</th>
					<td>edit/add 只 load Intel DSG products
						<div class="button14 " style="width:60px; " ><a class="fancybox fancybox.iframe" href="../elb_doload_mo_dsg.php?cid=<?=$dataEdit[0]?>&d_type=art" style="color:#ffffff">Edit</a></div>
						<textarea id="relProd_valM" name="relProd_valM" rows="5" cols="80" style="border: none;max-width: 800px; max-height: 200px;" readonly><?=$dataEdit[6]?></textarea>
					</td>
				</tr>
				<tr>
					<th>Status:</th>
					<td><select id="edit_status" name="edit_status">
						<option value="1" <?php if($dataEdit[7]==1){echo "selected";}?>>Online</option>
						<option value="0" <?php if($dataEdit[7]==0){echo "selected";}?>>Offline</option><
						/select>
					</td>
				</tr>


				<tr><td colspan="2">
					<input name="" type="submit" value="Done" />&nbsp;&nbsp;<input name="" type="button" value="Cancel" /> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
				</td></tr>


			</table>
		</form>
	</div>
	<!--Click Edit End -->	
	<?php
	}
	?>
							

	<p class="clear">&nbsp;</p>

</div>


<div id="footer">	Copyright &copy; 2014 Company Co. All rights reserved.
	<div class="gotop" onClick="location='#top'">Top</div>



</div>

</body>
<script>
function show_add(){
	$("#Article_Add").show();
	$("#Article_Edit").hide();
}

function search(){
	var Input=$("#sInput").val();
  self.location='article_mgt.php?sInput='+Input;
}
</script>
</html>
