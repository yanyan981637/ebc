<?php
header("X-Frame-Options: DENY");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://ipc.mitacmdt.com");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

if(strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: /404.htm");
	exit;
}

if(isset($_GET["status"])){
  //$s_cookie="";
}else{
	$s_cookie=$_COOKIE['status'];
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name='author' content='MiTAC Digital Technology'>
<meta name="company" content="MiTAC Digital Technology">
<meta name="description" content="">
<meta property="og:type" content="website" />
<meta property="og:description" content="" />
<meta property="og:title" content="404 | MiTAC Digital Technology" />
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
<link rel="stylesheet" href="css1/stylesheet1.css" type="text/css" /> 

<script src="js1/jquery.js"></script>
<!-- Document Title
============================================= -->
<title>404 | MiTAC Digital Technology</title>

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
			<h1>Page Not Found</h1>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">404</li>
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
						<div class="error404 center">404</div>
					</div>

					<div class="col-lg-6">

						<div class="heading-block text-center text-lg-start border-bottom-0">
							<h4>Ooopps.! The Page you were looking for, couldn't be found.</h4>
							<span>This may be due to an incorrect or nonexistent URL or the page may have been removed or renamed.</span>
						</div>

						<p class="mb-4">&nbsp;</p>

						<div class="center"><a href="/" class="button button-xlarge button-border button-rounded text-end">Return home<i class="icon-circle-arrow-right"></i></a></div>





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

<script src="js1/top.js"></script>
</body>
</html>