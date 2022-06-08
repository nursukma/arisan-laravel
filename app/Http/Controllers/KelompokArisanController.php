<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\KelompokArisan;
use App\Models\Arisan;

class KelompokArisanController extends Controller
{
    public function index()
    {
        $arisans = Arisan::all();

        $kelompok_arisans = DB::table('kelompok_arisans')->paginate(5);
        return view('pages.kelompok_arisan.kelompok_arisan', compact('kelompok_arisans', 'arisans'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function showById(Request $request)

    {
        $id = $request->id_arisan;
        $arisans = Arisan::where('id', $id)->with('arisan')->get();

        return response()->json([
            'arisan' => $arisans
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelompok' => 'required',
            'id_arisan' => 'required',
            'keterangan' => 'required',
            'harga' => 'required',
            'status' => 'required'
        ]);

        $save = KelompokArisan::create([
            'nama_kelompok' => $request->nama_kelompok,
            'id_arisan' => $request->id_arisan,
            'keterangan' => $request->keterangan,
            'harga' => $request->harga,
            'status' => $request->status
        ]);
        if ($save) {
            return back()->withStatus('Data Sukses Disimpan');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelompok' => 'required',
            'id_arisan' => 'required',
            'keterangan' => 'required',
            'harga' => 'required',
            'status' => 'required'
        ]);

        $arisan_fetch = KelompokArisan::find($id);

        $arisan_fetch->update([
            'nama_kelompok' => $request->nama_kelompok,
            'id_arisan' => $request->id_arisan,
            'keterangan' => $request->keterangan,
            'harga' => $request->harga,
            'status' => $request->status
        ]);
        if ($arisan_fetch) {
            return back()->withStatus(__('Sukses Ubah Data!'));
        }
    }

    public function destroy($id)
    {
        $arisan_fetch = KelompokArisan::find($id);
        $arisan_fetch->delete();

        if ($arisan_fetch)
            return back()->withStatus(__('Sukses Hapus Data!'));
    }
}