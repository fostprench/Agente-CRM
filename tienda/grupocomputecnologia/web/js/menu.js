(function($) {
$.fn.Menu = function(menu) 
{
  this.each(function()
  {
    var NombreMenu=$(this);
	
	
    jQuery.each(menu, function() 
    {
		  var capa=$("<li class='dropdown'></li>");
		  NombreMenu.append(capa);
		  var Base = $('<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <span class="'+this.icono+'" aria-hidden="true"></span> '+this.texto+'<span class="caret"></span></a>');
		  capa.append(Base);
		
		  var capaPadre=$('<ul class="dropdown-menu" role="menu"></ul>');
		  capa.append(capaPadre);
	  
	  
	      jQuery.each(this.enlaces, function()
		   {
			  var capahijo=$('<li></li>');
			  capaPadre.append(capahijo);
			  // var urlsub="'"+this.url+"&id="+this.idmodulo+"'";
			  var urlsub="'"+this.url+"'";
			  var subEnlace = $('<a  href="javascript:cargar_pages(' +urlsub + ')">' + this.texto + '</a>');
		      capahijo.append(subEnlace);
		   });
	  
	  
	});
  });
 return this;
};

 $.fn.setCursorToTextEnd = function() {
        var $initialVal = this.val();
        this.val($initialVal);
    };

})(jQuery);