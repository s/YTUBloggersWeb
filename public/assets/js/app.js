$(function(){
	$( "#submitForm" ).validate({
		rules: {
			url: {
				required: true,
				url: true			
			},
			email:{
				required:true,
				email:true		
			}
		}
	});
});