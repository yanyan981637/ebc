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
    <title>MiTAC Computing Technology Corp. - Open Compute Project (OCP)</title>
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



    <div style="background: url(/images/product/bg_OCP-2.jpg) no-repeat center center; background-size: cover;" class="intro-header">
        <div class="container">
            <div class="row" style="padding-top: 20%;">
                <div class="col-md-6 text-left">
                    <div class="intro-message" style="color:#ffffff">
                        <h1>Open Compute Project (OCP)</h1>
<p>
Starting in 2013, MiTAC began developing our first OCP Computing Project, Leopard. <br /><br />
Tioga Pass, MiTAC's 2nd generation, provides great improvement in power efficiency and is well recognized by world class telco companies. 
MiTAC was the first to provide the ESA, an Enclosure Sub Assembly, designed to enable standard 19 inch rack users to adopt OCP products and to enjoy great power saving of OCP designs. <br /><br />
We have broadened our OCP products with a family of Mezzanine cards, and we now deliver OCP Storage solutions!
</p>
<br />



<p style="margin-bottom:30%"> </p>


                      
                    </div>
                </div>
			<div class="col-md-6 text-center">
			
			</div>
            </div>

        </div>
        <!-- /.container -->

    </div>
	
	

	<!-- tabs -->
	<div style="background:#f8f8f8">
	<div class="container" >
	
<ul class="nav nav-pills" style="margin:40px 0px; font-size:1.2em ">

  <li role="presentation" ><a href="#server">Server</a></li>
 <li role="presentation" ><a href="#storage">Storage</a></li>
 <li role="presentation" ><a href="#Solution">Solution</a></li> 
 <li role="presentation" ><a href="#rack">Rack</a></li> 
 <li role="presentation" ><a href="#mezz">Mezzanine</a></li>
 <li role="presentation" ><a href="#partner">Partners</a></li>

</ul>

	
	
	</div>
	</div>
	<!-- end tabs -->	
	
	<a name="server"></a>
<p style="margin-top:6%"> </p>
	
	
	<!--Server-->
	
<div class="container-fluid" style="background:#0D47A1; color:#ffffff" >
<h1 class="container">Server</h1>	
	</div>
<p style="margin-top:3%"> </p>

<div class="container">

<h2>Intel<sup>&reg;</sup> Xeon<sup>&reg;</sup> Server:</h2>
<div class="row">
<div class="col-md-3">
	<div class="pro_well" >
<h4 style="text-align: center; line-height:150%"><span style="color:#0D47A1">Tioga Pass</span><br />E7278-S <br />(Standard)</h4>
<a href="/OCPserver_E7278_E7278-S" target="mit" /><img src="/images/product/OCPserver/E7278-std.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >SP OCP Server Sled
</div>
</div>
	</div>
	<div class="col-md-3">
	<div class="pro_well" >
<h4 style="text-align: center; line-height:150%"><span style="color:#0D47A1">Tioga Pass</span><br />E7278-A <br />(Advanced)</h4>
<a href="/OCPserver_E7278_E7278-A" target="mit" /><img src="/images/product/OCPserver/E7278-advanced.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >SP OCP Server Sled
</div>
</div>
	</div>
	<div class="col-md-3">
	<div class="pro_well" >
<h4 style="text-align: center; line-height:150%"><span style="color:#0D47A1">Tioga Pass</span><br />E7278-U <br />(Ultra)</h4>
<a href="/OCPserver_E7278_E7278-U" target="mit" /><img src="/images/product/OCPserver/E7278-ultra.jpg" class="img-responsive" /></a><br />
<div class="sub_des" >SP OCP Server Sled
</div>
</div>
	</div>
	<div class="col-md-3">
	
	</div>
</div>



<h2>AMD EPYC&#8482; Server:</h2>
<div class="row">

	<div class="col-md-3">
	<div class="pro_well" >
<h4 style="text-align: center; line-height:150%"><span style="color:#0D47A1">Capri</span><br />E8020-A <br />(Advanced)</h4>
<a href="/OCPserver_E8020_E8020-A" target="mit" /><img src="/images/product/OCPserver/E8020-advanced-1.gif" class="img-responsive" /></a><br />
<div class="sub_des" >SP OCP Server Sled
</div>
</div>
	</div>
	<div class="col-md-3">
	<div class="pro_well" >
<h4 style="text-align: center; line-height:150%"><span style="color:#0D47A1">Capri</span><br />E8020-U <br />(Ultra)</h4>
<a href="/OCPserver_E8020_E8020-U" target="mit" /><img src="/images/product/OCPserver/E8020-ultra-1.gif" class="img-responsive" /></a><br />
<div class="sub_des" >SP OCP Server Sled
</div>
</div>
	</div>
	<div class="col-md-3"></div>
	<div class="col-md-3"></div>
</div>










</div>

	<a name="storage"></a>
	<p style="margin-top:6%"> </p>	
<!--end Server-->

<!--Storage-->
	
<div class="container-fluid" style="background:#0D47A1; color:#ffffff" >
<h1 class="container">Storage</h1>	
	</div>
<p style="margin-top:3%"> </p>
<div class="container">
<div class="row">
<div class="col-md-3">
	<div class="pro_well" style="position:relative;" >	
<h4 style="text-align: center; line-height:150%"><span style="color:#0D47A1">Crystal Lake</span><br />EST1250</h4>
<a href="/JBODJBOF_EST1250_EST1250-U" /><img src="/images/product/JBODJBOF/EST1250.jpg" class="img-responsive" /></a><br />
<div class="sub_des" style="margin-top:5%" >OCP JBOF<br /><br /></div>
</div>
	</div>
	<div class="col-md-3">
	<div class="pro_well" style="position:relative;" >
<h4 style="text-align: center; line-height:150%"><span style="color:#0D47A1"></span><br />21" Shelf</h4>
<a href="/JBODJBOF_EST1250_EST1250-U" /><img src="/images/product/OCPserver/3Crystal_Lake_SLEDs.jpg" class="img-responsive" /></a><br />
<div class="sub_des" style="margin-top:5%" >3 Crystal Lake SLEDs for OpenRack v2</div>
</div>
	</div>
	<div class="col-md-3">
	<div class="pro_well" style="position:relative;" >	
<h4 style="text-align: center; line-height:150%"><span style="color:#0D47A1"></span><br />19" Shelf</h4>
<a href="/JBODJBOF_EST1250_EST1250-U" /><img src="/images/product/OCPserver/2Crystal_Lake_SLEDs.jpg" class="img-responsive" /></a><br />
<div class="sub_des" style="margin-top:5%" >2 Crystal Lake SLEDs with ESA for EIA rack</div>
</div>
	</div>
	<div class="col-md-3">
	
	</div>
</div>
</div>

<a name="Solution"></a>
<p style="margin-top:6%"> </p>
<!--end Storage-->





<!--Solution-->
	
<div class="container-fluid" style="background:#0D47A1; color:#ffffff" >
<h1 class="container">Solution</h1>	
	</div>
<p style="margin-top:3%"> </p>
<div class="container">
<div class="row">
<div class="col-md-3">
	<div class="pro_well" >
<h4 style="text-align: center; line-height:150%">SEBA&#8482; Solution</h4>
<a href="/products/OCP_SEBA_Solution" target="mit" /><img src="/images/product/OCPserver/OCP_SEBA_Solution.jpg" class="img-responsive" /></a><br />
<div class="sub_des" style="margin-top:5%" >OCP SEBA&#8482; Solution</div>
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
<a name="rack"></a>
<p style="margin-top:6%"> </p>


<!--end Solution-->





<!--Rack-->
	
<div class="container-fluid" style="background:#0D47A1; color:#ffffff" >
<h1 class="container">Rack</h1>	
	</div>
<p style="margin-top:3%"> </p>
<div class="container">
<div class="row">
<div class="col-md-3">
<div class="pro_well" >
<h4 style="text-align: center; line-height:150%">ESA Kit</h4>
<a href="/OCPRack_ESA_ESA" target="mit" /><img src="/images/product/OCPrack/ESA.jpg" class="img-responsive" /></a><br />
<div class="sub_des" style="margin-top:5%" >Install OCP Sled into 19" EIA Rack</div>
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
<a name="mezz"></a>
<p style="margin-top:6%"> </p>


<!--end Rack-->











<!--Mezzanine-->
	
<div class="container-fluid" style="background:#0D47A1; color:#ffffff" >
<h1 class="container">Mezzanine</h1>	
	</div>
<p style="margin-top:3%"> </p>
<div class="container">
<div class="row">
<div class="col-md-3">
	<div class="pro_well" >
<h4 style="text-align: center; line-height:150%">ML41202-P</h4><br />
<img src="/images/product/OCPMezz/ML41202-P.jpg" class="img-responsive" /><br />
<div class="sub_des" style="margin-top:5%" >2 X 25G OCP 2.0<br /> Mezzanine </div>
</div>
	</div>
	<div class="col-md-3">
	<div class="pro_well" >
<h4 style="text-align: center; line-height:150%">ML45604-2Q</h4><br />
<img src="/images/product/OCPMezz/ML45604-2Q.jpg" class="img-responsive" /><br />
<div class="sub_des" style="margin-top:5%" >2 X 40G OCP 2.0<br /> Mezzanine </div>
</div>
	</div>
	<div class="col-md-3">
<div class="pro_well" >
<h4 style="text-align: center; line-height:150%">ML45604-1Q</h4><br />
<img src="/images/product/OCPMezz/ML45604-1Q.jpg" class="img-responsive" /><br />
<div class="sub_des" style="margin-top:5%" >1 X 100G OCP 2.0<br /> Mezzanine </div>

</div>	
	</div>
	<div class="col-md-3">
	
	</div>
</div>
</div>

<a name="partner"></a>
<p style="margin-top:6%"> </p>


<!--end Mezzanine-->



<!--Partners-->
	
<div class="container-fluid" style="background:#0D47A1; color:#ffffff" >
<h1 class="container">Partners</h1>	
	</div>
<p style="margin-top:3%"> </p>
<div class="container">
<div class="pro_well" >
<div class="row">
<div class="col-md-3"><a href="https://www.sardinasystems.com/" target="mit" /><img src="/images/product/OCP/Sardina_logo.gif" class="img-responsive" /></a></div>
<div class="col-md-9"><br /><a href="https://www.sardinasystems.com/" target="mit" style="font-size:18px; font-weight:bold" />Sardina FishOS</a> is an innovative OpenStack and Kubernetes cloud platform software, offering a full suite of management and automation tools to enable operators to easily and flexibly Deploy, Operate and Upgrade the cloud, reducing complexity and improving reliability. Sardina FishOS is an official OpenStack distribution fully recognized by OpenInfra Foundation (formerly OpenStack Foundation).
</div>
</div>
</div>


</div>


<p style="margin-top:6%"> </p>


<!--end Partners-->




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