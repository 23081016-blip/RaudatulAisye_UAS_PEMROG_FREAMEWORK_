

<?php $__env->startSection('content'); ?>
<!-- Custom Styles untuk Kombinasi Biru & Hitam -->
<style>
    .nav-pills .nav-link.active {
        background-color: #0d6efd !important;
        color: white !important;
    }
    .nav-pills .nav-link {
        color: #212529 !important;
    }
    .nav-pills .nav-link:hover {
        background-color: #f8f9fa;
    }
</style>

<div class="row">
    <!-- Feedback Alert -->
    <?php if(session('success')): ?>
    <div class="col-12 mb-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    <?php endif; ?>

    <div class="col-12 mb-4">
        <h2 class="fw-bold text-dark">Sistem Informasi Bengkel Maju Motor</h2>
    </div>

    <!-- Navigasi Menu Tabs Utama -->
    <div class="col-12 mb-4">
        <ul class="nav nav-pills nav-fill bg-white p-2 rounded shadow-sm border" id="superTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold py-3" id="admin-tab" data-bs-toggle="tab" data-bs-target="#admin-panel" type="button" role="tab">🛠️ PANEL ADMIN (Master Data)</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold py-3" id="mekanik-tab" data-bs-toggle="tab" data-bs-target="#mekanik-panel" type="button" role="tab">🔧 PANEL MEKANIK (Antrean)</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold py-3" id="kasir-tab" data-bs-toggle="tab" data-bs-target="#kasir-panel" type="button" role="tab">💰 PANEL KASIR (Pembayaran)</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold py-3" id="laporan-tab" data-bs-toggle="tab" data-bs-target="#laporan-panel" type="button" role="tab">📊 PANEL LAPORAN</button>
            </li>
        </ul>
    </div>

    <!-- Isi Konten Tiap Navigasi Halaman -->
    <div class="col-12">
        <div class="tab-content" id="superTabContent">
            
            <!-- ======================= TABEL ADMIN ======================= -->
            <div class="tab-pane fade show active" id="admin-panel" role="tabpanel">
                <!-- SECTION 1: CRUD SPAREPART -->
                <div class="row mb-5">
                    <div class="col-md-4">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-dark text-white"><h6 class="mb-0 fw-bold">Tambah Sparepart Baru</h6></div>
                            <div class="card-body">
                                <form action="<?php echo e(route('super.sparepart.store')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="mb-3"><label class="form-label">Nama Sparepart</label><input type="text" name="nama_sparepart" class="form-control" required></div>
                                    <div class="mb-3"><label class="form-label">Harga (Rp)</label><input type="number" name="harga" class="form-control" min="0" required></div>
                                    <div class="mb-3"><label class="form-label">Stok Awal</label><input type="number" name="stok" class="form-control" min="0" required></div>
                                    <button type="submit" class="btn btn-primary w-100 fw-bold">Simpan Sparepart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white border-bottom"><h6 class="mb-0 text-dark fw-bold">Katalog Sparepart Bengkel</h6></div>
                            <div class="card-body">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light"><tr><th>#</th><th>Nama Sparepart</th><th>Harga</th><th>Stok</th><th class="text-center">Aksi</th></tr></thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $spareparts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $sp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($index + 1); ?></td>
                                            <td class="fw-bold text-dark"><?php echo e($sp->nama_sparepart); ?></td>
                                            <td>Rp <?php echo e(number_format($sp->harga, 0, ',', '.')); ?></td>
                                            <td><span class="badge <?php echo e($sp->stok > 5 ? 'bg-primary' : 'bg-danger'); ?>"><?php echo e($sp->stok); ?> Pcs</span></td>
                                            <td class="text-center">
                                                <button class="btn btn-warning btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editSp<?php echo e($sp->id); ?>">Edit</button>
                                                <form action="<?php echo e(route('super.sparepart.destroy', $sp->id)); ?>" method="POST" class="d-inline"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')">Hapus</button></form>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr><td colspan="5" class="text-center text-muted">Belum ada data sparepart.</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: CRUD JASA PERBAIKAN -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-dark text-white"><h6 class="mb-0 fw-bold">Tambah Jasa Perbaikan Baru</h6></div>
                            <div class="card-body">
                                <form action="<?php echo e(route('super.jasa.store')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="mb-3"><label class="form-label">Nama Jenis Jasa</label><input type="text" name="nama_jasa" class="form-control" placeholder="Contoh: Servis CVT" required></div>
                                    <div class="mb-3"><label class="form-label">Tarif Harga (Rp)</label><input type="number" name="harga" class="form-control" min="0" placeholder="0" required></div>
                                    <button type="submit" class="btn btn-primary w-100 fw-bold">Simpan Jasa</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white border-bottom"><h6 class="mb-0 text-dark fw-bold">Daftar Ongkos / Jasa Servis</h6></div>
                            <div class="card-body">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light"><tr><th>#</th><th>Nama Jasa Servis</th><th>Tarif Biaya</th><th class="text-center">Aksi</th></tr></thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $jasas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $js): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($index + 1); ?></td>
                                            <td class="fw-bold text-secondary"><?php echo e($js->nama_jasa); ?></td>
                                            <td class="text-primary fw-bold">Rp <?php echo e(number_format($js->harga, 0, ',', '.')); ?></td>
                                            <td class="text-center">
                                                <button class="btn btn-warning btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editJs<?php echo e($js->id); ?>">Edit</button>
                                                <form action="<?php echo e(route('super.jasa.destroy', $js->id)); ?>" method="POST" class="d-inline"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus tipe jasa ini?')">Hapus</button></form>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr><td colspan="4" class="text-center text-muted">Belum ada data master jasa.</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ======================= TABEL MEKANIK ======================= -->
            <div class="tab-pane fade" id="mekanik-panel" role="tabpanel">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white fw-bold"><h6 class="mb-0">Daftar Antrean & Kerja Mekanik</h6></div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light"><tr><th>Pelanggan</th><th>Plat Nomor</th><th>Keluhan</th><th>Status</th><th>Biaya Sementara</th><th class="text-center">Tindakan</th></tr></thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $daftarServis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $servis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><strong><?php echo e($servis->kendaraan->user->name); ?></strong><br><small class="text-muted"><?php echo e($servis->kendaraan->merk); ?> - <?php echo e($servis->kendaraan->tipe); ?></small></td>
                                    <td><span class="badge bg-dark"><?php echo e($servis->kendaraan->plat_nomor); ?></span></td>
                                    <td><?php echo e($servis->keluhan); ?></td>
                                    <td><span class="badge <?php echo e($servis->status == 'antrean' ? 'bg-warning text-dark' : 'bg-primary'); ?>"><?php echo e(ucfirst($servis->status)); ?></span></td>
                                    <td class="text-primary fw-bold">Rp <?php echo e(number_format($servis->total_biaya, 0, ',', '.')); ?></td>
                                    <td class="text-center">
                                        <?php if($servis->status == 'antrean'): ?>
                                            <form action="<?php echo e(route('super.servis.status', [$servis->id, 'dikerjakan'])); ?>" method="POST"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?><button type="submit" class="btn btn-primary btn-sm fw-bold">Ambil Kerjakan</button></form>
                                        <?php elseif($servis->status == 'dikerjakan'): ?>
                                            <button class="btn btn-warning btn-sm fw-bold text-white me-1" data-bs-toggle="modal" data-bs-target="#tindakanModal<?php echo e($servis->id); ?>">Input Sparepart/Jasa</button>
                                            <form action="<?php echo e(route('super.servis.status', [$servis->id, 'selesai'])); ?>" method="POST" class="d-inline"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?><button type="submit" class="btn btn-success btn-sm fw-bold">Set Selesai</button></form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="6" class="text-center text-muted">Tidak ada pengerjaan aktif.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ======================= TABEL KASIR ======================= -->
            <div class="tab-pane fade" id="kasir-panel" role="tabpanel">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white fw-bold"><h6 class="mb-0">Kasir - Siap Lunas Dibayar</h6></div>
                    <div class="card-body">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-light"><tr><th>Pelanggan</th><th>Kendaraan</th><th>Plat Nomor</th><th>Total Tagihan</th><th class="text-center">Aksi Transaksi</th></tr></thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $transaksi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="fw-bold text-dark"><?php echo e($tr->kendaraan->user->name); ?></td>
                                    <td><?php echo e($tr->kendaraan->merk); ?> - <?php echo e($tr->kendaraan->tipe); ?></td>
                                    <td><span class="badge bg-dark"><?php echo e($tr->plat_nomor ?? $tr->kendaraan->plat_nomor); ?></span></td>
                                    <td class="fw-bold text-primary">Rp <?php echo e(number_format($tr->total_biaya, 0, ',', '.')); ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm text-white fw-bold me-1" data-bs-toggle="modal" data-bs-target="#notaModalSuper<?php echo e($tr->id); ?>">Cetak Rincian</button>
                                        <form action="<?php echo e(route('super.servis.bayar', $tr->id)); ?>" method="POST" class="d-inline"><?php echo csrf_field(); ?><button type="submit" class="btn btn-primary btn-sm fw-bold">Bayar Lunas</button></form>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="5" class="text-center text-muted">Belum ada antrean bill pembayaran masuk di kasir.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ======================= TABEL LAPORAN PENDAPATAN ======================= -->
            <div class="tab-pane fade" id="laporan-panel" role="tabpanel">
                <div class="row">
                    <!-- Card Ringkasan Omzet Finansial -->
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 bg-primary text-white shadow-sm">
                            <div class="card-body p-4">
                                <h6 class="text-white-50 mb-1 fw-bold">TOTAL PENDAPATAN BENGKEL</h6>
                                <h2 class="fw-bold mb-0">Rp <?php echo e(number_format($totalPendapatan, 0, ',', '.')); ?></h2>
                                <small class="text-white-50 mt-2 d-block">Akumulasi biaya servis masuk</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 bg-dark text-white shadow-sm">
                            <div class="card-body p-4">
                                <h6 class="text-white-50 mb-1 fw-bold">TOTAL TRANSAKSI SERVIS</h6>
                                <h2 class="fw-bold mb-0"><?php echo e($riwayatServis->count()); ?> Kendaraan</h2>
                                <small class="text-white-50 mt-2 d-block">Total unit selesai dikerjakan</small>
                            </div>
                        </div>
                    </div>

                    <!-- Rekapitulasi Riwayat Detail Jurnal Servis -->
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white py-3 fw-bold text-secondary border-bottom">
                                📋 Jurnal Riwayat Transaksi & Pendapatan Bengkel
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Nama Pemilik</th>
                                                <th>Plat Kendaraan</th>
                                                <th>Rincian Keluhan Perbaikan</th>
                                                <th class="text-end">Omzet Masuk</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__empty_1 = true; $__currentLoopData = $riwayatServis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rw): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td><?php echo e($rw->tanggal_masuk); ?></td>
                                                <td class="fw-bold text-dark"><?php echo e($rw->kendaraan->user->name); ?></td>
                                                <td><span class="badge bg-dark"><?php echo e($rw->kendaraan->plat_nomor); ?></span></td>
                                                <td><small class="text-muted"><?php echo e($rw->keluhan); ?></small></td>
                                                <td class="text-end fw-bold text-primary">Rp <?php echo e(number_format($rw->total_biaya, 0, ',', '.')); ?></td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">Belum ada riwayat pendapatan servis yang tercatat.</td>
                                            </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ======================= MODAL SUB-LOGIC INJECTIONS ======================= -->
<?php $__currentLoopData = $spareparts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="editSp<?php echo e($sp->id); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header bg-dark text-white"><h5 class="modal-title fw-bold">Edit Sparepart</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
        <form action="<?php echo e(route('super.sparepart.update', $sp->id)); ?>" method="POST"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div class="modal-body">
                <div class="mb-3"><label class="form-label">Nama</label><input type="text" name="nama_sparepart" value="<?php echo e($sp->nama_sparepart); ?>" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Harga</label><input type="number" name="harga" value="<?php echo e($sp->harga); ?>" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Stok</label><input type="number" name="stok" value="<?php echo e($sp->stok); ?>" class="form-control" required></div>
            </div>
            <div class="modal-footer"><button type="submit" class="btn btn-primary fw-bold">Simpan</button></div>
        </form>
    </div></div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__currentLoopData = $jasas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $js): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="editJs<?php echo e($js->id); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header bg-dark text-white"><h5 class="modal-title fw-bold">Edit Detail Jasa</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
        <form action="<?php echo e(route('super.jasa.update', $js->id)); ?>" method="POST"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div class="modal-body">
                <div class="mb-3"><label class="form-label">Nama Jasa</label><input type="text" name="nama_jasa" value="<?php echo e($js->nama_jasa); ?>" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Tarif Biaya (Rp)</label><input type="number" name="harga" value="<?php echo e($js->harga); ?>" class="form-control" required></div>
            </div>
            <div class="modal-footer"><button type="submit" class="btn btn-primary fw-bold">Simpan Perubahan</button></div>
        </form>
    </div></div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__currentLoopData = $daftarServis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $servis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="tindakanModal<?php echo e($servis->id); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header bg-dark text-white"><h5 class="modal-title fw-bold">Input Part/Jasa</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
        <form action="<?php echo e(route('super.servis.detail', $servis->id)); ?>" method="POST"><?php echo csrf_field(); ?>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Gunakan Sparepart</label>
                    <select name="sparepart_id" class="form-select mb-2">
                        <option value="">-- Pilih --</option>
                        <?php $__currentLoopData = $spareparts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($sp->id); ?>"><?php echo e($sp->nama_sparepart); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <input type="number" name="jumlah_sparepart" value="1" class="form-control form-control-sm">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Tambah Jasa</label>
                    <select name="jasa_id" class="form-select">
                        <option value="">-- Pilih --</option>
                        <?php $__currentLoopData = $jasas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $js): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($js->id); ?>"><?php echo e($js->nama_jasa); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer"><button type="submit" class="btn btn-primary fw-bold">Tambahkan</button></div>
        </form>
    </div></div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__currentLoopData = $transaksi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="notaModalSuper<?php echo e($tr->id); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header bg-dark text-white"><h5 class="modal-title">Struk Pembayaran</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
        <div class="modal-body text-center">
            <h4>BENGKEL MAJU MOTOR</h4><hr>
            <p class="text-start mb-1"><strong>Pelanggan:</strong> <?php echo e($tr->kendaraan->user->name); ?></p>
            <p class="text-start mb-3"><strong>Plat Nomor:</strong> <?php echo e($tr->kendaraan->plat_nomor); ?></p>
            <table class="table table-sm table-bordered">
                <thead><tr><th>Item</th><th>Qty</th><th>Subtotal</th></tr></thead>
                <tbody>
                    <?php $__currentLoopData = $tr->detailServis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr><td><?php echo e($d->sparepart?->nama_sparepart ?? $d->jasa?->nama_jasa ?? 'Item Tidak Diketahui'); ?></td><td><?php echo e($d->jumlah); ?></td><td>Rp <?php echo e(number_format($d->subtotal, 0, ',', '.')); ?></td></tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr class="fw-bold"><td colspan="2">Total:</td><td class="text-primary">Rp <?php echo e(number_format($tr->total_biaya, 0, ',', '.')); ?></td></tr>
                </tbody>
            </table>
        </div>
    </div></div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<!-- JAVASCRIPT INJECTOR: Memaksa Navbar Atas Berubah Menjadi Hitam Pekat (bg-dark) -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var navbar = document.querySelector('.navbar');
        if (navbar) {
            navbar.classList.remove('bg-primary');
            navbar.classList.remove('navbar-dark');
            navbar.classList.add('bg-dark');
            navbar.classList.add('navbar-dark');
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\bengkel-maju-motor\resources\views/admin/super_dashboard.blade.php ENDPATH**/ ?>