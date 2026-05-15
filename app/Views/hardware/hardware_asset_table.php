<?= $this->include('layout/header') ?>

<h1 class="text-center mb-3">Hardware-Asset-Tabelle</h1>

<div class="text-center mb-3">
    <a href="<?= base_url('hardware/hardware_asset_detail_create') ?>">
        <?php if(auth()->user()->inGroup('admin', 'superadmin')): ?>
            <img src="<?= base_url('/images/create_button.png') ?>" alt="Neuer Eintrag">
        <?php endif; ?>
    </a>
</div>

<?php if (!empty($hw_list)): ?>
<div class="d-flex justify-content-center">
    <table class="table table-bordered" style="width: auto;">
        <thead class="table-dark">
            <tr>
                <th>Asset Name</th>
                <th>Typ</th>
                <th>Funktion</th>
                <th>Hersteller</th>
                <th>Modell</th>
                <th>Seriennummer</th>
                <th>In Verwendung</th>
                <th>Mit Netzwerkkarte</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($hw_list as $single_hw): ?>
            <tr>
                <td><?= esc($single_hw['hw_name']) ?></td>
                <td><?= esc($single_hw['hw_type']) ?></td>
                <td><?= esc($single_hw['hw_function']) ?></td>
                <td><?= esc($single_hw['hw_manufacturer']) ?></td>
                <td><?= esc($single_hw['hw_model']) ?></td>
                <td><?= esc($single_hw['hw_serial_number']) ?></td>
                <td><?= esc($single_hw['hw_status']) ?></td>
                <td class="text-center"><?= esc($single_hw['hw_has_network_interface_card']) ? '✓' : '✗' ?></td>
                <td>
                    <div class="d-flex align-items-center gap-1">
                        <?php if(auth()->user()->inGroup('admin', 'superadmin')): ?>
                            <a href="<?= base_url('hardware/hardware_asset_detail_edit/' . $single_hw['hardwareID']) ?>">
                                <img src="<?= base_url('/images/update_button.png') ?>" alt="Bearbeiten">
                            </a>
                            <form action="<?= base_url('hardware/deleteHw/' . $single_hw['hardwareID']) ?>" method="post" class="m-0">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn p-0 border-0 bg-transparent">
                                    <img src="<?= base_url('/images/delete_button.png') ?>" alt="Löschen">
                                </button>
                            </form>
                        <?php endif; ?>
                        <a href="<?= base_url('hardware/hardware_asset_detail/' . $single_hw['hardwareID']) ?>">
                            <img src="<?= base_url('/images/detail_button.png') ?>" alt="Detail">
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php else: ?>
    <p class="text-center">Keine Einträge vorhanden.</p>
<?php endif; ?>

<!-- Zebrastreifen in Aquamarinblau -->
<!-- <style>
    tbody tr:nth-child(even) {
        background-color: rgba(127, 255, 212, 0.15);
    }
    tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }
</style> -->

<?= $this->include('layout/footer') ?>