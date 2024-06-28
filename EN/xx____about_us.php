<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

if(strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
header("HTTP/1.1 301 Moved Permanently");
header("Location: /404.htm");
exit;
}

error_reporting(0);

session_start();

require "../config.php";

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
	<meta name='author' content='MiTAC Digital Technology'>
	<meta name="company" content="MiTAC Digital Technology">
	<meta name="description" content="MCT is a professional IT solution provider, providing total solutions from edge to cloud with advanced R&D, TCO and worldwide operations.">
	<meta property="og:type" content="website" />
	<meta property="og:description" content="MCT is a professional IT solution provider, providing total solutions from edge to cloud with advanced R&D, TCO and worldwide operations." />
	<meta property="og:title" content="About Us | MiTAC Digital Technology" />
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

		[id^="particles-"]  {
		  position: absolute;
		  width: 100%;
		  height: 100%;
		  top: 0;
		  left: 0;
		  background-repeat: no-repeat;
		  background-size: cover;
		  background-position: 50% 50%;
		}

		.card-box {margin-top:-3rem; margin-right:-15px; border-radius:0px; background-color: rgba(0, 66, 138, 0.8); color:#00428a; box-shadow:  5px 5px 10px rgba(104, 104, 104, 0.4),
-5px -5px 10px rgba(0, 0, 0, 0.4); color:#ffffff; padding: 3rem;}

.card-box-1 { border-radius:5px;  background-color:#77a6c2; box-shadow:  2px 2px 4px rgba(104, 104, 104, 0.4); color:#ffffff; padding: 3rem;}
.card-box-2 { border-radius:5px;  background-color:#4693b5; box-shadow:  2px 2px 4px rgba(104, 104, 104, 0.4); color:#ffffff; padding: 3rem;}
.heading-block::after {border-top: 2px solid #b5b5b5;}
.nav-box {color:#ffffff; font-size:1.5rem; font-weight:300; line-height:2rem; text-align: center; opacity: 0.9;}
.nav-box:hover {opacity: 1; cursor: pointer;}
.bg-dark-blue {background-color:#0D47A1; border:1px solid #0D47A1}
.bg-dark-blue h1 {color:#ffffff; padding: 1.6rem 1rem 0rem}

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

.gradient-text {
	background: -webkit-linear-gradient( 280deg, var(--color1) 12.08%, var(--color2) 53.53%, var(--color3) 95.62% );
	background: -o-linear-gradient( 280deg, var(--color1) 12.08%, var(--color2) 53.53%, var(--color3) 95.62% );
	background: linear-gradient( 280deg, var(--color1) 12.08%, var(--color2) 53.53%, var(--color3) 95.62% );
	-webkit-background-clip: text;
	-webkit-text-fill-color: transparent;
}



.title-1 h2 {font-weight: 300; line-height:2rem; letter-spacing: 2px !important; color:#626262; display: inline; }
.text-card {border-radius: 6px; box-shadow: 0 2px 4px rgba(3,27,78,.1); border: 1px solid #e5e8ed;}

  </style>

	<script src="/js1/jquery.js"></script>
	<!-- Document Title
	============================================= -->
	<title>About Us | MiTAC Digital Technology</title>

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
  include("../top1.htm");
	?>
	<!--end Header logo & global top menu-->





		<!-- Slider
		============================================= -->


				<div class="section m-0" style="background-color: #d2ecfa; padding: 80px 0">
					<div id="particles-bubbles"></div>
					<div class="container-fluid clearfix" >
					<h2 class="display-4 center" style="font-weight: 600; line-height:5rem;" data-animate="backInLeft">MiTAC Digital Technology Corp.</h2>
					<div class="row g-0" >
					<div class="col-lg-1">&nbsp;</div>
					<div class="col-lg-7">

					 <div class="row justify-content-between align-items-center" data-animate="backInLeft">
									<div class="col ls1 mb-5 mb-md-0 p-5">


										<p class="mb-5" style="line-height:1.5rem; font-weight:500;  font-size:1.2rem" >
										MiTAC Digital Technology Corporation is a professional IT solution provider, providing total solutions from edge to cloud with advanced R&D, TCO and worldwide operations. Focusing on cloud and edge computing solutions and services, MiTAC's design and manufacturing experience spans over thirty years in servers and storage systems for CSP, CoSP and Enterprise and is supplemented with a record of implementing hyper scale data centers and telecommunication companies. MiTAC Digital Technology' IoT solutions provide the industry with innovative embedded products and industrial computers. MiTAC's Industrial PC division provides the market with panel PCs, embedded box systems, mobile Point Of Sale, and industrial motherboards.


 <br /><br />
	MiTAC also serves the channel through <a href="https://www.tyan.com/" target="mtc" />TYAN Computer Corporation</a>, a business unit of MiTAC, offering an entire spectrum of commodity-off-the-shelf whitebox servers, spanning rack and tower systems, high-performance and GPU-accelerated computing, cloud computing servers, storage systems, workstations, including complete systems and fully integrated server racks to offer customers the best total cost of ownership.
										</p>
									</div>

					</div>


					</div>
					<div class="col-lg-4"><img src="/EN/solution/images/mitac-bg-2.png"  class="img-fluid" data-animate="backInRight" /></div>

					</div>


					<div class="row g-0" >
					<div class="col-lg-2">&nbsp;</div>
					<div class="col-lg-10">

					<div class="card-box"  data-animate="backInRight">
					 <div class="heading-block">
								  <h2 class="text-white">Manufacturing</h2>
					</div>
				 MCT design and manufacturing experience dates back more than thirty years, including a history of successfully supplying various computer and server solutions. MCT's industrial grade embedded products, ODM customization capacity, comprehensive relationships with channel and system integration service providers, means MCT now provides customers with deliverables featuring customized, flexible systems.  MCT’s belief is to ensure customers get the best Total Cost of Ownership (TCO) embedded solution of this and future generations.
				 </div>

				 <div class="row g-0" data-animate="backInRight" >
				  <div class="col nav-box p-4" onclick="location.href='#manf'" style="background:#4693b5;">Manufacturing Quality</div>
				  <div class="col nav-box p-4" onclick="location.href='#OEM'" style="background:#77a6c2;">Advanced JDM / ODM / OEM / OPM</div>
				  <div class="col nav-box p-4" onclick="location.href='#QM'" style="background:#a5c1d4; ">Design Quality Assurance</div>
				<div class="col nav-box p-4" onclick="location.href='#Office'" style="background:#4693b5; ">Worldwide Offices</div>
				  <div class="col nav-box p-4" onclick="location.href='https://www.mitac.com/en-global/environmental/index'" style="background:#77a6c2; ">Sustainability</div>
				 </div>


					</div>
					</div>
<p class="mb-3">&nbsp;</p>
					<a name="manf"></a>

					</div>
				</div>

		<!--end Slider
		============================================= -->



<div class="container-fluid m-0 bg-dark-blue">
	<h1 class="center">Manufacturing Quality</h1>
</div>


<div class="container-fluid m-0 border-0" style="padding: 80px 0; ">
<div class="container clearfix mt-3 mb-3">
<div class="heading-block center">
							<h2>World–Class Manufacturing Quality</h2>
							<span>Dedicated in-house manufacturing resource</span>
</div>
<div class="center"><img src="/EN/solution/images/Manufacturing-2022_1.jpg"  class="img-fluid" /></div>
</div>
</div>


<div class="container-fluid clearfix mt-3 mb-3 p-6" style="background:#f8f8f8;">

<div class="title-1 center mb-6" ><h2 class="gradient-underline">Intelligence</h2></div>

<div class="row justify-content-center gutter-30 col-mb-20">

<div class="col-lg-3 ">
							<div class="card h-100" >
								<img src="/EN/solution/images/Intelligence-1.jpg" class="card-img-top" alt="Online display">
								<div class="card-body">
									<h4 class="card-title">Online display</h4>
									<p class="card-text">The alert system, which is one part of intelligent management system (IMS) can alert SMT material shortage immediately.</p>

								</div>
							</div>
</div>
<div class="col-lg-3">
							<div class="card h-100">
								<img src="/EN/solution/images/Intelligence-2.jpg" class="card-img-top" alt="SPI Process">
								<div class="card-body">
									<h4 class="card-title">SPI Process</h4>
									<p class="card-text">3D solder paste inspection is to detect the quality of solder paste printing, including volume, area, height, XY offset, shape, bridging, etc. It could find defects occurring in process.</p>

								</div>
							</div>
</div>
<div class="col-lg-3">
							<div class="card h-100">
								<img src="/EN/solution/images/Intelligence-3.jpg" class="card-img-top" alt="Auto hand insertion machine">
								<div class="card-body">
									<h4 class="card-title">Auto hand insertion machine</h4>
									<p class="card-text">Auto H/I (hand insertion) machines improve production efficiency.</p>

								</div>
							</div>
</div>
<div class="col-lg-3">
							<div class="card h-100">
								<img src="/EN/solution/images/Intelligence-4.jpg" class="card-img-top" alt="High pot test">
								<div class="card-body">
									<h4 class="card-title">High pot test</h4>
									<p class="card-text">Automatic HI-POT test realizes test machine selfpositioning, test items auto-identifying, test data auto-uploading.</p>

								</div>
							</div>
</div>
</div>


<p class="mb-3 clear">&nbsp;</p>

</div>

<div class="container-fluid clearfix mt-3 mb-3 p-6" >

<div class="title-1 center mb-6" ><h2 class="gradient-underline">Efficiency</h2></div>

<div class="row justify-content-center gutter-30 col-mb-20">

<div class="col-lg-6">

							<div class="card">
								<div class="row g-0 align-items-center">
								    <div class="col-md-6 d-flex align-self-stretch overflow-hidden">
								    	<img src="/EN/solution/images/Efficiency-1.jpg" class="rounded-start" alt="Cell line">
								    </div>
								    <div class="col-md-6 p-4">
										<div class="card-body">
											<h4 class="card-title">Cell line</h4>
											<p class="card-text">Compared to the traditional assembly lines, the cellular manufacturing lines are with much higher efficiency and flexibility, good for low volume and diverse products.</p>

										</div>
									</div>
								</div>
							</div>

</div>
<div class="col-lg-6">
							<div class="card">
								<div class="row g-0 align-items-center">
								    <div class="col-md-6 d-flex align-self-stretch overflow-hidden">
								    	<img src="/EN/solution/images/Efficiency-2.jpg" class="rounded-start" alt="ERSA waving solder">
								    </div>
								    <div class="col-md-6 p-4">
										<div class="card-body">
											<h4 class="card-title">ERSA waving solder</h4>
											<p class="card-text">The advanced ERSA waving solder equipment could reduce the oxidation of the production and reduce the Sn slag, ﬂux residue in PCBA by 0.3mm size selective spray.</p>

										</div>
									</div>
								</div>
							</div>
</div>


</div>


<p class="mb-3  clear">&nbsp;</p>

</div>


<div class="container-fluid clearfix mt-3  p-6"  style="background:#f8f8f8;" >

<div class="title-1 center mb-6" ><h2 class="gradient-underline">Accuracy</h2></div>




<div class="row justify-content-center gutter-30 col-mb-20">

<div class="col-lg-3 ">
							<div class="card h-100" >
								<img src="/EN/solution/images/Accuracy-1.jpg" class="card-img-top" alt="P2L (Pick to light) / L2L (Load to light)">
								<div class="card-body"><br>
									<h4 class="card-title">P2L (Pick to light) / L2L (Load to light)</h4>
									<p class="card-text">MiTAC have set up 97 racks of P2Ls with the 135,800 reels capacity, 70 material shelves of L2L for over 5000 reels production supporting every day. The advantages is to kit materials collaboratively to avoid occupation, and reduce transferring time. The material kitting time has been reduced from 2 days to 4 hours.</p>

								</div>
							</div>
</div>
<div class="col-lg-3">
							<div class="card h-100">
							<div class="entry-image mb-0">
									<div class="fslider" data-arrows="false" data-lightbox="gallery">
										<div class="flexslider">
											<div class="slider-wrap">
												<div class="slide"><a href="/EN/solution/images/PCBA-1.jpg" data-lightbox="gallery-item" style="background: url('/EN/solution/images/PCBA-1.jpg') no-repeat center bottom; background-size: cover; height: 200px; "></a></div>
												<div class="slide"><a href="/EN/solution/images/PCBA-2.jpg" data-lightbox="gallery-item" style="background: url('/EN/solution/images/PCBA-2.jpg') no-repeat center bottom; background-size: cover; height: 200px; "></a></div>
												<div class="slide"><a href="/EN/solution/images/PCBA-3.jpg" data-lightbox="gallery-item" style="background: url('/EN/solution/images/PCBA-3.jpg') no-repeat center bottom; background-size: cover; height: 200px;"></a></div>
											</div>




										</div>
									</div>
							</div>



								<!--<img src="/EN/solution/images/Intelligence-2.jpg" class="card-img-top" alt="PCBA production line">-->
								<div class="card-body"><br>
									<h4 class="card-title">PCBA production line</h4>
									<p class="card-text"><ul class="leftmargin-sm" style="font-size:0.9rem">
											<li>3 PCBA production workshops with comprehensive SMT production and test equipment.</li>
<li>Produce different sizes of PCBA, up to 800*600mm.</li>
<li>The most advanced NXT generation III M6 SMT line reaches to 35000 component per hour (cph) with the nozzle H24.</li>
<li>Support the 03015 component.</li>
<li>IMS (Intelligent management system) is developed by IT team and connected with ERP and Shop Floor Control System.</li>
<li>IMS optimizes material kitting process, reduces inventory and improves manufacturing efﬁciency.</li>
<li>Material tracking, feeder management, inspection, MSD and material control are controlled by Part tracking system.</li>
<li>SMT process includes solder paste printing, SPI, component mounting, reflowing and AOI.</li>
<li>All the boards proceed with hand insertion, press-ﬁt, AXI, Flying Probe or ICT till BFT.</li>

</ul>	</p>

								</div>
							</div>
</div>
<div class="col-lg-3">
							<div class="card h-100">
								<img src="/EN/solution/images/Accuracy-3.jpg" class="card-img-top" alt="Clean room">
								<div class="card-body"><br>
									<h4 class="card-title">Clean room</h4>
									<p class="card-text">Clean room for panel cleaning and assembly which have passed ISO class 7 standard.</p>

								</div>
							</div>
</div>
<div class="col-lg-3">
							<div class="card h-100">
								<img src="/EN/solution/images/Accuracy-4.jpg" class="card-img-top" alt="Run in test and Burn in test">
								<div class="card-body"><br>
									<h4 class="card-title">Run in test and Burn in test</h4>
									<p class="card-text">Running the burn-in test tool at room temperature or 37OC to make sure the product quality and reliability.</p>

								</div>
							</div>
</div>
</div>
<a name="OEM"></a>
<p class="mb-5">&nbsp;</p>

</div>


<div class="container-fluid m-0 bg-dark-blue">
	<h1 class="center">Advanced JDM / ODM / OEM / OPM</h1>
</div>


<p class="mb-6">&nbsp;</p>
<div class="container-fluid m-0 border-0">
<div class="container-fluid clearfix mt-3 mb-3">

<div class="row justify-content-center gutter-30 col-mb-20">
<div class="col-lg-1"></div>
<div class="col-lg-2">
		<div class="feature-box p-5 media-box  h-100 text-card" >
										<div class="fbox-media display-1 center gradient-text">
											<i class="icon-line-database"></i>
										</div>
										<div class="fbox-content px-0">
											<h3 class="ls0">Leading Hardware</h3>
											<p><ul>
											<li>Various silicon platforms</li>
											<li>Board design simulation</li>
											<li>Advanced debug facility</li>
											</ul>
											</p>

										</div>
		</div>
</div>
<div class="col-lg-2">
		<div class="feature-box p-5 media-box  h-100 text-card" >
										<div class="fbox-media display-1 center gradient-text">
											<i class="icon-line-monitor"></i>
										</div>
										<div class="fbox-content px-0">
											<h3 class="ls0">Multiple Software</h3>
											<p><ul>
											<li>Various BIOS platform</li>
											<li>Windows / Linux / Android</li>
											<li>Windows compatibility test</li>
											<li>Utility / APP / API Design</li>
											</ul>
											</p>

										</div>
		</div>
</div>
<div class="col-lg-2">
		<div class="feature-box p-5 media-box  h-100 text-card" >
										<div class="fbox-media display-1 center gradient-text">
											<i class="icon-globe1"></i>
										</div>
										<div class="fbox-content px-0">
											<h3 class="ls0">World Class Industrial Design</h3>
											<p><ul>
											<li>Sketch proposal</li>
											<li>3D proposal</li>
											<li>Mock-up demo</li>
											</ul>
											</p>

										</div>
		</div>
</div>
<div class="col-lg-2">
		<div class="feature-box p-5 media-box  h-100 text-card" >
										<div class="fbox-media display-1 center gradient-text">
											<i class="icon-line-cog"></i>
										</div>
										<div class="fbox-content px-0">
											<h3 class="ls0">Superior Mechanical Engineering</h3>
											<p><ul>
											<li>Tier-1 ODM design experience</li>
											<li>Modularized design</li>
											<li>Structure simulation</li>
											<li>Thermal simulation</li>
											</ul>
											</p>

										</div>
		</div>
</div>
<div class="col-lg-2">
		<div class="feature-box p-5 media-box  h-100 text-card" >
										<div class="fbox-media display-1 center gradient-text">
											<i class="icon-award"></i>
										</div>
										<div class="fbox-content px-0">
											<h3 class="ls0">Wide Range Validation</h3>
											<p><ul>
											<li>Compatibility test</li>
											<li>Reliability test</li>
											<li>Environmental test</li>
											<li>Worldwide regulation certification</li>
											</ul>
											</p>

										</div>
		</div>
</div>
<div class="col-lg-1"></div>
</div>
<p class="mb-4">&nbsp;</p>
<div class="row mb-4">
<div class="col-lg-1"></div>
<div class="col-lg-2"><div class="feature-box p-5 media-box  h-100 text-card" >
										<div class="fbox-media display-1 center gradient-text">
											<i class="icon-city"></i>
										</div>
										<div class="fbox-content px-0">
											<h3 class="ls0">Advanced manufacturing</h3>
											<p><ul>
											<li>Automated inspection</li>
											<li>Uncompromising quality</li>
											<li>Systematic control process</li>
											</ul>
											</p>

										</div>
		</div></div>
<div class="col-lg-2"><div class="feature-box p-5 media-box  h-100 text-card" >
										<div class="fbox-media display-1 center gradient-text">
											<i class="icon-line-headphones"></i>
										</div>
										<div class="fbox-content px-0">
											<h3 class="ls0">Direct Service</h3>
											<p><ul>
											<li>Early-engage proposal service</li>
											<li>Fast sampling service</li>
											<li>Field technical service</li>
											<li>Global RMA service</li>
											</ul>
											</p>

										</div>
		</div></div>
<div class="col-lg-6">
<div class="card-box-1 h-100 justify-content-between align-items-center">
					 <div class="heading-block">
								  <h2 class="text-white">Certifications</h2>
					</div>
					<div class="center"><img src="/EN/solution/images/OEMODM-2.png" class="img-fluid" ></div>

</div>

</div>
<div class="col-lg-1"></div>
</div>
<p class="mb-4">&nbsp;</p>
</div>
</div>

<div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;">
<div class="container clearfix mt-3 mb-3">

<div class="card-box-2  justify-content-between align-items-center">
					 <div class="heading-block">
								  <h2 class="text-white">OEM / ODM Service</h2>
					</div>
					<p>MiTAC Digital Technology Corp. offers both Off The Shelf products, and OEM/ODM professional services to meet customer’s needs in different industries and applications. We provide tailored design packages from HW, SW, ME, ID, Test, Certification to Manufacturing. MCT's expertise is aimed to offer customers the most innovative design and World-class product quality to make the product just born to succeed!</p>

</div>

<div class="title-1 center mb-6 mt-5" ><h2 class="gradient-underline">Technical Support</h2></div>

<div class="center"><img src="/EN/solution/images/tech-support.png" class="img-fluid" ></div>
	<p class="mb-4">&nbsp;</p><a name="QM"></a>
</div>
</div>



<div class="container-fluid m-0 bg-dark-blue">
	<h1 class="center">Design Quality Assurance</h1>
</div>
<div class="container-fluid m-0 border-0" style="padding: 80px 0; ">
<div class="container clearfix mt-3 mb-3">
<div class="heading-block center">
							<h2>Robust & Reliable Design Quality Assurance</h2>
							<span>Professional design and comprehensive validation</span>
</div>

<div class="title-1 mb-1 center mt-1" ><h2 class="gradient-underline">Reliability Test</h2></div>
<div class="center mt-3 mb-6"><img src="/EN/solution/images/Reliability-Test.jpg" class="img-fluid" alt="Reliability Test" /></div>
<p class="mb-5">&nbsp;</p>
<div class="title-1 mb-1 center mt-1" ><h2 class="gradient-underline">Durability Test</h2></div>
<div class="center mt-3 mb-6"><img src="/EN/solution/images/Durability-Test.jpg" class="img-fluid" alt="Durability Test" /></div>
<p class="mb-5">&nbsp;</p>
<div class="row mb-6">
<div class="col-lg-6">
<div class="title-1 mb-1 center mt-1" ><h2 class="gradient-underline">Water & Dust Proof Test</h2></div>
<div class="center mt-3 mb-6"><img src="/EN/solution/images/Water-Dust-Proof-Test.jpg" class="img-fluid" alt="Water & Dust Proof Test" /></div>
</div>
<div class="col-lg-6">
<div class="title-1 mb-1 center mt-1" ><h2 class="gradient-underline">Acoustic Test</h2></div>
<div class="center mt-3 mb-6"><img src="/EN/solution/images/Acoustic-Test.jpg" class="img-fluid" alt="Acoustic Test" /></div>
</div>
</div>

<div class="title-1 mb-1 center mt-1" ><h2 class="gradient-underline">Package Test</h2></div>
<div class="center mt-3 mb-6"><img src="/EN/solution/images/Package-Test.jpg" class="img-fluid" alt="Package Test" /></div>


<p class="mb-5">&nbsp;</p>
<div class="title-1 mb-1 center mt-1" ><h2 class="gradient-underline">S & V Test</h2></div>
<div class="center mt-3 mb-6"><img src="/EN/solution/images/S-V-Test.jpg" class="img-fluid" alt="S & V Test" /></div>

</div>
</div>








<div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;">
<div class="container clearfix mt-3 ">
<div class="heading-block center">
							<h2>Qualified by international accreditation organization</h2>

</div>

<div class="center"><img src="/EN/solution/images/accreditation.png"  class="img-fluid"  /><br>
<span style="color:#aaaaaa; font-size:0.8rem; font-style: italic;">Reliability, E-Star and Acoustic lab (Accredit no.:3100/3017) / Certified with ISTA Shipment Criteria (1A,1B,1G,1H,3A,6A,7D)</span>
</div>
</div>
</div>




<div class="container-fluid clearfix" style="padding:80px 0">
<div class="container-fluid clearfix mt-3">
<div class="heading-block center">
							<h2>Worldwide ENV Marks & Ecolabels </h2>

</div>

<div class="row ">
<div class="col-lg-1"></div>
<div class="col-lg-10">

<div id="oc-clients" class="owl-carousel image-carousel carousel-widget" data-margin="60" data-loop="true" data-nav="false" data-autoplay="5000" data-pagi="false" data-items-xs="2" data-items-sm="3" data-items-md="4" data-items-lg="5" data-items-xl="6">

						<div class="oc-item"><a href="#"><img src="/EN/solution/images/European-WEEE.gif" alt="European WEEE"></a></div>
						<div class="oc-item"><a href="#"><img src="/EN/solution/images/Energy-Star.gif" alt="Energy Star"></a></div>
						<div class="oc-item"><a href="#"><img src="/EN/solution/images/Japan-Top-Runner.gif" alt="Japan's Top Runner"></a></div>
						<div class="oc-item"><a href="#"><img src="/EN/solution/images/Germany-GS.gif" alt="Germany GS (PAHs)"></a></div>
						<div class="oc-item"><a href="#"><img src="/EN/solution/images/80-Plus.gif" alt="80 Plus"></a></div>
						<div class="oc-item"><a href="#"><img src="/EN/solution/images/EPEAT.png" alt="EPEAT"></a></div>
					</div>

</div>
<div class="col-lg-1"></div>
</div>

</div>
</div>


<section id="content">
<div class="row g-0 clearfix" >

					<div class="col-lg-4 col-md-4 dark  col-padding" style="background-color: #515875;">
						<h3 class="center">MiTAC owns Full line ICT Products Agency Compliance Experiences</h3>
						<ul>
						<li>Servers, including NEBS spec validation and approval</li>
						<li>Workstations</li>
						<li>PCs</li>
						<li>POS-both desktop and mobaile types</li>
						<li>Home Media & AV product; Multimedia IT or IA products</li>
						<li>Car electronic products</li>
						<li>Power Supply / AC Power Adapters</li>
						<li>Conduct certification test and international approvals</li>
						</ul>
					</div>

					<div class="col-lg-4 col-md-4 dark col-padding" style="background-color: #576F9E;">
						<h3 class="center">Lab Accreditation ISO 17025</h3>
						<ul>
						<li>TAF (member of ILAC) accredited and regularly inspected by TAF through multilateral MRA (Mutual Recognition Arrangement) link to ILAC (Int'l Lab Accreditation Cooperation), and NVLAP is an accreditation body within the U.S and is a signatory of the ILAC MRA. in U.S</li>
						<li>FCC (US)</li>
						<li>VCCI (Japan)</li>
						<li>BSMI (Taiwan)</li>
						<li>Approved by Leading DOM / JDM partners</li>
						</ul>
					</div>

					<div class="col-lg-4 col-md-4 dark col-padding" style="background-color: #6697B9;">
						<h3 class="center">Lab Accreditation ISO 17025</h3>
						<ul class="leftmargin">
						<li>Agency requirement review</li>
<li>Joint development with E/E and M/E thru<ul>
<li>schematic / PCB layout design review,</li>
<li>system construction review</li></ul>
<li>Prototype pretest / debugging, system design verifications</li>
<li>Conduct certification test and international approvals</li>

						</ul>
					</div>
</div>
</section>

<div class="container-fluid m-0 border-0" style="padding: 80px 0; ">
<div class="container clearfix mt-3 mb-3">
<div class="heading-block center">
							<h2>Worldwide Regulatory Certification Services</h2>
							<span>Accredited In-house EMC & Safety Labs</span>
</div>

<div class="center mb-5"><img src="/EN/solution/images/Worldwide_Regulatory_Certification_Services_map.gif" class="card-img-top" alt="MiTAC Worldwide Regulatory Certification Services"></div>

<div class="row  clearfix">
  <div class="col-lg-4">
   <div class="card h-100">
   <img src="/EN/solution/images/Mitac-Hsinchu.jpg" class="card-img-top" alt="Mitac Hsinchu">
								<div class="card-body">
									<h4 class="card-title">Hsinchu Lab / Taiwan</h4>
									<ul class="card-text leftmargin-sm">
									<li>L11/L10 Climatic Test</li>
									<li>L10 Shock & Vibe Test</li>
									<li> HALT Test</li>
									<li>RDT Test</li>
									<li>Robot Test</li>
									<li>Energy Efficiency Test</li>
									</ul>
								</div>
	</div>
  </div>
  <div class="col-lg-4">
  <div class="card h-100">
   <img src="/EN/solution/images/Mitac-Linko.jpg" class="card-img-top" alt="Mitac Linko">
								<div class="card-body">
									<h4 class="card-title">Linko Lab / Taiwan</h4>
									<ul class="card-text leftmargin-sm">
											<li>Acoustic Test</li>
											<li>L11/L10 Shock & Vibe Test</li>
											<li>EMI & EMS Test</li>
									</ul>
								</div>
	</div>

  </div>
  <div class="col-lg-4">
  <div class="card h-100">
    <img src="/EN/solution/images/Mitac-MSL.jpg" class="card-img-top" alt="Mitac China MSL Lab">
								<div class="card-body">
									<h4 class="card-title">MSL Lab / China</h4>
									<ul class="card-text leftmargin-sm">
											<li>L10 Climatic Test</li>
											<li>L10 Shock & Vibe Test</li>
											<li>HALT Test</li>
											<li>RDT Test</li>
											<li>Energy Efficiency Test</li>
									</ul>
								</div>
	</div>

  </div>

</div>

</div>
</div>

<div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;background:#f8f8f8;">
<div class="container clearfix mt-3 mb-3">


<div class="row  clearfix">
  <div class="col-lg-1"></div>
  <div class="col-lg-4">
  <div class="card h-100">
								<img src="/EN/solution/images/EMI.jpg" class="card-img-top" alt="EMI">
								<div class="card-body">
									<p><ul class="card-text leftmargin-sm">
									<li>EMI</li>
									<li>Radiated Emission Test</li>
									<li>Conducted Emission Test</li>
									<li>Harmonic Test</li>
									<li>Voltage Fluctuations and Flicker Test</li>
									</ul>
									</p>
								</div>
	</div>
  </div>
  <div class="col-lg-3">
    <div class="card h-100">
								<img src="/EN/solution/images/Surge-Immunity-Test.jpg" class="card-img-top" alt="Surge Immunity Test">
								<div class="card-body">
									<p><ul class="card-text leftmargin-sm">
									<li>Surge Immunity Test</li>
									<li>Conducted Susceptibility Test (CS)</li>
									<li>Power Frequency Magnetic Field Immunity</li>
									<li>Voltage Dip and Interruption Test</li>
									</ul>
									</p>
								</div>
	</div>

  </div>
  <div class="col-lg-3">
  <div class="card h-100">
								<img src="/EN/solution/images/EMS.jpg" class="card-img-top" alt="EMS">
								<div class="card-body">
									<p><ul class="card-text leftmargin-sm">
									<li>EMS</li>
									<li>3M Full-Anechoic Chamber for EMI and RS testing</li>
									<li>Radiated Susceptibility Test (RS)</li>
									<li>Electric Fast Transient/Burst Test (EFT/B)</li>
									</ul>
									</p>
								</div>
	</div>
  </div>
<div class="col-lg-1"></div>
</div><p class="mb-3">&nbsp;</p><a name="Office"></a>
</div>
</div>









<div class="container-fluid m-0 bg-dark-blue">
	<h1 class="center">Worldwide Offices</h1>
</div>
<div class="container-fluid m-0 border-0" style="padding: 80px 0; ">
<div class="container clearfix mt-3 mb-3">
	<div class="row clearfix" >
	<div class="col-lg-4">
<h2>Headquarters</h2>
<h3>MiTAC Digital Technology Corporation</h3>
No.200, Wen Hwa 2nd Rd., Kuei Shan Dist., Taoyuan City 33383, Taiwan, R.O.C.<br />
TEL: 886-3-3275988 | <a href="mailto:Sales_client@mic.com.tw" />Sales_client@mic.com.tw</a><br />
<!--<a href="http://client.mitac.com" target="au" />http://client.mitac.com</a>-->
  </div>
	<div class="col-lg-4 p-3"><img src="/EN/solution/images/Mitac-Linko.jpg" class="img-fluid" ></div>


  <div class="col-lg-4 p-3"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3614.5933195827533!2d121.37341031537892!3d25.047871843888355!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3442a74040e9d095%3A0x53b44b9014055b9e!2z56We6YGU6Zu76IWm6IKh5Lu95pyJ6ZmQ5YWs5Y-4!5e0!3m2!1sen-US!2stw!4v1556853741415!5m2!1sen-US!2stw"  frameborder="0" style="border:0; height:250px" allowfullscreen></iframe></div>


	</div>
</div>
</div>
<div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;">
<div class="container clearfix mt-3 mb-3">
	<div class="row clearfix" >

	<div class="col-lg-4">
<h2>Taiwan</h2>
<h3>MiTAC Digital Technology Corporation</h3>
3F., No.1, R&D Road 2, HsinChu Science Park, HsinChu, Taiwan, R.O.C.<br />
TEL: 886-3-577-9088 | FAX: 886-3-578-3208</a><br />
<a href="mailto:Sales_client@mic.com.tw" />Sales_client@mic.com.tw</a>
  </div>
  <div class="col-lg-4 p-3"><img src="/EN/solution/images/Mitac-Hsinchu.jpg" class="img-fluid" ></div>
  <div class="col-lg-4 p-3"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3622.383880241614!2d121.00409721537545!3d24.78230535448803!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x34683616426caebb%3A0xeb79c7f6933a394d!2z5paw56u556eR5a245bel5qWt5ZyS5Y2A!5e0!3m2!1sen-US!2stw!4v1556854514321!5m2!1sen-US!2stw" frameborder="0" style="border:0;  height:250px" allowfullscreen></iframe>

  </div>


	</div>
</div>
</div>



<div class="container-fluid m-0 border-0" style="padding: 80px 0; ">
<div class="container clearfix mt-3 mb-3">
	<div class="row clearfix" >

	<div class="col-lg-4">
<h2>Japan</h2>
<h3>MiTAC Japan Corp.</h3>
Yasuda Shibaura 2nd Building 3F Kaigan 3-chome, 2-12, Minato-ku, Tokyo 108-0022, Japan<br />
TEL: 81-3-3769-8311 | FAX: 81-3-3769-8328<br />
<a href="mailto:MiTAC_NEWS@mitac.co.jp" />MiTAC_NEWS@mitac.co.jp</a>
  </div>
  <div class="col-lg-4 p-3"><img src="/EN/solution/images/Mitac-JP.jpg" class="img-fluid" ></div>
  <div class="col-lg-4 p-3"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3242.3517523137207!2d139.7531073155502!3d35.643704339635875!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188a34e73350b1%3A0x7b9559189f5c1d10!2z77yI5qCq77yJ44Oe44Kk44K_44OD44Kv44K444Oj44OR44Oz!5e0!3m2!1sen-US!2stw!4v1556854923475!5m2!1sen-US!2stw"  frameborder="0" style="border:0;  height:250px" allowfullscreen></iframe></div>


	</div>
</div>
</div>

<div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;">
<div class="container clearfix mt-3 mb-3">
<div class="heading-block center">
							<h2>China</h2>

</div>

<div class="row  gx-5 clearfix">
  <div class="col-lg-4 p-3">
  <img src="/EN/solution/images/Mitac-Kunshan.jpg" class="img-fluid" ><br><br />
  <h3>MiTAC Computer (KunShan) Co., Ltd.</h3>
  No.269, 2nd Road, Export Processing Zone, Changjiang South Road, Kunshan, Jiangsu, P.R.C<br />
TEL: 86-512-5736-7777 | FAX: 512-5739-1671<br />
<a href="mailto:Sales_client@mic.com.tw" />Sales_client@mic.com.tw</a>
  </div>
  <div class="col-lg-4 p-3">
  <img src="/EN/solution/images/Mitac-MSL.jpg" class="img-fluid" ><br><br />
  <h3>MITAC Computer (ShunDe) Ltd.</h3>
  No.1, Shunda Road, Lunjiao Street, ShunDe District, Foshan City, Guangdong Province, China<br />
TEL: 86-757-2775-3168 | FAX: 86-757-2775-9246<br />
<a href="mailto:Sales_client@mic.com.tw" />Sales_client@mic.com.tw</a>
  </div>
  <div class="col-lg-4 p-3">
  <img src="/EN/solution/images/Mitac-Shanghai.jpg" class="img-fluid" ><br><br />
  <h3>MiTAC Research (Shanghai) Ltd.</h3>
  No.213, Jiang Chang San Road, Zha Bei District, Shanghai<br />
TEL: 86-21-6143-1188 | FAX: 86-21-6143-1199<br />
<a href="mailto:Sales_client@mic.com.tw" />Sales_client@mic.com.tw</a>
  </div>
</div>



</div>
</div>
<div class="container-fluid m-0 border-0" style="padding: 80px 0; ">
<div class="container clearfix mt-3 mb-3">
	<div class="row clearfix" >
	<div class="col-lg-6 p-3">
<h2 >Europe</h2>
<h3>MiTAC Europe Ltd.,</h3>
3rd Floor The Pinnacle Station Way<br />
Crawley West Sussex <br />RH10 1JH<br />
United Kingdom
<br />
TEL: 44-7943739548<br />
<a href="mailto:Sales_client@mic.com.tw" />Sales_client@mic.com.tw</a>
  </div>
  <div class="col-lg-6 p-3">
  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2504.7609834768928!2d-0.18959098408582897!3d51.11286994729301!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4875ee1e677fe4cf%3A0x698e8c1ab9aa79d2!2sThe%20pinnacle%2C%20A2220%2C%20Crawley%20RH10%201HU%2C%20UK!5e0!3m2!1sen!2stw!4v1615345308095!5m2!1sen!2stw" frameborder="0" style="border:0;  height:300px" allowfullscreen="" loading="lazy"></iframe>
  </div>
	</div>
</div>
</div>


<div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;">
<div class="container clearfix mt-3 mb-3">
<div class="heading-block center">
							<h2>USA</h2>

</div>
	<div class="gx-5 clearfix mb-4"><img src="/EN/solution/images/Mitac-tyan.jpg" class="img-fluid" ></div>
<div class="row  gx-5 clearfix">
  <div class="col-lg-6 center p-3"><h3>MiTAC Information Systems Corp.</h3>
39889 Eureka Dr., Newark, CA 94560, U.S.A.<br />
<a href="mailto:Sales_client@mic.com.tw" />Sales_client@mic.com.tw</a><br /><br /><br />
<div>
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3164.9865473899804!2d-122.00050458441278!3d37.508235435221955!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fb8a600f117d3%3A0xd90b7b24b09fa94!2zMzk4ODkgRXVyZWthIERyLCBOZXdhcmssIENBIDk0NTYw576O5ZyL!5e0!3m2!1sen-US!2stw!4v1556863539851!5m2!1sen-US!2stw" frameborder="0" style="border:0;  height:300px" allowfullscreen></iframe>
</div>
  </div>
  <div class="col-lg-6 center p-3"> <h3>Tyan Computer Corp.</h3>
  39660 Eureka Drive, Newark, CA 94560,  U.S.A.<br />
TEL: 1-510-651-8868 | FAX: 1-510-651-7688<br />
<a href="https://www.tyan.com/" target="au" />https://www.tyan.com/</a><br /><br />
<div>
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3164.863279100973!2d-121.9980831309313!3d37.51114265629544!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fb8a92a6c481d%3A0x8dab972be8bff9d9!2zMzk2NjAgRXVyZWthIERyLCBOZXdhcmssIENBIDk0NTYw576O5ZyL!5e0!3m2!1szh-TW!2stw!4v1601947932154!5m2!1szh-TW!2stw" frameborder="0" style="border:0;  height:300px" allowfullscreen ></iframe>
</div>
  </div>
</div>



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

	<script src="/js1/particles/particles.min.js"></script>
	<script src="/js1/particles/particles-bubbles.js"></script><!-- Particles Bubbles -->

</body>
</html>