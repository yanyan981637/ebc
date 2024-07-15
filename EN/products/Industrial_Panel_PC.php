<?php
header("X-Frame-Options: DENY");
//header("Content-Security-Policy-Report-Only: default-src *; img-src https:; frame-src 'none'; report-uri http://www.tyan.com");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://ipc.mitacmdt.com");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

if(strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
header("HTTP/1.1 301 Moved Permanently");
header("Location: /404.htm");
exit;
}

error_reporting(0);
require "../../config.php";

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

if(isset($_GET['PLang'])!=''){
  $PLang_si=dowith_sql(trim($_GET['PLang']));
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

if($_GET['info']!=""){
  $info=dowith_sql($_GET['info']);
  $info=filter_var($info);
}else{
  $info="";
  $status="on";
}

if($_COOKIE["status"]==""){
  //$s_cookie="";
}else{
  $s_cookie=$_COOKIE['status'];
}

$PType="46";



$strInfo="SELECT PIV_id, PI_id, PIV_Value, PIV_Sort FROM product_infovalue_las WHERE 1";
$cmdInfo=mysqli_query($link_db, $strInfo);
while ($dataInfo=mysqli_fetch_array($cmdInfo)) {
	$listInfo[$dataInfo[1]][$dataInfo[0]]=$dataInfo[2];
	$Info[$dataInfo[0]]=$dataInfo[2];
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name='author' content='MiTAC Digital Technology'>
<meta name="company" content="MiTAC Digital Technology">
<meta name="description" content="MiTAC provides industrial panel pc and commercial panel pc supporting the latest Intel Core i processor for automation, ITS, AI applications.">
<meta property="og:type" content="website" />
<meta property="og:description" content="MiTAC provides industrial panel pc and commercial panel pc supporting the latest Intel Core i processor for automation, ITS, AI applications." />
<meta property="og:title" content="Industrial Panel PC | MiTAC Digital Technology" />
  <link rel="shortcut icon" href="/images/ico/favicon.ico">

<!-- Stylesheets
============================================= -->
<link rel="stylesheet" href="/css1/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="/css1/style.css" type="text/css" />
<link rel="stylesheet" href="/css1/swiper.css" type="text/css" />
<link rel="stylesheet" href="/css1/dark.css" type="text/css" />
<link rel="stylesheet" href="/css1/font-icons.css" type="text/css" />
<link rel="stylesheet" href="/css1/animate.css" type="text/css" />
<link rel="stylesheet" href="/css1/magnific-popup.css" type="text/css" />
<link rel="stylesheet" href="/css1/custom.css" type="text/css" />
<link rel="stylesheet" href="/css1/product-landing.css" type="text/css" />
<link rel="stylesheet" href="/css1/stylesheet1.css" type="text/css" />
<script src="/js1/jquery.js"></script>

<!-- Document Title
============================================= -->
<title>Industrial Panel PC | MiTAC Digital Technology</title>
<?php
//************ google analytics ************
if($s_cookie!=2){
  include_once("../../analyticstracking.php");
}
?>
</head>

<body class="stretched">

<!-- Document Wrapper
============================================= -->
<div id="wrapper" class="clearfix">


	<!--Header logo & global top menu-->
	<?php
	include("../../top1.htm");
	?>
	<!--end Header logo & global top menu-->



	<!-- Slider
	============================================= -->
	<section id="slider" class="slider-element" style="background: linear-gradient(to right, rgba(0,0,0, 0.8) 20%, transparent 100%), url('/products/img/bg_panel_PC.jpg') no-repeat center center / cover;">

		<div class="container">
			<div class="row justify-content-between align-items-center">
				<div class="col-lg-8 col-md-8 dark mb-5 mb-md-0 py-5">
					<h2 class="display-4" style="font-weight: 600;" data-animate="backInLeft">Industrial Panel PC</h2>
					<p class="mb-5 lead text-white" data-animate="backInLeft">MiTAC provides industrial panel PC and commercial panel PC for diverse application in several industries. Powered by Intel Core i and Atom processors with reliable, flexible, long-term supported in fanless slim chassis design, the industrial panel PCs include standalone and panel mount series designed for harsh environment. Commercial panel PCs - Maestro series with elegant all-in-one PC design powered by standard Thin Mini-iTX and latest Intel Core i platform with best computing & delicate graphic performance.</p>

				</div>
				<div class="col-md-4 d-flex align-self-end align-items-center align-items-lg-end col-form">
					<div class="card  bg-white border-0 w-100 shadow p-3 rounded-0 op-1" >
						<div class="card-body">
							<h3 class="mb-0 center">
								New products:
							</h3>
							<div class="line line-sm mt-3"></div>

							<ul class="iconlist">
								<?php
								$strList="SELECT a.MODELCODE, a.SKU, a.PanelSize_val, a.Panel_PC_Processor_val, a.Product_Info FROM contents_product_skus a inner join product_skus b on a.Product_SContents_Auto_ID=b.Product_SKU_Auto_ID WHERE a.ProductTypeID='".$PType."' AND a.IsnewUp='1' AND b.IS_EOL='0' AND a.STATUS='1' ORDER BY b.crea_d DESC Limit 6";
								$cmdList=mysqli_query($link_db, $strList);
								while ($dataList=mysqli_fetch_array($cmdList)) {
									$url="/IndustrialPanelPC_".$dataList[0]."_".$dataList[1];
									$tmp=explode(",", $dataList[2]);
									$tmp1=explode(",", $dataList[3]);
									/*$tmp2=explode(",", $dataList[4]);
									foreach ($tmp2 as $key => $value) {
										if($value!="" && $listInfo[14][$value]!=""){
											$ps=$listInfo[14][$value];
										}
									}*/
									echo "<li><i class='icon-line-chevrons-right'></i> <a href='".$url."'/>".$dataList[1]." (".$Info[$tmp[0]]." / ".$Info[$tmp1[0]].")</a></li>";
								}
							?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Content
	============================================= -->

	<!--filter-->

	<div class="section m-0 border-0" style="padding: 30px 30px 15px 30px; background:#c9c9c9">
		<div class="container center clearfix" >
			<div class="row">
				<div class="col-lg-2 form-group">
					<select id="sleType" class=" sm-form-control" onchange="search('sleType')" >
						<option value="">Type:</option>
						<?php
						//product_info_las
						//Industrial_Panel_PC Type ID 20
						$strType="SELECT PIV_id, PI_id, PIV_Value, PIV_Sort FROM product_infovalue_las WHERE PI_id='20'";
						$cmdType=mysqli_query($link_db,$strType);
						while ($dataType=mysqli_fetch_array($cmdType)){
							echo "<option value='".$dataType[0]."'>".$dataType[2]."</option>";
						}
						?>
					</select>
				</div>
				<div class="col-lg-2 form-group">
					<select id="slePro" class=" sm-form-control" onchange="search('slePro')"  >
						<option value="">Processor:</option>
						<?php
						//Embedded Processor ID 18
						$strPro="SELECT PIV_id, PI_id, PIV_Value, PIV_Sort FROM product_infovalue_las WHERE PI_id='18'";
						$cmdPro=mysqli_query($link_db,$strPro);
						while ($dataPro=mysqli_fetch_array($cmdPro)){
							echo "<option value='".$dataPro[0]."'>".$dataPro[2]."</option>";
						}
						?>
					</select>
				</div>
				<div class="col-lg-2 form-group">
					<select id="sleFF" class="sm-form-control " onchange="search('sleFF')">
						<option value="">Fanless:</option>
						<?php
						//Fanless ID 11
						$strFF="SELECT PIV_id, PI_id, PIV_Value, PIV_Sort FROM product_infovalue_las WHERE PI_id='11'";
						$cmdFF=mysqli_query($link_db,$strFF);
						while ($dataFF=mysqli_fetch_array($cmdFF)){
							echo "<option value='".$dataFF[0]."'>".$dataFF[2]."</option>";
						}
						?>
					</select>
				</div>
				<div class="col-lg-2 form-group">
					<select id="slePS" class=" sm-form-control" onchange="search('slePS')">
						<option value="">Panel Size:</option>
						<?php
						//Panel Size ID 14
						$strPS="SELECT PIV_id, PI_id, PIV_Value, PIV_Sort FROM product_infovalue_las WHERE PI_id='14'";
						$cmdPS=mysqli_query($link_db,$strPS);
						while ($dataPS=mysqli_fetch_array($cmdPS)){
							echo "<option value='".$dataPS[0]."'>".$dataPS[2]."</option>";
						}
						?>
					</select>
				</div>

				<div class="col-lg-2 form-group">
					<select id="slePow" class=" sm-form-control" onchange="search('slePow')">
						<option value="">Power:</option>
						<?php
						//Power ID 16
						$strPow="SELECT PIV_id, PI_id, PIV_Value, PIV_Sort FROM product_infovalue_las WHERE PI_id='16'";
						$cmdPow=mysqli_query($link_db,$strPow);
						while ($dataPow=mysqli_fetch_array($cmdPow)){
							echo "<option value='".$dataPow[0]."'>".$dataPow[2]."</option>";
						}
						?>
					</select>
				</div>
				<div class="col-lg-2 form-group">
					<select id="sleWT" class=" sm-form-control" onchange="search('sleWT')">
						<option value="">Wide Temperature:</option>
						<?php
						//Widge Temperature ID 13
						$strWT="SELECT PIV_id, PI_id, PIV_Value, PIV_Sort FROM product_infovalue_las WHERE PI_id='13'";
						$cmdWT=mysqli_query($link_db,$strWT);
						while ($dataWT=mysqli_fetch_array($cmdWT)){
							echo "<option value='".$dataWT[0]."'>".$dataWT[2]."</option>";
						}
						?>
					</select>
				</div>
			</div>
		</div>
	</div>
	<!--end filter-->


<div class="section m-0">
	<div class="container-fluid clearfix">

		<div class="row gutter-60 mt-2">

			<div class="col-lg-2">

				<!-- Primary Navigation
				============================================= -->

				<ul id="left-m" class="list-group list-group-flush">
					<li class="list-group-item <?=$status?>" onclick="location.href='/EN/products/Industrial_Panel_PC/'">ALL</li>
					<?php
					$strEST="SELECT PIV_id, PI_id, PIV_Value, PIV_Sort FROM product_infovalue_las WHERE PI_id='20'";
					$cmdEST=mysqli_query($link_db,$strEST);
					while ($dataEST=mysqli_fetch_array($cmdEST)){
						if($info==$dataEST[0]){
							$status="on";
						}else{
							$status="";
						}
						echo "<li class='list-group-item ".$status."' onclick=location.href='/EN/products/Industrial_Panel_PC@".$dataEST[0]."=Search'>".$dataEST[2]."</li>";
					}
					?>
				</ul>

				<!-- Primary Navigation end -->

			</div>


<div class="col-lg-10">

	<!--error msg for no result-->
	<div class="container  mb-5 mt-1" style="display:none">
		<div class="row">
			<div class="col-12">
				<span class="alert alert-danger">
					Sorry! There is no result for your search.
				</span>
			</div>

		</div>
	</div>
	<!--end error msg -->



	<div id="portfolio" class="portfolio row gutter-20 col-mb-30 grid grid-container customjs" data-layout="fitRows">

		<?php
					$IS_BTO="";$PR_info="";
					if($info==""){
						$strPR="SELECT a.Product_SContents_Auto_ID,a.ProductTypeID,a.MODELCODE,a.STATUS,a.Product_Info,a.SKU,a.ProductFile,a.ProductSFile,a.IsnewUp,b.IS_EOL,b.IS_BTO,a.Coming_Soon,a.LandingTitle, a.PanelPCType_val, b.ProductTypeID, b.COMPARE, b.REQUEST_QUOTE FROM contents_product_skus a inner join product_skus b on a.Product_SContents_Auto_ID=b.Product_SKU_Auto_ID";
				    $strPR.=" WHERE (a.ProductTypeID='".$PType."') AND (a.slang='".$PLang_si01.",') AND a.STATUS='1' AND b.IS_EOL='0'";
				    $strPR.=" ORDER BY a.crea_d DESC";
					}else{
						$strPR="SELECT a.Product_SContents_Auto_ID,a.ProductTypeID,a.MODELCODE,a.STATUS,a.Product_Info,a.SKU,a.ProductFile,a.ProductSFile,a.IsnewUp,b.IS_EOL,b.IS_BTO,a.Coming_Soon,a.LandingTitle, a.PanelPCType_val, b.ProductTypeID, b.COMPARE, b.REQUEST_QUOTE FROM contents_product_skus a inner join product_skus b on a.Product_SContents_Auto_ID=b.Product_SKU_Auto_ID";
				    $strPR.=" WHERE (a.ProductTypeID='".$PType."') AND (a.slang='".$PLang_si01.",') AND a.STATUS='1' AND b.IS_EOL='0' AND INSTR(CONCAT(',',Product_Info),',".$info.",')>0";
				    $strPR.=" ORDER BY a.crea_d DESC";
					}

			    $cmdPR=mysqli_query($link_db,$strPR);
			    $nums=mysqli_num_rows($cmdPR);
			    if($nums!=""){
			    	while ($dataPR=mysqli_fetch_array($cmdPR)) {
			    	$SKU=$dataPR[5];
			    	$img=explode(",", $dataPR[7]);
			    	$url="/IndustrialPanelPC_".$dataPR[2]."_".$SKU;
			    	$IsnewUp=$dataPR[8];
			    	$IS_EOL=$dataPR[9];
			    	if($dataPR[10]==1){
			    		$IS_BTO="(BTO)";
			    	}else{
			    		$IS_BTO="";
			    	}
			    	$Coming_Soon=$dataPR[11];
			    	$LandingTitle=$dataPR[12];
			    	$tmpEType=explode(",", $dataPR[13]);
			    	$PR_info=explode(",", $dataPR[4]);
			    	$compareTypeID=$dataPR[14];
			    	$COMPARE=$dataPR[15];
			    	$REQUEST_QUOTE=$dataPR[16];
				    ?>
				    <!-- Card  -->
						<article class="portfolio-item col-12 col-sm-6 col-lg-4" >

							<?php
							//<!--new label-->
							if($IsnewUp==1){
								echo "<div class='card-label-new'>New</div>";
							}
							//<!--coming soon label-->
							if($Coming_Soon==1){
								echo "<div class='card-label-cs'>Coming Soon!</div>";
							}
							?>
							<div class="grid-inner card card-hover border-0 shadow-sm p-5">
								<!--Panel PC Type label label-->
								<?php
								/*if($Info[$tmpEType[0]]!=""){
									echo "<div class='embedded_type' >".$Info[$tmpEType[0]]."</div>";
								}*/
								?>
								<!--Panel PC Type label label end-->
								<div class="portfolio-image">
									<a href="<?=$url?>" /><img src="/images/product/PanelPc/<?=$img[0]?>" alt="<?=$dataPR[5]?> Industrial Panel PC"></a>
								</div>
								<div class="portfolio-desc">
									<!--Panel PC Type--><div style="color:#004898; font-weight:700; font-size:0.8rem"><?=$Info[$tmpEType[0]]?></div><!--Panel PC Type-->
									<h3><a href="<?=$url?>"><?=$dataPR[5]?></a>&nbsp;&nbsp;<?=$IS_BTO?></h3>
									<span><?=$LandingTitle?></span>
									<br />
									<div class="line" style="margin: 1rem 0;"></div>
									<div style="font-size:0.9rem">
										<?php
										$i=0;
										$strInfoTitle="SELECT PI_id, PI_Name FROM product_info_las WHERE PI_id IN ('14','13','11','16')";
										$strInfoTitle.=" ORDER BY INSTR(',14,13,11,16,',CONCAT(',',PI_id,','))";
										$cmdInfoTitle=mysqli_query($link_db, $strInfoTitle);
										while ($dataInfoTitle=mysqli_fetch_array($cmdInfoTitle)) {

											if($dataInfoTitle[0]!=16){ // info title disable
												$title=$dataInfoTitle[1].":";
											}else{
												$title="";
											}

											if($i%3==0){
												echo "<div class='row'>";
											}
											echo "<div class='col-sm-12'>".$title." <strong>";
											foreach ($PR_info as $key => $value) {
												if($value!=""){

													echo $listInfo[$dataInfoTitle[0]][$value];

												}
											}
											echo "</strong></div>";
											if($i%3==2){
												echo "</div>";
											}
											$i++;
										}
										?>
									</div>
									<div class="line" style="margin: 1rem 0;"></div>
									<div class="center">
										<?php
										if($COMPARE==1){
										?>
										<div class="button button-mini button-border button-circle mt-1" onclick="add_compare('<?=$SKU?>','<?=$compareTypeID?>')"><i class="icon-line-plus"></i>Compare</div>&nbsp;
										<?php
										}
										if($REQUEST_QUOTE==1){
										?>
										<div class="button button-mini button-border button-circle mt-1" onclick="AddRFQ('<?=$SKU?>','<?=$compareTypeID?>')"><i class="icon-line-dollar-sign"></i>Request Quote</div>
										<?php
										}
										?>
									</div>
								</div>
							</div>
						</article>
						<!--end Card  -->
				    <?php
				    }
			    }else{
			    ?>
			    <!--error msg for no result-->
			    <article class="portfolio-item col-12 col-sm-6 col-lg-4" >
			    	<div class="container  mb-5 mt-1">
			        <div class="row">
			            <div class="col-12">
			                <span class="alert alert-danger">
			                    Sorry! There is no result for your search.
			                </span>
			            </div>
			          </div>
		        </div>
	        </article>
	        <!--end error msg -->
	        <?php
			    }
			    ?>












	</div>

</div>


</div>






















</div>
</div>


<!-- #content end -->

<!-- add quote sone msg Modal -->
<div id="addqtomsg" class="modal fade compare-alert-modal" tabindex="-1" role="dialog" aria-labelledby="centerModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<div class="block mx-auto" style="background-color: #FFF; max-width: 500px;">
					<div class="feature-box fbox-center fbox-effect fbox-lg border-bottom-0 mb-0" style="padding: 40px;">
						<div class="fbox-icon">
							<i class="icon-ok i-alt"></i>
						</div>
						<div class="fbox-content">
							<h3>Success!<span class="subtitle">Your requested quote has been added to the list. Click &nbsp;&nbsp;"<img src="/images/quote-icon.gif" />"&nbsp;&nbsp; on the top-right navigation bar to continue.</span></h3>
							<img src="/images/quote-nav-bar.gif" />
						</div>
					</div>
					<div class="section center m-0" style="padding: 30px;">
						<button type="button" class="button" data-bs-dismiss="modal" aria-hidden="true">Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end add quote sone msg Modal -->

<!-- FOOTER -->
<?php
include("../../foot1.htm");
?>
<!-- FOOTER end -->

</div><!-- #wrapper end -->

<!-- Go To Top
============================================= -->
<div id="gotoTop" class="icon-line-arrow-up"></div>

<!-- JavaScripts
============================================= -->
<script src="/js1/jquery.js"></script>
<script src="/js1/plugins.min.js"></script>

<!-- Footer Scripts
============================================= -->
<script src="/js1/functions.js"></script>
<script src="/js1/top.js"></script>

<Script>

jQuery(window).on( 'pluginIsotopeReady',  function(){
	var filters = {};

	var $container = $('.grid');

	$container.isotope();

	$('select.select-filter').on( 'change', function() {
		var $this = $(this);
			// get group key
			var filterGroup = $this.attr('data-filter-group');
			// set filter for group
			filters[ filterGroup ] = $this.val();
			// combine filters
			var filterValue = concatValues( filters );
			$container.isotope({ filter: filterValue });

			jQuery.each( filters, function(key, value){
				var count = $container.children().filter(':not('+ value +'):not(:hidden)').length;
			});
		});

		// flatten object by concatting values
		function concatValues( obj ) {
			var value = '';
			for ( var prop in obj ) {
				value += obj[ prop ];
			}
			return value;
		}

		$(window).resize(function() {
			$container.isotope('layout');
		});
	});

	function search(i){
		var s_val=document.getElementById(i).value;
		document.location.href="/EN/products/Industrial_Panel_PC@"+s_val+"=Search";
	}

</script>



</body>
</html>