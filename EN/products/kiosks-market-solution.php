<?php
header("X-Frame-Options: DENY");
//header("Content-Security-Policy-Report-Only: default-src *; img-src https:; frame-src 'none'; report-uri http://www.tyan.com");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://ipc.mitacmdt.com");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

/*if(strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
header("HTTP/1.1 301 Moved Permanently");
header("Location: /404.htm");
exit;
}*/

error_reporting(0);

if(isset($_GET["status"])){
  //$s_cookie="";
}else{
  $s_cookie=$_COOKIE['status'];
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name='author' content='MiTAC Digital Technology'>
	<meta name="company" content="MiTAC Digital Technology">
	<meta name="description" content="MiTAC provides market solutions for self-checkout kiosk, hospitality kiosk, ticketing kiosk and giftcard kiosk.">
	<meta property="og:type" content="website" />
	<meta property="og:description" content="MiTAC provides market solutions for self-checkout kiosk, hospitality kiosk, ticketing kiosk and giftcard kiosk." />
	<meta property="og:title" content="Kiosks Market Solutions | MiTAC Digital Technology" />
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
	<link rel="stylesheet" href="/css1/kiosks.css" type="text/css" />

  <style>

#slider {background:  url('/products/img/KV-kiosks.jpg') no-repeat center center / cover;}
#kiosk-nav {margin-top:-6rem}
#kiosk-nav:hover {cursor: pointer; }
#kiosk-nav .k-on {background:#00428a;}
.k-on h4 {color:#fff}


 .sw-img {

        overflow: hidden;
        margin: 0 auto;
		padding:0px 2px
    }

    .sw-img img {
        width: 100%;
        transition: 0.5s all ease-in-out;
    }

    .sw-img:hover img {
        transform: scale(1.1);
    }


.color-blue {color:#0e438b}
.bg-top-line {border-top:1px solid #fff}

h4 {line-height:1.5rem; margin-top:1rem; font-weight: bold; color:#0d47a1}
.bg-dark-blue {background-color:#0D47A1; border:1px solid #0D47A1}
.bg-dark-blue h1 {color:#ffffff; padding: 1.6rem 1rem 0rem}
.white {color:#ffffff}

.neumorphic-box-40 {border-radius: 40px;
background: #ffffff;
box-shadow:  6px 6px 15px rgba(0, 0, 0, 0.2),
             -6px -6px 15px rgba(255, 255, 255, 0.8); margin:5px 5px 10px 5px}

.neumorphic-box-kv {border:0px; border-radius: 50px; padding:3rem;  background-color: rgba(0, 0, 0, 0.7); color:#ffffff; box-shadow:  10px 10px 20px rgba(104, 104, 104, 0.5),
-10px -10px 20px rgba(0, 0, 0, 0.2); backdrop-filter: blur(6px);}
.solution-bgkv-CHECKOUT {position: relative; background: url(/EN/solution/images/KIOSK-solution-bg.jpg) no-repeat center center; width:900px; height:345px}


  </style>

	<script src="/js1/jquery.js"></script>
	<!-- Document Title
	============================================= -->
	<title>Kiosks Market Solutions | MiTAC Digital Technology</title>

</head>

<body class="stretched">

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">


	<!--Header logo & global top menu-->
	<?php
  include("../../top1.htm");
	?>
	<!--end Header logo & global top menu-->





		<!-- Slider
		============================================= -->
		<section id="slider" class="slider-element">

			<div class="container mt-4 mb-6">
				<div class="row justify-content-between align-items-center">
					<div class="col-lg-6 col-md-6 dark  mb-5 mb-md-0 py-5">
						<h2 class="display-4  mt-2" style="font-weight: 600;" data-animate="backInLeft">A FULLY INTEGRATED KIOSK PROVIDER</h2>
						<p class="mb-5 lead text-white" data-animate="backInLeft">MiTAC designs, engineers, assembles, deploys and supports self-service Kiosk solutions</p>

					</div>
					<div class="col-md-6 d-flex align-self-end align-items-center align-items-lg-end col-form">

					</div>
				</div>
			</div>
		</section>


<!-- tabs -->

<div class="container mb-1"  >
<div id="kiosk-nav" class="content">
<div class="row">
    <div class="col-lg-8">
    <div  class="row justify-content-start">



	  <div class="col-lg-3 mb-4 mb-lg-0" onclick="location.href='/EN/products/standard-kiosks/#1'">
        <div class="grid-inner shadow-sm h-shadow bg-white p-3 overflow-hidden rounded-5 text-center shadow-ts">
          <div class="row justify-content-center">
          <div class="col-12" ><h4 class="h4 mb-0" >Standard Kiosks</h4></div>
          </div>
        </div>
	  </div>

    <div class="col-lg-3 mb-4 mb-lg-0" onclick="location.href='/products/custom-kiosks/#1'">
        <div class="grid-inner shadow-sm h-shadow bg-white p-3 overflow-hidden rounded-5 text-center shadow-ts">
          <div class="row justify-content-center">
          <div class="col-12" ><h4 class="h4 mb-0" >Custom Kiosks</h4></div>
          </div>
        </div>
	  </div>

	     <div class="col-lg-3 mb-4 mb-lg-0" onclick="location.href='/products/kiosks-software-solution/#1'">
        <div class="grid-inner shadow-sm h-shadow bg-white p-3 overflow-hidden rounded-5 text-center shadow-ts">
          <div class="row justify-content-center">
          <div class="col-12" ><h4 class="h4 mb-0" >Software Solutions</h4></div>
          </div>
        </div>
	  </div>

	   <div class="col-lg-3 mb-4 mb-lg-0" onclick="location.href='/products/kiosks-market-solution/#1'">
        <div  class="k-on grid-inner shadow-sm h-shadow p-3 overflow-hidden rounded-5 text-center h-shadow-none">
          <div class="row justify-content-center">
          <div class="col-12" ><h4 class="h4 mb-0" >Market Solutions</h4></div>
          </div>
        </div>
	  </div>

    </div>
    </div>
    <div class="col-lg-4">
    </div>
  </div>


</div>
</div>


<!--end  tabs -->






<a name="1"></a>
<div class="container-fluid mt-6 mb-3" >
    <div class="heading-block center">
                  <h1>Market Solutions</h1>
    </div>

</div>



	<div class="container-fluid">

	<p class="mt-3">&nbsp;</p>

	<div class="container" >


	<div class="row">
  <div class="col-md-3">
  <a href="#KSK-SELF-CHECKOUT" /><img src="/EN/solution/images/KIOSK-SELF-CHECKOUT.jpg" alt="SELF-CHECKOUT KIOSK" class="img-fluid" />
  <h4 class="center"><span style="subtle">SELF-CHECKOUT KIOSK</span></h4></a>
  </div>
  <div class="col-md-3">
  <a href="#HOSPITALITY-KIOSK" /><img src="/EN/solution/images/KIOSK-HOSPITALITY.jpg" alt="HOSPITALITY KIOSK" class="img-fluid" />
  <h4 class="center"><span style="subtle">HOSPITALITY KIOSK</span></h4></a>
  </div>
  <div class="col-md-3">
  <a href="#KSK-TICKETING" /><img src="/EN/solution/images/KIOSK-TICKETING.jpg" alt="TICKETING KIOSK" class="img-fluid" />
  <h4 class="center"><span style="subtle">TICKETING KIOSK</span></h4></a>
  </div>
  <div class="col-md-3">
  <a href="#KSK-GIFTCARD" /><img src="/EN/solution/images/KIOSK-GIFTCARD.jpg" alt="GIFTCARD KIOSK" class="img-fluid" />
  <h4 class="center"><span style="subtle">GIFTCARD KIOSK</span></h4></a>
  </div>
</div>
<p class="mt-3">&nbsp;</p><a name="KSK-SELF-CHECKOUT"></a>
	</div>
	</div>


	<!--SELF-CHECKOUT -->

<a name="KSK-SELF-CHECKOUT"></a>
<p class="mt-3">&nbsp;</p>



	<div class="container-fluid m-0 bg-dark-blue">
	<h1 class="center">SELF-CHECKOUT KIOSK</h1>
	</div>
<div class="container-fluid m-0 border-0" style="padding: 80px 0; background: url(/EN/solution/images/KIOSK-SELF-CHECKOUT-overview.jpg) no-repeat center center; background-size: cover;">
					<div class="container  clearfix mb-5">
						<div class="row mt-2 ">

						<div class="col-lg-7" >
	 <div class="neumorphic-box-kv" >
		<h2 class="white">Overview</h2>
		Self-checkout kiosk is rapidly becoming popular with both retailers and consumers, it benefit to business owner and customer in many ways, such as saving human resource, serve more customers, increase profits, quicker services. Shoppers can also reduce queue time during rush hours to improve customer satisfactions. Also, self-checkout kiosks also enable customers to be more informed about the products you offer and special promotions in more effective way.<br /><br />

	</div><p class="mb-4">&nbsp;</p>
</div>
<div class="col-lg-5" ></div>

						</div>

					</div>
</div>


<div class="container-fluid m-0 border-0" style="padding: 80px 0; ">
<div class="container clearfix">

<h2>Challenges</h2>
<p class="mt-2">&nbsp;</p>
<div class="row mb-3">
  <div class="col-md-3" >
  <div class="neumorphic-box-40 p-3" >
  <div class="center"><img src="/EN/solution/images/KIOSK-SELF-CHECKOUT-Challenges-1.svg" style="width:160px; margin:75px 0px 45px 0px"  /></div><br />
  <p class="center">Long queue result in time waste caused by traditional checkout lanes</p>
  </div></div>
  <div class="col-md-3" >
  <div class="neumorphic-box-40 p-3">
  <div class="center"><img src="/EN/solution/images/KIOSK-SELF-CHECKOUT-Challenges-2.svg" style="width:160px; margin:40px 0px 25px 0px"  /></div><br />
  <p class="center">Dedicated store staff occupied checkout at counter side</p>
  </div></div>
  <div class="col-md-3 " >
  <div class="neumorphic-box-40 p-3">
  <div class="center"><img src="/EN/solution/images/KIOSK-SELF-CHECKOUT-Challenges-3.svg" style="width:120px; margin:15px 0 15px 0px"   /></div><br />
  <p class="center">Wage increase year by year result in company profit decrease</p>
  </div></div>
  <div class="col-md-3 ">
  <div class="neumorphic-box-40 p-3">
  <div class="center"><img src="/EN/solution/images/KIOSK-SELF-CHECKOUT-Challenges-4.svg" style="width:160px; margin:20px 0 20px 0px"  /></div><br />
  <p class="center">Potential infectious disease infected caused by human contact</p>
  </div></div>
</div>

</div>
</div>


<div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;">
<div class="container clearfix" ><p class="mb-2">&nbsp;</p>
<h2>Solutions</h2>
<div class="container solution-bgkv-CHECKOUT">
	<div style="position: absolute; top: 15%; left:37%;"><img src="/EN/solution/images/KIOSK-SELF-CHECKOUT-Solutions-cart.svg" style="width:250px" class="img-fluid" />
	</div>
	</div>




	</div>
</div>




<div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;">
<div class="container px-3">
  <div class="row gx-3">
    <div class="col">
	 <div class="neumorphic-box-40 p-3">
  <div class="center"><img src="/EN/solution/images/KIOSK-SELF-CHECKOUT-Solutions-1.svg" style="width:120px; margin:35px 0px 30px 0px"  /></div>
  <p class="center">Featured 1D/2D Barcode Scan, WiFi 11ac, BT connectivity and AI camera integrated</p>
  </div>
    </div>
    <div class="col">
      <div class="neumorphic-box-40 p-3">
  <div class="center"><img src="/EN/solution/images/KIOSK-SELF-CHECKOUT-Solutions-2.svg" style="width:150px; margin:50px 0px 60px 0px"  /></div>
  <p class="center">Modular peripherals design for easy upgrade</p>
  </div>
    </div>
	<div class="col">
      <div class="neumorphic-box-40 p-3">
  <div class="center"><img src="/EN/solution/images/KIOSK-SELF-CHECKOUT-Solutions-3.svg" style="width:150px; margin:70px 0px 75px 0px"  /></div>
  <p class="center">Wide screen and FHD display resolution increasing visual satisfaction</p>
  </div>
    </div>
	<div class="col">
      <div class="neumorphic-box-40 p-3">
  <div class="center"><img src="/EN/solution/images/KIOSK-SELF-CHECKOUT-Solutions-4.svg" style="width:150px; margin:80px 0px 75px 0px" /></div>
  <p class="center">Dual Windows / Linux enables wider OS migration compatibility with backend system</p>
  </div>
    </div>
	<div class="col">
      <div class="neumorphic-box-40 p-3">
  <div class="center"><img src="/EN/solution/images/KIOSK-SELF-CHECKOUT-Solutions-5.svg" style="width:150px; margin:45px 0px 45px 0px" /></div>
  <p class="center">Remote touch panel to avoid disease infected (option)</p>
  </div>
    </div>
  </div>
</div>
</div>

<div class="container-fluid m-0 border-0" style="padding: 80px 0; background: url(/EN/solution/images/KIOSK-SELF-CHECKOUT-results.jpg) no-repeat center center; background-size: cover;">
<div class="container clearfix">

<h2>Results</h2>
<p class="mt-2">&nbsp;</p>
<div class="row">
  <div class="col-lg-6">
  <div class="row">
  <div class="col-lg-6">
  <div class="neumorphic-box-40 p-3">
   <div class="center"><img src="/EN/solution/images/KIOSK-SELF-CHECKOUT-results-1.svg" style="width:160px; margin:20px 0px 20px 0px"  /></div><br />
  <p class="center">Shopping smart less waiting and improve customer shopping experience</p>

  </div>
  </div>
  <div class="col-lg-6">
  <div class="neumorphic-box-40 p-3">
   <div class="center"><img src="/EN/solution/images/KIOSK-SELF-CHECKOUT-results-2.svg" style="width:160px; margin:15px 0px 10px 0px" /></div><br />
  <p class="center">Free up store staff to serve customers in other ways</p>
  </div>
  </div>
</div>

  </div>
  <div class="col-lg-6"></div>
</div>
<p class="mb-3">&nbsp;</p><a name="HOSPITALITY-KIOSK"></a>

</div>


</div>



<!-- end SELF-CHECKOUT -->

<!--HOSPITALITY-KIOSK -->

	<div class="container-fluid m-0 bg-dark-blue">
	<h1 class="center">HOSPITALITY KIOSK</h1>
	</div>

<div class="container-fluid m-0 border-0" style="padding: 80px 0; background: url(/EN/solution/images/KIOSK-HOSPITALITY-overview.jpg) no-repeat center center; background-size: cover;">
					<div class="container  clearfix mb-5">
						<div class="row mt-2 ">

						<div class="col-lg-7" >
	 <div class="neumorphic-box-kv mt-1" >
		<h2 class="white">Overview</h2>
		Guests don't need to wait in front of your reception desk any more, they can choose a calm moment to register and check-in to avoid the hectic rush in front of the reception desk and checkout without queue.  Hotel Staff can focus on the things that matter most. Self check-in/ check-out Kiosk make thing in no rush because self service doesn't mean lack of service.<br /><br />

	</div><p class="mb-4">&nbsp;</p>
</div>
<div class="col-lg-5" ></div>

						</div>

					</div><p class="mb-4">&nbsp;</p>
</div>


<div class="container-fluid m-0 border-0" style="padding: 80px 0; ">
					<div class="container  clearfix mb-5">
					<h2>Challenges</h2>
						<div class="row">

						  <div class="col-md-4" >
  <div class="neumorphic-box-40 p-3" >
  <div class="center"><img src="/EN/solution/images/KIOSK-HOSPITALITY-Challenges-1.svg" style="width:160px; margin:10px 0px 10px 0px"  /></div><br />
  <p class="center">Long waiting in long check-in lines</p>
  </div></div>
  <div class="col-md-4" >
  <div class="neumorphic-box-40 p-3">
  <div class="center"><img src="/EN/solution/images/KIOSK-HOSPITALITY-Challenges-2.svg" style="width:160px; margin:45px 0px 45px 0px"  /></div><br />
  <p class="center">Single check-in / checkout way to go, front desk service</p>
  </div></div>
  <div class="col-md-4" >
  <div class="neumorphic-box-40 p-3">
  <div class="center"><img src="/EN/solution/images/KIOSK-HOSPITALITY-Challenges-3.svg" style="width:160px; margin:50px 0 40px 0px"   /></div><br />
  <p class="center">Frustrate customer during check-in / check-out process caused by human-related errors and language gap</p>
  </div></div>


						</div>
					</div>
</div>



<div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;">
<div class="container clearfix" ><p class="mb-2">&nbsp;</p>
<h2>Solutions</h2>
<div class="container solution-bgkv-CHECKOUT">
	<div style="position: absolute; top: 22%; left:42%;"><img src="/EN/solution/images/KIOSK-HOSPITALITY-Solutions.svg" style="width:100px" class="img-fluid" />
	</div>
	</div>




	</div>
</div>




<div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;">
<div class="container px-3">
  <div class="row gx-3">
    <div class="col">
	 <div class="neumorphic-box-40 p-3">
  <div class="center"><img src="/EN/solution/images/KIOSK-SELF-CHECKOUT-Solutions-1.svg" style="width:120px; margin:10px 0px 30px 0px"  /></div>
  <p class="center">Featured WiFi 11ac, BT, NFC, connectivity and AI camera integrated</p>
  </div>
    </div>
    <div class="col">
      <div class="neumorphic-box-40 p-3">
  <div class="center"><img src="/EN/solution/images/KIOSK-HOSPITALITY-Solutions-2.svg" style="width:150px; margin:65px 0px 70px 0px"  /></div>
  <p class="center">Featured OCR barcode scan for passport</p>
  </div>
    </div>
	<div class="col">
      <div class="neumorphic-box-40 p-3">
  <div class="center"><img src="/EN/solution/images/KIOSK-HOSPITALITY-Solutions-3.svg" style="width:150px; margin:40px 0px 40px 0px"  /></div>
  <p class="center">Privacy shelter bring guest a sense of comfort</p>
  </div>
    </div>
	<div class="col">
      <div class="neumorphic-box-40 p-3">
  <div class="center"><img src="/EN/solution/images/KIOSK-SELF-CHECKOUT-Solutions-3.svg" style="width:150px; margin:50px 0px 55px 0px" /></div>
  <p class="center">Wide screen and FHD display resolution increasing visual satisfaction</p>
  </div>
    </div>
	<div class="col">
      <div class="neumorphic-box-40 p-3">
  <div class="center"><img src="/EN/solution/images/KIOSK-SELF-CHECKOUT-Solutions-5.svg" style="width:150px; margin:20px 0px 38px 0px" /></div>
  <p class="center">Remote touch panel to avoid disease infected (option)</p>
  </div>
    </div>
  </div>
</div>
</div>

<div class="container-fluid m-0 border-0" style="padding: 80px 0; background: url(/EN/solution/images/KIOSK-HOSPITALITY-results.jpg) no-repeat center center; background-size: cover;">
<div class="container clearfix">

<h2>Results</h2>
<p class="mt-2">&nbsp;</p>
<div class="row">
  <div class="col-lg-6">
  <div class="row">
  <div class="col-lg-6">
  <div class="neumorphic-box-40 p-3">
   <div class="center"><img src="/EN/solution/images/KIOSK-HOSPITALITY-results-1.svg" style="width:140px; margin:10px 0px 10px 0px"  /></div><br />
  <p class="center">Personalize and improve guest experience</p>

  </div>
  </div>
  <div class="col-lg-6">
  <div class="neumorphic-box-40 p-3">
   <div class="center"><img src="/EN/solution/images/KIOSK-SELF-CHECKOUT-results-2.svg" style="width:160px; margin:10px 0px 10px 0px" /></div><br />
  <p class="center">Free up hotel staff to focus on exquisite service</p>
  </div>
  </div>
</div>

  </div>
  <div class="col-lg-6"></div>
</div>
<p class="mb-3">&nbsp;</p><a name="KSK-TICKETING"></a>

</div>


</div>


<!--end HOSPITALITY-KIOSK -->
<!--TICKETING KIOSK -->

<div class="container-fluid m-0 bg-dark-blue">
	<h1 class="center">TICKETING KIOSK</h1>
	</div>


<div class="container-fluid m-0 border-0" style="padding: 80px 0; background: url(/EN/solution/images/KIOSK-TICKETING-overview.jpg) no-repeat center center; background-size: cover;">
					<div class="container  clearfix mb-5">
						<div class="row mt-2 ">

						<div class="col-lg-7" >
	 <div class="neumorphic-box-kv mt-1" >
		<h2 class="white">Overview</h2>
		Ticketing Kiosk is providing the advantage of quick transactions, fast resulting in faster customer service and significant queue reduction. They can be used 24x7 and during peak time self ticketing services significantly improve customer flow because of convenience of operation during off peak hours to customers.<br /><br />

	</div><p class="mb-4">&nbsp;</p>
</div>
<div class="col-lg-5" ></div>

						</div>

					</div><p class="mb-4">&nbsp;</p>
</div>


<div class="container-fluid m-0 border-0" style="padding: 80px 0; ">
					<div class="container  clearfix mb-5">
					<h2>Challenges</h2>
						<div class="row">

						  <div class="col-md-4" >
  <div class="neumorphic-box-40 p-3" >
  <div class="center"><img src="/EN/solution/images/KIOSK-TICKETING-Challenges-1.svg" style="width:200px; margin:10px 0px 10px 0px"  /></div><br />
  <p class="center">Few and limited function can be provided in traditional ticket machine</p>
  </div></div>
  <div class="col-md-4" >
  <div class="neumorphic-box-40 p-3">
  <div class="center"><img src="/EN/solution/images/KIOSK-TICKETING-Challenges-2.svg" style="width:200px; margin:20px 0px 20px 0px"  /></div><br />
  <p class="center">Customer get used to purchase at counter and feel not secured when purchase on website</p>
  </div></div>
  <div class="col-md-4" >
  <div class="neumorphic-box-40 p-3">
  <div class="center"><img src="/EN/solution/images/KIOSK-TICKETING-Challenges-3.svg" style="width:200px; margin:63px 0px 62px 0px"   /></div><br />
  <p class="center">Long waiting in long purchase lines</p>
  </div></div>


						</div>
					</div>
</div>



<div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;">
<div class="container clearfix" ><p class="mb-2">&nbsp;</p>
<h2>Solutions</h2>
<div class="container solution-bgkv-CHECKOUT">
	<div style="position: absolute; top: 15%; left:37%;"><img src="/EN/solution/images/KIOSK-TICKETING-Solutions-ticket.svg" style="width:250px" class="img-fluid" />
	</div>
	</div>




	</div>
</div>




<div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;">
<div class="container px-3">
  <div class="row gx-3">
    <div class="col">
	 <div class="neumorphic-box-40 p-3">
  <div class="center"><img src="/EN/solution/images/KIOSK-SELF-CHECKOUT-Solutions-1.svg" style="width:110px; margin:25px 0px 35px 0px"  /></div>
  <p class="center">1D/2D BCR and payment device for quick transaction</p>
  </div>
    </div>
    <div class="col">
      <div class="neumorphic-box-40 p-3">
  <div class="center"><img src="/EN/solution/images/KIOSK-TICKETING-Solutions-2.svg" style="width:160px; margin:45px 0px 45px 0px"/></div>
  <p class="center">High speed ticket printer</p>
  </div>
    </div>
	<div class="col">
      <div class="neumorphic-box-40 p-3">
  <div class="center"><img src="/EN/solution/images/KIOSK-TICKETING-Solutions-3.svg" style="width:160px; margin:40px 0px 30px 0px"  /></div>
  <p class="center">Dual wide screens provide clear menu, instruction and in-time promotion</p>
  </div>
    </div>
	<div class="col">
      <div class="neumorphic-box-40 p-3">
  <div class="center"><img src="/EN/solution/images/KIOSK-TICKETING-Solutions-4.svg" style="width:120px; margin:20px 0px 30px 0px"  /></div>
  <p class="center">Integrated telephone to easily contact w/ service representative</p>
  </div>
    </div>
	<div class="col">
      <div class="neumorphic-box-40 p-3">
 <div class="center"><img src="/EN/solution/images/KIOSK-SELF-CHECKOUT-Solutions-5.svg" style="width:160px; margin:10px 0px 20px 0px"  /></div>
  <p class="center">Remote touch panel to avoid disease infected (option)</p>
  </div>
    </div>
  </div>
</div>
</div>

<div class="container-fluid m-0 border-0" style="padding: 80px 0; background: url(/EN/solution/images/KIOSK-TICKETING-result.jpg) no-repeat center center; background-size: cover;">
<div class="container clearfix">

<h2>Results</h2>
<p class="mt-2">&nbsp;</p>
<div class="row">
  <div class="col-lg-6">
  <div class="row">
  <div class="col-lg-6">
  <div class="neumorphic-box-40 p-3">
    <div class="center"><img src="/EN/solution/images/KIOSK-TICKETING-results-1.svg" style="width:150px; margin:5px 0px 15px 0px"  /></div><br />
  <p class="center">Customer satisfaction increase because of improved customer experience</p>

  </div>
  </div>
  <div class="col-lg-6">
  <div class="neumorphic-box-40 p-3">
   <div class="center"><img src="/EN/solution/images/KIOSK-TICKETING-results-2.svg" style="width:150px; margin:5px 0px 10px 0px"  /></div><br />
  <p class="center">Free up store staff to serve customers in other ways</p>
  </div>
  </div>
</div>

  </div>
  <div class="col-lg-6"></div>
</div>
<p class="mb-3">&nbsp;</p><a name="KSK-GIFTCARD"></a>

</div>


</div>
<!--end TICKETING KIOSK -->


<!-- GIFTCARD KIOSK-->


<div class="container-fluid m-0 bg-dark-blue">
	<h1 class="center">GIFTCARD KIOSK</h1>
	</div>


<div class="container-fluid m-0 border-0" style="padding: 80px 0; background: url(/EN/solution/images/KIOSK-GIFTCARD-overview.jpg) no-repeat center center; background-size: cover;">
					<div class="container  clearfix mb-5">
						<div class="row mt-2 ">

						<div class="col-lg-7" >
	 <div class="neumorphic-box-kv mt-1" >
		<h2 class="white">Overview</h2>
		Giftcard Kiosk is a highly integrated system because of complex devices connected inside the Kiosk, such as payment transaction, various printers, bill/ cash acceptor, camera and barcode scanner...etc. MiTAC is 40+ year-experienced company in retail industry that is an expert of system integration.<br /><br />

	</div><p class="mb-4">&nbsp;</p>
</div>
<div class="col-lg-5" ></div>

						</div>

					</div><p class="mb-4">&nbsp;</p>
</div>


<div class="container-fluid m-0 border-0" style="padding: 80px 0; ">
					<div class="container  clearfix mb-5">
					<h2>Challenges</h2>
						<div class="row">

						  <div class="col-md-4" >
  <div class="neumorphic-box-40 p-3" >
  <div class="center"><img src="/EN/solution/images/KIOSK-GIFTCARD-Challenges-1.svg" style="width:120px; margin:20px 0 20px 0px"  /></div><br />
  <p class="center">Few and limited function can be provided in traditional ticket machine</p>
  </div></div>
  <div class="col-md-4" >
  <div class="neumorphic-box-40 p-3">
  <div class="center"><img src="/EN/solution/images/KIOSK-GIFTCARD-Challenges-2.svg" style="width:130px; margin:35px 0 30px 0px"  /></div><br />
  <p class="center">Customer get used to purchase at counter and feel not secured when purchase on website</p>
  </div></div>
  <div class="col-md-4" >
  <div class="neumorphic-box-40 p-3">
 <div class="center"><img src="/EN/solution/images/KIOSK-SELF-CHECKOUT-Challenges-3.svg" style="width:120px; margin:40px 0 30px 0px"   /></div><br />
  <p class="center">Long waiting in long purchase lines</p>
  </div></div>


						</div>
					</div>
</div>



<div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;">
<div class="container clearfix" ><p class="mb-2">&nbsp;</p>
<h2>Solutions</h2>
<div class="container solution-bgkv-CHECKOUT">
	<div style="position: absolute; top: 10%; left:35%;"><img src="/EN/solution/images/KIOSK-GIFTCARD-Solutions-box.svg" style="width:250px" class="img-fluid" />
	</div>
	</div>




	</div>
</div>




<div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;">
<div class="container px-3">
  <div class="row gx-3">
    <div class="col">
	 <div class="neumorphic-box-40 p-3">
  <div class="center"><img src="/EN/solution/images/KIOSK-SELF-CHECKOUT-Solutions-1.svg" style="width:110px; margin:10px 0px 20px 0px"  /></div>
  <p class="center" >Multi-function card reader, PIN pad, card printer and bill acceptor for quick transaction</p>
  </div>
    </div>
    <div class="col">
      <div class="neumorphic-box-40 p-3">
 <div class="center"><img src="/EN/solution/images/KIOSK-GIFTCARD-Solutions-2.svg" style="width:150px; margin:40px 0px 40px 0px"  /></div>
  <p class="center">E-lock provide high protection</p>
  </div>
    </div>
	<div class="col">
      <div class="neumorphic-box-40 p-3">
  <div class="center"><img src="/EN/solution/images/KIOSK-TICKETING-Solutions-3.svg" style="width:150px; margin:45px 0px 50px 0px"  /></div>
  <p class="center" >Dual wide screens provide visual satisfaction and in-time promotion</p>
  </div>
    </div>
	<div class="col">
      <div class="neumorphic-box-40 p-3">
   <div class="center"><img src="/EN/solution/images/KIOSK-GIFTCARD-Solutions-4.svg" style="width:150px; margin:40px 0px 40px 0px" /></div>
  <p class="center" >Industrial 3G/4G/ LTE cellular router to secure wireless connection</p>
  </div>
    </div>
	<div class="col">
      <div class="neumorphic-box-40 p-3">
  <div class="center"><img src="/EN/solution/images/KIOSK-SELF-CHECKOUT-Solutions-5.svg" style="width:150px; margin:30px 0px 25px 0px" /></div>
  <p class="center" >Remote touch panel to avoid disease infected (option)</p>
  </div>
    </div>
  </div>
</div>
</div>

<div class="container-fluid m-0 border-0" style="padding: 80px 0; background: url(/EN/solution/images/KIOSK-GIFTCARD-results.jpg) no-repeat center center; background-size: cover;">
<div class="container clearfix">

<h2>Results</h2>
<p class="mt-2">&nbsp;</p>
<div class="row">
  <div class="col-lg-6">
  <div class="row">
  <div class="col-lg-6">
  <div class="neumorphic-box-40 p-3">
  <div class="center"><img src="/EN/solution/images/KIOSK-GIFTCARD-results-1.svg" style="width:150px; margin:40px 0px 20px 0px"  /></div><br />
  <p class="center">Customer royalty increase because of security transaction protection</p>
  </div>
  </div>
  <div class="col-lg-6">
  <div class="neumorphic-box-40 p-3">
   <div class="center"><img src="/EN/solution/images/KIOSK-GIFTCARD-results-2.svg" style="width:150px; margin:30px 0px 22px 0px" /></div><br />
  <p class="center">ROI reduction: gift card kiosk (unmanned) versus monthly-paid staff</p>
  </div>
  </div>
</div>

  </div>
  <div class="col-lg-6"></div>
</div>
<p class="mb-3">&nbsp;</p>

</div>


</div>

<!--end GIFTCARD KIOSK-->












		<!-- FOOTER -->
	  <?php
    include("../../foot1.htm");
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
</body>
</html>