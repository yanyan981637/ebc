<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

@session_start();
if(empty($_SESSION['user']) || empty($_SESSION['password']) || empty($_SESSION['login_time'])){
echo "<script language='JavaScript'>location='../login.php'</script>";
exit();
}
require "../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');

$cid=$_GET['cid'];
$model=$_GET['model'];
$lang=$_GET['lang'];
$typeID=$_GET['type'];

$kind=$_GET['kind'];



if($kind=="upload"){
	$Model_value=$_POST['u_model'];
	$u_cid=$_POST['u_cid'];
	//SYSTEMBOARD
	$str11="SELECT SYSTEMBOARDID,product_skus.MODELCODE as MODEL,STATUS, Remark,product_skus.SKU, Product_SKU_Auto_ID, IS_EOL FROM p_s_main_systemboards " .
	       " INNER JOIN product_skus ON p_s_main_systemboards.MODELCODE = product_skus.MODELCODE" .
	       " WHERE ((MODELNAME like '%".$Model_value."%'  ) OR (Replace(product_skus.MODELCODE,'-','') like '%".str_replace('-','',$Model_value)."%' ) OR product_skus.SKU like '%".str_replace(' ','%',$Model_value)."%' ) AND (LANG = 'en-US') and (product_skus.Web_Disable = 0)" .
	       " ORDER BY Product_SKU_Auto_ID";
	mysqli_query($link_db, 'SET NAMES utf8');
	$cmd11=mysqli_query($link_db,$str11);
	$Data_record11_num=mysqli_num_rows($cmd11);
	if($Data_record11_num==0):
	else:
	$CPUSORT_CHK="MM";
	endif;
	//Serverbarebones
	$str21="SELECT SERVERID, product_skus.MODELCODE as MODEL,STATUS,Remark,product_skus.SKU, Product_SKU_Auto_ID, IS_EOL FROM p_b_main_serverbarebones  " .
	       " INNER JOIN product_skus ON p_b_main_serverbarebones.MODELCODE = product_skus.MODELCODE" .
	       " WHERE ((MODELNAME like '%".$Model_value."%'  ) OR (Replace(product_skus.MODELCODE,'-','') like '%".str_replace('-','',$Model_value)."%' ) OR product_skus.SKU like '%".str_replace(' ','%',$Model_value)."%' ) AND (LANG = 'en-US') and (product_skus.Web_Disable = 0) ORDER BY 1";
	mysqli_query($link_db, 'SET NAMES utf8');
	$cmd21=mysqli_query($link_db,$str21);
	$Data_record21_num=mysqli_num_rows($cmd21);
	if($Data_record21_num==0):
	else:
	$CPUSORT_CHK="BB";
	endif;
	//Panel Pc
	$str31="SELECT PANELPCID, CONCAT(MODELNAME,'(',MODELCODE,')') as MODEL,STATUS,Remark FROM p_b_main_panelpc" .
	      " WHERE ((MODELNAME like '%".$Model_value."%' ) OR (MODELCODE like '%".$Model_value."%')) AND (LANG = 'en-US') ORDER BY 1";
	mysqli_query($link_db, 'SET NAMES utf8');
	$cmd31=mysqli_query($link_db,$str31);
	$Data_record31_num=mysqli_num_rows($cmd31);
	if($Data_record31_num==0):
	else:
	$CPUSORT_CHK="PanelPc";
	endif;
	//Embedded
	$str41="SELECT EMBEDDEDID, CONCAT(MODELNAME,'(',MODELCODE,')') as MODEL,STATUS,Remark FROM p_b_main_embedded" .
	      " WHERE ((MODELNAME like '%".$Model_value."%' ) OR (MODELCODE like '%".$Model_value."%')) AND (LANG = 'en-US') ORDER BY 1";
	mysqli_query($link_db, 'SET NAMES utf8');
	$cmd41=mysqli_query($link_db,$str41);
	$Data_record41_num=mysqli_num_rows($cmd41);
	if($Data_record41_num==0):
	  
	else:
	$CPUSORT_CHK="Embedded";
	endif;
	//Industria MB
	$str51="SELECT INDUSTRIAMBID, CONCAT(MODELNAME,'(',MODELCODE,')') as MODEL,STATUS,Remark FROM p_b_main_industriamb" .
	      " WHERE ((MODELNAME like '%".$Model_value."%' ) OR (MODELCODE like '%".$Model_value."%')) AND (LANG = 'en-US') ORDER BY 1";
	mysqli_query($link_db, 'SET NAMES utf8');
	$cmd51=mysqli_query($link_db,$str51);
	$Data_record51_num=mysqli_num_rows($cmd51);
	if($Data_record51_num==0):
	else:
	$CPUSORT_CHK="IndustriaMB";
	endif;

	//OCP Server
	$str61="SELECT OCPID, CONCAT(MODELNAME,'(',MODELCODE,')') as MODEL,STATUS,Remark FROM p_b_main_ocpserver" .
	      " WHERE ((MODELNAME like '%".$Model_value."%' ) OR (MODELCODE like '%".$Model_value."%')) AND (LANG = 'en-US') ORDER BY 1";
	mysqli_query($link_db, 'SET NAMES utf8');
	$cmd61=mysqli_query($link_db,$str61);
	$Data_record61_num=mysqli_num_rows($cmd61);
	if($Data_record61_num==0):
	else:
	$CPUSORT_CHK="OCPserver";
	endif;

	//OCP Mezz
	$str71="SELECT OCPMezzID, CONCAT(MODELNAME,'(',MODELCODE,')') as MODEL,STATUS,Remark FROM p_b_main_ocpmezz" .
	      " WHERE ((MODELNAME like '%".$Model_value."%' ) OR (MODELCODE like '%".$Model_value."%')) AND (LANG = 'en-US') ORDER BY 1";
	mysqli_query($link_db, 'SET NAMES utf8');
	$cmd71=mysqli_query($link_db,$str71);
	$Data_record71_num=mysqli_num_rows($cmd71);
	if($Data_record71_num==0):
	else:
	$CPUSORT_CHK="OCPMezz";
	endif;

	//POS
	$str81="SELECT POSID, CONCAT(MODELNAME,'(',MODELCODE,')') as MODEL,STATUS,Remark FROM p_b_main_pos" .
	      " WHERE ((MODELNAME like '%".$Model_value."%' ) OR (MODELCODE like '%".$Model_value."%')) AND (LANG = 'en-US') ORDER BY 1";
	mysqli_query($link_db, 'SET NAMES utf8');
	$cmd81=mysqli_query($link_db,$str81);
	$Data_record81_num=mysqli_num_rows($cmd81);
	if($Data_record81_num==0):
	else:
	$CPUSORT_CHK="POS";
	endif;

	//5GEdgeComputing
	$str91="SELECT 5GID, CONCAT(MODELNAME,'(',MODELCODE,')') as MODEL,STATUS,Remark FROM p_b_main_5G" .
	      " WHERE ((MODELNAME like '%".$Model_value."%' ) OR (MODELCODE like '%".$Model_value."%')) AND (LANG = 'en-US') ORDER BY 1";
	mysqli_query($link_db, 'SET NAMES utf8');
	$cmd91=mysqli_query($link_db,$str91);
	$Data_record91_num=mysqli_num_rows($cmd91);
	if($Data_record91_num==0):
	else:
	$CPUSORT_CHK="5GEdgeComputing";
	endif;

	if($CPUSORT_CHK=="MM"){
		$UploadPath = "../../images/systemboards/";
	}else if($CPUSORT_CHK=="BB"){
		$UploadPath = "../../images/serverbarebones/";
	}else if($CPUSORT_CHK=="Chassis"){  
		$UploadPath = "../../images/serverbarebones/";
	}else if($CPUSORT_CHK=="PanelPc"){
		$UploadPath = "../../images/product/PanelPc/";
	}else if($CPUSORT_CHK=="Embedded"){ 
		$UploadPath = "../../images/product/Embedded/";
	}else if($CPUSORT_CHK=="IndustriaMB"){
		$UploadPath = "../../images/product/IndustriaMB/";
	}else if($CPUSORT_CHK=="OCPserver"){
		$UploadPath = "../../images/product/OCPserver/";
	}else if($CPUSORT_CHK=="OCPMezz"){
		$UploadPath = "../../images/product/OCPMezz/";
	}else if($CPUSORT_CHK=="JBOD / JBOF"){
		$UploadPath = "../../images/product/JBODJBOF/";
	}else if($CPUSORT_CHK=="OCP Rack"){
		$UploadPath = "../../images/product/OCPrack/";
	}else if($CPUSORT_CHK=="POS"){
		$UploadPath = "../../images/product/POS/";
	}else if($CPUSORT_CHK=="5GEdgeComputing"){
		$UploadPath = "../../images/product/5G/";
	}

	$str="SELECT `Product_SContents_Auto_ID`, `SKU`, `MODELCODE`, `ProductFile` FROM `contents_product_skus` WHERE `Product_SContents_Auto_ID`='$u_cid'";
	$cmd=mysqli_query($link_db,$str);
	$date=mysqli_fetch_row($cmd);
	if($date[3]==""){
		$tmp_pFile=="";
	}else{
		$tmp_pFile=$date[3].",";
	}

	$fileCount = count($_FILES['my_file']['name']);
	for ($i = 0; $i < $fileCount; $i++) {
  		//檢查檔案是否上傳成功
		if ($_FILES['my_file']['error'][$i] === UPLOAD_ERR_OK){
			echo '檔案名稱: ' . $_FILES['my_file']['name'][$i] . '<br/>';
			echo '檔案類型: ' . $_FILES['my_file']['type'][$i] . '<br/>';
			echo '檔案大小: ' . ($_FILES['my_file']['size'][$i] / 1024) . ' KB<br/>';
			echo '暫存名稱: ' . $_FILES['my_file']['tmp_name'][$i] . '<br/>';

    		//檢查檔案是否已經存在
			if (file_exists('upload/' . $_FILES['my_file']['name'][$i])){
				echo '檔案已存在。<br/>';
			} else {
				$file = $_FILES['my_file']['tmp_name'][$i];
				$dest = $UploadPath.$_FILES['my_file']['name'][$i];

      			//將檔案移至指定位置
				move_uploaded_file($file, $dest);
				$file_name=$_FILES['my_file']['name'][$i];
				$tmp_pFile.=$file_name.",";
				
			}
		} else {
			echo '錯誤代碼：' . $_FILES['my_file']['error'] . '<br/>';
		}
	}

	//chmod($dest,0755);
	$update_str="UPDATE contents_product_skus SET ProductFile='$tmp_pFile' WHERE Product_SContents_Auto_ID='".$u_cid."'";
	$update_cmd=mysqli_query($link_db,$update_str);
}

if($kind=="delete"){
	$d_cid=$_POST['d_cid'];
	$tmp_image=$_POST['d_image'];
	$imageCount = count($_POST['d_image']);

	foreach ($tmp_image as $value) {
		if($value!=""){
			$d_image.=$value.",";
		}
	}
	$d_str="UPDATE contents_product_skus SET ProductFile='$d_image' WHERE Product_SContents_Auto_ID='".$d_cid."'";
	$d_cmd=mysqli_query($link_db,$d_str);
	echo 'Delete image name done!';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Supported Products</title>
<link rel="stylesheet" type="text/css" href="../backend.css">
</head>

<body style="backbround:#f9f9f9">
<h2>Upload multi image:</h2>
<form action="?kind=upload" method="post" enctype="multipart/form-data">
    <!-- 限制上傳檔案的最大值 -->
    <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
    <!-- 使用 html 5 實現單一上傳框可多選檔案方式，須新增 multiple 元素 -->
    <input type="file" name="my_file[]" id="" accept="image/jpeg,image/jpg,image/gif,image/png" multiple>
    <input type="hidden" name="u_cid" id="u_cid" value="<?=$cid;?>">
    <input type="hidden" name="u_model" id="u_model" value="<?=$model;?>">
    <input type="hidden" name="u_typeID" id="u_typeID" value="<?=$typeID;?>">
    <input type="submit" value="上傳檔案">
 </form>
<br><br>
<h2>Delete image name:</h2>
<?php
$str="SELECT `Product_SContents_Auto_ID`, `SKU`, `MODELCODE`, `ProductFile` FROM `contents_product_skus` WHERE `Product_SContents_Auto_ID`='$cid'";
$cmd=mysqli_query($link_db,$str);
?>
<form action="?kind=delete" method="post" enctype="multipart/form-data">
	<?php
	while ($date=mysqli_fetch_row($cmd)) {
		$image_arr=explode(",",$date[3]);
		foreach ($image_arr as $value) {
			if($value!=""){
				echo "<input type='text' name='d_image[]' id='d_image' value=".$value.">";
				echo "<br>";
			}
		}
	}
	?>
	<input type="hidden" name="d_cid" id="d_cid" value="<?=$cid;?>">
    <input type="hidden" name="d_model" id="d_model" value="<?=$model;?>">
    <input type="hidden" name="d_typeID" id="d_typeID" value="<?=$typeID;?>">
	<input type="submit" value="Update">
</form>
</body>
</html>