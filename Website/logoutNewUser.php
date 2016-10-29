<?php include_once(__DIR__.'/zz1.php'); ?>
<?php
if (isset($_POST['logoutOrNot'])) {
    $decisionValue = $_POST['logoutOrNot'];
	switch ($decisionValue) {
		case _('Ich komme später wieder - Ausloggen!'): header('Location: /logout.php'); break;
		case _('Ich habe ein Problem oder eine Frage - Hilfe!'): header('Location: /support.php'); break;
		case _('Ich habe keine Lust mehr - Account löschen!'): header('Location: /einstellungen.php#accDel'); break;
        default: throw new Exception('Unknown decision value: '.$decisionValue);
	}
    exit;
}
?>
<title><?php echo _('Ausloggen?'); ?> - <?php echo CONFIG_SITE_NAME; ?></title>
<?php include_once(__DIR__.'/zz2.php'); ?>
<h1><?php echo _('Ausloggen?'); ?></h1>
<?php if ($loggedin == 1) { ?>
<p><strong><?php echo _('Du bist neu hier, deshalb fragen wir Dich:').'</strong><br />'.__('Was möchtest Du tun? Wie gefällt Dir %s bisher?', CONFIG_SITE_NAME); ?></p>
<form action="/logoutNewUser.php" method="post" accept-charset="utf-8">
<p><input type="submit" name="logoutOrNot" value="<?php echo _('Ich komme später wieder - Ausloggen!'); ?>" style="width: 300px" /></p>
<p><input type="submit" name="logoutOrNot" value="<?php echo _('Ich habe ein Problem oder eine Frage - Hilfe!'); ?>" style="width: 300px" /></p>
<p><input type="submit" name="logoutOrNot" value="<?php echo _('Ich habe keine Lust mehr - Account löschen!'); ?>" style="width: 300px" /></p>
</form>
<?php } else { ?>
<p><?php echo _('Du musst angemeldet sein, um diese Seite aufrufen zu können!'); ?></p>
<?php } ?>
<?php include_once(__DIR__.'/zz3.php'); ?>
