<?php
// HC SVNT DRACONES

//password
$password = "password";

//set headers so that the page doesn't get cached
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

//get vars from post
$enteredPassword = $_POST['password'];

//get the current url
function curPageURL() {
	$pageURL = 'http';
	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
	$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
	$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

//include save files
include("fragments/notepadText.php");

//get post data for the text fields
$notepadListen = $_POST["notepadText"];

//generic function to check if the text field values have changed and if so save them to the corresponding file
function saveTextChanges($saveFileNameAndFieldName, $currentEnvironmentTextFieldValue, $environmentPostValue) {
	if ($environmentPostValue != $currentEnvironmentTextFieldValue && $environmentPostValue != NULL) {
		$currentEnvironmentTextFieldValue = $environmentPostValue;
		$var_str = var_export($currentEnvironmentTextFieldValue, true);
		$var = "<?php\n\n\$$saveFileNameAndFieldName = $var_str;\n\n?>";
		$environmentSaveFileString = 'fragments/' . $saveFileNameAndFieldName . '.php';
		file_put_contents($environmentSaveFileString, $var);
		header('Location: '. curPageURL());
	}
}

//run the saveTextChanges function for the notepad text if the correct password has been entered
if ($enteredPassword == $password) { 
	saveTextChanges('notepadText',$notepadText,$notepadListen);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="pragma" content="no-cache" />
<title>Electric Texture | Notepad</title>
<script type="text/javascript" src="/notepad/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
        mode : "textareas"
});
</script>
<style type="text/css">
/* Reset CSS */
html, body, div, ul, ol, li, dl, dt, dd, form, fieldset, label, input, textarea, p, h1, h2, h3, h4, h5, h6, pre, code, blockquote, hr, th, td {
	margin:0px;
	padding:0px;
}
body {
	color:#333333;
    text-shadow: 0 1px 0 #FFFFFF;
	font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
	height:100%;
	background-color:#FFFFFF;
	margin:20px;
}
textarea {
	width:800px;
	min-height:500px;
	font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
	padding:3px;
}
ul li {
	margin:0 0 10px 20px;
	font-size:0.75em;
	list-style-type:none;
}
</style>
</head>

<body>
<ul>
<form method="post">
	<li><textarea name="notepadText" id="notepadText"><?php echo $notepadText; ?></textarea></li>
    <li>Enter password to save changes:</li>
    <li><input name="password" type="password" size="40" /></li>
    <li><input type="submit" name="submit" value="save" /></li>
</form>
</ul>
</body>
</html>