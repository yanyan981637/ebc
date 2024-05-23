<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

require "../../config.php";
include_once('../../page.class.php');
error_reporting(0);

session_set_cookie_params(8*60*60); 
ini_set('session.gc_maxlifetime', '28800');
@session_start();

if(empty($_SESSION['user']) || empty($_SESSION['password']) || empty($_SESSION['login_time'])){
echo "<script language='JavaScript'>location='../../login.php'</script>";
exit();
}

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');


putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

function dowith_sql($str)
{
  /*$str = str_replace("and","",$str);
  $str = str_replace("execute","",$str);
  $str = str_replace("update","",$str);
  $str = str_replace("count","",$str);
  $str = str_replace("chr","",$str);
  $str = str_replace("mid","",$str);
  $str = str_replace("master","",$str);*/
  $str = str_replace("truncate","",$str);
  //$str = str_replace("char","",$str);
  $str = str_replace("declare","",$str);
  //$str = str_replace("select","",$str);
  //$str = str_replace("create","",$str);
  //$str = str_replace("delete","",$str);
  //$str = str_replace("insert","",$str);
  $str = str_replace("'","&#39;",$str);
  $str = str_replace('"',"&quot;",$str);
//$str = str_replace(".","",$str);
//$str = str_replace("or","",$str);
  $str = str_replace("=","",$str);
  $str = str_replace("?","",$str);
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

if(isset($_GET['act'])!=''){
	$act=trim($_GET['act']);
}else{
	$act="";
}

if($act=="del"){
	$ca_id01=intval($_GET['ca_id']);
	$page01=intval($_GET['page']);
	$str_del="delete from category_module_las where CategoryModuID=".$ca_id01;
	$del_cmd=mysqli_query($link_db,$str_del);
	echo "<script>alert('Delete the data!');self.location='category_module.php?page=".$page01."'</script>";
	exit();
}

if($act=="copy"){
	$ca_id01=intval($_GET['ca_id']);
	$page01=intval($_GET['page']);
	if($page01!=''){
		$page_str="?page=".$page01;
	}else{
		$page_str="";
	}
	$str_copy="insert into category_module_las (CategoryModuName, ProdTypeID, CategIntroduction, urls, GUID, slang, Meta_Des, Prod_Info_Sorting, Status, crea_d, crea_u, upd_d, upd_u, Title, Redirect_URL) SELECT CategoryModuName, ProdTypeID, CategIntroduction, urls, GUID, slang, Meta_Des, Prod_Info_Sorting, Status, crea_d, crea_u, upd_d, upd_u, Title, Redirect_URL from category_module_las where CategoryModuID=".$ca_id01."  limit 1";
	$copy_cmd=mysqli_query($link_db,$str_copy);
	echo "<script>alert('Copy the data!');self.location='category_module.php".$page_str."'</script>";
	exit();
}

if(isset($_GET['kinds'])!=''){
	$kinds=trim($_GET['kinds']);
}else{
	$kinds="";
}

if($kinds=="add_categoryM"){

	$str_n="select CategoryModuID FROM category_module_las order by CategoryModuID desc limit 1";
	$check_n=mysqli_query($link_db,$str_n);
	$Max_MatrixID=mysqli_fetch_row($check_n);
	$MCount=$Max_MatrixID[0]+1;

	if(isset($_POST['CA01'])!=''){
		$CA01=htmlspecialchars($_POST['CA01'], ENT_QUOTES);
	}else{
		$CA01="";
	}
	if(isset($_POST['SEL_APTYPE'])!=''){
		$SEL_APTYPE=str_replace('category_module.php?capt_aid=', '', $_POST['SEL_APTYPE']);
	}else{
		$SEL_APTYPE="";
	}
	if(isset($_POST['SEL_APTYPE_Val'])!=''){
		$SEL_APTYPE_Val=trim($_POST['SEL_APTYPE_Val']);
	}else{
		$SEL_APTYPE_Val="";
	}

	if(isset($_POST['Intro'])!=''){
		$Intro=trim($_POST['Intro']);
		$Intro = str_replace("'","&#39;",$Intro);
  	$Intro = str_replace('"',"&quot;",$Intro);

	}else{
		$Intro="";
	}

	if(isset($_POST['stat01'])!=''){
		$stat01=htmlspecialchars($_POST['stat01'], ENT_QUOTES);
	}else{
		$stat01="";
	}

	$pinfo01="";
	if(isset($_POST['pro_info_Tp'])!=''){

		foreach($_POST['pro_info_Tp'] as $check_pinfo) {
			$pinfo01=$pinfo01.$check_pinfo.",";
		}

	}else{
		$pinfo01='';
	}

	$product_sku=$_POST['relProd_val'];

	$addTitle=addslashes($_POST['CA_Title']);
	//$addTitle = str_replace("'","&#39;",$addTitle);
  //$addTitle = str_replace('"',"&quot;",$addTitle);

	$addR_URL=addslashes($_POST['CA_R_URL']);
	//$addR_URL = str_replace("'","&#39;",$addR_URL);
  //$addR_URL = str_replace('"',"&quot;",$addR_URL);

	$str_type_n1="SELECT ProductTypeID, ProductTypeName FROM producttypes_las where ProductTypeID=".$SEL_APTYPE;
	$type_n1_cmd=mysqli_query($link_db,$str_type_n1);
	$type_n1_data=mysqli_fetch_row($type_n1_cmd);

	if(isset($_POST['MD01'])!=''){
		$MD01=addslashes(trim($_POST['MD01']));
		//$MD01 = str_replace("'","&#39;",$MD01);
  	//$MD01 = str_replace('"',"&quot;",$MD01);
	}else{
	 	$MD01="";
	}

	$str_add="insert into category_module_las (CategoryModuID, CategoryModuName, ProdTypeID, CategIntroduction, slang, Meta_Des, Prod_Info_Sorting, Status, crea_d, crea_u, Models, Redirect_URL, Title) values (".$MCount.",'".$CA01."',".$SEL_APTYPE_Val.",'".$Intro."','".$SEL_LANG."','".$MD01."','".$pinfo01."',".$stat01.",'".$now."','1706','".$product_sku."','".$addTitle."','".$addR_URL."')";
	//echo $str_add;exit();
	$add_cmd=mysqli_query($link_db,$str_add);

	echo "<script>alert('AddNew Category Module!');location.href='category_module.php'</script>";
	exit();

}


if($kinds=="mod_categoryM"){

	$Introm="";$memo_M="";$Top_Block="";$td01="";$Foot_Block="";
	if(isset($_POST['catg_id'])!=''){
		$catg_id=htmlspecialchars($_POST['catg_id'], ENT_QUOTES);
	}else{
		$catg_id="";
	}
	if(isset($_POST['CA01m'])!=''){
		$CA01m=htmlspecialchars($_POST['CA01m'], ENT_QUOTES);
	}else{
		$CA01m="";
	}

	if(isset($_POST['SEL_PTYPEm_Val'])!=''){
		$SEL_PTYPEm=trim($_POST['SEL_PTYPEm_Val']);
	}else{
		$SEL_PTYPEm=str_replace('category_module.php?ca_id=&pt_mid=', '', trim($_POST['SEL_PTYPEm']));
	}

	if(isset($_POST['SEL_LANGm'])!=''){
		$SEL_LANGm=trim($_POST['SEL_LANGm']);
	}else{
		$SEL_LANGm="";
	}



	if(isset($_POST['Introm'])!=''){
		$Introm=addslashes($_POST['Introm']);
		//$Introm=str_replace("'","&#39;",$Introm);
		//$Introm = str_replace('"',"&quot;",$Introm);
	}else{
		$Introm="";
	}

	if(isset($_POST['stat01m'])!=''){
		$stat01m=htmlspecialchars($_POST['stat01m'], ENT_QUOTES);
	}else{
		$stat01m="";
	}

	putenv("TZ=Asia/Taipei");
	$now=date("Y/m/d H:i:s");

	if(isset($_POST['MD01m'])!=''){
		$MD01m=addslashes(trim($_POST['MD01m']));
		//$MD01m = str_replace('"',"&quot;",$MD01m);
	}else{
		$MD01m="";
	}

	$pinfoM01="";
	if(isset($_POST['pro_info_TpM'])!=''){

		foreach($_POST['pro_info_TpM'] as $check_pinfoM) {
			$pinfoM01=$pinfoM01.$check_pinfoM.",";
		}

	}else{
		$pinfoM01='';
	}

	$edit_product_sku=$_POST['relProd_valM'];

	$editTitle=addslashes($_POST['eCA_Title']);
	//$editTitle = str_replace("'","&#39;",$editTitle);
  //$editTitle = str_replace('"',"&quot;",$editTitle);

	$editR_URL=addslashes($_POST['eCA_R_URL']);
	//$editR_URL = str_replace("'","&#39;",$editR_URL);
  //$editR_URL = str_replace('"',"&quot;",$editR_URL);


	$str_upd="update category_module_las set CategoryModuName='".$CA01m."', ProdTypeID=".$SEL_PTYPEm.", CategIntroduction='".$Introm."', slang='".$SEL_LANGm."', Meta_Des='".$MD01m."', Prod_Info_Sorting='".$pinfoM01."', Status=".$stat01m;
	$str_upd.=", upd_d='".$now."', upd_u='1706', Models='".$edit_product_sku."', Redirect_URL='".$editR_URL."', Title='".$editTitle."' where CategoryModuID=".$catg_id;
	$upd_cmd=mysqli_query($link_db,$str_upd);

	echo "<script>alert('Update Category Module!');location.href='category_module.php'</script>";
	exit();
}


$pt_id="";$pt_lang="";
if(isset($_REQUEST['pt_id'])!=''){
 if(trim($_REQUEST['pt_id'])!=''){  
  $pt_id=preg_replace("/['\"\$ \r\n\t;<>\?]/i", '', intval($_REQUEST['pt_id']));
  if($pt_id==0){
  $pt_id="";
  }
 }else{
 $pt_id="";
 }
}else{
$pt_id="";
}

if(isset($_REQUEST['pt_lang'])<>''){
//$pt_lang=eregi_replace("['\"\$ \r\n\t;<>\*%\?]", '', $_REQUEST['pt_lang']);
$pt_lang=preg_replace("/['\"\$ \r\n\t;<>\?]/i", '', trim($_REQUEST['pt_lang']));
}else{
$pt_lang="";
}

if($pt_id<>''){
  if($pt_lang<>''){  
  $str1="select count(*) from category_module_las where ProdTypeID=".$pt_id." and slang='".$pt_lang."'";
  }else{
  $str1="select count(*) from category_module_las where ProdTypeID=".$pt_id;
  }
}else{
  if($pt_lang<>''){
  $str1="select count(*) from category_module_las where slang='".$pt_lang."'";
  }else{
  $str1="select count(*) from category_module_las";
  }
}
  
$list1 =mysqli_query($link_db,$str1);
list($public_count) = mysqli_fetch_row($list1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Website Contents Management - Products Management - Contents: Modules - Category Module </title>
<link rel="stylesheet" type="text/css" href="../../css.css" />
<link rel="stylesheet" type="text/css" href="../../backend.css">
<script type="text/javascript" src="../../jquery.min.js"></script>
<script type="text/javascript" src="jquery.cookie.js"></script>

<script type="text/javascript" src="../../source/jquery.fancybox.js?v=2.0.6"></script>
<link rel="stylesheet" type="text/css" href="../../source/jquery.fancybox.css?v=2.0.6" media="screen" />
<link rel="stylesheet" type="text/css" href="../../source/helpers/jquery.fancybox-buttons.css?v=1.0.2" />
<script type="text/javascript" src="../../source/helpers/jquery.fancybox-buttons.js?v=1.0.2"></script>
<script type="text/javascript" src="../../lib/calender.js"></script>
<script language="JavaScript">
function cookie_val(){
 
 if($.cookie("CA01")!=null){
  document.getElementById("CA01").value=$.cookie("CA01");
 }
 if($.cookie("Intro")!=null){
  document.getElementById("Intro").value=$.cookie("Intro");
 }
 if($.cookie("MD01")!=null){
  document.getElementById("MD01").value=$.cookie("MD01");
 }
 
}
function MM_o(selObj){
window.open(document.getElementById('SEL_PTYPE').options[document.getElementById('SEL_PTYPE').selectedIndex].value,"_self");
}
function MM_LA(selObj){
window.open(document.getElementById('SEL_LANGS').options[document.getElementById('SEL_LANGS').selectedIndex].value,"_self");
}
function MM_PT(selobj){
//alert(document.getElementById('SEL_APTYPE').selectedIndex);
window.open(document.getElementById('SEL_APTYPE').options[document.getElementById('SEL_APTYPE').selectedIndex].value+"#category_module_add","_self");

//var AP01 = document.getElementById('SEL_APTYPE').selectedIndex;
}
function MM_PTm(selobj){
window.open(document.getElementById('SEL_PTYPEm').options[document.getElementById('SEL_PTYPEm').selectedIndex].value+"#category_module_mod","_self");
}

//2017.11.09 add
function select_langA(){
	//var lang = document.getElementById("selectlang").value;
	window.open(document.getElementById('selectlangA').options[document.getElementById('selectlangA').selectedIndex].value+"#category_module_add","_self");
	//document.getElementById('test').value=lang;
}

function select_lang(){
	//var lang = document.getElementById("selectlang").value;
	window.open(document.getElementById('selectlang').options[document.getElementById('selectlang').selectedIndex].value+"#category_module_mod","_self");
	//document.getElementById('test').value=lang;
}
//end

function show_add(){
$("#category_module_add").show();
$("#category_module_mod").hide();
}
function hide_add(){
self.location="category_module.php";
}

function show_edit(){
$("#category_module_mod").show();
$("#category_module_add").hide();
}
function hide_edit(){
self.location="category_module.php";
}

</script>
</head>

<body onload="cookie_val()">
	<a name="top"></a>
	<div >
		<div class="left"><h1>&nbsp;&nbsp;Website Backends - Website Contents Management - Contents: Category Module</h1></div>
		<div id="logout">Hi <?=str_replace("@mic.com.tw", "", $_SESSION['user']);?> <a href="../logo.php">Log out &gt;&gt;</a></div>
	</div>

	<div class="clear"></div>
	<?php
	include("../../menu.php");
	?>
	
	<div class="clear"></div>

	<div id="Search" >
		<h2>Contents &nbsp;&gt;&nbsp;  <a href="../modules.php">Modules</a>  &nbsp;&gt;&nbsp; Category Module</h2> 
	</div>

	<div id="content">
		<br />
		<div class="right">&nbsp; | &nbsp;<a href="pro_type_module.php" />Product Type</a>&nbsp; | &nbsp;<a href="pro_info.php" />Product Info</a>&nbsp; | &nbsp;</div>
		<br />
		<h3>Category Lists:
		</h3>

		<div>
			<div class="pagination left">
				<?php
				if(isset($_GET['pt_lang'])!=''){
					$pt_lang=trim($_GET['pt_lang']);
				}else{
					$pt_lang="";
				}
				?>
				<SELECT id="SEL_PTYPE" name="SEL_PTYPE" onChange="MM_o(this)">
					<option value="category_module.php?pt_id=">All Types</option>
					<?php
					$str_type="select ProductTypeID,ProductTypeName from producttypes_las";
					$type_result=mysqli_query($link_db,$str_type);
					while(list($ProductTypeID,$ProductTypeName)=mysqli_fetch_row($type_result)){
						?>
						<option value="category_module.php?pt_id=<?=$ProductTypeID;?>&pt_lang=<?=$pt_lang;?>" <?php if($pt_id==$ProductTypeID){ echo "selected"; } ?> ><?=$ProductTypeName;?></option>
						<?php
					}
					?>
				</select>&nbsp;&nbsp;

				<select id="SEL_LANGS" onChange="MM_LA(this)">
					<option selected value="category_module.php?pt_id=&pt_lang=">All</option>
					<option value="category_module.php?pt_id=<?=$_GET['pt_id'];?>&pt_lang=EN" <?php if($pt_lang=="EN"){ echo "selected"; }?>>English</option>
					<option value="category_module.php?pt_id=<?=$_GET['pt_id'];?>&pt_lang=JP" <?php if($pt_lang=="JP"){ echo "selected"; }?>>JAPAN</option>
					<option value="category_module.php?pt_id=<?=$_GET['pt_id'];?>&pt_lang=ZH" <?php if($pt_lang=="ZH"){ echo "selected"; }?>>繁體中文</option>
					<option value="category_module.php?pt_id=<?=$_GET['pt_id'];?>&pt_lang=CN" <?php if($pt_lang=="CN"){ echo "selected"; }?>>簡體中文</option>
				</select>&nbsp;&nbsp;&nbsp;&nbsp;
				Total: <span class="w14bblue"><?=$public_count;?></span> records &nbsp;&nbsp;
			</div>
		</div>

		<table class="list_table">
			<tr>
				<th >*Category Name</th><th >Redirect_URL</th><th >*Product Type</th><th>*Language</th><th>*Status</th><th>*Update Date</th><th><div class="button14" style="width:50px;"><a href="#category_module_add" onClick="show_add()">Add</a></div></th>
			</tr>
			<?php
			if(isset($_GET['page'])==""){
				$page="1";
			}else{
				$page=intval($_GET['page']);
			}

			if(empty($page))$page="1";

			$read_num="10";
			$start_num=$read_num*($page-1);			

			if($pt_id<>''){
				if($pt_lang<>''){  
					$str="SELECT CategoryModuID, CategoryModuName, ProdTypeID, CategIntroduction, urls, slang, Meta_Des, Status, upd_d, Redirect_URL, Title, Models FROM category_module_las where ProdTypeID=".$pt_id." and slang='".$pt_lang."' ORDER BY upd_d desc limit $start_num,$read_num;";
				}else{
					$str="SELECT CategoryModuID, CategoryModuName, ProdTypeID, CategIntroduction, urls, slang, Meta_Des, Status, upd_d, Redirect_URL, Title, Models FROM category_module_las where ProdTypeID=".$pt_id." ORDER BY upd_d desc limit $start_num,$read_num;";
				}
			}else{
				if($pt_lang<>''){
					$str="SELECT CategoryModuID, CategoryModuName, ProdTypeID, CategIntroduction, urls, slang, Meta_Des, Status, upd_d, Redirect_URL, Title, Models FROM category_module_las where slang='".$pt_lang."' ORDER BY upd_d desc limit $start_num,$read_num;";
				}else{
					$str="SELECT CategoryModuID, CategoryModuName, ProdTypeID, CategIntroduction, urls, slang, Meta_Des, Status, upd_d, Redirect_URL, Title, Models FROM category_module_las ORDER BY upd_d desc limit $start_num,$read_num;";
				}
			}

			$result=mysqli_query($link_db, $str);
			$i=0;
			while(list($CategoryModuID,$CategoryModuName,$ProdTypeID,$CategIntroduction,$urls,$slang,$Meta_Des,$Web_Disable,$upd_d,$Redirect_URL)=mysqli_fetch_row($result))
			{
				$i=$i+1;
				putenv("TZ=Asia/Taipei");
				if($ProdTypeID==55){
					$url_link="https://datacentersolutions.mitacmct.com/";
				}else{
					$url_link="https://www.mitacmct.com/";
				}
				?>
				<tr>
					<td ><?=$CategoryModuName;?></td>
					<td >
						<a href="<?=$url_link.$Redirect_URL;?>~Landing" target="_blank"><?=$Redirect_URL;?></a>
					</td>
					<td>
					<?php	
					$str1="select ProductTypeName from producttypes_las where ProductTypeID=".$ProdTypeID;
					$result1=mysqli_query($link_db,$str1);
					list($ProductTypeName)=mysqli_fetch_row($result1);
					echo $ProductTypeName;	
					?>
					</td>
					<td><?=$slang;?></td>
					<td>
						<?php
						if($Web_Disable==1){
							echo "Offline";
						}else if($Web_Disable==0){
							echo "Online";
						}
						?>
					</td><td ><?=$upd_d;?></td><td ><a href="?ca_id=<?=$CategoryModuID;?> #category_module_mod">Edit</a>&nbsp;&nbsp;<a href="?act=del&ca_id=<?=$CategoryModuID;?>&page=<?=$_REQUEST['page'];?>" onclick="return confirm('Are you sure you want to delete this item?');">Del</a>&nbsp;&nbsp;<a href="?act=copy&ca_id=<?=$CategoryModuID;?>&page=<?=$_REQUEST['page'];?>">Copy</a></td>
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
		<br />
		<div class="sabrosus"><span class="w14bblue"><?=$read_num?></span> Records Per Page &nbsp;&nbsp;| &nbsp;&nbsp;Page: &nbsp;
			<select id="values_page" name="values_page" onChange="MM_o(this)">
				<?php
				for($j=1;$j<=$total;$j++){
					?>
					<option value="?page=<?=$j?>" <?php if($page==$j){ echo "selected"; } ?>><?=$j?></option>
					<?php
				}
				?>
			</select>&nbsp;&nbsp;
			<?php echo $pagenav;?>
		</div>

		<P style="color:#0F0">**設定 Global Top Menu 下 Products => Product Type 所列的 每個 categories name 以及其 Landing page 上的資料。  這裡所設定的 Category 會在 Create product 時，讓其選擇該 product 是於否會列在這個 category landing page 上。<br />
			** 設定完成一個 Category, 會自動產生一個頁面,  URL 為設定的 Category Name.html ( Category Name 若有空白,()，則以 "_" 底線代替)</p>

		<p >&nbsp;</p><p >&nbsp;</p>
		<p class="clear">&nbsp;</p>


<!--Add category  -->							
<div id="category_module_add" class="subsettings" style="display:none">
	<form id="form1" name="form1" method="post" action="?kinds=add_categoryM" onsubmit="return Final_Check();">
		<h1>Add a Category</h1>
		<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hide_add();"> [close] </a></div><!--end of close-->
		<table class="addspec">
			<tr>
				<th>Product Type:  </th>
				<td>
					<?php
					if(isset($_GET['capt_aid'])!=''){
						$capt_aid=intval($_GET['capt_aid']);
					}else{
						$capt_aid="";
					}
					?>

					<!-- <select id="selectlangA" name="selectlangA" onChange="select_langA(this)">
						<option value="">Select</option>
					</select> -->
					<select id="SEL_APTYPE" name="SEL_APTYPE" onChange="MM_PT(this)">
						<option value="category_module.php?capt_aid=">Select</option>
						<?php
						$str_tp="SELECT ProductTypeID, ProductTypeName FROM producttypes_las WHERE slang = 'EN'";
						$tp_cmd=mysqli_query($link_db,$str_tp);
						while($tpdata=mysqli_fetch_row($tp_cmd)){
						?>
						<option value="category_module.php?capt_aid=<?=$tpdata[0];?>" <?php if($capt_aid==$tpdata[0]){ echo "selected"; } ?>><?=$tpdata[1];?></option>
						<?php
						}
						?>
					</select>
					<input name="SEL_APTYPE_Val" type="hidden" value="<?=$capt_aid;?>">

					<span style="color:#0F0">Product Type 下拉選單，列出 module => Product Type 裏設定的 Product Types</span>
				</td>
			</tr>
			<tr>
				<th>Category Name:  </th>
				<td><input id="CA01" name="CA01" type="text" size="40" value="" /><span style="color:#0F0">允許輸入 (), 空白, -, /</span>
				</td>
			</tr>
			<tr>
				<th>Title:  </th>
				<td><input id="CA_Title" name="CA_Title" type="text" value="" />
				</td>
			</tr>
			<tr>
				<th>Redirect URL:  </th>
				<td><input id="CA_R_URL" name="CA_R_URL" type="text" value="" />
				</td>
			</tr>
			
			<tr>
				<th>Languages:</th>
				<td>
					<?php
					if(isset($_GET['capt_lang'])!=''){
						$capt_lang=trim($_GET['capt_lang']);
					}else{
						$capt_lang="";
					}
					?>
					<select id="SEL_LANG" name="SEL_LANG">
						<option value="EN" <?php if($capt_lang=='EN'){ echo "selected"; }?>>English</option>
						<option value="CN" <?php if($capt_lang=='CN'){ echo "selected"; }?>>簡體</option>
						<option value="ZH" <?php if($capt_lang=='ZH'){ echo "selected"; }?>>繁體</option>
						<option value="JP" <?php if($capt_lang=='JP'){ echo "selected"; }?>>日文</option>
					</select>
				</td>
			</tr>
			<tr>
				<th>Introduction: </th>
				<td><textarea id="Intro" name="Intro" rows="4" cols="50" style="max-width: 250px; max-height: 250px;"></textarea>
					<p style="color:#c00">** Alow HTML code</p>
				</td>
			</tr>
			<tr>
				<th>Sorting conditions:  </th>
				<td>
					<?php
					if(isset($_REQUEST['capt_lang'])!=''){
						$capt_lang=trim($_REQUEST['capt_lang']);
					}else{
						$capt_lang="";
					}

					if($capt_lang!=''){
						$str_pinfo="SELECT PI_id, PI_Name, slang, PI_Value, PTYPE_Value, Sorts FROM product_info_las where instr(concat(',',PTYPE_Value), concat(',','$capt_aid',','))>0 and slang='".$capt_lang."'";
					}else{
						$str_pinfo="SELECT PI_id, PI_Name, slang, PI_Value, PTYPE_Value, Sorts FROM product_info_las where instr(concat(',',PTYPE_Value), concat(',','$capt_aid',','))>0";
					}
					$pinfo_result=mysqli_query($link_db, $str_pinfo);
					while(list($PI_id,$PI_Name,$slang,$PI_Value,$PTYPE_Value,$Sorts)=mysqli_fetch_row($pinfo_result))      
					{
						?>
						<input name="pro_info_Tp[]" type="checkbox" value="<?=$PI_id;?>"  /> <?=$PI_Name;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?php
					}
					?>
					<p style="color:#0F0">**列出該語言在 Contents  >  Modules  >  Product Info 中該語言，上面所選擇的 Product Type 下，被套用到的所有 "Info Name"。這裏勾選的 Info Name 會在前端網頁上的 Sorting 下拉選單中出現。</p>
				</td>
			</tr>
			<tr>
			<th>Products:</th>
			<td><div class="button14" style="width:60px;" ><a class="fancybox fancybox.iframe" href="../lb_category_mo.php?ca_id=<?=$capt_aid;?>" style="color:#ffffff">Edit</a></div>
			 <!--列出被勾選的Products-->
			 <textarea id="relProd_val" name="relProd_val" rows="5" cols="80" style="border: none;max-width: 800px; max-height: 200px;" readonly></textarea>
			 <p><span id="relProd"></span></p></td>
			</tr>
			<tr class="sockettype_A" style="display:none">
				<th>Socket Type:  </th>
				<td>
					<select id="SEL_SKType" name="SEL_SKType">
						<option value="">-- Selected --</option>
						<?php
						$str_SKType="SELECT SOCKETID, SOCKETNAME, STATUS FROM c_s_socket WHERE STATUS='1'";
						$SKType_cmd=mysqli_query($link_db,$str_SKType);
						while($SKType_data=mysqli_fetch_row($SKType_cmd)){
							?>
							<option value="<?=$SKType_data[0];?>"><?=$SKType_data[1];?></option>
							<?php
						}
						?>
					</select>
				</td>
			</tr>
			<tr class="chipset_A" style="display:none">
				<th>Chipset:  </th>
				<td>
					<?php
					$br02="";
					$str_Chipsets="SELECT CHIPSETID, CHIPSETNAME, STATUS FROM c_s_chipset WHERE STATUS='1'";
					$Chipsets_cmd=mysqli_query($link_db,$str_Chipsets);
					while($Chipsets_data=mysqli_fetch_row($Chipsets_cmd)){
						$chi+=1;
						if($chi%3==0){
							$br02="<br />";
						}else{
							$br02="";
						}  
						?>
						<input name="chipset_Vals_Set[]" type="checkbox" value="<?=$Chipsets_data[0];?>" />&nbsp;<?=$Chipsets_data[1];?>&nbsp;<?=$br02;?>
						<?php
					}
					?>
				</td>
			</tr>
			<tr class="sockets_A" style="display:none">
				<th>Sockets:  </th>
				<td>
					<select id="SEL_Sockets" name="SEL_Sockets">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
					</select>
				</td>
			</tr>
			<tr class="cpu_A" style="display:none">
				<th>CPU:  </th>
				<td>
					<select id="SEL_CPUid" name="SEL_CPUid">
						<?php
						$str_cpuid="SELECT CPUID, CPUNAME, STATUS FROM c_s_cpu where STATUS='1'";
						$cpuid_cmd=mysqli_query($link_db,$str_cpuid);
						while($cpuid_data=mysqli_fetch_row($cpuid_cmd)){
							?>
							<option value="<?=$cpuid_data[0];?>"><?=$cpuid_data[1];?></option>
							<?php
						}
						?>
					</select>
				</td>
			</tr>
			<tr class="cputype_A" style="display:none">
				<th>CPUtype:  </th>
				<td>
					<select id="SEL_cputype" name="SEL_cputype">
						<?php
						$str_cputype="SELECT CPUTYPEID, CPUTYPE, STATUS FROM c_b_cputype where STATUS=1";
						$cputype_cmd=mysqli_query($link_db,$str_cputype);
						while($cputype_data=mysqli_fetch_row($cputype_cmd)){
							?>
							<option value="<?=$cputype_data[0];?>"><?=$cputype_data[1];?></option>
							<?php
						}
						?>
					</select>
				</td>
			</tr>

			<tr class="rackmount_A" style="display:none">
				<th>RACKMOUNT:  </th>
				<td>
					<input name="rackmount_Vals_Set[]" type="checkbox" value="1" />&nbsp;1&nbsp;
					<input name="rackmount_Vals_Set[]" type="checkbox" value="2" />&nbsp;2&nbsp;
					<input name="rackmount_Vals_Set[]" type="checkbox" value="3" />&nbsp;3&nbsp;
					<input name="rackmount_Vals_Set[]" type="checkbox" value="4" />&nbsp;4&nbsp;
					<input name="rackmount_Vals_Set[]" type="checkbox" value="5" />&nbsp;5&nbsp;
				</td>
			</tr>
			<tr>
				<th>Status:</th>
				<td>
					<select id="stat01" name="stat01">
						<option value="0" selected>Online</option>
						<option value="1">Offline</option>
					</select><span style="color:#0F0">**設定此 Category 是否會出現在 top drop mega menu 上</span>
				</td>
			</tr>
			<tr>
				<th>&#65124;Meta description&#65125;:</th>
				<td><textarea id="MD01" name="MD01" rows="6" cols="80" style="max-width: 250px; max-height: 250px;"></textarea>
					<span style="color:#0F0">**設定此 Category Product List 頁的html Meta description的值 (for SEO)</span>
				</td>
			</tr>

			<tr><td colspan="2">
				<input class="button14" style="width:60px;" type="submit" value="Done" />&nbsp;&nbsp;<input class="button14" style="width:75px;" name="C1" type="button" value="Cancel" onclick="javascript:self.location='category_module.php'" /> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
			</td></tr>
		</table>
	</form>

</div>
<!--Add category END -->							


<?php
if(isset($_GET['ca_id'])<>""){
	$ca_id01=intval($_GET['ca_id']);
	$str_m="SELECT CategoryModuID, CategoryModuName, ProdTypeID, CategIntroduction, slang, Meta_Des, Prod_Info_Sorting, Status, Redirect_URL, Title, Models FROM category_module_las where CategoryModuID=".$ca_id01;
	$mcmd=mysqli_query($link_db,$str_m);
	$mdata=mysqli_fetch_row($mcmd);
	if($_GET['pt_mid']!=""){
		$pt_mid=intval($_GET['pt_mid']);
	}else{		
		$pt_mid=$mdata[2];
	}
	?>
	<div id="category_module_mod" class="subsettings" style="display:none">
		<form id="form2" name="form2" method="post" action="?kinds=mod_categoryM" onsubmit="return Final_MCheck();">
			<h1>Edit a Category</h1>
			<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hide_edit();"> [close] </a></div><!--end of close-->
			<table class="addspec">
				<input id="ca_id01" name="ca_id01" type="hidden" value="<?=$ca_id01?>">
				<tr>
					<th>Product Type:  </th>
					<td>
						
						<select id="SEL_PTYPEm" name="SEL_PTYPEm" onChange="MM_PTm(this)">
							<option value="category_module.php?pt_mid=">Select</option>
							<?php
							$str_tp="SELECT ProductTypeID, ProductTypeName FROM producttypes_las WHERE 1";
							$tp_cmd=mysqli_query($link_db,$str_tp);
							while($tpdata=mysqli_fetch_row($tp_cmd)){
								if($mdata[2]==$tpdata[0]){
									$tpdata_id=$tpdata[0];
								}

							?>
							<option value="category_module.php?ca_id=<?=$ca_id01;?>&pt_mid=<?=$tpdata[0];?>" 
							<?php
							if(isset($_REQUEST['pt_mid'])<>""){
								if($_REQUEST['pt_mid']==$tpdata[0]){ echo "selected"; } 
							}else{
								if($mdata[2]==$tpdata[0]){ echo "selected"; } 
							}
							?> ><?=$tpdata[1];?></option>
							<?php
							}
							?>
						</select>
					<?php
						if(isset($_REQUEST["pt_mid"])<>''){
							$SEL_PTYPEm_Val01=$_REQUEST["pt_mid"];
						}else{
							$SEL_PTYPEm_Val01=$tpdata_id;
						}
						?>
						<input name="SEL_PTYPEm_Val" type="hidden" value="<?=$SEL_PTYPEm_Val01;?>">
						<span style="color:#0F0">Product Type 下拉選單，列出 module => Product Type 裏設定的 Product Types</span>
					</td>
				</tr>
				<tr>
					<th>Category Name:  </th>
					<td><input id="CA01m" name="CA01m" type="text" size="40" value="<?=$mdata[1];?>" /><span style="color:#0F0">允許輸入 (), 空白, -, /</span>
					</td>
				</tr>


				<tr>
					<th>Title:  </th>
					<td><input id="eCA_Title" name="eCA_Title" type="text" value="<?=$mdata[9]?>" />
					</td>
				</tr>
				<tr>
					<th>Redirect URL:  </th>
					<td><input id="eCA_R_URL" name="eCA_R_URL" type="text" value="<?=$mdata[8]?>" />
					</td>
				</tr>

				<tr>
					<th>Languages:</th>
					<td>
						<select id="SEL_LANGm" name="SEL_LANGm">
							<option value="EN" <?php if($mdata[4]=="EN"){ echo "selected"; } ?>>English</option>
							<option value="CN" <?php if($mdata[4]=="CN"){ echo "selected"; } ?>>簡體</option>
							<option value="ZH" <?php if($mdata[4]=="ZH"){ echo "selected"; } ?>>繁體</option>
							<option value="JP" <?php if($mdata[4]=="JP"){ echo "selected"; } ?>>日文</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>Introduction: </th>
					<td><textarea id="Introm" name="Introm" rows="4" cols="50" style="max-width: 250px; max-height: 250px;"><?=$mdata[3];?></textarea>
						<p style="color:#c00">** Alow HTML code</p>
					</td>
				</tr>
				<tr>
					<th>Sorting conditions:  </th>
					<td>
						<?php
						$str_pinfo="SELECT PI_id, PI_Name, slang, PI_Value, PTYPE_Value, Sorts FROM product_info_las where instr(concat(',',PTYPE_Value), concat(',','$pt_mid',','))>0";
						$pinfo_result=mysqli_query($link_db, $str_pinfo);
						while(list($PI_id,$PI_Name,$slang,$PI_Value,$PTYPE_Value,$Sorts)=mysqli_fetch_row($pinfo_result))      
						{
							?>
							<input name="pro_info_TpM[]" type="checkbox" value="<?=$PI_id;?>" <?php if(strpos($mdata[6],$PI_id.",")!='' || strpos($mdata[6],$PI_id.",")===0){ echo "checked"; } //if(eregi($mdata[6],$PTYPE_Value)!=''){ echo "checked"; } ?>  /> <?=$PI_Name;?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<?php
						}
						?>

						<p style="color:#0F0">**列出該語言在 Contents  >  Modules  >  Product Info 中該語言，上面所選擇的 Product Type 下，被套用到的所有 "Info Name"。這裏勾選的 Info Name 會在前端網頁上的 Sorting 下拉選單中出現。</p>
					</td>
				</tr>
				<tr>
					<th>Products:</th>
					<td><div class="button14" style="width:60px;" ><a class="fancybox fancybox.iframe" href="../elb_category_mo.php?ca_id=<?=$ca_id01;?>&pt_mid=<?=$pt_mid;?>" style="color:#ffffff">Edit</a></div>
						<!--列出被勾選的Products-->
						<textarea id="relProd_valM" name="relProd_valM" rows="5" cols="80" style="border: none;max-width: 800px; max-height: 200px;" readonly><?=$mdata[10];?></textarea>
						<p><span id="relProd"></span></p></td>
					</tr>
					<tr class="sockettype_A" style="display:none">
						<th>Socket Type:  </th>
						<td>
							<select id="SEL_SKType01m" name="SEL_SKType01m">
								<option value="">-- Selected --</option>
								<?php
								$str_SKType="SELECT SOCKETID, SOCKETNAME, STATUS FROM c_s_socket WHERE STATUS='1'";
								$SKType_cmd=mysqli_query($link_db,$str_SKType);
								while($SKType_data=mysqli_fetch_row($SKType_cmd)){
									?>
									<option value="<?=$SKType_data[0];?>"><?=$SKType_data[1];?></option>
									<?php
								}
								?>
							</select>
						</td>
					</tr>
					<tr class="chipset_A" style="display:none">
						<th>Chipset:  </th>
						<td>
							<?php
							$br02="";
							$str_Chipsets="SELECT CHIPSETID, CHIPSETNAME, STATUS FROM c_s_chipset WHERE STATUS='1'";
							$Chipsets_cmd=mysqli_query($link_db,$str_Chipsets);
							while($Chipsets_data=mysqli_fetch_row($Chipsets_cmd)){
								$chi+=1;
								if($chi%3==0){
									$br02="<br />";
								}else{
									$br02="";
								}  
								?>
								<input name="chipset_Vals_Set[]" type="checkbox" value="<?=$Chipsets_data[0];?>" />&nbsp;<?=$Chipsets_data[1];?>&nbsp;<?=$br02;?>
								<?php
							}
							?>
						</td>
					</tr>
					<tr class="sockets_A" style="display:none">
						<th>Sockets:  </th>
						<td>
							<select id="SEL_Sockets01m" name="SEL_Sockets01m">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
							</select>
						</td>
					</tr>
					<tr class="cpu_A" style="display:none">
						<th>CPU:  </th>
						<td>
							<select id="SEL_CPUid01m" name="SEL_CPUid01m">
								<?php
								$str_cpuid="SELECT CPUID, CPUNAME, STATUS FROM c_s_cpu where STATUS='1'";
								$cpuid_cmd=mysqli_query($link_db,$str_cpuid);
								while($cpuid_data=mysqli_fetch_row($cpuid_cmd)){
									?>
									<option value="<?=$cpuid_data[0];?>"><?=$cpuid_data[1];?></option>
									<?php
								}
								?>
							</select>
						</td>
					</tr>
					<tr class="cputype_A" style="display:none">
						<th>CPUtype:  </th>
						<td>
							<select id="SEL_cputype01m" name="SEL_cputype01m">
								<?php
								$str_cputype="SELECT CPUTYPEID, CPUTYPE, STATUS FROM c_b_cputype where STATUS=1";
								$cputype_cmd=mysqli_query($link_db,$str_cputype);
								while($cputype_data=mysqli_fetch_row($cputype_cmd)){
									?>
									<option value="<?=$cputype_data[0];?>"><?=$cputype_data[1];?></option>
									<?php
								}
								?>
							</select>
						</td>
					</tr>

					<tr class="rackmount_A" style="display:none">
						<th>RACKMOUNT:  </th>
						<td>
							<input name="rackmount_Vals_Set[]" type="checkbox" value="1" />&nbsp;1&nbsp;
							<input name="rackmount_Vals_Set[]" type="checkbox" value="2" />&nbsp;2&nbsp;
							<input name="rackmount_Vals_Set[]" type="checkbox" value="3" />&nbsp;3&nbsp;
							<input name="rackmount_Vals_Set[]" type="checkbox" value="4" />&nbsp;4&nbsp;
							<input name="rackmount_Vals_Set[]" type="checkbox" value="5" />&nbsp;5&nbsp;
						</td>
					</tr>
					<tr>
						<th>Status:</th>
						<td>
							<select id="stat01m" name="stat01m">
								<option value="0" <?php if($mdata[7]==0){ echo "selected"; } ?>>Online</option>
								<option value="1" <?php if($mdata[7]==1){ echo "selected"; } ?>>Offline</option>
								<span style="color:#0F0">**設定此 Category 是否會出現在 top drop mega menu 上</span>
							</td>
						</tr>
						<tr>
							<th>&#65124;Meta description&#65125;:</th>
							<td><textarea id="MD01m" name="MD01m" rows="6" cols="80" style="max-width: 250px; max-height: 250px;"><?=$mdata[5];?></textarea>

								<span style="color:#0F0">**設定此 Category Product List 頁的html Meta description的值 (for SEO)</span>
							</td>
						</tr>

						<tr><td colspan="2">
							<input name="catg_id" type="hidden" value="<?=$mdata[0];?>"><input class="button14" style="width:60px;" type="submit" value="Done" />&nbsp;&nbsp;<input class="button14" style="width:75px;" name="C2" type="button" value="Cancel" onclick="javascript:locat.href='category_module.php'" /> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
						</td></tr>
					</table>
				</form>

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
CKEDITOR.replace( 'Intro', {
});
</script>
<script>
CKEDITOR.replace( 'Introm', {
});
</script>

<script language="JavaScript">
function Final_Check( ) {

	if(document.form1.CA01.value == ""){
		alert("請輸入 Category Name！");
		document.form1.CA01.focus();
		return false;
	}

	if(document.form1.SEL_APTYPE.value == "" || document.form1.SEL_APTYPE.value == "category_module.php?capt_aid="){
		alert("請選擇 Product Type！");
		document.form1.SEL_APTYPE.focus();
		return false;
	}

	if(document.form1.SEL_LANG.value == "") {
		alert ("請選擇 Languages！");
		document.form1.SEL_LANG.focus();
		return false;
	}
	return true;
}


function Final_MCheck( ) {

	if(document.form2.CA01m.value == ""){
		alert("請輸入 Category Name！");
		document.form2.CA01m.focus();
		return false;
	}

	if(document.form2.SEL_PTYPEm.value == ""){
		alert("請選擇 Product Type！");
		document.form2.SEL_PTYPEm.focus();
		return false;
	}

	if(document.form2.SEL_LANGm.value == "") {
		alert ("請選擇 Languages！");
		document.form2.SEL_LANGm.focus();
		return false;
	}

	return true;
}
</script>
</script>
</body>
</html>
<?php
if(isset($_REQUEST['ca_id'])<>""){
	echo "<script language='Javascript'>show_edit();</script>\n";
	exit();
}
if(isset($_REQUEST['capt_aid'])<>""){
	echo "<script language='Javascript'>show_add();</script>\n";
	exit();
}

$link_db->close();
?>