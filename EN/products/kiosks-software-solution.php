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

error_reporting(0);

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
	<meta name="description" content="MiTAC's kiosks software solutions include face recognition, eye tracking, touchless and pose estimation technologies.">
	<meta property="og:type" content="website" />
	<meta property="og:description" content="MiTAC's kiosks software solutions include face recognition, eye tracking, touchless and pose estimation technologies." />
	<meta property="og:title" content="Kiosks Software Solutions | MiTAC Computing Technology" />
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

#slider {background:  url('/products/img/KV-kiosks.jpg') no-repeat center center / cover;}
#kiosk-nav {margin-top:-6rem}
#kiosk-nav:hover {cursor: pointer; }
#kiosk-nav .k-on {background:#00428a;}
.k-on h4 {color:#fff}


 .sw-img {

        overflow: hidden;
        margin: 0 auto;
		padding:0px 2px
    }

    .sw-img img {
        width: 100%;
        transition: 0.5s all ease-in-out;
    }

    .sw-img:hover img {
        transform: scale(1.1);
    }


.color-blue {color:#0e438b}
.bg-top-line {border-top:1px solid #fff}
.subtle {font-weight: bold; color:#0d47a1}
h4 {font-weight:300; line-height:1.5rem; margin-top:1rem}
.bg-dark-blue {background-color:#0D47A1; border:1px solid #0D47A1}
.bg-dark-blue h1 {color:#ffffff; padding: 1.6rem 1rem 0rem}


.neumorphic-box-40 {border-radius: 40px;
background: #ffffff;
box-shadow:  6px 6px 15px rgba(0, 0, 0, 0.2),
             -6px -6px 15px rgba(255, 255, 255, 0.8); margin:5px 5px 10px 5px}



  </style>

	<script src="/js1/jquery.js"></script>
	<!-- Document Title
	============================================= -->
	<title>Kiosks Software Solutions | MiTAC Computing Technology</title>

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
		<section id="slider" class="slider-element">

			<div class="container mt-4 mb-6">
				<div class="row justify-content-between align-items-center">
					<div class="col-lg-6 col-md-6 dark  mb-5 mb-md-0 py-5">
						<h2 class="display-4  mt-2" style="font-weight: 600;" data-animate="backInLeft">A FULLY INTEGRATED KIOSK PROVIDER</h2>
						<p class="mb-5 lead text-white" data-animate="backInLeft">MiTAC designs, engineers, assembles, deploys and supports self-service Kiosk solutions</p>

					</div>
					<div class="col-md-6 d-flex align-self-end align-items-center align-items-lg-end col-form">

					</div>
				</div>
			</div>
		</section>


<!-- tabs -->

<div class="container mb-1"  >
<div id="kiosk-nav" class="content">
<div class="row">
    <div class="col-lg-8">
    <div  class="row justify-content-start">



	  <div class="col-lg-3 mb-4 mb-lg-0" onclick="location.href='/EN/products/standard-kiosks/#1'">
        <div class="grid-inner shadow-sm h-shadow bg-white p-3 overflow-hidden rounded-5 text-center shadow-ts">
          <div class="row justify-content-center">
          <div class="col-12" ><h4 class="h4 mb-0" >Standard Kiosks</h4></div>
          </div>
        </div>
	  </div>

    <div class="col-lg-3 mb-4 mb-lg-0" onclick="location.href='/EN/products/custom-kiosks/#1'">
        <div class="grid-inner shadow-sm h-shadow bg-white p-3 overflow-hidden rounded-5 text-center shadow-ts">
          <div class="row justify-content-center">
          <div class="col-12" ><h4 class="h4 mb-0" >Custom Kiosks</h4></div>
          </div>
        </div>
	  </div>





	   <div class="col-lg-3 mb-4 mb-lg-0" onclick="location.href='/EN/products/kiosks-software-solution/#1'">
        <div  class="k-on grid-inner shadow-sm h-shadow p-3 overflow-hidden rounded-5 text-center h-shadow-none">
          <div class="row justify-content-center">
          <div class="col-12" ><h4 class="h4 mb-0" >Software Solutions</h4></div>
          </div>
        </div>
	  </div>



    <div class="col-lg-3 mb-4 mb-lg-0" onclick="location.href='/EN/products/kiosks-market-solution/#1'">
        <div class="grid-inner shadow-sm h-shadow bg-white p-3 overflow-hidden rounded-5 text-center shadow-ts">
          <div class="row justify-content-center">
          <div class="col-12" ><h4 class="h4 mb-0" >Market Solutions</h4></div>
          </div>
        </div>
	  </div>

    </div>
    </div>
    <div class="col-lg-4">
    </div>
  </div>


</div>
</div>


<!--end  tabs -->






<a name="1"></a>
<div class="container-fluid mt-6 mb-3" >
    <div class="heading-block center">
                  <h1>Software Solutions</h1>
    </div>

</div>



	<div class="container-fluid">

	<p class="mt-3">&nbsp;</p>

	<div class="container" >


	<div class="embed-responsive embed-responsive-4by3">
  <iframe class="embed-responsive-item" width="560" height="315" src="https://www.youtube.com/embed/InU-B5y5y1Q" allowfullscreen></iframe>
</div>











	<p class="mt-6">&nbsp;</p>

	<div class="row">


<div class="col-md-3" >
  <div class="sw-img" ><a href="#KSK-SW-MiAI-MiFace" /><img src="/EN/solution/images/KSK-SW-MiAI-MiFace.jpg" alt="MiAI® MiFace" class="img-fluid" /></a></div>
  <h4 class="center">ComiSmartAI<br /><span class="subtle">ComiSmartFace</span></h4>
  </div>


   <div class="col-md-3" >
  <div class="sw-img" ><a href="#KSK-SW-MiAI-MiGaze" /><img src="/EN/solution/images/KSK-SW-MiAI-MiGaze.jpg" alt="MiAI® MiGaze" class="img-fluid" /></a></div>
  <h4 class="center">ComiSmartAI<br /><span class="subtle">ComiSmartGaze</span></h4>
  </div>
   <div class="col-md-3" >
  <div class="sw-img" ><a href="#KSK-SW-MiAI-MiService" /><img src="/EN/solution/images/KSK-SW-MiAI-MiService.jpg" alt="MiAI® MiService" class="img-fluid" /></a></div>
  <h4 class="center">ComiSmartAI<br /><span class="subtle">ComiSmartService</span></h4>
  </div>
   <div class="col-md-3" >
  <div class="sw-img" ><a href="#KSK-SW-MiAI-MiAirtouch" /><img src="/EN/solution/images/KSK-SW-MiAI-MiAirtouch.jpg" alt="MiAI® MiAirtouch" class="img-fluid" /></a></div>
  <h4 class="center">ComiSmartAI<br /><span class="subtle">ComiSmartAirtouch</span></h4>
  </div>
</div>
<p class="mt-6">&nbsp;</p>
	</div>
	</div>


	<!--MiAI® MiFace -->

<a name="KSK-SW-MiAI-MiFace"></a>
<p class="mt-3">&nbsp;</p>



	<div class="container-fluid m-0 bg-dark-blue">
	<h1 class="center"><span style="font-weight:300; color:#fff; font-size:2rem">ComiSmartAI</span> - ComiSmartFace </h1>
	</div>
<div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8">
					<div class="container  clearfix">

						<div class="heading-block center">
							<h2>Face Recognition Technology</h2>
							<span></span>
						</div>

						<div class="row mt-4 mb-5">
							<div class="col-lg-6">
								<h2>Introduction</h2>
  <p>At MiTAC, we have delicated and experienced team for every project. Our experienced ID/ technical consultants take involvement to design customer-oriented, high quality and cost-effective Kiosk after listening and absorbing customer expectations.</p>
  <img src="/EN/solution/images/KIOSK-SW-intro.svg" class="img-fluid" style="margin:5% 15%"  />
							</div>

							<div class="col-lg-6">
								<img src="/EN/solution/images/KIOSK-SW-intro.jpg" style="margin:8% 0 0 0" class="img-fluid" />
							</div>
						</div>

					</div>
</div>
<div class="container-fluid m-0 border-0" style="padding: 80px 0; ">


<div class="container clearfix">

<h2>Application</h2>
<p class="mt-2">&nbsp;</p>
<div class="row mb-3">
  <div class="col-md-3"><div class="neumorphic-box-40 p-3" >
  <div class="center"><img src="/EN/solution/images/KIOSK-SW-APP-1.svg" style="width:150px; margin:10px 0px 10px 0px"  /></div><br />
  <p class="center">Illegal Purchasing Alert When Minors Get Alcohol from Self-Checkout Kiosk</p>
  </div></div>
  <div class="col-md-3"><div class="neumorphic-box-40 p-3" >
  <div class="center"><img src="/EN/solution/images/KIOSK-SW-APP-2.svg" style="width:150px; margin:25px 0px 40px 0px"  /></div><br />
  <p class="center">Customer Preference Prediction</p>
  </div></div>
  <div class="col-md-3"><div class="neumorphic-box-40 p-3" >
  <div class="center"><img src="/EN/solution/images/KIOSK-SW-APP-3.svg" style="width:150px; margin:30px 0px 35px 0px"  /></div><br />
  <p class="center" >Membership Management</p>
  </div></div>
  <div class="col-md-3"><div class="neumorphic-box-40 p-3" >
  <div class="center"><img src="/EN/solution/images/KIOSK-SW-APP-4.svg" style="width:150px; margin:70px 0px 45px 0px"  /></div><br />
  <p class="center" >BI Dashboard Analytics</p>
  </div></div>
</div>

</div>
</div>



		<div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;">
	<div class="container clearfix" >
	<p class="mb-3">&nbsp;</p>
	<div class="row">
  <div class="col-lg-6"><p class="mb-3">&nbsp;</p>
  <h2>Overview</h2>
  <p>In terms of AI technology, biometrics are used to identify and authenticate a person using a set of recognizable and verifiable data unique and specific to that person. Due to easy-to-deploy, facial biometrics continues to be the preferred biometric benchmark. In addition to authentication, it is also able to generate more insights for further analytics.</p>

  </div>
  <div class="col-lg-6"><img src="/EN/solution/images/KIOSK-SW-overview.jpg" style="margin:8% 0 0 0" class="img-fluid" /></div>
</div><p class="mb-3">&nbsp;</p>
	</div>
	</div>



<div class="container-fluid m-0 border-0" style="padding: 80px 0; ">
<div class="container clearfix" >
	<p class="mb-3">&nbsp;</p>
	 <h2>Challenges</h2>
	<div class="row">
  <div class="col-md-4" >
  <div class="neumorphic-box-40 p-3" >
  <div class="center"><img src="/EN/solution/images/KIOSK-SW-Challenges-1.svg" style="width:200px; margin:50px 0px 40px 0px"  /></div><br />
  <p class="center" >Not solid royalty management by physical member card (1 card shared among 1 family)</p>
  </div></div>
  <div class="col-md-4" >
  <div class="neumorphic-box-40 p-3">
  <div class="center"><img src="/EN/solution/images/KIOSK-SW-Challenges-2.svg" style="width:200px; margin:20px 0px 10px 0px"  /></div><br />
  <p class="center" >Imprecise and data latency on customer's preference analytics</p>
  </div></div>
  <div class="col-md-4" >
  <div class="neumorphic-box-40 p-3">
  <div class="center"><img src="/EN/solution/images/KIOSK-SW-Challenges-3.svg" style="width:200px; margin:10px 0px 10px 0px"  /></div><br />
  <p class="center">Certain R&amp;D effort on 2nd-time development on AI implementation</p>
  </div></div>

</div><p class="mb-3">&nbsp;</p>
	</div>
</div>

<div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;">
<div class="container clearfix" >
	<p class="mb-3">&nbsp;</p>
	 <h2>Solutions</h2>
	<div class="row">
   <div class="col-md-3"><div class="neumorphic-box-40 p-3" >
  <div class="center"><img src="/EN/solution/images/KIOSK-SW-Solution-1.svg" style="width:150px; margin:25px 0px 25px 0px"  /></div><br />
  <p class="center" >Utilizing key biometrics to capture actual purchasing customers</p>
  </div></div>
  <div class="col-md-3"><div class="neumorphic-box-40 p-3" >
  <div class="center"><img src="/EN/solution/images/KIOSK-SW-Solution-2.svg" style="width:150px; margin:50px 0px 30px 0px"  /></div><br />
  <p class="center" >Incredible recognition rate with machine learning model by Iterated dataset</p>
  </div></div>
  <div class="col-md-3"><div class="neumorphic-box-40 p-3" >
  <div class="center"><img src="/EN/solution/images/KIOSK-SW-Solution-3.svg" style="width:150px; margin:10px 0px 10px 0px"  /></div><br />
  <p class="center" >Scalability on easy-to-deploy and Integrable service/app with other IoT platform</p>
  </div></div>
  <div class="col-md-3"><div class="neumorphic-box-40 p-3" >
  <div class="center"><img src="/EN/solution/images/KIOSK-SW-Solution-4.svg" style="width:150px; margin:50px 0px 10px 0px"  /></div><br />
  <p class="center" >Decent and user-friendly BI Dashboard</p>
  </div></div>

</div><p class="mb-3">&nbsp;</p>
	</div>
</div>

<div class="container-fluid m-0 border-0" style="padding: 80px 0; background: url(/EN/solution/images/KIOSK-SW-results.jpg) no-repeat center center; background-size: cover;">
<div class="container clearfix" ><p class="mb-3">&nbsp;</p>
<h2>Results</h2>
<div class="row">
  <div class="col-md-4" >
  <div class="neumorphic-box-40 p-3" >
  <div class="center"><img src="/EN/solution/images/KIOSK-SW-result-1.svg" style="width:200px; margin:28px 0px 16px 0px"  /></div><br />
  <p class="center" >Customer's satisfaction arises as their needs are well-noted by retailers as well as being well-treated</p>
  </div></div>
  <div class="col-md-4" >
  <div class="neumorphic-box-40 p-3">
  <div class="center"><img src="/EN/solution/images/KIOSK-SW-result-2.svg" style="width:200px; margin:70px 0px 52px 0px"  /></div><br />
  <p class="center" >More precise customer's preference analytics due to real-time and customer-oriented BI Dashboard </p>
  </div></div>
  <div class="col-md-4" >
  <div class="neumorphic-box-40 p-3">
  <div class="center"><img src="/EN/solution/images/KIOSK-SW-result-3.svg" style="width:200px; margin:20px 0px 10px 0px"  /></div><br />
  <p class="center">Retailer's sales volume increasing and TCO optimized through state-of-the-art AI technology </p>
  </div></div>

</div>

<p class="mb-3">&nbsp;</p>
<a name="KSK-SW-MiAI-MiGaze"></a>

	</div>
</div>

<!-- end MiAI® MiFace -->

<!--ComiSmartGaze -->

	<div class="container-fluid m-0 bg-dark-blue">
	<h1 class="center"><span style="font-weight:300; color:#fff; font-size:2rem">ComiSmartAI</span> - ComiSmartGaze</h1>
	</div>

	<div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;">
<div class="container clearfix" >
	<p class="mb-3">&nbsp;</p>
	<div class="heading-block center">
							<h2>Eye Tracking Technology</h2>
							<span></span>
	</div>
	<div class="row mt-4 mb-5">
	<div class="col-lg-6">
  <h2>Introduction</h2>
  <p>Utilizing eye-tracking mechanism to filter mis-awake prevention of Kiosk as well as real energy saving</p>
  <img src="/EN/solution/images/KIOSK-SW-MiGaze-intro.svg" class="img-fluid" style="margin:5% 15%" />
  </div>
  <div class="col-lg-6"><img src="/EN/solution/images/KIOSK-SW-MiGaze-KV.jpg" style="margin:8% 0 0 0" class="img-fluid" /></div>
</div>
	</div>
</div>
<div class="container-fluid m-0 border-0" style="padding: 80px 0; ">
<div class="container clearfix" ><p class="mb-3">&nbsp;</p>
<h2>Application</h2>
<div class="row">
<div class="col-md-4"><div class="neumorphic-box-40 p-3" >
  <div class="center"><img src="/EN/solution/images/KIOSK-SW-APP-MiGaze-1.svg" style="width:140px; margin:60px 0px 25px 0px"  /></div><br />
  <p class="center">Smart Apps Modes Switch</p>
  </div></div>
  <div class="col-md-4"><div class="neumorphic-box-40 p-3" >
  <div class="center"><img src="/EN/solution/images/KIOSK-SW-APP-MiGaze-2.svg" style="width:100px; margin:10px 0px 10px 0px"  /></div><br />
  <p class="center" >Mis-awake Prevention When Walk-by Kiosk</p>
  </div></div>
  <div class="col-md-4"><div class="neumorphic-box-40 p-3" >
  <div class="center"><img src="/EN/solution/images/KIOSK-SW-APP-MiGaze-3.svg" style="width:200px; margin:18px 0px 0px 0px"  /></div><br />
  <p class="center" >Customer Analytics</p>
  </div></div>
</div>
<p class="mb-3">&nbsp;</p><a name="KSK-SW-MiAI-MiService"></a>
</div></div>





<!--end ComiSmartGaze -->


<!--ComiSmartService -->





	<div class="container-fluid m-0 bg-dark-blue">
	<h1 class="center"><span style="font-weight:300; color:#fff; font-size:2rem">ComiSmartAI</span> - ComiSmartService</h1>
	</div>

	<div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;">
<div class="container clearfix" >
	<p class="mb-3">&nbsp;</p>
	 <div class="heading-block center">
							<h2>Pose Estimation Technology</h2>
							<span></span>
						</div>


	<div class="row mt-4 mb-5">
    <div class="col-lg-6">
  <h2>Introduction</h2>
  <p>Utilizing pose estimation mechanism to replace continuously standby waiters/waitress for sake of customers' ordering request</p>
  <img src="/EN/solution/images/KIOSK-SW-MiService-intro.svg" class="img-fluid" style="margin:5% 15%" />
  </div>
  <div class="col-lg-6"><img src="/EN/solution/images/KIOSK-SW-MiService-intro.jpg" style="margin:8% 0 0 0" class="img-fluid" /></div>

</div>

	</div>
</div>

<div class="container-fluid m-0 border-0" style="padding: 80px 0; ">
<div class="container clearfix" ><p class="mb-3">&nbsp;</p>
<h2>Application</h2>
<div class="row">
 <div class="col-md-3"><div class="neumorphic-box-40 p-3" >
  <div class="center"><img src="/EN/solution/images/KIOSK-SW-APP-MiService-1.svg" style="width:150px; margin:50px 0px 40px 0px"  /></div><br />
  <p class="center">Real-time Notification</p>
  </div></div>
  <div class="col-md-3"><div class="neumorphic-box-40 p-3" >
  <div class="center"><img src="/EN/solution/images/KIOSK-SW-APP-MiService-2.svg" style="width:150px; margin:45px 0px 20px 0px"  /></div><br />
  <p class="center" >Smart Tableside Ordering</p>
  </div></div>
  <div class="col-md-3"><div class="neumorphic-box-40 p-3" >
  <div class="center"><img src="/EN/solution/images/KIOSK-SW-APP-MiService-3.svg" style="width:150px; margin:10px 0px 15px 0px"  /></div><br />
  <p class="center" >Smart Tableside Clean</p>
  </div></div>
  <div class="col-md-3"><div class="neumorphic-box-40 p-3" >
  <div class="center"><img src="/EN/solution/images/KIOSK-SW-APP-MiService-4.svg" style="width:150px; margin:10px 0px 10px 0px"  /></div><br />
  <p class="center">Staff Allocation Management</p>
  </div></div>
</div>
<p class="mb-3">&nbsp;</p><a name="KSK-SW-MiAI-MiAirtouch"></a>
</div></div>


<!--end ComiSmartService -->


<!--ComiSmartAirtouch -->




	<div class="container-fluid m-0 bg-dark-blue">
	<h1 class="center"><span style="font-weight:300; color:#fff; font-size:2rem">ComiSmartAI</span> - ComiSmartAirtouch</h1>
	</div>
<div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;">
<div class="container clearfix" >
	<p class="mb-3">&nbsp;</p>
	 <div class="heading-block center">
							<h2>Touchless Technology</h2>
							<span></span>
						</div>
	<div class="row mt-4 mb-5">
	  <div class="col-lg-6">
  <h2>Introduction</h2>
  <p>Utilizing touchless technology to make customer not only get used to post COVID-19 life seamlessly but also in a safe manner</p>
  <img src="/EN/solution/images/KIOSK-SW-MiAirtouch-intro.svg" class="img-fluid" style="width:150px; margin:5% 20%" />
  </div>
  <div class="col-lg-6"><img src="/EN/solution/images/KIOSK-SW-MiAirtouch-intro.jpg" style="margin:8% 0 0 0" class="img-fluid" /></div>


</div><p class="mb-3">&nbsp;</p>

	</div>
</div>


<div class="container-fluid m-0 border-0" style="padding: 80px 0; ">
<div class="container clearfix" ><p class="mb-3">&nbsp;</p>
<h2>Application</h2>
<div class="row">
  <div class="col-md-3"><div class="neumorphic-box-40 p-3" >
  <div class="center"><img src="/EN/solution/images/KIOSK-SW-APP-MiAirtouch-1.svg" style="width:150px; margin:55px 0px 45px 0px"  /></div><br />
  <p class="center">Touchless Touch Emerging</p>
  </div></div>
  <div class="col-md-3"><div class="neumorphic-box-40 p-3" >
  <div class="center"><img src="/EN/solution/images/KIOSK-SW-APP-MiAirtouch-2.svg" style="width:150px; margin:5px 0px 5px 0px"  /></div><br />
  <p class="center" >Reflection of Rising Hygiene Awareness</p>
  </div></div>
  <div class="col-md-3"><div class="neumorphic-box-40 p-3" >
  <div class="center"><img src="/EN/solution/images/KIOSK-SW-APP-MiAirtouch-3.svg" style="width:150px; margin:75px 0px 50px 0px"  /></div><br />
  <p class="center" >Best migration in NEW NORMAL era</p>
  </div></div>
  <div class="col-md-3"><div class="neumorphic-box-40 p-3" >
  <div class="center"><img src="/EN/solution/images/KIOSK-SW-APP-MiAirtouch-4.svg" style="width:150px; margin:30px 0px 20px 0px" /></div><br />
  <p class="center" >Convert to Contactless Service from physical</p>
  </div></div>
</div>
<p class="mb-3">&nbsp;</p>
</div></div>


<!--end ComiSmartAirtouch -->






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