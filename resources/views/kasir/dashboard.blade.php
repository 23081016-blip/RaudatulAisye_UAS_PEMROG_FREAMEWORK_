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

    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white fw-bold">
                <h5 class="mb-0">Kasir - Panel Pembayaran Servis</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Berikut adalah daftar kendaraan yang telah selesai diservis oleh mekanik dan siap untuk dilakukan pembayaran.</p>
                
                <div class="table-responsive mt-3">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Pelanggan</th>
                                <th>Kendaraan</th>
                                <th>Plat Nomor</th>
                                <th>Total Biaya</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksi as $index => $tr)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="fw-bold">{{ $tr->kendaraan->user->name }}</td>
                                <td>{{ $tr->kendaraan->merk }} - {{ $tr->kendaraan->tipe }}</td>
                                <td><span class="badge bg-dark">{{ $tr->kendaraan->plat_nomor }}</span></td>
                                <td class="fw-bold text-success">Rp {{ number_format($tr->total_biaya, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <!-- Button Trigger Rincian / Nota -->
                                    <button class="btn btn-info btn-sm text-white fw-bold me-1" data-bs-toggle="modal" data-bs-target="#notaModal{{ $tr->id }}">Lihat Rincian / Struk</button>
                                    
                                    <!-- Form Bayar -->
                                    <form action="{{ route('kasir.servis.bayar', $tr->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn bg-success btn-sm text-white fw-bold" onclick="return confirm('Proses pembayaran untuk transaksi ini?')">Bayar Lunas</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Struk / Nota Rincian -->
                            <div class="modal fade" id="notaModal{{ $tr->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-dark text-white">
                                            <h5 class="modal-title fw-bold">Struk Rincian Biaya Servis</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-center mb-3">
                                                <h4 class="fw-bold mb-0">BENGKEL MAJU MOTOR</h4>
                                                <small class="text-muted">Nota Rincian Perbaikan Kendaraan</small>
                                            </div>
                                            <hr>
                                            <p class="mb-1"><strong>Nama Pelanggan:</strong> {{ $tr->kendaraan->user->name }}</p>
                                            <p class="mb-1"><strong>Kendaraan:</strong> {{ $tr->kendaraan->merk }} {{ $tr->kendaraan->tipe }} ({{ $tr->kendaraan->plat_nomor }})</p>
                                            <p class="mb-3"><strong>Tanggal Masuk:</strong> {{ $tr->tanggal_masuk }}</p>
                                            
                                            <table class="table table-sm table-bordered">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Item Tindakan / Sparepart</th>
                                                        <th class="text-center">Qty</th>
                                                        <th class="text-end">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($tr->detailServis as $detail)
                                                    <tr>
                                                        <td>{{ $detail->sparepart->nama_sparepart ?? $detail->jasa->nama_jasa }}</td>
                                                        <td class="text-center">{{ $detail->jumlah }}</td>
                                                        <td class="text-end">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                                    </tr>
                                                    @endforeach
                                                    <tr class="table-secondary fw-bold">
                                                        <td colspan="2" class="text-end">Total Akhir:</td>
                                                        <td class="text-end text-success">Rp {{ number_format($tr->total_biaya, 0, ',', '.') }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                                            <button type="button" class="btn btn-primary btn-sm fw-bold" onclick="window.print()">Cetak Nota</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Belum ada kendaraan dengan status 'Selesai' servis yang mengantre di kasir.</td>
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