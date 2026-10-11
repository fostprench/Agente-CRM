$(function()
{
		var f = new Date();
		var primer_dia = 1 + "-" + (f.getMonth() +1) + "-" + f.getFullYear();
		var hoy = f.getDate() + "-" + (f.getMonth() +1) + "-" + f.getFullYear();
		var aFecha1 = hoy.split('-'); 
		var aFecha2 = primer_dia.split('-'); 
		var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]); 
		var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]); 
		var dif = fFecha1 - fFecha2;
		var dias = Math.floor(dif / (1000 * 60 * 60 * 24)); 
		//dias++;

	 $("#fecha_r").datepicker({
		format: "dd-mm-yyyy",
		weekStart: 0,
		todayBtn: "linked",
		language: "es",
		multidateSeparator: "-",
		autoclose: true,
		todayHighlight: true,
		startDate: '-'+dias+'d',
		endDate: '-0d'
	});
	
	
});


