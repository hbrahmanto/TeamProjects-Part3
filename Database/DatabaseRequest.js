function DatabaseRequest(url, callback) {
	// Function for calling asnychronus requests to the database, with given file and parameters using get
	// -- url --
		// url should be in form: "[phpfile].php?[parameter1]=[value]"
		// (for multiple parameters): "[phpfile].php?[parameter1]=[value]&[parameter2]=[value]..."
	// -- callback --
		// The function that is called after the server has fufilled the request,
		// which handles the logic dealing with the asynchronus data's arrival
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onload = function() {
		let data = JSON.parse(this.response);
		if (this.readyState == 4 && this.status == 200) {
			callback(data);
		}
    };
	xmlhttp.open("GET",url,true);
    xmlhttp.send();
};

function DatabaseRequestPost(url, callback, values) {
	// Function for calling asnychronus requests to the database, with given file and parameters using post
	// -- url --
		// url should be in form: "[phpfile].php"
	// -- callback --
		// a function that is called after the server has fufilled the request,
		// which handles the logic dealing with the asynchronus data's arrival
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onload = function() {
		let data = JSON.parse(this.response);

		if (this.readyState == 4 && this.status == 200) {
			callback(data);
		}
    };
	xmlhttp.open("POST",url,true);
    
	//console.log(JSON.stringify(values))
    xmlhttp.send(JSON.stringify(values));
};