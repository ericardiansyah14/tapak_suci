<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Cabang;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CabangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $anggota = Anggota::all();
        $cabang = Cabang::all();
        $lastCabang = Cabang::orderBy('nomor_induk_cabang', 'asc')->first();
        $lastKode = $lastCabang ? intval(substr($lastCabang->nomor_induk_cabang, 3)) : 0;
        $newKode = 'CBG' . str_pad($lastKode + 1, 3, '0', STR_PAD_LEFT);
        return view('pages.admin.anggota', compact('cabang', 'newKode','anggota'));
    }
    public function create(Request $request)
    {
       
    }
    public function store(Request $request)
    {
        $lastCabang = Cabang::orderBy('nomor_induk_cabang', 'desc')->first();
        $lastKode = $lastCabang ? intval(substr($lastCabang->nomor_induk_cabang, 3)) : 0;
        $newKode = 'CBG' . str_pad($lastKode + 1, 3, '0', STR_PAD_LEFT);

        Cabang::create([
            'id' => $request->id,
            'nomor_induk_cabang' => $request->nic,
            'nama_cabang' => $request->nama_cabang,
            'alamat_cabang' => $request->alamat,
            'kelurahan' => $request->kelurahan,
            'kecamatan' => $request->kecamatan,
            'pelatih_cabang' => $request->pelatih,
        ]);

        User::create([
            'name' => $request->pelatih,
            'username' => $request->pelatih,
            'role' => 'pelatih',
            'password' => $request->pelatih,
        ]);
        Alert::success('Success', 'Data Anggota berhasil ditambahkan');
        return redirect()->back()->with('success', 'Data Anggota berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cabang $cabang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cabang $cabang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $nomor_induk_cabang)
    {
        $data = Cabang::where('nomor_induk_cabang',$nomor_induk_cabang)->firstOrFail();

        $data -> nama_cabang = $request->input('nama_cabang');
        $data -> alamat_cabang = $request->input('alamat');
        $data -> kelurahan = $request->input('kelurahan');
        $data -> kecamatan = $request->input('kecamatan');
        $data -> pelatih_cabang = $request->input('pelatih');

        $data->update();
        Alert::success('Success', 'Data Cabang berhasil di perbarui');
        return redirect()->back()->with('success','Data Cabang Berhasil Di perbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $nomor_induk_cabang)
    {
        $data = Cabang::where('nomor_induk_cabang',$nomor_induk_cabang)->firstOrFail();

        $data->delete();
        Alert::success('Success', 'Data Cabang berhasil di hapus');
        return redirect()->back()->with('success','Data Cabang Berhasil Di hapus');
    }
}
