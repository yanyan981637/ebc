<?php
header("X-Frame-Options: DENY");
//header("Content-Security-Policy-Report-Only: default-src *; img-src https:; frame-src 'none'; report-uri http://www.tyan.com");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://www.tyan.com");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

if(strpos(trim(getenv('REQUEST_URI')),'?')!='' || strpos(trim(getenv('REQUEST_URI')),'?')===0 || strpos(trim(getenv('REQUEST_URI')),"'")!='' || strpos(trim(getenv('REQUEST_URI')),"'")===0 || strpos(trim(getenv('REQUEST_URI')),"script")!=''){
echo "<script language='javascript'>self.location='/404.htm'</script>";
exit;
}

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
  $PLang_si=dowith_sql($_REQUEST['PLang']);
  $PLang_si=str_replace(".php","",$PLang_si);

  if($PLang_si=="EN" || $PLang_si==""){
   $PLang_si01="EN";
   $PLang_si="en-US";
  }
}else{
  $PLang_si01="EN";
  $PLang_si="en-US";
}

if(isset($_GET["status"])){
  //$s_cookie="";
}else{
  $s_cookie=$_COOKIE['status'];
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	  <!-- <meta http-equiv="X-Frame-Options" content="deny"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="/images/ico/favicon.ico">
    <title>MiTAC Digital Technology Corp. - 5G Edge Computing Platform</title>
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script src="/js/gtm/modernizr.custom.63321.js"></script>
    <link href="/css/font-awesome.css" rel="stylesheet">
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">

    <link href="/css/fhmm.css" rel="stylesheet">

<!--news-->
<script type="text/javascript">
	function AutoScroll(obj){
		$(obj).find("ul:first").animate({
			marginTop:"-25px"
		},500,function(){
			$(this).css({marginTop:"0px"}).find("li:first").appendTo(this);
		});
	}
	$(document).ready(function(){
		setInterval('AutoScroll("#s1")',5000);
	});

</script>
<style type="text/css">
*{margin:0;padding:0;}
.scrollDiv{width:700px;height:25px;line-height:25px;border:#ccc 0px solid;overflow:hidden;/* 必要元素 */}
.scrollDiv li{height:25px;padding-left:10px;padding-top:4px;}


.pro_well {
  min-height: 20px;
  padding: 19px;
  margin-bottom: 20px;
  background-color: #ffffff;
  border: 1px solid #e3e3e3;
  border-radius: 4px;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);
}
.pro_well:hover{border: 1px solid #0D47A1; background-color: #ffffff; }
.sub_des{font-size:0.9em; line-height:110%; text-align: center; color:#626262}






</style>
<!--End-->

<script type="text/javascript">
	function checkComments(){
	if(( event.keyCode > 32 && event.keyCode < 46) || // 46=.
	   ( event.keyCode > 57 && event.keyCode < 64) || // 64=@
       ( event.keyCode > 90 && event.keyCode < 97) ||
	   ( event.keyCode > 123 && event.keyCode < 127)) { // 124=~,125=},126=|
       event.returnValue = false;
       }
	}
</script>

<?php
//************ google analytics ************
if($s_cookie!=2){
  include_once("analyticstracking.php");
}
?>
</head>
<body>
 <!--Header logo-->
	<?php
  include("../top.htm");

	?>
 <!--end Header logo-->

<!-- middles -->



    <div style="background: url(/images/product/bg_5G.jpg) no-repeat center center; background-size: cover;" class="intro-header">
        <div class="container">
            <div class="row" style="padding-top: 15%;">
                <div class="col-xs-12 col-sm-6 col-md-8 text-left">
                    <div class="intro-message" style="color:#ffffff">
                        <h1>5G Edge Computing Platform</h1><h3 style="color:#18ffff">A Low Latency, High Bandwidth and Capacity solution for network infrastructure</h3>
<p>
MiTAC Edge Computing platforms are a key technology for service providers build up the infrastructure to enable 5G and IoT applications with networking close to the end users. AI in Edge Computing will give people a refreshing experience. It will be driving smart city, home, industry and driving to change our life.


</p>
<br />



<p style="margin-bottom:10%"> </p>



                    </div>
                </div>
				<div class="col-xs-6 col-md-4 text-left" style="padding-top:3%;">
				 <div class="well box" style="background-color: rgba(255, 255, 255, 0.9); ">

				 <strong>Edge Server:</strong><br />

				 <ul style="margin-left:15px">
<li ><a href="/EN/contact/" target="mit" />FS2D01 (2U)</a></li>
<li ><a href="/EN/contact/" target="mit" />WS1S01 (1U)</a></li>
<li ><a href="/EN/contact/" target="mit" />WS1S02 (1U)</a></li>
</ul>

<strong>Multi Node Server:</strong><br />

				 <ul style="margin-left:15px">
<li ><a href="/EN/contact/" target="mit" />AD200</a></li>
<li ><a href="/EN/contact/" target="mit" />AD1S01</a></li>
<li ><a href="/EN/contact/" target="mit" />AD1S02</a></li>
</ul>
<strong>Edge Storage:</strong><br />

				 <ul style="margin-left:15px">
<li ><a href="/EN/contact/" target="mit" />FS2J01 (2U JBOD)</a></li>
</ul>



				</div>
				<br />


				</div>
            </div>

        </div>
        <!-- /.container -->

    </div>



	<!-- tabs -->
	<div style="background:#f8f8f8">
	<div class="container" >

<ul class="nav nav-pills" style="margin:40px 0px; font-size:1.2em ">
  <li role="presentation" ><a href="#2U_Edge_Server">2U Edge Server</a></li>
 <li role="presentation" ><a href="#2U_Edge_Storage">2U Edge Storage</a></li>
<li role="presentation" ><a href="#1U_Edge_Server">1U Edge Server</a></li>
<li role="presentation" ><a href="#Multi_Node_Edge_Server">Multi Node Edge Server</a></li>
</ul>



	</div>
	</div>
	<!-- end tabs -->

	<!--2U Edge Server-->

<a name="2U_Edge_Server"></a>
	<div class="container" style="padding:2% 0%">
	</div>
	<div class="container-fluid" style="background:#0D47A1; color:#ffffff" >
	<h1 class="text-center">2U Edge Server - Firestone family</h1>
	</div>

<p style="margin-top:3%"> </p>

<div class="container">
<div class="row">
<div class="col-md-3">
	<div class="pro_well" ><br />
<h4 style="text-align: center;">CU/MEC Edge Server FS2D11</h4>
<br /><a href="/EN/contact/" target="mit" /><img src="/images/product/5G/FS2D11.png" class="img-responsive" /></a><br /><br />
<div class="sub_des" style="line-height:150%" ><span style="color:#0D47A1; font-size:1em">(2) Intel Xeon-SP/ 3rd Gen<br />
(6) 2.5" HDD/SSD</span></div><br /><br />
</div>
	</div>
	<div class="col-md-3">
	<div class="pro_well" ><br />
<h4 style="text-align: center;">CU/MEC Edge Server FS2D01</h4>
<br /><a href="/EN/contact/" target="mit" /><img src="/images/product/5G/FS2D01.png" class="img-responsive" /></a><br /><br />
<div class="sub_des" style="line-height:150%" ><span style="color:#0D47A1; font-size:1em">(2) Intel Xeon-SP/ 2nd Gen<br />
(6) 2.5" HDD/SSD</span></div><br /><br />
</div>
	</div>
	<div class="col-md-3">

	</div>
	<div class="col-md-3">

	</div>
</div>


</div>


	<p style="margin-top:3%"> </p>
<!--end 2U Edge Server-->



<!--2U Edge Storage-->




<a name="2U_Edge_Storage"></a>
	<div class="container" style="padding:2% 0%">
	</div>
	<div class="container-fluid" style="background:#0D47A1; color:#ffffff" >
	<h1 class="text-center">2U Edge Storage - Firestorage family</h1>
	</div>
	<p style="margin-top:3%"> </p>
<div class="container">
<div class="row">
<div class="col-md-3">
	<div class="pro_well" >
	<div style="position: relative; text-align: center;  background:#8fc31f; padding:2px; color:#ffffff; font-size:0.8em;">Coming Soon!</div>
<h4 style="text-align: center;">Edge JBOD FS2J01</h4>
<a href="/EN/contact/" target="mit" /><img src="/images/product/5G/FS2J01.png" class="img-responsive" /></a><br />
<div class="sub_des" style="line-height:150%" ><span style="color:#0D47A1; font-size:1em">2U 11 x 3.5" SAS/SATA</div>
</div>
	</div>
	<div class="col-md-3">
	</div>
	<div class="col-md-3">

	</div>
	<div class="col-md-3">

	</div>
</div>
</div>


	<p style="margin-top:3%"> </p>
<!--end 2U Edge Storage-->


<!--1U Edge Server-->

<a name="1U_Edge_Server"></a>
	<div class="container" style="padding:2% 0%">
	</div>
	<div class="container-fluid" style="background:#0D47A1; color:#ffffff" >
	<h1 class="text-center">1U Edge Server - Whitestone family</h1>
	</div>
	<p style="margin-top:3%"> </p>
<div class="container">
<div class="row">
<div class="col-md-3">
	<div class="pro_well" >
	<div style="position: relative; text-align: center;  background:#8fc31f; padding:2px; color:#ffffff; font-size:0.8em;">Coming Soon!</div>
<h4 style="text-align: center;">DU Server WS1S01</h4>
<a href="/EN/contact/" target="mit" /><img src="/images/product/5G/whitestone.png" class="img-responsive" /></a><br />
<div class="sub_des" style="line-height:150%" ><span style="color:#0D47A1; font-size:1em">Intel Xeon SP 3rd Gen<br />
Designed for outdoor </div>
</div>
	</div>
	<div class="col-md-3"><div class="pro_well" >
	<div style="position: relative; text-align: center;  background:#8fc31f; padding:2px; color:#ffffff; font-size:0.8em;">Coming Soon!</div>
<h4 style="text-align: center;">DU Server WS1S02</h4>
<a href="/EN/contact/" target="mit" /><img src="/images/product/5G/whitestone.png" class="img-responsive" /></a><br />
<div class="sub_des" style="line-height:150%" ><span style="color:#0D47A1; font-size:1em">Intel Xeon D next Gen<br />
Designed for outdoor </div>
</div></div>
	</div>
	<div class="col-md-3">

	</div>
	<div class="col-md-3">

	</div>
</div>
</div>


	<p style="margin-top:3%"> </p>
<!--end 1U Edge Server-->





<!--Multi_Node_Edge_Server-->

<a name="Multi_Node_Edge_Server"></a>
	<div class="container" style="padding:2% 0%">
	</div>
	<div class="container-fluid" style="background:#0D47A1; color:#ffffff" >
	<h1 class="text-center">Multi Node Server - Aowanda family</h1>
	</div>
	<p style="margin-top:3%"> </p>
<div class="container">
<div class="row">
<div class="col-md-3">
	<div class="pro_well" >
	<!--<div style="position: relative; text-align: center;  background:#8fc31f; padding:2px; color:#ffffff; font-size:0.8em;">Coming Soon!</div>-->
<h4 style="text-align: center;">CU/DU Edge Server AD200</h4>
<a href="/5GEdgeComputing_AD211_AD1S01" target="mit" /><img src="/images/product/5G/AD200.png" class="img-responsive" /></a><br />
<div class="sub_des" style="line-height:150%" ><span style="color:#0D47A1; font-size:1em">2U 3 nodes<br />Intel Xeon SP 3rd Gen</div>
</div>
	</div>
	<div class="col-md-3"><div class="pro_well" >
	<!--<div style="position: relative; text-align: center;  background:#8fc31f; padding:2px; color:#ffffff; font-size:0.8em;">Coming Soon!</div>-->
<h4 style="text-align: center;">1U Edge Server Sled AD1S01</h4>
<a href="/5GEdgeComputing_AD211_AD1S01" target="mit" /><img src="/images/product/5G/Aowanda_Sled.png" class="img-responsive" /></a><br />
<div class="sub_des" style="line-height:150%" ><span style="color:#0D47A1; font-size:1em">Intel Xeon SP 3rd Gen<br />
OCP 3.0 slot / 2 E1.S SSD</div>
</div></div>
<div class="col-md-3">
	<div class="pro_well" >
	<!--<div style="position: relative; text-align: center;  background:#8fc31f; padding:2px; color:#ffffff; font-size:0.8em;">Coming Soon!</div>-->
<h4 style="text-align: center;">1U Edge Server Sled AD1S02</h4>
<a href="/5GEdgeComputing_AD211_AD1S02" target="mit" /><img src="/images/product/5G/Aowanda_Sled-AD1S02.png" class="img-responsive" /></a><br />
<div class="sub_des" style="line-height:150%" ><span style="color:#0D47A1; font-size:1em">Intel Xeon SP 3rd Gen<br />
2 PCIe Slot </div>
</div>
	</div>
	<div class="col-md-3">

	</div>
	</div>

</div>
</div>


	<p style="margin-top:3%"> </p>
<!--end Multi_Node_Edge_Server-->



















<!-- middles end-->


<!-- FOOTER -->
<?php
include("../foot.htm");
?>
<!-- FOOTER End
 -->
<div id="go-top" style="display: block;"><a title="Back to Top" href="#">Go To Top</a></div>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="/js/docs.min.js"></script>
<script src="/js/gtm/jquery.catslider.js"></script>
<script>
	$(function() {
	$( '#mi-slider' ).catslider();
	});
</script>
<script src="/js/jquery-1.10.2.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/bootstrap-hover-dropdown.js"></script>
<script src="/js/fhmm.js"></script>
<script src="/js/fitdivs.js"></script>
<script>
	$(document).ready(function(){
	// Target your .container, .wrapper, .post, etc.
		$(".fhmm").fitVids();
	});
</script>
<script>
	// Menu drop down effect
	$('.dropdown-toggle').dropdownHover().dropdown();
	$(document).on('click', '.fhmm .dropdown-menu', function(e) {
	  e.stopPropagation();
	})
</script>
</body>
</html>