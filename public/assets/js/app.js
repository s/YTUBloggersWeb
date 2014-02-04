$(function(){
	$( "#search_form_container").on("submit",function(e){
		if($(this).find("#q").val() == ''){
			e.preventDefault();
		}
	});
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

	$( "#apiForm" ).validate({
		rules: {
			client_id: {
				required: true				
			},
			email: {
				required: true,
				email:true			
			}
		}
	});
	$("#loginForm").validate({
		rules:{
			username:{
				required:true
			},
			password:{
				required:true
			}
		}
	});
	$("#settingsForm").validate({
		rules:{
			password:{
				required:true
			},
			new_password:{
				required:true,
				minlength:6
			},
			new_password_again:{
				required:true,
				equalTo:"#new_password"
			}
		}
	});

	$("#addAdminForm").validate({
		rules:{
			username:{
				required:true
			},
			password:{
				required:true
			},
			email:{
				required:true,
				email:true		
			}
		}
	});

	$("#newsletterForm").validate({
		rules:{			
			email:{
				required:true,
				email:true		
			}
		},
		messages:{
			email:{
				required:""
			}
		}
	});

	$("body").on("click","#search_icon",function(e){
		
		$(this).addClass("hide");
		$("#search_form_container").removeClass("hide");
		$("#search_form_container input#q").focus();
	});

	$('.container').on("click",function(e){
		if("q" != e.target.getAttribute("id")){
			$("#search_form_container").addClass("hide");
			$("#search_icon").removeClass("hide");
		}
	})
});