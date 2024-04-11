<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

if(isset($_SERVER['HTTP_REFERER'])!=''){
  if(basename($_SERVER['HTTP_REFERER'])!='login.php'){
    echo "<script language='JavaScript'>location.href='login.php';</script>";
    exit();
  }
}else{
  echo "<script language='JavaScript'>location.href='login.php';</script>";
  exit();
}

require "config.php";

class CActionLogin //extends CActionLogin
{
  function doAction()
  {
    $ret = "";
    $job = "check";
    
    switch($job)
    {
     case "check":
     $ret = $ret . $this->Check();
     break;
     case "login":
     $ret = $ret . $this->Login();
     break;
   }
   
   return $ret;
 }
 
 function get_client_ip(){   
   foreach(array(   
     'HTTP_CLIENT_IP',   
     'HTTP_X_FORWARDED_FOR',   
     'HTTP_X_FORWARDED',   
     'HTTP_X_CLUSTER_CLIENT_IP',   
     'HTTP_FORWARDED_FOR',   
     'HTTP_FORWARDED',   
     'REMOTE_ADDR'  
     ) as $key) {   
     if(!array_key_exists($key, $_SERVER)){ continue; }   
   
   foreach(explode(',', $_SERVER[$key]) as $ip) {   
     $ip= trim($ip);   
     if((bool) filter_var($ip,   
       FILTER_VALIDATE_IP,   
       FILTER_FLAG_IPV4 |   
       FILTER_FLAG_NO_PRIV_RANGE |   
       FILTER_FLAG_NO_RES_RANGE   
       )){ return $ip; }   
   }   
}   
return null;   
}

function Check()
{

  $slen= strrpos($_SERVER['REMOTE_ADDR'], ".");
  $dir = substr($_SERVER['REMOTE_ADDR'],0,$slen);

  if(isset($_POST['system_kind'])!=''){
    $system_kind=trim($_POST['system_kind']);
  }else{
    $system_kind="";
  }  
  
  if($system_kind=='spec_creation_tool'){
    $weburl="../MCTWEBMGT/spec_creation_tool";
  }else if($system_kind=='contents_management'){
    $weburl="./contents_management";
  }else{
    $weburl="./contents_management";
  }
  $user=preg_replace("/['\"\~\%\$ \r\n\t;<>\?]/i", '', $_POST['user']);
  $s_password=preg_replace("/['\"\~\%\$ \r\n\t;<>\?]/i", '', $_POST['s_password']);
  

  if(strpos($user,'@')!="" || strpos($user,'@')===0){
    $user_A=$user;
  }else{
    $user_A=$user."@mic.com.tw";
  }

  $db=new CMysql();
  //$db->CMysql();  
  
  $str="select `User_Auto_No`, `User_ID`, `User_Pwd`, `User_Name`, `User_authorized`, `User_ID_Enable` from user_login where User_ID='$user_A' and User_Pwd='$s_password';";
  $result=mysqli_query($db->conn,$str);
  $record=mysqli_fetch_row($result);

  if(empty($record)):
    echo "<script language='JavaScript'>location.href='login.php';</script>";
  exit();
  else:

    session_start();

  if(isset($_SESSION["Checknum"])!=''){
   if($_SESSION["Checknum"]==$_POST['checknum'] ){
     $msg = "You enter the correct verification code！";	
     putenv("TZ=Asia/Taipei");
     $login_time=date("Y,m d,h:i:s A");

     $_SESSION['user']=$user_A;
     $_SESSION['password']=$s_password;
     $_SESSION['login_time']=$login_time;
     $_SESSION['authorized']=$record[4];	

     echo "<script language='JavaScript'>self.location='$weburl/default.php';</script>";
     exit();
   }else{ 
     $msg = "You entered the wrong security code！Please re-enter。 "; 
     echo "<script>alert('".$msg."');history.go(-1);</script>"; 
   }
 }
 

 endif;
 $dbc=new CMysql();
 $dbc->CMysqlClose();
}

};

$action = new CActionLogin();
echo $action->doAction();
?> 