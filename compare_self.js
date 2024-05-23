function removeRFQ(i,j){
	var div="#Qty_"+j;
	var sku=i;
	var j=0;
	var tmpsku=Cookies.get("RFQsku");

	var newSKU="";
	tmpsku = tmpsku.split(",");

	for (var i = 0; i < tmpsku.length; i++) {
		if(tmpsku[i]==sku){
		}else{
			if(i>0){
				newSKU+=","+tmpsku[i];
				j++;
			}else{
				newSKU+=tmpsku[i];
				j++;
			}		
		}
	};
	document.cookie = "RFQsku="+ newSKU + ";path=/";
	var nums=j;
	document.getElementById("RFQnum").innerHTML="<i class='icon-dollar'></i>&nbsp;&nbsp; ("+nums+")";
	$(div).empty();
}

$("#RFQOK").click(function(){
  var IN = document.getElementById("IN").innerHTML;
  var QTotal = document.getElementById("QTotal").innerHTML;
  var RFQ_SKU="";
  var Qnum="";
  for (var i = 0; i < QTotal; i++) {
  	if(QTotal=="1"){
			RFQ_SKU = $("#RFQ_SKU_"+i).html();
			Qnum = $("#Qnum_"+i).val();
  	}else{
  		RFQ_SKU += $("#RFQ_SKU_"+i).html(); 
  		RFQ_SKU += "+";
	    Qnum += $("#Qnum_"+i).val();
	    Qnum += "+";
  	} 
  };

  document.cookie = "RFQnum="+ Qnum + ";path=/";

  if(IN=="1"){ //login
  	var kind="RFQ";
  	var url="RFQprocess";
  	/*$.ajax({
  		type: "post",
  		url: url,
  		dataType: "html",
  		data: {
  			RFQ_SKU : RFQ_SKU,
  			Qnum : Qnum,
  			kind : kind
  		},
  		success: function(message){
  			if(message == "success"){
  				Cookies.remove("RFQsku");
  				Cookies.remove("RFQnum");
  				window.open("https://partner.tyan.com/FEmyquotation");
  			}else if(message == "N"){
  				window.open("https://partner.tyan.com/FEmyquotation");
  			}else{
  				alert(message);
  			}
  		}
  	});*/
	location.href="https://partner.tyan.com/RFQprocess@"+RFQ_SKU+"@"+Qnum;
  }else{
  	//Cookies.remove("RFQsku");
  	//Cookies.remove("RFQnum");
  	location.href="https://partner.tyan.com/loginRFQ@"+RFQ_SKU+"@"+Qnum;
  	//window.open("https://partner.tyan.com/FEregister@"+RFQ_SKU+"@"+Qnum);
  } 
})


function AddRFQ(i, j){
	var cRFQSKU=Cookies.get("RFQsku");
	var sku=i;

	
	
	if(cRFQSKU!=undefined || cRFQSKU==""){
		if(cRFQSKU.indexOf(sku) != -1){
			exit;
		}	

		var items = Cookies.get("RFQsku");

		items = items.split(",");

		for (var i = 0; i < items.length; i++) {
			if(items[i]==sku){
				//exit;
			}
			
		};
	    var nums =items.length;
	    if(items!=""){
        	cRFQSKU+=","+sku;
        }else{
        	nums=0;
        	cRFQSKU+=sku;
        }
        sku=cRFQSKU;
        nums++;
	}else if(cRFQSKU==""){
		nums=0;
	}else{
		nums=1;

	}
	document.cookie = "RFQsku="+ sku + ";path=/";
	document.getElementById("RFQnum").innerHTML="<i class='icon-dollar'></i>&nbsp;&nbsp; ("+nums+")";
	location.reload();
}

function add_compare(i, j){
	var cSKU=Cookies.get("sku");
	var cTYPE=Cookies.get("type");
	var sku=i;
	var type=j;
	if(cTYPE==undefined){

	}else if(type!=cTYPE){
		$("#compare-msg1").modal('show');
		exit;
	}

	if(cSKU!=undefined || cSKU==""){		
		var items = Cookies.get("sku");
		items = items.split(",");

		for (var i = 0; i < items.length; i++) {
			if(items[i]==sku){
				exit;
			}
			
		};

	    var nums =items.length;
		if(nums>=10){
        	$("#compare-msg2").modal('show');
        	exit;
        }else{
        	if(items!=""){
        		cSKU+=","+sku;
        	}else{
        		nums=0;
        		cSKU+=sku;
        	}
        	sku=cSKU;
        	nums++;
        }
	}else if(cSKU==""){
		nums=0;
	}else{
		nums=1;
	}

	var getUrlString = location.href;
	var lang="";
	if(getUrlString.indexOf('en-US')>0 || getUrlString.indexOf('EN')>0){
		lang="en-US";
	}else if(getUrlString.indexOf('ja-JP')>0 || getUrlString.indexOf('JP')>0){
		lang="ja-JP";
	}else if(getUrlString.indexOf('zh-CN')>0 || getUrlString.indexOf('CN')>0){
		lang="zh-CN";
	}else if(getUrlString.indexOf('zh-TW')>0 || getUrlString.indexOf('ZH')>0){
		lang="zh-TW";
	}else{
		lang="en-US";
	}


	/*expire_days = 0.5; // 過期日期(天)
	var d = new Date();
	d.setTime(d.getTime() + (expire_days * 24 * 60 * 60 * 1000));
	var expires = "expires=" + d.toGMTString();*/
	document.cookie = "sku="+ sku + ";path=/";
	document.cookie = "type="+ type + ";";
	var url = sku.replace(/,/g, "+");
	document.getElementById("compare_process").href="/prcompare@"+url+"@"+type+"@"+lang;
	document.getElementById("cmsg2Modal").href="/prcompare@"+url+"@"+type+"@"+lang;
	document.getElementById("compare_process").innerHTML="<i class='icon-th-list1'></i>&nbsp;&nbsp;"+nums+"/10";
}

function reomve_dialog(){
	Cookies.remove("sku");
	Cookies.remove("type");
	$("#compare-msg1").modal("hide");
	location.reload(); 
}


function getCookie(cookieName) {
  var name = cookieName + "=";
  var ca = document.cookie.split(';');
  for(var i=0; i<ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0)==' ') c = c.substring(1);
      if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
  }
  return "";
}
	//var a= document.cookie;
	//alert(a);
	document.cookie = "tmpsku=; expires=Thu, 01 Jan 1970 00:00:00 GMT"; 
	//Cookies.remove("tmpsku");
	var cSKU=getCookie("sku");
	var cTYPE=getCookie("type");
	var cRFQSKU=getCookie("RFQsku");
	var url = cSKU.replace(/,/g, "+");
	if(cSKU!=""){
		cSKU = cSKU.split(",");
    	var nums =cSKU.length;
	}else{
		document.cookie = "sku=; expires=Thu, 01 Jan 1970 00:00:00 GMT"; 
		//Cookies.remove("sku");
		//delCookie("sku");
		var nums=0;
	}

	if(cRFQSKU!=""){
		cRFQSKU = cRFQSKU.split(",");
    	var RFQnums =cRFQSKU.length;
	}else{
		document.cookie = "RFQsku=; expires=Thu, 01 Jan 1970 00:00:00 GMT"; 
		//Cookies.remove("sku");
		//delCookie("sku");
		var RFQnums=0;
	}



	var getUrlString = location.href;
	var lang="";
	if(getUrlString.indexOf('en-US')>0 || getUrlString.indexOf('EN')>0){
		lang="en-US";
	}else if(getUrlString.indexOf('ja-JP')>0 || getUrlString.indexOf('JP')>0){
		lang="ja-JP";
	}else if(getUrlString.indexOf('zh-CN')>0 || getUrlString.indexOf('CN')>0){
		lang="zh-CN";
	}else if(getUrlString.indexOf('zh-TW')>0 || getUrlString.indexOf('ZH')>0){
		lang="zh-TW";
	}else{
		lang="en-US";
	}
	if (url=="" || cTYPE=="") {
		document.getElementById("compare_process").href="#";
	}else{
		document.getElementById("compare_process").href="/prcompare@"+url+"@"+cTYPE+"@"+lang;
	}
	document.getElementById("compare_process").innerHTML="<i class='icon-th-list1'></i>&nbsp;&nbsp;"+nums+"/10";
		document.getElementById("RFQnum").innerHTML="<i class='icon-dollar'></i>&nbsp;&nbsp; ("+RFQnums+")";

	document.getElementById("cmsg2Modal").href="/prcompare@"+url+"@"+cTYPE+"@"+lang;
