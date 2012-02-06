$(document).ready(function() {
	// TODO -  Grey out change button until passwords the same
   $("#changeButton").click(function(event){
		requestChange(event);
	});
});


function requestChange(event) {
	// lock form
	$('#changePasswordForm :input').each( function (index,el) {
		el.disabled = "disabled";
	});

	// Retrieve data
	var inputdata = {};
	$('#user,#realm,#password,#newpassword1,#newpassword2').each( function (index,el) {
		inputdata[el.id] = el.value;
	});
	if ($('#newpassword1').get(0).value == $('#newpassword2').get(0).value)
		inputdata["newpassword"] = $('#newpassword1').get(0).value;

	$.ajax(
		{
			url: "rpc.php",
		    type: "POST",
		    contentType: "application/json",
			dataType: "json",
   		 	data: $.toJSON({"jsonrpc": "2.0",
							"method": "update_password",
							"params": [inputdata],
							"id": 1
							}),  		
    		success: function(response) { returnChange(response); }
		});

};

function returnChange(data) {
	if (data.error == null) {
		$("#message").html("<p>Password changed</p>");
		$("#message").addClass('good');
	} else {
		$("#message").html("<p>Error "+ data.error + "</p>");
		$("#message").addClass('bad');
		$('#changePasswordForm :input').each( function (index,el) {
			el.disabled = null;
	});

	}

};
