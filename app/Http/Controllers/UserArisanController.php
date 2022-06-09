<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\KelompokArisan;
use App\Models\DetailKelompokArisan;
use App\Models\Arisan;
use App\Models\Peserta;

class UserArisanController extends Controller
{
    public function index()
    {
        $arisans = Arisan::all();
        $kelompok_arisan = KelompokArisan::with("arisan")->get();
        $pesertas = Peserta::where('email', auth()->user()->email)->value('id');

        return view('pages.user.user_arisan', compact('kelompok_arisan', 'arisans', 'pesertas'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function gabungKelompok($id)
    {
        $upStatus = KelompokArisan::where('id', $id)
            ->update([
                'stts' => 1
            ]);
        if ($upStatus) {
            // return view('pages.pembayaran.admin_pembayaran');
            return back()->withStatus('Berhasil Validasi Pembayaran!');
        }
    }

    public function gabung(Request $request, $id)
    {
        // $request->validate([
        //     'id_peserta' => 'required'
        // ]);
        $ket = "-";
        $stts = 1;

        $idPeserta = $request->id_peserta;
        // $id = $request->id_fix;

        // $id1 = $request->id_fix1;

        $save = DetailKelompokArisan::create([
            'id_peserta' => $idPeserta,
            'id_kelompok' => $id,
            'ket_arisan' => $ket,
            'peringatan' => 0,
        ]);

        //buat maks daftar 2
        $sttsPeserta = DB::table("pesertas")->where('id', $idPeserta)->value('stts');
        if ($sttsPeserta == 0) {
            $upPeserta = Peserta::where('id', $idPeserta)
                ->update([
                    'stts' => $stts,
                ]);
        } else if ($sttsPeserta == 1) {
            $upPeserta = Peserta::where('id', $idPeserta)
                ->update([
                    'stts' => 2,
                ]);
        }

        //Perhitungan
        $ttlSlot = DB::table("kelompok_arisans")->where('id', $id)->value('slot');
        $sttsSlot = DB::table("kelompok_arisans")->where('id', $id)->value('status');
        $countPeserta = DB::table("detail_kelompok_arisans")->groupBy('id_kelompok')->count();

        $fixTotal = ($ttlSlot - $countPeserta);

        if ($save) {
            if ($upPeserta) {
                if ($sttsSlot != "Full") {
                    $upStatus = KelompokArisan::where('id', $id)
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

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'nama_arisan' => 'required',
    //         'keterangan' => 'required',
    //         'slot' => 'required',
    //         'harga' => 'required'
    //     ]);

    //     if ($request->slot <= 0 || $request->harga <= 0) {
    //         return back()->withStatus(_('Data Tidak Valid'));
    //     } else {
    //         $save = Arisan::create([
    //             'nama_arisan' => $request->nama_arisan,
    //             'keterangan' => $request->keterangan,
    //             'slot' => $request->slot,
    //             'harga' => $request->harga
    //         ]);
    //         if ($save) {
    //             return back()->withStatus('Data Sukses Disimpan');
    //         }
    //     }
    // }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'nama_arisan' => 'required',
    //         'keterangan' => 'required',
    //         'slot' => 'required',
    //         'harga' => 'required'
    //     ]);

    //     $arisan_fetch = Arisan::find($id);

    //     if ($request->slot <= 0 || $request->harga <= 0) {
    //         return back()->withStatus(_('Data Tidak Valid'));
    //     } else {
    //         $arisan_fetch->update([
    //             'nama_arisan' => $request->nama_arisan,
    //             'keterangan' => $request->keterangan,
    //             'slot' => $request->slot,
    //             'harga' => $request->harga
    //         ]);
    //         if ($arisan_fetch) {
    //             return back()->withStatus(__('Sukses Ubah Data!'));
    //         }
    //     }
    // }

    // public function destroy($id)
    // {
    //     $arisan_fetch = Arisan::find($id);
    //     $arisan_fetch->delete();

    //     if ($arisan_fetch)
    //         return back()->withStatus(__('Sukses Hapus Data!'));
    // }
}