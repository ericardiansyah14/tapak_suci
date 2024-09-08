<?php

namespace App\Http\Controllers;

use App\Models\Ukt;
use App\Models\UktModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class uktPimdaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $panitia = User::where('role','pelatih')->get();
        $uktCounts = DB::table('ukt_pimda')
        ->leftJoin('ukt', 'ukt_pimda.id', '=', 'ukt.ukt_pimda_id')
        ->leftJoin('table_tingkatan as t1', 'ukt.tingkatan_saat_ini', '=', 't1.nomor_tingkatan') // Join untuk tingkatan saat ini
        ->leftJoin('table_tingkatan as t2', 'ukt.tingkatan_selanjutnya', '=', 't2.nomor_tingkatan') // Join untuk tingkat selanjutnya
        ->select(
            'ukt_pimda.id',
            'ukt_pimda.lokasi_ukt',
            'ukt_pimda.alamat_ukt',
            'ukt_pimda.tanggal_ukt',
            'ukt_pimda.ketua_panitia',
            DB::raw('COUNT(ukt.ukt_pimda_id) as jumlah_data'),
            't1.nama_tingkatan as tingkatan_saat_ini', // Ambil nama tingkatan saat ini
            't2.nama_tingkatan as tingkat_selanjutnya' // Ambil nama tingkat selanjutnya
        )
        ->groupBy(
            'ukt_pimda.id',
            'ukt_pimda.lokasi_ukt', 
            'ukt_pimda.alamat_ukt', 
            'ukt_pimda.tanggal_ukt',
            'ukt_pimda.ketua_panitia',
            't1.nama_tingkatan',
            't2.nama_tingkatan'
        )
        ->get();
        
        foreach ($uktCounts as $uktCount) {
            $uktCount->ukts = Ukt::where('ukt_pimda_id', $uktCount->id)
                ->with('tingkatanSaatIni', 'tingkatanSelanjutnya') 
                ->get();
        }
        return view('pages.admin.ukt_pimda', compact('panitia', 'uktCounts'));
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
        UktModel::create([
            'id' => $request->id,
            'lokasi_ukt' => $request->lokasi,
            'alamat_ukt' => $request->alamat,
            'tanggal_ukt' => $request->tanggal,
            'ketua_panitia' => $request->panitia,
        ]);
        Alert::success('Berhasil','Data ukt berhasil disimpan');
        return redirect()->back()->with('success','data ukt berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        
    }
    public function Peserta()
    {
        $uktCounts = DB::table('ukt_pimda')
        ->leftJoin('ukt', 'ukt_pimda.id', '=', 'ukt.ukt_pimda_id')
        ->leftJoin('tingkatan as t1', 'ukt.tingkatan_saat_ini', '=', 't1.kode_angkatan') // Join untuk tingkatan saat ini
        ->leftJoin('tingkatan as t2', 't1.tingkat_selanjutnya', '=', 't2.kode_angkatan') // Join untuk tingkat selanjutnya
        ->select(
            'ukt_pimda.id',
            'ukt_pimda.lokasi_ukt',
            'ukt_pimda.tanggal_ukt',
            'ukt_pimda.ketua_panitia',
            DB::raw('COUNT(ukt.ukt_pimda_id) as jumlah_data'),
            't1.nama_tingkatan as tingkatan_saat_ini', // Ambil nama tingkatan saat ini
            't2.nama_tingkatan as tingkat_selanjutnya' // Ambil nama tingkat selanjutnya
        )
        ->groupBy(
            'ukt_pimda.id',
            'ukt_pimda.lokasi_ukt',
            'ukt_pimda.tanggal_ukt',
            'ukt_pimda.ketua_panitia',
            't1.nama_tingkatan',
            't2.nama_tingkatan'
        )
        ->get();
    
        return view('pages.admin.show',compact('uktCounts'));
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
        $data = UktModel::where('id',$id)->firstOrFail();
        if ($request->input('panitia') !== null) {
            $data->ketua_panitia = $request->input('panitia');
        }
        $data->lokasi_ukt = $request->input('lokasi');
        $data->alamat_ukt = $request->input('alamat');
        $data->tanggal_ukt = $request->input('tanggal');

        $data->update();
        Alert::success('Berhasil','Data ukt berhasil diperbarui');
        return redirect()->back()->with('success','Data ukt berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ukt = UktModel::where('id',$id)->firstOrFail();
        $ukt->delete();
        Alert::success('Berhasil','Data Ukt berhasil di hapus');
        return redirect()->back()->with('success','Data Ukt Berhasil di haous');
    }
}
