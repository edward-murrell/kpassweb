//$.post(url, [data], [callback])
//jQuery.post('/rpc', JSON.stringify({method:'echo', params:'Hello
//World', id:1}), function (data){console.log(data);}, 'json') 

$(document).ready(function() {
alert('ready');
   $("#changeButton").click(function(event){
		requestChange(event);
	});
alert('ready2');
});


function requestChange(event) {
	alert("hello");
	// lock form
	var inputdata = new Array();
	var callResult = $.getJSON("rpc.php", {"params": inputdata, "method": "update_password", "id": 1}, returnChange(data));
	// Handle error of callResult here?
};

function returnChange(data) {
	//display result
};
