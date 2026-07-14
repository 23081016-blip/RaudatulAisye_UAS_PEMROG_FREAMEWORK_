<?php

namespace App\Http\Controllers;

use App\Models\Servis;
use App\Models\Sparepart;
use App\Models\Jasa;
use App\Models\DetailServis;
use Illuminate\Http\Request;

class MekanikController extends Controller
{
    // Tampilkan daftar antrean (opsional jika rute terpisah masih diakses)
    public function dashboard()
    {
        $daftarServis = Servis::with(['kendaraan.user', 'mekanik'])
            ->whereIn('status', ['antrean', 'dikerjakan'])
            ->get();
            
        $spareparts = Sparepart::where('stok', '>', 0)->get();
        $jasas = Jasa::all();

        return view('mekanik.dashboard', compact('daftarServis', 'spareparts', 'jasas'));
    }

    // Mengubah status servis (Mulai Mengerjakan / Selesai)
    public function updateStatus($id, $status)
    {
        $servis = Servis::findOrFail($id);
        
        // Jika mulai dikerjakan, catat siapa mekanik yang memegang
        if ($status == 'dikerjakan') {
            $servis->update([
                'status' => $status,
                'mekanik_id' => auth()->id()
            ]);
        } else {
            $servis->update(['status' => $status]);
        }

        // DI-UPDATE: Diarahkan kembali ke Super Dashboard gabungan
        return redirect()->route('dashboard')->with('success', 'Status servis berhasil diperbarui!');
    }

    // Menambahkan sparepart atau jasa ke dalam detail servis kendaraan
    public function tambahDetail(Request $request, $id)
    {
        $servis = Servis::findOrFail($id);
        $subtotal = 0;

        if ($request->filled('sparepart_id')) {
            $sparepart = Sparepart::findOrFail($request->sparepart_id);
            $jumlah = $request->input('jumlah_sparepart', 1);
            
            if ($sparepart->stok < $jumlah) {
                return redirect()->back()->with('error', 'Stok sparepart tidak mencukupi!');
            }

            $subtotal = $sparepart->harga * $jumlah;
            
            DetailServis::create([
                'servis_id' => $id,
                'sparepart_id' => $request->sparepart_id,
                'jumlah' => $jumlah,
                'subtotal' => $subtotal
            ]);

            // Potong stok sparepart
            $sparepart->decrement('stok', $jumlah);
        }

        if ($request->filled('jasa_id')) {
            $jasa = Jasa::findOrFail($request->jasa_id);
            $subtotal = $jasa->harga;

            DetailServis::create([
                'servis_id' => $id,
                'jasa_id' => $request->jasa_id,
                'jumlah' => 1,
                'subtotal' => $subtotal
            ]);
        }

        // Update total biaya di tabel induk servis
        $servis->increment('total_biaya', $subtotal);

        // DI-UPDATE: Diarahkan kembali ke Super Dashboard gabungan
        return redirect()->route('dashboard')->with('success', 'Item servis berhasil ditambahkan!');
    }
}