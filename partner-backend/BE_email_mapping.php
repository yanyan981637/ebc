<?php
header("X-Frame-Options: DENY");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://www.mitacmct.com/");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

error_reporting(0);

session_start();
if($_SESSION['user']=="" || $_SESSION['ID']==""){
  echo "<script language='javascript'>self.location='login'</script>";
  exit;
}

require "../config.php";


$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
    
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
if($_GET['Search']!=""){
  $Search=dowith_sql($_GET['Search']);
  $Search=filter_var($Search);
}else{
  $Search="";
}

$Role=$_SESSION['role'];
if($Role!="SUAD"){
  echo "<script language='javascript'>self.location='BEdashboard'</script>";
}

if($Search!=""){
  $tmp=explode(",", $Search);
  $i=0;
  foreach ($tmp as $key => $value) {
    if($value!=""){
      $str_count="SELECT ID FROM `partner_mapping` WHERE CountryCode Like '%".$value."%'";
      $list1 =mysqli_query($link_db,$str_count);
      while ($Total_count_ID = mysqli_fetch_row($list1)) {
        if($arrID[$Total_count_ID[0]]==""){
          $a.=$Total_count_ID[0];
          $arrID[$Total_count_ID[0]]=$Total_count_ID[0];
          $i++;
        }   
      } 
    }
  }
  $Total_count=$i;
}else{
  $str_count="SELECT count(ID) FROM `partner_mapping` WHERE 1";
  $list1 =mysqli_query($link_db,$str_count);
  list($Total_count) = mysqli_fetch_row($list1);  
}
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <title>BACKEND - Settings for Email Notification Mapping - MiTAC Partner Zone</title>


  <link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
  <link rel="shortcut icon" href="/images/ico/favicon.ico">
  <link rel="manifest" href="images/favicon/site.webmanifest">
  <link rel="mask-icon" href="images/favicon/safari-pinned-tab.svg" color="#5bbad5">

  <!-- BEGIN VENDOR CSS-->
  <link rel="stylesheet" type="text/css" href="app-assets/css/vendors.css">
  <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/listbox/bootstrap-duallistbox.min.css">
  <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/selects/select2.min.css">
  <!-- END VENDOR CSS-->
  <!-- BEGIN ROBUST CSS-->
  <link rel="stylesheet" type="text/css" href="app-assets/css/app.css">
  <link rel="stylesheet" type="text/css" href="app-assets/fonts/font-awesome/css/fontawesome.css" >
  <link rel="stylesheet" type="text/css" href="app-assets/fonts/feather/style.min.css" >	
  <!-- END ROBUST CSS-->
  <!-- BEGIN Page Level CSS-->
  <link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.css">
  <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/forms/dual-listbox.css">
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
              <li class="breadcrumb-item">Settings
              </li>
              <li class="breadcrumb-item active">Email Mapping
              </li>
            </ol>
          </div>
        </div>
      </div>

    </div>
    <div class="content-body">

      <h1>Settings for receiving email notifications from different regions/countries</h1>

      <hr>
      <!--search & sorting-->					
      <div class="row">
       <div class="col-md-10">
        <select id="search_country" class="select2 form-control"  multiple="multiple" style="width: 100%">
          <?php
          include("countryCode.php");
          ?>
        </select>

      </div>
    <div class="col-md-2">
      <button id="SearchOK" type="button" class="btn btn-info mr-1 mb-1">Search</button>							
    </div>
  </div>
  <!--end search & sorting-->						
  <!--total-->	
  <hr>				
  <div class="row">
   <div class="col-md-12">


   </div>
 </div>
 <!--end total-->

 <div class="row">
  <div class="col-xl-12 col-lg-12">
    <div class="card no-border box-shadow-1">
      <div class="card-content">
        <div class="card-body">

         <h3>Total: <span class="info darken-4 t700"><?=$Total_count;?></span></h3>
         <div class="text-left"><a href="addemail_mapping"  /><button type="button" class="btn btn-info mr-1 mb-1"><i class="ft-plus"></i> Add </button></a></div>


         <!-- list table-->

         <table class="table table-hover table-responsive">
          <thead class="bg-grey bg-lighten-4">
            <tr>
              <th>Received E-mail Accounts</th>		
              <th>Regions / Countries</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
            if($Search!=""){
              if($arrID!=""){
                $i=0;
                foreach ($arrID as $key => $value) {
                  $strList="SELECT ID, Sales, CountryCode FROM `partner_mapping` WHERE ID='".$value."' ORDER BY U_DATE DESC";
                  $cmdList=mysqli_query($link_db,$strList);
                  while ($dataList = mysqli_fetch_row($cmdList)) {
                    $sales=str_replace(",", "<br>",$dataList[1]);                  
                    ?>
                    <tr>
                      <td><?=$sales;?></td> 
                      <td><?=$dataList[2];?></td>
                      <td>
                        <a href="editemail_mapping@<?=$dataList[0];?>"  /><button type="button" class="btn btn-outline-info btn-sm mr-b-1">Edit</button></a>
                        <a href="" data-toggle="modal" data-target="#del-email-mapping" />
                          <button id="Del" type="button" class="btn btn-outline-info btn-sm mr-b-1" onclick="delID('<?=$i?>')">Delete</button>
                        </a>
                        <input id="deleteID_<?=$i?>" type="text" value="<?=$dataList[0]?>"></td>
                      </tr>
                    <?php
                    $i++;
                  }
                }
              }
              
            }else{
              $i=0;
              $strList="SELECT ID, Sales, CountryCode FROM `partner_mapping` WHERE 1 ORDER BY U_DATE DESC";
              $cmdList=mysqli_query($link_db,$strList);
              while ($dataList = mysqli_fetch_row($cmdList)) {
                $sales=str_replace(",", "<br>",$dataList[1]);                  
                ?>
                <tr>
                  <td><?=$sales;?></td> 
                  <td><?=$dataList[2];?></td>
                  <td>
                    <a href="editemail_mapping@<?=$dataList[0];?>"  /><button type="button" class="btn btn-outline-info btn-sm mr-b-1">Edit</button></a>
                    <a href="" data-toggle="modal" data-target="#del-email-mapping" />
                      <button id="Del" type="button" class="btn btn-outline-info btn-sm mr-b-1" onclick="delID('<?=$i?>')">Delete</button>
                    </a>
                    <input id="deleteID_<?=$i?>" type="hidden" value="<?=$dataList[0]?>">
                  </td>
                </tr>
              <?php
                $i++;
              }
            }
            ?>
          </tbody>
        </table>
        <input id="selDel" type="hidden" value=""> <!--select which delete id -->
        <!--end list table-->

      </div>
    </div>
  </div>
</div>

</div>


</div>
</div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->


<!--footer-->
<?php
include("footer.php");
?>
<!--end footer--> 


<!--delete email mapping Modal -->
<div class="modal fade text-left" id="del-email-mapping" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
   <div class="modal-content">
    <div class="modal-header">
     <h1 class="red"><i class="ft-trash-2"></i><h1>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <form action="#">
      <div class="modal-body">
       Are you sure you want to delete this setting?

     </div>

     <div class="modal-footer">
      <input id="Del_Y" type="submit" class="btn btn-info " value="Yes, Delete it." onclick="DelMapping()">
      <input type="submit" class="btn btn-secondary " data-dismiss="modal" value="No">	
    </div>
  </form>
</div>
</div>
</div>

<!-- end delete email mapping Modal -->	






















<!-- BEGIN VENDOR JS-->
<script src="app-assets/js/core/libraries/jquery.min.js"></script>

<!-- BEGIN VENDOR JS-->
<script src="app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN PAGE VENDOR JS-->
<script src="app-assets/vendors/js/forms/listbox/jquery.bootstrap-duallistbox.min.js"></script>
<script src="app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="app-assets/js/core/app-menu.js"></script>
<script src="app-assets/js/core/app.js"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="app-assets/js/scripts/forms/listbox/form-duallistbox.js"></script>
<script src="app-assets/js/scripts/forms/select/form-select2.js"></script>
<!-- END PAGE LEVEL JS-->

<script>
$("#SearchOK").click(function(){
  var country="";
  var search_country = document.getElementById("search_country");
  for(var i=0;i<search_country.options.length;i++){
    if (search_country.options[i].selected) {
      country += search_country.options[i].value + ",";
    }
  }
  //alert(country);
  document.location.href=country+"@BEemail_mapping";
  
})

function delID(i){
  var selDel=i;
  document.getElementById("selDel").value=selDel;
}

function DelMapping(){
  var tmp=document.getElementById("selDel").value;
  var DelID=document.getElementById("deleteID_"+tmp).value;
  var kind = "Del";
  var url = "mappingProcess";
  $.ajax({
    type: "post",
    url: url,
    dataType: "html",
    data: {
      DelID : DelID, 
      kind : kind
    },
    success: function(message){
      if(message == "success"){
        alert("Delete Done.");
        location.reload(); 
      }else{
       alert(message);
     }
   }
 });
 
}
</script>
</body>
</html>
<?php
mysqli_close($link_db);
?>