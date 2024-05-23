<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="author" content="" />

<!-- Stylesheets
============================================= -->
<link href="https://fonts.googleapis.com/css2?family=Prata&family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">
<link rel="icon" href="https://www.tyanvirtual.com/favicon.3b3d1e2a.png">

<link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="style.css" type="text/css" />
<link rel="stylesheet" href="css/dark.css" type="text/css" />
<link rel="stylesheet" href="css/font-icons.css" type="text/css" />
<link rel="stylesheet" href="css/animate.css" type="text/css" />
<link rel="stylesheet" href="css/magnific-popup.css" type="text/css" />


<link rel="stylesheet" href="css/custom.css" type="text/css" />
<meta name="viewport" content="width=device-width, initial-scale=1" />




<style>

body, html {font-family: 'Roboto', sans-serif;
height: 100%;
margin: 0;
}

.bg-kv {
background-image: url("images/bg.jpg");
height: 100%;
background-position: center;
background-repeat: no-repeat;
background-size: cover;
}


.desc {margin:8px 4px; font-size:0.8rem; font-weight:300; line-height:120%}
.desc a{color:#fff; text-decoration:none}

#footer {background:#000000; color:#a0a0a0; font-weight:100; line-height:100%; font-size:0.5rem; text-align:left; padding:1%; }
h2 {font-size:2.2rem; font-weight:500; line-height:100%; color:#fff; margin:3% 0% 1% 0%}

a{color:#6cbce1; }
a:hover{color:#00a0e9; }

</style>









<!-- Document Title
============================================= -->
<title>TYAN 2021 Server Solution Online Exhibition</title>

</head>

<body class="stretched" style="background:#00204d; color:#fff">




<div id="app">

<!-- Document Wrapper
============================================= -->


<div class="bg-kv">


	<div class="col-md-6" style="padding:20px 0px 0px 80px;">

		<a href="https://www.tyan.com/" target="cc" /><img src="https://www.tyan.com/EN/campaign/Online_Exhibition_2021/img/tyan-logo.png" /></a><br />
		<h2>2021 Online Exhibition<br /><span style="font-size:1.6rem; font-weight:300; color:#fff">TYAN Server Solution</span></h2>

		<p style="font-size:0.9rem; font-weight:100; color:#fff; line-height:120%; margin-bottom:5px">Join Tyan's server solutions online exhibition to learn about the latest HPC, storage, cloud and 5G server platforms powered by 3<sup>rd</sup> Gen Intel<sup>®</sup> Xeon<sup>®</sup> Scalable processors and AMD EPYC™ 7003 Series processors with a 3D virtual experience.</p>

		<div class="form-box">
			<div class="row">
				<div class="form-group col-md-6"><input type="text" name="company" class="form-control" id="" placeholder="* Company:"  v-model="form.company"></div>
				<div class="form-group col-md-6"><input type="text" name="email" class="form-control" id="" placeholder="* Email:" v-model="form.email"></div>
			</div>
			<div class="row">
				<div class="form-group col-md-6"><input type="text" name="name" class="form-control" id="" placeholder="* Name:" v-model="form.name"></div>
				<div class="form-group col-md-6">

					<select id="inputState" class="form-select" name="area" v-model="form.area">
						<option selected>* Area:</option>
						<option class="drop-item" value="US">US</option>
						<option class="drop-item" value="Central / South America">Central / South America</option>
						<option class="drop-item" value="Europe">Europe</option>
						<option class="drop-item" value="China">China</option>
						<option class="drop-item" value="Asia">Asia</option>
						<option class="drop-item" value="Else">Else</option></select>
					</div>
					<div class="form-row">
						<div class="form-group">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" v-model="form.agree" id="gridCheck">
								<label class="form-check-label" for="gridCheck"  style="color:#fff">
									I Agree To The <a href="https://www.tyan.com/EN/legal/privacy_policy/" target="_blank">Privacy Policy</a> To Process Of My Personal
									Data For Marketing Purpose
								</label>
							</div>
						</div>
					</div>
					<div class="form-group col-md-6">
						<button type="button" class="btn button-green" style="color:#fff; width:100%" @click="joinUs">Join us</button></div>
					</div>

				</div>
			</div>

	<!-- Content============================================= -->

	<div class="content-wrap" style="margin-top:-20px; ">
		<div class="container-fluid" >
			<div style="background:#01204c; ">
				<div style="margin-top:25px">&nbsp;</div>

				

				<div id="oc-posts" class="owl-carousel posts-carousel carousel-widget posts-md" data-pagi="false" data-items-xs="1" data-items-sm="2" data-items-md="3" data-items-lg="4" >

					<div class="oc-item">
						<div class="entry">
							<div class="entry-image">
								<a href="https://www.youtube.com/embed/z9q7PWIpfq8">
									<iframe width="560" height="315" src="https://www.youtube.com/embed/z9q7PWIpfq8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
								</a>
							</div>
							<div class="desc">
								<a href="https://www.tyan.com/EN/campaign/amd/amd_epyc_7003/" >3<sup>rd</sup> Gen AMD EPYC™ Processors powered server platforms designed for data centers</a>
							</div>
						</div>
					</div>

					<div class="oc-item">
						<div class="entry">
							<div class="entry-image">
								<a href="https://www.youtube.com/embed/OjpttL0SgXo">
									<iframe width="620" height="349" src="https://www.youtube.com/embed/OjpttL0SgXo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
								</a>
							</div>
							<div class="desc">
								<a href="#" >Transport CX GC68A B8036 - AMD EPYC™ 7003 1U1S high IPOS cloud storage server</a>
							</div>
						</div>
					</div>
					
					<div class="oc-item">
						<div class="entry">
							<div class="entry-image">
								<a href="https://www.youtube.com/embed/K7S7dQ5-6JM">
									<iframe width="560" height="315" src="https://www.youtube.com/embed/K7S7dQ5-6JM" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
								</a>
							</div>
							<div class="desc">
								<a href="https://www.tyan.com/EN/campaign/intel/Ice-Lake/" >3<sup>rd</sup> Gen Intel Xeon Scalable processors powered AI platforms</a>
							</div>
						</div>
					</div>
					
					<div class="oc-item">
						<div class="entry">
							<div class="entry-image">
								<a href="https://www.youtube.com/embed/eEXWavXSCRA">
									<iframe width="560" height="315" src="https://www.youtube.com/embed/eEXWavXSCRA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
								</a>
							</div>
							<div class="desc">
								<a href="https://www.tyan.com/Barebones_TS65B7120_B7120T65V10E4HR-2T" >Thunder SX TS65-B7120 - 3<sup>rd</sup> Gen Intel® Xeon® Scalable processors 2U self-contained AI inference server</a>
							</div>
						</div>
					</div>
					

					<div class="oc-item">
						<div class="entry">
							<div class="entry-image">
								<a href="portfolio-single.html">
									<img src="images/FT65T-B8030.jpg" alt="FT65T-B8030">
								</a>
							</div>
							<div class="desc">
								<a href="https://www.tyan.com/Barebones_FT65TB8030_B8030F65TV8E2H-2T-N" >Transport HX FT65T-B8030 - AMD EPYC™ 7003 Tower / 4U Convertible Server Platform for Cost-Effective HPC Applications</a>
							</div>
						</div>
					</div>

					<div class="oc-item">
						<div class="entry">
							<div class="entry-image">
								<a href="#">
									<img src="images/GC79A-B8252.jpg" alt="GC79A-B8252">
								</a>
							</div>
							<div class="desc">
								<a href="https://www.tyan.com/Barebones_GC79AB8252_B8252G79AE12HR-2T" >Transport CX GC79A-B8252 - AMD EPYC™ 7003 1U 12-bay All-Flash Server for IO-Heavy Computing</a>
							</div>
						</div>
					</div>
					
					
					
					
					<div class="oc-item">
						<div class="entry">
							<div class="entry-image">
								<a href="https://www.tyan.com/Barebones_FT83AB7129_B7129F83AV14E8HR-N">
									<img src="images/FT83A-B7129.jpg" alt="FT83A-B7129">
								</a>
							</div>
							<div class="desc">
								<a href="https://www.tyan.com/Barebones_FT83AB7129_B7129F83AV14E8HR-N" >Thunder HX FT83A-B7129 - 3<sup>rd</sup> Gen Intel® Xeon® Scalable processors 4U 10-GPU Server Platform for Embarrassingly Parallel Workloads</a>
							</div>
						</div>
					</div>
					
					<div class="oc-item">
						<div class="entry">
							<div class="entry-image">
								<a href="https://www.tyan.com/Barebones_GC68AB7126_B7126G68AV10E2HR">
									<img src="images/GC68A-B7126.jpg" alt="GC68A-B7126">
								</a>
							</div>
							<div class="desc">
								<a href="https://www.tyan.com/Barebones_GC68AB7126_B7126G68AV10E2HR" >Thunder CX GC68A-B7126 - 3<sup>rd</sup> Gen Intel® Xeon® Scalable processors 1U 12-bay All-Flash Server for CSP High IOPS Applications</a>
							</div>
						</div>
					</div>

				</div>
			</div>











		</div>



		<div id="footer" >
			<div class="row container">
				<div class="col-md-9">Copyright© 2004-2021 MiTAC Computing Technology Corporation (MiTAC Group) and/or any of its affiliates. All Rights Reserved.Information published on TYAN.com is subject to change without notice. All other trademarks are property of their respective companies.This site is best viewed using the latest versions of Internet Explorer, Firefox, and Chrome.</div>
				<div class="col-md-3 ">
					<div class="d-flex  justify-content-center justify-content-md-end">

						<a href="https://www.facebook.com/tyancomputer" target="cc" class="social-icon si-small si-borderless si-facebook">
							<i class="icon-facebook"></i>
							<i class="icon-facebook"></i>
						</a>
						<a href="https://twitter.com/tyan" target="cc" class="social-icon si-small si-borderless si-twitter">
							<i class="icon-twitter"></i>
							<i class="icon-twitter"></i>
						</a>
						<a href="https://www.linkedin.com/company/tyan-computer" target="cc" class="social-icon si-small si-borderless si-linkedin">
							<i class="icon-linkedin"></i>
							<i class="icon-linkedin"></i>
						</a>				
						<a href="https://www.youtube.com/c/tyancomputer/videos" target="cc" class="social-icon si-small si-borderless si-facebook">
							<i class="icon-youtube"></i>
							<i class="icon-youtube"></i>
						</a>

					</div>
				</div>
			</div>
			
		</div>


		<!-- .portfolio-carousel end -->

	</div>

	<!-- #content end -->

</div>
<!-- #wrapper end -->

<!-- Go To Top
============================================= -->
<div id="gotoTop" class="icon-angle-up"></div>
</div>
<!-- JavaScripts
============================================= -->
<script src="js/jquery.js"></script>
<script src="js/plugins.min.js"></script>

<!-- Footer Scripts
============================================= -->
<script src="js/functions.js"></script>
<script src="index.ba5228ff.js"></script>
</body>
</html>