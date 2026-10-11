function _reportecaja(url)
{
	loader();
  $.get(url,function(data)
 { 
	//alert(data);
    $("#cont").empty().append(data);
         document.getElementById("cont").style.display="none";
         $("#cont").fadeIn("slow");
		 
  });  	  
}


function _reportecaja_pdf(idcaja){
	window.open('index.php?controller=Reporte&action=caja_apertura&id='+idcaja, '_blank');
}

