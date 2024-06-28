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
    <title>MiTAC Digital Technology Corp. - Industrial Motherboards</title>
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
.pro_well:hover{border: 1px solid #0D47A1; background-color: #ffffff;}
.sub_des{font-size:0.9em; line-height:130%; text-align: center; color:#626262}






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



    <div style="background: url(/images/product/bg_industrial_motherboard.jpg) no-repeat center center; background-size: cover;" class="intro-header">
        <div class="container">
            <div class="row" style="padding-top: 15%;">
                <div class="col-xs-12 col-sm-6 col-md-8 text-left">
                    <div class="intro-message" style="color:#ffffff">
                        <h1>Industrial Motherboards</h1>
<p>
MiTAC's industrial motherboard ranging from Micro ATX to COMe with high longevity features high computing capability and integration, rich I/O connectivity, expansibility and ideal solution in industrial automation application.

</p>
<br /><p style="margin-bottom:10%">
<!--
<img src="/images/logo/intel_ElkhartLake-ATOM.png" /> <img src="/images/logo/intel-celeron-tigerlake.png" /> <img src="/images/logo/intel_ElkhartLake-Pentium.png" /> <img src="/images/logo/intel_core_i3_2020.png" /> <img src="/images/logo/intel_core_i5_2020.png" /> <img src="/images/logo/intel_core_i7_2020.png" /> -->
  </p>


                    </div>
                </div>
				<div class="col-xs-6 col-md-4 text-left" style="padding-top:3%;">
				 <div class="well box" style="background-color: rgba(255, 255, 255, 0.9); ">

				 <strong>New products:</strong><br />
				 <div class="intro-divider "></div><br />
				 <ul style="margin-left:15px">


<li ><a href="/IndustrialMotherboard=ND108T=ND108T=description=EN" target="mit" />ND108T (Pico-iTX)</a></li>
<li ><a href="/IndustrialMotherboard=PH12ADI=PH12ADI=description=EN" target="mit" />PH12ADI (Thin Mini-ITX)</a></li>
<li ><a href="/IndustrialMotherboard_PH11CMI_PH11CMI" target="mit" />PH11CMI (Thin Mini-ITX)</a></li>
<li ><a href="/IndustrialMotherboard_PH12CMI_PH12CMI" target="mit" />PH12CMI (Thin Mini-ITX)</a></li>
<li ><a href="/IndustrialMotherboard_PH13CMI_PH13CMI" target="mit" />PH13CMI (Mini-ITX)</a></li>
<li><a href="/IndustrialMotherboard%3DPD10EHI%3DPD10EHI%3Ddescription%3DEN" target="mit" />PD10EHI (Mini-ITX)</a></li>
<li><a href="/IndustrialMotherboard%3DPH10CMU%3DPH10CMU%3Ddescription%3DEN" target="mit" />PH10CMU (Micro-ATX)</a></li>
<!--<li><a href="/IndustrialMotherboard%3DPD11TGS%3DPD11TGS%3Ddescription%3DEN" target="mit" />PD11TGS (3.5" SBC)</a></li>-->

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

<ul class="nav nav-pills" style="margin:40px 0px; font-size:1.2em">

  <li role="presentation" ><a href="#M-ATX">Micro ATX</a></li>
  <li role="presentation"><a href="#TMiTX">Thin Mini-iTX</a></li>
  <li role="presentation"><a href="#M-iTX">Mini-iTX</a></li>
  <li role="presentation"><a href="#SBC">3.5 SBC</a></li>
    <li role="presentation"><a href="#Pico-iTX">2.5" Pico-iTX</a></li>
    <li role="presentation"><a href="#COMe">COMe</a></li>
</ul>



	</div>
	</div>
	<!-- end tabs -->

	<!--Micro ATX-->


		<a name="M-ATX"></a>
	<div class="container" style="padding:2% 0%">
	</div>
	<div class="container-fluid" style="background:#0D47A1; color:#ffffff" >
	<h1 class="text-center">Micro ATX</h1>
	</div>
	<p style="margin-top:3%"> </p>
	<div class="container">
  <div class="row">
  <div class="col-md-3">
  <div class="pro_well" ><div style="text-align: center;"><span class="label label-warning">&nbsp;New!&nbsp;</span></div>
<h4 style="text-align: center;">PH10CMU</h4>
<a href="/IndustrialMotherboard%3DPH10CMU%3DPH10CMU%3Ddescription%3DEN" target="mit" /><img src="/images/product/IndustriaMB/PH10CMU.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >Intel 10th Gen Core-i <br>(Comet Lake-S)</div>
</div>

  </div>
    <div class="col-md-3">
	<div class="pro_well" ><br />
<h4 style="text-align: center;">PH10FEU</h4>
<a href="/IndustrialMotherboard%3DPH10FEU%3DPH10FEU%3Ddescription%3DEN" target="mit" /><img src="/images/product/IndustriaMB/PH10FEU.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >Intel 9th/ 8th Gen Core-i<br>
(Coffee Lake-S)
</div>
</div>
	</div>
  <div class="col-md-3">
  <div class="pro_well" ><br />
<h4 style="text-align: center;">PH10SU</h4>
<a href="/IndustrialMotherboard%3DPH10SU%3DPH10SU%3Ddescription%3DEN" target="mit" /><img src="/images/product/IndustriaMB/PH10SU.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >Intel 7th/ 6th Gen Core-i<br>
(Skylake-S)
</div>
</div>
  </div>
  <div class="col-md-3">

  </div>

  </div>

</div>
 <p style="margin-top:6%"> </p>

	<!--end Micro ATX-->
<!--Thin Mini-iTX-->


<a name="TMiTX"></a>
	<div class="container" style="padding:2% 0%">
	</div>
	<div class="container-fluid" style="background:#0D47A1; color:#ffffff" >
	<h1 class="text-center">Thin Mini-iTX</h1>
	</div>

	<p style="margin-top:3%"> </p>

	<div class="container">

	<h2>Core i</h2>


  <div class="row">

  <div class="col-md-3">
<div class="pro_well" ><div style="text-align: center;"><span class="label label-warning">&nbsp;New!&nbsp;</span></div>
<h4 style="text-align: center;">PH12ADI</h4>
<a href="/IndustrialMotherboard=PH12ADI=PH12ADI=description=EN" target="mit" /><img src="/images/product/IndustriaMB/PH12ADI.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >Intel 12th Gen Core-i<br>
(Alder Lake)
</div>
</div>

  </div>



  <div class="col-md-3"><div class="pro_well" ><div style="text-align: center;"><span class="label label-warning">&nbsp;New!&nbsp;</span></div>
<h4 style="text-align: center;">PH11CMI</h4>
<a href="/IndustrialMotherboard_PH11CMI_PH11CMI" target="mit" /><img src="/images/product/IndustriaMB/PH11CMI.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >Intel 10th Gen Core-i<br>
(Comet Lake-S)
</div>
</div></div>


    <div class="col-md-3"><div class="pro_well" ><div style="text-align: center;"><span class="label label-warning">&nbsp;New!&nbsp;</span></div>
<h4 style="text-align: center;">PH12CMI</h4>
<a href="/IndustrialMotherboard_PH12CMI_PH12CMI" target="mit" /><img src="/images/product/IndustriaMB/PH12CMI.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >Intel 10th Gen Core-i<br>
(Comet Lake-S)
</div>
</div></div>



    <div class="col-md-3">
	<div class="pro_well" ><br />
<h4 style="text-align: center;">PH12FEI</h4>
<a href="/IndustrialMotherboard%3DPH12FEI%3DPH12FEI%3Ddescription%3DEN" target="mit" /><img src="/images/product/IndustriaMB/PH12FEI.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >Intel 9th/ 8th Gen Core-i<br>
(Coffee Lake-S)
</div>
</div>
	</div>


  </div> <p style="margin-top:3%"> </p>
  <div class="row">
  <div class="col-md-3">
    <div class="pro_well" ><br />
<h4 style="text-align: center;">PH14FEI</h4>
<a href="/IndustrialMotherboard=PH14FEI=PH14FEI=description=EN" target="mit" /><img src="/images/product/IndustriaMB/PH14FEI.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >Intel 9th/ 8th Gen Core-i<br>
(Coffee Lake-S)
</div>
</div>


	</div>


	<div class="col-md-3">
	 <div class="pro_well" >
<h4 style="text-align: center;">PH12SI</h4>
<a href="/IndustrialMotherboard%3DPH12SI%3DPH12SI%3Ddescription%3DEN" target="mit" /><img src="/images/product/IndustriaMB/PH12SI.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >Intel 7th/ 6th Gen Core-i<br>
(Skylake-S)
</div>
</div>
	</div>
	<div class="col-md-3">
	<div class="pro_well" >
<h4 style="text-align: center;">PH13SI</h4>
<a href="/IndustrialMotherboard%3DPH13SI%3DPH13SI%3Ddescription%3DEN" target="mit" /><img src="/images/product/IndustriaMB/PH13SI.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >Intel 7th/ 6th Gen Core-i<br>
(Skylake-S)
</div>
</div>
	</div>

	<div class="col-md-3">

	</div>
  </div>







  <p style="margin-top:3%"> </p>
  	<h2>Atom</h2>

    <div class="row">

	<div class="col-md-3">
	<div class="pro_well" ><div style="text-align: center;"><span class="label label-warning">&nbsp;New!&nbsp;</span></div>
<h4 style="text-align: center;">PD10EHI</h4>
<a href="/IndustrialMotherboard=PD10EHI=PD10EHI=description=EN" target="mit" /><img src="/images/product/IndustriaMB/PD10EHI.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >Intel N6211/J6413/X6413E<br>
(Elkhart Lake)
</div>
</div>
	</div>
	  <div class="col-md-3">
 <div class="pro_well" ><br>
<h4 style="text-align: center;">PD10AI</h4>
<a href="/IndustrialMotherboard%3DPD10AI%3DPD10AI%3Ddescription%3DEN" target="mit" /><img src="/images/product/IndustriaMB/PD10AI.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >Intel N3350/N4200<br>
(Apollo Lake)
</div>
</div>

  </div>
   <div class="col-md-3">
 <div class="pro_well" ><br>
<h4 style="text-align: center;">PD10RI</h4>
<a href="/IndustrialMotherboard%3DPD10RI%3DPD10RI%3Ddescription%3DEN" target="mit" /><img src="/images/product/IndustriaMB/PD10RI.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >Intel N3160<br>
(Braswell)
</div>
</div>
  </div>
  <div class="col-md-3">
 <div class="pro_well" ><br>
<h4 style="text-align: center;">PD10BI</h4>
<a href="/IndustrialMotherboard%3DPD10BI%3DPD10BI%3Ddescription%3DEN" target="mit" /><img src="/images/product/IndustriaMB/PD10BI.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >Intel J1900<br>
(Bay Trail)
</div>
</div>
  </div>



  </div>










</div>
  <p style="margin-top:6%"> </p>



<!--end Thin Mini-iTX-->
<!--Mini-iTX-->

<a name="M-iTX"></a>
	<div class="container" style="padding:2% 0%">
	</div>
	<div class="container-fluid" style="background:#0D47A1; color:#ffffff" >
	<h1 class="text-center">Mini-iTX</h1>
	</div>

	<p style="margin-top:3%"> </p>
<div class="container">
  <div class="row">
   <div class="col-md-3">
<div class="pro_well" ><div style="text-align: center;"><span class="label label-warning">&nbsp;New!&nbsp;</span></div>
<h4 style="text-align: center;">PH13CMI</h4>
<a href="/IndustrialMotherboard_PH13CMI_PH13CMI" target="mit" /><img src="/images/product/IndustriaMB/PH13CMI.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >Intel 10th Gen Core-i<br>
(Comet Lake-S)
</div>
</div>

  </div>

    <div class="col-md-3">
	<div class="pro_well" ><br>
<h4 style="text-align: center;">PH13FEI</h4>
<a href="/IndustrialMotherboard%3DPH13FEI%3DPH13FEI%3Ddescription%3DEN" target="mit" /><img src="/images/product/IndustriaMB/PH13FEI.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >Intel 9th/ 8th Gen Core-i<br>
(Coffee Lake-S)
</div>
</div>
	</div>
  <div class="col-md-3">
  <div class="pro_well" ><br>
<h4 style="text-align: center;">PD14RI</h4>
<a href="/IndustrialMotherboard%3DPD14RI%3DPD14RI%3Ddescription%3DEN" target="mit" /><img src="/images/product/IndustriaMB/PD14RI.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >Intel N3160<br>
(Braswell)
</div>
</div>
  </div>
  <div class="col-md-3">
  <div class="pro_well" ><br>
<h4 style="text-align: center;">PD11BI</h4>
<a href="/IndustrialMotherboard%3DPD11BI%3DPD11BI%3Ddescription%3DEN" target="mit" /><img src="/images/product/IndustriaMB/PD11BI.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >Intel J1900<br>
(Bay Trail)
</div>
</div>
  </div>


  </div>


</div>
  <p style="margin-top:6%"> </p>
<!--end Mini-iTX-->












<!--3.5 SBC-->

<a name="SBC"></a>
	<div class="container" style="padding:2% 0%">
	</div>
	<div class="container-fluid" style="background:#0D47A1; color:#ffffff" >
	<h1 class="text-center">3.5 SBC</h1>
	</div>

	<p style="margin-top:3%"> </p>
<div class="container">
  <div class="row">
  <div class="col-md-3">
<div class="pro_well" ><div style="text-align: center;"><span class="label label-warning">&nbsp;New!&nbsp;</span></div>
<h4 style="text-align: center;">PD11TGS</h4>
<a href="/IndustrialMotherboard%3DPD11TGS%3DPD11TGS%3Ddescription%3DEN" target="mit" /><img src="/images/product/IndustriaMB/PD11TGS.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >Intel 11th Gen Core-i<br>
(Tiger Lake-UP3)
</div>
</div>
  </div>


    <div class="col-md-3">

  <div class="pro_well" ><br>
<h4 style="text-align: center;">PD11KS</h4><br />
<a href="/IndustrialMotherboard%3DPD11KS%3DPD11KS%3Ddescription%3DEN" target="mit" /><img src="/images/product/IndustriaMB/PD11KS.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >Intel 7th/ 6th Gen Core-i<br>
(Kaby Lake-U)
</div>
</div>
	</div>
  <div class="col-md-3">
  <div class="pro_well" ><br>
<h4 style="text-align: center;">PD10KS</h4><br />
<a href="/IndustrialMotherboard%3DPD10KS%3DPD10KS%3Ddescription%3DEN" target="mit" /><img src="/images/product/IndustriaMB/PD10KS.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >Intel 7th/ 6th Gen Core-i<br>
(Kaby Lake-U)
</div>
</div>
  </div>
  <div class="col-md-3">
  <div class="pro_well" ><br>
<h4 style="text-align: center;">PD10AS</h4><br />
<a href="/IndustrialMotherboard%3DPD10AS%3DPD10AS%3Ddescription%3DEN" target="mit" /><img src="/images/product/IndustriaMB/PD10AS.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >Intel N3350/N4200/E3930<br>
(Apollo Lake)
</div>
</div>

  </div>

  </div>


</div>
  <p style="margin-top:6%"> </p>

<!--end3.5 SBC-->




<!--Pico-iTX-->



<a name="Pico-iTX"></a>
	<div class="container" style="padding:2% 0%">
	</div>
	<div class="container-fluid" style="background:#0D47A1; color:#ffffff" >
	<h1 class="text-center">2.5" Pico-iTX</h1>
	</div>
	<p style="margin-top:3%"> </p>

<div class="container">
  <div class="row">
    <div class="col-md-3">
	<div class="pro_well" ><div style="text-align: center;"><span class="label label-warning">&nbsp;New!&nbsp;</span></div>
<h4 style="text-align: center;">ND108T</h4>
<a href="/IndustrialMotherboard=ND108T=ND108T=description=EN" target="mit" /><img src="/images/product/IndustriaMB/ND108T.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >NXP i.MX8M</div>
</div>
	</div>
  <div class="col-md-3">
  <div class="pro_well" ><div style="text-align: center;"><span class="label label-warning">&nbsp;New!&nbsp;</span></div>
<h4 style="text-align: center;">ND118T</h4>
<a href="/IndustrialMotherboard%3DND118T%3DND118T%3Ddescription%3DEN" target="mit" /><img src="/images/product/IndustriaMB/ND118T.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >NXP i.MX8M</div>
</div>

  </div>
  <div class="col-md-3">

  </div>
  <div class="col-md-3">

  </div>
  </div>


</div>
  <p style="margin-top:6%"> </p>
<!--end Pico-iTX-->










<!--COMe-->



<a name="COMe"></a>
	<div class="container" style="padding:2% 0%">
	</div>
	<div class="container-fluid" style="background:#0D47A1; color:#ffffff" >
	<h1 class="text-center">COMe</h1>
	</div>
	<p style="margin-top:3%"> </p>

<div class="container">
  <div class="row">
    <div class="col-md-3">
	<div class="pro_well" >
<h4 style="text-align: center;">PD10KC</h4>
<a href="/IndustrialMotherboard%3DPD10KC%3DPD10KC%3Ddescription%3DEN" target="mit" /><img src="/images/product/IndustriaMB/PD10KC.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >Intel 7th/ 6th Gen Core-i<br>
(Kaby Lake-U)
</div>
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
  <p style="margin-top:6%"> </p>
<!--end COMe-->






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