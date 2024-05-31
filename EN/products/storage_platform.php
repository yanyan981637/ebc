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


require "../../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase) or die("Could not connect: " . mysqli_error());
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
	<meta name="description" content="MiTAC provides JBOD, JBOF, NVMe-oF JBOF storage choices for data centers and enterprise systems.">
	<meta property="og:type" content="website" />
	<meta property="og:description" content="MiTAC provides JBOD, JBOF, NVMe-oF JBOF storage choices for data centers and enterprise systems." /> 
	<meta property="og:title" content="Storage Platforms | MiTAC Computing Technology" />
    <link rel="shortcut icon" href="/images/ico/favicon.ico">

	<!-- Stylesheets
	============================================= -->
	<link rel="stylesheet" href="/css1/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="/css1/style.css" type="text/css" />
	<link rel="stylesheet" href="/css1/swiper.css" type="text/css" />
	<link rel="stylesheet" href="/css1/dark.css" type="text/css" />
	<link rel="stylesheet" href="/css1/font-icons.css" type="text/css" />
	<link rel="stylesheet" href="/css1/animate.css" type="text/css" />
	<link rel="stylesheet" href="/css1/magnific-popup.css" type="text/css" />
	<link rel="stylesheet" href="/css1/custom.css" type="text/css" />


  <style>

.bg-dark-blue {background-color:#0D47A1; border:1px solid #0D47A1}
.bg-dark-blue h1 {color:#ffffff; padding: 1.6rem 1rem 0rem}


.card-label-cs {
	background-color:#25b8fa;
	opacity: 0.9;
	padding:0.2rem 2rem;
	color:#fff;
	position: absolute;
	top: 2rem;
	left: 12px;
	text-transform: capitalize;
	border-radius: 0px 20px 20px 0px;
	z-index:4;
}

a.more {color:#41b6c7}

.course-card {border: 1px solid rgba(0, 0, 0, 0.125);  border-radius: 0.25rem; margin:2rem 0;  background-color:#ffffff; padding:0}
.lh2{line-height:2.2rem}
.text-black {color:#000000; line-height:1.5rem; text-align:center}


  </style>
	
	<script src="/js1/jquery.js"></script>
	<!-- Document Title
	============================================= -->
	<title>Storage Platforms | MiTAC Computing Technology</title>
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
  include("../../top1.htm");
	?>
	<!--end Header logo & global top menu-->

	


		<!-- Slider
		============================================= -->
		<section id="slider" class="slider-element" style="background: linear-gradient(to right, rgba(0,0,0, 0.8) 20%, transparent 100%), url('/images/product/bg_storage_platform.jpg') no-repeat center center / cover;">

			<div class="container">
				<div class="row justify-content-between align-items-center">
					<div class="col-lg-8 col-md-9 dark mb-5 mb-md-0 py-5" data-animate="backInLeft">
						<h2 class="display-4" style="font-weight: 600;" >Storage Platform</h2>
						<h3 style="color:#41b6c7; font-size:2.5rem">Diverse Storage Choices for Data Centers and Enterprise Systems.</h3>
						
						<p class="mb-5 lead text-white">
						

					
						
						
						MiTAC storage platforms for datacenters and enterprise systems address a 

full spectrum of needs. From attached storage (DAS), storage area networks 

(SAN), and network attached storage (NAS) environments to support for a 

variety of industry storage protocols including Fibre Channel, iSCSI, 

SAS/SATA, NVMe and NVMe over fabric, these platforms ensure that users are 

able to find the right solution.<br><br>
		MiTAC Computing Technology has 40 years of experience serving the unique needs and requirements of ODM manufacturing segments. 
Welcome you to <a href="/EN/contact/" style="color:#41b6c7;">contact us</a> and get more details about our ODM storage solutions.
						</p>
						
						
					</div>
					<div class="col-md-3 d-flex align-items-center col-form">
					
					
					<!--<div class="card  bg-white border-0 w-100 shadow p-3 rounded-0 op-09"  data-animate="backInRight" >
							<div class="card-body">
							
							 
								<h3 class="mb-0 center">
									Products:
								</h3>
								<div class="line line-sm mt-3"></div>
								<ul class="iconlist">
								<li><i class="icon-line-chevrons-right"></i> <a href="/JBODJBOF_TN52J-E3252_J3252T52U24HR-U8DR" target="mit" />TN52J-E3252 (JBOD)</a></li>
								<li><i class="icon-line-chevrons-right"></i> <a href="/EN/contact/" target="mit" />PM4233L (JBOD)</a></li>
								<li><i class="icon-line-chevrons-right"></i> <a href="/EN/contact/" target="mit" />FR2223 (JBOF)</a></li>
								<li><i class="icon-line-chevrons-right"></i> <a href="/EN/contact/" target="mit" />HT2221F (NVMe-oF JBOF)</a></li>
								</ul>
								
								
							</div>
						</div>-->
						
					</div>
				</div>
			</div>
		</section>

























































		<!-- FOOTER -->	  
	  <?php
    include("../../foot1.htm");
	  ?>
	  <!-- FOOTER end -->	  

	</div><!-- #wrapper end -->

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-line-arrow-up"></div>

	<!-- JavaScripts
	============================================= -->
	
	<script src="/js1/plugins.min.js"></script>

	<!-- Footer Scripts
	============================================= -->
	<script src="/js1/functions.js"></script>

	<!-- ADD-ONS JS FILES -->
	
	<script src="/js1/top.js"></script>
</body>
</html>