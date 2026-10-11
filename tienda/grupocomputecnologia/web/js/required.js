/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
(function( $ ){
  $.fn.required = function() {
    if ( $(this).val() == '' ) {
        $(this).addClass('ui-state-error');
        $(this).focus();
        return false;
    }else {
        $(this).removeClass('ui-state-error')
        return true;
    }
  };
  /*
  //
  //
  */
  $.fn.email=function()
  {
   var filtro=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
     if ( $(this).val() == '' ) {
        $(this).addClass('ui-state-error');
        $(this).focus();
        return false;
    }else {
        $(this).removeClass('ui-state-error')
		   if (filtro.test($(this).val()))
           return true;
		   else
		   {
		     alert("ingrese un email valido!")
		     $(this).focus();
		     return false;
		   }
    }
  }
})( jQuery );
