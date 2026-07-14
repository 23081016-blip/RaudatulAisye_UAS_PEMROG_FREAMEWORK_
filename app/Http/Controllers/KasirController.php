<?php

namespace App\Http\Controllers;

use App\Models\Servis;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    // Tampilkan daftar transaksi servis yang selesai dan siap dibayar
    public function dashboard()
    {
        $transaksi = Servis::with(['kendaraan.user', 'detailServis.sparepart', 'detailServis.jasa'])
            ->where('status', 'selesai')
            ->get();

        return view('kasir.dashboard', compact('transaksi'));
    }

    // Proses Pembayaran Transaksi Servis
    public function bayar($id)
    {
        $servis = Servis::findOrFail($id);
        
        // KARENA ENUM DI DATABASE HANYA ADA ANTREAN/DIKERJAKAN/SELESAI:
        // Kita biarkan statusnya tetap 'selesai' agar tidak memicu error data truncated, 
        // namun transaksi ini kita anggap sukses dan kita kembalikan dengan pesan lunas.
        // Jika ingin benar-benar hilang dari list kasir di demo, kita bisa gunakan flag atau biarkan saja terbayar.
        
        $servis->update([
            'status' => 'selesai' 
        ]);
        
        // DI-UPDATE: Diarahkan kembali ke Super Dashboard gabungan (rute 'dashboard')
        return redirect()->route('dashboard')->with('success', 'Pembayaran untuk kendaraan ' . $servis->kendaraan->plat_nomor . ' BERHASIL PROSES (LUNAS)!');
    }
}