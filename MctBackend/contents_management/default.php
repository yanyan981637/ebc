<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

require "../config.php";
include_once('../page.class.php');
@session_start();

if(empty($_SESSION['user']) || empty($_SESSION['login_time'])){
echo "<script language='JavaScript'>location.href='../login.php'</script>";
exit();
}

$PType_id="";
if(isset($_REQUEST['PType_id'])!=''){
$PType_id=intval($_REQUEST['PType_id']);
}else{
}

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase);

//********** add 其他語系********** 
if(isset($_REQUEST['method'])!='' && isset($_REQUEST['cid'])!=''){
  if($_REQUEST['method']=='AddProd' && $_REQUEST['cid']!=''){

    $cid=intval($_REQUEST['cid']);
    $lang=$_REQUEST['lang'];
    $page=$_REQUEST['page'];

    $str_chkCPS="SELECT `Product_SContents_Auto_ID`, `ProductTypeID`, `slang` FROM `contents_product_skus` where `slang`='EN,' and `Product_SContents_Auto_ID`=".$cid;
    $chkCPS_result=mysqli_query($link_db,$str_chkCPS);
    $chkCPS_data=mysqli_fetch_row($chkCPS_result);
    if($chkCPS_data==true){
     $PT_ID01=$chkCPS_data[1];
   }
   if($PT_ID01==1){	   
    if($lang=='JP'){
      $PT_ID01_str=6;
    }else if($lang=='ZH'){
      $PT_ID01_str=11;
    }else if($lang=='CN'){
      $PT_ID01_str=16;
    }	 
  }else if($PT_ID01==2){	   
    if($lang=='JP'){
      $PT_ID01_str=7;
    }else if($lang=='ZH'){
      $PT_ID01_str=12;
    }else if($lang=='CN'){
      $PT_ID01_str=17;
    }	 
  }else if($PT_ID01==3){
    if($lang=='JP'){
      $PT_ID01_str=8;
    }else if($lang=='ZH'){
      $PT_ID01_str=13;
    }else if($lang=='CN'){
      $PT_ID01_str=18;
    }
  }else if($PT_ID01==4){
    if($lang=='JP'){
      $PT_ID01_str=9;
    }else if($lang=='ZH'){
      $PT_ID01_str=14;
    }else if($lang=='CN'){
      $PT_ID01_str=19;
    }
  }else if($PT_ID01==5){
    if($lang=='JP'){
      $PT_ID01_str=10;
    }else if($lang=='ZH'){
      $PT_ID01_str=15;
    }else if($lang=='CN'){
      $PT_ID01_str=20;
    }
  }else if($PT_ID01==22){
    if($lang=='JP'){
      $PT_ID01_str=21;
    }else if($lang=='ZH'){
      $PT_ID01_str=23;
    }else if($lang=='CN'){
      $PT_ID01_str=24;
    }
  }else if($PT_ID01==28){
    if($lang=='JP'){
      $PT_ID01_str=33;
    }else if($lang=='ZH'){
      $PT_ID01_str=43;
    }else if($lang=='CN'){
      $PT_ID01_str=38;
    }
  }else if($PT_ID01==25){
    if($lang=='JP'){
      $PT_ID01_str=30;
    }else if($lang=='ZH'){
      $PT_ID01_str=40;
    }else if($lang=='CN'){
      $PT_ID01_str=35;
    }
  }else if($PT_ID01==26){
    if($lang=='JP'){
      $PT_ID01_str=31;
    }else if($lang=='ZH'){
      $PT_ID01_str=41;
    }else if($lang=='CN'){
      $PT_ID01_str=36;
    }
  }else if($PT_ID01==27){
    if($lang=='JP'){
      $PT_ID01_str=32;
    }else if($lang=='ZH'){
      $PT_ID01_str=42;
    }else if($lang=='CN'){
      $PT_ID01_str=37;
    }
  }else if($PT_ID01==29){
    if($lang=='JP'){
      $PT_ID01_str=34;
    }else if($lang=='ZH'){
      $PT_ID01_str=44;
    }else if($lang=='CN'){
      $PT_ID01_str=39;
    }
  }
  
  $str_chkProd="SELECT `Product_SContents_Auto_ID`,`slang` FROM `contents_product_skus` where `Product_SContents_Auto_ID`=".$cid." and `slang`='".$lang.",'";
  $chkProd_result=mysqli_query($link_db,$str_chkProd);
  $chkProd_data=mysqli_fetch_row($chkProd_result);
  if(empty($chkProd_data)):
   $str_copyprod="INSERT INTO `contents_product_skus`(`Product_SContents_Auto_ID`, `CategoryModuID`, `ProductTypeID`, `SKU`, `MODELCODE`, `STATUS`, `slang`, `Product_Info`, `ProductFile`, `ProductBFile`, `ProductSFile`, `Product_Icons`, `Product_dsc`, `Relate_enable`, `Relate_Prod`, `Compat_enable`, `Compat_Prod`, `crea_d`, `crea_u`, `upd_d`, `upd_u`, `ProductTypeID_SKU`, `lang_status`) SELECT `Product_SContents_Auto_ID`, `CategoryModuID`, ".$PT_ID01_str." as ptype01, `SKU`, `MODELCODE`, `STATUS`,'".$lang.",' as lang01 , `Product_Info`, `ProductFile`, `ProductBFile`, `ProductSFile`, `Product_Icons`, `Product_dsc`, `Relate_enable`, `Relate_Prod`, `Compat_enable`, `Compat_Prod`, `crea_d`, `crea_u`, `upd_d`, `upd_u`, `ProductTypeID_SKU`, `lang_status` FROM `contents_product_skus` WHERE `Product_SContents_Auto_ID`=".$cid." limit 1";
   $copyprod_cmd=mysqli_query($link_db,$str_copyprod);
  else:
    endif;
    echo "<script>self.location='default.php?page=".$page."'</script>";
    exit();
}
}
//************* add end ************

//*************2017.05.26 批次更新 STATUS ****************
if(isset($_REQUEST['o_line'])<>''){
  if($_POST['o_line'] == 'Update'){
    $s_status=$_POST['s_oline'];
    $check = $_POST['checkbox'];
    foreach($check as $value){
    //$value=str_replace(" ","", $value);
      $str_update = "UPDATE contents_product_skus SET STATUS = '".$s_status."' where Product_SContents_Auto_ID ='".$value."'";
      mysqli_query($link_db,$str_update);
    }
    echo "<script>self.location='default.php</script>";
  }
}
//*************2017.05.26 批次更新 STATUS end ****************

//*********************************
if(isset($_REQUEST['kinds'])!=''){
  $s_search="";
  if($_REQUEST['kinds']=="build"){
   $cid=intval($_REQUEST['cid']);
   if(isset($_REQUEST['s_search'])!=''){
     $s_search=trim($_REQUEST['s_search']);
     $s_search=htmlspecialchars($s_search, ENT_QUOTES);
   }
   if($s_search!=''){
     $search01="&s_search=".$_REQUEST['s_search'];
   }else{
     $search01="";
   }

   $str_dview="DROP VIEW s".$cid."";
   $dview_cmd=mysqli_query($link_db,$str_dview);
   $str_chk_spvw="select * from s".$cid;
   $chk_spvw_cmd=mysqli_query($link_db,$str_chk_spvw);
   $chk_spvw_data=mysqli_fetch_row($chk_spvw_cmd);
   if(empty($chk_spvw_data)):
     $str_cview="create view s".$cid." as SELECT specvalues.SPEC_Vaule_ID, specvalues.Product_SKU_Auto_ID, specvalues.SPECTypeID, specvalues.SPECValue, spectypes.InputTypeID, Case When spectypes.InputTypeID= 4 Then specvalues.SPECValue else Fun_Get_SPECValue(specvalues.SPECValue) End  CSPECValue, spectypes.ParentSpec,SPECTypeName, Case When spectypes.ParentSpec is null then '' Else (SELECT SPECTypeName FROM  spectypes P WHERE P.SPECTypeID = spectypes.ParentSpec) End CParentSpec, spectypes.SPECCategoryID, spectypes.WebOrder, spectypes.SPECTypeSort, spectypes.ParentSort FROM specvalues INNER JOIN spectypes ON specvalues.SPECTypeID = spectypes.SPECTypeID WHERE (specvalues.Product_SKU_Auto_ID = ".$cid.") AND (specvalues.SPECValue <> '')";
   $cview_cmd=mysqli_query($link_db,$str_cview);
   else: 
     endif;

   $str_dtable="DROP TABLE sp".$cid."";
   $dtable_cmd=mysqli_query($link_db,$str_dtable);

   $str_ctable="CREATE TABLE sp".$cid." select * from s".$cid;
   $ctable_cmd=mysqli_query($link_db,$str_ctable);

   echo "<script>alert('build completed!');self.location='default.php?page=".$_REQUEST['page'].$search01."'</script>";
   exit();
 }
}
//*********** end *************

//************* loadind count *******************
$slang="";$s_search="";$seol="";
if(isset($_GET["seol"])<>''){
  $seol=$_GET["seol"];
}
if(isset($_GET["sel_status"])<>''){
  $sel_status=$_GET["sel_status"];
}
if(isset($_REQUEST['s_search'])<>''){
  $s_search=preg_replace("/['\"\$\r\n\t;<>\*%\?]/i", '', $_REQUEST['s_search']);
  $s_search=htmlspecialchars($s_search, ENT_QUOTES);
}
if(isset($_GET['slang'])<>''){
    $slang = $_GET['slang'];
    $slang = str_replace("|", "%' or slang like '%", $slang);
    $slang = substr($slang, 0, strlen($slang)-19);  
}

if($PType_id<>''){
  if($s_search <> ''){
    $str1="select count(*) from `contents_product_skus` where (SKU like '%".$s_search."%' or MODELCODE like '%".$s_search."%') and ProductTypeID=".$PType_id." and STATUS='".$sel_status."'";
  }else{
    if($slang<>''){	
      if($sel_status<>''){
        $str1="SELECT count(*) FROM `contents_product_skus` where ProductTypeID=".$PType_id." and (slang LIKE '%".$slang."%') and STATUS='".$sel_status."'";  
      }else{
        $str1="SELECT count(*) FROM `contents_product_skus` where ProductTypeID=".$PType_id." and (slang LIKE '%".$slang."%')";  
      }

    }else{
      if($sel_status<>''){
        $str1="SELECT count(*) FROM `contents_product_skus` where ProductTypeID='".$PType_id."' and STATUS='".$sel_status."'";
      }else{
        $str1="SELECT count(*) FROM `contents_product_skus` where ProductTypeID=".$PType_id;
      }
    }
  }
}else{
  if($s_search != ''){
    $str1="select count(*) from `contents_product_skus` where (SKU like '%".$s_search."%' or MODELCODE like '%".$s_search."%')";
  }else{
    if($slang<>''){
      if($sel_status <> ''){
        $str1="SELECT count(*) FROM `contents_product_skus` a inner join producttypes b on a.ProductTypeID_SKU=b.ProductTypeID where (a.slang LIKE '%".$slang."%') and STATUS='".$sel_status."'";
      }else{
        $str1="SELECT count(*) FROM `contents_product_skus` a inner join producttypes b on a.ProductTypeID_SKU=b.ProductTypeID where (a.slang LIKE '%".$slang."%')";
      }
    }else{
      if($sel_status<>''){
        $str1="select count(*) from `contents_product_skus` where STATUS='".$sel_status."'";
      }else{
        $str1="select count(*) from `contents_product_skus`";
      }
    }	
  }
}
//************* loadind count end *******************
$list1 =mysqli_query($link_db,$str1);
list($public_count) = mysqli_fetch_row($list1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Website Contents Management - Products Management: Products </title>
<link rel="stylesheet" type="text/css" href="../backend.css" />
<link rel="stylesheet" type="text/css" href="../css/css.css" />
<script type="text/javascript" src="../jquery.min.js"></script>
<script type="text/javascript" src="../fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script language="JavaScript">
function MM_PT(selObj){
var str_lang="";
var lang01 = document.getElementsByName('slang');
  
  for(var i=0;i<lang01.length;i++){
     if(lang01[i].checked==true){	   
	   str_lang=str_lang + lang01[i].value + "|";       	   
	 }
  }
window.open(document.getElementById('SEL_PTYPE').options[document.getElementById('SEL_PTYPE').selectedIndex].value,"_self");
}

function MM_o(selObj){
window.open(document.getElementById('pskus_page').options[document.getElementById('pskus_page').selectedIndex].value,"_self");
}

function search_value(){
    self.location = "?s_search=" + document.getElementById('sear_txt').value;
    return false;
}

function doEnter(event){
 var keyCodeEntered = (event.which) ? event.which : window.event.keyCode;     
     if (keyCodeEntered == 13){
       if(confirm('Are you sure you want to search this word?')) {
	     document.location.href = "?s_search=" + document.getElementById('sear_txt').value;
	   }
	 }
}
function top_check(){
  var P01 = document.getElementById('SEL_PTYPE').value;
  var P01 = P01.replace('default.php?PType_id=', '');
  var SEL_status = document.getElementById('SEL_status').value;
  self.location="?PType_id=" + P01 + "&sel_status=" + SEL_status;
}
//-->
</script>
</head>
<body><a name="top"></a>
<div>
<div class="left"><h1>&nbsp;&nbsp;Website Backends - Website Contents Management: Products List</h1></div>
<div id="logout">Hi <?=str_replace("@mic.com.tw", "", $_SESSION['user']);?> <a href="./logo.php">Log out &gt;&gt;</a></div>
</div>
<div class="clear"></div>
<div id="menu">
<ul>
<li ><a href="default.php">Products</a>
</li>
<li> <a href="modules.php">Contents</a> 
<ul>
<li><a href="modules.php">Modules</a></li>	  
</ul>
</li>
<ul><li><a href="subscribe.php">Subscription</a></li></ul>
</li>
</ul>
</div>
<div class="clear"></div>
<div id="Search">
<div class="left" >
<select id="SEL_PTYPE" name="SEL_PTYPE" onChange="MM_PT(this)">
<option value="default.php?PType_id=">Product Type: All</option>
<?php
$str_type="SELECT `ProductTypeID`, `ProductTypeName` FROM `producttypes_las`";
$type_result=mysqli_query($link_db,$str_type);
while(list($ProductTypeID,$ProductTypeName)=mysqli_fetch_row($type_result))
{
?>
<option value="default.php?PType_id=<?=$ProductTypeID?>" <?php if($PType_id==$ProductTypeID){ echo "selected"; }?>><?=$ProductTypeName?></option>
<?php
}
?>
</select> &nbsp;&nbsp;
<select id="SEL_status" name="SEL_status">
  <option value="">Status: All</option>
  <option value="1" <?php if($sel_status=="1"){echo "selected"; }?>>Online</option>
  <option value="0" <?php if($sel_status=="0"){echo "selected"; }?>>Offline</option>
</select> &nbsp;&nbsp;
<input id="scheck_checked" name="scheck_checked" type="button" value="Search" onclick="top_check();" />
</div>
<p class="clear"></p>
<div id="content"><h3 class="left">Products List:</h3>
<p class="clear"></p>
<!--datatable starts here-->
<div>
<div class="pagination left">Total: <span class="w14bblue"><?=$public_count;?></span> records &nbsp;&nbsp;
</div>
<form id="form1" name="form1" method="post" action="default.php">
 <input id="sear_txt" name="sear_txt" type="text" size="20" value="" onkeydown="doEnter(event);" /> <input type="button" value="Search" onclick="search_value();" /> 
</form> 
</div>
<?php
      if(isset($_REQUEST['PSPEC'])!=''){   
        $PSPEC_Value_str=$_REQUEST['PSPEC'];        
        $PP01="ProductTypeName";
        $PM01="MODELCODE";
        $PS01="SKU";
        $PL01="slang";
        $PE01="IS_EOL";
        $PD01="upd_d";
        $PU01="upd_u";
      
        if($PSPEC_Value_str=="ProductTypeName"){
        $PSPEC_Value=$PSPEC_Value_str;
        $PP01="ProductTypeName_A";
        $P_value="Desc";
        }else if($PSPEC_Value_str=="ProductTypeName_A"){
        $PSPEC_Value="ProductTypeName";
        $PP01="ProductTypeName";
        $P_value="Asc";
        }
        
        if($PSPEC_Value_str=="MODELCODE"){
        $PSPEC_Value=$PSPEC_Value_str;
        $PM01="MODELCODE_A";
        $P_value="Desc";
        }else if($PSPEC_Value_str=="MODELCODE_A"){
        $PSPEC_Value="MODELCODE";
        $PM01="MODELCODE";
        $P_value="Asc";
        }
        
        if($PSPEC_Value_str=="SKU"){
        $PSPEC_Value=$PSPEC_Value_str;
        $PS01="SKU_A";
        $P_value="Desc";
        }else if($PSPEC_Value_str=="SKU_A"){
        $PSPEC_Value="SKU";
        $PS01="SKU";
        $P_value="Asc";
        }
        
        if($PSPEC_Value_str=="slang"){
        $PSPEC_Value=$PSPEC_Value_str;
        $PL01="slang_A";
        $P_value="Desc";
        }else if($PSPEC_Value_str=="slang_A"){
        $PSPEC_Value="slang";
        $PL01="slang";
        $P_value="Asc";
        }
        
       
        if($PSPEC_Value_str=="upd_d"){
        $PSPEC_Value=$PSPEC_Value_str;
        $PD01="upd_d_A";
        $P_value="Desc";
        }else if($PSPEC_Value_str=="upd_d_A"){
        $PSPEC_Value="upd_d";
        $PD01="upd_d";
        $P_value="Asc";
        }

        if($PSPEC_Value_str=="upd_u"){
        $PSPEC_Value=$PSPEC_Value_str;
        $PU01="upd_u_A";
        $P_value="Desc";
        }else if($PSPEC_Value_str=="upd_u_A"){
        $PSPEC_Value="upd_u";
        $PU01="upd_u";
        $P_value="Asc";
        }
      
      }else{
        $PSPEC_Value="upd_d";
      
        $PP01="ProductTypeName";
        $PM01="MODELCODE";
        $PS01="SKU";
        $PL01="slang";
        $PE01="IS_EOL";
        $PD01="upd_d";
        $PU01="upd_u";
        $P_value="Desc";
      }
?>
<p class="clear"></p>
<form id="form2" name="form2" method="post" action="default.php">
<table class="list_table">
	<tr>
		<th STYLE="text-decoration:none">*Category</th>
		<th STYLE="text-decoration:none">*SKU</th>
		<th STYLE="text-decoration:none">*Model</th>		
		<th STYLE="text-decoration:none">*Product Type</th>
		<th STYLE="text-decoration:none">*Update Date</th>
        <th STYLE="text-decoration:none">*Creation Date</th>
        <th STYLE="text-decoration:none">*Language</th>
        <th STYLE="text-decoration:none">
          
            <select id="s_oline" name="s_oline" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
              <option selected value="1">Online</option>
              <option value="0">Offline</option>
            </select>
            <input id="o_line" name="o_line" type="submit" value="Update" onclick="" />
            *Status
          
        </th>
	</tr>
	<?php
	  $demo_url="";
	  if(isset($_REQUEST['page'])==""){
      $page="1";
      }else{
      $page=$_REQUEST['page'];
      }      
      if(empty($page))$page="1";      
      $read_num="60";
      $start_num=$read_num*($page-1);
      if(isset($_GET['slang'])<>''){      
        $slang=trim($_REQUEST['slang']);
        $slang = str_replace("|", "%' or a.slang like '%", $slang);
        $slang = substr($slang, 0, strlen($slang)-19);
        $slang = "(a.slang LIKE '%".$slang."%')";
        $slang = str_replace("%'%'", "%'", $slang);
      }
      //************search 類別 start ***********			
      if($PType_id<>''){
        //************ search 類別+SKU **************
        if($s_search <> ''){
          $str="SELECT a.*,b.ProductTypeName FROM `contents_product_skus` a inner join `producttypes_las` b on a.ProductTypeID=b.ProductTypeID where (a.SKU like '%".$s_search."%' or a.MODELCODE like '%".$s_search."%') and a.ProductTypeID=".$PType_id." ORDER BY ".$PSPEC_Value." ".$P_value." limit $start_num,$read_num;";
        }else{		 
          //********* search 類別+lang ************** 
          if($slang<>''){
            if($seol == 1){
              // search EOL
              if($sel_status <> ''){
                $str="SELECT a.*,b.ProductTypeName, c.IS_EOL FROM `contents_product_skus` a inner join `producttypes_las` b on a.ProductTypeID=b.ProductTypeID inner join `product_skus` c ON a.Product_SContents_Auto_ID=c.Product_SKU_Auto_ID where a.ProductTypeID=".$PType_id." and ".$slang." and c.IS_EOL = ".$seol." and a.STATUS='".$sel_status."' ORDER BY ".$PSPEC_Value." ".$P_value.",a.Product_SContents_Auto_ID limit $start_num,$read_num;";
              }else{
                $str="SELECT a.*,b.ProductTypeName, c.IS_EOL FROM `contents_product_skus` a inner join `producttypes_las` b on a.ProductTypeID=b.ProductTypeID inner join `product_skus` c ON a.Product_SContents_Auto_ID=c.Product_SKU_Auto_ID where a.ProductTypeID=".$PType_id." and ".$slang." and c.IS_EOL = ".$seol." ORDER BY ".$PSPEC_Value." ".$P_value.",a.Product_SContents_Auto_ID limit $start_num,$read_num;";
              }
            }else{
              if($sel_status <> ''){
                $str="SELECT a.*,b.ProductTypeName FROM `contents_product_skus` a inner join `producttypes_las` b on a.ProductTypeID=b.ProductTypeID where a.ProductTypeID=".$PType_id." and ".$slang." and a.STATUS='".$sel_status."' ORDER BY ".$PSPEC_Value." ".$P_value.",a.Product_SContents_Auto_ID limit $start_num,$read_num;";
              }else{
                $str="SELECT a.*,b.ProductTypeName FROM `contents_product_skus` a inner join `producttypes_las` b on a.ProductTypeID=b.ProductTypeID where a.ProductTypeID=".$PType_id." and ".$slang." ORDER BY ".$PSPEC_Value." ".$P_value.",a.Product_SContents_Auto_ID limit $start_num,$read_num;";
              }
            }
          }else{
            if($seol == 1){
              // search EOL
              if($sel_status <> ''){
                $str="SELECT a.*,b.ProductTypeName, c.IS_EOL FROM `contents_product_skus` a inner join `producttypes_las` b on a.ProductTypeID=b.ProductTypeID inner join `product_skus` c ON a.Product_SContents_Auto_ID=c.Product_SKU_Auto_ID where a.ProductTypeID=".$PType_id." and c.IS_EOL = ".$seol." and a.STATUS='".$sel_status."' ORDER BY ".$PSPEC_Value." ".$P_value.",a.Product_SContents_Auto_ID limit $start_num,$read_num;";
              }else{
                $str="SELECT a.*,b.ProductTypeName, c.IS_EOL FROM `contents_product_skus` a inner join `producttypes_las` b on a.ProductTypeID=b.ProductTypeID inner join `product_skus` c ON a.Product_SContents_Auto_ID=c.Product_SKU_Auto_ID where a.ProductTypeID=".$PType_id." and c.IS_EOL = ".$seol." ORDER BY ".$PSPEC_Value." ".$P_value.",a.Product_SContents_Auto_ID limit $start_num,$read_num;";
              }
            }else{
              if($sel_status <> ''){
                $str="SELECT a.*,b.ProductTypeName FROM `contents_product_skus` a inner join `producttypes_las` b on a.ProductTypeID=b.ProductTypeID where a.ProductTypeID=".$PType_id." and a.STATUS='".$sel_status."' ORDER BY ".$PSPEC_Value." ".$P_value.",a.Product_SContents_Auto_ID limit $start_num,$read_num;";
              }else{
                $str="SELECT a.*,b.ProductTypeName FROM `contents_product_skus` a inner join `producttypes_las` b on a.ProductTypeID=b.ProductTypeID where a.ProductTypeID=".$PType_id." ORDER BY ".$PSPEC_Value." ".$P_value.",a.Product_SContents_Auto_ID limit $start_num,$read_num;";
              }
            }
          }
        }
      }else{
        //********** search SKU start *************
        if($s_search != ''){
          $str="SELECT a.*,b.ProductTypeName FROM `contents_product_skus` a inner join `producttypes_las` b on a.ProductTypeID=b.ProductTypeID where (a.SKU like '%".$s_search."%' or a.MODELCODE like '%".$s_search."%') ORDER BY ".$PSPEC_Value." ".$P_value." limit $start_num,$read_num;";
        }else{
          if($slang<>''){
            if($seol == 1){
              // search EOL
              if($sel_status <> ''){
                $str="SELECT a.*,b.ProductTypeName, c.IS_EOL FROM `contents_product_skus` a inner join `producttypes_las` b on a.ProductTypeID=b.ProductTypeID inner join `product_skus` c ON a.Product_SContents_Auto_ID=c.Product_SKU_Auto_ID where ".$slang." and c.IS_EOL = ".$seol." and a.STATUS='".$sel_status."' ORDER BY ".$PSPEC_Value." ".$P_value.",a.Product_SContents_Auto_ID limit $start_num,$read_num;";
              }else{
                $str="SELECT a.*,b.ProductTypeName, c.IS_EOL FROM `contents_product_skus` a inner join `producttypes_las` b on a.ProductTypeID=b.ProductTypeID inner join `product_skus` c ON a.Product_SContents_Auto_ID=c.Product_SKU_Auto_ID where ".$slang." and c.IS_EOL = ".$seol." ORDER BY ".$PSPEC_Value." ".$P_value.",a.Product_SContents_Auto_ID limit $start_num,$read_num;";
              }
            }else{
              // search EOL
              if($sel_status <> ''){
                $str="SELECT a.*,b.ProductTypeName FROM `contents_product_skus` a inner join `producttypes_las` b on a.ProductTypeID=b.ProductTypeID where ".$slang." and a.STATUS='".$sel_status."' ORDER BY ".$PSPEC_Value." ".$P_value.",a.Product_SContents_Auto_ID limit $start_num,$read_num;";
              }else{
                $str="SELECT a.*,b.ProductTypeName FROM `contents_product_skus` a inner join `producttypes_las` b on a.ProductTypeID=b.ProductTypeID where ".$slang." ORDER BY ".$PSPEC_Value." ".$P_value.",a.Product_SContents_Auto_ID limit $start_num,$read_num;";
              }
            }
          }else{
            if($seol == 1){
              // search EOL
              if($sel_status <> ''){
                $str="SELECT a.*,b.ProductTypeName, c.IS_EOL FROM `contents_product_skus` a inner join `producttypes_las` b on a.ProductTypeID=b.ProductTypeID inner join `product_skus` c ON a.Product_SContents_Auto_ID=c.Product_SKU_Auto_ID where c.IS_EOL = ".$seol." and a.STATUS='".$sel_status."' ORDER BY ".$PSPEC_Value." ".$P_value.",a.Product_SContents_Auto_ID limit $start_num,$read_num;";
              }else{
                $str="SELECT a.*,b.ProductTypeName, c.IS_EOL FROM `contents_product_skus` a inner join `producttypes_las` b on a.ProductTypeID=b.ProductTypeID inner join `product_skus` c ON a.Product_SContents_Auto_ID=c.Product_SKU_Auto_ID where c.IS_EOL = ".$seol." ORDER BY ".$PSPEC_Value." ".$P_value.",a.Product_SContents_Auto_ID limit $start_num,$read_num;";
              }
            }else{
              // search EOL
              if($sel_status <> ''){
                $str="SELECT a.*,b.ProductTypeName FROM `contents_product_skus` a inner join `producttypes_las` b on a.ProductTypeID=b.ProductTypeID WHERE a.STATUS='".$sel_status."' ORDER BY ".$PSPEC_Value." ".$P_value.",a.Product_SContents_Auto_ID limit $start_num,$read_num;";
              }else{
                $str="SELECT a.*,b.ProductTypeName FROM `contents_product_skus` a inner join `producttypes_las` b on a.ProductTypeID=b.ProductTypeID ORDER BY ".$PSPEC_Value." ".$P_value.",a.Product_SContents_Auto_ID limit $start_num,$read_num;";
              }
            }

          }
         /*if(isset($_REQUEST['PSPEC'])!=''){
          $str="SELECT a.*,b.ProductTypeName FROM `contents_product_skus` a inner join `producttypes_las` b on a.ProductTypeID=b.ProductTypeID ORDER BY ".$PSPEC_Value." ".$P_value." limit $start_num,$read_num;";
        }else{
          $str="SELECT a.*,b.ProductTypeName FROM `contents_product_skus` a inner join `producttypes_las` b on a.ProductTypeID=b.ProductTypeID ORDER BY a.upd_d Desc limit $start_num,$read_num;";
        }   */  
        }
      }

//************ search table data start *************
      $result=mysqli_query($link_db,$str);
	  $i=0;
      while(list($Product_SContents_Auto_ID,$CategoryModuID,$ProductTypeID,$SKU,$MODELCODE,$STATUS,$slang,$Product_Info,$ProductFile,$ProductBFile,$ProductSFile,$ProductFileCom,$Product_Icons,$Product_Icons_b,$Product_dsc,$Relate_enable,$Relate_Prod,$Compat_enable,$Compat_Prod,$crea_d,$crea_u,$upd_d,$upd_u,$ProductTypeID_SKU,$lang_status)=mysqli_fetch_row($result))
      {
      $i=$i+1;
      putenv("TZ=Asia/Taipei");

	  if($ProductTypeID==1 ){
	  $PTP01="Motherboards";
  		if($slang=="EN,"){
  		$slang_chk="en-US";  
  		}
	  $s_PID = "select SYSTEMBOARDID from p_s_main_systemboards where MODELCODE='".$MODELCODE."' and LANG='".$slang_chk."'";
	  }else if($ProductTypeID==2){
	  $PTP01="Barebones";
	  $s_PID = "select SERVERID from p_b_main_serverbarebones where MODELCODE='".$MODELCODE."' and LANG='en-US'";
	  }else if($ProductTypeID==46){
	  $PTP01="Industrial Panel PC";
	  $s_PID = "SELECT `PANELPCID` FROM `p_b_main_panelpc` where MODELCODE='".$MODELCODE."' and LANG='en-US'";
	  }else if($ProductTypeID==47){
	  $PTP01="Embedded System";
	  $s_PID = "select `EMBEDDEDID` from `p_b_main_embedded` where MODELCODE='".$MODELCODE."' and LANG='en-US'";
	  }else if($ProductTypeID==48){
	  $PTP01="Industrial Motherboard";
	  $s_PID = "select `INDUSTRIAMBID ` from `p_b_main_industriamb` where MODELCODE='".$MODELCODE."' and LANG='en-US'";
	  }else if($ProductTypeID==49){
    $PTP01="OCPserver";
    $s_PID = "select `OCPID ` from `p_b_main_ocpserver` where MODELCODE='".$MODELCODE."' and LANG='en-US'";
    }else if($ProductTypeID==50){
    $PTP01="OCPMezz";
    $s_PID = "select `OCPMezzID ` from `p_b_main_ocpmezz` where MODELCODE='".$MODELCODE."' and LANG='en-US'";
    }else if($ProductTypeID==51){
    $PTP01="JBODJBOF";
    $s_PID = "select `JBODFID ` from `p_b_main_jbodjbof` where MODELCODE='".$MODELCODE."' and LANG='en-US'";
    }else if($ProductTypeID==52){
    $PTP01="OCP Rack";
    $s_PID = "select `OCPRACKID ` from `p_b_main_ocprack` where MODELCODE='".$MODELCODE."' and LANG='en-US'";
    }else if($ProductTypeID==53){
    $PTP01="POS";
    $s_PID = "select `POSID ` from `p_b_main_pos` where MODELCODE='".$MODELCODE."' and LANG='en-US'";
    }else if($ProductTypeID==54){
    $PTP01="5GEdgeComputing ";
    $s_PID = "select `5GID ` from `p_b_main_5G` where MODELCODE='".$MODELCODE."' and LANG='en-US'";
    }

	  if($slang=='EN,'){
      $PTP01= preg_replace("/\s(?=)/","",$PTP01);
      $demo_url=$PTP01."_".$MODELCODE."_".$SKU;
	  }
  ?>
	<tr>
		<td width="100">
		<?php
		$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
    mysqli_query($link_db, 'SET NAMES utf8');
		//$select=mysqli_select_db($dataBase);
		$str_Categ1="SELECT `CategoryModuID`, `CategoryModuName`, `ProdTypeID` FROM `category_module_las` where `ProdTypeID`=".$ProductTypeID." and `slang`='".substr($slang,0,strlen($slang)-1)."' and `CategoryModuID`=".$CategoryModuID;
    $Categ_result1=mysqli_query($link_db,$str_Categ1);
		$Categ_data=mysqli_fetch_row($Categ_result1);
		echo $Categ_data[1];
		?>
		</td>
		<td>
		<?php
		?>
		<a href="/<?=$demo_url;?>" target="spec"><?=$SKU;?></a>
		<?php
		?>
		</td>
		<td><?=$MODELCODE;?></td>        
		<td>
		<?php
		$str_type="select * from `producttypes_las` where ProductTypeID=".$ProductTypeID;
		$type_result=mysqli_query($link_db,$str_type);
		$data=mysqli_fetch_row($type_result);
		echo $data[1];
		?>
		</td>
		<td>
		<?php
		echo date("Y-m-d",strtotime($upd_d));
		?></td>
		<td>
		<?php
		echo date("Y-m-d",strtotime($crea_d));
		?> </td>		
 		<td><?//=substr($slang, 0, strlen($slang)-1);?></td> 
		<td>
    <input type="checkbox" name="checkbox[]" value="<?=$Product_SContents_Auto_ID?>" />
		<?php
		if($STATUS=='1'){
		echo "Online";
		}else if($STATUS=='0'){
		echo "Offline";
		}
		?>&nbsp;&nbsp;<a href="edit_product.php?cid=<?=$Product_SContents_Auto_ID;?>&lang=<?=$slang;?>&s_search=<?=$s_search;?>" />Edit</a>&nbsp;&nbsp;
		<?php
		if(isset($_REQUEST['s_search'])!=''){
		?>
		<a href="?kinds=build&cid=<?=$Product_SContents_Auto_ID;?>&page=<?=$page;?>&s_search=<?=$_REQUEST['s_search'];?>">Build</a>&nbsp;&nbsp;
		<?php
		}else{		
		?>
		<a href="?kinds=build&cid=<?=$Product_SContents_Auto_ID;?>&page=<?=$page;?>">Build</a>&nbsp;&nbsp;
		<?php
		}
		?>		
		<a href="../../products/chtml.php?PType=<?=$PTP01;?>&PMCode=<?=$MODELCODE;?>&PSKUs=<?=$SKU;?>">Generated</a>&nbsp;&nbsp;
		<a href="../../<?=$PTP01;?>-<?=$MODELCODE;?>-<?=$SKU;?>.htm" target="spec">show</a>&nbsp;&nbsp;
		<?php
		if($slang=='EN,'){		
		 echo "<a href='?method=AddProd&cid=".$Product_SContents_Auto_ID."&lang=CN&page=".$page."'>CN</a>&nbsp;&nbsp;&nbsp;";
		 echo "<a href='?method=AddProd&cid=".$Product_SContents_Auto_ID."&lang=ZH&page=".$page."'>ZH</a>&nbsp;&nbsp;&nbsp;";
		 echo "<a href='?method=AddProd&cid=".$Product_SContents_Auto_ID."&lang=JP&page=".$page."'>JP</a>&nbsp;&nbsp;&nbsp;";
		}
		?>
		</td>              
	</tr>
  <?php
      }
  ?>	
  <tr>
    <td colspan="8">
    <?php
        $all_page=ceil($public_count/$read_num);
        $pageSize=$page;
		$total=$all_page;
		pageft($total,$pageSize,1,0,0,15);       
    ?>
    </td>
  </tr>
	
</table>		
</form>	
<!--end of datatable-->	
<p style="color:#0F0;display:none">
- Default load 最新的 從 "(PMM系統) SPEC Creation Tool" 所建的 10筆資料 & 被Edit 的sku 新的資料。(從"SPEC Creation Tool" 所建好的產品資料, 都是offline 的狀態, 必須在這裏設定完其他資料, 並決定其是否為Online or offline) <br>
- 在 PMM 系統中該SKU 有設定的語言，在這才會show出。點選該語言，可進入edit。	<br>	
- Search 可 search "Brand Name", "SKU","Model" 欄位
<br>
- * 表可sorting。<br>
- Click SKU will popup another win to show its SPEC table(PMM系統)<br>
- Click "Add" button 可新增非PMM 系統 Product Type 中的新產品<br>
 </p>
</div>
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
<p class="clear">&nbsp;</p>
<div id="footer">	Copyright &copy; 2013 Company Co. All rights reserved.<div class="gotop" onClick="location='#top'">Top</div></div>
</body>
</html>