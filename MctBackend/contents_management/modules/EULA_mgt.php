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
  $str = str_replace('<',"&lt;",$str);
  $str = str_replace('>',"&gt;",$str);
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

if($_GET['kinds']=='del'){
	$del_id=dowith_sql($_GET['id']);
	$del_id=filter_var($del_id);
  $str="DELETE FROM eula_dsg WHERE ID='".$del_id."'";
  mysqli_query($link_db,$str);
	echo "<script>alert('Delete The Data!');self.location='EULA_mgt.php'</script>";
	exit();
}


if($_GET['kinds']=='add_EULA'){
	$addName=dowith_sql($_POST['addName']);
	$addName=filter_var($addName);
	$addContent=filter_var($_POST['addContent']);
	$addContent=str_replace("'","’",$addContent);
	//$addContent=filter_var($addContent);
	$str="INSERT INTO eula_dsg (Name, Content, c_date) VALUES ('".$addName."','".$addContent."','".$now."')";

	if(mysqli_query($link_db,$str)){
		echo "<script>alert('Add done!');self.location='EULA_mgt.php'</script>";
	}else{
		echo "<script>alert('Add fail!');self.location='EULA_mgt.php'</script>";
	}
	exit();
}

if($_GET['kinds']=='update_EULA'){
	$editID=dowith_sql($_POST['editID']);
	$editID=filter_var($editID);
	$editName=dowith_sql($_POST['editName']);
	$editName=filter_var($editName);
	$editContent=filter_var($_POST['editContent']);
	$editContent=str_replace("'","’",$editContent);
	//$editContent=filter_var($editContent);
	$str="UPDATE eula_dsg SET Name='".$editName."', Content='".$editContent."', u_date='".$now."' WHERE ID='".$editID."'";
	if(mysqli_query($link_db,$str)){
		echo "<script>alert('Update done!');self.location='EULA_mgt.php'</script>";
	}else{
		echo "<script>alert('Update fail!');self.location='EULA_mgt.php'</script>";
	}
	exit();
}

$str1="SELECT count(*) FROM eula_dsg";
$list1 =mysqli_query($link_db,$str1);
list($public_count) = mysqli_fetch_row($list1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Website Contents Management - Products Management - Contents: Modules - EULA Management</title>
	<link rel=stylesheet type="text/css" href="../../backend.css">
<link rel="stylesheet" type="text/css" href="../../css/css.css" />
	<script type="text/javascript" src="../../lib/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="../../lib/jquery.mousewheel-3.0.6.pack.js"></script>
	<script type="text/javascript" src="../../source/jquery.fancybox.js?v=2.0.6"></script>
	<link rel="stylesheet" type="text/css" href="../../source/jquery.fancybox.css?v=2.0.6" media="screen" />
	<link rel="stylesheet" type="text/css" href="../../source/helpers/jquery.fancybox-buttons.css?v=1.0.2" />
	<script type="text/javascript" src="../../source/helpers/jquery.fancybox-buttons.js?v=1.0.2"></script>


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
		<div class="left"><h1>&nbsp;&nbsp;Website Backends - Website Contents Management - Contents: Document management</h1></div>
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
			<li><a href="../newsletter.php">Newsletters</a>
				<ul><li><a href="../subscribe.php">Subscription</a></li></ul>
			</li>
		</ul>
	</div>

	<div class="clear"></div>

	<div id="Search" >
		<h2>Contents &nbsp;&gt;&nbsp;  <a href="../modules.php">Modules</a>  &nbsp;&gt;&nbsp; EULA management</h2> 
	</div>

	<div id="content">
		<br />
		<h3>EULA List:</h3>
		<div class="pagination left">

			<p>Total: <span class="w14bblue"><?=$public_count?></span> records </p>
		</div>



		<table class="list_table">

			<tr>
				<th>ID</th><th>Name</th><th>CreateDate</th><th>Update Date</th><th>Products / Components</th><th><div class="button14" style="width:50px;" onClick="show_add();">Add</div></th>
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

			$strList="SELECT ID, Name, Content, c_date, u_date FROM eula_dsg limit $start_num,$read_num;";
			$cmdList=mysqli_query($link_db,$strList);
			while($data=mysqli_fetch_row($cmdList)){
				$cdate=explode(" ",$data[3]);
				$udate=explode(" ",$data[4]);
				echo "<tr>";
				echo "<td >".$data[0]."</td><td >".$data[1]."</td><td>".$cdate[0]."</td><td>".$udate[0]."</td><td>N/A</td>
				<td>	<a href='?kinds=edit_EULA&id=".$data[0]."'>Edit</a>&nbsp;&nbsp;
				<a href='?kinds=del&id=".$data[0]."'>Del</a></td>";
				echo "</tr>";
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




		<p class="clear">&nbsp;</p>




		<!--Click Edit and add -->							
		<div id="Add_EULA" class="subsettings" style="display:none">
			<form id="form1" name="form1" method="post" action="?kinds=add_EULA">
				<h1>Add an EULA</h1>
				<!--Click close to close this subsettings div--><div class="right"><a href="EULA_mgt.php"> [close] </a></div><!--end of close-->
				<table class="addspec">
					<tr>
						<th>Name:  </th>
						<td><input id="addName" name="addName" type="text" size="40" value=""  />
						</td>
					</tr>
					<tr>
						<th>Contents:</th>
						<td>
							<textarea id="addContent"  name="addContent" rows="6" cols="50" style="max-width: 300px; max-height: 300px;"></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input name="" type="submit" value="Done" />&nbsp;&nbsp;<input name="" type="button" value="Cancel" onclick="hide_add_edit()" /> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
						</td>
					</tr>
				</table>
			</form>
		</div>


		<?php
		if($_GET['kinds']!=""){
			if($_GET['kinds']=='edit_EULA'){
				echo "<script type='text/javascript'>hid_add();</script>";
				$editID=dowith_sql($_GET['id']);
				$editID=filter_var($editID);
				$strEdit="SELECT ID, Name, Content, c_date, u_date FROM eula_dsg WHERE ID='".$editID."'";
				$cmdEdit=mysqli_query($link_db,$strEdit);
				$dataEdit=mysqli_fetch_row($cmdEdit);
			?>
			<!--Click Edit and add -->							
			<div id="Edit_EULA" class="subsettings">
				<form id="form2" name="form2" method="post" action="?kinds=update_EULA">
					<h1>Edit an EULA</h1>
					<!--Click close to close this subsettings div--><div class="right"><a href="EULA_mgt.php"> [close] </a></div><!--end of close-->
					<table class="addspec">
						<tr>
							<th>Name:  </th>
							<td><input id="editName" name="editName" type="text" size="40" value="<?=$dataEdit[1]?>"  />
							</td>
						</tr>
						<tr>
							<th>Contents:</th>
							<td>
								<textarea id="editContent" name="editContent" rows="6" cols="50" style="max-width: 300px; max-height: 300px;"><?=$dataEdit[2]?></textarea>
							</td>
						</tr>
							<tr><td colspan="2">
								<input name="" type="submit" value="Done" />&nbsp;&nbsp;<input name="" type="button" value="Cancel" /> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
								<input id="editID" name="editID" type="hidden" value="<?=$dataEdit[0]?>">
							</td>
						</tr>

					</table>
				</form>
			</div>
			<?php
			}	
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
	  $("#Add_EULA").show();
	  $("#Edit_EULA").hide();
	}
	function hid_add(){
	  $("#Add_EULA").hide();
	}

	
</script>
</html>
<?php
mysqli_Close($link_db);
?>