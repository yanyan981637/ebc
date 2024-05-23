<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Website backend system</title>
<link rel="stylesheet" type="text/css" href="backend.css">
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript" src="jquery.cookie.js"></script>

<script type="text/javascript">
$(function(){
    $("#rand-img").click(function(){
		$(this).attr("src",'showrandimg.php?rnd=' + Math.random());
	});
});
</script>
<script language="JavaScript">
function check(){
  var kinds=document.form1.system_kind.value;
  var user=document.form1.user.value;
  var s_password=document.form1.s_password.value;
  if(kinds==""){
    alert("You need select one system.");
    document.form1.system_kind.focus();
    return false;
  }
  else if(user=="" && s_password==""){
    alert("Please enter your login ID and Password.");
    document.form1.user.focus();
    return false;
  }
  else if(user==""){
    alert("Please enter your login ID.");
    document.form1.user.focus();
    return false;
  }
  else if(s_password==""){
    alert("Please enter the password. Incorrect login ID and password combination.");
    document.form1.s_password.focus();
    return false;
  }
  else{
    document.form1.submit();
    return true;
  }
}
</script>
<script language="JavaScript"> 
function cookie_data(){
 if($.cookie("userNames")!=null || $.cookie("passWords")!=null){
 document.getElementById("user").value=$.cookie("userNames");
 document.getElementById("s_password").value=$.cookie("passWords");
 }
}
</script>
<script type="text/javascript">
$(function(){
$("#rmbUsers").click(function() {
    var userName = $("#user").val(); 
    var passWord = $("#s_password").val();    
    $.cookie("userNames", userName, { expires: 7 });
    $.cookie("passWords", passWord, { expires: 7 });
});

})
</script>
</head>
<body leftmargin="0" topmargin="0" marginheight="0" marginwidth="0" oncontextmenu="window.event.returnValue=false" 
onkeypress="window.event.returnValue=true" 
onkeydown="window.event.returnValue=true" 
onkeyup="window.event.returnValue=false" 
ondragstart="window.event.returnValue=false" 
onselectstart="event.returnValue=false" onload="cookie_data()">
<h1>&nbsp;&nbsp;Website Backends</h1>
<div id="login_header">
  <p style="font-size:24px; padding-left:20px " class="left">Sign In</p>
  <!-- <p style="padding:20px; " class="right"> <a href="mailto:ocean.huang@mic.com.tw">Don't have an account?</a></p> -->
</div>
<div id="login">
  <form name="form1" method="post" action="check.php" onsubmit="return check();">
  <p>
    <select name="system_kind" class="bigdropdown">
      <option selected="selected" class="bigdropdown" value="">Please Select...</option>
      <option class="bigdropdown" value="spec_creation_tool">SPEC Creation Tool</option>
      <option class="bigdropdown" value="contents_management">Website Contents Management</option>
      <option class="bigdropdown" value="contact_us">Contact Us</option>
      <option class="bigdropdown" value="contact_us_DSG">Contact Us – DSG</option>
      <option class="bigdropdown" value="catalog_emails">Catalog Emails</option>
    </select>
    <span class="error"></span><span id="ip_val"></span></p>
  <p>ID / E-mail: <br />
    <input id="user" name="user" type="text" size="30" value="" class="biginput" />
    <span class="error"></span> </p>
  <p>Password: <br />
    <input id="s_password" name="s_password" type="password" size="30" value="" class="biginput" />
    <span class="error"></span><br />
  <p>Enter your ValidateCode: 
  <div id="vals-img" style="width: 60px;"><img src="showrandimg.php" id="rand-img" border="0" width="150" style="cursor: pointer; cursor: hand;"></div> <input type="text" name="checknum" id="checknum" size="4" maxlength="4">
  </p>
  <p>
    <input id="rmbUsers" name="rmbUsers" type="checkbox" value="1" />
    Remember me</p>
  <div><input type="submit" class="button14" style="width:60px;" value="Sign in" /></div>
  </form>
</div>
<p class="clear">&nbsp;</p>
<div id="footer"> Copyright &copy; 2014 Company Co. All rights reserved.</div>
</body>
</html>