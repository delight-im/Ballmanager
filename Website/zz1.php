<?php
ini_set('session.use_trans_sid', 0);

include 'zzserver.php';
include 'zzcookie.php';

if (CONFIG_USE_HTTPS && CONFIG_USE_HTTPS_HSTS) {
    // use HTTP Strict Transport Security (HSTS) with a period of three months
    header('Strict-Transport-Security: max-age=7884000');
}

// prevent caching and storage of sensitive data
header('Expires: Mon, 24 Mar 2008 00:00:00 GMT');
header('Cache-Control: no-cache, no-store');

ob_start();

// BLAETTERN ANFANG
if (isset($_GET['seite'])) { $seite = intval($_GET['seite']); }
else { $seite = 1; }
$eintraege_pro_seite = 15; // ANGEBEN DER BEITRAEGE PRO SEITE
$start = $seite*$eintraege_pro_seite-$eintraege_pro_seite; // ERMITTELN DER STARTZAHL FÜR DIE ABFRAGE
// BLAETTERN ENDE

require_once('./classes/I18N.php');
if (isset($_GET['setLocale'])) {
    I18N::changeLanguage($_GET['setLocale']);
}
I18N::init('messages', './i18n', 'en_US', array(
    '/^de((-|_).*?)?$/i' => 'de_DE',
    '/^en((-|_).*?)?$/i' => 'en_US',
    '/^es((-|_).*?)?$/i' => 'es_ES'
));

// INFO-BOXEN-ARRAY ANFANG
$showInfoBox = array();
function addInfoBox($text) {
	global $showInfoBox;
	$showInfoBox[] = trim($text);
}
function setTaskDone($shortName) {
	global $prefix, $cookie_id, $cookie_team;
	if ($_SESSION['hasLicense'] == 0 && $cookie_team != '__'.$cookie_id) {
		$taskDone1 = "INSERT INTO ".$prefix."licenseTasks_Completed (user, task) VALUES ('".$cookie_id."', '".mysql_real_escape_string(trim($shortName))."')";
		$taskDone2 = mysql_query($taskDone1);
		if ($taskDone2 != FALSE) {
			addInfoBox(__('Herzlichen Glückwunsch, Du hast gerade einen weiteren Teil deiner %1$s abgeschlossen!', '<a class="inText" href="/managerPruefung.php">'._('Manager-Prüfung').'</a>'));
			$getTaskMoney1 = "UPDATE ".$prefix."teams SET konto = konto+1000000 WHERE ids = '".$cookie_team."'";
			mysql_query($getTaskMoney1);
			$taskBuchung1 = "INSERT INTO ".$prefix."buchungen (team, verwendungszweck, betrag, zeit) VALUES ('".$cookie_team."', 'Manager-Prüfung', 1000000, ".time().")";
			mysql_query($taskBuchung1);
		}
	}
}
// INFO-BOXEN-ARRAY ENDE
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="content-language" content="de" />
<meta http-equiv="content-script-type" content="text/javascript" />
<meta http-equiv="content-style-type" content="text/css" />
<meta name="robots" content="index,follow" />
<link rel="stylesheet" href="/images/Refresh.php?v=234936" type="text/css" />
<link rel="stylesheet" href="/css/emblem.css" type="text/css" />
<link rel="stylesheet" href="/css/app.css" type="text/css" />
<script type="text/javascript" src="/js/drop_down.js"></script>
<link rel="stylesheet" href="/css/drop_down.css" type="text/css" />
<link rel="icon" type="image/png" href="/images/favicon.png" />
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
