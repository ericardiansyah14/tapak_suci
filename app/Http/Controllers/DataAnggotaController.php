<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Cabang;
use App\Models\Tingkatan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DataAnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cabang = Cabang::all();
        $tingkat = Tingkatan::all();
        $anggota = Anggota::with(['cabang', 'tingkatan'])->get();
        return view('pages.admin.data_anggota',compact('cabang','tingkat','anggota'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
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
            'tgl_ijazah' => 'required|date',
            'foto' => 'required|file|mimes:jpeg,png,jpg|max:10240',
            'cabang' => 'required|string|max:50',
            'prestasi' => 'nullable|string|max:255',
            'pengalaman' => 'nullable|string|max:255'
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
                'tangga_ijazah_tingkatan' => $request->tgl_ijazah,
                'prestasi_yang_diraih' => $request->prestasi,
                'photo' => $publicurl,
                'pengalaman_organisasi_tapak_suci' => $request->pengalaman,
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
    public function update(Request $request, string $nomor_induk)
    {
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
    
        $anggota = Anggota::where('nomor_induk', $nomor_induk)->firstOrFail();
    
        if ($request->hasFile('foto')) {
            $fileName = Str::uuid() . '.' . $request->file('foto')->getClientOriginalExtension();
            $fotoPath = $request->file('foto')->storeAs('public', $fileName);
            $anggota->foto = Storage::url($fotoPath);
        }
    
        $anggota->nomor_induk = $request->input('nia');
        $anggota->nama_anggota = $request->input('nama_anggota');
        $anggota->tempat_lahir = $request->input('tempat_lahir');
        $anggota->tanggal_lahir = $request->input('tgl_anggota'); // Revisi ini
        $anggota->alamat = $request->input('alamat');
        $anggota->telepon_wa = $request->input('wa');
        $anggota->kode_angkatan = $request->input('tingkatan');
        $anggota->tangga_ijazah_tingkatan = $request->input('tgl_ijazah');
        $anggota->prestasi_yang_diraih = $request->input('prestasi');
        $anggota->pengalaman_organisasi_tapak_suci = $request->input('pengalaman');
        $anggota->kode_cabang = $request->input('cabang');
        $anggota->update();
    
        Alert::success('Success', 'Data anggota berhasil diperbarui');
        return redirect()->back()->with('success', 'Data Keanggotaan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $nomor_induk)
    {
        $data = Anggota::where('nomor_induk',$nomor_induk)->firstOrFail();

        $data->delete();
        Alert::success('Success', 'Data Anggota berhasil di hapus');
        return redirect()->back()->with('success','Data Anggota Berhasil Di hapus');
    }
}
