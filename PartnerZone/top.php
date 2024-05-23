<?php
$userName=$_SESSION['FEuser'];
$UserID=$_SESSION['FEID'];;

$str_user="SELECT CompanyID, CompanyName FROM partner_user WHERE ID='".$UserID."'";
$cmd_user=mysqli_query($link_db,$str_user);
$company = mysqli_fetch_row($cmd_user);
$CompanyName=$company[1];

function sqlin($str){
  if($str!=""){
    $tmp=explode(",", $str);
    $tmp1="";
    foreach ($tmp as $key => $value) {
      if($tmp1=="" ){
        if($value!=""){
          $tmp1=$value;
        }
      }elseif($value!=""){
        $tmp1.="','";
        $tmp1.=$value;
      }
    }
    return $tmp1;
  }
  return $str;
}

$IndexCard="";$IndexAnn="";$IndexRelease="";$IndexQuote="";$IndexProduct="";
$reAnn="";$reRelease="";$reQuote="";$reProduct="";$CompanyID="";$IndexFGroup="";
$str_top="SELECT IndexCard, IndexAnn, IndexRelease, IndexQuote, IndexProduct, CompanyID, FirstLogin, IndexFGroup FROM partner_user WHERE ID='".$UserID."'";
$cmd_top=mysqli_query($link_db,$str_top);
$data_top=mysqli_fetch_row($cmd_top);
$IndexCard=$data_top[0];
$reAnn=$data_top[1];
$IndexAnn=sqlin($reAnn);
$reRelease=$data_top[2];
$IndexRelease=sqlin($reRelease);
$reQuote=$data_top[3];
$IndexQuote=sqlin($reQuote);
$reProduct=$data_top[4];
$IndexProduct=sqlin($reProduct);
$CompanyID=$data_top[5];
$FirstLogin=$data_top[6];
$IndexFGroup=$data_top[7];
/*$str_top="SELECT FirstLogin, IndexCard, IndexAnn, IndexRelease, IndexQuote, IndexProduct, CompanyID FROM partner_user WHERE ID='".$ID."'";
$cmd_top=mysqli_query($link_db,$str_top);
$data_top=mysqli_fetch_row($cmd_top);*/

$num="0";
$str_ann="SELECT ID, Title, ReleaseTo, Schedule, Message, Status, C_DATE FROM partner_announcement WHERE ID NOT IN ('".$IndexAnn."') AND (ReleaseTo='ALL' OR ReleaseTo='".$CompanyName."') AND Status='1' ORDER BY C_DATE DESC LIMIT 5";
$cmd_ann=mysqli_query($link_db,$str_ann);
$data=mysqli_num_rows($cmd_ann);
$num+=$data;

//$str_file="SELECT a.ID, a.Name, a.FileDate, a.Status, c.FileType, a.ToWho, a.Description, a.FormatSize, b.SKU FROM partner_files a INNER JOIN partner_myproducts b ON a.ToWho=b.ID INNER JOIN partner_files_type c ON a.FileType=c.ID";
//$str_file.=" WHERE (a.ToWho='1' OR b.CompanyID='".$CompanyID."') AND a.ID NOT IN ('".$IndexProduct."') ORDER BY a.C_DATE DESC LIMIT 5";
//$cmd_file=mysqli_query($link_db,$str_file);
//$data=mysqli_num_rows($cmd_file);

$tmpFnum=""; // file num
$i=0;
$strSKU="SELECT ID FROM partner_myproducts WHERE CompanyID='".$CompanyID."'";
$cmdSKU=mysqli_query($link_db,$strSKU);
while ($dataSKU=mysqli_fetch_row($cmdSKU)){
  $str_file="SELECT a.ID, a.Name, a.FileDate, a.Status, c.FileType, a.ToWho, a.Description, a.FormatSize FROM partner_files a INNER JOIN partner_files_type c ON a.FileType=c.ID";
  $str_file.=" WHERE (a.ToWho='1' OR a.ToWho LIKE '%".$dataSKU[0].",%') AND a.ID NOT IN ('".$IndexProduct."') AND a.Status='1' ORDER BY a.C_DATE DESC";
  $cmd_file=mysqli_query($link_db,$str_file);
  while ($data_file=mysqli_fetch_row($cmd_file)) {
    if($tmpFnum[$data_file[0]]==$data_file[0]){

    }else{
      $tmpFnum[$data_file[0]]=$data_file[0];
      $i++;
    } 
  }
}
$num+=$i;

$str_quote="SELECT a.ID, a.QT_ID, a.Version, a.C_DATE FROM partner_projects_client a LEFT JOIN (SELECT QT_ID, max(version) as version FROM partner_projects_client) AS b ON a.Version=b.Version";
$str_quote.=" WHERE a.ID NOT IN ('".$IndexQuote."') AND a.ToUser='".$UserID."' AND Approval_Y='1' ORDER BY a.C_DATE DESC LIMIT 5";
$cmd_quote=mysqli_query($link_db,$str_quote);
$data=mysqli_num_rows($cmd_quote);
$num+=$data;

?>
<script>
function logout(){
  var kind="logout";
  var url = "loginProcess";
  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
    kind : kind
  },
  success: function(message){
    if(message == "success"){
      document.location.href="/";
    }else{
      alert(message);
      exit;
    }
  }
  }); 
}
</script>
<!-- fixed-top-->
<nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-dark bg-primary navbar-shadow navbar-brand-center">
  <div class="navbar-wrapper">
    <div class="navbar-header">
      <ul class="nav navbar-nav flex-row">
        <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
        <li class="nav-item"><a class="navbar-brand" href="FEdashboard"><img class=""  src="images/mitac-logo.png">
          <h3 class="brand-text"></h3></a></li>
          <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
        </ul>
      </div>
      <div class="navbar-container content">
        <div class="collapse navbar-collapse" id="navbar-mobile">
          <ul class="nav navbar-nav mr-auto float-left">
            <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu">         </i></a></li>

          </ul>
          <ul class="nav navbar-nav float-right">  



           <!--notifications-->

           <li class="dropdown dropdown-notification nav-item" style="margin-top:12px"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-bell"></i><span class="badge badge-pill badge-default badge-danger badge-default badge-up"><?=$num;?></span></a>
            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
              <li class="dropdown-menu-header">
                <h6 class="dropdown-header m-0"><span class="grey darken-2">Notifications</span></h6><span class="notification-tag badge badge-default badge-danger float-right m-0"><?=$num;?> New</span>
              </li>
              <li class="scrollable-container media-list w-100">
                <?php
                if($FirstLogin=="1"){
                ?>
                <a href="FEpassword@<?=$ID?>">
                  <div class="media">
                    <div class="media-left align-self-center"><i class="fa fa-handshake-o cyan"></i></div>
                    <div class="media-body">
                      <button type="button" class="close" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                      <h6 class="media-heading ">Welcome!</h6>
                      <p class="notification-text font-small-3 text-muted" style="color:#000" >Hi <?=$userName?>, welcome to join Tyan partners' family! Please change your password first to protect your account.</p>

                    </div>
                  </div>
                </a>
                <?php
                }
                
                //announcement
                $str_ann="SELECT ID, Title, ReleaseTo, Schedule, Message, Status, C_DATE FROM partner_announcement WHERE ID NOT IN ('".$IndexAnn."') AND Status='1' AND (ReleaseTo='ALL' OR ReleaseTo LIKE '%".$CompanyName."%') ORDER BY C_DATE DESC LIMIT 5";
                $cmd_ann=mysqli_query($link_db,$str_ann);
                while($data_ann=mysqli_fetch_row($cmd_ann)){
                ?>
                <a href="javascript:void(0)">
                  <div class="media">
                    <div class="media-left align-self-center"><i class="fa fa-bullhorn"></i></div>
                    <div class="media-body">
                      <button type="button" class="close" aria-label="Close" onclick="cancelCard('ann','<?=$data_ann[0]?>')">
                        <span aria-hidden="true">×</span>
                      </button>
                      <h6 class="media-heading cyan darken-3"><?=$data_ann[6]?></h6>
                      <p class="notification-text font-small-3 text-muted"><?=$data_ann[1]?></p>
                    </div>
                  </div>
                </a>
                <?php
                }
                //announcement end

                // File 
                $tmpFile="";
                $strSKU="SELECT ID FROM partner_myproducts WHERE CompanyID='".$CompanyID."'";
                $cmdSKU=mysqli_query($link_db,$strSKU);
                while ($dataSKU=mysqli_fetch_row($cmdSKU)){
                  $str_file="SELECT a.ID, a.Name, a.FileDate, a.Status, c.FileType, a.ToWho, a.Description, a.FormatSize FROM partner_files a INNER JOIN partner_files_type c ON a.FileType=c.ID";
                  $str_file.=" WHERE (a.ToWho='1' OR a.ToWho LIKE '%".$dataSKU[0].",%') AND a.Status='1' AND a.ID NOT IN ('".$IndexProduct."') ORDER BY a.C_DATE DESC LIMIT 5";
                  $cmd_file=mysqli_query($link_db,$str_file);
                  while ($data_file=mysqli_fetch_row($cmd_file)) {
                    if($tmpFile[$data_file[0]]==$data_file[0]){
                    }else{
                      $tmpFile[$data_file[0]]=$data_file[0];
                      if($data_file[5]==1){
                        $url="FEmarketplace";
                      }else{
                        $url="FEmyproducts";
                      }
                      ?>
                      <div class="media">
                        <div class="media-left align-self-center"><i class="ft-download-cloud "></i></div>
                        <div class="media-body">
                          <button type="button" class="close" aria-label="Close" onclick="cancelCard('file','<?=$data_file[0]?>')">
                            <span aria-hidden="true">×</span>
                          </button>
                          <a href="<?=$url?>">
                          <h6 class="media-heading cyan darken-3"><?=$data_file[2]?></h6>
                          <p class="notification-text font-small-3 text-muted">(<?=$data_file[4]?>) <?=$data_file[1]?> just released. </p>
                          </a>
                        </div>
                      </div>
                      <?php
                    }
                  }
                }
                // File end
                
                // Quote
                /*$tmpQID="";
                $str_quote="SELECT a.ID, a.QT_ID, a.Version, a.C_DATE FROM partner_projects_client a LEFT JOIN (SELECT QT_ID, max(version) as version FROM partner_projects_client) AS b ON a.Version=b.Version";
                $str_quote.=" WHERE a.ID NOT IN ('".$IndexQuote."') AND ToUser='".$ID."' AND Approval_Y='1' ORDER BY a.C_DATE DESC LIMIT 5";
                $cmd_quote=mysqli_query($link_db,$str_quote);
                while ($data_quote=mysqli_fetch_row($cmd_quote)) {*/
                ?>
               <!--  <a href="FEmyquotation">
                  <div class="media">
                    <div class="media-left align-self-center"><i class="fa fa-usd"></i></div>
                    <div class="media-body">
                      <button type="button" class="close" aria-label="Close" onclick="cancelCard('quote','<?//=$data_quote[0]?>')">
                        <span aria-hidden="true">×</span>
                      </button>
                      <h6 class="media-heading cyan darken-3"><?//=$data_quote[3]?></h6>
                      <p class="notification-text font-small-3 text-muted">[<?//=$data_quote[1]?>] just updated. </p>
                    </div>
                  </div>
                </a> -->
                <?php
               // }
                // Quote end
                ?>
              </li>
            </ul>
          </li>
          <!--end notifications-->

          <!--user-->
          <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"><span class="avatar avatar-online"><img src="app-assets/images/user.png" ><i></i></span><span class="user-name"><?=$userName?></span></a>
            <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="FEpassword@<?=$UserID?>"><i class="ft-lock"></i> Change Password</a><!-- <a class="dropdown-item" href="faq.html"><i class="ft-help-circle"></i> FAQ</a> -->
              <div class="dropdown-divider"></div><a class="dropdown-item" href="#" onclick="logout()"><i class="ft-log-out"></i> Logout</a>
            </div>
          </li>
          <!--end user-->	
        </ul>
      </div>
    </div>
  </div>
</nav>
<!-- ////////////////////////////////////////////////////////////////////////////-->