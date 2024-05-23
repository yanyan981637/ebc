<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

error_reporting(0);
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

if(isset($_REQUEST['d_id'])!=""){
  $d1=intval($_REQUEST['d_id']);
  $str_d="delete FROM specoptions where SPECOptionID=".$d1;
  $cmd_d=mysqli_query($link_db,$str_d);
  echo "<script>alert('Del Value !');location.href='spec_settings.php';</script>";
  exit();
}

if(isset($_REQUEST['kinds'])!=''){
  if(trim($_REQUEST['kinds'])=='edit_specvalues'){
    if(isset($_POST['spcg01'])!=''){
      $spcg01=intval($_POST['spcg01']);
    }else{
      $spcg01="";
    }
    if(isset($_POST['sptp01'])!=''){
      $sptp01=intval($_POST['sptp01']);
    }else{
      $sptp01="";
    }
    if(isset($_POST['sppg01'])!=''){
      $sppg01=intval($_POST['sppg01']);
    }else{
      $sppg01="";
    }

    if(isset($_POST['ESM0'])!=''){
      $ESM0=intval($_POST['ESM0']);
    }else{
      $ESM0="";
    }
    if(isset($_POST['ESM1'])!=''){
      $ESM1=trim($_POST['ESM1']);
    }else{
      $ESM1="";
    }
    if(isset($_POST['ESM3'])!=''){
      $ESM3=trim($_POST['ESM3']);
    }else{
      $ESM3="";
    }
    if(isset($_POST['ESM4'])!=''){
      $ESM4=trim($_POST['ESM4']);
    }else{
      $ESM4="";
    }
    if(isset($_POST['specoption_esorts'])!=''){
      $specoption_esorts=trim($_POST['specoption_esorts']);
    }else{
      $specoption_esorts="";
    }

    if(isset($_POST['prod_SKUS_E'])<>''){ 
      foreach($_POST['prod_SKUS_E'] as $Check2){
        $str2=$str2.$Check2.",";
      }
    }else{
      $str2="";
    }

    putenv("TZ=Asia/Taipei");
    $now=date("Y/m/d H:i:s");

/*
//-------------2017/04/17 新增資料比對(Edit)-------------
$str_su="select * from specoptions where SPECTypeID='$ESM1' and SPECOptionValue='$ESM3'";
$str_evalue="update `specoptions` set `SPECTypeID`=$ESM1, `SPECOptionValue`='$ESM3', `SPECOptionURL`='$ESM4', `upd_d`='$now', `upd_u`='1782', `IsShow`='1', `SPECOptionSKus`='$str2', `SPECOptionSort`=$specoption_esorts where `SPECOptionID`=".$ESM0;

$result=mysqli_query($link_db,$str_su);
$row_result=mysqli_fetch_assoc($result);
if(isset($ESM3))
{
//將讀取出來的資料取出欄位名稱為username的資料，並且存在$admin
$admin=$row_result["SPECOptionValue"];
if($ESM3==$admin)
{      
echo "<script>alert('Repeated Value! Please enter another!');self.location='spec_settings.php'</script>";
} else {
$cmd_evalue=mysqli_query($link_db,$str_evalue);
if($spcg01!='' && $sptp01!='' && $sppg01!=''){
   echo "<script>alert('Update Value !');location.href='spec_settings.php?SPECCategoryID=".$spcg01."&SPECTypeID=".$sptp01."&page=".$sppg01."'</script>";
 }else if($spcg01!='' && $sptp01=='' && $sppg01!=''){
   echo "<script>alert('Update Value !');location.href='spec_settings.php?SPECCategoryID=".$spcg01."&page=".$sppg01."'</script>";
 }else if($spcg01=='' && $sptp01=='' && $sppg01!=''){
   echo "<script>alert('Update Value !');location.href='spec_settings.php?page=".$sppg01."'</script>";
 }else{
   echo "<script>alert('Update Value !');location.href='spec_settings.php'</script>";
 }
exit();
}
}
*/ 

$str_evalue="update `specoptions` set `SPECTypeID`=$ESM1, `SPECOptionValue`='$ESM3', `SPECOptionURL`='$ESM4', `upd_d`='$now', `upd_u`='1782', `IsShow`='1', `SPECOptionSKus`='$str2', `SPECOptionSort`=$specoption_esorts where `SPECOptionID`=".$ESM0;
$cmd_evalue=mysqli_query($link_db,$str_evalue);
if($spcg01!='' && $sptp01!='' && $sppg01!=''){
  echo "<script>alert('Update Value !');location.href='spec_settings.php?SPECCategoryID=".$spcg01."&SPECTypeID=".$sptp01."&page=".$sppg01."'</script>";
}else if($spcg01!='' && $sptp01=='' && $sppg01!=''){
  echo "<script>alert('Update Value !');location.href='spec_settings.php?SPECCategoryID=".$spcg01."&page=".$sppg01."'</script>";
}else if($spcg01=='' && $sptp01=='' && $sppg01!=''){
  echo "<script>alert('Update Value !');location.href='spec_settings.php?page=".$sppg01."'</script>";
}else{
  echo "<script>alert('Update Value !');location.href='spec_settings.php'</script>";
}
exit();
}

if(trim($_REQUEST['kinds'])=='add_specvalues'){

  $str_s="select SPECOptionID FROM specoptions order by SPECOptionID desc limit 1";
  $check_s=mysqli_query($link_db,$str_s);
  $Max_SPCOptionID=mysqli_fetch_row($check_s);
  $MCount=$Max_SPCOptionID[0]+1;

  if(isset($_POST['SM1'])!=''){
    $SM1=trim($_POST['SM1']);
  }else{
    $SM1="";
  }
  if(isset($_POST['SM3'])!=''){
    $SM3=htmlspecialchars($_POST['SM3'], ENT_QUOTES);
  }else{
    $SM3="";
  }
  if(isset($_POST['SM4'])!=''){
    $SM4=trim($_POST['SM4']);
  }else{
    $SM4="";
  }
  if(isset($_POST['specoption_sorts'])!=''){
    if(trim(($_POST['specoption_sorts']))!=''){
      $specoption_sorts=trim($_POST['specoption_sorts']);
    }else{
      $specoption_sorts=0;
    }
  }else{
    $specoption_sorts=0;
  }

  putenv("TZ=Asia/Taipei");
  $now=date("Y/m/d H:i:s");

  if(isset($_POST['SEL_PSPEC'])!=''){

  }

  if(isset($_POST['SEL_PSPEC_sub'])<>''){
    if(trim($_POST['SEL_PSPEC_sub'])!=''){
      $SEL_PSPEC_sub=trim($_POST['SEL_PSPEC_sub']);
    }else{
      $SEL_PSPEC_sub=trim($_POST['SM1']);
    }
  }else{
    if(isset($_POST['SM1'])!=''){
      $SEL_PSPEC_sub=trim($_POST['SM1']);
    }else{
      $SEL_PSPEC_sub="";
    }
  }

  if(isset($_POST['prod_SKUS'])<>''){
    foreach($_POST['prod_SKUS'] as $Check1){
      $str1=$str1.$Check1.",";
    }
  }else{
    $str1="";
  }

  $str_value="INSERT INTO `specoptions`(`SPECOptionID`, `SPECTypeID`, `SPECOptionValue`, `SPECOptionURL`, `crea_d`, `crea_u`, `IsShow`, `SPECOptionSKus`, `SPECOptionSort`) values ($MCount,$SEL_PSPEC_sub,'$SM3','$SM4','$now','1782','1','$str1',$specoption_sorts)";
//-------------2017/04/17 新增資料比對(Add)-------------
/*  $str_ss="select * from specoptions where SPECTypeID='$SEL_PSPEC_sub' and SPECOptionValue='$SM3'";
$result=mysqli_query($link_db,$str_ss);
$row_result=mysqli_fetch_assoc($result);
if(isset($SM3))
{
//將讀取出來的資料取出欄位名稱為username的資料，並且存在$admin
$admin=$row_result["SPECOptionValue"];
if($SM3==$admin)
{
  echo "<script>alert('Repeated Value! Please enter another!');self.location='spec_settings.php'</script>";
} else {
$cmd_value=mysqli_query($link_db,$str_value);
echo "<script>alert('Add Value !');location.href='spec_settings.php'</script>";
exit();
}
}*/

//-------------2017/04/17 註解-------------
$cmd_value=mysqli_query($link_db,$str_value);
echo "<script>alert('Add Value !');location.href='spec_settings.php'</script>";
exit();
//-----------------------------------------
}
}

if(isset($_REQUEST['SPECCategoryID'])!=''){
  $SPECCategoryID=intval($_REQUEST['SPECCategoryID']);
}else{
  $SPECCategoryID="";
}

if(isset($_REQUEST['SPECTypeID'])!=''){
  $SPECTypeID=intval($_REQUEST['SPECTypeID']);
}else{
  $SPECTypeID="";
}

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);

if(isset($_REQUEST['act'])=="search"){

  if(isset($_POST['SEL_spccateg'])!=''){
    $sc=trim($_POST['SEL_spccateg']);
    $sc01=str_replace("?SPECCategoryID=", '', $sc);
  }else{
    $sc01="";
  }

  if(isset($_POST['SEL_spctyp'])!=''){
    $sy=trim($_POST['SEL_spctyp']);
    $sy01=str_replace($sc, '', $sy);
    $sy01=str_replace("&SPECTypeID=", '', $sy01);
  }else{
    $sy01="";
  }

  if(isset($_POST['SEL_spctyp_sub'])!=''){
    $ss=trim($_POST['SEL_spctyp_sub']);
  }else{
    $ss="";
  }

  if($sc01!="" && $sy01!=""){
    $str1="select count(*) from specoptions a inner join spectypes b on a.SPECTypeID=b.SPECTypeID inner join speccategroies c on b.SPECCategoryID=c.SPECCategoryID where c.SPECCategoryID=".$sc01." and b.SPECTypeID=".$sy01;
  }else if($sc01!="" && $sy01==""){
    $str1="select count(*) from specoptions a inner join spectypes b on a.SPECTypeID=b.SPECTypeID inner join speccategroies c on b.SPECCategoryID=c.SPECCategoryID where c.SPECCategoryID=".$sc01;
  }else{
    $str1="select count(*) from specoptions a inner join spectypes b on a.SPECTypeID=b.SPECTypeID inner join speccategroies c on b.SPECCategoryID=c.SPECCategoryID";
  }

}else if(isset($_REQUEST['SPECCategoryID'])!='' && isset($_REQUEST['SPECTypeID'])!=''){
  $str1="select count(*) from specoptions a inner join spectypes b on a.SPECTypeID=b.SPECTypeID inner join speccategroies c on b.SPECCategoryID=c.SPECCategoryID where c.SPECCategoryID=".intval($_REQUEST['SPECCategoryID'])." and b.SPECTypeID=".intval($_REQUEST['SPECTypeID']);
}else if(isset($_REQUEST['SPECCategoryID'])!='' && isset($_REQUEST['SPECTypeID'])==''){
  $str1="select count(*) from specoptions a inner join spectypes b on a.SPECTypeID=b.SPECTypeID inner join speccategroies c on b.SPECCategoryID=c.SPECCategoryID where c.SPECCategoryID=".intval($_REQUEST['SPECCategoryID']);
}else{
  $str1="select count(*) from specoptions a inner join spectypes b on a.SPECTypeID=b.SPECTypeID inner join speccategroies c on b.SPECCategoryID=c.SPECCategoryID";
}

$list1 =mysqli_query($link_db,$str1);
list($public_count) = mysqli_fetch_row($list1);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>SPEC Creation Tool - SPEC Settings</title>
  <link rel="stylesheet" type="text/css" href="../backend.css">
  <link rel="stylesheet" type="text/css" href="../css/css.css" />

  <link type="text/css" href="../lib/css/ui-lightness/jquery-ui-1.8.22.custom.css" rel="stylesheet" />
  <script type="text/javascript" src="../lib/jquery-1.7.2.min.js"></script>
  <script type="text/javascript" src="../lib/jquery-ui-1.8.22.custom.min.js"></script>
  <script type="text/javascript" src="../fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
  <script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
  <link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />

  <style type="text/css">
  /*---------20170925新增SKUs限制字數--------*/
  p{
    width:200px;
    white-space:nowrap;
    text-overflow:ellipsis;
    -o-text-overflow:ellipsis;
    overflow:hidden;
  }
  </style>

  <script type="text/javascript">
//***********20170925 新增fancybox***************
$(document).ready(function() {
/*
*  Simple image gallery. Uses default settings
*/

$('.fancybox').fancybox({
  'width':800,
  'height':400,
  'autoSize' : false,
  'type' : 'iframe'
});

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
  closeEffect : 'none',

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
    buttons : {}
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

//***********************************************
</script> 

<script language="JavaScript">
function check_SKU(tval){
  var i=0;
  for(i=0;i<document.form2.elements.length;i++){
   
    if((document.form2.elements[i].type == "checkbox") && (document.form2.elements[i].name == "AProductType[]") && (document.form2.elements[i].value==tval))
    { 
 var Fname = '.prod_SKUS_s'+tval;//prod_SKUS[] Class
 var lenA = $(Fname+":checked").length;
 if(lenA>0){
   document.form2.elements[i].checked=true;
 }else{
   document.form2.elements[i].checked=false;
 }
 document.getElementById('checkCount'+tval).innerHTML = "<font color=red><b>" + lenA + "</b></font> Item Checked";
 
}
}
}

function emopen(val){
  $('#eaccordion'+val).click(function() {

    if($('#eaccordion_sub'+val).is(":hidden")){
      $('#EProductType[]').is(':checked');
      $('#eaccordion'+val).hide();
      $('#eaccordion_c'+val).show(); 
      $('#eaccordion_sub'+val).show(); 
    }   
    return false;  
  });
}

function emclose(val){
  $('#eaccordion_c'+val).click(function() {  

    if($('#eaccordion_sub'+val).is(":visible")){
      $('#eaccordion_c'+val).hide();
      $('#eaccordion'+val).show(); 
      $('#eaccordion_sub'+val).hide(); 
    }  

    return false;  
  });
}


function mopen(val){
  $('#accordion'+val).click(function() {

    if($('#accordion_sub'+val).is(":hidden")){
      $('#AProductType[]').is(':checked');
      $('#accordion'+val).hide();
      $('#accordion_c'+val).show(); 
      $('#accordion_sub'+val).show(); 
    }   
    return false;  
  });
}

function mclose(val){
  $('#accordion_c'+val).click(function() {  

    if($('#accordion_sub'+val).is(":visible")){
      $('#accordion_c'+val).hide();
      $('#accordion'+val).show(); 
      $('#accordion_sub'+val).hide(); 
    }  

    return false;  
  });
}

function hiden_add(){
  self.location="spec_settings.php";
}

function hiden_edit(){
  self.location="spec_settings.php";
}

function show_add(){
$("#values_add").show();//顯示
$("#values_edit").hide();
}

function show_edit(){
  $("#values_add").hide();
$("#values_edit").show();//顯示
}

function MM_ae(selObj){
  window.open(document.getElementById('SEL_spccateg_e').options[document.getElementById('SEL_spccateg_e').selectedIndex].value,"_self");
}

function MM_a(selObj){
  window.open(document.getElementById('SEL_spccateg_a').options[document.getElementById('SEL_spccateg_a').selectedIndex].value,"_self");
}

function MM_ps(selObj){
  window.open(document.getElementById('SEL_PSPEC').options[document.getElementById('SEL_PSPEC').selectedIndex].value,"_self");
}

function MM_o(selObj){
  window.open(document.getElementById('SEL_spccateg').options[document.getElementById('SEL_spccateg').selectedIndex].value,"_self");
}
function MM_t(selObj){
  window.open(document.getElementById('SEL_spctyp').options[document.getElementById('SEL_spctyp').selectedIndex].value,"_self");
} 

</script>

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

function Del_id(t_id){    
  if(confirm("確定要刪除此筆資料嗎？")) {
    self.location="?d_id="+t_id;
  }else{
  }
}


</script>
</head>
<body><a name="top"></a>
  <div>
    <div class="left"><h1>&nbsp;&nbsp;Website Backends - SPEC Creation Tool</h1></div>
    <div id="logout">Hi <b><?=str_replace('@mic.com.tw','',$_SESSION['user']);?></b> <a href="./logo.php">Log out &gt;&gt;</a></div>
  </div>
  <div class="clear"></div>
  <?php
  include("./menu.php");
  ?>

  <div class="clear"></div>
  <div id="Search" >
    <div>
      <form id="form_s" name="form_s" method="post" action="spec_settings.php?act=search">
        <select id="SEL_spccateg" name="SEL_spccateg" onChange="MM_o(this)">
          <option value="" selected="selected">Select Category..</option>
          <?php
          $str_spccat="select SPECCategoryID, SPECCategoryName FROM speccategroies order by SPECCategoryName";
          $spccat_result=mysqli_query($link_db,$str_spccat);
          while($data_c=mysqli_fetch_row($spccat_result)){
            ?>
            <option value="?SPECCategoryID=<?=$data_c[0];?>" <?php if($SPECCategoryID==$data_c[0]) echo "selected"; ?>><?=$data_c[1];?></option>
            <?php
          }
          ?>
        </select>
        &nbsp;&nbsp;
        <select id="SEL_spctyp" name="SEL_spctyp" onChange="MM_t(this)">
          <option value="" selected="selected">Select Type...</option>
          <?php
          $str_spctyp="select SPECTypeID, SPECCategoryID, SPECTypeName FROM spectypes WHERE ParentSpec is NULL and SPECCategoryID=".$SPECCategoryID;
          echo $str_spctyp;
          $spctyp_result=mysqli_query($link_db,$str_spctyp);
          while($data_t=mysqli_fetch_row($spctyp_result)){
            ?>
            <option value="?SPECCategoryID=<?=$SPECCategoryID?>&SPECTypeID=<?=$data_t[0]?>" <?php if($SPECTypeID==$data_t[0]) echo "selected"; ?>><?=$data_t[2]?></option>
            <?php
          }
          ?>
        </select>
        &nbsp;&nbsp; 
        <select id="SEL_spctyp_sub" name="SEL_spctyp_sub">
          <option selected value="">All Values</option>
          <?php
          $str_spctyp_sub="select SPECTypeID,SPECTypeName from spectypes where ParentSpec <> '' and InputTypeID <3 and ParentSpec=".$SPECTypeID;
          $pspec_sub_result=mysqli_query($link_db,$str_spctyp_sub);
          while(list($SPECTypeID,$SPECTypeName)=mysqli_fetch_row($pspec_sub_result)){
            ?>
            <option value="<?=$SPECTypeID;?>"><?=$SPECTypeName;?></option>
            <?php
          }
          ?>
        </select>
        &nbsp;&nbsp;<input name="B1" type="submit" value="Search" />
      </form>
    </div>
  </div>
  <p class="clear"></p>
  <div id="content">
    <h3 class="left">SPEC Settings - Options</h3>
    <!--datatable start here-->
    <p class="clear"></p>
    <div>
      <div class="pagination left">Total: <span class="w14bblue"><?=$public_count;?></span> records </div>
    </div>
    <p class="clear"></p>

    <?php
    if(isset($_REQUEST['PSPEC'])<>''){

      $PSPEC_Value_str=trim($_REQUEST['PSPEC']);   
      $PSG01="SPECCategoryName";
      $PST01="SPECTypeName";
      $PPR01="ParentSpec";
      $PSO01="SPECOptionValue";
      $PSU01="SPECOptionURL";
      $PD01="upd_d";
      $PU01="upd_u";

      if($PSPEC_Value_str=="SPECCategoryName"){
        $PSPEC_Value=$PSPEC_Value_str;
        $PSG01="SPECCategoryName_A";
        $P_value="Desc";
      }else if($PSPEC_Value_str=="SPECCategoryName_A"){
        $PSPEC_Value="SPECCategoryName";
        $PSG01="SPECCategoryName";
        $P_value="Asc";
      }

      if($PSPEC_Value_str=="SPECTypeName"){
        $PSPEC_Value=$PSPEC_Value_str;
        $PST01="SPECTypeName_A";
        $P_value="Desc";
      }else if($PSPEC_Value_str=="SPECTypeName_A"){
        $PSPEC_Value="SPECTypeName";
        $PST01="SPECTypeName";
        $P_value="Asc";
      }

      if($PSPEC_Value_str=="ParentSpec"){
        $PSPEC_Value=$PSPEC_Value_str;
        $PPR01="ParentSpec_A";
        $P_value="Desc";
      }else if($PSPEC_Value_str=="ParentSpec_A"){
        $PSPEC_Value="ParentSpec";
        $PPR01="ParentSpec";
        $P_value="Asc";
      }

      if($PSPEC_Value_str=="SPECOptionValue"){
        $PSPEC_Value=$PSPEC_Value_str;
        $PSO01="SPECOptionValue_A";
        $P_value="Desc";
      }else if($PSPEC_Value_str=="SPECOptionValue_A"){
        $PSPEC_Value="SPECOptionValue";
        $PSO01="SPECOptionValue";
        $P_value="Asc";
      }

      if($PSPEC_Value_str=="SPECOptionURL"){
        $PSPEC_Value=$PSPEC_Value_str;
        $PSU01="SPECOptionURL_A";
        $P_value="Desc";
      }else if($PSPEC_Value_str=="SPECOptionURL_A"){
        $PSPEC_Value="SPECOptionURL";
        $PSU01="SPECOptionURL";
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

      $PSG01="SPECCategoryName";
      $PST01="SPECTypeName";
      $PPR01="ParentSpec";
      $PSO01="SPECOptionValue";
      $PSU01="SPECOptionURL";
      $PD01="upd_d";
      $PU01="upd_u";

      $P_value="Desc";
    }
    ?>

    <table class="list_table">
      <tr>
        <th width="150"><a href="?PSPEC=<?=$PSG01;?>" STYLE="text-decoration:none">*Category</a></th>
        <th width="150"><a href="?PSPEC=<?=$PST01;?>" STYLE="text-decoration:none">*Type</a></th>
        <th width="100"><a href="?PSPEC=<?=$PPR01;?>" STYLE="text-decoration:none">*Top Type</a></th>
        <th width="200"><a href="?PSPEC=<?=$PSO01;?>" STYLE="text-decoration:none">*Value</a></th>
        <th><a href="?PSPEC=<?=$PSU01;?>" STYLE="text-decoration:none">*URL</a></th>
        <th width="160"><a href="?PSPEC=<?=$PD01;?>" STYLE="text-decoration:none">*Update Date</a></th>
        <th width="100"><a href="?PSPEC=<?=$PU01;?>" STYLE="text-decoration:none">*Updated by</a></th>
        <th width="25"><a href="?PSPEC=" STYLE="text-decoration:none">SKUs</a></th>
        <th onClick="#" width="120"><div class="button14" style="width:100px;"><a href="#values_add" STYLE="text-decoration:none" onClick="show_add();">Add New</a></div></th> 		
      </tr>
      <?php
      if(isset($_REQUEST['page'])==""){
        $page="1";
      }else{
        $page=intval($_REQUEST['page']);
      }

      if(empty($page))$page="1";      
      $read_num="25";
      $start_num=$read_num*($page-1);    

      if(isset($_REQUEST['act'])=="search"){
        if(isset($_POST['SEL_spccateg'])!=''){
          $sc=trim($_POST['SEL_spccateg']);
          $sc01=str_replace("?SPECCategoryID=", '', $sc);
        }else{
          $sc01="";
        }

        if(isset($_POST['SEL_spctyp'])!=''){
          $sy=trim($_POST['SEL_spctyp']);
          $sy01=str_replace($sc, '', $sy);
          $sy01=str_replace("&SPECTypeID=", '', $sy01);
        }else{
          $sy01="";
        }

        if(isset($_POST['SEL_spctyp_sub'])!=''){
          $ss=trim($_POST['SEL_spctyp_sub']);
        }else{
          $ss="";
        }
        
        if($sc01!="" && $sy01!="" && $ss!=""){
          $str="select a.SPECOptionID,c.SPECCategoryName,b.SPECTypeName,b.ParentSpec,a.SPECOptionValue,a.SPECOptionURL,a.upd_d,a.upd_u,a.SPECOptionSKus, a.SPECTypeID from specoptions a inner join spectypes b on a.SPECTypeID=b.SPECTypeID inner join speccategroies c on b.SPECCategoryID=c.SPECCategoryID where c.SPECCategoryID=".$sc01." and b.ParentSpec=".$sy01." and b.SPECTypeID=".$ss." order by ".$PSPEC_Value." ".$P_value." limit $start_num,$read_num;";
        }else if($sc01!="" && $sy01!="" && $ss==""){
          $str="select a.SPECOptionID,c.SPECCategoryName,b.SPECTypeName,b.ParentSpec,a.SPECOptionValue,a.SPECOptionURL,a.upd_d,a.upd_u,a.SPECOptionSKus, a.SPECTypeID from specoptions a inner join spectypes b on a.SPECTypeID=b.SPECTypeID inner join speccategroies c on b.SPECCategoryID=c.SPECCategoryID where c.SPECCategoryID=".$sc01." and b.SPECTypeID=".$sy01." order by ".$PSPEC_Value." ".$P_value." limit $start_num,$read_num;";
        }else if($sc01!="" && $sy01==""){
          $str="select a.SPECOptionID,c.SPECCategoryName,b.SPECTypeName,b.ParentSpec,a.SPECOptionValue,a.SPECOptionURL,a.upd_d,a.upd_u,a.SPECOptionSKus, a.SPECTypeID from specoptions a inner join spectypes b on a.SPECTypeID=b.SPECTypeID inner join speccategroies c on b.SPECCategoryID=c.SPECCategoryID where c.SPECCategoryID=".$sc01." order by ".$PSPEC_Value." ".$P_value." limit $start_num,$read_num;";
        }else{
          $str="select a.SPECOptionID,c.SPECCategoryName,b.SPECTypeName,b.ParentSpec,a.SPECOptionValue,a.SPECOptionURL,a.upd_d,a.upd_u,a.SPECOptionSKus, a.SPECTypeID from specoptions a inner join spectypes b on a.SPECTypeID=b.SPECTypeID inner join speccategroies c on b.SPECCategoryID=c.SPECCategoryID order by ".$PSPEC_Value." ".$P_value." limit $start_num,$read_num;";
        }

      }else if(isset($_REQUEST['SPECCategoryID'])!='' && isset($_REQUEST['SPECTypeID'])!=''){
        $stID=intval($_REQUEST['SPECTypeID']);
        if($stID=='1024' || $stID=='1030' || $stID=='1031' || $stID=='1441' || $stID=='1455'){
          $str="select a.SPECOptionID,c.SPECCategoryName,b.SPECTypeName,b.ParentSpec,a.SPECOptionValue,a.SPECOptionURL,a.upd_d,a.upd_u,a.SPECOptionSKus, a.SPECTypeID from specoptions a inner join spectypes b on a.SPECTypeID=b.SPECTypeID inner join speccategroies c on b.SPECCategoryID=c.SPECCategoryID where c.SPECCategoryID=".intval($_REQUEST['SPECCategoryID'])." and b.ParentSpec=".intval($_REQUEST['SPECTypeID'])." order by ".$PSPEC_Value." ".$P_value." limit $start_num,$read_num;";
        }else{
          $str="select a.SPECOptionID,c.SPECCategoryName,b.SPECTypeName,b.ParentSpec,a.SPECOptionValue,a.SPECOptionURL,a.upd_d,a.upd_u,a.SPECOptionSKus, a.SPECTypeID from specoptions a inner join spectypes b on a.SPECTypeID=b.SPECTypeID inner join speccategroies c on b.SPECCategoryID=c.SPECCategoryID where c.SPECCategoryID=".intval($_REQUEST['SPECCategoryID'])." and b.SPECTypeID=".intval($_REQUEST['SPECTypeID'])." order by ".$PSPEC_Value." ".$P_value." limit $start_num,$read_num;";
        }
      }else if(isset($_REQUEST['SPECCategoryID'])!='' && isset($_REQUEST['SPECTypeID'])==''){
        $str="select a.SPECOptionID,c.SPECCategoryName,b.SPECTypeName,b.ParentSpec,a.SPECOptionValue,a.SPECOptionURL,a.upd_d,a.upd_u,a.SPECOptionSKus, a.SPECTypeID from specoptions a inner join spectypes b on a.SPECTypeID=b.SPECTypeID inner join speccategroies c on b.SPECCategoryID=c.SPECCategoryID where c.SPECCategoryID=".intval($_REQUEST['SPECCategoryID'])." order by ".$PSPEC_Value." ".$P_value." limit $start_num,$read_num;";
      }else{
        $str="select a.SPECOptionID,c.SPECCategoryName,b.SPECTypeName,b.ParentSpec,a.SPECOptionValue,a.SPECOptionURL,a.upd_d,a.upd_u,a.SPECOptionSKus, a.SPECTypeID from specoptions a inner join spectypes b on a.SPECTypeID=b.SPECTypeID inner join speccategroies c on b.SPECCategoryID=c.SPECCategoryID order by ".$PSPEC_Value." ".$P_value." limit $start_num,$read_num;";
      }
      $result=mysqli_query($link_db, $str);
      $i=0;
      while(list($SPECOptionID,$SPECCategoryName,$SPECTypeName,$ParentSpec,$SPECOptionValue,$SPECOptionURL,$upd_d,$upd_u,$SPECOptionSKus, $SPECTypeID)=mysqli_fetch_row($result))
      {
        $i=$i+1;
        putenv("TZ=Asia/Taipei");
        ?>
        <tr>
          <td><?=$SPECCategoryName;?></td>
          <td><?=$SPECTypeName;?></td>
          <td>
            <?php
            if($ParentSpec!=''){
              $str_type_p="select SPECTypeName from `spectypes` where SPECTypeID=".$ParentSpec;
              $type_presult=mysqli_query($link_db,$str_type_p);
              $data_p=mysqli_fetch_row($type_presult);
              echo $data_p[0];
              $TType=$data_p[0];
            }
            ?>
          </td> 
          <td><?=$SPECOptionValue;?></td> 
          <td><a href="#" target="spec"><?=$SPECOptionURL;?></a></td>
          <td><?=$upd_d;?></td>
          <td><?=$upd_u;?></td>
          <!--***************20170921 新增顯示SKUs**************-->
          <td  height = '50' >
            <div>
              <a class="fancybox fancybox.iframe" href="elb_spec_settings.php?Category=<?=$SPECCategoryName?>&Type=<?=$SPECTypeName?>&TType=<?=$TType?>&Value=<?=$SPECOptionID?>">
                <p>
                  <?php
    /*if($SPECOptionSKus!=''){    
        $SPCP_SKU=explode(",",$SPECOptionSKus,-1);
        echo count($SPCP_SKU);    
    }else{
        echo "0";
      }*/
      //2017.11.15 找value套用那些Product_SKU_Auto_ID
      $str_skuID="SELECT DISTINCT `Product_SKU_Auto_ID` FROM `specvalues` WHERE `SPECValue` like '%".$SPECOptionID."%'";
      $skuID_result=mysqli_query($link_db,$str_skuID);
      $i=0;
      while ($skuID_data=mysqli_fetch_row($skuID_result)) {
        $skuID[$i] = $skuID_data[0];
        $i++;
      }

      for ($j=0; $j < $i ; $j++) { 
        //2011.11.15 找ProductSKU
        $Product_ID = $skuID[$j];
        $str_productID="SELECT * FROM `contents_product_skus` WHERE `Product_SContents_Auto_ID` = '".$Product_ID."' and slang = 'EN,' ";
        $productID_result=mysqli_query($link_db,$str_productID);
        $productID_data=mysqli_fetch_row($productID_result);
        $arraysku[$j] = $productID_data[3];
      }
      
      $skus_count;
      for ($k=0; $k < $j ; $k++) { 
        $SKUsname = $arraysku[$k];
        $skus_count.= $SKUsname."&nbsp;&nbsp;&nbsp;";
      }
      /*$str_skus = "SELECT SKU FROM `contents_product_skus` WHERE `Product_Info` LIKE '%".$SPECTypeID."%'";
      $result_skus=mysqli_query($link_db,$str_skus, $link_db);
      while ($skus_data=mysqli_fetch_row($result_skus)) {
        $skus_count .= $skus_data[0].", ";
      }*/
      echo $skus_count;
      $skus_count = "";
      ?>
    </p>
  </a>
</div>
</td>
<!--***************20170921 新增顯示SKUs end**************-->
<td>
  <?php
  if(isset($_REQUEST['SPECTypeID'])!=''){
    $SPECTypeID=trim($_REQUEST['SPECTypeID']);
  }else{
    $SPECTypeID="";
  }
  ?>
  <a href="?spo_id=<?=$SPECOptionID;?>&SPECCategoryID=<?=$SPECCategoryID;?>&SPECTypeID=<?=$SPECTypeID;?>&page=<?=$page;?>#values_edit">Edit</a> &nbsp;
  <?php

  $str_spchk="SELECT DISTINCT `SPECValue` FROM `specvalues` WHERE `SPECValue` <> '' and INSTR('".$SPECOptionID."',`SPECValue`)>0";
  $cmd_spchk=mysqli_query($link_db,$str_spchk);
  $record_spchk=mysqli_fetch_row($cmd_spchk);  
  if(empty($record_spchk)):
    $spec_used='';
  else:          
    $spec_used='disabled';
  endif;    
  echo "<input type='button' name='D_This' value='Del' ".$spec_used." onClick='Del_id(".$SPECOptionID.");'>";
  ?>
</td>
</tr>
<?php
}
?>
<tr>
  <td colspan="9">
    <?php
    $all_page=ceil($public_count/$read_num);
    $pageSize=$page;
    $total=$all_page;
    pageft($total,$pageSize,1,0,0,15);       
    ?>
  </td>
</tr>
</table>
<div class="sabrosus"><?php echo $pagenav;?></div>
<p>&nbsp;</p><p>&nbsp;</p><p class="clear"></p>
<!--end of datatable -->
<!--Click Edit-->
<?php
if(isset($_REQUEST['spo_id'])<>""){

  $pr_values=intval($_REQUEST['spo_id']);
  $methods="edit_values";

  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
  mysqli_query($link_db,'SET NAMES utf8');
  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
  //$select=mysqli_select_db($dataBase, $link_db);  
  $str_value_m="select * from specoptions where SPECOptionID=".$pr_values;
  $cmd_value_m=mysqli_query($link_db,$str_value_m);
  $record_value_m=mysqli_fetch_row($cmd_value_m);

  if(empty($record_value_m)):
    else:
      $VM0=$record_value_m[0];
    $VM1=$record_value_m[1];
    $VM2=$record_value_m[2];
    $VM3=$record_value_m[3];
    $VM9=$record_value_m[9];
    $VM10=$record_value_m[10];
    endif;

  }else{
    $methods="add_values";
  }

  if(isset($_REQUEST['Speccat_id'])!=''){
    $Speccat_id=intval($_REQUEST['Speccat_id']);
  }else{
    $Speccat_id="";
  }
  if(isset($_REQUEST['Spectyp_id'])!=''){
    $Spectyp_id=intval($_REQUEST['Spectyp_id']);
  }else{
    $Spectyp_id="";
  }
  ?>


  <div id="values_edit" class="subsettings" style="display:none">
    <form id="form1" name="form1" method="post" action="?kinds=edit_specvalues" onsubmit="return EFinal_Check();">
      <input name="spcg01" type="hidden" value="<?=$_REQUEST['SPECCategoryID'];?>" />
      <input name="sptp01" type="hidden" value="<?=$_REQUEST['SPECTypeID'];?>" />
      <input name="sppg01" type="hidden" value="<?=$_REQUEST['page'];?>" />
      <div class="right"><a href="#" onclick="hiden_edit()"> [close] </a></div>

      <table class="addspec">
        <tr><td colspan="2"></td></tr>
        <tr>
          <th>Category Name:</th>
          <td>
            <select id="SEL_spccateg_e" name="SEL_spccateg_e" onChange="MM_ae(this)">
              <option value="">Select...</option>
              <?php
              $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
              mysqli_query($link_db,'SET NAMES utf8');
              mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
              mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
              //$select=mysqli_select_db($dataBase, $link_db);
              $str1="select SPECCategoryID from spectypes where SPECTypeID=".$VM1;
              $str1_result=mysqli_query($link_db,$str1);
              if($str1_result==true){
                $data_w=mysqli_fetch_row($str1_result);
              }
              mysqli_close($link_db);

              $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
              mysqli_query($link_db,'SET NAMES utf8');
              mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
              mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
              //$select=mysqli_select_db($dataBase, $link_db);
              $str_SPECC="select SPECCategoryID,SPECCategoryName,producttypeList from speccategroies";
              $SPECC_result=mysqli_query($link_db,$str_SPECC);
              while(list($SPECCategoryID,$SPECCategoryName,$producttypeList)=mysqli_fetch_row($SPECC_result))
              {
                ?>
                <option value="?Speccat_id=<?=$SPECCategoryID;?> #values_edit" <?php if($Speccat_id==$SPECCategoryID || $SPECCategoryID==$data_w[0]){ echo "selected"; }?>><?=$SPECCategoryName?></option>
                <?php
              }
              mysqli_close($link_db);
              ?>
            </select>
            <input name="ESM0" type="hidden" value="<?=$pr_values;?>"  />
          </td>
        </tr>
        <tr>
          <th>Type:</th>
          <td>
            <select id="SEL_PSPEC_E" name="SEL_PSPE_E" onChange="MM_ps(this)">
              <option selected="selected" value="">Select from extisting: </option>
              <?php   
              $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
              mysqli_query($link_db,'SET NAMES utf8');
              mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
              mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
              //$select=mysqli_select_db($dataBase, $link_db);
              if(isset($_REQUEST['Speccat_id'])<>''){
                $speccat_id=intval($_REQUEST['Speccat_id']);
                $spectyp_id=intval($_REQUEST['Spectyp_id']);
                $str_pspec="select SPECTypeID,SPECTypeName from spectypes where ParentSpec is NULL and SPECCategoryID=".$speccat_id;
              }else if($data_w[0]<>''){
                $speccat_id=$data_w[0];
                $spectyp_id="";
                $str_pspec="select SPECTypeID,SPECTypeName from spectypes where ParentSpec is NULL and SPECCategoryID=".$speccat_id;
              }
              $pspec_result=mysqli_query($link_db,$str_pspec);
              while(list($SPECTypeID,$SPECTypeName)=mysqli_fetch_row($pspec_result)){

                $str_ChkPar="SELECT `SPECTypeID`, `SPECCategoryID`, `ParentSpec` FROM `spectypes` WHERE `ParentSpec` IS NOT NULL and `SPECTypeID`=".$VM1;
                $ChkPar_cmd=mysqli_query($link_db,$str_ChkPar);
                $ChkPar_data=mysqli_fetch_row($ChkPar_cmd);
                if($ChkPar_data[2]!=''){
                  $PSPECTypeID=$ChkPar_data[2];
                }else{
                  $PSPECTypeID="";
                }
                ?>
                <option value="?Speccat_id=<?=$_REQUEST['Speccat_id'];?>&Spectyp_id=<?=$SPECTypeID;?> #values_edit" <?php if($spectyp_id==$SPECTypeID || $VM1==$SPECTypeID || $PSPECTypeID==$SPECTypeID){ echo "selected"; }?>><?=$SPECTypeName;?></option>
                <?php
              }
              mysqli_close($link_db);
              ?>
            </select>
            <input name="ESM1" type="hidden" value="<?=$VM1;?>" />    
            <select id="SEL_PSPEC_sub_e" name="SEL_PSPEC_sub_e">
              <option selected="selected" value="">Select from extisting: </option>
              <?php   
              $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
              mysqli_query($link_db,'SET NAMES utf8');
              mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
              mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
              //$select=mysqli_select_db($dataBase, $link_db);
              if($PSPECTypeID!=''){
                $str_pspec="select SPECTypeID,SPECTypeName from spectypes where ParentSpec <> '' and InputTypeID <3 and ParentSpec=".$PSPECTypeID;
              }else{
                $str_pspec="select SPECTypeID,SPECTypeName from spectypes where ParentSpec <> '' and InputTypeID <3 and ParentSpec=".$VM1;
              }
              $pspec_result=mysqli_query($link_db,$str_pspec);
              while(list($SPECTypeID,$SPECTypeName)=mysqli_fetch_row($pspec_result)){
                ?>
                <option value="<?=$SPECTypeID;?>" <?php if($VM1==$SPECTypeID){ echo "selected"; } ?>><?=$SPECTypeName;?></option>
                <?php
              }
              mysqli_close($link_db);
              ?>
            </select>    
          </td>
        </tr>
        <tr>
          <th>Value:</th>
          <td> <input name="ESM3" type="text" size="30" value="<?=htmlspecialchars($VM2, ENT_QUOTES);?>"> <input id="specoption_esorts" name="specoption_esorts" style="display:''" type="text" size="2" value="<?=$VM10;?>" /></td>
        </tr>
        <tr>
          <th>URL:</th>
          <td> <input name="ESM4" type="text" size="30" value="<?=$VM3;?>"  /> </td>
        </tr>
        <!--新增前端頁面在 mouse rollover 時, 顯示的文字說明-->
        <tr>
          <th>Tooltips:</th>
          <td> <input name="ESM5" type="text" size="40" value=""  /> </td>
        </tr>
        <tr>
          <th><!--SKUs:--></th>
          <td>
            <div style="display:none">
              <?php
              $i=0;
              $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
              mysqli_query($link_db,'SET NAMES utf8');
              mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
              mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
              //$select=mysqli_select_db($dataBase, $link_db);
              $str="select ProductTypeID,ProductTypeName from producttypes";
              $types_result=mysqli_query($link_db,$str);
              $i=0;
              while($data=mysqli_fetch_row($types_result)){
                $i=$i+1;
                ?>
                <div id="eaccordion<?=$i;?>" style="cursor:pointer" onClick="emopen(<?=$i;?>);"><img src="../images/icon_add.gif" border="0"> <?=$data[1];?></div>
                <div id="eaccordion_c<?=$i;?>" onClick="emclose(<?=$i;?>);" style="display:none; cursor:pointer;"><img src="../images/icon_hide.gif" border="0"> <?=$data[1];?></div><span id="checkCount<?=$data[0];?>"></span>
                <div id="eaccordion_sub<?=$i;?>" style="display:none; width:1000px;">
                  <div>
                    <table>
                      <tr>
                        <input name="EProductType[]" type="checkbox" value="<?=$data[0];?>" style="display:none" />
                        <div id="PSKU_s<?=$data[0];?>">        
                          <td>
                            <?php
                            $g=0;
                            $str_i="select Product_SKU_Auto_ID,ProductTypeID,SKU from product_skus where ProductTypeID=".$data[0];
                            $pskus_result=mysqli_query($link_db,$str_i);
                            $g=0;
                            while($data_i=mysqli_fetch_row($pskus_result)){
                              $g=$g+1;
                              ?>
                              <input name="prod_SKUS_E[]" class="prod_SKUS_s<?=$data[0];?>" type="checkbox" value="<?=$data_i[0];?>" onClick="check_SKU(<?=$data[0];?>);" <?php if(strpos($VM9,$data_i[0])!='' || strpos($VM9,$data_i[0])===0){ echo "checked"; }  //if(eregi($data_i[0],$VM9)!='') echo "checked"; ?> /> <?php if(preg_match("/".$data_i[0]."/i",$VM9)!='') { echo "<font color=red>".$data_i[2]."</font>"; } else { echo $data_i[2]; } ?>
                              <?php
                              if($g%6==0){ echo "<br />"; }
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
  </div>

  <div id="values_add" class="subsettings" style="display:none">
    <form id="form2" name="form2" method="post" action="?kinds=add_specvalues" onsubmit="return AFinal_Check();">
      <!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hiden_add()"> [close] </a></div><!--end of close-->
      <table class="addspec">
        <tr><td colspan="2"></td></tr>
        <tr>
          <th>Category Name:</th>
          <td>
            <select id="SEL_spccateg_a" name="SEL_spccateg_a" onChange="MM_a(this)">
              <option value="">Select...</option>
              <?php
              $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
              mysqli_query($link_db,'SET NAMES utf8');
              mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
              mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
              //$select=mysqli_select_db($dataBase, $link_db);
              $str_SPECC="select * from speccategroies order by SPECCategoryName";
              $SPECC_result=mysqli_query($link_db,$str_SPECC);
              while(list($SPECCategoryID,$SPECCategoryName,$producttypeList)=mysqli_fetch_row($SPECC_result))
              {
                ?>
                <option value="?Speccat_id=<?=$SPECCategoryID;?> #values_add" <?php if($Speccat_id==$SPECCategoryID){ echo "selected"; }?>><?=$SPECCategoryName?></option>
                <?php
              }
              mysqli_close($link_db);
              ?>
            </select>
            <input name="SM0" type="hidden" value="<?=intval($_REQUEST['Speccat_id']);?>"  />
          </td>
        </tr>
        <tr>
          <th>Type:</th>
          <td>
            <select id="SEL_PSPEC" name="SEL_PSPEC" onChange="MM_ps(this)">
              <option selected="selected" value="">Select from extisting: </option>
              <?php
              $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
              mysqli_query($link_db,'SET NAMES utf8');
              mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
              mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
              //$select=mysqli_select_db($dataBase, $link_db);
              $str_pspec="select SPECTypeID,SPECTypeName from spectypes where ParentSpec is NULL and SPECCategoryID=".$Speccat_id;

              $pspec_result=mysqli_query($link_db,$str_pspec);
              while(list($SPECTypeID,$SPECTypeName)=mysqli_fetch_row($pspec_result)){
                ?>
                <option value="?Speccat_id=<?=$Speccat_id;?>&Spectyp_id=<?=$SPECTypeID;?> #values_add" <?php if($spectyp_id==$SPECTypeID){ echo "selected"; }?>><?=$SPECTypeName;?></option>
                <?php
              }
              mysqli_close($link_db);
              ?>
            </select>
            <input name="SM1" type="hidden" value="<?=$Spectyp_id;?>" />    
            <select id="SEL_PSPEC_sub" name="SEL_PSPEC_sub">
              <option selected="selected" value="">Select from extisting: </option>
              <?php   
              $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
              mysqli_query($link_db,'SET NAMES utf8');
              mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
              mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
              //$select=mysqli_select_db($dataBase, $link_db);
              $str_pspec="select SPECTypeID,SPECTypeName from spectypes where ParentSpec <> '' and InputTypeID <3 and ParentSpec=".$spectyp_id;
              $pspec_result=mysqli_query($link_db,$str_pspec);
              while(list($SPECTypeID,$SPECTypeName)=mysqli_fetch_row($pspec_result)){
                ?>
                <option value="<?=$SPECTypeID;?>"><?=$SPECTypeName;?></option>
                <?php
              }
              mysqli_close($link_db);
              ?>
            </select>    
          </td>
        </tr>
        <tr>
          <th>Value:</th>
          <td> <input name="SM3" type="text" size="20" value="" /> <input id="specoption_sorts" name="specoption_sorts" style="display:''" type="text" size="2" value="" /></td>
        </tr>
        <tr>
          <th>URL:</th>
          <td> <input name="SM4" type="text" size="30" value="" /> </td>
        </tr>
        <!--新增前端頁面在 mouse rollover 時, 顯示的文字說明-->
        <tr>
          <th>Tooltips:</th>
          <td> <input name="SM5" type="text" size="40" value="" /> </td>
        </tr>
        <tr>
          <th><!--SKUs:--></th>
          <td>

            <div style="display:none">
              <?php
              $i=0;
              $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
              mysqli_query($link_db,'SET NAMES utf8');
              mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
              mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
              //$select=mysqli_select_db($dataBase, $link_db);
              $str="select ProductTypeID,ProductTypeName from producttypes";
              $types_result=mysqli_query($link_db,$str);
              $i=0;
              while($data=mysqli_fetch_row($types_result)){
                $i=$i+1;
                ?>
                <div id="accordion<?=$i;?>" style="cursor:pointer" onClick="mopen(<?=$i;?>);"><img src="../images/icon_add.gif" border="0"> <?=$data[1];?></div>
                <div id="accordion_c<?=$i;?>" onClick="mclose(<?=$i;?>);" style="display:none; cursor:pointer;"><img src="../images/icon_hide.gif" border="0"> <?=$data[1];?></div><span id="checkCount<?=$data[0];?>"></span>
                <div id="accordion_sub<?=$i;?>" style="display:none; width:1000px;">
                  <div>        
                    <table>
                      <tr>
                        <input name="AProductType[]" type="checkbox" value="<?=$data[0];?>" style="display:none" />
                        <div id="PSKU_s<?=$data[0];?>">        
                          <td>
                            <?php
                            $g=0;
                            $str_i="select Product_SKU_Auto_ID,ProductTypeID,SKU from product_skus where ProductTypeID=".$data[0];
                            $pskus_result=mysqli_query($link_db,$str_i);
                            $g=0;
                            while($data_i=mysqli_fetch_row($pskus_result)){
                              $g=$g+1;
                              ?>
                              <input name="prod_SKUS[]" class="prod_SKUS_s<?=$data[0];?>" type="checkbox" value="<?=$data_i[0];?>" onClick="check_SKU(<?=$data[0];?>);" /> <?=$data_i[2];?>
                              <?php
                              if($g%6==0){ echo "<br />"; }
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
    function AFinal_Check( ) {
      if ( document.form2.SM0.value == "" ) {
        alert ("請選擇 Category Name！");
        document.form2.SM0.focus();
        return false;
      }

      if ( document.form2.SM1.value == "" ) {
        alert ("請選擇 Type Name！");
        document.form2.SM1.focus();
        return false;
      }

      if ( document.form2.SEL_PSPEC.value == "" ) {
        alert ("請選擇 Top Type！");
        document.form2.SEL_PSPEC.focus();
        return false;
      }

      if ( document.form2.SM3.value == "" ) {
        alert ("請輸入 Value！");
        document.form2.SM3.focus();
        return false;
      }


      return true;
    }
    </script>
  </div>
  <!--end of edit -->
</div>
<p class="clear">&nbsp;</p>
<div id="footer">	Copyright &copy; 2012 Company Co. All rights reserved.<div class="gotop" onClick="location='#top'">Top</div></div>
</body>
</html>
<?php
if(isset($_REQUEST['Speccat_id'])<>""){
  echo "<script language='Javascript'>show_add();</script>\n";
}else if(isset($_REQUEST['spo_id'])<>""){
  echo "<script language='Javascript'>show_edit();</script>\n";
}
exit();
?>