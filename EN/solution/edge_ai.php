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
	<meta name="description" content="MiTAC's edge AI computing solutions for IoT appications, including Traffic Flow Monitoring, Smart Factory, Smart Vehicle, AMR">
	<meta property="og:type" content="website" />
	<meta property="og:description" content="MiTAC's edge AI computing solutions for IoT appications, including Traffic Flow Monitoring, Smart Factory, Smart Vehicle, AMR" />
	<meta property="og:title" content="Edge AI computing | MiTAC Digital Technology" />
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
	<title>Edge AI computing | MiTAC Digital Technology</title>

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

				<div class="section lazy mt-0 p-0" data-bg="/EN/solution/images/AI-edge-main-1.jpg" style="background-color:#f8f8f8; background-position: center center; background-repeat: no-repeat; background-size: cover;">


				<div class="container-fluid mt-3 mb-5">
				<div class="row g-0" >
					<div class="col-lg-1">&nbsp;</div>
				  <div class="col-lg-9 p-5">

				  <div class="row justify-content-between align-items-center">
									<div class="col  ls1 dark  mb-5 mb-md-0 py-5">
										<h2 class="display-4 text-white" style="font-weight: 600;" data-animate="backInLeft">Edge AI (Artificial Intelligence) </h2>
										<h2 style="font-weight: 300; color:#d2d2d2; line-height:0.6rem; font-size:2.5rem" data-animate="backInLeft">Real-time Calculation</h2>
										<div class="mb-5 text-white" style="line-height:1.2rem; font-weight: 100;  font-size:1rem" data-animate="backInLeft">
										In Industrial applications, the data is used mostly for the detection and control of abnormalities. But, the potential performance is for the optimization and prediction. Edge computing allows real-time operations for critical processes such as data analysis, decision making and taking action. It also decreases the costs and manpower requirements in data transmission and operation accuracy. Therefore, in many field like automation industries, visual inspection is increasingly used by Edge AI computing technology. In vehicle, smart ADAS driver assistance and incident detection also quite rapidly start to be adopted different autonomous vehicle applications. <br /><br />



	Edge AI provides:
	<ul style="margin-left:1rem" data-animate="backInLeft">

<li>Increase Productivity</li>
<li>Improve Security</li>
<li>Enhance Safety</li>
<li>Faster Response</li>

	</ul>
										</div>
									</div>

					</div>
				  </div>
				  <div class="col-lg-2">
				  <div class="card-solution"  data-animate="backInRight">

				  <div class="heading-block center">
								  <h4><a href="#stories">Success Stories:</a></h4>
					</div>
					 <ul  class="iconlist">
					 <li><i class="icon-line-chevrons-right"></i><a href="#AIE-1"  />Smart Factory Control Unit</a></li>
<li><i class="icon-line-chevrons-right"></i><a href="#AIE-3"  />Traffic Flow Monitoring</a></li>
<li><i class="icon-line-chevrons-right"></i><a href="#AIE-2"  />Smart Vehicle Control Unit</a></li>
<li><i class="icon-line-chevrons-right"></i><a href="#AIE-4"  />AMR (Autonomous Mobile Robot)</a></li>
<li><i class="icon-line-chevrons-right"></i><a href="#AIE-5"  />Machine Vision</a></li>
<li><i class="icon-line-chevrons-right"></i><a href="#AIE-6"  />Predictive Maintenance</a></li>
<li><i class="icon-line-chevrons-right"></i><a href="#AIE-7"  />Production Optimization</a></li>


					</ul>

					<!--<div class="heading-block center">
								  <h4 class="text-white">Document:</h4>
					</div>
					<ul  class="iconlist">
					<li><i class="icon-line-chevrons-right"></i><a href="https://download.mitacmct.com/Files/Catalog/Whitepaper-Edge_AI_in_Factory_automation_2022.pdf" target="_blank" />Edge AI White Paper</a></li>
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
<img src="/EN/solution/images/edge-ai.jpg" class="img-fluid" alt="Edge AI" />
</div>
</div>
<a name="stories"></a>

	<p class="mb-4">&nbsp;</p>


<a name="AIE-3"></a>
<div class="container-fluid m-0 bg-dark-blue">
	<h1 class="center">Success Stories - Edge AI</h1>
</div>

<div class="container-fluid m-0 border-0" style="padding: 80px 0; background-color:#f8f8f8">
<div class="container clearfix">

<div class="heading-block center">
							<h2>Traffic Flow Monitoring</h2>
							<span></span>
</div>

<div class="center title-1" ><h2 class="gradient-underline">Solutions: <a href="/EmbeddedSystem_MB1-10AP_MB1-10AP" />MB1-10AP</a> + Intel<sup>®</sup> Movidius<sup>TM</sup> Myriad<sup>TM</sup> X</h2></div>


	<div class="row mt-6 mb-6">
	<div class="col-lg-1 mt-4" ></div>
	<div class="col-lg-10 mt-4" >
	<img src="/EN/solution/images/AIE_Traffic_Flow_Monitoring-202201.jpg" alt="AI Edge computing - Traffic Flow Monitoring" class="img-fluid mb-4">
	<ul class="leftmargin-sm">
		<li>Intel Apollo Lake Efficient 4C4T or 2C2T Processor for real-time traffic flow monitoring </li>
<li>Equipped with Intel<sup>®</sup> Movidius<sup>TM</sup> Myriad<sup>TM</sup> X to enhance arithmetic capability for AI metadata computing</li>
<li>4 x USB3.0 and 3 x LAN Port for IP Camera connectivity</li>
<li>2 x mPCIE Slot for AI accelerator card or video capture card expansion</li>
<li>Expandable and Flexible I/O via Xpansion Modules </li>
<li>Wide temperature and wide voltage durability for harsh environment	</li>
	</ul>
	</div>
	<div class="col-lg-1" ></div>
	</div>

	<div class="divider divider-sm divider-center"><i class="icon-bullhorn1"></i></div>

	<div class="row mt-6 mb-6">
	<div class="title-1" ><h2>Press Release</h2></div>
	<div class="col-lg-3" >
	<div class="course-card">
									<a href="/en-US@Edge_AI_Solution_Autonomous_Car~PRDetail"><img class="card-img-top" src="/images/pressroom_pic/PR_Autonomous_Car_1.jpg" alt="Edge AI Solution- Autonomous Car"></a>
									<div class="card-body">
										<h4 class="card-title fw-bold mb-2"><a href="/en-US@Edge_AI_Solution_Autonomous_Car~PRDetail">Edge AI Solution- Autonomous Car</a></h4>
										<p class="mb-2 card-title-sub fw-normal "><a href="/en-US@Edge_AI_Solution_Autonomous_Car~PRDetail" class="text-black-50">2020/04/30</a></p>
									</div>

	</div>
	</div>
	<div class="col-lg-3" ></div>
	<div class="col-lg-3" ></div>
	<div class="col-lg-3" ></div>

	</div>





<p class="mb-4">&nbsp;</p>
<a name="AIE-1"></a>


</div></div>





<div class="container-fluid m-0 border-0" style="padding: 80px 0; ">
<div class="container clearfix">

<div class="heading-block center">
							<h2>Smart Factory Control Unit</h2>
							<span></span>
</div>

<div class="center title-1" ><h2 class="gradient-underline">Solutions: <a href="/EmbeddedSystem_MX1-10FEP-D_MX1-10FEP-D" />MX1-10FEP-D</a></h2></div>


	<div class="row mt-6 mb-6">
	<div class="col-lg-1" ></div>
	<div class="col-lg-10 mt-4" >
	<img src="/EN/solution/images/AIE_Smart_Factory-202201.png" alt="AI Edge computing - Smart Factory" class="img-fluid mb-4">
	<ul class="leftmargin-sm">
<li>Intel Xeon/Core-i7 processor for no latency computing power and center control</li>
<li>Nvidia Tesla T4/P4 graphic card for machine vision application</li>
<li>Up to 10 PoE for AOI camera connectivity</li>
<li>Expandable legacy I/O for rich sensors and devices control</li>
<li>Wide temperature and wide voltage durability for harsh environment</li>
	</ul>
	</div>
	<div class="col-lg-1" ></div>

	</div>


	<div class="divider divider-sm divider-center"><i class="icon-bullhorn1"></i></div>

	<div class="row mt-6 mb-6">
	<div class="title-1" ><h2>Press Release</h2></div>
	<div class="col-lg-3" >
	<div class="course-card">
									<a href="/en-US@MiTAC_Announce_Nvidia_NGC_ready_Edge_server_MX1-D~PRDetail"><img class="card-img-top" src="/images/pressroom_pic/PR_NGC-1.jpg" alt="MiTAC Announce Nvidia NGC ready Edge server - MX1-D"></a>
									<div class="card-body">
										<h4 class="card-title fw-bold mb-2"><a href="/en-US@MiTAC_Announce_Nvidia_NGC_ready_Edge_server_MX1-D~PRDetail">MiTAC Announce Nvidia NGC ready Edge server - MX1-D</a></h4>
										<p class="mb-2 card-title-sub fw-normal "><a href="/en-US@MiTAC_Announce_Nvidia_NGC_ready_Edge_server_MX1-D~PRDetail" class="text-black-50">2020/08/27</a></p>
									</div>

	</div>
	</div>
	<div class="col-lg-3" ></div>
	<div class="col-lg-3" ></div>
	<div class="col-lg-3" ></div>

	</div>







<p class="mb-4">&nbsp;</p>
<a name="AIE-4"></a>
</div></div>




<div class="container-fluid m-0 border-0" style="padding: 80px 0; background-color:#f8f8f8">
<div class="container clearfix">

<div class="heading-block center">
							<h2>AMR (Autonomous Mobile Robot)</h2>
							<span></span>
</div>

<div class="center title-1" ><h2 class="gradient-underline">Solutions: <a href="/EmbeddedSystem_MP1-11TGS_MP1-11TGS" />MP1-11TGS</a></h2></div>


	<div class="row mt-6 mb-6">
	<div class="col-lg-6 mt-4" >
	<img src="/EN/solution/images/AIE_AMR-202201-1.jpg" alt="AI Edge computing - Autonomous Mobile Robot" class="img-fluid mb-4">
	<ul class="leftmargin-sm">
<li>Intel® Tiger Lake-UP3 Core i7/i5/i3/Celeron ULV processors</li>
<li>Outstanding graphic computing capability with Integrated Intel®Iris Xe graphics</li>
<li>Provide rich I/O connections for multiple COM, USB for Camera, Sensor and motor control connection</li>
<li>4G/5G/SIM card ready for wireless connectivity</li>
	</ul>
	</div>
	<div class="col-lg-6" >
	<img src="/EN/solution/images/AIE_AMR-202201-2.jpg" alt="AI Edge computing - Autonomous Mobile Robot" class="img-fluid mt-2">
	</div>
	</div>

<p class="mb-4">&nbsp;</p>
<a name="AIE-2"></a>
</div></div>





<div class="container-fluid m-0 border-0" style="padding: 80px 0; ">
<div class="container clearfix">

<div class="heading-block center">
							<h2>Smart Vehicle Control Unit</h2>
							<span></span>
</div>

<div class="center title-1" ><h2 class="gradient-underline">Solutions: <a href="/EmbeddedSystem_MX1-10FEP-D_MX1-10FEP-D" />MX1-10FEP-D</a></h2></div>


	<div class="row mt-6 mb-6">
	<div class="col-lg-1" ></div>
	<div class="col-lg-10 mt-4" >
	<img src="/EN/solution/images/AIE_Smart_Vehicle-202201.jpg" alt="AI Edge computing - Smart Vehicle Control Unit" class="img-fluid mb-4">
	<ul class="leftmargin-sm">
	<li>Intel® Tiger Lake-UP3 Core i7/i5/i3/Celeron ULV processors</li>
<li>Intel®Iris Xe graphics for 5X better AI performance (up to 7.1 TOPS)</li>
<li>M.2 3042/3052 + SIM slot5G cellular network</li>
<li>M.2 2280 slot for Intel VPU card / Video capture card</li>
<li>UP to x8 PoE ports</li>
<li>I/O expansion like  x16 DIO, x12 COM, x2 CANBus</li>
<li>-40~70 operating temperature</li>
<li>12~36V wide power range with power ignition</li>
	</ul>
	</div>
	<div class="col-lg-1" ></div>

	</div>

	<div class="divider divider-sm divider-center"><i class="icon-bullhorn1"></i></div>

	<div class="row mt-6 mb-6">
	<div class="title-1" ><h2>Press Release</h2></div>
	<div class="col-lg-3" >
	<div class="course-card">
									<a href="/en-US@Automatic_Number_Plate_Recognition~PRDetail"><img class="card-img-top" src="/images/pressroom_pic/ANPR-PR-1.jpg" alt="Automatic Number Plate Recognition (ANPR)- Edge AI solution"></a>
									<div class="card-body">
										<h4 class="card-title fw-bold mb-2"><a href="/en-US@Automatic_Number_Plate_Recognition~PRDetail">Automatic Number Plate Recognition (ANPR)- Edge AI solution</a></h4>
										<p class="mb-2 card-title-sub fw-normal "><a href="/en-US@Automatic_Number_Plate_Recognition~PRDetail" class="text-black-50">2020/06/09</a></p>
									</div>

	</div>
	</div>
	<div class="col-lg-3" ></div>
	<div class="col-lg-3" ></div>
	<div class="col-lg-3" ></div>

	</div>



<p class="mb-4">&nbsp;</p>
<a name="AIE-6"></a>
</div></div>




<div class="container-fluid m-0 border-0" style="padding: 80px 0; background-color:#f8f8f8">
<div class="container clearfix">

<div class="heading-block center">
							<h2>Predictive Maintenance</h2>
							<span></span>
</div>

<div class="center title-1" ><h2 class="gradient-underline">Solutions: <a href="/EmbeddedSystem_ME1-108T_ME1-108T" />ME1-108T</a></h2></div>


	<div class="row mt-6 mb-6">
	<div class="col-lg-6 mt-4" >
	<img src="/EN/solution/images/AIE_Predictive_Maintenance-202201-1.jpg" alt="AI Edge computing - Predictive Maintenance" class="img-fluid mb-4">
	<ul class="leftmargin-sm">
<li>High performance 4 x 1.5 GHz ARM Cortex-A53 plus Cortex-M4 cores</li>
<li>Rich interface Giga LAN, USB 3.0, COM, Micro SD/SIM slot</li>
<li>High resoluluon DisplayPort @FHD 60Hz & HDMI 2.0@4K 60 Hz</li>
<li>Versatille expansion for HATs</li>
	</ul>
	</div>
	<div class="col-lg-6" >
	<img src="/EN/solution/images/AIE_Predictive_Maintenance-202201-2.jpg" alt="AI Edge computing - Predictive Maintenance" class="img-fluid mb-4">
	</div>
	</div>


<p class="mb-4">&nbsp;</p>
<a name="AIE-5"></a>
</div></div>



<div class="container-fluid m-0 border-0" style="padding: 80px 0; ">
<div class="container clearfix">

<div class="heading-block center">
							<h2>Machine Vision</h2>
							<span></span>
</div>

<div class="center title-1" ><h2 class="gradient-underline">Solutions: <a href="/EmbeddedSystem_MX1-10FEP-D_MX1-10FEP-D" />MX1-10FEP-D</a></h2></div>


	<div class="row mt-6 mb-6">
	<div class="col-lg-6 mt-4" >
	<img src="/EN/solution/images/AIE_Machine_Vision-202201-1.jpg" alt="AI Edge computing - Machine Vision" class="img-fluid mb-4">
	<ul class="leftmargin-sm">
<li>High performance embedded system by Intel Coffee Lake Core i / Xeon processor</li>
<li>Provide rich I/O connections for multiple COM, USB and PoE portrs</li>
<li>Features with triple/dual display ports for real-time monitoring</li>
<li>LAN and WLAN (optional) for cloud & edge computing</li>
	</ul>
	</div>
	<div class="col-lg-6" >
	<img src="/EN/solution/images/AIE_Machine_Vision-202201-2.jpg" alt="AI Edge computing - Machine Vision" class="img-fluid mt-2">
	</div>
	</div>

<p class="mb-4">&nbsp;</p>
<a name="AIE-7"></a>
</div></div>


<div class="container-fluid m-0 border-0" style="padding: 80px 0; background-color:#f8f8f8">
<div class="container clearfix">

<div class="heading-block center">
							<h2>Production Optimization</h2>
							<span></span>
</div>

<div class="center title-1" ><h2 class="gradient-underline">Solutions: <a href="/EmbeddedSystem_MX1-10FEP_MX1-10FEP" />MX1-10FEP</a></h2></div>


	<div class="row mt-6 mb-6">
	<div class="col-lg-6 mt-4" >
	<img src="/EN/solution/images/AIE_Production_Optimization-202201-1.jpg" alt="AI Edge computing - Production Optimization" class="img-fluid mb-4">
	<ul class="leftmargin-sm">
<li>High performance embedded system by Intel Coffee Lake Core i / Xeon processor</li>
<li>Provide rich I/O connections for multiple COM, USB and PoE portrs</li>
<li>Features with triple/dual display ports for real-time monitoring</li>
<li>LAN and WLAN (optional) for cloud & edge computing</li>
	</ul>
	</div>
	<div class="col-lg-6" >
	<img src="/EN/solution/images/AIE_Production_Optimization-202201-21.jpg" alt="AI Edge computing - Production Optimization" class="img-fluid mt-2">
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