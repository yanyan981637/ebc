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

$options = [
	PDO::ATTR_PERSISTENT => false,
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_EMULATE_PREPARES => false,
	PDO::ATTR_STRINGIFY_FETCHES => false,
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
];

//資料庫連線
try {
	$pdo = new PDO($pdo, $db_user, $db_pwd, $options);
	$pdo->exec('SET CHARACTER SET utf8mb4');
} catch (PDOException $e) {
	throw new PDOException($e->getMessage());
}

function dowith_sql($str)
{
	//$str = str_replace("and","",$str);
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
	//$str = str_replace(".","",$str);
	//$str = str_replace("or","",$str);  //2017.5.24暫時註解, 因舊資料sku會擋(Transport FX27)
	$str = str_replace("=","",$str);
	$str = str_replace("?","",$str);
	$str = str_replace("%","",$str);
	$str = str_replace("0x02BC","",$str);
	$str = str_replace("<script>","",$str);
	$str = str_replace("</script>","",$str);
	$str = str_replace("'","&#39;",$str);
  $str = str_replace('"',"&quot;",$str);
	return $str;
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");
$kinds=dowith_sql($_GET['kinds']);
if($_GET['mid']!=""){
	$mid=dowith_sql($_GET['mid']);
}

if($kinds=="delete_PNC"){
	$mid=dowith_sql($_GET['mid']);

	$delete = "DELETE pcn WHERE ID='".$mid."'";
	$cmd_delete = $pdo->prepare($delete);
	try {
		if($cmd_delete->execute()){
	    echo "<script>alert('Delete Done');window.location.href='PCN_mgt.php'</script>";
	  }else{
			echo "<script>alert('Delete Error');</script>";	    
		}
	} catch (PDOException $e) {
		echo "<script>alert('PDO Error');</script>";	    
	}
}

if($kinds=="add_PNC"){
	$add_title=dowith_sql($_POST['add_title']);
	$add_title=trim($add_title);

	$add_PN=dowith_sql($_POST['add_PN']);
	$add_PN=trim($add_PN);

	$add_Date=dowith_sql($_POST['add_Date']);
	$add_Date=trim($add_Date);

	$tmp_arr = array();
	$tmp_arr=dowith_sql($_POST['add_Pl']);
	$add_Pl = implode(',', $tmp_arr);//把陣列轉換為字串，每個值用,號分隔
	$add_Pl.=",";

	$tmp_arr1 = array();
	$tmp_arr1=dowith_sql($_POST['add_KC']);
	$add_KC = implode(',', $tmp_arr1);
	$add_KC.=",";


	$add_URL=dowith_sql($_POST['add_URL']);
	$add_URL=trim($add_URL);

	$add_Status=dowith_sql($_POST['add_Status']);
	$add_Status=trim($add_Status);

	if($_FILES['pcnCSV']!=""){
		//開啟上傳檔	
		$tmp_MN="";$tmp_PC="";$tmp_MM="";
		$handle = fopen($_FILES['pcnCSV']['tmp_name'], "r") or die("無法開啟");
		//利用fgetcsv()來讀取內容
		while (($data = fgetcsv($handle, 100)) !== FALSE) {
			if($data[0]!=""){
				$tmp=dowith_sql($data[0]);
				$tmp_MN.=$tmp.";";	
			}
			if($data[1]!=""){
				$tmp=dowith_sql($data[1]);
				$tmp_PC.=$tmp.";";
			}
			if($data[2]!=""){
				$tmp=dowith_sql($data[2]);
				$tmp_MM.=$tmp.";";
			}

		}
		fclose($handle);//關閉上傳檔
	}
	

	$data = [$add_title, $add_PN, $add_Date, $add_Pl, $tmp_MN, $tmp_PC, $tmp_MM, $add_KC, $add_URL, $add_Status, $now];
	$insert = 'INSERT INTO pcn (PCN_Title, PCN_Number, Publish_Date, Platform, Marketing_Name, Product_Code, MM, Key_Characteristics, File_URL, Status, C_DATE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
	$cmd_insert = $pdo->prepare($insert);
	try {
		if($cmd_insert->execute($data)){
	    echo "<script>alert('Add Done');window.location.href='PCN_mgt.php'</script>";
	  }else{
			echo "<script>alert('Add Error');</script>";	    
		}
	} catch (PDOException $e) {
		echo "<script>alert('PDO Error');</script>";	    
	}
}

if($kinds=="EditPNC"){
	$edit_ID=dowith_sql($_POST['edit_ID']);
	$edit_ID=trim($edit_ID);

	$edit_title=dowith_sql($_POST['edit_title']);
	$edit_title=trim($edit_title);

	$edit_PN=dowith_sql($_POST['edit_PN']);
	$edit_PN=trim($edit_PN);

	$edit_Date=dowith_sql($_POST['edit_Date']);
	$edit_Date=trim($edit_Date);

	$tmp_arr = array();
	$tmp_arr=dowith_sql($_POST['edit_Pl']);
	$edit_Pl = implode(',', $tmp_arr);//把陣列轉換為字串，每個值用,號分隔
	$edit_Pl.=",";


	$tmp_arr1 = array();
	$tmp_arr1=dowith_sql($_POST['edit_KC']);
	$edit_KC = implode(',', $tmp_arr1);
	$edit_KC.=",";

	$edit_URL=dowith_sql($_POST['edit_URL']);
	$edit_URL=trim($edit_URL);

	$edit_Status=dowith_sql($_POST['edit_Status']);
	$edit_Status=trim($edit_Status);
	if($_FILES['e_pcnCSV']['size']!=0){
		//開啟上傳檔	
		$tmp_MN="";$tmp_PC="";$tmp_MM="";
		$handle = fopen($_FILES['e_pcnCSV']['tmp_name'], "r") or die("無法開啟");
		//利用fgetcsv()來讀取內容
		while (($data = fgetcsv($handle, 100)) !== FALSE) {
			if($data[0]!=""){
				$tmp=dowith_sql($data[0]);
				$tmp_MN.=$tmp.";";	
			}
			if($data[1]!=""){
				$tmp=dowith_sql($data[1]);
				$tmp_PC.=$tmp.";";
			}
			if($data[2]!=""){
				$tmp=dowith_sql($data[2]);
				$tmp_MM.=$tmp.";";
			}

		}
		fclose($handle);//關閉上傳檔

		$data = [$edit_title, $edit_PN, $edit_Date, $edit_Pl, $tmp_MN, $tmp_PC, $tmp_MM, $edit_KC, $edit_URL, $edit_Status, $now];
		$edit = "UPDATE pcn SET PCN_Title = ?, PCN_Number = ?, Publish_Date = ?, Platform = ?, Marketing_Name = ?, Product_Code = ?, MM = ?, Key_Characteristics = ?, File_URL = ?, Status = ?, U_DATE = ? WHERE ID = '".$edit_ID."'";
	}else{
		$data = [$edit_title, $edit_PN, $edit_Date, $edit_Pl, $edit_KC, $edit_URL, $edit_Status, $now];
		$edit = "UPDATE pcn SET PCN_Title = ?, PCN_Number = ?, Publish_Date = ?, Platform = ?, Key_Characteristics = ?, File_URL = ?, Status = ?, U_DATE = ? WHERE ID = '".$edit_ID."'";

	}

	$cmd_update = $pdo->prepare($edit);
	try {
		if($cmd_update->execute($data)){
	    echo "<script>alert('Update Done');window.location.href='PCN_mgt.php'</script>";
	  }else{
			echo "<script>alert('Update Error');</script>";	    
		}
	} catch (PDOException $e) {
		echo "<script>alert('PDO Error');</script>";	    
	}
}

$Pla_arr=array();
$Pla = "SELECT ID, Platform FROM pcn_platform WHERE 1";
$cmd = $pdo->prepare($Pla);
$cmd->execute();
while ($pcn_data=$cmd->fetch(PDO::FETCH_NUM)) {
	$Pla_arr[$pcn_data[0]]=$pcn_data[1];
}

$KC_arr=array();
$KC = "SELECT ID, Characteristics FROM pcn_key_characteristics WHERE 1";
$cmd = $pdo->prepare($KC);
$cmd->execute();
while ($KC_data=$cmd->fetch(PDO::FETCH_NUM)) {
	$KC_arr[$KC_data[0]]=$KC_data[1];
}

if($_GET['sel_type']!=""){
	$selType=filter_var($_GET['sel_type']);
	$Input=filter_var($_GET['sInput']);
	switch ($selType) {
		case "PCN":
		$sql="PCN_Number";
		break;
		case "MN":
		$sql="Marketing_Name";
		break;
		case "PC":
		$sql="Product_Code";
		break;
		case "MM":
		$sql="MM";
		break;
		case "PT":
		$sql="PCN_Title";
		break;
	}

	$pcn = "SELECT count(*) FROM pcn WHERE ".$sql."='".$Input."'";
}else{
	$pcn = "SELECT count(*) FROM pcn WHERE 1";
}
$cmd = $pdo->prepare($pcn);
$cmd->execute();
$pcn_num=$cmd->fetch(PDO::FETCH_NUM);

if(isset($_GET['page'])!=""){
	$page=filter_var($_GET['page']);
}else{
	$page="1";
}

if(empty($page))$page="1";

$read_num="10";
$start_num=$read_num*($page-1); 

$all_page=ceil($pcn_num[0]/$read_num);

$pageSize=$page;
$total=$all_page;
pageft($total,$pageSize,1,0,0,15);       
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
		<div class="left"><h1>&nbsp;&nbsp;MCT Website Backends - MDSG PCN Management</h1></div>

		<div id="logout"><a href="../../login.html">Log out &gt;&gt;</a></div>
	</div>

	<div class="clear"></div>
	<?php
	include("menus.php");
	?>
	<div class="clear"></div>

	<div id="Search" >
		<h2>Contents &nbsp;&gt;&nbsp;  <a href="../modules.html">Modules</a>  &nbsp;&gt;&nbsp; PCN management</h2> 
	</div>

	<div id="content">

		<br />

		<h3>PCN Lists:</h3>


		<div class="pagination left">
			<p>
			<select id="selType" name="selType">
				<option value="PCN">PCN#</option>
				<option value="MN">Marketing Name</option>
				<option value="PC">Product Code</option>
				<option value="MM">MM#</option>
				<option value="PT">PCN Title</option>
			</select>&nbsp;&nbsp;&nbsp;&nbsp;
			<input id="sInput" name="sInput" type="text" size="30" value=""  />
			<input name="" type="button" value="Search" onclick="search()" />   </p>
			<p>Total: 
				<span class="w14bblue"><?=$pcn_num[0];?></span> records &nbsp;&nbsp;| &nbsp;&nbsp;<input name="" type="text" size="1" value="10" /> Records Per Page &nbsp;&nbsp;| &nbsp;&nbsp;Page: &nbsp;
				<select id="PCN_page" name="PCN_page" onChange="MM_o(this)">
				<?php
				for($j=1;$j<=$total;$j++){
				?>
				<option value="?page=<?=$j?>&s_search=<?=$s_search?>" <?php if($page==$j){ echo "selected"; } ?> ><?=$j?></option>
				<?php
				}
				?>
				</select>
			</p>
		</div>




		<table class="list_table">
			<tr>
				<th>PCN#</th>
				<th>PCN Title</th>
				<th><a class="fancybox fancybox.iframe" href="lb_PCN.php" /><img src="../../images/icon_edit.png" alt="Edit" />Platform</a></th>
				<th><a class="fancybox fancybox.iframe" href="lb_PCN.php" /><img src="../../images/icon_edit.png" alt="Edit" />Key Characteristics</a></th>
				<th>Publish Date</th>
				<th>Status</th>
				<th><div class="button14" style="width:50px;" onClick="show_add();">Add</div></th>
			</tr>
			<?php
			if($_GET['sel_type']!=""){
				$selType=filter_var($_GET['sel_type']);
				$Input=filter_var($_GET['sInput']);
				switch ($selType) {
					case "PCN":
					$sql="PCN_Number";
					break;
					case "MN":
					$sql="Marketing_Name";
					break;
					case "PC":
					$sql="Product_Code";
					break;
					case "MM":
					$sql="MM";
					break;
					case "PT":
					$sql="PCN_Title";
					break;
				}
				$str = "SELECT ID, PCN_Title, PCN_Number, Publish_Date, Platform, Marketing_Name, Product_Code, MM, Key_Characteristics, File_URL, Status, C_DATE FROM pcn WHERE ".$sql."='".$Input."' ORDER BY ID DESC limit $start_num,$read_num;";
			}else{
				$str = "SELECT ID, PCN_Title, PCN_Number, Publish_Date, Platform, Marketing_Name, Product_Code, MM, Key_Characteristics, File_URL, Status, C_DATE FROM pcn WHERE 1 ORDER BY ID DESC limit $start_num,$read_num;";
			}
		  $cmd = $pdo->prepare($str);
		  $cmd->execute();
		  while ($data=$cmd->fetch(PDO::FETCH_NUM)) {
		  	if($data[10]==1){
		  		$status="Online";
		  	}else{
		  		$status="Offline";
		  	}

		  	$PlaName_tmp=explode(",", $data[4]);
		  	$PlaName="";
		  	foreach ($PlaName_tmp as $key => $value) {
		  		$PlaName.=$Pla_arr[$value].",";
		  	}
		  	$KCName_tmp=explode(",", $data[8]);
		  	$KCName="";
		  	foreach ($KCName_tmp as $key => $value) {
		  		$KCName.=$KC_arr[$value].",";
		  	}
		  	
		  	echo "<tr>
								<td>".$data[2]."</td>
								<td>".$data[1]."</td>
									<td>".$PlaName."</td>
									<td>".$KCName."</td>
									<td>".$data[3]."</td>
									<td>".$status."</td>
									<td ><a href='?kinds=edit_PNC&mid=".$data[0]."'>Edit</a>&nbsp;&nbsp;<a href='?kinds=delete_PNC&mid=".$data[0]."'>Del</a></td>
							</tr>";
		  }
			?>
		</table>

		<p style="color:#0F0">- List順序: 新至舊</p>

		<p >&nbsp;</p><p >&nbsp;</p>



		<p class="clear">&nbsp;</p>



		<!--Click Add -->							
		<div id="addPCN" class="subsettings" style="display:none">
			<h1>Add a PCN</h1>
			<!--Click close to close this subsettings div--><div class="right"><a href="PCN_mgt.php"> [close] </a></div><!--end of close-->
			<form id="form1" name="form1" method="post" action="?kinds=add_PNC" enctype="multipart/form-data" >
				<table class="addspec">
					<tr>
						<th>PCN Title:  </th>
						<td><input id="add_title" name="add_title" type="text" size="40" value=""  />
						</td>
					</tr>

					<tr>
						<th>PCN Number:  </th>
						<td><input id="add_PN" name="add_PN" type="text" size="40" value=""  />
						</td>
					</tr>
					<tr>
						<th>Publish Date:  </th>
						<td>
							<input id="add_Date" name="add_Date" type="text" size="10" value="" onfocus="HS_setDate(this)" />
						</td>
					</tr>
					<tr>
						<th>Platform:  </th>
						<td>
							<?php
							$str = "SELECT ID, Platform FROM pcn_platform WHERE 1";
						  $cmd = $pdo->prepare($str);
						  $cmd->execute();
						  while ($data=$cmd->fetch(PDO::FETCH_NUM)) {
						  	echo "<input id='add_Pl' name='add_Pl[]' type='checkbox' value='".$data[0]."'> ".$data[1]." &nbsp;&nbsp";
						  }
							?>
						</td>
					</tr>

					<tr>
						<th>Marketing Name / Product Code / MM#:  </th>
						<td>
							<input id="pcnCSV" type='file' name='pcnCSV'>
							<div style="color:#cc0000">(Upload csv file: columns with the order - Marketing Name / Product Code / MM# )</div>
						</td>
					</tr>
					<tr>
						<th>Key Characteristics of the Change:  </th>
						<td>
							<?php
							$str = "SELECT ID, Characteristics FROM pcn_key_characteristics WHERE 1";
						  $cmd = $pdo->prepare($str);
						  $cmd->execute();
						  while ($data=$cmd->fetch(PDO::FETCH_NUM)) {
						  	echo "<input id='add_KC' name='add_KC[]' type='checkbox' value='".$data[0]."'> ".$data[1]." &nbsp;&nbsp";
						  }
							?>
						</td>
					</tr>
					<tr>
						<th>File URL:  </th>
						<td><input id="add_URL" name="add_URL" type="text" size="50" value=""  />
						</td>
					</tr>
					<tr>
						<th>Status:</th>
						<td><select id="add_Status" name="add_Status"><option value="1">Online</option><option value="0">Offline</option></select>
						</td>
					</tr>


					<tr>
						<td colspan="2">
							<input name="Add_Done" id="Add_Done" type="submit" value="Done" />&nbsp;&nbsp;
							<input name="" type="button" value="Cancel" onclick="javascript:self.location='PCN_mgt.php'"/> 
							<span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<!--Click Add End-->				

		<!--Click Edit -->
		<?php
		if($kinds=="edit_PNC"){

		$edit_str = "SELECT ID, PCN_Title, PCN_Number, Publish_Date, Platform, Marketing_Name, Product_Code, MM, Key_Characteristics, File_URL, Status, C_DATE FROM pcn WHERE ID='".$mid."'";
		$cmd_edit = $pdo->prepare($edit_str);
		$cmd_edit->execute();
		$edit_data=$cmd_edit->fetch(PDO::FETCH_NUM);
		?>				
		<div id="editPCN" class="subsettings">
			<h1>Edit a PCN</h1>
			<!--Click close to close this subsettings div--><div class="right"><a href="PCN_mgt.php"> [close] </a></div><!--end of close-->
			<form id="form2" name="form2" method="post" action="?kinds=EditPNC" enctype="multipart/form-data" >

				<table class="editspec">
					<tr>
							<th>PCN Title:  </th>
							<td><input id="edit_title" name="edit_title" type="text" size="40" value="<?=$edit_data[1];?>"  />
							</td>
						</tr>

						<tr>
							<th>PCN Number:  </th>
							<td><input id="edit_PN" name="edit_PN" type="text" size="40" value="<?=$edit_data[2];?>"  />
							</td>
						</tr>
						<tr>
							<th>Publish Date:  </th>
							<td>
								<input id="edit_Date" name="edit_Date" type="text" size="10" value="<?=$edit_data[3];?>" onfocus="HS_setDate(this)" />
							</td>
						</tr>
						<tr>
							<th>Platform:  </th>
							<td>
								<?php
								$str = "SELECT ID, Platform FROM pcn_platform WHERE 1";
							  $cmd = $pdo->prepare($str);
							  $cmd->execute();
							  while ($data=$cmd->fetch(PDO::FETCH_NUM)) {
									if(preg_match("/{$data[0]}/i", $edit_data[4])) {
									  $checked="checked";
									 }else{
									 	$checked="";
									}
							  	echo "<input id='edit_Pl' name='edit_Pl[]' type='checkbox' value='".$data[0]."' ".$checked."> ".$data[1]." &nbsp;&nbsp";
							  }
								?>
							</td>
						</tr>

						<tr>
							<th>Marketing Name / Product Code / MM#:  </th>
							<td>
								<input id="e_pcnCSV" name='e_pcnCSV' type='file' >
								<div style="color:#cc0000">(Upload csv file: columns with the order - Marketing Name / Product Code / MM# )</div>
							</td>
						</tr>
						<tr>
							<th>Key Characteristics of the Change:  </th>
							<td>
								<?php
								$str = "SELECT ID, Characteristics FROM pcn_key_characteristics WHERE 1";
							  $cmd = $pdo->prepare($str);
							  $cmd->execute();
							  while ($data=$cmd->fetch(PDO::FETCH_NUM)) {
							  	if(preg_match("/{$data[0]}/i", $edit_data[8])) {
									  $checked="checked";
									 }else{
									 	$checked="";
									}
							  	echo "<input id='edit_KC' name='edit_KC[]' type='checkbox' value='".$data[0]."' ".$checked."> ".$data[1]." &nbsp;&nbsp";
							  }
								?>
							</td>
						</tr>
						<tr>
							<th>File URL:  </th>
							<td><input id="edit_URL" name="edit_URL" type="text" size="50" value="<?=$edit_data[9];?>"  />
							</td>
						</tr>
						<tr>
							<th>Status:</th>
							<td>
								<select id="edit_Status" name="edit_Status">
									<option value="1" <?php if($edit_data[10]==1){echo "selected";}?> >Online</option>
									<option value="0" <?php if($edit_data[10]==0){echo "selected";}?> >Offline</option>
								</select>
							</td>
						</tr>


						<tr>
							<td colspan="2">
								<input id="edit_ID" name="edit_ID" type="hidden" size="40" value="<?=$edit_data[0];?>"  />
								<input name="edit_Done" id="edit_Done" type="submit" value="Done" />&nbsp;&nbsp;
								<input name="" type="button" value="Cancel" onclick="javascript:self.location='PCN_mgt.php'"/> 
								<span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
							</td>
						</tr>
				</table>
			</form>
		</div>
		<?php
		}
		?>

		<!--Click Edit End-->	

		<p class="clear">&nbsp;</p>

	</div>


	<div id="footer">	Copyright &copy; 2014 Company Co. All rights reserved.
		<div class="gotop" onClick="location='#top'">Top</div>
	</div>

</body>
<script type="text/javascript" src="../../lib/calender.js"></script>
<script type="text/javascript">
function show_add(){
	$("#addPCN").show();
	$("#editPCN").hide();
}

function MM_o(selObj){
  window.open(document.getElementById('PCN_page').options[document.getElementById('PCN_page').selectedIndex].value,"_self");
}

function search(){
	var selType=$("#selType").val();
	var Input=$("#sInput").val();
 	self.location='PCN_mgt.php?sel_type='+selType+'&sInput='+Input;
}


</script>
</html>
<?php
//關閉資料庫
unset($pdo);
?>
