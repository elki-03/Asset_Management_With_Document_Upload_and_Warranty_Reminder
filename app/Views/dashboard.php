<?= $this->include('layout/header') ?>

<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card text-center" style="width: 300px;">
        <div class="card-body">
            <h2 class="card-title">Hardware verwalten</h2>
            <p class="card-text">Geräte erfassen und Dokumente verwalten.</p>
            <a href="<?= base_url('hardware/hardware_asset_table') ?>" class="btn btn-primary">
                Jetzt starten
            </a>
        </div>
    </div>
</div>

<?= $this->include('layout/footer') ?>