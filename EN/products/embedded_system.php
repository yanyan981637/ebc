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


$PType="47";



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
<meta name='author' content='MiTAC Computing Technology'>
<meta name="company" content="MiTAC Computing Technology">
<meta name="description" content="MiTAC provides industrial and commercial embedded systems with rugged, modularized, compact designed for automation, AI, IOT applications.">
<meta property="og:type" content="website" />
<meta property="og:description" content="MiTAC provides industrial and commercial embedded systems with rugged, modularized, compact designed for automation, AI, IOT applications." />
<meta property="og:title" content="Embedded System | MiTAC Computing Technology" />
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
<script src="/js1/jquery.js"></script>

<style>

</style>

<!-- Document Title
============================================= -->
<title>Embedded System | MiTAC Computing Technology</title>

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
<section id="slider" class="slider-element" style="background: linear-gradient(to right, rgba(0,0,0, 0.8) 20%, transparent 100%), url('/products/img/bg_industrial_mobo.jpg') no-repeat center center / cover;">

	<div class="container">
		<div class="row justify-content-between align-items-center">
			<div class="col-lg-8 col-md-9 dark mb-5 mb-md-0 py-5">
				<h2 class="display-4" style="font-weight: 600;" data-animate="backInLeft">Embedded System</h2>
				<p class="mb-5 lead text-white" data-animate="backInLeft">MiTAC's embedded system, including industrial and commercial series powered by state of the art processors, whole new SOC structure packs and more powerful capability for your tasks and applications.</p>

			</div>
			<div class="col-md-3 d-flex align-self-end align-items-center align-items-lg-end col-form">
				<div class="card  bg-white border-0 w-100 shadow p-3 rounded-0 op-09" >
					<div class="card-body">
						<h3 class="mb-0 center">
							New products:
						</h3>
						<div class="line line-sm mt-3"></div>

						<ul class="iconlist">
							<?php
							$strList="SELECT a.MODELCODE, a.SKU, a.EmbeddedProcessor_val FROM contents_product_skus a inner join product_skus b on a.Product_SContents_Auto_ID=b.Product_SKU_Auto_ID WHERE a.ProductTypeID='".$PType."' AND a.IsnewUp='1' AND b.IS_EOL='0' AND a.STATUS='1' ORDER BY b.crea_d DESC Limit 6";
							$cmdList=mysqli_query($link_db, $strList);
							while ($dataList=mysqli_fetch_array($cmdList)) {
								$url="/EmbeddedSystem_".$dataList[0]."_".$dataList[1];
								$tmp=explode(",", $dataList[2]);
								echo "<li><i class='icon-line-chevrons-right'></i> <a href='".$url."'/>".$dataList[1]." (".$Info[$tmp[0]].")</a></li>";
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
			<div class="col-lg-4 form-group">
				<select id="sleEST" class=" sm-form-control" onchange="search('sleEST')" >
					<option value="">Embedded System Type:</option>
					<?php
					//product_info_las
					//Embedded Type ID 19
					$strEST="SELECT PIV_id, PI_id, PIV_Value, PIV_Sort FROM product_infovalue_las WHERE PI_id='19'";
					$cmdEST=mysqli_query($link_db,$strEST);
					while ($dataEST=mysqli_fetch_array($cmdEST)){
						echo "<option value='".$dataEST[0]."'>".$dataEST[2]."</option>";
					}
					?>
				</select>
			</div>
			<div class="col-lg-4 form-group">
				<select id="slePro" class=" sm-form-control" onchange="search('slePro')"  >
					<option value="">Processor:</option>
					<?php
					//Embedded Processor ID 17
					$strPr="SELECT PIV_id, PI_id, PIV_Value, PIV_Sort FROM product_infovalue_las WHERE PI_id='17'";
					$cmdPr=mysqli_query($link_db,$strPr);
					while ($dataPr=mysqli_fetch_array($cmdPr)){
						echo "<option value='".$dataPr[0]."'>".$dataPr[2]."</option>";
					}
					?>
				</select>
			</div>
			<div class="col-lg-4 form-group">
				<select id="sleMIO" class="sm-form-control " onchange="search('sleMIO')">
					<option value="">Modularized I/O:</option>
					<?php
					//Modularized I/O ID 12
					$strMIO="SELECT PIV_id, PI_id, PIV_Value, PIV_Sort FROM product_infovalue_las WHERE PI_id='12'";
					$cmdMIO=mysqli_query($link_db,$strMIO);
					while ($dataMIO=mysqli_fetch_array($cmdMIO)){
						echo "<option value='".$dataMIO[0]."'>".$dataMIO[2]."</option>";
					}
					?>
				</select>
			</div>
			<div class="col-lg-2 form-group">
				<select id="sleFan" class=" sm-form-control" onchange="search('sleFan')">
					<option value="">Fanless:</option>
					<?php
					//Fanless ID 11
					$strFan="SELECT PIV_id, PI_id, PIV_Value, PIV_Sort FROM product_infovalue_las WHERE PI_id='11'";
					$cmdFan=mysqli_query($link_db,$strFan);
					while ($dataFan=mysqli_fetch_array($cmdFan)){
						echo "<option value='".$dataFan[0]."'>".$dataFan[2]."</option>";
					}
					?>
				</select>
			</div>

			<div class="col-lg-2 form-group">
				<select id="slePCIe" class=" sm-form-control" onchange="search('slePCIe')">
					<option value="">PCIe Slot:</option>
					<?php
					//PCIe Slot ID 9
					$strPCIe="SELECT PIV_id, PI_id, PIV_Value, PIV_Sort FROM product_infovalue_las WHERE PI_id='9'";
					$cmdPCIe=mysqli_query($link_db,$strPCIe);
					while ($dataPCIe=mysqli_fetch_array($cmdPCIe)){
						echo "<option value='".$dataPCIe[0]."'>".$dataPCIe[2]."</option>";
					}
					?>
				</select>
			</div>
			<div class="col-lg-2 form-group">
				<select id="sleM2" class=" sm-form-control" onchange="search('sleM2')">
					<option value="">M.2 Slot:</option>
					<?php
					//M.2 Slot ID 7
					$strM2="SELECT PIV_id, PI_id, PIV_Value, PIV_Sort FROM product_infovalue_las WHERE PI_id='7'";
					$cmdM2=mysqli_query($link_db,$strM2);
					while ($dataM2=mysqli_fetch_array($cmdM2)){
						echo "<option value='".$dataM2[0]."'>".$dataM2[2]."</option>";
					}
					?>
				</select>
			</div>
			<div class="col-lg-2 form-group">
				<select id="sleMPCIe" class=" sm-form-control" onchange="search('sleMPCIe')">
					<option value="">Mini PCIe:</option>
					<?php
					//Mini PCIe ID 8
					$strMPCIe="SELECT PIV_id, PI_id, PIV_Value, PIV_Sort FROM product_infovalue_las WHERE PI_id='8'";
					$cmdMPCIe=mysqli_query($link_db,$strMPCIe);
					while ($dataMPCIe=mysqli_fetch_array($cmdMPCIe)){
						echo "<option value='".$dataMPCIe[0]."'>".$dataMPCIe[2]."</option>";
					}
					?>
				</select>
			</div>
			<div class="col-lg-2 form-group">
				<select id="slePower" class=" sm-form-control" onchange="search('slePower')">
					<option value="">Power:</option>
					<?php
					//Embedded Power ID 15
					$strPower="SELECT PIV_id, PI_id, PIV_Value, PIV_Sort FROM product_infovalue_las WHERE PI_id='15'";
					$cmdPower=mysqli_query($link_db,$strPower);
					while ($dataPower=mysqli_fetch_array($cmdPower)){
						echo "<option value='".$dataPower[0]."'>".$dataPower[2]."</option>";
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
					<li class="list-group-item <?=$status?>" onclick="location.href='/EN/products/embedded_system/'">ALL</li>
					<?php
					$strEST="SELECT PIV_id, PI_id, PIV_Value, PIV_Sort FROM product_infovalue_las WHERE PI_id='19'";
					$cmdEST=mysqli_query($link_db,$strEST);
					while ($dataEST=mysqli_fetch_array($cmdEST)){
						if($info==$dataEST[0]){
							$status="on";
						}else{
							$status="";
						}
						echo "<li class='list-group-item ".$status."' onclick=location.href='/EN/products/embedded_system@".$dataEST[0]."=Search'>".$dataEST[2]."</li>";
					}
					?>
				</ul>

				<!-- Primary Navigation end -->

			</div>


			<div class="col-lg-10">

				<div id="portfolio" class="portfolio row gutter-20 col-mb-30 grid grid-container customjs" data-layout="fitRows">


					<?php
					$IS_BTO="";$PR_info="";
					if($info==""){
						$strPR="SELECT a.Product_SContents_Auto_ID,a.ProductTypeID,a.MODELCODE,a.STATUS,a.Product_Info,a.SKU,a.ProductFile,a.ProductSFile,a.IsnewUp,b.IS_EOL,b.IS_BTO,a.Coming_Soon,a.LandingTitle, a.EmbeddedType_val, b.ProductTypeID, b.COMPARE, b.REQUEST_QUOTE FROM contents_product_skus a inner join product_skus b on a.Product_SContents_Auto_ID=b.Product_SKU_Auto_ID";
				    $strPR.=" WHERE (a.ProductTypeID='".$PType."') AND (a.slang='".$PLang_si01.",') AND a.STATUS='1' AND b.IS_EOL='0'";
				    $strPR.=" ORDER BY a.crea_d DESC";
					}else{
						$strPR="SELECT a.Product_SContents_Auto_ID,a.ProductTypeID,a.MODELCODE,a.STATUS,a.Product_Info,a.SKU,a.ProductFile,a.ProductSFile,a.IsnewUp,b.IS_EOL,b.IS_BTO,a.Coming_Soon,a.LandingTitle, a.EmbeddedType_val, b.ProductTypeID, b.COMPARE, b.REQUEST_QUOTE FROM contents_product_skus a inner join product_skus b on a.Product_SContents_Auto_ID=b.Product_SKU_Auto_ID";
				    $strPR.=" WHERE (a.ProductTypeID='".$PType."') AND (a.slang='".$PLang_si01.",') AND a.STATUS='1' AND b.IS_EOL='0' AND INSTR(CONCAT(',',Product_Info),',".$info.",')>0";
				    $strPR.=" ORDER BY a.crea_d DESC";
					}
			    $cmdPR=mysqli_query($link_db,$strPR);
			    $nums=mysqli_num_rows($cmdPR);
			    if($nums!=""){
			    	while ($dataPR=mysqli_fetch_array($cmdPR)) {
			    	$SKU=$dataPR[5];
			    	$img=explode(",", $dataPR[7]);
			    	$url="/EmbeddedSystem_".$dataPR[2]."_".$SKU;
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
								<!--Embedded System Type label-->
								<?php
								/*if($Info[$tmpEType[0]]!=""){
									echo "<div class='embedded_type' >".$Info[$tmpEType[0]]."</div>";
								}*/
								?>
								<!--Embedded System Type label end-->

								<div class="portfolio-image">
									<a href="<?=$url?>" /><img src="/images/product/Embedded/<?=$img[0]?>" alt="<?=$dataPR[5]?> Embedded System "></a>
								</div>
								<div class="portfolio-desc">
									<!--Embedded Type--><div style="color:#004898; font-weight:700; font-size:0.8rem"><?=$Info[$tmpEType[0]]?></div><!--Embedded Type-->
									<h3><a href="<?=$url?>"><?=$dataPR[5]?></a>&nbsp;&nbsp;<?=$IS_BTO?></h3>
									<span><?=$LandingTitle?></span>
									<br />
									<div class="line" style="margin: 1rem 0;"></div>
									<div style="font-size:0.9rem">
										<?php
										$i=0;
										$strInfoTitle="SELECT PI_id, PI_Name FROM product_info_las WHERE PI_id IN ('9','7','8','12','13','11','15')";
										$strInfoTitle.=" ORDER BY INSTR(',9,7,8,12,13,11,15,',CONCAT(',',PI_id,','))";
										$cmdInfoTitle=mysqli_query($link_db, $strInfoTitle);
										while ($dataInfoTitle=mysqli_fetch_array($cmdInfoTitle)) {

											if($dataInfoTitle[0]==13 || $dataInfoTitle[0]==11 || $dataInfoTitle[0]==15){
												$divclass="col-sm-12";
											}else{
												$divclass="col-sm-6";
											}

											if($dataInfoTitle[0]!=15){
												$title=$dataInfoTitle[1].":";
											}else{
												$title="";
											}

											if($i%2==0){
												echo "<div class='row'>";
											}
											echo "<div class='".$divclass."'>".$title." <strong>";
											foreach ($PR_info as $key => $value) {
												if($value!=""){

													echo $listInfo[$dataInfoTitle[0]][$value];

												}
											}
											echo "</strong></div>";
											if($i%2==1){
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
		document.location.href="/EN/products/embedded_system@"+s_val+"=Search";
	}

</script>



</body>
</html>