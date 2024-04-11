<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
session_destroy();
unset($_SESSION['user']);
unset($_SESSION['password']);
unset($_SESSION['login_time']);

function Clear_Cookie(){
 if (isset($_SERVER['HTTP_COOKIE']))
 {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach ($cookies as $cookie)
        {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time() - 1000);
            setcookie($name, '', time() - 1000, '/');
        }
 }
}

Clear_Cookie();
?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script type="text/javascript" src="../fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript">
$(document).ready(function() {    
    $("#Fancy_iframe").fancybox({
				'width'				: '100%',
				'height'			: '100%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
	});
	
	$(".various").fancybox({
		maxWidth	: 800,
		maxHeight	: 600,
		fitToView	: false,
		width		: '70%',
		height		: '70%',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
	});       
});
</script>
<div id="logo_po" style="display:''">login out <input name="B1" type="button" value="Close" onclick="javascript:parent.jQuery.fancybox.close();window.location.href='../login.php';"></div>
<a class="various" href="#logo_po"></a>
<div id="nums" style="display:'none'"></div>
<script type="text/javascript">
var c_time=0;
$(document).ready(function() {
var myClose=setInterval(function(){Click_link()},1000);

  function Click_link(){
   c_time+=1;
   if(c_time==1){
   $('.various').click();
   
   }else if(c_time>3){
   parent.jQuery.fancybox.close();
   window.location.href='../login.php';
   }
  document.getElementById("nums").innerHTML=c_time;
  }
});
</script>
<?php
exit();
?>