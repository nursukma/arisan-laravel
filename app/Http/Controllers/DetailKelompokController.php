<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\KelompokArisan;

use App\Models\Arisan;
use App\Models\DetailKelompokArisan;
use App\Models\Pembayaran;
use App\Models\Peserta;

class DetailKelompokController extends Controller
{
    public function showPembayaran($id)
    {
        $pesertas = Peserta::all();
        $kelompok_arisan = KelompokArisan::where('id', $id);

        $pembayarans = Pembayaran::with('kelompok_arisan', 'peserta')->where('id_kelompok', $id)->get();
        return view('pages.pembayaran.admin_pembayaran', compact('pembayarans',  'kelompok_arisan', 'pesertas'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    public function show($id)
    {
        //TODO : Implementasikan Proses Tampilkan Data Satu Mahasiswa Berdasarkan ID
        $a = 1;
        $b = 0;

        // $idPeserta = DB::table("detail_kelompok_arisans")->value('id_peserta');

        // $pesertas = Peserta::where('stts', '==', 0)->orWhere('stts', '==', 1)->get();
        $pesertas = Peserta::where(function ($query) use ($a, $b) {
            return $query->where('stts', '=', $a)
                ->orWhere('stts', '=', $b);
        })->get();

        $kelompok_arisan = KelompokArisan::where('id', $id)->get();

        // $detail = DB::table('detail_kelompok_arisans')->where('id_kelompok', $id)->first();

        $detail_kelompok_arisans = DetailKelompokArisan::with('kelompok_arisan', 'peserta')->where('id_kelompok', $id)->get();

        return view('pages.kelompok_arisan.detail_kelompok', compact('detail_kelompok_arisans', 'pesertas', 'kelompok_arisan'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function showPesertaId(Request $request)

    {
        $id = $request->id;
        $peserta = Peserta::find($id);

        return response()->json([
            'peserta' => $peserta
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_peserta' => 'required',
            // 'id_kelompok' => 'required',
        ]);
        $ket = "-";
        $stts = 1;
        $id = $request->id_fix;
        $id1 = $request->id_fix1;

        $save = DetailKelompokArisan::create([
            'id_peserta' => $id,
            'id_kelompok' => $id1,
            'ket_arisan' => $ket,
            'peringatan' => 0,
        ]);

        //buat maks daftar 2
        $sttsPeserta = DB::table("pesertas")->where('id', $id)->value('stts');
        if ($sttsPeserta == 0) {
            $upPeserta = Peserta::where('id', $id)
                ->update([
                    'stts' => $stts,
                ]);
        } else if ($sttsPeserta == 1) {
            $upPeserta = Peserta::where('id', $id)
                ->update([
                    'stts' => 2,
                ]);
        }

        //Perhitungan
        $ttlSlot = DB::table("kelompok_arisans")->where('id', $id1)->value('slot');
        $sttsSlot = DB::table("kelompok_arisans")->where('id', $id1)->value('status');
        $countPeserta = DB::table("detail_kelompok_arisans")->groupBy('id_kelompok')->count();

        $fixTotal = ($ttlSlot - $countPeserta);

        if ($save) {
            if ($upPeserta) {
                if ($sttsSlot != "Full") {
                    $upStatus = KelompokArisan::where('id', $id1)
                        ->update([
                            'status' => "Tersisa " . $fixTotal . " Slot"
                        ]);
                }
                if ($upStatus) {
                    return back()->withStatus('Data Sukses Disimpan');
                    // echo $fixTotal;
                }
            }
        } else {
            return back()->withStatus('Data Gagal');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_peserta' => 'required',
            // 'id_kelompok' => 'required',
        ]);

        $arisan_fetch = DetailKelompokArisan::find($id);

        $arisan_fetch->update([
            'id_kelompok' => $request->id_fix1,
            'id_arisan' => $request->id_fix,
            'ket_arisan' => $request->ket_arisan,
            'peringatan' => $request->peringatan,
        ]);
        if ($arisan_fetch) {
            return back()->withStatus(__('Sukses Ubah Data!'));
        }
    }

    public function destroy($id)
    {
        $arisan_fetch = DetailKelompokArisan::find($id);
        $arisan_fetch->delete();

        if ($arisan_fetch)
            return back()->withStatus(__('Sukses Hapus Data!'));
    }
}