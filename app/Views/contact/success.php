<!-- app/Views/contact/success.php -->
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Vielen Dank</title>
</head>
<body>
    <h1>Vielen Dank!</h1>
    <?php if (session()->has('success')): ?>
        <p><?= esc(session('success')) ?></p>
    <?php endif ?>
    <a href="/kontakt">Zurück zum Formular</a>
</body>
</html>