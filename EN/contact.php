<?php
header("X-Frame-Options: DENY");
//header("Content-Security-Policy-Report-Only: default-src *; img-src https:; frame-src 'none'; report-uri http://www.tyan.com");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://ipc.mitacmdt.com/");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
if (strpos(trim(getenv('REQUEST_URI')), '?') != '' || strpos(trim(getenv('REQUEST_URI')), '?') === 0 || strpos(trim(getenv('REQUEST_URI')), "'") != '' || strpos(trim(getenv('REQUEST_URI')), "'") === 0 || strpos(trim(getenv('REQUEST_URI')), "script") != '' || strpos(trim(getenv('REQUEST_URI')), ".php") != '') {
    echo "<script language='javascript'>self.location='/404.htm'</script>";
    exit;
}
require "../config.php";
error_reporting(0);
$link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
if (isset($_GET["status"])) {
    //$s_cookie="";
} else {
    $s_cookie = $_COOKIE['status'];
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name='author' content='MiTAC Digital Technology'>
    <meta name="company" content="MiTAC Digital Technology">
    <meta name="description" content="Leave your message for embedded, panel PC, kiosks, motherboards, OCP, or 5G enquiry">
    <meta property="og:type" content="website" />
    <meta property="og:description" content="Leave your message for embedded, panel PC, kiosks, motherboards, OCP, or 5G enquiry" />
    <meta property="og:title" content="Contact Us | MiTAC Digital Technology" />
    <link rel="shortcut icon" href="/images/ico/favicon.ico">
    <!-- Stylesheets
    ============================================= -->
    <link rel="stylesheet" href="/css1/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="/css1/style.css" type="text/css" />
    <link rel="stylesheet" href="/css1/swiper.css" type="text/css" />
    <link rel="stylesheet" href="/css1/dark.css" type="text/css" />
    <link rel="stylesheet" href="/css1/font-icons.css" type="text/css" />
    <link rel="stylesheet" href="/css1/animate.css" type="text/css" />
    <link rel="stylesheet" href="/css1/magnific-popup.css" type="text/css" />
    <link rel="stylesheet" href="/css1/custom.css" type="text/css" />
    <link rel="stylesheet" href="/css1/home.css " type="text/css" />
    <script src="/js1/jquery.js"></script>
    <!-- Document Title
    ============================================= -->
    <title>Contact Us | MiTAC Digital Technology</title>
    <?php
    //************ google analytics ************
    if ($s_cookie != 2) {
        include_once("../analyticstracking.php");
    }
    ?>
</head>

<body class="stretched">
    <!-- Document Wrapper
    ============================================= -->
    <div id="wrapper" class="clearfix">
        <!--Header logo & global top menu-->
        <?php
        include("../top1.htm");
        ?>
        <!--end Header logo & global top menu-->
        <!-- Content
        ============================================= -->
        <section id="content">
            <div class="content-wrap">
                <div class="container clearfix">
                    <div class="row align-items-stretch col-mb-50 mb-0">
                        <!-- Contact Form
                        ============================================= -->
                        <div class="col-lg-12">
                            <div class="center">
                                <h1>Contact MiTAC Digital Technology</h1>
                            </div>
                            <div class="divider  divider-rounded divider-center"><i class="icon-pencil"></i></div>
                            <div style="color:#2688f6; font-size:1.5rem;" class="center bottommargin">Please leave your message in English. All fields are required.</div>
                            <div class="form-widget">
                                <div class="form-result"></div>
                                <form class="mb-0" id="form_contact" name="form_contact" method="post" action="">
                                    <div class="form-process">
                                        <div class="css3-spinner">
                                            <div class="css3-spinner-scaler"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="template-contactform-name">Name:</label>
                                            <input type="text" name="f_Name" id="f_Name" value="" class="sm-form-control" />
                                            <div style="margin:5px; color:#c00; display:none" id="err_Name">Required field!</div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="template-contactform-companyname">Company Name:</label>
                                            <input type="text" name="f_cName" id="f_cName" value="" class="sm-form-control required" />
                                            <div style="margin:5px; color:#c00; display:none" id="err_cName">Required field!</div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="template-contactform-email">Email:</label>
                                            <input type="email" name="f_Email" id="f_Email" value="" class="required email sm-form-control" />
                                            <div style="margin:5px; color:#c00; display:none" id="err_Email1">Invalid e-mail address!</div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="template-contactform-phone">Phone: <span style="font-style: italic; color:#434343; font-weight:normal">(Ex. +1-5106518868 or +1-5106518868 ext.00000)</span></label>
                                            <input type="text" name="f_Phone" id="f_Phone" value="" class="required sm-form-control" />
                                            <div style="margin:5px; color:#c00; display:none" id="err_Phone">Required field!</div>
                                        </div>
                                        <div class="w-100"></div>
                                        <div class="col-md-4 form-group">
                                            <label for="template-contactform-residing-region">Your residing region:</label>
                                            <select id="nlang" name="nlang" class="required sm-form-control">
                                                <option selected value="">Select...</option>
                                                <option value="NA">North America</option>
                                                <option value="SA">Central / South America</option>
                                                <option value="EUR">Europe</option>
                                                <option value="ME">Middle East / Africa</option>
                                                <option value="ASIA">Asia</option>
                                            </select>
                                            <div class="alert alert-danger" id="err_nlang" style="display:none">Please select your residing region.</div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="template-contactform-Product-Type">Product Type:</label>
                                            <select id="PType" name="PType" class="required sm-form-control">
                                                <option selected value="">Select...</option>
                                                <option value="MB">Motherboard</option>
                                                <option value="Embedded">Embedded System</option>
                                                <option value="PanelPC">Panel PC</option>
                                                <option value="TB">Tablet/Kiosk</option>
                                            </select>
                                            <div id="newsletter" class="col-12 mt-4" style="display:none">
                                                <input type="checkbox" class="form-check-input" id="check_news">
                                                <label class="form-check-label" for="exampleCheck1">Subscribe me to newsletter</label>
                                            </div>
                                            <div class="alert alert-danger" id="err_PType" style="display:none">Please select your product type.</div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="template-contactform-Request-Type">Request Type:</label>
                                            <select id="s_Type" name="s_Type" class="required sm-form-control">
                                                <option selected value="">Select...</option>
                                                <option value="enquiry">Business Enquiry</option>
                                                <option value="TS">Technical Support</option>
                                                <option value="other">Others</option>
                                            </select>
                                            <div class="alert alert-danger" id="err_Type" style="display:none">Please select your request type.</div>
                                        </div>
                                        <div class="w-100"></div>
                                        <div class="col-12 form-group">
                                            <label for="template-contactform-message">Message:</label>
                                            <textarea class="required sm-form-control" id="f_Message" name="f_Message" rows="6" cols="30"></textarea>
                                        </div>
                                        <div class="col-12 form-group d-none">
                                            <input type="text" id="template-contactform-botcheck" name="template-contactform-botcheck" value="" class="sm-form-control" />
                                        </div>
                                        <div class="col-12 form-group">
                                            <label for="">Verify the code:</label>
                                            <div id="vals-img" style="width: 200px;">
                                                <img src="/captcha@1" id="rand-img1" border="0" width="200" style="cursor: pointer; cursor: hand;">
                                            </div>
                                            <a href="#" id="refresh1">Refresh</a><br>
                                            <input type="text" name="checknum" id="checknum" size="12" maxlength="12">
                                        </div>
                                        <div class="col-12 mt-4 mb-4">
                                            <div class="alert alert-info">Clicking <strong>"SUBMIT"</strong>, you agree to the
                                                <a href="https://www.mitacmdt.com/en/terms-of-use.php" target="terms" />Terms of Use</a>,
                                                <a href="https://www.mitacmdt.com/en/privacy-policy.php" target="terms" />Privacy Policy</a>, and
                                                <a href="https://www.mitacmdt.com/en/cookie-pocily.php" target="terms" />Cookie Policy</a>.
                                            </div>
                                        </div>
                                        <div class="col-12 form-group">
                                            <button id="add" name="add" type="button" id="submit-button" tabindex="5" value="Submit" class="button button-3d m-0">Submit</button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="prefix" value="template-contactform-">
                                </form>
                            </div>
                        </div><!-- Contact Form End -->
                    </div>
                </div>
            </div>
        </section><!-- #content end -->
        <!-- FOOTER -->
        <?php
        include("../foot1.htm");
        ?>
        <!-- FOOTER end -->
    </div><!-- #wrapper end -->
    <!-- Go To Top
    ============================================= -->
    <div id="gotoTop" class="icon-line-arrow-up"></div>
    <!-- JavaScripts
    ============================================= -->
    <script src="/js1/plugins.min.js"></script>
    <!-- Footer Scripts
    ============================================= -->
    <script src="/js1/functions.js"></script>
    <!-- ADD-ONS JS FILES -->
    <script src="/js1/top.js"></script>
    <script>
        function gtag_report_conversion(url) {
            var callback = function() {
                if (typeof(url) != 'undefined') {
                    window.location = url;
                }
            };
            gtag('event', 'conversion', {
                'send_to': '384108551/F1xHCNPf74kCEIeQlLcB',
                'event_callback': callback
            });
            return false;
        }
        $("#PType").change(function() {
            if ($("#PType").val() == "Embedded") {
                $("#newsletter").show();
                $("#check_news").prop('checked', true);
            } else {
                $("#newsletter").hide();
                $("#check_news").prop('checked', false);
            }
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $("#add").click(function() {
                if ($("#f_Name").val() == "") {
                    $("#f_Name").focus();
                    $("#err_Name").show();
                    $("#err_cName").hide();
                    $("#err_Email1").hide();
                    $("#err_Phone").hide();
                    $("#err_nlang").hide();
                    $("#err_PType").hide();
                    $("#err_Type").hide();
                    $("#err_Message").hide();
                    exit;
                } else if ($("#f_cName").val() == "") {
                    $("#err_Name").hide();
                    $("#err_cName").show();
                    $("#f_cName").focus();
                    $("#err_Email1").hide();
                    $("#err_Phone").hide();
                    $("#err_nlang").hide();
                    $("#err_PType").hide();
                    $("#err_Type").hide();
                    $("#err_Message").hide();
                    exit;
                }
                if ($("#f_Email").val() != "") {
                    var search_str = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
                    var mail_val = $("#f_Email").val();
                    if (search_str.test(mail_val)) {
                        $("#err_Email1").hide();
                    } else {
                        $("#err_Email1").show();
                        $("#f_Email").focus();
                        exit;
                    }
                } else {
                    $("#err_Name").hide();
                    $("#err_cName").hide();
                    $("#err_Email1").show();
                    $("#f_Email").focus();
                    $("#err_Phone").hide();
                    $("#err_nlang").hide();
                    $("#err_PType").hide();
                    $("#err_Type").hide();
                    $("#err_Message").hide();
                    exit;
                }
                if ($("#f_Phone").val() == "") {
                    $("#err_Name").hide();
                    $("#err_cName").hide();
                    $("#err_Email1").hide();
                    $("#err_Phone").show();
                    $("#f_Phone").focus();
                    $("#err_nlang").hide();
                    $("#err_PType").hide();
                    $("#err_Type").hide();
                    $("#err_Message").hide();
                    exit;
                } else if ($("#nlang").val() == "") {
                    $("#err_Name").hide();
                    $("#err_cName").hide();
                    $("#err_Email1").hide();
                    $("#err_Phone").hide();
                    $("#err_nlang").show();
                    $("#nlang").focus();
                    $("#err_PType").hide();
                    $("#err_Type").hide();
                    $("#err_Message").hide();
                    exit;
                } else if ($("#PType").val() == "") {
                    $("#err_Name").hide();
                    $("#err_cName").hide();
                    $("#err_Email1").hide();
                    $("#err_Phone").hide();
                    $("#err_nlang").hide();
                    $("#err_PType").show();
                    $("#PType").focus();
                    $("#err_Type").hide();
                    $("#err_Message").hide();
                    exit;
                } else if ($("#s_Type").val() == "") {
                    $("#err_Name").hide();
                    $("#err_cName").hide();
                    $("#err_Email1").hide();
                    $("#err_Phone").hide();
                    $("#err_nlang").hide();
                    $("#err_PType").hide();
                    $("#err_Type").show();
                    $("#s_Type").focus();
                    $("#err_Message").hide();
                    exit;
                } else if ($("#f_Message").val() == "") {
                    $("#err_Name").hide();
                    $("#err_cName").hide();
                    $("#err_Email1").hide();
                    $("#err_Phone").hide();
                    $("#err_nlang").hide();
                    $("#err_PType").hide();
                    $("#err_Type").hide();
                    $("#err_Message").show();
                    $("#f_Message").focus();
                    exit;
                } else {
                    if (document.getElementById("check_news").checked == true) {
                        var email = $("#f_Email").val();
                        var url = "/subscription";
                        var fd = new FormData();
                        fd.append("mail", email);
                        $.ajax({
                            type: "post",
                            url: url,
                            dataType: "html",
                            data: fd,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function(data) {}
                        })
                    } else {}
                    document.getElementById('add').disabled = true;
                    var fName = $("#f_Name").val();
                    var fCName = $("#f_cName").val();
                    var fEmail = $("#f_Email").val();
                    var fPhone = $("#f_Phone").val();
                    var nlang = $("#nlang").val();
                    var PType = $("#PType").val();
                    var s_Type = $("#s_Type").val();
                    var fMessage = $("#f_Message").val();
                    var Checknum1 = $("#checknum").val();
                    var url = "/EN/cdone";
                    var fd = new FormData();
                    fd.append("fName", fName);
                    fd.append("fCName", fCName);
                    fd.append("fEmail", fEmail);
                    fd.append("fPhone", fPhone);
                    fd.append("nlang", nlang);
                    fd.append("PType", PType);
                    fd.append("s_Type", s_Type);
                    fd.append("fMessage", fMessage);
                    fd.append("Checknum1", Checknum1);
                    $.ajax({
                        type: "post",
                        url: url,
                        //dataType: "html",
                        data: fd,
                        processData: false,
                        contentType: false,
                        cache: false,
                        success: function(message) {
                            if (message == "susses") {
                                alert('Thank you for contacting with us. We will respond to you shortly.');
                                document.location.href = '/EN/contact/';
                            } else {
                                alert(message);
                            }
                        }
                    });
                }
            })
        })
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
    </script>
</body>

</html>