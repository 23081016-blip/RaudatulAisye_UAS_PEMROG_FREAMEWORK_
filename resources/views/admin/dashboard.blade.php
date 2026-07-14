@extends('layouts.master')

@section('content')
<div class="row">
    <!-- Alert Success -->
    @if(session('success'))
    <div class="col-12 mb-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif

    <!-- Dashboard Header Info Cards -->
    <div class="col-12 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white text-dark fw-bold">
                <h5 class="mb-0 text-primary">Dashboard Panel Admin</h5>
            </div>
            <div class="card-body">
                <p>Selamat datang di panel Admin. Di sini kamu bisa mengelola data master (Sparepart, Jasa, dan Pengguna).</p>
                <div class="row g-3 mt-2">
                    <div class="col-md-4">
                        <div class="card bg-info text-white border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-1 text-white-50">Total Jenis Sparepart</h6>
                                <h3 class="card-title mb-0 fw-bold">{{ $spareparts->count() }} Item</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-1 text-white-50">Total Jenis Jasa</h6>
                                <h3 class="card-title mb-0 fw-bold">0 Item</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Tambah Sparepart (Sisi Kiri) -->
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0 fw-bold">Tambah Sparepart Baru</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.sparepart.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Sparepart</label>
                        <input type="text" name="nama_sparepart" class="form-control" placeholder="Contoh: Oli Top 1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" min="0" placeholder="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stok Awal</label>
                        <input type="number" name="stok" class="form-control" min="0" placeholder="0" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Simpan Sparepart</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel Data Sparepart (Sisi Kanan) -->
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0 text-dark fw-bold">Katalog Manajemen Sparepart</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">#</th>
                                <th>Nama Sparepart</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th class="text-center" width="25%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($spareparts as $index => $sp)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="fw-bold text-secondary">{{ $sp->nama_sparepart }}</td>
                                <td>Rp {{ number_format($sp->harga, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge {{ $sp->stok > 5 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $sp->stok }} Pcs
                                    </span>
                                </td>
                                <td class="text-center">
                                    <!-- Tombol Edit -->
                                    <button class="btn btn-warning btn-sm text-white fw-bold me-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $sp->id }}">Edit</button>
                                    
                                    <!-- Form Hapus -->
                                    <form action="{{ route('admin.sparepart.destroy', $sp->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm fw-bold" onclick="return confirm('Apakah Anda yakin ingin menghapus sparepart ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Edit Data -->
                            <div class="modal fade" id="editModal{{ $sp->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning text-white">
                                            <h5 class="modal-title fw-bold">Edit Sparepart</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin.sparepart.update', $sp->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Sparepart</label>
                                                    <input type="text" name="nama_sparepart" value="{{ $sp->nama_sparepart }}" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Harga (Rp)</label>
                                                    <input type="number" name="harga" value="{{ $sp->harga }}" class="form-control" min="0" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Stok</label>
                                                    <input type="number" name="stok" value="{{ $sp->stok }}" class="form-control" min="0" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-warning text-white fw-bold">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Belum ada data sparepart. Silakan tambah data di form sebelah kiri.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection