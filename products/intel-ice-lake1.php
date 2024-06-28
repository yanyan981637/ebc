<?php
header("X-Frame-Options: DENY");
//header("Content-Security-Policy-Report-Only: default-src *; img-src https:; frame-src 'none'; report-uri http://www.tyan.com");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://ipc.mitacmdt.com");
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
	<meta name='author' content='MiTAC Digital Technology'>
	<meta name="company" content="MiTAC Digital Technology">
	<meta name="description" content="MiTAC's 3rd Gen Intel Xeon Scalable platforms deliver high performance for AI and 5G applications.">
	<meta property="og:type" content="website" />
	<meta property="og:description" content="MiTAC's 3rd Gen Intel Xeon Scalable platforms deliver high performance for AI and 5G applications." />
	<meta property="og:title" content="Intel Ice Lake 5G Edge Computing Platforms | MiTAC Digital Technology" />
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
	<title>Intel Ice Lake 5G Edge Computing Platforms | MiTAC Digital Technology</title>

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
		<section id="slider" class="slider-element" style="background: linear-gradient(to right, rgba(0,0,0, 0.8) 20%, transparent 100%), url('/EN/solution/images/ice-lake-main.jpg') no-repeat center center / cover;">

			<div class="container">
				<div class="row justify-content-between align-items-center">
					<div class="col-lg-8 col-md-9 dark mb-5 mb-md-0 py-5" data-animate="backInLeft">
						<h2 class="display-4" style="font-weight: 600;" >3<sup>rd</sup> Gen Intel<sup>®</sup> Xeon<sup>®</sup> Scalable Processors <span style="font-size:2rem; color:#fff; font-weight:normal">(Ice Lake / ICX / Whitley)</span></h2>
						<h3 style="color:#41b6c7; font-size:2.5rem">MiTAC 5G Edge Computing Platforms</h3>
						<h4 style="font-weight:300; font-size:2rem">Aowanda Family - MEC, CU & DU All in One</h4>
						<p class="mb-5 lead text-white">
						3<sup>rd</sup> Gen Intel<sup>®</sup> Xeon<sup>®</sup> Scalable processors provide an  advanced security capabilities, optimized for the most demanding workload requirements, including databases, HPC, hypervisors, AI and 5G applications. With supporting 3<sup>rd</sup> Gen Intel<sup>®</sup> Xeon<sup>®</sup> Scalable processors , MiTAC 5G edge computing platforms deliver higher performance on a range of broadly-deployed network and 5G workloads to shortened time-to-deployment for RANs, NFVI, CDN and more. <br /><br />


	More info for <a href="/products/5G_edge_computing_platform" class="more" />MiTAC 5G edge computing platforms</a> and <a href="/EN/solution/5G_edge_computing_solution" class="more" />solutions</a>!

						</p>


					</div>
					<div class="col-md-3 d-flex align-items-center col-form">


					<div class="card  bg-white border-0 w-100 shadow p-3 rounded-0"  data-animate="backInRight" >
							<div class="card-body">
							 <div class="center mb-5"><img src="/EN/solution/images/intel-ice-lake-logo.jpg" /></div>

								<h3 class="mb-0 center">
									Product:
								</h3>
								<div class="line line-sm mt-3"></div>
								<ul class="iconlist">
								<li><i class="icon-line-chevrons-right"></i> <a href="/5GEdgeComputing_AD211_AD1S01"  />AD211 (2U3N)</a></li>
								</ul>


							</div>
						</div>

					</div>
				</div>
			</div>
		</section>














	<div class="container-fluid m-0 bg-dark-blue">
	<h1 class="center">Aowanda Family - MEC, CU & DU All in One</h1>
	</div>


<div class="container-fluid m-0 border-0" style="padding: 80px 0">
<div class="container  clearfix">
<div class="row">
<div class="col-lg-6">
 <h1 >AD211</h1>
  <h2 style="font-weight:300; color:#454545">2U3nodes Single Socket Edge Server</h2>
  <h3><a href="/5GEdgeComputing_AD211_AD1S01"  />AD1S01</a> / <a href="/5GEdgeComputing_AD211_AD1S02"  />AD1S02</a></h3>
		<ul class="leftmargin-sm">
<li>Network Rack Cabinet Compliable</li>
<li>Open Edge Compliable</li>
<li>Enhance Power Efficiency through centralized Power Supply design</li>
<li>RMC design for Centralize Server Management</li>
<li>NEBS Compliance</li>

</ul>	<p class="mt-1 mb-1">

<a href="/5GEdgeComputing_AD211_AD1S01" class="button button-xlarge button-border button-rounded text-end">View SPEC<i class="icon-circle-arrow-right"></i></a>
</p>

</div>
<div class="col-lg-6">
<a href="/5GEdgeComputing_AD211_AD1S01"  /><img src="/EN/solution/images/AD211.jpg" class="img-fluid" /></a>
<div ><img src="/images/logo/Xeon_Processor_Scalable_Family.jpg" > <img src="/images/logo/redfish.gif" ></div>
</div>


</div><p class="mb-5">&nbsp;</p>
</div>
</div>








	<div class="container-fluid m-0 bg-dark-blue">
	<h1 class="center">Powered by AMI TruE™ Trusted Environment Platform Security Solution</h1>
	</div>

<div class="container-fluid m-0 border-0" style="padding: 80px 0">
<div class="container  clearfix">
<div class="row">
<div class="col-lg-6 ">

 <h1 class="mt-5">Aowanda Edge Server - AD211</h1>
  <h2 style="font-weight:300; color:#454545">Enabling 5G Cybersecurity </h2>
  AMI and MiTAC are collaborators of the NIST® National Cybersecurity Center of Excellence (NCCoE) 5G Cybersecurity. In collaboration with AMI and NCCoE 5G teams, the Aowanda AD211 with support for 3rd Gen Intel® Xeon® Scalable processors delivers a true trusted 5G and edge computing environment.
			<p class="mt-5 mb-1">
			<a href="/en-US@Aowanda_AD211_Edge_Server_to_Add_AMI_TruE_for_5G_Cybersecurity~PRDetail" class="button button-xlarge button-border button-rounded text-end">View Press Release<i class="icon-circle-arrow-right"></i></a>
			</p>



</div>
<div class="col-lg-6">
<a href="/en-US@Aowanda_AD211_Edge_Server_to_Add_AMI_TruE_for_5G_Cybersecurity~PRDetail" target="mtc"  /><img src="/images/pressroom_pic/PR-AD211-AMI-TruE.jpg" class="img-fluid" /></a>
</div>


</div>

<p class="mb-5">&nbsp;</p>
</div>
</div>
































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