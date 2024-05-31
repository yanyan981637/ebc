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
    <title>MiTAC Computing Technology Corp. - Storage Platform</title>
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



    <div style="background: url(/images/product/bg_storage_platform.jpg) no-repeat center center; background-size: cover;" class="intro-header">
        <div class="container">
            <div class="row" style="padding-top: 15%;">
                <div class="col-xs-12 col-sm-6 col-md-8 text-left">
                    <div class="intro-message" style="color:#ffffff">
                        <h1>Storage Platform</h1><h3 style="color:#18ffff">Diverse Storage Choices for Data Centers and Enterprise Systems.</h3>
<p>
MiTAC storage platforms for datacenters and enterprise systems address a 

full spectrum of needs. From attached storage (DAS), storage area networks 

(SAN), and network attached storage (NAS) environments to support for a 

variety of industry storage protocols including Fibre Channel, iSCSI, 

SAS/SATA, NVMe and NVMe over fabric, these platforms ensure that users are 

able to find the right solution.

</p>
<br />

 

<p style="margin-bottom:10%"> </p>


                      
                    </div>
                </div>
				<div class="col-xs-6 col-md-4 text-left" style="padding-top:3%;">
				 <div class="well box" style="background-color: rgba(255, 255, 255, 0.9); ">
				 
				 <strong>JBOD:</strong><br />
				 <div class="intro-divider "></div><br />
				 <ul style="margin-left:15px">
<li ><a href="/JBODJBOF_TN52J-E3252_J3252T52U24HR-U8DR" target="mit" />TN52J-E3252</a></li>
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

  <li role="presentation" ><a href="#JBOD">JBOD</a></li>
 <li role="presentation" ><a href="#JBOF">JBOF</a></li>
<li role="presentation" ><a href="#NVMe_JBOF">NVMe over Fabrics JBOF</a></li>
</ul>

	
	
	</div>
	</div>
	<!-- end tabs -->	
	
	<!--JBOD-->
	
<a name="JBOD"></a>
	<div class="container" style="padding:2% 0%">
	</div>
	<div class="container-fluid" style="background:#0D47A1; color:#ffffff" >
	<h1 class="text-center">JBOD</h1>
	</div>

<p style="margin-top:3%"> </p>

<div class="container">
<div class="row">
<div class="col-md-3">
	<div class="pro_well" ><br />
<h4 style="text-align: center;">TN52J-E3252</h4>
<br /><a href="/JBODJBOF_TN52J-E3252_J3252T52U24HR-U8DR" target="mit" /><img src="/images/product/JBODJBOF/TN52JE3252.jpg" class="img-responsive" /></a><br /><br />
<div class="sub_des" style="line-height:150%" ><span style="color:#0D47A1; font-size:1.4em">(24) 2.5" SAS 12G JBOD</span></div><br /><br />
</div>
	</div>
	<div class="col-md-3">
	<div class="pro_well" >
	<div style="position: relative; text-align: center;  background:#8fc31f; padding:2px; color:#ffffff; font-size:0.5em;">Coming Soon!</div>
<h4 style="text-align: center;">PM4233L</h4>
<a href="/EN/contact/" target="mit" /><img src="/images/product/JBODJBOF/PM4233L.jpg" class="img-responsive" /></a><br />
<div class="sub_des" style="line-height:150%" ><span style="color:#0D47A1; font-size:1.4em">4U 24x 3.5" SAS4 JBOD</span><br />
High Availability<br />Design in Broadcom  SAS4 expender

</div>
</div>
	</div>
	<div class="col-md-3">
	
	</div>
	<div class="col-md-3">
	
	</div>
</div>


</div>

	
	<p style="margin-top:3%"> </p>	
<!--end JBOD-->



<!--JBOF-->




<a name="JBOF"></a>
	<div class="container" style="padding:2% 0%">
	</div>
	<div class="container-fluid" style="background:#0D47A1; color:#ffffff" >
	<h1 class="text-center">JBOF</h1>
	</div>
	<p style="margin-top:3%"> </p>
<div class="container">
<div class="row">
<div class="col-md-3">
	<div class="pro_well" >
	<div style="position: relative; text-align: center;  background:#8fc31f; padding:2px; color:#ffffff; font-size:0.5em;">Coming Soon!</div>
<h4 style="text-align: center;">FR2223</h4>
<a href="/EN/contact/" target="mit" /><img src="/images/product/JBODJBOF/FR2223.jpg" class="img-responsive" /></a><br />
<div class="sub_des" style="line-height:150%" ><span style="color:#0D47A1; font-size:1.4em">2U 24 x 2.5" PCIE G4 NVMe SSD JBOF</span><br />
High Availability<br />
Design in Broadcom PCIe G4 Switch
</div>
</div>
	</div>
	<div class="col-md-3">
	<!--<div class="pro_well" >
	<div style="position: relative; text-align: center;  background:#8fc31f; padding:2px; color:#ffffff; font-size:0.5em;">Coming Soon!</div>
<h4 style="text-align: center;">RK2223</h4>
<a href="/EN/contact/" target="mit" /><img src="/images/product/JBODJBOF/RK2223.jpg" class="img-responsive" /></a><br />
<div class="sub_des" style="line-height:150%" ><span style="color:#0D47A1; font-size:1.4em">2U 24 x 2.5" PCIE G4 NVMe SSD JBOF</span><br />
High Availability<br />
Design in Microchip PCIe G4 Switch
</div>
</div>-->
	</div>
	<div class="col-md-3">
	
	</div>
	<div class="col-md-3">
	
	</div>
</div>
</div>

	
	<p style="margin-top:3%"> </p>	
<!--end JBOF-->


<!--NVMe_JBOF-->

<a name="NVMe_JBOF"></a>
	<div class="container" style="padding:2% 0%">
	</div>
	<div class="container-fluid" style="background:#0D47A1; color:#ffffff" >
	<h1 class="text-center">NVMe over Fabrics JBOF</h1>
	</div>
	<p style="margin-top:3%"> </p>
<div class="container">
<div class="row">
<div class="col-md-3">
	<div class="pro_well" >
	<div style="position: relative; text-align: center;  background:#8fc31f; padding:2px; color:#ffffff; font-size:0.5em;">Coming Soon!</div>
<h4 style="text-align: center;">HT2221F</h4>
<a href="/EN/contact/" target="mit" /><img src="/images/product/JBODJBOF/HT2221F.jpg" class="img-responsive" /></a><br />
<div class="sub_des" style="line-height:150%" ><span style="color:#0D47A1; font-size:1.4em">2U 24 x 2.5" NVMe over Fabrics PCIE G3 JBOF</span><br />
High Availability, 7.5M IOPS<br />
Design in Mellanox BlueField Solution<br /><br />
</div>
</div>
	</div>
	<div class="col-md-3">
	<!--<div class="pro_well" >
	<div style="position: relative; text-align: center;  background:#8fc31f; padding:2px; color:#ffffff; font-size:0.5em;">Coming Soon!</div>
<h4 style="text-align: center;">SN2251</h4>
<a href="/EN/contact/" target="mit" /><img src="/images/product/JBODJBOF/SN2251.jpg" class="img-responsive" /></a><br />
<div class="sub_des" style="line-height:150%" ><span style="color:#0D47A1; font-size:1.4em">2U 24 x 2.5" NVMe over Fabrics PCIE G4 JBOF</span><br />
High Availability, <br />
Kazan Onyx / Broardcom Stingray smart NIC card compliable 
</div>
</div>-->
	</div>
	<div class="col-md-3">
	
	</div>
	<div class="col-md-3">
	
	</div>
</div>
</div>

	
	<p style="margin-top:3%"> </p>	
<!--end NVMe_JBOF-->


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