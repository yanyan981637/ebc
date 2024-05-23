<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

require "../config.php";
include_once('../page.class.php');

@session_start();
if(empty($_SESSION['user']) || empty($_SESSION['password']) || empty($_SESSION['login_time'])){
echo "<script language='JavaScript'>location='../login.php'</script>";
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

if($Type=="delete"){
  if($_GET['did']!=''){
    $did01=intval($_GET['did']);
    $str_del="delete from dsg_sa_source where ID=".$did01;
    $del_cmd=mysqli_query($link_db,$str_del);
    echo "<script>alert('Delete the Data!');self.location='lb_doc_type.php'</script>";
    exit();
  }  
}

if($Type=="add_sa"){
  if(isset($_POST['mm_model'])!=''){
    $mm_modellist=",";
    $tmp="";
    foreach($_POST['mm_model'] as $mm_model01){

      $str2="SELECT ID, Name, URL FROM dsg_sa_source WHERE ID='".$mm_model01."'";
      $cmd2=mysqli_query($link_db, $str2);
      $data2=mysqli_fetch_row($cmd2);
      $tmp.="Name: ".$data2[1]."&nbsp;&nbsp;&nbsp;URL: ".$data2[2]."</br>";



      $mm_modellist=$mm_modellist.$mm_model01.",";
    }
  }else{
   $mm_modellist="";
  }

  $tt=$mm_modellist;
  echo "<script language='Javascript'>parent.document.forms['form1'].add_SAsourceID.value='".$tt."';parent.document.getElementById('add_SAsource').innerHTML='".$tmp."';";
  /*echo "<script language='Javascript'>";
  echo "try{";
  echo "  if(parent.window.opener != null && !parent.window.opener.closed)";
  echo "  {";
  echo "    parent.window.opener.document.forms['form2'].relProd_valM.value = '".$mm_modellist.$mb_modellist.$nh_modellist.$as_modellist.$mm_skulist.$mb_skulist.$chs_skulist.$nh_skulist.$as_skulist."'";
  echo "  }";
  echo "  ";
  echo "  }catch(e){ alert(e.description);}";*/
  echo "parent.jQuery.fancybox.close()";
  echo "</script>\n";
  exit();
}


$str1="SELECT count(*) FROM dsg_sa_source WHERE 1";
$list1 =mysqli_query($link_db,$str1);
list($public_count)=mysqli_fetch_row($list1);



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Edit Download Type</title>
  <link rel=stylesheet type="text/css" href="../backend.css">
  <script type="text/javascript" src="../jquery.min.js"></script>
</head>
<script language="javascript">
function show_subsourceA(){
  $("#add_sub_source").show();
  $("#edit_sub_source").hide();
}

function Add_subdone(){

  var a_s_name = $("#a_s_name").val();
  var a_s_URL = $("#a_s_URL").val();

  var url = "add_SA_source.php";
  $.ajax({
    type: "post",
    url: url,
    dataType: "html",
    data: {
      a_s_name:a_s_name, 
      a_s_URL:a_s_URL
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

function Edit_done(i){
  var id=i;
  var edit_sourceN = $("#edit_sourceN").val();
  var edit_sourceU = $("#edit_sourceU").val();

  var url = "edit_SA_source.php";
  $.ajax({
    type: "post",
    url: url,
    dataType: "html",
    data: {
      id:id, 
      edit_sourceN:edit_sourceN, 
      edit_sourceU:edit_sourceU
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
  self.location='lb_SA_source.php?mid='+id+'&type=edit';
}

function del(id){
  self.location='lb_SA_source.php?did='+id+'&type=delete';
}

function MM_o(selObj){
 window.open(document.getElementById('sa_source_page').options[document.getElementById('sa_source_page').selectedIndex].value,"_self");
}
</script>
<body style="backbround:#f9f9f9">
  <h2>Edit / Add SA source:</h2><p class="clear"></p>
  <?php
    if(isset($_REQUEST['page'])!=""){
      $page=(int)$_REQUEST['page'];
    }else{
      $page="1";
    }

    if(empty($page))$page="1";

    $read_num="10";
    $start_num=$read_num*($page-1); 
    
    $all_page=ceil($public_count/$read_num);
    $pageSize=$page;
    $total=$all_page;
    pageft($total,$pageSize,1,0,0,15);       
    ?>
    <p>Total: <span class="w14bblue"><?=$public_count?></span> records &nbsp;&nbsp;
</div>
<p class="clear"></p>
<form id="form" name="form" method="post" action="?type=add_sa">
<table class="list_table">
  <tr>
    <th >Name</th><th >URL</th><th><div class="button14" style="width:50px;" onClick="show_subsourceA()">Add</div></th>
  </tr>
  <!--add a CMPT_classification-->
  <tr id="add_sub_source" name="add_sub_source" style="display:none">
    <td><input id="a_s_name" name="a_s_name" type="text" size="20" value=""  /></td>
    <td><input id="a_s_URL" name="a_s_URL" type="text" size="50" value=""  /></td>
    <td><input type="button" value="Done" onclick="Add_subdone()" />&nbsp;&nbsp;&nbsp;<a href="lb_SA_source.php"><input name="" type="button" value="Cancel" /></a></td>
  </tr>

  <?php
  if($Type=="edit"){
    $str_s_edit="SELECT ID, Name, URL FROM dsg_sa_source WHERE ID='".$mid."'";
    $s_cmd_edit=mysqli_query($link_db,$str_s_edit);
    $s_data_edit=mysqli_fetch_row($s_cmd_edit);
  ?>
  <tr id="editCMPT">
    <td ><input id="edit_sourceN" name="edit_sourceN" type="text" size="20" value="<?=$s_data_edit[1]?>"  /></td>
    <td ><input id="edit_sourceU" name="edit_sourceU" type="text" size="20" value="<?=$s_data_edit[2]?>"  /></td>
    <td style="width:150px">
      <input id="MVaBtn" name="" type="button" value="Done" onClick="Edit_done('<?=$s_data_edit[0];?>')" />
      <a href="lb_SA_source.php"><input name="" type="button" value="Cancel" /></a>
    </td>
  </tr>
  <?php 
  }
  ?>
  
  <!--end add a CMPT_classification-->
  <?php
  $str_source="SELECT ID, Name, URL FROM dsg_sa_source WHERE 1 ORDER BY C_DATE DESC";
  $Cmd=mysqli_query($link_db,$str_source);
  while ($data=mysqli_fetch_row($Cmd)) {
  ?>
  <tr>
    
    <td ><input id="mm_model[]" name="mm_model[]" type="checkbox" value="<?=$data[0];?>"/><?=$data[1]?></td>
    <td ><?=$data[2]?></td>
    <td>
    <a href="#" onclick="show_ModVal(<?=$data[0];?>);">Edit</a>&nbsp;&nbsp;
    <a href="#" onClick="del('<?=$data[0];?>');">Del</a>
  </td>
  </tr>
  <?php
  }
  ?>
</table>
<p class="clear">&nbsp;</p><p><input name="B1" type="submit" value="Done" />
</form>


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