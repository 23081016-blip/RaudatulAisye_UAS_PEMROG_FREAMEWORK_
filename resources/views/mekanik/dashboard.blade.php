@extends('layouts.master')

@section('content')
<div class="row">
    <!-- Alert Feedback -->
    @if(session('success'))
    <div class="col-12 mb-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif
    @if(session('error'))
    <div class="col-12 mb-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif

    <div class="col-12">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white fw-bold">
                <h5 class="mb-0">Daftar Kerja Mekanik</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Berikut adalah daftar kendaraan masuk yang perlu diperiksa atau sedang Anda kerjakan.</p>
                
                <div class="table-responsive mt-3">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-secondary">
                            <tr>
                                <th>Pelanggan / Tipe</th>
                                <th>Plat Nomor</th>
                                <th>Keluhan Awal</th>
                                <th>Status</th>
                                <th>Total Biaya Sementara</th>
                                <th class="text-center">Aksi Kerja</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($daftarServis as $servis)
                            <tr>
                                <td>
                                    <strong>{{ $servis->kendaraan->user->name }}</strong><br>
                                    <small class="text-muted">{{ $servis->kendaraan->merk }} - {{ $servis->kendaraan->tipe }}</small>
                                </td>
                                <td><span class="badge bg-dark">{{ $servis->kendaraan->plat_nomor }}</span></td>
                                <td>{{ $servis->keluhan }}</td>
                                <td>
                                    <span class="badge {{ $servis->status == 'antrean' ? 'bg-warning text-dark' : 'bg-info text-white' }}">
                                        {{ ucfirst($servis->status) }}
                                    </span>
                                </td>
                                <td>Rp {{ number_format($servis->total_biaya, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    @if($servis->status == 'antrean')
                                        <!-- Ambil Antrean -->
                                        <form action="{{ route('mekanik.servis.status', [$servis->id, 'dikerjakan']) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-primary btn-sm fw-bold">Kerjakan</button>
                                        </form>
                                    @elseif($servis->status == 'dikerjakan')
                                        <!-- Tombol Input Sparepart / Jasa Jurnal -->
                                        <button class="btn btn-warning btn-sm fw-bold text-white me-1" data-bs-toggle="modal" data-bs-target="#inputTindakanModal{{ $servis->id }}">Input Sparepart/Jasa</button>

                                        <!-- Selesaikan Servis -->
                                        <form action="{{ route('mekanik.servis.status', [$servis->id, 'selesai']) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm fw-bold" onclick="return confirm('Yakin pengerjaan servis ini sudah selesai?')">Set Selesai</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>

                            <!-- Modal Input Tindakan Sparepart & Jasa -->
                            <div class="modal fade" id="inputTindakanModal{{ $servis->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning text-white">
                                            <h5 class="modal-title fw-bold">Tindakan Servis: {{ $servis->kendaraan->plat_nomor }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('mekanik.servis.detail', $servis->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <p class="small text-muted mb-3">Pilih sparepart atau jenis jasa yang diberikan kepada kendaraan ini. Anda bisa menginputnya bertahap.</p>
                                                
                                                <!-- Opsi Tambah Sparepart -->
                                                <div class="border rounded p-3 mb-3 bg-light">
                                                    <label class="form-label fw-bold text-secondary">Gunakan Sparepart (Opsional)</label>
                                                    <select name="sparepart_id" class="form-select mb-2">
                                                        <option value="">-- Pilih Sparepart --</option>
                                                        @foreach($spareparts as $sp)
                                                            <option value="{{ $sp->id }}">{{ $sp->name ?? $sp->nama_sparepart }} (Stok: {{ $sp->stok }} | Rp {{ number_format($sp->harga, 0, ',', '.') }})</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="number" name="jumlah_sparepart" class="form-control form-control-sm" min="1" value="1" placeholder="Jumlah Pcs">
                                                </div>

                                                <!-- Opsi Tambah Jasa -->
                                                <div class="border rounded p-3 bg-light">
                                                    <label class="form-label fw-bold text-secondary">Tambah Jasa Perbaikan (Opsional)</label>
                                                    <select name="jasa_id" class="form-select">
                                                        <option value="">-- Pilih Jasa --</option>
                                                        @foreach($jasas as $js)
                                                            <option value="{{ $js->id }}">{{ $js->nama_jasa }} (Rp {{ number_format($js->harga, 0, ',', '.') }})</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-warning text-white fw-bold">Tambahkan Item</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Tidak ada kendaraan dalam antrean servis saat ini.</td>
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