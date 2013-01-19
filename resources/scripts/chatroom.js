/*____________________ chatroom.js ____________________*/
 
// jQuery part
// change annotation from "$" to "jq"
var jq=jQuery.noConflict();

var _hostRoot = "/___projects/wbChat";

jq(document).one("ready", function() {
	
	// User Menu Controller
	jq("#userControl").on("click", function(ev) {
		var userArea = jq(this).closest('#userArea');
		jq('.navMenu', userArea).first().slideToggle('fast');
	});
	
	// Create New Thread
	jq("#create_newThread").on("click", function(ev) {
		
		// Call Thread Viewer Control (Ajax)
		jq.ajax({
			url: _hostRoot+"/async/messages/create.php",
			type: "GET",
			dataType: "html",
			success: function(data) {
				// Debugging
				console.log(data);
				jq(data).appendTo(jq("#messageCenter").empty());
			},
			complete: function(ev) {
			},
			error: function(ev) {
			}
		});
	});
	
	// Chat Navigation Controller
	jq(".navLink").on("click", function(ev) {
		
		// Call Parameters
		var url_var = "view="+jq(this).attr("id");
		
		// Call Thread Viewer Control (Ajax)
		jq.ajax({
			url: _hostRoot+"/async/messages/load.php",
			data: url_var,
			type: "GET",
			dataType: "html",
			success: function(data) {
				// Debugging
				console.log(data);
				jq(data).appendTo(jq("#messageCenter").empty());
				
			},
			complete: function(ev) {
			},
			error: function(ev) {
			}
		});
	});
});