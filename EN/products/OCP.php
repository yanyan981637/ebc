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

$PType="110";
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name='author' content='MiTAC Digital Technology'>
	<meta name="company" content="MiTAC Digital Technology">
	<meta name="description" content="MiTAC provides OCP solutions for storage, servers, ESA with great power efficiency.">
	<meta property="og:type" content="website" />
	<meta property="og:description" content="MiTAC provides OCP solutions for storage, servers, ESA with great power efficiency." />
	<meta property="og:title" content="Open Compute Project (OCP) Platforms | MiTAC Digital Technology" />
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
	<link rel="stylesheet" href="/css1/stylesheet1.css" type="text/css" />


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
	.text-black {color:#000000; line-height:1.5rem; text-align:center}


	</style>

	<script src="/js1/jquery.js"></script>
	<!-- Document Title
	============================================= -->
	<title>Open Compute Project (OCP) Platforms | MiTAC Digital Technology</title>
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
		<section id="slider" class="slider-element" style="background: linear-gradient(to right, rgba(0,0,0, 0.5) 20%, transparent 100%), url('/images/product/bg_OCP-2.jpg') no-repeat center center / cover;">

			<div class="container">
				<div class="row justify-content-between align-items-center">
					<div class="col-lg-8 col-md-9 dark mb-5 mb-md-0 py-5" data-animate="backInLeft">
						<h2 class="display-4" style="font-weight: 600;" >Open Compute Project (OCP)</h2>

						<p class="mb-5 lead text-white">
							Starting in 2013, MiTAC began developing our first OCP Computing Project, Leopard. <br /><br />
							Tioga Pass, MiTAC's 2nd generation, provides great improvement in power efficiency and is well recognized by world class telco companies.
							MiTAC was the first to provide the ESA, an Enclosure Sub Assembly, designed to enable standard 19 inch rack users to adopt OCP products and to enjoy great power saving of OCP designs. <br /><br />
							We have broadened our OCP products with a family of Mezzanine cards, and we now deliver OCP Storage solutions!
						</p>


					</div>
					<div class="col-md-3 d-flex align-self-end align-items-center align-items-lg-end col-form">

					</div>
				</div>
			</div>
		</section>




<!--video-->
<div class="container-fluid" style="background-color:#eaf5fd">
<div class="container" style="padding: 3% 15%; ">
<div style="text-align:center">
<h3><span style="font-size:2rem">MiTAC speech at 2022 OCP Global Summit</span> <br>Leveraging OCP Technologies for Edge and Core Cloud Infrastructure Deployments</h3>
<div class="ratio-16x9"><iframe allowfullscreen="" class="ratio" height="315" src="https://www.youtube.com/embed/AMNo9iXj9vQ" title="YouTube video player" width="560"></iframe></div>

</div>
</div>
</div>

<!--end video-->






		<div class="container-fluid m-0 bg-dark-blue">
			<h1 class="center">Server</h1>
		</div>


		<div class="container-fluid m-0 border-0" style="padding: 80px 0">

			<div class="heading-block center">
				<h2>Intel<sup>&reg;</sup> Xeon<sup>&reg;</sup> Server:</h2>
			</div>


			<div class="container-fluid  clearfix">







			<div class="row">
					<div class="col-lg-1"></div>
					<div class="col-lg-10">
						<div class="row">
							<div class="col-lg-4">
								<div class="course-card p-4 center">
									<a href="/OCPserver_GS1D01_GS1D01-S" target="mit" /><img class="card-img-top" src="/images/product/OCPserver/Goldstone_Standard-R1.jpg" alt="Goldstone  GS1D01-S (Standard)"></a>
									<div class="card-body center">
										<h2 class="card-title fw-normal mb-2 center lh2" >Goldstone</h2>
										<div class="text-black"><span  style="font-size:1.5rem"><a href="/OCPserver_GS1D01_GS1D01-S" target="mit" />GS1D01-S</a></span><br /><span style="font-size:1rem" >(Standard)</span></div>
										<h5 class="center">DP OCP Server</h5>
										<div class="button button-mini button-border button-circle mt-1" onclick="add_compare('GS1D01-S', '<?=$PType?>')"><i class="icon-line-plus"></i>Compare</div>&nbsp;
										<div class="button button-mini button-border button-circle mt-1" onclick="AddRFQ('GS1D01-S','<?=$PType?>')"><i class="icon-line-dollar-sign"></i>Request Quote</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="course-card p-4">
									<a href="/OCPserver_GS1D01_GS1D01-U" target="mit" /><img class="card-img-top" src="/images/product/OCPserver/Goldstone_Ultra-R1.jpg" alt="Goldstone GS1D01-U (Ultra)"></a>
									<div class="card-body center">
										<h2 class="card-title fw-normal mb-2 center lh2" >Goldstone</h2>
										<div class="text-black"><span  style="font-size:1.5rem"><a href="/OCPserver_GS1D01_GS1D01-U" target="mit" />GS1D01-U</a></span><br /><span style="font-size:1rem" >(Ultra)</span></div>
										<h5 class="center">DP OCP Server</h5>
										<div class="button button-mini button-border button-circle mt-1" onclick="add_compare('GS1D01-U', '<?=$PType?>')"><i class="icon-line-plus"></i>Compare</div>&nbsp;
										<div class="button button-mini button-border button-circle mt-1" onclick="AddRFQ('GS1D01-U','<?=$PType?>')"><i class="icon-line-dollar-sign"></i>Request Quote</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4">

							</div>
						</div>
					</div>
					<div class="col-lg-1"></div>

				</div>




				<!--<div class="row">
					<div class="col-lg-1"></div>
					<div class="col-lg-10">
						<div class="row">
							<div class="col-lg-4">
								<div class="course-card p-4 center">
									<a href="/OCPserver_E7278_E7278-S" target="mit" /><img class="card-img-top" src="/images/product/OCPserver/E7278-std.jpg" alt="Tioga Pass E7278-S (Standard)"></a>
									<div class="card-body center">
										<h2 class="card-title fw-normal mb-2 center lh2" >Tioga Pass</h2>
										<div class="text-black"><span  style="font-size:1.5rem"><a href="/OCPserver_E7278_E7278-S" target="mit" />E7278-S</a></span><br /><span style="font-size:1rem" >(Standard)</span></div>
										<h5 class="center">SP OCP Server Sled</h5>
										<div class="button button-mini button-border button-circle mt-1" onclick="add_compare('E7278-S', '<?=$PType?>')"><i class="icon-line-plus"></i>Compare</div>&nbsp;
										<div class="button button-mini button-border button-circle mt-1" onclick="AddRFQ('E7278-S','<?=$PType?>')"><i class="icon-line-dollar-sign"></i>Request Quote</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="course-card p-4">
									<a href="/OCPserver_E7278_E7278-A" target="mit" /><img class="card-img-top" src="/images/product/OCPserver/E7278-advanced.jpg" alt="Tioga Pass E7278-A (Advanced)"></a>
									<div class="card-body center">
										<h2 class="card-title fw-normal mb-2 center lh2" >Tioga Pass</h2>
										<div class="text-black"><span  style="font-size:1.5rem"><a href="/OCPserver_E7278_E7278-A" target="mit" />E7278-A</a></span><br /><span style="font-size:1rem" >(Advanced)</span></div>
										<h5 class="center">SP OCP Server Sled</h5>
										<div class="button button-mini button-border button-circle mt-1" onclick="add_compare('E7278-A', '<?=$PType?>')"><i class="icon-line-plus"></i>Compare</div>&nbsp;
										<div class="button button-mini button-border button-circle mt-1" onclick="AddRFQ('E7278-A','<?=$PType?>')"><i class="icon-line-dollar-sign"></i>Request Quote</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="course-card p-4">
									<a href="/OCPserver_E7278_E7278-U" target="mit" /><img class="card-img-top" src="/images/product/OCPserver/E7278-ultra.jpg" alt="Tioga Pass E7278-U (Ultra)"></a>
									<div class="card-body center">
										<h2 class="card-title fw-normal mb-2 center lh2" >Tioga Pass</h2>
										<div class="text-black"><span  style="font-size:1.5rem"><a href="/OCPserver_E7278_E7278-U" target="mit" />E7278-U</a></span><br /><span style="font-size:1rem" >(Ultra)</span></div>
										<h5 class="center">SP OCP Server Sled</h5>
										<div class="button button-mini button-border button-circle mt-1" onclick="add_compare('E7278-U', '<?=$PType?>')"><i class="icon-line-plus"></i>Compare</div>&nbsp;
										<div class="button button-mini button-border button-circle mt-1" onclick="AddRFQ('E7278-U','<?=$PType?>')"><i class="icon-line-dollar-sign"></i>Request Quote</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-1"></div>

				</div>-->
			</div>
		</div>




		<div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;">

			<div class="heading-block center">
				<h2>AMD EPYC&#8482; Server:</h2>
			</div>

			<div class="container-fluid  clearfix">



			<div class="row">
					<div class="col-lg-1"></div>
					<div class="col-lg-10">
						<div class="row">
							<div class="col-lg-4">
								<div class="course-card h-100 p-4">
									<a href="/OCPserver_CP2S11_CP2S11-S" target="mit" /><img class="card-img-top" src="/images/product/OCPserver/Capri2_Standard-R1.jpg" alt="Capri2 CP2S11-S (Standard)"></a>
									<div class="card-body center">
										<h2 class="card-title fw-normal mb-2 center lh2" >Capri2</h2>
										<div class="text-black"><span  style="font-size:1.5rem"><a href="/OCPserver_CP2S11_CP2S11-S" target="mit" />CP2S11-S</a></span><br /><span style="font-size:1rem" >(Standard)</span></div>
										<h5 class="center">SP OCP Server Sled</h5>
										<div class="button button-mini button-border button-circle mt-1" onclick="add_compare('CP2S11-S', '<?=$PType?>')"><i class="icon-line-plus"></i>Compare</div>&nbsp;
										<div class="button button-mini button-border button-circle mt-1" onclick="AddRFQ('CP2S11-S','<?=$PType?>')"><i class="icon-line-dollar-sign"></i>Request Quote</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="course-card h-100 p-4">
									<a href="/OCPserver_CP2S11_CP2S11-U" target="mit" /><img class="card-img-top" src="/images/product/OCPserver/Capri2_Ultra-R1.jpg" alt="Capri2 CP2S11-U (Ultra)"></a>
									<div class="card-body center">
										<h2 class="card-title fw-normal mb-2 center lh2" >Capri2</h2>
										<div class="text-black"><span  style="font-size:1.5rem"><a href="/OCPserver_CP2S11_CP2S11-U" target="mit" />CP2S11-U</a></span><br /><span style="font-size:1rem" >(Ultra)</span></div>
										<h5 class="center">SP OCP Server Sled</h5>
										<div class="button button-mini button-border button-circle mt-1" onclick="add_compare('CP2S11-U', '<?=$PType?>')"><i class="icon-line-plus"></i>Compare</div>&nbsp;
										<div class="button button-mini button-border button-circle mt-1" onclick="AddRFQ('CP2S11-U','<?=$PType?>')"><i class="icon-line-dollar-sign"></i>Request Quote</div>
									</div>
								</div>

							</div>
							<div class="col-lg-4"></div>
						</div>
					</div>
					<div class="col-lg-1"></div>

				</div>





			<p class="mb-4">&nbsp;</p>










				<div class="row">
					<div class="col-lg-1"></div>
					<div class="col-lg-10">
						<div class="row">
							<div class="col-lg-4">
								<div class="course-card h-100 p-4">
									<a href="/OCPserver_E8020_E8020-A" target="mit" /><img class="card-img-top" src="/images/product/OCPserver/E8020-advanced-1.jpg" alt="Capri E8020-A (Advanced)"></a>
									<div class="card-body center">
										<h2 class="card-title fw-normal mb-2 center lh2" >Capri</h2>
										<div class="text-black"><span  style="font-size:1.5rem"><a href="/OCPserver_E8020_E8020-A" target="mit" />E8020-A</a></span><br /><span style="font-size:1rem" >(Advanced)</span></div>
										<h5 class="center">SP OCP Server Sled</h5>
										<div class="button button-mini button-border button-circle mt-1" onclick="add_compare('E8020-A', '<?=$PType?>')"><i class="icon-line-plus"></i>Compare</div>&nbsp;
										<div class="button button-mini button-border button-circle mt-1" onclick="AddRFQ('E8020-A','<?=$PType?>')"><i class="icon-line-dollar-sign"></i>Request Quote</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="course-card h-100 p-4">
									<a href="/OCPserver_E8020_E8020-U" target="mit" /><img class="card-img-top" src="/images/product/OCPserver/E8020-ultra-1.jpg" alt="Capri E8020-U (Ultra)"></a>
									<div class="card-body center">
										<h2 class="card-title fw-normal mb-2 center lh2" >Capri</h2>
										<div class="text-black"><span  style="font-size:1.5rem"><a href="/OCPserver_E8020_E8020-U" target="mit" />E8020-U</a></span><br /><span style="font-size:1rem" >(Ultra)</span></div>
										<h5 class="center">SP OCP Server Sled</h5>
										<div class="button button-mini button-border button-circle mt-1" onclick="add_compare('E8020-U', '<?=$PType?>')"><i class="icon-line-plus"></i>Compare</div>&nbsp;
										<div class="button button-mini button-border button-circle mt-1" onclick="AddRFQ('E8020-U','<?=$PType?>')"><i class="icon-line-dollar-sign"></i>Request Quote</div>
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




		<!--<div class="container-fluid m-0 bg-dark-blue">
			<h1 class="center">Storage</h1>
		</div>


		<div class="container-fluid m-0 border-0" style="padding: 80px 0">
			<div class="container-fluid  clearfix">
				<div class="row">
					<div class="col-lg-1"></div>
					<div class="col-lg-10">
						<div class="row">
							<div class="col-lg-4">
								<div class="course-card h-100 p-4">
									<a href="/JBODJBOF_EST1250_EST1250-U" target="mit" /><img class="card-img-top" src="/images/product/JBODJBOF/EST1250.jpg" alt="Crystal Lake EST1250"></a>
									<div class="card-body center">
										<h2 class="card-title fw-normal mb-2 center lh2" >Crystal Lake</h2>
										<div class="text-black"><span  style="font-size:1.5rem"><a href="/JBODJBOF_EST1250_EST1250-U" target="mit" />EST1250</a></span></div>
										<h5 class="center">OCP JBOF</h5>
										<div class="button button-mini button-border button-circle mt-1" onclick="AddRFQ('EST1250-U','112')"><i class="icon-line-dollar-sign"></i>Request Quote</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="course-card h-100 p-4">
									<a href="/JBODJBOF_EST1250_EST1250-U" target="mit" /><img class="card-img-top" src="/images/product/OCPserver/3Crystal_Lake_SLEDs.jpg" alt="OCP storage"></a>
									<div class="card-body center">
										<div class="text-black"><span  style="font-size:1.5rem"><a href="/JBODJBOF_EST1250_EST1250-U" target="mit" />21" Shelf</a></span></div>
										<h5 class="center">3 Crystal Lake SLEDs for OpenRack v2</h5>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="course-card h-100 p-4">
									<a href="/JBODJBOF_EST1250_EST1250-U" target="mit" /><img class="card-img-top" src="/images/product/OCPserver/2Crystal_Lake_SLEDs.jpg" alt="OCP storage"></a>
									<div class="card-body center">
										<div class="text-black"><span  style="font-size:1.5rem"><a href="/JBODJBOF_EST1250_EST1250-U" target="mit" />19" Shelf</a></span></div>
										<h5 class="center">2 Crystal Lake SLEDs with ESA for EIA rack</h5>
									</div>
								</div>

							</div>
						</div>
					</div>
					<div class="col-lg-1"></div>

				</div><p class="mb-4">&nbsp;</p>
			</div>
		</div>-->






		<div class="container-fluid m-0 bg-dark-blue">
			<h1 class="center">Solution</h1>
		</div>
		<div class="container-fluid m-0 border-0" style="padding: 80px 0">
			<div class="container-fluid  clearfix">
				<div class="row">
					<div class="col-lg-1"></div>
					<div class="col-lg-10">
						<div class="row">
							<div class="col-lg-4">
								<div class="course-card p-4">
									<a href="/EN/products/OCP_SEBA_Solution/" target="mit" /><img class="card-img-top" src="/images/product/OCPserver/OCP_SEBA_Solution.jpg" alt="SEBA Solution"></a>
									<div class="card-body">
										<h2 class="card-title fw-normal mb-2 center lh2" ><a href="/EN/products/OCP_SEBA_Solution/" target="mit" />SEBA&#8482; Solution</a></h2>

										<h5 class="center">OCP SEBA&#8482; Solution</h5>
									</div>
								</div>
							</div>
							<div class="col-lg-4">

							</div>
							<div class="col-lg-4">

							</div>
						</div>
					</div>
					<div class="col-lg-1"></div>

				</div>
			</div>
		</div>





		<div class="container-fluid m-0 bg-dark-blue">
			<h1 class="center">Rack</h1>
		</div>
		<div class="container-fluid m-0 border-0" style="padding: 80px 0">
			<div class="container-fluid  clearfix">
				<div class="row">
					<div class="col-lg-1"></div>
					<div class="col-lg-10">
						<div class="row">
							<div class="col-lg-4">
								<div class="course-card p-4 center">
									<a href="/OCPRack_ESA_ESA" target="mit" /><img class="card-img-top" src="/images/product/OCPrack/ESA.jpg" alt="ESA Kit"></a>
									<div class="card-body">
										<h2 class="card-title fw-normal mb-2 center lh2" ><a href="/OCPRack_ESA_ESA" target="mit" />ESA Kit</a></h2>
										<h5 class="center">Install OCP Sled into 19" EIA Rack</h5>
										<div class="button button-mini button-border button-circle mt-1" onclick="AddRFQ('ESA','113')"><i class="icon-line-dollar-sign"></i>Request Quote</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4">

							</div>
							<div class="col-lg-4">

							</div>
						</div>
					</div>
					<div class="col-lg-1"></div>

				</div>
			</div>
		</div>





		<!--<div class="container-fluid m-0 bg-dark-blue">
			<h1 class="center">Mezzanine</h1>
		</div>
		<div class="container-fluid m-0 border-0" style="padding: 80px 0">
			<div class="container-fluid  clearfix">
				<div class="row">
					<div class="col-lg-1"></div>
					<div class="col-lg-10">
						<div class="row">
							<div class="col-lg-4">
								<div class="course-card h-100 p-4">
									<a href="/OCPMezz_ML41202-P_ML41202-P" target="mit" /><img class="card-img-top" src="/images/product/OCPMezz/ML41202-P.jpg" alt="ML41202-P"></a>
									<div class="card-body center">
										<h2 class="card-title fw-normal mb-2 center lh2" >ML41202-P</h2>
										<h5 class="center">2 X 25G OCP 2.0 Mezzanine</h5>
										<div class="button button-mini button-border button-circle mt-1" onclick="add_compare('ML41202-P', '111')"><i class="icon-line-plus"></i>Compare</div>&nbsp;
										<div class="button button-mini button-border button-circle mt-1" onclick="AddRFQ('ML41202-P','111')"><i class="icon-line-dollar-sign"></i>Request Quote</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="course-card h-100 p-4">
									<a href="/OCPMezz_ML45604-2Q_ML45604-2Q" target="mit" /><img class="card-img-top" src="/images/product/OCPMezz/ML45604-2Q.jpg" alt="ML45604-2Q"></a>
									<div class="card-body center">
										<h2 class="card-title fw-normal mb-2 center lh2" >ML45604-2Q</h2>
										<h5 class="center">2 X 40G OCP 2.0 Mezzanine</h5>
										<div class="button button-mini button-border button-circle mt-1" onclick="add_compare('ML45604-2Q', '111')"><i class="icon-line-plus"></i>Compare</div>&nbsp;
										<div class="button button-mini button-border button-circle mt-1" onclick="AddRFQ('ML45604-2Q','111')"><i class="icon-line-dollar-sign"></i>Request Quote</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="course-card h-100 p-4">
									<a href="/OCPMezz_ML45604-1Q_ML45604-1Q" target="mit" /><img class="card-img-top" src="/images/product/OCPMezz/ML45604-1Q.jpg" alt="ML45604-1Q"></a>
									<div class="card-body center">
										<h2 class="card-title fw-normal mb-2 center lh2" >ML45604-1Q</h2>
										<h5 class="center">1 X 100G OCP 2.0 Mezzanine</h5>
										<div class="button button-mini button-border button-circle mt-1" onclick="add_compare('ML45604-1Q', '111')"><i class="icon-line-plus"></i>Compare</div>&nbsp;
										<div class="button button-mini button-border button-circle mt-1" onclick="AddRFQ('ML45604-1Q','111')"><i class="icon-line-dollar-sign"></i>Request Quote</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-1"></div>

				</div><p class="mb-4">&nbsp;</p>
			</div>
		</div>-->



		<div class="container-fluid m-0 bg-dark-blue">
			<h1 class="center">Partners</h1>
		</div>
		<div class="container-fluid m-0 border-0" style="padding: 80px 0">
			<div class="container  clearfix">
				<div class="row">
					<div class="col-lg-1"></div>
					<div class="col-lg-10">


						<div class="course-card p-4">


							<div class="row">
								<div class="col-lg-3"><a href="https://www.sardinasystems.com/" target="mit" /><img src="/images/product/OCP/Sardina_logo.gif" class="img-fluid" /></a></div>
								<div class="col-lg-9">
									<div class="card-body">

										<a href="https://www.sardinasystems.com/" target="mit" style="font-size:1.5rem; font-weight:bold" />Sardina FishOS</a> is an innovative OpenStack and Kubernetes cloud platform software, offering a full suite of management and automation tools to enable operators to easily and flexibly Deploy, Operate and Upgrade the cloud, reducing complexity and improving reliability. Sardina FishOS is an official OpenStack distribution fully recognized by OpenInfra Foundation (formerly OpenStack Foundation).

									</div>
								</div>
							</div>



						</div>





					</div>
					<div class="col-lg-1"></div>

				</div>
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