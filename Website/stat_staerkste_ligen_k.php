<?php include_once(__DIR__.'/zz1.php'); ?>
<title><?php echo _('Stärkste Ligen - Kader'); ?> - <?php echo CONFIG_SITE_NAME; ?></title>
<style type="text/css">
<!--
.liga_<?php echo $cookie_liga; ?> {
	font-weight: bold;
}
-->
</style>
<?php include_once(__DIR__.'/zz2.php'); ?>
<?php include_once(__DIR__.'/zzsubnav_statistik.php'); ?>
<h1><?php echo _('Stärkste Ligen - Kader'); ?></h1>
<?php if ($loggedin == 1) { ?>
<p><?php echo _('Jedes Team besitzt eine Kaderstärke. Am Durchschnitt dieser Stärken innerhalb der einzelnen Ligen wird hier deren Stärke gemessen.'); ?></p>
<p>
<table>
<thead>
<tr class="odd">
<th scope="col">&nbsp;</th>
<th scope="col"><?php echo _('Liga'); ?></th>
<th scope="col"><?php echo _('Stärke'); ?></th>
</tr>
</thead>
<tbody>
<?php
$ausdruck = "(SELECT AVG(staerke) FROM ".$prefix."teams WHERE liga = ".$prefix."ligen.ids)";
$sql1 = "SELECT ids, name, ".$ausdruck." FROM ".$prefix."ligen ORDER BY ".$ausdruck." DESC LIMIT 0, 26";
$sql2 = mysql_query($sql1);
$counter = 1;
while ($sql3 = mysql_fetch_assoc($sql2)) {
	if ($counter % 2 == 1) { echo '<tr class="liga_'.$sql3['ids'].'">'; } else { echo '<tr class="liga_'.$sql3['ids'].' odd">'; }
	echo '<td>'.$counter.'.</td><td class="link"><a href="/lig_tabelle.php?liga='.$sql3['ids'].'">'.$sql3['name'].'</a></td><td>'.number_format($sql3[$ausdruck], 1, ',', '.').'</td>';
	echo '</tr>';
	$counter++;
}
?>
</tbody>
</table>
</p>
<?php } else { ?>
<p><?php echo _('Du musst angemeldet sein, um diese Seite aufrufen zu können!'); ?></p>
<?php } ?>
<?php include_once(__DIR__.'/zz3.php'); ?>
