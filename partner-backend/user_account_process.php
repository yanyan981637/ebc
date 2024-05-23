<?php
header("X-Frame-Options: DENY");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://www.mitacmct.com/");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

if(strpos(trim(getenv('REQUEST_URI')),'?')!='' || strpos(trim(getenv('REQUEST_URI')),'?')===0 || strpos(trim(getenv('REQUEST_URI')),"'")!='' || strpos(trim(getenv('REQUEST_URI')),"'")===0 || strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
  echo "<script language='javascript'>self.location='/404.htm'</script>";
  exit;
}

error_reporting(0);

session_start();
if($_SESSION['user']=="" || $_SESSION['ID']==""){
  echo "<script language='javascript'>self.location='login'</script>";
  exit;
}

require "../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');

function dowith_sql($str)
{
  $str = str_replace("and","",$str);
  $str = str_replace("execute","",$str);
  $str = str_replace("update","",$str);
  $str = str_replace("count","",$str);
  $str = str_replace("chr","",$str);
  $str = str_replace("mid","",$str);
  $str = str_replace("master","",$str);
  $str = str_replace("truncate","",$str);
  //$str = str_replace("char","",$str);
  $str = str_replace("declare","",$str);
  $str = str_replace("select","",$str);
  $str = str_replace("create","",$str);
  $str = str_replace("delete","",$str);
  $str = str_replace("insert","",$str);
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

function arrayToString($arr) {
  if (is_array($arr)){
    return implode(',', array_map('arrayToString', $arr));
  }
  return $arr;
}

if($_POST['kind']!=""){
  $kind=dowith_sql($_POST['kind']);
  $kind=filter_var($kind);
}else{
  $kind="";
}
putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

if($kind=="AddTeam"){
  if($_POST['TeamName']!=""){
    $TeamName=trim(dowith_sql($_POST['TeamName']));
    $TeamName=filter_var($TeamName);
  }else{
    $TeamName="";
  }
  $str="SELECT * FROM `partner_teams` WHERE Team='".$TeamName."'";
  $cmd=mysqli_query($link_db,$str);
  $num=mysqli_num_rows($cmd);
  if($num>0){
    echo "repeated";
    mysqli_close($link_db);
    exit();
  }

  $add_team="INSERT INTO `partner_teams` (Team, C_DATE) VALUES ('".$TeamName."', '".$now."')";
  if(mysqli_query($link_db,$add_team)<1)
  {
    echo "error";
    mysqli_close($link_db);
    exit();
  }else{
    echo "success";
    mysqli_close($link_db);
    exit();
  }
}

if($kind=="EditTeam"){
  if($_POST['E_teamID']!=""){
    $E_teamID=trim(dowith_sql($_POST['E_teamID']));
    $E_teamID=filter_var($E_teamID);
  }else{
    $E_teamID="";
  }
  if($_POST['TeamName']!=""){
    $TeamName=trim(dowith_sql($_POST['TeamName']));
    $TeamName=filter_var($TeamName);
  }else{
    $TeamName="";
  }
  $str="SELECT * FROM `partner_teams` WHERE Team='".$TeamName."'";
  $cmd=mysqli_query($link_db,$str);
  $num=mysqli_num_rows($cmd);
  if($num>0){
    echo "repeated";
    mysqli_close($link_db);
    exit();
  }

  $edit_team="UPDATE `partner_teams` SET Team='".$TeamName."', U_DATE='".$now."' WHERE ID='".$E_teamID."'";
  if(mysqli_query($link_db,$edit_team)<1)
  {
    echo "error";
    mysqli_close($link_db);
    exit();
  }else{
    echo "success";
    mysqli_close($link_db);
    exit();
  }
}

if($kind=="DelTeam"){
  if($_POST['delTeamID']!=""){
    $delTeamID=trim(dowith_sql($_POST['delTeamID']));
    $delTeamID=filter_var($delTeamID);
  }else{
    $delTeamID="";
  }


  $delete_team="DELETE FROM `partner_teams` WHERE ID='".$delTeamID."'";
  if(mysqli_query($link_db,$delete_team)<1)
  {
    echo "error";
    mysqli_close($link_db);
    exit();
  }else{
    echo "success";
    mysqli_close($link_db);
    exit();
  }
}

if($kind=="addSales"){
  if($_POST['Add_Name']!=""){
    $Add_Name=trim(dowith_sql($_POST['Add_Name']));
    $Add_Name=filter_var($Add_Name);
  }else{
    $Add_Name="";
  }
  if($_POST['mail_val']!=""){
    $mail_val=trim(dowith_sql($_POST['mail_val']));
    $mail_val=filter_var($mail_val);
  }else{
    $mail_val="";
  }
  if($_POST['Add_Role']!=""){
    $Add_Role=trim(dowith_sql($_POST['Add_Role']));
    $Add_Role=filter_var($Add_Role);
  }else{
    $Add_Role="";
  }
  if($_POST['Add_checkbox']!=""){
    $Add_checkbox=trim(dowith_sql($_POST['Add_checkbox']));
    $Add_checkbox=filter_var($Add_checkbox);
  }else{
    $Add_checkbox="";
  }
  if($_POST['Add_Team']!=""){
    $Add_Team=trim(dowith_sql($_POST['Add_Team']));
    $Add_Team=filter_var($Add_Team);
  }else{
    $Add_Team="";
  }

  $str="SELECT * FROM `partner_sales` WHERE EMAIL='".$mail_val."'";
  $cmd=mysqli_query($link_db,$str);
  $num=mysqli_num_rows($cmd);
  if($num>0){
    echo "repeated";
    mysqli_close($link_db);
    exit();
  }

  $add_sales="INSERT INTO `partner_sales` (NAME, EMAIL, Role, checkbox, Team, C_DATE, PassWord, First) VALUES ('".$Add_Name."', '".$mail_val."', '".$Add_Role."', '".$Add_checkbox."', '".$Add_Team."', '".$now."', '!123456#', '1')";
  if(mysqli_query($link_db,$add_sales)<1)
  {
    echo "error";
    mysqli_close($link_db);
    exit();
  }else{
    echo "success";
    mysqli_close($link_db);
    exit();
  }
}

if($kind=="editSales"){
  if($_POST['editSalesID']!=""){
    $editSalesID=trim(dowith_sql($_POST['editSalesID']));
    $editSalesID=filter_var($editSalesID);
  }else{
    $editSalesID="";
  }
  if($_POST['edit_Name']!=""){
    $edit_Name=trim(dowith_sql($_POST['edit_Name']));
    $edit_Name=filter_var($edit_Name);
  }else{
    $edit_Name="";
  }
  if($_POST['mail_val']!=""){
    $mail_val=trim(dowith_sql($_POST['mail_val']));
    $mail_val=filter_var($mail_val);
  }else{
    $mail_val="";
  }
  if($_POST['edit_Role']!=""){
    $edit_Role=trim(dowith_sql($_POST['edit_Role']));
    $edit_Role=filter_var($edit_Role);
  }else{
    $edit_Role="";
  }
  if($_POST['edit_checkbox']!=""){
    $edit_checkbox=trim(dowith_sql($_POST['edit_checkbox']));
    $edit_checkbox=filter_var($edit_checkbox);
  }else{
    $edit_checkbox="";
  }
  if($_POST['edit_Team']!=""){
    $edit_Team=trim(dowith_sql($_POST['edit_Team']));
    $edit_Team=filter_var($edit_Team);
  }else{
    $edit_Team="";
  }

  $edit_sales="UPDATE `partner_sales` SET NAME='".$edit_Name."', EMAIL='".$mail_val."', Role='".$edit_Role."', checkbox='".$edit_checkbox."', Team='".$edit_Team."', U_DATE='".$now."' WHERE ID='".$editSalesID."'";

  if(mysqli_query($link_db,$edit_sales)<1)
  {
    echo "error";
    mysqli_close($link_db);
    exit();
  }else{
    echo "success";
    mysqli_close($link_db);
    exit();
  }
}

if($kind=="delSales"){
  if($_POST['delSalesID']!=""){
    $delSalesID=trim(dowith_sql($_POST['delSalesID']));
    $delSalesID=filter_var($delSalesID);
  }else{
    $delSalesID="";
  }
  
  $del_sales="DELETE FROM `partner_sales` WHERE ID='".$delSalesID."'";
  if(mysqli_query($link_db,$del_sales)<1)
  {
    echo "error";
    mysqli_close($link_db);
    exit();
  }else{
    echo "success";
    mysqli_close($link_db);
    exit();
  }
}

if($kind=="editToValue"){
  if($_POST['EditTeameID']!=""){
    $EditTeameID=trim(dowith_sql($_POST['EditTeameID']));
    $EditTeameID=filter_var($EditTeameID);
  }else{
    $EditTeameID="";
  }
  
  $str="SELECT ID, Team FROM `partner_teams` WHERE ID='".$EditTeameID."'";
  $cmd=mysqli_query($link_db,$str);
  $data=mysqli_fetch_row($cmd);
  echo $data[1];
  mysqli_close($link_db);
  exit();
}

if($kind=="editToDel"){
  if($_POST['delID']!=""){
    $delID=trim(dowith_sql($_POST['delID']));
    $delID=filter_var($delID);
  }else{
    $delID="";
  }
  
  $str="SELECT NAME FROM `partner_sales` WHERE ID='".$delID."'";
  $cmd=mysqli_query($link_db,$str);
  $data=mysqli_fetch_row($cmd);
  echo $data[0];
  mysqli_close($link_db);
  exit();
}

if($kind=="editToSales"){
  if($_POST['EditSalesID']!=""){
    $EditSalesID=trim(dowith_sql($_POST['EditSalesID']));
    $EditSalesID=filter_var($EditSalesID);
  }else{
    $EditSalesID="";
  }
  $content="";
  $sel_team_text="";
  $SUAD="";
  $AD="";
  $SA="";
  $checkbox="";
  
  $str="SELECT NAME, EMAIL, Role, checkbox, Team FROM `partner_sales` WHERE ID='".$EditSalesID."'";
  $cmd=mysqli_query($link_db,$str);
  $data=mysqli_fetch_row($cmd);
  if($data[2]=="SUAD"){
    $SUAD="selected";
  }elseif ($data[2]=="AD") {
    $AD="selected";
  }elseif ($data[2]=="SA") {
    $SA="selected";
  }
  if($data[3]=="1"){
    $checkbox="checked";
  }
  $TeamID=$data[4];

  $str_team="SELECT ID, Team FROM `partner_teams` WHERE 1";
  $cmd_team=mysqli_query($link_db,$str_team);
  while ($data_team=mysqli_fetch_row($cmd_team)) {
    if($TeamID==$data_team[0]){
      $status="selected";
    }else{
      $status="";
    }
    $sel_team_text.="<option  value='".$data_team[0]."' ".$status.">".$data_team[1]."</option>";
  }

  $content.="
  <div class='form-group'>
    <label>Name: </label>
    <input id='edit_Name' type='text' placeholder='' class='form-control' value='".$data[0]."' required>
  </div>
  <div class='form-group'>
    <label>Email: </label>
    <input id='edit_Email' type='email' placeholder='' class='form-control' value='".$data[1]."' required>
  </div>
  <div class='form-group'>
    <label>Role: </label>
    <select id='edit_Role' class='form-control'>
      <option  value='SUAD' ".$SUAD.">Super Admin</option>
      <option  value='AD' ".$AD.">Admin</option>
      <option  value='SA' ".$SA.">Sales</option>   
    </select>
  </div>
  <div class='form-group'>
    <div class='form-check'>
      <input id='edit_checkbox' type='checkbox' class='form-check-input' ".$checkbox.">
      <label class='form-check-label' for='exampleCheck1'>Enable Quotation Approval</label>
    </div>
  </div>

  <div class='form-group'>
    <label>Team: </label>
    <select id='edit_Team' class='form-control' >
    ".$sel_team_text."
    </select>
  </div>
  ";
  echo $content;
  mysqli_close($link_db);
  exit();
}

?>