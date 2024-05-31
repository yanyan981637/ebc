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
    <title>MiTAC Computing Technology Corp. - Industrial Panel PC</title>
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



    <div style="background: url(/images/product/bg_AIO.jpg) no-repeat center center; background-size: cover;" class="intro-header">
        <div class="container">
            <div class="row" style="padding-top: 15%;">
                <div class="col-xs-12 col-sm-6 col-md-8 text-left">
                    <div class="intro-message" style="color:#ffffff">
                        <h1>Industrial Panel PC</h1>
<p>
MiTAC provides industrial pacnel pc and commercial panel pc for diverse application in several industries. The industrial panel including standalone and panel mount series desgined for harsh environment. Commercial panel PCs - Maestro series with its elegant design and delicate graphic performance powered by latest Intel Core i platform. 

</p>
<br />
<!--<img src="/images/logo/Apollo-Lake-Celeron.jpg" /> <img src="/images/logo/Apollo-Lake-Pentium.jpg" /> <img src="/images/logo/core_i3.jpg" /> <img src="/images/logo/core_i5.jpg" /> <img src="/images/logo/core_i7.jpg" />-->
 

<p style="margin-bottom:10%"> </p>


                      
                    </div>
                </div>
				<div class="col-xs-6 col-md-4 text-left" style="padding-top:3%;">
				 <div class="well box" style="background-color: rgba(255, 255, 255, 0.9); ">
				 
				 <strong>New products:</strong><br />
				 <div class="intro-divider "></div><br />
				 
				 Commercial Panel PC:
				 <ul style="margin-left:15px">
				 
<li ><a href="/IndustrialPanelPC%3DM4080%3DM4080%3Ddescription%3DEN" target="mit" />M4080 (23.6" / 10th Intel core i)</a></li>
<li ><a href="/IndustrialPanelPC=M4070=M4070=description=EN" target="mit" />M4070 (21.5" / 10th Intel core i)</a></li>				 
<li ><a href="/IndustrialPanelPC%3DM850%3DM850%3Ddescription%3DEN" target="mit" />M850 (21.5" / 10th Intel core i)</a></li>	
</ul>
Industrial Panel PC:
<ul style="margin-left:15px">			 
<li ><a href="/IndustrialPanelPC=P210-10AI=P210-10AI=description=EN" target="mit" />P210-10AI (21.5" / Celeron N3350)</a></li>
<li ><a href="/IndustrialPanelPC%3DP210-11KS%3DP210-11KS%3Ddescription%3DEN" target="mit" />P210-11KS (21.5" / 7th Intel Core i)</a></li>
<li ><a href="/IndustrialPanelPC%3DP156-11KS%3DP156-11KS%3Ddescription%3DEN" target="mit" />P156-11KS (15.6" / 7th Intel Core i)</a></li>
<li ><a href="/IndustrialPanelPC%3DP156-10AI%3DP156-10AI%3Ddescription%3DEN" target="mit" />P156-10AI (15.6" / Celeron N3350)</a></li>

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

  <li role="presentation" ><a href="#Ind-PC">Industrial Panel PC</a></li>
  <li role="presentation"><a href="#Com-PC">Commercial Panel PC</a></li>

</ul>

	
	
	</div>
	</div>
	<!-- end tabs -->	
	
	<!--Industrial Panel PC-->
	
	
	<a name="Ind-PC"></a>
	<div class="container" style="padding:2% 0%">
	</div>
	<div class="container-fluid" style="background:#0D47A1; color:#ffffff" >
	<h1 class="text-center">Industrial Panel PC</h1>
	</div>
<p style="margin-top:3%"> </p>

<div class="container">
<div class="row">
  <div class="col-md-6">
  Powered by Intel Core i and Atom platform with reliable, flexible, long-term supported in fanless slim chasis design. Easy to access in different application.
  </div>
  <div class="col-md-6"><p style="margin-top:1%"> </p>
  <img src="/images/logo/ICONS_industrial_pc.gif" class="img-responsive" />

  
</div>
</div>
</div>

<p style="margin-top:3%"> </p>
 <div class="container-fluid" style="background-color:#f8f8f8">
	
	
	
	<div class="container">
	<h2 class="blue_cr">Standalone - D Series</h2>
	<div class="row">
	<div class="col-md-4">
  <div class="pro_well" >
<h4 style="text-align: center;">D151-11KS</h4>
<a href="/IndustrialPanelPC%3DD151-11KS%3DD151-11KS%3Ddescription%3DEN" target="mit" /><img src="/images/product/PanelPc/D151-11KS.jpg" class="img-responsive" /></a><br /><div class="sub_des" >15.6" (16:9)<br />Intel 7th Gen Core i</div>
</div>
  </div>
	<div class="col-md-4">
	<div class="pro_well" >
<h4 style="text-align: center;">D210-10RI</h4>
<a href="/IndustrialPanelPC%3DD210-10RI%3DD210-10RI%3Ddescription%3DEN" target="mit" /><img src="/images/product/PanelPc/D210-10RI.jpg" class="img-responsive" /></a><br /><div class="sub_des" >21.5" (16:9)<br />Intel Celeron N3160</div>
</div>
	</div>
  <div class="col-md-4">
  <div class="pro_well" >
<h4 style="text-align: center;">D210-11KS</h4>
<a href="/IndustrialPanelPC%3DD210-11KS%3DD210-11KS%3Ddescription%3DEN" target="mit" /><img src="/images/product/PanelPc/D210-11KS.jpg" class="img-responsive" /></a><br /><div class="sub_des" >21.5" (16:9)<br />Intel 7th Gen Core i</div>
</div>
  </div>
  
	
  </div><p style="margin-top:2%"> </p>
  <div class="row">
	
  <div class="col-md-4">
  <div class="pro_well" >
<h4 style="text-align: center;">D150-S</h4>
<a href="/IndustrialPanelPC%3DD150-S%3DD150-S%3Ddescription%3DEN" target="mit" /><img src="/images/product/PanelPc/D150.jpg" class="img-responsive" /></a><br /><div class="sub_des" >15" (4:3)<br />Intel 7th Gen Core i</div>
</div>
  </div>
  <div class="col-md-4">
	<!--<div class="pro_well" >
<h4 style="text-align: center;">D150-B</h4>
<a href="/IndustrialPanelPC%3DD150-B%3DD150-B%3Ddescription%3DEN" target="mit" /><img src="/images/product/PanelPc/D150.jpg" class="img-responsive" /></a><br /><div class="sub_des" >15" (4:3)<br />Intel Celeron J1900</div>
</div>-->
	</div>
  <div class="col-md-4">
  
  </div>
	
  </div><p style="margin-top:2%"> </p>
  
  
  
  </div>

</div>


 <div class="container-fluid" >
 <div class="container">
 <h2 class="blue_cr">Panel Mount - P Series</h2>
 <div class="row">
 <div class="col-md-4"><div class="pro_well" >
<h4 style="text-align: center;">P100-10AS</h4>
<a href="/IndustrialPanelPC%3DP100%3DP100-10AS%3Ddescription%3DEN" target="mit" /><img src="/images/product/PanelPc/P100-10AS.jpg" class="img-responsive" /></a><br /><div class="sub_des" >10" (4:3)<br />Intel Celeron N3350</div>
</div></div>
  <div class="col-md-4"><div class="pro_well" >
<h4 style="text-align: center;">P150-10AI</h4>
<a href="/IndustrialPanelPC=P150-10AI=P150-10AI=description=EN" target="mit" /><img src="/images/product/PanelPc/P150-10AI.jpg" class="img-responsive" /></a><br /><div class="sub_des" >15" (4:3)<br />Intel Celeron N3350</div>
</div></div>
  <div class="col-md-4"><div class="pro_well" >
<h4 style="text-align: center;">P150-11KS</h4>
<a href="/IndustrialPanelPC=P150-11KS=P150-11KS=description=EN" target="mit" /><img src="/images/product/PanelPc/P150-11KS.jpg" class="img-responsive" /></a><br /><div class="sub_des" >15" (4:3)<br />Intel 7th Gen Core i</div>
</div></div>
 </div>
 
  <div class="row">
  <div class="col-md-4"><div class="pro_well" style="position:relative;">
<div style="text-align: center;"><span class="label label-warning">&nbsp;New!&nbsp;</span></div>		
<h4 style="text-align: center;">P156-11KS</h4>
<a href="/IndustrialPanelPC%3DP156-11KS%3DP156-11KS%3Ddescription%3DEN" target="mit" /><img src="/images/product/PanelPc/P156-11KS.jpg" class="img-responsive" /></a><br /><div class="sub_des" >15.6" (16:9)<br />Intel 7th Gen Core i</div>
</div>
  
  </div>
  <div class="col-md-4"><div class="pro_well" style="position:relative;">
 <div style="text-align: center;"><span class="label label-warning">&nbsp;New!&nbsp;</span></div>		
<h4 style="text-align: center;">P156-10AI</h4>
<a href="/IndustrialPanelPC%3DP156-10AI%3DP156-10AI%3Ddescription%3DEN" target="mit" /><img src="/images/product/PanelPc/P156-10AI.jpg" class="img-responsive" /></a><br /><div class="sub_des" >15.6" (16:9)<br />Intel Celeron N3350</div>
</div></div>
  
 <div class="col-md-4"><div class="pro_well" style="position:relative;">
<div style="text-align: center;"><span class="label label-warning">&nbsp;New!&nbsp;</span></div>	
<h4 style="text-align: center;">P210-10AI</h4>
<a href="/IndustrialPanelPC=P210-10AI=P210-10AI=description=EN" target="mit" /><img src="/images/product/PanelPc/P210-10AI.jpg" class="img-responsive" /></a><br /><div class="sub_des" >21.5" (16:9)<br />Intel Celeron N3350</div>
</div></div>
  
  
 </div>
 
   <div class="row">
 <div class="col-md-4"><div class="pro_well" style="position:relative;">
 <div style="text-align: center;"><span class="label label-warning">&nbsp;New!&nbsp;</span></div>		
<h4 style="text-align: center;">P210-11KS</h4>
<a href="/IndustrialPanelPC%3DP210-11KS%3DP210-11KS%3Ddescription%3DEN" target="mit" /><img src="/images/product/PanelPc/P210-11KS.jpg" class="img-responsive" /></a><br /><div class="sub_des" >21.5" (16:9)<br />Intel 7th Gen Core i</div>
</div>
  
  </div>
  <div class="col-md-4">
  </div>
  <div class="col-md-4">
  </div>
 </div>
 
 <p style="margin-top:2%"> </p>
 
 
 
 
  </div>
 </div>

<!--
 <div class="container-fluid" style="background-color:#f8f8f8">
	
	
	
	<div class="container">
	<h2 class="blue_cr">Stainless – ST series</h2>
	<div class="row">
	<div class="col-md-4">
  <div class="pro_well" > <div style="text-align: center;"><span class="label label-warning">&nbsp;New!&nbsp;</span></div>		
<h4 style="text-align: center;">ST170-11TGS</h4>
<a href="/IndustrialPanelPC=ST170-11TGS=ST170-11TGS=description=EN" target="mit" /><img src="/images/product/PanelPc/ST170-11TGS.jpg" class="img-responsive" /></a><br /><div class="sub_des" >17"<br />Intel 11th Gen Core i</div>
</div>
  </div>
	<div class="col-md-4">
	</div>
  <div class="col-md-4">
  </div>
  
	
  </div><p style="margin-top:6%"> </p>

  
  
  </div>

</div>-->



	

<!--end Industrial Panel PC-->
<!--Commercial Panel PC-->


<a name="Com-PC"></a>
	<div class="container" style="padding:0% 0%">
	</div>
	<div class="container-fluid" style="background:#0D47A1; color:#ffffff" >
	<h1 class="text-center">Commercial Panel PC - Maestro Series</h1>
	</div>
	<p style="margin-top:3%"> </p>

	<div class="container">
<div class="row">
  <div class="col-md-6">
  Elegant all-in-one PC design powered by standard Thin Mini-iTX
and latest Intel Core i platform with best computing & delicate
graphic performance.
  </div>
  <div class="col-md-6"><p style="margin-top:1%"> </p>
  <img src="/images/logo/ICONS_commercial_pc.gif" class="img-responsive" />

  
</div>
</div>
</div><p style="margin-top:3%"> </p>
 <div class="container-fluid" style="background-color:#f8f8f8">
 <div class="container" >
 <p style="margin-top:3%"> </p>
 
  <div class="row">
<div class="col-md-4">
<div class="pro_well" ><div style="text-align: center;"><span class="label label-warning">&nbsp;New!&nbsp;</span></div>	
<h4 style="text-align: center;">M4070</h4>
<a href="/IndustrialPanelPC=M4070=M4070=description=EN" target="mit" /><img src="/images/product/PanelPc/M4070.jpg" class="img-responsive" /></a><br /><div class="sub_des" >21.5" (16:9)<br />Intel 10th core i</div></div>
</div>
<div class="col-md-4">
<div class="pro_well" ><div style="text-align: center;"><span class="label label-warning">&nbsp;New!&nbsp;</span></div>		
<h4 style="text-align: center;">M4080</h4>
<a href="/IndustrialPanelPC%3DM4080%3DM4080%3Ddescription%3DEN" target="mit" /><img src="/images/product/PanelPc/M4080.jpg" class="img-responsive" /></a><br /><div class="sub_des" >23.6" (16:9)<br />Intel 10th core i</div>
</div>
</div>
<div class="col-md-4">
<div class="pro_well" ><div style="text-align: center;"><span class="label label-warning">&nbsp;New!&nbsp;</span></div>		
<h4 style="text-align: center;">M850</h4>
<a href="/IndustrialPanelPC%3DM850%3DM850%3Ddescription%3DEN" target="mit" /><img src="/images/product/PanelPc/M850.jpg" class="img-responsive" /></a><br /><div class="sub_des" >21.5" (16:9)<br />Intel 10th core i</div>
</div>
</div>
</div>
 
 
 
 
 
 
 
 
 
 
 
 <div class="row">
<div class="col-md-4">
<div class="pro_well" >
<h4 style="text-align: center;">M3070</h4>
<a href="/IndustrialPanelPC%3DM3070%3DM3070%3Ddescription%3DEN" target="mit" /><img src="/images/product/PanelPc/M3070.jpg" class="img-responsive" /></a><br /><div class="sub_des" >21.5" (16:9)<br />Intel 8th & 9th Gen Core i</div></div>
</div>
<div class="col-md-4">
<div class="pro_well" >
<h4 style="text-align: center;">M3080</h4>
<a href="/IndustrialPanelPC%3DM3080%3DM3080%3Ddescription%3DEN" target="mit" /><img src="/images/product/PanelPc/M3080.jpg" class="img-responsive" /></a><br /><div class="sub_des" >23.6" (16:9)<br />Intel 8th & 9th Gen Core i</div>
</div>
</div>
<div class="col-md-4">
<div class="pro_well" >
<h4 style="text-align: center;">M840</h4>
<a href="/IndustrialPanelPC%3DM840%3DM840%3Ddescription%3DEN" target="mit" /><img src="/images/product/PanelPc/M840.jpg" class="img-responsive" /></a><br /><div class="sub_des" >21.5" (16:9)<br />Intel 8th & 9th Gen Core i</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-4">
<div class="pro_well" >
<h4 style="text-align: center;">M200i</h4>
<a href="/IndustrialPanelPC%3DM200i%3DM200i%3Ddescription%3DEN" target="mit" /><img src="/images/product/PanelPc/M200i.jpg" class="img-responsive" /></a><br /><div class="sub_des" >19.5" (16:9)<br />Intel Celeron N2930<br /><br /></div>
</div>
</div>
<div class="col-md-4">

</div>
<div class="col-md-4">

</div>
</div>
<div class="row">
<div class="col-md-4">

</div>
<div class="col-md-4">

</div>
<div class="col-md-4">

</div>
</div>
</div><p style="margin-top:6%"> </p>
 </div>

	
	

	
	
	
		
<!--end Commercial Panel PC-->

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