<?php
// System Check
if (!defined("_PLATFORM_"))
	exit();
	
// Header Code
require_once(systemCore."/profile/user.php");
require_once(systemCore."/state/session.php");
require_once(systemCore."/state/cookies.php");

?>
<div class="uiMainHeader">
	<div class="uiMainToolbar">
		<div class="userControl">
			<div class="avatar"></div>
			<div class="user">Guest</div>
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