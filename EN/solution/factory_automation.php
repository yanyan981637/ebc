<?php
header("X-Frame-Options: DENY");
//header("Content-Security-Policy-Report-Only: default-src *; img-src https:; frame-src 'none'; report-uri http://www.tyan.com");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://ipc.mitacmdt.com");
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
	<meta name='author' content='MiTAC Digital Technology'>
	<meta name="company" content="MiTAC Digital Technology">
	<meta name="description" content="Integrated with AOI, Robot, HMI, AGV, Surveillance, Access Control, Edge Server systems, MiTAC offers the totally solutions for factory automation.">
	<meta property="og:type" content="website" />
	<meta property="og:description" content="Integrated with AOI, Robot, HMI, AGV, Surveillance, Access Control, Edge Server systems, MiTAC offers the totally solutions for factory automation." />
	<meta property="og:title" content="Factory Automation | MiTAC Digital Technology" />
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
	<title>Factory Automation | MiTAC Digital Technology</title>

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

				<div class="section lazy mt-0 p-0" data-bg="/EN/solution/images/FA-main-1.jpg" style="background-color:#f8f8f8; background-position: center center; background-repeat: no-repeat; background-size: cover;">


				<div class="container-fluid mt-6 mb-5">
				<div class="row g-0" >
					<div class="col-lg-2">&nbsp;</div>
				  <div class="col-lg-8 p-5">

				  <div class="row justify-content-between align-items-center">
									<div class="col  ls1 dark  mb-5 mb-md-0 py-5">
										<h2 class="display-4 text-white" style="font-weight: 600;" data-animate="backInLeft">Factory Automation</h2>
										<p class="mb-5 text-white" style="line-height:1.2rem; font-weight: 100;  font-size:1rem" data-animate="backInLeft">
										Industry 4.0 brings industry automation to a new intelligent era. This represents both a trend and also a challenge to industrial manufacturing companies. To support our customers' demand requires that we make machines more intelligently communicate with each other and perform complex tasks perfectly. MiTAC offers a variety of solutions to meet the needs of stringent environments.
										</p>
									</div>

					</div>
				  </div>
				  <div class="col-lg-2">
				  <div class="card-solution header-stick"  data-animate="backInRight">

				  <div class="heading-block center">
								  <h4><a href="#stories">Success Stories:</a></h4>
					</div>
					 <ul  class="iconlist">
					 <li><i class="icon-line-chevrons-right"></i><a href="#FA-4"  />AGV (Automated Guided Vehicle)</a></li>
<li><i class="icon-line-chevrons-right"></i><a href="#FA-5"  />NVR (Network Video Recorder)</a></li>
<li><i class="icon-line-chevrons-right"></i><a href="#FA-6"  />Inspection</a></li>
<li><i class="icon-line-chevrons-right"></i><a href="#FA-7"  />AOI (Automated Optical Inspection)</a></li>
<li><i class="icon-line-chevrons-right"></i><a href="#FA-2"  />HMI (Human Machine Interface)</a></li>
<li><i class="icon-line-chevrons-right"></i><a href="#FA-3"  />Smart Building - Environment Control</a></li>

					</ul>

					<!--<div class="heading-block center">
								  <h4 class="text-white">Document:</h4>
					</div>
					<ul class="iconlist">
					<li><i class="icon-line-chevrons-right"></i><a href="/EN/solution/Edge_AI_Factory.pdf" target="_blank" />Edge AI Smart Factory Solution</a></li>
				    <li><i class="icon-line-chevrons-right"></i><a href="/EN/solution/Machine_Vision_white_paper_R2.pdf" target="_blank" />Machine Vision White Paper</a></li>
					</ul>-->

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
<img src="/EN/solution/images/factory_automation-2.jpg" class="img-fluid" alt="Factory Automation" />
</div>
</div>



<div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;">
<div class="container clearfix mt-3 mb-3">

	<h2 class="center">Operation & Automation System</h2>
	<div class="row mt-2">
<div class="col-md-4" >
<h4 class="center h4-1" >AOI & Robot Control</h4>
<div class="row">
<div class="col-sm-3 center p-1"></div>
<div class="col-sm-6 center p-1"><br /><a href="/EmbeddedSystem_MX1-10FEP_MX1-10FEP" /><img src="/EN/solution/images/FA_OAS_MX1-1.jpg" class="img-fluid" alt="MX1" /></a><br />
 <h4><a href="/EmbeddedSystem_MX1-10FEP_MX1-10FEP" />MX1</a></h4></div>
 <div class="col-sm-3 center p-1"></div>
</div>
</div>
<div class="col-md-4" >
<h4 class="center h4-1" >HMI</h4>
<div class="row">
<div class="col-sm-6 center p-1"><br /><a href="/IndustrialPanelPC_P150-11KS_P150-11KS" /><img src="/EN/solution/images/RA_ATM_P150-1.jpg" class="img-fluid" alt="P150" /></a><br />
 <h4><a href="/IndustrialPanelPC_P150-11KS_P150-11KS" />P150</a></h4></div>
<div class="col-sm-6 center p-1"><br /><a href="/IndustrialMotherboard_PH12CMI_PH12CMI" /><img src="/EN/solution/images/RA_RPOS_PH12CMI-1.jpg" class="img-fluid" alt="PH12CMI" /></a><br />
 <h4><a href="/IndustrialMotherboard_PH12CMI_PH12CMI" />PH12CMI</a></h4></div>
</div>
</div>
<div class="col-md-4">
<h4 class="center h4-1" >AGV</h4>
<div class="row">
<div class="col-sm-6 center p-1"><br /><a href="/EmbeddedSystem_MP1-11TGS_MP1-11TGS" /><img src="/EN/solution/images/FA_AGV_MP1-1.jpg" class="img-fluid" alt="MP1" /></a><br />
 <h4><a href="/EmbeddedSystem_MP1-11TGS_MP1-11TGS" />MP1</a></h4></div>
<div class="col-sm-6 center p-1"><br /><a href="/EmbeddedSystem_MB1-10AP_MB1-10AP" /><img src="/EN/solution/images/RA_VM_MB1-1.jpg" class="img-fluid" alt="MB1" /></a><br />
 <h4><a href="/EmbeddedSystem_MB1-10AP_MB1-10AP" />MB1</a></h4></div>
</div>
</div>

</div>

</div>
</div>



<div class="container-fluid m-0 border-0" style="padding: 80px 0;">
<div class="container clearfix mt-3 mb-3">

	<h2 class="center">Management & Communication System</h2>
	<div class="row mt-2">
	<div class="col-md-9" >
<h4 class="center h4-1" >Edge Server</h4>
<div class="row">
<div class="col-sm-4 center p-1" ><br /><a href="/EmbeddedSystem_MX1-10FEP-D_MX1-10FEP-D" /><img src="/EN/solution/images/FA_OAS_MX1-D.jpg" class="img-fluid" alt="MX1-D" /></a><br />
 <h4><a href="/EmbeddedSystem_MX1-10FEP-D_MX1-10FEP-D" />MX1-D</a></h4></div>
<div class="col-sm-4 center p-1"><br /><a href="/IndustrialMotherboard_PH13CMI_PH13CMI" /><img src="/EN/solution/images/FA_MC_PH13CMI.jpg" class="img-fluid" alt="PH13CMI" /></a><br />
 <h4><a href="/IndustrialMotherboard_PH13CMI_PH13CMI" />PH13CMI</a></h4></div>
<div class="col-sm-4 center p-1" ><br /><a href="/IndustrialMotherboard_PH10CMU_PH10CMU" /><img src="/EN/solution/images/FA_MC_PH10CMU.jpg" class="img-fluid" alt="PH10CMU" /></a><br />
 <h4><a href="/IndustrialMotherboard_PH10CMU_PH10CMU" />PH10CMU</a></h4></div>
</div>
</div>
<div class="col-md-3">
<h4 class="center h4-1" >&nbsp;&nbsp;</h4>
<div class="row">
<div class="col-sm-12 center p-1"><br /><a href="/EmbeddedSystem_MP1-11TGS-D_MP1-11TGS-D" /><img src="/EN/solution/images/FA_MC_MP1-D.jpg" class="img-fluid" alt="MP1-D" /></a><br />
 <h4><a href="/EmbeddedSystem_MP1-11TGS-D_MP1-11TGS-D" />MP1-D</a></h4></div>

</div>
</div>



	</div>


</div>
</div>


<div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;">
<div class="container clearfix mt-3 mb-3">

	<h2 class="center">Monitoring & Security System</h2>
	<div class="row mt-2">

<div class="col-md-6" >
<h4 class="center h4-1" >Surveillance</h4>
<div class="row">
<div class="col-sm-3 center p-1" ></div>
<div class="col-sm-6 center p-1"><br /><a href="/EmbeddedSystem_NV1_NV1" /><img src="/EN/solution/images/RA_SG_NV1.jpg" class="img-responsive" alt="NV1" /></a><br />
 <h4><a href="/EmbeddedSystem_NV1_NV1" />NV1</a></h4></div>
<div class="col-sm-3 center p-1" ></div>
</div>
</div>
<div class="col-md-6">
<h4 class="center h4-1" >Access Control</h4>
<div class="row">
<div class="col-sm-6 center p-1"><br /><a href="/EmbeddedSystem_MB1-10AP_MB1-10AP" /><img src="/EN/solution/images/RA_AC_MB1.jpg" class="img-fluid" alt="MB1" /></a><br />
 <h4><a href="/EmbeddedSystem_MB1-10AP_MB1-10AP" />MB1</a></h4></div>
<div class="col-sm-6 center p-1"><br /><a href="/EmbeddedSystem_ME1-118T_ME1-118T" /><img src="/EN/solution/images/RA_AC_ME1.jpg" class="img-fluid" alt="ME1" /></a><br />
 <h4><a href="/EmbeddedSystem_ME1-118T_ME1-118T" />ME1</a></h4></div>
</div>
</div>

</div>

<p class="mb-3">&nbsp;</p>
<a name="stories"></a>
<p class="mb-3">&nbsp;</p>

</div>
</div>

<a name="FA-4"></a>
<div class="container-fluid m-0 bg-dark-blue">
	<h1 class="center">Success Stories - Factory Automation</h1>
</div>

<div class="container-fluid m-0 border-0" style="padding: 80px 0; ">
<div class="container clearfix">

<div class="heading-block center">
							<h2>AGV (Automated Guided Vehicle)</h2>
							<span></span>
</div>

<div class="center title-1" ><h2 class="gradient-underline">Solutions: <a href="/EmbeddedSystem_MP1-11TGS_MP1-11TGS" />MP1-11TGS</a></h2></div>


	<div class="row mt-6 mb-6">
	<div class="col-lg-6 mt-4" >
	<img src="/EN/solution/images/IT_AGV_1.jpg" alt="Factory Automation - AGV (Automated Guided Vehicle)" class="img-fluid mb-4">
	<ul class="leftmargin-sm">
		<li>Intel® Tiger Lake-UP3 Core i7/i5/i3/Celeron ULV processors</li>
<li>Outstanding graphic computing capability with Integrated Intel®Iris Xe graphics</li>
<li>Provide rich I/O connections for multiple COM, USB for Camera, Sensor and motor control connection</li>
<li>4G/5G/SIM card ready for wireless connectivity</li>
	</ul>
	</div>
	<div class="col-lg-6" >
	<img src="/EN/solution/images/IT_AGV_20220126.png" alt="Factory Automation - AGV (Automated Guided Vehicle)" class="img-fluid mt-2">
	</div>
	</div>

	<div class="divider divider-sm divider-center"><i class="icon-bullhorn1"></i></div>

	<div class="row mt-6 mb-6">
	<div class="title-1" ><h2>Press Release</h2></div>
	<div class="col-lg-3" >
	<div class="course-card">
									<a href="/en-US@MiTAC_AGV_Embedded_System_Solution~PRDetail"><img class="card-img-top" src="/images/pressroom_pic/MiTAC_AGV-1.jpg" alt="MiTAC AGV (Automated Guided Vehicle) Embedded System Solution"></a>
									<div class="card-body">
										<h4 class="card-title fw-bold mb-2"><a href="/en-US@MiTAC_AGV_Embedded_System_Solution~PRDetail">MiTAC AGV (Automated Guided Vehicle) Embedded System Solution</a></h4>
										<p class="mb-2 card-title-sub fw-normal "><a href="/en-US@MiTAC_AGV_Embedded_System_Solution~PRDetail" class="text-black-50">2020/02/26</a></p>
									</div>

	</div>
	</div>
	<div class="col-lg-3" ></div>
	<div class="col-lg-3" ></div>
	<div class="col-lg-3" ></div>

	</div>





<p class="mb-4">&nbsp;</p>
<a name="FA-5"></a>


</div></div>





<div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;">
<div class="container clearfix">

<div class="heading-block center">
							<h2>NVR (Network Video Recorder)</h2>
							<span></span>
</div>

<div class="center title-1" ><h2 class="gradient-underline">Solutions: <a href="/EmbeddedSystem_NV1_NV1" />NV1</a></h2></div>


	<div class="row mt-6 mb-6">
	<div class="col-lg-6 mt-4" >
	<img src="/EN/solution/images/IT_NVR_1.jpg" alt="Factory Automation - NVR (Network Video Recorder)" class="img-fluid mb-4">
	<ul class="leftmargin-sm">
		<li>Intel® Tiger Lake-UP3 Core i7/i5/i3/Celeron ULV processors</li>
<li>64-CH H.265/H.264 decoding ability and simultaneous playback</li>
<li>Support up to 16 PoE ports</li>
<li>Dual 4K display for clear monitoring</li>
<li>Support 2 x HDD RAID 0/1 storage</li>
	</ul>
	</div>
	<div class="col-lg-6" >
	<img src="/EN/solution/images/IT_NVR_2.jpg" alt="Factory Automation - NVR (Network Video Recorder)" class="img-fluid mt-2">
	</div>
	</div>

<p class="mb-4">&nbsp;</p>
<a name="FA-6"></a>
</div></div>




<div class="container-fluid m-0 border-0" style="padding: 80px 0; ">
<div class="container clearfix">

<div class="heading-block center">
							<h2>Inspection</h2>
							<span></span>
</div>

<div class="center title-1" ><h2 class="gradient-underline">Solutions: <a href="/IndustrialMotherboard_ND108T_ND108T" />ND108T</a></h2></div>


	<div class="row mt-6 mb-6">
	<div class="col-lg-6 mt-4" >
	<img src="/EN/solution/images/IT_Inspection_1.jpg" alt="Factory Automation - Inspection" class="img-fluid mb-4">
	<ul class="leftmargin-sm">
<li>Powered by NXP I.MX8M Quad Core Arm-based processor</li>
<li>Featured with both LVDS and HDMI for internal and external display</li>
<li>Raspberry Pi 40 pin compatible connector for easy I/O expansion</li>
<li>Complete Linux BSP support for quick SW customization and development</li>
	</ul>
	</div>
	<div class="col-lg-6" >
	<img src="/EN/solution/images/IT_Inspection_2.jpg" alt="Factory Automation - Inspection" class="img-fluid mt-2">
	</div>
	</div>

<p class="mb-4">&nbsp;</p>
<a name="FA-7"></a>
</div></div>





<div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;">
<div class="container clearfix">

<div class="heading-block center">
							<h2>AOI (Automated Optical Inspection)</h2>
							<span></span>
</div>

<div class="center title-1" ><h2 class="gradient-underline">Solutions: <a href="/EmbeddedSystem_MX1-10FEP_MX1-10FEP"  />MX1-10FEP</a> / <a href="/EmbeddedSystem_S310-11KS_S310-11KS"  />S310-11KS</a></h2></div>


	<div class="row mt-6 mb-6">
	<div class="col-lg-6 mt-4" >
	<img src="/EN/solution/images/IT_AOI_1.jpg" alt="Factory Automation - AOI (Automated Optical Inspection)" class="img-fluid mb-4">
	<ul class="leftmargin-sm">
		<li>High performance embedded system by Intel Coffee Lake Core i / Xeon processor</li>
<li>Provide rich I/O connections for multiple COM, USB and PoE portrs</li>
<li>Features with triple/dual display ports for real-time monitoring</li>
<li>LAN and WLAN (optional) for cloud & edge computing</li>
	</ul>
	</div>
	<div class="col-lg-6" >
	<img src="/EN/solution/images/IT_AOI_2.jpg" alt="Factory Automation - AOI (Automated Optical Inspection)" class="img-fluid mt-2">
	</div>
	</div>


<p class="mb-4">&nbsp;</p>
<a name="FA-2"></a>
</div></div>




<div class="container-fluid m-0 border-0" style="padding: 80px 0; ">
<div class="container clearfix">

<div class="heading-block center">
							<h2>HMI (Human Machine Interface)</h2>
							<span></span>
</div>

<div class="center title-1" ><h2 class="gradient-underline">Solutions: <a href="/IndustrialPanelPC_P100_P100-10AS" />P100</a> / <a href="/IndustrialPanelPC_P150-11KS_P150-11KS" />P150</a> / <a href="/IndustrialPanelPC_D150-S_D150-S" />D150</a></h2></div>


	<div class="row mt-6 mb-6">
	<div class="col-lg-6 mt-4" >
	<img src="/EN/solution/images/FA_HMI_v1-1.jpg" alt="HMI (Human Machine Interface)" class="img-fluid mb-4">
	<ul class="leftmargin-sm">
<li>Provide I/O connection in both serial port (RS232/422/ 485) and GPIO function</li>
<li>Fanless design and IP rating for automation application</li>
<li>Feature with dual LAN ports for remote monitoring and maintain</li>
	</ul>
	</div>
	<div class="col-lg-6" >
	<img src="/EN/solution/images/FA_HMI_v1-2.png" alt="HMI (Human Machine Interface)" class="img-fluid mt-2">
	</div>
	</div>
	<div class="divider divider-sm divider-center"><i class="icon-bullhorn1"></i></div>
	<div class="row mt-6 mb-6">
	<div class="title-1" ><h2>Press Release</h2></div>
	<div class="col-lg-3" >
	<div class="course-card">
									<a href="/en-US@Integrated_Control_System_for_The_Food_And_Beverage_Industry~PRDetail">
									<img class="card-img-top" src="/images/pressroom_pic/P150-11KS_PR.jpg" alt="Integrated Control System for The Food And Beverage Industry"></a>
									<div class="card-body">
										<h4 class="card-title fw-bold mb-2"><a href="/en-US@Integrated_Control_System_for_The_Food_And_Beverage_Industry~PRDetail">Integrated Control System for The Food And Beverage Industry</a></h4>
										<p class="mb-2 card-title-sub fw-normal "><a href="/en-US@Integrated_Control_System_for_The_Food_And_Beverage_Industry~PRDetail" class="text-black-50">2020/03/27</a></p>
									</div>

	</div>
	</div>
	<div class="col-lg-3" ></div>
	<div class="col-lg-3" ></div>
	<div class="col-lg-3" ></div>

	</div>















<p class="mb-4">&nbsp;</p>
<a name="FA-3"></a>
</div></div>



<div class="container-fluid m-0 border-0" style="padding: 80px 0; background-color:#f8f8f8">
<div class="container clearfix">

<div class="heading-block center">
							<h2>Smart Building - Environment Control</h2>
							<span></span>
</div>

<div class="center title-1" ><h2 class="gradient-underline">Solutions: <a href="/IndustrialPanelPC_D210-10RI_D210-10RI" />D210</a> / <a href="/IndustrialPanelPC_D151-11KS_D151-11KS" />D151</a> / <a href="/IndustrialPanelPC_D150-L_D150-L" />D150</a></h2></div>


	<div class="row mt-6 mb-6">
	<div class="col-lg-6 mt-4" >
	<img src="/EN/solution/images/IT_Smart_Building_1.jpg" alt="Smart Building - Environment Control" class="img-fluid mb-4">
	<ul class="leftmargin-sm">
<li>Provide I/O connection in both serial port (RS232/422/485) and GPIO function</li>
<li>Industrial operating temperature and IP rating support</li>
<li>Optional WLAN for restricted area information and data transfer</li>
	</ul>
	</div>
	<div class="col-lg-6" >
	<img src="/EN/solution/images/IT_Smart_Building_2.png" alt="Smart Building - Environment Control" class="img-fluid mt-2">
	</div>
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