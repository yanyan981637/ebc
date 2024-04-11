<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

session_start();
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

if(isset($_REQUEST['pr_id'])!=''){
$pr_id=intval($_REQUEST['pr_id']);
}else{
$pr_id=101;
}

if(isset($_REQUEST['d_id'])!=""){
$d1=intval($_REQUEST['d_id']);
$str_d="delete FROM producttypes where ProductTypeID=".$d1;
$cmd_d=mysqli_query($link_db,$str_d);

$str_g="delete from `product_skus_categories` where `ProductTypeID`=".$d1;
$cmd_g=mysqli_query($link_db,$str_g);
echo "<script>alert('Del product Types !');location.href='spec_settings_pro_types.php';</script>";
exit();
}

if(isset($_REQUEST['kinds'])!=''){
//echo $_REQUEST['kinds'];
//exit();
if(trim($_REQUEST['kinds'])=='copy_producttypes'){
$str_c="select ProductTypeID FROM producttypes order by ProductTypeID desc limit 1";
$check_c=mysqli_query($link_db,$str_c);
$Max_CCOptionID=mysqli_fetch_row($check_c);
$CMCount=$Max_CCOptionID[0]+1;

if(isset($_POST['SPEC_cid'])!=''){
$c_id=intval($_POST['SPEC_cid']);
}else{
$c_id="";
}
if(isset($_POST['CPM1'])!=''){
$cm1=trim($_POST['CPM1']);
}else{
$cm1="";
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

if(isset($_POST['speccate_c'])<>''){
  foreach($_POST['speccate_c'] as $check1) {
  $cstr1=$cstr1.$check1.",";
  }
}else{
  $cstr1='';
}

if(isset($_POST['spectype_c'])<>''){
  foreach($_POST['spectype_c'] as $check2){
  $cstr2=$cstr2.$check2.",";
  }
}else{
  $cstr2='';
}

if(isset($_POST['spectype_sub_c'])<>''){
  foreach($_POST['spectype_sub_c'] as $check3){
  $cstr3=$cstr3.$check3.",";
  }
}else{
  $cstr3='';
}

//echo $CMCount."<br>".$cm1."<br>".$cstr1."<br>".$cstr2."<br>".$cstr3."<br>".$guid."<br>".$now;
putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");
$str_skuc="insert into producttypes (`ProductTypeID`, `ProductTypeName`, `SPECCategories`, `SPECType`, `SPECType_Sub`, `GUID`, `crea_d`, `crea_u`) values ($CMCount,'$cm1','$cstr1','$cstr2','$cstr3','$guid','$now','1782')";
$cmd_skuc=mysqli_query($link_db,$str_skuc);

    //寫入 product_skus_categories Start
    $str_c1="select Product_SKU_Cid FROM product_skus_categories order by Product_SKU_Cid desc limit 1";
    $check_c1=mysqli_query($link_db,$str_c1);
    $Max_CskuID=mysqli_fetch_row($check_c1);
    $CCount=$Max_CskuID[0]+1;

    $str_cos="insert into `product_skus_categories` (`Product_SKU_Cid`, `ProductTypeID`, `SKUs_Conditions`, `GUID`, `crea_u`, `crea_d`, `IsStatus`) values ($CCount,$CMCount,'','$guid','$now','1782','1')";
    $cmd_co0s=mysqli_query($link_db,$str_cos);
    // End

echo "<script>alert('Copy product Types !');location.href='spec_settings_pro_types.php?pr_id=".$c_id."';</script>";
exit();
}

if(trim($_REQUEST['kinds'])=='add_producttypes'){
$str_m="select ProductTypeID FROM producttypes order by ProductTypeID desc limit 1";
$check_m=mysqli_query($link_db,$str_m);
$Max_COptionID=mysqli_fetch_row($check_m);
$MCount=$Max_COptionID[0]+1;
if(isset($_POST['APM1'])!=''){
$m1=trim($_POST['APM1']);
}else{
$m1="";
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
if(isset($_POST['aspeccate'])<>''){
  foreach($_POST['aspeccate'] as $check1) {  
  $str1=$str1.$check1.",";
  }
}else{
  $str1='';
}

if(isset($_POST['aspectype'])<>''){
  foreach($_POST['aspectype'] as $check2){
  $str2=$str2.$check2.",";
  }
}else{
  $str2='';
}

if(isset($_POST['aspectype_sub'])<>''){
  foreach($_POST['aspectype_sub'] as $check3){
  $str3=$str3.$check3.",";
  }
}else{
  $str3='';
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s"); 

$str_sku="insert into producttypes (`ProductTypeID`, `ProductTypeName`, `SPECCategories`, `SPECType`, `SPECType_Sub`, `GUID`, `crea_d`, `crea_u`) values ($MCount,'$m1','$str1','$str2','$str3','$guid','$now','1782')";
$cmd_sku=mysqli_query($link_db,$str_sku);

    //寫入 product_skus_categories Start
    $str_m1="select Product_SKU_Cid FROM product_skus_categories order by Product_SKU_Cid desc limit 1";
    $check_m1=mysqli_query($link_db,$str_m1);
    $Max_GskuID=mysqli_fetch_row($check_m1);
    $GCount=$Max_GskuID[0]+1;

    $str_ins="insert into `product_skus_categories` (`Product_SKU_Cid`, `ProductTypeID`, `SKUs_Conditions`, `GUID`, `crea_u`, `crea_d`, `IsStatus`) values ($GCount,$MCount,'','$guid','$now','1782','1')";
    $cmd_ins=mysqli_query($link_db,$str_ins);
    // End

echo "<script>alert('Add product Types !');location.href='spec_settings_pro_types.php?pr_id=".$pr_id."';</script>";
exit();
}

if(trim($_REQUEST['kinds'])=='edit_producttypes'){
if(isset($_POST['SPEC_id'])!=''){
$s_id=intval($_POST['SPEC_id']);
}else{
$s_id="";
}
if(isset($_POST['PM1'])!=''){
$m1=$_POST['PM1'];
}else{
$m1="";
}

if(isset($_POST['stype_sr01a'])!=''){
/* Stype Sort */
$stype_all=trim($_POST['stype_sr01a']);
$stype_split=explode(",",$stype_all,-1);
foreach($stype_split as $stype_spstr){
  //echo "update spectypes set =".$_POST['spectype_'.$stype_spstr]." where SPECTypeID=".$stype_spstr."<br />";
  //echo $stype_spstr."<br />";
  $str_typeSort="update spectypes set SPECTypeSort=".$_POST['spectype_'.$stype_spstr]." where SPECTypeID=".$stype_spstr;
  $check_typeSort=mysqli_query($link_db,$str_typeSort);  
}
/* End */
}
$str1="";
if(isset($_POST['mspeccate'])<>''){
  foreach($_POST['mspeccate'] as $check1) {
  $str1=$str1.$check1.",";
  }
}else{
  $str1='';
}  

if(isset($_POST['spectype'])<>''){
  foreach($_POST['spectype'] as $check2){
  $str2=$str2.$check2.",";
  }
}else{
  $str2='';
}  

if(isset($_POST['spectype_sub'])<>''){  
  foreach($_POST['spectype_sub'] as $check3){
  $str3=$str3.$check3.",";
  }
}else{
  $str3='';
}

$str_sku="update producttypes set `ProductTypeName`='".$m1."',`SPECCategories`='".$str1."',`SPECType`='".$str2."',`SPECType_Sub`='".$str3."' where `ProductTypeID`=".$s_id;
//echo $str_sku;
$cmd_sku=mysqli_query($link_db,$str_sku);

echo "<script>alert('Mod product Types !');location.href='spec_settings_pro_types.php?pr_id=".$s_id."';</script>";
exit();
}
}
$str11="select count(*) from producttypes";
$list11 =mysqli_query($link_db,$str11);
list($public_count)=mysqli_fetch_row($list11);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SPEC Creation Tool - SPEC Settings (Product Types)</title>
<link rel="stylesheet" type="text/css" href="../backend.css">
<link rel="stylesheet" type="text/css" href="../css/css.css" />
<script type="text/javascript" src="../jquery.min.js"></script>

<link type="text/css" href="../lib/css/ui-lightness/jquery-ui-1.8.22.custom.css" rel="stylesheet" />
<script type="text/javascript" src="../lib/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="../lib/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript">
$(function(){
// Accordion
$("#accordion").accordion({ header: "h3" });
// Progressbar
$("#progressbar").progressbar({
value: 20
});
//hover states on the static widgets
$('#dialog_link, ul#icons li').hover(
function() { $(this).addClass('ui-state-hover'); },
function() { $(this).removeClass('ui-state-hover'); }
);        
});
</script>    
<script type="text/javascript" src="../fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript">
	  $(document).ready(function() {
	  
	  for(i=1;i<26;i++){
      $("#Fancy_iframe_copy"+i).fancybox({
				'width'				: '80%',
				'height'			: '60%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
	  });
	  
      }
      
      for(ii=1;ii<26;ii++){     
      
      $("#Fancy_iframe_edit"+ii).fancybox({
				'width'				: '80%',
				'height'			: '60%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
	  });
      
	  }
      
      
    });
</script>    

<script language="JavaScript">
<!--
  function Del_id(t_id){    
    if(confirm("確定要刪除此筆資料嗎？")) {
    self.location="?d_id="+t_id;
    }else{
    //alert("取消刪除!");
    }
  }  
//-->
</script>    
<script language="JavaScript">
function aopen(val){
$('#accordion'+val).click(function() {  
        //$('#accordion_sub'+val).toggle();
        //$('#accordion_sub'+val).unbind('click').toggle();
        //$('#accordion_sub'+val).slideToggle();
        //var sub_hidden=$('#accordion_sub'+val).is(":hidden");
        //var sub_show=$('#accordion_sub'+val).is(":visible");
        //if($('#accordion_sub'+val).is(":hidden")){ $(this).show(); }
        //if($('#accordion_sub'+val).is(":visible")){ $(this).hide(); }
        if($('#accordion_sub'+val).is(":hidden")){
        $('#speccate[]').is(':checked');
        $('#accordion'+val).hide();
        $('#accordion_c'+val).show(); 
        $('#accordion_sub'+val).show(); 
        }  
   
        return false;  
        });
}

function aclose(val){
$('#accordion_c'+val).click(function() {  

        if($('#accordion_sub'+val).is(":visible")){
        $('#accordion_c'+val).hide();
        $('#accordion'+val).show(); 
        $('#accordion_sub'+val).hide(); 
        }  
   
        return false;  
        });
}

function mopen(val){
$('#maccordion'+val).click(function() {  
        if($('#maccordion_sub'+val).is(":hidden")){
        $('#mspeccate[]').is(':checked');
        $('#maccordion'+val).hide();
        $('#maccordion_c'+val).show(); 
        $('#maccordion_sub'+val).show(); 
        }  
   
        return false;  
        });
}

function mclose(val){
$('#maccordion_c'+val).click(function() {  

        if($('#maccordion_sub'+val).is(":visible")){
        $('#maccordion_c'+val).hide();
        $('#maccordion'+val).show(); 
        $('#maccordion_sub'+val).hide(); 
        }  
   
        return false;  
        });
}


function copen(val){
$('#caccordion'+val).click(function() {  

        if($('#caccordion_sub'+val).is(":hidden")){
        $('#speccate_c[]').is(':checked');
        $('#caccordion'+val).hide();
        $('#caccordion_c'+val).show(); 
        $('#caccordion_sub'+val).show(); 
        }   
        return false;  
        });
}

function cclose(val){
$('#caccordion_c'+val).click(function() {  

        if($('#caccordion_sub'+val).is(":visible")){
        $('#caccordion_c'+val).hide();
        $('#caccordion'+val).show(); 
        $('#caccordion_sub'+val).hide(); 
        }   
        return false;  
        });
}



function check_type(tval){
var i=0;
for(i=0;i<document.form2.elements.length;i++){                
   if((document.form2.elements[i].type == "checkbox") && (document.form2.elements[i].name == "aspeccate[]") && (document.form2.elements[i].value==tval))
   { 
        //if(document.form2.elements[i].value=tval){

         //alert(document.form2.elements[i].value);
         var Fname = '.aspectype_s'+tval;//spectype[] Class
         var lenA = $(Fname+":checked").length;
         if(lenA>0){
         document.form2.elements[i].checked=true;
         }else{
         document.form2.elements[i].checked=false;
         }
         document.getElementById('checkCount'+tval).innerHTML = "<font color=red><b>" + lenA + "</b></font> Item Checked";

         //document.form2.elements["aspeccate[]"].checked=true;
        //}
        //document.form2.elements[i].checked=true;
        //var sct=document.form2.elements["aspectype[]"];
        //if(sct.checked){
        //alert(sct.checked);
        //document.form2.elements["aspeccate[]"].checked=true;
        //}             
   }
   //alert(document.form2.elements[i].name); 

}

 //var sct=document.form2.elements["aspectype[]"];
 //if(sct.checked==){
 //alert(sct.checked);
 //}
}

function check_subtype(tval,val){
var i=0;
for(i=0;i<document.form2.elements.length;i++){
      
   if((document.form2.elements[i].type == "checkbox") && (document.form2.elements[i].name == "aspectype[]") && (document.form2.elements[i].value==tval))
   {
         //alert(tval);
         var Fname = '.aspectype_sub_s'+tval;//aspectype_sub[] Class
         var lenA = $(Fname+":checked").length;
         if(lenA>0){
         document.form2.elements[i].checked=true;
         }else{
         document.form2.elements[i].checked=false;
         }
         //document.getElementById('SubcheckCount'+tval).innerHTML = "<font color=red><b>" + lenA + "</b></font> Item Checked";
   }
   if((document.form2.elements[i].type == "checkbox") && (document.form2.elements[i].name == "aspeccate[]") && (document.form2.elements[i].value==val))
   {
         var Sname = '.aspectype_s'+val;//aspeccate[] Class
         var lenB = $(Sname+":checked").length+1;
         //alert(lenB);
         if(lenB>0){
         document.form2.elements[i].checked=true;
         }else{
         document.form2.elements[i].checked=false;
         }
         //document.getElementById('SubcheckCount'+tval).innerHTML = "<font color=red><b>" + lenA + "</b></font> Item Checked";
   }  
   
}

}

function checked_scate(cVal){
//alert(cVal);
var ci=0;
for(ci=0;ci<document.form1.elements.length;ci++){   
   if((document.form1.elements[ci].type == "checkbox") && (document.form1.elements[ci].name == "mspeccate[]") && (document.form1.elements[ci].value==cVal))
   {
	 document.form1.elements[ci].checked=true;
   }
}
}

function checked_scate_cp(cVal){
//alert(cVal);
var ci1=0;
for(ci1=0;ci1<document.form3.elements.length;ci1++){   
   if((document.form3.elements[ci1].type == "checkbox") && (document.form3.elements[ci1].name == "speccate_c[]") && (document.form3.elements[ci1].value==cVal))
   {
	 document.form3.elements[ci1].checked=true;
   }
}
}

function mcheck_type(ttval){
var ii=0;
for(ii=0;ii<document.form1.elements.length;ii++){                
   if((document.form1.elements[ii].type == "checkbox") && (document.form1.elements[ii].name == "mspeccate[]") && (document.form1.elements[ii].value==ttval))
   { 
         var Fname = '.spectype_s'+ttval;  //spectype[] Class
         var len = $(Fname+":checked").length;
         //if(document.form1.elements[ii].name == "spectype[]"){                
         //var count = $("input:checked").length;
         //var count = $("input[name='spectype[]']:checked").length;
         //var len = $("#sptype_s101 input[name='spectype[]']:checked").length;

         //var len= $('form#form1 div#sptype_s101 input[type="checkbox"]:checked').size();
         //var len = $("form#form1 div#sptype_s101").find("input:checked").length;
         //var len= $('div#sptype_s101').find('input[type="checkbox"]:checked').length;
         
         //var len = document.getElementById(Fname).getElementsByTagName("checkbox");
         
         //for(var i=0; i<boxes.length; i++)
         //{ 
         //boxes[i].checked = true;
         //}
         //var len = jQuery('div'+Fname+' input[name="spectype[]"]:checked').length;
         if(len>0){
         document.form1.elements[ii].checked=true;
         }else{
         document.form1.elements[ii].checked=false;
         }
         
         document.getElementById('mcheckCount'+ttval).innerHTML = "<font color=red><b>" + len + "</b></font> Item Checked";
         
         
   }

}
}

function mcheck_subtype(ttval,val){
var ii=0;
for(ii=0;ii<document.form1.elements.length;ii++){                
   
   if((document.form1.elements[ii].type == "checkbox") && (document.form1.elements[ii].name == "spectype[]") && (document.form1.elements[ii].value==ttval))
   { 
         var Fname = '.spectype_sub_s'+ttval;  //spectype[] Class
         var lenC = $(Fname+":checked").length;
         if(lenC>0){
         document.form1.elements[ii].checked=true;
         }else{
         document.form1.elements[ii].checked=false;
         }
         
         //document.getElementById('mcheckCount'+ttval).innerHTML = "<font color=red><b>" + len + "</b></font> Item Checked";
   }
   
   if((document.form1.elements[ii].type == "checkbox") && (document.form1.elements[ii].name == "speccate[]") && (document.form1.elements[ii].value==val))
   { 
         var Fname = '.spectype_s'+val;  //spectype[] Class
         var lenD = $(Fname+":checked").length+1;
         if(lenD>0){
         document.form1.elements[ii].checked=true;
         }else{
         document.form1.elements[ii].checked=false;
         }
         
         //document.getElementById('mcheckCount'+ttval).innerHTML = "<font color=red><b>" + len + "</b></font> Item Checked";
   }


}
}


function ccheck_type(ttval){
var ii=0;
for(ii=0;ii<document.form3.elements.length;ii++){                
   if((document.form3.elements[ii].type == "checkbox") && (document.form3.elements[ii].name == "speccate_c[]") && (document.form3.elements[ii].value==ttval))
   { 
         var Fname = '.spectype_sc'+ttval;  //spectype[] Class
         var len = $(Fname+":checked").length;

         if(len>0){
         document.form3.elements[ii].checked=true;
         }else{
         document.form3.elements[ii].checked=false;
         }         
         document.getElementById('ccheckCount'+ttval).innerHTML = "<font color=red><b>" + len + "</b></font> Item Checked";
   }

}
}

function ccheck_subtype(ttval,val){
var ii=0;
for(ii=0;ii<document.form3.elements.length;ii++){                
   
   if((document.form3.elements[ii].type == "checkbox") && (document.form3.elements[ii].name == "spectype_c[]") && (document.form3.elements[ii].value==ttval))
   { 
         var Fname = '.spectype_sub_sc'+ttval;  //spectype[] Class
         var lenC = $(Fname+":checked").length;
         if(lenC>0){
         document.form3.elements[ii].checked=true;
         }else{
         document.form3.elements[ii].checked=false;
         }
         
         //document.getElementById('mcheckCount'+ttval).innerHTML = "<font color=red><b>" + len + "</b></font> Item Checked";
   }
   
   if((document.form3.elements[ii].type == "checkbox") && (document.form3.elements[ii].name == "speccate_c[]") && (document.form3.elements[ii].value==val))
   { 
         var Fname = '.spectype_sc'+val;  //spectype[] Class
         var lenD = $(Fname+":checked").length+1;
         if(lenD>0){
         document.form3.elements[ii].checked=true;
         }else{
         document.form3.elements[ii].checked=false;
         }
         
         //document.getElementById('mcheckCount'+ttval).innerHTML = "<font color=red><b>" + len + "</b></font> Item Checked";
   }


}
}



function hiden_add(){
//$("#subsettings_add").hide();//隱藏
self.location="spec_settings_pro_types.php";
}

function hiden_edit(){
//$("#subsettings_edit").hide();//隱藏
self.location="spec_settings_pro_types.php";
}
function hiden_copy(){
//$("#subsettings_copy").hide();//隱藏
self.location="spec_settings_pro_types.php";
}
function show_add(){
/*
var ck=document.form1.elements["speccate[]"];
var ckAll=document.form1.allbox;
if(!ck){
//ckAll.checked= false;
ck.checked=false;
}else if(!ck.length){
ck.checked=false;
}
*/
$("#subsettings_add").show();//顯示
$("#subsettings_edit").hide();
$("#subsettings_copy").hide();
}
function show_edit(){
$("#subsettings_add").hide();
$("#subsettings_edit").show();//顯示
$("#subsettings_copy").hide();
}
function show_copy(){
$("#subsettings_add").hide();
$("#subsettings_edit").hide();//顯示
$("#subsettings_copy").show();
}
function MM_o(selObj){
//window.open(document.all.pskus_page.options[document.all.pskus_page.selectedIndex].value,"_self");
window.open(document.getElementById('pskus_page').options[document.getElementById('pskus_page').selectedIndex].value,"_self");
}

function MM_PT(selObj){
//window.open(document.all.SEL_PTYPE.options[document.all.SEL_PTYPE.selectedIndex].value,"_self");
window.open(document.getElementById('SEL_PTYPE').options[document.getElementById('SEL_PTYPE').selectedIndex].value,"_self");
}   
</script>

</head>
<!--
oncontextmenu="window.event.returnValue=false" 
onkeypress="window.event.returnValue=true" 
onkeydown="window.event.returnValue=true" 
onkeyup="window.event.returnValue=false" 
ondragstart="window.event.returnValue=false" 
onselectstart="event.returnValue=false"
-->
<body ><a name="top"></a>
<div>
<div class="left"><h1>&nbsp;&nbsp;Website Backends - SPEC Creation Tool</h1></div>
<div id="logout">Hi <b><?=str_replace('@mic.com.tw', '', $_SESSION['user']);?></b> <a href="./logo.php">Log out &gt;&gt;</a></div>
</div>
<div class="clear"></div>
<?php
include("./menu.php");
?>

<div class="clear"></div>
<div id="Search" >
<h2><a href="spec_settings.php">SPEC Settings</a> &nbsp;&gt;&nbsp; Product Types</h2>
</div>

<div id="content">

<p class="clear"></p>

<div >
<div class="left"><h3>Product Types List:</h3></div>

<div class="left" style="padding:20px 8px 0px 20px">
<select id="SEL_PTYPE" onChange="MM_PT(this)">
<!--<option value="spec_settings_pro_types.php">Product Type: All</option>-->
<?php
$str_type="select ProductTypeID,ProductTypeName from producttypes";
$type_result=mysqli_query($link_db,$str_type);
while(list($ProductTypeID,$ProductTypeName)=mysqli_fetch_row($type_result))
{
?>
<option value="spec_settings_pro_types.php?pr_id=<?=$ProductTypeID?>" <?php if($pr_id==$ProductTypeID){ echo "selected"; }?>><?=$ProductTypeName?></option>
<?php
}
?>
</select>
</div>
</div>
<p class="clear"></p>
<!--List all product types, datatable start here-->
<div class="pagination left"><!--Total: <span class="w14bblue"><?=$public_count;?></span> records &nbsp;&nbsp;--></div>
<p class="clear"></p>
<table class="list_table2">
	<tr>
	<th width="200">Product Type Name</th>
	<th>SPEC Categories</th>	
    <th onClick="" width="100">Update Date</th>
    <th onClick="" width="100">Updated by</th> 
    <th width="120"><div class="button14" style="width:100px;"><a href="#subsettings_add" onClick="show_add();">Add New</a></div></th>
	</tr>
  <?php
	  if(isset($_REQUEST['page'])==""){
      $page="1";
      }else{
      $page=intval($_REQUEST['page']);
      }
      
      if(empty($page))$page="1";
      
      $read_num="1";
      $start_num=$read_num*($page-1);
      //$str="SELECT * FROM producttypes ORDER BY ProductTypeID Asc limit $start_num,$read_num;";
      $str="SELECT * FROM producttypes where ProductTypeID=".$pr_id." ORDER BY ProductTypeID Asc limit $start_num,$read_num;";      

      $result=mysqli_query($link_db, $str);
      $i=0;
	  while(list($ProductTypeID,$ProductTypeName,$SPECCategories,$SPECType,$SPECType_Sub,$GUID,$crea_d,$crea_u,$upd_d,$upd_u)=mysqli_fetch_row($result))
      {
      $i=$i+1;
      putenv("TZ=Asia/Taipei");
  ?>
	<tr class="list_table_con" >
	<td valign="top"><?=$ProductTypeName;?></td>
	<td>
    <?php
    $SPECCategories = explode(",",$SPECCategories);
    //count($SPECCategories) TotalCount    
    //foreach($SPECCategories as $check){    
    echo "<table border='0'>";    
    for($k=0;$k<count($SPECCategories)-1;$k++){
    
    $str_type="select SPECCategoryID,SPECCategoryName FROM speccategroies where SPECCategoryID=".$SPECCategories[$k];
    $type_result=mysqli_query($link_db,$str_type);
    $data=mysqli_fetch_array($type_result);
    echo "<tr>";
    echo "<td>".$data[1]."</td>";
    echo "<td>";

        $k1=0;
        $str_sectype1="select SPECTypeID,SPECCategoryID,SPECTypeName,IsShow FROM spectypes where IsShow='1' and SPECCategoryID=".$data[0];
		$sectype_result1=mysqli_query($link_db,$str_sectype1);
        while($stdata1=mysqli_fetch_row($sectype_result1))
        {
        $k1=$k1+1;
        
          if(preg_match("/".$stdata1[0]."/i",$SPECType)!=''){
        
            $str_s=$stdata1[2].":&nbsp;";
            echo $str_s;            
            $str_sectype2="select SPECTypeID,SPECCategoryID,SPECTypeName,IsShow FROM spectypes where ParentSpec=".$stdata1[0];
            $sectype_result2=mysqli_query($link_db,$str_sectype2);
            while($stdata2=mysqli_fetch_row($sectype_result2)){
             if(preg_match("/".$stdata2[0]."/i",$SPECType_Sub)!=''){
             echo "<b>".$stdata2[2]."&nbsp;,&nbsp;</b>";
             }
            }            
            //echo substr($str_s, 0, strlen($str_s)-1);
            //if($k1%4==0){
            echo "<br />";
            //}
            
          } 
        }

    echo "</td>";
    echo "</tr>";    
    }
    echo "</table>";
    //}    
    ?>
	</td>		       
	<td valign="top">
    <?php
    if($upd_d==''){
    echo $crea_d;
    }else{
    echo $upd_d;
    }
    ?>
    </td>
	<td valign="top">
    <?php
    if($upd_u==''){
    echo $crea_u;
    }else{
    echo $upd_u;
    }
    ?>
    </td>           
	<td valign="top">
    <a href="?pr_id=<?=$ProductTypeID;?>&types=edit#subsettings_edit">Edit</a>&nbsp;&nbsp;
    <a href="?pr_cid=<?=$ProductTypeID;?>&types=copy#subsettings_copy">copy</a>&nbsp;&nbsp;
    <!--<a id="Fancy_iframe_copy<?=$i;?>" href="Copy_pro_type.php?pr_id=<?=$ProductTypeID;?>">copy</a> &nbsp;-->
    <!--<input type="button" name="D_This" value="Del" onClick="Del_id(<?=$ProductTypeID;?>);">-->
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
<!--
<div class="sabrosus"><span class="w14bblue"><?=$read_num?></span> Records Per Page &nbsp;&nbsp;| &nbsp;&nbsp;Page: &nbsp;
<select id="pskus_page" name="pskus_page" onChange="MM_o(this)">
-->
<?php
//for($j=1;$j<=$total;$j++){
?>
<!--<option value="?page=<?=$j?>" <?php if($page==$j){ echo "selected"; } ?>><?=$j?></option>-->
<?php
//}
?>
<!--</select>&nbsp;&nbsp; -->
<?php //echo $pagenav;?>
</div>					
<p>&nbsp;</p><p>&nbsp;</p><p class="clear"></p>
<!--end of List all product types, datateble-->
<!--Add, Edit, Copy Product Type-->
<?php
if(isset($_REQUEST['pr_id'])<>""){
//echo "<script type=\"text/javascript\">document.getElementById('subsettings_edit').style.display='block';</script>\n";
//echo "<script type='text/javascript'>document.getElementById('subsettings_edit').style.display='block';</script>";
//echo "<script>show_edit();</script>\n";
//echo "<script type='text/javascript'>alert('Be ok');</script>"; 
$pr_PTYPEs=intval($_REQUEST['pr_id']);
$methods="edit_producttypes";

  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
  mysqli_query($link_db,'SET NAMES utf8');
  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
  //$select=mysqli_select_db($dataBase, $link_db);  
  $str_ptype_m="select * from producttypes where ProductTypeID=".$pr_PTYPEs;
  $cmd_ptype_m=mysqli_query($link_db,$str_ptype_m);
  $record_ptype_m=mysqli_fetch_row($cmd_ptype_m);
  
  if(empty($record_ptype_m)):
  else:
    $PM0=$record_ptype_m[0];
    $PM1=$record_ptype_m[1];
    $PM2=$record_ptype_m[2];
    $PM3=$record_ptype_m[3];
    $PM4=$record_ptype_m[4];    
  endif;
}else {
$methods="add_producttypes";
}
?>

<div id="subsettings_edit" class="subsettings" style="display:none">
<form id="form1" name="form1" method="post" action="?kinds=edit_producttypes" onsubmit="return Final_Check();">
<!--Click close to close this subsettings div--><div class="right"><a href="#" OnClick="hiden_edit();"> [close] </a></div><!--end of close-->
<table class="addspec">
<tr><td colspan="2"></td></tr>
<tr>
<th>Product Type Name:</th>
<td>
<input type="hidden" name="SPEC_id" value="<?=$PM0?>">
<input name="PM1" type="text" size="30" value="<?=$PM1;?>" /> </td>
</tr>
<tr>
<th>Categories:</th>
<td>
	  <div>
      <?php
      $str_type_s="select SPECCategoryID,SPECCategoryName,IsShow FROM speccategroies order by SPECCategoryName";
      $types_result=mysqli_query($link_db,$str_type_s);
      $u=0;
	  while($data=mysqli_fetch_row($types_result)){
      $u=$u+1;
      ?>       
      <div id="maccordion<?=$u;?>" style="cursor:pointer" onClick="mopen(<?=$u;?>);"><img src="../images/icon_add.gif" border="0"> <?=$data[1];?></div>
	  <div id="maccordion_c<?=$u;?>" onClick="mclose(<?=$u;?>);" style="display:none; cursor:pointer;"><img src="../images/icon_hide.gif" border="0"> <?=$data[1];?></div><span id="mcheckCount<?=$data[0];?>"></span>
      <div id="maccordion_sub<?=$u;?>" style="display:none; width:1000px;">        
        <div>
        <table>
        <tr>
        <input name="mspeccate[]" type="checkbox" style="display:none" value="<?=$data[0];?>" /><?php if(strpos($PM2, $data[0].",")!="" || strpos($PM2, $data[0].",")===0) { echo "<script>checked_scate('".$data[0]."');</script>"; } ?>
        <div id="msptype_s<?=$data[0];?>">        
        <td>
        <?php
        $k=0;$styp_str="";$str_L="";$str_R="";
        //$str_sectype="select SPECTypeID,SPECCategoryID,SPECTypeName,IsShow FROM spectypes where SPECCategoryID=".$data[0];
        //$str_sectype="select SPECTypeID,SPECCategoryID,SPECTypeName,IsShow FROM spectypes where ParentSpec is NULL and InputTypeID >1 and SPECCategoryID=".$data[0];
        $str_sectype="select SPECTypeID,SPECCategoryID,SPECTypeName,IsShow,SPECTypeSort FROM spectypes where ParentSpec is NULL and IsShow='1' and SPECCategoryID=".$data[0];
        $sectype_result=mysqli_query($link_db,$str_sectype);
		mysqli_query($link_db,'SET NAMES utf8');
		mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
		mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
        while($stdata=mysqli_fetch_row($sectype_result)){
        $k=$k+1;
        $styp_str.=$stdata[0].",";
		?>
        <input name="spectype[]" class="spectype_s<?=$data[0];?>" type="checkbox" value="<?=$stdata[0];?>" onclick="mcheck_type(<?=$data[0];?>);" <?php if(strpos($PM3, $stdata[0].",")!='' || strpos($PM3, $stdata[0].",")===0){ echo "checked"; } //if(eregi($stdata[0],$PM3)!='') { echo "checked"; } ?> /><input name="spectype_<?=$stdata[0];?>" type="text" size="2" value="<?=$k;?>" />
          <?php          
          echo $stdata[2].$str_L;                    
          $l=0;
          $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
          //$select=mysqli_select_db($dataBase, $link_db);
          $str_sectype_sub="select SPECTypeID,SPECCategoryID,SPECTypeName,IsShow FROM spectypes where InputTypeID<3 and SPECCategoryID=".$stdata[1]." and ParentSpec=".$stdata[0];
          $sectype_result_sub=mysqli_query($link_db,$str_sectype_sub);       
          while($stdata_sub=mysqli_fetch_row($sectype_result_sub)){
          $l=$l+1;
          $str_L=":(";
          $str_R=")";
          echo "<input name=spectype_sub[] class=spectype_sub_s".$stdata[0]." type='checkbox' value=".$stdata_sub[0]." onclick='mcheck_subtype(".$stdata[0].",".$data[0].");'";
          if(preg_match("/".$stdata_sub[0]."/i",$PM4)!='') { echo "checked"; }
          echo " />";
          ?>
          <!--<input name="spectype_sub[]" class="spectype_sub_s<?=$stdata[0];?>" type="checkbox" value="<?=$stdata_sub[0];?>" onclick="mcheck_subtype(<?=$stdata[0];?>);" <? if(preg_match("/".$stdata_sub[0]."/i",$PM4)!='') { echo "checked"; } ?> />--> <font color="red"><?=$stdata_sub[2];?></font>
          <?php
          }
          echo $str_R;          
          ?>
        <?php
        if($k%5==0){ echo "<br />"; }
        }
        ?>        
        </td>
        
        </div>
        </tr>        
        </table>
        </div>
        
	  </div>
      <?php
      }
      ?>
      </div>
</td>
</tr>
<tr><td colspan="2"><input type="hidden" name="stype_sr01a" value="<?=$styp_str;?>"><input type="submit" value="Done" />&nbsp;&nbsp;</td></tr>
</table>
</form>
<script language="JavaScript">
function Final_Check(){
if ( document.form1.PM1.value == "" ) {
alert ("請選擇 ProductTypeName！");
document.form1.PM1.focus();
return false;
}
return true;
}
</script>
</div>
<div id="subsettings_add" class="subsettings" style="display:none">
<form id="form2" name="form2" method="post" action="?kinds=add_producttypes" onsubmit="return AFinal_Check();">
<!--Click close to close this subsettings div--><div class="right"><a href="#" OnClick="hiden_add();"> [close] </a></div><!--end of close-->
<table class="addspec">
<tr><td colspan="2"></td></tr>
<tr>
<th>Product Type Name:</th>
<td>
<input name="APM1" type="text" size="30" value="" /> </td>
</tr>
<tr>
<th>Categories:</th>
<td>
	  <div>
      <?php
      $str_type_s="select SPECCategoryID,SPECCategoryName,IsShow FROM speccategroies order by SPECCategoryName";
      $types_result=mysqli_query($link_db,$str_type_s);
      $u=0;
	  while($data=mysqli_fetch_row($types_result)){
      $u=$u+1;
      ?>
      <div id="accordion<?=$u;?>" style="cursor:pointer" onClick="aopen(<?=$u;?>);"><img src="../images/icon_add.gif" border="0"> <?=$data[1];?></div>
	  <div id="accordion_c<?=$u;?>" onClick="aclose(<?=$u;?>);" style="display:none; cursor:pointer;"><img src="../images/icon_hide.gif" border="0"> <?=$data[1];?></div><span id="checkCount<?=$data[0];?>"></span>
      <div id="accordion_sub<?=$u;?>" style="display:none; width:1000px;">
   
        <div>
        <table>
        <tr>
        <input name="aspeccate[]" type="checkbox" value="<?=$data[0];?>" style="display:none" />
        <div id="sptype_s<?=$data[0];?>">        
        <td>
        <?php
        $k=0;
        //$str_sectype="select SPECTypeID,SPECCategoryID,SPECTypeName,IsShow FROM spectypes where ParentSpec is NULL and InputTypeID >1 and SPECCategoryID=".$data[0];//主 ProductType
        $str_sectype="select SPECTypeID,SPECCategoryID,SPECTypeName,IsShow FROM spectypes where ParentSpec is NULL and IsShow='1' and SPECCategoryID=".$data[0];
        //$str_sectype="select SPECTypeID,SPECCategoryID,SPECTypeName,ParentSpec,InputTypeID,IsShow FROM spectypes where SPECCategoryID=".$data[0];
        $sectype_result=mysqli_query($link_db,$str_sectype);
        while($stdata=mysqli_fetch_row($sectype_result)){
        $k=$k+1; 
        ?>         
          <input name="aspectype[]" class="aspectype_s<?=$data[0];?>" type="checkbox" value="<?=$stdata[0];?>" onclick="check_type(<?=$data[0];?>);" /><input name="spectype_<?=$stdata[0];?>" type="text" size="4" value="<?=$k;?>" />
          <?php
          echo $stdata[2].$str_L;
          $l=0;
          $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
		  mysqli_query($link_db,'SET NAMES utf8');
		  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
		  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
          //$select=mysqli_select_db($dataBase, $link_db);
          $str_asectype_sub="select SPECTypeID,SPECCategoryID,SPECTypeName,IsShow FROM spectypes where InputTypeID<3 and SPECCategoryID=".$stdata[1]." and ParentSpec=".$stdata[0];
          $asectype_result_sub=mysqli_query($link_db,$str_asectype_sub);           
          while($astdata_sub=mysqli_fetch_row($asectype_result_sub)){
          $l=$l+1;
          $str_L=":(";
          $str_R=")";          
          echo"<input name=aspectype_sub[] class=aspectype_sub_s".$stdata[0]." type='checkbox' value=".$astdata_sub[0]." onclick='check_subtype(".$stdata[0].",".$data[0].");' />";
          ?>
          <!--<input name="aspectype_sub[]" class="aspectype_sub_s<?=$stdata[0];?>" type="checkbox" value="<?=$astdata_sub[0];?>" onclick="check_subtype(<?=$stdata[0];?>);" />--> <font color="red"><?=$astdata_sub[2];?></font>
          <?php
          }
          echo $str_R;         
          ?>        
        <?php
        if($k%5==0){ echo "<br />"; }
        }
        ?>
        </td>        
        </div>        
        </tr>        
        </table>
        </div>
	  </div>
      <?php
      }
      ?>
      </div>
</td>
</tr>
<tr><td colspan="2"><input type="submit" value="Done" />&nbsp;&nbsp;</td></tr>
</table>
</form>
<script language="JavaScript">
function AFinal_Check(){
if ( document.form2.APM1.value == "" ) {
alert ("請選擇 ProductTypeName！");
document.form2.APM1.focus();
return false;
}
return true;
}
</script>
</div>
<?php
if(isset($_REQUEST['pr_cid'])<>""){
$pr_PTYPEc=intval($_REQUEST['pr_cid']);
$methods="copy_producttypes";
  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
  mysqli_query($link_db,'SET NAMES utf8');
  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
  //$select=mysqli_select_db($dataBase, $link_db);  
  $str_ptype_c="select * from producttypes where ProductTypeID=".$pr_PTYPEc;
  $cmd_ptype_c=mysqli_query($link_db,$str_ptype_c);
  $record_ptype_c=mysqli_fetch_row($cmd_ptype_c);  
  if(empty($record_ptype_c)):
  else:
    $CPM0=$record_ptype_c[0];
    $CPM1=$record_ptype_c[1];
    $CPM2=$record_ptype_c[2];
    $CPM3=$record_ptype_c[3];
    $CPM4=$record_ptype_c[4];    
  endif;
}
?>
<div id="subsettings_copy" class="subsettings" style="display:none">
<form id="form3" name="form3" method="post" action="?kinds=copy_producttypes" onsubmit="return CFinal_Check();">
<!--Click close to close this subsettings div--><div class="right"><a href="#" OnClick="hiden_copy();"> [close] </a></div><!--end of close-->
<table class="addspec">
<tr><td colspan="2"></td></tr>
<tr>
<th>Product Type Name:</th>
<td>
<input type="hidden" name="SPEC_cid" value="<?=$CPM0?>">
<input name="CPM1" type="text" size="30" value="" /> <font color="red"><?=$CPM1;?></font></td>
</tr>
<tr>
<th>Categories:</th>
<td>
	  <div>
      <?php
      $str_type_s="select SPECCategoryID,SPECCategoryName,IsShow FROM speccategroies order by SPECCategoryName";
      $types_result=mysqli_query($link_db,$str_type_s);
      $uu=0;
	  while($data=mysqli_fetch_row($types_result)){
      $uu=$uu+1;
      ?>       
      <div id="caccordion<?=$uu;?>" style="cursor:pointer" onClick="copen(<?=$uu;?>);"><img src="../images/icon_add.gif" border="0"> <?=$data[1];?></div>
	  <div id="caccordion_c<?=$uu;?>" onClick="cclose(<?=$uu;?>);" style="display:none; cursor:pointer;"><img src="../images/icon_hide.gif" border="0"> <?=$data[1];?></div><span id="ccheckCount<?=$data[0];?>"></span>
      <div id="caccordion_sub<?=$uu;?>" style="display:none; width:1000px;">        
        <div>
        <table>
        <tr>
        <input name="speccate_c[]" type="checkbox" value="<?=$data[0];?>" style="display:none" /><?php if(preg_match("/".$data[0]."/i",$CPM2)!='') { echo "<script>checked_scate_cp('".$data[0]."');</script>"; } ?>
        <div id="msptype_s<?=$data[0];?>">        
        <td>
        <?php
        $kk=0;
        $str_sectype="select SPECTypeID,SPECCategoryID,SPECTypeName,IsShow,SPECTypeSort FROM spectypes where ParentSpec is NULL and SPECCategoryID=".$data[0];
        $sectype_result=mysqli_query($link_db,$str_sectype);
        while($stdata=mysqli_fetch_row($sectype_result)){
        $kk=$kk+1;
        ?>
        <input name="spectype_c[]" class="spectype_sc<?=$data[0];?>" type="checkbox" value="<?=$stdata[0];?>" onclick="ccheck_type(<?=$data[0];?>);" <?php if(preg_match("/".$stdata[0]."/i",$CPM3)!='') { echo "checked"; } ?> /><input name="spectype_<?=$stdata[0];?>" type="text" size="4" value="<?=$stdata[4];?>" />
          <?php          
          echo $stdata[2].$str_L;                    
          $ll=0;
          $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
          //$select=mysqli_select_db($dataBase, $link_db);
          $str_sectype_sub="select SPECTypeID,SPECCategoryID,SPECTypeName,IsShow FROM spectypes where InputTypeID<3 and SPECCategoryID=".$stdata[1]." and ParentSpec=".$stdata[0];
          $sectype_result_sub=mysqli_query($link_db,$str_sectype_sub);       
          while($stdata_sub=mysqli_fetch_row($sectype_result_sub)){
          $ll=$ll+1;
          $str_L=":(";
          $str_R=")";
          echo "<input name=spectype_sub_c[] class=spectype_sub_sc".$stdata[0]." type='checkbox' value=".$stdata_sub[0]." onclick='ccheck_subtype(".$stdata[0].",".$data[0].");'";
          if(preg_match("/".$stdata_sub[0]."/i",$CPM4)!='') { echo "checked"; }
          echo " />";
          ?>
          <font color="red"><?=$stdata_sub[2];?></font>
          <?php
          }
          echo $str_R;          
          ?>
        <?php
        if($kk%5==0){ echo "<br />"; }
        }
        ?>        
        </td>        
        </div>
        </tr>        
        </table>
        </div>        
	  </div>
      <?php
      }
      ?>      
	  </div>
</td>
</tr>
<tr><td colspan="2"><input type="submit" value="Done" />&nbsp;&nbsp;</td></tr>
</table>
</form>
<script language="JavaScript">
function CFinal_Check(){
if(document.form3.CPM1.value == "" ) {
alert("請選擇 ProductTypeName！");
document.form3.CPM1.focus();
return false;
}
return true;
}
</script>
</div>
<!--Add, Edit, Copy Product Type-->
</div>
<p class="clear">&nbsp;</p>
<div id="footer">	Copyright &copy; 2012 Company Co. All rights reserved.<div class="gotop" onClick="location='#top'">Top</div></div>
</body>
</html>
<?php
if(isset($_REQUEST['pr_id'])<>"" && isset($_REQUEST['types'])!=''){
  if(trim($_REQUEST['types'])=='edit'){
  echo "<script language='Javascript'>show_edit();</script>\n";
  }
}else if(isset($_REQUEST['pr_cid'])<>"" && isset($_REQUEST['types'])!=''){
  if(trim($_REQUEST['types'])=='copy'){
  echo "<script language='Javascript'>show_copy();</script>\n";
  }
}
exit();
?>