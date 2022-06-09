<?php

namespace App\Http\Controllers;

use \Carbon\Carbon;

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

        if (auth()->user()->role == "admin")
            $pembayarans = DB::table("pembayarans")->get();
        else
            $pembayarans = DB::table("pembayarans")->get()->where('id_peserta', '==', $id_peserta);
        // $pembayarans1 = Pembayaran::with('kelompok_arisan', 'peserta')->where('id', $pembayarans)->get();
        $kelompok_arisan = KelompokArisan::where('id', '==', $id_kelompok)->get();
        $peserta = Peserta::where('id', '==', $id_peserta)->get();

        $id_peserta1 = DB::table('pesertas')->where('email', auth()->user()->email)->value('id');

        $tgl_setor = now();

        // $peserta1 = Peserta::all();
        // $kelompok_arisan1 = KelompokArisan::all();
        $detail_kelompok_arisan = DetailKelompokArisan::all();

        $addPembayarans = Pembayaran::with('peserta', 'kelompok_arisan', 'detail_kelompok_arisan')->where('id_peserta', $id_peserta1)->get();

        if (auth()->user()->role == "admin")
            $view = view('pages.pembayaran.admin_pembayaran', compact('pembayarans',  'kelompok_arisan', 'peserta', 'detail_kelompok_arisan'))
                ->with('i', (request()->input('page', 1) - 1) * 5);
        else
            $view = view('pages.pembayaran.user_pembayaran', compact('addPembayarans',  'kelompok_arisan', 'peserta', 'detail_kelompok_arisan'))
                ->with('i', (request()->input('page', 1) - 1) * 5);
        return $view;
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

        $id_peserta = DB::table('pesertas')->where('email', auth()->user()->email)->first();

        $id_kelompok = DetailKelompokArisan::where('id_peserta', $pesertas)->value('id');
        $id_kelompok1 = DB::table('detail_kelompok_arisans')->where('id_kelompok', $id_kelompok)->first();

        $tampilan = DetailKelompokArisan::with('kelompok_arisan', 'peserta')->where('id_peserta', $pesertas)->first();

        $pembayarans = Pembayaran::with('kelompok_arisan', 'peserta', 'detail_kelompok_arisan')->where('id_peserta', $pesertas)->get();


        $countPeserta = DB::table("pembayarans")->groupBy('id_peserta')->where('id_peserta', $pesertas)->count();

        $peserta = Peserta::all();
        $kelompok_arisan = KelompokArisan::all();
        $detail_kelompok_arisan = DetailKelompokArisan::all();


        return view('pages.pembayaran.user_pembayaran', compact('pesertas', 'pembayarans', 'countPeserta', 'id_peserta', 'tampilan', 'peserta'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function tambahPembayaran(Request $request)
    {

        $pesertas = Peserta::where('email', auth()->user()->email)->value('id');
        $id_detail = DetailKelompokArisan::where('id_peserta', $pesertas)->value('id');

        $tambah = Pembayaran::create([
            'id_kelompok' => $request->id_kelompok,
            'id_detail_kelompok' => $id_detail,
            'id_peserta' => $request->id_peserta,
            'tgl_setor' => date('Y-m-d'),
            'stts' => 0
        ]);

        if ($tambah) {
            // return view('pages.pembayaran.admin_pembayaran');
            return back()->withStatus('Berhasil Melakukan Pembayaran!');
        }
        // echo $id_kelompok;
    }

    public function kocok()
    {
        // $count_saldo = DB::table('setorans')->sum('jml_setoran');
        $setorans = DB::table('pembayarans')->select('id_peserta')->where('stts', '==', 1)->inRandomOrder()->limit(1)->get();

        $upStatus =  DB::table('pembayarans')->select('id_peserta')->get();
        $upStts = Peserta::where('id', $upStatus)
            ->update([
                'sttsPeserta' => 1
            ]);

        $nmPeserta = DB::table('pesertas')->select('nm_peserta')->where('id', '==', $setorans);
        if ($upStts) {
            return view('pages.hasil_kocok');
            // return view('pages.pembayaran.admin_pembayaran', compact('pembayarans',  'kelompok_arisan', 'peserta', 'detail_kelompok_arisan'))
            //     ->with('i', (request()->input('page', 1) - 1) * 5);
            // return back()->withStatus('Berhasil Melakukan Pembayaran!');
        }
    }
}