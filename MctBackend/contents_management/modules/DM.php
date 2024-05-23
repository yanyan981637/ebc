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

function dowith_sql($str){
	//$str = str_replace("and","",$str);
	$str = str_replace("execute","",$str);
	$str = str_replace("update","",$str);
	$str = str_replace("count","",$str);
	$str = str_replace("chr","",$str);
	$str = str_replace("<script>","",$str);
	$str = str_replace("</script>","",$str);
	$str = str_replace("javascript","",$str);
	$str = str_replace("mid","",$str);
	$str = str_replace("master","",$str);
	$str = str_replace("truncate","",$str);
	$str = str_replace("char","",$str);
	$str = str_replace("declare","",$str);
	$str = str_replace("select","",$str);
	$str = str_replace("create","",$str);
	$str = str_replace("delete","",$str);
	$str = str_replace("insert","",$str);
	$str = str_replace("'","",$str);
	$str = str_replace('"',"",$str);
//$str = str_replace("or","",$str); //2017.05.23 因舊資料SKU關係, 暫時註解
	$str = str_replace("=","",$str);
	return $str;
}


$str1="SELECT count(a.ID) FROM eDM a";
//echo $str1;
$list1 =mysqli_query($link_db,$str1);
list($public_count) = mysqli_fetch_row($list1);

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

if($_GET['kinds']=='add_EDM'){
	$eName=dowith_sql($_POST['eName']);
	$ePos=dowith_sql($_POST['ePos']);
	$eDes=dowith_sql($_POST['eDes']);
	$eURL=dowith_sql($_POST['eURL']);
	$eStatus=dowith_sql($_POST['eStatus']);
	$eorder=dowith_sql($_POST['eorder']);

	if($_FILES['eProFile']['name']!=''){
		$eImage=trim($_FILES['eProFile']['name']);
		$UploadPath = "../../../images/catalog/";
    $flag = copy($_FILES['eProFile']['tmp_name'], $UploadPath.$_FILES['eProFile']['name']);  
	}else{
		$eImage="";
	}

	$insert="INSERT INTO eDM (Name, Position, Description, Image, URL, Status, DMOrder, C_DATE) VALUES ('".$eName."','".$ePos."','".$eDes."','".$eImage."','".$eURL."','".$eStatus."','".$eorder."','".$now."')";
	mysqli_query($link_db,$insert);
	echo "<script language='JavaScript'>alert('Add a EDM !');self.location='DM.php'</script>";
	exit();
}

if($_GET['kinds']=='edit_EDM'){
	$e_eID=dowith_sql($_POST['e_eID']);
	$e_eName=dowith_sql($_POST['e_eName']);
	$e_ePos=dowith_sql($_POST['e_ePos']);
	$e_eDes=dowith_sql($_POST['e_eDes']);
	$e_eImage=dowith_sql($_POST['e_eImage']);
	$e_eURL=dowith_sql($_POST['e_eURL']);
	$e_eStatus=dowith_sql($_POST['e_eStatus']);
	$e_eorder=dowith_sql($_POST['e_eorder']);


	if($_FILES['e_eProFile']['name']!=''){
		$e_eImage=trim($_FILES['e_eProFile']['name']);
		$UploadPath = "../../../images/catalog/";
    $flag = copy($_FILES['e_eProFile']['tmp_name'], $UploadPath.$_FILES['e_eProFile']['name']);  
	}else{
		$e_eImage=dowith_sql($_POST['e_eImage']);
	}
	

	$update="UPDATE eDM SET Name='".$e_eName."', Position='".$e_ePos."', Description='".$e_eDes."', Image='".$e_eImage."', URL='".$e_eURL."', Status='".$e_eStatus."', DMOrder='".$e_eorder."', U_DATE='".$now."' WHERE ID='".$e_eID."' ";
	mysqli_query($link_db,$update);
	echo "<script language='JavaScript'>alert('Update a EDM !');self.location='DM.php'</script>";
	exit();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>MCT Website Contents Management - Products Management - Contents: Modules - Catalog Page Module </title>
	<link rel=stylesheet type="text/css" href="../../backend.css">
	<script type="text/javascript" src="../../lib/jquery-1.7.2.min.js"></script>

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
		<h2>Contents &nbsp;&gt;&nbsp;  <a href="../modules.php">Modules</a>  &nbsp;&gt;&nbsp; eDM management</h2> 
	</div>

	<div id="content">

		<br />

		<h3>eDM Lists:
		</h3>


		<div class="pagination left">

			Total: <span class="w14bblue"><?=$public_count?></span> records 
		</div>

		<table class="list_table">

			<tr>
				<th>Name</th>
				<th>Position</th>
				<th>Description</th>
				<th>Date Created</th>
				<th>Status</th>
				<th><div class="button14" style="width:50px;" onClick="show_add();">Add</div></th>
			</tr>
			<?php
			$strList="SELECT ID, Name, Position, Description, Status, C_DATE FROM eDM WHERE 1";
			$cmdList=mysqli_query($link_db, $strList);
			while($data=mysqli_fetch_row($cmdList)){
				$time=explode(" ", $data[5]);
				if($data[4]==0){
					$status="Online";
				}else{
					$status="Offline";
				}
				
			?>
			<tr>
				<td><?=$data[1]?></td>
				<td><?=$data[2]?></td>
				<td><?=$data[3]?></td>
				<td><?=$time[0]?></td>
				<td><?=$status?></td>
				<td>
					<a href="?kinds=edit_showEDM&ID=<?=$data[0]?>">Edit</a>&nbsp;&nbsp;
					<a href="?kinds=del_EDM&ID=<?=$data[0]?>">Del</a>
				</td>
			</tr>
			<?php
			}
				
			?>
			
		</table>



		<p >&nbsp;</p><p >&nbsp;</p>
		<P style="color:#0F0">
			- click "Del" 要popup a confirmation window to proceed<br />- List順序: 新至舊<
		</p>



		<p class="clear">&nbsp;</p>



		<!--Click add -->
		<form id="form1" name="form1" method="post" action="?kinds=add_EDM" enctype="multipart/form-data">
	
			<div id="eDM_add" class="subsettings" style="display:none">
				<h1>Add an eDM</h1>
				<!--Click close to close this subsettings div--><div class="right"><a href=""> [close] </a></div><!--end of close-->
				<table class="addspec">
					<tr>
						<th>Name:  </th>
						<td><input id="eName" name="eName" type="text" size="40" value=""  />
						</td>
					</tr>
					<tr>
						<th>Position:</th>
						<td>
							<select id="ePos" name="ePos">
								<option selected>Select...</option>
								<option value="Embedded">Embedded (with checkbox for newsletter subscription)</option>
								<option value="Enterprise">Enterprise</option>
							</select>
						</td>
					</tr>
					<tr>
						<th>Description: </th>
						<td><input id="eDes" name="eDes" type="text" size="100" value=""  /></td>
					</tr>
					<tr>
						<th>Cover image upload:</th>
						<td>
							<input id="eImage" name="eImage" type="text" size="40" value=""  /> 
							<input name="eProFile"  type="file" value="Browse" />
						</td>
					</tr>
					<tr>
						<th>Download URL:</th>
						<td><input id="eURL" name="eURL" type="text" size="60" value=""  />
						</td>
					</tr>

					<tr>
						<th>Status:</th>
						<td><select id="eStatus"  name="eStatus"><option value="0" selected="selected">Online</option><option value="1">Offline</option></select>
						</td>
					</tr>
					<tr>
						<th>EDM Order:</th>
						<td>
							<input id="eorder" name="eorder" type="text" value=""  />
						</td><span style="color:#0F0">數字越小排序越前面</span>
					</tr>
					<tr><td colspan="2">
						<input name="add" type="submit" value="Done" />&nbsp;&nbsp;<input name="" type="button" value="Cancel" /> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
					</td></tr>
				</table>
			</div>
		</form>

		<!--Click add end-->							
		<!--Click Edit -->		
		<?php
		if($_GET['kinds']=='edit_showEDM'){
			$editID=$_GET['ID'];
			$e_str="SELECT ID, Name, Position, Description, Image, URL, Status, DMOrder FROM eDM WHERE ID='".$editID."'";
			$e_cmd=mysqli_query($link_db, $e_str);
			$e_data=mysqli_fetch_row($e_cmd);
		?>
		<form id="form1" name="form1" method="post" action="?kinds=edit_EDM" enctype="multipart/form-data">

			<div id="eDM_edit" class="subsettings">
				<h1>Edit an eDM</h1>
				<!--Click close to close this subsettings div--><div class="right"><a href=""> [close] </a></div><!--end of close-->
				<table class="editspec">
						<input id="e_eID" name="e_eID" type="hidden" size="40" value="<?=$e_data[0]?>"  />
						<tr>
							<th>Name:  </th>
							<td><input id="e_eName" name="e_eName" type="text" size="40" value="<?=$e_data[1]?>"  />
							</td>
						</tr>
						<tr>
							<th>Position:</th>
							<td>
								<select id="e_ePos" name="e_ePos">
									<option selected>Select...</option>
									<option value="Embedded" <?php if($e_data[2]=="Embedded"){echo "selected";}?> >Embedded (with checkbox for newsletter subscription)</option>
									<option value="Enterprise" <?php if($e_data[2]=="Enterprise"){echo "selected";}?> >Enterprise</option>
								</select>
							</td>
						</tr>
						<tr>
							<th>Description: </th>
							<td><input id="e_eDes" name="e_eDes" type="text" size="100" value="<?=$e_data[3]?>"  /></td>
						</tr>
						<tr>
							<th>Cover image upload:</th>
							<td>
								<input id="e_eImage" name="e_eImage" type="text" size="40" value="<?=$e_data[4]?>"  />
								<input name="e_eProFile"  type="file" value="Browse" />
							</td>
						</tr>
						<tr>
							<th>Download URL:</th>
							<td><input id="e_eURL" name="e_eURL" type="text" size="60" value="<?=$e_data[5]?>"  />
							</td>
						</tr>

						<tr>
							<th>Status:</th>
							<td>
								<select id="e_eStatus" name="e_eStatus">
									<option value="0" <?php if($e_data[6]=="0"){echo "selected";}?> >Online</option>
									<option value="1" <?php if($e_data[6]=="1"){echo "selected";}?> >Offline</option>
								</select>
							</td>
						</tr>
						<tr>
						<th>EDM Order:</th>
						<td>
							<input id="e_eorder" name="e_eorder" type="text" value="<?=$e_data[7]?>"  />
						</td><span style="color:#0F0">數字越小排序越前面</span>
					</tr>
						<tr><td colspan="2">
							<input name="edit" type="submit" value="Done" />&nbsp;&nbsp;<input name="" type="button" value="Cancel" /> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
						</td></tr>
					</table>
			</div>
		</form> 	
		<?php
		}
		?>					
		<!--Click Edit end-->		

		<p class="clear">&nbsp;</p>

	</div>


	<div id="footer">	Copyright &copy; 2014 Company Co. All rights reserved.
		<div class="gotop" onClick="location='#top'">Top</div>



	</div>

</body>

<script type="text/javascript">
function show_add(){
	$("#eDM_add").show();
	$("#eDM_edit").hide();
}	
</script>
</html>
<?php
mysqli_Close($link_db);
?>
