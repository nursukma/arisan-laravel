<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\KelompokArisan;

use App\Models\Arisan;
use App\Models\DetailKelompokArisan;
use App\Models\Peserta;
use App\Models\Pembayaran;

class PembayaranController extends Controller
{
    public function index()
    {
        $id_kelompok = DB::table("pembayarans")->value('id_kelompok');
        $id_peserta = DB::table('pembayarans')->value('id_peserta');

        $pembayarans = DB::table("pembayarans")->get();
        // $pembayarans1 = Pembayaran::with('kelompok_arisan', 'peserta')->where('id', $pembayarans)->get();
        $kelompok_arisan = KelompokArisan::where('id', '==', $id_kelompok)->get();
        $peserta = Peserta::where('id', '==', $id_peserta)->get();

        return view('pages.pembayaran.admin_pembayaran', compact('pembayarans',  'kelompok_arisan', 'peserta'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function upValidasi($id)
    {
        $upStatus = Pembayaran::where('id_detail_kelompok', $id)
            ->update([
                'stts' => 1
            ]);
        if ($upStatus) {
            // return view('pages.pembayaran.admin_pembayaran');
            return back()->withStatus('Berhasil Validasi Pembayaran!');
        }
    }

    public function show($id)
    {
        $pesertas = Peserta::all();
        $kelompok_arisan = KelompokArisan::where('id', $id);

        $pembayarans = Pembayaran::with('kelompok_arisan', 'peserta')->where('id_kelompok', $id)->get();
        return view('pages.pembayaran.admin_pembayaran', compact('pembayarans',  'kelompok_arisan', 'pesertas'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function showHistory($id)
    {
        // $pesertas = Pembayaran::where('id_peserta', '==', $id)->get();

        $pesertas = Peserta::where('email', auth()->user()->email)->value('id');
        $pembayarans = Pembayaran::with('kelompok_arisan', 'peserta')->where('id_kelompok', $id)->get();


        return view('pages.pembayaran.user_pembayaran', compact('pesertas', 'pembayarans'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
}