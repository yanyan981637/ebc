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
	<meta name="description" content="MiTAC designs, engineers, assembles, deploys and supports self-service Kiosk solutions">
	<meta property="og:type" content="website" />
	<meta property="og:description" content="MiTAC designs, engineers, assembles, deploys and supports self-service Kiosk solutions" />
	<meta property="og:title" content="Kiosks | MiTAC Digital Technology" />
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
  <link rel="stylesheet" href="/css1/stylesheet1.css" type="text/css" />

  <style>

#slider {background:  url('/products/img/KV-kiosks.jpg') no-repeat center center / cover;}
#kiosk-nav {margin-top:-6rem}
#kiosk-nav:hover {cursor: pointer; }
#kiosk-nav .k-on {background:#00428a;}
.k-on h4 {color:#fff}

.bg-1{background: rgb(201,201,201);
background: linear-gradient(100deg, rgba(201,201,201,1) 36%, rgba(229,229,229,1) 36%);}

.bg-2{
background: rgb(201,201,201);
background: linear-gradient(80deg, rgba(201,201,201,1) 36%, rgba(229,229,229,1) 36%);}
.color-blue{color:#0e438b}
.bg-top-line {border-top:1px solid #fff}
.neumorphic-box-40 {border-radius: 40px;
background: #ffffff;
box-shadow:  6px 6px 15px rgba(0, 0, 0, 0.2),
             -6px -6px 15px rgba(255, 255, 255, 0.8); margin:5px 5px 10px 5px}
  </style>

	<script src="/js1/jquery.js"></script>
	<!-- Document Title
	============================================= -->
	<title>Kiosks | MiTAC Digital Technology</title>

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

    <div class="col-lg-3 mb-4 mb-lg-0" onclick="location.href='/products/standard-kiosks#1'">
        <div  class="k-on grid-inner shadow-sm h-shadow p-3 overflow-hidden rounded-5 text-center h-shadow-none">
          <div class="row justify-content-center">
          <div class="col-12" ><h4 class="h4 mb-0" >Standard Kiosks</h4></div>
          </div>
        </div>
	  </div>
    <div class="col-lg-3 mb-4 mb-lg-0" onclick="location.href='/products/custom-kiosks#1'">
        <div class="grid-inner shadow-sm h-shadow bg-white p-3 overflow-hidden rounded-5 text-center shadow-ts">
          <div class="row justify-content-center">
          <div class="col-12" ><h4 class="h4 mb-0" >Custom Kiosks</h4></div>
          </div>
        </div>
	  </div>
    <div class="col-lg-3 mb-4 mb-lg-0" onclick="location.href='/products/kiosks-software-solution#1'">
        <div class="grid-inner shadow-sm h-shadow bg-white p-3 overflow-hidden rounded-5 text-center shadow-ts">
          <div class="row justify-content-center">
          <div class="col-12" ><h4 class="h4 mb-0" >Software Solutions</h4></div>
          </div>
        </div>
	  </div>
    <div class="col-lg-3 mb-4 mb-lg-0" onclick="location.href='/products/kiosks-market-solution#1'">
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
                  <h1>Standard Kiosks</h1>
    </div>

</div>


	<div class="container-fluid" style="background: url(/EN/solution/images/KV-kiosks-std.gif) no-repeat center center; background-size: cover;">
	<div class="container-fluid" >
	<p class="mt-4">&nbsp;</p>


	<div class="row">
	 <div class="col-md-1" ></div>
  <div class="col-md-2 " >
  <div class="neumorphic-box-40 p-3" >
  <a href="#K32F" /><img src="/EN/solution/images/kiosk-K32F.png" alt="Kiosk K32F" class="img-responsive" /></a></div>
  <h4 class="center">K32F</h4>
  </div>
  <div class="col-md-2" >
  <div class="neumorphic-box-40 p-3" >
  <a href="#K23F" /><img src="/EN/solution/images/kiosk-K23F.png" alt="Kiosk K23F" class="img-responsive" /></a></div>
  <h4 class="center">K23F</h4>
  </div>
  <div class="col-md-2" >
  <div class="neumorphic-box-40 p-3" >
  <a href="#K17F" /><img src="/EN/solution/images/kiosk-K17F.png" alt="Kiosk K17F" class="img-responsive" /></a></div>
  <h4 class="center">K17F</h4>
  </div>
  <div class="col-md-2" >
  <div class="neumorphic-box-40 p-3" >
  <a href="#K27D" /><img src="/EN/solution/images/kiosk-K27D.png" alt="Kiosk K27D" class="img-responsive" /></a></div>
  <h4 class="center">K27D</h4>
  </div>
  <div class="col-md-2" >
  <div class="neumorphic-box-40 p-3" >
  <a href="#D210F" /><img src="/EN/solution/images/kiosk-D210F.png" alt="Kiosk D210F" class="img-responsive" /></a></div>
  <h4 class="center">D210F</h4>
  </div>
  <div class="col-md-1" ></div>
</div>




<p class="mt-6">&nbsp;</p>
	</div>
	</div>


<!--K32F-->

<a name="K32F"></a>






<div class="container-fluid bg-1" >

<p class="mt-3">&nbsp;</p>


<div class="container-fluid" >

<div class="row">
  <div class="col-md-4">
  <p style="margin-top:18%"> </p><img src="/EN/solution/images/kiosk-K32F.png" alt="Kiosk K32F" class="img-fluid" />
  <p style="margin-top:18%"> </p>
  </div>
  <div class="col-md-8" style="padding:30px 10px 0px 130px"><h1 style="font-size:52px; font-weight:bold">K32F&nbsp;&nbsp;
  <a href="/EN/contact/"  ><button type="button" class="btn btn-outline-dark btn-lg">Contact Us</button></a>
  </h1>
  <h2 class="color-blue">Floor Standing Model</h2>
  <div>This solution is perfect for those that have moderate floor space so the kiosk can be placed virtually anywhere in the space that is most convenient for the customer, and has access to a power source.<br /><br />
</div>
  <h2 class="color-blue">FEATURE</h2>
  <div class="row">
  <div class="col-md-4">
  <h3 style="border-bottom:1px solid #000">Display</h3><ul style="margin-left:20px">
<li>32" FHD 1920x1080 TFT LCD</li>
<li>High Brightness Support (optional)</li>
<li>True-flat Capacitive Touch Screen</li>
</ul>
  </div>
  <div class="col-md-4">
  <h3 style="border-bottom:1px solid #000">Mother Board</h3><ul style="margin-left:20px">
<li>Intel ATOM / Celeron / Core-i Support</li>
<li>Feature-rich I/O Interface</li>
<li>Windows/ Linux OS support</li>
</ul>
  </div>
  <div class="col-md-4">
  <h3 style="border-bottom:1px solid #000">Optional Components</h3><ul style="margin-left:20px">
<li>2" / 3" Thermal Printer (Option)</li>
<li>WLAN with External Antenna </li>
<li>1D / 2D Bar Code Scanner</li>
<li>HD Web Camera </li>
<li>Stainless Steel shelf</li>
</ul>
  </div>
</div>
 <p style="margin-top:3%"> </p>
  <h2 class="color-blue">Sample Cases</h2>
<ul style="margin-left:20px">
<li>Food-Order Self Order</li>
<li>Hospitality Check-In / Registration</li>
<li>Retail Price Check</li>
<li>Retail Self-Order &amp; Receipting</li>
<li>Event Ticketing</li>
<li>Office Check-In / Registration</li>
</ul>



  </div>
</div>


</div>
</div>


<!--end K32F-->


<!--K23F-->


<a name="K23F"></a>





<div class="container-fluid bg-2 bg-top-line" >
<p class="mt-3">&nbsp;</p>
<div class="container-fluid" >

<div class="row">
  <div class="col-md-4"><p style="margin-top:15%"> </p><img src="/EN/solution/images/kiosk-K23F.png" alt="Kiosk K23F" class="img-fluid" />
  <p style="margin-top:20%"> </p>
  </div>
  <div class="col-md-8" style="padding:30px 10px 0px 130px"><h1 style="font-size:52px; font-weight:bold">K23F&nbsp;&nbsp;
  <a href="/EN/contact/"  ><button type="button" class="btn btn-outline-dark btn-lg">Contact Us</button></a></h1>
  <h2 class="color-blue">Floor Standing Model</h2>
  <div>This solution is perfect for those that have moderate floor space so the kiosk can be placed virtually anywhere in the space that is most convenient for the customer and has access to a power source.<br /><br />
</div>
  <h2 class="color-blue">FEATURE</h2>
  <div class="row">
  <div class="col-md-4">
  <h3 style="border-bottom:1px solid #000">Display</h3><ul style="margin-left:20px">
<li>23" FHD 1920x1080 TFT LCD </li>
<li>High Brightness Support (optional)</li>
<li>True-flat Capacitive Touch Screen</li>
</ul>
  </div>
  <div class="col-md-4">
  <h3 style="border-bottom:1px solid #000">Mother Board</h3><ul style="margin-left:20px">
<li>Intel ATOM / Celeron / Core-i Support</li>
<li>Feature-rich I/O Interface</li>
<li>Windows/ Linux OS support</li>
</ul>
  </div>
  <div class="col-md-4">
  <h3 style="border-bottom:1px solid #000">Optional Components</h3><ul style="margin-left:20px">
<li>2" / 3" Thermal Printer (Option)</li>
<li>WLAN with External Antenna </li>
<li>1D / 2D Bar Code Scanner</li>
<li>HD Web Camera </li>
<li>Stainless Steel shelf</li>
</ul>
  </div>
</div>
 <p style="margin-top:3%"> </p>
  <h2 class="color-blue">Sample Cases</h2>
<ul style="margin-left:20px">
<li>Food-Order Self Order</li>
<li>Hospitality Check-In / Registration</li>
<li>Retail Price Check</li>
<li>Retail Self-Order &amp; Receipting</li>
<li>Event Ticketing</li>
<li>Office Check-In / Registration</li>
</ul>



  </div>
</div>


</div>
</div>

<!--end K23F-->



<!--K17F-->


<a name="K17F"></a>


<div class="container-fluid bg-1 bg-top-line" >
<p class="mt-3">&nbsp;</p>
<div class="container-fluid" >

<div class="row">
  <div class="col-md-4"><p style="margin-top:15%"> </p><img src="/EN/solution/images/kiosk-K17F.png" alt="Kiosk K17F" class="img-fluid" />
  <p style="margin-top:20%"> </p>
  </div>
  <div class="col-md-8" style="padding:30px 10px 0px 130px"><h1 style="font-size:52px; font-weight:bold">K17F&nbsp;&nbsp;
  <a href="/EN/contact/"  ><button type="button" class="btn btn-outline-dark btn-lg">Contact Us</button></a></h1>
  <h2 class="color-blue">Floor Standing Model</h2>
  <div>This solution is perfect for those that have moderate floor space so the kiosk can be placed virtually anywhere in the space that is most convenient for the customer and has access to a power source.<br /><br />
</div>
  <h2 class="color-blue">FEATURE</h2>
  <div class="row">
  <div class="col-md-4">
  <h3 style="border-bottom:1px solid #000">Display</h3><ul style="margin-left:20px">
<li>17" SXGA 1280x1024 TFT LCD</li>
<li>15.6" FHD 1920x1080 TFT LCD</li>
<li>High Brightness Support (optional)</li>
<li>True-flat Capacitive Touch Screen</li>
</ul>
  </div>
  <div class="col-md-4">
  <h3 style="border-bottom:1px solid #000">Mother Board</h3><ul style="margin-left:20px">
<li>Intel ATOM / Celeron / Core-i Support</li>
<li>Feature-rich I/O Interface</li>
<li>Windows/ Linux OS support</li>
</ul>
  </div>
  <div class="col-md-4">
  <h3 style="border-bottom:1px solid #000">Optional Components</h3><ul style="margin-left:20px">
<li>2" / 3" Thermal Printer (Option)</li>
<li>WLAN with External Antenna </li>
<li>1D / 2D Bar Code Scanner</li>
<li>HD Web Camera </li>
<li>Stainless Steel shelf</li>
</ul>
  </div>
</div>
 <p style="margin-top:3%"> </p>
  <h2 class="color-blue">Sample Cases</h2>
<ul style="margin-left:20px">
<li>Food-Order Self Order</li>
<li>Hospitality Check-In / Registration</li>
<li>Retail Price Check</li>
<li>Retail Self-Order &amp; Receipting</li>
<li>Event Ticketing</li>
<li>Office Check-In / Registration</li>
</ul>
  </div>
</div>


</div>
</div>

<!--end K17F-->

<!--K27D-->



<a name="K27D"></a>

<div class="container-fluid bg-2 bg-top-line" >
<p class="mt-3">&nbsp;</p>
<div class="container-fluid" >

<div class="row">
  <div class="col-md-4"><p style="margin-top:15%"> </p><img src="/EN/solution/images/kiosk-K27D.png" alt="Kiosk K27D" class="img-fluid" />
  <p style="margin-top:20%"> </p>
  </div>
  <div class="col-md-8" style="padding:30px 10px 0px 130px"><h1 style="font-size:52px; font-weight:bold">K27D&nbsp;&nbsp;
  <a href="/EN/contact/"  ><button type="button" class="btn btn-outline-dark btn-lg">Contact Us</button></a></h1>
  <h2 class="color-blue">COUNTER-TOP</h2>
  <div>Counter-top kiosks fit on existing counter space without taking up too much width. The rugged design of the larger screen size is more conducive to operation.  <br /><br />
</div>
  <h2 class="color-blue">FEATURE</h2>
  <div class="row">
  <div class="col-md-4">
  <h3 style="border-bottom:1px solid #000">Display</h3><ul style="margin-left:20px">
<li>27" FHD 1920x1080 TFT LCD</li>
<li>High Brightness Support (optional)</li>
<li>True-flat Capacitive Touch Screen</li>
</ul>
  </div>
  <div class="col-md-4">
  <h3 style="border-bottom:1px solid #000">Mother Board</h3><ul style="margin-left:20px">
<li>Intel ATOM / Celeron / Core-i Support</li>
<li>Feature-rich I/O Interface</li>
<li>Windows / Linux OS support</li>
</ul>
  </div>
  <div class="col-md-4">
  <h3 style="border-bottom:1px solid #000">Optional Components</h3><ul style="margin-left:20px">
<li>2" / 3" Thermal Printer (Option)</li>
<li>WLAN with External Antenna </li>
<li>1D / 2D Bar Code Scanner</li>
<li>HD Web Camera </li>
<li>Stainless Steel shelf</li>
</ul>
  </div>
</div>
 <p style="margin-top:3%"> </p>
  <h2 class="color-blue">Sample Cases</h2>
<ul style="margin-left:20px">
<li>Food-Order Self Order</li>
<li>Hospitality Check-In / Registration</li>
<li>Retail Price Check</li>
<li>Retail Self-Order &amp; Receipting</li>
<li>Event Ticketing</li>
<li>Office Check-In / Registration</li>
</ul>



  </div>
</div>


</div>
</div>


<!--end K27D-->




<!--D210F-->

<a name="D210F"></a>


<div class="container-fluid bg-1 bg-top-line" >
<p class="mt-3">&nbsp;</p>
<div class="container-fluid" >
<div class="row">
  <div class="col-md-4"><p style="margin-top:15%"> </p>
  <img src="/EN/solution/images/kiosk-D210F.png" alt="Kiosk D210F" class="img-responsive" />
  <p style="margin-top:20%"> </p>
  </div>
  <div class="col-md-8" style="padding:30px 10px 0px 130px"><h1 style="font-size:52px; font-weight:bold">D210F&nbsp;&nbsp;
  <a href="/EN/contact/"  ><button type="button" class="btn btn-outline-dark btn-lg">Contact Us</button></a>&nbsp;&nbsp;<a href="https://download.mitacmct.com/Files/datasheets/Kiosk/MiTAC-Kiosks-D210F-Datasheet.pdf" target="_blank" /><button type="button" class="btn btn-primary btn-lg">Datasheet</button></a></h1>
  <h2 class="color-blue">COUNTER-TOP</h2>
  <div>Counter-top kiosks fit on existing counter space without taking up too much width.
The rugged design of the larger screen size is more conducive to operation.
<br /><br />
</div>
  <h2 class="color-blue">FEATURE</h2>
  <div class="row">
  <div class="col-md-4">
  <h3 style="border-bottom:1px solid #000">Display</h3><ul style="margin-left:20px">
<li>Industrial-grade 21.5" Full HD TFT LCD with 40,000 backlight lifetime</li>
<li>Front panel IP65-rated, fanless design</li>
<li>Support multiple mounting modules(webcam, NFC/RFID, barcode)</li>
<li>Front panel IP65-rated, fanless design</li>
</ul>
  </div>
  <div class="col-md-4">
  <h3 style="border-bottom:1px solid #000">Mother Board</h3><ul style="margin-left:20px">

<li>Intel® Kaby Lake Core i7/i5/i3 / Celeron ULV processors</li>
<li>Intel® vPro technology support</li>
<li>Windows 10 IoT 2019 support</li>

</ul>
  </div>
  <div class="col-md-4">
  <h3 style="border-bottom:1px solid #000">Optional Components</h3><ul style="margin-left:20px">
<li>WLAN with External Antenna</li>
<li>1D / 2D Bar Code Scanner</li>
<li>5M webcam</li>
<li>MSR reader</li>
<li>RFID reader</li>
<li>2 in 1 SCR reader</li>
</ul>
  </div>
</div>
 <p style="margin-top:3%"> </p>
  <h2 class="color-blue">Sample Cases</h2>
<ul style="margin-left:20px">

<li>Food Order, Self Order</li>
<li>Hospitality Check-In; Registration</li>
<li>Retail Self Order & Receipting</li>
<li>Event Ticketing</li>
<li>Office Check-In / Registration</li>


</ul>
  </div>
</div>


</div>
</div>










<!--end D210F-->




















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