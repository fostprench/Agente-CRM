$(function()
{  
	
	
	
	$("#tipo_c").focus();

	$("#tipo_c").change(function(){
		idd = $(this).val();
	
         if(idd==1)
		 {
			  $(".style_razon").removeClass("show").addClass("hide");
			  $('.style_nombres').removeClass("hide").addClass("show");
			  $("#nombres").focus();
		 }
		 if(idd==2)
		 {
			 $('.style_nombres').removeClass("show").addClass("hide");
			 $(".style_razon").removeClass("hide").addClass("show");
			 $("#raz_social").focus();
		 }
	});
	
	
	
	$("#nombres").keypress(function(e) {
        if (e.which == 13) {
            $("#dni").focus();
        }
    });
	
	$("#raz_social").keypress(function(e) {
        if (e.which == 13) {
            $("#ruc").focus();
        }
    });
	
	$("#ruc").keypress(function(e) {
        if (e.which == 13) {
            $("#direccion").focus();
        }
    });
	
	$("#dni").keypress(function(e) {
        if (e.which == 13) {
            $("#direccion").focus();
        }
    });
	
	$("#direccion").keypress(function(e) {
        if (e.which == 13) {
            $("#email").focus();
        }
    });
	
	$("#direccion").keypress(function(e) {
        if (e.which == 13) {
			if($("#tipo_c").val()==1){
				$("#email").focus();
			}else{
				$("#telefono").focus();
			}
        }
    });
	
	$("#email").keypress(function(e) {
        if (e.which == 13) {
            $("#telefono").focus();
        }
    });
	
	$("#telefono").keypress(function(e) {
        if (e.which == 13) {
            $("#observaciones").focus();
        }
    });
	
	$("#observaciones").keypress(function(e) {
        if (e.which == 13) {
            $("#grabar").focus();
        }
    });
	
	
	// $("#_form").keypress(function(e) {
        // if (e.which == 13) {
            // return false;
        // }
    // });
	
	$("#grabar").keypress(function(e) {
        if (e.which == 13) {
            agregar(); return false;
        }
    });
	
	$("#grabar").click(function() {
            agregar(); return false;
    });

	function agregar()
	{            
		  bval = true;
		bval = bval && $( "#tipo_c" ).required();
	   	  if(bval&& $( "#tipo_c" ).val()==1)
		{	
		  bval = bval && $( "#nombres" ).required();
	      //bval = bval && $( "#dni" ).required();
	      //bval = bval && $( "#ubigeo" ).required();
		}
		  if(bval&& $( "#tipo_c" ).val()==2)
		{
		  bval = bval && $( "#raz_social" ).required();
	      bval = bval && $( "#ruc" ).required();
		  
		}
		
	      bval = bval && $( "#fecha" ).required();
		 
		 
		 
		if ( bval ) 
		{
			 if($( "#tipo_c" ).val()==1)
			{
				if($("#dni" ).val()){
					var myString = $("#dni").val();
					var tamanio = myString.length;
					if(tamanio<8){alert('DNI incorrecto, Verifique que Tenga 8 Digitos');$("#dni").focus();return false;}
				}
			}
			if(bval&& $( "#tipo_c" ).val()==2)
			{
				var myString = $("#ruc").val();
				var tamanio = myString.length;
				if(tamanio<11){alert('RUC incorrecto, Verifique que Tenga 11 Digitos');$("#ruc").focus();return false;}
		 
			}
		
			fecha = $("#fecha").val();
			fecha_ = formato_fecha(fecha);
		  
			ver_msg(0,"..::Guardando::..")
			str = $("#_form").serialize();
			str = str+"&fecha_="+fecha_;//alert(str);return false;
			$.post('index.php','controller=Cliente&action=save&'+str,function(data)
		    {
				//alert(data.rep);
				if(data.rep=="1")
			    {
					msg(1,'Datos grabados correctamente','controller=Cliente');
				}
				if(data.rep=="2")
				{
					ver_msg(2,'Datos modificados correctamente');
				}
			},'json');
		}
        return false;
	};

	 $("#fecha").datepicker({
		format: "dd-mm-yyyy",
		weekStart: 0,
		todayBtn: "linked",
		language: "es",
		multidateSeparator: "-",
		autoclose: true,
		todayHighlight: true
	});
	
	$("#cancel").click(function()
		{
		 $("#result").slideDown();
		  $("#res").slideUp();
		  document.getElementById("save").style.visibility="visible";
		});
		
	
});

function formato_fecha(fecha){
var array=fecha.split("-");
var fecha = array[2]+'-'+array[1]+'-'+array[0];
return fecha;
}

function atras()
{
	paginacion('controller=Cliente');
}
function imprimir()
{
	window.open("fpdf/reporte.php?tabla=Cliente");
}