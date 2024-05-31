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
    <title>MiTAC Computing Technology Corp. - OCP: SEBA Solution</title>
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



    <div style="background: url(/images/product/bg_OCP-SEBA.jpg) no-repeat center center; background-size: cover;" class="intro-header">
        <div class="container">
            <div class="row" style="padding-top: 20%;">
                <div class="col-md-12 text-center">
                    <div class="intro-message" style="color:#ffffff">
                        <h1>OCP - SEBA&#8482; Solution</h1>
<h3>From Edge to Cloud
New Generation Central Office with
OCP Solutions</h3>
<br />
<p style="margin-bottom:10%"> </p>


                      
                    </div>
                </div>
			
            </div>

        </div>
        <!-- /.container -->

    </div>
	
	<div class="container-fluid" style="background:#0D47A1; color:#ffffff" >
<h1 class="container">OCP - SEBA&#8482; Solution</h1>	
	</div>
<div class="container-fluid" style="background-color:#ffffff">
<div class="container" >


<p style="margin-top:6%"> </p>
<div class="row">
<div class="col-sm-5"><a href="/products/OCP" /><img src="/images/product/OCPserver/OCP_SEBA-5.jpg" alt="OCP SEBA Solution" class="img-responsive"></a></div>
<div class="col-sm-7">

<div class="row">
<div class="col-sm-6 text-center">
<div><a href="/OCPMezz_ML41202-P_ML41202-P" /><img src="/images/product/OCPserver/OCP_SEBA-6.jpg" alt="OCP SEBA Solution" class="img-responsive"></a></div>
<h4 style="margin:2% 0">OCP Mezzanine</h4>
</div>
<div class="col-sm-6 text-center">
<div><a href="/OCPserver_E7278_E7278-S" /><img src="/images/product/OCPserver/OCP_SEBA-7.jpg" alt="OCP SEBA Solution" class="img-responsive"></a></div>
<h4 style="margin:2% 0">OCP Compute Node</h4>
</div>
</div>
<p style="margin-top:6%"> </p>
<div class="row">
<div class="col-sm-6 text-center">
<div><a href="/OCPRack_ESA_ESA" /><img src="/images/product/OCPserver/OCP_SEBA-8.jpg" alt="OCP SEBA Solution" class="img-responsive"></a></div>
<h4 style="margin:2% 0">OCP ESA Kit</h4>
</div>
<div class="col-sm-6 text-center">
<div><img src="/images/product/OCPserver/OCP_SEBA-9.jpg" alt="OCP SEBA Solution" class="img-responsive"></div>
<h4 style="margin:2% 0">OCP JBOF</h4>
</div>
</div>
<p style="margin-top:6%"> </p>
<div class="row">
<div class="col-sm-12 text-center"><a href="/products/OCP" /><img src="/images/product/OCPserver/OCP_SEBA-10.gif" alt="OCP SEBA Solution" class="img-responsive"></a></div>
</div>

</div>
</div>














<p style="margin-top:6%"> </p>
</div>
</div>	
	
	<div class="container-fluid" style="background:#7bad2d; color:#ffffff" ><p style="margin-top:2%"> </p>
	<div class="container">
	<div class="row">
<div class="col-sm-1"></div>
<div class="col-sm-2 text-center">
<div><img src="/images/product/OCPserver/OCP_SEBA-icon1.gif" alt="OCP SEBA Solution" class="img-responsive"></div>
<p style="margin:2% 0">33%+ More Power Savings</p>
</div>
<div class="col-sm-2 text-center">
<div><img src="/images/product/OCPserver/OCP_SEBA-icon2.gif" alt="OCP SEBA Solution" class="img-responsive"></div>
<p style="margin:2% 0">Less Expenditure</p>
</div>
<div class="col-sm-2 text-center">
<div><img src="/images/product/OCPserver/OCP_SEBA-icon3.gif" alt="OCP SEBA Solution" class="img-responsive"></div>
<p style="margin:2% 0">Quick Adoption</p>
</div>
<div class="col-sm-2 text-center">
<div><img src="/images/product/OCPserver/OCP_SEBA-icon4.gif" alt="OCP SEBA Solution" class="img-responsive"></div>
<p style="margin:2% 0">Interchangeable</p>
</div>
<div class="col-sm-2 text-center">
<div><img src="/images/product/OCPserver/OCP_SEBA-icon5.gif" alt="OCP SEBA Solution" class="img-responsive"></div>
<p style="margin:2% 0">Vendor Lock-in Free</p>
</div>
<div class="col-sm-1"></div>	
	</div></div>
	<p style="margin-top:2%"> </p></div>	
	
	
	
	<div class="container-fluid" style="background-color:#f8f8f8"><p style="margin-top:6%"> </p>
<div class="container" >	
<h2 class="blue_cr">Toward the Next Generation Central Office</h2>

<div class="row"  style="">
<div class="col-sm-12">
<p style="margin-top:3%"> </p>

Telecom operators manage thousands of central offices, but
are locked by legacy hardware and high costs. <a href="#" data-toggle="tooltip" title="CORD : Central Office Re-architected as Datacenter. CORD enables the economies of a data center and the flexibility of SDN by applying Cloud-Native Infrastructure to Central
Office with white box solutions." />CORD</a> ,
combines SDN, NFV, commodity hardware and cloud
services to create more efficient, agile networks at the edge.
The edge affords an opportunity to customize the network
and services for individual customer segments.<br /><br />
As network functions virtualization (NFV) has gained more
success over the past years, telecom operators are adopting
the idea of disaggregating application and function from the
proprietary hardware platforms used to run telecom
applications in favor of commercial off-the-shelf (COTS)
hardware deployed as a cloud infrastructure.
<p style="margin-top:3%"> </p>
</div>
</div>
<div class="row">
<div class="col-sm-6"><img src="/images/product/OCPserver/OCP_SEBA-1.gif" alt="OCP SEBA Solution" class="img-responsive"></div>
<div class="col-sm-6"><img src="/images/product/OCPserver/OCP_SEBA-2.jpg" alt="OCP SEBA Solution" class="img-responsive"></div>
</div>	
</div><p style="margin-top:5%"> </p>		
</div>	
	

<div class="container-fluid" style="background-color:#ffffff"><p style="margin-top:6%"> </p>
<div class="container" >
<div class="row">
<div class="col-sm-6">
<p style="margin-top:3%"> </p>
<h2 class="blue_cr" style="border-bottom: 1px dotted #898989">Partnership<br /><br /></h2>	
<div class="row">
<div class="col-sm-4">
<img  src="/images/product/OCPserver/OCP_logo-1.gif" alt="OCP SEBA Solution" class="img-responsive" style="margin:0%">
</div><div class="col-sm-8"><p>

MiTAC and Edgecore are both Platinum
Members of OCP. (Edgecore is also the
board partner member of ONF.)
MiTAC and Edgecore have collaborated
and joined <span style="font-weight:700; color:#7bad2d">provide the world's first OCP
<a href="https://www.opennetworking.org/seba/" target="SEBA" data-toggle="tooltip" title="SEBA : SDN-Enabled Broadband Access. SEBA is a lightweight platform of R-CORD (Residential CORD includes services that leverage wireline access technologies). It supports a multitude of virtualized access technologies at the edge of the carrier network. SEBA supports both residential access and wireless with white box equipment including OLT, and switches and servers for the SDN broadband access." />SEBA&#8482;</a> POD solution in 2019</span>.

</p></div>
</div>
</div>
<div class="col-sm-6">
<h2 class="blue_cr" style="border-bottom: 1px dotted #898989">SEBA&#8482; Recommended Hardware</h2>
<p>MiTAC's Tioga Pass is a <a href="https://www.opennetworking.org/seba/" target="SEBA" />SEBA&#8482;</a> validated server; together
with our OCP ESA kit in the OCP <a href="https://www.opennetworking.org/seba/" target="SEBA" />SEBA&#8482;</a> POD, it helps
telecom carriers adopt OCP solutions supporting their
service in a central office as a cloud native infrastructure
with optimized power efficiency.</p>

</div>
</div><p style="margin-top:10%"> </p>
<img src="/images/product/OCPserver/OCP_SEBA-4.jpg" alt="OCP SEBA Solution" class="img-responsive">



<p style="margin-top:10%"> </p>

</div>
</div>
	
	<!--
<div class="container-fluid" style="background-color:#f8f8f8"><p style="margin-top:6%"> </p>
<div class="container text-center" >	
	<iframe width="920" height="517" src="https://www.youtube.com/embed/0Luqzy0JiD0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	
	
	
</div><p style="margin-top:6%"> </p>
</div>-->	
<div class="container-fluid" style="background:#7bad2d; color:#ffffff"><p style="margin-top:2%"> </p>
<div class="container" >	
	<h3>Any questions, welcome to contact with us!&nbsp;&nbsp;&nbsp;&nbsp;<a href="/EN/contact/" /><button type="button" class="btn btn-default" style="font-size:26px; border:1px solid #626262; ">&nbsp;&nbsp;Contact Us&nbsp;&nbsp;</button></a></h3>
</div><p style="margin-top:2%"> </p>
</div>	


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

<script>
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})
</script>

</body>
</html>