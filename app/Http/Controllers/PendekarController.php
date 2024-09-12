<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Pendekar;
use App\Models\Cabang; // Impor model Cabang
use App\Models\Tingkatan; // Pastikan untuk mengimpor Tingkatan jika Anda menggunakannya
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class PendekarController extends Controller
{
    /**
     * Menampilkan daftar sumber daya.
     */
    public function index(Request $request)
    {
        $cabang = Cabang::all();
        $kategori = $request->input('kategori');
        $tingkat1 = Tingkatan::whereNot('kategori', 'siswa')->get();
        $tingkat = Tingkatan::where('kategori', 'pendekar')->get();
    
        $anggota = Anggota::with('tingkatan')
        ->when($kategori, function ($query, $kategori) {
            return $query->whereHas('tingkatan', function ($query) use ($kategori) {
                $query->where('kategori', $kategori);
            });
        }, function ($query) {
            // Kondisi ketika tidak ada filter kategori
            return $query->whereHas('tingkatan', function ($query) {
                $query->where('kategori', '=', 'pendekar');
            });
        })
        ->get();
    
        $lastanggota = Anggota::orderBy('nomor_induk', 'desc')->first();
        $lastKode = $lastanggota ? intval(substr($lastanggota->nomor_induk, 6)) : 0;
        $newKode = '11425' . str_pad($lastKode + 1, 5 - strlen($lastKode + 1), '0', STR_PAD_LEFT);
    
        return view('pages.admin.pendekar', compact('cabang', 'tingkat', 'anggota', 'tingkat1', 'newKode'));
    }

    /**
     * Menampilkan formulir untuk membuat sumber daya baru.
     */
    public function create()
    {
        //
    }

    /**
     * Menyimpan sumber daya yang baru dibuat ke dalam penyimpanan.
     */
    public function store(Request $request)
    {
         $request->validate([
            'nia' => 'required|integer',
            'nama_anggota' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tgl_anggota' => 'required|date',
            'alamat' => 'required|string|max:255',
            'wa' => 'required|string|max:15',
            'tingkatan' => 'required|string|max:50',
        ]);
    
        // try {
        //     // // Upload foto
        //     // $fileName = Str::uuid() . '.' . $request->file('foto')->getClientOriginalExtension();
        //     // $path = $request->file('foto')->storeAs('public', $fileName);
        //     // $publicurl = Storage::url($path);
    
            Anggota::create([
                'id' => $request->id,
                'nomor_induk' => $request->nia,
                'nama_anggota' => $request->nama_anggota,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tgl_anggota,
                'alamat' => $request->alamat,
                'telepon_wa' => $request->wa,
                'kode_angkatan' => $request->tingkatan,
            ]);
    
            Alert::success('Success', 'Data anggota berhasil ditambahkan');
            return redirect()->back()->with('success', 'Data Keanggotaan berhasil ditambahkan');
    
    }

    /**
     * Menampilkan sumber daya yang ditentukan.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Menampilkan formulir untuk mengedit sumber daya yang ditentukan.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Memperbarui sumber daya yang ditentukan di penyimpanan.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Menghapus sumber daya yang ditentukan dari penyimpanan.
     */
    public function destroy(string $id)
    {
        $pendekar = Pendekar::where('id', $id)->firstOrFail();
        $pendekar->delete();
        Alert::success('Berhasil', 'Data pendekar berhasil dihapus');
        return redirect()->back()->with('success', 'Data pendekar berhasil dihapus');
    }
}
