<?php
$userName=$_SESSION['user'];
$ID=$_SESSION['ID'];
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
      document.location.href="login";
    }else{
      alert(message);
      exit;
    }
  }
  }); 
}
</script>
<nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-dark navbar-shadow">
		<div class="navbar-wrapper">
			<div class="navbar-header">
				<ul class="nav navbar-nav flex-row">
					<li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>

					<li class="nav-item"><a class="navbar-brand" href="#"><h3 class="brand-text">MiTAC Partner Zone</h3></a></li>


					<li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
				</ul>
			</div>
			<div class="navbar-container content">
				<div class="collapse navbar-collapse" id="navbar-mobile">
					<ul class="nav navbar-nav mr-auto float-left">
						<li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
					</ul>
					<ul class="nav navbar-nav float-right">



						<!--user-->
						<li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"><span class="avatar "><img src="app-assets/images/user.png" ><i></i></span><span class="user-name"><?=$userName;?></span></a>
							<div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="BEpassword@<?=$ID?>"><i class="ft-lock"></i> Change Password</a>
								<a class="dropdown-item" href="FAQ"><i class="ft-help-circle"></i>FAQ</a>
								<div class="dropdown-divider"></div><a class="dropdown-item" href="#" onclick="logout()"><i class="ft-log-out"></i> Logout</a>
							</div>
						</li>
						<!--end user-->			  
					</ul>
				</div>
			</div>
		</div>
	</nav>