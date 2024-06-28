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

if($_GET['ID']!=""){
  $ID=dowith_sql($_GET['ID']);
  $ID=filter_var($ID);
}


// Title Company Name
$str="SELECT CompanyName, ID, CompanyID, CompanyAddress, Name, Email, Title, CountryCode, Tel, ResponsibleSales, C_DATE, U_DATE FROM partner_user WHERE ID='".$ID."' ";
$cmd=mysqli_query($link_db,$str);
$result=mysqli_fetch_row($cmd);
$user_CountryCode=$result[7];
// Title Company Name End

?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">


<title>MiTAC Partner Zone - My Profile - Edit Members</title>


<link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
<link rel="shortcut icon" href="/images/ico/favicon.ico">
<link rel="manifest" href="images/favicon/site.webmanifest">
<link rel="mask-icon" href="images/favicon/safari-pinned-tab.svg" color="#5bbad5">


<!-- BEGIN VENDOR CSS-->
<link rel="stylesheet" type="text/css" href="app-assets/css/vendors.css">
<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/selects/select2.min.css">
<!-- END VENDOR CSS-->
<!-- BEGIN ROBUST CSS-->
<link rel="stylesheet" type="text/css" href="app-assets/css/app.css">
<link rel="stylesheet" type="text/css" href="app-assets/fonts/font-awesome/css/fontawesome.css" >
<link rel="stylesheet" type="text/css" href="app-assets/fonts/feather/style.min.css" >
<!-- END ROBUST CSS-->
<!-- BEGIN Page Level CSS-->

<link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-overlay-menu.css">
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
        <h3 class="content-header-title mb-0 d-inline-block">My Profile</h3>
        <div class="row breadcrumbs-top d-inline-block">
          <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="FEdashboard">Dashboard</a>
              </li>
              <li class="breadcrumb-item"><a href="FEmyprofile">My Profile</a>
              </li>
              <li class="breadcrumb-item active">Edit Members
              </li>
            </ol>
          </div>
        </div>
      </div>
      <!--end breadcrumb-->
    </div>
    <div class="content-body">
      <div class="row">
        <!--Members list-->
        <div class="col-12">
          <div class="card no-border box-shadow-1">
            <div class="card-content">
              <div class="card-body">

                <h1 class="card-header ">Edit Members:</h1>
                <input id="companyID" type="hidden" value="<?=$result[2]?>">
                <!--add one member-->
                <div class="repeater-default  p-15">
                  <div data-repeater-list="">
                    <div id="d_member" data-repeater-item>
                      <form class="form row">
                        <div class="form-group mb-1 col-sm-12 col-md-2">
                          <div class="form-group">
                            <label for="username">Name:</label>
                            <input id="Name" name="CName" type="" class="form-control" placeholder="" value="<?=$result[4]?>" required>
                          </div>
                        </div>
                        <div class="form-group mb-1 col-sm-12 col-md-2">
                          <div class="form-group">
                            <label for="email">Email Address:</label>
                            <input id="email" name="email" type="" class="form-control" placeholder="" value="<?=$result[5]?>" required>
                            <div id="erremail" name="erremail" class="alert alert-danger mb-1" role="alert" style="display:none">
                              This email has already been registered.
                            </div>
                          </div>
                        </div>
                        <div class=" form-group mb-1 col-sm-12 col-md-2">
                         <div class="form-group">
                           <label>Title: </label>
                           <input id="Title" name="Title" type="text" placeholder="" class="form-control" value="<?=$result[6]?>">
                         </div>
                       </div>
                       <div class=" form-group mb-1 col-sm-12 col-md-2">
                        <div class="form-group">
                          <label>Regions: </label>
                          <select id="sel_regions" name="sel_regions" class="form-control">
                            <option value="" selected>All Regions</option>
                            <option value="NA" <?php if($result[7]=="NA"){echo "selected";}?> >North America</option>
                            <option value="SA" <?php if($result[7]=="SA"){echo "selected";}?> >Central / South America</option>
                            <option value="EUR" <?php if($result[7]=="EUR"){echo "selected";}?> >Europe</option>
                            <option value="ME" <?php if($result[7]=="ME"){echo "selected";}?> >Middle East / Africa</option>
                            <option value="ASIA" <?php if($result[7]=="ASIA"){echo "selected";}?> >Asia</option>
                            <option value="Oceania" <?php if($result[7]=="Oceania"){echo "selected";}?> >Oceania</option>
                          </select>
                        </div>
                      </div>
                       <div class="form-group mb-1 col-sm-12 col-md-4">

                        <div class="row">
                          <!-- <div class="col-md-5">
                            <div class="form-group">
                              <label for="countryCode">Tel:</label>
                              <select id="countryCode" name="countryCode"  class="select2 form-control" style="width: 100%">
                                <option value="" selected>Select...</option>
                                <?php
                                /*$str_reg="SELECT Regions, ID, CountryCode, CountryName, Icon FROM partner_countrycode WHERE 1 GROUP BY Regions ORDER BY ID";
                                $cmd_reg=mysqli_query($link_db,$str_reg);
                                while ($reg=mysqli_fetch_row($cmd_reg)) {
                                  if($reg[0]=="United States"){
                                    $label=$reg[4];
                                  }else{
                                    $label="";
                                  }
                                  echo "<optgroup label='".$label." ".$reg[0]."'> ";
                                  $str_country="SELECT Regions, ID, CountryCode, CountryName, CodeNumber, Icon FROM partner_countrycode WHERE Regions='".$reg[0]."'";
                                  $cmd_country=mysqli_query($link_db,$str_country);
                                  while ($countryCode=mysqli_fetch_row($cmd_country)) {
                                    if($countryCode[0]!="United States"){
                                      $icon=$countryCode[5];
                                    }else{
                                      $icon="";
                                    }
                                    if($countryCode[2]==$user_CountryCode){
                                      $status="selected";
                                    }else{
                                      $status="";
                                    }
                                    echo "<option data-countryCode='".$countryCode[2]."' value='".$countryCode[2]."' ".$status.">".$icon." ".$countryCode[3]."(+".$countryCode[4].")</option>";
                                  }
                                }*/
                                ?>
                              </select>
                            </div>
                          </div> -->
                          <div class="col-md-7"><div class="form-group">
                            <label for="countryCode">Tel:</label>
                            <label for="tel">&nbsp;</label>
                            <input id="tel" name="tel" type="" class="form-control"  placeholder="" value="<?=$result[8]?>" required>
                          </div>
                        </div>
                      </div>

                    </div>
                  <!-- <div class="form-group col-sm-12 col-md-2 text-center mt-2">
                    <button type="button" class="btn btn-danger" data-repeater-delete> <i class="ft-x"></i> Delete</button>
                  </div> -->
                </form>
                <!-- <hr> -->
              </div>
            </div>
            <!-- <div class="form-group overflow-hidden">
              <div class="col-12">
                <button data-repeater-create class="btn btn-outline-secondary">
                  <i class="ft-plus"></i> Add
                </button>
              </div>
            </div> -->
          </div>
          <!--end add one member-->



          <br />
          <hr><br />
          <div class="text-left">
           <button id="EditOK" type="button" class="btn btn-info mr-1 mb-1"><i class="ft-save"></i> Save</button>
           <a href="FEmyprofile"  /><button type="button" class="btn btn-light mr-1 mb-1"><i class="ft-chevrons-left"></i> Back </button></a>
           <input id="editID" type="hidden" value="<?=$result[1]?>">
         </div>
       </div>
     </div>
   </div>
 </div>
 <!--end Members list-->
</div>
</div>
</div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->

<?php
include("footer.php");
?>

<!-- BEGIN VENDOR JS-->

<!--
<script src="app-assets/js/core/libraries/jquery.min.js"></script>
<script src="app-assets/js/core/libraries/bootstrap.min.js"></script>




<!-- BEGIN VENDOR JS-->
<script src="app-assets/vendors/js/vendors.min.js"></script>

<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<script src="app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
<script src="app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="app-assets/js/core/app-menu.js"></script>
<script src="app-assets/js/core/app.js"></script>
<script src="app-assets/vendors/js/forms/extended/maxlength/bootstrap-maxlength.js"></script>
<script src="app-assets/js/scripts/forms/extended/form-maxlength.js"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="app-assets/js/scripts/forms/form-repeater.js"></script>
<script src="app-assets/js/scripts/forms/select/form-select2.js"></script>
<!-- END PAGE LEVEL JS-->

<script src="app-assets/js/self.js"></script>
<script>
$("#EditOK").click(function(){
  var CompanyID = document.getElementById("companyID").value;
  var editID = document.getElementById("editID").value;
  var name=$("#Name").val();
  var email=$("#email").val();
  var title=$("#Title").val();
  var countryCode=$("#sel_regions").val();
  var tel=$("#tel").val();
  var kind="editMembers";
  var url = "memberProcess";
  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
    CompanyID : CompanyID,
    editID : editID,
    name : name,
    email : email,
    title : title,
    countryCode : countryCode,
    tel : tel,
    kind : kind
  },
  success: function(message){
    if(message == "success"){
      alert("Update Members Done.");
      document.location.href="FEmyprofile";
    }else if(message == "repeat"){
      $("#erremail").show();
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