<?php
header("X-Frame-Options: DENY");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://www.tyan.com");
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

?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<title>BACKEND - FAQs - MiTAC Partner Zone</title>
<link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
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


<div class="app-content content">
      <div class="content-wrapper">
	  
	  <div class="content-header row">
          <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">MiTAC Partner Zone</h3>
            <div class="row breadcrumbs-top d-inline-block">
              <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                  
                  <li class="breadcrumb-item active">FAQs
                  </li>
                </ol>
              </div>
            </div>
          </div>
          
        </div>
        <div class="content-body">
		
		
		<div class="row">
		<div class="col-12 mt-1">
		
		
		
		
		
		<h2 class="purple">Dashboard</h2>
			<div id="accordionWrap1-1" role="tablist" aria-multiselectable="true">
			<div class="card collapse-icon accordion-icon-rotate">
					<div id="heading1-1"  class="card-header">
						<a data-toggle="collapse" data-parent="#accordionWrap1-1" href="#accordion1-1" aria-expanded="false" aria-controls="accordion1-1" class="card-title lead collapsed purple accent-4">Pine Chart – Status for Leads - Conversion Rate</a>
					</div>
					<div id="accordion1-1" role="tabpanel" aria-labelledby="heading1-1" class="collapse" aria-expanded="false" >
						<div class="card-content">
							<div class="card-body">
								<h4>Conversion % calculation: </h4>
 Total amount of verified leads x 100 / Total amount of leads for all statuses (Processing + Pending + Verified + Invalid)

							</div>
						</div>
					</div>
					<div id="heading1-2"  class="card-header">
						<a data-toggle="collapse" data-parent="#accordionWrap1-1" href="#accordion1-2" aria-expanded="false" aria-controls="accordion1-2" class="card-title lead collapsed  purple accent-4">Pine Chart – Status for Projects - Conversion Rate</a>
					</div>
					<div id="accordion1-2" role="tabpanel" aria-labelledby="heading1-2" class="collapse" aria-expanded="false">
						<div class="card-content">
							<div class="card-body">
								<h4>Conversion % calculation: </h4>
 Total amount of confirmed projects x 100 / Total amount of projects for all statuses (Contact + RFP/RFQ + POC + Confirmed + Dropped)
							</div>
						</div>
					</div>
					
					
				</div>
				</div>
				
				<p>&nbsp;</p>

		
		
		
		
		
			<h2 class="purple">Registration / Leads Mgt</h2>
			<div id="accordionWrap1" role="tablist" aria-multiselectable="true">
			<div class="card collapse-icon accordion-icon-rotate">
					<div id="heading1"  class="card-header">
						<a data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion1" aria-expanded="false" aria-controls="accordion1" class="card-title lead collapsed purple accent-4">User flow for the registration</a>
					</div>
					<div id="accordion1" role="tabpanel" aria-labelledby="heading1" class="collapse" aria-expanded="false" >
						<div class="card-content">
							<div class="card-body">
								<img src="/partner-backend/images/leads-flow.png" class="img-fluid" alt="User Flow">
							</div>
						</div>
					</div>
					<div id="heading2"  class="card-header">
						<a data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion2" aria-expanded="false" aria-controls="accordion2" class="card-title lead collapsed  purple accent-4">The client can't register and got this message – "This email is existed".</a>
					</div>
					<div id="accordion2" role="tabpanel" aria-labelledby="heading2" class="collapse" aria-expanded="false">
						<div class="card-content">
							<div class="card-body">
							
							
							
							

<ul>					
<li>1.	Please get the registration email from the client. </li>
<li>2.	Go to <span class="blue accent-4 text-bold-600">"Leads Mgt"</span> and search this email.</li>
<li>3.	Check the status of this email's lead. <ul>
<li>If it's <strong>not "Verified" status</strong>, please check the request of the client to decide if he/she is qualified to be a member. (Update the status to "Verified" if he/she is qualified, an email notification with login info of Partner Zone will be sent to the client automatically.)</li>
<li>If it's "Verified" status: <ul>
<li>A.	Go to <span class="blue accent-4 text-bold-600">"Client Accounts Mgt"</span> and search this email's client account.</li>
<li>B.	Click the <span class="blue accent-4 text-bold-600">"Details"</span> button to enter the client account details page. Find this email and click <span class="blue accent-4 text-bold-600">"Send Password"</span> button. The system will send an email notification with the login password of Partner Zone to the client automatically. </li>
</ul>
</li>
</ul>
</li>
</ul>

<br><br>
<p>If you can't find the client in the "Leads Mgt", please send the registration email to website team. 
(Only "Admin" or "Super Admin" account can view/check all clients.)
</p>

							</div>
						</div>
					</div>
					
					<div id="heading3"  class="card-header">
						<a data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion3" aria-expanded="false" aria-controls="accordion1" class="card-title lead collapsed purple accent-4">What should I do when receiving leads' email notifications?</a>
					</div>
					<div id="accordion3" role="tabpanel" aria-labelledby="heading3" class="collapse" aria-expanded="false" >
						<div class="card-content">
							<div class="card-body">
<p class="text-bold-600 font-medium-3 blue-grey">For the dispatcher ("Admin" role required ):</p>
<ul>
<li>1.  Go to <span class="blue accent-4 text-bold-600">“Client Accounts Mgt”</span> and find the client/company</li>
<li>2.	Assign it to the responsible sales</li>
</ul><br /><br/>
<p class="text-bold-600 font-medium-3 blue-grey">For the responsible sales:</p><ul>
<li>1.	Contact with this client within 3 days</li>
<li>2.	Go to <span class="blue accent-4 text-bold-600">“Leads Mgt”</span> and find the lead<br />
Update its status to: <ul>
<li>Verified – if the client is qualified to be the member</li>
<li>Invalid – if the client is not qualified to be the member</li>
<li>Pending – if you need more time to communicate with the client</li>
</ul></li></ul>

<p class="red">
The "Verified" lead will be added to your projects automatically. Go to <span class="blue accent-4 text-bold-600">"Project Mgt"</span> and find it to proceed its online quotation. <br />The "Verified" lead is unable to change its status again. <br />Leads with no any actions will be updated to “Invalid” status automatically after 30 days.</p>

							</div>
						</div>
					</div>
					
					
					<!--<div id="heading4"  class="card-header">
						<a data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion4" aria-expanded="false" aria-controls="accordion1" class="card-title lead collapsed purple accent-4">Can I change the responsible sales for the lead?</a>
					</div>
					<div id="accordion4" role="tabpanel" aria-labelledby="heading4" class="collapse" aria-expanded="false" >
						<div class="card-content">
							<div class="card-body">
								Yes, you can. Go to <span class="blue accent-4 text-bold-600">“Leads Mgt”</span> and find the lead you want to change its responsible sales. <span class="blue accent-4 text-bold-600">Click its “Assigned Sales”</span> and select the new responsible sales from the drop-down list with notes added if you want to on the popup window. Email notification will be sent to the assigned sales automatically after clicking <span class="blue accent-4 text-bold-600">“SAVE”</span> button.
							</div>
						</div>
					</div>-->
					
					
					
					
					
					
					
					
					
					
				</div>
				</div>
				
				<p>&nbsp;</p>


			<h2 class="purple">Client Accounts Mgt</h2>
			<div id="accordionWrap2" role="tablist" aria-multiselectable="true">
			<div class="card collapse-icon accordion-icon-rotate">
					<div id="heading11"  class="card-header">
						<a data-toggle="collapse" data-parent="#accordionWrap2" href="#accordion11" aria-expanded="false" aria-controls="accordion11" class="card-title lead collapsed  purple accent-4">Can I help my clients to register Partner Zone?</a>
					</div>
					<div id="accordion11" role="tabpanel" aria-labelledby="heading11" class="collapse" aria-expanded="false">
						<div class="card-content">
							<div class="card-body">
								Yes. <ul>
<li>1.	Go to <span class="blue accent-4 text-bold-600">“Client Accounts Mgt”</span></li>
<li>2.	Click <span class="blue accent-4 text-bold-600">“+ Add a client account”</span> button</li>
<li>3.	Enter the client's information including Company Name, Company Address, Member Name, Email Address, Title and Contact Tel and click <span class="blue accent-4 text-bold-600">“Save”</span> button to complete.</li>

</ul><p class="red">
** Please note you can only add the clients that you are responsible to. </p>


							</div>
						</div>
					</div>
					<div id="heading12"  class="card-header">
						<a data-toggle="collapse" data-parent="#accordionWrap2" href="#accordion12" aria-expanded="false" aria-controls="accordion12" class="card-title lead collapsed  purple accent-4">Can I add members for my clients?</a>
					</div>
					<div id="accordion12" role="tabpanel" aria-labelledby="heading12" class="collapse" aria-expanded="false">
						<div class="card-content">
							<div class="card-body">Yes. <ul>
<li>1.	Go to <span class="blue accent-4 text-bold-600">“Client Accounts Mgt”</span></li>
<li>2.	Search the company you want to add its members.</li>
<li>3.	<span class="blue accent-4 text-bold-600">Click its members' number with the pen icon</span> or click <span class="blue accent-4 text-bold-600">“Details”</span> button.</li>
<li>4.	Click <span class="blue accent-4 text-bold-600">“+ Add”</span> button on the top of members list table.</li>
<li>5.	Enter the Contact Name, Email Address, Title and Contact Tel. One company only allows max. 6 members. </li>  
<li>6.	Click <span class="blue accent-4 text-bold-600">“Save”</span> button to complete.</li><br /><br />
<p class="text-bold-600">After adding the member, you can click its <span class="blue accent-4 text-bold-600">“Send Password”</span> button to send the login password of Partner Zone.
You can also click <span class="blue accent-4 text-bold-600">“Edit”</span> button of this member to edit the information, or click <span class="blue accent-4 text-bold-600">“Delete”</span> button to delete this member.</p>
</ul>							</div>
						</div>
					</div>
					
					
					<div id="heading4"  class="card-header">
						<a data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion4" aria-expanded="false" aria-controls="accordion1" class="card-title lead collapsed purple accent-4">Can I transfer the client to other Tyan Sales?</a>
					</div>
					<div id="accordion4" role="tabpanel" aria-labelledby="heading4" class="collapse" aria-expanded="false" >
						<div class="card-content">
							<div class="card-body">							
							Yes; only for user account with <strong>Admin</strong> or <strong>Super Admin</strong> role<ul> 
<li>1.	Go to <span class="blue accent-4 text-bold-600">“Client Accounts Mgt”</span></li>
<li>2.	Search the company you want to transfer its responsible sales.</li>
<li>3.	Click its responsible sales.</li>
<li>4.	Select the sales you want to transfer and click <span class="blue accent-4 text-bold-600">“Save”</span> button on the popup window.</li>
</ul> 
							</div>
						</div>
					</div>
					
					
					
					
					
				</div>
				</div>


<p>&nbsp;</p>


			<h2 class="purple">Project Mgt</h2>
			<div id="accordionWrap3" role="tablist" aria-multiselectable="true">
			<div class="card collapse-icon accordion-icon-rotate">
					<div id="heading10"  class="card-header">
						<a data-toggle="collapse" data-parent="#accordionWrap3" href="#accordion10" aria-expanded="false" aria-controls="accordion10" class="card-title lead collapsed  purple accent-4">What’s the “Projects Mgt” for? Where are my projects from?</a>
					</div>
					<div id="accordion10" role="tabpanel" aria-labelledby="heading10" class="collapse" aria-expanded="false">
						<div class="card-content">
							<div class="card-body">
								You can manage your quotations in the <span class="blue accent-4 text-bold-600">“Projects Mgt”</span>. <br />
								Your projects are from (1) verified leads, (2) created by your own<!--, (3) past sales data imported (TBD)-->.
<br /><br />								
								
<p class="text-bold-600 font-medium-3 blue-grey">(1)	For the verified lead:</p><ul>
<li>A.	Click its <span class="blue accent-4 text-bold-600">“Edit”</span> button -> Enter the page where you can edit/add data for the quotation and then click <span class="blue accent-4 text-bold-600">“Save”</span> button to complete it.</li>
<li>B.	Click its <span class="blue accent-4 text-bold-600">“ID”</span> to preview your quotation. If anything needs to update again, just go back #A until you finalize it.</li>
<li>C.	Click <span class="blue accent-4 text-bold-600">“Send”</span> button to get approval from your manager.<br />
<img src="/partner-backend/images/project-list.png" class="img-fluid" alt="project list">

</li>
</ul> 
<p class="text-bold-600 font-medium-3 blue-grey">(2)	Add a new quotation directly:</p><ul>
<li>A.	Click <span class="blue accent-4 text-bold-600">“+Add”</span> button to create a quotation </li>
<li>B.	Enter the page where you can add data for the quotation and then click <span class="blue accent-4 text-bold-600">“Save”</span> button to complete it.</li>
<li>C.	Your new quotation will be listed on the table. Click its <span class="blue accent-4 text-bold-600">“ID”</span> to preview your quotation. If anything needs to update again, just click its <span class="blue accent-4 text-bold-600">“Edit”</span> button to edit it again until you finalize it.</li>
<li>D.	Click <span class="blue accent-4 text-bold-600">“Send”</span> button to get approval from your manager.</li>
</ul>

<p class="text-bold-600">
The manager will receive an email notification with a link for approving this quotation. Click this link will direct to the detailed quotation with the <span class="blue accent-4 text-bold-600">“YES”</span> and <span class="blue accent-4 text-bold-600">“NO”</span> approval buttons. After the manager clicking <span class="blue accent-4 text-bold-600">“YES”</span> approval button, the client will receive an email notification automatically for checking this quotation from Tyan Partner Zone.
</p>
								
								
								
								
								
								
							</div>
						</div>
					</div>
					<div id="heading13"  class="card-header">
						<a data-toggle="collapse" data-parent="#accordionWrap3" href="#accordion13" aria-expanded="false" aria-controls="accordion13" class="card-title lead collapsed  purple accent-4">I can't find the item in the drop down products list while adding / editing the quotation. What should I do? </a>
					</div>
					<div id="accordion13" role="tabpanel" aria-labelledby="heading13" class="collapse" aria-expanded="false">
						<div class="card-content">
							<div class="card-body">
							The product you want to add for your quotation is not in the Products DB of Partner Zone.<br />
								You need go to <span class="blue accent-4 text-bold-600">“Products Mgt -> Products”</span> to add it first. After adding it, go back to the adding / editing page, then you will find it listed on the drop down menu.  

							</div>
						</div>
					</div>
					
					<div id="heading14"  class="card-header">
						<a data-toggle="collapse" data-parent="#accordionWrap3" href="#accordion14" aria-expanded="false" aria-controls="accordion14" class="card-title lead collapsed  purple accent-4">Can I set the order of items on the quotation?</a>
					</div>
					<div id="accordion14" role="tabpanel" aria-labelledby="heading14" class="collapse" aria-expanded="false">
						<div class="card-content">
							<div class="card-body">
							YES. On the Adding / Editing Quotation Pages, you can assign the numbers for ordering the items of this quotation.<br /><br />
							
							<img src="/partner-backend/images/item-order.png" class="img-fluid" alt="">

							</div>
						</div>
					</div>
					
					
				</div>
				</div>

<p>&nbsp;</p>


			<h2 class="purple">Products Mgt</h2>
			<div id="accordionWrap4" role="tablist" aria-multiselectable="true">
			<div class="card collapse-icon accordion-icon-rotate">
					<div id="heading15"  class="card-header">
						<a data-toggle="collapse" data-parent="#accordionWrap4" href="#accordion15" aria-expanded="false" aria-controls="accordion15" class="card-title lead collapsed  purple accent-4">What's “Products Mgt” for?</a>
					</div>
					<div id="accordion15" role="tabpanel" aria-labelledby="heading15" class="collapse" aria-expanded="false">
						<div class="card-content">
							<div class="card-body">
							
							2 functions for managing the products on the Partner Zone.<ul>
<li>1.	Go to <span class="blue accent-4 text-bold-600">“Products Mgt -> Products”</span>:<br />
Partner Zone's products DB is in sync with the products / Optional Parts / FRU Parts of Tyan Website. <br />
Here lists all products in Partner Zone, including motherboard, barebones, optional parts, FRU parts, etc. When editing or adding the items/products of your quotation (Projects Mgt -> Add / Edit Quotation) which is not listed on the dropdown menu, you need add them from here in advance. <div style="font-weight:bold; color:#c00">In order to keep the data accurate and consistent, please note the added products from here can't be deleted or edited.</div>
</li>
<li>2.	Go to <span class="blue accent-4 text-bold-600">“Products Mgt -> My Products”</span>:<br />
Here you can add the products for your clients. The added products will be associated with the “My Products” of your clients in the Partner Zone. If you want to release files to a specific product of your client, you need to make sure this product is listed here for your client first. For the <strong>“Confirmed”</strong> project, its products will be listed here for your client automatically.
</li>
</ul>							
							
							
							</div>
						</div>
					</div>
					<div id="heading16"  class="card-header">
						<a data-toggle="collapse" data-parent="#accordionWrap4" href="#accordion16" aria-expanded="false" aria-controls="accordion16" class="card-title lead collapsed  purple accent-4">How will the products be associated with the client/company?</a>
					</div>
					<div id="accordion16" role="tabpanel" aria-labelledby="heading16" class="collapse" aria-expanded="false">
						<div class="card-content">
							<div class="card-body"><ul>

<li>(1)	Confirmed projects:<br />
The status of your projects/quotations turns to <strong>“Confirmed”</strong>, the products listed on the quotations will be associated with the projects' client automatically. Please note only <strong>“Motherboard”</strong> and <strong>“Barebones”</strong> products will be associated. </li>
<li>(2)	Added manually from backend:<ul>
<li>1.	Go to <span class="blue accent-4 text-bold-600">“Products Mgt -> My Products”</span>.</li>
<li>2.	Select your client / company and click <span class="blue accent-4 text-bold-600">“Search”</span> button</li>
<li>3.	Check if the product is listed for this client. If <strong>NOT</strong>, click <span class="blue accent-4 text-bold-600">“Add”</span> button to add it for your client. Please note the added product must be listd in the <span class="blue accent-4 text-bold-600">“Products Mgt -> Products”</span> in advance. </li></ul>
</li>


</ul>
							</div>
						</div>
					</div>
					
					
				</div>
				</div>


<p>&nbsp;</p>


			<h2 class="purple">Contents Mgt ("Super Admin" or "Admin" role required)</h2>
			<div id="accordionWrap5" role="tablist" aria-multiselectable="true">
			<div class="card collapse-icon accordion-icon-rotate">
					<div id="heading17"  class="card-header">
						<a data-toggle="collapse" data-parent="#accordionWrap5" href="#accordion17" aria-expanded="false" aria-controls="accordion17" class="card-title lead collapsed  purple accent-4">Contents Mgt -> Announcement</a>
					</div>
					<div id="accordion17" role="tabpanel" aria-labelledby="heading17" class="collapse" aria-expanded="false">
						<div class="card-content">
							<div class="card-body"><ul>
<li>The settings are for the front-end <strong>“Noticeboard”</strong> Card.</li>
<li>Setting schedule for announcement should be <strong>“Offline”</strong> status.</li>
</ul>
							</div>
						</div>
					</div>
					<div id="heading18"  class="card-header">
						<a data-toggle="collapse" data-parent="#accordionWrap5" href="#accordion18" aria-expanded="false" aria-controls="accordion18" class="card-title lead collapsed  purple accent-4">Contents Mgt -> Files</a>
					</div>
					<div id="accordion18" role="tabpanel" aria-labelledby="heading18" class="collapse" aria-expanded="false">
						<div class="card-content">
							<div class="card-body">
								Release file to the clients:<ul>
<li>To <strong>“Marketplace”</strong>: files will be shown on the front-end <strong>“Marketplace”</strong> section.</li>
<li>To <strong>the selected's products</strong>: files will be shown on the front-end <strong>“My Products”</strong> section.</li>

</ul>

							</div>
						</div>
					</div>
					
					
				</div>
				</div>



<p>&nbsp;</p>


			<h2 class="purple">User Accounts Mgt  ("Super Admin" or "Admin" role required)</h2>
			<div id="accordionWrap7" role="tablist" aria-multiselectable="true">
			<div class="card collapse-icon accordion-icon-rotate">
					<div id="heading19"  class="card-header">
						<a data-toggle="collapse" data-parent="#accordionWrap7" href="#accordion19" aria-expanded="false" aria-controls="accordion19" class="card-title lead collapsed  purple accent-4">User account for dispatching leads</a>
					</div>
					<div id="accordion19" role="tabpanel" aria-labelledby="heading19" class="collapse" aria-expanded="false">
						<div class="card-content">
							<div class="card-body">
								The role of the user account is responsible for dispatching the received leads should be <strong>“Admin”</strong>.
							</div>
						</div>
					</div>
					<div id="heading20"  class="card-header">
						<a data-toggle="collapse" data-parent="#accordionWrap7" href="#accordion20" aria-expanded="false" aria-controls="accordion20" class="card-title lead collapsed  purple accent-4">User account for quotation approvals</a>
					</div>
					<div id="accordion20" role="tabpanel" aria-labelledby="heading20" class="collapse" aria-expanded="false">
						<div class="card-content">
							<div class="card-body">
							The user accounts which allow to approve the quotations need to check <span class="blue accent-4 text-bold-600">“Enable Quotation Approval”</span> and their role should be <strong>“Admin”</strong> as well.
							</div>
						</div>
					</div>
					
					
				</div>
				</div>









			
			
		</div>
		</div>
		
		
		
		
		
		</div>
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  </div>
</div>














<!--footer-->
<?php
include("footer.php");
?>
<!--end footer--> 











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
