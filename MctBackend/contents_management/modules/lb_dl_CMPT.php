<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

require "../../config.php";
include_once('../../page.class.php');

@session_start();
if(empty($_SESSION['user']) || empty($_SESSION['password']) || empty($_SESSION['login_time'])){
echo "<script language='JavaScript'>location='../../login.php'</script>";
exit();
}

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase);


if(isset($_GET['type'])!==''){
$Type=filter_var($_GET['type']);
}else{
$Type="";
}
if(isset($_GET['mid'])!==''){
$mid=filter_var($_GET['mid']);
}else{
$mid="";
}

if(trim($_REQUEST['act'])=='del'){
  if($_REQUEST['d_id']!=''){
    $did01=intval($_REQUEST['d_id']);
  $str_del="delete from c_sp_cmpt where ID=".$did01;
  $del_cmd=mysqli_query($link_db,$str_del);
  
 
  echo "<script>alert('Delete the Data!');self.location='lb_dl_CMPT.php'</script>";
  exit();
  }  
}


$str1="SELECT count(*) FROM c_sp_cmpt WHERE Type='CMPT'";
$list1 =mysqli_query($link_db,$str1);
list($CMPT_count)=mysqli_fetch_row($list1);

$str2="SELECT count(*) FROM c_sp_cmpt WHERE Type='OS'";
$list2 =mysqli_query($link_db,$str2);
list($OS_count)=mysqli_fetch_row($list2);

$str3="SELECT count(*) FROM c_sp_cmpt WHERE Type='OS'";
$list3 =mysqli_query($link_db,$str3);
list($Type_count)=mysqli_fetch_row($list3);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Edit Download Type</title>
  <link rel=stylesheet type="text/css" href="../../backend.css">
  <script type="text/javascript" src="../../jquery.min.js"></script>
</head>
<script language="javascript">
function show_AddCMPT(){
  $("#addCMPT").show();
  $("#editCMPT").hide();
}

function show_AddOS(){
  $("#addOS").show();
  $("#editOS").hide();
}

function show_AddType(){
  $("#addType").show();
  $("#editType").hide();
}

function Add_done(i){
  var kind = i;
  if($("#add_CMPT").val()!=""){
    var add_CMPT = $("#add_CMPT").val();
    var add_Order = $("#add_Order").val();
  }else if($("#add_OS").val()!=""){
    var add_CMPT = $("#add_OS").val();
    var add_Order = "";
  }else if($("#add_Type").val()!=""){
    var add_CMPT = $("#add_Type").val();
    var add_Order = "";
  }
  
  var url = "add_CMPT.php";
  $.ajax({
    type: "post",
    url: url,
    dataType: "html",
    data: {
      kind:kind, 
      add_CMPT:add_CMPT,
      add_Order:add_Order
    },
    success: function(message){
      if(message == "refresh"){  
        window.location.reload(true);
      }else{
        alert(message);
      }
    }
  });
}
 
function show_ModVal(id,type){
  self.location='lb_dl_CMPT.php?mid='+id+'&type='+type;
}

function Edit_done(i, j){
  var kind = i;
  var MID = j;
  
  if(kind=="CMPT"){
    var edit_CMPT = $("#edit_CMPT").val();
    var edit_Order = $("#edit_Order").val();
  }else if(kind=="OS"){
    var edit_CMPT = $("#edit_OS").val();
    var edit_Order = "";
  }else if(kind=="Type"){
    var edit_CMPT = $("#edit_Type").val();
    var edit_Order = "";
  }

  var url = "edit_CMPT.php";
  $.ajax({
    type: "post",
    url: url,
    dataType: "html",
    data: {
      kind:kind, 
      MID:MID,
      edit_CMPT:edit_CMPT,
      edit_Order:edit_Order
    },
    success: function(message){
      if(message == "refresh"){  
        self.location='lb_dl_CMPT.php'
      }else{
        alert(message);
      }
    }
  });
}

</script>
<body style="backbround:#f9f9f9">
<?php
$page="";
if(isset($_REQUEST['page'])!=''){
  $page=intval($_REQUEST['page']);
}else{
  $page="1";
}

if(empty($page))$page="1";

$read_num="10";
$start_num=$read_num*($page-1);
?>

  <h2>Edit / Add CMPT_classification:</h2><p class="clear"></p>
  <p>Total: <span class="w14bblue"><?=$CMPT_count;?></span> records </p>
</div>
<p class="clear"></p>
<table class="list_table">
  <tr>
    <th >Name</th><th><div class="button14" style="width:50px;" onClick="show_AddCMPT()">Add</div></th>
  </tr>
  <!--add a CMPT_classification-->
  <tr id="addCMPT" style="display:none">
    <td ><input id="add_CMPT" name="add_CMPT" type="text" size="20" value=""  /></td>
    <td ><input id="add_Order" name="add_Order" type="text" size="20" value=""  /></td>
    <td style="width:150px"><input id="MVaBtn" name="" type="button" value="Done" onClick="Add_done('CMPT')" /><input name="" type="button" value="Cancel" /></td>
  </tr>

  <?php
  if($Type=="CMPT"){
    $str_CPMT_edit="SELECT ID, Name, Type, CMPT_Order FROM c_sp_cmpt WHERE ID='".$mid."' AND Type='CMPT'";
    $CPMT_cmd_edit=mysqli_query($link_db,$str_CPMT_edit);
    $CPMT_data_edit=mysqli_fetch_row($CPMT_cmd_edit);
  ?>
  <tr id="editCMPT">
    <td ><input id="edit_CMPT" name="edit_CMPT" type="text" size="20" value="<?=$CPMT_data_edit[1]?>"  /></td>
    <td ><input id="edit_Order" name="edit_Order" type="text" size="20" value="<?=$CPMT_data_edit[3]?>"  /></td>
    <td style="width:150px"><input id="MVaBtn" name="" type="button" value="Done" onClick="Edit_done('CMPT','<?=$CPMT_data_edit[0];?>')" /><input name="" type="button" value="Cancel" /></td>
  </tr>
  <?php 
  }
  ?>
  
  <!--end add a CMPT_classification-->
  <?php
  $str_CPMT="SELECT ID, Name, Type FROM c_sp_cmpt WHERE Type='CMPT' limit $start_num,$read_num;";
  $CPMT_cmd=mysqli_query($link_db,$str_CPMT);
  while ($CPMT_data=mysqli_fetch_row($CPMT_cmd)) {
  ?>
  <tr>
    <td ><?=$CPMT_data[1]?></td><td><a href="#" onclick="show_ModVal(<?=$CPMT_data[0];?>,'CMPT');">Edit</a>&nbsp;&nbsp;<a href="#">Del</a></td>
  </tr>
  <?php
  }
  ?>
</table>



<p class="clear">&nbsp;</p>
<p class="clear">&nbsp;</p>



<h2>Edit / Add OS:</h2><p class="clear"></p>
<p>Total: <span class="w14bblue"><?=$OS_count;?></span> records </p>
</div>
<p class="clear"></p>
<table class="list_table">
  <tr>
    <th >OS</th><th><div class="button14" style="width:50px;" onClick="show_AddOS()">Add</div></th>
  </tr>
  <!--add a CMPT_classification-->
  <tr id="addOS" style="display:none">
    <td ><input id="add_OS" name="add_OS" type="text" size="20" value=""  /></td>
    <td style="width:150px"><input id="MVaBtn" name="" type="button" value="Done" onClick="Add_done('OS')" /><input name="" type="button" value="Cancel" /></td>
  </tr>

  <?php
  if($Type=="OS"){
    $str_OS_edit="SELECT ID, Name, Type FROM c_sp_cmpt WHERE ID='".$mid."' AND Type='OS'";
    $OS_cmd_edit=mysqli_query($link_db,$str_OS_edit);
    $OS_data_edit=mysqli_fetch_row($OS_cmd_edit);
  ?>
  <tr id="editOS">
    <td ><input id="edit_OS" name="edit_OS" type="text" size="20" value="<?=$OS_data_edit[1]?>"  /></td>
    <td style="width:150px"><input id="MVaBtn" name="" type="button" value="Done" onClick="Edit_done('OS','<?=$OS_data_edit[0];?>')" /><input name="" type="button" value="Cancel" /></td>
  </tr>
  <?php 
  }
  ?>
  
  <!--end add a CMPT_classification-->
  <?php
  $str_OS="SELECT ID, Name, Type FROM c_sp_cmpt WHERE Type='OS' limit $start_num,$read_num;";
  $OS_cmd=mysqli_query($link_db,$str_OS);
  while ($OS_data=mysqli_fetch_row($OS_cmd)) {
  ?>
  <tr>
    <td ><?=$OS_data[1]?></td><td><a href="#" onclick="show_ModVal(<?=$OS_data[0];?>,'OS');">Edit</a>&nbsp;&nbsp;<a href="#">Del</a></td>
  </tr>
  <?php
  }
  ?>

</table>



<p class="clear">&nbsp;</p>
<p class="clear">&nbsp;</p>



<h2>Edit / Add Type:</h2><p class="clear"></p>
<p>Total: <span class="w14bblue"><?=$Type_count;?></span> records </p>
</div>
<p class="clear"></p>
<table class="list_table">
  <tr>
    <th >Type</th><th><div class="button14" style="width:50px;" onClick="show_AddType()">Add</div></th>
  </tr>
  <!--add a CMPT_classification-->
  <tr id="addType" style="display:none">
    <td ><input id="add_Type" name="add_Type" type="text" size="20" value=""  /></td>
    <td style="width:150px"><input id="MVaBtn" name="" type="button" value="Done" onClick="Add_done('Type')" /><input name="" type="button" value="Cancel" /></td>
  </tr>

  <?php
  if($Type=="Type"){
    $str_Type_edit="SELECT ID, Name, Type FROM c_sp_cmpt WHERE ID='".$mid."' AND Type='Type'";
    $Type_cmd_edit=mysqli_query($link_db,$str_Type_edit);
    $Type_data_edit=mysqli_fetch_row($Type_cmd_edit);
  ?>
  <tr id="editType">
    <td ><input id="edit_Type" name="edit_Type" type="text" size="20" value="<?=$Type_data_edit[1]?>"  /></td>
    <td style="width:150px"><input id="MVaBtn" name="" type="button" value="Done" onClick="Edit_done('Type','<?=$Type_data_edit[0];?>')" /><input name="" type="button" value="Cancel" /></td>
  </tr>
  <?php 
  }
  ?>

  <!--end add a CMPT_classification-->
  <?php
  $str_Type="SELECT ID, Name, Type FROM c_sp_cmpt WHERE Type='Type' limit $start_num,$read_num;";
  $Type_cmd=mysqli_query($link_db,$str_Type);
  while ($Type_data=mysqli_fetch_row($Type_cmd)) {
  ?>
  <tr>
    <td ><?=$Type_data[1]?></td><td><a href="#" onclick="show_ModVal(<?=$Type_data[0];?>,'Type');">Edit</a>&nbsp;&nbsp;<a href="#">Del</a></td>
  </tr>
  <?php
  }
  ?>

</table>


<p class="clear">&nbsp;</p>
<p class="clear">&nbsp;</p>
<p style="color:#0F0">- List 順序：由新至舊</p>
<p class="clear">&nbsp;</p>
<p class="clear">&nbsp;</p>

</body>

</html>
<?php
mysqli_Close($link_db);
?>