<main class="main-content position-relative border-radius-lg ">
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="false">
        <div class="container-fluid py-1 px-3">
            <h6 class="font-weight-bolder text-white mb-0">
                <i class="fas fa-building me-2 text-success"></i> Edit Unit
            </h6>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <div class="card shadow border-0 rounded-4">
            <div class="card-header bg-gradient-primary text-white"><strong>Form Edit Unit</strong></div>
            <div class="card-body">

                <form action="<?= base_url('Unit/edit/' . urlencode($unit['ID_UNIT'] ?? '')); ?>" method="post">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Unit Pelaksana</label>
                            <select class="form-control" name="UNIT_PELAKSANA" required>
                                <?php
                                $selected_unit_pelaksana = trim((string)($unit['UNIT_PELAKSANA'] ?? ''));
                                $opts = $unit_pelaksana_options ?? [];
                                // Pastikan nilai existing tetap ada di dropdown
                                if ($selected_unit_pelaksana !== '' && !in_array($selected_unit_pelaksana, $opts, true)) {
                                    array_unshift($opts, $selected_unit_pelaksana);
                                }
                                ?>

                                <option value="" disabled <?= ($selected_unit_pelaksana === '') ? 'selected' : '' ?>>-- Pilih Unit Pelaksana --</option>
                                <?php foreach ($opts as $val):
                                    $safeVal = htmlentities((string)$val, ENT_QUOTES, 'UTF-8');
                                    $isSelected = ($selected_unit_pelaksana === (string)$val) ? 'selected' : '';
                                ?>
                                    <option value="<?= $safeVal; ?>" <?= $isSelected; ?>><?= $safeVal; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Unit Layanan (Dropdown) -->
                        <div class="col-md-6">
                            <label class="form-label">Unit Layanan</label>
                            <select class="form-control" name="UNIT_LAYANAN" required>
                                <?php
                                $selected_unit_layanan = trim((string)($unit['UNIT_LAYANAN'] ?? ''));
                                $opts = $unit_layanan_options ?? [];
                                // Pastikan nilai existing tetap ada di dropdown
                                if ($selected_unit_layanan !== '' && !in_array($selected_unit_layanan, $opts, true)) {
                                    array_unshift($opts, $selected_unit_layanan);
                                }
                                ?>

                                <option value="" disabled <?= ($selected_unit_layanan === '') ? 'selected' : '' ?>>-- Pilih Unit Layanan --</option>
                                <?php foreach ($opts as $val):
                                    $safeVal = htmlentities((string)$val, ENT_QUOTES, 'UTF-8');
                                    $isSelected = ($selected_unit_layanan === (string)$val) ? 'selected' : '';
                                ?>
                                    <option value="<?= $safeVal; ?>" <?= $isSelected; ?>><?= $safeVal; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Longitude (X)</label>
                            <input type="text" class="form-control" name="LONGITUDEX" value="<?= htmlentities($unit['LONGITUDEX'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Latitude (Y)</label>
                            <input type="text" class="form-control" name="LATITUDEY" value="<?= htmlentities($unit['LATITUDEY'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Alamat</label>
                            <input type="text" class="form-control" name="ADDRESS" value="<?= htmlentities($unit['ADDRESS'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                        </div>

                    </div>

                    <div class="mt-4">
                        <a href="<?= base_url('Unit'); ?>" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</main>
