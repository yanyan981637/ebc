<?php
header("X-Frame-Options: DENY");
//header("Content-Security-Policy-Report-Only: default-src *; img-src https:; frame-src 'none'; report-uri http://www.tyan.com");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://dev-ipc.mitacmdt.com/");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
header("Location: https://dev-ipc.mitacmdt.com/");
exit();
if(strpos(trim(getenv('REQUEST_URI')),'?')!='' || strpos(trim(getenv('REQUEST_URI')),'?')===0 || strpos(trim(getenv('REQUEST_URI')),"'")!='' || strpos(trim(getenv('REQUEST_URI')),"'")===0 || strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
header("HTTP/1.1 301 Moved Permanently");
header("Location: /404.htm");
exit;
}

require "../config.php";

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
  $str = str_replace("char","",$str);
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

session_start();
/*if($_SESSION['FEuser']!=""){
  header('Location: https://ipc.mitacmdt.com/PartnerZone/FEdashboard');
  exit();
}else{
  $login="";
}*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewpoint" content="width=evice-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <title>Welcome to MiTAC Partner Zone</title>
  <link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
  <link rel="shortcut icon" href="/images/ico/favicon.ico">
  <link rel="manifest" href="images/favicon/site.webmanifest">
  <link rel="mask-icon" href="images/favicon/safari-pinned-tab.svg" color="#5bbad5">

  <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/css/login.css">




</head>
<body style="background:#00296b;">
  <section>

    <img src="images/login-bg.jpg" class="bg">
    <div class="content">
      <div ><a href="https://ipc.mitacmdt.com" /><img src="images/mitac-logo.png" /></a></div>
      <h1>MiTAC Partner Zone</h1>
      <h2>Log In</h2>
      <p></p>
      <form>
        <div class="form-group">
          <label for="exampleInputEmail1">Email Address</label>
          <input id="acc_mail" name="acc_mail" type="email" class="form-control form-control-lg" aria-describedby="emailHelp" value="<?=$user?>">
          <div id="err_Email" name="err_Email" class="alert alert-danger mb-1" role="alert" style="display:none">
            Please enter a valid email.
          </div>
        </div>

        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input id="password" name="password" type="password" class="form-control form-control-lg" value="<?=$pw?>">
          <div id="err_Password" name="err_Password" class="alert alert-danger mb-1" role="alert" style="display:none" >
            Sorry. Email / password combination is wrong.
          </div>
        </div>

        <!--recaptcha-->
        <div class="row" style="margin:5px 0px 15px 0px; font-size:1rem">
          <div class="col-sm-12">

            <div style="margin:3% 0%">
              <img src="captcha@1" id="rand-img" border="0" width="150" style="cursor: pointer; cursor: hand;">
              <input type="text" name="checknum" id="checknum" size="4" maxlength="4" autocomplete="off">
            </div>
            <a href="" id="refresh" onclick="return false">Refresh the Captcha.</a><br>
            <div id="err_captacha" class="alert alert-danger mb-1" role="alert" style="display:none">Incorrect Captcha.</div>

          </div>

        </div>
        <!--end recaptcha-->
        <div class="checkmark-reg" >
          <label for="terms"><input type="checkbox" id="terms"><span class="tp-checkmark" value='1'></span> Keep me logged in</label>
        </div>


        <a href="#" /><button id="signin" type="button" class="btn  btn-lg btn-outline-light">Log In</button></a>
      </form>
      <div class="fpw" style=""><a href="" data-toggle="modal" data-target="#Forgotpassword" />Forgot password?</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="FEregister" />Register an account.</a></div>
      <div style="margin:6% 0">&nbsp;</div>
      <div class="copyrightText">Copyright&copy; 2021-2022 MiTAC Digital Technology Corporation. All Rights Reserved. <br />Please use the latest version of Firefox or Chrome to view this site.<br />
       <a href="https://www.tyan.com/EN/legal/terms_of_use/" target="tos" />Terms of Use</a>&nbsp;·&nbsp;
       <a href="https://www.tyan.com/EN/legal/privacy_policy/" target="tos" />Privacy Policy</a>&nbsp;·&nbsp;
       <a href="https://www.tyan.com/EN/legal/cookie_policy/" target="tos" />Cookie Policy</a>
     </div>
   </div>

   <div class="content-right">
    <h2>Welcome to visit MiTAC Partner Zone</h2>
    <div class="clearfix"></div><br />
    <p>You can request quotations, access marketing assets, customized software or documents in here. Register for an account now or contact with your Tyan sales representative.</p>

  </div>
</section>







<!-- Modal -->
<div class="modal fade" id="Forgotpassword" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Reset Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!--msg for reset successfully-->
        <div id="resetMsg" class="alert alert-info mb-1 topmargin-sm" role="alert" style="display:none">
        Success in resetting password. Please check your email for the new password.
        </div>
        <!--msg for reset successfully-->
        <form id="forgot_password" method="POST">
          <div class="">
            Please enter your email address that you used to register. We'll send you an email with your new password.
          </div><br />
          <div class="form-group">

            <input id="re_mail" type="email" class="form-control form-control-lg" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email" required>
          </div>
          <div id="err_mail" class="alert alert-danger mb-1" role="alert" style="display:none">
            This email doesn’t exist.
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button id="resetPW" type="button" class="btn btn-primary">RESET MY PASSWORD</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>




<script>


</script>



<script src="app-assets/js/core/libraries/jquery.min.js"></script>
<script src="app-assets/js/core/libraries/bootstrap.min.js"></script>



</body>

<script>
$(function(){
  $("#signin").click(function(){
    if($("#acc_mail").val()!=""){
      var search_str = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
      var mail_val = $("#acc_mail").val();
      if(search_str.test(mail_val)){
        $("#err_Email").hide();
        $("#err_Password").hide();
        $("#err_captacha").hide();
      }else{
        $("#err_Email").show();
        $("#err_Password").hide();
        $("#err_captacha").hide();
        exit;
      }
    }else{
      $("#err_Email").show();
      $("#err_Password").hide();
      $("#err_captacha").hide();
      exit;
    }

    if($("#password").val()==""){
      $("#err_Email").hide();
      $("#err_Password").show();
      $("#err_captacha").hide();
      exit;
    }
    if($("#checknum").val()==""){
      $("#err_Email").hide();
      $("#err_Password").hide();
      $("#err_captacha").show();
      exit;
    }
    var acc_mail = $("#acc_mail").val();
    var password = $("#password").val();
    var Checknum1 = $("#checknum").val();
    var terms = $("#terms").prop("checked");

    var kind = "Login";
    var url = "loginProcess";
    $.ajax({
      type: "post",
      url: url,
      dataType: "html",
      data: {
        acc_mail : acc_mail,
        password : password,
        Checknum1 : Checknum1,
        terms : terms,
        kind : kind
      },
      success: function(message){
        if(message == "success"){
          document.location.href="FEdashboard";
        }else if(message.indexOf("FEpassword") != -1 ){
          document.location.href=message;
        }else if(message == "captacha"){
          $("#err_Email").hide();
          $("#err_Password").hide();
          $("#err_captacha").show();
        }else if(message == "errMsg"){
          $("#err_Email").hide();
          $("#err_Password").show();
          $("#err_captacha").hide();
        }else{
          alert(message);
        }
      }
    });
  })
})

$("#resetPW").click(function(){
  $("#err_mail").hide();
  var mail = document.getElementById("re_mail").value;
  if(mail!=""){

    var search_str = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
    var mail_val = $("#re_mail").val();
    if(search_str.test(mail_val)){
      $("#err_mail").hide();
    }else{
      $("#err_mail").show();
      exit;
    }
  }else if(mail==""){
    $("#err_mail").show();
    exit;
  }
  var kind="reset";
  var url = "loginProcess";
  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
    mail : mail,
    kind : kind
  },
  success: function(message){
    if(message == "success"){
      $("#resetMsg").show();
      //document.location.href="index.html";
    }else if(message == "errMsg"){
       $("#err_mail").show();
      exit;
    }else{
      alert(message);
    }
  }
  });
})

//captcha
$(function(){
    $("#refresh").click(function() {
       var obj = document.getElementById("rand-img");
       var i=Math.floor((Math.random() * 10) + 1);
       obj.src=null;
       var url = "captcha@"+i;
       $.ajax({
        type: "post",
        url: url,
        dataType: "html",
        success: function(message){
            if(message == "susses"){
                alert(message);
            }else{
                obj.src="captcha@"+i;
            }
        }
        });
   });
})

</script>

</html>


