<?php
// Require System Configuration
require_once("_config.php");

// Import System Classes
importer::importCore("base::DOM");
importer::importCore("database::sqlQuery");
importer::importCore("database::dbConnection");
importer::importCore("content::validator");
importer::importCore("ui::notification");

// Set Page Title
$GLOBALS['pageTitle'] = "Εγγραφή Χρήστη";

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
	// Check required fields
	$has_error = FALSE;
	$errors = array();
	
	// Check firstname
	if (validator::_empty($_POST['firstname']))
	{
		$errors[] = "Εισάγετε το όνομά σας.";
		$has_error = TRUE;
	}
	
	// Check lastname
	if (validator::_empty($_POST['lastname']))
	{
		$errors[] = "Εισάγετε το επώνυμό σας.";
		$has_error = TRUE;
	}
	
	// Check Username
	if (validator::_empty($_POST['username']) || validator::_username($_POST['username']))
	{
		if (validator::_empty($_POST['username']))
			$errors[] = "Εισάγετε ένα όνομα χρήστη.";
		
		if (!validator::_username($_POST['username']))
			$errors[] = "Το όνομα χρήστη δεν έχει τη σωστή μορφή.";
		
		$has_error = TRUE;
	}
	
	// Check Password
	if (validator::_empty($_POST['password']) || !validator::_password($_POST['password']))
	{
		$has_error = TRUE;
		if (validator::_empty($_POST['password']))
			$errors[] = "Παρακαλώ εισάγετε έναν κωδικό πρόσβασης.";
			
		if (!validator::_password($_POST['password']))
			$errors[] = "Ο κωδικός πρόσβασης δεν έχει τη σωστή μορφή.";
	}
	
	if ($has_error)
	{
		$ntf = new notification("error");
		$ntf->set_header("Σφάλματα κατά την εγγραφή");
		
		// Create Error List
		$errList = $dom->create("ul");
		$ntf->set_body($errList);
		
		// Create error elemeents
		foreach($errors as $err)
		{
			$errItem = $dom->create("li", $err);
			$dom->append($errList, $errItem);
		}
	}
	else
	{
		// Create user record
		$q = new sqlQuery();
		$q->set_query("INSERT INTO user(firstname, lastname, username, password) VALUES('$_POST[firstname]', '$_POST[lastname]', '$_POST[username]', '$_POST[password]')");
		
		$dbc = new dbConnection();
		$result = TRUE;//$dbc->execute_query($q);
		
		if ($result)
		{
			// Create success notification
			$ntf = new notification("success");
			$ntf->set_header("Επιτυχία");
			
			// Create Error List
			$msg = $dom->create("p", "Η εγγραφή σας στο σύστημα ήταν επιτυχής.");
			$ntf->set_body($msg);
			
			unset($_POST);
		}
	}
}

?>
?>
<!DOCTYPE>
<html>
<?php importer::includeResource("head"); ?>
<body>
	<?php importer::includeResource("header"); ?>
	<div class="uiMainContent">
		<div class="uiHeader">Εγγραφή Χρήστη</div>
		<form id="register" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="uiForm big" role="register" locale="el_GR">
			<div class="form_report">
				<?php
					if (isset($ntf))
						echo $ntf->getHTML();
				?>
			</div>
			<div class="uiFormHeader">Προσωπικά Στοιχεία</div>
			<div class="form_row">
				<input id="inp_firstname" name="firstname" type="text" autofocus class="uiFormInput required" placeholder="* Όνομα" value="<?php echo $_POST['firstname'];?>" />
				<span class="note"></span>
			</div>
			<div class="form_row">
				<input id="inp_lastname" name="lastname" type="text" class="uiFormInput required" placeholder="* Επώνυμο" value="<?php echo $_POST['lastname'];?>" />
			</div>
			<div class="uiFormHeader">Στοιχεία Χρήστη</div>
			<div class="form_row">
				<input id="inp_username" name="username" type="text" class="uiFormInput required" placeholder="* Όνομα Χρήστη" value="<?php echo $_POST['username'];?>" />
			</div>
			<div class="form_row">
				<input id="inp_password" name="password" type="password" value="" class="uiFormInput required" placeholder="* Κωδικός Πρόσβασης" />
			</div>
			<div class="form_row">
				<input id="inp_passwordVerify" name="passwordVerify" type="password" value="" class="uiFormInput required" placeholder="* Επαλήθευση" />
			</div>
			<div class="form_row controls">
				<button id="btn_submit" type="submit" class="uiFormButton positive" >Αποστολή</button>
				<button id="btn_submit" type="reset" class="uiFormButton" >Επαναφορά</button>
			</div>
		</form>
	</div>
</body>
</html>
