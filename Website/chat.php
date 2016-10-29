<?php include_once(__DIR__.'/zz1.php'); ?>
<title><?php echo _('Chat'); ?> - <?php echo CONFIG_SITE_NAME; ?></title>
<?php if ($loggedin == 1) { ?>
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript">
function nachladen() {
	$.ajax({
	  url: '/chat_engine.php',
	  data: { aktion: 'letzte_nachrichten' },
	  success: function(data) {
		  $("#nachrichten").html(data);
	  },
	  dataType: 'html'
	});
}
function senden(nachricht) {
	$.ajax({
	  url: '/chat_engine.php',
	  data: { nachricht: nachricht, aktion: 'nachricht_erzeugen' },
	  success: function(data) {
	      $("#contain").text(data);
		  document.chatform.nachricht.value = '';
		  nachladen();
	  },
	  dataType: 'text'
	});
	return false;
}
</script>
<?php } ?>
<?php include_once(__DIR__.'/zz2.php'); ?>
<?php if ($loggedin == 1) { ?>
<?php
setTaskDone('open_chat');
// CHAT-SPERREN ANFANG
$sql1 = "SELECT MAX(chatSperre) FROM ".$prefix."helferLog WHERE managerBestrafen = '".$cookie_id."'";
$sql2 = mysql_query($sql1);
if (mysql_num_rows($sql2) > 0) {
	$sql3 = mysql_fetch_assoc($sql2);
	$chatSperreBis = $sql3['MAX(chatSperre)'];
	if ($chatSperreBis > 0 && $chatSperreBis > time()) {
		addInfoBox(__('Du bist noch bis zum %1$s Uhr für die Kommunikation im Spiel gesperrt. Wenn Dir unklar ist warum, frage bitte das %2$s.', date('d.m.Y H:i', $chatSperreBis), '<a class="inText" href="/wio.php">'._('Support-Team').'</a>'));
		include_once(__DIR__.'/zz3.php');
		exit;
	}
}
// CHAT-SPERREN ENDE
// IGNORIER-LISTE ANFANG
$igno1 = "SELECT f2 FROM ".$prefix."freunde WHERE f1 = '".$cookie_id."' AND typ = 'B'";
$igno2 = mysql_query($igno1);
$ignoList = array();
while ($igno3 = mysql_fetch_assoc($igno2)) {
	$ignoList[] = $igno3['f2'];
}
$_SESSION['ignoList'] = serialize($ignoList);
// IGNORIER-LISTE ENDE
?>
<script type="text/javascript">
$(document).ready(function() {
	nachladen();
	window.setInterval("nachladen()", 3500);
});
function add_smiley(smiley_str) {
	document.chatform.nachricht.value = document.chatform.nachricht.value+' '+smiley_str;
	document.getElementById('nachricht').focus();
}
function talkTo(username) {
	document.chatform.nachricht.value = '@'+username+' ';
	document.chatform.nachricht.focus();
	return false;
}
</script>
<?php } ?>
<?php if ($loggedin == 1) { ?>
<h1><?php echo _('Chat'); ?></h1>
<?php
// NAECHSTER CHAT ABEND ANFANG
$heute_tag = date('d', time());
$heute_monat = date('m', time());
$heute_jahr = date('Y', time());
$chatAbendTime = mktime(19, 00, 00, $heute_monat, $heute_tag, $heute_jahr);
while (date('w', $chatAbendTime) != 0 OR date('W', $chatAbendTime) % 2 != 0) {
	$chatAbendTime = getTimestamp('+1 day', $chatAbendTime);
}
// NAECHSTER CHAT ABEND ENDE
$timeout = getTimestamp('-1 hour');
$up1 = "DELETE FROM ".$prefix."chatroom WHERE zeit < ".$timeout;
$up2 = mysql_query($up1);
echo '<p><strong>REPORT '._('Username').'</strong> '.__('schreiben, um einen User zu melden (nur bei %s)', '<a href="/regeln.php">'._('Regelverstoß').'</a>').'<br />';
echo '<strong>'._('Usernamen anklicken').'</strong>, '._('um einen User direkt anzusprechen');
$timeout = getTimestamp('-120 seconds');
$whosOn1 = "SELECT ids, username FROM ".$prefix."users WHERE last_chat > ".$timeout;
$whosOn2 = mysql_query($whosOn1);
if (mysql_num_rows($whosOn2) > 0) {
	$whosOnList = 'Chatbot, ';
	while ($whosOn3 = mysql_fetch_assoc($whosOn2)) {
		$whosOnList .= '<a href="/manager.php?id='.$whosOn3['ids'].'">'.$whosOn3['username'].'</a>, ';
	}
	$whosOnList = substr($whosOnList, 0, -2);
	echo '<br /><strong>'._('Chatter:').'</strong> '.$whosOnList;
	echo '<br /><strong>'._('Nächster Chat-Abend:').'</strong> '.date('d.m.Y H:i', $chatAbendTime).'</p>';
}
else {
	echo '</p>';
}
echo '<p> 
<a href="#" onclick="add_smiley(\':)\'); return false;"><img src="/images/emoticon_smile.png" alt=":)" title=":)" /></a>
<a href="#" onclick="add_smiley(\':D\'); return false;"><img src="/images/emoticon_grin.png" alt=":D" title=":D" /></a>
<a href="#" onclick="add_smiley(\'=D\'); return false;"><img src="/images/emoticon_happy.png" alt="=D" title="=D" /></a>
<a href="#" onclick="add_smiley(\':O\'); return false;"><img src="/images/emoticon_surprised.png" alt=":O" title=":O" /></a>
<a href="#" onclick="add_smiley(\':P\'); return false;"><img src="/images/emoticon_tongue.png" alt=":P" title=":P" /></a>
<a href="#" onclick="add_smiley(\':(\'); return false;"><img src="/images/emoticon_unhappy.png" alt=":(" title=":(" /></a>
<a href="#" onclick="add_smiley(\';)\'); return false;"><img src="/images/emoticon_wink.png" alt=";)" title=";)" /></a>
</p>';
?>
<form name="chatform" action="" method="post" accept-charset="utf-8">
<p><input type="text" name="nachricht" id="nachricht" style="width:300px" /> <input type="submit" value="<?php echo _('Senden'); ?>" onclick="return<?php echo noDemoClick($cookie_id, TRUE); ?> senden(document.chatform.nachricht.value);" /></p>
</form>
<div id="nachrichten"><noscript><?php echo _('Bitte aktiviere JavaScript in Deinem Browser, um den Chat nutzen zu können!'); ?></noscript></div>
<div id="contain"></div>
<?php } else { ?>
<h1><?php echo _('Chat'); ?></h1>
<p><?php echo _('Du musst angemeldet sein, um diese Seite aufrufen zu können!'); ?></p>
<?php } ?>
<?php include_once(__DIR__.'/zz3.php'); ?>
