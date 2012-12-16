<?php
// System Check
if (!defined("_WBCHAT_PLATFORM_")) throw new Exception("Web Platform is not defined!");

// Header Code
importer::importCore("profile::user");

?>
<div class="uiMainHeader">
	<div class="uiMainToolbar">
		<div class="userArea">
			<div class="userControl">
				<div class="avatar"></div>
				<div class="user">Guest</div>
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