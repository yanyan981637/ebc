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
	<meta name="description" content="MiTAC's OCP SEBA Solution with more power savings, less costs, and quick adoption from edge to cloud computing applications">
	<meta property="og:type" content="website" />
	<meta property="og:description" content="MiTAC's OCP SEBA Solution with more power savings, less costs, and quick adoption from edge to cloud computing applications" /> 
	<meta property="og:title" content="OCP SEBA Solution | MiTAC Computing Technology" />
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



.course-card {border: 1px solid rgba(0, 0, 0, 0.125);  border-radius: 0.25rem; margin:2rem 0;  background-color:#ffffff; padding:0}
.lh2{line-height:2.2rem}
.text-black {color:#000000; line-height:1.5rem; text-align:center}


  </style>
	
	<script src="/js1/jquery.js"></script>
	<!-- Document Title
	============================================= -->
	<title>OCP SEBA Solution | MiTAC Computing Technology</title>
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
		<section id="slider" class="slider-element" style="background: linear-gradient(to right, rgba(0,0,0, 0.5) 20%, transparent 100%), url('/images/product/bg_OCP-SEBA.jpg') no-repeat center center / cover;">

			<div class="container">
				<div class="row justify-content-between align-items-center">
					<div class="col-lg-8 col-md-9 dark mb-5 mb-md-0 py-5" data-animate="backInLeft">
						<h2 class="display-4" style="font-weight: 600;" >OCP - SEBA™ Solution</h2>
						
						<h3 style="color:#07d8f7; font-size:2rem; font-weight:300">From Edge to Cloud New Generation Central Office with OCP Solutions</h3>
						<h3>Toward the Next Generation Central Office</h3>
						<p class="mb-5 lead text-white">
						
						
						Telecom operators manage thousands of central offices, but
are locked by legacy hardware and high costs. <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="CORD : Central Office Re-architected as Datacenter. CORD enables the economies of a data center and the flexibility of SDN by applying Cloud-Native Infrastructure to Central
Office with white box solutions." style="color:#07d8f7" />CORD</a> ,
combines SDN, NFV, commodity hardware and cloud
services to create more efficient, agile networks at the edge.
The edge affords an opportunity to customize the network
and services for individual customer segments.<br /><br />
As network functions virtualization (NFV) has gained more
success over the past years, telecom operators are adopting
the idea of disaggregating application and function from the
proprietary hardware platforms used to run telecom
applications in favor of commercial off-the-shelf (COTS)
hardware deployed as a cloud infrastructure.
						

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
								<li><i class="icon-line-chevrons-right"></i> <a href="/OCPMezz_ML41202-P_ML41202-P" target="mit" />OCP Mezzanine</a></li>
								<li><i class="icon-line-chevrons-right"></i> <a href="/OCPserver_E7278_E7278-S" target="mit" />OCP Compute Node</a></li>
								<li><i class="icon-line-chevrons-right"></i> <a href="/OCPRack_ESA_ESA" target="mit" />OCP ESA Kit</a></li>
								<li><i class="icon-line-chevrons-right"></i> <a href="/EN/contact/" target="mit" />OCP JBOF</a></li>
								</ul>
								
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>



<div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#ffffff;">
<div class="container  clearfix">

<div class="row">
<div class="col-lg-6"><img src="/images/product/OCPserver/OCP_SEBA-1.gif" alt="OCP SEBA Solution" class="img-fluid"></div>
<div class="col-lg-6"><img src="/images/product/OCPserver/OCP_SEBA-2.jpg" alt="OCP SEBA Solution" class="img-fluid"></div>
</div>

</div>
</div>






	<div class="container-fluid m-0 bg-dark-blue">
	<h1 class="center">OCP - SEBA&#8482; Solution</h1>	
	</div>


<div class="container-fluid m-0 border-0" style="padding: 80px 0">


<div class="container  clearfix">

<div class="row">
<div class="col-lg-5"><a href="/products/OCP" /><img src="/images/product/OCPserver/OCP_SEBA-5.jpg" alt="OCP SEBA Solution" class="img-fluid mt-6"></a></div>
<div class="col-lg-7">

<div class="row">
<div class="col-lg-6 center">
<div><a href="/OCPMezz_ML41202-P_ML41202-P" /><img src="/images/product/OCPserver/OCP_SEBA-6.jpg" alt="OCP SEBA Solution" class="img-fluid"></a></div>
<h4 style="margin:2% 0">OCP Mezzanine</h4>
</div>
<div class="col-lg-6 center">
<div><a href="/OCPserver_E7278_E7278-S" /><img src="/images/product/OCPserver/OCP_SEBA-7.jpg" alt="OCP SEBA Solution" class="img-fluid"></a></div>
<h4 style="margin:2% 0">OCP Compute Node</h4>
</div>
</div>
<p class="mb-4">&nbsp;</p>

<div class="row">
<div class="col-lg-6 center">
<div><a href="/OCPRack_ESA_ESA" /><img src="/images/product/OCPserver/OCP_SEBA-8.jpg" alt="OCP SEBA Solution" class="img-fluid"></a></div>
<h4 style="margin:2% 0">OCP ESA Kit</h4>
</div>
<div class="col-lg-6 center">
<div><img src="/images/product/OCPserver/OCP_SEBA-9.jpg" alt="OCP SEBA Solution" class="img-fluid"></div>
<h4 style="margin:2% 0">OCP JBOF</h4>
</div>
</div>
<p class="mb-4">&nbsp;</p>
<div class="row">
<div class="col-lg-12 center"><a href="/products/OCP" /><img src="/images/product/OCPserver/OCP_SEBA-10.gif" alt="OCP SEBA Solution" class="img-fluid"></a></div>
</div>

</div>
</div>


</div>
</div>




<div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#7bad2d;">
<div class="container  clearfix">


<div class="row">
<div class="col-lg-1"></div>
<div class="col-lg-2 center ">
<div><img src="/images/product/OCPserver/OCP_SEBA-icon1.gif" alt="OCP SEBA Solution" class="img-fluid"></div>
<h4 class="text-white">33%+ More Power Savings</h4>
</div>
<div class="col-lg-2 center">
<div><img src="/images/product/OCPserver/OCP_SEBA-icon2.gif" alt="OCP SEBA Solution" class="img-fluid"></div>
<h4 class="text-white">Less Expenditure</h4>
</div>
<div class="col-lg-2 center">
<div><img src="/images/product/OCPserver/OCP_SEBA-icon3.gif" alt="OCP SEBA Solution" class="img-fluid"></div>
<h4 class="text-white">Quick Adoption</h4>
</div>
<div class="col-lg-2 center">
<div><img src="/images/product/OCPserver/OCP_SEBA-icon4.gif" alt="OCP SEBA Solution" class="img-fluid"></div>
<h4 class="text-white">Interchangeable</h4>
</div>
<div class="col-lg-2 center">
<div><img src="/images/product/OCPserver/OCP_SEBA-icon5.gif" alt="OCP SEBA Solution" class="img-fluid"></div>
<h4 class="text-white">Vendor Lock-in Free</h4>
</div>
<div class="col-lg-1"></div>	
	</div>


</div>
</div>





<div class="container-fluid m-0 border-0" style="padding: 80px 0">
<div class="container  clearfix">
<div class="row">
<div class="col-lg-1"></div>
<div class="col-lg-5">
<div class="card h-100">
								<div class="card-body">
								<div class="heading-block center">
											  <h1>Partnership</h1>
								</div>
								</div>
								<div class="card-body">	
								<div class="row">
<div class="col-md-4 p-3"><img src="/images/product/OCPserver/OCP_logo-2.gif" alt="OCP SEBA Solution"></div>
<div class="col-md-8"><p class="card-text p-3">MiTAC and Edgecore are both Platinum
Members of OCP. (Edgecore is also the
board partner member of ONF.)
MiTAC and Edgecore have collaborated
and joined <span style="font-weight:700; color:#7bad2d">provide the world's first OCP
<a href="https://www.opennetworking.org/seba/" target="SEBA" data-toggle="tooltip" title="SEBA : SDN-Enabled Broadband Access. SEBA is a lightweight platform of R-CORD (Residential CORD includes services that leverage wireline access technologies). It supports a multitude of virtualized access technologies at the edge of the carrier network. SEBA supports both residential access and wireless with white box equipment including OLT, and switches and servers for the SDN broadband access." />SEBA&#8482;</a> POD solution in 2019</span>.</p>
</div>
</div>
								</div>
</div>

</div>
<div class="col-lg-5">
<div class="card h-100">
								<div class="card-body">
								<div class="heading-block center">
											  <h1>SEBA&#8482; Recommended Hardware</h1>
								</div>
								</div>
								<div class="card-body">
									<p class="card-text p-3">MiTAC's Tioga Pass is a <a href="https://www.opennetworking.org/seba/" target="SEBA" />SEBA&#8482;</a> validated server; together
with our OCP ESA kit in the OCP <a href="https://www.opennetworking.org/seba/" target="SEBA" />SEBA&#8482;</a> POD, it helps
telecom carriers adopt OCP solutions supporting their
service in a central office as a cloud native infrastructure
with optimized power efficiency.</p>
									
								</div>
</div>

</div>
<div class="col-lg-1"></div>
</div>

<p class="mb-6">&nbsp;</p>
<div class="center"><img src="/images/product/OCPserver/OCP_SEBA-4.jpg" alt="OCP SEBA Solution" class="img-fluid"></div>


<p class="mb-2">&nbsp;</p>
</div>
</div>


























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