<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PrestasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prestasi = Prestasi::where('pelatih',Auth::user()->username)->get();
        return view('pages.pelatih.prestasi', compact('prestasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $prestasi = new Prestasi();
        $prestasi -> nama_event = $request->input('nama');
        $prestasi -> skala_event = $request->input('skala');
        $prestasi -> tanggal_event = $request->input('tanggal');
        $prestasi -> prestasi_yang_diraih = $request->input('prestasi');
        $prestasi -> pelatih = Auth::user()->username;

        $prestasi->save();

        Alert::success('berhasil','berhasil menambahkan data prestasi');
        return redirect()->back()->with('success','berhasil menambahkan data prestasi');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $prestasi = Prestasi::where('id',$id)->firstOrFail();
        $prestasi->nama_event = $request->input('nama');
        $prestasi->skala_event = $request->input('skala');
        $prestasi->tanggal_event = $request->input('tanggal');
        $prestasi->prestasi_yang_diraih = $request->input('prestasi');

        $prestasi->update();
        Alert::success('Berhasil','Berhasil update data prestasi');
        return redirect()->back()->with('success','Berhasil update data prestasi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prestasi = Prestasi::where('id',$id)->firstOrFail();
        $prestasi->delete();
        Alert::success('Berhasil','Data prestasi berhasil dihapus');
        return redirect()->back()->with('success','Data prestasi berhasil dihapus');
    }
}
