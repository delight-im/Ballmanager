<?php
if (!isset($_POST['reg_email']) OR !isset($_POST['reg_benutzername'])) { exit; }
?>
<?php include 'zz1.php'; ?>
<title>Registriert | Ballmanager.de</title>
<?php include 'zz2.php'; ?>

<h1>Registriert</h1>
<?php
function email_senden($email, $username, $password, $activeIP='0.0.0.0') {
    global $config;
	$empfaenger = $email;
	$betreff = 'Ballmanager: Willkommen';
	$nachricht = '
        <div>
	    <table width="100%" border="0" bgcolor="#f1f1f1" cellspacing="0" cellpadding="0">
	        <tbody>
                    <br>
		    <tr>
		        <td valign="top"><img width="1" height="1" src=""></td>
			<td valign="middle" align="center"><a target="_blank" href="http://www.ballmanager.de"><img width="260" style="border: 0px none; width: 260px; height: 60px;" title="Ballmanager - Online-Fußball-Manager" alt="Ballmanager - Online-Fußball-Manager" src="http://www.ballmanager.de/images/logo_black.png"></a></td>
			<td valign="top"><img width="1" height="1" src=""></td>
		    </tr>
                    <tr>
		        <td><img width="1" height="1" src=""></td>
                        <td width="800" bgcolor="#ffffff" style="border-top:10px solid #3f6d98;line-height:1.5">
			    <table width="100%" cellpadding="20">
			        <tbody>
                                    <tr>
				        <td align="center">
					    <table width="100%" cellpadding="5">
						<tbody>
                                                    <tr>
						        <td style="font-family: \'Helvetica Neue\',helvetica,sans-serif; color: rgb(68, 68, 68); font-size: 16px; line-height: 1.5;">
							    <h1 style="font-family:\'Helvetica Neue\',helvetica,sans-serif;color:#3f6d98!important;font-weight:300!important"><center>Please confirm your data</center></h1>Hallo '.$username.',<br><br> Du hast Dich erfolgreich auf www.ballmanager.de registriert. Bitte logge Dich jetzt mit Deinen Benutzerdaten ein, um Deinen Account zu aktivieren. Und dann kann es auch schon losgehen ...<br><br>  Damit Du Dich anmelden kannst, findest Du hier noch einmal Deine Benutzerdaten:<br><br>  E-Mail: '.$email.'<br>Benutzername: '.$username.'<br> Passwort: '.$password.'<br><br>  Wir wünschen Dir noch viel Spaß beim Managen!<br>  Sportliche Grüße<br> Das Ballmanager Support-Team<br> www.ballmanager.de<br>
                                                            <br><br><center><a href="http://www.ballmanager.de" style="color:#ffffff;font-family:\'Helvetica Neue\',helvetica,sans-serif;text-decoration:none;font-size:14px;background:#3f6d98;line-height:32px;padding:0 10px;display:inline-block;border-radius:3px" target="_blank">Activate your account</a></center><br>---------------------------------------------------------------------<br><div style="font-size:10px;">Du erhältst diese E-Mail, weil Du Dich auf www.ballmanager.de mit dieser Adresse registriert hast. Du kannst Deinen Account jederzeit löschen, nachdem Du Dich eingeloggt hast, sodass Du anschließend keine E-Mails mehr von uns bekommst. Bei Missbrauch Deiner E-Mail-Adresse meldest Du Dich bitte per E-Mail unter info@ballmanager.de</div>
							    <br>
							</td>
						    </tr>
						</tbody>
                                            </table>
					</td>
				    </tr>
				</tbody>
                            </table>
			</td>
		    </tr>
		</tbody>
            </table>
        </div>';
	if ($config['PHP_MAILER']) {
		require './phpmailer/PHPMailerAutoload.php';
		$mail = new PHPMailer(); // create a new object
		$mail->CharSet= $config['SMTP_CHARSET'];
		$mail->IsSMTP();
		$mail->SMTPAuth = $config['SMTP_AUTH'];
		$mail->SMTPSecure = $config['SMTP_SECURE'];
		$mail->Host = $config['SMTP_HOST'];
		$mail->Port = $config['SMTP_PORT'];
		$mail->Username = $config['SMTP_USER'];
		$mail->Password = $config['SMTP_PASS'];
		$mail->SetFrom($config['SMTP_FROM']);
		$mail->Subject = $betreff;
		$mail->Body = $nachricht;
		$mail->AddAddress($empfaenger);
		$mail->Send();
	}
	else{
		$header = "From: Ballmanager <info@ballmanager.de>\r\nContent-type: text/html; charset=utf-8";
		mail($empfaenger, $betreff, $nachricht, $header);
	}
}
$last_ip = getUserIP();
$fehler_gemacht = TRUE;
if (strlen($_POST['reg_email']) > 0 && strlen($_POST['reg_benutzername']) > 0) {
    $email = mysql_real_escape_string(trim(strip_tags($_POST['reg_email'])));
    $email_valide = preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i', $email);
    if ($email_valide == TRUE) {
		$username = mysql_real_escape_string(trim(strip_tags($_POST['reg_benutzername'])));
		$username = str_replace('_', '', $username);
		$password = mt_rand(1,9).mt_rand(1,9).mt_rand(1,9).mt_rand(1,9).mt_rand(1,9).mt_rand(1,9);
		$password_db = md5('1'.$password.'29');
		$blackList1 = "SELECT COUNT(*) FROM ".$prefix."blacklist WHERE email = '".md5($email)."' AND until > ".time();
		$blackList2 = mysql_query($blackList1);
		$blackList3 = mysql_result($blackList2, 0);
		$schon_vorhandene_user = $blackList3;
		$sql1 = "SELECT COUNT(*) FROM ".$prefix."users WHERE email = '".$email."' OR username = '".$username."'";
		$sql2 = mysql_query($sql1);
		$sql3 = mysql_result($sql2, 0);
		$schon_vorhandene_user += $sql3;
		if ($schon_vorhandene_user == 0) {
			$uniqueIDHash = md5($email.time());
			$sql4 = "INSERT INTO ".$prefix."users (email, username, password, regdate, last_login, last_ip, ids, liga, team) VALUES ('".$email."', '".$username."', '".$password_db."', ".time().", ".bigintval(getTimestamp('-14 days')).", '".$last_ip."', '".$uniqueIDHash."', '', '__".$uniqueIDHash."')";
			$sql5 = mysql_query($sql4);
			if ($sql5 != FALSE) {
				if (isset($_SESSION['referralID'])) {
					$refID = mysql_real_escape_string(trim($_SESSION['referralID']));
					if (mb_strlen($refID) == 32) {
						$addReferral1 = "INSERT INTO ".$prefix."referrals (werber, geworben, zeit) VALUES ('".$refID."', '".$uniqueIDHash."', ".time().")";
						$addReferral2 = mysql_query($addReferral1);
					}
				}
				$fehler_gemacht = FALSE;
				if ($config['isLocalInstallation']) {
					echo '<p><strong>Dein Passwort lautet:</strong> '.htmlspecialchars($password).'</p>';
					echo '<p>Du brauchst dieses Passwort unbedingt für den ersten Login. Danach kannst Du es in den Einstellungen ändern, wenn Du möchtest.</p>';
				}
				else {
					echo '<p>Vielen Dank, die Registrierung war erfolgreich! Wir senden Dir nun an die angegebene Adresse eine E-Mail mit Deinem Passwort zu. Mit dem Benutzernamen und dem zugeschickten Passwort kannst Du Dich danach einloggen.</p>';
					echo '<p>Logge Dich am besten ganz schnell ein - dann kannst Du dir das beste Team sichern! Viel Spaß!</p>';
					email_senden($email, $username, $password, $last_ip);
				}
			}
		}
    }
}
if ($fehler_gemacht == TRUE) {
	echo '<p>Die Registrierung konnte leider nicht abgeschlossen werden. Der Benutzername oder die E-Mail-Adresse ist ungültig oder schon vergeben. <a href="/index.php">Bitte versuche es noch einmal.</a></p>';
}
?>
<?php include 'zz3.php'; ?>
