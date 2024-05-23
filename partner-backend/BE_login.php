<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<title>Login - BACKEND - MiTAC Partner Zone</title>

<link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
<link rel="shortcut icon" href="/images/ico/favicon.ico">
<link rel="manifest" href="images/favicon/site.webmanifest">
<link rel="mask-icon" href="images/favicon/safari-pinned-tab.svg" color="#5bbad5">

<!-- BEGIN VENDOR CSS-->
<link rel="stylesheet" type="text/css" href="app-assets/css/vendors.css">
<!-- END VENDOR CSS-->
<!-- BEGIN ROBUST CSS-->
<link rel="stylesheet" type="text/css" href="app-assets/css/app.css">
<link rel="stylesheet" type="text/css" href="app-assets/fonts/font-awesome/css/fontawesome.css" >
<link rel="stylesheet" type="text/css" href="app-assets/fonts/feather/fonts/style.min.css" >	
<!-- END ROBUST CSS-->
<!-- BEGIN Page Level CSS-->
<link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.css">
<!-- END Page Level CSS-->
<!-- BEGIN Custom CSS-->

<link rel="stylesheet" type="text/css" href="assets/css/login.css">
<!-- END Custom CSS-->

</head>
<body  class="vertical-layout vertical-menu 1-column   menu-expanded blank-page blank-page" data-open="click" data-menu="vertical-menu" data-col="1-column">
<!-- ////////////////////////////////////////////////////////////////////////////-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
    </div>
    <div class="content-body"><section class="flexbox-container">



        <div class="col-12 d-flex align-items-center justify-content-center">



            <div class="col-md-5 col-10 box-shadow-2 p-0">
                <div class="card border-grey border-lighten-3 m-0">
                    <div class="card-header border-0">
                        <div class="card-title text-center">
                            <div class="p-1"><img src="app-assets/images/logo/mitac-logo-b.png" ></div>
                        </div>
                        <h1 class="text-center">BACKEND-MiTAC Partner Zone</h1>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                                <fieldset class="form-group position-relative has-icon-left mb-1">
                                    <input type="text" class="form-control form-control-lg input-lg" id="user_name" placeholder="Enter Email" required>
                                    <div class="form-control-position">
                                        <i class="ft-mail"></i>
                                    </div>
                                </fieldset>
                                <fieldset class="form-group position-relative has-icon-left">
                                    <input type="password" class="form-control form-control-lg input-lg" id="user_password" placeholder="Enter Password" required>
                                    <div class="form-control-position">
                                        <i class="fa fa-key"></i>
                                    </div>
                                </fieldset>

                                <div id="err_msg" class="alert alert-danger mb-1" role="alert" style="display:none">
                                 Sorry. Email / password combination is wrong.
                             </div>

                             <!--recaptcha-->
                             <div class="row" style="margin:5px 0px 5px 0px; ">
                              <div class="col-sm-12">
                                <div style="margin:3% 0%">
                                  <img src="captcha@1" id="rand-img" border="0" width="150" style="cursor: pointer; cursor: hand;">
                                </div>
                                  <a href="" id="refresh" onclick="return false"/>Refresh the Captcha.</a>
                                  <input id="Captcha" type="" size="10" >
                              </div>

                          </div>
                          <!--end recaptcha-->
                          <div class="form-group row">
                            <div class="col-md-6 col-12 text-center text-md-left">
                                <fieldset>
                                    <input type="checkbox" name="rememberme" id="rememberme" class="chk-remember">
                                    <label for="remember-me"> Remember Me</label>
                                </fieldset>
                            </div>
                            <div class="col-md-6 col-12 text-center text-md-right"></div>
                        </div>
                        <button id="loginOK" type="button" class="btn btn-info btn-lg btn-block"><i class="ft-unlock"></i> Login</button>




                    <div class="text-center" style="margin-top:20px">
                     <a href="" data-toggle="modal" data-target="#Forgotpassword" />Forgot password?</a>
                 </div>


             </div>
         </div>
         <div class="card-footer">
            <div class="">

            </div>
        </div>
    </div>
</div>
</div>
</section>

</div>
</div>
</div>





<!-- Forget password Modal -->
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
<form id="forgot_password" method="POST">
    <div class="">
        Please enter your email address. We'll send you an email with your new password.
    </div><br />
    <div class="form-group">

      <input id="re_mail" type="email" class="form-control form-control-lg" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email" required>
  </div>
  <div id="err_mail" class="alert alert-danger mb-1" role="alert" style="display:none">
      This email doesn't exist.
  </div>


</form>
</div>
<div class="modal-footer">
<button id="resetPW" type="button" class="btn btn-info">RESET MY PASSWORD</button>
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

</div>
</div>
</div>
</div>
<!-- end Forget password Modal -->



<!-- ////////////////////////////////////////////////////////////////////////////-->

<!-- BEGIN VENDOR JS-->

<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->

<script src="app-assets/js/core/libraries/jquery.min.js"></script>
<script src="app-assets/js/core/libraries/bootstrap.min.js"></script>
<script src="app-assets/js/core/app-menu.js"></script>
<script src="app-assets/js/core/app.js"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<!-- END PAGE LEVEL JS-->
<script>
$("#loginOK").click(function(){
  var name = document.getElementById("user_name").value;
  if(name!=""){

    var search_str = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
    var mail_val = $("#user_name").val();
    if(search_str.test(mail_val)){
      $("#err_msg").hide();
    }else{
      $("#err_msg").show();
      exit;
    }
  }else if(name==""){
    $("#err_msg").show();
    exit;
  }
  var password = document.getElementById("user_password").value;
  var Captcha = document.getElementById("Captcha").value;
  if(Captcha==""){
    alert("Please enter captcha");
    exit;
  }
  var kind="Login";
  var url = "loginProcess";
  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
    name : name,
    password : password ,
    Captcha : Captcha,
    kind : kind
  },
  success: function(message){
    if(message == "success"){
      document.location.href="BEdashboard";
    }else if(message.indexOf("BEpassword") != -1 ){
      document.location.href=message;
    }else if(message == "errMsg"){
      $("#err_msg").show();
      exit;
    }else if(message == "Captcha"){
      alert("Captcha error");
      exit;
    }else{
      alert(message);
    }
  }
  }); 
})

$("#resetPW").click(function(){
  $("#err_mail").hide();
  var mail = document.getElementById("re_mail").value;
  if(mail!=""){

    var search_str = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
    var mail_val = $("#re_mail").val();
    if(search_str.test(mail_val)){
      $("#v").hide();
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
      document.location.href="BEdashboard";
    }else if(message == "errMsg"){
       $("#err_mail").show();
      exit;
    }else{
      alert(message);
    }
  }
  }); 
})

$(function(){
    $("#rememberme").click(function() {
        var userName = $("#user_name").val(); 
        var passWord = $("#user_password").val();
        $.cookie("userNames", userName, { expires: 7 });
        $.cookie("passWords", passWord, { expires: 7 });

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
            if(message == "success"){
                alert(message);
            }else{
                obj.src="captcha@"+i;
            }
        }
        });
   });
})
</script>
</body>
</html>