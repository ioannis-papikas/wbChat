<?php
// System Check
if (!defined("_WBCHAT_PLATFORM_")) throw new Exception("Web Platform is not defined!");

// Header Code
importer::importCore("profile::user");
importer::importCore("base::DOM");
	
// Create User Navigation
DOM::initialize();
$container = DOM::create("div", "", "", "user");
DOM::append($container);

// Get User
$profile = user::profile();
$avatarName = "Guest";
if (!is_null($profile))
{
	// Create Avatar
	$avatar = DOM::create("a", $profile['fullname']);
	DOM::attr($avatar, "href", "profile.php");
	DOM::attr($avatar, "target", "_self");
	DOM::append($container, $avatar);
	
	// User Controls
	$controls = DOM::create("div", "", "", "controls");
	DOM::append($container, $controls);
	
	// Create logout form
	$logoutForm = DOM::create("form");
	DOM::append($controls, $logoutForm);
	DOM::attr($logoutForm, "action", "logout.php");
	DOM::attr($logoutForm, "method", "post");
	//_____ Logout button
	$btn_logout = DOM::create("button", "Αποσύνδεση");
	DOM::append($logoutForm, $btn_logout);
	DOM::attr($btn_logout, "type", "submit");
	DOM::attr($btn_logout, "class", "label_button");
}
else
{
	// Create Avatar
	$avatar = DOM::create("a", "Guest");
	DOM::append($container, $avatar);
	
	// Create Login Control
	$controls = DOM::create("div", "", "", "controls");
	DOM::append($container, $controls);
	// Login
	$login = DOM::create("a", "login");
	DOM::attr($login, "href", "login.php");
	DOM::attr($login, "target", "_self");
	DOM::append($controls, $login);
}

?>
<div class="uiMainHeader">
	<div class="uiMainToolbar">
		<div class="userArea">
			<div class="userControl">
				<div class="avatar"></div>
				<?php echo DOM::getHTML(); ?>
			</div>
			<div class="pageTitle">
				<span class="content"><?php echo $GLOBALS['pageTitle']; ?></span>
			</div>
		</div>
		<div class="signature">
			<div class="content">
				<div class="title">Web Chat &copy; 2012</div>
				<br />
				<div class="menu">
					<a href="<?php echo siteRoot; ?>/about.php" target="_self" tabindex="-1">Πληροφορίες</a>
					<span>&bull;</span>
					<a href="<?php echo siteRoot; ?>/copyright.php" target="_self" tabindex="-1">Copyright</a>
				</div>
			</div>
		</div>
	</div>
</div>