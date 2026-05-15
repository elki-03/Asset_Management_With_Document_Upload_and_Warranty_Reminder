<?= $this->include('layout/header') ?>

<div class="container mt-3">
    <div class="row justify-content-center">

        <!-- GLEICHE GESAMTBREITE WIE DETAILVIEW -->
        <div class="col-12 col-xxl-10">

            <div class="row">

                <!-- UNSICHTBARE LINKE SPALTE -->
                <div class="col-5">
                    <!-- absichtlich leer -->
                </div>

                <!-- RECHTE SPALTE -->
                <div class="col-7">

                    <!-- Fehleranzeige -->
                    <?php if (session()->has('errors')):?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach (session('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-body">

                            <h1 class="mb-4">Hardware-Asset-Detail</h1>

                            <form action="<?= !empty($single_hw['hardwareID'])
                                ? base_url('hardware/update/' . $single_hw['hardwareID'])
                                : base_url('hardware/createHw');
                            ?>" method="post">

                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="hw_name" class="form-label">Asset Name:</label>
                                <input class="form-control"
                                       type="text"
                                       name="hw_name"
                                       value="<?php echo set_value('hw_name', $single_hw['hw_name'] ?? '') ?>">
                            </div>

                            <div class="mb-3">
                                <label for="hw_type" class="form-label">Kategorie:</label>
                                <input class="form-control"
                                       type="text"
                                       name="hw_type"
                                       value="<?php echo set_value('hw_type', $single_hw['hw_type'] ?? '') ?>">
                            </div>

                            <div class="mb-3">
                                <label for="hw_function" class="form-label">Funktion:</label>
                                <input class="form-control"
                                       type="text"
                                       name="hw_function"
                                       value="<?php echo set_value('hw_function', $single_hw['hw_function'] ?? '') ?>">
                            </div>

                            <div class="mb-3">
                                <label for="hw_manufacturer" class="form-label">Hersteller:</label>
                                <input class="form-control"
                                       type="text"
                                       name="hw_manufacturer"
                                       value="<?php echo set_value('hw_manufacturer', $single_hw['hw_manufacturer'] ?? '') ?>">
                            </div>

                            <div class="mb-3">
                                <label for="hw_model" class="form-label">Modell:</label>
                                <input class="form-control"
                                       type="text"
                                       name="hw_model"
                                       value="<?php echo set_value('hw_model', $single_hw['hw_model'] ?? '') ?>">
                            </div>

                            <div class="mb-3">
                                <label for="hw_serial_number" class="form-label">Seriennummer:</label>
                                <input class="form-control"
                                       type="text"
                                       name="hw_serial_number"
                                       value="<?php echo set_value('hw_serial_number', $single_hw['hw_serial_number'] ?? '') ?>">
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="hw_inventory"
                                       value="1"
                                       <?= set_checkbox('hw_inventory', '1', ($single_hw['hw_inventory'] ?? 0) == 1) ?>>

                                <label class="form-check-label" for="hw_inventory">
                                    Inventar
                                </label>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="hw_deprecated"
                                       value="1"
                                       <?= set_checkbox('hw_deprecated', '1', ($single_hw['hw_deprecated'] ?? 0) == 1) ?>>

                                <label class="form-check-label" for="hw_deprecated">
                                    Abgeschrieben
                                </label>
                            </div>

                            <div class="mb-3">
                                <label for="hw_status" class="form-label">Status:</label>

                                <select class="form-select" name="hw_status">
                                    <option value="In Verwendung">In Verwendung</option>
                                    <option value="Defekt">Defekt</option>
                                    <option value="In Reparatur">In Reparatur</option>
                                </select>
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="hw_has_network_interface_card"
                                       value="1"
                                       <?= set_checkbox(
                                            'hw_has_network_interface_card',
                                            '1',
                                            ($single_hw['hw_has_network_interface_card'] ?? 0) == 1) ?>>

                                <label class="form-check-label" for="hw_has_network_interface_card">
                                    Mit Netzwerkkarte
                                </label>
                            </div>

                            <h4 class="mb-3">Geräte mit Netzwerkkarte</h4>

                            <div class="mb-3">
                                <label for="mac_adress" class="form-label">MAC-Adresse:</label>
                                <input class="form-control"
                                       type="text"
                                       name="mac_adress"
                                       value="<?php echo set_value('mac_adress', $single_hw['mac_adress'] ?? '') ?>">
                            </div>

                            <div class="mb-4">
                                <label for="ip_adress" class="form-label">IP:</label>
                                <input class="form-control"
                                       type="text"
                                       name="ip_adress"
                                       value="<?php echo set_value('ip_adress', $single_hw['ip_adress'] ?? '') ?>">
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Bestätigen
                            </button>

                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('layout/footer') ?>