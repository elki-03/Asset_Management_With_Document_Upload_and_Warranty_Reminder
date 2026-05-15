<h5>Garantie</h5>

<?php if (session()->getFlashdata('success')): ?>
  <p><?= session()->getFlashdata('success') ?></p>
<?php endif; ?>

<?= form_open('/garantie') ?>

  <input type="hidden" name="documentID" value="<?= esc($single_warranty['documentID']) ?>">

  <label for="expiration_date">Ablaufdatum</label><br>
  <input type="date"
         id="expiration_date"
         name="expiration_date"
         value="<?= esc($single_warranty['expiration_date']) ?>">

  <br><br>

  <label>
    <input type="checkbox"
           name="expiration_reminder_check"
           value="1"
           <?= set_checkbox('expiration_reminder_check', '1', $single_warranty['expiration_reminder_check'] == true) ?>>
    Erinnerung per E-Mail drei Wochen vor Ablauf
  </label>

  <?php if ($single_warranty['reminder_sent']): ?>
    <p>Erinnerung gesendet</p>
  <?php endif; ?>

  <br><br>

  <?php if(auth()->user()->inGroup('admin', 'superadmin')): ?>
    <button type="submit">Bearbeiten</button>
  <?php endif; ?>

<?= form_close() ?>