<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Arisan;

class ArisanController extends Controller
{
    public function index()
    {
        $arisans = DB::table('arisans')->paginate(5);
        return view('pages.arisan', compact('arisans'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_arisan' => 'required',
            'keterangan' => 'required',
            'slot' => 'required',
            'harga' => 'required'
        ]);

        if ($request->slot <= 0 || $request->harga <= 0) {
            return back()->withStatus(_('Data Tidak Valid'));
        } else {
            $save = Arisan::create([
                'nama_arisan' => $request->nama_arisan,
                'keterangan' => $request->keterangan,
                'slot' => $request->slot,
                'harga' => $request->harga
            ]);
            if ($save) {
                return back()->withStatus('Data Sukses Disimpan');
            }
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_arisan' => 'required',
            'keterangan' => 'required',
            'slot' => 'required',
            'harga' => 'required'
        ]);

        $arisan_fetch = Arisan::find($id);

        if ($request->slot <= 0 || $request->harga <= 0) {
            return back()->withStatus(_('Data Tidak Valid'));
        } else {
            $arisan_fetch->update([
                'nama_arisan' => $request->nama_arisan,
                'keterangan' => $request->keterangan,
                'slot' => $request->slot,
                'harga' => $request->harga
            ]);
            if ($arisan_fetch) {
                return back()->withStatus(__('Sukses Ubah Data!'));
            }
        }
    }

    public function destroy($id)
    {
        $arisan_fetch = Arisan::find($id);
        $arisan_fetch->delete();

        if ($arisan_fetch)
            return back()->withStatus(__('Sukses Hapus Data!'));
    }
}