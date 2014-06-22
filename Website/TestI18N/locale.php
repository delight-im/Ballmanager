<?php
// use sessions
session_start();
 
// get language preference
if (isset($_GET["lang"])) {
    $language = $_GET["lang"];
}
else if (isset($_SESSION["lang"])) {
    $language  = $_SESSION["lang"];
}
else {
    $language = "en_US";
}
 
// save language preference for future page requests
$_SESSION["Language"]  = $language;
 
$folder = "Locale";
$domain = "messages";
$encoding = "iso-8859-1";
 
putenv("LANG=" . $language);
setlocale(LC_ALL, $language);
 
bindtextdomain($domain, $folder);
bind_textdomain_codeset($domain, $encoding);
 
textdomain($domain);
?>
