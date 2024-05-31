<?php
header("X-Frame-Options: DENY");
//header("Content-Security-Policy-Report-Only: default-src *; img-src https:; frame-src 'none'; report-uri http://www.tyan.com");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://www.mitacmct.com");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

/*if(strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
header("HTTP/1.1 301 Moved Permanently");
header("Location: /404.htm");
exit;
}*/


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

</head>

<body class="stretched">

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">


	<!--Header logo & global top menu-->
	<?php
  include("../top1.htm");
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

able to find the right solution.
	
						</p>
						
						
					</div>
					<div class="col-md-3 d-flex align-items-center col-form">
					
					
					<div class="card  bg-white border-0 w-100 shadow p-3 rounded-0"  data-animate="backInRight" >
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
						</div>
						
					</div>
				</div>
			</div>
		</section>














	<div class="container-fluid m-0 bg-dark-blue">
	<h1 class="center">JBOD</h1>	
	</div>

<div class="container-fluid m-0 border-0" style="padding: 80px 0">
					<div class="container  clearfix">
<div class="row">
<div class="col-lg-1"></div>
<div class="col-lg-10">
<div class="row">
<div class="col-lg-4">
 <div class="course-card p-4 h-100">
									<a href="/JBODJBOF_TN52J-E3252_J3252T52U24HR-U8DR" target="mit" /><img class="card-img-top" src="/images/product/JBODJBOF/TN52JE3252.jpg" alt="TN52J-E3252"></a>
									<div class="card-body">
									<h2 class="card-title fw-normal mb-2 center lh2" ><a href="/JBODJBOF_TN52J-E3252_J3252T52U24HR-U8DR" target="mit" />TN52J-E3252</a></h2>
										<h5 class="center">(24) 2.5" SAS 12G JBOD</h5>
									</div>
</div>
</div>
<div class="col-lg-4">
 <div class="course-card p-4 h-100"><div class="card-label-cs">Coming Soon!</div>
									<a href="/EN/contact/" target="mit" /><img class="card-img-top" src="/images/product/JBODJBOF/PM4233L.jpg" alt="PM4233L"></a>
									<div class="card-body">
									<h2 class="card-title fw-normal mb-2 center lh2" ><a href="/EN/contact/" target="mit" />PM4233L</a></h2>
										<h5 class="center"><span style="font-size:1.2rem; font-weight:300">4U 24x 3.5" SAS4 JBOD</span><br />High Availability<br />Design in Broadcom  SAS4 expender</h5>
									</div>
	</div>


</div>
<div class="col-lg-4">

</div>
</div>
</div>
<div class="col-lg-1"></div>
	
</div>
</div>
</div>







	<div class="container-fluid m-0 bg-dark-blue">
	<h1 class="center">JBOF</h1>	
	</div>

<div class="container-fluid m-0 border-0" style="padding: 80px 0">
					<div class="container  clearfix">
<div class="row">
<div class="col-lg-1"></div>
<div class="col-lg-10">
<div class="row">
<div class="col-lg-4">
 <div class="course-card p-4"><div class="card-label-cs">Coming Soon!</div>
									<a href="/EN/contact/" target="mit" /><img class="card-img-top" src="/images/product/JBODJBOF/FR2223.jpg" alt="FR2223"></a>
									<div class="card-body">
									<h2 class="card-title fw-normal mb-2 center lh2" ><a href="/EN/contact/" target="mit" />FR2223</a></h2>
										<h5 class="center"><span style="font-size:1.2rem; font-weight:300">2U 24 x 2.5" PCIE G4 NVMe SSD JBOF</span><br />
High Availability<br />
Design in Broadcom PCIe G4 Switch</h5>
									</div>
</div>
</div>
<div class="col-lg-4">

</div>
<div class="col-lg-4">

</div>
</div>
</div>
<div class="col-lg-1"></div>
	
</div>
</div>
</div>




	<div class="container-fluid m-0 bg-dark-blue">
	<h1 class="center">NVMe over Fabrics JBOF</h1>	
	</div>

<div class="container-fluid m-0 border-0" style="padding: 80px 0">
					<div class="container  clearfix">
<div class="row">
<div class="col-lg-1"></div>
<div class="col-lg-10">
<div class="row">
<div class="col-lg-4">
 <div class="course-card p-4"><div class="card-label-cs">Coming Soon!</div>
									<a href="/EN/contact/" target="mit" /><img class="card-img-top" src="/images/product/JBODJBOF/HT2221F.jpg" alt="HT2221F"></a>
									<div class="card-body">
									<h2 class="card-title fw-normal mb-2 center lh2" ><a href="/EN/contact/" target="mit" />HT2221F</a></h2>
										<h5 class="center"><span style="font-size:1.2rem; font-weight:300">2U 24 x 2.5" NVMe over Fabrics PCIE G3 JBOF</span><br />
High Availability, 7.5M IOPS<br />
Design in Mellanox BlueField Solution</h5>
									</div>
</div>
</div>
<div class="col-lg-4">

</div>
<div class="col-lg-4">

</div>
</div>
</div>
<div class="col-lg-1"></div>
	
</div>
</div>
</div>

























<p class="mb-5">&nbsp;</p>






























		<!-- FOOTER -->	  
	  <?php
    include("../foot1.htm");
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