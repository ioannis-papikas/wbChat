/*____________________ chatroom.js ____________________*/
 
// jQuery part
// change annotation from "$" to "jq"
var jq=jQuery.noConflict();

jq(document).one("ready", function() {
	jq("#userControl").on("click", function(ev) {
		var userArea = jq(this).closest('#userArea');
		jq('.navMenu', userArea).first().slideToggle('fast');
	});
});