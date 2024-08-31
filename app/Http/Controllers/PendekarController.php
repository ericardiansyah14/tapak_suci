<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Pendekar;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class PendekarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $anggotasel = null;
        if ($request->has('nama_anggota')) {
            $anggotasel = Anggota::find($request->input('nama_anggota'));
        }
            $kaderisasi = Pendekar::all();
            $anggota = Anggota::with('tingkatan')
        ->whereHas('tingkatan', function ($query) {
            $query->where('kategori', 'pendekar');
        })
        ->get();
    
            return view('pages.admin.pendekar', compact('kaderisasi', 'anggota','anggotasel'));
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
        $request->validate([
            'nama_anggota' => 'required|exists:table_anggota,id',
            'tingkatan' => 'required',
            'tanggal' => 'required|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        // Temukan anggota berdasarkan ID
        $anggota = Anggota::find($request->input('nama_anggota'));
    
        // Siapkan data untuk disimpan
        $data = [
            'nama_anggota' => $anggota->nama_anggota,
            'kode_cabang' => $anggota->cabang->nama_cabang ?? null, 
            'nomor_tingkatan' => $request->input('tingkatan'),
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
        Pendekar::create($data);
    
        // Redirect dengan pesan sukses
        Alert::success('berhasil','Data kaderisasi berhasil disimpan');
        return redirect()->back()->with('success', 'Data kaderisasi berhasil disimpan.');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pendekar = Pendekar::where('id',$id)->firstOrFail();
        $pendekar->delete();
        Alert::success('Berhasil','Data pendekar berhasil dihapus');
        return redirect()->back()->with('success','Data pendekar berhasil dihapus');
    }
}
