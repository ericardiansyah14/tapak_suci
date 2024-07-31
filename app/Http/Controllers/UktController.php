<?php

namespace App\Http\Controllers;

use App\Models\Ukt;
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
    $ukts = DB::table('ukt')
        ->select(
            'ukt.*',
            DB::raw('(SELECT nama_tingkatan FROM table_tingkatan WHERE nomor_tingkatan = ukt.tingkatan_saat_ini) as nama_tingkatan_saat_ini'),
            DB::raw('(SELECT nama_tingkatan FROM table_tingkatan WHERE nomor_tingkatan = ukt.tingkatan_selanjutnya) as nama_tingkatan_selanjutnya')
        )
        ->where('pelatih', Auth::user()->name)
        ->get();

    return view('pages.pelatih.ukt', compact('ukts'));
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
        $nomor_induk = $request->input('nic');
        

        $exit = Ukt::where('nomor_induk', $nomor_induk)->exists();

        if($exit){
            Alert::error('Error','Nomor induk sudah terdaftar di ukt');
            return redirect()->back()->with('error','Nomor induk sudah terdaftar ukt');
        }
        $ukt = new Ukt();
        $ukt->nomor_induk = $nomor_induk;
        $ukt->nama_siswa = $request->input('nama_siswa');
        $ukt->tingkatan_saat_ini = $request->input('saat_ini');
        $ukt->tingkatan_selanjutnya = $request->input('selanjutnya');
        $ukt->pelatih = Auth::user()->username;

        $ukt->save();

        Alert::success('Berhasil','Berhasil mendaftarkan siswa ukt');
        return redirect()->back()->with('success','Berhasil Mendaftarkan siswa ukt');
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
