<?php
header("X-Frame-Options: DENY");
//header("Content-Security-Policy-Report-Only: default-src *; img-src https:; frame-src 'none'; report-uri http://www.tyan.com");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://ipc.mitacmdt.com");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

error_reporting(0);

if (strpos(trim(getenv('REQUEST_URI')), "script") != '' || strpos(trim(getenv('REQUEST_URI')), ".php") != '') {
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: /404.htm");
	exit;
}
session_start();
require "./config.php";
$link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
function dowith_sql($str)
{
	$str = str_replace("and", "", $str);
	$str = str_replace("execute", "", $str);
	$str = str_replace("update", "", $str);
	$str = str_replace("count", "", $str);
	$str = str_replace("chr", "", $str);
	$str = str_replace("mid", "", $str);
	$str = str_replace("master", "", $str);
	$str = str_replace("truncate", "", $str);
	$str = str_replace("char", "", $str);
	$str = str_replace("declare", "", $str);
	$str = str_replace("select", "", $str);
	$str = str_replace("create", "", $str);
	$str = str_replace("delete", "", $str);
	$str = str_replace("insert", "", $str);
	$str = str_replace("'", "&#39;", $str);
	$str = str_replace('"', "&quot;", $str);
	//$str = str_replace(".","",$str);
	//$str = str_replace("or","",$str);
	$str = str_replace("=", "", $str);
	$str = str_replace("?", "", $str);
	$str = str_replace("%", "", $str);
	$str = str_replace("0x02BC", "", $str);
	//$str = str_replace("%20","",$str);
	$str = str_replace("<script>", "", $str);
	$str = str_replace("</script>", "", $str);
	$str = str_replace("<style>", "", $str);
	$str = str_replace("</style>", "", $str);
	$str = str_replace("<img>", "", $str);
	$str = str_replace("</img>", "", $str);
	$str = str_replace("<a>", "", $str);
	$str = str_replace("</a>", "", $str);
	return $str;
}
if (isset($_COOKIE['status'])) {
	//$s_cookie="";
} else {
	$s_cookie = $_COOKIE['status'];
}
// login in
if (isset($_GET["RFQsku"])) {
	$RFQsku = "";
} else {
	$RFQsku = dowith_sql($_COOKIE['RFQsku']);
	$RFQsku = filter_var($RFQsku);
}
$arr_sku = explode(",", $RFQsku);
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name='author' content='MiTAC Digital Technology'>
	<meta name="company" content="MiTAC Digital Technology">
	<meta name="description" content="">
	<meta property="og:type" content="website" />
	<meta property="og:description" content="" />
	<meta property="og:title" content="MiTAC Digital Technology | Request for Quotation" />
	<link rel="shortcut icon" href="images/ico/favicon.ico">
	<!-- Stylesheets
	============================================= -->
	<link rel="stylesheet" href="css1/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="css1/style.css" type="text/css" />
	<link rel="stylesheet" href="css1/swiper.css" type="text/css" />
	<link rel="stylesheet" href="css1/dark.css" type="text/css" />
	<link rel="stylesheet" href="css1/font-icons.css" type="text/css" />
	<link rel="stylesheet" href="css1/animate.css" type="text/css" />
	<link rel="stylesheet" href="css1/magnific-popup.css" type="text/css" />
	<link rel="stylesheet" href="css1/custom.css" type="text/css" />
	<link rel="stylesheet" href="css1/quote.css" type="text/css" />
	<link rel="stylesheet" href="css1/stylesheet1.css" type="text/css" /> 

	<script src="https://www.google.com/recaptcha/api.js" async defer></script>

	<script src="js1/jquery.js"></script>
	<!-- Document Title
	============================================= -->
	<title>MiTAC Digital Technology | Request for Quotation</title>
	<?php
	//************ google analytics ************
	if ($s_cookie != 2) {
		include_once("analyticstracking.php");
	}
	?>
</head>

<body class="stretched">
	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">
		<!--Header logo & global top menu-->
		<?php
		include("top1.htm");
		?>
		<!--end Header logo & global top menu-->
		<section id="content">
			<div class="content-wrap">
				<div class="container">
					<div class="row col-mb-30">
						<!--product list-->
						<div class="col-lg-6">
							<h2><i class="icon-line-dollar-sign"></i>&nbsp;Request for Quotation (RFQ)</h2>
							<table id="tablePR" class="table cart mb-5">
								<thead>
									<tr>
										<th class="cart-product-remove">&nbsp;</th>
										<th class="cart-product-thumbnail">&nbsp;</th>
										<th class="cart-product-name">&nbsp;</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$i = 0;
									$arr_pType = array();
									if ($RFQsku != "") {
										foreach ($arr_sku as $key => $value) {
											if ($value != "") {
												$str = "SELECT ProductFile, ProductTypeID, MODELCODE FROM contents_product_skus WHERE SKU='" . $value . "'";
												$cmd = mysqli_query($link_db, $str);
												$data = mysqli_fetch_row($cmd);
												$ProductFile = $data[0];
												$pType = $data[1];
												array_push($arr_pType, $data[1]);
												$model = $data[2];
												$img = explode(",", $ProductFile);
												if ($pType == "46") { //IndustrialPanelPC
													$prod_imgurl = "./images/product/PanelPc/";
													$url = "/IndustrialPanelPC";
												} else if ($pType == "47") { //EmbeddedSystem
													$prod_imgurl = "./images/product/Embedded/";
													$url = "/EmbeddedSystem";
												} else if ($pType == "48") { //IndustrialMotherboard
													$prod_imgurl = "./images/product/IndustriaMB/";
													$url = "/IndustrialMotherboard";
												} else if ($pType == "49") { //OCPserver
													$prod_imgurl = "./images/product/OCPserver/";
													$url = "/OCPserver";
												} else if ($pType == "50") { //OCPMezz
													$prod_imgurl = "./images/product/OCPMezz/";
													$url = "/OCPMezz";
												} else if ($pType == "51") { //JBODJBOF
													$prod_imgurl = "./images/product/JBODJBOF/";
													$url = "/JBODJBOF";
												} else if ($pType == "52") { //OCPRack
													$prod_imgurl = "./images/product/OCPrack/";
													$url = "/OCPRack";
												} else if ($pType == "53") { //POS
													$prod_imgurl = "./images/product/POS/";
													$url = "/POS";
												} else if ($pType == "54") { //5GEdgeComputing
													$prod_imgurl = "./images/product/5G/";
													$url = "/5GEdgeComputing";
												}
									?>
												<tr id="item_<?= $i ?>" class="cart_item">
													<td class="cart-product-remove">
														<a href="#" class="remove" title="Remove this item" onclick="removeRFQ('<?= $value ?>','<?= $i ?>')"><i class="icon-trash2" style="font-size:2rem"></i></a>
													</td>
													<td class="cart-product-thumbnail">
														<a href="<?= $url ?>_<?= $model ?>_<?= $value ?>"><img src="<?= $prod_imgurl . $img[0] ?>" alt="<?= $value ?>" style="border:none"></a>
													</td>
													<td class="cart-product-name" style="font-size:2rem">
														<a href="<?= $url ?>_<?= $model ?>_<?= $value ?>"><?= $value ?></a>
													</td>
												</tr>
									<?php
											}
											$i++;
										}
									}
									?>
									<!--no product msg-->
									<?php
									if ($RFQsku == "") {
									?>
										<tr class="cart_item">
											<td class="cart-product-name" colspan="3" style="font-size:1.5rem">
												There is no product!
											</td>
										</tr>
									<?php
									}
									?>
									<!--end msg-->
								</tbody>
							</table>
							<input id="pr_num" type="hidden" value="<?= $i ?>">
							<?php
							if ($login_IN == "1" && $RFQsku != "") {
							?>
								<!--confirm quote button-->
								<a href="#" class="button button-3d button-xlarge button-rounded button-aqua" data-bs-toggle="modal" data-bs-target=".confirm-quote">Send the request for quotation</a>
								<!--end confirm quote button-->
								<div id="myModal1" class="modal fade confirm-quote" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title" id="myModalLabel"></h4>
												<button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-hidden="true"></button>
											</div>
											<div class="modal-body">
												<div style="">
													<p class="mb-3">Are you sure you want to send your request?</p>
													<button id="RFQ_OK" type="button" class="btn btn-primary">Yes, send it.</button>
													<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php
							}
							?>

							<!-- loading 覆蓋層 -->
							<div id="loadingOverlay">
								<div class="lds-dual-ring"></div>
							</div>

							<div id="myModal2" class="modal fade confirm-quote" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myModalLabel"></h4>
											<button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-hidden="true"></button>
										</div>
										<div class="modal-body">
											<div class="center" style="padding: 50px;">
												<h3>Submit Successfully!</h3>
												<p class="mb-0">Thank you for your interest in MiTAC Digital Technology.
													We will contact with you ASAP.
												</p>
											</div>
											<div class="section center m-0" style="padding: 30px;">
												<a href="/" class="button">Close</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--end product list-->
						<!--register & login-->
						<div class="col-lg-6" style="padding:5%">
							<?php
							if ($login_IN != "1") {
								//--registration button
								if ($login_IN != "1" && $RFQsku != "") {
							?>
									<div><a href="#" class="button button-desc button-3d button-rounded button-aqua center" style="width:520px" data-bs-toggle="modal" data-bs-target=".registration-modal-lg">Fill out the form<span>Leave your information to request the quotation!</span></a></div>
								<?php
								}
								?>
								<br />
								<!--login button-->
								<!-- <div>
									<a href="#modal-register" data-lightbox="inline" class="button button-desc button-3d button-rounded button-blue center" style="width:520px">Have an account for Partner Zone?<span>Log in to your Partner Zone Account.</span></a>
								</div> -->
								<!--end login button-->
								<br />
							<?php
							}
							?>
							<div id="RFQmodal" class="modal fade registration-modal-lg" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
								<div class="modal-dialog modal-lg modal-dialog-scrollable">
									<div class="modal-content">
										<div class="modal-header">
											<h2 class="modal-title center" id="myModalLabel">Request for Quotation (RFQ)</h2>
											<button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-hidden="true"></button>
										</div>
										<div class="modal-body">
											<form id="form1">
												<h4 style="color:#004898">Please fill out the form below. All fields are required.
													We will contact you soon after receiving your request.</h4>
												<div class="form-group">
													<label>Name:</label>
													<input id="username" name="username" type="text" class="form-control required" placeholder="">
												</div>
												<div class="form-group">
													<label>Company Name:</label>
													<input id="companyname" name="companyname" type="text" class="form-control required" placeholder="">
												</div>
												<div class="form-group">
													<label>Email address:</label>
													<input id="email" name="email" type="email" class="form-control required" aria-describedby="emailHelp" placeholder="">
													<div id="err_Email" name="err_Email" class="alert alert-danger mb-1" role="alert" style="display:none">Please enter a valid email.</div>
													<div id="err_Email1" name="err_Email1" class="alert alert-danger mb-1" role="alert" style="display:none">You have sent the request to us before. Please log in Partner Zone or <a href="/EN/contact/" />contact us</a>.</div>
												</div>
												<div class="form-group">
													<label>Tel: </label>
													<input id="tel" name="tel" type="text" class="form-control required" placeholder="">
													<span style="color:#535353;font-style: italic; font-size:0.8rem">(Ex. +1-5106518868 or +1-5106518868 ext.00000)</span>
												</div>
												<div class="form-group">
													<label>Your residing region:</label>
													<select id="countryCode" name="countryCode" class="form-select">
														<option selected value="">Select...</option>
														<option value="NA">North America</option>
														<option value="SA">Central / South America</option>
														<option value="EUR">Europe</option>
														<option value="ME">Middle East / Africa</option>
														<option value="ASIA">Asia</option>
														<option value="Oceania">Oceania</option>
													</select>
													<div id="err_countryCode" name="err_countryCode" class="alert alert-danger mb-1" role="alert" style="display:none">Please select your residing region.</div>
												</div>
												<div class="form-group">
													<label>Message:</label>
													<textarea id="re_message" name="re_message" class="form-control" rows="3"></textarea>
												</div>
												<?php
												if (in_array("46", $arr_pType) || in_array("47", $arr_pType) || in_array("48", $arr_pType) || in_array("53", $arr_pType)) {
												?>
													<div class="form-check">
														<input type="checkbox" class="form-check-input" id="S_News" checked>
														<label class="form-check-label" for="">Subscribe me to newsletter</label>
													</div>
												<?php
												}
												?>

												<!-- Google reCAPTCHA v2 核取方塊 -->
                                                <div class="form-group" style="margin:15px 0;">
                                                    <div class="g-recaptcha" data-sitekey="<?php echo $google_recaptcha_web_key; ?>"></div>
                                                </div>
                                                <!-- End Google reCAPTCHA -->

												
												<!-- Google Invisible reCAPTCHA v2 -->
												<!-- <div class="form-group" style="margin:15px 0;">
                                                    <div class="g-recaptcha"
                                                         data-sitekey="<?php echo $google_recaptcha_web_key; ?>"
                                                         data-size="invisible"
                                                         data-callback="onSubmit">
                                                    </div>
                                                </div> -->
                                                <!-- End Google Invisible reCAPTCHA -->

												<!--recaptcha-->
												<!-- <div class="row" style="margin:5px 0px 15px 0px; font-size:1rem">
													<div id="vals-img" style="width: 100px;">
														<img src="/captcha@1" id="rand-img1" border="0" width="150" style="cursor: pointer; cursor: hand;">
													</div>
													<a href="" id="refresh1" onclick="return false">Refresh</a><br>
													<input type="text" id="Checknum" name="Checknum" class="form-control not-dark required" placeholder="Type the text from image">
												</div> -->
												<!--end recaptcha-->
												<div class="form-check">
													<input type="checkbox" class="form-check-input" id="terms">
													<label class="form-check-label" for="">I acknowledge and confirm that I have read, understood and agree to MiTAC's <a href="/EN/legal/terms_of_use/" target="TOS">Terms of Use</a>, <a href="/EN/legal/privacy_policy" target="TOS">Privacy Policy</a> and <a href="/EN/legal/cookie_policy" target="TOS">Cookie Policy</a>.</label>
												</div>
												<button id="register" type="button" class="button button-3d button-black nomargin" disabled>Submit</button>
											</form>
										</div>
									</div>
								</div>
							</div>
							<!--end registration button-->
							<input id="RFQpage" type="hidden" value="Y">
						</div>
						<!--end register & login-->
					</div>
				</div>
			</div>
			<!-- FOOTER -->
			<?php
			include("foot1.htm");
			?>
			<!-- FOOTER end -->
	</div><!-- #wrapper end -->
	<!-- Go To Top
============================================= -->
	<div id="gotoTop" class="icon-line-arrow-up"></div>
	<!-- JavaScripts
============================================= -->
	<script src="js1/plugins.min.js"></script>
	<!-- Footer Scripts
============================================= -->
	<script src="js1/functions.js"></script>
	<!-- ADD-ONS JS FILES -->
	<script src="js1/top.js"></script>
	<script>
		// 取得按鈕和 loading 層的 DOM 物件
		const overlay = document.getElementById('loadingOverlay');

        // 當 modal 隱藏後，轉到首頁
        $("#myModal2").on('hidden.bs.modal', function () {
            window.location.href = '/';
        });

		$("#RFQ_OK").click(function() {
			var num = $("#pr_num").val();
			var kind = "";
			var url = "PartnerZone/RFQprocess";
			$.ajax({
				type: "post",
				url: url,
				dataType: "html",
				data: {
					kind: kind
				},
				success: function(message) {
					if (message == "success") {
						document.cookie = "RFQsku=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
						$('#myModal1').modal('hide');
						$("#myModal2").modal('show');
						for (var i = 0; i <= num; i++) {
							var tr = "#item_" + j;
							$(tr).remove();
						};
						$("#tablePR>tbody").append("<tr class=cart_item><td class=cart-product-name colspan=3 style=font-size:1.5rem>There is no product!</td></tr>");
						exit;
					} else {
						exit;
					}
				}
			});
		})
		
		// $(function() {
		// 	$("#register").click(function() {
		// 		if ($("#username").val() == "") {
		// 			eval("document.form1['username'].focus()");
		// 			exit;
		// 		}
		// 		if ($("#companyname").val() == "") {
		// 			eval("document.form1['companyname'].focus()");
		// 			exit;
		// 		}
		// 		if ($("#email").val() != "") {
		// 			var search_str = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
		// 			var mail_val = $("#email").val();
		// 			if (search_str.test(mail_val)) {
		// 				$("#err_Email").hide();
		// 			} else {
		// 				$("#err_Email").show();
		// 				eval("document.form1['email'].focus()");
		// 				exit;
		// 			}
		// 		} else if ($("#email").val() == "") {
		// 			eval("document.form1['email'].focus()");
		// 			$("#err_Email").show();
		// 			exit;
		// 		}
		// 		if ($("#countryCode").val() == "") {
		// 			eval("document.form1['countryCode'].focus()");
		// 			exit;
		// 		}
		// 		if ($("#tel").val() == "") {
		// 			eval("document.form1['tel'].focus()");
		// 			exit;
		// 		}
		// 		var username = $("#username").val();
		// 		var companyname = $("#companyname").val();
		// 		var email = $("#email").val();
		// 		var countryCode = $("#countryCode").val();
		// 		var S_News = $("#S_News").is(":checked");
		// 		//newsletter
		// 		if (S_News == true) {
		// 			var url = "/subscription";
		// 			var mail = $("#email").val();
		// 			var fd = new FormData();
		// 			fd.append("mail", mail);
		// 			$.ajax({
		// 				type: "post",
		// 				url: url,
		// 				dataType: "html",
		// 				data: fd,
		// 				cache: false,
		// 				contentType: false,
		// 				processData: false,
		// 				success: function(data) {
		// 					if (data == "refresh") {} else {}
		// 				}
		// 			});
		// 		}
		// 		//newsletter end
		// 		var tel = $("#tel").val();
		// 		var Msg = $("#re_message").val();
		// 		var Checknum = $("#Checknum").val();
		// 		var kind = "register";
		// 		var url = "PartnerZone/regProcess";
		// 		$.ajax({
		// 			type: "post",
		// 			url: url,
		// 			dataType: "html",
		// 			data: {
		// 				username: username,
		// 				companyname: companyname,
		// 				email: email,
		// 				countryCode: countryCode,
		// 				tel: tel,
		// 				Msg: Msg,
		// 				Checknum: Checknum,
		// 				kind: kind
		// 			},
		// 			success: function(message) {
		// 				if (message == "email") {
		// 					$('#err_Email1').show();
		// 					exit;
		// 				} else if (message == "success") {
		// 					$("#RFQmodal").modal('hide');
		// 					document.cookie = "RFQsku=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
		// 					$("#myModal2").modal('show');
		// 				} else {
		// 					alert(message);
		// 				}
		// 			}
		// 		});
		// 	});
		// });

		// 修改 #register 按鈕點擊事件：先進行欄位驗證，再檢查 reCAPTCHA 是否完成，完成後以 Ajax 送出表單
        $(function() {
            $("#register").click(function() {
				// 檢查必填欄位是否有填寫
                if ($("#username").val() == "") {
                    $("#username").focus();
                    return;
                }
                if ($("#companyname").val() == "") {
                    $("#companyname").focus();
                    return;
                }
                if ($("#email").val() != "") {
                    var search_str = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
                    var mail_val = $("#email").val();
                    if (!search_str.test(mail_val)) {
                        $("#err_Email").show();
                        $("#email").focus();
                        return;
                    } else {
                        $("#err_Email").hide();
                    }
                } else {
                    $("#email").focus();
                    $("#err_Email").show();
                    return;
                }
                if ($("#tel").val() == "") {
                    $("#tel").focus();
                    return;
                }
                if ($("#countryCode").val() == "") {
                    $("#countryCode").focus();
                    return;
                }
                // 檢查 reCAPTCHA 是否有回傳值（使用者是否已勾選）
                if ($("#g-recaptcha-response").val() == "") {
                    alert("Please complete the reCAPTCHA verification.");
                    return;
                }
                // 收集欄位資料，並以 Ajax 送出
                var username = $("#username").val();
                var companyname = $("#companyname").val();
                var email = $("#email").val();
                var countryCode = $("#countryCode").val();
                var tel = $("#tel").val();
                var Msg = $("#re_message").val();
                var kind = "register";
                var url = "PartnerZone/regProcess";

				$("#register").attr("disabled", "disabled");

				// 顯示 loading 特效覆蓋層
				overlay.style.display = 'flex';

                // 若 newsletter 被勾選，另行發送訂閱請求（保留原有 newsletter 程式碼）
                if ($("#S_News").is(":checked")) {
                    var url_sub = "/subscription";
                    var mail = $("#email").val();
                    var fd = new FormData();
                    fd.append("mail", mail);
                    $.ajax({
                        type: "post",
                        url: url_sub,
                        dataType: "html",
                        data: fd,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(data) { }
                    });
                }
                $.ajax({
                    type: "post",
                    url: url,
                    dataType: "html",
                    data: {
                        username: username,
                        companyname: companyname,
                        email: email,
                        countryCode: countryCode,
                        tel: tel,
                        Msg: Msg,
                        kind: kind
                    },
                    success: function(message) {
                        if (message == "email") {
                            $('#err_Email1').show();
                            return;
                        } else if (message == "success") {
                            $("#RFQmodal").modal('hide');
                            document.cookie = "RFQsku=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
							// 關閉 loading 覆蓋層
							overlay.style.display = 'none';
                            $("#myModal2").modal('show');
                        } else {
                            alert(message);
                        }
                    }
                });
            });
        });

		// // 修改 #register 按鈕點擊事件：先進行欄位驗證，驗證通過後呼叫 recaptcha 執行
        // $(function() {
        //     $("#register").click(function() {
        //         if ($("#username").val() == "") {
        //             $("#username").focus();
        //             return;
        //         }
        //         if ($("#companyname").val() == "") {
        //             $("#companyname").focus();
        //             return;
        //         }
        //         if ($("#email").val() != "") {
        //             var search_str = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
        //             var mail_val = $("#email").val();
        //             if (!search_str.test(mail_val)) {
        //                 $("#err_Email").show();
        //                 $("#email").focus();
        //                 return;
        //             } else {
        //                 $("#err_Email").hide();
        //             }
        //         } else {
        //             $("#email").focus();
        //             $("#err_Email").show();
        //             return;
        //         }
        //         if ($("#countryCode").val() == "") {
        //             $("#countryCode").focus();
        //             return;
        //         }
        //         if ($("#tel").val() == "") {
        //             $("#tel").focus();
        //             return;
        //         }
        //         // 若欄位驗證通過，執行 Invisible reCAPTCHA 驗證
        //         grecaptcha.execute();
        //     });
        // });

        // // reCAPTCHA 驗證成功後的回呼函數
        // function onSubmit(token) {
        //     // 取得表單欄位值，並透過 Ajax 將資料送出
        //     var username = $("#username").val();
        //     var companyname = $("#companyname").val();
        //     var email = $("#email").val();
        //     var countryCode = $("#countryCode").val();
        //     var tel = $("#tel").val();
        //     var Msg = $("#re_message").val();
        //     var kind = "register";
        //     var url = "PartnerZone/regProcess";

        //     // 若 newsletter 被勾選，另行發送訂閱請求（原有 newsletter 程式碼保留）
        //     if ($("#S_News").is(":checked")) {
        //         var url_sub = "/subscription";
        //         var mail = $("#email").val();
        //         var fd = new FormData();
        //         fd.append("mail", mail);
        //         $.ajax({
        //             type: "post",
        //             url: url_sub,
        //             dataType: "html",
        //             data: fd,
        //             cache: false,
        //             contentType: false,
        //             processData: false,
        //             success: function(data) { }
        //         });
        //     }
        //     // 以 Ajax 送出註冊資料
        //     $.ajax({
        //         type: "post",
        //         url: url,
        //         dataType: "html",
        //         data: {
        //             username: username,
        //             companyname: companyname,
        //             email: email,
        //             countryCode: countryCode,
        //             tel: tel,
        //             Msg: Msg,
        //             kind: kind
        //         },
        //         success: function(message) {
        //             if (message == "email") {
        //                 $('#err_Email1').show();
        //                 return;
        //             } else if (message == "success") {
        //                 $("#RFQmodal").modal('hide');
        //                 document.cookie = "RFQsku=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
        //                 $("#myModal2").modal('show');
        //             } else {
        //                 alert(message);
        //             }
        //         }
        //     });
        // }


		//captcha
		$(function() {
			$("#refresh1").click(function() {
				var obj = document.getElementById("rand-img1");
				var i = Math.floor((Math.random() * 10) + 1);;
				obj.src = null;
				var url = "/captcha@" + i;
				$.ajax({
					type: "post",
					url: url,
					dataType: "html",
					success: function(message) {
						if (message == "susses") {
							alert(message);
							//document.location.href='../SupportCenter';
						} else {
							obj.src = "/captcha@" + i;
						}
					}
				});
			});
		})
		//captcha end
		$(function() {
			$("#terms").click(function() {
				var checked = $(this).prop("checked");
				if (checked == true) {
					$("#register").attr("disabled", false);
				} else {
					$("#register").attr("disabled", "disabled");
				}
			})
		})
	</script>
</body>

</html>
<?php
mysqli_Close($link_db);
?>