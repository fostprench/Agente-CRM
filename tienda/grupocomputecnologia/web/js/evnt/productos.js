var band=0;
$(function()
{ 
	$("#idtipo").focus();
	
	$("#idtipo").change(function(){
		$("#idmarca").focus();
	});
	
	$("#idmarca").change(function(){
		$("#descripcion").focus();
	});
	
	$("#descripcion" ).keypress(function(e) {
			if (e.which == 13) {
				$("#informacion").focus();
			}		
	});
	
	$("#informacion").keypress(function(e) {
			if (e.which == 13) {
				$("#grabar").focus();
			}		
	});
	
	$("#_form").submit(function()
	{   
		bval = true;
	    bval = bval && $( "#idtipo" ).required();
	    bval = bval && $( "#idmarca" ).required();
	    bval = bval && $( "#idmodelo" ).required();
	    bval = bval && $( "#descripcion" ).required();
 
		if ( bval ) 
		{
			ver_msg(0,"..::Guardando::..");
			str = $(this).serialize();
			
			if($("#mostrar_web").is(':checked')) {  
            estado = 1; 
            } else {  
            estado = 0;
            }
			
		    str = str +'&web='+estado;
			//alert(str);
			$.post('index.php','controller=Productos&action=save&'+str,function(data)
		    {   
				if(data.rep=="1")
			    {
					msg(1,'Datos grabados correctamente','controller=Productos'); // insertar
				}
				if(data.rep=="2")
				{
					ver_msg(2,'Datos modificados correctamente'); //editar
				}
			},'json');
		}
        return false;
	});
	 
	$("#file_upload").click(function(){
		$('#image_file').show().focus().click().hide();
	});
	
	$("#image_file").change(function(){
		dir = $('#image_file').val();
		//Valido la Extencion del Archivo Cargado
		enviar = /.(gif|jpg|png)$/i.test(dir);
		if (!enviar){alert("Solo se Aceptan Formatos de imagen .jpg .gif .png ");document.getElementById('image_file').value='';return false;}

		var file = $('#image_file')[0].files[0];
		console.log("nombre de la imagen: "+file.name);
		var id = "progress_bar";
		var previa = "vista_previa";
		peticionAjax(file,id,previa);
		 
	});

});

//los stylos del pogress_bar esta es css/progres_bar.css
var i=0;
function peticionAjax(file,id_box,previa){
		i++;
		var formData = new FormData();
		formData.append('obj', file);
		formData.append('numero', i);
		formData.append('opcion', 1);
		
		$("#"+previa).empty();
		
		$.ajax({
			url:'controller/UploadController.php',
			type:'POST',
			//esto nos devuelve el porcentaje de progreso
			xhr: function() {
           		var myXhr = $.ajaxSettings.xhr();
           		if(myXhr.upload){
						console.log("SUBIENDO IMAGEN VIA AJAX");
						$("#"+id_box).css({
											"opacity":"1",
											"display":"block"
										});
						console.log("agrega la clase a id: "+id_box);
             			myXhr.upload.addEventListener('progress',function(event){
           				var porcentaje = 0;
						var posicion = event.loaded || event.position;
						var total = event.total;
    					if(event.lengthComputable){
    						porcentaje = Math.ceil(posicion / total * 100) + '%';
       						$('#'+id_box+' .porcentaje').width(porcentaje);
       						$('#'+id_box+' .porcentaje').html(porcentaje);
    					}
           			}, false);
       			}
           		return myXhr;
       		},
			data:formData,
			cache: false,
       		contentType: false,
       		processData: false,
       		//si todo marcho bien, sacamos la barra de progreso y mostramos la imagen
			success:function(data){
				console.log("SUCCESS IMAGEN :D");
				$("#"+id_box).css("display","none");
				var img = "<img class='img-responsive' wight='250px' height='250px' />";
				$('#'+previa).html(img);;
				$('#'+previa+'  img').attr('src', 'web/images/upload/'+data).load(function(){
					$(this).css('display','block');
				});
				//alert("NOMBRE IMAGEN: "+data);
				if(id_box=="progress_bar"){$("#imagen_producto").val(data);}				
				$("#"+id_box).css('opacity',0);
				$('#'+id_box+' .porcentaje').width(0);
       			$('#'+id_box+' .porcentaje').html("0%");
				//alert("Archivo Subido "+data);
				//document.getElementById('vista_previa').innerHTML = data;
			},
			//si surgio un error, lo mostramos por consola
			error:function(data){
				alert('Ocurrio un error y no se pudo subir la imagen. '+data);
				console.log("ERROR :( "+data);
			}
		});
		
}


function atras()
{
	paginacion('controller=Productos&id=8');
}



	