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
	<meta name="description" content="MiTAC's Intelligent Transportation System includes surveillance, fleet management system, control / passenger information system, signage, self-service system, intelligent locker system, automated ticketing system">
	<meta property="og:type" content="website" />
	<meta property="og:description" content="MiTAC's Intelligent Transportation System includes surveillance, fleet management system, control / passenger information system, signage, self-service system, intelligent locker system, automated ticketing system" />
	<meta property="og:title" content="Intelligent Transportation System | MiTAC Computing Technology" />
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
	<link rel="stylesheet" href="/css1/kiosks.css" type="text/css" />

  <style>


.card-solution {margin-top:3rem; margin-right:-10px; border-radius:0px; background-color: rgba(0, 66, 138, 0.8); color:#00428a; box-shadow:  10px 10px 20px rgba(104, 104, 104, 0.5),
-10px -10px 20px rgba(0, 0, 0, 0.5); color:#ffffff; padding: 2rem 1.5rem;}
.card-solution a{color:#ffffff}
.card-solution a:hover {color:#479cf9}



.course-card {border: 1px solid rgba(0, 0, 0, 0.125);  border-radius: 0.25rem; margin:2rem 0;  background-color:#ffffff; padding:0}


.heading-block::after {border-top: 2px solid #a1a1a1;}
.h4-1{border-bottom:2px solid #dcdcdc; line-height:200%; font-weight:600}

.bg-dark-blue {background-color:#0D47A1; border:1px solid #0D47A1}
.bg-dark-blue h1 {color:#ffffff; padding: 1.6rem 1rem 0rem}
.white {color:#ffffff}


.title-1 h2 {font-weight: 300; line-height:2rem; letter-spacing: 2px !important; color:#626262; display: inline; }


:root {
	--color1: #08c5db;
	--color2: #3966c7;
	--color3: #167ff5;
}

.gradient-underline {

	background-image: -webkit-linear-gradient( 280deg, var(--color1) 12.08%, var(--color2) 53.53%, var(--color3) 95.62% );
	background-image: -o-linear-gradient( 280deg, var(--color1) 12.08%, var(--color2) 53.53%, var(--color3) 95.62% );
	background-image: linear-gradient( 280deg, var(--color1) 12.08%, var(--color2) 53.53%, var(--color3) 95.62% );
	background-repeat: no-repeat;
	background-size: 100% 0.3em;
	background-position: 0 110%;
}

.gradient-underline a{color:#167ff5}
.gradient-underline a:hover{color:#08c5db}


  </style>

	<script src="/js1/jquery.js"></script>
	<!-- Document Title
	============================================= -->
	<title>Intelligent Transportation System | MiTAC Computing Technology</title>

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

				<div class="section lazy mt-0 p-0" data-bg="/EN/solution/images/IT-main.jpg" style="background-color:#f8f8f8; background-position: center center; background-repeat: no-repeat; background-size: cover;">


				<div class="container-fluid mt-5 mb-5">
				<div class="row g-0" >
					<div class="col-lg-1">&nbsp;</div>
				  <div class="col-lg-9 p-5">

				  <div class="row justify-content-between align-items-center">
									<div class="col  ls1 dark  mb-5 mb-md-0 py-5">
										<h2 class="display-4 text-white" style="font-weight: 600;" data-animate="backInLeft">Intelligent Transportation</h2>
										<p class="mb-5 text-white" style="line-height:1.2rem; font-weight: 100;  font-size:1rem" data-animate="backInLeft">

The application of intelligent transportation system (ITS) is widely accepted and used in many countries today and now become a multidisciplinary conjunctive field of work and thus many organizations around the world have developed solutions for providing ITS applications to meet the need.<br /><br />

The entire application of ITS is based on data collection, analysis and using the results of the analysis in the operations, control and research concepts for traffic management where location plays an important role.
										</p>
									</div>

					</div>
				  </div>
				  <div class="col-lg-2">
				  <div class="card-solution"  data-animate="backInRight">
				  <br />
				  <div class="heading-block center">
								  <h4><a href="#stories">Success Stories:</a></h4>
					</div>
					 <ul  class="iconlist">
					<li><i class="icon-line-chevrons-right"></i> <a href="#IT-5"  />Embedded NVR (Network Video Recorder)</a></li>
					<li><i class="icon-line-chevrons-right"></i> <a href="#IT-6"  />Edge Computing Drone</a></li>
					<li><i class="icon-line-chevrons-right"></i> <a href="#IT-4"  />Automotive Diagnostics</a></li>
					<li><i class="icon-line-chevrons-right"></i> <a href="#IT-3"  />Access Control</a></li>
					<li><i class="icon-line-chevrons-right"></i> <a href="#IT-1"  />Real-time In-Vehicle Surveillance</a></li>
					<li><i class="icon-line-chevrons-right"></i> <a href="#IT-2"  />Intelligent Passenger Information System (PIS)</a></li>
					</ul>
				  </div>
				  </div>
				</div>
				</div>


					<div class="shape-divider" data-shape="wave-4" data-position="bottom" data-height="150"></div>
				</div>


		<!--end Slider
		============================================= -->

<div class="container-fluid m-0 border-0" style="padding: 80px 0;">
<div class="container clearfix mt-3 mb-3 center">
	<img src="/EN/solution/images/Intelligent_Transportation-1.jpg" class="img-fluid" alt="Intelligent Transportation" />

</div>
</div>



<div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;">
<div class="container clearfix mt-3 mb-3">

	<h2 class="center">Traveler Information System</h2>
	<div class="row mt-2">

<div class="col-md-6" >
<h4 class="center h4-1" >Signage</h4>
<div class="row">
<div class="col-sm-6 center p-1" ><br /><a href="/EmbeddedSystem_MP1-11TGS_MP1-11TGS" /><img src="/EN/solution/images/FA_AGV_MP1-g.jpg" class="img-fluid" alt="MP1" /></a><h4><a href="/EmbeddedSystem_MP1-11TGS_MP1-11TGS" />MP1</a></h4></div>
<div class="col-sm-6 center p-1"><br /><a href="/EmbeddedSystem_S300-10AS_S300-10AS" /><img src="/EN/solution/images/IT_AFC_S300-g.jpg" class="img-fluid" alt="S300" /></a><h4><a href="/EmbeddedSystem_S300-10AS_S300-10AS" />S300</a></h4></div>

</div>
</div>
<div class="col-md-6">
<h4 class="center h4-1" >Self-service System</h4>
<div class="row">
<div class="col-sm-6 center p-1"><br /><a href="/IndustrialPanelPC_P210-11KS_P210-11KS" /><img src="/EN/solution/images/IT_hub_P210.jpg" class="img-fluid" alt="P210" /></a><h4><a href="/IndustrialPanelPC_P210-11KS_P210-11KS" />P210</a></h4></div>
<div class="col-sm-6 center p-1"><br /><a href="/EmbeddedSystem_E600_E600" /><img src="/EN/solution/images/IT_E600.jpg" class="img-fluid" alt="E600" /></a><h4><a href="/EmbeddedSystem_E600_E600" />E600</a></h4></div>
</div>
</div>

</div>
<p class="mb-3">&nbsp;</p>

<div class="row mt-2">
<div class="col-md-6" >
<h4 class="center h4-1">Intelligent Locker System</h4>
<div class="row">
<div class="col-sm-6 center p-1" ><br /><a href="/EmbeddedSystem_S310-11KS_S310-11KS" /><img src="/EN/solution/images/FA_AGV_S310-g.jpg" class="img-fluid" alt="S310" /></a><h4><a href="/EmbeddedSystem_S310-11KS_S310-11KS" />S310</a></h4></div>
<div class="col-sm-6 center p-1"><br /><a href="/EmbeddedSystem_E310_E310" /><img src="/EN/solution/images/IT_E310.jpg" class="img-fluid" alt="E310" /></a><h4><a href="/EmbeddedSystem_E310_E310" />E310</a></h4></div>

</div>
</div>
<div class="col-md-6">
<h4 class="center h4-1" >Automated Ticketing System</h4>
<div class="row">
<div class="col-sm-6 center p-1"><br /><a href="/IndustrialPanelPC_P150-10AI_P150-10AI" /><img src="/EN/solution/images/IT_FMS_P150-g.jpg" class="img-fluid" alt="P150" /></a><h4><a href="/IndustrialPanelPC_P150-10AI_P150-10AI" />P150</a></h4></div>
<div class="col-sm-6 center p-1"><br /><a href="/EmbeddedSystem_E410_E410" /><img src="/EN/solution/images/IT_E410.jpg" class="img-fluid" alt="E410" /></a><h4><a href="/EmbeddedSystem_E410_E410" />E410</a></h4></div>
</div>
</div>

</div>


<p class="mb-3">&nbsp;</p>
<a name="stories"></a>
<p class="mb-3">&nbsp;</p>

</div>
</div>




<div class="container-fluid m-0 border-0" style="padding: 80px 0;">
<div class="container clearfix mt-3 mb-3">

	<h2 class="center">In Vehicle Equipment Control & Surveillance</h2>
	<div class="row mt-2">
<div class="col-md-6" >
<h4 class="center h4-1">Surveilance</h4>
<div class="row">
<div class="col-sm-6 center p-1" ><br /><a href="/EmbeddedSystem_MX1-10FEP-D_MX1-10FEP-D" /><img src="/EN/solution/images/FA_OAS_MX1-D.jpg" class="img-fluid" alt="MX1-D" /></a><h4><a href="/EmbeddedSystem_MX1-10FEP-D_MX1-10FEP-D" />MX1-D</a></h4></div>
<div class="col-sm-6 center p-1"><br /><a href="/EmbeddedSystem_NV1_NV1" /><img src="/EN/solution/images/RA_SG_NV1-w.jpg" class="img-fluid" alt="NV1" /></a><h4><a href="/EmbeddedSystem_NV1_NV1" />NV1</a></h4></div>

</div>
</div>
<div class="col-md-6">
<h4 class="center h4-1" >Fleet Management System (FMS)</h4>
<div class="row">
<div class="col-sm-6 center p-1"><br /><a href="/IndustrialPanelPC_P100_P100-10AS" /><img src="/EN/solution/images/IT_ATS_P100.jpg" class="img-fluid" alt="P100" /></a><h4><a href="/IndustrialPanelPC_P100_P100-10AS" />P100</a></h4></div>
<div class="col-sm-6 center p-1"><br /><a href="/POS_Cappuccino_Cappuccino" /><img src="/EN/solution/images/IT_FMS_Cappuccino.jpg" class="img-fluid" alt="Cappuccino" /></a><h4><a href="/POS_Cappuccino_Cappuccino" />Cappuccino</a></h4></div>
</div>
</div>

</div>

<p class="mb-3">&nbsp;</p>


<div class="row mt-2">
<div class="col-md-12" >
<h4 class="center h4-1">Control & Passenger Information System</h4>
<div class="row">
<div class="col-sm-3 center p-1" ><br /><a href="/EmbeddedSystem_MX1-10FEP_MX1-10FEP" /><img src="/EN/solution/images/FA_OAS_MX1.jpg" class="img-fluid" alt="MX1" /></a><h4><a href="/EmbeddedSystem_MX1-10FEP_MX1-10FEP" />MX1</a></h4></div>
<div class="col-sm-3 center p-1"><br /><a href="/EmbeddedSystem_MP1-11TGS_MP1-11TGS" /><img src="/EN/solution/images/FA_AGV_MP1.jpg" class="img-fluid" alt="MP1" /></a><h4><a href="/EmbeddedSystem_MP1-11TGS_MP1-11TGS" />MP1</a></h4></div>
<div class="col-sm-3 center p-1" ><br /><a href="/EmbeddedSystem_MP1-11TGS-D_MP1-11TGS-D" /><img src="/EN/solution/images/FA_MC_MP1-D.jpg" class="img-fluid" alt="MP1-D" /></a><h4><a href="/EmbeddedSystem_MP1-11TGS-D_MP1-11TGS-D" />MP1-D</a></h4></div>
<div class="col-sm-3 center p-1"></div>

</div>
</div>


</div>


</div>
</div>



<a name="IT-5"></a>
<div class="container-fluid m-0 bg-dark-blue">
	<h1 class="center">Success Stories - Intelligent Transportation</h1>
</div>
<div class="container-fluid m-0 border-0" style="padding: 80px 0;">
<div class="container clearfix">

<div class="heading-block center">
							<h2>Embedded NVR (Network Video Recorder)</h2>
							<span></span>
</div>

<div class="center title-1" ><h2 class="gradient-underline">Solutions: <a href="/EmbeddedSystem_MP1-11TGS_MP1-11TGS" />MP1-11TGS</a></h2></div>


	<div class="row mt-6 mb-6">
	<div class="col-lg-6 mt-4" >
	<img src="/EN/solution/images/IT_Embedded_NVR_1.jpg" alt="Embedded NVR (Network Video Recorder)" class="img-fluid mb-4">
	<ul class="leftmargin-sm">
		<li>Intel® Tiger Lake-UP3 Core i7/i5/i3/Celeron ULV processors</li>
<li>Outstanding graphic computing capability with Integrated Intel® Iris Xe graphics</li>
<li>Provide rich I/O connections for multiple COM, USB for Camera, Sensor and motor control connection</li>
<li>4G/5G/SIM card ready for wireless connectivity</li>
	</ul>
	</div>
	<div class="col-lg-6" >
	<img src="/EN/solution/images/IT_Embedded_NVR_2.jpg" alt="Embedded NVR (Network Video Recorder)" class="img-fluid mt-2">
	</div>
	</div>
<p class="mb-4">&nbsp;</p>
<a name="IT-6"></a>

</div></div>





<div class="container-fluid m-0 border-0" style="padding: 80px 0;  background:#f8f8f8;">
<div class="container clearfix">

<div class="heading-block center">
							<h2>Edge Computing Drone</h2>
							<span></span>
</div>

<div class="center title-1" ><h2 class="gradient-underline">Solutions: <a href="/IndustrialMotherboard_PH13FEI_PH13FEI" />PH13FEI</a></h2></div>


	<div class="row mt-6 mb-6">
	<div class="col-lg-6 mt-4" >
	<img src="/EN/solution/images/IT_Edge_Computing_Drone_1.jpg" alt="Edge Computing Drone" class="img-fluid mb-4">
	<ul class="leftmargin-sm">
<li>High performance industrial-grade MB by Intel Coffee Lake Core-i processor</li>
<li>On-board hardware TPM2.0 module for performing encryption keys & crypto operations</li>
<li>Rich expansion slots for discrete Video Capture Card, Intel VPU Card, 4G / 5G card expansion</li>
<li>Up to 11 USB3.0/2.0 ports for camera and sensors connections</li>
	</ul>
	</div>
	<div class="col-lg-6" >
	<img src="/EN/solution/images/IT_Edge_Computing_Drone_2.jpg" alt="Edge Computing Drone" class="img-fluid mt-2">
	</div>
	</div>

<p class="mb-4">&nbsp;</p>
<a name="IT-4"></a>
</div></div>




<div class="container-fluid m-0 border-0" style="padding: 80px 0; ">
<div class="container clearfix">

<div class="heading-block center">
							<h2>Automotive Diagnostics</h2>
							<span></span>
</div>

<div class="center title-1" ><h2 class="gradient-underline">Solutions: <a href="/POS_Cappuccino_Cappuccino" />Cappuccino Tablet</a> + Extension Cover</h2></div>


	<div class="row mt-6 mb-6">
	<div class="col-lg-6 mt-4" >
	<img src="/EN/solution/images/IT_Automotive-Diagnostics_1.jpg" alt="Automotive Diagnostics" class="img-fluid mb-4">
	<ul class="leftmargin-sm">
<li>Capacitive hotkey (F1/F2/F3) on front side for intuitive operation </li>
<li>Featured with TPM 2.0, powerful anti-tampering device, able to detect potential intrusion during system boot-up</li>
<li>Built-in NFC reader to authenticate users' credentials</li>
<li>Featured with WiFi/BT/GPS/WWAN(optional) and rich I/O connections for OBD-II, external display, sensor equipment and Diagnostics Management System</li>
	</ul>
	</div>
	<div class="col-lg-6" >
	<img src="/EN/solution/images/IT_Automotive-Diagnostics_2.png" alt="Automotive Diagnostics" class="img-fluid mt-2">
	</div>
	</div>

<p class="mb-4">&nbsp;</p>
<a name="IT-3"></a>
</div></div>





<div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;">
<div class="container clearfix">

<div class="heading-block center">
							<h2>Access Control</h2>
							<span></span>
</div>

<div class="center title-1" ><h2 class="gradient-underline">Solutions: <a href="/IndustrialPanelPC_P100_P100-10AS" />P100</a> / <a href="/IndustrialPanelPC_P150-10AI_P150-10AI" />P150</a></h2></div>


	<div class="row mt-6 mb-6">
	<div class="col-lg-6 mt-4" >
	<img src="/EN/solution/images/IT_Access_Control_1.jpg" alt="Access Control" class="img-fluid mb-4">
	<ul class="leftmargin-sm">
<li>COM & GPIO interface for gate control</li>
<li>LAN and WLAN (optional) for real-time data transmission	</li>
	</ul>
	</div>
	<div class="col-lg-6" >
	<img src="/EN/solution/images/IT_Access_Control_2.png" alt="Access Control" class="img-fluid mt-2">
	</div>
	</div>

<p class="mb-4">&nbsp;</p>
<a name="IT-1"></a>
</div></div>




<div class="container-fluid m-0 border-0" style="padding: 80px 0; ">
<div class="container clearfix">

<div class="heading-block center">
							<h2>Real-time In-Vehicle Surveillance</h2>
							<span></span>
</div>

<div class="center title-1" ><h2 class="gradient-underline">Solutions: <a href="/EmbeddedSystem_MX1-10FEP-D_MX1-10FEP-D" />MX1-10FEP-D</a></h2></div>


	<div class="row mt-6 mb-6">
	<div class="col-lg-1"></div>
	<div class="col-lg-10 mt-4" >
	<img src="/EN/solution/images/IT-Surveillance-202201.png" alt="Real-time In-Vehicle Surveillance" class="img-fluid mb-4">
	<ul class="leftmargin-sm">
<li>Features with maximum 10 ports PoE (Power over Ethernet) for safety and surveillance applications, such as facial recognitoin</li>
<li>Rich I/O connectivities for multiple sencing and control in-vehicle devices</li>
<li>Multiple display for monitoring and passenger information displays</li>
<li>Optional WLAN for passenger internet connction and LTE for fleet management E-Mark certified </li>
	</ul>
	</div>
	<div class="col-lg-1"></div>
	</div>

<p class="mb-4">&nbsp;</p>
<a name="IT-2"></a>
</div></div>



<div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#fcfcfc;">
<div class="container clearfix">

<div class="heading-block center">
							<h2>Intelligent Passenger Information System (PIS)</h2>
							<span></span>
</div>

<div class="center title-1" ><h2 class="gradient-underline">Solutions: <a href="/EmbeddedSystem_MX1-10FEP_MX1-10FEP" />MX1-10FEP</a></h2></div>


	<div class="row mt-6 mb-6">
	<div class="col-lg-1" ></div>
	<div class="col-lg-10 mt-4" >
	<img src="/EN/solution/images/PIS-202201-1.jpg" alt="Intelligent Passenger Information System" class="img-fluid mb-4">
	<ul class="leftmargin-sm">
<li>Supports HDMI, DisplayPort, and DVI-I triple display ports for multi-display scenarios</li>
<li>Provides rich I/O connectivities for passenger counters, IP intercoms and environment sensors</li>
<li>Optional WLAN/4G/GPS expansion modules for railway traffic control </li>
<li>EN50155 certified </li>
	</ul>
	</div>
	<div class="col-lg-1" ></div>
	</div>

<p class="mb-4">&nbsp;</p>

</div></div>













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