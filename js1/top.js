$(document).ready(function()
{
  $('li').hover(function(){
    var timer = $(this).data('timer');
    if(timer) clearTimeout(timer);
    $(this).addClass('over');
  },function(){
    var li = $(this);
    li.data('timer', setTimeout(function(){ li.removeClass('over'); }, 500));
  });
});

// download catelog 點選後給值到表單
function eDM(i, j, k, l){
  if(k=="C"){
    $("#cbuurl").val(i);
    $("#c_cateName").val(l);
  }else{
    $("#ebuurl").val(i);
    $("#e_cateName").val(l);

  }
}
// download catelog 點選後給值到表單 end


//<!-- Cookies -->

function cookies(i){
  var cookies_status=i;
  expire_days = 365; // 過期日期(天)
  var d = new Date();
  d.setTime(d.getTime() + (expire_days * 24 * 60 * 60 * 1000));
  var expires = "expires=" + d.toGMTString();
  //document.cookie = "status=1" + "; " + expires + '; domain=blog.longwin.com.tw; path=/';
  document.cookie = "status="+ cookies_status + "; " + expires + ';path=/;';
  //alert(document.cookie);
  document.getElementById("cookie-alert").style.visibility="hidden";
}

//<!-- Cookies end -->

// Subscribe
$(function(){
  $("#MVaBtn").click(function() {

    var search_str = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
    var mail_val = $("#mail").val();
    var subscribe = $("#sel_sub").val();

    if(search_str.test(mail_val)){
      if(subscribe=="subscribe"){
        var url = "/subscription";
      }else{
        var url = "/delsubscription";
      }
      var mail = $("#mail").val();
      var fd = new FormData();
      fd.append("mail", mail);
      $.ajax({
        type: "post",
        url: url,
        dataType: "html",
        data: fd,
        cache: false,
        contentType: false,
        processData: false,

        success: function(data){
          if(data == "refresh"){
              $("#sucss_msg").show();
              $("#delete_msg").hide();
              $("#exist_msg").hide();
              $("#err_msg").hide();
              $("#mail").val('');
            }else if(data == "delete"){
              $("#sucss_msg").hide();
              $("#delete_msg").show();
              $("#exist_msg").hide();
              $("#err_msg").hide();
              $("#mail").val('');
            }else{
              $("#sucss_msg").hide();
              $("#delete_msg").hide();
              $("#exist_msg").show();
              $("#err_msg").hide();
              $("#mail").val('');
            }
          }
      });
              /* End */
    }else{
      //alert("mail format is incorrect!");
      $("#sucss_msg").hide();
      $("#delete_msg").hide();
      $("#exist_msg").hide();
      $("#err_msg").show();
      $("#mail").val('');

    }

  });
});
// Subscribe End

//captcha
$(function(){
    $("#re_catelog").click(function() {
       var obj = document.getElementById("rand-img");
       var i=Math.floor((Math.random() * 10) + 1);;
       obj.src=null;
       var url = "/captcha@"+i;
       $.ajax({
        type: "post",
        url: url,
        dataType: "html",
        success: function(message){
            if(message == "susses"){
                alert(message);
                //document.location.href='../SupportCenter';
            }else{
                obj.src="/captcha@"+i;
            }
        }
        });
   });
})
$(function(){
    $("#re_catelog_E").click(function() {
       var obj = document.getElementById("e_rand-img");
       var i=Math.floor((Math.random() * 10) + 1);;
       obj.src=null;
       var url = "/captcha@"+i;
       $.ajax({
        type: "post",
        url: url,
        dataType: "html",
        success: function(message){
            if(message == "susses"){
                alert(message);
                //document.location.href='../SupportCenter';
            }else{
                obj.src="/captcha@"+i;
            }
        }
        });
   });
})
//captcha END

// top catalog
function catalog(i,j){

  var name=document.getElementById(i+"_name").value;
  if(name==""){
    $("#"+i+"_err_Name").show();
    $("#"+i+"_err_cName").hide();
    $("#"+i+"_err_Email").hide();
    $("#"+i+"_err_nlang").hide();
    exit;
  }
  var company = document.getElementById(i+"_company").value;
  if(company==""){
    $("#"+i+"_err_Name").hide();
    $("#"+i+"_err_cName").show();
    $("#"+i+"_err_Email").hide();
    $("#"+i+"_err_nlang").hide();
    exit;
  }
  var email = document.getElementById(i+"_email").value;

  if(email!=""){
    var search_str = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
    //var mail_val = $("#f_Email").val();
    if(search_str.test(email)){
      $("#"+i+"_err_Name").hide();
      $("#"+i+"_err_cName").hide();
      $("#"+i+"_err_Email").hide();
      $("#"+i+"_err_nlang").hide();
    }else{
      $("#"+i+"_err_Name").hide();
      $("#"+i+"_err_cName").hide();
      $("#"+i+"_err_Email").show();
      $("#"+i+"_err_nlang").hide();
      exit;
    }
  }else{
    $("#"+i+"_err_Name").hide();
    $("#"+i+"_err_cName").hide();
    $("#"+i+"_err_Email").show();
    $("#"+i+"_err_nlang").hide();
    exit;
  }


  var region = document.getElementById(i+"_sel_reg").value;
  if(region==""){
    $("#"+i+"_err_Name").hide();
    $("#"+i+"_err_cName").hide();
    $("#"+i+"_err_Email").hide();
    $("#"+i+"_err_nlang").show();
    exit;
  }

  var News_S="N";

  if(i=="c"){
    if( document.getElementById(i+"_check_news").checked == true){
      News_S="Y";
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

        success: function(data){
        }
      })
    }else{
    }
    var urlDownload = document.getElementById("cbuurl").value;
    var cateName = document.getElementById("c_cateName").value;
  }else{
    var urlDownload = document.getElementById("ebuurl").value;
    var cateName = document.getElementById("e_cateName").value;
  }

  var Checknum1 = document.getElementById(i+"_checknum").value;
  var url1="/catalog";
  var type=i;
  //var link="https://download.mitacmct.com/Files/Catalog/"+j+".pdf";
  var fd1 = new FormData();
      fd1.append("name", name);
      fd1.append("company", company);
      fd1.append("mail", email);
      fd1.append("region", region);
      fd1.append("Checknum1", Checknum1);
      fd1.append("type", type);
      fd1.append("News_S", News_S);
      fd1.append("cateName", cateName);
      $.ajax({
        type: "post",
        url: url1,
        dataType: "html",
        data: fd1,
        cache: false,
        contentType: false,
        processData: false,

        success: function(data){
          if(data=="success"){
            self.location.href=urlDownload;
          }else{
          }
        }
      })
}
// top catalog end

//captcha
$(function(){
    $("#refresh").click(function() {
       var obj = document.getElementById("rand-img");
       var i=Math.floor((Math.random() * 10) + 1);;
       obj.src=null;
       var url = "/captcha@"+i;
       $.ajax({
        type: "post",
        url: url,
        dataType: "html",
        success: function(message){
            if(message == "susses"){
                alert(message);
                //document.location.href='../SupportCenter';
            }else{
                obj.src="/captcha@"+i;
            }
        }
        });
   });
})
//captcha end

// div login <-> FPW
$(function(){
  $("#FPW").click(function() {
    document.getElementById("loginDiv").style.display="none";
    document.getElementById("FPWDiv").style.display="";
  });
})
$(function(){
  $("#B_login").click(function() {
    document.getElementById("loginDiv").style.display="";
    document.getElementById("FPWDiv").style.display="none";
  });
})
// div login <-> FPW end

// reset PW
$(function(){
  $("#resetPW").click(function() {
    var search_str = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
    var mail_val = $("#FPW_mail").val();

    if(mail_val==""){
      $("#errMsg").show();
      $("#sucMsg").hide();
      exit;
    }
    if(search_str.test(mail_val)){

    }else{
      //alert("mail format is incorrect!");
      $("#errMsg").show();
      $("#sucMsg").hide();
      exit;
    }
    var kind = "reset";
    var url = "/PartnerZone/loginProcess";
    var fd = new FormData();
    fd.append("kind", kind),
    fd.append("mail", mail_val);
    $.ajax({
      type: "post",
      url: url,
      dataType: "html",
      data: fd,
      cache: false,
      contentType: false,
      processData: false,

      success: function(data){
        if(data == "success"){
          $("#rest_sucMsg").show();
          $("#rest_errMsg").hide();
        }else{
          $("#rest_errMsg").show();
          $("#rest_sucMsg").hide();
        }
      }
    });
  });
});
// reset PW end

// topLogin
$(function(){
  $("#topLogin").click(function() {
    var topMail = $("#topMail").val();
    var topPW = $("#topPW").val();
    var search_str = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
    if(topMail==""){
      $("#err_Email").show();
      exit;
    }else{
      $("#err_Email").hide();
    }

    if(search_str.test(topMail)){

    }else{
      $("#err_Email").show();
      exit;
    }
    var Checknum1 = $("#topChecknum").val();
    var keepIn=$("#keepIn").is(":checked");

    if(keepIn==true){
      keepIn = "1";
    }else{
      keepIn = "0";
    }
    var RFQpage = $("#RFQpage").val();
    if(RFQpage!="Y"){
      RFQpage="N";
    }
    var kind = "Login";
    var url = "/PartnerZone/loginProcess";
    var fd = new FormData();
    fd.append("mail", topMail),
    fd.append("topPW", topPW),
    fd.append("Checknum1", Checknum1),
    fd.append("keepIn", keepIn),
    fd.append("RFQpage", RFQpage),
    fd.append("kind", kind);
    $.ajax({
      type: "post",
      url: url,
      dataType: "html",
      data: fd,
      cache: false,
      contentType: false,
      processData: false,

      success: function(data){
        if(data == "success"){
          document.location.href="/PartnerZone/FEdashboard";
        }else if(data == "captacha"){
          $("#err_captacha").show();
          $("#err_Email").hide();
          $("#errMsg").hide();
        }else if(data == "errMail"){
          $("#err_captacha").hide();
          $("#err_Email").show();
          $("#errMsg").hide();
        }else if(data == "errMsg"){
          $("#err_captacha").hide();
          $("#errMsg").show();
          $("#err_Email").hide();
        }else if(data == "err_Password"){ // login process
          $("#err_captacha").hide();
          $("#errMsg").show();
          $("#err_Email").hide();
        }else if(data == "Y"){
          location.reload();
        }else if(data.indexOf("FEpassword") != -1 ){
          document.location.href="/PartnerZone/"+data;
        }else{
          alert(data);
        }
      }
    });
    exit;
  });
});
// topLogin end


// Quote
function removeRFQ(i,j){
  var tr="#item_"+j;
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
  document.getElementById("RFQnum").innerHTML="<i class='icon-line-dollar-sign me-1 position-relative' style='top: 1px;'></i>Quote ("+nums+")&nbsp;&nbsp;&nbsp;";
  //$(div).empty();
  $(tr).remove();
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
  $("#addqtomsg").modal('show');

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
  document.getElementById("RFQnum").innerHTML="<i class='icon-line-dollar-sign me-1 position-relative' style='top: 1px;'></i>Quote ("+nums+")&nbsp;&nbsp;&nbsp;";
  //location.reload();
}
// Quote end

// Compare
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
          $("#compare-msg1").modal('show');
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
  document.cookie = "type="+ type + ";path=/";
  var url = sku.replace(/,/g, "+");
  document.getElementById("compare_process").href="/prcompare@"+url+"@"+type+"@"+lang;
  //document.getElementById("cmsg2Modal").href="/prcompare@"+url+"@"+type+"@"+lang;
  document.getElementById("compare_process").innerHTML="Compare ("+nums+"/10)&nbsp;&nbsp;&nbsp;";
}

function reomve_dialog(){
  Cookies.remove("sku");
  Cookies.remove("type");
  $("#compare-msg1").modal("hide");
  location.reload();
}
// Compare end

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
  document.getElementById("compare_process").innerHTML="Compare ("+nums+"/10)&nbsp;&nbsp;&nbsp;";
  document.getElementById("RFQnum").innerHTML="<i class='icon-line-dollar-sign me-1 position-relative' style='top: 1px;'></i>Quote ("+RFQnums+")&nbsp;&nbsp;&nbsp;";

  // document.getElementById("cmsg2Modal").href="/prcompare@"+url+"@"+cTYPE+"@"+lang;
