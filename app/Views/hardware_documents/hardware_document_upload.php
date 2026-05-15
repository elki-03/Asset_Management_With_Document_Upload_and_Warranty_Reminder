<?php
$documentTypeLabels = [
    'manual'   => 'Handbuch',
    'warranty' => 'Garantie',
    'invoice'  => 'Rechnung',
    'other'    => 'Sonstiges',
];
?>

<h5>Dokumente</h5>

<?php if (!empty($documents)): ?>
  <ul>
  <?php foreach ($documents as $document): ?>
    <li>
      <a href="<?= site_url('/hardware/' . $hardwareId . '/documents/' . $document['documentID'] . '/show') ?>"
         target="_blank">
        <?= esc($document['original_filename']) ?>
      </a>
      (<?= number_format($document['file_size'] / 1024, 1) ?> KB)
      <?= esc($documentTypeLabels[$document['document_type']] ?? $document['document_type']) ?>

      <?php if(auth()->user()->inGroup('admin', 'superadmin')): ?>
        <form action="<?= site_url('/hardware/' . $hardwareId . '/documents/' . $document['documentID'] . '/delete') ?>"
              method="post" style="display:inline"
              onsubmit="return confirm('Dokument wirklich löschen?')">
          <?= csrf_field() ?>
          <button type="submit">
            <img src="<?= base_url('/images/delete_button.png') ?>" alt="Löschen">
          </button>
        </form>
      <?php endif; ?>

      <?php if ($document['document_type'] === 'warranty'): ?>
        <!-- Dieser Button klappt das Garantie-Panel auf -->
        <button class="btn btn-sm btn-outline-info"
                data-bs-toggle="collapse"
                data-bs-target="#garantie-panel">
          Garantie öffnen
        </button>
      <?php endif; ?>

    </li>
  <?php endforeach ?>
  </ul>
<?php else: ?>
  <p>Keine Dokumente vorhanden.</p>
<?php endif; ?>

<h5>Dokument hochladen</h5>

<form action="<?= site_url('/hardware/' . $hardwareId . '/documents/upload') ?>"
      method="post"
      enctype="multipart/form-data">
  <?= csrf_field() ?>

  <select name="document_type">
    <option value="other">Sonstiges</option>
    <option value="warranty">Garantie</option>
    <option value="invoice">Rechnung</option>
    <option value="manual">Handbuch</option>
  </select>

  <input type="file" name="pdf" accept=".pdf">

  <?php if(auth()->user()->inGroup('admin', 'superadmin')): ?>
    <button type="submit">PDF hochladen</button>
  <?php endif; ?>

</form>