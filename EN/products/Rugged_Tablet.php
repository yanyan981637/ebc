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

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase) or die("Could not connect: " . mysqli_error());
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');

if($_COOKIE["status"]==""){
  //$s_cookie="";
}else{
  $s_cookie=$_COOKIE['status'];
}

$SKU="Cappuccino";
$compareTypeID="114";
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name='author' content='MiTAC Digital Technology'>
<meta name="company" content="MiTAC Digital Technology">
<meta name="description" content="MiTAC's Windows 10 rugged tablet is designed for vertical and retail markets.">
<meta property="og:type" content="website" />
<meta property="og:description" content="MiTAC's Windows 10 rugged tablet is designed for vertical and retail markets." />
<meta property="og:title" content="Tablet | MiTAC Digital Technology" />
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

.bg-dark-blue {background-color:#0D47A1; border:1px solid #0D47A1}
.bg-dark-blue h1 {color:#ffffff; padding: 1.6rem 1rem 0rem}

</style>

<script src="/js1/jquery.js"></script>
<!-- Document Title
============================================= -->
<title>Tablet | MiTAC Digital Technology</title>

<?php
	//************ google analytics ************
	// if($s_cookie!=2){
	//   include_once("analyticstracking.php");
	// }
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
		<section id="slider" class="slider-element" style="background: linear-gradient(to right, rgba(0,0,0, 0.8) 20%, transparent 100%), url('/images/product/bg_POS.jpg') no-repeat center center / cover;">

			<div class="container">
				<div class="row justify-content-between align-items-center">
					<div class="col-lg-8 col-md-9 dark mb-5 mb-md-0 py-5">
						<h2 class="display-4" style="font-weight: 600;" data-animate="backInLeft">Rugged Tablet</h2>
						<p class="ls2" style="font-weight: 300; font-size:2rem; line-height:0rem" data-animate="backInLeft">MiTAC Windows 10 Rugged Tablet</p>
						<p class="mb-5 lead text-white" data-animate="backInLeft">Born to be the Best Mobile Solution for Vertical and Retail Market</p>


					</div>
					<div class="col-md-3 d-flex align-self-end align-items-center align-items-lg-end col-form">
						<div class="card  bg-white border-0 w-100 shadow p-3 rounded-0 op-09" >
							<div class="card-body">
								<h3 class="mb-0 center">
									New products:
								</h3>
								<div class="line line-sm mt-3"></div>
								<ul class="iconlist">
									<li><i class="icon-line-chevrons-right"></i> <a href="/POS_Cappuccino_Cappuccino" />Cappuccino</a></li>
								</ul>

							</div>
						</div>
					</div>
				</div>
			</div>
		</section>





		<div class="container-fluid m-0 bg-dark-blue">
			<h1 class="center">Cappuccino</h1>
		</div>


		<!--Cappuccino-->

		<div class="container-fluid m-0 border-0" style="padding: 80px 0; ">
			<div class="container  clearfix mb-5">
				<div class="row mt-2 ">

					<div class="col-lg-6" >
						<h1 class="ls1"><a href="/POS_Cappuccino_Cappuccino" target="mit" />Cappuccino</a></h1>
						<h3 style="">Intel® Pentium N4200</h3>
						<ul class="leftmargin-sm">
							<li>11.6" Windows® Tablet w/ 2K Resolution</li>
							<li>Extra Light (&lt;900g w/ entry SKU)</li>
							<li>IP65</li>
							<li>MIL-STD-810G on 1.2M Drop Proof, S&V, High/Low Temperature</li>
							<li>Hot-Swappable Battery</li>
							<li>Honeywell Software Decode Scanner 1D/2D (Optional)</li>
							<li>WiFi ac/a/b/g/n, GPS & LTE(Support by Request)</li>
							<li>NFC Module</li>
							<li>HW TPM 2.0 FIPS 140-2 Level 2 Compliance</li>
							<li>Adjustable View-angle Docking Station </li>
							<li>Accessory for Cable Cover w/ Docking Station, I/O Connectivity, Vehicle Mounting VESA 75mm, charging battery</li>
						</li>
					</ul>

					<a href="/POS_Cappuccino_Cappuccino" class="button button-border button-circle">Details</a>&nbsp;&nbsp;&nbsp;
					<a href="javascript:void(0);" class="button button-border button-circle" onclick="AddRFQ('<?=$SKU?>','<?=$compareTypeID?>')"><i class="icon-line-dollar-sign"></i>Request Quote</a>


					<p class="mb-4">&nbsp;</p>
				</div>
				<div class="col-lg-6 p-4" ><a href="/POS_Cappuccino_Cappuccino"><img src="/images/product/POS/Cappuccino-landing.jpg" class="img-fluid mt-6 mb-3"  /></a><br>
					<img src="/images/logo/Apollo-Lake-Pentium.jpg" class="img-fluid"  />

				</div>

			</div>

		</div>
	</div>





	<!--End Cappuccino-->


<!-- add quote sone msg Modal -->
<div id="addqtomsg" class="modal fade compare-alert-modal" tabindex="-1" role="dialog" aria-labelledby="centerModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<div class="block mx-auto" style="background-color: #FFF; max-width: 500px;">
					<div class="feature-box fbox-center fbox-effect fbox-lg border-bottom-0 mb-0" style="padding: 40px;">
						<div class="fbox-icon">
							<i class="icon-ok i-alt"></i>
						</div>
						<div class="fbox-content">
							<h3>Success!<span class="subtitle">Your requested quote has been added to the list. Click &nbsp;&nbsp;"<img src="/images/quote-icon.gif" />"&nbsp;&nbsp; on the top-right navigation bar to continue.</span></h3>
							<img src="/images/quote-nav-bar.gif" />
						</div>
					</div>
					<div class="section center m-0" style="padding: 30px;">
						<button type="button" class="button" data-bs-dismiss="modal" aria-hidden="true">Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end add quote sone msg Modal -->



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