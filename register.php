<?php
// Require System Configuration
require_once("_config.php");

// Set Page Title
$GLOBALS['pageTitle'] = "Εγγραφή Χρήστη";

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
}

?>
<!DOCTYPE>
<html>
<?php importer::includeResource("head"); ?>
<body>
	<?php importer::includeResource("header"); ?>
	<div class="uiMainContent">
		<form id="register" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="uiForm big" role="register" locale="el_GR">
			<div class="form_report"></div>
			<div class="uiFormHeader">Προσωπικά Στοιχεία</div>
			<div class="form_row">
				<input id="inp_firstname" name="firstname" type="text" value="" autofocus class="uiFormInput required" placeholder="* Όνομα" />
				<span class="note"></span>
			</div>
			<div class="form_row">
				<input id="inp_lastname" name="lastname" type="text" value="" class="uiFormInput required" placeholder="* Επώνυμο" />
			</div>
			<div class="uiFormHeader">Στοιχεία Χρήστη</div>
			<div class="form_row">
				<input id="inp_username" name="username" type="text" value="" class="uiFormInput required" placeholder="* Όνομα Χρήστη"/>
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
