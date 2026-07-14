<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use App\Models\Jasa;
use App\Models\Servis;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Tampilkan Super Dashboard Gabungan (Admin, Mekanik, Kasir, Laporan)
    public function superDashboard()
    {
        // Mengambil semua data katalog sparepart
        $spareparts = Sparepart::all();

        // Mengambil semua data katalog jasa
        $jasas = Jasa::all();
        
        // Mengambil data antrean mekanik (antrean & dikerjakan)
        $daftarServis = Servis::with(['kendaraan.user', 'mekanik'])
            ->whereIn('status', ['antrean', 'dikerjakan'])
            ->get();
        
        // Mengambil data untuk kasir (servis selesai siap bayar)
        $transaksi = Servis::with(['kendaraan.user', 'detailServis.sparepart', 'detailServis.jasa'])
            ->where('status', 'selesai')
            ->get();

        // [FITUR BARU] Mengambil data riwayat yang sudah selesai/lunas untuk laporan
        $riwayatServis = Servis::with(['kendaraan.user', 'detailServis.sparepart', 'detailServis.jasa'])
            ->where('status', 'selesai') // sesuaikan kondisi dummy aplikasi saat ini
            ->get();

        // Hitung total pendapatan bengkel
        $totalPendapatan = $riwayatServis->sum('total_biaya');

        return view('admin.super_dashboard', compact('spareparts', 'jasas', 'daftarServis', 'transaksi', 'riwayatServis', 'totalPendapatan'));
    }

    // ==========================================
    // LOGIK CRUD SPAREPART
    // ==========================================
    public function storeSparepart(Request $request)
    {
        $request->validate([
            'nama_sparepart' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|numeric|min:0',
        ]);

        Sparepart::create($request->all());
        return redirect()->route('dashboard')->with('success', 'Sparepart berhasil ditambahkan!');
    }

    public function updateSparepart(Request $request, $id)
    {
        $request->validate([
            'nama_sparepart' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|numeric|min:0',
        ]);

        $sparepart = Sparepart::findOrFail($id);
        $sparepart->update($request->all());
        return redirect()->route('dashboard')->with('success', 'Sparepart berhasil diperbarui!');
    }

    public function destroySparepart($id)
    {
        $sparepart = Sparepart::findOrFail($id);
        $sparepart->delete();
        return redirect()->route('dashboard')->with('success', 'Sparepart berhasil dihapus!');
    }

    // ==========================================
    // LOGIK CRUD JASA
    // ==========================================
    public function storeJasa(Request $request)
    {
        $request->validate([
            'nama_jasa' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        Jasa::create($request->all());
        return redirect()->route('dashboard')->with('success', 'Data Jasa perbaikan berhasil ditambahkan!');
    }

    public function updateJasa(Request $request, $id)
    {
        $request->validate([
            'nama_jasa' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        $jasa = Jasa::findOrFail($id);
        $jasa->update($request->all());
        return redirect()->route('dashboard')->with('success', 'Data Jasa perbaikan berhasil diperbarui!');
    }

    public function destroyJasa($id)
    {
        $jasa = Jasa::findOrFail($id);
        $jasa->delete();
        return redirect()->route('dashboard')->with('success', 'Data Jasa perbaikan berhasil dihapus!');
    }
}