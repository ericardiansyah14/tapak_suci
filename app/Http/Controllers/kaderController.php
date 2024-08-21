<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Cabang;
use App\Models\Kaderisasi;
use App\Models\Tingkatan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class kaderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil data kaderisasi beserta relasi cabang dan tingkatan
        $kaderisasi = Kaderisasi::all();
        $anggota = Anggota::all();
        return view('pages.admin.kader', compact('kaderisasi', 'anggota'));
    }
    

public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'nama_anggota' => 'required|exists:table_anggota,id',
        'tanggal' => 'required|date',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Temukan anggota berdasarkan ID
    $anggota = Anggota::find($request->input('nama_anggota'));

    // Siapkan data untuk disimpan
    $data = [
        'nama_anggota' => $anggota->nama_anggota,
        'kode_cabang' => $anggota->cabang->nama_cabang ?? null, 
        'nomor_tingkatan' => $anggota->tingkatan->nama_tingkatan ?? null, 
        'tanggal_ijazah' => $request->input('tanggal'),
    ];

    // Proses upload foto jika ada
    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('public', $fileName); // Simpan di folder 'public/foto'
        $publicUrl = Storage::url($path); // Mendapatkan URL publik

        $data['foto_ijazah'] = $publicUrl; // Simpan nama file di database
    }

    // Simpan data ke dalam tabel kaderisasi
    Kaderisasi::create($data);

    // Redirect dengan pesan sukses
    Alert::success('berhasil','Data kaderisasi berhasil disimpan');
    return redirect()->back()->with('success', 'Data kaderisasi berhasil disimpan.');
}


    /**
     * Store a newly created resource in storage.
     */
  

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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
