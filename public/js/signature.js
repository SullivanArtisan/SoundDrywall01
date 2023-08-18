function signatureCapture(sig_id) {
	var canvas = document.getElementById(sig_id);
	var context = canvas.getContext("2d");
	canvas.width = 400;
	canvas.height = 120;
	context.fillStyle = "#fff";
	context.strokeStyle = "#444";
	context.lineWidth = 1.5;
	context.lineCap = "round";
	context.fillRect(0, 0, canvas.width, canvas.height);
	var disableSave = true;
	var pixels = [];
	var cpixels = [];
	var xyLast = {};
	var xyAddLast = {};
	var calculate = false;
	{ 	
		function remove_event_listeners() {
			canvas.removeEventListener('mousemove', on_mousemove, false);
			canvas.removeEventListener('mouseup', on_mouseup, false);
			canvas.removeEventListener('touchmove', on_mousemove, false);
			canvas.removeEventListener('touchend', on_mouseup, false);

			document.body.removeEventListener('mouseup', on_mouseup, false);
			document.body.removeEventListener('touchend', on_mouseup, false);
		}

		function get_coords(e) {
			var x, y;

			if (e.changedTouches && e.changedTouches[0]) {
				var offsety = canvas.offsetTop || 0;
				var offsetx = canvas.offsetLeft || 0;

				x = e.changedTouches[0].pageX - offsetx;
				y = e.changedTouches[0].pageY - offsety;
			} else if (e.layerX || 0 == e.layerX) {
				x = e.layerX;
				y = e.layerY;
			} else if (e.offsetX || 0 == e.offsetX) {
				x = e.offsetX;
				y = e.offsetY;
			}

			return {
				x : x,
				y : y
			};
		};

		function on_mousedown(e) {
			e.preventDefault();
			e.stopPropagation();

			canvas.addEventListener('mouseup', on_mouseup, false);
			canvas.addEventListener('mousemove', on_mousemove, false);
			canvas.addEventListener('touchend', on_mouseup, false);
			canvas.addEventListener('touchmove', on_mousemove, false);
			document.body.addEventListener('mouseup', on_mouseup, false);
			document.body.addEventListener('touchend', on_mouseup, false);

			empty = false;
			var xy = get_coords(e);
			context.beginPath();
			pixels.push('moveStart');
			context.moveTo(xy.x, xy.y);
			pixels.push(xy.x, xy.y);
			xyLast = xy;
		};

		function on_mousemove(e, finish) {
			e.preventDefault();
			e.stopPropagation();

			var xy = get_coords(e);
			var xyAdd = {
				x : (xyLast.x + xy.x) / 2,
				y : (xyLast.y + xy.y) / 2
			};

			if (calculate) {
				var xLast = (xyAddLast.x + xyLast.x + xyAdd.x) / 3;
				var yLast = (xyAddLast.y + xyLast.y + xyAdd.y) / 3;
				pixels.push(xLast, yLast);
			} else {
				calculate = true;
			}

			context.quadraticCurveTo(xyLast.x, xyLast.y, xyAdd.x, xyAdd.y);
			pixels.push(xyAdd.x, xyAdd.y);
			context.stroke();
			context.beginPath();
			context.moveTo(xyAdd.x, xyAdd.y);
			xyAddLast = xyAdd;
			xyLast = xy;

		};

		function on_mouseup(e) {
			remove_event_listeners();
			disableSave = false;
			context.stroke();
			pixels.push('e');
			calculate = false;
		};
	}
	canvas.addEventListener('touchstart', on_mousedown, false);
	canvas.addEventListener('mousedown', on_mousedown, false);
}


function signaturedSave() {
	var fin = confirm("You are about to Finish this Job, Proceed?");
	if(fin){
		var canvas = document.getElementById("signatureForTask");
		var dataURL = canvas.toDataURL("image/png");
		document.getElementById("saveSignature").src = dataURL;
		//console.log(dataURL);
		
		var pudid = document.getElementById('pudid').innerHTML;
		//alert("pudid: "+pudid);
		var transaction1 = db1.transaction("allview","readwrite");
	    var objectStore1 = transaction1.objectStore("allview");
	    objectStore1.openCursor().onsuccess = function(event) {
	        var cursor = event.target.result;
	        if(cursor){
	        	if(cursor.value.pud_Id==pudid){
	        		cursor.value.Sig=dataURL;
	        		cursor.value.ftime = new Date().toISOString().slice(0, 19).replace('T', ' ');
                    if(cursor.value.Item_Status <= 15) {
                        cursor.value.Item_Status=parseInt(cursor.value.Item_Status)+1;
                    }
                    if ((cursor.value.Status % 2) == 0) {
                        cursor.value.Status = parseInt(cursor.value.Status)+1;
                    } 	  
	        	}
	        	if(cursor.value.Orig==pudid) {
                    //alert("Should be here");
                    cursor.value.Item_Status = 13;
                } 
			    cursor.update(cursor.value);  	 
	        	cursor.continue();
	        }
	    };
	    document.getElementById('sig').setAttribute('style','display:none');
	    //alt();
	    //console.log('signatureSave');
	    getLocation();
  	}
}

function errorHandler(err) {
    if(err.code == 1) {
        console.log("Error: Access is denied!");
    } else if( err.code == 2) {
        console.log("Error: Position is unavailable!");
    }
}

// Changes to function getLocation made to try and increase accuracy of GPS location
// Original: navigator.geolocation.getCurrentPosition(showPosition, errorHandler, options);
// Change:   navigator.geolocation.watchPosition(showPosition, errorHandler, options);
  
function getLocation(){
	if (navigator.geolocation) {
		console.log("Getting location");
		var options = {timeout:60000};
		navigator.geolocation.watchPosition(showPosition, errorHandler, options);
	} else {
		console.log('no');
	}	
}

function showPosition(position){
	var pudid = document.getElementById('pudid').innerHTML;
	var lat = position.coords.latitude;
	var lng = position.coords.longitude;
	
	var transaction1 = db1.transaction("allview","readwrite");
    var objectStore1 = transaction1.objectStore("allview");
    objectStore1.openCursor().onsuccess = function(event) {
        var cursor = event.target.result;
	
        if (cursor) {
        	if (cursor.value.pud_Id == pudid) {
        		console.log("Storing long/lat");
        		cursor.value.Latitude = lat;
        		cursor.value.Longitude = lng;
        		cursor.value.Priority = 5;
        		cursor.update(cursor.value);
        	}
        	cursor.continue();
        } else {
        	finalmove();
        
        }
    };   
}

function signatureClear() {
	var canvas = document.getElementById("signatureForTask");
	var context = canvas.getContext("2d");
	context.clearRect(0, 0, canvas.width, canvas.height);
	var canvas = document.getElementById("signatureForTask_shadow");
	var context = canvas.getContext("2d");
	context.clearRect(0, 0, canvas.width, canvas.height);
}

function alt(){
	var pudid = document.getElementById('pudid').innerHTML;
	var transaction1 = db1.transaction("allview","readwrite");
    var objectStore1 = transaction1.objectStore("allview");
    objectStore1.openCursor().onsuccess = function(event) {
        var cursor = event.target.result;
	
        if(cursor) {
        	if(cursor.value.pud_Id == pudid){
        		cursor.value.Priority = 5;
        		//cursor.value.ftime = Date().toLocaleString();
        		cursor.update(cursor.value);
        	}
        	cursor.continue();
        } else {
        	finalmove();
        }
    };
}