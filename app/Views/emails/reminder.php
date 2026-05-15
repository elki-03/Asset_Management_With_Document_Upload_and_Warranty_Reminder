<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <h2>Garantieerinnerung</h2>

    <p>Guten Tag,</p>

    <p>die folgende Garantie läuft in <strong>3 Wochen</strong> ab:</p>

    <table border="1" cellpadding="8">
        <tr>
            <td><strong>Asset-ID</strong></td>
            <td><?= esc($documentID) ?></td>
        </tr>
        <tr>
            <td><strong>Ablaufdatum</strong></td>
            <td><?= esc($expiration_date) ?></td>
        </tr>
    </table>

    <p>Bitte rechtzeitig um Verlängerung oder Ersatz kümmern.</p>

    <p>Mit freundlichen Grüßen<br>Garantieverwaltung</p>
</body>
</html>