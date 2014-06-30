		// posterity scripts that successfully fetch content from a json file also stored on server?
		// not clear how far back in the revisions one goes to find working versions

		function forEachIn(object, action) {
			for (var property in object) {
			if (Object.prototype.hasOwnProperty.call(object, property))
				action(property, object[property]);
			}
		}
		function forEach(array, action) {
			for (var i = 0; i < array.length; i++)
			action(array[i]);
		}

		var json = $.getJSON("cards.json", function(data) {
			var items = []; // won't work because closure
		    for (var i in data.statements) {
		    items.push(data.statements[i].name); // this way became redundant when I added additional array to cards.json
			}
			// $.each( data, function( key, val ) {
			// console.log(val);
			// items.push( val );
			// });
			console.log(items);
		    //return json.statements; // this will show the info it in firebug console
		    return items;
		});

		function createArray(action){
		    $.getJSON("cards.json", function(json) {
		        var myArray = [];
		        $.each(json, function(key,val) {
		        	//forEach(val, function(v){myArray.push(v.name);}); // creates a single array of any object with a name handle
		            myArray.push(val); // creates an array of arrays of objects
		        });
		        action(myArray);
		        //return myArray; // presumably does nothing because this is the only part still waiting to execute after async
		    });
		}