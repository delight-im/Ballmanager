<?php include 'zz1.php'; ?>
<title>Manager-Achievements | Ballmanager.de</title>
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
echo '<h1>Manager-Achievements</h1>';
echo '<p>Der Vorstand Deines Klubs hat viel Vertrauen in Dich. Aber bevor Du Transfers aushandeln darfst, sollst Du erst alle Aufgaben dieser Manager-Prüfung erfolgreich abschließen.</p>';
$html = '<table><thead><tr class="odd"><th scope="col">&nbsp;</th><th scope="col">Prüfung</th></tr></thead><tbody>';
$sql1 = "SELECT a.task, b.id AS done FROM ".$prefix."licenseTasks AS a LEFT JOIN ".$prefix."licenseTasks_Completed AS b ON a.shortName = b.task AND b.user = '".$cookie_id."' LIMIT 30, 40";
$sql2 = mysql_query($sql1);
$rowCounter = 2;
while ($sql3 = mysql_fetch_assoc($sql2)) {
	$html .= '<tr';
	if ($rowCounter % 2 != 0) { $html .= ' class="odd"'; }
	$html .= '>';
	$html .= '<td>'.showErfolg($sql3['done']).'</td>';
	$html .= '<td>['.sprintf('%1$02d', $rowCounter+1).'] '.$sql3['task'].'</td></tr>';
	$rowCounter++;
}
$html .= '</tbody></table>';
$pDone = floor($nDone/$rowCounter*100);
echo '<div style="width:400px; height:40px; margin:10px auto; border:1px solid #000; background-color:#fff; color:#fff"><div style="width:'.floor(400*$pDone/100).'px; height:40px; margin:0; background-color:#3b69b6;"></div></div>';
echo '<p style="text-align:center; font-size:14px">'.$pDone.'% ABGESCHLOSSEN</p>';
echo $html;
?>
<?php } else { ?>
<p>Du musst angemeldet sein, um diese Seite aufrufen zu können!</p>
<?php } ?>
<?php include 'zz3.php'; ?>
