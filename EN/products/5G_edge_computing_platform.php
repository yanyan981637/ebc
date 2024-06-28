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

$PType="115";
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name='author' content='MiTAC Digital Technology'>
	<meta name="company" content="MiTAC Digital Technology">
	<meta name="description" content="MiTAC's 5G edge computing platforms include 2U/1U edge servers, 2U edge storage, and multi node edge server designed for 5G, AI, and IoT applications.">
	<meta property="og:type" content="website" />
	<meta property="og:description" content="MiTAC's 5G edge computing platforms include 2U/1U edge servers, 2U edge storage, and multi node edge server designed for 5G, AI, and IoT applications." />
	<meta property="og:title" content="5G Edge Computing Platforms | MiTAC Digital Technology" />
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







	.floating-contact-wrap {
		position: fixed;
		right: 50px;
		bottom: 60px;
		z-index: 299;
		-webkit-transition: right .2s ease;
		-o-transition: right .2s ease;
		transition: right .2s ease;
	}

	.stretched .floating-contact-wrap + #gotoTop { bottom: 100px; }

	.floating-contact-wrap .floating-contact-btn {
		position: absolute;
		left: 0;
		top: 0;
		width: 60px;
		height: 60px;
		border-radius: 60px;
		background-color: #e4007f;
		color: #FFF;
		cursor: pointer;
		z-index: 3;
		-webkit-transform: translate(-50%, -50%);
		transform: translate(-50%, -50%);
		transition: transform .3s ease;
	}

	.floating-contact-wrap .floating-contact-btn:hover,
	.floating-contact-wrap.active .floating-contact-btn {
		-webkit-transform: translate(-50%, -50%) scale(1.1);
		transform: translate(-50%, -50%) scale(1.1);
		background-color: #222;
	}

	.floating-contact-wrap .floating-contact-btn .floating-contact-icon {
		position: absolute;
		top: 50%;
		left: 50%;
		font-size: 26px;
		-webkit-transition: .3s cubic-bezier(0.645, 0.045, 0.355, 1.000);
		transition: .3s cubic-bezier(0.645, 0.045, 0.355, 1.000);
		-webkit-transition-property: opacity, -webkit-transform;
		transition-property: opacity, transform;
		-webkit-transform: translate(-50%, -50%);
		transform: translate(-50%, -50%);
		-webkit-backface-visibility: hidden;
	}

	.floating-contact-wrap .floating-contact-btn .floating-contact-icon.btn-active,
	.floating-contact-wrap.active .floating-contact-btn .floating-contact-icon {
		opacity: 0;
		-webkit-transform: translate(-50%, -50%);
		transform: translate(-50%, -50%);
	}

	.floating-contact-wrap.active .floating-contact-btn .floating-contact-icon.btn-active {
		opacity: 1;
		-webkit-transform: translate(-50%, -50%) rotate(-45deg);
		transform: translate(-50%, -50%) rotate(-45deg);
	}

	.floating-contact-wrap .floating-contact-box {
		opacity: 0;
		position: absolute;
		right: 0;
		bottom: 0;
		width: 320px;
		background-color: #fff;
		border-radius: 6px;
		z-index: 1;
		-webkit-transform-origin: right bottom;
		transform-origin: right bottom;
		box-shadow: 0px 0px 13px 3px rgba(0,0,0,0.07);
		-webkit-transform: scale(.01);
		transform: scale(.01);
		-webkit-transition: all .3s cubic-bezier(0.645, 0.045, 0.355, 1.000);
		transition: all .3s cubic-bezier(0.645, 0.045, 0.355, 1.000);
		-webkit-backface-visibility: hidden;
	}

	.floating-contact-wrap.active .floating-contact-box {
		opacity: 1;
		-webkit-transform: scale(1);
		transform: scale(1);
	}


	</style>

	<script src="/js1/jquery.js"></script>
	<!-- Document Title
	============================================= -->
	<title>5G Edge Computing Platforms | MiTAC Digital Technology</title>
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
		<section id="slider" class="slider-element" style="background: linear-gradient(to right, rgba(0,0,0, 0.8) 20%, transparent 100%), url('/images/product/bg_5G.jpg') no-repeat center center / cover;">

			<div class="container">
				<div class="row justify-content-between align-items-center">
					<div class="col-lg-8 col-md-9 dark mb-5 mb-md-0 py-5" data-animate="backInLeft">
						<h2 class="display-4" style="font-weight: 600;" >5G Edge Computing Platform</h2>
						<h3 style="color:#18ffff">A Low Latency, High Bandwidth and Capacity solution for network infrastructure</h3>
						<p class="mb-5 lead text-white">MiTAC Edge Computing platforms are a key technology for service providers build up the infrastructure to enable 5G and IoT applications with networking close to the end users. AI in Edge Computing will give people a refreshing experience. It will be driving smart city, home, industry and driving to change our life. </p>


					</div>
					<div class="col-md-3 d-flex align-self-end align-items-center align-items-lg-end col-form">
						<div class="card  bg-white border-0 w-100 shadow p-3 rounded-0 op-09"  data-animate="backInRight">
							<div class="card-body">
								<h3 class="mb-0 center">
									Edge Server:
								</h3>
								<!--<div class="line line-sm mt-3"></div>-->
								<ul class="iconlist">
									<li><i class="icon-line-chevrons-right"></i> <a href="/5GEdgeComputing_FS2D11_FS2D11" target="mit" />FS2D11 (2U)</a></li>
									<li><i class="icon-line-chevrons-right"></i> <a href="/5GEdgeComputing_WS1S01_WS1S01" target="mit" />WS1S01 (1U)</a></li>
								</ul>
								<h3 class="mb-0 center">
									Multi Node Server:
								</h3>
								<!--<div class="line line-sm mt-3"></div>-->
								<ul class="iconlist">
									<li><i class="icon-line-chevrons-right"></i> <a href="/5GEdgeComputing_AD211_AD1S01" target="mit" />AD1S01 (2U)</a></li>
									<li><i class="icon-line-chevrons-right"></i> <a href="/5GEdgeComputing_AD211_AD1S02" target="mit" />AD1S02 (2U)</a></li>
								</ul>


							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
<div class="container-fluid" style="background-color:#eaf5fd">
<div class="container" style="padding: 3% 15%; ">
<div style="text-align:center">
<h3><span style="font-size:2rem">MiTAC's 5G End-To-End product family -</span> <br>Firestone2 5G Core, Aowanda Central Unit, and Whitestone Distributed Units.</h3>
<div class="ratio-16x9"><iframe allowfullscreen="" class="ratio" height="315" src="https://www.youtube.com/embed/JZ2xJ-Pv0-Y" title="YouTube video player" width="560"></iframe></div>

</div>
</div>
</div>

		<div class="container-fluid m-0 bg-dark-blue">
			<h1 class="center"><span style="font-weight:300; color:#fff; font-size:2rem">2U Edge Server</span> - Firestone family</h1>
		</div>


		<div class="container-fluid m-0 border-0" style="padding: 80px 0">
			<div class="container-fluid  clearfix">
				<div class="row">
					<div class="col-lg-1"></div>
					<div class="col-lg-10">
						<div class="row">
							<div class="col-lg-4">
								<div class="course-card h-100 p-4">
									<a href="/5GEdgeComputing_FS2D11_FS2D11" target="mit" /><img class="card-img-top" src="/images/product/5G/FS2D11.png" alt="CU/MEC Edge Server FS2D11"></a>
									<div class="card-body center">
										<h2 class="card-title fw-normal mb-2 center lh2"><a href="/5GEdgeComputing_FS2D11_FS2D11" target="mit" />CU/MEC Edge Server FS2D11</a></h2>
										<h5 class="center">(2) Intel Xeon-SP/ 3rd Gen<br />(6) 2.5" HDD/SSD</h5>
										<div class="button button-mini button-border button-circle mt-1" onclick="add_compare('FS2D11','<?=$PType?>')"><i class="icon-line-plus"></i>Compare</div>&nbsp;
										<div class="button button-mini button-border button-circle mt-1" onclick="AddRFQ('FS2D11','<?=$PType?>')"><i class="icon-line-dollar-sign"></i>Request Quote</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<!--<div class="course-card h-100 p-4">
									<a href="/EN/contact/" target="mit" /><img class="card-img-top" src="/images/product/5G/FS2D01.png" alt="CU/MEC Edge Server FS2D01"></a>
									<div class="card-body center">
										<h2 class="card-title fw-normal mb-2 center lh2"><a href="/EN/contact/" target="mit" />CU/MEC Edge Server FS2D01</a></h2>
										<h5 class="center">(2) Intel Xeon-SP/ 2nd Gen<br />(6) 2.5" HDD/SSD</h5>

									</div>-->
								</div>
							</div>
							<div class="col-lg-4"></div>
						</div>
					</div>
					<div class="col-lg-1"></div>

				</div><p class="mb-4">&nbsp;</p>
			</div>
		</div>










<!--
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
	</div>-->




	<div class="container-fluid m-0 bg-dark-blue">
		<h1 class="center"><span style="font-weight:300; color:#fff; font-size:2rem">1U Edge Server </span> - Whitestone family</h1>
	</div>


	<div class="container-fluid m-0 border-0" style="padding: 80px 0">
		<div class="container-fluid  clearfix">
			<div class="row">
				<div class="col-lg-1"></div>
				<div class="col-lg-10">
					<div class="row">
						<div class="col-lg-4">
							<div class="course-card h-100 p-4">
							<a href="/5GEdgeComputing_WS1S01_WS1S01" target="mit" /><img class="card-img-top" src="/images/product/5G/whitestone.png" alt="DU Server WS1S01"></a>
							<div class="card-body center">
								<h2 class="card-title fw-normal mb-2 center lh2" ><a href="/5GEdgeComputing_WS1S01_WS1S01" target="mit" />DU Server WS1S01</a></h2>
								<h5 class="center">Intel Xeon SP 3rd Gen<br />Designed for outdoor</h5>
								<div class="button button-mini button-border button-circle mt-1" onclick="add_compare('WS1S01','<?=$PType?>')"><i class="icon-line-plus"></i>Compare</div>&nbsp;
								<div class="button button-mini button-border button-circle mt-1" onclick="AddRFQ('WS1S01','<?=$PType?>')"><i class="icon-line-dollar-sign"></i>Request Quote</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="course-card h-100 p-4"><!--<div class="card-label-cs">Coming Soon!</div>-->

						<a href="/5GEdgeComputing_WS1S12_WS1S12" target="mit" /><img class="card-img-top" src="/images/product/5G/whitestone.png" alt="5G CU/DU Server WS1S11"></a>
						<div class="card-body center">
							<h2 class="card-title fw-normal mb-2 center lh2" ><a href="/5GEdgeComputing_WS1S12_WS1S12" target="mit" />5G CU/DU Server WS1S11</a></h2>
							<h5 class="center">Intel Xeon SP 4th Gen<br />Timing & Synchronization Support</h5>
							<div class="button button-mini button-border button-circle mt-1" onclick="add_compare('WS1S11','<?=$PType?>')"><i class="icon-line-plus"></i>Compare</div>&nbsp;
								<div class="button button-mini button-border button-circle mt-1" onclick="AddRFQ('WS1S11','<?=$PType?>')"><i class="icon-line-dollar-sign"></i>Request Quote</div>

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
	<div class="container-fluid  clearfix">
		<div class="row">
			<div class="col-lg-1"></div>
			<div class="col-lg-10">
				<div class="row">
					<div class="col-lg-4">
						<div class="course-card h-100 p-4">
							<a href="/5GEdgeComputing_AD211_AD1S01" target="mit" /><img class="card-img-top" src="/images/product/5G/AD200.png" alt="CU/DU Edge Server AD200"></a>
							<div class="card-body center">
								<h2 class="card-title fw-normal mb-2 center lh2" ><a href="/5GEdgeComputing_AD211_AD1S01" target="mit" />CU/DU Edge Server AD211</a></h2>
								<h5 class="center">2U 3 nodes<br />Intel Xeon SP 3rd Gen</h5>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="course-card h-100 p-4"><a href="/5GEdgeComputing_AD211_AD1S01" target="mit" /><img class="card-img-top" src="/images/product/5G/Aowanda_Sled.png" alt="1U Edge Server Sled AD1S01"></a>
							<div class="card-body center">
								<h2 class="card-title fw-normal mb-2 center lh2" ><a href="/5GEdgeComputing_AD211_AD1S01" target="mit" />1U Edge Server Sled AD1S01</a></h2>
								<h5 class="center">Intel Xeon SP 3rd Gen<br />OCP 3.0 slot / 2 E1.S SSD</h5>
								<div class="button button-mini button-border button-circle mt-1" onclick="add_compare('AD1S01','<?=$PType?>')"><i class="icon-line-plus"></i>Compare</div>&nbsp;
								<div class="button button-mini button-border button-circle mt-1" onclick="AddRFQ('AD1S01','<?=$PType?>')"><i class="icon-line-dollar-sign"></i>Request Quote</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="course-card h-100 p-4"><a href="/5GEdgeComputing_AD211_AD1S02" target="mit" /><img class="card-img-top" src="/images/product/5G/Aowanda_Sled-AD1S02.png" alt="1U Edge Server Sled AD1S02"></a>
							<div class="card-body center">
								<h2 class="card-title fw-normal mb-2 center lh2" ><a href="/5GEdgeComputing_AD211_AD1S02" target="mit" />1U Edge Server Sled AD1S02</a></h2>
								<h5 class="center">Intel Xeon SP 3rd Gen<br />2 PCIe Slot </h5>
								<div class="button button-mini button-border button-circle mt-1" onclick="add_compare('AD1S02','<?=$PType?>')"><i class="icon-line-plus"></i>Compare</div>&nbsp;
								<div class="button button-mini button-border button-circle mt-1" onclick="AddRFQ('AD1S02','<?=$PType?>')"><i class="icon-line-dollar-sign"></i>Request Quote</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-1"></div>

		</div><p class="mb-4">&nbsp;</p>
	</div>
</div>




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

<!-- Floating Contact
	============================================= -->
	<div class="floating-contact-wrap">
		<div class="floating-contact-btn shadow">
			<i class="floating-contact-icon btn-unactive icon-chat-3"></i>
			<i class="floating-contact-icon btn-active icon-line-plus"></i>
		</div>
		<div class="floating-contact-box">



				<div class="floating-contact-heading p-2 " style="background-color: #e4007f; color:#fff">


				<div class="container mb-0">
						<div class="row align-items-center mb-0">
							<div class="col-8 col-md">
								<p class="mb-0"><i class="icon-robot"></i>&nbsp;&nbsp;MiTAC Chatbot</p>
							</div>
							<div class="col-4 col-md-auto mt-0 mt-lg-0 mb-0">
							<div style="float:right">
							<div class="btn-group">
								<button type="button" class="btn btn-lg dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:#fff">
									<!--<i class="icon-line-align-justify"></i>-->
								</button>
								<div class="dropdown-menu">
									<a class="dropdown-item" href="https://ipc.mitacmdt.com/EN/contact/" target="_blank">Contact Us</a>
									<a class="dropdown-item" href="https://ipc.mitacmdt.com/SupportCenter " target="_blank">Issue a Ticket</a>

								</div>
							</div>
							</div>


							</div>
						</div>
					</div>






			</div>



			<iframe height="450" id="chat"  frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		</div>
	</div>

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

	<script>
	jQuery(document).ready( function($){

		var elementParent = $('.floating-contact-wrap');
		$('.floating-contact-btn').off( 'click' ).on( 'click', function() {
			elementParent.toggleClass('active', );
		});

		document.getElementById("chat").src="https://i-chat02.mic.com.tw/ ";
	});
	</script>
</body>
</html>