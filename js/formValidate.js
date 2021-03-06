//
//Email validation script from THE MOLITOR

$(document).ready(function(){

// validate form content
	$("#contactform #submit_btn").click(function() {

	    $("#contactform .input, #contactform textarea").removeClass('error');
		var name = $("#contactform input#name");
		if (name.val() == "") {
			name.addClass('error').focus();
			return false;
		}
		var email = $("#contactform input#email");
		if (email.val() == "") {
	      	email.addClass('error').focus();
	     	return false;
		}
		var message = $("#contactform textarea#message");
		if (message.val() == "") {
	      	message.addClass('error').focus();
	     	return false;
		}
	});
	// alert on success
	if(window.location.hash == "#contact") {
  		$('#contactform').slideUp(800,function(){
  			$('#messageSent').fadeIn(800);
  		});
  	}
});
