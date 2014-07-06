<?php include 'zz1.php'; ?>
<title>Einführung für Anfänger | Ballmanager.de</title>
<?php include 'zz2.php'; ?>
<?php if ($loggedin == 1) { ?>

<?php
// setTaskDone('open_tutorial');
?>
<div id="intro">
    <h1>Einführung für Anfänger</h1>
    <p>Dies ist eine schnelle BallManager-Einführung. Detailliertere Informationen findest du im <a href="support.php">Support</a>.</p>
    <p style="margin: 0px 25px 0px 260px;">Du bist der Manager und für alle Geschehnisse, die den Verein betreffen, verantwortlich. Du    erarbeitest Taktiken und Strategien, entscheidest über die Trainingsausrichtung und wählst die Spieler aus, die spielen sollen. Du    kaufst und verkaufst Spieler, investierst in das Stadion und vieles mehr.</p>
	<img style="border: 1px solid rgb(101, 146, 107); margin-left: 30px; margin-top: -130px;" src="images/tut1.png" id="tut1">
</div>
<br>
<div id="money">
    <h1>Money</h1>
    <p>Geld ist wichtig, denke daher gründlich darüber nach, wofür du es ausgeben willst. Ein sehr guter Ratschlag zu Beginn ist es, kein    Geld auszugeben, bevor du nicht weißt, was wichtig ist und wofür das Geld am Besten ausgegeben wird.</p>
    <p style="margin: 0px 250px 0px 0px;">Du nimmst Geld über Spiele, Sponsoren, Fans und Spielerverkäufe ein. Damit werden deine Ausgaben    gedeckt, die durch Spielergehälter, Spezialisten oder den Stadionunterhalt entstehen - aber auch durch Investitionen in neue Spieler    und Stadionumbauten.</p><img id="tut2" src="images/tut2.png" style="border: 1px solid rgb(101, 146, 107); margin-top: -130px; margin-left: 300px;">
</div>
<br>
<div id="players">
    <h1>Spieler</h1>
    <p>Nimm dir die Zeit, um deine Spieler und deren Fähigkeiten kennenzulernen.</p>
    <table class="thin">
                    <thead>
                        <tr>
                            <th>Position</th>
                            <th>Hauptfähigkeit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Torwart</td>
                            <td>Torwart</td>
                        </tr>
                        <tr>
                            <td>Verteidiger</td>
                            <td>Verteidigung</td>
                        </tr>
                        <tr>
                            <td>Zentrale Mittelfeldspieler</td>
                            <td>Spielaufbau</td>
                        </tr>
                        <tr>
                            <td>Flügelspieler</td>
                            <td>Flügelspiel</td>
                        </tr>
                        <tr>
                            <td>Stürmer</td>
                            <td>Torschuss</td>
                        </tr>
                    </tbody>
                </table>
</div>
<br>
<div id="spiele">
    <h1>Spiele</h1>
    <p>Eine BallManager-Saison dauert 22 Tage.</p>
    <p style="margin: 0px 25px 0px 260px;">10-12 Uhr: Cupspiele
14-16 Uhr: Ligaspiele
18-20 Uhr: Pokalspiele
22-24 Uhr: Testspiele</p>
	<img style="border: 1px solid rgb(101, 146, 107); margin-left: 30px; margin-top: -130px;" src="images/tut3.png" id="tut3">
	<p>Ferner solltest du jede Woche ein Freundschaftsspiel vereinbaren, falls du nicht (mehr) im Pokal vertreten bist. Dies geht ganz einfach über den Pool für Freundschaftsspiele. Durch das Austragen von Freundschaftsspielen kannst mehr Spieler pro Woche trainieren. Das Maximieren des Trainings ist sehr wichtig um voranzukommen.</p>
</div>
<br>
<div id="transfers">
    <h1>Transfers</h1>
    <p>Du kaufst neue Spieler auf dem Transfermarkt, und dort kannst du auch deine eigenen Spieler verkaufen.</p>
    <p style="margin: 0px 250px 0px 0px;">xxxxxxxxx xxxxx xxxxxxx.</p>
	<img id="tut4" src="images/tut4.png" style="border: 1px solid rgb(101, 146, 107); margin-top: -130px; margin-left: 300px;">
</div>
<br>
<div id="spezialisten">
    <h1>Spezialisten</h1>
    <p>Spezialisten können bei der Entwicklung deines Vereins auf unterschiedliche Weise helfen.</p>
    <p style="margin: 0px 25px 0px 260px;"> Je höher die Stufe eines Spezialisten ist, desto höher wird sein Gehalt sein. Das Fachpersonal der höchsten Stufen kann entsprechend ganz schön teuer werden, daher solltest du diese vorerst nicht einstellen, bis du dir ganz sicher bist, was du wirklich brauchst.</p>
	<img style="border: 1px solid rgb(101, 146, 107); margin-left: 30px; margin-top: -130px;" src="images/tut5.png" id="tut5">
</div>
<br>
<div id="stadion">
    <h1>Stadion</h1>
    <p></p>
    <p style="margin: 0px 250px 0px 0px;">Es wird der Zeitpunkt kommen, an dem du dein Stadion ausbauen möchtest. Ein Tipp: Das solltest    du erst angehen, wenn dein aktuelles Stadion regelmäßig ausverkauft ist. Ein früherer Ausbau ist rausgeworfenes Geld.</p>
	<img id="tut6" src="images/tut6.png" style="border: 1px solid rgb(101, 146, 107); margin-top: -130px; margin-left: 300px;">
</div>
<br>
<?php } else { ?>
<h1>Einführung für Anfänger</h1>
<p>Du musst angemeldet sein, um diese Seite aufrufen zu können!</p>
<?php } ?>
<?php include 'zz3.php'; ?>
