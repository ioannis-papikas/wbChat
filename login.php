<?php
// Require System Configuration
require_once("_config.php");

// Import System Classes
importer::importCore("base::DOM");
importer::importCore("profile::user");
importer::importCore("content::validator");
importer::importCore("ui::notification");

// Set Page Title
$GLOBALS['pageTitle'] = "Σύνδεση Χρήστη";

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
	// Check required fields
	$has_error = FALSE;
	$errors = array();
	
	// Check Login Data
	if (validator::_empty($_POST['username']) || validator::_empty($_POST['password']))
	{
		$errors[] = "Παρακαλώ εισάγετε όλα τα στοιχεία.";
		$has_error = TRUE;
	}
	
	if ($has_error)
	{
		$ntf = new notification("error");
		$ntf->set_header("Σφάλματα κατά την σύνδεση");
		
		// Create Error List
		$errList = DOM::create("ul");
		$ntf->set_body($errList);
		
		// Create error elemeents
		foreach($errors as $err)
		{
			$errItem = DOM::create("li", $err);
			DOM::append($errList, $errItem);
		}
	}
	else
	{
		// Login user
		$success = user::login($_POST['username'], $_POST['password']);
		if (!$success)
		{
			$ntf = new notification("error");
			$ntf->set_header("Σφάλμα κατά την σύνδεση");
			
			// Create Error List
			$msg = DOM::create("p", "Το όνομα χρήστη ή/και ο κωδικός πρόσβασης είναι λανθασμένα. Παρακαλώ δοκιμάστε ξανά.");
			$ntf->set_body($msg);
		}
		else
		{
			$profile = user::profile();
			header('Location: index.php');
			return;
		}
	}
}

?>
<!DOCTYPE>
<html>
<?php importer::includeResource("head"); ?>
<body>
	<?php importer::includeResource("header"); ?>
	<div class="uiMainContent">
		<form id="register" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="uiForm big" role="register" locale="el_GR">
			<div class="form_report">
				<?php
					if (isset($ntf))
						echo $ntf->getHTML();
				?>
			</div>
			<div class="uiFormHeader">Συνδεση</div>
			<div class="form_row">
				<input id="inp_username" name="username" type="text" class="uiFormInput required" placeholder="* Όνομα Χρήστη" value="<?php echo $_POST['username'];?>" autofocus />
			</div>
			<div class="form_row">
				<input id="inp_password" name="password" type="password" value="" class="uiFormInput required" placeholder="* Κωδικός Πρόσβασης" />
			</div>
			<div class="form_row controls">
				<button id="btn_submit" type="submit" class="uiFormButton positive" >Αποστολή</button>
				<button id="btn_submit" type="reset" class="uiFormButton" >Επαναφορά</button>
			</div>
		</form>
	</div>
</body>
</html>
