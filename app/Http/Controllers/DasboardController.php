<?php

namespace App\Http\Controllers;

    use App\Models\Cabang;
    use App\Models\Anggota;
    use App\Models\Tingkatan;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;

    use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;

class DasboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
    
        $tingkatanCounts = Anggota::join('table_tingkatan', 'table_anggota.kode_angkatan', '=', 'table_tingkatan.nomor_tingkatan')
            ->select('table_tingkatan.kategori as tingkatan', DB::raw('count(*) as total'))
            ->groupBy('table_tingkatan.kategori')
            ->get();
        $labels = $tingkatanCounts->pluck('tingkatan')->toArray();
        $data = $tingkatanCounts->pluck('total')->toArray();
        $colors = [];
        foreach ($labels as $label) {
            if ($label == 'siswa') {
                $colors[] = '#3498db';
            } elseif ($label == 'pendekar') {
                $colors[] = '#e74c3c'; 
            } elseif ($label == 'kader') {
                $colors[] = '#f1c40f'; 
            } else {
                $colors[] = '#95a5a6'; 
            }
        }
        $chartAnggota = LarapexChart::pieChart()
        ->setTitle('Jumlah Anggota Berdasarkan Tingkatan')
        ->addData($data)
        ->setLabels($labels)
        ->setColors($colors); 
        function generateRandomColor() {
            return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        }

        $cabangs = Cabang::all();

        $cabangCounts = Anggota::join('table_cabang', 'table_anggota.kode_cabang', '=', 'table_cabang.nomor_induk_cabang')
            ->select('table_cabang.nomor_induk_cabang', 'table_cabang.nama_cabang as cabang', DB::raw('count(*) as total'))
            ->groupBy('table_cabang.nomor_induk_cabang', 'table_cabang.nama_cabang')
            ->get();

        $labels = [];
        $data = [];
        $colors = [];

        foreach ($cabangs as $cabang) {
            $labels[] = $cabang->nama_cabang;

            $count = $cabangCounts->firstWhere('nomor_induk_cabang', $cabang->nomor_induk_cabang);
            $data[] = $count ? $count->total : 0;

            $colors[] = generateRandomColor();
        }

       
        $chartCabang = LarapexChart::barChart()
            ->setTitle('Jumlah Anggota per Cabang')
            ->addData('Jumlah Anggota', $data)
            ->setXAxis($labels)
            ->setColors($colors); 
            
        
        return view('pages.dashboard', compact('chartAnggota','chartCabang'));
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
        //
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
