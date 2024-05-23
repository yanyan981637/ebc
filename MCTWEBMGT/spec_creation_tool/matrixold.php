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
include_once('../page.class.php');
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);

if(isset($_REQUEST['d_id'])!="")
{
$d1=intval($_REQUEST['d_id']);
$str_d="delete from product_matrix_categories where Product_Matrix_Cid=".$d1;
$cmd_d=mysqli_query($link_db,$str_d);
echo "<script>alert('Del Product Matrix!');location.href='matrix.php'</script>";
exit();
}

if(isset($_REQUEST['kinds'])=="edit_productMatrix"){  

if(isset($_POST['m_id'])!=''){
$mid=intval($_POST['m_id']);
}else{
$mid="";
}
if(isset($_POST['ES1'])!=''){
$es1=trim($_POST['ES1']);
}else{
$es1="";
}
if(isset($_POST['EM1'])!=''){
$em1=trim($_POST['EM1']);
}else{
$em1="";
}
if(isset($_POST['ESR2'])!=''){
$esr2=trim($_POST['ESR2']);
}else{
$esr2="";
}
if(isset($_POST['editor2'])!=''){
$edr=str_replace("\n","<br>",$_POST['editor2']);
}else{
$edr="";
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

$epsku='';
if(isset($_POST['eprosku'])!=''){  
  foreach($_POST['eprosku'] as $check_c){
  $epsku=$epsku.$check_c.",";
  }  
}else{
  $epsku='';
}
  if(isset($_FILES['MyFile']['name'])!=''){
  $MyFile=trim($_FILES['MyFile']['name']);
  }else{
  $MyFile="";
  }  

  if($MyFile!="none" && $MyFile!=""){
  
    $UploadPath = "./ico_img/";
    $flag = copy($_FILES['MyFile']['tmp_name'], $UploadPath.$_FILES['MyFile']['name']);  
    $flag_s = copy($_FILES['MyFile1']['tmp_name'], $UploadPath.$_FILES['MyFile1']['name']);
    $str_ed="update `product_matrix_categories` set `ProductTypeID`=".$es1.",`Page_Status`='1',`Matrix_CategoryName`='".$em1."',`IsStatus`='".$esr2."',`Matrix_SKUs`='".$epsku."',`ico_img`='$UploadPath$MyFile',`Legends`='".$edr."',`upd_d`='$now' where `Product_Matrix_Cid`=".$mid;
  
  }else{
    $str_ed="update `product_matrix_categories` set `ProductTypeID`=".$es1.",`Page_Status`='1',`Matrix_CategoryName`='".$em1."',`IsStatus`='".$esr2."',`Matrix_SKUs`='".$epsku."',`Legends`='".$edr."',`upd_d`='$now' where `Product_Matrix_Cid`=".$mid;
  }

$cmd_ed=mysqli_query($link_db,$str_ed);
echo "<script>alert('Mod product Matrix!');location.href='matrix.php'</script>";
exit();
}

if(isset($_REQUEST['kinds'])=="copy_productMatrix"){

$str_m2="select Product_Matrix_Cid FROM product_matrix_categories order by Product_Matrix_Cid desc limit 1";
$check_m2=mysqli_query($link_db,$str_m2);
$Max_MatrixID=mysqli_fetch_row($check_m2);
$MCount=$Max_MatrixID[0]+1;

if(isset($_POST['CS1'])!=''){
$cs1=trim($_POST['CS1']);
}else{
$cs1="";
}
if(isset($_POST['CM1'])!=''){
$cm1=trim($_POST['CM1']);
}else{
$cm1="";
}
if(isset($_POST['CSR2'])!=''){
$csr2=trim($_POST['CSR2']);
}else{
$csr2="";
}
if(isset($_POST['editor3'])!=''){
$edr=str_replace("\n","<br>",$_POST['editor3']);
}else{
$edr="";
}

if(isset($_POST['cprosku'])!=''){
  foreach($_POST['cprosku'] as $check) {
  $cpsku=$cpsku.$check.",";
  }
}else{
  $cpsku='';
}

$str_cos="insert into `product_matrix_categories` (`Product_Matrix_Cid`, `ProductTypeID`, `Page_Status`, `Matrix_CategoryName`, `IsStatus`, `Matrix_SKUs`, `Legends`) values ($MCount,$cs1,'1','$cm1','$csr2','$cpsku','$edr')";
$cmd_cos=mysqli_query($link_db,$str_cos);
echo "<script>alert('Copy Product Matrix!');location.href='matrix.php'</script>";
exit();
}

if(isset($_REQUEST['kinds'])=="add_productMatrix"){

  if(isset($_FILES['MyFile']['name'])!=''){
  $MyFile=trim($_FILES['MyFile']['name']);
  }else{
  $MyFile="";
  }

  if($MyFile!="none" && $MyFile!=""){
  
    $UploadPath = "./ico_img/";
    $flag = copy($_FILES['MyFile']['tmp_name'], $UploadPath.$_FILES['MyFile']['name']);  
    $flag_s = copy($_FILES['MyFile1']['tmp_name'], $UploadPath.$_FILES['MyFile1']['name']);
  
  }else{  
  }


$str_m1="select Product_Matrix_Cid FROM product_matrix_categories order by Product_Matrix_Cid desc limit 1";
$check_m1=mysqli_query($link_db,$str_m1);
$Max_MatrixID=mysqli_fetch_row($check_m1);
$MCount=$Max_MatrixID[0]+1;

if(isset($_POST['S1'])!=''){
$s1=trim($_POST['S1']);
}else{
$s1="";
}
if(isset($_POST['M1'])!=''){
$m1=trim($_POST['M1']);
}else{
$m1="";
}
if(isset($_POST['SR2'])!=''){
$sr2=trim($_POST['SR2']);
}else{
$sr2="";
}
if(isset($_POST['editor'])!=''){
$edr=str_replace("\n","<br />",$_POST['editor']);
}else{
$edr="";
}

if(isset($_POST['prosku'])!=''){  
  foreach($_POST['prosku'] as $check) {
  $psku=$psku.$check.",";
  }
}else{
  $psku='';
}

$str_ins="insert into `product_matrix_categories` (`Product_Matrix_Cid`, `ProductTypeID`, `Page_Status`, `Matrix_CategoryName`, `IsStatus`, `Matrix_SKUs`, `ico_img`, `Legends`, `upd_d`) values ($MCount,$s1,'1','$m1','$sr2','$psku','$UploadPath$MyFile','$edr','$now')";
$cmd_ins=mysqli_query($link_db,$str_ins);
echo "<script>alert('AddNew Product Matrix!');location.href='matrix.php'</script>";
exit();
}

if(isset($_REQUEST['SType_id'])==""){
$SType_id=101;
}else{
$SType_id=intval($_REQUEST['SType_id']);
}

if(isset($_REQUEST['PType_id'])==""){
$PType_id="";
}else{
$PType_id=intval($_REQUEST['PType_id']);
}

if(isset($_REQUEST['kinds'])=='copy'){

$str_m="select Product_SKU_Auto_ID FROM product_skus order by Product_SKU_Auto_ID desc limit 1";
$check_m=mysqli_query($link_db,$str_m);
$Max_COptionID=mysqli_fetch_row($check_m);
$MCount=$Max_COptionID[0]+1;

if(isset($_REQUEST['pSKU'])!=''){
$p_SKU=trim($_REQUEST['pSKU']);
}else{
$p_SKU="";
}

function getGUID(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = chr(123)// "{"
            .substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12)
            .chr(125);// "}"
        return $uuid;
    }
}

$guid = getGUID();
$guid = preg_replace("/{/i", '', $guid);
$guid = preg_replace("/}/i", '', $guid);

  $str_sku_m="select * from product_skus where Product_SKU_Auto_ID=".$p_SKU;
  $cmd_sku_m=mysqli_query($link_db,$str_sku_m);
  $record_sku_m=mysqli_fetch_row($cmd_sku_m);  
  if(empty($record_sku_m)):
  else:
    $str_sku="insert into product_skus (`Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE`, `NetWorking`, `SAS`, `FormFactor`, `UPCcode`, `FAN`, `IS_EOL`, `Web_Disable`, `GUID`, `crea_d`, `crea_u`, `slang`) values ($MCount,$record_sku_m[1],'$record_sku_m[2]','$record_sku_m[3]','$record_sku_m[4]','$record_sku_m[5]','$record_sku_m[6]','$record_sku_m[7]','$record_sku_m[8]','$record_sku_m[9]','$record_sku_m[10]','$guid','$record_sku_m[12]','$record_sku_m[13]','$record_sku_m[16]')";
    $cmd_sku=mysqli_query($link_db,$str_sku);
    echo "<script>alert('Copy be Finish!');self.location='default.php';</script>";
	exit();
  endif;
}
if(intval($PType_id)<>''){

  if(isset($_REQUEST['s_search'])<>''){
  $s_search=trim($_REQUEST['s_search']);
  $str1="select count(*) from product_matrix_categories where Matrix_CategoryName like '%".$s_search."%' and ProductTypeID=".$PType_id;
  }else{
  $str1="select count(*) from product_matrix_categories where ProductTypeID=".$PType_id;
  }

}else{
 
  if(isset($_REQUEST['s_search'])<>''){
  $s_search=trim($_REQUEST['s_search']);
  $str1="select count(*) from product_matrix_categories where Matrix_CategoryName like '%".$s_search."%'";
  }else{
  $str1="select count(*) from product_matrix_categories";
  }

}
  
$list1 =mysqli_query($link_db,$str1);
list($public_count) = mysqli_fetch_row($list1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SPEC Creation Tool - Product Matrix</title>
<link rel="stylesheet" type="text/css" href="../backend.css">
<link rel="stylesheet" type="text/css" href="../css/css.css" />
<script type="text/javascript" src="../jquery.min.js"></script>
<script language="JavaScript">
<!--
  function Del_id(t_id){    
    if(confirm("確定要刪除此筆資料嗎？")) {
    self.location="?d_id="+t_id;
    }else{
    }
  }
  function search_value(){
    self.location = "?s_search=" + document.form1.sear_txt.value;
    return false;
 }
//-->
</script>
<script type="text/javascript" src="../fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript">
	$(document).ready(function() {
	  for(i=1;i<=10;i++){
      $("#Fancy_iframe"+i+"").fancybox({
				'width'				: '100%',
				'height'			: '100%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
		});
      }
      
      for(c=1;c<=10;c++){	  
      $("#Fancy_iframe_copy"+c+"").fancybox({
				'width'				: '35%',
				'height'			: '56%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
		});      
      }
      
	  for(e=1;e<=10;e++){
      $("#Fancy_iframe_edit"+e+"").fancybox({
				'width'				: '35%',
				'height'			: '56%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
      }      

    });
</script>

<script language="JavaScript">
function MM_ST(selObj){
window.open(document.getElementById('SM1').options[document.getElementById('SM1').selectedIndex].value,"_self");
}

function MM_EST(selObj){
window.open(document.getElementById('ESM1').options[document.getElementById('ESM1').selectedIndex].value,"_self");
}

function MM_CST(selObj){
window.open(document.getElementById('CSM1').options[document.getElementById('CSM1').selectedIndex].value,"_self");
}

function MM_PT(selObj){
 if(document.getElementById('SEL_PTYPE').options[document.getElementById('SEL_PTYPE').selectedIndex].value==''){
  window.open("matrix.php","_self");
 }else{
  window.open(document.getElementById('SEL_PTYPE').options[document.getElementById('SEL_PTYPE').selectedIndex].value,"_self");
 }
}

function MM_o(selObj){
window.open(document.getElementById('pskus_page').options[document.getElementById('pskus_page').selectedIndex].value,"_self");
}

function show_add(){
$("#matrix_add").show();
$("#matrix_edit").hide();
$("#matrix_copy").hide();
} 

function show_edit(){
$("#matrix_add").hide();
$("#matrix_edit").show();
$("#matrix_copy").hide();
}
function show_copy(){
$("#matrix_add").hide();
$("#matrix_edit").hide();
$("#matrix_copy").show();
} 

function hide_add(){
self.location="matrix.php";
}

function hide_edit(){
self.location="matrix.php";
}

function hide_copy(){
self.location="matrix.php";
}     
</script>
</head>
<body>
<a name="top"></a>
<div >
<div class="left"><h1>&nbsp;&nbsp;Website Backends - SPEC Creation Tool</h1></div>
<div id="logout">Hi <b><?=str_replace('@mic.com.tw', '', $_SESSION['user']);?></b> <a href="./logo.php">Log out &gt;&gt;</a></div>
</div>
<div class="clear"></div>
<?php
include("./menu.php");
?>
<div class="clear"></div>
<?php
if(isset($_REQUEST['PType_id'])!=''){
$PType_id=intval($_REQUEST['PType_id']);
}else{
$PType_id="";
}
?>
<div id="Search" >
<div>
<select id="SEL_PTYPE" onChange="MM_PT(this)">
<option value="">Select...</option>
<?php
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);
$str_type="select ProductTypeID,ProductTypeName from producttypes";
$type_result=mysqli_query($link_db,$str_type);
while(list($ProductTypeID,$ProductTypeName)=mysqli_fetch_row($type_result))
{
?>
<option value="matrix.php?PType_id=<?=$ProductTypeID?>" <?php if($PType_id==$ProductTypeID){ echo "selected"; }?>><?=$ProductTypeName?></option>
<?php
}
mysqli_close($link_db);
?>
</select>&nbsp;&nbsp;
</div>
</div>

<div id="content">
<h3 class="left">Matrix List:</h3>
<p class="clear"></p>

<!--datatable-->
<div>
<div class="pagination left">Total: <span class="w14bblue"><?=$public_count;?></span> records &nbsp;&nbsp;
</div>
<div class="left">
<!--
<form id="form1" name="form1" method="post" action="matrix.php">
 <input name="sear_txt" type="text" size="20" value=""  /> <input type="button" value="Search" onclick="search_value();">
</form>
-->  
</div>
</div>
<p class="clear"></p>
<?php
      if(isset($_REQUEST['PSPEC'])<>''){
      
        $PSPEC_Value_str=trim($_REQUEST['PSPEC']);        
        $PP01="ProductTypeName";
        $MN01="Matrix_CategoryName";
        $IS01="IsStatus";
        $MS01="Matrix_SKUs";
        
        if($PSPEC_Value_str=="ProductTypeName"){
        $PSPEC_Value=$PSPEC_Value_str;
        $PP01="ProductTypeName_A";
        $P_value="Desc";
        }else if($PSPEC_Value_str=="ProductTypeName_A"){
        $PSPEC_Value="ProductTypeName";
        $PP01="ProductTypeName";
        $P_value="Asc";
        }
        
        if($PSPEC_Value_str=="Matrix_CategoryName"){
        $PSPEC_Value=$PSPEC_Value_str;
        $MN01="Matrix_CategoryName_A";
        $P_value="Desc";
        }else if($PSPEC_Value_str=="Matrix_CategoryName_A"){
        $PSPEC_Value="Matrix_CategoryName";
        $MN01="Matrix_CategoryName";
        $P_value="Asc";
        }
        
        if($PSPEC_Value_str=="IsStatus"){
        $PSPEC_Value=$PSPEC_Value_str;
        $IS01="IsStatus_A";
        $P_value="Desc";
        }else if($PSPEC_Value_str=="IsStatus_A"){
        $PSPEC_Value="IsStatus";
        $IS01="IsStatus";
        $P_value="Asc";
        }
        
        if($PSPEC_Value_str=="Matrix_SKUs"){
        $PSPEC_Value=$PSPEC_Value_str;
        $MS01="Matrix_SKUs_A";
        $P_value="Desc";
        }else if($PSPEC_Value_str=="Matrix_SKUs_A"){
        $PSPEC_Value="Matrix_SKUs";
        $MS01="Matrix_SKUs";
        $P_value="Asc";
        }     
      
      }else{
        
        $PSPEC_Value="ProductTypeName";        
		$PP01="ProductTypeName";
        $MN01="Matrix_CategoryName";
        $IS01="IsStatus";
        $MS01="Matrix_SKUs";
        $P_value="Desc";
      }
?>
<table class="list_table">
	<tr>
		<th width="160"><a href="?PSPEC=<?=$PP01;?>" STYLE="text-decoration:none">*Product Type</a></th>
		<!--<th><a href="?PSPEC=Page_Status" STYLE="text-decoration:none">*Page Status</a></th>-->		
		<th><a href="?PSPEC=<?=$MN01?>" STYLE="text-decoration:none">*Matrix Category</a></th>
		<th width="50"><a href="?PSPEC=<?=$IS01?>" STYLE="text-decoration:none">*Status</a></th>
		<th width="160"><a href="?PSPEC=<?=$MS01?>" STYLE="text-decoration:none">SKUs</a></th>
    <th width="140"><div class="button14" style="width:100px;"><a href="#matrix_add" STYLE="text-decoration:none" onClick="show_add();">Add New</a></div></th>
	</tr>
  
  <?php    
      if(isset($_REQUEST['page'])==""){
      $page="1";
      }else{
      $page=intval($_REQUEST['page']);
      }
      
      if(empty($page))$page="1";
      
      $read_num="10";
      $start_num=$read_num*($page-1);      
			
      $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
	  mysqli_query($link_db,'SET NAMES utf8');
	  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
	  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
      //$select=mysqli_select_db($dataBase, $link_db);
      
      if(intval($PType_id)<>''){
        if(isset($_REQUEST['s_search'])<>''){
        $s_search=trim($_REQUEST['s_search']);
        $str="SELECT a.*,b.ProductTypeName FROM product_matrix_categories a inner join producttypes b on a.ProductTypeID=b.ProductTypeID where a.Matrix_CategoryName like '%".$s_search."%' and a.ProductTypeID=".$PType_id." ORDER BY ".$PSPEC_Value." limit $start_num,$read_num;";
        }else{
        $str="SELECT a.*,b.ProductTypeName FROM product_matrix_categories a inner join producttypes b on a.ProductTypeID=b.ProductTypeID where a.ProductTypeID=".$PType_id." ORDER BY b.".$PSPEC_Value." limit $start_num,$read_num;";
        }
      }else{  
        if(isset($_REQUEST['s_search'])<>''){
        $s_search=trim($_REQUEST['s_search']);
        $str="SELECT a.*,b.ProductTypeName FROM product_matrix_categories a inner join producttypes b on a.ProductTypeID=b.ProductTypeID where a.Matrix_CategoryName like '%".$s_search."%' ORDER BY ".$PSPEC_Value." limit $start_num,$read_num;";
        }else{
          
          if(isset($_REQUEST['PSPEC'])<>''){
            $str="SELECT a.*,b.ProductTypeName FROM product_matrix_categories a inner join producttypes b on a.ProductTypeID=b.ProductTypeID ORDER BY ".$PSPEC_Value." ".$P_value." limit $start_num,$read_num;";
            }else{
            $str="SELECT * FROM product_matrix_categories ORDER BY upd_d Desc limit $start_num,$read_num;";
            }
        }
      }
	  $i=0;
      $result_u=mysqli_query($link_db,$str);
      while(list($Product_Matrix_Cid,$ProductTypeID,$Page_Status,$Matrix_CategoryName,$IsStatus,$Matrix_SKUs)=mysqli_fetch_row($result_u))
      {
      $i=$i+1;
      putenv("TZ=Asia/Taipei");
  ?>
  <tr class="list_table_con">
	<td>
    <?php
    $str_t="select ProductTypeID,ProductTypeName from producttypes where ProductTypeID=".$ProductTypeID;
    $t_result=mysqli_query($link_db,$str_t);
    $data_w=mysqli_fetch_row($t_result);
    echo $data_w[1];
    ?></td>	
    <?php
    /*
    echo "<td>";
    if($Page_Status=='1'){
    echo "Enabled";
    }else if($Page_Status=='0')
    {
    echo "Disabled";
    }
    echo "</td>";
    */
    ?>
    <td><?=$Matrix_CategoryName;?></td>
	<td>
    <?php
    if($IsStatus=='1'){
    $del_disabled='';
    echo "Online";
    }else if($IsStatus=='0')
    {
    $del_disabled='disabled';
    echo "Offline";
    }
    ?>
    </td>  
	<td>    
    <?php
    $data_SSMSKUs="";
    $data_s="";
    $MSKUs_id = explode(",", $Matrix_SKUs,-1);
    $MSKUs_count = count($MSKUs_id);    
    
    /* 頭一筆 product_skus */
    //$single_MSKUs="select Product_SKU_Auto_ID,ProductTypeID,SKU from product_skus where Product_SKU_Auto_ID=".$MSKUs_id[0];
    //$SMSKUsResult=mysqli_query($link_db,$single_MSKUs);
    //$Sdata_MSKUs=mysqli_fetch_row($SMSKUsresult);
    /* End */
    
    for($j=0;$j<$MSKUs_count;$j++){
     
     if($MSKUs_id[$j]!=''){     
     $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
	 mysqli_query($link_db,'SET NAMES utf8');
	 mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
	 mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
     //$select=mysqli_select_db($dataBase, $link_db);
     $str_MSKUs="select Product_SKU_Auto_ID,ProductTypeID,SKU from product_skus where Product_SKU_Auto_ID=".$MSKUs_id[$j];     
     $MSKUsresult=mysqli_query($link_db,$str_MSKUs);
     $data_MSKUs=mysqli_fetch_row($MSKUsresult);
    
     if($j==0){
     $data_SSMSKUs=$data_MSKUs[2];
     }    
     if($j%4==0){ 
     $br="<br>";
     }     
     $data_s=$data_s.$data_MSKUs[2].",".$br;     
     }   
     
    }    
    $data_slist=substr($data_s, 0, strlen($data_s)-5);    
    //mysqli_close($link_db);
    ?> 
    <div title="<?=preg_replace("/<br>/i", '', $data_slist);?>">
    <?php
    $data_slist_value = preg_split(",",$data_slist);
    if(count($data_slist_value)>1){ 
    //echo count($data_slist_value);
    ?>
    <?=$data_SSMSKUs;?>,...
    <?php
    }else{
    echo $data_SSMSKUs;
    }
    ?>
    </div>
    </td>
	<td>
      <a href="matrix.php?pr_id=<?=$Product_Matrix_Cid;?>#matrix_edit">Edit</a>&nbsp;&nbsp;
      <a href="matrix.php?pr_cid=<?=$Product_Matrix_Cid;?>#matrix_copy">copy</a>&nbsp;&nbsp;
      <?php //echo "<a id='Fancy_iframe_copy".$i."' href='Edit_pro_matrix.php?pr_id=".$Product_Matrix_Cid."'>copy</a>" ?>
      <?php echo "<input type='button' name='D_This' value=Del ".$del_disabled." onClick=Del_id(".$Product_Matrix_Cid.");>"; ?>
    </td>                
	</tr>
  <?php
      }
  ?> 
  <tr>
     <td colspan="5">
     <?php
        $all_page=ceil($public_count/$read_num);
        $pageSize=$page;
		$total=$all_page;
		pageft($total,$pageSize,1,0,0,15);       
     ?>
     </td>
  </tr>
  
</table>
<!--end of datatable-->
<div class="sabrosus"><span class="w14bblue"><?=$read_num?></span> Records Per Page &nbsp;&nbsp;| &nbsp;&nbsp;Page: &nbsp;
<select id="pskus_page" name="pskus_page" onChange="MM_o(this)">
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
<?php
if(isset($_REQUEST['SType_id'])!=''){
$SType_id=intval($_REQUEST['SType_id']);
}else{
$SType_id="";
}
?>
<div id="matrix_add" class="subsettings" style="display:none">
<form id="form2" name="form2" method="post" action="?kinds=add_productMatrix" enctype="multipart/form-data" onsubmit="return Final_Check();">
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hide_add();"> [close] </a></div><!--end of close-->
<table class="addspec">
<tr><td colspan="2"><!--<input name="" type="button" value="Delete" disabled />--> </td></tr>
<tr>
<th width="200">Product Type</th>
<td>
<select id="SM1" onChange="MM_ST(this)">
<option value="">Select...</option>
<?php
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);
$str_type1="select ProductTypeID,ProductTypeName from producttypes";
$type_result1=mysqli_query($link_db,$str_type1);
while(list($ProductTypeID,$ProductTypeName)=mysqli_fetch_row($type_result1))
{
?>
<option value="matrix.php?SType_id=<?=$ProductTypeID;?> #matrix_add" <?php if($SType_id==$ProductTypeID){ echo "selected"; }?>><?=$ProductTypeName?></option>
<?php
}
mysqli_close($link_db);
?>
</select>
</td>
</tr>
<!--<tr>
<th>Page Status</th><td><input type="radio" value="1" name="SR1" checked> Enabled <input type="radio" value="0" name="SR1"> Disabled </td>
</tr>-->
<tr>
<th>Matrix Category Name:</th>
<td> <input name="M1" type="text" size="80" value="" /> </td>
</tr>
<tr>
<th>Status</th><td><input type="radio" value="1" name="SR2" checked> Online <input type="radio" value="0" name="SR2"> Offline </td>
</tr>
<tr>
<th>Upload Image:</th><td><input type="file" name="MyFile" size="20"></td>
</tr>
<tr>
<th>Legends:</th><td><div style="width:750px;"><textarea cols="100" id="editor1" name="editor1" rows="10"></textarea></div></td>
</tr>
<tr>
<th>SKU:</th>
<td>
		<div id="accordion">
        <table border="0">
        <tr >        
        <td width="40%" style="word-wrap: break-word; word-break: normal;">
        <?php
		if($SType_id!=''){
        $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
		mysqli_query($link_db,'SET NAMES utf8');
	    mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
	    mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
        //$select=mysqli_select_db($dataBase, $link_db);
        $str_sku="select Product_SKU_Auto_ID,SKU FROM product_skus where ProductTypeID=".$SType_id." order by MODELCODE";
        $sku_result=mysqli_query($link_db,$str_sku);
        $i=0;
		while($stdata=mysqli_fetch_row($sku_result)){
        $i=$i+1;
        ?>
        <input name="prosku[]" type="checkbox" value="<?=$stdata[0];?>" /> <?=$stdata[1];?>
        <?php
        if($i%5==0){ echo "<br>"; }
        }
		}
        ?>
        </td>
        </tr>        
        </table>      
		</div>
</td>
</tr>

<tr><td colspan="2"><input type="hidden" name="S1" value="<?=$SType_id;?>"><input type="submit" value="Done" />&nbsp;&nbsp;</td></tr>
</table>
</form>

<script language="JavaScript">
function Final_Check( ) {

if(document.form2.SM1.value == ""){
alert("請選擇 Product Type！");
document.form2.SM1.focus();
return false;
}

if(document.form2.M1.value == "") {
alert ("請選擇 Matrix Category Name！");
document.form2.M1.focus();
return false;
}

return true;
}
</script>
</div>
<?php
if(isset($_REQUEST['pr_id'])!=""){

  $p_marx=intval($_REQUEST['pr_id']);

  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
  mysqli_query($link_db,'SET NAMES utf8');
  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
  //$select=mysqli_select_db($dataBase, $link_db);  
  $str_matr_m="select * from product_matrix_categories where Product_Matrix_Cid=".$p_marx;
  $cmd_matr_m=mysqli_query($link_db,$str_matr_m);
  $record_matr_m=mysqli_fetch_row($cmd_matr_m);
  
  if(empty($record_matr_m)):
  else:
    $MA0=$record_matr_m[1];
    $MA1=$record_matr_m[2];
    $MA2=$record_matr_m[3];
    $MA3=$record_matr_m[4];
    $MA4=$record_matr_m[5];
    $MA5=$record_matr_m[6];
    $MA6=$record_matr_m[7];
  endif;

if(isset($_REQUEST['SType_id'])!=""){
$SType_id=intval($_REQUEST['SType_id']);
}else{
$SType_id=$MA0;
}

}
?>

<div id="matrix_edit" class="subsettings" style="display:none">
<form id="form3" name="form3" method="post" action="?kinds=edit_productMatrix" enctype="multipart/form-data" onsubmit="return EFinal_Check();">
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hide_edit();"> [close] </a></div><!--end of close-->
<table class="addspec">
<tr><td colspan="2"><!--<input name="" type="button" value="Delete" disabled />--> </td></tr>
<tr>
<th width="200">Product Type</th>
<td>
<select id="ESM1" onChange="MM_EST(this)">
<!--<option value="">Select...</option>-->
<?php
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);
$str_type1="select ProductTypeID,ProductTypeName from producttypes where ProductTypeID=".$SType_id;
$type_result1=mysqli_query($link_db,$str_type1);
while(list($ProductTypeID,$ProductTypeName)=mysqli_fetch_row($type_result1))
{
?>
<option value="matrix.php?SType_id=<?=$ProductTypeID?>" <?php if($SType_id==$ProductTypeID){ echo "selected"; }?>><?=$ProductTypeName?></option>
<?php
}
mysqli_close($link_db);
?>
</select>
</td>
</tr>
<!--<tr>
<th>Page Status</th><td><input type="radio" value="1" name="ESR1" <?php if($MA1=='1') {echo "checked"; } ?>> Enabled <input type="radio" value="0" name="ESR1" <?php if($MA1=='0') {echo "checked"; } ?>> Disabled </td>
</tr>-->
<tr>
<th>Matrix Category Name:</th>
<td> <input name="EM1" type="text" size="80" value="<?=$MA2;?>"  /> </td>
</tr>
<tr>
<th>Status</th><td><input type="radio" value="1" name="ESR2" <?php if($MA3=='1') { echo "checked";} ?> > Online <input type="radio" value="0" name="ESR2" <?php if($MA3=='0') { echo "checked";} ?>> Offline </td>
</tr>
<tr>
<th>Upload Image:</th><td><?php if($MA5!=""){ ?><img src="<?=$MA5;?>"><?php } ?> <input type="file" name="MyFile" size="20"></td>
</tr>
<tr>
<th>Legends:</th><td><div style="width:750px;"><textarea cols="100" id="editor2" name="editor2" rows="10"><?=$MA6;?></textarea></div></td>
</tr>

<tr>
<th>SKU:</th>
<td>
		<div id="accordion">
        <table border="0">
        <tr>        
        <td width="40%" style="word-wrap: break-word; word-break: normal;">
        <?php
        $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
		mysqli_query($link_db,'SET NAMES utf8');
		mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
		mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
        //$select=mysqli_select_db($dataBase, $link_db);
        $str_sku_e="select Product_SKU_Auto_ID,SKU FROM product_skus where ProductTypeID=".$SType_id." order by MODELCODE";
        $sku_result_e=mysqli_query($link_db,$str_sku_e);
        $i=0;
		while($stdata_e=mysqli_fetch_row($sku_result_e)){
        $i=$i+1;
        ?>
        <input name="eprosku[]" type="checkbox" value="<?=$stdata_e[0];?>" <?php if(strpos($MA4,$stdata_e[0].",")!="" || strpos($MA4,$stdata_e[0].",")===0){ echo "checked"; } //if(eregi($stdata_e[0],$MA4)!='') echo "checked"; ?> /> <?php if(preg_match("/".$stdata_e[0]."/i",$MA4)!='') { echo "<font color=red>".$stdata_e[1]."</font>"; } else { echo $stdata_e[1]; } ?>
        <?php
        if($i%5==0){ echo "<br>"; }
        }
        ?>
        </td>
        </tr>        
        </table>      
		</div>
</td>
</tr>

<tr><td colspan="2"><input type="hidden" name="m_id" value="<?=$p_marx;?>"><input type="hidden" name="ES1" value="<?=$SType_id;?>"><input type="submit" value="Done" />&nbsp;&nbsp;</td></tr>
</table>
</form>
<?php
$CKEditor1 = new CKEditor();
$CKEditor1->basePath = 'ckeditor/';
$CKEditor1->replace("editor2");
?>
<script language="JavaScript">
function EFinal_Check( ) {

if(document.form3.ESM1.value == ""){
alert("請選擇 Product Type！");
document.form3.ESM1.focus();
return false;
}

if(document.form3.EM1.value == "") {
alert ("請選擇 Matrix Category Name！");
document.form3.EM1.focus();
return false;
}

return true;
}
</script>
</div>

<?php
if(isset($_REQUEST['pr_cid'])!=""){

  $p_marxc=intval($_REQUEST['pr_cid']);

  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
  mysqli_query($link_db,'SET NAMES utf8');
  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
  //$select=mysqli_select_db($dataBase, $link_db);
  $str_matr_c="select * from product_matrix_categories where Product_Matrix_Cid=".$p_marxc;
  $cmd_matr_c=mysqli_query($link_db,$str_matr_c);
  $record_matr_c=mysqli_fetch_row($cmd_matr_c);
  
  if(empty($record_matr_c)):
  else:
    $CMA0=$record_matr_c[1];
    $CMA1=$record_matr_c[2];
    $CMA2=$record_matr_c[3];
    $CMA3=$record_matr_c[4];
    $CMA4=$record_matr_c[5];
    $CMA5=$record_matr_c[6];
    $CMA6=$record_matr_c[7];
  endif;

if(isset($_REQUEST['SType_cid'])!=""){
$SType_cid=intval($_REQUEST['SType_cid']);
}else{
$SType_cid=$CMA0;
}
}
?>
<div id="matrix_copy" class="subsettings" style="display:none">
<form id="form4" name="form4" method="post" action="?kinds=copy_productMatrix" onsubmit="return CFinal_Check();">
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hide_copy();"> [close] </a></div><!--end of close-->
<table class="addspec">
<tr><td colspan="2"><input name="" type="button" value="Delete" disabled /> </td></tr>
<tr>
<th>Product Type</th>
<td>
<select id="CSM1" onChange="MM_CST(this)">
<!--<option value="">Select...</option>-->
<?php
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);
$str_type2="select ProductTypeID,ProductTypeName from producttypes where ProductTypeID=".$SType_cid;
$type_result2=mysqli_query($link_db,$str_type2);
while(list($ProductTypeID,$ProductTypeName)=mysqli_fetch_row($type_result2))
{
?>
<option value="matrix.php?SType_cid=<?=$ProductTypeID?>" <?php if($SType_cid==$ProductTypeID){ echo "selected"; }?>><?=$ProductTypeName?></option>
<?php
}
mysqli_close($link_db);
?>
</select>
</td>
</tr>
<!--<tr>
<th>Page Status</th><td><input type="radio" value="1" name="CSR1" <?php if($CMA1=='1') {echo "checked"; } ?>> Enabled <input type="radio" value="0" name="CSR1" <?php if($CMA1=='0'){echo "checked"; } ?>> Disabled </td>
</tr>-->
<tr>
<th>Matrix Category Name:</th>
<td> <input name="CM1" type="text" size="80" value="" /> <br /><font color="red"><?=$CMA2;?></font></td> 
</tr>
<tr>
<th>Status</th><td><input type="radio" value="1" name="CSR2" <?php if($CMA3=='1'){ echo "checked";} ?> > Online <input type="radio" value="0" name="CSR2" <?php if($CMA3=='0'){ echo "checked";} ?>> Offline </td>
</tr>
<tr>
<tr>
<th>Upload Image:</th><td><?php if($CMA5!=""){ ?><img src="<?=$CMA5;?>"><?php } ?> <input type="file" name="MyFile" size="20"></td>
</tr>
<tr>
<th>Legends:</th><td><div style="width:750px;"><textarea cols="100" id="editor3" name="editor3" rows="10"><?=$CMA6;?></textarea></div></td>
</tr>
<th>SKU:</th>
<td>
		<div id="accordion">
        <table border="0">
        <tr>        
        <td width="40%" style="word-wrap: break-word; word-break: normal;">
        <?php
        $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
        //$select=mysqli_select_db($dataBase, $link_db);
        $str_sku_e="select Product_SKU_Auto_ID,SKU FROM product_skus where ProductTypeID=".$SType_cid." order by MODELCODE";
        $sku_result_e=mysqli_query($link_db,$str_sku_e);
        while($stdata_e=mysqli_fetch_row($sku_result_e)){
        $i=$i+1;
        ?>
        <input name="cprosku[]" type="checkbox" value="<?=$stdata_e[0];?>" <?php if(preg_match("/".$stdata_e[0]."/i",$CMA4)!='') echo "checked"; ?> /> <?php if(preg_match("/".$stdata_e[0]."/i",$CMA4)!='') { echo "<font color=red>".$stdata_e[1]."</font>"; } else { echo $stdata_e[1]; } ?>
        <?php
        if($i%5==0){ echo "<br>"; }
        }
        ?>
        </td>
        </tr>        
        </table>      
		</div>
</td>
</tr>
<tr><td colspan="2"><input type="hidden" name="c_id" value="<?=$p_marxc;?>"><input type="hidden" name="CS1" value="<?=$SType_cid;?>"><input type="submit" value="Done" />&nbsp;&nbsp;</td></tr>
</table>
</form>
<?php
$CKEditor2 = new CKEditor();
$CKEditor2->basePath = 'ckeditor/';
$CKEditor2->replace("editor3");
?>
<script language="JavaScript">
function CFinal_Check( ) {

if(document.form4.CSM1.value == ""){
alert("請選擇 Product Type！");
document.form4.CSM1.focus();
return false;
}

if(document.form4.CM1.value == "") {
alert ("請選擇 Matrix Category Name！");
document.form4.CM1.focus();
return false;
}

return true;
}
</script>
</div>
<p>&nbsp;</p><p>&nbsp;</p><p class="clear"></p>
</div>
<p class="clear">&nbsp;</p>
<div id="footer">	Copyright &copy; 2012 Company Co. All rights reserved.<div class="gotop" onClick="location='#top'">Top</div></div>
<script src="../ckeditor/ckeditor.js"></script>
<script>
  CKEDITOR.replace( 'editor1', {
    });
</script>

</body>
</html>
<?php
if(isset($_REQUEST['SType_id'])<>""){
echo "<script language='Javascript'>show_add();</script>\n";
}

if(isset($_REQUEST['pr_id'])<>""){
echo "<script language='Javascript'>show_edit();</script>\n";
//}else if($_REQUEST['SType_n']=="Add"){
//echo "<script language='Javascript'>show_add();</script>\n";
}else if(isset($_REQUEST['pr_cid'])<>""){
echo "<script language='Javascript'>show_copy();</script>\n";
}
?>