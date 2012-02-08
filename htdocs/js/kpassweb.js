/* kpassweb.js
 * Main jQuery functions to communicate with PHP backend for running password
 * changes.
 *
 * This file and it's surrounding application is licensed under version 3 of
 * the GNU General Public License. Further information can be found in the
 * LICENSE file in the root of this application.
 *
 * Copyright Edward Murrell, 2012
 * edward@murrell.co.nz
 */

$(document).ready(function() {
	// TODO - Grey out change button until passwords the same
	// TODO - Use real id numbers for RPC events
	// TODO - force check for SSL
	getRealms();
	$("#changeButton").click(function(event){
		requestChange(event);
	});
	$("#newpassword1,#newpassword2").keyup(function(event){
		checkNewPass(event);
	});
});


function requestChange(event) {
	disableForm(); // lock form

	// Retrieve data
	var inputdata = {};
	$('#user,#realm,#password,#newpassword1,#newpassword2').each( function (index,el) {
		inputdata[el.id] = el.value;
	});
	if ($('#newpassword1').get(0).value == $('#newpassword2').get(0).value)
		inputdata["newpassword"] = $('#newpassword1').get(0).value;
	else {
		setError('New passwords do not match.');
		enableForm();
		return false;
	}
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
		$("#message").removeClass('bad');
		$('#password').get(0).value = '';
		$('#newpassword1').get(0).value = '';
		$('#newpassword2').get(0).value = '';
	} else {
		setError("Error: "+ data.error);
		$('#password').get(0).value = '';
		$('#newpassword1').get(0).value = '';
		$('#newpassword2').get(0).value = '';
		enableForm();
	}
};

function setError(text) {
		$("#message").html("<p>"+text+"</p>");
		$("#message").addClass('bad');
		$("#message").removeClass('good');
}
function enableForm () {
		$('#changePasswordForm :input').each( function (index,el) {
			el.disabled = null;
		});
}
function disableForm () {
		$('#changePasswordForm :input').each( function (index,el) {
			el.disabled = 'disabled';
		});
}
function checkNewPass (event) {
	var p1 = $('#newpassword1').get(0).value;
	var p2 = $('#newpassword2').get(0).value;
	if (p1 == '' && p2 == '' || p1 == p2) {
		$('#changeButton').get(0).disabled = null;
		return;
	} else {
		$('#changeButton').get(0).disabled = 'disabled';
	}
}

function getRealms() {
	$.ajax({
			url: "rpc.php",
		    type: "POST",
		    contentType: "application/json",
			dataType: "json",
   		 	data: $.toJSON({"jsonrpc": "2.0",
							"method": "get_realms",
							"params": [null],
							"id": 1
							}),  		
    		success: function(response) { updateRealms(response); }
		});
};

function updateRealms(data) {
	if (data.result == null) {
		disableForm();
		setError('Server has not been configured.');
	} else {
		$.each(data.result, function(i, realm) {
	    	$('#realm')
        	.append($('<option></option>')
        	.attr('value',realm)
        	.text(realm));
		});
	}
}
