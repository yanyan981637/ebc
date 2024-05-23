<?php
$URL=$_SERVER['REQUEST_URI'];
$userName=$_SESSION['user'];
$ID=$_SESSION['ID'];
$Role=$_SESSION['role'];
if($Role!="SA"){
  $str_count="SELECT COUNT(*) FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID WHERE b.STATUS='Processing'";
}else{
  $str_count="SELECT COUNT(*) FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID WHERE b.STATUS='Processing' AND b.SalesID='".$ID."'";
}
$list1 =mysqli_query($link_db,$str_count);
list($public_count) = mysqli_fetch_row($list1);
?>
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
  <div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

      <li class=" navigation-header">
      </li>

      <li class=" nav-item <?php if(strpos($URL,'BEdashboard') !== false){ echo 'active'; }?>"><a href="BEdashboard"><i class="icon-home"></i><span class="menu-title" >Dashboard</span></a>
      </li>
      <li class=" nav-item <?php if(strpos($URL,'BEleads') !== false){ echo 'active'; }?>"><a href="BEleads"><i class="icon-graph"></i><span class="menu-title" >Leads Mgt</span><span class="badge badge-warning badge-pill float-right mr-2" style="color:#000"><?=$public_count?></span></a>
      </li>
      <li class=" nav-item <?php if(strpos($URL,'BEclient_accounts') !== false){ echo 'active'; }?>"><a href="BEclient_accounts"><i class="ft-user-plus"></i><span class="menu-title" >Client Accounts Mgt</span></a>
      </li>
      <li class=" nav-item <?php if(strpos($URL,'BEprojects') !== false){ echo 'active'; }?>"><a href="BEprojects"><i class="fa fa-usd"></i><span class="menu-title" >&nbsp;&nbsp;Projects Mgt</span></a>
      </li>
      <li class=" nav-item <?php if(strpos($URL,'BEproducts') !== false || strpos($URL,'BEmyproducts') !== false){ echo 'active'; }?>"><a href="#"><i class="ft-server"></i><span class="menu-title" >Products Mgt</span></a>
        <ul class="menu-content">
          <li>
            <a class="menu-item" href="BEproducts">Products</a>
          </li>
          <li>
            <a class="menu-item" href="BEmyproducts">My Products</a>
          </li>
        </ul>
      </li>
      <?php
      if($Role=="SUAD" || $Role=="AD"){
      ?>
      <li class=" nav-item <?php if(strpos($URL,'BEcontents') !== false || strpos($URL,'BEfilesMgt') !== false || strpos($URL,'BEgroupsMgt') !== false){ echo 'active'; }?>"><a href="#"><i class="ft-download-cloud"></i><span class="menu-title" >Contents Mgt</span></a>
        <ul class="menu-content">
          <li>
            <a class="menu-item" href="BEcontents">Announcements</a>
          </li>
          <li>
            <a class="menu-item" href="BEfilesMgt">Files</a>
          </li>
          <li>
            <a class="menu-item" href="BEgroupsMgt">Groups</a>
          </li>
        </ul>
      </li>
      <li class=" nav-item <?php if(strpos($URL,'BEreport') !== false){ echo 'active'; }?>"><a href="BEreport"><i class="icon-pie-chart"></i><span class="menu-title" >Reports Mgt</span></a>
      </li>
      <li class=" nav-item <?php if(strpos($URL,'BEuser_accounts') !== false){ echo 'active'; }?>"><a href="BEuser_accounts"><i class="fa fa-users"></i><span class="menu-title" >User Accounts Mgt</span></a>
      </li>
      <?php
      }
      if($Role=="SUAD"){
      ?>
      <!-- <li class=" nav-item <?php //if(strpos($URL,'BEemail_mapping') !== false){ echo 'active'; }?>"><a href="#"><i class="fa fa-cogs"></i><span class="menu-title" >Settings</span></a>
        <ul class="menu-content">
          <li><a class="menu-item" href="BEemail_mapping">Email Mapping</a></li>
        </ul>
      </li> -->
      <?php
      }
      ?>
    </ul>
  </div>
</div>