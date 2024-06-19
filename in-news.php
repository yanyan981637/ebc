<?php
header("X-Frame-Options: DENY");
//header("Content-Security-Policy-Report-Only: default-src *; img-src https:; frame-src 'none'; report-uri http://www.tyan.com");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://www.tyan.com");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
if(strpos(trim(getenv('REQUEST_URI')),'?')!='' || strpos(trim(getenv('REQUEST_URI')),'?')===0 || strpos(trim(getenv('REQUEST_URI')),"'")!='' || strpos(trim(getenv('REQUEST_URI')),"'")===0 || strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
echo "<script language='javascript'>self.location='/404.htm'</script>";
exit;
}
require "./config.php";
include_once('./page_pr.class.php');
function dowith_sql($str)
{
   $str = str_replace("and","",$str);
   $str = str_replace("execute","",$str);
   $str = str_replace("update","",$str);
   $str = str_replace("count","",$str);
   $str = str_replace("chr","",$str);
   $str = str_replace("mid","",$str);
   $str = str_replace("master","",$str);
   $str = str_replace("truncate","",$str);
   $str = str_replace("char","",$str);
   $str = str_replace("declare","",$str);
   $str = str_replace("select","",$str);
   $str = str_replace("create","",$str);
   $str = str_replace("delete","",$str);
   $str = str_replace("insert","",$str);
   $str = str_replace("'","",$str);
   $str = str_replace('"',"",$str);
   $str = str_replace(".","",$str);
   $str = str_replace("or","",$str);
   $str = str_replace("=","",$str);
   $str = str_replace("?","",$str);
   $str = str_replace("%","",$str);
   $str = str_replace("0x02BC","",$str);
   return $str;
}
if(isset($_REQUEST['PLang'])!=''){
  $PLang_si=dowith_sql(trim($_REQUEST['PLang']));
  $PLang_si=str_replace(".php","",$PLang_si);
  if($PLang_si=="en-US" || $PLang_si==""){
    $PLang_si01="EN";
    $PLang_si="en-US";
    $NRM01="Newsroom";
    $PRL01="Press Release";
    $NLT01="Newsletters";
    $EVL01="Events";
    $PRE01="Product Review";
  }else if($PLang_si=="ja-JP"){
    $PLang_si01="JP";
    $PLang_si="ja-JP";
    $NRM01="ニュースルーム";
    $PRL01="プレスリリース";
    $NLT01="ニュースレター";
    $EVL01="イベント";
    $PRE01="製品レビュー";
  }else if($PLang_si=="zh-CN"){
    $PLang_si01="CN";
    $PLang_si="zh-CN";
    $NRM01="新闻发布";
    $PRL01="新闻稿";
    $NLT01="快讯";
    $EVL01="活动";
    $PRE01="产品评测";
  }else if($PLang_si=="zh-TW"){
    $PLang_si01="ZH";
    $PLang_si="zh-TW";
    $NRM01="新聞中心";
    $PRL01="新聞稿";
    $NLT01="電子報";
    $EVL01="活動";
    $PRE01="產品評測";
  }else{
      $PLang_si01="EN";
    $PLang_si="en-US";
    $NRM01="Newsroom";
    $PRL01="Press Release";
    $NLT01="Newsletters";
    $EVL01="Events";
    $PRE01="Product Review";
  }
}else{
$PLang_si01="EN";
$PLang_si="en-US";
$PLang_si01="EN";
    $PLang_si="en-US";
    $NRM01="Newsroom";
    $PRL01="Press Release";
    $NLT01="Newsletters";
    $EVL01="Events";
    $PRE01="Product Review";
}
if(isset($_COOKIE['status'])){
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
<meta name="description" content="">
<meta property="og:type" content="website" />
<meta property="og:description" content="" />
<meta property="og:title" content="News - MiTAC in the News  | MiTAC Computing Technology" />
  <link rel="shortcut icon" href="images/ico/favicon.ico">
<!-- Stylesheets
============================================= -->
<link rel="stylesheet" href="css1/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="css1/style.css" type="text/css" />
<link rel="stylesheet" href="css1/swiper.css" type="text/css" />
<link rel="stylesheet" href="css1/dark.css" type="text/css" />
<link rel="stylesheet" href="css1/font-icons.css" type="text/css" />
<link rel="stylesheet" href="css1/animate.css" type="text/css" />
<link rel="stylesheet" href="css1/magnific-popup.css" type="text/css" />
<link rel="stylesheet" href="css1/custom.css" type="text/css" />
<link rel="stylesheet" href="css1/news.css" type="text/css" />
<script src="js1/jquery.js"></script>
<!-- Document Title
============================================= -->
<title>News - MiTAC in the News  | MiTAC Computing Technology</title>
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
		include("top1.htm");
		?>
		<!--end Header logo & global top menu-->
		<!-- Slider
		============================================= -->
		<section id="slider" class="slider-element">
			<div class="container center col-padding">
				<div class="text-uppercase fw-light ls3" style="color:#c9c9c9">Newsroom</div>
				<h1 class="fw-bold ls0 mb-5" >Events</h1>
			</div>
		</section>
		<div id="news-nav" class="content mb-6" >
			<div class="w-100 mb-4 mt-0 mt-lg-0 p-3">
				<div class="row justify-content-center gx-3">
					<div class="col-lg-3 mb-4 mb-lg-0" onclick="location.href='<?=$PLang_si;?>@EVLIST~evlist~1'">
						<div class="grid-inner shadow-sm h-shadow bg-white p-3 overflow-hidden rounded-5 text-center shadow-ts">
							<div class="row justify-content-center">
								<div class="col-12" ><h3 class="h3 mb-0 fw-bold" > <i class="icon-line-calendar mb-1" ></i> Events</h3></div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 mb-4 mb-lg-0" onclick="location.href='<?=$PLang_si;?>@PRLIST~plist~1'">
						<div class="grid-inner shadow-sm h-shadow bg-white p-3 overflow-hidden rounded-5 text-center shadow-ts">
							<div class="row justify-content-center">
								<div class="col-12" ><h3 class="h3 mb-0 fw-bold"> <i class="icon-bullhorn1 mb-1"></i> Press Release</h3></div>
							</div>
						</div>
					</div>
					<div class="col-lg-3" onclick="location.href='in-news'">
						<div class="grid-inner shadow-sm h-shadow  p-3 overflow-hidden rounded-5 text-center shadow-ts" style="background:#d4e8fe">
							<div class="row justify-content-center">
								<div class="col-12" ><h3 class="h3 mb-0 fw-bold"> <i class="icon-news mb-1"></i> MiTAC in the News</h3></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="clear"></div>
		<section id="content">
			<div class="content-wrap pt-3" style="overflow: visible;">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 mb-5 mb-lg-0">
							<h1>MiTAC in the News</h1>
							<!--pagnation-->
						<!--	<div style="float:right">
							<ul class="pagination pagination-transparent pagination-circle">
									  <li class="page-item disabled"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
									  <li class="page-item active"><a class="page-link" href="#">1</a></li>
									  <li class="page-item"><a class="page-link" href="#">2</a></li>
									  <li class="page-item"><a class="page-link" href="#">3</a></li>
									  <li class="page-item"><a class="page-link" href="#">4</a></li>
									  <li class="page-item"><a class="page-link" href="#">5</a></li>
									  <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
							</ul>
							</div>
							<div class="clear"></div>-->
							<!--end pagnation-->
							<div class="row posts-md col-mb-30" >
							<!--one -->
								<article class="entry col-12 mb-3">
									<div class="grid-inner row gutter-20">
										<div class="col-md-1">
											<a href="https://embeddedcomputing.com/technology/iot/edge-computing/deploy-aoi-with-ai-capabilities-through-an-on-prem-next-gen-edge-computer" target="min"><img src="/images/pressroom_pic/PRIM-embedded.gif" alt=""  ></a>
										</div>
										<div class="col-md-11">
											<div class="entry-title title-xs">
												<span class="badge rounded-pill bg-info">2023/11/30</span><br>
												<h2><a href="https://embeddedcomputing.com/technology/iot/edge-computing/deploy-aoi-with-ai-capabilities-through-an-on-prem-next-gen-edge-computer" target="min">Deploy AOI With AI Capabilities Through an On-Prem Next-Gen Edge Computer</a></h2>
												<!--Contents--><span></span><!--end Contents-->
											</div>
										</div>
									</div>
								</article>
								<!--end one -->
							<!--one -->
								<article class="entry col-12 mb-3">
									<div class="grid-inner row gutter-20">
										<div class="col-md-1">
											<a href="https://embeddedcomputing.com/technology/iot/edge-computing/unlock-the-power-of-edge-computing-in-diverse-applications-with-nvidias-jetson-orin" target="min"><img src="/images/pressroom_pic/PRIM-embedded.gif" alt=""  ></a>
										</div>
										<div class="col-md-11">
											<div class="entry-title title-xs">
												<span class="badge rounded-pill bg-info">2023/10/31</span><br>
												<h2><a href="https://embeddedcomputing.com/technology/iot/edge-computing/unlock-the-power-of-edge-computing-in-diverse-applications-with-nvidias-jetson-orin" target="min">Unlock the Power of Edge Computing in Diverse Applications with NVIDIA's Jetson Orin</a></h2>
												<!--Contents--><span></span><!--end Contents-->
											</div>
										</div>
									</div>
								</article>
								<!--end one -->
							<!--one -->
								<article class="entry col-12 mb-3">
									<div class="grid-inner row gutter-20">
										<div class="col-md-1">
											<a href="https://embeddedcomputing.com/application/industrial/automation-robotics/complete-your-smart-factory-with-an-amr" target="min"><img src="/images/pressroom_pic/PRIM-embedded.gif" alt=""  ></a>
										</div>
										<div class="col-md-11">
											<div class="entry-title title-xs">
												<span class="badge rounded-pill bg-info">2023/09/05</span><br>
												<h2><a href="https://embeddedcomputing.com/application/industrial/automation-robotics/complete-your-smart-factory-with-an-amr" target="min">Complete Your Smart Factory With an AMR</a></h2>
												<!--Contents--><span></span><!--end Contents-->
											</div>
										</div>
									</div>
								</article>
								<!--end one -->
								<!--one -->
								<article class="entry col-12 mb-3">
									<div class="grid-inner row gutter-20">
										<div class="col-md-1">
											<a href="https://embeddedcomputing.com/application/industrial/machine-vision/ai-enhances-industrial-machine-vision" target="min"><img src="/images/pressroom_pic/PRIM-embedded.gif" alt="AI Enhances Industrial Machine Vision"  ></a>
										</div>
										<div class="col-md-11">
											<div class="entry-title title-xs">
												<span class="badge rounded-pill bg-info">2023/08/02</span><br>
												<h2><a href="https://embeddedcomputing.com/application/industrial/machine-vision/ai-enhances-industrial-machine-vision" target="min">AI Enhances Industrial Machine Vision</a></h2>
												<!--Contents--><span></span><!--end Contents-->
											</div>
										</div>
									</div>
								</article>
								<!--end one -->
										<!--one -->
								<article class="entry col-12 mb-3">
									<div class="grid-inner row gutter-20">
										<div class="col-md-1">
											<a href="https://embeddedcomputing.com/technology/ai-machine-learning/edge-ai-puts-the-smart-in-a-smart-factory" target="min"><img src="/images/pressroom_pic/PRIM-embedded.gif" alt="Edge AI Puts the Smart in a Smart Factory"  ></a>
										</div>
										<div class="col-md-11">
											<div class="entry-title title-xs">
												<span class="badge rounded-pill bg-info">2023/06/07</span><br>
												<h2><a href="https://embeddedcomputing.com/technology/ai-machine-learning/edge-ai-puts-the-smart-in-a-smart-factory" target="min">Edge AI Puts the "Smart" in a Smart Factory</a></h2>
												<!--Contents--><span></span><!--end Contents-->
											</div>
										</div>
									</div>
								</article>
								<!--end one -->
										<!--one -->
								<article class="entry col-12 mb-3">
									<div class="grid-inner row gutter-20">
										<div class="col-md-1">
											<a href="https://embeddedcomputing.com/technology/ai-machine-learning/computer-vision-speech-processing/ai-plus-nvr-is-a-powerful-surveillance-combination" target="min"><img src="/images/pressroom_pic/PRIM-embedded.gif" alt="AI Plus NVR Is a Powerful Surveillance Combination"  ></a>
										</div>
										<div class="col-md-11">
											<div class="entry-title title-xs">
												<span class="badge rounded-pill bg-info">2022/9/26</span><br>
												<h2><a href="https://embeddedcomputing.com/technology/ai-machine-learning/computer-vision-speech-processing/ai-plus-nvr-is-a-powerful-surveillance-combination" target="min">AI Plus NVR Is a Powerful Surveillance Combination</a></h2>
												<!--Contents--><span></span><!--end Contents-->
											</div>
										</div>
									</div>
								</article>
								<!--end one -->
								<!--one -->
								<article class="entry col-12 mb-3">
									<div class="grid-inner row gutter-20">
										<div class="col-md-1">
											<a href="https://marketplace.intel.com/s/offering/a5b3b000000YQpEAAW/mitac-machine-vision-in-factory-automation?language=en_US" target="min"><img src="/images/pressroom_pic/intel-market-ready.gif" alt="MiTAC Machine Vision in Factory Automation"  ></a>
										</div>
										<div class="col-md-11">
											<div class="entry-title title-xs">
												<span class="badge rounded-pill bg-info">2022/7/13</span><br>
												<h2><a href="https://marketplace.intel.com/s/offering/a5b3b000000YQpEAAW/mitac-machine-vision-in-factory-automation?language=en_US" target="min">MiTAC Machine Vision in Factory Automation</a></h2>
												<!--Contents--><span></span><!--end Contents-->
											</div>
										</div>
									</div>
								</article>
								<!--end one -->
								<!--one -->
								<article class="entry col-12 mb-3">
									<div class="grid-inner row gutter-20">
										<div class="col-md-1">
											<a href="https://embeddedcomputing.com/application/networking-5g/5g/railway-data-collection-serves-train-protection-and-monitoring-amongst-other-traits" target="min"><img src="/images/pressroom_pic/PRIM-embedded.gif" alt="Railway Data Collection Serves Train Protection and Monitoring, Amongst Other Traits"  ></a>
										</div>
										<div class="col-md-11">
											<div class="entry-title title-xs">
												<span class="badge rounded-pill bg-info">2022/7/12</span><br>
												<h2><a href="https://embeddedcomputing.com/application/networking-5g/5g/railway-data-collection-serves-train-protection-and-monitoring-amongst-other-traits" target="min">Railway Data Collection Serves Train Protection and Monitoring, Amongst Other Traits</a></h2>
												<!--Contents--><span></span><!--end Contents-->
											</div>
										</div>
									</div>
								</article>
								<!--end one -->
								<!--one -->
								<article class="entry col-12 mb-3">
									<div class="grid-inner row gutter-20">
										<div class="col-md-1">
											<a href="https://www.elektronikpraxis.vogel.de/wie-edge-ki-die-fabrikautomatisierung-verbessert-d-623d61e1ef32b/" target="min"><img src="/images/pressroom_pic/elektronikpraxis.gif" alt="KI und Edge Computing"  ></a>
										</div>
										<div class="col-md-11">
											<div class="entry-title title-xs">
												<span class="badge rounded-pill bg-info">2022/4/7</span><br>
												<h2><a href="https://www.elektronikpraxis.vogel.de/wie-edge-ki-die-fabrikautomatisierung-verbessert-d-623d61e1ef32b/" target="min">KI und Edge Computing - Wie Edge-KI die Fabrikautomatisierung verbessert</a></h2>
												<!--Contents--><span></span><!--end Contents-->
											</div>
										</div>
									</div>
								</article>
								<!--end one -->
							<!--one -->
								<article class="entry col-12 mb-3">
									<div class="grid-inner row gutter-20">
										<div class="col-md-1">
											<a href="https://embeddedcomputing.com/application/industrial/automation-robotics/machine-vision-leads-to-an-automated-factory" target="min"><img src="/images/pressroom_pic/PRIM-embedded.gif" alt="Machine Vision Leads to an Automated Factory"  ></a>
										</div>
										<div class="col-md-11">
											<div class="entry-title title-xs">
												<span class="badge rounded-pill bg-info">2022/3/19</span><br>
												<h2><a href="https://embeddedcomputing.com/application/industrial/automation-robotics/machine-vision-leads-to-an-automated-factory" target="min">Machine Vision Leads to an Automated Factory</a></h2>
												<!--Contents--><span></span><!--end Contents-->
											</div>
										</div>
									</div>
								</article>
								<!--end one -->
								<!--one -->
								<article class="entry col-12 mb-3">
									<div class="grid-inner row gutter-20">
										<div class="col-md-1">
											<a href="https://www.embeddedcomputing.com/application/industrial/industrial-iot/the-road-to-embedded-world-mitac" target="min"><img src="/images/pressroom_pic/PRIM-embedded.gif" alt="The Road to embedded world: MiTAC"  ></a>
										</div>
										<div class="col-md-11">
											<div class="entry-title title-xs">
												<span class="badge rounded-pill bg-info">2022/3/15</span><br>
												<h2><a href="https://www.embeddedcomputing.com/application/industrial/industrial-iot/the-road-to-embedded-world-mitac" target="min">The Road to embedded world: MiTAC</a></h2>
												<!--Contents--><span></span><!--end Contents-->
											</div>
										</div>
									</div>
								</article>
								<!--end one -->
							</div>
							<div class="clear mb-6 mt-6 "></div>
							<!--pagnation-->
<!--<div style="float:right">
<ul class="pagination pagination-transparent pagination-circle">
		  <li class="page-item disabled"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
		  <li class="page-item active"><a class="page-link" href="#">1</a></li>
		  <li class="page-item"><a class="page-link" href="#">2</a></li>
		  <li class="page-item"><a class="page-link" href="#">3</a></li>
		  <li class="page-item"><a class="page-link" href="#">4</a></li>
		  <li class="page-item"><a class="page-link" href="#">5</a></li>
		  <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
</ul>
</div>
<div class="clear"></div>-->
<!--end pagnation-->
</div>
</div>
</div>
</div>
</section>
<div class="clear mb-6"></div>
<!-- FOOTER -->
<?php
include("foot1.htm");
?>
<!-- FOOTER end -->
</div><!-- #wrapper end -->
	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-line-arrow-up"></div>
	<!-- JavaScripts
	============================================= -->
	<script src="js1/plugins.min.js"></script>
	<!-- Footer Scripts
	============================================= -->
	<script src="js1/functions.js"></script>
	<!-- ADD-ONS JS FILES -->
	<script src="/js1/top.js"></script>
</body>
</html>