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
class PelatihController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tingkat = Tingkatan::where('kategori','siswa');
    $pelatihUsername = Auth::user()->username;

    $cabang = DB::select('SELECT * FROM table_cabang WHERE pelatih_cabang = ? LIMIT 1', [$pelatihUsername]);
    
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

    $lastanggota = Anggota::orderBy('nomor_induk', 'desc')->first();
    $lastKode = $lastanggota ? intval(substr($lastanggota->nomor_induk, 6)) : 0;
    $newKode = 'C11425' . str_pad($lastKode + 1, 5 - strlen($lastKode + 1), '0', STR_PAD_LEFT);
    
       

    
    return view('pages.pelatih.siswa', compact('siswa', 'tingkat', 'cabang','newKode'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function lihat(){
       
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
    public function insert(Request $request){
        
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
    public function update(Request $request, $nomor_induk)
{
    // Validasi input
    $request->validate([
        'nia' => 'required|integer',
        'nama_anggota' => 'required|string|max:255',
        'tempat_lahir' => 'required|string|max:255',
        'tgl_anggota' => 'nullable|date',
        'alamat' => 'required|string|max:255',
        'wa' => 'required|string|max:25',
        'tingkatan' => 'required|string|max:50',
        'tgl_ijazah' => 'nullable|date',
        'foto' => 'nullable|file|mimes:jpeg,png,jpg|max:10240',
        'cabang' => 'required|string|max:50',
        'prestasi' => 'nullable|string|max:255',
        'pengalaman' => 'nullable|string|max:255'
    ]);

    // Cari anggota yang akan diupdate
    $anggota = Anggota::where('nomor_induk', $nomor_induk)->firstOrFail();
    
    // Jika ada file foto yang diupload, simpan file tersebut
    if ($request->hasFile('foto')) {
        $fileName = Str::uuid() . '.' . $request->file('foto')->getClientOriginalExtension();
        $fotoPath = $request->file('foto')->storeAs('public', $fileName);
        $anggota->foto = Storage::url($fotoPath);
    }

    // Update data anggota
    $anggota->nomor_induk = $request->input('nia');
    $anggota->nama_anggota = $request->input('nama_anggota');
    $anggota->tempat_lahir = $request->input('tempat_lahir');
    $anggota->tanggal_lahir = $request->input('tgl_anggota');
    $anggota->alamat = $request->input('alamat');
    $anggota->telepon_wa = $request->input('wa');
    $anggota->kode_angkatan = $request->input('tingkatan');
    $anggota->tangga_ijazah_tingkatan = $request->input('tgl_ijazah');
    $anggota->prestasi_yang_diraih = $request->input('prestasi');
    $anggota->pengalaman_organisasi_tapak_suci = $request->input('pengalaman');
    $anggota->kode_cabang = $request->input('cabang');
    $anggota->update();

    // Update tingkatan di tabel UKT
    $ukt = Ukt::where('nomor_induk', $nomor_induk)->first();
    if ($ukt) {
        $ukt->tingkatan_saat_ini = $request->input('tingkatan');
        $ukt->save();
    }

    Alert::success('Success', 'Data anggota berhasil diperbarui');
    return redirect()->back()->with('success', 'Data Keanggotaan berhasil diperbarui');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
