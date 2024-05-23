<?php
header("X-Frame-Options: DENY");
//header("Content-Security-Policy-Report-Only: default-src *; img-src https:; frame-src 'none'; report-uri http://www.tyan.com");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://www.mitacmct.com");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

if(strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
header("HTTP/1.1 301 Moved Permanently");
header("Location: /404.htm");
exit;
}

error_reporting(0);

require "./config.php";
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");


if(isset($_COOKIE['status'])){
  //$s_cookie="";
}else{
  $s_cookie=$_COOKIE['status'];
}

//********2018.03.26 判斷時間on/offline end***************
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name='author' content='MiTAC Computing Technology'>
	<meta name="company" content="MiTAC Computing Technology">
	<meta name="description" content="">
	<meta property="og:type" content="website" />
	<meta property="og:description" content="" /> 
	<meta property="og:title" content="404 | MiTAC Computing Technology" />
	<link rel="shortcut icon" href="images/ico/favicon.ico">

	<!-- Stylesheets
	============================================= -->
	<link rel="stylesheet" href="css1/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="css1/style.css" type="text/css" />
	<link rel="stylesheet" href="css1/swiper.css" type="text/css" />
	<link rel="stylesheet" href="css1/dark.css" type="text/css" />
	<link rel="stylesheet" href="css1/font-icons.css" type="text/css" />
	<link rel="stylesheet" href="css1/animate.css" type="text/css" />
	<link rel="stylesheet" href="css1/magnific-popup.css" type="text/css" />
	<link rel="stylesheet" href="css1/custom.css" type="text/css" />
	<link rel="stylesheet" href="css1/home.css " type="text/css" />
	
	<script src="js1/jquery.js"></script>
	<!-- Document Title
	============================================= -->
	<title>MiTAC Computing Technology</title>

</head>

<body class="stretched">

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">


	<!--Header logo & global top menu-->
	<?php
	include("top1.htm");
	?>
	<!--end Header logo & global top menu-->








	<!-- Page Title
	============================================= -->
	<section id="page-title">

		<div class="container clearfix">
			<h1>Subscribe Newsletter</h1>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Newsletter Subscription</li>
			</ol>
		</div>

	</section><!-- #page-title end -->

	<!-- Content
	============================================= -->
	<section id="content">
		<div class="content-wrap">
			<div class="container clearfix">

				<div class="row align-items-center col-mb-80">

					

					<div class="col-lg-6">

						<div class="heading-block text-center text-lg-start border-bottom-0">
							<h4>Want to get the latest updates? </h4>
							<span>Enter your e-mail to subscribe MCT newsletter!</span>
						</div>
						
						
						
						<form id="widget-subscribe-form" action="include/subscribe.php" method="post" class="mb-0">
							<div class="input-group mx-auto">
								<div class="input-group-text bg-transparent"><i class="icon-email2" ></i></div>
								<input id="mail" type="email" id="widget-subscribe-form-email" name="widget-subscribe-form-email" class="form-control required email" placeholder="Enter your Email">

								<div class="btn-group">
									<select id="sel_sub" class="form-control">
										<option selected value="subscribe">Subscribe</option>
										<option value="unsubscribe">Unsubscribe</option>
									</select>
								</div>
								<button id="MVaBtn" class="button button-large button-circle button-blue nott ls0 m-0" type="button">OK</button>
							</div>
						</form>
						<p class="mb-1">&nbsp;</p>
						<div class="alert alert-success" id="sucss_msg" style="display:none">Thank you for your subscription.</div>
						<div class="alert alert-danger" id="exist_msg" style="display:none">Existed email or invalid e-mail!</div>
						<div class="alert alert-success" id="delete_msg" style="display:none">Successful unsubscription.</div>
						<div class="alert alert-danger" id="err_msg" style="display:none">Email doesn’t exist.</div>



						

					</div>
					
					<div class="col-lg-6">
						<div class="error404 center"><i class="icon-newspaper"></i></div>
					</div>
					

				</div>

			</div>
		</div>
	</section><!-- #content end -->

	<!-- FOOTER -->	  
	<?php
	include("foot1.htm");
	?>
	<!-- FOOTER end -->	  

</div><!-- #wrapper end -->

<!-- Go To Top
============================================= -->
<div id="gotoTop" class="icon-line-arrow-up"></div>

<!-- JavaScripts
============================================= -->

<script src="js1/plugins.min.js"></script>

<!-- Footer Scripts
============================================= -->
<script src="js1/functions.js"></script>

<!-- ADD-ONS JS FILES -->

<script src="/js1/top.js"></script>
<script type="text/javascript">
$(function(){
	$("#MVaBtn").click(function() {
		var search_str = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
		var mail_val = $("#mail").val();
		var subscribe = $("#sel_sub").val();
		if(search_str.test(mail_val)){
			if(subscribe=="subscribe"){
				var url = "/subscription";
			}else{
				var url = "/delsubscription";
			}
			var mail = $("#mail").val();
			var fd = new FormData();
			fd.append("mail", mail);
			
			$.ajax({
				type: "post",
				url: url,
				dataType: "html",
				data: fd,
				cache: false,
				contentType: false,
				processData: false,  

				success: function(data){
					if(data == "refresh"){
				    	$("#sucss_msg").show();
				    	$("#delete_msg").hide();
				    	$("#exist_msg").hide();
				    	$("#err_msg").hide();
				    	$("#mail").val('');
				    }else if(data == "delete"){
				    	$("#sucss_msg").hide();
				    	$("#delete_msg").show();
				    	$("#exist_msg").hide();
				    	$("#err_msg").hide();
				    	$("#mail").val('');
				    }else{
				    	$("#sucss_msg").hide();
				    	$("#delete_msg").hide();
				    	$("#exist_msg").show();
				    	$("#err_msg").hide();
				    	$("#mail").val('');
				    }
				}  
				});  
							/* End */
		}else{
			//alert("mail format is incorrect!");
			$("#sucss_msg").hide();
			$("#delete_msg").hide();
			$("#exist_msg").hide();
			$("#err_msg").show();
			$("#mail").val('');
		}

	});  
});
</script>
</body>
</html>