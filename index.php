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

require "./config.php";
ini_set("error_reporting","E_ALL & ~E_NOTICE");
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');

if($_COOKIE["status"]==""){
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
	<meta name='author' content='MiTAC Computing Technology'>
	<meta name="company" content="MiTAC Computing Technology">
	<meta name="description" content="Industry leader of embedded, panel PC, kiosks, motherboards, OCP for 5G, edge computing, AI, automation solutions">
	<meta property="og:type" content="website" />
	<meta property="og:description" content="Industry leader of embedded, panel PC, kiosks, motherboards, OCP for 5G, edge computing, AI, automation solutions" /> 
	<meta property="og:title" content="MiTAC Computing Technology | 5G, OCP, panel PC, embedded motherboards" />
	<meta name="google-site-verification" content="eQiyhhgLcF1f4G-nh1RdOZz8egds53Ztgk-hbW_JsEY" />
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
	<title>MiTAC Computing Technology | 5G, OCP, panel PC, embedded motherboards</title>

	<?php 
	//************ google analytics ************
	if($s_cookie!=2){
	  include_once("analyticstracking.php");
	}
	?>

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

	<!-- middles1 -->	  
	<?php
  include("middles1.htm");
	?>
	<!-- middles1 end -->	  
	
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