<?php
header("X-Frame-Options: DENY");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://ipc.mitacmdt.com/");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

if(strpos(trim(getenv('REQUEST_URI')),"'")!='' || strpos(trim(getenv('REQUEST_URI')),"'")===0 || strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
echo "<script language='javascript'>self.location='/404.htm'</script>";
exit;
}
error_reporting(0);

session_start();
if($_SESSION['user']=="" || $_SESSION['ID']==""){
  echo "<script language='javascript'>self.location='login'</script>";
  exit;
}

require "../config.php";


putenv("TZ=Asia/Taipei");
$now=date("Y/m/d");

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');

include("countryCodeReplace.php");
function dowith_sql($str)
{
  /*$str = str_replace("and","",$str);
  $str = str_replace("execute","",$str);
  $str = str_replace("update","",$str);
  $str = str_replace("count","",$str);
  $str = str_replace("chr","",$str);
  $str = str_replace("mid","",$str);
  $str = str_replace("master","",$str);
  $str = str_replace("truncate","",$str);*/
  //$str = str_replace("char","",$str);
  $str = str_replace("declare","",$str);
  //$str = str_replace("select","",$str);
  //$str = str_replace("create","",$str);
  //$str = str_replace("delete","",$str);
  //$str = str_replace("insert","",$str);
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

$Role=$_SESSION['role'];
if($Role=="SA" ){
  echo "<script language='javascript'>self.location='BEdashboard'</script>";
}

$str_count="SELECT COUNT(*) FROM partner_announcement WHERE 1";
$list1 =mysqli_query($link_db,$str_count);
list($public_count) = mysqli_fetch_row($list1);

$per = 10; //每頁顯示項目數量
$pages_totle = ceil($public_count/$per); //總頁數

if(!isset($_GET["page"])){
    $page=1; //設定起始頁
} else {
    $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
    $page = ($page > 0) ? $page : 1; //確認頁數大於零
    $pages=0;
    $page = ($pages_totle > $page) ? $page : $pages_totle; //確認使用者沒有輸入太神奇的數字
}

$start = ($page-1)*$per; //每頁起始資料序號

?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <title>BACKEND - Add Edit file group - MiTAC Partner Zone</title>


  <link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
  <link rel="shortcut icon" href="/images/ico/favicon.ico">
  <link rel="manifest" href="images/favicon/site.webmanifest">
  <link rel="mask-icon" href="images/favicon/safari-pinned-tab.svg" color="#5bbad5">

  <!-- BEGIN VENDOR CSS-->
  <link rel="stylesheet" type="text/css" href="app-assets/css/vendors.css">
  <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/selects/select2.min.css">
  <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/icheck/icheck.css">
  <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/icheck/custom.css">
  <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/pickers/daterange/daterangepicker.css">
  <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/pickers/pickadate/pickadate.css">
  <!-- END VENDOR CSS-->
  <!-- BEGIN ROBUST CSS-->
  <link rel="stylesheet" type="text/css" href="app-assets/css/app.css">
  <link rel="stylesheet" type="text/css" href="app-assets/fonts/font-awesome/css/fontawesome.css" >
  <link rel="stylesheet" type="text/css" href="app-assets/fonts/feather/style.min.css" >
  <!-- END ROBUST CSS-->
  <!-- BEGIN Page Level CSS-->
  <link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.css">
  <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/forms/checkboxes-radios.css">
  <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/pickers/daterange/daterange.css">

  <!-- END Page Level CSS-->
  <!-- BEGIN Custom CSS-->
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <!-- END Custom CSS-->
</head>
<body  class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">

<!-- fixed-top-->
<?php
include("top.php");
?>
<!-- fixed-top end-->

<!--left menu-->
<?php
include("left_menu.php");
?>
<!--end left menu-->

<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
        <h3 class="content-header-title mb-0 d-inline-block">MiTAC Partner Zone</h3>
        <div class="row breadcrumbs-top d-inline-block">
          <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="BEdashboard">Dashboard</a>
              </li>
              <li class="breadcrumb-item">Contents Management
              </li>
              <li class="breadcrumb-item"><a href="BEgroupsMgt">Files Group Management</a>
              </li>
              <li class="breadcrumb-item active">Add Edit a Group
              </li>
            </ol>
          </div>
        </div>
      </div>

    </div>
    <div class="content-body">




     <div class="row ">
      <div class="col-12 ">
        <div class="card no-border box-shadow-1">
          <div class="card-content">
            <div class="card-body p-3">
              <h1>Add a Group:</h1>
              <hr>
              <form>
                <div class="form-group" >
                  <label><strong>Select a product: </strong></label>
                  <select id="sel_sku"  class="select2 form-control block"  style="width: 100%" onchange="selSKU()">
                    <option value="">SKU</option>
                    <?php
                    $strSKU="SELECT ID, Model, SKU, ProductType FROM partner_model WHERE 1 ORDER BY SKU ASC";
                    $cmdSKU =mysqli_query($link_db,$strSKU);
                    while($dataSKU = mysqli_fetch_row($cmdSKU)) {
                      echo "<option value='".$dataSKU[0]."'>".$dataSKU[2]."</option>";
                    }
                    ?>
                 </select>
               </div>
               <div class="form-group bg-grey bg-lighten-3 p-2" style="">
                <label><strong>Files: </strong></label>
                <button type="button" class="btn btn-outline-secondary ml-1" data-toggle="modal" data-target="#addfileForm">
                  Add
                </button>
                <input id="FileID" type="hidden" value="">
                <!--show selected items-->
                <div id="div_file" class="p-2">

                </div>
                <!-- end show selected items-->


              </div>
              <div class="form-group bg-grey bg-lighten-3 p-2">
                <label><strong>Clients / Companies: </strong></label>

                <!--show selected items-->
                <form action="#">
                  <div id="div_Clients" class="p-2">
                  </div>
                </form>
                <!-- end show selected items-->
              </div>



              <br />
              <button id="addGroup" type="button" class="btn btn-info mr-1 mb-1"><i class="ft-save"></i> SAVE </button>
              <a href="BEgroupsMgt"  /><button type="button" class="btn btn-light mr-1 mb-1"><i class="ft-chevrons-left"></i> BACK </button></a>
            </form>

          </div>
        </div>
      </div>
    </div>


  </div>

</div>
</div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->


<footer class="footer footer-static footer-dark navbar-border">
  <p class="clearfix  lighten-2 text-sm-center mb-0 px-2"><span class="float-md-left d-block d-md-inline-block">Copyright&copy; 2004-2021 MiTAC Digital Technology Corporation and/or any of its affiliates. All Rights Reserved. Please use the latest version of Firefox or Chrome to view this site.</span></p>
</footer>





<!--add files Modal -->
<div class="modal fade text-left" id="addfileForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
   <div class="modal-content">
    <div class="modal-header">
     <h4>Select File(s):</h4>
     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true">&times;</span>
     </button>
   </div>
   <form action="#">
    <div class="modal-body">
      <fieldset class="checkboxsas">
        <?php
        $strFile="SELECT a.ID, a.Name, a.FileType, b.ID, b.FileType FROM partner_files a INNER JOIN partner_files_type b ON a.FileType=b.ID WHERE 1 ORDER BY a.Name ASC";
        $cmdFile =mysqli_query($link_db,$strFile);
        while($dataFile = mysqli_fetch_row($cmdFile)) {
          echo "<fieldset class='checkboxsas'>";
          echo "<label><input id='selFile' name='selFile' type='checkbox' value='".$dataFile[0]."'> ".$dataFile[1]." (".$dataFile[4].") </label>";
          echo "</fieldset>";
        }
        ?>
      </div>
    <div class="modal-footer">
     <input id="addFile" type="button" class="btn btn-info btn-lg" value="Confirm">
   </div>
 </form>
</div>
</div>
</div>

<!--end add files Modal -->


<!-- BEGIN VENDOR JS-->
<script src="app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<script src="app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="app-assets/vendors/js/forms/icheck/icheck.min.js"></script>


<script src="app-assets/vendors/js/editors/ckeditor/ckeditor.js"></script>
<script src="app-assets/vendors/js/pickers/pickadate/picker.js"></script>
<script src="app-assets/vendors/js/pickers/pickadate/picker.date.js"></script>
<script src="app-assets/vendors/js/pickers/pickadate/picker.time.js"></script>
<script src="app-assets/vendors/js/pickers/pickadate/legacy.js"></script>
<script src="app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js"></script>
<script src="app-assets/vendors/js/pickers/daterange/daterangepicker.js"></script>





<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="app-assets/js/core/app-menu.js"></script>
<script src="app-assets/js/core/app.js"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="app-assets/js/scripts/forms/select/form-select2.js"></script>
<script src="app-assets/js/scripts/forms/checkbox-radio.js"></script>
<script src="app-assets/js/scripts/editors/editor-ckeditor.js"></script>
<script src="app-assets/js/scripts/pickers/dateTime/pick-a-datetime.js"></script>
<!-- END PAGE LEVEL JS-->

<script>
function selSKU(){
  var ID = document.getElementById("sel_sku").value;
  var kind="selSKU";
  var url = "groupProcess";
  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
    ID : ID,
    kind : kind
  },
  success: function(message){
    if(message == "success"){
      //location.reload();
    }else{
      $("#div_Clients").empty();
      $("#div_Clients").append(message);
    }
  }
  });
}

$("#addFile").click(function(){
  var file = document.getElementsByName("selFile");
  var checkboxID="";
  for (var i = 0; i < file.length; i++) {
    if (file[i].checked) {
      checkboxID+=file[i].value+",";
    }
  }
  var kind="addFile";
  var url = "groupProcess";
  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
    checkboxID : checkboxID,
    kind : kind
  },
  success: function(message){
    if(message == "success"){
      //location.reload();
    }else{
      $("#div_file").empty();
      $("#div_file").append(message);
      document.getElementById("FileID").value=checkboxID;
      $("#addfileForm").modal('hide');
    }
  }
  });
})

$("#addGroup").click(function(){
  var SKUID = document.getElementById("sel_sku").value;
  var FileID = document.getElementById("FileID").value;
  var CID = document.getElementsByName("CID");
  var companyID="";
  for (var i = 0; i < CID.length; i++) {
    if (CID[i].checked) {
      companyID+=CID[i].value+",";
    }
  }
  var kind="addGroup";
  var url = "groupProcess";
  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
    SKUID : SKUID,
    companyID : companyID,
    FileID : FileID,
    kind : kind
  },
  success: function(message){
    if(message == "success"){
      document.location.href="BEgroupsMgt";
      //location.reload();
    }else{
      alert(message);
    }
  }
  });
})
</script>
</body>
</html>
<?php
mysqli_close($link_db);
?>