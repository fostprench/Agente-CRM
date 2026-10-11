$(document).ready(function(){
_ver = function (url){
$("#emergente").load(url, function(){
$.blockUI({
				message: $("#emergente"),
				css:{
					top: '2%',
					width: '80%',
					height: 'auto',
					left: '10%'
				 }
			}); 
		});	
}


_amortizacion = function (url){
$.get(url,function(data)
	 {
	    $("#cont").html(data);

      });
}


_msgamortizacion = function (url){
alert('Deuda Cancelada');
}



});





