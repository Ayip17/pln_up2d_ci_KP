<main class="main-content position-relative border-radius-lg">
    <!-- Header -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur">
        <div class="container-fluid py-1 px-3">
            <h6 class="font-weight-bolder text-white mb-0">
                <i class="fas fa-edit me-2 text-warning"></i> Edit Rekap PRK
            </h6>
        </div>
    </nav>

    <div class="container-fluid py-4">

        <div class="card shadow border-0 rounded-4">
            <div class="card-header bg-gradient-primary text-white rounded-top-4">
                <strong>Form Edit Rekap PRK</strong>
            </div>

            <div class="card-body">
                <form action="<?= base_url('rekap_prk/edit/' . $rekap['ID_PRK']); ?>" method="POST">

                    <input type="hidden" name="original_id" value="<?= $rekap['ID_PRK']; ?>">

                    <div class="row g-4">

                        <!-- Jenis Anggaran -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jenis Anggaran</label>
                            <select name="JENIS_ANGGARAN" class="form-select modern-select" required>
                                <option value="CAPEX" <?= $rekap['JENIS_ANGGARAN'] === 'CAPEX' ? 'selected' : '' ?>>INVESTASI</option>
                                <option value="OPEX" <?= $rekap['JENIS_ANGGARAN'] === 'OPEX' ? 'selected' : '' ?>>OPERASI</option>
                            </select>
                        </div>

                        <!-- Nomor PRK -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nomor PRK</label>
                            <select name="NOMOR_PRK" class="form-select modern-select" required>
                                <?php foreach ($prk_list as $p): ?>
                                    <option value="<?= $p['NOMOR_PRK']; ?>"
                                        <?= $rekap['NOMOR_PRK'] === $p['NOMOR_PRK'] ? 'selected' : '' ?>>
                                        <?= $p['NOMOR_PRK']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Uraian PRK -->
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Uraian PRK</label>
                            <textarea name="URAIAN_PRK" class="form-control modern-input" rows="2" required><?= $rekap['URAIAN_PRK']; ?></textarea>
                        </div>

                        <!-- Pagu SKK IO -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Pagu SKK-IO</label>
                            <input type="text" name="PAGU_SKK_IO" value="<?= $rekap['PAGU_SKK_IO']; ?>" class="form-control modern-input money-input">
                        </div>

                        <!-- Rencana Kontrak -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Rencana Kontrak</label>
                            <input type="text" name="RENC_KONTRAK" value="<?= $rekap['RENC_KONTRAK']; ?>" class="form-control modern-input money-input">
                        </div>

                        <!-- NODIN -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">NODIN / Surat</label>
                            <input type="text" name="NODIN_SRT" value="<?= $rekap['NODIN_SRT']; ?>" class="form-control modern-input">
                        </div>

                        <!-- Kontrak -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Kontrak</label>
                            <input type="text" name="KONTRAK" value="<?= $rekap['KONTRAK']; ?>" class="form-control modern-input money-input">
                        </div>

                        <!-- Sisa -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Sisa</label>
                            <input type="text" name="SISA" value="<?= $rekap['SISA']; ?>" class="form-control modern-input money-input">
                        </div>

                        <!-- Rencana Bayar -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Rencana Bayar</label>
                            <input type="text" name="RENCANA_BAYAR" value="<?= $rekap['RENCANA_BAYAR']; ?>" class="form-control modern-input money-input">
                        </div>

                        <!-- Terbayar -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Terbayar</label>
                            <input type="text" name="TERBAYAR" value="<?= $rekap['TERBAYAR']; ?>" class="form-control modern-input money-input">
                        </div>

                        <!-- Ke Tahun 2026 -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Ke Tahun 2026</label>
                            <input type="text" name="KE_TAHUN_2026" value="<?= $rekap['KE_TAHUN_2026']; ?>" class="form-control modern-input money-input">
                        </div>

                        <!-- Buttons -->
                        <div class="col-12 mt-4">
                            <a href="<?= base_url('rekap_prk'); ?>" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>

                            <button type="submit" class="btn btn-primary ms-2">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

    </div>
</main>

<style>
    .modern-select,
    .modern-input {
        border-radius: 10px;
        border: 1px solid #d0d7e3;
        padding: 10px 12px;
        transition: .2s ease;
    }

    .modern-select:focus,
    .modern-input:focus {
        border-color: #4e73df !important;
        box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.25);
    }

    .bg-gradient-primary {
        background: linear-gradient(90deg, #005C99, #0099CC);
    }
</style>