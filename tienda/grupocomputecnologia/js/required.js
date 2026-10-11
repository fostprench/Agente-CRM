/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
(function( $ ){
  $.fn.required = function() {
    if ( $(this).val() == '' ) {
        $(this).addClass('alert alert-dange');
        $(this).focus();
        return false;
    }else {
        $(this).removeClass('alert alert-dange')
        return true;
    }
  };
})( jQuery );

