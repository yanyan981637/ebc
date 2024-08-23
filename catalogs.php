<?php
header("X-Frame-Options: DENY");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://ipc.mitacmdt.com");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
if (strpos(trim(getenv('REQUEST_URI')), "script") != '' || strpos(trim(getenv('REQUEST_URI')), ".php") != '') {
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: /404.htm");
	exit;
}
if (isset($_GET["status"])) {
	//$s_cookie="";
} else {
	$s_cookie = $_COOKIE['status'];
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
	<meta property="og:title" content="Download Catalogs | MiTAC Digital Technology" />
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
	<title>Download Catalogs | MiTAC Digital Technology</title>
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
				<h1>Catalogs</h1>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="/">Home</a></li>
					<li class="breadcrumb-item active" aria-current="page">Catalogs</li>
				</ol>
			</div>
		</section><!-- #page-title end -->
		<!-- Content
	============================================= -->
		<section id="content">
			<div class="content-wrap py-0">
				<!--embedded-->
				<div class="section border-top-0 m-1" style="background-color:#ffffff">
					<div class="container clearfix">
						<h2>Embedded:</h2>
						<div class="row justify-content-center col-mb-50">
							<div class="col-sm-6 col-md-4 col-lg-4">
								<a href="https://dl-mio.akamaized.net/ebc/product-info/File/2024-Edge%20AI_DM.pdf" target="_blank"><img src="/images/catalog/Edge-AI-Catalog-2023-cover.jpg" class="img-fluid"></a><br>
								<h5>Edge AI Catalog</h5>
							</div>
							<div class="col-sm-6 col-md-4 col-lg-4">
								<a href="https://download.mitacmct.com/Files/Catalog/MiTAC-embedded-catalog-2023-s.pdf" target="_blank"><img src="/images/catalog/Embedded_Catalog_Cover.jpg" class="img-fluid"></a><br>
								<h5>Embedded Catalog</h5>
							</div>
							<div class="col-sm-6 col-md-4 col-lg-4">
								<a href="https://download.mitacmct.com/Files/Catalog/Whitepaper-Edge_AI_in_Factory_automation_2022.pdf" target="_blank"><img src="/images/catalog/whitepaper-2022-edge-ai-cover.jpg" class="img-fluid"></a>
								<h5>Embedded White Paper</h5>
							</div>
						</div>
					</div>
				</div>
				<!--end embedded-->
				<!--5GOCP-->
				<!-- <div class="section border-top-0 m-1" style="background-color:#f5f9fd">
					<div class="container clearfix">
						<h2>5G & OCP:</h2>
						<div class="row col-mb-50">
							<div class="col-sm-6 col-md-4 col-lg-4">
								<a href="https://download.mitacmct.com/Files/Catalog/5G_Edge_OCP_Cloud_DM.pdf" target="_blank"><img src="/images/catalog/OCP_5G_DM_cover.jpg" class="img-fluid"></a>
								<h5>5G Edge & OCP Cloud</h5>
							</div>
							<div class="col-sm-6 col-md-4 col-lg-4">
							</div>
							<div class="col-sm-6 col-md-4 col-lg-4">
							</div>
						</div>
					</div>
				</div> -->
				<!--end 5GOCP-->
				<!--Tyan-->
				<!-- <div class="section border-top-0 m-1" style="background-color:#ffffff">
					<div class="container clearfix">
						<h2>TYAN Server:</h2>
						<div class="row justify-content-center col-mb-50">
							<div class="col-sm-6 col-md-4 col-lg-4">
								<a href="https://ftp1.tyan.com/pub/catalog/2023Q2_AMD_catalog.pdf" target="_blank"><img src="https://www.tyan.com/EN/img/catalog/2023Q2_AMD_catalog-cover.jpg" class="img-fluid"></a><br>
								<h5>AMD EPYC™ 9004 Series Processors</h5>
							</div>
							<div class="col-sm-6 col-md-4 col-lg-4">
								<a href="https://ftp1.tyan.com/pub/catalog/2023Q2_Intel_catalog.pdf" target="_blank"><img src="https://www.tyan.com/EN/img/catalog/2023Q2_Intel_catalog-cover.jpg" class="img-fluid"></a>
								<h5>4th Gen Intel® Xeon® Scalable Processors</h5>
							</div>
							<div class="col-sm-6 col-md-4 col-lg-4">
							</div>
						</div>
					</div>
				</div> -->
				<!--end Tyan-->
			</div>
		</section>
		<!-- #content end -->
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