<?php
// System Check
if (!defined("_WBCHAT_PLATFORM_")) throw new Exception("Web Platform is not defined!");

// Header Code
importer::importCore("profile::user");
importer::importCore("base::DOM");
	
// Create User Navigation
$dom = new DOM();
$container = $dom->create("div", "", "userArea");
$dom->append($container);

$userControl = $dom->create("div", "", "userControl");
$dom->append($container, $userControl);

// User Avatar
$avatar = $dom->create("div", "", "", "avatar");
$dom->append($userControl, $avatar);

// User Sign
$userSign = $dom->create("div", "", "", "user");
$dom->append($userControl, $userSign);

// Get User
$profile = user::profile();
$avatarName = (!is_null($profile) ? $profile['fullname'] : "Guest");
$userFullName = $dom->create("span", $avatarName);
$dom->append($userSign, $userFullName);

// User Navigation
$userNav = $dom->create("div", "", "", "userNav");
$dom->append($container, $userNav);

$navMenu = $dom->create("div", "", "", "navMenu noDisplay");
$dom->append($userNav, $navMenu);
if (!is_null($profile))
{
	// Create Navigation item
	$navItem = $dom->create("li", "", "", "navItem");
	$dom->append($navMenu, $navItem);
	$profileNav = $dom->create("a", "Προφίλ");
	$dom->append($navItem, $profileNav);
	$dom->attr($profileNav, "href", "profile.php");
	$dom->attr($profileNav, "target", "_self");
	
	// Create Navigation item
	$navItem = $dom->create("li", "", "", "navItem");
	$dom->append($navMenu, $navItem);
	
	// Create logout form
	$logoutForm = $dom->create("form");
	$dom->append($navItem, $logoutForm);
	$dom->attr($logoutForm, "action", "logout.php");
	$dom->attr($logoutForm, "method", "post");
	//_____ Logout button
	$btn_logout = $dom->create("button", "Αποσύνδεση");
	$dom->append($logoutForm, $btn_logout);
	$dom->attr($btn_logout, "type", "submit");
	$dom->attr($btn_logout, "class", "label_button");
	
	// Create Navigation item
	$sepItem = $dom->create("li", "", "", "navItem separator");
	$dom->append($navMenu, $sepItem);
}

// Include Chat Controls
if (!is_null($profile))
{
	// Create Chat Control's Menu
	$chatMenu = $dom->create("div", "", "chatControls", "navMenu");
	$dom->append($container, $chatMenu);
	
	// New Thread Item
	$navItem = $dom->create("li", "", "", "navItem");
	$dom->append($chatMenu, $navItem);
	$navItemA = $dom->create("a", "+ Νέα Συζήτηση", "create_newThread");
	$dom->attr($navItemA, "href", "#");
	$dom->append($navItem, $navItemA);
	
	// Create Separator item
	$sepItem = $dom->create("li", "", "", "navItem separator");
	$dom->append($chatMenu, $sepItem);
	
	// Create Chat Folders
	$navItem = $dom->create("li", "", "", "navItem");
	$dom->append($chatMenu, $navItem);
	$navItemA = $dom->create("a", "Εισερχόμενα", "view_inbox");
	$dom->attr($navItemA, "href", "#");
	$dom->append($navItem, $navItemA);
	
	$navItem = $dom->create("li", "", "", "navItem");
	$dom->append($chatMenu, $navItem);
	$navItemA = $dom->create("a", "Απεσταλμένα", "view_inbox");
	$dom->attr($navItemA, "href", "#");
	$dom->append($navItem, $navItemA);
}

?>
<div class="uiMainHeader">
	<div class="uiMainToolbar">
		<?php echo $dom->getHTML(); ?>
		<div class="navigation">
			<?php
				// Create navigation menu
				$dom = new DOM();
				
				$menu = $dom->create("ul", "", "", "navMenu");
				$dom->append($menu);
				
				// If user is logged in, logout link
				if (is_null($profile))
				{
					// Create Navigation item
					$loginItem = $dom->create("li", "", "", "navItem");
					$dom->append($menu, $loginItem);
					
					// Login
					$login = $dom->create("a", "Σύνδεση Χρήστη");
					$dom->attr($login, "href", "login.php");
					$dom->attr($login, "target", "_self");
					$dom->append($loginItem, $login);
					
					// Create Navigation item
					$registerItem = $dom->create("li", "", "", "navItem");
					$dom->append($menu, $registerItem);
					
					// Register
					$register = $dom->create("a", "Εγγραφή Χρήστη");
					$dom->attr($register, "href", "register.php");
					$dom->attr($register, "target", "_self");
					$dom->append($registerItem, $register);
				}
				
				echo $dom->getHTML();
			?>
		</div>
		<div class="signature">
			<div class="content">
				<div class="title">Web Chat &copy; 2013</div>
				<br />
				<div class="menu">
					<a href="<?php echo siteRoot; ?>/index.php" target="_self" tabindex="-1">Αρχική</a>
					<span>&bull;</span>
					<a href="<?php echo siteRoot; ?>/about.php" target="_self" tabindex="-1">Πληροφορίες</a>
					<span>&bull;</span>
					<a href="<?php echo siteRoot; ?>/copyright.php" target="_self" tabindex="-1">Copyright</a>
				</div>
			</div>
		</div>
	</div>
</div>