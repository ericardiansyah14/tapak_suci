<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Tingkatan;
use App\Models\Ukt;
use App\Models\UktModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class UktController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
     public function index()
{
    $uktpimda = UktModel::all();
    $tingkat = Tingkatan::all();
    $pelatihUsername = Auth::user()->username;

    // Ambil semua siswa
    $siswa = Anggota::join('table_cabang', 'table_anggota.kode_cabang', '=', 'table_cabang.nomor_induk_cabang')
    ->join('users', 'table_cabang.pelatih_cabang', '=', 'users.username')
    ->leftJoin('ukt', 'table_anggota.nomor_induk', '=', 'ukt.nomor_induk') 
    ->leftJoin('table_tingkatan', 'table_anggota.kode_angkatan', '=', 'table_tingkatan.nomor_tingkatan') 
    ->whereNotNull('table_anggota.kode_cabang')
    ->where('table_cabang.pelatih_cabang', '=', Auth::user()->username)
    ->select(
        'table_anggota.*',
        'ukt.nomor_induk as ukt_nic',
        'ukt.tingkatan_selanjutnya', 
        'table_tingkatan.nomor_tingkatan as tingkat_saat_ini'
    )
    ->distinct() // Menambahkan distinct untuk menghindari duplikat
    ->get();


    // Ambil data siswa yang sudah terdaftar di UKT lain
    $uktSiswa = [];
    foreach ($uktpimda as $item) {
        $uktSiswa[$item->id] = Ukt::where('ukt_pimda_id', $item->id)
            ->pluck('nomor_induk')
            ->toArray();
    }

    return view('pages.pelatih.ukt', compact('uktpimda', 'siswa', 'tingkat', 'uktSiswa'));
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
             'ukt_pimda_id' => 'required|exists:ukt_pimda,id',
             'siswa_ids' => 'required|array',
             'siswa_ids.*' => 'exists:table_anggota,id',
             'tingkat' => 'required|exists:table_tingkatan,nomor_tingkatan',
         ]);
     
         $uktPimdaId = $request->input('ukt_pimda_id');
         $siswaIds = $request->input('siswa_ids');
         $tingkat = $request->input('tingkat');
     
         // Ambil daftar siswa yang ingin didaftarkan
         $siswaList = Anggota::whereIn('id', $siswaIds)->get();
     
         // Ambil nomor induk siswa yang sudah terdaftar di UKT ini
         $existingSiswaIds = Ukt::where('ukt_pimda_id', $uktPimdaId)
             ->where('tingkatan_selanjutnya', $tingkat)
             ->pluck('nomor_induk')
             ->toArray();
     
         // Daftar siswa yang sudah terdaftar
         $alreadyRegisteredSiswaIds = [];
         // Daftar siswa baru yang akan didaftarkan
         $newSiswa = [];
     
         foreach ($siswaList as $siswaItem) {
             if (in_array($siswaItem->nomor_induk, $existingSiswaIds)) {
                 $alreadyRegisteredSiswaIds[] = $siswaItem->id;
             } else {
                 $newSiswa[] = [
                     'nomor_induk' => $siswaItem->nomor_induk,
                     'nama_siswa' => $siswaItem->nama_anggota,
                     'tingkatan_saat_ini' => $siswaItem->kode_angkatan, 
                     'tingkatan_selanjutnya' => $tingkat,
                     'ukt_pimda_id' => $uktPimdaId, 
                 ];
             }
         }
     
         // Insert siswa baru ke dalam UKT
         if (!empty($newSiswa)) {
             Ukt::insert($newSiswa);
         }
     
         if (!empty($alreadyRegisteredSiswaIds)) {
             Alert::success('berhasil', 'Data terbaru sudah terdaftar');
             return redirect()->back()->with('warning', 'Data sudah terdaftar untuk siswa dengan ID: ' . implode(', ', $alreadyRegisteredSiswaIds));
         }
     
         Alert::success('Berhasil', 'Data berhasil disimpan!');
         return redirect()->back()->with('success', 'Data berhasil disimpan!');
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
        $ukt = Ukt::where('id',$id)->firstOrFail();
        $ukt->delete();
        Alert::success('Berhasil','Ukt siswa ' .$ukt->nama_siswa. ' berhasil dibatalkan');
        return redirect()->back()->with('success','Ukt siswa ini berhasil dibatalkan');
    }
}
