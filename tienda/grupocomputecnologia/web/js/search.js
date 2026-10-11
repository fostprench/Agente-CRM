$(function() {

controller=$('#c').val();

$("#_buscar").click(function(){
var q=$('#q').val();
var p=$('#p').val();
str="index.php?controller="+controller+"&action=index&q="+q+"&p="+p
$.get(str,function(data){
 $("#cont").html(data);
 $('#q').val(q);
});
 
});

});