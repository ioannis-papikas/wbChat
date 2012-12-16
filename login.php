<?php
// Require System Configuration
require_once("_config.php");
?>
<!DOCTYPE>
<html>
<?php importer::includeResource("head"); ?>
<body>
	<?php importer::includeResource("header"); ?>
	<div class="uiMainContent">
		<form id="login" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="uiForm" role="contact" locale="el_GR" data-validation='{"mode":"verbose"}' data-captcha="true">
			<div class="form_report"></div>
			<div class="uiFormHeader">Στοιχεία επικοινωνίας</div>
				<div class="form_row">
					<label id="lbl_firstname" for="inp_firstname" class="uiFormLabel required"><span class="required">*</span>Όνομα</label>
				</div>
					<input id="inp_firstname" name="firstname" type="text" value="" autofocus class="uiFormInput required" data-fann-info='{"title":"Όνομα","desc":"Παρακαλώ εισάγετε το όνομά σας."}'/>
				<div class="form_row">
					<label id="lbl_lastname" for="inp_lastname" class="uiFormLabel required"><span class="required">*</span>Επώνυμο</label>
				</div>
				<div class="form_row">
					<input id="inp_lastname" name="lastname" type="text" value="" class="uiFormInput required" data-fann-info='{"title":"Επώνυμο","desc":"Παρακαλώ εισάγετε το επώνυμό σας."}'/>
				</div>
				<div class="form_row">
					<label id="lbl_companyname" for="inp_companyname" class="uiFormLabel">Επωνυμία</label>
				</div>
				<div class="form_row">
					<input id="inp_companyname" name="companyname" type="text" value="" class="uiFormInput" data-fann-info='{"title":"Επωνυμία","desc":"Παρακαλώ εισάγετε την επωνυμία της εταιρία σας (εάν υπάρχει)."}'/>
				</div>
				<div class="form_row">
					<label id="lbl_phone" for="inp_phone" class="uiFormLabel">Τηλέφωνο Επικοινωνίας</label>
				</div>
				<div class="form_row">
					<input id="inp_phone" name="phone" type="text" value="" class="uiFormInput" data-fann-info='{"title":"Τηλέφωνο Επικοινωνίας","desc":"Παρακαλώ εισάγετε το τηλέφωνο επικοινωνίας σας (εάν επιθυμείτε να σας καλέσουμε)."}'/>
				</div>
				<div class="form_row">
					<label id="lbl_email" for="inp_email" class="uiFormLabel required"><span class="required">*</span>Email</label>
				</div>
				<div class="form_row">
					<input id="inp_email" name="email" type="email" value="" class="uiFormInput required" data-fann-info='{"title":"Email","desc":"Παρακαλώ εισάγετε το email σας."}'/>
				</div>
				<div class="form_row">
					<label id="lbl_address" for="inp_address" class="uiFormLabel">Διεύθυνση</label>
				</div>
				<div class="form_row">
					<input id="inp_address" name="address" type="text" value="" class="uiFormInput" data-fann-info='{"title":"Διεύθυνση","desc":"Παρακαλώ εισάγετε τη διεύθυνσή σας."}'/>
				</div>
				<div class="form_row">
					<label id="lbl_comments" for="cst_comments" class="uiFormLabel"><span class="required">*</span>Σχόλια</label>
				</div>
				<div class="form_row">
					<textarea id="cst_comments" name="comments" type="textarea" value="" class="uiFormInput required" data-fann-info='{"title":"Σχόλια","desc":"Παρακαλώ εισάγετε το κείμενο που θέλετε."}'></textarea>
				</div>
			<div class="captcha">
				<div class="uiAppToolContainer" data-tool='{"code":"3", "domain":"eBuilder"}' data-attr='{"locale":"el_GR"}'></div>
			</div>
			<div class="form_row controls">
				<button id="btn_submit" type="submit" class="uiFormButton positive" >Αποστολή</button>
				<button id="btn_submit" type="reset" class="uiFormButton" >Επαναφορά</button>
			</div>
		</form>
	</div>
</body>
</html>
