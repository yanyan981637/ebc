<?php
header("X-Frame-Options: DENY");
//header("Content-Security-Policy-Report-Only: default-src *; img-src https:; frame-src 'none'; report-uri http://www.tyan.com");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://www.mitacmct.com/");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

if(strpos(trim(getenv('REQUEST_URI')),'?')!='' || strpos(trim(getenv('REQUEST_URI')),'?')===0 || strpos(trim(getenv('REQUEST_URI')),"'")!='' || strpos(trim(getenv('REQUEST_URI')),"'")===0 || strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
  echo "<script language='javascript'>self.location='/index.html'</script>";
  exit;
}
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">


<title>MiTAC Partner Zone - Registration</title>


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
<link rel="stylesheet" type="text/css" href="app-assets/fonts/feather/fonts/style.min.css" >	
<!-- END ROBUST CSS-->
<!-- BEGIN Page Level CSS-->
<!--<link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.css">-->
<link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-overlay-menu.css">
<!-- END Page Level CSS-->
<!-- BEGIN Custom CSS-->
<link rel="stylesheet" type="text/css" href="assets/css/style.css">
<link rel="stylesheet" type="text/css" href="assets/css/register.css">
<!-- END Custom CSS-->
</head>
<body class="vertical-layout vertical-content-menu 1-column   menu-expanded blank-page blank-page" data-open="click" data-menu="vertical-content-menu" data-col="1-column">
<!-- ////////////////////////////////////////////////////////////////////////////-->
<div class="app-content content">
	<div class="content-wrapper">
		<div class="content-header row">
		</div>
		<div class="content-body">
			<section class="">
				<div class="col-12 d-flex align-items-center justify-content-center">
					<div class="col-md-12 col-12 box-shadow-2 p-0" >
						<div class="card border-grey border-lighten-3 px-2 py-2 m-0">
							<div class="card-header border-0">
								<div class="card-title text-center">
									<div ><a href="https://www.tyan.com" /><img src="app-assets/images/logo/tyan-logo-register.png" /></a></div>
									<h1>MiTAC Partner Zone</h1>
									<p>Thank you for your interest in Tyan Computer. <br />
										Our sales representative will contact with you shortly via telephone or email to check your requirements before becoming a Tyan partner. </p>
										<div style="margin:1% 0">&nbsp;</div>

										<div class="text-center"><a href="https://www.tyan.com/" /><button type="button"  class="btn btn-lg btn-outline-light btn-primary ">Go Back to Tyan Website</button></a></div>

									</div>
									
								</div>
								<div class="card-content">	
									<div style="margin:2% 0">&nbsp;</div>
									<div class="copyrightText text-center">Copyright&copy; 2021-2022 MiTAC Computing Technology Corporation (MiTAC Group). All Rights Reserved. <br />Please use the latest version of Firefox or Chrome to view this site.<br />
										<a href="https://www.tyan.com/EN/legal/terms_of_use/" target="tos" />Terms of Use</a>&nbsp;·&nbsp;
										<a href="https://www.tyan.com/EN/legal/privacy_policy/" target="tos" />Privacy Policy</a>&nbsp;·&nbsp;
										<a href="https://www.tyan.com/EN/legal/cookie_policy/" target="tos" />Cookie Policy</a>
									</div>
									
									
								</div>
							</div>
							
							
							
							
						</div>
						
						
						
					</div>
				</section>
			</div>
		</div>
	</div>
	<!-- ////////////////////////////////////////////////////////////////////////////-->
	
	
	
	



	
	<!-- Repeated Company name msg Modal -->
	<div class="modal fade text-left" id="repeated-account-msg-2" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<label class="modal-title text-text-bold-600" ><h1 class="red"><i class="ft-alert-circle"></i></h1></label>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				
				
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							This email has already been registered. Please log in MiTAC Partner Zone.
							
						</div>
					</div>								 
				</div>
				<div class="modal-footer">
					<a href="index.html" ><input type="submit" class="btn btn-info btn-lg" value="LOGIN"></a>							
				</div>
				
			</div>
		</div>
	</div>
	<!-- end Repeated Company name msg Modal -->
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	



<!-- BEGIN VENDOR JS-->
<script src="app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<script src="app-assets/vendors/js/ui/jquery.sticky.js"></script>
<script src="app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
<script src="app-assets/vendors/js/ui/headroom.min.js"></script>
<script src="app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
<script src="app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="app-assets/js/core/app-menu.js"></script>
<script src="app-assets/js/core/app.js"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="app-assets/js/scripts/ui/breadcrumbs-with-stats.js"></script>
<script src="app-assets/js/scripts/forms/form-login-register.js"></script>
<script src="app-assets/js/scripts/forms/select/form-select2.js"></script>
<!-- END PAGE LEVEL JS-->
</body>
</html>