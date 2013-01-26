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
			url: _hostRoot+"/async/threads/create.php",
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
	jq(document).on("click", ".navLink", function(ev) {
		
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
	
	jq(document).on('click', '.thread', function(ev) {
		// Stop Bubling
		ev.preventDefault();
		
		// Set all threads unselected
		jq('.thread').removeClass('selected');
		
		// Set this thread selected
		jq(this).addClass('selected');
		
		// Disable button
		jq("#sendMessage").attr("disabled", "disabled");
		
		// Call Parameters
		var url_var = "tid="+jq(this).data("tid");
		
		// Call Message Viewer Control (Ajax)
		jq.ajax({
			url: _hostRoot+"/async/messages/load.php",
			data: url_var,
			type: "GET",
			dataType: "html",
			success: function(data) {
				// Append Messages
				console.log(data);
				
				if (jq("#messageList").contents().length != 0)
				{
					jq("#messageList").find('.messages').empty().replaceWith(jq(data).get(0));
					//jq(data).get(0).children.appendTo();
				}
				else
				{
					jq(data).appendTo(jq("#messageList").empty());
				}
				
				jq("#sendMessage").removeAttr("disabled");
				
				// Trigger window resize to set messageList height
				jq(window).trigger("resize");
				
				// Scroll messageList to bottom
				var height = jq('.messages').get(0).scrollHeight;
				jq('.messages').scrollTop(height);
				
			},
			complete: function(ev) {
			},
			error: function(ev) {
			}
		});
	});
	
	// Create New Thread
	jq(document).on("click", "#newThread", function(ev) {
		// Stop Bubling
		ev.preventDefault();
		
		// Get Parameters
		var postVars = jq(this).closest('form').serialize();
		
		// Call Message Viewer Control (Ajax)
		jq.ajax({
			url: _hostRoot+"/async/threads/create.php",
			data: postVars,
			type: "POST",
			dataType: "html",
			success: function(data) {
				// Debugging
				console.log(data);
				//jq(data).appendTo(jq("#messageList").empty());
				
			},
			complete: function(ev) {
			},
			error: function(ev) {
				console.log(ev);
			}
		});
		
	});
	
	// Send Thread Message
	jq(document).on("click", "#sendMessage", function(ev) {
		// Stop Bubling
		ev.preventDefault();
		
		// Get Parameters
		var postVars = jq(this).closest('form').serialize();
		
		// Call Message Viewer Control (Ajax)
		jq.ajax({
			url: _hostRoot+"/async/messages/send.php",
			data: postVars,
			type: "POST",
			dataType: "html",
			success: function(data) {
				// Debugging
				jq('.textInput').children('textarea').first().val("");
				jq('.thread.selected').trigger("click");
				
			},
			complete: function(ev) {
			},
			error: function(ev) {
				console.log(ev);
			}
		});
		
	});
	
	// Refresh message list interval
	var refreshMessagesInterval;
	
	var refreshMessages = function() {
		jq('.thread.selected').trigger("click");
	}
	
	jq(document).on("keydown", "#threadMessage", function(ev) {
		clearInterval(refreshMessagesInterval);
		
		if (ev.which == 13)
		{
			// Prevent Default Action
			ev.preventDefault();
			
			// Press send Button
			jq(this).closest('form').find('button').trigger("click");
		}
	});
	
	jq(document).on("keyup", "#threadMessage", function(ev) {
		clearInterval(refreshMessagesInterval);
		refreshMessagesInterval = setInterval(refreshMessages, 5000);
	});
	
	
	jq(window).on('resize', function(ev) {
		var value = jq("#messageList").outerHeight() - jq("#chatControls").outerHeight();
		jq(".messages").height(value);
	});
});