<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
require "../../config.php";

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
  $str = str_replace("'","",$str);
  $str = str_replace('"',"",$str);
  $str = str_replace(".","",$str);
//$str = str_replace("or","",$str);  //2017.5.24暫時註解, 因舊資料sku會擋(Transport FX27)
  $str = str_replace("=","",$str);
  $str = str_replace("?","",$str);
  $str = str_replace("%","",$str);
  $str = str_replace("0x02BC","",$str);
  $str = str_replace("<script>","",$str);
  $str = str_replace("</script>","",$str);
  return $str;
}

if(isset($_GET['type'])!==''){
$Type=dowith_sql(filter_var($_GET['type']));
}else{
$Type="";
}
if(isset($_GET['mid'])!==''){
$mid=dowith_sql(filter_var($_GET['mid']));
}else{
$mid="";
}

$platform = "SELECT count(*) FROM pcn_platform WHERE 1";
$cmd = $pdo->prepare($platform);
$cmd->execute();
$platform_num=$cmd->fetch(PDO::FETCH_NUM);

$KC = "SELECT count(*) FROM pcn_key_characteristics WHERE 1";
$cmd = $pdo->prepare($KC);
$cmd->execute();
$KC_num=$cmd->fetch(PDO::FETCH_NUM);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Edit / Add PCN Platform</title>
  <link rel=stylesheet type="text/css" href="../../backend.css">
  <script type="text/javascript" src="../../jquery.min.js"></script>
  <style type="text/css">
  </style>
</head>

<body style="backbround:#f9f9f9">


  <h2>Edit / Add PCN Platform:</h2><p class="clear"></p>
  <p>Total: <span class="w14bblue"><?=$platform_num[0];?></span> records </p>
</div>
<p class="clear"></p>
<table class="list_table">
  <tr>
    <th>Platform</th><th><div class="button14" style="width:50px;" onClick="show_AddPP()">Add</div></th>
  </tr>
  <!--add a PCN Platform-->
  <tr id="addPP" name="addPP" style="display:none">
    <td >
      <input id="add_PP" name="add_PP" type="text" size="20" value=""  />
    </td>
    <td style="width:150px">
      <input name="" type="button" value="Done" Onclick="Add_done('AddPlatform')" />
      <input name="" type="button" value="Cancel" onclick="location.replace('lb_PCN.php');"/>
    </td>
  </tr>
  <!--end add a PCN Platform-->
  <?php
  if($Type=="Platform"){
    $str = "SELECT ID, Platform FROM pcn_platform WHERE ID= :ID";
    $cmd = $pdo->prepare($str);
    $cmd->bindValue(':ID', $mid);
    $cmd->execute();
    $data=$cmd->fetch(PDO::FETCH_NUM);
  ?>
  <tr id="editPlatform">
    <td ><input id="edit_Platform" name="edit_Platform" type="text" size="20" value="<?=$data[1]?>"  /></td>
    <td style="width:150px">
      <input id="MVaBtn" name="" type="button" value="Done" onClick="Edit_done('EditPlatform','<?=$data[0];?>')" />
      <input name="" type="button" value="Cancel" onclick="location.replace('lb_PCN.php');"/>
    </td>
  </tr>
  <?php 
  }

  $str = "SELECT ID, Platform FROM pcn_platform WHERE 1";
  $cmd = $pdo->prepare($str);
  $cmd->execute();
  while ($data=$cmd->fetch(PDO::FETCH_NUM)) {
  ?>
  <tr>
    <td><?=$data[1];?></td><td><a href="#" onclick="show_ModVal('<?=$data[0];?>','Platform');">Edit</a>&nbsp;&nbsp;<a href="#">Del</a></td>
  </tr>
  <?php
  }
  ?>
  

</table>



<p class="clear">&nbsp;</p>
<p class="clear">&nbsp;</p>



<h2>Edit / Add PCN Key Characteristics:</h2><p class="clear"></p>
<p>Total: <span class="w14bblue"><?=$KC_num[0];?></span> records </p>
</div>
<p class="clear"></p>
<table class="list_table">
  <tr>
    <th>OS</th><th><div class="button14" style="width:50px;" onClick="show_AddKC()">Add</div></th>
  </tr>
  <!--add PCN Key Characteristics-->
  <tr id="addKC" name="addKC" style="display:none">
    <td >
      <input id="add_KC" name="add_KC" type="text" size="20" value=""  />
    </td>
    <td style="width:150px">
      <input name="" type="button" value="Done" Onclick="Add_done('AddKC')" />
      <input name="" type="button" value="Cancel" onclick="location.replace('lb_PCN.php');"/>
    </td>
  </tr>
  <!--end PCN Key Characteristics-->
  
  <?php
  if($Type=="PKC"){
    $str = "SELECT ID, Characteristics FROM pcn_key_characteristics WHERE ID= :ID";
    $cmd = $pdo->prepare($str);
    $cmd->bindValue(':ID', $mid);
    $cmd->execute();
    $data=$cmd->fetch(PDO::FETCH_NUM);
  ?>
  <tr id="editKC">
    <td ><input id="edit_KC" name="edit_KC" type="text" size="20" value="<?=$data[1]?>"  /></td>
    <td style="width:150px">
      <input id="MVaBtn" name="" type="button" value="Done" onClick="Edit_done('EditKC','<?=$data[0];?>')" />
      <input name="" type="button" value="Cancel" onclick="location.replace('lb_PCN.php');"/>
    </td>
  </tr>
  <?php 
  }

  $str1 = "SELECT ID, Characteristics FROM pcn_key_characteristics WHERE 1";
  $cmd1 = $pdo->prepare($str1);
  $cmd1->execute();
  while ($data1=$cmd1->fetch(PDO::FETCH_NUM)) {
  ?>
  <tr>
    <td><?=$data1[1];?></td><td><a href="#" onclick="show_ModVal('<?=$data1[0];?>','PKC');">Edit</a>&nbsp;&nbsp;<a href="#">Del</a></td>
  </tr>
  <?php
  }
  ?>

</table>



<p class="clear">&nbsp;</p>
<p class="clear">&nbsp;</p>




<p class="clear">&nbsp;</p>
<p class="clear">&nbsp;</p>
<p style="color:#0F0">- List 順序：由新至舊</p>
<p class="clear">&nbsp;</p>
<p class="clear">&nbsp;</p>
</body>

<script language="javascript">
function Add_done(i){
  var kind = i;
  var add_PP = "";
  var add_KC = "";
  if(kind=="AddPlatform"){
    add_PP = $("#add_PP").val();
  }else if(kind=="AddKC"){
    add_KC = $("#add_KC").val();
  }

  var url = "PCN_process.php";
  $.ajax({
    type: "post",
    url: url,
    dataType: "html",
    data: {
      kind:kind, 
      add_PP:add_PP,
      add_KC:add_KC
    },
    success: function(message){
      if(message == "refresh"){  
        self.location='lb_PCN.php'
      }else{
        alert(message);
      }
    }
  });
}

function Edit_done(i, j){
  var kind = i;
  var MID = j;
  var edit_Platform;
  var edit_KC;
  if(kind=="EditPlatform"){
    edit_Platform = $("#edit_Platform").val();
  }else if(kind=="EditKC"){
    edit_KC = $("#edit_KC").val();
  }

  var url = "PCN_process.php";
  $.ajax({
    type: "post",
    url: url,
    dataType: "html",
    data: {
      kind:kind, 
      MID:MID,
      edit_Platform:edit_Platform,
      edit_KC:edit_KC
    },
    success: function(message){
      if(message == "refresh"){  
        self.location='lb_PCN.php'
      }else{
        alert(message);
      }
    }
  });
}

function show_AddPP(){
  $("#addPP").show();
  $("#editPP").hide();
}

function show_AddKC(){
  $("#addKC").show();
  $("#editKC").hide();
}

function show_ModVal(id,type){
  self.location='lb_PCN.php?mid='+id+'&type='+type;
}
</script>
</html>
