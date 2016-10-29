<?php include_once(__DIR__.'/zz1.php'); ?>
<title><?php echo _('Entwicklung'); ?> - <?php echo CONFIG_SITE_NAME; ?></title>
<?php include_once(__DIR__.'/zz2.php'); ?>
<h1><?php echo _('Entwicklung'); ?></h1>
<?php if ($loggedin == 1) { ?>
<?php
setTaskDone('players_development');
echo '<table>';
echo '<thead>';
echo '<tr>';
echo '<th scope="col">'._('MT').'</th>';
echo '<th scope="col">'._('Spieler').'</th>';
echo '<th scope="col">'._('Alter').'</th>';
echo '<th scope="col">'._('Datum').'</th>';
echo '<th scope="col">'._('Alt').'</th>';
echo '<th scope="col">'._('Neu').'</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
$delOld_Timeout = getTimestamp('-28 days');
$delOld1 = "DELETE FROM ".$prefix."spielerEntwicklung WHERE team = '".$cookie_team."' AND zeit < ".$delOld_Timeout;
$delOld2 = mysql_query($delOld1);
$sql1 = "SELECT a.spieler, a.zeit, a.staerkeNeu, a.staerkeAlt, b.vorname, b.nachname, b.position, b.wiealt FROM ".$prefix."spielerEntwicklung AS a JOIN ".$prefix."spieler AS b ON a.spieler = b.ids WHERE a.team = '".$cookie_team."' ORDER BY a.zeit DESC LIMIT ".$start.", ".$eintraege_pro_seite;
$sql2 = mysql_query($sql1);
$blaetter3 = anzahl_datensaetze_gesamt($sql1);
while ($sql3 = mysql_fetch_assoc($sql2)) {
	echo '<tr>';
	echo '<td>'.$sql3['position'].'</td>';
	echo '<td class="link"><a href="/spieler.php?id='.$sql3['spieler'].'">'.$sql3['vorname'].' '.$sql3['nachname'].' </a></td>';
	echo '<td>'.floor($sql3['wiealt']/365).'</td>';
	echo '<td>'.date('d.m.Y', $sql3['zeit']).'</td>';
	if ($sql3['staerkeAlt'] == $sql3['staerkeNeu']) {
		echo '<td colspan="2">'._('Höhepunkt').' ('.number_format($sql3['staerkeNeu'], 1, ',', '.').')</td>';
	}
	else {
		echo '<td>'.number_format($sql3['staerkeAlt'], 1, ',', '.').'</td>';
		echo '<td>'.number_format($sql3['staerkeNeu'], 1, ',', '.').'</td>';
	}
	echo '</tr>';
}
echo '</tbody>';
echo '</table>';
echo '<p><strong>'._('Überschriften:').'</strong> '._('MT: Mannschaftsteil').'</p>';
echo '<p><strong>'._('Mannschaftsteile:').'</strong> '._('T: Torwart, A: Abwehr, M: Mittelfeld, S: Sturm').'</p>';
?>
<?php
echo '<div class="pagebar">';
$wieviel_seiten = $blaetter3/$eintraege_pro_seite; // ERMITTELN DER SEITENANZAHL FÜR DAS INHALTSVERZEICHNIS
$vorherige = $seite-1;
if ($wieviel_seiten > 0) { echo '<a href="'.$_SERVER['SCRIPT_NAME'].'?seite=1">'._('Erste').'</a> '; } else { echo '<span class="this-page">'._('Erste').'</span>'; }
if ($seite > 1) { echo '<a href="'.$_SERVER['SCRIPT_NAME'].'?seite='.$vorherige.'">'._('Vorherige').'</a> '; } else { echo '<span class="this-page">'._('Vorherige').'</span> '; }
$naechste = $seite+1;
$vor4 = $seite-4; if ($vor4 > 0) { echo '<a href="'.$_SERVER['SCRIPT_NAME'].'?seite='.$vor4.'">'.$vor4.'</a> '; }
$vor3 = $seite-3; if ($vor3 > 0) { echo '<a href="'.$_SERVER['SCRIPT_NAME'].'?seite='.$vor3.'">'.$vor3.'</a> '; }
$vor2 = $seite-2; if ($vor2 > 0) { echo '<a href="'.$_SERVER['SCRIPT_NAME'].'?seite='.$vor2.'">'.$vor2.'</a> '; }
$vor1 = $seite-1; if ($vor1 > 0) { echo '<a href="'.$_SERVER['SCRIPT_NAME'].'?seite='.$vor1.'">'.$vor1.'</a> '; }
echo '<span class="this-page">'.$seite.'</span> ';
$nach1 = $seite+1; if ($nach1 < $wieviel_seiten+1) { echo '<a href="'.$_SERVER['SCRIPT_NAME'].'?seite='.$nach1.'">'.$nach1.'</a> '; }
$nach2 = $seite+2; if ($nach2 < $wieviel_seiten+1) { echo '<a href="'.$_SERVER['SCRIPT_NAME'].'?seite='.$nach2.'">'.$nach2.'</a> '; }
$nach3 = $seite+3; if ($nach3 < $wieviel_seiten+1) { echo '<a href="'.$_SERVER['SCRIPT_NAME'].'?seite='.$nach3.'">'.$nach3.'</a> '; }
$nach4 = $seite+4; if ($nach4 < $wieviel_seiten+1) { echo '<a href="'.$_SERVER['SCRIPT_NAME'].'?seite='.$nach4.'">'.$nach4.'</a> '; }
if ($seite < $wieviel_seiten) { echo '<a href="'.$_SERVER['SCRIPT_NAME'].'?seite='.$naechste.'">'._('Nächste').'</a> '; } else { echo '<span class="this-page">'._('Nächste').'</span> '; }
if ($wieviel_seiten > 0) { echo '<a href="'.$_SERVER['SCRIPT_NAME'].'?seite='.ceil($wieviel_seiten).'">'._('Letzte').'</a>'; } else { echo '<span clss="this-page">'._('Letzte').'</span>'; }
echo '</div>';
?>
<?php } else { ?>
<p><?php echo _('Du musst angemeldet sein, um diese Seite aufrufen zu können!'); ?></p>
<?php } ?>
<?php include_once(__DIR__.'/zz3.php'); ?>
