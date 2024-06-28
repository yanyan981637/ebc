<?php
header("X-Frame-Options: DENY");
//header("Content-Security-Policy-Report-Only: default-src *; img-src https:; frame-src 'none'; report-uri http://www.tyan.com");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://www.tyan.com");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

//if(strpos(trim(getenv('REQUEST_URI')),'?')!='' || strpos(trim(getenv('REQUEST_URI')),'?')===0 || strpos(trim(getenv('REQUEST_URI')),"'")!='' || strpos(trim(getenv('REQUEST_URI')),"'")===0 || strpos(trim(getenv('REQUEST_URI')),"script")!=''){
if(strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
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
    <title>MiTAC Digital Technology Corp. - Embedded System</title>
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
.sub_des{font-size:0.9em; line-height:120%; text-align: left; color:#626262}






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
  include_once("../analyticstracking.php");
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



    <div style="background: url(/images/product/bg_embedded_system.jpg) no-repeat center center; background-size: cover;" class="intro-header">
        <div class="container">
            <div class="row" style="padding-top: 15%;">
                <div class="col-xs-12 col-sm-6 col-md-8 text-left">
                    <div class="intro-message" style="color:#ffffff">
                        <h1>Embedded System</h1>
<p>
MiTAC's embedded system, including industrial and commercial series powered by state of the art processors, whole new SOC structure packs and more powerful capability for your tasks and applications.

</p>
<br />
<!--
<img src="/images/logo/intel_core_i3_2020.png" /> <img src="/images/logo/intel_core_i5_2020.png" /> <img src="/images/logo/intel_core_i7_2020.png" /> <img src="/images/logo/Apollo-Lake-Celeron.jpg" /> <img src="/images/logo/Apollo-Lake-Pentium.jpg" /> -->


<p style="margin-bottom:10%"> </p>



                    </div>
                </div>
				<div class="col-xs-6 col-md-4 text-left" style="padding-top:3%;">
				 <div class="well box" style="background-color: rgba(255, 255, 255, 0.9); ">

				 <strong>New products:</strong><br />
				 <div class="intro-divider "></div><br />
				 <ul style="margin-left:15px">
<li ><a href="/EmbeddedSystem%3DNV1%3DNV1%3Ddescription%3DEN" target="mit" />NV1</a> (Tiger Lake-UP3)</li>
<li ><a href="/EmbeddedSystem%3DE310%3DE310%3Ddescription%3DEN" target="mit" />E310</a> (Elkhart Lake)</li>
<li ><a href="/EmbeddedSystem%3DE410%3DE410%3Ddescription%3DEN" target="mit" />E410</a> (Comet Lake)</li>
<li ><a href="/EmbeddedSystem%3DMP1-11TGS%3DMP1-11TGS%3Ddescription%3DEN" target="mit" />MP1-11TGS</a> / <a href="/EmbeddedSystem%3DMP1-11TGS-D%3DMP1-11TGS-D%3Ddescription%3DEN" target="mit" />MP1-11TGS-D</a> (Tiger Lake-UP3)</li>
<li ><a href="/EmbeddedSystem%3DME1-108T%3DME1-108T%3Ddescription%3DEN" target="mit" />ME1-108T (NXP i.MX8M)</a></li>





</ul>


				</div>
				<br />


				</div>
            </div>

        </div>
        <!-- /.container -->

    </div>



	<!-- tabs -->
	<!--<div style="background:#f8f8f8">
	<div class="container" >

<ul class="nav nav-pills" style="margin:40px 0px; font-size:1.2em">

  <li role="presentation" ><a href="#Ind-ES">Industrial Embedded System</a></li>


</ul>



	</div>
	</div>
	<!-- end tabs -->



	<!--Industrial Embedded System-->


	<a name="Ind-ES"></a>
	<!--<div class="container" style="padding:2% 0%">
	</div>-->
	<div class="container-fluid" style="background:#0D47A1; color:#ffffff" >

	<h1 class="text-center">Industrial Embedded System</h1>


	</div>





	<div class="container-fluid" >
	<p style="margin-top:3%"> </p>
	<div class="container">
	 <h2 class="blue_cr">Rugged & Modularized</h2>

	</div>
	<p style="margin-top:3%"> </p>
	<div class="container">

	<div class="row">
	<div class="col-md-4">
	  <div class="pro_well" >
<h4 style="text-align: center;">MX1-10FEP-D</h4>
<a href="/EmbeddedSystem=MX1-10FEP-D=MX1-10FEP-D=description=EN" target="mit" /><img src="/images/product/Embedded/MX1-10FEP-D-c1.jpg" class="img-responsive" /></a><br /><div class="sub_des" >
 <ul style="margin-left:20px; ">
<li>Intel 9th/ 8th Gen (Coffee Lake-S),  Xeon/Core Processor</li>
<li>MiTAC Xpansion I/O module options</li>
<li>PCIe x16 Nvidia GPU card support</li>
 </ul>
 </div>
</div>
	</div>
	<div class="col-md-4">
	<div class="pro_well" >
<h4 style="text-align: center;">MX1-10FEP</h4>
<a href="/EmbeddedSystem%3DMX1-10FEP%3DMX1-10FEP%3Ddescription%3DEN" target="mit" /><img src="/images/product/Embedded/MX1-10FEP-c1.jpg" class="img-responsive" /></a><br />
<div class="sub_des" ><ul style="margin-left:20px; ">
<li>Intel 9th/ 8th Gen (Coffee Lake-S), Xeon/Core Processor</li>
<li>MiTAC Xpansion I/O module options</li>
<li>PCIe x16 I/O card support</li>
 </ul>
</div>
</div>
	</div>
	<div class="col-md-4">
	<div class="pro_well" > <div style="text-align: center;"><span class="label label-warning">&nbsp;New!&nbsp;</span></div>
<h4 style="text-align: center;">MP1-11TGS-D</h4>
<a href="/EmbeddedSystem%3DMP1-11TGS-D%3DMP1-11TGS-D%3Ddescription%3DEN" target="mit" /><img src="/images/product/Embedded/MP1-11TGS-D1.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >
<ul style="margin-left:20px; ">
<li>Intel 11th Gen (Tiger Lake-UP3) Core Processor</li>
<li>MiTAC Xpansion I/O module options</li>
 </ul></div>
</div>

	</div>
	</div>


		<div class="row">
	<div class="col-md-4">
	    <div class="pro_well" >
  <div style="text-align: center;"><span class="label label-warning">&nbsp;New!&nbsp;</span></div>
<h4 style="text-align: center;">MP1-11TGS</h4>
<a href="/EmbeddedSystem%3DMP1-11TGS%3DMP1-11TGS%3Ddescription%3DEN" target="mit" /><img src="/images/product/Embedded/MP1-11TGS-1.jpg" class="img-responsive" /></a><br />
<div class="sub_des" style="text-align:center">
Intel 11th Gen (Tiger Lake-UP3) Core Processor<br /><br />
</div>
</div>


	</div>
	<div class="col-md-4">
	<div class="pro_well" >
  <br />
<h4 style="text-align: center;">MB1-10AP</h4>
<a href="/EmbeddedSystem%3DMB1-10AP%3DMB1-10AP%3Ddescription%3DEN" target="mit" /><img src="/images/product/Embedded/MB1-10AP-c1.jpg" class="img-responsive" /></a><br /><div class="sub_des" >
<ul style="margin-left:20px; ">
<li>Intel N3350N/N4200 (Apollo Lake) SoC Processors</li>
<li>MiTAC Xpansion I/O module options</li>
</ul>
</div>
</div>

	</div>
	<div class="col-md-4">
	<div class="pro_well" >
  <div style="text-align: center;"><span class="label label-warning">&nbsp;New!&nbsp;</span></div>
<h4 style="text-align: center;">ME1-108T</h4>
<a href="/EmbeddedSystem%3DME1-108T%3DME1-108T%3Ddescription%3DEN" target="mit" /><img src="/images/product/Embedded/ME1-108T-c1.jpg" class="img-responsive" /></a><br /><div class="sub_des" style="text-align:center">NXP ARM-based i.MX8M<br /><br /><br /></div>
</div>

	</div>
	</div>


	<div class="row">
	<div class="col-md-4">
	<div class="pro_well" >
  <div style="text-align: center; margin-bottom:10px"><span class="label label-warning">&nbsp;New!&nbsp;</span></div>
   <!--<div style="text-align: center;"><span class="label label-default">Coming soon!</span></div>-->
<h4 style="text-align: center;">ME1-118T</h4>
<a href="/EmbeddedSystem%3DME1-118T%3DME1-118T%3Ddescription%3DEN" target="mit" /><img src="/images/product/Embedded/ME1-118T.jpg" class="img-responsive" /></a><br /><div class="sub_des" style="text-align:center">NXP ARM-based i.MX8M<br /><br /><br /></div>
</div>

	</div>
	<div class="col-md-4">
	</div>
	<div class="col-md-4">
	</div>
	</div>








  </div><p style="margin-top:3%"> </p>
  </div>

  <div class="container-fluid" style="background-color:#f8f8f8">



  <p style="margin-top:3%"> </p>
	<div class="container">
	<h2 class="blue_cr">Industrial & Compact</h2>
	</div>
	<p style="margin-top:3%"> </p>

  <div class="container">
	<div class="row">
	<div class="col-md-4">
	  <div class="pro_well" >
<h4 style="text-align: center;">S300-10AS</h4>
<a href="/EmbeddedSystem%3DS300-10AS%3DS300-10AS%3Ddescription%3DEN" target="mit" /><img src="/images/product/Embedded/S300-10AS-1.jpg" class="img-responsive" /></a>
<div class="sub_des" >
<ul style="margin-left:20px; ">
<li>Intel N3350 (Apollo Lake) SoC Processors</li>
<li>Fanless design</li>
<li>External Power Adapter</li>
</ul></div>
</div>

	</div>
	<div class="col-md-4">
	 <div class="pro_well" >
<h4 style="text-align: center;">S310-11KS</h4>
<a href="/EmbeddedSystem=S310-11KS=S310-11KS=description=EN" target="mit" /><img src="/images/product/Embedded/S310-11KS-1.jpg" class="img-responsive" /></a>
<div class="sub_des" >
<ul style="margin-left:20px; ">
<li>Intel 7th/ 6th Gen (Kaby Lake-U) Core Processor</li>
<li>Fanless design</li>
<li>External Power Adapter</li>
</ul>
</div>
</div>

	</div>
	<div class="col-md-4">
	 <div class="pro_well" >
<h4 style="text-align: center;">E300</h4>
<a href="/EmbeddedSystem%3DE300%3DE300%3Ddescription%3DEN" target="mit" /><img src="/images/product/Embedded/E300-1.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >
<ul style="margin-left:20px; ">
<li>Intel J1900 (Bay Trail) SoC Processors</li>
<li>Fanless design</li>
<li>External Power Adapter</li>
</ul>
</div>
</div>

	</div>
	</div>

	<div class="row">
	<div class="col-md-4">

 <div class="pro_well" >
<h4 style="text-align: center;">E400</h4>
<a href="/EmbeddedSystem%3DE400%3DE400%3Ddescription%3DEN" target="mit" /><img src="/images/product/Embedded/E400-1.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >
<ul style="margin-left:20px; ">
<li>Intel J1900 (Bay Trail) SoC Processors</li>
<li>Fanless design</li>
<li>Internal Power Supply</li>
</ul>

</div>
</div>
	</div>
	<div class="col-md-4">


	</div>
	<div class="col-md-4">


	</div>
	</div>



	</div>


  </div>


	<div class="container-fluid" >

	  <p style="margin-top:3%"> </p>
	<div class="container">
	<h2 class="blue_cr">Performance & Multifunctional</h2>
	</div>
	<p style="margin-top:3%"> </p>
	<div class="container">

	<div class="row">
	<div class="col-md-4">
	<div class="pro_well" > <div style="text-align: center;"><span class="label label-warning">&nbsp;New!&nbsp;</span></div>
<h4 style="text-align: center;">E310</h4>
<a href="/EmbeddedSystem%3DE310%3DE310%3Ddescription%3DEN" target="mit" /><img src="/images/product/Embedded/E310.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >
<ul style="margin-left:20px; ">
<li>Intel® Elkhart Lake Atom/Celeron/Pentium Processor</li>
<li>Fanless</li>
<li>External Power Adapter</li>
</ul>

</div>
</div>

	</div>
	<div class="col-md-4">
	 	<div class="pro_well" > <div style="text-align: center;"><span class="label label-warning">&nbsp;New!&nbsp;</span></div>
<h4 style="text-align: center;">E410</h4>
<a href="/EmbeddedSystem%3DE410%3DE410%3Ddescription%3DEN" target="mit" /><img src="/images/product/Embedded/E410.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >
<ul style="margin-left:20px; ">
<li>10th Intel® Comet Lake Processor</li>
<li>Fanless</li>
<li>External Power Adapter</li>
</ul>

</div>
</div>

	</div>
	<div class="col-md-4">
	 <div class="pro_well" > <div style="text-align: center;"><!--<span class="label label-warning">&nbsp;New!&nbsp;</span>--></div>
<h4 style="text-align: center;">E500</h4>
<a href="/EmbeddedSystem%3DE500%3DE500%3Ddescription%3DEN" target="mit" /><img src="/images/product/Embedded/E500.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >
<ul style="margin-left:20px; ">
<li>Intel 9th/ 8th Gen (Coffee Lake-S), Xeon/Core Processor</li>
<li>With FAN</li>
<li>External Power Adapter</li>
</ul>

</div>
</div>

	</div>
	</div>


	<div class="row">
	<div class="col-md-4">
	 <div class="pro_well" > <div style="text-align: center;"><!--<span class="label label-warning">&nbsp;New!&nbsp;</span>--></div>
<h4 style="text-align: center;">E600</h4>
<a href="/EmbeddedSystem%3DE600%3DE600%3Ddescription%3DEN" target="mit" /><img src="/images/product/Embedded/E600.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >
<ul style="margin-left:20px; ">
<li>Intel 9th/ 8th Gen (Coffee Lake-S),  Xeon/Core Processor</li>
<li>With FAN</li>
<li>Internal Power Supply</li>
</ul>
</div>
</div>
	</div>
	<div class="col-md-4">
	</div>
	<div class="col-md-4">
	</div>
	</div>





	</div>












  </div>








	 <p style="margin-top:6%"> </p>





  <div class="container-fluid" style="background-color:#f8f8f8">



  <p style="margin-top:3%"> </p>
	<div class="container">
	<h2 class="blue_cr">NVR</h2>
	</div>
	<p style="margin-top:3%"> </p>

  <div class="container">
	<div class="row">
	<div class="col-md-4">
	  <div class="pro_well" ><div style="text-align: center;"><span class="label label-warning">&nbsp;New!&nbsp;</span></div>
<h4 style="text-align: center;">NV1</h4>
<a href="/EmbeddedSystem=NV1=NV1=description=EN" target="mit" /><img src="/images/product/Embedded/NV1.jpg" class="img-responsive" /></a>
<div class="sub_des" >
1U Smart NVR System with Intel® Tiger Lake-UP3 Processor</div>
</div>

	</div>
	<div class="col-md-4">

	</div>
	<div class="col-md-4">


	</div>
	</div>



	</div>


	 	 <p style="margin-top:6%"> </p>
  </div>










	<!--end Industrial Embedded System-->





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