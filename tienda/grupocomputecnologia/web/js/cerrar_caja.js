$(document).ready(function(){
_cerrarcaja= function (url){
//alert(url);
$("#emergente").load(url, function(){
$.blockUI({
				message: $("#emergente"),
				css:{
					top: '15%',
					width: '50%',
					height: '40%',
					left: '24%'
				 }
			}); 
		});	
}



});





