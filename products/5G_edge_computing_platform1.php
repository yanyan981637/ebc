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
	<meta name="description" content="MiTAC's 5G edge computing platforms include 2U/1U edge servers, 2U edge storage, and multi node edge server designed for 5G, AI, and IoT applications.">
	<meta property="og:type" content="website" />
	<meta property="og:description" content="MiTAC's 5G edge computing platforms include 2U/1U edge servers, 2U edge storage, and multi node edge server designed for 5G, AI, and IoT applications." /> 
	<meta property="og:title" content="5G Edge Computing Platforms | MiTAC Computing Technology" />
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


  </style>
	
	<script src="/js1/jquery.js"></script>
	<!-- Document Title
	============================================= -->
	<title>5G Edge Computing Platforms | MiTAC Computing Technology</title>

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
		<section id="slider" class="slider-element" style="background: linear-gradient(to right, rgba(0,0,0, 0.8) 20%, transparent 100%), url('/images/product/bg_5G.jpg') no-repeat center center / cover;">

			<div class="container">
				<div class="row justify-content-between align-items-center">
					<div class="col-lg-8 col-md-9 dark mb-5 mb-md-0 py-5" data-animate="backInLeft">
						<h2 class="display-4" style="font-weight: 600;" >5G Edge Computing Platform</h2>
						<h3 style="color:#18ffff">A Low Latency, High Bandwidth and Capacity solution for network infrastructure</h3>
						<p class="mb-5 lead text-white">MiTAC Edge Computing platforms are a key technology for service providers build up the infrastructure to enable 5G and IoT applications with networking close to the end users. AI in Edge Computing will give people a refreshing experience. It will be driving smart city, home, industry and driving to change our life. </p>
						
						
					</div>
					<div class="col-md-3 d-flex align-self-end align-items-center align-items-lg-end col-form">
						<div class="card  bg-white border-0 w-100 shadow p-3 rounded-0 op-1"  data-animate="backInRight">
							<div class="card-body">
								<h3 class="mb-0 center">
									Edge Server:
								</h3>
								<!--<div class="line line-sm mt-3"></div>-->
								<ul class="iconlist">
								<li><i class="icon-line-chevrons-right"></i> <a href="/EN/contact/" target="mit" />FS2D01 (2U)</a></li>
<li><i class="icon-line-chevrons-right"></i> <a href="/EN/contact/" target="mit" />WS1S01 (1U)</a></li>
<li><i class="icon-line-chevrons-right"></i> <a href="/EN/contact/" target="mit" />WS1S02 (1U)</a></li>
								</ul>
								<h3 class="mb-0 center">
									Multi Node Server:
								</h3>
								<!--<div class="line line-sm mt-3"></div>-->
								<ul class="iconlist">
								<li><i class="icon-line-chevrons-right"></i> <a href="/EN/contact/" target="mit" />AD200</a></li>
<li><i class="icon-line-chevrons-right"></i> <a href="/EN/contact/" target="mit" />AD1S01</a></li>
<li><i class="icon-line-chevrons-right"></i> <a href="/EN/contact/" target="mit" />AD1S02</a></li>
								</ul>
								<h3 class="mb-0 center">
									Edge Storage:
								</h3>
								<!--<div class="line line-sm mt-3"></div>-->
								<ul class="iconlist">
								<li><i class="icon-line-chevrons-right"></i> <a href="/EN/contact/" target="mit" />FS2J01 (2U JBOD)</a></li>
										
								</ul>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>




	<div class="container-fluid m-0 bg-dark-blue">
	<h1 class="center"><span style="font-weight:300; color:#fff; font-size:2rem">2U Edge Server</span> - Firestone family</h1>	
	</div>


<div class="container-fluid m-0 border-0" style="padding: 80px 0">
					<div class="container  clearfix">
<div class="row">
<div class="col-lg-1"></div>
<div class="col-lg-10">
<div class="row">
<div class="col-lg-4">
 <div class="course-card h-100 p-4">
									<a href="/EN/contact/" target="mit" /><img class="card-img-top" src="/images/product/5G/FS2D11.png" alt="CU/MEC Edge Server FS2D11"></a>
									<div class="card-body">
									<h2 class="card-title fw-normal mb-2 center lh2"><a href="/EN/contact/" target="mit" />CU/MEC Edge Server FS2D11</a></h2>
										<h5 class="center">(2) Intel Xeon-SP/ 3rd Gen<br />(6) 2.5" HDD/SSD</h5>
									</div>
	</div>
</div>
<div class="col-lg-4">
 <div class="course-card h-100 p-4">
									<a href="/EN/contact/" target="mit" /><img class="card-img-top" src="/images/product/5G/FS2D01.png" alt="CU/MEC Edge Server FS2D01"></a>
									<div class="card-body">
									<h2 class="card-title fw-normal mb-2 center lh2"><a href="/EN/contact/" target="mit" />CU/MEC Edge Server FS2D01</a></h2>
										<h5 class="center">(2) Intel Xeon-SP/ 2nd Gen<br />(6) 2.5" HDD/SSD</h5>
									</div>
	</div>
</div>
<div class="col-lg-4"></div>
</div>
</div>
<div class="col-lg-1"></div>
	
</div><p class="mb-4">&nbsp;</p>	
</div>
</div>











	<div class="container-fluid m-0 bg-dark-blue">
	<h1 class="center"><span style="font-weight:300; color:#fff; font-size:2rem">2U Edge Storage</span> - Firestorage family</h1>	
	</div>


<div class="container-fluid m-0 border-0" style="padding: 80px 0">
					<div class="container  clearfix">
<div class="row">
<div class="col-lg-1"></div>
<div class="col-lg-10">
<div class="row">
<div class="col-lg-4">
 <div class="course-card h-100 p-4"><div class="card-label-cs">Coming Soon!</div>
 
									<a href="/EN/contact/" target="mit" /><img class="card-img-top" src="/images/product/5G/FS2J01.png" alt="Edge JBOD FS2J01"></a>
									<div class="card-body">
									<h2 class="card-title fw-normal mb-2 center lh2" ><a href="/EN/contact/" target="mit" />Edge JBOD FS2J01</a></h2>
										<h5 class="center">2U 11 x 3.5" SAS/SATA</h5>
									</div>
	</div>
</div>
<div class="col-lg-4"></div>
<div class="col-lg-4"></div>
</div>
</div>
<div class="col-lg-1"></div>
	
</div><p class="mb-4">&nbsp;</p>	
</div>
</div>




	<div class="container-fluid m-0 bg-dark-blue">
	<h1 class="center"><span style="font-weight:300; color:#fff; font-size:2rem">1U Edge Server </span> - Whitestone family</h1>	
	</div>


<div class="container-fluid m-0 border-0" style="padding: 80px 0">
					<div class="container  clearfix">
<div class="row">
<div class="col-lg-1"></div>
<div class="col-lg-10">
<div class="row">
<div class="col-lg-4">
 <div class="course-card h-100 p-4"><div class="card-label-cs">Coming Soon!</div>
									<a href="/EN/contact/" target="mit" /><img class="card-img-top" src="/images/product/5G/whitestone.png" alt="DU Server WS1S01"></a>
									<div class="card-body">
									<h2 class="card-title fw-normal mb-2 center lh2" ><a href="/EN/contact/" target="mit" />DU Server WS1S01</a></h2>
										<h5 class="center">Intel Xeon SP 3rd Gen<br />Designed for outdoor</h5>
									</div>
	</div>
</div>
<div class="col-lg-4">
<div class="course-card h-100 p-4"><div class="card-label-cs">Coming Soon!</div>
 
									<a href="/EN/contact/" target="mit" /><img class="card-img-top" src="/images/product/5G/whitestone.png" alt="DU Server WS1S02"></a>
									<div class="card-body">
									<h2 class="card-title fw-normal mb-2 center lh2" ><a href="/EN/contact/" target="mit" />DU Server WS1S02</a></h2>
										<h5 class="center">Intel Xeon D next Gen<br />Designed for outdoor</h5>
									</div>
	</div>
</div>
<div class="col-lg-4"></div>
</div>
</div>
<div class="col-lg-1"></div>
	
</div><p class="mb-4">&nbsp;</p>
</div>
</div>






	<div class="container-fluid m-0 bg-dark-blue">
	<h1 class="center"><span style="font-weight:300; color:#fff; font-size:2rem">Multi Node Server </span> - Aowanda family </h1>	
	</div>


<div class="container-fluid m-0 border-0" style="padding: 80px 0">
					<div class="container  clearfix">
<div class="row">
<div class="col-lg-1"></div>
<div class="col-lg-10">
<div class="row">
<div class="col-lg-4">
 <div class="course-card h-100 p-4">
									<a href="/5GEdgeComputing_AD211_AD1S01" target="mit" /><img class="card-img-top" src="/images/product/5G/AD200.png" alt="CU/DU Edge Server AD200"></a>
									<div class="card-body">
									<h2 class="card-title fw-normal mb-2 center lh2" ><a href="/5GEdgeComputing_AD211_AD1S01" target="mit" />CU/DU Edge Server AD200</a></h2>
										<h5 class="center">2U 3 nodes<br />Intel Xeon SP 3rd Gen</h5>
									</div>
	</div>
</div>
<div class="col-lg-4">
<div class="course-card h-100 p-4"><a href="/5GEdgeComputing_AD211_AD1S01" target="mit" /><img class="card-img-top" src="/images/product/5G/Aowanda_Sled.png" alt="1U Edge Server Sled AD1S01"></a>
									<div class="card-body">
									<h2 class="card-title fw-normal mb-2 center lh2" ><a href="/5GEdgeComputing_AD211_AD1S01" target="mit" />1U Edge Server Sled AD1S01</a></h2>
										<h5 class="center">Intel Xeon SP 3rd Gen<br />OCP 3.0 slot / 2 E1.S SSD</h5>
									</div>
	</div>
</div>
<div class="col-lg-4">
<div class="course-card h-100 p-4"><a href="/5GEdgeComputing_AD211_AD1S02" target="mit" /><img class="card-img-top" src="/images/product/5G/Aowanda_Sled-AD1S02.png" alt="1U Edge Server Sled AD1S02"></a>
									<div class="card-body">
									<h2 class="card-title fw-normal mb-2 center lh2" ><a href="/5GEdgeComputing_AD211_AD1S02" target="mit" />1U Edge Server Sled AD1S02</a></h2>
										<h5 class="center">Intel Xeon SP 3rd Gen<br />2 PCIe Slot </h5>
									</div>
	</div>
</div>
</div>
</div>
<div class="col-lg-1"></div>
	
</div><p class="mb-4">&nbsp;</p>
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