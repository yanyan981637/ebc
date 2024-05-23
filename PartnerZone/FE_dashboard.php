<?php
header("X-Frame-Options: DENY");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://www.mitacmct.com/");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

if(strpos(trim(getenv('REQUEST_URI')),'?')!='' || strpos(trim(getenv('REQUEST_URI')),'?')===0 || strpos(trim(getenv('REQUEST_URI')),"'")!='' || strpos(trim(getenv('REQUEST_URI')),"'")===0 || strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
  echo "<script language='javascript'>self.location='/'</script>";
  exit;
}
error_reporting(0);

session_start();

$now=date('Y-m-d H:i:s',time());
if($_SESSION['FEuser']=="" || $_SESSION['FEID']==""){
	echo "<script language='javascript'>self.location='index.html'</script>";
	exit;
}elseif($now > $_SESSION['expire']){
	session_destroy();
	setcookie("IN", "", time()-3600, '/', "tyan.com");
  echo "<script language='javascript'>self.location='index.html'</script>";
  exit();
}

require "config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');

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
$str = str_replace("'","&#39;",$str);
$str = str_replace('"',"&quot;",$str);
//$str = str_replace(".","",$str);
//$str = str_replace("or","",$str);
$str = str_replace("=","",$str);
$str = str_replace("?","",$str);
$str = str_replace("%","",$str);
$str = str_replace("0x02BC","",$str);
//$str = str_replace("%20","",$str);
$str = str_replace("<script>","",$str);
$str = str_replace("</script>","",$str);
$str = str_replace("<style>","",$str);
$str = str_replace("</style>","",$str);
$str = str_replace("<img>","",$str);
$str = str_replace("</img>","",$str);
$str = str_replace("<a>","",$str);
$str = str_replace("</a>","",$str);
return $str;
}
$ID=dowith_sql($_SESSION['FEID']);
$ID=filter_var($ID);

$user=dowith_sql($_SESSION['FEuser']);
$user=filter_var($user);

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

$str_annTime="SELECT ID, Title, ReleaseTo, Schedule, Message, Status, C_DATE FROM partner_announcement WHERE Status='0' AND Schedule>'0000-00-00 00:00:00'";
$cmd_annTime=mysqli_query($link_db,$str_annTime);
while($data_annTime=mysqli_fetch_row($cmd_annTime)){
	if(strtotime($now)>strtotime($data_annTime[3])){
		$update="UPDATE partner_announcement SET Status='1', U_DATE='".$now."' WHERE ID='".$data_annTime[0]."'";
		$cmd_update=mysqli_query($link_db,$update);
	}
}

$str_user="SELECT CompanyID, CompanyName FROM partner_user WHERE ID='".$ID."'";
$cmd_user=mysqli_query($link_db,$str_user);
$company = mysqli_fetch_row($cmd_user);
$CompanyName=$company[1];


?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

<title>MiTAC Partner Zone</title>
<link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
<link rel="shortcut icon" href="/images/ico/favicon.ico">
<link rel="manifest" href="images/favicon/site.webmanifest">
<link rel="mask-icon" href="images/favicon/safari-pinned-tab.svg" color="#5bbad5">

<!-- BEGIN VENDOR CSS-->
<link rel="stylesheet" type="text/css" href="app-assets/css/vendors.css">
<!-- END VENDOR CSS-->
<!-- BEGIN ROBUST CSS-->
<link rel="stylesheet" type="text/css" href="app-assets/css/app.css">
<link rel="stylesheet" type="text/css" href="app-assets/fonts/font-awesome/css/fontawesome.css" >
<link rel="stylesheet" type="text/css" href="app-assets/fonts/feather/style.min.css" >	
<!-- END ROBUST CSS-->
<!-- BEGIN Page Level CSS-->
<!--<link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.css">-->
<link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-overlay-menu.css">
<link rel="stylesheet" type="text/css" href="app-assets/css/core/colors/palette-gradient.css">
<link rel="stylesheet" type="text/css" href="app-assets/css/pages/gallery.css">
<!-- END Page Level CSS-->
<!-- BEGIN Custom CSS-->
<link rel="stylesheet" type="text/css" href="assets/css/style.css">
<!-- END Custom CSS-->
</head>

<body class="vertical-layout vertical-overlay-menu 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-overlay-menu" data-col="2-columns">

<!-- fixed-top-->
<?php
include("top.php");
?>
<!-- fixed-top end--

<!--left menu-->
<?php
include("left_menu.php");
?>
<!--end left menu-->






<div class="app-content content">
<div class="content-wrapper">
<div class="content-header row">

<!--breadcrumb-->
<div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
<h3 class="content-header-title mb-0 d-inline-block">Dashboard</h3>
<div class="row breadcrumbs-top d-inline-block">
	<div class="breadcrumb-wrapper col-12">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="FEdashboard">Dashboard</a>
		</ol>
	</div>
</div>
</div>
<!--end breadcrumb--> 


</div>
<div class="content-body">
<input id="UID" type="hidden" value="<?=$ID?>"> <!-- for self.js -->
<input id="CompanyID" type="hidden" value="<?=$CompanyID?>">



<section id="image-grid" class="">

<div class="card-content">
	<div class="masonry-grid my-gallery mx-1" >
		<div class="grid-sizer"></div>

		<!--msg for logged in lead-->	
		<?php
		$str_leads="SELECT ID, MODEL, QuoteQty, CompanyID, SalesID FROM partner_leads_quote WHERE UserID='".$ID."' AND (STATUS<>'Verified' AND STATUS<>'Invalid') ORDER BY ID DESC";
		$cmd_leads=mysqli_query($link_db,$str_leads);
		$data_leads=mysqli_fetch_row($cmd_leads);
		if($data_leads[0]!=""){
			$CompanyID=$data_leads[3];
			$SalesID=$data_leads[4];
		?>
		<div id="leadcard" class="grid-item mb-4" >
			<figure class="card bg-cyan box-shadow-2" >
				<div class="card-header" >
					<button type="button" class="close font-large-1" aria-label="Close" onclick="leadcardhidden()" >
						<span aria-hidden="true">×</span>
					</button>
					<h1 class="card-title text-white t900" style="font-size:2rem">Request for <?=$data_leads[0]?></h1>
				</div>
				<div class="card-content collapse show">
					<div class="card-body">
						<p class="card-text text-white" style="line-height:150%">
							<h3 class="text-white">Quote:</h3>
							<table class="table table-sm text-white " style=""  >
								<thead class="bg-cyan bg-lighten-2"><tr><th>Product</th></tr></thead>
								<?php
								$tmp_model=explode(",", $data_leads[1]);
								foreach ($tmp_model as $key => $value) {
									if($value!=""){
										echo "<tr><td>".$value." (".$value.") </td></tr>";
									}
								}
								?>
							</table>
						</p>
					</div>
				</div>
				
			</figure>
		</div>
		<?php
		}
		?>

		

		<!--end msg for logged in lead-->	




		<!--Greeting card : for 1st time login-->
		<?php
		if($IndexCard!=1){
		?>
		<div class="grid-item mb-2" >
			<figure class="card bg-gradient-y-blue box-shadow-0" >
				<div class="card-header" >
					<button type="button" class="close font-large-1" aria-label="Close" onclick="cancelCard('cancelCard')" >
						<span aria-hidden="true">×</span>
					</button>
					<h1 class="card-title text-white t900" style="font-size:2rem"><i class="fa fa-handshake-o" ></i>&nbsp;&nbsp;Welcome!</h1>
				</div>
				<div class="card-content collapse show">
					<div class="card-body">
						<p class="card-text  text-white" style="line-height:150%">
							Hi <?=$user?>, <br /><br />
							Welcome to join Mitac Partners' family! <br /><br />
							Please <a href="#" class="yellow darken-1" onclick="window.location.href='/PartnerZone/FEpassword@<?=$ID?>';" />click here</u></a> to change your password for your account security.
							<br /><br />


							Please <a href="#" class="yellow darken-1" onclick="window.location.href='/PartnerZone/FEmyprofile';"/><u>click here to complete or confirm your information</u></a> for future communication.

							.<br /><br />
							Thank you for your cooperation.<br /><br />
						</p>
					</div>
				</div>
				<div class="card-footer text-muted">
					<a href="#" class="yellow darken-1" onclick="cancelCard('cancelCard')" /><span class="float-right btn btn-outline-secondary btn-sm"><i class="ft-trash-2"></i> Close this permanently </span></a>
				</div>
			</figure>
		</div>
		<?php
		}
		?>
		
		<!--end Greeting card-->



		<!--announcement card-->
		<div class="grid-item mb-2">
			<figure class="card  box-shadow-1" >
				<div class="card-header card-head-inverse bg-pink" >
					<h1 class="card-title text-white t900" style="font-size:2rem"><i class="fa fa-bullhorn" ></i>&nbsp;&nbsp;Noticeboard</h1>
					<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
					<div class="heading-elements">
						<ul class="list-inline mb-0">
							<!-- <li><a data-action="reload" onclick="reload('anntable','<?//=$reAnn;?>')"><i class="ft-rotate-cw"></i></a></li> -->
						</ul>
					</div>
				</div>
				<div class="card-content collapse show">
					<div class="">
						<table id="anntable" class="table table-borderless table-hover table-responsive-lg">
							<!--one message-->
							<?php
							$time="";
							$str_ann="SELECT ID, Title, ReleaseTo, Schedule, Message, Status, C_DATE FROM partner_announcement WHERE ID NOT IN ('".$IndexAnn."') AND Status='1' AND (ReleaseTo='ALL' OR ReleaseTo LIKE '%".$CompanyName."%') ORDER BY C_DATE DESC";
							$cmd_ann=mysqli_query($link_db,$str_ann);
							while($data_ann=mysqli_fetch_row($cmd_ann)){
								if($data_ann[3]=="0000-00-00 00:00:00"){
									$time=$data_ann[6];
								}else{
									$time=$data_ann[3];
								}
							?>
							<tr>
								<td class="grey darken-4">
									<button type="button" class="close font-large-1" aria-label="Close" onclick="cancelCard('ann','<?=$data_ann[0]?>')">
										<span aria-hidden="true">×</span>
									</button>
									<span class="t-Italic"><?=$time?></span>
									<h2><?=$data_ann[1]?></h2>
									<p><?=$data_ann[4]?></p>
								</td>
							</tr>
							<?php
							}
							?>
						</table>

					</div>
				</div>
			</figure>
		</div>
		<!--end announcement card-->




		<!--new release card-->
		<div class="grid-item mb-2" >
			<figure class="card  box-shadow-1" >
				<div class="card-header card-head-inverse bg-purple" >
					<h1 class="card-title text-white t900" style="font-size:2rem"><i class="ft-download-cloud"></i>&nbsp;&nbsp;New Release!</h1>
					<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
					<div class="heading-elements">
						<ul class="list-inline mb-0">
							<!-- <li><a data-action="reload" onclick="reload('releasetable','<?//=$reRelease?>')"><i class="ft-rotate-cw"></i></a></li> -->
						</ul>
					</div>
				</div>
				<div class="card-content collapse show">
					<div class="">
						<table id="releasetable" class="table table-borderless table-hover table-responsive-lg">
							<!--one message-->
							<?php
							$str_release="SELECT a.ID, a.Name, a.FileDate, a.Status, b.FileType, a.ToWho, a.Description, a.FormatSize FROM partner_files a INNER JOIN partner_files_type b ON a.FileType=b.ID INNER JOIN partner_myproducts c ON a.ToWho=c.ID";
							$str_release.=" WHERE a.ToWho='1' AND a.ID NOT IN ('".$IndexRelease."') ORDER BY a.C_DATE DESC";
							$cmd_release=mysqli_query($link_db,$str_release);
							while ($data_release=mysqli_fetch_row($cmd_release)) {
								$des = str_replace("&quot;",'',$data_release[6]);
							?>
							<tr>
								<td class="grey darken-4">
									<button type="button" class="close font-large-1" aria-label="Close" onclick="cancelCard('release','<?=$data_release[0]?>')">
										<span aria-hidden="true" >×</span>
									</button>
									<span class="t-Italic"><?=$data_release[2];?></span>
									<h3><?=$data_release[4];?> - <?=$data_release[1];?> (<?=$data_release[7];?>)</h3>
									<p><?=$des;?></p>
								</td>
							</tr>
							<?php
							}
							?>
							<!--end one message-->
						</table>



					</div>
					<div class="card-footer text-muted border-top-0 " style="margin-bottom:3rem" >

						<a href="#" onclick="window.location.href='/PartnerZone/FEmarketplace';"/><span class="float-right btn btn-outline-secondary btn-sm">Go To Marketplace</span></a>
					</div>

				</div>
			</figure>
		</div>
		<!--end new release card-->














		<!--Quote card-->
		<!--<div class="grid-item mb-2" >
			<figure class="card  box-shadow-1" >
				<div class="card-header card-head-inverse bg-indigo" >
					<h1 class="card-title text-white t900" style="font-size:2rem"><i class="fa fa-usd"></i>&nbsp;&nbsp;My Quote</h1>
					<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
					<div class="heading-elements">
						<ul class="list-inline mb-0">-->
  					<!--<li><a data-action="reload"  onclick="reload('Quotetable','<?//=$reQuote?>')"><i class="ft-rotate-cw"></i></a></li>-->
						<!--<</ul>
					</div>
				</div>
				<div class="card-content collapse show">
					<div class="">
						<table id="Quotetable" class="table table-borderless table-hover table-responsive-lg">-->
							<!--one quote-->
							<?php
							/*$open="";
							//$str_quote="SELECT a.ID, a.QT_ID, a.Version, a.C_DATE, b.Products, b.Qty, a.Approval_Y FROM partner_projects_client a INNER JOIN partner_projects_items_client b ON a.QT_ID=b.QT_ID";
							$str_quote="SELECT a.ID, a.QT_ID, a.Company, a.Version, a.QT_DATE, a.Due_DATE, a.Terms, a.Remarks, a.Sales, a.STATUS, a.Approval_Y, a.Approval_N, a.Version FROM partner_projects_client a LEFT JOIN (SELECT QT_ID, max(version) as version FROM partner_projects_client) AS b ON a.Version=b.Version";
							$str_quote.=" WHERE a.ID NOT IN ('".$IndexQuote."') AND a.ToUser='".$ID."' GROUP BY a.QT_ID ORDER BY a.C_DATE DESC";
							$cmd_quote=mysqli_query($link_db,$str_quote);
							while ($data_quote=mysqli_fetch_row($cmd_quote)) {
								$QT_ID=$data_quote[1];
								$Version=$data_quote[3];
								if($data_quote[6]=="1"){
									$open="window.open('FEquoteDetails@".$data_quote[0]."');";
								}*/
								?>
								<!--<tr>
									<td class="grey darken-4">
										<button type="button" class="close font-large-1" aria-label="Close" onclick="cancelCard('quote','<?//=$data_quote[0]?>')">
											<span aria-hidden="true" >×</span>
										</button>
										<span class="t-Italic"></span>
										<h3><a href="#" target="_blank" onclick="<?//=$open?>"><?//=$data_quote[1];?></a></h3>
										<ul>
											<?php
											/*$str_item="SELECT Products, Qty FROM partner_projects_items_client WHERE QT_ID='".$QT_ID."' AND Version='".$Version."' ORDER BY Sort ASC";
											$cmd_item=mysqli_query($link_db,$str_item);
											while ($data_item=mysqli_fetch_row($cmd_item)) {*/
											?>
											<li><?//=$data_item[0];?> x <?//=$data_item[1];?></li>
											<?php
											//}
											?>
										<ul>
									</td>
								</tr>-->
								
								<?php
								//}
							?>
							<!--end one quote-->
						<!--</table>
					</div>
					<div class="card-footer text-muted border-top-0 " style="margin-bottom:3rem" >
						<a href="#" onclick="window.location.href='FEmyquotation';"/><span class="float-right btn btn-outline-secondary btn-sm">Go To My Quotation</span></a>
					</div>
				</div>
			</figure>
		</div>-->
		<!--end Quote card-->






		<!--My prouct card-->
		<div class="grid-item mb-2" >
			<figure class="card  box-shadow-1" >
				<div class="card-header card-head-inverse bg-deep-orange" >
					<h1 class="card-title text-white t900" style="font-size:2rem"><i class="ft-server"></i>&nbsp;&nbsp;My Product</h1>
					<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
					<div class="heading-elements">
						<ul class="list-inline mb-0">
							<!-- <li><a data-action="reload" onclick="reload('Proucttable','<?=$reProduct?>')"><i class="ft-rotate-cw"></i></a></li> -->
						</ul>
					</div>
				</div>
				<div class="card-content collapse show">
					<div class="">
						<table id="Proucttable" class="table table-borderless table-hover table-responsive-lg">
							<?php
							// one file 
							$strSKU="SELECT ID FROM partner_myproducts WHERE CompanyID='".$CompanyID."'";
							$cmdSKU=mysqli_query($link_db,$strSKU);
							while ($dataSKU=mysqli_fetch_row($cmdSKU)){
								$str_file="SELECT a.ID, a.Name, a.FileDate, a.Status, c.FileType, a.ToWho, a.Description, a.FormatSize FROM partner_files a INNER JOIN partner_files_type c ON a.FileType=c.ID";
								$str_file.=" WHERE (a.ToWho<>'1' AND a.ToWho LIKE '%".$dataSKU[0].",%') AND a.ID NOT IN ('".$IndexProduct."') AND a.Status='1' ORDER BY a.C_DATE DESC";
								$cmd_file=mysqli_query($link_db,$str_file);
								while ($data_file=mysqli_fetch_row($cmd_file)) {
									$des = str_replace("&quot;",'',$data_file[6]);
								?>
								<tr>
									<td class="grey darken-4">
										<button type="button" class="close font-large-1" aria-label="Close">
											<span aria-hidden="true" onclick="cancelCard('file','<?=$data_file[0]?>')">×</span>
										</button>
										<div class="badge badge-pill  font-medium-3 bg-grey"><?=$data_file[8]?></div>
										<div class="clearfix"><br /></div>
										<span class="t-Italic"><?=$data_file[2]?></span>
										<h3><?=$data_file[4]?> - <?=$data_file[1]?> (<?=$data_file[7]?>) </h3>
										<p><?=$des?></p>
									</td>
								</tr>
								<?php
								}
							}
							//  end one file 

							// File Group
							$str_group="SELECT ID, SKU, FileID, CompanyID FROM partner_files_group WHERE CompanyID LIKE '%".$CompanyID."%' AND ID NOT IN ('".$IndexFGroup."')";
							$cmd_group=mysqli_query($link_db,$str_group);
							while ($data_group=mysqli_fetch_row($cmd_group)) {
								$str_mypID="SELECT ID FROM partner_myproducts WHERE SKU='".$data_group[1]."'";
								$cmd_mypID=mysqli_query($link_db,$str_mypID);
								$data_mypID=mysqli_fetch_row($cmd_mypID);
							?>
							<tr><td class="grey darken-4">
								<button type="button" class="close font-large-1" aria-label="Close">
									<span aria-hidden="true" onclick="cancelCard('FGroup','<?=$data_group[0]?>')">×</span>
								</button>
								<div class="clearfix"><br /></div>
								<h4 class="mb-2"><a href="#" onclick="window.location.href='FEmyproducts?kind=search&product=<?=$data_mypID[0]?>&type=';"/>Click to check <?=$data_group[1]?> Files.</a></h4>

							</td></tr>
							<?php
							}
							// end File Group
							?>
							
						</table>
					</div>
					<div class="card-footer text-muted border-top-0 " style="margin-bottom:3rem" >

						<a href="#" onclick="window.location.href='FEmyproducts';" /><span class="float-right btn btn-outline-secondary btn-sm">Go To My Products</span></a>
					</div>

				</div>
			</figure>
		</div>
		<!--end my product card-->




		<!--company info card-->
		<div class="grid-item mb-2" >
			<figure class="card  box-shadow-1" >
				<div class="card-header card-head-inverse bg-green" >
					<h1 class="card-title text-white t900" style="font-size:2rem"><i class="ft-user-plus"></i>&nbsp;&nbsp;Company Info</h1>

				</div>
				<?php
				$str_company="SELECT a.CompanyID, a.CompanyName FROM partner_user a WHERE a.ID='".$ID."'";
				$cmd_company=mysqli_query($link_db,$str_company);
				$result_company=mysqli_fetch_row($cmd_company);
				$CompanyName=$result_company[1];
				$CID=$result_company[0];
				$str_list="SELECT COUNT(*) FROM partner_user WHERE CompanyID='".$result_company[0]."'";
				$list1 =mysqli_query($link_db,$str_list);
				list($public_count) = mysqli_fetch_row($list1);

				?>
				<div class="card-content collapse show">
					<div class="card-body  text-center">
						<div class="card-header mb-2">
							<h1 class="font-large-2"><?=$CompanyName?></h1>
							<span class="green font-medium-1">(ID: <?=$CID?>)</span>
							<div style="margin-top:20px">
								<!-- <a href="#" onclick="mailTo('<?//=$result_company[2]?>','<?//=$result_company[1]?>','<?//=$result_company[0]?>','com')"><button type="button" class="btn btn-green btn-min-width mr-1 mb-1"><i class="fa fa-envelope-o"></i> Contact with your sales rep</button></a> -->
              </div>
            </div>
						<hr>
						<div class="card-body">
							<p class="font-large-3"><?=$public_count?>&nbsp;<span class="font-small-3">member(s)</span></p>
						</div>
						<div class="card-footer text-muted">
							<a href="#" onclick="window.location.href='FEmyprofile';"/><span class="float-left btn btn-outline-secondary btn-sm">Add Members</span></a>
							<a href="#" onclick="window.location.href='FEmyprofile';"/><span class="float-right btn btn-outline-secondary btn-sm">Go To My Profile</span></a>
						</div> 
					</div>
				</div>
			</figure>
		</div>
		<!--end company info card-->

	</div>
</div>
</section>	









</div>
</div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->


<?php
include("footer.php");
?>

<!-- BEGIN VENDOR JS-->
<script src="app-assets/vendors/js/vendors.min.js"></script>

<!-- BEGIN VENDOR JS-->
<script src="app-assets/vendors/js/gallery/masonry/masonry.pkgd.min.js"></script>
<script src="app-assets/vendors/js/gallery/photo-swipe/photoswipe.min.js"></script>
<script src="app-assets/vendors/js/gallery/photo-swipe/photoswipe-ui-default.min.js"></script>	
<!-- BEGIN PAGE VENDOR JS-->
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="app-assets/js/core/app-menu.js"></script>
<script src="app-assets/js/core/app.js"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="app-assets/js/scripts/gallery/photo-swipe/photoswipe-script.js"></script>
<!-- END PAGE LEVEL JS-->

<script src="app-assets/js/self.js"></script>
<script type="text/javascript">
function mailTo(i,j,k,l){
	if(l=="lead"){
		location.href="mailto:"+i+"?subject=Message from company name - "+j;
	}else{
		location.href="mailto:"+i+"?subject=Message from "+j+" - "+k;
	}
}
function reload(i,j){
	var UID=$("#UID").val();
	var IN=j;
  var kind=i;
  if(kind=="Proucttable"){
  	var UID=$("#CompanyID").val();
  }
  var url = "dashboardProcess";
  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
  	UID : UID,
  	IN : IN,
    kind : kind
  },
  success: function(message){
    if(message == "success"){
    }else{
      $("#"+kind).empty("");
      $("#"+kind).append(message);
    }
  }
  }); 
}

function leadcardhidden(i){
	document.getElementById("leadcard").style.visibility="hidden"; 
}
</script>
</body>

</html>
<?php
mysqli_close($link_db);
?>