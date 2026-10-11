function valida_password()
{
      bval = true;
	    bval = bval && $("#password").required();
		if(bval){
		 
          var pass = $("#password").val();
                $.post("index.php","controller=User&action=validar_pass&pass="+pass,function(data){		
                    if(data.rep=="1" ){
                        $("#msg,#c1").fadeOut();
                        $("#clave,#clave2").attr("disabled",false);
                        $("#clave").focus();
                        $("#cambiar_clave").css("display","block");
                    }
                     else {
					  $("#msg").hide("slow");
					  $("#msg").css("display","none");
					  mensaje = '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Password Incorrecto';
					  $("#msg").html(mensaje);
					  $("#msg").css("display","block");
					  $("#msg").show("slow");
					 
                     }
                },'json');
  }
}

	   $("#password").keyup(function(evt){
			var keyPressed = (evt.which) ? evt.which : event.keyCode
			if (keyPressed==13){
				valida_password();
			}
		});


function change_password()
{
       bval = true;
	    bval = bval && $( "#clave").required();
	    bval = bval && $( "#clave2").required();
		if(bval)
		{
		  var c= $( "#clave").val();
		  var c1= $( "#clave2").val();
		  if(c==c1)
		  {
		    $.post("index.php","controller=User&action=change&clave="+c,function(data)
			{ 
			   if(data.rep=="1")
			  {
			  $("#msg").css("color","");
			    ver_msg(2,data.msg)
			   
				;
			  }else
			  {
				  $("#msg").hide("slow");
				  $("#msg").css("display","none"); 
				  $("#msg").css("color","red");
				  $("#msg").html("no se pudo cambiar password");
				  $("#msg").css("display","block");
				  $("#msg").show("slow");
			  }
			
			},'json');
			return false;
		  }
		  else
		  {   $("#msg").hide("slow");
		      $("#msg").css("display","none");
			   $("#msg").css("color","red");
			  $("#msg").html('Las claves no coinciden');
			  $("#msg").css("display","block");
			  $("#msg").show("slow");			  
		  }
		}
}

  