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
		
		// Stop Bubling
		ev.preventDefault();
		
		// Call Parameters
		var url_var = "view="+jq(this).attr("id");
		
		// Call Thread Viewer Control (Ajax)
		jq.ajax({
			url: _hostRoot+"/async/threads/load.php",
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
        
        /* Assign click handlers to the user links in the sidebar list. */
//        jq('#usersList .userLink').click(function(event) {
//            event.preventDefault();
//            event.stopPropagation();
//            
//            var otherUserId = jq(this).attr('href');
//            
//            jq.ajax({
//                data: 'otherUserId=' + otherUserId
//                ,dataType: 'html'
//                ,error: function(jqXHR, textStatus, errorThrown) {
//                    console.log(textStatus);
//                    console.log(errorThrown);
//                }
//                ,success: function(data, textStatus, jqXHR) {
//                    jq('#messageCenter').append(data);
//                }
//                ,type: 'GET'
//                ,url: _hostRoot + '/async/messages/create.php'
//            });
//        });
});