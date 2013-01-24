<?php

importer::importCore("profile::user");
importer::importCore("base::DOM");
importer::importCore('domain::threadmodel');

/**
 * The default view of a {@link ThreadModel}.
 *
 * @author Marios
 * @author John
 */
class ThreadView {
    
    private static $KEY_NEW_THREAD = 'newThread';
    private static $KEY_MESSAGE = 'message';
    private static $DEFAULT_THREAD_DESC = 'default';
    private static $DEFAULT_THREAD_SUBJECT = 'untitled';

    /**
     * Checks if this view is about a new {@link ThreadModel}.
     * 
     * @return boolean true if this view is about a new {@link ThreadModel}
     */
    public static function isNewThread() {
        return isset($_POST[self::$KEY_NEW_THREAD]);
    }

    /**
     * Returns the HTML code of a new thread.
     * 
     * @return String the HTML code for a new thread
     */
    public function getNewThreadHtml() {
        $threadDom = new DOM();
        $threadContainer =
                $threadDom->create('div', '', '', 'threadContainer newThreadContainer');
        $threadDom->append($threadContainer);
        $threadText = $threadDom->create('textarea', '', '', 'message');
        $threadDom->append($threadContainer, $threadText);
        $btn = $threadDom->create('button', 'Send', '', 'sendButton');
        $threadDom->append($threadContainer, $btn);

        return $threadDom->getHTML();
    }
    
    /**
     * 
     * @return String the HTML code for the chat
     */
    public function display() {
        if (!$this->isNewThread()) {
            return $this->getDefault();
        }
        
        $userIds = array( $_COOKIE['user'], $_POST['otherUserId'] );
        $this->saveNewThread($userIds);
        
        return $this->getChatView();
    }

    /**
     * Returns the HTML code for the view displayed when on chat.
     * 
     * @return String the HTML code for the view when on chat
     */
    private function getChatView() {
        $messageDOM = new DOM();
        $container = $messageDOM->create('div', '', '', 'textContainer');
        $messageDOM->append($container);

        $threadText = $messageDOM->create('div', $this->getMessageBody(), '', 
                'message');
        $messageDOM->append($container, $threadText);

        $html = $messageDOM->getHTML();

        $messageDOM = new DOM();
        $container = $messageDOM->create('div', '', '', 'textContainer');
        $messageDOM->append($container);

        $threadText = $messageDOM->create('textarea', '', '', 'message');
        $messageDOM->attr($threadText, 'placeholder', 'Write your text...');
        $messageDOM->append($container, $threadText);

        $sendButton = $messageDOM->create('button', 'Send', '', 'sendButton');
        $messageDOM->append($container, $sendButton);

        $html .= $messageDOM->getHTML();
        
        return $html;
    }

    /**
     * Returns the initial view of a {@link ThreadModel}.
     * 
     * @return String the HTML code for the view
     */
    private function getDefault() {
        return $this->createUsersList() . $this->getNewThreadHtml();

        /*        $html .= '<script src="<?php echo siteRoot . systemResources; ?>
          /scripts/chatroom-create.js"></script>'; */
    }

    /**
     * Returns true if a message has been sent.
     * 
     * @return boolean true if a message has been sent
     */
    public function hasMessage() {
        return isset($_POST[self::$KEY_NEW_THREAD]);
    }

    /**
     * Creates the HTML code for the users list.
     * 
     * @return String the HTML code of the users list
     */
    private function createUsersList() {
        $html = '<div id = "usersList">';

        $usersListDom = new DOM();
        $usersList = $usersListDom->create("ul");
        $usersListDom->append($usersList);

        $userExceptIds = array($_COOKIE['user']);
        $users = user::getUsers($userExceptIds);
        foreach ($users as $user) {
            $usersListItem = $usersListDom->create("li", $user['username'], $user['id']);
            $usersListDom->attr($usersListItem, 'data-user-id', $user['id']);
            $usersListDom->attr($usersListItem, 'class', 'userLink');
            $usersListDom->append($usersList, $usersListItem);
        }

        $html .= $usersListDom->getHTML();
        $html .= '</div>';

        return $html;
    }

    /**
     * Retrieves the body of the message that was sent.
     * 
     * @return String the body of the message
     */
    private function getMessageBody() {
        return $_POST[self::$KEY_MESSAGE];
    }
    
    /**
     * Saves the new thread.
     * 
     * @param array $userIds The IDs of the users chatting.
     */
    private function saveNewThread($userIds) {
        $thread = new ThreadModel();
        
        return $thread->saveNew(self::$DEFAULT_THREAD_DESC,
                self::$DEFAULT_THREAD_SUBJECT, $userIds);
    }
}
