<?= $this->include('layout/header') ?>

<div class="container mt-3">
  <div class="row justify-content-center">

    <!-- INNERER WRAPPER (begrenzt Gesamtbreite & zentriert alles) -->
    <div class="col-12 col-xxl-10">

      <div class="row">

        <!-- LINKE SPALTE -->
        <div class="col-5">

          <?php foreach ($warranties as $documentID => $single_warranty): ?>
            <div class="collapse mb-2" id="garantie-<?= $documentID ?>">
              <div class="card">
                <div class="card-body">

                  <h5>Garantie</h5>

                  <?php if (session()->getFlashdata('success')): ?>
                    <p><?= session()->getFlashdata('success') ?></p>
                  <?php endif; ?>

                  <?= form_open('/garantie') ?>
                    <input type="hidden" name="documentID" value="<?= esc($single_warranty['documentID']) ?>">

                    <label for="expiration_date_<?= $documentID ?>">Ablaufdatum</label><br>
                    <input type="date"
                           id="expiration_date_<?= $documentID ?>"
                           name="expiration_date"
                           value="<?= esc($single_warranty['expiration_date']) ?>">

                    <br><br>

                    <label>
                      <input type="checkbox"
                             name="expiration_reminder_check"
                             value="1"
                             <?= $single_warranty['expiration_reminder_check'] ? 'checked' : '' ?>>
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

                </div>
              </div>
            </div>
          <?php endforeach ?>

          <div class="collapse" id="dokumente-panel">
            <div class="card">
              <div class="card-body">

                <h5>Dokumente</h5>

                <?php
                $documentTypeLabels = [
                    'manual'   => 'Handbuch',
                    'warranty' => 'Garantie',
                    'invoice'  => 'Rechnung',
                    'other'    => 'Sonstiges',
                ];
                ?>

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
                              method="post"
                              style="display:inline"
                              onsubmit="return confirm('Dokument wirklich löschen?')">
                          <?= csrf_field() ?>
                          <button type="submit">
                            <img src="<?= base_url('/images/delete_button.png') ?>" alt="Löschen">
                          </button>
                        </form>
                      <?php endif; ?>

                      <?php if ($document['document_type'] === 'warranty'): ?>
                        <button class="btn btn-sm btn-outline-info"
                                data-bs-toggle="collapse"
                                data-bs-target="#garantie-<?= $document['documentID'] ?>">
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

              </div>
            </div>
          </div>

        </div>

        <!-- RECHTE SPALTE -->
        <div class="col-7">

          <h1>Hardware-Asset-Detail</h1>

          <p>Asset Name: <?= esc($hw['hw_name']) ?></p>
          <p>Typ: <?= esc($hw['hw_type']) ?></p>
          <p>Funktion: <?= esc($hw['hw_function']) ?></p>
          <p>Hersteller: <?= esc($hw['hw_manufacturer']) ?></p>
          <p>Modell: <?= esc($hw['hw_model']) ?></p>
          <p>Seriennummer: <?= esc($hw['hw_serial_number']) ?></p>
          <p>Inventar: <?= $hw['hw_inventory'] ? '✓' : '✗' ?></p>
          <p>Abgeschrieben: <?= $hw['hw_deprecated'] ? '✓' : '✗' ?></p>
          <p>In Verwendung: <?= esc($hw['hw_status']) ?></p>
          <p>Mit Netzwerkkarte: <?= $hw['hw_has_network_interface_card'] ? '✓' : '✗' ?></p>

          <?php if ($hw['hw_has_network_interface_card']): ?>
            <h2>Netzwerkkarte</h2>
            <p>MAC-Adresse: <?= esc($hw['mac_adress']) ?></p>
            <p>IP: <?= esc($hw['ip_adress']) ?></p>
          <?php endif; ?>

          <br>

          <div class="d-flex align-items-center gap-2 flex-wrap mt-3">

            <button class="btn btn-secondary btn-sm"
                    data-bs-toggle="collapse"
                    data-bs-target="#dokumente-panel">
              Zugehörige Dokumente
            </button>

            <?php if(auth()->user()->inGroup('admin', 'superadmin')): ?>

              <a class="btn btn-outline-primary btn-sm d-flex align-items-center"
                 href="<?= base_url('hardware/hardware_asset_detail_edit/' . $hw['hardwareID']) ?>">
                <img src="<?= base_url('/images/update_button.png') ?>" alt="Bearbeiten">
              </a>

              <form action="<?= base_url('hardware/deleteHw/' . $hw['hardwareID']) ?>"
                    method="post"
                    class="m-0">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-outline-danger btn-sm d-flex align-items-center">
                  <img src="<?= base_url('/images/delete_button.png') ?>" alt="Löschen">
                </button>
              </form>

            <?php endif; ?>

          </div>

        </div>

      </div>
    </div>
  </div>
</div>

<?= $this->include('layout/footer') ?>