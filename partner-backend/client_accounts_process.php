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
include("../EN/PHPMailer-master/PHPMailerAutoload.php"); //匯入PHPMailer類別  

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');

function dowith_sql($str)
{
  /*$str = str_replace("and","",$str);
  $str = str_replace("execute","",$str);
  $str = str_replace("update","",$str);
  $str = str_replace("count","",$str);
  $str = str_replace("chr","",$str);
  $str = str_replace("mid","",$str);
  $str = str_replace("master","",$str);*/
  $str = str_replace("truncate","",$str);
  //$str = str_replace("char","",$str);
  $str = str_replace("declare","",$str);
  //$str = str_replace("select","",$str);
  //$str = str_replace("create","",$str);
  //$str = str_replace("delete","",$str);
  //$str = str_replace("insert","",$str);
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

if($_POST['kind']!=""){
  $kind=dowith_sql($_POST['kind']);
  $kind=filter_var($kind);
}else{
  $kind="";
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");
if($kind=="Add"){
  if($_POST['companyName']!=""){
    $companyName=dowith_sql($_POST['companyName']);
    $companyName=filter_var($companyName);
  }else{
    $companyName="";
  }
  if($_POST['companyAddress']!=""){
    $companyAddress=trim(dowith_sql($_POST['companyAddress']));
    $companyAddress=filter_var($companyAddress);
  }else{
    $companyAddress="";
  }
  if($_POST['username']!=""){
    $username=trim(dowith_sql($_POST['username']));
    $username=filter_var($username);
  }else{
    $username="";
  }
  if($_POST['email']!=""){
    $email=trim(dowith_sql($_POST['email']));
    $email=filter_var($email);
  }else{
    $email="";
  }
  if($_POST['Title']!=""){
    $Title=trim(dowith_sql($_POST['Title']));
    $Title=filter_var($Title);
  }else{
    $Title="";
  }
  if($_POST['countryCode']!=""){
    $countryCode=trim(dowith_sql($_POST['countryCode']));
    $countryCode=filter_var($countryCode);
  }else{
    $countryCode="";
  }
  if($_POST['tel']!=""){
    $tel=trim(dowith_sql($_POST['tel']));
    $tel=filter_var($tel);
  }else{
    $tel="";
  }
  if($_POST['resSales']!=""){
    $resSales=trim(dowith_sql($_POST['resSales']));
    $resSales=filter_var($resSales);
  }else{
    $resSales="";
  }
  if($_POST['Region']!=""){
    $Region=trim(dowith_sql($_POST['Region']));
    $Region=filter_var($Region);
  }else{
    $Region="";
  }
  $str="SELECT ID, CompanyName, Email FROM partner_user WHERE Email='".$email."'";
  $cmd=mysqli_query($link_db,$str);
  $num=mysqli_num_rows($cmd);
  if($num>0){
    echo "email";
    mysqli_close($link_db);
    exit();
  }

  $strCompanyID="SELECT CompanyID FROM partner_user WHERE 1 ORDER BY CompanyID DESC";
  $cmdCompanyID=mysqli_query($link_db,$strCompanyID);
  $resultCompanyID=mysqli_fetch_row($cmdCompanyID);
  if($resultCompanyID[0]==""){
    $CompanyID="CP1000001";
  }else{
    $arr_ID=explode("CP" , $resultCompanyID[0]);
    $CompanyID=$arr_ID[1]+1;
    $CompanyID="CP".$CompanyID;
  }

  //******** rand 產生新密碼 ********
  $random=6; //亂數長度
  for ($i=1;$i<=$random;$i++){
    $c=rand(1,3);
      //chr()將數值轉變為對應英文
    if($c==1){
      $a=rand(97,122);$b=chr($a);
    }
    if($c==2){
      $a=rand(65,90);$b=chr($a);
    }
    if($c==3){
      $b=rand(0,9);
    }
    $password=$password.$b;
  }
    //**********************************

  $str="INSERT INTO partner_user (CompanyID, CompanyName, CompanyAddress, Name, Email, Title, CountryCode, Tel, ResponsibleSales, Password, C_DATE) VALUES ('".$CompanyID."', '".$companyName."', '".$companyAddress."', '".$username."', '".$email."', '".$Title."', '".$Region."', '".$tel."', '".$resSales."', '".$password."', '".$now."')";
  if(mysqli_query($link_db,$str)<1)
  {
    echo "Insert error";
    mysqli_close($link_db);
    exit();
  }else{
    echo "success";
    mysqli_close($link_db);
    exit();
  }
}

if($kind=="ResSales"){
  if($_POST['companyID']!=""){
    $companyID=dowith_sql($_POST['companyID']);
    $companyID=filter_var($companyID);
  }else{
    $companyID="";
  }
  if($_POST['sales']!=""){
    $sales=dowith_sql($_POST['sales']);
    $sales=filter_var($sales);
  }else{
    $sales="";
  }
  
 

  $ResSales="<label>Please select a sales: </label>";
  $ResSales.="<select class='form-control' id='res_sales'>";
  $ResSales.="<option value='none' >Select..</option>"; 
  $str_teams="SELECT ID, Team FROM partner_teams WHERE 1";
  $cmd_teams=mysqli_query($link_db,$str_teams);
  while ($result_teams=mysqli_fetch_row($cmd_teams)) {
    
    $ResSales.="<optgroup label='".$result_teams[1]."'>";

    $str_sales="SELECT ID, NAME, EMAIL FROM partner_sales WHERE Team='".$result_teams[0]."'";
    $cmd_sales=mysqli_query($link_db,$str_sales);
    while ($result_sales=mysqli_fetch_row($cmd_sales)) { 
      if($sales==$result_sales[1]){
        $status="selected";
      }else{
        $status="";
      }
      $ResSales.="<option value='".$result_sales[0]."' ".$status.">".$result_sales[1]." / ".$result_sales[2]."</option>"; 
    }
    $ResSales.="</optgroup>";
    
  }
  $ResSales.="</select>";
  echo $ResSales;
  mysqli_close($link_db);
  exit();
}

if($kind=="Logs"){
  if($_POST['companyName']!=""){
    $companyName=dowith_sql($_POST['companyName']);
    $companyName=filter_var($companyName);
  }else{
    $companyName="";
  }
  if($_POST['companyID']!=""){
    $companyID=dowith_sql($_POST['companyID']);
    $companyID=filter_var($companyID);
  }else{
    $companyID="";
  }
  $str="SELECT ID, Sales, CompanyID, CompanyName, C_DATE, U_DATE FROM partner_client_logs WHERE companyID='".$companyID."' ORDER BY C_DATE DESC";
  $cmd=mysqli_query($link_db,$str);
  $num=mysqli_num_rows($cmd);
  if($num==0){
    mysqli_close($link_db);
    exit();
  }

  $log_content="";
  
  $cmd=mysqli_query($link_db,$str);
  while ($result=mysqli_fetch_row($cmd)) { 
    if($result[5]=="0000-00-00 00:00:00"){
      $date=$result[4];
    }else{
      $date=$result[5];
    }
    $log_content.="<tr>";
    $log_content.="<td>".$result[1]."</td><td>".$date."</td>";       
    $log_content.="</tr>";
  }
  echo $log_content;
  mysqli_close($link_db);
  exit();
}

if($kind=="assSales"){
  if($_POST['CompanyID']!=""){
    $CompanyID=dowith_sql($_POST['CompanyID']);
    $CompanyID=filter_var($CompanyID);
  }else{
    $CompanyID="";
  }
  if($_POST['Company']!=""){
    $Company=dowith_sql($_POST['Company']);
    $Company=filter_var($Company);
  }else{
    $Company="";
  }
  if($_POST['res_sales']!=""){
    $res_sales=dowith_sql($_POST['res_sales']);
    $res_sales=filter_var($res_sales);
  }else{
    $res_sales="";
  }
  $str="UPDATE partner_user SET ResponsibleSales='".$res_sales."', U_DATE='".$now."' WHERE CompanyID='".$CompanyID."'";
  if(mysqli_query($link_db,$str)<1)
  {
    echo "Update Sales Error";
    mysqli_close($link_db);
    exit();
  }
  $str_leads="UPDATE partner_leads_quote SET SalesID='".$res_sales."', U_DATE='".$now."' WHERE CompanyID='".$CompanyID."'";
  if(mysqli_query($link_db,$str_leads)<1)
  {
    echo "Update leads Error";
    mysqli_close($link_db);
    exit();
  }
  $str_QT="UPDATE partner_projects SET Sales='".$res_sales."', U_DATE='".$now."' WHERE Company='".$CompanyID."'";
  if(mysqli_query($link_db,$str_QT)<1)
  {
    echo "Update QT Error";
    mysqli_close($link_db);
    exit();
  }

  $str_sales="SELECT ID, NAME, EMAIL FROM partner_sales WHERE ID='".$res_sales."'";
  $cmd_sales=mysqli_query($link_db,$str_sales);
  $result_sales=mysqli_fetch_row($cmd_sales);
  $str="INSERT INTO partner_client_logs (Sales, CompanyID, CompanyName, C_DATE) VALUES ('".$result_sales[1]."','".$CompanyID."', '".$Company."', '".$now."')";
  
  if(mysqli_query($link_db,$str)<1)
  {
    echo "Insert log error";
    mysqli_close($link_db);
    exit();
  }else{
    echo "success";
    mysqli_close($link_db);
    exit();
  }

  echo $log_content;
  mysqli_close($link_db);
  exit();
}

if($kind=="addMembers"){
  if($_POST['CompanyID']!=""){
    $CompanyID=dowith_sql($_POST['CompanyID']);
    $CompanyID=filter_var($CompanyID);
  }else{
    $CompanyID="";
  }
  if($_POST['name']!=""){
    $name=dowith_sql($_POST['name']);
    $name=filter_var($name);
  }else{
    $name="";
  }
  if($_POST['email']!=""){
    $email=dowith_sql($_POST['email']);
    $email=filter_var($email);
  }else{
    $email="";
  }
  if($_POST['title']!=""){
    $title=dowith_sql($_POST['title']);
    $title=filter_var($title);
  }else{
    $title="";
  }
  if($_POST['countryCode']!=""){
    $countryCode=dowith_sql($_POST['countryCode']);
    $countryCode=filter_var($countryCode);
  }else{
    $countryCode="";
  }
  if($_POST['tel']!=""){
    $tel=dowith_sql($_POST['tel']);
    $tel=filter_var($tel);
  }else{
    $tel="";
  }
  if($_POST['Count']!=""){
    $Count=dowith_sql($_POST['Count']);
    $Count=filter_var($Count);
  }else{
    $Count="";
  }
  $tmp_name=explode("+",$name);
  $tmp_email=explode("+",$email);
  $tmp_title=explode("+",$title);
  $tmp_countryCode=explode("+",$countryCode);
  $tmp_tel=explode("、",$tel);

  $i=0; // display mail error number[][]
  foreach ($tmp_email as $key => $value) {
   
      $str_user="SELECT ID, Name, Email FROM partner_user WHERE Email='".$value."'";
      $cmd_user=mysqli_query($link_db,$str_user);
      $num=mysqli_num_rows($cmd_user);

      if($num>0){
        echo $i;
        mysqli_close($link_db);
        exit();
      }
      $i++;
    
  }

  // Title Company Name
  $str="SELECT distinct CompanyName, ID, CompanyID, CompanyAddress, Name, Email, Title, CountryCode, Tel, ResponsibleSales, C_DATE, U_DATE FROM partner_user WHERE CompanyID='".$CompanyID."' ";
  $cmd=mysqli_query($link_db,$str);
  $result=mysqli_fetch_row($cmd);
  // Title Company Name End

  for ($j=0; $j < $Count; $j++) { 
    $country="SELECT ID, Regions, CountryCode, CountryName, CodeNumber FROM partner_countrycode WHERE CodeNumber='".$tmp_countryCode[$j]."'";
    
    $cmd_country=mysqli_query($link_db,$country);
    $result_country=mysqli_fetch_row($cmd_country);
    if($result_country[2]==""){
      $CountryCode=$tmp_countryCode[$j];
    }else{
      $CountryCode=$result_country[2];
    }

    $str="INSERT INTO partner_user (CompanyID, Name, CompanyName, CompanyAddress, Title, Email, Password, CountryCode, Tel, ResponsibleSales, FirstLogin, C_DATE)";
    $str.=" VALUES ('".$result[2]."','".$tmp_name[$j]."', '".$result[0]."', '".$result[3]."', '".$tmp_title[$j]."', '".$tmp_email[$j]."', 'X123687!k!', '".$CountryCode."', '".$tmp_tel[$j]."', '".$result[9]."', '1', '".$now."')";
    if(mysqli_query($link_db,$str)<1)
    {
      echo "Insert member error";
      mysqli_close($link_db);
      exit();
    }else{
    }
  }

  echo "success";
  mysqli_close($link_db);
  exit();
}

if($kind=="editMembers"){
  if($_POST['CompanyID']!=""){
    $CompanyID=dowith_sql($_POST['CompanyID']);
    $CompanyID=filter_var($CompanyID);
  }else{
    $CompanyID="";
  }
  if($_POST['name']!=""){
    $name=dowith_sql($_POST['name']);
    $name=filter_var($name);
  }else{
    $name="";
  }
  if($_POST['email']!=""){
    $email=dowith_sql($_POST['email']);
    $email=filter_var($email);
  }else{
    $email="";
  }
  if($_POST['title']!=""){
    $title=dowith_sql($_POST['title']);
    $title=filter_var($title);
  }else{
    $title="";
  }
  if($_POST['countryCode']!=""){
    $countryCode=dowith_sql($_POST['countryCode']);
    $countryCode=filter_var($countryCode);
  }else{
    $countryCode="";
  }
  if($_POST['tel']!=""){
    $tel=dowith_sql($_POST['tel']);
    $tel=filter_var($tel);
  }else{
    $tel="";
  }
  if($_POST['editID']!=""){
    $editID=dowith_sql($_POST['editID']);
    $editID=filter_var($editID);
  }else{
    $editID="";
  }

  /*$str_user="SELECT ID, Name, Email FROM partner_user WHERE Email='".$email."'";
  $cmd_user=mysqli_query($link_db,$str_user);
  $num=mysqli_num_rows($cmd_user);
  if($num>0){
    echo "mail";
    mysqli_close($link_db);
    exit();
  }*/

  $country="SELECT ID, Regions, CountryCode, CountryName, CodeNumber FROM partner_countrycode WHERE CodeNumber='".$countryCode."'";
  
  $cmd_country=mysqli_query($link_db,$country);
  $result_country=mysqli_fetch_row($cmd_country);
  if($result_country[2]==""){
    $countryCode=$countryCode;
  }else{
    $countryCode=$result_country[2];
  }

  $str="UPDATE partner_user SET Name='".$name."', Title='".$title."', Email='".$email."', CountryCode='".$countryCode."', Tel='".$tel."', U_DATE='".$now."' WHERE ID='".$editID."'";
  if(mysqli_query($link_db,$str)<1)
  {
    echo "Update member error";
    mysqli_close($link_db);
    exit();
  }else{
    echo "success";
    mysqli_close($link_db);
    exit();
  }
}

if($kind=="delMembers"){
  if($_POST['Delete']!=""){
    $Delete=dowith_sql($_POST['Delete']);
    $Delete=filter_var($Delete);
  }else{
    $Delete="";
  }

  $str="DELETE FROM partner_user WHERE ID='".$Delete."' ";
  $cmd=mysqli_query($link_db,$str);
  $result=mysqli_affected_rows($link_db);  
  if($result>0){  
    echo "success";
    mysqli_close($link_db);
    exit(); 
  }else{  
    echo "Delete member error";
    mysqli_close($link_db);
    exit();
  }  
}

if($kind=="editCompany"){
  if($_POST['CompanyID']!=""){
    $CompanyID=dowith_sql($_POST['CompanyID']);
    $CompanyID=filter_var($CompanyID);
  }else{
    $CompanyID="";
  }

  // Get Country Naem 
  $str_countrycode="SELECT Regions, CountryCode, CountryName, CodeNumber FROM partner_countrycode WHERE 1";
  $cmd_countrycode=mysqli_query($link_db,$str_countrycode);
  while ($data_countrycode=mysqli_fetch_row($cmd_countrycode)) {
    $country[$data_countrycode[1]]=$data_countrycode[2];
    $Regions[$data_countrycode[1]]=$data_countrycode[0];
    $CountryCode[$data_countrycode[1]]=$data_countrycode[1];
  }
  // Get Country Naem End
  // Title Company Name
  $str="SELECT CompanyName, ID, CompanyID, CompanyAddress, Name, Email, Title, CountryCode, Tel, ResponsibleSales, C_DATE, U_DATE FROM partner_user WHERE CompanyID='".$CompanyID."' ";
  $cmd=mysqli_query($link_db,$str);
  $result=mysqli_fetch_row($cmd);
  // Title Company Name End
  $content="
    <label><span class='info'>* </span>Company Name: </label>
    <div class='form-group'>
      <input id='edit_CName' type='text' placeholder='' class='form-control' value='".$result[0]."'>
      <div id='c_exist' class='alert alert-danger mb-1' role='alert'  style='display:none'>
        This company is already existed. 
      </div>
    </div>

    <label><span class='info'>* </span>Company Address: </label>
    <div class='form-group'>
      <textarea id='edit_CAddress' name='maxlength-textarea' class='form-control textarea-maxlength' placeholder='Enter upto 250 characters..' maxlength='250' rows='3'>".$result[3]."</textarea>
    </div>
    <label><span class='info'>* </span>Region: </label>
    <select class='form-control' id='edit_CCode'>";
  $cmd1=mysqli_query($link_db,$str);
  while($result1=mysqli_fetch_row($cmd1)){
    $content.="<option value='".$CountryCode[$result1[7]]."' selected>".$Regions[$result1[7]]." - ".$country[$result1[7]]."</option>";
  }
  $content.="</select>";

  echo $content;
  mysqli_close($link_db);
  exit();

}

if($kind=="editCompanyinfo"){
  if($_POST['CompanyID']!=""){
    $CompanyID=dowith_sql($_POST['CompanyID']);
    $CompanyID=filter_var($CompanyID);
  }else{
    $CompanyID="";
  }
  if($_POST['CName']!=""){
    $CName=dowith_sql($_POST['CName']);
    $CName=filter_var($CName);
  }else{
    $CName="";
  }
  if($_POST['CAddress']!=""){
    $CAddress=dowith_sql($_POST['CAddress']);
    $CAddress=filter_var($CAddress);
  }else{
    $CAddress="";
  }
  if($_POST['CCode']!=""){
    $CCode=dowith_sql($_POST['CCode']);
    $CCode=filter_var($CCode);
  }else{
    $CCode="";
  }

  $str="UPDATE partner_user SET CompanyName='".$CName."', CompanyAddress='".$CAddress."', CountryCode='".$CCode."' WHERE CompanyID='".$CompanyID."' ";
  $cmd=mysqli_query($link_db,$str);
  $result=mysqli_affected_rows($link_db);  
  if($result>0){  
    echo "success";
    mysqli_close($link_db);
    exit(); 
  }else{  
    echo "Update company error";
    mysqli_close($link_db);
    exit();
  }  
}

if($kind=="SPW"){
  if($_POST['UID']!=""){
    $UID=dowith_sql($_POST['UID']);
    $UID=filter_var($UID);
  }else{
    $UID="";
  }
  if($_POST['Umail']!=""){
    $Umail=dowith_sql($_POST['Umail']);
    $Umail=filter_var($Umail);
  }else{
    $Umail="";
  }

  $str_user="SELECT ID, Name, Email FROM partner_user WHERE ID='".$UID."' AND Email='".$Umail."'";
  $cmd_user=mysqli_query($link_db,$str_user);
  $num=mysqli_num_rows($cmd_user);
  if($num!=0){  
    $result=mysqli_fetch_row($cmd_user);
    $email=$result[2];
    $username=$result[1];
    //******** rand 產生新密碼 ********
    $random=6; //亂數長度
    for ($i=1;$i<=$random;$i++){
      $c=rand(1,3);
      //chr()將數值轉變為對應英文
      if($c==1){
        $a=rand(97,122);$b=chr($a);
      }
      if($c==2){
        $a=rand(65,90);$b=chr($a);
      }
      if($c==3){
        $b=rand(0,9);
      }
      $password=$password.$b;
    }
    //**********************************
    //$hash = password_hash($password, PASSWORD_DEFAULT);
    $str="UPDATE partner_user SET Password='".$password."', FirstLogin='1', GDPR_YN='1', confirm_member='1' WHERE ID='".$UID."' ";
    $cmd=mysqli_query($link_db,$str);

    $content="
    <table style='width: 100%;margin: 0;padding: 0;-premailer-width: 100%;-premailer-cellpadding: 0;-premailer-cellspacing: 0;background-color: #F2F4F6;' width='100%' cellpadding='0' cellspacing='0'>
      <tr>
        <td align='center'>
          <table style='width: 100%; margin: 0; padding: 0; -premailer-width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0;' width='100%' cellpadding='0' cellspacing='0'>
            <tr>
              <td style='padding: 25px 0;  '>
               <table  align='center'>
                <tr>
                  <td style='width:220px'><img src='https://www.mitacmct.com/images/mct-logo-email.png' style='border:0px;' /></td>
                  <td vlign='middle' align='center'> <div style='font-family: Arial; line-height:100%; font-size:20px; font-weight:bold; color:#434343;'> Partner Zone <br /><span style=' font-size:12px; font-weight:normal'>MiTAC Computing Technology</span></div></td>
                </tr>
              </table>
            </td>
          </tr>
          <!-- Email Body -->
          <tr>
            <td style='width: 100%; margin: 0; padding: 0;-premailer-width: 100%;-premailer-cellpadding: 0;-premailer-cellspacing: 0;border-top: 1px solid #EDEFF2;border-bottom: 1px solid #EDEFF2; background-color: #FFFFFF;' width='100%' cellpadding='0' cellspacing='0'>
              <table style='width: 570px; margin: 0 auto; padding: 0; -premailer-width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; background-color: #FFFFFF;' align='center' width='570' cellpadding='0' cellspacing='0'>
                <!-- Body content -->
                <tr>
                  <td style='padding: 35px;'>
                    <h1 style='font-family: Arial; line-height:130%; text-align:left; font-size:16px'>Hi ".$username.",</h1>
                    <p style='font-family: arial; line-height:130%;  text-align:left; font-size:14px'>
                     
                     We're emailing to notify your account info for MiTAC Partner Zone. Now you can use your email with password below to log in MiTAC Partner Zone.<br /><br />

                     <span style='font-weight:bold; color:#000000; font-size:14px'>Password: ".$password." </span>
                     <br /><br />
                     For your account security, please be sure to change your password after login. 

                   </p>
                   
                   <table style='width: 100%;  margin: 30px auto;  padding: 0;  -premailer-width: 100%;  -premailer-cellpadding: 0;  -premailer-cellspacing: 0;  text-align: center;' align='center' width='100%' cellpadding='0' cellspacing='0'>
                    <tr>
                      <td align='center'>
                        
                        
                       <br />
                       <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                        <tr>
                          <td align='center'>
                            <table border='0' cellspacing='0' cellpadding='0'>
                              <tr> <td>
                                <a href='https://www.mitacmct.com/' style='font-family: arial; line-height:130%; background-color: #3869D4; border-top: 10px solid #3869D4; border-right: 18px solid #3869D4;border-bottom: 10px solid #3869D4;border-left: 18px solid #3869D4;display: inline-block;color: #FFF;text-decoration: none;border-radius: 3px;box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);-webkit-text-size-adjust: none;' target='_blank'>LOG IN</a>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                    <p style='font-family: arial; line-height:130%;  text-align:left; font-size:14px'>Thanks,
                      <br>Partner Zone | MiTAC Computing Technology</p>
                      <!-- Sub copy -->
                      
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td>
               <table style='width: 570px;  margin: 0 auto;  padding: 0;  -premailer-width: 570px;  -premailer-cellpadding: 0;  -premailer-cellspacing: 0;  text-align: center;' align='center' width='570' cellpadding='0' cellspacing='0' style='border-top:1px solid #ccc'>
                <tr>
                  <td style='padding: 35px;' align='center'>
                    <p style='font-family: arial; line-height:130%; font-size: 12px; text-align: center;'>This is an automatic message. Please do not reply to this email. <a href='https://www.mitacmct.com/EN/contact/' />Contact us via here. </a></p>
                    
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    </table>
    <table style='width: 570px;  margin: 0 auto;  padding: 0;  -premailer-width: 570px;  -premailer-cellpadding: 0;  -premailer-cellspacing: 0;  text-align: center;' align='center' width='570' cellpadding='0' cellspacing='0'>
      <tr>
        <td style='padding: 35px;' align='center'>
          <p style='font-family: arial; line-height:130%; font-size: 12px;text-align: center;'>&copy; MiTAC Computing Technology Corporation (MiTAC Group) and/or any of its affiliates. <br />All Rights Reserved.</p>
          
        </td>
      </tr>
    </table>
    ";

    $mail= new PHPMailer(); //建立新物件   
    $mail->IsSMTP(); //設定使用SMTP方式寄信   
    $mail->SMTPAuth = false; //設定SMTP需要驗證   
    //$mail->SMTPSecure = "ssl"; //ssl tls
    //$mail->SMTPDebug = 2;
    $mail->Host = "10.88.0.58"; //設定SMTP主機   smtp.gmail.com
    $mail->Port = 25; //設定SMTP埠位，預設為25埠   587 80
    $mail->CharSet = "utf-8"; //設定郵件編碼   

    $mail->Username = "global-marketing@tyan.com"; //設定驗證帳號   tyanwebsite@gmail.com
    $mail->Password = "Tyan1989@"; //設定驗證密碼   9ijnmklp0

    $mail->From = "noreply-to-partner-zone@mitacmct.com"; //設定寄件者信箱   
    $mail->FromName = "Partner Zone | MiTAC Computing Technology"; //設定寄件者姓名   

    $mail->Subject = "Account info for MiTAC Partner Zone"; //設定郵件標題   
    $mail->Body = $content; //設定郵件內容 
    $mail->IsHTML(true); //設定郵件內容為HTML   
  $mail->SMTPAutoTLS = false;   

    $mail->AddAddress($email, $username); //設定收件者郵件及名稱 
    //$mail->AddAddress("nick.t@tyan.com.tw", "Nick.t"); //設定收件者郵件及名稱 
    if(!$mail->Send()) {
      $errorMail=$mail->ErrorInfo;

      $admail= new PHPMailer(); //建立新物件   
      $admail->IsSMTP(); //設定使用SMTP方式寄信   
      $admail->SMTPAuth = false; //設定SMTP需要驗證   
      //$mail->SMTPSecure = "ssl"; //ssl tls
      //$mail->SMTPDebug = 2;
      $admail->Host = "10.88.0.58"; //設定SMTP主機   smtp.gmail.com
      $admail->Port = 25; //設定SMTP埠位，預設為25埠   587 80
      $admail->CharSet = "utf-8"; //設定郵件編碼   

      $admail->Username = "global-marketing@tyan.com"; //設定驗證帳號   tyanwebsite@gmail.com
      $admail->Password = "Tyan1989@"; //設定驗證密碼   9ijnmklp0

      $admail->From = "noreply-to-partner-zone@mitacmct.com"; //設定寄件者信箱   
      $admail->FromName = "Partner Zone | MiTAC Computing Technology"; //設定寄件者姓名   

      $admail->Subject = "Account info for MiTAC Partner Zone"; //設定郵件標題   
      $admail->Body = $errorMail; //設定郵件內容 
      $admail->IsHTML(true); //設定郵件內容為HTML  
    $admail->SMTPAutoTLS = false;    
      $admail->AddAddress("nick.t@tyan.com.tw", "Nick.t"); //設定收件者郵件及名稱 
      //$admail->AddCC("even.syao@tyan.com.tw", "even.syao");  
      $admail->Send();   
      echo "Mailer Error: " . $mail->ErrorInfo;  
      mysqli_close($link_db);
      exit(); 
    } else {   
      echo "success";
      mysqli_close($link_db);
      exit();
    }
  }else{  
    echo "Error";
    mysqli_close($link_db);
    exit();
  }  
}
?>