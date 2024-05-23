function cancelCard(i,j){
	var UID=$("#UID").val();
	var cardID=j;
  var kind=i;
  var url = "dashboardProcess";
  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
  	UID : UID,
  	cardID : cardID,
    kind : kind
  },
  success: function(message){
    if(message == "success"){
      location.reload();
    }else{
      alert(message);
    }
  }
  }); 
}