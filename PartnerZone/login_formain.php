<?php
// ***** 由TYAN RFQ進來, 判斷是否有帳號的處理頁

header("X-Frame-Options: DENY");
//header("Content-Security-Policy-Report-Only: default-src *; img-src https:; frame-src 'none'; report-uri http://www.tyan.com");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://www.mitacmct.com/");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

if(strpos(trim(getenv('REQUEST_URI')),'?')!='' || strpos(trim(getenv('REQUEST_URI')),'?')===0 || strpos(trim(getenv('REQUEST_URI')),"'")!='' || strpos(trim(getenv('REQUEST_URI')),"'")===0 || strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
  echo "<script language='javascript'>self.location='/index.html'</script>";
  exit;
}

require "config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');

function dowith_sql($str){
  $str = str_replace("and","",$str);
  $str = str_replace("execute","",$str);
  $str = str_replace("update","",$str);
  $str = str_replace("count","",$str);
  $str = str_replace("chr","",$str);
  $str = str_replace("<script>","",$str);
  $str = str_replace("</script>","",$str);
  $str = str_replace("javascript","",$str);
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
//$str = str_replace("or","",$str); //2017.05.23 因舊資料SKU關係, 暫時註解
  $str = str_replace("=","~",$str);
  return $str;
}
if(isset($_GET['rfq'])!=''){
  $rfq=dowith_sql($_GET['rfq']);
  $rfq=filter_var($rfq);
}else{
  $rfq="";
}
if(isset($_GET['qty'])!=''){
  //$qty=dowith_sql($_GET['qty']);
  $qty=filter_var($_GET['qty']);
}else{
  $qty="";
}
$rfq=str_replace(" ","+", $rfq);
$qty=str_replace(" ","+", $qty);
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">


<title>MiTAC Partner Zone - Login</title>


<link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
<link rel="shortcut icon" href="/images/ico/favicon.ico">
<link rel="manifest" href="images/favicon/site.webmanifest">
<link rel="mask-icon" href="images/favicon/safari-pinned-tab.svg" color="#5bbad5">

<!-- BEGIN VENDOR CSS-->
<link rel="stylesheet" type="text/css" href="app-assets/css/vendors.css">
<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/selects/select2.min.css">

<!-- END VENDOR CSS-->
<!-- BEGIN ROBUST CSS-->
<link rel="stylesheet" type="text/css" href="app-assets/css/app.css">
<link rel="stylesheet" type="text/css" href="app-assets/fonts/font-awesome/css/fontawesome.css" >
<link rel="stylesheet" type="text/css" href="app-assets/fonts/feather/fonts/style.min.css" >	
<!-- END ROBUST CSS-->
<!-- BEGIN Page Level CSS-->
<!--<link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.css">-->
<link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-overlay-menu.css">
<!-- END Page Level CSS-->
<!-- BEGIN Custom CSS-->
<link rel="stylesheet" type="text/css" href="assets/css/style.css">
<link rel="stylesheet" type="text/css" href="assets/css/register.css">
<!-- END Custom CSS-->
</head>
<body class="vertical-layout vertical-content-menu 1-column   menu-expanded blank-page blank-page" data-open="click" data-menu="vertical-content-menu" data-col="1-column">
	<!-- ////////////////////////////////////////////////////////////////////////////-->
	<div class="app-content content">
		<div class="content-wrapper">
			<div class="content-header row">
			</div>
			<div class="content-body">
				<section class="">
					<div class="col-12 d-flex align-items-center justify-content-center">
						<div class="col-md-12 col-12 box-shadow-2 p-0" >
							<div class="card border-grey border-lighten-3 px-2 py-2 m-0">
								<div class="card-header border-0">
									<div class="card-title text-center">
										<div ><a href="https://www.mitacmct.com/PartnerZone/" /><img src="app-assets/images/logo/tyan-logo-register.png" /></a></div>
										<h1>MiTAC Partner Zone</h1>

									</div>

								</div>
								<div class="copyrightText text-center" style="width:100%"></div>
								<div class="card-content">	
									<div class="card-body">

										<div class="row">
											<div class="col-xl-6 col-lg-6">
												<!--Quote list-->
												<div class="card bg-indigo bg-lighten-4">

													<div class="card-body" style="padding: 40px;">
														<h3><i class="icon-dollar"></i>&nbsp;&nbsp;Request for Quote (RFQ)</h3>
														<input id="Quote" type="hidden" value="<?=$rfq;?>">
														<input id="QuoteQty" type="hidden" value="<?=$qty;?>">
														<table class="table" style="" >
															<tr><th><h4>Product</h4></th><th><h4>Qty</h4></th></tr>
															<?php
															if($rfq!=""){
																$rfq=explode("+" , $rfq);
																$qty=explode("+" , $qty);
																foreach ($rfq as $key => $value) {
																	if($value!=""){
															    		//$new_arrQty[$value]=$qty[$key];
																		$str="SELECT Product_SKU_Auto_ID, SKU, MODELCODE, Quote, ProductTypeID FROM product_skus WHERE SKU='".$value."' AND Product_SKU_Auto_ID>'700000000'";
																		$cmd=mysqli_query($link_db,$str);
																		$result=mysqli_fetch_row($cmd);
																		if($result[0]!=""){
																			echo "<tr><td>".$value." (".$result[2].")</td><td>".$qty[$key]."</td></tr>";
																		}
																	}
																}
															}
															?>

														</table>
													</div>
												</div>
												<!--end Quote list-->	
											</div>
											<div class="col-xl-6 col-lg-6">
												<!--login-->
												<div class="card border-indigo border-lighten-4">

													<div class="card-body" style="padding: 40px;">

														<form id="login-form" name="login-form" class="nobottommargin" action="#" method="post">

															<h3>Already have an account for Tyan Partnet Portal? Log in to your Account.</h3>
															<br/><br/>				

															<div class="form-group">
																<label for="exampleInputEmail1">Email Address</label>
																<input id="acc_mail" type="email" class="form-control form-control-lg" aria-describedby="emailHelp">
																<div id="err_Email" name="err_Email" class="alert alert-danger mb-1" role="alert" style="display:none">
																	Please enter a valid email.
																</div>
															</div>

															<div class="form-group">
																<label for="exampleInputPassword1">Password</label>
																<input id="password" type="password" class="form-control form-control-lg">
																<div id="err_Password" name="err_Password" class="alert alert-danger mb-1" role="alert" style="display:none">
																	Sorry. Email / password combination is wrong.
																</div>
															</div>

															<!--recaptcha-->
															<div class="row" style="margin:5px 0px 15px 0px; font-size:1.5rem">
																<div class="col-sm-12">

																	<div style="margin:3% 0%">
																		<img src="captcha@1" id="captcha" border="0" width="150" style="cursor: pointer; cursor: hand;">
																	</div>
																	<a href="#" id="refresh">Refresh the Captcha.</a><br>
																	<input type="text" name="checknum1" id="checknum1" size="4" maxlength="4" autocomplete="off">
																</div>
																<div id="err_captacha" class="alert alert-danger mb-1" role="alert" style="display:none">Incorrect Captcha.</div>
															</div>
															<!--end recaptcha-->



															<button id="PNlogin" type="button" class="btn btn-dark btn-min-width mr-1 mb-1 btn-lg text-uppercase font-medium-3">Log In</button>
															&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
															<a href="#" data-toggle="modal" data-target="#default" />Forgot password?</a>


															<!-- Modal -->
															<div class="modal fade text-left" id="default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
																<div class="modal-dialog" role="document">
																	<div class="modal-content">
																		<div class="modal-header">
																			<h2 class="modal-title" id="myModalLabel1">Reset Password</h2>
																			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																				<span aria-hidden="true">&times;</span>
																			</button>
																		</div>
																		<div class="modal-body">


																			<!--msg for reset successfully-->
																			<div id="reset_done" name="reset_done" class="alert alert-info mb-1 topmargin-sm" role="alert" style="display:none">
																				Success in resetting password. Please check your email for the new password.
																			</div>
																			<!--msg for reset successfully-->	


																			<p>
																				<form id="forgot_password" method="POST">
																					<div class="">
																						Please enter your email address that you used to register MiTAC Partner Zone. We'll send you an email with your new password.
																					</div><br />



																					<div class="form-group">

																						<input id="re_mail" type="email" class="form-control form-control-lg" aria-describedby="emailHelp" placeholder="Email" required>
																					</div>
																					<div id="reset_err" name="reset_err" class="alert alert-danger mb-1" role="alert" style="display:none">
																						This email doesn't exist.
																					</div>


																				</form>

																			</p>


																		</div>
																		<div class="modal-footer">

																			<button id="resetOK" name="resetOK" type="button" class="btn btn-indigo btn-min-width mr-1 mb-1 btn-lg text-uppercase ">Reset my password</button>




																		</div>
																	</div>
																</div>
															</div>

															<!--end Modal -->
														</form>

													</div>
												</div>
												<!--end login-->



												<br />
												<div class="card border-indigo border-lighten-4">

													<div class="card-body text-center" style="padding: 40px;">
														<button id="ReAccount" type="button" class="btn btn-indigo btn-min-width mr-1 mb-1 btn-lg text-uppercase font-medium-3">Register an account</button>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="copyrightText text-center">Copyright&copy; 2021-2022 MiTAC Computing Technology Corporation (MiTAC Group). All Rights Reserved. <br />Please use the latest version of Firefox or Chrome to view this site.<br />
										<a href="https://www.tyan.com/EN/legal/terms_of_use/" target="tos" />Terms of Use</a>&nbsp;·&nbsp;
										<a href="https://www.tyan.com/EN/legal/privacy_policy/" target="tos" />Privacy Policy</a>&nbsp;·&nbsp;
										<a href="https://www.tyan.com/EN/legal/cookie_policy/" target="tos" />Cookie Policy</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->

<!-- BEGIN VENDOR JS-->
<script src="app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<script src="app-assets/vendors/js/ui/jquery.sticky.js"></script>
<script src="app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
<script src="app-assets/vendors/js/ui/headroom.min.js"></script>
<script src="app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
<script src="app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="app-assets/js/core/app-menu.js"></script>
<script src="app-assets/js/core/app.js"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="app-assets/js/scripts/ui/breadcrumbs-with-stats.js"></script>
<script src="app-assets/js/scripts/forms/form-login-register.js"></script>
<script src="app-assets/js/scripts/forms/select/form-select2.js"></script>
<!-- END PAGE LEVEL JS-->

<script type="text/javascript">
$("#PNlogin").click(function(){
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
	if($("#checknum1").val()==""){
		$("#err_Email").hide();
		$("#err_Password").hide();
		$("#err_captacha").show();
		exit;
	}
	var acc_mail=document.getElementById("acc_mail").value;
	var password=document.getElementById("password").value;
	var RFQ_SKU=document.getElementById("Quote").value;
	var Qnum=document.getElementById("QuoteQty").value;
	var checknum1=document.getElementById("checknum1").value;
	var tmp="login";
  var kind="RFQ";
	var url="loginProcessFor";
	$.ajax({
		type: "post",
		url: url,
		dataType: "html",
		data: {
			acc_mail : acc_mail,
			password : password,
			tmp : tmp,
			RFQ_SKU : RFQ_SKU,
			Qnum : Qnum,
			checknum1 : checknum1,
			kind : kind
		},
		success: function(message){
			if(message == "success"){
				location="https://www.tyan.com/RFQprocess@done";
			}else if(message == "errMsg"){
				$("#err_Email").show();
			}else if(message == "errPW"){
				$("#err_Password").show();
			}else if(message == "captacha"){
				$("#err_captacha").show();
			}else{
				alert(message);
			}
		}
	});
})

//captcha
$(function(){
    $("#refresh").click(function() { 
    	var obj = document.getElementById("captcha");
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

$(function(){
    $("#resetOK").click(function() { 
       if($("#re_mail").val()!=""){
				var search_str = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
				var mail_val = $("#re_mail").val();
				if(search_str.test(mail_val)){
					$("#reset_err").hide();
				}else{
					$("#reset_err").show();
					exit;
				}
			}else{
				$("#reset_err").show();
				exit;
			}
			var acc_mail=document.getElementById("re_mail").value;
			var kind="reset";
			var url="loginProcessFor";
			$.ajax({
			type: "post",
			url: url,
			dataType: "html",
			data: {
				acc_mail : acc_mail,
				kind : kind
			},
			success: function(message){
				if(message == "success"){
					$("#reset_done").show();
					//location.reload();
					exit;
				}else{
					$("#reset_err").show();
					exit;
				}
			}
		});
   });
})

$(function(){
	$("#ReAccount").click(function() { 
		var Quote=document.getElementById("Quote").value;
		var QuoteQty=document.getElementById("QuoteQty").value;
		location.href="https://www.mitacmct.com/PartnerZone/FEregister@"+Quote+"@"+QuoteQty;
	});
})
</script>
</body>
</html>
<?php
mysqli_close($link_db);
?>