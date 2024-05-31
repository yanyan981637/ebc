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
	<meta name="description" content="MiTAC provides customized kiosk designs or high quality, low cost and easy maintenance.">
	<meta property="og:type" content="website" />
	<meta property="og:description" content="MiTAC provides customized kiosk designs or high quality, low cost and easy maintenance." /> 
	<meta property="og:title" content="Custom Kiosks | MiTAC Computing Technology" />
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


.color-blue{color:#0e438b}


.padding10{padding:20px 20px}

.neumorphic-box-kv {border:0px; border-radius: 50px; padding:25px 50px;background-color: rgba(0, 0, 0, 0.5); color:#ffffff; box-shadow:  10px 10px 20px rgba(104, 104, 104, 0.4), 
-10px -10px 20px rgba(0, 0, 0, 0.2); }
.txt32{color:#ffffff; font-weight:bold; font-size:2rem}

  </style>
	
	<script src="/js1/jquery.js"></script>
	<!-- Document Title
	============================================= -->
	<title>Custom Kiosks | MiTAC Computing Technology</title>

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
        <div class="grid-inner shadow-sm h-shadow bg-white p-3 overflow-hidden rounded-5 text-center shadow-ts">
          <div class="row justify-content-center">
          <div class="col-12" ><h4 class="h4 mb-0" >Standard Kiosks</h4></div>
          </div>
        </div>
	  </div>

	  
	 <div class="col-lg-3 mb-4 mb-lg-0" onclick="location.href='/products/custom-kiosks#1'">
        <div  class="k-on grid-inner shadow-sm h-shadow p-3 overflow-hidden rounded-5 text-center  h-shadow-none">
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
                  <h1>Custom Kiosks</h1>
    </div>

</div>



	<div class="container-fluid" style="background:#f8f8f8;">
	<div class="container" >
	<div class="row"> 
	<p class="mt-3">&nbsp;</p>
		  <div class="col-md-6">
		  <h1 class="color-blue">Customer Needs Kiosk Design</h1>
		  <p>We help our clients create better experiences for their customers by design for high quality, design for low cost and design for easy maintenance. Our custom, fast-to-market kiosk solutions help businesses growth, enabling your product to every corner of the world.</p>
		  </div>
		  <div class="col-md-6">
		  <img src="/EN/solution/images/Custom-Kiosks-intro.jpg" class="img-fluid" />
		  <p class="mt-3">&nbsp;</p>
		  </div>
	</div>
	</div>
	</div>
	

	<div class="container-fluid" style="background:#ffffff; border:1px solid #ffffff">
	<div class="container" >
	<p class="mt-3">&nbsp;</p>
	<h1 class="color-blue">Collaboration</h1>
	<p>At MiTAC, we have delicate and experienced team for every project. Our experienced ID / technical consultants take involvement to design customer-oriented, high quality and cost-effective Kiosk after listening and absorbing customer expectations.</p><br /><br />
	<div class="center"><img src="/EN/solution/images/Custom-Kiosks-Collaboration.svg" alt="Custom Kiosks" style="width:600px" /></div>
	<p class="mt-4">&nbsp;</p></div>
	</div>
	
	<div class="container-fluid mb-0" style="background:#f8f8f8; border:1px solid #f8f8f8">
	<p class="mt-2">&nbsp;</p>
	<div class="container  mb-0" ><h1 class="color-blue">Design Thinking</h1></div>
	</div>

<div class="container-fluid" style="background: url(/EN/solution/images/Custom-Kiosks-DTBG.jpg) no-repeat center center; background-size: cover; border:0px solid #c00">

<div class="container" >
<div class="row p-6">
  <div class="col-md-3 mb-2">
  <div class="neumorphic-box-kv p-1" >
  <div class="center p-5"><img src="/EN/solution/images/Custom-Kiosks-DT-1.svg" style="width:130px;"  /></div>
  <p class="center txt32" >Retail</p>
  </div>
  </div>
  <div class="col-md-3 mb-2">
  <div class="neumorphic-box-kv p-1" >
  <div class="center p-5"><img src="/EN/solution/images/Custom-Kiosks-DT-2.svg" style="width:130px; margin-bottom:15px"  /></div>
  <p class="center txt32">Hospitality</p>
  </div>
  </div>
  <div class="col-md-3 mb-2">
  <div class="neumorphic-box-kv p-1" >
  <div class="center p-5"><img src="/EN/solution/images/Custom-Kiosks-DT-3.svg" style="width:130px; margin-bottom:15px"  /></div>
  <p class="center txt32">Banking</p>
  </div>
  </div>
  <div class="col-md-3 mb-2">
  <div class="neumorphic-box-kv p-1" >
  <div class="center p-5"><img src="/EN/solution/images/Custom-Kiosks-DT-4.svg" style="width:130px; margin-bottom:30px"  /></div>
  <p class="center txt32">Ticketing</p>
  </div>
  </div>
</div>
</div>

</div>
<div class="container-fluid" style="background:#f8f8f8; border:1px solid #f8f8f8">
 <p class="mt-4">&nbsp;</p>
<div class="container-fluid" >
<div class="row">
  <div class="col-md-4 mb-2">
  <h3 class="center">Industrial & Time To Market Design</h3>
  <img src="/EN/solution/images/Custom-Kiosks-DT-5.jpg" alt="Custom Kiosks" class="img-fluid" /><br />
  <p class="p-2">MiTAC's  industrial designers turn the concepts from customer draft idea into reality in abundant successful cases. Plus, MiTAC have own-brand, various and ready embedded MB solutions help customer Kiosk product can be fast-to-market.</p>
  </div>
  <div class="col-md-4 mb-2">
  <h3 class="center">Engineering</h3>
  <img src="/EN/solution/images/Custom-Kiosks-DT-6.jpg" alt="Custom Kiosks" class="img-fluid" /><br />
  <p class="p-2">MiTAC's experienced engineers conclude customer requirement and create a fully precise 3D CAD model, considering design for cost-effective design and design for easy maintenance throughout the Kiosk mechanism.</p>
  </div>
  <div class="col-md-4 mb-2">
  <h3 class="center">Manufacturing & Field Installation</h3>
  <img src="/EN/solution/images/Custom-Kiosks-DT-7.jpg" alt="Custom Kiosks" class="img-fluid" /><br />
  <p class="p-2">MiTAC provide geo support options of manufacturing and field installation according to customer preference, the geo options could be at EU, US, China and TW.</p>
  </div>
</div>


</div>
<p class="mt-6">&nbsp;</p>
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