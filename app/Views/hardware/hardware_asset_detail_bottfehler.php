<?= $this->include('layout/header') ?>

<div class="container-fluid mt-3">
  <div class="row">

    <!-- LINKE SPALTE (col-5): Dokumente + Garantie -->
    <div class="col-5" id="linke-spalte" style="display: none;">

      <!-- GARANTIE-PANEL -->
      <div id="garantie-panel" style="display: none;" class="card mb-3">
        <div class="card-body">
          <h5>Garantie</h5>
          <?= $this->include('hardware/garantie_partial') ?>
        </div>
      </div>

      <!-- DOKUMENTE-PANEL -->
      <div id="dokumente-panel" class="card">
        <div class="card-body">
          <h5>Dokumente</h5>
          <?= $this->include('hardware/dokumente_partial') ?>
        </div>
      </div>

    </div>

    <!-- RECHTE SPALTE -->
    <div class="col-12 ps-4" id="detail-spalte">

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

      <button class="btn btn-secondary" onclick="zeigeDokumente()">
        Zugehörige Dokumente
      </button>

      <br><br>

      <?php if(auth()->user()->inGroup('admin', 'superadmin')): ?>
        <div class="d-flex align-items-center gap-2">
          <a href="<?= base_url('hardware/hardware_asset_detail_edit/' . $hw['hardwareID']) ?>">
            <img src="<?= base_url('/images/update_button.png') ?>" alt="Bearbeiten">
          </a>
          <form action="<?= base_url('hardware/deleteHw/' . $hw['hardwareID']) ?>" method="post" class="m-0">
            <?= csrf_field() ?>
            <button type="submit" class="btn p-0 border-0 bg-transparent">
              <img src="<?= base_url('/images/delete_button.png') ?>" alt="Löschen">
            </button>
          </form>
        </div>
      <?php endif; ?>

    </div>
  </div>
</div>

<?= $this->include('layout/footer') ?>

<script>
  function zeigeDokumente() {
    document.getElementById('linke-spalte').style.display = 'block';
    const detail = document.getElementById('detail-spalte');
    detail.classList.remove('col-12');
    detail.classList.add('col-7');
  }

  function zeigeGarantie() {
    document.getElementById('garantie-panel').style.display = 'block';
  }
</script>