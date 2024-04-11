<?php
header("X-Frame-Options: DENY");
//header("Content-Security-Policy-Report-Only: default-src *; img-src https:; frame-src 'none'; report-uri http://www.tyan.com");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://www.mitacmct.com");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

if(strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
header("HTTP/1.1 301 Moved Permanently");
header("Location: /404.htm");
exit;
}
error_reporting(0);

require "./config.php";

function dowith_sql($str){
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
   $str = str_replace("<script>","",$str);
   $str = str_replace("</script>","",$str);
   $str = str_replace("(","",$str);
   $str = str_replace(")","",$str);
   return $str;
}

if(isset($_REQUEST['PLang'])!=''){
  $PLang_si=dowith_sql(trim($_REQUEST['PLang']));
  $PLang_si=str_replace(".php","",$PLang_si);
  
  if($PLang_si=="en-US" || $PLang_si==""){
   $PLang_si01="EN";
   $PLang_si="en-US";
  }
}else{
  $PLang_si01="EN";
  $PLang_si="en-US";
}

$url=$_SERVER['HTTP_REFERER'];

if(isset($_REQUEST['pr_id'])!=''){
$pr_id=preg_replace("/['\"\~\%\$ \r\n\t;<>\?]/i", '', $_REQUEST['pr_id']);
$pr_id=htmlspecialchars($pr_id);	
$pr_id=filter_var($pr_id);	

}else{
$pr_id=1;
}

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase) or die("Could not connect: " . mysqli_error());
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db) or die("Could not connect:" . mysqli_error());

if(strlen($pr_id)>3){
  $str_prdetail="SELECT ID, TITLE, CONTENT, DETAIL, MODEL, STATUS, NEWSDATE FROM nr_pressroom WHERE Redirect='".$pr_id."' and LANG='".$PLang_si."'  and STATUS='1'";
}else{
	$str_prdetail="SELECT ID, TITLE, CONTENT, DETAIL, MODEL, STATUS, NEWSDATE FROM nr_pressroom WHERE ID='".$pr_id."' and STATUS='1'";
}

/*$str_prdetail="SELECT ID, TITLE, CONTENT, DETAIL, MODEL, STATUS, NEWSDATE FROM nr_pressroom WHERE ID='".$pr_id."' and STATUS='1'";

$prdetail_cmd=mysqli_query($link_db,$str_prdetail);
$nums=mysqli_num_rows($prdetail_cmd);
if($nums!=1){
  $str_prdetail="SELECT ID, TITLE, CONTENT, DETAIL, MODEL, STATUS, NEWSDATE FROM nr_pressroom WHERE Redirect='".$pr_id."' and LANG='".$PLang_si."'  and STATUS='1'";
  $prdetail_cmd=mysqli_query($link_db,$str_prdetail);
}*/
$prdetail_cmd=mysqli_query($link_db,$str_prdetail);
$prdetail_data=mysqli_fetch_row($prdetail_cmd);
$id=intval($prdetail_data[0]);
$title=trim($prdetail_data[1]);
$content=trim($prdetail_data[2]);
$detail=trim($prdetail_data[3]);
$model=trim($prdetail_data[4]);
$DATE=trim($prdetail_data[6]);
$DATE=date("Y/m/d",strtotime($DATE));

//mysqli_close($link_db);

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
<meta name="description" content="<?=$title?>">
<meta property="og:type" content="website" />
<meta property="og:description" content="<?=$title?>" /> 
<meta property="og:title" content="News - Press Release  | MiTAC Computing Technology" />
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
<title>News - Press Release  | MiTAC Computing Technology</title>

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
				<h1 class="fw-bold ls0 mb-5" >Press Release</h1>
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
						<div class="grid-inner shadow-sm h-shadow  p-3 overflow-hidden rounded-5 text-center shadow-ts" style="background:#d4e8fe">
							<div class="row justify-content-center">
								<div class="col-12" ><h3 class="h3 mb-0 fw-bold"> <i class="icon-bullhorn1 mb-1"></i> Press Release</h3></div>
							</div>
						</div>
					</div>

					<div class="col-lg-3" onclick="location.href='in-news'">
						<div class="grid-inner shadow-sm h-shadow bg-white p-3 overflow-hidden rounded-5 text-center shadow-ts">
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
							<h1 class="mb-6">Press Release</h1>

							<div class="row border-between">
								<div class="col-lg-8 mb-5 mb-lg-0">
									<!-- Post Article -->
									<article class="entry border-bottom-0 mb-0">

										<div class="entry-title">

											<h2 class="display-4 mt-2 mb-3"><?=$title;?></h2>
											<div class="entry-categories"><?=$content;?></div>
										</div>
										<br>
										<div class="entry-meta">
											<ul>
												<li><?=$DATE?></li>
											</ul>
										</div>
										<?php
										if($model!=""){
										?>
										<div class="center">
											<em>Products: &nbsp;
											<?php
											$br01="";$model_split_all="";
											$model_split=explode(",",$model,-1);
											for($j=0;$j<=count($model_split)-1;$j++){
												if($j%4==0 && $j<>0){
												$br01="<br />";
												}else{
												$br01="";
												}
												$modelcode = $model_split[$j];
												//---------------ProductTypeId 參考資料 producttypes------------------
												/* if(strchr($modelcode, "S.")!= null){
													$modelcode=str_replace("S.","",$modelcode);
													$str_sku = "SELECT SKU, MODELCODE, slang FROM product_skus WHERE MODELCODE = '".$modelcode."' GROUP BY MODELCODE";
													$skucmd=mysqli_query($str_sku,$link_db);
													$sku_result=mysqli_fetch_array($skucmd);
													$sku_1 = $sku_result[0];
													$MB_url="Motherboards=".$modelcode."=".$sku_1."=description=".$PLang_si01;
													$modelcode = "<a href='".$MB_url."'>".$modelcode."</a>";
												} else if(strchr($modelcode, "B.")!= null) {
													$modelcode=str_replace("B.","",$modelcode);
													$str_sku = "SELECT SKU, MODELCODE, slang FROM product_skus WHERE MODELCODE = '".$modelcode."' GROUP BY MODELCODE";
													$skucmd=mysqli_query($str_sku,$link_db);
													$sku_result=mysqli_fetch_array($skucmd);
													$sku_1 = $sku_result[0];
													$BB_url="Barebones=".$modelcode."=".$sku_1."=description=".$PLang_si01;
													$modelcode = "<a href='".$BB_url."'>".$modelcode."</a>";
												} else if(strchr($modelcode, "J.")!= null) {
													$modelcode=str_replace("J.","",$modelcode);
													$str_sku = "SELECT SKU, MODELCODE, slang FROM product_skus WHERE MODELCODE = '".$modelcode."' GROUP BY MODELCODE";
													$skucmd=mysqli_query($str_sku,$link_db);
													$sku_result=mysqli_fetch_array($skucmd);
													$sku_1 = $sku_result[0];
													$BB_url="Barebones=".$modelcode."=".$sku_1."=description=".$PLang_si01;
													$modelcode = "<a href='".$BB_url."'>".$modelcode."</a>";
												} */
												if(strchr($modelcode, "S.")!= null || strchr($modelcode, "B.")!= null || strchr($modelcode, "J.")!= null){
													$modelcode=str_replace("S.","",$modelcode);
													$modelcode=str_replace("B.","",$modelcode);
													$modelcode=str_replace("J.","",$modelcode);
													$str_sku = "SELECT ProductTypeID, SKU, MODELCODE FROM product_skus WHERE MODELCODE = '".$modelcode."' GROUP BY MODELCODE";	
													$skucmd=mysqli_query($link_db,$str_sku);
													$sku_result=mysqli_fetch_array($skucmd);
													$productID = $sku_result[0];	
													$sku_url = $sku_result[1];
													$model_url = $sku_result[2];
												} else {
													$str_sku = "SELECT ProductTypeID, SKU, MODELCODE FROM product_skus WHERE SKU = '".$modelcode."' GROUP BY MODELCODE";
													$skucmd=mysqli_query($link_db,$str_sku);
													$sku_result=mysqli_fetch_array($skucmd);
													$productID = $sku_result[0];	
													$sku_url = $sku_result[1];
													$model_url = $sku_result[2];
												}

												if ($productID == 107){
													$IPC_url="IndustrialPanelPC_".$model_url."_".$sku_url;
													$modelcode = "<a href='".$IPC_url."'>".$modelcode."</a>";
												} else if ($productID == 108) {
													$ES_url="EmbeddedSystem_".$model_url."_".$sku_url;
													$modelcode = "<a href='".$ES_url."'>".$modelcode."</a>";
												} else if ($productID == 109) {
													$IM_url="IndustrialMotherboard_".$model_url."_".$sku_url;
													$modelcode = "<a href='".$IM_url."'>".$modelcode."</a>";
												} else if ($productID == 110) {
													$OCPS_url="OCPserver_".$model_url."_".$sku_url;
													$modelcode = "<a href='".$OCPS_url."'>".$modelcode."</a>";
												} else if ($productID == 111) {
													$OCPM_url="OCPMezz_".$model_url."_".$sku_url;
													$modelcode = "<a href='".$OCPM_url."'>".$modelcode."</a>";
												} else if ($productID == 112) {
													$JBOD_url="JBODJBOF_".$model_url."_".$sku_url;
													$modelcode = "<a href='".$JBOD_url."'>".$modelcode."</a>";
												} else if ($productID == 113) {
													$OCPR_url="OCPRack_".$model_url."_".$sku_url;
													$modelcode = "<a href='".$OCPR_url."'>".$modelcode."</a>";
												} else if ($productID == 114) {
											    $POS_url="POS_".$model_url."_".$sku_url;
											    $modelcode = "<a href='".$POS_url."'>".$modelcode."</a>";
											  }
												
												$model_split_all.=$modelcode."&nbsp;".$br01;
												
											}
											/* $model_split_all=str_replace("S.","",$model_split_all);
											$model_split_all=str_replace("B.","",$model_split_all);
											$model_split_all=str_replace("J.","",$model_split_all); */
											echo $model_split_all;
											?> 
											</em>
										</div>
										<?php
										}
										?>


										<div class="entry-content">
											<?=$detail;?>
										</div>
									</article>
								</div>

								<div class="col-lg-4">


									<div class="row posts-md col-mb-30">

										<div style="text-align:right"><a href="<?=$url?>" class="button button-mini button-border button-rounded"><span><i class="icon-line-chevrons-left"></i> BACK</span></a>
										</div><div class="clear mb-3 mt-3"></div>
										<?php
										$p=0;
										$str_pr="SELECT ID, TITLE, CONTENT, NEWSDATE, MODEL, STATUS, Redirect, IMG FROM nr_pressroom where STATUS='1' and LANG='".$PLang_si."' and ID<>'".$id."' order by NEWSDATE desc Limit 5";
										$pr_cmd=mysqli_query($link_db,$str_pr);
										while(list($id,$title,$content,$newdate,$model,$status,$Redirect,$IMG)=mysqli_fetch_row($pr_cmd)){
											$p+=1;
											$prDate=date("Y/m/d",strtotime($newdate));


											if($Redirect!=""){
												$link=$Redirect;
											}else{
												$link=$id;
											}
										?>
										<!--one PR-->
										<article class="entry col-12">
											<div class="grid-inner row gutter-20">
												<div class="col-md-12">
													<div class="entry-meta">
														<ul>
															<li><a href="<?=$PLang_si;?>@<?=$link;?>~PRDetail"><?=$prDate?></a></li>
														</ul>
													</div>
													<div class="entry-title title-xs">
														<h3><a href="<?=$PLang_si;?>@<?=$link;?>~PRDetail" class="color-underline"><?=$title?></a></h3>
														<?php
														if($content!=""){
															echo "<span>".$content."</span>";
														}

														if($model!='' || !empty($model)){
															$br01="";$model_split_all="";
															$model_split=explode(",",$model,-1);
															for($j=0;$j<=count($model_split)-1;$j++){
																if($j%4==0 && $j<>0){
																$br01="<br />";
																}else{
																$br01="";
																}
																$model_split_all.=$model_split[$j]."&nbsp;".$br01;
															}
															$model_split_all=str_replace("S.","",$model_split_all);
															$model_split_all=str_replace("B.","",$model_split_all);
															$model_split_all=str_replace("J.","",$model_split_all);
															echo "<p style='color: #898989;' ><em>Products: ".$model_split_all."</em></p>";
														}
														?>

													</div>
												</div>
											</div>
										</article>
										<!--end one PR-->
										<?php
										}
										?>
									</div>

								</div>
							</div>




































							

							<div class="clear mb-6 mt-6 "></div>







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
	<script type="text/javascript">
	$(document).ready(function(){
      $('html,body').animate({scrollTop:$('#content').offset().top}, 500);
  });
	</script>

</body>
</html>
<?php
mysqli_Close($link_db);
?>