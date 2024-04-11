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
   $NRM01="Newsroom";
   $PRL01="Press Release";
   $NLT01="Newsletters";
   $EVL01="Events";
   $PRE01="Product Review";
  }
}else{
  $PLang_si01="EN";
  $PLang_si="en-US";
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase) or die("Could not connect: " . mysqli_error());
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');

$str1="select * from `nr_pressroom` where `STATUS`='1' and `LANG`='".$PLang_si."'";
$cmd1=mysqli_query($link_db,$str1);
$public_count=mysqli_num_rows($cmd1);
$total=$public_count;

$per = 10; //每頁顯示項目數量 
$pages_totle = ceil($total/$per); //總頁數

if(!isset($_GET["page"])){ 
    $page=1; //設定起始頁 
} else { 
    $page = intval($_GET["page"]); //確認頁數只能夠是數值資料 
    $page = ($page > 0) ? $page : 1; //確認頁數大於零 
    $pages=0;
    $page = ($pages_totle > $page) ? $page : $pages_totle; //確認使用者沒有輸入太神奇的數字 
}

$Previous="";$Next="";
if($page==1){
	$Previous="disabled";
}else if($pages_totle==$page){
	$Next="disabled";
}

$start = ($page-1)*$per; //每頁起始資料序號

if(isset($_COOKIE['status'])){
  //$s_cookie="";
}else{
  $s_cookie=$_COOKIE['status'];
}

//********2018.03.26 判斷時間on/offline***************
$str_Date="SELECT `ID`, `TITLE`, `CONTENT`, `NEWSDATE`, `MODEL`, `STATUS`, `sDate`, `eDate` FROM `nr_pressroom` where `LANG`='".$PLang_si."' and (`sDate`!='NULL' and `sDate`!='0000-00-00 00:00:00') or (`eDate`!='NULL' and `eDate`!='0000-00-00 00:00:00')";
$strDate_cmd=mysqli_query($link_db,$str_Date);
while ($result=mysqli_fetch_array($strDate_cmd)) {
  if (strtotime($result[6])!="") {
    $time = (strtotime($now) - strtotime($result[6]));
    if($time > 0){
      $str_update="UPDATE `nr_pressroom` SET `STATUS`='1', `sDate`='NULL' where `ID`='".$result[0]."' ";
      $Date_cmd=mysqli_query($link_db,$str_update);
    }
  }

  //********* strtotime(0000-00-00) 32bit return flase 64bit return -62169955200
  /*if (strtotime($result[7])!="") {
    $time = (strtotime($now) - strtotime($result[7]));
    if($time > 0){
      $str_update="UPDATE `nr_pressroom` SET `STATUS`='0', `eDate`='NULL' where `ID`='".$result[0]."' ";
      $Date_cmd=mysqli_query($str_update,$link_db);
    }
  }*/
}
//********2018.03.26 判斷時間on/offline end***************
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name='author' content='MiTAC Computing Technology'>
<meta name="company" content="MiTAC Computing Technology">
<meta name="description" content="Press release for 5G edge computing, OCP, embedded systems, AI, automation from MiTAC.">
<meta property="og:type" content="website" />
<meta property="og:description" content="Press release for 5G edge computing, OCP, embedded systems, AI, automation from MiTAC." /> 
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
							<h1>Press Release</h1>

							<!--pagnation-->
							<div style="float:right">
								<ul class="pagination pagination-transparent pagination-circle">
									<li class="page-item <?=$Previous;?>"><a class="page-link" href="<?=$PLang_si?>@PRLIST~plist~<?=$page-1?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
									<?php
									for($i=1;$i<=$pages_totle;$i++) { 
										$pagenum=6;
										$last=$page+10;
										$first=$page-10;
										if($i==1 && $first>1){
											?>
											<li class="page-item"><a href="<?=$PLang_si?>@PRLIST~plist~1" class="page-link">1</a></li>
											<li class="page-item"><a href="" class="page-link">...</a></li>
											<?php
										}
										if($i>=$first && $i<=$last){
											if ($page==$i) {
												?>
												<li class="page-item active"><a href="<?=$PLang_si?>@PRLIST~plist~<?=$i?>" class="page-link"><?=$i?></a></li>
												<?php
											}else{
												?>
												<li class="page-item"><a href="<?=$PLang_si?>@PRLIST~plist~<?=$i?>" class="page-link"><?=$i?></a></li>
												<?php
											}
										}
										if($i==$pages_totle && $last<$pages_totle){
											?>
											<li class="page-item"><a href="" class="page-link">...</a></li>
											<li class="page-item"><a href="<?=$PLang_si?>@PRLIST~plist~<?=$i?>" class="page-link"><?=$i?></a></li>
											<?php
										}
									}
									?>
									<li class="page-item <?=$Next?>"><a class="page-link" href="<?=$PLang_si?>@PRLIST~plist~<?=$page+1?>" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
								</ul>
							</div>
							<div class="clear"></div>
							<!--end pagnation-->

							<div class="row posts-md col-mb-30" >
								<?php
								$p=0;
								$str_pr="SELECT `ID`, `TITLE`, `CONTENT`, `NEWSDATE`, `MODEL`, `STATUS`, `Redirect`, IMG FROM `nr_pressroom` where `STATUS`='1' and `LANG`='".$PLang_si."' order by `NEWSDATE` desc limit $start, $per";
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
											<div class="col-md-4">
												<a href="<?=$PLang_si;?>@<?=$link;?>~PRDetail"><img src="<?=$IMG?>" alt="<?=$title;?>"  ></a>
											</div>
											<div class="col-md-8">
												<div class="entry-meta">
													<ul>
														<li><a href="<?=$PLang_si;?>@<?=$link;?>~PRDetail"><?=$prDate?></a></li>
													</ul>
												</div>
												<div class="entry-title title-xs">
													<h3><a href="<?=$PLang_si;?>@<?=$link;?>~PRDetail" class="color-underline"><?=$title;?></a></h3>
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

							<div class="clear mb-6 mt-6 "></div>

							<!--pagnation-->
							<div style="float:right">
								<ul class="pagination pagination-transparent pagination-circle">
									<li class="page-item <?=$Previous;?>"><a class="page-link" href="<?=$PLang_si?>@PRLIST~plist~<?=$page-1?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
									<?php
									for($i=1;$i<=$pages_totle;$i++) { 
										$pagenum=6;
										$last=$page+10;
										$first=$page-10;
										if($i==1 && $first>1){
											?>
											<li class="page-item"><a href="<?=$PLang_si?>@PRLIST~plist~1" class="page-link">1</a></li>
											<li class="page-item"><a href="" class="page-link">...</a></li>
											<?php
										}
										if($i>=$first && $i<=$last){
											if ($page==$i) {
												?>
												<li class="page-item active"><a href="<?=$PLang_si?>@PRLIST~plist~<?=$i?>" class="page-link"><?=$i?></a></li>
												<?php
											}else{
												?>
												<li class="page-item"><a href="<?=$PLang_si?>@PRLIST~plist~<?=$i?>" class="page-link"><?=$i?></a></li>
												<?php
											}
										}
										if($i==$pages_totle && $last<$pages_totle){
											?>
											<li class="page-item"><a href="" class="page-link">...</a></li>
											<li class="page-item"><a href="<?=$PLang_si?>@PRLIST~plist~<?=$i?>" class="page-link"><?=$i?></a></li>
											<?php
										}
									}
									?>
									<li class="page-item <?=$Next?>"><a class="page-link" href="<?=$PLang_si?>@PRLIST~plist~<?=$page+1?>" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
								</ul>
							</div>
							<div class="clear"></div>
							<!--end pagnation-->





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

</body>
</html>
<?php
mysqli_Close($link_db);
?>