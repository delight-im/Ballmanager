<?php include 'zz1.php'; ?>
<?php $mode = '';
if (isset($_GET['mode'])){
    $mode = mysql_real_escape_string(trim(strip_tags($_GET['mode'])));
}
if ($mode == 'achievements'){
echo '<title>Manager-Achievements | Ballmanager.de</title>';
}else{
echo '<title>Manager-Prüfung | Ballmanager.de</title>';
}?>
<?php include 'zz2.php'; ?>
<?php if ($loggedin == 1) { ?>
<?php
$nDone = 0;
function showErfolg($erfolg = 0) {
	global $nDone;
	if ($erfolg > 0) {
		$nDone++;
		return '<img src="/images/erfolg.png" width="16" alt="J" title="Erfolgreich bestanden" />';
	}
	else {
		return '<img src="/images/fehler.png" width="16" alt="N" title="Noch nicht abgeschlossen" />';
	}
}
// DABEIBLEIBEN - PRÜFEN ANFANG
$stayed1 = "SELECT COUNT(*) FROM ".$prefix."users WHERE ids = '".$cookie_id."' AND regdate < ".(time()-3600*24*10);
$stayed2 = mysql_query($stayed1);
$stayed3 = mysql_result($stayed2, 0);
if ($stayed3 >= 1) {
	setTaskDone('stay_time');
}
$stayed1 = "SELECT COUNT(*) FROM ".$prefix."users WHERE ids = '".$cookie_id."' AND regdate < ".(time()-3600*24*365);
$stayed2 = mysql_query($stayed1);
$stayed3 = mysql_result($stayed2, 0);
if ($stayed3 >= 1) {
	setTaskDone('happy_birthday');
}
// DABEIBLEIBEN - PRÜFEN ENDE
if ($mode == 'achievements'){
    echo '<h1>Manager-Achievements</h1>';
    echo '<p>BLA BLA BLA. Aber bevor Du Transfers aushandeln darfst, sollst Du erst alle Aufgaben dieser Manager-Prüfung erfolgreich abschließen.</p>';
    $html = '<table><thead><tr class="odd"><th scope="col">&nbsp;</th><th scope="col">Prüfung</th></tr></thead><tbody>';
    $sql1 = "SELECT a.task, b.id AS done FROM ".$prefix."licenseTasks AS a LEFT JOIN ".$prefix."licenseTasks_Completed AS b ON a.shortName = b.task AND b.user = '".$cookie_id."' LIMIT 30, 18446744073709551615"; //CHANGE THE MAX VALUE DEPENDING ON THE NUMBER OF ACHIEVEMENTS
}else{
    echo '<h1>Manager-Prüfung</h1>';
    echo '<p>Der Vorstand Deines Klubs hat viel Vertrauen in Dich. Aber bevor Du Transfers aushandeln darfst, sollst Du erst alle Aufgaben dieser Manager-Prüfung erfolgreich abschließen.</p>';
    $html = '<table><thead><tr class="odd"><th scope="col">&nbsp;</th><th scope="col">Prüfung</th></tr></thead><tbody>';
    $html .= '<tr><td>'.showErfolg(1).'</td><td>[01] Registriere Dich beim Ballmanager und aktiviere Deinen Account.</td></tr>';
    $html .= '<tr class="odd"><td>'.showErfolg(1).'</td><td>[02] Wähle nach dem ersten Login Dein Team und Deine Liga.</td></tr>';
    $sql1 = "SELECT a.task, b.id AS done FROM ".$prefix."licenseTasks AS a LEFT JOIN ".$prefix."licenseTasks_Completed AS b ON a.shortName = b.task AND b.user = '".$cookie_id."' LIMIT 0, 30";
}
$sql2 = mysql_query($sql1);
$rowCounter = 0;
while ($sql3 = mysql_fetch_assoc($sql2)) {
	$html .= '<tr';
	if ($rowCounter % 2 != 0) { $html .= ' class="odd"'; }
	$html .= '>';
	$html .= '<td style="width:16px">'.showErfolg($sql3['done']).'</td>';
	$html .= '<td>['.sprintf('%1$02d', $rowCounter+1).'] '.$sql3['task'].'</td></tr>';
	$rowCounter++;
}
$html .= '</tbody></table>';
$pDone = floor($nDone/$rowCounter*100);
echo '<div style="width:400px; height:40px; margin:10px auto; border:1px solid #000; background-color:#fff; color:#fff"><div style="width:'.floor(400*$pDone/100).'px; height:40px; margin:0; background-color:#3b69b6;"></div></div>';
echo '<p style="text-align:center; font-size:14px">'.$pDone.'% ABGESCHLOSSEN</p>';
if ($pDone >= 100 && $mode != 'achievements') {
	// GEGEBENENFALLS REFERRAL-BONUS AN WERBER VERGEBEN ANFANG
	$werberData1 = "SELECT b.ids, b.team FROM ".$prefix."referrals AS a JOIN ".$prefix."users AS b ON a.werber = b.ids WHERE a.geworben = '".$cookie_id."'";
	$werberData2 = mysql_query($werberData1);
	if (mysql_num_rows($werberData2) > 0) {
		$werberData3 = mysql_fetch_assoc($werberData2);
		$mql1 = "SELECT user2 FROM ".$prefix."users_multis WHERE user1 = '".$cookie_id."'";
		$mql2 = mysql_query($mql1);
		$werberIsMulti = FALSE;
		while ($mql3 = mysql_fetch_assoc($mql2)) {
			if ($mql3['user2'] == $werberData3['ids']) {
				$werberIsMulti = TRUE;
			}
		}
		if (!$werberIsMulti) {
			$geworben1 = "UPDATE ".$prefix."teams SET konto = konto+7500000 WHERE ids = '".$werberData3['team']."' OR ids = '".$cookie_team."'";
			$geworben2 = mysql_query($geworben1);
            $buch1 = "INSERT INTO ".$prefix."buchungen (team, verwendungszweck, betrag, zeit) VALUES ('".$werberData3['team']."', 'Empfehlung', 7500000, ".time().")";
            $buch2 = mysql_query($buch1);
            $buch1 = "INSERT INTO ".$prefix."buchungen (team, verwendungszweck, betrag, zeit) VALUES ('".$cookie_team."', 'Empfehlung', 7500000, ".time().")";
            $buch2 = mysql_query($buch1);
			$geworben1 = "UPDATE ".$prefix."referrals SET billed = 1 WHERE geworben = '".$cookie_id."'";
			$geworben2 = mysql_query($geworben1);
		}
	}
	// GEGEBENENFALLS REFERRAL-BONUS AN WERBER VERGEBEN ENDE
	$up1 = "UPDATE ".$prefix."users SET hasLicense = 1 WHERE ids = '".$cookie_id."'";
	mysql_query($up1);
	setTaskDone('graduated');
	$_SESSION['hasLicense'] = 1;
}
echo $html;
?>
<?php } else { ?>
<p>Du musst angemeldet sein, um diese Seite aufrufen zu können!</p>
<?php } ?>
<?php include 'zz3.php'; ?>
