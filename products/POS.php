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
    <title>MiTAC Digital Technology Corp. - POS</title>
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



    <div style="background: url(/images/product/bg_POS.jpg) no-repeat center center; background-size: cover;" class="intro-header">
        <div class="container">
            <div class="row" style="padding-top: 15%;">
                <div class="col-xs-12 col-sm-6 col-md-8 text-left">
                    <div class="intro-message" style="color:#ffffff">
                        <h1>Rugged Tablet</h1>

						<h2>MiTAC Windows 10 Rugged Tablet</h2>
<h3>Born to be the Best Mobile Solution for Vertical and Retail Market</h3>
<br />
<img src="/images/logo/Apollo-Lake-Celeron.jpg" /> <img src="/images/logo/Apollo-Lake-Pentium.jpg" />


<p style="margin-bottom:10%"> </p>



                    </div>
                </div>
				<div class="col-xs-6 col-md-4 text-left" style="padding-top:3%;">
				 <div class="well box" style="background-color: rgba(255, 255, 255, 0.9); ">

				 <strong>New products:</strong><br />
				 <div class="intro-divider "></div><br />
				 <ul style="margin-left:15px">
<li ><a href="/POS_Latte_Latte" target="mit" />Latte</a></li>
<li ><a href="/POS_Cappuccino_Cappuccino" target="mit" />Cappuccino</a></li>



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

<ul class="nav nav-pills" style="margin:40px 0px; ">

  <li role="presentation" ><a href="#Latte">Latte</a></li>
  <li role="presentation"><a href="#Cappu">Cappuccino</a></li>

</ul>



	</div>
	</div>
	<!-- end tabs -->



	<!--Industrial Embedded System-->
	<a name="Latte"></a>
		<div class="container-fluid" style="background:#0D47A1; color:#ffffff" >
<h1 class="container">Latte</h1>
	</div>

	<div class="container-fluid" >
	<p style="margin-top:5%"> </p>
	<div class="container">


	<div class="row">
	<div class="col-md-6"><a href="/POS_Latte_Latte" target="mit" /><img src="/images/product/POS/Latte-1.jpg" class="img-responsive" /></a></div>
  <div class="col-md-6">
   <h2 class="blue_cr"><a href="/POS_Latte_Latte" target="mit" />Latte</a></h2>
  <h3 style="">Intel® Pentium N4200 / <br />Intel® Celeron N3350 & N4100</h3>
   <ul style="margin-left:20px">
<li>7" Windows Tablet</li>
<li>Modularization (Expansion module support)</li>
<li>IP65</li>
<li>MIL-STD-810G 1.5m drop proof</li>
<li>Hot-Swapping Battery</li>
<li>23.18Whr Battery (Option for long-life)</li>
<li>Hardware Decode Scanner 1D/2D</li>
<li>Wireless WAN and LAN</li>
<li>TPM 2.0</li>
<li>Wide-Temperature</li>
<li>Accessory for Vehicle Mounting and I/O Connectivity<br /><br /> <a href="/POS_Latte_Latte" target="mit" /><button type="button" class="btn btn-default">View</button></a></li>

   </ul>


  </div>

</div>


  </div>
  </div>











	 <p style="margin-top:5%"> </p>

	<!--end Industrial Embedded System-->
<!--Commercial Embedded System-->
	<a name="Cappu"></a>
		<div class="container-fluid" style="background:#0D47A1; color:#ffffff" >
<h1 class="container">Cappuccino</h1>
	</div>

	<p style="margin-top:3%"> </p>
	<div class="container-fluid" >
	<p style="margin-top:3%"> </p>
	<div class="container">


	<div class="row">
  <div class="col-md-6">

   <h2 class="blue_cr"><a href="/POS_Cappuccino_Cappuccino" target="mit" />Cappuccino</a></h2>
  <h3 style="">Intel® Pentium N4200 / <br />Intel® Celeron N3350 & N4100</h3>
   <ul style="margin-left:20px">
<li>11.6" Windows Tablet</li>
<li>Extra Light (&lt;900g)</li>
<li>IP65</li>
<li>MIL-STD-810G 1.2m drop proof</li>
<li>Hot-Swapping Battery</li>
<li>19.98Whr Battery (Option for long-life)</li>
<li>Software Decode Scanner 1D/2D</li>
<li>Wireless WAN and LAN</li>
<li>NFC module (optional)</li>
<li>TPM 2.0</li>
<li>Wide-Temperature</li>
<li>Accessory for Vehicle Mounting and I/O Connectivity<br /><br />
<a href="/POS_Cappuccino_Cappuccino" target="mit" /><button type="button" class="btn btn-default">View</button></a>
</li>


   </ul>

  </div>
  <div class="col-md-6"><a href="/POS_Cappuccino_Cappuccino" target="mit" /><img src="/images/product/POS/Cappuccino-1.jpg" class="img-responsive" /></a></div>
</div>











  </div>
  </div>

	 <p style="margin-top:6%"> </p>
	<!--end Commercial Embedded System-->





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