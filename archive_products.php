<?php
header("X-Frame-Options: DENY");
//header("Content-Security-Policy-Report-Only: default-src *; img-src https:; frame-src 'none'; report-uri http://www.tyan.com");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://www.tyan.com");
header('Content-Type: text/html; charset=utf-8');
header("Cache-control: private");

error_reporting(0);

if(strpos(trim(getenv('REQUEST_URI')),'?')!='' || strpos(trim(getenv('REQUEST_URI')),'?')===0 || strpos(trim(getenv('REQUEST_URI')),"'")!='' || strpos(trim(getenv('REQUEST_URI')),"'")===0 || strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
	echo "<script language='javascript'>self.location='/404.htm'</script>";
	exit;
}

require "./config.php";
function dowith_sql($str){
	//$str = str_replace("and","",$str);
	$str = str_replace("execute","",$str);
	$str = str_replace("update","",$str);
	$str = str_replace("count","",$str);
	$str = str_replace("chr","",$str);
	$str = str_replace("<script>","",$str);
	$str = str_replace("</script>","",$str);
	$str = str_replace("javascript","",$str);
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
//$str = str_replace("or","",$str); //2017.05.23 因舊資料SKU關係, 暫時註解
	$str = str_replace("=","",$str);
	return $str;
}

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');

if(isset($_REQUEST['PLang'])!=''){
  $PLang_si=dowith_sql(trim($_REQUEST['PLang']));
  $PLang_si=str_replace(".php","",$PLang_si);
  
  if($PLang_si=="en-US" || $PLang_si==""){
	  $PLang_si01="EN";
	  $PLang_si="en-US";	  
  }else if($PLang_si=="ja-JP"){
	  $PLang_si01="JP";
	  $PLang_si="ja-JP";
  }else if($PLang_si=="zh-CN"){
	  $PLang_si01="CN";
	  $PLang_si="zh-CN";
  }else if($PLang_si=="zh-TW"){
	  $PLang_si01="ZH";
	  $PLang_si="zh-TW";
  }
}else{
	$PLang_si01="EN";
	$PLang_si="en-US";
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
<meta name="description" content="End-of-life products list of MiTAC Computing Technology">
<meta property="og:type" content="website" />
<meta property="og:description" content="End-of-life products list of MiTAC Computing Technology" /> 
<meta property="og:title" content="Archived Products  | MiTAC Computing Technology" />
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
<link rel="stylesheet" href="css1/home.css " type="text/css" />

<script src="js1/jquery.js"></script>
<!-- Document Title
============================================= -->
<title>Archived Products  | MiTAC Computing Technology</title>

</head>
<?php 
//************判斷語系載入 google analytics ************
if($s_cookie!=2){
  include_once("analyticstracking.php");
}
?>
<body class="stretched">

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">


		<!--Header logo & global top menu-->
		<?php
		include("top1.htm");
		?>
		<!--end Header logo & global top menu-->



		<div class="section m-0 border-0 dark" style="background:#e7f2fd; padding:35px 100px 15px 100px">
			<div class="container clearfix">
				<h2 style="color:#1b1b1b"><span class="fw-semibold">Archived Products</span></h2>
			</div>
		</div>

		<div class="clear mb-6"></div>

		<div class="container">

			<div class="row ">
				<div class="col-2"></div>
				<div class="col-8">
					<?php
					// Type
					$str_type="SELECT DISTINCT(a.`ProductTypeID`), a.`ProductTypeName` FROM `producttypes` a inner join (SELECT Product_SKU_Auto_ID, ProductTypeID, IS_EOL FROM product_skus) b on a.ProductTypeID=b.ProductTypeID WHERE b.IS_EOL='1'";
					$cmd_type=mysqli_query($link_db,$str_type);
					while($data_type=mysqli_fetch_array($cmd_type)){ 
					?>
					<!--one product type card-->
					<div class="card mb-5">
						<div class="card-body">
							<h1 class="card-title"><?=$data_type[1];?></h1>
							<table class="table table-striped table-hover">
								<tbody>
									<?php
									$str_EOL="SELECT a.`SKU`, a.`MODELCODE` FROM contents_product_skus a inner join (SELECT Product_SKU_Auto_ID, ProductTypeID, IS_EOL FROM product_skus) b on a.Product_SContents_Auto_ID=b.Product_SKU_Auto_ID WHERE a.STATUS='1' AND b.IS_EOL='1' AND b.ProductTypeID='".$data_type[0]."'";
									$cmd_EOL=mysqli_query($link_db,$str_EOL);
									while($data_EOL=mysqli_fetch_row($cmd_EOL)){
										$type=preg_replace('/\s(?=)/', '', $data_type[1]);
										$url=$type."_".$data_EOL[1]."_".$data_EOL[0];
									?>
									<tr><td><a href="./<?=$url;?>" ><?=$data_EOL[0];?></a> / <a href="./<?=$url;?>" ><?=$data_EOL[1];?></a>&nbsp;<span class="badge bg-secondary">EOL</span></td></tr>
									<?php
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
					<!--end one product type card-->
					<?php
					}
					?>
				</div>
				<div class="col-2"></div>
			</div>
		</div>

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
	
	<script src="js1/top.js"></script>
	
</body>
</html>