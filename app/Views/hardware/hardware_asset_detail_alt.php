<?= $this->include('layout/header') ?>

    <h1>Hardware-Asset-Detail</h1>
        <p>Asset Name: <?php echo esc($hw['hw_name']) ?></p>
        <p>Typ: <?php echo esc($hw['hw_type']) ?></p>
        <p>Funktion: <?php echo esc($hw['hw_function']) ?></p>
        <p>Hersteller: <?php echo esc($hw['hw_manufacturer']) ?></p>
        <p>Modell: <?php echo esc($hw['hw_model']) ?></p>
        <p>Seriennummer: <?php echo esc($hw['hw_serial_number']) ?></p>
        <p>Inventar: <?php echo esc($hw['hw_inventory']) ? '✓' : '✗' ?></p>
        <p>Abgeschrieben: <?php echo esc($hw['hw_deprecated']) ? '✓' : '✗' ?></p>
        <p>In Verwendung: <?php echo esc($hw['hw_status']) ?></p>
        <p>Mit Netzwerkkarte (evtl unsichtbar?): <?php echo esc($hw['hw_has_network_interface_card']) ? '✓' : '✗' ?></p>
        <!-- later implementation -->
        <!-- <p>Owner: <?php // echo esc($hw['ownerID']) ?></p>
        <p>Owner-Vertreter: <?php // echo esc($hw['owner_deputyID']) ?></p>
        <p>Admin: <?php // echo esc($hw['adminID']) ?></p>
        <p>Admin-Vertreter: <?php // echo esc($hw['admin_deputyID']) ?></p> -->

        <?php //if ($hw['hw_has_network_interface_card'] && !empty($hw['mac_adress'])): //für später?>
        <?php if ($hw['hw_has_network_interface_card']): ?>
            <h2>Netzwerkkarte</h2>
            <p>MAC-Adresse: <?= esc($hw['mac_adress']) ?></p>
            <p>IP: <?= esc($hw['ip_adress']) ?></p>
        <?php endif; ?>


        
        <a href="<?= base_url('hardware/' . $hw['hardwareID'] . '/documents') ?>">
            <button>Zugehörige Dokumente</button>
        </a>
        <br>
        <br>

        <a href="<?= base_url('hardware/hardware_asset_detail_edit/' . $hw['hardwareID']) ?>">
            <?php if(auth()->user()->inGroup('admin', 'superadmin')): ?>
                <img src="<?= base_url('/images/update_button.png') ?>" alt="Bearbeiten">
            <?php endif; ?>
        </a>

        <!-- wirklich löschen? hinzufügen -->
        <form action="<?= base_url('hardware/deleteHw/' . $hw['hardwareID']) ?>" method="post">
            <?= csrf_field() ?>
            <?php if(auth()->user()->inGroup('admin', 'superadmin')): ?>
                <button type="submit"><img src= "<?= base_url('/images/delete_button.png') ?>" alt="Löschen"></button>
            <?php endif; ?>
        </form>

<?= $this->include('layout/footer') ?>