<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<title>BACKEND - Projects Management - MiTAC Partner Zone</title>
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
<link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.css">
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


<!--footer-->
<?php
include("footer.php");
?>
<!--end footer--> 

<!--update  quote status Modal -->
<div class="modal fade text-left" id="quote-status" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<label class="modal-title text-text-bold-600" ><h1 id="status_title"></h1></label>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<form action="#">
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="">Select a Status:</label>
							<select id="sel_status" class="form-control" >
								<option value="Contact">Contact</option> 
								<option value="RFP">RFP</option> 
								<option value="Assessment">Assessment</option> 
								<option value="RFQ">RFQ</option> 
								<option value="Audit">Audit</option> 
								<option value="POC">POC</option> 
								<option value="Award">Award</option>
								<option value="Confirmed">Confirmed</option>
								<option value="Dropped">Dropped</option>
							</select>
						</div>
						<div class="form-group">
							<label for="">Note:</label>
							<fieldset>
								<textarea id="status_note" class="form-control" rows="3"></textarea>
							</fieldset>
						</div>
					</div>
				</div>								 
			</div>
			<div class="modal-footer">
				<input id="StatusOK" type="button" class="btn btn-info btn-lg" value="Save">								
			</div>
		</form>
	</div>
</div>
</div>
<!--end update quote status Modal -->

<!-- Quote status update log Modal -->

<div class="modal fade text-left" id="quote-status-log" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<label class="modal-title text-text-bold-600" ><h1 id="log_title"></h1></label>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12">
					<table class="table table-hover ">
						<thead class="bg-grey bg-lighten-4">
							<tr>
								<th>Update Time</th>		 		
								<th>Action</th>
								<th>Note</th>	
							</tr>
						</thead>
						<tbody id="logs_content">
							<tr>
								<td>2021-04-4 18:35:55 </td>
								<td>[ID]-v.2 Approval by Robby.Lin: <br />Y</td>
								<td></td>      	  
							</tr>
							
						</tbody>
					</table>

					
				</div>
			</div>								 
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>							
		</div>
		
	</div>
</div>
</div>

<!--end  Quote status update log Modal -->

<!--delete quote Modal -->
<div class="modal fade text-left" id="del-quote" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h1 class="red"><i class="ft-trash-2"></i><h1>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="#">
				<div id="del_title" class="modal-body">

					

				</div>

				<div class="modal-footer">
					<input id="DelOK" type="button" class="btn btn-info " value="Yes, Delete it.">
					<input type="button" class="btn btn-secondary " value="No" data-dismiss="modal" aria-label="Close">	
				</div>
			</form>
		</div>
	</div>
</div>

<!-- end delete quote Modal -->	





<!-- edit sales  Modal -->
<div class="modal fade text-left" id="edit-sales" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<label class="modal-title text-text-bold-600" ><h1 id="e_sales_title"></h1></label>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="#">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="">Select a sale:</label>
								<select id="editSales" class="form-control" >
									

								</select>
							</div>
							<div class="form-group">
								<label for="">Note:</label>
								<fieldset>
									<textarea id="sales_note" class="form-control" rows="3"></textarea>
								</fieldset>
							</div>
						</div>
					</div>								 
				</div>
				<div class="modal-footer">
					<input id="SalesOK" type="button" class="btn btn-info btn-lg" value="Save">								
				</div>
			</form>
		</div>
	</div>
</div>
<!-- end edit-sales  Modal -->	

<!-- BEGIN VENDOR JS-->


<!-- BEGIN VENDOR JS-->
<script src="app-assets/vendors/js/vendors.min.js"></script>

<!-- BEGIN PAGE VENDOR JS-->
<script src="app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="app-assets/js/core/app-menu.js"></script>
<script src="app-assets/js/core/app.js"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="app-assets/js/scripts/forms/select/form-select2.js"></script>
<!-- END PAGE LEVEL JS-->

</body>
</html>
