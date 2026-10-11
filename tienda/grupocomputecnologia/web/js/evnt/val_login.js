function validar_numero(){
if(event.keyCode<48 || event.keyCode>57){event.returnValue = false;}
}


	
$(document).ready(function() 
{
	$("#login").focus();
	var icono = '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>';
	$("#ingresar").click(function()
	{
		bval = true;
	    bval = bval && $("#login").required();
	    bval = bval && $("#clave").required();
	    bval = bval && $("#codigo").required();
		if ( bval ) 
		{
			if($("#codigo").val()==CodVali)
			{                
				$("#loader").css("display","block");
				$("#msg").css("display","none");
				str=$("#frmperfil").serialize();  
				console.log(str);
				$.post("process.php",str,function(data){
					console.log(data);
				if(data.rep=="1")
				{
					window.location="index.php";
				}
				else 
				{
					$("#loader").css("display","none");
					$("#msg").html(icono+' '+data.msg);
					$("#msg").show("slow");}
				},'json');
			}
			else 
			{
				$("#msg").html(icono+" <strong>Codigo de Verficacion incorrecto</strong>");$("#msg").show("slow");
			}
		}
        return false;
		
		
	});
	
	   $("#codigo").keyup(function(evt){
        var keyPressed = (evt.which) ? evt.which : event.keyCode
		if (keyPressed==13)
                {
				
				
						bval = true;
						bval = bval && $("#login").required();
						bval = bval && $("#clave").required();
						bval = bval && $("#codigo").required();
						if ( bval ) 
						{
							if($("#codigo").val()==CodVali){ 
								$("#loader").css("display","block");
								$("#msg").css("display","none");
								str=$("#frmperfil").serialize();  
								$.post("process.php",str,function(data){
									if(data.rep=="1")
									{
										window.location="index.php";
									}
									else 
									{
										$("#loader").css("display","none");
										$("#msg").html(icono+' '+data.msg);
										$("#msg").show("slow");
									}
								},'json');
							}
							else 
							{
								$("#msg").html(icono+" <strong>Codigo de Verficacion incorrecto</strong>");$("#msg").show("slow");
							}
						}
						return false;
						
						
                }
   });
   
   
	   $("#login").keyup(function(evt){
			var keyPressed = (evt.which) ? evt.which : event.keyCode
			if (keyPressed==13){
				$("#clave").focus();
			}
		});
		
		 $("#clave").keyup(function(evt){
			var keyPressed = (evt.which) ? evt.which : event.keyCode
			if (keyPressed==13){
				$("#codigo").focus();
			}
		});
	
});

  