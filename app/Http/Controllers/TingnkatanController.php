<?php

namespace App\Http\Controllers;

use App\Models\Tingkatan;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class TingnkatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

       $tingkatan = Tingkatan::all();
        $lastCabang = Tingkatan::orderBy('id', 'desc')->first();
        $lastKode = $lastCabang ? intval(substr($lastCabang->nomor_tingkatan, 3)) : 0;
        $newKode = 'TNG' . str_pad($lastKode + 1, 3, '0', STR_PAD_LEFT);
        return view('pages.admin.data_ketingkatan',compact('tingkatan','newKode'));
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
        $lastCabang = Tingkatan::orderBy('id', 'desc')->first();
        $lastKode = $lastCabang ? intval(substr($lastCabang->nomor_tingkatan, 3)) : 0;
        $newKode = 'TNG' . str_pad($lastKode + 1, 3, '0', STR_PAD_LEFT);

        Tingkatan::create([
            'id' => $request->id,
            'nomor_tingkatan' => $request->nik,
            'kategori' => $request->kategori,
            'nama_tingkatan' => $request->nama_ketingkatan,
        ]);
        Alert::success('Success','Data Tingkatan Berhasil Di simpan');
        return redirect()->back()->with('success','Data Tingkatan Berhasil Dibuat');
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
    public function update(Request $request, string $nomor_tingkatan)
    {
        $data = Tingkatan::where('nomor_tingkatan',$nomor_tingkatan)->firstOrFail();

        $data -> nama_tingkatan = $request->input('nama_ketingkatan');
        $data -> kategori = $request->input('kategori');

        $data->update();
        Alert::success('Success', 'Data Tingkatan berhasil di perbarui');
        return redirect()->back()->with('success','Data Tingkatan Berhasil Di perbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $nomor_tingkatan)
    {
        $data = Tingkatan::where('nomor_tingkatan',$nomor_tingkatan)->firstOrFail();

        $data->delete();
        Alert::success('Success', 'Data Tingkatan berhasil di hapus');
        return redirect()->back()->with('success','Data Tingkatan Berhasil Di hapus');

    }
}
