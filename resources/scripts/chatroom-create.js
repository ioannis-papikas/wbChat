// jQuery part
jq(document).ready(function() {
        
    /* Assign click handlers to the user links in the top list. */
    jq('#usersList .userLink').click(function(event) {
        event.preventDefault();
        event.stopPropagation();
        jq('.newThreadContainer').show('slow');
            
        /* Click handler for the Send Button. */
        var otherUserId = jq(this).data('userId');
        jq('.sendButton').click(function() {
            var message = jq('.newThreadContainer .message').val();
            console.log(message);
        
            var data = {
                'message': message
                ,'newThread': true
                ,'otherUserId': otherUserId
            };
        
            jq.ajax({
                data: data
                ,dataType: 'html'
                ,error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus);
                    console.log(errorThrown);
                }
                ,success: function(data, textStatus, jqXHR) {
                    console.log(data);
                    jq('.newThreadContainer').remove();
                    jq('#messageCenter').append(data);
                }
                ,type: 'POST'
                ,url: _hostRoot + '/async/messages/create.php'
            });
        });
    });
});