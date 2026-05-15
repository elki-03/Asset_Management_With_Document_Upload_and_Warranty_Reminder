<!-- app/Views/contact/form.php -->
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Kontakt</title>
</head>
<body>

<h1>Kontaktformular</h1>

<!-- Allgemeine Fehlermeldung (z. B. SMTP-Fehler) -->
<?php if (isset($error)): ?>
    <p style="color:red;"><?= esc($error) ?></p>
<?php endif ?>

<!-- Validierungsfehler gesammelt ausgeben -->
<?php if (isset($validation)): ?>
    <?= $validation->listErrors() ?>
<?php endif ?>

<!--
    form_open() erzeugt das <form>-Tag UND fügt automatisch das CSRF-Hidden-Field ein.
    Alternativ: <form method="post"> + <?php// echo csrf_field() ?>
-->
<?= form_open('/kontakt') ?>

    <label for="name">Name *</label><br>
    <!-- old() füllt das Feld nach einem Fehler mit dem vorherigen Wert vor -->
    <input
        type="text"
        id="name"
        name="name"
        value="<?= esc(old('name', $old['name'] ?? '')) ?>"
        maxlength="100"
        required
    ><br><br>

    <label for="email">E-Mail-Adresse *</label><br>
    <input
        type="email"
        id="email"
        name="email"
        value="<?= esc(old('email', $old['email'] ?? '')) ?>"
        maxlength="254"
        required
    ><br><br>

    <label for="betreff">Betreff *</label><br>
    <input
        type="text"
        id="betreff"
        name="betreff"
        value="<?= esc(old('betreff', $old['betreff'] ?? '')) ?>"
        maxlength="150"
        required
    ><br><br>

    <label for="nachricht">Nachricht *</label><br>
    <textarea
        id="nachricht"
        name="nachricht"
        rows="6"
        maxlength="3000"
        required
    ><?= esc(old('nachricht', $old['nachricht'] ?? '')) ?></textarea><br><br>

    <button type="submit">Nachricht senden</button>

<?= form_close() ?>

</body>
</html>