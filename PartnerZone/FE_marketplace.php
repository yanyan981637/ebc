<?php
header("X-Frame-Options: DENY");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://ipc.mitacmdt.com/");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

if(strpos(trim(getenv('REQUEST_URI')),'?')!='' || strpos(trim(getenv('REQUEST_URI')),'?')===0 || strpos(trim(getenv('REQUEST_URI')),"'")!='' || strpos(trim(getenv('REQUEST_URI')),"'")===0 || strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
  echo "<script language='javascript'>self.location='/index.html'</script>";
  exit;
}
error_reporting(0);

session_start();
$now=time();
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

$str_user="SELECT CompanyID FROM partner_user WHERE ID='".$ID."'";
$cmd_user=mysqli_query($link_db,$str_user);
$company = mysqli_fetch_row($cmd_user);
$companyID=$company[0];

$str_Ftype="SELECT ID, FileType FROM partner_files_type WHERE 1";
$cmd_Ftype=mysqli_query($link_db,$str_Ftype);
while ($Ftype = mysqli_fetch_row($cmd_Ftype)) {
  $FileType[$Ftype[0]]=$Ftype[1];
}

if($_GET['kind']!=""){
  $kind=dowith_sql($_GET['kind']);
  $kind=filter_var($kind);
}
if($_GET['t']!=""){
  $type=dowith_sql($_GET['t']);
  $type=filter_var($type);
}
if($type!=""){
  $class_default="btn btn-outline-secondary";
}else{
  $class_default="btn btn-secondary";
 }
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">


<title>MiTAC Partner Zone - Marketplace</title>


<link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
<link rel="shortcut icon" href="/images/ico/favicon.ico">
<link rel="manifest" href="images/favicon/site.webmanifest">
<link rel="mask-icon" href="images/favicon/safari-pinned-tab.svg" color="#5bbad5">

<!-- BEGIN VENDOR CSS-->
<link rel="stylesheet" type="text/css" href="app-assets/css/vendors.css">
<link rel="stylesheet" type="text/css" href="app-assets/vendors/js/gallery/photo-swipe/photoswipe.css">
<link rel="stylesheet" type="text/css" href="app-assets/vendors/js/gallery/photo-swipe/default-skin/default-skin.css">
<!-- END VENDOR CSS-->
<!-- BEGIN ROBUST CSS-->
<link rel="stylesheet" type="text/css" href="app-assets/css/app.css">
<link rel="stylesheet" type="text/css" href="app-assets/fonts/font-awesome/css/fontawesome.css" >
<link rel="stylesheet" type="text/css" href="app-assets/fonts/feather/style.min.css" >
<!-- END ROBUST CSS-->
<!-- BEGIN Page Level CSS-->
<!--<link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.css">-->
<link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-overlay-menu.css">
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
        <h3 class="content-header-title mb-0 d-inline-block">Marketplace</h3>
        <div class="row breadcrumbs-top d-inline-block">
          <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="FEdashboard">Dashboard</a>
              </li>
              <li class="breadcrumb-item active">Marketplace
              </li>
            </ol>
          </div>
        </div>
      </div>
      <!--end breadcrumb-->

    </div>
    <div class="content-body">
      <input id="UID" type="hidden" value="<?=$ID?>"> <!-- for self.js -->
      <!--sorting-->
      <div class="btn-group" role="group" style="margin:1rem 1rem">
        <button type="button" class="<?=$class_default?>" onclick="search(0)">ALL</button>
        <?php
        $str_type="SELECT ID, FileType FROM partner_files_type WHERE 1";
        $cmd_type=mysqli_query($link_db,$str_type);
        while ($data_type=mysqli_fetch_row($cmd_type)) {
          if($type==$data_type[0]){
            $class="btn btn-secondary";
          }else{
            $class="btn btn-outline-secondary";
          }
        ?>
        <button type="button" class="<?=$class?>" onclick="search(<?=$data_type[0]?>)"><?=$data_type[1]?></button>
        <?php
        }
        ?>
      </div>
      <!--end sorting-->

      <section id="image-grid" class="">

        <div class="card-content">

          <div class="masonry-grid my-gallery mx-1" >
            <div class="grid-sizer"></div>
            <!--one card-->
            <?php
            if($kind=="search"){
              $str_file="SELECT a.ID, a.FileType, b.Name, b.Description, b.FormatSize, b.FileDate, b.ImageURL, b.DownloadURL FROM partner_files_type a INNER JOIN partner_files b ON a.ID=b.FileType WHERE ToWho='1' AND a.ID='".$type."' ORDER BY FileDate DESC";
            }else{
              $str_file="SELECT a.ID, a.FileType, b.Name, b.Description, b.FormatSize, b.FileDate, b.ImageURL, b.DownloadURL FROM partner_files_type a INNER JOIN partner_files b ON a.ID=b.FileType WHERE ToWho='1' ORDER BY FileDate DESC";
            }
            $cmd_file=mysqli_query($link_db,$str_file);
            while ($data_file=mysqli_fetch_row($cmd_file)) {
              $des = str_replace("&quot;",'',$data_file[3]);
            ?>
            <div class="grid-item">
              <figure class="card border-grey border-lighten-2" >
                <a href="#" onclick="window.open('<?=$data_file[7]?>');">
                  <img class="gallery-thumbnail card-img-top" src="<?=$data_file[6]?>"  />
                </a>
                <div class="card-body">
                 <div  ><span class="badge badge-info"><?=$data_file[1]?></span></div>
                 <span class="mk-date info darken-2"><?=$data_file[5]?></span>
                 <h4 class="card-title"><?=$data_file[2]?> <a href="#" onclick="window.open('<?=$data_file[7]?>');" />(<?=$data_file[4]?>)</a></h4>
                 <p class="card-text"><?=$des?></p>
               </div>
             </figure>
           </div>
            <?php
            }
            ?>

           <!--end one card-->

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
<!-- BEGIN PAGE VENDOR JS-->
<script src="app-assets/vendors/js/gallery/masonry/masonry.pkgd.min.js"></script>
<script src="app-assets/vendors/js/gallery/photo-swipe/photoswipe.min.js"></script>
<script src="app-assets/vendors/js/gallery/photo-swipe/photoswipe-ui-default.min.js"></script>


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
function search(i){
  if(i==0){
    document.location.href="FEmarketplace";
    exit;
  }
  var t=i;
  document.location.href="FEmarketplace@"+t;
}
</script>
</body>
</html>
<?php
mysqli_close($link_db);
?>