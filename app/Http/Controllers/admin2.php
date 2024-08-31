<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use Illuminate\Support\Facades\Storage;
use App\Models\Cabang;
use App\Models\Siswa;
use App\Models\Tingkatan;
use App\Models\Ukt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class admin2 extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tingkat = Tingkatan::where('kategori','siswa')->get();
        $cabang = Cabang::all();
        $pelatihUsername = Auth::user()->username;
        $userRole = Auth::user()->role; // Asumsi role ada di field `role` pada tabel `users`

// Cek apakah pengguna yang login adalah admin
if ($userRole == 'admin') {
    // Jika admin, tampilkan semua data
    $siswa = Anggota::join('table_cabang', 'table_anggota.kode_cabang', '=', 'table_cabang.nomor_induk_cabang')
        ->leftJoin('ukt', 'table_anggota.nomor_induk', '=', 'ukt.nomor_induk') 
        ->leftJoin('table_tingkatan', 'table_anggota.kode_angkatan', '=', 'table_tingkatan.nomor_tingkatan') 
        ->select(
            'table_anggota.*',
            'ukt.nomor_induk as ukt_nic',
            'ukt.tingkatan_selanjutnya', 
            'table_tingkatan.nomor_tingkatan as tingkat_saat_ini'
        )
        ->distinct() // Menghindari duplikat
        ->get();
} else {
    // Jika pelatih, tampilkan hanya data yang sesuai dengan pelatih yang login
    $siswa = Anggota::join('table_cabang', 'table_anggota.kode_cabang', '=', 'table_cabang.nomor_induk_cabang')
        ->join('users', 'table_cabang.pelatih_cabang', '=', 'users.username')
        ->leftJoin('ukt', 'table_anggota.nomor_induk', '=', 'ukt.nomor_induk') 
        ->leftJoin('table_tingkatan', 'table_anggota.kode_angkatan', '=', 'table_tingkatan.nomor_tingkatan') 
        ->whereNotNull('table_anggota.kode_cabang')
        ->where('table_cabang.pelatih_cabang', '=', $pelatihUsername)
        ->select(
            'table_anggota.*',
            'ukt.nomor_induk as ukt_nic',
            'ukt.tingkatan_selanjutnya', 
            'table_tingkatan.nomor_tingkatan as tingkat_saat_ini'
        )
        ->distinct() // Menghindari duplikat
        ->get();

}
$lastanggota = Anggota::orderBy('nomor_induk', 'desc')->first();
$lastKode = $lastanggota ? intval(substr($lastanggota->nomor_induk, 6)) : 0;
$newKode = 'C11425' . str_pad($lastKode + 1, 5 - strlen($lastKode + 1), '0', STR_PAD_LEFT);
return view('pages.admin.insert_siswa',compact('tingkat','cabang','siswa','newKode'));
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
            'nia' => 'required|string|max:11',
            'nama_anggota' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tgl_anggota' => 'required|date',
            'alamat' => 'required|string|max:255',
            'wa' => 'required|string|max:15',
            'tingkatan' => 'required|string|max:50',
            'foto' => 'required|file|mimes:jpeg,png,jpg|max:10240',
            'cabang' => 'required|string|max:50',
        ]);
    
        try {
            // Upload foto
            $fileName = Str::uuid() . '.' . $request->file('foto')->getClientOriginalExtension();
            $path = $request->file('foto')->storeAs('public', $fileName);
            $publicurl = Storage::url($path);
    
            Anggota::create([
                'id' => $request->id,
                'nomor_induk' => $request->nia,
                'nama_anggota' => $request->nama_anggota,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tgl_anggota,
                'alamat' => $request->alamat,
                'telepon_wa' => $request->wa,
                'kode_angkatan' => $request->tingkatan,
                'photo' => $publicurl,
                'kode_cabang' => $request->cabang,

            ]);
    
            Alert::success('Success', 'Data anggota berhasil ditambahkan');
            return redirect()->back()->with('success', 'Data Keanggotaan berhasil ditambahkan');
    
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: '.$e->getMessage());
        }
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
        //
    }
}
