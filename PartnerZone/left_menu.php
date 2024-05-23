<?php
$URL=$_SERVER['REQUEST_URI'];

?>
<!--left menu-->
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
  <div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

      <li class=" navigation-header">
      </li>

      <li class=" nav-item <?php if(strpos($URL,'FEdashboard') !== false){ echo 'active'; }?>"><a href="FEdashboard"><i class="icon-home"></i><span class="menu-title" >Dashboard</span></a>
      </li>
      <li class=" nav-item <?php if(strpos($URL,'FEmyprofile') !== false){ echo 'active'; }?>"><a href="FEmyprofile"><i class="ft-user-plus"></i><span class="menu-title" >My Profile</span></a>
      </li>
      <!-- <li class=" nav-item <?php //if(strpos($URL,'FEmyquotation') !== false){ echo 'active'; }?>"><a href="FEmyquotation"><i class="fa fa-usd"></i><span class="menu-title" >&nbsp;&nbsp;My Quotation</span></a>
      </li> -->
      <li class=" nav-item <?php if(strpos($URL,'FEmyproducts') !== false){ echo 'active'; }?>"><a href="FEmyproducts"><i class="ft-server"></i><span class="menu-title" >My Products</span></a>
      </li>
      <li class=" nav-item <?php if(strpos($URL,'FEmarketplace') !== false){ echo 'active'; }?>"><a href="FEmarketplace"><i class="ft-download-cloud"></i><span class="menu-title" >Marketplace</span></a>
      </li>

    </ul>
  </div>
</div>

<!--end left menu-->	