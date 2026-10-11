(function($){
    $.fn.setCursorToTextEnd = function() {
        this.focus();
        $initialVal = this.val();
        this.val($initialVal + ' ');
        this.val($initialVal);
    };
})(jQuery);

$(document).ready(function() 
{
	 

	
	$("#frmperfil").submit(function()
	{            
        return false;
	});
	
	$("#_buscar").click(function()
	{	
		var controller = $("#c").val();
		var termino = $("#q").val();
		var str = 'controller='+controller+'&action=Index&q='+termino;
		$("#loader").css("display","block");
		$.get("index.php",str,function(data){
			$("#cont").html(data);
		});
	});
	
	$('#q').setCursorToTextEnd();
	
	$("#q").keyup(function(evt){
        var keyPressed = (evt.which) ? evt.which : event.keyCode
		if (keyPressed==13)
                {
						var controller = $("#c").val();
						var termino = $("#q").val();
						var str = 'controller='+controller+'&action=Index&q='+termino;
						 
							$("#loader").css("display","block");
							$.get("index.php",str,function(data){
								$("#cont").html(data);
							});
	
                }
   });
	
});
