<?php
header('Content-Type: text/html; charset=utf-8');
require "../config.php";

error_reporting(0);

if(isset($_REQUEST['ProductTypeID'])!=''){
$SType_id=intval($_REQUEST['ProductTypeID']);
}else{
$SType_id="";
}
if(isset($_REQUEST['SKUs_Mid'])!=''){
$SMid=intval($_REQUEST['SKUs_Mid']);
}else{
$SMid="";
}
if(isset($_REQUEST['SKUs_Sid'])!=''){
$Ssid=intval($_REQUEST['SKUs_Sid']);
}else{
$Ssid="";
}

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase);

$str_type1="select ProductTypeID,ProductTypeName from producttypes where ProductTypeID=".$SType_id;
$type_result=mysqli_query($link_db,$str_type1);
$type_data=mysqli_fetch_row($type_result);

$str_CSKUss="select SKUs_Mid,SKUs_MiName from skus_mainsub where `SKUs_Mid`=".$SMid;
$Mid_result=mysqli_query($link_db,$str_CSKUss);
$Mid_data=mysqli_fetch_row($Mid_result);

//add
/*if(isset($_REQUEST['kinds'])!=''){
  if(trim($_REQUEST['kinds'])=="addnew"){

    if(isset($_POST['SkuMname'])!=''){
      $SkuMname=$_POST['SkuMname'];
    }else{
      $SkuMname="";
    }
    if(isset($_POST['pID'])!=''){
      $pID=$_POST['pID'];
    }else{
      $pID="";
    }
    if(isset($_POST['SMid'])!=''){
      $SMid=$_POST['SMid'];
    }else{
      $SMid="";
    }

    $insert = "INSERT INTO skus_sublist (SKUs_Mid, SKUs_Mname, ProductTypeID) VALUES ('".$SMid."', '".$SkuMname."', '".$pID."')";
    $insert_result=mysqli_query($link_db,$insert);
    echo "<script>alert('Add OK!');location.href='group_sku.php'</script>";
  }
}*/

//edit
/*if(isset($_REQUEST['kinds'])!=''){
  if(trim($_REQUEST['kinds'])=="edit_group_sku"){

    if(isset($_POST['SkuMname'])!=''){
      $SkuMname=$_POST['SkuMname'];
    }else{
      $SkuMname="";
    }
    if(isset($_POST['SkuSid'])!=''){
      $SkuSid=$_POST['SkuSid'];
    }else{
      $SkuSid="";
    }

    $update = "UPDATE skus_sublist SET SKUs_Mname='".$SkuMname."' WHERE SKUs_Sid='".$SkuSid."'";
    $update_result=mysqli_query($link_db,$update);
    echo "<script>alert('Edit OK!');location.href='group_sku.php'</script>";
    exit();
  }
}*/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$ptype?></title>
<link rel="stylesheet" type="text/css" href="../backend.css">
<script type="text/javascript" src="../jquery.min.js"></script>
<script type="text/javascript" src="../fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<style type="text/css">
table{border:1px solid #c0c0c0; width:100%}
thead{background:#00a0e9; color:#fff; font-weight:bolder;padding:5px 15px;}
td{ padding:5px 15px;}
td.two{padding-left:50px}
tr{  cursor: pointer; }
tr:hover{background: #dcf2fd;}
tbody:nth-child(even) {
	background: #f8f8f8;
	}
</style>

<script language="JavaScript">

function show_edit(num){
  var sSID = $("#s_SID"+num).val();
  var skuvlaue = $("#SKUvalue"+num).val();
  var type = $("#Typename").val();
  var Mskuname = $("#MSKUname").val();
  var E_title = type+" : "+Mskuname;
  document.getElementById('SkuSid').value = sSID;
  document.getElementById('SkuMname').value = skuvlaue;
  document.getElementById('test').innerHTML = E_title;
  $('#SKU_edit').show();
} 

/*function show_search(){
  $("#searchSku").show();
} */

function hide_edit(){
  $("#SKU_edit").hide();
}

function hide_search(){
  $("#searchSku01").hide();
}

/*function showaa(){
$("#SKU_select").click(function() {
    var Mname = $("#SKU_select").val();
    var num = $("#num").val();
    alert('editValue'+num);
    document.getElementById('SkuMname').value = Mname;
});
} */

function searchSKU(n){
//$(".searchSKU").click(function() {
    var kind = "search";
    var SID = $("#s_SID"+n).val();
    var MID = $("#s_MID").val();
    var url = "edit_groupsku.php";
    if(kind!=""){
     $.ajax({
      type: "post",
      url: url,
      dataType: "html",
      data: {kind, SID, MID},
      success: function(message){
        document.getElementById('search01').innerHTML = message;
        $("#searchSku01").show();
      }
      }); 
   }
//});
}

function addsku(){
//$("#addSKUs").click(function() {
    var kind = "add";
    var pID = $("#addpID").val();
    var MID = $("#addSMid").val();
    var Mname = $("#addvalue").val();
    var url = "edit_groupsku.php";
    if(kind!=""){
     $.ajax({
      type: "post",
      url: url,
      dataType: "html",
      data: {kind, pID, MID, Mname},
      success: function(message){
        if(message == "susses"){
          alert('Add susses');
          parent.$.fancybox.close();
        }
        else{
          alert(message);
        }
      }
      }); 
   }
//});
}

function editSKUs(){
//$("#editSKU").click(function() {
    var kind = "edit";
    var SID = $("#SkuSid").val();
    var Mname = $("#SkuMname").val();
    var MID = $("#s_MID").val();
    var url = "edit_groupsku.php";
    if(kind!=""){
     $.ajax({
      type: "post",
      url: url,
      dataType: "html",
      data: {kind, SID, Mname, MID},
      success: function(message){
        if(message == "susses"){
          alert('Edit susses');
          parent.$.fancybox.close();
        }
        else{
          alert(message);
        }
        
      }
      }); 
   }
//});
}


</script>

</head>

<body style="backbround:#f9f9f9">
  <div>
    <div>
      <table><thead><tr><td ><?=$type_data[1];?> : <?=$Mid_data[1];?></td></tr></thead></table></div>
      <div>
        <form id="form1" name="form1" method="post" action="" >
          <tr>
            <td>
              <input id="addvalue" type='text' name="addvalue" size="45" value="">&nbsp;&nbsp;
              <input id="addpID" type='hidden' name="pID" value="<?=$type_data[0];?>" >
              <input id="MSKUname" type='hidden' name="MSKUname" value="<?=$Mid_data[1];?>" >
              <input id="addSMid" type='hidden' name="SMid" value="<?=$Mid_data[0];?>" >
              <input id="addSKUs" type="button" value="Add New" onclick="addsku()">
            </td>
          </tr>
        </form>
      </div>

      <div id="SKU_edit" name="SKU_edit" class="subsettings" style="display:none">
        <form id="form2" name="form2" method="post" action="">
          <table>
            <tr><td><p id="test"></p></td></tr>
            <tr>
              <div class="right"><a href="#" onclick="hide_edit();"> [close] </a></div>
              <td>
                <input id="SkuMname" name="SkuMname" type="text" size="45" value="" />
                <input id="SkuSid" name="SkuSid" type="hidden" value="" />
              </td>
            </tr>
<!-- <select id="SKU_select" name="SKU_select" onChange="showaa(this)">
  <option selected="selected">Select from extisting: </option>-->
  <?php
    /*$str_result01=mysqli_query($link_db,$str_s);
    while($str_data01=mysqli_fetch_row($str_result01)){*/
      ?>
      <!--<option value="<?//=$str_data01[3];?>"><?//=$str_data01[3];?></option> -->
      <?php
  //}
      ?>
      <!--</select> -->
      <tr><td><input id="editSKU" type="button" value="Done" onclick="editSKUs()" /></td></tr>
    </table>
  </form>
</div>

<div id="searchSku01" class="subsettings" style="display:none">
  <div class="right"><a href="#" onclick="hide_search();"> [close] </a></div>
  <form id="form3" name="form3" method="post" action="">
    <table id="search01">
    </table>
  </form>
</div>

<table>
  <tbody>
    <?php
    $i=0;
    $str_s="select SKUs_Sid,SKUs_Mid,ProductTypeID,SKUs_Mname,IsShow from skus_sublist where SKUs_Mid=".$Mid_data[0]." and ProductTypeID=".$type_data[0];
    $str_result=mysqli_query($link_db,$str_s);
    while($str_data=mysqli_fetch_row($str_result)){
      $SKUvalue = htmlspecialchars($str_data[3]);
      ?>
      <tr>
        <td> 
          <a id="searchSKU" onclick="searchSKU(<?=$i?>)" href="#"><?=$str_data[3]?></a>&nbsp;&nbsp;
          <input id="Typename" type='hidden' value="<?=$type_data[1];?>">
          <input id="SKUvalue<?=$i?>" type='hidden' value="<?=$SKUvalue;?>">
          <input id="s_SID<?=$i?>" type='hidden' value="<?=$str_data[0];?>">
          <input id="s_MID" type='hidden' value="<?=$str_data[1];?>">

          <a href="#" onclick="show_edit(<?=$i?>)">Edit</a>

        </td>
      </tr>
      <?php
      $i++;
    }

    ?>

  </tbody>
</table>
</div>





</body>
</html>
<?php
mysqli_close($link_db);
?>